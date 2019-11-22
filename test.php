<?php

function decodeBody($body) {
    $rawData = $body;
    $sanitizedData = strtr($rawData,'-_', '+/');
    $decodedMessage = base64_decode($sanitizedData);
    if(!$decodedMessage){
        $decodedMessage = FALSE;
    }
    return $decodedMessage;
}

  session_start();
  require __DIR__ . '/vendor/autoload.php';


  // Replace this with your Google Client ID
  $client_id     = '427713525737-0v42i0hponsg1g3rj180rbcpi3cqpr71.apps.googleusercontent.com';
  $client_secret = '8D_z1b6q6-Ry4Xfr7n50BzsH';
  $redirect_uri  = 'https://localhost/MailList/test.php'; // Change this

  $client = new Google_Client();
  $client->setClientId($client_id);
  $client->setClientSecret($client_secret);
  $client->setRedirectUri($redirect_uri);

  // We only need permissions to compose and send emails
  $client->addScope("https://mail.google.com/");
  $service = new Google_Service_Gmail($client);

  // Redirect the URL after OAuth
  if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
  }

  // If Access Toket is not set, show the OAuth URL
  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
  } else {
    $authUrl = $client->createAuthUrl();
  }

  if ($client->getAccessToken() && isset($_POST['message'])) {

    $_SESSION['access_token'] = $client->getAccessToken();

    // Prepare the message in message/rfc822

    $strSubject = 'Test mail using GMail API' . date('M d, Y h:i:s A');
    $strRawMessage = "From: <mail.brandonj@gmail.com>\r\n";
    $strRawMessage .= "To: <mail.brandonj@gmail.com>\r\n";
    $strRawMessage .= 'Subject: =?utf-8?B?' . base64_encode($strSubject) . "?=\r\n";
    $strRawMessage .= "MIME-Version: 1.0\r\n";
    $strRawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
    $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
    $strRawMessage .= $_POST['message'];

    try {

        // The message needs to be encoded in Base64URL
        $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        $service->users_messages->send("me", $msg);

    } catch (Exception $e) {
        print($e->getMessage());
        unset($_SESSION['access_token']);
    }

  } ?>

 <? if ( isset ( $authUrl ) ) { ?>
  <a href="<?= $authUrl; ?>"><img src="google.png" title="Sign-in with Google" /></a>
 <? } else {
       
} ?>