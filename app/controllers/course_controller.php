<?php

class CourseController extends BaseController {

    public static function index() {
        $courses = Course::all();
        View::make('course/index.html', array('courses' => $courses));
    }

    public static function edit($id) {
        self::check_logged_in();
        $course = Course::find($id);
        if ($course->teacher_id == self::get_student_logged_in()->id) {
            View::make('course/edit.html', array('course' => $course));
        } else
            Redirect::to('/course/' . $course->id, array('message' => 'Et voi muokata toisten kursseja!')
            );
    }

    public static function check_owned() {
        self::check_logged_in();
        $course = Course::find($id);
        if ($course->teacher_id == self::get_student_logged_in()->id) {
            return true;
        } else
            return false;
    }

    public static function create() {
        self::check_logged_in();
        View::make('course/new.html');
    }

    public static function join($id) {
        $course = Course::find($id);
        $course->join();
    }

    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Course-luokan olion käyttäjän syöttämillä arvoilla
        $attributes = new Course(array(
            'teacher_id' => self::get_student_logged_in()->id,
            'publisher' => $params['publisher'],
            'status' => $params['status'],
            'starts' => $params['starts'],
            'ends' => $params['ends'],
            'url' => $params['url'],
            'description' => $params['description'],
            'name' => $params['name']
        ));

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

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'description' => $params['description'],
            'name' => $params['name'],
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
        self::check_logged_in();
        $course = Course::find($id);
        if ($course->teacher_id == self::get_student_logged_in()->id) {//
            $course = new Course(array('id' => $id));
            $course->destroy();
            Redirect::to('/', array('message' => 'Kurssi on poistettu onnistuneesti!'));
        } else
            Redirect::to('/course/' . $course->id, array('message' => 'Et voi poistaa toisten kursseja!'));
    }

    public static function show($id) {
        $course = Course::find($id);
        $participants = Participant::find_participants($id);
        View::make('course/show.html', array('course' => $course, 'participants' => $participants));
    }

}
