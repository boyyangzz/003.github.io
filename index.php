<?php
$private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAIkK/aWBqODL3vMqQ
J1tsd0bac7tA12nh8E39NX17dmyXnijGUNIQ3f+V2EVVMnGSDbYZJYdYacGUNzE0Q
8qAPCEuOIlFfdtPe2FgsH8EVV7NJjdmcGS9NkmgEiotl1+o/+uD6Lyj+EC8jDpBTB
vW7I09+TDA53H1T1BOwN2ZHqdAgMBAAECgYAnFQ1VH+8LfNiuPESFIP1ycxjvvEQT
d22NuumGA0a7qNSsTscrmvYyyEQfGbg+et+pVHkLHoH04iY5b5+3VWFCy0dX234+G
QxUggaLZbwhkObXvo1po2sTL8SqWiWNLY55S8FuSg/S1FbFxOgViQNBkzquKQLz8C
Zg9Wr5iX9yeQJBAMsmXRWb6nqp9tKDfdwYPj+db8jdkm1O+S/HCaUqG8czAJgrS1y
TjmRUMmS30IfFOIgDIK9ij/G1Lbt0Tt9JCOMCQQCssfPw9UafUh0g6olYto87scdm
rt4veQWllWmn3EHkpZT07Tefp39oN6zGylBpbRMMwCZYJ4wU76PBjTEQSUZ/AkBkk
0O2dRCrVgZKxqrDEoWO/STgr0HVOCoKS2ItESHbhxaeP6D53lu6tCyWzKJC9ZM9Uz
8VVZiqM+bGTZjW1tO9AkAkTFcYy4UnkavbslBiHCUpB+oAlDrRQZ/FOQ13Id2bwI3
5mS662Qr3jdQ8CGQ0dJ+va2fj2ZQhBmmmEhZA9RXjAkEAiduQswGnHX3UDn0CRcP/
KX+b6xs1qo6yJDY0hRt10kHJZLK6RIVYVTOkjsky048cp5L5QVN5lT7xmTWRn6nGd
A==
-----END RSA PRIVATE KEY-----';

$public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCJCv2lgajgy97zKkCdbbHdG2nO7
QNdp4fBN/TV9e3Zsl54oxlDSEN3/ldhFVTJxkg22GSWHWGnBlDcxNEPKgDwhLjiJR
X3bT3thYLB/BFVezSY3ZnBkvTZJoBIqLZdfqP/rg+i8o/hAvIw6QUwb1uyNPfkwwO
dx9U9QTsDdmR6nQIDAQAB
-----END PUBLIC KEY-----';

function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

//原始数据
$t=time()*1000;
$data='0000000000000000010121,1103,wifiwx-userid,http://api.wifiwx.com/icbc/,1,null,null';
$pkeyid = openssl_pkey_get_private($private_key);
$signature= '';
$verify = openssl_sign($data, $signature, $pkeyid, OPENSSL_ALGO_MD5);
$signature=base64_encode($signature);
openssl_free_key($pkeyid);
$url='https://gw.open.icbc.com.cn/ui/wapb/payment/V1/entry?A=00000000000000000101&B='.urlencode('21,1103,wifiwx-userid,http://api.wifiwx.com/icbc/,1,null,null').'&T='.$t.'&S='.urlencode($signature).'';
echo '<script>window.location.href = "'.$url.'"</script>';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>工银e缴费</title>
  <link rel="stylesheet" href="/css/module.v2.css">
  <script src="/js/zepto.min.js"></script>
</head>
<body>
  <div id="page" class="loading">
    <div class="section">
      <div id="error-msg" class="tc"></div>
    </div>
  </div>
  <script src="/js/api.min.js?22611130"></script>
  <script>
    authUserSuccess = function() {
      window.location.href = "<?php echo $url?>";
    }
    loadingPage = $('#page');
    appErrorMsgBox = $('#error-msg');
    callUserInfo();
  </script>
  <script src="//app.wifiwx.com/js/stat.js"></script>
</body>
</html>