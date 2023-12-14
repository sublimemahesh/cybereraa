
var size=0;
// Check if the viewport width is 412 pixels or less
if (window.innerWidth <= 412) {
  // Code to execute for mobile view
  console.log('Mobile view with a width of 412 pixels or less');
  size=250;
} else {
  // Code to execute for larger screens
  console.log('Larger screen view');
  size=578;
}



var rangeSlider = document.getElementById("rs-range-line");
var rangeBullet = document.getElementById("rs-bullet");
var customDepositAmountInput = document.getElementById("custom-deposit-amount");

rangeSlider.addEventListener("input", showSliderValue, false);

function showSliderValue() {
  rangeBullet.innerHTML = rangeSlider.value;
  customDepositAmountInput.value = rangeSlider.value;
  var bulletPosition = (rangeSlider.value /rangeSlider.max);
  rangeBullet.style.left = (bulletPosition * size) + "px";

//   console.log(bulletPosition);

}
