create table document
(
    id          int auto_increment,
    name        VARCHAR(100) null,
    title       VARCHAR(100) null,
    description VARCHAR(100) null,
    uri_file    VARCHAR(100) null,
    version     int          null,
    constraint document_pk
        primary key (id)
);


