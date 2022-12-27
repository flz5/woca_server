# Modul Nachrichten

## Allgemein

## Beitreten

```
message_join.php
```

Parameter:

```
session
```

```
channel
```

```
type
```

```
device_id
```



Rückgabe:

```
APIState::OK;
```

```
APIState::Error_NoPermission;
```

```
APIState::Error_LoginRequired;
```

```
APIState::Error_InvalidData;
```



## Gerät aktiv halten

```
message_keep_active.php
```

Param:

Session,type,device_id



APIState::Error_InvalidData;

APIState::OK;



## Alle Kanäle verlassen

```

message_leave_all.php
```

Params: session

APIState::OK;

APIState::Error_InvalidData;

## Bestimmten Kanal verlassen

```
message_leave_id.php
```

## Liste alle Geräte/Abos

```
message_list_devices.php
```

## Liste alle Kanäle denen beigereten werden kann

```
message_list_joinable.php
```

## Liste alle Kanäle denen nachrichten gesendet werden kann

```
message_list_writable.php
```

## Nachricht senden

```
message_send.php
```

