CREATE TABLE MotionPicture(
    id CHAR(20),
    name CHAR(30),
    rating FLOAT,
    production CHAR(30),
    budget INT,
    PRIMARY KEY (id)
);

CREATE TABLE Genre(
    mpid CHAR(20),
    genre_name CHAR(30),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id)
);

CREATE TABLE Location(
    zip CHAR(10),
    city CHAR(20),
    country CHAR(20),
    mpid CHAR(20) NOT NULL,
    PRIMARY KEY(zip, mpid),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id) ON DELETE CASCADE
);

CREATE TABLE Movie(
    mpid CHAR(20) NOT NULL,
    boxoffice_collection INT,
    PRIMARY KEY(mpid),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id)
);

CREATE TABLE Series(
    mpid CHAR(20) NOT NULL,
    season_count INT,
    PRIMARY KEY(mpid),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id)
);

CREATE TABLE User(
    email CHAR(30),
    name CHAR(20),
    age INT,
    PRIMARY KEY(email)
);

CREATE TABLE Likes(
    uemail CHAR(30),
    mpid CHAR(20),
    PRIMARY KEY(uemail, mpid),
    FOREIGN KEY (uemail) REFERENCES User(email),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id)
);

CREATE TABLE People(
    id CHAR(20),
    name CHAR(20),
    nationality CHAR(20),
    DOB DATE,
    gender CHAR(8),
    PRIMARY KEY(id)
);

CREATE TABLE Role(
    mpid CHAR(20),
    pid CHAR(20),
    role_name CHAR(30),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
    FOREIGN KEY (pid) REFERENCES People(id)
);

CREATE TABLE Award(
    mpid CHAR(20),
    pid CHAR(20),
    award_name CHAR(30),
    award_year YEAR,
    PRIMARY KEY(mpid, pid, award_name, award_year),
    FOREIGN KEY (mpid) REFERENCES MotionPicture(id),
    FOREIGN KEY (pid) REFERENCES People(id)
);