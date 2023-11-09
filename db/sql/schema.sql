DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS commentaries;
DROP TABLE IF EXISTS businesses_categories_mapping;
DROP TABLE IF EXISTS businesses_categories;
DROP TABLE IF EXISTS business_contacts;
DROP TABLE IF EXISTS authorities_granted;
DROP TABLE IF EXISTS authorities;
DROP TABLE IF EXISTS articles_categories_mapping;
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS article_categories;
DROP TABLE IF EXISTS adverts_characteristics;
DROP TABLE IF EXISTS advert_categories;
DROP TABLE IF EXISTS adverts;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS businesses_advert_categories;
DROP TABLE IF EXISTS businesses;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS cities;

CREATE TABLE accounts (
    account_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(60) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    last_login TIMESTAMP NOT NULL,
    verified TINYINT NOT NULL,
    PRIMARY KEY (account_id),
    UNIQUE INDEX (username),
    UNIQUE INDEX (email)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE businesses (
    business_id INT NOT NULL AUTO_INCREMENT,
    account_id INT NOT NULL,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500),
    PRIMARY KEY (business_id),
    CONSTRAINT bus_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE cities (
    city_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (city_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE addresses (
    address_id INT NOT NULL AUTO_INCREMENT,
    business_id INT NOT NULL,
    city_id INT NOT NULL,
    address VARCHAR(100) NOT NULL,
    postal_code INT NOT NULL,
    PRIMARY KEY (address_id),
    CONSTRAINT add_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id),
    CONSTRAINT add_cit_fk FOREIGN KEY (city_id) REFERENCES cities (city_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE adverts (
    advert_id INT NOT NULL AUTO_INCREMENT,
    business_id INT NOT NULL,
    title VARCHAR(70) NOT NULL,
    description VARCHAR(500) NOT NULL,
    cover_img VARCHAR(255),
    active TINYINT NOT NULL,
    creation_date TIMESTAMP NULL,
    modified_date TIMESTAMP NOT NULL,
    PRIMARY KEY (advert_id),
    CONSTRAINT adv_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE businesses_advert_categories (
    category_id INT NOT NULL AUTO_INCREMENT,
    business_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (category_id),
    CONSTRAINT bus_adv_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE advert_categories (
    advert_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (advert_id, category_id),
    CONSTRAINT adv_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id),
    CONSTRAINT adv_cat_fk FOREIGN KEY (category_id) REFERENCES businesses_advert_categories (category_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE adverts_characteristics (
    characteristic_id INT NOT NULL AUTO_INCREMENT,
    advert_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    value VARCHAR(100) NOT NULL,
    PRIMARY KEY (characteristic_id),
    CONSTRAINT adv_cha_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE article_categories (
    category_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (category_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE articles (
    article_id INT NOT NULL AUTO_INCREMENT,
    account_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description LONGTEXT NOT NULL,
    created_date TIMESTAMP NOT NULL,
    modified_date TIMESTAMP NULL,
    PRIMARY KEY (article_id),
    CONSTRAINT art_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE articles_categories_mapping (
    article_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (article_id, category_id),
    CONSTRAINT art_cat_fk FOREIGN KEY (article_id) REFERENCES articles (article_id),
    CONSTRAINT art_cat_fk2 FOREIGN KEY (category_id) REFERENCES article_categories (category_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE authorities (
    authority_id INT NOT NULL AUTO_INCREMENT,
    role VARCHAR(30) NOT NULL UNIQUE,
    PRIMARY KEY (authority_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE authorities_granted (
    authority_id INT NOT NULL,
    account_id INT NOT NULL,
    PRIMARY KEY (authority_id, account_id),
    CONSTRAINT aut_acc_fk FOREIGN KEY (authority_id) REFERENCES authorities (authority_id),
    CONSTRAINT aut_acc_fk2 FOREIGN KEY (account_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE business_contacts (
    contact_id INT NOT NULL AUTO_INCREMENT,
    business_id INT NOT NULL,
    type VARCHAR(100) NOT NULL,
    value VARCHAR(255) NOT NULL,
    PRIMARY KEY (contact_id),
    CONSTRAINT bus_con_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE businesses_categories (
    category_id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY (category_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE businesses_categories_mapping (
    category_id INT NOT NULL,
    business_id INT NOT NULL,
    PRIMARY KEY (category_id, business_id),
    CONSTRAINT bus_cat_fk FOREIGN KEY (category_id) REFERENCES businesses_categories (category_id),
    CONSTRAINT bus_cat_fk2 FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE commentaries (
    article_id INT NOT NULL,
    account_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(500) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    modified_date TIMESTAMP NULL,
    likes INT NOT NULL,
    dislikes INT,
    PRIMARY KEY (article_id, account_id),
    CONSTRAINT com_art_fk FOREIGN KEY (article_id) REFERENCES articles (article_id),
    CONSTRAINT com_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE images (
    image_id INT NOT NULL AUTO_INCREMENT,
    advert_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    PRIMARY KEY (image_id),
    CONSTRAINT ima_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE reviews (
    account_id INT NOT NULL,
    business_id INT NOT NULL,
    title VARCHAR(70) NOT NULL,
    description VARCHAR(500) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    modified_date TIMESTAMP NOT NULL,
    rating INT NOT NULL,
    PRIMARY KEY (account_id, business_id),
    CONSTRAINT rev_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id),
    CONSTRAINT rev_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB CHARSET=utf8;
