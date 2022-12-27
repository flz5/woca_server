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

if (!ss_account_requestPermission("boat", 2)) {
    die("Keine Berechtigung!");

}

include_once '../../lib/boat/struct_boat.php';
include_once '../../lib/boat/db_boat.php';

$obj = new struct_boat();
$obj->id = $_GET['id'];
$obj->house = $_GET['house'];
$obj->seats = $_GET['seats'];
$obj->type = $_GET['type'];
$obj->place = $_GET['place'];
$obj->tag1 = $_GET['tag1'];
$obj->tag2 = $_GET['tag2'];
$obj->tag3 = $_GET['tag3'];
$obj->tag4 = $_GET['tag4'];
$obj->weight = $_GET['weight'];
$obj->name = $_GET['name'];

//Wenn ID=0 neuen Eintrag anlegen

if($obj->id != ""){
    db_boat_edit(1,$obj);

}else{
    db_boat_new($obj);
}

header('Location: index.php', true, 301);
exit();

?>