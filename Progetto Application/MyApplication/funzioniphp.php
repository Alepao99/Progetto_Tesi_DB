<?php
function getCFUser($user)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT CF FROM Utente WHERE Username=$1;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}


function allUsers($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT distinct U.cf as cf, U.nome as nome, U.cognome as cognome, U.immagine
    FROM Utente U, Preferenza P, Disciplina D
     WHERE P.Utente = U.CF and P.disciplina = D.codice
     except
     SELECT distinct U.cf as cf, U.nome as nome, U.cognome as cognome, U.immagine
     FROM Utente U, Preferenza P, Disciplina D
     WHERE P.Utente = U.CF and P.disciplina = D.codice and U.CF = $1";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array($user));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}
function discSelectUser($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT D.nome as disciplina
    FROM Utente U, Preferenza P, Disciplina D
    WHERE P.Utente = U.CF and P.disciplina = D.codice  and U.CF = $1";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array($user));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}

function getNameUser($user)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT nome FROM Utente WHERE CF=$1;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}
function esecuzioneIndex()
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT * from vistaServizioProposto";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array());
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}


function insertPrenotazioneAttesa($id, $user, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $idDisciplina, $data, $societa)
{
    $esito = 'Attesa';
    $codiceEvent = insertElementCalendarUserAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $societa, $user);
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "INSERT INTO Prenotazione(esito,utente,proposta,codiceEvento) VALUES ($1,$2,$3,$4)";
    $prep = pg_prepare($db, "sqlInsertAudio", $sql);
    $ret = pg_execute($db, "sqlInsertAudio", array($esito, $user, $id, $codiceEvent));
    pg_close($db);
    if (!$ret) {
        return false;
    } else {
        return true;
    }
}

function esecuzionePropostaAttesa($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT * from prenotazioniAttesa where utente = $1";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array($user));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}

function esecuzionePropostaAcquistata($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT * from prenotazioniAcquistate where utente = $1";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array($user));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}

function esecuzionePrenotazione($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT * from Prenotazione where Utente = $1";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array($user));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}


function esecuzionePropostaInvitate($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT * from invitiEffettuati where Utente = $1";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array($user));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}


function deleteAccount($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "DELETE FROM utenti WHERE username=$1";
    $prep = pg_prepare($db, "deleteUtente", $sql);
    $ret = pg_execute($db, 'deleteUtente', array($user));
    pg_close($db);
    if (!$ret) {
        echo "ERRORE DELETE " . pg_last_error($db);
        return false;
    } else {
        unset($_SESSION['email']);
        session_destroy();
        setcookie("email", '', time() - 3600, '/');
        return true;
    }
}


function insertPrenotazione($id, $user, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $idDisciplina, $data, $societa)
{
    $esito = 'Acquistato';
    $today = date("Y-m-d H:i:s");
    $codiceEvent = insertElementCalendarUser($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $societa, $user);
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "INSERT INTO Prenotazione(dataesito,esito,utente,proposta,codiceEvento) VALUES ($1,$2,$3,$4,$5)";
    $prep = pg_prepare($db, "sqlInsertAudio", $sql);
    $ret = pg_execute($db, "sqlInsertAudio", array($today, $esito, $user, $id, $codiceEvent));
    pg_close($db);
    if (!$ret) {
        return false;
    } else {
        return true;
    }
}

function getAmico($user, $disc)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT amico FROM Amicizia WHERE Utente=$1 and Disciplina = $2";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user, $disc));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}


function getDisciplina($disc)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT nome FROM disciplina WHERE codice = $1;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($disc));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}

function getCalendario($user, $disc)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT distinct calendarId FROM amicizia WHERE utente = $1 and disciplina = $2;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user, $disc));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}

function getPosti($disc)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT distinct  NumeroPosti FROM Servizio WHERE disciplina = $1;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($disc));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}




function insertInvitoAttesaGruppo($id, $user, $disc, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $costo)
{
    require "db.php";
    $retT = getAmico($user, $disc);
    $count = getPosti($disc);
    deleteElementCalendar('primary', $codiceEvento);
    $calendarioCondiviso = getCalendario($user, $disc);
    insertElementCalendarCondivisoAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $calendarioCondiviso, $user, $retT, $count, $costo);
    pg_result_seek($retT, 0);
    while ($row = pg_fetch_array($retT)) {
        $amico = $row['amico'];
        $descrizione = 'Ciao ' . getNameUser($amico) . ', ti invito a partecipare ' . getDisciplina($disc) . ', divideremo il prezzo del servizio! Prezzo: ' . round($costo / $count, 1, PHP_ROUND_HALF_DOWN) . '€';
        $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
        $sql = "INSERT INTO Invito(descrizione,prenotazione,utenteinvitato) VALUES ($1,$2,$3)";
        $prep = pg_prepare($db, "sqlInsertAudio", $sql);
        $ret = pg_execute($db, "sqlInsertAudio", array($descrizione, $id, $amico));
    }
    pg_close($db);
}


function insertInvitoCondiviso($id, $user, $disc, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento)
{
    require "db.php";
    $retT = getAmico($user, $disc);
    deleteElementCalendar('primary', $codiceEvento);
    $calendarioCondiviso = getCalendario($user, $disc);
    insertElementCalendarCondiviso($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $calendarioCondiviso, $user, $retT);
    pg_result_seek($retT, 0);
    while ($row = pg_fetch_array($retT)) {
        $amico = $row['amico'];
        $descrizione = 'Ciao ' . getNameUser($amico) . ', ho acquistato il servizio,  ti invito a partecipare ' . getDisciplina($disc) . '.';
        $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
        $sql = "INSERT INTO Invito(descrizione,prenotazione,utenteinvitato) VALUES ($1,$2,$3)";
        $prep = pg_prepare($db, "sqlInsertAudio", $sql);
        $ret = pg_execute($db, "sqlInsertAudio", array($descrizione, $id, $amico));
    }
    pg_close($db);
}


function insertInvitoPrivato($id, $user, $disc, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utenteApp)
{
    require "db.php";
    $email = getEmail($utenteApp);
    deleteElementCalendar('primary', $codiceEvento);
    insertElementCalendarPrivato($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $email);
    $descrizione = 'Ciao ' . getNameUser($utenteApp) . ', ho acquistato il servizio, ti invito a partecipare ' . getDisciplina($disc) . '.';
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "INSERT INTO Invito(descrizione,prenotazione,utenteinvitato) VALUES ($1,$2,$3)";
    $prep = pg_prepare($db, "sqlInsertAudio", $sql);
    $ret = pg_execute($db, "sqlInsertAudio", array($descrizione, $id, $utenteApp));
    pg_close($db);
}

function insertInvitoPrivatoAttesa($id, $user, $disc, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utenteApp, $costo)
{
    require "db.php";
    $email = getEmail($utenteApp);
    deleteElementCalendar('primary', $codiceEvento);
    $partecipanti = getPosti($disc);
    insertElementCalendarPrivatoAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $email, $costo, $partecipanti);
    $descrizione = 'Ciao ' . getNameUser($utenteApp) . ', ti invito a partecipare ' . getDisciplina($disc) . '. Pagheremo il servizio insieme! Prezzo diviso: ' . round($costo / $partecipanti, 1, PHP_ROUND_HALF_DOWN) . '€ invece di ' . round($costo) . '€';
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "INSERT INTO Invito(descrizione,prenotazione,utenteinvitato) VALUES ($1,$2,$3)";
    $prep = pg_prepare($db, "sqlInsertAudio", $sql);
    $ret = pg_execute($db, "sqlInsertAudio", array($descrizione, $id, $utenteApp));
    pg_close($db);
}

function insertInvitoPrivatoMultiploAttesa($id, $user, $disc, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utentiApp, $costo)
{
    require "db.php";
    deleteElementCalendar('primary', $codiceEvento);
    $partecipanti = getPosti($disc);
    foreach ($utentiApp as $utenteApp) {
        $descrizione = 'Ciao ' . getNameUser($utenteApp) . ', ti invito a partecipare a ' . getDisciplina($disc) . '. Pagheremo il servizio ' . round($costo / $partecipanti, 1, PHP_ROUND_HALF_DOWN) . '€ invece di ' . round($costo) . '€';
        $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
        $sql = "INSERT INTO Invito(descrizione,prenotazione,utenteinvitato) VALUES ($1,$2,$3)";
        $prep = pg_prepare($db, "sqlInsertAudio", $sql);
        $ret = pg_execute($db, "sqlInsertAudio", array($descrizione, $id, $utenteApp));
    }
    pg_close($db);
    insertElementCalendarPrivatoMultiploAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $utentiApp, $costo, $partecipanti);
}


function insertInvitoPrivatoMultiplo($id, $user, $disc, $titolo, $luogo, $descrizione, $timeStart, $timeEnd, $data, $codiceEvento, $utentiApp)
{
    require "db.php";
    deleteElementCalendar('primary', $codiceEvento);
    insertElementCalendarPrivatoMultiplo($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $utentiApp);
    foreach ($utentiApp as $utenteApp) {
        $descrizione = 'Ciao ' . getNameUser($utenteApp) . ', ho acquistato il servizio, ti invito a partecipare ' . getDisciplina($disc) . '.';
        $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
        $sql = "INSERT INTO Invito(descrizione,prenotazione,utenteinvitato) VALUES ($1,$2,$3)";
        $prep = pg_prepare($db, "sqlInsertAudio", $sql);
        $ret = pg_execute($db, "sqlInsertAudio", array($descrizione, $id, $utenteApp));
    }
    pg_close($db);
}

function email_exist($user)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT Email FROM Account WHERE email=$1";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user));
    pg_close($db);
    if (!$ret) {
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret)) {
            return true;
        } else {
            return false;
        }
    }
}

function username_exist($nome)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT Username FROM Account WHERE username=$1";
    $prep = pg_prepare($db, "sqlUser", $sql);
    $ret = pg_execute($db, "sqlUser", array($nome));
    pg_close($db);
    if (!$ret) {
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret)) {
            return true;
        } else {
            return false;
        }
    }
}


function insert_utente($user, $nome, $pass)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Account(Email, Username, Password) VALUES($1, $2, $3)";
    $prep = pg_prepare($db, "insertUser", $sql);
    $ret = pg_execute($db, "insertUser", array($user, $nome, $hash));
    pg_close($db);
    if (!$ret) {
        return false;
    } else {
        return true;
    }
}

function insert_utente_no_pass($user, $nome, $pass)
{
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "INSERT INTO Account(Email, Username, Password) VALUES($1, $2, $3)";
    $prep = pg_prepare($db, "insertUser", $sql);
    $ret = pg_execute($db, "insertUser", array($user, $nome, $pass));
    pg_close($db);
    if (!$ret) {
        return false;
    } else {
        return true;
    }
}

function get_pwd($user)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT Password FROM Account WHERE email=$1;";
    $prep = pg_prepare($db, "sqlPassword", $sql);
    $ret = pg_execute($db, "sqlPassword", array($user));
    if (!$ret) {
        return false;
    } else {
        if ($row = pg_fetch_assoc($ret)) {
            $pass = $row['password'];
            pg_close($db);
            return $pass;
        } else {
            pg_close($db);
            return false;
        }
    }
}

function get_username($user)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT Username FROM Account WHERE email=$1;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}



function esecuzioneInviti($user)
{
    $esito = "Attesa";
    require "db.php";
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT * from partecipazione where invitato = $1 and esito = $2";
    $prep = pg_prepare($db, "sqlIndex", $sql);
    $ret = pg_execute($db, "sqlIndex", array($user, $esito));
    pg_close($db);
    if (!$ret)
        exit;
    return $ret;
}


function confirmNot($cod, $user)
{
    $today = date("Y-m-d H:i:s");
    $esito = "Accettato";
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "UPDATE Invito SET dataesito = $1, esito = $2 WHERE codice = $3 and utenteinvitato = $4;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($today, $esito, $cod, $user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        return true;
    }
}

function resetConferma($cod)
{
    $today = date("Y-m-d H:i:s");
    $esito = "Accettato";
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "UPDATE Prenotazione SET conferma = true WHERE codice = $1";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($cod));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        return true;
    }
}
function refuseNot($cod, $user)
{
    $today = date("Y-m-d H:i:s");
    $esito = "Rifiutato";
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "UPDATE Invito SET dataesito = $1, esito = $2 WHERE codice = $3 and utenteinvitato = $4;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($today, $esito, $cod, $user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        return true;
    }
}


function checkQuantita($user)
{
    $esito = "Attesa";
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT count(*) FROM invito WHERE utenteinvitato=$1 and esito =$2;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user, $esito));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}

function getClient()
{
    require __DIR__ . '/vendor/autoload.php';
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

function deleteElementCalendar($calendarId, $eventoCod)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();
    if (empty($events)) {
        print "No upcoming events found.\n";
    } else {
        $service->events->delete($calendarId, $eventoCod);
    }
}

function getEmail($user)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT email FROM Utente as U, Account as A WHERE U.username = A.username and CF=$1;";
    $prep = pg_prepare($db, "sqlEmail", $sql);
    $ret = pg_execute($db, "sqlEmail", array($user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}
function getEmailTwo($user)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT email FROM Utente as U, Account as A WHERE U.username = A.username and CF=$1;";
    $prep = pg_prepare($db, "sqlEmailTwo", $sql);
    $ret = pg_execute($db, "sqlEmailTwo", array($user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}
function getEmailThree($user)
{
    require "db.php";
    //CONNESSIONE AL DB
    $db = pg_connect($connection_string) or die('Impossibile connetersi al database: ' . pg_last_error());
    $sql = "SELECT email FROM Utente as U, Account as A WHERE U.username = A.username and CF=$1;";
    $prep = pg_prepare($db, "sqlEmailTwo", $sql);
    $ret = pg_execute($db, "sqlEmailTwo", array($user));
    if (!$ret) {
        pg_close($db);
        return false;
    } else {
        $row = pg_fetch_row($ret);
        $nome = $row[0];
        pg_close($db);
        return $nome;
    }
}


function insertElementCalendarPrivatoMultiplo($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $utentiApp)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents('primary', $optParams);
    $events = $results->getItems();

    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Ho acquistato il Servizio, alleniamoci insieme!',
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));
    $attendees = array();
    foreach ($utentiApp as $item) {
        $attendee = new Google_Service_Calendar_EventAttendee();
        $attendee->setEmail(getEmail($item));
        $attendees[] = $attendee;
    }
    $event->setAttendees($attendees);
    $event = $service->events->insert('primary', $event);
}


function insertElementCalendarPrivatoMultiploAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $utentiApp, $costo, $partecipanti)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents('primary', $optParams);
    $events = $results->getItems();

    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Servizio in attesa, partecipiamo insieme e pagheremo il servizio ' . 
        round($costo / $partecipanti, 1, PHP_ROUND_HALF_DOWN) . '€ invece di ' . round($costo) . '€!' . ' Posti disponibili ' . $partecipanti,
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));
    $attendees = array();
    foreach ($utentiApp as $item) {
        $attendee = new Google_Service_Calendar_EventAttendee();
        $attendee->setEmail(getEmail($item));
        $attendees[] = $attendee;
    }
    $event->setAttendees($attendees);
    $event = $service->events->insert($calendarId, $event);
}


function insertElementCalendarCondivisoAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $calendarioCondiviso, $user, $retT, $partecipanti, $costo)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarioCondiviso, $optParams);
    $events = $results->getItems();

    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Servizio in attesa, partecipiamo insieme e pagheremo il servizio ' . round($costo / $partecipanti, 1, PHP_ROUND_HALF_DOWN) . '€ invece di ' . round($costo) . '€!' . ' Posti disponibili ' . $partecipanti,
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));
    $attendees = array();
    pg_result_seek($retT, 0);
    while ($row = pg_fetch_array($retT)) {
        if (isset($row['amico'])) {
            $attendee = new Google_Service_Calendar_EventAttendee();
            $attendee->setEmail(getEmail($row['amico']));
            $attendees[] = $attendee;
        }
    }
    $event->setAttendees($attendees);
    $event = $service->events->insert($calendarioCondiviso, $event);
}




function insertElementCalendarCondiviso($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $calendarioCondiviso, $user, $retT)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarioCondiviso, $optParams);
    $events = $results->getItems();

    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Servizio acquistato, alleniamoci insieme!',
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));
    $attendees = array();
    pg_result_seek($retT, 0);
    while ($row = pg_fetch_array($retT)) {
        if (isset($row['amico'])) {
            $attendee = new Google_Service_Calendar_EventAttendee();
            $attendee->setEmail(getEmail($row['amico']));
            $attendees[] = $attendee;
        }
    }
    $event->setAttendees($attendees);
    $event = $service->events->insert($calendarioCondiviso, $event);
}


function insertElementCalendarPrivato($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $email)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'primary';
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();


    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Ho acquistato il servizio, unisciti a me!',
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'attendees' => array(
            array('email' => '' . $email),
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));

    $event = $service->events->insert($calendarId, $event);
    return $event->getId();
}

function insertElementCalendarPrivatoAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $user, $email, $costo, $partecipanti)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'primary';
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();


    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Servizio in attesa, partecipa e pagheremo il servizio insieme al costo di ' . round($costo / $partecipanti, 1, PHP_ROUND_HALF_DOWN) . '€' . ' invece di ' . round($costo) . '€!' . ' Posti disponibili ' . $partecipanti,
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'attendees' => array(
            array('email' => '' . $email),
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));

    $event = $service->events->insert($calendarId, $event);
    return $event->getId();
}

function insertElementCalendarUserAttesa($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $societa, $user)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'primary';
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();


    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Servizio in attesa, si svolgerà presso il club ' . $societa,
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));

    $event = $service->events->insert($calendarId, $event);
    return $event->getId();
}


function insertElementCalendarUser($titolo, $luogo, $descrizione, $data, $timeStart, $timeEnd, $societa, $user)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'primary';
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();


    $event = new Google_Service_Calendar_Event(array(
        'summary' => $titolo,
        'location' => $luogo,
        'description' => 'Servizio acquistato, si svolgerà presso il club ' . $societa,
        'organizer' => array(
            'id' => $user,
        ),
        'start' => array(
            'dateTime' => $data . 'T' . $timeStart,
            'timeZone' => 'Europe/Rome',
        ),
        'end' => array(
            'dateTime' => $data . 'T' . $timeEnd,
            'timeZone' => 'Europe/Rome',
        ),
        'reminders' => array(
            'useDefault' => FALSE,
            'overrides' => array(
                array('method' => 'email', 'minutes' => 24 * 60),
                array('method' => 'popup', 'minutes' => 10),
            ),
        ),
    ));

    $event = $service->events->insert($calendarId, $event);
    return $event->getId();
}


function updateClient($user, $status, $eventId)
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'k172vnttel8nd703s1a7lco68k@group.calendar.google.com';
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();

    $event = $this->service->events->get($calendarId, $eventId);
    $attendees = array();
    foreach ($event->attendees as $key => $value) {
        $attendees[] = $value;
    }
    $attendee1 = new Google_Service_Calendar_EventAttendee();
    $attendee1->setEmail(getEmailThree($user));
    if ($accept == "true") {
        $attendee1->setResponseStatus('accepted');
    }
    $attendees[] = $attendee1;
    $event->attendees = $attendees;
    $optParams = array('sendNotifications' => true, 'maxAttendees' => 1000);
    $updatedEvent = $this->service->events->update($calendarId, $event->getId(), $event, $optParams);
}


function printElementCalendar()
{
    require __DIR__ . '/vendor/autoload.php';
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'k172vnttel8nd703s1a7lco68k@group.calendar.google.com';
    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();

    if (empty($events)) {
        print "No upcoming events found.\n";
    } else {
        print "All Event:\n";
        foreach ($events as $event) {
            $start = $event->start->dateTime;
            $end = $event->end->dateTime;
            $location = $event->location;
            if (empty($start)) {
                $start = $event->start->date;
            } else if (empty($end)) {
                $start = $event->$end->date;
            }
            print "Evento: " . $event->getId() . "\n";
            printf("Evento creato da: \nTitolo:%s;\nDescrizione: %s\nInizio: (%s);\nFine: (%s)\nDove: %s \n\n", $event->getSummary(), $event->getDescription(), $start, $end, $location, $event);
        }
    }
}
