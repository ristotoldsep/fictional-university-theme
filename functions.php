<?php 

    function university_files() { //Defining function with my own chosen name
        wp_enqueue_script('university_main_javascript', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true); //for JS - WORDPRESS demands=> NULL (does this script depend on any other scripts?, 1.0 is the version number, true means that YES we want to load JS script in the bottom of the html)
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); //Here don't need to add https:
        wp_enqueue_style('university_main_styles', get_stylesheet_uri()); //Loading CSS file with WP function
    
    }

    add_action('wp_enqueue_scripts', 'university_files'); /* telling WP to load files, running uni files function!*/

    function university_features() { 
        /* register_nav_menu('headerMenuLocation', 'Header Menu Location'); //to register a menu so "menus" tab would be visible from admin screen
        register_nav_menu('footerLocationOne', 'Footer Location One'); //Footer menu 1 (NAMES ARE RANDOMLY SELECTED!!!)
        register_nav_menu('footerLocationTwo', 'Footer Location Two'); //Footer menu 2 */

        add_theme_support('title-tag'); //Adds title to titlebar!
    }

    add_action('after_setup_theme', 'university_features'); //telling wp to run features function

?>