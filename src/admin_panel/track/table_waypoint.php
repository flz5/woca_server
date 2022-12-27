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

    //header('Location: ../login/form_login.php?option=p', true, 301);
    //exit();
    //die("Nicht angemeldet");
}

if (!ss_account_requestPermission("event", 1)) {
    //die("Keine Berechtigung!");

}

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    die("ID bentigt!");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event - Übersicht</title>
</head>
<body>

<h2>Übersicht</h2>

<a href="..\index.php">Start</a> > Strecken > Streckenpositionen<br><br>
<a href="form_waypoint_edit.php?nv=<?php echo $id;?>">Neu ...</a> <br>


<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Entfernung</td>
        <td>Aktion</td>
    </tr>


    <?php
    include_once "../../lib/track/track_waypoint.php";
    //include_once '../../lib/events/appstruct_event.php';

    $gg = new track_waypoint();

    $boats = $gg->getAllByStartpoint($id);

    foreach ($boats as $bb){
        echo "<tr>";
        echo"<td>".$bb->id . "</td>";
        echo"<td>".$bb->name . "</td>";
        echo"<td>".$bb->distance . "</td>";

        $json = json_encode($bb);
        echo "<td> <a href='form_waypoint_edit.php?data=".$json."'>Bearbeiten</a><a href='form_waypoint_delete.php?data=".$json."'>Löschen</a></td>";
        echo "<tr>";
    }


    ?>

</table>


</body>
</html>