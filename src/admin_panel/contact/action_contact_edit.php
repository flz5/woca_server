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
include_once '../../lib/contact/contact_db.php';

if (!ss_account_isLoggedIn()) {

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}

if (!ss_account_requestPermission("contact", 2)) {
    die("Keine Berechtigung!");

}

include_once '../../lib/contact/contact_db.php';
include_once '../../lib/contact/contact_appstruct.php';

$obj = new _contactAppstruct();
$obj->title = $_GET['title'];
$obj->name = $_GET['name'];
$obj->mail = $_GET['mail'];
$obj->telephone = $_GET['telephone'];
$obj->mobile = $_GET['mobile'];
$obj->id = $_GET['id'];
$obj->img = $_GET['img'];
$obj->version = $_GET['ver'];


//Wenn ID=0 neuen Eintrag anlegen

if($obj->id != ""){
    contact_edit($obj);

}else{
    contact_new($obj);
}


header('Location: index.php', true, 301);
exit();

?>