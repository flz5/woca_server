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

function generatePassword() : string{
    $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $combLen = strlen($comb) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $combLen);
        $pass[] = $comb[$n];
    }
    return implode($pass);
}

if(!ss_account_isLoggedIn()){

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}

$dd = new struct_account();
$dd->state = $_POST['state'];
$dd->login_username = $_POST['login_username'];
$dd->user_group = $_POST['user_group'];
$dd->email = $_POST['email'];
$dd->user_name = $_POST['user_name'];
$dd->login_password = generatePassword();
$dd->createdBy = ss_account_getID();
$dd->login_tries = "0";
$dd->login_time = "0";

if(isset($_GET['id'])){
    if(!ss_account_requestPermission("account",2)){
        die("Keine Berechtigung");
    }
    db_account_updateDataSet($_GET['id'],$dd);
    header('Location: index.php', true, 301);
    exit();
}
else{
    if(!ss_account_requestPermission("account",4)){
        die("Keine Berechtigung");
    }
    db_account_createDataSet($dd);
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
    <div style="font-size: x-large">Account erstellt</div>
    <a href="..\index.php">Start</a> > <a href="index.php"> Accounts </a> > Speichern

</div>

<div class="container_default">

    <p class="box_success">

Der Account wurde erstellt. <br><br>

Passwort: "<?php echo $dd->login_password ?>" <br>

Die Anführungszeichen begrenzen das Passwort. Es wird nur einmalig auf dieser Seite angezeigt!

    </p>

</div>

</body>
</html>




