<?php
/**
 * WordPress 配置文件 - 环境变量驱动
 *
 * 通过 Docker 环境变量注入数据库连接、密钥等敏感配置。
 *
 * @package WordPress
 */

// ** 数据库设置 ** //
define( 'DB_NAME',     getenv('WORDPRESS_DB_NAME')     ?: 'wordpress' );
define( 'DB_USER',     getenv('WORDPRESS_DB_USER')     ?: 'root' );
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'bluesky' );
define( 'DB_HOST',     getenv('WORDPRESS_DB_HOST')     ?: 'mariadb' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

/**
 * 认证密钥与盐值
 * 生产环境务必通过环境变量设置唯一值
 * @link https://api.wordpress.org/secret-key/1.1/salt/
 */
define( 'AUTH_KEY',         getenv('WORDPRESS_AUTH_KEY')         ?: 'put-your-unique-phrase-here' );
define( 'SECURE_AUTH_KEY',  getenv('WORDPRESS_SECURE_AUTH_KEY')  ?: 'put-your-unique-phrase-here' );
define( 'LOGGED_IN_KEY',    getenv('WORDPRESS_LOGGED_IN_KEY')    ?: 'put-your-unique-phrase-here' );
define( 'NONCE_KEY',        getenv('WORDPRESS_NONCE_KEY')        ?: 'put-your-unique-phrase-here' );
define( 'AUTH_SALT',        getenv('WORDPRESS_AUTH_SALT')        ?: 'put-your-unique-phrase-here' );
define( 'SECURE_AUTH_SALT', getenv('WORDPRESS_SECURE_AUTH_SALT') ?: 'put-your-unique-phrase-here' );
define( 'LOGGED_IN_SALT',   getenv('WORDPRESS_LOGGED_IN_SALT')  ?: 'put-your-unique-phrase-here' );
define( 'NONCE_SALT',       getenv('WORDPRESS_NONCE_SALT')       ?: 'put-your-unique-phrase-here' );

/** 数据库表前缀 */
$table_prefix = 'wp_';

/** 调试模式 */
define( 'WP_DEBUG', getenv('WORDPRESS_DEBUG') === 'true' );

/** 站点地址 */
define( 'WP_HOME',    getenv('WORDPRESS_HOME')    ?: 'https://www.keejiai.com' );
define( 'WP_SITEURL', getenv('WORDPRESS_SITEURL') ?: 'https://www.keejiai.com' );

/** 默认语言 */
define( 'WPLANG', 'zh_CN' );

/** 反向代理 HTTPS 支持（Caddy -> WordPress） */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

/* 自定义值请加在此行与下方 "stop editing" 之间 */



/* 到此为止，不要再编辑。祝发布愉快！ */

/** WordPress 绝对路径 */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** 加载 WordPress 核心 */
require_once ABSPATH . 'wp-settings.php';
