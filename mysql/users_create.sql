CREATE TABLE users 
(id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
login VARCHAR(20) NOT NULL ,
email VARCHAR(100) NOT NULL ,
hash VARCHAR(100) NOT NULL ,
salt VARCHAR(20) NOT NULL);

INSERT INTO users VALUES
(1, 'bob', 'mrbord30@yandex.ru', 'asdasd', 'asdasdas');

SELECT * FROM users;