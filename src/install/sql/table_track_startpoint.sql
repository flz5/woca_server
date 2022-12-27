create table track_startpoint
(
    id      int auto_increment,
    name    VARCHAR(100) null,
    version int          null,
    constraint track_startpoint_pk
        primary key (id)
);

create unique index track_startpoint_id_uindex
    on track_startpoint (id);

