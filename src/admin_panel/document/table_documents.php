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
include_once '../../lib/documents/db_document.php';
include_once '../../lib/documents/appstruct_document.php';

if (!ss_account_isLoggedIn()) {

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}

if (!ss_account_requestPermission("documents", 2)) {
    die("Keine Berechtigung!");

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<h2>Übersicht Kontakte</h2>

<a href="..\index.php">Start</a> > Dokumente <br>

<a href="formEditDocument.php">Neuer Eintrag</a>
<a href="table_files.php">Dateien verwalten</a> <br>

<br>

<table border="1">
    <tr>

        <td>Titel</td>
        <td>Name</td>
        <td>Beschreibung</td>
        <td>Dateiname</td>
        <td>Version</td>
        <td>Aktion</td>
    </tr>


    <?php
    include_once "../../lib/contact/contact_db.php";
    include_once '../../lib/contact/contact_appstruct.php';

    $boats = db_document_getAll();

    if(isset($boats)){
        foreach ($boats as $bb){
            echo "<tr>";
            echo"<td>".$bb->title . "</td>";
            echo"<td>".$bb->name . "</td>";
            echo"<td>".$bb->description . "</td>";
            echo"<td>".$bb->uri_file . "</td>";
            echo"<td>".$bb->version . "</td>";

            $json = json_encode($bb);

            echo "<td> <a href='formEditDocument.php?data=".$json."'>Bearbeiten</a> <a href='formDeleteDocument.php?data=".$json."'>Löschen</a></td>";
            echo "<tr>";
        }
    }




    ?>

</table>


</body>
</html>