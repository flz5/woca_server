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

/*
 * Ort für Training und Veranstalungen
 *
 */

class struct_location{
    public $id; //Datenbank ID
    public $type;   //Typ des Eintrags
    public $name;   //Name des Ortes
    public $description;    //Beschreibung
    public $address_street; //Straße
    public $address_city;   //Stadt
    public $address_postal_code; //PLZ
    public $address_country;    //Land
    public $geo_long;   //GPS
    public $geo_lat;    //GPS
}

?>