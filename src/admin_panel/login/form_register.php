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

include_once '../../lib/config.php';
include_once '../../lib/account/db_account.php';
include_once '../../lib/account/session_login.php';




if(!$cfg_registration_enabled){

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}


?>

<html>

<h2>Passwort ändern</h2>

<a href="..\index.html">Start</a> > Passwort ändern <br><br>


<?php

if(isset($_GET['option'])){

    echo "<p style='background-color:yellow'>Fehler beim ausführen</p>";

}


?>


<form action="savePassword.php" method="post">


    <table>

        <tr>
            <td>Benutzername:</td>
            <td><input type="name" name="id" value="<?php echo $_GET['username'] ?>"></td>

        </tr>


        <tr>
            <td>Neues Passwort:</td>
            <td><input type="name" name="password_new1" value=""></td>

        </tr>

        <tr>
            <td>Neues Passwort:</td>
            <td><input type="name" name="password_new2" value=""></td>

        </tr>
    </table>

    <input type="submit" value="Speichern">

</form>


</html>