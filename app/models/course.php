<?php

class Course extends BaseModel{
  // Attribuutit
  public $id, $teacher_id, $name, $starts, $description, $ends, $publisher, $status;
  // Konstruktori
  public function __construct($attributes){
    parent::__construct($attributes);
    $course1 = new Course(array('id' => 1, 'name' => 'Opiskelijan kokkikurssi', 'description' => 'Arrow to the knee'));
    echo $course1->name;
  }
  
   
  public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
    $query = DB::connection()->prepare('SELECT * FROM Course');
    // Suoritetaan kysely
    $query->execute();
    // Haetaan kyselyn tuottamat rivit
    $rows = $query->fetchAll();
    $courses = array();

    // Käydään kyselyn tuottamat rivit läpi
    foreach($rows as $row){
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
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
  public static function find($id){
    $query = DB::connection()->prepare('SELECT * FROM Course WHERE id = :id LIMIT 1');
    $query->execute(array('id' => $id));
    $row = $query->fetch();

    if($row){
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
}