(()=>{
    var e={
        755:()=>{console.log("components")},
        /*901:()=>{
            document.querySelector(".roadmap").offsetHeight,
            document.querySelector(".roadmap__progress");
            var e=document.querySelector(".header__burger"),
            t=document.querySelector(".header__burger-menu"),
            n=document.querySelector(".services__close-icon"),
            o=document.querySelector(".mob-menu"),
            d=document.querySelector("body"),
            i=document.querySelectorAll(".mob-nav__link"),
            s=document.querySelectorAll(".services__link");
            i.length>0&&i.forEach((function(e){
                e.addEventListener("click",(function(e){
                    o.classList.remove("--active-menu")
                }))
            })),
            window.scrollY,e.addEventListener("click",(function(){
                t.classList.toggle("--active-burger"),
                o.classList.add("--active-menu"),
                d.classList.add("body-lock")
            })),n.addEventListener("click",(function(){
                o.classList.remove("--active-menu"),
                d.classList.remove("body-lock")
            })),s.length>0&&s.forEach((function(e){
                e.addEventListener("click",(function(){
                    o.classList.remove("--active-menu")}))
            }))
        },*/
        598:()=>{
            function e(e){
                var t=!0,n=!1,o=null,d={text:!0,search:!0,url:!0,tel:!0,email:!0,password:!0,number:!0,date:!0,month:!0,week:!0,time:!0,datetime:!0,"datetime-local":!0};
                function i(e){return!!(e&&e!==document&&"HTML"!==e.nodeName&&"BODY"!==e.nodeName&&"classList"in e&&"contains"in e.classList)}
                function s(e){e.classList.contains("focus-visible")||(e.classList.add("focus-visible"),e.setAttribute("data-focus-visible-added",""))}
                function c(e){t=!1}function r(){
                    document.addEventListener("mousemove",u),
                    document.addEventListener("mousedown",u),
                    document.addEventListener("mouseup",u),
                    document.addEventListener("pointermove",u),
                    document.addEventListener("pointerdown",u),
                    document.addEventListener("pointerup",u),
                    document.addEventListener("touchmove",u),
                    document.addEventListener("touchstart",u),
                    document.addEventListener("touchend",u)
                }
                function u(e){
                    e.target.nodeName&&"html"===e.target.nodeName.toLowerCase()||(t=!1,document.removeEventListener("mousemove",u),
                    document.removeEventListener("mousedown",u),
                    document.removeEventListener("mouseup",u),
                    document.removeEventListener("pointermove",u),
                    document.removeEventListener("pointerdown",u),
                    document.removeEventListener("pointerup",u),
                    document.removeEventListener("touchmove",u),
                    document.removeEventListener("touchstart",u),
                    document.removeEventListener("touchend",u))
                }
                document.addEventListener("keydown",(function(n){n.metaKey||n.altKey||n.ctrlKey||(i(e.activeElement)&&s(e.activeElement),t=!0)}),!0),
                document.addEventListener("mousedown",c,!0),document.addEventListener("pointerdown",c,!0),
                document.addEventListener("touchstart",c,!0),document.addEventListener("visibilitychange",(function(e){"hidden"===document.visibilityState&&(n&&(t=!0),r())}),!0),
                r(),e.addEventListener("focus",(function(e){var n,o,c;i(e.target)&&(t||(o=(n=e.target).type,"INPUT"===(c=n.tagName)&&d[o]&&!n.readOnly||"TEXTAREA"===c&&!n.readOnly||n.isContentEditable))&&s(e.target)}),!0),e.addEventListener("blur",(function(e){var t;i(e.target)&&(e.target.classList.contains("focus-visible")||e.target.hasAttribute("data-focus-visible-added"))&&(n=!0,window.clearTimeout(o),o=window.setTimeout((function(){n=!1}),100),(t=e.target).hasAttribute("data-focus-visible-added")&&(t.classList.remove("focus-visible"),t.removeAttribute("data-focus-visible-added")))}),!0),e.nodeType===Node.DOCUMENT_FRAGMENT_NODE&&e.host?e.host.setAttribute("data-js-focus-visible",""):e.nodeType===Node.DOCUMENT_NODE&&(document.documentElement.classList.add("js-focus-visible"),document.documentElement.setAttribute("data-js-focus-visible",""))}if("undefined"!=typeof window&&"undefined"!=typeof document){var t;window.applyFocusVisiblePolyfill=e;try{t=new CustomEvent("focus-visible-polyfill-ready")}catch(e){(t=document.createEvent("CustomEvent")).initCustomEvent("focus-visible-polyfill-ready",!1,!1,{})}window.dispatchEvent(t)}"undefined"!=typeof document&&e(document)}},t={};function n(o){var d=t[o];if(void 0!==d)return d.exports;var i=t[o]={exports:{}};return e[o](i,i.exports,n),i.exports}(()=>{"use strict";n(598);const e={windowEl:window,documentEl:document,htmlEl:document.documentElement,bodyEl:document.body};var t;console.log((t=navigator.userAgent||navigator.vendor||window.opera,/android/i.test(t)?(e.htmlEl.classList.add("page--android"),"Android"):/iPad|iPhone|iPod/.test(t)&&!window.MSStream?(e.htmlEl.classList.add("page--ios"),"iOS"):"unknown")),n(755),n(901)})()})();