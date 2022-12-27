create table training
(
    id             int auto_increment
        primary key,
    name           varchar(100)  null,
    description    varchar(100)  null,
    day            int           null,
    start_hour     int           null,
    start_minute   int           null,
    end_hour       int           null,
    end_minute     int           null,
    color          varchar(20)   null,
    location       int default 0 null,
    training_group varchar(50)   null,
    slots          int           null
);

