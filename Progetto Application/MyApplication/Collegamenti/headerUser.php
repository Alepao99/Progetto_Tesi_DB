    <div class="header normal-text">
        <div class="logo"><img src="Img/logo.png"></div>
        <ul class="menu">
            <li>
                <div class="container_info">
                    <div class="information tw">Ciao <?php echo "" . $_SESSION['email'] ?></div>
                </div>
            </li>
            <li><a href="index.php">Home</a></li>
            <li><a href="acquisti.php">Acquisti</a></li>
            <li><a href="attesa.php">Attesa</a></li>
            <li><a href="invita.php">Inviti effettuati</a></li>
        </ul>
        <ul class="menu--log">
            <?php
            $uss = getCFUser($_SESSION['email']);
            $tot = checkQuantita($uss);
            if ($tot > '0') {
                print "
                <div class='check'>
                    <img src = 'Img/notification.png' type = 'img/png'/>
                    <p class = 'numb'>$tot</p> 
                </div>
                <li><a href='notifiche.php'>Notifiche Invito</a></li>";
            } else {
                print "<li><a href='notifiche.php'>Notifiche Invito</a></li>";
            }
            ?>

            <li><a href="delete.php?delete=true">Drop Account</a></li>
            <li><a href="logout.php?logout=true">Logout</a></li>
        </ul>
        </li>
    </div>