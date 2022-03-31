<?php
//$Id$
require_once "./config.php";
//認證
	sfs_check();

///------ 0.資料目錄設定與檢查---------- ////
$php_dir = dirname($_SERVER[PHP_SELF]);
$ary = explode('/',$php_dir);
$dir_name=end($ary);
$the_mod_path=$UPLOAD_PATH;
$the_mod_paths=$UPLOAD_PATH;
$the_dn_url=$UPLOAD_URL;

//取得己上傳學校陣列
$sch_up=get_upfile_ary($the_mod_path);

$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$template_dir = $SFS_PATH."/".get_store_path()."/templates/";
$template_file1 = $SFS_PATH."/special.htm";;


//秀出網頁布景標頭
head($MODULE_PRO_KIND_NAME,$super_mgr);
print_menu($school_menu_p);


$sch= $_REQUEST[sch_file];
$this_sch=$sch_up[$sch];

if($_POST[action]=='go'){
    $LineArray = file($the_mod_paths.$this_sch['out_name']);
    $titel_ary=array_slice($LineArray,0,3);
    $st_ary=array_slice($LineArray,3);

    foreach($st_ary as $k=>$v){
        $now_stu = explode(',',$v);
        $stu_data[$now_stu[0]]['class'] = $now_stu[1];
        $stu_data[$now_stu[0]]['num'] = $now_stu[2];
        $stu_data[$now_stu[0]]['sex'] = $now_stu[3];
        $stu_data[$now_stu[0]]['name'] = $now_stu[4];
        $stu_data[$now_stu[0]]['id'] = $now_stu[5];
        $stu_data[$now_stu[0]]['os'] = $now_stu[6];
        $stu_data[$now_stu[0]]['type'] = $now_stu[7];
        $stu_data[$now_stu[0]]['about'] = $now_stu[8];
        $stu_data[$now_stu[0]]['ps'] = $now_stu[9];
    }
    $move_stu = $stu_data[$_POST[special_stu_sn]];

    //調動的是同一班就出錯
    if ($_POST[class_id] == $move_stu['class']) backend('所選班級為該生本來的班級，操作錯誤！');

    foreach($titel_ary as $k=>$v){
        $str1 .= $v;
    }

    foreach($stu_data as $k=>$v){
        //更改此生的新班級和座號
        if($_POST[special_stu_sn] == $k){
            $stu_data[$k]['class'] = $_POST[class_id];
            $stu_data[$k]['num'] = $_POST[new_num];
        }else{
            //原先班級的學生上移座號
            if($v['class'] == $move_stu['class'] and $v['num'] > $move_stu['num']){
                $stu_data[$k]['num'] = $v['num']-1;
            }
            //新班級的學生下移座號
            if($v['class'] == $_POST[class_id] and $v['num'] >= $_POST[new_num]){
                $stu_data[$k]['num'] = $v['num']+1;
            }
        }
        $temp_stu_data[$stu_data[$k]['class']][$stu_data[$k]['num']] = $k;
        //$str .= $k.','.$v['class'].','.$v['num'].','.$v['sex'].','.$v['name'].','.$v['id'].','.$v['os'].','.$v['type'].','.$v['about'].','.$v['ps'];
    }

    //先依班級排序，再依座號排序
    ksort($temp_stu_data);
    foreach($temp_stu_data as $k=>$v){
        ksort($temp_stu_data[$k]);
    }

    //產出csv
    foreach($temp_stu_data as $k=>$v){
        foreach($v as $k1=>$v1){
            $str .= $v1.','.$stu_data[$v1]['class'].','.$stu_data[$v1]['num'].','.$stu_data[$v1]['sex'].','.$stu_data[$v1]['name'].','.$stu_data[$v1]['id'].','.$stu_data[$v1]['os'].','.$stu_data[$v1]['type'].','.$stu_data[$v1]['about'].','.$stu_data[$v1]['ps'];
        }
    }

    $str = $str1.$str;

    $fname = $the_mod_path.$this_sch[out_name];
    unlink($fname);
    $file = fopen($fname,"a+"); //開啟檔案
    fwrite($file,$str);
    fclose($file);

    header("Location:school.php?sch_file=".$sch."&act=view");

}

//取得代碼
if ($this_sch[sch_id]!=$sch) backe('--==無該學校資料存在,按下後返回!==--');
if ($this_sch[out]!='OK') backe('--==該學校尚未進行過編班動作,還不能特殊處理,按下後返回!==--');


$smarty->assign("school",$this_sch);
$smarty->assign("PHP_SELF",$_SERVER[PHP_SELF]);
$smarty->assign("ABC",get_abc());//加入ABC班號
$smarty->assign("abc",get_Number($this_sch[sch_num]));//加入ABC班號
$smarty->display($template_file1);


foot();

