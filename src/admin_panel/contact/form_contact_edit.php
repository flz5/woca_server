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



//Parameter:
//Anzeigeparameter
//Form abgesendet


if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);
    $id = $st->id;
    $name = $st->name;
    $title = $st->title;
    $mobile = $st->mobile;
    $mail = $st->mail;
    $img = $st->img;
    $ver = $st->version + 1;
    $telephone = $st->telephone;


}else{
    $id = "";
    $name = "";
    $title = "";
    $mobile = "";
    $mail = "";
    $img = "";
    $ver = "1";
    $telephone = "";
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
    <div style="font-size: x-large">Kontakte bearbeiten</div>
    <a href="..\index.php">Start</a> > Kontakte > Kontakt bearbeiten/erstellen</a>

</div>

<div class="container_default">


<br>


<?php echo $name; ?>

<form action="action_contact_edit.php">


    <table>

        <tr>
            <td>Titel:</td>
            <td><input type="text" name="title" value="<?php echo $title; ?>"></td>

        </tr>
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name" value="<?php echo $name; ?>"></td>

        </tr>

        <tr>
            <td>E-Mail:</td>
            <td><input type="text" name="mail" value="<?php echo $mail; ?>"></td>

        </tr>

        <tr>
            <td>Telefon:</td>
            <td><input type="text" name = "telephone" value="<?php echo $telephone; ?>"></td>

        </tr>

        <tr>
            <td>Handy:</td>
            <td><input type="text" name="mobile" value="<?php echo $mobile; ?>"></td>

        </tr>

        <tr>
            <td>Bild:</td>
            <td><input type="text" name="img" value="<?php echo $img; ?>"></td>

        </tr>

        <tr>
            <td>Version:</td>
            <td><input type="text" name = "ver" readonly value="<?php echo $ver; ?>"></td>

        </tr>

    </table>


    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input type="submit" value="Speichern">

</form>
</div>

</html>
