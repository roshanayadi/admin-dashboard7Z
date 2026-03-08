# DAS Agriculture - Admin Dashboard

A scalable Laravel admin panel for Dynamic Agriculture System (DAS).

## Features

- **Dashboard** — Real-time stats, activity feed, charts
- **Blog Management** — CRUD with rich editor, categories, comments moderation
- **Gallery Management** — Image/video upload with categories
- **User Management** — Members CRUD with status tracking
- **Contact Messages** — View and manage contact form submissions
- **Feedback** — View ratings and approve/reject feedback
- **SMS & Email** — Send bulk/individual SMS and emails
- **Notifications** — System notification center
- **Settings** — SMTP, SMS API, and general settings
- **Activity Log** — Track all admin actions
- **Role-based Access** — Admin and Editor roles

## Requirements

- PHP >= 8.1
- Composer
- MySQL / MariaDB
- Node.js & NPM (for frontend assets)

## Installation

```bash
# 1. Install dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate app key
php artisan key:generate

# 4. Configure database in .env
# DB_DATABASE=dasorgnp_das_agriculture
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Run migrations
php artisan migrate

# 6. Seed default admin
php artisan db:seed --class=AdminSeeder

# 7. Start the server
php artisan serve
```

## Default Admin Login

- **Username:** admin
- **Password:** password

## Project Structure

```
app/
├── Http/Controllers/Admin/   # All admin controllers
├── Http/Middleware/           # Auth middleware
├── Http/Requests/            # Form validation
├── Models/                   # Eloquent models
├── Services/                 # SMS, Email services
config/                       # App configuration
database/migrations/          # Database migrations
database/seeders/             # Data seeders
resources/views/              # Blade templates
routes/web.php                # All routes
public/                       # Public assets
```

## License

MIT
