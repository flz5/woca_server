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

/**
 * Liest alle Einträge in der Slotdatenbank die in dem Angegebenen Zeitraum (Unix Timestamp )liegen.
 *
 * @param $event_id ; ID der Veranstaltung/Training
 * @param $time_min ; Untere Grenze
 * @param $time_max ; Obere Grenze
 * @return struct_slot_user[]|null
 */
function db_slots_event_getAllWhereEvent(int $event_id) : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);


        $stmt = $mysqli->prepare("select * from slot_event LEFT JOIN account ".
            "ON slot_event.user_id = account.id");
        $stmt->bind_param('i',$event_id, $time_min);


    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_slot_user();
        $rr->id = $dsatz['id'];
        $rr->eventID = $dsatz['event_id'];
        $rr->user_name = $dsatz['user_name'];
        $rr->userID = $dsatz['user_id'];

        $results[] = $rr;

    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}

/**
 * Liest alle Einträge in der Slotdatenbank die in dem Angegebenen Zeitraum (Unix Timestamp )liegen.
 *
 * @param $event_id ; ID der Veranstaltung/Training
 * @param $time_min ; Untere Grenze
 * @param $time_max ; Obere Grenze
 * @return struct_slot_event[]|null
 */

function db_slots_event_getAllWhereUser(int $user_id,int $all) : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;
    $tt = time();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    if(!$all){
        $stmt = $mysqli->prepare("select * from slot_event LEFT JOIN event ".
            "ON slot_event.event_id = event.id WHERE slot_event.user_id = ? AND event.time_end > ?");
        $stmt->bind_param('ii',$user_id,$tt);
    }else{
        $stmt = $mysqli->prepare("select * from slot_event LEFT JOIN event ".
            "ON slot_event.event_id = event.id WHERE slot_event.user_id = ?");
        $stmt->bind_param('ii',$user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_slot_event();
        $rr->id = $dsatz['id'];
        $rr->eventID = $dsatz['event_id'];
        $rr->event_start = $dsatz['name'];
        $rr->userID = $dsatz['user_id'];
        $results[] = $rr;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}


/**
 * Löscht alle einträge in dem angegebenen Zeitraum
 * @param int $event_id
 * @param int $time_min
 * @param int $time_max
 * @return void
 */
function db_slots_event_clear(int $event_id,int $time_min,int $time_max = 0) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    if($time_max == 0){
        $stmt = $mysqli->prepare("DELETE FROM slot_event WHERE event_id=? AND time > ?");
        $stmt->bind_param('ii',$event_id,$time_min);
    }else{
        $stmt = $mysqli->prepare("DELETE FROM slot_event WHERE event_id=? AND time > ? AND time < ?");
        $stmt->bind_param('iii',$event_id,$time_min,$time_max);
    }

    $stmt->execute();
    $stmt->close();

}

/**
 * Anzahl der Einträge für ein Event innerhalb des Zeitraumes
 * @param int $event_id Event-ID
 * @param int $time_min Untere Grenze
 * @param int $time_max Obere Grenze
 * @return int
 */
function db_slots_event_getCount(int $event_id) :int {

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);


        $stmt = $mysqli->prepare("select COUNT(*) from slot_event WHERE event_id = ?");
        $stmt->bind_param('i',$event_id, $time_min);


    $stmt->execute();
    $result = $stmt->get_result();

    $cc = 0;
    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $cc = $dsatz["COUNT(*)"];

    }

    /* Verbindung schließen */
    $mysqli->close();
    return $cc;

}

/**
 * Fügt einen neuen Eintrag hinzu
 *
 * @param int $event_id
 * @param int $user_id
 * @return void
 */
function db_slots_event_register(int $event_id, int $user_id) : void{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    $time = time();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO slot_event (event_id,user_id,time) 
                VALUES (?,?,?)");
    $stmt->bind_param('iii',$event_id,
        $user_id,
        $time);

    $stmt->execute();
    $stmt->close();

}

/**
 * Löscht einen Eintrag
 *
 * @param int $id       ID des Eintrags
 * @param int $user_id  ID des Benutzers
 * @param int $time     Untergrenze Zeitpunkt. Zu löschender Eintrag muss neuer Sein
 * @return void
 */

function db_slots_event_delete(int $id,int $user_id,int $time) : void{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    if($user_id == 0){
        $stmt = $mysqli->prepare("DELETE FROM slot_event WHERE id=? AND time > ?");
        $stmt->bind_param('ii',$id,$time);
    }else{
        $stmt = $mysqli->prepare("DELETE FROM slot_event WHERE id=? AND user_id = ? AND time > ?");
        $stmt->bind_param('iii',$id,$user_id,$time);
    }

    $stmt->execute();
    $stmt->close();

}