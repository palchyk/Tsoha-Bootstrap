<?php

class ParticipantsController extends BaseController {

    public static function join() {
        self::check_logged_in();
        View::make('course/join.html');
    }

    public static function participate() {
        $params = $_POST;

        $attributes = new Participants(array(
            'studentnumber' => $params['studentnumber'],
            'fullname' => $params['fullname'],
        ));
        $participants = new Participants($attributes);
        $errors = $participants->errors();
        if (count($errors) == 0) {
            $participants->save();


            Redirect::to('/', array('message' => 'Ilmoittauduit!'));
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
