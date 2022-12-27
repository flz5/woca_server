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

include_once '../lib/boat/appstruct_boat.php';
include_once '../lib/boat/struct_boat_parameter.php';
include_once '../lib/boat/db_boat.php';

$param_ok = false;

//Check if all required parameters are set
if(isset($_GET['tag']) && isset($_GET['house']) && isset($_GET['type'])
    && isset ($_GET['seats_min']) && isset($_GET['seats_max']) && isset($_GET['weight'])){
    $param_ok = true;
}

if($param_ok){
    $kk = new struct_boat_parameter();
    $kk->type = $_GET['type'];
    $kk->house = $_GET['house'];
    $kk->seats_min = $_GET['seats_min'];
    $kk->seats_max = $_GET['seats_max'];
    $kk->weight = $_GET['weight'];
    $kk->tag = $_GET['tag'];

    $boats = db_boat_get($kk);
}

if(!isset($boats)){
    $bs = new appstruct_boat();
    $bs->name = "Keine Daten";
    $bs->seats = "1";
    $bs->type = "Fehler";
    $bs->place = "E100";
    $bs->weight = "10";
    $bs->tag1 = "X";
    $bs->tag1color = "#FF0000";
    $bs->tag2 = "X";
    $bs->tag2color = "#FF0000";
    $bs->tag3 = "X";
    $bs->tag3color = "#FF0000";
    $bs->tag4 = "X";
    $bs->tag4color = "#FF0000";

    $boats[] = $bs;
}

echo json_encode($boats);

?>
