function menu_desktop() {
    document.getElementById("menu_desktop").classList.add("active");
    document.getElementById("menu_content").classList.remove("active");
    document.getElementById("menu_services").classList.remove("active");
    document.getElementById("menu_settings").classList.remove("active");
    document.getElementById("submenu_desktop").classList.add("active");
    document.getElementById("submenu_content").classList.remove("active");
    document.getElementById("submenu_services").classList.remove("active");
    document.getElementById("submenu_settings").classList.remove("active");
}

function menu_content() {
    document.getElementById("menu_desktop").classList.remove("active");
    document.getElementById("menu_content").classList.add("active");
    document.getElementById("menu_services").classList.remove("active");
    document.getElementById("menu_settings").classList.remove("active");
    document.getElementById("submenu_desktop").classList.remove("active");
    document.getElementById("submenu_content").classList.add("active");
    document.getElementById("submenu_services").classList.remove("active");
    document.getElementById("submenu_settings").classList.remove("active");
}

function menu_services() {
    document.getElementById("menu_desktop").classList.remove("active");
    document.getElementById("menu_content").classList.remove("active");
    document.getElementById("menu_services").classList.add("active");
    document.getElementById("menu_settings").classList.remove("active");
    document.getElementById("submenu_desktop").classList.remove("active");
    document.getElementById("submenu_content").classList.remove("active");
    document.getElementById("submenu_services").classList.add("active");
    document.getElementById("submenu_settings").classList.remove("active");
}

function menu_settings() {
    document.getElementById("menu_desktop").classList.remove("active");
    document.getElementById("menu_content").classList.remove("active");
    document.getElementById("menu_services").classList.remove("active");
    document.getElementById("menu_settings").classList.add("active");
    document.getElementById("submenu_desktop").classList.remove("active");
    document.getElementById("submenu_content").classList.remove("active");
    document.getElementById("submenu_services").classList.remove("active");
    document.getElementById("submenu_settings").classList.add("active");
}