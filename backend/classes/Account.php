<?php
    class Account{
        private $pdo;
        private $errorArray=array();

        public function __construct()
        {
            $this->pdo=Database::instance();
        }

        public function register($fn,$ln,$un,$em,$pw,$rpw)
        {
            $this->isInvalidFirstName($fn);
            $this->isInvalidLastName($ln);
            $this->validateEmail($em);
            $this->validatepassword($pw,$rpw);
            if (empty($this->errorArray))
            {
                $data=$this->addUserDetails($fn,$ln,$un,$em,$pw);
                $this->addProfileDetails($data,$fn,$ln,$em);
                return $data;
            }
            
            else{
                return false;
            }
        }

        public function login($username,$pass){
            $pass_hash=$this->getHashPassword($username);
            $stmt=$this->pdo->prepare("SELECT * FROM `users` WHERE (username=:un and password=:pass) or (email=:un and password=:pass) ");
            $stmt->bindParam(":un",$username,PDO::PARAM_STR);
            $stmt->bindParam(":pass",$pass_hash,PDO::PARAM_STR);
            $stmt->execute();
            $user=$stmt->fetch(PDO::FETCH_OBJ);
            $count=$stmt->rowCount();
            if ($count!=0)
            {
                if (password_verify($pass,$pass_hash))
                {
                    return $user->user_id;
                }
                else{
                    array_push($this->errorArray,constant::$loginFailed);
                    return false;
                }
            }
            else{
                array_push($this->errorArray,constant::$loginFailed);
                return false;
            }
        }

        private function getHashPassword($un){
            $stmt=$this->pdo->prepare("SELECT `password` FROM `users` WHERE username=:un OR email=:un");
            $stmt->bindParam(":un",$un,PDO::PARAM_STR);
            $stmt->execute();
            $user=$stmt->fetch(PDO::FETCH_OBJ);
            $count=$stmt->rowCount();

            if ($count!=0)
            {
                return $user->password;
            }
            else{
                return false;
            }
        }

        private function isInvalidFirstName($fn)    
        {
            if ($this->length($fn,2,25))
            {
                array_push($this->errorArray,Constant::$firstNameCharactters);
            }
            return;
        }

        private function isInvalidLastName($ln)    
        {
            if ($this->length($ln,2,25))
            {
                array_push($this->errorArray,Constant::$lastNameCharactters);
            }
            return;
        }

        public function createUsername($fn,$ln)
        {
            if (!empty($fn)&&!empty($ln))
            {
                if (!in_array(Constant::$firstNameCharactters,$this->errorArray) && !in_array(Constant::$lastNameCharactters,$this->errorArray))
                {
                    $username=strtolower($fn."".$ln);
                    if ($this->checkUsernameExist($username))
                    {
                        $Random=rand();
                        $userLink=''.$username.''.$Random;
                    }
                    else{
                        $userLink=$username;
                    }
                }
                return $userLink;
            }
        }
        

        private function validateEmail($em)
        {
            $stmt=$this->pdo->prepare("SELECT email FROM twitter.users WHERE email=:email");
            $stmt->bindParam(":email",$em,PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount()!=0)
            {
                array_push($this->errorArray,Constant::$emailTaken);
            }

            if (!filter_var($em,FILTER_VALIDATE_EMAIL))
            {
                array_push($this->errorArray,Constant::$emailInvalid);
                return; 
            }
        }

        private function validatepassword($pw,$rpw){
            if ($pw!=$rpw)
            {
                array_push($this->errorArray,Constant::$diffentpass);
                return;
            }
            if ($this->length($pw,5,25))
            {
                array_push($this->errorArray,Constant::$shortpass);
                return;
            }
            if ($this->length($rpw,5,25))
            {
                array_push($this->errorArray,Constant::$shortpass);
                return;
            }
            if (preg_match("/[^A-Za-z0-9]/",$pw))
            {
                array_push($this->errorArray,Constant::$NotAlphapass);
                return;
            }
        }

        private function checkUsernameExist($username)
        {
            $stmt=$this->pdo->prepare("SELECT username FROM twitter.users WHERE username=:username");
            $stmt->bindParam(":username",$username,PDO::PARAM_STR);
            $stmt->execute();
            $count=$stmt->rowCount();
            if ($count>0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        private function addProfileDetails($userid,$fn,$ln,$em){
            $rand=rand(0,2);
            if ($rand==0)
            {
                $profileAvatar="frontend/assets/images/defaultProfilePic.png";
                $profilebackground="frontend/assets/images/backgroundCoverPic.svg";
            }else if ($rand==1)
            {
                $profileAvatar="frontend/assets/images/default_profile.png";
                $profilebackground="frontend/assets/images/backgroundImage.svg";
            }else if ($rand==2)
            {
                $profileAvatar="frontend/assets/images/profilePic.jpeg";
                $profilebackground="frontend/assets/images/backgroundCoverPic.svg";
            }
            $stmt=$this->pdo->prepare("INSERT INTO twitter.profile (user_id,firstName,lastName,email,profileImage,profileCover) VALUES (:uid,:fn,:ln,:em,:ava,:cov)");

            $stmt->bindParam(":uid",$userid,PDO::PARAM_STR);
            $stmt->bindParam(":fn",$fn,PDO::PARAM_STR); 
            $stmt->bindParam(":ln",$ln,PDO::PARAM_STR);
            $stmt->bindParam(":em",$em,PDO::PARAM_STR);
            $stmt->bindParam(":ava",$profileAvatar,PDO::PARAM_STR);
            $stmt->bindParam(":cov",$profilebackground,PDO::PARAM_STR);   
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }

        private function addUserDetails($fn,$ln,$un,$em,$pw){
            $password_hash=password_hash($pw,PASSWORD_BCRYPT);
            $rand=rand(0,2);
            if ($rand==0)
            {
                $profileAvatar="frontend/assets/images/defaultProfilePic.png";
                $profilebackground="frontend/assets/images/backgroundCoverPic.svg";
            }else if ($rand==1)
            {
                $profileAvatar="frontend/assets/images/default_profile.png";
                $profilebackground="frontend/assets/images/backgroundImage.svg";
            }else if ($rand==2)
            {
                $profileAvatar="frontend/assets/images/profilePic.jpeg";
                $profilebackground="frontend/assets/images/backgroundCoverPic.svg";
            }
            $stmt=$this->pdo->prepare("INSERT INTO twitter.users (firstName,lastName,username,email,password,profileImage,profileCover,signUpDate) VALUES (:fn,:ln,:un,:em,:pw,:ava,:cov,NOW())");

            $stmt->bindParam(":fn",$fn,PDO::PARAM_STR); 
            $stmt->bindParam(":ln",$ln,PDO::PARAM_STR);
            $stmt->bindParam(":un",$un,PDO::PARAM_STR);
            $stmt->bindParam(":em",$em,PDO::PARAM_STR);
            $stmt->bindParam(":pw",$password_hash,PDO::PARAM_STR);
            $stmt->bindParam(":ava",$profileAvatar,PDO::PARAM_STR);
            $stmt->bindParam(":cov",$profilebackground,PDO::PARAM_STR);   
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }

        private function length($input,$min,$max)
        {
            if (strlen($input)<$min)
            {
                return true;
            }
            else if(strlen($input)>$max)
            {
                return true;
            }
        }

        public function getError($error)
        {
            if (in_array($error,$this->errorArray))
            {
                return "<span class='errorMessage'>$error</span>";
            }
        }
    }
