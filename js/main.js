// main.js — Interactions JS de l'application

// Indicateur de force du mot de passe
document.addEventListener('DOMContentLoaded', function () {
    const pwd = document.getElementById('password');
    const meter = document.getElementById('pwd-strength');
    if (pwd && meter) {
        pwd.addEventListener('input', function () {
            const v = pwd.value;
            let score = 0;
            if (v.length >= 8) score++;
            if (/[A-Z]/.test(v)) score++;
            if (/[0-9]/.test(v)) score++;
            if (/[^A-Za-z0-9]/.test(v)) score++;
            const colors = ['#ef4444', '#f59e0b', '#eab308', '#22c55e', '#10b981'];
            const widths = ['20%', '40%', '60%', '80%', '100%'];
            meter.style.background = colors[score];
            meter.style.width = widths[score];
        });
    }

    // Validation Bootstrap
    document.querySelectorAll('form.needs-validation').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            // Vérification confirm password
            const p1 = form.querySelector('#password');
            const p2 = form.querySelector('#password_confirm');
            if (p1 && p2 && p1.value !== p2.value) {
                e.preventDefault();
                p2.setCustomValidity('Les mots de passe ne correspondent pas');
                p2.reportValidity();
            } else if (p2) {
                p2.setCustomValidity('');
            }
            form.classList.add('was-validated');
        });
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Animation des compteurs
    const counters = document.querySelectorAll('.counter');
    const animate = (el) => {
        const target = +el.dataset.target;
        let current = 0;
        const step = Math.max(1, Math.ceil(target / 60));
        const timer = setInterval(() => {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = current;
        }, 25);
    };
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(en => { if (en.isIntersecting) { animate(en.target); obs.unobserve(en.target); } });
        });
        counters.forEach(c => obs.observe(c));
    } else { counters.forEach(animate); }
});
