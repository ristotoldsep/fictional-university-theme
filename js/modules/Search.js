import $ from 'jquery'; //ADDS JQUERY 

//OOP JS FOR LIVE SEARCH
//========================================================================
class Search { //Creating the class
    //1. Constructor is used to describe and create/initiate our object
    constructor() {//this refers to the current object, HERE I CAN INITIATE STATE! (ORDEER DOES MATTER)
       /*  this.name = "Jane";
        this.eyecolor = "green";
        this.head = {}  */
        this.addSearchHTML();
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results");
        this.events(); //Must add function,that adds the event listeners
        this.isOverlayOpen = false; //Added state in the beginning (overlay is closed), and then changing the state later on
        this.typingTimer; //Timeout timer for search ( waiting for longer phrase not sending request every time ) OBJECT PROPERTY
        this.isSpinnerVisible = false; //To keep track of the spinner state (and not write it over constantly)
        this.previousValue; //So request would only be made if text keys are pressed
    }
//========================================================================
    //2. events (Here we connect the dots between object and different actions it can perform)
    /* EVENT LISTENERS - ADDED BIND, CAUSE OTHERWISE "on" method would change the value of "this" & it wouldn't get to the methods ()*/
    events() {
        this.openButton.on("click", this.openOverlay.bind(this)); //Listener for search icon click, then fires a method openOverlay
        this.closeButton.on("click", this.closeOverlay.bind(this)); //Listener for search close click, then fires a method closeverlay
        $(document).on("keydown", this.keyPressDispatcher.bind(this)); //Listener for a keypress anywhere in the browser (keyup = execute once when key is released; keydown = you can hold down longer)
        this.searchField.on("keyup", this.typingLogic.bind(this)); //without BIND "this" turns to searcField (cause it triggered the typingLogic method)
    }

//========================================================================
    // 3. methods (function, action...) - Called by events()
    //TYPING FUNCTION
    typingLogic () {
        //Run only if search term wasn't the previous search (to avoid requests when using arrow keys etc...)
        if (this.searchField.val() != this.previousValue) { 
            clearTimeout(this.typingTimer); //If typing has not stopped in 0.75 seconds, clear the timer variable

            if (this.searchField.val()) {
                if(!this.isSpinnerVisible) { //Only show spinner, if it is not already visible
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750); //If 0.75 seconds has passed since last keypress, set timer and call results method!
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            } 
        }
        this.previousValue = this.searchField.val();
    }
    //JSON FETCH CALL
    getResults () { //Method gets valled by typingTimer

        // $.when(one, two).then((one, two) => { });

        //USING SYNC AND ASYNC !!!!!!!!!!!!!!!!!
        $.when( //FIRST GETTING BOTH JSON REQUESTS AT THE SAME TIME
                $.getJSON(universityData.root_url + "/wp-json/wp/v2/posts?search=" + this.searchField.val()),
                $.getJSON(universityData.root_url + "/wp-json/wp/v2/pages?search=" + this.searchField.val())
        ).then((posts, pages) => { //WHEN REQ'S ARE DONE, SHOW SEARCH RESULTS

                const combinedResults = posts[0].concat(pages[0]); /*CONCAT COMBINES ARRAYS, so all the post types. 
                when req also passes other info to "then" than just JSON (like is req successful etc), so we use [0], which means we want only JSON data    */

                this.resultsDiv.html(` 
                        <h2 class="search-overlay__section-title">General Information</h2>

                        ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No matches my brudda</p>'}
                        
                        ${combinedResults.map((item) => `<li><a href="${ item.link }">${ item.title.rendered }</a> ${ item.type == 'post' ? `by ${item.authorName}` : '' }</li>`).join('') } 

                        ${combinedResults.length ? '</ul>' : ''}
                    `);
                this.isSpinnerVisible = false; //Reset state 
            }, () => { //ERROR HANDLING 
                this.resultsDiv.html('<h4>Unexpected error, please try again.</h4>');
            }); 

        /* this.resultsDiv.html("<h1>Testing hahaha</h1>");*/
        // $.getJSON(url, fx) -> it wants an url, and a function what to do with the data == JQUERY METHOD!!!!!!!!!!!!! (json to html)
        
        //$.getJSON("http://fictional-university.local/wp-json/wp/v2/posts?search=" + this.searchField.val(), (data) => { // data gets passed from the API call to anonymous fx => converting JSON to html

        //FIRST WAY OF SYNCHRONOUSLY RUNNING ALL THE API CALLS
        // $.getJSON(universityData.root_url + "/wp-json/wp/v2/posts?search=" + this.searchField.val(), (posts) => { /* MADE URL RELATIVE (DYNAMIC)!!! variable init in functions.php */ 
        //     $.getJSON(universityData.root_url + "/wp-json/wp/v2/pages?search=" + this.searchField.val(), (pages) => {
                
        //     });
        // });
    }

    //KEYPRESS FUNCTION
    keyPressDispatcher(event) {
        //console.log("Keypress: ", event.keyCode, event.key);

        /* Open search overlay with "s" only if other inputs/textareas are not active!! */
        if (event.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) { 
             this.openOverlay();
             console.log("OpenMethod");
        }
        if (event.keyCode == 27 && this.isOverlayOpen) { //Close search with "ESC" key
            this.closeOverlay();
            console.log("CloseMethod"); 
        }
        
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll"); //If search active, remove scrolling from bg
         //this.resultsDiv.html(''); //Remove search results if opened/closed multiple times and results were previously there
         this.searchField.val(''); //Setting the value to empty string each time opened
       
        setTimeout(() => { this.searchField.focus(); }, 301); //Setting timeout to give CSS time to load (otherwise the instant focus would not work)
        this.isOverlayOpen = true;
        //console.log(this.isOverlayOpen);
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll"); //If search deactivated, add scrolling to bg
        this.isOverlayOpen = false;
        //console.log(this.isOverlayOpen);
    }

    //Method for outputting the search overlay to the end of the body (append)!
    addSearchHTML() {
        $("body").append(` 
             <!-- SEARCH OVERLAY -->
            <div class="search-overlay"> <!-- ACTIVE class makes the search window appear (JS) -->
                <div class="search-overlay__top">
                <div class="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
                </div>

                <div class="container">
                <div id="search-overlay__results">
                    <h2></h2>
                </div>
                </div>
            </div>
        `);
    }
}
        

export default Search;