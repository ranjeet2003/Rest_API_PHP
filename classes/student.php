<?php
    class Student{
        public $name;
        public $email;
        public $mobile;

        private $conn;
        private $table_name;

        // constructor
        public function __construct($db){

            $this->conn=$db;
            $this->table_name= "tbl_students";
        }


        public function create_data(){
            // sql query to insert data
            $query="INSERT INTO ".$this->table_name." SET name = ?, email = ?, mobile = ?";
            // prepare the sql 
            $obj = $this->conn->prepare($query);

            // sanitize input variable => basically removes the extra characters likes som special symbol as well as if some tags availabel in input values
            $this->name= htmlspecialchars(strip_tags($this->name));
            $this->email= htmlspecialchars(strip_tags($this->email));
            $this->mobile= htmlspecialchars(strip_tags($this->mobile));
            // binding parameter with prepared statements
            $obj->bind_param("sss", $this->name, $this->email, $this->mobile);
            if($obj->execute()){
                return true;
            }
            return false;
        }
        // read all data
        public function get_all_data(){
            $sql_query="SELECT * FROM ".$this->table_name;

            $std_obj=$this->conn->prepare($sql_query); //prepare statement;

            $std_obj->execute();

            return $std_obj->get_result();
        }
        // read single student data
        public function get_single_student(){
            $sql_query="SELECT * from ".$this->table_name." WHERE id = ?";

            // prepare stataement
            $obj=$this->conn->prepare($sql_query); //prepare statement;
            $obj->bind_param("i", $this->id); //bind parameters with te hprepared stsatement
            $obj->execute();
            $data=$obj->get_result();
            return $data->fetch_assoc();
            
        }
    }
?>