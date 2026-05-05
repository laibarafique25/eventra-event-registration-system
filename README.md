# 📅 Eventra - Event Registration System

**Eventra** is a robust PHP + MySQL based event management platform developed during my **CodeAlpha Backend Internship**. It provides a seamless experience for users to discover and register for events, while offering administrators a powerful dashboard to manage the entire ecosystem.

---

## 🌟 Key Features

### 👤 User Side
- **Event Discovery:** Browse upcoming events with details, images, and locations.
- **Secure Authentication:** User signup and login with hashed passwords.
- **Personal Dashboard:** Manage registered events and cancel attendance if needed.
- **One-Click Registration:** Quick registration flow for authenticated users.

### 🔑 Admin Side
- **Centralized Dashboard:** Overview of system activity and registrations.
- **Event Management (CRUD):** Full control to create, edit, and delete events.
- **Registration Tracking:** Monitor which users are attending specific events.
- **Secure Access:** Dedicated admin authentication layer.

---

## 🛠️ Technology Stack

- **Backend:** PHP (PDO & Prepared Statements for SQL Security)
- **Database:** MySQL (Relational schema with Foreign Keys)
- **Security:** `password_hash()` for credentials and `htmlspecialchars()` for XSS protection.
- **Architecture:** Clean folder-based separation (Admin/User/Config).

---

## 📁 Project Structure

```text
/Eventra
│
├── /admin              # Administrative control panel & logic
├── /user               # User-facing website and registration flow
├── /database           # SQL schema and seed data
├── /docs               # Project reports and documentation
├── config.php          # Database connection & global helpers
├── index.php           # Entry point
└── README.md           # Project guide
