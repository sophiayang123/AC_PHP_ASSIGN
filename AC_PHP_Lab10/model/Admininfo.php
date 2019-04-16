<?php
    class Admininfo{
        private $adminID;
        private $userName;
        private $password;
        private $lastLogin;

        function __construct($adminID, $userName, $password, $lastLogin){
            $this->setAdminID($adminID);
            $this->setuserName($userName);
			$this->setPassword($password);
            $this->setLastLogin($lastLogin);
		}	

        public function getAdminID(){
			return $this->adminID;
		}
		
		public function setAdminID($adminID){
			$this->adminID = $adminID;
		}
		
		public function getuserName(){
			return $this->userName;
		}
		
		public function setuserName($userName){
			$this->userName = $userName;
		}
		
		public function getPassword(){
			return $this->password;
		}
		
		public function setPassword($password){
			$this->password = $password;
		}
		
		public function getLastLogin(){
			return $this->lastLogin;
		}
		
		public function setLastLogin($lastLogin){
			$this->lastLogin = $lastLogin;
        }

    }
?>