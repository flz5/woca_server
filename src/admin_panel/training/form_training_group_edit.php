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

include_once '../../lib/training/db_training.php';
include_once '../../lib/training/struct_training.php';

include_once "../../lib/training/struct_training_group.php";
include_once '../../lib/training/db_training_group.php';

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("training", 2)) {
    die("Keine Berechtigung!");
}

if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);

    if(!db_training_checkGroupStruct($st)){
        echo "Daten unvollständig!";
    }

}else{
    $st = new struct_training_group();
    $st->id = 0;
    $st->color = 'CCFFCC';
    $st->name ='Gruppenname';
    $st->description = 'Beschreibung';
}

?>

<html>

<h2>Übersicht</h2>

<a href="..\index.php">Start</a> > <a href="table_training.php">Trainingszeiten</a> > Trainingszeiten hinzufügen/bearbeiten<br><br>

<form action="action_training_group_edit.php">

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
</html>
