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

?>

<html>
<body>

<h2>Woca-Server</h2>
<h3>Installer</h3>

<?php

if(isset($_GET['rval'])){
    echo "<p>";

    switch ($_GET['rval']) {
        case 1:
            echo "Tabellen hinzugefügt.";
            break;
        case 2:
            echo "Benutzer hinzugefügt.";
            break;
        case 3:
            echo "Konfiguration gespeichert.";
            break;
        case 4:
            echo "Tabellen gelöscht.";
            break;
        case 5:
            echo "Dateien kopiert.";
            break;
    }

    echo "</p><br>";
}
?>

Installation: <br>
<a href="form_install_config.php">Konfiguration einrichten</a><br>
<a href="action_install_database.php">Datenbank Tabellen erstellen</a><br>
<a href="action_install_database_user.php">Benutzer(Admin) erstellen</a><br>
<a href="action_install_files.php">Gruppen einrichten</a><br>
<a href="action_install_destroy.php">Installer entfernen</a><br><br>

Wartungsoptionen: <br>
<a href="action_install_drop_tables.php">Tabellen löschen</a><br><br>

Hinweis: <br>
Der Installer muss, nach dem alle Vorgänge abgeschlossen wurden, gelöscht werden. <br>

</body>
</html>
