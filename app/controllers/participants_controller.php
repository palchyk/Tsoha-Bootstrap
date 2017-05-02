<?php

class ParticipantsController extends BaseController {

//    public static $id;

    public static function join($id) {
        self::check_logged_in();
        $course = Course::find($id);
        View::make('course/join.html', array('course' => $course));
    }

    public static function destroy($pid) {
        self::check_logged_in();
//        $course = Course::find($course_id);
        $participant = Participant::find($pid);
        
        if($participant==null){
            Redirect::to('/', array('message' => 'Osallistuja ei löytynyt!'));
        }
//        Redirect::to('/', array('message' => 'Osallistuja on poistettu onnistuneesti!'));
//        $course = Course::find($id);
//        if ($course->teacher_id == self::get_student_logged_in()->id) {//
//        $participant = new Participant(array('pid' => $pid));
        else{$participant = new Participant(array('pid' => $pid));$participant->destroy();
//        } else {
//                    Redirect::to('/course/' . $course->id, array('message' => 'Et voi poistaa toisten kursseja!'));
        Redirect::to('/', array('message' => 'Osallistuja on poistettu onnistuneesti!'));
    }}

//    }
//         else Redirect::to('/course/' . $course->id, array('message' => 'Et voi poistaa osallistujia jos et ole kursin ylläpitäjä'));
//    public static function save_id($id){
//        $this->id=$id;
//    }

    public static function participate($id) {
        $params = $_POST;
        $course = Course::find($id);

        $attributes = new Participant(array(
            'studentnumber' => $params['studentnumber'],
            'fullname' => $params['fullname'],
            'participant_id' => self::get_student_logged_in()->id,
            'course_id' => $id,
        ));
        $participant = new Participant($attributes);
        $errors = $participant->errors();
        if (count($errors) == 0) {
            $participant->save();

            Redirect::to('/course/' . $course->id, array('message' => 'Ilmoittauduit kurssille!')
            );
//            Redirect::to('/', array('message' => 'Ilmoittauduit!'));
        } else {

            View::make('course/join.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function show($id) {
        $course = Course::find($id);
        View::make('course/show.html', array('course' => $course));
    }

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */
}
