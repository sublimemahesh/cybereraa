///////////////////////////////////////////
// Resizing Slider

const inputs = document.querySelectorAll("input");
const div = document.querySelector("li");

function handleInputChange() {
  const units = this.dataset.units || "";

  document.documentElement.style.setProperty(
    `--${this.name}`,
    this.value + units
  );
}

inputs.forEach((input) => input.addEventListener("input", handleInputChange));
var range = $("input#range"),
  value = $(".range-value");
value.html(range.attr("value"));
range.on("input", function () {
  value.html(this.value);
});