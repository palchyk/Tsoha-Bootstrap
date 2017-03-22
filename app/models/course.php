<?php

class Course extends BaseModel {

    // Attribuutit
    public $id, $teacher_id, $name, $starts, $description, $ends, $publisher, $status;

    // Konstruktori
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name');
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
                'status' => $row['status']
            ));
        }

        return $courses;
    }
     public function update() {
      $query = DB::connection()->prepare('UPDATE course SET name=:name WHERE id=:id');
      $query->execute(array(
          'name' => $this->name,
          'id' => $this->id
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
   
    public function save() {
        // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
        $query = DB::connection()->prepare('INSERT INTO Course (name, publisher,status, starts,ends,description) VALUES (:name, :publisher,:status, :starts,:ends, :description) RETURNING id');
        // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
        $query->execute(array('name' => $this->name, 'publisher' => $this->publisher,'status' => $this->status, 'starts' => $this->starts, 'ends' => $this->ends, 'description' => $this->description));
        // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
        $row = $query->fetch();
        // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
        $this->id = $row['id'];
    }

}
