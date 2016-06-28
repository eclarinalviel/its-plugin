<?php

add_action('init', function() {
    if ( in('do') ) post()->submit();
    wp_enqueue_script( 'wp-util' );
    wp_enqueue_style( 'font-awesome', URL_ITS . 'css/font-awesome/css/font-awesome.min.css' );
    wp_enqueue_style( 'bootstrap', URL_ITS . '/css/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_script( 'tether', URL_ITS . '/css/bootstrap/js/tether.min.js' );
    wp_enqueue_script( 'bootstrap', URL_ITS . '/css/bootstrap/js/bootstrap.min.js', array(), false, true );
});

add_action( 'wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu( array(
        'id' => 'its_toolbar',
        'title' => __('ITS Plugin', 'its'),
        'href' => issues()->adminURL()
    ) );
});


add_action('admin_menu', function () {
    add_menu_page('Issue Tracker', 'Issue Tracker', 'manage_options', 'issue-tracker-plugin/template/issue-list.php', '', 'dashicons-text', '23.45' );
    add_submenu_page(
        'issue-tracker-plugin/template/issue-list.php', // parent slug id
        __('Add New', 'its'),
        __('Add New', 'its'),
        'manage_options',
        'issue-tracker-plugin/template/admin.php',
        ''
    );
    add_submenu_page(
        'issue-tracker-plugin/template/issue-list.php', // parent slug id
        __('Labels', 'its'),
        __('Labels', 'its'),
        'manage_options',
        'issue-tracker-plugin/template/labels.php',
        ''
    );
//    add_submenu_page(
//        'issue-tracker-plugin/template/issue-list.php', // parent slug id
//        __('Members', 'its'),
//        __('Members', 'its'),
//        'manage_options',
//        'issue-tracker-plugin/template/members.php',
//        ''
//    );
} );
