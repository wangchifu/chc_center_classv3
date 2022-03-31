<?php
require_once "./config.php";

///------ 0.資料目錄設定與檢查---------- ////
$php_dir = dirname($_SERVER['PHP_SELF']);
$ary = explode('/',$php_dir);
$dir_name=end($ary);
$the_mod_path=$UPLOAD_PATH;
$the_mod_paths=$UPLOAD_PATH;
$the_dn_url=$UPLOAD_URL;
//if (chk_office_dir($UPLOAD_PATH.'school/',$dir_name)=='NO') mkdir($the_mod_path, 0777);

//$template_file1 = $SFS_PATH."/".get_store_path()."/show_All.htm";
$template_file1 = $SFS_PATH."/show_Sp.htm";


//取得己上傳學校陣列
$sch_up=get_upfile_ary($the_mod_path);
$sch_up2=add_to_td2($sch_up,4);
$smarty->assign("sch",$sch_up2);
$smarty->assign("PHP_SELF",$_SERVER['PHP_SELF']);

if ($_GET['act']=='view' && in_array($_GET['sch'],array_keys($sch_up),true) ){
	 
	$this_sch=$sch_up[$_GET['sch']];
	if ($this_sch['sch_id']!=$_GET['sch']) backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch['out']!='OK') backe('--==該學校尚末編班,無法顯示,按下後返回!==--');
	$data_file=$the_mod_paths.$this_sch['out_name'];
	if (!file_exists($data_file))  backend('--==無該學校資料檔存在,按下後返回!==--');
	//讀出全部檔案
	$LineArray = file($the_mod_paths.$this_sch['out_name']);
	$titel_ary=array_slice($LineArray,0,2);
	$st_ary=array_slice($LineArray,3);
	$ago_stu=view_stu($st_ary,$this_sch['sch_num'],'yes');//來自檔案
	$ago_stu=class_to_view($ago_stu,$this_sch['sch_num'],$this_sch['teacher2']);//來自陣列
	$SEX=array("1"=>"<img src='images/boy.gif' height=22>","2"=>"<img src='images/girl.gif' height=22>");
	$smarty->assign("show_table",'stu');
	$smarty->assign("school",$this_sch);
	$smarty->assign("SEX",$SEX);
	$smarty->assign("the_class",$ago_stu);
}

head($MODULE_PRO_KIND_NAME);

print_menu($school_menu_p);


$smarty->display($template_file1);
// echo"<PRE><BR>";
//	print_r($ago_stu[8]);
//print_r($sch_up2);


