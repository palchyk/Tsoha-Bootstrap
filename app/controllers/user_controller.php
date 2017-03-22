<?php

class UserController extends BaseController {
    
     public static function store() {
        $params = $_POST;
        $attributes = array(
            'username' => $params['username'],
            'password' => $params['password']
        );
        $user = new Student($attributes);
        $errors = $user->errors();
       
        if (count($errors) == 0) {
            $user->save();        
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
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
             $_SESSION['student'] = $student->id;

            $_SESSION['username'] = $student->username;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $student->username . '!'));
        }
    }
     public static function register() {
        View::make('user/register.html');
    }
     public static function logout(){
      $_SESSION['student'] = null;
      Redirect::to('/user/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
