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

include_once '../../lib/location/db_location.php';
include_once '../../lib/location/struct_location.php';

include_once "../../lib/events/db_event.php";
include_once '../../lib/events/appstruct_event.php';
include_once "../../lib/events/db_event_group.php";

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("event", 2)) {
    die("Keine Berechtigung!");
}

if(isset($_GET['data'])){
    $st = json_decode($_GET['data']);
    if(!db_event_checkStruct($st)){
        echo "Daten unvollständig!";
    }
}else{
    $st = new struct_event();
    $st->name = 0;
    $st->description = 0;
    $st->day = "0";
    $st->time_start = "0";
    $st->time_end = "0";
    $st->slots = "0";
    $st->color = "FFFFFF";
    $st->location = 0;
    $st->group = 0;
    $st->id = 0;
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
    <div style="font-size: x-large">Events hinzufügen/bearbeiten</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Events</a> > Events hinzufügen/bearbeiten

</div>

<br>

<div class="container_default">

<h2>Übersicht</h2>

<a href="..\index.php">Start</a> > <a href="index.php">Events</a> > Event hinzufügen/bearbeiten<br><br>

<form action="action_event_save.php">

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
            <td>Startzeit (Posix):</td>
            <td><input type="name" name="time_start" value="<?php echo $st->time_start; ?>"></td>
        </tr>
        <tr>
            <td>Endzeit (Posix):</td>
            <td><input type="name" name="time_end" value="<?php echo $st->time_end; ?>"></td>
        </tr>
        <tr>
            <td>Plätze:</td>
            <td><input type="name" name="slots" value="<?php echo $st->slots; ?>"></td>
        </tr>
        <tr>
            <td>Farbe:</td>
            <td><input type="name" name="color" value="<?php echo $st->color; ?>"></td>
        </tr>
        <tr>
            <td>Ort:</td>
            <td>
                <select name="location" id="house-select">
                    <?php
                    $list = db_location_getAll();

                    foreach($list as $k){
                        if($k->id == $st->location){
                            echo "<option value='".$k->id."' selected>".$k->name."</option>";
                        }else{
                            echo "<option value='".$k->id."'>".$k->name."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Gruppe:</td>
            <td>
                <select name="group" id="house-select7">
                    <?php
                    $list = db_event_group_getAll();
                    foreach($list as $k){
                        if($k->id == $st->group){
                            echo "<option value='".$k->id."' selected>".$k->name."</option>";
                        }else{
                            echo "<option value='".$k->id."'>".$k->name."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>

    <input type="hidden" name="id" value="<?php echo $st->id; ?>">
    <input type="submit" value="Speichern">

</form>


</html>
