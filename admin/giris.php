<?php
  session_start();
  include("../back-end/function/func.php");
  $db = new db();
  $char = new char();
  $user = new user();
  $db->connect("localhost","uyelik","root","");
  
  if(isset($_SESSION['username']) && isset($_SESSION['password'])>0){
    if($db->user_check("admin",$_SESSION['username'],$_SESSION['password'])>0){
      header("Location:../panel/index.php");
    }
    else if($db->user_check("user",$_SESSION['username'],$_SESSION['password'])>0){
      header("Location:../kullanici/giris.php");
    }
    exit();
}
  if($_GET){
    $hata = $_GET['hata'] ?? NULL;
  }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Yönetim Paneli Giriş</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<canvas id="svgBlob"></canvas>

<div class="position">
  <form action="../back-end/db/controls.php?rol=admin" method="post" class="container">
    <div class="centering-wrapper">
      <div class="section1 text-center">
        <div class="primary-header">Hoşgeldin admin !</div>
        <div class="input-position">
	  <div class="form-group">
            <h5 class="input-placeholder" id="email-txt">E-posta<span class="error-message" id="email-error"></span></h5>
	    <input type="text" required="true" name="username" class="form-style" id="logemail" autocomplete="off" style="margin-bottom: 20px;">
	    <i class="input-icon uil uil-at"></i>
	  </div>	
          <div class="form-group">
            <h5 class="input-placeholder" id="pword-txt">Parola<span class="error-message" id="password-error"></span></h5>
	    <input type="password" required="true" name="password" class="form-style" id="logpass" autocomplete="on">
	    <i class="input-icon uil uil-lock-alt"></i>
	  </div>
        </div>
        <?php
          if($_GET){
            if($hata==1){
              echo '<p style="margin-top:30px;color:red;">Kullanıcı adı veya parola yanlış !</p>';
              header("Refresh: 3; url=giris.php");
            }
          }
        ?>
          <div style="margin-top:30px;" class="btn-position">
          <a style="display:none;" href="../back-end/db/controls.php?rol=admin" class="btn">Giriş yap</a>
          <input type="submit" class="btn">
        </div>
      </div>
      <div class="horizontalSeparator"></div>
      <div class="qr-login">
        <div class="qr-container">
          <img class="logo" src="https://cdn.discordapp.com/attachments/742854174324031528/771346778356318248/ChallengerCarl_2.png"/>
          <canvas id="qr-code"></canvas>
        </div>
        <div class="qr-pheader">Log in with QR Code</div>
        <div class="qr-sheader">Scan this with the <strong>scanner app </strong>to log in instantly.</div>
      </div>
    </div>
  </form>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js'></script><script  src="./script.js"></script>

</body>
</html>
