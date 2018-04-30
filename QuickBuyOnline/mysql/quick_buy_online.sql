CREATE TABLE users (
  user_id int UNIQUE NOT NULL AUTO_INCREMENT,
  username varchar(50) UNIQUE NOT NULL,
  first_name varchar(50) NOT NULL,
  last_name varchar(50) NOT NULL,
  email varchar(50) NOT NULL,
  pass varchar(41) NOT NULL,
  administrator boolean NOT NULL DEFAULT false,
  registration_date datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id)
);

CREATE TABLE checkout_accounts (
  account_id int UNIQUE NOT NULL AUTO_INCREMENT,
  user_id int NOT NULL,
  cardholder_name varchar(100) NOT NULL,
  card_number varchar(20) NOT NULL,
  security_code varchar(3) NOT NULL,
  expiration_date varchar(10) NOT NULL,
  PRIMARY KEY (account_id),
  FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE carts (
  cart_id int UNIQUE NOT NULL AUTO_INCREMENT,
  user_id int NOT NULL,
  PRIMARY KEY (cart_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE products (
  product_id int UNIQUE NOT NULL AUTO_INCREMENT,
  name varchar(40) NOT NULL,
  price float NOT NULL,
  description varchar(300),
  purchased boolean NOT NULL DEFAULT false,
  PRIMARY KEY (product_id)
);

CREATE TABLE carts_products (
  cart_id int NOT NULL,
  product_id int NOT NULL,
  FOREIGN KEY (cart_id) REFERENCES carts(cart_id),
  FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE purchases (
  purchase_id int UNIQUE NOT NULL AUTO_INCREMENT,
  product_id int NOT NULL,
  PRIMARY KEY (purchase_id),
  FOREIGN KEY (products) REFERENCES products(product_id)
);

INSERT INTO users (username, first_name, last_name, email, pass, administrator)
VALUES ('admin1', 'test', 'admin', 'admin@testemail.test', SHA1('password'), true),
('test', 'test', 'user', 'test@testemail.test', SHA1('password'), true);
