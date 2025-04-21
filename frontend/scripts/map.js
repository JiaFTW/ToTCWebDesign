function showCountryImage(event, country, x, y) {
    const image = document.getElementById(country + 'Image');
    const text = document.getElementById(country + 'Text');
    const imageWidth = 300;
    const imageHeight = 300;

    // Get the mouse position
    const mouseX = event.clientX;
    const mouseY = event.clientY;

    // Image realitive to mouse placement
    image.style.left = `${mouseX - imageWidth / 2}px`;
    image.style.top = `${mouseY - 100}px`; 
    text.style.left = `${mouseX - 70}px`;
    text.style.top = `${mouseY + imageHeight + 20}px`;  

    // Display the image and text
    image.style.display = 'block';
    text.style.display = 'block';
}

// General function to hide country image and text
function hideCountryImage(country) {
    const image = document.getElementById(country + 'Image');
    const text = document.getElementById(country + 'Text');
    
    
    image.style.display = 'none';
    text.style.display = 'none';
}