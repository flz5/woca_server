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

    die("Nicht angemeldet!");
}


if(db_account_checkLogin(ss_account_getLoginUsername(),$_POST['password_old']) == -1){


    header('Location: form_passwort_edit.php?option=c1', true, 301);
    exit();
}


if($_POST['password_new1'] == ""){
    header('Location: form_passwort_edit.php?option=c4', true, 301);
    exit();
}


if($_POST['password_new1'] != $_POST['password_new2']){
    header('Location: form_passwort_edit.php?option=c2', true, 301);
    exit();
}

$status = db_account_changePasswort(ss_account_getID(),$_POST['password_new1']);

if($status){


    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>Title</title>";
    echo "<link rel='stylesheet'' href='../css/style.css'>";
    echo "</head>";
    echo "<body>";


    echo "<div class='d4'>";
    echo "<p class='p4'>";
    echo "Änderung ok";
    echo "<p/>";
    echo "Änderung der Daten erfolgreich. Die neuen Daten sind beim nächsten Anmelden gültig.<br><br>";
    echo "<a href='../index.html'>OK</a><br><br>";
    echo "</div></body></html>";


}else{
    header('Location: form_passwort_edit.php?option=c3', true, 301);
    exit();
}


