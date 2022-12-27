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

function db_message_add(struct_message $data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO message (msg_text,msg_title,msg_author,msg_time,msg_receiver) 
                VALUES (?,?,?,?,?)");
    $stmt->bind_param('ssiii',$data->text,
        $data->title,
        $data->author,
        $data->time,
        $data->receiver);

    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();

    return $id;

}

function db_message_getWhereID($id){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from message WHERE id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $rr = new struct_message();
        $rr->id = $dsatz['id'];
        $rr->text = $dsatz['msg_text'];
        $rr->author = $dsatz['msg_author'];
        $rr->title = $dsatz['msg_title'];
        $rr->time = $dsatz['msg_time'];
        $rr->receiver = $dsatz['msg_receiver'];
        $results[] = $rr;


    }

    /* Verbindung schließen */
    $mysqli->close();
    return $rr;
}


function db_message_delete($id){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM message WHERE id=?");
    $stmt->bind_param('i',$id);

    $stmt->execute();
    $stmt->close();

    return true;


}