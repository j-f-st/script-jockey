<?php
$test = $_POST["input_words"];
$test = mb_convert_kana($test);//半角カナ=>全角カナへ変換

//errorCheck
$err_msg = '<p style="text-align: center;">';
$err_back = '</p><a href="pixel_art_index_form.php" style="display: block; text-align: center;">back</a>';

if(empty($test)){
	echo($err_msg);	echo("no word<br>何も入力されておりません"); echo($err_back);
	exit();
} //値入っているかどうか
if(preg_match('/[ガギグゲゴザジズゼゾダヂヅデドバビベボパピプペポヮヵヶヴ]/u',$test)){
	echo($err_msg);	echo("Sorry there are some words that I couldn't prepare.<br>用意できていないカタカナがあります リスト内の文字でやってみて下さい"); echo($err_back);
	exit();
} //未用意文字排除
if(preg_match('/[^ァ-ヴー]/u',$test)){
	echo($err_msg);	echo("You can use only listed カタカナ!<br>リスト内の「カタカナ」のみ使えます"); echo($err_back);
	exit();
} //使用可能カタカナのみ通す(^==否定)

//文字数カウント
$test_words_length = mb_strlen($test);
if($test_words_length > 9 ){
	echo($err_msg);	echo("Characters limit : 9 CHARs<br>入力可能文字数は9文字までです"); echo($err_back);
	exit();
}// 文字数制限(input枠大きさ的にも現在9文字)

$test_words_list = preg_split("//u", $test, -1, PREG_SPLIT_NO_EMPTY);




/* [現状稼働文字]
アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘ
ホマミムメモヤユヨラリルレロ
ワヰヱヲンーァィゥェォッャュョブ
*/


//エンコードUTF-8へ
$json_char_default_list_pre_decode = mb_convert_encoding('[
	{"number":[0],
	"class":"ptc_a",
	"column":[1,2,3,4,5,6,7,8,7,8,7,4,7,4,5,6,7,3,4,2,3,1,2],
	"row":[1,1,1,1,1,1,1,1,2,2,3,4,4,5,5,5,5,6,6,7,7,8,8],
	"jap_char":"ア"},
	{"number":[1],
	"class":"ptc_i",
	"column":[7,8,5,6,7,3,4,5,6,2,3,4,5,1,2,4,5,4,5,4,5,4,5],
	"row":[1,1,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,6,6,7,7,8,8],
	"jap_char":"イ"},
	{"number":[2],
	"class":"ptc_u",
	"column":[4,5,4,5,1,2,3,4,5,6,7,8,1,2,8,7,6,7,5,6,3,4,5],
	"row":[1,1,2,2,3,3,3,3,3,3,3,3,4,4,4,5,6,6,7,7,8,8,8],
	"jap_char":"ウ"},
	{"number":[3],
	"class":"ptc_e",
	"column":[2,3,4,5,6,7,4,5,4,5,4,5,4,5,1,2,3,4,5,6,7,8],
	"row":[2,2,2,2,2,2,3,3,4,4,5,5,6,6,7,7,7,7,7,7,7,7],
	"jap_char":"エ"},
	{"number":[4],
	"class":"ptc_o",
	"column":[5,5,1,2,3,4,5,6,7,8,4,5,3,4,5,1,2,3,5,1,5,5],
	"row":[1,2,3,3,3,3,3,3,3,3,4,4,5,5,5,6,6,6,6,7,7,8],
	"jap_char":"オ"},
	{"number":[5],
	"class":"ptc_ka",
	"column":[4,5,4,5,2,3,4,5,6,7,8,4,5,7,8,4,5,7,8,3,4,7,2,3,6,7,1,2,5,6],
	"row":[1,1,2,2,3,3,3,3,3,3,3,4,4,4,4,5,5,5,5,6,6,6,7,7,7,7,8,8,8,8],
	"jap_char":"カ"},
	{"number":[6],
	"class":"ptc_ki",
	"column":[4,4,2,3,4,5,6,7,4,5,2,3,4,5,6,7,5,5,5],
	"row":[1,2,3,3,3,3,3,3,4,4,5,5,5,5,5,5,6,7,8],
	"jap_char":"キ"},
	{"number":[7],
	"class":"ptc_ku",
	"column":[4,5,6,7,8,3,4,7,8,3,7,2,3,6,7,5,6,4,5,3,4],
	"row":[2,2,2,2,2,3,3,3,3,4,4,5,5,5,5,6,6,7,7,8,8],
	"jap_char":"ク"},
	{"number":[8],
	"class":"ptc_ke",
	"column":[3,3,3,4,5,6,7,8,2,3,5,6,1,2,5,4,5,4,3,4],
	"row":[1,2,3,3,3,3,3,3,4,4,4,4,5,5,5,6,6,7,8,8],
	"jap_char":"ケ"},
	{"number":[9],
	"class":"ptc_ko",
	"column":[1,2,3,4,5,6,7,8,7,8,7,8,7,8,7,8,1,2,3,4,5,6,7,8],
	"row":[2,2,2,2,2,2,2,2,3,3,4,4,5,5,6,6,7,7,7,7,7,7,7,7],
	"jap_char":"コ"},
	{"number":[10],
	"class":"ptc_sa",
	"column":[3,6,3,6,1,2,3,4,5,6,7,8,3,6,5,6,5,4,5],
	"row":[2,2,3,3,4,4,4,4,4,4,4,4,5,5,6,6,7,8,8],
	"jap_char":"サ"},
	{"number":[11],
	"class":"ptc_si",
	"column":[1,2,2,3,4,8,5,8,1,2,8,2,3,4,7,8,6,7,5,6,2,3,4,5],
	"row":[1,1,2,2,2,2,3,3,4,4,4,5,5,5,5,5,6,6,7,7,8,8,8,8],
	"jap_char":"シ"},
	{"number":[12],
	"class":"ptc_su",
	"column":[1,2,3,4,5,6,7,8,7,8,6,7,5,6,4,5,6,7,2,3,7,8,1,2,8],
	"row":[2,2,2,2,2,2,2,2,3,3,4,4,5,5,6,6,6,6,7,7,7,7,8,8,8],
	"jap_char":"ス"},
	{"number":[13],
	"class":"ptc_se",
	"column":[3,3,1,2,3,4,5,6,7,8,3,7,8,3,6,3,3,4,4,5,6,7,8],
	"row":[1,2,3,3,3,3,3,3,3,3,4,4,4,5,5,6,7,7,8,8,8,8,8],
	"jap_char":"セ"},
	{"number":[14],
	"class":"ptc_so",
	"column":[2,7,8,2,3,7,3,7,3,4,6,7,6,5,6,3,4,5],
	"row":[2,2,2,3,3,3,4,4,5,5,5,5,6,7,7,8,8,8],
	"jap_char":"ソ"},
	{"number":[15],
	"class":"ptc_ta",
	"column":[3,3,4,5,2,3,5,6,7,1,2,3,7,8,1,3,4,6,7,4,5,6,3,4,5,2,3],
	"row":[1,2,2,2,3,3,3,3,3,4,4,4,4,4,5,5,5,5,5,6,6,6,7,7,7,8,8],
	"jap_char":"タ"},
	{"number":[16],
	"class":"ptc_ti",
	"column":[5,6,3,4,5,5,7,8,4,5,6,7,1,2,3,4,5,4,5,4,3],
	"row":[1,1,2,2,2,3,3,3,4,4,4,4,5,5,5,5,5,6,6,7,8],
	"jap_char":"チ"},
	{"number":[17],
	"class":"ptc_tu",
	"column":[2,5,8,2,5,8,2,5,8,2,5,7,8,7,6,7,6,5],
	"row":[1,1,1,2,2,2,3,3,3,4,4,4,4,5,6,6,7,8],
	"jap_char":"ツ"},
	{"number":[18],
	"class":"ptc_te",
	"column":[2,3,4,5,6,7,1,2,3,4,5,6,7,8,5,5,4,5,3,4],
	"row":[2,2,2,2,2,2,4,4,4,4,4,4,4,4,5,6,7,7,8,8],
	"jap_char":"テ"},
	{"number":[19],
	"class":"ptc_to",
	"column":[3,3,3,3,4,3,4,5,3,6,3,3],
	"row":[1,2,3,4,4,5,5,5,6,6,7,8],
	"jap_char":"ト"},
	{"number":[20],
	"class":"ptc_na",
	"column":[5,5,5,2,3,4,5,6,7,5,4,5,3,4,2,3],
	"row":[1,2,3,4,4,4,4,4,4,5,6,6,7,7,8,8],
	"jap_char":"ナ"},
	{"number":[21],
	"class":"ptc_ni",
	"column":[3,4,5,6,2,3,4,5,6,7],
	"row":[3,3,3,3,7,7,7,7,7,7],
	"jap_char":"ニ"},
	{"number":[22],
	"class":"ptc_nu",
	"column":[1,2,3,4,5,6,7,6,7,2,3,5,6,3,4,5,3,4,5,6,2,3,6,7,1,2],
	"row":[2,2,2,2,2,2,2,3,3,4,4,4,4,5,5,5,6,6,6,6,7,7,7,7,8,8],
	"jap_char":"ヌ"},
	{"number":[23],
	"class":"ptc_ne",
	"column":[4,5,4,5,1,2,3,4,5,6,7,8,6,7,4,5,6,3,4,5,6,1,2,4,5,7,8,1,4,5,8],
	"row":[1,1,2,2,3,3,3,3,3,3,3,3,4,4,5,5,5,6,6,6,6,7,7,7,7,7,7,8,8,8,8],
	"jap_char":"ネ"},
	{"number":[24],
	"class":"ptc_no",
	"column":[7,7,6,7,6,5,6,4,5,3,4,1,2,3],
	"row":[1,2,3,3,4,5,5,6,6,7,7,8,8,8],
	"jap_char":"ノ"},
	{"number":[25],
	"class":"ptc_ha",
	"column":[3,6,3,6,3,6,2,3,6,7,1,2,7,8,1,8],
	"row":[2,2,3,3,4,4,5,5,5,5,6,6,6,6,7,7],
	"jap_char":"ハ"},
	{"number":[26],
	"class":"ptc_hi",
	"column":[2,3,2,3,8,2,3,6,7,2,3,4,5,6,2,3,2,3,2,3,3,4,5,6,7,8],
	"row":[1,1,2,2,2,3,3,3,3,4,4,4,4,4,5,5,6,6,7,7,8,8,8,8,8,8],
	"jap_char":"ヒ"},
	{"number":[27],
	"class":"ptc_hu",
	"column":[1,2,3,4,5,6,7,8,7,8,6,7,5,6,4,5,3,4,1,2,3],
	"row":[2,2,2,2,2,2,2,2,3,3,4,4,5,5,6,6,7,7,8,8,8],
	"jap_char":"フ"},
	{"number":[28],
	"class":"ptc_he",
	"column":[3,4,2,3,4,5,1,2,5,6,6,7,7,8,8],
	"row":[2,2,3,3,3,3,4,4,4,4,5,5,6,6,7],
	"jap_char":"ヘ"},
	{"number":[29],
	"class":"ptc_ho",
	"column":[4,5,4,5,1,2,3,4,5,6,7,8,4,5,2,4,5,7,1,2,4,5,7,8,1,4,5,8,4,5],
	"row":[1,1,2,2,3,3,3,3,3,3,3,3,4,4,5,5,5,5,6,6,6,6,6,6,7,7,7,7,8,8],
	"jap_char":"ホ"},
	{"number":[30],
	"class":"ptc_ma",
	"column":[1,2,3,4,5,6,7,8,7,8,7,2,3,5,6,3,4,5,4,5,5,6,7],
	"row":[2,2,2,2,2,2,2,2,3,3,4,5,5,5,5,6,6,6,7,7,8,8,8],
	"jap_char":"マ"},
	{"number":[31],
	"class":"ptc_mi",
	"column":[2,3,3,4,5,6,6,7,3,4,4,5,6,2,2,3,4,5,5,6,7,8],
	"row":[1,1,2,2,2,2,3,3,4,4,5,5,5,6,7,7,7,7,8,8,8,8],
	"jap_char":"ミ"},
	{"number":[32],
	"class":"ptc_mu",
	"column":[4,4,3,4,3,2,3,6,7,2,7,1,2,3,4,5,6,7,8,1,2,8],
	"row":[1,2,3,3,4,5,5,5,5,6,6,7,7,7,7,7,7,7,7,8,8,8],
	"jap_char":"ム"},
	{"number":[33],
	"class":"ptc_me",
	"column":[6,6,2,3,6,4,5,6,5,6,7,4,7,8,3,4,1,2,3],
	"row":[1,2,3,3,3,4,4,4,5,5,5,6,6,6,7,7,8,8,8],
	"jap_char":"メ"},
	{"number":[34],
	"class":"ptc_mo",
	"column":[2,3,4,5,6,7,4,4,1,2,3,4,5,6,7,8,4,4,4,5,5,6,7,8],
	"row":[1,1,1,1,1,1,2,3,4,4,4,4,4,4,4,4,5,6,7,7,8,8,8,8],
	"jap_char":"モ"},
	{"number":[35],
	"class":"ptc_ya",
	"column":[1,1,2,8,2,3,5,6,7,8,2,3,4,5,7,8,1,2,3,4,7,4,5,5,5,6],
	"row":[1,2,2,2,3,3,3,3,3,3,4,4,4,4,4,4,5,5,5,5,5,6,6,7,8,8],
	"jap_char":"ヤ"},
	{"number":[36],
	"class":"ptc_yu",
	"column":[2,3,4,5,6,7,7,7,6,7,6,5,6,1,2,3,4,5,6,7,8],
	"row":[2,2,2,2,2,2,3,4,5,5,6,7,7,8,8,8,8,8,8,8,8],
	"jap_char":"ユ"},
	{"number":[37],
	"class":"ptc_yo",
	"column":[2,3,4,5,6,7,8,8,8,3,4,5,6,7,8,8,8,8,2,3,4,5,6,7,8],
	"row":[1,1,1,1,1,1,1,2,3,4,4,4,4,4,4,5,6,7,8,8,8,8,8,8,8],
	"jap_char":"ヨ"},
	{"number":[38],
	"class":"ptc_ra",
	"column":[3,4,5,6,1,2,3,4,5,6,7,8,7,8,7,6,7,5,6,2,3,4,5],
	"row":[1,1,1,1,3,3,3,3,3,3,3,3,4,4,5,6,6,7,7,8,8,8,8],
	"jap_char":"ラ"},
	{"number":[39],
	"class":"ptc_ri",
	"column":[3,6,3,6,3,6,3,6,5,6,4,5,3,4],
	"row":[2,2,3,3,4,4,5,5,6,6,7,7,8,8],
	"jap_char":"リ"},
	{"number":[40],
	"class":"ptc_ru",
	"column":[5,3,5,3,5,3,5,3,5,2,3,5,8,1,2,5,7,8,1,5,6],
	"row":[1,2,2,3,3,4,4,5,5,6,6,6,6,7,7,7,7,7,8,8,8],
	"jap_char":"ル"},
	{"number":[41],
	"class":"ptc_re",
	"column":[3,3,3,3,3,8,3,7,8,3,4,5,6,7,3,4,5,6],
	"row":[1,2,3,4,5,5,6,6,6,7,7,7,7,7,8,8,8,8],
	"jap_char":"レ"},
	{"number":[42],
	"class":"ptc_ro",
	"column":[1,2,3,4,5,6,7,8,1,2,3,4,5,6,7,8,1,2,7,8,1,2,7,8,1,2,7,8,1,2,7,8,1,2,3,4,5,6,7,8,1,2,3,4,5,6,7,8],
	"row":[1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,6,6,6,6,7,7,7,7,7,7,7,7,8,8,8,8,8,8,8,8],
	"jap_char":"ロ"},
	{"number":[43],
	"class":"ptc_wa",
	"column":[1,2,3,4,5,6,7,8,1,2,8,1,2,8,1,2,8,7,8,7,5,6,7,2,3,4,5],
	"row":[1,1,1,1,1,1,1,1,2,2,2,3,3,3,4,4,4,5,5,6,7,7,7,8,8,8,8],
	"jap_char":"ワ"},
	{"number":[44],
	"class":"ptc_wi",
	"column":[6,6,2,3,4,5,6,7,3,6,3,6,1,2,3,4,5,6,7,8,6,6],
	"row":[1,2,3,3,3,3,3,3,4,4,5,5,6,6,6,6,6,6,6,6,7,8],
	"jap_char":"ヰ"},
	{"number":[45],
	"class":"ptc_we",
	"column":[2,3,4,5,6,7,8,8,5,7,8,5,6,7,5,5,1,2,3,4,5,6,7,8],
	"row":[1,1,1,1,1,1,1,2,3,3,3,4,4,4,5,6,7,7,7,7,7,7,7,7],
	"jap_char":"ヱ"},
	{"number":[46],
	"class":"ptc_wo",
	"column":[1,2,3,4,5,6,7,8,8,2,3,4,5,6,7,8,7,6,7,5,6,4,5,2,3,4],
	"row":[1,1,1,1,1,1,1,1,2,3,3,3,3,3,3,3,4,5,5,6,6,7,7,8,8,8],
	"jap_char":"ヲ"},
	{"number":[47],
	"class":"ptc_nn",
	"column":[8,1,2,3,8,3,4,5,8,8,7,8,4,5,6,7,1,2,3,4,5],
	"row":[2,3,3,3,3,4,4,4,4,5,6,6,7,7,7,7,8,8,8,8,8],
	"jap_char":"ン"},
	{"number":[48],
	"class":"ptc_long",
	"column":[8,1,2,3,4,5,6,7,8,1,2,3,4,5,6,7,8],
	"row":[3,4,4,4,4,4,4,4,4,5,5,5,5,5,5,5,5],
	"jap_char":"ー"},
	{"number":[49],
	"class":"ptc_m_a",
	"column":[4,5,6,7,8,6,8,6,7,8,5,6,4,5],
	"row":[4,4,4,4,4,5,5,6,6,6,7,7,8,8],
	"jap_char":"ァ"},
	{"number":[50],
	"class":"ptc_m_i",
	"column":[7,8,6,7,5,6,7,4,5,7,7],
	"row":[4,4,5,5,6,6,6,7,7,7,8],
	"jap_char":"ィ"},
	{"number":[51],
	"class":"ptc_m_u",
	"column":[6,4,5,6,7,8,4,7,8,6,7,5,6],
	"row":[4,5,5,5,5,5,6,6,6,7,7,8,8],
	"jap_char":"ゥ"},
	{"number":[52],
	"class":"ptc_m_e",
	"column":[4,5,6,7,8,6,6,4,5,6,7,8],
	"row":[5,5,5,5,5,6,7,8,8,8,8,8],
	"jap_char":"ェ"},
	{"number":[53],
	"class":"ptc_m_o",
	"column":[7,4,5,6,7,8,5,6,7,5,7,4,5,7],
	"row":[4,5,5,5,5,5,6,6,6,7,7,8,8,8],
	"jap_char":"ォ"},
	{"number":[54],
	"class":"ptc_m_tu",
	"column":[4,6,8,4,6,8,8,7],
	"row":[5,5,5,6,6,6,7,8],
	"jap_char":"ッ"},
	{"number":[55],
	"class":"ptc_m_ya",
	"column":[5,4,5,6,7,8,5,8,5,7,5],
	"row":[4,5,5,5,5,5,6,6,7,7,8],
	"jap_char":"ャ"},
	{"number":[56],
	"class":"ptc_m_yu",
	"column":[4,5,6,7,7,7,4,5,6,7,8],
	"row":[5,5,5,5,6,7,8,8,8,8,8],
	"jap_char":"ュ"},
	{"number":[57],
	"class":"ptc_m_yo",
	"column":[5,6,7,8,8,5,6,7,8,8,5,6,7,8],
	"row":[4,4,4,4,5,6,6,6,6,7,8,8,8,8],
	"jap_char":"ョ"},
	{"number":[58],
	"class":"ptc_bu",
	"column":[7,6,8,1,2,3,4,5,7,5,5,4,5,3,4,1,2,3],
	"row":[1,2,2,3,3,3,3,3,3,4,5,6,6,7,7,8,8,8],
	"jap_char":"ブ"}
]', 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
//jsonをデコードしてjson_char_listへ
$json_char_default_list = json_decode($json_char_default_list_pre_decode,true);

/* json構造
array() { 
[0]=> array(5) { 
	["number"]=> array(1) { [0]=> int(0) } 
	["class"]=> string(5) "ptc_a" 
	["column"]=> 
	 array(23) { [0]=> int(1) [1]=> int(2) [2]=> int(3) [3]=> int(4) [4]=> int(5) [5]=> int(6) [6]=> int(7) [7]=> int(8) [8]=> int(7) [9]=> int(8) [10]=> int(7) [11]=> int(4) [12]=> int(7) [13]=> int(4) [14]=> int(5) [15]=> int(6) [16]=> int(7) [17]=> int(3) [18]=> int(4) [19]=> int(2) [20]=> int(3) [21]=> int(1) [22]=> int(2) } 
	["row"]=> 
	 array(23) { [0]=> int(1) [1]=> int(1) [2]=> int(1) [3]=> int(1) [4]=> int(1) [5]=> int(1) [6]=> int(1) [7]=> int(1) [8]=> int(2) [9]=> int(2) [10]=> int(3) [11]=> int(4) [12]=> int(4) [13]=> int(5) [14]=> int(5) [15]=> int(5) [16]=> int(5) [17]=> int(6) [18]=> int(6) [19]=> int(7) [20]=> int(7) [21]=> int(8) [22]=> int(8) } } 
	["jap_char"]=> string(3)"ア"
[1]=> array(5) ...
*/

//入力された文字をサウンドスコアにマッピング
for($i=0;$i<$test_words_length;$i++){
	${'beat_char_' . $i} = $test_words_list[$i];
	//文字に対応するサウンドスコア初期化
	${'musical_score_' . $i} = [
	["","","","","","","",""], // 8px
	["","","","","","","",""], // 8px
	["","","","","","","",""], // 8px
	["","","","","","","",""], // 8px
	["","","","","","","",""], // 8px
	["","","","","","","",""], // 8px
	["","","","","","","",""], // 8px
	["","","","","","","",""]  // 8px
	];

// echo '<pre>'; var_dump(${'beat_char_' . $i}); echo '</pre><pre>'; var_dump(${'musical_score_' . $i}); echo '</pre>';

}


//入力された文字とjson(文字リスト)を照合
foreach($test_words_list as $key => $value){
	foreach($json_char_default_list as $key_2 => $value_2 ){
		if($value === $value_2["jap_char"]){
			$test_words_list[$key] = $value_2;
		}
	}
}	

//入力文字数分だけスコアにbeat情報代入
for($i=0;$i<$test_words_length;$i++){
	for($j=0;$j<count($test_words_list[$i]["row"]);$j++){

		$row_a_num    = $test_words_list[$i]["row"][$j];
		$column_a_num = $test_words_list[$i]["column"][$j];

		${'musical_score_' . $i}[$row_a_num-1][$column_a_num-1] = "1" ;
		//現状1で音出るが他の数で何かできるかも
	}
}

?>
<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-137050799-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-137050799-1');
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="sigetayoshimi">
<meta name="description" content="文字を利用してリズムマシン的な遊びが可能です。文字DJ">
<meta name="robots" content="noindex,nofollow">
<title>Script_Jockey_Playing</title>
<link rel="shortcut icon" href="img/kaiten_sitefavi.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
<style>

@font-face {
	font-family: 'MyFont';
	src: url('font/kkm_analogtv.ttf');
}

body {
	display: flex;
	flex-wrap: nowrap;
	justify-content: center;
	min-width: 600px;
	margin: 0;
}
div#left_background {
	order: 0;
	height: auto;
	flex: 1;
}
div#right_background {
	order: 2;
	height: auto;
	flex: 1;
}

div.wrap_all {
	order: 1;

	background-color: #fff;

	/*全体フォント*/
	font-family: 'Press Start 2P', cursive;

	/* form側と同じwidth */
	width: 600px;
	margin: 40px 0 auto 0;
}

/* 文字数カウンター */
div.information {
	margin-left: 25px;
}
div.information > h1 span {
	font-family: MyFont;
}
div.information div.counter {
	display: inline-flex;
}
div.information div.counter div#count {
	font-size: 32px;
	margin-top: 21.5px;
}

/* 文字配置ビジュアル確認用 */
.wrapper {
	display: flex;
	flex-wrap: wrap;
	margin: 0 8px;
}
div[id^="order_"] {
	width: 192px; /*個別divに対応して可変*/

	/* div上下間隔空け */
	margin-top: 5px;
    margin-bottom: 5px;
}

div[class^="column_"] {
	display: inline-block;
	padding: 0;
}

/* 0,1情報が入っている個別div */
div.wrapper > div[id^="order_"] > div > div {
	width: 20px;
	height: 20px;

	background-color: #444;
	margin: 1px;
	border: 1px solid #444;
	font-size: 8px;

	visibility: hidden; /* 最初は全隠し JSで'1'のみhidden解除 */

	font-family: initial;
}

/* topページ戻ボタン */
a.back2top {
	text-decoration: none;
	display: block;
	margin: 30px auto;
	width: 320px;
	text-align: center;

	color: red;
	font-size: 20px;
}
a.back2top:active {
	color: #000;
}
a.back2top > span {
	letter-spacing: -15px;
	display: inline-block;
	margin-right: 15px;
}


/* トラックリスト */
div.last_one {
	width: 190px;
	height: 190px;
	margin: auto 0;
	color: #888;
	background-color: #ddd;
}
div.last_one h2 {
	font-size: 12px;
	margin: 14px 0 0 6px;
	color: #444;
}
/* 色渋谷diversityへ */
div.last_one h2 > i {
	font-style: inherit;
}
div.last_one h2 > i:nth-child(1) {
	color: #c81e1a;
}
div.last_one h2 > i:nth-child(2) {
	color: #e57923;
}
div.last_one h2 > i:nth-child(3) {
	color: #e7c033;
}
div.last_one h2 > i:nth-child(4) {
	color: #0e823c;
}
div.last_one h2 > i:nth-child(5) {
	color: #1e519a;
}
div.last_one h2 > i:nth-child(6) {
	color: #651d76;
}

div.last_one ul {
	list-style: none;
	margin-top: 20px;
	padding-left: 12px;
	font-size: 11px;
	color: #666;
}
div.last_one ul > li {
	margin: 5px 0;
}

</style>
<script src="https://cdn.logrocket.io/LogRocket.min.js" crossorigin="anonymous"></script>
<script>window.LogRocket && window.LogRocket.init('wki3oq/script_jockey');</script>
<script>//preload

//sound インスタンス作成
var sound_0 = new Audio("music_stock/sound_0.mp3");
var sound_1 = new Audio("music_stock/sound_1.mp3");
var sound_2 = new Audio("music_stock/sound_2.mp3");
var sound_3 = new Audio("music_stock/sound_3.mp3");
var sound_4 = new Audio("music_stock/sound_4.mp3");
var sound_5 = new Audio("music_stock/sound_5.mp3");
var sound_6 = new Audio("music_stock/sound_6.mp3");
var sound_7 = new Audio("music_stock/sound_7.mp3");

</script>
</head>
<body>
<?php

/*背景用ブロック(x2)*/
echo('<div id="left_background"></div><div id="right_background"></div><div class="wrap_all">');
/*入力文字*/
echo('<div class=information><h1>words:<span>' . $test . '</span></h1>');
/*カウンター*/
echo('<div class="counter"><h1>count:</h1><div id="count">' . $test_words_length . '</div></div></div>');


//文字配置ビジュアル確認用
echo("<div class='wrapper'>");
for($x=0;$x<$test_words_length;$x++){
	echo('<div' . " id=\"order_{$x}\"" . '>');
	for($i=0;$i<8;$i++){
		echo('<div class="row_' . $i . '">');
		for($j=0;$j<8;$j++){
			echo('<div class="column_' . $j . '">');
    		echo(${'musical_score_' . $x}[$i][$j]);
    		if(${'musical_score_' . $x}[$i][$j] === ""){
    			echo('0');
    		}
    		echo('</div>');
		}
		echo('</div>');
	}
	echo('</div>');
	echo('<br>');
}


//147=>左端表示 369=>真ん中表示
if($test_words_length !== 2 && $test_words_length !== 5 && $test_words_length !== 8){
	echo('<div style="width: 192px; height: 192px;"></div>');			
}

echo("<div class='last_one'><h2>S<i>o</i><i>u</i><i>n</i><i>d</i><i>I</i><i>n</i>spiredBy</h2>");
$track_list = [
    '<ul><li>0 Yebisu</li>',
    '<li>1 Moyai</li>',
    '<li>2 Hachiko</li>',
    '<li>3 Crowded</li>',
    '<li>4 Policeman</li>',
    '<li>5 Meiji Jingu</li>',
    '<li>6 Sasazuka bowl</li>',
    '<li>7 Club beat</li>',
];
$track_list_express = implode('', $track_list);

echo $track_list_express;
echo("</ul></div>");//last_one | track_list

echo("</div>");//wrapper

?>

<a class="back2top" href="pixel_art_index_form.php"><span><-</span>top</a>
</div class="wrap_all">

<script>//load-after

//orderの数を取得したい
	var pre_words_count = document.getElementById('count');
	var words_count = pre_words_count.innerHTML;

//　order順にcolumn0~7を順番に動かせばよい
for(let i=0;i<words_count;i++){ //order順
	//変数を動的に生成して words_order_~
	eval("var words_order_" + i + " = document.getElementById('order_" + i + "')");

	for(let j=0;j<8;j++){ //order順	
		//music_order_にcolumnを代入してゆく
		eval("var music_order_" + function(){return j+8*i;}() + " = words_order_" + i + ".getElementsByClassName('column_" + j + "')");
	}
}

	var music_count = words_count*8;
	console.log(music_count);


//同じ拍目を鳴らしたりするモジュール
function sameColumnSounds(num){
	for(let j=0;j<8;j++){
		if(eval("music_order_" + num + "[" + j + "].innerHTML == '1'")){
			eval("sound_" + j +".play()");

			eval("music_order_" + num + "[" + j + "].innerHTML = '　'");//空文字
			eval("music_order_" + num + "[" + j + "].style = 'visibility: initial;'");
			//visibility:hidden解除
		}
		if(eval("music_order_" + num + "[" + j + "].innerHTML == '0'")){


			eval("music_order_" + num + "[" + j + "].innerHTML = '　'");//空文字入れてるけど他の文字も表示させられる
			eval("music_order_" + num + "[" + j + "].style = 'visibility: initial; background-color: #fff;'");
		}
	}
}


//////////////
//テンポ調整機能
//////////////
function makeTempo(){
	for(let i=0;i<music_count;i++){
		setTimeout(makeTempoFn(i),i*9100);
	}
}
//別関数
function makeTempoFn(value){
	return function(){
		sameColumnSounds(value);
	}
}
//演奏開始
makeTempo();



/* ------- */
/* 背景処理 */
/* ------- */

var field_back_body = document.getElementsByTagName('body');
var field_left = document.getElementById('left_background');
var field_right = document.getElementById('right_background');

function backGroundTraffic() {
var bg = ["img/north_south.png",
		"img/west_east.png",
		"img/northwest_southeast.png",
		"img/northeast_southwest.png"];
var c = Math.floor(Math.random() * bg.length);
var l = Math.floor(Math.random() * bg.length);
var r = Math.floor(Math.random() * bg.length);
field_back_body[0].style.backgroundImage = "url(" + bg[c] + ")"; 
field_left.style.backgroundImage = "url(" + bg[l] + ")"; 
field_right.style.backgroundImage = "url(" + bg[r] + ")"; 

}

backGroundTraffic();

</script>
</body>
</html>