<?php
/**
 * Plugin Name: Issue Tracker Plugin
 * Plugin URI:
 * Author: WithCenter Devs.
 * Description: This is Issue Tracking Plugin for WithCenter Developers.
 * Version: 0.0.1
 *
 *
 *
 */


// defines
define( 'FILE_ITS', __FILE__ );
define( 'DIR_ITS', plugin_dir_path( __FILE__ ) );
define( 'URL_ITS',  plugin_dir_url( __FILE__ ) );
define( 'DIR_CLASS',  DIR_ITS . 'class/' );
define( 'ITS_CATEGORY_SLUG',  'ITS' );
include DIR_ITS . 'etc/function.php';
include DIR_ITS . 'etc/action.php';
//include DIR_ITS . 'etc/filter.php';
include_once DIR_CLASS . 'issue.php';
include_once DIR_CLASS . 'post.php';
include_once DIR_CLASS . 'library.php';

issues()
    ->addFilters();








