<?php

	namespace X\App\Models;

	use \X\Sys\Model;

	class mRegister extends Model{
		public function __construct(){
			parent::__construct();

		}

        /**
        *
        * check_email: funcion que devuelve un userweb si existe el correo
        *
        */

        public function check_email($mail)
        {
            $sql='Select * From userweb Where mail="'.$mail.'"';
            $this->query($sql);
            $this->execute();
            $res=$this->execute();
            $result="";
            if($res){
                $result=$this->resultset();
            }
            return $result;
        }

        /**
        *
        * get_poblaciones: funcion que devuelve las poblaciones
        *
        */
        public function get_poblaciones()
        {
            $sql='SELECT * FROM poblacion order by nombre';
            $this->query($sql);
            $this->execute();
            $res=$this->execute();
            $result="";
            if($res){
                $result=$this->resultset();
            }
            return $result;
        }

        /**
        *
        * check_username: funcion que devuelve un userweb si existe el username
        *
        */

        public function check_username($username)
        {
            $sql='Select * From userweb Where username="'.$username.'"';
            $this->query($sql);
            $this->execute();
            $res=$this->execute();
            $result="";
            if($res){
                $result=$this->resultset();
            }
            return $result;
        }

        /**
        *
        * insert: funcion que inserta un userweb
        *
        */

        public function insert($username,$pass,$email)
        {
            $sql='Insert into userweb (mail, password, roles, fecha_registro, username) Values ("'.$email.'","'.$pass.'",2,"'.	Date("Y-m-d").'","'.$username.'")';
						$this->query($sql);
            $this->execute();
        }

        /**
        *
        * insert_a: funcion que inserta un alumno
        *
        */

        public function insert_a($apellidos,$nombre,$dni,$direccion,$telefono,$poblacion,$userweb)
        {
            $sql='Call new_alumno ("'.$apellidos.'","'.$nombre.'","'.$dni.'","'.$direccion.'","'.$telefono.'","'.$poblacion.'","'.$userweb.'")';
            $this->query($sql);
            $res = $this->execute();
						return $res;
        }
	}
