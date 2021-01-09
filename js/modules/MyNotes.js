//USING C-R-U from CRUD! Manipulates page-my-notes.php

import $ from "jquery";

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $("#my-notes").on("click", ".delete-note", this.deleteNote); //Delete button - This event listener passes data with it [(event) argument in deleteNode method]
        $("#my-notes").on("click", ".edit-note", this.editNote.bind(this)); //Edit button - Use bind(this) so js would not modify it's value
        $("#my-notes").on("click", ".update-note", this.updateNote.bind(this)); //Save button
        $(".submit-note",).on("click", this.createNote.bind(this)); //Create Note button
    }

    //Custom methods
    deleteNote(event) { //SENDING DELETE REQ TO REST API WITH AJAX

        const thisNote = $(event.target).parents("li"); //To get info which delete button got clicked on

        $.ajax({ //Ajax method is a great option when you want to be able to control what type of request you're sending //POST, DELETE etc..
            beforeSend: (xhr) => { //XHR - XML HTTP REQUEST, this is to prove to wordpress our authenticity
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'), //Url the API Call will be made to
            type: 'DELETE', //Http request type
            success: (response) => { //in case of successs
                thisNote.slideUp(); //remove note
                console.log("Note Deleted!");
                console.log(response);
            },
            error: (response) => { //in case of error
                console.log("Error");
                console.log(response);
            }
        });
    }

    updateNote(event) { //SENDING DELETE REQ TO REST API WITH AJAX

        const thisNote = $(event.target).parents("li"); //To get info which delete button got clicked on

        const ourUpdatedNote = { /* WP rest API is looking for very specific property names */
            'title': thisNote.find(".note-title-field").val(), //updating the note title
            'content': thisNote.find(".note-body-field").val() //Updating note body content
        }

        $.ajax({ //Ajax method is a great option when you want to be able to control what type of request you're sending //POST, DELETE etc..
            beforeSend: (xhr) => { //XHR - XML HTTP REQUEST, this is to prove to wordpress our authenticity
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'), //Url the API Call will be made to
            type: 'POST', //Http request type
            data: ourUpdatedNote, //Pass the updated note object with the POST request
            success: (response) => { //in case of success
                this.makeNoteReadOnly(thisNote); //If clicked save, exit from edit mode
                console.log("Note Updated!");
                console.log(response);
            },
            error: (response) => { //in case of error
                console.log("Error");
                console.log(response);
            }
        });
    }

    createNote(event) { //SENDING DELETE REQ TO REST API WITH AJAX

        const ourNewNote = { /* WP rest API is looking for very specific property names */
            'title': $(".new-note-title").val(), //updating the note title
            'content': $(".new-note-body").val(), //Updating note body content
            'status': 'publish' //Cause by default the status is draft, and the note won't appear on the front-end 
            //Could also set to 'private' etc, but we are using filtering hook which is safer (in functions.php)
        }

        $.ajax({ //Ajax method is a great option when you want to be able to control what type of request you're sending //POST, DELETE etc..
            beforeSend: (xhr) => { //XHR - XML HTTP REQUEST, this is to prove to wordpress our authenticity
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/', //Url the API Call will be made to
            type: 'POST', //Http request type
            data: ourNewNote, //Pass the new note object with the POST request
            success: (response) => { //in case of success

                $(".new-note-title, .new-note-body").val(''); //When note created, empty the text fields
                //Now adding html template literal
                $(`
                    <li data-id="${ response.id }">
                    <input readonly class="note-title-field" type="text" value="${ response.title.raw }">

                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>

                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>

                    <textarea readonly class="note-body-field">${ response.content.raw }</textarea>

                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                </li>
                `).prependTo("#my-notes").hide().slideDown(); //To slowly fade in the new note

                console.log("Note Successfully created!");
                console.log(response);
            },
            error: (response) => { //in case of error
                console.log("Error");
                console.log(response);
            }
        });
    }

    editNote(event) {
        
        const thisNote = $(event.target).parents("li"); //To get info which delete button got clicked on (targeting children of li element)

        if (thisNote.data("state") == "editable") { //if edit mode is on, use cancel method
            this.makeNoteReadOnly(thisNote);
        } else { //If note is currently read-only, use edit method
            this.makeNoteEditable(thisNote);
        }
        
    }

    makeNoteEditable(thisNote) {
        thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i>Cancel'); //If in edit mode, show cancel button

        //To remove the readonly html attribute and add borders for editing notes!
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");

        thisNote.find(".update-note").addClass("update-note--visible");

        thisNote.data("state", "editable"); //To toggle between edit and close
    }

    makeNoteReadOnly(thisNote) {
        thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit'); //If in edit mode, show cancel button

        //To remove the readonly html attribute and add borders for editing notes!
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");

        thisNote.find(".update-note").removeClass("update-note--visible");

        thisNote.data("state", "cancel"); //To toggle between edit and close
    }
}

export default MyNotes;