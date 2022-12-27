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

//Parameter:
//Anzeigeparameter
//Form abgesendet

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

if(isset($_GET['id'])){
    $st = db_account_getData(true,$_GET['id']);
    $dd = $st[0];
    var_dump($dd);

}else{
    $dd = new struct_account();
    $dd->user_group = "";
    $dd->user_name = "";
    $dd->login_username = "";
    $dd->email = "";
    $dd->state = "";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account bearbeiten | WOCS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Account bearbeiten</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Account</a> > Account hinzufügen/bearbeiten

</div>

<div class="container_default">
 <br><br>

<p class="box_note">
    Info: Das Passwort wird nicht geändert.


</p>

<form action="action_account_save.php" method="post">


    <table>

        <tr>
            <td>Login Benutzername:</td>
            <td><input type="name" name="login_username" value="<?php echo $dd->login_username; ?>"></td>

        </tr>


        <tr>
            <td>Name:</td>
            <td><input type="name" name="user_name" value="<?php echo $dd->user_name; ?>"></td>

        </tr>

        <tr>
            <td>E-Mail:</td>
            <td><input type="name" name="email" value="<?php echo $dd->email; ?>"></td>

        </tr>

        <tr>
            <td>Gruppe:</td>
            <td><input type="name" name="user_group" value="<?php echo $dd->user_group; ?>"></td>

        </tr>

        <tr>
            <td>Status:</td>
            <td>

                <select name="state" id="state">

                    <option value="0">Dauerhaft gesperrt</option>
                    <option value="1">Temporär gesperrt</option>
                    <option value="2">Inaktiv</option>
                    <option value="10">Aktiv</option>

                </select>
            </td>

        </tr>


    </table>


    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? null; ?>">

    <input type="submit" value="Speichern">

</form>
</div>
</body>

</html>
