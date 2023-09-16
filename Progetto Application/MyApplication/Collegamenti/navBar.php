<div class="par" id="menu1" onmouseover="mostraMenu('1')" onmouseout="nascondiMenu('1')">
    <div id="titolo1" class="titolo">Discipline</div>
    <div id="scelte1" class="scelte">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="submit" class="navBar" name="boxe" value="Boxe"></input>
            <input type="submit" class="navBar" name="zumba" value="Zumba"></input>
            <input type="submit" class="navBar" name="spinning" value="Spinning"></input>
            <input type="submit" class="navBar" name="beachVolley" value="Beach Volleyball"></input>
        </form>
    </div>
</div>
<div class="par" id="menu2" onmouseover="mostraMenu('2')" onmouseout="nascondiMenu('2')">
    <div id="titolo2" class="titolo">Prenotazioni</div>
    <div id="scelte2" class="scelte">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="submit" class="navBar" name="effettuate" value="Acquisti"></input>
            <input type="submit" class="navBar" name="attesa" value="In attesa"></input>
        </form>
    </div>
</div>
<div class="par">
    <div id="titolo3" class="titolo"><a class="tw" href="amici.php">Amici</a></div>
</div>
<div class="par" id="menu4" onmouseover="mostraMenu('4')" onmouseout="nascondiMenu('4')">
    <div id="titolo4" class="titolo">Opzioni utente</div>
    <div id="scelte4" class="scelte">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="submit" class="navBar" name="audioCaricato" value="Audio Caricato"></input>
        </form>
        <a class="menubar" href="upload.php" target="_self">Inserisci</a>
    </div>
</div>