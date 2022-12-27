create table message_member
(
    id          int auto_increment,
    channel_id  int          null,
    user_id     int          null,
    device_type int          null,
    device_id   varchar(100) null,
    last_time int null,
    constraint message_member_pk
        primary key (id)
);

create unique index message_member_id_uindex
    on message_member (id);

