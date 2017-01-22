<?php


class CourseController extends BaseController{
    public static function index(){
    // Haetaan kaikki pelit tietokannasta
    $courses = Course::all();
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('course/index.html', array('courses' => $courses));
  }
}
