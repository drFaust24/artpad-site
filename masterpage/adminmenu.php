<? if (!defined('artpadadm')) exit('No direct script access allowed'); ?>  
<?
    if (!empty($_GET["main"])) {
        $main=$_GET["main"];
    } else {
        $main = "desktop";
    }
    if (!empty($_GET["sub"])) {
        $sub=$_GET["sub"];
    } else {
        $sub = "dashboards";
    }
?>
<div class="admin-main-menu">
    <div class="admin-main-menu-item <?if ($main=="desktop") { echo "active"; } ?>" onclick="menu_desktop()" id="menu_desktop">
        <img src="/images/home.png">
        Рабочий стол
    </div>   
    <div class="admin-main-menu-item <?if ($main=="content") { echo "active"; } ?>" onclick="menu_content()" id="menu_content">
        <img src="/images/content.png">
        Контент
    </div>  
    <div class="admin-main-menu-item <?if ($main=="services") { echo "active"; } ?>" onclick="menu_services()" id="menu_services">
        <img src="/images/services.png">
        Сервисы
    </div> 
    <div class="admin-main-menu-item <?if ($main=="settings") { echo "active"; } ?>" onclick="menu_settings()" id="menu_settings">
        <img src="/images/settings.png">
        Настройки
    </div>
</div>
<div class="adm-submenu" id="adm-submenu">
    <div class="admin-submenu-item <?if ($main=="desktop") { echo "active"; } ?>" id="submenu_desktop">
        <a href="/masterpage/dashboard.php?main=desktop&sub=dashboards" <?if ($sub=="dashboards") { echo "class=\"active\""; } ?>>Dashboards</a>
    </div>
    <div class="admin-submenu-item <?if ($main=="content") { echo "active"; } ?>" id="submenu_content">
        <a href="/masterpage/pages/?main=content&sub=pages" <?if ($sub=="pages") { echo "class=\"active\""; } ?>>Страницы</a>
        <a href="/masterpage/projects/?main=content&sub=projects" <?if ($sub=="projects") { echo "class=\"active\""; } ?>>Проекты</a>
        <a href="/masterpage/menus/?main=content&sub=menu" <?if ($sub=="menu") { echo "class=\"active\""; } ?>>Меню</a>
    </div>
    <div class="admin-submenu-item <?if ($main=="services") { echo "active"; } ?>" id="submenu_services">
        <a href="/masterpage/applyforido.php?main=services&sub=ido" <?if ($sub=="ido") { echo "class=\"active\""; } ?>>Заявки на IDO</a>
        <a href="/masterpage/subscribers.php?main=services&sub=subscr" <?if ($sub=="subscr") { echo "class=\"active\""; } ?>>Подписки на рассылку</a>
    </div>
    <div class="admin-submenu-item <?if ($main=="settings") { echo "active"; } ?>" id="submenu_settings">
        <a href="/masterpage/users/?main=settings&sub=users" <?if ($sub=="users") { echo "class=\"active\""; } ?>>Список пользователей</a>
        <a href="/masterpage/settings.php?main=settings&sub=site" <?if ($sub=="site") { echo "class=\"active\""; } ?>>Настройки сайта</a>
    </div>
</div>