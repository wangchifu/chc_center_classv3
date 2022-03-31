<?php
//$Id$
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once "./config.php";

//秀出網頁布景標頭
head("彰化縣新生亂數編班系統",$mod_set_arys['super_mgr']);

print_menu($school_menu_p);
$template_file1 = $SFS_PATH."/index.htm";;
$smarty->display($template_file1);
$smarty->display($template_file2);

foot();


