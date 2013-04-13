<?php
/*Twwy's art*/

preg_match('/\/oobject\/(.+)$/', $_SERVER['REQUEST_URI'], $match);
$uri = (empty($match)) ? 'default' : $match[1];

/*数据库*/
if(php_uname() == 'SAE LINUX ENVIRONMENT') require('./database-sae.php');
else require('./database.php');
$db = new database;
/*require('./database.php');
$db = new database;*/

/*路由*/
$router = Array();
function router($path, $func){
	global $router;
	$router[$path] = $func;
}

/*视图*/
function view($page, $data = Array(), $onlyBody = false){
	foreach ($data as $key => $value) $$key = $value;
	if($onlyBody) return require("./view/{$page}");
	require("./view/header.html");
	require("./view/{$page}");
	require("./view/footer.html");
}

/*会话*/
session_start();

/*JSON格式*/
function json($result, $value){
	if($result) exit(json_encode(array('result' => true, 'data' => $value)));
	exit(json_encode(array('result' => false, 'msg' => $value)));
}

/*POST过滤器*/	//符合rule返回字符串，否则触发callback，optional为真则返回null
function filter($name, $rule, $callback, $optional = false){
	//if(isset($_POST[$name]) && preg_match($rule, $post = iconv('UTF-8', 'GB2312//IGNORE', trim($_POST[$name])))) return iconv('GB2312', 'UTF-8//IGNORE', $post);
	if(isset($_POST[$name]) && preg_match($rule, $post = trim($_POST[$name]))) return $post;
	elseif(!$optional){
		if(is_object($callback)) return $callback();
		else json(false, $callback);
	}
	return null;
}

/*模型*/
class model{
	function db(){
		global $db;
		return $db;
	}
}//model中转db类
function model($value){
	require("./model/{$value}.php");
	return new $value;
}

/*扩展函数*/
require('common.php');

/*================路由表<开始>========================*/


//require('user.php');
//require('domain.php');
//require('task.php');

router('default',function(){
	view('main.html', array());
});

router('cmd',function(){
	view('cmd.html', array());
});

router('test',function(){
	$oobejct = model('oobject');
	$oobejct->creat('test2');
	//view('main.html', array());
});


/*================路由表<结束>========================*/


/*路由遍历*/
foreach ($router as $key => $value){
	if(preg_match('/^'.$key.'$/', $uri, $matches)) exit($value($matches));
}

/*not found*/
echo 'Page not fonud';

?>