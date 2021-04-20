<?php

include_once "../inc/db.inc.init.php";

$email = $_GET['email'];

$sql = "DELETE FROM tb_user
WHERE email = '$email'";


if (mysqli_query($db, $sql)) {
    mysqli_close($db);
    header("Location: ../newsletter.php");
    exit;
} else {
    echo "Fehler beim Abbestellen des Newsletters!" . mysqli_error($db);
}
