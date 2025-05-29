
let currentIndex = 0;

function scrollToNext() {
  const total = document.querySelectorAll('.slide').length;
  currentIndex = (currentIndex + 1) % total;
  slider.scrollTo({
    left: window.innerWidth * currentIndex,
    behavior: 'smooth'
  });
}

function scrollToPrev() {
  const total = document.querySelectorAll('.slide').length;
  currentIndex = (currentIndex - 1 + total) % total;
  slider.scrollTo({
    left: window.innerWidth * currentIndex,
    behavior: 'smooth'
  });
}
slider.scrollTo({
    left: window.innerWidth * currentIndex,
    behavior: 'smooth'
  });
  