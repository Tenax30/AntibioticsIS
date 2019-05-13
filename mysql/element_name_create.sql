CREATE TABLE names (
number INT NOT NULL, name VARCHAR(50) NOT NULL PRIMARY KEY
);

ALTER TABLE elements ADD (formula VARCHAR(20),
smiles VARCHAR(50), description TEXT);

CREATE TABLE element_name(element_id INT NOT NULL,
element_name VARCHAR(50) NOT NULL,
PRIMARY KEY(element_id, element_name));

SELECT n.name FROM elements e INNER JOIN element_name en ON en.element_id=e.id INNER JOIN names n ON n.name=en.element_name;