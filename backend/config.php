<?php

    //Create value
    define("DB_HOST","localhost");
    define("DB_NAME","twitter");
    define("DB_USER","twitter");
    define("DB_PASS","password");   

    $public_end=strpos($_SERVER['SCRIPT_NAME'],'/frontend')+9;
    $doc_root=substr($_SERVER['SCRIPT_NAME'],0,$public_end);
    define("WWW_ROOT",$doc_root);

    //SMTP
    define("M_HOST","smtp.gmail.com");
    define("M_USERNAME","sunshine15092001@gmail.com");
    define("M_PASSWORD","zekxnwqafliqtvfm");
    define("M_STMPSECURE","tls");
    define("M_PORT",465);