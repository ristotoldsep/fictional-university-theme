import $ from "jquery";

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".like-box").on("click", this.ourClickDispatcher.bind(this));
    }

    //Custom methods

    //Deciding whether to call createLike or deleteLike
    ourClickDispatcher() {
        if ($(".like-box").data('exists') == 'yes') {
            this.deleteLike();
        } else {
            this.createLike();
        }
    }

    createLike() {
        alert("Liked!");
    }

    deleteLike() {
        alert("Disliked!");
    }
}

export default Like;