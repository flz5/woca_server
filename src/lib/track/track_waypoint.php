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

require_once 'struct_track_waypoint.php';

class track_waypoint{

    public function new($data){

        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("INSERT INTO track_waypoint (name,distance,startpoint) 
                VALUES (?,?,?)");
        $stmt->bind_param('sdi',$data->name,
            $data->distance,
            $data->startpoint);

        $stmt->execute();
        $stmt->close();
    }

    public function edit($data){

        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("UPDATE track_waypoint SET name=?,distance=?,startpoint=? WHERE id=?");
        $stmt->bind_param('sdii',$data->name,
            $data->distance,
            $data->startpoint,
            $data->id);

        $stmt->execute();
        $stmt->close();

        $sp = new track_startpoint();
        $sp->increaseVersion($data->startpoint);
    }

    public function delete($id){
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("DELETE FROM track_waypoint WHERE id = ?");
        $stmt->bind_param('i',$id);

        $stmt->execute();
        $stmt->close();


        return true;
    }

    public function getAllByStartpoint($id){
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("select * from track_waypoint WHERE startpoint = ?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

            $rr = new struct_track_waypoint();
            $rr->id = $dsatz['id'];
            $rr->name = $dsatz['name'];
            $rr->distance = $dsatz['distance'];
            $rr->startpoint = $dsatz['startpoint'];
            $res[] = $rr;
        }

        /* Verbindung schließen */
        $mysqli->close();
        return $res;
    }

    public function getByID($id){
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("select * from track_waypoint WHERE id = ?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

            $rr = new struct_track_waypoint();
            $rr->id = $dsatz['id'];
            $rr->name = $dsatz['name'];
            $rr->distance = $dsatz['distance'];
            $rr->startpoint = $dsatz['startpoint'];
            //$res[] = $rr;
        }

        /* Verbindung schließen */
        $mysqli->close();
        return $rr;

    }

    public function isUsingStartpoint($id){
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("select * FROM track_waypoint WHERE startpoint=?");
        $stmt->bind_param('i', $id);
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

}