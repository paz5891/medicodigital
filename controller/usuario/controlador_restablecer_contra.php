<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    require '../../model/usuario/Usuario.php';


    $mUsuario     = new Usuario();
    $email        = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $contraactual = htmlspecialchars($_POST['contrasena'], ENT_QUOTES, 'UTF-8');
    $contra1       = htmlspecialchars($_POST['contrasena'], ENT_QUOTES, 'UTF-8');

    $contra=hash("SHA256",$contra1);


    $consulta     = $mUsuario->restablecerContra($email, $contra);
    if($consulta == "1"){
        
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );
          
            $mail->SMTPDebug = 0;                    
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                   
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'byteseven777@gmail.com';                     
            $mail->Password   = '1AUDYbb)';                             
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
            $mail->Port       = 587;                                    

            $mail->setFrom(utf8_decode('byteseven777@gmail.com'), utf8_decode('Clinica Génesis'));
            $mail->addAddress($email);    
           
            $mail->isHTML(true);                                 
            $mail->Subject = utf8_decode('Restablecer Contraseña');
            $mail->Body    = 'Contraseña Restaurada <br> Nueva Contraseña <br> <b>'.$contraactual.'</b>';
            $mail->send();
            echo '1';
        } catch (Exception $e) {
            echo "0";
        }

       
    }else{
        echo "2";
    }
    

   
?>