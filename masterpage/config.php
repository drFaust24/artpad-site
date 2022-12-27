<?php

//Не выводить предупреждения и ошибки.
Error_Reporting(0);
// Error_Reporting(E_ERROR | E_PARSE);

// Установка кодировки для вывода контента.
header('Content-Type: text/html; charset=utf-8');
/**
 * Путь корневой директории сайта.
 */
define('SITE_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);

/**
 * Путь к директории с основой движка.
 */
define('CORE_DIR', SITE_DIR.'core/');

/**
 * Путь к директории с авторизацией.
 */
define('AUTH_DIR', SITE_DIR.'auth/');

/**
 * Путь к директории с JS скриптам.
 */
define('JS_DIR', CORE_DIR.'js/');

/**
 * Путь к директории админки.
 */
define('ADMIN_DIR', SITE_DIR.'masterpage/');

/**
 * Путь к директории загрузок.
 */
define('UPLOAD_DIR', SITE_DIR.'uploads/');

/**
 * Путь к директории личного кабинета.
 */
define('LK_DIR', SITE_DIR.'lk/');

/**
 * Путь к директории публичных данных.
 */
define('PUBLIC_DIR', SITE_DIR.'public/');

/**
 * Путь к директории изображений.
 */
define('IMG_DIR', 'images/');

/**
 * Путь к директории роботов.
 */
define('ROBO_DIR', 'robots/');

/**
 *  Текущая версия.
 */
define('VER', 'v1.0.0');
?>