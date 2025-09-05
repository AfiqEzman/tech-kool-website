<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$mail = new PHPMailer(true);


try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'muhammadafiqezman@gmail.com'; // Gmail account
    $mail->Password = 'hcdh fdlb gebg tyqs'; // Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Get form data
    $name    = htmlspecialchars($_POST['name']);
    $email   = htmlspecialchars($_POST['email']);
    $contact = htmlspecialchars($_POST['contact']);
    $address = htmlspecialchars($_POST['address']);
    $type    = htmlspecialchars($_POST['type']);
    $services = isset($_POST['services']) ? implode(', ', $_POST['services']) : 'None selected';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit;
    }

   
    $mail->setFrom($email, $name);
    $mail->Sender = $mail->Username; // Prevent Gmail rejection
    $mail->addAddress('afiqezman18@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Form Submission';
    $mail->Body = "
        <h3>Message</h3>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Contact:</strong> {$contact}</p>
        <p><strong>Address:</strong> {$address}</p>
        <p><strong>Type:</strong> {$type}</p>
        <p><strong>Services:</strong> {$services}</p>
    ";

    $mail->send();

    http_response_code(200);
    echo "Message has been sent successfully!";
} catch (Exception $e) {
    http_response_code(500);
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

