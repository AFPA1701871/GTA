const mouseWheel = document.querySelector('.grid-pointage');

mouseWheel.addEventListener('wheel', function(e) {
    const race = 125; // How many pixels to scroll

    if (e.deltaY > 0) // Scroll right
        mouseWheel.scrollLeft += race;
    else // Scroll left
        mouseWheel.scrollLeft -= race;
		e.preventDefault();
});