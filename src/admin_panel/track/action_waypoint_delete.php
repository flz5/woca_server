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
include_once '../../lib/training/db_training.php';


if (!ss_account_isLoggedIn()) {

    //header('Location: ../login/form_login.php?option=p', true, 301);
    // exit();
    //die("Nicht angemeldet");
}

if (!ss_account_requestPermission("event", 2)) {
    //die("Keine Berechtigung!");

}

include_once '../../lib/track/track_waypoint.php';
include_once '../../lib/track/track_startpoint.php';

if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);

    $gg = new track_waypoint();
    $gg->delete($st->id);

    $ff = new track_startpoint();
    $ff->increaseVersion($st->startpoint);

    header('Location: index.php', true, 301);
    exit();


}else{
    echo "Ungültig!";
}


?>

