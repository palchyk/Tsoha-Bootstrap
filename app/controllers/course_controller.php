<?php

class CourseController extends BaseController {

    public static function index() {
        $courses = Course::all();
        View::make('course/index.html', array('courses' => $courses));
    }

    public static function edit($id) {
        self::check_logged_in();
        $course = Course::find($id);
        View::make('course/edit.html', array('course' => $course));
    }

    public static function create() {
        self::check_logged_in();
        View::make('course/new.html');
    }
    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Course-luokan olion käyttäjän syöttämillä arvoilla
        $attributes = new Course(array(
            'teacher_id' =>  self::get_student_logged_in()->id                ,
            'publisher' => $params['publisher'],
            'status' => $params['status'],
            'starts' => $params['starts'],
            'ends' => $params['ends'],
            'url' => $params['url'],
            'description' => $params['description'],
            'name' => $params['name']
            
        ));

//         Kint::dump($params);
        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $course = new Course($attributes);
        $errors = $course->errors();
        if (count($errors) == 0) {
            $course->save();

            // Ohjataan käyttäjä lisäyksen jälkeen kurssin esittelysivulle
            Redirect::to('/course/' . $course->id, array('message' => 'Kurssi on lisätty kirjastoosi!'));
        } else {
            // Kurssissa oli jotain vikaa :(
            View::make('course/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
//    public static function join() {
//        self::check_logged_in();
//        View::make('course/join.html');
//    }
//    public static function participate() {
//        $params = $_POST;
//
//        $attributes = array(
//            
//            'studentnumber' => $params['studentnumber'],
//            'fullname' => $params['fullname'],              
//
//        );
//      
//
//        // Alustetaan Course-olio käyttäjän syöttämillä tiedoilla
//        $participants = new Participants($attributes);
//        $errors = $participants->errors();
//
//        if (count($errors) > 0) {
//            View::make('course/join.html', array('errors' => $errors, 'attributes' => $attributes));
//        } else {
//            // Kutsutaan alustetun olion update-metodia, joka päivittää kurssin tiedot tietokannassa
//            $participants->save();
//
//            Redirect::to('/course/' . $course->id, array('message' => 'Olet ilmoittautunut onnistuneesti!'));
//        }
//    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            
            'description' => $params['description'],
            'name' => $params['name'], 
            'teacher_id' => self::get_student_logged_in()->id,
            'id' => $id,
            'status' => $params['status'],
            'url' => $params['url'],
            'publisher' => $params['publisher'],
            'starts' => $params['starts'],
           'ends' => $params['ends'],

        );
      

        
        $course = new Course($attributes);
        $errors = $course->errors();

        if (count($errors) > 0) {
            View::make('course/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            
            $course->update();

            Redirect::to('/course/' . $course->id, array('message' => 'Kurssia on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();        //
        $course = new Course(array('id' => $id));      
        $course->destroy();
        Redirect::to('/', array('message' => 'Kurssi on poistettu onnistuneesti!'));
    }
//    public static function join() {
//        self::check_logged_in();
        // Alustetaan Game-olio annetulla id:llä
//        $course = new Course(array('id' => $id));
        // Kutsutaan Game-malliluokan metodia destroy, joka poistaa pelin sen id:llä
//        $course->destroy();

        // Ohjataan käyttäjä pelien listaussivulle ilmoituksen kera
//        Redirect::to('/', array('message' => 'Ilmoittauduit onnistuneesti onnistuneesti!'));
//    }

    

    public static function show($id) {
        $course = Course::find($id);
        View::make('course/show.html', array('course' => $course));
    }

}
