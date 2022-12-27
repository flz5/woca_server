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

require_once 'struct_track_startpoint.php';

class track_startpoint{

    public function new($data){
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("INSERT INTO track_startpoint (name,version) 
                VALUES (?,?)");
        $stmt->bind_param('si',$data->name,
            $data->version);

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

        $stmt = $mysqli->prepare("UPDATE track_startpoint SET name=?,version=? WHERE id=?");
        $stmt->bind_param('sii',$data->name,
            $data->version,
            $data->id);

        $stmt->execute();
        $stmt->close();

    }

    /**
     * @return struct_track_startpoint[]
     */

    public function getAll() : ?array{
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("select * from track_startpoint");
        //$stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

            $rr = new struct_track_startpoint();
            $rr->id = $dsatz['id'];
            $rr->name = $dsatz['name'];
            $rr->version = $dsatz['version'];
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

        $stmt = $mysqli->prepare("select * from track_startpoint WHERE id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        foreach($result->fetch_all(MYSQLI_ASSOC) as $dsatz){

            $rr = new struct_track_startpoint();
            $rr->id = $dsatz['id'];
            $rr->name = $dsatz['name'];
            $rr->version = $dsatz['version'];
        }

        /* Verbindung schließen */
        $mysqli->close();
        return $rr;

    }

    public function delete($id){
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("DELETE FROM track_startpoint WHERE id = ?");
        $stmt->bind_param('i',$id);

        $stmt->execute();
        $stmt->close();

        return true;

    }

    public function increaseVersion($id){
        global $mysql_server;
        global $mysql_user;
        global $mysql_password;
        global $mysql_database;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

        $stmt = $mysqli->prepare("UPDATE track_startpoint SET version = version + 1 WHERE id = ?");
        $stmt->bind_param('i',$id);

        $stmt->execute();
        $stmt->close();

        return true;
    }

    /*
     * Versionsnummer muss bei jeder Änderung an der STrecke erhöht werden
     *
     */


}
