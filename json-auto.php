<?php header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
/*
This script is using PHP PDO to generate a MySQL database in JSON format.

It is only using a general select SQL query without a special analogy query to find valuable shares.
*/

/* ###########################################
require_once 'mydbconfig.php';
can make a file of mydbconfig.php with the following codes
<?php
    $host = 'servername';
    $dbname = 'databasename';
    $username = 'username';
    $password = 'password';
?>
#############################################
*/

     $host = 'servername';
    $dbname = 'databasename';
    $username = 'username';
    $password = 'password';

if (isset($_GET['term'])){
	$return_arr = array();
	
	try {  
	    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); // connect to the database
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
		/* A select query under where condition to find  record(s) from the Australian Industry shares
		// use prepared statements, even if not strictly required is good practice */
	    $stmt = $conn->prepare('SELECT * FROM IndustryShares WHERE SecurityDescription LIKE :term');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%')); // execute the query
	    
		 // fetch the results into an array
	    while($row = $stmt->fetch()) {
	        $return_arr[] =  $row['SecurityDescription'];
	    }
	} catch(PDOException $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}
    /* generate results as json encoded array. */
    echo json_encode($return_arr);
}
?>