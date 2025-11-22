<?php
// login.php

// تشغيل الجلسة (اختياري لتخزين بيانات المستخدم بعد تسجيل الدخول)
session_start();

// التأكد أن الطلب من نوع POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // استلام البيانات من النموذج
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // مصفوفة لتجميع الأخطاء
    $errors = [];

    // التحقق من البريد
    if (empty($email)) {
        $errors[] = "الرجاء إدخال البريد الإلكتروني.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "صيغة البريد الإلكتروني غير صحيحة.";
    }

    // التحقق من كلمة المرور
    if (empty($password)) {
        $errors[] = "الرجاء إدخال كلمة المرور.";
    } elseif (strlen($password) < 8) {
        $errors[] = "كلمة المرور يجب أن تكون 8 أحرف على الأقل.";
    }

    // إذا وجد أخطاء — نعرضها
    if (!empty($errors)) {
        echo "<h3>حدثت الأخطاء التالية:</h3>";
        foreach ($errors as $err) {
            echo "<p style='color:red;'>• $err</p>";
        }
        exit;
    }

    // ---- في هذا المكان يمكنك إضافة تحقق من قاعدة البيانات ----
    // مثال بسيط (محاكاة مستخدم محفوظ)
    $valid_email = "admin@lugx.com";
    $valid_password = "12345678"; // في الحقيقة احفظها بوضع مشفر hashing

    if ($email === $valid_email && $password === $valid_password) {

        // تخزين المستخدم في الجلسة
        $_SESSION['user'] = $email;

        echo "<h2 style='color:green;'>تم تسجيل الدخول بنجاح!</h2>";
        echo "<p>مرحباً بك يا $email</p>";

        // تحويل لصفحة لوحة التحكم
        // header(\"Location: dashboard.php\");
        exit;
    } else {
        echo "<h3 style='color:red;'>بيانات الدخول غير صحيحة!</h3>";
        exit;
    }

} else {
    echo "طلب غير مسموح!";
}
?>
