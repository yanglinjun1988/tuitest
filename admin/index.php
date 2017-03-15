<?php 
    header("Content-type:text/html;charset=utf-8"); 
	require dirname(__FILE__).'/conf/config.inc.php';
	if(empty($_GET['type'])){
	echo tiaos('index.php?type=login');	
	}
    #用户退出，清空用户session信息
	if ($_GET['type'] == 'loginout') {
		$_SESSION['wzadminid'] = '';
		$_SESSION['wzadminname'] = '';
		$_SESSION['wzkey'] = '';
		$_SESSION['wzlogintime'] = '';
		echo tiao('安全退出成功！', 'index.php?type=login');
		exit();
	}
	
	#用户登录
	if (($_GET['type'] == 'login')&&$_POST) {
		$names = '/^[a-zA-Z0-9_]{2,10}$/';
		#密码验证规则设置，大小写字母，3-16位。
		$passwords = '/^[a-zA-Z0-9_]{3,16}$/';
		#正则匹配通过，向数据库添加一条数据
		if (preg_match($names, $_POST['username']) && preg_match($passwords, $_POST['password'])) {
			#查询一条数据记录
			$rs=$cm->cmselect('wz_admini', '*', 'where admin_name=\'' . $_POST['username'] . '\' AND admin_pass=\'' . md5('wzt' . $_POST['password']) . '\'');
			#查找到记录，保存session记录
			if ($cm->db_num_rows($rs) == 1) {
				$row = $cm->fetch_array($rs);
				$_SESSION['wzadminid'] = $row['admin_id'];
				$_SESSION['wzadminname'] = $row['admin_name'];
				$_SESSION['wzkey'] = $row['admin_key'];
				$_SESSION['wzlogintime'] = $row['admin_logintime'];
				$cm->query('UPDATE wz_admini SET admin_logintime=\'' . time() . '\' WHERE admin_id=\'' . $row['admin_id'] . '\'');
				//echo "哈哈，你好";
				echo tiaos('dashboard.php');
			}
			else {
				//echo "xiangganma";
				echo tiao('账号或密码错误', 'index.php?type=login');
				exit();
			}
		}
		else {
			//echo "mima zuo";
			echo tiao('账号或密码错误', 'index.php?type=login');
			exit();
		}
	}
	
	#用户注册
	if (($_GET['type'] == 'register')&&$_POST) {
		$names = '/^[a-zA-Z0-9_]{2,10}$/';
		#密码验证规则设置，大小写字母，3-16位。
		$passwords = '/^[a-zA-Z0-9_]{3,16}$/';
		#正则匹配通过，再查询数据库
		if (preg_match($names, $_POST['username']) && preg_match($passwords, $_POST['password'])) {
			#查询一条数据记录
			$rs=$cm->cmselect('wz_admini', '*', 'where admin_name=\'' . $_POST['username'] . '\' AND admin_pass=\'' . md5('wzt' . $_POST['password']) . '\'');
			#查找到记录，保存session记录
			if ($cm->db_num_rows($rs) == 1) {
				$row = $cm->fetch_array($rs);
				$_SESSION['wzadminid'] = $row['admin_id'];
				$_SESSION['wzadminname'] = $row['admin_name'];
				$_SESSION['wzkey'] = $row['admin_key'];
				$_SESSION['wzlogintime'] = $row['admin_logintime'];
				$cm->query('UPDATE wz_admini SET admin_logintime=\'' . time() . '\' WHERE admin_id=\'' . $row['admin_id'] . '\'');
				//echo "哈哈，你好";
				echo tiaos('dashboard.php');
			}
			else {
				//echo "xiangganma";
				echo tiao('账号或密码错误', 'index.php?type=login');
				exit();
			}
		}
		else {
			//echo "mima zuo";
			echo tiao('账号或密码错误', 'index.php?type=login');
			exit();
		}
	}
	
?>
	
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>彖天科技员工推广系统</title>
        <meta content="彖天" name="keywords" />
        <meta content="彖天推广" name="description" />
		    <!--引入头文件-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<!--<script type="text/javascript" src="/js/jquery.min.js" ></script>
		<script type="text/javascript" src="/js/bootstrap.js" ></script>-->
	</head>
	<body style="padding:50px;background-color:#ccc">
		<div id="app" class="container" style="background-color:#fff;padding:50px;">
			<div class="text-center"><h2>彖天科技员工推广系统</h2></div>
			<div class="row">
				<div class="col-md-6">
					<div class="text-center"><h3>会员登陆</h3></div>
				
					    <div class="form-group">
						    <label for="username">用户名</label>
						    <input type="text" class="form-control" placeholder="用户名"  name="username"  v-model = "json.name">
						  </div>
					
					    <div class="form-group">
						    <label for="password">密码</label>
						    <input type="password" class="form-control" placeholder="密码"  name="password" v-model = "json.tel" >
						  </div>
					
					   <button @click = "m_save" class="btn btn-default">登陆</button>
					
				</div>
				<div class="col-md-6">
						<div class="text-center"><h3>会员注册</h3></div>
					<form id="login" action="?type=register" method="post">
				  <div class="form-group">
				    <label for="username">用户名</label>
				    <input type="text" class="form-control" placeholder="用户名"  name="username" value="" >
				  </div>
				  <div class="form-group">
				    <label for="userphone">手机</label>
				    <input type="text" class="form-control" name="userphone" placeholder="用户手机"  value="" >
				  </div>
				  <div class="form-group">
				    <label for="password">密码</label>
				    <input type="password" class="form-control" placeholder="密码"  name="password" value="" >
				  </div>
				  <button type="submit" class="btn btn-default">注册</button>
				</form>
				</div>
				
			</div>
		
		</div>
		<script src="js/vue.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			function _m_get_json(){
				return {
					name : "",
					tel : "",
					
				}
			}
			
			var _vm = new Vue({
				el : "#app",
				data : {
					json : _m_get_json()
				},
				methods : {
					m_save : function(){
						console.log(this.json)
					}
				}
			}) ;
		</script>
	</body>
</html>