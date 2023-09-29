//shipping option dropdown menu
const selected = document.querySelector(".selected");
const optionsContainer = document.querySelector(".options-container");

const optionsList = document.querySelectorAll(".option");

selected.addEventListener("click", () =>{
    optionsContainer.classList.toggle("active");
});

optionsList.forEach( o => {
    o.addEventListener("click", () => {
        selected.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer.classList.remove("active");
    })
})

//clicking the remove button to delete cart, specific_price --> RM0.00
let removeCartItemButtons = document.getElementsByClassName("btn-remove");
let prices = document.getElementsByClassName("specific_price");
console.log(removeCartItemButtons);
for (let i = 0; i < removeCartItemButtons.length; i++){
    let button = removeCartItemButtons[i];
    let price = prices[i].innerHTML;
    button.addEventListener("click", function(event){
        // console.log("clicked")
        let buttonClicked = event.target;
        buttonClicked.parentElement.parentElement.parentElement.parentElement.remove();
        priceFloat = parseFloat(price);
        console.log(priceFloat);
        priceFloat = 0;
        calculateSubtotal();
        calculateGrandTotal();
    });
};

//calculating total price via quantity
function calculateTotalPrice(i, price){
    let itemQuantity = document.getElementsByClassName("input_quantity");
    let displayPrice = document.getElementsByClassName("specific_price");
    let quantity = itemQuantity[i];
    quantityInt = parseInt(quantity.value);
    totalPrice = (quantityInt * price).toFixed(2);
    displayPrice[i].innerHTML = totalPrice;
}

//press enter to trigger function
let inputs = document.getElementsByClassName("input_quantity");
// console.log(inputs);
let buttons = document.getElementsByClassName("hidden_btn");
// console.log(buttons);
for(i = 0; i < inputs.length; i++){
    let input = inputs[i];
    // console.log(input);
    let button = buttons[i];
    // console.log(button);
    input.addEventListener("keyup", e => {
        e.preventDefault();
        if(e.keyCode === 13){
            console.log("Enter is pressed!");
            button.click();
        }
    });
}

//Items subtotal, service tax
function calculateSubtotal(){
    let prices = document.getElementsByClassName("specific_price");
    console.log(prices);
    total = 0;
    for(i = 0; i < prices.length; i++){
        let price = prices[i].innerHTML;
        priceFloat = parseFloat(price);
        console.log(priceFloat);
        total += priceFloat;
        totalFixed = total.toFixed(2);
    }
    // console.log(totalFixed);
    document.querySelector(".subtotal_span").innerHTML = totalFixed;
    serviceTax = (totalFixed * 0.06).toFixed(2);
    document.querySelector(".service_tax_span").innerHTML = serviceTax;
}

//display shipping fee
function displayShippingFee(){
    let standard = document.getElementById("standard");
    let express = document.getElementById("express");
    let self = document.getElementById("self");
    let shippingFee;

    if(standard.checked == true){
        shippingFee = 3.50;
        // console.log("HELLO");
    }

    else if(express.checked == true){
        shippingFee = 5.50;
    }

    else if(self.checked == true){
        shippingFee = 0.00;
    }

    shippingFeeFixed = shippingFee.toFixed(2);
    document.querySelector(".shipping_fee_span").innerHTML = shippingFeeFixed;
}

//Apply Discount Code
function checkDiscountCode(){
    let discountPrice;
    discountCode = document.getElementById("input_code").value;
    if(discountCode == "ABCDE"){
        discountPrice = 6;
        discountPriceFixed = discountPrice.toFixed(2);
        document.querySelector(".discount_price_span").innerHTML = discountPriceFixed; 
    }else{
        alert("Invalid discount code applied!");
        discountPrice = 0;
        discountPriceFixed = discountPrice.toFixed(2);
        document.querySelector(".discount_price_span").innerHTML = discountPriceFixed; 
    }
}

//calculate grandtotal
function calculateGrandTotal(){
    let grandTotal;
    let subtotal;
    let serviceTax;
    let shippingFee;
    let discount;
    subtotal = parseFloat(document.querySelector(".subtotal_span").innerHTML);
    serviceTax = parseFloat(document.querySelector(".service_tax_span").innerHTML);
    shippingFee = parseFloat(document.querySelector(".shipping_fee_span").innerHTML);
    discount = parseFloat(document.querySelector(".discount_price_span").innerHTML);
    // console.log(discount);
    grandTotal = (subtotal + serviceTax + shippingFee + discount).toFixed(2);
    // console.log(grandTotal);
    document.querySelector(".grand_total_span").innerHTML = grandTotal;
}

// alert spinning wheel
function alertSpinningWheel(){
    let grandTotal;
    grandTotal = parseFloat(document.querySelector(".grand_total_span").innerHTML);
    if(grandTotal > 500){
        response = confirm("You are eligible for spinning the lucky wheel! Proceed?")
        if(response){
            // document.location.href = "wheel/wheel.html";
            return popitup('../wheel/wheel.html')
        }else{
            document.location.href = "../details.php"
        }
    }else{
        let response = confirm("Buy up to RM 500.00 to be eligible to spin the lucky wheel !!! >.<")
        if(response == false){
            document.location.href = "../details/details.php"
        }
    }
}

//popup spinning wheel window
function popitup(url) {
 newwindow=window.open(url,'name','height=600,width=800,screenX=400,screenY=350');
 if (window.focus) {newwindow.focus()}
 return false;
}
