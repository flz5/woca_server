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

<br>


    <p class="box_note">
        Hinweis: <br>
        User-ID kann in Account verwaltung gefunden wrden.

    </p>

<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = '0';
}

if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
}else{
    $user_id = '0';
}

if(isset($_GET['channel'])){
    $channel = $_GET['channel'];
}else{
    die("Kein Kanel!");
}

if(isset($_GET['permission_write']) and $_GET['permission_write'] == 1){
    $write = '1';
}else{
    $write = '0';
}

if(isset($_GET['permission_join']) and $_GET['permission_join'] == 1){
    $join = '1';
}else{
    $join = '0';
}


?>

<form action="action_permission_save.php" method="get">


    <table>


        <tr>
            <td>User-ID:</td>
            <td><input type="name" name="user_id" value="<?php echo $user_id ?>"></td>

        </tr>

        <tr>
            <td>Schreiben:</td>
            <td><input type="checkbox" name="permission_write" value="public" <?php if($write==1) {echo "checked";} ?>></td>

        </tr>
        <tr>
            <td>Beitreten:</td>
            <td><input type="checkbox" name="permission_join" value="public" <?php if($join==1) {echo "checked";} ?>></td>

        </tr>


    </table>




    <input type="hidden" name="id" value="<?php echo $id ?>">
    <input type="hidden" name="channel" value="<?php echo $channel ?>">

    <input type="submit" value="Speichern">

</form>
</div>
</body>

</html>
