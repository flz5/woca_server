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
include_once 'struct_boat_parameter.php';
include_once 'db_boat_tags.php';
include_once 'db_boat_type.php';
include_once 'struct_boat.php';

function db_boat_buildQuery(struct_boat_parameter $pp){
    $query = "1=1";

    if($pp->house != 0){
        $query .= " AND house = ".$pp->house."";
    }
    if($pp->type != 0){
        $query .= " AND type = ".$pp->type."";
    }
    if($pp->seats_min != 0){
        $query .= " AND seats >= ".$pp->seats_min."";
    }
    if($pp->seats_max != 0){
        $query .= " AND seats <= ".$pp->seats_max."";
    }
    if($pp->weight != 0){
        $query .= " AND weight >= ".$pp->weight."";
    }
    if($pp->tag != 0){
        $query .= " AND (tag1=".$pp->tag." OR tag2=".$pp->tag." OR tag3=".$pp->tag." OR tag4=".$pp->tag.") ";
    }
    return $query;
}

function db_boat_get($parameter){
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $search = db_boat_buildQuery($parameter);
    $stmt = $mysqli->prepare("select * from boat WHERE " . $search);

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){
        $as_boat = new appstruct_boat();
        $as_boat->name = $dsatz['name'];
        $as_boat->seats = $dsatz['seats'];

        $ff = db_boat_getTypeWhereID($dsatz['type']);
        $as_boat->type = $ff->name;
        $as_boat->place = $dsatz['place'];
        $as_boat->weight = $dsatz['weight'];

        $tt1 = db_boat_getTagWhereID($dsatz['tag1']);
        $as_boat->tag1 = $tt1->name_short;
        $as_boat->tag1color = "#".$tt1->color;

        $tt2 = db_boat_getTagWhereID($dsatz['tag2']);
        $as_boat->tag2 = $tt2->name_short;
        $as_boat->tag2color = "#".$tt2->color;

        $tt3 = db_boat_getTagWhereID($dsatz['tag3']);
        $as_boat->tag3 = $tt3->name_short;
        $as_boat->tag3color = "#".$tt3->color;

        $tt4 = db_boat_getTagWhereID($dsatz['tag4']);
        $as_boat->tag4 = $tt4->name_short;
        $as_boat->tag4color = "#".$tt4->color;

        $boats[] = $as_boat;
    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats;
}

function db_boat_getAll(){
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from boat");

    $stmt->execute();
    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){
        $bs = new appstruct_boat();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->seats = $dsatz['seats'];
        $bs->type = $dsatz['type'];
        $bs->place = $dsatz['place'];
        $bs->weight = $dsatz['weight'];

        //TODO: Tags korrekt behandeln

        $tt1 = ($dsatz['tag1']);
        //$bs->tag1 = $tt1->name_short;
        //$bs->tag1color = $tt1->color;

        $tt2 = ($dsatz['tag2']);
        //$bs->tag2 = $tt2->name_short;
        //$bs->tag2color = $tt2->color;

        $tt3 = ($dsatz['tag3']);
        //$bs->tag3 = $tt3->name_short;
        //$bs->tag3color = $tt3->color;

        $tt4 = ($dsatz['tag4']);
        //$bs->tag4 = $tt4->name_short;
        //$bs->tag4color = $tt4->color;

        $boats[] = $bs;
    }

    /* Verbindung schließen */
    $mysqli->close();

    return $boats;
}

function db_boat_getAllRaw() : ?array{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("SELECT * FROM boat");
    $stmt->execute();

    $result = $stmt->get_result();

    foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){


        $bs = new struct_boat();
        $bs->id = $dsatz['id'];
        $bs->name = $dsatz['name'];
        $bs->seats = $dsatz['seats'];
        $bs->type = $dsatz['type'];
        $bs->place = $dsatz['place'];
        $bs->weight = $dsatz['weight'];
        $bs->house = $dsatz['house'];

        $bs->tag1 = ($dsatz['tag1']);
        $bs->tag2 = ($dsatz['tag2']);
        $bs->tag3 = ($dsatz['tag3']);
        $bs->tag4 = ($dsatz['tag4']);

        $boats[] = $bs;
    }

    /* Verbindung schließen */
    $stmt->close();

    if(isset($boats)){
        return $boats;
    }else{
        return null;
    }
}

function db_boat_edit($id,$data) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE boat SET house=?, seats=?, type=?, place=?,".
        "tag1=?, tag2=?, tag3=?, tag4=?, weight=?, name=? WHERE id=?");
    $stmt->bind_param('iiisiiiiisi',
        $data->house,
        $data->seats,
        $data->type,
        $data->place,
        $data->tag1,
        $data->tag2,
        $data->tag3,
        $data->tag4,
        $data->weight,
        $data->name,
        $data->id);
    $stmt->execute();
    $stmt->close();

}

function db_boat_new($data) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO boat (house,seats,type,place,tag1,tag2,tag3,tag4,weight,name)".
                                    "VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('iiiiiiiiis',
        $data->house,
        $data->seats,
        $data->type,
        $data->place,
        $data->tag1,
        $data->tag2,
        $data->tag3,
        $data->tag4,
        $data->weight,
        $data->name);
    $stmt->execute();
    $stmt->close();
}

function db_boat_deleteBoat($data) :void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM boat WHERE id=?");
    $stmt->bind_param('i', $data->id);
    $stmt->execute();
    $stmt->close();
}

function db_boat_isUsedTag($tag) : bool{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * FROM boat WHERE tag1=? OR tag2=? OR tag3=? OR tag4=?");
    $stmt->bind_param('iiii', $tag,$tag,$tag,$tag);
    $stmt->execute();
    $result = $stmt->get_result();

    $cc = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $t){
        $cc++;
    }

    /* Verbindung schließen */
    $mysqli->close();


    if($cc > 0){
        return true;
    }else{
        return false;
    }

}

function db_boat_isUsedType($type) : bool{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * FROM boat WHERE type=?");
    $stmt->bind_param('i', $type);
    $stmt->execute();
    $result = $stmt->get_result();

    $cc = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $t){
        $cc++;
    }
    /* Verbindung schließen */
    $mysqli->close();

    if($cc > 0){
        return true;
    }else{
        return false;
    }
}

function db_boat_isUsedHouse($house) : bool{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * FROM boat WHERE house=?");
    $stmt->bind_param('i', $house);
    $stmt->execute();
    $result = $stmt->get_result();

    $cc = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $t){
       $cc++;
    }

    /* Verbindung schließen */
    $mysqli->close();

    if($cc > 0){
        return true;
    }else{
        return false;
    }

}

?>