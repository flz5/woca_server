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

require_once 'struct_message_channel.php';
require_once 'struct_message_joinInformation.php';
require_once dirname(__FILE__) . "/../config.php";

function db_message_getChannels() : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_channel");
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_channel();
        $rr->id = $dsatz['id'];
        $rr->description = $dsatz['description'];
        $rr->public = $dsatz['public'];
        $rr->name = $dsatz['name'];
        $rr->password = $dsatz['password'];

        $results[] = $rr;


    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}

function db_message_getChannelsWhereID($id) : ?struct_message_channel{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_channel WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_channel();
        $rr->id = $dsatz['id'];
        $rr->description = $dsatz['description'];
        $rr->public = $dsatz['public'];
        $rr->name = $dsatz['name'];
        $rr->password = $dsatz['password'];

        $results[] = $rr;


    }

    /* Verbindung schließen */
    $mysqli->close();
    return $rr;

}


//Liefert JoinInformation zurück
function db_message_getChannelsForUser($id) : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select message_channel.id,name,description,public,password,perm_write,perm_join from message_channel ".
    "LEFT JOIN message_permission ON message_channel.id = message_permission.channel_id AND message_permission.user_id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_joinInformation();

        if(isset($dsatz['perm_join']) and $dsatz['perm_join'] == 1){
            $rr->permission_join = true;
        }else{
            $rr->permission_join = false;
        }

        $rr->public = $dsatz['public'];

        //Der Liste nur Einträge hinzuzfügen, denen der Benutzer auch beitreten kann
        if($rr->public or $rr->permission_join){
            $rr->id = $dsatz['id'];
            $rr->description = $dsatz['description'];
            $rr->name = $dsatz['name'];

            if($dsatz['password'] != ""){
                $rr->password_required = true;
            }else{
                $rr->password_required = false;
            }

            if(isset($dsatz['perm_write']) and $dsatz['perm_write'] == 1){
                $rr->permission_write = true;
            }else{
                $rr->permission_write = false;
            }

            $results[] = $rr;
        }
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}


function db_message_addChannel(struct_message_channel $data){
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO message_channel (name,description,public,password) 
                VALUES (?,?,?,?)");
    $stmt->bind_param('ssis',$data->name,
        $data->description,
        $data->public,
        $data->password);

    $stmt->execute();
    $stmt->close();


}

function db_message_deleteChannel(struct_message_channel $data){
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM message_channel WHERE id=?");
    $stmt->bind_param('i',$data->id);

    $stmt->execute();
    $stmt->close();

}

function db_message_editChannel(struct_message_channel $data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE message_channel SET name=?,description=?,public=?,".
        "password=? WHERE id=?");
    $stmt->bind_param('ssisi',$data->name,
        $data->description,
        $data->public,
        $data->password,
        $data->id);

    $stmt->execute();
    $stmt->close();

}