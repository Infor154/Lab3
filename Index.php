<?php

/*<!--===============================================
   Name   : index.php
   Purpose: Authenticates and prints out JSON results
   Version: 5.0
   Notes   : 
   Author : Omotola and Shauns
 ================================================-->*/
// requires library 
       require_once('TwitterAPIExchange.php');
             
       //sets authentication data
       $settings = array(
    'oauth_access_token' => "259392968-J19sEoQuhIJDa5EdmPzJQdxtM4wQgmWAUhORLsxf",
    'oauth_access_token_secret' => "sKkPBFnJdVuewNbenzX92VJyIyd7SPY14c7vh9HX25P1x",
    'consumer_key' => "5Mxg8hTW6bXmi7AXlbmBIXHg1",
    'consumer_secret' => "HevfmignG9EksUAg5IqSvVKdzBBoB4LTA1FBn7lnTsmXcn5ECx"
);
       //gets text field from html file
$keyword = $_POST['keyword'];
//makes the keyword compatible with the url
$plus = '%20';
$keywords = explode(" ",$keyword);
$query = implode($plus,$keywords);
$q = str_replace('','%3A',$query);


//sets the url and the request method
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q='. $q;
$requestMethod = 'GET';

// creates a new TwitterAPIExchange object with the authetication data and calls the function that gets the results form twitter
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

//prints out the query string, and url
echo'<h3>'.$query.'</h3>';
echo'<h3>URL for the Query</h3>';
//echo'<a href='.$url.'>' .$url.'</a>';
echo'<a href='.$url.'?q='.$query.'>' .$url.'?q='.$query.'</a>';
echo'<hr>';


//prints out the results in json format
$tweets = json_decode($response);
var_dump($tweets);
//var_dump(json_decode($response));

//Datebase

$con=mysqli_connect("example.com","peter","abc123");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Create database
$sql="CREATE DATABASE my_db";
if (mysqli_query($con,$sql)) {
  echo "Database my_db created successfully";
} else {
  echo "Error creating database: " . mysqli_error($con);
  
  
  
// Table
  
  $con=mysqli_connect("example.com","peter","abc123","my_db");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Create table
$sql="CREATE TABLE Persons(FirstName CHAR(30),LastName CHAR(30),Age INT)";

// Execute query
if (mysqli_query($con,$sql)) {
  echo "Table persons created successfully";
} else {
  echo "Error creating table: " . mysqli_error($con);
}

//Primary Keys
$sql = "CREATE TABLE Persons 
(
PID INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(PID),
FirstName CHAR(15),
LastName CHAR(15),
Age INT
)";

?>
