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
include_once "struct_training.php";

function db_training_getAll() :?array
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from training");

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $bs = new  struct_training();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->description = $dsatz['description'];
        $bs->day = $dsatz['day'];
        $bs->start_hour = $dsatz['start_hour'];
        $bs->start_minute = $dsatz['start_minute'];
        $bs->end_hour = $dsatz['end_hour'];
        $bs->end_minute = $dsatz['end_minute'];
        $bs->color = $dsatz['color'];
        $bs->location = $dsatz['location'];
        $bs->group = $dsatz['training_group'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats ?? null;


}

/**
 * @param $id
 * @return mixed|struct_training
 */
function db_training_getWhereID($id)
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from training WHERE id=?");
    $stmt->bind_param('i',$id);

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $training = new struct_training();
        $training->id = $dsatz['id'];
        $training->name = $dsatz['name'];
        $training->day = $dsatz['day'];
        $training->start_hour = $dsatz['start_hour'];
        $training->start_minute = $dsatz['start_minute'];
        $training->end_hour = $dsatz['end_hour'];
        $training->end_minute = $dsatz['end_minute'];
        $training->color = $dsatz['color'];
        $training->location = $dsatz['location'];
        $training->group = $dsatz['group'];

        $list_training[] = $training;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $list_training[0];

}

function db_training_edit(struct_training $data)
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE training SET name=?, description=?, day=?, start_hour=?, start_minute=?, end_hour=?,
                    end_minute=?, color=?, location=?, training_group=? WHERE id=?");
    $stmt->bind_param('ssiiiiisiii',$data->name,
        $data->description,
        $data->day,
        $data->start_hour,
        $data->start_minute,
        $data->end_hour,
        $data->end_minute,
        $data->color,
        $data->location,
        $data->group,
        $data->id);

    $stmt->execute();


    /* Verbindung schließen */
    $mysqli->close();

}

function db_training_new($data)
{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO training (name, description, day, start_hour, start_minute, end_hour, end_minute, color, location, training_group) 
                VALUES(?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssiiiiisii',$data->name,
        $data->description,
        $data->day,
        $data->start_hour,
        $data->start_minute,
        $data->end_hour,
        $data->end_minute,
        $data->color,
        $data->location,
        $data->group);

    $stmt->execute();


    /* Verbindung schließen */
    $mysqli->close();

}


function db_training_delete($data){


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM training WHERE id=?");
    $stmt->bind_param('i',$data->id);

    $stmt->execute();
    $stmt->close();

}


//Gibt die Anzahl der Datensätze zurück die die Location nutzen
function db_training_isUsingLocation($location) : int{


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from training WHERE location=?");
    $stmt->bind_param('i',$location);

    $stmt->execute();
    $result = $stmt->get_result();

    $count = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $ignored){

        $count++;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $count;

}

//Gibt die Anzahl der Datensätze zurück die die Location nutzen
function db_training_isUsingGroup($group) : int{


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from training WHERE training_group=?");
    $stmt->bind_param('i',$group);

    $stmt->execute();
    $result = $stmt->get_result();

    $count = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $ignored){

        $count++;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $count;

}

function db_training_checkStruct($data){

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

    if(!isset($data->end_minute)){
        return false;
    }

    if(!isset($data->end_hour)){
        return false;
    }

    if(!isset($data->start_minute)){
        return false;
    }

    if(!isset($data->start_hour)){
        return false;
    }

    if(!isset($data->day)){
        return false;
    }

    if(!isset($data->location)){
        return false;
    }

    return true;

}