<?php
include_once '';

class Db{
    protected $conn;
    //constructor
    function _construct()
    {
        $dsn = "mysql:host =".Utility::$dbserver.";dbname=".Utility::$dbname . "";
        $options = [ 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC
        ];
        // instantiating the PDO class:
        try{
           $this->conn=new PDO($dsn,Utility::$dbuser,Utility::$dbpassword, $options);				
         }catch (PDOException $e){
                   echo $e->getMessage();
         }			
      }
      //The connectToDB method returns the PDO connection handle:
      public function connect_func(){
              return $this->conn;
      } 			
      public function close_connect_func(){
              $this->conn = null;
      }
    }


?>