<?php

class UserController extends BaseController {
    
     public static function store() {
        $params = $_POST;
        $attributes = array(
            'username' => $params['username'],
            'password' => $params['password']
        );
        $student = new Student($attributes);
        $errors = $student->errors();
       
        if (count($errors) == 0) {
            $student->save();        
            Redirect::to('/user/login', array('message' => 'Rekisteröidyit onnistuneesti, ' . $params['username'], 'username' => $params['username']));
        } else {
            Redirect::to('/user/register', array('errors' => $errors, 'attributes' => $attributes));
        }
    } 
    public static function login() {
        View::make('user/login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $student = Student::authenticate($params['username'], $params['password']);

        if (!$student) {
            View::make('user/login.html', array('message' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
             $_SESSION['student'] = $student->id;

            $_SESSION['username'] = $student->username;

            Redirect::to('/', array('message' => 'Tervetuloa ' . $student->username . '!'));
        }
    }
     public static function handle_registration() {
        $params = $_POST;
        Kint::dump($params);
        $user = Student::save($params['username'], $params['password']);
        Kint::dump($student);
        if (!$student) {
            View::make('account/register.html', array('errors' => array('Käyttäjätunnus on jo varattu!')));
        } else {
            $_SESSION['student'] = $student->id;
            Redirect::to('/', array('message' => 'Registered user ' . $student->username . '.'));
        }
    }
     public static function register() {
        View::make('user/register.html');
    }
     public static function logout(){
      $_SESSION['student'] = null;
      Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));
    }

}
