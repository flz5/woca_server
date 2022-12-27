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

require_once '../../lib/message/message.php';

if(!isset($_GET['id'])){
    die("ID erforderlich");
}



$id = $_GET['id'];


if(!isset($_GET['type'])){
    die("type erforderlich");
}

$type = $_GET['type'];

if(!isset($_GET['device'])){
    die("device erforderlich");
}

$device = $_GET['device'];


$tt = new message();
$tt->setUserID(1);



$pw_db = $tt->getChannelPassword($id);
if(isset($pw_db)){

    $joinP = $tt->isChannelJoinable($id);

    if(!isset($_GET['password']) and $joinP==false ){
        die("Passwort erforderlich");

    }

    if($pw_db == $_GET['password']){
        echo "OK";
        $tt->joinChannel($id,$type,$device);
    }else{
        echo "Passwort nicht ok";
    }



}

?>

<html>

<body>


<form>




</form>

</body>


</html>