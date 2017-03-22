CREATE TABLE Student(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  username varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  password varchar(50) NOT NULL
);

CREATE TABLE Course(
  id SERIAL PRIMARY KEY,
  teacher_id INTEGER REFERENCES Student(id), -- Viiteavain Player-tauluun
  name varchar(50) NOT NULL,
  starts DATE,
  description varchar(400),
  ends DATE,   
  publisher varchar(50),
  status integer 
  
  
);-- Lisää CREATE TABLE lauseet tähän tiedostoon
