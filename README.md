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
- PHP 8+
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