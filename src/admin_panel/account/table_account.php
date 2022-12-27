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


if(!ss_account_isLoggedIn()){

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}

if(!ss_account_requestPermission("account",1)){
    die("Keine Berechtigung");
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
    <div style="font-size: x-large">Accounts</div>
    <a href="..\index.php">Start</a> > Accounts

</div>

<div class="container_default">

<br><br>
<a href="form_account_edit.php">Neu ...</a> <br>
<a href="table_groups.php">Gruppen</a>

<br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Login (Benutzername)</td>
        <td>E-Mail</td>
        <td>Gruppe</td>
        <td>Benutzername</td>
        <td>Letzter Versuche</td>
        <td>Letzter Login</td>
        <td>Status</td>
        <td>Erstellt von</td>
        <td>Aktionen</td>
    </tr>


    <?php

    echo $_SESSION['isLoggedIn'];

    $data = db_account_getData(false,0);

    foreach($data as $acc){

        echo "<tr>";
        echo"<td>".$acc->id . "</td>";
        echo"<td>".$acc->login_username . "</td>";
        echo"<td>".$acc->email . "</td>";
        echo"<td>".$acc->user_group . "</td>";
        echo"<td>".$acc->user_name . "</td>";
        echo"<td>".$acc->login_tries . "</td>";
        echo"<td>".$acc->login_time . "</td>";
        echo"<td>".$acc->state . "</td>";
        echo"<td>".$acc->createdBy . "</td>";

        echo "<td>";
        echo "<a href='form_passwort_edit.php?username=".$acc->id."'>Passwort ändern</a><br>";
        echo "<a href='form_account_edit.php?id=".$acc->id."'>Daten ändern</a><br>";
        echo "<a href='form_account_delete.php?id=".$acc->id."'>Löschen</a><br>";
        echo "</tr>";

    }

    ?>

</table>

</div>
</body>
</html>

