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
include_once "struct_location.php";

function db_location_getAll(){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from location");
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $bs = new  struct_location();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->type = $dsatz['type'];
        $bs->description = $dsatz['description'];
        $bs->address_street = $dsatz['address_street'];
        $bs->address_city = $dsatz['address_city'];
        $bs->address_postal_code = $dsatz['address_postal_code'];
        $bs->address_country = $dsatz['address_country'];
        $bs->geo_lat = $dsatz['geo_lat'];
        $bs->geo_long = $dsatz['geo_long'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();
    return $boats ?? null;

}

function db_location_getWhereID($id)
{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from location WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $bs = new  struct_location();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->type = $dsatz['type'];
        $bs->description = $dsatz['description'];
        $bs->address_street = $dsatz['address_street'];
        $bs->address_city = $dsatz['address_city'];
        $bs->address_postal_code = $dsatz['address_postal_code'];
        $bs->address_country = $dsatz['address_country'];
        $bs->geo_lat = $dsatz['geo_lat'];
        $bs->geo_long = $dsatz['geo_long'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats[0];

}

function db_location_edit($id,$data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE location SET type=?,name=?,description=?,address_street=?,"."
                    address_city=?,address_postal_code=?,address_country=?,geo_lat=?,geo_long=? WHERE id=?");
    $stmt->bind_param('issssssssi',$data->type,
        $data->name,
        $data->description,
        $data->address_street,
        $data->address_city,
        $data->address_postal_code,
        $data->address_country,
        $data->geo_lat,
        $data->geo_long,
        $data->id);

    $stmt->execute();
    $stmt->close();

}

function db_location_new($data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO location (type,name,description,address_street,address_city,address_postal_code,address_country,geo_lat,geo_long) 
                VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('issssssss',$data->type,
        $data->name,
        $data->description,
        $data->address_street,
        $data->address_city,
        $data->address_postal_code,
        $data->address_country,
        $data->geo_lat,
        $data->geo_long);

    $stmt->execute();
    $stmt->close();

}

function db_location_delete($data){


    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM location WHERE id=?");
    $stmt->bind_param('i',$data->id);

    $stmt->execute();
    $stmt->close();

}

function db_location_checkStruct ($data) : bool{

    if(!isset($data->id)){
        return false;
    }
    if(!isset($data->geo_long)){
        return false;
    }
    if(!isset($data->geo_lat)){
        return false;
    }
    if(!isset($data->description)){
        return false;
    }
    if(!isset($data->type)){
        return false;
    }
    if(!isset($data->address_country)){
        return false;
    }
    if(!isset($data->address_street)){
        return false;
    }
    if(!isset($data->address_postal_code)){
        return false;
    }
    if(!isset($data->address_city)){
        return false;
    }
    if(!isset($data->name)){
        return false;
    }

    return true;
}