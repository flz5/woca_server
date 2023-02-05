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

$file_source = 'data_internal/config/config.php';
$file_destination = '../lib/config.php';

//Skript stoppen falls die benötigten Parameter fehlen
if(!isset($_POST['server'])){
    die("STOP: Parameter fehlt!");
}
if(!isset($_POST['database'])){
    die("STOP: Parameter fehlt!");
}
if(!isset($_POST['username'])){
    die("STOP: Parameter fehlt!");
}
if(!isset($_POST['password'])){
    die("STOP: Parameter fehlt!");
}

//Prüfen ob die Installationsdateien vorhanden sind
if (!file_exists($file_source)) {
    die("STOP: Dateien unvollständig (Quelldatei fehlt)!");
}

$text = file_get_contents($file_source);
$text = str_replace("%MYSQL_SERVER%", $_POST['server'], $text);
$text = str_replace("%MYSQL_USER%", $_POST['username'], $text);
$text = str_replace("%MYSQL_PASSWORD%", $_POST['password'], $text);
$text = str_replace("%MYSQL_DATABASE%", $_POST['database'], $text);
file_put_contents($file_destination, $text);

header('Location: index.php?rval=3', true, 301);
exit;