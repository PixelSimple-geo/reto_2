INSERT INTO authorities (role)
VALUES ('Admin'),
       ('Moderator'),
       ('User');

INSERT INTO accounts (username, email, password, creation_date, last_login, verified)
VALUES ('user1', 'user1@example.com', 'password1', '2023-11-09', '2023-11-09', 1),
       ('user2', 'user2@example.com', 'password2', '2023-11-09', '2023-11-09', 1),
       ('user3', 'user3@example.com', 'password3', '2023-11-09', '2023-11-09', 1);

INSERT INTO authorities_granted (authority_id, account_id)
VALUES (1, 1),
       (2, 2),
       (3, 3);

INSERT INTO businesses (account_id, name, description)
VALUES (1, 'Business 1', 'Description for Business 1'),
       (2, 'Business 2', 'Description for Business 2'),
       (3, 'Business 3', 'Description for Business 3');

INSERT INTO reviews (account_id, business_id, title, description, creation_date, modified_date, rating)
VALUES (1, 1, 'Review 1', 'Description for Review 1', '2023-11-09', '2023-11-09', 5),
       (2, 2, 'Review 2', 'Description for Review 2', '2023-11-09', '2023-11-09', 4),
       (3, 3, 'Review 3', 'Description for Review 3', '2023-11-09', '2023-11-09', 3);

INSERT INTO cities (name)
VALUES ('CityA'),
       ('CityB'),
       ('CityC');

INSERT INTO addresses (business_id, city_id, address, postal_code)
VALUES (1, 1, '123 Main St', 12345),
       (2, 2, '456 Oak St', 67890),
       (3, 3, '789 Pine St', 54321);

INSERT INTO business_contacts (business_id, type, value)
VALUES (1, 'Phone', '123-456-7890'),
       (2, 'Email', 'contact@example.com'),
       (3, 'Address', '789 Elm St');

INSERT INTO businesses_categories (name)
VALUES ('CategoryX'),
       ('CategoryY'),
       ('CategoryZ');

INSERT INTO businesses_categories_mapping (category_id, business_id)
VALUES (1, 1),
       (2, 2),
       (3, 3);

INSERT INTO businesses_advert_categories (business_id, name)
VALUES (1, 'CategoryA'),
       (2, 'CategoryB'),
       (3, 'CategoryC');

INSERT INTO adverts (business_id, title, description, cover_img, active, creation_date, modified_date)
VALUES (1, 'Advert 1', 'Description for Advert 1', 'img1.jpg', 1, '2023-11-09', '2023-11-09'),
       (2, 'Advert 2', 'Description for Advert 2', 'img2.jpg', 1, '2023-11-09', '2023-11-09'),
       (3, 'Advert 3', 'Description for Advert 3', 'img3.jpg', 1, '2023-11-09', '2023-11-09');


INSERT INTO advert_categories (advert_id, category_id)
VALUES (1, 1),
       (2, 2),
       (3, 3);


INSERT INTO adverts_characteristics (advert_id, type, value)
VALUES (1, 'Type1', 'Value1'),
       (2, 'Type2', 'Value2'),
       (3, 'Type3', 'Value3');

INSERT INTO article_categories (name)
VALUES ('Category1'),
       ('Category2'),
       ('Category3');

INSERT INTO articles (account_id, title, description, created_date, modified_date)
VALUES (1, 'Article 1', 'Description for Article 1', '2023-11-09', '2023-11-09'),
       (2, 'Article 2', 'Description for Article 2', '2023-11-09', '2023-11-09'),
       (3, 'Article 3', 'Description for Article 3', '2023-11-09', '2023-11-09');

INSERT INTO articles_categories_mapping (article_id, category_id)
VALUES (1, 1),
       (2, 2),
       (3, 3);

INSERT INTO commentaries (article_id, account_id, title, description, creation_date, modified_date, likes, dislikes)
VALUES (1, 1, 'Comment 1', 'Description for Comment 1', '2023-11-09', '2023-11-09', 10, 2),
       (2, 2, 'Comment 2', 'Description for Comment 2', '2023-11-09', '2023-11-09', 5, 1),
       (3, 3, 'Comment 3', 'Description for Comment 3', '2023-11-09', '2023-11-09', 8, 3);

INSERT INTO images (advert_id, url)
VALUES (1, 'img1.jpg'),
       (2, 'img2.jpg'),
       (3, 'img3.jpg');

