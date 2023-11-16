INSERT INTO authorities (role) VALUES ('ADMIN');
INSERT INTO authorities (role) VALUES ('USER');

INSERT INTO accounts (username, email, password, creation_date, last_login, verified, active) VALUES
('user1', 'user1@example.com', 'password1', NOW(), NOW(), 1, 1),
('user2', 'user2@example.com', 'password2', NOW(), NOW(), 1, 1);

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