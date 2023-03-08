<form action="" method="post">
  <div>
    <label for="nrp">NRP:</label>
    <input type="text" id="nrp" name="nrp">
  </div>
  <div>
    <label for="password">Password:</label>
    <input type="password" id="pass" name="pass">
  </div>
  <input type="submit" value="Submit">
</form>

<?php 
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$user=strtolower($_POST['nrp']);
	$pass=$_POST['pass'];
	$imap=false;
	$timeout=30;
	$fp = fsockopen ($host='john.petra.ac.id',$port=110,$errno,$errstr,$timeout);
	$errstr = fgets ($fp);
	if (substr ($errstr,0,1) == '+'){
		fputs ($fp,"USER ".$user."\n");
		$errstr = fgets ($fp);
		if (substr ($errstr,0,1) == '+'){
			fputs ($fp,"PASS ".$pass."\n");
			$errstr = fgets ($fp);
			if (substr ($errstr,0,1) == '+'){
				$imap=true;
			}
		}
	}
}
?>