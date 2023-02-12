<?php
/*
 * This file is part of the WOCA (server) project.
 * Copyright (c) 2020-2023 Frank Zimdars.
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
include_once "../../lib/events/db_event.php";
include_once "../../lib/events/db_event_group.php";
include_once "../../lib/events/struct_event_group_raw.php";

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("event", 2)) {
    die("Keine Berechtigung!");
}

$st = new struct_event_group_raw();
$st->id = $_POST['id'];
$st->name = $_POST['name'];
$st->description = $_POST['description'];
$st->color = $_POST['color'];

if(!db_event_checkGroupStruct($st)){
    die("Daten unvollständig!");
}

//Wenn ID=0 neuen Eintrag anlegen
if($st->id != 0){
    db_event_group_edit($st);
}else{
    db_event_group_new($st);
}

header('Location: table_group.php', true, 301);
exit();

?>