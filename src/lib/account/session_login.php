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

include_once "db_account.php";
include_once "db_security.php";
include_once "enum_login_state.php";

include_once dirname(__FILE__) . "/../permissions/permission.php";

function ss_account_login($username,$password) : LoginState{

    if(!db_security_IPisOk($_SERVER['REMOTE_ADDR'])){
        db_security_addIp($_SERVER['REMOTE_ADDR']);
        return LoginState::IPBlock;
    }

    $id = db_account_checkLogin($username,$password);

    if($id >= 0){
        $_SESSION['user_id'] = $id;
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['login_username'] = $username;
        return LoginState::OK;
    }else{
        $_SESSION['isLoggedIn'] = false;
        db_security_addIp($_SERVER['REMOTE_ADDR']);

        if($id == -1){
            return LoginState::WrongCredentials;
        }
        if($id == -2){
            return LoginState::TooManyAttempts;
        }
        return LoginState::Error;
    }
}

function ss_account_logout() : void{
    session_destroy();
}

function ss_account_getID() : int{
    return $_SESSION['user_id'];
}

function ss_account_getLoginUsername(): string{
    return $_SESSION['login_username'];
}

function ss_account_isLoggedIn() : bool{
    if($_SESSION['isLoggedIn'] == true){
        return true;
    }else{
        return false;
    }
}

function ss_account_requestPermission($permission, $level) : bool{
    $data = db_account_getData(true,$_SESSION['user_id']);
    $group = $data[0]->user_group;
    if(permission_isSet($group,$permission,$level)){
        return true;
    }else{
        return false;
    }
}

function ss_account_verifySession() : bool{
    return true;
}

?>
