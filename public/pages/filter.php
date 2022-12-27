<?
    include_once '../../config.php';
    include_once CORE_DIR.'connect.php';
    include_once CORE_DIR.'functions.php';
    
    if (isset($_POST["filter"])) {
        $filter = $_POST["filter"];
        switch ($filter) {
            case 'all':
                $qprojects ="SELECT * FROM `projects`";
                $strh = "All IDOs";
                break;
            case 'upcoming':
                $qprojects ="SELECT * FROM `projects` WHERE `project_status`='upcoming'";
                $strh = "Upcoming IDOs";
                break;
            case 'active':
                $qprojects ="SELECT * FROM `projects` WHERE `project_status`='active'";
                $strh = "Active IDOs";
                break;
            case 'ended':
                $qprojects ="SELECT * FROM `projects` WHERE `project_status`='ended'";
                $strh = "Ended IDOs";
                break;
            case 'vesting':
                $qprojects ="SELECT * FROM `projects` WHERE `project_status`='vesting'";
                $strh = "Vesting IDOs";
                break;
            case 'search':
                $search = $_POST["search"];
                $qprojects ="SELECT * FROM `projects` WHERE `project_title` LIKE '%$search%'";
                $strh = "Result for ".$search;
                break;
        }
        echo "<p class=\"text-white md:text-4xl text-3xl font-bold my-10\">".$strh."</p>";
        echo "<div>";
        
        $rprojects = $artpad -> query($qprojects);
        while ($rproject = $rprojects->fetch_assoc()) {
            echo "<a href=\"/projects/".$rproject[project_name]."\">";
                echo "<div class=\"xl:w-1/3 sm:w-1/2 w-full inline-block\">";
                    echo "<div class=\"max-w-max border border-2 border-[#CD3ED0] my-4 rounded-md lg:mx-6 sm:mx-2 mx-0\">";
                        echo "<div class=\"relative\">";
                            echo "<div class=\"absolute flex justify-between items-center w-full h-full px-4\">";
                                echo "<div class=\"text-white 2xl:text-4xl lg:text-3xl md:text-2xl text-3xl\">";
                                    echo "<p class=\"font-bold mb-2\">".$rproject['project_title']."</p>";
                                    echo "<p class=\"font-semibold mt-2\">$".$rproject['project_token_small']."</p>";
                                echo "</div>";
                                echo "<div class=\"text-white\">";
                                    echo "<img src=\"".$rproject['project_logo']."\" class=\"platform__image\">";
                                echo "</div>";
                            echo "</div>";
                            echo "<img src=\"/public/img/ProjectsCardImg.png\" class=\"w-full rounded-t-md\">";
                        echo "</div>";
                        echo "<div class=\"px-3 w-full\">";
                            echo "<div class=\"text-white bg-gray-600 rounded-2xl max-w-max text-sm px-2 py-1 my-2.5\">";
                                echo "<p style=\"text-transform: uppercase;\">".$rproject[project_status]."</p>";
                            echo "</div>";
                            echo "<p class=\"text-white text-sm projectdescr\">".$rproject[project_content]."</p>";
                            echo "<div class=\"my-8\">";
                                echo "<div class=\"flex justify-between items-center\">";
                                    echo "<p class=\"text-white 2xl:text-2xl md:text-xl text-lg\">Total Raise</p>";
                                    echo "<p class=\"2xl:text-3xl lg:text-2xl md:text-xl text-xl text-[#CD3ED0] overflow-ellipsis break-normal\">".$rproject[project_initial_supply]."</p>";
                                echo "</div>";
                                echo "<div class=\"flex justify-between items-center my-3\">";
                                    echo "<p class=\"text-white text-xl\">Strats</p>";
                                    echo "<p class=\"2xl:text-2xl md:text-xl text-lg text-[#CD3ED0] overflow-ellipsis break-normal\">Jul 4, 11:00 UTC</p>";
                                echo "</div>";
                                echo "<div class=\"flex justify-between items-center\">";
                                    echo "<p class=\"text-white text-xl\">Price</p>";
                                    echo "<p class=\"2xl:text-2xl md:text-xl text-lg text-[#CD3ED0] overflow-ellipsis break-normal text-right`\">1 ".$rproject[project_token_small]." = ".$rproject['project_price_ido']."</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div>";
                                echo "<div class=\"flex justify-between items-center\">";
                                    echo "<p class=\"text-white 2xl:text-base text-sm\">registrations opens ind 8 days, 23 hours</p>";
                                    echo "<p class=\"text-base text-[#CD3ED0] overflow-ellipsis break-normal\">0%</p>";
                                echo "</div>";
                                echo "<div class=\"bg-gray-600 rounded-lg h-2 my-2\"></div>";
                                echo "<div class=\"flex justify-between items-center text-gray-600 font-semibold\">";
                                    echo "<p class=\"text-base\">0 BUSD</p>";
                                    echo "<p class=\"text-base overflow-ellipsis break-normal\">0 / ".$rproject[project_total_supply]." ".$rproject[project_token_small]."</p>";
                                echo "</div>";
                            echo "</div>";
                            echo "<div class=\"text-right my-6\">";
                                echo "<p class=\"text-white 2xl:text-2xl text-xl\">Listing Time</p>";
                                echo "<p class=\"text-[#CD3ED0] 2xl:text-3xl text-2xl\">".truedate($rproject[project_listing])."</p>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</a>";
        }
        echo "</div>";
    }
?>