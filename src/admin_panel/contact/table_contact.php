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

if (!ss_account_requestPermission("contact", 2)) {
    die("Keine Berechtigung!");

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container_header">
    <div style="font-size: x-large">Übersicht Kontakte</div>
    <a href="..\index.php">Start</a> > Kontakte

</div>

<div class="container_default">


 <br>

<a href="form_contact_edit.php">Neuer Eintrag</a>
<a href="table_images.php">Bilder verwalten</a> <br>

<br>

<table border="1">
    <tr>

        <td>Titel</td>
        <td>Name</td>
        <td>Telefon</td>
        <td>Handynummer</td>
        <td>E-Mail</td>
        <td>Bild</td>
        <td>Version</td>
        <td>Aktion</td>

    </tr>


    <?php
    include_once "../../lib/contact/contact_db.php";
    include_once '../../lib/contact/contact_appstruct.php';

    $boats = db_contact_getAll();

    if(isset($boats)){
        foreach ($boats as $bb){
            echo "<tr>";
            echo"<td>".$bb->title . "</td>";
            echo"<td>".$bb->name . "</td>";
            echo"<td>".$bb->telephone . "</td>";
            echo"<td>".$bb->mobile . "</td>";
            echo"<td>".$bb->mail . "</td>";
            echo"<td>".$bb->img . "</td>";
            echo"<td>".$bb->version . "</td>";

            $json = json_encode($bb);

            echo "<td> <a href='form_contact_edit.php?data=".$json."'>Bearbeiten</a> <a href='form_contact_delete.php?data=".$json."'>Löschen</a></td>";
            echo "<tr>";
        }
    }




    ?>

</table>

</div>
</body>
</html>