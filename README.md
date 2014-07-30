Lab3
//Runhong Gao Create it ( I didn't finish it, i will do it later)
<?php

class Database{
    var $db;
    
    public function _construct($dbname){
        $dsn ='mysql.host=localhost;dbname='. $dbname;
        $username='root';
        $password='sesame';
        
        try{
            $this->db=new PDO($dsn,$username,$password);
        } catch (PDOException $e) {
          echo'<br>The<b>'.$dbname.'</b> database does not exist. Creat it now <b>';
            try{
                $this->db=newPDO('mysql:host=localhost',$username, $password);
                $sql = "create database twitter;
                        use twitter;
                        create table tweets(
                        id VARCHAR(30) NOT NULL,
                        data DateTime,
                        from_user_id INT,
                        from_user_name VARCHAR(30),
                        geo VARCHAR(30),
                        profile_image_url VARCHAR(200),
                        PRIMARY KEY(id, date, from_user_id)
                        )";
                $this->db->exec($sql);
            echo'Done!<br>';
            }                
                        
             catch (PDOException $e) {
                echo $e->getMessage();
                exit();

    }}
}
//Disconnect
Public function close(){
    try{
        $this->db=null;
    }catch(PSOException $e) {
        echo $e->getMessage(). "Exit";
    }
}

Public function insertTweets($tweets){
    
    $sql = "insert INTO tweets
        (id, date, from_user_id, from_user_name, profile_image_url, text)
        VALUES (:id, :date, :from_user_id, :from_user_name, :profile_image_url, :text)";
    try{
        $x = $this->db->prepare($sql);
        foreach($tweets as $t) {
            $parameters=array(
                ':id'=>$t->id,
                ':date'=>date('Y-m-d H:i:s', strtotime($t->date)),
                ':from_user_id'=>$t->from_user_id,
                ':from_user_name'=>$t->from_user_name,
                ':from_user_url'=>$profile_image_url,
                'text'=>$t->text
            );
            $x->execute($parameters);
        }
    } catch (PDException $e) {
        die("Insert attempt failed:". $e->getMessage());
    }
}


           


     

            
        

