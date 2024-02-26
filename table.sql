CREATE TABLE Motion_picture(
    id CHAR(20),
    name CHAR(30),
    rating FLOAT,
    production CHAR(30),
    budget INT,
    PRIMARY KEY (mid)
);

CREATE TABLE HAS_Location(
    id CHAR(10),
    city CHAR(20),
    country CHAR(20),
    mid CHAR(20) NOT NULL,
    PRIMARY KEY(id, mid),
    FOREIGN KEY (mid) REFERENCES Motion_picture, ON DELETE CASCADE
);

CREATE TABLE 