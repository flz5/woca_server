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

include_once dirname(__FILE__) . "/../config.php";
include_once dirname(__FILE__) . "/struct_event_slot_joined.php";

function db_event_slots_get_list(int $event_id) : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select event_slot.id, event_id, user_id,time, account.user_name from event_slot LEFT JOIN account ".
        "ON event_slot.user_id = account.id WHERE event_id = ?");
    $stmt->bind_param('i',$event_id);

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $col){
        $st = new struct_event_slot_joined();
        $st->id = $col['id'];
        $st->event_id = $col['event_id'];
        $st->user_name = $col['user_name'];
        $st->user_id = $col['user_id'];
        $st->time = $col['time'];
        $results[] = $st;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results ?? null;
}

function db_event_slots_clear(int $event_id) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM event_slot WHERE event_id=?");
    $stmt->bind_param('i',$event_id);

    $stmt->execute();
    $stmt->close();
}


function db_event_slots_get_count(int $event_id) :int {

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select COUNT(*) from event_slot WHERE event_id = ?");
    $stmt->bind_param('i',$event_id);

    $stmt->execute();
    $result = $stmt->get_result();

    $cc = 0;
    foreach($result->fetch_all(MYSQLI_ASSOC) as $col){
        $cc = $col["COUNT(*)"];
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $cc;
}

function db_event_slot_register(int $event_id, int $user_id) : void{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    $time = time();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO event_slot (event_id, user_id, time) VALUES (?,?,?)");
    $stmt->bind_param('iii',$event_id, $user_id, $time);

    $stmt->execute();
    $stmt->close();

}

function db_event_slot_delete(int $id, int $user_id) : void{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    if($user_id == 0){
        $stmt = $mysqli->prepare("DELETE FROM event_slot WHERE id=?");
        $stmt->bind_param('i',$id);
    }else{
        $stmt = $mysqli->prepare("DELETE FROM event_slot WHERE id=? AND user_id = ?");
        $stmt->bind_param('ii',$id,$user_id);
    }

    $stmt->execute();
    $stmt->close();
}

function db_event_slot_get_item(int $id) : ?struct_event_slot_joined{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from event_slot WHERE event_id = ?");
    $stmt->bind_param('i',$event_id, $time_min);

    $stmt->execute();
    $result = $stmt->get_result();

    $list = 0;
    foreach($result->fetch_all(MYSQLI_ASSOC) as $col){
        $st = new struct_event_slot_joined();
        $st->event_id = $col['event_id'];
        $st->user_id = $col['user_id'];
        $st->time = $col['time'];
        $list[] = $st;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $list[0];

}
