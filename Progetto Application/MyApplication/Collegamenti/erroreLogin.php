<div class="wrapper">
    <section class="form login">
        <header>SportClub Login</header>
        <p class="error_text">Errore in login!</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="field input">
                <label for="">Indirizzo Email</label>
                <input type="text" name="email" placeholder="Email" required>
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