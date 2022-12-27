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

if (!ss_account_requestPermission("location", 1)) {
    die("Fehler: Keine Berechtigung!");

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
    <div style="font-size: x-large">Übersicht Orte | WOCS Admin Panel</div>
    <a href="..\index.php">Start</a> > Orte

</div>

<br>

<div class="container_default">


<a href="form_location_edit.php">Neu ...</a> <br><br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Beschreibung</td>
        <td>Typ</td>
        <td>Straße</td>
        <td>Stadt</td>
        <td>PLZ</td>
        <td>Land</td>
        <td>Geo. Lat.</td>
        <td>Geo. Long.</td>
        <td>Aktion</td>

    </tr>


    <?php
    include_once "../../lib/location/db_location.php";
    include_once '../../lib/location/struct_location.php';

    $boats = db_location_getAll();

    if(isset($boats)){
        foreach ($boats as $bb){
            echo "<tr>";
            echo"<td>".$bb->id . "</td>";
            echo"<td>".$bb->name . "</td>";
            echo"<td>".$bb->description . "</td>";
            echo"<td>".$bb->type . "</td>";
            echo"<td>".$bb->address_street . "</td>";
            echo"<td>".$bb->address_city . "</td>";
            echo"<td>".$bb->address_postal_code . "</td>";
            echo"<td>".$bb->address_country . "</td>";
            echo"<td>".$bb->geo_lat . "</td>";
            echo"<td>".$bb->geo_long . "</td>";

            $json = json_encode($bb);
            echo "<td> <a href='formEditLocation.php?data=".$json."'>Bearbeiten</a> <a href='formDeleteLocation.php?data=".$json."'>Löschen</a></td>";
            echo "<tr>";
        }
    }




    ?>

</table>
</div>
</body>
</html>