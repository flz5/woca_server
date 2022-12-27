create table track_waypoint
(
    id         int auto_increment,
    name       VARCHAR(100) null,
    distance   float        null,
    startpoint int          null,
    constraint track_waypoint_pk
        primary key (id)
);

create unique index track_waypoint_id_uindex
    on track_waypoint (id);

