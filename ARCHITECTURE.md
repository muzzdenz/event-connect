# Frontend Architecture Documentation

## Overview

This is a **frontend-only Laravel application** that renders user interfaces and calls a separate backend API for all business logic and data operations.

## Architecture Principles

### What This Frontend DOES:
- ✅ Renders Blade templates (views) for user interface
- ✅ Handles user authentication sessions (login/logout state)
- ✅ Makes HTTP requests to backend API via `BackendApiService`
- ✅ Displays data received from backend API
- ✅ Validates user input (client-side, UX-focused)
- ✅ Manages file-based sessions and cache

### What This Frontend DOES NOT DO:
- ❌ Connect to application database directly
- ❌ Implement business logic or calculations
- ❌ Define database schema (no migrations)
- ❌ Seed data (no seeders)
- ❌ Run background jobs or queues
- ❌ Process payments or sensitive operations
- ❌ Define API endpoints (routes/api.php is empty)

## Key Components

### 1. BackendApiService (`app/Services/BackendApiService.php`)

**Purpose**: HTTP client wrapper for communicating with the backend API.

**Usage Example**:
```php
use App\Services\BackendApiService;

class EventController extends Controller
{
    protected BackendApiService $api;

    public function __construct(BackendApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $events = $this->api->get('events');
        return view('events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $event = $this->api->post('events', $request->validated());
        return redirect()->route('events.show', $event['id']);
    }
}
```

**Configuration**:
```env
API_BASE_URL=https://staging-eventconnect.sre-telkomuniversity-pwt.org/api
API_TIMEOUT=10
```

### 2. Web Controllers (`app/Http/Controllers/`)

**Purpose**: Render views and orchestrate user interactions.

**Pattern**:
- Receive user request
- Call `BackendApiService` to fetch/send data
- Pass data to Blade views
- Return rendered HTML

**Example Controllers**:
- `AuthController.php` - Login/register pages
- `ParticipantDashboardController.php` - Participant dashboard
- `ParticipantEventController.php` - Event browsing
- `AdminDashboardController.php` - Admin panel

### 3. Views (`resources/views/`)

**Purpose**: Blade templates for UI.

**Structure**:
```
resources/views/
├── auth/               # Login, register, password reset
├── participant/        # Participant dashboard and features
│   ├── dashboard.blade.php
│   ├── events/
│   └── notifications/
├── admin/              # Admin dashboard
├── errors/             # Error pages (404, 502, etc)
└── layouts/            # Layout templates
```

### 4. Routes (`routes/web.php`)

**Purpose**: Define frontend routes (NOT API routes).

**Pattern**:
- Public routes: `/`, `/events`, `/login`, `/register`
- Protected routes: `/participant/*`, `/admin/*`
- All routes render views, NO direct JSON responses

### 5. Session Management

**Configuration**:
```env
SESSION_DRIVER=file        # File-based sessions (no database)
SESSION_LIFETIME=120       # 2 hours
CACHE_STORE=file           # File-based cache (no database)
```

**Authentication State**:
- User login state stored in session
- JWT token (from backend) stored in session
- `BackendApiService` automatically includes token in API calls

## Configuration Files

### Required `.env` Variables:
```env
# App basics
APP_NAME=EventConnect
APP_ENV=local
APP_URL=http://localhost:8000

# Backend API (CRITICAL)
API_BASE_URL=https://staging-eventconnect.sre-telkomuniversity-pwt.org/api
VITE_API_BASE_URL=https://staging-eventconnect.sre-telkomuniversity-pwt.org/api

# Sessions & Cache (File-based, no database needed)
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### Optional `.env` Variables:
```env
# Only if you need database for FinanceController/AttendanceController
# (will be removed after refactoring)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_connect
```

## Recent Cleanup (December 2024)

### Files Removed:
1. **API Controllers** (9 files, ~2,800 lines):
   - `app/Http/Controllers/Api/*`
   - Reason: Backend logic should be in backend API

2. **Eloquent Models** (4 files):
   - `app/Models/Category.php`
   - `app/Models/EventBookmark.php`
   - `app/Models/Feedback.php`
   - `app/Models/Notification.php`
   - Reason: Unused, database layer belongs in backend

3. **Database Migrations** (17 files):
   - `database/migrations/*`
   - Reason: Schema management is backend responsibility

4. **Seeders** (4 files):
   - `database/seeders/DummyDataSeeder.php`
   - `database/seeders/AdminUserSeeder.php`
   - `database/seeders/CategorySeeder.php`
   - `database/seeders/SuperAdminSeeder.php`
   - Reason: Data seeding is backend responsibility

5. **Background Jobs** (1 file):
   - `app/Jobs/SendEventRemindersJob.php`
   - Reason: Background processing belongs in backend

6. **Backend Services** (2 files):
   - `app/Services/PaymentService.php`
   - `app/Services/NotificationService.php`
   - Reason: Payment/notification logic is backend responsibility

### Files Retained (Temporary):
- `app/Models/Event.php`
- `app/Models/EventParticipant.php`
- `app/Models/User.php`

**Reason**: Still used by `FinanceController`, `AttendanceController`, and `PaymentController`.
**TODO**: Refactor these controllers to use `BackendApiService` instead of direct database access.

## Future Improvements

### 1. Refactor Remaining Controllers
**Controllers that need refactoring**:
- `app/Http/Controllers/FinanceController.php` (uses Event, EventParticipant models)
- `app/Http/Controllers/AttendanceController.php` (uses EventParticipant model)
- `app/Http/Controllers/PaymentController.php` (uses EventParticipant model)

**Refactoring Strategy**:
1. Create backend API endpoints for these operations
2. Update controllers to call `BackendApiService`
3. Remove remaining Eloquent models
4. Remove database connection from `.env`

### 2. Remove Database Dependency
After refactoring controllers:
- Remove `DB_*` variables from `.env`
- Remove `User` model (if not needed for session auth)
- Frontend becomes 100% stateless

### 3. Implement API Response Caching
Cache frequently accessed data:
```php
$events = Cache::remember('events.popular', 3600, function() {
    return $this->api->get('events/popular');
});
```

## Deployment Considerations

### Frontend Server Requirements:
- PHP 8.2+
- Composer
- File write permissions (for sessions/cache)
- NO database required (after refactoring)
- NO queue workers required

### Environment-Specific Configuration:

**Local Development**:
```env
API_BASE_URL=http://localhost:8001/api
APP_ENV=local
APP_DEBUG=true
```

**Staging**:
```env
API_BASE_URL=https://staging-eventconnect.sre-telkomuniversity-pwt.org/api
APP_ENV=staging
APP_DEBUG=false
```

**Production**:
```env
API_BASE_URL=https://api.eventconnect.com/api
APP_ENV=production
APP_DEBUG=false
```

## Testing

### Testing API Connection:
```bash
# Verify configuration
php artisan tinker
>>> config('services.backend.base_url')

# Test API is reachable
curl https://staging-eventconnect.sre-telkomuniversity-pwt.org/api/events
```

### Testing Frontend:
```bash
# Start frontend server
php artisan serve --port=8000

# Visit in browser
http://localhost:8000
```

### Common Issues:

**"Cannot connect to backend API"**:
- Check `API_BASE_URL` in `.env`
- Verify backend API is running
- Run `php artisan config:clear`

**"Session not persisting"**:
- Check `storage/framework/sessions/` is writable
- Verify `SESSION_DRIVER=file` in `.env`

## Directory Structure

```
event-connect/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Web controllers (render views)
│   │   └── Middleware/
│   ├── Models/               # Only User.php (temporary: Event, EventParticipant)
│   ├── Services/
│   │   └── BackendApiService.php  # API client
│   └── Exceptions/
├── resources/
│   ├── views/                # Blade templates
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php               # Frontend routes
│   └── api.php               # Empty (no API routes)
├── storage/
│   └── framework/
│       ├── sessions/         # Session files
│       └── cache/            # Cache files
├── .env                      # Environment configuration
└── README.md
```

## Related Documentation

- [API_SETUP.md](./API_SETUP.md) - Backend API configuration guide
- [SETUP_GUIDE.md](./SETUP_GUIDE.md) - Initial setup instructions
- Backend API repository: *(link to backend repo if available)*

## Contact & Support

For questions about this architecture:
- Review this document
- Check `API_SETUP.md` for API configuration
- Ensure backend API is running and accessible

---

**Last Updated**: December 2024
**Architecture Status**: ✅ Frontend-only (in progress - some controllers still need refactoring)
