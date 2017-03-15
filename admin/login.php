<?php 
    header("Content-type:text/html;charset=utf-8");  
	require dirname(__FILE__).'/conf/config.inc.php';
    $names = '/^[a-zA-Z0-9_]{2,10}$/';
	#密码验证规则设置，大小写字母，3-16位。
	$passwords = '/^[a-zA-Z0-9_]{3,16}$/';
	
	if(!empty($_POST['do']) && ($_POST['do'] == "login")){
		if(!empty($_POST['username'])){
			if (preg_match($names, $_POST['username']) && preg_match($passwords, $_POST['pass'])) {
				#查询一条数据记录
				$rs=$cm->cmselect('wz_tuiuser', '*', 'where username=\'' . $_POST['username'] . '\' AND userpass=\'' . $_POST['pass'] . '\'');
				#查找到记录，保存session记录
				if ($cm->db_num_rows($rs) == 1) {
					$row = $cm->fetch_array($rs);	
					$_SESSION['userid']=$row['id'];
					$_SESSION['username']=$row['username'];
					$_SESSION['usertel']=$row['usertel'];
					$arr1 = array(
				    'state' => 200,
				    'data' => "success"
				     );
				     echo json_encode($arr1);
				}else{
					$arr3 = array(
				    'state' => 501,
				     'data' => "faile",
				     'name' => $_POST['username'],
				     'pass' => $_POST['pass']
				     );
				     echo json_encode($arr3);
				}
				
			}
			else{
				$arr2 = array(
			    'state' => 500,
			     'data' => "faile",
			     'name' => $_POST['username'],
				  'pass' => $_POST['pass']
			     );
			     echo json_encode($arr2);
			}
		}else{
					$arr4 = array(
				    'state' => 504,
				     'data' => "faile",
				     'name' => $_POST['username'],
				     'pass' => $_POST['pass']
				     );
				     echo json_encode($arr4);
				}
			
				
	}
	if(!empty($_POST['do']) && ($_POST['do'] == "register")){
		$date=array(
			'username'=>$_POST['name'],
			'usertel'=>$_POST['tel'],
			'userpass'=>$_POST['pass'],
			'regtime' => date('y-m-d h:i:s',time()),
			'tuiid' =>$_POST['tuiid'],
			'userip' =>$_SERVER["REMOTE_ADDR"],
			);
			if($cm->cmadd($date,'wz_tuiuser')){
				$arr5 = array(
				    'state' => 200,
				    'data' => "success + 成功"
				     );
				echo json_encode($arr5);
			}
	}
	
	if(!empty($_POST['do']) && ($_POST['do'] == "settion")){
		if(empty($_SESSION['userid']) or empty($_SESSION['usertel'])){
			$arr = array(
				    'state' => 202,
				    'data' => "还没有登陆"
				     );
				echo json_encode($arr);
		}
		else{
			$arr = array(
				    'state' => 200,
				    'data' => array(
				    	'message' => "登陆成功",
				    	'userid' => $_SESSION['userid'],
				    	'usertel' => $_SESSION['usertel'],
				    	'username' => $_SESSION['username']
				    )
				     );
				echo json_encode($arr);
		}
	}

    
	
	
?>