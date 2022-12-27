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

require_once "db_slots.php";
require_once "struct_slot_event.php";
require_once "struct_slot_user.php";
require_once "db_slots_event.php";

class slot_event{

    private int $id = 0;

    function setUserID(int $id) : void{
        $this->id = $id;
    }

    /**
     * @param int $event_id Datenbank-ID des Events
     * @return bool
     */
    function register(int $event_id) : bool{

        if($this->id == 0){
            return false;
        }

        $d1 = db_event_getWhereID($event_id);

        $cc = db_slots_event_getCount($event_id);

        if($d1->slots > $cc){
            db_slots_training_register($event_id,$this->id);
            return true;
        }
        return false;
    }

    function delete($id){

        $ss = db_slots_event_getWhereID($id);
        $d1 = db_event_getWhereID($ss->eventID);

        if(time() < $d1->time_start){
            db_slots_training_delete($id,$this->id);
            return true;
        }else{
            return false;
        }


    }

    /**
     * @param $time_range
     * @return array|null
     */
    function getListUser($time_range) : ?array{
        $tt = db_slots_training_getAllWhereUser($this->id,false);
        return $tt;
    }

    /**
     * @param $event
     * @param $time_range
     * @return array|null
     */
    function getListEvent($event) : ?array{

        $hh = db_slots_training_getAllWhereTraining($event);
        return $hh;

    }
    function getCount($event) : int{
        return db_slots_event_getCount($event);

    }
}