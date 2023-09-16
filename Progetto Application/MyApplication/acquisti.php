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
    <?php



include "funzioniphp.php"; ?>

    <?php
    session_start();
    if (isset($_SESSION['email'])) {
        $user = getCFUser($_SESSION['email']);
        if (isset($_POST['id'])) {
            $pr = $_POST['id'];
            $titolo = $_POST['titolo'];
            $luogo = $_POST['luogo'];
            $descrizione = $_POST['descrizione'];
            $timeStart = $_POST['timeStart'];
            $timeEnd = $_POST['timeEnd'];
            $idDisciplina = $_POST['idDisciplina'];
            $data = $_POST['data'];
            $societa = $_POST['societa'];
            insertPrenotazione($pr, $user, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $idDisciplina, $data, $societa);
        }
        $ret = esecuzionePropostaAcquistata($user); ?>
        <?php include "Collegamenti/headerUser.php"; ?>
        <div class="container_tracks">
            <div class="container_tracks_title tw normal-text">
            </div>
            <div class="container_tracks_tracks">
                <div class="tracks_tracks_subTitle"><em>I tuoi acquisti</em></div>
                <div class="container_grid">
                    <?php
                    pg_result_seek($ret, 0);
                    while ($row = pg_fetch_array($ret)) {
                        $codPrenotazione = $row['codice'];
                        $titolo = $row['titolo'];
                        $costo = $row['costo'];
                        $oraInizio = $row['orainizio'];
                        $oraFine = $row['orafine'];
                        $data = $row['data'];
                        $strutturaNome = $row['struttura'];
                        $condiviso = $row['condiviso'];
                        $iddisciplina = $row['iddisciplina'];
                        $indirizzo = $row['luogo'];
                        $descrizione = $row['descrizione'];
                        $codiceEvento = $row['evento'];
                        $var = $row["immagine"];
                        $attesa = $row["attesa"];
                        $conferma = $row["conferma"];
                        $img = pg_unescape_bytea($var);
                        print "<div class='col'>
                        <div class = 'elemtImg'><img src=\"Img/$img\"></div>
                                     <div class = 'cell'>
                                <p class = 'general'>
                                <br/>
                                <strong>Disciplina:</strong> <em>$titolo; </em><br/> 
                                <strong>Struttura:</strong> <em>$strutturaNome; </em><br/>
                                <strong>Indirizzo:</strong> <a href='https://www.google.it/maps/place/$indirizzo;' style = 'color:white' title='Vedi il luogo' target='_blanck'><em>$indirizzo;</em></a><br/><br/>
                                <strong>Quando:</strong> <em>$data</em><br/>
                                <strong>Inizio:</strong> <em>$oraInizio</em><br/>
                                <strong>Fine:</strong> <em>$oraFine</em><br/><br/>
                                <strong>Prezzo:</strong> <em>$costo €</em>
                                </p>
                            </div>
                                ";
                        if ($condiviso == 't' && $attesa == 'f') {
                            print "<div class = 'decision'>
                                    <form action='invita.php' method='post'>
                                        <input type='hidden' name='prenotazione' value='$codPrenotazione'>
                                        <input type='hidden' name='iddisciplina' value='$iddisciplina'>
                                        <input type='hidden' name='titolo' value='$titolo'>
                                        <input type='hidden' name='luogo' value='$indirizzo'>
                                        <input type='hidden' name='descrizione' value='$descrizione'>
                                        <input type='hidden' name='timeStart' value='$oraInizio'>
                                        <input type='hidden' name='timeEnd' value='$oraFine'>                                        
                                        <input type='hidden' name='data' value='$data'>
                                        <input type='hidden' name='codiceEvento' value='$codiceEvento'>
                                        <input type='hidden' name='acquisti'>   
                                        <input type='submit' class='navBar formsub' value = 'Invita il tuo gruppo'></input>
                                    </form>
                                    <form action='invitaUtente.php' method='post'>
                                    <input type='hidden' name='prenotazione' value='$codPrenotazione'>
                                    <input type='hidden' name='iddisciplina' value='$iddisciplina'>
                                    <input type='hidden' name='titolo' value='$titolo'>
                                    <input type='hidden' name='luogo' value='$indirizzo'>
                                    <input type='hidden' name='descrizione' value='$descrizione'>
                                    <input type='hidden' name='timeStart' value='$oraInizio'>
                                    <input type='hidden' name='timeEnd' value='$oraFine'>                                        
                                    <input type='hidden' name='data' value='$data'>
                                    <input type='hidden' name='codiceEvento' value='$codiceEvento'>
                                    <input type='hidden' name='acquisti'>    
                                    <input type='submit' class='navBar formsub' value = 'Invita un Utente'></input>
                                </form>
                                </div>";
                        }
                        if ($attesa == 't' && $conferma == 'f') {
                            $dataesito = $row['esitod'];
                            resetConferma($codPrenotazione);
                            echo '<script type = "text/javascript"> alert("Pagamento condiviso del servizio ' . $titolo . ' in attesa del ' . $data . ' eseguito il ' . date("Y-m-d", strtotime($dataesito)) . '"); </script>';
                        }
                        print " <div class = ''>
                                    <div title= 'Acquisto confermato' class='botton confirm'>&#10004</div>
                                </div> 
                            </div>";
                    }
                    print "</div>";
                    ?>
                </div>
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