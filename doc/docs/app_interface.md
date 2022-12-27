# App Interface





Zugriff:

root/app_interface/

Passwortschutz:

HTTP Auth Basic

Einstellung in der Datei root/app_interface/.htaccess

--> Verknüpfung zu HTPasswd muss als absoluter Pfad in die Datei eingetragen werden

Passwort in der Datei root/pw/.htpasswd





## Allgemeine Antwort

| Parameter | Beschreibung         | Typ       |
| --------- | -------------------- | --------- |
| State     | Zustand              | API_STATE |
| Msg       | (Optional) Nachricht | *         |
| Data      | (Optional) Daten     | *         |

*) Je nach Modul unterschiedlich, nur optional verwendet

| Zustand | Wert | Beschreibung |
| ------- | ---- | ------------ |
| ***     | 0    | ***          |
| ***     | 1    | ***          |
| ***     | 2    | ***          |
| ***     | 3    | ***          |
| ***     | 4    | ***          |
|         |      |              |
|         |      |              |

