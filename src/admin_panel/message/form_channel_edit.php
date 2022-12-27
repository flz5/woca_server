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
    <title>Orte | WOCS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Events hinzufügen/bearbeiten</div>
    <a href="..\index.php">Start</a> > <a href="index.php">Nachrichten</a> > Kanal hinzufügen/bearbeiten

</div>

<br>

<div class="container_default">

<br><br>

<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = '0';
}

if(isset($_GET['name'])){
    $name = $_GET['name'];
}else{
    $name = '0';
}

if(isset($_GET['description'])){
    $description = $_GET['description'];
}else{
    $description = '0';
}

if(isset($_GET['public'])){
    $public = $_GET['public'];
}else{
    $public = '0';
}

if(isset($_GET['password'])){
    $password = $_GET['password'];
}else{
    $password = '0';
}

?>

<form action="action_channel_create.php" method="post">


    <table>

        <tr>
            <td>Name:</td>
            <td><input type="name" name="name" value="<?php echo $name ?>"></td>

        </tr>
        <tr>
            <td>Beschreibung:</td>
            <td><input type="name" name="description" value="<?php echo $description ?>"></td>

        </tr>

        <tr>
            <td>Beitritt für alle:</td>
            <td><input type="checkbox" name="public" value="public" <?php if($public==1) {echo "checked";} ?>></td>

        </tr>

        <tr>
            <td>Passwort:</td>
            <td><input type="name" name="password" value="<?php echo $password ?>"></td>

        </tr>




    </table>




    <input type="hidden" name="id" value="<?php echo $id ?>">

    <input type="submit" value="Speichern">

</form>
</div>
</body>

</html>
