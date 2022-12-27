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
include_once 'appstruct_boat_selection.php';

function db_boat_getHousesAll() : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from boat_house");

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){
        $as_selection = new appstruct_boat_selection();
        $as_selection->id = $dsatz['id'];
        $as_selection->name = $dsatz['name'];

        $as_selection_array[] = $as_selection;
    }
    /* Verbindung schließen */
    $mysqli->close();

    return $as_selection_array ?? null;
}

function db_boat_getHouseWhereID($n) : ?array{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from boat_house WHERE id=?");
    $stmt->bind_param('i',$n);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){
        $as_selection = new appstruct_boat_selection();
        $as_selection->id = $dsatz['id'];
        $as_selection->name = $dsatz['name'];

        $as_selection_array[] = $as_selection;
    }

    /* Verbindung schließen */
    $mysqli->close();

    return $as_selection_array;
}

function db_boat_editHouse($id,$data) : void{

    //Eintrag 0 darf nicht bearbeitet werden
    if($id == 0){
        return;
    }

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE boat_house SET name=? WHERE id=?");
    $stmt->bind_param('si',
        $data->name,
        $data->id);

    $stmt->execute();
    $stmt->close();

}

function db_boat_newHouse($data) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO boat_house (name) VALUES (?)");
    $stmt->bind_param('s',$data->name);

    $stmt->execute();
    $stmt->close();
}

function db_boat_deleteHouse($data) : void{
    //Eintrag 0 darf nicht bearbeitet werden
    if($data->id == 0){
        return;
    }

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM boat_house WHERE id=?");
    $stmt->bind_param('i',$data->id);

    $stmt->execute();
    $stmt->close();
}