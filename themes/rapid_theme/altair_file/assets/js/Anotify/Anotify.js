function ANotify() {
    this.elem = "";
    this.chooseCol = function (clase) {
        var color = "";
        switch (clase) {
            case 'success':
                color = "#28c76f";
                ;
                break;
            case 'danger':
                color = "#da2525";
                ;
                break;
            case 'warning':
                color = "#d4c834";
                ;
                break;
        }
        return color;
    }
    this.init = function (elem, txt, color, interval) {
        var inner = document.getElementById('ATInnerSpan');
        inner.innerHTML = txt;
        this.elem = elem;
        this.elem.style.display = 'block';
        this.elem.style.backgroundColor = this.chooseCol(color);
        setTimeout(function () {
            elem.style.display = "none";
        }, 3000);
    }
    this.close = function () {
        var elem = document.getElementById('Atoast');
//        elem.className = "AtoastClose";
        elem.style.display = "none";
    }
}
var AUIkit = new ANotify();
document.getElementById("ATanchor").addEventListener("click", AUIkit.close);
