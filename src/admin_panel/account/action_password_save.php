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

if (!ss_account_isLoggedIn()) {
    die("Nicht angemeldet!");
}


if(!ss_account_requestPermission("account",2)){
    die("Keine Berechtigung!");
}

if ($_POST['password_new1'] != $_POST['password_new2']) {
    header('Location: form_passwort_edit.php?option=c2', true, 301);
    exit();
}

echo ss_account_getID();

$status = db_account_changePasswort($_POST['id'], $_POST['password_new1']);

if ($status) {
    header('Location: index.php', true, 301);
} else {
    header('Location: form_passwort_edit.php?option=c3&username='.$_POST['id'], true, 301);
    exit();
}
