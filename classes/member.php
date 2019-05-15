<?php

/**
 *The Member class represents a member of the dating site.
 *
 * The Member class represents a Member with a first name, last name, age, gender, phone number,
 * email address, location(state), seeking type(female or male), and biography.
 * @author Kat Truitt <ktruitt@mail.greenriver.edu>
 * @copyright 2019
 */
class Member
{
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Parameterized constructor for a Member
     * @param $fname Member first name of the Member
     * @param $lname Member last name of the Member
     * @param $age Member age of the Member
     * @param $gender Member gender of the Member
     * @param $phone Member phone number of the Member
     * @return void
     */
    public function __construct($fname,$lname,$age,$gender,$phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    /**
     * Gets the first name of the Member
     * @return Member first name
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * Sets the first name of the Member
     * @param Member $fn the Member's first name
     * @return void
     */
    public function setFname($fn)
    {
        $this->_fname = $fn;
    }

    /**
     * Gets the last name of the Member
     * @return Member last name
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * Sets the Member last name
     * @param Member $ln the Member's last name
     * @return void
     */
    public function setLname($ln)
    {
        $this->_lname = $ln;
    }

    /**
     * Gets the Member age.
     * @return Member the Member's age
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Sets the Member age
     * @param Member $age the Member's age
     * @return void
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Gets the Member gender
     * @return Member the Member's gender
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Sets the Member gender
     * @param Member $gender the Member's gender
     * @return void
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * Gets the Member phone number
     * @return Member phone number
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Sets the Member phone number
     * @param Member $tel phone number
     * @return void
     */
    public function setPhone($tel)
    {
        $this->_phone = $tel;
    }

    /**
     * Gets the Member email address
     * @return mixed Member email address
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the Member email address
     * @param mixed $email Member email address
     * @return void
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Gets the state(location) of the member
     * @return mixed Member state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Sets the Member state (location)
     * @param mixed $state Member state
     * @return void
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * Get the Member's preferred seeking gender
     * @return mixed Member's preferred seeking gender
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * Sets the Member preferred seeking gender
     * @param mixed $seeking Member's preferred seeking gender
     * @return void
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * Gets the Member bio
     * @return mixed Member bio
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * Sets the Member's bio
     * @param mixed $bio Member bio
     * @return void
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }
}