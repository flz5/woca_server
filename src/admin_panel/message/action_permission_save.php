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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}else{
    $id = 0;
}

if (!isset($_GET['user_id'])) {
    die("user_id erforderlich");
}
$user_id = $_GET['user_id'];

if (!isset($_GET['permission_write'])) {
    $write = 0;
}else{
    $write = 1;
}

if (!isset($_GET['permission_join'])) {
    $join = 0;
}else{
    $join = 1;
}

if (!isset($_GET['channel'])) {
    die("channel erforderlich");
}
$channel = $_GET['channel'];


$tt = new message_admin();

if($id == 0){
    $tt->addChannelPermission($channel,$user_id,$write,$join);
}else{
    $tt->editChannelPermission($id,$channel,$user_id,$write,$join);
}



echo "Ok";

?>

<html>

<body>


<form>


</form>

</body>


</html>