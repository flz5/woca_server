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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Boot-Tag | WOCA</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Boot-Tag hinzufügen/bearbeiten</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Boote</a> > Tags

</div>

<br>
<div class="container_default">

<a href="form_tag_edit.php">Neu ...</a> <br>


<table border="1">
    <tr>
        <td>IDa</td>
        <td>NameL</td>
        <td>Name (kurz)d</td>
        <td>Farbe</td>
        <td>Anzeigen</td>
        <td>Aktion</td>

    </tr>


    <?php
    include_once "../../lib/boat/struct_boat_tags.php";
    include_once '../../lib/boat/db_boat_tags.php';

    $boats = db_boat_getTagAll();

    if(isset($boats)){
        foreach ($boats as $bb){
            echo "<tr>";
            echo"<td>".$bb->id . "</td>";
            echo"<td>".$bb->name . "</td>";
            echo"<td>".$bb->name_short . "</td>";
            echo"<td>".$bb->color . "</td>";
            echo"<td>".$bb->display . "</td>";
            $json = json_encode($bb);

            echo "<td> <a href='form_tag_edit.php?data=".$json."'>Bearbeiten</a><a href='form_tag_delete.php?data=".$json."'>Löschen</a></td>";
            echo "<tr>";
        }
    }




    ?>



</table>

</div>
</body>
</html>