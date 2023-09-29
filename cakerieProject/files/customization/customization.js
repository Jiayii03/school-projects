const multiStepForm = document.querySelector("[data-multi-step]")
const formSteps = [...multiStepForm.querySelectorAll("[data-step]")]

let currentStep = formSteps.findIndex(step => {
    return step.classList.contains("active")
})

if (currentStep < 0){
    currentStep = 0
    showCurrentStep()
}

multiStepForm.addEventListener("click", e => {
    if (e.target.matches("[data-next]")) {
        currentStep += 1
    } else if (e.target.matches("[data-previous]")){
        currentStep -= 1
    }
    showCurrentStep()
})

function cakeType(that){
    if (that.value == "Standard Cake"){
        document.getElementById("standard-cake").style.display = "block";
    }
    else{
        document.getElementById("standard-cake").style.display = "none";
    }
    if (that.value == "Special Cake"){
        document.getElementById("special-cake").style.display = "block";
    }
    else{
        document.getElementById("special-cake").style.display = "none";
    }
}


function showCurrentStep(){
    formSteps.forEach((step, index) => {
        step.classList.toggle("active", index === currentStep)
    })
}


function changeCaketoWhite(){
    document.getElementById("cake-top").style.backgroundColor = "rgb(221, 222, 207)";
    document.getElementById("cake-middle").style.backgroundColor = "rgb(248, 249, 232)";
    document.getElementById("cake-bottom").style.backgroundColor = "rgb(248, 249, 232)";
}

function changeCaketoYellow(){
    document.getElementById("cake-top").style.backgroundColor = "rgb(213, 218, 153)";
    document.getElementById("cake-middle").style.backgroundColor = "rgb(242, 248, 151)";
    document.getElementById("cake-bottom").style.backgroundColor = "rgb(242, 248, 151)";
}

function changeCaketoOrange(){
    document.getElementById("cake-top").style.backgroundColor = "rgb(215, 169, 113)";
    document.getElementById("cake-middle").style.backgroundColor = "rgb(251, 176, 77)";
    document.getElementById("cake-bottom").style.backgroundColor = "rgb(251, 176, 77)";
}

function changeCaketoRed(){
    document.getElementById("cake-top").style.backgroundColor = "rgb(118, 57, 72)";
    document.getElementById("cake-middle").style.backgroundColor = "#962d33";
    document.getElementById("cake-bottom").style.backgroundColor = "#962d33";
}

function changeCaketoPink(){
    document.getElementById("cake-top").style.backgroundColor = "#c29191";
    document.getElementById("cake-middle").style.backgroundColor = "#E9ACAB";
    document.getElementById("cake-bottom").style.backgroundColor = "#E9ACAB";
}

function changeCaketoChocolate(){
    document.getElementById("cake-top").style.backgroundColor = "#895a41";
    document.getElementById("cake-middle").style.backgroundColor = "#B17251";
    document.getElementById("cake-bottom").style.backgroundColor = "#B17251";
}

function changeCaketoGreen(){
    document.getElementById("cake-top").style.backgroundColor = "#7d8c33";
    document.getElementById("cake-middle").style.backgroundColor = "#A1B440";
    document.getElementById("cake-bottom").style.backgroundColor = "#A1B440";
}

function whiteIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#ede6d0";
    document.querySelector(".icing").style.backgroundColor = "#F5EACC";
    document.querySelector(".drip2").style.backgroundColor = "#ede6d0";
    document.querySelector(".drip3").style.backgroundColor = "#ede6d0";
    document.querySelector(".drip4").style.backgroundColor = "#ede6d0";
    document.querySelector(".drip5").style.backgroundColor = "#ede6d0";
}

function yellowIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#f4e79d";
    document.querySelector(".icing").style.backgroundColor = "#fff29f";
    document.querySelector(".drip2").style.backgroundColor = "#f4e79d";
    document.querySelector(".drip3").style.backgroundColor = "#f4e79d";
    document.querySelector(".drip4").style.backgroundColor = "#f4e79d";
    document.querySelector(".drip5").style.backgroundColor = "#f4e79d";
}

function orangeIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#edae6a";
    document.querySelector(".icing").style.backgroundColor = "#ffb567";
    document.querySelector(".drip2").style.backgroundColor = "#edae6a";
    document.querySelector(".drip3").style.backgroundColor = "#edae6a";
    document.querySelector(".drip4").style.backgroundColor = "#edae6a";
    document.querySelector(".drip5").style.backgroundColor = "#edae6a";
}

function redIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#db6f68";
    document.querySelector(".icing").style.backgroundColor = "#ed736a";
    document.querySelector(".drip2").style.backgroundColor = "#db6f68";
    document.querySelector(".drip3").style.backgroundColor = "#db6f68";
    document.querySelector(".drip4").style.backgroundColor = "#db6f68";
    document.querySelector(".drip5").style.backgroundColor = "#db6f68";
}

function pinkIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#eba3d3";
    document.querySelector(".icing").style.backgroundColor = "#ffabe3";
    document.querySelector(".drip2").style.backgroundColor = "#eba3d3";
    document.querySelector(".drip3").style.backgroundColor = "#eba3d3";
    document.querySelector(".drip4").style.backgroundColor = "#eba3d3";
    document.querySelector(".drip5").style.backgroundColor = "#eba3d3";
}

function purpleIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#d2acf0";
    document.querySelector(".icing").style.backgroundColor = "#d9acff";
    document.querySelector(".drip2").style.backgroundColor = "#d2acf0";
    document.querySelector(".drip3").style.backgroundColor = "#d2acf0";
    document.querySelector(".drip4").style.backgroundColor = "#d2acf0";
    document.querySelector(".drip5").style.backgroundColor = "#d2acf0";
}

function blueIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "rgb(187, 232, 244)";
    document.querySelector(".icing").style.backgroundColor = "#BAEFFE";
    document.querySelector(".drip2").style.backgroundColor = "rgb(187, 232, 244)";
    document.querySelector(".drip3").style.backgroundColor = "rgb(187, 232, 244)";
    document.querySelector(".drip4").style.backgroundColor = "rgb(187, 232, 244)";
    document.querySelector(".drip5").style.backgroundColor = "rgb(187, 232, 244)";
}

function greenIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#afe7a2";
    document.querySelector(".icing").style.backgroundColor = "#b2f3a3";
    document.querySelector(".drip2").style.backgroundColor = "#afe7a2";
    document.querySelector(".drip3").style.backgroundColor = "#afe7a2";
    document.querySelector(".drip4").style.backgroundColor = "#afe7a2";
    document.querySelector(".drip5").style.backgroundColor = "#afe7a2";
}

function chocolateIcing(){
    document.getElementById("cream").style.visibility = "visible";
    document.querySelector(".drip").style.backgroundColor = "#6d362a";
    document.querySelector(".icing").style.backgroundColor = "#7A3C2E";
    document.querySelector(".drip2").style.backgroundColor = "#6d362a";
    document.querySelector(".drip3").style.backgroundColor = "#6d362a";
    document.querySelector(".drip4").style.backgroundColor = "#6d362a";
    document.querySelector(".drip5").style.backgroundColor = "#6d362a";
}

function addNuts(){
    document.getElementById("nuts-topping").style.visibility = "visible";
    document.getElementById("sprinkle").style.visibility = "hidden";
    document.getElementById("fruit-topping").style.visibility = "hidden";
}

function addSprinkles(){
    document.getElementById("sprinkle").style.visibility = "visible";
    document.getElementById("nuts-topping").style.visibility = "hidden";
    document.getElementById("fruit-topping").style.visibility = "hidden";
}

function addFruits(){
    document.getElementById("fruit-topping").style.visibility = "visible";
    document.getElementById("nuts-topping").style.visibility = "hidden";
    document.getElementById("sprinkle").style.visibility = "hidden";
}

function enableTextBot(){
    let textbox = document.getElementById("idea");
    let check = document.getElementById("others");
    textbox.disabled = check.checked? false: true;
    if (!textbox.disabled){
        textbox.focus();
    }
}

function displayOrder(){
    let cakeType = document.getElementById("type");
    let chosenType = cakeType.options[cakeType.selectedIndex];
    document.getElementById('selectedType').innerHTML = chosenType.value;

    let layer = document.getElementsByName("layer");
    for(i=0; i<layer.length; i++){
        if(layer[i].checked)
        document.getElementById("layers").innerHTML = layer[i].value;
    }

    let flavour = document.getElementsByName("flavour");
    for(i=0; i<flavour.length; i++){
        if(flavour[i].checked)
        document.getElementById("flat-cake-flavour").innerHTML = flavour[i].value;
    }

    let icing = document.getElementsByName("colour");
    for(i=0; i<icing.length; i++){
        if(icing[i].checked)
        document.getElementById("icingColour").innerHTML = icing[i].value;
    }

    let toppings = document.getElementsByName("toppings");
    for(i=0; i<toppings.length; i++){
        if(toppings[i].checked)
        document.getElementById("cakeTopping").innerHTML = toppings[i].value;
    }

    let cakeSize = document.getElementsByName("size");
    for (i=0; i<cakeSize.length; i++){
        if(cakeSize[i].checked)
        document.getElementById("inches").innerHTML = cakeSize[i].value;
    }

    let cakeTheme = document.getElementsByName("cake-theme");
    for (i=0; i<cakeTheme.length; i++){
        if(cakeTheme[i].checked)
        document.getElementById("finalTheme").innerHTML = cakeTheme[i].value;
    }

    const request = document.getElementById("add-ons");
    const output = document.getElementById("displayAddOn");
    output.innerHTML = request.value;

}


function changeIcing(finalIcing){
    document.getElementById('icingColour').innerHTML = finalIcing.innerHTML;
}

function changeTopping(finalTopping){
    document.getElementById('cakeTopping').innerHTML = finalTopping.innerHTML;
}

