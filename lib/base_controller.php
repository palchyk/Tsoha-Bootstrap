<?php

class BaseController {

    public static function get_student_logged_in() {
        if (isset($_SESSION['student'])) {
            $id = $_SESSION['student'];
            $student = Student::find($id);
            return $student;
        }
        return null;
    }
    public static function owner(){
        if (isset($_SESSION['student'])) {
            $id = $_SESSION['student'];
           
            return $id;
        }
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['student'])) {
            Redirect::to('/user/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

}
