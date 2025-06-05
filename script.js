// Mobile Menu Toggle
const menuBtn = document.querySelector('.menu-btn');
const slider = document.querySelector('.slider');
const body = document.body;

menuBtn.addEventListener('click', () => {
    menuBtn.classList.toggle('active');
    slider.classList.toggle('active');
    body.style.overflow = slider.classList.contains('active') ? 'hidden' : '';
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
    if (!slider.contains(e.target) && !menuBtn.contains(e.target) && slider.classList.contains('active')) {
        menuBtn.classList.remove('active');
        slider.classList.remove('active');
        body.style.overflow = '';
    }
});

// Header scroll effect
const header = document.querySelector('.header');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll <= 0) {
        header.classList.remove('scrolled');
        return;
    }

    if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
        // Scrolling down
        header.style.transform = 'translateY(-100%)';
    } else if (currentScroll < lastScroll && header.style.transform !== 'translateY(0)') {
        // Scrolling up
        header.style.transform = 'translateY(0)';
    }

    if (currentScroll > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }

    lastScroll = currentScroll;
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));

        if (target) {
            // Close mobile menu if open
            if (slider.classList.contains('active')) {
                menuBtn.classList.remove('active');
                slider.classList.remove('active');
                body.style.overflow = '';
            }

            // Scroll to target
            const headerOffset = header.offsetHeight;
            const elementPosition = target.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Animation on scroll
const animateOnScroll = () => {
    const elements = document.querySelectorAll('.card, .product-card');

    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;

        if (elementTop < window.innerHeight && elementBottom > 0) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
};

// Product Image Popup
function openPopup(card) {
    const front = card.getAttribute('data-front');
    const back = card.getAttribute('data-back');

    document.getElementById('popupFront').src = front;
    document.getElementById('popupBack').src = back;

    document.getElementById('imagePopup').style.display = 'flex';
}

function closePopup() {
    document.getElementById('imagePopup').style.display = 'none';
}


// Initial check for elements in view
window.addEventListener('load', animateOnScroll);
window.addEventListener('scroll', animateOnScroll);

// Form validation
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Basic form validation
        const name = contactForm.querySelector('#name').value.trim();
        const email = contactForm.querySelector('#email').value.trim();
        const mobile = contactForm.querySelector('#mobile').value.trim();
        const message = contactForm.querySelector('#message').value.trim();

        if (!name || !email || !mobile || !message) {
            alert('Please fill in all fields');
            return;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address');
            return;
        }

        // Mobile validation
        const mobileRegex = /^\+?[\d\s-]{10,}$/;
        if (!mobileRegex.test(mobile)) {
            alert('Please enter a valid mobile number');
            return;
        }

        // If validation passes, submit the form
        contactForm.submit();
    });
}