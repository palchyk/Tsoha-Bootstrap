-- Player-taulun testidata
INSERT INTO Student (username, password) VALUES ('Kalle', 'Kalle123'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
INSERT INTO Student (username, password) VALUES ('Henri', 'Henri123');
-- Game taulun testidata
INSERT INTO Course (id, teacher_id, name, starts,description,ends, publisher,status) 
VALUES (1, 1, 'Kokkikurssi', '2017-11-11','Kokataan','2017-11-18', 'Stan Fingery',1);-- Lisää INSERT INTO lauseet tähän tiedostoon
