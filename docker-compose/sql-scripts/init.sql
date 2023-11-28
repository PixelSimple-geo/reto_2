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

-- Inserting authorities
INSERT INTO authorities (role) VALUES
                                   ('ADMIN'),
                                   ('PUBLISHER');

-- Inserción de cuentas
INSERT INTO accounts (username, email, password) VALUES
                                                     ('john_doe', 'john.doe@example.com', 'hashed_password_123'),
                                                     ('jane_smith', 'jane.smith@example.com', 'hashed_password_456'),
                                                     ('admin_user', 'admin@example.com', 'hashed_admin_password');

-- Inserción de negocios
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (1, 1, 'Awesome Tech Solutions', 'Proporcionando soluciones tecnológicas de vanguardia.', '/statics/uploads/pickawood-_l9Znw_mxgs-unsplash.jpg');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (2, 2, 'Paraíso de la Moda', 'Tu tienda única para las últimas tendencias de moda.', '/statics/uploads/charlesdeluvio-kyD7I53MEuE-unsplash.jpg');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (3, 1, 'Dulces Delicias Panadería', 'Ofrecemos una amplia variedad de panes frescos y pasteles irresistibles.', '/statics/uploads/panaderia.png');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (4, 2, 'Artesanos del Sabor Panadería', 'Descubre el auténtico sabor de la tradición en cada bocado de nuestros productos horneados.', '/statics/uploads/panaderia2.png');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (5, 1, 'Sabor Urbano Restaurant', 'Explora una experiencia culinaria única con nuestra fusión de sabores urbanos y creatividad en cada plato.', '/statics/uploads/restaurante.jpg');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (6, 2, 'Delicias del Mar Restaurante', 'Déjate llevar por la frescura y exquisitez de nuestros platillos con ingredientes del mar.', '/statics/uploads/restaurante2.jpg');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (7, 1, 'Café Aromático', 'Disfruta de la experiencia única de nuestro café aromático y deliciosos postres en un ambiente acogedor.', '/statics/uploads/cafeteria.jpg');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (8, 2, 'Rincón del Café', 'Sumérgete en la calidez de nuestro rincón, donde la pasión por el café se combina con la comodidad y el buen gusto.', '/statics/uploads/cafeteria2.jpg');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (9, 1, 'Gimnasio Vitalidad', 'Transforma tu cuerpo y mente en nuestro gimnasio, donde la vitalidad se encuentra con el bienestar.', '/statics/uploads/gimnasio.jpg');
INSERT INTO reto_2.businesses (business_id, account_id, name, description, cover_img) VALUES (10, 2, 'Florería Elegante', 'Expresa tus emociones con la belleza de nuestras flores frescas y arreglos florales elegantes.', '/statics/uploads/floreria.jpg');

-- Inserción de categorías de negocios
INSERT INTO businesses_categories (name) VALUES
('Tecnología'),
('Moda'),
('Restaurante'),
('Cafetería'),
('Panadería'),
('Salud'),
('Cultura');

INSERT INTO businesses_categories_mapping (category_id, business_id) VALUES
(1, 1),
(2, 2),
(5, 3),
(5, 4),
(3, 5),
(3, 6),
(4, 7),
(4, 8),
(6, 9),
(7, 10);
 

INSERT INTO business_contacts (business_id, type, value) VALUES
(1, 'Teléfono', '123-456-7890'),
(1, 'Correo Electrónico', 'info@awesome-tech.com'),
(1, 'Twitter', '@AwesomeTech'),
(2, 'Teléfono', '555-123-4567'),
(2, 'Correo Electrónico', 'info@fashion-paradise.com'),
(2, 'Facebook', '/fashionparadise'),
(3, 'Teléfono', '987-654-3210'),
(3, 'Correo Electrónico', 'info@dulces-delicias.com'),
(3, 'Instagram', '@dulcesdelicias'),
(4, 'Teléfono', '567-890-1234'),
(4, 'Correo Electrónico', 'info@artesanos-sabor.com'),
(4, 'Facebook', '/artesanosdelsabor'),
(5, 'Teléfono', '876-543-2109'),
(5, 'Correo Electrónico', 'info@sabor-urbano.com'),
(5, 'Twitter', '@SaborUrbano'),
(6, 'Teléfono', '234-567-8901'),
(6, 'Correo Electrónico', 'info@delicias-mar.com'),
(6, 'Instagram', '@deliciasdelmar'),
(7, 'Teléfono', '345-678-9012'),
(7, 'Correo Electrónico', 'info@cafe-aromatico.com'),
(7, 'Twitter', '@CafeAromático'),
(8, 'Teléfono', '789-012-3456'),
(8, 'Correo Electrónico', 'info@rincon-cafe.com'),
(8, 'Instagram', '@rincondelcafe'),
(9, 'Teléfono', '901-234-5678'),
(9, 'Correo Electrónico', 'info@gimnasio-vitalidad.com'),
(9, 'Facebook', '/gimnasiovitalidad'),
(10, 'Teléfono', '210-987-6543'),
(10, 'Correo Electrónico', 'info@floreria-elegante.com'),
(10, 'Instagram', '@floreriaelegante');

-- Inserción de categorías de anuncios de negocios
INSERT INTO businesses_advert_categories (business_id, name) VALUES
(1, 'Gadgets Tecnológicos'),
(2, 'Ropa'),
(2, 'Accesorios'),
(3, 'Pan Integral'),
(3, 'Pasteles Especiales'),
(4, 'Pan Artesanal'),
(4, 'Postres Gourmet'),
(5, 'Platos Gourmet'),
(5, 'Especialidades de la Casa'),
(6, 'Mariscos Frescos'),
(6, 'Menú del Chef'),
(7, 'Café Especial'),
(7, 'Postres Caseros'),
(8, 'Variedades de Café'),
(8, 'Desayunos Saludables'),
(9, 'Entrenamiento Personalizado'),
(9, 'Clases de Grupo'),
(10, 'Arreglos Florales'),
(10, 'Flores para Eventos');

-- Inserción de autorizaciones otorgadas
INSERT INTO authorities_granted (authority_id, account_id) VALUES
(1, 1),
(2, 2),
(1,3),
(2,3);

-- Inserción de artículos
INSERT INTO articles (account_id, title, description, created_date, modified_date) VALUES
(2, 'Tendencias de Otoño en Moda', 'Descubre las tendencias de moda que marcarán la pauta este otoño.', NOW(), NOW()),
(2, 'Secretos de la Cocina del Mar', 'Conoce los secretos detrás de los deliciosos platillos de Delicias del Mar.', NOW(), NOW()),
(2, 'Flores que Expresan Emociones', 'Descubre el significado de diferentes flores en los arreglos de Florería Elegante.', NOW(), NOW()),
(3, 'El Arte de Hacer un Buen Espresso', 'Consejos de Café Aromático para preparar el espresso perfecto en casa.', NOW(), NOW()),
(2, 'Cómo Elegir el Smartphone Perfecto', 'Guía para seleccionar el smartphone ideal según tus necesidades y preferencias.', NOW(), NOW()),
(3, '5 Tendencias de Decoración para el Hogar', 'Descubre las últimas tendencias en decoración para transformar tu hogar.', NOW(), NOW()),
(2, 'Los Mejores Destinos de Viaje para el Próximo Año', 'Explora los destinos de viaje más emocionantes y populares para el próximo año.', NOW(), NOW()),
(3, 'Recetas de Postres Saludables', 'Disfruta de deliciosos postres sin sacrificar la salud con estas recetas.', NOW(), NOW()),
(2, 'Cómo Crear un Armario Cápsula', 'Consejos para construir un armario versátil con piezas clave de moda.', NOW(), NOW()),
(3, 'Consejos para un Entrenamiento Efectivo en Casa', 'Optimiza tu rutina de ejercicios en casa con estos consejos profesionales.', NOW(), NOW()),
(2, 'Cómo Cuidar Tus Plantas de Interior', 'Guía completa para mantener tus plantas de interior felices y saludables.', NOW(), NOW()),
(3, 'Ideas Creativas para Regalos Personalizados', 'Inspírate con ideas únicas para regalos personalizados y significativos.', NOW(), NOW()),
(2, 'Recetas de Mariscos para Impresionar a tus Invitados', 'Prepara platos de mariscos sofisticados que dejarán a tus invitados encantados.', NOW(), NOW()),
(3, 'Consejos para un Café Perfecto en Casa', 'Descubre los secretos para preparar el café perfecto en la comodidad de tu hogar.', NOW(), NOW());

-- Insercion de categorias de articulos
INSERT INTO article_categories(category_id, name) VALUES(DEFAULT, 'Noticias'), (DEFAULT, 'Campañas'),(DEFAULT, 'Entrevistas'), (DEFAULT, 'Reseñas');

-- Inserción de asignación de categorías de artículos
INSERT INTO articles_categories_mapping (article_id, category_id) VALUES
(1, 1),
(2, 2),
(3, 1),
(4, 2);

-- Inserción de direcciones
INSERT INTO addresses (business_id, address, postal_code) VALUES
(1, '123 Calle Tech', 56789),
(2, '456 Avenida de la Moda', 12345),
(3, '789 Plaza de la Panadería', 67890),
(4, '012 Calle de los Artesanos', 34567),
(5, '234 Calle del Sabor', 89012),
(6, '567 Avenida del Mar', 45678),
(7, '890 Calle del Café', 12340),
(8, '123 Rincón del Café', 56789),
(9, '456 Calle de la Vitalidad', 23456),
(10, '789 Avenida Elegante', 78901);

-- Inserción de comentarios
INSERT INTO commentaries (article_id, commentator_id, title, description, creation_date) VALUES
(1, 2, '¡Gran Artículo!', 'Disfruté leyendo sobre IA. Muy informativo.', NOW()),
(2, 1, '¡Amo las Tendencias!', 'Estas tendencias de moda son increíbles. ¡No puedo esperar al verano!', NOW()),
(3, 3, 'Emociones a Flor de Piel', 'La descripción de las flores en Florería Elegante es encantadora. Me encanta saber el significado detrás de cada arreglo.', NOW()),
(4, 2, 'Espresso Perfecto en Casa', 'Los consejos de Café Aromático realmente mejoraron mi habilidad para hacer espresso en casa. ¡Gracias!', NOW()),
(5, 1, 'Guía Útil para Elegir Smartphone', 'La guía sobre cómo elegir el smartphone perfecto fue muy útil para mi próxima compra.', NOW()),
(6, 3, 'Transformando mi Hogar', 'Las tendencias de decoración para el hogar que mencionas en el artículo fueron justo lo que necesitaba. ¡Mi hogar se ve increíble!', NOW()),
(7, 2, 'Destinos de Viaje Inolvidables', 'Los destinos de viaje recomendados son emocionantes. ¡Definitivamente planeando mi próximo viaje!', NOW()),
(8, 1, 'Delicias Saludables', 'Las recetas de postres saludables son deliciosas. ¡Ahora puedo disfrutar de algo dulce sin sentirme culpable!', NOW()),
(9, 3, 'Armario Cápsula Exitoso', 'Gracias por los consejos sobre cómo crear un armario cápsula. Ahora me siento más organizado y con estilo.', NOW()),
(10, 2, 'Entrenamiento Efectivo en Casa', 'Los consejos para un entrenamiento efectivo en casa son justo lo que necesitaba. ¡Me siento más fuerte cada día!', NOW()),
(11, 1, 'Cuidado de Plantas Simplificado', 'La guía para cuidar plantas de interior es muy útil. ¡Mis plantas están más felices que nunca!', NOW()),
(12, 3, 'Regalos Personalizados y Significativos', 'Las ideas creativas para regalos personalizados me inspiraron. ¡Definitivamente haré regalos más especiales!', NOW()),
(13, 2, 'Impresionando con Mariscos', 'Las recetas de mariscos para impresionar a los invitados son fantásticas. ¡Mi cena fue un éxito gracias a ellas!', NOW()),
(14, 1, 'Café Perfecto en Casa', 'Los consejos para un café perfecto en casa realmente mejoraron mi experiencia con el café. ¡Gracias por compartir!', NOW());

-- Inserción de likes de comentarios
INSERT INTO commentaries_likes (liker_id, commentary_id, is_liked) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(2, 4, 1),
(1, 5, 1),
(3, 6, 1),
(2, 7, 1),
(1, 8, 1),
(3, 9, 1),
(2, 10, 1),
(1, 11, 1),
(3, 12, 1),
(2, 13, 1),
(1, 14, 1);

-- Inserción de anuncios para negocios
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (1, 1, 'Última Venta de Gadgets Tecnológicos', 'Obtén los gadgets más nuevos a precios imbatibles.', '/statics/uploads/screen-post-vYxnwamt6HE-unsplash.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (2, 2, 'Venta de Moda Verano', 'Disfruta de descuentos en los últimos artículos de moda para el verano.', '/statics/uploads/hannah-busing-ut8l3-_S0c4-unsplash.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (3, 3, 'Oferta Especial en Panes Frescos', 'Descubre nuestra variedad de panes frescos con descuentos especiales esta semana.', '/statics/uploads/panaderia_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (4, 4, 'Promoción de Productos Tradicionales', 'Aprovecha nuestras ofertas en productos horneados tradicionales. ¡Solo por tiempo limitado!', '/statics/uploads/panaderia2_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (5, 5, 'Noche de Sabores Urbanos', 'Disfruta de una noche especial con nuestra selección de sabores urbanos en Sabor Urbano Restaurant.', '/statics/uploads/restaurante_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (6, 6, 'Menú del Mar Exquisito', 'Explora nuestro menú exquisito con ingredientes frescos del mar en Delicias del Mar Restaurante.', '/statics/uploads/restaurante2_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (7, 7, 'Aromas Tentadores en Café Aromático', 'Descubre los aromas tentadores de nuestro café y disfruta de postres deliciosos en Café Aromático.', '/statics/uploads/cafeteria_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (8, 8, 'Experiencia Café en Rincón del Café', 'Vive la experiencia del café en Rincón del Café, donde la pasión y el buen gusto se encuentran.', '/statics/uploads/cafeteria2_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (9, 9, 'Transforma tu Vida en Gimnasio Vitalidad', 'Descubre cómo transformar tu cuerpo y mente en Gimnasio Vitalidad. ¡Te esperamos!', '/statics/uploads/gimnasio_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (10, 10, 'Elegancia en Cada Flor', 'Expresa tus emociones con la elegancia de nuestras flores frescas en Florería Elegante.', '/statics/uploads/floreria_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (11, 1, 'Descubre la Innovación en Awesome Tech Solutions', 'Explora la última innovación tecnológica con nuestras soluciones vanguardistas.', '/statics/uploads/awesome_tech_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (12, 2, 'Fashion Paradise: Donde las Tendencias Cobran Vida', 'Sumérgete en el paraíso de la moda y descubre las tendencias que cobran vida.', '/statics/uploads/fashion_paradise_advert.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (13, 3, 'Dulces Tentaciones en Dulces Delicias Panadería', 'Satisface tus dulces tentaciones con nuestra variedad de panes y pasteles en Dulces Delicias Panadería.', '/statics/uploads/panaderia_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (14, 4, 'Artesanía de Sabores en Artesanos del Sabor Panadería', 'Disfruta de la artesanía de sabores con nuestros productos horneados en Artesanos del Sabor Panadería.', '/statics/uploads/panaderia2_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (15, 5, 'Sabor Urbano Restaurant: Creatividad Culinaria y Urbano', 'Experimenta la fusión de sabores urbanos y la creatividad culinaria en Sabor Urbano Restaurant.', '/statics/uploads/restaurante_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (16, 6, 'Delicias del Mar Restaurante: Sabores Frescos del Mar', 'Déjate llevar por los sabores frescos del mar en Delicias del Mar Restaurante.', '/statics/uploads/restaurante2_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (17, 7, 'Café Aromático: Disfruta del Verdadero Aroma del Café', 'Disfruta del auténtico aroma del café y deliciosos postres en Café Aromático.', '/statics/uploads/cafeteria_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (18, 8, 'Rincón del Café: Pasión por el Café y Comodidad', 'Sumérgete en la calidez de Rincón del Café, donde la pasión por el café se combina con la comodidad.', '/statics/uploads/cafeteria2_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (19, 9, 'Gimnasio Vitalidad: Transforma tu Cuerpo y Mente', 'Descubre la vitalidad al transformar tu cuerpo y mente en Gimnasio Vitalidad.', '/statics/uploads/gimnasio_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');
INSERT INTO reto_2.adverts (advert_id, business_id, title, description, cover_img, active, creation_date, modified_date) VALUES (20, 10, 'Florería Elegante: Expresa Emociones con Elegancia', 'Expresa tus emociones con la elegancia de nuestras flores frescas en Florería Elegante.', '/statics/uploads/floreria_advert_2.jpg', 1, '2023-11-28 10:01:45', '2023-11-28 10:01:45');

-- Inserción de características de anuncios
INSERT INTO adverts_characteristics (advert_id, type, value) VALUES
                                                             (1, 'Porcentaje de Descuento', '20% de descuento'),
                                                             (2, 'Porcentaje de Descuento', '30% de descuento'),
                                                             (3, 'Dimensiones', '50x50 cm'),
                                                             (4, 'Dimensiones', '40x60 cm'),
                                                             (5, 'Peso', '1.5 kg'),
                                                             (6, 'Peso', '2 kg'),
                                                             (7, 'Color', 'Negro'),
                                                             (8, 'Color', 'Marrón'),
                                                             (9, 'Duración de Membresía', '3 meses'),
                                                             (10, 'Duración de Membresía', '6 meses'),
                                                             (11, 'Descuento', '15% en productos seleccionados'),
                                                             (12, 'Descuento', '20% en toda la colección'),
                                                             (13, 'Precio', '$599.99'),
                                                             (14, 'Precio', '$49.99'),
                                                             (15, 'Dimensiones', '45x45 cm'),
                                                             (16, 'Dimensiones', '30x50 cm'),
                                                             (17, 'Peso', '1.8 kg'),
                                                             (18, 'Peso', '1.2 kg'),
                                                             (19, 'Color', 'Blanco'),
                                                             (20, 'Color', 'Verde');
-- Inserción de categorías de anuncios
INSERT INTO advert_categories (advert_id, category_id) VALUES
                                                        (1, 1),
                                                        (2, 2),
                                                        (3, 3),
                                                        (4, 4),
                                                        (5, 5),
                                                        (6, 6),
                                                        (7, 7),
                                                        (8, 8),
                                                        (9, 9),
                                                        (10, 10),
                                                        (11, 11),
                                                        (12, 12),
                                                        (13, 1),
                                                        (14, 2),
                                                        (15, 3),
                                                        (16, 4),
                                                        (17, 5),
                                                        (18, 6),
                                                        (19, 7),
                                                        (20, 8);

-- Inserción de categorías de anuncios de negocios
INSERT INTO businesses_advert_categories (business_id, name) VALUES
                                                               (1, 'Gadgets Tecnológicos'),
                                                               (2, 'Ropa'),
                                                               (2, 'Accesorios'),
                                                               (3, 'Panadería'),
                                                               (3, 'Pasteles'),
                                                               (4, 'Panadería'),
                                                               (4, 'Postres'),
                                                               (5, 'Restaurante'),
                                                               (5, 'Platos Gourmet'),
                                                               (6, 'Restaurante'),
                                                               (6, 'Especialidades del Mar'),
                                                               (7, 'Cafetería'),
                                                               (7, 'Postres Caseros'),
                                                               (8, 'Cafetería'),
                                                               (8, 'Desayunos'),
                                                               (9, 'Gimnasio'),
                                                               (9, 'Clases de Fitness'),
                                                               (10, 'Florería'),
                                                               (10, 'Arreglos Florales');

INSERT INTO images (advert_id, url) VALUES
(1, 'imagen_gadget_1.jpg'),
(1, 'imagen_gadget_2.jpg'),
(2, 'imagen_moda_1.jpg'),
(2, 'imagen_moda_2.jpg'),
(3, 'panes_frescos_1.jpg'),
(3, 'panes_frescos_2.jpg'),
(4, 'productos_tradicionales_1.jpg'),
(4, 'productos_tradicionales_2.jpg'),
(5, 'sabores_urbanos_1.jpg'),
(5, 'sabores_urbanos_2.jpg'),
(6, 'menu_mar_1.jpg'),
(6, 'menu_mar_2.jpg'),
(7, 'cafe_aromatico_1.jpg'),
(7, 'cafe_aromatico_2.jpg'),
(8, 'rincon_cafe_1.jpg'),
(8, 'rincon_cafe_2.jpg'),
(9, 'gimnasio_vitalidad_1.jpg'),
(9, 'gimnasio_vitalidad_2.jpg'),
(10, 'elegancia_flor_1.jpg'),
(10, 'elegancia_flor_2.jpg'),
(11, 'innovacion_tech_1.jpg'),
(11, 'innovacion_tech_2.jpg'),
(12, 'fashion_paradise_1.jpg'),
(12, 'fashion_paradise_2.jpg'),
(13, 'dulces_delicias_1.jpg'),
(13, 'dulces_delicias_2.jpg'),
(14, 'artesanos_sabor_1.jpg'),
(14, 'artesanos_sabor_2.jpg'),
(15, 'sabor_urbano_1.jpg'),
(15, 'sabor_urbano_2.jpg'),
(16, 'delicias_mar_1.jpg'),
(16, 'delicias_mar_2.jpg'),
(17, 'cafe_aromatico_3.jpg'),
(17, 'cafe_aromatico_4.jpg'),
(18, 'rincon_cafe_3.jpg'),
(18, 'rincon_cafe_4.jpg'),
(19, 'gimnasio_vitalidad_3.jpg'),
(19, 'gimnasio_vitalidad_4.jpg'),
(20, 'floreria_elegante_3.jpg'),
(20, 'floreria_elegante_4.jpg');

-- Inserción de revisiones
INSERT INTO reviews (account_id, business_id, title, description, creation_date, rating) VALUES
                                                                                 (1, 1, '¡Excelente Servicio!', 'Awesome Tech Solutions ofrece un servicio de primera.', NOW(), 5),
                                                                                 (2, 2, 'Gran Tienda de Moda', 'Fashion Paradise tiene las últimas tendencias y excelentes precios.', NOW(), 1),
                                                                                 (3, 3, 'Repostería de Alta Calidad', 'Dulces Delicias Panadería siempre sorprende con sus exquisitos pasteles y panes.', NOW(), 2),
                                                                                 (1, 4, 'Sabor Tradicional Inigualable', 'Artesanos del Sabor Panadería mantiene viva la auténtica tradición en cada producto.', NOW(), 5),
                                                                                 (2, 5, 'Experiencia Gastronómica Única', 'Sabor Urbano Restaurant ofrece una fusión de sabores que te transporta a lugares únicos.', NOW(), 4),
                                                                                 (2, 6, 'Delicias del Mar', 'Los platillos de Delicias del Mar Restaurante son frescos y deliciosos, una experiencia marina única.', NOW(), 3),
                                                                                 (1, 7, 'Aromas Irresistibles', 'Café Aromático te envuelve con sus aromas deliciosos y postres irresistibles.', NOW(), 3),
                                                                                 (3, 8, 'Rinconcito Acogedor', 'Rincón del Café ofrece una experiencia cálida donde el buen gusto y el café se fusionan.', NOW(), 1),
                                                                                 (3, 9, 'Transformación Total', 'Gimnasio Vitalidad me ha ayudado a transformar mi cuerpo y mente. ¡Recomendado!', NOW(), 4),
                                                                                 (1, 10, 'Flores Elegantes', 'Florería Elegante tiene arreglos florales que expresan emociones de manera elegante y única.', NOW(), 5);

-- Inserción de likes de revisiones
INSERT INTO reviews_likes (commentator_id, review_id, is_liked) VALUES
                                                                    (2, 1, 1),
                                                                    (1, 2, 1);