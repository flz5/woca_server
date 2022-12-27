create table account_registration_token
(
    id          int auto_increment,
    auth_key    varchar(50) null,
    user_group  varchar(50) null,
    mail        varchar(50) null,
    valid_until int         null,
    valid_count int         null,
    constraint account_registration_token_pk
        primary key (id)
);

