-- Inserting authorities
INSERT INTO authorities (role) VALUES
('ADMIN'),
('PUBLISHER');

-- Inserting accounts
INSERT INTO accounts (username, email, password) VALUES
('john_doe', 'john.doe@example.com', '$2y$10$gUJnHTwf61th6eHwNQWTV.R05Fq8wNAIHnb2e6sP0V6pN2Z5DCoaC'),
('jane_smith', 'jane.smith@example.com', '$2y$10$RPIi1kazG4NCm1rxK7y8UOKKem32ie5M8KaDY79/ahMBCeAFMisXu'),
('admin_user', 'admin@example.com', '$2y$10$CQyNDQxwJsyOfWmi1/rtCOBBFXMWYW50TwQ4wMvKBkpR9Qycu.dhC');

-- Inserting businesses
INSERT INTO businesses (account_id, name, description, cover_img) VALUES
(1, 'Awesome Tech Solutions', 'Providing cutting-edge technology solutions.', 'tech_solutions.jpg'),
(2, 'Fashion Paradise', 'Your one-stop shop for the latest fashion trends.', 'fashion_paradise.jpg');

-- Inserting businesses_categories
INSERT INTO businesses_categories (name) VALUES
('Technology'),
('Fashion'),
('Food & Dining');

-- Inserting businesses_categories_mapping
INSERT INTO businesses_categories_mapping (category_id, business_id) VALUES
(1, 1),
(2, 2);

-- Inserting business_contacts
INSERT INTO business_contacts (business_id, type, value) VALUES
(1, 'Phone', '123-456-7890'),
(1, 'Email', 'info@awesome-tech.com'),
(2, 'Phone', '555-123-4567'),
(2, 'Email', 'info@fashion-paradise.com');

-- Inserting businesses_advert_categories
INSERT INTO businesses_advert_categories (business_id, name) VALUES
(1, 'Tech Gadgets'),
(2, 'Clothing'),
(2, 'Accessories');

-- Inserting authorities_granted
INSERT INTO authorities_granted (authority_id, account_id) VALUES
(1, 1),
(2, 2),
(3, 3);

-- Inserting articles
INSERT INTO articles (account_id, title, description, created_date, modified_date) VALUES
(1, 'Introduction to Artificial Intelligence', 'Exploring the basics of AI and machine learning.', NOW(), NOW()),
(2, 'Summer Fashion Trends 2023', 'Discover the hottest trends for the summer season.', NOW(), NOW());

-- Inserting articles_categories_mapping
INSERT INTO articles_categories_mapping (article_id, category_id) VALUES
(1, 1),
(2, 2);

-- Inserting addresses
INSERT INTO addresses (business_id, address, postal_code) VALUES
(1, '123 Tech Street', 56789),
(2, '456 Fashion Avenue', 12345);

-- Inserting commentaries
INSERT INTO commentaries (article_id, commentator_id, title, description, creation_date) VALUES
(1, 2, 'Great Article!', 'I enjoyed reading about AI. Very informative.', NOW()),
(2, 1, 'Love the Trends!', 'These fashion trends are amazing. Cant wait for summer!', NOW());

-- Inserting commentaries_likes
INSERT INTO commentaries_likes (liker_id, commentary_id, is_liked) VALUES
(1, 1, 1),
(2, 2, 1);

-- Inserting adverts
INSERT INTO adverts (business_id, title, description, cover_img, active, creation_date, modified_date) VALUES
(1, 'Latest Tech Gadgets Sale', 'Get the newest gadgets at unbeatable prices!', 'tech_sale.jpg', 1, NOW(), NOW()),
(2, 'Summer Fashion Sale', 'Enjoy discounts on the latest summer fashion items.', 'fashion_sale.jpg', 1, NOW(), NOW());

-- Inserting adverts_characteristics
INSERT INTO adverts_characteristics (advert_id, type, value) VALUES
(1, 'Discount Percentage', '20% off'),
(2, 'Discount Percentage', '30% off');

-- Inserting advert_categories
INSERT INTO advert_categories (advert_id, category_id) VALUES
(1, 1),
(2, 2);

-- Inserting images
INSERT INTO images (advert_id, url) VALUES
(1, 'gadget_image_1.jpg'),
(1, 'gadget_image_2.jpg'),
(2, 'fashion_image_1.jpg'),
(2, 'fashion_image_2.jpg');

-- Inserting reviews
INSERT INTO reviews (account_id, business_id, title, description, creation_date, rating) VALUES
(1, 1, 'Excellent Service!', 'Awesome Tech Solutions provides top-notch service.', NOW(), 5),
(2, 2, 'Great Fashion Store', 'Fashion Paradise has the latest trends and great prices.', NOW(), 4);

-- Inserting reviews_likes
INSERT INTO reviews_likes (commentator_id, review_id, is_liked) VALUES
(2, 1, 1),
(1, 2, 1);
