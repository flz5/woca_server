# Modul Accounts

!!! warning "Entwurf"
	Der Abschnitt ist noch nicht vollständig

## Hinweise

## Daten

| Feld           | Kategorie | Beschreibung |
| -------------- | --------- | ------------ |
| ID             | System    | intern       |
| login_username | Benutzer  |              |
| login_password | Benutzer  |              |
| email          | Benutzer  |              |
| login_time     | System    | Zeit         |
| login_tries    | System    | Zähler       |
| user_group     | Benutzer  |              |
| user_name      | Benutzer  |              |
| createdBy      | System    |              |
| state          | System    | Zustand      |



- Ersteller des Accounts wird gespeichert


## Sichere Passwörter

Es ist wichtig sichere Passwörter zu vergeben.

## Berechtigungen

Die Berechtigungen werden über die Gruppen eingestellt. Siehe Modul Berechtigungen.

## Account Zustand

TODO
Bei gesperrtem Zustadn ist keine Anmeldung möglich.

## Funktionen

### Account erstellen / bearbeiten

Passort wird nicht geändert. Beim Erstellen wird ein zufälliges Passwort generiert. Dies wird einmalig angezeigt. Ein späteres Auslesen ist nicht mehr möglich.

Bei Änderungen wird das Passwort beibehalten.

### Passwört ändern

Ändert nur das Passwort

## Sicherheitssystem

!!! note "Hinweis"
	Einstellungen können nicht über das Web Interface vorgenommen werden

### Anmeldezähler

Bei jeder nicht erfolgreichen Anmeldung wird ein interner Zähler hochgezählt. Überschreitet dieser den eingstellten Wert, werden alle weiteren Anmeldeversuche als fehlerhaft zurückgegeben. Dies trifft auch bei korrektem Bentzername und Passwort zu.
Nach der einstegellten Wartezeit wird der Zähler zurückgesetzt. Anmeldeversuche in dieser Zeit führen zum neubeginn der Wartezeit.

### IP Addressen

Für die IP Addressen findet eine seperate Zählung statt. Bei Überschreiten werden alle Anmeldeversuche von der Addresse abgelehnt.

## 