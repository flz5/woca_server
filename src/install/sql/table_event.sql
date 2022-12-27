create table event
(
    id             int auto_increment
        primary key,
    name           varchar(100)  null,
    description    varchar(100)  null,
    day            int           null,
    time_start     int           null,
    time_end       int           null,
    color          varchar(20)   null,
    location       int default 0 null,
    training_group varchar(50)   null,
    slots          int           null
);

