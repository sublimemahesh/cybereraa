const container = document.querySelector('.slide-container');
const container2 = document.querySelector('.slide-container2');
const slides = document.querySelectorAll('.slide');
const slides2 = document.querySelectorAll('.slide2');
const btns = document.querySelectorAll('.btn');
const btnPrev = document.querySelector('.btn-prev');
const btnNext = document.querySelector('.btn-next');

const n = slides.length;
const n2 = slides2.length;

const angle = 360 / n;

let setId = 0;
let deg = [];
let x = 0;
let y = 0;

const touchDevice = () => ('ontouchstart' in document.documentElement);
const setTransition = (time) => {
  let i = 0;
  for (; i < n; i++) slides[i].style.transition = `all ${time}s`;
 
}
const positionSlides = () => {
  const r = container.offsetWidth / 2;
  
  let i = 0;
  
  setTransition('0');
  
  for (; i < n; i++) {
    deg[i] = i * angle;
    x = Math.cos(deg[i] * (Math.PI / 180)) * r + r;
    y = Math.sin(deg[i] * (Math.PI / 180)) * r + r;
    
    slides[i].style.top = `${~~y}px`;
    slides2[i].style.top = `${~~y}px`;
    slides[i].style.left = `${~~x}px`;
    slides2[i].style.left = `${~~x}px`;
  }
  
  setTimeout(() => {
    setTransition('.3');
  }, 10);
}
const prevSlide = () => {
  let i = 0;
  for (; i < n; i++) deg[i] -= angle;
  animateSlide();
}
const nextSlide = () => {
  let i = 0;
  for (; i < n; i++) deg[i] += angle;
  animateSlide();
}
const animateSlide = () => {
  const r = container.offsetWidth / 2;
  let i = 0;
  
  for (; i < n; i++) {
    x = Math.cos(deg[i] * (Math.PI / 180)) * r + r;
    y = Math.sin(deg[i] * (Math.PI / 180)) * r + r;
    
    slides[i].style.top = `${~~y}px`;
    slides2[i].style.top = `${~~y}px`;
    slides[i].style.left = `${~~x}px`;
    slides2[i].style.left = `${~~x}px`;
    
    y === 0 ? slides[i].classList.add('active') : slides[i].classList.remove('active');
    y === 0 ? slides2[i].classList.add('active') : slides2[i].classList.remove('active');
  }
  
  const activeSlide = document.querySelector('.slide.active');
  const slideBgImg = getComputedStyle(activeSlide).backgroundImage;
  
  const activeSlide2 = document.querySelector('.slide2.active');
  const slideBgImg2 = getComputedStyle(activeSlide2).backgroundImage;


  container.style.backgroundImage = slideBgImg;
  container2.style.backgroundImage = slideBgImg2;
}
const autoPlay = () => setId = setInterval(nextSlide, 3000);
const changeSlideImg = (e) => {
  let i = 0;
  for (; i < n; i++) slides[i].classList.remove('active');
  e.currentTarget.classList.add('active');

  for (; i < n; i++) slides2[i].classList.remove('active');
  e.currentTarget.classList.add('active');

  const activeSlide = document.querySelector('.slide.active');
  const slideBgImg = getComputedStyle(activeSlide).backgroundImage;
  container.style.backgroundImage = slideBgImg;

  const activeSlide2 = document.querySelector('.slide2.active');
  const slideBgImg2 = getComputedStyle(activeSlide2).backgroundImage;
  container2.style.backgroundImage = slideBgImg2;
}

positionSlides();
nextSlide();
autoPlay();

// btnPrev.addEventListener('click', prevSlide);
// btnNext.addEventListener('click', nextSlide);
// btns.forEach(btn => {
//   btn.addEventListener('mouseenter', () => clearInterval(setId));
//   btn.addEventListener('mouseleave', () => {
//     clearInterval(setId);
//     autoPlay();
//   });
// })

// slides.forEach(slide => {
//   if (touchDevice()) {
//     slide.addEventListener('click', (e) => {
//       changeSlideImg(e);
//       clearInterval(setId);
//       autoPlay();
//     });
//   }
//   else {
//     slide.addEventListener('mouseenter', (e) => {
//       changeSlideImg(e);
//       clearInterval(setId);
//     });
//     slide.addEventListener('mouseleave', () => {
//       clearInterval(setId);
//       autoPlay();
//     });
//   }
// })
// window.addEventListener('resize', () => {
//   clearInterval(setId);
//   positionSlides();
//   autoPlay();
// })