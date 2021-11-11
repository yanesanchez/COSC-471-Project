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

CREATE TABLE CATEGORY(
  id int not null auto_increment,
  name varchar(50) not null,
  primary key(id)
);

CREATE TABLE AUTHOR(
  id int not null auto_increment,
  name varchar(50) not null,
  primary key(id)
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

CREATE TABLE USER(
  id int not null auto_increment,
  type varchar(5) not null,
   primary key(id)
);


CREATE TABLE TEMP_USER(
  id int not null,
  primary key(id),
  foreign key (id) references USER(id)
);


CREATE TABLE ADMIN(
  id int not null,
  username varchar(50) not null,
  pin int not null, primary key(id),
  foreign key(id) references USER(id)
);

CREATE TABLE REGISTERED_USER(
  id int not null auto_increment,
  username VARCHAR (50) NOT NULL,
  pin INT NOT NULL,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  zip CHAR(5) NOT NULL,
  credit_card_type VARCHAR(10) NOT NULL,
  credit_card_no VARCHAR(16) NOT NULL,
  credit_card_exp DATE NOT NULL,
  primary key (id, username),
  foreign key(id) references USER(id)
);

CREATE TABLE SHOPPING_CART(
  id int not null auto_increment,
  user_id int not null, total decimal(50,2) DEFAULT 0.00,
  primary key(id, user_id),
  foreign key(user_id) references USER(id)
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
  primary key(id, isbn),
  foreign key(order_id) references ORDER_PLACED(id),
  foreign key(isbn) references BOOK(isbn)
);
