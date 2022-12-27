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

include "enum_input_type.php";

class input_filter{

    //bereinigt den String um snsichere Elemente

    function clean($text) : String{
        return trim(htmlspecialchars($text));
    }

    //Prüft ob der String die anforderungen an den Typ erfüllt
    function checkType($text,$type) : Bool{
        $retVal = false;

        if($type == input_type::Mail){
            $retVal = filter_var($text, FILTER_VALIDATE_EMAIL);
        }
        if($type == input_type::Float){
            $retVal = filter_var($text, FILTER_VALIDATE_FLOAT);
        }
        if($type == input_type::Integer){
            $retVal = filter_var($text, FILTER_VALIDATE_INT);
        }
        if($type == input_type::String){
            $retVal = true;
        }
        if($type == input_type::Boolean){
            $retVal = filter_var($text, FILTER_VALIDATE_BOOLEAN);
        }
        if($type == input_type::URL){
            $retVal = filter_var($text, FILTER_VALIDATE_URL);
        }

        return $retVal;
    }
}