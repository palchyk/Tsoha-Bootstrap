<?php

class ParticipantsController extends BaseController {

    public static function join($id) {
        self::check_logged_in();
        $course = Course::find($id);
        View::make('course/join.html', array('course' => $course));
    }

    public static function destroy($pid) {
        self::check_logged_in();
        $participant = Participant::find($pid);

        $participant = new Participant(array('pid' => $pid));
        $participant->destroy();

        Redirect::to('/', array('message' => 'Osallistuja on poistettu onnistuneesti!'));
    }

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
        } else {

            Redirect::to('/course/' . $course->id . '/join', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function show($id) {
        $course = Course::find($id);
        View::make('course/show.html', array('course' => $course));
    }

   
}
