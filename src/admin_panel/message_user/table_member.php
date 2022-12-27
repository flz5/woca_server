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

require_once '../../lib/message/message.php';
$tt = new message();
$tt->setUserID(1);

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
    <a href="..\index.php">Start</a> > Nachrichten (Benutzer)

</div>

<br>

<div class="container_default">


<br><br>
<a href="form_message_send.php">Nachricht senden</a>
<a href="table_channel_join.php">Kanal beitreten</a>
<br><br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Kanal</td>
        <td>Typ</td>
        <td>Geräte-ID</td>
        <td>Status</td>
        <td>Aktion</td>

    </tr>


    <?php

    $list = $tt->getListMyDevices();


    foreach($list as $rfr){


        echo "<tr>";
        echo "<td>".$rfr->id."</td>";
        echo "<td>".$rfr->channel_id."</td>";
        echo "<td>".$rfr->device_type."</td>";
        echo "<td>".$rfr->device_id."</td>";
        echo "<td>".$rfr->last_time."</td>";

        echo"<td>";
        echo "<a href='form_member_remove.php?id=".$rfr->channel_id."'>Löschen</a><br>";
        echo "</td>";

        echo "</tr>";




    }


    ?>



</table>

<a href="form_member_remove_all.php">Alle entfernen</a>

</div>
</body>
</html>