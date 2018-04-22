CREATE TABLE theaters (
  theater_id int UNIQUE NOT NULL AUTO_INCREMENT,
  theater_name varchar(50) NOT NULL,
  seats_per_theater int NOT NULL,
  zipcode int NOT NULL,
  price float DEFAULT 10.00,
  PRIMARY KEY (theater_id)
);

CREATE TABLE movies (
  movie_id int UNIQUE NOT NULL AUTO_INCREMENT,
  theater_id int NOT NULL,
  movie_title varchar(50) NOT NULL,
  PRIMARY KEY (movie_id),
  FOREIGN KEY (theater_id) REFERENCES theaters(theater_id)
);

CREATE TABLE movies_theaters (
  movie_id int NOT NULL,
  theater_id int NOT NULL,
  seats_purchased int NOT NULL DEFAULT 0,
  FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
  FOREIGN KEY (theater_id) REFERENCES theaters(theater_id)
);

CREATE TABLE tickets (
  ticket_id int UNIQUE NOT NULL AUTO_INCREMENT,
  movie_id int NOT NULL,
  theater_id int NOT NULL,
  price float NOT NULL,
  purchase_date datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ticket_id),
  FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
  FOREIGN KEY (theater_id) REFERENCES theaters(theater_id)
);

CREATE TABLE forums (
  forum_id int UNIQUE NOT NULL AUTO_INCREMENT,
  forum_name varchar(100) UNIQUE NOT NULL,
  PRIMARY KEY (forum_id)
);

CREATE TABLE threads (
  thread_id int UNIQUE NOT NULL AUTO_INCREMENT,
  forum_id int NOT NULL,
  post_content varchar(5000),
  PRIMARY KEY (thread_id),
  FOREIGN KEY (forum_id) REFERENCES forums(forum_id)
);

INSERT INTO theaters (theater_id, theater_name, seats_per_theater, zipcode)
VALUES
(1, 'AMC River East', 100, 60611),
(2, 'Regal Webster Place 11', 100, 60614),
(3, 'ShowPlace ICON Theaters at Roosevelt', 100, 60605),
(4, 'AMC DINE-IN Block 37', 100, 60602);

INSERT INTO movies (movie_id, movie_title, duration)
VALUES
(1, 'Ready Player One', 140),
(2, 'Black Panther', 134),
(3, 'A Quiet Place', 90),
(4, 'Blockers', 102);

INSERT INTO movies_theaters (theater_id, movie_id, seats_purchased)
VALUES
(1, 1, 0),
(1, 2, 0),
(1, 3, 0),
(1, 4, 0),
(2, 1, 0),
(2, 2, 0),
(2, 3, 0),
(2, 4, 0),
(3, 1, 0),
(3, 2, 0),
(3, 3, 0),
(3, 4, 0),
(4, 1, 0),
(4, 2, 0),
(4, 3, 0),
(4, 4, 0);
