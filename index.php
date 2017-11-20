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
	if ($this->id != '') {
	$sql = $this->update($this->id);
	        } else {
		            $sql = $this->insert();
	 }
	$db = dbConn::getConnection();
        $statement = $db->prepare($sql);
  $array = get_object_vars($this);
                foreach (array_flip($array) as $record=>$item){
                

            $statement->bindParam(":$item", $this->$item);
        }

        
        $statement->execute();
        //$tableName = get_called_class();
	
       // $columnString = implode(',', $array);
     //   $valueString = ":".implode(',:', $array);
   //echo "INSERT INTO $tableName (" . $columnString . ") VALUES (" . $valueString . ")</br>";

  echo '<h2>I just saved record: </h2>';
	echo '<hr/>';
	}
	private function insert() {
 $modelName=get_called_class();
        $tableName = $modelName::tname();
        $array = get_object_vars($this);
        $columnString = implode(',', array_flip($array));
        $valueString = ':'.implode(',:', array_flip($array));
        print_r($columnString);
        $sql =  'INSERT INTO '.$tableName.' ('.$columnString.') VALUES ('.$valueString.')';
        return $sql;
               
     		echo '<hr/>';
        
	    }
        private function update($id) {
	        $modelName=get_called_class();
        $tableName = $modelName::tname();
        $array = get_object_vars($this);
        $update = " ";
        $sql = 'UPDATE '.$tableName.' SET ';
         foreach ($array as $record=>$item){
            if( ! empty($item)) {
                $sql .= $update . $record . ' = "'. $item .'"';
                $update = ", ";
            }
        }
         $sql .= ' WHERE id='.$id;
      
        return $sql;
      
	        echo 'I just updated record' . $this->id;
	    	echo '<hr/>';
	    }

	 public function delete($id) {
           $db = dbConn::getConnection();
        $modelName=get_called_class();
        $tableName = $modelName::tname();
        $sql = 'DELETE FROM '.$tableName.' WHERE id='.$id;
        $statement = $db->prepare($sql);
        $statement->execute();

	         echo '<h2>I just deleted record</h2>' . $this->id;
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
 public static function tname(){
        $tableName='accounts';
        return $tableName;
   }

}

class todo extends model {
    public $id;
        public $owneremail;
	    public $ownerid;
	        public $createddate;
		    public $duedate;
		        public $message;
			    public $isdone;
                      public static function tname(){
        $tableName='todos';
        return $tableName;
   }

// public function __construct()
     //{
  
	     //$this->tableName = 'accounts';	     	
		    //}
		    }
            
      echo "<h1> Select One Record from accounts</h1>";      
      echo '<table border="1">';
            echo '<tr><th>ID</th><th>Email</th><th>fname</th><th>lname</th><th>phone</th><th>birthday</th><th>gender</th><th>password</th></tr>';
	$r3 = accounts::findOne(1);
  echo '<tr>';
echo '<td>'.$r3->id.'</td>';
echo '<td>'.$r3->email.'</td>';
echo '<td>'.$r3->fname.'</td>';
echo '<td>'.$r3->lname.'</td>';
echo '<td>'.$r3->phone.'</td>';
echo '<td>'.$r3->birthday.'</td>';
echo '<td>'.$r3->gender.'</td>';
echo '<td>'.$r3->password.'</td>';


  echo '</tr>';
  echo '</table>';

      echo "<h1> Select One Record from todos</h1>";      
      echo '<table border="1">';
            echo '<tr><th>ID</th><th>OwnerEmail</th><th>OwnerId</th><th>createddate</th><th>duedate</th><th>message</th><th>isdone</th></tr>';
	$r3 = todos::findOne(1);
  echo '<tr>';
echo '<td>'.$r3->id.'</td>';
echo '<td>'.$r3->owneremail.'</td>';
echo '<td>'.$r3->ownerid.'</td>';
echo '<td>'.$r3->createddate.'</td>';
echo '<td>'.$r3->duedate.'</td>';
echo '<td>'.$r3->message.'</td>';
echo '<td>'.$r3->isdone.'</td>';



  echo '</tr>';
  echo '</table>';
            
            echo "<h1> Select all Records from accounts</h1>";
            echo '<table border="1">';
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

echo "<h1> Select all Records from todos</h1>";
echo '<table border="1">';
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


$record = new account();
$record = new account();
$record->email="sm2555@njit.edu";
$record->fname="m";
$record->lname="s";
$record->phone="3549";
$record->birthday="1989-08-08";
$record->gender="f";
$record->password="3549";
$record->save();
$records = accounts::findAll();//$records = todos::findAll();
//print_r($records);


$record= new account();
$id=43;
$record->delete($id);

echo "<h2> updates fname,lname,gender where id=9 </h2>";
$id=9;
$record = new account();
$record->id=$id;
$record->fname="manigonda";
$record->lname="srujana";
$record->gender="female";
$record->save();

//$records = accounts::findAll();
//print_r($records);

//$record = todos::save();
//$records1 = todos::create();



?>
