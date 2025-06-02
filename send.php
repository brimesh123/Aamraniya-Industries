<?php
// Prevent any output
ob_start();

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';


// Function to send JSON response
function sendResponse($success, $message)
{
    // Clear all output buffers
    while (ob_get_level()) {
        ob_end_clean();
    }

    // Set headers
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, must-revalidate');

    // Send JSON response
    die(json_encode([
        'success' => $success,
        'message' => $message
    ]));
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       //Disable debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                             //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                     //Enable SMTP authentication
    $mail->Username = 'parthvibalar1211@gmail.com';             //SMTP username
    $mail->Password = 'jsjs cnhv etsi hgkp';                    //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                          //TCP port to connect to

    //Recipients
    $mail->setFrom('parthvibalar1211@gmail.com', 'Contact Form');
    $mail->addAddress('sandipaamraniya@yahoo.com', 'Website');       //Add a recipient

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'New Contact Form Submission';

    // Get form data
    $name = isset($_POST['name']) ? $_POST['name'] : 'Not provided';
    $email = isset($_POST['email']) ? $_POST['email'] : 'Not provided';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : 'Not provided';
    $message = isset($_POST['message']) ? $_POST['message'] : 'Not provided';

    // Create HTML body
    $htmlBody = "
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {$name}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Mobile:</strong> {$mobile}</p>
    <p><strong>Message:</strong></p>
    <p>" . nl2br(htmlspecialchars($message)) . "</p>
    ";

    $mail->Body = $htmlBody;
    $mail->AltBody = strip_tags($htmlBody);                     //Plain text version

    $mail->send();
    sendResponse(true, 'Message has been sent successfully!');
} catch (Exception $e) {
    sendResponse(false, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}

?>