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
}

if (!ss_account_requestPermission("training", 1)) {
    die("Keine Berechtigung!");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account erstellt | WOCS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Übersicht</div>
    <a href="..\index.php">Start</a> > Trainingszeiten

</div>

<div class="container_default">
    <br>
<a href="form_training_edit.php">Neu ...</a> <br>

<a href="table_training_group.php">Gruppen</a><br><br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Beschreibung</td>
        <td>Tag</td>
        <td>Start (h)</td>
        <td>Start (m)</td>
        <td>Ende (h)</td>
        <td>Ende (m)</td>
        <td>Farbe</td>
        <td>Ort</td>
        <td>Gruppe</td>
        <td>Aktion</td>
    </tr>

    <?php
    include_once "../../lib/training/db_training.php";
    include_once '../../lib/training/struct_training.php';

    $list = db_training_getAll();

    if($list != null){
        foreach ($list as $bb){
            echo "<tr>";
            echo"<td>".$bb->id . "</td>";
            echo"<td>".$bb->name . "</td>";
            echo"<td>".$bb->description . "</td>";
            echo"<td>".$bb->day . "</td>";
            echo"<td>".$bb->start_hour . "</td>";
            echo"<td>".$bb->start_minute . "</td>";
            echo"<td>".$bb->end_hour . "</td>";
            echo"<td>".$bb->end_minute . "</td>";
            echo"<td>".$bb->color . "</td>";
            echo"<td>".$bb->location . "</td>";
            echo"<td>".$bb->group . "</td>";

            $json = json_encode($bb);
            echo "<td>";
            echo "<a href='form_training_edit.php?data=".$json."'>Bearbeiten</a> ";
            echo "<a href='form_training_delete.php?data=".$json."'>Löschen</a>";
            echo "</td>";
            echo "<tr>";
        }
    }
    ?>

</table>

</div>
</body>
</html>