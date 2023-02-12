create table event_slot
(
    id       int auto_increment,
    event_id int null,
    user_id  int null,
    time     int null,
    constraint event_slot_pk
        primary key (id)
);


