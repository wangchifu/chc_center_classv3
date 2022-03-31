<?php
//$Id$
require_once "./config.php";
//認證
sfs_check();

//$file="107_074736_20170520.csv";
//echo chk_file_format($file);

$php_dir = dirname($_SERVER['PHP_SELF']);
$ary = explode('/', $php_dir);
$dir_name = end($ary);

//取出模組的設定
//$mod_set_arys=&get_module_setup($dir_name);

/// 設定是否為練習模式,練習模式多了刪除檔案功能,預設不開啟
$super_mgr = $mod_set_arys['super_mgr'];



///------ 0.資料目錄設定與檢查---------- ////

$the_mod_path = $UPLOAD_PATH;
$the_mod_paths = $UPLOAD_PATH;
$the_dn_url = $UPLOAD_URL;
//if (chk_office_dir($UPLOAD_PATH.'school/',$dir_name)=='NO') mkdir($the_mod_path, 0777);

//取得已上傳學校陣列
$sch_up = get_upfile_ary($the_mod_path);
//print_r($sch_up);
///------ 0.導師編不出來---------- ////
if ($_GET['error'] == 10000) {
    echo "<body onload=alert('已編10000次了，也編不出導師！');>";
}

///------ 1.上傳檔案---------- ////
if ($_POST['act'] == 'upload' and $_FILES['upfile']['error'] == 0) {
    //$fname = chk_upload_file($_FILES['upfile']['name']);
    if (chk_file_name($_FILES['upfile']['name']) != 'OK') backend('檔案類型錯誤,請修正!');
    if (chk_file_format($_FILES['upfile']['name']) != 'OK') backend('檔案名稱不符,請修正!');
    //取出學校代碼
    $tmp_file = explode('_', $_FILES['upfile']['name']);
    //檢查是否上傳過了
    foreach ($now_upload_school as $tmp => $tmp_ary) {
        if ($tmp == $tmp_file[1]) backend('該校己上傳!禁止重新上傳!');
    }
    $fname = $the_mod_path . $_FILES['upfile']['name'];
    move_uploaded_file($_FILES['upfile']['tmp_name'], $fname);

    //轉xlsx到csv
    include 'include/Classes/PHPExcel.php';
    try {
        $objPHPExcel = PHPExcel_IOFactory::load($fname);
    } catch (Exception $e) {
        die('Error loading file "' . pathinfo($fname, PATHINFO_BASENAME) . '": ' . $e->getMessage());
    }

    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    $str = "";
    foreach ($sheetData as $k1 => $v1) {
        $i = 0;
        //if(!empty($v1['A'])){
        foreach ($v1 as $k2 => $v2) {
            //一列最多30欄
            if ($i == 30) break;
            $str .= $v2 . ",";
            $i++;
        }
        $str .= "\r\n";
        //}        
    }

    $csv = str_replace('xlsx', 'csv', $fname);

    $file = fopen($csv, "a+"); //開啟檔案
    fwrite($file, $str);
    fclose($file);
    unlink($fname);

    $URL = $_SERVER['PHP_SELF'];
    header("Location:$URL");
}

///------ 3.下載檔案---------- ////
if ($_GET['act'] == 'down' && $_GET['fn'] != '') {
    $this_sch = $sch_up[$_GET['fn']];
    $URL = $the_mod_paths . $this_sch['out_name'];


    include 'include/Classes/PHPExcel.php';
    // 首先建立一個新的物件  PHPExcel object
    $objPHPExcel = new PHPExcel();
    // 設定檔案的一些屬性，在xls檔案——>屬性——>詳細資訊裡可以看到這些值，xml表格裡是沒有這些值的
    /**
    $objPHPExcel
        ->getProperties()  //獲得檔案屬性物件，給下文提供設定資源
        ->setCreator( "Maarten Balliauw")                 //設定檔案的建立者
        ->setLastModifiedBy( "Maarten Balliauw")          //設定最後修改者
        ->setTitle( "Office 2007 XLSX Test Document" )    //設定標題
        ->setSubject( "Office 2007 XLSX Test Document" )  //設定主題
        ->setDescription( "Test document for Office 2007 XLSX, generated using PHP classes.") //設定備註
        ->setKeywords( "office 2007 openxml php")        //設定標記
        ->setCategory( "Test result file");                //設定類別
     * */
    // 位置aaa  *為下文程式碼位置提供錨
    // 給表格新增資料
    //$objPHPExcel->setActiveSheetIndex(0);             //設定第一個內建表（一個xls檔案裡可以有多個表）為活動的


    $eng = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
    $file = fopen($URL, 'r');
    $i = 1;
    while ($data = fgetcsv($file)) { //每次讀取CSV裡面的一行內容
        $j = 0;
        foreach ($data as $d) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($eng[$j] . $i, $d); //給表的單元格設定資料
            $j++;
        }
        $i++;
    }


    fclose($file);


    //得到當前活動的表,注意下文教程中會經常用到$objActSheet
    $objActSheet = $objPHPExcel->getActiveSheet();
    // 位置bbb  *為下文程式碼位置提供錨
    // 給當前活動的表設定名稱
    //$objActSheet->setTitle('Simple2222');

    // 生成2007excel格式的xlsx檔案
    $f = $this_sch['out_name'];
    $f = str_replace(".csv", "", $f);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $f . '.xlsx');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
    /**
    $str=file_get_contents($URL);
    header("Content-disposition: attachment; filename=$this_sch[out_name]");
	header("Content-type: text/x-csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $str;die();
     * */
}

///------ 4.刪除檔案---------- ////
if ($_GET['act'] == 'del' && $_GET['fn'] != '' && $super_mgr == 'Yes') {
    $this_file = $the_mod_paths . $_GET['fn'];
    unlink($this_file);
    $file_array = explode('.', $this_file);
    $OK_file = $file_array[0] . "_OK." . $file_array[1];
    if (file_exists($OK_file)) {
        unlink($OK_file);
    };
    $URL = $_SERVER['PHP_SELF'];
    header("Location:$URL");
}
///------ 4-1.刪除已編導師---------- ////
if ($_GET['act'] == 'del_teacher' && $_GET['fn'] != '' && $super_mgr == 'Yes') {
    $this_file = $the_mod_paths . $_GET['fn'];

    $empty_teacher = "\n";
    $csv_str = "";
    $n = 1;
    $fpWrite = fopen($this_file, "r");
    while (!feof($fpWrite)) {
        $value = fgets($fpWrite);
        if ($n == 2) {
            $csv_str .= $empty_teacher;
        } else {
            $csv_str .= $value;
        }
        $n++;
    }

    fclose($fpWrite);
    $fpWrite = fopen($this_file, "w");
    fputs($fpWrite, $csv_str);
    fclose($fpWrite);

    $URL = $_SERVER['PHP_SELF'];
    header("Location:$URL");
}
/*
///------ 4.刪除檔案---------- ////
if ($_GET['act']=='del' && $_GET['fn']!='' && $super_mgr=='Yes'){
	$this_file=$the_mod_paths.$_GET['fn'];
	unlink($this_file);
	$URL=$_SERVER['PHP_SELF'];
	header("Location:$URL");
}
*/
///------ 5.刪除全部檔案---------- ////
if ($_GET['act'] == 'del_all' && $super_mgr == 'Yes') {
    del_work_dir($the_mod_path);
    $URL = $_SERVER['PHP_SELF'];
    header("Location:$URL");
}
///------ 6.名冊列印------------------ ////
if ($_GET['act'] == 'prt' and $_GET['fn'] != '') {
    $this_sch = $sch_up[$_GET['fn']];
    //讀出全部檔案
    $LineArray = file($the_mod_paths . $this_sch['out_name']);

    //資料陣列
    $st_ary = array_slice($LineArray, 3);
    $class_ary = view_stu($st_ary, $this_sch['sch_num'], 1);

    $template_file1 = $SFS_PATH . "chc_prt.htm";
    $template_file2 = $SFS_PATH . "chc_end.htm";
    $i = 0;
    $prt_date = date("Y-m-d");

    $smarty->assign("SEX", array(1 => '男', 2 => '女'));
    $smarty->assign("sch", $this_sch);
    ksort($class_ary);
    foreach ($class_ary as $k1 => $the_class) {
        ($i == 0) ? $smarty->assign("show_school", 'yes') : $smarty->assign("show_school", 'no');
        ($i != 0) ? $smarty->assign("new_page", 'yes') : $smarty->assign("new_page", 'no');
        //		echo "i=".$i."<BR>";
        $smarty->assign("now_class", $k1);
        $smarty->assign("teacher", $this_sch['teacher2'][$i]);
        $smarty->assign("prt_date", $prt_date);
        $smarty->assign("stu", $the_class);
        $smarty->display($template_file1);
        $i++;
    }
    $smarty->display($template_file2);
    die();
}

//編班中心A校 與上傳檔案學校比對,上傳檔案資料匯入編班中心A校陣列
foreach ($sch_up_A as $sch_up_A_key => $sch_up_A_value) {
    foreach ($sch_up as $sch_up_key => $sch_up_value) {
        if ($sch_up_A_key == $sch_up_key) {
            $sch_up_A[$sch_up_A_key]['sch_num'] =  $sch_up_value['sch_num'];
            $sch_up_A[$sch_up_A_key]['stu_tol'] =  $sch_up_value['stu_tol'];
            $sch_up_A[$sch_up_A_key]['teacher'] =  $sch_up_value['teacher'];
            $sch_up_A[$sch_up_A_key]['in'] =  $sch_up_value['in'];
            $sch_up_A[$sch_up_A_key]['out'] =  $sch_up_value['out'];
            $sch_up_A[$sch_up_A_key]['out_name'] =  $sch_up_value['out_name'];
            $sch_up_A[$sch_up_A_key]['teacher2'] =  $sch_up_value['teacher2'];
        }
    }
}


//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";

$template_file1 = $SFS_PATH . "/ind.htm";;

//秀出網頁布景標頭
head("學校編班作業", $mod_set_arys['super_mgr']);
print_menu($school_menu_p);
//主要內容
//$sch_id_ary=get_sch_id();
//$smarty->assign("sch",$sch_up);

//編班中心A校
$smarty->assign("sch", $sch_up_A);

$smarty->assign("PHP_SELF", $_SERVER['PHP_SELF']);
//$smarty->assign("sch_id_ary",$sch_id_ary);
$smarty->assign("down_url", $the_dn_url);
$smarty->assign("super_mgr", $super_mgr);


$smarty->display($template_file1);
// echo"<PRE><BR>"; print_r($sch_up);

foot();
