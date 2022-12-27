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

include_once '../lib/account/db_account.php';
include_once '../lib/account/session_login.php';




if(!ss_account_isLoggedIn()){

    header('Location: login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WOCS Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="padding: 0;margin: 0;">

<div style="background-color: #295a9f;color: white;margin:0px;position:relative;box-sizing:border-box;padding: 0;padding-left: 15px">
    <div style="font-size: x-large">WOCS Admin Panel</div>
    Start
</div>

<div style="padding-left: 15px">

<br>
Grundmodule: <br>
<a href="contact/index.php">Kontakte</a><br>
<a href="location/index.php">Orte</a><br>
<a href="account/index.php">Accounts</a><br><br>

Module: <br>

<a href="boat/index.php">Boote</a> <br>
<a href="training/index.php">Traininszeiten</a><br>
<a href="event/index.php">Events</a><br>
<a href="slots/index.php">Slots</a><br>

<a href="document/index.php">Dokumente</a><br>
<a href="message/index.php">Nachrichten (Admin)</a><br>
<a href="message_user/index.php">Nachrichten</a><br>

<br><br>

Account: <br>
    <a href="login/form_password_change.php">Passwort ändern</a><br>
    <a href="login/action_logout.php">Abmelden</a><br>

<br><br>

System:<br>

    <a href="about.php">Info über ...</a><br>
    <a href="help/index.php">Hilfe</a><br>
    <br><br>

</div>
</body>
</html>