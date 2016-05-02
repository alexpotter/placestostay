DROP TABLE IF EXISTS api;
DROP TABLE IF EXISTS bookings;
DROP table IF EXISTS rooms;
DROP TABLE IF EXISTS locations;
DROP TABLE IF EXISTS users;

CREATE TABLE users
(
  ID          int NOT NULL AUTO_INCREMENT,
  first_name  varchar (255),
  last_name   varchar (255),
  email       varchar (255),
  password    varchar (255),
  user_type   int,
  PRIMARY KEY (ID),
  UNIQUE (email)
);

CREATE TABLE locations
(
  ID              int NOT NULL AUTO_INCREMENT,
  name            VARCHAR (255),
  lat             VARCHAR (255),
  lng             VARCHAR (255),
  google_id       VARCHAR (255),
  street_number   int,
  address_line1   VARCHAR (255),
  town            VARCHAR (255),
  postcode        VARCHAR (255),
  country         VARCHAR (255),
  location_type   VARCHAR (255),
  belongs_to      int,
  PRIMARY KEY (ID),
  FOREIGN KEY (belongs_to) REFERENCES users(ID),
  UNIQUE (google_id)
);

CREATE TABLE rooms
(
  ID              int NOT NULL AUTO_INCREMENT,
  location_id     int,
  number_of_beds  int,
  price           int,
  PRIMARY KEY (ID),
  FOREIGN KEY (location_id) REFERENCES locations(ID)
);

CREATE TABLE bookings
(
  ID          int NOT NULL AUTO_INCREMENT,
  room_id     int,
  date_from   DATE,
  date_to     DATE,
  user_id     int,
  price_paid  int,
  PRIMARY KEY (ID),
  FOREIGN KEY (room_id) REFERENCES rooms(ID),
  FOREIGN KEY (user_id) REFERENCES users(ID)
);

CREATE TABLE api
(
  ID            int NOT NULL AUTO_INCREMENT,
  api_key       VARCHAR (15),
  user_id       int,
  PRIMARY KEY (ID),
  FOREIGN KEY (user_id) REFERENCES users(ID),
  UNIQUE (api_key)
);