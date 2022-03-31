<?php
//$Id$
require_once "./config.php";
//認證
sfs_check();

if ($_POST['change_mod']=='儲存設定') {
    $path=$UPLOAD_PATH.'setup/';
    $fi=$UPLOAD_PATH.'setup/config.txt';
    $change_mod['super_mgr'] = ($_POST['super_mgr']=='Yes')?"Yes":"No";
    $change_mod['random_class'] = ($_POST['random_class']=='Yes')?"Yes":"No";

    file_put_contents($fi,serialize($change_mod));
    header('Location:'.$_SERVER['PHP_SELF']);
}
if ($_POST['save_group']=='儲存分組') {
    $sch_sn = $_POST['sch_sn'];
    $save_school = [];
    $one = [];
    foreach($school_set as $k1=>$v1){
        foreach($v1 as $k2=>$v2){
            $total_school[$k2] = $v2['sch_name'];
        }
    }


    asort($sch_sn);


    foreach($sch_sn as $k=>$v){
        $group = substr($v,0,1);
        $save_school[$group][$k]['sch_sn'] = $v;
        $save_school[$group][$k]['sch_id'] = $k;
        $save_school[$group][$k]['sch_name'] = $total_school[$k];

    }

    $path=$UPLOAD_PATH.'setup/';
    $fi=$UPLOAD_PATH.'setup/school.txt';
    file_put_contents($fi,serialize($save_school));

    header('Location:'.$_SERVER['PHP_SELF']);
}
///------ 4.刪除檔案---------- ////
if ($_GET[act]=='del' && $_GET[file]!=''){
    $this_file=$UPLOAD_PATH."/setup/".$_GET[file];
    unlink($this_file);
    $URL=$_SERVER[PHP_SELF];
    header("Location:$URL");
}


//秀出網頁布景標頭
head("系統設定",$mod_set_arys['super_mgr']);

print_menu($school_menu_p);

$template_file1 = $SFS_PATH."/setup.htm";

if($mod_set_arys['super_mgr'] == "Yes") $check1 = "checked";
if($mod_set_arys['super_mgr'] == "No") $check1 = "";

if($mod_set_arys['random_class'] == "Yes") $check2 = "checked";
if($mod_set_arys['random_class'] == "No") $check2 = "";

$smarty->assign("check1",$check1);
$smarty->assign("check2",$check2);
$smarty->assign("sch_A",$sch_up_A);
$smarty->assign("sch_B",$sch_up_B);
$smarty->assign("PHP_SELF",$_SERVER['PHP_SELF']);
$smarty->display($template_file1);

foot();


