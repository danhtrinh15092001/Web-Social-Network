<?php
    class FormSanitizer{

        public static function formSanitizerString($input)
        {
            $input=trim(strip_tags($input));
            $input=htmlspecialchars($input);
            return $input;
        }

        public static function formSanitizerName($input)
        {
            $input=trim(strip_tags($input));
            $input=htmlspecialchars($input);
            $input=strtolower($input);
            $input=ucfirst($input);
            return $input;
        }
    }
?>