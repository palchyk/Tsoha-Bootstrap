<?php
  class Student extends BaseModel {
    //Attribuutit
    public $id, $username, $password;
    //Konstruktori
    public function __construct($attributes) {
      parent::__construct($attributes);
      $this->validators = array(
          'validate_username',
          'validate_password'
      );
    }
    public static function authenticate($username, $password) {
      $query = DB::connection()->prepare('SELECT * FROM Student WHERE username = :username AND password = :password LIMIT 1');
      $query->execute(array('username' => $username, 'password' => $password));
      $row = $query->fetch();
      if($row){
        // Käyttäjä löytyi, palautetaan löytynyt käyttäjä oliona
        $student = new Student(array(
          'id' => $row['id'],
          'username' => $row['username'],
          'password' => $row['password'],
        ));
        return $student;
      }else{
        return null;
        // Käyttäjää ei löytynyt, palautetaan null
      }
    }
    public static function find($id) {
      $query = DB::connection()->prepare('SELECT * FROM Student WHERE id = :id LIMIT 1');
      $query->execute(array('id' => $id));
      $row = $query->fetch();
      if($row) {
        $user = new Student(array(
          'id' => $row['id'],
          'username' => $row['username'],
          'password' => $row['password']
        ));
        return $user;
      }
      return null;
    }
    
    public function save() {
      $query = DB::connection()->prepare('INSERT INTO student (username, password) VALUES (:username, :password) RETURNING id');
      $query->execute(array(
          'username' => $this->username,
          'password' => $this->password
      ));
      $row = $query->fetch();
      $this->id = $row['id'];
    }
    
    public function validate_username() {
      $errors = array();
      if ($this->username == '' || $this->username == null) {
        $errors[] = 'Käyttäjänimi puuttuu';
      }
      if (strlen($this->username) > 20) {
        $errors[] = 'Liian pitkä nimi (max 20 merkkiä)';
      }
      return $errors;
    }
    
    public function validate_password() {
      $errors = array();
      if ($this->password == '' || $this->password == null) {
        $errors[] = 'Salasana puuttuu';
      }
      if (strlen($this->password) > 50) {
        $errors[] = 'Liian pitkä salasana (max 50 merkkiä)';
      }
      return $errors;
    }
  }