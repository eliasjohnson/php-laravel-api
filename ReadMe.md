# IT Ticket Management API

A Laravel-based API for managing IT support tickets with React frontend using Inertia.js.

## Quick Start

### Database Connection
```bash
# Connect to PostgreSQL database
psql -h 127.0.0.1 -U user -d aws_it_database

# Common PostgreSQL commands:
\dt                    # List all tables
\d tickets            # Describe tickets table structure
SELECT COUNT(*) FROM tickets;     # Count total tickets
SELECT * FROM tickets LIMIT 10;  # View first 10 tickets
\q                    # Quit PostgreSQL
```

### Development Setup
```bash
# Start development server (runs Laravel + React + Queue + Logs)
composer run dev

# Or individual services:
php artisan serve                 # Laravel server (port 8000)
php artisan queue:listen         # Background job processing
php artisan pail --timeout=0    # Real-time logs
npm run dev                      # Vite React frontend
```

## Database

**Current Status:** 10,000 IT tickets imported from CSV
- **Database:** PostgreSQL (`aws_it_database`)
- **Tables:** users, tickets, cache, jobs, sessions, password_reset_tokens
- **Main Data:** Tickets table with 37 columns (priority, status, agent, timestamps, etc.)

## Project Structure

```
my-api/
├── app/
│   ├── Http/Controllers/     # API controllers
│   ├── Models/              # Eloquent models
│   └── ...
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/            # Data seeders (TicketSeeder)
├── routes/
│   ├── api.php             # API routes
│   └── web.php             # Web routes
├── resources/
│   └── js/                 # React components
├── storage/
│   └── app/               # File storage (CSV imports)
└── .env                   # Environment configuration
```

## Key Files

- **Tickets Migration:** `database/migrations/2025_09_20_220907_create_tickets_table.php`
- **Ticket Seeder:** `database/seeders/TicketSeeder.php` (imports CSV data)
- **Environment:** `.env` (PostgreSQL connection settings)

## API Development

**Next Steps:**
1. Create Ticket model: `php artisan make:model Ticket`
2. Create API controller: `php artisan make:controller Api/TicketController`
3. Add API routes in `routes/api.php`

## Common Commands

```bash
# Database
php artisan migrate              # Run migrations
php artisan db:seed             # Run seeders
php artisan migrate:rollback    # Rollback last migration

# Development
php artisan make:model Ticket   # Create model
php artisan make:controller ApiController  # Create controller
php artisan route:list          # List all routes

# Testing
php artisan test               # Run tests
```

## Architecture

Think of it like a restaurant:
- **Laravel:** The kitchen (API logic, database operations)
- **React/Inertia:** The dining room (user interface)
- **PostgreSQL:** The pantry (ticket data storage)
- **API Routes:** The waiters (data flow between frontend/backend)
