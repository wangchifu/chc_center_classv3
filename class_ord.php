<?php
//$Id$
require_once "./config.php";
//認證
sfs_check();


$php_dir = dirname($_SERVER[PHP_SELF]);
$ary = explode('/',$php_dir);
$dir_name=end($ary);
//取出模組的設定
//$mod_set_arys=&get_module_setup($dir_name);
/// 設定是否班級再打散
//$random_class=$mod_set_arys["random_class"];
///------ 0.資料目錄設定與檢查---------- ////
$the_mod_path=$UPLOAD_PATH;
$the_mod_paths=$UPLOAD_PATH;
$the_dn_url=$UPLOAD_URL;
//if (chk_office_dir($UPLOAD_PATH.'school/',$dir_name)=='NO') mkdir($the_mod_path, 0777);

//取得己上傳學校陣列
$sch_up=get_upfile_ary($the_mod_path);

///------ 1.編排班序並輸出檔案---------- ////
if ($_POST[act]=='start' ){

	//對映新班級順序
	foreach ($_POST[class_id] as $key=>$val){
		$cla_key[$key]=$val;
		$cla_select_value[$val]=$val;
		$cla_tea[$val]=$_POST[Tea][$key];
	}

	//重複班級檢查
	if(count($cla_key) != count($cla_select_value) )  backe('--==送出重複的班級編號,按下後返回!==--');
	//將老師依班級順序排序
	ksort($cla_tea);
	if (strlen($_POST[sch_file])!=6 ) backe('--==無該學校資料代碼存在,按下後返回!==--');
	$sch= $_POST[sch_file];
	$this_sch=$sch_up[$sch];
	//取得代碼
	if ($this_sch[sch_id]!=$sch) backe('--==無該學校資料存在,按下後返回!==--');

	if ($this_sch[out]=='') backe('--==該學校尚未進行編班,禁止排班序,按下後返回!==--');
	$data_file=$the_mod_paths.$this_sch[out_name];
	if (!file_exists($data_file))  backend('該學校尚未進行編班動作,禁止編排班序!');

	//讀出全部檔案
	$LineArray = file($the_mod_paths.$this_sch[out_name]);
	$Ord_obj=new ord_Num();
	$Ord_obj->title=array_slice($LineArray,0,3);
	$Ord_obj->Stu	=array_slice($LineArray,3);
	$Ord_obj->Num	=$cla_key;
	$Ord_obj->Tea	=$cla_tea;
	$Ord_obj->start_change();

	$tmp = explode(".",$_POST[sch_file]);
	$data_file=$the_mod_paths.$this_sch[out_name];
	$fpWrite=fopen($data_file,"w");
	fputs($fpWrite,$Ord_obj->Str);
	fclose($fpWrite);
	$URL="school.php?sch_file=".$sch."&act=view";
	header("Location:$URL");
}

$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$template_file1 = $SFS_PATH."class_ord.htm";


//秀出網頁布景標頭
head($MODULE_PRO_KIND_NAME,$super_mgr);
print_menu($school_menu_p);
//主要內容
if ($_GET[sch_file]!='' && $_GET[act]==''){
	$this_sch=$sch_up[$_GET[sch_file]];	
	//取得代碼
	if ($this_sch[in]=='') backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch[out]=='') backe('--==該學校尚未進行編班動作,禁止編排班序,按下後返回!==--');
	$data_file=$the_mod_paths.$this_sch[out_name];
	if (!file_exists($data_file))  backend('該學校尚未進行編班動作,禁止編排班序!');
	$smarty->assign("school",$this_sch);
	$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
	$smarty->assign("ABC",get_abc());//加入ABC班號
	$smarty->assign("abc",get_Number($this_sch[sch_num]));//加入ABC班號
	$smarty->assign("show_table",'school');
	$smarty->display($template_file1);
}


foot();


