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

include_once '../../lib/boat/struct_boat_tags.php';
include_once '../../lib/boat/db_boat_tags.php';

$obj = new struct_boat_tag();
$obj->id = $_GET['id'];
$obj->name = $_GET['name'];
$obj->name_short = $_GET['name_short'];
$obj->color = $_GET['color'];
$obj->display = $_GET['display'];


//Wenn ID=0 neuen Eintrag anlegen

if($obj->id != 0){
    db_boat_editTag(1,$obj);

}else{
    db_boat_newTag($obj);
}

header('Location: table_boat_tags.php', true, 301);
exit();

?>