create table training_group
(
    id          int auto_increment,
    name        varchar(100) null,
    description varchar(100) null,
    color       varchar(20)  null,
    constraint event_slot_pk
        primary key (id)
);
