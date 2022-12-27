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

session_start();

include_once '../../lib/account/db_account.php';
include_once '../../lib/account/session_login.php';

include_once '../../lib/boat/struct_boat.php';
include_once '../../lib/boat/struct_boat_house.php';
include_once '../../lib/boat/struct_boat_type.php';
include_once '../../lib/boat/struct_boat_tags.php';

include_once '../../lib/boat/db_boat_house.php';
include_once '../../lib/boat/db_boat_tags.php';
include_once '../../lib/boat/db_boat_type.php';

if (!ss_account_isLoggedIn()) {

    header('Location: ../login/form_login.php?option=p', true, 301);
    exit();
    //die("Nicht angemeldet");
}

if (!ss_account_requestPermission("boat", 2)) {
    die("Keine Berechtigung!");

}

if(isset($_GET['data'])){

    $st = json_decode($_GET['data']);

}else{
    $st = new struct_boat();
    $st->name = "*";
    $st->weight = "0";
    $st->seats = "0";
    $st->house = 0;
    $st->id = "";
    $st->tag1 = 0;
    $st->tag2 = 0;
    $st->tag3 = 0;
    $st->tag4 = 0;
    $st->place = "*";
    $st->type = 0;
}

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
    <a href="..\index.php">Start</a> > <a href="index.php">Boote</a> > Bootshäuser

</div>

<br>
<div class="container_default">

<a href="..\index.php">Start</a> > <a href="index.php">Boote</a> > Boot hinzufügen<br><br>

<form action="action_boat_save.php">
    <table>
        <tr>
            <td>Name:</td>
            <td><input type="name" name="name" value="<?php echo $st->name; ?>"></td>
        </tr>
        <tr>
            <td>Gewicht:</td>
            <td><input type="text" name="weight" value="<?php echo $st->weight; ?>"></td>
        </tr>
        <tr>
            <td>Sitze:</td>
            <td><input type="text" name="seats" value="<?php echo $st->seats; ?>"></td>
        </tr>
        <tr>
            <td>Platz:</td>
            <td><input type="text" name="place" value="<?php echo $st->place; ?>"></td>
        </tr>

        <tr>
            <td>Typ:</td>
            <td>
                <select name="type" id="house-select">
                    <?php
                    $list = db_boat_getTypeAll();
                    foreach($list as $k){

                        if($k->id == $st->type){
                            echo "<option value='".$k->id."' selected>".$k->name."</option>";
                        }else{
                            echo "<option value='".$k->id."'>".$k->name."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tag1:</td>
            <td>
            <select name="tag1" id="house-select">
                <?php
                $list = db_boat_getTagAll();
                foreach($list as $k){
                    if($k->id == $st->tag1){
                        echo "<option value='".$k->id."' selected>".$k->name."</option>";
                    }else{
                        echo "<option value='".$k->id."'>".$k->name."</option>";
                    }
                }
                ?>
            </select>
            </td>
        </tr>
        <tr>
            <td>Tag2:</td>
            <td>
                <select name="tag2" id="house-select">
                    <?php
                    $list = db_boat_getTagAll();
                    foreach($list as $k){

                        if($k->id == $st->tag1){
                            echo "<option value='".$k->id."' selected>".$k->name."</option>";
                        }else{
                            echo "<option value='".$k->id."'>".$k->name."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tag3:</td>
            <td>
                <select name="tag3" id="house-select">
                    <?php
                    $list = db_boat_getTagAll();
                    foreach($list as $k){

                        if($k->id == $st->tag1){
                            echo "<option value='".$k->id."' selected>".$k->name."</option>";
                        }else{
                            echo "<option value='".$k->id."'>".$k->name."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tag4:</td>
            <td>
                <select name="tag4" id="house-select">
                    <?php
                    $list = db_boat_getTagAll();
                    foreach($list as $k){
                        if($k->id == $st->tag1){
                            echo "<option value='".$k->id."' selected>".$k->name."</option>";
                        }else{
                            echo "<option value='".$k->id."'>".$k->name."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Bootshaus:</td>
            <td>
                <select name="house" id="house-select" value="<?php $st->house?>">
                    <?php
                    $list = db_boat_getHousesAll();
                    foreach($list as $k){
                        if($k->id == $st->house){
                            echo "<option value='".$k->id."' selected>".$k->name."</option>";
                        }else{
                            echo "<option value='".$k->id."'>".$k->name."</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <input type="hidden" name="id" value="<?php echo $st->id; ?>">
    <input type="submit" value="Speichern">
</form>
</div>
</body>

</html>
