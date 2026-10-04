<?php
require_once 'config.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$message = '';
$message_type = '';

// إضافة تسجيل جديد
if (isset($_POST['add'])) {
    $full_name = $_POST['full_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $graduation_year = $_POST['graduation_year'];
    $address = $_POST['address'];
    
    $sql = "INSERT INTO registrations (full_name, mobile_number, email, date_of_birth, graduation_year, address) 
            VALUES ('$full_name', '$mobile_number', '$email', '$date_of_birth', '$graduation_year', '$address')";
    
    if ($conn->query($sql)) {
        $message = 'تم إضافة التسجيل بنجاح';
        $message_type = 'success';
    } else {
        $message = 'خطأ في الإضافة: ' . $conn->error;
        $message_type = 'error';
    }
}

// تحديث تسجيل
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $graduation_year = $_POST['graduation_year'];
    $address = $_POST['address'];
    
    $sql = "UPDATE registrations SET 
            full_name = '$full_name',
            mobile_number = '$mobile_number',
            email = '$email',
            date_of_birth = '$date_of_birth',
            graduation_year = '$graduation_year',
            address = '$address'
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        $message = 'تم تحديث التسجيل بنجاح';
        $message_type = 'success';
    } else {
        $message = 'خطأ في التحديث: ' . $conn->error;
        $message_type = 'error';
    }
}

// حذف تسجيل
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM registrations WHERE id = $id";
    
    if ($conn->query($sql)) {
        $message = 'تم حذف التسجيل بنجاح';
        $message_type = 'success';
    } else {
        $message = 'خطأ في الحذف: ' . $conn->error;
        $message_type = 'error';
    }
}

// جلب بيانات للتعديل
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM registrations WHERE id = $id");
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    }
}

// جلب جميع التسجيلات
$registrations = $conn->query("SELECT * FROM registrations ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نموذج التسجيل</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>نموذج التسجيل</h1>
            <a href="logout.php" class="logout-btn">تسجيل الخروج</a>
        </div>
        
        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="form-section">
            <h2><?php echo $edit_data ? 'تعديل التسجيل' : 'إضافة تسجيل جديد'; ?></h2>
            <form method="POST" action="">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>الاسم الكامل:</label>
                    <input type="text" name="full_name" value="<?php echo $edit_data ? $edit_data['full_name'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>رقم الجوال:</label>
                    <input type="text" name="mobile_number" value="<?php echo $edit_data ? $edit_data['mobile_number'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>البريد الإلكتروني:</label>
                    <input type="email" name="email" value="<?php echo $edit_data ? $edit_data['email'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>تاريخ الميلاد:</label>
                    <input type="date" name="date_of_birth" value="<?php echo $edit_data ? $edit_data['date_of_birth'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>سنة التخرج:</label>
                    <input type="number" name="graduation_year" value="<?php echo $edit_data ? $edit_data['graduation_year'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label>العنوان:</label>
                    <textarea name="address"><?php echo $edit_data ? $edit_data['address'] : ''; ?></textarea>
                </div>
                
                <div class="form-buttons">
                    <?php if ($edit_data): ?>
                        <button type="submit" name="update" class="btn btn-update">تحديث</button>
                        <a href="form.php" class="btn btn-cancel">إلغاء</a>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-add">إضافة</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-section">
            <h2>قائمة التسجيلات</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم الكامل</th>
                        <th>رقم الجوال</th>
                        <th>البريد الإلكتروني</th>
                        <th>تاريخ الميلاد</th>
                        <th>سنة التخرج</th>
                        <th>العنوان</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($registrations->num_rows > 0): ?>
                        <?php while ($row = $registrations->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['full_name']; ?></td>
                                <td><?php echo $row['mobile_number']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['date_of_birth']; ?></td>
                                <td><?php echo $row['graduation_year']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td>
                                    <a href="form.php?edit=<?php echo $row['id']; ?>" class="btn-edit">تعديل</a>
                                    <a href="form.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">لا توجد تسجيلات</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

