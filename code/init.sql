CREATE DATABASE IF NOT EXISTS ${DB_NAME};

USE ${DB_NAME};

DROP TABLE users;
DROP TABLE user_rules;

CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50),
	user_lastname VARCHAR(50),
    email VARCHAR(100) UNIQUE,
	user_birthday_timestamp VARCHAR(20),
    password_hash VARCHAR(200),
    csrf_token VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS user_rules (
    id_user INT,
    rule VARCHAR(10)
);
