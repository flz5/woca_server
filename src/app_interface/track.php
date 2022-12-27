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

require_once "../lib/track/appstruct_track.php";
require_once "../lib/track/struct_track_waypoint.php";
require_once "../lib/track/track_startpoint.php";
require_once "../lib/track/track_waypoint.php";

$startpoint = new track_startpoint();
$waypoint = new track_waypoint();

$list_startpoints = $startpoint->getAll();

foreach ($list_startpoints as $g){
    $as_track = new appstruct_track();
    $list_waypoints = $waypoint->getAllByStartpoint($g->id);
    $as_track->waypoints = $list_waypoints;

    $as_track_array[] = $as_track;
}

echo $as_track_array;

?>
