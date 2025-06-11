document.addEventListener('DOMContentLoaded', function () {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
        const toggle = item.querySelector('.accordion-toggle');
        const icon = toggle.querySelector('.icon');
        
        // Inisialisasi ikon berdasarkan status aktif
        if (item.classList.contains('active')) {
            icon.textContent = '▲'; // Panah ke atas (terbuka)
        } else {
            icon.textContent = '▼'; // Panah ke bawah (tertutup)
        }

        toggle.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Non-aktifkan semua item lain jika Anda ingin hanya satu yang terbuka
            accordionItems.forEach(otherItem => {
                otherItem.classList.remove('active');
                otherItem.querySelector('.accordion-toggle').setAttribute('aria-expanded', 'false');
                otherItem.querySelector('.icon').textContent = '▼';
            });
            
            // Toggle item yang diklik
            if (!isActive) {
                item.classList.add('active');
                toggle.setAttribute('aria-expanded', 'true');
                icon.textContent = '▲';
            }
        });
    });
});