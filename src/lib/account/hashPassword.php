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

function db_password_hashPassword($text) : string{

    //Das übergebene Passwort durch einen Hash ersetzen damit es nicht in der Datenbank ausgelesen werden kann
    $salt = uniqid('', true);
    $algo = '6'; // CRYPT_SHA512
    $rounds = '5042';
    $cryptSalt = '$'.$algo.'$rounds='.$rounds.'$'.$salt;
    $hashedPassword = crypt($text, $cryptSalt);

    return $hashedPassword;
}

function db_password_hashPasswordCompare($clear,$hashed) :bool{
    if (crypt($clear, $hashed) == $hashed) {
        return true;
    }else{
        return false;
    }
}

//Überprüft die Stärke eines Passwort
function passwort_validateStrength($password) : bool{
    $number = preg_match('@[0-9]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
        return false;
        //echo "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
    } else {
        return true;
        echo "Your password is strong.";
    }
}

?>