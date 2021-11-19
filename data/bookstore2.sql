CREATE TABLE CATEGORY(
  id int not null auto_increment,
  name varchar(50) not null,
  primary key(id)
);

CREATE TABLE AUTHOR(
  id int not null auto_increment,
  first_name varchar(50) not null,
  last_name varchar(50) not null,
  primary key(id)
);

CREATE TABLE BOOK (
  isbn varchar(100) not null,
  title varchar(50) not null,
  author_id int not null,
  category_id int not null,
  price decimal(20,2) not null,
  quantity int not null,
  primary key(isbn),
  foreign key(author_id) references AUTHOR(id),
  foreign key(category_id) references CATEGORY(id)
);

CREATE TABLE REVIEW (
  id int NOT NULL AUTO_INCREMENT,
  isbn varchar(50) NOT NULL,
  description varchar(1000) NOT NULL,
  PRIMARY KEY (`id`,`isbn`),
  FOREIGN KEY (`isbn`) REFERENCES BOOK (`isbn`)
);

CREATE TABLE USER (
  id int NOT NULL AUTO_INCREMENT,
  type char(1) NOT NULL,
  username varchar(50),
  pin int,
  first_name varchar(50),
  last_name varchar(50),
  address varchar(50),
  city varchar(50),
  state varchar(50),
  zip char(5),
  credit_card varchar(10),
  card_number varchar(16),
  expiration varchar(10),
  PRIMARY KEY (`id`)
);

CREATE TABLE SHOPPING_CART(
  id int not null auto_increment,
  user_id int not null, total decimal(50,2) DEFAULT 0.00,
  primary key(id, user_id),
  foreign key(user_id) references USER(id)
);

CREATE TABLE CART_ITEM(
  cart_id int not null,
  isbn varchar(50) not null,
  price decimal(10,2)  not null,
  quantity int  not null,
  primary key(cart_id, isbn),
  foreign key(cart_id) references SHOPPING_CART(id),
  foreign key(isbn) references BOOK(isbn)
);

CREATE TABLE ORDER_PLACED(
  id int not null auto_increment,
  user_id int not null,
  total decimal(20,2) not null,
  primary key(id, user_id),
  foreign key(user_id) references USER(id)
);

CREATE TABLE ORDER_ITEM(
  order_id int not null,
  isbn varchar(50) not null,
  cost decimal(10,2) not null,
  quantity int not null,
  primary key(order_id, isbn),
  foreign key(order_id) references ORDER_PLACED(id),
  foreign key(isbn) references BOOK(isbn)
);
