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

if(!isset($_GET['session'])){
    session_start($_GET['session']);
    if(ss_account_isLoggedIn()){
        $userID = ss_account_getID();

        $message = new message();
        $message->setUserID($userID);
        $channel_list = $message->getListJoinable();

        foreach($channel_list as $channel){
            $as_channel = new appstruct_channel();

            $as_channel->id = $channel->id;
            $as_channel->description = $channel->description;
            $as_channel->name = $channel->name;
            $as_channel->password_required = $channel->password_required;
            $as_channel->public = $channel->public;
            $as_channel->permission_write = $channel->permission_write;

            $as_channel_array[] = $as_channel;
        }
        echo json_encode($as_channel_array);
    }

}
?>
