-- Player-taulun testidata
INSERT INTO Student (name, password) VALUES ('Kalle', 'Kalle123'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
INSERT INTO Student (name, password) VALUES ('Henri', 'Henri123');
-- Game taulun testidata
INSERT INTO Course (name, description, starts, ends, publisher) 
VALUES ('Opiskelijan kokkikurssi', 'Kokataan!', '2017-11-11', '2017-11-18', 'Stan Fingery');-- Lisää INSERT INTO lauseet tähän tiedostoon
