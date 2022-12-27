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
include_once "struct_account.php";
include_once "enum_account_state.php";
include_once "hashPassword.php";

function db_account_getData($filter, $id) : array{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    if($filter == true){
        $stmt = $mysqli->prepare("select * from account WHERE id=?");
        $stmt->bind_param('i',  $id);
        $stmt->execute();
    }else{

        $stmt = $mysqli->prepare("select * from account");
        $stmt->execute();
    }

    $result = $stmt->get_result();
    foreach($result->fetch_all(MYSQLI_ASSOC) as $col){
        $account = new  struct_account();
        $account->id = $col['id'];
        $account->login_username = $col['login_username'];
        $account->login_password = $col['login_password'];
        $account->email = $col['email'];
        $account->state = $col['login_state'];
        $account->login_time = $col['login_time'];
        $account->login_tries = $col['login_tries'];
        $account->user_group = $col['user_group'];
        $account->user_name = $col['user_name'];
        $account->createdBy = $col['createdBy'];

        $account_array[] = $account;
    }

    //TODO: Fehlerbehandlung wenn keine Daten gefunden wurden
    return $account_array;
}

function db_account_setState($id,$state) : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE account SET state=? WHERE id=?");
    $stmt->bind_param('ii',  $id, $state);
    $stmt->execute();
    $stmt->close();

    return true;
}

function db_account_setLoginTime($id,$time) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE account SET login_time=? WHERE id=?");
    $stmt->bind_param('ii', $time, $id);
    $stmt->execute();
    $stmt->close();

}

function db_account_setLoginTries($id,$tries) : void{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE account SET login_tries=? WHERE id=?");
    $stmt->bind_param('ii',  $tries , $id);
    $stmt->execute();

    /* Verbindung schließen */
    $mysqli->close();
}

function db_account_checkLogin($username,$password) :int {
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select login_password,id,login_tries,login_state,login_time from account WHERE login_username=?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    /* Datensätze aus Ergebnis ermitteln, */
    /* in Array speichern und ausgeben    */

    $pw = "";
    $id = "";
    $tries = 0;
    $time = 0;
    $state = 0;

    foreach($result->fetch_all(MYSQLI_ASSOC) as $data_row){
        $pw = $data_row['login_password'];
        $id = $data_row['id'];
        $tries = $data_row['login_tries'];
        $time = $data_row['login_time'];
        $state = $data_row['login_state'];
    }

    /* Verbindung schließen */
    $mysqli->close();
    $dist = 10000; //Wartezeit

    if($time + $dist < time()){
        //Wartezeit ist um Zähler zurücksetzen
        db_account_setLoginTries($id,0);
    }

    if(($tries < 5) ){
        if ((db_password_hashPasswordCompare($password,$pw) == true) and $state == AccountState::Active->value) {
            db_account_setLoginTries($id,0);
            return $id;
        }else{
            db_account_setLoginTime($id,time());
            db_account_setLoginTries($id,$tries + 1);
            return -1;
        }
    }else{
        db_account_setLoginTime($id,time());
        db_account_setLoginTries($id,$tries + 1);
        return -2;
    }
}

function db_account_changePasswort($id, $password_new) : bool{
    //Das übergebene Passwort durch einen Hash ersetzen damit es nicht in der Datenbank ausgelesen werden kann
    $hashedPassword = db_password_hashPassword($password_new);

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE account SET login_password=? WHERE id=?");
    $stmt->bind_param('si',  $hashedPassword , $id);
    $stmt->execute();
    $stmt->close();

    return true;
}

function db_account_createDataSet(struct_account $data) : bool{
    //Das übergebene Passwort durch einen Hash ersetzen damit es nicht in der Datenbank ausgelesen werden kann
    $hashedPassword = db_password_hashPassword($data->login_password);

    if(db_account_existsUsername($data->login_username)){
        return false;
    }

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("INSERT INTO account (login_username,login_password,email,login_state,login_time,login_tries,user_group,user_name,createdBy) 
                VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssiiissi',
        $data->login_username,
        $hashedPassword,
        $data->email,
        $data->state,
        $data->login_time,
        $data->login_tries,
        $data->user_group,
        $data->user_name,
        $data->createdBy);

    $stmt->execute();
    $stmt->close();

    return true;
}

function db_account_updateDataSet($id, struct_account $data){
    //Das passwort wird hier nicht geändert
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("UPDATE account SET login_username=?,email=?,login_state=?,login_time=?,".
        "login_tries=?,user_group=?,user_name=?,createdBy=? WHERE id=?");
    $stmt->bind_param('ssiiissii',
        $data->login_username,
        $data->email,
        $data->state,
        $data->login_time,
        $data->login_tries,
        $data->user_group,
        $data->user_name,
        $data->createdBy,
        $id);

    $stmt->execute();
    $stmt->close();
}

function db_account_deleteDataSet($id){
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("DELETE FROM account WHERE id=?");
    $stmt->bind_param('ssiiissii',$id);

    $stmt->execute();
    $stmt->close();
}

//Prüft ob der benuzuername schon vergeben ist
function db_account_existsUsername($username) : bool{
    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select id from account WHERE login_username=?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $count = 0;
    foreach($result->fetch_all(MYSQLI_ASSOC) as $col){
        $count++;
    }

    /* Verbindung schließen */
    $mysqli->close();
    if($count == 0){
        return false;
    }else{
        return true;
    }
}

function db_account_isUsingGroup(string $group) : bool{

    global $mysql_server;
    global $mysql_user;
    global $mysql_password;
    global $mysql_database;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);

    $stmt = $mysqli->prepare("select * FROM account WHERE user_group=?");
    $stmt->bind_param('s', $group);
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