export default function compress(e, resizeWidth, resizeHeight, quality, callback) {
    //toBlob polyfill
    if (!HTMLCanvasElement.prototype.toBlob) {
        Object.defineProperty(HTMLCanvasElement.prototype, 'toBlob', {
            value: function (callback, type, quality) {
                var dataURL = this.toDataURL(type, quality).split(',')[1];
                setTimeout(function() {
                    var binStr = atob( dataURL ),
                        len = binStr.length,
                        arr = new Uint8Array(len);
                    for (var i = 0; i < len; i++ ) {
                        arr[i] = binStr.charCodeAt(i);
                    }
                    callback( new Blob( [arr], {type: type || 'image/png'} ) );
                });
            }
        });
    }

    const fileName = e.target.files[0].name;
    const reader = new FileReader();
    reader.readAsDataURL(e.target.files[0]);
    reader.onload = event => {
        const img = new Image();
        img.src = event.target.result;
        img.onload = () => {
            const elem = document.createElement('canvas');

            let width = img.width;
            let height = img.height;

            if(resizeWidth) {
                if(resizeWidth !== 'auto' && img.width > resizeWidth) {
                    width = resizeWidth;
                    if (resizeHeight === 'auto') {
                        const scaleFactor = width / img.width;
                        height = img.height * scaleFactor;
                    }
                }
            }

            if(resizeHeight) {
                if (resizeHeight !== 'auto' && img.height > resizeHeight) {
                    height = resizeHeight;
                    if (resizeWidth === 'auto') {
                        const scaleFactor = height / img.height;
                        width = img.width * scaleFactor;
                    }
                }
            }

            elem.width = width;
            elem.height = height;

            const ctx = elem.getContext('2d');
            // img.width and img.height will contain the original dimensions
            ctx.drawImage(img, 0, 0, elem.width, elem.height);
            ctx.canvas.toBlob((blob) => {
                const file = new File([blob], fileName, {
                    type: blob.type,
                    lastModified: Date.now()
                });
                callback(file, blob);
            }, e.target.files[0].type, quality);
        };
        reader.onerror = error => console.log(error);
    };
}