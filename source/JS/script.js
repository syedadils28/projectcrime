// toggle / menu icon navbar
let menuIcon = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

menuIcon.onclick = () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
}

//multiple text typeing in home
var typed = new Typed(".multiple-text", {
    strings: ["", "e", "inal"],
    typeSpeed: 100,
    backSpeed: 50,
    backDelay: 1500,
    loop: true,
    showCursor: false,   // 🔥 removes cursor spacing entirely
    gap: 0                  // 🔥 removes gap between texts
});


/*==================== Portfolio Filtering ====================*/
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Isotope
  var iso = new Isotope('.isotope-container', {
    itemSelector: '.isotope-item',
    layoutMode: 'masonry'
  });

  var iso = new Isotope('.isotope-container', {
  itemSelector: '.isotope-item',
  layoutMode: 'masonry'
});

imagesLoaded('.isotope-container').on('progress', function() {
  iso.layout();
});

  // Bind filter button click
  var filterButtons = document.querySelectorAll('.portfolio-filters li');
  filterButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      var filterValue = this.getAttribute('data-filter');
      
      // Update active class
      filterButtons.forEach(function(btn) {
        btn.classList.remove('filter-active');
      });
      this.classList.add('filter-active');
      
      // Filter items
      iso.arrange({
        filter: filterValue
      });
    });
  });

  // Re-layout on image load
  imagesLoaded('.isotope-container').on('progress', function() {
    iso.layout();
  });
}); 

/*==================== SHOW SCROLL UP ====================*/ 
function scrollUp(){
    const scrollUp = document.getElementById('scroll-up');
    // When the scroll is higher than 560 viewport height, add the show-scroll class to the a tag with the scroll-top class
    if(this.scrollY >= 560) scrollUp.classList.add('show-scroll'); else scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollUp)

// scroll sections

let sections = document.querySelectorAll('section');
let navLinks = document.querySelectorAll('header nav a');

window.onscroll = () => {
    sections.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop - 100;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if(top >= offset && top < offset + height){
            //active navbar links
            navLinks.forEach(links => {
                links.classList.remove('active');
                document.querySelector('header nav a[href*=' + id + ']').classList.add('active');
            });

            //active section for animation on scroll
            sec.classList.add('show-animate');
        }
        //if want to use animation that repeats on scroll use this
        else{ 
            sec.classList.remove('show-animate');
        }
    });

    // sticky header
    let header = document.querySelector('header');

    header.classList.toggle('sticky', window.scrollY > 100);

    // remove toggle icon and navbar when click navbar links (scroll)
    menuIcon.classList.remove('bx-x');
    navbar.classList.remove('active');

    // animation footer on scroll
    let footer = document.querySelector('footer');

    footer.classList.toggle('show-animate', this.innerHeight + this.scrollY >= document.scrollingElement.scrollHeight);
}

//  <!-- ScrollReveal JS -->
    ScrollReveal({
      distance: '80px',
      duration: 2000,
      delay: 200
    });

    ScrollReveal().reveal('.home-content,.heading',{origin:'top'});
    ScrollReveal().reveal('.home-img,.skills-container,.services-container,.portfolio-container,.certificates-container',{origin:'bottom'});
    ScrollReveal().reveal('.home-content h1,.about-img,.contact form,.footer-left',{origin:'left'});
    ScrollReveal().reveal('.home-content p,.about-content,.footer-center',{origin:'right'});






