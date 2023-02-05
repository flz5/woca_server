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
include_once 'struct_boat_type.php';

function db_boat_getTypeWhereID($n) :struct_boat_type {
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from boat_type WHERE id=?");
    $stmt->bind_param('i',$n);
    $stmt->execute();
    $result = $stmt->get_result();

    $obj = new struct_boat_type();
    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $obj->name = $dsatz['name'];
        $obj->id = $dsatz['id'];
        $tt[] = $obj;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $obj;
}

function db_boat_getTypeAll() : ?array{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from boat_type");
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){
        $obj = new appstruct_boat_selection();
        $obj->name = $dsatz['name'];
        $obj->id = $dsatz['id'];
        $tt[] = $obj;
    }

    /* Verbindung schließen */
    $mysqli->close();

    return $tt ?? null;

}

function db_boat_editType($id,$data) : void{
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

    $stmt = $mysqli->prepare("UPDATE boat_type SET name=? WHERE id=?");
    $stmt->bind_param('si',$data->name, $data->id);

    $stmt->execute();
    $stmt->close();
}

function db_boat_newType($data) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO boat_type (name) VALUES (?)");
    $stmt->bind_param('s',$data->name);

    $stmt->execute();
    $stmt->close();
}

function db_boat_deleteType($data) :void{
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

    $stmt = $mysqli->prepare("DELETE FROM boat_type WHERE id=?");
    $stmt->bind_param('i',$data->id);

    $stmt->execute();
    $stmt->close();
}

?>