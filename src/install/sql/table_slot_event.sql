create table slot_event
(
    id       int auto_increment,
    event_id int null,
    user_id  int null,
    time     int null,
    constraint slot_event_pk
        primary key (id)
);

create unique index slot_event_id_uindex
    on slot_event (id);

