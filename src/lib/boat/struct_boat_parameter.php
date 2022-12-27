<?php declare(strict_types=1);
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

//Suchparameter
class struct_boat_parameter{

    public int $seats_min;  //Min. Seats
    public int $seats_max;  //Max. seats
    public int $weight;     //Weight
    public int $house;      //Bootshaus
    public int $tag;        //Tag
    public int $type;       //Typ

}

?>