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

/**
 * @param $day ;Day of the Week, 1 = Monday
 * @param $hour
 * @param $minute
 * @return int ;Unix Timestamp
 */
function db_slot_create_timestamp_dayOfTheWeek($day,$hour,$minute): int
{

    $weekday =  ["monday","tuesday","wednesday","thursday","friday","saturday","sunday"];

    $time = strtotime("previous ". $weekday[$day]);

    $time += $minute * 60;
    $time += $hour * 60 * 60;

    return $time;
}



