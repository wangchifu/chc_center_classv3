<?php

require_once "./config.php";
//認證
sfs_check();

///------ 0.資料目錄設定與檢查---------- ////
$php_dir = dirname($_SERVER['PHP_SELF']);
$ary = explode('/',$php_dir);
$dir_name=end($ary);
$the_mod_path=$UPLOAD_PATH;
$the_mod_paths=$UPLOAD_PATH;
$the_dn_url=$UPLOAD_URL;
//if (chk_office_dir($UPLOAD_PATH.'school/',$dir_name)=='NO') mkdir($the_mod_path, 0777);

$template_file1 = $SFS_PATH."/view_Sp.htm";
//$template_file1 = $SFS_PATH."/".get_store_path()."/view.htm";
//$smarty->left_delimiter="{{";
//$smarty->right_delimiter="}}";

//秀出網頁布景標頭
head("參與編班資料",$mod_set_arys['super_mgr']);
print_menu($school_menu_p);


//取得己上傳學校陣列
$sch_up=get_upfile_ary($the_mod_path);
//print_r(array_keys($sch_up));
//$sch_up2=add_to_td2($sch_up,4);
//$smarty->assign("sch",$sch_up2);
//$smarty->assign("PHP_SELF",$_SERVER['PHP_SELF']);


if ( in_array($_GET['sch'],array_keys($sch_up)) ) {
	//echo "OK";
	//$this_sch=$sch_up[$_GET[sch]];
	$this_sch=$sch_up[$_GET['sch']];
//	if ($this_sch[sch_id]!=$_GET[sch]) backe('--==無該學校資料存在,按下後返回!==--');
//	if ($this_sch[out]!='OK') backe('--==該學校尚末編班,無法顯示,按下後返回!==--');
	$data_file=$the_mod_paths.$this_sch['in'];
	if (!file_exists($data_file))  backend('--==無該學校資料檔存在,按下後返回!==--');
	//讀出全部檔案
	$LineArray = file($data_file);
	$titel_ary=array_slice($LineArray,0,2);
	$st_ary=array_slice($LineArray,3);
	$stu=view_stu($st_ary,$this_sch['sch_num']);//來自檔案
	$sp_stu=get_sp_stu($stu);//特殊生陣列
	if ($sp_stu['sp']!=''){
		$sp_stu1=add_to_td2($sp_stu['sp'],5);//每行列6個學生,特殊生
		$smarty->assign("sp_stu1",$sp_stu1);
	}
	if ($sp_stu['bo']!=''){
		$sp_stu2=add_to_td2($sp_stu['bo'],5);//每行列6個學生,雙胞胎應同班
		$smarty->assign("sp_stu2",$sp_stu2);
	}
	if ($sp_stu['na_bo']!=''){
		$sp_stu3=add_to_td2($sp_stu['na_bo'],5);//每行列6個學生,雙胞胎不同班
		$smarty->assign("sp_stu3",$sp_stu3);
	}

	$stu=add_to_td($stu,5);//每行列6個學生
	$SEX=array("1"=>"<img src='images/boy.gif' height=22 alt='男'>","2"=>"<img src='images/girl.gif' height=22 alt='女'>");
	
	$smarty->assign("SEX",$SEX);
	$smarty->assign("stu",$stu);
	$smarty->assign("sp_stu",$sp_stu);
	$smarty->assign("show_data",'yes');
	$smarty->assign("school",$this_sch);
	$smarty->assign("PHP_SELF",$_SERVER['PHP_SELF']);
	
}

$smarty->display($template_file1);

//echo"<PRE><BR>";
//	print_r($ago_stu[8]);
//print_r($sp_stu);
//print_r($stu);
//echo readfile($data_file);
foot();


