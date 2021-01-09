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
                if (response.userNoteCount < 6) {
                    $(".note-limit-message").removeClass("active");
                }
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
                if (response.responseText == "You have reached your note limit.") {
                    $(".note-limit-message").addClass("active");
                }
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
/* 
JQUERY FREE DUPLICATE CODE WITH AXIOS

import axios from "axios"

class MyNotes {
    constructor() {
        if (document.querySelector("#my-notes")) {
            axios.defaults.headers.common["X-WP-Nonce"] = universityData.nonce
            this.myNotes = document.querySelector("#my-notes")
            this.events()
        }
    }

    events() {
        this.myNotes.addEventListener("click", e => this.clickHandler(e))
        document.querySelector(".submit-note").addEventListener("click", () => this.createNote())
    }

    clickHandler(e) {
        if (e.target.classList.contains("delete-note") || e.target.classList.contains("fa-trash-o")) this.deleteNote(e)
        if (e.target.classList.contains("edit-note") || e.target.classList.contains("fa-pencil") || e.target.classList.contains("fa-times")) this.editNote(e)
        if (e.target.classList.contains("update-note") || e.target.classList.contains("fa-arrow-right")) this.updateNote(e)
    }

    findNearestParentLi(el) {
        let thisNote = el
        while (thisNote.tagName != "LI") {
            thisNote = thisNote.parentElement
        }
        return thisNote
    }

    // Methods will go here
    editNote(e) {
        const thisNote = this.findNearestParentLi(e.target)

        if (thisNote.getAttribute("data-state") == "editable") {
            this.makeNoteReadOnly(thisNote)
        } else {
            this.makeNoteEditable(thisNote)
        }
    }

    makeNoteEditable(thisNote) {
        thisNote.querySelector(".edit-note").innerHTML = '<i class="fa fa-times" aria-hidden="true"></i> Cancel'
        thisNote.querySelector(".note-title-field").removeAttribute("readonly")
        thisNote.querySelector(".note-body-field").removeAttribute("readonly")
        thisNote.querySelector(".note-title-field").classList.add("note-active-field")
        thisNote.querySelector(".note-body-field").classList.add("note-active-field")
        thisNote.querySelector(".update-note").classList.add("update-note--visible")
        thisNote.setAttribute("data-state", "editable")
    }

    makeNoteReadOnly(thisNote) {
        thisNote.querySelector(".edit-note").innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit'
        thisNote.querySelector(".note-title-field").setAttribute("readonly", "true")
        thisNote.querySelector(".note-body-field").setAttribute("readonly", "true")
        thisNote.querySelector(".note-title-field").classList.remove("note-active-field")
        thisNote.querySelector(".note-body-field").classList.remove("note-active-field")
        thisNote.querySelector(".update-note").classList.remove("update-note--visible")
        thisNote.setAttribute("data-state", "cancel")
    }

    async deleteNote(e) {
        const thisNote = this.findNearestParentLi(e.target)

        try {
            const response = await axios.delete(universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.getAttribute("data-id"))
            thisNote.style.height = `${thisNote.offsetHeight}px`
            setTimeout(function () {
                thisNote.classList.add("fade-out")
            }, 20)
            setTimeout(function () {
                thisNote.remove()
            }, 401)
            if (response.data.userNoteCount < 5) {
                document.querySelector(".note-limit-message").classList.remove("active")
            }
        } catch (e) {
            console.log("Sorry")
        }
    }

    async updateNote(e) {
        const thisNote = this.findNearestParentLi(e.target)

        var ourUpdatedPost = {
            "title": thisNote.querySelector(".note-title-field").value,
            "content": thisNote.querySelector(".note-body-field").value
        }

        try {
            const response = await axios.post(universityData.root_url + "/wp-json/wp/v2/note/" + thisNote.getAttribute("data-id"), ourUpdatedPost)
            this.makeNoteReadOnly(thisNote)
        } catch (e) {
            console.log("Sorry")
        }
    }

    async createNote() {
        var ourNewPost = {
            "title": document.querySelector(".new-note-title").value,
            "content": document.querySelector(".new-note-body").value,
            "status": "publish"
        }

        try {
            const response = await axios.post(universityData.root_url + "/wp-json/wp/v2/note/", ourNewPost)

            if (response.data != "You have reached your note limit.") {
                document.querySelector(".new-note-title").value = ""
                document.querySelector(".new-note-body").value = ""
                document.querySelector("#my-notes").insertAdjacentHTML(
                    "afterbegin",
                    ` <li data-id="${response.data.id}" class="fade-in-calc">
            <input readonly class="note-title-field" value="${response.data.title.raw}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${response.data.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          </li>`
                )

                // notice in the above HTML for the new <li> I gave it a class of fade-in-calc which will make it invisible temporarily so we can count its natural height

                let finalHeight // browser needs a specific height to transition to, you can't transition to 'auto' height
                let newlyCreated = document.querySelector("#my-notes li")

                // give the browser 30 milliseconds to have the invisible element added to the DOM before moving on
                setTimeout(function () {
                    finalHeight = `${newlyCreated.offsetHeight}px`
                    newlyCreated.style.height = "0px"
                }, 30)

                // give the browser another 20 milliseconds to count the height of the invisible element before moving on
                setTimeout(function () {
                    newlyCreated.classList.remove("fade-in-calc")
                    newlyCreated.style.height = finalHeight
                }, 50)

                // wait the duration of the CSS transition before removing the hardcoded calculated height from the element so that our design is responsive once again
                setTimeout(function () {
                    newlyCreated.style.removeProperty("height")
                }, 450)
            } else {
                document.querySelector(".note-limit-message").classList.add("active")
            }
        } catch (e) {
            console.error(e)
        }
    }
}

export default MyNotes
 */