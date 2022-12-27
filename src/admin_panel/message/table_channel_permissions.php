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
    <a href="..\index.html">Start</a> > <a href="index.php">Nachrichten (Kanäle)</a> > Berechtigungen

</div>

<br>

<div class="container_default">

<a href="..\index.html">Start</a> > <a href="index.php">Nachrichten (Kanäle)</a> > Berechtigungen<br><br>


<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    die("ID notwendig");
}

echo "Kanal: ".$_GET['id'];

?>

<?php echo "<a href='form_permission_edit.php?channel=".$id."'>Neu...</a>"; ?>
<br><br>




<table border="1">
    <tr>
        <td>ID</td>
        <td>Account ID</td>
        <td>Beitreten</td>
        <td>Schreiben</td>
        <td>Aktion</td>

    </tr>


    <?php

    require_once '../../lib/message/message_admin.php';
    $tt = new message_admin();
    $list = $tt->getPermissionList($id);

    foreach($list as $rfr){


        echo "<tr>";
        echo "<td>".$rfr->id."</td>";
        echo "<td>".$rfr->user_id."</td>";

        if($rfr->permission_write == false){
            echo "<td>Nein</td>";
        }else{
            echo "<td>Ja</td>";
        }

        if($rfr->permission_join == false){
            echo "<td>Nein</td>";
        }else{
            echo "<td>Ja</td>";
        }




        echo "<td>";
            echo "<a href='form_permission_edit.php?id=".$rfr->id."&user_id=".$rfr->user_id."&permission_write=".$rfr->permission_write."&permission_join=".$rfr->permission_join."&channel=".$id."'>Bearbeiten</a><br>";
            echo "<a href='form_permission_delete.php?id=".$rfr->id."'>Löschen</a><br>";
        echo "</td>";

        echo "</tr>";




    }


    ?>

</table>
</div>
</body>
</html>