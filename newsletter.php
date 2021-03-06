<?php

include_once "./inc/db.inc.init.php";
// include_once "./inc/db.inc.statements.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Newsletter</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="container">
    <header>
      <ul id="menu">
        <li class="item"><a href="main.php">Home</a></li>
        <li class="item"><a href="#">Newsletter</a></li>
      </ul>
    </header>
    <hr>
    <main>
      <h2>Melden Sie sich für den Newsletter an.</h2>
      <form action="inc/db.inc.statements.php" method="post">
        <input type="text" name="vorname" id="" placeholder="Vorname" autofocus />
        <input type="text" name="nachname" id="" placeholder="Nachname" />
        <input type="text" name="email" id="" placeholder="E-Mail" /><br>
        <button id="btn_reg" type="submit" name="submit">registrieren</button>
        <button id="btn_res" type="reset" name="reset">zurücksetzen</button>
      </form>

      <table>
        <?php


        /******************************************************
         *****   D A T E N S Ä T Z E   A U S L E S E N   *****
         ******************************************************/

        $sql = "SELECT * FROM tb_user";

        if ($result = mysqli_query($db, $sql)) {
          echo "
  <tr>
  <th>Vorname</th>
  <th>Nachname</th>
  <th>E-Mail</th>
  <th hidden>Benutzer-ID</th>
  <th></th>
  <th></th>
  
  </tr>
  ";
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['vorname']) . "</td> " .
              "<td>" . htmlspecialchars($row['nachname']) . "</td>" .
              "<td>" . htmlspecialchars($row['email']) . "</td>" .
              "<td hidden>" . htmlspecialchars($row['user_id']) . "</td> " .
              "<td><a href='dbmods/edit.php?email=" . $row['email'] . "'>bearbeiten</a></td>" .
              "<td><a href='dbmods/delete.php?email=" . $row['email'] . "'>löschen</a></td>";
            echo "</tr>";
          }
        } else {
          echo "Keine Daten vorhanden!";
        }

        ?>
      </table>

    </main>
    <footer>
      <ul id="menu">
        <li class="item"><a href="main.php">Home</a></li>
        <li class="item"><a href="about.php">About</a></li>
      </ul>
    </footer>
  </div>
</body>

</html>