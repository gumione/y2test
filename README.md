# Loan Application System (Yii2)

This repository is part of a test assignment demonstrating a backend solution with **Yii2** (PHP 8.2). It covers user registration, token-based authentication (Bearer), file uploads, and basic loan application management. The architecture follows a service-oriented approach, separating business logic (Services), data access (Repositories), and data models (ActiveRecord/DTO).

## Key Features

- **User Management**  
  Registration, login, and profile updates, with dedicated Repositories and Services for data handling.
- **Loan Applications**  
  Basic creation, validation, and tracking of loan requests, with fields for outstanding balances, statuses, etc.
- **Documents**  
  File uploads linked to each user; easy to extend for additional document types.
- **Swagger/OpenAPI**  
  Initial annotations for API documentation (controllers annotated to generate specs).
- **Service & Repository Layers**  
  Clear separation of responsibilities, supporting maintainability and scalability.

## Installation & Setup

1. Ensure **PHP 8.2**, Composer, and a configured database (e.g., MySQL/MariaDB).
2. Clone the repository, then run `composer install`.
3. Update database credentials in Yii2 config, apply migrations (`php yii migrate`).
4. Launch via a web server or `php yii serve`.

## Potential Enhancements

- **RBAC**: Fine-grained roles/permissions for admins and regular users.
- **Admin Panel**: Dedicated CRUD interfaces for loans, documents, and user management.
- **Extended Validation**: More thorough checks and custom error structures.
- **Debt Clearing**: Automated logic (via cron/queue) to randomly clear one user's debt annually.
- **Advanced Swagger Docs**: Detailed schemas, versioned endpoints, and comprehensive examples.
