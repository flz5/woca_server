create table message
(
    id           int auto_increment,
    msg_text     varchar(300) null,
    msg_title varchar(300) null,
    msg_author   int          null,
    msg_time     int          null,
    msg_receiver int          null,
    constraint message_pk
        primary key (id)
);

