create table contact
(
    id        int          not null
        primary key,
    title     varchar(100) null,
    name      varchar(100) null,
    telephone varchar(30)  null,
    mobile    varchar(30)  null,
    email     varchar(50)  null,
    img       varchar(100) null,
    version   int          null
);

