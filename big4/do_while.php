<?php
//this is no good because it can present false information 
//pros: if you want the code to run once only then check for next!?
 $i = 1;
do {
    echo $i;
} while ($i > 2);

//In a do--while loop, the test condition evaluation is at the end of the loop.  This means that the code inside of the loop will iterate once through before the condition is ever evaluated.  This is ideal for tasks that need to execute once before a test is made to continue, such as test that is dependant upon the results of the loop.  


?>


