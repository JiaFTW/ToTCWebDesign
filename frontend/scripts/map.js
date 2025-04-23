function showCountryImage(event, country, x, y) {
    const link = document.getElementById(country + 'Link'); 
    const image = document.getElementById(country + 'Image'); 
    const text = document.getElementById(country + 'Text');
    const imageWidth = 300;
    const imageHeight = 300;

    // Get the mouse position
    const mouseX = event.clientX;
    const mouseY = event.clientY;

    // Position the a tag (hopeflly over the image)
    link.style.position = 'absolute';
    link.style.left = `${mouseX - imageWidth / 2}px`;
    link.style.top = `${mouseY - 100}px`;
    link.style.display = 'block';

    // Place image in a tag
    image.style.display = 'block';
    image.style.width = `${imageWidth}px`;
    image.style.height = `${imageHeight}px`;
    
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