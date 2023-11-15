<?php

// Replace this with your own email address
$to = "00barisasker@gmail.com";

// Extract form contents
$name = $_POST['name'];
$email = $_POST['email'];
$website = $_POST['website'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Validate email address
function valid_email($str) {
    return filter_var($str, FILTER_VALIDATE_EMAIL);
}

// Return errors if present
$errors = [];

if (empty($name)) {
    $errors[] = "Name is required";
}

if (!valid_email($email)) {
    $errors[] = "Invalid email address";
}

if (empty($message)) {
    $errors[] = "Message is required";
}

// Send email
if (empty($errors)) {

    $headers = 'From: FluidApp <no-reply@fluidapp.com>' . "\r\n" .
        'Reply-To: ' . $email . '' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $email_subject = "Website Contact Form: $email";
    $message_body = "Name: $name \n\nEmail: $email \n\nWebsite: $website \n\nSubject: $subject \n\nMessage:\n\n $message";

    if (mail($to, $email_subject, $message_body, $headers)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error sending email"]);
    }

} else {
    echo json_encode(["status" => "error", "message" => implode(", ", $errors)]);
}
?>
