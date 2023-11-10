DROP TABLE IF EXISTS reviews_likes;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS advert_categories;
DROP TABLE IF EXISTS adverts_characteristics;
DROP TABLE IF EXISTS commentaries_likes;
DROP TABLE IF EXISTS commentaries;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS articles_categories_mapping;
DROP TABLE IF EXISTS authorities_granted;
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS authorities;
DROP TABLE IF EXISTS businesses_advert_categories;
DROP TABLE IF EXISTS advert_category;
DROP TABLE IF EXISTS advert_contacts;
DROP TABLE IF EXISTS adverts;
DROP TABLE IF EXISTS business_contacts;
DROP TABLE IF EXISTS businesses_categories_mapping;
DROP TABLE IF EXISTS businesses_categories;
DROP TABLE IF EXISTS businesses;
DROP TABLE IF EXISTS accounts;
DROP TABLE IF EXISTS article_categories;
DROP TABLE IF EXISTS cities;

CREATE TABLE authorities (
    authority_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(30) NOT NULL,
    UNIQUE INDEX (role)
) ENGINE=InnoDB;

CREATE TABLE accounts (
    account_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    last_login TIMESTAMP NOT NULL,
    verified TINYINT NOT NULL,
    active TINYINT NOT NULL,
    UNIQUE INDEX (username)
) ENGINE=InnoDB;

CREATE TABLE businesses (
    business_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500),
    CONSTRAINT bus_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB;

CREATE TABLE businesses_categories (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    UNIQUE INDEX (name)
) ENGINE=InnoDB;

CREATE TABLE cities (
    city_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    UNIQUE INDEX (name)
) ENGINE=InnoDB;

CREATE TABLE article_categories (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    UNIQUE INDEX (name)
) ENGINE=InnoDB;

CREATE TABLE businesses_categories_mapping (
    category_id INT NOT NULL,
    business_id INT NOT NULL,
    CONSTRAINT bcm_cat_bus_pk PRIMARY KEY (category_id, business_id),
    CONSTRAINT bcm_cat_fk FOREIGN KEY (category_id) REFERENCES businesses_categories (category_id),
    CONSTRAINT bcm_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB;

CREATE TABLE business_contacts (
    contact_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    business_id INT NOT NULL,
    type VARCHAR(100) NOT NULL,
    value VARCHAR(255) NOT NULL,
    CONSTRAINT buc_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB;

CREATE TABLE businesses_advert_categories (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    business_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    CONSTRAINT bac_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB;

CREATE TABLE authorities_granted (
    authority_id INT NOT NULL,
    account_id INT NOT NULL,
    CONSTRAINT aug_aut_acc_pk PRIMARY KEY (authority_id, account_id),
    CONSTRAINT aug_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id),
    CONSTRAINT aug_aut_fk FOREIGN KEY (authority_id) REFERENCES authorities (authority_id)
) ENGINE=InnoDB;

CREATE TABLE articles (
    article_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY PRIMARY KEY,
    account_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description LONGTEXT NOT NULL,
    created_date TIMESTAMP NOT NULL,
    modified_date TIMESTAMP NULL,
    CONSTRAINT art_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB;

CREATE TABLE articles_categories_mapping (
    article_id INT NOT NULL,
    category_id INT NOT NULL,
    CONSTRAINT acm_art_cat_pk PRIMARY KEY (article_id, category_id),
    CONSTRAINT acm_art_fk FOREIGN KEY (article_id) REFERENCES articles (article_id),
    CONSTRAINT acm_cat_fk FOREIGN KEY (category_id) REFERENCES article_categories (category_id)
) ENGINE=InnoDB;

CREATE TABLE addresses (
    address_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    business_id INT NOT NULL,
    city_id INT NOT NULL,
    address VARCHAR(100) NOT NULL,
    postal_code INT NOT NULL,
    CONSTRAINT add_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id),
    CONSTRAINT add_cit_fk FOREIGN KEY (city_id) REFERENCES cities (city_id)
) ENGINE=InnoDB;

CREATE TABLE commentaries (
    commentary_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    commentator_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(500) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    modified_date TIMESTAMP NULL,
    CONSTRAINT com_art_fk FOREIGN KEY (article_id) REFERENCES articles (article_id),
    CONSTRAINT com_com_fk FOREIGN KEY (commentator_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB;

CREATE TABLE commentaries_likes (
    liker_id INT NOT NULL,
    commentary_id INT NOT NULL,
    is_liked TINYINT NOT NULL,
    CONSTRAINT col_lik_com_pk PRIMARY KEY (liker_id, commentary_id),
    CONSTRAINT col_comm_fk FOREIGN KEY (commentary_id) REFERENCES commentaries (commentary_id),
    CONSTRAINT col_lik_fk FOREIGN KEY (liker_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB;

CREATE TABLE adverts (
    advert_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    business_id INT NOT NULL,
    title VARCHAR(70) NOT NULL,
    description VARCHAR(500) NOT NULL,
    cover_img VARCHAR(255),
    active TINYINT NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    modified_date TIMESTAMP NULL,
    CONSTRAINT adv_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB;

CREATE TABLE adverts_characteristics (
    characteristic_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    advert_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    value VARCHAR(100) NOT NULL,
    CONSTRAINT adc_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id)
) ENGINE=InnoDB;

CREATE TABLE advert_categories (
    advert_id INT NOT NULL,
    category_id INT NOT NULL,
    CONSTRAINT adc_adv_cat_pk PRIMARY KEY (advert_id, category_id),
    CONSTRAINT adca_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id),
    CONSTRAINT adc_cat_fk FOREIGN KEY (category_id) REFERENCES businesses_advert_categories (category_id)
) ENGINE=InnoDB;

CREATE TABLE images (
    image_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    advert_id INT NOT NULL,
    url VARCHAR(255) NOT NULL,
    CONSTRAINT ima_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id)
) ENGINE=InnoDB;

CREATE TABLE reviews (
    review_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    business_id INT NOT NULL,
    title VARCHAR(70) NOT NULL,
    description VARCHAR(500) NOT NULL,
    creation_date TIMESTAMP NOT NULL,
    modified_date TIMESTAMP NULL,
    rating INT NOT NULL,
    CONSTRAINT rev_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id),
    CONSTRAINT rev_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id)
) ENGINE=InnoDB;

CREATE TABLE reviews_likes (
    commentator_id INT NOT NULL,
    review_id INT NOT NULL,
    is_liked TINYINT NOT NULL,
    CONSTRAINT rel_comm_rev_pk PRIMARY KEY (commentator_id, review_id),
    CONSTRAINT rel_rev_fk FOREIGN KEY (review_id) REFERENCES reviews (review_id),
    CONSTRAINT rel_comm_fk FOREIGN KEY (commentator_id) REFERENCES accounts (account_id)
) ENGINE=InnoDB;