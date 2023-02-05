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

if (!ss_account_requestPermission("event", 1)) {
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

<h2>Übersicht</h2>

<a href="..\index.php">Start</a> > <a href="index.php">Trainingszeiten</a> > Teilnehmer<br><br>
<a href="action_slot_clear.php">Zurücksetzen</a> <br> <br>


<table border="1">
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Zeit</td>

    </tr>

    <?php
    include_once "../../lib/slots/slot_event.php";
    include_once '../../lib/training/db_training_group.php';

    $tt = new slot_event();
    $tt->setUserID(ss_account_getID());
    $list = $tt->getListEvent($_GET['id'],0);

    if(isset($list)){
        foreach ($list as $bb){
            echo "<tr>";
            echo"<td>".$bb->id . "</td>";
            echo"<td>".$bb->user_name . "</td>";
            echo"<td>".$bb->time . "</td>";

            $json = json_encode($bb);
            echo "<a href='action_slot_delete.php?id=".$bb->id."'>Löschen</a></td>";
            echo "<tr>";
        }
    }
    ?>

</table>

</body>
</html>