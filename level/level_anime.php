<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cherry Blossom DEMO</title>
  <link rel="stylesheet" href="level_anime.css"><!-- CSS読み込み -->
  <link rel="stylesheet" href="ClickEffects-master/css/component.css"><!-- CSS読み込み -->
  <script src="ClickEffects-master\js/classie.js"></script>
  <script src="ClickEffects-master\js/modernizr.custom.js"></script>
</head>
<body>
  <div class="cherry-blossom-container">
    <!-- レベルによる表示画像変更 -->
    <img id="hero" style="width: 30%;" src="img/22338667.png" alt="ないよ">
    <progress id="lifeBar" value="0" max="100" min="0" optimum="100"></progress>
    <div id="lv">Lv.
      <div id="level">1</div>
      <!-- <div id="level"><?php// echo $user_data('pre_level') ?></div> -->
      <div id="bg"></div>
    </div>
    <div id="ohome_word"></div>
  </div>
  
  
  <script type="text/javascript">
    // 前回マイページ参照時からレベルが上がった分だけ処理を繰り返し
    
    // let previousLevel = <?php //echo $user_data('pre_level') ?>;
    // let currentLevel = <?php //echo $user_data('level') ?>;
    // let previousExp = <?php //echo $user_data('pre_exp') ?>;
    // let currentExp = <?php //echo $user_data('exp') ?>;
    
    // let lifeBar.value = previousExp
    // let exExp = currentExp % 100;
    
    let currentLevel = 5;
    lifeBar.value = 50;
    let exExp = 20;
    
    function update() {
      gameTimer = setTimeout(update, 4);
      let heroImg = document.getElementById('hero');
      let lifeBar = document.getElementById('lifeBar');
      let level = document.getElementById('level'); 
    let bg = document.getElementById('bg'); 
    let ohome = document.getElementById('ohome_word'); 
    lifeBar.value++;
    
    console.log(exExp);
    
    // レベルアップ時のエフェクトを消去
    if(lifeBar.value == 95){
      document.getElementById("bg").classList.remove("before");
    }
    // 経験値が100になったら、レベルが上がる
    if(lifeBar.value >= lifeBar.max){
      lifeBar.value = 0;
      // レベルアップ時エフェクト起動(この後ループされ、上で消去される)
      document.getElementById("bg").classList.add("before");
      level.innerHTML++;
      // document.getElementById("level").classList.add("s-fs-l");
      
      
      // 一定レベルを超えたら表示画像が変更される
      if(level.innerHTML >= 5){
        document.getElementById("hero").src='img/22503431.png';
        // document.getElementById("hero").classList.add("cbutton--effect-stana");
      } 
      if(level.innerHTML >= 10){
        document.getElementById("hero").src='img/22350820.png';
      }
      if (level.innerHTML >= 20){
        document.getElementById("hero").src='img/22493175.png';
      }
    }
      //規定レベルに達したらループ終了
      if(level.innerHTML >= currentLevel && lifeBar.value >= exExp){
        clearTimeout(gameTimer);        
        console.log(currentLevel);
          // コンテナを指定
          const section = document.querySelector('.cherry-blossom-container');
          // 花びらを生成する関数
          const createPetal = () => {
            const petalEl = document.createElement('span');
            petalEl.className = 'petal';
            const minSize = 10;
            const maxSize = 15;
            const size = Math.random() * (maxSize + 1 - minSize) + minSize;
            petalEl.style.width = `${size}px`;
            petalEl.style.height = `${size}px`;
            petalEl.style.left = Math.random() * innerWidth + 'px';
            section.appendChild(petalEl);

            // 一定時間が経てば花びらを消す
            setTimeout(() => {
              petalEl.remove();
            }, 10000);
          }
        // 花びらを生成する間隔をミリ秒で指定
        setInterval(createPetal, 300);
      }
    }    

    window.onload = update();


</script>
</body>



