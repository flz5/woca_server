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
}

if (!ss_account_requestPermission("training", 2)) {
    die("Keine Berechtigung!");
}

include_once '../../lib/training/db_training.php';
include_once '../../lib/training/struct_training.php';

$st = new struct_training();
$st->name = $_GET['name'];
$st->description = $_GET['description'];
$st->day = $_GET['day'];
$st->start_hour = $_GET['start_hour'];
$st->start_minute = $_GET['start_minute'];
$st->end_hour = $_GET['end_hour'];
$st->end_minute = $_GET['end_minute'];
$st->color = $_GET['color'];
$st->location = $_GET['location'];
$st->group = $_GET['group'];
$st->id = $_GET['id'];

//Wenn ID=0 neuen Eintrag anlegen

if(!db_training_checkStruct($st)){
    die("Daten unvollständig!");
}

if($st->id != 0){
    db_training_edit($st);

}else{
    db_training_new($st);
}

header('Location: index.php', true, 301);
exit();

?>