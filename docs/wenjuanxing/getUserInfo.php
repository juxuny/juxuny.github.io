<?php
$conn = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS,  SAE_MYSQL_DB, SAE_MYSQL_PORT);
$sql = 'SET NAMES utf8';
mysqli_query($conn, $sql);

$appid = "wxcc607f2ac191a91b";  
$secret = "cc6a1ccfdbadc162b9acffce9140a78e";  
$code = $_GET["code"];
 
//第一步:取得openid
$oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
$oauth2 = getJson($oauth2Url);
$access_token=$oauth2['access_token'];
$openid=$oauth2['openid'];
//第二步:根据全局access_token和openid查询用户信息     
$get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
$userinfo = getJson($get_user_info_url);
//var_dump($userinfo);

//第三步：取得UnionID（强制关注公众号步骤）
$conn = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS,  SAE_MYSQL_DB, SAE_MYSQL_PORT);
$sql = 'SET NAMES utf8';
mysqli_query($conn, $sql);
$sql = "SELECT * FROM dtjilu1";
$result1 = mysqli_query($conn,$sql);
$msg=mysqli_fetch_assoc($result1);
if($msg==null){
    $time=date('Y-m-d H:i:s');
    $a_time = strtotime($time);
    $time11 = strtotime('+2 Hour',$a_time);
	$q="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
	$p= getJson($q);
	$access_token1=$p['access_token'];
    $conn = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS,  SAE_MYSQL_DB, SAE_MYSQL_PORT);
    $sql = 'SET NAMES utf8';
    mysqli_query($conn, $sql);
    $sql = "INSERT INTO dtjilu1 VALUES(NULL,'$time11','$access_token1')";
    $result = mysqli_query($conn,$sql);
}
$conn = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS,  SAE_MYSQL_DB, SAE_MYSQL_PORT);
$sql = 'SET NAMES utf8';
mysqli_query($conn, $sql);
$sql = "SELECT * FROM dtjilu1";
$result3 = mysqli_query($conn,$sql);
$msg=mysqli_fetch_assoc($result3);
$time11=$msg['time'];
$time=date('Y-m-d H:i:s');
$time22 = strtotime($time);
$time111 = strtotime('+2 Hour',$time22);
if($time22>$time11){
    $q="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
	$p= getJson($q);
	$access_token1=$p['access_token'];
	$conn = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS,  SAE_MYSQL_DB, SAE_MYSQL_PORT);
    $sql = 'SET NAMES utf8';
    mysqli_query($conn, $sql);
    $sql = "UPDATE dtjilu1 SET time = '$time111',token = '$access_token1' WHERE cid = '1'";
    $result = mysqli_query($conn,$sql);
}
$conn = mysqli_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS,  SAE_MYSQL_DB, SAE_MYSQL_PORT);
$sql = 'SET NAMES utf8';
mysqli_query($conn, $sql);
$sql = "SELECT * FROM dtjilu1";
$result2 = mysqli_query($conn,$sql);
$msg=mysqli_fetch_assoc($result2);
$access_token1=$msg['token'];
$UnionIDurl="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token1&openid=$openid&lang=zh_CN";
$UnionID1 = getJson($UnionIDurl);
$UnionID=$UnionID1['subscribe'];


//打印用户信息
  //print_r($userinfo);
  //print_r($oauth2);
//print_r($UnionID);
session_start();  
$_SESSION['one']=$openid; 
$_SESSION['tow']=$UnionID; 
header('Location: https://guanhu.applinzi.com/wenjuanxing/index2.php');
 
function getJson($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}
$sql = "select op, COUNT(op) as Count from biao group by op having COUNT(op)>1";
$result = mysqli_query($conn, $sql);
if($result>1){
	
}else{
$sql = "INSERT INTO biao VALUES (NULL,'$openid')";
$result = mysqli_query($conn, $sql);
}
?>