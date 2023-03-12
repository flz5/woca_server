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
    <title>Anmelden | WOCA</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<div class="d4">
    <p class="p4">
        Anmeldung
    </p>

    <h2 style="margin-bottom: 0px;">Willkommen</h2>

    Für den Zugriff auf diese Seite ist eine Anmeldung erforderlich.<br><br>

    <?php
    if(isset($_GET['login_state'])){

        echo "<p class='box_failed' style='margin-left: 15px;margin-right: 15px;'>";

        switch($_GET['login_state']){

            case LoginState::WrongCredentials->value:{
                echo "Die eingegebene Daten sind ungültig!";
            }break;
            case LoginState::TooManyAttempts->value:{
                echo "Die Anmeldung wurde zeitweise gesperrt!";
            }break;
            case LoginState::IPBlock->value:{
                echo "Die Anmeldung von dieser IP wurde zeitweise gesperrt!";
            }break;
            case LoginState::Abort->value:{
                echo "Beide Felder müssen ausgefüllt werden!";
            }break;
            case LoginState::NotActivated->value:{
                echo "Der Account ist nicht zur Anmeldung freigegeben!";
            }break;
        }
        echo "</p>";
    }

    ?>

    <form action="action_login.php" method="post">
        <table>
            <tr>
                <td>Benutzername:</td>
                <td><input type="name" name="username" value=""></td>
            </tr>
            <tr>
                <td>Passwort:</td>
                <td><input type="password" name="password" value=""></td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Anmelden">
                </td>
            </tr>
            <tr>
                <td>
                    <a href="form_notes.php">Hinweise zum Anmelden</a><br>
                    <a href="../about.php">Info über...</a>
                </td>
            </tr>
        </table>
        <br>
    </form>
</div>
</html>