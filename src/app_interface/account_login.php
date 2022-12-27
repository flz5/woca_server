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

require_once "../lib/account/session_login.php";
require_once "../lib/message/enum_state.php";

$status = new appstruct_status();
$status->state = APIState::Error_Unknown;
$status->msg = "";

if(isset($_GET['username']) and isset($_GET['password'])){
    session_start();
    $state = ss_account_login($_GET['username'],$_GET['password']);
    if($state == LoginState::OK){
        $status->data = session_id();
        $status->state = APIState::OK;
    }else{
        $status->state = APIState::Error_LoginInvalid;
    }
}else{
    $status->state = APIState::Error_InvalidData;
}

echo json_encode($status);
