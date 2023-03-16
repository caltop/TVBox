<?php
/*
---竹子哥学习---
*/
$api = 'https://www.foodieguide.com/iptvsearch/?page=1&s=';
$s = $_GET['s'];
$data=http_get($api.$s);//取源码



 $jtarr=get_txt($data);//取数组


for ($i=0; $i<count($jtarr); $i++) {
	     $jtarr=array_unique($jtarr);//去重复
		 $jtarr=array_values($jtarr);//重组，关键
    	 $uu1=$s.",".$jtarr[$i]."<br />";		 
		 $uus1=$uus1.$uu1;//整个txt文本		 
	     }
	 

if ($uus1!=''){//输出并写出文本
	echo $uus1;
    //file_put_contents('CCTV.txt',"网络频道,#genre#\n".$uus1.$uus2.$uus3);
}else{
	echo '获取文件失败，请重试！';
}
	 
function get_txt($url){//取数组函数
    preg_match_all("/http:\/\/.*?\.m3u8/",$url,$text);
	return $text[0];//返回匹配0
}


function http_get($url,$post_data = '', $ua = '' , $cookie = '',  $redirect = true){
		$refere = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$header = array("Referer:".$refere,"User-Agent:".$_SERVER['HTTP_USER_AGENT']);
		// 初始化cURL
		$curl = curl_init();
		//伪造IP
		$ip = mt_rand(11, 191) . "." . mt_rand(0, 240) . "." . mt_rand(1, 240) . "." . mt_rand(1, 240);
		// 设置网址
		curl_setopt($curl,CURLOPT_URL, $url);
		// 设置UA
		if(empty($ua) == false){
			$header[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36';
		}
		// 设置Cookie
		if(empty($cookie) == false){
			$header[] = 'Cookie:'.$cookie;
		}
		// 设置请求头
		if(empty($ua) == false or empty($cookie) == false or empty($header) == false){
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		}
		// 设置POST数据
		if($type == 1){
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		}
		// 设置重定向
		if($redirect == false){
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		}
		//允许执行的最长秒数
		curl_setopt($curl,CURLOPT_TIMEOUT,10); 
		//伪造来源
		//curl_setopt($curl, CURLOPT_REFERER, 'https://baidu.com/');
        //伪造IP 		
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $ip, 'CLIENT-IP:' . $ip)); 
		// 过SSL验证证书
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		// 将头部作为数据流输出
		curl_setopt($curl, CURLOPT_HEADER, false);
		// 设置以变量形式存储返回数据
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// 请求并存储数据
		$return = curl_exec($curl);
		// 分割头部和身体
		if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == '200'){
			$return_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
			$return_header = substr($return, 0, $return_header_size);
			$return_data = substr($return, $return_header_size);
		}
		// 关闭cURL
		curl_close($curl);
		// 返回数据
		return $return;
	}
?>	
	