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
    <title>Title</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container_header">
    <div style="font-size: x-large">Bild hochladen</div>
    <a href="..\index.php"> Start </a> > <a href="index.php">Kontakte</a> > <a href="table_images.php">Bilderübersicht</a> > Neu

</div>

<div class="container_default">

<?php


if(isset($_GET['error'])){

    echo "<p class='box_failed'>Beim Hochladen der Datei ist ein Fehler aufgetreten!</p>";


}


?>


<form action="action_image_upload.php" method="post" enctype="multipart/form-data">
    Datei: <input type="file" name="datei"><br><br>
    Name: <input type="text" name="name" value="Img001.jpg"><br><br>
    <input type="submit" value="Hochladen">
</form>
<br>

Hinweise: <br>

<ul>
    <li>Maximale Dateigroe*e: 500kB</li>
    <li>Nur Bilddateien folgender Formate: jpg,png</li>
    <li>Bestehende Dateien mit dem gleichen Namen werden überschrieben</li>

</ul>

</div>