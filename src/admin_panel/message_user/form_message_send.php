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
    <a href="..\index.php">Start</a> > <a href="index.php">Nachrichten (Benutzer)</a>  > Nachricht senden

</div>

<br>
<div class="container_default">

<br><br>

<form action="action_message_send.php" method="get">

<table border="1" >

    <tr>
        <td>Kanal:</td>
    <td>

    <?php




    $list = $tt->getListWritable();



    echo  "<select name='id' id='house-select'>";



    foreach($list as $rfr){

        echo "<option value='".$rfr->id."' selected>".$rfr->name."</option>";

    }

    echo "</select>";
    ?>

    </td>
    </tr>
    <tr>
        <td>Titel:</td>
        <td><input type="name" name="title" value=""></td>

    </tr>
    <tr>
        <td>Nachricht:</td>
        <td><input type="name" name="text" value=""></td>

    </tr>

    <tr>

        <td>
            <input type="submit" value="Speichern">
        </td>
    </tr>




</table>
</form>
<br>
<br>
*) Berechtigung für diesen Account gesetzt, ohne Passwort beitreten zu können.

</body>
</html>


