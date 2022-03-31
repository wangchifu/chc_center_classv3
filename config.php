<?php
//$Id$
//預設的引入檔，不可移除。
// require_once "./module-cfg.php";
// include_once "../../include/config.php";
// include_once "../../include/sfs_case_dataarray.php";
//您可以自己加入引入檔
ini_set('default_charset', 'utf-8');
require_once "./chc_func.php";
$SFS_PATH = dirname(__file__) . '/';

$area = (!empty($_SERVER['PHP_AUTH_USER'])) ? $_SERVER['PHP_AUTH_USER'] : "";


//以下可更改
//使用者帳密
$Admin['jhsa'] = 'jhsa_' . date("md");
$Admin['jhsb'] = 'jhsb_' . date("md");
$Admin['changhua'] = 'changhua_' . date("md");
$Admin['homei'] = 'homei_' . date("md");
$Admin['lukang'] = 'lukang_' . date("md");
$Admin['erlin'] = 'erlin_' . date("md");
$Admin['tianzhong'] = 'tianzhong_' . date("md");
$Admin['beidou'] = 'beidou_' . date("md");
$Admin['yuanlin'] = 'yuanlin_' . date("md");
$Admin['xihu'] = 'xihu_' . date("md");

//上傳目錄
$UPLOAD_PATH = '/home/wang/chc_center_classv3_data/' . $area . '/';
$UPLOAD_URL = '../chc_center_classv3_data/' . $area . '/';



//以下勿動//////////////////////////////////////////////////////////////

autoDir($UPLOAD_PATH);


error_reporting(E_ERROR);
//error_reporting( E_ALL );
ini_set('display_errors', '1');

$school_menu_p = array(
    "index.php" => "首頁",
    "indexA.php" => "學校編班作業",
    "tw_id_chk.php?act=yes" => "查驗證號",
    "setup.php" => "系統設定",
);

/*編班中心國中A組陣列宣告*/
$def_school['jhsa']  = array(
    "074308" => array(
        "sch_sn" => "A01",
        "sch_id" => "074308",
        "sch_name" => "彰化縣彰化藝術高中",
    ),
    "074505" => array(
        "sch_sn" => "A02",
        "sch_id" => "074505",
        "sch_name" => "彰化縣陽明國中",
    ),
    "074506" => array(
        "sch_sn" => "A03",
        "sch_id" => "074506",
        "sch_name" => "彰化縣彰安國中",
    ),
    "074507" => array(
        "sch_sn" => "A04",
        "sch_id" => "074507",
        "sch_name" => "彰化縣彰德國中",
    ),
    "074538" => array(
        "sch_sn" => "A05",
        "sch_id" => "074538",
        "sch_name" => "彰化縣彰興國中",
    ),
    "074540" => array(
        "sch_sn" => "A06",
        "sch_id" => "074540",
        "sch_name" => "彰化縣彰泰國中",
    ),
    "074541" => array(
        "sch_sn" => "A07",
        "sch_id" => "074541",
        "sch_name" => "彰化縣信義國中小",
    ),
    "074509" => array(
        "sch_sn" => "A08",
        "sch_id" => "074509",
        "sch_name" => "彰化縣芬園國中",
    ),
    "074526" => array(
        "sch_sn" => "A09",
        "sch_id" => "074526",
        "sch_name" => "彰化縣花壇國中",
    ),
    "074518" => array(
        "sch_sn" => "A10",
        "sch_id" => "074518",
        "sch_name" => "彰化縣溪湖國中",
    ),
    "074339" => array(
        "sch_sn" => "A11",
        "sch_id" => "074339",
        "sch_name" => "彰化縣成功高中",
    ),
    "074519" => array(
        "sch_sn" => "A12",
        "sch_id" => "074519",
        "sch_name" => "彰化縣埔鹽國中",
    ),
    "074520" => array(
        "sch_sn" => "A13",
        "sch_id" => "074520",
        "sch_name" => "彰化縣埔心國中",
    ),
    "074512" => array(
        "sch_sn" => "A14",
        "sch_id" => "074512",
        "sch_name" => "彰化縣萬興國中",
    ),
    "074517" => array(
        "sch_sn" => "A15",
        "sch_id" => "074517",
        "sch_name" => "彰化縣芳苑國中",
    ),
    "074515" => array(
        "sch_sn" => "A16",
        "sch_id" => "074515",
        "sch_name" => "彰化縣大城國中",
    ),
    "074514" => array(
        "sch_sn" => "A17",
        "sch_id" => "074514",
        "sch_name" => "彰化縣竹塘國中",
    ),
    "074313" => array(
        "sch_sn" => "A18",
        "sch_id" => "074313",
        "sch_name" => "彰化縣二林高中",
    ),
    "074516" => array(
        "sch_sn" => "A19",
        "sch_id" => "074516",
        "sch_name" => "彰化縣草湖國中",
    ),
    "074537" => array(
        "sch_sn" => "A20",
        "sch_id" => "074537",
        "sch_name" => "彰化縣原斗國中",
    ),
);

/*編班中心國中B組陣列宣告*/
$def_school['jhsb']  = array(
    "074525" => array(
        "sch_sn" => "B01",
        "sch_id" => "074525",
        "sch_name" => "彰化縣大村國中",
    ),
    "074510" => array(
        "sch_sn" => "B02",
        "sch_id" => "074510",
        "sch_name" => "彰化縣員林國中",
    ),
    "074511" => array(
        "sch_sn" => "B03",
        "sch_id" => "074511",
        "sch_name" => "彰化縣明倫國中",
    ),
    "074527" => array(
        "sch_sn" => "B04",
        "sch_id" => "074527",
        "sch_name" => "彰化縣永靖國中",
    ),
    "074536" => array(
        "sch_sn" => "B05",
        "sch_id" => "074536",
        "sch_name" => "彰化縣大同國中",
    ),
    "074323" => array(
        "sch_sn" => "B06",
        "sch_id" => "074323",
        "sch_name" => "彰化縣和美高中",
    ),
    "074535" => array(
        "sch_sn" => "B07",
        "sch_id" => "074535",
        "sch_name" => "彰化縣和群國中",
    ),
    "074521" => array(
        "sch_sn" => "B08",
        "sch_id" => "074521",
        "sch_name" => "彰化縣福興國中",
    ),
    "074524" => array(
        "sch_sn" => "B09",
        "sch_id" => "074524",
        "sch_name" => "彰化縣伸港國中",
    ),
    "074504" => array(
        "sch_sn" => "B10",
        "sch_id" => "074504",
        "sch_name" => "彰化縣線西國中",
    ),
    "074503" => array(
        "sch_sn" => "B11",
        "sch_id" => "074503",
        "sch_name" => "彰化縣鹿鳴國中",
    ),
    "074502" => array(
        "sch_sn" => "B12",
        "sch_id" => "074502",
        "sch_name" => "彰化縣鹿港國中",
    ),
    "074522" => array(
        "sch_sn" => "B13",
        "sch_id" => "074522",
        "sch_name" => "彰化縣秀水國中",
    ),
    "074534" => array(
        "sch_sn" => "B14",
        "sch_id" => "074534",
        "sch_name" => "彰化縣埤頭國中",
    ),
    "074501" => array(
        "sch_sn" => "B15",
        "sch_id" => "074501",
        "sch_name" => "彰化縣北斗國中",
    ),
    "074532" => array(
        "sch_sn" => "B16",
        "sch_id" => "074532",
        "sch_name" => "彰化縣溪州國中",
    ),
    "074530" => array(
        "sch_sn" => "B17",
        "sch_id" => "074530",
        "sch_name" => "彰化縣社頭國中",
    ),
    "074318" => array(
        "sch_sn" => "B18",
        "sch_id" => "074318",
        "sch_name" => "彰化縣二水國中",
    ),
    "074531" => array(
        "sch_sn" => "B19",
        "sch_id" => "074531",
        "sch_name" => "彰化縣田尾國中",
    ),
    "074328" => array(
        "sch_sn" => "B20",
        "sch_id" => "074328",
        "sch_name" => "彰化縣田中高中",
    ),
    "074533" => array(
        "sch_sn" => "B21",
        "sch_id" => "074533",
        "sch_name" => "彰化縣溪陽國中",
    ),
);


//彰化A
$def_school['changhua']  = array(
    "074601" => array(
        "sch_sn" => "A01",
        "sch_id" => "074601",
        "sch_name" => "縣立中山國小",
    ),
    "074602" => array(
        "sch_sn" => "A02",
        "sch_id" => "074602",
        "sch_name" => "縣立民生國小",
    ),
    "074603" => array(
        "sch_sn" => "A03",
        "sch_id" => "074603",
        "sch_name" => "縣立平和國小",
    ),
    "074604" => array(
        "sch_sn" => "A04",
        "sch_id" => "074604",
        "sch_name" => "縣立南郭國小",
    ),
    "074605" => array(
        "sch_sn" => "A05",
        "sch_id" => "074605",
        "sch_name" => "縣立南興國小",
    ),
    "074606" => array(
        "sch_sn" => "A06",
        "sch_id" => "074606",
        "sch_name" => "縣立東芳國小",
    ),
    "074607" => array(
        "sch_sn" => "A07",
        "sch_id" => "074607",
        "sch_name" => "縣立泰和國小",
    ),
    "074609" => array(
        "sch_sn" => "A08",
        "sch_id" => "074609",
        "sch_name" => "縣立聯興國小",
    ),
    "074610" => array(
        "sch_sn" => "A09",
        "sch_id" => "074610",
        "sch_name" => "縣立大竹國小",
    ),
    "074614" => array(
        "sch_sn" => "A10",
        "sch_id" => "074614",
        "sch_name" => "縣立忠孝國小",
    ),
    "074615" => array(
        "sch_sn" => "A11",
        "sch_id" => "074615",
        "sch_name" => "縣立芬園國小",
    ),
    "074621" => array(
        "sch_sn" => "A12",
        "sch_id" => "074621",
        "sch_name" => "縣立花壇國小",
    ),
    "074625" => array(
        "sch_sn" => "A13",
        "sch_id" => "074625",
        "sch_name" => "縣立三春國小",
    ),
    "074626" => array(
        "sch_sn" => "A14",
        "sch_id" => "074626",
        "sch_name" => "縣立白沙國小",
    ),
    "074774" => array(
        "sch_sn" => "A15",
        "sch_id" => "074774",
        "sch_name" => "縣立信義國小",
    ),
    "074775" => array(
        "sch_sn" => "A16",
        "sch_id" => "074775",
        "sch_name" => "縣立大成國小",
    ),
    "746031" => array(
        "sch_sn" => "A17",
        "sch_id" => "746031",
        "sch_name" => "平和國小建和分校",
    ),
    "074622" => array(
        "sch_sn" => "A18",
        "sch_id" => "074622",
        "sch_name" => "縣立文祥國小",
    ),
);

//和美B
$def_school['homei']  = array(
    "074631" => array(
        "sch_sn" => "A01",
        "sch_id" => "074631",
        "sch_name" => "彰化縣新庄國小",
    ),
    "074633" => array(
        "sch_sn" => "A02",
        "sch_id" => "074633",
        "sch_name" => "彰化縣線西國小",
    ),
    "074632" => array(
        "sch_sn" => "A03",
        "sch_id" => "074632",
        "sch_name" => "彰化縣培英國小",
    ),
    "074630" => array(
        "sch_sn" => "A04",
        "sch_id" => "074630",
        "sch_name" => "彰化縣大榮國小",
    ),
    "074637" => array(
        "sch_sn" => "A05",
        "sch_id" => "074637",
        "sch_name" => "彰化縣伸仁國小",
    ),
    "074769" => array(
        "sch_sn" => "A06",
        "sch_id" => "074769",
        "sch_name" => "彰化縣和仁國小",
    ),
    "074629" => array(
        "sch_sn" => "A07",
        "sch_id" => "074629",
        "sch_name" => "彰化縣大嘉國小",
    ),
    "074627" => array(
        "sch_sn" => "A08",
        "sch_id" => "074627",
        "sch_name" => "彰化縣和美國小",
    ),
    "074636" => array(
        "sch_sn" => "A09",
        "sch_id" => "074636",
        "sch_name" => "彰化縣伸東國小",
    ),
    "074634" => array(
        "sch_sn" => "A10",
        "sch_id" => "074634",
        "sch_name" => "彰化縣曉陽國小",
    ),
    "074638" => array(
        "sch_sn" => "A11",
        "sch_id" => "074638",
        "sch_name" => "彰化縣大同國小",
    ),
    "074628" => array(
        "sch_sn" => "A12",
        "sch_id" => "074628",
        "sch_name" => "彰化縣和東國小",
    ),
    "074635" => array(
        "sch_sn" => "A13",
        "sch_id" => "074635",
        "sch_name" => "彰化縣新港國小",
    ),
);

//鹿港C
$def_school['lukang']  = array(
    "074639" => array(
        "sch_sn" => "A01",
        "sch_id" => "074639",
        "sch_name" => "縣立鹿港國小",
    ),
    "074640" => array(
        "sch_sn" => "A02",
        "sch_id" => "074640",
        "sch_name" => "縣立文開國小",
    ),
    "074641" => array(
        "sch_sn" => "A03",
        "sch_id" => "074641",
        "sch_name" => "縣立洛津國小",
    ),
    "074642" => array(
        "sch_sn" => "A04",
        "sch_id" => "074642",
        "sch_name" => "縣立海埔國小",
    ),
    "074643" => array(
        "sch_sn" => "A05",
        "sch_id" => "074643",
        "sch_name" => "縣立新興國小",
    ),
    "074644" => array(
        "sch_sn" => "A06",
        "sch_id" => "074644",
        "sch_name" => "縣立草港國小",
    ),
    "074645" => array(
        "sch_sn" => "A07",
        "sch_id" => "074645",
        "sch_name" => "縣立頂番國小",
    ),
    "074646" => array(
        "sch_sn" => "A08",
        "sch_id" => "074646",
        "sch_name" => "縣立東興國小",
    ),
    "074771" => array(
        "sch_sn" => "A09",
        "sch_id" => "074771",
        "sch_name" => "縣立鹿東國小",
    ),
    "074654" => array(
        "sch_sn" => "A10",
        "sch_id" => "074654",
        "sch_name" => "縣立秀水國小",
    ),
    "074655" => array(
        "sch_sn" => "A11",
        "sch_id" => "074655",
        "sch_name" => "縣立馬興國小",
    ),
    "074656" => array(
        "sch_sn" => "A12",
        "sch_id" => "074656",
        "sch_name" => "縣立華龍國小",
    ),
    "074657" => array(
        "sch_sn" => "A13",
        "sch_id" => "074657",
        "sch_name" => "縣立明正國小",
    ),
    "074658" => array(
        "sch_sn" => "A14",
        "sch_id" => "074658",
        "sch_name" => "縣立陝西國小",
    ),
    "074659" => array(
        "sch_sn" => "A15",
        "sch_id" => "074659",
        "sch_name" => "縣立育民國小",
    ),
    "074647" => array(
        "sch_sn" => "A16",
        "sch_id" => "074647",
        "sch_name" => "縣立管嶼國小",
    ),
    "074648" => array(
        "sch_sn" => "A17",
        "sch_id" => "074648",
        "sch_name" => "縣立文昌國小",
    ),
    "074649" => array(
        "sch_sn" => "A18",
        "sch_id" => "074649",
        "sch_name" => "縣立西勢國小",
    ),
    "074650" => array(
        "sch_sn" => "A19",
        "sch_id" => "074650",
        "sch_name" => "縣立大興國小",
    ),
    "074651" => array(
        "sch_sn" => "A20",
        "sch_id" => "074651",
        "sch_name" => "縣立永豐國小",
    ),
    "074652" => array(
        "sch_sn" => "A21",
        "sch_id" => "074652",
        "sch_name" => "縣立日新國小",
    ),
    "074653" => array(
        "sch_sn" => "A22",
        "sch_id" => "074653",
        "sch_name" => "縣立育新國小",
    ),
);

//二林D
$def_school['erlin']  = array(
    "074736" => array(
        "sch_sn" => "A01",
        "sch_id" => "074736",
        "sch_name" => "縣立二林國小",
    ),
    "074738" => array(
        "sch_sn" => "A02",
        "sch_id" => "074738",
        "sch_name" => "縣立中正國小",
    ),
    "074742" => array(
        "sch_sn" => "A03",
        "sch_id" => "074742",
        "sch_name" => "縣立萬興國小",
    ),
    "074747" => array(
        "sch_sn" => "A04",
        "sch_id" => "074747",
        "sch_name" => "縣立大城國小",
    ),
    "074753" => array(
        "sch_sn" => "A05",
        "sch_id" => "074753",
        "sch_name" => "縣立竹塘國小",
    ),
    "074764" => array(
        "sch_sn" => "A06",
        "sch_id" => "074764",
        "sch_name" => "縣立漢寶國小",
    ),
    "074765" => array(
        "sch_sn" => "A07",
        "sch_id" => "074765",
        "sch_name" => "縣立王功國小",
    ),
);

//田中E
$def_school['tianzhong']  = array(
    "074698" => array(
        "sch_sn" => "A01",
        "sch_id" => "074698",
        "sch_name" => "縣立田中國小",
    ),
    "074699" => array(
        "sch_sn" => "A02",
        "sch_id" => "074699",
        "sch_name" => "縣立三潭國小",
    ),
    "074700" => array(
        "sch_sn" => "A03",
        "sch_id" => "074700",
        "sch_name" => "縣立大安國小",
    ),
    "074701" => array(
        "sch_sn" => "A04",
        "sch_id" => "074701",
        "sch_name" => "縣立內安國小",
    ),
    "074702" => array(
        "sch_sn" => "A05",
        "sch_id" => "074702",
        "sch_name" => "縣立東和國小",
    ),
    "074703" => array(
        "sch_sn" => "A06",
        "sch_id" => "074703",
        "sch_name" => "縣立明禮國小",
    ),
    "074776" => array(
        "sch_sn" => "A07",
        "sch_id" => "074776",
        "sch_name" => "縣立新民國小",
    ),
    "074704" => array(
        "sch_sn" => "A08",
        "sch_id" => "074704",
        "sch_name" => "縣立社頭國小",
    ),
    "074705" => array(
        "sch_sn" => "A09",
        "sch_id" => "074705",
        "sch_name" => "縣立橋頭國小",
    ),
    "074706" => array(
        "sch_sn" => "A10",
        "sch_id" => "074706",
        "sch_name" => "縣立朝興國小",
    ),
    "074707" => array(
        "sch_sn" => "A11",
        "sch_id" => "074707",
        "sch_name" => "縣立清水國小",
    ),
    "074708" => array(
        "sch_sn" => "A12",
        "sch_id" => "074708",
        "sch_name" => "縣立湳雅國小",
    ),
    "074772" => array(
        "sch_sn" => "A13",
        "sch_id" => "074772",
        "sch_name" => "縣立舊社國小",
    ),
    "074773" => array(
        "sch_sn" => "A14",
        "sch_id" => "074773",
        "sch_name" => "縣立崙雅國小",
    ),
    "074709" => array(
        "sch_sn" => "A15",
        "sch_id" => "074709",
        "sch_name" => "縣立二水國小",
    ),
    "074710" => array(
        "sch_sn" => "A16",
        "sch_id" => "074710",
        "sch_name" => "縣立復興國小",
    ),
    "074711" => array(
        "sch_sn" => "A17",
        "sch_id" => "074711",
        "sch_name" => "縣立源泉國小",
    ),
);
//北斗F
$def_school['beidou']  = array(
    "074712" => array(
        "sch_sn" => "A01",
        "sch_id" => "074712",
        "sch_name" => "縣立北斗國小",
    ),
    "074713" => array(
        "sch_sn" => "A02",
        "sch_id" => "074713",
        "sch_name" => "縣立萬來國小",
    ),
    "074714" => array(
        "sch_sn" => "A03",
        "sch_id" => "074714",
        "sch_name" => "縣立螺青國小",
    ),
    "074716" => array(
        "sch_sn" => "A04",
        "sch_id" => "074716",
        "sch_name" => "縣立螺陽國小",
    ),
    "074717" => array(
        "sch_sn" => "A05",
        "sch_id" => "074717",
        "sch_name" => "縣立田尾國小",
    ),
    "074718" => array(
        "sch_sn" => "A06",
        "sch_id" => "074718",
        "sch_name" => "縣立南鎮國小",
    ),
    "074727" => array(
        "sch_sn" => "A07",
        "sch_id" => "074727",
        "sch_name" => "縣立溪州國小",
    ),
    "074722" => array(
        "sch_sn" => "A08",
        "sch_id" => "074722",
        "sch_name" => "縣立合興國小",
    ),
    "074721" => array(
        "sch_sn" => "A09",
        "sch_id" => "074721",
        "sch_name" => "縣立埤頭國小",
    ),
    "074725" => array(
        "sch_sn" => "A10",
        "sch_id" => "074725",
        "sch_name" => "縣立中和國小",
    ),
);
//員林G
$def_school['yuanlin']  = array(
    "074680" => array(
        "sch_sn" => "A01",
        "sch_id" => "074680",
        "sch_name" => "縣立員林國小",
    ),
    "074681" => array(
        "sch_sn" => "A02",
        "sch_id" => "074681",
        "sch_name" => "縣立育英國小",
    ),
    "074682" => array(
        "sch_sn" => "A03",
        "sch_id" => "074682",
        "sch_name" => "縣立靜修國小",
    ),
    "074683" => array(
        "sch_sn" => "A04",
        "sch_id" => "074683",
        "sch_name" => "縣立僑信國小",
    ),
    "074684" => array(
        "sch_sn" => "A05",
        "sch_id" => "074684",
        "sch_name" => "縣立員東國小",
    ),
    "074686" => array(
        "sch_sn" => "A06",
        "sch_id" => "074686",
        "sch_name" => "縣立東山國小",
    ),
    "074687" => array(
        "sch_sn" => "A07",
        "sch_id" => "074687",
        "sch_name" => "縣立青山國小",
    ),
    "074689" => array(
        "sch_sn" => "A08",
        "sch_id" => "074689",
        "sch_name" => "縣立大村國小",
    ),
    "074691" => array(
        "sch_sn" => "A09",
        "sch_id" => "074691",
        "sch_name" => "縣立村上國小",
    ),
    "074692" => array(
        "sch_sn" => "A10",
        "sch_id" => "074692",
        "sch_name" => "縣立村東國小",
    ),
    "074693" => array(
        "sch_sn" => "A11",
        "sch_id" => "074693",
        "sch_name" => "縣立永靖國小",
    ),
    "074695" => array(
        "sch_sn" => "A12",
        "sch_id" => "074695",
        "sch_name" => "縣立永興國小",
    ),
    "074685" => array(
        "sch_sn" => "A13",
        "sch_id" => "074685",
        "sch_name" => "縣立饒明國小",
    ),
);
//溪湖H
$def_school['xihu']  = array(
    "074660" => array(
        "sch_sn" => "A01",
        "sch_id" => "074660",
        "sch_name" => "縣立溪湖國小",
    ),
    "074662" => array(
        "sch_sn" => "A02",
        "sch_id" => "074662",
        "sch_name" => "縣立湖西國小",
    ),
    "074663" => array(
        "sch_sn" => "A03",
        "sch_id" => "074663",
        "sch_name" => "縣立湖東國小",
    ),
    "074664" => array(
        "sch_sn" => "A04",
        "sch_id" => "074664",
        "sch_name" => "縣立湖南國小",
    ),
    "074777" => array(
        "sch_sn" => "A05",
        "sch_id" => "074777",
        "sch_name" => "縣立湖北國小",
    ),
    "074666" => array(
        "sch_sn" => "A06",
        "sch_id" => "074666",
        "sch_name" => "縣立埔鹽國小",
    ),
    "074669" => array(
        "sch_sn" => "A07",
        "sch_id" => "074669",
        "sch_name" => "縣立好修國小",
    ),
    "074673" => array(
        "sch_sn" => "A08",
        "sch_id" => "074673",
        "sch_name" => "縣立埔心國小",
    ),
    "074674" => array(
        "sch_sn" => "A09",
        "sch_id" => "074674",
        "sch_name" => "縣立太平國小",
    ),
    "074675" => array(
        "sch_sn" => "A10",
        "sch_id" => "074675",
        "sch_name" => "縣立舊館國小",
    ),
    "074661" => array(
        "sch_sn" => "A11",
        "sch_id" => "074661",
        "sch_name" => "縣立東溪國小",
    ),
    "074665" => array(
        "sch_sn" => "A12",
        "sch_id" => "074665",
        "sch_name" => "縣立媽厝國小",
    ),
);

$def['super_mgr'] = 'Yes'; //預設值，是否為測試模式
$def['random_class'] = 'Yes'; ////預設值，建議要Yes才能每次亂數不同班

if (!empty($area)) {
    $mod_set_arys = conf_set($def, $UPLOAD_PATH);
    $school_set = school_set($def_school[$area], $UPLOAD_PATH);
    $sch_up_A = $school_set;
}

$Smarty_class_file = $SFS_PATH . 'Smarty2.6.30/Smarty.class.php';
$Smarty_Compile_DIR = $UPLOAD_PATH . 'tmp/';
autoDir($Smarty_Compile_DIR);

//--------3.Smarty啟動部分----------///
require_once $Smarty_class_file;
//建立物件
$smarty = new Smarty();
$smarty->compile_dir = $Smarty_Compile_DIR; //可寫入的編譯檔置放目錄(絕對路徑)
$smarty->left_delimiter = '{{'; //設定樣本檔的左邊標籤
$smarty->right_delimiter = '}}'; //設定樣本檔的右邊標籤


//簡易認証
function sfs_check()
{
    //login_chk();
    //$aa=$_SESSION['auth']['admin'];
    //if ($aa=='' || $aa < $limit ) backe("！！未經授權或權限不足！！");	return ;

    global $Admin;
    if ($Admin[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW'] || $_SERVER['PHP_AUTH_USER'] == '' || $_SERVER['PHP_AUTH_PW'] == '') {
        Header('WWW-Authenticate: Basic realm="SOGO級超黑金卡會員"');
        //header("WWW-Authenticate: Basic realm=\"SOGO級超黑金卡會員\"");
        Header("HTTP/1.0 401 Unauthorized");
        echo "<div align='center'><h2>不要隨意進入！</h2></div>";
        exit;
    }
}


//----- 自動建立目錄函式 -----//
function autoDir($dir)
{
    //echo $dir.'<br>';
    if (file_exists($dir) && is_dir($dir))    return;
    $rs = @mkdir($dir, 0755);
    if (!$rs) backe($dir . "資料存放區\n 不存在或無法建立");
}

function head($title, $super_mgr)
{
    $alert = ($super_mgr == "Yes") ? "<h2 style='color:red'>測試模式</h2>" : "";
    echo "
    <html>
    <head>
    <meta charset=\"utf-8\" />
    <title>{$title}</title>
    </head>
    <body>
    <style type=\"text/css\">
    A:link  {text-decoration:none;color:blue; }
    A:visited {text-decoration:none;color:blue; }
    A:hover {background-color:FF8000;color: #000000 }
    .content {
        min-height: calc(100vh - 90px);
    }
    .footer {
        height: 70px;
        background-color:#008000;
        color:white;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    </style>
    <div class=\"content\">
    <center><img src=images/107.jpg style='width: 100%;height: auto;'>{$alert}</center>
    <hr size=1>";
}
function print_menu($menu)
{
    echo "<table align=center><tr><td>";
    foreach ($menu as $link => $name) {
        echo "[<a href=$link> $name </a>]、";
    }
    echo "</td></tr></table>";
}
function foot()
{
    echo "
    <br>
    </div>
    <div class=\"footer\">
    <h2>Copyright chi.ET 2020</h2>
    </div>
    </body></html>";
}

//取模組變數
function conf_set($def, $UPLOAD_PATH)
{
    $path = $UPLOAD_PATH . 'setup/';
    $fi = $UPLOAD_PATH . 'setup/config.txt';
    if (!file_exists($path)) mkdir($path);
    if (!file_exists($fi)) file_put_contents($fi, serialize($def));
    if (file_exists($fi)) $tmp = file_get_contents($fi);
    return unserialize($tmp);
}

//取模組變數
function school_set($def_school, $UPLOAD_PATH)
{
    $path = $UPLOAD_PATH . 'setup/';
    $fi = $UPLOAD_PATH . 'setup/school.txt';
    if (!file_exists($path)) mkdir($path);
    if (!file_exists($fi)) file_put_contents($fi, serialize($def_school));
    if (file_exists($fi)) $tmp = file_get_contents($fi);
    return unserialize($tmp);
}
