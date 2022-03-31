<?php
//$Id$
require_once "./config.php";
//認證
sfs_check();

///------ 0.資料目錄設定與檢查---------- ////
$php_dir = dirname($_SERVER[PHP_SELF]);
$ary = explode('/', $php_dir);
$dir_name = end($ary);
$the_mod_path = $UPLOAD_PATH;
$the_mod_paths = $UPLOAD_PATH;
$the_dn_url = $UPLOAD_URL;
//if (chk_office_dir($UPLOAD_PATH.'school/',$dir_name)=='NO') mkdir($the_mod_path, 0777);

//取得己上傳學校陣列
$sch_up = get_upfile_ary($the_mod_path);

/// 設定是否為練習模式,練習模式多了刪除檔案功能,預設不開啟
$super_mgr = $mod_set_arys['super_mgr'];

///------ 1.亂數編班並輸出檔案---------- ////
if ($_POST[act] == 'start') {
	$sch = $_POST[sch_file];
	$this_sch = $sch_up[$sch];
	//取得代碼
	if ($this_sch[sch_id] != $sch) backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch[out] != 'OK') backe('--==該學校尚未進行過編班動作,無法編排導師!按下後返回!==--');
	if ($this_sch[teacher2] != '') backe('--==導師己經進行過編排作業,禁止重新編排,按下後返回!==--');

	$data_file = $the_mod_paths . $this_sch[out_name];
	if (!file_exists($data_file))  backend('尚未進行編班動作!無法編排導師!');
	//讀出全部檔案
	if ($_POST[work_kind] == '')  backe('--==未選擇處理方式,按下後返回!==--');
	if ($_POST[work_kind] == '1' && $_POST[tea] != '') {
		foreach ($_POST[tea] as $key => $class) {
			$teacher[$class] = $_POST[tea_name][$key];
		}
		ksort($teacher);
	}
	if ($_POST[work_kind] == '1' && $_POST[tea] == '') {
		foreach ($_POST[tea_name] as $key => $tea_name) {
			$teacher[] = $tea_name;
		}
	}

	if ($_POST[work_kind] == '2') {
		foreach ($_POST[tea_name] as $key => $tea) {
			$teacher[$key] = $tea;
		}


		//取得學生已經編班的陣列資料
		$LineArray = file($the_mod_paths . $this_sch['out_name']);
		$st_ary = array_slice($LineArray, 3);
		$ago_stu = view_stu($st_ary, $this_sch['sch_num'], 'yes');

		//標註老師的小孩，如果有同班，就重新亂數
		$times = 0;
		do {
			if ($times > 9999) {
				break;
			}
			$has_teacher_son = 0;

			shuffle($teacher);
			$times++;

			foreach ($teacher as $kk => $vv) {
				$kkk = $kk + 1;
				foreach ($ago_stu[$kkk] as $kkkk => $vvvv) {
					if ($vvvv['memo'] == $vv) {
						$has_teacher_son = 1;
					}
				}
			}
		} while ($has_teacher_son == 1);
		//print_r($teacher);
		//echo "<hr>";
		//print_r($has_teacher_son);
		//die();
		if ($times > 9999) {
			header("Location:indexA.php?error=10000");
			die();
		}
	}
	$arr_str = join(',', $teacher) . "\n";
	$LineArray = file($data_file);
	$titel_ary = array_slice($LineArray, 0, 3);
	$st_ary = array_slice($LineArray, 3);
	$Str = $titel_ary[0];
	$Str .= $arr_str;
	$Str .= $titel_ary[2];
	foreach ($st_ary as $stu) {
		$Str .= $stu;
	}
	$fpWrite = fopen($data_file, "w");
	fputs($fpWrite, $Str);
	fclose($fpWrite);
	$URL = $_SERVER[PHP_SELF] . "?sch_file=" . $_POST[sch_file] . "&act=view";
	header("Location:$URL");
}

$smarty->left_delimiter = "{{";
$smarty->right_delimiter = "}}";
//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$template_file1 = $SFS_PATH . "/teacher.htm";;


//秀出網頁布景標頭
head($MODULE_PRO_KIND_NAME, $super_mgr);
print_menu($school_menu_p);
//主要內容
$smarty->assign("ABC", get_abc()); //加入ABC班號

if ($_GET[sch_file] != '' && $_GET[act] == '') {
	$sch = $_GET[sch_file];
	$this_sch = $sch_up[$sch];
	//取得代碼
	if ($this_sch[sch_id] != $sch) backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch[out] != 'OK') backe('--==該學校尚未進行過編班動作,還不能編排導師,按下後返回!==--');
	if ($this_sch[teacher2] != '') backe('--==導師己經進行過編排作業,禁止重新編排,按下後返回!==--');
	$smarty->assign("school", $this_sch);
	$smarty->assign("PHP_SELF", $_SERVER[PHP_SELF]);
	$class_loop = range(0, ($this_sch[sch_num] - 1));
	$smarty->assign("class_loop", $class_loop);
	//設定隨機顯示的亂數種子
	srand((float)microtime() * 1000000);
	$random = rand(1, 5000);
	$smarty->assign("show_table", 'school');
	$smarty->assign("random", $random);
	$smarty->display($template_file1);
}

if ($_GET[sch_file] != '' && $_GET[act] == 'view') {
	$sch = $_GET[sch_file];
	$this_sch = $sch_up[$sch];
	//取得代碼
	if ($this_sch[sch_id] != $sch) backe('--==無該學校資料存在,按下後返回!==--');
	if ($this_sch[out] != 'OK') backe('--==該學校尚未進行過編班動作,還不能編排導師,按下後返回!==--');
	if ($this_sch[teacher2] == '') backe('--==導師尚未進行過編排作業,無法檢視結果,按下後返回!==--');
	$class_loop = range(0, ($this_sch[sch_num] - 1));
	$smarty->assign("class_loop", $class_loop);

	$smarty->assign("school", $this_sch);
	$smarty->assign("PHP_SELF", $_SERVER[PHP_SELF]);
	//設定隨機顯示的亂數種子
	srand((float)microtime() * 1000000);
	$random = rand(1, 5000);
	$smarty->assign("show_table", 'school2');
	$smarty->assign("random", $random);
	$smarty->display($template_file1);
}


foot();
