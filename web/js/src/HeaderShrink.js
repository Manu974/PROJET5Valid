class HeaderShrink {
    constructor(header, shrink, newHeight) {
        this.header = document.querySelector(header);
        this.shrink = shrink;
        this.newHeight = newHeight;
        this.oldHeight = window.getComputedStyle(this.header).getPropertyValue('height');


        document.addEventListener('scroll', () => {
            if (document.body.scrollTop > this.shrink) {
                this.header.style.height = this.newHeight;
            } else if (document.body.scrollTop <= 0) {
                this.header.style.height = this.oldHeight;
            }
        })
    }
}
