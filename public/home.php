        <main class="main">
            <section class="home">
                <div class="bg">
                    <video autoplay loop muted>
                        <? /* <source src="/public/bg.mp4" type="video/mp4" /> */ ?>
                    </video>
                </div>
                <div class="home__container _container">
                    <div class="home__body">
                        <div class="home__top-content">
                            <div class="home__top-text">
                                <h1 class="home__heading"><?=$arrLang['head1']?>.</h1>
                                <p class="home__subtitle">
                                    <?=$arrLang['text1']?>
                                </p>
                            </div>
                            <div class="home__community-wrapper">
                                <div class="home__community">
                                    <p class="home__community-name"><?=$arrLang['community']?>:</p>
                                    <a href="#" class="home__tg _social-link">Telegram</a>
                                    <a href="#" class="home__dem _social-link">DEM</a>
                                </div>
                            </div>
                        </div>

                        <div class="advant">
                            <div class="advant__row">
                                <ul class="advant__list">
                                    <li class="advant__item">
                                        <div class="advant__item-top">
                                            <img src="/public/img/platform/advant-1.svg" alt="" class=""/>
                                            <p class="advant__item-price">0.6432</p>
                                        </div>
                                        <div class="advant__item-bot"><?=$arrLang['block1']?></div>
                                    </li>
                      <li class="advant__item">
                        <div class="advant__item-top">
                          <img
                            src="/public/img/platform/advant-2.svg"
                            alt=""
                            class=""
                          />
                          <p class="advant__item-price">$56.88M</p>
                        </div>
                        <div class="advant__item-bot">
                          <?=$arrLang['block2']?> <?if($_SESSION[language]=="en") {?>(87.44M supply)<?}?>
                        </div>
                      </li>
                      <li class="advant__item">
                        <div class="advant__item-top">
                          <img
                            src="/public/img/platform/advant-3.svg"
                            alt=""
                            class=""
                          />
                          <p class="advant__item-price">$44.7M</p>
                        </div>
                        <div class="advant__item-bot"><?=$arrLang['block4']?></div>
                      </li>
                      <li class="advant__item">
                        <div class="advant__item-top">
                          <img
                            src="/public/img/platform/advant-4.svg"
                            alt=""
                            class=""
                          />
                          <p class="advant__item-price">$16.28M</p>
                        </div>
                        <div class="advant__item-bot">
                          <?=$arrLang['block5']?>
                        </div>
                      </li>
                    </ul>
                    
                    <span id="OpenForm" class="advant__apply">
                        <span><?=$arrLang['applyido']?></span>
                        <img src="/public/img/platform/apply-btn.svg" alt=""/>
                    </span>
                
                    <div id="Apply" class="modal">
                        <div class="modal-content">
                            <span class="exit">&times;</span>
                            <form method="post" id="applyform" class="applyform" action="" style="display: contents;">
                                <div class="notif__input-block">
                                    <input type="text" class="outline-none bg-black border-1 p-2 pl-10 text-white text-sm sm:w-auto w-full border-[#CD3ED0] rounded-lg" name="nameapply" placeholder="<?=$arrLang['entname']?>"/>
                                </div>
                                <div class="notif__input-block">
                                    <input type="text" class="outline-none bg-black border-1 p-2 pl-10 text-white text-sm sm:w-auto w-full border-[#CD3ED0] rounded-lg" name="phoneapply" placeholder="<?=$arrLang['entphone']?>"/>
                                </div>
                                <div class="notif__input-block">
                                    <input type="text" class="outline-none bg-black border-1 p-2 pl-10 text-white text-sm sm:w-auto w-full border-[#CD3ED0] rounded-lg" name="emailapply" placeholder="<?=$arrLang['entemail']?>"/>
                                </div>
                                <div class="notif__input-block">
                                    <textarea class="outline-none bg-black border-1 p-2 pl-10 text-white text-sm sm:w-auto w-full border-[#CD3ED0] rounded-lg" name="descripapply" placeholder="<?=$arrLang['entdescr']?>"/></textarea>
                                </div>
                                <div class="notif__button">
                                    <button id="applysend" class="notif__btn btn-primary"><?=$arrLang['send']?></button>
                                </div>
                            </form>
                            <div id="result_formapply"></div>
                        </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="platform">
            <div class="platform__container _container">
              <h2 class="platform__title"><?=$arrLang['head2']?></h2>
              <ul class="platform__list">
                <li class="platform__item">
                  <p href="#" class="platform__link">
                    <img src="/public/img/platform/ethereum.svg" alt="" />
                  </p>
                  <p class="platform__name">Ethereum</p>
                  <img
                    src="/public/img/svg/rm-1.svg"
                    class="wow animate__animated snake-animation platform__image"
                    alt=""
                  />
                  <p></p>
                </li>
                <li class="platform__item">
                  <p href="#" class="platform__link">
                    <img src="/public/img/platform/solana-sol-logo 1.svg" alt="" />
                  </p>
                  <p class="platform__name">Solana</p>
                  <img
                    src="/public/img/svg/rm-2.svg"
                    class="wow animate__animated snake-animation platform__image"
                    alt=""
                  />
                </li>
                <li class="platform__item">
                  <p class="platform__link">
                    <img src="/public/img/platform/polygon.svg" alt="" />
                  </p>
                  <p class="platform__name">Polygon</p>
                  <img
                    src="/public/img/svg/rm-3.svg"
                    class="wow animate__animated snake-animation platform__image"
                    alt=""
                  />
                  <p></p>
                </li>
                <li class="platform__item">
                  <p class="platform__link">
                    <img src="/public/img/platform/binance.svg" alt="" />
                  </p>
                  <p class="platform__name">Binance</p>
                  <img
                    src="/public/img/svg/rm-5.svg"
                    class="wow animate__animated snake-animation platform__image"
                    alt=""
                  />
                  <p></p>
                </li>
              </ul>
              <div class="platform__info">
                <h4 class="platform__heading">
                  <?=$arrLang['head3']?>
                </h4>
                <p class="platform__descr home__subtitle">
                  <?=$arrLang['text3']?>
                </p>
              </div>
            </div>
          </section>
            <section class="roadmap">
                <div class="roadmap__container">
                    <h3 class="roadmap__title platform__title"><?=$arrLang['roadmap']?></h3>
                    <div class="roadmap__lists">
                        <ul>
                            <li>
                                <div class="text">
                                    <ul class="roadmap__list">
                                        <li class="roadmap__item">
                                            <img src="/public/img/svg/check-sign.svg" alt="check-sign">
                                            <p class="roadmap__link checked">IDO Platform Launch</p>
                                        </li>
                                        <li class="roadmap__item">
                                            <img src="/public/img/svg/check-sign.svg" alt="check-sign">
                                            <p class="roadmap__link checked">Airdrop Lottery</p>
                                        </li>
                                        <li class="roadmap__item">
                                            <img src="/public/img/svg/check-sign.svg" alt="check-sign">
                                            <p class="roadmap__link checked">KYC and Tiers System</p>
                                        </li>
                                        <li class="roadmap__item">
                                            <img src="/public/img/svg/checked.svg" alt="">
                                            <p class="roadmap__link">Stacking Pools on Platform</p>
                                        </li>
                                        <li class="roadmap__item">
                                            <img src="/public/img/svg/checked.svg" alt="">
                                            <p class="roadmap__link">Placement of the first project IDO</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="btn p-0"><div class="roadmap__bar active-bar"><div class="roadmap__progress wow animate__animated progress-animation"><span>Q1 2022</span>&gt;<span class="shape"><div class="roadmap__bar-pulse wow animate__animatedd progress-pulse-animation"><img src="/public/img/svg/loading.svg" class="progress-image pulse" alt=""></div></span></div></div></div></li><li><div class="btn"><div class="roadmap__bar"><span> Q2 2022 </span></div></div><div class="text"><ul class="roadmap__list-row"><li class="roadmap__list-row-item"><img src="/public/img/svg/checked.svg" alt=""><p class="roadmap__list-row-link">NFT Marketplace</p></li><li class="roadmap__list-row-item"><img src="/public/img/svg/checked.svg" alt=""><p class="roadmap__list-row-link">Seed and Private round</p></li><li class="roadmap__list-row-item _huge-line"><img src="/public/img/svg/checked.svg" alt=""><p class="roadmap__list-row-link">Formation of pools by Investors in the personal account, whixh will allow participants to enter more expensive Tiers, by joint efforts</p></li></ul></div></li><li><div class="text"><ul class="roadmap__list"><li class="roadmap__item"><img src="/public/img/svg/checked.svg" alt=""><p class="roadmap__link">Dex Exchange</p></li><li class="roadmap__item"><img src="/public/img/svg/checked.svg" alt=""><p class="roadmap__link">Smart Contract</p></li></ul></div><div class="btn"><div class="roadmap__bar"><span> Q3 2022 </span></div></div></li><li><div class="btn"><div class="roadmap__bar"><span> Q4 2022 </span></div></div><div class="text"><ul class="roadmap__bottom-list-second"><li class="roadmap__bottom-list-second-item _huge-line"><img src="/public/img/svg/checked.svg" alt=""><p class="roadmap__bottom-list-link">Placement of the first project on LaunchPad developed on ArteryChain</p></li></ul></div></li></ul></div></div></section>
          <section class="notif">
            <div class="notif__container _container">
              <div class="notif__body">
                <h5 class="notif__title"><?=$arrLang['notified']?></h5>
                <div class="notif__row">
                    <form method="post" id="subscribe" class="subscribe" action="" style="display: contents;">
                        <div class="notif__input-block">
                            <input type="text" class="notif__input" name="email" placeholder="<?=$arrLang['entemail']?>"/>
                        </div>
                        <div class="notif__button">
                            <button id="subscr" class="notif__btn btn-primary"><?=$arrLang['subscribe']?></button>
                        </div>
                    </form>
                    <div id="result_form" class="result_form"></div> 
                </div>
              </div>
            </div>
          </section>
        </main>
        
    <script>
        $( document ).ready(function() {
            $("#subscr").click(
        		function(){
        			sendAjaxForm('result_form', 'subscribe', '/public/sendform.php?form=1', '1');
        			return false; 
        		}
        	);
        });
        
        $( document ).ready(function() {
            $("#applysend").click(
        		function(){
        			sendApplyForm('result_formapply', 'applyform', '/public/sendform.php?form=2');
        			return false; 
        		}
        	);
        });
        
        // Получить модальный
        var apply = document.getElementById("Apply");
        
        // Получить кнопку, которая открывает модальный
        var open = document.getElementById("OpenForm");
        
        // Получить элемент <span>, который закрывает модальный
        var exit = document.getElementsByClassName("exit")[0];
        
        // Когда пользователь нажимает на кнопку, откройте модальный
        open.onclick = function() {
          apply.style.display = "block";
        }
        
        // Когда пользователь нажимает на <span> (x), закройте модальное окно
        exit.onclick = function() {
          apply.style.display = "none";
        }
        
        // Когда пользователь щелкает в любом месте за пределами модального, закройте его
        window.onclick = function(event) {
          if (event.target == apply) {
            apply.style.display = "none";
          }
        }
         
        function sendAjaxForm(result_form, subscribe, url) {
            $.ajax({
                url:     url,
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#"+subscribe).serialize(),  // Сеарилизуем объект
                success: function(response) { //Данные отправлены успешно
                	$('#result_form').html(response);
                	$('#subscribe').hide();
            	},
            	error: function(response) { // Данные не отправлены
                    $('#result_form').html('Ошибка. Данные не отправлены.');
            	}  
         	});
        }
         
        function sendApplyForm(result_formapply, applyform, url) {
            $.ajax({
                url:     url,
                type:     "POST", //метод отправки
                dataType: "html", //формат данных
                data: $("#"+applyform).serialize(),  // Сеарилизуем объект
                success: function(applyres) { //Данные отправлены успешно
                	$('#result_formapply').html(applyres);
                	$('#applyform').hide();
            	},
            	error: function(applyres) { // Данные не отправлены
                    $('#result_formapply').html('Ошибка. Данные не отправлены.');
            	}  
         	});
        }
    </script>