# Crime Report Management System

A comprehensive web-based platform for reporting and managing crime incidents. This application allows users to file crime reports, view galleries, and provides an administrative dashboard for authority personnel.

## 🎯 Features

### User Features
- **User Registration & Authentication** - Secure registration and login system
- **Crime Reporting** - Easy-to-use interface for submitting crime reports
- **Gallery Management** - Browse image galleries categorized by crime type
  - Cyber crimes
  - Organized crime
  - Property crimes
  - Serial crimes
- **Account Management** - Profile management and password recovery
- **Report Submission** - Submit crimes with detailed information

### Admin Features
- **Admin Dashboard** - Centralized control panel for administrators
- **Report Management** - View and manage all submitted crime reports
- **User Management** - Monitor and manage registered users
- **Data Analytics** - Track crime statistics and trends

## 📋 System Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Apache with mod_rewrite enabled (or XAMPP)
- Modern web browser (Chrome, Firefox, Safari, Edge)

## 🛠️ Installation

### Prerequisites
1. Install XAMPP or any local server environment
2. Have a database server running (MySQL/MariaDB)

### Setup Steps

1. **Clone Repository**
   ```bash
   git clone https://github.com/syedadils28/projectcrime.git
   cd projectcrime
   ```

2. **Database Configuration**
   - Open `db_conn.php` and update database credentials:
     ```php
     $HOST = "localhost";
     $USER = "root";
     $PASSWORD = "";
     $DB = "crime_db";
     ```

3. **Create Database**
   - Import the database schema (if provided)
   - Ensure all required tables are created

4. **File Permissions**
   - Make sure upload directories have proper write permissions
   - Place project in `htdocs` folder (for XAMPP)

5. **Access Application**
   - Open browser and navigate to: `http://localhost/6sem/projectcrime/`

## 📁 Project Structure

```
projectcrime/
├── index.php              # Homepage
├── login.php              # User login page
├── register.php           # User registration page
├── gallery.php            # Gallery display
├── auth.php               # Authentication logic
├── db_conn.php            # Database connection
├── logout.php             # Logout functionality
├── welcome.php            # Welcome page (after login)
│
├── report/                # Crime report module
│   ├── index.php          # Report submission form
│   ├── adminlogin.php     # Admin login
│   ├── signup.php         # Admin signup
│   ├── user-forgot-password.php  # Password recovery
│   ├── includes/          # Include files
│   │   ├── config.php
│   │   ├── header.php
│   │   └── footer.php
│   └── assets/            # Frontend resources
│       ├── css/           # Stylesheets
│       │   ├── bootstrap.css
│       │   ├── font-awesome.css
│       │   └── style.css
│       ├── js/            # JavaScript files
│       │   ├── bootstrap.js
│       │   ├── custom.js
│       │   ├── jquery-1.10.2.js
│       │   └── dataTables/  # Data table functionality
│       ├── fonts/
│       └── img/
│
└── source/                # Source assets
    ├── CSS/               # Custom styles
    ├── JS/                # Custom scripts
    ├── img/               # Image files
    │   ├── home/          # Homepage images
    │   ├── about/         # About page images
    │   └── gallary/       # Gallery images
    │       ├── cyber/
    │       ├── organi/
    │       ├── property/
    │       └── srial/
    └── pdf/               # PDF documents
```

## 🔐 Security Features

- **Password Hashing** - Secure password storage
- **Session Management** - User session handling
- **SQL Injection Prevention** - Prepared statements
- **Authentication** - Role-based access (User/Admin)
- **Form Validation** - Client and server-side validation

## 📚 Key Files

| File | Purpose |
|------|---------|
| `db_conn.php` | Database connection |
| `auth.php` | Authentication logic |
| `index.php` | Main landing page |
| `login.php` | User login interface |
| `register.php` | User registration |
| `report/index.php` | Crime report submission |
| `report/adminlogin.php` | Admin authentication |
| `gallery.php` | Image gallery display |

## 🚀 Usage

### For Users
1. Navigate to the homepage
2. Click "Register" to create a new account
3. Log in with your credentials
4. Submit crime reports through the report section
5. Browse gallery for reference materials

### For Administrators
1. Access admin panel at `/report/adminlogin.php`
2. View and manage submitted reports
3. Monitor user activity
4. Generate reports and statistics

## 🐛 Troubleshooting

**Database Connection Error**
- Check database credentials in `db_conn.php`
- Ensure MySQL/MariaDB service is running
- Verify database exists

**Access Denied**
- Clear browser cache and cookies
- Check user permissions in database
- Verify PHP session is enabled

**File Upload Issues**
- Check folder permissions (should be writable)
- Verify file size limits in `php.ini`
- Check available disk space

## 📝 Dependencies

- **Bootstrap** - Frontend framework
- **jQuery** - JavaScript library
- **DataTables** - Data table plugin
- **Font Awesome** - Icon library

## 👨‍💻 Developer

**Project Owner:** syedadils28

## 📄 License

This project is provided as-is for educational and authorized use only.

## 📧 Contact & Support

For issues, questions, or support, please contact the project maintainer or submit issues through the repository.

---

**Last Updated:** March 2, 2026  
**Version:** 1.0
