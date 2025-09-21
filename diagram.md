# IT Ticket Management API - Infrastructure Diagram

```mermaid
graph TB
    %% User Interface Layer
    User[👤 User/Client]
    Browser[🌐 Browser]
    PostmanAPI[📡 Postman/API Client]
    SwaggerUI[📋 Swagger UI<br/>localhost:8000/api/documentation]

    %% Application Layer
    subgraph "Laravel Application (Port 8000)"
        direction TB
        ArtisanServer[🚀 Artisan Server<br/>php artisan serve]

        subgraph "Routes Layer"
            WebRoutes[🛣️ Web Routes<br/>routes/web.php]
            APIRoutes[🛣️ API Routes<br/>routes/api.php]
            AuthRoutes[🔐 Auth Routes<br/>routes/auth.php]
        end

        subgraph "Controllers Layer"
            TicketController[🎛️ TicketController<br/>app/Http/Controllers/Api/]
            AuthController[🔐 Auth Controllers<br/>app/Http/Controllers/Auth/]
        end

        subgraph "Models Layer"
            TicketModel[📊 Ticket Model<br/>app/Models/]
            UserModel[👥 User Model<br/>app/Models/]
        end

        subgraph "Frontend Layer"
            ReactComponents[⚛️ React Components<br/>resources/js/]
            InertiaJS[🔄 Inertia.js Bridge]
            ViteServer[⚡ Vite Dev Server<br/>npm run dev]
        end
    end

    %% Database Layer
    subgraph "PostgreSQL Database"
        direction TB
        PGServer[🐘 PostgreSQL Server<br/>127.0.0.1:5432]
        Database[(🗄️ aws_it_database)]

        subgraph "Tables"
            TicketsTable[📋 tickets<br/>10,000 records<br/>37 columns]
            UsersTable[👥 users<br/>Laravel Auth]
            CacheTable[💾 cache<br/>Performance]
            JobsTable[⚙️ jobs<br/>Background Tasks]
            SessionsTable[🔐 sessions<br/>User Sessions]
        end
    end

    %% Data Import Layer
    subgraph "Data Sources"
        CSVFile[📄 tickets_1.csv<br/>10,000 IT tickets<br/>Real production data]
        TicketSeeder[🌱 TicketSeeder<br/>database/seeders/<br/>Batch import logic]
    end

    %% Development Tools
    subgraph "Development Tools"
        Composer[📦 Composer<br/>PHP Dependencies<br/>L5-Swagger, Fortify]
        NPM[📦 NPM<br/>Frontend Packages<br/>React, Vite, Inertia]
        SwaggerGen[📖 L5-Swagger<br/>Auto-generate API docs]
        Migrations[🔄 Laravel Migrations<br/>Database schema<br/>Version control]
    end

    %% Background Services
    subgraph "Background Services"
        QueueWorker[⚙️ Queue Worker<br/>php artisan queue:listen<br/>Process background jobs]
        PailLogs[📝 Pail Logs<br/>php artisan pail<br/>Real-time logging]
    end

    %% User Flow Connections
    User --> Browser
    User --> PostmanAPI
    Browser --> SwaggerUI
    Browser --> ArtisanServer
    PostmanAPI --> ArtisanServer
    SwaggerUI --> ArtisanServer

    %% Application Internal Flow
    ArtisanServer --> WebRoutes
    ArtisanServer --> APIRoutes
    WebRoutes --> ReactComponents
    APIRoutes --> TicketController
    AuthRoutes --> AuthController
    TicketController --> TicketModel
    AuthController --> UserModel
    ReactComponents --> InertiaJS
    InertiaJS --> TicketController

    %% Database Connections
    TicketModel -.-> Database
    UserModel -.-> Database
    Database --> TicketsTable
    Database --> UsersTable
    Database --> CacheTable
    Database --> JobsTable
    Database --> SessionsTable

    %% Data Import Flow
    CSVFile --> TicketSeeder
    TicketSeeder --> TicketsTable
    Migrations --> Database

    %% Development Flow
    Composer -.-> ArtisanServer
    NPM -.-> ViteServer
    ViteServer -.-> ReactComponents
    SwaggerGen -.-> SwaggerUI

    %% Background Services
    QueueWorker -.-> JobsTable
    PailLogs -.-> ArtisanServer

    %% API Endpoints Labels
    APIRoutes -.-> |"GET /api/tickets<br/>GET /api/tickets/{id}<br/>GET /api/stats"| TicketController

    %% Styling
    classDef database fill:#e1f5fe,stroke:#0277bd,stroke-width:2px
    classDef api fill:#f3e5f5,stroke:#7b1fa2,stroke-width:2px
    classDef frontend fill:#e8f5e8,stroke:#388e3c,stroke-width:2px
    classDef tools fill:#fff3e0,stroke:#f57c00,stroke-width:2px
    classDef data fill:#fce4ec,stroke:#c2185b,stroke-width:2px
    classDef services fill:#f1f8e9,stroke:#689f38,stroke-width:2px

    class PGServer,Database,TicketsTable,UsersTable,CacheTable,JobsTable,SessionsTable database
    class APIRoutes,TicketController,SwaggerUI,PostmanAPI api
    class ReactComponents,InertiaJS,ViteServer,Browser frontend
    class Composer,NPM,SwaggerGen,Migrations tools
    class CSVFile,TicketSeeder data
    class QueueWorker,PailLogs services
```

## Architecture Overview

**This diagram shows the complete infrastructure for the IT Ticket Management API:**

### 🏗️ **Key Components:**

1. **Frontend Layer:** React + Inertia.js + Vite for modern SPA experience
2. **Backend Layer:** Laravel 12 with clean API architecture
3. **Database Layer:** PostgreSQL with 10,000 real IT ticket records
4. **Documentation:** Auto-generated Swagger/OpenAPI docs
5. **Development Tools:** Modern PHP/JS toolchain
6. **Background Services:** Queue processing and real-time logging

### 🔄 **Data Flow:**

1. **Import:** CSV → TicketSeeder → PostgreSQL
2. **API:** Client → Routes → Controller → Model → Database
3. **Frontend:** React → Inertia.js → Laravel → API responses
4. **Documentation:** Code annotations → Swagger generator → Interactive UI

### 🚀 **Development Commands:**

- `php artisan serve` - Start API server
- `npm run dev` - Start frontend development
- `php artisan queue:listen` - Process background jobs
- `php artisan pail` - Real-time application logs
- `composer run dev` - Run all services in parallel

### 📊 **Current Status:**

- ✅ 10,000 IT tickets imported and indexed
- ✅ RESTful API with 3 endpoints documented
- ✅ PostgreSQL database optimized with indexes
- ✅ Swagger documentation auto-generated
- ✅ Full-stack development environment ready