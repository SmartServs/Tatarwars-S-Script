<?php
function replace_data_p_players($vars){  
$return = '<span style="font-style:italic;">لم يتم العثور على اللاعب</span>';  
return $return;  
} 

function replace_data_p_alliances($vars){  
$return = '<span style="font-style:italic;">لم يتم العثو على التحالف</span>';  
return $return;  
} 

function replace_data_p_map($vars){   
$return = '<span style="font-style:italic;">لم يتم العثور على احداثيات القرية</span>';   
return $return;   
}  


$topic = preg_replace_callback('/\[player\](.*?)\[\/player\]/i','replace_data_p_players',$topic);  
$topic = preg_replace_callback('/\[alliance\](.*?)\[\/alliance\]/i','replace_data_p_alliances',$topic);  
$topic = preg_replace_callback('/\[x\|y\](.*[^\|]?)\|(.*[^\|]?)\[\/x\|y\]/i','replace_data_p_map',$topic); 
$topic = str_replace("[b]","<b>",$topic); $topic = str_replace("[/b]","</b>",$topic);
$topic = str_replace("[i]","<i>",$topic); $topic = str_replace("[/i]","</i>",$topic);
$topic = str_replace("[u]","<u>",$topic); $topic = str_replace("[/u]","</u>",$topic);

$x = 1;
while ($x < 51) {
$topic = str_replace("[tid$x]","<img class='unit u$x' src=core-s/st-s/x.gif>",$topic);
$x++;
}

$topic = str_replace("[hero]","<img src=core-s/st-s/default/img/u/hero.gif>",$topic);
$topic = str_replace("[r1]","<img src=core-s/st-s/default/img/r/1.gif>",$topic);
$topic = str_replace("[r2]","<img src=core-s/st-s/default/img/r/2.gif>",$topic);
$topic = str_replace("[r3]","<img src=core-s/st-s/default/img/r/3.gif>",$topic);
$topic = str_replace("[r4]","<img src=core-s/st-s/default/img/r/4.gif>",$topic);

$topic = str_replace("*aha*","<img class='smiley aha' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*angry*","<img class='smiley angry' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*cool*","<img class='smiley cool' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*cry*","<img class='smiley cry' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*cute*","<img class='smiley cute' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*depressed*","<img class='smiley depressed' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*eek*","<img class='smiley eek' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*ehem*","<img class='smiley ehem' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*emotional*","<img class='smiley emotional' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace(":D","<img class='smiley grin' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace(":)","<img class='smiley happy' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*hit*","<img class='smiley hit' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*hmm*","<img class='smiley hmm' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*hmpf*","<img class='smiley hmpf' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*hrhr*","<img class='smiley hrhr' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*huh*","<img class='smiley huh' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*lazy*","<img class='smiley lazy' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*love*","<img class='smiley love' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*nocomment*","<img class='smiley nocomment' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*noemotion*","<img class='smiley noemotion' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*notamused*","<img class='smiley notamused' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*pout*","<img class='smiley pout' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*redface*","<img class='smiley redface' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*rolleyes*","<img class='smiley rolleyes' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace(";)","<img class='smiley wink' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*veryhappy*","<img class='smiley veryhappy' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*veryangry*","<img class='smiley veryangry' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*tongue*","<img class='smiley tongue' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*smile*","<img class='smiley smile' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace("*shy*","<img class='smiley shy' src=core-s/st-s/x.gif>",$topic);
$topic = str_replace(":(","<img class='smiley sad' src=core-s/st-s/x.gif>",$topic);



?>