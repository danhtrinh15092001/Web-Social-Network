<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        function twitter_copyright($startYear){
            $currentyear=date("Y");
            if ($startYear<$currentyear){
                return "&copy; $startYear&ndash;$currentyear";
            }else{
                return "&copy; $startYear";
            }
        }
        echo twitter_copyright(2021);
    ?>
</body>
</html>