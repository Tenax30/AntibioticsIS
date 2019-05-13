CREATE TABLE elements(id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
	name TEXT NOT NULL, type VARCHAR(50) NOT NULL,
	toxity DECIMAL(3,2), activity DECIMAL(2,2));

INSERT INTO elements VALUES(1, 'Nystatin', 'Полиен', 0.0, 0.0);

SELECT * FROM elements;