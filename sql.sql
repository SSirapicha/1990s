drop table series;
drop table header;

create table series (
    id int not null AUTO_INCREMENT,
    title varchar(50) not null,
    yearReleased int not null,
    type varchar(10) not null,
    country varchar(20) not null, 
    notes varchar(100) null,
    poster varchar(50) not null,
    primary key(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

create table header (
    img1 varchar(50),
    img2 varchar(50),
    img3 varchar(50),
    statusMsg varchar(45),
    emoji varchar(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

insert into header (img1, img2, img3, statusMsg, emoji) values ('header1.jpg','header2.jpg','header3.png', '123','123');

select * from header;
select * from series;