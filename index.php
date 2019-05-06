<?php
session_start();
/*
Kat Truitt
IT328 Assignment Dating
April 19,2019
index.php-> renders the routes functions, sessions and etc. for the dating websites
*/

//turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require autoload file
require_once('vendor/autoload.php');
require_once('model/validation.php');

//create an instance of the Base class
$f3 = Base::instance();
$f3->config('config.ini');

//Define a default root
$f3->route('GET /', function()
{
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /home', function()
{
    $view = new Template();
    echo $view->render('views/home.html');

});

$f3->route('GET|POST /personal', function($f3)
{
    //if post array is not empty
    if(!empty($_POST))
    {
        //get data from form
        $fn= $_POST['fname'];
        $ln= $_POST['lname'];
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $tel= $_POST['phone'];

        //add data to hive
        $f3->set('fname',$fn);
        $f3->set('lname',$ln);
        $f3->set('gender',$gender);
        $f3->set('age',$age);
        $f3->set('phone',$tel);

        //If data is valid
        if (validForm1()) {
            $_SESSION['fname']= $fn;
            $_SESSION['lname']= $ln;
            $_SESSION['age']= $age;
            $_SESSION['phone'] = $tel;
            if (empty($gender)) {
                $_SESSION['gender'] = "Please select a gender";
            }
            else {
                $_SESSION['gender'] = $gender;
            }
            $f3->reroute('/profile');
        }
    }

    $view = new Template();
    echo $view->render('views/form1.html');
});

$f3->route('GET|POST /profile', function($f3)
{
    //get data from form
    if(!empty($_POST)){
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        //add data to hive
        $f3->set('email',$email);
        $f3->set('state',$state);
        $f3->set('seeking',$seeking);
        $f3->set('bio',$bio);

        //If data is valid
        if (validForm2()) {
            $_SESSION['state']= $state;
            $_SESSION['seeking']= $seeking;
            $_SESSION['bio']= $bio;
            $_SESSION['email']= $email;

            $f3->reroute('/interests');

        }
    }
    $view = new Template();
    echo $view->render('views/form2.html');

});

$f3->route('GET|POST /interests',function($f3)
{
    if(!empty($_POST))
    {
        //get the data
        $outdoor = $_POST['outdoor'];
        $indoor = $_POST['indoor'];

        //set the data
        $f3->set('outdoor', $outdoor);
        $f3->set('indoor', $indoor);

        //If data is valid
        if(validInterest())
        {
            //add data to session

            //No selections were made, display message
            if(empty($indoor))
            {
                $_SESSION['indoor']= "No indoor interests selected ";

            }
            else{
                $_SESSION['indoor']=implode(", " , $indoor);
            }

            //No selections were made
            if(empty($outdoor)){
                $_SESSION['outdoor'] ="No outdoor interests were selected";
            }
            //display selections
            else{
                $_SESSION['outdoor']=implode(", " , $outdoor);

            }
            $f3->reroute('/confirmation');
        }

    }
    //go to next page
    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET /confirmation', function()
{
    //display form data
    $view = new Template();
    echo $view->render('views/summary.html');
});
//Run Fat-free
$f3->run();