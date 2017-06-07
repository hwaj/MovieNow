<?php

$url = "http://movie.naver.com/movie/running/current.nhn";

function curl_get_content($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $content = curl_exec($ch);
  curl_close($ch);
  return $content;
}

$return = curl_get_content($url);

$pattern = '/<a href="([^\d]+\d{6})">(.*)<\/a>/U';
//out[][0]=태그 전체, [1]=첫번째 ()안 내용, [2]=두번째 ()안 내용

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

echo $num."<br>";
for($i=0;$i<($num);$i++){
echo $i.")".$out[$i][0]."...".$out[$i][2]."<br>"; 
}

?>
