<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="charset" content="utf-8" />
    <meta name="author" content="Gruppo TSW" />
    <meta name="description" content="Un sito per Audio" />
    <meta name="keywords" content="Audio, TSW, Web" />
    <link rel="icon" href="Img/iconaSito.png" type="image/X-icon" />
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;900&display=swap" rel="stylesheet">
    <title>Tesi</title>
</head>

<body>
    <?php include "funzioniphp.php"; ?>
    <?php include "Collegamenti/header.html"; ?>

    <?php
    if (isset($_COOKIE['email'])) {
        session_start();
        $_SESSION['email'] = $_COOKIE['email'];
        header("location: /MyApplication/index.php");
    } else if (empty($_POST['email']) and empty($_POST['password'])) {
    ?>
        <div class="wrapper">
            <section class="form login">
                <header>SportClub Login</header>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="field input">
                        <label>Indirizzo Email</label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class="icon" onclick="visibilitapass();"></i>
                    </div>
                    <div class="field button">
                        <input type="submit" value="Accedi">
                    </div>
                </form>
                <div class="link small-text">Non sei ancora registrato? <a href="register.php"> Registrati!</a></div>
            </section>
        </div>
    <?php
    } else {
        $user =  $_POST['email'];
        $pass =  $_POST['password'];
        $hash = get_pwd($user);
      //  if (!$hash) {
        //    echo '<script type = "text/javascript"> alert("Account non esistente"); </script>';
          //  include "Collegamenti/erroreLogin.php";
       // } else {
           // if (password_verify($pass, $hash)) {
                session_start();
                setcookie("email", get_username($user), time() + 86400 * 365, "/");
                $_SESSION['email'] = $_COOKIE['email'];
               header("location: /MyApplication/index.php");
           // } else {
            //    echo '<script type = "text/javascript"> alert("Password errata"); </script>';
            //    include "Collegamenti/erroreLogin.php";
          //  }
        //}
    }
    ?>
    <?php include "Collegamenti/footer.html" ?>

    <script src="Java/pass.js"></script>

</body>

</html>