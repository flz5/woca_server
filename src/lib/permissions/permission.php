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

class Permission{

    public function getArray($group,$permission,$level){
        return permission_getArray($group, $permission, $level);
    }

    public function isSet($group,$permission,$level){

    }

}

function permission_getArray($group, $permission, $level) : ?array{

    $path = dirname(__FILE__) ."/../../data_internal/permissions/";
    $ini_array = parse_ini_file($path . $group.".ini");
    return $ini_array;
}

function permission_isSet($group,$permission,$level) : bool{


    $path = dirname(__FILE__) ."/../../data_internal/permissions/";
    $ini_array = parse_ini_file($path . $group.".ini");

    if(isset($ini_array[$permission])){

        if($ini_array[$permission] >= $level){

            return true;
        }
    }
    return false;
}

function permission_getGroups() :?array{
    $path = dirname(__FILE__) ."/../../data_internal/permissions/";

    $ordner=opendir($path);
    while(($datei=readdir($ordner))!=false) {
        if($datei!="." && $datei!="..") {
            $groups[] = substr($datei,0,-4);
        } }

    return $groups;
}

function permission_getDescription($group){
    $path = dirname(__FILE__) ."/../../data_internal/permissions/";
    $ini_array = parse_ini_file($path . $group.".ini");

    if(isset($ini_array["text"])){
        return $ini_array["text"];
    }else{
        return "Keine Beschreibung";
    }
}

function permission_readFile($group) : string{
    $path = dirname(__FILE__) ."/../../data_internal/permissions/";
    $filename = $path . $group .".ini";
    $file = fopen($filename, "r");
    return fread($file,filesize($filename));
}

function permission_writeFile($group,$text) :void{
    $path = dirname(__FILE__) ."/../../data_internal/permissions/";
    file_put_contents($path . $group .".ini", $text);
}

function permission_deleteFile($group) :void{
    $path = dirname(__FILE__) ."/../../data_internal/permissions/";
    unlink($path . $group .".ini");
}
