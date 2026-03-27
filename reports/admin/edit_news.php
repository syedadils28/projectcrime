<?php
require_once '../includes/config.php';
$page_title = 'Edit News';
$base_url   = '../';
$breadcrumb = [['label' => 'Daily News'], ['label' => 'Edit News']];

// Session check — admin uses 'adminid', police uses 'policeid' (change if needed)
$is_admin  = isset($_SESSION['adminid']);
$is_police = isset($_SESSION['policeid']);

if (!$is_admin && !$is_police) {
    header("Location: login.php");
    exit();
}

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header("Location: manage_news.php");
    exit();
}

// Police can only edit their own news
if ($is_police) {
    $pid   = (int)$_SESSION['policeid'];
    $check = mysqli_fetch_assoc(mysqli_query($con,
        "SELECT * FROM news WHERE id=$id AND posted_by=$pid AND posted_by_role='police'"
    ));
    if (!$check) {
        echo "<p style='color:red;padding:20px;'>Unauthorized: You can only edit your own news.</p>";
        exit();
    }
}

$news = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM news WHERE id=$id"));
if (!$news) {
    echo "<p style='color:red;padding:20px;'>News not found.</p>";
    exit();
}

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title      = mysqli_real_escape_string($con, trim($_POST['title']));
    $content    = mysqli_real_escape_string($con, trim($_POST['content']));
    $category   = mysqli_real_escape_string($con, $_POST['category']);
    $image_name = $news['image'];

    if (!empty($_FILES['image']['name'])) {
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            // Remove old image file
            if ($image_name && file_exists('../uploads/news/' . $image_name)) {
                unlink('../uploads/news/' . $image_name);
            }
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $upload_dir = '../uploads/news/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
        } else {
            $error = "Invalid image format. Use JPG, PNG, GIF or WEBP.";
        }
    }

    if (empty($error)) {
        $img_val = $image_name ? "'$image_name'" : "NULL";
        $sql = "UPDATE news
                SET title='$title', content='$content', category='$category', image=$img_val
                WHERE id=$id";
        if (mysqli_query($con, $sql)) {
            $success = "News updated successfully!";
            // Refresh data
            $news = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM news WHERE id=$id"));
        } else {
            $error = "Database error: " . mysqli_error($con);
        }
    }
}

include '../includes/admin-header.php';
?>

<style>
.news-form-card {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    max-width: 700px;
    margin: 0 auto 30px;
}
.form-group { margin-bottom: 18px; }
.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
    font-size: 13px;
}
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    box-sizing: border-box;
    font-family: inherit;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}
.form-group textarea { height: 150px; resize: vertical; }
.btn-update {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 11px 28px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
}
.btn-update:hover { background: #0056b3; }
.alert-success {
    background: #d4edda; color: #155724;
    padding: 10px 16px; border-radius: 6px; margin-bottom: 16px;
}
.alert-error {
    background: #f8d7da; color: #721c24;
    padding: 10px 16px; border-radius: 6px; margin-bottom: 16px;
}
.current-img img {
    max-height: 120px;
    border-radius: 6px;
    border: 1px solid #eee;
    margin-top: 8px;
    display: block;
}
</style>

<div class="news-form-card">
    <?php if ($success): ?><div class="alert-success">✅ <?= $success ?></div><?php endif; ?>
    <?php if ($error):   ?><div class="alert-error">❌ <?= $error ?></div><?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title *</label>
            <input type="text" name="title"
                   value="<?= htmlspecialchars($news['title']) ?>"
                   required maxlength="255">
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category">
                <?php foreach (['General','Crime Alert','Missing Person','Notice','Update'] as $cat): ?>
                    <option value="<?= $cat ?>" <?= $news['category'] === $cat ? 'selected' : '' ?>>
                        <?= $cat ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Content *</label>
            <textarea name="content" required><?= htmlspecialchars($news['content']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Image <small style="font-weight:400;color:#888;">(leave blank to keep existing)</small></label>
            <?php if ($news['image']): ?>
                <div class="current-img">
                    <small style="color:#888;">Current image:</small>
                    <img src="../uploads/news/<?= htmlspecialchars($news['image']) ?>" alt="Current image">
                </div>
                <br>
            <?php endif; ?>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn-update">💾 Update News</button>
        &nbsp;&nbsp;
        <a href="manage_news.php" style="color:#666; font-size:13px;">← Back to Manage News</a>
    </form>
</div>

<?php include '../includes/admin-footer.php'; ?>