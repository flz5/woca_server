<?php
/*
 * This file is part of the WOCA (server) project.
 * Copyright (c) 2020-2023 Frank Zimdars.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

session_start();

include_once '../../lib/account/db_account.php';
include_once '../../lib/account/session_login.php';

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("event", 2)) {
    die("Keine Berechtigung!");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Löschen bestätigen</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php

if(isset($_GET['id'])){

    $id = $_GET['id'];

    if(!isset($id)){
        echo "<div class='d4'>";
        echo "<p class='p4'>";
        echo "Fehler";
        echo "<p/>";
        echo "Fehlerhafter Datensatz<br><br>";
        echo "<a href='index.php'>Zurück</a><br><br>";
        echo "</div>";
    }else{
        if($id == 0){
            echo "<div class='d4'>";
            echo "<p class='p4'>";
            echo "Löschen bestätigen";
            echo "<p/>";
            echo "Der Eintrag kann nicht gelöscht werden<br>Eintrag 0<br><br>";
            echo "<a href='index.php'>Abbrechen</a><br><br>";
            echo "</div>";

        }else{
                echo "<div class='d4'>";
                echo "<p class='p4'>";
                echo "Löschen bestätigen";
                echo "<p/>";
                echo "Soll der Eintrag wirklich gelöscht werden?<br><br>";
                echo "<a href='action_event_delete.php?id=".$id."'>Löschen</a><br><br>";
                echo "<a href='index.php'>Abbrechen</a><br><br>";
                echo "</div>";
        }
    }
}else{
    echo "<div class='d4'>";
    echo "<p class='p4'>";
    echo "Fehler";
    echo "<p/>";
    echo "Keine Daten<br><br>";
    echo "<a href='index.php'>Zurück</a><br><br>";
    echo "</div>";
}

?>

</body>
</html>