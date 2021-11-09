//function called when page is loaded
//displays all the stuffs
window.onload = function onpageload(){
    let allendpoint = "https://api.themoviedb.org/3/movie/now_playing?api_key=eae4bbc99c117dc3713a04a6d0adcb3b&language=en-US&page=1";

     ajax(allendpoint, displayResults);
}


//test for loading full results using search button
document.querySelector("#search-form").onsubmit = function(event){
    console.log("hi");
    event.preventDefault();

    let searchtext = document.querySelector("#searchbox").value.trim();

    let searchfirsttext = "https://api.themoviedb.org/3/search/movie?api_key=eae4bbc99c117dc3713a04a6d0adcb3b&language=en-US&query=";
    let searchendpoint = searchfirsttext + searchtext + "&page=1&include_adult=false";

    ajax(searchendpoint, displayResults);
}

function displayResults(response){
    let JSresponse = JSON.parse(response);
	console.log(JSresponse);
	

    //clear out old search results
    //works
    let searchbody = document.querySelector("#movierows");
    while(searchbody.hasChildNodes())
    {
        searchbody.removeChild(searchbody.lastChild);
    }

	//display number of results
    document.querySelector("#showing-results").innerHTML = JSresponse.results.length;
    document.querySelector("#total-results").innerHTML = JSresponse.total_results;

    //display actual results 
    for( let i = 0; i < JSresponse.results.length; i++) {
        //create div and add class to it
        let divelement = document.createElement("div");
        divelement.className += ("col-6 col-sm-6 col-md-4 col-lg-3");

        //get image and combine with source to get right file
        let imgElement = document.createElement("img");
        let baseimgstring = "https://image.tmdb.org/t/p/w185";
        let imgstring = JSresponse.results[i].poster_path;
        console.log(imgstring);

        //set image to display SRC to correct source
        imgElement.src = baseimgstring + imgstring;

        if(!imgstring)
        {
            imgElement.src = "images/noavail.webp"
            console.log("its working");
        }

        divelement.appendChild(imgElement);

        //rating
        let rating = document.createElement("div");
        rating.innerHTML = "Rating: " + JSresponse.results[i].vote_average;
        rating.style.color = "black";
        rating.id = "overlay";
        divelement.appendChild(rating);

        //votes
        let votes = document.createElement("div");
        votes.innerHTML = "Votes: " + JSresponse.results[i].vote_count;
        votes.classList.add("top-left");
        votes.style.color = "black";
        votes.id = "overlay1";
        divelement.appendChild(votes);

        //description
        let description = document.createElement("div");
        description.innerHTML = JSresponse.results[i].overview;
        description.classList.add("top-left");
        description.style.color = "black";
        description.id = "overlay2";

         //limits number of characters to 200
         if(description.innerHTML.length >= 200)
         {
             description.innerHTML = description.innerHTML.substring(0,200);
             description.innerHTML += "...";
         }
 
         divelement.appendChild(description);

        //name
        let nameelement = document.createElement("p");
        nameelement.innerHTML = JSresponse.results[i].original_title;
        divelement.appendChild(nameelement);

        //date
        let dateelement = document.createElement("p");
        dateelement.innerHTML = JSresponse.results[i].release_date;
        divelement.appendChild(dateelement);
        
        //add div element to movierows
        document.querySelector("#movierows").appendChild(divelement);
    }
}

//this function makes an api call using a given endpoint,
// and calls a function using the response text
function ajax(end, displayResults)
{
    let httpRequest = new XMLHttpRequest();

    httpRequest.open("GET", end);

    httpRequest.send();

    httpRequest.onreadystatechange = function(){
        if(httpRequest.readyState == 4) {
			// We have a response from API!
			if(httpRequest.status == 200) {
                displayResults(httpRequest.responseText);
            }
        }
    }
}


var test = document.querySelectorAll("#movierows");

for(let i = 0; i < test.length; i++)
{
    test[i].onmouseover = function(){
        document.querySelector("#overlay").classList.visibility = "1";
        document.querySelector("#overlay1").classList.visibility = "visible";
        document.querySelector("#overlay2").classList.visibility = "visible";
        console.log("hey");
    }

    test[i].onmouseexit = function(){
        document.querySelector("#overlay").classList.visibility = "hidden";
        document.querySelector("#overlay1").classList.visibility = "hidden";
        document.querySelector("#overlay2").classList.visibility = "hidden";
        console.log("bye");
    }



}


