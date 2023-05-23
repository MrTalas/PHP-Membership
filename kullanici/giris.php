<?php
    session_start();
    include("../back-end/function/func.php");
    $db = new db();
    $char = new char();
    $user = new user();
    $db->connect("localhost","uyelik","root","");

    $username = NULL;
    $password = NULL;
    $durum = 0;

    if($_GET){
      $username = $_GET['username'] ?? NULL;
      $password = $_GET['password'] ?? NULL;
      if($username && $password){
        $durum=1;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
      }
    }

    else if(isset($_SESSION['username']) && isset($_SESSION['password'])){
      $username = $_SESSION['username'] ?? NULL;
      $password = $_SESSION['password'] ?? NULL;
      if($db->user_check("user",$_SESSION['username'],$_SESSION['password'])>0){
        header("Location:../panel/pages/dash.php");  
      }
      else{
          header("Location:kullanici/giris.php");
      }
    }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Üye giriş</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.2/tailwind.min.css'>

</head>
<body>
<!-- partial:index.partial.html -->
<section class="flex flex-col md:flex-row h-screen items-center">

  <div class="bg-blue-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
    <img src="https://images.unsplash.com/photo-1444313431167-e7921088a9d3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1441&q=100" alt="" class="w-full h-full object-cover">
  </div>

  <div class="bg-white w-full md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12
        flex items-center justify-center">

    <div class="w-full h-100">

      <h1 class="text-xl md:text-2xl font-bold leading-tight mt-12">Hesabınıza giriş yapın</h1>

      <form class="mt-6" action="../back-end/db/controls.php?rol=user" action="../back-end/db/controls.php" method="POST">
        <div>
          <label class="block text-gray-700">E-posta</label>
          <?php
          echo '<input type="text" value="'.$username.'" name="username" id="" placeholder="E-posta adresinizi giriniz" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none" autofocus autocomplete required>';
          ?>
        </div>

        <?php
        if($durum==0){
          echo '<div class="mt-4">
            <label class="block text-gray-700">Parola</label>
            <input value="'.$password.'" type="password" name="password" id="" placeholder="Parola giriniz" minlength="6" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500
                  focus:bg-white focus:outline-none" required>
          </div>';
        }
        else if($durum==1){
          echo '<div class="mt-4">
            <label class="block text-gray-700">Parola</label>
            <input value="'.$password.'" type="text" name="password" id="" placeholder="Parola giriniz" minlength="6" class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500
                  focus:bg-white focus:outline-none" required>
          </div>';
        }
        ?>

        <div class="text-right mt-2">
          <a href="#" class="text-sm font-semibold text-gray-700 hover:text-blue-700 focus:text-blue-700">Parolanızı mı unuttunuz?</a>
        </div>

        <button type="submit" class="w-full block bg-blue-500 hover:bg-blue-400 focus:bg-blue-400 text-white font-semibold rounded-lg
              px-4 py-3 mt-6">Giriş yap</button>
      </form>

      <hr class="my-6 border-gray-300 w-full">



      <p class="mt-8">Hesabınız yok mu?<a href="pass_generator.php" class="text-blue-500 hover:text-blue-700 font-semibold"> Tek tıkla hesap oluştur</a></p>

    </div>
  </div>

</section>
<!-- partial -->
  
</body>
</html>
