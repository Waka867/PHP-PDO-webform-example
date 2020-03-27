<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
// Connection credentials outside web accessible level of filesystem
$connDir        = dirname('/var/www/html/sampledomain.com');
include( $connDir . '/conn.php');



// Set up database connection object
try {
  $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
  // set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch( PDOException $e ) {
  echo "Connection failed: " . $e->getMessage();
}

?>
