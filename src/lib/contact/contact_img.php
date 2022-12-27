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

function contact_getImgList(){

    // Der Punkt steht für das Verzeichnis, in der auch dieses
    // PHP-Programm gespeichert ist
    $verzeichnis = "../../data/contact/";
    //echo "<ol>";

    // Test, ob es sich um ein Verzeichnis handelt
    if (is_dir($verzeichnis)) {
        // öffnen des Verzeichnisses
        if ($handle = opendir($verzeichnis)) {
            // einlesen der Verzeichnisses
            while (($file = readdir($handle)) !== false) {
                $txt = basename($file);
                if($txt != "." and $txt != ".."){
                    $names[] = $txt;
                }
            }
            closedir($handle);
        }
    }
    return $names ?? null;
}

function contactUploadImage($image,$name,$size){

    global $contact_img_path;

    $verzeichnis = "../../data/contact/";

    $upload_folder = $verzeichnis; //Das Upload-Verzeichnis
    $filename = pathinfo($name, PATHINFO_FILENAME);
    $extension = strtolower(pathinfo($name,PATHINFO_EXTENSION));

    //Überprüfung der Dateiendung
    $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif');
    if(!in_array($extension, $allowed_extensions)) {
        return -1;
        //die("Ungültige Dateiendung. Nur png, jpg, jpeg und gif-Dateien sind erlaubt");
    }

    //Überprüfung der Dateigröße
    $max_size = 500*1024; //500 KB
    if($size > $max_size) {
        return -2;
        //die("Bitte keine Dateien größer 500kb hochladen");
    }

    //Überprüfung dass das Bild keine Fehler enthält
    if(function_exists('exif_imagetype')) { //Die exif_imagetype-Funktion erfordert die exif-Erweiterung auf dem Server
        $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $detected_type = exif_imagetype($image);
        if(!in_array($detected_type, $allowed_types)) {
            return -3;
            //die("Nur der Upload von Bilddateien ist gestattet");
        }
    }

    //Pfad zum Upload
    $new_path = $upload_folder.$filename.'.'.$extension;

    //Neuer Dateiname falls die Datei bereits existiert
    /*
    if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
        $id = 1;
        do {
            $new_path = $upload_folder.$filename.'_'.$id.'.'.$extension;
            $id++;
        } while(file_exists($new_path));
    }*/

    //Alles okay, verschiebe Datei an neuen Pfad


    move_uploaded_file($image, $new_path);

   // return 0;

}

function contact_deleteImage($image){
    $verzeichnis = "../../data/contact/";
    unlink($verzeichnis.$image);

}