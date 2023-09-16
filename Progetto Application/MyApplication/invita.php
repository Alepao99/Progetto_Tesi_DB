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
        if (isset($_POST['acquisti'])) {
            $cod = $_POST['prenotazione'];
            $iddisciplina = $_POST['iddisciplina'];
            $titolo = $_POST['titolo'];
            $luogo = $_POST['luogo'];
            $descrizione = $_POST['descrizione'];
            $timeStart = $_POST['timeStart'];
            $timeEnd = $_POST['timeEnd'];
            $data = $_POST['data'];
            $codiceEvento = $_POST['codiceEvento'];
            insertInvitoCondiviso($cod, $user, $iddisciplina, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento);
        }
        if (isset($_POST['utenteApp'])) {
            $cod = $_POST['prenotazione'];
            $iddisciplina = $_POST['iddisciplina'];
            $titolo = $_POST['titolo'];
            $luogo = $_POST['luogo'];
            $descrizione = $_POST['descrizione'];
            $timeStart = $_POST['timeStart'];
            $timeEnd = $_POST['timeEnd'];
            $data = $_POST['data'];
            $codiceEvento = $_POST['codiceEvento'];
            $utenteApp = $_POST['utenteApp'];
            insertInvitoPrivato($cod, $user, $iddisciplina, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utenteApp);
        }
        if (isset($_POST['attesaUtente'])) {
            $cod = $_POST['prenotazione'];
            $iddisciplina = $_POST['iddisciplina'];
            $titolo = $_POST['titolo'];
            $luogo = $_POST['luogo'];
            $descrizione = $_POST['descrizione'];
            $timeStart = $_POST['timeStart'];
            $timeEnd = $_POST['timeEnd'];
            $data = $_POST['data'];
            $codiceEvento = $_POST['codiceEvento'];
            $utenteApp = $_POST['attesaUtente'];
            $costo = $_POST['costo'];
            insertInvitoPrivatoAttesa($cod, $user, $iddisciplina, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utenteApp, $costo);
        }
        if (isset($_POST['utentiApp'])) {
            $cod = $_POST['prenotazione'];
            $iddisciplina = $_POST['iddisciplina'];
            $titolo = $_POST['titolo'];
            $luogo = $_POST['luogo'];
            $descrizione = $_POST['descrizione'];
            $timeStart = $_POST['timeStart'];
            $timeEnd = $_POST['timeEnd'];
            $data = $_POST['data'];
            $codiceEvento = $_POST['codiceEvento'];
            $utentiApp = $_POST['utente'];
            insertInvitoPrivatoMultiplo($cod, $user, $iddisciplina, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utentiApp);
        }
        if (isset($_POST['utentiAttesa'])) {
            $cod = $_POST['prenotazione'];
            $iddisciplina = $_POST['iddisciplina'];
            $titolo = $_POST['titolo'];
            $luogo = $_POST['luogo'];
            $descrizione = $_POST['descrizione'];
            $timeStart = $_POST['timeStart'];
            $timeEnd = $_POST['timeEnd'];
            $data = $_POST['data'];
            $codiceEvento = $_POST['codiceEvento'];
            $utentiApp = $_POST['utente'];
            $costo = $_POST['costo'];
            insertInvitoPrivatoMultiploAttesa($cod, $user, $iddisciplina, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utentiApp, $costo);
        }
        if (isset($_POST['attesaGruppo'])) {
            $cod = $_POST['prenotazione'];
            $iddisciplina = $_POST['iddisciplina'];
            $titolo = $_POST['titolo'];
            $luogo = $_POST['luogo'];
            $descrizione = $_POST['descrizione'];
            $timeStart = $_POST['timeStart'];
            $timeEnd = $_POST['timeEnd'];
            $data = $_POST['data'];
            $codiceEvento = $_POST['codiceEvento'];
            $costo = $_POST['costo'];
            insertInvitoAttesaGruppo($cod, $user, $iddisciplina, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $costo);
        }

        $ret = esecuzionePropostaInvitate($user); ?>
        <?php include "Collegamenti/headerUser.php"; ?>
        <div class="container_tracks">
            <div class="container_tracks_title tw normal-text">
            </div>
            <div class="container_tracks_tracks">
                <div class="tracks_tracks_subTitle"><em>Inviti eseguiti</em></div>
                <div class="container_grid">
                    <?php
                    pg_result_seek($ret, 0);
                    while ($row = pg_fetch_array($ret)) {
                        $nome = $row['nome'];
                        $cognome = $row['cognome'];
                        $disciplina = $row['disciplina'];
                        $struttura = $row['struttura'];
                        $esito = $row['esito'];
                        $var = $row['immagine'];
                        $data = $row['data'];
                        $oraInizio = $row['orainizio'];
                        $oraFine = $row['orafine'];
                        $img = pg_unescape_bytea($var);
                        print "<div class='col'>
                                      <div class = 'elemtImg'><img src=\"Img/$img\"></div>
                                      <div class = 'cell'>
                                            <p class = 'general'>
                                                <strong>Hai invitato</strong> <em>$nome $cognome</em>
                                                <strong>per giocare a</strong> <em>$disciplina</em><br/>
                                                <strong>alla struttura</strong> <em>$struttura</em><br/>
                                                <strong>Evento che si terr&agrave; il </strong> <em>$data</em><br/>
                                                <strong>dalle</strong> <em>$oraInizio</em><br/> <strong>alle</strong> <em>$oraFine</em>
                                            </p>
                                        </div>
                                ";
                        if ($esito == 'Accettato') {
                            print "<p class = 'general' style='text-align: center;color: green;'>Esito Accettato</p>
                                    <div class = 'decision'>
                                    <div title= 'Invito confermato' class='botton confirm'>&#10004</div>
                                </div>";
                        } else if ($esito == 'Attesa') {
                            print "<p class = 'general' style='text-align: center;color: orange;'>Esito in Attesa</p>
                                    <div class = 'decision'>
                                    <div title= 'In attesa di conferma' class='botton wait'></div>
                                </div>";
                        } else {
                            print "<p class = 'general' style='text-align: center;color: red;'>Esito Rifiutato</p>
                                    <div class = 'decision'>
                                    <div title= 'Invito rifiutato' class='botton rifiutato'></div>
                                </div>";
                        }
                        print "</div>";
                    }
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