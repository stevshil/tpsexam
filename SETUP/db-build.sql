/* Script to build the database schema */

create database IF NOT EXISTS tpsexam;

use tpsexam;

-- create user 'TPSADMIN'@'%' IDENTIFIED BY 'TPSPASSWORD';
-- create user 'TPSADMIN'@'localhost' IDENTIFIED BY 'TPSPASSWORD';

GRANT ALL PRIVILEGES ON tpsexam.* TO 'TPSADMIN'@'%' IDENTIFIED BY 'TPSPASSWORD';
GRANT ALL PRIVILEGES ON tpsexam.* TO 'TPSADMIN'@'localhost' IDENTIFIED BY 'TPSPASSWORD';

create table IF NOT EXISTS users (
	UserID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	LoginID VARCHAR(20) NOT NULL,
	CompanyName VARCHAR(180) NULL,
	FullName VARCHAR(180) NOT NULL,
	Address1 VARCHAR(150) NULL,
	Address2 VARCHAR(150) NULL,
	Address3 VARCHAR(150) NULL,
	TownCity VARCHAR(150) NULL,
	County VARCHAR(150) NULL,
	Country VARCHAR(4) NOT NULL,
	Postcode VARCHAR(10) NOT NULL,
	Phone VARCHAR(25) NULL,
	Email VARCHAR(150) NOT NULL,
	Inactive CHAR(1) NULL,
	Admin CHAR(1) NOT NULL DEFAULT '0',
	AddedDate DATETIME NOT NULL,
	AddedBy BIGINT UNSIGNED NOT NULL,
	PRIMARY KEY (UserID)
);

create table IF NOT EXISTS shadow (
	UserID BIGINT UNSIGNED NOT NULL,
	Password VARCHAR(60) NOT NULL,
	Locked CHAR(1) NULL,
	ExpireDate DATETIME NULL,
	LastLogon DATETIME NULL,
	LastLogoff DATETIME NULL,
	FOREIGN KEY (UserID) REFERENCES users(UserID) ON UPDATE CASCADE,
	PRIMARY KEY(UserID)
);

create table IF NOT EXISTS questions (
	QID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	Question LONGTEXT NOT NULL,
	Added DATETIME NOT NULL,
	AddedBy	BIGINT UNSIGNED NOT NULL,
	FOREIGN KEY (AddedBy) REFERENCES users(UserID),
	PRIMARY KEY (QID)
);

create table IF NOT EXISTS answers (
	AID VARCHAR(50) NOT NULL UNIQUE,
	QID BIGINT UNSIGNED NOT NULL,
	Correct CHAR(1) NOT NULL DEFAULT '0',
	AnswerText LONGTEXT NOT NULL,
	Added DATETIME NOT NULL,
	AddedBy	BIGINT UNSIGNED NOT NULL,
	FOREIGN KEY (QID) REFERENCES questions(QID),
	FOREIGN KEY (AddedBy) REFERENCES users(UserID),
	PRIMARY KEY (AID,QID)
);

create table IF NOT EXISTS testQHistory (
	TestID varchar(50) NOT NULL PRIMARY KEY,
	TestDate DATETIME NOT NULL,
	RequestedBy BIGINT UNSIGNED NOT NULL,
	RequestedDate DATETIME NOT NULL,
	NumTakers SMALLINT UNSIGNED NULL,
	NumQuestions SMALLINT UNSIGNED NULL,
	FOREIGN KEY (RequestedBy) REFERENCES users(UserID)
);

create table IF NOT EXISTS testQuestions (
	TestID varchar(50) NOT NULL,
	QID BIGINT UNSIGNED NOT NULL,
	OptionLetter CHAR(1) NOT NULL,
	Correct CHAR(1) NOT NULL,
	Mark SMALLINT NOT NULL DEFAULT 1,
	FOREIGN KEY (QID) REFERENCES questions(QID),
	PRIMARY KEY (TestID,QID)
);

create table IF NOT EXISTS testAnswers (
	TestID VARCHAR(50) NOT NULL,
	QID BIGINT UNSIGNED NOT NULL,
	UserID BIGINT UNSIGNED NOT NULL,
	AnswerLetter CHAR(1),
	FOREIGN KEY (TestID) REFERENCES testQuestions(TestID),
	FOREIGN KEY (QID) REFERENCES questions(QID),
	FOREIGN KEY (UserID) REFERENCES users(UserID),
	PRIMARY KEY (TestID,QID,UserID)
);

create table IF NOT EXISTS testAnswersWritten (
	TestID VARCHAR(50) NOT NULL,
	QID BIGINT UNSIGNED NOT NULL,
	UserID BIGINT UNSIGNED NOT NULL,
	AnswerText LONGTEXT,
	FOREIGN KEY (TestID) REFERENCES testQuestions(TestID),
	FOREIGN KEY (QID) REFERENCES questions(QID),
	FOREIGN KEY (UserID) REFERENCES users(UserID),
	PRIMARY KEY (TestID,QID,UserID)
);

create table IF NOT EXISTS categories (
	CatID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	CategoryName VARCHAR(150) NOT NULL,
	DateAdded DATETIME NOT NULL,
	AddedBy BIGINT UNSIGNED NOT NULL,
	PRIMARY KEY(CatID)
);

create table IF NOT EXISTS questionCategory (
	QID BIGINT UNSIGNED NOT NULL,
	CategoryID BIGINT UNSIGNED NOT NULL,
	FOREIGN KEY (QID) REFERENCES questions(QID),
	FOREIGN KEY (CategoryID) REFERENCES categories(CatID),
	PRIMARY KEY (QID,CategoryID)
);

-- Populate some tables
INSERT INTO users (LoginID,FullName,Email,Admin,AddedDate,AddedBy) VALUES ('Admin','System Administrator','admin@localhost.localdomain',1,Now(),1);
INSERT INTO shadow (UserID,Password) VALUES (1,PASSWORD('admin'));
INSERT INTO categories (CategoryName,DateAdded,AddedBy) VALUES('Linux',Now(),1);
INSERT INTO categories (CategoryName,DateAdded,AddedBy) VALUES('LPIC',Now(),1);
INSERT INTO categories (CategoryName,DateAdded,AddedBy) VALUES('Programming',Now(),1);
INSERT INTO categories (CategoryName,DateAdded,AddedBy) VALUES('Perl',Now(),1);
INSERT INTO categories (CategoryName,DateAdded,AddedBy) VALUES('Python',Now(),1);
INSERT INTO categories (CategoryName,DateAdded,AddedBy) VALUES('Shell Scripting',Now(),1);
INSERT INTO categories (CategoryName,DateAdded,AddedBy) VALUES('Java',Now(),1);
