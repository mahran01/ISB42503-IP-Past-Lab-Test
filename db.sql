CREATE DATABASE IF NOT EXISTS diploma_course;

USE diploma_course;

CREATE TABLE IF NOT EXISTS courses (
    no INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(200) NOT NULL,
    credit INT(11) NOT NULL,
    semoffer INT(11) NOT NULL
);