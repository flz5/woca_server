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

require_once '../../lib/message/message_admin.php';

if (!isset($_POST['name'])) {
    die("name erforderlich");
}
$name = $_POST['name'];

if (!isset($_POST['description'])) {
    die("description erforderlich");
}
$description = $_POST['description'];

if (!isset($_POST['public'])) {
    $public = false;
}else{
    $public = true;
}


if (!isset($_POST['password'])) {
    die("password erforderlich");
}
$password = $_POST['password'];


if(isset($_POST['id'])){
    $id = $_POST['id'];
}else{
    $id = 0;
}

$tt = new message_admin();

if($id == 0){
    $tt->createChannel($name,$description,$public,$password);
}else{
    $tt->editChannel($id,$name,$description,$public,$password);
}



echo "Ok";

?>

<html>

<body>


<form>


</form>

</body>


</html>