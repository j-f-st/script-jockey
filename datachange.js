const win = window;
const d = document;

win.addEventListener('load', (e) => {
  randomizeBackgroundView();
});

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
