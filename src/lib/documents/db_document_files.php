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

function document_getFileList(){

    // Der Punkt steht für das Verzeichnis, in der auch dieses
    // PHP-Programm gespeichert ist
    $verzeichnis = "../../data/documents/";

    // Test, ob es sich um ein Verzeichnis handelt
    if (is_dir($verzeichnis)) {
        // öffnen des Verzeichnisses
        if ($handle = opendir($verzeichnis)) {
            // einlesen der Verzeichnisses
            while (($file = readdir($handle)) !== false) {
                //echo "<li>Dateiname: ";
                //echo $file;

                $txt = basename($file);
                if($txt != "." and $txt != ".."){
                    $names[] = $txt;
                }

            }
            closedir($handle);
        }
        //echo $names;
    }

    return $names ?? null;
}


function document_UploadFile($image,$name,$size){

    global $contact_img_path;

    $verzeichnis = "../../data/documents/";

    $upload_folder = $verzeichnis; //Das Upload-Verzeichnis
    $filename = pathinfo($name, PATHINFO_FILENAME);
    $extension = strtolower(pathinfo($name,PATHINFO_EXTENSION));

/*
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
*/
//Überprüfung dass das Bild keine Fehler enthält


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
    //echo 'Bild erfolgreich hochgeladen: <a href="'.$new_path.'">'.$new_path.'</a>';

   // return 0;

}

function document_deleteFile($file){
    $verzeichnis = "../../data/documents/";
    unlink($verzeichnis.$file);

}