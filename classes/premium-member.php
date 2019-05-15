<?php

/**
 * The PremiumMember class represents a premium member of the dating site.
 *
 * The PremiumMember class represents a premium member with indoor/outdoor interests.
 */
class PremiumMember extends Member
{
    private $_indoorInterests;
    private $_outdoorInterests;

    /**
     * Parameterized constructor for a PremiumMember
     * @param $fname PremiumMember first name
     * @param $lname PremiumMember last name
     * @param $age PremiumMember age
     * @param $gender PremiumMember gender
     * @param $phone PremiumMember phone number
     * @return void
     */
    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone);
    }

    /**
     * Gets the PremiumMember indoor interests
     * @return mixed Premium Member indoor interests
     */
    public function getIndoorInterests()
    {
        return $this->_indoorInterests;
    }

    /**
     * Sets the PremiumMember indoor interests
     * @param mixed $indoor Premium Member indoor interests
     * @return void
     */
    public function setIndoorInterests($indoor)
    {
        $this->_indoorInterests = $indoor;
    }

    /**
     * Gets the PremiumMember outdoor interests
     * @return mixed Premium Member outdoor interests
     */
    public function getOutdoorInterests()
    {
        return $this->_outdoorInterests;
    }

    /**
     * Sets the PremiumMember outdoor interests
     * @param mixed $outdoor Premium Member outdoor interests
     * @return void
     */
    public function setOutdoorInterests($outdoor)
    {
        $this->_outdoorInterests = $outdoor;
    }
}