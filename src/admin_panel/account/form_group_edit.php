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
include_once '../../lib/permissions/permission.php';

if(!ss_account_isLoggedIn()){
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}

if(!ss_account_requestPermission("permissions",1)){
    die("Keine Berechtigung!");
}

if(isset($_GET['new'])){
    $ht = "";
    $group = "neu";
}else{
    $ht = permission_readFile($_GET['group']);
    $group = $_GET['group'];
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

<br>

<div class="container_default">

<form action="action_group_save.php" method="post">

    Gruppe: <input type="text" name="group" value="<?php echo $group ?>"><br>
    Inhalt: <br>


    <textarea name="text" cols="40" rows="20"><?php echo $ht; ?></textarea><br>
    <input type="submit" value="Speichern">

</form>

</div>

</html>