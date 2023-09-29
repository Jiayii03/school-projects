function shuffle() {
    var c = document.getElementsByClassName('pic');
    for (var i = 0; i < c.length; i++) {
        c[i].classList.add('animate');
    }
  }

function showModal(){
  document.querySelector('.modal').id = 'show';
}

function shuffle() {
  var c = document.getElementsByClassName('pic');
  for (var i = 0; i < c.length; i++) {
      c[i].classList.add('animate');
  }
}

function displayModal(){
  // alert("HELLO");  
  document.getElementById("modal").style.display = "inline";
}

function closeModal(){
  document.querySelector(".modal").id = "hide";
}

// function shuffle(array) {
//   let currentIndex = array.length,  randomIndex;

//   // While there remain elements to shuffle.
//   while (currentIndex != 0) {

//     // Pick a remaining element.
//     randomIndex = Math.floor(Math.random() * currentIndex);
//     currentIndex--;

//     // And swap it with the current element.
//     [array[currentIndex], array[randomIndex]] = [
//       array[randomIndex], array[currentIndex]];
//   }

//   return array;
// }

// Used like so
var arr = [2, 11, 37, 42];
shuffle(arr);
console.log(arr);

function randomChoice(){
  let cake;
  
  arr = ['Strawberry Cream Chiffon', 'Mango Cream Chiffon', 'Carrot Walnut Cake', 'Pinata Cake', 'Chocolate Classic Vintage Cake']
  cake = arr[Math.floor(Math.random() * arr.length)];
  console.log(cake);

  document.getElementById("displayChoice").innerHTML = `"${cake}"`;

   
}

window.addEventListener("load", function(){
  setTimeout(
      function open(event){
          document.querySelector(".popup").style.display = "block";
          document.querySelector(".popupinside").style.display = "block";
      },
      500 
  )
});

// document.querySelector("#close").addEventListener("click", function(){
//   alert("BYEBYE");
//   document.querySelector(".popup").style.display = "none";
//   document.querySelector(".popupinside").style.display = "none";
// });

function closePopUp(){
  // alert("BYEBYE");
  document.querySelector(".popup").style.display = "none";
  document.querySelector(".popupinside").style.display = "none";
}

function reloadPage(){
  location.reload()
}

function linkToCart(){
  document.location.href = "../cart/cart.html"
}
