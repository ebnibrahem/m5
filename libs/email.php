<?php namespace M5\Library;

    /**
     *  send un Email | sms
     *
     *
     */
    class Email {


    /**
     * Send Email without Auth
     *
     * @param string $subj    message title
     * @param email $reciver reciver email
     * @param email $sender  sender email
     * @param text $msg     message body
     */
    public static function Send($subj, $reciver, $sender, $msg) {
      $headers = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html;charset=utf8' . "\r\n";
      $headers .= "from: " . $sender . "\r\n";
      $msg_body = '
      <html>
      <head>
        <div style="
        background-color:#f9f9f9;
        font-family:tahoma;
        padding: 20px;
        font-size:18px;
        color:#123;
        width: 88%;
        margin: auto;
        border: 1px solid #c3d9ff;
        box-shadow: 0 2px 2px 0 #C3D9FF;
        border-radius: 5px;
        ">' . $msg . '
      </div>';
      $send = mail($reciver, $subj, $msg_body, $headers);
      return $send;
    }


    /**
     * Send  smtp Email
     *
     * @param string $subj    message title
     * @param email $reciver reciver email
     * @param email $sender  sender email
     * @param text $msg     message body
     */
    public static function smtp($subj, $reciver, $sender, $msg)
    {
      $mail = new \PHPMailer;
      $mail->CharSet = 'UTF-8';
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPDebug =null; /*1 | 2*/

      $mail->SMTPOptions = array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
          )
        );

      $mail->Host = mail_host;
      $mail->Username = mail_user;
      $mail->Password = mail_pass;

      $mail->Port = mail_port ;

      $mail->From = !$sender ? site_email : $sender ;
      $mail->FromName = site_name;
      $mail->addAddress($reciver);

      $mail->addReplyTo($GLOBALS['email_set_addReplyTo']);

      $message = '<div style="
      background-color:#f9f9f9;
      font-family:tahoma;
      padding: 20px;
      font-size:18px;
      color:#123;
      width: 88%;
      margin: auto;
      border: 1px solid #c3d9ff;
      box-shadow: 0 2px 2px 0 #C3D9FF;
      border-radius: 5px;
      ">' . $msg . '
    </div>';

    $mail->Subject = $subj;
    $mail->Body    = $message;
    $mail->AltBody = $msg;

    $mail->isHTML(true);

    if(!$mail->send()) {
      echo '<h3>Message could not be sent.</h3>';
      echo '<b>Mailer Error: </b>' . $mail->ErrorInfo;
    } else {
            // echo pre('Message has been sent','','','#F00');
      return true;
    }

  }

  public function sms(array $args)
  {
    $API_KEY = "167cb1baa74d412a582f07a1d70ee81d228f83d5";

    if(!$args)
      throw new Exception("agrs Exceptions!", 1);
    else{
      extract($args);
                //tel , msg

      try
      {
        /* Create a Clockwork object using your API key*/
        $clockwork = new Clockwork( $API_KEY );

        /* Setup and send a message*/
        $message = array( 'to' => $tel, 'message' => $msg );
        $result = $clockwork->send( $message );

        /* Check if the send was successful*/
        if($result['success']) {
                        // echo 'Message sent - ID: ' . $result['id'];
        } else {
          die( 'Message failed - Error: ' . $result['error_message'] );
        }
      }
      catch (ClockworkException $e)
      {
        echo 'Exception sending SMS: ' . $e->getMessage();
      }

    }


  }

}
