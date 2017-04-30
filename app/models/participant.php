<?php

class Participant extends BaseModel {

    public $fullname, $studentnumber, $participant_id, $course_id, $status;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_studentnumber', 'validate_fullname');
    }

    public function validate_fullname() {
        $errors = array();
        if ($this->fullname == '' || $this->fullname == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->fullname) < 3) {
            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
        }

        return $errors;
    }

    public function validate_studentnumber() {
        $errors = array();
        if ($this->studentnumber == '' || $this->studentnumber == null) {
            $errors[] = 'Tunnus ei saa olla tyhjä!';
        }
        if (strlen($this->studentnumber) < 5) {
            $errors[] = 'Tunnuksen pituuden tulee olla vähintään viisi merkkiä!';
        }

        return $errors;
    }


    public static function find_participants($id) {
        //Tietokantayhteyden alustaminen
        $query = DB::connection()->prepare('SELECT * FROM Participant WHERE course_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $participants = array();
        $participant = null;

        foreach ($rows as $row) {
            //käyttäjänimen hakeminen show-näkymää varten
            $participant = Student::find($row['participant_id']);         
            $participants[] = array(
                'participant_id' => $row['participant_id'],
                'course_id' => $row['course_id'],
                'fullname' => $row['fullname'],
                'studentnumber' => $row['studentnumber'],
             
            );
        }
    }
//     public static function find($id) {
//        $query = DB::connection()->prepare('SELECT * FROM Participant WHERE id = :id LIMIT 1');
//        $query->execute(array('id' => $id));
//        $row = $query->fetch();
//        if ($row) {
//            $participant= new Participant(array(
//                'id' => $row['id'],
//                'fullname' => $row['fullname'],
//                'studentnumber' => $row['studentnumber']
//            ));
//            return $participant;
//        }
//        return null;
//    }

    public function save() {
//        $query = DB::connection()->prepare('UPDATE course SET status=:status-1 WHERE id=:course_id');
//        $query->execute(array('status' => $this->status));
        $query = DB::connection()->prepare('INSERT INTO Participant (participant_id,fullname,studentnumber,course_id) '
                . 'VALUES (:participant_id,:fullname,:studentnumber,:course_id) RETURNING id');
        $query->execute(array('course_id' => $this->course_id, 'participant_id' => $this->participant_id, 'fullname' => $this->fullname,
            'studentnumber' => $this->studentnumber));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

//    public function join() {
//        $query = DB::connection()->prepare('INSERT INTO Participants(studentnumber,fullname) RETURNING id');
//        $query->execute(array('studentnumber' => $this->studentnumber, 'fullname' => $this->fullname));
//        $row = $query->fetch();
//        $this->id = $row['id'];
//    }
}
