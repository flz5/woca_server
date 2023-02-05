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

//MySQL database server
$mysql_server = "%MYSQL_SERVER%";
$mysql_user = "%MYSQL_USER%";
$mysql_password = "%MYSQL_PASSWORD%";
$mysql_database = "%MYSQL_DATABASE%";

//login / security
$security_ip_enabled = true;
$security_ip_limit = 5;
$security_ip_waiting = 900;        //Waiting time in seconds until the counter is released

$security_account_enabled = true;
$security_account_limit = 5;
$security_account_waiting = 900;   //Waiting time in seconds until the counter is released

//registration (admin-panel)
$cfg_registration_enabled = true;
$cfg_registration_group = "guest";

?>