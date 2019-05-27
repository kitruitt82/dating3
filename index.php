<?php
require_once('vendor/autoload.php');
session_start();

//turn on error reporting
ini_set('display_errors',true);
error_reporting(E_ALL);

require_once('model/validation.php');

//create an instance of the Base class
$f3 = Base::instance();
$f3->config('config.ini');


//Define a default root
$f3->route('GET /', function()
{
    session_destroy();
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /home', function()
{
   session_destroy();
    $view = new Template();
    echo $view->render('views/home.html');

});

$db = new Database();
$f3->route('GET|POST /personal', function($f3)
{
    //if post array is not empty
    if(!empty($_POST))
    {
        //get data from form
        $fn= $_POST['fname'];
        $ln= $_POST['lname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone= $_POST['phone'];
        $membership = $_POST['membership'];
        //$member= null;

        //add data to hive
        $f3->set('fname',$fn);
        $f3->set('lname',$ln);
        $f3->set('age',$age);
        $f3->set('gender',$gender);
        $f3->set('phone',$phone);
        $f3->set('membership', $membership);


        //If data is valid
        if (validForm1()) {
            $_SESSION['fname']= $fn;
            $_SESSION['lname']= $ln;
            $_SESSION['age']= $age;

            if (empty($gender)) {
                $_SESSION['gender'] = "Please select a gender";
            }
            else {
                $_SESSION['gender'] = $gender;
            }

            $_SESSION['phone'] = $phone;
            $_SESSION['membership']= $membership;
            if(!empty($membership))
            {
                $member = new PremiumMember($fn, $ln, $gender, $age, $phone);
            }
            else{
                $member = new Member($fn, $ln, $gender, $age, $phone);
            }

            $_SESSION['member'] = $member;


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
        $seeking = $_POST['seekings'];
        $bio = $_POST['biography'];
        //$member =null;

        //add data to hive
        $f3->set('email',$email);
        $f3->set('state',$state);
        $f3->set('seeking',$seeking);
        $f3->set('biography',$bio);

        //If data is valid
        if (validForm2()) {
            $_SESSION['email'] = $email;
            $_SESSION['state'] = $state;

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
            $member = $_SESSION['member'];
            $member->setEmail($email);
            $member->setState($state);
            $member->setSeeking($seeking);
            $member->setBio($bio);
            $_SESSION['member']=$member;
            if($member instanceof PremiumMember) {


                $f3->reroute('/interests');
            }
            else{
                 //$_SESSION['member']->setIndoorInterests(["Not a premium member"]);
                 //$_SESSION['member']->setOutdoorInterests(["Not a premium member"]);
                $f3->reroute('/confirmation');
            }
        }
    }
    $view = new Template();
    echo $view->render('views/form2.html');

});

$f3->route('GET|POST /interests',function($f3)
{
    //$member=null;
    if(!empty($_POST)){

        //get the data
        $outdoor = $_POST['outdoor'];
        $indoor = $_POST['indoor'];

        //set the data
        $f3->set('outdoor', $outdoor);
        $f3->set('indoor', $indoor);

        //If data is valid

        if (validInterest()) {
            //Write data to Session
            if (empty($indoor)) {
                $_SESSION['indoor'] = ["no indoor interests"];
            }
            else {
                $_SESSION['indoor'] = $indoor;
            }
            if (empty($outdoor)) {
                $_SESSION['outdoor'] = ["no outdoor interests"];
            }
            else {
                $_SESSION['outdoor'] = $outdoor;
            }
            $member=$_SESSION['member'];
            $member->setInDoorInterests($indoor);
            $member->setOutDoorInterests($outdoor);
            $f3->reroute('/confirmation');
        }
    }

    $view = new Template();
    echo $view->render('views/interests.html');
});

$f3->route('GET /confirmation', function($f3)
{
    //$member = null;

    $member=$_SESSION['member'];

    $interests=null;
    if($member instanceof PremiumMember){
        if(!count($member->getOutdoorInterests())==0 && count($member->getIndoorInterests())==0){
            $chosenInterests = $member->getOutdoorInterests();
        }
        elseif(!count($member->getIndoorInterests())==0 && count($member->getOutdoorInterests())==0){
            $chosenInterests = $member->getIndoorInterests();
        }
        elseif(count($member->getIndoorInterests())==0 && count($member->getOutdoorInterests())==0){
            $chosenInterests=[];
        }
        else{
            $chosenInterests = array_merge($member->getIndoorInterests(),$member->getOutdoorInterests());
        }
        $interests= implode(' , ' ,$chosenInterests);
    }
    $_SESSION['interests'] = $interests;

    $f3->set('member',$member);
    global $db;
    $db->insertMember();

    //display form data
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Define a route for admin to view all members
$f3->route('GET|POST /admin', function($f3) {

    global $db;
    $members = $db->getMembers();
    $f3->set('members', $members);

    //print_r($members);
    //load a template
    $template = new Template();
    echo $template->render('views/all-members.html');
});
$f3->run();