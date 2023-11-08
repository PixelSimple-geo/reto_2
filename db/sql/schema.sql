SET time_zone = 'Europe/Madrid';

DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS advert_category;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS advert_contacts;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS business_contacts;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS adverts;
DROP TABLE IF EXISTS businesses;
DROP TABLE IF EXISTS accounts;

CREATE TABLE accounts (
    account_id INT(5) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    last_login TIMESTAMP NOT NULL,
    verified TINYINT(1) NOT NULL,
    PRIMARY KEY (account_id),
    CONSTRAINT acc_ver_ck CHECK (verified = 0 OR verified = 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE cities (
    city_id INT(3) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (city_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE businesses (
    business_id INT(5) NOT NULL AUTO_INCREMENT,
    account_id INT(5) NOT NULL,
    name VARCHAR(100) NOT NULL /*UNIQUE*/,
    description VARCHAR(500),
    PRIMARY KEY (business_id),
    FOREIGN KEY (account_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE adverts (
    advert_id INT(10) NOT NULL AUTO_INCREMENT,
    business_id INT(10) NOT NULL,
    title VARCHAR(70) NOT NULL,
    description VARCHAR(500) NOT NULL,
    cover_img VARCHAR(255),
    active TINYINT(1) NOT NULL,
    creation_date TIMESTAMP NULL,
    modified_date TIMESTAMP NOT NULL,
    PRIMARY KEY (advert_id),
    FOREIGN KEY (business_id) REFERENCES businesses (business_id),
    CONSTRAINT adv_act_ck CHECK ( active = 0 OR active = 1 )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE addresses (
    advert_id INT(10) NOT NULL,
    city_id INT(3) NOT NULL,
    address VARCHAR(100) NOT NULL,
    postal_code INT(6),
    PRIMARY KEY (advert_id),
    FOREIGN KEY (advert_id) REFERENCES adverts (advert_id),
    FOREIGN KEY (city_id) REFERENCES cities (city_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE business_contacts (
    business_contact_id INT(10) NOT NULL AUTO_INCREMENT,
    business_id INT(5) NOT NULL,
    type VARCHAR(100) NOT NULL,
    value VARCHAR(100) NOT NULL,
    PRIMARY KEY (business_contact_id),
    FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE categories (
    category_id INT(5) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE advert_category (
    category_id INT(10) NOT NULL,
    advert_id INT(10) NOT NULL,
    PRIMARY KEY (category_id, advert_id),
    FOREIGN KEY (advert_id) REFERENCES adverts (advert_id),
    FOREIGN KEY (category_id) REFERENCES categories (category_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE images (
    image_id INT(10) NOT NULL AUTO_INCREMENT,
    advert_id INT(10) NOT NULL,
    url VARCHAR(255) NOT NULL,
    PRIMARY KEY (image_id),
    FOREIGN KEY (advert_id) REFERENCES adverts (advert_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE advert_contacts (
    contact_id INT(10) NOT NULL AUTO_INCREMENT,
    advert_id INT(10) NOT NULL,
    type VARCHAR(100) NOT NULL,
    value VARCHAR(100) NOT NULL,
    PRIMARY KEY (contact_id),
    FOREIGN KEY (advert_id) REFERENCES adverts (advert_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE reviews (
    account_id INT(5) NOT NULL,
    advert_id INT(10) NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(500) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    rating INT(3) NOT NULL,
    PRIMARY KEY (account_id, advert_id),
    FOREIGN KEY (account_id) REFERENCES accounts (account_id),
    FOREIGN KEY (advert_id) REFERENCES adverts (advert_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
