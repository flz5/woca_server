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

require_once '../../lib/message/message.php';

/*
 *
 * Formular zum Beitreten eines Kanals
 * Parameter: KanalID
 *
 * Formular:
 * Beitritt bestätigen
 * Passwort (wenn vorhanden)
 *
 * Fehlermeldeung wenn nicht öffentlich oder keine Berechtigung vorhanden
 */
?>


    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>

    <h2>Übersicht</h2>

    <a href="..\index.php">Start</a> > <a href="index.php"> Nachrichten (Benutzer) </a> > <a href="table_channel_join.php">Kanal beitreten </a><br><br>
    <br><br>


<form action="action_channel_join.php" method="get">

    <table>

        <tr>
            <td>Kanal-ID:</td>
            <td><input type="id" name="id" value="<?php echo $_GET['id']?>"></td>

        </tr>
        <tr>
            <td>Typ:</td>
            <td>

                <select name="type" id="house-select">


                    <option value='0' selected>E-Mail</option>
                    <option value='1' selected>Android</option>
                    <option value='2' selected>iOS</option>
                    <option value='3' selected>UWP</option>
                </select>

            </td>

        </tr>

        <tr>
            <td>Device ID:</td>
            <td><input type="device" name="device" value=""></td>

        </tr>



        <tr>
            <td>PW:</td>
            <td><input type="device" name="password" value=""></td>

        </tr>



    </table>

    Bei Typ "Email" wird die Email Addresse des Accounts genommen. Das Feld ID braucht nicht ausgefüllt zu werden.

    <input type="submit" value="Speichern">
</form>

<?php
$tt = new message();
$list = $tt->getListJoinable();
?>