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

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("event", 1)) {
    die("Keine Berechtigung!");
}

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
    <div style="font-size: x-large">Event</div>
    <a href="..\index.php">Start</a> > Events

</div>

<br>

<div class="container_default">

<br><br>
<a href="form_event_edit.php">Neu ...</a> <br>

<a href="table_group.php">Gruppen</a><br><br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Beschreibung</td>
        <td>Start (u)</td>
        <td>Ende (u)</td>
        <td>Plätze</td>
        <td>Farbe</td>
        <td>Ort</td>
        <td>Gruppe</td>
        <td>Aktion</td>
    </tr>

    <?php
    include_once "../../lib/events/db_event.php";
    include_once '../../lib/events/appstruct_event.php';

    $boats = db_event_getAll();

    if(isset($boats)){
        foreach ($boats as $bb){
            echo "<tr>";
            echo"<td>".$bb->id . "</td>";
            echo"<td>".$bb->name . "</td>";
            echo"<td>".$bb->description . "</td>";
            echo"<td>".$bb->time_start . "</td>";
            echo"<td>".$bb->time_end . "</td>";
            echo"<td>".$bb->slots . "</td>";
            echo"<td>".$bb->color . "</td>";
            echo"<td>".$bb->location . "</td>";
            echo"<td>".$bb->group . "</td>";

            $json = json_encode($bb);
            echo "<td>";
            echo " <a href='form_event_edit.php?data=".$json."'>Bearbeiten</a>";
            echo"<a href='form_event_delete.php?data=".$json."'>Löschen</a>";
            echo"<a href='table_event_slots.php?id=".$bb->id."'>Teilnehmer</a>";
            echo"</td>";

            echo "<tr>";
        }
    }
    ?>

</table>

</div>
</body>
</html>