<?php
$servername = "sql1.njit.edu";
$username = "sm2555";
$password = "tzw8bjLL";
$dbname = "sm2555";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $sql = "INSERT INTO accounts (id,email,fname,lname,phone,birthday,gender,password)
		    VALUES ('43','sm','m','s','45','30-08','f','Doe')";
		        // use exec() because no results are returned
			    $conn->exec($sql);
			        echo "New record created successfully";
				    }
				    catch(PDOException $e)
				        {
					    echo $sql . "<br>" . $e->getMessage();
					        }

						$conn = null;
						?>
