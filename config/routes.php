<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  $routes->get('/tervetuloa', function() {
    HelloWorldController::welcome();
  });
  $routes->get('/kurssit', function() {
    HelloWorldController::courses();
  });
  $routes->get('/kurssit/1', function() {
    HelloWorldController::course1();
  });
  $routes->get('/kurssit/1/edit', function() {
    HelloWorldController::course1edit();
  });
  $routes->get('/kirjaudu', function() {
    HelloWorldController::login();
  });
  $routes->get('/course', function(){
  CourseController::index();
});
$routes->get('/course/:id', function($id){
  CourseController::show($id);
});
