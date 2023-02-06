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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Datei hochladen | WOCS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Datei hochladen</div>
    <a href="..\index.php">Start</a> > <a href="table_documents.php">Dokumente</a> > <a href="table_files.php">Dateien</a> > Hochladen

</div>

<form action="action_file_upload.php" method="post" enctype="multipart/form-data">
    Datei: <input type="file" name="datei"><br><br>
    Name: <input type="text" name="name" value="Doc001.jpg"><br><br>
    <input type="submit" value="Hochladen">
</form>


Hinweise: <br>

<ul>
    <li>Maximale Dateigroe*e: 500kB</li>
    <li>Bestehende Dateien mit dem gleichen Namen werden überschrieben</li>
</ul>

</body>
</html>