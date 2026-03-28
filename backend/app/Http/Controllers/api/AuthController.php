<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiRefreshToken;
use App\Models\SecurityEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
            'role' => ['required', 'in:donor,recipient,hospital'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_donor' => $data['role'] === 'donor',
            'is_recipient' => $data['role'] === 'recipient',
        ]);

        return response()->json($this->issueTokens($user), 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            SecurityEvent::create([
                'user_id' => $user?->id,
                'event_type' => 'LOGIN_FAILED',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'details' => ['email' => $data['email']],
            ]);
            return response()->json(['detail' => 'Invalid credentials'], 401);
        }

        SecurityEvent::create([
            'user_id' => $user->id,
            'event_type' => 'LOGIN_SUCCESS',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'details' => [],
        ]);

        return response()->json($this->issueTokens($user));
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($request->filled('refresh_token')) {
            $hash = ApiRefreshToken::hashToken($request->refresh_token);
            ApiRefreshToken::where('user_id', $user->id)
                ->where('token', $hash)
                ->update(['revoked_at' => now()]);
        } else {
            ApiRefreshToken::where('user_id', $user->id)->update(['revoked_at' => now()]);
        }

        $user->tokens()->delete();
        return response()->json(['detail' => 'Logged out']);
    }

    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => ['required', 'string'],
        ]);

        $hash = ApiRefreshToken::hashToken($request->refresh_token);
        $refreshToken = ApiRefreshToken::where('token', $hash)->first();

        if (!$refreshToken || !$refreshToken->isActive()) {
            return response()->json(['detail' => 'Invalid or expired refresh token'], 401);
        }

        $user = $refreshToken->user;
        $refreshToken->revoked_at = now();
        $refreshToken->save();

        return response()->json($this->issueTokens($user));
    }

    private function issueTokens(User $user): array
    {
        $accessToken = $user->createToken('api')->plainTextToken;
        $refreshToken = ApiRefreshToken::generateToken();
        $expiresAt = now()->addDays(30);

        ApiRefreshToken::create([
            'user_id' => $user->id,
            'token' => ApiRefreshToken::hashToken($refreshToken),
            'expires_at' => $expiresAt,
        ]);

        return [
            'access' => $accessToken,
            'access_token' => $accessToken,
            'refresh' => $refreshToken,
            'refresh_token' => $refreshToken,
            'refresh_expires_at' => $expiresAt->toISOString(),
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
