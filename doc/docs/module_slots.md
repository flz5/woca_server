# Modul Teilnehmer

Das Modul Teilnehmer stellt Funktionen bereit um Teilnehmerlisten von Veranstaltungen zu erfassen. Es eignet sich auch dazu die Teilnehmeranzahl zu begrenzen.

Neue Einträge sind bis zum Start der Veranstaltung möglich.
Bei regelmäßigen Veranstaltungen (wöchentlich) wird nach dem Ende der Veranstatlung eine neue Liste begonnen.

Die Teilnehmerliste kann über das Admin-Panel erstellt werden.

## API Interface

### Modus

| Modus    | Wert |
| -------- | ---- |
| Training | 0    |
| Event    | 1    |

### Liste

| Parameter | Beschreibung | Typ  |
| --------- | ------------ | ---- |
|           |              |      |
|           |              |      |
|           |              |      |
|           |              |      |






### Liste eigener Teilnahmen

```
slot_list.php
```
Parameter: keine

### Eintrag hinzufügen

```
slot_register.php
```
Parameter: 
Event-ID
Session-ID

### Eintrag löschen

```
slot_register.php
```
Parameter: 
Eintrag-ID
Session-ID

Es kann nur ein eigener Eintrag gelöscht werden. Die Veranstaltuing darf noch nicht stattgefunden haben, anderenfalls wird das LÖschen gesperrt.

### Anzahl Teilnehmer


```
slot_count.php
```
Parameter: 
Event-ID
Mode



