<?
require_once("session_start.php");
if(!isset($login)) error("You do not have administrator rights\n");

$id = addslashes($_POST['id']);

mysqlconnect();

$error = "";

$squery = "SELECT s.name, d.name division FROM season s JOIN division d ON (s.division = d.id) WHERE (s.ruleset='$id' OR s.ruleset_qualifying='$id')";
$sresult = mysql_query($squery);
if(!$sresult) error("MySQL error: " . mysql_error() . "\n");
if(mysql_num_rows($sresult) > 0) {
	$seasons = "";
	while($s = mysql_fetch_array($sresult)) {
		$seasons .= "&bull; " . $s['name'] . " (" . $s['division'] . ")\n";
	}
	$error .= "Ruleset cannot be deleted because it is related to the following season(s):\n" . $seasons;
}

$rquery = "SELECT r.name, r.track FROM race r WHERE (r.ruleset='$id' OR r.ruleset_qualifying='$id') AND r.season='0'";
$rresult = mysql_query($rquery);
if(!$rresult) error("MySQL error: " . mysql_error() . "\n");
if(mysql_num_rows($rresult) > 0) {
	$races = "";
	while($r = mysql_fetch_array($rresult)) {
		$races .= "&bull; " . $r['name'] . " (" . $r['track'] . ")\n";
	}
	$error .= "Ruleset cannot be deleted because it is related to the following race(s):\n" . $races;
}

if(!empty($error)) error($error);

$query = "DELETE FROM point_ruleset WHERE id='$id'";
$result = mysql_query($query);
if(!$result) error("MySQL Error: " . mysql_error() . "\n");

return_do(".?page=points", "Ruleset succesfully deleted\n$msg");
?>