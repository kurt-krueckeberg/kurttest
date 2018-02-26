<?php
include "hidden/MedwatchDbConfig.php"; // password file

$MedwatchDbConfig = MedwatchDbConfig::getDbConfig(); 
 
$sql_row_count = "SELECT count(*) FROM medwatch_report";
           
 try { 
     $dbh = new PDO("mysql:host=localhost;dbname=medwatch", 'medwatch', 'kk0457');  

     $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
     
     $select_stmt_total = $dbh->query($sql_row_count);
     
     $total_records = (int) $select_stmt_total->fetchColumn();

     echo "Total rows = $total_records\n";
 
 } catch (Exception $e) {
     

     $msg = $e->getMessage();
     echo "<p>An Exception has occurred:</p>\n<p>$msg<p>\n";
     echo "<hr />\n";
     echo "<p>Stack Trace:</p><p>" . $e->getTrace() . "</p>\n";
     exit();
 }
