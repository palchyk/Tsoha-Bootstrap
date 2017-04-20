<?php

class Course extends BaseModel {

    // Attribuutit
    public $id, $teacher_id, $url,  $name, $starts, $description, $ends,  $publisher,
           
            $status;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
    }
    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Course (name,'
                . 'url,'
                . 'description, publisher,status, starts,ends) VALUES (:name,'
                . ':url,'
                . ' :description, :publisher,:status, :starts,:ends) RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('name' => $this->name,
            'url' => $this->url,
            'description' => $this->description, 'publisher' => $this->publisher, 'status' => $this->status, 'starts' => $this->starts, 'ends' => $this->ends));
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

        return $errors;
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

    public function update() {
        $query = DB::connection()->prepare('UPDATE course SET url=:url,starts=:starts,ends=:ends,publisher=:publisher,name=:name,description=:description,status=:status WHERE id=:id');

        $query->execute(array(
           'name' => $this->name ,
           'description' => $this->description, 
            'id' => $this->id, 
          'status' => $this->status,
            'starts' => $this->starts,
            'ends' => $this->ends,
           'url' => $this->url,
            'publisher' => $this->publisher
        ));

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
        $query = DB::connection()->prepare('DELETE FROM course WHERE id=:id');
        $query->execute(array('id' => $this->id));
    }
//    public function join() {
//        $query = DB::connection()->prepare('INSERT INTO participants(studentsnumber,fullname) RETURNING id');
////        $query = DB::connection()->prepare('INSERT INTO course(students) VALUES WHERE id=:id');
//        $query->execute(array('studentsnumber' => $this->studentsnumber,'fullname' => $this->fullname));
//        $row = $query->fetch();
//        $this->id = $row['id'];
//    }
    

    

}
