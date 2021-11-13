// (function (e, t, n) {
    // "use strict";
    // n(38),
    // n(40);
    jQuery((function(e) {
        var t = "ontouchstart"in document.documentElement, 
        n = function(e, t) {
            (t && !e.hasClass("active") || !t && e.hasClass("active")) && (e[t ? "addClass" : "removeClass"]("active"),
            document.querySelectorAll("ul .btn-floating").forEach((function(e) {
                return e.classList[t ? "add" : "remove"]("shown")
            }
            )))
        },
        i = e(".fixed-action-btn:not(.smooth-scroll) > .btn-floating");
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
    ));
// })(jQuery);