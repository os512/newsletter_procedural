<?php

include_once "db.inc.init.php";

$vorname = trim($_POST['vorname']);
$nachname = trim($_POST['nachname']);
$email = trim($_POST['email']);


/*****************************************************
 ********   T A B E L L E N   A N L E G E N   ********
 *****************************************************
 */

if ($db) {
    echo 'Verbindung zur Datenbank erfolgreich. <br />';

    $sql = "CREATE TABLE IF NOT EXISTS tb_user (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        vorname VARCHAR(256) NOT NULL,
        nachname VARCHAR(256) NOT NULL ,
        email VARCHAR(256) NOT NULL UNIQUE
    )";
    if (mysqli_query($db, $sql)) {
        echo "Tabelle tb_user erfolgreich angelegt. <br>";
    } else {
        echo "Anlegen der Tabelle tb_user fehlgeschlagen: " . mysqli_error($db) . "<br>";
    }


    /*****************************************************
     ******   D A T E N S Ä T Z E   A N L E G E N   ******
     *****************************************************
     *
     * User ——>> tb_user
     */

    $sql = "INSERT INTO tb_user (vorname, nachname, email)
    VALUES(?, ?, ?)";

    if (
        isset($_POST['vorname']) && $_POST['vorname'] != "" && trim($_POST['vorname']) &&
        isset($_POST['nachname']) && $_POST['nachname'] != "" && trim($_POST['nachname']) &&
        isset($_POST['email']) && $_POST['email'] != "" && trim($_POST['email'])
    ) {
        if ($prepStmt = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param(
                $prepStmt,
                "sss",
                $vorname,
                $nachname,
                $email
            );
            if (mysqli_stmt_execute($prepStmt)) {
                include_once 'status.inc.true.php';
                $id = mysqli_insert_id($db);
                echo "Der Benutzer '$vorname $nachname' wurde mit der ID-Nummer $id erfolgreich angelegt. <br>";
                mysqli_stmt_close($prepStmt);
                header("Location: ../status/confirm.php"); // für Status-Anzeigen der Statements —> hier auskommentieren!
            } else {
                echo "Anlegen des Benutzers '$vorname $nachname' fehlgeschlagen: <br>" . mysqli_stmt_error($prepStmt);
                header("Location: ../status/error_duplicate_entry.php"); // für Status-Anzeigen der Statements —> hier auskommentieren!
            }
        }
    } else {
        echo "Bitte füllen Sie die Felder aus. <br>" . mysqli_error($db) . "<br>";
        header("Location: ../status/error_no_entry.php"); // für Status-Anzeigen der Statements —> hier auskommentieren!
    }

    /******************************************************
     *****   D A T E N S Ä T Z E   A U S L E S E N   *****
     *****************************************************
     *
     * User ——>> tb_user
     */

    // $sql = "SELECT * FROM tb_user";

    // if ($result = mysqli_query($db, $sql)) {
    //     echo "<ul>";
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         echo "<li>" . htmlspecialchars($row['vorname']) .
    //             "<li>" . htmlspecialchars($row['nachname']) .
    //             "<li>" . htmlspecialchars($row['email']);
    //     }
    //     echo "</ul>";
    // } else {
    //     echo "Keine Daten vorhanden!";
    // }


    mysqli_close($db);
} else {
    echo 'Keine Verbindung zur Datenbank! <br />';
}
