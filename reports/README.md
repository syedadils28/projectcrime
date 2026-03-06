# Crime Record Management System (CRMS)
### Developed using PHP & MySQL | PHPGurukul Style

---

## 📋 System Overview

A complete multi-role Crime Record Management System with:
- **Public Home Page** – Mission & Vision, navigation
- **Admin Panel** – Full management of all records
- **User Panel** – Citizens can file FIRs and track status
- **Police Panel** – Officers can manage assigned FIRs

---

## 🔐 Login Credentials

| Role  | URL                          | Username/Email    | Password    |
|-------|------------------------------|-------------------|-------------|
| Admin | `/admin/login.php`           | `admin`           | `Test@12345`|
| User  | `/user/signin.php`           | Register first    | —           |
| Police| `/police/login.php`          | `CNTD01`          | `Test@123`  |

---

## 🛠️ Installation

### Requirements
- PHP 7.4+
- MySQL 5.7+  
- Apache/Nginx (XAMPP / WAMP / LAMP)

### Steps

1. **Copy** `crms/` folder to:
   - XAMPP: `C:/xampp/htdocs/crms/`
   - Linux: `/var/www/html/crms/`

2. **Import Database**:
   - Open phpMyAdmin
   - Create database: `crms`
   - Import: `crms.sql`

3. **Configure** `includes/config.php`:
   ```php
   $con = mysqli_connect("localhost","root","","crms");
   ```

4. **Access**: `http://localhost/crms/`

---

## 📁 File Structure

```
crms/
├── index.php                    ← Public home page
├── logout.php
├── crms.sql                     ← Database
├── css/style.css
├── images/
│   └── criminals/               ← Auto-created on upload
├── includes/
│   ├── config.php               ← DB connection
│   ├── admin-header.php / admin-footer.php
│   └── user-header.php  / user-footer.php
├── admin/
│   ├── login.php  /  dashboard.php
│   ├── add-police-station.php   manage-police-stations.php
│   ├── add-police.php           manage-police.php
│   ├── add-crime-category.php   manage-crime-categories.php
│   ├── add-criminal.php         view-criminals.php  edit-criminal.php
│   ├── view-fir.php
│   ├── report-criminals.php     report-fir.php
│   ├── search-criminal.php      search-fir.php
│   └── change-password.php
├── user/
│   ├── signup.php  signin.php
│   ├── dashboard.php
│   ├── fir-form.php             fir-history.php
│   ├── charge-sheet.php
│   ├── search.php
│   ├── profile.php
│   └── change-password.php
└── police/
    ├── login.php
    └── dashboard.php
```

---

## ✨ Features

### Admin Panel
- Dashboard with 5 stat cards (Criminals, Police, Crime Categories, Police Stations, FIRs)
- **Police Station** – Add/Edit/Delete stations with code
- **Police** – Add/Edit/Delete officers linked to stations
- **Crime Category** – Manage crime types
- **View Criminals** – Full CRUD with photo upload
- **View FIR** – Update status (Pending/Inprogress/Solved), assign officer, add remark
- **Reports** – Filter criminal & FIR reports by date range, print-ready
- **Search** – Search criminals and FIRs
- Change Password

### User Panel  
- Register / Sign In
- Dashboard with FIR stats
- File FIR (select station, category, subject, detail)
- FIR History with status tracking
- View Charge Sheet (added by police)
- Search criminal records
- Update Profile / Change Password

### Police Panel
- Login with Police ID
- Dashboard with station-level stats
- View & update FIRs

---

© PHPGurukul | Crime Record Management System
