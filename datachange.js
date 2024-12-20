//sound インスタンス作成
const dir = 'sound_files/';
const sound_0 = new Audio(`${dir}0.mp3`);
const sound_1 = new Audio(`${dir}1.mp3`);
const sound_2 = new Audio(`${dir}2.mp3`);
const sound_3 = new Audio(`${dir}3.mp3`);
const sound_4 = new Audio(`${dir}4.mp3`);
const sound_5 = new Audio(`${dir}5.mp3`);
const sound_6 = new Audio(`${dir}6.mp3`);
const sound_7 = new Audio(`${dir}7.mp3`);

const d = document;
const inputWords = replaceKanaHalfToFull(getParam('input_words'));
const inputWordsLength = inputWords.length;

/**
 * URLから'input_words'を取得
 */
function getParam(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

/**
 * 半角→全角(カタカナ)変換
 */
function replaceKanaHalfToFull(str) {
  const kanaMap = {
    ｶﾞ: 'ガ',
    ｷﾞ: 'ギ',
    ｸﾞ: 'グ',
    ｹﾞ: 'ゲ',
    ｺﾞ: 'ゴ',
    ｻﾞ: 'ザ',
    ｼﾞ: 'ジ',
    ｽﾞ: 'ズ',
    ｾﾞ: 'ゼ',
    ｿﾞ: 'ゾ',
    ﾀﾞ: 'ダ',
    ﾁﾞ: 'ヂ',
    ﾂﾞ: 'ヅ',
    ﾃﾞ: 'デ',
    ﾄﾞ: 'ド',
    ﾊﾞ: 'バ',
    ﾋﾞ: 'ビ',
    ﾌﾞ: 'ブ',
    ﾍﾞ: 'ベ',
    ﾎﾞ: 'ボ',
    ﾊﾟ: 'パ',
    ﾋﾟ: 'ピ',
    ﾌﾟ: 'プ',
    ﾍﾟ: 'ペ',
    ﾎﾟ: 'ポ',
    ｳﾞ: 'ヴ',
    ﾜﾞ: 'ヷ',
    ｦﾞ: 'ヺ',
    ｱ: 'ア',
    ｲ: 'イ',
    ｳ: 'ウ',
    ｴ: 'エ',
    ｵ: 'オ',
    ｶ: 'カ',
    ｷ: 'キ',
    ｸ: 'ク',
    ｹ: 'ケ',
    ｺ: 'コ',
    ｻ: 'サ',
    ｼ: 'シ',
    ｽ: 'ス',
    ｾ: 'セ',
    ｿ: 'ソ',
    ﾀ: 'タ',
    ﾁ: 'チ',
    ﾂ: 'ツ',
    ﾃ: 'テ',
    ﾄ: 'ト',
    ﾅ: 'ナ',
    ﾆ: 'ニ',
    ﾇ: 'ヌ',
    ﾈ: 'ネ',
    ﾉ: 'ノ',
    ﾊ: 'ハ',
    ﾋ: 'ヒ',
    ﾌ: 'フ',
    ﾍ: 'ヘ',
    ﾎ: 'ホ',
    ﾏ: 'マ',
    ﾐ: 'ミ',
    ﾑ: 'ム',
    ﾒ: 'メ',
    ﾓ: 'モ',
    ﾔ: 'ヤ',
    ﾕ: 'ユ',
    ﾖ: 'ヨ',
    ﾗ: 'ラ',
    ﾘ: 'リ',
    ﾙ: 'ル',
    ﾚ: 'レ',
    ﾛ: 'ロ',
    ﾜ: 'ワ',
    ｦ: 'ヲ',
    ﾝ: 'ン',
    ｧ: 'ァ',
    ｨ: 'ィ',
    ｩ: 'ゥ',
    ｪ: 'ェ',
    ｫ: 'ォ',
    ｯ: 'ッ',
    ｬ: 'ャ',
    ｭ: 'ュ',
    ｮ: 'ョ',
    '｡': '。',
    '､': '、',
    ｰ: 'ー',
    '｢': '「',
    '｣': '」',
    '･': '・',
  };
  const reg = new RegExp('(' + Object.keys(kanaMap).join('|') + ')', 'g');
  return str
    .replace(reg, (s) => kanaMap[s])
    .replace(/ﾞ/g, '゛')
    .replace(/ﾟ/g, '゜');
}

// onload
d.addEventListener('DOMContentLoaded', () => {
  handleInputError();
  showSoundScore();
  optimizeGridView();
  showInputData();
  randomizeBackgroundView();
  play();
});

/**
 * 'input_words'のエラーハンドリング
 */
function handleInputError() {
  const errorMsgEmptyHTML =
    '<p style="text-align: center;">no word<br>何も入力されておりません</p><a href="index.htm" style="display: block; text-align: center;">back</a>';
  const errorMsgNotListedHTML =
    '<p style="text-align: center;">Sorry there are some words that I couldnt prepare.<br>用意できていないカタカナがあります リスト内の文字でやってみて下さい</p><a href="index.htm" style="display: block; text-align: center;">back</a>';
  const errorMsgInvalidWordsHTML =
    '<p style="text-align: center;">You can use only listed カタカナ!<br>リスト内の「カタカナ」のみ使えます</p><a href="index.htm" style="display: block; text-align: center;">back</a>';
  const errorMsgOverLengthHTML =
    '<p style="text-align: center;">Characters limit : 9 CHARs<br>入力可能文字数は9文字までです</p><a href="index.htm" style="display: block; text-align: center;">back</a>';
  const wrapper = d.querySelector('main');
  if (inputWords === '') {
    wrapper.innerHTML = errorMsgEmptyHTML;
    return false;
  }
  if (
    /[ガギグゲゴザジズゼゾダヂヅデドバビベボパピプペポヮヵヶヴ]/.test(
      inputWords
    )
  ) {
    wrapper.innerHTML = errorMsgNotListedHTML;
    return false;
  }
  if (/[^ァ-ヴー]/.test(inputWords)) {
    wrapper.innerHTML = errorMsgInvalidWordsHTML;
    return false;
  }
  if (inputWordsLength > 9) {
    // 文字数カウント
    wrapper.innerHTML = errorMsgOverLengthHTML;
    return false;
  }
  return true;
}

/**
 * 演奏開始
 */
function play() {
  // order順にcolumn0~7を順番に動かせばよい
  for (let i = 0; i < inputWordsLength; i++) {
    //order順
    /* グローバルに設定しちゃってるので何とかしたい！！ */
    eval('words_order_' + i + " = document.getElementById('order_" + i + "')");
    for (let j = 0; j < 8; j++) {
      //order順
      //music_order_にcolumnを代入してゆく
      eval(
        'music_order_' +
          (() => j + 8 * i)() +
          ' = words_order_' +
          i +
          ".getElementsByClassName('column_" +
          j +
          "')"
      );
    }
  }
  const musicCount = inputWordsLength * 8;
  setTempo(musicCount);
}

/**
 * テンポ(時間)を設定する
 */
function setTempo(musicCount) {
  for (let count = 0; count < musicCount; count++) {
    setTimeout(setTempoFn(count), count * 9100);
  }
}
function setTempoFn(count) {
  return () => {
    soundSameColumn(count);
  };
}
/**
 * 同じ拍(カラム)の音を鳴らす
 */
function soundSameColumn(num) {
  for (let j = 0; j < 8; j++) {
    if (eval('music_order_' + num + '[' + j + "].innerHTML == '1'")) {
      eval('sound_' + j + '.play()');

      eval('music_order_' + num + '[' + j + "].innerHTML = '　'"); //空文字
      eval('music_order_' + num + '[' + j + "].style = 'visibility: initial;'");
      //visibility:hidden解除
    }
    if (eval('music_order_' + num + '[' + j + "].innerHTML == '0'")) {
      eval('music_order_' + num + '[' + j + "].innerHTML = '　'"); //空文字入れてるけど他の文字も表示させられる
      eval(
        'music_order_' +
          num +
          '[' +
          j +
          "].style = 'visibility: initial; background-color: #fff;'"
      );
    }
  }
}

/**
 * 入力された文字をサウンドスコアにマッピングする
 */
function getSoundScore(inputWords) {
  const soundScore = inputWords.split('').map((word) => {
    const blankMapping = [
      ['', '', '', '', '', '', '', ''], // 8px
      ['', '', '', '', '', '', '', ''],
      ['', '', '', '', '', '', '', ''],
      ['', '', '', '', '', '', '', ''],
      ['', '', '', '', '', '', '', ''],
      ['', '', '', '', '', '', '', ''],
      ['', '', '', '', '', '', '', ''],
      ['', '', '', '', '', '', '', ''],
    ];
    return [word, blankMapping];
  });

  //入力された文字とjson(文字リスト)を照合
  soundScore.forEach((arr) => {
    musicalCharInfoArr.forEach((obj) => {
      if (arr[0] === obj.jap_char) {
        arr[2] = obj;
      }
    });
  });

  //入力文字数分だけスコアにbeat情報代入
  soundScore.forEach((arr) => {
    for (let i = 0; i < arr[2].row.length; i++) {
      const rowANum = arr[2].row[i];
      const columnANum = arr[2].column[i];
      arr[1][rowANum - 1][columnANum - 1] = '1';
    }
  });
  return soundScore;
}
/**
 * soundScoreのデータを受け取ってHTMLを作成する
 */
function getVisualizedHTML(soundScore) {
  let HTML = '';
  soundScore.forEach((score, i) => {
    HTML += `<div id="order_${i}">`;
    for (let x = 0; x < 8; x++) {
      HTML += `<div class="row_${x}">`;
      for (let y = 0; y < 8; y++) {
        HTML += `<div class="column_${y}">${score[1][x][y]}`;
        if (score[1][x][y] === '') HTML += '0';
        HTML += '</div>';
      }
      HTML += '</div>';
    }
    HTML += '</div><br>';
  });
  return HTML;
}
/**
 * soundScoreを描画する
 */
function showSoundScore() {
  d.querySelector('.wrapper').insertAdjacentHTML(
    'beforeend',
    getVisualizedHTML(getSoundScore(inputWords))
  );
}
/**
 * 入力したデータ詳細(文字列,文字数)の表示処理
 */
function showInputData() {
  d.getElementById('js-inputWords').insertAdjacentText('beforeend', inputWords);
  d.getElementById('js-count').insertAdjacentText(
    'beforeend',
    inputWordsLength
  );
}
/**
 * 文字数に応じてビュー(グリッド)を調整
 */
function optimizeGridView() {
  // MEMO: 147=>左端表示 369=>真ん中表示
  if ([2, 5, 8].includes(inputWordsLength)) {
    d.getElementById('js-positionChanger').remove();
  }
}
/**
 * 背景のランダマイズ
 */
function randomizeBackgroundView() {
  const body = d.getElementsByTagName('body')[0];
  const bgLeft = d.getElementById('js-backgroundLeft');
  const bgRight = d.getElementById('js-backgroundRight');
  const bgImages = [
    'img/north_south.png',
    'img/west_east.png',
    'img/northwest_southeast.png',
    'img/northeast_southwest.png',
  ];

  const getRandomIndex = () => {
    return Math.floor(Math.random() * bgImages.length);
  };

  const place = {
    left: getRandomIndex(),
    center: getRandomIndex(),
    right: getRandomIndex(),
  };

  body.style.backgroundImage = `url(${bgImages[place.center]})`;
  bgLeft.style.backgroundImage = `url(${bgImages[place.left]})`;
  bgRight.style.backgroundImage = `url(${bgImages[place.right]})`;
}

// [現状稼働文字]
// アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘ
// ホマミムメモヤユヨラリルレロ
// ワヰヱヲンーァィゥェォッャュョブ
const musicalCharInfoArr = [
  {
    number: [0],
    class: 'ptc_a',
    column: [
      1, 2, 3, 4, 5, 6, 7, 8, 7, 8, 7, 4, 7, 4, 5, 6, 7, 3, 4, 2, 3, 1, 2,
    ],
    row: [1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 3, 4, 4, 5, 5, 5, 5, 6, 6, 7, 7, 8, 8],
    jap_char: 'ア',
  },
  {
    number: [1],
    class: 'ptc_i',
    column: [
      7, 8, 5, 6, 7, 3, 4, 5, 6, 2, 3, 4, 5, 1, 2, 4, 5, 4, 5, 4, 5, 4, 5,
    ],
    row: [1, 1, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 7, 7, 8, 8],
    jap_char: 'イ',
  },
  {
    number: [2],
    class: 'ptc_u',
    column: [
      4, 5, 4, 5, 1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 8, 7, 6, 7, 5, 6, 3, 4, 5,
    ],
    row: [1, 1, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 5, 6, 6, 7, 7, 8, 8, 8],
    jap_char: 'ウ',
  },
  {
    number: [3],
    class: 'ptc_e',
    column: [2, 3, 4, 5, 6, 7, 4, 5, 4, 5, 4, 5, 4, 5, 1, 2, 3, 4, 5, 6, 7, 8],
    row: [2, 2, 2, 2, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7],
    jap_char: 'エ',
  },
  {
    number: [4],
    class: 'ptc_o',
    column: [5, 5, 1, 2, 3, 4, 5, 6, 7, 8, 4, 5, 3, 4, 5, 1, 2, 3, 5, 1, 5, 5],
    row: [1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 6, 6, 7, 7, 8],
    jap_char: 'オ',
  },
  {
    number: [5],
    class: 'ptc_ka',
    column: [
      4, 5, 4, 5, 2, 3, 4, 5, 6, 7, 8, 4, 5, 7, 8, 4, 5, 7, 8, 3, 4, 7, 2, 3, 6,
      7, 1, 2, 5, 6,
    ],
    row: [
      1, 1, 2, 2, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 7, 7, 7,
      7, 8, 8, 8, 8,
    ],
    jap_char: 'カ',
  },
  {
    number: [6],
    class: 'ptc_ki',
    column: [4, 4, 2, 3, 4, 5, 6, 7, 4, 5, 2, 3, 4, 5, 6, 7, 5, 5, 5],
    row: [1, 2, 3, 3, 3, 3, 3, 3, 4, 4, 5, 5, 5, 5, 5, 5, 6, 7, 8],
    jap_char: 'キ',
  },
  {
    number: [7],
    class: 'ptc_ku',
    column: [4, 5, 6, 7, 8, 3, 4, 7, 8, 3, 7, 2, 3, 6, 7, 5, 6, 4, 5, 3, 4],
    row: [2, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 5, 5, 5, 5, 6, 6, 7, 7, 8, 8],
    jap_char: 'ク',
  },
  {
    number: [8],
    class: 'ptc_ke',
    column: [3, 3, 3, 4, 5, 6, 7, 8, 2, 3, 5, 6, 1, 2, 5, 4, 5, 4, 3, 4],
    row: [1, 2, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 6, 6, 7, 8, 8],
    jap_char: 'ケ',
  },
  {
    number: [9],
    class: 'ptc_ko',
    column: [
      1, 2, 3, 4, 5, 6, 7, 8, 7, 8, 7, 8, 7, 8, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8,
    ],
    row: [
      2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7,
    ],
    jap_char: 'コ',
  },
  {
    number: [10],
    class: 'ptc_sa',
    column: [3, 6, 3, 6, 1, 2, 3, 4, 5, 6, 7, 8, 3, 6, 5, 6, 5, 4, 5],
    row: [2, 2, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 6, 6, 7, 8, 8],
    jap_char: 'サ',
  },
  {
    number: [11],
    class: 'ptc_si',
    column: [
      1, 2, 2, 3, 4, 8, 5, 8, 1, 2, 8, 2, 3, 4, 7, 8, 6, 7, 5, 6, 2, 3, 4, 5,
    ],
    row: [
      1, 1, 2, 2, 2, 2, 3, 3, 4, 4, 4, 5, 5, 5, 5, 5, 6, 6, 7, 7, 8, 8, 8, 8,
    ],
    jap_char: 'シ',
  },
  {
    number: [12],
    class: 'ptc_su',
    column: [
      1, 2, 3, 4, 5, 6, 7, 8, 7, 8, 6, 7, 5, 6, 4, 5, 6, 7, 2, 3, 7, 8, 1, 2, 8,
    ],
    row: [
      2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 8, 8, 8,
    ],
    jap_char: 'ス',
  },
  {
    number: [13],
    class: 'ptc_se',
    column: [
      3, 3, 1, 2, 3, 4, 5, 6, 7, 8, 3, 7, 8, 3, 6, 3, 3, 4, 4, 5, 6, 7, 8,
    ],
    row: [1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 5, 5, 6, 7, 7, 8, 8, 8, 8, 8],
    jap_char: 'セ',
  },
  {
    number: [14],
    class: 'ptc_so',
    column: [2, 7, 8, 2, 3, 7, 3, 7, 3, 4, 6, 7, 6, 5, 6, 3, 4, 5],
    row: [2, 2, 2, 3, 3, 3, 4, 4, 5, 5, 5, 5, 6, 7, 7, 8, 8, 8],
    jap_char: 'ソ',
  },
  {
    number: [15],
    class: 'ptc_ta',
    column: [
      3, 3, 4, 5, 2, 3, 5, 6, 7, 1, 2, 3, 7, 8, 1, 3, 4, 6, 7, 4, 5, 6, 3, 4, 5,
      2, 3,
    ],
    row: [
      1, 2, 2, 2, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 6, 6, 6, 7, 7, 7,
      8, 8,
    ],
    jap_char: 'タ',
  },
  {
    number: [16],
    class: 'ptc_ti',
    column: [5, 6, 3, 4, 5, 5, 7, 8, 4, 5, 6, 7, 1, 2, 3, 4, 5, 4, 5, 4, 3],
    row: [1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 5, 6, 6, 7, 8],
    jap_char: 'チ',
  },
  {
    number: [17],
    class: 'ptc_tu',
    column: [2, 5, 8, 2, 5, 8, 2, 5, 8, 2, 5, 7, 8, 7, 6, 7, 6, 5],
    row: [1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4, 4, 5, 6, 6, 7, 8],
    jap_char: 'ツ',
  },
  {
    number: [18],
    class: 'ptc_te',
    column: [2, 3, 4, 5, 6, 7, 1, 2, 3, 4, 5, 6, 7, 8, 5, 5, 4, 5, 3, 4],
    row: [2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 4, 4, 5, 6, 7, 7, 8, 8],
    jap_char: 'テ',
  },
  {
    number: [19],
    class: 'ptc_to',
    column: [3, 3, 3, 3, 4, 3, 4, 5, 3, 6, 3, 3],
    row: [1, 2, 3, 4, 4, 5, 5, 5, 6, 6, 7, 8],
    jap_char: 'ト',
  },
  {
    number: [20],
    class: 'ptc_na',
    column: [5, 5, 5, 2, 3, 4, 5, 6, 7, 5, 4, 5, 3, 4, 2, 3],
    row: [1, 2, 3, 4, 4, 4, 4, 4, 4, 5, 6, 6, 7, 7, 8, 8],
    jap_char: 'ナ',
  },
  {
    number: [21],
    class: 'ptc_ni',
    column: [3, 4, 5, 6, 2, 3, 4, 5, 6, 7],
    row: [3, 3, 3, 3, 7, 7, 7, 7, 7, 7],
    jap_char: 'ニ',
  },
  {
    number: [22],
    class: 'ptc_nu',
    column: [
      1, 2, 3, 4, 5, 6, 7, 6, 7, 2, 3, 5, 6, 3, 4, 5, 3, 4, 5, 6, 2, 3, 6, 7, 1,
      2,
    ],
    row: [
      2, 2, 2, 2, 2, 2, 2, 3, 3, 4, 4, 4, 4, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 8,
      8,
    ],
    jap_char: 'ヌ',
  },
  {
    number: [23],
    class: 'ptc_ne',
    column: [
      4, 5, 4, 5, 1, 2, 3, 4, 5, 6, 7, 8, 6, 7, 4, 5, 6, 3, 4, 5, 6, 1, 2, 4, 5,
      7, 8, 1, 4, 5, 8,
    ],
    row: [
      1, 1, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7,
      7, 7, 8, 8, 8, 8,
    ],
    jap_char: 'ネ',
  },
  {
    number: [24],
    class: 'ptc_no',
    column: [7, 7, 6, 7, 6, 5, 6, 4, 5, 3, 4, 1, 2, 3],
    row: [1, 2, 3, 3, 4, 5, 5, 6, 6, 7, 7, 8, 8, 8],
    jap_char: 'ノ',
  },
  {
    number: [25],
    class: 'ptc_ha',
    column: [3, 6, 3, 6, 3, 6, 2, 3, 6, 7, 1, 2, 7, 8, 1, 8],
    row: [2, 2, 3, 3, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 7, 7],
    jap_char: 'ハ',
  },
  {
    number: [26],
    class: 'ptc_hi',
    column: [
      2, 3, 2, 3, 8, 2, 3, 6, 7, 2, 3, 4, 5, 6, 2, 3, 2, 3, 2, 3, 3, 4, 5, 6, 7,
      8,
    ],
    row: [
      1, 1, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 8, 8, 8,
      8,
    ],
    jap_char: 'ヒ',
  },
  {
    number: [27],
    class: 'ptc_hu',
    column: [1, 2, 3, 4, 5, 6, 7, 8, 7, 8, 6, 7, 5, 6, 4, 5, 3, 4, 1, 2, 3],
    row: [2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 8],
    jap_char: 'フ',
  },
  {
    number: [28],
    class: 'ptc_he',
    column: [3, 4, 2, 3, 4, 5, 1, 2, 5, 6, 6, 7, 7, 8, 8],
    row: [2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 6, 6, 7],
    jap_char: 'ヘ',
  },
  {
    number: [29],
    class: 'ptc_ho',
    column: [
      4, 5, 4, 5, 1, 2, 3, 4, 5, 6, 7, 8, 4, 5, 2, 4, 5, 7, 1, 2, 4, 5, 7, 8, 1,
      4, 5, 8, 4, 5,
    ],
    row: [
      1, 1, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 7,
      7, 7, 7, 8, 8,
    ],
    jap_char: 'ホ',
  },
  {
    number: [30],
    class: 'ptc_ma',
    column: [
      1, 2, 3, 4, 5, 6, 7, 8, 7, 8, 7, 2, 3, 5, 6, 3, 4, 5, 4, 5, 5, 6, 7,
    ],
    row: [2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 4, 5, 5, 5, 5, 6, 6, 6, 7, 7, 8, 8, 8],
    jap_char: 'マ',
  },
  {
    number: [31],
    class: 'ptc_mi',
    column: [2, 3, 3, 4, 5, 6, 6, 7, 3, 4, 4, 5, 6, 2, 2, 3, 4, 5, 5, 6, 7, 8],
    row: [1, 1, 2, 2, 2, 2, 3, 3, 4, 4, 5, 5, 5, 6, 7, 7, 7, 7, 8, 8, 8, 8],
    jap_char: 'ミ',
  },
  {
    number: [32],
    class: 'ptc_mu',
    column: [4, 4, 3, 4, 3, 2, 3, 6, 7, 2, 7, 1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 8],
    row: [1, 2, 3, 3, 4, 5, 5, 5, 5, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8],
    jap_char: 'ム',
  },
  {
    number: [33],
    class: 'ptc_me',
    column: [6, 6, 2, 3, 6, 4, 5, 6, 5, 6, 7, 4, 7, 8, 3, 4, 1, 2, 3],
    row: [1, 2, 3, 3, 3, 4, 4, 4, 5, 5, 5, 6, 6, 6, 7, 7, 8, 8, 8],
    jap_char: 'メ',
  },
  {
    number: [34],
    class: 'ptc_mo',
    column: [
      2, 3, 4, 5, 6, 7, 4, 4, 1, 2, 3, 4, 5, 6, 7, 8, 4, 4, 4, 5, 5, 6, 7, 8,
    ],
    row: [
      1, 1, 1, 1, 1, 1, 2, 3, 4, 4, 4, 4, 4, 4, 4, 4, 5, 6, 7, 7, 8, 8, 8, 8,
    ],
    jap_char: 'モ',
  },
  {
    number: [35],
    class: 'ptc_ya',
    column: [
      1, 1, 2, 8, 2, 3, 5, 6, 7, 8, 2, 3, 4, 5, 7, 8, 1, 2, 3, 4, 7, 4, 5, 5, 5,
      6,
    ],
    row: [
      1, 2, 2, 2, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 6, 6, 7, 8,
      8,
    ],
    jap_char: 'ヤ',
  },
  {
    number: [36],
    class: 'ptc_yu',
    column: [2, 3, 4, 5, 6, 7, 7, 7, 6, 7, 6, 5, 6, 1, 2, 3, 4, 5, 6, 7, 8],
    row: [2, 2, 2, 2, 2, 2, 3, 4, 5, 5, 6, 7, 7, 8, 8, 8, 8, 8, 8, 8, 8],
    jap_char: 'ユ',
  },
  {
    number: [37],
    class: 'ptc_yo',
    column: [
      2, 3, 4, 5, 6, 7, 8, 8, 8, 3, 4, 5, 6, 7, 8, 8, 8, 8, 2, 3, 4, 5, 6, 7, 8,
    ],
    row: [
      1, 1, 1, 1, 1, 1, 1, 2, 3, 4, 4, 4, 4, 4, 4, 5, 6, 7, 8, 8, 8, 8, 8, 8, 8,
    ],
    jap_char: 'ヨ',
  },
  {
    number: [38],
    class: 'ptc_ra',
    column: [
      3, 4, 5, 6, 1, 2, 3, 4, 5, 6, 7, 8, 7, 8, 7, 6, 7, 5, 6, 2, 3, 4, 5,
    ],
    row: [1, 1, 1, 1, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 5, 6, 6, 7, 7, 8, 8, 8, 8],
    jap_char: 'ラ',
  },
  {
    number: [39],
    class: 'ptc_ri',
    column: [3, 6, 3, 6, 3, 6, 3, 6, 5, 6, 4, 5, 3, 4],
    row: [2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8],
    jap_char: 'リ',
  },
  {
    number: [40],
    class: 'ptc_ru',
    column: [5, 3, 5, 3, 5, 3, 5, 3, 5, 2, 3, 5, 8, 1, 2, 5, 7, 8, 1, 5, 6],
    row: [1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 7, 8, 8, 8],
    jap_char: 'ル',
  },
  {
    number: [41],
    class: 'ptc_re',
    column: [3, 3, 3, 3, 3, 8, 3, 7, 8, 3, 4, 5, 6, 7, 3, 4, 5, 6],
    row: [1, 2, 3, 4, 5, 5, 6, 6, 6, 7, 7, 7, 7, 7, 8, 8, 8, 8],
    jap_char: 'レ',
  },
  {
    number: [42],
    class: 'ptc_ro',
    column: [
      1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 7, 8, 1, 2, 7, 8, 1,
      2, 7, 8, 1, 2, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8,
    ],
    row: [
      1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5,
      5, 5, 5, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 8, 8, 8,
    ],
    jap_char: 'ロ',
  },
  {
    number: [43],
    class: 'ptc_wa',
    column: [
      1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 8, 1, 2, 8, 1, 2, 8, 7, 8, 7, 5, 6, 7, 2, 3,
      4, 5,
    ],
    row: [
      1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4, 5, 5, 6, 7, 7, 7, 8, 8,
      8, 8,
    ],
    jap_char: 'ワ',
  },
  {
    number: [44],
    class: 'ptc_wi',
    column: [6, 6, 2, 3, 4, 5, 6, 7, 3, 6, 3, 6, 1, 2, 3, 4, 5, 6, 7, 8, 6, 6],
    row: [1, 2, 3, 3, 3, 3, 3, 3, 4, 4, 5, 5, 6, 6, 6, 6, 6, 6, 6, 6, 7, 8],
    jap_char: 'ヰ',
  },
  {
    number: [45],
    class: 'ptc_we',
    column: [
      2, 3, 4, 5, 6, 7, 8, 8, 5, 7, 8, 5, 6, 7, 5, 5, 1, 2, 3, 4, 5, 6, 7, 8,
    ],
    row: [
      1, 1, 1, 1, 1, 1, 1, 2, 3, 3, 3, 4, 4, 4, 5, 6, 7, 7, 7, 7, 7, 7, 7, 7,
    ],
    jap_char: 'ヱ',
  },
  {
    number: [46],
    class: 'ptc_wo',
    column: [
      1, 2, 3, 4, 5, 6, 7, 8, 8, 2, 3, 4, 5, 6, 7, 8, 7, 6, 7, 5, 6, 4, 5, 2, 3,
      4,
    ],
    row: [
      1, 1, 1, 1, 1, 1, 1, 1, 2, 3, 3, 3, 3, 3, 3, 3, 4, 5, 5, 6, 6, 7, 7, 8, 8,
      8,
    ],
    jap_char: 'ヲ',
  },
  {
    number: [47],
    class: 'ptc_nn',
    column: [8, 1, 2, 3, 8, 3, 4, 5, 8, 8, 7, 8, 4, 5, 6, 7, 1, 2, 3, 4, 5],
    row: [2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 6, 6, 7, 7, 7, 7, 8, 8, 8, 8, 8],
    jap_char: 'ン',
  },
  {
    number: [48],
    class: 'ptc_long',
    column: [8, 1, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8],
    row: [3, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5],
    jap_char: 'ー',
  },
  {
    number: [49],
    class: 'ptc_m_a',
    column: [4, 5, 6, 7, 8, 6, 8, 6, 7, 8, 5, 6, 4, 5],
    row: [4, 4, 4, 4, 4, 5, 5, 6, 6, 6, 7, 7, 8, 8],
    jap_char: 'ァ',
  },
  {
    number: [50],
    class: 'ptc_m_i',
    column: [7, 8, 6, 7, 5, 6, 7, 4, 5, 7, 7],
    row: [4, 4, 5, 5, 6, 6, 6, 7, 7, 7, 8],
    jap_char: 'ィ',
  },
  {
    number: [51],
    class: 'ptc_m_u',
    column: [6, 4, 5, 6, 7, 8, 4, 7, 8, 6, 7, 5, 6],
    row: [4, 5, 5, 5, 5, 5, 6, 6, 6, 7, 7, 8, 8],
    jap_char: 'ゥ',
  },
  {
    number: [52],
    class: 'ptc_m_e',
    column: [4, 5, 6, 7, 8, 6, 6, 4, 5, 6, 7, 8],
    row: [5, 5, 5, 5, 5, 6, 7, 8, 8, 8, 8, 8],
    jap_char: 'ェ',
  },
  {
    number: [53],
    class: 'ptc_m_o',
    column: [7, 4, 5, 6, 7, 8, 5, 6, 7, 5, 7, 4, 5, 7],
    row: [4, 5, 5, 5, 5, 5, 6, 6, 6, 7, 7, 8, 8, 8],
    jap_char: 'ォ',
  },
  {
    number: [54],
    class: 'ptc_m_tu',
    column: [4, 6, 8, 4, 6, 8, 8, 7],
    row: [5, 5, 5, 6, 6, 6, 7, 8],
    jap_char: 'ッ',
  },
  {
    number: [55],
    class: 'ptc_m_ya',
    column: [5, 4, 5, 6, 7, 8, 5, 8, 5, 7, 5],
    row: [4, 5, 5, 5, 5, 5, 6, 6, 7, 7, 8],
    jap_char: 'ャ',
  },
  {
    number: [56],
    class: 'ptc_m_yu',
    column: [4, 5, 6, 7, 7, 7, 4, 5, 6, 7, 8],
    row: [5, 5, 5, 5, 6, 7, 8, 8, 8, 8, 8],
    jap_char: 'ュ',
  },
  {
    number: [57],
    class: 'ptc_m_yo',
    column: [5, 6, 7, 8, 8, 5, 6, 7, 8, 8, 5, 6, 7, 8],
    row: [4, 4, 4, 4, 5, 6, 6, 6, 6, 7, 8, 8, 8, 8],
    jap_char: 'ョ',
  },
  {
    number: [58],
    class: 'ptc_bu',
    column: [7, 6, 8, 1, 2, 3, 4, 5, 7, 5, 5, 4, 5, 3, 4, 1, 2, 3],
    row: [1, 2, 2, 3, 3, 3, 3, 3, 3, 4, 5, 6, 6, 7, 7, 8, 8, 8],
    jap_char: 'ブ',
  },
];

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
