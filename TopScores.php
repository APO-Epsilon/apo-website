SELECT * FROM Scores ORDER by score DESC, ts ASC LIMIT 10
$result_length = mysql_num_rows($result);
 
for($i = 0; $i < $result_length; $i++)
{
     $row = mysql_fetch_array($result);
     echo $row['name'] . "\t" . $row['score'] . "\n";
}
