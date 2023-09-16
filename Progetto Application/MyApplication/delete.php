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

    <?php
    session_start();
    if (isset($_GET['delete'])) {
        $user = $_SESSION['email'];
        if (!deleteAccount($user))
            exit;
        setcookie("email", '', time() - 3600, '/');
    }
    header("location: /MyApplication/index.html");
    ?>
    <script src="Java/pass.js"></script>
</body>

</html>