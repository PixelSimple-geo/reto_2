USE reto_2;

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
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE accounts (
                          account_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                          username VARCHAR(50) NOT NULL UNIQUE,
                          email VARCHAR(100) NOT NULL UNIQUE,
                          password VARCHAR(60) NOT NULL,
                          creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                          last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                          verified TINYINT DEFAULT 0 NOT NULL,
                          active TINYINT DEFAULT 1 NOT NULL,
                          UNIQUE INDEX (username)
) ENGINE=InnoDB;

CREATE TABLE businesses (
                            business_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            account_id INT NOT NULL,
                            name VARCHAR(100) NOT NULL UNIQUE,
                            description VARCHAR(1500),
                            cover_img varchar(255),
                            CONSTRAINT bus_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE businesses_categories (
                                       category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                       name VARCHAR(100) NOT NULL UNIQUE,
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
                                               CONSTRAINT bcm_cat_bus_pk PRIMARY KEY (business_id),
                                               CONSTRAINT bcm_cat_fk FOREIGN KEY (category_id) REFERENCES businesses_categories (category_id) ON DELETE CASCADE ,
                                               CONSTRAINT bcm_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE business_contacts (
                                   contact_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                   business_id INT NOT NULL,
                                   type VARCHAR(100) NOT NULL,
                                   value VARCHAR(255) NOT NULL,
                                   CONSTRAINT buc_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE businesses_advert_categories (
                                              category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                              business_id INT NOT NULL,
                                              name VARCHAR(100) NOT NULL,
                                              CONSTRAINT bac_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE authorities_granted (
                                     authority_id INT NOT NULL,
                                     account_id INT NOT NULL,
                                     CONSTRAINT aug_aut_acc_pk PRIMARY KEY (authority_id, account_id),
                                     CONSTRAINT aug_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id) ON DELETE CASCADE,
                                     CONSTRAINT aug_aut_fk FOREIGN KEY (authority_id) REFERENCES authorities (authority_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE articles (
                          article_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY PRIMARY KEY,
                          account_id INT NOT NULL,
                          title VARCHAR(100) NOT NULL,
                          description LONGTEXT NOT NULL,
                          created_date TIMESTAMP NOT NULL,
                          modified_date TIMESTAMP NULL,
                          CONSTRAINT art_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE articles_categories_mapping (
                                             article_id INT NOT NULL,
                                             category_id INT NOT NULL,
                                             CONSTRAINT acm_art_cat_pk PRIMARY KEY (article_id, category_id),
                                             CONSTRAINT acm_art_fk FOREIGN KEY (article_id) REFERENCES articles (article_id) ON DELETE CASCADE,
                                             CONSTRAINT acm_cat_fk FOREIGN KEY (category_id) REFERENCES article_categories (category_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE addresses (
                           address_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                           business_id INT NOT NULL,
                           address VARCHAR(100) NOT NULL,
                           postal_code INT NOT NULL,
                           CONSTRAINT add_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE commentaries (
                              commentary_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                              article_id INT NOT NULL,
                              commentator_id INT NOT NULL,
                              title VARCHAR(50) NOT NULL,
                              description VARCHAR(500) NOT NULL,
                              creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                              modified_date TIMESTAMP NULL,
                              CONSTRAINT com_art_fk FOREIGN KEY (article_id) REFERENCES articles (article_id) ON DELETE CASCADE,
                              CONSTRAINT com_com_fk FOREIGN KEY (commentator_id) REFERENCES accounts (account_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE commentaries_likes (
                                    liker_id INT NOT NULL,
                                    commentary_id INT NOT NULL,
                                    is_liked TINYINT NOT NULL,
                                    CONSTRAINT col_lik_com_pk PRIMARY KEY (liker_id, commentary_id),
                                    CONSTRAINT col_comm_fk FOREIGN KEY (commentary_id) REFERENCES commentaries (commentary_id) ON DELETE CASCADE,
                                    CONSTRAINT col_lik_fk FOREIGN KEY (liker_id) REFERENCES accounts (account_id) ON DELETE CASCADE
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
                         CONSTRAINT adv_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE adverts_characteristics (
                                         characteristic_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                         advert_id INT NOT NULL,
                                         type VARCHAR(50) NOT NULL,
                                         value VARCHAR(100) NOT NULL,
                                         CONSTRAINT adc_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE advert_categories (
                                   advert_id INT NOT NULL,
                                   category_id INT NOT NULL,
                                   CONSTRAINT adc_adv_cat_pk PRIMARY KEY (advert_id, category_id),
                                   CONSTRAINT adca_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id) ON DELETE CASCADE ,
                                   CONSTRAINT adc_cat_fk FOREIGN KEY (category_id) REFERENCES businesses_advert_categories (category_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE images (
                        image_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        advert_id INT NOT NULL,
                        url VARCHAR(255) NOT NULL,
                        CONSTRAINT ima_adv_fk FOREIGN KEY (advert_id) REFERENCES adverts (advert_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reviews (
                         review_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         account_id INT NOT NULL,
                         business_id INT NOT NULL,
                         title VARCHAR(70) NOT NULL,
                         description VARCHAR(500) NOT NULL,
                         creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                         modified_date TIMESTAMP NULL,
                         rating INT NOT NULL,
                         CONSTRAINT rev_acc_fk FOREIGN KEY (account_id) REFERENCES accounts (account_id) ON DELETE CASCADE,
                         CONSTRAINT rev_bus_fk FOREIGN KEY (business_id) REFERENCES businesses (business_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reviews_likes (
                               commentator_id INT NOT NULL,
                               review_id INT NOT NULL,
                               is_liked TINYINT NOT NULL,
                               CONSTRAINT rel_comm_rev_pk PRIMARY KEY (commentator_id, review_id),
                               CONSTRAINT rel_rev_fk FOREIGN KEY (review_id) REFERENCES reviews (review_id) ON DELETE CASCADE ,
                               CONSTRAINT rel_comm_fk FOREIGN KEY (commentator_id) REFERENCES accounts (account_id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO authorities (role) VALUES ('ADMIN');
INSERT INTO authorities (role) VALUES ('USER');

INSERT INTO accounts (username, email, password, creation_date, last_login, verified, active) VALUES
                                                                                                  ('user1', 'user1@example.com', '$2y$10$6jLrRrOZD8ryJlx905t/1uT8Yh1FfOdemHf3Ho02ZhLz0.xVKko6i', NOW(), NOW(), 1, 1),
                                                                                                  ('user2', 'user2@example.com', '$2y$10$sq6SMouNo86RnNnqAqKhc.6G5p1d2ZcVDJ7TRe8Ioj1NsFeiOQFja', NOW(), NOW(), 1, 1);

INSERT INTO businesses (account_id, name, description) VALUES
                                                           (1, 'Business1', 'Description for Business1'),
                                                           (2, 'Business2', 'Description for Business2');

INSERT INTO businesses_categories (name) VALUES ('Category1'), ('Category2');

INSERT INTO article_categories (name) VALUES ('CategoryA'), ('CategoryB');

INSERT INTO businesses_categories_mapping (category_id, business_id) VALUES (1, 1), (2, 2);

INSERT INTO business_contacts (business_id, type, value) VALUES
                                                             (1, 'Phone', '123-456-7890'),
                                                             (2, 'Email', 'business2@example.com');

INSERT INTO businesses_advert_categories (business_id, name) VALUES (1, 'AdvertCategory1'), (2, 'AdvertCategory2');

INSERT INTO authorities_granted (authority_id, account_id) VALUES (1, 1), (2, 2);

INSERT INTO articles (account_id, title, description, created_date, modified_date) VALUES
                                                                                       (1, 'Article1', 'Description for Article1', NOW(), NULL),
                                                                                       (2, 'Article2', 'Description for Article2', NOW(), NULL);

INSERT INTO articles_categories_mapping (article_id, category_id) VALUES (1, 1), (2, 2);

INSERT INTO addresses (business_id, address, postal_code) VALUES
                                                              (1, '123 Main St', 12345),
                                                              (2, '456 Oak St', 67890);

INSERT INTO commentaries (article_id, commentator_id, title, description, creation_date, modified_date) VALUES
                                                                                                            (1, 1, 'Commentary1', 'Description for Commentary1', NOW(), NULL),
                                                                                                            (2, 2, 'Commentary2', 'Description for Commentary2', NOW(), NULL);

INSERT INTO commentaries_likes (liker_id, commentary_id, is_liked) VALUES (1, 1, 1), (2, 2, 1);

INSERT INTO adverts (business_id, title, description, cover_img, active, creation_date, modified_date) VALUES
                                                                                                           (1, 'Advert1', 'Description for Advert1', 'img1.jpg', 1, NOW(), NULL),
                                                                                                           (2, 'Advert2', 'Description for Advert2', 'img2.jpg', 1, NOW(), NULL);

INSERT INTO adverts_characteristics (advert_id, type, value) VALUES
                                                                 (1, 'Characteristic1', 'Value1'),
                                                                 (2, 'Characteristic2', 'Value2');

INSERT INTO advert_categories (advert_id, category_id) VALUES (1, 1), (2, 2);

INSERT INTO images (advert_id, url) VALUES
                                        (1, 'img1.jpg'),
                                        (2, 'img2.jpg');

INSERT INTO reviews (account_id, business_id, title, description, creation_date, modified_date, rating) VALUES
                                                                                                            (1, 1, 'Review1', 'Description for Review1', NOW(), NULL, 4),
                                                                                                            (2, 2, 'Review2', 'Description for Review2', NOW(), NULL, 5);

INSERT INTO reviews_likes (commentator_id, review_id, is_liked) VALUES (1, 1, 1), (2, 2, 1);