<?php
//$Id$
require_once "./config.php";
//認證
sfs_check();



$php_dir = dirname($_SERVER['PHP_SELF']);
$ary = explode('/', $php_dir);
$dir_name = end($ary);

//取出模組的設定
//$mod_set_arys=&get_module_setup($dir_name);
/// 設定是否班級再打散
$random_class = $mod_set_arys["random_class"];

///------ 0.資料目錄設定與檢查---------- ////
$the_mod_path = $UPLOAD_PATH;
$the_mod_paths = $UPLOAD_PATH;
$the_dn_url = $UPLOAD_URL;

// if (chk_office_dir($UPLOAD_PATH.'school/',$dir_name)=='NO') mkdir($the_mod_path, 0777);

//取得己上傳學校陣列
$sch_up = get_upfile_ary($the_mod_path);

///------ 1.亂數編班並輸出檔案---------- ////
if ($_POST['act'] == 'start') {
	if (strlen($_POST['sch_file']) != 6) backe('--==無該學校資料代碼存在,按下後返回!==--');
	$sch = $_POST['sch_file'];
	$this_sch = $sch_up[$sch];
	//取得代碼
	if ($this_sch['sch_id'] != $sch) backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch['out'] != '') backe('--==該學校己進行過編班動作,禁止重編,按下後返回!==--');
	$data_file = $the_mod_paths . $this_sch['out_name'];
	//$data_file01=$the_mod_paths."01_".$this_sch[out_name];
	//$data_file02=$the_mod_paths."02_".$this_sch[out_name];

	if (file_exists($data_file)) backend('該校己編班過了!禁止重新編班!');
	//if (file_exists($data_file01)) backend('該校己編班過了!禁止重新編班!');
	//if (file_exists($data_file02)) backend('該校己編班過了!禁止重新編班!');
	//讀出全部檔案
	$LineArray = file($the_mod_paths . $this_sch['in']);
	$titel_ary = array_slice($LineArray, 0, 3);
	$st_ary = array_slice($LineArray, 3);
	//第一次亂數
	shuffle($st_ary);

	$class_ary = set_in_order($st_ary, $_POST['sch_num']);
	//$class_ary01=set_in_order($st_ary,$_POST[sch_num]);
	//$class_ary02=set_in_order($st_ary,$_POST[sch_num]);

	$Str = $titel_ary[0];
	$Str .= "\n";
	$Str .= $titel_ary[2];
	//$Str01=$titel_ary[0];
	//$Str01.="\n";
	//$Str01.=$titel_ary[2];
	//$Str02=$titel_ary[0];
	//$Str02.="\n";
	//$Str02.=$titel_ary[2];
	/*
	echo "<pre>";
	print_r($class_ary);
   echo "</pre>";
	echo "<pre>";
	print_r($class_ary01);
   echo "</pre>";
   echo "<pre>";
	print_r($class_ary02);
   echo "</pre>";
	die();
*/
	foreach ($class_ary as $k1 => $the_class) {
		foreach ($the_class as $k2 => $the_stu) {
			$Str .= $the_stu['sn'] . ',' . $k1 . ',' . ($k2 + 1) . ',' .
				$the_stu['sex'] . ',' . $the_stu['stud_name'] . ',' .
				$the_stu['person_id'] . ',' . $the_stu['old_sch'] . ',' .
				$the_stu['stud_kind'] . ',' . $the_stu['bao_id'] . ',' .
				$the_stu['memo'] . "\n";
		}
	}
	/* 	
	foreach ($class_ary01 as $k1=> $the_class){
		foreach ($the_class as $k2=> $the_stu){
		$Str01.=$the_stu[sn].','.$k1.','.($k2+1).','.
		$the_stu[sex].','.$the_stu[stud_name].','.
		$the_stu[person_id].','.$the_stu[old_sch].','.
		$the_stu[stud_kind].','.$the_stu[bao_id].','.
		$the_stu[memo]."\n";
		}
	}	
		foreach ($class_ary02 as $k1=> $the_class){
		foreach ($the_class as $k2=> $the_stu){
		$Str02.=$the_stu[sn].','.$k1.','.($k2+1).','.
		$the_stu[sex].','.$the_stu[stud_name].','.
		$the_stu[person_id].','.$the_stu[old_sch].','.
		$the_stu[stud_kind].','.$the_stu[bao_id].','.
		$the_stu[memo]."\n";
		}
	}
*/
	$tmp = explode(".", $_POST['sch_file']);
	$data_file = $the_mod_paths . $this_sch['out_name'];
	//	$data_file01=$the_mod_paths."01_".$this_sch[out_name];
	//	$data_file02=$the_mod_paths."02_".$this_sch[out_name];

	$fpWrite = fopen($data_file, "w");
	fputs($fpWrite, $Str);
	fclose($fpWrite);
	//$fpWrite01=fopen($data_file01,"w");
	//fputs($fpWrite01,$Str01);
	//fclose($fpWrite01);
	//$fpWrite02=fopen($data_file02,"w");
	//fputs($fpWrite02,$Str02);
	//fclose($fpWrite02);

	$URL = $_SERVER['PHP_SELF'] . "?sch_file=" . $sch . "&act=view";
	header("Location:$URL");
}


//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
//$template_file1 = $SFS_PATH."/".get_store_path()."/school.htm";
$template_file1 = $SFS_PATH . "school_Sp.htm";


//秀出網頁布景標頭
head("進行編班...", $mod_set_arys['super_mgr']);
print_menu($school_menu_p);
//主要內容

if ($_GET['sch_file'] != '' && $_GET['act'] == '') {
	$this_sch = $sch_up[$_GET['sch_file']];
	//取得代碼
	if ($this_sch['in'] == '') backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch['out'] != '') backe('--==該學校己進行過編班動作,禁止重編,按下後返回!==--');
	$data_file = $the_mod_paths . $this_sch['out_name'];
	//$data_file01=$the_mod_paths."01_".$this_sch[out_name];
	//$data_file02=$the_mod_paths."02_".$this_sch[out_name];
	//echo $data_file."<br>".$this_sch[in]."<br>".$this_sch[out]."<br>"; 
	//echo $this_sch[out]."<br>";
	if (file_exists($data_file))  backend('該校己編班過了!禁止重新編班!');
	//if (file_exists($data_file01))  backend('該校己編班過了!禁止重新編班!');
	//if (file_exists($data_file02))  backend('該校己編班過了!禁止重新編班!');

	$smarty->assign("school", $this_sch);
	$smarty->assign("PHP_SELF", $_SERVER['PHP_SELF']);
	$smarty->assign("ABC", get_abc()); //加入ABC班號

	//設定隨機顯示的亂數種子
	srand((float)microtime() * 1000000);
	$random01 = rand(1, 5000);
	$random02 = rand(1, 5000);
	$smarty->assign("show_table", 'school');
	$smarty->assign("random01", $random01);
	$smarty->assign("random02", $random02);
	$smarty->display($template_file1);
}

if ($_GET['sch_file'] != '' && $_GET['act'] == 'view') {
	$this_sch = $sch_up[$_GET['sch_file']];
	//取得代碼
	if ($this_sch['sch_id'] != $_GET['sch_file']) backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch['out'] != 'OK') backe('--==該學校尚末編班,無法顯示,按下後返回!==--');
	$data_file = $the_mod_paths . $this_sch['out_name'];
	//$data_file01=$the_mod_paths."01_".$this_sch[out_name];
	//$data_file02=$the_mod_paths."02_".$this_sch[out_name];
	if (!file_exists($data_file))  backend('--==無該學校資料檔存在,按下後返回!==--');
	//if (!file_exists($data_file01))  backend('--==無該學校資料檔存在,按下後返回!==--');
	//if (!file_exists($data_file02))  backend('--==無該學校資料檔存在,按下後返回!==--');
	//讀出全部檔案
	$LineArray = file($the_mod_paths . $this_sch['out_name']);
	$titel_ary = array_slice($LineArray, 0, 2);
	$st_ary = array_slice($LineArray, 3);
	$ago_stu = view_stu($st_ary, $this_sch['sch_num'], 'yes'); //來自檔案
	$ago_stu = class_to_view($ago_stu, $this_sch['sch_num'], $this_sch['teacher2']); //來自陣列
	$SEX = array("1" => "<img src='images/boy.gif' height=22>", "2" => "<img src='images/girl.gif' height=22>");
	$smarty->assign("show_table", 'stu');
	$smarty->assign("school", $this_sch);
	$smarty->assign("SEX", $SEX);
	$smarty->assign("the_class", $ago_stu);
	//如果人數超過28人，則發出警告
	foreach ($ago_stu as $k => $v) {
		if ($v['num'] > 28) {
			echo "<body onload=alert('A" . $k . "班人數超過法定上限28人');>";
		}
	}


	//	$smarty->assign("the_class",$sch_up[teacher2]);
	$smarty->display($template_file1);
}

//echo"<PRE><BR>";
//	print_r($ago_stu);
//print_r($sch_up);


foot();
