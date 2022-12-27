<?php declare(strict_types = 1);
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
 * WOCS
 * (c) Copyright 2022 Frank Zimdars
 */
require_once 'db_message.php';
require_once 'db_message_channel.php';
require_once 'db_message_member.php';
require_once 'db_message_permission.php';

require_once 'struct_message_permission.php';
require_once 'struct_message_joinInformation.php';
require_once 'struct_message_channel.php';
require_once 'struct_message_member.php';
require_once 'struct_message.php';


/*
 * Admin Modus
 *
 */

class message_admin{
    function addChannelPermission($channel,$userID,$write,$join) : bool{
        $t = new struct_message_permission();
        $t->user_id = $userID;
        $t->permission_join = $join;
        $t->permission_write = $write;
        $t->channel_id = $channel;

        db_message_addPermission($t);

        return true;
    }

    function removeChannelPermission($id) : bool{
        db_message_deletePermission($id);
        return true;
    }

    function editChannelPermission($id,$channel,$userID,$write,$join) : bool{

        $t = new struct_message_permission();
        $t->id = $id;
        $t->user_id = $userID;
        $t->permission_join = $join;
        $t->permission_write = $write;
        $t->channel_id = $channel;

        db_message_editPermission($t);
    return true;
    }


    function createChannel($name,$description,$public,$password) : bool{

        $tt = new struct_message_channel();
        $tt->password = $password;
        $tt->public = $public;
        $tt->description = $description;
        $tt->name = $name;

        db_message_addChannel($tt);

        return true;
    }

    function editChannel($id,$name,$description,$public,$password) : bool{
        $tt = new struct_message_channel();
        $tt->password = $password;
        $tt->public = $public;
        $tt->description = $description;
        $tt->name = $name;
        $tt->id = $id;

        db_message_editChannel($tt);

        return true;
    }

    function deleteChannel($id) : bool{
        db_message_deletePermission($id);
        return true;
    }

    function getPermissionList($id) : ?array{

        $t = db_message_getListChannelPermission($id);

        return $t;
    }

    function getChannelList() : ?array{

        return db_message_getChannels();
    }



}

