<?php

namespace App\Http\Controllers;

use App\Models\TwoFactorAuth;
use App\Models\SecurityEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class SecurityController extends Controller
{
    public function dashboard(Request $request)
    {
        $twoFactor = TwoFactorAuth::firstOrNew(['user_id' => $request->user()->id]);
        $recentEvents = SecurityEvent::where('user_id', $request->user()->id)
            ->latest()
            ->take(10)
            ->get();

        return view('pages.security', [
            'twoFactor' => $twoFactor,
            'recentEvents' => $recentEvents,
        ]);
    }

    public function setup(Request $request)
    {
        $google2fa = new Google2FA();
        $twoFactor = TwoFactorAuth::firstOrNew(['user_id' => $request->user()->id]);

        if (!$twoFactor->secret_key) {
            $twoFactor->secret_key = $google2fa->generateSecretKey();
            $twoFactor->save();
        }

        $qrUrl = $google2fa->getQRCodeUrl(
            config('app.name', 'LifeLink'),
            $request->user()->email,
            $twoFactor->secret_key
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrSvg = $writer->writeString($qrUrl);

        return response()->json([
            'secret_key' => $twoFactor->secret_key,
            'qr_svg' => base64_encode($qrSvg),
            'is_enabled' => $twoFactor->is_enabled,
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $google2fa = new Google2FA();
        $twoFactor = TwoFactorAuth::where('user_id', $request->user()->id)->firstOrFail();

        if (!$google2fa->verifyKey($twoFactor->secret_key, $request->token)) {
            return redirect()->back()->with('error', 'Invalid token.');
        }

        $twoFactor->is_enabled = true;
        $twoFactor->backup_codes = $this->generateBackupCodes();
        $twoFactor->save();

        $this->logEvent($request, '2FA_ENABLED', ['method' => 'TOTP']);

        return redirect()->back()->with('status', 'Two-factor authentication enabled.');
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $twoFactor = TwoFactorAuth::where('user_id', $request->user()->id)->first();
        if ($twoFactor) {
            $twoFactor->is_enabled = false;
            $twoFactor->backup_codes = [];
            $twoFactor->save();
        }

        $this->logEvent($request, '2FA_DISABLED', ['method' => 'password']);

        return redirect()->back()->with('status', 'Two-factor authentication disabled.');
    }

    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => ['nullable', 'string'],
            'backup_code' => ['nullable', 'string'],
        ]);

        $twoFactor = TwoFactorAuth::where('user_id', $request->user()->id)->where('is_enabled', true)->first();
        if (!$twoFactor) {
            return response()->json(['error' => '2FA not enabled'], 400);
        }

        if ($request->token) {
            $google2fa = new Google2FA();
            if (!$google2fa->verifyKey($twoFactor->secret_key, $request->token)) {
                return response()->json(['error' => 'Invalid token'], 400);
            }
            $twoFactor->last_used = now();
            $twoFactor->save();
            return response()->json(['message' => 'Token verified']);
        }

        if ($request->backup_code) {
            $codes = $twoFactor->backup_codes ?? [];
            if (!in_array($request->backup_code, $codes, true)) {
                return response()->json(['error' => 'Invalid backup code'], 400);
            }
            $twoFactor->backup_codes = array_values(array_diff($codes, [$request->backup_code]));
            $twoFactor->save();

            $this->logEvent($request, '2FA_BACKUP_USED', ['code' => substr($request->backup_code, 0, 4) . '****']);

            return response()->json(['message' => 'Backup code verified']);
        }

        return response()->json(['error' => 'Token or backup code required'], 400);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        $strength = $this->checkPasswordStrength($request->new_password);
        if ($strength['score'] < 3) {
            return redirect()->back()->with('error', 'Password too weak.');
        }

        $user = $request->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        $this->logEvent($request, 'PASSWORD_CHANGE', ['strength' => $strength['score']]);

        return redirect()->back()->with('status', 'Password updated successfully.');
    }

    private function generateBackupCodes(): array
    {
        return collect(range(1, 10))
            ->map(fn () => strtoupper(Str::random(8)))
            ->values()
            ->all();
    }

    private function checkPasswordStrength(string $password): array
    {
        $requirements = [
            'length' => strlen($password) >= 8,
            'uppercase' => preg_match('/[A-Z]/', $password) === 1,
            'lowercase' => preg_match('/[a-z]/', $password) === 1,
            'digits' => preg_match('/\d/', $password) === 1,
            'special' => preg_match('/[^A-Za-z0-9]/', $password) === 1,
        ];

        $score = collect($requirements)->filter()->count();

        return ['score' => $score, 'requirements' => $requirements];
    }

    private function logEvent(Request $request, string $type, array $details = []): void
    {
        SecurityEvent::create([
            'user_id' => $request->user()->id,
            'event_type' => $type,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'details' => $details,
        ]);
    }
}
