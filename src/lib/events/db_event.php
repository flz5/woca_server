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
include_once "struct_event.php";

function db_event_getAll()
{

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

        $bs = new  struct_event();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->description = $dsatz['description'];
        $bs->day = $dsatz['day'];
        $bs->time_start = $dsatz['time_start'];
        $bs->time_end = $dsatz['time_end'];
        $bs->slots = $dsatz['slots'];
        $bs->color = $dsatz['color'];
        $bs->location = $dsatz['location'];
        $bs->group = $dsatz['event_group'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats ?? null;
}

function db_event_getWhereID($id)
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from event WHERE id=?");
    $stmt->bind_param('i',$id);

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $bs = new  struct_training();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->day = $dsatz['day'];
        $bs->time_start = $dsatz['time_start'];
        $bs->time_end = $dsatz['time_end'];
        $bs->color = $dsatz['color'];
        $bs->location = $dsatz['location'];
        $bs->group = $dsatz['event_group'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats[0];

}

function db_event_edit(struct_event $data)
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE event SET name=?, description=?, slots=?, time_start=?, time_end=?,
                    color=?, location=?, event_group=? WHERE id=?");
    $stmt->bind_param('ssiiisiii',$data->name,
        $data->description,
        $data->slots,
        $data->time_start,
        $data->time_end,
        $data->color,
        $data->location,
        $data->group,
        $data->id);

    $stmt->execute();


    /* Verbindung schließen */
    $mysqli->close();

}

function db_event_new($data)
{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO event (name, description, time_start, time_end, slots, color, location, event_group) 
                VALUES(?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssiiisii',$data->name,
        $data->description,
        $data->time_start,
        $data->time_end,
        $data->slots,
        $data->color,
        $data->location,
        $data->group);

    $stmt->execute();

    /* Verbindung schließen */
    $mysqli->close();
}

function db_event_delete($data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM event WHERE id=?");
    $stmt->bind_param('i',$data->id);

    $stmt->execute();
    $stmt->close();
}

//Gibt die Anzahl der Datensätze zurück die die Location nutzen
function db_event_isUsingLocation($location) : int{


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from event WHERE location=?");
    $stmt->bind_param('i',$location);

    $stmt->execute();
    $result = $stmt->get_result();

    $count = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $count++;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $count;

}

//Gibt die Anzahl der Datensätze zurück die die Location nutzen
function db_event_isUsingGroup($group) : int{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from event WHERE event_group=?");
    $stmt->bind_param('i',$group);

    $stmt->execute();
    $result = $stmt->get_result();

    $count = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){
        $count++;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $count;
}

function db_event_checkStruct($data) : bool{

    if(!isset($data->id)){
        return false;
    }
    if(!isset($data->name)){
        return false;
    }
    if(!isset($data->description)){
        return false;
    }
    if(!isset($data->group)){
        return false;
    }
    if(!isset($data->color)){
        return false;
    }

    if(!isset($data->time_start)){
        return false;
    }

    if(!isset($data->time_end)){
        return false;
    }

    if(!isset($data->slots)){
        return false;
    }

    if(!isset($data->location)){
        return false;
    }

    return true;

}