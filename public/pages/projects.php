<div class="xl:px-40 lg:px-28 md:px-16 px-12">
    
    <div class="flex flex-col lg:flex-row items-center">
        <div class="filter text-white text-xs xl:text-sm md:w-auto w-full">
            <?
                $qall = $artpad -> query("SELECT * FROM `projects`")->num_rows;
                $qup = $artpad -> query("SELECT * FROM `projects` WHERE `project_status` = 'upcoming'")->num_rows;
                $qact = $artpad -> query("SELECT * FROM `projects` WHERE `project_status` = 'active'")->num_rows;
                $qend = $artpad -> query("SELECT * FROM `projects` WHERE `project_status` = 'ended'")->num_rows;
                $vest = $artpad -> query("SELECT * FROM `projects` WHERE `project_status` = 'vesting'")->num_rows;
            ?>
                <button id="all" class="outline-none bg-auto border-2 border-[#CD3ED0] rounded-lg py-2 px-6 mr-2 sm:mt-2 min-w-max"><?=$arrLang['prall']?> [<?=$qall?>]</button>
                <button id="upcoming" class="outline-none bg-auto border-2 border-[#CD3ED0] rounded-lg py-2 px-6 mx-2 sm:mt-2 min-w-max"><?=$arrLang['prupcoming']?> [<?=$qup?>]</button>
                <button id="active" class="outline-none bg-auto border-2 border-[#CD3ED0] rounded-lg py-2 px-6 ml-2 mr-4 sm:mt-2 min-w-max"><?=$arrLang['practive']?> [<?=$qact?>]</button>
                <button id="ended" class="outline-none bg-auto border-2 border-[#CD3ED0] rounded-lg py-2 px-6 ml-2 mr-4 sm:mt-2 min-w-max"><?=$arrLang['prended']?> [<?=$qend?>]</button>
                <button id="vesting" class="outline-none bg-auto border-2 border-[#CD3ED0] rounded-lg py-2 px-6 ml-2 mr-4 sm:mt-2 min-w-max"><?=$arrLang['prvesting']?> [<?=$vest?>]</button>
        </div>
        <div class="grow"></div>
        <div class="lg:order-last lg:mt-2.5 sm:w-auto w-full">
            <div class="absolute my-1.5 mx-2">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.2667 1.73334C6.00166 1.73334 1.73333 6.00167 1.73333 11.2667C1.73333 16.5317 6.00166 20.8 11.2667 20.8C16.5317 20.8 20.8 16.5317 20.8 11.2667C20.8 6.00167 16.5317 1.73334 11.2667 1.73334ZM11.2667 17.3333C7.91613 17.3333 5.2 14.6172 5.2 11.2667C5.2 7.91614 7.91613 5.2 11.2667 5.2C14.6172 5.2 17.3333 7.91614 17.3333 11.2667C17.3333 14.6172 14.6172 17.3333 11.2667 17.3333Z" fill="white" fill-opacity="0.5"></path><path d="M24.1926 21.7412L20.3636 17.9118C19.6772 18.8496 18.85 19.6768 17.9123 20.3632L21.7412 24.1921C22.0549 24.5063 22.4883 24.7 22.9667 24.7C23.9239 24.7 24.7 23.9239 24.7 22.9667C24.7 22.4883 24.5059 22.0549 24.1926 21.7412Z" fill="white" fill-opacity="0.5"></path></svg>
            </div>
            <input id="search" type="text" class="search outline-none bg-black border-2 p-2 pl-10 text-white text-sm sm:w-auto w-full border-[#CD3ED0] rounded-lg" placeholder="<?=$arrLang['searchpools']?>">
        </div>
    </div>
    
    <div id="firstscr">
        <p class="text-white md:text-4xl text-3xl font-bold my-10"><?=$arrLang['allidos']?></p>
        <div>
            <?
                $qprojects ="SELECT * FROM `projects`";
                $rprojects = $artpad -> query($qprojects);
                while ($rproject = $rprojects->fetch_assoc()) {
            ?>
                <a href="/projects/<?=$rproject['project_name']?>">
                    <div class="xl:w-1/3 sm:w-1/2 w-full inline-block">
                        <div class="max-w-max border border-2 border-[#CD3ED0] my-4 rounded-md lg:mx-6 sm:mx-2 mx-0">
                            <div class="relative">
                                <div class="absolute flex justify-between items-center w-full h-full px-4">
                                    <div class="text-white 2xl:text-4xl lg:text-3xl md:text-2xl text-3xl">
                                        <p class="font-bold mb-2"><?=$rproject['project_title']?></p>
                                        <p class="font-semibold mt-2">$<?=$rproject['project_token_small']?></p>
                                    </div>
                                    <div class="text-white">
                                        <img src="<?=$rproject['project_logo']?>" class="platform__image" alt="">
                                    </div>
                                </div>
                                <img src="/public/img/ProjectsCardImg.png" alt="" class="w-full rounded-t-md">
                            </div>
                            <div class="px-3 w-full">
                                <div class="text-white bg-gray-600 rounded-2xl max-w-max text-sm px-2 py-1 my-2.5">
                                    <p style="text-transform: uppercase;"><?=$rproject['project_status']?></p>
                                </div>
                                <p class="text-white text-sm projectdescr"><?=$rproject['project_content']?></p>
                                <div class="my-8">
                                    <div class="flex justify-between items-center">
                                        <p class="text-white 2xl:text-2xl md:text-xl text-lg"><?=$arrLang['totalraise']?></p>
                                        <p class="2xl:text-3xl lg:text-2xl md:text-xl text-xl text-[#CD3ED0] overflow-ellipsis break-normal"><?=$rproject['project_initial_supply']?></p>
                                    </div>
                                    <div class="flex justify-between items-center my-3">
                                        <p class="text-white text-xl"><?=$arrLang['starts']?></p>
                                        <p class="2xl:text-2xl md:text-xl text-lg text-[#CD3ED0] overflow-ellipsis break-normal">Jul 4, 11:00 UTC</p>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-white text-xl"><?=$arrLang['price']?></p>
                                        <p class="2xl:text-2xl md:text-xl text-lg text-[#CD3ED0] overflow-ellipsis break-normal text-right`">1 <?=$rproject['project_token_small']?> = <?=$rproject['project_price_ido']?></p>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-white 2xl:text-base text-sm"><?=$arrLang['regopen']?> 8, 23</p>
                                        <p class="text-base text-[#CD3ED0] overflow-ellipsis break-normal">0%</p>
                                    </div>
                                    <div class="bg-gray-600 rounded-lg h-2 my-2"></div>
                                    <div class="flex justify-between items-center text-gray-600 font-semibold">
                                        <p class="text-base">0 BUSD</p>
                                        <p class="text-base overflow-ellipsis break-normal">0 / <?=$rproject['project_total_supply']?> <?=$rproject['project_token_small']?></p>
                                    </div>
                                </div>
                                <div class="text-right my-6">
                                    <p class="text-white 2xl:text-2xl text-xl"><?=$arrLang['listime']?></p>
                                    <p class="text-[#CD3ED0] 2xl:text-3xl text-2xl"><? echo truedatetime($rproject['project_listing'])?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <? } ?>          
        </div>
    </div>
    <div id="resultscr"></div>
</div>  

<script>  
    $( document ).ready(function() {
        $("#all").click(
    		function(){
    			sendAjaxForm('all');
    			return false; 
    		}
    	);
        $("#upcoming").click(
    		function(){
    			sendAjaxForm('upcoming');
    			return false; 
    		}
    	);
        $("#active").click(
    		function(){
    			sendAjaxForm('active');
    			return false; 
    		}
    	);
        $("#ended").click(
    		function(){
    			sendAjaxForm('ended');
    			return false; 
    		}
    	);
        $("#vesting").click(
    		function(){
    			sendAjaxForm('vesting');
    			return false; 
    		}
    	);
    });
    
    $("#search").on('change keydown paste input', function(){
        var search = document.getElementById('search').value;
			sendAjaxForm('search',search);
    });

    function sendAjaxForm(filter, search) {
        $.ajax({
            url:     "/public/pages/filter.php",
            type:     "POST", //метод отправки
            dataType: "html", //формат данных
            data: {
                filter: filter,
                search: search
                
            },  // Сеарилизуем объект
            success: function(response) { //Данные отправлены успешно
            	$('#resultscr').html(response);
            	var element=document.getElementById('firstscr');
                if(element) {
                    document.getElementById("firstscr").remove();
                }
        	}, 
     	});
    }
</script>