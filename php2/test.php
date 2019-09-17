<?php

$x = 'jk';
$y = 10;
$z = (string)$y;
$z = "_".$z;

$width = 500;
$height = 100;

echo $z;

?>


<html>
    <head>
        <style>
            #_10{
                color: blue;
                background: red; 
            }
            /* using php to change styling  */
            #divv
            {
                background: pink;
                height : <?php echo $height."px" ?>;                
                width: <?php echo $width."px" ?>;
            }
        </style>
    </head>
    <body>
        <p id = <?php echo $z ?> > harshit </p>

        <div id = "divv"> my name</div>
    
    <script>
        function baseline(y)
        {
            document.write('y: ' + y);                  // method to use php in script
            document.write(<?php echo $y ?>);         // another method 

            while( y != 0)
            {
                document.write(y);
                y--;
            }
        }
        
        <?php
                echo "baseline('$y')";
        ?>

    </script>
    
    </body>
</html>