export class ImgPreviewController {
    constructor() {
        this.img = document.querySelector('#img-preview')
        this.uploadInput = document.querySelector('.img-preview')

        if (this.uploadInput && this.img)
            this.init()
    }

    init() {

        this.uploadInput.onchange = evt => {
                const [file] = this.uploadInput.files
                if (file) 
                this.img.src = URL.createObjectURL(file)
            }
    }
}