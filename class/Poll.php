<?php
include_once 'Database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Poll
 *
 * @author Paul
 */
class Poll
{
    //put your code here
    private $id = "";
    private $poll = array();
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    }

    public function selectPoll($sql, $id)
    {
        $this->setId($id);
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->getId());
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->poll=array();
            $this->poll[$row['id']]=["id" => $row['id'], "question" => $row['question'], "answer1" => $row['answer1'], "answer2" => $row['answer2'], "answer3" => $row['answer3'], "answer4" => $row['answer4'], "count1" => $row['count1'], "count2" => $row['count2'], "count3" => $row['count3'], "count4" => $row['count4']];
        }
    }

    public function updatePoll($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function insertPoll($sql ,$poll){
        $this->setPoll($poll);
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':question', $this->poll["question"]);
        $stmt->bindParam(':answer1', $this->poll["answer1"]);
        $stmt->bindParam(':answer2', $this->poll["answer2"]);
        $stmt->bindParam(':answer3', $this->poll["answer3"]);
        $stmt->bindParam(':answer4', $this->poll["answer4"]);
        $stmt->bindParam(':count1', $this->poll["count1"]);
        $stmt->bindParam(':count2' , $this->poll["count2"]);
        $stmt->bindParam(':count3', $this->poll["count3"]);
        $stmt->bindParam(':count4', $this->poll["count4"]);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    public function deletePoll($sql ,$id){
        $this->setId($id);
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->getId());
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * @param array $poll
     */
    public function setPoll($poll)
    {
        $this->poll = $poll;
    }

}


