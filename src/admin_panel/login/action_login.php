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

session_start();

include_once '../../lib/account/db_account.php';
include_once '../../lib/account/session_login.php';
include_once '../../lib/account/enum_login_state.php';


if(!isset($_POST['username']) or !isset($_POST['password'])){
    header('Location: form_login.php?option=f&cc=' . LoginState::Abort->value, true, 301);
    exit();
}

if($_POST['username'] == "" or $_POST['password'] == ""){
    header('Location: form_login.php?option=f&cc=' . LoginState::Abort->value, true, 301);
    exit();
}



$vv = ss_account_login($_POST['username'],$_POST['password']);

if($vv == LoginState::OK){

    //echo "OK";
    header('Location: ../index.php', true, 301);
    exit();
}else{

    if($vv->value == LoginState::TooManyAttempts->value){
        //Den Wert nicht nach außen witerreichen
        $vv = LoginState::WrongCredentials->value;
    }

    //echo "NOK";
    header('Location: form_login.php?option=f&cc='.$vv->value, true, 301);
    exit();
}


