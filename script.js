// ===== CONFIGURATION & VARIABLES GLOBALES =====
const config = {
    animationDuration: 2000,
    scrollOffset: 80,
    debounceDelay: 100
};

// ===== UTILITAIRES =====
// Fonction de debounce pour optimiser les performances
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ===== NAVIGATION =====
class Navigation {
    constructor() {
        this.navbar = document.querySelector('.navbar');
        this.menuToggle = document.getElementById('menuToggle');
        this.navLinks = document.querySelector('.nav-links');
        this.links = document.querySelectorAll('.nav-links a');
        
        this.init();
    }
    
    init() {
        this.setupMenuToggle();
        this.setupSmoothScroll();
        this.setupScrollEffect();
        this.setupClickOutside();
    }
    
    // Menu hamburger pour mobile
    setupMenuToggle() {
        if (this.menuToggle) {
            this.menuToggle.addEventListener('click', () => {
                this.toggleMenu();
            });
        }
    }
    
    toggleMenu() {
        this.navLinks.classList.toggle('active');
        this.menuToggle.classList.toggle('active');
        document.body.style.overflow = this.navLinks.classList.contains('active') ? 'hidden' : '';
    }
    
    closeMenu() {
        this.navLinks.classList.remove('active');
        this.menuToggle.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Smooth scroll vers les sections
    setupSmoothScroll() {
        this.links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                
                if (targetId.startsWith('#')) {
                    const target = document.querySelector(targetId);
                    
                    if (target) {
                        const targetPosition = target.offsetTop - config.scrollOffset;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        
                        this.closeMenu();
                    }
                }
            });
        });
    }
    
    // Effet de la navbar au scroll
    setupScrollEffect() {
        const handleScroll = debounce(() => {
            if (window.scrollY > 50) {
                this.navbar.classList.add('scrolled');
            } else {
                this.navbar.classList.remove('scrolled');
            }
        }, config.debounceDelay);
        
        window.addEventListener('scroll', handleScroll);
    }
    
    // Fermer le menu en cliquant à l'extérieur
    setupClickOutside() {
        document.addEventListener('click', (e) => {
            if (this.navLinks.classList.contains('active')) {
                if (!this.navLinks.contains(e.target) && !this.menuToggle.contains(e.target)) {
                    this.closeMenu();
                }
            }
        });
    }
}

// ===== ANIMATIONS AU SCROLL =====
class ScrollAnimations {
    constructor() {
        this.observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -100px 0px'
        };
        
        this.init();
    }
    
    init() {
        this.animateOnScroll();
        this.animateServiceCards();
    }
    
    // Animation générale des éléments au scroll
    animateOnScroll() {
        const elementsToAnimate = document.querySelectorAll('.service-card, .stat, .about-text');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    
                    observer.unobserve(entry.target);
                }
            });
        }, this.observerOptions);
        
        elementsToAnimate.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }
    
    // Animation spécifique des cartes de service
    animateServiceCards() {
        const cards = document.querySelectorAll('.service-card');
        
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    }
}

// ===== COMPTEURS ANIMÉS =====
class CounterAnimation {
    constructor() {
        this.counters = document.querySelectorAll('.counter');
        this.hasAnimated = false;
        
        this.init();
    }
    
    init() {
        if (this.counters.length === 0) return;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.hasAnimated) {
                    this.animateCounters();
                    this.hasAnimated = true;
                }
            });
        }, { threshold: 0.5 });
        
        const statsSection = document.querySelector('.stats');
        if (statsSection) {
            observer.observe(statsSection);
        }
    }
    
    animateCounters() {
        this.counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = config.animationDuration;
            const increment = target / (duration / 16);
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };
            
            updateCounter();
        });
    }
}

// ===== EFFET PARALLAX =====
class ParallaxEffect {
    constructor() {
        this.hero = document.querySelector('.hero');
        this.init();
    }
    
    init() {
        if (!this.hero) return;
        
        const handleScroll = debounce(() => {
            const scrolled = window.pageYOffset;
            const parallaxSpeed = 0.5;
            
            this.hero.style.transform = `translateY(${scrolled * parallaxSpeed}px)`;
        }, 10);
        
        window.addEventListener('scroll', handleScroll);
    }
}

// ===== GESTION DU FORMULAIRE =====
class ContactForm {
    constructor() {
        this.form = document.getElementById('contactForm');
        this.messageDiv = document.getElementById('formMessage');
        
        this.init();
    }
    
    init() {
        if (!this.form) return;
        
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.setupInputValidation();
    }
    
    // Soumission du formulaire avec AJAX
    async handleSubmit(e) {
        e.preventDefault();
        
        const submitButton = this.form.querySelector('.submit-button');
        const originalText = submitButton.textContent;
        
        // Désactiver le bouton pendant l'envoi
        submitButton.textContent = 'Envoi en cours...';
        submitButton.disabled = true;
        
        const formData = new FormData(this.form);
        
        try {
            const response = await fetch('contact.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            this.showMessage(result.success, result.message);
            
            if (result.success) {
                this.form.reset();
                this.clearValidationStates();
            }
            
        } catch (error) {
            this.showMessage(false, 'Une erreur est survenue. Veuillez réessayer plus tard.');
            console.error('Erreur:', error);
        } finally {
            // Réactiver le bouton
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    }
    
    // Afficher le message de succès ou d'erreur
    showMessage(success, message) {
        this.messageDiv.textContent = message;
        this.messageDiv.className = success ? 'success' : 'error';
        this.messageDiv.style.display = 'block';
        
        // Faire défiler jusqu'au message
        this.messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Masquer le message après 5 secondes
        setTimeout(() => {
            this.messageDiv.style.display = 'none';
        }, 5000);
    }
    
    // Validation en temps réel des champs
    setupInputValidation() {
        const inputs = this.form.querySelectorAll('input, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }
    
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        
        if (field.hasAttribute('required') && value === '') {
            isValid = false;
        }
        
        if (field.type === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(value);
        }
        
        if (!isValid) {
            field.style.borderColor = '#ef4444';
        } else {
            field.style.borderColor = '#10b981';
        }
        
        return isValid;
    }
    
    clearFieldError(field) {
        field.style.borderColor = '#e2e8f0';
    }
    
    clearValidationStates() {
        const inputs = this.form.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.style.borderColor = '#e2e8f0';
        });
    }
}

// ===== ANIMATIONS DES ICÔNES =====
class IconAnimations {
    constructor() {
        this.init();
    }
    
    init() {
        const serviceCards = document.querySelectorAll('.service-card');
        
        serviceCards.forEach(card => {
            const icon = card.querySelector('.service-icon');
            
            card.addEventListener('mouseenter', () => {
                icon.style.transform = 'scale(1.2) rotate(10deg)';
            });
            
            card.addEventListener('mouseleave', () => {
                icon.style.transform = 'scale(1) rotate(0deg)';
            });
        });
    }
}

// ===== BUTTON SCROLL TO TOP =====
class ScrollToTop {
    constructor() {
        this.button = this.createButton();
        this.init();
    }
    
    createButton() {
        const btn = document.createElement('button');
        btn.innerHTML = '↑';
        btn.className = 'scroll-to-top';
        btn.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        `;
        
        document.body.appendChild(btn);
        return btn;
    }
    
    init() {
        this.button.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        const handleScroll = debounce(() => {
            if (window.scrollY > 300) {
                this.button.style.opacity = '1';
                this.button.style.visibility = 'visible';
            } else {
                this.button.style.opacity = '0';
                this.button.style.visibility = 'hidden';
            }
        }, config.debounceDelay);
        
        window.addEventListener('scroll', handleScroll);
    }
}

// ===== INDICATEUR DE CHARGEMENT =====
class LoadingIndicator {
    constructor() {
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
            this.animateElements();
        });
    }
    
    animateElements() {
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
}

// ===== INITIALISATION =====
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser tous les modules
    new Navigation();
    new ScrollAnimations();
    new CounterAnimation();
    new ParallaxEffect();
    new ContactForm();
    new IconAnimations();
    new ScrollToTop();
    new LoadingIndicator();
    
    // Log de confirmation
    console.log('🚀 Site initialisé avec succès!');
});

// ===== GESTION DES ERREURS GLOBALES =====
window.addEventListener('error', (e) => {
    console.error('Erreur détectée:', e.error);
});

// ===== PERFORMANCE MONITORING =====
if ('performance' in window) {
    window.addEventListener('load', () => {
        setTimeout(() => {
            const perfData = performance.getEntriesByType('navigation')[0];
            console.log(`⚡ Temps de chargement: ${perfData.loadEventEnd - perfData.fetchStart}ms`);
        }, 0);
    });
}