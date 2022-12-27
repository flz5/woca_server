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
include_once "contact_db.php";

function db_contact_getAll() : ?array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;
    global $contact_img_server;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from contact");
    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

        $bs = new  _contactAppstruct();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->img = $contact_img_server . $dsatz['img'];
        $bs->mail = $dsatz['email'];
        $bs->mobile = $dsatz['mobile'];
        $bs->telephone = $dsatz['telephone'];
        $bs->title = $dsatz['title'];
        $bs->version = $dsatz['version'];

        $boats[] = $bs;

    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats ?? null;
}

function contact_edit(_contactAppstruct $data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE contact SET title=?, name=?, telephone=?, mobile=?, email=?, img=?, version=? WHERE id=?");
    $stmt->bind_param('ssssssii',
        $data->title,
        $data->name,
        $data->telephone,
        $data->mobile,
        $data->mail,
        $data->img,
        $data->version,
        $data->id);

    $stmt->execute();
    $stmt->close();
}

function contact_new($data){

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO contact (title,name,telephone,mobile,email,img,version) VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssssi',$data->title,$data->name,$data->telephone,$data->mobile,$data->mail,$data->img,$data->version);

    $stmt->execute();
    $stmt->close();

}

function db_contact_delete($data) :void{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM contact WHERE id=?");
    $stmt->bind_param('i', $data->id);
    $stmt->execute();
    $stmt->close();

}

?>