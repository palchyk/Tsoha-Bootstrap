<?php

class Participants extends BaseModel {

    public $fullname, $studentnumber, $participant_id;

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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Participants (praticipant_id,fullname,studentnumber) '
                . 'VALUES (:participant_id,:fullname,:studentnumber) RETURNING id');
        $query->execute(array('participant_id' => $this->participant_id, 'fullname' => $this->fullname,
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
