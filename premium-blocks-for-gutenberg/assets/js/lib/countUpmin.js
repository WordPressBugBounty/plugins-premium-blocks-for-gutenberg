/*!
 * jquery.counterup.js 1.1
 *
 * Copyright 2013, Benjamin Intal http://gambit.ph @bfintal
 * Released under the GPL v2 License
 *
 * Date: Nov 26, 2013
 * Update Date: Mar 21, 2017
 */ (function (a) {
    a.fn.counterUp = function (b) {
        var c = a.extend({ time: 400, delay: 10 }, b);
        return this.each(function () {
            var f = a(this);
            var d = c;
            var e = function () {
                if (typeof f.attr("counterup-text") === "undefined") {
                    f.attr("counterup-text", f.text());
                }
                if (f.attr("counterup-text") !== f.text()) {
                    return;
                }
                var p = [];
                var g = d.time / d.delay;
                var n = f.text();
                var q = /[0-9]+,[0-9]+/.test(n);
                n = n.replace(/,/g, "");
                var l = /^[0-9]+$/.test(n);
                var h = /^[0-9]+\.[0-9]+$/.test(n);
                var j = h ? (n.split(".")[1] || []).length : 0;
                for (var m = g; m >= 1; m--) {
                    var k = parseInt((n / g) * m);
                    if (h) {
                        k = parseFloat((n / g) * m).toFixed(j);
                    }
                    if (q) {
                        while (/(\d+)(\d{3})/.test(k.toString())) {
                            k = k
                                .toString()
                                .replace(/(\d+)(\d{3})/, "$1" + "," + "$2");
                        }
                    }
                    p.unshift(k);
                }
                f.data("counterup-nums", p);
                f.text("0");
                var o = function () {
                    f.text(f.data("counterup-nums").shift());
                    if (f.data("counterup-nums").length) {
                        setTimeout(f.data("counterup-func"), d.delay);
                    } else {
                        delete f.data("counterup-nums");
                        f.data("counterup-nums", null);
                        f.data("counterup-func", null);
                    }
                };
                f.data("counterup-func", o);
                setTimeout(f.data("counterup-func"), d.delay);
            };
            f.waypoint(e, { offset: "100%", triggerOnce: true });
        });
    };
})(jQuery);
