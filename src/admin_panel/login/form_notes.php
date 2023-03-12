<?php
/*
 * This file is part of the WOCA (server) project.
 * Copyright (c) 2020-2023 Frank Zimdars.
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

include_once '../../lib/account/enum_login_state.php';

?>

<html>

<head>
    <title>Hinweise Login | WOCA</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="d4">
    <p class="p4">
        Hinweise zur Anmeldung
    </p>

    <h3>Automatische Sperrung der Anmeldung</h3>
    Wenn zu oft versucht wird, sich mit falschen Zugangsdaten anzumelden, <br>
    wird die Anmeldung beim angegebenen Account für eine kurze Zeit gesperrt. <br>
    Die Zugangsdaten werden als falsch angezeigt, auch wenn sie korrekt sind. <br>
    Jeder Versuch setzt die Wartezeit zurück! <br>

    <h3>Speicherung der IP Addresse</h3>
    Die IP Addresse wird beim Anmeldevorgang in einer Datenbank gespeichert.

    <h3>Passwort vergessen</h3>
    Vergessene Passwörter können nicht automatisch zurückgesetzt werden!<br>
    Die Wiederherstellung muss durch einen Benutzer mit der Berechtigung erfolgen.<br><br>

    <a href="form_login.php">Zurück</a><br>

</div>
</body>
</html>