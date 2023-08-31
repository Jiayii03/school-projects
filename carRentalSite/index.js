// banner slideshow
var index = 0;//number of looping//
var i = 0;
var images = document.getElementsByClassName("slide");

auto();

function show(n){
    for(i = 0;i < images.length; i++){
        images[i].style.display = "none";
    }
    images[n-1].style.display = "block";
}
function auto(){
    index++;
    if(index > images.length){
    index = 1;
    }
    show(index);
    setTimeout(auto,3000);
}