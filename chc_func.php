<?php
//$Id$
//預設的引入檔，不可移除。
function get_abc() {
	$A=range("A","Z");
	for($i=0;$i<26;$i++) {
		if($i==0) continue;
		$y=$i-1;
		$B[$i]=$A[$y];
	}
	return $B;
}
class ord_Num {
		var $title;//標題行(3行)
		var $Stu;//學生資料行
		var $Num;//班級對映陣列
		var $Tea;
		var $Str='';
	function start_change(){
		$this->Str= $this->title[0].join(",",$this->Tea)."\n".$this->title[2];
		$this->change_class();
//		$this->Str=return $Str_1.$this->Str;
	}
	function change_class(){
//		print_r($this->Stu);
//		print_r($this->Num);
		foreach ($this->Stu as  $line){
			//if( !ereg(',',$line)) continue;//去除空白行
			if(!preg_match('/,/',$line)) continue;//去除空白行
			//$nn=array("流水號","班級","座號","性別","姓名","身分証字號","就讀國小","編班類別","相關流水號","備註");
			//$nn=array("sn","k1","k2","sex","stud_name","person_id","old_sch","stud_kind","bao_id","memo");
			$stu_tmp = explode(",",$line);
			$now_stud['sn']=trim($stu_tmp[0]);
			$now_stud['k1']=$this->Num[$stu_tmp[1]];//變更班序
//			echo "A";
			$now_stud['k2']=$stu_tmp[2];
			$now_stud['sex']=trim($stu_tmp[3]);
			$now_stud['stud_name']=trim($stu_tmp[4]);
			$now_stud['person_id']=trim($stu_tmp[5]);
			$now_stud['old_sch']=trim($stu_tmp[6]);
			$now_stud['stud_kind']=trim($stu_tmp[7]);
			$now_stud['bao_id']=trim($stu_tmp[8]);
			$now_stud['memo']=trim($stu_tmp[9]);
			$this->Str.=join(",",$now_stud)."\n";
		}
//echo $this->Str;
	}
}

####-----------將陣列依key排序-----########
function xx_sort($arys) {
	foreach($arys as $item) {
		$arys2[$item['k1']][$item['k2']] = $item;
	}
	$arys = $arys2;
	$arys2=array();
	
	$max_cla=count($arys);
	for($cla_no=1; $cla_no<=$max_cla; $cla_no++) {
		$max_seat = count($arys[$cla_no]);
		
		for($seat=1; $seat<=$max_seat; $seat++) {
			$arys2[$cla_no][$seat]=$arys[$cla_no][$seat];
		}
		
	}
	
	return $arys2;
}

//#######========== 寫檔函式  ===================#######################
function chk_download_file($fname) {
	global $UPLOAD_PATH,$UPLOAD_URL;
	//--- 取得目前 php 所在的目錄
	$php_dir = dirname($_SERVER['PHP_SELF']);
	$ary = explode('/',$php_dir);
	$fname0 = $UPLOAD_PATH.$fname;
	// $fname0 = $UPLOAD_PATH.'school/'.end($ary).'/'.$fname;
	//print "<br> fname0={$fname}";
	if (file_exists($fname0)) $fname = $UPLOAD_PATH.$fname;
	else $fname=false;
	//print "<br> fname1={$fname}";
	
	return $fname;
}

function chk_upload_file($fname) {
	global $UPLOAD_PATH;
	//--- 取得目前 php 所在的目錄
	$php_dir = dirname($_SERVER['PHP_SELF']);
	$ary = explode('/',$php_dir);
	//$fname = $UPLOAD_PATH.'school/'.end($ary).'/'.$fname;
	$fname = $UPLOAD_PATH.$fname;
	return $fname;
	//-- 將 $fname 中的 '//' 修正成 '/' 以避免錯誤
	while (strpos($fname,'//')!==false) 
		$fname = str_replace('//','/',$fname);
	//--- 取得實際上要存檔的目錄陣列
//	print "<br> test1 fname={$fname}";
	$ary = explode('/',dirname(substr($fname,strlen($UPLOAD_PATH))));
//	print_r($ary);
	//$fname = substr($fname,strrpos($fname,'/'));
	$fname=basename($fname);
	$upload_dir = substr($UPLOAD_PATH,0,-1); //--- 最後的 / 不要
//	print "<br> test2 fname={$fname} uplod_dir={$upload_dir}";
	foreach ($ary as $next_dir) {
		if (!empty($next_dir)) {
			$upload_dir .= '/'.$next_dir;
//			print "<br> test3 uplod_dir={$upload_dir}";
			//--- 檢查是否為一個目錄
			if (filetype($upload_dir)!=='dir') {
				//--- 檢查檔案是否存在，若存在檔案時先將其刪除
				if (file_exists($upload_dir)) unlink($upload_dir);
				//-- 建立目錄 失敗立刻中斷
//				print "<br> test4 uplod_dir={$upload_dir}";
				//mkdir($upload_dir);
				if (mkdir($upload_dir)===false) break;
			}
		}
	}
	if (filetype($upload_dir)==='dir') $fname = $upload_dir.'/'.$fname;
	else $fname = false;
//	print "<br> upload_dir={$upload_dir} fname={$fname}";
	return $fname;
}
################ 檢查處室目錄是否建立函式  #####################################
function chk_office_dir($path,$dir_name) {
	$a=dir($path);
	$a->rewind();
	$flag='NO';
	while($dir=$a->read()) {
		if (!is_dir($path."/".$dir_name)) continue;
		($dir==$dir_name) ? $flag='OK':$flag=$flag;
	}
	$a->close();
	return $flag;
}
function backend($st="未填妥!按下後回上頁重填!") {
echo "<BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:16pt;color:red'>
	</form></CENTER>";
	exit;
	}
####################  檢查檔名  ####################
function chk_file_name($file) {
	//$upload_type=array(".csv$");//可上傳類型
	$chk='NO';
	//foreach($upload_type as $val) {
	// (eregi($val,$file)) ?  $chk='OK':$chk=$chk ;
	(preg_match("/.xlsx/",$file)) ? $chk='OK':$chk=$chk ;
		Return $chk;
}

####################  檢查檔名  ####################


function chk_file_format($file) {
	$chk='NO';
	//if(ereg("^[0-9]{3}_[0-9]{6}_[0-9]{8}\.csv",$file))   $chk='OK';
	//if(ereg("^[0-9]{3}_[0-9]{6}_[0-9]{8}\.csv",$file))   $chk='OK';
	//if (preg_match("/^[0-9]{3}_[0-9]{6}_[0-9]{8}.csv/",$file))  $chk='OK';
	$regex="/^[0-9]{3}_[0-9]{6}_[0-9]{8}.xlsx/";
	if (preg_match($regex,$file))  $chk='OK';
	Return $chk;
}

################ 取得合格的檔案名稱陣列函式  #####################################
function get_upfile_ary($path) {
	$a=dir($path);
	$a->rewind();
	$i=0;
	$big_pix=array();
	while($file=$a->read()) {
		if( filetype($path."/".$file)!='file')  continue;
		//if( !eregi("\.csv$",$file))   continue;
		if(!preg_match("/.csv/",$file))   continue;
		
//		if( !eregi("^[0-9]{2}.+\.csv$",$file))   continue;
//		if( !eregi("^[0-9]{2}_[0-9]{6}_[0-9]{8}_OK\.csv",$file))   continue;
//		if (eregi('OK.csv$',$file))  continue;+"\.csv$"
		$big_pix[$i]=$file;
		$i++;
	}
	$a->close();
	//print_r($big_pix);
	foreach($big_pix as $aa) {
//		if( !eregi('_',$aa)) continue;
		//if( eregi('OK',$aa)) continue;//去除己輸出的
		if(preg_match("/OK/",$aa)) continue;//去除己輸出的
		$ary = explode('_',$aa);
		$file_ary[$ary[1]]['sch_id']=$ary[1];
		$sch= get_sch_part($path."/".$aa);//print_r($sch);
		$file_ary[$ary[1]]['sch_name']=$sch[1];
		$file_ary[$ary[1]]['sch_num']=$sch[3];
		$file_ary[$ary[1]]['stu_tol']=$sch[4];
		$file_ary[$ary[1]]['teacher']=$sch['teacher'];
		$file_ary[$ary[1]]['in']=$aa;//print_r($file_ary);
	}
	foreach($file_ary as $key=>$up_ary) {
		$file_ary1[$key]=$up_ary;
		$tmp = explode(".",$up_ary['in']);
		$name=$tmp[0]."_OK.".$tmp[1];
		foreach($big_pix as $aa) {
//			echo $aa."<BR>";
			if( $aa==$name) $file_ary1[$key]['out']='OK';
		}
		if($file_ary1[$key]['out']=='') $file_ary1[$key]['out']='';
		$file_ary1[$key]['out_name']=$name;
		///加入己編排導師資料
		if($file_ary1[$key]['out']=='OK') {
			$sch= get_sch_part($path."/".$name);
			$file_ary1[$key]['teacher2']=$sch['teacher'];
			} else {
			$file_ary1[$key]['teacher2']='';
			}
	}
	return $file_ary1;
}


################ 全省學校陣列  #####################################


function get_sch_id(){

	global $CONN ;

	$sch=get_school_base(); 
	$state=array("01"=>"台北縣","02"=>"宜蘭縣","03"=>"桃園縣","04"=>"新竹縣","05"=>"苗栗縣",
"06"=>"台中縣","07"=>"彰化縣","08"=>"南投縣","09"=>"雲林縣","10"=>"嘉義縣","11"=>"台南縣",
"12"=>"高雄縣","13"=>"屏東縣","14"=>"台東縣","15"=>"花蓮縣","16"=>"澎湖縣","17"=>"基隆市",
"18"=>"新竹市","19"=>"台中市","20"=>"嘉義市","21"=>"台南市","31"=>"松山區","32"=>"信義區",
"33"=>"大安區","34"=>"中山區","35"=>"中正區","36"=>"大同區","37"=>"萬華區","38"=>"文山區",
"39"=>"南港區","40"=>"內湖區","41"=>"士林區","42"=>"北投區","51"=>"鹽埕區","52"=>"鼓山區",
"53"=>"左營區","54"=>"楠梓區","55"=>"三民區","56"=>"新興區","57"=>"前金區","58"=>"苓雅區",
"59"=>"前鎮區","60"=>"旗津區","61"=>"小港區","71"=>"金門縣","72"=>"連江縣","80大陸地區"=>"90海外地區");

	foreach ($state as $kk=> $val){
	if ($val==$sch['sch_sheng']) {$the_stat=$kk;break;}
	}


	$SQL="select scode,sname from  school_edu_tw where sch_sheng='$the_stat' ";

	$rs=$CONN->Execute($SQL) or die("無法查詢，語法:".$SQL);

	$rs = $CONN->Execute($SQL);


	while ($ro=$rs->FetchNextObject(false)) {
	
	$sch_ary[$ro->scode]=get_object_vars($ro);

	}
	

	return $sch_ary;


}



################ 清除所有檔案與該目錄  ##########################
function del_work_dir($path) {
	$a=dir($path);
	$a->rewind();
	$i=0;
	$big_pix=array();
	while($file=$a->read()) {
		if( filetype($path."/".$file)=='file')  unlink($path."/".$file);
	}
	$a->close();
	rmdir($path);
}
##################回上頁函式1#####################
function backe($st="未填妥!按下後回上頁重填!") {
echo"<BR><BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:18pt;color:red'>
	</form></CENTER>";
	exit;
	}

#########------------亂數編班函式--------###########

function set_in_order($st_ary,$class_num){
		global $random_class;
	foreach ($st_ary as $no=>$line ){
		//if( !ereg(',',$line)) continue;//去除空白行
		if( !preg_match('/,*/',$line)) continue;//去除空白行
		$stu_tmp = explode(",",$line);
		$sn=$stu_tmp[0];
			$now_stud['sn']=trim($stu_tmp[0]);
			$now_stud['sex']=trim($stu_tmp[3]);
			$now_stud['stud_name']=$stu_tmp[4];
			$now_stud['person_id']=trim($stu_tmp[5]);
			$now_stud['old_sch']=$stu_tmp[6];
			$now_stud['stud_kind']=trim($stu_tmp[7]);
			$now_stud['bao_id']=trim($stu_tmp[8]);
			$now_stud['memo']=trim($stu_tmp[9]);
		//特殊生
		if ($stu_tmp[7]==1){
			$st_sp[]=$now_stud;
			}
		//雙胞胎同班
		if ($stu_tmp[7]==2){
			$st_bao[$sn]=$now_stud;
			}
			//雙胞胎不同班
		if ($stu_tmp[7]==3){
			$no_bao[$sn]=$now_stud;
			}
		//三胞胎同班
		if ($stu_tmp[7]==4){
			$n = explode(';',$stu_tmp[9]);
			//都同班
			if(count($n)==3){
				$three_bao3[$sn]=$now_stud;	
			}
			//都不同班
			if(empty($n[0])){
				$three_bao0[$sn]=$now_stud;	
			}
			//兩個同班
			if(count($n)==2){
				$three_bao2[$sn]=$now_stud;	
			}		
		}
		//多胞胎且為特殊生
		if ($stu_tmp[7]==5){
			$st_sp_bao[$sn]=$now_stud;
		}	
		//男生
		if ($stu_tmp[7]==0 && $stu_tmp[3]==1){
			$st_boy[]=$now_stud;
			}
		//女生
		if ($stu_tmp[7]==0 && $stu_tmp[3]==2){
			$st_girl[]=$now_stud;
			}
		($stu_tmp[3]==1)? $tmp_class_ary['tol_boy']++:$tmp_class_ary['tol_girl']++;
	}
	//計算男女生比值
	$per=array("boy"=>$tmp_class_ary['tol_boy'],"girl"=>$tmp_class_ary['tol_girl']);
////////////-------初始化男女生數------//////////////////
	for ($i=1;$i<=$class_num;$i++){
		$tmp_class_ary[$i]['boy']=0;
		$tmp_class_ary[$i]['girl']=0;
	}
//print_r($per);
//die();
////////////-------處理特殊生---逆向---//////////////////
$clano='XX';
	if ($st_sp!=''){
		shuffle($st_sp);
			$clano=$class_num;
			foreach  ($st_sp as $sk=>$svalue ){
				$class_ary[$clano][]=$svalue;
				if ($svalue['sex']==1) {$tmp_class_ary[$clano]['boy']++;$tmp_class_ary[$clano]['girl']++;}
				if ($svalue['sex']==2) {$tmp_class_ary[$clano]['girl']++;$tmp_class_ary[$clano]['boy']++;}
				($clano==1) ? $clano=$class_num:$clano--;
				}
		}



////////////-------雙胞胎同班處理------//////////////////

	if ( !empty($st_bao)){
		if ($clano=='XX' )$clano=$class_num;
	//逆向
	while(!empty($st_bao)){
		$stud=end($st_bao);
		$sn1=$stud['sn'];$sn2=$stud['bao_id'];
		$class_ary[$clano][]=$st_bao[$sn1];
		($st_bao[$sn1]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		$class_ary[$clano][]=$st_bao[$sn2];
		($st_bao[$sn2]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		unset($st_bao[$sn1]);
		unset($st_bao[$sn2]);
		($clano==1) ? $clano=$class_num:$clano--;
	}
	}
//		die("$clano");


////////////-------補齊學生數------//////////////////
        //第二次亂數
		shuffle($st_boy);shuffle($st_girl);
	if ($clano!='XX' && $clano >= 1 ) {
		for($clano;$clano>=1;$clano--){
			if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
				$class_ary[$clano][]=end($st_girl);
				$tmp_class_ary[$clano]['girl']++;
				$st_girl=array_slice($st_girl,0,-1);
				}else{
				$class_ary[$clano][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$clano]['boy']++;
				}
			if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
				$class_ary[$clano][]=end($st_girl);
				$tmp_class_ary[$clano]['girl']++;
				$st_girl=array_slice($st_girl,0,-1);
				}else{
				$class_ary[$clano][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$clano]['boy']++;
				}
			}
		}
		
		//echo "<PRE>";
		//print_r($class_ary);
		//print_r($tmp_class_ary);
		//die("$clano");
//	echo "<PRE>";
//	print_r($tmp_class_ary);
//	die("$clano");

//////----------------雙胞胎不同班處理----------------//////
		$clano =1;
	while(!empty($no_bao)){
		$stud=end($no_bao);
		$sn1=$stud['sn'];$sn2=$stud['bao_id'];
		$class_ary[$clano][]=$no_bao[$sn1];
		($no_bao[$sn1]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		$clano++;
		if ($clano>$class_num) $clano=1;
		$class_ary[$clano][]=$no_bao[$sn2];
		($no_bao[$sn2]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		unset($no_bao[$sn1]);
		unset($no_bao[$sn2]);
		$clano++;
		if ($clano>$class_num) $clano=1;
	}
//		die("$clano");

//////--------------補齊學生數1---------------//////
		if ($clano > 1 ) {
		for($clano;$clano<=$class_num;$clano++){
			if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
				$class_ary[$clano][]=end($st_girl);
				$st_girl=array_slice($st_girl,0,-1);
				$tmp_class_ary[$clano]['girl']++;
				}
			else{
				$class_ary[$clano][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$clano]['boy']++;
				}
			}
			}

			

			///////////-------三胞胎都同班處理------//////////////////
if ( !empty($three_bao3)){
	//從1班開始編
	$clano =1;	
	while(!empty($three_bao3)){
		$stud=end($three_bao3);
		$sn = explode(';',$stud['bao_id']);
		$sn1=$stud['sn'];
		$sn2=$sn[0];
		$sn3=$sn[1];
		$class_ary[$clano][]=$three_bao3[$sn1];
		($three_bao3[$sn1]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		$class_ary[$clano][]=$three_bao3[$sn2];
		($three_bao3[$sn2]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		$class_ary[$clano][]=$three_bao3[$sn3];
		($three_bao3[$sn3]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		unset($three_bao3[$sn1]);
		unset($three_bao3[$sn2]);
		unset($three_bao3[$sn3]);
		($clano==$class_num) ? $clano=1:$clano++;
	}

	////////////-------補齊學生數3------//////////////////
	if ($clano!='XX' && $clano >= 1 ) {
		for($clano;$clano<=$class_num;$clano++){
			if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
				$class_ary[$clano][]=end($st_girl);
				$tmp_class_ary[$clano]['girl']++;
				$st_girl=array_slice($st_girl,0,-1);
			}else{
				$class_ary[$clano][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$clano]['boy']++;
			}
			if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
				$class_ary[$clano][]=end($st_girl);
				$tmp_class_ary[$clano]['girl']++;
				$st_girl=array_slice($st_girl,0,-1);
			}else{
				$class_ary[$clano][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$clano]['boy']++;
			}
			if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
				$class_ary[$clano][]=end($st_girl);
				$tmp_class_ary[$clano]['girl']++;
				$st_girl=array_slice($st_girl,0,-1);
			}else{
				$class_ary[$clano][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$clano]['boy']++;
			}
		}
	}
}

//////----------------三胞胎都不同班處理----------------//////
if(!empty($three_bao0)){
	$clano =1;
	while(!empty($three_bao0)){
		$stud=end($three_bao0);
		$sn = explode(';',$stud['bao_id']);
		$sn1=$stud['sn'];
		$sn2=$sn[0];
		$sn3=$sn[1];
		$class_ary[$clano][]=$three_bao0[$sn1];
		($three_bao0[$sn1]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;
	
		$clano++;
		if ($clano>$class_num) $clano=1;
		$class_ary[$clano][]=$three_bao0[$sn2];
		($three_bao0[$sn2]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;
	
		$clano++;
		if ($clano>$class_num) $clano=1;
		$class_ary[$clano][]=$three_bao0[$sn3];
		($three_bao0[$sn3]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;
	
		unset($three_bao0[$sn1]);
		unset($three_bao0[$sn2]);
		unset($three_bao0[$sn3]);
		$clano++;
		if ($clano>$class_num) $clano=1;
	}
	//////--------------補齊學生數1---------------//////
		if ($clano > 1 ) {
			for($clano;$clano<=$class_num;$clano++){
				if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
					$class_ary[$clano][]=end($st_girl);
					$st_girl=array_slice($st_girl,0,-1);
					$tmp_class_ary[$clano]['girl']++;
				}
				else{
					$class_ary[$clano][]=end($st_boy);
					$st_boy=array_slice($st_boy,0,-1);
					$tmp_class_ary[$clano]['boy']++;
				}
			}
		}
}
//		die("$clano");


//////----------------三胞胎兩個同班處理----------------//////
if ( !empty($three_bao2)){
	//從1班開始編
	$clano =1;	
	$k=1;
	while(!empty($three_bao2)){
		$stud=end($three_bao2);
		$sn = explode(';',$stud['bao_id']);
		$sn1=$stud['sn'];
		$sn2=$sn[0];
		$sn3=$sn[1];
		$sn_array = [$sn1,$sn2,$sn3];

		$sn_both = explode(';',$stud['memo']);
		$sn_both1 = $sn_both[0];
		$sn_both2 = $sn_both[1];

		//找出不同班者
		foreach($sn_array as $k=>$v){
			if(!in_array($v,$sn_both)) $sn_not_both = $v;
		}


		$class_ary[$clano][]=$three_bao2[$sn_both1];
		($three_bao2[$sn_both1]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;

		$class_ary[$clano][]=$three_bao2[$sn_both2];
		($three_bao2[$sn_both2]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;		
		
		//第三個不同班	
		$clano++;	
		if ($clano>$class_num) $clano=1;
		$class_ary[$clano][]=$three_bao2[$sn_not_both];
		($three_bao2[$sn_not_both]['sex']==1) ? $tmp_class_ary[$clano]['boy']++:$tmp_class_ary[$clano]['girl']++;
		
		unset($three_bao2[$sn1]);
		unset($three_bao2[$sn2]);
		unset($three_bao2[$sn3]);
		
		$clano++;
		if ($clano>$class_num) $clano=1;
		$k++;
	
	}

	

	//取出目前最大班為
	$clano = 1;
	$max = 0;
	for($clano;$clano<=$class_num;$clano++){
		$all = $tmp_class_ary[$clano]['boy'] + $tmp_class_ary[$clano]['girl'];
		if($all > $max) $max = $all;
	}

	//剩下的各班補足
	$clano = 1;
	for($clano;$clano<=$class_num;$clano++){
		$all = $tmp_class_ary[$clano]['boy'] + $tmp_class_ary[$clano]['girl'];
		if($all < $max){
			$n=1;
			for($n;$n<=$max-$all;$n++){
				if ( chk_sex($per,$tmp_class_ary[$clano]['boy'],$tmp_class_ary[$clano]['girl'])==2 ) {
					$class_ary[$clano][]=end($st_girl);
					$st_girl=array_slice($st_girl,0,-1);
					$tmp_class_ary[$clano]['girl']++;
				}
				else{
					$class_ary[$clano][]=end($st_boy);
					$st_boy=array_slice($st_boy,0,-1);
					$tmp_class_ary[$clano]['boy']++;
				}
			}	
		}
	}
}



////////////-------平均學生數一次求男女生一樣多1------//////////////////
	for ($i=1;$i<=$class_num;$i++){
			if ( chk_sex($per,$tmp_class_ary[$i]['boy'],$tmp_class_ary[$i]['girl'])==2 ) {
				$class_ary[$i][]=end($st_girl);
				$st_girl=array_slice($st_girl,0,-1);
				$tmp_class_ary[$i]['girl']++;
				}
			else{
				$class_ary[$i][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$i]['boy']++;
				}
	}
		////////////-------平均學生數一次求男女生一樣多2------//////////////////
	for ($i=1;$i<=$class_num;$i++){
			if ( chk_sex($per,$tmp_class_ary[$i]['boy'],$tmp_class_ary[$i]['girl'])==2 ) {
				$class_ary[$i][]=end($st_girl);
				$st_girl=array_slice($st_girl,0,-1);
				$tmp_class_ary[$i]['girl']++;
				}
			else{
				$class_ary[$i][]=end($st_boy);
				$st_boy=array_slice($st_boy,0,-1);
				$tmp_class_ary[$i]['boy']++;
				}
	}


//////-------------一般生處理---------------///////

	$all_stu=array_merge($st_boy,$st_girl);
	foreach  ($all_stu as $sk=>$svalue ){
		$clano=($sk%$class_num )+1;
		$class_ary[$clano][]=$svalue;
	}




/*
	$i=1;//班級數
	while(count($st_boy)>0 || count($st_girl)>0 ){
		//男生大於女生
		if ($tmp_class_ary[$i]['boy'] > $tmp_class_ary[$i]['girl']) {
			   if (count($st_girl)>0) {
					$class_ary[$i][]=end($st_girl);
					$st_girl=array_slice($st_girl,0,-1);
					$tmp_class_ary[$i]['girl']++;
					}
				else{
					$class_ary[$i][]=end($st_boy);
					$st_boy=array_slice($st_boy,0,-1);
					$tmp_class_ary[$i]['boy']++;
					}
				}
		//女生大於男生
		if ($tmp_class_ary[$i]['boy'] < $tmp_class_ary[$i]['girl']) {
			   if (count($st_boy)>0) {
					$class_ary[$i][]=end($st_boy);
					$st_boy=array_slice($st_boy,0,-1);
					$tmp_class_ary[$i]['boy']++;
					}
				else{
					$class_ary[$i][]=end($st_girl);
					$st_girl=array_slice($st_girl,0,-1);
					$tmp_class_ary[$i]['girl']++;
					}
				}
		//女生等於男生
		if ($tmp_class_ary[$i]['boy'] == $tmp_class_ary[$i]['girl']) {
				if (count($st_boy)>=count($st_girl)) {
					$class_ary[$i][]=end($st_boy);
					$st_boy=array_slice($st_boy,0,-1);
					$tmp_class_ary[$i]['boy']++;
					}
				else{
					$class_ary[$i][]=end($st_girl);
					$st_girl=array_slice($st_girl,0,-1);
					$tmp_class_ary[$i]['girl']++;
				}
			}
		$i++;
	if ($i>$class_num) $i=1;
	}

*/

//////----整理成班級陣列,打亂座號並將男生放到前面-------///////

	for ($i=1;$i<=$class_num;$i++){
				$this_boy=[];$this_girl=[];
		shuffle($class_ary[$i]);
		foreach($class_ary[$i] as $stu){
			if ($stu['sex']==1) $this_boy[]=$stu;
			if ($stu['sex']==2) $this_girl[]=$stu;
			}
		$OK[$i]=array_merge($this_boy,$this_girl);//將男生放到前面
	}
if ($random_class=='Yes'){
		$aa=range(1,$class_num);
		shuffle($aa);$i=1;
		foreach($aa as $key) {
			$OK_ary[$i]=$OK[$key];
			$i++;
			}
		return $OK_ary;
	}
	else{ return $OK;}
}

//////-------------補齊顯示用函式---------------///////
function chk_sex($per,$boy,$girl) {
	//男生總人數較多時,男生先
	if ($per['boy'] > $per['girl']){
		if ($boy > $girl) return '2';
		if ($boy <= $girl) return '1';
	}
	//男生總人數較少時,女生先
	if ($per['boy'] <  $per['girl']){
		if ($boy < $girl) return '1';
		if ($boy >= $girl) return '2';
	}
	//男生總人數一樣時,男生先
	if ($per['boy'] ==  $per['girl']){
		if ($boy > $girl) return '2';
		if ($boy <= $girl) return '1';
	}
}
function add_to_td($data,$num) {
	$all=count($data);
	$loop=ceil($all/$num);
	$flag=$num-1;
	$all_td=($loop*$num)-1;//最大值小1
	$show=array();
	for ($i=0;$i<=$all_td;$i++){
		$show[$i]=$data[$i];
		if (($i%$num)==$flag && $i!=0 && $i!=$all_td ){
			$show[$i]['next_line']='yes';
			}else {
			$show[$i]['next_line']='';
			}
		}
	return $show;
}
//////-------------補齊顯示用函式2---------------///////
function add_to_td2($data,$num) {
	$all=count($data);
	$loop=ceil($all/$num);
	$flag=$num-1;//幾格的key
	$all_td=($loop*$num)-1;//最大值小1
	$show=array();$i=0;
	foreach ($data as $key=>$ary ){
		(($i%$num)==$flag && $i!=0 && $i!=$all_td ) ? $ary['next_line']='yes':$ary['next_line']='';
		$show[$key]=$ary;
		$i++;
		}
	if ($i<=$all_td ){
		for ($i;$i<=$all_td;$i++){
			$key='Add_Td_'.$i;
		(($i%$num)==$flag && $i!=0 && $i!=$all_td ) ? $show[$key]['next_line']='yes':$show[$key]['next_line']='';
		}
	}
		return $show;
}

function class_to_view($class_ary,$class_num,$teach='') {
	for ($i=1;$i<=$class_num;$i++){
		$y=$i-1;$OK[$i]['sp']=0;$OK[$i]['sp_girl']=0;$OK[$i]['sp_boy']=0;
		foreach  ($class_ary[$i] as $stu ){
			if ($stu['sex']==1) {
				if ($stu['stud_kind']==1) $OK[$i]['sp_boy']++;
				$OK[$i]['boys']++;//計算該班男生
				}
			if ($stu['sex']==2) {
				if ($stu['stud_kind']==1) $OK[$i]['sp_girl']++;
				$OK[$i]['girls']++;//計算該班女生
				}
			if ($stu['stud_kind']==1) {
				$OK[$i]['sp']++;//計算該班特殊生
				}
			}
		$OK[$i]['stu']=add_to_td($class_ary[$i],5);
		$OK[$i]['num']=$OK[$i]['boys']+$OK[$i]['girls'];
		if ($teach!='') $OK[$i]['teach']=$teach[$y];
		}
	return $OK;
}

///--------------秀內容函式---------------------------/////
function view_stu($st_ary,$class_num='',$vcalss=''){
//$nn=array("流水號","班級","座號","性別","姓名","身分証字號","就讀國小","編班類別","相關流水號","備註");
//	$nn=array("流水號","班級","座號","性別","姓名","就讀國小","備註");
//	$nn=array("sn","k1","k2","sex","stud_name","person_id","old_sch","stud_kind","bao_id","memo");
	foreach ($st_ary as $no=>$line ){
		//if( !ereg(',',$line)) continue;//去除空白行
		if(!preg_match('/,/',$line)) continue;//去除空白行
		$stu_tmp = explode(",",$line);
		$now_stud['sn']=trim($stu_tmp[0]);
		$now_stud['k1']=$stu_tmp[1];
		$now_stud['k2']=$stu_tmp[2];
		$now_stud['sex']=trim($stu_tmp[3]);
		$now_stud['stud_name']=$stu_tmp[4];
		$now_stud['person_id']=trim($stu_tmp[5]);
		$now_stud['old_sch']=$stu_tmp[6];
		$now_stud['stud_kind']=trim($stu_tmp[7]);
		$now_stud['bao_id']=trim($stu_tmp[8]);
		$now_stud['memo']=trim($stu_tmp[9]);
		$stu[]=$now_stud;
	}
	if ($vcalss=='') {
		return $stu;
	}else{
		foreach ($stu as $stu2 ){
			for ($i=1;$i<=$class_num;$i++){
				if ($stu2['k1']==$i) $class_ary[$i][]=$stu2;
				}
		}
		return $class_ary;
	}
}


################ 取得學校檔案部分內容  #####################################

function get_sch_part($file) {
	$handle = fopen($file, "r");
	$sch=explode(",",fgets($handle, 4096));
//	$teacher=explode(",",fgets($handle, 4096));
	$teacher=fgets($handle, 4096);

//	$sch=fgetcsv($handle,512, ",");//第一行
//	$teacher=fgets($handle,1024);//第二行
//	if( eregi(',',$teacher)) {
	if(preg_match('/,+/',$teacher)) {

		// $teacher=ereg_replace("\n", "",$teacher);
		$teacher=str_replace("\n", "",$teacher);
		$teacher=str_replace("\r", "",$teacher);
		$tea=explode(",",$teacher);
		foreach ($tea as $tea2){
			if ($tea2!='') $sch['teacher'][]=$tea2;
			}
	} else {
		$sch['teacher']='';
		}
	fclose($handle);
	return $sch;

}
################ 取得學校檔案部分內容  #####################################

function get_sp_stu($ary) {
	$sp_stu=array();
	$sp_stu['sp_tol']=0;
	$sp_stu['bo_tol']=0;
	$sp_stu['na_bo_tol']=0;
	$sp_stu['boy']=0;
	$sp_stu['girl']=0;
	$sp_stu['tol']=0;
	
	foreach ($ary as $stu){
		$key=$stu['sn'];
		//特殊生
		if ($stu['stud_kind']==1){
			$sp_stu['sp'][$key]=$stu;
			$sp_stu['sp_tol']++;
		}
		//雙胞胎同班
		if ($stu['stud_kind']==2){
			$sp_stu['bo'][$key]=$stu;
			$sp_stu['bo_tol']++;
		}
		//雙胞胎不同班
		if ($stu['stud_kind']==3){
			$sp_stu['na_bo'][$key]=$stu;
			$sp_stu['na_bo_tol']++;
		}
		//三胞胎
		if ($stu['stud_kind']==4){
			$n = explode(';',$stu['memo']);		
			//都同班
			if(count($n)==3){
				$sp_stu['3bo3'][$key]=$stu;
				$sp_stu['3bo3_tol']++;	
			}
			//都不同班
			if(empty($n[0])){
				$sp_stu['3bo0'][$key]=$stu;
				$sp_stu['3bo0_tol']++;	
			}
			//兩個同班
			if(count($n)==2){
				$sp_stu['3bo2'][$key]=$stu;
				$sp_stu['3bo2_tol']++;	
			}
			
		}
		
		//計算男生
		if ($stu['sex']==1){
			$sp_stu['boy']++;
		}
		//計算女生
		if ($stu['sex']==2){
			$sp_stu['girl']++;
		}
		$sp_stu['tol']++;
	}


	return $sp_stu;

}

function get_Number($num){
    for($i=1;$i<=$num;$i++){
        $A[$i]="Class ".$i;}
    return $A;
}
