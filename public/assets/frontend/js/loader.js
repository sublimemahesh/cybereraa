// Function to show the loader
function showLoader() {
    document.getElementById('loaderContainer').style.display = 'flex';
  }
  
  // Function to hide the loader and show the main content
  function hideLoader() {
    document.getElementById('loaderContainer').style.display = 'none';
    document.getElementById('mainContent').style.display = 'block';
  }
  
  // Simulate loading delay (remove this in a real-world scenario)
  function simulateLoading() {
    showLoader();
    setTimeout(function() {
      hideLoader();
    }, 3000); // Adjust the time as needed
  }
  
  // Call the function to simulate loading when the page loads
  window.onload = simulateLoading;
  