require_once('mysql_access.php');
$username = mysql_real_escape_string($_GET['name'], $db);
$score = mysql_real_escape_string($_GET['score'], $db);
$hash = $_GET['hash'];
$privateKey="ADDYOURKEY";
$expected_hash = md5($username . $score . $privateKey);
if($expected_hash == $hash) {
$query = "INSERT INTO Scores
SET name = '$name'
   , score = '$score'
   , ts = CURRENT_TIMESTAMP
   ON DUPLICATE KEY UPDATE
   ts = if('$score'>score,CURRENT_TIMESTAMP,ts), score = if ('$score'>score, '$score', score);";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
?>
