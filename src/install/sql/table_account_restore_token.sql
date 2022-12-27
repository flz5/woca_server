create table account_restore_token
(
    id          int auto_increment,
    auth_key    varchar(50) not null,
    user_id     int         null,
    valid_until int         null,
    type        int         null,
    constraint account_restore_token_pk
        primary key (id)
);