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
        $device_list = $message->getListMyDevices();

        foreach($device_list as $device){
            $as_device = new appstruct_device();
            $as_device->device_id = $device->device_id;
            $as_device->type = $device->device_type;
            $as_device->id = $device->id;

            $as_device_array[] = $as_device;
        }
        echo json_encode($as_device_array);
    }
}

?>
