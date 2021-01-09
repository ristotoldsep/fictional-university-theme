//USING C-R-U from CRUD!

import $ from "jquery";

class MyNotes {
    constructor() {
        this.events()
    }

    events() {
        $(".delete-note").on("click", this.deleteNote) //This event listener passes data with it [(event) argument in deleteNode method]
        $(".edit-note").on("click", this.editNote)
    }

    //Custom methods
    deleteNote(event) {

        const thisNote = $(event.target).parents("li"); //To get info which delete button got clicked on

        $.ajax({ //Ajax method is a great option when you want to be able to control what type of request you're sending
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'), //Url the API Call will be made to
            type: 'DELETE', //Http request type
            success: (response) => { //in case of successs
                thisNote.slideUp();

                console.log("Success");
                console.log(response);
            },
            error: (response) => { //in case of error
                console.log("Error");
                console.log(response);
            }
        });
    }

    editNote(event) {
        
        const thisNote = $(event.target).parents("li"); //To get info which delete button got clicked on

        //To remove the readonly html attribute and add borders for editing notes!
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");

        thisNote.find(".update-note").addClass("update-note--visible");
    }
}

export default MyNotes;