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
        $ret = esecuzioneIndex(); ?>
        <?php include "Collegamenti/headerUser.php"; ?>
        <div class="container_tracks">
            <div class="container_tracks_title tw normal-text">
            </div>
            <div class="container_tracks_tracks">
                <div class="tracks_tracks_title">Proposte disponibili</div>
                <div class="container_grid">
                    <?php
                    pg_result_seek($ret, 0);
                    while ($row = pg_fetch_array($ret)) {
                        $id = $row["codice"];
                        $societa = $row["denominazione"];
                        $struttura = $row["struttura"];
                        $indirizzo = $row["indirizzo"];
                        $nome = $row["nome"];
                        $descrizione = $row["descrizione"];
                        $data = $row["data"];
                        $costo = $row["costo"];
                        $oraInizio = $row["orainizio"];
                        $oraFine = $row["orafine"];
                        $condiviso = $row["condiviso"];
                        $titolo = $row['titolo'];
                        $idDisciplina = $row['disciplina'];
                        $var = $row["immagine"];
                        $img = pg_unescape_bytea($var);                        
                        print "<div class='col'>
                                <div class = 'elemtImg'><img src=\"Img/$img\"></div>
                             <div class = 'cell'>
                                <p class = 'general'>
                                <br/>
                                <strong>Società:</strong> <em>$societa; </em><br/> 
                                <strong>Struttura:</strong> <em>$struttura; </em><br/>
                                <strong>Indirizzo:</strong>
                                <a href='https://www.google.it/maps/place/$indirizzo; ' style = 'color:white' title='Vedi il luogo' target='_blanck'><em>$indirizzo;</em></a><br/><br/>
                                <strong>Disciplina:</strong> <em>$nome; </em><br/>
                                <strong>Descrizione:</strong> <em>$descrizione;</em><br/><br/>
                                <strong>Quando:</strong> <em>$data</em><br/>
                                <strong>Inizio:</strong> <em>$oraInizio</em><br/>
                                <strong>Fine:</strong> <em>$oraFine</em><br/><br/>
                                <strong>Prezzo:</strong> <em>$costo €</em>
                                </p>
                            </div>
                                                    ";
                        if ($condiviso == 't') {
                            print "
                            <div class = 'decision'>
                                <form action='acquisti.php' method='post'>
                                <input type='hidden' name='titolo' value='$titolo'>
                                <input type='hidden' name='luogo' value='$indirizzo'>
                                <input type='hidden' name='descrizione' value='$descrizione'>
                                <input type='hidden' name='timeStart' value='$oraInizio'>
                                <input type='hidden' name='timeEnd' value='$oraFine'>
                                <input type='hidden' name='idDisciplina' value='$idDisciplina'>
                                <input type='hidden' name='data' value='$data'> 
                                 <input type='hidden' name='id' value='$id'>
                                 <input type='hidden' name='societa' value='$societa'>
                                <input type='submit' class='navBar'  value='Acquista'></input>
                                </form>
                                <form action='attesa.php' method='post'>
                                <input type='hidden' name='titolo' value='$titolo'>
                                <input type='hidden' name='luogo' value='$indirizzo'>
                                <input type='hidden' name='descrizione' value='$descrizione'>
                                <input type='hidden' name='timeStart' value='$oraInizio'>
                                <input type='hidden' name='timeEnd' value='$oraFine'>
                                <input type='hidden' name='idDisciplina' value='$idDisciplina'>
                                <input type='hidden' name='data' value='$data'>                               
                                 <input type='hidden' name='id' value='$id'>
                                 <input type='hidden' name='societa' value='$societa'>                                    
                                <input type='submit' class='navBar'  value='In Attesa'></input>
                                </form>
                        </div>";
                        } else {
                            print "
                        <div class = 'decision'>
                        <form action='acquisti.php' method='post'>
                        <input type='hidden' name='titolo' value=''>
                        <input type='hidden' name='titolo' value='$titolo'>
                        <input type='hidden' name='luogo' value='$indirizzo'>
                        <input type='hidden' name='descrizione' value='$descrizione'>
                        <input type='hidden' name='timeStart' value='$oraInizio'>
                        <input type='hidden' name='timeEnd' value='$oraFine'>
                        <input type='hidden' name='idDisciplina' value='$idDisciplina'>
                        <input type='hidden' name='data' value='$data'>                                                        
                        <input type='hidden' name='id' value='$id'>
                        <input type='hidden' name='societa' value='$societa'>
                            <input type='submit' class='navBar' value='Acquista'></input>
                        </form>
                    </div>   ";
                        }
                        print"</div>";
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