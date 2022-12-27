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

if (!ss_account_requestPermission("location", 2)) {
    die("Keine Berechtigung!");

}
//Parameter:
//Anzeigeparameter
//Form abgesendet

include_once '../../lib/location/db_location.php';
include_once '../../lib/location/struct_location.php';

include_once '../../lib/boat/struct_boat_house.php';
include_once '../../lib/boat/struct_boat_type.php';
include_once '../../lib/boat/struct_boat_tags.php';

include_once '../../lib/boat/db_boat_house.php';
include_once '../../lib/boat/db_boat_tags.php';
include_once '../../lib/boat/db_boat_type.php';

if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);

    if(!db_location_checkStruct($st)){
        die("Daten ungültig!");
    }


}else{
    $st = new struct_location();
    $st->type = 0;
    $st->id = 0;
    $st->name = "*";
    $st->description = "*";
    $st->address_city = "*";
    $st->address_postal_code = "*";
    $st->address_country = "*";
    $st->address_street = "*";
    $st->geo_lat = "*";
    $st->geo_long = "*";
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
    <div style="font-size: x-large">Ort hinzufügen/bearbeiten  | WOCS Admin Panel</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Orte</a> > Ort hinzufügen/bearbeiten

</div>


<div class="container_default">
    <br>



<form action="action_location_save.php">


    <table>

        <tr>
            <td>Name:</td>
            <td><input type="name" name="name" value="<?php echo $st->name; ?>"></td>

        </tr>
        <tr>
            <td>Typ:</td>
            <td><input type="name" name="type" value="<?php echo $st->type; ?>"></td>

        </tr>

        <tr>
            <td>Beschreibung:</td>
            <td><input type="name" name="description" value="<?php echo $st->description; ?>"></td>

        </tr>

        <tr>
            <td>Straße:</td>
            <td><input type="name" name="address_street" value="<?php echo $st->address_street; ?>"></td>

        </tr>
        <tr>
            <td>Ort:</td>
            <td><input type="name" name="address_city" value="<?php echo $st->address_city; ?>"></td>

        </tr>
        <tr>
            <td>PLZ:</td>
            <td><input type="name" name="address_postal_code" value="<?php echo $st->address_postal_code; ?>"></td>

        </tr>
        <tr>
            <td>Land:</td>
            <td><input type="name" name="address_country" value="<?php echo $st->address_country; ?>"></td>

        </tr>
        <tr>
            <td>Geo. Lat.:</td>
            <td><input type="name" name="geo_lat" value="<?php echo $st->geo_lat; ?>"></td>

        </tr>

        <tr>
            <td>Geo. Long.:</td>
            <td><input type="name" name="geo_long" value="<?php echo $st->geo_long; ?>"></td>

        </tr>



    </table>

    Hinweis: <br>
    Typ 0 = Keine Addresse oder GPS<br>
    Typ 1 = Nur Addresse<br>
    Typ 2 = Nur GPS<br>
    Typ 3 = Beides<br>


    <input type="hidden" name="id" value="<?php echo $st->id; ?>">

    <input type="submit" value="Speichern">

</form>


</html>
