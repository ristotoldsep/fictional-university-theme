<?php 
    //==========================
    //FILE IMPORTS
    //==========================
    function university_files() { //Defining function with my own chosen name
        //wp_enqueue_script('university_main_javascript', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true); //REMOVED AFTER NODE AUTOMATION  /*for JS - WORDPRESS demands=> NULL (does this script depend on any other scripts?, 1.0 is the version number, true means that YES we want to load JS script in the bottom of the html) */
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); //Here don't need to add https:
        //php fx to check string inside of a string
        if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) { //IF TRUE = DEVELOPMENT FILES BUNDLED AND LOADED
            wp_enqueue_script('university_main_javascript', 'http://localhost:3000/bundled.js', NULL, '1.0', true); //ADDED AFTER AUTOMATION ONLY FOR DEVELOPMENT
        } else { //FILES BUNDLED FOR THE PUBLIC VIEW
            wp_enqueue_script('our_vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
            wp_enqueue_script('university_main_javascript', get_theme_file_uri('/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'), NULL, '1.0', true);
            wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.bc49dbb23afb98cfc0f7.css'));
        }
    
        //wp_enqueue_style('university_main_styles', get_stylesheet_uri()); //REMOVED AFTER NODE AUTOMATION //Loading CSS file with WP function
    
    }
    //First is wp function, second is our made up name
    add_action('wp_enqueue_scripts', 'university_files'); /* telling WP to load files, running uni files function!*/
    //==========================
    //ADDING TITLE TAG
    //==========================
    function university_features() { 
        /* register_nav_menu('headerMenuLocation', 'Header Menu Location'); //to register a menu so "menus" tab would be visible from admin screen
        register_nav_menu('footerLocationOne', 'Footer Location One'); //Footer menu 1 (NAMES ARE RANDOMLY SELECTED!!!)
        register_nav_menu('footerLocationTwo', 'Footer Location Two'); //Footer menu 2 */
        
        add_theme_support('title-tag'); //Adds title to titlebar!
        add_theme_support('post-thumbnails'); //Enables adding default thumbnails and featured images!! //but only for blog posts by default
        add_image_size('professorLandscape', 300, 230, true); //Naming the custom image size, width px, height px, do you want to crop image (T/F)?
        add_image_size('professorPortrait', 280, 450, true); //Naming the custom image size, width px, height px, do you want to crop image (T/F)?
    }

    add_action('after_setup_theme', 'university_features'); //telling wp to run features function
    
    //POST TYPE FX WAS PREVIOSLY HERE, BUT MOVED TO MU-PLUGINS FOLDER and university-post-types.php file

    function university_adjust_queries($query) { //Manipulating default URL based queries!!!
        //FOR PROGRAMS ORDERING IN ALL PROGRAMS ARCHIVE
        if(!is_admin() AND is_post_type_archive('program') AND is_main_query()) {
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
            $query->set('posts_per_page', -1);
        }
        //FOR DATE FILTERING ON EVENTS ARCHIVE
       if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) { //Only when on front end and event archive and is default, not custom query!! 
            $today = date('Ymd'); //Variable for todays date 
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');;
            $query->set('order', 'ASC');
            $query->set('meta_query', array( //FOR FILTERING DATES (OLD DATES DISAPPEAR, ONLY SHOW LATEST)
                  array( //ONLY RETURN POSTS THAT ARE GREATER THAN OR EQUAL OF TODAYS DATE!
                    'key' => 'event_date', //event_date = Custom field name in dashboard
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                  )
                  ));
       }
    }   

    add_action('pre_get_posts', 'university_adjust_queries');
?>