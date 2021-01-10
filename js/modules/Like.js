
//COMMENTED CODE WITH JQUERY IS BELOW
import axios from "axios"

class Like {
  constructor() {
      //WE ONLY NEED TO RUN THIS JS IF WE ARE ON A PAGE THAT CONTAINS THE ELEMENT LIKE BOX
    if (document.querySelector(".like-box")) {
      axios.defaults.headers.common["X-WP-Nonce"] = universityData.nonce
      this.events()
    }
  }

  events() {
    document.querySelector(".like-box").addEventListener("click", e => this.ourClickDispatcher(e))
  }

  // methods
  ourClickDispatcher(e) {
    let currentLikeBox = e.target
    while (!currentLikeBox.classList.contains("like-box")) {
      currentLikeBox = currentLikeBox.parentElement
    }

    if (currentLikeBox.getAttribute("data-exists") == "yes") {
      this.deleteLike(currentLikeBox)
    } else {
      this.createLike(currentLikeBox)
    }
  }

  async createLike(currentLikeBox) {
    try {
      const response = await axios.post(universityData.root_url + "/wp-json/university/v1/manageLike", { "professorID": currentLikeBox.getAttribute("data-professor") })
      if (response.data != "Only logged in users can create a like.") {
        currentLikeBox.setAttribute("data-exists", "yes")
        var likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
        likeCount++
        currentLikeBox.querySelector(".like-count").innerHTML = likeCount
        currentLikeBox.setAttribute("data-like", response.data)
      } else {
          alert("You must be logged in to like a professor!");
      }
      console.log(response.data)
    } catch (e) {
      console.log("Sorry")
    }
  }

  async deleteLike(currentLikeBox) {
    try {
      const response = await axios({
        url: universityData.root_url + "/wp-json/university/v1/manageLike",
        method: 'delete',
        data: { "like": currentLikeBox.getAttribute("data-like") },
      })
      currentLikeBox.setAttribute("data-exists", "no")
      var likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
      likeCount--
      currentLikeBox.querySelector(".like-count").innerHTML = likeCount
      currentLikeBox.setAttribute("data-like", "")
      console.log(response.data)
    } catch (e) {
      console.log(e)
    }
  }
}

export default Like

/* import $ from "jquery";

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
        let currentLikeBox = $(event.target).closest(".like-box"); //Setting this up, because users might click on the heart icon/number, not the gray like box - MAKING JS FLEXIBLE

        if (currentLikeBox.attr('data-exists') == 'yes') { //If you want to pull in fresh updated attribute values always use attr
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox); //Passing currentLikeBox to access .likebox html element and it's data-professorid attribute
        }
    }

    createLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => { //XHR - XML HTTP REQUEST, this is to prove to wordpress our authenticity
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'POST',
            data: {
                'professorID': currentLikeBox.attr('data-professorid')  //THIS COMES FROM HTML ATTR data-professorid //BASICALLY '/wp-json/university/v1/manageLike?professorID=789'
            },
            success: (response) => { 

                currentLikeBox.attr('data-exists', 'yes'); //THIS WILL FILL THE HEART ICON

                let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10); //ADD 1 TO the like counter:D
                likeCount++; 
                currentLikeBox.find(".like-count").html(likeCount);

                currentLikeBox.attr("data-like", response); //Setting the data like attr in html on the fly, response returs the id nr of the new like post!

                console.log("Like added!!!!!!");
                console.log(response);
            },
            error: (response) => {
                // console.log("Error!!!!!!");
                console.log(response);
            }
        });
    }

    deleteLike(currentLikeBox) {
        $.ajax({
            beforeSend: (xhr) => { //XHR - XML HTTP REQUEST, this is to prove to wordpress our authenticity
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            data: {
                'like': currentLikeBox.attr('data-like') //ID OF THE LIKE POST WE WANT TO DELETE
            },
            type: 'DELETE',
            success: (response) => {

                currentLikeBox.attr('data-exists', 'no'); //THIS WILL FILL THE HEART ICON

                let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10); //Subtract 1 from the like counter:D
                likeCount--;
                currentLikeBox.find(".like-count").html(likeCount);

                currentLikeBox.attr("data-like", ''); //Setting the data like attr in html on the fly, response returs the id nr of the new like post!

                //console.log("Like deleted!!!!!!");
                console.log(response);
            },
            error: (response) => {
                console.log("Error!!!!!!");
                console.log(response);
            }
        });
    }
}

export default Like; */

