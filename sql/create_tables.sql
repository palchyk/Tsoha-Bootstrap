CREATE TABLE Student(
  id SERIAL PRIMARY KEY, 
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL
);

CREATE TABLE Course(
    id SERIAL PRIMARY KEY,
    teacher_id INTEGER REFERENCES Student(id), -- Viiteavain Student-tauluun
    name varchar(50) NOT NULL,
    description varchar(400),
    starts DATE,
    url varchar(200)  ,
    ends DATE,   
    publisher varchar(50),
    status integer 
  
  
);
CREATE TABLE Participant(
    pid Serial PRIMARY KEY,
    participant_id INTEGER REFERENCES Student(id),
    course_id INTEGER REFERENCES Course(id),
    fullname varchar(80),
    studentnumber varchar(20)
);
