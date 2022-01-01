<?php
    class Verify{
        private $pdo;
        private $user;

        public function __construct()
        {
            $this->pdo=Database::instance();
            $this->user=new User;
        }

        public function generateLink()
        {
            return str_shuffle(substr(md5(time().mt_rand().time()),0,25));
        }

        public function verifyCode($targetColumn,$code)
        {
            return $this->user->get('verification',$targetColumn,array('code'=>$code));
        }

        public function getVerifyStatus($targetColumn,$user_id)
        {
            return $this->user->get('verification',$targetColumn,array('user_id'=>$user_id));
        }

        public function authOnly($userId){
            $stmt=$this->pdo->prepare("SELECT * FROM `verification` WHERE user_id=:userId ORDER BY `createAt`");
            $stmt->bindParam(":userId",$userId,PDO::PARAM_INT);
            $stmt->execute();
            $user=$stmt->fetch(PDO::FETCH_OBJ);
            $files=array('verification.php');
            if(!$this->user->is_log_in()){
                redirect_to(url_for('index'));
            }

            if(!empty($user)){
                if($user->status==='0' && !in_array(basename($_SERVER['SCRIPT_NAME']),$files)){
                    redirect_to(url_for('verification'));
                }

                if($user->status==='1' && in_array(basename($_SERVER['SCRIPT_NAME']),$files)){
                    redirect_to(url_for('home'));
                }
            }else if(!in_array(basename($_SERVER['SCRIPT_NAME']),$files)){
                redirect_to(url_for('verification'));
            }
        }

        public function sendToMail($email,$message,$subject){
            $mail=new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth=true;
            $mail->SMTPDebug=0;
            $mail->Host = "ssl://smtp.gmail.com";
            $mail->Username=M_USERNAME;
            $mail->Password=M_PASSWORD;
            $mail->SMPTSecure=M_STMPSECURE;
            $mail->Port=M_PORT;

            if (!empty($email))
            {
                $mail->From="sunshine15092001@gmail.com";
                $mail->FromName="TWITTER";
                $mail->addReplyTo("no-reply@gmail.com");
                $mail->addAddress($email);

                $mail->Subject=$subject;

                $mail->Body=$message;
                $mail->AltBody=$message;

                if ($mail->send())
                {
                    return true;
                }
                else{
                    return false;
                }
            }
        }
    }