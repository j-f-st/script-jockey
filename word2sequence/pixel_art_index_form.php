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
  <meta name="description" content="文字を利用してリズムマシン的な遊びが可能です。文字DJ">
  <title>Script_Jockey</title>
  <link rel="shortcut icon" href="img/kaiten_sitefavi.ico" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
  <link href="./index.css" rel="stylesheet">

  <script src="https://cdn.logrocket.io/LogRocket.min.js" crossorigin="anonymous"></script>
  <script>window.LogRocket && window.LogRocket.init('wki3oq/script_jockey');</script>
</head>

<body>
	<div class="logo_total">
		<div class="logo_upper">
			<h1 id="logo_s"></h1>
			<h1 id="logo_c"></h1>
			<h1 id="logo_r"></h1>
			<h1 id="logo_i"></h1>
			<h1 id="logo_p"></h1>
			<h1 id="logo_t"></h1>
		</div>
		<div class="logo_middle">
			<h1 id="logo_record"><img src="img/kaiten_logo.png"></h1>
		</div>
		<div class="logo_lower">
			<h1 id="logo_j"></h1>
			<h1 id="logo_o"></h1>
			<h1 id="logo_c2"></h1>
			<h1 id="logo_k"></h1>
			<h1 id="logo_e"></h1>
			<h1 id="logo_y"></h1>
		</div>
	</div><!--logo_total-->


	<div class="input_part">
		<h2 id="input_script"></h2>

		<form method="get" action="datachange.php">
    		<input type="text" value="" placeholder="Set" name="input_words" pattern="^[ァ-ンヴー]+$">
    		<button type="submit">Play!</button>
  		</form>
  	</div><!--input_part-->


  	<div class="caution">
		<div class="caution_sentence">
			<h3 style="color: red; font-size: 20px; margin: 0 0 30px 0; padding-top: 15px; text-align: center;">Notice</h3>
			<h3 style="color: red;">This content makes some sounds</h3>
			<h3><span></span>and only works in Google Chrome.</h3>
			<h3>The maximum number of CHARs : 9</h3>
			<h3><span></span>(Short word is recommended.)</h3>
			<h3 style="padding-bottom: 20px;">You can use only listed "カタカナ".</h3>
		</div>
		<h3 style="margin: 15px 0 30px 0; text-align: center;">↓ List ↓</h3>
	</div><!--caution-->

<!--phpでimport?-->
<p class="ptc_a">ア</p>
<p class="ptc_i">イ</p>
<p class="ptc_u">ウ</p>
<p class="ptc_e">エ</p>
<p class="ptc_o">オ</p>

<p class="ptc_ka">カ</p>
<p class="ptc_ki">キ</p>
<p class="ptc_ku">ク</p>
<p class="ptc_ke">ケ</p>
<p class="ptc_ko">コ</p>

<p class="ptc_sa">サ</p>
<p class="ptc_si">シ</p>
<p class="ptc_su">ス</p>
<p class="ptc_se">セ</p>
<p class="ptc_so">ソ</p>

<p class="ptc_ta">タ</p>
<p class="ptc_ti">チ</p>
<p class="ptc_tu">ツ</p>
<p class="ptc_te">テ</p>
<p class="ptc_to">ト</p>

<p class="ptc_na">ナ</p>
<p class="ptc_ni">ニ</p>
<p class="ptc_nu">ヌ</p>
<p class="ptc_ne">ネ</p>
<p class="ptc_no">ノ</p>

<p class="ptc_ha">ハ</p>
<p class="ptc_hi">ヒ</p>
<p class="ptc_hu">フ</p>
<p class="ptc_he">ヘ</p>
<p class="ptc_ho">ホ</p>

<p class="ptc_ma">マ</p>
<p class="ptc_mi">ミ</p>
<p class="ptc_mu">ム</p>
<p class="ptc_me">メ</p>
<p class="ptc_mo">モ</p>

<p class="ptc_ya">ヤ</p>
<p class="ptc_yu">ユ</p>
<p class="ptc_yo">ヨ</p>

<p class="ptc_ra">ラ</p>
<p class="ptc_ri">リ</p>
<p class="ptc_ru">ル</p>
<p class="ptc_re">レ</p>
<p class="ptc_ro">ロ</p>

<p class="ptc_wa">ワ</p>
<p class="ptc_wi">ヰ</p>
<p class="ptc_we">ヱ</p>
<p class="ptc_wo">ヲ</p>

<p class="ptc_nn">ン</p>
<p class="ptc_long">ー</p>

<p class="ptc_m_a">ァ</p>
<p class="ptc_m_i">ィ</p>
<p class="ptc_m_u">ゥ</p>
<p class="ptc_m_e">ェ</p>
<p class="ptc_m_o">ォ</p>

<p class="ptc_m_tu">ッ</p>

<p class="ptc_m_ya">ャ</p>
<p class="ptc_m_yu">ュ</p>
<p class="ptc_m_yo">ョ</p>

<p class="ptc_bu">ブ</p>

<footer style="text-align: center;">
<h3 style="margin: 5px 0;">-------------------</h3>
<h3>© 2019</h3>
</footer>
<script>
  //PHP_musical_scoreに 0,1 情報代入するための処置
  //
  var element = document.getElementsByTagName('p');
  var style_list = [];
for(let i=0;i<element.length;i++){
  var style = (element.currentStyle || document.defaultView.getComputedStyle(element[i], '')).boxShadow; 
  style_list[i] = style.split('rgb(0, 0, 0) ').join('').split(' 0px 0px').join('');
  //rgb情報削り,0pxの不要な情報削り
}

  //区切り文字に「, 」を指定(該当px縦横情報の切り出し,0,2,4..縦情報1,3,5..横情報)
  var style_list_extra = [];
for(let i=0;i<element.length;i++){
  style_list_extra[i] = style_list[i].split(', ').join(' ');
}

  //オブジェクトへpixelデータ持たせる(新規作成)
  var char_list = [];
  var char_precision; //個々のオブジェクト
  var column_order = []; //縦
  var row_order = []; //横
for(let i=0;i<style_list_extra.length;i++){
  char_list[i] = style_list_extra[i].split(' ');
  column_order[i] = [];
  row_order[i] = [];
    for(let n=0;n<char_list[i].length;n++){
      if(n===0||n%2===0){
        //px(sliceで後ろから2文字)削除し、8で割った
        column_order[i].push(char_list[i][n].slice( 0, -2 )/8);
      } else if(n%2===1){
        row_order[i].push(char_list[i][n].slice( 0, -2 )/8);
      }
    }
  char_precision = {
    number:[i],
    class:element[i].className,
    column:column_order[i],
    row:row_order[i],
    jap_char:element[i].innerHTML,
    //※innerHTMLカタカナ情報オブジェクト代入(innerHTMLチェンジ関数実行すると動かない)
  };
  char_list[i] = char_precision;
}

</script>
</body>
</html>