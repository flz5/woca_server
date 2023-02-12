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

class struct_event_slot_joined{

    public int $id;         //Database ID
    public int $user_id;     //User ID
    public string $user_name;     //User ID
    public int $event_id;    //event ID
    public int $time;       //Timestamp, when the entry was created


}