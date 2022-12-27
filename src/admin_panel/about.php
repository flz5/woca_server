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
    <title>Info über | WOCS</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="container_header">
    <div style="font-size: x-large">Info über</div>
    <a href="index.php">Start</a> > Info über

</div>
<div class="container_default">

<div style="background-color: #BFBFBF">

    <h2>WOCS</h2>
    Version 1.0.0 <br>

    Copyright © 2021-2022 Frank Zimdars <br>


</div>
<br>
<br>


<div style="background-color: #BFBFBF">

    Administration:<br>

<?php
    include_once '..\lib\config_contact.php';

    echo $cfg_contact_name."<br>";
    echo $cfg_contact_address."<br>";
    echo $cfg_contact_city."<br>";
    echo $cfg_contact_country."<br>";
    echo $cfg_contact_email."<br>";
?>

</div>
</div>

</body>
</html>


