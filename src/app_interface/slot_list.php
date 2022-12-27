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

if(!isset($_GET['session']) and isset($_GET['mode'])){

    session_start($_GET['session']);

    if(ss_account_isLoggedIn()){
        $userID = ss_account_getID();

        if($_GET['mode'] == 0){
            $slot = new slot_training();
            $slot->setUserID($userID);
            $retVal = $slot->getListUser();

        }else{
            $slot = new slot_event();
            $slot->setUserID($userID);
            $retVal = $slot->getListUser();
        }
        echo json_encode($retVal);
    }
}
?>
