<?php
include 'Config/database.php';

class BaseModel
{
    private $db;
    public static $instance;
    protected $data =[];
    protected $empty = [];
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new BaseModel();
        }
        return self::$instance;
    }

    public function __construct(){
        // print_r(DATABASE);
        try{$this->db = new PDO('mysql:host='.DATABASE['HOST'].';port='.DATABASE['PORT'].';dbname='.DATABASE['DBNAME'].';',DATABASE['USERNAME'],DATABASE['PASSWORD']);
            // $this->db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            die("Error! ". $e->getMessage() ."<br>");
        }
    }
    public function arrayToString($array){
        $string ="";
        foreach($array as $key=>$value){
            $string = $string. "`{$key}` = :{$key} AND ";
        }
        return rtrim($string,"AND ") ;
    }
    public function arrayToColoumns($array){
        $string ="";
        foreach($array as $key=>$value){
            $string = $string. "`{$key}` = :{$key}, ";
        }
        return rtrim($string,", ");
    }
    public function selectQuery($tableName,$conditionsString){
        return $selectQuery = "SELECT * FROM `{$tableName}` WHERE ".$conditionsString."";
    }
    public function deleteQuery($tableName,$conditionsString){
        return $deleteQuery = "DELETE FROM `{$tableName}` WHERE ".$conditionsString."";
    }
    public function updateQuery($tableName,$conditionsString,$updateString){
        return $updateQuery = "UPDATE `{$tableName}` SET ".$updateString." WHERE ".$conditionsString."";
    }
    public function valueBinding($conditions=[],$updates=[],$case){
        $conditionsString = $this->arrayToString($conditions);
        $caseQuery = $case.'Query';
        if($case == "update") {
            $updateString = $this->arrayToColoumns($updates);
            $query = $this->$caseQuery($this->tableName,$conditionsString,$updateString);
        }
        else{
            $query = $this->$caseQuery($this->tableName,$conditionsString);
        }
        $sth = $this->db->prepare($query);
        $this->valueBind($conditions,$sth);
        if($case == "update"){
            $this->valueBind($updates,$sth);
        }
        $sth->execute();
        return $sth;

        // switch ($case){
        //     case 1: $query = $this->selectQuery($this->tableName,$conditionsString);
        //             $sth = $this->db->prepare($query);
        //             $this->valueBind($conditions,$sth);
        //             $sth->execute();
        //             return $sth;
        //             break;
        //     case 2: $query = $this->deleteQuery($this->tableName,$conditionsString);
        //             $sth = $this->db->prepare($query);
        //             $this->valueBind($conditions,$sth);
        //             $sth->execute();
        //             return $sth;
        //             break;
        //     case 3: $updateString = $this->arrayToColoumns($updates);
        //             $query = $this->updateQuery($this->tableName,$conditionsString,$updateString);
        //             $sth = $this->db->prepare($query);
        //             $this->valueBind($conditions,$sth);
        //             $this->valueBind($updates,$sth);
        //             $sth->execute();
        //             return $sth;
        //             break;
        // }
    }
    public function valueBind($array,$sth){
        foreach($array as $key=>$value){
            $sth->bindValue(":{$key}",$value);
        }  
    }
    public function fetchAll($conditions=[]){
        try{
        $result = $this->valueBinding($conditions,NULL,"select");
        while($row = $result->fetch(PDO::FETCH_OBJ) ){
            $this->data[] = $row;
        }
        return $this->data;  
        }
        catch(Exception $e){
            echo $e->getLine().$e->getMessage();
        }
    }
    public function fetchRow($conditions=[]){
        try{
            $result = $this->valueBinding($conditions,NULL,"select");
            $row = $result->fetch(PDO::FETCH_OBJ);
            return $row;  
        }
        catch(Exception $e){
            echo $e->getLine().$e->getMessage();
        }
    }
    public function delete($conditions=[]){
        try{
            $result = $this->valueBinding($conditions,NULL,"delete");            
            if($result){
                $msg = "Deleted successfully";
                return $msg;
            }
        }
        catch(Exception $e){
            echo $e->getLine().$e->getMessage();
        }
        
    }
    public function update($conditions=[],$updates=[]){   
        try{
            $result = $this->valueBinding($conditions,$updates,"update");
            if($result){
                $msg = "Updated successfully";
                return $msg;
            }
        }
        catch(Exception $e){
            echo $e->getLine().$e->getMessage();
        }
    }
}
