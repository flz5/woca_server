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

include_once dirname(__FILE__) . "/../config.php";
include_once "appstruct_event.php";

function db_event_getAppStructAll(){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from event");
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){


        $bs = new  appstruct_training();

        $bs->title = $dsatz['name'];
        $bs->description = $dsatz['description'];
        $bs->day = $dsatz['day'];
        $bs->start_hour = $dsatz['start_hour'];
        $bs->start_minute = $dsatz['start_minute'];
        $bs->end_hour = $dsatz['end_hour'];
        $bs->end_minute = $dsatz['end_minute'];
        $bs->color = "#".$dsatz['color'];

        //Trainignsgruppe

        $stmt2 = $mysqli->prepare("select * from event_group WHERE id = ?");
        $stmt2->bind_param('i',$dsatz['event_group']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $r = $result2->fetch_array();

        $bs->group = $r['name'];

        //Ort

        $stmt3 = $mysqli->prepare("select * from location WHERE id = ?");
        $stmt3->bind_param('i',$dsatz['location']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $p = $result3->fetch_array();



        $bs->geo_lat = $p['geo_lat'];
        $bs->geo_long = $p['geo_long'];
        $bs->place = $p['name'];

        if($p['type'] == 0){
            $bs->hasLocation = "false";
            $bs->address = $p['address_street'];

        }else if($p['type'] == 1 or $p['type'] == 3){
            $bs->hasLocation = "true";
            $bs->address = $p['address_street'] . "," . $p['address_postal_code']. " ". $p['address_city'] .
                "," . $p['address_country'];
        }
        else if($p['type'] == 2){
            $bs->hasLocation = "true";
            $bs->address = "";
        }

        if($bs->start_hour == 99){
            $bs->hasDate = "false";
        }else{
            $bs->hasDate = "true";
        }

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats;


}