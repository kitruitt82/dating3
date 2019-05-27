<?php

require ("/home/ktruittg/config.php");

/**
 * Class Database
 */
class Database
{
    private $_dbh;

    function __construct()
    {
        $this->connect();
    }

    /**
     * @return PDO|void
     */
    function connect()
    {
        try {

            //Instantiate a database object
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME,
                DB_PASSWORD);
            //echo "Connected to database!!!**!!";
            return $this->_dbh;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return;
        }
    }


    /**
     * @return mixed
     */
    function getMembers()
    {
        $sql = "SELECT *  FROM member  ORDER BY lname";
    
        $statement = $this->_dbh->prepare($sql);

        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /**
     * @param $member_id
     * @return mixed
     */
    function getMember($member_id)
    {
        $sql = "SELECT * FROM member WHERE member_id= :member_id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param $member_id
     * @return mixed
     */
    function getInterests($member_id)
    {
        $sql = "SELECT interest.interest FROM member_interest INNER JOIN interest ON 
        member_interest.interest_id=interest.interest_id WHERE member_interest.member_id = :member_id";
        $statement = $this->_dbh->prepare($sql);
        $statement->bindParam(':member_id', $member_id, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_NUM);
        $interests = [];
        foreach ($row as $item)
        {
            array_push($interests, $item[0]);
        }
        if(empty($interests))
        {
            array_push($interests, "No interests selected");
        }
        //print_r($interests);
        return $interests;
    }

    /**
     * @return mixed
     */
    function insertMember()
    {
        global $f3;
        $member= $f3->get('member');

        //1. define the query
        $sql = "INSERT INTO member(lname,fname,age,gender,phone,email,state,seeking,bio,premium)
                VALUES (:lname, :fname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";

        //2. prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //values
        $lname = $member->getLname();
        $fname = $member->getFname();
        $age = $member->getAge();
        $gender= $member->getGender();
        $phone = $member->getPhone();
        $email = $member->getEmail();
        $state = $member->getState();
        $seeking = $member->getSeeking();
        $bio = $member->getBio();

        if($member instanceof PremiumMember){

            $premium = 1;
        }
        else{
            $premium =0;
        }


        //3. bind parameters
        $statement->bindParam(':lname',$fname, PDO::PARAM_STR);
        $statement->bindParam(':fname', $lname, PDO::PARAM_STR);
        $statement->bindParam(':age', $age, PDO::PARAM_STR);
        $statement->bindParam(':gender',$gender, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':state', $state, PDO::PARAM_STR);
        $statement->bindParam(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindParam(':bio', $bio, PDO::PARAM_STR);
        $statement->bindParam(':premium',$premium, PDO::PARAM_INT);

        //4. execute the statement
        $statement->execute();

        if($member instanceof PremiumMember)
        {
            $lastMemberID = $this->_dbh->lastInsertId();
            if(!empty($member->getOutDoorInterests())) {
                foreach ($member->getOutDoorInterests() as $interest) {
                    $this->addInterest($interest, $lastMemberID);
                }
            }
            if(!empty($member->getInDoorInterests())) {
                foreach ($member->getInDoorInterests() as $interest)
                {
                    $this->addInterest($interest, $lastMemberID);
                }
            }
        }
    }


    private function addInterest($interest, $lastMemberID)
    {
        $sqlIntID = "SELECT interest_id FROM interest WHERE interest = :interest";
        $statementIntID = $this->_dbh->prepare($sqlIntID);
        $statementIntID->bindParam(':interest', $interest, PDO::PARAM_STR);
        $statementIntID->execute();
        $intID = $statementIntID->fetch(PDO::FETCH_NUM);
        $sqlInterests = "INSERT INTO member_interest(member_id, interest_id) VALUES (:member_id, :interest_id)";
        $statementInterest = $this->_dbh->prepare($sqlInterests);
        $statementInterest->bindParam(':member_id', $lastMemberID, PDO::PARAM_INT);
        $statementInterest->bindParam(':interest_id', $intID[0], PDO::PARAM_INT);
        $statementInterest->execute();
    }
}