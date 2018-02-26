<?php
$char_class = '[a-zA-ZäoüÄOÜ]';
$regex_s1 = '/^\b' . $char_class . '+\b' . $char_class . '+\b/';
$subject = 'die Gepäck';
$matches = array();
$result = preg_match($regex_s1, $subject, $matches);

echo " preg_match($regex_s1, $subject, $matches);\n";

echo "The subject is: " . $subject . "\n" . "The matches are\n";
print_r($matches);
?>
