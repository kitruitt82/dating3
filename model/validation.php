<?php
/*
Kat Truitt
IT328 Assignment Dating
May 4, 2019
index.php-> renders the routes functions, sessions and etc. for the dating websites
*/
function validForm1()
{
    global $f3;
    $isValid = true;

    if (!validFName($f3->get('fname'))) {

        $isValid = false;
        $f3->set("errors['fname']", "Please enter your first name.");

    }

    if (!validLName($f3->get('lname'))) {
        $isValid = false;
        $f3->set("errors['lname']", "Please enter your last name.");
    }

    if (!validGender($f3->get('gender'))) {
        $isValid = false;
        $f3->set("errors['gender']", "Please select your gender.");
    }

    if (!validAge($f3->get('age'))) {
        $isValid = false;
        $f3->set("errors['age']", "Please enter a valid number, must be 21 or older to sign up.");
    }

    if (!validPhone($f3->get('phone'))) {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter a valid phone number. Only numbers(0-9), no dashes and
        include area code ");
    }

    return $isValid;
}

function validForm2()
{
    global $f3;
    $isValid=true;
    if(!validEmail($f3->get('email')))
    {
        $isValid = false;
        $f3->set("errors['email']", "Please enter a valid email.");
    }
    return $isValid;
}

function validInterest()
{
    global $f3;
    $isValid = true;
    if (!validIndoorInterest($f3->get('indoor'))) {
        $isValid = false;
        $f3->set("errors['indoor']", "Please select a valid outdoor interests");
    }
    if (!validOutdoorInterest($f3->get('outdoor'))) {
        $isValid = false;
        $f3->set("errors['outdoor']", "Please select a valid indoor interests");
    }
    return $isValid;
}

function validFName($fn)
{
    return !empty($fn) && ctype_alpha($fn);
}

function validLName($ln)
{
    return !empty($ln) && ctype_alpha($ln);
}

function validGender($gender)
{

    return !(empty($gender));
}

function validAge($age)
{

    return !empty($age) && ctype_digit($age) && (int)$age>=18 && (int) $age<=118;
}

function validPhone($tel)
{
    return !empty($tel) && is_numeric($tel) && strlen($tel)===10 ;
}
function validEmail($email)
{

    return !empty($email) && FILTER_VALIDATE_EMAIL;

}

function validIndoorInterest($indoor)
{
    global $f3;
    if(empty($indoor))
    {
        return true;
    }
    foreach($indoor as $interest)
    {
        if(!in_array($interest, $f3->get('indoor')))
        {
            return false;
        }
    }
    return true;
}

function validOutdoorInterest($outdoor)
{
    global $f3;
    if(empty($outdoor))
    {
        return true;
    }
    foreach($outdoor as $interest)
    {
        if(!in_array($interest, $f3->get('outdoor')))
        {
            return false;
        }
    }
    return true;
}

