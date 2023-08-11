drop table series;
drop table header;
drop table music;
drop table login;

create table login (
    userId int not null AUTO_INCREMENT,
    username varchar(50) not null,
    password varchar(50) not null,
    PRIMARY KEY(userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

create table header (
    userId int not null,
    img1 varchar(50),
    img2 varchar(50),
    img3 varchar(50),
    statusMsg varchar(45),
    emoji varchar(100),
    PRIMARY KEY(userId),
    FOREIGN KEY(userId) REFERENCES login(userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

create table music (
    userId int not null,
    id int not null AUTO_INCREMENT,
    title varchar(50) not null,
    artist varchar(50) not null,
    audio varchar(50) not null,
    poster varchar(50) not null,
    PRIMARY KEY(id),
    FOREIGN KEY(userId) REFERENCES login(userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

create table series (
    userId int not null,
    id int not null AUTO_INCREMENT,
    title varchar(50) not null,
    yearReleased int not null,
    type varchar(10) not null,
    country varchar(20) not null, 
    notes varchar(100) null,
    poster varchar(50) not null,
    PRIMARY KEY(id),
    FOREIGN KEY(userId) REFERENCES login(userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

select * from login;
select * from header;
select * from series;
select * from music;