<?php
    $user_data = UserLogic::levelModal();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cherry Blossom DEMO</title>
  <link rel="stylesheet" type="text/css" href="level_anime.css">
  <link rel="stylesheet" type="text/css" href="../2.css" />

  <link rel="stylesheet" href="ClickEffects-master/css/component.css"><!-- CSS読み込み -->
  <script src="ClickEffects-master\js/classie.js"></script>
  <script src="ClickEffects-master\js/modernizr.custom.js"></script>
</head>
<body>
  <div class="cherry-blossom-container">
    <!-- レベルによる表示画像変更 -->
    <img id="hero" class="col-4 d-block mx-auto" style="width: 100px; padding-left:27px; height: auto" src="../../level/img/22338667.png" alt="ないよ">
    <div id="lv" class="col-4 d-block mx-auto">Lv.<span id="level"><?php echo $login_user['pre_level']; ?></span>
      <!-- <span id="level"><?php// echo $user_data('pre_level') ?></span> -->
    </div>
      <progress class=" d-block mx-auto" id="lifeBar" value="0" max="100" min="0" optimum="100"></progress>
      <div class="col-4 d-block  element js-animation" id="ohome_word">Congratulation!</div>
    <div id="bg"></div>
  </div>
  
  
  <script type="text/javascript">
    // 前回マイページ参照時からレベルが上がった分だけ処理を繰り返し
    
    let previousLevel = <?php echo $login_user['pre_level'] ?>;
    let currentLevel = <?php echo $login_user['level'] ?>;
    let previousExp = <?php echo $login_user['pre_exp'] ?>;
    let currentExp = <?php echo $login_user['exp'] ?>;
    
    let lifeBar.value = previousExp
    let exExp = currentExp % 100;
    
    // let previousLevel = 1;
    // let currentLevel = 3;
    // lifeBar.value = 0;
    // let exExp = 70;
    
    function update() {
      gameTimer = setTimeout(update, 4);
      let heroImg = document.getElementById('hero');
      let lifeBar = document.getElementById('lifeBar');
      let level = document.getElementById('level'); 
      let bg = document.getElementById('bg'); 
      lifeBar.value++;
    
      
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
          document.getElementById("hero").src='../../level/img/22503431.png';
          // document.getElementById("hero").classList.add("cbutton--effect-stana");
        } 
        if(level.innerHTML >= 10){
          document.getElementById("hero").src='../../level/img/22350820.png';
        }
        if (level.innerHTML >= 20){
          document.getElementById("hero").src='../../level/img/22493175.png';
        }
      }
        //規定レベルに達したらループ終了
        if(level.innerHTML >= currentLevel && lifeBar.value >= exExp){
          clearTimeout(gameTimer);        
          document.getElementById("ohome_word").classList.add("is-show");
          
          if(previousLevel != currentLevel){
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
    }    

    window.onload = update();


</script>
</body>



