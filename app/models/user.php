<?php
  class User extends BaseModel {
    //Attribuutit
    public $id, $name, $password;
    //Konstruktori
    public function __construct($attributes) {
      parent::__construct($attributes);
      $this->validators = array(
          'validate_name',
          'validate_password'
      );
    }
    public static function authenticate($name, $password) {
      $query = DB::connection()->prepare('SELECT * FROM User WHERE name = :name AND password = :password LIMIT 1');
      $query->execute(array('name' => $name, 'password' => $password));
      $row = $query->fetch();
      if($row){
        // Käyttäjä löytyi, palautetaan löytynyt käyttäjä oliona
        $user = new User(array(
          'id' => $row['id'],
          'name' => $row['name'],
          'password' => $row['password'],
        ));
        return $user;
      }else{
        return null;
        // Käyttäjää ei löytynyt, palautetaan null
      }
    }
    public static function find($id) {
      $query = DB::connection()->prepare('SELECT * FROM User WHERE id = :id LIMIT 1');
      $query->execute(array('id' => $id));
      $row = $query->fetch();
      if($row) {
        $user = new User(array(
          'id' => $row['id'],
          'name' => $row['name'],
          'password' => $row['password']
        ));
        return $user;
      }
      return null;
    }
    
    public function save() {
      $query = DB::connection()->prepare('INSERT INTO User (name, password) VALUES (:name, :password) RETURNING id');
      $query->execute(array(
          'name' => $this->name,
          'password' => $this->password
      ));
      $row = $query->fetch();
      $this->id = $row['id'];
    }
    
    public function validate_nimi() {
      $errors = array();
      if ($this->name == '' || $this->name == null) {
        $errors[] = 'Käyttäjänimi puuttuu';
      }
      if (strlen($this->name) > 20) {
        $errors[] = 'Liian pitkä nimi (max 20 merkkiä)';
      }
      return $errors;
    }
    
    public function validate_salasana() {
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