create table location
(
    id                  int auto_increment
        primary key,
    type                int          not null,
    name                varchar(40)  null,
    description         varchar(200) null,
    address_street      varchar(40)  null,
    address_city        varchar(40)  null,
    address_postal_code varchar(10)  null,
    address_country     varchar(30)  null,
    geo_lat             varchar(40)  null,
    geo_long            varchar(40)  null
);