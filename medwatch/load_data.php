<?php

/*
 TODO : The total number of pages calculation is completely wrong.

*/
include "hidden/MedwatchDbConfig.php"; // password file

const fda_get_request = 'http://www.accessdata.fda.gov/scripts/cdrh/cfdocs/cfMAUDE/Detail.CFM?MDRFOI__ID='; 

if($_POST['page']) {
    
    $current_page = $_POST['page'];
/*
if($_GET['page']) {  // for testing only
    
    $current_page = $_GET['page'];
*/
   $per_page = 5;
   $start = $per_page * ($current_page - 1);
       
   $MedwatchDbConfig = MedwatchDbConfig::getDbConfig(); 
    
   $sql_select_chunk = "SELECT * FROM medwatch_report WHERE report_source_code='P' ORDER BY date_received DESC LIMIT $start, $per_page";
   $sql_row_count = "SELECT count(*) FROM medwatch_report WHERE report_source_code='P'";
              
    try { 
        
        $dbh = new PDO("mysql:host=localhost;dbname=" . $MedwatchDbConfig['dbname'], $MedwatchDbConfig['dbuser'], $MedwatchDbConfig['passwd']);  
   
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
        
        $select_stmt_total = $dbh->query($sql_row_count);
        
        $total_records = (int) $select_stmt_total->fetchColumn();
        
        $select_stmt_block = $dbh->query($sql_select_chunk);
                            
        $msg = '';

        foreach ($select_stmt_block as $row) {
            
            $date_received = new DateTime($row['date_received']);
                        
            $date_to_show = $date_received->format('j M Y');
            
            $date_received = htmlentities($date_to_show);
           
            $mdr_key  = htmlentities($row['mdr_report_key']);
         
            // Turn the mdr_key into a html link
            $mdr_key_link = '<a href="' . fda_get_request  . $mdr_key .'">' . $mdr_key .  '</a>'; 
         
            $report = htmlentities($row['text_report']);
         
            $msg .= "<tr><td class='date'>$date_received</td><td class='key'>$mdr_key_link</td><td class='report'><blockquote>$report</blockquote></td></tr>\n";
                 
        }
    
    } catch (Exception $e) {
        

        $msg = $e->getMessage();
        echo "<p>An Exception has occurred:</p>\n<p>$msg<p>\n";
        echo "<hr />\n";
        echo "<p>Stack Trace:</p><p>" . $e->getTrace() . "</p>\n";
        exit();
    }
    
$output = <<<EOD
<h1 class="heading">LASIK Patient Adverse Event Reports to FDA</h1>        
<div class='data'>
<table>
 <!-- Colgroup -->
   
     <!-- Table header -->
   <thead>
      <tr>
       <th>Received</th>
       <th>Report Id</th>
       <th>Report Text</th>
      </tr>
   </thead>
<tbody>
    $msg
</tbody>
</table>
</div>
EOD;

    echo $output;
       
    $slider = getBottomSlider($current_page, $total_records, $per_page);
    
    echo $slider;
}

function getBottomSlider($current_page, $total_records, $per_page) 
{
    $no_of_paginations = ceil($total_records / $per_page); 
    
    $previous_btn = true;

    $next_btn = true;

    $first_btn = true;

    $last_btn = true;

/* ---------------Calculating the starting and ending values for the loop----------------------------------- */
  if ($current_page >= 7) {
  
      $start_loop = $current_page - 3;
  
      if ($no_of_paginations > $current_page + 3) {
  
          $end_loop = $current_page + 3;
  
      } else if ($current_page <= $no_of_paginations && $current_page > $no_of_paginations - 6) {
  
          $start_loop = $no_of_paginations - 6;
          $end_loop = $no_of_paginations;
  
  
      } else {
  
          $end_loop = $no_of_paginations;
      }
  } else {
  
      $start_loop = 1;
  
      if ($no_of_paginations > 7) {
  
          $end_loop = 7;

      } else {

          $end_loop = $no_of_paginations;
      }
  }
    /* ----------------------------------------------------------------------------------------------------------- */
    $msg = "<div class='pagination'><ul>";
    
    // FOR ENABLING THE FIRST BUTTON
    if ($first_btn && $current_page > 1) {

        $msg .= "<li p='1' class='active'>First</li>";

    } else if ($first_btn) {

        $msg .= "<li p='1' class='inactive'>First</li>";

    }
    
    // FOR ENABLING THE PREVIOUS BUTTON
    if ($previous_btn && $current_page > 1) {

        $pre = $current_page - 1;
        $msg .= "<li p='$pre' class='active'>Previous</li>";

    } else if ($previous_btn) {

        $msg .= "<li class='inactive'>Previous</li>";
    }

    for ($i = $start_loop; $i <= $end_loop; $i++) {
    
        if ($current_page == $i)
            $msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
        else
            $msg .= "<li p='$i' class='active'>{$i}</li>";
    }
    
    // TO ENABLE THE NEXT BUTTON
    if ($next_btn && $current_page < $no_of_paginations) {

        $nex = $current_page + 1;
        $msg .= "<li p='$nex' class='active'>Next</li>";

    } else if ($next_btn) {

        $msg .= "<li class='inactive'>Next</li>";
    }
    
    // TO ENABLE THE END BUTTON
    if ($last_btn && $current_page < $no_of_paginations) {

        $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";

    } else if ($last_btn) {

        $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";

    }

    $goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";

    $total_string = "<span class='total' a='$no_of_paginations'>Page <b>" . $current_page . "</b> of <b>$no_of_paginations</b></span>";

    $msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination

    return $msg;
}
