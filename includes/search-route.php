<?php 

    //==========================
    //CUSTOMIZING THE REST API / CREATING OUR OWN CUSTOM URL ROUTES to have more control
    //=========================
    add_action('rest_api_init', 'universityRegisterSearch');

    //To register a new custom Rest API route
    function universityRegisterSearch() {
        //1st argument = namespace [the "wp" in -> /wp-json/wp/v2/posts)]   v2 is also part of the namespace, the version of our api route
        //2nd argument = route [the "posts"]
        //3rd argument = array that describes how we want to manage this field
        register_rest_route('university/v1', 'search', array( //university/v1/search/...
            'methods' => WP_REST_SERVER::READABLE, //means = 'GET', but just in case if some web hosts don't know what GET is
            'callback' => 'universitySearchResults' //calls this function, and passes along $data about the current request that someone is sending
        ));
    }

    //To create our own custom JSON
    function universitySearchResults($data) { //WP automatically converts PHP into JSON data!!!! (don't need to write JSON syntax)
       
        //Main query to REST API custom URL
        $mainQuery = new WP_Query(array(
           'post_type' => array('post', 'page', 'program', 'professor', 'event', 'institution'),
           's' => sanitize_text_field($data['term'])  //s = search |$data = array that WordPress puts together and within this is the term someone searched for
       ));
       
       // return $professors->posts; //LOOPS through the professor object and posts array automatically (and outputs 10 by default)
       //Since we don't use 90% of the JSON data we get back, we are populating the JSON with only the data we want !!
       
       //POPULATING this array with certain post types
       $results = array(
           'generalInfo' => array(),
           'professors' => array(),
           'programs' => array(),
           'events' => array(),
           'institutions' => array()
       );

    
       while($mainQuery->have_posts()) { //Loop length = number of professors
            $mainQuery->the_post();
            
            if (get_post_type() == 'post' OR get_post_type() == 'page') {
                array_push($results['generalInfo'], array( //Output the combined array of objects in JSON
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'ID' => get_the_ID()
                ));   
            }
            if (get_post_type() == 'professor') {
                array_push($results['professors'], array( //Output the combined array of objects in JSON
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'ID' => get_the_ID()
                ));   
            }
            if (get_post_type() == 'program') {
                array_push($results['programs'], array( //Output the combined array of objects in JSON
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'ID' => get_the_ID()
                ));   
            }
            if (get_post_type() == 'event') {
                array_push($results['events'], array( //Output the combined array of objects in JSON
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'ID' => get_the_ID()
                ));   
            }
            if (get_post_type() == 'institution') {
                array_push($results['institutions'], array( //Output the combined array of objects in JSON
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'ID' => get_the_ID()
                ));   
            }
       }
       return $results; //Return the associative array with JSON data
    }


?>