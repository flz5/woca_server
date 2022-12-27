<?php

//Das übergebene Passwort durch einen Hash ersetzen damit es nicht in der Datenbank ausgelesen werden kann
$salt = uniqid('', true);
$algo = '6'; // CRYPT_SHA512
$rounds = '5042';
$cryptSalt = '$'.$algo.'$rounds='.$rounds.'$'.$salt;
$hashedPassword = crypt("admin", $cryptSalt);

echo $hashedPassword;
echo "<br>";
echo $_SERVER['REMOTE_ADDR'];
