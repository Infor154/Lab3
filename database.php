<?php
//$con=  mysqli_connect("localhost","root","");
//// Check connection
//if (mysqli_connect_errno()) {
//  echo "Failed to connect to MySQL: " . mysqli_connect_error();
//}
//
//// Create database
//$sql="CREATE DATABASE my_db";
//if (mysqli_query($con,$sql)) {
//  echo "Database my_db created successfully";
//} else {
//  echo "Error creating database: " . mysqli_error($con);
//}
class Database{
    var $db;
    public function __construct($dbname){
        $dsn = 'mysql:host=localhost;dbname='.$dbname;
        $username ='root';
        $password='';
        try{
            $this->db=new PDO($dsn,$username,$password);
                                 $table = "
                use ".$dbname." ;
                create table tweets(
                id VARCHAR(30) NOT NULL,
                date DateTime,
                from_user_id INT,
                from_user_name VARCHAR(30),
                to_user_id INT,
                to_user_name VARCHAR(30),
                geo VARCHAR(30),
                profile_image_url VARCHAR(200),
                text VARCHAR(150),
                PRIMARY KEY(id,date,from_user_id));";
                
                    $this->db->exec($table);
        }catch(PDOException $e){
            echo '<br>The <b>'.$dbname.'<b> database does not exist. Creating it now...<br>';
            try{
             $this->db=new PDO('mysql:host=localhost',$username,$password);   
 
            $sql = "create database " .$dbname." ;
                use ". $dbname." ;
                create table tweets(
                id VARCHAR(30) NOT NULL,
                date DateTime,
                from_user_id INT,
                from_user_name VARCHAR(30),
                to_user_id INT,
                to_user_name VARCHAR(30),
                geo VARCHAR(30),
                profile_image_url VARCHAR(200),
                text VARCHAR(150),
                PRIMARY KEY(id,date,from_user_id));";
                
                    $this->db->exec($sql);
                        echo 'Done!<br>';
        
}
catch(PDOException $e){
    echo $e-> getMessage();
    exit();
}
}
}
public function close(){
    try{
        $this->db = null;
    }catch (PDOException $e){
        echo $e->getMessage()."Exit!";
        exit();
}
}
public function insertTweets($tweets){
    $sql ="INSERT INTO tweets
        (id,date,from_user_id,from_user_name,profile_image_url,text)
        VALUES(:id,:date,:from_user_id,:from_user_name,:profile_image_url,:text)";
            try{
        $x=$this->db->prepare($sql);
        foreach($tweets as $t){
            $parameters= array(
                ':id' => $t->id,
                ':date' => date('Y-m-d H:i:s', strtotime($t->date)),
                'from_user_id'=>$t->from_user_id,
                'from_user_name'=>$t->from_user_name,
                'profile_image_url'=>$t->profile_image_url,
                'text'=>$t->text
                
            );
            $x->execute($parameters);
        }
        echo "<br/> insert successful";
            }catch(PDOException $e){
                die('insert attempt failed: '. $e->getMessage());
            }
}
public function search($query){
    try{
        $x=$this->db->prepare($query);
        $x->execute();
}catch (PDOException $e){
    die('Query failed: '. $e->getMessage());
}
echo '<table border = 1>';
$heading = true;
while (($row = $x->fetch(PDO::FETCH_ASSOC))){
    echo '<tr>';
    if ($heading){
        $keys = array_keys($row);
        foreach($keys as $k){
            echo '<th>'.$k.'</th>';
        }
        echo '</tr><tr>';
        $heading=false;
    }
    foreach($row as $r=>$v){
        echo '<td>'.$v.'</td>';
        
    }
    echo '</tr>';
}
}
public function clearTable(){
    try{
        $x=$this->db->prepare('TRUNCATE TABLE tweets');
        $x->execute();
}catch (PDOException $e){
    die('Attempt failed: '.$e->getMessage());
 
}
}
}

?>
