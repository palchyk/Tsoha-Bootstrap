<?php
$routes->get('/', function() {
    CourseController::index();
});
$routes->post('/course', function() {
    CourseController::store();
});
$routes->get('/course/new', function() {
    CourseController::create();
});
$routes->get('/course/:id', function($id) {
    CourseController::show($id);
});
$routes->get('/course/:id/join', function($id) {
//liittymisen lomakkeen esittäminen
    ParticipantsController::join($id);
});
$routes->post('/course/:id/participate', function($id) {
    //varsinainen liittyminen
    CourseController::join($id);
    ParticipantsController::participate($id);
});
$routes->get('/course/:id', function($id) {
    ParticipantsController::show($id);
});

$routes->get('/user/login', function() {
// Kirjautumislomakkeen esittäminen
    UserController::login();
});
$routes->post('/user/login', function() {
// Kirjautumisen käsittely
    UserController::handle_login();
});
$routes->get('/course/:id/edit', function($id) {
// Kurssin muokkauslomakkeen esittäminen
    CourseController::edit($id);
});
$routes->post('/course/:id/edit', function($id) {
// Kurssin muokkaaminen
    CourseController::update($id);
});
$routes->post('/course/:id/destroy', function($id) {

    CourseController::destroy($id);
});
$routes->post('/remove_participant/:pid', function($pid) {

    ParticipantsController::destroy($pid);
});
$routes->get('/user/register', function() {
    UserController::register();
});
$routes->post('/user/register', function() {
    UserController::store();
});
$routes->post('/logout', function() {
    UserController::logout();
});

