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

require_once dirname(__FILE__) . "/../config.php";
require_once "struct_message_permission.php";

function db_message_getPermissionStruct($channel,$userID) : ?struct_message_permission{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_permission WHERE user_id = ? and channel_id = ?");
    $stmt->bind_param('ii',$userID,$channel);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_permission();
        $rr->id = $dsatz['id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->permission_join = $dsatz['perm_join'];
        $rr->permission_write = $dsatz['perm_write'];
        $results[] = $rr;


    }

    /* Verbindung schließen */
    $mysqli->close();
    return $rr;

}


function db_message_addPermission(struct_message_permission $data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO message_permission (channel_id,user_id,perm_write,perm_join) 
                VALUES (?,?,?,?)");
    $stmt->bind_param('iiii',$data->channel_id,
        $data->user_id,
        $data->permission_write,
        $data->permission_join);

    $stmt->execute();
    $stmt->close();

}

function db_message_editPermission(struct_message_permission $data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE message_permission SET channel_id=?,user_id=?,perm_write=?,"."
                    perm_join=? WHERE id=?");
    $stmt->bind_param('iiiii',$data->channel_id,
        $data->user_id,
        $data->permission_write,
        $data->permission_join,
        $data->id);

    $stmt->execute();
    $stmt->close();

}

function db_message_deletePermission($id){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM message_permission WHERE id=?");
    $stmt->bind_param('i',$id);

    $stmt->execute();
    $stmt->close();

}


//Liste alle Einträgte für den Kanal
function db_message_getListChannelPermission($channel) : ?array{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_permission WHERE channel_id = ?");
    $stmt->bind_param('i',$channel);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_permission();
        $rr->id = $dsatz['id'];
        $rr->user_id = $dsatz['user_id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->permission_join = $dsatz['perm_join'];
        $rr->permission_write = $dsatz['perm_write'];
        $results[] = $rr;


    }


    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}


//Liste aller Kanäle für die der Benutzer Beitrittrsrechte besietzt
function db_message_getListChannelPermissionJoin($user_id) : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_permission WHERE user_id = ? and perm_join = true");
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_permission();
        $rr->id = $dsatz['id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->permission_join = $dsatz['permission_join'];
        $rr->permission_write = $dsatz['permission_write'];
        $results[] = $rr;


    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;


    //WHERE
}

//Liste aller Kanäle für die der Benutzer schreibrechte besitzt
function db_message_getListChannelPermissionWrite($user_id) : ?array{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_permission LEFT JOIN message_channel ON message_permission.channel_id = message_channel.id WHERE user_id = ? and perm_write = true ");
    $stmt->bind_param('i',$user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_joinInformation();
        $rr->id = $dsatz['id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->name = $dsatz['name'];

        if(isset($dsatz['perm_write']) and $dsatz['perm_write'] == 1){
            $rr->permission_write = true;
        }else{
            $rr->permission_write = false;
        }

        if(isset($dsatz['perm_join']) and $dsatz['perm_join'] == 1){
            $rr->permission_join = true;
        }else{
            $rr->permission_join = false;
        }
        $results[] = $rr;


    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}

