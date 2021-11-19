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

create table PUBLISHER(
id int not null auto_increment,
name varchar(50) not null,
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

INSERT INTO `USER` (`username`, `type`, `pin`, `first_name`, `last_name`, `street`, `city`, `state`, `zip`, `credit_card_type`, `credit_card_no`, `credit_card_exp`) VALUES
('goodusername', 'R', 1234, 'Mary', 'Smith', '1010 Street Ave', 'Ypsilanti', 'Michigan', '48195', 'Visa', '1111000011110000', '2026-10-10'),
('bookworm', 'R', 5548, 'Avery', 'Ross', '852 Boulevard Dr', 'Toledo', 'Ohio', '43601', 'Discover', '111100001111', '2024-06-10'),
('catdad', 'R', 6679, 'Jose', 'Garcia', '987 Camino St', 'Chicago', 'Illinois', '85009', 'MasterCard', '1234567876543210', '2022-02-22'),
('admin1', 45678, null, null, null, null, null, null, null, null, null, null),
('admin2', 12345, null, null, null, null, null, null, null, null, null, null),
('admin3', 96385, null, null, null, null, null, null, null, null, null, null);

INSERT INTO `AUTHOR` (`id`, `first_name`, `last_name`) VALUES
('James', 'Clear'),
('Markus', 'Zusak'),
('Thomas', 'Byrom'),
('Edwin', 'Abbott'),
('Ryder', 'Carroll'),
('John', 'Yates PhD'),
('Barbara', 'Oakley PhD'),
('Bessel', 'van der Kolk MD'),
('Stephen', 'Chbosky');

INSERT INTO `CATEGORY` (`id`, `name`) VALUES
('Nonfiction'),
('Fiction'),
('Young Adult'),
('Philosophy'),
('Psychology');

INSERT INTO `REVIEW` (`id`, `isbn`, `description`) VALUES
('9780385754729', 'I don\'t usually write review for books but above all the books I have read I can hands down say this is my favourite book I truly can\'t fault it i loved the story, how and when it\'s set and by far the POV from death it really is masterfully written and if anybody can recommend a book like it I\'m open to suggestions.'),
('9780385754729', 'A wonderful story of youthful curiosity, tenacity and daring set against a backdrop of a society that controlled the minds and actions of its citizens with fear.'),
('9780385754729', 'Such a great book! I love historicals. This one was set in Nazi Germany. So many of those stories are told from a Jewish person\'s point of view, but not this one. The main character is a young German girl, whose Communist father is taken away and her mother sends her to safety in another town. Took me a little while to get into the formatting, all the capital, bold type here and there. And I finally searched online to verify that yes, the narrator was Death. But once you get past those two things, the story is gripping, compelling. I loved this book.'),
('9780525533337', 'I love this book! It\'s been so helpfull! I\'ll use some of the ideas in my journal. Thanks to the inventor and writer of this book Ryder Carroll.'),
('9780525533337', 'As someone who has repeatedly failed to keep a traditional planner/journal, I appreciate the flexibility of the Bullet Journal method and am looking forward to developing the practice this year.'),
('9780525533337', 'I listened to this on audiobook as well as read the physical book. Really enjoyed it, it\'s a great system and I love how much the book talks about reflection, goals, and that it\'s about using the system to help you in your goals. It\'s very easy to get distracted by the beautiful layouts out there, but the core of the system is about function. Helping you know where you are and get to where you want to be. So good!');


