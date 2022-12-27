<script>
    window.addEventListener('DOMContentLoaded', () => {
        let onestake;
        holder = String('<?=$user['wallet']?>');
        stakeARTR().then(result => {
            alert(result);
            $.ajax({
                url: '/public/js/funcjs.php',
                type: 'POST',
                data: {
                    func: '4',
                    stake: onestake,
                    holder: holder
                },
                success: function(sql){
                    console.log(sql);
                }
            })
        });
        
    });
    window.onload = function () {
        var re = document.getElementById('re');
        var re2 = document.getElementById('re2');
        var rep1 = document.getElementById('replace1');
        var rep2 = document.getElementById('replace2');
        var rep3 = document.getElementById('replace3');
        var rep4 = document.getElementById('replace4');
        
        re.onclick = function() {
            tmp = rep1.innerHTML;
            rep1.innerHTML = rep2.innerHTML;
            rep2.innerHTML = tmp;
            tmp2 = rep3.innerHTML;
            rep3.innerHTML = rep4.innerHTML;
            rep4.innerHTML = tmp2;
        }
        re2.onclick = function() {
            tmp = rep1.innerHTML;
            rep1.innerHTML = rep2.innerHTML;
            rep2.innerHTML = tmp;
            tmp2 = rep3.innerHTML;
            rep3.innerHTML = rep4.innerHTML;
            rep4.innerHTML = tmp2;
        }
    }
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<div class="w-full flex row px-16 swap">
    <div class="col-xl-4 col-lg-4 col-md-4 col-min">
        <div class="w-full pr-8">
            <div class="w-full border border-[#6B1495] rounded-3xl">
                <div class="text-center p-6 border-b border-[#6B1495]">
                    <p class="text-3xl font-semibold text-[#CD3ED0]"><?=$arrLang['swap']?></p>
                    <p><?=$arrLang['trade']?></p>
                </div>
                <div class="px-8 pt-8">
                    <div id="replace1">
                        <div>
                            <img src="/images/artery.png" alt="" class="inline-block artery24">
                            <span class="text-white font-semibold">ARTR</span>
                        </div>
                        <input type="text" class="bg-transparent cursor-pointer w-full border border-[#6B1495] rounded-3xl p-8 outline-none mt-2 text-center" value="0.0">
                    </div>
                    <div class="w-full flex justify-end mt-4 -mb-4">
                        <button id="re">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAZCAYAAADe1WXtAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAEjSURBVHgB1dRNUsIwFAfw91JkzRG6diFtHXcOU04inkCv4AnUE6gnIeiMKxWc8QB4Aw9A3vOFb2iAJsCi/0WbpukvmaQJgiP9vB8bg/dRxNepTv/AM+gCibArxZgBBpHiti+Mm8BZXQiM28BQGHeBIXDNXojUFSDrJaEzLQ2lWz3r3dh2AI+7UHRVfrYGPH4pYNZL2uAZBUfIUdAaBOTr8qcJSA1bzt7OegdBCUcPMt/59LGwLtWZ04qvPsl2tHfZAd7H3kb0Qqca9kh15hTLNPpofd8AczL/aPLjx7bMDM+LehyevzbvSu2oSNGLIezICJLCqHBxTOLoJC89Uhs5yBsCd13wBKzn2fvprxe6BV4BvVEHXACD0Dls8EmZ+u06aPMPH1WA1/jc1owAAAAASUVORK5CYII=" alt="">
                        </button>
                    </div>
                    <div id="replace2">
                        <div>
                            <img src="/public/img/svg/binance.svg" alt="" class="inline-block artery24">
                            <span class="text-white font-semibold">wARTR</span>
                        </div>
                        <input type="text" class="bg-transparent cursor-pointer w-full border border-[#6B1495] rounded-3xl p-8 outline-none mt-2 text-center" value="0.0">
                    </div>
                    <div class="text-center py-6">
                        <p class="text-md text-[#CD3ED0] font-semibold"><?=$arrLang['slippage']?></p>
                        <p class="text-white text-4xl mt-3 font-bold">0.5%</p>
                    </div>
                </div>
                <div class="px-8 w-full pb-8 border-[#6B1495]">
                    <button id="OpenQR" class="py-4 text-lg w-full rounded-2xl" style="background-image: linear-gradient(90deg, rgb(205, 62, 208) 14.1%, rgb(107, 20, 149) 144.51%);"><?=$arrLang['swap']?></button>
                    <div id="QR" class="modal">
                        <div class="modal-content">
                            <span class="exit">&times;</span>
                            Здесь будет QR код
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-min">
        <div class="w-full pl-8">
            <div class="w-full flex panel justify-between mb-3">
                <div class="flex items-center">
                    <div class="flex items-center" id="replace3">
                        <div>
                            <img src="/images/artery.png" alt="" class="ml-1.5 artery24">
                        </div>
                        <div>
                            <img src="/public/img/svg/binance.svg" alt="" class="ml-1.5 artery24">
                        </div>
                        <p class="text-md font-semibold text-white mx-3 w-auto">ARTR/wARTR</p>
                    </div>
                    <div class="flex items-center" id="replace4" style="display:none">
                        <div>
                            <img src="/public/img/svg/binance.svg" alt="" class="ml-1.5 artery24">
                        </div>
                        <div>
                            <img src="/images/artery.png" alt="" class="ml-1.5 artery24">
                        </div>
                        <p class="text-md font-semibold text-white mx-3 w-auto">wARTR/ARTR</p>
                    </div>
                    <button id="re2">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAZCAYAAADe1WXtAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAEjSURBVHgB1dRNUsIwFAfw91JkzRG6diFtHXcOU04inkCv4AnUE6gnIeiMKxWc8QB4Aw9A3vOFb2iAJsCi/0WbpukvmaQJgiP9vB8bg/dRxNepTv/AM+gCibArxZgBBpHiti+Mm8BZXQiM28BQGHeBIXDNXojUFSDrJaEzLQ2lWz3r3dh2AI+7UHRVfrYGPH4pYNZL2uAZBUfIUdAaBOTr8qcJSA1bzt7OegdBCUcPMt/59LGwLtWZ04qvPsl2tHfZAd7H3kb0Qqca9kh15hTLNPpofd8AczL/aPLjx7bMDM+LehyevzbvSu2oSNGLIezICJLCqHBxTOLoJC89Uhs5yBsCd13wBKzn2fvprxe6BV4BvVEHXACD0Dls8EmZ+u06aPMPH1WA1/jc1owAAAAASUVORK5CYII=" alt="" class="rotate-90">
                    </button>
                </div>
                <div class="timeframe border border-[#6B1495] rounded-3xl px-4 py-0.5 font-semibold text-[15px]">
                    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0] active" onclick="hour()">1H</button>
                    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0]" onclick="day()">1D</button>
                    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0]" onclick="week()">1W</button>
                    <button class="outline-none bg-transparent mx-2 hover:text-[#CD3ED0] focus:text-[#CD3ED0]" onclick="month()">1M</button>
                </div>
            </div>
            <div class="w-full border border-[#6B1495] rounded-3xl px-8 chart">
                <p class="text-right text-sm text-[#6B1495] mt-1.5"><?=date('d-m-Y H:i')?></p>
                <div class="w-full flex items-center justify-between">
                    <?
                        $currency = $artpad -> query("SELECT value FROM `charts` WHERE `id`='43'");
                        $currency =$currency->fetch_assoc();
                        $currency = $currency['value'];
                    ?>
                    <p class="text-3xl text-white font-bold"><?=$currency?> ARTR/USDT</p>
                    <p class="text-transparent">ARTR/wARTR</p>
                </div>
                
                <div>
                    <div id="hour">
                        <? include "charthour.php";?>
                    </div>
                    <div id="day" style="display: none">
                        <? include "chartday.php";?>
                    </div>
                    <div id="week" style="display: none">
                        <? include "chartweek.php";?>
                    </div>
                    <div id="month" style="display: none">
                        <? include "chartmonth.php";?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            

<script>
    // Получить модальный
    var apply = document.getElementById("QR");
    
    // Получить кнопку, которая открывает модальный
    var open = document.getElementById("OpenQR");
    
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
    
    const list = document.querySelectorAll('.timeframe button')
     list.forEach(item =>{ 
            item.addEventListener('click', (e) =>{
            list.forEach(el=>{ el.classList.remove('active'); });
            item.classList.add('active')
        })
    })
    
    function hour() {
        document.getElementById('hour').style.display='block';
        document.getElementById('day').style.display='none';
        document.getElementById('week').style.display='none';
        document.getElementById('month').style.display='none';
    }
    function day() {
        document.getElementById('hour').style.display='none';
        document.getElementById('day').style.display='block';
        document.getElementById('week').style.display='none';
        document.getElementById('month').style.display='none';
    }
    function week() {
        document.getElementById('hour').style.display='none';
        document.getElementById('day').style.display='none';
        document.getElementById('week').style.display='block';
        document.getElementById('month').style.display='none';
    }
    function month() {
        document.getElementById('hour').style.display='none';
        document.getElementById('day').style.display='none';
        document.getElementById('week').style.display='none';
        document.getElementById('month').style.display='block';
    }
</script>