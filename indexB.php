<?php
//$Id$
require_once "./config.php";
//認證
sfs_check();
$addtime=60*60*24*365;
setcookie("close_left_menu");
setcookie("close_left_menu", 1,time()+$addtime,"/");



$php_dir = dirname($_SERVER[PHP_SELF]);
$ary = explode('/',$php_dir);
$dir_name=end($ary);

//取出模組的設定
//$mod_set_arys=&get_module_setup($dir_name);

/// 設定是否為練習模式,練習模式多了刪除檔案功能,預設不開啟
$super_mgr=$mod_set_arys[super_mgr];



///------ 0.資料目錄設定與檢查---------- ////

$the_mod_path=$UPLOAD_PATH;
$the_mod_paths=$UPLOAD_PATH;
$the_dn_url=$UPLOAD_URL;
//if (chk_office_dir($UPLOAD_PATH.'school/',$dir_name)=='NO') mkdir($the_mod_path, 0777);

//取得己上傳學校陣列
$sch_up=get_upfile_ary($the_mod_path);
///------ 1.上傳檔案---------- ////
if ($_POST[act]=='upload' and $_FILES[upfile][error]==0) {
	//$fname = chk_upload_file($_FILES[upfile][name]);
	if (chk_file_name($_FILES[upfile][name])!='OK') backend('檔案類型錯誤,請修正!');
	if (chk_file_format($_FILES[upfile][name])!='OK') backend('檔案名稱不符,請修正!');
	//取出學校代碼
	$tmp_file= explode('_',$_FILES[upfile][name]);
	//檢查是否上傳過了
	foreach ($now_upload_school as $tmp => $tmp_ary){
		if ($tmp==$tmp_file[1]) backend('該校己上傳!禁止重新上傳!');
		}
	$fname = $the_mod_paths.$_FILES[upfile][name];
	move_uploaded_file ( $_FILES[upfile][tmp_name], $fname );
	$URL=$_SERVER[PHP_SELF];
	header("Location:$URL");
}

///------ 3.下載檔案---------- ////
if ($_GET[act]=='down' && $_GET[fn]!=''){
	$this_sch=$sch_up[$_GET[fn]];
	$URL=$the_mod_paths.$this_sch[out_name];
	$str=file_get_contents($URL);
	header("Content-disposition: attachment; filename=$this_sch[out_name]");
	header("Content-type: text/x-csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $str;die();
}


///------ 4.刪除檔案---------- ////
if ($_GET[act]=='del' && $_GET[fn]!='' && $super_mgr=='Yes'){
	$this_file=$the_mod_paths.$_GET[fn];
	unlink($this_file);
	$file_array=explode('.',$this_file);
	$OK_file = $file_array[0]."_OK.".$file_array[1];
	if(file_exists($OK_file)) {unlink($OK_file);};
	$URL=$_SERVER[PHP_SELF];
	header("Location:$URL");
}

///------ 5.刪除全部檔案---------- ////
if ($_GET[act]=='del_all' && $super_mgr=='Yes') {
	del_work_dir($the_mod_path);
	$URL=$_SERVER[PHP_SELF];
	header("Location:$URL");
}
///------ 6.名冊列印------------------ ////
if ($_GET[act]=='prt' and $_GET[fn]!='') {
	$this_sch=$sch_up[$_GET[fn]];
	//讀出全部檔案
	$LineArray = file($the_mod_paths.$this_sch[out_name]);

	//資料陣列
	$st_ary=array_slice($LineArray,3);
	$class_ary=view_stu($st_ary,$this_sch[sch_num],1);
	$smarty->left_delimiter="{{";
	$smarty->right_delimiter="}}";
	$template_file1 = $SFS_PATH."chc_prt.htm";
	$template_file2 = $SFS_PATH."chc_end.htm";
	$i=0;
	$prt_date=date("Y-m-d");

	$smarty->assign("SEX",array(1=>'男',2=>'女'));
	$smarty->assign("sch",$this_sch);
	ksort($class_ary);
	foreach ($class_ary as $k1=> $the_class){
		($i==0) ? $smarty->assign("show_school",'yes'): $smarty->assign("show_school",'no');
		($i!=0) ? $smarty->assign("new_page",'yes'):$smarty->assign("new_page",'no');
//		echo "i=".$i."<BR>";
		$smarty->assign("now_class",$k1);
		$smarty->assign("teacher",$this_sch[teacher2][$i]);
		$smarty->assign("prt_date",$prt_date);
		$smarty->assign("stu",$the_class);
		$smarty->display($template_file1);
		$i++;
		}
	$smarty->display($template_file2);
	die();
}

//編班中心B校 與上傳檔案學校比對,上傳檔案資料匯入編班中心B校陣列
foreach ($sch_up_B as $sch_up_B_key => $sch_up_B_value ) {
        foreach ($sch_up as $sch_up_key => $sch_up_value ) {    
             if ($sch_up_B_key == $sch_up_key) {
                       $sch_up_B[$sch_up_B_key]["sch_num"] =  $sch_up_value[sch_num]; 
                       $sch_up_B[$sch_up_B_key]["stu_tol"] =  $sch_up_value[stu_tol];
                       $sch_up_B[$sch_up_B_key]["teacher"] =  $sch_up_value[teacher];
                       $sch_up_B[$sch_up_B_key]["in"] =  $sch_up_value[in];
                       $sch_up_B[$sch_up_B_key]["out"] =  $sch_up_value[out];
                       $sch_up_B[$sch_up_B_key]["out_name"] =  $sch_up_value[out_name];
                       $sch_up_B[$sch_up_B_key]["teacher2"] =  $sch_up_value[teacher2];      
		     }		     
	   }   
}

$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";

$template_file1 = $SFS_PATH."/indB.htm";;

//秀出網頁布景標頭
head("B組編班",$mod_set_arys['super_mgr']);
print_menu($school_menu_p);
//主要內容
//$sch_id_ary=get_sch_id();
//$smarty->assign("sch",$sch_up);

//編班中心B校
$smarty->assign("sch",$sch_up_B);

$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
//$smarty->assign("sch_id_ary",$sch_id_ary);
$smarty->assign("down_url",$the_dn_url);
$smarty->assign("super_mgr",$super_mgr);


$smarty->display($template_file1);
// echo"<PRE><BR>"; print_r($sch_up);

foot();


