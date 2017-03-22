<?php



class HelloWorldController extends BaseController {
public static function login() {
        // Testaa koodiasi täällä
        View::make('login.html');
    }
   

//    public static function sandbox(){
    // Testaa koodiasi täällä
//       View::make('helloworld.html');
//      
//    }
    public static function index() {
        // Testaa koodiasi täällä
        View::make('home.html');
    }

    public static function courses() {
        // Testaa koodiasi täällä
        View::make('courses.html');
    }

    public static function course1() {
        // Testaa koodiasi täällä
        View::make('course1.html');
    }

    public static function course1edit() {
        // Testaa koodiasi täällä
        View::make('course1edit.html');
    }

    

    public static function sandbox() {
        $course1 = Course::find(1);
        $courses = Course::all();
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($courses);
        Kint::dump($course1);
    }

}
