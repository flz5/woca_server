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


class struct_event_joined
{
    //Event
    public int $id;
    public string $title;
    public string $description;
    public int $time_start;
    public int $time_end;

    //Location
    public int $location_id;
    public string $location_name;
    public  $geo_lat;
    public  $geo_long;
    public string $address;
    public string $color;

    //Group
    public int $group_id;
    public string $group_name;


    //Slot system
    //Total number of seats available
    public int $slots_total;
    //Number of free places
    public int $slots_free;
    //Indicates whether there is a registration for the event (ID or 0)
    public int $registered;

    //App interface
    public bool $has_date;
    public bool $has_location;

    //Entfernt alle internen IDs aus dem Datensatz damit er sicher zur App (extern) übertragen werden kann
    function clean_id() : void{
        $this->id = 0;
        $this->location_id = 0;
        $this->group_id = 0;
        if($this->registered != 0){
            $this->registered = 1;
        }

    }

}


