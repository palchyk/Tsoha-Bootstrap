<?php

class Participant extends BaseModel {

    public $pid, $fullname, $studentnumber, $participant_id, $course_id;

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
        if (strlen($this->fullname) > 20) {
            $errors[] = 'Nimen pituuden tulee olla maksimissaan 20 merkkiä!';
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
        if (strlen($this->studentnumber) > 20) {
            $errors[] = 'Tunnuksen pituuden tulee olla maksimissaan 20 merkkiä!';
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
            $participant = Participant::find($row['participant_id']);
            $participants[] = array(
                'pid' => $row['pid'],
                'participant_id' => $row['participant_id'],
                'course_id' => $row['course_id'],
                'fullname' => $row['fullname'],
                'studentnumber' => $row['studentnumber'],
            );
        }
        return $participants;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Participant (participant_id,fullname,studentnumber,course_id) '
                . 'VALUES (:participant_id,:fullname,:studentnumber,:course_id) RETURNING pid');
        $query->execute(array('course_id' => $this->course_id, 'participant_id' => $this->participant_id, 'fullname' => $this->fullname,
            'studentnumber' => $this->studentnumber));
        $row = $query->fetch();
        $this->pid = $row['pid'];
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM participant WHERE pid=:pid');
        $query->execute(array('pid' => $this->pid));
    }

    public static function find($pid) {
        $query = DB::connection()->prepare('SELECT * FROM Participant WHERE pid = :pid LIMIT 1');
        $query->execute(array('pid' => $pid));
        $row = $query->fetch();

        if ($row) {
            $participant = new Participant(array(
                'pid' => $row['pid'],
                'participant_id' => $row['participant_id'],
                'course_id' => $row['course_id'],
                'fullname' => $row['fullname'],
                'studentnumber' => $row['studentnumber'],
            ));

            return $participant;
        } else {

            return null;
        }
    }

    public static function find_owner($pid) {
        $query = DB::connection()->prepare('SELECT * FROM Student WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $user = new Student(array(
                'id' => $row['id'],
                'username' => $row['username'],
                'password' => $row['password']
            ));
            return $user;
        }
        return null;
    }

}
