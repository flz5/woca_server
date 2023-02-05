create table slot_training
(
    id       int auto_increment,
    event_id int null,
    user_id  int null,
    time     int null,
    constraint slot_training_pk
        primary key (id)
);


