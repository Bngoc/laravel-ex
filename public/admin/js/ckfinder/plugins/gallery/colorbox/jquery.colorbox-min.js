﻿/*!
 Colorbox v1.4.27 - 2013-07-16
 jQuery lightbox and modal window plugin
 (c) 2013 Jack Moore - http://www.jacklmoore.com/colorbox
 license: http://www.opensource.org/licenses/mit-license.php
 */
(function (M, l, aa) {
    var N = {
        transition: "elastic",
        speed: 300,
        fadeOut: 300,
        width: false,
        initialWidth: "600",
        innerWidth: false,
        maxWidth: false,
        minWidth: false,
        height: false,
        initialHeight: "450",
        innerHeight: false,
        maxHeight: false,
        minHeight: false,
        scalePhotos: true,
        scrolling: true,
        inline: false,
        html: false,
        iframe: false,
        fastIframe: true,
        photo: false,
        href: false,
        title: false,
        rel: false,
        opacity: 0.9,
        preloading: true,
        className: false,
        retinaImage: false,
        retinaUrl: false,
        retinaSuffix: "@2x.$1",
        current: "image {current} of {total}",
        previous: "previous",
        next: "next",
        close: "close",
        xhrError: "This content failed to load.",
        imgError: "This image failed to load.",
        open: false,
        returnFocus: true,
        trapFocus: true,
        reposition: true,
        loop: true,
        slideshow: false,
        slideshowAuto: true,
        slideshowSpeed: 2500,
        slideshowStart: "start slideshow",
        slideshowStop: "stop slideshow",
        photoRegex: /\.(gif|png|jp(e|g|eg)|bmp|ico|webp)((#|\?).*)?$/i,
        onOpen: false,
        onLoad: false,
        onComplete: false,
        onCleanup: false,
        onClosed: false,
        overlayClose: true,
        escKey: true,
        arrowKey: true,
        top: false,
        bottom: false,
        left: false,
        right: false,
        fixed: false,
        data: undefined,
        closeButton: true
    }, x = "colorbox", V = "cbox", r = V + "Element", Z = V + "_open", e = V + "_load", X = V + "_complete", v = V + "_cleanup", ag = V + "_closed", i = V + "_purge", T, al, am, d, K, p, b, S, c, ae, Q, k, h, o, u, ab, t, U, z, B, I = M("<a/>"), aj, an, m, g, a, w, L, n, D, ac, P, A, O, ai = "div", ah, G = 0, ad = {}, af;

    function J(ao, ar, aq) {
        var ap = l.createElement(ao);
        if (ar) {
            ap.id = V + ar
        }
        if (aq) {
            ap.style.cssText = aq
        }
        return M(ap)
    }

    function s() {
        return aa.innerHeight ? aa.innerHeight : M(aa).height()
    }

    function F(ap) {
        var ao = c.length, aq = (L + ap) % ao;
        return (aq < 0) ? ao + aq : aq
    }

    function R(ao, ap) {
        return Math.round((/%/.test(ao) ? ((ap === "x" ? ae.width() : s()) / 100) : 1) * parseInt(ao, 10))
    }

    function C(ap, ao) {
        return ap.photo || ap.photoRegex.test(ao)
    }

    function E(ap, ao) {
        return ap.retinaUrl && aa.devicePixelRatio > 1 ? ao.replace(ap.photoRegex, ap.retinaSuffix) : ao
    }

    function ak(ao) {
        if ("contains" in al[0] && !al[0].contains(ao.target)) {
            ao.stopPropagation();
            al.focus()
        }
    }

    function W() {
        var ao, ap = M.data(w, x);
        if (ap == null) {
            aj = M.extend({}, N);
            if (console && console.log) {
                console.log("Error: cboxElement missing settings object")
            }
        } else {
            aj = M.extend({}, ap)
        }
        for (ao in aj) {
            if (M.isFunction(aj[ao]) && ao.slice(0, 2) !== "on") {
                aj[ao] = aj[ao].call(w)
            }
        }
        aj.rel = aj.rel || w.rel || M(w).data("rel") || "nofollow";
        aj.href = aj.href || M(w).attr("href");
        aj.title = aj.title || w.title;
        if (typeof aj.href === "string") {
            aj.href = M.trim(aj.href)
        }
    }

    function H(ao, ap) {
        M(l).trigger(ao);
        I.trigger(ao);
        if (M.isFunction(ap)) {
            ap.call(w)
        }
    }

    function y() {
        var ap, ar = V + "Slideshow_", at = "click." + V, ao, av, au, aq;
        if (aj.slideshow && c[1]) {
            ao = function () {
                clearTimeout(ap)
            };
            av = function () {
                if (aj.loop || c[L + 1]) {
                    ap = setTimeout(O.next, aj.slideshowSpeed)
                }
            };
            au = function () {
                ab.html(aj.slideshowStop).unbind(at).one(at, aq);
                I.bind(X, av).bind(e, ao).bind(v, aq);
                al.removeClass(ar + "off").addClass(ar + "on")
            };
            aq = function () {
                ao();
                I.unbind(X, av).unbind(e, ao).unbind(v, aq);
                ab.html(aj.slideshowStart).unbind(at).one(at, function () {
                    O.next();
                    au()
                });
                al.removeClass(ar + "on").addClass(ar + "off")
            };
            if (aj.slideshowAuto) {
                au()
            } else {
                aq()
            }
        } else {
            al.removeClass(ar + "off " + ar + "on")
        }
    }

    function f(ao) {
        if (!P) {
            w = ao;
            W();
            c = M(w);
            L = 0;
            if (aj.rel !== "nofollow") {
                c = M("." + r).filter(function () {
                    var aq = M.data(this, x), ap;
                    if (aq) {
                        ap = M(this).data("rel") || aq.rel || this.rel
                    }
                    return (ap === aj.rel)
                });
                L = c.index(w);
                if (L === -1) {
                    c = c.add(w);
                    L = c.length - 1
                }
            }
            T.css({
                opacity: parseFloat(aj.opacity),
                cursor: aj.overlayClose ? "pointer" : "auto",
                visibility: "visible"
            }).show();
            if (ah) {
                al.add(T).removeClass(ah)
            }
            if (aj.className) {
                al.add(T).addClass(aj.className)
            }
            ah = aj.className;
            if (aj.closeButton) {
                z.html(aj.close).appendTo(d)
            } else {
                z.appendTo("<div/>")
            }
            if (!D) {
                D = ac = true;
                al.css({visibility: "hidden", display: "block"});
                Q = J(ai, "LoadedContent", "width:0; height:0; overflow:hidden");
                d.css({width: "", height: ""}).append(Q);
                an = K.height() + S.height() + d.outerHeight(true) - d.height();
                m = p.width() + b.width() + d.outerWidth(true) - d.width();
                g = Q.outerHeight(true);
                a = Q.outerWidth(true);
                aj.w = R(aj.initialWidth, "x");
                aj.h = R(aj.initialHeight, "y");
                O.position();
                y();
                H(Z, aj.onOpen);
                B.add(o).hide();
                al.focus();
                if (aj.trapFocus) {
                    if (l.addEventListener) {
                        l.addEventListener("focus", ak, true);
                        I.one(ag, function () {
                            l.removeEventListener("focus", ak, true)
                        })
                    }
                }
                if (aj.returnFocus) {
                    I.one(ag, function () {
                        M(w).focus()
                    })
                }
            }
            Y()
        }
    }

    function q() {
        if (!al && l.body) {
            af = false;
            ae = M(aa);
            al = J(ai).attr({
                id: x,
                "class": M.support.opacity === false ? V + "IE" : "",
                role: "dialog",
                tabindex: "-1"
            }).hide();
            T = J(ai, "Overlay").hide();
            h = M([J(ai, "LoadingOverlay")[0], J(ai, "LoadingGraphic")[0]]);
            am = J(ai, "Wrapper");
            d = J(ai, "Content").append(o = J(ai, "Title"), u = J(ai, "Current"), U = M('<button type="button"/>').attr({id: V + "Previous"}), t = M('<button type="button"/>').attr({id: V + "Next"}), ab = J("button", "Slideshow"), h);
            z = M('<button type="button"/>').attr({id: V + "Close"});
            am.append(J(ai).append(J(ai, "TopLeft"), K = J(ai, "TopCenter"), J(ai, "TopRight")), J(ai, false, "clear:left").append(p = J(ai, "MiddleLeft"), d, b = J(ai, "MiddleRight")), J(ai, false, "clear:left").append(J(ai, "BottomLeft"), S = J(ai, "BottomCenter"), J(ai, "BottomRight"))).find("div div").css({"float": "left"});
            k = J(ai, false, "position:absolute; width:9999px; visibility:hidden; display:none");
            B = t.add(U).add(u).add(ab);
            M(l.body).append(T, al.append(am, k))
        }
    }

    function j() {
        function ao(ap) {
            if (!(ap.which > 1 || ap.shiftKey || ap.altKey || ap.metaKey || ap.ctrlKey)) {
                ap.preventDefault();
                f(this)
            }
        }

        if (al) {
            if (!af) {
                af = true;
                t.click(function () {
                    O.next()
                });
                U.click(function () {
                    O.prev()
                });
                z.click(function () {
                    O.close()
                });
                T.click(function () {
                    if (aj.overlayClose) {
                        O.close()
                    }
                });
                M(l).bind("keydown." + V, function (aq) {
                    var ap = aq.keyCode;
                    if (D && aj.escKey && ap === 27) {
                        aq.preventDefault();
                        O.close()
                    }
                    if (D && aj.arrowKey && c[1] && !aq.altKey) {
                        if (ap === 37) {
                            aq.preventDefault();
                            U.click()
                        } else {
                            if (ap === 39) {
                                aq.preventDefault();
                                t.click()
                            }
                        }
                    }
                });
                if (M.isFunction(M.fn.on)) {
                    M(l).on("click." + V, "." + r, ao)
                } else {
                    M("." + r).live("click." + V, ao)
                }
            }
            return true
        }
        return false
    }

    if (M.colorbox) {
        return
    }
    M(q);
    O = M.fn[x] = M[x] = function (ao, aq) {
        var ap = this;
        ao = ao || {};
        q();
        if (j()) {
            if (M.isFunction(ap)) {
                ap = M("<a/>");
                ao.open = true
            } else {
                if (!ap[0]) {
                    return ap
                }
            }
            if (aq) {
                ao.onComplete = aq
            }
            ap.each(function () {
                M.data(this, x, M.extend({}, M.data(this, x) || N, ao))
            }).addClass(r);
            if ((M.isFunction(ao.open) && ao.open.call(ap)) || ao.open) {
                f(ap[0])
            }
        }
        return ap
    };
    O.position = function (aq, at) {
        var aw, ay = 0, ap = 0, au = al.offset(), ao, ar;
        ae.unbind("resize." + V);
        al.css({top: -90000, left: -90000});
        ao = ae.scrollTop();
        ar = ae.scrollLeft();
        if (aj.fixed) {
            au.top -= ao;
            au.left -= ar;
            al.css({position: "fixed"})
        } else {
            ay = ao;
            ap = ar;
            al.css({position: "absolute"})
        }
        if (aj.right !== false) {
            ap += Math.max(ae.width() - aj.w - a - m - R(aj.right, "x"), 0)
        } else {
            if (aj.left !== false) {
                ap += R(aj.left, "x")
            } else {
                ap += Math.round(Math.max(ae.width() - aj.w - a - m, 0) / 2)
            }
        }
        if (aj.bottom !== false) {
            ay += Math.max(s() - aj.h - g - an - R(aj.bottom, "y"), 0)
        } else {
            if (aj.top !== false) {
                ay += R(aj.top, "y")
            } else {
                ay += Math.round(Math.max(s() - aj.h - g - an, 0) / 2)
            }
        }
        al.css({top: au.top, left: au.left, visibility: "visible"});
        am[0].style.width = am[0].style.height = "9999px";
        function ax() {
            K[0].style.width = S[0].style.width = d[0].style.width = (parseInt(al[0].style.width, 10) - m) + "px";
            d[0].style.height = p[0].style.height = b[0].style.height = (parseInt(al[0].style.height, 10) - an) + "px"
        }

        aw = {width: aj.w + a + m, height: aj.h + g + an, top: ay, left: ap};
        if (aq) {
            var av = 0;
            M.each(aw, function (az) {
                if (aw[az] !== ad[az]) {
                    av = aq;
                    return
                }
            });
            aq = av
        }
        ad = aw;
        if (!aq) {
            al.css(aw)
        }
        al.dequeue().animate(aw, {
            duration: aq || 0, complete: function () {
                ax();
                ac = false;
                am[0].style.width = (aj.w + a + m) + "px";
                am[0].style.height = (aj.h + g + an) + "px";
                if (aj.reposition) {
                    setTimeout(function () {
                        ae.bind("resize." + V, O.position)
                    }, 1)
                }
                if (at) {
                    at()
                }
            }, step: ax
        })
    };
    O.resize = function (ap) {
        var ao;
        if (D) {
            ap = ap || {};
            if (ap.width) {
                aj.w = R(ap.width, "x") - a - m
            }
            if (ap.innerWidth) {
                aj.w = R(ap.innerWidth, "x")
            }
            Q.css({width: aj.w});
            if (ap.height) {
                aj.h = R(ap.height, "y") - g - an
            }
            if (ap.innerHeight) {
                aj.h = R(ap.innerHeight, "y")
            }
            if (!ap.innerHeight && !ap.height) {
                ao = Q.scrollTop();
                Q.css({height: "auto"});
                aj.h = Q.height()
            }
            Q.css({height: aj.h});
            if (ao) {
                Q.scrollTop(ao)
            }
            O.position(aj.transition === "none" ? 0 : aj.speed)
        }
    };
    O.prep = function (ap) {
        if (!D) {
            return
        }
        var at, aq = aj.transition === "none" ? 0 : aj.speed;
        Q.empty().remove();
        Q = J(ai, "LoadedContent").append(ap);
        function ao() {
            aj.w = aj.w || Q.width();
            aj.w = aj.minw && aj.minw > aj.w ? aj.minw : aj.w;
            aj.w = aj.mw && aj.mw < aj.w ? aj.mw : aj.w;
            return aj.w
        }

        function ar() {
            aj.h = aj.h || Q.height();
            aj.h = aj.minh && aj.minh > aj.h ? aj.minh : aj.h;
            aj.h = aj.mh && aj.mh < aj.h ? aj.mh : aj.h;
            return aj.h
        }

        Q.hide().appendTo(k.show()).css({
            width: ao(),
            overflow: aj.scrolling ? "auto" : "hidden"
        }).css({height: ar()}).prependTo(d);
        k.hide();
        M(n).css({"float": "none"});
        at = function () {
            var ay = c.length, aw, ax = "frameBorder", au = "allowTransparency", av;
            if (!D) {
                return
            }
            function az() {
                if (M.support.opacity === false) {
                    al[0].style.removeAttribute("filter")
                }
            }

            av = function () {
                clearTimeout(A);
                h.hide();
                H(X, aj.onComplete)
            };
            o.html(aj.title).add(Q).show();
            if (ay > 1) {
                if (typeof aj.current === "string") {
                    u.html(aj.current.replace("{current}", L + 1).replace("{total}", ay)).show()
                }
                t[(aj.loop || L < ay - 1) ? "show" : "hide"]().html(aj.next);
                U[(aj.loop || L) ? "show" : "hide"]().html(aj.previous);
                if (aj.slideshow) {
                    ab.show()
                }
                if (aj.preloading) {
                    M.each([F(-1), F(1)], function () {
                        var aD, aA, aB = c[this], aC = M.data(aB, x);
                        if (aC && aC.href) {
                            aD = aC.href;
                            if (M.isFunction(aD)) {
                                aD = aD.call(aB)
                            }
                        } else {
                            aD = M(aB).attr("href")
                        }
                        if (aD && C(aC, aD)) {
                            aD = E(aC, aD);
                            aA = l.createElement("img");
                            aA.src = aD
                        }
                    })
                }
            } else {
                B.hide()
            }
            if (aj.iframe) {
                aw = J("iframe")[0];
                if (ax in aw) {
                    aw[ax] = 0
                }
                if (au in aw) {
                    aw[au] = "true"
                }
                if (!aj.scrolling) {
                    aw.scrolling = "no"
                }
                M(aw).attr({
                    src: aj.href,
                    name: (new Date()).getTime(),
                    "class": V + "Iframe",
                    allowFullScreen: true,
                    webkitAllowFullScreen: true,
                    mozallowfullscreen: true
                }).one("load", av).appendTo(Q);
                I.one(i, function () {
                    aw.src = "//about:blank"
                });
                if (aj.fastIframe) {
                    M(aw).trigger("load")
                }
            } else {
                av()
            }
            if (aj.transition === "fade") {
                al.fadeTo(aq, 1, az)
            } else {
                az()
            }
        };
        if (aj.transition === "fade") {
            al.fadeTo(aq, 0, function () {
                O.position(0, at)
            })
        } else {
            O.position(aq, at)
        }
    };
    function Y() {
        var aq, ar, ap = O.prep, ao, at = ++G;
        ac = true;
        n = false;
        w = c[L];
        W();
        H(i);
        H(e, aj.onLoad);
        aj.h = aj.height ? R(aj.height, "y") - g - an : aj.innerHeight && R(aj.innerHeight, "y");
        aj.w = aj.width ? R(aj.width, "x") - a - m : aj.innerWidth && R(aj.innerWidth, "x");
        aj.mw = aj.w;
        aj.mh = aj.h;
        aj.minw = aj.w;
        aj.minh = aj.h;
        if (aj.maxWidth) {
            aj.mw = R(aj.maxWidth, "x") - a - m;
            aj.mw = aj.w && aj.w < aj.mw ? aj.w : aj.mw
        }
        if (aj.minWidth) {
            aj.minw = R(aj.minWidth, "x") - a - m;
            aj.minw = aj.w && aj.w > aj.minw ? aj.w : aj.minw
        }
        if (aj.maxHeight) {
            aj.mh = R(aj.maxHeight, "y") - g - an;
            aj.mh = aj.h && aj.h < aj.mh ? aj.h : aj.mh
        }
        if (aj.minHeight) {
            aj.minh = R(aj.minHeight, "y") - g - an;
            aj.minh = aj.h && aj.h > aj.minh ? aj.h : aj.minh
        }
        aq = aj.href;
        A = setTimeout(function () {
            h.show()
        }, 100);
        if (aj.inline) {
            ao = J(ai).hide().insertBefore(M(aq)[0]);
            I.one(i, function () {
                ao.replaceWith(Q.children())
            });
            ap(M(aq))
        } else {
            if (aj.iframe) {
                ap(" ")
            } else {
                if (aj.html) {
                    ap(aj.html)
                } else {
                    if (C(aj, aq)) {
                        aq = E(aj, aq);
                        n = l.createElement("img");
                        M(n).addClass(V + "Photo").bind("error", function () {
                            aj.title = false;
                            ap(J(ai, "Error").html(aj.imgError))
                        }).one("load", function () {
                            var au;
                            if (at !== G) {
                                return
                            }
                            n.alt = M(w).attr("alt") || M(w).attr("data-alt") || "";
                            if (aj.retinaImage && aa.devicePixelRatio > 1) {
                                n.height = n.height / aa.devicePixelRatio;
                                n.width = n.width / aa.devicePixelRatio
                            }
                            if (aj.scalePhotos) {
                                ar = function () {
                                    n.height -= n.height * au;
                                    n.width -= n.width * au
                                };
                                if (aj.mw && n.width > aj.mw) {
                                    au = (n.width - aj.mw) / n.width;
                                    ar()
                                }
                                if (aj.mh && n.height > aj.mh) {
                                    au = (n.height - aj.mh) / n.height;
                                    ar()
                                }
                            }
                            if (aj.h) {
                                n.style.marginTop = Math.max(aj.mh - n.height, 0) / 2 + "px"
                            }
                            if (c[1] && (aj.loop || c[L + 1])) {
                                n.style.cursor = "pointer";
                                n.onclick = function () {
                                    O.next()
                                }
                            }
                            n.style.width = n.width + "px";
                            n.style.height = n.height + "px";
                            setTimeout(function () {
                                ap(n)
                            }, 1)
                        });
                        setTimeout(function () {
                            n.src = aq
                        }, 1)
                    } else {
                        if (aq) {
                            k.load(aq, aj.data, function (av, au) {
                                if (at === G) {
                                    ap(au === "error" ? J(ai, "Error").html(aj.xhrError) : M(this).contents())
                                }
                            })
                        }
                    }
                }
            }
        }
    }

    O.next = function () {
        if (!ac && c[1] && (aj.loop || c[L + 1])) {
            L = F(1);
            f(c[L])
        }
    };
    O.prev = function () {
        if (!ac && c[1] && (aj.loop || L)) {
            L = F(-1);
            f(c[L])
        }
    };
    O.close = function () {
        if (D && !P) {
            P = true;
            D = false;
            H(v, aj.onCleanup);
            ae.unbind("." + V);
            T.fadeTo(aj.fadeOut || 0, 0);
            al.stop().fadeTo(aj.fadeOut || 0, 0, function () {
                al.add(T).css({"opacity": 1, cursor: "auto"}).hide();
                H(i);
                Q.empty().remove();
                setTimeout(function () {
                    P = false;
                    H(ag, aj.onClosed)
                }, 1)
            })
        }
    };
    O.remove = function () {
        if (!al) {
            return
        }
        al.stop();
        M.colorbox.close();
        al.stop().remove();
        T.remove();
        P = false;
        al = null;
        M("." + r).removeData(x).removeClass(r);
        M(l).unbind("click." + V)
    };
    O.element = function () {
        return M(w)
    };
    O.settings = N
}(jQuery, document, window));
