import Alpine from 'alpinejs';

// Alpine.js Store: Theme Controller (light/dark)
// Menyimpan preferensi tema ke localStorage dan menerapkan ke data-theme HTML
Alpine.store('theme', {
    current: 'batik-light',

    init() {
        const saved = localStorage.getItem('admin-theme');
        if (saved) {
            this.current = saved;
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            this.current = 'batik-dark';
        } else {
            this.current = 'batik-light';
        }
    },

    toggle() {
        this.current = this.current === 'batik-light' ? 'batik-dark' : 'batik-light';
        localStorage.setItem('admin-theme', this.current);
    },

    isDark() {
        return this.current === 'batik-dark';
    }
});

window.Alpine = Alpine;
Alpine.start();
