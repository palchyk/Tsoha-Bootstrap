<?php



//$routes->get('/course', function() {
//    CourseController::index();
//});
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
$routes->get('/course/:id/join', function($id) {
    // Kurssin muokkauslomakkeen esittäminen
    CourseController::join();
});

$routes->post('/course/:id/destroy', function($id) {
    // Pelin poisto
    CourseController::destroy($id);
});
 $routes->get('/user/register', function(){
    UserController::register();
  });
  
  $routes->post('/user/register', function(){
    UserController::store();
  });
   $routes->post('/logout', function(){
    UserController::logout();
  });

//$routes->get('/hiekkalaatikko', function() {
//    HelloWorldController::sandbox();
//});
//$routes->get('/tervetuloa', function() {
//    HelloWorldController::welcome();
//});
//$routes->get('/kurssit', function() {
//    HelloWorldController::courses();
//});
//$routes->get('/kurssit/1', function() {
//    HelloWorldController::course1();
//});
//$routes->get('/kurssit/1/edit', function() {
//    HelloWorldController::course1edit();
//});
$routes->get('/kirjaudu', function() {
    HelloWorldController::login();
});
