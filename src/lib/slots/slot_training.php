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
require_once "db_slots_training.php";

class slot_training{

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

        $d1 = db_training_getWhereID($event_id);
        $timestamp = db_slot_create_timestamp_dayOfTheWeek($d1->day,$d1->end_hour,$d1->end_minute);

        $cc = db_slots_training_getCount($event_id,$timestamp,0);

        if($d1->slots > $cc){
            db_slots_training_register($event_id,$this->id);
            return true;
        }
        return false;
    }


    function delete($id){

        $ss = db_slots_training_getWhereID($id);
        $d1 = db_training_getWhereID($ss->eventID);
        $timestamp = db_slot_create_timestamp_dayOfTheWeek($d1->day,$d1->end_hour,$d1->end_minute);

        if($timestamp > $ss->time){
            db_slots_training_delete($id,$this->id,$timestamp);
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

        $time_now = time();
        $week = 604800; //Dauer Woche

        $time_min = $time_now - $week;
        $time_max = 0;

        if($time_range != 0){
            $time_min = $time_now - ($time_range * $week);
            $time_max = $time_now - (($time_range+1) * $week);
        }

        $tt = db_slots_training_getAllWhereUser($this->id,$time_min,$time_max);

        return $tt;

    }

    /**
     * @param $event
     * @param $time_range
     * @return array|null
     */
    function getListEvent($event,$time_range) : ?array{

        $d1 = db_training_getWhereID($event);
        $timestamp = db_slot_create_timestamp_dayOfTheWeek($d1->day,$d1->end_hour,$d1->end_minute);

        $time_min = $timestamp;
        $time_max = 0;

        $week = 604800; //Dauer Woche

        if($time_range != 0){
            $time_min = $timestamp - ($time_range * $week);
            $time_max = $timestamp - (($time_range+1) * $week);
        }

        $hh = db_slots_training_getAllWhereTraining($event,$time_min,$time_max);

        return $hh;

    }

    function clear($id){
        $d1 = db_training_getWhereID($id);
        $timestamp = db_slot_create_timestamp_dayOfTheWeek($d1->day,$d1->end_hour,$d1->end_minute);
        db_slots_training_clear($id,$timestamp);
    }

    function getCount($event) : int{
        return db_slots_training_getCount($event);

    }

}