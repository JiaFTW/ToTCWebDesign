function showCountryImage(event, country, x, y) {
    const image = document.getElementById(country + 'Image');
    const text = document.getElementById(country + 'Text');
    const imageWidth = 300;
    const imageHeight = 300;

    // Get the mouse position
    const mouseX = event.clientX;
    const mouseY = event.clientY;

    // Adjusting image and text position to appear right below the cursor
    image.style.left = `${mouseX - imageWidth / 2}px`;
    image.style.top = `${mouseY + 10}px`;  // Make sure it's below the mouse
    text.style.left = `${mouseX - 70}px`;
    text.style.top = `${mouseY + imageHeight + 20}px`;  // Adjust text below image

    // Display the image and text
    image.style.display = 'block';
    text.style.display = 'block';
}

// General function to hide country image and text
function hideCountryImage(country) {
    const image = document.getElementById(country + 'Image');
    const text = document.getElementById(country + 'Text');
    
    // Hide the image and text
    image.style.display = 'none';
    text.style.display = 'none';
}