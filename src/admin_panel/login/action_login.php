<?php
/*
 * This file is part of the WOCA (server) project.
 * Copyright (c) 2020-2023 Frank Zimdars.
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
    header('Location: form_login.php?login_state=' . LoginState::Abort->value, true, 301);
    exit();
}

if($_POST['username'] == "" or $_POST['password'] == ""){
    header('Location: form_login.php?login_state=' . LoginState::Abort->value, true, 301);
    exit();
}

$login_state = ss_account_login($_POST['username'],$_POST['password']);

if($login_state == LoginState::OK){
    header('Location: ../index.php', true, 301);
}else{
    if($login_state->value == LoginState::TooManyAttempts->value){
        //Den Wert nicht nach außen weiterreichen
        $login_state = LoginState::WrongCredentials->value;
    }
    header('Location: form_login.php?login_state='.$login_state->value, true, 301);
}
exit();
