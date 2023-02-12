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
include_once dirname(__FILE__) . "/struct_event_raw.php";
include_once dirname(__FILE__) . "/struct_event_joined.php";
include_once dirname(__FILE__) . "/db_event_slots.php";

function db_event_edit(struct_event_raw $data) :void
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

function db_event_new($data) : void {
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

function db_event_delete($id) :void {

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM event WHERE id=?");
    $stmt->bind_param('i',$id);

    $stmt->execute();
    $stmt->close();
}

//Returns the number of records using the location
function db_event_is_using_location($location) : int {
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

    foreach($result->fetch_all(MYSQLI_ASSOC) as $ignored){
        $count++;
    }
    /* Verbindung schließen */
    $mysqli->close();
    return $count;
}

//Returns the number of records using the group
function db_event_is_using_group($group) : int{
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

    foreach($result->fetch_all(MYSQLI_ASSOC) as $ignored){
        $count++;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $count;
}

function db_event_check_struct($data) : bool{

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

//filer_reg: Show only events for which the user is registered 0 = no, 1 = filter active
//user: ID of the user, 0 = not used
function db_event_get_list_joined($user, $filter_reg) : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);


    if($filter_reg == 0){
        $stmt = $mysqli->prepare("select ev.id, ev.name, ev.description, ev.time_start,
        ev.time_end, ev.color, ev.location,ev.event_group,ev.slots,eg.id as egid,
        eg.name as egname, eg.description as egdescription, eg.color as egcolor, l.id as lid,
        l.type, l.name as lname, l.description as ldescription,
        l.address_street, l.address_city, l.address_postal_code, l.address_country, l.geo_lat,
        l.geo_long  from event as ev 
        left join event_slot se on ev.id = se.event_id and se.user_id=? 
        left join location l on ev.location = l.id 
        left join event_group eg on ev.event_group = eg.id");
        $stmt->bind_param('i',$user);
    }else{
        $stmt = $mysqli->prepare("select ev.id, ev.name, ev.description, ev.time_start,
        ev.time_end, ev.color, ev.location,ev.event_group,ev.slots,eg.id as egid,
        eg.name as egname, eg.description as egdescription, eg.color as egcolor, l.id as lid, 
        l.type, l.name as lname, l.description as ldescription,
        l.address_street, l.address_city, l.address_postal_code, l.address_country, l.geo_lat,
        l.geo_long  from event as ev 
        left join event_slot se on ev.id = se.event_id and se.user_id=? 
        left join location l on ev.location = l.id 
        left join event_group eg on ev.event_group = eg.id
        WHERE se.user_id = ?");
        $stmt->bind_param('ii',$user,$user);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $row){
        $data = new struct_event_joined();
        $data->id = $row['id'];
        $data->title = $row['name'];
        $data->description = $row['description'];
        $data->time_start = $row['time_start'];
        $data->time_end = $row['time_end'];
        $data->color = $row['color'];

        //Trainingsgruppe
        $data->group_id = $row['egid'];
        $data->group_name = $row['egname'];

        //Ort
        $data->geo_lat = $row['geo_lat'];
        $data->geo_long = $row['geo_long'];

        if($row['type'] == 0){
            $data->has_location = "false";
            $data->address = $row['address_street'];
        }else if($row['type'] == 1 or $row['type'] == 3){
            $data->has_location = "true";
            $data->address = $row['address_street'] . "," . $row['address_postal_code']. " ". $row['address_city'] .
                "," . $row['address_country'];
        }
        else if($row['type'] == 2){
            $data->has_location = "true";
            $data->address = "";
        }

        if($data->time_start != 0){
            $data->has_date = "false";
        }else{
            $data->has_date = "true";
        }

        $data->location_id = $row['lid'];
        $data->location_name = $row['lname'];

        $data->slots_total = $row['slots'];
        $data->slots_free = $data->slots_total - db_event_slots_get_count($row['id']);
        if(isset($row['se.id'])){
            $data->registered = $row['se.id'];
        }else{
            $data->registered = 0;
        }

        $list[] = $data;
    }

    /* Verbindung schließen */
    $mysqli->close();

    return $list;

}

function db_event_get_item_joined($event) {

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select ev.id, ev.name, ev.description, ev.time_start,
        ev.time_end, ev.color, ev.location,ev.event_group,ev.slots,eg.id as egid,
        eg.name as egname, eg.description as egdescription, eg.color as egcolor, 
        l.id as lid, l.type, l.name as lname, l.description as ldescription,
        l.address_street, l.address_city, l.address_postal_code, l.address_country,
        l.geo_lat, l.geo_long  from event as ev 
        left join location l on ev.location = l.id 
        left join event_group eg on ev.event_group = eg.id
        WHERE ev.id = ?");
    $stmt->bind_param('i',$event);

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $row){

        $data = new  struct_event_joined();
        $data->id = $row['id'];
        $data->title = $row['name'];
        $data->description = $row['description'];
        $data->time_start = $row['time_start'];
        $data->time_end = $row['time_end'];
        $data->color = $row['color'];

        //Trainingsgruppe
        $data->group_id = $row['egid'];
        $data->group_name = $row['egname'];

        //Ort
        $data->geo_lat = $row['geo_lat'];
        $data->geo_long = $row['geo_long'];
        $data->place = $row['lname'];

        if($row['type'] == 0){
            $data->has_location = "false";
            $data->address = $row['address_street'];
        }else if($row['type'] == 1 or $row['type'] == 3){
            $data->has_location = "true";
            $data->address = $row['address_street'] . "," . $row['address_postal_code']. " ". $row['address_city'] .
                "," . $row['address_country'];
        }
        else if($row['type'] == 2){
            $data->has_location = "true";
            $data->address = "";
        }

        if($data->time_start != 0){
            $data->has_date = "false";
        }else{
            $data->has_date = "true";
        }

        $data->slots_total = $row['slots'];
        $data->slots_free = $data->slots_total - db_event_slots_get_count($row['id']);
        $data->registered = 0;

        $list[] = $data;
    }

    /* Verbindung schließen */
    $mysqli->close();

    return $list[0];

}