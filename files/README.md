# Daily News Feature — Integration Guide
## Crime Record Management System (PHP + MySQL)

---

## 1. Database Setup
Run `news_table.sql` in **phpMyAdmin → SQL tab**:
```
CREATE TABLE news ( ... )
```

---

## 2. Folder Structure to Create
```
your_project/
├── uploads/
│   └── news/               ← images uploaded here (create this folder, chmod 755)
│
├── admin/
│   └── news/
│       ├── add_news.php        ← Admin posts news
│       ├── manage_news.php     ← Admin views/deletes all news
│       └── edit_news.php       ← Admin edits any news
│
├── police/
│   └── news/
│       ├── manage_news.php     ← Police posts + edits + deletes their own news
│       └── edit_news.php       ← (copy admin/edit_news.php, change session check)
│
└── user/
    └── news/
        ├── all_news.php        ← Users view all news (read-only)
        └── view_news.php       ← (optional: single news detail page)
```

---

## 3. Add News to Navigation Sidebar

### Admin sidebar (admin/includes/sidebar.php)
Add inside your nav links:
```html
<li>
  <a href="<?= BASE_URL ?>admin/news/manage_news.php">
    <i class="fas fa-newspaper"></i> Daily News
  </a>
</li>
```

### Police sidebar (police/includes/sidebar.php)
```html
<li>
  <a href="<?= BASE_URL ?>police/news/manage_news.php">
    <i class="fas fa-newspaper"></i> Daily News
  </a>
</li>
```

### User sidebar (user/includes/sidebar.php)
```html
<li>
  <a href="<?= BASE_URL ?>user/news/all_news.php">
    <i class="fas fa-newspaper"></i> Daily News
  </a>
</li>
```

---

## 4. Add News Widget to Dashboards

Open each dashboard file and paste this code where you want the news card to appear (after your existing stat cards).

**In ALL 3 dashboards (admin, police, user):**
```php
<?php include('news/dashboard_news_widget.php'); ?>
```
OR copy-paste the HTML/CSS directly from `shared/dashboard_news_widget.php`.

Make sure `$conn` (your DB connection) is already initialized before this include.

---

## 5. Session Variable Mapping

| Panel  | Check             | Name variable            |
|--------|-------------------|--------------------------|
| Admin  | `$_SESSION['admin_id']`  | `$_SESSION['admin_name']`  |
| Police | `$_SESSION['police_id']` | `$_SESSION['police_name']` |
| User   | `$_SESSION['user_id']`   | `$_SESSION['user_name']`   |

Update the session variable names in each file to match YOUR existing session keys.

---

## 6. Edit `edit_news.php` for Police
Copy `admin/edit_news.php` to `police/news/edit_news.php`.
Change the top session check from:
```php
$is_admin  = isset($_SESSION['admin_id']);
```
to use police session. The ownership check is already inside the file — police can only edit news they posted.

---

## 7. Permissions Summary

| Action        | Admin | Police | User |
|---------------|-------|--------|------|
| Post news     | ✅    | ✅     | ❌   |
| Edit news     | ✅ All | ✅ Own only | ❌ |
| Delete news   | ✅ All | ✅ Own only | ❌ |
| View news     | ✅    | ✅     | ✅   |
| Hide/Show     | ✅    | ❌     | ❌   |

---

## 8. Image Uploads
- The `uploads/news/` folder must exist and be writable.
- On Linux/Mac: `chmod 755 uploads/news/`
- On XAMPP Windows: folder permissions are usually fine by default.

---

That's it! The feature is fully functional with category filtering, image support, role-based access, and dashboard integration.
