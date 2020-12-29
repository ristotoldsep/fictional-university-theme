import $ from 'jquery'; //ADDS JQUERY 

//========================================================================
class Search { //Creating the class
    //1. Constructor is used to describe and create/initiate our object
    constructor() {//this refers to the current object, HERE I CAN INITIATE STATE!
       /*  this.name = "Jane";
        this.eyecolor = "green";
        this.head = {}  */
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
            clearTimeout(this.typingTimer); //If typing has not stopped in 2 seconds, clear the timer variable

            if (this.searchField.val()) {
                if(!this.isSpinnerVisible) { //Only show spinner, if it is not already visible
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 2000); //If 2 seconds has passed since last keypress, set timer!
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            } 
        }
        this.previousValue = this.searchField.val();
    }

    getResults () {
        this.resultsDiv.html("<h1>Testing hahaha</h1>");
        this.isSpinnerVisible = false; //Reset state
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
        this.isOverlayOpen = true;
        //console.log(this.isOverlayOpen);
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll"); //If search deactivated, add scrolling to bg
        this.isOverlayOpen = false;
        //console.log(this.isOverlayOpen);
    }
    }
        

export default Search;