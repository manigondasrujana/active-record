<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('DATABASE', 'sm2555');
define('USERNAME', 'sm2555');
define('PASSWORD', 'tzw8bjLL');
define('CONNECTION', 'sql1.njit.edu');
class dbConn{
	protected static $db;
	private function __construct() {
	try{
	self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
        self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch (PDOException $e) {
	echo "Connection Error: " . $e->getMessage();
        }
        }
	public static function getConnection() {
	if (!self::$db) {
	new dbConn();
	}
	return self::$db;
	    }
	    }
class collection {
    static public function create() {
    $model = new static::$modelName;
    return $model;
    }
    static public function findAll() {
    $db = dbConn::getConnection();
    $tableName = get_called_class();
    $sql = 'SELECT * FROM ' . $tableName;
    $statement = $db->prepare($sql);
    $statement->execute();
    $class = static::$modelName;
    $statement->setFetchMode(PDO::FETCH_CLASS, $class);
    $recordsSet =  $statement->fetchAll();
    return $recordsSet;
    }
	static public function findOne($id) {
        $db = dbConn::getConnection();
	$tableName = get_called_class();
	$sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
	$statement = $db->prepare($sql);
	$statement->execute();
	$class = static::$modelName;
	$statement->setFetchMode(PDO::FETCH_CLASS, $class);
	$recordsSet =  $statement->fetchAll();
	return $recordsSet[0];
	}
	}
class accounts extends collection {
    protected static $modelName = 'account';
    }
    class todos extends collection {
        protected static $modelName = 'todo';
	}
class model {
    protected $tableName;
    public function save()
	    {
	if ($this->id = '') {
	$sql = $this->insert();
	        } else {
		            $sql = $this->update();
	 }
	$db = dbConn::getConnection();
        $statement = $db->prepare($sql);
        $statement->execute();
        $tableName = get_called_class();
	$array = get_object_vars($this);
        $columnString = implode(',', $array);
        $valueString = ":".implode(',:', $array);
	echo 'I just saved record: ' . $this->id;
	echo '<hr/>';
	}
	private function insert() {

		$sql = 'SELECT * FROM accounts';
	        return $sql;
		echo '<hr/>';
	    }
        private function update() {
	        $sql = "UPDATE `accounts` SET `id`=1,`email`=sm2555,`fname`=m,`lname`=s,`phone`=551,`birthday`=3-8,`gender`=f,`password`=3549	WHERE 1";
	        return $sql;
	        echo 'I just updated record' . $this->id;
	    	echo '<hr/>';
	    }

	 public function delete() {
	         echo 'I just deleted record' . $this->id;
		 echo '<hr/>';    
		     }

}
class account extends model {
 public $id;
 public $email;
 public $fname;
 public $lname;
 public $phone;
 public $birthday;
 public $gender;
 public $password;

}

class todo extends model {
    public $id;
        public $owneremail;
	    public $ownerid;
	        public $createddate;
		    public $duedate;
		        public $message;
			    public $isdone;
 public function __construct()
     {
  
	     $this->tableName = 'accounts';	     	
		    }
		    }
            
            
            
            
            echo '<table>';
            echo '<tr><th>ID</th><th>Email</th><th>fname</th><th>lname</th><th>phone</th><th>birthday</th><th>gender</th><th>password</th></tr>';
	$records = accounts::findAll();

  foreach($records as $item) 
  {
  echo '<tr>';
echo '<td>'.$item->id.'</td>';
echo '<td>'.$item->email.'</td>';
echo '<td>'.$item->fname.'</td>';
echo '<td>'.$item->lname.'</td>';
echo '<td>'.$item->phone.'</td>';
echo '<td>'.$item->birthday.'</td>';
echo '<td>'.$item->gender.'</td>';
echo '<td>'.$item->password.'</td>';


  echo '</tr>';
  }
  echo '</table>';


echo '<table>';
  echo '<tr><th>ID</th><th>OwnerEmail</th><th>ownerid</th><th>createddate</th><th>duedate</th><th>message</th><th>isdone</th></tr>';
	
$records2 = todos::findAll();
  foreach($records2 as $item) 
  {
  echo '<tr>';
echo '<td>'.$item->id.'</td>';
echo '<td>'.$item->owneremail.'</td>';
echo '<td>'.$item->ownerid.'</td>';
echo '<td>'.$item->createddate.'</td>';
echo '<td>'.$item->duedate.'</td>';
echo '<td>'.$item->message.'</td>';
echo '<td>'.$item->isdone.'</td>'; 
echo '</tr>';
}
echo '</table>';


?>
