---
---
--- Eutsiv Information Technology http://www.eutsiv.com.br
--- Eutsiv :: KingFisher (Quota Manager)
---
--- SGBD: PostgreSQL
---


-- Settings
CREATE TABLE settings (
	price_gray NUMERIC(10, 4) NOT NULL,
	price_color NUMERIC(10, 4) NOT NULL,
	language varchar(5) NOT NULL
);

-- Settings Default
INSERT INTO settings(price_gray, price_color, language) values(0.0000, 0.0000, 'en_US');


-- Sectors sequence
CREATE SEQUENCE sectors_seq START 1 ;

-- Sectors table
CREATE TABLE sectors ( 
	id INTEGER PRIMARY KEY DEFAULT nextval('sectors_seq'),
	sectorname varchar(50) UNIQUE NOT NULL
);

-- Sector Default
INSERT INTO sectors(sectorname) values('default');


-- Costscenter sequence
CREATE SEQUENCE costscenter_seq START 1 ;

-- Costscenter table
CREATE TABLE costscenter ( 
	id INTEGER PRIMARY KEY DEFAULT nextval('costscenter_seq'),
	costcentername varchar(50) UNIQUE NOT NULL
);

-- Costcenter Default
INSERT INTO costscenter(costcentername) values('default');


-- Users sequence
CREATE SEQUENCE users_seq START 1 ;

-- Users table
CREATE TABLE users ( 
	id INTEGER PRIMARY KEY DEFAULT nextval('users_seq'),
	username varchar(50) UNIQUE NOT NULL,
	sectors_id INTEGER NOT NULL,
	costscenter_id INTEGER NOT NULL,
	FOREIGN KEY (sectors_id) REFERENCES sectors (id),
	FOREIGN KEY (costscenter_id) REFERENCES costscenter (id)
);


-- Printers sequence
CREATE SEQUENCE printers_seq START 1 ;

-- Printers table
CREATE TABLE printers ( 
	id INTEGER PRIMARY KEY DEFAULT nextval('printers_seq'),
	printername varchar(50) UNIQUE NOT NULL
);


-- Paper Formats sequence
CREATE SEQUENCE paperformats_seq START 1 ;

-- Paper Formats table
CREATE TABLE paperformats ( 
	id INTEGER PRIMARY KEY DEFAULT nextval('paperformats_seq'),
	paperformatname varchar(20) UNIQUE NOT NULL,
	page_price_percent INTEGER NOT NULL DEFAULT 0
);

-- Most common paper formats
INSERT INTO paperformats(paperformatname, page_price_percent) VALUES('A3', 100);
INSERT INTO paperformats(paperformatname) VALUES('A4');
INSERT INTO paperformats(paperformatname) VALUES('A5');
INSERT INTO paperformats(paperformatname) VALUES('Executive');
INSERT INTO paperformats(paperformatname) VALUES('Legal');
INSERT INTO paperformats(paperformatname) VALUES('Letter');


-- Print queue table
CREATE TABLE printqueue (
	job_date date NOT NULL,
	job_time time NOT NULL,
	job_id INTEGER NOT NULL,
	job_status varchar(1) NOT NULL,
	backends_dir varchar(50) NOT NULL,
	backend varchar(20) NOT NULL,
	device_uri varchar(50) NOT NULL,
	host varchar(255) NOT NULL,
	printername varchar(50) NOT NULL,
	username varchar(50) NOT NULL,
	title TEXT,
	colormode varchar(1) NOT NULL,
	duplex varchar(1) NOT NULL,
	job_size varchar(8),
	copies INTEGER,
	number_of_pages INTEGER,
	total_pages INTEGER,
	paperformatname varchar(20) NOT NULL,
	job_options varchar(100) NOT NULL,
	doc_path varchar(255) NOT NULL
);


-- Print logs table
CREATE TABLE printlogs ( 
	job_date date NOT NULL,
	job_time time NOT NULL,
	host varchar(255) NOT NULL,
	users_id INTEGER NOT NULL,
	sectors_id INTEGER NOT NULL,
	costscenter_id INTEGER NOT NULL,
        printers_id INTEGER NOT NULL,
	paperformats_id INTEGER NOT NULL,
	title TEXT,
	job_size varchar(8),
	colormode varchar(1) NOT NULL,
	copies INTEGER,
	number_of_pages INTEGER,
	total_pages INTEGER,
	price NUMERIC(10, 4) NOT NULL,
	FOREIGN KEY (users_id) REFERENCES users (id),
	FOREIGN KEY (sectors_id) REFERENCES sectors (id),
	FOREIGN KEY (costscenter_id) REFERENCES costscenter (id),
	FOREIGN KEY (printers_id) REFERENCES printers (id),
	FOREIGN KEY (paperformats_id) REFERENCES paperformats (id)
);	


-- Users (Web Admin) sequence
CREATE SEQUENCE users_webadm_seq START 1 ;

-- Users Web Administration Table
CREATE TABLE users_webadm (
  id INTEGER PRIMARY KEY DEFAULT nextval('users_webadm_seq'),
  login varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  name varchar(50) NOT NULL,
  email varchar(255) default NULL,
  datetime timestamp NOT NULL
);

-- Admin User - Login: admin  Password: kingfisher
INSERT INTO users_webadm(login, password, name, datetime) VALUES('admin', 'a577cb9aa0be8ef12005bdbbc65bf3685a5f687d', 'Administrator', localtimestamp(0));

