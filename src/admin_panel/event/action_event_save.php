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
include_once "../../lib/events/db_event.php";
include_once '../../lib/events/appstruct_event.php';

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("training", 2)) {
    die("Keine Berechtigung!");
}

$st = new struct_event();
$st->name = $_GET['name'];
$st->description = $_GET['description'];
$st->time_start = $_GET['time_start'];
$st->time_end = $_GET['time_end'];
$st->slots = $_GET['slots'];
$st->color = $_GET['color'];
$st->location = $_GET['location'];
$st->group = $_GET['group'];
$st->id = $_GET['id'];

//Prüfen ob die Daten vollständig sind
if(!db_event_checkStruct($st)){
    die("Daten unvollständig!");
}

//Wenn ID=0 neuen Eintrag anlegen
if($st->id != 0){
    db_event_edit($st);

}else{
    db_event_new($st);
}

header('Location: index.php', true, 301);
exit();

?>