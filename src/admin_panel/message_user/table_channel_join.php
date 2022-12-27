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

/*
 * Parameter:
 *
 * Aneigen alle abonbierten Kanäle
 *
 * DeviecType, Kanal, DeviceKey
 *
 * Aktionen: entfernen, alle entfernen
 *
 */

require_once '../../lib/message/message.php';
$tt = new message();
$tt->setUserID(1);
$list = $tt->getListJoinable();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orte | WOCS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Events hinzufügen/bearbeiten</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Nachrichten (Benutzer)</a>

</div>

<br>
<div class="container_default">
<br><br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Beschreibung</td>
        <td>Passwort benötigt</td>
        <td>Schreibrechte</td>
        <td>Aktion</td>

    </tr>

    <?php

    $list = $tt->getListJoinable();

    foreach($list as $rfr){


        echo "<tr>";
        echo "<td>".$rfr->id."</td>";
        echo "<td>".$rfr->name."</td>";
         echo "<td>$rfr->description</td>";

         if($rfr->password_required == false){
             echo "<td>Nein</td>";
         }else if ($rfr->permission_join == true){
             echo "<td>Nein*</td>";
         }else{
             echo "<td>Ja</td>";
         }

        if($rfr->permission_write == false){
            echo "<td>Nein</td>";
        }else{
            echo "<td>Ja</td>";
        }


        echo"<td>";

        if($rfr->password_required){
            echo "<a href='form_channel_join.php?id=".$rfr->id."&pw=1'>Beitreten</a><br>";
        }else{
            echo "<a href='form_channel_join.php?id=".$rfr->id."&pw=0'>Beitreten</a><br>";
        }


        echo "</td>";

    echo "</tr>";




    }


    ?>

</table>
<br>
<br>
*) Berechtigung für diesen Account gesetzt, ohne Passwort beitreten zu können.

</div>
</body>
</html>