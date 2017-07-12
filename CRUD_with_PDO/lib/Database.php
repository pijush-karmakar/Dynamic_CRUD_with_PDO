<?php 

class Database{ 

private $dbhost  ="localhost";
private $dbuser  ="root";
private $dbpass  ="";
private $dbname  = "db_crud_with_pdo";

private $pdo;

public function __construct(){
    if(!isset($this->pdo) ){
    	try{
    		$link = new PDO("mysql:host=".$this->dbhost.";dbname=".$this->dbname,$this->dbuser,$this->dbpass);
    		$link->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $link->exec("SET CHARACTER SET utf8");
            $this->pdo = $link;

	    	} catch(PDOException $e){
	            die("Failed to connect with database ".$e->getMessage() );
	    	}


     }

  }




/* // -----------------------------  For Select  --------------------------- //
       ====> procedural process

$sql = 'SELECT *FROM tablename WHERE id = :id AND email = :email LIMIT 2,4';
$query = $this->pdo->prepare($sql);
$query->bindValue( ':id',$id );
$query->bindValue( ':email',$email );
$query->execute();

*/

// ====> Dynamic process 

public function select($table,$data = array() ){
  $sql     = ' SELECT ';
  $sql    .= array_key_exists("select", $data)?$data['select']:'*';
  $sql    .= ' FROM '.$table ;
  if(array_key_exists("where", $data) ){
       $sql   .= ' WHERE ';
       $i = 0;
       foreach ($data['where'] as $key => $value) {
       	  $add  = ($i > 0)?' AND ':'';
       	  $sql .= "$add"."$key = :$key";
       	  $i++;
       }
  }
  
  if(array_key_exists("order_by", $data) ){
     $sql  .= ' ORDER BY '.$data['order_by'];
  } 

  if(array_key_exists("start", $data) && array_key_exists("limit", $data) ){
      $sql  .= ' LIMIT '.$data['start'].','.$data['limit'] ;
  }
  elseif( ! array_key_exists("start", $data) && array_key_exists("limit", $data) ) {
       $sql  .= ' LIMIT '.$data['limit'];
  }


$query = $this->pdo->prepare($sql);

  if(array_key_exists('where', $data) ){
       foreach ($data['where'] as $key => $value) {
       	  $query->bindValue(":$key","$value");
       }
  }

$query->execute();  

 if(array_key_exists("return_type", $data) ){
		switch ($data['return_type']) {
			case 'count':
				$value = $query->rowCount();
				break;

			case 'single':
				$value = $query->fetch(PDO::FETCH_ASSOC);
				break;	
			
			default:
				$value = '';
				break;
		}
 }
 else{
     if($query->rowCount() > 0 ){
     	$value = $query->fetchAll();
     }
 }

 return !empty($value)?$value:false;


}


// -----------------------------  For Insert  --------------------------- //
/*
$sql = 'INSERT INTO tablename (name,email) VALUES(:name,:email)';
$query = $this->pdo->prepare($sql);
$query->bindValue( ':name',$name );
$query->bindValue( ':email',$email );
$query->execute();


*/

public function insert($table,$data){
   if(!empty($data) && is_array($data) ){
       $keys   =" ";
       $values = " ";

       $keys    = implode(',', array_keys($data) );
       $values  = ":".implode(', :', array_keys($data) );
       $sql     = "INSERT INTO ".$table." (".$keys.") VALUES (".$values.")" ;
       $query = $this->pdo->prepare($sql); 

       foreach ($data as $key => $val) {
            $query->bindValue(":$key",$val);
       }

       $insertdata = $query->execute();
      if($insertdata){
          $lastid = $this->pdo->lastInsertId();
          return $lastid;
      } else{
          return false;
      } 


   }
}

// -----------------------------  For Update  --------------------------- //
/*
$sql = 'UPDATE tablename set name= :name,email= :emnail WHERE id= :id';
$query = $this->pdo->prepare($sql);
$query->bindValue( ':name',$name );
$query->bindValue( ':email',$email );
$query->bindValue( ':id',$id );
$query->execute();


*/

public function update($table,$data,$cond){
   if(!empty($data) && is_array($data) ){
         $keyvalue  = '';
         $wherecond = '';
         $i=0;
          foreach ($data as $key => $val) {
            $add  = ($i > 0)? ' , ' :'';
            $keyvalue .= "$add"."$key = :$key";
            $i++;
         }
         if( !empty($cond) && is_array($cond) ){
              $wherecond .= " WHERE "  ;
              $i=0;
              foreach ($cond as $key => $val) {
                $add  = ($i > 0)? ' AND ' :'';
                $wherecond .= "$add"."$key = :$key";
                $i++;
             }
         }

         $sql     = "UPDATE ".$table." SET ".$keyvalue.$wherecond ;
         $query = $this->pdo->prepare($sql); 

         foreach ($data as $key => $val) {
              $query->bindValue(":$key",$val);
         }
         
         foreach ($cond as $key => $val) {
              $query->bindValue(":$key",$val);
         }

         $update= $query->execute();
         return $update?$query->rowCount():false;
         
  } else{
      return false;
  }


}

// -----------------------------  For Delete  --------------------------- //
/*
$sql = 'DELETE tablename  WHERE id= :id';
$query = $this->pdo->prepare($sql);
$query->bindValue( ':id',$id );
$query->execute();

*/

public function delete($table,$data){
  /*  // process with bind value

     if(!empty($data) && is_array($data) ){
      $wherecond .= " WHERE ";
         $i=0;
          foreach ($data as $key => $val) {
            $add  = ($i > 0)? ' AND ' :'';
            $wherecond .= "$add"."$key = :$key";
            $i++;
         }
     }

   $sql     = "DELETE FROM ".$table.$wherecond ;
   $query   = $this->pdo->prepare($sql); 

       foreach ($data as $key => $val) {
            $query->bindValue(":$key",$val);
       }
   $delete = $query->execute() ;
   return $delete?true:false ;
}  */

// Another process to delete data

     if(!empty($data) && is_array($data) ){
      $wherecond .= " WHERE ";
         $i=0;
          foreach ($data as $key => $val) {
            $add  = ($i > 0)? ' AND ' :'';
            $wherecond .= $add.$key ." = '".$val."'";
            $i++;
         }
     }

   $sql      = "DELETE FROM ".$table.$wherecond ;
   $delete   = $this->pdo->exec($sql); 
   return $delete?true:false ;
      
   
}




}

 ?>