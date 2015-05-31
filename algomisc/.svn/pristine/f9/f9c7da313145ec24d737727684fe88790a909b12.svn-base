<?php
function BaiduResult($url) {
  $options = array(
		   'http' => array(
				   'user_agent'    => 'Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 6.0)',        // who am i
				   'max_redirects' => 10,              // stop after 10 redirects
				   'timeout'       => 120,             // timeout on response
				   )
		   );
  $context = stream_context_create( $options );
  $handle = fopen( $url, "r", false, $context );
  $result = stream_get_contents( $handle );
  fclose($handle);
  $result = str_replace('charset=gb2312', 'charset=utf-8', $result);
  $result = iconv('gb2312', 'utf-8//IGNORE', $result);
  $removed_str1 = 'if (top.location != self.location)';
  $removed_str2 = '{top.location=self.location;}';
  $idx1 = strpos($result, $removed_str1);
  $idx2 = strpos($result, $removed_str2, $idx1);
  $result1 = substr($result, 0, $idx1);
  $result2 = substr($result, $idx2 + strlen($removed_str2), strlen($result) - $idx2 - strlen($removed_str2));
  $result = $result1.$result2;
  print $result;
}
?>
<?
$query = iconv('utf-8', 'gb2312//IGNORE', $_GET['q']);
$query = urlencode($query);

if (empty($query)) {
  print 'no query';
} else {
  $urlb = 'http://www.baidu.com/s?wd='.$query;
  BaiduResult($urlb);
}
?>

