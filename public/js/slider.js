document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('mainSlider');
    if (!slider) return;

    const wrapper = slider.querySelector('.slider-wrapper');
    const items = slider.querySelectorAll('.slider-item');
    const dots = slider.querySelectorAll('.dot');
    const prevBtn = slider.querySelector('.slider-prev');
    const nextBtn = slider.querySelector('.slider-next');
    
    let currentIndex = 0;
    const totalSlides = items.length;
    let autoPlayInterval;

    function goToSlide(index) {
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;
        currentIndex = index;
        wrapper.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
        
        dots.forEach((dot, i) => {
            if (i === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function nextSlide() {
        goToSlide(currentIndex + 1);
    }

    function prevSlide() {
        goToSlide(currentIndex - 1);
    }

    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 3000);
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    // Next button click
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });
    }

    // Previous button click
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });
    }

    // Dots click
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            stopAutoPlay();
            goToSlide(index);
            startAutoPlay();
        });
    });

    // Pause on hover
    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);

    // Start autoplay
    if (totalSlides > 1) {
        startAutoPlay();
    }
});
