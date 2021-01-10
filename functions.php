<?php 

    require get_theme_file_path('/includes/like-route.php'); //Importing custom REST API creating functions, to not bloat this file //POST and DELETE endpoints for likes
    require get_theme_file_path('/includes/search-route.php'); //Importing custom REST API creating functions, to not bloat this file //READ endpoints for search

    //==========================
    //CUSTOMIZING THE REST API
    //==========================
    function university_custom_rest() {
        //1st argument = post type that you want to customize
        //2nd argument = second argument is whatever you want to name the new field (property to JSON)
        //3rd argument = array that describes how we want to manage this field
        register_rest_field('post', 'authorName', array( //Adding the post authorName property to REST API JSON
            'get_callback' => function() { return get_the_author(); }
        ));

        register_rest_field('note', 'userNoteCount', array( //Count the notes a user currently has
            'get_callback' => function() { return count_user_posts(get_current_user_id(), 'note'); }
        ));
    }

    add_action('rest_api_init', 'university_custom_rest');

    //==========================
    //CUSTOM PAGE BANNER FUNCTION (takes array as arguments ($args))
    //==========================
    function pageBanner ($args = NULL) {
        if (!$args['title']) { //If no title gets passed, take the default WordPress one!!!
            $args['title'] = get_the_title();
        }

        if (!$args['subtitle']) { //If no subtitle gets passed, take the default WordPress one!!!
            $args['subtitle'] = get_field('page_banner_subtitle');
        }

        if (!$args['photo']) { //If no photo is passed from code argument
            if(get_field('page_banner_background_image')) { //If there is a custom page banner inserted from dashboard
                $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
            } else {
                $args['photo'] = get_theme_file_uri('/images/taltech2.jpg');
            }
            
        }
    ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(
                <?php 
                /* echo get_theme_file_uri('/images/taltech3.jpg') */ 
                /* $pageBannerImage = get_field('page_banner_background_image');
                echo $pageBannerImage['sizes']['pageBanner']; */
                echo $args['photo'];
                ?>);">
            </div>
                <div class="page-banner__content container container--narrow">
                     <h1 class="page-banner__title"><?php echo $args['title'];  //the_title(); ?></h1>
                        <div class="page-banner__intro">
                            <p><?php echo $args['subtitle'];   //the_field('page_banner_subtitle'); ?></p>
                        </div>
                </div>  
        </div>
    <?php }

    //==========================
    //FILE IMPORTS (css, js etc...)
    //==========================
    function university_files() { //Defining function with my own chosen name

        //wp_enqueue_script('university_main_javascript', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true); //REMOVED AFTER NODE AUTOMATION  /*for JS - WORDPRESS demands=> NULL (does this script depend on any other scripts?, 1.0 is the version number, true means that YES we want to load JS script in the bottom of the html) */
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); //Here don't need to add https:

        //LOADS GOOGLE MAPS API
        wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=<key>', NULL, '1.0', true); 


        //php fx to check string inside of a string, RUNNING APP LOCALLY VS PRODUCTION
        if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) { //IF TRUE = DEVELOPMENT FILES BUNDLED AND LOADED
            wp_enqueue_script('university_main_javascript', 'http://localhost:3000/bundled.js', NULL, '1.0', true); //ADDED AFTER AUTOMATION ONLY FOR DEVELOPMENT
        } else { //FILES BUNDLED FOR THE PUBLIC VIEW
            wp_enqueue_script('our_vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.9678b4003190d41dd438.js'), NULL, '1.0', true);
            wp_enqueue_script('university_main_javascript', get_theme_file_uri('/bundled-assets/scripts.b8802cd0aa92babbb1b0.js'), NULL, '1.0', true);
            wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.b8802cd0aa92babbb1b0.css'));
        }
    
        //wp_enqueue_style('university_main_styles', get_stylesheet_uri()); //REMOVED AFTER NODE.js AUTOMATION //Loading CSS file with WP function
        
        //CREATING DYNAMIC flexible RELATIVE URL FOR API CALLS (creates variable universityData [check from chrome inspect element console bottom! & Search.js dynamic url in API call])
        //Takes 3 arguments: 1) The js file u r trying to make flexible 2) made up variable 3) array
        wp_localize_script('university_main_javascript', 'universityData', array(
            'root_url' => get_site_url(), //fx will return url for current WP installation
            'nonce' => wp_create_nonce('wp_rest') //This is for enablind CRUD actions
            /* Whenever we successfully log into WordPress if we check the view source of the page there will be a secret property named nonce That equals a randomly generated number that WordPress creates just for our user session. */
        ));
    }
    //First is wp function, second is our made up name = ACTION HOOKS
    add_action('wp_enqueue_scripts', 'university_files'); /* telling WP to load files, running uni files function!*/
    //==========================
    //ADDING TITLE TAG, DEFAULT THUMBNAILS & IMAGE SIZES
    //==========================
    function university_features() { 
        /* register_nav_menu('headerMenuLocation', 'Header Menu Location'); //to register a menu so "menus" tab would be visible from admin screen
        register_nav_menu('footerLocationOne', 'Footer Location One'); //Footer menu 1 (NAMES ARE RANDOMLY SELECTED!!!)
        register_nav_menu('footerLocationTwo', 'Footer Location Two'); //Footer menu 2 */
        
        add_theme_support('title-tag'); //Adds title to titlebar!
        add_theme_support('post-thumbnails'); //Enables adding default thumbnails and featured images!! //but only for blog posts by default
        add_image_size('professorLandscape', 300, 230, true); //Naming the custom image size, width px, height px, do you want to crop image (T/F)?
        add_image_size('professorPortrait', 280, 450, true); //Naming the custom image size, width px, height px, do you want to crop image (T/F)?
        add_image_size('pageBanner', 1500, 350, true); //Naming the custom image size, width px, height px, do you want to crop image (T/F)?
    }

    add_action('after_setup_theme', 'university_features'); //telling wp to run features function
    
    //POST TYPE FX WAS PREVIOSLY HERE, BUT MOVED TO MU-PLUGINS FOLDER and university-post-types.php file

    //==========================
    //MANIPULATING DEFAULT URL BASED QUERIES
    //==========================
    function university_adjust_queries($query) { 
        //FOR INSTITUTION ORDERING IN CAMPUS ARCHIVE (So it would show all Map pins, not wp default 10)
        if(!is_admin() AND is_post_type_archive('institution') AND is_main_query()) {
            $query->set('posts_per_page', -1);
        }
        
        //FOR PROGRAMS ORDERING IN ALL PROGRAMS/MAJORS ARCHIVE
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


    //==========================
    //FUNCTION FOR GOOGLE MAPS API
    //==========================
    function universityMapKey($api) {
        $api['key'] = '<key>';  
        return $api;
    }

    add_filter('acf/fields/google_map/api', 'universityMapKey'); //acf = advanced custom fields

    //==========================
    //REDIRECT subscriber accounts out of admin and onto homepage
    //==========================

    add_action('admin_init', 'redirectSubsToFrontend');
    
    function redirectSubsToFrontend() {

        $ourCurrentUser = wp_get_current_user(); 

        //IF user has only one role and it is subscriber = Don't show them the dashboard, but redirect
        if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
            wp_redirect(site_url('/'));
            exit; //Telling WP to chill out
        }
    }

    //==========================
    //REMOVE WP admin bar from top of the page for regular users (subscribers)
    //==========================

    add_action('wp_loaded', 'noSubsAdminBar');
    
    function noSubsAdminBar() {

        $ourCurrentUser = wp_get_current_user(); 

        //IF user has only one role and it is subscriber = Don't show them the dashboard, but redirect
        if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
            show_admin_bar(false);
        }
    }

    //==========================
    //CUSTOMIZE Login Screen
    //==========================

    add_filter('login_headerurl', 'ourHeaderUrl');

    //Change the url the login image points to
    function ourHeaderUrl() {
        return esc_url(site_url('/'));
    }
    add_filter('login_headertitle', 'ourLoginTitle');
    
    //Custom Title for login screen
    function ourLoginTitle() {
        //return get_option('blogname');
        return get_bloginfo('name');
    }

    //Customize the CSS
    add_action('login_enqueue_scripts', 'ourLoginCSS');

    function ourLoginCSS() {
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.b8802cd0aa92babbb1b0.css'));
    }

    //Forcing note posts to be private, filtering the post, SECURITY
    //Filtering HOOK - intercepting a request right before the data gets saved into the database.
    add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2); //10 - priority (in case several same filter functions), 2 - we want this function to be able to work with two parameters.

    //LIKE FILTERING DIRTY WATER, IT GETS PaSSED AS AN ARGUMENT, WE CLEAN IT AND RETURN CLEAN WATER
    function makeNotePrivate($data, $postarray) { //wp_insert_post_data passes both
        
        //Since wp_insert_post_data runs for all post types, we only want to select "note"
        if ($data['post_type'] == 'note') {

            //Limiting the number of notes user can enter
            if(count_user_posts(get_current_user_id(), 'note') > 5 AND !$postarray['ID']) { //If over five and user tries to enter a NEW note (not change existing one, new note does not have ID yet)
                die("You have reached your note limit.");
            }

            //Sanitizing the input - NO HTML or JS Scripts will be executed!
            $data['post_title'] = sanitize_text_field($data['post_title']);
            $data['post_content'] = sanitize_textarea_field($data['post_content']);

        }
        //Setting the note post type to be private by default
        if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {

            $data['post_status'] = "private";

        }
        return $data; //returning filtered water
    }

?>