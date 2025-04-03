//Variables used in the following methods
var priceElement = document.querySelector(".tprice");
var value = parseFloat(priceElement.innerHTML.replace(/[^0-9.]/g, "")) || 0;
var amount = document.querySelector(".addonchoice");
var quantity = parseFloat(0);
var foodsize = '';
var addon = '';

function Aseasonal() {
    location.replace("../dinein/appetizers/Aseasonal.html")
}

//Methods for cancelling and submitting the order
function cancelling() {
    location.replace("../../category/dinein.html");
}

function submitting() {
    if(quantity == 0) console.log("You havent added anything!");
    else if(foodsize == '') console.log("Please select the size of the item!")
    if(!(quantity == 0) && !(foodsize == '')) {
        location.replace("../../cart.php");
        console.log("Your item has been added in the cart!");
    }

    // Get item details
    let foodName = document.querySelector(".rightfields p").innerText; 
    let finalPrice = value.toFixed(2);

    // Prepare data for sending
    let cartData = new FormData();
    cartData.append("name", foodName);
    cartData.append("size", foodsize);
    cartData.append("quantity", quantity);
    cartData.append("price", finalPrice);

    // Send data to add_to_cart.php
    fetch("../../backend/api/add_to_cart.php", {
        method: "POST",
        body: cartData
    })
    .then(response => response.text())
    .then(data => {
        console.log("Item added to cart:", data);
        window.location.href = "../../cart.php"; // Redirect to cart page
    })
    .catch(error => console.error("Error adding to cart:", error));
}

//Gets the size of the food from the selected radio options
function getsize() {
    if (document.getElementById("small").checked) foodsize = 's';
    else if (document.getElementById("medium").checked) foodsize = 'm';
    else if (document.getElementById("large").checked) foodsize = 'l';
    console.log("Selected size option: " + foodsize);
}

//Assigns addon value to variable based on options, only if quantity is selected
function getaddon() {
    if(quantity == 0) {
        document.getElementById("yes").checked = false;
        document.getElementById("no").checked = false;
        addon = '';
        return;
    }
    if(document.getElementById("yes").checked) addon = 'y';
    else if (document.getElementById("no").checked) addon = 'n';
}


//Plus and Minus that calculates cost based on size and quantity
function increment() {
    quantity += 1;
    amount.childNodes[1].nodeValue = quantity;
    if(foodsize == 's') value += 5;
    else if(foodsize == 'm') value += 7;
    else if(foodsize == 'l') value += 10;
    change();
}

function decrement() {
    if(amount.childNodes[1].nodeValue > 0) {
        quantity -= 1;
        amount.childNodes[1].nodeValue = quantity;
        if(foodsize == 's') value -= 5;
        else if(foodsize == 'm') value -= 7;
        else if(foodsize == 'l') value -= 10;
        change();
        if(quantity == 0) {
            document.getElementById("no").checked = true;
            value -= 4;
            change();
        }
    }
}

//These methods help initialize final cost based on option selected
function smalloption() {
    if(addon == 'y') {
        value = 4 + (5 * quantity);
        change();
    }
    else {
        value = 5 * quantity;
        change();
    }
}

function mediumoption() {
    if(addon == 'y') {
        value = 4 + (7 * quantity);
        change();
    }
    else {
        value = 7 * quantity;
        change();
    }
}

function largeoption() {
    if(addon == 'y') {
        value = 4 + (10 * quantity);
        change();
    }
    else {
        value = 10 * quantity;
        change();
    }
}


//Evaluates cost based on add ons
function ifyes() {
    if(!(quantity == 0) && !(foodsize == '')) {
        value += 4;
        change();
    }
    else if (quantity == 0) {
        console.log("Please select the size and quantity of the item!");
        addon = '';
        event.preventDefault();
    }
    else if (foodsize == '') {
        console.log("Please select the size and quantity of the item!");
        addon = '';
        event.preventDefault();
    }
    else {
        console.log("Please select the size and quantity of the item!");
        addon = '';
        event.preventDefault();
    }
}

function ifno() {
    if(!(quantity == 0) && !(foodsize == '')) {
        if(foodsize == 's') {
            if(value % 5 == 4) value -= 4;
            change();
        }
        else if(foodsize == 'm') {
            if(value % 7 == 4) value -= 4;
            change();
        }
        else if(foodsize == 'l') {
            if(value % 10 == 4) value -= 4;
            change();
        }
        change();
    }
    else if (quantity == 0) {
        console.log("Please select the size and quantity of the item!");
        addon = '';
        event.preventDefault();
    }
    else if (foodsize == '') {
        console.log("Please select the size and quantity of the item!");
        addon = '';
        event.preventDefault();
    }
    else {
        console.log("Please select the size and quantity of the item!");
        addon = '';
        event.preventDefault();
    }
}

//Default method for instantly updating the final price
function change() {
    priceElement.innerHTML = '$' + value.toFixed(2);
}