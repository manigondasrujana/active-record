<?php
namespace activerecord;

abstract class model {
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
      
	        //echo 'I just updated record' . $this->id;
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

?>