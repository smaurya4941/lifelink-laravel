# LifeLink

AI-powered blood donation matching platform built with Laravel.

LifeLink connects **donors**, **recipients**, **hospitals**, and **admins** through role-based workflows, compatibility scoring, and location-aware discovery to reduce emergency response time.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Architecture](#architecture)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Configuration](#configuration)
- [Run the App](#run-the-app)
- [Testing](#testing)
- [API Overview](#api-overview)
- [Role-Based Web Routes](#role-based-web-routes)
- [Database Notes](#database-notes)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [License](#license)

## Features

- Role-based authentication and authorization (`donor`, `recipient`, `hospital`, `admin`)
- Recipient blood request workflow:
  - Create request
  - Generate ranked donor matches
  - Donor accept/reject
  - Recipient confirms donor
- Matching engine with weighted scoring:
  - Blood compatibility
  - Location proximity
  - Temporal compatibility
  - Health risk
  - Donor reliability
  - Urgency factor
- Location intelligence:
  - Nearby donor search
  - Nearby request search
  - Map dataset endpoints
- Notifications (user inbox + mark read/all read)
- Security module:
  - TOTP 2FA setup/enable/disable
  - Backup code verification
  - Security event logging
- Admin panel for users, requests, matches, donations, and notifications
- Hospital dashboard skeleton (ready for extension)

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade + Tailwind + Vite
- **Database:** MySQL
- **Auth (API):** Laravel Sanctum
- **Testing:** PHPUnit

## Architecture

```text
Laravel (Web + API + Service Layer)
        |
      MySQL
```

Current matching logic runs in the Laravel service layer (`MatchingService`).

## Project Structure

```text
backend/
  app/
    Http/Controllers/        # Web controllers
    Http/Controllers/api/    # API controllers
    Models/                  # Eloquent models
    Services/                # Matching + notification logic
  database/
    migrations/              # Schema + compatibility migrations
  resources/views/           # Blade templates
```

## Getting Started

1. Clone the repository

```bash
git clone <your-repo-url>
cd Lifelink/backend
```

2. Install dependencies

```bash
composer install
npm install
```

3. Prepare environment

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=lifelink_db
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations

```bash
php artisan migrate --force
```

## Configuration

Important `.env` keys:

- `APP_URL`
- `DB_*`
- `MAIL_*` (for email verification / password reset)
- `SESSION_DRIVER`, `CACHE_STORE`

## Run the App

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

Open: `http://127.0.0.1:8000`

## Testing

Run full suite:

```bash
php artisan test
```

Run specific tests:

```bash
php artisan test --filter=AuthenticationTest
php artisan test --filter=RegistrationTest
php artisan test --filter=ProfileTest
```

## API Overview

Base: `/api`

Public:

- `POST /register`
- `POST /login`
- `POST /token/refresh`
- `POST /password-reset`
- `POST /password-reset/confirm`

Authenticated (Sanctum):

- Dashboard/profile
  - `GET /dashboard`
  - `GET /profile`
  - `PATCH /profile`
- Donors/recipients
  - `GET/POST /donors`
  - `PATCH /donors/{donor}`
  - `GET/POST /recipients`
  - `PATCH /recipients/{recipient}`
- Blood requests
  - `GET/POST /blood-requests`
  - `GET/PATCH/DELETE /blood-requests/{bloodRequest}`
  - `POST /blood-requests/{bloodRequest}/find_matches`
  - `POST /blood-requests/{bloodRequest}/confirm_donor`
- Matches/donations
  - `GET /matches`
  - `POST /matches/{match}/accept`
  - `POST /matches/{match}/reject`
  - `GET/POST/PATCH/DELETE /donation-history`
- Location/map
  - `GET /nearby/donors`
  - `GET /nearby/requests`
  - `GET /map/data`
- Notifications/security
  - `GET /notifications`
  - `POST /notifications/{notification}/mark_read`
  - `POST /notifications/mark_all_read`
  - `GET /security/dashboard`
  - `GET /security/2fa/setup`
  - `POST /security/2fa/enable`
  - `POST /security/2fa/verify`
  - `POST /security/2fa/disable`
  - `POST /security/password`

## Role-Based Web Routes

- Donor
  - `/donor/profile`
  - `/donor/matches`
- Recipient
  - `/recipient/profile`
  - `/recipient/requests`
- Hospital
  - `/hospital/dashboard`
- Admin
  - `/admin`

## Database Notes

If you cloned from an older snapshot and get `Unknown column` SQL errors, run:

```bash
php artisan migrate --force
```

Recent compatibility migrations include:

- `2026_03_20_080500_sync_users_table_with_current_schema.php`
- `2026_03_20_082000_sync_donations_table_with_current_schema.php`
- `2026_03_20_093000_sync_recipient_profiles_table_with_current_schema.php`

## Roadmap

- Complete hospital request management flow (create/manage requests from hospital dashboard)
- Add hospital verification workflow for admins
- Add richer analytics and operational reporting
- Optional: external ML microservice integration for matching
- CI workflow for lint/test on pull requests

## Contributing

Contributions are welcome.

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a pull request

## License

MIT
