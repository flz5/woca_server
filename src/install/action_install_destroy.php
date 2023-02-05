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

/*
 * Aufrufen nach Ende der Installation
 * Aufgaben:
 * Entfernen der Installationsdateien so dass über diese keine weitere Installation im Betrieb mehr ausgeführt werden kann
 *
 * Entfernen aller Dateien aus dem Install Ordner (außer index)
 * Umleiten auf Index
 *
 */

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

//Index des Installers durch Platzhalterseite ersetzen
copy("data_internal/install/index.php","index.php");

//Skripte löschen
unlink("action_install_config.php");
unlink("action_install_database.php");
unlink("action_install_database_user.php");
unlink("action_install_drop_tables.php");
unlink("action_install_files.php");
unlink("form_install_config.php");
unlink("sql_exec.php");

//Ordner löschen
rrmdir("sql");
rrmdir("data_internal");

//Umleiten zur neuen Startseite des Installers
header('Location: index.php', true, 301);
exit;