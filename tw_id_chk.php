<?php
//$Id$
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

//取得己上傳學校陣列
$sch_up=get_upfile_ary($the_mod_path);


//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$template_file1 = $SFS_PATH."tw_id_chk.htm";


//秀出網頁布景標頭
head("查驗證號",$mod_set_arys['super_mgr']);
print_menu($school_menu_p);
//主要內容
//	echo"<PRE><BR>";

if ( $_GET['act']=='yes'){
	foreach($sch_up as $skey => $sch_info){
		$LineArray = file($the_mod_paths.$sch_info['in']);
		$st_ary=array_slice($LineArray,3);
		foreach ($st_ary as $no=>$line ){
			//if( !ereg(',',$line)) continue;//去除空白行
			if(!preg_match("/,/",$line)) continue;//去除空白行
			$stu_tmp = explode(",",$line);
			$tw_id=strtoupper($stu_tmp[5]);
			$now_stud['sn']=trim($stu_tmp[0]);
			//$now_stud[k1]=$stu_tmp[1];
			//		$now_stud[k2]=$stu_tmp[2];
			$now_stud['sex']=trim($stu_tmp[3]);
			$now_stud['stud_name']=$stu_tmp[4];
			$now_stud['person_id']=strtoupper(trim($stu_tmp[5]));
			// $now_stud[old_sch]=$stu_tmp[6];
			//$now_stud[stud_kind]=$stu_tmp[7];
			//$now_stud[bao_id]=$stu_tmp[8];
			//$now_stud[memo]=trim($stu_tmp[9]);
			$now_stud['in_school']=$sch_info['sch_name'];
			$stu[$tw_id][]=$now_stud;
			}
		}
		$stud_err = array();
		foreach ($stu as $tw_id=>$line ){
			if (empty($tw_id) or strlen($tw_id)<10) { 
					$stud_err2[]=$line;
//				echo "身分証字號錯誤！<BR>";
			} else{
				if (count($stu[$tw_id])>1 ) {
					$stud_err[$tw_id]=$line;
//					print_r($stud_err);
					}
			}
		}
	$smarty->assign("err",$stud_err);
	$smarty->assign("err2",$stud_err2);
	$smarty->display($template_file1);
//	echo"<PRE><BR>";
//	print_r($stud_err);
//	print_r($stud_err2);
//	print_r($stu);
}


foot();

