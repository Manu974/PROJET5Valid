class HeaderShrink {
    /**
     *
     * @param header, The element for le listening
     * @param shrink, The moment when the shrink begin
     * @param newHeight, This new height of the element
     * @param menuSlider|null, The menu slider if we have one to listen at the same time of the header element.
     */
    constructor(header, shrink, newHeight, menuSlider = null) {
        this.header = document.querySelector(header);
        this.shrink = shrink;
        this.newHeight = newHeight;
        this.oldHeight = window.getComputedStyle(this.header).getPropertyValue('height');
        // The difference for the calcul of the new and old height for the scroll.
        this.differenceOfHeight = this.oldHeight.replace('px', '') - this.newHeight.replace('px', '');

        // Init the menu slider if we have one
        if (menuSlider !== null) {
            this.menuSlider = menuSlider;
            this.menuPositionTop = window.getComputedStyle(menuSlider.navbarMobile).getPropertyValue('top').replace('px', '');
        }

        document.addEventListener('scroll', () => {
            if (document.body.scrollTop > this.shrink) {
                this.header.style.height = this.newHeight;
                this.menuSlider.navbarMobile.style.top = (this.menuPositionTop - this.differenceOfHeight) + 'px';
            } else if (document.body.scrollTop <= 0) {
                this.header.style.height = this.oldHeight;
                this.menuSlider.navbarMobile.style.top = this.menuPositionTop + 'px';
            }
        })
    }
}
