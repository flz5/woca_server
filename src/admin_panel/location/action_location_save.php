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
include_once '../../lib/location/db_location.php';
include_once '../../lib/location/struct_location.php';

if (!ss_account_isLoggedIn()) {

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("location", 2)) {
    die("Fehler: Keine Berechtigung!");

}

//Struktur aus GET Daten erstellen
$obj = new struct_location();
$obj->id = $_GET['id'];
$obj->name = $_GET['name'];
$obj->description = $_GET['description'];
$obj->address_city = $_GET['address_city'];
$obj->address_postal_code = $_GET['address_postal_code'];
$obj->address_street = $_GET['address_street'];
$obj->address_country = $_GET['address_country'];
$obj->type = $_GET['type'];
$obj->geo_long = $_GET['geo_long'];
$obj->geo_lat = $_GET['geo_lat'];

if(!db_location_checkStruct($obj)){
    die("Fehler: Daten unvollständig!");
}

//Wenn ID=0 neuen Eintrag anlegen
if($obj->id != 0){
    db_location_edit(1,$obj);

}else{
    db_location_new($obj);
}

header('Location: index.php', true, 301);
exit();

?>