<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html>

<head>
    <title>SMTP Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>

<body>
    <h2>SMTP Test Form</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Load Composer's autoloader
        require 'phpMailer/Exception.php';
        require 'phpMailer/PHPMailer.php';
        require 'phpMailer/SMTP.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'parthvibalar1211@gmail.com';           //SMTP username
            $mail->Password = 'jsjs cnhv etsi hgkp';                  //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to
    
            //Recipients
            $mail->setFrom('parthvibalar1211@gmail.com', 'SMTP Test');
            $mail->addAddress($_POST['to_email'], $_POST['to_name']);   //Add a recipient
    
            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $_POST['subject'];
            $mail->Body = $_POST['message'];
            $mail->AltBody = strip_tags($_POST['message']);             //Plain text version
    
            $mail->send();
            echo '<div class="result success">Message has been sent successfully!</div>';
        } catch (Exception $e) {
            echo '<div class="result error">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="to_name">Recipient Name:</label>
            <input type="text" id="to_name" name="to_name" required>
        </div>

        <div class="form-group">
            <label for="to_email">Recipient Email:</label>
            <input type="email" id="to_email" name="to_email" required>
        </div>

        <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>

        <button type="submit">Send Test Email</button>
    </form>
</body>

</html>