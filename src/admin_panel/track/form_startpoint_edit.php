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

include_once "../../lib/track/track_startpoint.php";


if (!ss_account_isLoggedIn()) {

    //header('Location: ../login/form_login.php?option=p', true, 301);
    //exit();
}

if (!ss_account_requestPermission("event", 2)) {
    //die("Keine Berechtigung!");

}


if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);

    //if(!db_event_checkStruct($st)){
        //echo "Daten unvollständig!";
    //}

}else{
    $st = new struct_track_startpoint();
    $st->name = 0;
    $st->version = 0;
    $st->id = 0;
}

?>

<html>

<h2>Übersicht</h2>

<a href="..\index.php">Start</a> > <a href="index.php">Strecke</a> > Strecke hinzufügen/bearbeiten<br><br>


<form action="action_startpoint_save.php">

    <table>

        <tr>
            <td>Name:</td>
            <td><input type="name" name="name" value="<?php echo $st->name; ?>"></td>

        </tr>
        <tr>
            <td>Beschreibung:</td>
            <td><input type="name" name="version" value="<?php echo $st->version; ?>"></td>

        </tr>



    <input type="hidden" name="id" value="<?php echo $st->id; ?>">

    <input type="submit" value="Speichern">

</form>


</html>
