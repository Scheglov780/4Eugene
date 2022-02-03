/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Magic Toolbox <support@magictoolbox.com>
 *  @copyright Copyright (c) 2015 Magic Toolbox <support@magictoolbox.com>. All rights reserved
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
/*


 Magic Zoom Plus v5.1.3
 Copyright 2015 Magic Toolbox
 Buy a license: https://www.magictoolbox.com/magiczoomplus/
 License agreement: https://www.magictoolbox.com/license/


 */
window.MagicZoom = (function () {
    var w, y;
    w = y = (function () {
        var S = {
            version: "v3.3-b3-9-g7dd0194", UUID: 0, storage: {}, $uuid: function (W) {
                return (W.$J_UUID || (W.$J_UUID = ++M.UUID))
            }, getStorage: function (W) {
                return (M.storage[W] || (M.storage[W] = {}))
            }, $F: function () {
            }, $false: function () {
                return false
            }, $true: function () {
                return true
            }, stylesId: "mjs-" + Math.floor(Math.random() * new Date().getTime()), defined: function (W) {
                return (undefined != W)
            }, ifndef: function (X, W) {
                return (undefined != X) ? X : W
            }, exists: function (W) {
                return !!(W)
            }, jTypeOf: function (W) {
                if (!M.defined(W)) {
                    return false
                }
                if (W.$J_TYPE) {
                    return W.$J_TYPE
                }
                if (!!W.nodeType) {
                    if (1 == W.nodeType) {
                        return "element"
                    }
                    if (3 == W.nodeType) {
                        return "textnode"
                    }
                }
                if (W.length && W.item) {
                    return "collection"
                }
                if (W.length && W.callee) {
                    return "arguments"
                }
                if ((W instanceof window.Object || W instanceof window.Function) && W.constructor === M.Class) {
                    return "class"
                }
                if (W instanceof window.Array) {
                    return "array"
                }
                if (W instanceof window.Function) {
                    return "function"
                }
                if (W instanceof window.String) {
                    return "string"
                }
                if (M.jBrowser.trident) {
                    if (M.defined(W.cancelBubble)) {
                        return "event"
                    }
                } else {
                    if (W === window.event || W.constructor == window.Event || W.constructor == window.MouseEvent || W.constructor == window.UIEvent || W.constructor == window.KeyboardEvent || W.constructor == window.KeyEvent) {
                        return "event"
                    }
                }
                if (W instanceof window.Date) {
                    return "date"
                }
                if (W instanceof window.RegExp) {
                    return "regexp"
                }
                if (W === window) {
                    return "window"
                }
                if (W === document) {
                    return "document"
                }
                return typeof(W)
            }, extend: function (ab, aa) {
                if (!(ab instanceof window.Array)) {
                    ab = [ab]
                }
                if (!aa) {
                    return ab[0]
                }
                for (var Z = 0, X = ab.length; Z < X; Z++) {
                    if (!M.defined(ab)) {
                        continue
                    }
                    for (var Y in aa) {
                        if (!Object.prototype.hasOwnProperty.call(aa, Y)) {
                            continue
                        }
                        try {
                            ab[Z][Y] = aa[Y]
                        } catch (W) {
                        }
                    }
                }
                return ab[0]
            }, implement: function (aa, Z) {
                if (!(aa instanceof window.Array)) {
                    aa = [aa]
                }
                for (var Y = 0, W = aa.length; Y < W; Y++) {
                    if (!M.defined(aa[Y])) {
                        continue
                    }
                    if (!aa[Y].prototype) {
                        continue
                    }
                    for (var X in(Z || {})) {
                        if (!aa[Y].prototype[X]) {
                            aa[Y].prototype[X] = Z[X]
                        }
                    }
                }
                return aa[0]
            }, nativize: function (Y, X) {
                if (!M.defined(Y)) {
                    return Y
                }
                for (var W in(X || {})) {
                    if (!Y[W]) {
                        Y[W] = X[W]
                    }
                }
                return Y
            }, $try: function () {
                for (var X = 0, W = arguments.length; X < W; X++) {
                    try {
                        return arguments[X]()
                    } catch (Y) {
                    }
                }
                return null
            }, $A: function (Y) {
                if (!M.defined(Y)) {
                    return M.$([])
                }
                if (Y.toArray) {
                    return M.$(Y.toArray())
                }
                if (Y.item) {
                    var X = Y.length || 0, W = new Array(X);
                    while (X--) {
                        W[X] = Y[X]
                    }
                    return M.$(W)
                }
                return M.$(Array.prototype.slice.call(Y))
            }, now: function () {
                return new Date().getTime()
            }, detach: function (aa) {
                var Y;
                switch (M.jTypeOf(aa)) {
                    case"object":
                        Y = {};
                        for (var Z in aa) {
                            Y[Z] = M.detach(aa[Z])
                        }
                        break;
                    case"array":
                        Y = [];
                        for (var X = 0, W = aa.length; X < W; X++) {
                            Y[X] = M.detach(aa[X])
                        }
                        break;
                    default:
                        return aa
                }
                return M.$(Y)
            }, $: function (Y) {
                var W = true;
                if (!M.defined(Y)) {
                    return null
                }
                if (Y.$J_EXT) {
                    return Y
                }
                switch (M.jTypeOf(Y)) {
                    case"array":
                        Y = M.nativize(Y, M.extend(M.Array, {$J_EXT: M.$F}));
                        Y.jEach = Y.forEach;
                        return Y;
                        break;
                    case"string":
                        var X = document.getElementById(Y);
                        if (M.defined(X)) {
                            return M.$(X)
                        }
                        return null;
                        break;
                    case"window":
                    case"document":
                        M.$uuid(Y);
                        Y = M.extend(Y, M.Doc);
                        break;
                    case"element":
                        M.$uuid(Y);
                        Y = M.extend(Y, M.Element);
                        break;
                    case"event":
                        Y = M.extend(Y, M.Event);
                        break;
                    case"textnode":
                    case"function":
                    case"array":
                    case"date":
                    default:
                        W = false;
                        break
                }
                if (W) {
                    return M.extend(Y, {$J_EXT: M.$F})
                } else {
                    return Y
                }
            }, $new: function (W, Y, X) {
                return M.$(M.doc.createElement(W)).setProps(Y || {}).jSetCss(X || {})
            }, addCSS: function (X, Z, ad) {
                var aa, Y, ab, ac = [], W = -1;
                ad || (ad = M.stylesId);
                aa = M.$(ad) || M.$new("style", {
                        id: ad,
                        type: "text/css"
                    }).jAppendTo((document.head || document.body), "top");
                Y = aa.sheet || aa.styleSheet;
                if ("string" != M.jTypeOf(Z)) {
                    for (var ab in Z) {
                        ac.push(ab + ":" + Z[ab])
                    }
                    Z = ac.join(";")
                }
                if (Y.insertRule) {
                    W = Y.insertRule(X + " {" + Z + "}", Y.cssRules.length)
                } else {
                    W = Y.addRule(X, Z)
                }
                return W
            }, removeCSS: function (Z, W) {
                var Y, X;
                Y = M.$(Z);
                if ("element" !== M.jTypeOf(Y)) {
                    return
                }
                X = Y.sheet || Y.styleSheet;
                if (X.deleteRule) {
                    X.deleteRule(W)
                } else {
                    if (X.removeRule) {
                        X.removeRule(W)
                    }
                }
            }, generateUUID: function () {
                return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (Y) {
                    var X = Math.random() * 16 | 0, W = Y == "x" ? X : (X & 3 | 8);
                    return W.toString(16)
                }).toUpperCase()
            }, getAbsoluteURL: (function () {
                var W;
                return function (X) {
                    if (!W) {
                        W = document.createElement("a")
                    }
                    W.setAttribute("href", X);
                    return ("!!" + W.href).replace("!!", "")
                }
            })(), getHashCode: function (Y) {
                var Z = 0, W = Y.length;
                for (var X = 0; X < W; ++X) {
                    Z = 31 * Z + Y.charCodeAt(X);
                    Z %= 4294967296
                }
                return Z
            }
        };
        var M = S;
        var N = S.$;
        if (!window.magicJS) {
            window.magicJS = S;
            window.$mjs = S.$
        }
        M.Array = {
            $J_TYPE: "array", indexOf: function (Z, aa) {
                var W = this.length;
                for (var X = this.length, Y = (aa < 0) ? Math.max(0, X + aa) : aa || 0; Y < X; Y++) {
                    if (this[Y] === Z) {
                        return Y
                    }
                }
                return -1
            }, contains: function (W, X) {
                return this.indexOf(W, X) != -1
            }, forEach: function (W, Z) {
                for (var Y = 0, X = this.length; Y < X; Y++) {
                    if (Y in this) {
                        W.call(Z, this[Y], Y, this)
                    }
                }
            }, filter: function (W, ab) {
                var aa = [];
                for (var Z = 0, X = this.length; Z < X; Z++) {
                    if (Z in this) {
                        var Y = this[Z];
                        if (W.call(ab, this[Z], Z, this)) {
                            aa.push(Y)
                        }
                    }
                }
                return aa
            }, map: function (W, aa) {
                var Z = [];
                for (var Y = 0, X = this.length; Y < X; Y++) {
                    if (Y in this) {
                        Z[Y] = W.call(aa, this[Y], Y, this)
                    }
                }
                return Z
            }
        };
        M.implement(String, {
            $J_TYPE: "string", jTrim: function () {
                return this.replace(/^\s+|\s+$/g, "")
            }, eq: function (W, X) {
                return (X || false) ? (this.toString() === W.toString()) : (this.toLowerCase().toString() === W.toLowerCase().toString())
            }, jCamelize: function () {
                return this.replace(/-\D/g, function (W) {
                    return W.charAt(1).toUpperCase()
                })
            }, dashize: function () {
                return this.replace(/[A-Z]/g, function (W) {
                    return ("-" + W.charAt(0).toLowerCase())
                })
            }, jToInt: function (W) {
                return parseInt(this, W || 10)
            }, toFloat: function () {
                return parseFloat(this)
            }, jToBool: function () {
                return !this.replace(/true/i, "").jTrim()
            }, has: function (X, W) {
                W = W || "";
                return (W + this + W).indexOf(W + X + W) > -1
            }
        });
        S.implement(Function, {
            $J_TYPE: "function", jBind: function () {
                var X = M.$A(arguments), W = this, Y = X.shift();
                return function () {
                    return W.apply(Y || null, X.concat(M.$A(arguments)))
                }
            }, jBindAsEvent: function () {
                var X = M.$A(arguments), W = this, Y = X.shift();
                return function (Z) {
                    return W.apply(Y || null, M.$([Z || (M.jBrowser.ieMode ? window.event : null)]).concat(X))
                }
            }, jDelay: function () {
                var X = M.$A(arguments), W = this, Y = X.shift();
                return window.setTimeout(function () {
                    return W.apply(W, X)
                }, Y || 0)
            }, jDefer: function () {
                var X = M.$A(arguments), W = this;
                return function () {
                    return W.jDelay.apply(W, X)
                }
            }, interval: function () {
                var X = M.$A(arguments), W = this, Y = X.shift();
                return window.setInterval(function () {
                    return W.apply(W, X)
                }, Y || 0)
            }
        });
        var T = {}, L = navigator.userAgent.toLowerCase(), K = L.match(/(webkit|gecko|trident|presto)\/(\d+\.?\d*)/i), P = L.match(/(edge|opr)\/(\d+\.?\d*)/i) || L.match(/(crios|chrome|safari|firefox|opera|opr)\/(\d+\.?\d*)/i), R = L.match(/version\/(\d+\.?\d*)/i), G = document.documentElement.style;

        function H(X) {
            var W = X.charAt(0).toUpperCase() + X.slice(1);
            return X in G || ("Webkit" + W) in G || ("Moz" + W) in G || ("ms" + W) in G || ("O" + W) in G
        }

        M.jBrowser = {
            features: {
                xpath: !!(document.evaluate),
                air: !!(window.runtime),
                query: !!(document.querySelector),
                fullScreen: !!(document.fullscreenEnabled || document.msFullscreenEnabled || document.exitFullscreen || document.cancelFullScreen || document.webkitexitFullscreen || document.webkitCancelFullScreen || document.mozCancelFullScreen || document.oCancelFullScreen || document.msCancelFullScreen),
                xhr2: !!(window.ProgressEvent) && !!(window.FormData) && (window.XMLHttpRequest && "withCredentials" in new XMLHttpRequest),
                transition: H("transition"),
                transform: H("transform"),
                perspective: H("perspective"),
                animation: H("animation"),
                requestAnimationFrame: false,
                multibackground: false,
                cssFilters: false,
                svg: (function () {
                    return document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1")
                })()
            },
            touchScreen: function () {
                return "ontouchstart" in window || (window.DocumentTouch && document instanceof DocumentTouch)
            }(),
            mobile: L.match(/(android|bb\d+|meego).+|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(jBrowser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/) ? true : false,
            engine: (K && K[1]) ? K[1].toLowerCase() : (window.opera) ? "presto" : !!(window.ActiveXObject) ? "trident" : (undefined !== document.getBoxObjectFor || null != window.mozInnerScreenY) ? "gecko" : (null !== window.WebKitPoint || !navigator.taintEnabled) ? "webkit" : "unknown",
            version: (K && K[2]) ? parseFloat(K[2]) : 0,
            uaName: (P && P[1]) ? P[1].toLowerCase() : "",
            uaVersion: (P && P[2]) ? parseFloat(P[2]) : 0,
            cssPrefix: "",
            cssDomPrefix: "",
            domPrefix: "",
            ieMode: 0,
            platform: L.match(/ip(?:ad|od|hone)/) ? "ios" : (L.match(/(?:webos|android)/) || navigator.platform.match(/mac|win|linux/i) || ["other"])[0].toLowerCase(),
            backCompat: document.compatMode && "backcompat" == document.compatMode.toLowerCase(),
            scrollbarsWidth: 0,
            getDoc: function () {
                return (document.compatMode && "backcompat" == document.compatMode.toLowerCase()) ? document.body : document.documentElement
            },
            requestAnimationFrame: window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || undefined,
            cancelAnimationFrame: window.cancelAnimationFrame || window.mozCancelAnimationFrame || window.mozCancelAnimationFrame || window.oCancelAnimationFrame || window.msCancelAnimationFrame || window.webkitCancelRequestAnimationFrame || undefined,
            ready: false,
            onready: function () {
                if (M.jBrowser.ready) {
                    return
                }
                var Z, Y;
                M.jBrowser.ready = true;
                M.body = M.$(document.body);
                M.win = M.$(window);
                try {
                    var X = M.$new("div").jSetCss({
                        width: 100,
                        height: 100,
                        overflow: "scroll",
                        position: "absolute",
                        top: -9999
                    }).jAppendTo(document.body);
                    M.jBrowser.scrollbarsWidth = X.offsetWidth - X.clientWidth;
                    X.jRemove()
                } catch (W) {
                }
                try {
                    Z = M.$new("div");
                    Y = Z.style;
                    Y.cssText = "background:url(https://),url(https://),red url(https://)";
                    M.jBrowser.features.multibackground = (/(url\s*\(.*?){3}/).test(Y.background);
                    Y = null;
                    Z = null
                } catch (W) {
                }
                if (!M.jBrowser.cssTransformProp) {
                    M.jBrowser.cssTransformProp = M.normalizeCSS("transform").dashize()
                }
                try {
                    Z = M.$new("div");
                    Z.style.cssText = M.normalizeCSS("filter").dashize() + ":blur(2px);";
                    M.jBrowser.features.cssFilters = !!Z.style.length && (!M.jBrowser.ieMode || M.jBrowser.ieMode > 9);
                    Z = null
                } catch (W) {
                }
                if (!M.jBrowser.features.cssFilters) {
                    M.$(document.documentElement).jAddClass("no-cssfilters-magic")
                }
                if (undefined === window.TransitionEvent && undefined !== window.WebKitTransitionEvent) {
                    T.transitionend = "webkitTransitionEnd"
                }
                M.Doc.jCallEvent.call(M.$(document), "domready")
            }
        };
        (function () {
            var aa = [], Z, Y, X;

            function W() {
                return !!(arguments.callee.caller)
            }

            switch (M.jBrowser.engine) {
                case"trident":
                    if (!M.jBrowser.version) {
                        M.jBrowser.version = !!(window.XMLHttpRequest) ? 3 : 2
                    }
                    break;
                case"gecko":
                    M.jBrowser.version = (P && P[2]) ? parseFloat(P[2]) : 0;
                    break
            }
            M.jBrowser[M.jBrowser.engine] = true;
            if (P && "crios" === P[1]) {
                M.jBrowser.uaName = "chrome"
            }
            if (!!window.chrome) {
                M.jBrowser.chrome = true
            }
            if (P && "opr" === P[1]) {
                M.jBrowser.uaName = "opera";
                M.jBrowser.opera = true
            }
            if ("safari" === M.jBrowser.uaName && (R && R[1])) {
                M.jBrowser.uaVersion = parseFloat(R[1])
            }
            if ("android" == M.jBrowser.platform && M.jBrowser.webkit && (R && R[1])) {
                M.jBrowser.androidBrowser = true
            }
            Z = ({
                    gecko: ["-moz-", "Moz", "moz"],
                    webkit: ["-webkit-", "Webkit", "webkit"],
                    trident: ["-ms-", "ms", "ms"],
                    presto: ["-o-", "O", "o"]
                })[M.jBrowser.engine] || ["", "", ""];
            M.jBrowser.cssPrefix = Z[0];
            M.jBrowser.cssDomPrefix = Z[1];
            M.jBrowser.domPrefix = Z[2];
            M.jBrowser.ieMode = (!M.jBrowser.trident) ? undefined : (document.documentMode) ? document.documentMode : function () {
                        var ab = 0;
                        if (M.jBrowser.backCompat) {
                            return 5
                        }
                        switch (M.jBrowser.version) {
                            case 2:
                                ab = 6;
                                break;
                            case 3:
                                ab = 7;
                                break
                        }
                        return ab
                    }();
            aa.push(M.jBrowser.platform + "-magic");
            if (M.jBrowser.mobile) {
                aa.push("mobile-magic")
            }
            if (M.jBrowser.androidBrowser) {
                aa.push("android-jBrowser-magic")
            }
            if (M.jBrowser.ieMode) {
                M.jBrowser.uaName = "ie";
                M.jBrowser.uaVersion = M.jBrowser.ieMode;
                aa.push("ie" + M.jBrowser.ieMode + "-magic");
                for (Y = 11; Y > M.jBrowser.ieMode; Y--) {
                    aa.push("lt-ie" + Y + "-magic")
                }
            }
            if (M.jBrowser.webkit && M.jBrowser.version < 536) {
                M.jBrowser.features.fullScreen = false
            }
            if (M.jBrowser.requestAnimationFrame) {
                M.jBrowser.requestAnimationFrame.call(window, function () {
                    M.jBrowser.features.requestAnimationFrame = true
                })
            }
            if (M.jBrowser.features.svg) {
                aa.push("svg-magic")
            } else {
                aa.push("no-svg-magic")
            }
            X = (document.documentElement.className || "").match(/\S+/g) || [];
            document.documentElement.className = M.$(X).concat(aa).join(" ");
            if (M.jBrowser.ieMode && M.jBrowser.ieMode < 9) {
                document.createElement("figure");
                document.createElement("figcaption")
            }
        })();
        (function () {
            M.jBrowser.fullScreen = {
                capable: M.jBrowser.features.fullScreen,
                enabled: function () {
                    return !!(document.fullscreenElement || document[M.jBrowser.domPrefix + "FullscreenElement"] || document.fullScreen || document.webkitIsFullScreen || document[M.jBrowser.domPrefix + "FullScreen"])
                },
                request: function (W, X) {
                    X || (X = {});
                    if (this.capable) {
                        M.$(document).jAddEvent(this.changeEventName, this.onchange = function (Y) {
                            if (this.enabled()) {
                                X.onEnter && X.onEnter()
                            } else {
                                M.$(document).jRemoveEvent(this.changeEventName, this.onchange);
                                X.onExit && X.onExit()
                            }
                        }.jBindAsEvent(this));
                        M.$(document).jAddEvent(this.errorEventName, this.onerror = function (Y) {
                            X.fallback && X.fallback();
                            M.$(document).jRemoveEvent(this.errorEventName, this.onerror)
                        }.jBindAsEvent(this));
                        (W[M.jBrowser.domPrefix + "RequestFullscreen"] || W[M.jBrowser.domPrefix + "RequestFullScreen"] || W.requestFullscreen || function () {
                        }).call(W)
                    } else {
                        if (X.fallback) {
                            X.fallback()
                        }
                    }
                },
                cancel: (document.exitFullscreen || document.cancelFullScreen || document[M.jBrowser.domPrefix + "ExitFullscreen"] || document[M.jBrowser.domPrefix + "CancelFullScreen"] || function () {
                }).jBind(document),
                changeEventName: document.msExitFullscreen ? "MSFullscreenChange" : (document.exitFullscreen ? "" : M.jBrowser.domPrefix) + "fullscreenchange",
                errorEventName: document.msExitFullscreen ? "MSFullscreenError" : (document.exitFullscreen ? "" : M.jBrowser.domPrefix) + "fullscreenerror",
                prefix: M.jBrowser.domPrefix,
                activeElement: null
            }
        })();
        var V = /\S+/g, J = /^(border(Top|Bottom|Left|Right)Width)|((padding|margin)(Top|Bottom|Left|Right))$/, O = {"float": ("undefined" === typeof(G.styleFloat)) ? "cssFloat" : "styleFloat"}, Q = {
            fontWeight: true,
            lineHeight: true,
            opacity: true,
            zIndex: true,
            zoom: true
        }, I = (window.getComputedStyle) ? function (Y, W) {
                var X = window.getComputedStyle(Y, null);
                return X ? X.getPropertyValue(W) || X[W] : null
            } : function (Z, X) {
                var Y = Z.currentStyle, W = null;
                W = Y ? Y[X] : null;
                if (null == W && Z.style && Z.style[X]) {
                    W = Z.style[X]
                }
                return W
            };

        function U(Y) {
            var W, X;
            X = (M.jBrowser.webkit && "filter" == Y) ? false : (Y in G);
            if (!X) {
                W = M.jBrowser.cssDomPrefix + Y.charAt(0).toUpperCase() + Y.slice(1);
                if (W in G) {
                    return W
                }
            }
            return Y
        }

        M.normalizeCSS = U;
        M.Element = {
            jHasClass: function (W) {
                return !(W || "").has(" ") && (this.className || "").has(W, " ")
            }, jAddClass: function (aa) {
                var X = (this.className || "").match(V) || [], Z = (aa || "").match(V) || [], W = Z.length, Y = 0;
                for (; Y < W; Y++) {
                    if (!M.$(X).contains(Z[Y])) {
                        X.push(Z[Y])
                    }
                }
                this.className = X.join(" ");
                return this
            }, jRemoveClass: function (ab) {
                var X = (this.className || "").match(V) || [], aa = (ab || "").match(V) || [], W = aa.length, Z = 0, Y;
                for (; Z < W; Z++) {
                    if ((Y = M.$(X).indexOf(aa[Z])) > -1) {
                        X.splice(Y, 1)
                    }
                }
                this.className = ab ? X.join(" ") : "";
                return this
            }, jToggleClass: function (W) {
                return this.jHasClass(W) ? this.jRemoveClass(W) : this.jAddClass(W)
            }, jGetCss: function (X) {
                var Y = X.jCamelize(), W = null;
                X = O[Y] || (O[Y] = U(Y));
                W = I(this, X);
                if ("auto" === W) {
                    W = null
                }
                if (null !== W) {
                    if ("opacity" == X) {
                        return M.defined(W) ? parseFloat(W) : 1
                    }
                    if (J.test(X)) {
                        W = parseInt(W, 10) ? W : "0px"
                    }
                }
                return W
            }, jSetCssProp: function (X, W) {
                var Z = X.jCamelize();
                try {
                    if ("opacity" == X) {
                        this.jSetOpacity(W);
                        return this
                    }
                    X = O[Z] || (O[Z] = U(Z));
                    this.style[X] = W + (("number" == M.jTypeOf(W) && !Q[Z]) ? "px" : "")
                } catch (Y) {
                }
                return this
            }, jSetCss: function (X) {
                for (var W in X) {
                    this.jSetCssProp(W, X[W])
                }
                return this
            }, jGetStyles: function () {
                var W = {};
                M.$A(arguments).jEach(function (X) {
                    W[X] = this.jGetCss(X)
                }, this);
                return W
            }, jSetOpacity: function (Y, W) {
                var X;
                W = W || false;
                this.style.opacity = Y;
                Y = parseInt(parseFloat(Y) * 100);
                if (W) {
                    if (0 === Y) {
                        if ("hidden" != this.style.visibility) {
                            this.style.visibility = "hidden"
                        }
                    } else {
                        if ("visible" != this.style.visibility) {
                            this.style.visibility = "visible"
                        }
                    }
                }
                if (M.jBrowser.ieMode && M.jBrowser.ieMode < 9) {
                    if (!isNaN(Y)) {
                        if (!~this.style.filter.indexOf("Alpha")) {
                            this.style.filter += " progid:DXImageTransform.Microsoft.Alpha(Opacity=" + Y + ")"
                        } else {
                            this.style.filter = this.style.filter.replace(/Opacity=\d*/i, "Opacity=" + Y)
                        }
                    } else {
                        this.style.filter = this.style.filter.replace(/progid:DXImageTransform.Microsoft.Alpha\(Opacity=\d*\)/i, "").jTrim();
                        if ("" === this.style.filter) {
                            this.style.removeAttribute("filter")
                        }
                    }
                }
                return this
            }, setProps: function (W) {
                for (var X in W) {
                    if ("class" === X) {
                        this.jAddClass("" + W[X])
                    } else {
                        this.setAttribute(X, "" + W[X])
                    }
                }
                return this
            }, jGetTransitionDuration: function () {
                var X = 0, W = 0;
                X = this.jGetCss("transition-duration");
                W = this.jGetCss("transition-delay");
                X = X.indexOf("ms") > -1 ? parseFloat(X) : X.indexOf("s") > -1 ? parseFloat(X) * 1000 : 0;
                W = W.indexOf("ms") > -1 ? parseFloat(W) : W.indexOf("s") > -1 ? parseFloat(W) * 1000 : 0;
                return X + W
            }, hide: function () {
                return this.jSetCss({display: "none", visibility: "hidden"})
            }, show: function () {
                return this.jSetCss({display: "", visibility: "visible"})
            }, jGetSize: function () {
                return {width: this.offsetWidth, height: this.offsetHeight}
            }, getInnerSize: function (X) {
                var W = this.jGetSize();
                W.width -= (parseFloat(this.jGetCss("border-left-width") || 0) + parseFloat(this.jGetCss("border-right-width") || 0));
                W.height -= (parseFloat(this.jGetCss("border-top-width") || 0) + parseFloat(this.jGetCss("border-bottom-width") || 0));
                if (!X) {
                    W.width -= (parseFloat(this.jGetCss("padding-left") || 0) + parseFloat(this.jGetCss("padding-right") || 0));
                    W.height -= (parseFloat(this.jGetCss("padding-top") || 0) + parseFloat(this.jGetCss("padding-bottom") || 0))
                }
                return W
            }, jGetScroll: function () {
                return {top: this.scrollTop, left: this.scrollLeft}
            }, jGetFullScroll: function () {
                var W = this, X = {top: 0, left: 0};
                do {
                    X.left += W.scrollLeft || 0;
                    X.top += W.scrollTop || 0;
                    W = W.parentNode
                } while (W);
                return X
            }, jGetPosition: function () {
                var aa = this, X = 0, Z = 0;
                if (M.defined(document.documentElement.getBoundingClientRect)) {
                    var W = this.getBoundingClientRect(), Y = M.$(document).jGetScroll(), ab = M.jBrowser.getDoc();
                    return {top: W.top + Y.y - ab.clientTop, left: W.left + Y.x - ab.clientLeft}
                }
                do {
                    X += aa.offsetLeft || 0;
                    Z += aa.offsetTop || 0;
                    aa = aa.offsetParent
                } while (aa && !(/^(?:body|html)$/i).test(aa.tagName));
                return {top: Z, left: X}
            }, jGetRect: function () {
                var X = this.jGetPosition();
                var W = this.jGetSize();
                return {top: X.top, bottom: X.top + W.height, left: X.left, right: X.left + W.width}
            }, changeContent: function (X) {
                try {
                    this.innerHTML = X
                } catch (W) {
                    this.innerText = X
                }
                return this
            }, jRemove: function () {
                return (this.parentNode) ? this.parentNode.removeChild(this) : this
            }, kill: function () {
                M.$A(this.childNodes).jEach(function (W) {
                    if (3 == W.nodeType || 8 == W.nodeType) {
                        return
                    }
                    M.$(W).kill()
                });
                this.jRemove();
                this.jClearEvents();
                if (this.$J_UUID) {
                    M.storage[this.$J_UUID] = null;
                    delete M.storage[this.$J_UUID]
                }
                return null
            }, append: function (Y, X) {
                X = X || "bottom";
                var W = this.firstChild;
                ("top" == X && W) ? this.insertBefore(Y, W) : this.appendChild(Y);
                return this
            }, jAppendTo: function (Y, X) {
                var W = M.$(Y).append(this, X);
                return this
            }, enclose: function (W) {
                this.append(W.parentNode.replaceChild(this, W));
                return this
            }, hasChild: function (W) {
                if ("element" !== M.jTypeOf("string" == M.jTypeOf(W) ? W = document.getElementById(W) : W)) {
                    return false
                }
                return (this == W) ? false : (this.contains && !(M.jBrowser.webkit419)) ? (this.contains(W)) : (this.compareDocumentPosition) ? !!(this.compareDocumentPosition(W) & 16) : M.$A(this.byTag(W.tagName)).contains(W)
            }
        };
        M.Element.jGetStyle = M.Element.jGetCss;
        M.Element.jSetStyle = M.Element.jSetCss;
        if (!window.Element) {
            window.Element = M.$F;
            if (M.jBrowser.engine.webkit) {
                window.document.createElement("iframe")
            }
            window.Element.prototype = (M.jBrowser.engine.webkit) ? window["[[DOMElement.prototype]]"] : {}
        }
        M.implement(window.Element, {$J_TYPE: "element"});
        M.Doc = {
            jGetSize: function () {
                if (M.jBrowser.touchScreen || M.jBrowser.presto925 || M.jBrowser.webkit419) {
                    return {width: window.innerWidth, height: window.innerHeight}
                }
                return {width: M.jBrowser.getDoc().clientWidth, height: M.jBrowser.getDoc().clientHeight}
            }, jGetScroll: function () {
                return {
                    x: window.pageXOffset || M.jBrowser.getDoc().scrollLeft,
                    y: window.pageYOffset || M.jBrowser.getDoc().scrollTop
                }
            }, jGetFullSize: function () {
                var W = this.jGetSize();
                return {
                    width: Math.max(M.jBrowser.getDoc().scrollWidth, W.width),
                    height: Math.max(M.jBrowser.getDoc().scrollHeight, W.height)
                }
            }
        };
        M.extend(document, {$J_TYPE: "document"});
        M.extend(window, {$J_TYPE: "window"});
        M.extend([M.Element, M.Doc], {
            jFetch: function (Z, X) {
                var W = M.getStorage(this.$J_UUID), Y = W[Z];
                if (undefined !== X && undefined === Y) {
                    Y = W[Z] = X
                }
                return (M.defined(Y) ? Y : null)
            }, jStore: function (Y, X) {
                var W = M.getStorage(this.$J_UUID);
                W[Y] = X;
                return this
            }, jDel: function (X) {
                var W = M.getStorage(this.$J_UUID);
                delete W[X];
                return this
            }
        });
        if (!(window.HTMLElement && window.HTMLElement.prototype && window.HTMLElement.prototype.getElementsByClassName)) {
            M.extend([M.Element, M.Doc], {
                getElementsByClassName: function (W) {
                    return M.$A(this.getElementsByTagName("*")).filter(function (Y) {
                        try {
                            return (1 == Y.nodeType && Y.className.has(W, " "))
                        } catch (X) {
                        }
                    })
                }
            })
        }
        M.extend([M.Element, M.Doc], {
            byClass: function () {
                return this.getElementsByClassName(arguments[0])
            }, byTag: function () {
                return this.getElementsByTagName(arguments[0])
            }
        });
        if (M.jBrowser.fullScreen.capable && !document.requestFullScreen) {
            M.Element.requestFullScreen = function () {
                M.jBrowser.fullScreen.request(this)
            }
        }
        M.Event = {
            $J_TYPE: "event", isQueueStopped: M.$false, stop: function () {
                return this.stopDistribution().stopDefaults()
            }, stopDistribution: function () {
                if (this.stopPropagation) {
                    this.stopPropagation()
                } else {
                    this.cancelBubble = true
                }
                return this
            }, stopDefaults: function () {
                if (this.preventDefault) {
                    this.preventDefault()
                } else {
                    this.returnValue = false
                }
                return this
            }, stopQueue: function () {
                this.isQueueStopped = M.$true;
                return this
            }, getClientXY: function () {
                var X, W;
                X = ((/touch/i).test(this.type)) ? this.changedTouches[0] : this;
                return (!M.defined(X)) ? {x: 0, y: 0} : {x: X.clientX, y: X.clientY}
            }, jGetPageXY: function () {
                var X, W;
                X = ((/touch/i).test(this.type)) ? this.changedTouches[0] : this;
                return (!M.defined(X)) ? {x: 0, y: 0} : {
                        x: X.pageX || X.clientX + M.jBrowser.getDoc().scrollLeft,
                        y: X.pageY || X.clientY + M.jBrowser.getDoc().scrollTop
                    }
            }, getTarget: function () {
                var W = this.target || this.srcElement;
                while (W && 3 == W.nodeType) {
                    W = W.parentNode
                }
                return W
            }, getRelated: function () {
                var X = null;
                switch (this.type) {
                    case"mouseover":
                    case"pointerover":
                    case"MSPointerOver":
                        X = this.relatedTarget || this.fromElement;
                        break;
                    case"mouseout":
                    case"pointerout":
                    case"MSPointerOut":
                        X = this.relatedTarget || this.toElement;
                        break;
                    default:
                        return X
                }
                try {
                    while (X && 3 == X.nodeType) {
                        X = X.parentNode
                    }
                } catch (W) {
                    X = null
                }
                return X
            }, getButton: function () {
                if (!this.which && this.button !== undefined) {
                    return (this.button & 1 ? 1 : (this.button & 2 ? 3 : (this.button & 4 ? 2 : 0)))
                }
                return this.which
            }, isTouchEvent: function () {
                return (this.pointerType && ("touch" === this.pointerType || this.pointerType === this.MSPOINTER_TYPE_TOUCH)) || (/touch/i).test(this.type)
            }, isPrimaryTouch: function () {
                return this.pointerType ? (("touch" === this.pointerType || this.MSPOINTER_TYPE_TOUCH === this.pointerType) && this.isPrimary) : 1 === this.changedTouches.length && (this.targetTouches.length ? this.targetTouches[0].identifier == this.changedTouches[0].identifier : true)
            }
        };
        M._event_add_ = "addEventListener";
        M._event_del_ = "removeEventListener";
        M._event_prefix_ = "";
        if (!document.addEventListener) {
            M._event_add_ = "attachEvent";
            M._event_del_ = "detachEvent";
            M._event_prefix_ = "on"
        }
        M.Event.Custom = {
            type: "",
            x: null,
            y: null,
            timeStamp: null,
            button: null,
            target: null,
            relatedTarget: null,
            $J_TYPE: "event.custom",
            isQueueStopped: M.$false,
            events: M.$([]),
            pushToEvents: function (W) {
                var X = W;
                this.events.push(X)
            },
            stop: function () {
                return this.stopDistribution().stopDefaults()
            },
            stopDistribution: function () {
                this.events.jEach(function (X) {
                    try {
                        X.stopDistribution()
                    } catch (W) {
                    }
                });
                return this
            },
            stopDefaults: function () {
                this.events.jEach(function (X) {
                    try {
                        X.stopDefaults()
                    } catch (W) {
                    }
                });
                return this
            },
            stopQueue: function () {
                this.isQueueStopped = M.$true;
                return this
            },
            getClientXY: function () {
                return {x: this.clientX, y: this.clientY}
            },
            jGetPageXY: function () {
                return {x: this.x, y: this.y}
            },
            getTarget: function () {
                return this.target
            },
            getRelated: function () {
                return this.relatedTarget
            },
            getButton: function () {
                return this.button
            },
            getOriginalTarget: function () {
                return this.events.length > 0 ? this.events[0].getTarget() : undefined
            }
        };
        M.extend([M.Element, M.Doc], {
            jAddEvent: function (Y, aa, ab, ae) {
                var ad, W, Z, ac, X;
                if ("string" == M.jTypeOf(Y)) {
                    X = Y.split(" ");
                    if (X.length > 1) {
                        Y = X
                    }
                }
                if (M.jTypeOf(Y) == "array") {
                    M.$(Y).jEach(this.jAddEvent.jBindAsEvent(this, aa, ab, ae));
                    return this
                }
                if (!Y || !aa || M.jTypeOf(Y) != "string" || M.jTypeOf(aa) != "function") {
                    return this
                }
                if (Y == "domready" && M.jBrowser.ready) {
                    aa.call(this);
                    return this
                }
                Y = T[Y] || Y;
                ab = parseInt(ab || 50);
                if (!aa.$J_EUID) {
                    aa.$J_EUID = Math.floor(Math.random() * M.now())
                }
                ad = M.Doc.jFetch.call(this, "_EVENTS_", {});
                W = ad[Y];
                if (!W) {
                    ad[Y] = W = M.$([]);
                    Z = this;
                    if (M.Event.Custom[Y]) {
                        M.Event.Custom[Y].handler.add.call(this, ae)
                    } else {
                        W.handle = function (af) {
                            af = M.extend(af || window.e, {$J_TYPE: "event"});
                            M.Doc.jCallEvent.call(Z, Y, M.$(af))
                        };
                        this[M._event_add_](M._event_prefix_ + Y, W.handle, false)
                    }
                }
                ac = {type: Y, fn: aa, priority: ab, euid: aa.$J_EUID};
                W.push(ac);
                W.sort(function (ag, af) {
                    return ag.priority - af.priority
                });
                return this
            }, jRemoveEvent: function (ac) {
                var aa = M.Doc.jFetch.call(this, "_EVENTS_", {}), Y, W, X, ad, ab, Z;
                ab = arguments.length > 1 ? arguments[1] : -100;
                if ("string" == M.jTypeOf(ac)) {
                    Z = ac.split(" ");
                    if (Z.length > 1) {
                        ac = Z
                    }
                }
                if (M.jTypeOf(ac) == "array") {
                    M.$(ac).jEach(this.jRemoveEvent.jBindAsEvent(this, ab));
                    return this
                }
                ac = T[ac] || ac;
                if (!ac || M.jTypeOf(ac) != "string" || !aa || !aa[ac]) {
                    return this
                }
                Y = aa[ac] || [];
                for (X = 0; X < Y.length; X++) {
                    W = Y[X];
                    if (-100 == ab || !!ab && ab.$J_EUID === W.euid) {
                        ad = Y.splice(X--, 1)
                    }
                }
                if (0 === Y.length) {
                    if (M.Event.Custom[ac]) {
                        M.Event.Custom[ac].handler.jRemove.call(this)
                    } else {
                        this[M._event_del_](M._event_prefix_ + ac, Y.handle, false)
                    }
                    delete aa[ac]
                }
                return this
            }, jCallEvent: function (aa, ac) {
                var Z = M.Doc.jFetch.call(this, "_EVENTS_", {}), Y, W, X;
                aa = T[aa] || aa;
                if (!aa || M.jTypeOf(aa) != "string" || !Z || !Z[aa]) {
                    return this
                }
                try {
                    ac = M.extend(ac || {}, {type: aa})
                } catch (ab) {
                }
                if (undefined === ac.timeStamp) {
                    ac.timeStamp = M.now()
                }
                Y = Z[aa] || [];
                for (X = 0; X < Y.length && !(ac.isQueueStopped && ac.isQueueStopped()); X++) {
                    Y[X].fn.call(this, ac)
                }
            }, jRaiseEvent: function (X, W) {
                var aa = ("domready" == X) ? false : true, Z = this, Y;
                X = T[X] || X;
                if (!aa) {
                    M.Doc.jCallEvent.call(this, X);
                    return this
                }
                if (Z === document && document.createEvent && !Z.dispatchEvent) {
                    Z = document.documentElement
                }
                if (document.createEvent) {
                    Y = document.createEvent(X);
                    Y.initEvent(W, true, true)
                } else {
                    Y = document.createEventObject();
                    Y.eventType = X
                }
                if (document.createEvent) {
                    Z.dispatchEvent(Y)
                } else {
                    Z.fireEvent("on" + W, Y)
                }
                return Y
            }, jClearEvents: function () {
                var X = M.Doc.jFetch.call(this, "_EVENTS_");
                if (!X) {
                    return this
                }
                for (var W in X) {
                    M.Doc.jRemoveEvent.call(this, W)
                }
                M.Doc.jDel.call(this, "_EVENTS_");
                return this
            }
        });
        (function (W) {
            if ("complete" === document.readyState) {
                return W.jBrowser.onready.jDelay(1)
            }
            if (W.jBrowser.webkit && W.jBrowser.version < 420) {
                (function () {
                    (W.$(["loaded", "complete"]).contains(document.readyState)) ? W.jBrowser.onready() : arguments.callee.jDelay(50)
                })()
            } else {
                if (W.jBrowser.trident && W.jBrowser.ieMode < 9 && window == top) {
                    (function () {
                        (W.$try(function () {
                            W.jBrowser.getDoc().doScroll("left");
                            return true
                        })) ? W.jBrowser.onready() : arguments.callee.jDelay(50)
                    })()
                } else {
                    W.Doc.jAddEvent.call(W.$(document), "DOMContentLoaded", W.jBrowser.onready);
                    W.Doc.jAddEvent.call(W.$(window), "load", W.jBrowser.onready)
                }
            }
        })(S);
        M.Class = function () {
            var aa = null, X = M.$A(arguments);
            if ("class" == M.jTypeOf(X[0])) {
                aa = X.shift()
            }
            var W = function () {
                for (var ad in this) {
                    this[ad] = M.detach(this[ad])
                }
                if (this.constructor.$parent) {
                    this.$parent = {};
                    var af = this.constructor.$parent;
                    for (var ae in af) {
                        var ac = af[ae];
                        switch (M.jTypeOf(ac)) {
                            case"function":
                                this.$parent[ae] = M.Class.wrap(this, ac);
                                break;
                            case"object":
                                this.$parent[ae] = M.detach(ac);
                                break;
                            case"array":
                                this.$parent[ae] = M.detach(ac);
                                break
                        }
                    }
                }
                var ab = (this.init) ? this.init.apply(this, arguments) : this;
                delete this.caller;
                return ab
            };
            if (!W.prototype.init) {
                W.prototype.init = M.$F
            }
            if (aa) {
                var Z = function () {
                };
                Z.prototype = aa.prototype;
                W.prototype = new Z;
                W.$parent = {};
                for (var Y in aa.prototype) {
                    W.$parent[Y] = aa.prototype[Y]
                }
            } else {
                W.$parent = null
            }
            W.constructor = M.Class;
            W.prototype.constructor = W;
            M.extend(W.prototype, X[0]);
            M.extend(W, {$J_TYPE: "class"});
            return W
        };
        S.Class.wrap = function (W, X) {
            return function () {
                var Z = this.caller;
                var Y = X.apply(W, arguments);
                return Y
            }
        };
        (function (Z) {
            var Y = Z.$;
            var W = 5, X = 300;
            Z.Event.Custom.btnclick = new Z.Class(Z.extend(Z.Event.Custom, {
                type: "btnclick", init: function (ac, ab) {
                    var aa = ab.jGetPageXY();
                    this.x = aa.x;
                    this.y = aa.y;
                    this.clientX = ab.clientX;
                    this.clientY = ab.clientY;
                    this.timeStamp = ab.timeStamp;
                    this.button = ab.getButton();
                    this.target = ac;
                    this.pushToEvents(ab)
                }
            }));
            Z.Event.Custom.btnclick.handler = {
                options: {threshold: X, button: 1}, add: function (aa) {
                    this.jStore("event:btnclick:options", Z.extend(Z.detach(Z.Event.Custom.btnclick.handler.options), aa || {}));
                    this.jAddEvent("mousedown", Z.Event.Custom.btnclick.handler.handle, 1);
                    this.jAddEvent("mouseup", Z.Event.Custom.btnclick.handler.handle, 1);
                    this.jAddEvent("click", Z.Event.Custom.btnclick.handler.onclick, 1);
                    if (Z.jBrowser.trident && Z.jBrowser.ieMode < 9) {
                        this.jAddEvent("dblclick", Z.Event.Custom.btnclick.handler.handle, 1)
                    }
                }, jRemove: function () {
                    this.jRemoveEvent("mousedown", Z.Event.Custom.btnclick.handler.handle);
                    this.jRemoveEvent("mouseup", Z.Event.Custom.btnclick.handler.handle);
                    this.jRemoveEvent("click", Z.Event.Custom.btnclick.handler.onclick);
                    if (Z.jBrowser.trident && Z.jBrowser.ieMode < 9) {
                        this.jRemoveEvent("dblclick", Z.Event.Custom.btnclick.handler.handle)
                    }
                }, onclick: function (aa) {
                    aa.stopDefaults()
                }, handle: function (ad) {
                    var ac, aa, ab;
                    aa = this.jFetch("event:btnclick:options");
                    if (ad.type != "dblclick" && ad.getButton() != aa.button) {
                        return
                    }
                    if (this.jFetch("event:btnclick:ignore")) {
                        this.jDel("event:btnclick:ignore");
                        return
                    }
                    if ("mousedown" == ad.type) {
                        ac = new Z.Event.Custom.btnclick(this, ad);
                        this.jStore("event:btnclick:btnclickEvent", ac)
                    } else {
                        if ("mouseup" == ad.type) {
                            ac = this.jFetch("event:btnclick:btnclickEvent");
                            if (!ac) {
                                return
                            }
                            ab = ad.jGetPageXY();
                            this.jDel("event:btnclick:btnclickEvent");
                            ac.pushToEvents(ad);
                            if (ad.timeStamp - ac.timeStamp <= aa.threshold && Math.sqrt(Math.pow(ab.x - ac.x, 2) + Math.pow(ab.y - ac.y, 2)) <= W) {
                                this.jCallEvent("btnclick", ac)
                            }
                            document.jCallEvent("mouseup", ad)
                        } else {
                            if (ad.type == "dblclick") {
                                ac = new Z.Event.Custom.btnclick(this, ad);
                                this.jCallEvent("btnclick", ac)
                            }
                        }
                    }
                }
            }
        })(S);
        (function (X) {
            var W = X.$;
            X.Event.Custom.mousedrag = new X.Class(X.extend(X.Event.Custom, {
                type: "mousedrag",
                state: "dragstart",
                dragged: false,
                init: function (ab, aa, Z) {
                    var Y = aa.jGetPageXY();
                    this.x = Y.x;
                    this.y = Y.y;
                    this.clientX = aa.clientX;
                    this.clientY = aa.clientY;
                    this.timeStamp = aa.timeStamp;
                    this.button = aa.getButton();
                    this.target = ab;
                    this.pushToEvents(aa);
                    this.state = Z
                }
            }));
            X.Event.Custom.mousedrag.handler = {
                add: function () {
                    var Z = X.Event.Custom.mousedrag.handler.handleMouseMove.jBindAsEvent(this), Y = X.Event.Custom.mousedrag.handler.handleMouseUp.jBindAsEvent(this);
                    this.jAddEvent("mousedown", X.Event.Custom.mousedrag.handler.handleMouseDown, 1);
                    this.jAddEvent("mouseup", X.Event.Custom.mousedrag.handler.handleMouseUp, 1);
                    document.jAddEvent("mousemove", Z, 1);
                    document.jAddEvent("mouseup", Y, 1);
                    this.jStore("event:mousedrag:listeners:document:move", Z);
                    this.jStore("event:mousedrag:listeners:document:end", Y)
                }, jRemove: function () {
                    this.jRemoveEvent("mousedown", X.Event.Custom.mousedrag.handler.handleMouseDown);
                    this.jRemoveEvent("mouseup", X.Event.Custom.mousedrag.handler.handleMouseUp);
                    W(document).jRemoveEvent("mousemove", this.jFetch("event:mousedrag:listeners:document:move") || X.$F);
                    W(document).jRemoveEvent("mouseup", this.jFetch("event:mousedrag:listeners:document:end") || X.$F);
                    this.jDel("event:mousedrag:listeners:document:move");
                    this.jDel("event:mousedrag:listeners:document:end")
                }, handleMouseDown: function (Z) {
                    var Y;
                    if (1 != Z.getButton()) {
                        return
                    }
                    Z.stopDefaults();
                    Y = new X.Event.Custom.mousedrag(this, Z, "dragstart");
                    this.jStore("event:mousedrag:dragstart", Y)
                }, handleMouseUp: function (Z) {
                    var Y;
                    Y = this.jFetch("event:mousedrag:dragstart");
                    if (!Y) {
                        return
                    }
                    Z.stopDefaults();
                    Y = new X.Event.Custom.mousedrag(this, Z, "dragend");
                    this.jDel("event:mousedrag:dragstart");
                    this.jCallEvent("mousedrag", Y)
                }, handleMouseMove: function (Z) {
                    var Y;
                    Y = this.jFetch("event:mousedrag:dragstart");
                    if (!Y) {
                        return
                    }
                    Z.stopDefaults();
                    if (!Y.dragged) {
                        Y.dragged = true;
                        this.jCallEvent("mousedrag", Y)
                    }
                    Y = new X.Event.Custom.mousedrag(this, Z, "dragmove");
                    this.jCallEvent("mousedrag", Y)
                }
            }
        })(S);
        (function (X) {
            var W = X.$;
            X.Event.Custom.dblbtnclick = new X.Class(X.extend(X.Event.Custom, {
                type: "dblbtnclick",
                timedout: false,
                tm: null,
                init: function (aa, Z) {
                    var Y = Z.jGetPageXY();
                    this.x = Y.x;
                    this.y = Y.y;
                    this.clientX = Z.clientX;
                    this.clientY = Z.clientY;
                    this.timeStamp = Z.timeStamp;
                    this.button = Z.getButton();
                    this.target = aa;
                    this.pushToEvents(Z)
                }
            }));
            X.Event.Custom.dblbtnclick.handler = {
                options: {threshold: 200}, add: function (Y) {
                    this.jStore("event:dblbtnclick:options", X.extend(X.detach(X.Event.Custom.dblbtnclick.handler.options), Y || {}));
                    this.jAddEvent("btnclick", X.Event.Custom.dblbtnclick.handler.handle, 1)
                }, jRemove: function () {
                    this.jRemoveEvent("btnclick", X.Event.Custom.dblbtnclick.handler.handle)
                }, handle: function (aa) {
                    var Z, Y;
                    Z = this.jFetch("event:dblbtnclick:event");
                    Y = this.jFetch("event:dblbtnclick:options");
                    if (!Z) {
                        Z = new X.Event.Custom.dblbtnclick(this, aa);
                        Z.tm = setTimeout(function () {
                            Z.timedout = true;
                            aa.isQueueStopped = X.$false;
                            this.jCallEvent("btnclick", aa);
                            this.jDel("event:dblbtnclick:event")
                        }.jBind(this), Y.threshold + 10);
                        this.jStore("event:dblbtnclick:event", Z);
                        aa.stopQueue()
                    } else {
                        clearTimeout(Z.tm);
                        this.jDel("event:dblbtnclick:event");
                        if (!Z.timedout) {
                            Z.pushToEvents(aa);
                            aa.stopQueue().stop();
                            this.jCallEvent("dblbtnclick", Z)
                        } else {
                        }
                    }
                }
            }
        })(S);
        (function (ac) {
            var ab = ac.$;

            function W(ad) {
                return ad.pointerType ? (("touch" === ad.pointerType || ad.MSPOINTER_TYPE_TOUCH === ad.pointerType) && ad.isPrimary) : 1 === ad.changedTouches.length && (ad.targetTouches.length ? ad.targetTouches[0].identifier == ad.changedTouches[0].identifier : true)
            }

            function Y(ad) {
                if (ad.pointerType) {
                    return ("touch" === ad.pointerType || ad.MSPOINTER_TYPE_TOUCH === ad.pointerType) ? ad.pointerId : null
                } else {
                    return ad.changedTouches[0].identifier
                }
            }

            function Z(ad) {
                if (ad.pointerType) {
                    return ("touch" === ad.pointerType || ad.MSPOINTER_TYPE_TOUCH === ad.pointerType) ? ad : null
                } else {
                    return ad.changedTouches[0]
                }
            }

            ac.Event.Custom.tap = new ac.Class(ac.extend(ac.Event.Custom, {
                type: "tap",
                id: null,
                init: function (ae, ad) {
                    var af = Z(ad);
                    this.id = af.pointerId || af.identifier;
                    this.x = af.pageX;
                    this.y = af.pageY;
                    this.pageX = af.pageX;
                    this.pageY = af.pageY;
                    this.clientX = af.clientX;
                    this.clientY = af.clientY;
                    this.timeStamp = ad.timeStamp;
                    this.button = 0;
                    this.target = ae;
                    this.pushToEvents(ad)
                }
            }));
            var X = 10, aa = 200;
            ac.Event.Custom.tap.handler = {
                add: function (ad) {
                    this.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ac.Event.Custom.tap.handler.onTouchStart, 1);
                    this.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ac.Event.Custom.tap.handler.onTouchEnd, 1);
                    this.jAddEvent("click", ac.Event.Custom.tap.handler.onClick, 1)
                }, jRemove: function () {
                    this.jRemoveEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ac.Event.Custom.tap.handler.onTouchStart);
                    this.jRemoveEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ac.Event.Custom.tap.handler.onTouchEnd);
                    this.jRemoveEvent("click", ac.Event.Custom.tap.handler.onClick)
                }, onClick: function (ad) {
                    ad.stopDefaults()
                }, onTouchStart: function (ad) {
                    if (!W(ad)) {
                        this.jDel("event:tap:event");
                        return
                    }
                    this.jStore("event:tap:event", new ac.Event.Custom.tap(this, ad));
                    this.jStore("event:btnclick:ignore", true)
                }, onTouchEnd: function (ag) {
                    var ae = ac.now(), af = this.jFetch("event:tap:event"), ad = this.jFetch("event:tap:options");
                    if (!af || !W(ag)) {
                        return
                    }
                    this.jDel("event:tap:event");
                    if (af.id == Y(ag) && ag.timeStamp - af.timeStamp <= aa && Math.sqrt(Math.pow(Z(ag).pageX - af.x, 2) + Math.pow(Z(ag).pageY - af.y, 2)) <= X) {
                        this.jDel("event:btnclick:btnclickEvent");
                        ag.stop();
                        af.pushToEvents(ag);
                        this.jCallEvent("tap", af)
                    }
                }
            }
        })(S);
        M.Event.Custom.dbltap = new M.Class(M.extend(M.Event.Custom, {
            type: "dbltap",
            timedout: false,
            tm: null,
            init: function (X, W) {
                this.x = W.x;
                this.y = W.y;
                this.clientX = W.clientX;
                this.clientY = W.clientY;
                this.timeStamp = W.timeStamp;
                this.button = 0;
                this.target = X;
                this.pushToEvents(W)
            }
        }));
        M.Event.Custom.dbltap.handler = {
            options: {threshold: 300}, add: function (W) {
                this.jStore("event:dbltap:options", M.extend(M.detach(M.Event.Custom.dbltap.handler.options), W || {}));
                this.jAddEvent("tap", M.Event.Custom.dbltap.handler.handle, 1)
            }, jRemove: function () {
                this.jRemoveEvent("tap", M.Event.Custom.dbltap.handler.handle)
            }, handle: function (Y) {
                var X, W;
                X = this.jFetch("event:dbltap:event");
                W = this.jFetch("event:dbltap:options");
                if (!X) {
                    X = new M.Event.Custom.dbltap(this, Y);
                    X.tm = setTimeout(function () {
                        X.timedout = true;
                        Y.isQueueStopped = M.$false;
                        this.jCallEvent("tap", Y)
                    }.jBind(this), W.threshold + 10);
                    this.jStore("event:dbltap:event", X);
                    Y.stopQueue()
                } else {
                    clearTimeout(X.tm);
                    this.jDel("event:dbltap:event");
                    if (!X.timedout) {
                        X.pushToEvents(Y);
                        Y.stopQueue().stop();
                        this.jCallEvent("dbltap", X)
                    } else {
                    }
                }
            }
        };
        (function (ab) {
            var aa = ab.$;

            function W(ac) {
                return ac.pointerType ? (("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) && ac.isPrimary) : 1 === ac.changedTouches.length && (ac.targetTouches.length ? ac.targetTouches[0].identifier == ac.changedTouches[0].identifier : true)
            }

            function Y(ac) {
                if (ac.pointerType) {
                    return ("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) ? ac.pointerId : null
                } else {
                    return ac.changedTouches[0].identifier
                }
            }

            function Z(ac) {
                if (ac.pointerType) {
                    return ("touch" === ac.pointerType || ac.MSPOINTER_TYPE_TOUCH === ac.pointerType) ? ac : null
                } else {
                    return ac.changedTouches[0]
                }
            }

            var X = 10;
            ab.Event.Custom.touchdrag = new ab.Class(ab.extend(ab.Event.Custom, {
                type: "touchdrag",
                state: "dragstart",
                id: null,
                dragged: false,
                init: function (ae, ad, ac) {
                    var af = Z(ad);
                    this.id = af.pointerId || af.identifier;
                    this.clientX = af.clientX;
                    this.clientY = af.clientY;
                    this.pageX = af.pageX;
                    this.pageY = af.pageY;
                    this.x = af.pageX;
                    this.y = af.pageY;
                    this.timeStamp = ad.timeStamp;
                    this.button = 0;
                    this.target = ae;
                    this.pushToEvents(ad);
                    this.state = ac
                }
            }));
            ab.Event.Custom.touchdrag.handler = {
                add: function () {
                    var ad = ab.Event.Custom.touchdrag.handler.onTouchMove.jBind(this), ac = ab.Event.Custom.touchdrag.handler.onTouchEnd.jBind(this);
                    this.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ab.Event.Custom.touchdrag.handler.onTouchStart, 1);
                    this.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ab.Event.Custom.touchdrag.handler.onTouchEnd, 1);
                    this.jAddEvent(["touchmove", window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove"], ab.Event.Custom.touchdrag.handler.onTouchMove, 1);
                    this.jStore("event:touchdrag:listeners:document:move", ad);
                    this.jStore("event:touchdrag:listeners:document:end", ac);
                    aa(document).jAddEvent(window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove", ad, 1);
                    aa(document).jAddEvent(window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp", ac, 1)
                }, jRemove: function () {
                    this.jRemoveEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], ab.Event.Custom.touchdrag.handler.onTouchStart);
                    this.jRemoveEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], ab.Event.Custom.touchdrag.handler.onTouchEnd);
                    this.jRemoveEvent(["touchmove", window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove"], ab.Event.Custom.touchdrag.handler.onTouchMove);
                    aa(document).jRemoveEvent(window.navigator.pointerEnabled ? "pointermove" : "MSPointerMove", this.jFetch("event:touchdrag:listeners:document:move") || ab.$F, 1);
                    aa(document).jRemoveEvent(window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp", this.jFetch("event:touchdrag:listeners:document:end") || ab.$F, 1);
                    this.jDel("event:touchdrag:listeners:document:move");
                    this.jDel("event:touchdrag:listeners:document:end")
                }, onTouchStart: function (ad) {
                    var ac;
                    if (!W(ad)) {
                        return
                    }
                    ac = new ab.Event.Custom.touchdrag(this, ad, "dragstart");
                    this.jStore("event:touchdrag:dragstart", ac)
                }, onTouchEnd: function (ad) {
                    var ac;
                    ac = this.jFetch("event:touchdrag:dragstart");
                    if (!ac || !ac.dragged || ac.id != Y(ad)) {
                        return
                    }
                    ac = new ab.Event.Custom.touchdrag(this, ad, "dragend");
                    this.jDel("event:touchdrag:dragstart");
                    this.jCallEvent("touchdrag", ac)
                }, onTouchMove: function (ad) {
                    var ac;
                    ac = this.jFetch("event:touchdrag:dragstart");
                    if (!ac || !W(ad)) {
                        return
                    }
                    if (ac.id != Y(ad)) {
                        this.jDel("event:touchdrag:dragstart");
                        return
                    }
                    if (!ac.dragged && Math.sqrt(Math.pow(Z(ad).pageX - ac.x, 2) + Math.pow(Z(ad).pageY - ac.y, 2)) > X) {
                        ac.dragged = true;
                        this.jCallEvent("touchdrag", ac)
                    }
                    if (!ac.dragged) {
                        return
                    }
                    ac = new ab.Event.Custom.touchdrag(this, ad, "dragmove");
                    this.jCallEvent("touchdrag", ac)
                }
            }
        })(S);
        M.Event.Custom.touchpinch = new M.Class(M.extend(M.Event.Custom, {
            type: "touchpinch",
            scale: 1,
            previousScale: 1,
            curScale: 1,
            state: "pinchstart",
            init: function (X, W) {
                this.timeStamp = W.timeStamp;
                this.button = 0;
                this.target = X;
                this.x = W.touches[0].clientX + (W.touches[1].clientX - W.touches[0].clientX) / 2;
                this.y = W.touches[0].clientY + (W.touches[1].clientY - W.touches[0].clientY) / 2;
                this._initialDistance = Math.sqrt(Math.pow(W.touches[0].clientX - W.touches[1].clientX, 2) + Math.pow(W.touches[0].clientY - W.touches[1].clientY, 2));
                this.pushToEvents(W)
            },
            update: function (W) {
                var X;
                this.state = "pinchupdate";
                if (W.changedTouches[0].identifier != this.events[0].touches[0].identifier || W.changedTouches[1].identifier != this.events[0].touches[1].identifier) {
                    return
                }
                X = Math.sqrt(Math.pow(W.changedTouches[0].clientX - W.changedTouches[1].clientX, 2) + Math.pow(W.changedTouches[0].clientY - W.changedTouches[1].clientY, 2));
                this.previousScale = this.scale;
                this.scale = X / this._initialDistance;
                this.curScale = this.scale / this.previousScale;
                this.x = W.changedTouches[0].clientX + (W.changedTouches[1].clientX - W.changedTouches[0].clientX) / 2;
                this.y = W.changedTouches[0].clientY + (W.changedTouches[1].clientY - W.changedTouches[0].clientY) / 2;
                this.pushToEvents(W)
            }
        }));
        M.Event.Custom.touchpinch.handler = {
            add: function () {
                this.jAddEvent("touchstart", M.Event.Custom.touchpinch.handler.handleTouchStart, 1);
                this.jAddEvent("touchend", M.Event.Custom.touchpinch.handler.handleTouchEnd, 1);
                this.jAddEvent("touchmove", M.Event.Custom.touchpinch.handler.handleTouchMove, 1)
            }, jRemove: function () {
                this.jRemoveEvent("touchstart", M.Event.Custom.touchpinch.handler.handleTouchStart);
                this.jRemoveEvent("touchend", M.Event.Custom.touchpinch.handler.handleTouchEnd);
                this.jRemoveEvent("touchmove", M.Event.Custom.touchpinch.handler.handleTouchMove)
            }, handleTouchStart: function (X) {
                var W;
                if (X.touches.length != 2) {
                    return
                }
                X.stopDefaults();
                W = new M.Event.Custom.touchpinch(this, X);
                this.jStore("event:touchpinch:event", W)
            }, handleTouchEnd: function (X) {
                var W;
                W = this.jFetch("event:touchpinch:event");
                if (!W) {
                    return
                }
                X.stopDefaults();
                this.jDel("event:touchpinch:event")
            }, handleTouchMove: function (X) {
                var W;
                W = this.jFetch("event:touchpinch:event");
                if (!W) {
                    return
                }
                X.stopDefaults();
                W.update(X);
                this.jCallEvent("touchpinch", W)
            }
        };
        (function (ab) {
            var Z = ab.$;
            ab.Event.Custom.mousescroll = new ab.Class(ab.extend(ab.Event.Custom, {
                type: "mousescroll",
                init: function (ah, ag, aj, ad, ac, ai, ae) {
                    var af = ag.jGetPageXY();
                    this.x = af.x;
                    this.y = af.y;
                    this.timeStamp = ag.timeStamp;
                    this.target = ah;
                    this.delta = aj || 0;
                    this.deltaX = ad || 0;
                    this.deltaY = ac || 0;
                    this.deltaZ = ai || 0;
                    this.deltaFactor = ae || 0;
                    this.deltaMode = ag.deltaMode || 0;
                    this.isMouse = false;
                    this.pushToEvents(ag)
                }
            }));
            var aa, X;

            function W() {
                aa = null
            }

            function Y(ac, ad) {
                return (ac > 50) || (1 === ad && !("win" == ab.jBrowser.platform && ac < 1)) || (0 === ac % 12) || (0 == ac % 4.000244140625)
            }

            ab.Event.Custom.mousescroll.handler = {
                eventType: "onwheel" in document || ab.jBrowser.ieMode > 8 ? "wheel" : "mousewheel",
                add: function () {
                    this.jAddEvent(ab.Event.Custom.mousescroll.handler.eventType, ab.Event.Custom.mousescroll.handler.handle, 1)
                },
                jRemove: function () {
                    this.jRemoveEvent(ab.Event.Custom.mousescroll.handler.eventType, ab.Event.Custom.mousescroll.handler.handle, 1)
                },
                handle: function (ah) {
                    var ai = 0, af = 0, ad = 0, ac = 0, ag, ae;
                    if (ah.detail) {
                        ad = ah.detail * -1
                    }
                    if (ah.wheelDelta !== undefined) {
                        ad = ah.wheelDelta
                    }
                    if (ah.wheelDeltaY !== undefined) {
                        ad = ah.wheelDeltaY
                    }
                    if (ah.wheelDeltaX !== undefined) {
                        af = ah.wheelDeltaX * -1
                    }
                    if (ah.deltaY) {
                        ad = -1 * ah.deltaY
                    }
                    if (ah.deltaX) {
                        af = ah.deltaX
                    }
                    if (0 === ad && 0 === af) {
                        return
                    }
                    ai = 0 === ad ? af : ad;
                    ac = Math.max(Math.abs(ad), Math.abs(af));
                    if (!aa || ac < aa) {
                        aa = ac
                    }
                    ag = ai > 0 ? "floor" : "ceil";
                    ai = Math[ag](ai / aa);
                    af = Math[ag](af / aa);
                    ad = Math[ag](ad / aa);
                    if (X) {
                        clearTimeout(X)
                    }
                    X = setTimeout(W, 200);
                    ae = new ab.Event.Custom.mousescroll(this, ah, ai, af, ad, 0, aa);
                    ae.isMouse = Y(aa, ah.deltaMode || 0);
                    this.jCallEvent("mousescroll", ae)
                }
            }
        })(S);
        M.win = M.$(window);
        M.doc = M.$(document);
        return S
    })();
    (function (I) {
        if (!I) {
            throw"MagicJS not found"
        }
        var H = I.$;
        var G = window.URL || window.webkitURL || null;
        w.ImageLoader = new I.Class({
            img: null,
            ready: false,
            options: {
                onprogress: I.$F,
                onload: I.$F,
                onabort: I.$F,
                onerror: I.$F,
                oncomplete: I.$F,
                onxhrerror: I.$F,
                xhr: false,
                progressiveLoad: true
            },
            size: null,
            _timer: null,
            loadedBytes: 0,
            _handlers: {
                onprogress: function (J) {
                    if (J.target && (200 === J.target.status || 304 === J.target.status) && J.lengthComputable) {
                        this.options.onprogress.jBind(null, (J.loaded - (this.options.progressiveLoad ? this.loadedBytes : 0)) / J.total).jDelay(1);
                        this.loadedBytes = J.loaded
                    }
                }, onload: function (J) {
                    if (J) {
                        H(J).stop()
                    }
                    this._unbind();
                    if (this.ready) {
                        return
                    }
                    this.ready = true;
                    this._cleanup();
                    !this.options.xhr && this.options.onprogress.jBind(null, 1).jDelay(1);
                    this.options.onload.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                }, onabort: function (J) {
                    if (J) {
                        H(J).stop()
                    }
                    this._unbind();
                    this.ready = false;
                    this._cleanup();
                    this.options.onabort.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                }, onerror: function (J) {
                    if (J) {
                        H(J).stop()
                    }
                    this._unbind();
                    this.ready = false;
                    this._cleanup();
                    this.options.onerror.jBind(null, this).jDelay(1);
                    this.options.oncomplete.jBind(null, this).jDelay(1)
                }
            },
            _bind: function () {
                H(["load", "abort", "error"]).jEach(function (J) {
                    this.img.jAddEvent(J, this._handlers["on" + J].jBindAsEvent(this).jDefer(1))
                }, this)
            },
            _unbind: function () {
                if (this._timer) {
                    try {
                        clearTimeout(this._timer)
                    } catch (J) {
                    }
                    this._timer = null
                }
                H(["load", "abort", "error"]).jEach(function (K) {
                    this.img.jRemoveEvent(K)
                }, this)
            },
            _cleanup: function () {
                this.jGetSize();
                if (this.img.jFetch("new")) {
                    var J = this.img.parentNode;
                    this.img.jRemove().jDel("new").jSetCss({position: "static", top: "auto"});
                    J.kill()
                }
            },
            loadBlob: function (K) {
                var L = new XMLHttpRequest(), J;
                H(["abort", "progress"]).jEach(function (M) {
                    L["on" + M] = H(function (N) {
                        this._handlers["on" + M].call(this, N)
                    }).jBind(this)
                }, this);
                L.onerror = H(function () {
                    this.options.onxhrerror.jBind(null, this).jDelay(1);
                    this.options.xhr = false;
                    this._bind();
                    this.img.src = K
                }).jBind(this);
                L.onload = H(function () {
                    if (200 !== L.status && 304 !== L.status) {
                        this._handlers.onerror.call(this);
                        return
                    }
                    J = L.response;
                    this._bind();
                    if (G && !I.jBrowser.trident && !("ios" === I.jBrowser.platform && I.jBrowser.version < 537)) {
                        this.img.setAttribute("src", G.createObjectURL(J))
                    } else {
                        this.img.src = K
                    }
                }).jBind(this);
                L.open("GET", K);
                L.responseType = "blob";
                L.send()
            },
            init: function (K, J) {
                this.options = I.extend(this.options, J);
                this.img = H(K) || I.$new("img", {}, {
                        "max-width": "none",
                        "max-height": "none"
                    }).jAppendTo(I.$new("div").jAddClass("magic-temporary-img").jSetCss({
                        position: "absolute",
                        top: -10000,
                        width: 10,
                        height: 10,
                        overflow: "hidden"
                    }).jAppendTo(document.body)).jStore("new", true);
                if (I.jBrowser.features.xhr2 && this.options.xhr && "string" == I.jTypeOf(K)) {
                    this.loadBlob(K);
                    return
                }
                var L = function () {
                    if (this.isReady()) {
                        this._handlers.onload.call(this)
                    } else {
                        this._handlers.onerror.call(this)
                    }
                    L = null
                }.jBind(this);
                this._bind();
                if ("string" == I.jTypeOf(K)) {
                    this.img.src = K
                } else {
                    if (I.jBrowser.trident && 5 == I.jBrowser.version && I.jBrowser.ieMode < 9) {
                        this.img.onreadystatechange = function () {
                            if (/loaded|complete/.test(this.img.readyState)) {
                                this.img.onreadystatechange = null;
                                L && L()
                            }
                        }.jBind(this)
                    }
                    this.img.src = K.getAttribute("src")
                }
                this.img && this.img.complete && L && (this._timer = L.jDelay(100))
            },
            destroy: function () {
                this._unbind();
                this._cleanup();
                this.ready = false;
                return this
            },
            isReady: function () {
                var J = this.img;
                return (J.naturalWidth) ? (J.naturalWidth > 0) : (J.readyState) ? ("complete" == J.readyState) : J.width > 0
            },
            jGetSize: function () {
                return this.size || (this.size = {
                        width: this.img.naturalWidth || this.img.width,
                        height: this.img.naturalHeight || this.img.height
                    })
            }
        })
    })(w);
    (function (H) {
        if (!H) {
            throw"MagicJS not found"
        }
        if (H.FX) {
            return
        }
        var G = H.$;
        H.FX = new H.Class({
            init: function (J, I) {
                var K;
                this.el = H.$(J);
                this.options = H.extend(this.options, I);
                this.timer = false;
                this.easeFn = this.cubicBezierAtTime;
                K = H.FX.Transition[this.options.transition] || this.options.transition;
                if ("function" === H.jTypeOf(K)) {
                    this.easeFn = K
                } else {
                    this.cubicBezier = this.parseCubicBezier(K) || this.parseCubicBezier("ease")
                }
                if ("string" == H.jTypeOf(this.options.cycles)) {
                    this.options.cycles = "infinite" === this.options.cycles ? Infinity : parseInt(this.options.cycles) || 1
                }
            },
            options: {
                fps: 60,
                duration: 600,
                transition: "ease",
                cycles: 1,
                direction: "normal",
                onStart: H.$F,
                onComplete: H.$F,
                onBeforeRender: H.$F,
                onAfterRender: H.$F,
                forceAnimation: false,
                roundCss: false
            },
            styles: null,
            cubicBezier: null,
            easeFn: null,
            setTransition: function (I) {
                this.options.transition = I;
                I = H.FX.Transition[this.options.transition] || this.options.transition;
                if ("function" === H.jTypeOf(I)) {
                    this.easeFn = I
                } else {
                    this.easeFn = this.cubicBezierAtTime;
                    this.cubicBezier = this.parseCubicBezier(I) || this.parseCubicBezier("ease")
                }
            },
            start: function (K) {
                var I = /\%$/, J;
                this.styles = K;
                this.cycle = 0;
                this.state = 0;
                this.curFrame = 0;
                this.pStyles = {};
                this.alternate = "alternate" === this.options.direction || "alternate-reverse" === this.options.direction;
                this.continuous = "continuous" === this.options.direction || "continuous-reverse" === this.options.direction;
                for (J in this.styles) {
                    I.test(this.styles[J][0]) && (this.pStyles[J] = true);
                    if ("reverse" === this.options.direction || "alternate-reverse" === this.options.direction || "continuous-reverse" === this.options.direction) {
                        this.styles[J].reverse()
                    }
                }
                this.startTime = H.now();
                this.finishTime = this.startTime + this.options.duration;
                this.options.onStart.call();
                if (0 === this.options.duration) {
                    this.render(1);
                    this.options.onComplete.call()
                } else {
                    this.loopBind = this.loop.jBind(this);
                    if (!this.options.forceAnimation && H.jBrowser.features.requestAnimationFrame) {
                        this.timer = H.jBrowser.requestAnimationFrame.call(window, this.loopBind)
                    } else {
                        this.timer = this.loopBind.interval(Math.round(1000 / this.options.fps))
                    }
                }
                return this
            },
            stopAnimation: function () {
                if (this.timer) {
                    if (!this.options.forceAnimation && H.jBrowser.features.requestAnimationFrame && H.jBrowser.cancelAnimationFrame) {
                        H.jBrowser.cancelAnimationFrame.call(window, this.timer)
                    } else {
                        clearInterval(this.timer)
                    }
                    this.timer = false
                }
            },
            stop: function (I) {
                I = H.defined(I) ? I : false;
                this.stopAnimation();
                if (I) {
                    this.render(1);
                    this.options.onComplete.jDelay(10)
                }
                return this
            },
            calc: function (K, J, I) {
                K = parseFloat(K);
                J = parseFloat(J);
                return (J - K) * I + K
            },
            loop: function () {
                var J = H.now(), I = (J - this.startTime) / this.options.duration, K = Math.floor(I);
                if (J >= this.finishTime && K >= this.options.cycles) {
                    this.stopAnimation();
                    this.render(1);
                    this.options.onComplete.jDelay(10);
                    return this
                }
                if (this.alternate && this.cycle < K) {
                    for (var L in this.styles) {
                        this.styles[L].reverse()
                    }
                }
                this.cycle = K;
                if (!this.options.forceAnimation && H.jBrowser.features.requestAnimationFrame) {
                    this.timer = H.jBrowser.requestAnimationFrame.call(window, this.loopBind)
                }
                this.render((this.continuous ? K : 0) + this.easeFn(I % 1))
            },
            render: function (I) {
                var J = {}, L = I;
                for (var K in this.styles) {
                    if ("opacity" === K) {
                        J[K] = Math.round(this.calc(this.styles[K][0], this.styles[K][1], I) * 100) / 100
                    } else {
                        J[K] = this.calc(this.styles[K][0], this.styles[K][1], I);
                        this.pStyles[K] && (J[K] += "%")
                    }
                }
                this.options.onBeforeRender(J, this.el);
                this.set(J);
                this.options.onAfterRender(J, this.el)
            },
            set: function (I) {
                return this.el.jSetCss(I)
            },
            parseCubicBezier: function (I) {
                var J, K = null;
                if ("string" !== H.jTypeOf(I)) {
                    return null
                }
                switch (I) {
                    case"linear":
                        K = G([0, 0, 1, 1]);
                        break;
                    case"ease":
                        K = G([0.25, 0.1, 0.25, 1]);
                        break;
                    case"ease-in":
                        K = G([0.42, 0, 1, 1]);
                        break;
                    case"ease-out":
                        K = G([0, 0, 0.58, 1]);
                        break;
                    case"ease-in-out":
                        K = G([0.42, 0, 0.58, 1]);
                        break;
                    case"easeInSine":
                        K = G([0.47, 0, 0.745, 0.715]);
                        break;
                    case"easeOutSine":
                        K = G([0.39, 0.575, 0.565, 1]);
                        break;
                    case"easeInOutSine":
                        K = G([0.445, 0.05, 0.55, 0.95]);
                        break;
                    case"easeInQuad":
                        K = G([0.55, 0.085, 0.68, 0.53]);
                        break;
                    case"easeOutQuad":
                        K = G([0.25, 0.46, 0.45, 0.94]);
                        break;
                    case"easeInOutQuad":
                        K = G([0.455, 0.03, 0.515, 0.955]);
                        break;
                    case"easeInCubic":
                        K = G([0.55, 0.055, 0.675, 0.19]);
                        break;
                    case"easeOutCubic":
                        K = G([0.215, 0.61, 0.355, 1]);
                        break;
                    case"easeInOutCubic":
                        K = G([0.645, 0.045, 0.355, 1]);
                        break;
                    case"easeInQuart":
                        K = G([0.895, 0.03, 0.685, 0.22]);
                        break;
                    case"easeOutQuart":
                        K = G([0.165, 0.84, 0.44, 1]);
                        break;
                    case"easeInOutQuart":
                        K = G([0.77, 0, 0.175, 1]);
                        break;
                    case"easeInQuint":
                        K = G([0.755, 0.05, 0.855, 0.06]);
                        break;
                    case"easeOutQuint":
                        K = G([0.23, 1, 0.32, 1]);
                        break;
                    case"easeInOutQuint":
                        K = G([0.86, 0, 0.07, 1]);
                        break;
                    case"easeInExpo":
                        K = G([0.95, 0.05, 0.795, 0.035]);
                        break;
                    case"easeOutExpo":
                        K = G([0.19, 1, 0.22, 1]);
                        break;
                    case"easeInOutExpo":
                        K = G([1, 0, 0, 1]);
                        break;
                    case"easeInCirc":
                        K = G([0.6, 0.04, 0.98, 0.335]);
                        break;
                    case"easeOutCirc":
                        K = G([0.075, 0.82, 0.165, 1]);
                        break;
                    case"easeInOutCirc":
                        K = G([0.785, 0.135, 0.15, 0.86]);
                        break;
                    case"easeInBack":
                        K = G([0.6, -0.28, 0.735, 0.045]);
                        break;
                    case"easeOutBack":
                        K = G([0.175, 0.885, 0.32, 1.275]);
                        break;
                    case"easeInOutBack":
                        K = G([0.68, -0.55, 0.265, 1.55]);
                        break;
                    default:
                        I = I.replace(/\s/g, "");
                        if (I.match(/^cubic-bezier\((?:-?[0-9\.]{0,}[0-9]{1,},){3}(?:-?[0-9\.]{0,}[0-9]{1,})\)$/)) {
                            K = I.replace(/^cubic-bezier\s*\(|\)$/g, "").split(",");
                            for (J = K.length - 1; J >= 0; J--) {
                                K[J] = parseFloat(K[J])
                            }
                        }
                }
                return G(K)
            },
            cubicBezierAtTime: function (U) {
                var I = 0, T = 0, Q = 0, V = 0, S = 0, O = 0, P = this.options.duration;

                function N(W) {
                    return ((I * W + T) * W + Q) * W
                }

                function M(W) {
                    return ((V * W + S) * W + O) * W
                }

                function K(W) {
                    return (3 * I * W + 2 * T) * W + Q
                }

                function R(W) {
                    return 1 / (200 * W)
                }

                function J(W, X) {
                    return M(L(W, X))
                }

                function L(ad, ae) {
                    var ac, ab, aa, X, W, Z;

                    function Y(af) {
                        if (af >= 0) {
                            return af
                        } else {
                            return 0 - af
                        }
                    }

                    for (aa = ad, Z = 0; Z < 8; Z++) {
                        X = N(aa) - ad;
                        if (Y(X) < ae) {
                            return aa
                        }
                        W = K(aa);
                        if (Y(W) < 0.000001) {
                            break
                        }
                        aa = aa - X / W
                    }
                    ac = 0;
                    ab = 1;
                    aa = ad;
                    if (aa < ac) {
                        return ac
                    }
                    if (aa > ab) {
                        return ab
                    }
                    while (ac < ab) {
                        X = N(aa);
                        if (Y(X - ad) < ae) {
                            return aa
                        }
                        if (ad > X) {
                            ac = aa
                        } else {
                            ab = aa
                        }
                        aa = (ab - ac) * 0.5 + ac
                    }
                    return aa
                }

                Q = 3 * this.cubicBezier[0];
                T = 3 * (this.cubicBezier[2] - this.cubicBezier[0]) - Q;
                I = 1 - Q - T;
                O = 3 * this.cubicBezier[1];
                S = 3 * (this.cubicBezier[3] - this.cubicBezier[1]) - O;
                V = 1 - O - S;
                return J(U, R(P))
            }
        });
        H.FX.Transition = {
            linear: "linear",
            sineIn: "easeInSine",
            sineOut: "easeOutSine",
            expoIn: "easeInExpo",
            expoOut: "easeOutExpo",
            quadIn: "easeInQuad",
            quadOut: "easeOutQuad",
            cubicIn: "easeInCubic",
            cubicOut: "easeOutCubic",
            backIn: "easeInBack",
            backOut: "easeOutBack",
            elasticIn: function (J, I) {
                I = I || [];
                return Math.pow(2, 10 * --J) * Math.cos(20 * J * Math.PI * (I[0] || 1) / 3)
            },
            elasticOut: function (J, I) {
                return 1 - H.FX.Transition.elasticIn(1 - J, I)
            },
            bounceIn: function (K) {
                for (var J = 0, I = 1; 1; J += I, I /= 2) {
                    if (K >= (7 - 4 * J) / 11) {
                        return I * I - Math.pow((11 - 6 * J - 11 * K) / 4, 2)
                    }
                }
            },
            bounceOut: function (I) {
                return 1 - H.FX.Transition.bounceIn(1 - I)
            },
            none: function (I) {
                return 0
            }
        }
    })(w);
    (function (H) {
        if (!H) {
            throw"MagicJS not found"
        }
        if (H.PFX) {
            return
        }
        var G = H.$;
        H.PFX = new H.Class(H.FX, {
            init: function (I, J) {
                this.el_arr = I;
                this.options = H.extend(this.options, J);
                this.timer = false;
                this.$parent.init()
            }, start: function (M) {
                var I = /\%$/, L, K, J = M.length;
                this.styles_arr = M;
                this.pStyles_arr = new Array(J);
                for (K = 0; K < J; K++) {
                    this.pStyles_arr[K] = {};
                    for (L in M[K]) {
                        I.test(M[K][L][0]) && (this.pStyles_arr[K][L] = true);
                        if ("reverse" === this.options.direction || "alternate-reverse" === this.options.direction || "continuous-reverse" === this.options.direction) {
                            this.styles_arr[K][L].reverse()
                        }
                    }
                }
                this.$parent.start([]);
                return this
            }, render: function (I) {
                for (var J = 0; J < this.el_arr.length; J++) {
                    this.el = H.$(this.el_arr[J]);
                    this.styles = this.styles_arr[J];
                    this.pStyles = this.pStyles_arr[J];
                    this.$parent.render(I)
                }
            }
        })
    })(w);
    (function (H) {
        if (!H) {
            throw"MagicJS not found";
            return
        }
        if (H.Tooltip) {
            return
        }
        var G = H.$;
        H.Tooltip = function (J, K) {
            var I = this.tooltip = H.$new("div", null, {
                position: "absolute",
                "z-index": 999
            }).jAddClass("MagicToolboxTooltip");
            H.$(J).jAddEvent("mouseover", function () {
                I.jAppendTo(document.body)
            });
            H.$(J).jAddEvent("mouseout", function () {
                I.jRemove()
            });
            H.$(J).jAddEvent("mousemove", function (P) {
                var R = 20, O = H.$(P).jGetPageXY(), N = I.jGetSize(), M = H.$(window).jGetSize(), Q = H.$(window).jGetScroll();

                function L(U, S, T) {
                    return (T < (U - S) / 2) ? T : ((T > (U + S) / 2) ? (T - S) : (U - S) / 2)
                }

                I.jSetCss({
                    left: Q.x + L(M.width, N.width + 2 * R, O.x - Q.x) + R,
                    top: Q.y + L(M.height, N.height + 2 * R, O.y - Q.y) + R
                })
            });
            this.text(K)
        };
        H.Tooltip.prototype.text = function (I) {
            this.tooltip.firstChild && this.tooltip.removeChild(this.tooltip.firstChild);
            this.tooltip.append(document.createTextNode(I))
        }
    })(w);
    (function (H) {
        if (!H) {
            throw"MagicJS not found";
            return
        }
        if (H.MessageBox) {
            return
        }
        var G = H.$;
        H.Message = function (L, K, J, I) {
            this.hideTimer = null;
            this.messageBox = H.$new("span", null, {
                position: "absolute",
                "z-index": 999,
                visibility: "hidden",
                opacity: 0.8
            }).jAddClass(I || "").jAppendTo(J || document.body);
            this.setMessage(L);
            this.show(K)
        };
        H.Message.prototype.show = function (I) {
            this.messageBox.show();
            this.hideTimer = this.hide.jBind(this).jDelay(H.ifndef(I, 5000))
        };
        H.Message.prototype.hide = function (I) {
            clearTimeout(this.hideTimer);
            this.hideTimer = null;
            if (this.messageBox && !this.hideFX) {
                this.hideFX = new w.FX(this.messageBox, {
                    duration: H.ifndef(I, 500), onComplete: function () {
                        this.messageBox.kill();
                        delete this.messageBox;
                        this.hideFX = null
                    }.jBind(this)
                }).start({opacity: [this.messageBox.jGetCss("opacity"), 0]})
            }
        };
        H.Message.prototype.setMessage = function (I) {
            this.messageBox.firstChild && this.tooltip.removeChild(this.messageBox.firstChild);
            this.messageBox.append(document.createTextNode(I))
        }
    })(w);
    (function (H) {
        if (!H) {
            throw"MagicJS not found"
        }
        if (H.Options) {
            return
        }
        var K = H.$, G = null, O = {
            "boolean": 1,
            array: 2,
            number: 3,
            "function": 4,
            string: 100
        }, I = {
            "boolean": function (R, Q, P) {
                if ("boolean" != H.jTypeOf(Q)) {
                    if (P || "string" != H.jTypeOf(Q)) {
                        return false
                    } else {
                        if (!/^(true|false)$/.test(Q)) {
                            return false
                        } else {
                            Q = Q.jToBool()
                        }
                    }
                }
                if (R.hasOwnProperty("enum") && !K(R["enum"]).contains(Q)) {
                    return false
                }
                G = Q;
                return true
            }, string: function (R, Q, P) {
                if ("string" !== H.jTypeOf(Q)) {
                    return false
                } else {
                    if (R.hasOwnProperty("enum") && !K(R["enum"]).contains(Q)) {
                        return false
                    } else {
                        G = "" + Q;
                        return true
                    }
                }
            }, number: function (S, R, Q) {
                var P = false, U = /%$/, T = (H.jTypeOf(R) == "string" && U.test(R));
                if (Q && !"number" == typeof R) {
                    return false
                }
                R = parseFloat(R);
                if (isNaN(R)) {
                    return false
                }
                if (isNaN(S.minimum)) {
                    S.minimum = Number.NEGATIVE_INFINITY
                }
                if (isNaN(S.maximum)) {
                    S.maximum = Number.POSITIVE_INFINITY
                }
                if (S.hasOwnProperty("enum") && !K(S["enum"]).contains(R)) {
                    return false
                }
                if (S.minimum > R || R > S.maximum) {
                    return false
                }
                G = T ? (R + "%") : R;
                return true
            }, array: function (S, Q, P) {
                if ("string" === H.jTypeOf(Q)) {
                    try {
                        Q = window.JSON.parse(Q)
                    } catch (R) {
                        return false
                    }
                }
                if (H.jTypeOf(Q) === "array") {
                    G = Q;
                    return true
                } else {
                    return false
                }
            }, "function": function (R, Q, P) {
                if (H.jTypeOf(Q) === "function") {
                    G = Q;
                    return true
                } else {
                    return false
                }
            }
        }, J = function (U, T, Q) {
            var S;
            S = U.hasOwnProperty("oneOf") ? U.oneOf : [U];
            if ("array" != H.jTypeOf(S)) {
                return false
            }
            for (var R = 0, P = S.length - 1; R <= P; R++) {
                if (I[S[R].type](S[R], T, Q)) {
                    return true
                }
            }
            return false
        }, M = function (U) {
            var S, R, T, P, Q;
            if (U.hasOwnProperty("oneOf")) {
                P = U.oneOf.length;
                for (S = 0; S < P; S++) {
                    for (R = S + 1; R < P; R++) {
                        if (O[U.oneOf[S]["type"]] > O[U.oneOf[R].type]) {
                            Q = U.oneOf[S];
                            U.oneOf[S] = U.oneOf[R];
                            U.oneOf[R] = Q
                        }
                    }
                }
            }
            return U
        }, N = function (S) {
            var R;
            R = S.hasOwnProperty("oneOf") ? S.oneOf : [S];
            if ("array" != H.jTypeOf(R)) {
                return false
            }
            for (var Q = R.length - 1; Q >= 0; Q--) {
                if (!R[Q].type || !O.hasOwnProperty(R[Q].type)) {
                    return false
                }
                if (H.defined(R[Q]["enum"])) {
                    if ("array" !== H.jTypeOf(R[Q]["enum"])) {
                        return false
                    }
                    for (var P = R[Q]["enum"].length - 1; P >= 0; P--) {
                        if (!I[R[Q].type]({type: R[Q].type}, R[Q]["enum"][P], true)) {
                            return false
                        }
                    }
                }
            }
            if (S.hasOwnProperty("default") && !J(S, S["default"], true)) {
                return false
            }
            return true
        }, L = function (P) {
            this.schema = {};
            this.options = {};
            this.parseSchema(P)
        };
        H.extend(L.prototype, {
            parseSchema: function (R) {
                var Q, P, S;
                for (Q in R) {
                    if (!R.hasOwnProperty(Q)) {
                        continue
                    }
                    P = (Q + "").jTrim().jCamelize();
                    if (!this.schema.hasOwnProperty(P)) {
                        this.schema[P] = M(R[Q]);
                        if (!N(this.schema[P])) {
                            throw"Incorrect definition of the '" + Q + "' parameter in " + R
                        }
                        this.options[P] = undefined
                    }
                }
            }, set: function (Q, P) {
                Q = (Q + "").jTrim().jCamelize();
                if (H.jTypeOf(P) == "string") {
                    P = P.jTrim()
                }
                if (this.schema.hasOwnProperty(Q)) {
                    G = P;
                    if (J(this.schema[Q], P)) {
                        this.options[Q] = G
                    }
                    G = null
                }
            }, get: function (P) {
                P = (P + "").jTrim().jCamelize();
                if (this.schema.hasOwnProperty(P)) {
                    return H.defined(this.options[P]) ? this.options[P] : this.schema[P]["default"]
                }
            }, fromJSON: function (Q) {
                for (var P in Q) {
                    this.set(P, Q[P])
                }
            }, getJSON: function () {
                var Q = H.extend({}, this.options);
                for (var P in Q) {
                    if (undefined === Q[P] && undefined !== this.schema[P]["default"]) {
                        Q[P] = this.schema[P]["default"]
                    }
                }
                return Q
            }, fromString: function (P) {
                K(P.split(";")).jEach(K(function (Q) {
                    Q = Q.split(":");
                    this.set(Q.shift().jTrim(), Q.join(":"))
                }).jBind(this))
            }, exists: function (P) {
                P = (P + "").jTrim().jCamelize();
                return this.schema.hasOwnProperty(P)
            }, isset: function (P) {
                P = (P + "").jTrim().jCamelize();
                return this.exists(P) && H.defined(this.options[P])
            }, jRemove: function (P) {
                P = (P + "").jTrim().jCamelize();
                if (this.exists(P)) {
                    delete this.options[P];
                    delete this.schema[P]
                }
            }
        });
        H.Options = L
    }(w));
    (function (K) {
        if (!K) {
            throw"MagicJS not found";
            return
        }
        var J = K.$;
        if (K.SVGImage) {
            return
        }
        var I = "http://www.w3.org/2000/svg", H = "http://www.w3.org/1999/xlink";
        var G = function (L) {
            this.filters = {};
            this.originalImage = J(L);
            this.canvas = J(document.createElementNS(I, "svg"));
            this.canvas.setAttribute("width", this.originalImage.naturalWidth || this.originalImage.width);
            this.canvas.setAttribute("height", this.originalImage.naturalHeight || this.originalImage.height);
            this.image = J(document.createElementNS(I, "image"));
            this.image.setAttributeNS(H, "href", this.originalImage.getAttribute("src"));
            this.image.setAttribute("width", "100%");
            this.image.setAttribute("height", "100%");
            this.image.jAppendTo(this.canvas)
        };
        G.prototype.getNode = function () {
            return this.canvas
        };
        G.prototype.blur = function (L) {
            if (Math.round(L) < 1) {
                return
            }
            if (!this.filters.blur) {
                this.filters.blur = J(document.createElementNS(I, "filter"));
                this.filters.blur.setAttribute("id", "filterBlur");
                this.filters.blur.appendChild(J(document.createElementNS(I, "feGaussianBlur")).setProps({
                    "in": "SourceGraphic",
                    stdDeviation: L
                }));
                this.filters.blur.jAppendTo(this.canvas);
                this.image.setAttribute("filter", "url(#filterBlur)")
            } else {
                this.filters.blur.firstChild.setAttribute("stdDeviation", L)
            }
            return this
        };
        K.SVGImage = G
    }(w));
    var r = (function (I) {
        var H = I.$;
        var G = function (K, J) {
            this.settings = {
                cssPrefix: "magic",
                orientation: "horizontal",
                position: "bottom",
                size: {units: "px", width: "auto", height: "auto"},
                sides: ["height", "width"]
            };
            this.parent = K;
            this.root = null;
            this.wrapper = null;
            this.context = null;
            this.buttons = {};
            this.items = [];
            this.selectedItem = null;
            this.scrollFX = null;
            this.resizeCallback = null;
            this.settings = I.extend(this.settings, J);
            this.rootCSS = this.settings.cssPrefix + "-thumbs";
            this.itemCSS = this.settings.cssPrefix + "-thumb";
            this.setupContent()
        };
        G.prototype = {
            setupContent: function () {
                this.root = I.$new("div").jAddClass(this.rootCSS).jAddClass(this.rootCSS + "-" + this.settings.orientation).jSetCss({visibility: "hidden"});
                this.wrapper = I.$new("div").jAddClass(this.rootCSS + "-wrapper").jAppendTo(this.root);
                this.root.jAppendTo(this.parent);
                H(["prev", "next"]).jEach(function (J) {
                    this.buttons[J] = I.$new("button").jAddClass(this.rootCSS + "-button").jAddClass(this.rootCSS + "-button-" + J).jAppendTo(this.root).jAddEvent("btnclick tap", (function (L, K) {
                        H(L).events[0].stop().stopQueue();
                        H(L).stopDistribution();
                        this.scroll(K)
                    }).jBindAsEvent(this, J))
                }.jBind(this));
                this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled");
                this.context = I.$new("ul").jAddEvent("btnclick tap", function (J) {
                    J.stop()
                })
            }, addItem: function (K) {
                var J = I.$new("li").jAddClass(this.itemCSS).append(K).jAppendTo(this.context);
                new I.ImageLoader(K, {oncomplete: this.reflow.jBind(this)});
                this.items.push(J);
                return J
            }, selectItem: function (K) {
                var J = this.selectedItem || this.context.byClass(this.itemCSS + "-selected")[0];
                if (J) {
                    H(J).jRemoveClass(this.itemCSS + "-selected")
                }
                this.selectedItem = H(K);
                if (!this.selectedItem) {
                    return
                }
                this.selectedItem.jAddClass(this.itemCSS + "-selected");
                this.scroll(this.selectedItem)
            }, run: function () {
                if (this.wrapper !== this.context.parentNode) {
                    H(this.context).jAppendTo(this.wrapper);
                    this.initDrag();
                    H(window).jAddEvent("resize", this.resizeCallback = this.reflow.jBind(this));
                    this.run.jBind(this).jDelay(1);
                    return
                }
                var J = this.parent.jGetSize();
                if (J.height > 0 && J.height > J.width) {
                    this.setOrientation("vertical")
                } else {
                    this.setOrientation("horizontal")
                }
                this.reflow();
                this.root.jSetCss({visibility: ""})
            }, stop: function () {
                if (this.resizeCallback) {
                    H(window).jRemoveEvent("resize", this.resizeCallback)
                }
                this.root.kill()
            }, scroll: function (W, M) {
                var O = {
                    x: 0,
                    y: 0
                }, Z = "vertical" == this.settings.orientation ? "top" : "left", R = "vertical" == this.settings.orientation ? "height" : "width", N = "vertical" == this.settings.orientation ? "y" : "x", V = this.context.parentNode.jGetSize()[R], S = this.context.parentNode.jGetPosition(), L = this.context.jGetSize()[R], U, J, Y, P, K, T, Q, X = [];
                if (this.scrollFX) {
                    this.scrollFX.stop()
                } else {
                    this.context.jSetCss("transition", I.jBrowser.cssTransformProp + String.fromCharCode(32) + "0s")
                }
                if (undefined === M) {
                    M = 600
                }
                U = this.context.jGetPosition();
                if ("string" == I.jTypeOf(W)) {
                    O[N] = ("next" == W) ? Math.max(U[Z] - S[Z] - V, V - L) : Math.min(U[Z] - S[Z] + V, 0)
                } else {
                    if ("element" == I.jTypeOf(W)) {
                        J = W.jGetSize();
                        Y = W.jGetPosition();
                        O[N] = Math.min(0, Math.max(V - L, U[Z] + V / 2 - Y[Z] - J[R] / 2))
                    } else {
                        return
                    }
                }
                if (I.jBrowser.gecko && "android" == I.jBrowser.platform || I.jBrowser.ieMode && I.jBrowser.ieMode < 10) {
                    if ("string" == I.jTypeOf(W) && O[N] == U[Z] - S[Z]) {
                        U[Z] += 0 === U[Z] - S[Z] ? 30 : -30
                    }
                    O["margin-" + Z] = [((L <= V) ? 0 : (U[Z] - S[Z])), O[N]];
                    delete O.x;
                    delete O.y;
                    if (!this.selectorsMoveFX) {
                        this.selectorsMoveFX = new I.PFX([this.context], {duration: 500})
                    }
                    X.push(O);
                    this.selectorsMoveFX.start(X);
                    Q = O["margin-" + Z][1]
                } else {
                    this.context.jSetCss({
                        transition: I.jBrowser.cssTransformProp + String.fromCharCode(32) + M + "ms ease",
                        transform: "translate3d(" + O.x + "px, " + O.y + "px, 0)"
                    });
                    Q = O[N]
                }
                if (Q >= 0) {
                    this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled")
                } else {
                    this.buttons.prev.jRemoveClass(this.rootCSS + "-button-disabled")
                }
                if (Q <= V - L) {
                    this.buttons.next.jAddClass(this.rootCSS + "-button-disabled")
                } else {
                    this.buttons.next.jRemoveClass(this.rootCSS + "-button-disabled")
                }
                Q = null
            }, initDrag: function () {
                var L, K, M, T, S, V, N, R, Q, U, aa, X, Y, W = {x: 0, y: 0}, J, P, O = 300, Z = function (ad) {
                    var ac, ab = 0;
                    for (ac = 1.5; ac <= 90; ac += 1.5) {
                        ab += (ad * Math.cos(ac / Math.PI / 2))
                    }
                    (T < 0) && (ab *= (-1));
                    return ab
                };
                S = H(function (ab) {
                    W = {x: 0, y: 0};
                    J = "vertical" == this.settings.orientation ? "top" : "left";
                    P = "vertical" == this.settings.orientation ? "height" : "width";
                    L = "vertical" == this.settings.orientation ? "y" : "x";
                    X = this.context.parentNode.jGetSize()[P];
                    aa = this.context.jGetSize()[P];
                    M = X - aa;
                    if (M >= 0) {
                        return
                    }
                    if (ab.state == "dragstart") {
                        if (undefined === Y) {
                            Y = 0
                        }
                        this.context.jSetCssProp("transition", I.jBrowser.cssTransformProp + String.fromCharCode(32) + "0ms");
                        V = ab[L];
                        Q = ab.y;
                        R = ab.x;
                        U = false
                    } else {
                        if ("dragend" == ab.state) {
                            if (U) {
                                return
                            }
                            N = Z(Math.abs(T));
                            Y += N;
                            (Y <= M) && (Y = M);
                            (Y >= 0) && (Y = 0);
                            W[L] = Y;
                            this.context.jSetCssProp("transition", I.jBrowser.cssTransformProp + String.fromCharCode(32) + O + "ms  cubic-bezier(.0, .0, .0, 1)");
                            this.context.jSetCssProp("transform", "translate3d(" + W.x + "px, " + W.y + "px, 0px)");
                            T = 0
                        } else {
                            if (U) {
                                return
                            }
                            if ("horizontal" == this.settings.orientation && Math.abs(ab.x - R) > Math.abs(ab.y - Q) || "vertical" == this.settings.orientation && Math.abs(ab.x - R) < Math.abs(ab.y - Q)) {
                                ab.stop();
                                T = ab[L] - V;
                                Y += T;
                                W[L] = Y;
                                this.context.jSetCssProp("transform", "translate3d(" + W.x + "px, " + W.y + "px, 0px)");
                                if (Y >= 0) {
                                    this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled")
                                } else {
                                    this.buttons.prev.jRemoveClass(this.rootCSS + "-button-disabled")
                                }
                                if (Y <= M) {
                                    this.buttons.next.jAddClass(this.rootCSS + "-button-disabled")
                                } else {
                                    this.buttons.next.jRemoveClass(this.rootCSS + "-button-disabled")
                                }
                            } else {
                                U = true
                            }
                        }
                        V = ab[L]
                    }
                }).jBind(this);
                this.context.jAddEvent("touchdrag", S)
            }, reflow: function () {
                var M, L, J, K = this.parent.jGetSize();
                if (K.height > 0 && K.height > K.width) {
                    this.setOrientation("vertical")
                } else {
                    this.setOrientation("horizontal")
                }
                M = "vertical" == this.settings.orientation ? "height" : "width";
                L = this.context.jGetSize()[M];
                J = this.root.jGetSize()[M];
                if (L <= J) {
                    this.root.jAddClass("no-buttons");
                    this.context.jSetCssProp("transition", "").jGetSize();
                    this.context.jSetCssProp("transform", "translate3d(0,0,0)");
                    this.buttons.prev.jAddClass(this.rootCSS + "-button-disabled");
                    this.buttons.next.jRemoveClass(this.rootCSS + "-button-disabled")
                } else {
                    this.root.jRemoveClass("no-buttons")
                }
                if (this.selectedItem) {
                    this.scroll(this.selectedItem, 0)
                }
            }, setOrientation: function (J) {
                if ("vertical" !== J && "horizontal" !== J || J == this.settings.orientation) {
                    return
                }
                this.root.jRemoveClass(this.rootCSS + "-" + this.settings.orientation);
                this.settings.orientation = J;
                this.root.jAddClass(this.rootCSS + "-" + this.settings.orientation);
                this.context.jSetCssProp("transition", "none").jGetSize();
                this.context.jSetCssProp("transform", "").jSetCssProp("margin", "")
            }
        };
        return G
    })(w);
    var h = y.$;
    if (!y.jBrowser.cssTransform) {
        y.jBrowser.cssTransform = y.normalizeCSS("transform").dashize()
    }
    var o = {
        zoomOn: {type: "string", "enum": ["click", "hover"], "default": "hover"},
        zoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "preview", "off"],
                "default": "zoom"
            }, {type: "boolean", "enum": [false]}], "default": "zoom"
        },
        zoomWidth: {oneOf: [{type: "string", "enum": ["auto"]}, {type: "number", minimum: 1}], "default": "auto"},
        zoomHeight: {oneOf: [{type: "string", "enum": ["auto"]}, {type: "number", minimum: 1}], "default": "auto"},
        zoomPosition: {type: "string", "default": "right"},
        zoomDistance: {type: "number", minimum: 0, "default": 15},
        zoomCaption: {
            oneOf: [{type: "string", "enum": ["bottom", "top", "off"], "default": "off"}, {
                type: "boolean",
                "enum": [false]
            }], "default": "off"
        },
        expand: {
            oneOf: [{type: "string", "enum": ["window", "fullscreen", "off"]}, {type: "boolean", "enum": [false]}],
            "default": "window"
        },
        expandZoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "off"],
                "default": "zoom"
            }, {type: "boolean", "enum": [false]}], "default": "zoom"
        },
        expandZoomOn: {type: "string", "enum": ["click", "always"], "default": "click"},
        expandCaption: {type: "boolean", "default": true},
        closeOnClickOutside: {type: "boolean", "default": true},
        hint: {
            oneOf: [{type: "string", "enum": ["once", "always", "off"]}, {type: "boolean", "enum": [false]}],
            "default": "once"
        },
        smoothing: {type: "boolean", "default": true},
        upscale: {type: "boolean", "default": true},
        variableZoom: {type: "boolean", "default": false},
        lazyZoom: {type: "boolean", "default": false},
        autostart: {type: "boolean", "default": true},
        rightClick: {type: "boolean", "default": false},
        transitionEffect: {type: "boolean", "default": true},
        selectorTrigger: {type: "string", "enum": ["click", "hover"], "default": "click"},
        cssClass: {type: "string"},
        textHoverZoomHint: {type: "string", "default": "Hover to zoom"},
        textClickZoomHint: {type: "string", "default": "Click to zoom"},
        textExpandHint: {type: "string", "default": "Click to expand"},
        textBtnClose: {type: "string", "default": "Close"},
        textBtnNext: {type: "string", "default": "Next"},
        textBtnPrev: {type: "string", "default": "Previous"}
    };
    var l = {
        zoomMode: {
            oneOf: [{
                type: "string",
                "enum": ["zoom", "magnifier", "off"],
                "default": "zoom"
            }, {type: "boolean", "enum": [false]}], "default": "zoom"
        },
        expandZoomOn: {type: "string", "enum": ["click"], "default": "click"},
        textExpandHint: {type: "string", "default": "Tap to expand"},
        textHoverZoomHint: {type: "string", "default": "Touch to zoom"},
        textClickZoomHint: {type: "string", "default": "Double tap to zoom"}
    };
    var n = "MagicZoom", B = "mz", b = 20, z = ["onZoomReady", "onUpdate", "onZoomIn", "onZoomOut", "onExpandOpen", "onExpandClose"];
    var t, p = {}, D = h([]), F, e = window.devicePixelRatio || 1, E, x = true, f = y.jBrowser.features.perspective ? "translate3d(" : "translate(", A = y.jBrowser.features.perspective ? ",0)" : ")", m = null;

    function v(I) {
        var H, G;
        H = "";
        for (G = 0; G < I.length; G++) {
            H += String.fromCharCode(14 ^ I.charCodeAt(G))
        }
        return H
    }

    function i(I) {
        var H = [], G = null;
        (I && (G = h(I))) && (H = D.filter(function (J) {
            return J.placeholder === G
        }));
        return H.length ? H[0] : null
    }

    function a(I) {
        var H = h(window).jGetSize(), G = h(window).jGetScroll();
        I = I || 0;
        return {left: I, right: H.width - I, top: I, bottom: H.height - I, x: G.x, y: G.y}
    }

    function c(G) {
        return (G.pointerType && ("touch" === G.pointerType || G.pointerType === G.MSPOINTER_TYPE_TOUCH)) || (/touch/i).test(G.type)
    }

    function g(G) {
        return G.pointerType ? (("touch" === G.pointerType || G.MSPOINTER_TYPE_TOUCH === G.pointerType) && G.isPrimary) : 1 === G.changedTouches.length && (G.targetTouches.length ? G.targetTouches[0].identifier == G.changedTouches[0].identifier : true)
    }

    function s() {
        var I = y.$A(arguments), H = I.shift(), G = p[H];
        if (G) {
            for (var J = 0; J < G.length; J++) {
                G[J].apply(null, I)
            }
        }
    }

    function C() {
        var K = arguments[0], G, J, H = [];
        try {
            do {
                J = K.tagName;
                if (/^[A-Za-z]*$/.test(J)) {
                    if (G = K.getAttribute("id")) {
                        if (/^[A-Za-z][-A-Za-z0-9_]*/.test(G)) {
                            J += "#" + G
                        }
                    }
                    H.push(J)
                }
                K = K.parentNode
            } while (K && K !== document.documentElement);
            H = H.reverse();
            y.addCSS(H.join(" ") + "> .mz-figure > img", {width: "100% !important;"}, "mz-runtime-css", true)
        } catch (I) {
        }
    }

    function u() {
        var H = null, I = null, G = function () {
            window.scrollTo(document.body.scrollLeft, document.body.scrollTop);
            window.dispatchEvent(new Event("resize"))
        };
        I = setInterval(function () {
            var L = window.orientation == 90 || window.orientation == -90, K = window.innerHeight, J = (L ? screen.availWidth : screen.availHeight) * 0.85;
            if ((H == null || H == false) && ((L && K < J) || (!L && K < J))) {
                H = true;
                G()
            } else {
                if ((H == null || H == true) && ((L && K > J) || (!L && K > J))) {
                    H = false;
                    G()
                }
            }
        }, 250);
        return I
    }

    function d() {
        y.addCSS(".magic-hidden-wrapper, .magic-temporary-img", {
            display: "block !important",
            "min-height": "0 !important",
            "min-width": "0 !important",
            "max-height": "none !important",
            "max-width": "none !important",
            width: "10px !important",
            height: "10px !important",
            position: "absolute !important",
            top: "-10000px !important",
            left: "0 !important",
            overflow: "hidden !important",
            "-webkit-transform": "none !important",
            transform: "none !important",
            "-webkit-transition": "none !important",
            transition: "none !important"
        }, "magiczoom-reset-css");
        y.addCSS(".magic-temporary-img img", {
            display: "inline-block !important",
            border: "0 !important",
            padding: "0 !important",
            "min-height": "0 !important",
            "min-width": "0 !important",
            "max-height": "none !important",
            "max-width": "none !important",
            "-webkit-transform": "none !important",
            transform: "none !important",
            "-webkit-transition": "none !important",
            transition: "none !important"
        }, "magiczoom-reset-css");
        if (y.jBrowser.androidBrowser) {
            y.addCSS(".mobile-magic .mz-expand .mz-expand-bg", {display: "none !important"}, "magiczoom-reset-css")
        }
        if (y.jBrowser.androidBrowser && ("chrome" !== y.jBrowser.uaName || 44 == y.jBrowser.uaVersion)) {
            y.addCSS(".mobile-magic .mz-zoom-window.mz-magnifier, .mobile-magic .mz-zoom-window.mz-magnifier:before", {"border-radius": "0 !important"}, "magiczoom-reset-css")
        }
    }

    var k = function (J, K, H, I, G) {
        this.small = {src: null, url: null, dppx: 1, node: null, state: 0, size: {width: 0, height: 0}, loaded: false};
        this.zoom = {src: null, url: null, dppx: 1, node: null, state: 0, size: {width: 0, height: 0}, loaded: false};
        if ("object" == y.jTypeOf(J)) {
            this.small = J
        } else {
            if ("string" == y.jTypeOf(J)) {
                this.small.url = y.getAbsoluteURL(J)
            }
        }
        if ("object" == y.jTypeOf(K)) {
            this.zoom = K
        } else {
            if ("string" == y.jTypeOf(K)) {
                this.zoom.url = y.getAbsoluteURL(K)
            }
        }
        this.caption = H;
        this.options = I;
        this.origin = G;
        this.callback = null;
        this.link = null;
        this.node = null
    };
    k.prototype = {
        parseNode: function (I, H, G) {
            var J = I.byTag("img")[0];
            if (G) {
                this.small.node = J || y.$new("img").jAppendTo(I)
            }
            if (e > 1) {
                this.small.url = I.getAttribute("data-image-2x");
                if (this.small.url) {
                    this.small.dppx = 2
                }
                this.zoom.url = I.getAttribute("data-zoom-image-2x");
                if (this.zoom.url) {
                    this.zoom.dppx = 2
                }
            }
            this.small.src = I.getAttribute("data-image") || I.getAttribute("rev") || (J ? J.getAttribute("src") : null);
            if (this.small.src) {
                this.small.src = y.getAbsoluteURL(this.small.src)
            }
            this.small.url = this.small.url || this.small.src;
            if (this.small.url) {
                this.small.url = y.getAbsoluteURL(this.small.url)
            }
            this.zoom.src = I.getAttribute("data-zoom-image") || I.getAttribute("href");
            if (this.zoom.src) {
                this.zoom.src = y.getAbsoluteURL(this.zoom.src)
            }
            this.zoom.url = this.zoom.url || this.zoom.src;
            if (this.zoom.url) {
                this.zoom.url = y.getAbsoluteURL(this.zoom.url)
            }
            this.caption = I.getAttribute("data-caption") || I.getAttribute("title") || H;
            this.link = I.getAttribute("data-link");
            this.origin = I;
            return this
        }, loadImg: function (G) {
            var H = null;
            if (arguments.length > 1 && "function" === y.jTypeOf(arguments[1])) {
                H = arguments[1]
            }
            if (0 !== this[G].state) {
                if (this[G].loaded) {
                    this.onload(H)
                }
                return
            }
            if (this[G].url && this[G].node && !this[G].node.getAttribute("src") && !this[G].node.getAttribute("srcset")) {
                this[G].node.setAttribute("src", this[G].url)
            }
            this[G].state = 1;
            new y.ImageLoader(this[G].node || this[G].url, {
                oncomplete: h(function (I) {
                    this[G].loaded = true;
                    this[G].state = I.ready ? 2 : -1;
                    if (I.ready) {
                        this[G].size = I.jGetSize();
                        if (!this[G].node) {
                            this[G].node = h(I.img);
                            this[G].node.getAttribute("style");
                            this[G].node.removeAttribute("style");
                            this[G].size.width /= this[G].dppx;
                            this[G].size.height /= this[G].dppx
                        } else {
                            this[G].node.jSetCss({"max-width": this[G].size.width, "max-height": this[G].size.height});
                            if (this[G].node.currentSrc && this[G].node.currentSrc != this[G].node.src) {
                                this[G].url = this[G].node.currentSrc
                            } else {
                                if (y.getAbsoluteURL(this[G].node.getAttribute("src") || "") != this[G].url) {
                                    this[G].node.setAttribute("src", this[G].url)
                                }
                            }
                        }
                    }
                    this.onload(H)
                }).jBind(this)
            })
        }, loadSmall: function () {
            this.loadImg("small", arguments[0])
        }, loadZoom: function () {
            this.loadImg("zoom", arguments[0])
        }, load: function () {
            this.callback = null;
            if (arguments.length > 0 && "function" === y.jTypeOf(arguments[0])) {
                this.callback = arguments[0]
            }
            this.loadSmall();
            this.loadZoom()
        }, onload: function (G) {
            if (G) {
                G.call(null, this)
            }
            if (this.callback && this.small.loaded && this.zoom.loaded) {
                this.callback.call(null, this);
                this.callback = null;
                return
            }
        }, loaded: function () {
            return (this.small.loaded && this.zoom.loaded)
        }, ready: function () {
            return (2 === this.small.state && 2 === this.zoom.state)
        }, getURL: function (H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].url
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].url
                } else {
                    return null
                }
            }
        }, getNode: function (H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].node
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].node
                } else {
                    return null
                }
            }
        }, jGetSize: function (H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].size
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].size
                } else {
                    return {width: 0, height: 0}
                }
            }
        }, getRatio: function (H) {
            var G = "small" == H ? "zoom" : "small";
            if (!this[H].loaded || (this[H].loaded && 2 === this[H].state)) {
                return this[H].dppx
            } else {
                if (!this[G].loaded || (this[G].loaded && 2 === this[G].state)) {
                    return this[G].dppx
                } else {
                    return 1
                }
            }
        }, setCurNode: function (G) {
            this.node = this.getNode(G)
        }
    };
    var j = function (H, G) {
        this.options = new y.Options(o);
        this.option = h(function () {
            if (arguments.length > 1) {
                return this.set(arguments[0], arguments[1])
            } else {
                return this.get(arguments[0])
            }
        }).jBind(this.options);
        this.touchOptions = new y.Options(l);
        this.additionalImages = [];
        this.image = null;
        this.primaryImage = null;
        this.placeholder = h(H).jAddEvent("dragstart selectstart click", function (I) {
            I.stop()
        });
        this.id = null;
        this.node = null;
        this.originalImg = null;
        this.originalImgSrc = null;
        this.originalTitle = null;
        this.normalSize = {width: 0, height: 0};
        this.size = {width: 0, height: 0};
        this.zoomSize = {width: 0, height: 0};
        this.zoomSizeOrigin = {width: 0, height: 0};
        this.boundaries = {top: 0, left: 0, bottom: 0, right: 0};
        this.ready = false;
        this.expanded = false;
        this.activateTimer = null;
        this.resizeTimer = null;
        this.resizeCallback = h(function () {
            if (this.expanded) {
                this.image.node.jSetCss({"max-height": Math.min(this.image.jGetSize("zoom").height, this.expandMaxHeight())});
                this.image.node.jSetCss({"max-width": Math.min(this.image.jGetSize("zoom").width, this.expandMaxWidth())})
            }
            this.reflowZoom(arguments[0])
        }).jBind(this);
        this.onResize = h(function (I) {
            clearTimeout(this.resizeTimer);
            this.resizeTimer = h(this.resizeCallback).jDelay(10, "scroll" === I.type)
        }).jBindAsEvent(this);
        this.lens = null;
        this.zoomBox = null;
        this.hint = null;
        this.hintMessage = null;
        this.hintRuns = 0;
        this.mobileZoomHint = true;
        this.loadingBox = null;
        this.loadTimer = null;
        this.thumb = null;
        this.expandBox = null;
        this.expandBg = null;
        this.expandCaption = null;
        this.expandStage = null;
        this.expandImageStage = null;
        this.expandFigure = null;
        this.expandControls = null;
        this.expandNav = null;
        this.expandThumbs = null;
        this.expandGallery = [];
        this.buttons = {};
        this.start(G)
    };
    j.prototype = {
        loadOptions: function (G) {
            this.options.fromJSON(window[B + "Options"] || {});
            this.options.fromString(this.placeholder.getAttribute("data-options") || "");
            if (y.jBrowser.mobile) {
                this.options.fromJSON(this.touchOptions.getJSON());
                this.options.fromJSON(window[B + "MobileOptions"] || {});
                this.options.fromString(this.placeholder.getAttribute("data-mobile-options") || "")
            }
            if ("string" == y.jTypeOf(G)) {
                this.options.fromString(G || "")
            } else {
                this.options.fromJSON(G || {})
            }
            if (this.option("cssClass")) {
                this.option("cssClass", this.option("cssClass").replace(",", " "))
            }
            if (false === this.option("zoomCaption")) {
                this.option("zoomCaption", "off")
            }
            if (false === this.option("hint")) {
                this.option("hint", "off")
            }
            switch (this.option("hint")) {
                case"off":
                    this.hintRuns = 0;
                    break;
                case"once":
                    this.hintRuns = 2;
                    break;
                case"always":
                    this.hintRuns = Infinity;
                    break
            }
            if ("off" === this.option("zoomMode")) {
                this.option("zoomMode", false)
            }
            if ("off" === this.option("expand")) {
                this.option("expand", false)
            }
            if ("off" === this.option("expandZoomMode")) {
                this.option("expandZoomMode", false)
            }
            if (y.jBrowser.mobile && "zoom" == this.option("zoomMode") && "inner" == this.option("zoomPosition")) {
                if (this.option("expand")) {
                    this.option("zoomMode", false)
                } else {
                    this.option("zoomOn", "click")
                }
            }
        }, start: function (H) {
            var G;
            this.loadOptions(H);
            if (x && !this.option("autostart")) {
                return
            }
            this.id = this.placeholder.getAttribute("id") || "mz-" + Math.floor(Math.random() * y.now());
            this.placeholder.setAttribute("id", this.id);
            this.node = y.$new("figure").jAddClass("mz-figure");
            C(this.placeholder);
            this.originalImg = this.placeholder.querySelector("img");
            this.originalImgSrc = this.originalImg ? this.originalImg.getAttribute("src") : null;
            this.originalTitle = h(this.placeholder).getAttribute("title");
            h(this.placeholder).removeAttribute("title");
            this.primaryImage = new k().parseNode(this.placeholder, this.originalTitle, true);
            this.image = this.primaryImage;
            this.node.enclose(this.image.small.node).jAddClass(this.option("cssClass"));
            if (true !== this.option("rightClick")) {
                this.node.jAddEvent("contextmenu", function (J) {
                    J.stop();
                    return false
                })
            }
            this.node.jAddClass("mz-" + this.option("zoomOn") + "-zoom");
            if (!this.option("expand")) {
                this.node.jAddClass("mz-no-expand")
            }
            this.lens = {
                node: y.$new("div", {"class": "mz-lens"}, {top: 0}).jAppendTo(this.node),
                image: y.$new("img", {src: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="}, {
                    position: "absolute",
                    top: 0,
                    left: 0
                }),
                width: 0,
                height: 0,
                pos: {x: 0, y: 0},
                spos: {x: 0, y: 0},
                size: {width: 0, height: 0},
                border: {x: 0, y: 0},
                dx: 0,
                dy: 0,
                innertouch: false,
                hide: function () {
                    if (y.jBrowser.features.transform) {
                        this.node.jSetCss({transform: "translate(-10000px,-10000px)"})
                    } else {
                        this.node.jSetCss({top: -10000})
                    }
                }
            };
            this.lens.hide();
            this.lens.node.append(this.lens.image);
            this.zoomBox = {
                node: y.$new("div", {"class": "mz-zoom-window"}, {top: -100000}).jAddClass(this.option("cssClass")).jAppendTo(F),
                image: y.$new("img", {src: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="}, {position: "absolute"}),
                aspectRatio: 0,
                width: 0,
                height: 0,
                innerWidth: 0,
                innerHeight: 0,
                size: {width: "auto", wunits: "px", height: "auto", hunits: "px"},
                mode: this.option("zoomMode"),
                position: this.option("zoomPosition"),
                trigger: this.option("zoomOn"),
                custom: false,
                active: false,
                activating: false,
                enabled: false,
                enable: h(function () {
                    this.zoomBox.enabled = false !== arguments[0];
                    this.node[this.zoomBox.enabled ? "jRemoveClass" : "jAddClass"]("mz-no-zoom")
                }).jBind(this),
                hide: h(function () {
                    var J = h(this.node).jFetch("cr");
                    this.zoomBox.node.jRemoveEvent("transitionend");
                    this.zoomBox.node.jSetCss({top: -100000}).jAppendTo(F);
                    this.zoomBox.node.jRemoveClass("mz-deactivating mz-p-" + ("zoom" == this.zoomBox.mode ? this.zoomBox.position : this.zoomBox.mode));
                    if (!this.expanded && J) {
                        J.jRemove()
                    }
                    this.zoomBox.image.getAttribute("style");
                    this.zoomBox.image.removeAttribute("style")
                }).jBind(this),
                setMode: h(function (J) {
                    this.node[false === J ? "jAddClass" : "jRemoveClass"]("mz-no-zoom");
                    this.node["magnifier" == J ? "jAddClass" : "jRemoveClass"]("mz-magnifier-zoom");
                    this.zoomBox.node["magnifier" == J ? "jAddClass" : "jRemoveClass"]("mz-magnifier");
                    this.zoomBox.node["preview" == J ? "jAddClass" : "jRemoveClass"]("mz-preview");
                    if ("zoom" != J) {
                        this.node.jRemoveClass("mz-inner-zoom");
                        this.zoomBox.node.jRemoveClass("mz-inner")
                    }
                    this.zoomBox.mode = J;
                    if (false === J) {
                        this.zoomBox.enable(false)
                    } else {
                        if ("preview" === J) {
                            this.zoomBox.enable(true)
                        }
                    }
                }).jBind(this)
            };
            this.zoomBox.node.append(this.zoomBox.image);
            this.zoomBox.setMode(this.option("zoomMode"));
            this.zoomBox.image.removeAttribute("width");
            this.zoomBox.image.removeAttribute("height");
            if ("undefined" !== typeof(q)) {
                var I = Math.floor(Math.random() * y.now());
                h(this.node).jStore("cr", y.$new(((Math.floor(Math.random() * 101) + 1) % 2) ? "span" : "div").setProps({id: "crMz" + I}).jSetCss({
                    display: "inline",
                    overflow: "hidden",
                    visibility: "visible",
                    color: q[1],
                    fontSize: q[2],
                    fontWeight: q[3],
                    fontFamily: "sans-serif",
                    position: "absolute",
                    top: 8,
                    left: 8,
                    margin: "auto",
                    width: "auto",
                    textAlign: "right",
                    "line-height": "2em",
                    zIndex: 2147483647
                }).changeContent(v(q[0])));
                if (h(h(this.node).jFetch("cr")).byTag("a")[0]) {
                    h(h(h(this.node).jFetch("cr")).byTag("a")[0]).jAddEvent("tap btnclick", function (J) {
                        J.stopDistribution();
                        window.open(this.href)
                    }).setProps({id: "mzCrA" + I})
                }
                y.addCSS("#" + this.id + " > figure.mz-figure > #" + ("crMz" + I) + ",#" + this.id + " > figure.mz-figure > #" + ("crMz" + I) + " > #" + ("mzCrA" + I) + ",html body .mz-expand > #" + ("crMz" + I) + " > #" + ("mzCrA" + I) + ",html body .mz-expand > #" + ("crMz" + I) + " > #" + ("mzCrA" + I), {
                    display: "inline !important;",
                    visibility: "visible !important;",
                    zIndex: "2147483647 !important;",
                    fontSize: q[2] + " !important;",
                    color: q[1] + " !important;"
                }, "mz-runtime-css", true)
            }
            if ((G = ("" + this.option("zoomWidth")).match(/^([0-9]+)?(px|%)?$/))) {
                this.zoomBox.size.wunits = G[2] || "px";
                this.zoomBox.size.width = (parseFloat(G[1]) || "auto")
            }
            if ((G = ("" + this.option("zoomHeight")).match(/^([0-9]+)?(px|%)?$/))) {
                this.zoomBox.size.hunits = G[2] || "px";
                this.zoomBox.size.height = (parseFloat(G[1]) || "auto")
            }
            if ("magnifier" == this.zoomBox.mode) {
                this.node.jAddClass("mz-magnifier-zoom");
                this.zoomBox.node.jAddClass("mz-magnifier");
                if ("auto" === this.zoomBox.size.width) {
                    this.zoomBox.size.wunits = "%";
                    this.zoomBox.size.width = 70
                }
                if ("auto" === this.zoomBox.size.height) {
                    this.zoomBox.size.hunits = "%"
                }
            } else {
                if (this.option("zoom-position").match(/^#/)) {
                    if (this.zoomBox.custom = h(this.option("zoom-position").replace(/^#/, ""))) {
                        if (h(this.zoomBox.custom).jGetSize().height > 50) {
                            if ("auto" === this.zoomBox.size.width) {
                                this.zoomBox.size.wunits = "%";
                                this.zoomBox.size.width = 100
                            }
                            if ("auto" === this.zoomBox.size.height) {
                                this.zoomBox.size.hunits = "%";
                                this.zoomBox.size.height = 100
                            }
                        }
                    } else {
                        this.option("zoom-position", "right")
                    }
                }
                if ("preview" == this.zoomBox.mode) {
                    if ("auto" === this.zoomBox.size.width) {
                        this.zoomBox.size.wunits = "px"
                    }
                    if ("auto" === this.zoomBox.size.height) {
                        this.zoomBox.size.hunits = "px"
                    }
                }
                if ("zoom" == this.zoomBox.mode) {
                    if ("auto" === this.zoomBox.size.width || "inner" == this.option("zoom-position")) {
                        this.zoomBox.size.wunits = "%";
                        this.zoomBox.size.width = 100
                    }
                    if ("auto" === this.zoomBox.size.height || "inner" == this.option("zoom-position")) {
                        this.zoomBox.size.hunits = "%";
                        this.zoomBox.size.height = 100
                    }
                }
                if ("inner" == this.option("zoom-position")) {
                    this.node.jAddClass("mz-inner-zoom")
                }
            }
            this.zoomBox.position = this.zoomBox.custom ? "custom" : this.option("zoom-position");
            this.lens.border.x = parseFloat(this.lens.node.jGetCss("border-left-width") || "0");
            this.lens.border.y = parseFloat(this.lens.node.jGetCss("border-top-width") || "0");
            this.image.loadSmall(function () {
                if (2 !== this.image.small.state) {
                    return
                }
                this.image.setCurNode("small");
                this.size = this.image.node.jGetSize();
                this.registerEvents();
                this.ready = true;
                if (true === this.option("lazyZoom")) {
                    this.showHint()
                }
            }.jBind(this));
            if (true !== this.option("lazyZoom") || "always" == this.option("zoomOn")) {
                this.image.load(h(function (J) {
                    this.setupZoom(J, true)
                }).jBind(this));
                this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
            }
            this.setupSelectors()
        }, stop: function () {
            this.unregisterEvents();
            if (this.zoomBox) {
                this.zoomBox.node.kill()
            }
            if (this.expandThumbs) {
                this.expandThumbs.stop();
                this.expandThumbs = null
            }
            if (this.expandBox) {
                this.expandBox.kill()
            }
            if (this.expanded) {
                h(y.jBrowser.getDoc()).jSetCss({overflow: ""})
            }
            h(this.additionalImages).jEach(function (G) {
                h(G.origin).jRemoveClass("mz-thumb-selected").jRemoveClass(this.option("cssClass") || "mz-$dummy-css-class-to-jRemove$")
            }, this);
            if (this.originalImg) {
                this.placeholder.append(this.originalImg);
                if (this.originalImgSrc) {
                    this.originalImg.setAttribute("src", this.originalImgSrc)
                }
            }
            if (this.originalTitle) {
                this.placeholder.setAttribute("title", this.originalTitle)
            }
            if (this.node) {
                this.node.kill()
            }
        }, setupZoom: function (I, J) {
            var H = this.initEvent, G = this.image;
            this.initEvent = null;
            if (2 !== I.zoom.state) {
                this.image = I;
                this.ready = true;
                this.zoomBox.enable(false);
                return
            }
            this.image = I;
            this.image.setCurNode(this.expanded ? "zoom" : "small");
            this.zoomBox.image.src = this.image.getURL("zoom");
            this.zoomBox.node.jRemoveClass("mz-preview");
            this.zoomBox.image.getAttribute("style");
            this.zoomBox.image.removeAttribute("style");
            this.zoomBox.node.jGetSize();
            setTimeout(h(function () {
                var L = this.zoomBox.image.jGetSize(), K;
                this.zoomSizeOrigin = this.image.jGetSize("zoom");
                if (L.width * L.height > 1 && L.width * L.height < this.zoomSizeOrigin.width * this.zoomSizeOrigin.height) {
                    this.zoomSizeOrigin = L
                }
                this.zoomSize = y.detach(this.zoomSizeOrigin);
                if ("preview" == this.zoomBox.mode) {
                    this.zoomBox.node.jAddClass("mz-preview")
                }
                this.setCaption();
                this.lens.image.src = this.image.node.currentSrc || this.image.node.src;
                this.zoomBox.enable(this.zoomBox.mode && !(this.expanded && "preview" == this.zoomBox.mode));
                this.ready = true;
                this.activateTimer = null;
                this.resizeCallback();
                this.node.jAddClass("mz-ready");
                this.hideLoading();
                if (G !== this.image) {
                    s("onUpdate", this.id, G.origin, this.image.origin);
                    if (this.nextImage) {
                        K = this.nextImage;
                        this.nextImage = null;
                        this.update(K.image, K.onswipe)
                    }
                } else {
                    s("onZoomReady", this.id)
                }
                if (H) {
                    this.node.jCallEvent(H.type, H)
                } else {
                    if (this.expanded && "always" == this.option("expandZoomOn")) {
                        this.activate()
                    } else {
                        if (!!J) {
                            this.showHint()
                        }
                    }
                }
            }).jBind(this), 256)
        }, setupSelectors: function () {
            var H = this.id, G, I;
            I = new RegExp("zoom\\-id(\\s+)?:(\\s+)?" + H + "($|;)");
            if (y.jBrowser.features.query) {
                G = y.$A(document.querySelectorAll('[data-zoom-id="' + this.id + '"]'));
                G = h(G).concat(y.$A(document.querySelectorAll('[rel*="zoom-id"]')).filter(function (J) {
                    return I.test(J.getAttribute("rel") || "")
                }))
            } else {
                G = y.$A(document.getElementsByTagName("A")).filter(function (J) {
                    return H == J.getAttribute("data-zoom-id") || I.test(J.getAttribute("rel") || "")
                })
            }
            h(G).jEach(function (K) {
                var J, L;
                h(K).jAddEvent("click", function (M) {
                    M.stopDefaults()
                });
                J = new k().parseNode(K, this.originalTitle);
                if (this.image.zoom.src.has(J.zoom.src) && this.image.small.src.has(J.small.src)) {
                    h(J.origin).jAddClass("mz-thumb-selected");
                    J = this.image;
                    J.origin = K
                }
                if (!J.link && this.image.link) {
                    J.link = this.image.link
                }
                L = h(function () {
                    this.update(J)
                }).jBind(this);
                h(K).jAddEvent("mousedown", function (M) {
                    if ("stopImmediatePropagation" in M) {
                        M.stopImmediatePropagation()
                    }
                }, 5);
                h(K).jAddEvent("tap " + ("hover" == this.option("selectorTrigger") ? "mouseover mouseout" : "btnclick"), h(function (N, M) {
                    if (this.updateTimer) {
                        clearTimeout(this.updateTimer)
                    }
                    this.updateTimer = false;
                    if ("mouseover" == N.type) {
                        this.updateTimer = h(L).jDelay(M)
                    } else {
                        if ("tap" == N.type || "btnclick" == N.type) {
                            L()
                        }
                    }
                }).jBindAsEvent(this, 60)).jAddClass(this.option("cssClass")).jAddClass("mz-thumb");
                J.loadSmall();
                if (true !== this.option("lazyZoom")) {
                    J.loadZoom()
                }
                this.additionalImages.push(J)
            }, this)
        }, update: function (G, H) {
            if (!this.ready) {
                this.nextImage = {image: G, onswipe: H};
                return
            }
            if (!G || G === this.image) {
                return false
            }
            this.deactivate(null, true);
            this.ready = false;
            this.node.jRemoveClass("mz-ready");
            this.loadTimer = h(this.showLoading).jBind(this).jDelay(400);
            G.load(h(function (O) {
                var I, P, N, K, J, M, L = (y.jBrowser.ieMode < 10) ? "jGetSize" : "getBoundingClientRect";
                this.hideLoading();
                O.setCurNode("small");
                if (!O.node) {
                    this.ready = true;
                    this.node.jAddClass("mz-ready");
                    return
                }
                this.setActiveThumb(O);
                I = this.image.node[L]();
                if (this.expanded) {
                    O.setCurNode("zoom");
                    N = y.$new("div").jAddClass("mz-expand-bg");
                    if (y.jBrowser.features.cssFilters || y.jBrowser.ieMode < 10) {
                        N.append(y.$new("img", {src: O.getURL("zoom")}).jSetCss({opacity: 0}))
                    } else {
                        N.append(new y.SVGImage(O.node).blur(b).getNode().jSetCss({opacity: 0}))
                    }
                    h(N).jSetCss({"z-index": -99}).jAppendTo(this.expandBox)
                }
                if (this.expanded && "zoom" === this.zoomBox.mode && "always" === this.option("expandZoomOn")) {
                    h(O.node).jSetCss({opacity: 0}).jAppendTo(this.node);
                    P = I;
                    J = [O.node, this.image.node];
                    M = [{opacity: [0, 1]}, {opacity: [1, 0]}];
                    h(O.node).jSetCss({
                        "max-width": Math.min(O.jGetSize("zoom").width, this.expandMaxWidth()),
                        "max-height": Math.min(O.jGetSize("zoom").height, this.expandMaxHeight())
                    })
                } else {
                    this.node.jSetCss({height: this.node[L]().height});
                    this.image.node.jSetCss({
                        position: "absolute",
                        top: 0,
                        left: 0,
                        bottom: 0,
                        right: 0,
                        width: "100%",
                        height: "100%",
                        "max-width": "",
                        "max-height": ""
                    });
                    h(O.node).jSetCss({
                        "max-width": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").width, this.expanded ? this.expandMaxWidth() : Infinity),
                        "max-height": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").height, this.expanded ? this.expandMaxHeight() : Infinity),
                        position: "relative",
                        top: 0,
                        left: 0,
                        opacity: 0,
                        transform: ""
                    }).jAppendTo(this.node);
                    P = h(O.node)[L]();
                    if (!H) {
                        h(O.node).jSetCss({
                            "min-width": I.width,
                            height: I.height,
                            "max-width": I.width,
                            "max-height": ""
                        })
                    }
                    this.node.jSetCss({height: "", overflow: ""}).jGetSize();
                    h(O.node).jGetSize();
                    J = [O.node, this.image.node];
                    M = [y.extend({opacity: [0, 1]}, H ? {scale: [0.6, 1]} : {
                            "min-width": [I.width, P.width],
                            "max-width": [I.width, P.width],
                            height: [I.height, P.height]
                        }), {opacity: [1, 0]}]
                }
                if (this.expanded) {
                    if (this.expandBg.firstChild && N.firstChild) {
                        K = h(this.expandBg.firstChild).jGetCss("opacity");
                        if (y.jBrowser.gecko) {
                            J = J.concat([N.firstChild]);
                            M = M.concat([{opacity: [0.0001, K]}])
                        } else {
                            J = J.concat([N.firstChild, this.expandBg.firstChild]);
                            M = M.concat([{opacity: [0.0001, K]}, {opacity: [K, 0.0001]}])
                        }
                    }
                }
                new y.PFX(J, {
                    duration: (H || this.option("transitionEffect")) ? H ? 400 : 350 : 0,
                    transition: H ? "cubic-bezier(0.175, 0.885, 0.320, 1.275)" : (I.width == P.width) ? "linear" : "cubic-bezier(0.25, .1, .1, 1)",
                    onComplete: h(function () {
                        this.image.node.jRemove().getAttribute("style");
                        this.image.node.removeAttribute("style");
                        h(O.node).jSetCss(this.expanded ? {width: "auto", height: "auto"} : {
                                width: "",
                                height: ""
                            }).jSetCss({
                            "min-width": "",
                            "min-height": "",
                            opacity: "",
                            "max-width": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").width, this.expanded ? this.expandMaxWidth() : Infinity),
                            "max-height": Math.min(O.jGetSize(this.expanded ? "zoom" : "small").height, this.expanded ? this.expandMaxHeight() : Infinity)
                        });
                        if (this.expanded) {
                            this.expandBg.jRemove();
                            this.expandBg = undefined;
                            this.expandBg = N.jSetCssProp("z-index", -100);
                            h(this.expandBg.firstChild).jSetCss({opacity: ""});
                            if (this.expandCaption) {
                                if (O.caption) {
                                    if (O.link) {
                                        this.expandCaption.changeContent("").append(y.$new("a", {href: O.link}).jAddEvent("tap btnclick", this.openLink.jBind(this)).changeContent(O.caption))
                                    } else {
                                        this.expandCaption.changeContent(O.caption).jAddClass("mz-show")
                                    }
                                } else {
                                    this.expandCaption.jRemoveClass("mz-show")
                                }
                            }
                        }
                        this.setupZoom(O)
                    }).jBind(this),
                    onBeforeRender: h(function (Q, R) {
                        if (undefined !== Q.scale) {
                            R.jSetCssProp("transform", "scale(" + Q.scale + ")")
                        }
                    })
                }).start(M)
            }).jBind(this))
        }, setActiveThumb: function (H) {
            var G = false;
            h(this.additionalImages).jEach(function (I) {
                h(I.origin).jRemoveClass("mz-thumb-selected");
                if (I === H) {
                    G = true
                }
            });
            if (G && H.origin) {
                h(H.origin).jAddClass("mz-thumb-selected")
            }
            if (this.expandThumbs) {
                this.expandThumbs.selectItem(H.selector)
            }
        }, setCaption: function (G) {
            if (this.image.caption && "off" !== this.option("zoomCaption") && "magnifier" !== this.zoomBox.mode) {
                if (!this.zoomBox.caption) {
                    this.zoomBox.caption = y.$new("div", {"class": "mz-caption"}).jAppendTo(this.zoomBox.node.jAddClass("caption-" + this.option("zoomCaption")))
                }
                this.zoomBox.caption.changeContent(this.image.caption)
            }
        }, showHint: function (G, J, H) {
            var I;
            if (!this.expanded) {
                if (this.hintRuns <= 0) {
                    return
                }
                if (true !== H) {
                    this.hintRuns--
                }
            }
            if (undefined === J || null === J) {
                if (!this.zoomBox.active && !this.zoomBox.activating) {
                    if (this.option("zoomMode") && this.zoomBox.enabled) {
                        if ("hover" == this.zoomBox.trigger) {
                            J = this.option("textHoverZoomHint")
                        } else {
                            if ("click" == this.zoomBox.trigger) {
                                J = this.option("textClickZoomHint")
                            }
                        }
                    } else {
                        J = this.option("expand") ? this.option("textExpandHint") : ""
                    }
                } else {
                    J = this.option("expand") ? this.option("textExpandHint") : ""
                }
            }
            if (!J) {
                this.hideHint();
                return
            }
            I = this.node;
            if (!this.hint) {
                this.hint = y.$new("div", {"class": "mz-hint"});
                this.hintMessage = y.$new("span", {"class": "mz-hint-message"}).append(document.createTextNode(J)).jAppendTo(this.hint);
                h(this.hint).jAppendTo(this.node)
            } else {
                h(this.hintMessage).changeContent(J)
            }
            this.hint.jSetCss({"transition-delay": ""}).jRemoveClass("mz-hint-hidden");
            if (this.expanded) {
                I = this.expandFigure
            } else {
                if ((this.zoomBox.active || this.zoomBox.activating) && "magnifier" !== this.zoomBox.mode && "inner" == this.zoomBox.position) {
                    I = this.zoomBox.node
                }
            }
            if (true === G) {
                setTimeout(h(function () {
                    this.hint.jAddClass("mz-hint-hidden")
                }).jBind(this), 16)
            }
            this.hint.jAppendTo(I)
        }, hideHint: function () {
            if (this.hint) {
                this.hint.jSetCss({"transition-delay": "0ms"}).jAddClass("mz-hint-hidden")
            }
        }, showLoading: function () {
            if (!this.loadingBox) {
                this.loadingBox = y.$new("div", {"class": "mz-loading"});
                this.node.append(this.loadingBox);
                this.loadingBox.jGetSize()
            }
            this.loadingBox.jAddClass("shown")
        }, hideLoading: function () {
            clearTimeout(this.loadTimer);
            this.loadTimer = null;
            if (this.loadingBox) {
                h(this.loadingBox).jRemoveClass("shown")
            }
        }, setSize: function (I, M) {
            var L = y.detach(this.zoomBox.size), K = (!this.expanded && this.zoomBox.custom) ? h(this.zoomBox.custom).jGetSize() : {
                    width: 0,
                    height: 0
                }, H, G, J = this.size, N = {x: 0, y: 0};
            M = M || this.zoomBox.position;
            this.normalSize = this.image.node.jGetSize();
            this.size = this.image.node.jGetSize();
            this.boundaries = this.image.node.getBoundingClientRect();
            if (!K.height) {
                K = this.size
            }
            if (false === this.option("upscale") || false === this.zoomBox.mode || "preview" === this.zoomBox.mode) {
                I = false
            }
            if ("preview" == this.zoomBox.mode) {
                if ("auto" === L.width) {
                    L.width = this.zoomSizeOrigin.width
                }
                if ("auto" === L.height) {
                    L.height = this.zoomSizeOrigin.height
                }
            }
            if (this.expanded && "magnifier" == this.zoomBox.mode) {
                L.width = 70;
                L.height = "auto"
            }
            if ("magnifier" == this.zoomBox.mode && "auto" === L.height) {
                this.zoomBox.width = parseFloat(L.width / 100) * Math.min(K.width, K.height);
                this.zoomBox.height = this.zoomBox.width
            } else {
                if ("zoom" == this.zoomBox.mode && "inner" == M) {
                    this.size = this.node.jGetSize();
                    K = this.size;
                    this.boundaries = this.node.getBoundingClientRect();
                    this.zoomBox.width = K.width;
                    this.zoomBox.height = K.height
                } else {
                    this.zoomBox.width = ("%" === L.wunits) ? parseFloat(L.width / 100) * K.width : parseInt(L.width);
                    this.zoomBox.height = ("%" === L.hunits) ? parseFloat(L.height / 100) * K.height : parseInt(L.height)
                }
            }
            if ("preview" == this.zoomBox.mode) {
                G = Math.min(Math.min(this.zoomBox.width / this.zoomSizeOrigin.width, this.zoomBox.height / this.zoomSizeOrigin.height), 1);
                this.zoomBox.width = this.zoomSizeOrigin.width * G;
                this.zoomBox.height = this.zoomSizeOrigin.height * G
            }
            this.zoomBox.width = Math.ceil(this.zoomBox.width);
            this.zoomBox.height = Math.ceil(this.zoomBox.height);
            this.zoomBox.aspectRatio = this.zoomBox.width / this.zoomBox.height;
            this.zoomBox.node.jSetCss({width: this.zoomBox.width, height: this.zoomBox.height});
            if (I) {
                K = this.expanded ? this.expandBox.jGetSize() : this.zoomBox.node.jGetSize();
                if (!this.expanded && (this.normalSize.width * this.normalSize.height) / (this.zoomSizeOrigin.width * this.zoomSizeOrigin.height) > 0.8) {
                    this.zoomSize.width = 1.5 * this.zoomSizeOrigin.width;
                    this.zoomSize.height = 1.5 * this.zoomSizeOrigin.height
                } else {
                    this.zoomSize = y.detach(this.zoomSizeOrigin)
                }
            }
            if (false !== this.zoomBox.mode && !this.zoomBox.active && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ((this.normalSize.width * this.normalSize.height) / (this.zoomSize.width * this.zoomSize.height) > 0.8) {
                    this.zoomSize = y.detach(this.zoomSizeOrigin);
                    this.zoomBox.enable(false)
                } else {
                    this.zoomBox.enable(true)
                }
            }
            this.zoomBox.image.jSetCss({width: this.zoomSize.width, height: this.zoomSize.height});
            H = this.zoomBox.node.getInnerSize();
            this.zoomBox.innerWidth = Math.ceil(H.width);
            this.zoomBox.innerHeight = Math.ceil(H.height);
            this.lens.width = Math.ceil(this.zoomBox.innerWidth / (this.zoomSize.width / this.size.width));
            this.lens.height = Math.ceil(this.zoomBox.innerHeight / (this.zoomSize.height / this.size.height));
            this.lens.node.jSetCss({width: this.lens.width, height: this.lens.height});
            this.lens.image.jSetCss(this.size);
            y.extend(this.lens, this.lens.node.jGetSize());
            if (this.zoomBox.active) {
                clearTimeout(this.moveTimer);
                this.moveTimer = null;
                if (this.lens.innertouch) {
                    this.lens.pos.x *= (this.size.width / J.width);
                    this.lens.pos.y *= (this.size.height / J.height);
                    N.x = this.lens.spos.x;
                    N.y = this.lens.spos.y
                } else {
                    N.x = this.boundaries.left + this.lens.width / 2 + (this.lens.pos.x * (this.size.width / J.width));
                    N.y = this.boundaries.top + this.lens.height / 2 + (this.lens.pos.y * (this.size.height / J.height))
                }
                this.animate(null, N)
            }
        }, reflowZoom: function (K) {
            var N, M, G, L, J, I, H = h(this.node).jFetch("cr");
            G = a(5);
            J = this.zoomBox.position;
            L = this.expanded ? "inner" : this.zoomBox.custom ? "custom" : this.option("zoom-position");
            I = this.expanded && "zoom" == this.zoomBox.mode ? this.expandBox : document.body;
            if (this.expanded) {
                G.y = 0;
                G.x = 0
            }
            if (!K) {
                this.setSize(true, L)
            }
            N = this.boundaries.top;
            if ("magnifier" !== this.zoomBox.mode) {
                if (K) {
                    this.setSize(false);
                    return
                }
                switch (L) {
                    case"inner":
                    case"custom":
                        N = 0;
                        M = 0;
                        break;
                    case"top":
                        N = this.boundaries.top - this.zoomBox.height - this.option("zoom-distance");
                        if (G.top > N) {
                            N = this.boundaries.bottom + this.option("zoom-distance");
                            L = "bottom"
                        }
                        M = this.boundaries.left;
                        break;
                    case"bottom":
                        N = this.boundaries.bottom + this.option("zoom-distance");
                        if (G.bottom < N + this.zoomBox.height) {
                            N = this.boundaries.top - this.zoomBox.height - this.option("zoom-distance");
                            L = "top"
                        }
                        M = this.boundaries.left;
                        break;
                    case"left":
                        M = this.boundaries.left - this.zoomBox.width - this.option("zoom-distance");
                        if (G.left > M && G.right >= this.boundaries.right + this.option("zoom-distance") + this.zoomBox.width) {
                            M = this.boundaries.right + this.option("zoom-distance");
                            L = "right"
                        }
                        break;
                    case"right":
                    default:
                        M = this.boundaries.right + this.option("zoom-distance");
                        if (G.right < M + this.zoomBox.width && G.left <= this.boundaries.left - this.zoomBox.width - this.option("zoom-distance")) {
                            M = this.boundaries.left - this.zoomBox.width - this.option("zoom-distance");
                            L = "left"
                        }
                        break
                }
                switch (this.option("zoom-position")) {
                    case"top":
                    case"bottom":
                        if (G.top > N || G.bottom < N + this.zoomBox.height) {
                            L = "inner"
                        }
                        break;
                    case"left":
                    case"right":
                        if (G.left > M || G.right < M + this.zoomBox.width) {
                            L = "inner"
                        }
                        break
                }
                this.zoomBox.position = L;
                if (!this.zoomBox.activating && !this.zoomBox.active) {
                    if (y.jBrowser.mobile && !this.expanded && "zoom" == this.zoomBox.mode) {
                        if (this.option("expand")) {
                            this.zoomBox.enable("inner" !== L)
                        } else {
                            if ("click" !== this.option("zoomOn")) {
                                this.zoomBox.trigger = "inner" === L ? "click" : this.option("zoomOn");
                                this.unregisterActivateEvent();
                                this.unregisterDeactivateEvent();
                                this.registerActivateEvent("click" === this.zoomBox.trigger);
                                this.registerDeactivateEvent("click" === this.zoomBox.trigger && !this.option("expand"))
                            }
                        }
                        this.showHint(false, null, true)
                    }
                    return
                }
                this.setSize(false);
                if (K) {
                    return
                }
                if ("custom" == L) {
                    I = this.zoomBox.custom;
                    G.y = 0;
                    G.x = 0
                }
                if ("inner" == L) {
                    if ("preview" !== this.zoomBox.mode) {
                        this.zoomBox.node.jAddClass("mz-inner");
                        this.node.jAddClass("mz-inner-zoom")
                    }
                    this.lens.hide();
                    N = this.boundaries.top + G.y;
                    M = this.boundaries.left + G.x;
                    if (!this.expanded && y.jBrowser.ieMode && y.jBrowser.ieMode < 11) {
                        N = 0;
                        M = 0;
                        I = this.node
                    }
                } else {
                    N += G.y;
                    M += G.x;
                    this.node.jRemoveClass("mz-inner-zoom");
                    this.zoomBox.node.jRemoveClass("mz-inner")
                }
                this.zoomBox.node.jSetCss({top: N, left: M})
            } else {
                this.setSize(false);
                if (y.jBrowser.ieMode && y.jBrowser.ieMode < 11) {
                    I = this.node
                }
            }
            this.zoomBox.node[this.expanded ? "jAddClass" : "jRemoveClass"]("mz-expanded");
            if (!this.expanded && H) {
                H.jAppendTo("zoom" == this.zoomBox.mode && "inner" == L ? this.zoomBox.node : this.node, ((Math.floor(Math.random() * 101) + 1) % 2) ? "top" : "bottom")
            }
            this.zoomBox.node.jAppendTo(I)
        }, changeZoomLevel: function (M) {
            var I, G, K, J, L = false, H = M.isMouse ? 5 : 3 / 54;
            h(M).stop();
            H = (100 + H * Math.abs(M.deltaY)) / 100;
            if (M.deltaY < 0) {
                H = 1 / H
            }
            if ("magnifier" == this.zoomBox.mode) {
                G = Math.max(100, Math.round(this.zoomBox.width * H));
                G = Math.min(G, this.size.width * 0.9);
                K = G / this.zoomBox.aspectRatio;
                this.zoomBox.width = Math.ceil(G);
                this.zoomBox.height = Math.ceil(K);
                this.zoomBox.node.jSetCss({width: this.zoomBox.width, height: this.zoomBox.height});
                I = this.zoomBox.node.getInnerSize();
                this.zoomBox.innerWidth = Math.ceil(I.width);
                this.zoomBox.innerHeight = Math.ceil(I.height);
                L = true
            } else {
                if (!this.expanded && "zoom" == this.zoomBox.mode) {
                    G = Math.max(50, Math.round(this.lens.width * H));
                    G = Math.min(G, this.size.width * 0.9);
                    K = G / this.zoomBox.aspectRatio;
                    this.zoomSize.width = Math.ceil((this.zoomBox.innerWidth / G) * this.size.width);
                    this.zoomSize.height = Math.ceil((this.zoomBox.innerHeight / K) * this.size.height);
                    this.zoomBox.image.jSetCss({width: this.zoomSize.width, height: this.zoomSize.height})
                } else {
                    return
                }
            }
            J = h(window).jGetScroll();
            this.lens.width = Math.ceil(this.zoomBox.innerWidth / (this.zoomSize.width / this.size.width));
            this.lens.height = Math.ceil(this.zoomBox.innerHeight / (this.zoomSize.height / this.size.height));
            this.lens.node.jSetCss({width: this.lens.width, height: this.lens.height});
            y.extend(this.lens, this.lens.node.jGetSize());
            if (this.zoomBox.active) {
                clearTimeout(this.moveTimer);
                this.moveTimer = null;
                if (L) {
                    this.moveTimer = true
                }
                this.animate(null, {x: M.x - J.x, y: M.y - J.y});
                if (L) {
                    this.moveTimer = null
                }
            }
        }, registerActivateEvent: function (I) {
            var H, G = I ? "dbltap btnclick" : "touchstart" + (!y.jBrowser.mobile ? (window.navigator.pointerEnabled ? " pointermove" : window.navigator.msPointerEnabled ? " MSPointerMove" : " mousemove") : ""), J = this.node.jFetch("mz:handlers:activate:fn", (!I) ? h(function (K) {
                    H = (y.jBrowser.ieMode < 9) ? y.extend({}, K) : K;
                    if (!this.activateTimer) {
                        clearTimeout(this.activateTimer);
                        this.activateTimer = setTimeout(h(function () {
                            this.activate(H)
                        }).jBind(this), 120)
                    }
                }).jBindAsEvent(this) : h(this.activate).jBindAsEvent(this));
            this.node.jStore("mz:handlers:activate:event", G).jAddEvent(G, J, 10)
        }, unregisterActivateEvent: function (H) {
            var G = this.node.jFetch("mz:handlers:activate:event"), I = this.node.jFetch("mz:handlers:activate:fn");
            this.node.jRemoveEvent(G, I);
            this.node.jDel("mz:handlers:activate:fn")
        }, registerDeactivateEvent: function (H) {
            var G = H ? "dbltap btnclick" : "touchend" + (!y.jBrowser.mobile ? (window.navigator.pointerEnabled ? " pointerout" : window.navigator.msPointerEnabled ? " MSPointerOut" : " mouseout") : ""), I = this.node.jFetch("mz:handlers:deactivate:fn", h(function (J) {
                if (c(J) && !g(J)) {
                    return
                }
                if (this.zoomBox.node !== J.getRelated() && !(("inner" == this.zoomBox.position || "magnifier" == this.zoomBox.mode) && this.zoomBox.node.hasChild(J.getRelated())) && !this.node.hasChild(J.getRelated())) {
                    this.deactivate(J)
                }
            }).jBindAsEvent(this));
            this.node.jStore("mz:handlers:deactivate:event", G).jAddEvent(G, I, 20)
        }, unregisterDeactivateEvent: function () {
            var G = this.node.jFetch("mz:handlers:deactivate:event"), H = this.node.jFetch("mz:handlers:deactivate:fn");
            this.node.jRemoveEvent(G, H);
            this.node.jDel("mz:handlers:deactivate:fn")
        }, registerEvents: function () {
            this.moveBind = this.move.jBind(this);
            this.node.jAddEvent(["touchstart", window.navigator.pointerEnabled ? "pointerdown" : "MSPointerDown"], h(function (G) {
                if ((y.jBrowser.androidBrowser || "android" === y.jBrowser.platform && y.jBrowser.gecko) && this.option("zoomMode") && "click" !== this.option("zoomOn") && "touchstart" === G.type) {
                    G.stopDefaults();
                    if (y.jBrowser.gecko) {
                        G.stopDistribution()
                    }
                }
                if (!this.zoomBox.active) {
                    return
                }
                if ("inner" === this.zoomBox.position) {
                    this.lens.spos = G.getClientXY()
                }
            }).jBindAsEvent(this), 10);
            this.node.jAddEvent(["touchend", window.navigator.pointerEnabled ? "pointerup" : "MSPointerUp"], h(function (G) {
                if (c(G) && g(G)) {
                    this.lens.touchmovement = false
                }
            }).jBindAsEvent(this), 10);
            this.node.jAddEvent("touchmove " + ("android" === y.jBrowser.platform ? "" : window.navigator.pointerEnabled ? "pointermove" : window.navigator.msPointerEnabled ? "MSPointerMove" : "mousemove"), h(this.animate).jBindAsEvent(this));
            if (this.option("zoomMode")) {
                this.registerActivateEvent("click" === this.option("zoomOn"));
                this.registerDeactivateEvent("click" === this.option("zoomOn") && !this.option("expand"))
            }
            this.node.jAddEvent("mousedown", function (G) {
                G.stopDistribution()
            }, 10).jAddEvent("btnclick", h(function (G) {
                this.node.jRaiseEvent("MouseEvent", "click");
                if (this.expanded) {
                    this.expandBox.jCallEvent("btnclick", G)
                }
            }).jBind(this), 15);
            if (this.option("expand")) {
                this.node.jAddEvent("tap btnclick", h(this.expand).jBindAsEvent(this), 15)
            } else {
                this.node.jAddEvent("tap btnclick", h(this.openLink).jBindAsEvent(this), 15)
            }
            if (this.additionalImages.length > 1) {
                this.swipe()
            }
            if (!y.jBrowser.mobile && this.option("variableZoom")) {
                this.node.jAddEvent("mousescroll", this.changeZoomLevel.jBindAsEvent(this))
            }
            h(window).jAddEvent(y.jBrowser.mobile ? "resize" : "resize scroll", this.onResize)
        }, unregisterEvents: function () {
            if (this.node) {
                this.node.jRemoveEvent("mousescroll")
            }
            h(window).jRemoveEvent("resize scroll", this.onResize);
            h(this.additionalImages).jEach(function (G) {
                h(G.origin).jClearEvents()
            })
        }, activate: function (M) {
            var N, L, J, K, G, H = 0, I = 0;
            if (!this.ready || !this.zoomBox.enabled || this.zoomBox.active || this.zoomBox.activating) {
                if (!this.image.loaded()) {
                    if (M) {
                        this.initEvent = y.extend({}, M);
                        M.stopQueue()
                    }
                    this.image.load(this.setupZoom.jBind(this));
                    if (!this.loadTimer) {
                        this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
                    }
                }
                return
            }
            if (M && "pointermove" == M.type && "touch" == M.pointerType) {
                return
            }
            if (!this.option("zoomMode") && this.option("expand") && !this.expanded) {
                this.zoomBox.active = true;
                return
            }
            this.zoomBox.activating = true;
            if (this.expanded && "zoom" == this.zoomBox.mode) {
                K = this.image.node.jGetRect();
                this.expandStage.jAddClass("mz-zoom-in");
                G = this.expandFigure.jGetRect();
                I = ((K.left + K.right) / 2 - (G.left + G.right) / 2);
                H = ((K.top + K.bottom) / 2 - (G.top + G.bottom) / 2)
            }
            this.zoomBox.image.jRemoveEvent("transitionend");
            this.zoomBox.node.jRemoveClass("mz-deactivating").jRemoveEvent("transitionend");
            this.zoomBox.node.jAddClass("mz-activating");
            this.node.jAddClass("mz-activating");
            this.reflowZoom();
            L = ("zoom" == this.zoomBox.mode) ? this.zoomBox.position : this.zoomBox.mode;
            if (y.jBrowser.features.transition && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ("inner" == L) {
                    J = this.image.node.jGetSize();
                    this.zoomBox.image.jSetCss({transform: "translate3d(0," + H + "px, 0) scale(" + J.width / this.zoomSize.width + ", " + J.height / this.zoomSize.height + ")"}).jGetSize();
                    this.zoomBox.image.jAddEvent("transitionend", h(function () {
                        this.zoomBox.image.jRemoveEvent("transitionend");
                        this.zoomBox.node.jRemoveClass("mz-activating mz-p-" + L);
                        this.zoomBox.activating = false;
                        this.zoomBox.active = true
                    }).jBind(this));
                    this.zoomBox.node.jAddClass("mz-p-" + L).jGetSize();
                    if (!y.jBrowser.mobile && y.jBrowser.chrome && ("chrome" === y.jBrowser.uaName || "opera" === y.jBrowser.uaName)) {
                        this.zoomBox.activating = false;
                        this.zoomBox.active = true
                    }
                } else {
                    this.zoomBox.node.jAddEvent("transitionend", h(function () {
                        this.zoomBox.node.jRemoveEvent("transitionend");
                        this.zoomBox.node.jRemoveClass("mz-activating mz-p-" + L)
                    }).jBind(this));
                    this.zoomBox.node.jAddClass("mz-p-" + L).jGetSize();
                    this.zoomBox.node.jRemoveClass("mz-p-" + L);
                    this.zoomBox.activating = false;
                    this.zoomBox.active = true
                }
            } else {
                this.zoomBox.node.jRemoveClass("mz-activating");
                this.zoomBox.activating = false;
                this.zoomBox.active = true
            }
            if (!this.expanded) {
                this.showHint(true)
            }
            if (M) {
                M.stop().stopQueue();
                N = M.getClientXY();
                if ("magnifier" == this.zoomBox.mode && (/tap/i).test(M.type)) {
                    N.y -= this.zoomBox.height / 2 + 10
                }
                if ("inner" == L && ((/tap/i).test(M.type) || c(M))) {
                    this.lens.pos = {x: 0, y: 0};
                    N.x = -(N.x - this.boundaries.left - this.size.width / 2) * (this.zoomSize.width / this.size.width);
                    N.y = -(N.y - this.boundaries.top - this.size.height / 2) * (this.zoomSize.height / this.size.height)
                }
            } else {
                N = {
                    x: this.boundaries.left + (this.boundaries.right - this.boundaries.left) / 2,
                    y: this.boundaries.top + (this.boundaries.bottom - this.boundaries.top) / 2
                }
            }
            this.node.jRemoveClass("mz-activating").jAddClass("mz-active");
            N.x += -I;
            N.y += -H;
            this.lens.spos = {x: 0, y: 0};
            this.lens.dx = 0;
            this.lens.dy = 0;
            this.animate(M, N, true);
            s("onZoomIn", this.id)
        }, deactivate: function (I, N) {
            var L, J, G, H, K = 0, M = 0, O = this.zoomBox.active;
            this.initEvent = null;
            if (!this.ready) {
                return
            }
            if (I && "pointerout" == I.type && "touch" == I.pointerType) {
                return
            }
            clearTimeout(this.moveTimer);
            this.moveTimer = null;
            clearTimeout(this.activateTimer);
            this.activateTimer = null;
            this.zoomBox.activating = false;
            this.zoomBox.active = false;
            if (true !== N && !this.expanded) {
                if (O) {
                    if (y.jBrowser.mobile && !this.expanded && "zoom" == this.zoomBox.mode) {
                        this.reflowZoom()
                    } else {
                        this.showHint()
                    }
                }
            }
            if (!this.zoomBox.enabled) {
                return
            }
            if (I) {
                I.stop()
            }
            this.zoomBox.image.jRemoveEvent("transitionend");
            this.zoomBox.node.jRemoveClass("mz-activating").jRemoveEvent("transitionend");
            if (this.expanded) {
                H = this.expandFigure.jGetRect();
                if ("always" !== this.option("expandZoomOn")) {
                    this.expandStage.jRemoveClass("mz-zoom-in")
                }
                this.image.node.jSetCss({"max-height": this.expandMaxHeight()});
                G = this.image.node.jGetRect();
                M = ((G.left + G.right) / 2 - (H.left + H.right) / 2);
                K = ((G.top + G.bottom) / 2 - (H.top + H.bottom) / 2)
            }
            L = ("zoom" == this.zoomBox.mode) ? this.zoomBox.position : this.zoomBox.mode;
            if (y.jBrowser.features.transition && I && !(this.expanded && "always" == this.option("expandZoomOn"))) {
                if ("inner" == L) {
                    this.zoomBox.image.jAddEvent("transitionend", h(function () {
                        this.zoomBox.image.jRemoveEvent("transitionend");
                        this.node.jRemoveClass("mz-active");
                        setTimeout(h(function () {
                            this.zoomBox.hide()
                        }).jBind(this), 32)
                    }).jBind(this));
                    J = this.image.node.jGetSize();
                    this.zoomBox.node.jAddClass("mz-deactivating mz-p-" + L).jGetSize();
                    this.zoomBox.image.jSetCss({transform: "translate3d(0," + K + "px,0) scale(" + J.width / this.zoomSize.width + ", " + J.height / this.zoomSize.height + ")"})
                } else {
                    this.zoomBox.node.jAddEvent("transitionend", h(function () {
                        this.zoomBox.hide();
                        this.node.jRemoveClass("mz-active")
                    }).jBind(this));
                    this.zoomBox.node.jGetCss("opacity");
                    this.zoomBox.node.jAddClass("mz-deactivating mz-p-" + L);
                    this.node.jRemoveClass("mz-active")
                }
            } else {
                this.zoomBox.hide();
                this.node.jRemoveClass("mz-active")
            }
            this.lens.dx = 0;
            this.lens.dy = 0;
            this.lens.spos = {x: 0, y: 0};
            this.lens.hide();
            if (O) {
                s("onZoomOut", this.id)
            }
        }, animate: function (Q, P, O) {
            var I = P, K, J, M = 0, H, L = 0, G, R, N = false;
            if (this.initEvent && !this.image.loaded()) {
                this.initEvent = Q
            }
            if (!this.zoomBox.active && !O) {
                return
            }
            if (Q) {
                h(Q).stopDefaults().stopDistribution();
                if (c(Q) && !g(Q)) {
                    return
                }
                N = (/tap/i).test(Q.type) || c(Q);
                if (N && !this.lens.touchmovement) {
                    this.lens.touchmovement = N
                }
                if (!I) {
                    I = Q.getClientXY()
                }
            }
            if ("preview" == this.zoomBox.mode) {
                return
            }
            if ("zoom" == this.zoomBox.mode && "inner" === this.zoomBox.position && (Q && N || !Q && this.lens.innertouch)) {
                this.lens.innertouch = true;
                K = this.lens.pos.x + (I.x - this.lens.spos.x);
                J = this.lens.pos.y + (I.y - this.lens.spos.y);
                this.lens.spos = I;
                M = Math.min(0, this.zoomBox.innerWidth - this.zoomSize.width) / 2;
                H = -M;
                L = Math.min(0, this.zoomBox.innerHeight - this.zoomSize.height) / 2;
                G = -L
            } else {
                this.lens.innertouch = false;
                K = I.x - this.boundaries.left;
                J = I.y - this.boundaries.top;
                H = this.size.width - this.lens.width;
                G = this.size.height - this.lens.height;
                K -= this.lens.width / 2;
                J -= this.lens.height / 2
            }
            if ("magnifier" !== this.zoomBox.mode) {
                K = Math.max(M, Math.min(K, H));
                J = Math.max(L, Math.min(J, G))
            }
            this.lens.pos.x = K = Math.round(K);
            this.lens.pos.y = J = Math.round(J);
            if ("zoom" == this.zoomBox.mode && "inner" != this.zoomBox.position) {
                if (y.jBrowser.features.transform) {
                    this.lens.node.jSetCss({transform: "translate(" + this.lens.pos.x + "px," + this.lens.pos.y + "px)"});
                    this.lens.image.jSetCss({transform: "translate(" + -(this.lens.pos.x + this.lens.border.x) + "px, " + -(this.lens.pos.y + this.lens.border.y) + "px)"})
                } else {
                    this.lens.node.jSetCss({top: this.lens.pos.y, left: this.lens.pos.x});
                    this.lens.image.jSetCss({
                        top: -(this.lens.pos.y + this.lens.border.y),
                        left: -(this.lens.pos.x + this.lens.border.x)
                    })
                }
            }
            if ("magnifier" == this.zoomBox.mode) {
                if (this.lens.touchmovement && !(Q && "dbltap" == Q.type)) {
                    I.y -= this.zoomBox.height / 2 + 10
                }
                R = h(window).jGetScroll();
                this.zoomBox.node.jSetCss((y.jBrowser.ieMode && y.jBrowser.ieMode < 11) ? {
                        top: I.y - this.boundaries.top - this.zoomBox.height / 2,
                        left: I.x - this.boundaries.left - this.zoomBox.width / 2
                    } : {top: I.y + R.y - this.zoomBox.height / 2, left: I.x + R.x - this.zoomBox.width / 2})
            }
            if (!this.moveTimer) {
                this.lens.dx = 0;
                this.lens.dy = 0;
                this.move(1)
            }
        }, move: function (I) {
            var H, G;
            if (!isFinite(I)) {
                if (this.lens.innertouch) {
                    I = this.lens.touchmovement ? 0.4 : 0.16
                } else {
                    I = this.option("smoothing") ? 0.2 : this.lens.touchmovement ? 0.4 : 0.8
                }
            }
            H = ((this.lens.pos.x - this.lens.dx) * I);
            G = ((this.lens.pos.y - this.lens.dy) * I);
            this.lens.dx += H;
            this.lens.dy += G;
            if (!this.moveTimer || Math.abs(H) > 0.000001 || Math.abs(G) > 0.000001) {
                this.zoomBox.image.jSetCss(y.jBrowser.features.transform ? {transform: f + (this.lens.innertouch ? this.lens.dx : -(this.lens.dx * (this.zoomSize.width / this.size.width) - Math.max(0, this.zoomSize.width - this.zoomBox.innerWidth) / 2)) + "px," + (this.lens.innertouch ? this.lens.dy : -(this.lens.dy * (this.zoomSize.height / this.size.height) - Math.max(0, this.zoomSize.height - this.zoomBox.innerHeight) / 2)) + "px" + A + " scale(1)"} : {
                        left: -(this.lens.dx * (this.zoomSize.width / this.size.width) + Math.min(0, this.zoomSize.width - this.zoomBox.innerWidth) / 2),
                        top: -(this.lens.dy * (this.zoomSize.height / this.size.height) + Math.min(0, this.zoomSize.height - this.zoomBox.innerHeight) / 2)
                    })
            }
            if ("magnifier" == this.zoomBox.mode) {
                return
            }
            this.moveTimer = setTimeout(this.moveBind, 16)
        }, swipe: function () {
            var S, I, N = 30, K = 201, P, Q = "", H = {}, G, M, R = 0, T = {transition: y.jBrowser.cssTransform + String.fromCharCode(32) + "300ms cubic-bezier(.18,.35,.58,1)"}, J, O, L = h(function (U) {
                if (!this.ready || this.zoomBox.active) {
                    return
                }
                if (U.state == "dragstart") {
                    clearTimeout(this.activateTimer);
                    this.activateTimer = null;
                    R = 0;
                    H = {x: U.x, y: U.y, ts: U.timeStamp};
                    S = this.size.width;
                    I = S / 2;
                    this.image.node.jRemoveEvent("transitionend");
                    this.image.node.jSetCssProp("transition", "");
                    this.image.node.jSetCssProp("transform", "translate3d(0, 0, 0)");
                    O = null
                } else {
                    G = (U.x - H.x);
                    M = {x: 0, y: 0, z: 0};
                    if (null === O) {
                        O = (Math.abs(U.x - H.x) < Math.abs(U.y - H.y))
                    }
                    if (O) {
                        return
                    }
                    U.stop();
                    if ("dragend" == U.state) {
                        R = 0;
                        J = null;
                        P = U.timeStamp - H.ts;
                        if (Math.abs(G) > I || (P < K && Math.abs(G) > N)) {
                            if ((Q = (G > 0) ? "backward" : (G <= 0) ? "forward" : "")) {
                                if (Q == "backward") {
                                    J = this.getPrev();
                                    R += S * 10
                                } else {
                                    J = this.getNext();
                                    R -= S * 10
                                }
                            }
                        }
                        M.x = R;
                        M.deg = -90 * (M.x / S);
                        this.image.node.jAddEvent("transitionend", h(function (V) {
                            this.image.node.jRemoveEvent("transitionend");
                            this.image.node.jSetCssProp("transition", "");
                            if (J) {
                                this.image.node.jSetCss({transform: "translate3d(" + M.x + "px, 0px, 0px)"});
                                this.update(J, true)
                            }
                        }).jBind(this));
                        this.image.node.jSetCss(T);
                        this.image.node.jSetCss({
                            "transition-duration": M.x ? "100ms" : "300ms",
                            opacity: 1 - 0.7 * Math.abs(M.x / S),
                            transform: "translate3d(" + M.x + "px, 0px, 0px)"
                        });
                        G = 0;
                        return
                    }
                    M.x = G;
                    M.z = -50 * Math.abs(M.x / I);
                    M.deg = -60 * (M.x / I);
                    this.image.node.jSetCss({
                        opacity: 1 - 0.7 * Math.abs(M.x / I),
                        transform: "translate3d(" + M.x + "px, 0px, " + M.z + "px)"
                    })
                }
            }).jBind(this);
            this.node.jAddEvent("touchdrag", L)
        }, setupExpandGallery: function () {
            var H, G;
            if (this.additionalImages.length) {
                this.expandGallery = this.additionalImages
            } else {
                H = this.placeholder.getAttribute("data-gallery");
                if (H) {
                    if (y.jBrowser.features.query) {
                        G = y.$A(document.querySelectorAll('.MagicZoom[data-gallery="' + H + '"]'))
                    } else {
                        G = y.$A(document.getElementsByTagName("A")).filter(function (I) {
                            return H == I.getAttribute("data-gallery")
                        })
                    }
                    h(G).jEach(function (J) {
                        var I, K;
                        I = i(J);
                        if (I && I.additionalImages.length > 0) {
                            return
                        }
                        if (I) {
                            K = new k(I.image.small.url, I.image.zoom.url, I.image.caption, null, I.image.origin)
                        } else {
                            K = new k().parseNode(J, I ? I.originalTitle : null)
                        }
                        if (this.image.zoom.src.has(K.zoom.url) && this.image.small.src.has(K.small.url)) {
                            K = this.image
                        }
                        this.expandGallery.push(K)
                    }, this);
                    this.primaryImage = this.image
                }
            }
            if (this.expandGallery.length > 1) {
                this.expandStage.jAddClass("with-thumbs");
                this.expandNav = y.$new("div", {"class": "mz-expand-thumbnails"}).jAppendTo(this.expandStage);
                this.expandThumbs = new r(this.expandNav);
                h(this.expandGallery).jEach(function (I) {
                    var J = h(function (K) {
                        this.setActiveThumb(I);
                        this.update(I)
                    }).jBind(this);
                    I.selector = this.expandThumbs.addItem(y.$new("img", {src: I.getURL("small")}).jAddEvent("tap btnclick", function (K) {
                        K.stop()
                    }).jAddEvent("tap " + ("hover" == this.option("selectorTrigger") ? "mouseover mouseout" : "btnclick"), h(function (L, K) {
                        if (this.updateTimer) {
                            clearTimeout(this.updateTimer)
                        }
                        this.updateTimer = false;
                        if ("mouseover" == L.type) {
                            this.updateTimer = h(J).jDelay(K)
                        } else {
                            if ("tap" == L.type || "btnclick" == L.type) {
                                J()
                            }
                        }
                    }).jBindAsEvent(this, 60)))
                }, this);
                this.buttons.next.show();
                this.buttons.prev.show()
            } else {
                this.expandStage.jRemoveClass("with-thumbs");
                this.buttons.next.hide();
                this.buttons.prev.hide()
            }
        }, destroyExpandGallery: function () {
            var G;
            if (this.expandThumbs) {
                this.expandThumbs.stop();
                this.expandThumbs = null
            }
            if (this.expandNav) {
                this.expandNav.jRemove();
                this.expandNav = null
            }
            if (this.expandGallery.length > 1 && !this.additionalImages.length) {
                this.node.jRemoveEvent("touchdrag");
                this.image.node.jRemove().getAttribute("style");
                this.image.node.removeAttribute("style");
                this.primaryImage.node.jAppendTo(this.node);
                this.setupZoom(this.primaryImage);
                while (G = this.expandGallery.pop()) {
                    if (G !== this.primaryImage) {
                        if (G.small.node) {
                            G.small.node.kill();
                            G.small.node = null
                        }
                        if (G.zoom.node) {
                            G.zoom.node.kill();
                            G.zoom.node = null
                        }
                        G = null
                    }
                }
            }
            this.expandGallery = []
        }, close: function () {
            if (!this.ready || !this.expanded) {
                return
            }
            if ("ios" == y.jBrowser.platform && "safari" == y.jBrowser.uaName && 7 == parseInt(y.jBrowser.uaVersion)) {
                clearInterval(m);
                m = null
            }
            h(document).jRemoveEvent("keydown", this.keyboardCallback);
            this.deactivate(null, true);
            this.ready = false;
            if (w.jBrowser.fullScreen.capable && w.jBrowser.fullScreen.enabled()) {
                w.jBrowser.fullScreen.cancel()
            } else {
                if (y.jBrowser.features.transition) {
                    this.node.jRemoveEvent("transitionend").jSetCss({transition: ""});
                    this.node.jAddEvent("transitionend", this.onClose);
                    if (y.jBrowser.chrome && ("chrome" === y.jBrowser.uaName || "opera" === y.jBrowser.uaName)) {
                        setTimeout(h(function () {
                            this.onClose()
                        }).jBind(this), 600)
                    }
                    this.expandBg.jRemoveEvent("transitionend").jSetCss({transition: ""});
                    this.expandBg.jSetCss({transition: "all 0.6s cubic-bezier(0.895, 0.030, 0.685, 0.220) 0.0s"}).jGetSize();
                    if (y.jBrowser.androidBrowser && "chrome" !== y.jBrowser.uaName) {
                        this.node.jSetCss({transition: "all .4s cubic-bezier(0.600, 0, 0.735, 0.045) 0s"}).jGetSize()
                    } else {
                        this.node.jSetCss({transition: "all .4s cubic-bezier(0.600, -0.280, 0.735, 0.045) 0s"}).jGetSize()
                    }
                    if ("always" == this.option("expandZoomOn") && "magnifier" !== this.option("expandZoomMode")) {
                        this.image.node.jSetCss({"max-height": this.image.jGetSize("zoom").height});
                        this.image.node.jSetCss({"max-width": this.image.jGetSize("zoom").width})
                    }
                    this.expandBg.jSetCss({opacity: 0.4});
                    this.node.jSetCss({opacity: 0.01, transform: "scale(0.4)"})
                } else {
                    this.onClose()
                }
            }
        }, expand: function (I) {
            if (!this.image.loaded() || !this.ready || this.expanded) {
                if (!this.image.loaded()) {
                    if (I) {
                        this.initEvent = y.extend({}, I);
                        I.stopQueue()
                    }
                    this.image.load(this.setupZoom.jBind(this));
                    if (!this.loadTimer) {
                        this.loadTimer = h(this.showLoading).jBind(this).jDelay(400)
                    }
                }
                return
            }
            if (I) {
                I.stopQueue()
            }
            var G = h(this.node).jFetch("cr"), H = document.createDocumentFragment();
            this.hideHint();
            this.hintRuns--;
            this.deactivate(null, true);
            this.unregisterActivateEvent();
            this.unregisterDeactivateEvent();
            this.ready = false;
            if (!this.expandBox) {
                this.expandBox = y.$new("div").jAddClass("mz-expand").jAddClass(this.option("cssClass")).jSetCss({opacity: 0});
                this.expandStage = y.$new("div").jAddClass("mz-expand-stage").jAppendTo(this.expandBox);
                this.expandControls = y.$new("div").jAddClass("mz-expand-controls").jAppendTo(this.expandStage);
                h(["prev", "next", "close"]).jEach(function (K) {
                    var J = "mz-button";
                    this.buttons[K] = y.$new("button", {title: this.option("text-btn-" + K)}).jAddClass(J).jAddClass(J + "-" + K);
                    H.appendChild(this.buttons[K]);
                    switch (K) {
                        case"prev":
                            this.buttons[K].jAddEvent("tap btnclick", function (L) {
                                L.stop();
                                this.update(this.getPrev())
                            }.jBindAsEvent(this));
                            break;
                        case"next":
                            this.buttons[K].jAddEvent("tap btnclick", function (L) {
                                L.stop();
                                this.update(this.getNext())
                            }.jBindAsEvent(this));
                            break;
                        case"close":
                            this.buttons[K].jAddEvent("tap btnclick", function (L) {
                                L.stop();
                                this.close()
                            }.jBindAsEvent(this));
                            break
                    }
                }, this);
                this.expandControls.append(H);
                this.expandBox.jAddEvent("mousescroll touchstart dbltap", h(function (J) {
                    h(J).stop()
                }));
                if (this.option("closeOnClickOutside")) {
                    this.expandBox.jAddEvent("tap btnclick", function (J) {
                        if ("always" !== this.option("expandZoomOn") && this.node.hasChild(J.getOriginalTarget())) {
                            return
                        }
                        J.stop();
                        this.close()
                    }.jBindAsEvent(this))
                }
                this.keyboardCallback = h(function (K) {
                    var J = null;
                    if (27 !== K.keyCode && 37 !== K.keyCode && 39 !== K.keyCode) {
                        return
                    }
                    h(K).stop();
                    if (27 === K.keyCode) {
                        this.close()
                    } else {
                        J = (37 === K.keyCode) ? this.getPrev() : this.getNext();
                        if (J) {
                            this.update(J)
                        }
                    }
                }).jBindAsEvent(this);
                this.onExpand = h(function () {
                    var J;
                    this.node.jRemoveEvent("transitionend").jSetCss({transition: "", transform: "translate3d(0,0,0)"});
                    if (this.expanded) {
                        return
                    }
                    this.expanded = true;
                    this.expandBox.jRemoveClass("mz-expand-opening").jSetCss({opacity: 1});
                    this.zoomBox.setMode(this.option("expandZoomMode"));
                    this.zoomSize = y.detach(this.zoomSizeOrigin);
                    this.resizeCallback();
                    if (this.expandCaption && this.image.caption) {
                        if (this.image.link) {
                            this.expandCaption.append(y.$new("a", {href: this.image.link}).jAddEvent("tap btnclick", this.openLink.jBind(this)).changeContent(this.image.caption))
                        } else {
                            this.expandCaption.changeContent(this.image.caption)
                        }
                        this.expandCaption.jAddClass("mz-show")
                    }
                    if ("always" !== this.option("expandZoomOn")) {
                        this.registerActivateEvent(true);
                        this.registerDeactivateEvent(true)
                    }
                    this.ready = true;
                    if ("always" === this.option("expandZoomOn")) {
                        this.activate()
                    }
                    if (y.jBrowser.mobile && this.mobileZoomHint && this.zoomBox.enabled) {
                        this.showHint(true, this.option("textClickZoomHint"));
                        this.mobileZoomHint = false
                    }
                    this.expandControls.jRemoveClass("mz-hidden").jAddClass("mz-fade mz-visible");
                    this.expandNav && this.expandNav.jRemoveClass("mz-hidden").jAddClass("mz-fade mz-visible");
                    if (this.expandThumbs) {
                        this.expandThumbs.run();
                        this.setActiveThumb(this.image)
                    }
                    if (G) {
                        G.jAppendTo(this.expandBox, ((Math.floor(Math.random() * 101) + 1) % 2) ? "top" : "bottom")
                    }
                    if (this.expandGallery.length && !this.additionalImages.length) {
                        this.swipe()
                    }
                    h(document).jAddEvent("keydown", this.keyboardCallback);
                    if ("ios" == y.jBrowser.platform && "safari" == y.jBrowser.uaName && 7 == parseInt(y.jBrowser.uaVersion)) {
                        m = u()
                    }
                    s("onExpandOpen", this.id)
                }).jBind(this);
                this.onClose = h(function () {
                    this.node.jRemoveEvent("transitionend");
                    if (!this.expanded) {
                        return
                    }
                    if (this.expanded) {
                        h(document).jRemoveEvent("keydown", this.keyboardCallback);
                        this.deactivate(null, true)
                    }
                    this.destroyExpandGallery();
                    this.expanded = false;
                    this.zoomBox.setMode(this.option("zoomMode"));
                    this.node.replaceChild(this.image.getNode("small"), this.image.node);
                    this.image.setCurNode("small");
                    h(this.image.node).jSetCss({
                        width: "",
                        height: "",
                        "max-width": Math.min(this.image.jGetSize("small").width),
                        "max-height": Math.min(this.image.jGetSize("small").height)
                    });
                    this.node.jSetCss({opacity: "", transition: ""});
                    this.node.jSetCss({transform: "translate3d(0,0,0)"});
                    this.node.jAppendTo(this.placeholder);
                    this.setSize(true);
                    if (this.expandCaption) {
                        this.expandCaption.jRemove();
                        this.expandCaption = null
                    }
                    this.unregisterActivateEvent();
                    this.unregisterDeactivateEvent();
                    if ("always" == this.option("zoomOn")) {
                        this.activate()
                    } else {
                        if (false !== this.option("zoomMode")) {
                            this.registerActivateEvent("click" === this.option("zoomOn"));
                            this.registerDeactivateEvent("click" === this.option("zoomOn") && !this.option("expand"))
                        }
                    }
                    this.showHint();
                    this.expandBg.jRemoveEvent("transitionend");
                    this.expandBox.jRemove();
                    this.expandBg.jRemove();
                    this.expandBg = null;
                    h(y.jBrowser.getDoc()).jSetCss({overflow: ""});
                    h(document.body).jSetCss({overflow: ""});
                    this.ready = true;
                    if (y.jBrowser.ieMode < 10) {
                        this.resizeCallback()
                    } else {
                        h(window).jRaiseEvent("UIEvent", "resize")
                    }
                    s("onExpandClose", this.id)
                }).jBind(this);
                this.expandImageStage = y.$new("div", {"class": "mz-image-stage"}).jAppendTo(this.expandStage);
                this.expandFigure = y.$new("figure").jAppendTo(this.expandImageStage)
            }
            this.setupExpandGallery();
            h(y.jBrowser.getDoc()).jSetCss({overflow: "hidden"});
            h(document.body).jSetCss({overflow: "hidden"}).jGetSize();
            if ("fullscreen" == this.option("expand")) {
                this.prepareExpandedView();
                w.jBrowser.fullScreen.request(this.expandBox, {
                    onEnter: h(function () {
                        this.onExpand()
                    }).jBind(this), onExit: this.onClose, fallback: h(function () {
                        this.expandToWindow()
                    }).jBind(this)
                })
            } else {
                setTimeout(h(function () {
                    this.expandToWindow()
                }).jBind(this), 96)
            }
        }, prepareExpandedView: function () {
            var G;
            G = y.$new("img", {src: this.image.getURL("zoom")});
            this.expandBg = y.$new("div").jAddClass("mz-expand-bg").append((y.jBrowser.features.cssFilters || y.jBrowser.ieMode < 10) ? G : new y.SVGImage(G).blur(b).getNode()).jAppendTo(this.expandBox);
            if ("always" === this.option("expandZoomOn")) {
                this.expandStage.jAddClass("mz-always-zoom" + ("zoom" === this.option("expandZoomMode") ? " mz-zoom-in" : "")).jGetSize()
            }
            this.node.replaceChild(this.image.getNode("zoom"), this.image.node);
            this.image.setCurNode("zoom");
            this.expandBox.jAppendTo(document.body);
            this.expandMaxWidth = function () {
                var H = this.expandImageStage;
                if (h(this.expandFigure).jGetSize().width > 50) {
                    H = this.expandFigure
                }
                return function () {
                    return "always" == this.option("expandZoomOn") && "magnifier" !== this.option("expandZoomMode") ? Infinity : Math.round(h(H).getInnerSize().width)
                }
            }.call(this);
            this.expandMaxHeight = function () {
                var H = this.expandImageStage;
                if (h(this.expandFigure).jGetSize().height > 50) {
                    H = this.expandFigure
                }
                return function () {
                    return "always" == this.option("expandZoomOn") && "magnifier" !== this.option("expandZoomMode") ? Infinity : Math.round(h(H).getInnerSize().height)
                }
            }.call(this);
            this.expandControls.jRemoveClass("mz-fade mz-visible").jAddClass("mz-hidden");
            this.expandNav && this.expandNav.jRemoveClass("mz-fade mz-visible").jAddClass("mz-hidden");
            this.image.node.jSetCss({"max-height": Math.min(this.image.jGetSize("zoom").height, this.expandMaxHeight())});
            this.image.node.jSetCss({"max-width": Math.min(this.image.jGetSize("zoom").width, this.expandMaxWidth())});
            this.expandFigure.append(this.node);
            if (this.option("expandCaption")) {
                this.expandCaption = y.$new("figcaption", {"class": "mz-caption"}).jAppendTo(this.expandFigure)
            }
        }, expandToWindow: function () {
            this.prepareExpandedView();
            this.node.jSetCss({transition: ""});
            this.node.jSetCss({transform: "scale(0.6)"}).jGetSize();
            if (y.jBrowser.androidBrowser && "chrome" !== y.jBrowser.uaName) {
                this.node.jSetCss({transition: y.jBrowser.cssTransform + " 0.6s cubic-bezier(0.175, 0.885, 0.320, 1) 0s"})
            } else {
                this.node.jSetCss({transition: y.jBrowser.cssTransform + " 0.6s cubic-bezier(0.175, 0.885, 0.320, 1.275) 0s"})
            }
            if (y.jBrowser.features.transition) {
                this.node.jAddEvent("transitionend", this.onExpand);
                if (y.jBrowser.chrome && ("chrome" === y.jBrowser.uaName || "opera" === y.jBrowser.uaName)) {
                    setTimeout(h(function () {
                        this.onExpand()
                    }).jBind(this), 800)
                }
            } else {
                this.onExpand.jDelay(16, this)
            }
            this.expandBox.jSetCss({opacity: 1});
            this.node.jSetCss({transform: "scale(1)"})
        }, openLink: function () {
            if (this.image.link) {
                window.open(this.image.link, "_self")
            }
        }, getNext: function () {
            var G = (this.expanded ? this.expandGallery : this.additionalImages).filter(function (J) {
                return (-1 !== J.small.state || -1 !== J.zoom.state)
            }), H = G.length, I = h(G).indexOf(this.image) + 1;
            return (1 >= H) ? null : G[(I >= H) ? 0 : I]
        }, getPrev: function () {
            var G = (this.expanded ? this.expandGallery : this.additionalImages).filter(function (J) {
                return (-1 !== J.small.state || -1 !== J.zoom.state)
            }), H = G.length, I = h(G).indexOf(this.image) - 1;
            return (1 >= H) ? null : G[(I < 0) ? H - 1 : I]
        }, imageByURL: function (H, I) {
            var G = this.additionalImages.filter(function (J) {
                    return ((J.zoom.src.has(H) || J.zoom.url.has(H)) && (J.small.src.has(I) || J.small.url.has(I)))
                }) || [];
            return G[0] || ((I && H && "string" === y.jTypeOf(I) && "string" === y.jTypeOf(H)) ? new k(I, H) : null)
        }, imageByOrigin: function (H) {
            var G = this.additionalImages.filter(function (I) {
                    return (I.origin === H)
                }) || [];
            return G[0]
        }, imageByIndex: function (G) {
            return this.additionalImages[G]
        }
    };
    t = {
        version: "v5.1.3 (Plus)", start: function (J, H) {
            var I = null, G = [];
            y.$A((J ? [h(J)] : y.$A(document.byClass("MagicZoom")).concat(y.$A(document.byClass("MagicZoomPlus"))))).jEach((function (K) {
                if (h(K)) {
                    if (!i(K)) {
                        I = new j(K, H);
                        if (x && !I.option("autostart")) {
                            I.stop();
                            I = null
                        } else {
                            D.push(I);
                            G.push(I)
                        }
                    }
                }
            }).jBind(this));
            return J ? G[0] : G
        }, stop: function (J) {
            var H, I, G;
            if (J) {
                (I = i(J)) && (I = D.splice(D.indexOf(I), 1)) && I[0].stop() && (delete I[0]);
                return
            }
            while (H = D.length) {
                I = D.splice(H - 1, 1);
                I[0].stop();
                delete I[0]
            }
        }, refresh: function (G) {
            this.stop(G);
            return this.start(G)
        }, update: function (L, K, J, H) {
            var I = i(L), G;
            if (I) {
                G = "element" === y.jTypeOf(K) ? I.imageByOrigin(K) : I.imageByURL(K, J);
                if (G) {
                    I.update(G)
                }
            }
        }, switchTo: function (J, I) {
            var H = i(J), G;
            if (H) {
                switch (y.jTypeOf(I)) {
                    case"element":
                        G = H.imageByOrigin(I);
                        break;
                    case"number":
                        G = H.imageByIndex(I);
                        break;
                    default:
                }
                if (G) {
                    H.update(G)
                }
            }
        }, prev: function (H) {
            var G;
            (G = i(H)) && G.update(G.getPrev())
        }, next: function (H) {
            var G;
            (G = i(H)) && G.update(G.getNext())
        }, zoomIn: function (H) {
            var G;
            (G = i(H)) && G.activate()
        }, zoomOut: function (H) {
            var G;
            (G = i(H)) && G.deactivate()
        }, expand: function (H) {
            var G;
            (G = i(H)) && G.expand()
        }, close: function (H) {
            var G;
            (G = i(H)) && G.close()
        }, registerCallback: function (G, H) {
            if (!p[G]) {
                p[G] = []
            }
            if ("function" == y.jTypeOf(H)) {
                p[G].push(H)
            }
        }, running: function (G) {
            return !!i(G)
        }
    };
    h(document).jAddEvent("domready", function () {
        var H = window[B + "Options"] || {};
        d();
        F = y.$new("div", {"class": "magic-hidden-wrapper"}).jAppendTo(document.body);
        E = (y.jBrowser.mobile && window.matchMedia && window.matchMedia("(max-device-width: 767px), (max-device-height: 767px)").matches);
        if (y.jBrowser.mobile) {
            y.extend(o, l)
        }
        for (var G = 0; G < z.length; G++) {
            if (H[z[G]] && y.$F !== H[z[G]]) {
                t.registerCallback(z[G], H[z[G]])
            }
        }
        t.start();
        x = false
    });
    window.MagicZoomPlus = window.MagicZoomPlus || {};
    return t
})();