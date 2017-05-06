<?php

class Course extends BaseModel {

    // Attribuutit
    public $id,
            $teacher_id,
            $url, $name, $starts, $description, $ends, $publisher,
            $status;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_publisher', 'validate_status','validate_starts','validate_ends',
            'validate_description'
             );
    }

    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Course (name,'
                . 'url,description,'
                . 'teacher_id,'
                . ' publisher,status, starts,ends)'
                . ' VALUES (:name,:url,:description,'
                . ':teacher_id,'
                . ' :publisher,:status, :starts,:ends) RETURNING id');

        $query->execute(array(
            'teacher_id' => $this->teacher_id,
            'name' => $this->name,
            'url' => $this->url,
            'description' => $this->description, 'publisher' => $this->publisher,
            'status' => $this->status, 'starts' => $this->starts, 'ends' => $this->ends));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->name) < 3) {
            $errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
        }
        if (strlen($this->name) > 50) {
            $errors[] = 'Nimen pituuden tulee olla enintään viisikymmentä merkkiä!';
        }

        return $errors;
    }
    public function validate_publisher() {
        $errors = array();
        if ($this->publisher == '' || $this->publisher == null) {
            $errors[] = 'Pitäjän nimi ei saa olla tyhjä!';
        }
        if (strlen($this->publisher) < 10) {
            $errors[] = 'Pitäjän nimen pituuden tulee olla vähintään kymmenen merkkiä!';
        }
        if (strlen($this->publisher) > 50) {
            $errors[] = 'Pitäjän nimen pituuden tulee olla enintään viisikymmentä merkkiä!';
        }

        return $errors;
    }

    public function validate_description() {
        $errors = array();
        if ($this->description == '' || $this->description == null) {
            $errors[] = 'Kuvaus ei saa olla tyhjä!';
        }
        if (strlen($this->description) < 10) {
            $errors[] = 'Kuvauksen pituuden tulee olla vähintään kymmenen merkkiä!';
        }
        if (strlen($this->description) > 400) {
            $errors[] = 'Kuvauksen pituuden tulee olla enintään neljäsataa merkkiä!';
        }

        return $errors;
    }

    

    public function validate_status() {
        $errors = array();
        if (($this->status) < 0) {
            $errors[] = 'Tila ei saa olla pienempi kuin nolla!';
        }
        if ($this->status > 500) {
            $errors[] = 'Tila ei saa olla yli 500!';
        }
        if ($this->status == '') {
            $errors[] = 'Tilassa on oltava sisältöä!';
        }
        if (is_numeric($this->status) == false) {
            $errors[] = 'Tilan on oltava numero!';
        }

        return $errors;
    }

    public function validate_starts() {
        $errors = array();
        $test_date = $this->starts;
        $test_arr = explode('-', $test_date);
        if (count($test_arr) == 3&& is_numeric($test_arr[1])
                && is_numeric($test_arr[2])
                && is_numeric($test_arr[0])) {
            if (checkdate( $test_arr[1],$test_arr[2], $test_arr[0]) ) {
                
            } else {
                $errors[] = 'Alkupäivämäärässä on vika!';
            }
        } else {
            $errors[] = 'Alkupäivämäärässä on vika!';
        }return $errors;
    }
    public function validate_ends() {
        $errors = array();
        $test_date = $this->ends;
        $test_arr = explode('-', $test_date);
        if (count($test_arr) == 3&& is_numeric($test_arr[1])
                && is_numeric($test_arr[2])
                && is_numeric($test_arr[0])) {
            
            if (checkdate( $test_arr[1],$test_arr[2], $test_arr[0])) {
                
            } else {
                $errors[] = 'Loppupäivämäärässä on vika!';
            }
        } else {
            $errors[] = 'Loppupäivämäärässä on vika!';
        }return $errors;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Course');
        $query->execute();
        $rows = $query->fetchAll();
        $courses = array();
        foreach ($rows as $row) {
            $courses[] = new Course(array(
                'id' => $row['id'],
                'teacher_id' => $row['teacher_id'],
                'name' => $row['name'],
                'starts' => $row['starts'],
                'description' => $row['description'],
                'ends' => $row['ends'],
                'publisher' => $row['publisher'],
                'url' => $row['url'],
                'status' => $row['status']
            ));
        }

        return $courses;
    }

    public function join() {
        $query = DB::connection()->prepare('UPDATE course SET status=:status-1 WHERE id=:id');
        $query->execute(array('status' => $this->status, 'id' => $this->id));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE course SET url=:url,'
                . 'starts=:starts,ends=:ends,publisher=:publisher,name=:name,'
                . 'description=:description,status=:status WHERE id=:id');

        $query->execute(array(
            'name' => $this->name,
            'description' => $this->description,
            'id' => $this->id,
            'status' => $this->status,
            'starts' => $this->starts,
            'ends' => $this->ends,
            'url' => $this->url,
            'publisher' => $this->publisher
        ));
    }

    public static function check_joined($id, $cid) {
        $query = DB::connection()->prepare('SELECT * FROM Participant WHERE participant_id = :id AND course_id = :cid LIMIT 1');
        $query->execute(array('id' => $id, 'cid' => $cid));
        $row = $query->fetch();
        if ($row) {
            return false;
        } else
            return true;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Course WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $course = new Course(array(
                'id' => $row['id'],
                'teacher_id' => $row['teacher_id'],
                'name' => $row['name'],
                'starts' => $row['starts'],
                'description' => $row['description'],
                'ends' => $row['ends'],
                'publisher' => $row['publisher'],
                'url' => $row['url'],
                'status' => $row['status']
            ));

            return $course;
        }

        return null;
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM participant WHERE course_id=:id');
        $query->execute(array('id' => $this->id));
        $query = DB::connection()->prepare('DELETE FROM course WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }

}
