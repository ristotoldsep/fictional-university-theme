import $ from "jquery";

class Like {
    constructor() {
        this.events(); //Means that our event listeners get added as soon as the page loads!
    }

    events() {
        $(".like-box").on("click", this.ourClickDispatcher.bind(this)); //ourClickDispatcher passes along data (event)
    }

    //Custom methods

    //Deciding whether to call createLike or deleteLike
    ourClickDispatcher(event) {
        const currentLikeBox = $(event.target).closest(".like-box"); //Setting this up, because users might click on the heart icon/number, not the gray like box - MAKING JS FLEXIBLE

        if (currentLikeBox.data('exists') == 'yes') {
            this.deleteLike();
        } else {
            this.createLike();
        }
    }

    createLike() {
        $.ajax({
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'POST',
            success: (response) => {
                console.log("Success!!!!!!");
                console.log(response);
            },
            error: (response) => {
                console.log("Error!!!!!!");
                console.log(response);
            }
        });
    }

    deleteLike() {
        $.ajax({
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'DELETE',
            success: (response) => {
                console.log("Success!!!!!!");
                console.log(response);
            },
            error: (response) => {
                console.log("Error!!!!!!");
                console.log(response);
            }
        });
    }
}

export default Like;