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
    if (empty($_POST['username']) and empty($_POST['email']) and empty($_POST['password'])) {
    ?>
        <?php include "Collegamenti/formRegister.php" ?>
        <?php
    } else {
        if (isset($_POST['username']))
            $nome = $_POST['username'];
        else {
            $nome = "";
        }
        if (isset($_POST['email']))
            $user = $_POST['email'];
        else
            $user = "";
        if (isset($_POST['password']))
            $pass = $_POST['password'];
        else
            $pass = "";
        if (isset($_POST['repassword']))
            $repassword = $_POST['repassword'];
        else
            $repassword = "";
        if (!empty($pass)) {
            if ($pass != $repassword) {
                $pass = "";
                echo '<script type = "text/javascript"> alert("Errore in Repassword"); </script>';
        ?>
                <?php include "Collegamenti/erroreRegister.php" ?>
                <?php
            } else {
                if (email_exist($user) || username_exist($nome)) {
                    echo '<script type = "text/javascript"> alert("Account esistente"); </script>';
                ?>
                    <?php include "Collegamenti/erroreRegister.php" ?>
                    <?php
                } else {
                    if (insert_utente_no_pass($user,$nome,$pass)) {
                    ?>
                        <div class="wrapper">
                            <section class="form signup">
                                <header>Registrazione eseguita con successo</header>
                                <p class="confirm_text">Benvenuto <?php echo $nome ?> Puoi accedere alla nostra App!</p>
                                <div class="link small-text">Vai al <a href="login.php">LOGIN</a></div>
                            </section>
                        </div>
                    <?php
                    } else {
                        echo '<script type = "text/javascript"> alert("Errore 404"); </script>';
                    ?>
                        <?php include "Collegamenti/erroreRegister.php" ?>

    <?php
                    }
                }
            }
        }
    }
    ?>

    <?php include "Collegamenti/footer.html" ?>

    <script src="Java/pass.js"></script>
</body>

</html>