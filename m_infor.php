<?php
//��ȭ �� url �ּ� 
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

//��ȭ�� ����
$pattern = '/<a href="\.\/basic\.nhn\?code=\d+">(.*)<\/a>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

$movie_name = $out[0][1];
echo $movie_name."<br>";

//����� ����

$pattern = '/false;\"\>\<img src=\"(http:\/\/movie\d?\.phinf\.naver\.net\/[^\?]+)\?/';
$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

$thumbnail = $out[0][1];
echo $thumbnail."<br>";


//������, ��Ƽ�� ���� ����
$pattern = '/<em class="num\d">(.*)<\/em>/U';
//out[][0]=�±� ��ü, [1]=ù��° ()�� ����, [2]=�ι�° ()�� ����

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

$audience = $out[0][1]+ ($out[1][1]*0.1)+ ($out[2][1]*0.01);
$netizen = $out[3][1]+ ($out[4][1]*0.1)+ ($out[5][1]*0.01);

echo $audience."<br>";
echo $netizen."<br>";

//���� ������ �� ����

$pattern = '/<span class="user_count">(.*)<em>(.*)<\/em>(.*)<\/span>/U';
//out[][0]=�±� ��ü, [1]=ù��° ()�� ����, [2]=�ι�° ()�� ����

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
$audience_num=$out[0][2];

echo $audience_num."<br>";

//�帣 ����
$pattern = '/<a href="\/movie\/sdb\/browsing\/bmovie\.nhn\?genre=\d+">(.*)<\/a>/U';

$genre_num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
//genre_num/2:�帣���� , out[][1]:�帣 
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

//��Ÿ�� ����
$pattern = '/<span>.* <\/span>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
//out[0][0]:��Ÿ�� 
$runtime = $out[0][0];

echo $runtime."<br>";

//������ ����
$pattern = '/<a href="\/movie\/sdb\/browsing\/bmovie\.nhn\?open=(\d{8})">(.*)<\/a>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
 
$premier = $out[0][1][0].$out[0][1][1].$out[0][1][2].$out[0][1][3].".".$out[0][1][4].$out[0][1][5].".".$out[0][1][6].$out[0][1][7];

echo $premier."<br>";

//���� �� ��� ����
$pattern = '/<p>(<a href="\/movie\/bi\/pi\/basic\.nhn\?code=\d+">(.*)<\/a>.*)<\/p>/U';
$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);

//������
$pattern = '/<a href="\/movie\/bi\/pi\/basic\.nhn\?code=\d+">(.*)<\/a>/U';
$director_num = preg_match_all($pattern,$out[0][1],$out1,PREG_SET_ORDER);
for($i=0;$i<$director_num;$i++){
	$director[$i] = $out1[$i][1];
}

for($i=0;$i<$director_num;$i++){
echo $director[$i]." , ";
}
echo "<br>";
//����
$pattern = '/<a href="\/movie\/bi\/pi\/basic\.nhn\?code=\d+">(.*)<\/a>/U';
$actor_num = preg_match_all($pattern,$out[1][1],$out2,PREG_SET_ORDER);
for($i=0;$i<$actor_num;$i++){
	$actor[$i] = $out2[$i][1];
}

for($i=0;$i<$actor_num;$i++){
echo $actor[$i]." , ";
}
echo "<br>";

//������ ����
$pattern = '/<a href="\/movie\/sdb\/browsing\/bmovie\.nhn\?grade=\d+">(.*)<\/a>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
$rating = $out[0][1];
 
echo $rating."<br>";

//�ٰŸ� ����
$pattern = '/<p class="con_tx">(.*)<\/p>/U';

$num = preg_match_all($pattern,$return,$out,PREG_SET_ORDER);
$story = $out[0][1];
 
echo $story."<br>";

//////////////�����ͺ��̽� �����ϴ� ����////////////////////




?>
