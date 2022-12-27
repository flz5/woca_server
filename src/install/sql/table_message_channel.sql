create table message_channel
(
    id          int auto_increment,
    name        varchar(100) null,
    description varchar(100) null,
    public      bool         null,
    password    varchar(100) null,
    constraint message_channel_pk
        primary key (id)
);

create unique index message_channel_id_uindex
    on message_channel (id);

