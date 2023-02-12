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

include_once '../../lib/location/db_location.php';
include_once '../../lib/location/struct_location.php';

include_once "../../lib/events/db_event.php";
include_once "../../lib/events/db_event_group.php";

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("event", 2)) {
    die("Keine Berechtigung!");
}

if(isset($_GET['id'])){
    $st = db_event_getGroupWhereID($_GET['id']);

}else{
    $st = new struct_event_group_raw();
    $st->id = 0;
    $st->color = 'CCFFCC';
    $st->name ='Name';
    $st->description = 'Beschreibung';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Gruppe bearbeiten | WOCA</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Event Gruppe bearbeiten</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Events</a> > Events bearbeiten

</div>

<br>

<div class="container_default">

<br><br>

<form action="action_group_save.php" method="post">

    <table>

        <tr>
            <td>Name:</td>
            <td><input type="name" name="name" value="<?php echo $st->name; ?>"></td>
        </tr>
        <tr>
            <td>Beschreibung:</td>
            <td><input type="name" name="description" value="<?php echo $st->description; ?>"></td>
        </tr>
        <tr>
            <td>Farbe:</td>
            <td><input type="name" name="color" value="<?php echo $st->color; ?>"></td>

        </tr>
    </table>

    <input type="hidden" name="id" value="<?php echo $st->id; ?>">
    <input type="submit" value="Speichern">

</form>

</div>
</body>
</html>
