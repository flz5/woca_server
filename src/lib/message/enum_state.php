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

enum APIState : int
{
    case Error_Unknown = 0;        //Nicht freigeschaltet
    case Error_LoginRequired = 1;       //Nicht angemeldet
    case Error_NoPermission = 2;     //Keine Berechtigung
    case Error_InvalidData = 3;     //Die übergebenen Daten sind nicht korrekt oder vollständig

    case Error_LoginInvalid = 4;    //Logindaten ungültig

    case OK = 100;                  //Erfolgreich ausgeführt
}