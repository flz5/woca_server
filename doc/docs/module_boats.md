# Modul Boote



## Typen

```
public string $name; //NAME
public int $id; //id
```

```
boat_types.php
```

Parameter: keine

Liefert die Liste der Bootstypen zurück



## Tags

public string $id;
    public string $name;       //Name
    public string $name_short; //Short Name
    public string $color;      //Background color
    public string $display;     //Anzeigen



```
boat_tags.php
```

Parameter: keine

Liefert die Liste der Bootstags zurück

## Bootshaus

| Feld | Typ      | Beschreibung |
| ---- | -------- | ------------ |
| ID   | Anwender |              |
| Name | Anwender |              |



```
boat_house.php
```

Parameter: keine

Liefert die Liste der Bootshäuser zurück



Sitzplätze

| Feld | Typ      | Beschreibung |
| ---- | -------- | ------------ |
| ID   | Anwender |              |
| Name | Anwender |              |



```
boat_house.php
```

Parameter: keine

Liefert die Liste der Bootshäuser zurück



Gewicht



| Feld | Typ      | Beschreibung |
| ---- | -------- | ------------ |
| ID   | Anwender |              |
| Name | Anwender |              |



```
boat_weights.php
```



id: Gewichtswert (int)

name: Gewichtswert (Anzeige)





## Bootsabfrage

| Feld   | Typ     | Beschreibung |
| ------ | ------- | ------------ |
| id     |         |              |
| name   |         |              |
| seats  |         |              |
| type   | Verweis |              |
| place  |         |              |
| weight |         |              |
| tag1   | Verweis |              |
| tag2   | Verweis |              |
| tag3   | Verweis |              |
| tag4   | Verweis |              |
| house  | Verweis |              |



```
boat.php
```

Parameter:

'tag'

'house'

'type'

'seats_min'

'seats_max'

'weight'

Über GET

Rückgabe: Liste aller passenden Boots, falls keines passt mit Dummyeintrag (nicht gefunden)



## Hinweise



