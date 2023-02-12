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

require_once "../lib/account/session_login.php";
require_once "../lib/message/enum_state.php";
require_once "../lib/events/db_event.php";
require_once "../lib/events/db_event_slots.php";

$status = new appstruct_status();
$status->state = APIState::Error_Unknown;
$status->msg = "";

if(!isset($_GET['session']) and isset($_GET['id']) ){
    session_start($_GET['session']);
    if(ss_account_isLoggedIn()){
        $event_id = $_GET['id'];
        $userID = ss_account_getID();
        $data = db_event_get_item_joined($event_id);
        $count = db_event_slots_get_count($event_id);

        if($count >= $data->slots){
            //Es sind bereits alle Plätze vergeben
            $status->state = APIState::Error_Unknown;
        }else{
            db_event_slot_register($event_id,$userID);
            $status->state = APIState::OK;
        }
    }
}else{
    $status->state = APIState::Error_InvalidData;
}

echo json_encode($status);

?>