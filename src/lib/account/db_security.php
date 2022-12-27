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
include_once "struct_account_ip.php";

function db_security_IPisOk($ip) : bool{
    global $security_ip_limit;
    global $security_ip_waiting;

    $rr = db_security_getIP($ip);

    if(!isset($rr)){
        //Es existiert kein Datensatz, daher noch kein fehlerhafter Login für diese IP gespeichert und OK
        return true;
    }

    if($rr->time + $security_ip_waiting < time()){
        db_security_resetIPCounter($ip);
    }

    if($rr->count > $security_ip_limit){
        return false;
    }
    return true;
}

function db_security_getIP($ip) : ?struct_account_ip{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * from account_ip WHERE ip=?");
    $stmt->bind_param('s', $ip);
    $stmt->execute();
    $result = $stmt->get_result();

    /* Datensätze aus Ergebnis ermitteln, */
    /* in Array speichern und ausgeben    */

    $st = null;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $t){
        $st = new struct_account_ip();
        $st->ip = $t['ip'];
        $st->time = $t['time'];
        $st->count = $t['count'];
    }

    return $st;
}

//Fügt die IP Addresse hinzu
//Bei bestehendem Datensatz wird der Zähler erhöht und die Zeit mit der aktuellen überschrieben
function db_security_addIp($ip): bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    $timestamp = time();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO account_ip (ip,count,time) 
                VALUES (?,1,?) ON DUPLICATE KEY UPDATE count = count + 1, time = ?");
    $stmt->bind_param('sii',
        $ip,
        $timestamp,
        $timestamp);

    $stmt->execute();
    $stmt->close();

    return true;

    //Daten: IP, Counter, Zeitstempel
    return true;
}

//setzt den Zähler für die IP Addresse zurück
function db_security_resetIPCounter($ip) : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    $timestamp = time();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE account_ip SET count = 0 WHERE ip = ?");
    $stmt->bind_param('s', $ip);

    $stmt->execute();
    $stmt->close();

    return true;
}

//Räumt die Datenbank auf (Cron Job...)
function db_security_clean() : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    global $security_ip_waiting;


    $timestamp = time() - $security_ip_waiting;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM account_ip WHERE time < ?");
    $stmt->bind_param('i', $timestamp);

    $stmt->execute();
    $stmt->close();

    return true;
}

?>