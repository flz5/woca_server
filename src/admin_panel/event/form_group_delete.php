<?php
/*
 * This file is part of the WOCA (server) project.
 * Copyright (c) 2020-2022 Frank Zimdars.
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

include_once "../../lib/events/db_event.php";
include_once '../../lib/events/appstruct_event.php';
include_once "../../lib/events/db_event_group.php";



if (!ss_account_isLoggedIn()) {

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
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

//Parameter:
//Anzeigeparameter
//Form abgesendet




if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);

    if(!isset($st->id)){
        echo "<div class='d4'>";
        echo "<p class='p4'>";
        echo "Fehler";
        echo "<p/>";
        echo "Fehlerhafter Datensatz<br><br>";
        echo "<a href='table_group.php'>Zurück</a><br><br>";
        echo "</div>";

    }else{

        if($st->id == 0){
            echo "<div class='d4'>";
            echo "<p class='p4'>";
            echo "Löschen bestätigen";
            echo "<p/>";
            echo "Der Eintrag kann nicht gelöscht werden<br>Eintrag 0<br><br>";
            echo "<a href='table_group.php'>Abbrechen</a><br><br>";
            echo "</div>";

        }else{

            if(db_training_isUsingGroup($st->id)){
                echo "<div class='d4'>";
                echo "<p class='p4'>";
                echo "Eintrag wird noch verwendet";
                echo "<p/>";
                echo "Der Eintrag ist noch in Verwendung und kann nicht gelöscht werden!<br><br>";
                echo "<a href='table_group.php'>Zurück</a><br><br>";
                echo "</div>";

            }else{
                echo "<div class='d4'>";
                echo "<p class='p4'>";
                echo "Löschen bestätigen";
                echo "<p/>";
                echo "Soll der Eintrag wirklich gelöscht werden?<br><br>";
                echo "<a href='action_group_delete.php?data=".$_GET['data']."'>Löschen</a><br><br>";
                echo "<a href='table_group.php'>Abbrechen</a><br><br>";
                echo "</div>";

            }

        }

    }




}else{


    echo "<div class='d4'>";
    echo "<p class='p4'>";
    echo "Fehler";
    echo "<p/>";
    echo "Keine Daten<br><br>";
    echo "<a href='table_group.php'>Zurück</a><br><br>";
    echo "</div>";
}


?>


</body>
</html>