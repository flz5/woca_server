# Modul Sitzung



## Gültigkeit prüfen

```
account_check_session.php
```

**Parameter:**
'session': ID der aktuellen Sitzung

**Rückgabe:**

| Status                        | Beschreibung                        |
| ----------------------------- | ----------------------------------- |
| APIState::OK                  | Sitzung ist gültig                  |
| APIState::Error_LoginRequired | sitzung nicht gültig (abgelaufen)   |
| APIState::Error_InvalidData:  | Die übergebenen Daten sind ungültig |

## Anmelden

```
account_login.php
```

Parameter:

'username': Benutzername
'password': Passwort (im Klartext)

**Rückgabe:**

|                               |                                     |
| ----------------------------- | ----------------------------------- |
| APIState::OK:                 | Sitzung ist gültig                  |
| APIState::Error_LoginInvalid: | Anmeldung fehlgschlagen             |
| APIState::Error_InvalidData:  | Die übergebenen Daten sind ungültig |

Data: enthält die Sitzungs-ID
