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

    //header('Location: ../login/form_login.php?option=p', true, 301);
    //exit();
    //die("Nicht angemeldet");
}

if (!ss_account_requestPermission("event", 2)) {
    //die("Keine Berechtigung!");

}


include_once "../../lib/events/db_event.php";
include_once '../../lib/track/track_waypoint.php';
include_once '../../lib/track/track_startpoint.php';

$st = new struct_track_startpoint();
$st->id = $_GET['id'];
$st->name = $_GET['name'];
$st->version = $_GET['version'];


$gg = new track_startpoint();

if($st->id != 0){

    $gg->edit($st);
    echo "OO";

}else{
    $gg->new($st);
}


//header('Location: table_waypoint.php?id='.$st->id, true, 301);
exit();

?>