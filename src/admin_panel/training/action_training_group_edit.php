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

if (!ss_account_requestPermission("training", 2)) {
    die("Keine Berechtigung!");
}

include_once '../../lib/training/db_training_group.php';
include_once '../../lib/training/struct_training_group.php';

$st = new struct_training_group();
$st->id = $_GET['id'];
$st->name = $_GET['name'];
$st->description = $_GET['description'];
$st->color = $_GET['color'];

//Wenn ID=0 neuen Eintrag anlegen

if(!db_training_checkGroupStruct($st)){
    die("Daten unvollständig!");
}

//Prüfen ob die Farbe einen gültigen RGB Wert darstellt
if (!preg_match("#^[a-fA-F0-9]+$#", $st->color)) {
    die("Farbwert ist ungültig (ungültiges Zeichen vorhanden A-F*0-9 erlaubt)");
}

if($st->id != 0){
    db_training_editGroup($st);
    
}else{
    db_training_newGroup($st);
}

header('Location: table_training_group.php', true, 301);
exit();

?>