// Step 1: Get the element and parse the value
var priceElement = document.querySelector(".tprice");
var value = parseFloat(priceElement.innerHTML.replace(/[^0-9.]/g, "")) || 0; // Remove $ if present
var amount = document.querySelector(".addonchoice");
var quantity = parseFloat(0);
var foodsize = '';
var addon = '';

function Aseasonal() {
    location.replace("../dinein/appetizers/Aseasonal.html")
}

function cancelling() {
    location.replace("../../category/dinein.html");
}

function submitting() {
    if(quantity == 0) console.log("You havent added anything!");
    else if(foodsize == '') console.log("Please select the size of the item!")
    if(!(quantity == 0) && !(foodsize == '')) {
        location.replace("../../category/dinein.html");
        console.log("Your item has been added in the cart!");
    }
}

function getsize() {
    if (document.getElementById("small").checked) foodsize = 's';
    else if (document.getElementById("medium").checked) foodsize = 'm';
    else if (document.getElementById("large").checked) foodsize = 'l';
    console.log("Selected size option: " + foodsize);
}

function getaddon() {
    if(quantity == 0) {
        document.getElementById("yes").checked = false;
        document.getElementById("no").checked = false;
        addon = '';
        return;
    }
    if(document.getElementById("yes").checked) addon = 'y';
    else if (document.getElementById("no").checked) addon = 'n';

    document.getElementById("yes").onclick = null;
    document.getElementById("no").onclick = null;
}

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
    }
}

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

function change() {
    priceElement.innerHTML = '$' + value.toFixed(2);
}