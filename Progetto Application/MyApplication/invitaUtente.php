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
    if (isset($_SESSION['email'])) {
        $user = getCFUser($_SESSION['email']);
        $ret = allUsers($user);
        $codPrenotazione = $_POST['prenotazione'];
        $iddisciplina = $_POST['iddisciplina'];
        $titolo = $_POST['titolo'];
        $indirizzo = $_POST['luogo'];
        $descrizione = $_POST['descrizione'];
        $timeStart = $_POST['timeStart'];
        $timeEnd = $_POST['timeEnd'];
        $data = $_POST['data'];
        $codiceEvento = $_POST['codiceEvento'];
    ?>
        <?php include "Collegamenti/headerUser.php"; ?>
        <div class="container_tracks">
            <div class="container_tracks_title tw normal-text">
            </div>
            <div class="container_tracks_tracks" id="contenuto">
                <div class="tracks_tracks_subTitle"><em>Invita un utente</em></div>
                <div class="invitaClass" onclick="mostra('contenuto','contenuto_Utente')">Invita pi&ugrave; utenti</div>
                <div class="container_grid" id="tutto">
                    <?php
                    pg_result_seek($ret, 0);
                    while ($row = pg_fetch_array($ret)) {
                        $cf = $row['cf'];
                        $nome = $row['nome'];
                        $cognome = $row['cognome'];
                        $var = $row["immagine"];
                        $img = pg_unescape_bytea($var);
                        $retD = discSelectUser($cf);
                        print "<div class='col'>
                                 <div class = 'elemtImg'><img src=\"Img/$img\"></div>
                             <div class = 'cell'>
                                <p class = 'general'>
                                <strong>Nome:</strong> <em>$nome</em>
                                <strong>Cognome:</strong> <em>$cognome</em><br/>
                                <strong>Discipline preferite:</strong> ";
                        pg_result_seek($retD, 0);
                        while ($row2 = pg_fetch_array($retD)) {
                            $disciplina = $row2['disciplina'];
                            print "<br/><em>$disciplina</em>";
                        }
                        print "</p>";
                        print "
                            </div>
                                 <div class = 'decision'>
                                 ";
                            if(isset($_POST['acquisti'])){
                                print "
                                    <form action='invita.php' method='post'>
                                    <input type='hidden' name='prenotazione' value='$codPrenotazione'>
                                    <input type='hidden' name='iddisciplina' value='$iddisciplina'>
                                    <input type='hidden' name='titolo' value='$titolo'>
                                    <input type='hidden' name='luogo' value='$indirizzo'>
                                    <input type='hidden' name='descrizione' value='$descrizione'>
                                    <input type='hidden' name='timeStart' value='$timeStart'>
                                    <input type='hidden' name='timeEnd' value='$timeEnd'>                                        
                                    <input type='hidden' name='data' value='$data'>
                                    <input type='hidden' name='codiceEvento' value='$codiceEvento'>   
                                    <input type='hidden' name='utenteApp' value='$cf'>  
                                    <input type='submit' class='navBar'  value='Invita $nome'>
                                    </form>";
                                 }
                                 if (isset($_POST['attesaUtente'])){
                                    $costo = $_POST['costo'];
                                    print "
                                <form action='invita.php' method='post'>
                                    <input type='hidden' name='prenotazione' value='$codPrenotazione'>
                                    <input type='hidden' name='iddisciplina' value='$iddisciplina'>
                                    <input type='hidden' name='titolo' value='$titolo'>
                                    <input type='hidden' name='luogo' value='$indirizzo'>
                                    <input type='hidden' name='descrizione' value='$descrizione'>
                                    <input type='hidden' name='timeStart' value='$timeStart'>
                                    <input type='hidden' name='timeEnd' value='$timeEnd'>                                        
                                    <input type='hidden' name='data' value='$data'>
                                    <input type='hidden' name='codiceEvento' value='$codiceEvento'>   
                                    <input type='hidden' name='attesaUtente' value='$cf'>
                                    <input type='hidden' name='costo' value='$costo'>
                                    <input type='submit' class='navBar'  value='Invita $nome'>
                                    </form>";
                                 }
                                 print "
                                </div>
                            </div>";
                    }

                    ?>
                </div>
            </div>
            <div class="wrapper wrapper--upload" style="margin-top: 20px; display:none;margin-left: 460px;" id="contenuto_Utente">
                <div style="margin-left: -480px;">
                    <div class="tracks_tracks_subTitle"><em>Invita pi&ugrave; utenti</em></div>
                    <div class="invitaClass" onclick="mostra('contenuto','contenuto_Utente')">Invita un utente</div>
                </div>
                <section class="form login small-text" style="margin-bottom: -20px;margin-top: -115px;">
                    <header>Invita pi&ugrave; utenti!</header>
                    <form method='post' action='invita.php' name = "modulo">
                        
                        <div class="field">
                            <?php
                                pg_result_seek($ret, 0);
                                while ($row = pg_fetch_array($ret)) {
                                    $cf = $row['cf'];
                                    $nome = $row['nome'];
                                    $cognome = $row['cognome'];
                                    $retD = discSelectUser($cf);
                                    print " <div class = 'uploadUtents'><div><strong>$nome $cognome,</strong> Discipline preferite: ";
                                    pg_result_seek($retD, 0);
                                    while ($row2 = pg_fetch_array($retD)) {
                                        $disciplina = $row2['disciplina'];
                                        print "<em>$disciplina</em> ";
                                    }
                                    print "</div>
                                    <div>
                                        <input type='checkbox' name = 'utente[]' value='$cf'>
                                    </div>
                                </div></br>";
                                }
                                if(isset($_POST['acquisti'])){
                                print "
                                <input type='hidden' name='prenotazione' value='$codPrenotazione'>
                                <input type='hidden' name='iddisciplina' value='$iddisciplina'>
                                <input type='hidden' name='titolo' value='$titolo'>
                                <input type='hidden' name='luogo' value='$indirizzo'>
                                <input type='hidden' name='descrizione' value='$descrizione'>
                                <input type='hidden' name='timeStart' value='$timeStart'>
                                <input type='hidden' name='timeEnd' value='$timeEnd'>                                        
                                <input type='hidden' name='data' value='$data'>
                                <input type='hidden' name='codiceEvento' value='$codiceEvento'>   
                                <input type='hidden' name='utentiApp'>";
                                }
                                if(isset($_POST['attesaUtente'])){
                                    $costo = $_POST['costo'];
                                print "<input type='hidden' name='prenotazione' value='$codPrenotazione'>
                                <input type='hidden' name='iddisciplina' value='$iddisciplina'>
                                <input type='hidden' name='titolo' value='$titolo'>
                                <input type='hidden' name='luogo' value='$indirizzo'>
                                <input type='hidden' name='descrizione' value='$descrizione'>
                                <input type='hidden' name='timeStart' value='$timeStart'>
                                <input type='hidden' name='timeEnd' value='$timeEnd'>                                        
                                <input type='hidden' name='data' value='$data'>
                                <input type='hidden' name='codiceEvento' value='$codiceEvento'>   
                                <input type='hidden' name='costo' value='$costo'>
                                <input type='hidden' name='utentiAttesa'>";
                                }
                                print "</div>";
                                ?>
                            <div class="field button">
                                <input id='sel' type = "button" value="Seleziona tutto" onclick="SelezTT('sel','desc')">
                                <input id='desc' style = "display:none" type = "button" value="Deleziona tutto" onclick="SelezTT('desc','sel')">
                                <input type='submit' value='invita'>
                            </div>
                    </form>

            </div>
        </div>

        <?php include "Collegamenti/footer.html"; ?>
    <?php
    } else {
        header("location: /MyApplication/login.php");
    }
    ?>
    <script src="Java/pass.js"></script>
</body>

</html>