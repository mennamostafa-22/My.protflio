<?php
// ⚠️ 
$to_email = "mennaalahnice@gmail.com"; 
$subject_prefix = "طلب تحليل بيانات جديد: ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $message = strip_tags(trim($_POST["message"] ?? ''));

    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "يرجى ملء جميع الحقول بشكل صحيح.";
        exit;
    }

    $email_content = "وصلتك رسالة جديدة من نموذج الاتصال في موقعك:\n\n";
    $email_content .= "الاسم: $name\n";
    $email_content .= "البريد الإلكتروني: $email\n\n";
    $email_content .= "الموضوع: $subject\n\n";
    $email_content .= "الرسالة:\n$message\n";

    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to_email, $subject_prefix . $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "OK"; 
    } else {
        http_response_code(500);
        echo "عذراً، حدث خطأ أثناء إرسال رسالتك. حاول مجدداً لاحقاً.";
    }
} else {
    http_response_code(403);
    echo "هناك مشكلة في طريقة الإرسال.";
}
?>
