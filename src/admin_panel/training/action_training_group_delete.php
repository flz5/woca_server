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

session_start();

include_once '../../lib/account/db_account.php';
include_once '../../lib/account/session_login.php';
include_once '../../lib/training/db_training_group.php';
include_once '../../lib/training/db_training.php';
include_once '../../lib/training/struct_training_group.php';

if (!ss_account_isLoggedIn()) {
    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
}

if (!ss_account_requestPermission("training", 2)) {
    die("Keine Berechtigung!");
}

if(isset($_GET['data'])){
    $st = json_decode($_GET['data']);

    if(db_training_isUsingGroup($st->id)){
        echo "Der Datensatz wird noch verwendet und kann nicht gelöscht werden!";
    }else{
        db_training_deleteGroup($st);
        header('Location: table_training_group.php', true, 301);
        exit();
    }

}else{
    echo "Ungültig!";
}

?>

