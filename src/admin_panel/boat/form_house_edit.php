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
    //die("Nicht angemeldet");
}

if (!ss_account_requestPermission("boat", 2)) {
    die("Keine Berechtigung!");

}



//Parameter:
//Anzeigeparameter
//Form abgesendet

include_once '../../lib/boat/struct_boat.php';
include_once '../../lib/boat/struct_boat_house.php';
include_once '../../lib/boat/struct_boat_type.php';
include_once '../../lib/boat/struct_boat_tags.php';

include_once '../../lib/boat/db_boat_house.php';
include_once '../../lib/boat/db_boat_tags.php';
include_once '../../lib/boat/db_boat_type.php';


if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);

}else{
    $st = new struct_boat_house();
    $st->name = "*";
    $st->id = 0;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bootshaus bearbeiten | WOCS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Bootshaus hinzufügen/bearbeiten</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Bote</a> > <a href="table_boat_house.php">Bootshäuser</a> > Bearbeiten

</div>

<br>
<div class="container_default">



<form action="action_house_save.php">


    <table>

        <tr>
            <td>Name:</td>
            <td><input type="name" name="name" value="<?php echo $st->name; ?>"></td>

        </tr>




    </table>


    <input type="hidden" name="id" value="<?php echo $st->id; ?>">

    <input type="submit" value="Speichern">

</form>

</div>
</body>
</html>
