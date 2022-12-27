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
include_once '../../lib/documents/db_document_files.php';
include_once '../../lib/documents/appstruct_document.php';

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
</head>
<body>

<h2>Dateiübersicht Dokumente</h2>

<a href="..\index.php"> Start </a> > <a href="index.php">Dokumente</a> > Dateiübersicht <br><br>

<a href="form_file_upload.php">Neu ...</a> <br><br>

<table border="1">
    <tr>
        <td>Dateiname</td>
        <td>Aktionen</td>
    </tr>


<?php


require_once '../../lib/documents/db_document_files.php';


$ll = document_getFileList();

if(isset($ll)){
    foreach ($ll as $value) {
        //$value = $value * 2;

        echo "<tr><td>";

        echo $value;
        $rr = $value;

        echo "</td><td><a href='fileDelete.php?id=".$rr."'>Löschen</a></td></tr>";

    }

}



?>



</table>


</body>
</html>
