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
            'callback' => 'universitySearchResults' //calls this function
        ));
    }

    //To create our own custom JSON
    function universitySearchResults() { //WP automatically converts PHP into JSON data (don't need to write JSON syntax)
       $professors = new WP_Query(array(
           'post_type' => 'professor'
       ));
       
       // return $professors->posts; //LOOPS through the professor object and posts array automatically (and outputs 10 by default)
       //Since we don't use 90% of the JSON data we get back, we are populating the JSON with only the data we want !!
       
       $professorResults = array();

       while($professors->have_posts()) { //Loop length = number of professors
         $professors->the_post();

         array_push($professorResults, array( //Output the combined array of objects in JSON
            'title' => get_the_title(),
            'permalink' => get_the_permalink()
         ));
       }

       return $professorResults;
    }


?>