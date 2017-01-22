CREATE TABLE Student(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  name varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  password varchar(50) NOT NULL
);

CREATE TABLE Course(
  id SERIAL PRIMARY KEY,
  teacher_id INTEGER REFERENCES Student(id), -- Viiteavain Player-tauluun
  name varchar(50) NOT NULL,
  status integer ,
  description varchar(400),  
  publisher varchar(50),
  starts DATE,
  ends DATE
);-- Lisää CREATE TABLE lauseet tähän tiedostoon
