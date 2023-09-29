function shuffle(array) {
    var currentIndex = array.length,
      randomIndex;
  
    // While there remain elements to shuffle...
    while (0 !== currentIndex) {
      // Pick a remaining element...
      randomIndex = Math.floor(Math.random() * currentIndex);
      currentIndex--;
  
      // And swap it with the current element.
      [array[currentIndex], array[randomIndex]] = [ array[randomIndex], array[currentIndex],];
    }
  
    return array;
  }
  
  function spin() {
//     // Play the sound
    wheelspin.play();
    // Inisialisasi variabel
    const box = document.getElementById("box");
    const element = document.getElementById("mainbox");
    let SelectedItem = "";
  
//     // Shuffle 450 because class box1 has been added 90 degrees at the beginning. minus 40 per item so that the position of the arrow fits in the middle.
//      // Each item has a 12.5% win except the bike item which only has about a 4% chance of winning.
//      // Items in the form of ipad and samsung tab will never win.
//      // let Bike = shuffle ([2210]); // Probability: 33% or 1/3
    let Pandan = shuffle([1890, 2250, 2610]);
    let WhiteCLassic = shuffle([1850, 2210, 2570]); //Kemungkinan : 100%
    let Strawberry = shuffle([1810, 2170, 2530]);
    let MiniCream = shuffle([1770, 2130, 2490]);
    let OreoCream = shuffle([1750, 2110, 2470]);
    let CrepeCake = shuffle([1630, 1990, 2350]);
    let Mango = shuffle([1570, 1930, 2290]);
  
//     // Bentuk acak
    let results = shuffle([
      Pandan[0],
      WhiteCLassic[0],
      Strawberry[0],
      MiniCream[0],
      OreoCream[0],
      CrepeCake[0],
      Mango[0],
    ]);
//     // console.log(results[0]);
  
//     // Ambil value item yang terpilih
    if (Pandan.includes(results[0])) SelectedItem = "Pandan Cream Chiffon";
    if (WhiteCLassic.includes(results[0])) SelectedItem = "White CLassic Vintage Cake";
    if (Strawberry.includes(results[0])) SelectedItem = "Strawberry Cream Chiffon";
    if (MiniCream.includes(results[0])) SelectedItem = "Mini Cream Chiffon";
    if (OreoCream.includes(results[0])) SelectedItem = "Oreo Cream Chiffon";
    if (CrepeCake.includes(results[0])) SelectedItem = "Crepe Cake";
    if (Mango.includes(results[0])) SelectedItem = "Mango Cream Chiffon";
  
//     // Proses
    box.style.setProperty("transition", "all ease 5s");
    box.style.transform = "rotate(" + results[0] + "deg)";
    element.classList.remove("animate");
    setTimeout(function() {
      element.classList.add("animate");
    }, 5000);
  
//     // Munculkan Alert
    setTimeout(function() {
      applause.play();
      swal(
        "Congratulations",
        "You Won The " + SelectedItem + ".",
        "success"   
      );
    }, 5500);
  
//     // Delay and set to normal state
    setTimeout(function() {
      box.style.setProperty("transition", "initial");
      box.style.transform = "rotate(90deg)";
    }, 6000);
  }