![CI](https://github.com/alexsis20102/laravel-simple-crm/actions/workflows/ci.yml/badge.svg)

# 🚀 Simple CRM — Laravel Backend System

Modern client and contact management system built with Laravel.  
The project demonstrates structured backend architecture, authenticated data access, and relational domain modeling for business-oriented applications.

This repository represents a transition from procedural PHP development to a modern framework-based backend architecture.

---

## ✨ Features

### 🔐 Authentication & Security
- User registration and login
- Password recovery via email
- Protected routes with access control
- Automatic ownership tracking for created records
- Server-side validation and secure request handling

### 👥 Client Management
- Create, update, and delete clients
- Enum-based client status system
- Real-time search and sorting
- Pagination support
- Dynamic updates without page reload

### 📇 Contact Management
- Multiple contacts per client
- Typed contact roles (Mother, Father, Spouse, etc.)
- Relational data model using Eloquent ORM
- Cross-entity search capabilities

### ⚡ Dynamic Interface
- Asynchronous communication via Axios
- SPA-like interaction without page reloads
- Reusable data table engine
- Modal-based editing workflow

---

## 🧱 Technical Stack

### Backend
- PHP >= 8.4
- Laravel 12
- Eloquent ORM
- Enum-based domain modeling

### Frontend
- JavaScript
- Axios
- Bootstrap 5 (Dark Theme)

### Architecture Concepts
- MVC pattern
- Service-oriented business logic
- Relational domain modeling
- REST-oriented communication
- Server-side validation

---

## 🧩 Domain Model

### Entities
- **User** → system access and ownership tracking  
- **Client** → primary business entity  
- **ContactPerson** → related entity linked to client  

### Relationships
- User → has many Clients  
- Client → has many ContactPersons  

---

## 🎯 Project Goals

This project was created to demonstrate:

- Transition from procedural PHP to modern backend architecture
- Implementation of structured business logic
- Secure authenticated data management
- Real-world relational domain modeling
- Scalable application structure suitable for API expansion

---

## ⚙️ Installation

This project can be installed locally using the same steps as the CI pipeline.

### 1 Requirements

- PHP ≥ 8.4  
- Composer  
- Node.js ≥ 20  
- MySQL 8  
- Git  

---

### 2 Clone repository

```bash
git clone https://github.com/alexsis20102/laravel-simple-crm.git
cd simple-crm
```

### 3 Install dependencies:

```bash
composer install
```

### 4 Configure environment:

```bash
cp .env.example .env
php artisan key:generate
```

### 5 Configure database in .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password

### 6 Run database migrations:

```bash
php artisan migrate
```

### 7 Install frontend dependencies:

```bash
npm install
```

### 8 Build frontend assets:

```bash
npm run build
```

Development mode:

```bash
npm run dev
```

### 9 Run application:

```bash
php artisan serve
```
Open in browser: http://127.0.0.1:8000

## 📌 Project Purpose

This project was created as a portfolio application demonstrating:

- modern Laravel architecture
- relational data modeling
- SPA-like interface
- CI/CD pipeline
- automated testing
- reproducible environment setup

---

## 🔮 Future Improvements

- Public REST API
- Automated tests (Feature + Unit)
- Docker environment
- OpenAPI / Swagger documentation
- Service layer abstraction
- Role-based permissions
- Event-driven domain logic

---

## 👨‍💻 Author

Backend developer focused on business systems, automation, and scalable PHP architecture.

---

## 📄 License

Open-source project intended for educational and portfolio purposes.