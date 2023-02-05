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

include_once "sql_exec.php";

exeSQL("sql/table_account.sql");
exeSQL("sql/table_account_ip.sql");
exeSQL("sql/table_account_registration_token.sql");
exeSQL("sql/table_account_restore_token.sql");
exeSQL("sql/table_boat.sql");
exeSQL("sql/table_boat_house.sql");
exeSQL("sql/table_boat_tag.sql");
exeSQL("sql/table_boat_type.sql");
exeSQL("sql/table_contact.sql");
exeSQL("sql/table_document.sql");
exeSQL("sql/table_event.sql");
exeSQL("sql/table_event_group.sql");
exeSQL("sql/table_location.sql");
exeSQL("sql/table_message.sql");
exeSQL("sql/table_message_channel.sql");
exeSQL("sql/table_message_member.sql");
exeSQL("sql/table_message_permission.sql");
exeSQL("sql/table_slot_event.sql");
exeSQL("sql/table_slot_training.sql");
exeSQL("sql/table_track_startpoint.sql");
exeSQL("sql/table_track_waypoint.sql");
exeSQL("sql/table_training.sql");
exeSQL("sql/table_training_group.sql");

header('Location: index.php?rval=2', true, 301);
exit;

?>
