<div class="wrapper">
    <section class="form signup">
        <header>SportClub Registrazione</header>
        <p class="error_text">Errore in Registrazione!</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="info_utente">
                <div class="field input">
                    <label for="">Username</label>
                    <input type="text" name="username" placeholder="Username" required />
                </div>
                <div class="field input">
                    <label for="">Indirizzo Email</label>
                    <input type="email" name="email" placeholder="Email" required />
                </div>
            </div>
            <div class="field input">
                <label for="">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required />
                <i class="icon" onclick="visibilitapass();"></i>
            </div>
            <div class="field input">
                <label for="">Repassword</label>
                <input type="password" name="repassword" id="repassword" placeholder="Repassword" required />
                <i class="icon" onclick="visibilitarepass();"></i>
            </div>
            <div class="field button">
                <input type="submit" value="Accedi">
            </div>
        </form>
        <div class="link small-text">Sei registrato? <a href="login.php">Loggati!</a></div>
    </section>
</div>