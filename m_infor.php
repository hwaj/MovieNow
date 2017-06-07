<?php
//영화 별 url 주소 
$url = "http://movie.naver.com/movie/bi/mi/basic.nhn?code=162173";

function curl_get_content($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $content = curl_exec($ch);
  curl_close($ch);
  return $content;
}

$return = curl_get_content($url);

//영화명 필터
$pattern = '/<a href="\.\/basic\.nhn\?code=\d+">(.*)<\/a>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

$movie_name = $out[0][1];
echo $movie_name."<br>";

//썸네일 필터

$pattern = '/false;\"\>\<img src=\"(http:\/\/movie\d?\.phinf\.naver\.net\/[^\?]+)\?/';
$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

$thumbnail = $out[0][1];
echo $thumbnail."<br>";


//관람객, 네티즌 평점 필터
$pattern = '/<em class="num\d">(.*)<\/em>/U';
//out[][0]=태그 전체, [1]=첫번째 ()안 내용, [2]=두번째 ()안 내용

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

$audience = $out[0][1]+ ($out[1][1]*0.1)+ ($out[2][1]*0.01);
$netizen = $out[3][1]+ ($out[4][1]*0.1)+ ($out[5][1]*0.01);

echo $audience."<br>";
echo $netizen."<br>";

//평점 참여자 수 필터

$pattern = '/<span class="user_count">(.*)<em>(.*)<\/em>(.*)<\/span>/U';
//out[][0]=태그 전체, [1]=첫번째 ()안 내용, [2]=두번째 ()안 내용

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
$audience_num=$out[0][2];

echo $audience_num."<br>";

//장르 필터
$pattern = '/<a href="\/movie\/sdb\/browsing\/bmovie\.nhn\?genre=\d+">(.*)<\/a>/U';

$genre_num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
//genre_num/2:장르갯수 , out[][1]:장르 
$genre_num /= 2;

//echo $genre_num."<br>";
$genre = "";
for($i=0;$i<($genre_num);$i++)
{
$genre .= $out[$i][1];
if($i+1<($genre_num)){
$genre .=",";
}
}
echo $genre."<br>";

//런타임 필터
$pattern = '/<span>.* <\/span>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
//out[0][0]:런타임 
$runtime = $out[0][0];

echo $runtime."<br>";

//개봉일 필터
$pattern = '/<a href="\/movie\/sdb\/browsing\/bmovie\.nhn\?open=(\d{8})">(.*)<\/a>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
 
$premier = $out[0][1][0].$out[0][1][1].$out[0][1][2].$out[0][1][3].".".$out[0][1][4].$out[0][1][5].".".$out[0][1][6].$out[0][1][7];

echo $premier."<br>";

//감독 및 배우 필터
$pattern = '/<p>(<a href="\/movie\/bi\/pi\/basic\.nhn\?code=\d+">(.*)<\/a>.*)<\/p>/U';
$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

//감독들
$pattern = '/<a href="\/movie\/bi\/pi\/basic\.nhn\?code=\d+">(.*)<\/a>/U';
$director_num = preg_match_all($pattern,$out[0][1],$out1,PREG_SET_ORDER);
for($i=0;$i<$director_num;$i++){
	$director[$i] = $out1[$i][1];
}

for($i=0;$i<$director_num;$i++){
echo $director[$i]." , ";
}
echo "<br>";
//배우들
$pattern = '/<a href="\/movie\/bi\/pi\/basic\.nhn\?code=\d+">(.*)<\/a>/U';
$actor_num = preg_match_all($pattern,$out[1][1],$out2,PREG_SET_ORDER);
for($i=0;$i<$actor_num;$i++){
	$actor[$i] = $out2[$i][1];
}

for($i=0;$i<$actor_num;$i++){
echo $actor[$i]." , ";
}
echo "<br>";

//관람가 필터
$pattern = '/<a href="\/movie\/sdb\/browsing\/bmovie\.nhn\?grade=\d+">(.*)<\/a>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
$rating = $out[0][1];
 
echo $rating."<br>";

//줄거리 필터
$pattern = '/<p class="con_tx">(.*)<\/p>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
$story = $out[0][1];
 
echo $story."<br>";

//////////////데이터베이스 연결하는 구문////////////////////




?>
