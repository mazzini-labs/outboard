!function(e,t){if("function"==typeof define&&define.amd)define("hoverintent",["module"],t);else if("undefined"!=typeof exports)t(module);else{var n={exports:{}};t(n),e.hoverintent=n.exports}}(this,function(e){"use strict";var t=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e};e.exports=function(e,n,o){function i(e,t){return y&&(y=clearTimeout(y)),b=0,p?void 0:o.call(e,t)}function r(e){m=e.clientX,d=e.clientY}function u(e,t){if(y&&(y=clearTimeout(y)),Math.abs(h-m)+Math.abs(E-d)<x.sensitivity)return b=1,p?void 0:n.call(e,t);h=m,E=d,y=setTimeout(function(){u(e,t)},x.interval)}function s(t){return L=!0,y&&(y=clearTimeout(y)),e.removeEventListener("mousemove",r,!1),1!==b&&(h=t.clientX,E=t.clientY,e.addEventListener("mousemove",r,!1),y=setTimeout(function(){u(e,t)},x.interval)),this}function c(t){return L=!1,y&&(y=clearTimeout(y)),e.removeEventListener("mousemove",r,!1),1===b&&(y=setTimeout(function(){i(e,t)},x.timeout)),this}function v(t){L||(p=!0,n.call(e,t))}function a(t){!L&&p&&(p=!1,o.call(e,t))}function f(){e.addEventListener("focus",v,!1),e.addEventListener("blur",a,!1)}function l(){e.removeEventListener("focus",v,!1),e.removeEventListener("blur",a,!1)}var m,d,h,E,L=!1,p=!1,T={},b=0,y=0,x={sensitivity:7,interval:100,timeout:0,handleFocus:!1};return T.options=function(e){var n=e.handleFocus!==x.handleFocus;return x=t({},x,e),n&&(x.handleFocus?f():l()),T},T.remove=function(){e&&(e.removeEventListener("mouseover",s,!1),e.removeEventListener("mouseout",c,!1),l())},e&&(e.addEventListener("mouseover",s,!1),e.addEventListener("mouseout",c,!1)),T}});

/*! This file is auto-generated */
!function(d,f,m){function p(e){var t;27===e.which&&(t=A(e.target,".menupop"))&&(t.querySelector(".menupop > .ab-item").focus(),w(t,"hover"))}function h(e){var t;13===e.which&&(A(e.target,".ab-sub-wrapper")||(t=A(e.target,".menupop"))&&(e.preventDefault(),E(t,"hover")?w(t,"hover"):L(t,"hover")))}function v(e){var t;13===e.which&&(t=e.target.getAttribute("href"),-1<m.userAgent.toLowerCase().indexOf("applewebkit")&&t&&"#"===t.charAt(0)&&setTimeout(function(){var e=d.getElementById(t.replace("#",""));e&&(e.setAttribute("tabIndex","0"),e.focus())},100))}function g(e,t){var n;A(t.target,".ab-sub-wrapper")||(t.preventDefault(),(n=A(t.target,".menupop"))&&(E(n,"hover")?w(n,"hover"):(S(e),L(n,"hover"))))}function b(e){var t,n=e.target.parentNode;if(n&&(t=n.querySelector(".shortlink-input")),t)return e.preventDefault&&e.preventDefault(),e.returnValue=!1,L(n,"selected"),t.focus(),t.select(),!(t.onblur=function(){w(n,"selected")})}function y(){if("sessionStorage"in f)try{for(var e in sessionStorage)-1<e.indexOf("wp-autosave-")&&sessionStorage.removeItem(e)}catch(e){}}function E(e,t){return!!e&&(e.classList&&e.classList.contains?e.classList.contains(t):!!e.className&&-1<e.className.split(" ").indexOf(t))}function L(e,t){e&&(e.classList&&e.classList.add?e.classList.add(t):E(e,t)||(e.className&&(e.className+=" "),e.className+=t))}function w(e,t){var n,r;if(e&&E(e,t))if(e.classList&&e.classList.remove)e.classList.remove(t);else{for(n=" "+t+" ",r=" "+e.className+" ";-1<r.indexOf(n);)r=r.replace(n,"");e.className=r.replace(/^[\s]+|[\s]+$/g,"")}}function S(e){if(e&&e.length)for(var t=0;t<e.length;t++)w(e[t],"hover")}function k(e){if(!e.target||"wpadminbar"===e.target.id||"wp-admin-bar-top-secondary"===e.target.id)try{f.scrollTo({top:-32,left:0,behavior:"smooth"})}catch(e){f.scrollTo(0,-32)}}function A(e,t){for(f.Element.prototype.matches||(f.Element.prototype.matches=f.Element.prototype.matchesSelector||f.Element.prototype.mozMatchesSelector||f.Element.prototype.msMatchesSelector||f.Element.prototype.oMatchesSelector||f.Element.prototype.webkitMatchesSelector||function(e){for(var t=(this.document||this.ownerDocument).querySelectorAll(e),n=t.length;0<=--n&&t.item(n)!==this;);return-1<n});e&&e!==d;e=e.parentNode)if(e.matches(t))return e;return null}d.addEventListener("DOMContentLoaded",function(){var n,e,t,r,o,a,s,i,c,l,u=d.getElementById("wpadminbar");if(u&&"querySelectorAll"in u){n=u.querySelectorAll("li.menupop"),e=u.querySelectorAll(".ab-item"),t=d.getElementById("wp-admin-bar-logout"),r=d.getElementById("adminbarsearch"),o=d.getElementById("wp-admin-bar-get-shortlink"),a=u.querySelector(".screen-reader-shortcut"),s=/Mobile\/.+Safari/.test(m.userAgent)?"touchstart":"click",i=/Android (1.0|1.1|1.5|1.6|2.0|2.1)|Nokia|Opera Mini|w(eb)?OSBrowser|webOS|UCWEB|Windows Phone OS 7|XBLWP7|ZuneWP7|MSIE 7/,w(u,"nojs"),"ontouchstart"in f&&(d.body.addEventListener(s,function(e){A(e.target,"li.menupop")||S(n)}),u.addEventListener("touchstart",function e(){for(var t=0;t<n.length;t++)n[t].addEventListener("click",g.bind(null,n));u.removeEventListener("touchstart",e)})),u.addEventListener("click",k);for(l=0;l<n.length;l++)f.hoverintent(n[l],L.bind(null,n[l],"hover"),w.bind(null,n[l],"hover")).options({timeout:180}),n[l].addEventListener("keydown",h);for(l=0;l<e.length;l++)e[l].addEventListener("keydown",p);r&&((c=d.getElementById("adminbar-search")).addEventListener("focus",function(){L(r,"adminbar-focused")}),c.addEventListener("blur",function(){w(r,"adminbar-focused")})),a&&a.addEventListener("keydown",v),o&&o.addEventListener("click",b),f.location.hash&&f.scrollBy(0,-32),m.userAgent&&i.test(m.userAgent)&&!E(d.body,"no-font-face")&&L(d.body,"no-font-face"),t&&t.addEventListener("click",y)}})}(document,window,navigator);
/*! This file is auto-generated */
!function(d,l){"use strict";var e=!1,o=!1;if(l.querySelector)if(d.addEventListener)e=!0;if(d.wp=d.wp||{},!d.wp.receiveEmbedMessage)if(d.wp.receiveEmbedMessage=function(e){var t=e.data;if(t)if(t.secret||t.message||t.value)if(!/[^a-zA-Z0-9]/.test(t.secret)){var r,a,i,s,n,o=l.querySelectorAll('iframe[data-secret="'+t.secret+'"]'),c=l.querySelectorAll('blockquote[data-secret="'+t.secret+'"]');for(r=0;r<c.length;r++)c[r].style.display="none";for(r=0;r<o.length;r++)if(a=o[r],e.source===a.contentWindow){if(a.removeAttribute("style"),"height"===t.message){if(1e3<(i=parseInt(t.value,10)))i=1e3;else if(~~i<200)i=200;a.height=i}if("link"===t.message)if(s=l.createElement("a"),n=l.createElement("a"),s.href=a.getAttribute("src"),n.href=t.value,n.host===s.host)if(l.activeElement===a)d.top.location.href=t.value}}},e)d.addEventListener("message",d.wp.receiveEmbedMessage,!1),l.addEventListener("DOMContentLoaded",t,!1),d.addEventListener("load",t,!1);function t(){if(!o){o=!0;var e,t,r,a,i=-1!==navigator.appVersion.indexOf("MSIE 10"),s=!!navigator.userAgent.match(/Trident.*rv:11\./),n=l.querySelectorAll("iframe.wp-embedded-content");for(t=0;t<n.length;t++){if(!(r=n[t]).getAttribute("data-secret"))a=Math.random().toString(36).substr(2,10),r.src+="#?secret="+a,r.setAttribute("data-secret",a);if(i||s)(e=r.cloneNode(!0)).removeAttribute("security"),r.parentNode.replaceChild(e,r)}}}}(window,document);

!function(e) {
    var t = {};
    function n(i) {
        if (t[i])
            return t[i].exports;
        var r = t[i] = {
            i: i,
            l: !1,
            exports: {}
        };
        // return e[i].call(r.exports, r, r.exports, n),
        r.l = !0,
        r.exports
    }
    n.m = e,
    n.c = t,
    n.d = function(e, t, i) {
        n.o(e, t) || Object.defineProperty(e, t, {
            enumerable: !0,
            get: i
        })
    }
    ,
    n.r = function(e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }),
        Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }
    ,
    n.t = function(e, t) {
        if (1 & t && (e = n(e)),
        8 & t)
            return e;
        if (4 & t && "object" == typeof e && e && e.__esModule)
            return e;
        var i = Object.create(null);
        if (n.r(i),
        Object.defineProperty(i, "default", {
            enumerable: !0,
            value: e
        }),
        2 & t && "string" != typeof e)
            for (var r in e)
                n.d(i, r, function(t) {
                    return e[t]
                }
                .bind(null, r));
        return i
    }
    ,
    n.n = function(e) {
        var t = e && e.__esModule ? function() {
            return e.default
        }
        : function() {
            return e
        }
        ;
        return n.d(t, "a", t),
        t
    }
    ,
    n.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }
    ,
    n.p = "",
    n(n.s = 239)
}([function(e, t, n) {
    var i = n(1)
      , r = n(47).f
      , o = n(26)
      , a = n(34)
      , s = n(93)
      , l = n(114)
      , c = n(86);
    e.exports = function(e, t) {
        var n, u, f, d, h, p = e.target, g = e.global, v = e.stat;
        if (n = g ? i : v ? i[p] || s(p, {}) : (i[p] || {}).prototype)
            for (u in t) {
                if (d = t[u],
                f = e.noTargetGet ? (h = r(n, u)) && h.value : n[u],
                !c(g ? u : p + (v ? "." : "#") + u, e.forced) && void 0 !== f) {
                    if (typeof d == typeof f)
                        continue;
                    l(d, f)
                }
                (e.sham || f && f.sham) && o(d, "sham", !0),
                a(n, u, d, e)
            }
    }
}
, function(e, t, n) {
    "use strict";
    (function(e) {
        var t, i;
        n(10),
        n(16),
        n(17),
        n(213),
        n(36),
        n(38),
        n(12),
        n(8),
        n(23),
        n(52),
        n(13),
        n(44),
        n(7),
        n(43),
        n(14),
        n(18),
        n(42),
        n(30),
        n(40),
        n(19);
        function r(e) {
            return (r = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
                return typeof e
            }
            : function(e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
            }
            )(e)
        }
        /*!
 * perfect-scrollbar v1.5.0
 * Copyright 2020 Hyunje Jun, MDBootstrap and Contributors
 * Licensed under MIT
 */
        t = void 0,
        i = function() {
            function e(e) {
                return getComputedStyle(e)
            }
            function t(e, t) {
                for (var n in t) {
                    var i = t[n];
                    "number" == typeof i && (i += "px"),
                    e.style[n] = i
                }
                return e
            }
            function n(e) {
                var t = document.createElement("div");
                return t.className = e,
                t
            }
            var i = "undefined" != typeof Element && (Element.prototype.matches || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector);
            function r(e, t) {
                if (!i)
                    throw new Error("No element matching method supported");
                return i.call(e, t)
            }
            function o(e) {
                e.remove ? e.remove() : e.parentNode && e.parentNode.removeChild(e)
            }
            function a(e, t) {
                return Array.prototype.filter.call(e.children, (function(e) {
                    return r(e, t)
                }
                ))
            }
            var s = {
                main: "ps",
                rtl: "ps__rtl",
                element: {
                    thumb: function(e) {
                        return "ps__thumb-" + e
                    },
                    rail: function(e) {
                        return "ps__rail-" + e
                    },
                    consuming: "ps__child--consume"
                },
                state: {
                    focus: "ps--focus",
                    clicking: "ps--clicking",
                    active: function(e) {
                        return "ps--active-" + e
                    },
                    scrolling: function(e) {
                        return "ps--scrolling-" + e
                    }
                }
            }
              , l = {
                x: null,
                y: null
            };
            function c(e, t) {
                var n = e.element.classList
                  , i = s.state.scrolling(t);
                n.contains(i) ? clearTimeout(l[t]) : n.add(i)
            }
            function u(e, t) {
                l[t] = setTimeout((function() {
                    return e.isAlive && e.element.classList.remove(s.state.scrolling(t))
                }
                ), e.settings.scrollingThreshold)
            }
            var f = function(e) {
                this.element = e,
                this.handlers = {}
            }
              , d = {
                isEmpty: {
                    configurable: !0
                }
            };
            f.prototype.bind = function(e, t) {
                void 0 === this.handlers[e] && (this.handlers[e] = []),
                this.handlers[e].push(t),
                this.element.addEventListener(e, t, !1)
            }
            ,
            f.prototype.unbind = function(e, t) {
                var n = this;
                this.handlers[e] = this.handlers[e].filter((function(i) {
                    return !(!t || i === t) || (n.element.removeEventListener(e, i, !1),
                    !1)
                }
                ))
            }
            ,
            f.prototype.unbindAll = function() {
                for (var e in this.handlers)
                    this.unbind(e)
            }
            ,
            d.isEmpty.get = function() {
                var e = this;
                return Object.keys(this.handlers).every((function(t) {
                    return 0 === e.handlers[t].length
                }
                ))
            }
            ,
            Object.defineProperties(f.prototype, d);
            var h = function() {
                this.eventElements = []
            };
            function p(e) {
                if ("function" == typeof window.CustomEvent)
                    return new CustomEvent(e);
                var t = document.createEvent("CustomEvent");
                return t.initCustomEvent(e, !1, !1, void 0),
                t
            }
            function g(e, t, n, i, r) {
                var o;
                if (void 0 === i && (i = !0),
                void 0 === r && (r = !1),
                "top" === t)
                    o = ["contentHeight", "containerHeight", "scrollTop", "y", "up", "down"];
                else {
                    if ("left" !== t)
                        throw new Error("A proper axis should be provided");
                    o = ["contentWidth", "containerWidth", "scrollLeft", "x", "left", "right"]
                }
                !function(e, t, n, i, r) {
                    var o = n[0]
                      , a = n[1]
                      , s = n[2]
                      , l = n[3]
                      , f = n[4]
                      , d = n[5];
                    void 0 === i && (i = !0),
                    void 0 === r && (r = !1);
                    var h = e.element;
                    e.reach[l] = null,
                    h[s] < 1 && (e.reach[l] = "start"),
                    h[s] > e[o] - e[a] - 1 && (e.reach[l] = "end"),
                    t && (h.dispatchEvent(p("ps-scroll-" + l)),
                    t < 0 ? h.dispatchEvent(p("ps-scroll-" + f)) : t > 0 && h.dispatchEvent(p("ps-scroll-" + d)),
                    i && function(e, t) {
                        c(e, t),
                        u(e, t)
                    }(e, l)),
                    e.reach[l] && (t || r) && h.dispatchEvent(p("ps-" + l + "-reach-" + e.reach[l]))
                }(e, n, o, i, r)
            }
            function v(e) {
                return parseInt(e, 10) || 0
            }
            h.prototype.eventElement = function(e) {
                var t = this.eventElements.filter((function(t) {
                    return t.element === e
                }
                ))[0];
                return t || (t = new f(e),
                this.eventElements.push(t)),
                t
            }
            ,
            h.prototype.bind = function(e, t, n) {
                this.eventElement(e).bind(t, n)
            }
            ,
            h.prototype.unbind = function(e, t, n) {
                var i = this.eventElement(e);
                i.unbind(t, n),
                i.isEmpty && this.eventElements.splice(this.eventElements.indexOf(i), 1)
            }
            ,
            h.prototype.unbindAll = function() {
                this.eventElements.forEach((function(e) {
                    return e.unbindAll()
                }
                )),
                this.eventElements = []
            }
            ,
            h.prototype.once = function(e, t, n) {
                var i = this.eventElement(e);
                i.bind(t, (function e(r) {
                    i.unbind(t, e),
                    n(r)
                }
                ))
            }
            ;
            var m = {
                isWebKit: "undefined" != typeof document && "WebkitAppearance"in document.documentElement.style,
                supportsTouch: "undefined" != typeof window && ("ontouchstart"in window || "maxTouchPoints"in window.navigator && window.navigator.maxTouchPoints > 0 || window.DocumentTouch && document instanceof window.DocumentTouch),
                supportsIePointer: "undefined" != typeof navigator && navigator.msMaxTouchPoints,
                isChrome: "undefined" != typeof navigator && /Chrome/i.test(navigator && navigator.userAgent)
            };
            function y(e) {
                var n = e.element
                  , i = Math.floor(n.scrollTop)
                  , r = n.getBoundingClientRect();
                e.containerWidth = Math.ceil(r.width),
                e.containerHeight = Math.ceil(r.height),
                e.contentWidth = n.scrollWidth,
                e.contentHeight = n.scrollHeight,
                n.contains(e.scrollbarXRail) || (a(n, s.element.rail("x")).forEach((function(e) {
                    return o(e)
                }
                )),
                n.appendChild(e.scrollbarXRail)),
                n.contains(e.scrollbarYRail) || (a(n, s.element.rail("y")).forEach((function(e) {
                    return o(e)
                }
                )),
                n.appendChild(e.scrollbarYRail)),
                !e.settings.suppressScrollX && e.containerWidth + e.settings.scrollXMarginOffset < e.contentWidth ? (e.scrollbarXActive = !0,
                e.railXWidth = e.containerWidth - e.railXMarginWidth,
                e.railXRatio = e.containerWidth / e.railXWidth,
                e.scrollbarXWidth = b(e, v(e.railXWidth * e.containerWidth / e.contentWidth)),
                e.scrollbarXLeft = v((e.negativeScrollAdjustment + n.scrollLeft) * (e.railXWidth - e.scrollbarXWidth) / (e.contentWidth - e.containerWidth))) : e.scrollbarXActive = !1,
                !e.settings.suppressScrollY && e.containerHeight + e.settings.scrollYMarginOffset < e.contentHeight ? (e.scrollbarYActive = !0,
                e.railYHeight = e.containerHeight - e.railYMarginHeight,
                e.railYRatio = e.containerHeight / e.railYHeight,
                e.scrollbarYHeight = b(e, v(e.railYHeight * e.containerHeight / e.contentHeight)),
                e.scrollbarYTop = v(i * (e.railYHeight - e.scrollbarYHeight) / (e.contentHeight - e.containerHeight))) : e.scrollbarYActive = !1,
                e.scrollbarXLeft >= e.railXWidth - e.scrollbarXWidth && (e.scrollbarXLeft = e.railXWidth - e.scrollbarXWidth),
                e.scrollbarYTop >= e.railYHeight - e.scrollbarYHeight && (e.scrollbarYTop = e.railYHeight - e.scrollbarYHeight),
                function(e, n) {
                    var i = {
                        width: n.railXWidth
                    }
                      , r = Math.floor(e.scrollTop);
                    n.isRtl ? i.left = n.negativeScrollAdjustment + e.scrollLeft + n.containerWidth - n.contentWidth : i.left = e.scrollLeft,
                    n.isScrollbarXUsingBottom ? i.bottom = n.scrollbarXBottom - r : i.top = n.scrollbarXTop + r,
                    t(n.scrollbarXRail, i);
                    var o = {
                        top: r,
                        height: n.railYHeight
                    };
                    n.isScrollbarYUsingRight ? n.isRtl ? o.right = n.contentWidth - (n.negativeScrollAdjustment + e.scrollLeft) - n.scrollbarYRight - n.scrollbarYOuterWidth - 9 : o.right = n.scrollbarYRight - e.scrollLeft : n.isRtl ? o.left = n.negativeScrollAdjustment + e.scrollLeft + 2 * n.containerWidth - n.contentWidth - n.scrollbarYLeft - n.scrollbarYOuterWidth : o.left = n.scrollbarYLeft + e.scrollLeft,
                    t(n.scrollbarYRail, o),
                    t(n.scrollbarX, {
                        left: n.scrollbarXLeft,
                        width: n.scrollbarXWidth - n.railBorderXWidth
                    }),
                    t(n.scrollbarY, {
                        top: n.scrollbarYTop,
                        height: n.scrollbarYHeight - n.railBorderYWidth
                    })
                }(n, e),
                e.scrollbarXActive ? n.classList.add(s.state.active("x")) : (n.classList.remove(s.state.active("x")),
                e.scrollbarXWidth = 0,
                e.scrollbarXLeft = 0,
                n.scrollLeft = !0 === e.isRtl ? e.contentWidth : 0),
                e.scrollbarYActive ? n.classList.add(s.state.active("y")) : (n.classList.remove(s.state.active("y")),
                e.scrollbarYHeight = 0,
                e.scrollbarYTop = 0,
                n.scrollTop = 0)
            }
            function b(e, t) {
                return e.settings.minScrollbarLength && (t = Math.max(t, e.settings.minScrollbarLength)),
                e.settings.maxScrollbarLength && (t = Math.min(t, e.settings.maxScrollbarLength)),
                t
            }
            function w(e, t) {
                var n = t[0]
                  , i = t[1]
                  , r = t[2]
                  , o = t[3]
                  , a = t[4]
                  , l = t[5]
                  , f = t[6]
                  , d = t[7]
                  , h = t[8]
                  , p = e.element
                  , g = null
                  , v = null
                  , m = null;
                function b(t) {
                    t.touches && t.touches[0] && (t[r] = t.touches[0].pageY),
                    p[f] = g + m * (t[r] - v),
                    c(e, d),
                    y(e),
                    t.stopPropagation(),
                    t.preventDefault()
                }
                function w() {
                    u(e, d),
                    e[h].classList.remove(s.state.clicking),
                    e.event.unbind(e.ownerDocument, "mousemove", b)
                }
                function x(t, a) {
                    g = p[f],
                    a && t.touches && (t[r] = t.touches[0].pageY),
                    v = t[r],
                    m = (e[i] - e[n]) / (e[o] - e[l]),
                    a ? e.event.bind(e.ownerDocument, "touchmove", b) : (e.event.bind(e.ownerDocument, "mousemove", b),
                    e.event.once(e.ownerDocument, "mouseup", w),
                    t.preventDefault()),
                    e[h].classList.add(s.state.clicking),
                    t.stopPropagation()
                }
                e.event.bind(e[a], "mousedown", (function(e) {
                    x(e)
                }
                )),
                e.event.bind(e[a], "touchstart", (function(e) {
                    x(e, !0)
                }
                ))
            }
            var x = {
                "click-rail": function(e) {
                    e.element,
                    e.event.bind(e.scrollbarY, "mousedown", (function(e) {
                        return e.stopPropagation()
                    }
                    )),
                    e.event.bind(e.scrollbarYRail, "mousedown", (function(t) {
                        var n = t.pageY - window.pageYOffset - e.scrollbarYRail.getBoundingClientRect().top > e.scrollbarYTop ? 1 : -1;
                        e.element.scrollTop += n * e.containerHeight,
                        y(e),
                        t.stopPropagation()
                    }
                    )),
                    e.event.bind(e.scrollbarX, "mousedown", (function(e) {
                        return e.stopPropagation()
                    }
                    )),
                    e.event.bind(e.scrollbarXRail, "mousedown", (function(t) {
                        var n = t.pageX - window.pageXOffset - e.scrollbarXRail.getBoundingClientRect().left > e.scrollbarXLeft ? 1 : -1;
                        e.element.scrollLeft += n * e.containerWidth,
                        y(e),
                        t.stopPropagation()
                    }
                    ))
                },
                "drag-thumb": function(e) {
                    w(e, ["containerWidth", "contentWidth", "pageX", "railXWidth", "scrollbarX", "scrollbarXWidth", "scrollLeft", "x", "scrollbarXRail"]),
                    w(e, ["containerHeight", "contentHeight", "pageY", "railYHeight", "scrollbarY", "scrollbarYHeight", "scrollTop", "y", "scrollbarYRail"])
                },
                keyboard: function(e) {
                    var t = e.element;
                    e.event.bind(e.ownerDocument, "keydown", (function(n) {
                        if (!(n.isDefaultPrevented && n.isDefaultPrevented() || n.defaultPrevented) && (r(t, ":hover") || r(e.scrollbarX, ":focus") || r(e.scrollbarY, ":focus"))) {
                            var i, o = document.activeElement ? document.activeElement : e.ownerDocument.activeElement;
                            if (o) {
                                if ("IFRAME" === o.tagName)
                                    o = o.contentDocument.activeElement;
                                else
                                    for (; o.shadowRoot; )
                                        o = o.shadowRoot.activeElement;
                                if (r(i = o, "input,[contenteditable]") || r(i, "select,[contenteditable]") || r(i, "textarea,[contenteditable]") || r(i, "button,[contenteditable]"))
                                    return
                            }
                            var a = 0
                              , s = 0;
                            switch (n.which) {
                            case 37:
                                a = n.metaKey ? -e.contentWidth : n.altKey ? -e.containerWidth : -30;
                                break;
                            case 38:
                                s = n.metaKey ? e.contentHeight : n.altKey ? e.containerHeight : 30;
                                break;
                            case 39:
                                a = n.metaKey ? e.contentWidth : n.altKey ? e.containerWidth : 30;
                                break;
                            case 40:
                                s = n.metaKey ? -e.contentHeight : n.altKey ? -e.containerHeight : -30;
                                break;
                            case 32:
                                s = n.shiftKey ? e.containerHeight : -e.containerHeight;
                                break;
                            case 33:
                                s = e.containerHeight;
                                break;
                            case 34:
                                s = -e.containerHeight;
                                break;
                            case 36:
                                s = e.contentHeight;
                                break;
                            case 35:
                                s = -e.contentHeight;
                                break;
                            default:
                                return
                            }
                            e.settings.suppressScrollX && 0 !== a || e.settings.suppressScrollY && 0 !== s || (t.scrollTop -= s,
                            t.scrollLeft += a,
                            y(e),
                            function(n, i) {
                                var r = Math.floor(t.scrollTop);
                                if (0 === n) {
                                    if (!e.scrollbarYActive)
                                        return !1;
                                    if (0 === r && i > 0 || r >= e.contentHeight - e.containerHeight && i < 0)
                                        return !e.settings.wheelPropagation
                                }
                                var o = t.scrollLeft;
                                if (0 === i) {
                                    if (!e.scrollbarXActive)
                                        return !1;
                                    if (0 === o && n < 0 || o >= e.contentWidth - e.containerWidth && n > 0)
                                        return !e.settings.wheelPropagation
                                }
                                return !0
                            }(a, s) && n.preventDefault())
                        }
                    }
                    ))
                },
                wheel: function(t) {
                    var n = t.element;
                    function i(i) {
                        var r = function(e) {
                            var t = e.deltaX
                              , n = -1 * e.deltaY;
                            return void 0 !== t && void 0 !== n || (t = -1 * e.wheelDeltaX / 6,
                            n = e.wheelDeltaY / 6),
                            e.deltaMode && 1 === e.deltaMode && (t *= 10,
                            n *= 10),
                            t != t && n != n && (t = 0,
                            n = e.wheelDelta),
                            e.shiftKey ? [-n, -t] : [t, n]
                        }(i)
                          , o = r[0]
                          , a = r[1];
                        if (!function(t, i, r) {
                            if (!m.isWebKit && n.querySelector("select:focus"))
                                return !0;
                            if (!n.contains(t))
                                return !1;
                            for (var o = t; o && o !== n; ) {
                                if (o.classList.contains(s.element.consuming))
                                    return !0;
                                var a = e(o);
                                if (r && a.overflowY.match(/(scroll|auto)/)) {
                                    var l = o.scrollHeight - o.clientHeight;
                                    if (l > 0 && (o.scrollTop > 0 && r < 0 || o.scrollTop < l && r > 0))
                                        return !0
                                }
                                if (i && a.overflowX.match(/(scroll|auto)/)) {
                                    var c = o.scrollWidth - o.clientWidth;
                                    if (c > 0 && (o.scrollLeft > 0 && i < 0 || o.scrollLeft < c && i > 0))
                                        return !0
                                }
                                o = o.parentNode
                            }
                            return !1
                        }(i.target, o, a)) {
                            var l = !1;
                            t.settings.useBothWheelAxes ? t.scrollbarYActive && !t.scrollbarXActive ? (a ? n.scrollTop -= a * t.settings.wheelSpeed : n.scrollTop += o * t.settings.wheelSpeed,
                            l = !0) : t.scrollbarXActive && !t.scrollbarYActive && (o ? n.scrollLeft += o * t.settings.wheelSpeed : n.scrollLeft -= a * t.settings.wheelSpeed,
                            l = !0) : (n.scrollTop -= a * t.settings.wheelSpeed,
                            n.scrollLeft += o * t.settings.wheelSpeed),
                            y(t),
                            (l = l || function(e, i) {
                                var r = Math.floor(n.scrollTop)
                                  , o = 0 === n.scrollTop
                                  , a = r + n.offsetHeight === n.scrollHeight
                                  , s = 0 === n.scrollLeft
                                  , l = n.scrollLeft + n.offsetWidth === n.scrollWidth;
                                return !(Math.abs(i) > Math.abs(e) ? o || a : s || l) || !t.settings.wheelPropagation
                            }(o, a)) && !i.ctrlKey && (i.stopPropagation(),
                            i.preventDefault())
                        }
                    }
                    void 0 !== window.onwheel ? t.event.bind(n, "wheel", i) : void 0 !== window.onmousewheel && t.event.bind(n, "mousewheel", i)
                },
                touch: function(t) {
                    if (m.supportsTouch || m.supportsIePointer) {
                        var n = t.element
                          , i = {}
                          , r = 0
                          , o = {}
                          , a = null;
                        m.supportsTouch ? (t.event.bind(n, "touchstart", f),
                        t.event.bind(n, "touchmove", d),
                        t.event.bind(n, "touchend", h)) : m.supportsIePointer && (window.PointerEvent ? (t.event.bind(n, "pointerdown", f),
                        t.event.bind(n, "pointermove", d),
                        t.event.bind(n, "pointerup", h)) : window.MSPointerEvent && (t.event.bind(n, "MSPointerDown", f),
                        t.event.bind(n, "MSPointerMove", d),
                        t.event.bind(n, "MSPointerUp", h)))
                    }
                    function l(e, i) {
                        n.scrollTop -= i,
                        n.scrollLeft -= e,
                        y(t)
                    }
                    function c(e) {
                        return e.targetTouches ? e.targetTouches[0] : e
                    }
                    function u(e) {
                        return !(e.pointerType && "pen" === e.pointerType && 0 === e.buttons || (!e.targetTouches || 1 !== e.targetTouches.length) && (!e.pointerType || "mouse" === e.pointerType || e.pointerType === e.MSPOINTER_TYPE_MOUSE))
                    }
                    function f(e) {
                        if (u(e)) {
                            var t = c(e);
                            i.pageX = t.pageX,
                            i.pageY = t.pageY,
                            r = (new Date).getTime(),
                            null !== a && clearInterval(a)
                        }
                    }
                    function d(a) {
                        if (u(a)) {
                            var f = c(a)
                              , d = {
                                pageX: f.pageX,
                                pageY: f.pageY
                            }
                              , h = d.pageX - i.pageX
                              , p = d.pageY - i.pageY;
                            if (function(t, i, r) {
                                if (!n.contains(t))
                                    return !1;
                                for (var o = t; o && o !== n; ) {
                                    if (o.classList.contains(s.element.consuming))
                                        return !0;
                                    var a = e(o);
                                    if (r && a.overflowY.match(/(scroll|auto)/)) {
                                        var l = o.scrollHeight - o.clientHeight;
                                        if (l > 0 && (o.scrollTop > 0 && r < 0 || o.scrollTop < l && r > 0))
                                            return !0
                                    }
                                    if (i && a.overflowX.match(/(scroll|auto)/)) {
                                        var c = o.scrollWidth - o.clientWidth;
                                        if (c > 0 && (o.scrollLeft > 0 && i < 0 || o.scrollLeft < c && i > 0))
                                            return !0
                                    }
                                    o = o.parentNode
                                }
                                return !1
                            }(a.target, h, p))
                                return;
                            l(h, p),
                            i = d;
                            var g = (new Date).getTime()
                              , v = g - r;
                            v > 0 && (o.x = h / v,
                            o.y = p / v,
                            r = g),
                            function(e, i) {
                                var r = Math.floor(n.scrollTop)
                                  , o = n.scrollLeft
                                  , a = Math.abs(e)
                                  , s = Math.abs(i);
                                if (s > a) {
                                    if (i < 0 && r === t.contentHeight - t.containerHeight || i > 0 && 0 === r)
                                        return 0 === window.scrollY && i > 0 && m.isChrome
                                } else if (a > s && (e < 0 && o === t.contentWidth - t.containerWidth || e > 0 && 0 === o))
                                    return !0;
                                return !0
                            }(h, p) && a.preventDefault()
                        }
                    }
                    function h() {
                        t.settings.swipeEasing && (clearInterval(a),
                        a = setInterval((function() {
                            t.isInitialized ? clearInterval(a) : o.x || o.y ? Math.abs(o.x) < .01 && Math.abs(o.y) < .01 ? clearInterval(a) : (l(30 * o.x, 30 * o.y),
                            o.x *= .8,
                            o.y *= .8) : clearInterval(a)
                        }
                        ), 10))
                    }
                }
            }
              , S = function(i, r) {
                var o = this;
                if (void 0 === r && (r = {}),
                "string" == typeof i && (i = document.querySelector(i)),
                !i || !i.nodeName)
                    throw new Error("no element is specified to initialize PerfectScrollbar");
                for (var a in this.element = i,
                i.classList.add(s.main),
                this.settings = {
                    handlers: ["click-rail", "drag-thumb", "keyboard", "wheel", "touch"],
                    maxScrollbarLength: null,
                    minScrollbarLength: null,
                    scrollingThreshold: 1e3,
                    scrollXMarginOffset: 0,
                    scrollYMarginOffset: 0,
                    suppressScrollX: !1,
                    suppressScrollY: !1,
                    swipeEasing: !0,
                    useBothWheelAxes: !1,
                    wheelPropagation: !0,
                    wheelSpeed: 1
                },
                r)
                    this.settings[a] = r[a];
                this.containerWidth = null,
                this.containerHeight = null,
                this.contentWidth = null,
                this.contentHeight = null;
                var l, c, u = function() {
                    return i.classList.add(s.state.focus)
                }, f = function() {
                    return i.classList.remove(s.state.focus)
                };
                this.isRtl = "rtl" === e(i).direction,
                !0 === this.isRtl && i.classList.add(s.rtl),
                this.isNegativeScroll = (c = i.scrollLeft,
                i.scrollLeft = -1,
                l = i.scrollLeft < 0,
                i.scrollLeft = c,
                l),
                this.negativeScrollAdjustment = this.isNegativeScroll ? i.scrollWidth - i.clientWidth : 0,
                this.event = new h,
                this.ownerDocument = i.ownerDocument || document,
                this.scrollbarXRail = n(s.element.rail("x")),
                i.appendChild(this.scrollbarXRail),
                this.scrollbarX = n(s.element.thumb("x")),
                this.scrollbarXRail.appendChild(this.scrollbarX),
                this.scrollbarX.setAttribute("tabindex", 0),
                this.event.bind(this.scrollbarX, "focus", u),
                this.event.bind(this.scrollbarX, "blur", f),
                this.scrollbarXActive = null,
                this.scrollbarXWidth = null,
                this.scrollbarXLeft = null;
                var d = e(this.scrollbarXRail);
                this.scrollbarXBottom = parseInt(d.bottom, 10),
                isNaN(this.scrollbarXBottom) ? (this.isScrollbarXUsingBottom = !1,
                this.scrollbarXTop = v(d.top)) : this.isScrollbarXUsingBottom = !0,
                this.railBorderXWidth = v(d.borderLeftWidth) + v(d.borderRightWidth),
                t(this.scrollbarXRail, {
                    display: "block"
                }),
                this.railXMarginWidth = v(d.marginLeft) + v(d.marginRight),
                t(this.scrollbarXRail, {
                    display: ""
                }),
                this.railXWidth = null,
                this.railXRatio = null,
                this.scrollbarYRail = n(s.element.rail("y")),
                i.appendChild(this.scrollbarYRail),
                this.scrollbarY = n(s.element.thumb("y")),
                this.scrollbarYRail.appendChild(this.scrollbarY),
                this.scrollbarY.setAttribute("tabindex", 0),
                this.event.bind(this.scrollbarY, "focus", u),
                this.event.bind(this.scrollbarY, "blur", f),
                this.scrollbarYActive = null,
                this.scrollbarYHeight = null,
                this.scrollbarYTop = null;
                var p = e(this.scrollbarYRail);
                this.scrollbarYRight = parseInt(p.right, 10),
                isNaN(this.scrollbarYRight) ? (this.isScrollbarYUsingRight = !1,
                this.scrollbarYLeft = v(p.left)) : this.isScrollbarYUsingRight = !0,
                this.scrollbarYOuterWidth = this.isRtl ? function(t) {
                    var n = e(t);
                    return v(n.width) + v(n.paddingLeft) + v(n.paddingRight) + v(n.borderLeftWidth) + v(n.borderRightWidth)
                }(this.scrollbarY) : null,
                this.railBorderYWidth = v(p.borderTopWidth) + v(p.borderBottomWidth),
                t(this.scrollbarYRail, {
                    display: "block"
                }),
                this.railYMarginHeight = v(p.marginTop) + v(p.marginBottom),
                t(this.scrollbarYRail, {
                    display: ""
                }),
                this.railYHeight = null,
                this.railYRatio = null,
                this.reach = {
                    x: i.scrollLeft <= 0 ? "start" : i.scrollLeft >= this.contentWidth - this.containerWidth ? "end" : null,
                    y: i.scrollTop <= 0 ? "start" : i.scrollTop >= this.contentHeight - this.containerHeight ? "end" : null
                },
                this.isAlive = !0,
                this.settings.handlers.forEach((function(e) {
                    return x[e](o)
                }
                )),
                this.lastScrollTop = Math.floor(i.scrollTop),
                this.lastScrollLeft = i.scrollLeft,
                this.event.bind(this.element, "scroll", (function(e) {
                    return o.onScroll(e)
                }
                )),
                y(this)
            };
            return S.prototype.update = function() {
                this.isAlive && (this.negativeScrollAdjustment = this.isNegativeScroll ? this.element.scrollWidth - this.element.clientWidth : 0,
                t(this.scrollbarXRail, {
                    display: "block"
                }),
                t(this.scrollbarYRail, {
                    display: "block"
                }),
                this.railXMarginWidth = v(e(this.scrollbarXRail).marginLeft) + v(e(this.scrollbarXRail).marginRight),
                this.railYMarginHeight = v(e(this.scrollbarYRail).marginTop) + v(e(this.scrollbarYRail).marginBottom),
                t(this.scrollbarXRail, {
                    display: "none"
                }),
                t(this.scrollbarYRail, {
                    display: "none"
                }),
                y(this),
                g(this, "top", 0, !1, !0),
                g(this, "left", 0, !1, !0),
                t(this.scrollbarXRail, {
                    display: ""
                }),
                t(this.scrollbarYRail, {
                    display: ""
                }))
            }
            ,
            S.prototype.onScroll = function(e) {
                this.isAlive && (y(this),
                g(this, "top", this.element.scrollTop - this.lastScrollTop),
                g(this, "left", this.element.scrollLeft - this.lastScrollLeft),
                this.lastScrollTop = Math.floor(this.element.scrollTop),
                this.lastScrollLeft = this.element.scrollLeft)
            }
            ,
            S.prototype.destroy = function() {
                this.isAlive && (this.event.unbindAll(),
                o(this.scrollbarX),
                o(this.scrollbarY),
                o(this.scrollbarXRail),
                o(this.scrollbarYRail),
                this.removePsClasses(),
                this.element = null,
                this.scrollbarX = null,
                this.scrollbarY = null,
                this.scrollbarXRail = null,
                this.scrollbarYRail = null,
                this.isAlive = !1)
            }
            ,
            S.prototype.removePsClasses = function() {
                this.element.className = this.element.className.split(" ").filter((function(e) {
                    return !e.match(/^ps([-_].+|)$/)
                }
                )).join(" ")
            }
            ,
            S
        }
        ,
        "object" === ("undefined" == typeof exports ? "undefined" : r(exports)) && void 0 !== e ? e.exports = i() : "function" == typeof define && n(24) ? define(i) : (t = t || self).PerfectScrollbar = i()
    }
    ).call(this, n(27)(e))
}
, function(e, t, n) {
    "use strict";
    var i = n(0)
      , r = n(21).every;
    i({
        target: "Array",
        proto: !0,
        forced: n(45)("every")
    }, {
        every: function(e) {
            return r(this, e, arguments.length > 1 ? arguments[1] : void 0)
        }
    })
}
, function(e, t, n) {
    "use strict";
    (function(e) {
        n(13),
        n(46);
        !function(e) {
            e(["jquery"], (function(e) {
                return function() {
                    var t, n, i, r = 0, o = {
                        error: "error",
                        info: "info",
                        success: "success",
                        warning: "warning"
                    }, a = {
                        clear: function(n, i) {
                            var r = f();
                            t || s(r);
                            l(n, r, i) || function(n) {
                                for (var i = t.children(), r = i.length - 1; r >= 0; r--)
                                    l(e(i[r]), n)
                            }(r)
                        },
                        remove: function(n) {
                            var i = f();
                            t || s(i);
                            if (n && 0 === e(":focus", n).length)
                                return void d(n);
                            t.children().length && t.remove()
                        },
                        error: function(e, t, n) {
                            return u({
                                type: o.error,
                                iconClass: f().iconClasses.error,
                                message: e,
                                optionsOverride: n,
                                title: t
                            })
                        },
                        getContainer: s,
                        info: function(e, t, n) {
                            return u({
                                type: o.info,
                                iconClass: f().iconClasses.info,
                                message: e,
                                optionsOverride: n,
                                title: t
                            })
                        },
                        options: {},
                        subscribe: function(e) {
                            n = e
                        },
                        success: function(e, t, n) {
                            return u({
                                type: o.success,
                                iconClass: f().iconClasses.success,
                                message: e,
                                optionsOverride: n,
                                title: t
                            })
                        },
                        version: "2.1.1",
                        warning: function(e, t, n) {
                            return u({
                                type: o.warning,
                                iconClass: f().iconClasses.warning,
                                message: e,
                                optionsOverride: n,
                                title: t
                            })
                        }
                    };
                    return a;
                    function s(n, i) {
                        return n || (n = f()),
                        (t = e("#" + n.containerId)).length ? t : (i && (t = function(n) {
                            return (t = e("<div/>").attr("id", n.containerId).addClass(n.positionClass).attr("aria-live", "polite").attr("role", "alert")).appendTo(e(n.target)),
                            t
                        }(n)),
                        t)
                    }
                    function l(t, n, i) {
                        var r = !(!i || !i.force) && i.force;
                        return !(!t || !r && 0 !== e(":focus", t).length) && (t[n.hideMethod]({
                            duration: n.hideDuration,
                            easing: n.hideEasing,
                            complete: function() {
                                d(t)
                            }
                        }),
                        !0)
                    }
                    function c(e) {
                        n && n(e)
                    }
                    function u(n) {
                        var o = f()
                          , a = n.iconClass || o.iconClass;
                        if (void 0 !== n.optionsOverride && (o = e.extend(o, n.optionsOverride),
                        a = n.optionsOverride.iconClass || a),
                        !function(e, t) {
                            if (e.preventDuplicates) {
                                if (t.message === i)
                                    return !0;
                                i = t.message
                            }
                            return !1
                        }(o, n)) {
                            r++,
                            t = s(o, !0);
                            var l = null
                              , u = e("<div/>")
                              , h = e("<div/>")
                              , p = e("<div/>")
                              , g = e("<div/>")
                              , v = e(o.closeHtml)
                              , m = {
                                intervalId: null,
                                hideEta: null,
                                maxHideTime: null
                            }
                              , y = {
                                toastId: r,
                                state: "visible",
                                startTime: new Date,
                                options: o,
                                map: n
                            };
                            return n.iconClass && u.addClass(o.toastClass).addClass(a),
                            n.title && (h.append(n.title).addClass(o.titleClass),
                            u.append(h)),
                            n.message && (p.append(n.message).addClass(o.messageClass),
                            u.append(p)),
                            o.closeButton && (v.addClass("md-toast-close-button").attr("role", "button"),
                            u.prepend(v)),
                            o.progressBar && (g.addClass("md-toast-progress"),
                            u.prepend(g)),
                            o.newestOnTop ? t.prepend(u) : t.append(u),
                            u.hide(),
                            u[o.showMethod]({
                                duration: o.showDuration,
                                easing: o.showEasing,
                                complete: o.onShown
                            }),
                            o.timeOut > 0 && (l = setTimeout(b, o.timeOut),
                            m.maxHideTime = parseFloat(o.timeOut),
                            m.hideEta = (new Date).getTime() + m.maxHideTime,
                            o.progressBar && (m.intervalId = setInterval(S, 10))),
                            function() {
                                u.hover(x, w),
                                !o.onclick && o.tapToDismiss && u.click(b);
                                o.closeButton && v && v.click((function(e) {
                                    e.stopPropagation ? e.stopPropagation() : void 0 !== e.cancelBubble && !0 !== e.cancelBubble && (e.cancelBubble = !0),
                                    b(!0)
                                }
                                ));
                                o.onclick && u.click((function() {
                                    o.onclick(),
                                    b()
                                }
                                ))
                            }(),
                            c(y),
                            o.debug && console && console.log(y),
                            u
                        }
                        function b(t) {
                            if (!e(":focus", u).length || t)
                                return clearTimeout(m.intervalId),
                                u[o.hideMethod]({
                                    duration: o.hideDuration,
                                    easing: o.hideEasing,
                                    complete: function() {
                                        d(u),
                                        o.onHidden && "hidden" !== y.state && o.onHidden(),
                                        y.state = "hidden",
                                        y.endTime = new Date,
                                        c(y)
                                    }
                                })
                        }
                        function w() {
                            (o.timeOut > 0 || o.extendedTimeOut > 0) && (l = setTimeout(b, o.extendedTimeOut),
                            m.maxHideTime = parseFloat(o.extendedTimeOut),
                            m.hideEta = (new Date).getTime() + m.maxHideTime)
                        }
                        function x() {
                            clearTimeout(l),
                            m.hideEta = 0,
                            u.stop(!0, !0)[o.showMethod]({
                                duration: o.showDuration,
                                easing: o.showEasing
                            })
                        }
                        function S() {
                            var e = (m.hideEta - (new Date).getTime()) / m.maxHideTime * 100;
                            g.width(e + "%")
                        }
                    }
                    function f() {
                        return e.extend({}, {
                            tapToDismiss: !0,
                            toastClass: "md-toast",
                            containerId: "toast-container",
                            debug: !1,
                            showMethod: "fadeIn",
                            showDuration: 300,
                            showEasing: "swing",
                            onShown: void 0,
                            hideMethod: "fadeOut",
                            hideDuration: 1e3,
                            hideEasing: "swing",
                            onHidden: void 0,
                            extendedTimeOut: 1e3,
                            iconClasses: {
                                error: "md-toast-error",
                                info: "md-toast-info",
                                success: "md-toast-success",
                                warning: "md-toast-warning"
                            },
                            iconClass: "md-toast-info",
                            positionClass: "md-toast-top-right",
                            timeOut: 5e3,
                            titleClass: "md-toast-title",
                            messageClass: "md-toast-message",
                            target: "body",
                            closeHtml: '<button type="button">&times;</button>',
                            newestOnTop: !0,
                            preventDuplicates: !1,
                            progressBar: !1
                        }, a.options)
                    }
                    function d(e) {
                        t || (t = s()),
                        e.is(":visible") || (e.remove(),
                        e = null,
                        0 === t.children().length && (t.remove(),
                        i = void 0))
                    }
                }()
            }
            ))
        }("function" == typeof define && n(24) ? define : function(t, i) {
            e.exports ? e.exports = i(n(64)) : window.toastr = i(window.jQuery)
        }
        )
    }
    ).call(this, n(27)(e))
}
, function(e, t, n) {
    "use strict";
    n(38),
    n(40);
    jQuery((function(e) {
        var t = "ontouchstart"in document.documentElement
          , n = function(e, t) {
            (t && !e.hasClass("active") || !t && e.hasClass("active")) && (e[t ? "addClass" : "removeClass"]("active"),
            document.querySelectorAll("ul .btn-floating").forEach((function(e) {
                return e.classList[t ? "add" : "remove"]("shown")
            }
            )))
        }
          , i = e(".fixed-action-btn:not(.smooth-scroll) > .btn-floating");
        i.on("mouseenter", (function(i) {
            t || n(e(i.currentTarget).parent(), !0)
        }
        )),
        i.parent().on("mouseleave", (function(t) {
            return n(e(t.currentTarget), !1)
        }
        )),
        i.on("click", (function(t) {
            var i;
            t.preventDefault(),
            (i = e(t.currentTarget).parent()).hasClass("active") ? n(i, !1) : n(i, !0)
        }
        )),
        e.fn.extend({
            openFAB: function() {
                n(e(this), !0)
            },
            closeFAB: function() {
                n(e(this), !1)
            }
        })
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(6);
    jQuery((function(e) {
        e(document).on("click.card", ".card", (function(i) {
            var r = e(this).find(".card-reveal");
            if (r.length) {
                var o = e(i.target)
                  , a = o.is(".card-reveal .card-title")
                  , s = o.is(".card-reveal .card-title i")
                  , l = o.is(".card .activator")
                  , c = o.is(".card .activator i");
                a || s ? n(r) : (l || c) && t(r)
            }
        }
        ));
        var t = function(e) {
            e.css({
                display: "block"
            }).velocity({
                translateY: "-100%"
            }, {
                duration: 300,
                queue: !1,
                easing: "easeInOutQuad"
            })
        }
          , n = function(e) {
            e.velocity({
                translateY: 0
            }, {
                duration: 225,
                queue: !1,
                easing: "easeInOutQuad",
                complete: function() {
                    e.css({
                        display: "none"
                    })
                }
            })
        };
        e(".rotate-btn").on("click", (function() {
            e(this).closest(".card").toggleClass("flipped")
        }
        )),
        e(window).on("load", (function() {
            e(".card-rotating").each((function() {
                var t = e(this)
                  , n = t.parent()
                  , i = t.find(".front")
                  , r = t.find(".back")
                  , o = t.find(".front").outerHeight()
                  , a = t.find(".back").outerHeight();
                o > a ? e(n, r).height(o) : o < a ? e(n, i).height(a) : e(n).height(a)
            }
            ))
        }
        )),
        e(".card-share > a").on("click", (function(t) {
            t.preventDefault(),
            e(this).toggleClass("share-expanded").parent().find("div").toggleClass("social-reveal-active")
        }
        )),
        e(".map-card").on("click", (function() {
            e(this).find(".card-body").toggleClass("closed")
        }
        ))
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(31),
    n(6),
    n(61);
    jQuery((function(e) {
        function t() {
            var t = e(this)
              , n = Number(t.attr("length"))
              , i = Number(t.val().length)
              , r = i <= n;
            t.parent().find('span[class="character-counter"]').html("".concat(i, "/").concat(n)),
            function(e, t) {
                var n = t.hasClass("invalid");
                e && n ? t.removeClass("invalid") : e || n || (t.removeClass("valid"),
                t.addClass("invalid"))
            }(r, t)
        }
        function n() {
            e(this).parent().find('span[class="character-counter"]').html("")
        }
        e.fn.characterCounter = function() {
            return this.each((function() {
                var i, r, o = e(this);
                void 0 !== o.attr("length") && (o.on("input focus", t),
                o.on("blur", n),
                i = o,
                r = e("<span/>").addClass("character-counter").css("float", "right").css("font-size", "12px").css("height", 1),
                i.parent().append(r))
            }
            ))
        }
        ,
        e(document).ready((function() {
            e("input, textarea").characterCounter()
        }
        ))
    }
    ))
}
, function(e, t, n) {
    var i = n(100);
    e.exports = function(e) {
        if (i(e))
            throw TypeError("The method doesn't accept regular expressions");
        return e
    }
}
, function(e, t, n) {
    var i = n(4)("match");
    e.exports = function(e) {
        var t = /./;
        try {
            "/./"[e](t)
        } catch (n) {
            try {
                return t[i] = !1,
                "/./"[e](t)
            } catch (e) {}
        }
        return !1
    }
}
, function(e, t, n) {
    "use strict";
    n(36),
    n(6);
    jQuery((function(e) {
        function t(t, i) {
            var r = t.find("> li > .collapsible-header");
            n(i),
            r.not(i).removeClass("active").parent().removeClass("active").children(".collapsible-body").stop(!0, !1).slideUp({
                duration: 350,
                easing: "easeOutQuart",
                queue: !1,
                complete: function() {
                    e(this).css("height", "")
                }
            })
        }
        function n(t) {
            t.hasClass("active") ? t.parent().addClass("active") : t.parent().removeClass("active"),
            t.parent().hasClass("active") ? t.siblings(".collapsible-body").stop(!0, !1).slideDown({
                duration: 350,
                easing: "easeOutQuart",
                queue: !1,
                complete: function() {
                    e(this).css("height", "")
                }
            }) : t.siblings(".collapsible-body").stop(!0, !1).slideUp({
                duration: 350,
                easing: "easeOutQuart",
                queue: !1,
                complete: function() {
                    e(this).css("height", "")
                }
            })
        }
        function i(e) {
            return r(e).length > 0
        }
        function r(e) {
            return e.closest("li > .collapsible-header")
        }
        e.fn.collapsible = function(o) {
            var a = {
                accordion: void 0
            };
            return o = e.extend(a, o),
            this.each((function() {
                var a = e(this)
                  , s = a.find("> li > .collapsible-header")
                  , l = a.data("collapsible");
                a.off("click.collapse", ".collapsible-header"),
                s.off("click.collapse"),
                o.accordion || "accordion" === l || void 0 === l ? (s.on("click.collapse", (function(n) {
                    var o = e(n.target);
                    i(o) && (o = r(o)),
                    o.toggleClass("active"),
                    t(a, o)
                }
                )),
                t(a, s.filter(".active").first())) : s.each((function() {
                    e(this).on("click.collapse", (function(t) {
                        var o = e(t.target);
                        i(o) && (o = r(o)),
                        o.toggleClass("active"),
                        n(o)
                    }
                    )),
                    e(this).hasClass("active") && n(e(this))
                }
                ))
            }
            ))
        }
        ,
        e(".collapsible").collapsible()
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(6),
    n(23),
    n(32),
    n(54),
    n(155);
    jQuery((function(e) {
        e(document).on("change", '.file-field input[type="file"]', (function() {
            var t = e(this);
            console.log(t);
            var n = t.closest(".file-field").find("input.file-path")
              , i = t.get(0).files
              , r = [];
            r = Array.isArray(i) ? i.map((function(e) {
                return e.name
            }
            )) : Object.values(i).map((function(e) {
                return e.name
            }
            )),
            n.val(r.join(", ")),
            n.trigger("change")
        }
        ))
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(6),
    n(109),
    n(12),
    n(44),
    n(110);
    function i(e, t) {
        for (var n = 0; n < t.length; n++) {
            var i = t[n];
            i.enumerable = i.enumerable || !1,
            i.configurable = !0,
            "value"in i && (i.writable = !0),
            Object.defineProperty(e, i.key, i)
        }
    }
    !function(e) {
        var t = function() {
            function t(n, i) {
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t),
                this.defaults = {
                    data: {},
                    dataColor: "",
                    closeColor: "#4285f4",
                    closeBlurColor: "#ced4da",
                    inputFocus: "1px solid #4285f4",
                    inputBlur: "1px solid #ced4da",
                    inputFocusShadow: "0 1px 0 0 #4285f4",
                    inputBlurShadow: "",
                    visibleOptions: 5
                },
                this.enterCharCode = 13,
                this.homeCharCode = 36,
                this.endCharCode = 35,
                this.arrowUpCharCode = 38,
                this.arrowDownCharCode = 40,
                this.tabCharCode = 9,
                this.shiftCharCode = 16,
                this.count = -1,
                this.nextScrollHeight = -45,
                this.$input = n,
                this.options = this.assignOptions(i),
                this.$clearButton = this.$input.next(".mdb-autocomplete-clear"),
                this.$autocompleteWrap = e('<ul class="mdb-autocomplete-wrap"></ul>')
            }
            var n, r, o;
            return n = t,
            (r = [{
                key: "init",
                value: function() {
                    this.handleEvents()
                }
            }, {
                key: "handleEvents",
                value: function() {
                    this.setData(),
                    this.inputFocus(),
                    this.inputBlur(),
                    this.inputKeyupData(),
                    this.inputTabPrevent(),
                    this.inputLiClick(),
                    this.clearAutocomplete(),
                    this.setAutocompleteWrapHeight()
                }
            }, {
                key: "assignOptions",
                value: function(t) {
                    return e.extend({}, this.defaults, t)
                }
            }, {
                key: "setAutocompleteWrapHeight",
                value: function() {
                    this.$autocompleteWrap.css("max-height", "".concat(45 * this.options.visibleOptions, "px"))
                }
            }, {
                key: "setData",
                value: function() {
                    Object.keys(this.options.data).length && this.$autocompleteWrap.insertAfter(this.$input)
                }
            }, {
                key: "inputFocus",
                value: function() {
                    var e = this;
                    this.$input.on("focus", (function() {
                        e.changeSVGcolors(),
                        e.$input.css("border-bottom", e.options.inputFocus),
                        e.$input.css("box-shadow", e.options.inputFocusShadow)
                    }
                    ))
                }
            }, {
                key: "inputBlur",
                value: function() {
                    var e = this;
                    this.$input.on("blur", (function() {
                        e.$input.css("border-bottom", e.options.inputBlur),
                        e.$input.css("box-shadow", e.options.inputBlurShadow),
                        e.$autocompleteWrap.empty()
                    }
                    ))
                }
            }, {
                key: "inputTabPrevent",
                value: function() {
                    var e = this
                      , t = {};
                    this.$input.on("keydown keyup", (function(n) {
                        "keydown" == n.type && e.$input.val() ? (t[n.which] = !0,
                        t[e.shiftCharCode] && t[e.tabCharCode] ? (n.preventDefault(),
                        e.$clearButton.focus()) : t[e.tabCharCode] && !t[e.shiftCharCode] && (n.preventDefault(),
                        e.$clearButton.focus())) : "keyup" == n.type && (t = {})
                    }
                    )),
                    this.$clearButton.on("keydown keyup", (function(n) {
                        "keydown" == n.type && e.$input.val() ? (t[n.which] = !0,
                        t[e.shiftCharCode] && t[e.tabCharCode] ? (n.preventDefault(),
                        e.$input.focus()) : t[e.tabCharCode] && !t[e.shiftCharCode] && (n.preventDefault(),
                        e.$input.focus())) : "keyup" == n.type && (t = {})
                    }
                    ))
                }
            }, {
                key: "inputKeyupData",
                value: function() {
                    var e = this;
                    this.$input.on("keyup change focus", (function(t) {
                        if (t.which === e.enterCharCode)
                            return e.options.data.includes(e.$input.val()) || e.options.data.push(e.$input.val()),
                            e.$autocompleteWrap.find(".selected").trigger("mousedown"),
                            e.$autocompleteWrap.empty(),
                            e.inputBlur(),
                            e.count = -1,
                            e.nextScrollHeight = -45,
                            e.count;
                        var n = e.$input.val();
                        if (e.$autocompleteWrap.empty(),
                        n.length) {
                            e.appendOptions(e.options.data, n);
                            var i = e.$autocompleteWrap
                              , r = e.$autocompleteWrap.find("li")
                              , o = r.eq(e.count).outerHeight()
                              , a = r.eq(e.count - 1).outerHeight();
                            t.which === e.homeCharCode && e.homeHandler(i, r),
                            t.which === e.endCharCode && e.endHandler(i, r),
                            t.which === e.arrowDownCharCode ? e.arrowDownHandler(i, r, o) : t.which === e.arrowUpCharCode && e.arrowUpHandler(i, r, o, a),
                            0 === n.length ? e.$clearButton.css("visibility", "hidden") : e.$clearButton.css("visibility", "visible"),
                            e.$autocompleteWrap.children().css("color", e.options.dataColor)
                        } else
                            e.$clearButton.css("visibility", "hidden")
                    }
                    ))
                }
            }, {
                key: "endHandler",
                value: function(e, t) {
                    this.count = t.length - 1,
                    this.nextScrollHeight = 45 * t.length - 45,
                    e.scrollTop(45 * t.length),
                    t.eq(-1).addClass("selected")
                }
            }, {
                key: "homeHandler",
                value: function(e, t) {
                    this.count = 0,
                    this.nextScrollHeight = -45,
                    e.scrollTop(0),
                    t.eq(0).addClass("selected")
                }
            }, {
                key: "arrowDownHandler",
                value: function(e, t, n) {
                    if (this.count > t.length - 2)
                        return this.count = -1,
                        t.scrollTop(0),
                        void (this.nextScrollHeight = -45);
                    this.count++,
                    this.nextScrollHeight += n,
                    e.scrollTop(this.nextScrollHeight),
                    t.eq(this.count).addClass("selected")
                }
            }, {
                key: "arrowUpHandler",
                value: function(e, t, n, i) {
                    this.count < 1 ? (this.count = t.length,
                    e.scrollTop(e.prop("scrollHeight")),
                    this.nextScrollHeight = e.prop("scrollHeight") - n) : this.count--,
                    this.nextScrollHeight -= i,
                    e.scrollTop(this.nextScrollHeight),
                    t.eq(this.count).addClass("selected")
                }
            }, {
                key: "appendOptions",
                value: function(t, n) {
                    for (var i in t)
                        if (-1 !== t[i].toLowerCase().indexOf(n.toLowerCase())) {
                            var r = e("<li>".concat(t[i], "</li>"));
                            this.$autocompleteWrap.append(r)
                        }
                }
            }, {
                key: "inputLiClick",
                value: function() {
                    var t = this;
                    this.$autocompleteWrap.on("mousedown", "li", (function(n) {
                        n.preventDefault(),
                        t.$input.val(e(n.target).text()),
                        t.$autocompleteWrap.empty()
                    }
                    ))
                }
            }, {
                key: "clearAutocomplete",
                value: function() {
                    var t = this;
                    this.$clearButton.on("click", (function(n) {
                        n.preventDefault(),
                        t.count = -1,
                        t.nextScrollHeight = -45;
                        var i = e(n.currentTarget);
                        i.parent().find(".mdb-autocomplete").val(""),
                        i.css("visibility", "hidden"),
                        t.$autocompleteWrap.empty(),
                        i.parent().find("label").removeClass("active")
                    }
                    ))
                }
            }, {
                key: "changeSVGcolors",
                value: function() {
                    var e = this;
                    this.$input.hasClass("mdb-autocomplete") && (this.$input.on("keyup", (function(t) {
                        e.fillSVG(t, e.options.closeColor)
                    }
                    )),
                    this.$input.on("blur", (function(t) {
                        e.fillSVG(t, e.options.closeBlurColor)
                    }
                    )))
                }
            }, {
                key: "fillSVG",
                value: function(t, n) {
                    t.preventDefault(),
                    e(t.target).parent().find(".mdb-autocomplete-clear").find("svg").css("fill", n)
                }
            }]) && i(n.prototype, r),
            o && i(n, o),
            t
        }();
        e.fn.mdbAutocomplete = function(n) {
            return this.each((function() {
                new t(e(this),n).init()
            }
            ))
        }
    }(jQuery)
}
, function(e, t) {
    var n = !1;
    function i() {
        $("#mdb-preloader").fadeOut("slow"),
        $("body").removeAttr("aria-busy")
    }
    $(window).on("load", (function() {
        n = !0
    }
    )),
    jQuery((function(e) {
        e("body").attr("aria-busy", !0),
        e("#preloader-markup").load("./dev/dist/mdb-addons/preloader.html", (function() {
            n ? i() : e(window).on("load", (function() {
                i()
            }
            ))
        }
        ))
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(6);
    jQuery((function(e) {
        var t = "input[type=range]:not(.custom-range):not(.multi-range)"
          , n = '<span class="thumb" style="margin-left: 7px"><span class="value"></span></span>'
          , i = !1;
        function r(e, t) {
            var n = e.attr("min")
              , i = e.attr("max")
              , r = e.width() - 13.5
              , o = r / (i - n)
              , a = o * e.val() - o * n;
            a < 0 ? a = 0 : a > r && (a = r),
            t.addClass("active").css("left", a)
        }
        function o(e, t, n, i, r, o, a) {
            e.velocity({
                height: t,
                width: n,
                top: i,
                marginLeft: r
            }, {
                duration: o,
                easing: a || "swing"
            })
        }
        function a(e) {
            o(e, "30px", "30px", "-27px", "-7px", 200, "easeOutExpo")
        }
        function s(e) {
            o(e, "0", "0", "10px", "7px", 200)
        }
        e(document).on("change", t, (function() {
            var t = e(this);
            t.siblings(".thumb").find(".value").html(t.val())
        }
        )),
        e(document).on("mousedown touchstart contextmenu", t, (function(o) {
            var s = e(this)
              , l = !s.siblings(".thumb").length
              , c = "contextmenu" === o.type;
            l && function() {
                var i = e(n);
                e(t).after(i)
            }();
            var u = s.siblings(".thumb");
            i = !c,
            s.addClass("active"),
            u.hasClass("active") || a(u),
            r(e(this), u),
            u.find(".value").html(s.val())
        }
        )),
        e(document).on("mouseup touchend", ".range-field", (function() {
            var t = e(this).children(".thumb");
            i = !1,
            t.hasClass("active") && s(t),
            t.removeClass("active")
        }
        )),
        e(document).on("input mousemove touchmove", ".range-field", (function() {
            var n = e(this).children(".thumb");
            i && (n.hasClass("active") || a(n),
            r(e(this).children(t), n),
            n.find(".value").html(n.siblings(t).val()))
        }
        )),
        e(document).on("mouseout touchleave", ".range-field", (function() {
            if (!i) {
                var t = e(this).children(".thumb");
                t.hasClass("active") && s(t),
                t.removeClass("active")
            }
        }
        ))
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(10),
    n(16),
    n(17),
    n(6),
    n(8),
    n(13),
    n(61),
    n(7),
    n(29),
    n(18),
    n(19);
    function i(e, t) {
        return function(e) {
            if (Array.isArray(e))
                return e
        }(e) || function(e, t) {
            if (!(Symbol.iterator in Object(e) || "[object Arguments]" === Object.prototype.toString.call(e)))
                return;
            var n = []
              , i = !0
              , r = !1
              , o = void 0;
            try {
                for (var a, s = e[Symbol.iterator](); !(i = (a = s.next()).done) && (n.push(a.value),
                !t || n.length !== t); i = !0)
                    ;
            } catch (e) {
                r = !0,
                o = e
            } finally {
                try {
                    i || null == s.return || s.return()
                } finally {
                    if (r)
                        throw o
                }
            }
            return n
        }(e, t) || function() {
            throw new TypeError("Invalid attempt to destructure non-iterable instance")
        }()
    }
    function r(e, t) {
        for (var n = 0; n < t.length; n++) {
            var i = t[n];
            i.enumerable = i.enumerable || !1,
            i.configurable = !0,
            "value"in i && (i.writable = !0),
            Object.defineProperty(e, i.key, i)
        }
    }
    jQuery((function(e) {
        var t = function() {
            function t(n, i) {
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t),
                this.settings = {
                    menuLeftMinBorder: .3,
                    menuLeftMaxBorder: -.5,
                    menuRightMinBorder: -.3,
                    menuRightMaxBorder: .5,
                    menuVelocityOffset: 10
                },
                this.defaults = {
                    menuWidth: 240,
                    edge: "left",
                    closeOnClick: !1,
                    breakpoint: 1440,
                    timeDurationOpen: 500,
                    timeDurationClose: 500,
                    timeDurationOverlayOpen: 200,
                    timeDurationOverlayClose: 200,
                    easingOpen: "easeInOutQuad",
                    easingClose: "easeInOutQuad",
                    showOverlay: !0,
                    showCloseButton: !1,
                    slim: !1,
                    onOpen: null,
                    onClose: null
                },
                this.$element = n,
                this.$elementCloned = n.clone().css({
                    display: "inline-block",
                    lineHeight: "24px"
                }).html('<i class="fas fa-times"></i>'),
                this.options = this.assignOptions(i),
                this.menuOut = !1,
                this.lastTouchVelocity = {
                    x: {
                        startPosition: 0,
                        startTime: 0,
                        endPosition: 0,
                        endTime: 0
                    }
                },
                this.$body = e("body"),
                this.$menu = e("#".concat(this.$element.attr("data-activates"))),
                this.$sidenavOverlay = e("#sidenav-overlay"),
                this.$dragTarget = e('<div class="drag-target"></div>'),
                this.isTouchDevice = "ontouchstart"in document.documentElement,
                this.$body.append(this.$dragTarget)
            }
            var n, o, a;
            return n = t,
            (o = [{
                key: "assignOptions",
                value: function(t) {
                    return e.extend({}, this.defaults, t)
                }
            }, {
                key: "init",
                value: function() {
                    this.setMenuWidth(),
                    this.setMenuTranslation(),
                    this.closeOnClick(),
                    this.openOnClick(),
                    this.bindTouchEvents(),
                    this.showCloseButton(),
                    this.inputOnClick(),
                    !0 === this.options.slim && this.handleSlim(),
                    this.onOpen(),
                    this.onClose(),
                    this.options[0] + this.options[1] + this.options[2] + this.options[3] === "show" && !1 === this.menuOut && this.$element.trigger("click"),
                    this.options[0] + this.options[1] + this.options[2] + this.options[3] === "hide" && !0 === this.menuOut && this.removeMenu()
                }
            }, {
                key: "setMenuWidth",
                value: function() {
                    var t = e("#".concat(this.$menu.attr("id"))).find("> .sidenav-bg");
                    this.$menu.css("width", this.options.menuWidth),
                    t.css("width", this.options.menuWidth)
                }
            }, {
                key: "setMenuTranslation",
                value: function() {
                    var t = this;
                    "left" === this.options.edge ? (this.$menu.css("transform", "translateX(-100%)"),
                    this.$dragTarget.css({
                        left: 0
                    })) : (this.$menu.addClass("right-aligned").css("transform", "translateX(100%)"),
                    this.$dragTarget.css({
                        right: 0
                    })),
                    this.$menu.hasClass("fixed") && (window.innerWidth > this.options.breakpoint ? (this.menuOut = !0,
                    this.$menu.css("transform", "translateX(0)")) : this.menuOut = !1,
                    this.$menu.find("input[type=text]").on("touchstart", (function() {
                        t.$menu.addClass("transform-fix-input")
                    }
                    )),
                    e(window).on("resize", (function() {
                        if (t.isTouchDevice || e(".fixed-sn main, .fixed-sn footer").css("padding-left", t.options.menuWidth),
                        window.innerWidth > t.options.breakpoint)
                            t.$sidenavOverlay.length ? (t.removeMenu(!0),
                            e(".fixed-sn main, .fixed-sn footer").css("padding-left", t.options.menuWidth)) : (!1 === t.menuOut && e(t).trigger("sidenav_open", [t.options.onOpen]),
                            t.$menu.css("transform", "translateX(0%)"),
                            t.menuOut = !0);
                        else if (!1 !== t.menuOut || t.isTouchDevice)
                            t.isTouchDevice || (t.menuOut = !1,
                            t.removeMenu(!0));
                        else {
                            var n = "left" === t.options.edge ? "-100" : "100";
                            t.$menu.css("transform", "translateX(".concat(n, "%)")),
                            t.removeMenu(!0)
                        }
                    }
                    )))
                }
            }, {
                key: "closeOnClick",
                value: function() {
                    var e = this;
                    !0 === this.options.closeOnClick && (this.$menu.on("click", "a:not(.collapsible-header)", (function() {
                        return e.removeMenu()
                    }
                    )),
                    "translateX(0)" === this.$menu.css("transform") && this.$menu.on("click", (function() {
                        return e.removeMenu()
                    }
                    )))
                }
            }, {
                key: "onOpen",
                value: function(t) {
                    e(this).on("sidenav_open", (function(e, t) {
                        "function" == typeof t && t()
                    }
                    ))
                }
            }, {
                key: "onClose",
                value: function(t) {
                    e(this).on("sidenav_close", (function(e, t) {
                        "function" == typeof t && t()
                    }
                    ))
                }
            }, {
                key: "openOnClick",
                value: function() {
                    var t = this;
                    this.$element.on("click", (function(n) {
                        if (n.preventDefault(),
                        !0 === t.menuOut)
                            return t.removeMenu();
                        e(t).trigger("sidenav_open", [t.options.onOpen]),
                        t.menuOut = !0,
                        !0 === t.options.showOverlay ? e("#sidenav-overlay").length || t.showSidenavOverlay() : t.showCloseButton();
                        var i = [];
                        i = "left" === t.options.edge ? [0, -1 * t.options.menuWidth] : [0, t.options.menuWidth],
                        "matrix(1, 0, 0, 1, 0, 0)" !== t.$menu.css("transform") && t.$menu.velocity({
                            translateX: i
                        }, {
                            duration: t.options.timeDurationOpen,
                            queue: !1,
                            easing: t.options.easingOpen
                        }),
                        t.$sidenavOverlay.on("touchmove", t.touchmoveEventHandler.bind(t)),
                        t.$menu.on("touchmove", (function(e) {
                            e.preventDefault(),
                            t.$menu.find(".custom-scrollbar").css("padding-bottom", "30px")
                        }
                        )),
                        !1 === t.options.showOverlay && (t.menuOut = !0)
                    }
                    ))
                }
            }, {
                key: "bindTouchEvents",
                value: function() {
                    var e = this;
                    this.$dragTarget.on("click", (function() {
                        e.menuOut && e.removeMenu()
                    }
                    )),
                    this.$dragTarget.on("touchstart", (function(t) {
                        e.lastTouchVelocity.x.startPosition = t.touches[0].clientX,
                        e.lastTouchVelocity.x.startTime = Date.now()
                    }
                    )),
                    this.$dragTarget.on("touchmove", this.touchmoveEventHandler.bind(this)),
                    this.$dragTarget.on("touchend", this.touchendEventHandler.bind(this))
                }
            }, {
                key: "showCloseButton",
                value: function() {
                    !0 === this.options.showCloseButton && (this.$menu.prepend(this.$elementCloned),
                    this.$menu.find(".logo-wrapper").css({
                        borderTop: "1px solid rgba(153,153,153,.3)"
                    }))
                }
            }, {
                key: "inputOnClick",
                value: function() {
                    var e = this;
                    this.$menu.find("input[type=text]").on("touchstart", (function() {
                        return e.$menu.css("transform", "translateX(0)")
                    }
                    ))
                }
            }, {
                key: "removeMenu",
                value: function(t) {
                    var n = this;
                    this.$body.css({
                        overflow: "",
                        width: ""
                    }),
                    this.$menu.velocity({
                        translateX: "left" === this.options.edge ? "-100%" : "100%"
                    }, {
                        duration: this.options.timeDurationClose,
                        queue: !1,
                        easing: this.options.easingClose,
                        complete: function() {
                            !0 === t && (n.$menu.removeAttr("style"),
                            n.$menu.css("width", n.options.menuWidth))
                        }
                    }),
                    this.$menu.removeClass("transform-fix-input"),
                    this.hideSidenavOverlay(),
                    this.menuOut = !1,
                    e(".fixed-sn .double-nav").css("padding-left", "unset"),
                    e(".fixed-sn main, .fixed-sn footer").css({
                        "padding-left": "0"
                    }),
                    e(this).trigger("sidenav_close", [this.options.onClose])
                }
            }, {
                key: "handleSlim",
                value: function() {
                    var t = this;
                    e("#toggle").on("click", (function() {
                        t.$menu.hasClass("slim") ? (t.$menu.removeClass("slim"),
                        e(".sv-slim-icon").removeClass("fa-angle-double-right").addClass("fa-angle-double-left"),
                        e(".fixed-sn .double-nav").css({
                            transition: "all .3s ease-in-out",
                            "padding-left": "15.9rem"
                        }),
                        e(".fixed-sn main, .fixed-sn footer").css({
                            transition: "all .3s ease-in-out",
                            "padding-left": "15rem"
                        })) : (t.$menu.addClass("slim"),
                        e(".sv-slim-icon").removeClass("fa-angle-double-left").addClass("fa-angle-double-right"),
                        e(".fixed-sn .double-nav").css("padding-left", "4.6rem"),
                        e(".fixed-sn main, .fixed-sn footer").css({
                            "padding-left": "3.7rem"
                        }))
                    }
                    ))
                }
            }, {
                key: "touchmoveEventHandler",
                value: function(e) {
                    if ("touchmove" === e.type) {
                        var t = i(e.touches, 1)[0]
                          , n = t.clientX;
                        Date.now() - this.lastTouchVelocity.x.startTime > 20 && (this.lastTouchVelocity.x.startPosition = t.clientX,
                        this.lastTouchVelocity.x.startTime = Date.now()),
                        this.disableScrolling(),
                        0 !== this.$sidenavOverlay.length || this.buildSidenavOverlay(),
                        "left" === this.options.edge && (n > this.options.menuWidth ? n = this.options.menuWidth : n < 0 && (n = 0)),
                        this.translateSidenavX(n),
                        this.updateOverlayOpacity(n)
                    }
                }
            }, {
                key: "calculateTouchVelocityX",
                value: function() {
                    return Math.abs(this.lastTouchVelocity.x.endPosition - this.lastTouchVelocity.x.startPosition) / Math.abs(this.lastTouchVelocity.x.endTime - this.lastTouchVelocity.x.startTime)
                }
            }, {
                key: "touchendEventHandler",
                value: function(e) {
                    if ("touchend" === e.type) {
                        var t = e.changedTouches[0];
                        this.lastTouchVelocity.x.endTime = Date.now(),
                        this.lastTouchVelocity.x.endPosition = t.clientX;
                        var n = this.calculateTouchVelocityX()
                          , i = t.clientX
                          , r = i - this.options.menuWidth
                          , o = i - this.options.menuWidth / 2;
                        r > 0 && (r = 0),
                        o < 0 && (o = 0),
                        "left" === this.options.edge ? (this.menuOut || n <= this.settings.menuLeftMinBorder || n < this.options.menuLeftMaxBorder ? (0 !== r && this.translateMenuX([0, r], "300"),
                        this.showSidenavOverlay()) : (!this.menuOut || n > this.settings.menuLeftMinBorder) && (this.enableScrolling(),
                        this.translateMenuX([-1 * this.options.menuWidth - this.options.menuVelocityOffset, r], "200"),
                        this.hideSidenavOverlay()),
                        this.$dragTarget.css({
                            width: "10px",
                            right: "",
                            left: 0
                        })) : this.menuOut && n >= this.settings.menuRightMinBorder || n > this.settings.menuRightMaxBorder ? (this.translateMenuX([0, o], "300"),
                        this.showSidenavOverlay(),
                        this.$dragTarget.css({
                            width: "50%",
                            right: "",
                            left: 0
                        })) : (!this.menuOut || n < this.settings.menuRightMinBorder) && (this.enableScrolling(),
                        this.translateMenuX([this.options.menuWidth + this.options.menuVelocityOffset, o], "200"),
                        this.hideSidenavOverlay(),
                        this.$dragTarget.css({
                            width: "10px",
                            right: 0,
                            left: ""
                        }))
                    }
                }
            }, {
                key: "buildSidenavOverlay",
                value: function() {
                    var t = this;
                    !0 === this.options.showOverlay && (this.$sidenavOverlay = e('<div id="sidenav-overlay"></div>'),
                    this.$sidenavOverlay.css("opacity", 0).on("click", (function() {
                        return t.removeMenu()
                    }
                    )),
                    this.$body.append(this.$sidenavOverlay))
                }
            }, {
                key: "disableScrolling",
                value: function() {
                    var e = this.$body.innerWidth();
                    this.$body.css("overflow", "hidden"),
                    this.$body.width(e)
                }
            }, {
                key: "enableScrolling",
                value: function() {
                    this.$body.css({
                        overflow: "",
                        width: ""
                    })
                }
            }, {
                key: "translateMenuX",
                value: function(e, t) {
                    this.$menu.velocity({
                        translateX: e
                    }, {
                        duration: "string" == typeof t ? Number(t) : t,
                        queue: !1,
                        easing: this.options.easingOpen
                    })
                }
            }, {
                key: "translateSidenavX",
                value: function(e) {
                    if ("left" === this.options.edge) {
                        var t = e >= this.options.menuWidth / 2;
                        this.menuOut = t,
                        this.$menu.css("transform", "translateX(".concat(e - this.options.menuWidth, "px)"))
                    } else {
                        var n = e < window.innerWidth - this.options.menuWidth / 2;
                        this.menuOut = n;
                        var i = e - this.options.menuWidth / 2;
                        i < 0 && (i = 0),
                        this.$menu.css("transform", "translateX(".concat(i, "px)"))
                    }
                }
            }, {
                key: "updateOverlayOpacity",
                value: function(e) {
                    var t;
                    t = "left" === this.options.edge ? e / this.options.menuWidth : Math.abs((e - window.innerWidth) / this.options.menuWidth),
                    this.$sidenavOverlay.velocity({
                        opacity: t
                    }, {
                        duration: 10,
                        queue: !1,
                        easing: this.options.easingOpen
                    })
                }
            }, {
                key: "showSidenavOverlay",
                value: function() {
                    !0 !== this.options.showOverlay || e("#sidenav-overlay").length || this.buildSidenavOverlay(),
                    this.$sidenavOverlay.velocity({
                        opacity: 1
                    }, {
                        duration: this.options.timeDurationOverlayOpen,
                        queue: !1,
                        easing: this.options.easingOpen
                    })
                }
            }, {
                key: "hideSidenavOverlay",
                value: function() {
                    this.$sidenavOverlay.velocity({
                        opacity: 0
                    }, {
                        duration: this.options.timeDurationOverlayClose,
                        queue: !1,
                        easing: this.options.easingOpen,
                        complete: function() {
                            e(this).remove()
                        }
                    })
                }
            }]) && r(n.prototype, o),
            a && r(n, a),
            t
        }();
        e.fn.sideNav = function(n) {
            e(this).each((function() {
                new t(e(this),n).init()
            }
            ))
        }
        ,
        e(".side-nav").on("touchmove", (function(e) {
            e.stopPropagation()
        }
        ), !1)
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(10),
    n(16),
    n(17),
    n(12),
    n(8),
    n(7),
    n(18),
    n(19);
    function i(e) {
        return (i = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
            return typeof e
        }
        : function(e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        }
        )(e)
    }
    jQuery((function() {
        $(".smooth-scroll").on("click", "a", (function(e) {
            e.preventDefault();
            var t = $(this)
              , n = t.attr("href");
            if (void 0 !== i(n) && 0 === n.indexOf("#")) {
                var r = $(this).attr("data-offset") || 0;
                $("body,html").animate({
                    scrollTop: $(n).offset().top - r
                }, 700);
                var o = t.parentsUntil(".smooth-scroll").last().parent().attr("data-allow-hashes");
                void 0 !== i(o) && !1 !== o && history.replaceState(null, null, n)
            }
        }
        ))
    }
    ))
}
, function(e, t) {
    function n(e, t) {
        for (var n = 0; n < t.length; n++) {
            var i = t[n];
            i.enumerable = i.enumerable || !1,
            i.configurable = !0,
            "value"in i && (i.writable = !0),
            Object.defineProperty(e, i.key, i)
        }
    }
    jQuery((function(e) {
        var t = function() {
            function t(n, i) {
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t),
                this.defaults = {
                    topSpacing: 0,
                    zIndex: !1,
                    stopper: "#footer",
                    stickyClass: !1,
                    startScrolling: "top",
                    minWidth: !1
                },
                this.$element = n,
                this.options = this.assignOptions(i),
                this.$window = e(window),
                this.stopper = this.options.stopper,
                this.elementWidth = this.$element.outerWidth(),
                this.elementHeight = this.$element.outerHeight(!0),
                this.initialScrollTop = this.$element.offset().top,
                this.$placeholder = e('<div class="sticky-placeholder"></div>'),
                this.scrollTop = 0,
                this.setPushPoint(),
                this.setStopperPosition(),
                this.bindEvents()
            }
            var i, r, o;
            return i = t,
            (r = [{
                key: "hasZIndex",
                value: function() {
                    return "number" == typeof this.options.zIndex
                }
            }, {
                key: "hasStopper",
                value: function() {
                    return e(this.options.stopper).length || "number" == typeof this.options.stopper
                }
            }, {
                key: "isScreenHeightEnough",
                value: function() {
                    return this.$element.outerHeight() + this.options.topSpacing < this.$window.height()
                }
            }, {
                key: "assignOptions",
                value: function(t) {
                    return e.extend({}, this.defaults, t)
                }
            }, {
                key: "setPushPoint",
                value: function() {
                    "bottom" !== this.options.startScrolling || this.isScreenHeightEnough() ? this.$pushPoint = this.initialScrollTop - this.options.topSpacing : this.$pushPoint = this.initialScrollTop + this.$element.outerHeight(!0) - this.$window.height()
                }
            }, {
                key: "setStopperPosition",
                value: function() {
                    "string" == typeof this.options.stopper ? this.stopPoint = e(this.stopper).offset().top - this.options.topSpacing : "number" == typeof this.options.stopper && (this.stopPoint = this.options.stopper)
                }
            }, {
                key: "bindEvents",
                value: function() {
                    this.$window.on("resize", this.handleResize.bind(this)),
                    this.$window.on("scroll", this.init.bind(this))
                }
            }, {
                key: "handleResize",
                value: function() {
                    var e = this.$element.parent();
                    this.elementWidth = e.width(),
                    this.elementHeight = this.$element.outerHeight(!0),
                    this.setPushPoint(),
                    this.setStopperPosition(),
                    this.init()
                }
            }, {
                key: "init",
                value: function() {
                    if (this.options.minWidth && this.options.minWidth > this.$window.innerWidth())
                        return !1;
                    "bottom" !== this.options.startScrolling || this.isScreenHeightEnough() ? this.scrollTop = this.$window.scrollTop() : this.scrollTop = this.$window.scrollTop() + this.$window.height(),
                    this.$pushPoint < this.scrollTop ? (this.appendPlaceholder(),
                    this.stickyStart()) : this.stickyEnd(),
                    this.$window.scrollTop() > this.$pushPoint ? this.stop() : this.stickyEnd()
                }
            }, {
                key: "appendPlaceholder",
                value: function() {
                    this.$element.after(this.$placeholder),
                    this.$placeholder.css({
                        width: this.elementWidth,
                        height: this.elementHeight
                    })
                }
            }, {
                key: "stickyStart",
                value: function() {
                    this.options.stickyClass && this.$element.addClass(this.options.stickyClass),
                    this.$element.get(0).style.overflow = "scroll";
                    var e = this.$element.get(0).scrollHeight;
                    this.$element.get(0).style.overflow = "",
                    this.$element.css({
                        position: "fixed",
                        width: this.elementWidth,
                        height: e
                    }),
                    "bottom" !== this.options.startScrolling || this.isScreenHeightEnough() ? this.$element.css({
                        top: this.options.topSpacing
                    }) : this.$element.css({
                        bottom: 0,
                        top: ""
                    }),
                    this.hasZIndex() && this.$element.css({
                        zIndex: this.options.zIndex
                    })
                }
            }, {
                key: "stickyEnd",
                value: function() {
                    this.options.stickyClass && this.$element.removeClass(this.options.stickyClass),
                    this.$placeholder.remove(),
                    this.$element.css({
                        position: "static",
                        top: this.options.topSpacing,
                        width: "",
                        height: ""
                    })
                }
            }, {
                key: "stop",
                value: function() {
                    this.stopPoint < e(this.$element).offset().top - this.options.topSpacing + this.$element.outerHeight(!0) && this.$element.css({
                        position: "absolute",
                        bottom: 0,
                        top: ""
                    })
                }
            }]) && n(i.prototype, r),
            o && n(i, o),
            t
        }();
        e.fn.sticky = function(n) {
            e(this).each((function() {
                new t(e(this),n).init()
            }
            ))
        }
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(10),
    n(31),
    n(36),
    n(6),
    n(38),
    n(23),
    n(134),
    n(135),
    n(44),
    n(40);
    function i(e, t) {
        var n = Object.keys(e);
        if (Object.getOwnPropertySymbols) {
            var i = Object.getOwnPropertySymbols(e);
            t && (i = i.filter((function(t) {
                return Object.getOwnPropertyDescriptor(e, t).enumerable
            }
            ))),
            n.push.apply(n, i)
        }
        return n
    }
    function r(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n,
        e
    }
    function o(e, t) {
        for (var n = 0; n < t.length; n++) {
            var i = t[n];
            i.enumerable = i.enumerable || !1,
            i.configurable = !0,
            "value"in i && (i.writable = !0),
            Object.defineProperty(e, i.key, i)
        }
    }
    jQuery((function(e) {
        var t = function() {
            function t(n) {
                var i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t),
                this.$activator = n,
                this.$activates = e("#".concat(n.attr("data-activates"))),
                this.options = {
                    inDuration: this.fallback().or(n.data("induration")).or(n.attr("data-in-duration")).or(i.inDuration).or(300).value(),
                    outDuration: this.fallback().or(n.data("outduration")).or(n.attr("data-out-duration")).or(i.outDuration).or(225).value(),
                    easingEffectIn: this.fallback().or(n.data("easingeffectin")).or(n.attr("data-easing-effect-in")).or(i.easingEffectIn).or("easeOutCubic").value(),
                    easingEffectOut: this.fallback().or(n.data("easingeffectout")).or(n.attr("data-easing-effect-out")).or(i.easingEffectOut).or("swing").value(),
                    constrainWidth: this.fallback().or(n.data("constrainwidth")).or(n.attr("data-constrain-width")).or(i.constrainWidth).or(!0).value(),
                    hover: this.fallback().or(n.data("hover")).or(n.attr("data-hover")).or(i.hover).or(!1).value(),
                    gutter: this.fallback().or(n.data("gutter")).or(n.attr("data-gutter")).or(i.gutter).or(0).value(),
                    belowOrigin: this.fallback().or(n.data("beloworigin")).or(n.attr("data-below-origin")).or(i.belowOrigin).or(!1).value(),
                    alignment: this.fallback().or(n.data("alignment")).or(n.attr("data-alignment")).or(i.alignment).or("left").value(),
                    maxHeight: this.fallback().or(n.data("maxheight")).or(n.attr("data-max-height")).or(i.maxHeight).or("").value(),
                    resetScroll: this.fallback().or(n.data("resetscroll")).or(n.attr("data-reset-scroll")).or(i.resetScroll).or(!0).value()
                },
                this.isFocused = !1
            }
            var n, a, s;
            return n = t,
            s = [{
                key: "mdbDropdownAutoInit",
                value: function() {
                    e(".dropdown-button").dropdown(),
                    this.bindMultiLevelDropdownEvents(),
                    this.bindBootstrapEvents()
                }
            }, {
                key: "bindMultiLevelDropdownEvents",
                value: function() {
                    e(".multi-level-dropdown .dropdown-submenu > a").on("mouseenter", (function(t) {
                        var n = e(this);
                        e(".multi-level-dropdown .dropdown-submenu .dropdown-menu").removeClass("show"),
                        n.next(".dropdown-menu").addClass("show"),
                        t.stopPropagation()
                    }
                    )),
                    e(".multi-level-dropdown .dropdown").on("hidden.bs.dropdown", (function() {
                        e(".multi-level-dropdown .dropdown-menu.show").removeClass("show")
                    }
                    ))
                }
            }, {
                key: "bindBootstrapEvents",
                value: function() {
                    var t = this;
                    e(".dropdown, .dropup").on({
                        "show.bs.dropdown": function(n) {
                            var i = e(n.target)
                              , r = t._getDropdownEffects(i);
                            t._dropdownEffectStart(i, r.effectIn)
                        },
                        "shown.bs.dropdown": function(n) {
                            var i = e(n.target)
                              , r = t._getDropdownEffects(i);
                            r.effectIn && r.effectOut && t._dropdownEffectEnd(i, r)
                        },
                        "hide.bs.dropdown": function(n) {
                            var i = window.matchMedia("(prefers-reduced-motion: reduce)").matches
                              , r = e(n.target)
                              , o = t._getDropdownEffects(r);
                            o.effectOut && (i || n.preventDefault(),
                            t._dropdownEffectStart(r, o.effectOut),
                            t._dropdownEffectEnd(r, o, (function() {
                                r.removeClass("show"),
                                r.find(".dropdown-menu").removeClass("show")
                            }
                            )))
                        }
                    })
                }
            }, {
                key: "_getDropdownEffects",
                value: function(e) {
                    var t = "fadeIn"
                      , n = "fadeOut"
                      , i = e.find(".dropdown-menu")
                      , r = e.parents("ul.nav");
                    return r.height > 0 && (t = r.data("dropdown-in") || null,
                    n = r.data("dropdown-out") || null),
                    {
                        effectIn: i.data("dropdown-in") || t,
                        effectOut: i.data("dropdown-out") || n
                    }
                }
            }, {
                key: "_dropdownEffectStart",
                value: function(e, t) {
                    t && (e.addClass("dropdown-animating"),
                    e.find(".dropdown-menu").addClass(["animated", t].join(" ")))
                }
            }, {
                key: "_dropdownEffectEnd",
                value: function(e, t, n) {
                    e.one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", (function() {
                        e.removeClass("dropdown-animating"),
                        e.find(".dropdown-menu").removeClass(["animated", t.effectIn, t.effectOut].join(" ")),
                        "function" == typeof n && n()
                    }
                    ))
                }
            }],
            (a = [{
                key: "returnPublicInterface",
                value: function() {
                    return {
                        $activator: this.$activator,
                        $activates: this.$activates,
                        updatePosition: this.updatePosition.bind(this)
                    }
                }
            }, {
                key: "init",
                value: function() {
                    this.appendDropdownToActivator(),
                    this.options.hover ? this.handleHoverableDropdown() : this.handleClickableDropdown(),
                    this.bindEvents()
                }
            }, {
                key: "appendDropdownToActivator",
                value: function() {
                    this.$activator.after(this.$activates)
                }
            }, {
                key: "handleHoverableDropdown",
                value: function() {
                    var t = this
                      , n = !1;
                    this.$activator.unbind("click.".concat(this.$activator.attr("id"))),
                    this.$activator.on("mouseenter", (function() {
                        !1 === n && (t.placeDropdown(),
                        n = !0)
                    }
                    )),
                    this.$activator.on("mouseleave", (function(i) {
                        var r = i.toElement || i.relatedTarget;
                        e(r).closest(".dropdown-content").is(t.$activates) || (t.$activates.stop(!0, !0),
                        t.hideDropdown(),
                        n = !1)
                    }
                    )),
                    this.$activates.on("mouseleave", (function(i) {
                        var r = i.toElement || i.relatedTarget;
                        e(r).closest(".dropdown-button").is(t.$activator) || (t.$activates.stop(!0, !0),
                        t.hideDropdown(),
                        n = !1)
                    }
                    ))
                }
            }, {
                key: "handleClickableDropdown",
                value: function() {
                    var t = this;
                    this.$activator.unbind("click.".concat(this.$activator.attr("id"))),
                    this.$activator.bind("click.".concat(this.$activator.attr("id")), (function(n) {
                        if (!t.isFocused) {
                            var i = t.$activator.get(0) === n.currentTarget
                              , r = t.$activator.hasClass("active")
                              , o = 0 !== e(n.target).closest(".dropdown-content").length;
                            !i || r || o ? r && (t.hideDropdown(),
                            e(document).unbind("click.".concat(t.$activates.attr("id"), " touchstart.").concat(t.$activates.attr("id")))) : (n.preventDefault(),
                            t.placeDropdown("click")),
                            t.$activates.hasClass("active") && e(document).bind("click.".concat(t.$activates.attr("id"), " touchstart.").concat(t.$activates.attr("id")), (function(n) {
                                !t.$activates.is(n.target) && !t.$activator.is(n.target) && !t.$activator.find(n.target).length && (t.hideDropdown(),
                                e(document).unbind("click.".concat(t.$activates.attr("id"), " touchstart.").concat(t.$activates.attr("id"))))
                            }
                            ))
                        }
                    }
                    ))
                }
            }, {
                key: "bindEvents",
                value: function() {
                    var e = this;
                    this.$activator.on("open", (function(t, n) {
                        e.placeDropdown(n)
                    }
                    )),
                    this.$activator.on("close", this.hideDropdown.bind(this))
                }
            }, {
                key: "placeDropdown",
                value: function(e) {
                    "focus" === e && (this.isFocused = !0),
                    this.$activates.addClass("active"),
                    this.$activator.addClass("active"),
                    !0 === this.options.constrainWidth ? this.$activates.css("width", this.$activator.outerWidth()) : this.$activates.css("white-space", "nowrap"),
                    this.updatePosition(),
                    this.showDropdown()
                }
            }, {
                key: "showDropdown",
                value: function() {
                    this.$activates.stop(!0, !0).css("opacity", 0).slideDown({
                        queue: !1,
                        duration: this.options.inDuration,
                        easing: this.options.easingEffectIn,
                        complete: function() {
                            e(this).css("height", "")
                        }
                    }).animate(function(e) {
                        for (var t = 1; t < arguments.length; t++) {
                            var n = null != arguments[t] ? arguments[t] : {};
                            t % 2 ? i(n, !0).forEach((function(t) {
                                r(e, t, n[t])
                            }
                            )) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n)) : i(n).forEach((function(t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t))
                            }
                            ))
                        }
                        return e
                    }({
                        opacity: 1
                    }, this.options.resetScroll && {
                        scrollTop: 0
                    }), {
                        queue: !1,
                        duration: this.options.inDuration,
                        easing: "easeOutSine"
                    })
                }
            }, {
                key: "hideDropdown",
                value: function() {
                    var e = this;
                    this.isFocused = !1,
                    this.$activates.fadeOut({
                        durations: this.options.outDuration,
                        easing: this.options.easingEffectOut
                    }),
                    this.$activates.removeClass("active"),
                    this.$activator.removeClass("active"),
                    setTimeout((function() {
                        e.$activates.css("max-height", e.options.maxHeight)
                    }
                    ), this.options.outDuration)
                }
            }, {
                key: "updatePosition",
                value: function() {
                    var t = window.innerHeight
                      , n = this.$activator.innerHeight()
                      , i = this.$activator.offset().top - e(window).scrollTop()
                      , r = this._getHorizontalAlignment()
                      , o = 0
                      , a = 0
                      , s = this.$activator.parent()
                      , l = this.options.belowOrigin ? n : 0
                      , c = !s.is("body") && s.get(0).scrollHeight > s.get(0).clientHeight ? s.get(0).scrollTop : 0
                      , u = i + this.$activates.innerHeight() > t
                      , f = i + n - this.$activates.innerHeight() < 0;
                    if (u && f) {
                        var d = t - i - l;
                        this.$activates.css("max-height", d)
                    } else
                        u && (l || (l += n),
                        l -= this.$activates.innerHeight());
                    "left" === r ? (o = this.options.gutter,
                    a = this.$activator.position().left + o) : "right" === r && (a = this.$activator.position().left + this.$activator.outerWidth() - this.$activates.outerWidth() + (o = -this.options.gutter)),
                    this.$activates.css({
                        position: "absolute",
                        top: this.$activator.position().top + l + c,
                        left: a
                    })
                }
            }, {
                key: "_getHorizontalAlignment",
                value: function() {
                    var t = this.$activator.offset().left;
                    return t + this.$activates.innerWidth() > e(window).width() ? "right" : t - this.$activates.innerWidth() + this.$activator.innerWidth() < 0 ? "left" : this.options.alignment
                }
            }, {
                key: "fallback",
                value: function() {
                    return {
                        _value: void 0,
                        or: function(e) {
                            return void 0 !== e && void 0 === this._value && (this._value = e),
                            this
                        },
                        value: function() {
                            return this._value
                        }
                    }
                }
            }]) && o(n.prototype, a),
            s && o(n, s),
            t
        }();
        e.fn.scrollTo = function(t) {
            return this.scrollTop(this.scrollTop() - this.offset().top + e(t).offset().top),
            this
        }
        ,
        e.fn.dropdown = function(e) {
            if (this.length > 1) {
                var n = [];
                return this.each((function() {
                    var i = new t(this,e);
                    i.init(),
                    n.push(i.returnPublicInterface())
                }
                )),
                n
            }
            var i = new t(this,e);
            return i.init(),
            i.returnPublicInterface()
        }
        ,
        e.dropdown = {
            initAnimations: function() {
                t.bindBootstrapEvents()
            }
        },
        t.mdbDropdownAutoInit()
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(6),
    n(12);
    function i(e, t) {
        for (var n = 0; n < t.length; n++) {
            var i = t[n];
            i.enumerable = i.enumerable || !1,
            i.configurable = !0,
            "value"in i && (i.writable = !0),
            Object.defineProperty(e, i.key, i)
        }
    }
    jQuery((function(e) {
        var t = function() {
            function t(e) {
                var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t),
                this.$searchWrappers = e,
                this.options = {
                    color: this.fallback().or(n.color).or("#000").value(),
                    backgroundColor: this.fallback().or(n.backgroundColor).or("").value(),
                    fontSize: this.fallback().or(n.fontSize).or(".9rem").value(),
                    fontWeight: this.fallback().or(n.fontWeight).or("400").value(),
                    borderRadius: this.fallback().or(n.borderRadius).or("").value(),
                    borderColor: this.fallback().or(n.borderColor).or("").value(),
                    margin: this.fallback().or(n.margin).or("").value()
                }
            }
            var n, r, o;
            return n = t,
            (r = [{
                key: "init",
                value: function() {
                    return this.bindSearchEvents(),
                    this.$searchWrappers.css({
                        color: this.options.color,
                        backgroundColor: this.options.backgroundColor,
                        fontSize: this.options.fontSize,
                        fontWeight: this.options.fontWeight,
                        borderRadius: this.options.borderRadius,
                        borderColor: this.options.borderColor,
                        margin: this.options.margin
                    })
                }
            }, {
                key: "bindSearchEvents",
                value: function() {
                    this.$searchWrappers.each((function() {
                        var t = e(this).find("input").first();
                        t.on("keyup", (function() {
                            t.closest("div[id]").find("a, li").each((function() {
                                var n = e(this);
                                n.html().toLowerCase().indexOf(t.val().toLowerCase()) > -1 ? n.css({
                                    display: ""
                                }) : n.css({
                                    display: "none"
                                })
                            }
                            ))
                        }
                        ))
                    }
                    ))
                }
            }, {
                key: "fallback",
                value: function() {
                    return {
                        _value: void 0,
                        or: function(e) {
                            return void 0 !== e && void 0 === this._value && (this._value = e),
                            this
                        },
                        value: function() {
                            return this._value
                        }
                    }
                }
            }]) && i(n.prototype, r),
            o && i(n, o),
            t
        }();
        e.fn.mdbDropSearch = function(e) {
            return new t(this,e).init()
        }
    }
    ))
}
, function(e, t, n) {
    "use strict";
    n(31),
    n(6),
    n(38),
    n(12),
    n(52),
    n(13),
    n(7),
    n(14),
    n(29),
    n(35),
    n(53),
    n(40);
    var i = n(105);
    function r(e, t) {
        for (var n = 0; n < t.length; n++) {
            var i = t[n];
            i.enumerable = i.enumerable || !1,
            i.configurable = !0,
            "value"in i && (i.writable = !0),
            Object.defineProperty(e, i.key, i)
        }
    }
    jQuery((function(e) {
        var t, n = function() {
            function t(e) {
                var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
                !function(e, t) {
                    if (!(e instanceof t))
                        throw new TypeError("Cannot call a class as a function")
                }(this, t),
                this.options = {
                    destroy: this.fallback().or(n.destroy).or(!1).value(),
                    validate: this.fallback().or(e.attr("data-validate")).or(n.validate).or(!1).value(),
                    selectId: this.fallback().or(e.attr("data-select-id")).or(n.selectId).or(null).value(),
                    defaultMaterialInput: this.fallback().or(e.attr("data-default-material-input")).or(n.defaultMaterialInput).or(!1).value(),
                    fasClasses: this.fallback().or(e.attr("data-fas-classes")).or(n.fasClasses).or("").value(),
                    farClasses: this.fallback().or(e.attr("data-far-classes")).or(n.farClasses).or("").value(),
                    fabClasses: this.fallback().or(e.attr("data-fab-classes")).or(n.fabClasses).or("").value(),
                    copyClassesOption: this.fallback().or(e.attr("data-copy-classes-option")).or(n.copyClassesOption).or(!1).value(),
                    labels: {
                        selectAll: this.fallback().or(e.attr("data-label-select-all")).or((n.labels || {}).selectAll).or("Select all").value(),
                        optionsSelected: this.fallback().or(e.attr("data-label-options-selected")).or((n.labels || {}).optionsSelected).or("options selected").value(),
                        validFeedback: this.fallback().or(e.attr("data-label-valid-feedback")).or((n.labels || {}).validFeedback).or("Ok").value(),
                        invalidFeedback: this.fallback().or(e.attr("data-label-invalid-feedback")).or((n.labels || {}).invalidFeedback).or("Incorrect value").value(),
                        noSearchResults: this.fallback().or(e.attr("data-label-no-search-results")).or((n.labels || {}).noSearchResults).or("No results").value()
                    },
                    keyboardActiveClass: this.fallback().or(e.attr("data-keyboard-active-class")).or(n.keyboardActiveClass).or("heavy-rain-gradient").value(),
                    placeholder: this.fallback().or(e.attr("data-placeholder")).or(n.placeholder).or(null).value(),
                    visibleOptions: this.fallback().or(e.attr("data-visible-options")).or(n.visibleOptions).or(5).value(),
                    maxSelectedOptions: this.fallback().or(e.attr("data-max-selected-options")).or(n.maxSelectedOptions).or(5).value(),
                    showResetButton: this.fallback().or(e.attr("data-show-reset-button")).or(n.showResetButton).or(!1).value()
                },
                this.uuid = e.attr("id") || this.options.selectId || this._randomUUID(),
                this.view = new i.a(e,{
                    options: this.options,
                    properties: {
                        id: this.uuid
                    }
                }),
                this.selectedOptionsIndexes = [],
                t.mutationObservers = []
            }
            var n, o, a;
            return n = t,
            a = [{
                key: "clearMutationObservers",
                value: function() {
                    t.mutationObservers.forEach((function(e) {
                        e.disconnect(),
                        e.customStatus = "stopped"
                    }
                    ))
                }
            }, {
                key: "mdbSelectAutoInit",
                value: function() {
                    e(".mdb-select.mdb-select-autoinit").materialSelect()
                }
            }],
            (o = [{
                key: "init",
                value: function() {
                    var e = this;
                    this.options.destroy ? this.view.destroy() : (this.isInitialized && this.view.destroy(),
                    this.view.render(),
                    this.view.selectPreselectedOptions((function(t) {
                        return e._toggleSelectedValue(t)
                    }
                    )),
                    this.bindEvents())
                }
            }, {
                key: "bindEvents",
                value: function() {
                    var e = this;
                    this.bindMutationObserverChange(),
                    this.view.isEditable && this.view.isSearchable && this.view.bindResetButtonClick((function() {
                        return e._resetSelection()
                    }
                    )),
                    this.view.bindAddNewOptionClick(),
                    this.view.bindMaterialSelectFocus(),
                    this.view.bindMaterialSelectClick(),
                    this.view.bindMaterialSelectBlur(),
                    this.view.bindMaterialOptionsListTouchstart(),
                    this.view.bindMaterialSelectKeydown(),
                    this.view.bindMaterialSelectDropdownToggle(),
                    this.view.bindToggleAllClick((function(t) {
                        return e._toggleSelectedValue(t)
                    }
                    )),
                    this.view.bindMaterialOptionMousedown(),
                    this.view.bindMaterialOptionClick((function(t) {
                        return e._toggleSelectedValue(t)
                    }
                    )),
                    !this.view.isMultiple && this.view.isSearchable && this.view.bindSingleMaterialOptionClick(),
                    this.view.isSearchable && this.view.bindSearchInputKeyup(),
                    this.view.bindHtmlClick(),
                    this.view.bindMobileDevicesMousedown(),
                    this.view.bindSaveBtnClick()
                }
            }, {
                key: "bindMutationObserverChange",
                value: function() {
                    var e = new MutationObserver(this._onMutationObserverChange.bind(this));
                    e.observe(this.view.$nativeSelect.get(0), {
                        attributes: !0,
                        childList: !0,
                        characterData: !0,
                        subtree: !0
                    }),
                    e.customId = this.uuid,
                    e.customStatus = "observing",
                    t.clearMutationObservers(),
                    t.mutationObservers.push(e)
                }
            }, {
                key: "_onMutationObserverChange",
                value: function(t) {
                    t.forEach((function(t) {
                        var n = e(t.target).closest("select");
                        !0 !== n.data("stop-refresh") && ("childList" === t.type || "attributes" === t.type && e(t.target).is("option")) && (n.materialSelect({
                            destroy: !0
                        }),
                        n.materialSelect())
                    }
                    ))
                }
            }, {
                key: "_resetSelection",
                value: function() {
                    this.selectedOptionsIndexes = [],
                    this.view.$nativeSelect.find("option").prop("selected", !1)
                }
            }, {
                key: "_toggleSelectedValue",
                value: function(e) {
                    var t = this.selectedOptionsIndexes.indexOf(e)
                      , n = -1 !== t;
                    return n ? this.selectedOptionsIndexes.splice(t, 1) : this.selectedOptionsIndexes.push(e),
                    this.view.$nativeSelect.find("option").eq(e).prop("selected", !n),
                    this._setValueToMaterialSelect(),
                    !n
                }
            }, {
                key: "_setValueToMaterialSelect",
                value: function() {
                    var e = this
                      , t = ""
                      , n = this.selectedOptionsIndexes.length;
                    this.selectedOptionsIndexes.forEach((function(n) {
                        return t += ", ".concat(e.view.$nativeSelect.find("option").eq(n).text().replace(/  +/g, " ").trim())
                    }
                    )),
                    0 === (t = this.options.maxSelectedOptions >= 0 && n > this.options.maxSelectedOptions ? "".concat(n, " ").concat(this.options.labels.optionsSelected) : t.substring(2)).length && (t = this.view.$nativeSelect.find("option:disabled").eq(0).text()),
                    this.view.$nativeSelect.siblings("".concat(this.options.defaultMaterialInput ? "input.multi-bs-select" : "input.select-dropdown")).val(t)
                }
            }, {
                key: "_randomUUID",
                value: function() {
                    var e = (new Date).getTime();
                    return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, (function(t) {
                        var n = (e + 16 * Math.random()) % 16 | 0;
                        return e = Math.floor(e / 16),
                        ("x" === t ? n : 3 & n | 8).toString(16)
                    }
                    ))
                }
            }, {
                key: "fallback",
                value: function() {
                    return {
                        _value: void 0,
                        or: function(e) {
                            return void 0 !== e && void 0 === this._value && (this._value = e),
                            this
                        },
                        value: function() {
                            return this._value
                        }
                    }
                }
            }, {
                key: "isInitialized",
                get: function() {
                    return Boolean(this.view.$nativeSelect.data("select-id")) && this.view.$nativeSelect.hasClass("initialized")
                }
            }]) && r(n.prototype, o),
            a && r(n, a),
            t
        }();
        e.fn.materialSelect = function(t) {
            e(this).not(".browser-default").not(".custom-select").each((function() {
                new n(e(this),t).init()
            }
            ))
        }
        ,
        t = e.fn.val,
        e.fn.val = function(e) {
            if (!arguments.length)
                return t.call(this);
            if (!0 !== this.data("stop-refresh") && this.hasClass("mdb-select") && this.hasClass("initialized")) {
                n.clearMutationObservers(),
                this.materialSelect({
                    destroy: !0
                });
                var i = t.call(this, e);
                return this.materialSelect(),
                i
            }
            return t.call(this, e)
        }
        ,
        n.mdbSelectAutoInit()
    }
    ))
}
, function(e, t, n) {
    "use strict";
    (function(e) {
        var t;
        n(10),
        n(16),
        n(17),
        n(38),
        n(8),
        n(32),
        n(28),
        n(13),
        n(130),
        n(157),
        n(7),
        n(29),
        n(18),
        n(40),
        n(19);
        function i(e) {
            return (i = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
                return typeof e
            }
            : function(e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
            }
            )(e)
        }
        /*!
 * clipboard.js v2.0.0
 * https://zenorocha.github.io/clipboard.js
 * 
 * Licensed MIT © Zeno Rocha
 */
        t = function() {
            return function(e) {
                function t(i) {
                    if (n[i])
                        return n[i].exports;
                    var r = n[i] = {
                        i: i,
                        l: !1,
                        exports: {}
                    };
                    return e[i].call(r.exports, r, r.exports, t),
                    r.l = !0,
                    r.exports
                }
                var n = {};
                return t.m = e,
                t.c = n,
                t.i = function(e) {
                    return e
                }
                ,
                t.d = function(e, n, i) {
                    t.o(e, n) || Object.defineProperty(e, n, {
                        configurable: !1,
                        enumerable: !0,
                        get: i
                    })
                }
                ,
                t.n = function(e) {
                    var n = e && e.__esModule ? function() {
                        return e.default
                    }
                    : function() {
                        return e
                    }
                    ;
                    return t.d(n, "a", n),
                    n
                }
                ,
                t.o = function(e, t) {
                    return Object.prototype.hasOwnProperty.call(e, t)
                }
                ,
                t.p = "",
                t(t.s = 3)
            }([function(e, t, n) {
                var r, o, a;
                o = [e, n(7)],
                r = function(e, t) {
                    var n = function(e) {
                        return e && e.__esModule ? e : {
                            default: e
                        }
                    }(t)
                      , r = "function" == typeof Symbol && "symbol" == i(Symbol.iterator) ? function(e) {
                        return i(e)
                    }
                    : function(e) {
                        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : i(e)
                    }
                      , o = function() {
                        function e(e, t) {
                            for (var n = 0; n < t.length; n++) {
                                var i = t[n];
                                i.enumerable = i.enumerable || !1,
                                i.configurable = !0,
                                "value"in i && (i.writable = !0),
                                Object.defineProperty(e, i.key, i)
                            }
                        }
                        return function(t, n, i) {
                            return n && e(t.prototype, n),
                            i && e(t, i),
                            t
                        }
                    }()
                      , a = function() {
                        function e(t) {
                            (function(e, t) {
                                if (!(e instanceof t))
                                    throw new TypeError("Cannot call a class as a function")
                            }
                            )(this, e),
                            this.resolveOptions(t),
                            this.initSelection()
                        }
                        return o(e, [{
                            key: "resolveOptions",
                            value: function() {
                                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                                this.action = e.action,
                                this.container = e.container,
                                this.emitter = e.emitter,
                                this.target = e.target,
                                this.text = e.text,
                                this.trigger = e.trigger,
                                this.selectedText = ""
                            }
                        }, {
                            key: "initSelection",
                            value: function() {
                                this.text ? this.selectFake() : this.target && this.selectTarget()
                            }
                        }, {
                            key: "selectFake",
                            value: function() {
                                var e = this
                                  , t = "rtl" == document.documentElement.getAttribute("dir");
                                this.removeFake(),
                                this.fakeHandlerCallback = function() {
                                    return e.removeFake()
                                }
                                ,
                                this.fakeHandler = this.container.addEventListener("click", this.fakeHandlerCallback) || !0,
                                this.fakeElem = document.createElement("textarea"),
                                this.fakeElem.style.fontSize = "12pt",
                                this.fakeElem.style.border = "0",
                                this.fakeElem.style.padding = "0",
                                this.fakeElem.style.margin = "0",
                                this.fakeElem.style.position = "absolute",
                                this.fakeElem.style[t ? "right" : "left"] = "-9999px";
                                var i = window.pageYOffset || document.documentElement.scrollTop;
                                this.fakeElem.style.top = i + "px",
                                this.fakeElem.setAttribute("readonly", ""),
                                this.fakeElem.value = this.text,
                                this.container.appendChild(this.fakeElem),
                                this.selectedText = (0,
                                n.default)(this.fakeElem),
                                this.copyText()
                            }
                        }, {
                            key: "removeFake",
                            value: function() {
                                this.fakeHandler && (this.container.removeEventListener("click", this.fakeHandlerCallback),
                                this.fakeHandler = null,
                                this.fakeHandlerCallback = null),
                                this.fakeElem && (this.container.removeChild(this.fakeElem),
                                this.fakeElem = null)
                            }
                        }, {
                            key: "selectTarget",
                            value: function() {
                                this.selectedText = (0,
                                n.default)(this.target),
                                this.copyText()
                            }
                        }, {
                            key: "copyText",
                            value: function() {
                                var e = void 0;
                                try {
                                    e = document.execCommand(this.action)
                                } catch (t) {
                                    e = !1
                                }
                                this.handleResult(e)
                            }
                        }, {
                            key: "handleResult",
                            value: function(e) {
                                this.emitter.emit(e ? "success" : "error", {
                                    action: this.action,
                                    text: this.selectedText,
                                    trigger: this.trigger,
                                    clearSelection: this.clearSelection.bind(this)
                                })
                            }
                        }, {
                            key: "clearSelection",
                            value: function() {
                                this.trigger && this.trigger.focus(),
                                window.getSelection().removeAllRanges()
                            }
                        }, {
                            key: "destroy",
                            value: function() {
                                this.removeFake()
                            }
                        }, {
                            key: "action",
                            set: function() {
                                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "copy";
                                if (this._action = e,
                                "copy" !== this._action && "cut" !== this._action)
                                    throw new Error('Invalid "action" value, use either "copy" or "cut"')
                            },
                            get: function() {
                                return this._action
                            }
                        }, {
                            key: "target",
                            set: function(e) {
                                if (void 0 !== e) {
                                    if (!e || "object" !== (void 0 === e ? "undefined" : r(e)) || 1 !== e.nodeType)
                                        throw new Error('Invalid "target" value, use a valid Element');
                                    if ("copy" === this.action && e.hasAttribute("disabled"))
                                        throw new Error('Invalid "target" attribute. Please use "readonly" instead of "disabled" attribute');
                                    if ("cut" === this.action && (e.hasAttribute("readonly") || e.hasAttribute("disabled")))
                                        throw new Error('Invalid "target" attribute. You can\'t cut text from elements with "readonly" or "disabled" attributes');
                                    this._target = e
                                }
                            },
                            get: function() {
                                return this._target
                            }
                        }]),
                        e
                    }();
                    e.exports = a
                }
                ,
                void 0 !== (a = "function" == typeof r ? r.apply(t, o) : r) && (e.exports = a)
            }
            , function(e, t, n) {
                var i = n(6)
                  , r = n(5);
                e.exports = function(e, t, n) {
                    if (!e && !t && !n)
                        throw new Error("Missing required arguments");
                    if (!i.string(t))
                        throw new TypeError("Second argument must be a String");
                    if (!i.fn(n))
                        throw new TypeError("Third argument must be a Function");
                    if (i.node(e))
                        return function(e, t, n) {
                            return e.addEventListener(t, n),
                            {
                                destroy: function() {
                                    e.removeEventListener(t, n)
                                }
                            }
                        }(e, t, n);
                    if (i.nodeList(e))
                        return function(e, t, n) {
                            return Array.prototype.forEach.call(e, (function(e) {
                                e.addEventListener(t, n)
                            }
                            )),
                            {
                                destroy: function() {
                                    Array.prototype.forEach.call(e, (function(e) {
                                        e.removeEventListener(t, n)
                                    }
                                    ))
                                }
                            }
                        }(e, t, n);
                    if (i.string(e))
                        return function(e, t, n) {
                            return r(document.body, e, t, n)
                        }(e, t, n);
                    throw new TypeError("First argument must be a String, HTMLElement, HTMLCollection, or NodeList")
                }
            }
            , function(e, t) {
                function n() {}
                n.prototype = {
                    on: function(e, t, n) {
                        var i = this.e || (this.e = {});
                        return (i[e] || (i[e] = [])).push({
                            fn: t,
                            ctx: n
                        }),
                        this
                    },
                    once: function(e, t, n) {
                        function i() {
                            r.off(e, i),
                            t.apply(n, arguments)
                        }
                        var r = this;
                        return i._ = t,
                        this.on(e, i, n)
                    },
                    emit: function(e) {
                        for (var t = [].slice.call(arguments, 1), n = ((this.e || (this.e = {}))[e] || []).slice(), i = 0, r = n.length; i < r; i++)
                            n[i].fn.apply(n[i].ctx, t);
                        return this
                    },
                    off: function(e, t) {
                        var n = this.e || (this.e = {})
                          , i = n[e]
                          , r = [];
                        if (i && t)
                            for (var o = 0, a = i.length; o < a; o++)
                                i[o].fn !== t && i[o].fn._ !== t && r.push(i[o]);
                        return r.length ? n[e] = r : delete n[e],
                        this
                    }
                },
                e.exports = n
            }
            , function(e, t, n) {
                var r, o, a;
                o = [e, n(0), n(2), n(1)],
                void 0 !== (a = "function" == typeof (r = function(e, t, n, r) {
                    function o(e) {
                        return e && e.__esModule ? e : {
                            default: e
                        }
                    }
                    function a(e, t) {
                        var n = "data-clipboard-" + e;
                        if (t.hasAttribute(n))
                            return t.getAttribute(n)
                    }
                    var s = o(t)
                      , l = o(n)
                      , c = o(r)
                      , u = "function" == typeof Symbol && "symbol" == i(Symbol.iterator) ? function(e) {
                        return i(e)
                    }
                    : function(e) {
                        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : i(e)
                    }
                      , f = function() {
                        function e(e, t) {
                            for (var n = 0; n < t.length; n++) {
                                var i = t[n];
                                i.enumerable = i.enumerable || !1,
                                i.configurable = !0,
                                "value"in i && (i.writable = !0),
                                Object.defineProperty(e, i.key, i)
                            }
                        }
                        return function(t, n, i) {
                            return n && e(t.prototype, n),
                            i && e(t, i),
                            t
                        }
                    }()
                      , d = function(e) {
                        function t(e, n) {
                            !function(e, t) {
                                if (!(e instanceof t))
                                    throw new TypeError("Cannot call a class as a function")
                            }(this, t);
                            var r = function(e, t) {
                                if (!e)
                                    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                                return !t || "object" != i(t) && "function" != typeof t ? e : t
                            }(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this));
                            return r.resolveOptions(n),
                            r.listenClick(e),
                            r
                        }
                        return function(e, t) {
                            if ("function" != typeof t && null !== t)
                                throw new TypeError("Super expression must either be null or a function, not " + i(t));
                            e.prototype = Object.create(t && t.prototype, {
                                constructor: {
                                    value: e,
                                    enumerable: !1,
                                    writable: !0,
                                    configurable: !0
                                }
                            }),
                            t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
                        }(t, e),
                        f(t, [{
                            key: "resolveOptions",
                            value: function() {
                                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                                this.action = "function" == typeof e.action ? e.action : this.defaultAction,
                                this.target = "function" == typeof e.target ? e.target : this.defaultTarget,
                                this.text = "function" == typeof e.text ? e.text : this.defaultText,
                                this.container = "object" === u(e.container) ? e.container : document.body
                            }
                        }, {
                            key: "listenClick",
                            value: function(e) {
                                var t = this;
                                this.listener = (0,
                                c.default)(e, "click", (function(e) {
                                    return t.onClick(e)
                                }
                                ))
                            }
                        }, {
                            key: "onClick",
                            value: function(e) {
                                var t = e.delegateTarget || e.currentTarget;
                                this.clipboardAction && (this.clipboardAction = null),
                                this.clipboardAction = new s.default({
                                    action: this.action(t),
                                    target: this.target(t),
                                    text: this.text(t),
                                    container: this.container,
                                    trigger: t,
                                    emitter: this
                                })
                            }
                        }, {
                            key: "defaultAction",
                            value: function(e) {
                                return a("action", e)
                            }
                        }, {
                            key: "defaultTarget",
                            value: function(e) {
                                var t = a("target", e);
                                if (t)
                                    return document.querySelector(t)
                            }
                        }, {
                            key: "defaultText",
                            value: function(e) {
                                return a("text", e)
                            }
                        }, {
                            key: "destroy",
                            value: function() {
                                this.listener.destroy(),
                                this.clipboardAction && (this.clipboardAction.destroy(),
                                this.clipboardAction = null)
                            }
                        }], [{
                            key: "isSupported",
                            value: function() {
                                var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : ["copy", "cut"]
                                  , t = "string" == typeof e ? [e] : e
                                  , n = !!document.queryCommandSupported;
                                return t.forEach((function(e) {
                                    n = n && !!document.queryCommandSupported(e)
                                }
                                )),
                                n
                            }
                        }]),
                        t
                    }(l.default);
                    e.exports = d
                }
                ) ? r.apply(t, o) : r) && (e.exports = a)
            }
            , function(e, t) {
                var n = 9;
                if ("undefined" != typeof Element && !Element.prototype.matches) {
                    var i = Element.prototype;
                    i.matches = i.matchesSelector || i.mozMatchesSelector || i.msMatchesSelector || i.oMatchesSelector || i.webkitMatchesSelector
                }
                e.exports = function(e, t) {
                    for (; e && e.nodeType !== n; ) {
                        if ("function" == typeof e.matches && e.matches(t))
                            return e;
                        e = e.parentNode
                    }
                }
            }
            , function(e, t, n) {
                function i(e, t, n, i, o) {
                    var a = r.apply(this, arguments);
                    return e.addEventListener(n, a, o),
                    {
                        destroy: function() {
                            e.removeEventListener(n, a, o)
                        }
                    }
                }
                function r(e, t, n, i) {
                    return function(n) {
                        n.delegateTarget = o(n.target, t),
                        n.delegateTarget && i.call(e, n)
                    }
                }
                var o = n(4);
                e.exports = function(e, t, n, r, o) {
                    return "function" == typeof e.addEventListener ? i.apply(null, arguments) : "function" == typeof n ? i.bind(null, document).apply(null, arguments) : ("string" == typeof e && (e = document.querySelectorAll(e)),
                    Array.prototype.map.call(e, (function(e) {
                        return i(e, t, n, r, o)
                    }
                    )))
                }
            }
            , function(e, t) {
                t.node = function(e) {
                    return void 0 !== e && e instanceof HTMLElement && 1 === e.nodeType
                }
                ,
                t.nodeList = function(e) {
                    var n = Object.prototype.toString.call(e);
                    return void 0 !== e && ("[object NodeList]" === n || "[object HTMLCollection]" === n) && "length"in e && (0 === e.length || t.node(e[0]))
                }
                ,
                t.string = function(e) {
                    return "string" == typeof e || e instanceof String
                }
                ,
                t.fn = function(e) {
                    return "[object Function]" === Object.prototype.toString.call(e)
                }
            }
            , function(e, t) {
                e.exports = function(e) {
                    var t;
                    if ("SELECT" === e.nodeName)
                        e.focus(),
                        t = e.value;
                    else if ("INPUT" === e.nodeName || "TEXTAREA" === e.nodeName) {
                        var n = e.hasAttribute("readonly");
                        n || e.setAttribute("readonly", ""),
                        e.select(),
                        e.setSelectionRange(0, e.value.length),
                        n || e.removeAttribute("readonly"),
                        t = e.value
                    } else {
                        e.hasAttribute("contenteditable") && e.focus();
                        var i = window.getSelection()
                          , r = document.createRange();
                        r.selectNodeContents(e),
                        i.removeAllRanges(),
                        i.addRange(r),
                        t = i.toString()
                    }
                    return t
                }
            }
            ])
        }
        ,
        "object" == ("undefined" == typeof exports ? "undefined" : i(exports)) && "object" == i(e) ? e.exports = t() : "function" == typeof define && n(24) ? define([], t) : "object" == ("undefined" == typeof exports ? "undefined" : i(exports)) ? exports.ClipboardJS = t() : window.ClipboardJS = t()
    }
    ).call(this, n(27)(e))
}]);