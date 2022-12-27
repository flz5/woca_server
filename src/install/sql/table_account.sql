create table account
(
    id             int auto_increment,
    login_username varchar(50)  null,
    login_password varchar(500) null,
    email          varchar(50)  null,
    login_state          int          null,
    login_time     int          null,
    login_tries    int          null,
    user_group     varchar(50)  null,
    user_name      varchar(50)  null,
    createdBy      int          null,
    constraint account_id_uindex
        unique (id)
);