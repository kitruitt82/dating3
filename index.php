<?php
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
session_start();
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
    $_SESSION = [];
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
        $bio = $_POST['biography'];

        //add data to hive
        $f3->set('email',$email);
        $f3->set('state',$state);
        $f3->set('seeking',$seeking);
        $f3->set('biography',$bio);

        //If data is valid
        if (validForm2()) {
            $_SESSION['email']= $email;
            if(empty($email))
            {
                $_SESSION['email']= "Please enter an email address";

            }
            else{
                $_SESSION['email']=$email;
            }
            if(empty($state))
            {
                $_SESSION['state']= "No state selection";
            }
            else{
                $_SESSION['state']=$state;
            }
            if(empty($seeking))
            {
                $_SESSION['seeking']= "No selection was made";
            }
            else{
                $_SESSION['seeking']= $seeking;
            }
            if(empty($bio))
            {
                $_SESSION['biography']= "Biography has not been entered yet";
            }
            else{
                $_SESSION['biography']= $bio;
            }

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
            echo "HEY!";
            //add data to session
            if(!empty($indoor)){
                $_SESSION['indoor']=implode(", " , $indoor);
            }

            if(!empty($outdoor))
            {
                $_SESSION['outdoor']=implode(", " , $outdoor);
            }

            //go to next page
            $f3->reroute('/confirmation');
        }
    }

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