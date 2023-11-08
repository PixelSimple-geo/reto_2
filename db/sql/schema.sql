SET time_zone = 'Europe/Madrid';

DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS advert;
DROP TABLE IF EXISTS advert_contacts;
DROP TABLE IF EXISTS business_contacts;
DROP TABLE IF EXISTS businesses;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS reviews;

CREATE TABLE Account (
    account_id INT(5) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(60) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    last_login TIMESTAMP NOT NULL,
    verified TINYINT(1) NOT NULL,
    PRIMARY KEY (account_id),
    UNIQUE (username),
    UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE addresses (
    advert_id INT(10) NOT NULL,
    city_id INT(10) NOT NULL,
    address VARCHAR(100) NOT NULL,
    postal_code INT(10),
    PRIMARY KEY (advert_id),
    FOREIGN KEY (advert_id) REFERENCES advert (advert_id),
    FOREIGN KEY (city_id) REFERENCES cities (city_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE advert (
    advert_id INT(10) NOT NULL AUTO_INCREMENT,
    business_id INT(10) NOT NULL,
    title VARCHAR(70) NOT NULL,
    description VARCHAR(500) NOT NULL,
    cover_img VARCHAR(255),
    active TINYINT(1) NOT NULL,
    creation_date TIMESTAMP NULL,
    modified_date TIMESTAMP NOT NULL,
    PRIMARY KEY (advert_id),
    FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE advert_contacts (
    contact_id INT(10) NOT NULL AUTO_INCREMENT,
    advert_id INT(10) NOT NULL,
    type VARCHAR(100) NOT NULL,
    value VARCHAR(100) NOT NULL,
    PRIMARY KEY (contact_id),
    FOREIGN KEY (advert_id) REFERENCES advert (advert_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE business_contacts (
    business_contact_id INT(10) NOT NULL AUTO_INCREMENT,
    business_id INT(10) NOT NULL,
    type VARCHAR(100) NOT NULL,
    value VARCHAR(100) NOT NULL,
    PRIMARY KEY (business_contact_id),
    FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE businesses (
    business_id INT(10) NOT NULL AUTO_INCREMENT,
    account_id INT(5) NOT NULL,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500),
    PRIMARY KEY (business_id),
    FOREIGN KEY (account_id) REFERENCES Account (account_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE category (
    category_id INT(10) NOT NULL AUTO_INCREMENT,
    advert_id INT(10) NOT NULL,
    name VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY (category_id),
    FOREIGN KEY (advert_id) REFERENCES advert (advert_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE cities (
    city_id INT(10) NOT NULL AUTO_INCREMENT,
    name INT(10) NOT NULL,
    PRIMARY KEY (city_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE images (
    image_id INT(10) NOT NULL AUTO_INCREMENT,
    advert_id INT(10) NOT NULL,
    url VARCHAR(255) NOT NULL,
    PRIMARY KEY (image_id),
    FOREIGN KEY (advert_id) REFERENCES advert (advert_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE reviews (
    account_id INT(5) NOT NULL,
    advert_id INT(10) NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(500) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    rating INT(3) NOT NULL,
    PRIMARY KEY (account_id, advert_id),
    FOREIGN KEY (account_id) REFERENCES Account (account_id),
    FOREIGN KEY (advert_id) REFERENCES advert (advert_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
