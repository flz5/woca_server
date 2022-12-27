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
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orte | WOCS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Events hinzufügen/bearbeiten</div>
    <a href="..\index.php">Start</a> > Nacrichten (Kanäle)

</div>

<br>

<div class="container_default">

<br><br>

<a href="form_channel_edit.php">Kanal erstellen</a>
<br><br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Beschreibung</td>
        <td>Beitritt</td>
        <td>Passwort</td>
        <td>Aktion</td>

    </tr>


    <?php

    require_once '../../lib/message/message_admin.php';
    $tt = new message_admin();
    $list = $tt->getChannelList();

    foreach($list as $rfr){


        echo "<tr>";
        echo "<td>".$rfr->id."</td>";
        echo "<td>".$rfr->name."</td>";
        echo "<td>".$rfr->description."</td>";

        if($rfr->public == false){
            echo "<td>Nein</td>";
        }else{
            echo "<td>Ja</td>";
        }

        if($rfr->password == false){
            echo "<td>Nein</td>";
        }else{
            echo "<td>Ja</td>";
        }

        echo "<td>";
        echo "<a href='form_channel_edit.php?id=".$rfr->id."&name=".$rfr->name."&description=".$rfr->description."&public=".$rfr->public."'>Bearbeiten</a><br>";
        echo "<a href='form_channel_delete.php?id=".$rfr->id."'>Löschen</a><br>";
        echo "<a href='table_channel_permissions.php?id=".$rfr->id."'>Berechtigungen</a><br>";
        echo "</td>";

        echo "</tr>";

    }


    ?>


</table>
</div>
</body>
</html>