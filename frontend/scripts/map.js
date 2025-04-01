function showCountryImage(event, country, x, y) {
    const image = document.getElementById(country + 'Image');
    const text = document.getElementById(country + 'Text');
    const imageWidth = 300; 
    const imageHeight = 300; 

    // Position the image and text
    image.style.left = `${x - imageWidth / 2}px`; 
    image.style.top = `${y - imageHeight - 10}px`; 
    text.style.left = `${x - 70}px`;
    text.style.top = `${y - 50}px`; 

    // Display the image and text
    image.style.display = 'block';
    text.style.display = 'block';
}

// General function to hide country image and text
function hideCountryImage(country) {
    document.getElementById(country + 'Image').style.display = 'none';
    document.getElementById(country + 'Text').style.display = 'none';
}