DROP TABLE footprint;

CREATE TABLE footprint (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user VARCHAR(255) NOT NULL,
    footprint VARCHAR(255),
    country VARCHAR(255),
    province VARCHAR(255),
    latitude DECIMAL(10,2),
    longitude DECIMAL(10,2),
    _time VARCHAR(255),
    description TEXT
) DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
