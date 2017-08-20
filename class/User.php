<?php
include_once 'Database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Paul
 */
class User {
    //put your code here
    private $userid='';
    private $username='';
    private $password='';
    private $role=array();

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    }

    public function selectUser($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt;

    }

    public function selectMutiUser($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }


    public function insertUser($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        if($stmt->execute()){
            return "true";
        }
        else{
            return "false";
        }
    }

    public function insertRole($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        if(count($this->role) >0){
            foreach ($this->role as $value) {
                $stmt->bindValue(':role', $value);
                if ($stmt->execute()) {
                    continue;
                } else {
                    return false;
                }
            }
            return true;
      }
        return true;
    }
    public function updateUser($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    public function deleteUserOrRole($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @return string
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param string $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param array $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }




}
//insert role
/*
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$user->setRole(array("test1"));
$user->setUsername("test");
$sql="INSERT INTO user_roles (username, role) VALUES (:username, :role);";
$stmt = $user->insertRole($sql);
if($stmt)
echo "true";
else
    echo "false";
*/

//insert user
/*
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$user->setUsername("ok");
$user->setPassword("888");
$sql="INSERT INTO user (username, password) VALUES (:username, :password);";
$stmt = $user->insertUser($sql);
if($stmt)
echo "true";
else
    echo "false";
*/

//select m user
/*
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$sql="SELECT user.username ,user.password ,GROUP_CONCAT(user_roles.role SEPARATOR '  ') as role FROM user,user_roles WHERE user.username=user_roles.username GROUP BY user.username";
$stmt = $user->selectMutiUser($sql);
if($stmt)
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
      echo $row['username'] .  ":" . $row['role'];
      echo "<br>";
    }
else
    echo "false";

*/


//select user
/*
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$user->setUsername("test");
$sql="SELECT user.username ,user.password ,GROUP_CONCAT(user_roles.role SEPARATOR ', ') as role FROM user,user_roles WHERE user.username=user_roles.username and user.username=:username GROUP BY user.username";
$stmt = $user->selectUser($sql);
if($stmt)
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['username'] .  ":" . $row['role'];
        echo "<br>";
    }
else
    echo "false";
*/

//update user
/*
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$user->setUsername("ok");
$user->setPassword("888");
$sql="UPDATE user SET password=:password WHERE username=:username ";
$stmt = $user->updateUser($sql);
if($stmt)
    echo "true";
else
    echo "false";



*/
//delete user
/*
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$user->setUsername("ok");
$sql="DELETE FROM user WHERE username=:username ";
$stmt = $user->deleteUser($sql);
if($stmt)
    echo "true";
else
    echo "false";
*/