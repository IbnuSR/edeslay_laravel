import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== MOBILE MENU TOGGLE =====
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const mobileLinks = document.querySelectorAll('.mobile-link');
    
    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const isOpen = !mobileMenu.classList.contains('hidden');
            if (menuIcon) {
                menuIcon.className = isOpen ? 'fas fa-times text-2xl' : 'fas fa-bars text-2xl';
            }
        });
        
        // Close mobile menu when clicking a link
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                if (menuIcon) {
                    menuIcon.className = 'fas fa-bars text-2xl';
                }
            });
        });
    }
    
    // ===== NAVBAR SCROLL EFFECT =====
    const navbar = document.getElementById('main-nav');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }
    
    // ===== SMOOTH SCROLL WITH OFFSET =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
    // ===== SCROLL ANIMATIONS (INTERSECTION OBSERVER) =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                
                // Trigger counter animation
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    if (target && !counter.classList.contains('counted')) {
                        counter.classList.add('counted');
                        animateCounter(counter, target);
                    }
                });
            }
        });
    }, observerOptions);
    
    // Observe all animated elements
    document.querySelectorAll('.fade-in-up, .card-slide').forEach(el => {
        observer.observe(el);
    });
    
    // Counter Animation Function
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString('id-ID');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString('id-ID');
            }
        }, 30);
    }
});