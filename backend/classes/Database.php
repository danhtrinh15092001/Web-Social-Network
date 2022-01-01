<?php
    class Database{
        protected $con;
        protected static $instance;

        protected function __construct()
        {
            try{
                $this->con=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
                $this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
            }catch(PDOExeption $e)
            {
                echo "Connect failed: ".$e->getMessage();
            }
        }

        public static function instance()
        {
            if (self::$instance===null)
            {
                self::$instance=new self;
            }
            return self::$instance;
        }

        public function __call($method,$args)
        {
            return call_user_func_array(array($this->con,$method),$args);
        }

        public static function query($query,$params=array())
        {
            $stmt=self::instance()->prepare($query);
            $stmt->execute($params);

            if (explode(' ',$query)[0]=='SELECT')
            {
                $data=$stmt->fetchAll();
                return $data;
            }
        }
    }
?>