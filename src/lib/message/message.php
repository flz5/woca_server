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

require_once 'db_message.php';
require_once 'db_message_channel.php';
require_once 'db_message_member.php';
require_once 'db_message_permission.php';

require_once 'struct_message_permission.php';
require_once 'struct_message_joinInformation.php';
require_once 'struct_message_channel.php';
require_once 'struct_message_member.php';
require_once 'struct_message.php';

require_once 'enum_device_type.php';
require_once 'message_sender.php';

/*
 * Benuttzer
 *
 */

class message{

    private int $userID = 1;

    public function setUserID($id){
        $userID = $id;
    }


    //Benutzer hat das REecht in den Kanal zu schreiben
    public function isChannelWritable($channel) : bool{
        $dd = db_message_getPermissionStruct($this->userID,$channel);

        if($dd->permission_write == true){
            return true;
        }else{
            return false;
        }
    }

    public function isChannelJoinable($channel) : bool{
        $dd = db_message_getPermissionStruct($this->userID,$channel);

        if($dd->permission_join == true){
            return true;
        }else{
            return false;
        }
    }

    function sendMessage(struct_message $msg){

        //Nachricht in Datenbank speichern und anschließend DB-ID in Struct speichern
       $msg_id = db_message_add($msg);
       $msg->id = $msg_id;

       $receiver = $msg->receiver;

       $list_email = db_message_getChannelMemberByType($receiver,DeviceType::DeviceEmail->value);

        if(isset($list_email)){
            message_send_email($msg,$list_email);
        }


        $list_ios = db_message_getChannelMemberByType($receiver,DeviceType::DeviceIOS->value);


        if(isset($list_ios)){
            message_send_ios($msg,$list_ios);
        }

        $list_android = db_message_getChannelMemberByType($receiver,DeviceType::DeviceAndroid->value);

        if(isset($list_android)){
            message_send_android($msg,$list_android);
        }


        $list_uwp = db_message_getChannelMemberByType($receiver,DeviceType::DeviceWindowsUWP->value);

        if(isset($list_uwp)){
            message_send_uwp($msg,$list_uwp);
        }

    }

    function getMessage($id){
        return db_message_getWhereID($id);
    }

    function joinChannel($channel, $device_type,$device_id){

        db_message_addChannelMember($this->userID,$channel,$device_type,$device_id);

    }

    //Liste aller Kanäle denen beigetreten werden kann
    function getListJoinable() : ?array{

        //struct joinInformation
        $tt = db_message_getChannelsForUser($this->userID);
        return $tt;

    }

    function getListWritable(): ?array{
        //JOIN mit Kanalnamen/Beschreibung
        return db_message_getListChannelPermissionWrite($this->userID);

    }

    function getChannelPassword($id) : ?string{

        $t = db_message_getChannelsWhereID($id);
        return $t->password;

    }


    function getListMyDevices(){

        //Liste aller Geräte des Benutzers
        return db_message_getChannelMemberByUser($this->userID);

    }

    //Verlässt alle Kanäle (für den Benutzer)
    function leaveChannelAll() : bool{
        db_message_removeChannelMemberByUser($this->userID);
        return true;
    }

    function leaveChannelDevice($channel,$device_type, $device_id) : bool{
        db_message_removeChannelMemberByDevice($device_type,$device_id,$channel);
        return true;
    }

    function leaveChannelDeviceByID($id) : bool{
        db_message_removeChannelMemberByID($id);
        return true;
    }



    function updateDeviceTime($type,$id){
        db_message_updateMemberTime($type,$id);

    }



}
