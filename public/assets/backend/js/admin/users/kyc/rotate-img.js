
function rotateImage(direction, imageIndex) {
    const images = document.querySelectorAll('.rotatable-image');
    const image = images[imageIndex];

    let rotation = parseInt(image.dataset.rotation) || 0;

    if (direction === 'clockwise') {
        rotation += 90;
    } else if (direction === 'counterclockwise') {
        rotation -= 90;
    }

    image.style.transform = `rotate(${rotation}deg)`;
    image.dataset.rotation = rotation;
}

function toggleRotateButtons(imageIndex) {
    const rotateButtons = document.querySelectorAll('.rotate-buttons');
    const rotateButton = rotateButtons[imageIndex];
    const marginValue = '10px'; // Set your desired margin value

    // Toggle visibility of rotate buttons
    rotateButton.style.display = rotateButton.style.display === 'none' ? 'block' : 'none';

    // Adjust margin of the image based on button visibility
    const image = document.querySelectorAll('.rotatable-image')[imageIndex];
    image.style.marginBottom = rotateButton.style.display === 'none' ? '0' : marginValue;
}
