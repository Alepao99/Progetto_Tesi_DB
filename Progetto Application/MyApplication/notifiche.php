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
        if (isset($_POST['accetto'])) {
            $cod = $_POST['accetto'];
            $status = "accepted";
            confirmNot($cod, $user);
            //$codiceEvento = $_POST['eventID'];
           // updateClient($user,$status,$codiceEvento);
        }
        if (isset($_POST['nok'])) {
            $cod = $_POST['nok'];
            $status = "declined";
            refuseNot($cod, $user);
           // $codiceEvento = $_POST['eventID'];
        //    updateClient($user,$status,$codiceEvento);
        }

        $ret = esecuzioneInviti($user); ?>
        <?php include "Collegamenti/headerUser.php"; ?>
        <div class="container_tracks">
            <div class="container_tracks_title tw normal-text">
            </div>
            <div class="container_tracks_tracks">
                <div class="tracks_tracks_subTitle"><em>Centro notifiche</em></div>
                <div class="container_grid">
                    <?php
                    pg_result_seek($ret, 0);
                    while ($row = pg_fetch_array($ret)) {
                        $nome = $row['nome'];
                        $disciplina = $row['disciplina'];
                        $struttura = $row['struttura'];
                        $indirizzo = $row['indirizzo'];
                        $data = $row['data'];
                        $orainizio = $row['orainizio'];
                        $orafine = $row['orafine'];
                        $costo = $row['costo'];
                        $posti = $row['numeroposti'];
                        $costoridotto =  $costo/$posti;
                        $cod = $row['codice'];
                        $esito = $row['esitoprenotazione'];
                        $codiceEvento = $row['evento'];
                        $descrizione = $row['invitodescri'];
                        $var = $row["invitanteimg"];
                        $img = pg_unescape_bytea($var);  
                        print "<div class='col'>
                        <div class = 'elemtImg'><img src=\"Img/$img\"></div>
                                <div class = 'cell'>
                                    <p class = 'general'>
                                    <strong>Il tuo amico</strong> <em>$nome</em>
                                    <strong>vuole invitarti per giocare a</strong> <em>$disciplina</em><br/>
                                    <strong>Alla struttura</strong> <em>$struttura</em>, <br/>
                                    <strong>situata</strong> <a href='https://www.google.it/maps/place/$indirizzo;' style = 'color:white' title='Vedi il luogo' target='_blanck'><em>$indirizzo;</em></a>.<br/>
                                    <strong>Nella giornata del</strong> <em>$data</em><br/>
                                    <strong>Dalle</strong> <em>$orainizio</em><br/>
                                    <strong>Alle</strong> <em>$orafine</em><br/><br/>
                                    <strong>Messaggio:</strong> <em>$descrizione</em><br/>
                                    </p>
                                </div>
                                ";
                        if ($esito == "Acquistato") {
                            print "
                                    <div class = 'decision'>
                                        <form action='notifiche.php' method='post'>
                                            <input type='hidden' name='accetto' value='$cod'>
                                            <input type='hidden' name='eventID' value='$codiceEvento'>
                                            <input type='submit' class='navBar'  value='Accetta'></input>
                                        </form>
                                        <form action='notifiche.php' method='post'>
                                            <input type='hidden' name='nok' value='$cod'>
                                            <input type='hidden' name='eventID' value='$codiceEvento'>
                                            <input type='submit' class='navBar'  value='Rifiuta'></input>
                                        </form>
                                    </div>
                                </div>";
                        } else {
                            print " 
                                   <div class = 'decision'>
                                        <form action='notifiche.php' method='post'>
                                            <input type='hidden' name='accetto' value='$cod'>
                                            <input type='hidden' name='eventID' value='$codiceEvento'>
                                            <input type='submit' class='navBar'  value='Acquista'></input>
                                        </form>
                                        <form action='notifiche.php' method='post'>
                                            <input type='hidden' name='nok' value='$cod'>
                                            <input type='hidden' name='eventID' value='$codiceEvento'>
                                            <input type='submit' class='navBar'  value='Rifiuta'></input>
                                        </form>
                                    </div>
                                </div>";
                        }
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