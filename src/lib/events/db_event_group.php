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
include_once "struct_event_group.php";

function db_event_group_getAll() : ?array
{


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from event_group");

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $bs = new struct_event_group();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->description = $dsatz['description'];
        $bs->color = $dsatz['color'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats ?? null;

}

function db_event_getGroupWhereID($id) : ?struct_training_group
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from event_group WHERE id=?");
    $stmt->bind_param('i',$id);

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $bs = new  struct_event_group();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->description = $dsatz['description'];
        $bs->day = $dsatz['color'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats[0];

}

function db_event_editGroup($data) : bool
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE event_group SET name=?,description=?,color=? WHERE id=?");
    $stmt->bind_param('sssi',

        $data->name,
        $data->description,
        $data->color,
        $data->id);

    $stmt->execute();

    /* Verbindung schließen */
    $mysqli->close();

    return true;
}

function db_event_newGroup(struct_training_group $data) : bool
{


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO event_group (name,description,color) VALUES(?,?,?)");
    $stmt->bind_param('sss',
        $data->name,
        $data->description,
        $data->color);

    $stmt->execute();

    /* Verbindung schließen */
    $mysqli->close();

    return true;

}

function db_event_deleteGroup($data){


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM event_group WHERE id=?");
    $stmt->bind_param('i',$data->id);

    $stmt->execute();
    $stmt->close();

}

function db_event_checkGroupStruct($data){

    if(!isset($data->id)){
        return false;
    }
    if(!isset($data->name)){
        return false;
    }
    if(!isset($data->description)){
        return false;
    }
    if(!isset($data->color)){
        return false;
    }
    return true;

}

