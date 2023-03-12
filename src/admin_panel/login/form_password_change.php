<?php
/*
 * This file is part of the WOCA (server) project.
 * Copyright (c) 2020-2023 Frank Zimdars.
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account erstellt | WOCA</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Passwort ändern</div>
    <a href="..\index.php">Start</a> > Passwort ändern

</div>

<div class="container_default"><br><br>

<?php

if(isset($_GET['option'])){
    echo "<div class='dnote'>";

    switch($_GET['option']){
        case 'c1':{
            echo "Das alte Password ist nicht korrekt!";
        }break;
        case 'c2':{
            echo "Neues Passwort stimmt nicht mit Wiederholung überein!";
        }break;
        case 'c3':{
            echo "Die Ausführung ist fehlgeschlagen!";
        }break;
        case 'c4':{
            echo "Es wurden nicht alle Felder ausgefüllt!";
        }break;
    }
    echo "</div>";
}


?>

<form action="action_password_change.php" method="post">
    <table>
        <tr>
            <td>Altes Passwort:</td>
            <td><input type="name" name="password_old" value=""></td>
        </tr>
        <tr>
            <td>Neues Passwort:</td>
            <td><input type="name" name="password_new1" value=""></td>
        </tr>
        <tr>
            <td>Neues Passwort:</td>
            <td><input type="name" name="password_new2" value=""></td>
        </tr>
        <tr>
            <td><input type="submit" value="Speichern"></td>
        </tr>
    </table>
</form>

</div>
</body>
</html>