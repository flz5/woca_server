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

if(!isset($_GET['title'])){
    die("title erforderlich");
}

$title = $_GET['title'];

if(!isset($_GET['text'])){
    die("device erforderlich");
}
$text = $_GET['text'];

$tt = new message();
$tt->setUserID(1);


if($tt->isChannelWritable($id)){

    $z = new struct_message();
    $z->title = $title;
    $z->author = 1;
    $z->time = time();
    $z->receiver = $id;
    $z->text = $text;

    $tt->sendMessage($z);


}
?>

<html>
<body>

<form>

</form>

</body>


</html>