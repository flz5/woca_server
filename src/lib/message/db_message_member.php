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

require_once 'struct_message_member.php';
require_once dirname(__FILE__) . "/../config.php";

function db_message_getChannelMember($channel_id) : array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_member WHERE channel_id = ?");
    $stmt->bind_param('i',$channel_id);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_member();
        $rr->id = $dsatz['id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->user_id = $dsatz['user_id'];
        $rr->device_type = $dsatz['device_type'];
        $rr->device_id = $dsatz['device_id'];
        $results[] = $rr;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $rr;

}


function db_message_getChannelMemberByType($channel_id,$type) : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_member WHERE channel_id = ? and device_type = ?");
    $stmt->bind_param('ii',$channel_id,$type);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_member();
        $rr->id = $dsatz['id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->user_id = $dsatz['user_id'];
        $rr->device_type = $dsatz['device_type'];
        $rr->device_id = $dsatz['device_id'];
        $results[] = $rr;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}


function db_message_getChannelMemberByUser($user){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_member WHERE user_id = ?");
    $stmt->bind_param('i',$user);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_member();
        $rr->id = $dsatz['id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->user_id = $dsatz['user_id'];
        $rr->device_type = $dsatz['device_type'];
        $rr->device_id = $dsatz['device_id'];
        $rr->last_time = $dsatz['last_time'];
        $results[] = $rr;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $results;

}

function db_message_getChannelMemberByUserAndChannel($user,$channel){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message_member WHERE user_id = ? and channel_id = ?");
    $stmt->bind_param('ii',$user,$channel);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message_member();
        $rr->id = $dsatz['id'];
        $rr->channel_id = $dsatz['channel_id'];
        $rr->user_id = $dsatz['user_id'];
        $rr->device_type = $dsatz['device_type'];
        $rr->device_id = $dsatz['device_id'];
        $rr->last_time = $dsatz['last_time'];
        $results[] = $rr;
    }

    /* Verbindung schließen */
    $mysqli->close();
    return $rr;

}


function db_message_addChannelMember($userID, $channel, $type,$id) : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO message_member (channel_id,user_id,device_type,device_id,last_time) 
                VALUES (?,?,?,?,?)");

    $ttt = time();

    $stmt->bind_param('iiisi',$channel,
        $userID,
        $type,
        $id,
        $ttt
    );

    $stmt->execute();
    $stmt->close();


    return true;
}

function db_message_removeChannelMemberByID($id) : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM message_member WHERE id = ?");
    $stmt->bind_param('i',$id);

    $stmt->execute();
    $stmt->close();

    return true;
}


function db_message_removeChannelMemberByDevice($channel,$type,$id) : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM message_member WHERE device_type = ? and device_id=? and channel=?");
    $stmt->bind_param('isi',$type,$id,$channel);

    $stmt->execute();
    $stmt->close();

    return true;
}

function db_message_removeChannelMemberByUser($user) : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM message_member WHERE user_id=?");
    $stmt->bind_param('i',$user);

    $stmt->execute();
    $stmt->close();

    return true;
}


function db_message_updateMemberTime($type,$id){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE message_member SET last_time=? WHERE device_type=? and device_id = ?");

    $time = time();

    $stmt->bind_param('iis',$time,
        $type,
        $id);

    $stmt->execute();
    $stmt->close();


}
