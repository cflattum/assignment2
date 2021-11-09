let storedcity = localStorage.getItem("city");

if(storedcity)
{
    $("#bgInput").val(storedcity);
}

let city1 = $("#bgInput").val();

$.ajax({
    method:"GET",
     url:"https://api.weatherbit.io/v2.0/current",
     data:{
         city: city1,
         key: "be3c2e55e92e49f988c909ebed429653",
         units: "I"
            
       }
})
.done(function(results) {
    displayResults((results));
})
.fail(function(results) {
    console.log("API FAIL");
    console.log(city1);
});

function displayResults(results){
    let weathertextt = $("#weathertext");

    
    let length = Object.keys(results.data[0]).length;
  
    
    let temp1 = results.data[0].temp;
    console.log(temp1);
    let description1 = results.data[0].weather.description;
    console.log(description1);
    let feelslike = results.data[0].app_temp;
    console.log(feelslike);
    let cityname = results.data[0].city_name;
    
    let toDisplay = "Today's Temperature in "+ cityname + ": " + temp1 + " " + description1 + ". Feels like: " + feelslike;
    console.log(toDisplay);
    $("#weathertext").text(toDisplay);
}

//document.querySelector("#bgInput").onchange = function()
$("#bgInput").change(function() {
    let city2 = $("#bgInput").val();

    $.ajax({
        method:"GET",
        url:"https://api.weatherbit.io/v2.0/current",
        data:{
            city: city2,
            key: "65335c6e61dd4c0c97e79565960ca980",
            units: "I"
            
        }
    })
    .done(function(results) {
        displayResults((results));
    })
    .fail(function(results) {
        console.log("API FAIL");
    });

    localStorage.setItem("city",city2);


});

$("#fname").keypress(function(e) {
    if (e.which == 13) {
        let todotext = $("#fname").val();
        console.log(todotext);
        $("#todolistitems").append("<div>" + "<i class=\"fas fa-camera\"></i>" + "<span> " + todotext + "</span>" + "</div>");
        $("#fname").val('');
    }
})

//$("#list li").innerHTML.on("click", function() {
 //   $("#list li").addClass("text-decoration: line-through");
//});

$("#todolistitems").on("click", ".fas", function() {
    console.log($(this).parent('div'));

    $(this).parent('div').remove();

});

$("#todolistitems").on("click", "span", function() {
    
    console.log($(this).css("text-decoration"));
    if($(this).css("text-decoration") == "line-through solid rgb(255, 0, 0)")
    {
        
        $(this).css("text-decoration", "none");
        $(this).css("color", "black");
    }
    else
    {
    $(this).css("text-decoration", "line-through");
    $(this).css("color", "red");
    }

});

$("#plus").on("click",  function() {
    if($("#fname").is(":hidden"))
    {
        $("#fname").show();
    }
    else
    {
        $("#fname").hide();
    }

});

storedcity = localStorage.getItem("city");

if(storedcity)
{
    $("#bgInput").val(storedcity);
}
