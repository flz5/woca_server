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

if(isset($_GET['session']) and isset($_GET['channel']) and isset($_GET['text']) and isset($_GET{'titile'})){

    session_start($_GET['session']);

    if(ss_account_isLoggedIn()){
        $userID = ss_account_getID();

        $message = new message();
        $message->setUserID($userID);

        if($message->isChannelWritable($_GET['channel'])){

            $msg = new struct_message();
            $msg->author = $userID;
            $msg->receiver = $_GET['channel'];
            $msg->time = time();
            $msg->text = $_GET['text'];
            $msg->title = $_GET['title'];

            $message->sendMessage($msg);
            $status->state = APIState::OK;
        }else{
            $status->state = APIState::Error_NoPermission;
        }
    }else{
        $status->state = APIState::Error_LoginRequired;
    }
}else{
    $status->state = APIState::Error_InvalidData;
}

echo json_encode($status);

?>