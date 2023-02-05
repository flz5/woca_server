create table message_permission
(
    id         int auto_increment,
    channel_id int null,
    user_id    int null,
    perm_write int null,
    perm_join  int null,
    constraint message_permission_pk
        primary key (id)
);


