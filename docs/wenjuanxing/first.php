<?php
$appid='wxcc607f2ac191a91b';
$redirect_uri = urlencode ( 'https://guanhu.applinzi.com/wenjuanxing/getUserInfo.php' );
$url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
header("Location:".$url);
?>