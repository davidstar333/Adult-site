"use strict";

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*
 AngularJS v1.4.9
 (c) 2010-2015 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (S, W, w) {
  'use strict';
  function M(a) {
    return function () {
      var b = arguments[0],
          d;d = "[" + (a ? a + ":" : "") + b + "] http://errors.angularjs.org/1.4.9/" + (a ? a + "/" : "") + b;for (b = 1; b < arguments.length; b++) {
        d = d + (1 == b ? "?" : "&") + "p" + (b - 1) + "=";var c = encodeURIComponent,
            e;e = arguments[b];e = "function" == typeof e ? e.toString().replace(/ \{[\s\S]*$/, "") : "undefined" == typeof e ? "undefined" : "string" != typeof e ? JSON.stringify(e) : e;d += c(e);
      }return Error(d);
    };
  }function Aa(a) {
    if (null == a || Xa(a)) return !1;if (E(a) || F(a) || A && a instanceof A) return !0;
    var b = "length" in Object(a) && a.length;return Q(b) && (0 <= b && (b - 1 in a || a instanceof Array) || "function" == typeof a.item);
  }function n(a, b, d) {
    var c, e;if (a) if (B(a)) for (c in a) {
      "prototype" == c || "length" == c || "name" == c || a.hasOwnProperty && !a.hasOwnProperty(c) || b.call(d, a[c], c, a);
    } else if (E(a) || Aa(a)) {
      var f = "object" !== (typeof a === "undefined" ? "undefined" : _typeof(a));c = 0;for (e = a.length; c < e; c++) {
        (f || c in a) && b.call(d, a[c], c, a);
      }
    } else if (a.forEach && a.forEach !== n) a.forEach(b, d, a);else if (oc(a)) for (c in a) {
      b.call(d, a[c], c, a);
    } else if ("function" === typeof a.hasOwnProperty) for (c in a) {
      a.hasOwnProperty(c) && b.call(d, a[c], c, a);
    } else for (c in a) {
      ra.call(a, c) && b.call(d, a[c], c, a);
    }return a;
  }function pc(a, b, d) {
    for (var c = Object.keys(a).sort(), e = 0; e < c.length; e++) {
      b.call(d, a[c[e]], c[e]);
    }return c;
  }function qc(a) {
    return function (b, d) {
      a(d, b);
    };
  }function Xd() {
    return ++ob;
  }function Ob(a, b, d) {
    for (var c = a.$$hashKey, e = 0, f = b.length; e < f; ++e) {
      var g = b[e];if (G(g) || B(g)) for (var h = Object.keys(g), k = 0, l = h.length; k < l; k++) {
        var m = h[k],
            r = g[m];d && G(r) ? da(r) ? a[m] = new Date(r.valueOf()) : La(r) ? a[m] = new RegExp(r) : r.nodeName ? a[m] = r.cloneNode(!0) : Pb(r) ? a[m] = r.clone() : (G(a[m]) || (a[m] = E(r) ? [] : {}), Ob(a[m], [r], !0)) : a[m] = r;
      }
    }c ? a.$$hashKey = c : delete a.$$hashKey;return a;
  }function N(a) {
    return Ob(a, sa.call(arguments, 1), !1);
  }function Yd(a) {
    return Ob(a, sa.call(arguments, 1), !0);
  }function Z(a) {
    return parseInt(a, 10);
  }function Qb(a, b) {
    return N(Object.create(a), b);
  }function z() {}function Ya(a) {
    return a;
  }function na(a) {
    return function () {
      return a;
    };
  }function rc(a) {
    return B(a.toString) && a.toString !== ta;
  }function q(a) {
    return "undefined" === typeof a;
  }function u(a) {
    return "undefined" !== typeof a;
  }function G(a) {
    return null !== a && "object" === (typeof a === "undefined" ? "undefined" : _typeof(a));
  }function oc(a) {
    return null !== a && "object" === (typeof a === "undefined" ? "undefined" : _typeof(a)) && !sc(a);
  }function F(a) {
    return "string" === typeof a;
  }function Q(a) {
    return "number" === typeof a;
  }function da(a) {
    return "[object Date]" === ta.call(a);
  }function B(a) {
    return "function" === typeof a;
  }function La(a) {
    return "[object RegExp]" === ta.call(a);
  }function Xa(a) {
    return a && a.window === a;
  }function Za(a) {
    return a && a.$evalAsync && a.$watch;
  }function $a(a) {
    return "boolean" === typeof a;
  }function tc(a) {
    return a && Q(a.length) && Zd.test(ta.call(a));
  }function Pb(a) {
    return !(!a || !(a.nodeName || a.prop && a.attr && a.find));
  }function $d(a) {
    var b = {};a = a.split(",");var d;for (d = 0; d < a.length; d++) {
      b[a[d]] = !0;
    }return b;
  }function oa(a) {
    return K(a.nodeName || a[0] && a[0].nodeName);
  }function ab(a, b) {
    var d = a.indexOf(b);0 <= d && a.splice(d, 1);return d;
  }function Ma(a, b) {
    function d(a, b) {
      var d = b.$$hashKey,
          e;if (E(a)) {
        e = 0;for (var f = a.length; e < f; e++) {
          b.push(c(a[e]));
        }
      } else if (oc(a)) for (e in a) {
        b[e] = c(a[e]);
      } else if (a && "function" === typeof a.hasOwnProperty) for (e in a) {
        a.hasOwnProperty(e) && (b[e] = c(a[e]));
      } else for (e in a) {
        ra.call(a, e) && (b[e] = c(a[e]));
      }d ? b.$$hashKey = d : delete b.$$hashKey;return b;
    }function c(a) {
      if (!G(a)) return a;var b = e.indexOf(a);if (-1 !== b) return f[b];if (Xa(a) || Za(a)) throw Ba("cpws");var b = !1,
          c;E(a) ? (c = [], b = !0) : tc(a) ? c = new a.constructor(a) : da(a) ? c = new Date(a.getTime()) : La(a) ? (c = new RegExp(a.source, a.toString().match(/[^\/]*$/)[0]), c.lastIndex = a.lastIndex) : B(a.cloneNode) ? c = a.cloneNode(!0) : (c = Object.create(sc(a)), b = !0);e.push(a);f.push(c);return b ? d(a, c) : c;
    }var e = [],
        f = [];if (b) {
      if (tc(b)) throw Ba("cpta");
      if (a === b) throw Ba("cpi");E(b) ? b.length = 0 : n(b, function (a, c) {
        "$$hashKey" !== c && delete b[c];
      });e.push(a);f.push(b);return d(a, b);
    }return c(a);
  }function ha(a, b) {
    if (E(a)) {
      b = b || [];for (var d = 0, c = a.length; d < c; d++) {
        b[d] = a[d];
      }
    } else if (G(a)) for (d in b = b || {}, a) {
      if ("$" !== d.charAt(0) || "$" !== d.charAt(1)) b[d] = a[d];
    }return b || a;
  }function ka(a, b) {
    if (a === b) return !0;if (null === a || null === b) return !1;if (a !== a && b !== b) return !0;var d = typeof a === "undefined" ? "undefined" : _typeof(a),
        c;if (d == (typeof b === "undefined" ? "undefined" : _typeof(b)) && "object" == d) if (E(a)) {
      if (!E(b)) return !1;if ((d = a.length) == b.length) {
        for (c = 0; c < d; c++) {
          if (!ka(a[c], b[c])) return !1;
        }return !0;
      }
    } else {
      if (da(a)) return da(b) ? ka(a.getTime(), b.getTime()) : !1;if (La(a)) return La(b) ? a.toString() == b.toString() : !1;if (Za(a) || Za(b) || Xa(a) || Xa(b) || E(b) || da(b) || La(b)) return !1;d = ea();for (c in a) {
        if ("$" !== c.charAt(0) && !B(a[c])) {
          if (!ka(a[c], b[c])) return !1;d[c] = !0;
        }
      }for (c in b) {
        if (!(c in d) && "$" !== c.charAt(0) && u(b[c]) && !B(b[c])) return !1;
      }return !0;
    }return !1;
  }function bb(a, b, d) {
    return a.concat(sa.call(b, d));
  }function uc(a, b) {
    var d = 2 < arguments.length ? sa.call(arguments, 2) : [];return !B(b) || b instanceof RegExp ? b : d.length ? function () {
      return arguments.length ? b.apply(a, bb(d, arguments, 0)) : b.apply(a, d);
    } : function () {
      return arguments.length ? b.apply(a, arguments) : b.call(a);
    };
  }function ae(a, b) {
    var d = b;"string" === typeof a && "$" === a.charAt(0) && "$" === a.charAt(1) ? d = w : Xa(b) ? d = "$WINDOW" : b && W === b ? d = "$DOCUMENT" : Za(b) && (d = "$SCOPE");return d;
  }function cb(a, b) {
    if ("undefined" === typeof a) return w;Q(b) || (b = b ? 2 : null);return JSON.stringify(a, ae, b);
  }function vc(a) {
    return F(a) ? JSON.parse(a) : a;
  }function wc(a, b) {
    var d = Date.parse("Jan 01, 1970 00:00:00 " + a) / 6E4;return isNaN(d) ? b : d;
  }function Rb(a, b, d) {
    d = d ? -1 : 1;var c = wc(b, a.getTimezoneOffset());b = a;a = d * (c - a.getTimezoneOffset());b = new Date(b.getTime());b.setMinutes(b.getMinutes() + a);return b;
  }function ua(a) {
    a = A(a).clone();try {
      a.empty();
    } catch (b) {}var d = A("<div>").append(a).html();try {
      return a[0].nodeType === Na ? K(d) : d.match(/^(<[^>]+>)/)[1].replace(/^<([\w\-]+)/, function (a, b) {
        return "<" + K(b);
      });
    } catch (c) {
      return K(d);
    }
  }function xc(a) {
    try {
      return decodeURIComponent(a);
    } catch (b) {}
  }
  function yc(a) {
    var b = {};n((a || "").split("&"), function (a) {
      var c, e, f;a && (e = a = a.replace(/\+/g, "%20"), c = a.indexOf("="), -1 !== c && (e = a.substring(0, c), f = a.substring(c + 1)), e = xc(e), u(e) && (f = u(f) ? xc(f) : !0, ra.call(b, e) ? E(b[e]) ? b[e].push(f) : b[e] = [b[e], f] : b[e] = f));
    });return b;
  }function Sb(a) {
    var b = [];n(a, function (a, c) {
      E(a) ? n(a, function (a) {
        b.push(ia(c, !0) + (!0 === a ? "" : "=" + ia(a, !0)));
      }) : b.push(ia(c, !0) + (!0 === a ? "" : "=" + ia(a, !0)));
    });return b.length ? b.join("&") : "";
  }function pb(a) {
    return ia(a, !0).replace(/%26/gi, "&").replace(/%3D/gi, "=").replace(/%2B/gi, "+");
  }function ia(a, b) {
    return encodeURIComponent(a).replace(/%40/gi, "@").replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%3B/gi, ";").replace(/%20/g, b ? "%20" : "+");
  }function be(a, b) {
    var d,
        c,
        e = Oa.length;for (c = 0; c < e; ++c) {
      if (d = Oa[c] + b, F(d = a.getAttribute(d))) return d;
    }return null;
  }function ce(a, b) {
    var d,
        c,
        e = {};n(Oa, function (b) {
      b += "app";!d && a.hasAttribute && a.hasAttribute(b) && (d = a, c = a.getAttribute(b));
    });n(Oa, function (b) {
      b += "app";var e;!d && (e = a.querySelector("[" + b.replace(":", "\\:") + "]")) && (d = e, c = e.getAttribute(b));
    });d && (e.strictDi = null !== be(d, "strict-di"), b(d, c ? [c] : [], e));
  }function zc(a, b, d) {
    G(d) || (d = {});d = N({ strictDi: !1 }, d);var c = function c() {
      a = A(a);if (a.injector()) {
        var c = a[0] === W ? "document" : ua(a);throw Ba("btstrpd", c.replace(/</, "&lt;").replace(/>/, "&gt;"));
      }b = b || [];b.unshift(["$provide", function (b) {
        b.value("$rootElement", a);
      }]);d.debugInfoEnabled && b.push(["$compileProvider", function (a) {
        a.debugInfoEnabled(!0);
      }]);b.unshift("ng");c = db(b, d.strictDi);c.invoke(["$rootScope", "$rootElement", "$compile", "$injector", function (a, b, c, d) {
        a.$apply(function () {
          b.data("$injector", d);c(b)(a);
        });
      }]);return c;
    },
        e = /^NG_ENABLE_DEBUG_INFO!/,
        f = /^NG_DEFER_BOOTSTRAP!/;S && e.test(S.name) && (d.debugInfoEnabled = !0, S.name = S.name.replace(e, ""));if (S && !f.test(S.name)) return c();S.name = S.name.replace(f, "");$.resumeBootstrap = function (a) {
      n(a, function (a) {
        b.push(a);
      });return c();
    };B($.resumeDeferredBootstrap) && $.resumeDeferredBootstrap();
  }function de() {
    S.name = "NG_ENABLE_DEBUG_INFO!" + S.name;S.location.reload();
  }
  function ee(a) {
    a = $.element(a).injector();if (!a) throw Ba("test");return a.get("$$testability");
  }function Ac(a, b) {
    b = b || "_";return a.replace(fe, function (a, c) {
      return (c ? b : "") + a.toLowerCase();
    });
  }function ge() {
    var a;if (!Bc) {
      var b = qb();(pa = q(b) ? S.jQuery : b ? S[b] : w) && pa.fn.on ? (A = pa, N(pa.fn, { scope: Pa.scope, isolateScope: Pa.isolateScope, controller: Pa.controller, injector: Pa.injector, inheritedData: Pa.inheritedData }), a = pa.cleanData, pa.cleanData = function (b) {
        var c;if (Tb) Tb = !1;else for (var e = 0, f; null != (f = b[e]); e++) {
          (c = pa._data(f, "events")) && c.$destroy && pa(f).triggerHandler("$destroy");
        }a(b);
      }) : A = P;$.element = A;Bc = !0;
    }
  }function rb(a, b, d) {
    if (!a) throw Ba("areq", b || "?", d || "required");return a;
  }function Qa(a, b, d) {
    d && E(a) && (a = a[a.length - 1]);rb(B(a), b, "not a function, got " + (a && "object" === (typeof a === "undefined" ? "undefined" : _typeof(a)) ? a.constructor.name || "Object" : typeof a === "undefined" ? "undefined" : _typeof(a)));return a;
  }function Ra(a, b) {
    if ("hasOwnProperty" === a) throw Ba("badname", b);
  }function Cc(a, b, d) {
    if (!b) return a;b = b.split(".");for (var c, e = a, f = b.length, g = 0; g < f; g++) {
      c = b[g], a && (a = (e = a)[c]);
    }return !d && B(a) ? uc(e, a) : a;
  }function sb(a) {
    for (var b = a[0], d = a[a.length - 1], c, e = 1; b !== d && (b = b.nextSibling); e++) {
      if (c || a[e] !== b) c || (c = A(sa.call(a, 0, e))), c.push(b);
    }return c || a;
  }function ea() {
    return Object.create(null);
  }function he(a) {
    function b(a, b, c) {
      return a[b] || (a[b] = c());
    }var d = M("$injector"),
        c = M("ng");a = b(a, "angular", Object);a.$$minErr = a.$$minErr || M;return b(a, "module", function () {
      var a = {};return function (f, g, h) {
        if ("hasOwnProperty" === f) throw c("badname", "module");g && a.hasOwnProperty(f) && (a[f] = null);return b(a, f, function () {
          function a(b, d, e, f) {
            f || (f = c);return function () {
              f[e || "push"]([b, d, arguments]);return y;
            };
          }function b(a, d) {
            return function (b, e) {
              e && B(e) && (e.$$moduleName = f);c.push([a, d, arguments]);return y;
            };
          }if (!g) throw d("nomod", f);var c = [],
              e = [],
              t = [],
              C = a("$injector", "invoke", "push", e),
              y = { _invokeQueue: c, _configBlocks: e, _runBlocks: t, requires: g, name: f, provider: b("$provide", "provider"), factory: b("$provide", "factory"), service: b("$provide", "service"), value: a("$provide", "value"), constant: a("$provide", "constant", "unshift"), decorator: b("$provide", "decorator"), animation: b("$animateProvider", "register"), filter: b("$filterProvider", "register"), controller: b("$controllerProvider", "register"), directive: b("$compileProvider", "directive"), config: C, run: function run(a) {
              t.push(a);return this;
            } };h && C(h);return y;
        });
      };
    });
  }function ie(a) {
    N(a, { bootstrap: zc, copy: Ma, extend: N, merge: Yd, equals: ka, element: A, forEach: n, injector: db, noop: z, bind: uc, toJson: cb, fromJson: vc, identity: Ya, isUndefined: q, isDefined: u, isString: F, isFunction: B, isObject: G, isNumber: Q, isElement: Pb, isArray: E,
      version: je, isDate: da, lowercase: K, uppercase: tb, callbacks: { counter: 0 }, getTestability: ee, $$minErr: M, $$csp: Ca, reloadWithDebugInfo: de });Ub = he(S);Ub("ng", ["ngLocale"], ["$provide", function (a) {
      a.provider({ $$sanitizeUri: ke });a.provider("$compile", Dc).directive({ a: le, input: Ec, textarea: Ec, form: me, script: ne, select: oe, style: pe, option: qe, ngBind: re, ngBindHtml: se, ngBindTemplate: te, ngClass: ue, ngClassEven: ve, ngClassOdd: we, ngCloak: xe, ngController: ye, ngForm: ze, ngHide: Ae, ngIf: Be, ngInclude: Ce, ngInit: De, ngNonBindable: Ee,
        ngPluralize: Fe, ngRepeat: Ge, ngShow: He, ngStyle: Ie, ngSwitch: Je, ngSwitchWhen: Ke, ngSwitchDefault: Le, ngOptions: Me, ngTransclude: Ne, ngModel: Oe, ngList: Pe, ngChange: Qe, pattern: Fc, ngPattern: Fc, required: Gc, ngRequired: Gc, minlength: Hc, ngMinlength: Hc, maxlength: Ic, ngMaxlength: Ic, ngValue: Re, ngModelOptions: Se }).directive({ ngInclude: Te }).directive(ub).directive(Jc);a.provider({ $anchorScroll: Ue, $animate: Ve, $animateCss: We, $$animateJs: Xe, $$animateQueue: Ye, $$AnimateRunner: Ze, $$animateAsyncRun: $e, $browser: af, $cacheFactory: bf,
        $controller: cf, $document: df, $exceptionHandler: ef, $filter: Kc, $$forceReflow: ff, $interpolate: gf, $interval: hf, $http: jf, $httpParamSerializer: kf, $httpParamSerializerJQLike: lf, $httpBackend: mf, $xhrFactory: nf, $location: of, $log: pf, $parse: qf, $rootScope: rf, $q: sf, $$q: tf, $sce: uf, $sceDelegate: vf, $sniffer: wf, $templateCache: xf, $templateRequest: yf, $$testability: zf, $timeout: Af, $window: Bf, $$rAF: Cf, $$jqLite: Df, $$HashMap: Ef, $$cookieReader: Ff });
    }]);
  }function eb(a) {
    return a.replace(Gf, function (a, d, c, e) {
      return e ? c.toUpperCase() : c;
    }).replace(Hf, "Moz$1");
  }function Lc(a) {
    a = a.nodeType;return 1 === a || !a || 9 === a;
  }function Mc(a, b) {
    var d,
        c,
        e = b.createDocumentFragment(),
        f = [];if (Vb.test(a)) {
      d = d || e.appendChild(b.createElement("div"));c = (If.exec(a) || ["", ""])[1].toLowerCase();c = ja[c] || ja._default;d.innerHTML = c[1] + a.replace(Jf, "<$1></$2>") + c[2];for (c = c[0]; c--;) {
        d = d.lastChild;
      }f = bb(f, d.childNodes);d = e.firstChild;d.textContent = "";
    } else f.push(b.createTextNode(a));e.textContent = "";e.innerHTML = "";n(f, function (a) {
      e.appendChild(a);
    });return e;
  }function P(a) {
    if (a instanceof P) return a;var b;F(a) && (a = T(a), b = !0);if (!(this instanceof P)) {
      if (b && "<" != a.charAt(0)) throw Wb("nosel");return new P(a);
    }if (b) {
      b = W;var d;a = (d = Kf.exec(a)) ? [b.createElement(d[1])] : (d = Mc(a, b)) ? d.childNodes : [];
    }Nc(this, a);
  }function Xb(a) {
    return a.cloneNode(!0);
  }function vb(a, b) {
    b || wb(a);if (a.querySelectorAll) for (var d = a.querySelectorAll("*"), c = 0, e = d.length; c < e; c++) {
      wb(d[c]);
    }
  }function Oc(a, b, d, c) {
    if (u(c)) throw Wb("offargs");var e = (c = xb(a)) && c.events,
        f = c && c.handle;if (f) if (b) {
      var g = function g(b) {
        var c = e[b];u(d) && ab(c || [], d);u(d) && c && 0 < c.length || (a.removeEventListener(b, f, !1), delete e[b]);
      };n(b.split(" "), function (a) {
        g(a);yb[a] && g(yb[a]);
      });
    } else for (b in e) {
      "$destroy" !== b && a.removeEventListener(b, f, !1), delete e[b];
    }
  }function wb(a, b) {
    var d = a.ng339,
        c = d && fb[d];c && (b ? delete c.data[b] : (c.handle && (c.events.$destroy && c.handle({}, "$destroy"), Oc(a)), delete fb[d], a.ng339 = w));
  }function xb(a, b) {
    var d = a.ng339,
        d = d && fb[d];b && !d && (a.ng339 = d = ++Lf, d = fb[d] = { events: {}, data: {}, handle: w });return d;
  }function Yb(a, b, d) {
    if (Lc(a)) {
      var c = u(d),
          e = !c && b && !G(b),
          f = !b;a = (a = xb(a, !e)) && a.data;if (c) a[b] = d;else {
        if (f) return a;if (e) return a && a[b];N(a, b);
      }
    }
  }function zb(a, b) {
    return a.getAttribute ? -1 < (" " + (a.getAttribute("class") || "") + " ").replace(/[\n\t]/g, " ").indexOf(" " + b + " ") : !1;
  }function Ab(a, b) {
    b && a.setAttribute && n(b.split(" "), function (b) {
      a.setAttribute("class", T((" " + (a.getAttribute("class") || "") + " ").replace(/[\n\t]/g, " ").replace(" " + T(b) + " ", " ")));
    });
  }function Bb(a, b) {
    if (b && a.setAttribute) {
      var d = (" " + (a.getAttribute("class") || "") + " ").replace(/[\n\t]/g, " ");n(b.split(" "), function (a) {
        a = T(a);-1 === d.indexOf(" " + a + " ") && (d += a + " ");
      });a.setAttribute("class", T(d));
    }
  }function Nc(a, b) {
    if (b) if (b.nodeType) a[a.length++] = b;else {
      var d = b.length;if ("number" === typeof d && b.window !== b) {
        if (d) for (var c = 0; c < d; c++) {
          a[a.length++] = b[c];
        }
      } else a[a.length++] = b;
    }
  }function Pc(a, b) {
    return Cb(a, "$" + (b || "ngController") + "Controller");
  }function Cb(a, b, d) {
    9 == a.nodeType && (a = a.documentElement);for (b = E(b) ? b : [b]; a;) {
      for (var c = 0, e = b.length; c < e; c++) {
        if (u(d = A.data(a, b[c]))) return d;
      }a = a.parentNode || 11 === a.nodeType && a.host;
    }
  }function Qc(a) {
    for (vb(a, !0); a.firstChild;) {
      a.removeChild(a.firstChild);
    }
  }function Zb(a, b) {
    b || vb(a);var d = a.parentNode;d && d.removeChild(a);
  }function Mf(a, b) {
    b = b || S;if ("complete" === b.document.readyState) b.setTimeout(a);else A(b).on("load", a);
  }function Rc(a, b) {
    var d = Db[b.toLowerCase()];return d && Sc[oa(a)] && d;
  }function Nf(a, b) {
    var d = function d(c, _d) {
      c.isDefaultPrevented = function () {
        return c.defaultPrevented;
      };var f = b[_d || c.type],
          g = f ? f.length : 0;if (g) {
        if (q(c.immediatePropagationStopped)) {
          var h = c.stopImmediatePropagation;c.stopImmediatePropagation = function () {
            c.immediatePropagationStopped = !0;c.stopPropagation && c.stopPropagation();h && h.call(c);
          };
        }c.isImmediatePropagationStopped = function () {
          return !0 === c.immediatePropagationStopped;
        };var k = f.specialHandlerWrapper || Of;1 < g && (f = ha(f));for (var l = 0; l < g; l++) {
          c.isImmediatePropagationStopped() || k(a, c, f[l]);
        }
      }
    };d.elem = a;return d;
  }function Of(a, b, d) {
    d.call(a, b);
  }function Pf(a, b, d) {
    var c = b.relatedTarget;c && (c === a || Qf.call(a, c)) || d.call(a, b);
  }function Df() {
    this.$get = function () {
      return N(P, { hasClass: function hasClass(a, b) {
          a.attr && (a = a[0]);return zb(a, b);
        }, addClass: function addClass(a, b) {
          a.attr && (a = a[0]);return Bb(a, b);
        }, removeClass: function removeClass(a, b) {
          a.attr && (a = a[0]);return Ab(a, b);
        } });
    };
  }function Da(a, b) {
    var d = a && a.$$hashKey;if (d) return "function" === typeof d && (d = a.$$hashKey()), d;d = typeof a === "undefined" ? "undefined" : _typeof(a);return d = "function" == d || "object" == d && null !== a ? a.$$hashKey = d + ":" + (b || Xd)() : d + ":" + a;
  }function Sa(a, b) {
    if (b) {
      var d = 0;this.nextUid = function () {
        return ++d;
      };
    }n(a, this.put, this);
  }function Rf(a) {
    return (a = a.toString().replace(Tc, "").match(Uc)) ? "function(" + (a[1] || "").replace(/[\s\r\n]+/, " ") + ")" : "fn";
  }function db(a, b) {
    function d(a) {
      return function (b, c) {
        if (G(b)) n(b, qc(a));else return a(b, c);
      };
    }function c(a, b) {
      Ra(a, "service");if (B(b) || E(b)) b = t.instantiate(b);if (!b.$get) throw Ea("pget", a);return r[a + "Provider"] = b;
    }function e(a, b) {
      return function () {
        var c = y.invoke(b, this);if (q(c)) throw Ea("undef", a);return c;
      };
    }function f(a, b, d) {
      return c(a, { $get: !1 !== d ? e(a, b) : b });
    }function g(a) {
      rb(q(a) || E(a), "modulesToLoad", "not an array");var b = [],
          c;
      n(a, function (a) {
        function d(a) {
          var b, c;b = 0;for (c = a.length; b < c; b++) {
            var e = a[b],
                f = t.get(e[0]);f[e[1]].apply(f, e[2]);
          }
        }if (!m.get(a)) {
          m.put(a, !0);try {
            F(a) ? (c = Ub(a), b = b.concat(g(c.requires)).concat(c._runBlocks), d(c._invokeQueue), d(c._configBlocks)) : B(a) ? b.push(t.invoke(a)) : E(a) ? b.push(t.invoke(a)) : Qa(a, "module");
          } catch (e) {
            throw E(a) && (a = a[a.length - 1]), e.message && e.stack && -1 == e.stack.indexOf(e.message) && (e = e.message + "\n" + e.stack), Ea("modulerr", a, e.stack || e.message || e);
          }
        }
      });return b;
    }function h(a, c) {
      function d(b, e) {
        if (a.hasOwnProperty(b)) {
          if (a[b] === k) throw Ea("cdep", b + " <- " + l.join(" <- "));return a[b];
        }try {
          return l.unshift(b), a[b] = k, a[b] = c(b, e);
        } catch (f) {
          throw a[b] === k && delete a[b], f;
        } finally {
          l.shift();
        }
      }function e(a, c, f, g) {
        "string" === typeof f && (g = f, f = null);var k = [],
            h = db.$$annotate(a, b, g),
            l,
            m,
            t;m = 0;for (l = h.length; m < l; m++) {
          t = h[m];if ("string" !== typeof t) throw Ea("itkn", t);k.push(f && f.hasOwnProperty(t) ? f[t] : d(t, g));
        }E(a) && (a = a[l]);return a.apply(c, k);
      }return { invoke: e, instantiate: function instantiate(a, b, c) {
          var d = Object.create((E(a) ? a[a.length - 1] : a).prototype || null);a = e(a, d, b, c);return G(a) || B(a) ? a : d;
        }, get: d, annotate: db.$$annotate, has: function has(b) {
          return r.hasOwnProperty(b + "Provider") || a.hasOwnProperty(b);
        } };
    }b = !0 === b;var k = {},
        l = [],
        m = new Sa([], !0),
        r = { $provide: { provider: d(c), factory: d(f), service: d(function (a, b) {
          return f(a, ["$injector", function (a) {
            return a.instantiate(b);
          }]);
        }), value: d(function (a, b) {
          return f(a, na(b), !1);
        }), constant: d(function (a, b) {
          Ra(a, "constant");r[a] = b;C[a] = b;
        }), decorator: function decorator(a, b) {
          var c = t.get(a + "Provider"),
              d = c.$get;
          c.$get = function () {
            var a = y.invoke(d, c);return y.invoke(b, null, { $delegate: a });
          };
        } } },
        t = r.$injector = h(r, function (a, b) {
      $.isString(b) && l.push(b);throw Ea("unpr", l.join(" <- "));
    }),
        C = {},
        y = C.$injector = h(C, function (a, b) {
      var c = t.get(a + "Provider", b);return y.invoke(c.$get, c, w, a);
    });n(g(a), function (a) {
      a && y.invoke(a);
    });return y;
  }function Ue() {
    var a = !0;this.disableAutoScrolling = function () {
      a = !1;
    };this.$get = ["$window", "$location", "$rootScope", function (b, d, c) {
      function e(a) {
        var b = null;Array.prototype.some.call(a, function (a) {
          if ("a" === oa(a)) return b = a, !0;
        });return b;
      }function f(a) {
        if (a) {
          a.scrollIntoView();var c;c = g.yOffset;B(c) ? c = c() : Pb(c) ? (c = c[0], c = "fixed" !== b.getComputedStyle(c).position ? 0 : c.getBoundingClientRect().bottom) : Q(c) || (c = 0);c && (a = a.getBoundingClientRect().top, b.scrollBy(0, a - c));
        } else b.scrollTo(0, 0);
      }function g(a) {
        a = F(a) ? a : d.hash();var b;a ? (b = h.getElementById(a)) ? f(b) : (b = e(h.getElementsByName(a))) ? f(b) : "top" === a && f(null) : f(null);
      }var h = b.document;a && c.$watch(function () {
        return d.hash();
      }, function (a, b) {
        a === b && "" === a || Mf(function () {
          c.$evalAsync(g);
        });
      });
      return g;
    }];
  }function gb(a, b) {
    if (!a && !b) return "";if (!a) return b;if (!b) return a;E(a) && (a = a.join(" "));E(b) && (b = b.join(" "));return a + " " + b;
  }function Sf(a) {
    F(a) && (a = a.split(" "));var b = ea();n(a, function (a) {
      a.length && (b[a] = !0);
    });return b;
  }function Fa(a) {
    return G(a) ? a : {};
  }function Tf(a, b, d, c) {
    function e(a) {
      try {
        a.apply(null, sa.call(arguments, 1));
      } finally {
        if (y--, 0 === y) for (; R.length;) {
          try {
            R.pop()();
          } catch (b) {
            d.error(b);
          }
        }
      }
    }function f() {
      H = null;g();h();
    }function g() {
      a: {
        try {
          p = m.state;break a;
        } catch (a) {}p = void 0;
      }p = q(p) ? null : p;ka(p, D) && (p = D);D = p;
    }function h() {
      if (v !== k.url() || x !== p) v = k.url(), x = p, n(la, function (a) {
        a(k.url(), p);
      });
    }var k = this,
        l = a.location,
        m = a.history,
        r = a.setTimeout,
        t = a.clearTimeout,
        C = {};k.isMock = !1;var y = 0,
        R = [];k.$$completeOutstandingRequest = e;k.$$incOutstandingRequestCount = function () {
      y++;
    };k.notifyWhenNoOutstandingRequests = function (a) {
      0 === y ? a() : R.push(a);
    };var p,
        x,
        v = l.href,
        Y = b.find("base"),
        H = null;g();x = p;k.url = function (b, d, e) {
      q(e) && (e = null);l !== a.location && (l = a.location);m !== a.history && (m = a.history);if (b) {
        var f = x === e;if (v === b && (!c.history || f)) return k;var h = v && Ga(v) === Ga(b);v = b;x = e;if (!c.history || h && f) {
          if (!h || H) H = b;d ? l.replace(b) : h ? (d = l, e = b.indexOf("#"), e = -1 === e ? "" : b.substr(e), d.hash = e) : l.href = b;l.href !== b && (H = b);
        } else m[d ? "replaceState" : "pushState"](e, "", b), g(), x = p;return k;
      }return H || l.href.replace(/%27/g, "'");
    };k.state = function () {
      return p;
    };var la = [],
        I = !1,
        D = null;k.onUrlChange = function (b) {
      if (!I) {
        if (c.history) A(a).on("popstate", f);A(a).on("hashchange", f);I = !0;
      }la.push(b);return b;
    };k.$$applicationDestroyed = function () {
      A(a).off("hashchange popstate", f);
    };k.$$checkUrlChange = h;k.baseHref = function () {
      var a = Y.attr("href");return a ? a.replace(/^(https?\:)?\/\/[^\/]*/, "") : "";
    };k.defer = function (a, b) {
      var c;y++;c = r(function () {
        delete C[c];e(a);
      }, b || 0);C[c] = !0;return c;
    };k.defer.cancel = function (a) {
      return C[a] ? (delete C[a], t(a), e(z), !0) : !1;
    };
  }function af() {
    this.$get = ["$window", "$log", "$sniffer", "$document", function (a, b, d, c) {
      return new Tf(a, c, b, d);
    }];
  }function bf() {
    this.$get = function () {
      function a(a, c) {
        function e(a) {
          a != r && (t ? t == a && (t = a.n) : t = a, f(a.n, a.p), f(a, r), r = a, r.n = null);
        }function f(a, b) {
          a != b && (a && (a.p = b), b && (b.n = a));
        }if (a in b) throw M("$cacheFactory")("iid", a);var g = 0,
            h = N({}, c, { id: a }),
            k = ea(),
            l = c && c.capacity || Number.MAX_VALUE,
            m = ea(),
            r = null,
            t = null;return b[a] = { put: function put(a, b) {
            if (!q(b)) {
              if (l < Number.MAX_VALUE) {
                var c = m[a] || (m[a] = { key: a });e(c);
              }a in k || g++;k[a] = b;g > l && this.remove(t.key);return b;
            }
          }, get: function get(a) {
            if (l < Number.MAX_VALUE) {
              var b = m[a];if (!b) return;e(b);
            }return k[a];
          }, remove: function remove(a) {
            if (l < Number.MAX_VALUE) {
              var b = m[a];if (!b) return;b == r && (r = b.p);b == t && (t = b.n);f(b.n, b.p);delete m[a];
            }a in k && (delete k[a], g--);
          }, removeAll: function removeAll() {
            k = ea();g = 0;m = ea();r = t = null;
          }, destroy: function destroy() {
            m = h = k = null;delete b[a];
          }, info: function info() {
            return N({}, h, { size: g });
          } };
      }var b = {};a.info = function () {
        var a = {};n(b, function (b, e) {
          a[e] = b.info();
        });return a;
      };a.get = function (a) {
        return b[a];
      };return a;
    };
  }function xf() {
    this.$get = ["$cacheFactory", function (a) {
      return a("templates");
    }];
  }function Dc(a, b) {
    function d(a, b, c) {
      var d = /^\s*([@&]|=(\*?))(\??)\s*(\w*)\s*$/,
          e = {};n(a, function (a, f) {
        var g = a.match(d);
        if (!g) throw ga("iscp", b, f, a, c ? "controller bindings definition" : "isolate scope definition");e[f] = { mode: g[1][0], collection: "*" === g[2], optional: "?" === g[3], attrName: g[4] || f };
      });return e;
    }function c(a) {
      var b = a.charAt(0);if (!b || b !== K(b)) throw ga("baddir", a);if (a !== a.trim()) throw ga("baddir", a);
    }var e = {},
        f = /^\s*directive\:\s*([\w\-]+)\s+(.*)$/,
        g = /(([\w\-]+)(?:\:([^;]+))?;?)/,
        h = $d("ngSrc,ngSrcset,src,srcset"),
        k = /^(?:(\^\^?)?(\?)?(\^\^?)?)?/,
        l = /^(on[a-z]+|formaction)$/;this.directive = function t(b, f) {
      Ra(b, "directive");
      F(b) ? (c(b), rb(f, "directiveFactory"), e.hasOwnProperty(b) || (e[b] = [], a.factory(b + "Directive", ["$injector", "$exceptionHandler", function (a, c) {
        var f = [];n(e[b], function (e, g) {
          try {
            var h = a.invoke(e);B(h) ? h = { compile: na(h) } : !h.compile && h.link && (h.compile = na(h.link));h.priority = h.priority || 0;h.index = g;h.name = h.name || b;h.require = h.require || h.controller && h.name;h.restrict = h.restrict || "EA";var k = h,
                l = h,
                m = h.name,
                t = { isolateScope: null, bindToController: null };G(l.scope) && (!0 === l.bindToController ? (t.bindToController = d(l.scope, m, !0), t.isolateScope = {}) : t.isolateScope = d(l.scope, m, !1));G(l.bindToController) && (t.bindToController = d(l.bindToController, m, !0));if (G(t.bindToController)) {
              var y = l.controller,
                  X = l.controllerAs;if (!y) throw ga("noctrl", m);var U;a: if (X && F(X)) U = X;else {
                if (F(y)) {
                  var n = Vc.exec(y);if (n) {
                    U = n[3];break a;
                  }
                }U = void 0;
              }if (!U) throw ga("noident", m);
            }var s = k.$$bindings = t;G(s.isolateScope) && (h.$$isolateBindings = s.isolateScope);h.$$moduleName = e.$$moduleName;f.push(h);
          } catch (w) {
            c(w);
          }
        });return f;
      }])), e[b].push(f)) : n(b, qc(t));
      return this;
    };this.aHrefSanitizationWhitelist = function (a) {
      return u(a) ? (b.aHrefSanitizationWhitelist(a), this) : b.aHrefSanitizationWhitelist();
    };this.imgSrcSanitizationWhitelist = function (a) {
      return u(a) ? (b.imgSrcSanitizationWhitelist(a), this) : b.imgSrcSanitizationWhitelist();
    };var m = !0;this.debugInfoEnabled = function (a) {
      return u(a) ? (m = a, this) : m;
    };this.$get = ["$injector", "$interpolate", "$exceptionHandler", "$templateRequest", "$parse", "$controller", "$rootScope", "$sce", "$animate", "$$sanitizeUri", function (a, b, c, d, p, x, v, Y, H, la) {
      function I(a, b) {
        try {
          a.addClass(b);
        } catch (c) {}
      }function D(a, b, c, d, e) {
        a instanceof A || (a = A(a));n(a, function (b, c) {
          b.nodeType == Na && b.nodeValue.match(/\S+/) && (a[c] = A(b).wrap("<span></span>").parent()[0]);
        });var f = L(a, b, a, c, d, e);D.$$addScopeClass(a);var g = null;return function (b, c, d) {
          rb(b, "scope");e && e.needsNewScope && (b = b.$parent.$new());d = d || {};var h = d.parentBoundTranscludeFn,
              k = d.transcludeControllers;d = d.futureParentElement;h && h.$$boundTransclude && (h = h.$$boundTransclude);g || (g = (d = d && d[0]) ? "foreignobject" !== oa(d) && d.toString().match(/SVG/) ? "svg" : "html" : "html");d = "html" !== g ? A(Q(g, A("<div>").append(a).html())) : c ? Pa.clone.call(a) : a;if (k) for (var l in k) {
            d.data("$" + l + "Controller", k[l].instance);
          }D.$$addScopeInfo(d, b);c && c(d, b);f && f(b, d, d, h);return d;
        };
      }function L(a, b, c, d, e, f) {
        function g(a, c, d, e) {
          var f, k, l, m, t, v, I;if (p) for (I = Array(c.length), m = 0; m < h.length; m += 3) {
            f = h[m], I[f] = c[f];
          } else I = c;m = 0;for (t = h.length; m < t;) {
            k = I[h[m++]], c = h[m++], f = h[m++], c ? (c.scope ? (l = a.$new(), D.$$addScopeInfo(A(k), l)) : l = a, v = c.transcludeOnThisElement ? O(a, c.transclude, e) : !c.templateOnThisElement && e ? e : !e && b ? O(a, b) : null, c(f, l, k, d, v)) : f && f(a, k.childNodes, w, e);
          }
        }for (var h = [], k, l, m, t, p, v = 0; v < a.length; v++) {
          k = new aa();l = X(a[v], [], k, 0 === v ? d : w, e);(f = l.length ? s(l, a[v], k, b, c, null, [], [], f) : null) && f.scope && D.$$addScopeClass(k.$$element);k = f && f.terminal || !(m = a[v].childNodes) || !m.length ? null : L(m, f ? (f.transcludeOnThisElement || !f.templateOnThisElement) && f.transclude : b);if (f || k) h.push(v, f, k), t = !0, p = p || f;f = null;
        }return t ? g : null;
      }function O(a, b, c) {
        return function (d, e, f, g, h) {
          d || (d = a.$new(!1, h), d.$$transcluded = !0);return b(d, e, { parentBoundTranscludeFn: c, transcludeControllers: f, futureParentElement: g });
        };
      }function X(a, b, c, d, e) {
        var h = c.$attr,
            k;switch (a.nodeType) {case 1:
            u(b, va(oa(a)), "E", d, e);for (var l, m, t, p = a.attributes, v = 0, I = p && p.length; v < I; v++) {
              var L = !1,
                  C = !1;l = p[v];k = l.name;m = T(l.value);l = va(k);if (t = ia.test(l)) k = k.replace(Yc, "").substr(8).replace(/_(.)/g, function (a, b) {
                return b.toUpperCase();
              });(l = l.match(ja)) && fa(l[1]) && (L = k, C = k.substr(0, k.length - 5) + "end", k = k.substr(0, k.length - 6));l = va(k.toLowerCase());h[l] = k;if (t || !c.hasOwnProperty(l)) c[l] = m, Rc(a, l) && (c[l] = !0);P(a, b, m, l, t);u(b, l, "A", d, e, L, C);
            }a = a.className;G(a) && (a = a.animVal);if (F(a) && "" !== a) for (; k = g.exec(a);) {
              l = va(k[2]), u(b, l, "C", d, e) && (c[l] = T(k[3])), a = a.substr(k.index + k[0].length);
            }break;case Na:
            if (11 === Ha) for (; a.parentNode && a.nextSibling && a.nextSibling.nodeType === Na;) {
              a.nodeValue += a.nextSibling.nodeValue, a.parentNode.removeChild(a.nextSibling);
            }J(b, a.nodeValue);break;case 8:
            try {
              if (k = f.exec(a.nodeValue)) l = va(k[1]), u(b, l, "M", d, e) && (c[l] = T(k[2]));
            } catch (X) {}}b.sort(wa);return b;
      }function U(a, b, c) {
        var d = [],
            e = 0;if (b && a.hasAttribute && a.hasAttribute(b)) {
          do {
            if (!a) throw ga("uterdir", b, c);1 == a.nodeType && (a.hasAttribute(b) && e++, a.hasAttribute(c) && e--);d.push(a);a = a.nextSibling;
          } while (0 < e);
        } else d.push(a);return A(d);
      }function Ta(a, b, c) {
        return function (d, e, f, g, h) {
          e = U(e[0], b, c);return a(d, e, f, g, h);
        };
      }function s(a, b, d, e, f, g, h, l, m) {
        function t(a, b, c, d) {
          if (a) {
            c && (a = Ta(a, c, d));a.require = q.require;a.directiveName = z;if (O === q || q.$$isolateScope) a = ba(a, { isolateScope: !0 });h.push(a);
          }if (b) {
            c && (b = Ta(b, c, d));b.require = q.require;b.directiveName = z;if (O === q || q.$$isolateScope) b = ba(b, { isolateScope: !0 });l.push(b);
          }
        }function p(a, b, c, d) {
          var e;if (F(b)) {
            var f = b.match(k);b = b.substring(f[0].length);var g = f[1] || f[3],
                f = "?" === f[2];"^^" === g ? c = c.parent() : e = (e = d && d[b]) && e.instance;e || (d = "$" + b + "Controller", e = g ? c.inheritedData(d) : c.data(d));if (!e && !f) throw ga("ctreq", b, a);
          } else if (E(b)) for (e = [], g = 0, f = b.length; g < f; g++) {
            e[g] = p(a, b[g], c, d);
          }return e || null;
        }function v(a, b, c, d, e, f) {
          var g = ea(),
              h;for (h in d) {
            var k = d[h],
                l = { $scope: k === O || k.$$isolateScope ? e : f, $element: a, $attrs: b, $transclude: c },
                m = k.controller;"@" == m && (m = b[k.name]);l = x(m, l, !0, k.controllerAs);g[k.name] = l;hb || a.data("$" + k.name + "Controller", l.instance);
          }return g;
        }function I(a, c, e, f, g) {
          function k(a, b, c) {
            var d;Za(a) || (c = b, b = a, a = w);hb && (d = X);c || (c = hb ? x.parent() : x);return g(a, b, d, c, Ta);
          }var m, t, L, X, y, x, U;b === e ? (f = d, x = d.$$element) : (x = A(e), f = new aa(x, d));L = c;O ? t = c.$new(!0) : C && (L = c.$parent);g && (y = k, y.$$boundTransclude = g);R && (X = v(x, f, y, R, t, c));O && (D.$$addScopeInfo(x, t, !0, !(n && (n === O || n === O.$$originalDirective))), D.$$addScopeClass(x, !0), t.$$isolateBindings = O.$$isolateBindings, (U = Z(c, f, t, t.$$isolateBindings, O)) && t.$on("$destroy", U));for (var Xc in X) {
            U = R[Xc];var Y = X[Xc],
                H = U.$$bindings.bindToController;Y.identifier && H && (m = Z(L, f, Y.instance, H, U));var q = Y();q !== Y.instance && (Y.instance = q, x.data("$" + U.name + "Controller", q), m && m(), m = Z(L, f, Y.instance, H, U));
          }fa = 0;for (K = h.length; fa < K; fa++) {
            m = h[fa], ca(m, m.isolateScope ? t : c, x, f, m.require && p(m.directiveName, m.require, x, X), y);
          }var Ta = c;O && (O.template || null === O.templateUrl) && (Ta = t);a && a(Ta, e.childNodes, w, g);for (fa = l.length - 1; 0 <= fa; fa--) {
            m = l[fa], ca(m, m.isolateScope ? t : c, x, f, m.require && p(m.directiveName, m.require, x, X), y);
          }
        }m = m || {};for (var L = -Number.MAX_VALUE, C = m.newScopeDirective, R = m.controllerDirectives, O = m.newIsolateScopeDirective, n = m.templateDirective, Y = m.nonTlbTranscludeDirective, H = !1, la = !1, hb = m.hasElementTranscludeDirective, u = d.$$element = A(b), q, z, J, ib = e, wa, fa = 0, K = a.length; fa < K; fa++) {
          q = a[fa];var N = q.$$start,
              P = q.$$end;N && (u = U(b, N, P));J = w;if (L > q.priority) break;if (J = q.scope) q.templateUrl || (G(J) ? (Ua("new/isolated scope", O || C, q, u), O = q) : Ua("new/isolated scope", O, q, u)), C = C || q;z = q.name;!q.templateUrl && q.controller && (J = q.controller, R = R || ea(), Ua("'" + z + "' controller", R[z], q, u), R[z] = q);if (J = q.transclude) H = !0, q.$$tlb || (Ua("transclusion", Y, q, u), Y = q), "element" == J ? (hb = !0, L = q.priority, J = u, u = d.$$element = A(W.createComment(" " + z + ": " + d[z] + " ")), b = u[0], V(f, sa.call(J, 0), b), ib = D(J, e, L, g && g.name, { nonTlbTranscludeDirective: Y })) : (J = A(Xb(b)).contents(), u.empty(), ib = D(J, e, w, w, { needsNewScope: q.$$isolateScope || q.$$newScope }));if (q.template) if (la = !0, Ua("template", n, q, u), n = q, J = B(q.template) ? q.template(u, d) : q.template, J = ha(J), q.replace) {
            g = q;J = Vb.test(J) ? Zc(Q(q.templateNamespace, T(J))) : [];b = J[0];if (1 != J.length || 1 !== b.nodeType) throw ga("tplrt", z, "");V(f, u, b);J = { $attr: {} };var Eb = X(b, [], J),
                $ = a.splice(fa + 1, a.length - (fa + 1));(O || C) && Wc(Eb, O, C);a = a.concat(Eb).concat($);M(d, J);K = a.length;
          } else u.html(J);if (q.templateUrl) la = !0, Ua("template", n, q, u), n = q, q.replace && (g = q), I = S(a.splice(fa, a.length - fa), u, d, f, H && ib, h, l, { controllerDirectives: R, newScopeDirective: C !== q && C, newIsolateScopeDirective: O, templateDirective: n, nonTlbTranscludeDirective: Y }), K = a.length;else if (q.compile) try {
            wa = q.compile(u, d, ib), B(wa) ? t(null, wa, N, P) : wa && t(wa.pre, wa.post, N, P);
          } catch (da) {
            c(da, ua(u));
          }q.terminal && (I.terminal = !0, L = Math.max(L, q.priority));
        }I.scope = C && !0 === C.scope;I.transcludeOnThisElement = H;I.templateOnThisElement = la;I.transclude = ib;m.hasElementTranscludeDirective = hb;return I;
      }function Wc(a, b, c) {
        for (var d = 0, e = a.length; d < e; d++) {
          a[d] = Qb(a[d], { $$isolateScope: b, $$newScope: c });
        }
      }function u(b, d, f, g, h, k, l) {
        if (d === h) return null;h = null;if (e.hasOwnProperty(d)) {
          var m;d = a.get(d + "Directive");for (var p = 0, v = d.length; p < v; p++) {
            try {
              m = d[p], (q(g) || g > m.priority) && -1 != m.restrict.indexOf(f) && (k && (m = Qb(m, { $$start: k, $$end: l })), b.push(m), h = m);
            } catch (I) {
              c(I);
            }
          }
        }return h;
      }function fa(b) {
        if (e.hasOwnProperty(b)) for (var c = a.get(b + "Directive"), d = 0, f = c.length; d < f; d++) {
          if (b = c[d], b.multiElement) return !0;
        }return !1;
      }function M(a, b) {
        var c = b.$attr,
            d = a.$attr,
            e = a.$$element;n(a, function (d, e) {
          "$" != e.charAt(0) && (b[e] && b[e] !== d && (d += ("style" === e ? ";" : " ") + b[e]), a.$set(e, d, !0, c[e]));
        });n(b, function (b, f) {
          "class" == f ? (I(e, b), a["class"] = (a["class"] ? a["class"] + " " : "") + b) : "style" == f ? (e.attr("style", e.attr("style") + ";" + b), a.style = (a.style ? a.style + ";" : "") + b) : "$" == f.charAt(0) || a.hasOwnProperty(f) || (a[f] = b, d[f] = c[f]);
        });
      }function S(a, b, c, e, f, g, h, k) {
        var l = [],
            m,
            t,
            p = b[0],
            v = a.shift(),
            C = Qb(v, { templateUrl: null, transclude: null, replace: null,
          $$originalDirective: v }),
            x = B(v.templateUrl) ? v.templateUrl(b, c) : v.templateUrl,
            y = v.templateNamespace;b.empty();d(x).then(function (d) {
          var R, D;d = ha(d);if (v.replace) {
            d = Vb.test(d) ? Zc(Q(y, T(d))) : [];R = d[0];if (1 != d.length || 1 !== R.nodeType) throw ga("tplrt", v.name, x);d = { $attr: {} };V(e, b, R);var U = X(R, [], d);G(v.scope) && Wc(U, !0);a = U.concat(a);M(c, d);
          } else R = p, b.html(d);a.unshift(C);m = s(a, R, c, f, b, v, g, h, k);n(e, function (a, c) {
            a == R && (e[c] = b[0]);
          });for (t = L(b[0].childNodes, f); l.length;) {
            d = l.shift();D = l.shift();var Y = l.shift(),
                H = l.shift(),
                U = b[0];if (!d.$$destroyed) {
              if (D !== p) {
                var q = D.className;k.hasElementTranscludeDirective && v.replace || (U = Xb(R));V(Y, A(D), U);I(A(U), q);
              }D = m.transcludeOnThisElement ? O(d, m.transclude, H) : H;m(t, d, U, e, D);
            }
          }l = null;
        });return function (a, b, c, d, e) {
          a = e;b.$$destroyed || (l ? l.push(b, c, d, a) : (m.transcludeOnThisElement && (a = O(b, m.transclude, e)), m(t, b, c, d, a)));
        };
      }function wa(a, b) {
        var c = b.priority - a.priority;return 0 !== c ? c : a.name !== b.name ? a.name < b.name ? -1 : 1 : a.index - b.index;
      }function Ua(a, b, c, d) {
        function e(a) {
          return a ? " (module: " + a + ")" : "";
        }if (b) throw ga("multidir", b.name, e(b.$$moduleName), c.name, e(c.$$moduleName), a, ua(d));
      }function J(a, c) {
        var d = b(c, !0);d && a.push({ priority: 0, compile: function compile(a) {
            a = a.parent();var b = !!a.length;b && D.$$addBindingClass(a);return function (a, c) {
              var e = c.parent();b || D.$$addBindingClass(e);D.$$addBindingInfo(e, d.expressions);a.$watch(d, function (a) {
                c[0].nodeValue = a;
              });
            };
          } });
      }function Q(a, b) {
        a = K(a || "html");switch (a) {case "svg":case "math":
            var c = W.createElement("div");c.innerHTML = "<" + a + ">" + b + "</" + a + ">";return c.childNodes[0].childNodes;default:
            return b;}
      }function Eb(a, b) {
        if ("srcdoc" == b) return Y.HTML;var c = oa(a);if ("xlinkHref" == b || "form" == c && "action" == b || "img" != c && ("src" == b || "ngSrc" == b)) return Y.RESOURCE_URL;
      }function P(a, c, d, e, f) {
        var g = Eb(a, e);f = h[e] || f;var k = b(d, !0, g, f);if (k) {
          if ("multiple" === e && "select" === oa(a)) throw ga("selmulti", ua(a));c.push({ priority: 100, compile: function compile() {
              return { pre: function pre(a, c, h) {
                  c = h.$$observers || (h.$$observers = ea());if (l.test(e)) throw ga("nodomevents");var m = h[e];m !== d && (k = m && b(m, !0, g, f), d = m);k && (h[e] = k(a), (c[e] || (c[e] = [])).$$inter = !0, (h.$$observers && h.$$observers[e].$$scope || a).$watch(k, function (a, b) {
                    "class" === e && a != b ? h.$updateClass(a, b) : h.$set(e, a);
                  }));
                } };
            } });
        }
      }function V(a, b, c) {
        var d = b[0],
            e = b.length,
            f = d.parentNode,
            g,
            h;if (a) for (g = 0, h = a.length; g < h; g++) {
          if (a[g] == d) {
            a[g++] = c;h = g + e - 1;for (var k = a.length; g < k; g++, h++) {
              h < k ? a[g] = a[h] : delete a[g];
            }a.length -= e - 1;a.context === d && (a.context = c);break;
          }
        }f && f.replaceChild(c, d);a = W.createDocumentFragment();a.appendChild(d);A.hasData(d) && (A.data(c, A.data(d)), pa ? (Tb = !0, pa.cleanData([d])) : delete A.cache[d[A.expando]]);d = 1;for (e = b.length; d < e; d++) {
          f = b[d], A(f).remove(), a.appendChild(f), delete b[d];
        }b[0] = c;b.length = 1;
      }function ba(a, b) {
        return N(function () {
          return a.apply(null, arguments);
        }, a, b);
      }function ca(a, b, d, e, f, g) {
        try {
          a(b, d, e, f, g);
        } catch (h) {
          c(h, ua(d));
        }
      }function Z(a, c, d, e, f) {
        var g = [];n(e, function (e, h) {
          var k = e.attrName,
              l = e.optional,
              m,
              t,
              v,
              I;switch (e.mode) {case "@":
              l || ra.call(c, k) || (d[h] = c[k] = void 0);c.$observe(k, function (a) {
                F(a) && (d[h] = a);
              });
              c.$$observers[k].$$scope = a;F(c[k]) && (d[h] = b(c[k])(a));break;case "=":
              if (!ra.call(c, k)) {
                if (l) break;c[k] = void 0;
              }if (l && !c[k]) break;t = p(c[k]);I = t.literal ? ka : function (a, b) {
                return a === b || a !== a && b !== b;
              };v = t.assign || function () {
                m = d[h] = t(a);throw ga("nonassign", c[k], f.name);
              };m = d[h] = t(a);l = function l(b) {
                I(b, d[h]) || (I(b, m) ? v(a, b = d[h]) : d[h] = b);return m = b;
              };l.$stateful = !0;l = e.collection ? a.$watchCollection(c[k], l) : a.$watch(p(c[k], l), null, t.literal);g.push(l);break;case "&":
              t = c.hasOwnProperty(k) ? p(c[k]) : z;if (t === z && l) break;d[h] = function (b) {
                return t(a, b);
              };}
        });return g.length && function () {
          for (var a = 0, b = g.length; a < b; ++a) {
            g[a]();
          }
        };
      }var aa = function aa(a, b) {
        if (b) {
          var c = Object.keys(b),
              d,
              e,
              f;d = 0;for (e = c.length; d < e; d++) {
            f = c[d], this[f] = b[f];
          }
        } else this.$attr = {};this.$$element = a;
      };aa.prototype = { $normalize: va, $addClass: function $addClass(a) {
          a && 0 < a.length && H.addClass(this.$$element, a);
        }, $removeClass: function $removeClass(a) {
          a && 0 < a.length && H.removeClass(this.$$element, a);
        }, $updateClass: function $updateClass(a, b) {
          var c = $c(a, b);c && c.length && H.addClass(this.$$element, c);(c = $c(b, a)) && c.length && H.removeClass(this.$$element, c);
        }, $set: function $set(a, b, d, e) {
          var f = Rc(this.$$element[0], a),
              g = ad[a],
              h = a;f ? (this.$$element.prop(a, b), e = f) : g && (this[g] = b, h = g);this[a] = b;e ? this.$attr[a] = e : (e = this.$attr[a]) || (this.$attr[a] = e = Ac(a, "-"));f = oa(this.$$element);if ("a" === f && "href" === a || "img" === f && "src" === a) this[a] = b = la(b, "src" === a);else if ("img" === f && "srcset" === a) {
            for (var f = "", g = T(b), k = /(\s+\d+x\s*,|\s+\d+w\s*,|\s+,|,\s+)/, k = /\s/.test(g) ? k : /(,)/, g = g.split(k), k = Math.floor(g.length / 2), l = 0; l < k; l++) {
              var m = 2 * l,
                  f = f + la(T(g[m]), !0),
                  f = f + (" " + T(g[m + 1]));
            }g = T(g[2 * l]).split(/\s/);f += la(T(g[0]), !0);2 === g.length && (f += " " + T(g[1]));this[a] = b = f;
          }!1 !== d && (null === b || q(b) ? this.$$element.removeAttr(e) : this.$$element.attr(e, b));(a = this.$$observers) && n(a[h], function (a) {
            try {
              a(b);
            } catch (d) {
              c(d);
            }
          });
        }, $observe: function $observe(a, b) {
          var c = this,
              d = c.$$observers || (c.$$observers = ea()),
              e = d[a] || (d[a] = []);e.push(b);v.$evalAsync(function () {
            e.$$inter || !c.hasOwnProperty(a) || q(c[a]) || b(c[a]);
          });return function () {
            ab(e, b);
          };
        } };var $ = b.startSymbol(),
          da = b.endSymbol(),
          ha = "{{" == $ || "}}" == da ? Ya : function (a) {
        return a.replace(/\{\{/g, $).replace(/}}/g, da);
      },
          ia = /^ngAttr[A-Z]/,
          ja = /^(.+)Start$/;D.$$addBindingInfo = m ? function (a, b) {
        var c = a.data("$binding") || [];E(b) ? c = c.concat(b) : c.push(b);a.data("$binding", c);
      } : z;D.$$addBindingClass = m ? function (a) {
        I(a, "ng-binding");
      } : z;D.$$addScopeInfo = m ? function (a, b, c, d) {
        a.data(c ? d ? "$isolateScopeNoTemplate" : "$isolateScope" : "$scope", b);
      } : z;D.$$addScopeClass = m ? function (a, b) {
        I(a, b ? "ng-isolate-scope" : "ng-scope");
      } : z;return D;
    }];
  }function va(a) {
    return eb(a.replace(Yc, ""));
  }function $c(a, b) {
    var d = "",
        c = a.split(/\s+/),
        e = b.split(/\s+/),
        f = 0;a: for (; f < c.length; f++) {
      for (var g = c[f], h = 0; h < e.length; h++) {
        if (g == e[h]) continue a;
      }d += (0 < d.length ? " " : "") + g;
    }return d;
  }function Zc(a) {
    a = A(a);var b = a.length;if (1 >= b) return a;for (; b--;) {
      8 === a[b].nodeType && Uf.call(a, b, 1);
    }return a;
  }function cf() {
    var a = {},
        b = !1;this.register = function (b, c) {
      Ra(b, "controller");G(b) ? N(a, b) : a[b] = c;
    };this.allowGlobals = function () {
      b = !0;
    };this.$get = ["$injector", "$window", function (d, c) {
      function e(a, b, c, d) {
        if (!a || !G(a.$scope)) throw M("$controller")("noscp", d, b);a.$scope[b] = c;
      }return function (f, g, h, k) {
        var l, m, r;h = !0 === h;k && F(k) && (r = k);if (F(f)) {
          k = f.match(Vc);if (!k) throw Vf("ctrlfmt", f);m = k[1];r = r || k[3];f = a.hasOwnProperty(m) ? a[m] : Cc(g.$scope, m, !0) || (b ? Cc(c, m, !0) : w);Qa(f, m, !0);
        }if (h) return h = (E(f) ? f[f.length - 1] : f).prototype, l = Object.create(h || null), r && e(g, r, l, m || f.name), N(function () {
          var a = d.invoke(f, l, g, m);a !== l && (G(a) || B(a)) && (l = a, r && e(g, r, l, m || f.name));return l;
        }, { instance: l, identifier: r });l = d.instantiate(f, g, m);r && e(g, r, l, m || f.name);return l;
      };
    }];
  }function df() {
    this.$get = ["$window", function (a) {
      return A(a.document);
    }];
  }function ef() {
    this.$get = ["$log", function (a) {
      return function (b, d) {
        a.error.apply(a, arguments);
      };
    }];
  }function $b(a) {
    return G(a) ? da(a) ? a.toISOString() : cb(a) : a;
  }function kf() {
    this.$get = function () {
      return function (a) {
        if (!a) return "";var b = [];pc(a, function (a, c) {
          null === a || q(a) || (E(a) ? n(a, function (a, d) {
            b.push(ia(c) + "=" + ia($b(a)));
          }) : b.push(ia(c) + "=" + ia($b(a))));
        });return b.join("&");
      };
    };
  }function lf() {
    this.$get = function () {
      return function (a) {
        function b(a, e, f) {
          null === a || q(a) || (E(a) ? n(a, function (a, c) {
            b(a, e + "[" + (G(a) ? c : "") + "]");
          }) : G(a) && !da(a) ? pc(a, function (a, c) {
            b(a, e + (f ? "" : "[") + c + (f ? "" : "]"));
          }) : d.push(ia(e) + "=" + ia($b(a))));
        }if (!a) return "";var d = [];b(a, "", !0);return d.join("&");
      };
    };
  }function ac(a, b) {
    if (F(a)) {
      var d = a.replace(Wf, "").trim();if (d) {
        var c = b("Content-Type");(c = c && 0 === c.indexOf(bd)) || (c = (c = d.match(Xf)) && Yf[c[0]].test(d));c && (a = vc(d));
      }
    }return a;
  }function cd(a) {
    var b = ea(),
        d;F(a) ? n(a.split("\n"), function (a) {
      d = a.indexOf(":");var e = K(T(a.substr(0, d)));a = T(a.substr(d + 1));e && (b[e] = b[e] ? b[e] + ", " + a : a);
    }) : G(a) && n(a, function (a, d) {
      var f = K(d),
          g = T(a);f && (b[f] = b[f] ? b[f] + ", " + g : g);
    });return b;
  }function dd(a) {
    var b;return function (d) {
      b || (b = cd(a));return d ? (d = b[K(d)], void 0 === d && (d = null), d) : b;
    };
  }function ed(a, b, d, c) {
    if (B(c)) return c(a, b, d);n(c, function (c) {
      a = c(a, b, d);
    });return a;
  }function jf() {
    var a = this.defaults = { transformResponse: [ac], transformRequest: [function (a) {
        return G(a) && "[object File]" !== ta.call(a) && "[object Blob]" !== ta.call(a) && "[object FormData]" !== ta.call(a) ? cb(a) : a;
      }], headers: { common: { Accept: "application/json, text/plain, */*" },
        post: ha(bc), put: ha(bc), patch: ha(bc) }, xsrfCookieName: "XSRF-TOKEN", xsrfHeaderName: "X-XSRF-TOKEN", paramSerializer: "$httpParamSerializer" },
        b = !1;this.useApplyAsync = function (a) {
      return u(a) ? (b = !!a, this) : b;
    };var d = !0;this.useLegacyPromiseExtensions = function (a) {
      return u(a) ? (d = !!a, this) : d;
    };var c = this.interceptors = [];this.$get = ["$httpBackend", "$$cookieReader", "$cacheFactory", "$rootScope", "$q", "$injector", function (e, f, g, h, k, l) {
      function m(b) {
        function c(a) {
          var b = N({}, a);b.data = ed(a.data, a.headers, a.status, f.transformResponse);
          a = a.status;return 200 <= a && 300 > a ? b : k.reject(b);
        }function e(a, b) {
          var c,
              d = {};n(a, function (a, e) {
            B(a) ? (c = a(b), null != c && (d[e] = c)) : d[e] = a;
          });return d;
        }if (!$.isObject(b)) throw M("$http")("badreq", b);if (!F(b.url)) throw M("$http")("badreq", b.url);var f = N({ method: "get", transformRequest: a.transformRequest, transformResponse: a.transformResponse, paramSerializer: a.paramSerializer }, b);f.headers = function (b) {
          var c = a.headers,
              d = N({}, b.headers),
              f,
              g,
              h,
              c = N({}, c.common, c[K(b.method)]);a: for (f in c) {
            g = K(f);for (h in d) {
              if (K(h) === g) continue a;
            }d[f] = c[f];
          }return e(d, ha(b));
        }(b);f.method = tb(f.method);f.paramSerializer = F(f.paramSerializer) ? l.get(f.paramSerializer) : f.paramSerializer;var g = [function (b) {
          var d = b.headers,
              e = ed(b.data, dd(d), w, b.transformRequest);q(e) && n(d, function (a, b) {
            "content-type" === K(b) && delete d[b];
          });q(b.withCredentials) && !q(a.withCredentials) && (b.withCredentials = a.withCredentials);return r(b, e).then(c, c);
        }, w],
            h = k.when(f);for (n(y, function (a) {
          (a.request || a.requestError) && g.unshift(a.request, a.requestError);(a.response || a.responseError) && g.push(a.response, a.responseError);
        }); g.length;) {
          b = g.shift();var m = g.shift(),
              h = h.then(b, m);
        }d ? (h.success = function (a) {
          Qa(a, "fn");h.then(function (b) {
            a(b.data, b.status, b.headers, f);
          });return h;
        }, h.error = function (a) {
          Qa(a, "fn");h.then(null, function (b) {
            a(b.data, b.status, b.headers, f);
          });return h;
        }) : (h.success = fd("success"), h.error = fd("error"));return h;
      }function r(c, d) {
        function g(a, c, d, e) {
          function f() {
            l(c, a, d, e);
          }D && (200 <= a && 300 > a ? D.put(X, [a, c, cd(d), e]) : D.remove(X));b ? h.$applyAsync(f) : (f(), h.$$phase || h.$apply());
        }function l(a, b, d, e) {
          b = -1 <= b ? b : 0;(200 <= b && 300 > b ? n.resolve : n.reject)({ data: a, status: b, headers: dd(d), config: c, statusText: e });
        }function r(a) {
          l(a.data, a.status, ha(a.headers()), a.statusText);
        }function y() {
          var a = m.pendingRequests.indexOf(c);-1 !== a && m.pendingRequests.splice(a, 1);
        }var n = k.defer(),
            I = n.promise,
            D,
            L,
            O = c.headers,
            X = t(c.url, c.paramSerializer(c.params));m.pendingRequests.push(c);I.then(y, y);!c.cache && !a.cache || !1 === c.cache || "GET" !== c.method && "JSONP" !== c.method || (D = G(c.cache) ? c.cache : G(a.cache) ? a.cache : C);D && (L = D.get(X), u(L) ? L && B(L.then) ? L.then(r, r) : E(L) ? l(L[1], L[0], ha(L[2]), L[3]) : l(L, 200, {}, "OK") : D.put(X, I));q(L) && ((L = gd(c.url) ? f()[c.xsrfCookieName || a.xsrfCookieName] : w) && (O[c.xsrfHeaderName || a.xsrfHeaderName] = L), e(c.method, X, d, g, O, c.timeout, c.withCredentials, c.responseType));return I;
      }function t(a, b) {
        0 < b.length && (a += (-1 == a.indexOf("?") ? "?" : "&") + b);return a;
      }var C = g("$http");a.paramSerializer = F(a.paramSerializer) ? l.get(a.paramSerializer) : a.paramSerializer;var y = [];n(c, function (a) {
        y.unshift(F(a) ? l.get(a) : l.invoke(a));
      });m.pendingRequests = [];(function (a) {
        n(arguments, function (a) {
          m[a] = function (b, c) {
            return m(N({}, c || {}, { method: a, url: b }));
          };
        });
      })("get", "delete", "head", "jsonp");(function (a) {
        n(arguments, function (a) {
          m[a] = function (b, c, d) {
            return m(N({}, d || {}, { method: a, url: b, data: c }));
          };
        });
      })("post", "put", "patch");m.defaults = a;return m;
    }];
  }function nf() {
    this.$get = function () {
      return function () {
        return new S.XMLHttpRequest();
      };
    };
  }function mf() {
    this.$get = ["$browser", "$window", "$document", "$xhrFactory", function (a, b, d, c) {
      return Zf(a, c, a.defer, b.angular.callbacks, d[0]);
    }];
  }function Zf(a, b, d, c, e) {
    function f(a, b, d) {
      var f = e.createElement("script"),
          _m = null;f.type = "text/javascript";f.src = a;f.async = !0;_m = function m(a) {
        f.removeEventListener("load", _m, !1);f.removeEventListener("error", _m, !1);e.body.removeChild(f);f = null;var g = -1,
            C = "unknown";a && ("load" !== a.type || c[b].called || (a = { type: "error" }), C = a.type, g = "error" === a.type ? 404 : 200);d && d(g, C);
      };f.addEventListener("load", _m, !1);f.addEventListener("error", _m, !1);e.body.appendChild(f);return _m;
    }
    return function (e, h, k, l, m, r, t, C) {
      function y() {
        x && x();v && v.abort();
      }function R(b, c, e, f, g) {
        u(H) && d.cancel(H);x = v = null;b(c, e, f, g);a.$$completeOutstandingRequest(z);
      }a.$$incOutstandingRequestCount();h = h || a.url();if ("jsonp" == K(e)) {
        var p = "_" + (c.counter++).toString(36);c[p] = function (a) {
          c[p].data = a;c[p].called = !0;
        };var x = f(h.replace("JSON_CALLBACK", "angular.callbacks." + p), p, function (a, b) {
          R(l, a, c[p].data, "", b);c[p] = z;
        });
      } else {
        var v = b(e, h);v.open(e, h, !0);n(m, function (a, b) {
          u(a) && v.setRequestHeader(b, a);
        });v.onload = function () {
          var a = v.statusText || "",
              b = "response" in v ? v.response : v.responseText,
              c = 1223 === v.status ? 204 : v.status;0 === c && (c = b ? 200 : "file" == xa(h).protocol ? 404 : 0);R(l, c, b, v.getAllResponseHeaders(), a);
        };e = function e() {
          R(l, -1, null, null, "");
        };v.onerror = e;v.onabort = e;t && (v.withCredentials = !0);if (C) try {
          v.responseType = C;
        } catch (Y) {
          if ("json" !== C) throw Y;
        }v.send(q(k) ? null : k);
      }if (0 < r) var H = d(y, r);else r && B(r.then) && r.then(y);
    };
  }function gf() {
    var a = "{{",
        b = "}}";this.startSymbol = function (b) {
      return b ? (a = b, this) : a;
    };this.endSymbol = function (a) {
      return a ? (b = a, this) : b;
    };this.$get = ["$parse", "$exceptionHandler", "$sce", function (d, c, e) {
      function f(a) {
        return "\\\\\\" + a;
      }function g(c) {
        return c.replace(m, a).replace(r, b);
      }function h(f, h, m, r) {
        function p(a) {
          try {
            var b = a;a = m ? e.getTrusted(m, b) : e.valueOf(b);var d;if (r && !u(a)) d = a;else if (null == a) d = "";else {
              switch (typeof a === "undefined" ? "undefined" : _typeof(a)) {case "string":
                  break;case "number":
                  a = "" + a;break;default:
                  a = cb(a);}d = a;
            }return d;
          } catch (g) {
            c(Ia.interr(f, g));
          }
        }r = !!r;for (var x, v, n = 0, H = [], s = [], I = f.length, D = [], L = []; n < I;) {
          if (-1 != (x = f.indexOf(a, n)) && -1 != (v = f.indexOf(b, x + k))) n !== x && D.push(g(f.substring(n, x))), n = f.substring(x + k, v), H.push(n), s.push(d(n, p)), n = v + l, L.push(D.length), D.push("");else {
            n !== I && D.push(g(f.substring(n)));break;
          }
        }m && 1 < D.length && Ia.throwNoconcat(f);if (!h || H.length) {
          var O = function O(a) {
            for (var b = 0, c = H.length; b < c; b++) {
              if (r && q(a[b])) return;D[L[b]] = a[b];
            }return D.join("");
          };return N(function (a) {
            var b = 0,
                d = H.length,
                e = Array(d);try {
              for (; b < d; b++) {
                e[b] = s[b](a);
              }return O(e);
            } catch (g) {
              c(Ia.interr(f, g));
            }
          }, { exp: f, expressions: H, $$watchDelegate: function $$watchDelegate(a, b) {
              var c;return a.$watchGroup(s, function (d, e) {
                var f = O(d);B(b) && b.call(this, f, d !== e ? c : f, a);c = f;
              });
            } });
        }
      }var k = a.length,
          l = b.length,
          m = new RegExp(a.replace(/./g, f), "g"),
          r = new RegExp(b.replace(/./g, f), "g");h.startSymbol = function () {
        return a;
      };h.endSymbol = function () {
        return b;
      };return h;
    }];
  }function hf() {
    this.$get = ["$rootScope", "$window", "$q", "$$q", function (a, b, d, c) {
      function e(e, h, k, l) {
        var m = 4 < arguments.length,
            r = m ? sa.call(arguments, 4) : [],
            t = b.setInterval,
            C = b.clearInterval,
            y = 0,
            n = u(l) && !l,
            p = (n ? c : d).defer(),
            x = p.promise;
        k = u(k) ? k : 0;x.then(null, null, m ? function () {
          e.apply(null, r);
        } : e);x.$$intervalId = t(function () {
          p.notify(y++);0 < k && y >= k && (p.resolve(y), C(x.$$intervalId), delete f[x.$$intervalId]);n || a.$apply();
        }, h);f[x.$$intervalId] = p;return x;
      }var f = {};e.cancel = function (a) {
        return a && a.$$intervalId in f ? (f[a.$$intervalId].reject("canceled"), b.clearInterval(a.$$intervalId), delete f[a.$$intervalId], !0) : !1;
      };return e;
    }];
  }function cc(a) {
    a = a.split("/");for (var b = a.length; b--;) {
      a[b] = pb(a[b]);
    }return a.join("/");
  }function hd(a, b) {
    var d = xa(a);b.$$protocol = d.protocol;b.$$host = d.hostname;b.$$port = Z(d.port) || $f[d.protocol] || null;
  }function id(a, b) {
    var d = "/" !== a.charAt(0);d && (a = "/" + a);var c = xa(a);b.$$path = decodeURIComponent(d && "/" === c.pathname.charAt(0) ? c.pathname.substring(1) : c.pathname);b.$$search = yc(c.search);b.$$hash = decodeURIComponent(c.hash);b.$$path && "/" != b.$$path.charAt(0) && (b.$$path = "/" + b.$$path);
  }function qa(a, b) {
    if (0 === b.indexOf(a)) return b.substr(a.length);
  }function Ga(a) {
    var b = a.indexOf("#");return -1 == b ? a : a.substr(0, b);
  }function jb(a) {
    return a.replace(/(#.+)|#$/, "$1");
  }function dc(a, b, d) {
    this.$$html5 = !0;d = d || "";hd(a, this);this.$$parse = function (a) {
      var d = qa(b, a);if (!F(d)) throw Fb("ipthprfx", a, b);id(d, this);this.$$path || (this.$$path = "/");this.$$compose();
    };this.$$compose = function () {
      var a = Sb(this.$$search),
          d = this.$$hash ? "#" + pb(this.$$hash) : "";this.$$url = cc(this.$$path) + (a ? "?" + a : "") + d;this.$$absUrl = b + this.$$url.substr(1);
    };this.$$parseLinkUrl = function (c, e) {
      if (e && "#" === e[0]) return this.hash(e.slice(1)), !0;var f, g;u(f = qa(a, c)) ? (g = f, g = u(f = qa(d, f)) ? b + (qa("/", f) || f) : a + g) : u(f = qa(b, c)) ? g = b + f : b == c + "/" && (g = b);g && this.$$parse(g);return !!g;
    };
  }function ec(a, b, d) {
    hd(a, this);this.$$parse = function (c) {
      var e = qa(a, c) || qa(b, c),
          f;q(e) || "#" !== e.charAt(0) ? this.$$html5 ? f = e : (f = "", q(e) && (a = c, this.replace())) : (f = qa(d, e), q(f) && (f = e));id(f, this);c = this.$$path;var e = a,
          g = /^\/[A-Z]:(\/.*)/;0 === f.indexOf(e) && (f = f.replace(e, ""));g.exec(f) || (c = (f = g.exec(c)) ? f[1] : c);this.$$path = c;this.$$compose();
    };this.$$compose = function () {
      var b = Sb(this.$$search),
          e = this.$$hash ? "#" + pb(this.$$hash) : "";this.$$url = cc(this.$$path) + (b ? "?" + b : "") + e;this.$$absUrl = a + (this.$$url ? d + this.$$url : "");
    };this.$$parseLinkUrl = function (b, d) {
      return Ga(a) == Ga(b) ? (this.$$parse(b), !0) : !1;
    };
  }function jd(a, b, d) {
    this.$$html5 = !0;ec.apply(this, arguments);this.$$parseLinkUrl = function (c, e) {
      if (e && "#" === e[0]) return this.hash(e.slice(1)), !0;var f, g;a == Ga(c) ? f = c : (g = qa(b, c)) ? f = a + d + g : b === c + "/" && (f = b);f && this.$$parse(f);return !!f;
    };this.$$compose = function () {
      var b = Sb(this.$$search),
          e = this.$$hash ? "#" + pb(this.$$hash) : "";this.$$url = cc(this.$$path) + (b ? "?" + b : "") + e;this.$$absUrl = a + d + this.$$url;
    };
  }function Gb(a) {
    return function () {
      return this[a];
    };
  }function kd(a, b) {
    return function (d) {
      if (q(d)) return this[a];this[a] = b(d);this.$$compose();return this;
    };
  }function of() {
    var a = "",
        b = { enabled: !1, requireBase: !0, rewriteLinks: !0 };this.hashPrefix = function (b) {
      return u(b) ? (a = b, this) : a;
    };this.html5Mode = function (a) {
      return $a(a) ? (b.enabled = a, this) : G(a) ? ($a(a.enabled) && (b.enabled = a.enabled), $a(a.requireBase) && (b.requireBase = a.requireBase), $a(a.rewriteLinks) && (b.rewriteLinks = a.rewriteLinks), this) : b;
    };this.$get = ["$rootScope", "$browser", "$sniffer", "$rootElement", "$window", function (d, c, e, f, g) {
      function h(a, b, d) {
        var e = l.url(),
            f = l.$$state;try {
          c.url(a, b, d), l.$$state = c.state();
        } catch (g) {
          throw l.url(e), l.$$state = f, g;
        }
      }function k(a, b) {
        d.$broadcast("$locationChangeSuccess", l.absUrl(), a, l.$$state, b);
      }var l, m;m = c.baseHref();var r = c.url(),
          t;if (b.enabled) {
        if (!m && b.requireBase) throw Fb("nobase");t = r.substring(0, r.indexOf("/", r.indexOf("//") + 2)) + (m || "/");m = e.history ? dc : jd;
      } else t = Ga(r), m = ec;var C = t.substr(0, Ga(t).lastIndexOf("/") + 1);l = new m(t, C, "#" + a);l.$$parseLinkUrl(r, r);l.$$state = c.state();var y = /^\s*(javascript|mailto):/i;f.on("click", function (a) {
        if (b.rewriteLinks && !a.ctrlKey && !a.metaKey && !a.shiftKey && 2 != a.which && 2 != a.button) {
          for (var e = A(a.target); "a" !== oa(e[0]);) {
            if (e[0] === f[0] || !(e = e.parent())[0]) return;
          }var h = e.prop("href"),
              k = e.attr("href") || e.attr("xlink:href");G(h) && "[object SVGAnimatedString]" === h.toString() && (h = xa(h.animVal).href);y.test(h) || !h || e.attr("target") || a.isDefaultPrevented() || !l.$$parseLinkUrl(h, k) || (a.preventDefault(), l.absUrl() != c.url() && (d.$apply(), g.angular["ff-684208-preventDefault"] = !0));
        }
      });jb(l.absUrl()) != jb(r) && c.url(l.absUrl(), !0);var n = !0;c.onUrlChange(function (a, b) {
        q(qa(C, a)) ? g.location.href = a : (d.$evalAsync(function () {
          var c = l.absUrl(),
              e = l.$$state,
              f;a = jb(a);l.$$parse(a);l.$$state = b;f = d.$broadcast("$locationChangeStart", a, c, b, e).defaultPrevented;l.absUrl() === a && (f ? (l.$$parse(c), l.$$state = e, h(c, !1, e)) : (n = !1, k(c, e)));
        }), d.$$phase || d.$digest());
      });d.$watch(function () {
        var a = jb(c.url()),
            b = jb(l.absUrl()),
            f = c.state(),
            g = l.$$replace,
            m = a !== b || l.$$html5 && e.history && f !== l.$$state;if (n || m) n = !1, d.$evalAsync(function () {
          var b = l.absUrl(),
              c = d.$broadcast("$locationChangeStart", b, a, l.$$state, f).defaultPrevented;l.absUrl() === b && (c ? (l.$$parse(a), l.$$state = f) : (m && h(b, g, f === l.$$state ? null : l.$$state), k(a, f)));
        });l.$$replace = !1;
      });return l;
    }];
  }function pf() {
    var a = !0,
        b = this;this.debugEnabled = function (b) {
      return u(b) ? (a = b, this) : a;
    };this.$get = ["$window", function (d) {
      function c(a) {
        a instanceof Error && (a.stack ? a = a.message && -1 === a.stack.indexOf(a.message) ? "Error: " + a.message + "\n" + a.stack : a.stack : a.sourceURL && (a = a.message + "\n" + a.sourceURL + ":" + a.line));return a;
      }function e(a) {
        var b = d.console || {},
            e = b[a] || b.log || z;a = !1;try {
          a = !!e.apply;
        } catch (k) {}return a ? function () {
          var a = [];n(arguments, function (b) {
            a.push(c(b));
          });return e.apply(b, a);
        } : function (a, b) {
          e(a, null == b ? "" : b);
        };
      }return { log: e("log"), info: e("info"), warn: e("warn"), error: e("error"), debug: function () {
          var c = e("debug");return function () {
            a && c.apply(b, arguments);
          };
        }() };
    }];
  }
  function Va(a, b) {
    if ("__defineGetter__" === a || "__defineSetter__" === a || "__lookupGetter__" === a || "__lookupSetter__" === a || "__proto__" === a) throw aa("isecfld", b);return a;
  }function ld(a, b) {
    a += "";if (!F(a)) throw aa("iseccst", b);return a;
  }function ya(a, b) {
    if (a) {
      if (a.constructor === a) throw aa("isecfn", b);if (a.window === a) throw aa("isecwindow", b);if (a.children && (a.nodeName || a.prop && a.attr && a.find)) throw aa("isecdom", b);if (a === Object) throw aa("isecobj", b);
    }return a;
  }function md(a, b) {
    if (a) {
      if (a.constructor === a) throw aa("isecfn", b);if (a === ag || a === bg || a === cg) throw aa("isecff", b);
    }
  }function nd(a, b) {
    if (a && (a === 0 .constructor || a === (!1).constructor || a === "".constructor || a === {}.constructor || a === [].constructor || a === Function.constructor)) throw aa("isecaf", b);
  }function dg(a, b) {
    return "undefined" !== typeof a ? a : b;
  }function od(a, b) {
    return "undefined" === typeof a ? b : "undefined" === typeof b ? a : a + b;
  }function V(a, b) {
    var d, c;switch (a.type) {case s.Program:
        d = !0;n(a.body, function (a) {
          V(a.expression, b);d = d && a.expression.constant;
        });a.constant = d;break;case s.Literal:
        a.constant = !0;a.toWatch = [];break;case s.UnaryExpression:
        V(a.argument, b);a.constant = a.argument.constant;a.toWatch = a.argument.toWatch;break;case s.BinaryExpression:
        V(a.left, b);V(a.right, b);a.constant = a.left.constant && a.right.constant;a.toWatch = a.left.toWatch.concat(a.right.toWatch);break;case s.LogicalExpression:
        V(a.left, b);V(a.right, b);a.constant = a.left.constant && a.right.constant;a.toWatch = a.constant ? [] : [a];break;case s.ConditionalExpression:
        V(a.test, b);V(a.alternate, b);V(a.consequent, b);a.constant = a.test.constant && a.alternate.constant && a.consequent.constant;a.toWatch = a.constant ? [] : [a];break;case s.Identifier:
        a.constant = !1;a.toWatch = [a];break;case s.MemberExpression:
        V(a.object, b);a.computed && V(a.property, b);a.constant = a.object.constant && (!a.computed || a.property.constant);a.toWatch = [a];break;case s.CallExpression:
        d = a.filter ? !b(a.callee.name).$stateful : !1;c = [];n(a.arguments, function (a) {
          V(a, b);d = d && a.constant;a.constant || c.push.apply(c, a.toWatch);
        });a.constant = d;a.toWatch = a.filter && !b(a.callee.name).$stateful ? c : [a];break;case s.AssignmentExpression:
        V(a.left, b);V(a.right, b);a.constant = a.left.constant && a.right.constant;a.toWatch = [a];break;case s.ArrayExpression:
        d = !0;c = [];n(a.elements, function (a) {
          V(a, b);d = d && a.constant;a.constant || c.push.apply(c, a.toWatch);
        });a.constant = d;a.toWatch = c;break;case s.ObjectExpression:
        d = !0;c = [];n(a.properties, function (a) {
          V(a.value, b);d = d && a.value.constant;a.value.constant || c.push.apply(c, a.value.toWatch);
        });a.constant = d;a.toWatch = c;break;case s.ThisExpression:
        a.constant = !1, a.toWatch = [];}
  }function pd(a) {
    if (1 == a.length) {
      a = a[0].expression;var b = a.toWatch;return 1 !== b.length ? b : b[0] !== a ? b : w;
    }
  }function qd(a) {
    return a.type === s.Identifier || a.type === s.MemberExpression;
  }function rd(a) {
    if (1 === a.body.length && qd(a.body[0].expression)) return { type: s.AssignmentExpression, left: a.body[0].expression, right: { type: s.NGValueParameter }, operator: "=" };
  }function sd(a) {
    return 0 === a.body.length || 1 === a.body.length && (a.body[0].expression.type === s.Literal || a.body[0].expression.type === s.ArrayExpression || a.body[0].expression.type === s.ObjectExpression);
  }function td(a, b) {
    this.astBuilder = a;this.$filter = b;
  }function ud(a, b) {
    this.astBuilder = a;this.$filter = b;
  }function Hb(a) {
    return "constructor" == a;
  }function fc(a) {
    return B(a.valueOf) ? a.valueOf() : eg.call(a);
  }function qf() {
    var a = ea(),
        b = ea();this.$get = ["$filter", function (d) {
      function c(a, b) {
        return null == a || null == b ? a === b : "object" === (typeof a === "undefined" ? "undefined" : _typeof(a)) && (a = fc(a), "object" === (typeof a === "undefined" ? "undefined" : _typeof(a))) ? !1 : a === b || a !== a && b !== b;
      }function e(a, b, d, e, f) {
        var g = e.inputs,
            h;if (1 === g.length) {
          var k = c,
              g = g[0];return a.$watch(function (a) {
            var b = g(a);c(b, k) || (h = e(a, w, w, [b]), k = b && fc(b));return h;
          }, b, d, f);
        }for (var l = [], m = [], r = 0, n = g.length; r < n; r++) {
          l[r] = c, m[r] = null;
        }return a.$watch(function (a) {
          for (var b = !1, d = 0, f = g.length; d < f; d++) {
            var k = g[d](a);if (b || (b = !c(k, l[d]))) m[d] = k, l[d] = k && fc(k);
          }b && (h = e(a, w, w, m));return h;
        }, b, d, f);
      }function f(a, b, c, d) {
        var e, f;return e = a.$watch(function (a) {
          return d(a);
        }, function (a, c, d) {
          f = a;B(b) && b.apply(this, arguments);u(a) && d.$$postDigest(function () {
            u(f) && e();
          });
        }, c);
      }function g(a, b, c, d) {
        function e(a) {
          var b = !0;n(a, function (a) {
            u(a) || (b = !1);
          });return b;
        }var f, g;return f = a.$watch(function (a) {
          return d(a);
        }, function (a, c, d) {
          g = a;B(b) && b.call(this, a, c, d);e(a) && d.$$postDigest(function () {
            e(g) && f();
          });
        }, c);
      }function h(a, b, c, d) {
        var e;return e = a.$watch(function (a) {
          return d(a);
        }, function (a, c, d) {
          B(b) && b.apply(this, arguments);e();
        }, c);
      }function k(a, b) {
        if (!b) return a;var c = a.$$watchDelegate,
            d = !1,
            c = c !== g && c !== f ? function (c, e, f, g) {
          f = d && g ? g[0] : a(c, e, f, g);return b(f, c, e);
        } : function (c, d, e, f) {
          e = a(c, d, e, f);c = b(e, c, d);return u(e) ? c : e;
        };a.$$watchDelegate && a.$$watchDelegate !== e ? c.$$watchDelegate = a.$$watchDelegate : b.$stateful || (c.$$watchDelegate = e, d = !a.inputs, c.inputs = a.inputs ? a.inputs : [a]);return c;
      }var l = Ca().noUnsafeEval,
          m = { csp: l, expensiveChecks: !1 },
          r = { csp: l, expensiveChecks: !0 };return function (c, l, y) {
        var n, p, x;switch (typeof c === "undefined" ? "undefined" : _typeof(c)) {case "string":
            x = c = c.trim();var v = y ? b : a;n = v[x];n || (":" === c.charAt(0) && ":" === c.charAt(1) && (p = !0, c = c.substring(2)), y = y ? r : m, n = new gc(y), n = new hc(n, d, y).parse(c), n.constant ? n.$$watchDelegate = h : p ? n.$$watchDelegate = n.literal ? g : f : n.inputs && (n.$$watchDelegate = e), v[x] = n);return k(n, l);case "function":
            return k(c, l);default:
            return k(z, l);}
      };
    }];
  }function sf() {
    this.$get = ["$rootScope", "$exceptionHandler", function (a, b) {
      return vd(function (b) {
        a.$evalAsync(b);
      }, b);
    }];
  }function tf() {
    this.$get = ["$browser", "$exceptionHandler", function (a, b) {
      return vd(function (b) {
        a.defer(b);
      }, b);
    }];
  }function vd(a, b) {
    function d(a, b, c) {
      function d(b) {
        return function (c) {
          e || (e = !0, b.call(a, c));
        };
      }var e = !1;return [d(b), d(c)];
    }function c() {
      this.$$state = { status: 0 };
    }function e(a, b) {
      return function (c) {
        b.call(a, c);
      };
    }function f(c) {
      !c.processScheduled && c.pending && (c.processScheduled = !0, a(function () {
        var a, d, e;e = c.pending;c.processScheduled = !1;c.pending = w;for (var f = 0, g = e.length; f < g; ++f) {
          d = e[f][0];a = e[f][c.status];try {
            B(a) ? d.resolve(a(c.value)) : 1 === c.status ? d.resolve(c.value) : d.reject(c.value);
          } catch (h) {
            d.reject(h), b(h);
          }
        }
      }));
    }function g() {
      this.promise = new c();this.resolve = e(this, this.resolve);this.reject = e(this, this.reject);this.notify = e(this, this.notify);
    }var h = M("$q", TypeError);N(c.prototype, { then: function then(a, b, c) {
        if (q(a) && q(b) && q(c)) return this;var d = new g();this.$$state.pending = this.$$state.pending || [];this.$$state.pending.push([d, a, b, c]);0 < this.$$state.status && f(this.$$state);return d.promise;
      }, "catch": function _catch(a) {
        return this.then(null, a);
      }, "finally": function _finally(a, b) {
        return this.then(function (b) {
          return l(b, !0, a);
        }, function (b) {
          return l(b, !1, a);
        }, b);
      } });N(g.prototype, { resolve: function resolve(a) {
        this.promise.$$state.status || (a === this.promise ? this.$$reject(h("qcycle", a)) : this.$$resolve(a));
      }, $$resolve: function $$resolve(a) {
        var c, e;e = d(this, this.$$resolve, this.$$reject);try {
          if (G(a) || B(a)) c = a && a.then;B(c) ? (this.promise.$$state.status = -1, c.call(a, e[0], e[1], this.notify)) : (this.promise.$$state.value = a, this.promise.$$state.status = 1, f(this.promise.$$state));
        } catch (g) {
          e[1](g), b(g);
        }
      }, reject: function reject(a) {
        this.promise.$$state.status || this.$$reject(a);
      }, $$reject: function $$reject(a) {
        this.promise.$$state.value = a;this.promise.$$state.status = 2;f(this.promise.$$state);
      }, notify: function notify(c) {
        var d = this.promise.$$state.pending;0 >= this.promise.$$state.status && d && d.length && a(function () {
          for (var a, e, f = 0, g = d.length; f < g; f++) {
            e = d[f][0];a = d[f][3];try {
              e.notify(B(a) ? a(c) : c);
            } catch (h) {
              b(h);
            }
          }
        });
      } });var k = function k(a, b) {
      var c = new g();b ? c.resolve(a) : c.reject(a);return c.promise;
    },
        l = function l(a, b, c) {
      var d = null;try {
        B(c) && (d = c());
      } catch (e) {
        return k(e, !1);
      }return d && B(d.then) ? d.then(function () {
        return k(a, b);
      }, function (a) {
        return k(a, !1);
      }) : k(a, b);
    },
        m = function m(a, b, c, d) {
      var e = new g();e.resolve(a);return e.promise.then(b, c, d);
    },
        r = function C(a) {
      if (!B(a)) throw h("norslvr", a);if (!(this instanceof C)) return new C(a);var b = new g();
      a(function (a) {
        b.resolve(a);
      }, function (a) {
        b.reject(a);
      });return b.promise;
    };r.defer = function () {
      return new g();
    };r.reject = function (a) {
      var b = new g();b.reject(a);return b.promise;
    };r.when = m;r.resolve = m;r.all = function (a) {
      var b = new g(),
          c = 0,
          d = E(a) ? [] : {};n(a, function (a, e) {
        c++;m(a).then(function (a) {
          d.hasOwnProperty(e) || (d[e] = a, --c || b.resolve(d));
        }, function (a) {
          d.hasOwnProperty(e) || b.reject(a);
        });
      });0 === c && b.resolve(d);return b.promise;
    };return r;
  }function Cf() {
    this.$get = ["$window", "$timeout", function (a, b) {
      var d = a.requestAnimationFrame || a.webkitRequestAnimationFrame,
          c = a.cancelAnimationFrame || a.webkitCancelAnimationFrame || a.webkitCancelRequestAnimationFrame,
          e = !!d,
          f = e ? function (a) {
        var b = d(a);return function () {
          c(b);
        };
      } : function (a) {
        var c = b(a, 16.66, !1);return function () {
          b.cancel(c);
        };
      };f.supported = e;return f;
    }];
  }function rf() {
    function a(a) {
      function b() {
        this.$$watchers = this.$$nextSibling = this.$$childHead = this.$$childTail = null;this.$$listeners = {};this.$$listenerCount = {};this.$$watchersCount = 0;this.$id = ++ob;this.$$ChildScope = null;
      }b.prototype = a;
      return b;
    }var b = 10,
        d = M("$rootScope"),
        c = null,
        e = null;this.digestTtl = function (a) {
      arguments.length && (b = a);return b;
    };this.$get = ["$injector", "$exceptionHandler", "$parse", "$browser", function (f, g, h, k) {
      function l(a) {
        a.currentScope.$$destroyed = !0;
      }function m(a) {
        9 === Ha && (a.$$childHead && m(a.$$childHead), a.$$nextSibling && m(a.$$nextSibling));a.$parent = a.$$nextSibling = a.$$prevSibling = a.$$childHead = a.$$childTail = a.$root = a.$$watchers = null;
      }function r() {
        this.$id = ++ob;this.$$phase = this.$parent = this.$$watchers = this.$$nextSibling = this.$$prevSibling = this.$$childHead = this.$$childTail = null;this.$root = this;this.$$destroyed = !1;this.$$listeners = {};this.$$listenerCount = {};this.$$watchersCount = 0;this.$$isolateBindings = null;
      }function t(a) {
        if (v.$$phase) throw d("inprog", v.$$phase);v.$$phase = a;
      }function C(a, b) {
        do {
          a.$$watchersCount += b;
        } while (a = a.$parent);
      }function y(a, b, c) {
        do {
          a.$$listenerCount[c] -= b, 0 === a.$$listenerCount[c] && delete a.$$listenerCount[c];
        } while (a = a.$parent);
      }function s() {}function p() {
        for (; w.length;) {
          try {
            w.shift()();
          } catch (a) {
            g(a);
          }
        }e = null;
      }function x() {
        null === e && (e = k.defer(function () {
          v.$apply(p);
        }));
      }r.prototype = { constructor: r, $new: function $new(b, c) {
          var d;c = c || this;b ? (d = new r(), d.$root = this.$root) : (this.$$ChildScope || (this.$$ChildScope = a(this)), d = new this.$$ChildScope());d.$parent = c;d.$$prevSibling = c.$$childTail;c.$$childHead ? (c.$$childTail.$$nextSibling = d, c.$$childTail = d) : c.$$childHead = c.$$childTail = d;(b || c != this) && d.$on("$destroy", l);return d;
        }, $watch: function $watch(a, b, d, e) {
          var f = h(a);if (f.$$watchDelegate) return f.$$watchDelegate(this, b, d, f, a);var g = this,
              k = g.$$watchers,
              l = { fn: b, last: s, get: f, exp: e || a, eq: !!d };c = null;B(b) || (l.fn = z);k || (k = g.$$watchers = []);k.unshift(l);C(this, 1);return function () {
            0 <= ab(k, l) && C(g, -1);c = null;
          };
        }, $watchGroup: function $watchGroup(a, b) {
          function c() {
            h = !1;k ? (k = !1, b(e, e, g)) : b(e, d, g);
          }var d = Array(a.length),
              e = Array(a.length),
              f = [],
              g = this,
              h = !1,
              k = !0;if (!a.length) {
            var l = !0;g.$evalAsync(function () {
              l && b(e, e, g);
            });return function () {
              l = !1;
            };
          }if (1 === a.length) return this.$watch(a[0], function (a, c, f) {
            e[0] = a;d[0] = c;b(e, a === c ? e : d, f);
          });n(a, function (a, b) {
            var k = g.$watch(a, function (a, f) {
              e[b] = a;d[b] = f;h || (h = !0, g.$evalAsync(c));
            });f.push(k);
          });return function () {
            for (; f.length;) {
              f.shift()();
            }
          };
        }, $watchCollection: function $watchCollection(a, b) {
          function c(a) {
            e = a;var b, d, g, h;if (!q(e)) {
              if (G(e)) {
                if (Aa(e)) for (f !== r && (f = r, p = f.length = 0, l++), a = e.length, p !== a && (l++, f.length = p = a), b = 0; b < a; b++) {
                  h = f[b], g = e[b], d = h !== h && g !== g, d || h === g || (l++, f[b] = g);
                } else {
                  f !== t && (f = t = {}, p = 0, l++);a = 0;for (b in e) {
                    ra.call(e, b) && (a++, g = e[b], h = f[b], b in f ? (d = h !== h && g !== g, d || h === g || (l++, f[b] = g)) : (p++, f[b] = g, l++));
                  }if (p > a) for (b in l++, f) {
                    ra.call(e, b) || (p--, delete f[b]);
                  }
                }
              } else f !== e && (f = e, l++);return l;
            }
          }c.$stateful = !0;var d = this,
              e,
              f,
              g,
              k = 1 < b.length,
              l = 0,
              m = h(a, c),
              r = [],
              t = {},
              n = !0,
              p = 0;return this.$watch(m, function () {
            n ? (n = !1, b(e, e, d)) : b(e, g, d);if (k) if (G(e)) {
              if (Aa(e)) {
                g = Array(e.length);for (var a = 0; a < e.length; a++) {
                  g[a] = e[a];
                }
              } else for (a in g = {}, e) {
                ra.call(e, a) && (g[a] = e[a]);
              }
            } else g = e;
          });
        }, $digest: function $digest() {
          var a,
              f,
              h,
              l,
              m,
              r,
              n = b,
              C,
              x = [],
              q,
              y;t("$digest");k.$$checkUrlChange();this === v && null !== e && (k.defer.cancel(e), p());c = null;do {
            r = !1;for (C = this; u.length;) {
              try {
                y = u.shift(), y.scope.$eval(y.expression, y.locals);
              } catch (w) {
                g(w);
              }c = null;
            }a: do {
              if (l = C.$$watchers) for (m = l.length; m--;) {
                try {
                  if (a = l[m]) if ((f = a.get(C)) !== (h = a.last) && !(a.eq ? ka(f, h) : "number" === typeof f && "number" === typeof h && isNaN(f) && isNaN(h))) r = !0, c = a, a.last = a.eq ? Ma(f, null) : f, a.fn(f, h === s ? f : h, C), 5 > n && (q = 4 - n, x[q] || (x[q] = []), x[q].push({ msg: B(a.exp) ? "fn: " + (a.exp.name || a.exp.toString()) : a.exp, newVal: f, oldVal: h }));else if (a === c) {
                    r = !1;break a;
                  }
                } catch (la) {
                  g(la);
                }
              }if (!(l = C.$$watchersCount && C.$$childHead || C !== this && C.$$nextSibling)) for (; C !== this && !(l = C.$$nextSibling);) {
                C = C.$parent;
              }
            } while (C = l);if ((r || u.length) && !n--) throw v.$$phase = null, d("infdig", b, x);
          } while (r || u.length);for (v.$$phase = null; H.length;) {
            try {
              H.shift()();
            } catch (A) {
              g(A);
            }
          }
        }, $destroy: function $destroy() {
          if (!this.$$destroyed) {
            var a = this.$parent;this.$broadcast("$destroy");this.$$destroyed = !0;this === v && k.$$applicationDestroyed();C(this, -this.$$watchersCount);for (var b in this.$$listenerCount) {
              y(this, this.$$listenerCount[b], b);
            }a && a.$$childHead == this && (a.$$childHead = this.$$nextSibling);a && a.$$childTail == this && (a.$$childTail = this.$$prevSibling);this.$$prevSibling && (this.$$prevSibling.$$nextSibling = this.$$nextSibling);this.$$nextSibling && (this.$$nextSibling.$$prevSibling = this.$$prevSibling);this.$destroy = this.$digest = this.$apply = this.$evalAsync = this.$applyAsync = z;this.$on = this.$watch = this.$watchGroup = function () {
              return z;
            };this.$$listeners = {};this.$$nextSibling = null;m(this);
          }
        }, $eval: function $eval(a, b) {
          return h(a)(this, b);
        }, $evalAsync: function $evalAsync(a, b) {
          v.$$phase || u.length || k.defer(function () {
            u.length && v.$digest();
          });u.push({ scope: this, expression: a, locals: b });
        }, $$postDigest: function $$postDigest(a) {
          H.push(a);
        }, $apply: function $apply(a) {
          try {
            t("$apply");try {
              return this.$eval(a);
            } finally {
              v.$$phase = null;
            }
          } catch (b) {
            g(b);
          } finally {
            try {
              v.$digest();
            } catch (c) {
              throw g(c), c;
            }
          }
        }, $applyAsync: function $applyAsync(a) {
          function b() {
            c.$eval(a);
          }var c = this;a && w.push(b);x();
        }, $on: function $on(a, b) {
          var c = this.$$listeners[a];c || (this.$$listeners[a] = c = []);c.push(b);var d = this;do {
            d.$$listenerCount[a] || (d.$$listenerCount[a] = 0), d.$$listenerCount[a]++;
          } while (d = d.$parent);var e = this;return function () {
            var d = c.indexOf(b);-1 !== d && (c[d] = null, y(e, 1, a));
          };
        }, $emit: function $emit(a, b) {
          var c = [],
              d,
              e = this,
              f = !1,
              h = { name: a, targetScope: e, stopPropagation: function stopPropagation() {
              f = !0;
            }, preventDefault: function preventDefault() {
              h.defaultPrevented = !0;
            }, defaultPrevented: !1 },
              k = bb([h], arguments, 1),
              l,
              m;do {
            d = e.$$listeners[a] || c;h.currentScope = e;l = 0;for (m = d.length; l < m; l++) {
              if (d[l]) try {
                d[l].apply(null, k);
              } catch (r) {
                g(r);
              } else d.splice(l, 1), l--, m--;
            }if (f) return h.currentScope = null, h;e = e.$parent;
          } while (e);h.currentScope = null;return h;
        }, $broadcast: function $broadcast(a, b) {
          var c = this,
              d = this,
              e = { name: a, targetScope: this, preventDefault: function preventDefault() {
              e.defaultPrevented = !0;
            }, defaultPrevented: !1 };if (!this.$$listenerCount[a]) return e;for (var f = bb([e], arguments, 1), h, k; c = d;) {
            e.currentScope = c;d = c.$$listeners[a] || [];h = 0;for (k = d.length; h < k; h++) {
              if (d[h]) try {
                d[h].apply(null, f);
              } catch (l) {
                g(l);
              } else d.splice(h, 1), h--, k--;
            }if (!(d = c.$$listenerCount[a] && c.$$childHead || c !== this && c.$$nextSibling)) for (; c !== this && !(d = c.$$nextSibling);) {
              c = c.$parent;
            }
          }e.currentScope = null;return e;
        } };var v = new r(),
          u = v.$$asyncQueue = [],
          H = v.$$postDigestQueue = [],
          w = v.$$applyAsyncQueue = [];return v;
    }];
  }function ke() {
    var a = /^\s*(https?|ftp|mailto|tel|file):/,
        b = /^\s*((https?|ftp|file|blob):|data:image\/)/;this.aHrefSanitizationWhitelist = function (b) {
      return u(b) ? (a = b, this) : a;
    };this.imgSrcSanitizationWhitelist = function (a) {
      return u(a) ? (b = a, this) : b;
    };this.$get = function () {
      return function (d, c) {
        var e = c ? b : a,
            f;f = xa(d).href;return "" === f || f.match(e) ? d : "unsafe:" + f;
      };
    };
  }function fg(a) {
    if ("self" === a) return a;
    if (F(a)) {
      if (-1 < a.indexOf("***")) throw za("iwcard", a);a = wd(a).replace("\\*\\*", ".*").replace("\\*", "[^:/.?&;]*");return new RegExp("^" + a + "$");
    }if (La(a)) return new RegExp("^" + a.source + "$");throw za("imatcher");
  }function xd(a) {
    var b = [];u(a) && n(a, function (a) {
      b.push(fg(a));
    });return b;
  }function vf() {
    this.SCE_CONTEXTS = ma;var a = ["self"],
        b = [];this.resourceUrlWhitelist = function (b) {
      arguments.length && (a = xd(b));return a;
    };this.resourceUrlBlacklist = function (a) {
      arguments.length && (b = xd(a));return b;
    };this.$get = ["$injector", function (d) {
      function c(a, b) {
        return "self" === a ? gd(b) : !!a.exec(b.href);
      }function e(a) {
        var b = function b(a) {
          this.$$unwrapTrustedValue = function () {
            return a;
          };
        };a && (b.prototype = new a());b.prototype.valueOf = function () {
          return this.$$unwrapTrustedValue();
        };b.prototype.toString = function () {
          return this.$$unwrapTrustedValue().toString();
        };return b;
      }var f = function f(a) {
        throw za("unsafe");
      };d.has("$sanitize") && (f = d.get("$sanitize"));var g = e(),
          h = {};h[ma.HTML] = e(g);h[ma.CSS] = e(g);h[ma.URL] = e(g);h[ma.JS] = e(g);h[ma.RESOURCE_URL] = e(h[ma.URL]);return { trustAs: function trustAs(a, b) {
          var c = h.hasOwnProperty(a) ? h[a] : null;if (!c) throw za("icontext", a, b);if (null === b || q(b) || "" === b) return b;if ("string" !== typeof b) throw za("itype", a);return new c(b);
        }, getTrusted: function getTrusted(d, e) {
          if (null === e || q(e) || "" === e) return e;var g = h.hasOwnProperty(d) ? h[d] : null;if (g && e instanceof g) return e.$$unwrapTrustedValue();if (d === ma.RESOURCE_URL) {
            var g = xa(e.toString()),
                r,
                t,
                n = !1;r = 0;for (t = a.length; r < t; r++) {
              if (c(a[r], g)) {
                n = !0;break;
              }
            }if (n) for (r = 0, t = b.length; r < t; r++) {
              if (c(b[r], g)) {
                n = !1;break;
              }
            }if (n) return e;throw za("insecurl", e.toString());
          }if (d === ma.HTML) return f(e);throw za("unsafe");
        }, valueOf: function valueOf(a) {
          return a instanceof g ? a.$$unwrapTrustedValue() : a;
        } };
    }];
  }function uf() {
    var a = !0;this.enabled = function (b) {
      arguments.length && (a = !!b);return a;
    };this.$get = ["$parse", "$sceDelegate", function (b, d) {
      if (a && 8 > Ha) throw za("iequirks");var c = ha(ma);c.isEnabled = function () {
        return a;
      };c.trustAs = d.trustAs;c.getTrusted = d.getTrusted;c.valueOf = d.valueOf;a || (c.trustAs = c.getTrusted = function (a, b) {
        return b;
      }, c.valueOf = Ya);c.parseAs = function (a, d) {
        var e = b(d);return e.literal && e.constant ? e : b(d, function (b) {
          return c.getTrusted(a, b);
        });
      };var e = c.parseAs,
          f = c.getTrusted,
          g = c.trustAs;n(ma, function (a, b) {
        var d = K(b);c[eb("parse_as_" + d)] = function (b) {
          return e(a, b);
        };c[eb("get_trusted_" + d)] = function (b) {
          return f(a, b);
        };c[eb("trust_as_" + d)] = function (b) {
          return g(a, b);
        };
      });return c;
    }];
  }function wf() {
    this.$get = ["$window", "$document", function (a, b) {
      var d = {},
          c = Z((/android (\d+)/.exec(K((a.navigator || {}).userAgent)) || [])[1]),
          e = /Boxee/i.test((a.navigator || {}).userAgent),
          f = b[0] || {},
          g,
          h = /^(Moz|webkit|ms)(?=[A-Z])/,
          k = f.body && f.body.style,
          l = !1,
          m = !1;if (k) {
        for (var r in k) {
          if (l = h.exec(r)) {
            g = l[0];g = g.substr(0, 1).toUpperCase() + g.substr(1);break;
          }
        }g || (g = "WebkitOpacity" in k && "webkit");l = !!("transition" in k || g + "Transition" in k);m = !!("animation" in k || g + "Animation" in k);!c || l && m || (l = F(k.webkitTransition), m = F(k.webkitAnimation));
      }return { history: !(!a.history || !a.history.pushState || 4 > c || e), hasEvent: function hasEvent(a) {
          if ("input" === a && 11 >= Ha) return !1;if (q(d[a])) {
            var b = f.createElement("div");
            d[a] = "on" + a in b;
          }return d[a];
        }, csp: Ca(), vendorPrefix: g, transitions: l, animations: m, android: c };
    }];
  }function yf() {
    this.$get = ["$templateCache", "$http", "$q", "$sce", function (a, b, d, c) {
      function e(f, g) {
        e.totalPendingRequests++;F(f) && a.get(f) || (f = c.getTrustedResourceUrl(f));var h = b.defaults && b.defaults.transformResponse;E(h) ? h = h.filter(function (a) {
          return a !== ac;
        }) : h === ac && (h = null);return b.get(f, { cache: a, transformResponse: h })["finally"](function () {
          e.totalPendingRequests--;
        }).then(function (b) {
          a.put(f, b.data);return b.data;
        }, function (a) {
          if (!g) throw ga("tpload", f, a.status, a.statusText);return d.reject(a);
        });
      }e.totalPendingRequests = 0;return e;
    }];
  }function zf() {
    this.$get = ["$rootScope", "$browser", "$location", function (a, b, d) {
      return { findBindings: function findBindings(a, b, d) {
          a = a.getElementsByClassName("ng-binding");var g = [];n(a, function (a) {
            var c = $.element(a).data("$binding");c && n(c, function (c) {
              d ? new RegExp("(^|\\s)" + wd(b) + "(\\s|\\||$)").test(c) && g.push(a) : -1 != c.indexOf(b) && g.push(a);
            });
          });return g;
        }, findModels: function findModels(a, b, d) {
          for (var g = ["ng-", "data-ng-", "ng\\:"], h = 0; h < g.length; ++h) {
            var k = a.querySelectorAll("[" + g[h] + "model" + (d ? "=" : "*=") + '"' + b + '"]');if (k.length) return k;
          }
        }, getLocation: function getLocation() {
          return d.url();
        }, setLocation: function setLocation(b) {
          b !== d.url() && (d.url(b), a.$digest());
        }, whenStable: function whenStable(a) {
          b.notifyWhenNoOutstandingRequests(a);
        } };
    }];
  }function Af() {
    this.$get = ["$rootScope", "$browser", "$q", "$$q", "$exceptionHandler", function (a, b, d, c, e) {
      function f(f, k, l) {
        B(f) || (l = k, k = f, f = z);var m = sa.call(arguments, 3),
            r = u(l) && !l,
            t = (r ? c : d).defer(),
            n = t.promise,
            q;
        q = b.defer(function () {
          try {
            t.resolve(f.apply(null, m));
          } catch (b) {
            t.reject(b), e(b);
          } finally {
            delete g[n.$$timeoutId];
          }r || a.$apply();
        }, k);n.$$timeoutId = q;g[q] = t;return n;
      }var g = {};f.cancel = function (a) {
        return a && a.$$timeoutId in g ? (g[a.$$timeoutId].reject("canceled"), delete g[a.$$timeoutId], b.defer.cancel(a.$$timeoutId)) : !1;
      };return f;
    }];
  }function xa(a) {
    Ha && (ba.setAttribute("href", a), a = ba.href);ba.setAttribute("href", a);return { href: ba.href, protocol: ba.protocol ? ba.protocol.replace(/:$/, "") : "", host: ba.host, search: ba.search ? ba.search.replace(/^\?/, "") : "", hash: ba.hash ? ba.hash.replace(/^#/, "") : "", hostname: ba.hostname, port: ba.port, pathname: "/" === ba.pathname.charAt(0) ? ba.pathname : "/" + ba.pathname };
  }function gd(a) {
    a = F(a) ? xa(a) : a;return a.protocol === yd.protocol && a.host === yd.host;
  }function Bf() {
    this.$get = na(S);
  }function zd(a) {
    function b(a) {
      try {
        return decodeURIComponent(a);
      } catch (b) {
        return a;
      }
    }var d = a[0] || {},
        c = {},
        e = "";return function () {
      var a, g, h, k, l;a = d.cookie || "";if (a !== e) for (e = a, a = e.split("; "), c = {}, h = 0; h < a.length; h++) {
        g = a[h], k = g.indexOf("="), 0 < k && (l = b(g.substring(0, k)), q(c[l]) && (c[l] = b(g.substring(k + 1))));
      }return c;
    };
  }function Ff() {
    this.$get = zd;
  }function Kc(a) {
    function b(d, c) {
      if (G(d)) {
        var e = {};n(d, function (a, c) {
          e[c] = b(c, a);
        });return e;
      }return a.factory(d + "Filter", c);
    }this.register = b;this.$get = ["$injector", function (a) {
      return function (b) {
        return a.get(b + "Filter");
      };
    }];b("currency", Ad);b("date", Bd);b("filter", gg);b("json", hg);b("limitTo", ig);b("lowercase", jg);b("number", Cd);b("orderBy", Dd);b("uppercase", kg);
  }function gg() {
    return function (a, b, d) {
      if (!Aa(a)) {
        if (null == a) return a;throw M("filter")("notarray", a);
      }var c;switch (ic(b)) {case "function":
          break;case "boolean":case "null":case "number":case "string":
          c = !0;case "object":
          b = lg(b, d, c);break;default:
          return a;}return Array.prototype.filter.call(a, b);
    };
  }function lg(a, b, d) {
    var c = G(a) && "$" in a;!0 === b ? b = ka : B(b) || (b = function b(a, _b) {
      if (q(a)) return !1;if (null === a || null === _b) return a === _b;if (G(_b) || G(a) && !rc(a)) return !1;a = K("" + a);_b = K("" + _b);return -1 !== a.indexOf(_b);
    });return function (e) {
      return c && !G(e) ? Ja(e, a.$, b, !1) : Ja(e, a, b, d);
    };
  }function Ja(a, b, d, c, e) {
    var f = ic(a),
        g = ic(b);if ("string" === g && "!" === b.charAt(0)) return !Ja(a, b.substring(1), d, c);if (E(a)) return a.some(function (a) {
      return Ja(a, b, d, c);
    });switch (f) {case "object":
        var h;if (c) {
          for (h in a) {
            if ("$" !== h.charAt(0) && Ja(a[h], b, d, !0)) return !0;
          }return e ? !1 : Ja(a, b, d, !1);
        }if ("object" === g) {
          for (h in b) {
            if (e = b[h], !B(e) && !q(e) && (f = "$" === h, !Ja(f ? a : a[h], e, d, f, f))) return !1;
          }return !0;
        }return d(a, b);case "function":
        return !1;default:
        return d(a, b);}
  }function ic(a) {
    return null === a ? "null" : typeof a === "undefined" ? "undefined" : _typeof(a);
  }function Ad(a) {
    var b = a.NUMBER_FORMATS;return function (a, c, e) {
      q(c) && (c = b.CURRENCY_SYM);q(e) && (e = b.PATTERNS[1].maxFrac);return null == a ? a : Ed(a, b.PATTERNS[1], b.GROUP_SEP, b.DECIMAL_SEP, e).replace(/\u00A4/g, c);
    };
  }function Cd(a) {
    var b = a.NUMBER_FORMATS;return function (a, c) {
      return null == a ? a : Ed(a, b.PATTERNS[0], b.GROUP_SEP, b.DECIMAL_SEP, c);
    };
  }function mg(a) {
    var b = 0,
        d,
        c,
        e,
        f,
        g;-1 < (c = a.indexOf(Fd)) && (a = a.replace(Fd, ""));0 < (e = a.search(/e/i)) ? (0 > c && (c = e), c += +a.slice(e + 1), a = a.substring(0, e)) : 0 > c && (c = a.length);for (e = 0; a.charAt(e) == jc; e++) {}if (e == (g = a.length)) d = [0], c = 1;else {
      for (g--; a.charAt(g) == jc;) {
        g--;
      }c -= e;d = [];for (f = 0; e <= g; e++, f++) {
        d[f] = +a.charAt(e);
      }
    }c > Gd && (d = d.splice(0, Gd - 1), b = c - 1, c = 1);return { d: d, e: b, i: c };
  }function ng(a, b, d, c) {
    var e = a.d,
        f = e.length - a.i;b = q(b) ? Math.min(Math.max(d, f), c) : +b;d = b + a.i;c = e[d];if (0 < d) e.splice(d);else {
      a.i = 1;e.length = d = b + 1;for (var g = 0; g < d; g++) {
        e[g] = 0;
      }
    }for (5 <= c && e[d - 1]++; f < b; f++) {
      e.push(0);
    }if (b = e.reduceRight(function (a, b, c, d) {
      b += a;d[c] = b % 10;return Math.floor(b / 10);
    }, 0)) e.unshift(b), a.i++;
  }function Ed(a, b, d, c, e) {
    if (!F(a) && !Q(a) || isNaN(a)) return "";var f = !isFinite(a),
        g = !1,
        h = Math.abs(a) + "",
        k = "";if (f) k = "\u221E";else {
      g = mg(h);ng(g, e, b.minFrac, b.maxFrac);k = g.d;h = g.i;e = g.e;f = [];for (g = k.reduce(function (a, b) {
        return a && !b;
      }, !0); 0 > h;) {
        k.unshift(0), h++;
      }0 < h ? f = k.splice(h) : (f = k, k = [0]);h = [];for (k.length > b.lgSize && h.unshift(k.splice(-b.lgSize).join("")); k.length > b.gSize;) {
        h.unshift(k.splice(-b.gSize).join(""));
      }k.length && h.unshift(k.join(""));k = h.join(d);f.length && (k += c + f.join(""));e && (k += "e+" + e);
    }return 0 > a && !g ? b.negPre + k + b.negSuf : b.posPre + k + b.posSuf;
  }function Ib(a, b, d) {
    var c = "";0 > a && (c = "-", a = -a);for (a = "" + a; a.length < b;) {
      a = jc + a;
    }d && (a = a.substr(a.length - b));return c + a;
  }function ca(a, b, d, c) {
    d = d || 0;return function (e) {
      e = e["get" + a]();if (0 < d || e > -d) e += d;0 === e && -12 == d && (e = 12);return Ib(e, b, c);
    };
  }function Jb(a, b) {
    return function (d, c) {
      var e = d["get" + a](),
          f = tb(b ? "SHORT" + a : a);return c[f][e];
    };
  }function Hd(a) {
    var b = new Date(a, 0, 1).getDay();return new Date(a, 0, (4 >= b ? 5 : 12) - b);
  }function Id(a) {
    return function (b) {
      var d = Hd(b.getFullYear());
      b = +new Date(b.getFullYear(), b.getMonth(), b.getDate() + (4 - b.getDay())) - +d;b = 1 + Math.round(b / 6048E5);return Ib(b, a);
    };
  }function kc(a, b) {
    return 0 >= a.getFullYear() ? b.ERAS[0] : b.ERAS[1];
  }function Bd(a) {
    function b(a) {
      var b;if (b = a.match(d)) {
        a = new Date(0);var f = 0,
            g = 0,
            h = b[8] ? a.setUTCFullYear : a.setFullYear,
            k = b[8] ? a.setUTCHours : a.setHours;b[9] && (f = Z(b[9] + b[10]), g = Z(b[9] + b[11]));h.call(a, Z(b[1]), Z(b[2]) - 1, Z(b[3]));f = Z(b[4] || 0) - f;g = Z(b[5] || 0) - g;h = Z(b[6] || 0);b = Math.round(1E3 * parseFloat("0." + (b[7] || 0)));k.call(a, f, g, h, b);
      }return a;
    }var d = /^(\d{4})-?(\d\d)-?(\d\d)(?:T(\d\d)(?::?(\d\d)(?::?(\d\d)(?:\.(\d+))?)?)?(Z|([+-])(\d\d):?(\d\d))?)?$/;return function (c, d, f) {
      var g = "",
          h = [],
          k,
          l;d = d || "mediumDate";d = a.DATETIME_FORMATS[d] || d;F(c) && (c = og.test(c) ? Z(c) : b(c));Q(c) && (c = new Date(c));if (!da(c) || !isFinite(c.getTime())) return c;for (; d;) {
        (l = pg.exec(d)) ? (h = bb(h, l, 1), d = h.pop()) : (h.push(d), d = null);
      }var m = c.getTimezoneOffset();f && (m = wc(f, c.getTimezoneOffset()), c = Rb(c, f, !0));n(h, function (b) {
        k = qg[b];g += k ? k(c, a.DATETIME_FORMATS, m) : b.replace(/(^'|'$)/g, "").replace(/''/g, "'");
      });return g;
    };
  }function hg() {
    return function (a, b) {
      q(b) && (b = 2);return cb(a, b);
    };
  }function ig() {
    return function (a, b, d) {
      b = Infinity === Math.abs(Number(b)) ? Number(b) : Z(b);if (isNaN(b)) return a;Q(a) && (a = a.toString());if (!E(a) && !F(a)) return a;d = !d || isNaN(d) ? 0 : Z(d);d = 0 > d ? Math.max(0, a.length + d) : d;return 0 <= b ? a.slice(d, d + b) : 0 === d ? a.slice(b, a.length) : a.slice(Math.max(0, d + b), d);
    };
  }function Dd(a) {
    function b(b, d) {
      d = d ? -1 : 1;return b.map(function (b) {
        var c = 1,
            h = Ya;if (B(b)) h = b;else if (F(b)) {
          if ("+" == b.charAt(0) || "-" == b.charAt(0)) c = "-" == b.charAt(0) ? -1 : 1, b = b.substring(1);if ("" !== b && (h = a(b), h.constant)) var k = h(),
              h = function h(a) {
            return a[k];
          };
        }return { get: h, descending: c * d };
      });
    }function d(a) {
      switch (typeof a === "undefined" ? "undefined" : _typeof(a)) {case "number":case "boolean":case "string":
          return !0;default:
          return !1;}
    }return function (a, e, f) {
      if (!Aa(a)) return a;E(e) || (e = [e]);0 === e.length && (e = ["+"]);var g = b(e, f);g.push({ get: function get() {
          return {};
        }, descending: f ? -1 : 1 });a = Array.prototype.map.call(a, function (a, b) {
        return { value: a, predicateValues: g.map(function (c) {
            var e = c.get(a);c = typeof e === "undefined" ? "undefined" : _typeof(e);if (null === e) c = "string", e = "null";else if ("string" === c) e = e.toLowerCase();else if ("object" === c) a: {
              if ("function" === typeof e.valueOf && (e = e.valueOf(), d(e))) break a;if (rc(e) && (e = e.toString(), d(e))) break a;e = b;
            }return { value: e, type: c };
          }) };
      });a.sort(function (a, b) {
        for (var c = 0, d = 0, e = g.length; d < e; ++d) {
          var c = a.predicateValues[d],
              f = b.predicateValues[d],
              n = 0;c.type === f.type ? c.value !== f.value && (n = c.value < f.value ? -1 : 1) : n = c.type < f.type ? -1 : 1;if (c = n * g[d].descending) break;
        }return c;
      });return a = a.map(function (a) {
        return a.value;
      });
    };
  }
  function Ka(a) {
    B(a) && (a = { link: a });a.restrict = a.restrict || "AC";return na(a);
  }function Jd(a, b, d, c, e) {
    var f = this,
        g = [];f.$error = {};f.$$success = {};f.$pending = w;f.$name = e(b.name || b.ngForm || "")(d);f.$dirty = !1;f.$pristine = !0;f.$valid = !0;f.$invalid = !1;f.$submitted = !1;f.$$parentForm = Kb;f.$rollbackViewValue = function () {
      n(g, function (a) {
        a.$rollbackViewValue();
      });
    };f.$commitViewValue = function () {
      n(g, function (a) {
        a.$commitViewValue();
      });
    };f.$addControl = function (a) {
      Ra(a.$name, "input");g.push(a);a.$name && (f[a.$name] = a);a.$$parentForm = f;
    };f.$$renameControl = function (a, b) {
      var c = a.$name;f[c] === a && delete f[c];f[b] = a;a.$name = b;
    };f.$removeControl = function (a) {
      a.$name && f[a.$name] === a && delete f[a.$name];n(f.$pending, function (b, c) {
        f.$setValidity(c, null, a);
      });n(f.$error, function (b, c) {
        f.$setValidity(c, null, a);
      });n(f.$$success, function (b, c) {
        f.$setValidity(c, null, a);
      });ab(g, a);a.$$parentForm = Kb;
    };Kd({ ctrl: this, $element: a, set: function set(a, b, c) {
        var d = a[b];d ? -1 === d.indexOf(c) && d.push(c) : a[b] = [c];
      }, unset: function unset(a, b, c) {
        var d = a[b];d && (ab(d, c), 0 === d.length && delete a[b]);
      }, $animate: c });f.$setDirty = function () {
      c.removeClass(a, Wa);c.addClass(a, Lb);f.$dirty = !0;f.$pristine = !1;f.$$parentForm.$setDirty();
    };f.$setPristine = function () {
      c.setClass(a, Wa, Lb + " ng-submitted");f.$dirty = !1;f.$pristine = !0;f.$submitted = !1;n(g, function (a) {
        a.$setPristine();
      });
    };f.$setUntouched = function () {
      n(g, function (a) {
        a.$setUntouched();
      });
    };f.$setSubmitted = function () {
      c.addClass(a, "ng-submitted");f.$submitted = !0;f.$$parentForm.$setSubmitted();
    };
  }function lc(a) {
    a.$formatters.push(function (b) {
      return a.$isEmpty(b) ? b : b.toString();
    });
  }function kb(a, b, d, c, e, f) {
    var g = K(b[0].type);if (!e.android) {
      var h = !1;b.on("compositionstart", function (a) {
        h = !0;
      });b.on("compositionend", function () {
        h = !1;k();
      });
    }var k = function k(a) {
      l && (f.defer.cancel(l), l = null);if (!h) {
        var e = b.val();a = a && a.type;"password" === g || d.ngTrim && "false" === d.ngTrim || (e = T(e));(c.$viewValue !== e || "" === e && c.$$hasNativeValidators) && c.$setViewValue(e, a);
      }
    };if (e.hasEvent("input")) b.on("input", k);else {
      var l,
          m = function m(a, b, c) {
        l || (l = f.defer(function () {
          l = null;b && b.value === c || k(a);
        }));
      };
      b.on("keydown", function (a) {
        var b = a.keyCode;91 === b || 15 < b && 19 > b || 37 <= b && 40 >= b || m(a, this, this.value);
      });if (e.hasEvent("paste")) b.on("paste cut", m);
    }b.on("change", k);c.$render = function () {
      var a = c.$isEmpty(c.$viewValue) ? "" : c.$viewValue;b.val() !== a && b.val(a);
    };
  }function Mb(a, b) {
    return function (d, c) {
      var e, f;if (da(d)) return d;if (F(d)) {
        '"' == d.charAt(0) && '"' == d.charAt(d.length - 1) && (d = d.substring(1, d.length - 1));if (rg.test(d)) return new Date(d);a.lastIndex = 0;if (e = a.exec(d)) return e.shift(), f = c ? { yyyy: c.getFullYear(),
          MM: c.getMonth() + 1, dd: c.getDate(), HH: c.getHours(), mm: c.getMinutes(), ss: c.getSeconds(), sss: c.getMilliseconds() / 1E3 } : { yyyy: 1970, MM: 1, dd: 1, HH: 0, mm: 0, ss: 0, sss: 0 }, n(e, function (a, c) {
          c < b.length && (f[b[c]] = +a);
        }), new Date(f.yyyy, f.MM - 1, f.dd, f.HH, f.mm, f.ss || 0, 1E3 * f.sss || 0);
      }return NaN;
    };
  }function lb(a, b, d, c) {
    return function (e, f, g, h, k, l, m) {
      function r(a) {
        return a && !(a.getTime && a.getTime() !== a.getTime());
      }function n(a) {
        return u(a) && !da(a) ? d(a) || w : a;
      }Ld(e, f, g, h);kb(e, f, g, h, k, l);var C = h && h.$options && h.$options.timezone,
          y;h.$$parserName = a;h.$parsers.push(function (a) {
        return h.$isEmpty(a) ? null : b.test(a) ? (a = d(a, y), C && (a = Rb(a, C)), a) : w;
      });h.$formatters.push(function (a) {
        if (a && !da(a)) throw mb("datefmt", a);if (r(a)) return (y = a) && C && (y = Rb(y, C, !0)), m("date")(a, c, C);y = null;return "";
      });if (u(g.min) || g.ngMin) {
        var s;h.$validators.min = function (a) {
          return !r(a) || q(s) || d(a) >= s;
        };g.$observe("min", function (a) {
          s = n(a);h.$validate();
        });
      }if (u(g.max) || g.ngMax) {
        var p;h.$validators.max = function (a) {
          return !r(a) || q(p) || d(a) <= p;
        };g.$observe("max", function (a) {
          p = n(a);h.$validate();
        });
      }
    };
  }function Ld(a, b, d, c) {
    (c.$$hasNativeValidators = G(b[0].validity)) && c.$parsers.push(function (a) {
      var c = b.prop("validity") || {};return c.badInput && !c.typeMismatch ? w : a;
    });
  }function Md(a, b, d, c, e) {
    if (u(c)) {
      a = a(c);if (!a.constant) throw mb("constexpr", d, c);return a(b);
    }return e;
  }function mc(a, b) {
    a = "ngClass" + a;return ["$animate", function (d) {
      function c(a, b) {
        var c = [],
            d = 0;a: for (; d < a.length; d++) {
          for (var e = a[d], m = 0; m < b.length; m++) {
            if (e == b[m]) continue a;
          }c.push(e);
        }return c;
      }function e(a) {
        var b = [];return E(a) ? (n(a, function (a) {
          b = b.concat(e(a));
        }), b) : F(a) ? a.split(" ") : G(a) ? (n(a, function (a, c) {
          a && (b = b.concat(c.split(" ")));
        }), b) : a;
      }return { restrict: "AC", link: function link(f, g, h) {
          function k(a, b) {
            var c = g.data("$classCounts") || ea(),
                d = [];n(a, function (a) {
              if (0 < b || c[a]) c[a] = (c[a] || 0) + b, c[a] === +(0 < b) && d.push(a);
            });g.data("$classCounts", c);return d.join(" ");
          }function l(a) {
            if (!0 === b || f.$index % 2 === b) {
              var l = e(a || []);if (!m) {
                var n = k(l, 1);h.$addClass(n);
              } else if (!ka(a, m)) {
                var q = e(m),
                    n = c(l, q),
                    l = c(q, l),
                    n = k(n, 1),
                    l = k(l, -1);n && n.length && d.addClass(g, n);l && l.length && d.removeClass(g, l);
              }
            }m = ha(a);
          }var m;f.$watch(h[a], l, !0);h.$observe("class", function (b) {
            l(f.$eval(h[a]));
          });"ngClass" !== a && f.$watch("$index", function (c, d) {
            var g = c & 1;if (g !== (d & 1)) {
              var l = e(f.$eval(h[a]));g === b ? (g = k(l, 1), h.$addClass(g)) : (g = k(l, -1), h.$removeClass(g));
            }
          });
        } };
    }];
  }function Kd(a) {
    function b(a, b) {
      b && !f[a] ? (k.addClass(e, a), f[a] = !0) : !b && f[a] && (k.removeClass(e, a), f[a] = !1);
    }function d(a, c) {
      a = a ? "-" + Ac(a, "-") : "";b(nb + a, !0 === c);b(Nd + a, !1 === c);
    }var c = a.ctrl,
        e = a.$element,
        f = {},
        g = a.set,
        h = a.unset,
        k = a.$animate;f[Nd] = !(f[nb] = e.hasClass(nb));c.$setValidity = function (a, e, f) {
      q(e) ? (c.$pending || (c.$pending = {}), g(c.$pending, a, f)) : (c.$pending && h(c.$pending, a, f), Od(c.$pending) && (c.$pending = w));$a(e) ? e ? (h(c.$error, a, f), g(c.$$success, a, f)) : (g(c.$error, a, f), h(c.$$success, a, f)) : (h(c.$error, a, f), h(c.$$success, a, f));c.$pending ? (b(Pd, !0), c.$valid = c.$invalid = w, d("", null)) : (b(Pd, !1), c.$valid = Od(c.$error), c.$invalid = !c.$valid, d("", c.$valid));e = c.$pending && c.$pending[a] ? w : c.$error[a] ? !1 : c.$$success[a] ? !0 : null;d(a, e);c.$$parentForm.$setValidity(a, e, c);
    };
  }function Od(a) {
    if (a) for (var b in a) {
      if (a.hasOwnProperty(b)) return !1;
    }return !0;
  }var sg = /^\/(.+)\/([a-z]*)$/,
      K = function K(a) {
    return F(a) ? a.toLowerCase() : a;
  },
      ra = Object.prototype.hasOwnProperty,
      tb = function tb(a) {
    return F(a) ? a.toUpperCase() : a;
  },
      Ha,
      A,
      pa,
      sa = [].slice,
      Uf = [].splice,
      tg = [].push,
      ta = Object.prototype.toString,
      sc = Object.getPrototypeOf,
      Ba = M("ng"),
      $ = S.angular || (S.angular = {}),
      Ub,
      ob = 0;Ha = W.documentMode;z.$inject = [];Ya.$inject = [];var E = Array.isArray,
      Zd = /^\[object (?:Uint8|Uint8Clamped|Uint16|Uint32|Int8|Int16|Int32|Float32|Float64)Array\]$/,
      T = function T(a) {
    return F(a) ? a.trim() : a;
  },
      wd = function wd(a) {
    return a.replace(/([-()\[\]{}+?*.$\^|,:#<!\\])/g, "\\$1").replace(/\x08/g, "\\x08");
  },
      Ca = function Ca() {
    if (!u(Ca.rules)) {
      var a = W.querySelector("[ng-csp]") || W.querySelector("[data-ng-csp]");if (a) {
        var b = a.getAttribute("ng-csp") || a.getAttribute("data-ng-csp");Ca.rules = { noUnsafeEval: !b || -1 !== b.indexOf("no-unsafe-eval"), noInlineStyle: !b || -1 !== b.indexOf("no-inline-style") };
      } else {
        a = Ca;try {
          new Function(""), b = !1;
        } catch (d) {
          b = !0;
        }a.rules = { noUnsafeEval: b, noInlineStyle: !1 };
      }
    }return Ca.rules;
  },
      qb = function qb() {
    if (u(qb.name_)) return qb.name_;var a,
        b,
        d = Oa.length,
        c,
        e;for (b = 0; b < d; ++b) {
      if (c = Oa[b], a = W.querySelector("[" + c.replace(":", "\\:") + "jq]")) {
        e = a.getAttribute(c + "jq");break;
      }
    }return qb.name_ = e;
  },
      Oa = ["ng-", "data-ng-", "ng:", "x-ng-"],
      fe = /[A-Z]/g,
      Bc = !1,
      Tb,
      Na = 3,
      je = { full: "1.4.9", major: 1, minor: 4, dot: 9, codeName: "implicit-superannuation" };P.expando = "ng339";var fb = P.cache = {},
      Lf = 1;P._data = function (a) {
    return this.cache[a[this.expando]] || {};
  };var Gf = /([\:\-\_]+(.))/g,
      Hf = /^moz([A-Z])/,
      yb = { mouseleave: "mouseout",
    mouseenter: "mouseover" },
      Wb = M("jqLite"),
      Kf = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/,
      Vb = /<|&#?\w+;/,
      If = /<([\w:-]+)/,
      Jf = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi,
      ja = { option: [1, '<select multiple="multiple">', "</select>"], thead: [1, "<table>", "</table>"], col: [2, "<table><colgroup>", "</colgroup></table>"], tr: [2, "<table><tbody>", "</tbody></table>"], td: [3, "<table><tbody><tr>", "</tr></tbody></table>"], _default: [0, "", ""] };ja.optgroup = ja.option;ja.tbody = ja.tfoot = ja.colgroup = ja.caption = ja.thead;
  ja.th = ja.td;var Qf = Node.prototype.contains || function (a) {
    return !!(this.compareDocumentPosition(a) & 16);
  },
      Pa = P.prototype = { ready: function ready(a) {
      function b() {
        d || (d = !0, a());
      }var d = !1;"complete" === W.readyState ? setTimeout(b) : (this.on("DOMContentLoaded", b), P(S).on("load", b));
    }, toString: function toString() {
      var a = [];n(this, function (b) {
        a.push("" + b);
      });return "[" + a.join(", ") + "]";
    }, eq: function eq(a) {
      return 0 <= a ? A(this[a]) : A(this[this.length + a]);
    }, length: 0, push: tg, sort: [].sort, splice: [].splice },
      Db = {};n("multiple selected checked disabled readOnly required open".split(" "), function (a) {
    Db[K(a)] = a;
  });var Sc = {};n("input select option textarea button form details".split(" "), function (a) {
    Sc[a] = !0;
  });var ad = { ngMinlength: "minlength", ngMaxlength: "maxlength", ngMin: "min", ngMax: "max", ngPattern: "pattern" };n({ data: Yb, removeData: wb, hasData: function hasData(a) {
      for (var b in fb[a.ng339]) {
        return !0;
      }return !1;
    } }, function (a, b) {
    P[b] = a;
  });n({ data: Yb, inheritedData: Cb, scope: function scope(a) {
      return A.data(a, "$scope") || Cb(a.parentNode || a, ["$isolateScope", "$scope"]);
    }, isolateScope: function isolateScope(a) {
      return A.data(a, "$isolateScope") || A.data(a, "$isolateScopeNoTemplate");
    }, controller: Pc, injector: function injector(a) {
      return Cb(a, "$injector");
    }, removeAttr: function removeAttr(a, b) {
      a.removeAttribute(b);
    }, hasClass: zb, css: function css(a, b, d) {
      b = eb(b);if (u(d)) a.style[b] = d;else return a.style[b];
    }, attr: function attr(a, b, d) {
      var c = a.nodeType;if (c !== Na && 2 !== c && 8 !== c) if (c = K(b), Db[c]) {
        if (u(d)) d ? (a[b] = !0, a.setAttribute(b, c)) : (a[b] = !1, a.removeAttribute(c));else return a[b] || (a.attributes.getNamedItem(b) || z).specified ? c : w;
      } else if (u(d)) a.setAttribute(b, d);else if (a.getAttribute) return a = a.getAttribute(b, 2), null === a ? w : a;
    }, prop: function prop(a, b, d) {
      if (u(d)) a[b] = d;else return a[b];
    }, text: function () {
      function a(a, d) {
        if (q(d)) {
          var c = a.nodeType;return 1 === c || c === Na ? a.textContent : "";
        }a.textContent = d;
      }a.$dv = "";return a;
    }(), val: function val(a, b) {
      if (q(b)) {
        if (a.multiple && "select" === oa(a)) {
          var d = [];n(a.options, function (a) {
            a.selected && d.push(a.value || a.text);
          });return 0 === d.length ? null : d;
        }return a.value;
      }a.value = b;
    }, html: function html(a, b) {
      if (q(b)) return a.innerHTML;vb(a, !0);a.innerHTML = b;
    }, empty: Qc }, function (a, b) {
    P.prototype[b] = function (b, c) {
      var e,
          f,
          g = this.length;if (a !== Qc && q(2 == a.length && a !== zb && a !== Pc ? b : c)) {
        if (G(b)) {
          for (e = 0; e < g; e++) {
            if (a === Yb) a(this[e], b);else for (f in b) {
              a(this[e], f, b[f]);
            }
          }return this;
        }e = a.$dv;g = q(e) ? Math.min(g, 1) : g;for (f = 0; f < g; f++) {
          var h = a(this[f], b, c);e = e ? e + h : h;
        }return e;
      }for (e = 0; e < g; e++) {
        a(this[e], b, c);
      }return this;
    };
  });n({ removeData: wb, on: function on(a, b, d, c) {
      if (u(c)) throw Wb("onargs");if (Lc(a)) {
        c = xb(a, !0);var e = c.events,
            f = c.handle;f || (f = c.handle = Nf(a, e));c = 0 <= b.indexOf(" ") ? b.split(" ") : [b];for (var g = c.length, h = function h(b, c, g) {
          var h = e[b];h || (h = e[b] = [], h.specialHandlerWrapper = c, "$destroy" === b || g || a.addEventListener(b, f, !1));h.push(d);
        }; g--;) {
          b = c[g], yb[b] ? (h(yb[b], Pf), h(b, w, !0)) : h(b);
        }
      }
    }, off: Oc, one: function one(a, b, d) {
      a = A(a);a.on(b, function e() {
        a.off(b, d);a.off(b, e);
      });a.on(b, d);
    }, replaceWith: function replaceWith(a, b) {
      var d,
          c = a.parentNode;vb(a);n(new P(b), function (b) {
        d ? c.insertBefore(b, d.nextSibling) : c.replaceChild(b, a);d = b;
      });
    }, children: function children(a) {
      var b = [];n(a.childNodes, function (a) {
        1 === a.nodeType && b.push(a);
      });return b;
    }, contents: function contents(a) {
      return a.contentDocument || a.childNodes || [];
    }, append: function append(a, b) {
      var d = a.nodeType;if (1 === d || 11 === d) {
        b = new P(b);for (var d = 0, c = b.length; d < c; d++) {
          a.appendChild(b[d]);
        }
      }
    }, prepend: function prepend(a, b) {
      if (1 === a.nodeType) {
        var d = a.firstChild;n(new P(b), function (b) {
          a.insertBefore(b, d);
        });
      }
    }, wrap: function wrap(a, b) {
      b = A(b).eq(0).clone()[0];var d = a.parentNode;d && d.replaceChild(b, a);b.appendChild(a);
    }, remove: Zb, detach: function detach(a) {
      Zb(a, !0);
    }, after: function after(a, b) {
      var d = a,
          c = a.parentNode;b = new P(b);for (var e = 0, f = b.length; e < f; e++) {
        var g = b[e];c.insertBefore(g, d.nextSibling);d = g;
      }
    }, addClass: Bb, removeClass: Ab, toggleClass: function toggleClass(a, b, d) {
      b && n(b.split(" "), function (b) {
        var e = d;q(e) && (e = !zb(a, b));(e ? Bb : Ab)(a, b);
      });
    }, parent: function parent(a) {
      return (a = a.parentNode) && 11 !== a.nodeType ? a : null;
    }, next: function next(a) {
      return a.nextElementSibling;
    }, find: function find(a, b) {
      return a.getElementsByTagName ? a.getElementsByTagName(b) : [];
    }, clone: Xb, triggerHandler: function triggerHandler(a, b, d) {
      var c,
          e,
          f = b.type || b,
          g = xb(a);if (g = (g = g && g.events) && g[f]) c = { preventDefault: function preventDefault() {
          this.defaultPrevented = !0;
        }, isDefaultPrevented: function isDefaultPrevented() {
          return !0 === this.defaultPrevented;
        }, stopImmediatePropagation: function stopImmediatePropagation() {
          this.immediatePropagationStopped = !0;
        }, isImmediatePropagationStopped: function isImmediatePropagationStopped() {
          return !0 === this.immediatePropagationStopped;
        }, stopPropagation: z, type: f, target: a }, b.type && (c = N(c, b)), b = ha(g), e = d ? [c].concat(d) : [c], n(b, function (b) {
        c.isImmediatePropagationStopped() || b.apply(a, e);
      });
    } }, function (a, b) {
    P.prototype[b] = function (b, c, e) {
      for (var f, g = 0, h = this.length; g < h; g++) {
        q(f) ? (f = a(this[g], b, c, e), u(f) && (f = A(f))) : Nc(f, a(this[g], b, c, e));
      }return u(f) ? f : this;
    };P.prototype.bind = P.prototype.on;P.prototype.unbind = P.prototype.off;
  });Sa.prototype = { put: function put(a, b) {
      this[Da(a, this.nextUid)] = b;
    }, get: function get(a) {
      return this[Da(a, this.nextUid)];
    }, remove: function remove(a) {
      var b = this[a = Da(a, this.nextUid)];delete this[a];return b;
    } };var Ef = [function () {
    this.$get = [function () {
      return Sa;
    }];
  }],
      Uc = /^[^\(]*\(\s*([^\)]*)\)/m,
      ug = /,/,
      vg = /^\s*(_?)(\S+?)\1\s*$/,
      Tc = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg,
      Ea = M("$injector");db.$$annotate = function (a, b, d) {
    var c;if ("function" === typeof a) {
      if (!(c = a.$inject)) {
        c = [];if (a.length) {
          if (b) throw F(d) && d || (d = a.name || Rf(a)), Ea("strictdi", d);b = a.toString().replace(Tc, "");b = b.match(Uc);n(b[1].split(ug), function (a) {
            a.replace(vg, function (a, b, d) {
              c.push(d);
            });
          });
        }a.$inject = c;
      }
    } else E(a) ? (b = a.length - 1, Qa(a[b], "fn"), c = a.slice(0, b)) : Qa(a, "fn", !0);return c;
  };var Qd = M("$animate"),
      Xe = function Xe() {
    this.$get = function () {};
  },
      Ye = function Ye() {
    var a = new Sa(),
        b = [];this.$get = ["$$AnimateRunner", "$rootScope", function (d, c) {
      function e(a, b, c) {
        var d = !1;b && (b = F(b) ? b.split(" ") : E(b) ? b : [], n(b, function (b) {
          b && (d = !0, a[b] = c);
        }));return d;
      }function f() {
        n(b, function (b) {
          var c = a.get(b);if (c) {
            var d = Sf(b.attr("class")),
                e = "",
                f = "";n(c, function (a, b) {
              a !== !!d[b] && (a ? e += (e.length ? " " : "") + b : f += (f.length ? " " : "") + b);
            });n(b, function (a) {
              e && Bb(a, e);f && Ab(a, f);
            });a.remove(b);
          }
        });b.length = 0;
      }return { enabled: z, on: z, off: z, pin: z, push: function push(g, h, k, l) {
          l && l();k = k || {};k.from && g.css(k.from);k.to && g.css(k.to);if (k.addClass || k.removeClass) if (h = k.addClass, l = k.removeClass, k = a.get(g) || {}, h = e(k, h, !0), l = e(k, l, !1), h || l) a.put(g, k), b.push(g), 1 === b.length && c.$$postDigest(f);g = new d();g.complete();
          return g;
        } };
    }];
  },
      Ve = ["$provide", function (a) {
    var b = this;this.$$registeredAnimations = Object.create(null);this.register = function (d, c) {
      if (d && "." !== d.charAt(0)) throw Qd("notcsel", d);var e = d + "-animation";b.$$registeredAnimations[d.substr(1)] = e;a.factory(e, c);
    };this.classNameFilter = function (a) {
      if (1 === arguments.length && (this.$$classNameFilter = a instanceof RegExp ? a : null) && /(\s+|\/)ng-animate(\s+|\/)/.test(this.$$classNameFilter.toString())) throw Qd("nongcls", "ng-animate");return this.$$classNameFilter;
    };this.$get = ["$$animateQueue", function (a) {
      function b(a, c, d) {
        if (d) {
          var h;a: {
            for (h = 0; h < d.length; h++) {
              var k = d[h];if (1 === k.nodeType) {
                h = k;break a;
              }
            }h = void 0;
          }!h || h.parentNode || h.previousElementSibling || (d = null);
        }d ? d.after(a) : c.prepend(a);
      }return { on: a.on, off: a.off, pin: a.pin, enabled: a.enabled, cancel: function cancel(a) {
          a.end && a.end();
        }, enter: function enter(e, f, g, h) {
          f = f && A(f);g = g && A(g);f = f || g.parent();b(e, f, g);return a.push(e, "enter", Fa(h));
        }, move: function move(e, f, g, h) {
          f = f && A(f);g = g && A(g);f = f || g.parent();b(e, f, g);return a.push(e, "move", Fa(h));
        },
        leave: function leave(b, c) {
          return a.push(b, "leave", Fa(c), function () {
            b.remove();
          });
        }, addClass: function addClass(b, c, g) {
          g = Fa(g);g.addClass = gb(g.addclass, c);return a.push(b, "addClass", g);
        }, removeClass: function removeClass(b, c, g) {
          g = Fa(g);g.removeClass = gb(g.removeClass, c);return a.push(b, "removeClass", g);
        }, setClass: function setClass(b, c, g, h) {
          h = Fa(h);h.addClass = gb(h.addClass, c);h.removeClass = gb(h.removeClass, g);return a.push(b, "setClass", h);
        }, animate: function animate(b, c, g, h, k) {
          k = Fa(k);k.from = k.from ? N(k.from, c) : c;k.to = k.to ? N(k.to, g) : g;k.tempClasses = gb(k.tempClasses, h || "ng-inline-animate");return a.push(b, "animate", k);
        } };
    }];
  }],
      $e = function $e() {
    this.$get = ["$$rAF", function (a) {
      function b(b) {
        d.push(b);1 < d.length || a(function () {
          for (var a = 0; a < d.length; a++) {
            d[a]();
          }d = [];
        });
      }var d = [];return function () {
        var a = !1;b(function () {
          a = !0;
        });return function (d) {
          a ? d() : b(d);
        };
      };
    }];
  },
      Ze = function Ze() {
    this.$get = ["$q", "$sniffer", "$$animateAsyncRun", "$document", "$timeout", function (a, b, d, c, e) {
      function f(a) {
        this.setHost(a);var b = d();this._doneCallbacks = [];this._tick = function (a) {
          var d = c[0];d && d.hidden ? e(a, 0, !1) : b(a);
        };this._state = 0;
      }f.chain = function (a, b) {
        function c() {
          if (d === a.length) b(!0);else a[d](function (a) {
            !1 === a ? b(!1) : (d++, c());
          });
        }var d = 0;c();
      };f.all = function (a, b) {
        function c(f) {
          e = e && f;++d === a.length && b(e);
        }var d = 0,
            e = !0;n(a, function (a) {
          a.done(c);
        });
      };f.prototype = { setHost: function setHost(a) {
          this.host = a || {};
        }, done: function done(a) {
          2 === this._state ? a() : this._doneCallbacks.push(a);
        }, progress: z, getPromise: function getPromise() {
          if (!this.promise) {
            var b = this;this.promise = a(function (a, c) {
              b.done(function (b) {
                !1 === b ? c() : a();
              });
            });
          }return this.promise;
        },
        then: function then(a, b) {
          return this.getPromise().then(a, b);
        }, "catch": function _catch(a) {
          return this.getPromise()["catch"](a);
        }, "finally": function _finally(a) {
          return this.getPromise()["finally"](a);
        }, pause: function pause() {
          this.host.pause && this.host.pause();
        }, resume: function resume() {
          this.host.resume && this.host.resume();
        }, end: function end() {
          this.host.end && this.host.end();this._resolve(!0);
        }, cancel: function cancel() {
          this.host.cancel && this.host.cancel();this._resolve(!1);
        }, complete: function complete(a) {
          var b = this;0 === b._state && (b._state = 1, b._tick(function () {
            b._resolve(a);
          }));
        },
        _resolve: function _resolve(a) {
          2 !== this._state && (n(this._doneCallbacks, function (b) {
            b(a);
          }), this._doneCallbacks.length = 0, this._state = 2);
        } };return f;
    }];
  },
      We = function We() {
    this.$get = ["$$rAF", "$q", "$$AnimateRunner", function (a, b, d) {
      return function (b, e) {
        function f() {
          a(function () {
            g.addClass && (b.addClass(g.addClass), g.addClass = null);g.removeClass && (b.removeClass(g.removeClass), g.removeClass = null);g.to && (b.css(g.to), g.to = null);h || k.complete();h = !0;
          });return k;
        }var g = e || {};g.$$prepared || (g = Ma(g));g.cleanupStyles && (g.from = g.to = null);g.from && (b.css(g.from), g.from = null);var h,
            k = new d();return { start: f, end: f };
      };
    }];
  },
      ga = M("$compile");Dc.$inject = ["$provide", "$$sanitizeUriProvider"];var Yc = /^((?:x|data)[\:\-_])/i,
      Vf = M("$controller"),
      Vc = /^(\S+)(\s+as\s+([\w$]+))?$/,
      ff = function ff() {
    this.$get = ["$document", function (a) {
      return function (b) {
        b ? !b.nodeType && b instanceof A && (b = b[0]) : b = a[0].body;return b.offsetWidth + 1;
      };
    }];
  },
      bd = "application/json",
      bc = { "Content-Type": bd + ";charset=utf-8" },
      Xf = /^\[|^\{(?!\{)/,
      Yf = { "[": /]$/, "{": /}$/ },
      Wf = /^\)\]\}',?\n/,
      wg = M("$http"),
      fd = function fd(a) {
    return function () {
      throw wg("legacy", a);
    };
  },
      Ia = $.$interpolateMinErr = M("$interpolate");Ia.throwNoconcat = function (a) {
    throw Ia("noconcat", a);
  };Ia.interr = function (a, b) {
    return Ia("interr", a, b.toString());
  };var xg = /^([^\?#]*)(\?([^#]*))?(#(.*))?$/,
      $f = { http: 80, https: 443, ftp: 21 },
      Fb = M("$location"),
      yg = { $$html5: !1, $$replace: !1, absUrl: Gb("$$absUrl"), url: function url(a) {
      if (q(a)) return this.$$url;var b = xg.exec(a);(b[1] || "" === a) && this.path(decodeURIComponent(b[1]));(b[2] || b[1] || "" === a) && this.search(b[3] || "");this.hash(b[5] || "");return this;
    }, protocol: Gb("$$protocol"), host: Gb("$$host"), port: Gb("$$port"), path: kd("$$path", function (a) {
      a = null !== a ? a.toString() : "";return "/" == a.charAt(0) ? a : "/" + a;
    }), search: function search(a, b) {
      switch (arguments.length) {case 0:
          return this.$$search;case 1:
          if (F(a) || Q(a)) a = a.toString(), this.$$search = yc(a);else if (G(a)) a = Ma(a, {}), n(a, function (b, c) {
            null == b && delete a[c];
          }), this.$$search = a;else throw Fb("isrcharg");break;default:
          q(b) || null === b ? delete this.$$search[a] : this.$$search[a] = b;}this.$$compose();
      return this;
    }, hash: kd("$$hash", function (a) {
      return null !== a ? a.toString() : "";
    }), replace: function replace() {
      this.$$replace = !0;return this;
    } };n([jd, ec, dc], function (a) {
    a.prototype = Object.create(yg);a.prototype.state = function (b) {
      if (!arguments.length) return this.$$state;if (a !== dc || !this.$$html5) throw Fb("nostate");this.$$state = q(b) ? null : b;return this;
    };
  });var aa = M("$parse"),
      ag = Function.prototype.call,
      bg = Function.prototype.apply,
      cg = Function.prototype.bind,
      Nb = ea();n("+ - * / % === !== == != < > <= >= && || ! = |".split(" "), function (a) {
    Nb[a] = !0;
  });var zg = { n: "\n", f: "\f", r: "\r", t: "\t", v: "\v", "'": "'", '"': '"' },
      gc = function gc(a) {
    this.options = a;
  };gc.prototype = { constructor: gc, lex: function lex(a) {
      this.text = a;this.index = 0;for (this.tokens = []; this.index < this.text.length;) {
        if (a = this.text.charAt(this.index), '"' === a || "'" === a) this.readString(a);else if (this.isNumber(a) || "." === a && this.isNumber(this.peek())) this.readNumber();else if (this.isIdent(a)) this.readIdent();else if (this.is(a, "(){}[].,;:?")) this.tokens.push({ index: this.index, text: a }), this.index++;else if (this.isWhitespace(a)) this.index++;else {
          var b = a + this.peek(),
              d = b + this.peek(2),
              c = Nb[b],
              e = Nb[d];Nb[a] || c || e ? (a = e ? d : c ? b : a, this.tokens.push({ index: this.index, text: a, operator: !0 }), this.index += a.length) : this.throwError("Unexpected next character ", this.index, this.index + 1);
        }
      }return this.tokens;
    }, is: function is(a, b) {
      return -1 !== b.indexOf(a);
    }, peek: function peek(a) {
      a = a || 1;return this.index + a < this.text.length ? this.text.charAt(this.index + a) : !1;
    }, isNumber: function isNumber(a) {
      return "0" <= a && "9" >= a && "string" === typeof a;
    }, isWhitespace: function isWhitespace(a) {
      return " " === a || "\r" === a || "\t" === a || "\n" === a || "\v" === a || "\xA0" === a;
    }, isIdent: function isIdent(a) {
      return "a" <= a && "z" >= a || "A" <= a && "Z" >= a || "_" === a || "$" === a;
    }, isExpOperator: function isExpOperator(a) {
      return "-" === a || "+" === a || this.isNumber(a);
    }, throwError: function throwError(a, b, d) {
      d = d || this.index;b = u(b) ? "s " + b + "-" + this.index + " [" + this.text.substring(b, d) + "]" : " " + d;throw aa("lexerr", a, b, this.text);
    }, readNumber: function readNumber() {
      for (var a = "", b = this.index; this.index < this.text.length;) {
        var d = K(this.text.charAt(this.index));if ("." == d || this.isNumber(d)) a += d;else {
          var c = this.peek();if ("e" == d && this.isExpOperator(c)) a += d;else if (this.isExpOperator(d) && c && this.isNumber(c) && "e" == a.charAt(a.length - 1)) a += d;else if (!this.isExpOperator(d) || c && this.isNumber(c) || "e" != a.charAt(a.length - 1)) break;else this.throwError("Invalid exponent");
        }this.index++;
      }this.tokens.push({ index: b, text: a, constant: !0, value: Number(a) });
    }, readIdent: function readIdent() {
      for (var a = this.index; this.index < this.text.length;) {
        var b = this.text.charAt(this.index);if (!this.isIdent(b) && !this.isNumber(b)) break;this.index++;
      }this.tokens.push({ index: a,
        text: this.text.slice(a, this.index), identifier: !0 });
    }, readString: function readString(a) {
      var b = this.index;this.index++;for (var d = "", c = a, e = !1; this.index < this.text.length;) {
        var f = this.text.charAt(this.index),
            c = c + f;if (e) "u" === f ? (e = this.text.substring(this.index + 1, this.index + 5), e.match(/[\da-f]{4}/i) || this.throwError("Invalid unicode escape [\\u" + e + "]"), this.index += 4, d += String.fromCharCode(parseInt(e, 16))) : d += zg[f] || f, e = !1;else if ("\\" === f) e = !0;else {
          if (f === a) {
            this.index++;this.tokens.push({ index: b, text: c, constant: !0,
              value: d });return;
          }d += f;
        }this.index++;
      }this.throwError("Unterminated quote", b);
    } };var s = function s(a, b) {
    this.lexer = a;this.options = b;
  };s.Program = "Program";s.ExpressionStatement = "ExpressionStatement";s.AssignmentExpression = "AssignmentExpression";s.ConditionalExpression = "ConditionalExpression";s.LogicalExpression = "LogicalExpression";s.BinaryExpression = "BinaryExpression";s.UnaryExpression = "UnaryExpression";s.CallExpression = "CallExpression";s.MemberExpression = "MemberExpression";s.Identifier = "Identifier";s.Literal = "Literal";s.ArrayExpression = "ArrayExpression";s.Property = "Property";s.ObjectExpression = "ObjectExpression";s.ThisExpression = "ThisExpression";s.NGValueParameter = "NGValueParameter";s.prototype = { ast: function ast(a) {
      this.text = a;this.tokens = this.lexer.lex(a);a = this.program();0 !== this.tokens.length && this.throwError("is an unexpected token", this.tokens[0]);return a;
    }, program: function program() {
      for (var a = [];;) {
        if (0 < this.tokens.length && !this.peek("}", ")", ";", "]") && a.push(this.expressionStatement()), !this.expect(";")) return { type: s.Program,
          body: a };
      }
    }, expressionStatement: function expressionStatement() {
      return { type: s.ExpressionStatement, expression: this.filterChain() };
    }, filterChain: function filterChain() {
      for (var a = this.expression(); this.expect("|");) {
        a = this.filter(a);
      }return a;
    }, expression: function expression() {
      return this.assignment();
    }, assignment: function assignment() {
      var a = this.ternary();this.expect("=") && (a = { type: s.AssignmentExpression, left: a, right: this.assignment(), operator: "=" });return a;
    }, ternary: function ternary() {
      var a = this.logicalOR(),
          b,
          d;return this.expect("?") && (b = this.expression(), this.consume(":")) ? (d = this.expression(), { type: s.ConditionalExpression, test: a, alternate: b, consequent: d }) : a;
    }, logicalOR: function logicalOR() {
      for (var a = this.logicalAND(); this.expect("||");) {
        a = { type: s.LogicalExpression, operator: "||", left: a, right: this.logicalAND() };
      }return a;
    }, logicalAND: function logicalAND() {
      for (var a = this.equality(); this.expect("&&");) {
        a = { type: s.LogicalExpression, operator: "&&", left: a, right: this.equality() };
      }return a;
    }, equality: function equality() {
      for (var a = this.relational(), b; b = this.expect("==", "!=", "===", "!==");) {
        a = { type: s.BinaryExpression,
          operator: b.text, left: a, right: this.relational() };
      }return a;
    }, relational: function relational() {
      for (var a = this.additive(), b; b = this.expect("<", ">", "<=", ">=");) {
        a = { type: s.BinaryExpression, operator: b.text, left: a, right: this.additive() };
      }return a;
    }, additive: function additive() {
      for (var a = this.multiplicative(), b; b = this.expect("+", "-");) {
        a = { type: s.BinaryExpression, operator: b.text, left: a, right: this.multiplicative() };
      }return a;
    }, multiplicative: function multiplicative() {
      for (var a = this.unary(), b; b = this.expect("*", "/", "%");) {
        a = { type: s.BinaryExpression, operator: b.text,
          left: a, right: this.unary() };
      }return a;
    }, unary: function unary() {
      var a;return (a = this.expect("+", "-", "!")) ? { type: s.UnaryExpression, operator: a.text, prefix: !0, argument: this.unary() } : this.primary();
    }, primary: function primary() {
      var a;this.expect("(") ? (a = this.filterChain(), this.consume(")")) : this.expect("[") ? a = this.arrayDeclaration() : this.expect("{") ? a = this.object() : this.constants.hasOwnProperty(this.peek().text) ? a = Ma(this.constants[this.consume().text]) : this.peek().identifier ? a = this.identifier() : this.peek().constant ? a = this.constant() : this.throwError("not a primary expression", this.peek());for (var b; b = this.expect("(", "[", ".");) {
        "(" === b.text ? (a = { type: s.CallExpression, callee: a, arguments: this.parseArguments() }, this.consume(")")) : "[" === b.text ? (a = { type: s.MemberExpression, object: a, property: this.expression(), computed: !0 }, this.consume("]")) : "." === b.text ? a = { type: s.MemberExpression, object: a, property: this.identifier(), computed: !1 } : this.throwError("IMPOSSIBLE");
      }return a;
    }, filter: function filter(a) {
      a = [a];for (var b = { type: s.CallExpression, callee: this.identifier(),
        arguments: a, filter: !0 }; this.expect(":");) {
        a.push(this.expression());
      }return b;
    }, parseArguments: function parseArguments() {
      var a = [];if (")" !== this.peekToken().text) {
        do {
          a.push(this.expression());
        } while (this.expect(","));
      }return a;
    }, identifier: function identifier() {
      var a = this.consume();a.identifier || this.throwError("is not a valid identifier", a);return { type: s.Identifier, name: a.text };
    }, constant: function constant() {
      return { type: s.Literal, value: this.consume().value };
    }, arrayDeclaration: function arrayDeclaration() {
      var a = [];if ("]" !== this.peekToken().text) {
        do {
          if (this.peek("]")) break;
          a.push(this.expression());
        } while (this.expect(","));
      }this.consume("]");return { type: s.ArrayExpression, elements: a };
    }, object: function object() {
      var a = [],
          b;if ("}" !== this.peekToken().text) {
        do {
          if (this.peek("}")) break;b = { type: s.Property, kind: "init" };this.peek().constant ? b.key = this.constant() : this.peek().identifier ? b.key = this.identifier() : this.throwError("invalid key", this.peek());this.consume(":");b.value = this.expression();a.push(b);
        } while (this.expect(","));
      }this.consume("}");return { type: s.ObjectExpression, properties: a };
    },
    throwError: function throwError(a, b) {
      throw aa("syntax", b.text, a, b.index + 1, this.text, this.text.substring(b.index));
    }, consume: function consume(a) {
      if (0 === this.tokens.length) throw aa("ueoe", this.text);var b = this.expect(a);b || this.throwError("is unexpected, expecting [" + a + "]", this.peek());return b;
    }, peekToken: function peekToken() {
      if (0 === this.tokens.length) throw aa("ueoe", this.text);return this.tokens[0];
    }, peek: function peek(a, b, d, c) {
      return this.peekAhead(0, a, b, d, c);
    }, peekAhead: function peekAhead(a, b, d, c, e) {
      if (this.tokens.length > a) {
        a = this.tokens[a];
        var f = a.text;if (f === b || f === d || f === c || f === e || !(b || d || c || e)) return a;
      }return !1;
    }, expect: function expect(a, b, d, c) {
      return (a = this.peek(a, b, d, c)) ? (this.tokens.shift(), a) : !1;
    }, constants: { "true": { type: s.Literal, value: !0 }, "false": { type: s.Literal, value: !1 }, "null": { type: s.Literal, value: null }, undefined: { type: s.Literal, value: w }, "this": { type: s.ThisExpression } } };td.prototype = { compile: function compile(a, b) {
      var d = this,
          c = this.astBuilder.ast(a);this.state = { nextId: 0, filters: {}, expensiveChecks: b, fn: { vars: [], body: [], own: {} }, assign: { vars: [],
          body: [], own: {} }, inputs: [] };V(c, d.$filter);var e = "",
          f;this.stage = "assign";if (f = rd(c)) this.state.computing = "assign", e = this.nextId(), this.recurse(f, e), this.return_(e), e = "fn.assign=" + this.generateFunction("assign", "s,v,l");f = pd(c.body);d.stage = "inputs";n(f, function (a, b) {
        var c = "fn" + b;d.state[c] = { vars: [], body: [], own: {} };d.state.computing = c;var e = d.nextId();d.recurse(a, e);d.return_(e);d.state.inputs.push(c);a.watchId = b;
      });this.state.computing = "fn";this.stage = "main";this.recurse(c);e = '"' + this.USE + " " + this.STRICT + '";\n' + this.filterPrefix() + "var fn=" + this.generateFunction("fn", "s,l,a,i") + e + this.watchFns() + "return fn;";e = new Function("$filter", "ensureSafeMemberName", "ensureSafeObject", "ensureSafeFunction", "getStringValue", "ensureSafeAssignContext", "ifDefined", "plus", "text", e)(this.$filter, Va, ya, md, ld, nd, dg, od, a);this.state = this.stage = w;e.literal = sd(c);e.constant = c.constant;return e;
    }, USE: "use", STRICT: "strict", watchFns: function watchFns() {
      var a = [],
          b = this.state.inputs,
          d = this;n(b, function (b) {
        a.push("var " + b + "=" + d.generateFunction(b, "s"));
      });b.length && a.push("fn.inputs=[" + b.join(",") + "];");return a.join("");
    }, generateFunction: function generateFunction(a, b) {
      return "function(" + b + "){" + this.varsPrefix(a) + this.body(a) + "};";
    }, filterPrefix: function filterPrefix() {
      var a = [],
          b = this;n(this.state.filters, function (d, c) {
        a.push(d + "=$filter(" + b.escape(c) + ")");
      });return a.length ? "var " + a.join(",") + ";" : "";
    }, varsPrefix: function varsPrefix(a) {
      return this.state[a].vars.length ? "var " + this.state[a].vars.join(",") + ";" : "";
    }, body: function body(a) {
      return this.state[a].body.join("");
    }, recurse: function recurse(a, b, d, c, e, f) {
      var g,
          h,
          k = this,
          l,
          m;c = c || z;if (!f && u(a.watchId)) b = b || this.nextId(), this.if_("i", this.lazyAssign(b, this.computedMember("i", a.watchId)), this.lazyRecurse(a, b, d, c, e, !0));else switch (a.type) {case s.Program:
          n(a.body, function (b, c) {
            k.recurse(b.expression, w, w, function (a) {
              h = a;
            });c !== a.body.length - 1 ? k.current().body.push(h, ";") : k.return_(h);
          });break;case s.Literal:
          m = this.escape(a.value);this.assign(b, m);c(m);break;case s.UnaryExpression:
          this.recurse(a.argument, w, w, function (a) {
            h = a;
          });m = a.operator + "(" + this.ifDefined(h, 0) + ")";this.assign(b, m);c(m);break;case s.BinaryExpression:
          this.recurse(a.left, w, w, function (a) {
            g = a;
          });this.recurse(a.right, w, w, function (a) {
            h = a;
          });m = "+" === a.operator ? this.plus(g, h) : "-" === a.operator ? this.ifDefined(g, 0) + a.operator + this.ifDefined(h, 0) : "(" + g + ")" + a.operator + "(" + h + ")";this.assign(b, m);c(m);break;case s.LogicalExpression:
          b = b || this.nextId();k.recurse(a.left, b);k.if_("&&" === a.operator ? b : k.not(b), k.lazyRecurse(a.right, b));c(b);break;case s.ConditionalExpression:
          b = b || this.nextId();k.recurse(a.test, b);k.if_(b, k.lazyRecurse(a.alternate, b), k.lazyRecurse(a.consequent, b));c(b);break;case s.Identifier:
          b = b || this.nextId();d && (d.context = "inputs" === k.stage ? "s" : this.assign(this.nextId(), this.getHasOwnProperty("l", a.name) + "?l:s"), d.computed = !1, d.name = a.name);Va(a.name);k.if_("inputs" === k.stage || k.not(k.getHasOwnProperty("l", a.name)), function () {
            k.if_("inputs" === k.stage || "s", function () {
              e && 1 !== e && k.if_(k.not(k.nonComputedMember("s", a.name)), k.lazyAssign(k.nonComputedMember("s", a.name), "{}"));k.assign(b, k.nonComputedMember("s", a.name));
            });
          }, b && k.lazyAssign(b, k.nonComputedMember("l", a.name)));(k.state.expensiveChecks || Hb(a.name)) && k.addEnsureSafeObject(b);c(b);break;case s.MemberExpression:
          g = d && (d.context = this.nextId()) || this.nextId();b = b || this.nextId();k.recurse(a.object, g, w, function () {
            k.if_(k.notNull(g), function () {
              if (a.computed) h = k.nextId(), k.recurse(a.property, h), k.getStringValue(h), k.addEnsureSafeMemberName(h), e && 1 !== e && k.if_(k.not(k.computedMember(g, h)), k.lazyAssign(k.computedMember(g, h), "{}")), m = k.ensureSafeObject(k.computedMember(g, h)), k.assign(b, m), d && (d.computed = !0, d.name = h);else {
                Va(a.property.name);e && 1 !== e && k.if_(k.not(k.nonComputedMember(g, a.property.name)), k.lazyAssign(k.nonComputedMember(g, a.property.name), "{}"));m = k.nonComputedMember(g, a.property.name);if (k.state.expensiveChecks || Hb(a.property.name)) m = k.ensureSafeObject(m);k.assign(b, m);d && (d.computed = !1, d.name = a.property.name);
              }
            }, function () {
              k.assign(b, "undefined");
            });c(b);
          }, !!e);break;case s.CallExpression:
          b = b || this.nextId();a.filter ? (h = k.filter(a.callee.name), l = [], n(a.arguments, function (a) {
            var b = k.nextId();k.recurse(a, b);l.push(b);
          }), m = h + "(" + l.join(",") + ")", k.assign(b, m), c(b)) : (h = k.nextId(), g = {}, l = [], k.recurse(a.callee, h, g, function () {
            k.if_(k.notNull(h), function () {
              k.addEnsureSafeFunction(h);n(a.arguments, function (a) {
                k.recurse(a, k.nextId(), w, function (a) {
                  l.push(k.ensureSafeObject(a));
                });
              });g.name ? (k.state.expensiveChecks || k.addEnsureSafeObject(g.context), m = k.member(g.context, g.name, g.computed) + "(" + l.join(",") + ")") : m = h + "(" + l.join(",") + ")";m = k.ensureSafeObject(m);k.assign(b, m);
            }, function () {
              k.assign(b, "undefined");
            });c(b);
          }));break;case s.AssignmentExpression:
          h = this.nextId();g = {};if (!qd(a.left)) throw aa("lval");this.recurse(a.left, w, g, function () {
            k.if_(k.notNull(g.context), function () {
              k.recurse(a.right, h);k.addEnsureSafeObject(k.member(g.context, g.name, g.computed));k.addEnsureSafeAssignContext(g.context);m = k.member(g.context, g.name, g.computed) + a.operator + h;k.assign(b, m);c(b || m);
            });
          }, 1);break;case s.ArrayExpression:
          l = [];n(a.elements, function (a) {
            k.recurse(a, k.nextId(), w, function (a) {
              l.push(a);
            });
          });
          m = "[" + l.join(",") + "]";this.assign(b, m);c(m);break;case s.ObjectExpression:
          l = [];n(a.properties, function (a) {
            k.recurse(a.value, k.nextId(), w, function (b) {
              l.push(k.escape(a.key.type === s.Identifier ? a.key.name : "" + a.key.value) + ":" + b);
            });
          });m = "{" + l.join(",") + "}";this.assign(b, m);c(m);break;case s.ThisExpression:
          this.assign(b, "s");c("s");break;case s.NGValueParameter:
          this.assign(b, "v"), c("v");}
    }, getHasOwnProperty: function getHasOwnProperty(a, b) {
      var d = a + "." + b,
          c = this.current().own;c.hasOwnProperty(d) || (c[d] = this.nextId(!1, a + "&&(" + this.escape(b) + " in " + a + ")"));return c[d];
    }, assign: function assign(a, b) {
      if (a) return this.current().body.push(a, "=", b, ";"), a;
    }, filter: function filter(a) {
      this.state.filters.hasOwnProperty(a) || (this.state.filters[a] = this.nextId(!0));return this.state.filters[a];
    }, ifDefined: function ifDefined(a, b) {
      return "ifDefined(" + a + "," + this.escape(b) + ")";
    }, plus: function plus(a, b) {
      return "plus(" + a + "," + b + ")";
    }, return_: function return_(a) {
      this.current().body.push("return ", a, ";");
    }, if_: function if_(a, b, d) {
      if (!0 === a) b();else {
        var c = this.current().body;c.push("if(", a, "){");b();c.push("}");d && (c.push("else{"), d(), c.push("}"));
      }
    }, not: function not(a) {
      return "!(" + a + ")";
    }, notNull: function notNull(a) {
      return a + "!=null";
    }, nonComputedMember: function nonComputedMember(a, b) {
      return a + "." + b;
    }, computedMember: function computedMember(a, b) {
      return a + "[" + b + "]";
    }, member: function member(a, b, d) {
      return d ? this.computedMember(a, b) : this.nonComputedMember(a, b);
    }, addEnsureSafeObject: function addEnsureSafeObject(a) {
      this.current().body.push(this.ensureSafeObject(a), ";");
    }, addEnsureSafeMemberName: function addEnsureSafeMemberName(a) {
      this.current().body.push(this.ensureSafeMemberName(a), ";");
    },
    addEnsureSafeFunction: function addEnsureSafeFunction(a) {
      this.current().body.push(this.ensureSafeFunction(a), ";");
    }, addEnsureSafeAssignContext: function addEnsureSafeAssignContext(a) {
      this.current().body.push(this.ensureSafeAssignContext(a), ";");
    }, ensureSafeObject: function ensureSafeObject(a) {
      return "ensureSafeObject(" + a + ",text)";
    }, ensureSafeMemberName: function ensureSafeMemberName(a) {
      return "ensureSafeMemberName(" + a + ",text)";
    }, ensureSafeFunction: function ensureSafeFunction(a) {
      return "ensureSafeFunction(" + a + ",text)";
    }, getStringValue: function getStringValue(a) {
      this.assign(a, "getStringValue(" + a + ",text)");
    }, ensureSafeAssignContext: function ensureSafeAssignContext(a) {
      return "ensureSafeAssignContext(" + a + ",text)";
    }, lazyRecurse: function lazyRecurse(a, b, d, c, e, f) {
      var g = this;return function () {
        g.recurse(a, b, d, c, e, f);
      };
    }, lazyAssign: function lazyAssign(a, b) {
      var d = this;return function () {
        d.assign(a, b);
      };
    }, stringEscapeRegex: /[^ a-zA-Z0-9]/g, stringEscapeFn: function stringEscapeFn(a) {
      return "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4);
    }, escape: function escape(a) {
      if (F(a)) return "'" + a.replace(this.stringEscapeRegex, this.stringEscapeFn) + "'";if (Q(a)) return a.toString();if (!0 === a) return "true";if (!1 === a) return "false";if (null === a) return "null";if ("undefined" === typeof a) return "undefined";throw aa("esc");
    }, nextId: function nextId(a, b) {
      var d = "v" + this.state.nextId++;a || this.current().vars.push(d + (b ? "=" + b : ""));return d;
    }, current: function current() {
      return this.state[this.state.computing];
    } };ud.prototype = { compile: function compile(a, b) {
      var d = this,
          c = this.astBuilder.ast(a);this.expression = a;this.expensiveChecks = b;V(c, d.$filter);var e, f;if (e = rd(c)) f = this.recurse(e);e = pd(c.body);var g;e && (g = [], n(e, function (a, b) {
        var c = d.recurse(a);a.input = c;g.push(c);a.watchId = b;
      }));var h = [];n(c.body, function (a) {
        h.push(d.recurse(a.expression));
      });
      e = 0 === c.body.length ? function () {} : 1 === c.body.length ? h[0] : function (a, b) {
        var c;n(h, function (d) {
          c = d(a, b);
        });return c;
      };f && (e.assign = function (a, b, c) {
        return f(a, c, b);
      });g && (e.inputs = g);e.literal = sd(c);e.constant = c.constant;return e;
    }, recurse: function recurse(a, b, d) {
      var c,
          e,
          f = this,
          g;if (a.input) return this.inputs(a.input, a.watchId);switch (a.type) {case s.Literal:
          return this.value(a.value, b);case s.UnaryExpression:
          return e = this.recurse(a.argument), this["unary" + a.operator](e, b);case s.BinaryExpression:
          return c = this.recurse(a.left), e = this.recurse(a.right), this["binary" + a.operator](c, e, b);case s.LogicalExpression:
          return c = this.recurse(a.left), e = this.recurse(a.right), this["binary" + a.operator](c, e, b);case s.ConditionalExpression:
          return this["ternary?:"](this.recurse(a.test), this.recurse(a.alternate), this.recurse(a.consequent), b);case s.Identifier:
          return Va(a.name, f.expression), f.identifier(a.name, f.expensiveChecks || Hb(a.name), b, d, f.expression);case s.MemberExpression:
          return c = this.recurse(a.object, !1, !!d), a.computed || (Va(a.property.name, f.expression), e = a.property.name), a.computed && (e = this.recurse(a.property)), a.computed ? this.computedMember(c, e, b, d, f.expression) : this.nonComputedMember(c, e, f.expensiveChecks, b, d, f.expression);case s.CallExpression:
          return g = [], n(a.arguments, function (a) {
            g.push(f.recurse(a));
          }), a.filter && (e = this.$filter(a.callee.name)), a.filter || (e = this.recurse(a.callee, !0)), a.filter ? function (a, c, d, f) {
            for (var r = [], n = 0; n < g.length; ++n) {
              r.push(g[n](a, c, d, f));
            }a = e.apply(w, r, f);return b ? { context: w, name: w, value: a } : a;
          } : function (a, c, d, m) {
            var n = e(a, c, d, m),
                t;if (null != n.value) {
              ya(n.context, f.expression);md(n.value, f.expression);t = [];for (var q = 0; q < g.length; ++q) {
                t.push(ya(g[q](a, c, d, m), f.expression));
              }t = ya(n.value.apply(n.context, t), f.expression);
            }return b ? { value: t } : t;
          };case s.AssignmentExpression:
          return c = this.recurse(a.left, !0, 1), e = this.recurse(a.right), function (a, d, g, m) {
            var n = c(a, d, g, m);a = e(a, d, g, m);ya(n.value, f.expression);nd(n.context);n.context[n.name] = a;return b ? { value: a } : a;
          };case s.ArrayExpression:
          return g = [], n(a.elements, function (a) {
            g.push(f.recurse(a));
          }), function (a, c, d, e) {
            for (var f = [], n = 0; n < g.length; ++n) {
              f.push(g[n](a, c, d, e));
            }return b ? { value: f } : f;
          };case s.ObjectExpression:
          return g = [], n(a.properties, function (a) {
            g.push({ key: a.key.type === s.Identifier ? a.key.name : "" + a.key.value, value: f.recurse(a.value) });
          }), function (a, c, d, e) {
            for (var f = {}, n = 0; n < g.length; ++n) {
              f[g[n].key] = g[n].value(a, c, d, e);
            }return b ? { value: f } : f;
          };case s.ThisExpression:
          return function (a) {
            return b ? { value: a } : a;
          };case s.NGValueParameter:
          return function (a, c, d, e) {
            return b ? { value: d } : d;
          };}
    }, "unary+": function unary(a, b) {
      return function (d, c, e, f) {
        d = a(d, c, e, f);d = u(d) ? +d : 0;return b ? { value: d } : d;
      };
    }, "unary-": function unary(a, b) {
      return function (d, c, e, f) {
        d = a(d, c, e, f);d = u(d) ? -d : 0;return b ? { value: d } : d;
      };
    }, "unary!": function unary(a, b) {
      return function (d, c, e, f) {
        d = !a(d, c, e, f);return b ? { value: d } : d;
      };
    }, "binary+": function binary(a, b, d) {
      return function (c, e, f, g) {
        var h = a(c, e, f, g);c = b(c, e, f, g);h = od(h, c);return d ? { value: h } : h;
      };
    }, "binary-": function binary(a, b, d) {
      return function (c, e, f, g) {
        var h = a(c, e, f, g);c = b(c, e, f, g);h = (u(h) ? h : 0) - (u(c) ? c : 0);return d ? { value: h } : h;
      };
    }, "binary*": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) * b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary/": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) / b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary%": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) % b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary===": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) === b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary!==": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) !== b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary==": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) == b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary!=": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) != b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary<": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) < b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary>": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) > b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary<=": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) <= b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary>=": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) >= b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary&&": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) && b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "binary||": function binary(a, b, d) {
      return function (c, e, f, g) {
        c = a(c, e, f, g) || b(c, e, f, g);return d ? { value: c } : c;
      };
    }, "ternary?:": function ternary(a, b, d, c) {
      return function (e, f, g, h) {
        e = a(e, f, g, h) ? b(e, f, g, h) : d(e, f, g, h);return c ? { value: e } : e;
      };
    }, value: function value(a, b) {
      return function () {
        return b ? { context: w, name: w, value: a } : a;
      };
    }, identifier: function identifier(a, b, d, c, e) {
      return function (f, g, h, k) {
        f = g && a in g ? g : f;c && 1 !== c && f && !f[a] && (f[a] = {});g = f ? f[a] : w;b && ya(g, e);return d ? { context: f, name: a, value: g } : g;
      };
    }, computedMember: function computedMember(a, b, d, c, e) {
      return function (f, g, h, k) {
        var l = a(f, g, h, k),
            m,
            n;null != l && (m = b(f, g, h, k), m = ld(m), Va(m, e), c && 1 !== c && l && !l[m] && (l[m] = {}), n = l[m], ya(n, e));return d ? { context: l, name: m, value: n } : n;
      };
    }, nonComputedMember: function nonComputedMember(a, b, d, c, e, f) {
      return function (g, h, k, l) {
        g = a(g, h, k, l);e && 1 !== e && g && !g[b] && (g[b] = {});h = null != g ? g[b] : w;(d || Hb(b)) && ya(h, f);return c ? { context: g, name: b, value: h } : h;
      };
    }, inputs: function inputs(a, b) {
      return function (d, c, e, f) {
        return f ? f[b] : a(d, c, e);
      };
    } };var hc = function hc(a, b, d) {
    this.lexer = a;this.$filter = b;this.options = d;this.ast = new s(this.lexer);this.astCompiler = d.csp ? new ud(this.ast, b) : new td(this.ast, b);
  };hc.prototype = { constructor: hc, parse: function parse(a) {
      return this.astCompiler.compile(a, this.options.expensiveChecks);
    } };var eg = Object.prototype.valueOf,
      za = M("$sce"),
      ma = { HTML: "html", CSS: "css", URL: "url", RESOURCE_URL: "resourceUrl", JS: "js" },
      ga = M("$compile"),
      ba = W.createElement("a"),
      yd = xa(S.location.href);
  zd.$inject = ["$document"];Kc.$inject = ["$provide"];var Gd = 22,
      Fd = ".",
      jc = "0";Ad.$inject = ["$locale"];Cd.$inject = ["$locale"];var qg = { yyyy: ca("FullYear", 4), yy: ca("FullYear", 2, 0, !0), y: ca("FullYear", 1), MMMM: Jb("Month"), MMM: Jb("Month", !0), MM: ca("Month", 2, 1), M: ca("Month", 1, 1), dd: ca("Date", 2), d: ca("Date", 1), HH: ca("Hours", 2), H: ca("Hours", 1), hh: ca("Hours", 2, -12), h: ca("Hours", 1, -12), mm: ca("Minutes", 2), m: ca("Minutes", 1), ss: ca("Seconds", 2), s: ca("Seconds", 1), sss: ca("Milliseconds", 3), EEEE: Jb("Day"), EEE: Jb("Day", !0),
    a: function a(_a, b) {
      return 12 > _a.getHours() ? b.AMPMS[0] : b.AMPMS[1];
    }, Z: function Z(a, b, d) {
      a = -1 * d;return a = (0 <= a ? "+" : "") + (Ib(Math[0 < a ? "floor" : "ceil"](a / 60), 2) + Ib(Math.abs(a % 60), 2));
    }, ww: Id(2), w: Id(1), G: kc, GG: kc, GGG: kc, GGGG: function GGGG(a, b) {
      return 0 >= a.getFullYear() ? b.ERANAMES[0] : b.ERANAMES[1];
    } },
      pg = /((?:[^yMdHhmsaZEwG']+)|(?:'(?:[^']|'')*')|(?:E+|y+|M+|d+|H+|h+|m+|s+|a|Z|G+|w+))(.*)/,
      og = /^\-?\d+$/;Bd.$inject = ["$locale"];var jg = na(K),
      kg = na(tb);Dd.$inject = ["$parse"];var le = na({ restrict: "E", compile: function compile(a, b) {
      if (!b.href && !b.xlinkHref) return function (a, b) {
        if ("a" === b[0].nodeName.toLowerCase()) {
          var e = "[object SVGAnimatedString]" === ta.call(b.prop("href")) ? "xlink:href" : "href";b.on("click", function (a) {
            b.attr(e) || a.preventDefault();
          });
        }
      };
    } }),
      ub = {};n(Db, function (a, b) {
    function d(a, d, e) {
      a.$watch(e[c], function (a) {
        e.$set(b, !!a);
      });
    }if ("multiple" != a) {
      var c = va("ng-" + b),
          e = d;"checked" === a && (e = function e(a, b, _e) {
        _e.ngModel !== _e[c] && d(a, b, _e);
      });ub[c] = function () {
        return { restrict: "A", priority: 100, link: e };
      };
    }
  });n(ad, function (a, b) {
    ub[b] = function () {
      return { priority: 100,
        link: function link(a, c, e) {
          if ("ngPattern" === b && "/" == e.ngPattern.charAt(0) && (c = e.ngPattern.match(sg))) {
            e.$set("ngPattern", new RegExp(c[1], c[2]));return;
          }a.$watch(e[b], function (a) {
            e.$set(b, a);
          });
        } };
    };
  });n(["src", "srcset", "href"], function (a) {
    var b = va("ng-" + a);ub[b] = function () {
      return { priority: 99, link: function link(d, c, e) {
          var f = a,
              g = a;"href" === a && "[object SVGAnimatedString]" === ta.call(c.prop("href")) && (g = "xlinkHref", e.$attr[g] = "xlink:href", f = null);e.$observe(b, function (b) {
            b ? (e.$set(g, b), Ha && f && c.prop(f, e[g])) : "href" === a && e.$set(g, null);
          });
        } };
    };
  });var Kb = { $addControl: z, $$renameControl: function $$renameControl(a, b) {
      a.$name = b;
    }, $removeControl: z, $setValidity: z, $setDirty: z, $setPristine: z, $setSubmitted: z };Jd.$inject = ["$element", "$attrs", "$scope", "$animate", "$interpolate"];var Rd = function Rd(a) {
    return ["$timeout", "$parse", function (b, d) {
      function c(a) {
        return "" === a ? d('this[""]').assign : d(a).assign || z;
      }return { name: "form", restrict: a ? "EAC" : "E", require: ["form", "^^?form"], controller: Jd, compile: function compile(d, f) {
          d.addClass(Wa).addClass(nb);var g = f.name ? "name" : a && f.ngForm ? "ngForm" : !1;return { pre: function pre(a, d, e, f) {
              var n = f[0];if (!("action" in e)) {
                var t = function t(b) {
                  a.$apply(function () {
                    n.$commitViewValue();n.$setSubmitted();
                  });b.preventDefault();
                };d[0].addEventListener("submit", t, !1);d.on("$destroy", function () {
                  b(function () {
                    d[0].removeEventListener("submit", t, !1);
                  }, 0, !1);
                });
              }(f[1] || n.$$parentForm).$addControl(n);var q = g ? c(n.$name) : z;g && (q(a, n), e.$observe(g, function (b) {
                n.$name !== b && (q(a, w), n.$$parentForm.$$renameControl(n, b), q = c(n.$name), q(a, n));
              }));d.on("$destroy", function () {
                n.$$parentForm.$removeControl(n);q(a, w);N(n, Kb);
              });
            } };
        } };
    }];
  },
      me = Rd(),
      ze = Rd(!0),
      rg = /\d{4}-[01]\d-[0-3]\dT[0-2]\d:[0-5]\d:[0-5]\d\.\d+([+-][0-2]\d:[0-5]\d|Z)/,
      Ag = /^[a-z][a-z\d.+-]*:\/*(?:[^:@]+(?::[^@]+)?@)?(?:[^\s:/?#]+|\[[a-f\d:]+\])(?::\d+)?(?:\/[^?#]*)?(?:\?[^#]*)?(?:#.*)?$/i,
      Bg = /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i,
      Cg = /^\s*(\-|\+)?(\d+|(\d*(\.\d*)))([eE][+-]?\d+)?\s*$/,
      Sd = /^(\d{4})-(\d{2})-(\d{2})$/,
      Td = /^(\d{4})-(\d\d)-(\d\d)T(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/,
      nc = /^(\d{4})-W(\d\d)$/,
      Ud = /^(\d{4})-(\d\d)$/,
      Vd = /^(\d\d):(\d\d)(?::(\d\d)(\.\d{1,3})?)?$/,
      Wd = { text: function text(a, b, d, c, e, f) {
      kb(a, b, d, c, e, f);lc(c);
    }, date: lb("date", Sd, Mb(Sd, ["yyyy", "MM", "dd"]), "yyyy-MM-dd"), "datetime-local": lb("datetimelocal", Td, Mb(Td, "yyyy MM dd HH mm ss sss".split(" ")), "yyyy-MM-ddTHH:mm:ss.sss"), time: lb("time", Vd, Mb(Vd, ["HH", "mm", "ss", "sss"]), "HH:mm:ss.sss"), week: lb("week", nc, function (a, b) {
      if (da(a)) return a;if (F(a)) {
        nc.lastIndex = 0;var d = nc.exec(a);if (d) {
          var c = +d[1],
              e = +d[2],
              f = d = 0,
              g = 0,
              h = 0,
              k = Hd(c),
              e = 7 * (e - 1);b && (d = b.getHours(), f = b.getMinutes(), g = b.getSeconds(), h = b.getMilliseconds());return new Date(c, 0, k.getDate() + e, d, f, g, h);
        }
      }return NaN;
    }, "yyyy-Www"), month: lb("month", Ud, Mb(Ud, ["yyyy", "MM"]), "yyyy-MM"), number: function number(a, b, d, c, e, f) {
      Ld(a, b, d, c);kb(a, b, d, c, e, f);c.$$parserName = "number";c.$parsers.push(function (a) {
        return c.$isEmpty(a) ? null : Cg.test(a) ? parseFloat(a) : w;
      });c.$formatters.push(function (a) {
        if (!c.$isEmpty(a)) {
          if (!Q(a)) throw mb("numfmt", a);a = a.toString();
        }return a;
      });if (u(d.min) || d.ngMin) {
        var g;c.$validators.min = function (a) {
          return c.$isEmpty(a) || q(g) || a >= g;
        };d.$observe("min", function (a) {
          u(a) && !Q(a) && (a = parseFloat(a, 10));g = Q(a) && !isNaN(a) ? a : w;c.$validate();
        });
      }if (u(d.max) || d.ngMax) {
        var h;c.$validators.max = function (a) {
          return c.$isEmpty(a) || q(h) || a <= h;
        };d.$observe("max", function (a) {
          u(a) && !Q(a) && (a = parseFloat(a, 10));h = Q(a) && !isNaN(a) ? a : w;c.$validate();
        });
      }
    }, url: function url(a, b, d, c, e, f) {
      kb(a, b, d, c, e, f);lc(c);c.$$parserName = "url";c.$validators.url = function (a, b) {
        var d = a || b;return c.$isEmpty(d) || Ag.test(d);
      };
    }, email: function email(a, b, d, c, e, f) {
      kb(a, b, d, c, e, f);lc(c);c.$$parserName = "email";c.$validators.email = function (a, b) {
        var d = a || b;return c.$isEmpty(d) || Bg.test(d);
      };
    }, radio: function radio(a, b, d, c) {
      q(d.name) && b.attr("name", ++ob);b.on("click", function (a) {
        b[0].checked && c.$setViewValue(d.value, a && a.type);
      });c.$render = function () {
        b[0].checked = d.value == c.$viewValue;
      };d.$observe("value", c.$render);
    }, checkbox: function checkbox(a, b, d, c, e, f, g, h) {
      var k = Md(h, a, "ngTrueValue", d.ngTrueValue, !0),
          l = Md(h, a, "ngFalseValue", d.ngFalseValue, !1);b.on("click", function (a) {
        c.$setViewValue(b[0].checked, a && a.type);
      });c.$render = function () {
        b[0].checked = c.$viewValue;
      };c.$isEmpty = function (a) {
        return !1 === a;
      };c.$formatters.push(function (a) {
        return ka(a, k);
      });c.$parsers.push(function (a) {
        return a ? k : l;
      });
    }, hidden: z, button: z, submit: z, reset: z, file: z },
      Ec = ["$browser", "$sniffer", "$filter", "$parse", function (a, b, d, c) {
    return { restrict: "E", require: ["?ngModel"], link: { pre: function pre(e, f, g, h) {
          h[0] && (Wd[K(g.type)] || Wd.text)(e, f, g, h[0], b, a, d, c);
        } } };
  }],
      Dg = /^(true|false|\d+)$/,
      Re = function Re() {
    return { restrict: "A", priority: 100, compile: function compile(a, b) {
        return Dg.test(b.ngValue) ? function (a, b, e) {
          e.$set("value", a.$eval(e.ngValue));
        } : function (a, b, e) {
          a.$watch(e.ngValue, function (a) {
            e.$set("value", a);
          });
        };
      } };
  },
      re = ["$compile", function (a) {
    return { restrict: "AC", compile: function compile(b) {
        a.$$addBindingClass(b);return function (b, c, e) {
          a.$$addBindingInfo(c, e.ngBind);c = c[0];b.$watch(e.ngBind, function (a) {
            c.textContent = q(a) ? "" : a;
          });
        };
      } };
  }],
      te = ["$interpolate", "$compile", function (a, b) {
    return { compile: function compile(d) {
        b.$$addBindingClass(d);
        return function (c, d, f) {
          c = a(d.attr(f.$attr.ngBindTemplate));b.$$addBindingInfo(d, c.expressions);d = d[0];f.$observe("ngBindTemplate", function (a) {
            d.textContent = q(a) ? "" : a;
          });
        };
      } };
  }],
      se = ["$sce", "$parse", "$compile", function (a, b, d) {
    return { restrict: "A", compile: function compile(c, e) {
        var f = b(e.ngBindHtml),
            g = b(e.ngBindHtml, function (a) {
          return (a || "").toString();
        });d.$$addBindingClass(c);return function (b, c, e) {
          d.$$addBindingInfo(c, e.ngBindHtml);b.$watch(g, function () {
            c.html(a.getTrustedHtml(f(b)) || "");
          });
        };
      } };
  }],
      Qe = na({ restrict: "A",
    require: "ngModel", link: function link(a, b, d, c) {
      c.$viewChangeListeners.push(function () {
        a.$eval(d.ngChange);
      });
    } }),
      ue = mc("", !0),
      we = mc("Odd", 0),
      ve = mc("Even", 1),
      xe = Ka({ compile: function compile(a, b) {
      b.$set("ngCloak", w);a.removeClass("ng-cloak");
    } }),
      ye = [function () {
    return { restrict: "A", scope: !0, controller: "@", priority: 500 };
  }],
      Jc = {},
      Eg = { blur: !0, focus: !0 };n("click dblclick mousedown mouseup mouseover mouseout mousemove mouseenter mouseleave keydown keyup keypress submit focus blur copy cut paste".split(" "), function (a) {
    var b = va("ng-" + a);Jc[b] = ["$parse", "$rootScope", function (d, c) {
      return { restrict: "A", compile: function compile(e, f) {
          var g = d(f[b], null, !0);return function (b, d) {
            d.on(a, function (d) {
              var e = function e() {
                g(b, { $event: d });
              };Eg[a] && c.$$phase ? b.$evalAsync(e) : b.$apply(e);
            });
          };
        } };
    }];
  });var Be = ["$animate", function (a) {
    return { multiElement: !0, transclude: "element", priority: 600, terminal: !0, restrict: "A", $$tlb: !0, link: function link(b, d, c, e, f) {
        var g, h, k;b.$watch(c.ngIf, function (b) {
          b ? h || f(function (b, e) {
            h = e;b[b.length++] = W.createComment(" end ngIf: " + c.ngIf + " ");g = { clone: b };a.enter(b, d.parent(), d);
          }) : (k && (k.remove(), k = null), h && (h.$destroy(), h = null), g && (k = sb(g.clone), a.leave(k).then(function () {
            k = null;
          }), g = null));
        });
      } };
  }],
      Ce = ["$templateRequest", "$anchorScroll", "$animate", function (a, b, d) {
    return { restrict: "ECA", priority: 400, terminal: !0, transclude: "element", controller: $.noop, compile: function compile(c, e) {
        var f = e.ngInclude || e.src,
            g = e.onload || "",
            h = e.autoscroll;return function (c, e, m, n, q) {
          var s = 0,
              y,
              w,
              p,
              x = function x() {
            w && (w.remove(), w = null);y && (y.$destroy(), y = null);p && (d.leave(p).then(function () {
              w = null;
            }), w = p, p = null);
          };c.$watch(f, function (f) {
            var m = function m() {
              !u(h) || h && !c.$eval(h) || b();
            },
                H = ++s;f ? (a(f, !0).then(function (a) {
              if (!c.$$destroyed && H === s) {
                var b = c.$new();n.template = a;a = q(b, function (a) {
                  x();d.enter(a, null, e).then(m);
                });y = b;p = a;y.$emit("$includeContentLoaded", f);c.$eval(g);
              }
            }, function () {
              c.$$destroyed || H !== s || (x(), c.$emit("$includeContentError", f));
            }), c.$emit("$includeContentRequested", f)) : (x(), n.template = null);
          });
        };
      } };
  }],
      Te = ["$compile", function (a) {
    return { restrict: "ECA",
      priority: -400, require: "ngInclude", link: function link(b, d, c, e) {
        /SVG/.test(d[0].toString()) ? (d.empty(), a(Mc(e.template, W).childNodes)(b, function (a) {
          d.append(a);
        }, { futureParentElement: d })) : (d.html(e.template), a(d.contents())(b));
      } };
  }],
      De = Ka({ priority: 450, compile: function compile() {
      return { pre: function pre(a, b, d) {
          a.$eval(d.ngInit);
        } };
    } }),
      Pe = function Pe() {
    return { restrict: "A", priority: 100, require: "ngModel", link: function link(a, b, d, c) {
        var e = b.attr(d.$attr.ngList) || ", ",
            f = "false" !== d.ngTrim,
            g = f ? T(e) : e;c.$parsers.push(function (a) {
          if (!q(a)) {
            var b = [];a && n(a.split(g), function (a) {
              a && b.push(f ? T(a) : a);
            });return b;
          }
        });c.$formatters.push(function (a) {
          return E(a) ? a.join(e) : w;
        });c.$isEmpty = function (a) {
          return !a || !a.length;
        };
      } };
  },
      nb = "ng-valid",
      Nd = "ng-invalid",
      Wa = "ng-pristine",
      Lb = "ng-dirty",
      Pd = "ng-pending",
      mb = M("ngModel"),
      Fg = ["$scope", "$exceptionHandler", "$attrs", "$element", "$parse", "$animate", "$timeout", "$rootScope", "$q", "$interpolate", function (a, b, d, c, e, f, g, h, k, l) {
    this.$modelValue = this.$viewValue = Number.NaN;this.$$rawModelValue = w;this.$validators = {};this.$asyncValidators = {};this.$parsers = [];this.$formatters = [];this.$viewChangeListeners = [];this.$untouched = !0;this.$touched = !1;this.$pristine = !0;this.$dirty = !1;this.$valid = !0;this.$invalid = !1;this.$error = {};this.$$success = {};this.$pending = w;this.$name = l(d.name || "", !1)(a);this.$$parentForm = Kb;var m = e(d.ngModel),
        r = m.assign,
        t = m,
        s = r,
        y = null,
        A,
        p = this;this.$$setOptions = function (a) {
      if ((p.$options = a) && a.getterSetter) {
        var b = e(d.ngModel + "()"),
            f = e(d.ngModel + "($$$p)");t = function t(a) {
          var c = m(a);B(c) && (c = b(a));return c;
        };s = function s(a, b) {
          B(m(a)) ? f(a, { $$$p: p.$modelValue }) : r(a, p.$modelValue);
        };
      } else if (!m.assign) throw mb("nonassign", d.ngModel, ua(c));
    };this.$render = z;this.$isEmpty = function (a) {
      return q(a) || "" === a || null === a || a !== a;
    };var x = 0;Kd({ ctrl: this, $element: c, set: function set(a, b) {
        a[b] = !0;
      }, unset: function unset(a, b) {
        delete a[b];
      }, $animate: f });this.$setPristine = function () {
      p.$dirty = !1;p.$pristine = !0;f.removeClass(c, Lb);f.addClass(c, Wa);
    };this.$setDirty = function () {
      p.$dirty = !0;p.$pristine = !1;f.removeClass(c, Wa);f.addClass(c, Lb);p.$$parentForm.$setDirty();
    };
    this.$setUntouched = function () {
      p.$touched = !1;p.$untouched = !0;f.setClass(c, "ng-untouched", "ng-touched");
    };this.$setTouched = function () {
      p.$touched = !0;p.$untouched = !1;f.setClass(c, "ng-touched", "ng-untouched");
    };this.$rollbackViewValue = function () {
      g.cancel(y);p.$viewValue = p.$$lastCommittedViewValue;p.$render();
    };this.$validate = function () {
      if (!Q(p.$modelValue) || !isNaN(p.$modelValue)) {
        var a = p.$$rawModelValue,
            b = p.$valid,
            c = p.$modelValue,
            d = p.$options && p.$options.allowInvalid;p.$$runValidators(a, p.$$lastCommittedViewValue, function (e) {
          d || b === e || (p.$modelValue = e ? a : w, p.$modelValue !== c && p.$$writeModelToScope());
        });
      }
    };this.$$runValidators = function (a, b, c) {
      function d() {
        var c = !0;n(p.$validators, function (d, e) {
          var g = d(a, b);c = c && g;f(e, g);
        });return c ? !0 : (n(p.$asyncValidators, function (a, b) {
          f(b, null);
        }), !1);
      }function e() {
        var c = [],
            d = !0;n(p.$asyncValidators, function (e, g) {
          var h = e(a, b);if (!h || !B(h.then)) throw mb("nopromise", h);f(g, w);c.push(h.then(function () {
            f(g, !0);
          }, function (a) {
            d = !1;f(g, !1);
          }));
        });c.length ? k.all(c).then(function () {
          g(d);
        }, z) : g(!0);
      }function f(a, b) {
        h === x && p.$setValidity(a, b);
      }function g(a) {
        h === x && c(a);
      }x++;var h = x;(function () {
        var a = p.$$parserName || "parse";if (q(A)) f(a, null);else return A || (n(p.$validators, function (a, b) {
          f(b, null);
        }), n(p.$asyncValidators, function (a, b) {
          f(b, null);
        })), f(a, A), A;return !0;
      })() ? d() ? e() : g(!1) : g(!1);
    };this.$commitViewValue = function () {
      var a = p.$viewValue;g.cancel(y);if (p.$$lastCommittedViewValue !== a || "" === a && p.$$hasNativeValidators) p.$$lastCommittedViewValue = a, p.$pristine && this.$setDirty(), this.$$parseAndValidate();
    };
    this.$$parseAndValidate = function () {
      var b = p.$$lastCommittedViewValue;if (A = q(b) ? w : !0) for (var c = 0; c < p.$parsers.length; c++) {
        if (b = p.$parsers[c](b), q(b)) {
          A = !1;break;
        }
      }Q(p.$modelValue) && isNaN(p.$modelValue) && (p.$modelValue = t(a));var d = p.$modelValue,
          e = p.$options && p.$options.allowInvalid;p.$$rawModelValue = b;e && (p.$modelValue = b, p.$modelValue !== d && p.$$writeModelToScope());p.$$runValidators(b, p.$$lastCommittedViewValue, function (a) {
        e || (p.$modelValue = a ? b : w, p.$modelValue !== d && p.$$writeModelToScope());
      });
    };this.$$writeModelToScope = function () {
      s(a, p.$modelValue);n(p.$viewChangeListeners, function (a) {
        try {
          a();
        } catch (c) {
          b(c);
        }
      });
    };this.$setViewValue = function (a, b) {
      p.$viewValue = a;p.$options && !p.$options.updateOnDefault || p.$$debounceViewValueCommit(b);
    };this.$$debounceViewValueCommit = function (b) {
      var c = 0,
          d = p.$options;d && u(d.debounce) && (d = d.debounce, Q(d) ? c = d : Q(d[b]) ? c = d[b] : Q(d["default"]) && (c = d["default"]));g.cancel(y);c ? y = g(function () {
        p.$commitViewValue();
      }, c) : h.$$phase ? p.$commitViewValue() : a.$apply(function () {
        p.$commitViewValue();
      });
    };a.$watch(function () {
      var b = t(a);if (b !== p.$modelValue && (p.$modelValue === p.$modelValue || b === b)) {
        p.$modelValue = p.$$rawModelValue = b;A = w;for (var c = p.$formatters, d = c.length, e = b; d--;) {
          e = c[d](e);
        }p.$viewValue !== e && (p.$viewValue = p.$$lastCommittedViewValue = e, p.$render(), p.$$runValidators(b, e, z));
      }return b;
    });
  }],
      Oe = ["$rootScope", function (a) {
    return { restrict: "A", require: ["ngModel", "^?form", "^?ngModelOptions"], controller: Fg, priority: 1, compile: function compile(b) {
        b.addClass(Wa).addClass("ng-untouched").addClass(nb);return { pre: function pre(a, b, e, f) {
            var g = f[0];b = f[1] || g.$$parentForm;g.$$setOptions(f[2] && f[2].$options);b.$addControl(g);e.$observe("name", function (a) {
              g.$name !== a && g.$$parentForm.$$renameControl(g, a);
            });a.$on("$destroy", function () {
              g.$$parentForm.$removeControl(g);
            });
          }, post: function post(b, c, e, f) {
            var g = f[0];if (g.$options && g.$options.updateOn) c.on(g.$options.updateOn, function (a) {
              g.$$debounceViewValueCommit(a && a.type);
            });c.on("blur", function (c) {
              g.$touched || (a.$$phase ? b.$evalAsync(g.$setTouched) : b.$apply(g.$setTouched));
            });
          } };
      } };
  }],
      Gg = /(\s+|^)default(\s+|$)/,
      Se = function Se() {
    return { restrict: "A", controller: ["$scope", "$attrs", function (a, b) {
        var d = this;this.$options = Ma(a.$eval(b.ngModelOptions));u(this.$options.updateOn) ? (this.$options.updateOnDefault = !1, this.$options.updateOn = T(this.$options.updateOn.replace(Gg, function () {
          d.$options.updateOnDefault = !0;return " ";
        }))) : this.$options.updateOnDefault = !0;
      }] };
  },
      Ee = Ka({ terminal: !0, priority: 1E3 }),
      Hg = M("ngOptions"),
      Ig = /^\s*([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+group\s+by\s+([\s\S]+?))?(?:\s+disable\s+when\s+([\s\S]+?))?\s+for\s+(?:([\$\w][\$\w]*)|(?:\(\s*([\$\w][\$\w]*)\s*,\s*([\$\w][\$\w]*)\s*\)))\s+in\s+([\s\S]+?)(?:\s+track\s+by\s+([\s\S]+?))?$/,
      Me = ["$compile", "$parse", function (a, b) {
    function d(a, c, d) {
      function e(a, b, c, d, f) {
        this.selectValue = a;this.viewValue = b;this.label = c;this.group = d;this.disabled = f;
      }function l(a) {
        var b;if (!q && Aa(a)) b = a;else {
          b = [];for (var c in a) {
            a.hasOwnProperty(c) && "$" !== c.charAt(0) && b.push(c);
          }
        }return b;
      }var m = a.match(Ig);if (!m) throw Hg("iexp", a, ua(c));var n = m[5] || m[7],
          q = m[6];a = / as /.test(m[0]) && m[1];var s = m[9];c = b(m[2] ? m[1] : n);var y = a && b(a) || c,
          u = s && b(s),
          p = s ? function (a, b) {
        return u(d, b);
      } : function (a) {
        return Da(a);
      },
          x = function x(a, b) {
        return p(a, D(a, b));
      },
          v = b(m[2] || m[1]),
          w = b(m[3] || ""),
          H = b(m[4] || ""),
          A = b(m[8]),
          z = {},
          D = q ? function (a, b) {
        z[q] = b;z[n] = a;return z;
      } : function (a) {
        z[n] = a;return z;
      };return { trackBy: s, getTrackByValue: x, getWatchables: b(A, function (a) {
          var b = [];a = a || [];for (var c = l(a), e = c.length, f = 0; f < e; f++) {
            var g = a === c ? f : c[f],
                k = D(a[g], g),
                g = p(a[g], k);b.push(g);if (m[2] || m[1]) g = v(d, k), b.push(g);m[4] && (k = H(d, k), b.push(k));
          }return b;
        }), getOptions: function getOptions() {
          for (var a = [], b = {}, c = A(d) || [], f = l(c), g = f.length, m = 0; m < g; m++) {
            var n = c === f ? m : f[m],
                r = D(c[n], n),
                q = y(d, r),
                n = p(q, r),
                t = v(d, r),
                u = w(d, r),
                r = H(d, r),
                q = new e(n, q, t, u, r);a.push(q);b[n] = q;
          }return { items: a, selectValueMap: b, getOptionFromViewValue: function getOptionFromViewValue(a) {
              return b[x(a)];
            }, getViewValueFromOption: function getViewValueFromOption(a) {
              return s ? $.copy(a.viewValue) : a.viewValue;
            } };
        } };
    }var c = W.createElement("option"),
        e = W.createElement("optgroup");return { restrict: "A", terminal: !0, require: ["select", "?ngModel"], link: { pre: function pre(a, b, c, d) {
          d[0].registerOption = z;
        }, post: function post(b, g, h, k) {
          function l(a, b) {
            a.element = b;b.disabled = a.disabled;
            a.label !== b.label && (b.label = a.label, b.textContent = a.label);a.value !== b.value && (b.value = a.selectValue);
          }function m(a, b, c, d) {
            b && K(b.nodeName) === c ? c = b : (c = d.cloneNode(!1), b ? a.insertBefore(c, b) : a.appendChild(c));return c;
          }function r(a) {
            for (var b; a;) {
              b = a.nextSibling, Zb(a), a = b;
            }
          }function q(a) {
            var b = x && x[0],
                c = z && z[0];if (b || c) for (; a && (a === b || a === c || 8 === a.nodeType || "option" === oa(a) && "" === a.value);) {
              a = a.nextSibling;
            }return a;
          }function s() {
            var a = B && u.readValue();B = D.getOptions();var b = {},
                d = g[0].firstChild;H && g.prepend(x);
            d = q(d);B.items.forEach(function (a) {
              var f, h;a.group ? (f = b[a.group], f || (f = m(g[0], d, "optgroup", e), d = f.nextSibling, f.label = a.group, f = b[a.group] = { groupElement: f, currentOptionElement: f.firstChild }), h = m(f.groupElement, f.currentOptionElement, "option", c), l(a, h), f.currentOptionElement = h.nextSibling) : (h = m(g[0], d, "option", c), l(a, h), d = h.nextSibling);
            });Object.keys(b).forEach(function (a) {
              r(b[a].currentOptionElement);
            });r(d);y.$render();if (!y.$isEmpty(a)) {
              var f = u.readValue();(D.trackBy || p ? ka(a, f) : a === f) || (y.$setViewValue(f), y.$render());
            }
          }var y = k[1];if (y) {
            var u = k[0],
                p = h.multiple,
                x;k = 0;for (var v = g.children(), w = v.length; k < w; k++) {
              if ("" === v[k].value) {
                x = v.eq(k);break;
              }
            }var H = !!x,
                z = A(c.cloneNode(!1));z.val("?");var B,
                D = d(h.ngOptions, g, b);p ? (y.$isEmpty = function (a) {
              return !a || 0 === a.length;
            }, u.writeValue = function (a) {
              B.items.forEach(function (a) {
                a.element.selected = !1;
              });a && a.forEach(function (a) {
                (a = B.getOptionFromViewValue(a)) && !a.disabled && (a.element.selected = !0);
              });
            }, u.readValue = function () {
              var a = g.val() || [],
                  b = [];n(a, function (a) {
                (a = B.selectValueMap[a]) && !a.disabled && b.push(B.getViewValueFromOption(a));
              });return b;
            }, D.trackBy && b.$watchCollection(function () {
              if (E(y.$viewValue)) return y.$viewValue.map(function (a) {
                return D.getTrackByValue(a);
              });
            }, function () {
              y.$render();
            })) : (u.writeValue = function (a) {
              var b = B.getOptionFromViewValue(a);b && !b.disabled ? g[0].value !== b.selectValue && (z.remove(), H || x.remove(), g[0].value = b.selectValue, b.element.selected = !0, b.element.setAttribute("selected", "selected")) : null === a || H ? (z.remove(), H || g.prepend(x), g.val(""), x.prop("selected", !0), x.attr("selected", !0)) : (H || x.remove(), g.prepend(z), g.val("?"), z.prop("selected", !0), z.attr("selected", !0));
            }, u.readValue = function () {
              var a = B.selectValueMap[g.val()];return a && !a.disabled ? (H || x.remove(), z.remove(), B.getViewValueFromOption(a)) : null;
            }, D.trackBy && b.$watch(function () {
              return D.getTrackByValue(y.$viewValue);
            }, function () {
              y.$render();
            }));H ? (x.remove(), a(x)(b), x.removeClass("ng-scope")) : x = A(c.cloneNode(!1));s();b.$watchCollection(D.getWatchables, s);
          }
        } } };
  }],
      Fe = ["$locale", "$interpolate", "$log", function (a, b, d) {
    var c = /{}/g,
        e = /^when(Minus)?(.+)$/;return { link: function link(f, g, h) {
        function k(a) {
          g.text(a || "");
        }var l = h.count,
            m = h.$attr.when && g.attr(h.$attr.when),
            r = h.offset || 0,
            t = f.$eval(m) || {},
            s = {},
            u = b.startSymbol(),
            w = b.endSymbol(),
            p = u + l + "-" + r + w,
            x = $.noop,
            v;n(h, function (a, b) {
          var c = e.exec(b);c && (c = (c[1] ? "-" : "") + K(c[2]), t[c] = g.attr(h.$attr[b]));
        });n(t, function (a, d) {
          s[d] = b(a.replace(c, p));
        });f.$watch(l, function (b) {
          var c = parseFloat(b),
              e = isNaN(c);e || c in t || (c = a.pluralCat(c - r));c === v || e && Q(v) && isNaN(v) || (x(), e = s[c], q(e) ? (null != b && d.debug("ngPluralize: no rule defined for '" + c + "' in " + m), x = z, k()) : x = f.$watch(e, k), v = c);
        });
      } };
  }],
      Ge = ["$parse", "$animate", function (a, b) {
    var d = M("ngRepeat"),
        c = function c(a, b, _c, d, k, l, m) {
      a[_c] = d;k && (a[k] = l);a.$index = b;a.$first = 0 === b;a.$last = b === m - 1;a.$middle = !(a.$first || a.$last);a.$odd = !(a.$even = 0 === (b & 1));
    };return { restrict: "A", multiElement: !0, transclude: "element", priority: 1E3, terminal: !0, $$tlb: !0, compile: function compile(e, f) {
        var g = f.ngRepeat,
            h = W.createComment(" end ngRepeat: " + g + " "),
            k = g.match(/^\s*([\s\S]+?)\s+in\s+([\s\S]+?)(?:\s+as\s+([\s\S]+?))?(?:\s+track\s+by\s+([\s\S]+?))?\s*$/);
        if (!k) throw d("iexp", g);var l = k[1],
            m = k[2],
            r = k[3],
            q = k[4],
            k = l.match(/^(?:(\s*[\$\w]+)|\(\s*([\$\w]+)\s*,\s*([\$\w]+)\s*\))$/);if (!k) throw d("iidexp", l);var s = k[3] || k[1],
            u = k[2];if (r && (!/^[$a-zA-Z_][$a-zA-Z0-9_]*$/.test(r) || /^(null|undefined|this|\$index|\$first|\$middle|\$last|\$even|\$odd|\$parent|\$root|\$id)$/.test(r))) throw d("badident", r);var z,
            p,
            x,
            v,
            B = { $id: Da };q ? z = a(q) : (x = function x(a, b) {
          return Da(b);
        }, v = function v(a) {
          return a;
        });return function (a, e, f, k, l) {
          z && (p = function p(b, c, d) {
            u && (B[u] = b);B[s] = c;B.$index = d;return z(a, B);
          });var q = ea();a.$watchCollection(m, function (f) {
            var k,
                m,
                t = e[0],
                z,
                B = ea(),
                D,
                F,
                G,
                E,
                I,
                J,
                K;r && (a[r] = f);if (Aa(f)) I = f, m = p || x;else for (K in m = p || v, I = [], f) {
              ra.call(f, K) && "$" !== K.charAt(0) && I.push(K);
            }D = I.length;K = Array(D);for (k = 0; k < D; k++) {
              if (F = f === I ? k : I[k], G = f[F], E = m(F, G, k), q[E]) J = q[E], delete q[E], B[E] = J, K[k] = J;else {
                if (B[E]) throw n(K, function (a) {
                  a && a.scope && (q[a.id] = a);
                }), d("dupes", g, E, G);K[k] = { id: E, scope: w, clone: w };B[E] = !0;
              }
            }for (z in q) {
              J = q[z];E = sb(J.clone);b.leave(E);if (E[0].parentNode) for (k = 0, m = E.length; k < m; k++) {
                E[k].$$NG_REMOVED = !0;
              }J.scope.$destroy();
            }for (k = 0; k < D; k++) {
              if (F = f === I ? k : I[k], G = f[F], J = K[k], J.scope) {
                z = t;do {
                  z = z.nextSibling;
                } while (z && z.$$NG_REMOVED);J.clone[0] != z && b.move(sb(J.clone), null, A(t));t = J.clone[J.clone.length - 1];c(J.scope, k, s, G, u, F, D);
              } else l(function (a, d) {
                J.scope = d;var e = h.cloneNode(!1);a[a.length++] = e;b.enter(a, null, A(t));t = e;J.clone = a;B[J.id] = J;c(J.scope, k, s, G, u, F, D);
              });
            }q = B;
          });
        };
      } };
  }],
      He = ["$animate", function (a) {
    return { restrict: "A", multiElement: !0, link: function link(b, d, c) {
        b.$watch(c.ngShow, function (b) {
          a[b ? "removeClass" : "addClass"](d, "ng-hide", { tempClasses: "ng-hide-animate" });
        });
      } };
  }],
      Ae = ["$animate", function (a) {
    return { restrict: "A", multiElement: !0, link: function link(b, d, c) {
        b.$watch(c.ngHide, function (b) {
          a[b ? "addClass" : "removeClass"](d, "ng-hide", { tempClasses: "ng-hide-animate" });
        });
      } };
  }],
      Ie = Ka(function (a, b, d) {
    a.$watch(d.ngStyle, function (a, d) {
      d && a !== d && n(d, function (a, c) {
        b.css(c, "");
      });a && b.css(a);
    }, !0);
  }),
      Je = ["$animate", function (a) {
    return { require: "ngSwitch", controller: ["$scope", function () {
        this.cases = {};
      }],
      link: function link(b, d, c, e) {
        var f = [],
            g = [],
            h = [],
            k = [],
            l = function l(a, b) {
          return function () {
            a.splice(b, 1);
          };
        };b.$watch(c.ngSwitch || c.on, function (b) {
          var c, d;c = 0;for (d = h.length; c < d; ++c) {
            a.cancel(h[c]);
          }c = h.length = 0;for (d = k.length; c < d; ++c) {
            var q = sb(g[c].clone);k[c].$destroy();(h[c] = a.leave(q)).then(l(h, c));
          }g.length = 0;k.length = 0;(f = e.cases["!" + b] || e.cases["?"]) && n(f, function (b) {
            b.transclude(function (c, d) {
              k.push(d);var e = b.element;c[c.length++] = W.createComment(" end ngSwitchWhen: ");g.push({ clone: c });a.enter(c, e.parent(), e);
            });
          });
        });
      } };
  }],
      Ke = Ka({ transclude: "element", priority: 1200, require: "^ngSwitch", multiElement: !0, link: function link(a, b, d, c, e) {
      c.cases["!" + d.ngSwitchWhen] = c.cases["!" + d.ngSwitchWhen] || [];c.cases["!" + d.ngSwitchWhen].push({ transclude: e, element: b });
    } }),
      Le = Ka({ transclude: "element", priority: 1200, require: "^ngSwitch", multiElement: !0, link: function link(a, b, d, c, e) {
      c.cases["?"] = c.cases["?"] || [];c.cases["?"].push({ transclude: e, element: b });
    } }),
      Ne = Ka({ restrict: "EAC", link: function link(a, b, d, c, e) {
      if (!e) throw M("ngTransclude")("orphan", ua(b));e(function (a) {
        b.empty();b.append(a);
      });
    } }),
      ne = ["$templateCache", function (a) {
    return { restrict: "E", terminal: !0, compile: function compile(b, d) {
        "text/ng-template" == d.type && a.put(d.id, b[0].text);
      } };
  }],
      Jg = { $setViewValue: z, $render: z },
      Kg = ["$element", "$scope", "$attrs", function (a, b, d) {
    var c = this,
        e = new Sa();c.ngModelCtrl = Jg;c.unknownOption = A(W.createElement("option"));c.renderUnknownOption = function (b) {
      b = "? " + Da(b) + " ?";c.unknownOption.val(b);a.prepend(c.unknownOption);a.val(b);
    };b.$on("$destroy", function () {
      c.renderUnknownOption = z;
    });c.removeUnknownOption = function () {
      c.unknownOption.parent() && c.unknownOption.remove();
    };c.readValue = function () {
      c.removeUnknownOption();return a.val();
    };c.writeValue = function (b) {
      c.hasOption(b) ? (c.removeUnknownOption(), a.val(b), "" === b && c.emptyOption.prop("selected", !0)) : null == b && c.emptyOption ? (c.removeUnknownOption(), a.val("")) : c.renderUnknownOption(b);
    };c.addOption = function (a, b) {
      Ra(a, '"option value"');"" === a && (c.emptyOption = b);var d = e.get(a) || 0;e.put(a, d + 1);c.ngModelCtrl.$render();b[0].hasAttribute("selected") && (b[0].selected = !0);
    };c.removeOption = function (a) {
      var b = e.get(a);b && (1 === b ? (e.remove(a), "" === a && (c.emptyOption = w)) : e.put(a, b - 1));
    };c.hasOption = function (a) {
      return !!e.get(a);
    };c.registerOption = function (a, b, d, e, l) {
      if (e) {
        var m;d.$observe("value", function (a) {
          u(m) && c.removeOption(m);m = a;c.addOption(a, b);
        });
      } else l ? a.$watch(l, function (a, e) {
        d.$set("value", a);e !== a && c.removeOption(e);c.addOption(a, b);
      }) : c.addOption(d.value, b);b.on("$destroy", function () {
        c.removeOption(d.value);c.ngModelCtrl.$render();
      });
    };
  }],
      oe = function oe() {
    return { restrict: "E",
      require: ["select", "?ngModel"], controller: Kg, priority: 1, link: { pre: function pre(a, b, d, c) {
          var e = c[1];if (e) {
            var f = c[0];f.ngModelCtrl = e;b.on("change", function () {
              a.$apply(function () {
                e.$setViewValue(f.readValue());
              });
            });if (d.multiple) {
              f.readValue = function () {
                var a = [];n(b.find("option"), function (b) {
                  b.selected && a.push(b.value);
                });return a;
              };f.writeValue = function (a) {
                var c = new Sa(a);n(b.find("option"), function (a) {
                  a.selected = u(c.get(a.value));
                });
              };var g,
                  h = NaN;a.$watch(function () {
                h !== e.$viewValue || ka(g, e.$viewValue) || (g = ha(e.$viewValue), e.$render());h = e.$viewValue;
              });e.$isEmpty = function (a) {
                return !a || 0 === a.length;
              };
            }
          }
        }, post: function post(a, b, d, c) {
          var e = c[1];if (e) {
            var f = c[0];e.$render = function () {
              f.writeValue(e.$viewValue);
            };
          }
        } } };
  },
      qe = ["$interpolate", function (a) {
    return { restrict: "E", priority: 100, compile: function compile(b, d) {
        if (u(d.value)) var c = a(d.value, !0);else {
          var e = a(b.text(), !0);e || d.$set("value", b.text());
        }return function (a, b, d) {
          var k = b.parent();(k = k.data("$selectController") || k.parent().data("$selectController")) && k.registerOption(a, b, d, c, e);
        };
      } };
  }],
      pe = na({ restrict: "E", terminal: !1 }),
      Gc = function Gc() {
    return { restrict: "A", require: "?ngModel", link: function link(a, b, d, c) {
        c && (d.required = !0, c.$validators.required = function (a, b) {
          return !d.required || !c.$isEmpty(b);
        }, d.$observe("required", function () {
          c.$validate();
        }));
      } };
  },
      Fc = function Fc() {
    return { restrict: "A", require: "?ngModel", link: function link(a, b, d, c) {
        if (c) {
          var e,
              f = d.ngPattern || d.pattern;d.$observe("pattern", function (a) {
            F(a) && 0 < a.length && (a = new RegExp("^" + a + "$"));if (a && !a.test) throw M("ngPattern")("noregexp", f, a, ua(b));e = a || w;c.$validate();
          });c.$validators.pattern = function (a, b) {
            return c.$isEmpty(b) || q(e) || e.test(b);
          };
        }
      } };
  },
      Ic = function Ic() {
    return { restrict: "A", require: "?ngModel", link: function link(a, b, d, c) {
        if (c) {
          var e = -1;d.$observe("maxlength", function (a) {
            a = Z(a);e = isNaN(a) ? -1 : a;c.$validate();
          });c.$validators.maxlength = function (a, b) {
            return 0 > e || c.$isEmpty(b) || b.length <= e;
          };
        }
      } };
  },
      Hc = function Hc() {
    return { restrict: "A", require: "?ngModel", link: function link(a, b, d, c) {
        if (c) {
          var e = 0;d.$observe("minlength", function (a) {
            e = Z(a) || 0;c.$validate();
          });
          c.$validators.minlength = function (a, b) {
            return c.$isEmpty(b) || b.length >= e;
          };
        }
      } };
  };S.angular.bootstrap ? console.log("WARNING: Tried to load angular more than once.") : (ge(), ie($), $.module("ngLocale", [], ["$provide", function (a) {
    function b(a) {
      a += "";var b = a.indexOf(".");return -1 == b ? 0 : a.length - b - 1;
    }a.value("$locale", { DATETIME_FORMATS: { AMPMS: ["AM", "PM"], DAY: "Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "), ERANAMES: ["Before Christ", "Anno Domini"], ERAS: ["BC", "AD"], FIRSTDAYOFWEEK: 6, MONTH: "January February March April May June July August September October November December".split(" "),
        SHORTDAY: "Sun Mon Tue Wed Thu Fri Sat".split(" "), SHORTMONTH: "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "), STANDALONEMONTH: "January February March April May June July August September October November December".split(" "), WEEKENDRANGE: [5, 6], fullDate: "EEEE, MMMM d, y", longDate: "MMMM d, y", medium: "MMM d, y h:mm:ss a", mediumDate: "MMM d, y", mediumTime: "h:mm:ss a", "short": "M/d/yy h:mm a", shortDate: "M/d/yy", shortTime: "h:mm a" }, NUMBER_FORMATS: { CURRENCY_SYM: "$", DECIMAL_SEP: ".", GROUP_SEP: ",",
        PATTERNS: [{ gSize: 3, lgSize: 3, maxFrac: 3, minFrac: 0, minInt: 1, negPre: "-", negSuf: "", posPre: "", posSuf: "" }, { gSize: 3, lgSize: 3, maxFrac: 2, minFrac: 2, minInt: 1, negPre: "-\xA4", negSuf: "", posPre: "\xA4", posSuf: "" }] }, id: "en-us", pluralCat: function pluralCat(a, c) {
        var e = a | 0,
            f = c;w === f && (f = Math.min(b(a), 3));Math.pow(10, f);return 1 == e && 0 == f ? "one" : "other";
      } });
  }]), A(W).ready(function () {
    ce(W, zc);
  }));
})(window, document);!window.angular.$$csp().noInlineStyle && window.angular.element(document.head).prepend('<style type="text/css">@charset "UTF-8";[ng\\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>');
//# sourceMappingURL=angular.min.js.map

/*
 AngularJS v1.4.9
 (c) 2010-2015 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (p, c, n) {
  'use strict';
  function l(b, a, g) {
    var d = g.baseHref(),
        k = b[0];return function (b, e, f) {
      var g, h;f = f || {};h = f.expires;g = c.isDefined(f.path) ? f.path : d;c.isUndefined(e) && (h = "Thu, 01 Jan 1970 00:00:00 GMT", e = "");c.isString(h) && (h = new Date(h));e = encodeURIComponent(b) + "=" + encodeURIComponent(e);e = e + (g ? ";path=" + g : "") + (f.domain ? ";domain=" + f.domain : "");e += h ? ";expires=" + h.toUTCString() : "";e += f.secure ? ";secure" : "";f = e.length + 1;4096 < f && a.warn("Cookie '" + b + "' possibly not set or overflowed because it was too large (" + f + " > 4096 bytes)!");k.cookie = e;
    };
  }c.module("ngCookies", ["ng"]).provider("$cookies", [function () {
    var b = this.defaults = {};this.$get = ["$$cookieReader", "$$cookieWriter", function (a, g) {
      return { get: function get(d) {
          return a()[d];
        }, getObject: function getObject(d) {
          return (d = this.get(d)) ? c.fromJson(d) : d;
        }, getAll: function getAll() {
          return a();
        }, put: function put(d, a, m) {
          g(d, a, m ? c.extend({}, b, m) : b);
        }, putObject: function putObject(d, b, a) {
          this.put(d, c.toJson(b), a);
        }, remove: function remove(a, k) {
          g(a, n, k ? c.extend({}, b, k) : b);
        } };
    }];
  }]);c.module("ngCookies").factory("$cookieStore", ["$cookies", function (b) {
    return { get: function get(a) {
        return b.getObject(a);
      }, put: function put(a, c) {
        b.putObject(a, c);
      }, remove: function remove(a) {
        b.remove(a);
      } };
  }]);l.$inject = ["$document", "$log", "$browser"];c.module("ngCookies").provider("$$cookieWriter", function () {
    this.$get = l;
  });
})(window, window.angular);
//# sourceMappingURL=angular-cookies.min.js.map

/*
 AngularJS v1.4.9
 (c) 2010-2015 Google, Inc. http://angularjs.org
 License: MIT
*/
(function (n, h, p) {
  'use strict';
  function E(a) {
    var f = [];r(f, h.noop).chars(a);return f.join("");
  }function g(a, f) {
    var d = {},
        c = a.split(","),
        b;for (b = 0; b < c.length; b++) {
      d[f ? h.lowercase(c[b]) : c[b]] = !0;
    }return d;
  }function F(a, f) {
    function d(a, b, d, l) {
      b = h.lowercase(b);if (s[b]) for (; e.last() && t[e.last()];) {
        c("", e.last());
      }u[b] && e.last() == b && c("", b);(l = v[b] || !!l) || e.push(b);var m = {};d.replace(G, function (b, a, f, c, d) {
        m[a] = q(f || c || d || "");
      });f.start && f.start(b, m, l);
    }function c(b, a) {
      var c = 0,
          d;if (a = h.lowercase(a)) for (c = e.length - 1; 0 <= c && e[c] != a; c--) {}if (0 <= c) {
        for (d = e.length - 1; d >= c; d--) {
          f.end && f.end(e[d]);
        }e.length = c;
      }
    }"string" !== typeof a && (a = null === a || "undefined" === typeof a ? "" : "" + a);var b,
        k,
        e = [],
        m = a,
        l;for (e.last = function () {
      return e[e.length - 1];
    }; a;) {
      l = "";k = !0;if (e.last() && w[e.last()]) a = a.replace(new RegExp("([\\W\\w]*)<\\s*\\/\\s*" + e.last() + "[^>]*>", "i"), function (a, b) {
        b = b.replace(H, "$1").replace(I, "$1");f.chars && f.chars(q(b));return "";
      }), c("", e.last());else {
        if (0 === a.indexOf("\x3c!--")) b = a.indexOf("--", 4), 0 <= b && a.lastIndexOf("--\x3e", b) === b && (f.comment && f.comment(a.substring(4, b)), a = a.substring(b + 3), k = !1);else if (x.test(a)) {
          if (b = a.match(x)) a = a.replace(b[0], ""), k = !1;
        } else if (J.test(a)) {
          if (b = a.match(y)) a = a.substring(b[0].length), b[0].replace(y, c), k = !1;
        } else K.test(a) && ((b = a.match(z)) ? (b[4] && (a = a.substring(b[0].length), b[0].replace(z, d)), k = !1) : (l += "<", a = a.substring(1)));k && (b = a.indexOf("<"), l += 0 > b ? a : a.substring(0, b), a = 0 > b ? "" : a.substring(b), f.chars && f.chars(q(l)));
      }if (a == m) throw L("badparse", a);m = a;
    }c();
  }function q(a) {
    if (!a) return "";A.innerHTML = a.replace(/</g, "&lt;");return A.textContent;
  }function B(a) {
    return a.replace(/&/g, "&amp;").replace(M, function (a) {
      var d = a.charCodeAt(0);a = a.charCodeAt(1);return "&#" + (1024 * (d - 55296) + (a - 56320) + 65536) + ";";
    }).replace(N, function (a) {
      return "&#" + a.charCodeAt(0) + ";";
    }).replace(/</g, "&lt;").replace(/>/g, "&gt;");
  }function r(a, f) {
    var d = !1,
        c = h.bind(a, a.push);return { start: function start(a, k, e) {
        a = h.lowercase(a);!d && w[a] && (d = a);d || !0 !== C[a] || (c("<"), c(a), h.forEach(k, function (d, e) {
          var k = h.lowercase(e),
              g = "img" === a && "src" === k || "background" === k;!0 !== O[k] || !0 === D[k] && !f(d, g) || (c(" "), c(e), c('="'), c(B(d)), c('"'));
        }), c(e ? "/>" : ">"));
      }, end: function end(a) {
        a = h.lowercase(a);d || !0 !== C[a] || (c("</"), c(a), c(">"));a == d && (d = !1);
      }, chars: function chars(a) {
        d || c(B(a));
      } };
  }var L = h.$$minErr("$sanitize"),
      z = /^<((?:[a-zA-Z])[\w:-]*)((?:\s+[\w:-]+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)\s*(>?)/,
      y = /^<\/\s*([\w:-]+)[^>]*>/,
      G = /([\w:-]+)(?:\s*=\s*(?:(?:"((?:[^"])*)")|(?:'((?:[^'])*)')|([^>\s]+)))?/g,
      K = /^</,
      J = /^<\//,
      H = /\x3c!--(.*?)--\x3e/g,
      x = /<!DOCTYPE([^>]*?)>/i,
      I = /<!\[CDATA\[(.*?)]]\x3e/g,
      M = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
      N = /([^\#-~| |!])/g,
      v = g("area,br,col,hr,img,wbr");n = g("colgroup,dd,dt,li,p,tbody,td,tfoot,th,thead,tr");p = g("rp,rt");var u = h.extend({}, p, n),
      s = h.extend({}, n, g("address,article,aside,blockquote,caption,center,del,dir,div,dl,figure,figcaption,footer,h1,h2,h3,h4,h5,h6,header,hgroup,hr,ins,map,menu,nav,ol,pre,script,section,table,ul")),
      t = h.extend({}, p, g("a,abbr,acronym,b,bdi,bdo,big,br,cite,code,del,dfn,em,font,i,img,ins,kbd,label,map,mark,q,ruby,rp,rt,s,samp,small,span,strike,strong,sub,sup,time,tt,u,var"));
  n = g("circle,defs,desc,ellipse,font-face,font-face-name,font-face-src,g,glyph,hkern,image,linearGradient,line,marker,metadata,missing-glyph,mpath,path,polygon,polyline,radialGradient,rect,stop,svg,switch,text,title,tspan,use");var w = g("script,style"),
      C = h.extend({}, v, s, t, u, n),
      D = g("background,cite,href,longdesc,src,usemap,xlink:href");n = g("abbr,align,alt,axis,bgcolor,border,cellpadding,cellspacing,class,clear,color,cols,colspan,compact,coords,dir,face,headers,height,hreflang,hspace,ismap,lang,language,nohref,nowrap,rel,rev,rows,rowspan,rules,scope,scrolling,shape,size,span,start,summary,tabindex,target,title,type,valign,value,vspace,width");
  p = g("accent-height,accumulate,additive,alphabetic,arabic-form,ascent,baseProfile,bbox,begin,by,calcMode,cap-height,class,color,color-rendering,content,cx,cy,d,dx,dy,descent,display,dur,end,fill,fill-rule,font-family,font-size,font-stretch,font-style,font-variant,font-weight,from,fx,fy,g1,g2,glyph-name,gradientUnits,hanging,height,horiz-adv-x,horiz-origin-x,ideographic,k,keyPoints,keySplines,keyTimes,lang,marker-end,marker-mid,marker-start,markerHeight,markerUnits,markerWidth,mathematical,max,min,offset,opacity,orient,origin,overline-position,overline-thickness,panose-1,path,pathLength,points,preserveAspectRatio,r,refX,refY,repeatCount,repeatDur,requiredExtensions,requiredFeatures,restart,rotate,rx,ry,slope,stemh,stemv,stop-color,stop-opacity,strikethrough-position,strikethrough-thickness,stroke,stroke-dasharray,stroke-dashoffset,stroke-linecap,stroke-linejoin,stroke-miterlimit,stroke-opacity,stroke-width,systemLanguage,target,text-anchor,to,transform,type,u1,u2,underline-position,underline-thickness,unicode,unicode-range,units-per-em,values,version,viewBox,visibility,width,widths,x,x-height,x1,x2,xlink:actuate,xlink:arcrole,xlink:role,xlink:show,xlink:title,xlink:type,xml:base,xml:lang,xml:space,xmlns,xmlns:xlink,y,y1,y2,zoomAndPan", !0);var O = h.extend({}, D, p, n),
      A = document.createElement("pre");h.module("ngSanitize", []).provider("$sanitize", function () {
    this.$get = ["$$sanitizeUri", function (a) {
      return function (f) {
        var d = [];F(f, r(d, function (c, b) {
          return !/^unsafe/.test(a(c, b));
        }));return d.join("");
      };
    }];
  });h.module("ngSanitize").filter("linky", ["$sanitize", function (a) {
    var f = /((ftp|https?):\/\/|(www\.)|(mailto:)?[A-Za-z0-9._%+-]+@)\S*[^\s.;,(){}<>"\u201d\u2019]/i,
        d = /^mailto:/i;return function (c, b) {
      function k(a) {
        a && g.push(E(a));
      }function e(a, c) {
        g.push("<a ");h.isDefined(b) && g.push('target="', b, '" ');g.push('href="', a.replace(/"/g, "&quot;"), '">');k(c);g.push("</a>");
      }if (!c) return c;for (var m, l = c, g = [], n, p; m = l.match(f);) {
        n = m[0], m[2] || m[4] || (n = (m[3] ? "http://" : "mailto:") + n), p = m.index, k(l.substr(0, p)), e(n, m[0].replace(d, "")), l = l.substring(p + m[0].length);
      }k(l);return a(g.join(""));
    };
  }]);
})(window, window.angular);
//# sourceMappingURL=angular-sanitize.min.js.map

/*
 * angular-ui-bootstrap
 * http://angular-ui.github.io/bootstrap/

 * Version: 1.1.1 - 2016-01-25
 * License: MIT
 */angular.module("ui.bootstrap", ["ui.bootstrap.tpls", "ui.bootstrap.collapse", "ui.bootstrap.accordion", "ui.bootstrap.alert", "ui.bootstrap.buttons", "ui.bootstrap.carousel", "ui.bootstrap.dateparser", "ui.bootstrap.isClass", "ui.bootstrap.position", "ui.bootstrap.datepicker", "ui.bootstrap.debounce", "ui.bootstrap.dropdown", "ui.bootstrap.stackedMap", "ui.bootstrap.modal", "ui.bootstrap.paging", "ui.bootstrap.pager", "ui.bootstrap.pagination", "ui.bootstrap.tooltip", "ui.bootstrap.popover", "ui.bootstrap.progressbar", "ui.bootstrap.rating", "ui.bootstrap.tabs", "ui.bootstrap.timepicker", "ui.bootstrap.typeahead"]), angular.module("ui.bootstrap.tpls", ["uib/template/accordion/accordion-group.html", "uib/template/accordion/accordion.html", "uib/template/alert/alert.html", "uib/template/carousel/carousel.html", "uib/template/carousel/slide.html", "uib/template/datepicker/datepicker.html", "uib/template/datepicker/day.html", "uib/template/datepicker/month.html", "uib/template/datepicker/popup.html", "uib/template/datepicker/year.html", "uib/template/modal/backdrop.html", "uib/template/modal/window.html", "uib/template/pager/pager.html", "uib/template/pagination/pagination.html", "uib/template/tooltip/tooltip-html-popup.html", "uib/template/tooltip/tooltip-popup.html", "uib/template/tooltip/tooltip-template-popup.html", "uib/template/popover/popover-html.html", "uib/template/popover/popover-template.html", "uib/template/popover/popover.html", "uib/template/progressbar/bar.html", "uib/template/progressbar/progress.html", "uib/template/progressbar/progressbar.html", "uib/template/rating/rating.html", "uib/template/tabs/tab.html", "uib/template/tabs/tabset.html", "uib/template/timepicker/timepicker.html", "uib/template/typeahead/typeahead-match.html", "uib/template/typeahead/typeahead-popup.html"]), angular.module("ui.bootstrap.collapse", []).directive("uibCollapse", ["$animate", "$q", "$parse", "$injector", function (a, b, c, d) {
  var e = d.has("$animateCss") ? d.get("$animateCss") : null;return { link: function link(d, f, g) {
      function h() {
        f.hasClass("collapse") && f.hasClass("in") || b.resolve(l(d)).then(function () {
          f.removeClass("collapse").addClass("collapsing").attr("aria-expanded", !0).attr("aria-hidden", !1), e ? e(f, { addClass: "in", easing: "ease", to: { height: f[0].scrollHeight + "px" } }).start()["finally"](i) : a.addClass(f, "in", { to: { height: f[0].scrollHeight + "px" } }).then(i);
        });
      }function i() {
        f.removeClass("collapsing").addClass("collapse").css({ height: "auto" }), m(d);
      }function j() {
        return f.hasClass("collapse") || f.hasClass("in") ? void b.resolve(n(d)).then(function () {
          f.css({ height: f[0].scrollHeight + "px" }).removeClass("collapse").addClass("collapsing").attr("aria-expanded", !1).attr("aria-hidden", !0), e ? e(f, { removeClass: "in", to: { height: "0" } }).start()["finally"](k) : a.removeClass(f, "in", { to: { height: "0" } }).then(k);
        }) : k();
      }function k() {
        f.css({ height: "0" }), f.removeClass("collapsing").addClass("collapse"), o(d);
      }var l = c(g.expanding),
          m = c(g.expanded),
          n = c(g.collapsing),
          o = c(g.collapsed);d.$eval(g.uibCollapse) || f.addClass("in").addClass("collapse").attr("aria-expanded", !0).attr("aria-hidden", !1).css({ height: "auto" }), d.$watch(g.uibCollapse, function (a) {
        a ? j() : h();
      });
    } };
}]), angular.module("ui.bootstrap.accordion", ["ui.bootstrap.collapse"]).constant("uibAccordionConfig", { closeOthers: !0 }).controller("UibAccordionController", ["$scope", "$attrs", "uibAccordionConfig", function (a, b, c) {
  this.groups = [], this.closeOthers = function (d) {
    var e = angular.isDefined(b.closeOthers) ? a.$eval(b.closeOthers) : c.closeOthers;e && angular.forEach(this.groups, function (a) {
      a !== d && (a.isOpen = !1);
    });
  }, this.addGroup = function (a) {
    var b = this;this.groups.push(a), a.$on("$destroy", function (c) {
      b.removeGroup(a);
    });
  }, this.removeGroup = function (a) {
    var b = this.groups.indexOf(a);-1 !== b && this.groups.splice(b, 1);
  };
}]).directive("uibAccordion", function () {
  return { controller: "UibAccordionController", controllerAs: "accordion", transclude: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/accordion/accordion.html";
    } };
}).directive("uibAccordionGroup", function () {
  return { require: "^uibAccordion", transclude: !0, replace: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/accordion/accordion-group.html";
    }, scope: { heading: "@", isOpen: "=?", isDisabled: "=?" }, controller: function controller() {
      this.setHeading = function (a) {
        this.heading = a;
      };
    }, link: function link(a, b, c, d) {
      d.addGroup(a), a.openClass = c.openClass || "panel-open", a.panelClass = c.panelClass || "panel-default", a.$watch("isOpen", function (c) {
        b.toggleClass(a.openClass, !!c), c && d.closeOthers(a);
      }), a.toggleOpen = function (b) {
        a.isDisabled || b && 32 !== b.which || (a.isOpen = !a.isOpen);
      };
    } };
}).directive("uibAccordionHeading", function () {
  return { transclude: !0, template: "", replace: !0, require: "^uibAccordionGroup", link: function link(a, b, c, d, e) {
      d.setHeading(e(a, angular.noop));
    } };
}).directive("uibAccordionTransclude", function () {
  return { require: "^uibAccordionGroup", link: function link(a, b, c, d) {
      a.$watch(function () {
        return d[c.uibAccordionTransclude];
      }, function (a) {
        a && (b.find("span").html(""), b.find("span").append(a));
      });
    } };
}), angular.module("ui.bootstrap.alert", []).controller("UibAlertController", ["$scope", "$attrs", "$interpolate", "$timeout", function (a, b, c, d) {
  a.closeable = !!b.close;var e = angular.isDefined(b.dismissOnTimeout) ? c(b.dismissOnTimeout)(a.$parent) : null;e && d(function () {
    a.close();
  }, parseInt(e, 10));
}]).directive("uibAlert", function () {
  return { controller: "UibAlertController", controllerAs: "alert", templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/alert/alert.html";
    }, transclude: !0, replace: !0, scope: { type: "@", close: "&" } };
}), angular.module("ui.bootstrap.buttons", []).constant("uibButtonConfig", { activeClass: "active", toggleEvent: "click" }).controller("UibButtonsController", ["uibButtonConfig", function (a) {
  this.activeClass = a.activeClass || "active", this.toggleEvent = a.toggleEvent || "click";
}]).directive("uibBtnRadio", ["$parse", function (a) {
  return { require: ["uibBtnRadio", "ngModel"], controller: "UibButtonsController", controllerAs: "buttons", link: function link(b, c, d, e) {
      var f = e[0],
          g = e[1],
          h = a(d.uibUncheckable);c.find("input").css({ display: "none" }), g.$render = function () {
        c.toggleClass(f.activeClass, angular.equals(g.$modelValue, b.$eval(d.uibBtnRadio)));
      }, c.on(f.toggleEvent, function () {
        if (!d.disabled) {
          var a = c.hasClass(f.activeClass);(!a || angular.isDefined(d.uncheckable)) && b.$apply(function () {
            g.$setViewValue(a ? null : b.$eval(d.uibBtnRadio)), g.$render();
          });
        }
      }), d.uibUncheckable && b.$watch(h, function (a) {
        d.$set("uncheckable", a ? "" : null);
      });
    } };
}]).directive("uibBtnCheckbox", function () {
  return { require: ["uibBtnCheckbox", "ngModel"], controller: "UibButtonsController", controllerAs: "button", link: function link(a, b, c, d) {
      function e() {
        return g(c.btnCheckboxTrue, !0);
      }function f() {
        return g(c.btnCheckboxFalse, !1);
      }function g(b, c) {
        return angular.isDefined(b) ? a.$eval(b) : c;
      }var h = d[0],
          i = d[1];b.find("input").css({ display: "none" }), i.$render = function () {
        b.toggleClass(h.activeClass, angular.equals(i.$modelValue, e()));
      }, b.on(h.toggleEvent, function () {
        c.disabled || a.$apply(function () {
          i.$setViewValue(b.hasClass(h.activeClass) ? f() : e()), i.$render();
        });
      });
    } };
}), angular.module("ui.bootstrap.carousel", []).controller("UibCarouselController", ["$scope", "$element", "$interval", "$timeout", "$animate", function (a, b, c, d, e) {
  function f() {
    for (; s.length;) {
      s.shift();
    }
  }function g(a) {
    if (angular.isUndefined(p[a].index)) return p[a];for (var b = 0, c = p.length; c > b; ++b) {
      if (p[b].index === a) return p[b];
    }
  }function h(c, d, g) {
    t || (angular.extend(c, { direction: g, active: !0 }), angular.extend(o.currentSlide || {}, { direction: g, active: !1 }), e.enabled(b) && !a.$currentTransition && c.$element && o.slides.length > 1 && (c.$element.data(q, c.direction), o.currentSlide && o.currentSlide.$element && o.currentSlide.$element.data(q, c.direction), a.$currentTransition = !0, e.on("addClass", c.$element, function (b, c) {
      if ("close" === c && (a.$currentTransition = null, e.off("addClass", b), s.length)) {
        var d = s.pop(),
            g = a.indexOfSlide(d),
            i = g > o.getCurrentIndex() ? "next" : "prev";f(), h(d, g, i);
      }
    })), o.currentSlide = c, r = d, k());
  }function i() {
    m && (c.cancel(m), m = null);
  }function j(b) {
    b.length || (a.$currentTransition = null, f());
  }function k() {
    i();var b = +a.interval;!isNaN(b) && b > 0 && (m = c(l, b));
  }function l() {
    var b = +a.interval;n && !isNaN(b) && b > 0 && p.length ? a.next() : a.pause();
  }var m,
      n,
      o = this,
      p = o.slides = a.slides = [],
      q = "uib-slideDirection",
      r = -1,
      s = [];o.currentSlide = null;var t = !1;o.addSlide = function (b, c) {
    b.$element = c, p.push(b), 1 === p.length || b.active ? (a.$currentTransition && (a.$currentTransition = null), o.select(p[p.length - 1]), 1 === p.length && a.play()) : b.active = !1;
  }, o.getCurrentIndex = function () {
    return o.currentSlide && angular.isDefined(o.currentSlide.index) ? +o.currentSlide.index : r;
  }, o.next = a.next = function () {
    var b = (o.getCurrentIndex() + 1) % p.length;return 0 === b && a.noWrap() ? void a.pause() : o.select(g(b), "next");
  }, o.prev = a.prev = function () {
    var b = o.getCurrentIndex() - 1 < 0 ? p.length - 1 : o.getCurrentIndex() - 1;return a.noWrap() && b === p.length - 1 ? void a.pause() : o.select(g(b), "prev");
  }, o.removeSlide = function (a) {
    angular.isDefined(a.index) && p.sort(function (a, b) {
      return +a.index > +b.index;
    });var b = s.indexOf(a);-1 !== b && s.splice(b, 1);var c = p.indexOf(a);p.splice(c, 1), d(function () {
      p.length > 0 && a.active ? c >= p.length ? o.select(p[c - 1]) : o.select(p[c]) : r > c && r--;
    }), 0 === p.length && (o.currentSlide = null, f());
  }, o.select = a.select = function (b, c) {
    var d = a.indexOfSlide(b);void 0 === c && (c = d > o.getCurrentIndex() ? "next" : "prev"), b && b !== o.currentSlide && !a.$currentTransition ? h(b, d, c) : b && b !== o.currentSlide && a.$currentTransition && (s.push(b), b.active = !1);
  }, a.indexOfSlide = function (a) {
    return angular.isDefined(a.index) ? +a.index : p.indexOf(a);
  }, a.isActive = function (a) {
    return o.currentSlide === a;
  }, a.pause = function () {
    a.noPause || (n = !1, i());
  }, a.play = function () {
    n || (n = !0, k());
  }, a.$on("$destroy", function () {
    t = !0, i();
  }), a.$watch("noTransition", function (a) {
    e.enabled(b, !a);
  }), a.$watch("interval", k), a.$watchCollection("slides", j);
}]).directive("uibCarousel", function () {
  return { transclude: !0, replace: !0, controller: "UibCarouselController", controllerAs: "carousel", templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/carousel/carousel.html";
    }, scope: { interval: "=", noTransition: "=", noPause: "=", noWrap: "&" } };
}).directive("uibSlide", function () {
  return { require: "^uibCarousel", transclude: !0, replace: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/carousel/slide.html";
    }, scope: { active: "=?", actual: "=?", index: "=?" }, link: function link(a, b, c, d) {
      d.addSlide(a, b), a.$on("$destroy", function () {
        d.removeSlide(a);
      }), a.$watch("active", function (b) {
        b && d.select(a);
      });
    } };
}).animation(".item", ["$animateCss", function (a) {
  function b(a, b, c) {
    a.removeClass(b), c && c();
  }var c = "uib-slideDirection";return { beforeAddClass: function beforeAddClass(d, e, f) {
      if ("active" === e) {
        var g = !1,
            h = d.data(c),
            i = "next" === h ? "left" : "right",
            j = b.bind(this, d, i + " " + h, f);return d.addClass(h), a(d, { addClass: i }).start().done(j), function () {
          g = !0;
        };
      }f();
    }, beforeRemoveClass: function beforeRemoveClass(d, e, f) {
      if ("active" === e) {
        var g = !1,
            h = d.data(c),
            i = "next" === h ? "left" : "right",
            j = b.bind(this, d, i, f);return a(d, { addClass: i }).start().done(j), function () {
          g = !0;
        };
      }f();
    } };
}]), angular.module("ui.bootstrap.dateparser", []).service("uibDateParser", ["$log", "$locale", "orderByFilter", function (a, b, c) {
  function d(a) {
    var b = [],
        d = a.split(""),
        e = a.indexOf("'");if (e > -1) {
      var f = !1;a = a.split("");for (var g = e; g < a.length; g++) {
        f ? ("'" === a[g] && (g + 1 < a.length && "'" === a[g + 1] ? (a[g + 1] = "$", d[g + 1] = "") : (d[g] = "", f = !1)), a[g] = "$") : "'" === a[g] && (a[g] = "$", d[g] = "", f = !0);
      }a = a.join("");
    }return angular.forEach(m, function (c) {
      var e = a.indexOf(c.key);if (e > -1) {
        a = a.split(""), d[e] = "(" + c.regex + ")", a[e] = "$";for (var f = e + 1, g = e + c.key.length; g > f; f++) {
          d[f] = "", a[f] = "$";
        }a = a.join(""), b.push({ index: e, apply: c.apply, matcher: c.regex });
      }
    }), { regex: new RegExp("^" + d.join("") + "$"), map: c(b, "index") };
  }function e(a, b, c) {
    return 1 > c ? !1 : 1 === b && c > 28 ? 29 === c && (a % 4 === 0 && a % 100 !== 0 || a % 400 === 0) : 3 === b || 5 === b || 8 === b || 10 === b ? 31 > c : !0;
  }function f(a) {
    return parseInt(a, 10);
  }function g(a, b) {
    return a && b ? k(a, b) : a;
  }function h(a, b) {
    return a && b ? k(a, b, !0) : a;
  }function i(a, b) {
    var c = Date.parse("Jan 01, 1970 00:00:00 " + a) / 6e4;return isNaN(c) ? b : c;
  }function j(a, b) {
    return a = new Date(a.getTime()), a.setMinutes(a.getMinutes() + b), a;
  }function k(a, b, c) {
    c = c ? -1 : 1;var d = i(b, a.getTimezoneOffset());return j(a, c * (d - a.getTimezoneOffset()));
  }var l,
      m,
      n = /[\\\^\$\*\+\?\|\[\]\(\)\.\{\}]/g;this.init = function () {
    l = b.id, this.parsers = {}, m = [{ key: "yyyy", regex: "\\d{4}", apply: function apply(a) {
        this.year = +a;
      } }, { key: "yy", regex: "\\d{2}", apply: function apply(a) {
        this.year = +a + 2e3;
      } }, { key: "y", regex: "\\d{1,4}", apply: function apply(a) {
        this.year = +a;
      } }, { key: "M!", regex: "0?[1-9]|1[0-2]", apply: function apply(a) {
        this.month = a - 1;
      } }, { key: "MMMM", regex: b.DATETIME_FORMATS.MONTH.join("|"), apply: function apply(a) {
        this.month = b.DATETIME_FORMATS.MONTH.indexOf(a);
      } }, { key: "MMM", regex: b.DATETIME_FORMATS.SHORTMONTH.join("|"), apply: function apply(a) {
        this.month = b.DATETIME_FORMATS.SHORTMONTH.indexOf(a);
      } }, { key: "MM", regex: "0[1-9]|1[0-2]", apply: function apply(a) {
        this.month = a - 1;
      } }, { key: "M", regex: "[1-9]|1[0-2]", apply: function apply(a) {
        this.month = a - 1;
      } }, { key: "d!", regex: "[0-2]?[0-9]{1}|3[0-1]{1}", apply: function apply(a) {
        this.date = +a;
      } }, { key: "dd", regex: "[0-2][0-9]{1}|3[0-1]{1}", apply: function apply(a) {
        this.date = +a;
      } }, { key: "d", regex: "[1-2]?[0-9]{1}|3[0-1]{1}", apply: function apply(a) {
        this.date = +a;
      } }, { key: "EEEE", regex: b.DATETIME_FORMATS.DAY.join("|") }, { key: "EEE", regex: b.DATETIME_FORMATS.SHORTDAY.join("|") }, { key: "HH", regex: "(?:0|1)[0-9]|2[0-3]", apply: function apply(a) {
        this.hours = +a;
      } }, { key: "hh", regex: "0[0-9]|1[0-2]", apply: function apply(a) {
        this.hours = +a;
      } }, { key: "H", regex: "1?[0-9]|2[0-3]", apply: function apply(a) {
        this.hours = +a;
      } }, { key: "h", regex: "[0-9]|1[0-2]", apply: function apply(a) {
        this.hours = +a;
      } }, { key: "mm", regex: "[0-5][0-9]", apply: function apply(a) {
        this.minutes = +a;
      } }, { key: "m", regex: "[0-9]|[1-5][0-9]", apply: function apply(a) {
        this.minutes = +a;
      } }, { key: "sss", regex: "[0-9][0-9][0-9]", apply: function apply(a) {
        this.milliseconds = +a;
      } }, { key: "ss", regex: "[0-5][0-9]", apply: function apply(a) {
        this.seconds = +a;
      } }, { key: "s", regex: "[0-9]|[1-5][0-9]", apply: function apply(a) {
        this.seconds = +a;
      } }, { key: "a", regex: b.DATETIME_FORMATS.AMPMS.join("|"), apply: function apply(a) {
        12 === this.hours && (this.hours = 0), "PM" === a && (this.hours += 12);
      } }, { key: "Z", regex: "[+-]\\d{4}", apply: function apply(a) {
        var b = a.match(/([+-])(\d{2})(\d{2})/),
            c = b[1],
            d = b[2],
            e = b[3];this.hours += f(c + d), this.minutes += f(c + e);
      } }, { key: "ww", regex: "[0-4][0-9]|5[0-3]" }, { key: "w", regex: "[0-9]|[1-4][0-9]|5[0-3]" }, { key: "GGGG", regex: b.DATETIME_FORMATS.ERANAMES.join("|").replace(/\s/g, "\\s") }, { key: "GGG", regex: b.DATETIME_FORMATS.ERAS.join("|") }, { key: "GG", regex: b.DATETIME_FORMATS.ERAS.join("|") }, { key: "G", regex: b.DATETIME_FORMATS.ERAS.join("|") }];
  }, this.init(), this.parse = function (c, f, g) {
    if (!angular.isString(c) || !f) return c;f = b.DATETIME_FORMATS[f] || f, f = f.replace(n, "\\$&"), b.id !== l && this.init(), this.parsers[f] || (this.parsers[f] = d(f));var h = this.parsers[f],
        i = h.regex,
        j = h.map,
        k = c.match(i),
        m = !1;if (k && k.length) {
      var o, p;angular.isDate(g) && !isNaN(g.getTime()) ? o = { year: g.getFullYear(), month: g.getMonth(), date: g.getDate(), hours: g.getHours(), minutes: g.getMinutes(), seconds: g.getSeconds(), milliseconds: g.getMilliseconds() } : (g && a.warn("dateparser:", "baseDate is not a valid date"), o = { year: 1900, month: 0, date: 1, hours: 0, minutes: 0, seconds: 0, milliseconds: 0 });for (var q = 1, r = k.length; r > q; q++) {
        var s = j[q - 1];"Z" === s.matcher && (m = !0), s.apply && s.apply.call(o, k[q]);
      }var t = m ? Date.prototype.setUTCFullYear : Date.prototype.setFullYear,
          u = m ? Date.prototype.setUTCHours : Date.prototype.setHours;return e(o.year, o.month, o.date) && (!angular.isDate(g) || isNaN(g.getTime()) || m ? (p = new Date(0), t.call(p, o.year, o.month, o.date), u.call(p, o.hours || 0, o.minutes || 0, o.seconds || 0, o.milliseconds || 0)) : (p = new Date(g), t.call(p, o.year, o.month, o.date), u.call(p, o.hours, o.minutes, o.seconds, o.milliseconds))), p;
    }
  }, this.toTimezone = g, this.fromTimezone = h, this.timezoneToOffset = i, this.addDateMinutes = j, this.convertTimezoneToLocal = k;
}]), angular.module("ui.bootstrap.isClass", []).directive("uibIsClass", ["$animate", function (a) {
  var b = /^\s*([\s\S]+?)\s+on\s+([\s\S]+?)\s*$/,
      c = /^\s*([\s\S]+?)\s+for\s+([\s\S]+?)\s*$/;return { restrict: "A", compile: function compile(d, e) {
      function f(a, b, c) {
        i.push(a), j.push({ scope: a, element: b }), o.forEach(function (b, c) {
          g(b, a);
        }), a.$on("$destroy", h);
      }function g(b, d) {
        var e = b.match(c),
            f = d.$eval(e[1]),
            g = e[2],
            h = k[b];if (!h) {
          var i = function i(b) {
            var c = null;j.some(function (a) {
              var d = a.scope.$eval(m);return d === b ? (c = a, !0) : void 0;
            }), h.lastActivated !== c && (h.lastActivated && a.removeClass(h.lastActivated.element, f), c && a.addClass(c.element, f), h.lastActivated = c);
          };k[b] = h = { lastActivated: null, scope: d, watchFn: i, compareWithExp: g, watcher: d.$watch(g, i) };
        }h.watchFn(d.$eval(g));
      }function h(a) {
        var b = a.targetScope,
            c = i.indexOf(b);if (i.splice(c, 1), j.splice(c, 1), i.length) {
          var d = i[0];angular.forEach(k, function (a) {
            a.scope === b && (a.watcher = d.$watch(a.compareWithExp, a.watchFn), a.scope = d);
          });
        } else k = {};
      }var i = [],
          j = [],
          k = {},
          l = e.uibIsClass.match(b),
          m = l[2],
          n = l[1],
          o = n.split(",");return f;
    } };
}]), angular.module("ui.bootstrap.position", []).factory("$uibPosition", ["$document", "$window", function (a, b) {
  var c,
      d = { normal: /(auto|scroll)/, hidden: /(auto|scroll|hidden)/ },
      e = { auto: /\s?auto?\s?/i, primary: /^(top|bottom|left|right)$/, secondary: /^(top|bottom|left|right|center)$/, vertical: /^(top|bottom)$/ };return { getRawNode: function getRawNode(a) {
      return a[0] || a;
    }, parseStyle: function parseStyle(a) {
      return a = parseFloat(a), isFinite(a) ? a : 0;
    }, offsetParent: function offsetParent(c) {
      function d(a) {
        return "static" === (b.getComputedStyle(a).position || "static");
      }c = this.getRawNode(c);for (var e = c.offsetParent || a[0].documentElement; e && e !== a[0].documentElement && d(e);) {
        e = e.offsetParent;
      }return e || a[0].documentElement;
    }, scrollbarWidth: function scrollbarWidth() {
      if (angular.isUndefined(c)) {
        var b = angular.element('<div style="position: absolute; top: -9999px; width: 50px; height: 50px; overflow: scroll;"></div>');a.find("body").append(b), c = b[0].offsetWidth - b[0].clientWidth, c = isFinite(c) ? c : 0, b.remove();
      }return c;
    }, scrollParent: function scrollParent(c, e) {
      c = this.getRawNode(c);var f = e ? d.hidden : d.normal,
          g = a[0].documentElement,
          h = b.getComputedStyle(c),
          i = "absolute" === h.position,
          j = c.parentElement || g;if (j === g || "fixed" === h.position) return g;for (; j.parentElement && j !== g;) {
        var k = b.getComputedStyle(j);if (i && "static" !== k.position && (i = !1), !i && f.test(k.overflow + k.overflowY + k.overflowX)) break;j = j.parentElement;
      }return j;
    }, position: function position(c, d) {
      c = this.getRawNode(c);var e = this.offset(c);if (d) {
        var f = b.getComputedStyle(c);e.top -= this.parseStyle(f.marginTop), e.left -= this.parseStyle(f.marginLeft);
      }var g = this.offsetParent(c),
          h = { top: 0, left: 0 };return g !== a[0].documentElement && (h = this.offset(g), h.top += g.clientTop - g.scrollTop, h.left += g.clientLeft - g.scrollLeft), { width: Math.round(angular.isNumber(e.width) ? e.width : c.offsetWidth), height: Math.round(angular.isNumber(e.height) ? e.height : c.offsetHeight), top: Math.round(e.top - h.top), left: Math.round(e.left - h.left) };
    }, offset: function offset(c) {
      c = this.getRawNode(c);var d = c.getBoundingClientRect();return { width: Math.round(angular.isNumber(d.width) ? d.width : c.offsetWidth), height: Math.round(angular.isNumber(d.height) ? d.height : c.offsetHeight), top: Math.round(d.top + (b.pageYOffset || a[0].documentElement.scrollTop)), left: Math.round(d.left + (b.pageXOffset || a[0].documentElement.scrollLeft)) };
    }, viewportOffset: function viewportOffset(c, d, e) {
      c = this.getRawNode(c), e = e !== !1 ? !0 : !1;var f = c.getBoundingClientRect(),
          g = { top: 0, left: 0, bottom: 0, right: 0 },
          h = d ? a[0].documentElement : this.scrollParent(c),
          i = h.getBoundingClientRect();if (g.top = i.top + h.clientTop, g.left = i.left + h.clientLeft, h === a[0].documentElement && (g.top += b.pageYOffset, g.left += b.pageXOffset), g.bottom = g.top + h.clientHeight, g.right = g.left + h.clientWidth, e) {
        var j = b.getComputedStyle(h);g.top += this.parseStyle(j.paddingTop), g.bottom -= this.parseStyle(j.paddingBottom), g.left += this.parseStyle(j.paddingLeft), g.right -= this.parseStyle(j.paddingRight);
      }return { top: Math.round(f.top - g.top), bottom: Math.round(g.bottom - f.bottom), left: Math.round(f.left - g.left), right: Math.round(g.right - f.right) };
    }, parsePlacement: function parsePlacement(a) {
      var b = e.auto.test(a);return b && (a = a.replace(e.auto, "")), a = a.split("-"), a[0] = a[0] || "top", e.primary.test(a[0]) || (a[0] = "top"), a[1] = a[1] || "center", e.secondary.test(a[1]) || (a[1] = "center"), b ? a[2] = !0 : a[2] = !1, a;
    }, positionElements: function positionElements(a, c, d, f) {
      a = this.getRawNode(a), c = this.getRawNode(c);var g = angular.isDefined(c.offsetWidth) ? c.offsetWidth : c.prop("offsetWidth"),
          h = angular.isDefined(c.offsetHeight) ? c.offsetHeight : c.prop("offsetHeight");d = this.parsePlacement(d);var i = f ? this.offset(a) : this.position(a),
          j = { top: 0, left: 0, placement: "" };if (d[2]) {
        var k = this.viewportOffset(a),
            l = b.getComputedStyle(c),
            m = { width: g + Math.round(Math.abs(this.parseStyle(l.marginLeft) + this.parseStyle(l.marginRight))), height: h + Math.round(Math.abs(this.parseStyle(l.marginTop) + this.parseStyle(l.marginBottom))) };if (d[0] = "top" === d[0] && m.height > k.top && m.height <= k.bottom ? "bottom" : "bottom" === d[0] && m.height > k.bottom && m.height <= k.top ? "top" : "left" === d[0] && m.width > k.left && m.width <= k.right ? "right" : "right" === d[0] && m.width > k.right && m.width <= k.left ? "left" : d[0], d[1] = "top" === d[1] && m.height - i.height > k.bottom && m.height - i.height <= k.top ? "bottom" : "bottom" === d[1] && m.height - i.height > k.top && m.height - i.height <= k.bottom ? "top" : "left" === d[1] && m.width - i.width > k.right && m.width - i.width <= k.left ? "right" : "right" === d[1] && m.width - i.width > k.left && m.width - i.width <= k.right ? "left" : d[1], "center" === d[1]) if (e.vertical.test(d[0])) {
          var n = i.width / 2 - g / 2;k.left + n < 0 && m.width - i.width <= k.right ? d[1] = "left" : k.right + n < 0 && m.width - i.width <= k.left && (d[1] = "right");
        } else {
          var o = i.height / 2 - m.height / 2;k.top + o < 0 && m.height - i.height <= k.bottom ? d[1] = "top" : k.bottom + o < 0 && m.height - i.height <= k.top && (d[1] = "bottom");
        }
      }switch (d[0]) {case "top":
          j.top = i.top - h;break;case "bottom":
          j.top = i.top + i.height;break;case "left":
          j.left = i.left - g;break;case "right":
          j.left = i.left + i.width;}switch (d[1]) {case "top":
          j.top = i.top;break;case "bottom":
          j.top = i.top + i.height - h;break;case "left":
          j.left = i.left;break;case "right":
          j.left = i.left + i.width - g;break;case "center":
          e.vertical.test(d[0]) ? j.left = i.left + i.width / 2 - g / 2 : j.top = i.top + i.height / 2 - h / 2;}return j.top = Math.round(j.top), j.left = Math.round(j.left), j.placement = "center" === d[1] ? d[0] : d[0] + "-" + d[1], j;
    }, positionArrow: function positionArrow(a, c) {
      a = this.getRawNode(a);var d = a.querySelector(".tooltip-inner, .popover-inner");if (d) {
        var f = angular.element(d).hasClass("tooltip-inner"),
            g = f ? a.querySelector(".tooltip-arrow") : a.querySelector(".arrow");if (g) {
          if (c = this.parsePlacement(c), "center" === c[1]) return void angular.element(g).css({ top: "", bottom: "", right: "", left: "", margin: "" });var h = "border-" + c[0] + "-width",
              i = b.getComputedStyle(g)[h],
              j = "border-";j += e.vertical.test(c[0]) ? c[0] + "-" + c[1] : c[1] + "-" + c[0], j += "-radius";var k = b.getComputedStyle(f ? d : a)[j],
              l = { top: "auto", bottom: "auto", left: "auto", right: "auto", margin: 0 };switch (c[0]) {case "top":
              l.bottom = f ? "0" : "-" + i;break;case "bottom":
              l.top = f ? "0" : "-" + i;break;case "left":
              l.right = f ? "0" : "-" + i;break;case "right":
              l.left = f ? "0" : "-" + i;}l[c[1]] = k, angular.element(g).css(l);
        }
      }
    } };
}]), angular.module("ui.bootstrap.datepicker", ["ui.bootstrap.dateparser", "ui.bootstrap.isClass", "ui.bootstrap.position"]).value("$datepickerSuppressError", !1).constant("uibDatepickerConfig", { datepickerMode: "day", formatDay: "dd", formatMonth: "MMMM", formatYear: "yyyy", formatDayHeader: "EEE", formatDayTitle: "MMMM yyyy", formatMonthTitle: "yyyy", maxDate: null, maxMode: "year", minDate: null, minMode: "day", ngModelOptions: {}, shortcutPropagation: !1, showWeeks: !0, yearColumns: 5, yearRows: 4 }).controller("UibDatepickerController", ["$scope", "$attrs", "$parse", "$interpolate", "$locale", "$log", "dateFilter", "uibDatepickerConfig", "$datepickerSuppressError", "uibDateParser", function (a, b, c, d, e, f, g, h, i, j) {
  var k = this,
      l = { $setViewValue: angular.noop },
      m = {},
      n = [];this.modes = ["day", "month", "year"], angular.forEach(["formatDay", "formatMonth", "formatYear", "formatDayHeader", "formatDayTitle", "formatMonthTitle"], function (c) {
    k[c] = angular.isDefined(b[c]) ? d(b[c])(a.$parent) : h[c];
  }), angular.forEach(["showWeeks", "yearRows", "yearColumns", "shortcutPropagation"], function (c) {
    k[c] = angular.isDefined(b[c]) ? a.$parent.$eval(b[c]) : h[c];
  }), angular.isDefined(b.startingDay) ? k.startingDay = a.$parent.$eval(b.startingDay) : angular.isNumber(h.startingDay) ? k.startingDay = h.startingDay : k.startingDay = (e.DATETIME_FORMATS.FIRSTDAYOFWEEK + 8) % 7, angular.forEach(["minDate", "maxDate"], function (c) {
    b[c] ? n.push(a.$parent.$watch(b[c], function (a) {
      k[c] = a ? angular.isDate(a) ? j.fromTimezone(new Date(a), m.timezone) : new Date(g(a, "medium")) : null, k.refreshView();
    })) : k[c] = h[c] ? j.fromTimezone(new Date(h[c]), m.timezone) : null;
  }), angular.forEach(["minMode", "maxMode"], function (c) {
    b[c] ? n.push(a.$parent.$watch(b[c], function (d) {
      k[c] = a[c] = angular.isDefined(d) ? d : b[c], ("minMode" === c && k.modes.indexOf(a.datepickerMode) < k.modes.indexOf(k[c]) || "maxMode" === c && k.modes.indexOf(a.datepickerMode) > k.modes.indexOf(k[c])) && (a.datepickerMode = k[c]);
    })) : k[c] = a[c] = h[c] || null;
  }), a.datepickerMode = a.datepickerMode || h.datepickerMode, a.uniqueId = "datepicker-" + a.$id + "-" + Math.floor(1e4 * Math.random()), angular.isDefined(b.initDate) ? (this.activeDate = j.fromTimezone(a.$parent.$eval(b.initDate), m.timezone) || new Date(), n.push(a.$parent.$watch(b.initDate, function (a) {
    a && (l.$isEmpty(l.$modelValue) || l.$invalid) && (k.activeDate = j.fromTimezone(a, m.timezone), k.refreshView());
  }))) : this.activeDate = new Date(), a.disabled = angular.isDefined(b.disabled) || !1, angular.isDefined(b.ngDisabled) && n.push(a.$parent.$watch(b.ngDisabled, function (b) {
    a.disabled = b, k.refreshView();
  })), a.isActive = function (b) {
    return 0 === k.compare(b.date, k.activeDate) ? (a.activeDateId = b.uid, !0) : !1;
  }, this.init = function (a) {
    l = a, m = a.$options || h.ngModelOptions, l.$modelValue && (this.activeDate = l.$modelValue), l.$render = function () {
      k.render();
    };
  }, this.render = function () {
    if (l.$viewValue) {
      var a = new Date(l.$viewValue),
          b = !isNaN(a);b ? this.activeDate = j.fromTimezone(a, m.timezone) : i || f.error('Datepicker directive: "ng-model" value must be a Date object');
    }this.refreshView();
  }, this.refreshView = function () {
    if (this.element) {
      a.selectedDt = null, this._refreshView(), a.activeDt && (a.activeDateId = a.activeDt.uid);var b = l.$viewValue ? new Date(l.$viewValue) : null;b = j.fromTimezone(b, m.timezone), l.$setValidity("dateDisabled", !b || this.element && !this.isDisabled(b));
    }
  }, this.createDateObject = function (b, c) {
    var d = l.$viewValue ? new Date(l.$viewValue) : null;d = j.fromTimezone(d, m.timezone);var e = { date: b, label: g(b, c.replace(/d!/, "dd")).replace(/M!/, "MM"), selected: d && 0 === this.compare(b, d), disabled: this.isDisabled(b), current: 0 === this.compare(b, new Date()), customClass: this.customClass(b) || null };return d && 0 === this.compare(b, d) && (a.selectedDt = e), k.activeDate && 0 === this.compare(e.date, k.activeDate) && (a.activeDt = e), e;
  }, this.isDisabled = function (c) {
    return a.disabled || this.minDate && this.compare(c, this.minDate) < 0 || this.maxDate && this.compare(c, this.maxDate) > 0 || b.dateDisabled && a.dateDisabled({ date: c, mode: a.datepickerMode });
  }, this.customClass = function (b) {
    return a.customClass({ date: b, mode: a.datepickerMode });
  }, this.split = function (a, b) {
    for (var c = []; a.length > 0;) {
      c.push(a.splice(0, b));
    }return c;
  }, a.select = function (b) {
    if (a.datepickerMode === k.minMode) {
      var c = l.$viewValue ? j.fromTimezone(new Date(l.$viewValue), m.timezone) : new Date(0, 0, 0, 0, 0, 0, 0);c.setFullYear(b.getFullYear(), b.getMonth(), b.getDate()), c = j.toTimezone(c, m.timezone), l.$setViewValue(c), l.$render();
    } else k.activeDate = b, a.datepickerMode = k.modes[k.modes.indexOf(a.datepickerMode) - 1];
  }, a.move = function (a) {
    var b = k.activeDate.getFullYear() + a * (k.step.years || 0),
        c = k.activeDate.getMonth() + a * (k.step.months || 0);k.activeDate.setFullYear(b, c, 1), k.refreshView();
  }, a.toggleMode = function (b) {
    b = b || 1, a.datepickerMode === k.maxMode && 1 === b || a.datepickerMode === k.minMode && -1 === b || (a.datepickerMode = k.modes[k.modes.indexOf(a.datepickerMode) + b]);
  }, a.keys = { 13: "enter", 32: "space", 33: "pageup", 34: "pagedown", 35: "end", 36: "home", 37: "left", 38: "up", 39: "right", 40: "down" };var o = function o() {
    k.element[0].focus();
  };a.$on("uib:datepicker.focus", o), a.keydown = function (b) {
    var c = a.keys[b.which];if (c && !b.shiftKey && !b.altKey && !a.disabled) if (b.preventDefault(), k.shortcutPropagation || b.stopPropagation(), "enter" === c || "space" === c) {
      if (k.isDisabled(k.activeDate)) return;a.select(k.activeDate);
    } else !b.ctrlKey || "up" !== c && "down" !== c ? (k.handleKeyDown(c, b), k.refreshView()) : a.toggleMode("up" === c ? 1 : -1);
  }, a.$on("$destroy", function () {
    for (; n.length;) {
      n.shift()();
    }
  });
}]).controller("UibDaypickerController", ["$scope", "$element", "dateFilter", function (a, b, c) {
  function d(a, b) {
    return 1 !== b || a % 4 !== 0 || a % 100 === 0 && a % 400 !== 0 ? f[b] : 29;
  }function e(a) {
    var b = new Date(a);b.setDate(b.getDate() + 4 - (b.getDay() || 7));var c = b.getTime();return b.setMonth(0), b.setDate(1), Math.floor(Math.round((c - b) / 864e5) / 7) + 1;
  }var f = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];this.step = { months: 1 }, this.element = b, this.init = function (b) {
    angular.extend(b, this), a.showWeeks = b.showWeeks, b.refreshView();
  }, this.getDates = function (a, b) {
    for (var c, d = new Array(b), e = new Date(a), f = 0; b > f;) {
      c = new Date(e), d[f++] = c, e.setDate(e.getDate() + 1);
    }return d;
  }, this._refreshView = function () {
    var b = this.activeDate.getFullYear(),
        d = this.activeDate.getMonth(),
        f = new Date(this.activeDate);f.setFullYear(b, d, 1);var g = this.startingDay - f.getDay(),
        h = g > 0 ? 7 - g : -g,
        i = new Date(f);h > 0 && i.setDate(-h + 1);for (var j = this.getDates(i, 42), k = 0; 42 > k; k++) {
      j[k] = angular.extend(this.createDateObject(j[k], this.formatDay), { secondary: j[k].getMonth() !== d, uid: a.uniqueId + "-" + k });
    }a.labels = new Array(7);for (var l = 0; 7 > l; l++) {
      a.labels[l] = { abbr: c(j[l].date, this.formatDayHeader), full: c(j[l].date, "EEEE") };
    }if (a.title = c(this.activeDate, this.formatDayTitle), a.rows = this.split(j, 7), a.showWeeks) {
      a.weekNumbers = [];for (var m = (11 - this.startingDay) % 7, n = a.rows.length, o = 0; n > o; o++) {
        a.weekNumbers.push(e(a.rows[o][m].date));
      }
    }
  }, this.compare = function (a, b) {
    var c = new Date(a.getFullYear(), a.getMonth(), a.getDate()),
        d = new Date(b.getFullYear(), b.getMonth(), b.getDate());return c.setFullYear(a.getFullYear()), d.setFullYear(b.getFullYear()), c - d;
  }, this.handleKeyDown = function (a, b) {
    var c = this.activeDate.getDate();if ("left" === a) c -= 1;else if ("up" === a) c -= 7;else if ("right" === a) c += 1;else if ("down" === a) c += 7;else if ("pageup" === a || "pagedown" === a) {
      var e = this.activeDate.getMonth() + ("pageup" === a ? -1 : 1);this.activeDate.setMonth(e, 1), c = Math.min(d(this.activeDate.getFullYear(), this.activeDate.getMonth()), c);
    } else "home" === a ? c = 1 : "end" === a && (c = d(this.activeDate.getFullYear(), this.activeDate.getMonth()));this.activeDate.setDate(c);
  };
}]).controller("UibMonthpickerController", ["$scope", "$element", "dateFilter", function (a, b, c) {
  this.step = { years: 1 }, this.element = b, this.init = function (a) {
    angular.extend(a, this), a.refreshView();
  }, this._refreshView = function () {
    for (var b, d = new Array(12), e = this.activeDate.getFullYear(), f = 0; 12 > f; f++) {
      b = new Date(this.activeDate), b.setFullYear(e, f, 1), d[f] = angular.extend(this.createDateObject(b, this.formatMonth), { uid: a.uniqueId + "-" + f });
    }a.title = c(this.activeDate, this.formatMonthTitle), a.rows = this.split(d, 3);
  }, this.compare = function (a, b) {
    var c = new Date(a.getFullYear(), a.getMonth()),
        d = new Date(b.getFullYear(), b.getMonth());return c.setFullYear(a.getFullYear()), d.setFullYear(b.getFullYear()), c - d;
  }, this.handleKeyDown = function (a, b) {
    var c = this.activeDate.getMonth();if ("left" === a) c -= 1;else if ("up" === a) c -= 3;else if ("right" === a) c += 1;else if ("down" === a) c += 3;else if ("pageup" === a || "pagedown" === a) {
      var d = this.activeDate.getFullYear() + ("pageup" === a ? -1 : 1);this.activeDate.setFullYear(d);
    } else "home" === a ? c = 0 : "end" === a && (c = 11);this.activeDate.setMonth(c);
  };
}]).controller("UibYearpickerController", ["$scope", "$element", "dateFilter", function (a, b, c) {
  function d(a) {
    return parseInt((a - 1) / f, 10) * f + 1;
  }var e, f;this.element = b, this.yearpickerInit = function () {
    e = this.yearColumns, f = this.yearRows * e, this.step = { years: f };
  }, this._refreshView = function () {
    for (var b, c = new Array(f), g = 0, h = d(this.activeDate.getFullYear()); f > g; g++) {
      b = new Date(this.activeDate), b.setFullYear(h + g, 0, 1), c[g] = angular.extend(this.createDateObject(b, this.formatYear), { uid: a.uniqueId + "-" + g });
    }a.title = [c[0].label, c[f - 1].label].join(" - "), a.rows = this.split(c, e), a.columns = e;
  }, this.compare = function (a, b) {
    return a.getFullYear() - b.getFullYear();
  }, this.handleKeyDown = function (a, b) {
    var c = this.activeDate.getFullYear();"left" === a ? c -= 1 : "up" === a ? c -= e : "right" === a ? c += 1 : "down" === a ? c += e : "pageup" === a || "pagedown" === a ? c += ("pageup" === a ? -1 : 1) * f : "home" === a ? c = d(this.activeDate.getFullYear()) : "end" === a && (c = d(this.activeDate.getFullYear()) + f - 1), this.activeDate.setFullYear(c);
  };
}]).directive("uibDatepicker", function () {
  return { replace: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/datepicker/datepicker.html";
    }, scope: { datepickerMode: "=?", dateDisabled: "&", customClass: "&", shortcutPropagation: "&?" }, require: ["uibDatepicker", "^ngModel"], controller: "UibDatepickerController", controllerAs: "datepicker", link: function link(a, b, c, d) {
      var e = d[0],
          f = d[1];e.init(f);
    } };
}).directive("uibDaypicker", function () {
  return { replace: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/datepicker/day.html";
    }, require: ["^uibDatepicker", "uibDaypicker"], controller: "UibDaypickerController", link: function link(a, b, c, d) {
      var e = d[0],
          f = d[1];f.init(e);
    } };
}).directive("uibMonthpicker", function () {
  return { replace: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/datepicker/month.html";
    }, require: ["^uibDatepicker", "uibMonthpicker"], controller: "UibMonthpickerController", link: function link(a, b, c, d) {
      var e = d[0],
          f = d[1];f.init(e);
    } };
}).directive("uibYearpicker", function () {
  return { replace: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/datepicker/year.html";
    }, require: ["^uibDatepicker", "uibYearpicker"], controller: "UibYearpickerController", link: function link(a, b, c, d) {
      var e = d[0];angular.extend(e, d[1]), e.yearpickerInit(), e.refreshView();
    } };
}).constant("uibDatepickerPopupConfig", { altInputFormats: [], appendToBody: !1, clearText: "Clear", closeOnDateSelection: !0, closeText: "Done", currentText: "Today", datepickerPopup: "yyyy-MM-dd", datepickerPopupTemplateUrl: "uib/template/datepicker/popup.html", datepickerTemplateUrl: "uib/template/datepicker/datepicker.html", html5Types: { date: "yyyy-MM-dd", "datetime-local": "yyyy-MM-ddTHH:mm:ss.sss", month: "yyyy-MM" }, onOpenFocus: !0, showButtonBar: !0 }).controller("UibDatepickerPopupController", ["$scope", "$element", "$attrs", "$compile", "$parse", "$document", "$rootScope", "$uibPosition", "dateFilter", "uibDateParser", "uibDatepickerPopupConfig", "$timeout", "uibDatepickerConfig", function (a, b, c, d, e, f, g, h, i, j, k, l, m) {
  function n(a) {
    return a.replace(/([A-Z])/g, function (a) {
      return "-" + a.toLowerCase();
    });
  }function o(b) {
    var c = j.parse(b, t, a.date);if (isNaN(c)) for (var d = 0; d < E.length; d++) {
      if (c = j.parse(b, E[d], a.date), !isNaN(c)) return c;
    }return c;
  }function p(a) {
    if (angular.isNumber(a) && (a = new Date(a)), !a) return null;if (angular.isDate(a) && !isNaN(a)) return a;if (angular.isString(a)) {
      var b = o(a);if (!isNaN(b)) return j.toTimezone(b, C.timezone);
    }return B.$options && B.$options.allowInvalid ? a : void 0;
  }function q(a, b) {
    var d = a || b;return c.ngRequired || d ? (angular.isNumber(d) && (d = new Date(d)), d ? angular.isDate(d) && !isNaN(d) ? !0 : angular.isString(d) ? !isNaN(o(b)) : !1 : !0) : !0;
  }function r(c) {
    if (a.isOpen || !a.disabled) {
      var d = D[0],
          e = b[0].contains(c.target),
          f = void 0 !== d.contains && d.contains(c.target);!a.isOpen || e || f || a.$apply(function () {
        a.isOpen = !1;
      });
    }
  }function s(c) {
    27 === c.which && a.isOpen ? (c.preventDefault(), c.stopPropagation(), a.$apply(function () {
      a.isOpen = !1;
    }), b[0].focus()) : 40 !== c.which || a.isOpen || (c.preventDefault(), c.stopPropagation(), a.$apply(function () {
      a.isOpen = !0;
    }));
  }var t,
      u,
      v,
      w,
      x,
      y,
      z,
      A,
      B,
      C,
      D,
      E,
      F = {},
      G = !1,
      H = [];a.watchData = {}, this.init = function (h) {
    if (B = h, C = h.$options || m.ngModelOptions, u = angular.isDefined(c.closeOnDateSelection) ? a.$parent.$eval(c.closeOnDateSelection) : k.closeOnDateSelection, v = angular.isDefined(c.datepickerAppendToBody) ? a.$parent.$eval(c.datepickerAppendToBody) : k.appendToBody, w = angular.isDefined(c.onOpenFocus) ? a.$parent.$eval(c.onOpenFocus) : k.onOpenFocus, x = angular.isDefined(c.datepickerPopupTemplateUrl) ? c.datepickerPopupTemplateUrl : k.datepickerPopupTemplateUrl, y = angular.isDefined(c.datepickerTemplateUrl) ? c.datepickerTemplateUrl : k.datepickerTemplateUrl, E = angular.isDefined(c.altInputFormats) ? a.$parent.$eval(c.altInputFormats) : k.altInputFormats, a.showButtonBar = angular.isDefined(c.showButtonBar) ? a.$parent.$eval(c.showButtonBar) : k.showButtonBar, k.html5Types[c.type] ? (t = k.html5Types[c.type], G = !0) : (t = c.uibDatepickerPopup || k.datepickerPopup, c.$observe("uibDatepickerPopup", function (a, b) {
      var c = a || k.datepickerPopup;if (c !== t && (t = c, B.$modelValue = null, !t)) throw new Error("uibDatepickerPopup must have a date format specified.");
    })), !t) throw new Error("uibDatepickerPopup must have a date format specified.");if (G && c.uibDatepickerPopup) throw new Error("HTML5 date input types do not support custom formats.");z = angular.element("<div uib-datepicker-popup-wrap><div uib-datepicker></div></div>"), a.ngModelOptions = angular.copy(C), a.ngModelOptions.timezone = null, z.attr({ "ng-model": "date", "ng-model-options": "ngModelOptions", "ng-change": "dateSelection(date)", "template-url": x }), A = angular.element(z.children()[0]), A.attr("template-url", y), G && "month" === c.type && (A.attr("datepicker-mode", '"month"'), A.attr("min-mode", "month")), a.datepickerOptions && angular.forEach(a.datepickerOptions, function (a, b) {
      -1 === ["minDate", "maxDate", "minMode", "maxMode", "initDate", "datepickerMode"].indexOf(b) ? A.attr(n(b), a) : A.attr(n(b), "datepickerOptions." + b);
    }), angular.forEach(["minMode", "maxMode", "datepickerMode", "shortcutPropagation"], function (b) {
      if (c[b]) {
        var d = e(c[b]),
            f = { get: function get() {
            return d(a.$parent);
          } };if (A.attr(n(b), "watchData." + b), "datepickerMode" === b) {
          var g = d.assign;f.set = function (b) {
            g(a.$parent, b);
          };
        }Object.defineProperty(a.watchData, b, f);
      }
    }), angular.forEach(["minDate", "maxDate", "initDate"], function (b) {
      if (c[b]) {
        var d = e(c[b]);H.push(a.$parent.$watch(d, function (c) {
          "minDate" === b || "maxDate" === b ? (null === c ? F[b] = null : angular.isDate(c) ? F[b] = j.fromTimezone(new Date(c), C.timezone) : F[b] = new Date(i(c, "medium")), a.watchData[b] = null === c ? null : F[b]) : a.watchData[b] = j.fromTimezone(new Date(c), C.timezone);
        })), A.attr(n(b), "watchData." + b);
      }
    }), c.dateDisabled && A.attr("date-disabled", "dateDisabled({ date: date, mode: mode })"), angular.forEach(["formatDay", "formatMonth", "formatYear", "formatDayHeader", "formatDayTitle", "formatMonthTitle", "showWeeks", "startingDay", "yearRows", "yearColumns"], function (a) {
      angular.isDefined(c[a]) && A.attr(n(a), c[a]);
    }), c.customClass && A.attr("custom-class", "customClass({ date: date, mode: mode })"), G ? B.$formatters.push(function (b) {
      return a.date = j.fromTimezone(b, C.timezone), b;
    }) : (B.$$parserName = "date", B.$validators.date = q, B.$parsers.unshift(p), B.$formatters.push(function (b) {
      return B.$isEmpty(b) ? (a.date = b, b) : (a.date = j.fromTimezone(b, C.timezone), t = t.replace(/M!/, "MM").replace(/d!/, "dd"), i(a.date, t));
    })), B.$viewChangeListeners.push(function () {
      a.date = o(B.$viewValue);
    }), b.on("keydown", s), D = d(z)(a), z.remove(), v ? f.find("body").append(D) : b.after(D), a.$on("$destroy", function () {
      for (a.isOpen === !0 && (g.$$phase || a.$apply(function () {
        a.isOpen = !1;
      })), D.remove(), b.off("keydown", s), f.off("click", r); H.length;) {
        H.shift()();
      }
    });
  }, a.getText = function (b) {
    return a[b + "Text"] || k[b + "Text"];
  }, a.isDisabled = function (b) {
    return "today" === b && (b = new Date()), a.watchData.minDate && a.compare(b, F.minDate) < 0 || a.watchData.maxDate && a.compare(b, F.maxDate) > 0;
  }, a.compare = function (a, b) {
    return new Date(a.getFullYear(), a.getMonth(), a.getDate()) - new Date(b.getFullYear(), b.getMonth(), b.getDate());
  }, a.dateSelection = function (c) {
    angular.isDefined(c) && (a.date = c);var d = a.date ? i(a.date, t) : null;b.val(d), B.$setViewValue(d), u && (a.isOpen = !1, b[0].focus());
  }, a.keydown = function (c) {
    27 === c.which && (c.stopPropagation(), a.isOpen = !1, b[0].focus());
  }, a.select = function (b) {
    if ("today" === b) {
      var c = new Date();angular.isDate(a.date) ? (b = new Date(a.date), b.setFullYear(c.getFullYear(), c.getMonth(), c.getDate())) : b = new Date(c.setHours(0, 0, 0, 0));
    }a.dateSelection(b);
  }, a.close = function () {
    a.isOpen = !1, b[0].focus();
  }, a.disabled = angular.isDefined(c.disabled) || !1, c.ngDisabled && H.push(a.$parent.$watch(e(c.ngDisabled), function (b) {
    a.disabled = b;
  })), a.$watch("isOpen", function (c) {
    c ? a.disabled ? a.isOpen = !1 : (a.position = v ? h.offset(b) : h.position(b), a.position.top = a.position.top + b.prop("offsetHeight"), l(function () {
      w && a.$broadcast("uib:datepicker.focus"), f.on("click", r);
    }, 0, !1)) : f.off("click", r);
  });
}]).directive("uibDatepickerPopup", function () {
  return { require: ["ngModel", "uibDatepickerPopup"], controller: "UibDatepickerPopupController", scope: { datepickerOptions: "=?", isOpen: "=?", currentText: "@", clearText: "@", closeText: "@", dateDisabled: "&", customClass: "&" }, link: function link(a, b, c, d) {
      var e = d[0],
          f = d[1];f.init(e);
    } };
}).directive("uibDatepickerPopupWrap", function () {
  return { replace: !0, transclude: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/datepicker/popup.html";
    } };
}), angular.module("ui.bootstrap.debounce", []).factory("$$debounce", ["$timeout", function (a) {
  return function (b, c) {
    var d;return function () {
      var e = this,
          f = Array.prototype.slice.call(arguments);d && a.cancel(d), d = a(function () {
        b.apply(e, f);
      }, c);
    };
  };
}]), angular.module("ui.bootstrap.dropdown", ["ui.bootstrap.position"]).constant("uibDropdownConfig", { appendToOpenClass: "uib-dropdown-open", openClass: "open" }).service("uibDropdownService", ["$document", "$rootScope", function (a, b) {
  var c = null;this.open = function (b) {
    c || (a.on("click", d), a.on("keydown", e)), c && c !== b && (c.isOpen = !1), c = b;
  }, this.close = function (b) {
    c === b && (c = null, a.off("click", d), a.off("keydown", e));
  };var d = function d(a) {
    if (c && !(a && "disabled" === c.getAutoClose() || a && 3 === a.which)) {
      var d = c.getToggleElement();if (!(a && d && d[0].contains(a.target))) {
        var e = c.getDropdownElement();a && "outsideClick" === c.getAutoClose() && e && e[0].contains(a.target) || (c.isOpen = !1, b.$$phase || c.$apply());
      }
    }
  },
      e = function e(a) {
    27 === a.which ? (c.focusToggleElement(), d()) : c.isKeynavEnabled() && -1 !== [38, 40].indexOf(a.which) && c.isOpen && (a.preventDefault(), a.stopPropagation(), c.focusDropdownEntry(a.which));
  };
}]).controller("UibDropdownController", ["$scope", "$element", "$attrs", "$parse", "uibDropdownConfig", "uibDropdownService", "$animate", "$uibPosition", "$document", "$compile", "$templateRequest", function (a, b, c, d, e, f, g, h, i, j, k) {
  var l,
      m,
      n = this,
      o = a.$new(),
      p = e.appendToOpenClass,
      q = e.openClass,
      r = angular.noop,
      s = c.onToggle ? d(c.onToggle) : angular.noop,
      t = !1,
      u = null,
      v = !1,
      w = i.find("body");b.addClass("dropdown"), this.init = function () {
    if (c.isOpen && (m = d(c.isOpen), r = m.assign, a.$watch(m, function (a) {
      o.isOpen = !!a;
    })), angular.isDefined(c.dropdownAppendTo)) {
      var e = d(c.dropdownAppendTo)(o);e && (u = angular.element(e));
    }t = angular.isDefined(c.dropdownAppendToBody), v = angular.isDefined(c.keyboardNav), t && !u && (u = w), u && n.dropdownMenu && (u.append(n.dropdownMenu), b.on("$destroy", function () {
      n.dropdownMenu.remove();
    }));
  }, this.toggle = function (a) {
    return o.isOpen = arguments.length ? !!a : !o.isOpen;
  }, this.isOpen = function () {
    return o.isOpen;
  }, o.getToggleElement = function () {
    return n.toggleElement;
  }, o.getAutoClose = function () {
    return c.autoClose || "always";
  }, o.getElement = function () {
    return b;
  }, o.isKeynavEnabled = function () {
    return v;
  }, o.focusDropdownEntry = function (a) {
    var c = n.dropdownMenu ? angular.element(n.dropdownMenu).find("a") : b.find("ul").eq(0).find("a");switch (a) {case 40:
        angular.isNumber(n.selectedOption) ? n.selectedOption = n.selectedOption === c.length - 1 ? n.selectedOption : n.selectedOption + 1 : n.selectedOption = 0;break;case 38:
        angular.isNumber(n.selectedOption) ? n.selectedOption = 0 === n.selectedOption ? 0 : n.selectedOption - 1 : n.selectedOption = c.length - 1;}c[n.selectedOption].focus();
  }, o.getDropdownElement = function () {
    return n.dropdownMenu;
  }, o.focusToggleElement = function () {
    n.toggleElement && n.toggleElement[0].focus();
  }, o.$watch("isOpen", function (c, d) {
    if (u && n.dropdownMenu) {
      var e,
          i,
          m = h.positionElements(b, n.dropdownMenu, "bottom-left", !0);if (e = { top: m.top + "px", display: c ? "block" : "none" }, i = n.dropdownMenu.hasClass("dropdown-menu-right"), i ? (e.left = "auto", e.right = window.innerWidth - (m.left + b.prop("offsetWidth")) + "px") : (e.left = m.left + "px", e.right = "auto"), !t) {
        var v = h.offset(u);e.top = m.top - v.top + "px", i ? e.right = window.innerWidth - (m.left - v.left + b.prop("offsetWidth")) + "px" : e.left = m.left - v.left + "px";
      }n.dropdownMenu.css(e);
    }var w = u ? u : b;if (g[c ? "addClass" : "removeClass"](w, u ? p : q).then(function () {
      angular.isDefined(c) && c !== d && s(a, { open: !!c });
    }), c) n.dropdownMenuTemplateUrl && k(n.dropdownMenuTemplateUrl).then(function (a) {
      l = o.$new(), j(a.trim())(l, function (a) {
        var b = a;n.dropdownMenu.replaceWith(b), n.dropdownMenu = b;
      });
    }), o.focusToggleElement(), f.open(o);else {
      if (n.dropdownMenuTemplateUrl) {
        l && l.$destroy();var x = angular.element('<ul class="dropdown-menu"></ul>');n.dropdownMenu.replaceWith(x), n.dropdownMenu = x;
      }f.close(o), n.selectedOption = null;
    }angular.isFunction(r) && r(a, c);
  }), a.$on("$locationChangeSuccess", function () {
    "disabled" !== o.getAutoClose() && (o.isOpen = !1);
  });
}]).directive("uibDropdown", function () {
  return { controller: "UibDropdownController", link: function link(a, b, c, d) {
      d.init();
    } };
}).directive("uibDropdownMenu", function () {
  return { restrict: "A", require: "?^uibDropdown", link: function link(a, b, c, d) {
      if (d && !angular.isDefined(c.dropdownNested)) {
        b.addClass("dropdown-menu");var e = c.templateUrl;e && (d.dropdownMenuTemplateUrl = e), d.dropdownMenu || (d.dropdownMenu = b);
      }
    } };
}).directive("uibDropdownToggle", function () {
  return { require: "?^uibDropdown", link: function link(a, b, c, d) {
      if (d) {
        b.addClass("dropdown-toggle"), d.toggleElement = b;var e = function e(_e2) {
          _e2.preventDefault(), b.hasClass("disabled") || c.disabled || a.$apply(function () {
            d.toggle();
          });
        };b.bind("click", e), b.attr({ "aria-haspopup": !0, "aria-expanded": !1 }), a.$watch(d.isOpen, function (a) {
          b.attr("aria-expanded", !!a);
        }), a.$on("$destroy", function () {
          b.unbind("click", e);
        });
      }
    } };
}), angular.module("ui.bootstrap.stackedMap", []).factory("$$stackedMap", function () {
  return { createNew: function createNew() {
      var a = [];return { add: function add(b, c) {
          a.push({ key: b, value: c });
        }, get: function get(b) {
          for (var c = 0; c < a.length; c++) {
            if (b === a[c].key) return a[c];
          }
        }, keys: function keys() {
          for (var b = [], c = 0; c < a.length; c++) {
            b.push(a[c].key);
          }return b;
        }, top: function top() {
          return a[a.length - 1];
        }, remove: function remove(b) {
          for (var c = -1, d = 0; d < a.length; d++) {
            if (b === a[d].key) {
              c = d;break;
            }
          }return a.splice(c, 1)[0];
        }, removeTop: function removeTop() {
          return a.splice(a.length - 1, 1)[0];
        }, length: function length() {
          return a.length;
        } };
    } };
}), angular.module("ui.bootstrap.modal", ["ui.bootstrap.stackedMap"]).factory("$$multiMap", function () {
  return { createNew: function createNew() {
      var a = {};return { entries: function entries() {
          return Object.keys(a).map(function (b) {
            return { key: b, value: a[b] };
          });
        }, get: function get(b) {
          return a[b];
        }, hasKey: function hasKey(b) {
          return !!a[b];
        }, keys: function keys() {
          return Object.keys(a);
        }, put: function put(b, c) {
          a[b] || (a[b] = []), a[b].push(c);
        }, remove: function remove(b, c) {
          var d = a[b];if (d) {
            var e = d.indexOf(c);-1 !== e && d.splice(e, 1), d.length || delete a[b];
          }
        } };
    } };
}).provider("$uibResolve", function () {
  var a = this;this.resolver = null, this.setResolver = function (a) {
    this.resolver = a;
  }, this.$get = ["$injector", "$q", function (b, c) {
    var d = a.resolver ? b.get(a.resolver) : null;return { resolve: function resolve(a, e, f, g) {
        if (d) return d.resolve(a, e, f, g);var h = [];return angular.forEach(a, function (a) {
          angular.isFunction(a) || angular.isArray(a) ? h.push(c.resolve(b.invoke(a))) : angular.isString(a) ? h.push(c.resolve(b.get(a))) : h.push(c.resolve(a));
        }), c.all(h).then(function (b) {
          var c = {},
              d = 0;return angular.forEach(a, function (a, e) {
            c[e] = b[d++];
          }), c;
        });
      } };
  }];
}).directive("uibModalBackdrop", ["$animateCss", "$injector", "$uibModalStack", function (a, b, c) {
  function d(b, d, e) {
    e.modalInClass && (a(d, { addClass: e.modalInClass }).start(), b.$on(c.NOW_CLOSING_EVENT, function (c, f) {
      var g = f();b.modalOptions.animation ? a(d, { removeClass: e.modalInClass }).start().then(g) : g();
    }));
  }return { replace: !0, templateUrl: "uib/template/modal/backdrop.html", compile: function compile(a, b) {
      return a.addClass(b.backdropClass), d;
    } };
}]).directive("uibModalWindow", ["$uibModalStack", "$q", "$animate", "$animateCss", "$document", function (a, b, c, d, e) {
  return { scope: { index: "@" }, replace: !0, transclude: !0, templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/modal/window.html";
    }, link: function link(f, g, h) {
      g.addClass(h.windowClass || ""), g.addClass(h.windowTopClass || ""), f.size = h.size, f.close = function (b) {
        var c = a.getTop();c && c.value.backdrop && "static" !== c.value.backdrop && b.target === b.currentTarget && (b.preventDefault(), b.stopPropagation(), a.dismiss(c.key, "backdrop click"));
      }, g.on("click", f.close), f.$isRendered = !0;var i = b.defer();h.$observe("modalRender", function (a) {
        "true" === a && i.resolve();
      }), i.promise.then(function () {
        var i = null;h.modalInClass && (i = d(g, { addClass: h.modalInClass }).start(), f.$on(a.NOW_CLOSING_EVENT, function (a, b) {
          var e = b();d ? d(g, { removeClass: h.modalInClass }).start().then(e) : c.removeClass(g, h.modalInClass).then(e);
        })), b.when(i).then(function () {
          if (!e[0].activeElement || !g[0].contains(e[0].activeElement)) {
            var a = g[0].querySelector("[autofocus]");a ? a.focus() : g[0].focus();
          }
        });var j = a.getTop();j && a.modalRendered(j.key);
      });
    } };
}]).directive("uibModalAnimationClass", function () {
  return { compile: function compile(a, b) {
      b.modalAnimation && a.addClass(b.uibModalAnimationClass);
    } };
}).directive("uibModalTransclude", function () {
  return { link: function link(a, b, c, d, e) {
      e(a.$parent, function (a) {
        b.empty(), b.append(a);
      });
    } };
}).factory("$uibModalStack", ["$animate", "$animateCss", "$document", "$compile", "$rootScope", "$q", "$$multiMap", "$$stackedMap", function (a, b, c, d, e, f, g, h) {
  function i() {
    for (var a = -1, b = t.keys(), c = 0; c < b.length; c++) {
      t.get(b[c]).value.backdrop && (a = c);
    }return a;
  }function j(a, b) {
    var c = t.get(a).value,
        d = c.appendTo;t.remove(a), m(c.modalDomEl, c.modalScope, function () {
      var b = c.openedClass || s;u.remove(b, a), d.toggleClass(b, u.hasKey(b)), k(!0);
    }, c.closedDeferred), l(), b && b.focus ? b.focus() : d.focus && d.focus();
  }function k(a) {
    var b;t.length() > 0 && (b = t.top().value, b.modalDomEl.toggleClass(b.windowTopClass || "", a));
  }function l() {
    if (p && -1 === i()) {
      var a = q;m(p, q, function () {
        a = null;
      }), p = void 0, q = void 0;
    }
  }function m(a, c, d, e) {
    function g() {
      g.done || (g.done = !0, b(a, { event: "leave" }).start().then(function () {
        a.remove(), e && e.resolve();
      }), c.$destroy(), d && d());
    }var h,
        i = null,
        j = function j() {
      return h || (h = f.defer(), i = h.promise), function () {
        h.resolve();
      };
    };return c.$broadcast(v.NOW_CLOSING_EVENT, j), f.when(i).then(g);
  }function n(a) {
    if (a.isDefaultPrevented()) return a;var b = t.top();if (b) switch (a.which) {case 27:
        b.value.keyboard && (a.preventDefault(), e.$apply(function () {
          v.dismiss(b.key, "escape key press");
        }));break;case 9:
        v.loadFocusElementList(b);var c = !1;a.shiftKey ? v.isFocusInFirstItem(a) && (c = v.focusLastFocusableElement()) : v.isFocusInLastItem(a) && (c = v.focusFirstFocusableElement()), c && (a.preventDefault(), a.stopPropagation());}
  }function o(a, b, c) {
    return !a.value.modalScope.$broadcast("modal.closing", b, c).defaultPrevented;
  }var p,
      q,
      r,
      s = "modal-open",
      t = h.createNew(),
      u = g.createNew(),
      v = { NOW_CLOSING_EVENT: "modal.stack.now-closing" },
      w = 0,
      x = "a[href], area[href], input:not([disabled]), button:not([disabled]),select:not([disabled]), textarea:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable=true]";return e.$watch(i, function (a) {
    q && (q.index = a);
  }), c.on("keydown", n), e.$on("$destroy", function () {
    c.off("keydown", n);
  }), v.open = function (b, f) {
    var g = c[0].activeElement,
        h = f.openedClass || s;k(!1), t.add(b, { deferred: f.deferred, renderDeferred: f.renderDeferred, closedDeferred: f.closedDeferred, modalScope: f.scope, backdrop: f.backdrop, keyboard: f.keyboard, openedClass: f.openedClass, windowTopClass: f.windowTopClass, animation: f.animation, appendTo: f.appendTo }), u.put(h, b);var j = f.appendTo,
        l = i();if (!j.length) throw new Error("appendTo element not found. Make sure that the element passed is in DOM.");l >= 0 && !p && (q = e.$new(!0), q.modalOptions = f, q.index = l, p = angular.element('<div uib-modal-backdrop="modal-backdrop"></div>'), p.attr("backdrop-class", f.backdropClass), f.animation && p.attr("modal-animation", "true"), d(p)(q), a.enter(p, j));var m = angular.element('<div uib-modal-window="modal-window"></div>');m.attr({ "template-url": f.windowTemplateUrl, "window-class": f.windowClass, "window-top-class": f.windowTopClass, size: f.size, index: t.length() - 1, animate: "animate" }).html(f.content), f.animation && m.attr("modal-animation", "true"), a.enter(d(m)(f.scope), j).then(function () {
      a.addClass(j, h);
    }), t.top().value.modalDomEl = m, t.top().value.modalOpener = g, v.clearFocusListCache();
  }, v.close = function (a, b) {
    var c = t.get(a);return c && o(c, b, !0) ? (c.value.modalScope.$$uibDestructionScheduled = !0, c.value.deferred.resolve(b), j(a, c.value.modalOpener), !0) : !c;
  }, v.dismiss = function (a, b) {
    var c = t.get(a);return c && o(c, b, !1) ? (c.value.modalScope.$$uibDestructionScheduled = !0, c.value.deferred.reject(b), j(a, c.value.modalOpener), !0) : !c;
  }, v.dismissAll = function (a) {
    for (var b = this.getTop(); b && this.dismiss(b.key, a);) {
      b = this.getTop();
    }
  }, v.getTop = function () {
    return t.top();
  }, v.modalRendered = function (a) {
    var b = t.get(a);b && b.value.renderDeferred.resolve();
  }, v.focusFirstFocusableElement = function () {
    return r.length > 0 ? (r[0].focus(), !0) : !1;
  }, v.focusLastFocusableElement = function () {
    return r.length > 0 ? (r[r.length - 1].focus(), !0) : !1;
  }, v.isFocusInFirstItem = function (a) {
    return r.length > 0 ? (a.target || a.srcElement) === r[0] : !1;
  }, v.isFocusInLastItem = function (a) {
    return r.length > 0 ? (a.target || a.srcElement) === r[r.length - 1] : !1;
  }, v.clearFocusListCache = function () {
    r = [], w = 0;
  }, v.loadFocusElementList = function (a) {
    if ((void 0 === r || !r.length) && a) {
      var b = a.value.modalDomEl;b && b.length && (r = b[0].querySelectorAll(x));
    }
  }, v;
}]).provider("$uibModal", function () {
  var a = { options: { animation: !0, backdrop: !0, keyboard: !0 }, $get: ["$rootScope", "$q", "$document", "$templateRequest", "$controller", "$uibResolve", "$uibModalStack", function (b, c, d, e, f, g, h) {
      function i(a) {
        return a.template ? c.when(a.template) : e(angular.isFunction(a.templateUrl) ? a.templateUrl() : a.templateUrl);
      }var j = {},
          k = null;return j.getPromiseChain = function () {
        return k;
      }, j.open = function (e) {
        function j() {
          return r;
        }var l = c.defer(),
            m = c.defer(),
            n = c.defer(),
            o = c.defer(),
            p = { result: l.promise, opened: m.promise, closed: n.promise, rendered: o.promise, close: function close(a) {
            return h.close(p, a);
          }, dismiss: function dismiss(a) {
            return h.dismiss(p, a);
          } };if (e = angular.extend({}, a.options, e), e.resolve = e.resolve || {}, e.appendTo = e.appendTo || d.find("body").eq(0), !e.template && !e.templateUrl) throw new Error("One of template or templateUrl options is required.");var q,
            r = c.all([i(e), g.resolve(e.resolve, {}, null, null)]);return q = k = c.all([k]).then(j, j).then(function (a) {
          var c = e.scope || b,
              d = c.$new();d.$close = p.close, d.$dismiss = p.dismiss, d.$on("$destroy", function () {
            d.$$uibDestructionScheduled || d.$dismiss("$uibUnscheduledDestruction");
          });var g,
              i = {};e.controller && (i.$scope = d, i.$uibModalInstance = p, angular.forEach(a[1], function (a, b) {
            i[b] = a;
          }), g = f(e.controller, i), e.controllerAs && (e.bindToController && (g.$close = d.$close, g.$dismiss = d.$dismiss, angular.extend(g, c)), d[e.controllerAs] = g)), h.open(p, { scope: d, deferred: l, renderDeferred: o, closedDeferred: n, content: a[0], animation: e.animation, backdrop: e.backdrop, keyboard: e.keyboard, backdropClass: e.backdropClass, windowTopClass: e.windowTopClass, windowClass: e.windowClass, windowTemplateUrl: e.windowTemplateUrl, size: e.size, openedClass: e.openedClass, appendTo: e.appendTo }), m.resolve(!0);
        }, function (a) {
          m.reject(a), l.reject(a);
        })["finally"](function () {
          k === q && (k = null);
        }), p;
      }, j;
    }] };return a;
}), angular.module("ui.bootstrap.paging", []).factory("uibPaging", ["$parse", function (a) {
  return { create: function create(b, c, d) {
      b.setNumPages = d.numPages ? a(d.numPages).assign : angular.noop, b.ngModelCtrl = { $setViewValue: angular.noop }, b._watchers = [], b.init = function (e, f) {
        b.ngModelCtrl = e, b.config = f, e.$render = function () {
          b.render();
        }, d.itemsPerPage ? b._watchers.push(c.$parent.$watch(a(d.itemsPerPage), function (a) {
          b.itemsPerPage = parseInt(a, 10), c.totalPages = b.calculateTotalPages(), b.updatePage();
        })) : b.itemsPerPage = f.itemsPerPage, c.$watch("totalItems", function (a, d) {
          (angular.isDefined(a) || a !== d) && (c.totalPages = b.calculateTotalPages(), b.updatePage());
        });
      }, b.calculateTotalPages = function () {
        var a = b.itemsPerPage < 1 ? 1 : Math.ceil(c.totalItems / b.itemsPerPage);return Math.max(a || 0, 1);
      }, b.render = function () {
        c.page = parseInt(b.ngModelCtrl.$viewValue, 10) || 1;
      }, c.selectPage = function (a, d) {
        d && d.preventDefault();var e = !c.ngDisabled || !d;e && c.page !== a && a > 0 && a <= c.totalPages && (d && d.target && d.target.blur(), b.ngModelCtrl.$setViewValue(a), b.ngModelCtrl.$render());
      }, c.getText = function (a) {
        return c[a + "Text"] || b.config[a + "Text"];
      }, c.noPrevious = function () {
        return 1 === c.page;
      }, c.noNext = function () {
        return c.page === c.totalPages;
      }, b.updatePage = function () {
        b.setNumPages(c.$parent, c.totalPages), c.page > c.totalPages ? c.selectPage(c.totalPages) : b.ngModelCtrl.$render();
      }, c.$on("$destroy", function () {
        for (; b._watchers.length;) {
          b._watchers.shift()();
        }
      });
    } };
}]), angular.module("ui.bootstrap.pager", ["ui.bootstrap.paging"]).controller("UibPagerController", ["$scope", "$attrs", "uibPaging", "uibPagerConfig", function (a, b, c, d) {
  a.align = angular.isDefined(b.align) ? a.$parent.$eval(b.align) : d.align, c.create(this, a, b);
}]).constant("uibPagerConfig", { itemsPerPage: 10, previousText: "« Previous", nextText: "Next »", align: !0 }).directive("uibPager", ["uibPagerConfig", function (a) {
  return { scope: { totalItems: "=", previousText: "@", nextText: "@", ngDisabled: "=" }, require: ["uibPager", "?ngModel"], controller: "UibPagerController", controllerAs: "pager", templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/pager/pager.html";
    }, replace: !0, link: function link(b, c, d, e) {
      var f = e[0],
          g = e[1];g && f.init(g, a);
    } };
}]), angular.module("ui.bootstrap.pagination", ["ui.bootstrap.paging"]).controller("UibPaginationController", ["$scope", "$attrs", "$parse", "uibPaging", "uibPaginationConfig", function (a, b, c, d, e) {
  function f(a, b, c) {
    return { number: a, text: b, active: c };
  }function g(a, b) {
    var c = [],
        d = 1,
        e = b,
        g = angular.isDefined(i) && b > i;g && (j ? (d = Math.max(a - Math.floor(i / 2), 1), e = d + i - 1, e > b && (e = b, d = e - i + 1)) : (d = (Math.ceil(a / i) - 1) * i + 1, e = Math.min(d + i - 1, b)));for (var h = d; e >= h; h++) {
      var m = f(h, h, h === a);c.push(m);
    }if (g && i > 0 && (!j || k || l)) {
      if (d > 1) {
        if (!l || d > 3) {
          var n = f(d - 1, "...", !1);c.unshift(n);
        }if (l) {
          if (3 === d) {
            var o = f(2, "2", !1);c.unshift(o);
          }var p = f(1, "1", !1);c.unshift(p);
        }
      }if (b > e) {
        if (!l || b - 2 > e) {
          var q = f(e + 1, "...", !1);c.push(q);
        }if (l) {
          if (e === b - 2) {
            var r = f(b - 1, b - 1, !1);c.push(r);
          }var s = f(b, b, !1);c.push(s);
        }
      }
    }return c;
  }var h = this,
      i = angular.isDefined(b.maxSize) ? a.$parent.$eval(b.maxSize) : e.maxSize,
      j = angular.isDefined(b.rotate) ? a.$parent.$eval(b.rotate) : e.rotate,
      k = angular.isDefined(b.forceEllipses) ? a.$parent.$eval(b.forceEllipses) : e.forceEllipses,
      l = angular.isDefined(b.boundaryLinkNumbers) ? a.$parent.$eval(b.boundaryLinkNumbers) : e.boundaryLinkNumbers;a.boundaryLinks = angular.isDefined(b.boundaryLinks) ? a.$parent.$eval(b.boundaryLinks) : e.boundaryLinks, a.directionLinks = angular.isDefined(b.directionLinks) ? a.$parent.$eval(b.directionLinks) : e.directionLinks, d.create(this, a, b), b.maxSize && h._watchers.push(a.$parent.$watch(c(b.maxSize), function (a) {
    i = parseInt(a, 10), h.render();
  }));var m = this.render;this.render = function () {
    m(), a.page > 0 && a.page <= a.totalPages && (a.pages = g(a.page, a.totalPages));
  };
}]).constant("uibPaginationConfig", { itemsPerPage: 10, boundaryLinks: !1, boundaryLinkNumbers: !1, directionLinks: !0, firstText: "First", previousText: "Previous", nextText: "Next", lastText: "Last", rotate: !0, forceEllipses: !1 }).directive("uibPagination", ["$parse", "uibPaginationConfig", function (a, b) {
  return { scope: { totalItems: "=", firstText: "@", previousText: "@", nextText: "@", lastText: "@", ngDisabled: "=" }, require: ["uibPagination", "?ngModel"], controller: "UibPaginationController", controllerAs: "pagination", templateUrl: function templateUrl(a, b) {
      return b.templateUrl || "uib/template/pagination/pagination.html";
    }, replace: !0, link: function link(a, c, d, e) {
      var f = e[0],
          g = e[1];g && f.init(g, b);
    } };
}]), angular.module("ui.bootstrap.tooltip", ["ui.bootstrap.position", "ui.bootstrap.stackedMap"]).provider("$uibTooltip", function () {
  function a(a) {
    var b = /[A-Z]/g,
        c = "-";return a.replace(b, function (a, b) {
      return (b ? c : "") + a.toLowerCase();
    });
  }var b = { placement: "top", placementClassPrefix: "", animation: !0, popupDelay: 0, popupCloseDelay: 0, useContentExp: !1 },
      c = { mouseenter: "mouseleave", click: "click", outsideClick: "outsideClick", focus: "blur", none: "" },
      d = {};this.options = function (a) {
    angular.extend(d, a);
  }, this.setTriggers = function (a) {
    angular.extend(c, a);
  }, this.$get = ["$window", "$compile", "$timeout", "$document", "$uibPosition", "$interpolate", "$rootScope", "$parse", "$$stackedMap", function (e, f, g, h, i, j, k, l, m) {
    function n(a) {
      if (27 === a.which) {
        var b = o.top();b && (b.value.close(), o.removeTop(), b = null);
      }
    }var o = m.createNew();return h.on("keypress", n), k.$on("$destroy", function () {
      h.off("keypress", n);
    }), function (e, k, m, n) {
      function p(a) {
        var b = (a || n.trigger || m).split(" "),
            d = b.map(function (a) {
          return c[a] || a;
        });return { show: b, hide: d };
      }n = angular.extend({}, b, d, n);var q = a(e),
          r = j.startSymbol(),
          s = j.endSymbol(),
          t = "<div " + q + '-popup title="' + r + "title" + s + '" ' + (n.useContentExp ? 'content-exp="contentExp()" ' : 'content="' + r + "content" + s + '" ') + 'placement="' + r + "placement" + s + '" popup-class="' + r + "popupClass" + s + '" animation="animation" is-open="isOpen"origin-scope="origScope" style="visibility: hidden; display: block; top: -9999px; left: -9999px;"></div>';return { compile: function compile(a, b) {
          var c = f(t);return function (a, b, d, f) {
            function j() {
              M.isOpen ? q() : m();
            }function m() {
              (!L || a.$eval(d[k + "Enable"])) && (u(), x(), M.popupDelay ? G || (G = g(r, M.popupDelay, !1)) : r());
            }function q() {
              s(), M.popupCloseDelay ? H || (H = g(t, M.popupCloseDelay, !1)) : t();
            }function r() {
              return s(), u(), M.content ? (v(), void M.$evalAsync(function () {
                M.isOpen = !0, y(!0), R();
              })) : angular.noop;
            }function s() {
              G && (g.cancel(G), G = null), I && (g.cancel(I), I = null);
            }function t() {
              M && M.$evalAsync(function () {
                M && (M.isOpen = !1, y(!1), M.animation ? F || (F = g(w, 150, !1)) : w());
              });
            }function u() {
              H && (g.cancel(H), H = null), F && (g.cancel(F), F = null);
            }function v() {
              D || (E = M.$new(), D = c(E, function (a) {
                J ? h.find("body").append(a) : b.after(a);
              }), z());
            }function w() {
              s(), u(), A(), D && (D.remove(), D = null), E && (E.$destroy(), E = null);
            }function x() {
              M.title = d[k + "Title"], P ? M.content = P(a) : M.content = d[e], M.popupClass = d[k + "Class"], M.placement = angular.isDefined(d[k + "Placement"]) ? d[k + "Placement"] : n.placement;var b = parseInt(d[k + "PopupDelay"], 10),
                  c = parseInt(d[k + "PopupCloseDelay"], 10);M.popupDelay = isNaN(b) ? n.popupDelay : b, M.popupCloseDelay = isNaN(c) ? n.popupCloseDelay : c;
            }function y(b) {
              O && angular.isFunction(O.assign) && O.assign(a, b);
            }function z() {
              Q.length = 0, P ? (Q.push(a.$watch(P, function (a) {
                M.content = a, !a && M.isOpen && t();
              })), Q.push(E.$watch(function () {
                N || (N = !0, E.$$postDigest(function () {
                  N = !1, M && M.isOpen && R();
                }));
              }))) : Q.push(d.$observe(e, function (a) {
                M.content = a, !a && M.isOpen ? t() : R();
              })), Q.push(d.$observe(k + "Title", function (a) {
                M.title = a, M.isOpen && R();
              })), Q.push(d.$observe(k + "Placement", function (a) {
                M.placement = a ? a : n.placement, M.isOpen && R();
              }));
            }function A() {
              Q.length && (angular.forEach(Q, function (a) {
                a();
              }), Q.length = 0);
            }function B(a) {
              M && M.isOpen && D && (b[0].contains(a.target) || D[0].contains(a.target) || q());
            }function C() {
              var a = d[k + "Trigger"];S(), K = p(a), "none" !== K.show && K.show.forEach(function (a, c) {
                "outsideClick" === a ? (b.on("click", j), h.on("click", B)) : a === K.hide[c] ? b.on(a, j) : a && (b.on(a, m), b.on(K.hide[c], q)), b.on("keypress", function (a) {
                  27 === a.which && q();
                });
              });
            }var D,
                E,
                F,
                G,
                H,
                I,
                J = angular.isDefined(n.appendToBody) ? n.appendToBody : !1,
                K = p(void 0),
                L = angular.isDefined(d[k + "Enable"]),
                M = a.$new(!0),
                N = !1,
                O = angular.isDefined(d[k + "IsOpen"]) ? l(d[k + "IsOpen"]) : !1,
                P = n.useContentExp ? l(d[e]) : !1,
                Q = [],
                R = function R() {
              D && D.html() && (I || (I = g(function () {
                D.css({ top: 0, left: 0 });var a = i.positionElements(b, D, M.placement, J);D.css({ top: a.top + "px", left: a.left + "px", visibility: "visible" }), n.placementClassPrefix && D.removeClass("top bottom left right"), D.removeClass(n.placementClassPrefix + "top " + n.placementClassPrefix + "top-left " + n.placementClassPrefix + "top-right " + n.placementClassPrefix + "bottom " + n.placementClassPrefix + "bottom-left " + n.placementClassPrefix + "bottom-right " + n.placementClassPrefix + "left " + n.placementClassPrefix + "left-top " + n.placementClassPrefix + "left-bottom " + n.placementClassPrefix + "right " + n.placementClassPrefix + "right-top " + n.placementClassPrefix + "right-bottom");var c = a.placement.split("-");D.addClass(c[0] + " " + n.placementClassPrefix + a.placement), i.positionArrow(D, a.placement), I = null;
              }, 0, !1)));
            };M.origScope = a, M.isOpen = !1, o.add(M, { close: t }), M.contentExp = function () {
              return M.content;
            }, d.$observe("disabled", function (a) {
              a && s(), a && M.isOpen && t();
            }), O && a.$watch(O, function (a) {
              M && !a === M.isOpen && j();
            });var S = function S() {
              K.show.forEach(function (a) {
                "outsideClick" === a ? b.off("click", j) : (b.off(a, m), b.off(a, j));
              }), K.hide.forEach(function (a) {
                "outsideClick" === a ? h.off("click", B) : b.off(a, q);
              });
            };C();var T = a.$eval(d[k + "Animation"]);M.animation = angular.isDefined(T) ? !!T : n.animation;var U,
                V = k + "AppendToBody";U = V in d && void 0 === d[V] ? !0 : a.$eval(d[V]), J = angular.isDefined(U) ? U : J, J && a.$on("$locationChangeSuccess", function () {
              M.isOpen && t();
            }), a.$on("$destroy", function () {
              S(), w(), o.remove(M), M = null;
            });
          };
        } };
    };
  }];
}).directive("uibTooltipTemplateTransclude", ["$animate", "$sce", "$compile", "$templateRequest", function (a, b, c, d) {
  return { link: function link(e, f, g) {
      var h,
          i,
          j,
          k = e.$eval(g.tooltipTemplateTranscludeScope),
          l = 0,
          m = function m() {
        i && (i.remove(), i = null), h && (h.$destroy(), h = null), j && (a.leave(j).then(function () {
          i = null;
        }), i = j, j = null);
      };e.$watch(b.parseAsResourceUrl(g.uibTooltipTemplateTransclude), function (b) {
        var g = ++l;b ? (d(b, !0).then(function (d) {
          if (g === l) {
            var e = k.$new(),
                i = d,
                n = c(i)(e, function (b) {
              m(), a.enter(b, f);
            });h = e, j = n, h.$emit("$includeContentLoaded", b);
          }
        }, function () {
          g === l && (m(), e.$emit("$includeContentError", b));
        }), e.$emit("$includeContentRequested", b)) : m();
      }), e.$on("$destroy", m);
    } };
}]).directive("uibTooltipClasses", ["$uibPosition", function (a) {
  return { restrict: "A", link: function link(b, c, d) {
      if (b.placement) {
        var e = a.parsePlacement(b.placement);c.addClass(e[0]);
      } else c.addClass("top");b.popupClass && c.addClass(b.popupClass), b.animation() && c.addClass(d.tooltipAnimationClass);
    } };
}]).directive("uibTooltipPopup", function () {
  return { replace: !0, scope: { content: "@", placement: "@", popupClass: "@", animation: "&", isOpen: "&"
    }, templateUrl: "uib/template/tooltip/tooltip-popup.html" };
}).directive("uibTooltip", ["$uibTooltip", function (a) {
  return a("uibTooltip", "tooltip", "mouseenter");
}]).directive("uibTooltipTemplatePopup", function () {
  return { replace: !0, scope: { contentExp: "&", placement: "@", popupClass: "@", animation: "&", isOpen: "&", originScope: "&" }, templateUrl: "uib/template/tooltip/tooltip-template-popup.html" };
}).directive("uibTooltipTemplate", ["$uibTooltip", function (a) {
  return a("uibTooltipTemplate", "tooltip", "mouseenter", { useContentExp: !0 });
}]).directive("uibTooltipHtmlPopup", function () {
  return { replace: !0, scope: { contentExp: "&", placement: "@", popupClass: "@", animation: "&", isOpen: "&" }, templateUrl: "uib/template/tooltip/tooltip-html-popup.html" };
}).directive("uibTooltipHtml", ["$uibTooltip", function (a) {
  return a("uibTooltipHtml", "tooltip", "mouseenter", { useContentExp: !0 });
}]), angular.module("ui.bootstrap.popover", ["ui.bootstrap.tooltip"]).directive("uibPopoverTemplatePopup", function () {
  return { replace: !0, scope: { title: "@", contentExp: "&", placement: "@", popupClass: "@", animation: "&", isOpen: "&", originScope: "&" }, templateUrl: "uib/template/popover/popover-template.html" };
}).directive("uibPopoverTemplate", ["$uibTooltip", function (a) {
  return a("uibPopoverTemplate", "popover", "click", { useContentExp: !0 });
}]).directive("uibPopoverHtmlPopup", function () {
  return { replace: !0, scope: { contentExp: "&", title: "@", placement: "@", popupClass: "@", animation: "&", isOpen: "&" }, templateUrl: "uib/template/popover/popover-html.html" };
}).directive("uibPopoverHtml", ["$uibTooltip", function (a) {
  return a("uibPopoverHtml", "popover", "click", { useContentExp: !0 });
}]).directive("uibPopoverPopup", function () {
  return { replace: !0, scope: { title: "@", content: "@", placement: "@", popupClass: "@", animation: "&", isOpen: "&" }, templateUrl: "uib/template/popover/popover.html" };
}).directive("uibPopover", ["$uibTooltip", function (a) {
  return a("uibPopover", "popover", "click");
}]), angular.module("ui.bootstrap.progressbar", []).constant("uibProgressConfig", { animate: !0, max: 100 }).controller("UibProgressController", ["$scope", "$attrs", "uibProgressConfig", function (a, b, c) {
  var d = this,
      e = angular.isDefined(b.animate) ? a.$parent.$eval(b.animate) : c.animate;this.bars = [], a.max = angular.isDefined(a.max) ? a.max : c.max, this.addBar = function (b, c, f) {
    e || c.css({ transition: "none" }), this.bars.push(b), b.max = a.max, b.title = f && angular.isDefined(f.title) ? f.title : "progressbar", b.$watch("value", function (a) {
      b.recalculatePercentage();
    }), b.recalculatePercentage = function () {
      var a = d.bars.reduce(function (a, b) {
        return b.percent = +(100 * b.value / b.max).toFixed(2), a + b.percent;
      }, 0);a > 100 && (b.percent -= a - 100);
    }, b.$on("$destroy", function () {
      c = null, d.removeBar(b);
    });
  }, this.removeBar = function (a) {
    this.bars.splice(this.bars.indexOf(a), 1), this.bars.forEach(function (a) {
      a.recalculatePercentage();
    });
  }, a.$watch("max", function (b) {
    d.bars.forEach(function (b) {
      b.max = a.max, b.recalculatePercentage();
    });
  });
}]).directive("uibProgress", function () {
  return { replace: !0, transclude: !0, controller: "UibProgressController", require: "uibProgress", scope: { max: "=?" }, templateUrl: "uib/template/progressbar/progress.html" };
}).directive("uibBar", function () {
  return { replace: !0, transclude: !0, require: "^uibProgress", scope: { value: "=", type: "@" }, templateUrl: "uib/template/progressbar/bar.html", link: function link(a, b, c, d) {
      d.addBar(a, b, c);
    } };
}).directive("uibProgressbar", function () {
  return { replace: !0, transclude: !0, controller: "UibProgressController", scope: { value: "=", max: "=?", type: "@" }, templateUrl: "uib/template/progressbar/progressbar.html", link: function link(a, b, c, d) {
      d.addBar(a, angular.element(b.children()[0]), { title: c.title });
    } };
}), angular.module("ui.bootstrap.rating", []).constant("uibRatingConfig", { max: 5, stateOn: null, stateOff: null, titles: ["one", "two", "three", "four", "five"] }).controller("UibRatingController", ["$scope", "$attrs", "uibRatingConfig", function (a, b, c) {
  var d = { $setViewValue: angular.noop };this.init = function (e) {
    d = e, d.$render = this.render, d.$formatters.push(function (a) {
      return angular.isNumber(a) && a << 0 !== a && (a = Math.round(a)), a;
    }), this.stateOn = angular.isDefined(b.stateOn) ? a.$parent.$eval(b.stateOn) : c.stateOn, this.stateOff = angular.isDefined(b.stateOff) ? a.$parent.$eval(b.stateOff) : c.stateOff;var f = angular.isDefined(b.titles) ? a.$parent.$eval(b.titles) : c.titles;this.titles = angular.isArray(f) && f.length > 0 ? f : c.titles;var g = angular.isDefined(b.ratingStates) ? a.$parent.$eval(b.ratingStates) : new Array(angular.isDefined(b.max) ? a.$parent.$eval(b.max) : c.max);a.range = this.buildTemplateObjects(g);
  }, this.buildTemplateObjects = function (a) {
    for (var b = 0, c = a.length; c > b; b++) {
      a[b] = angular.extend({ index: b }, { stateOn: this.stateOn, stateOff: this.stateOff, title: this.getTitle(b) }, a[b]);
    }return a;
  }, this.getTitle = function (a) {
    return a >= this.titles.length ? a + 1 : this.titles[a];
  }, a.rate = function (b) {
    !a.readonly && b >= 0 && b <= a.range.length && (d.$setViewValue(d.$viewValue === b ? 0 : b), d.$render());
  }, a.enter = function (b) {
    a.readonly || (a.value = b), a.onHover({ value: b });
  }, a.reset = function () {
    a.value = d.$viewValue, a.onLeave();
  }, a.onKeydown = function (b) {
    /(37|38|39|40)/.test(b.which) && (b.preventDefault(), b.stopPropagation(), a.rate(a.value + (38 === b.which || 39 === b.which ? 1 : -1)));
  }, this.render = function () {
    a.value = d.$viewValue;
  };
}]).directive("uibRating", function () {
  return { require: ["uibRating", "ngModel"], scope: { readonly: "=?", onHover: "&", onLeave: "&" }, controller: "UibRatingController", templateUrl: "uib/template/rating/rating.html", replace: !0, link: function link(a, b, c, d) {
      var e = d[0],
          f = d[1];e.init(f);
    } };
}), angular.module("ui.bootstrap.tabs", []).controller("UibTabsetController", ["$scope", function (a) {
  var b = this,
      c = b.tabs = a.tabs = [];b.select = function (a) {
    angular.forEach(c, function (b) {
      b.active && b !== a && (b.active = !1, b.onDeselect(), a.selectCalled = !1);
    }), a.active = !0, a.selectCalled || (a.onSelect(), a.selectCalled = !0);
  }, b.addTab = function (a) {
    c.push(a), 1 === c.length && a.active !== !1 ? a.active = !0 : a.active ? b.select(a) : a.active = !1;
  }, b.removeTab = function (a) {
    var e = c.indexOf(a);if (a.active && c.length > 1 && !d) {
      var f = e === c.length - 1 ? e - 1 : e + 1;b.select(c[f]);
    }c.splice(e, 1);
  };var d;a.$on("$destroy", function () {
    d = !0;
  });
}]).directive("uibTabset", function () {
  return { transclude: !0, replace: !0, scope: { type: "@" }, controller: "UibTabsetController", templateUrl: "uib/template/tabs/tabset.html", link: function link(a, b, c) {
      a.vertical = angular.isDefined(c.vertical) ? a.$parent.$eval(c.vertical) : !1, a.justified = angular.isDefined(c.justified) ? a.$parent.$eval(c.justified) : !1;
    } };
}).directive("uibTab", ["$parse", function (a) {
  return { require: "^uibTabset", replace: !0, templateUrl: "uib/template/tabs/tab.html", transclude: !0, scope: { active: "=?", heading: "@", onSelect: "&select", onDeselect: "&deselect" }, controller: function controller() {}, controllerAs: "tab", link: function link(b, c, d, e, f) {
      b.$watch("active", function (a) {
        a && e.select(b);
      }), b.disabled = !1, d.disable && b.$parent.$watch(a(d.disable), function (a) {
        b.disabled = !!a;
      }), b.select = function () {
        b.disabled || (b.active = !0);
      }, e.addTab(b), b.$on("$destroy", function () {
        e.removeTab(b);
      }), b.$transcludeFn = f;
    } };
}]).directive("uibTabHeadingTransclude", function () {
  return { restrict: "A", require: "^uibTab", link: function link(a, b) {
      a.$watch("headingElement", function (a) {
        a && (b.html(""), b.append(a));
      });
    } };
}).directive("uibTabContentTransclude", function () {
  function a(a) {
    return a.tagName && (a.hasAttribute("uib-tab-heading") || a.hasAttribute("data-uib-tab-heading") || a.hasAttribute("x-uib-tab-heading") || "uib-tab-heading" === a.tagName.toLowerCase() || "data-uib-tab-heading" === a.tagName.toLowerCase() || "x-uib-tab-heading" === a.tagName.toLowerCase());
  }return { restrict: "A", require: "^uibTabset", link: function link(b, c, d) {
      var e = b.$eval(d.uibTabContentTransclude);e.$transcludeFn(e.$parent, function (b) {
        angular.forEach(b, function (b) {
          a(b) ? e.headingElement = b : c.append(b);
        });
      });
    } };
}), angular.module("ui.bootstrap.timepicker", []).constant("uibTimepickerConfig", { hourStep: 1, minuteStep: 1, secondStep: 1, showMeridian: !0, showSeconds: !1, meridians: null, readonlyInput: !1, mousewheel: !0, arrowkeys: !0, showSpinners: !0, templateUrl: "uib/template/timepicker/timepicker.html" }).controller("UibTimepickerController", ["$scope", "$element", "$attrs", "$parse", "$log", "$locale", "uibTimepickerConfig", function (a, b, c, d, e, f, g) {
  function h() {
    var b = +a.hours,
        c = a.showMeridian ? b > 0 && 13 > b : b >= 0 && 24 > b;return c ? (a.showMeridian && (12 === b && (b = 0), a.meridian === u[1] && (b += 12)), b) : void 0;
  }function i() {
    var b = +a.minutes;return b >= 0 && 60 > b ? b : void 0;
  }function j() {
    var b = +a.seconds;return b >= 0 && 60 > b ? b : void 0;
  }function k(a) {
    return null === a ? "" : angular.isDefined(a) && a.toString().length < 2 ? "0" + a : a.toString();
  }function l(a) {
    m(), t.$setViewValue(new Date(r)), n(a);
  }function m() {
    t.$setValidity("time", !0), a.invalidHours = !1, a.invalidMinutes = !1, a.invalidSeconds = !1;
  }function n(b) {
    if (t.$modelValue) {
      var c = r.getHours(),
          d = r.getMinutes(),
          e = r.getSeconds();a.showMeridian && (c = 0 === c || 12 === c ? 12 : c % 12), a.hours = "h" === b ? c : k(c), "m" !== b && (a.minutes = k(d)), a.meridian = r.getHours() < 12 ? u[0] : u[1], "s" !== b && (a.seconds = k(e)), a.meridian = r.getHours() < 12 ? u[0] : u[1];
    } else a.hours = null, a.minutes = null, a.seconds = null, a.meridian = u[0];
  }function o(a) {
    r = q(r, a), l();
  }function p(a, b) {
    return q(a, 60 * b);
  }function q(a, b) {
    var c = new Date(a.getTime() + 1e3 * b),
        d = new Date(a);return d.setHours(c.getHours(), c.getMinutes(), c.getSeconds()), d;
  }var r = new Date(),
      s = [],
      t = { $setViewValue: angular.noop },
      u = angular.isDefined(c.meridians) ? a.$parent.$eval(c.meridians) : g.meridians || f.DATETIME_FORMATS.AMPMS;a.tabindex = angular.isDefined(c.tabindex) ? c.tabindex : 0, b.removeAttr("tabindex"), this.init = function (b, d) {
    t = b, t.$render = this.render, t.$formatters.unshift(function (a) {
      return a ? new Date(a) : null;
    });var e = d.eq(0),
        f = d.eq(1),
        h = d.eq(2),
        i = angular.isDefined(c.mousewheel) ? a.$parent.$eval(c.mousewheel) : g.mousewheel;i && this.setupMousewheelEvents(e, f, h);var j = angular.isDefined(c.arrowkeys) ? a.$parent.$eval(c.arrowkeys) : g.arrowkeys;j && this.setupArrowkeyEvents(e, f, h), a.readonlyInput = angular.isDefined(c.readonlyInput) ? a.$parent.$eval(c.readonlyInput) : g.readonlyInput, this.setupInputEvents(e, f, h);
  };var v = g.hourStep;c.hourStep && s.push(a.$parent.$watch(d(c.hourStep), function (a) {
    v = +a;
  }));var w = g.minuteStep;c.minuteStep && s.push(a.$parent.$watch(d(c.minuteStep), function (a) {
    w = +a;
  }));var x;s.push(a.$parent.$watch(d(c.min), function (a) {
    var b = new Date(a);x = isNaN(b) ? void 0 : b;
  }));var y;s.push(a.$parent.$watch(d(c.max), function (a) {
    var b = new Date(a);y = isNaN(b) ? void 0 : b;
  }));var z = !1;c.ngDisabled && s.push(a.$parent.$watch(d(c.ngDisabled), function (a) {
    z = a;
  })), a.noIncrementHours = function () {
    var a = p(r, 60 * v);return z || a > y || r > a && x > a;
  }, a.noDecrementHours = function () {
    var a = p(r, 60 * -v);return z || x > a || a > r && a > y;
  }, a.noIncrementMinutes = function () {
    var a = p(r, w);return z || a > y || r > a && x > a;
  }, a.noDecrementMinutes = function () {
    var a = p(r, -w);return z || x > a || a > r && a > y;
  }, a.noIncrementSeconds = function () {
    var a = q(r, A);return z || a > y || r > a && x > a;
  }, a.noDecrementSeconds = function () {
    var a = q(r, -A);return z || x > a || a > r && a > y;
  }, a.noToggleMeridian = function () {
    return r.getHours() < 12 ? z || p(r, 720) > y : z || p(r, -720) < x;
  };var A = g.secondStep;c.secondStep && s.push(a.$parent.$watch(d(c.secondStep), function (a) {
    A = +a;
  })), a.showSeconds = g.showSeconds, c.showSeconds && s.push(a.$parent.$watch(d(c.showSeconds), function (b) {
    a.showSeconds = !!b;
  })), a.showMeridian = g.showMeridian, c.showMeridian && s.push(a.$parent.$watch(d(c.showMeridian), function (b) {
    if (a.showMeridian = !!b, t.$error.time) {
      var c = h(),
          d = i();angular.isDefined(c) && angular.isDefined(d) && (r.setHours(c), l());
    } else n();
  })), this.setupMousewheelEvents = function (b, c, d) {
    var e = function e(a) {
      a.originalEvent && (a = a.originalEvent);var b = a.wheelDelta ? a.wheelDelta : -a.deltaY;return a.detail || b > 0;
    };b.bind("mousewheel wheel", function (b) {
      z || a.$apply(e(b) ? a.incrementHours() : a.decrementHours()), b.preventDefault();
    }), c.bind("mousewheel wheel", function (b) {
      z || a.$apply(e(b) ? a.incrementMinutes() : a.decrementMinutes()), b.preventDefault();
    }), d.bind("mousewheel wheel", function (b) {
      z || a.$apply(e(b) ? a.incrementSeconds() : a.decrementSeconds()), b.preventDefault();
    });
  }, this.setupArrowkeyEvents = function (b, c, d) {
    b.bind("keydown", function (b) {
      z || (38 === b.which ? (b.preventDefault(), a.incrementHours(), a.$apply()) : 40 === b.which && (b.preventDefault(), a.decrementHours(), a.$apply()));
    }), c.bind("keydown", function (b) {
      z || (38 === b.which ? (b.preventDefault(), a.incrementMinutes(), a.$apply()) : 40 === b.which && (b.preventDefault(), a.decrementMinutes(), a.$apply()));
    }), d.bind("keydown", function (b) {
      z || (38 === b.which ? (b.preventDefault(), a.incrementSeconds(), a.$apply()) : 40 === b.which && (b.preventDefault(), a.decrementSeconds(), a.$apply()));
    });
  }, this.setupInputEvents = function (b, c, d) {
    if (a.readonlyInput) return a.updateHours = angular.noop, a.updateMinutes = angular.noop, void (a.updateSeconds = angular.noop);var e = function e(b, c, d) {
      t.$setViewValue(null), t.$setValidity("time", !1), angular.isDefined(b) && (a.invalidHours = b), angular.isDefined(c) && (a.invalidMinutes = c), angular.isDefined(d) && (a.invalidSeconds = d);
    };a.updateHours = function () {
      var a = h(),
          b = i();t.$setDirty(), angular.isDefined(a) && angular.isDefined(b) ? (r.setHours(a), r.setMinutes(b), x > r || r > y ? e(!0) : l("h")) : e(!0);
    }, b.bind("blur", function (b) {
      t.$setTouched(), null === a.hours || "" === a.hours ? e(!0) : !a.invalidHours && a.hours < 10 && a.$apply(function () {
        a.hours = k(a.hours);
      });
    }), a.updateMinutes = function () {
      var a = i(),
          b = h();t.$setDirty(), angular.isDefined(a) && angular.isDefined(b) ? (r.setHours(b), r.setMinutes(a), x > r || r > y ? e(void 0, !0) : l("m")) : e(void 0, !0);
    }, c.bind("blur", function (b) {
      t.$setTouched(), null === a.minutes ? e(void 0, !0) : !a.invalidMinutes && a.minutes < 10 && a.$apply(function () {
        a.minutes = k(a.minutes);
      });
    }), a.updateSeconds = function () {
      var a = j();t.$setDirty(), angular.isDefined(a) ? (r.setSeconds(a), l("s")) : e(void 0, void 0, !0);
    }, d.bind("blur", function (b) {
      !a.invalidSeconds && a.seconds < 10 && a.$apply(function () {
        a.seconds = k(a.seconds);
      });
    });
  }, this.render = function () {
    var b = t.$viewValue;isNaN(b) ? (t.$setValidity("time", !1), e.error('Timepicker directive: "ng-model" value must be a Date object, a number of milliseconds since 01.01.1970 or a string representing an RFC2822 or ISO 8601 date.')) : (b && (r = b), x > r || r > y ? (t.$setValidity("time", !1), a.invalidHours = !0, a.invalidMinutes = !0) : m(), n());
  }, a.showSpinners = angular.isDefined(c.showSpinners) ? a.$parent.$eval(c.showSpinners) : g.showSpinners, a.incrementHours = function () {
    a.noIncrementHours() || o(60 * v * 60);
  }, a.decrementHours = function () {
    a.noDecrementHours() || o(60 * -v * 60);
  }, a.incrementMinutes = function () {
    a.noIncrementMinutes() || o(60 * w);
  }, a.decrementMinutes = function () {
    a.noDecrementMinutes() || o(60 * -w);
  }, a.incrementSeconds = function () {
    a.noIncrementSeconds() || o(A);
  }, a.decrementSeconds = function () {
    a.noDecrementSeconds() || o(-A);
  }, a.toggleMeridian = function () {
    var b = i(),
        c = h();a.noToggleMeridian() || (angular.isDefined(b) && angular.isDefined(c) ? o(720 * (r.getHours() < 12 ? 60 : -60)) : a.meridian = a.meridian === u[0] ? u[1] : u[0]);
  }, a.blur = function () {
    t.$setTouched();
  }, a.$on("$destroy", function () {
    for (; s.length;) {
      s.shift()();
    }
  });
}]).directive("uibTimepicker", ["uibTimepickerConfig", function (a) {
  return { require: ["uibTimepicker", "?^ngModel"], controller: "UibTimepickerController", controllerAs: "timepicker", replace: !0, scope: {}, templateUrl: function templateUrl(b, c) {
      return c.templateUrl || a.templateUrl;
    }, link: function link(a, b, c, d) {
      var e = d[0],
          f = d[1];f && e.init(f, b.find("input"));
    } };
}]), angular.module("ui.bootstrap.typeahead", ["ui.bootstrap.debounce", "ui.bootstrap.position"]).factory("uibTypeaheadParser", ["$parse", function (a) {
  var b = /^\s*([\s\S]+?)(?:\s+as\s+([\s\S]+?))?\s+for\s+(?:([\$\w][\$\w\d]*))\s+in\s+([\s\S]+?)$/;return { parse: function parse(c) {
      var d = c.match(b);if (!d) throw new Error('Expected typeahead specification in form of "_modelValue_ (as _label_)? for _item_ in _collection_" but got "' + c + '".');return { itemName: d[3], source: a(d[4]), viewMapper: a(d[2] || d[1]), modelMapper: a(d[1]) };
    } };
}]).controller("UibTypeaheadController", ["$scope", "$element", "$attrs", "$compile", "$parse", "$q", "$timeout", "$document", "$window", "$rootScope", "$$debounce", "$uibPosition", "uibTypeaheadParser", function (a, b, c, d, e, f, g, h, i, j, k, l, m) {
  function n() {
    N.moveInProgress || (N.moveInProgress = !0, N.$digest()), Y();
  }function o() {
    N.position = D ? l.offset(b) : l.position(b), N.position.top += b.prop("offsetHeight");
  }var p,
      q,
      r = [9, 13, 27, 38, 40],
      s = 200,
      t = a.$eval(c.typeaheadMinLength);t || 0 === t || (t = 1);var u = a.$eval(c.typeaheadWaitMs) || 0,
      v = a.$eval(c.typeaheadEditable) !== !1;a.$watch(c.typeaheadEditable, function (a) {
    v = a !== !1;
  });var w,
      x,
      y = e(c.typeaheadLoading).assign || angular.noop,
      z = e(c.typeaheadOnSelect),
      A = angular.isDefined(c.typeaheadSelectOnBlur) ? a.$eval(c.typeaheadSelectOnBlur) : !1,
      B = e(c.typeaheadNoResults).assign || angular.noop,
      C = c.typeaheadInputFormatter ? e(c.typeaheadInputFormatter) : void 0,
      D = c.typeaheadAppendToBody ? a.$eval(c.typeaheadAppendToBody) : !1,
      E = c.typeaheadAppendTo ? a.$eval(c.typeaheadAppendTo) : null,
      F = a.$eval(c.typeaheadFocusFirst) !== !1,
      G = c.typeaheadSelectOnExact ? a.$eval(c.typeaheadSelectOnExact) : !1,
      H = e(c.typeaheadIsOpen).assign || angular.noop,
      I = a.$eval(c.typeaheadShowHint) || !1,
      J = e(c.ngModel),
      K = e(c.ngModel + "($$$p)"),
      L = function L(b, c) {
    return angular.isFunction(J(a)) && q && q.$options && q.$options.getterSetter ? K(b, { $$$p: c }) : J.assign(b, c);
  },
      M = m.parse(c.uibTypeahead),
      N = a.$new(),
      O = a.$on("$destroy", function () {
    N.$destroy();
  });N.$on("$destroy", O);var P = "typeahead-" + N.$id + "-" + Math.floor(1e4 * Math.random());b.attr({ "aria-autocomplete": "list", "aria-expanded": !1, "aria-owns": P });var Q, R;I && (Q = angular.element("<div></div>"), Q.css("position", "relative"), b.after(Q), R = b.clone(), R.attr("placeholder", ""), R.val(""), R.css({ position: "absolute", top: "0px", left: "0px", "border-color": "transparent", "box-shadow": "none", opacity: 1, background: "none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255)", color: "#999" }), b.css({ position: "relative", "vertical-align": "top", "background-color": "transparent" }), Q.append(R), R.after(b));var S = angular.element("<div uib-typeahead-popup></div>");S.attr({ id: P, matches: "matches", active: "activeIdx", select: "select(activeIdx, evt)", "move-in-progress": "moveInProgress", query: "query", position: "position", "assign-is-open": "assignIsOpen(isOpen)", debounce: "debounceUpdate" }), angular.isDefined(c.typeaheadTemplateUrl) && S.attr("template-url", c.typeaheadTemplateUrl), angular.isDefined(c.typeaheadPopupTemplateUrl) && S.attr("popup-template-url", c.typeaheadPopupTemplateUrl);var T = function T() {
    I && R.val("");
  },
      U = function U() {
    N.matches = [], N.activeIdx = -1, b.attr("aria-expanded", !1), T();
  },
      V = function V(a) {
    return P + "-option-" + a;
  };N.$watch("activeIdx", function (a) {
    0 > a ? b.removeAttr("aria-activedescendant") : b.attr("aria-activedescendant", V(a));
  });var W = function W(a, b) {
    return N.matches.length > b && a ? a.toUpperCase() === N.matches[b].label.toUpperCase() : !1;
  },
      X = function X(c, d) {
    var e = { $viewValue: c };y(a, !0), B(a, !1), f.when(M.source(a, e)).then(function (f) {
      var g = c === p.$viewValue;if (g && w) if (f && f.length > 0) {
        N.activeIdx = F ? 0 : -1, B(a, !1), N.matches.length = 0;for (var h = 0; h < f.length; h++) {
          e[M.itemName] = f[h], N.matches.push({ id: V(h), label: M.viewMapper(N, e), model: f[h] });
        }if (N.query = c, o(), b.attr("aria-expanded", !0), G && 1 === N.matches.length && W(c, 0) && (angular.isNumber(N.debounceUpdate) || angular.isObject(N.debounceUpdate) ? k(function () {
          N.select(0, d);
        }, angular.isNumber(N.debounceUpdate) ? N.debounceUpdate : N.debounceUpdate["default"]) : N.select(0, d)), I) {
          var i = N.matches[0].label;c.length > 0 && i.slice(0, c.length).toUpperCase() === c.toUpperCase() ? R.val(c + i.slice(c.length)) : R.val("");
        }
      } else U(), B(a, !0);g && y(a, !1);
    }, function () {
      U(), y(a, !1), B(a, !0);
    });
  };D && (angular.element(i).on("resize", n), h.find("body").on("scroll", n));var Y = k(function () {
    N.matches.length && o(), N.moveInProgress = !1;
  }, s);N.moveInProgress = !1, N.query = void 0;var Z,
      $ = function $(a) {
    Z = g(function () {
      X(a);
    }, u);
  },
      _ = function _() {
    Z && g.cancel(Z);
  };U(), N.assignIsOpen = function (b) {
    H(a, b);
  }, N.select = function (d, e) {
    var f,
        h,
        i = {};x = !0, i[M.itemName] = h = N.matches[d].model, f = M.modelMapper(a, i), L(a, f), p.$setValidity("editable", !0), p.$setValidity("parse", !0), z(a, { $item: h, $model: f, $label: M.viewMapper(a, i), $event: e }), U(), N.$eval(c.typeaheadFocusOnSelect) !== !1 && g(function () {
      b[0].focus();
    }, 0, !1);
  }, b.on("keydown", function (a) {
    if (0 !== N.matches.length && -1 !== r.indexOf(a.which)) {
      if (-1 === N.activeIdx && (9 === a.which || 13 === a.which)) return U(), void N.$digest();a.preventDefault();var b;switch (a.which) {case 9:case 13:
          N.$apply(function () {
            angular.isNumber(N.debounceUpdate) || angular.isObject(N.debounceUpdate) ? k(function () {
              N.select(N.activeIdx, a);
            }, angular.isNumber(N.debounceUpdate) ? N.debounceUpdate : N.debounceUpdate["default"]) : N.select(N.activeIdx, a);
          });break;case 27:
          a.stopPropagation(), U(), N.$digest();break;case 38:
          N.activeIdx = (N.activeIdx > 0 ? N.activeIdx : N.matches.length) - 1, N.$digest(), b = S.find("li")[N.activeIdx], b.parentNode.scrollTop = b.offsetTop;break;case 40:
          N.activeIdx = (N.activeIdx + 1) % N.matches.length, N.$digest(), b = S.find("li")[N.activeIdx], b.parentNode.scrollTop = b.offsetTop;}
    }
  }), b.bind("focus", function (a) {
    w = !0, 0 !== t || p.$viewValue || g(function () {
      X(p.$viewValue, a);
    }, 0);
  }), b.bind("blur", function (a) {
    A && N.matches.length && -1 !== N.activeIdx && !x && (x = !0, N.$apply(function () {
      angular.isObject(N.debounceUpdate) && angular.isNumber(N.debounceUpdate.blur) ? k(function () {
        N.select(N.activeIdx, a);
      }, N.debounceUpdate.blur) : N.select(N.activeIdx, a);
    })), !v && p.$error.editable && (p.$viewValue = "", b.val("")), w = !1, x = !1;
  });var aa = function aa(a) {
    b[0] !== a.target && 3 !== a.which && 0 !== N.matches.length && (U(), j.$$phase || N.$digest());
  };h.on("click", aa), a.$on("$destroy", function () {
    h.off("click", aa), (D || E) && ba.remove(), D && (angular.element(i).off("resize", n), h.find("body").off("scroll", n)), S.remove(), I && Q.remove();
  });var ba = d(S)(N);D ? h.find("body").append(ba) : E ? angular.element(E).eq(0).append(ba) : b.after(ba), this.init = function (b, c) {
    p = b, q = c, N.debounceUpdate = p.$options && e(p.$options.debounce)(a), p.$parsers.unshift(function (b) {
      return w = !0, 0 === t || b && b.length >= t ? u > 0 ? (_(), $(b)) : X(b) : (y(a, !1), _(), U()), v ? b : b ? void p.$setValidity("editable", !1) : (p.$setValidity("editable", !0), null);
    }), p.$formatters.push(function (b) {
      var c,
          d,
          e = {};return v || p.$setValidity("editable", !0), C ? (e.$model = b, C(a, e)) : (e[M.itemName] = b, c = M.viewMapper(a, e), e[M.itemName] = void 0, d = M.viewMapper(a, e), c !== d ? c : b);
    });
  };
}]).directive("uibTypeahead", function () {
  return { controller: "UibTypeaheadController", require: ["ngModel", "^?ngModelOptions", "uibTypeahead"], link: function link(a, b, c, d) {
      d[2].init(d[0], d[1]);
    } };
}).directive("uibTypeaheadPopup", ["$$debounce", function (a) {
  return { scope: { matches: "=", query: "=", active: "=", position: "&", moveInProgress: "=", select: "&", assignIsOpen: "&", debounce: "&" }, replace: !0, templateUrl: function templateUrl(a, b) {
      return b.popupTemplateUrl || "uib/template/typeahead/typeahead-popup.html";
    }, link: function link(b, c, d) {
      b.templateUrl = d.templateUrl, b.isOpen = function () {
        var a = b.matches.length > 0;return b.assignIsOpen({ isOpen: a }), a;
      }, b.isActive = function (a) {
        return b.active === a;
      }, b.selectActive = function (a) {
        b.active = a;
      }, b.selectMatch = function (c, d) {
        var e = b.debounce();angular.isNumber(e) || angular.isObject(e) ? a(function () {
          b.select({ activeIdx: c, evt: d });
        }, angular.isNumber(e) ? e : e["default"]) : b.select({ activeIdx: c, evt: d });
      };
    } };
}]).directive("uibTypeaheadMatch", ["$templateRequest", "$compile", "$parse", function (a, b, c) {
  return { scope: { index: "=", match: "=", query: "=" }, link: function link(d, e, f) {
      var g = c(f.templateUrl)(d.$parent) || "uib/template/typeahead/typeahead-match.html";a(g).then(function (a) {
        var c = angular.element(a.trim());e.replaceWith(c), b(c)(d);
      });
    } };
}]).filter("uibTypeaheadHighlight", ["$sce", "$injector", "$log", function (a, b, c) {
  function d(a) {
    return a.replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
  }function e(a) {
    return (/<.*>/g.test(a)
    );
  }var f;return f = b.has("$sanitize"), function (b, g) {
    return !f && e(b) && c.warn("Unsafe use of typeahead please use ngSanitize"), b = g ? ("" + b).replace(new RegExp(d(g), "gi"), "<strong>$&</strong>") : b, f || (b = a.trustAsHtml(b)), b;
  };
}]), angular.module("uib/template/accordion/accordion-group.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/accordion/accordion-group.html", '<div class="panel" ng-class="panelClass || \'panel-default\'">\n  <div class="panel-heading" ng-keypress="toggleOpen($event)">\n    <h4 class="panel-title">\n      <a href tabindex="0" class="accordion-toggle" ng-click="toggleOpen()" uib-accordion-transclude="heading"><span ng-class="{\'text-muted\': isDisabled}">{{heading}}</span></a>\n    </h4>\n  </div>\n  <div class="panel-collapse collapse" uib-collapse="!isOpen">\n	  <div class="panel-body" ng-transclude></div>\n  </div>\n</div>\n');
}]), angular.module("uib/template/accordion/accordion.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/accordion/accordion.html", '<div class="panel-group" ng-transclude></div>');
}]), angular.module("uib/template/alert/alert.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/alert/alert.html", '<div class="alert" ng-class="[\'alert-\' + (type || \'warning\'), closeable ? \'alert-dismissible\' : null]" role="alert">\n    <button ng-show="closeable" type="button" class="close" ng-click="close({$event: $event})">\n        <span aria-hidden="true">&times;</span>\n        <span class="sr-only">Close</span>\n    </button>\n    <div ng-transclude></div>\n</div>\n');
}]), angular.module("uib/template/carousel/carousel.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/carousel/carousel.html", '<div ng-mouseenter="pause()" ng-mouseleave="play()" class="carousel" ng-swipe-right="prev()" ng-swipe-left="next()">\n  <div class="carousel-inner" ng-transclude></div>\n  <a role="button" href class="left carousel-control" ng-click="prev()" ng-show="slides.length > 1">\n    <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>\n    <span class="sr-only">previous</span>\n  </a>\n  <a role="button" href class="right carousel-control" ng-click="next()" ng-show="slides.length > 1">\n    <span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>\n    <span class="sr-only">next</span>\n  </a>\n  <ol class="carousel-indicators" ng-show="slides.length > 1">\n    <li ng-repeat="slide in slides | orderBy:indexOfSlide track by $index" ng-class="{ active: isActive(slide) }" ng-click="select(slide)">\n      <span class="sr-only">slide {{ $index + 1 }} of {{ slides.length }}<span ng-if="isActive(slide)">, currently active</span></span>\n    </li>\n  </ol>\n</div>');
}]), angular.module("uib/template/carousel/slide.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/carousel/slide.html", '<div ng-class="{\n    \'active\': active\n  }" class="item text-center" ng-transclude></div>\n');
}]), angular.module("uib/template/datepicker/datepicker.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/datepicker/datepicker.html", '<div class="uib-datepicker" ng-switch="datepickerMode" role="application" ng-keydown="keydown($event)">\n  <uib-daypicker ng-switch-when="day" tabindex="0"></uib-daypicker>\n  <uib-monthpicker ng-switch-when="month" tabindex="0"></uib-monthpicker>\n  <uib-yearpicker ng-switch-when="year" tabindex="0"></uib-yearpicker>\n</div>');
}]), angular.module("uib/template/datepicker/day.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/datepicker/day.html", '<table class="uib-daypicker" role="grid" aria-labelledby="{{::uniqueId}}-title" aria-activedescendant="{{activeDateId}}">\n  <thead>\n    <tr>\n      <th><button type="button" class="btn btn-default btn-sm pull-left uib-left" ng-click="move(-1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-left"></i></button></th>\n      <th colspan="{{::5 + showWeeks}}"><button id="{{::uniqueId}}-title" role="heading" aria-live="assertive" aria-atomic="true" type="button" class="btn btn-default btn-sm uib-title" ng-click="toggleMode()" ng-disabled="datepickerMode === maxMode" tabindex="-1"><strong>{{title}}</strong></button></th>\n      <th><button type="button" class="btn btn-default btn-sm pull-right uib-right" ng-click="move(1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-right"></i></button></th>\n    </tr>\n    <tr>\n      <th ng-if="showWeeks" class="text-center"></th>\n      <th ng-repeat="label in ::labels track by $index" class="text-center"><small aria-label="{{::label.full}}">{{::label.abbr}}</small></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr class="uib-weeks" ng-repeat="row in rows track by $index">\n      <td ng-if="showWeeks" class="text-center h6"><em>{{ weekNumbers[$index] }}</em></td>\n      <td ng-repeat="dt in row" class="uib-day text-center" role="gridcell"\n        id="{{::dt.uid}}"\n        ng-class="::dt.customClass">\n        <button type="button" class="btn btn-default btn-sm"\n          uib-is-class="\n            \'btn-info\' for selectedDt,\n            \'active\' for activeDt\n            on dt"\n          ng-click="select(dt.date)"\n          ng-disabled="::dt.disabled"\n          tabindex="-1"><span ng-class="::{\'text-muted\': dt.secondary, \'text-info\': dt.current}">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n');
}]), angular.module("uib/template/datepicker/month.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/datepicker/month.html", '<table class="uib-monthpicker" role="grid" aria-labelledby="{{::uniqueId}}-title" aria-activedescendant="{{activeDateId}}">\n  <thead>\n    <tr>\n      <th><button type="button" class="btn btn-default btn-sm pull-left uib-left" ng-click="move(-1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-left"></i></button></th>\n      <th><button id="{{::uniqueId}}-title" role="heading" aria-live="assertive" aria-atomic="true" type="button" class="btn btn-default btn-sm uib-title" ng-click="toggleMode()" ng-disabled="datepickerMode === maxMode" tabindex="-1"><strong>{{title}}</strong></button></th>\n      <th><button type="button" class="btn btn-default btn-sm pull-right uib-right" ng-click="move(1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-right"></i></button></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr class="uib-months" ng-repeat="row in rows track by $index">\n      <td ng-repeat="dt in row" class="uib-month text-center" role="gridcell"\n        id="{{::dt.uid}}"\n        ng-class="::dt.customClass">\n        <button type="button" class="btn btn-default"\n          uib-is-class="\n            \'btn-info\' for selectedDt,\n            \'active\' for activeDt\n            on dt"\n          ng-click="select(dt.date)"\n          ng-disabled="::dt.disabled"\n          tabindex="-1"><span ng-class="::{\'text-info\': dt.current}">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n');
}]), angular.module("uib/template/datepicker/popup.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/datepicker/popup.html", '<div>\n  <ul class="uib-datepicker-popup dropdown-menu" dropdown-nested ng-if="isOpen" ng-style="{top: position.top+\'px\', left: position.left+\'px\'}" ng-keydown="keydown($event)" ng-click="$event.stopPropagation()">\n    <li ng-transclude></li>\n    <li ng-if="showButtonBar" class="uib-button-bar">\n    <span class="btn-group pull-left">\n      <button type="button" class="btn btn-sm btn-info uib-datepicker-current" ng-click="select(\'today\')" ng-disabled="isDisabled(\'today\')">{{ getText(\'current\') }}</button>\n      <button type="button" class="btn btn-sm btn-danger uib-clear" ng-click="select(null)">{{ getText(\'clear\') }}</button>\n    </span>\n      <button type="button" class="btn btn-sm btn-success pull-right uib-close" ng-click="close()">{{ getText(\'close\') }}</button>\n    </li>\n  </ul>\n</div>\n');
}]), angular.module("uib/template/datepicker/year.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/datepicker/year.html", '<table class="uib-yearpicker" role="grid" aria-labelledby="{{::uniqueId}}-title" aria-activedescendant="{{activeDateId}}">\n  <thead>\n    <tr>\n      <th><button type="button" class="btn btn-default btn-sm pull-left uib-left" ng-click="move(-1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-left"></i></button></th>\n      <th colspan="{{::columns - 2}}"><button id="{{::uniqueId}}-title" role="heading" aria-live="assertive" aria-atomic="true" type="button" class="btn btn-default btn-sm uib-title" ng-click="toggleMode()" ng-disabled="datepickerMode === maxMode" tabindex="-1"><strong>{{title}}</strong></button></th>\n      <th><button type="button" class="btn btn-default btn-sm pull-right uib-right" ng-click="move(1)" tabindex="-1"><i class="glyphicon glyphicon-chevron-right"></i></button></th>\n    </tr>\n  </thead>\n  <tbody>\n    <tr class="uib-years" ng-repeat="row in rows track by $index">\n      <td ng-repeat="dt in row" class="uib-year text-center" role="gridcell"\n        id="{{::dt.uid}}"\n        ng-class="::dt.customClass">\n        <button type="button" class="btn btn-default"\n          uib-is-class="\n            \'btn-info\' for selectedDt,\n            \'active\' for activeDt\n            on dt"\n          ng-click="select(dt.date)"\n          ng-disabled="::dt.disabled"\n          tabindex="-1"><span ng-class="::{\'text-info\': dt.current}">{{::dt.label}}</span></button>\n      </td>\n    </tr>\n  </tbody>\n</table>\n');
}]), angular.module("uib/template/modal/backdrop.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/modal/backdrop.html", '<div class="modal-backdrop"\n     uib-modal-animation-class="fade"\n     modal-in-class="in"\n     ng-style="{\'z-index\': 1040 + (index && 1 || 0) + index*10}"\n></div>\n');
}]), angular.module("uib/template/modal/window.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/modal/window.html", '<div modal-render="{{$isRendered}}" tabindex="-1" role="dialog" class="modal"\n    uib-modal-animation-class="fade"\n    modal-in-class="in"\n    ng-style="{\'z-index\': 1050 + index*10, display: \'block\'}">\n    <div class="modal-dialog {{size ? \'modal-\' + size : \'\'}}"><div class="modal-content" uib-modal-transclude></div></div>\n</div>\n');
}]), angular.module("uib/template/pager/pager.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/pager/pager.html", '<ul class="pager">\n  <li ng-class="{disabled: noPrevious()||ngDisabled, previous: align}"><a href ng-click="selectPage(page - 1, $event)">{{::getText(\'previous\')}}</a></li>\n  <li ng-class="{disabled: noNext()||ngDisabled, next: align}"><a href ng-click="selectPage(page + 1, $event)">{{::getText(\'next\')}}</a></li>\n</ul>\n');
}]), angular.module("uib/template/pagination/pagination.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/pagination/pagination.html", '<ul class="pagination">\n  <li ng-if="::boundaryLinks" ng-class="{disabled: noPrevious()||ngDisabled}" class="pagination-first"><a href ng-click="selectPage(1, $event)">{{::getText(\'first\')}}</a></li>\n  <li ng-if="::directionLinks" ng-class="{disabled: noPrevious()||ngDisabled}" class="pagination-prev"><a href ng-click="selectPage(page - 1, $event)">{{::getText(\'previous\')}}</a></li>\n  <li ng-repeat="page in pages track by $index" ng-class="{active: page.active,disabled: ngDisabled&&!page.active}" class="pagination-page"><a href ng-click="selectPage(page.number, $event)">{{page.text}}</a></li>\n  <li ng-if="::directionLinks" ng-class="{disabled: noNext()||ngDisabled}" class="pagination-next"><a href ng-click="selectPage(page + 1, $event)">{{::getText(\'next\')}}</a></li>\n  <li ng-if="::boundaryLinks" ng-class="{disabled: noNext()||ngDisabled}" class="pagination-last"><a href ng-click="selectPage(totalPages, $event)">{{::getText(\'last\')}}</a></li>\n</ul>\n');
}]), angular.module("uib/template/tooltip/tooltip-html-popup.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/tooltip/tooltip-html-popup.html", '<div class="tooltip"\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="tooltip-arrow"></div>\n  <div class="tooltip-inner" ng-bind-html="contentExp()"></div>\n</div>\n');
}]), angular.module("uib/template/tooltip/tooltip-popup.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/tooltip/tooltip-popup.html", '<div class="tooltip"\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="tooltip-arrow"></div>\n  <div class="tooltip-inner" ng-bind="content"></div>\n</div>\n');
}]), angular.module("uib/template/tooltip/tooltip-template-popup.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/tooltip/tooltip-template-popup.html", '<div class="tooltip"\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="tooltip-arrow"></div>\n  <div class="tooltip-inner"\n    uib-tooltip-template-transclude="contentExp()"\n    tooltip-template-transclude-scope="originScope()"></div>\n</div>\n');
}]), angular.module("uib/template/popover/popover-html.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/popover/popover-html.html", '<div class="popover"\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="arrow"></div>\n\n  <div class="popover-inner">\n      <h3 class="popover-title" ng-bind="title" ng-if="title"></h3>\n      <div class="popover-content" ng-bind-html="contentExp()"></div>\n  </div>\n</div>\n');
}]), angular.module("uib/template/popover/popover-template.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/popover/popover-template.html", '<div class="popover"\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="arrow"></div>\n\n  <div class="popover-inner">\n      <h3 class="popover-title" ng-bind="title" ng-if="title"></h3>\n      <div class="popover-content"\n        uib-tooltip-template-transclude="contentExp()"\n        tooltip-template-transclude-scope="originScope()"></div>\n  </div>\n</div>\n');
}]), angular.module("uib/template/popover/popover.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/popover/popover.html", '<div class="popover"\n  tooltip-animation-class="fade"\n  uib-tooltip-classes\n  ng-class="{ in: isOpen() }">\n  <div class="arrow"></div>\n\n  <div class="popover-inner">\n      <h3 class="popover-title" ng-bind="title" ng-if="title"></h3>\n      <div class="popover-content" ng-bind="content"></div>\n  </div>\n</div>\n');
}]), angular.module("uib/template/progressbar/bar.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/progressbar/bar.html", '<div class="progress-bar" ng-class="type && \'progress-bar-\' + type" role="progressbar" aria-valuenow="{{value}}" aria-valuemin="0" aria-valuemax="{{max}}" ng-style="{width: (percent < 100 ? percent : 100) + \'%\'}" aria-valuetext="{{percent | number:0}}%" aria-labelledby="{{::title}}" ng-transclude></div>\n');
}]), angular.module("uib/template/progressbar/progress.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/progressbar/progress.html", '<div class="progress" ng-transclude aria-labelledby="{{::title}}"></div>');
}]), angular.module("uib/template/progressbar/progressbar.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/progressbar/progressbar.html", '<div class="progress">\n  <div class="progress-bar" ng-class="type && \'progress-bar-\' + type" role="progressbar" aria-valuenow="{{value}}" aria-valuemin="0" aria-valuemax="{{max}}" ng-style="{width: (percent < 100 ? percent : 100) + \'%\'}" aria-valuetext="{{percent | number:0}}%" aria-labelledby="{{::title}}" ng-transclude></div>\n</div>\n');
}]), angular.module("uib/template/rating/rating.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/rating/rating.html", '<span ng-mouseleave="reset()" ng-keydown="onKeydown($event)" tabindex="0" role="slider" aria-valuemin="0" aria-valuemax="{{range.length}}" aria-valuenow="{{value}}">\n    <span ng-repeat-start="r in range track by $index" class="sr-only">({{ $index < value ? \'*\' : \' \' }})</span>\n    <i ng-repeat-end ng-mouseenter="enter($index + 1)" ng-click="rate($index + 1)" class="glyphicon" ng-class="$index < value && (r.stateOn || \'glyphicon-star\') || (r.stateOff || \'glyphicon-star-empty\')" ng-attr-title="{{r.title}}" aria-valuetext="{{r.title}}"></i>\n</span>\n');
}]), angular.module("uib/template/tabs/tab.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/tabs/tab.html", '<li ng-class="{active: active, disabled: disabled}" class="uib-tab">\n  <a href ng-click="select()" uib-tab-heading-transclude>{{heading}}</a>\n</li>\n');
}]), angular.module("uib/template/tabs/tabset.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/tabs/tabset.html", '<div>\n  <ul class="nav nav-{{type || \'tabs\'}}" ng-class="{\'nav-stacked\': vertical, \'nav-justified\': justified}" ng-transclude></ul>\n  <div class="tab-content">\n    <div class="tab-pane" \n         ng-repeat="tab in tabs" \n         ng-class="{active: tab.active}"\n         uib-tab-content-transclude="tab">\n    </div>\n  </div>\n</div>\n');
}]), angular.module("uib/template/timepicker/timepicker.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/timepicker/timepicker.html", '<table class="uib-timepicker">\n  <tbody>\n    <tr class="text-center" ng-show="::showSpinners">\n      <td class="uib-increment hours"><a ng-click="incrementHours()" ng-class="{disabled: noIncrementHours()}" class="btn btn-link" ng-disabled="noIncrementHours()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-up"></span></a></td>\n      <td>&nbsp;</td>\n      <td class="uib-increment minutes"><a ng-click="incrementMinutes()" ng-class="{disabled: noIncrementMinutes()}" class="btn btn-link" ng-disabled="noIncrementMinutes()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-up"></span></a></td>\n      <td ng-show="showSeconds">&nbsp;</td>\n      <td ng-show="showSeconds" class="uib-increment seconds"><a ng-click="incrementSeconds()" ng-class="{disabled: noIncrementSeconds()}" class="btn btn-link" ng-disabled="noIncrementSeconds()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-up"></span></a></td>\n      <td ng-show="showMeridian"></td>\n    </tr>\n    <tr>\n      <td class="form-group uib-time hours" ng-class="{\'has-error\': invalidHours}">\n        <input style="width:50px;" type="text" placeholder="HH" ng-model="hours" ng-change="updateHours()" class="form-control text-center" ng-readonly="::readonlyInput" maxlength="2" tabindex="{{::tabindex}}" ng-disabled="noIncrementHours()" ng-blur="blur()">\n      </td>\n      <td class="uib-separator">:</td>\n      <td class="form-group uib-time minutes" ng-class="{\'has-error\': invalidMinutes}">\n        <input style="width:50px;" type="text" placeholder="MM" ng-model="minutes" ng-change="updateMinutes()" class="form-control text-center" ng-readonly="::readonlyInput" maxlength="2" tabindex="{{::tabindex}}" ng-disabled="noIncrementMinutes()" ng-blur="blur()">\n      </td>\n      <td ng-show="showSeconds" class="uib-separator">:</td>\n      <td class="form-group uib-time seconds" ng-class="{\'has-error\': invalidSeconds}" ng-show="showSeconds">\n        <input style="width:50px;" type="text" placeholder="SS" ng-model="seconds" ng-change="updateSeconds()" class="form-control text-center" ng-readonly="readonlyInput" maxlength="2" tabindex="{{::tabindex}}" ng-disabled="noIncrementSeconds()" ng-blur="blur()">\n      </td>\n      <td ng-show="showMeridian" class="uib-time am-pm"><button type="button" ng-class="{disabled: noToggleMeridian()}" class="btn btn-default text-center" ng-click="toggleMeridian()" ng-disabled="noToggleMeridian()" tabindex="{{::tabindex}}">{{meridian}}</button></td>\n    </tr>\n    <tr class="text-center" ng-show="::showSpinners">\n      <td class="uib-decrement hours"><a ng-click="decrementHours()" ng-class="{disabled: noDecrementHours()}" class="btn btn-link" ng-disabled="noDecrementHours()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-down"></span></a></td>\n      <td>&nbsp;</td>\n      <td class="uib-decrement minutes"><a ng-click="decrementMinutes()" ng-class="{disabled: noDecrementMinutes()}" class="btn btn-link" ng-disabled="noDecrementMinutes()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-down"></span></a></td>\n      <td ng-show="showSeconds">&nbsp;</td>\n      <td ng-show="showSeconds" class="uib-decrement seconds"><a ng-click="decrementSeconds()" ng-class="{disabled: noDecrementSeconds()}" class="btn btn-link" ng-disabled="noDecrementSeconds()" tabindex="{{::tabindex}}"><span class="glyphicon glyphicon-chevron-down"></span></a></td>\n      <td ng-show="showMeridian"></td>\n    </tr>\n  </tbody>\n</table>\n');
}]), angular.module("uib/template/typeahead/typeahead-match.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/typeahead/typeahead-match.html", '<a href\n   tabindex="-1"\n   ng-bind-html="match.label | uibTypeaheadHighlight:query"\n   ng-attr-title="{{match.label}}"></a>\n');
}]), angular.module("uib/template/typeahead/typeahead-popup.html", []).run(["$templateCache", function (a) {
  a.put("uib/template/typeahead/typeahead-popup.html", '<ul class="dropdown-menu" ng-show="isOpen() && !moveInProgress" ng-style="{top: position().top+\'px\', left: position().left+\'px\'}" role="listbox" aria-hidden="{{!isOpen()}}">\n    <li ng-repeat="match in matches track by $index" ng-class="{active: isActive($index) }" ng-mouseenter="selectActive($index)" ng-click="selectMatch($index, $event)" role="option" id="{{::match.id}}">\n        <div uib-typeahead-match index="$index" match="match" query="query" template-url="templateUrl"></div>\n    </li>\n</ul>\n');
}]), angular.module("ui.bootstrap.carousel").run(function () {
  !angular.$$csp().noInlineStyle && angular.element(document).find("head").prepend('<style type="text/css">.ng-animate.item:not(.left):not(.right){-webkit-transition:0s ease-in-out left;transition:0s ease-in-out left}</style>');
}), angular.module("ui.bootstrap.datepicker").run(function () {
  !angular.$$csp().noInlineStyle && angular.element(document).find("head").prepend('<style type="text/css">.uib-datepicker .uib-title{width:100%;}.uib-day button,.uib-month button,.uib-year button{min-width:100%;}.uib-datepicker-popup.dropdown-menu{display:block;}.uib-button-bar{padding:10px 9px 2px;}</style>');
}), angular.module("ui.bootstrap.timepicker").run(function () {
  !angular.$$csp().noInlineStyle && angular.element(document).find("head").prepend('<style type="text/css">.uib-time input{width:50px;}</style>');
}), angular.module("ui.bootstrap.typeahead").run(function () {
  !angular.$$csp().noInlineStyle && angular.element(document).find("head").prepend('<style type="text/css">[uib-typeahead-popup].dropdown-menu{display:block;}</style>');
});
/*
 * @license
 * angular-socket-io v0.7.0
 * (c) 2014 Brian Ford http://briantford.com
 * License: MIT
 */
angular.module("btford.socket-io", []).provider("socketFactory", function () {
  "use strict";
  var n = "socket:";this.$get = ["$rootScope", "$timeout", function (t, e) {
    var r = function r(n, t) {
      return t ? function () {
        var r = arguments;e(function () {
          t.apply(n, r);
        }, 0);
      } : angular.noop;
    };return function (e) {
      e = e || {};var o = e.ioSocket || io.connect(),
          c = void 0 === e.prefix ? n : e.prefix,
          u = e.scope || t,
          i = function i(n, t) {
        o.on(n, t.__ng = r(o, t));
      },
          a = function a(n, t) {
        o.once(n, t.__ng = r(o, t));
      },
          s = { on: i, addListener: i, once: a, emit: function emit(n, t, e) {
          var c = arguments.length - 1,
              e = arguments[c];return "function" == typeof e && (e = r(o, e), arguments[c] = e), o.emit.apply(o, arguments);
        }, removeListener: function removeListener(n, t) {
          return t && t.__ng && (arguments[1] = t.__ng), o.removeListener.apply(o, arguments);
        }, removeAllListeners: function removeAllListeners() {
          return o.removeAllListeners.apply(o, arguments);
        }, disconnect: function disconnect(n) {
          return o.disconnect(n);
        }, connect: function connect() {
          return o.connect();
        }, forward: function forward(n, t) {
          n instanceof Array == !1 && (n = [n]), t || (t = u), n.forEach(function (n) {
            var e = c + n,
                u = r(o, function () {
              Array.prototype.unshift.call(arguments, e), t.$broadcast.apply(t, arguments);
            });t.$on("$destroy", function () {
              o.removeListener(n, u);
            }), o.on(n, u);
          });
        } };return s;
    };
  }];
});
//# sourceMappingURL=socket.min.js.map
(function (f) {
  if ((typeof exports === "undefined" ? "undefined" : _typeof(exports)) === "object" && typeof module !== "undefined") {
    module.exports = f();
  } else if (typeof define === "function" && define.amd) {
    define([], f);
  } else {
    var g;if (typeof window !== "undefined") {
      g = window;
    } else if (typeof global !== "undefined") {
      g = global;
    } else if (typeof self !== "undefined") {
      g = self;
    } else {
      g = this;
    }g.io = f();
  }
})(function () {
  var define, module, exports;return function e(t, n, r) {
    function s(o, u) {
      if (!n[o]) {
        if (!t[o]) {
          var a = typeof require == "function" && require;if (!u && a) return a(o, !0);if (i) return i(o, !0);var f = new Error("Cannot find module '" + o + "'");throw f.code = "MODULE_NOT_FOUND", f;
        }var l = n[o] = { exports: {} };t[o][0].call(l.exports, function (e) {
          var n = t[o][1][e];return s(n ? n : e);
        }, l, l.exports, e, t, n, r);
      }return n[o].exports;
    }var i = typeof require == "function" && require;for (var o = 0; o < r.length; o++) {
      s(r[o]);
    }return s;
  }({ 1: [function (_dereq_, module, exports) {
      module.exports = _dereq_("./lib/");
    }, { "./lib/": 2 }], 2: [function (_dereq_, module, exports) {
      module.exports = _dereq_("./socket");module.exports.parser = _dereq_("engine.io-parser");
    }, { "./socket": 3, "engine.io-parser": 19 }], 3: [function (_dereq_, module, exports) {
      (function (global) {
        var transports = _dereq_("./transports");var Emitter = _dereq_("component-emitter");var debug = _dereq_("debug")("engine.io-client:socket");var index = _dereq_("indexof");var parser = _dereq_("engine.io-parser");var parseuri = _dereq_("parseuri");var parsejson = _dereq_("parsejson");var parseqs = _dereq_("parseqs");module.exports = Socket;function noop() {}function Socket(uri, opts) {
          if (!(this instanceof Socket)) return new Socket(uri, opts);opts = opts || {};if (uri && "object" == (typeof uri === "undefined" ? "undefined" : _typeof(uri))) {
            opts = uri;uri = null;
          }if (uri) {
            uri = parseuri(uri);opts.hostname = uri.host;opts.secure = uri.protocol == "https" || uri.protocol == "wss";opts.port = uri.port;if (uri.query) opts.query = uri.query;
          } else if (opts.host) {
            opts.hostname = parseuri(opts.host).host;
          }this.secure = null != opts.secure ? opts.secure : global.location && "https:" == location.protocol;if (opts.hostname && !opts.port) {
            opts.port = this.secure ? "443" : "80";
          }this.agent = opts.agent || false;this.hostname = opts.hostname || (global.location ? location.hostname : "localhost");this.port = opts.port || (global.location && location.port ? location.port : this.secure ? 443 : 80);this.query = opts.query || {};if ("string" == typeof this.query) this.query = parseqs.decode(this.query);this.upgrade = false !== opts.upgrade;this.path = (opts.path || "/engine.io").replace(/\/$/, "") + "/";this.forceJSONP = !!opts.forceJSONP;this.jsonp = false !== opts.jsonp;this.forceBase64 = !!opts.forceBase64;this.enablesXDR = !!opts.enablesXDR;this.timestampParam = opts.timestampParam || "t";this.timestampRequests = opts.timestampRequests;this.transports = opts.transports || ["polling", "websocket"];this.readyState = "";this.writeBuffer = [];this.policyPort = opts.policyPort || 843;this.rememberUpgrade = opts.rememberUpgrade || false;this.binaryType = null;this.onlyBinaryUpgrades = opts.onlyBinaryUpgrades;this.perMessageDeflate = false !== opts.perMessageDeflate ? opts.perMessageDeflate || {} : false;if (true === this.perMessageDeflate) this.perMessageDeflate = {};if (this.perMessageDeflate && null == this.perMessageDeflate.threshold) {
            this.perMessageDeflate.threshold = 1024;
          }this.pfx = opts.pfx || null;this.key = opts.key || null;this.passphrase = opts.passphrase || null;this.cert = opts.cert || null;this.ca = opts.ca || null;this.ciphers = opts.ciphers || null;this.rejectUnauthorized = opts.rejectUnauthorized === undefined ? null : opts.rejectUnauthorized;var freeGlobal = (typeof global === "undefined" ? "undefined" : _typeof(global)) == "object" && global;if (freeGlobal.global === freeGlobal) {
            if (opts.extraHeaders && Object.keys(opts.extraHeaders).length > 0) {
              this.extraHeaders = opts.extraHeaders;
            }
          }this.open();
        }Socket.priorWebsocketSuccess = false;Emitter(Socket.prototype);Socket.protocol = parser.protocol;Socket.Socket = Socket;Socket.Transport = _dereq_("./transport");Socket.transports = _dereq_("./transports");Socket.parser = _dereq_("engine.io-parser");Socket.prototype.createTransport = function (name) {
          debug('creating transport "%s"', name);var query = clone(this.query);query.EIO = parser.protocol;query.transport = name;if (this.id) query.sid = this.id;var transport = new transports[name]({ agent: this.agent, hostname: this.hostname, port: this.port, secure: this.secure, path: this.path, query: query, forceJSONP: this.forceJSONP, jsonp: this.jsonp, forceBase64: this.forceBase64, enablesXDR: this.enablesXDR, timestampRequests: this.timestampRequests, timestampParam: this.timestampParam, policyPort: this.policyPort, socket: this, pfx: this.pfx, key: this.key, passphrase: this.passphrase, cert: this.cert, ca: this.ca, ciphers: this.ciphers, rejectUnauthorized: this.rejectUnauthorized, perMessageDeflate: this.perMessageDeflate, extraHeaders: this.extraHeaders });return transport;
        };function clone(obj) {
          var o = {};for (var i in obj) {
            if (obj.hasOwnProperty(i)) {
              o[i] = obj[i];
            }
          }return o;
        }Socket.prototype.open = function () {
          var transport;if (this.rememberUpgrade && Socket.priorWebsocketSuccess && this.transports.indexOf("websocket") != -1) {
            transport = "websocket";
          } else if (0 === this.transports.length) {
            var self = this;setTimeout(function () {
              self.emit("error", "No transports available");
            }, 0);return;
          } else {
            transport = this.transports[0];
          }this.readyState = "opening";try {
            transport = this.createTransport(transport);
          } catch (e) {
            this.transports.shift();this.open();return;
          }transport.open();this.setTransport(transport);
        };Socket.prototype.setTransport = function (transport) {
          debug("setting transport %s", transport.name);var self = this;if (this.transport) {
            debug("clearing existing transport %s", this.transport.name);this.transport.removeAllListeners();
          }this.transport = transport;transport.on("drain", function () {
            self.onDrain();
          }).on("packet", function (packet) {
            self.onPacket(packet);
          }).on("error", function (e) {
            self.onError(e);
          }).on("close", function () {
            self.onClose("transport close");
          });
        };Socket.prototype.probe = function (name) {
          debug('probing transport "%s"', name);var transport = this.createTransport(name, { probe: 1 }),
              failed = false,
              self = this;Socket.priorWebsocketSuccess = false;function onTransportOpen() {
            if (self.onlyBinaryUpgrades) {
              var upgradeLosesBinary = !this.supportsBinary && self.transport.supportsBinary;failed = failed || upgradeLosesBinary;
            }if (failed) return;debug('probe transport "%s" opened', name);transport.send([{ type: "ping", data: "probe" }]);transport.once("packet", function (msg) {
              if (failed) return;if ("pong" == msg.type && "probe" == msg.data) {
                debug('probe transport "%s" pong', name);self.upgrading = true;self.emit("upgrading", transport);if (!transport) return;Socket.priorWebsocketSuccess = "websocket" == transport.name;debug('pausing current transport "%s"', self.transport.name);self.transport.pause(function () {
                  if (failed) return;if ("closed" == self.readyState) return;debug("changing transport and sending upgrade packet");cleanup();self.setTransport(transport);transport.send([{ type: "upgrade" }]);self.emit("upgrade", transport);transport = null;self.upgrading = false;self.flush();
                });
              } else {
                debug('probe transport "%s" failed', name);var err = new Error("probe error");err.transport = transport.name;self.emit("upgradeError", err);
              }
            });
          }function freezeTransport() {
            if (failed) return;failed = true;cleanup();transport.close();transport = null;
          }function onerror(err) {
            var error = new Error("probe error: " + err);error.transport = transport.name;freezeTransport();debug('probe transport "%s" failed because of error: %s', name, err);self.emit("upgradeError", error);
          }function onTransportClose() {
            onerror("transport closed");
          }function onclose() {
            onerror("socket closed");
          }function onupgrade(to) {
            if (transport && to.name != transport.name) {
              debug('"%s" works - aborting "%s"', to.name, transport.name);freezeTransport();
            }
          }function cleanup() {
            transport.removeListener("open", onTransportOpen);transport.removeListener("error", onerror);transport.removeListener("close", onTransportClose);self.removeListener("close", onclose);self.removeListener("upgrading", onupgrade);
          }transport.once("open", onTransportOpen);transport.once("error", onerror);transport.once("close", onTransportClose);this.once("close", onclose);this.once("upgrading", onupgrade);transport.open();
        };Socket.prototype.onOpen = function () {
          debug("socket open");this.readyState = "open";Socket.priorWebsocketSuccess = "websocket" == this.transport.name;this.emit("open");this.flush();if ("open" == this.readyState && this.upgrade && this.transport.pause) {
            debug("starting upgrade probes");for (var i = 0, l = this.upgrades.length; i < l; i++) {
              this.probe(this.upgrades[i]);
            }
          }
        };Socket.prototype.onPacket = function (packet) {
          if ("opening" == this.readyState || "open" == this.readyState) {
            debug('socket receive: type "%s", data "%s"', packet.type, packet.data);this.emit("packet", packet);this.emit("heartbeat");switch (packet.type) {case "open":
                this.onHandshake(parsejson(packet.data));break;case "pong":
                this.setPing();this.emit("pong");break;case "error":
                var err = new Error("server error");err.code = packet.data;this.onError(err);break;case "message":
                this.emit("data", packet.data);this.emit("message", packet.data);break;}
          } else {
            debug('packet received with socket readyState "%s"', this.readyState);
          }
        };Socket.prototype.onHandshake = function (data) {
          this.emit("handshake", data);this.id = data.sid;this.transport.query.sid = data.sid;this.upgrades = this.filterUpgrades(data.upgrades);this.pingInterval = data.pingInterval;this.pingTimeout = data.pingTimeout;this.onOpen();if ("closed" == this.readyState) return;this.setPing();this.removeListener("heartbeat", this.onHeartbeat);this.on("heartbeat", this.onHeartbeat);
        };Socket.prototype.onHeartbeat = function (timeout) {
          clearTimeout(this.pingTimeoutTimer);var self = this;self.pingTimeoutTimer = setTimeout(function () {
            if ("closed" == self.readyState) return;self.onClose("ping timeout");
          }, timeout || self.pingInterval + self.pingTimeout);
        };Socket.prototype.setPing = function () {
          var self = this;clearTimeout(self.pingIntervalTimer);self.pingIntervalTimer = setTimeout(function () {
            debug("writing ping packet - expecting pong within %sms", self.pingTimeout);self.ping();self.onHeartbeat(self.pingTimeout);
          }, self.pingInterval);
        };Socket.prototype.ping = function () {
          var self = this;this.sendPacket("ping", function () {
            self.emit("ping");
          });
        };Socket.prototype.onDrain = function () {
          this.writeBuffer.splice(0, this.prevBufferLen);this.prevBufferLen = 0;if (0 === this.writeBuffer.length) {
            this.emit("drain");
          } else {
            this.flush();
          }
        };Socket.prototype.flush = function () {
          if ("closed" != this.readyState && this.transport.writable && !this.upgrading && this.writeBuffer.length) {
            debug("flushing %d packets in socket", this.writeBuffer.length);this.transport.send(this.writeBuffer);this.prevBufferLen = this.writeBuffer.length;this.emit("flush");
          }
        };Socket.prototype.write = Socket.prototype.send = function (msg, options, fn) {
          this.sendPacket("message", msg, options, fn);return this;
        };Socket.prototype.sendPacket = function (type, data, options, fn) {
          if ("function" == typeof data) {
            fn = data;data = undefined;
          }if ("function" == typeof options) {
            fn = options;options = null;
          }if ("closing" == this.readyState || "closed" == this.readyState) {
            return;
          }options = options || {};options.compress = false !== options.compress;var packet = { type: type, data: data, options: options };this.emit("packetCreate", packet);this.writeBuffer.push(packet);if (fn) this.once("flush", fn);this.flush();
        };Socket.prototype.close = function () {
          if ("opening" == this.readyState || "open" == this.readyState) {
            this.readyState = "closing";var self = this;if (this.writeBuffer.length) {
              this.once("drain", function () {
                if (this.upgrading) {
                  waitForUpgrade();
                } else {
                  close();
                }
              });
            } else if (this.upgrading) {
              waitForUpgrade();
            } else {
              close();
            }
          }function close() {
            self.onClose("forced close");debug("socket closing - telling transport to close");self.transport.close();
          }function cleanupAndClose() {
            self.removeListener("upgrade", cleanupAndClose);self.removeListener("upgradeError", cleanupAndClose);close();
          }function waitForUpgrade() {
            self.once("upgrade", cleanupAndClose);self.once("upgradeError", cleanupAndClose);
          }return this;
        };Socket.prototype.onError = function (err) {
          debug("socket error %j", err);Socket.priorWebsocketSuccess = false;this.emit("error", err);this.onClose("transport error", err);
        };Socket.prototype.onClose = function (reason, desc) {
          if ("opening" == this.readyState || "open" == this.readyState || "closing" == this.readyState) {
            debug('socket close with reason: "%s"', reason);var self = this;clearTimeout(this.pingIntervalTimer);clearTimeout(this.pingTimeoutTimer);this.transport.removeAllListeners("close");this.transport.close();this.transport.removeAllListeners();this.readyState = "closed";this.id = null;this.emit("close", reason, desc);self.writeBuffer = [];self.prevBufferLen = 0;
          }
        };Socket.prototype.filterUpgrades = function (upgrades) {
          var filteredUpgrades = [];for (var i = 0, j = upgrades.length; i < j; i++) {
            if (~index(this.transports, upgrades[i])) filteredUpgrades.push(upgrades[i]);
          }return filteredUpgrades;
        };
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { "./transport": 4, "./transports": 5, "component-emitter": 15, debug: 17, "engine.io-parser": 19, indexof: 23, parsejson: 26, parseqs: 27, parseuri: 28 }], 4: [function (_dereq_, module, exports) {
      var parser = _dereq_("engine.io-parser");var Emitter = _dereq_("component-emitter");module.exports = Transport;function Transport(opts) {
        this.path = opts.path;this.hostname = opts.hostname;this.port = opts.port;this.secure = opts.secure;this.query = opts.query;this.timestampParam = opts.timestampParam;this.timestampRequests = opts.timestampRequests;this.readyState = "";this.agent = opts.agent || false;this.socket = opts.socket;this.enablesXDR = opts.enablesXDR;this.pfx = opts.pfx;this.key = opts.key;this.passphrase = opts.passphrase;this.cert = opts.cert;this.ca = opts.ca;this.ciphers = opts.ciphers;this.rejectUnauthorized = opts.rejectUnauthorized;this.extraHeaders = opts.extraHeaders;
      }Emitter(Transport.prototype);Transport.prototype.onError = function (msg, desc) {
        var err = new Error(msg);err.type = "TransportError";err.description = desc;this.emit("error", err);return this;
      };Transport.prototype.open = function () {
        if ("closed" == this.readyState || "" == this.readyState) {
          this.readyState = "opening";this.doOpen();
        }return this;
      };Transport.prototype.close = function () {
        if ("opening" == this.readyState || "open" == this.readyState) {
          this.doClose();this.onClose();
        }return this;
      };Transport.prototype.send = function (packets) {
        if ("open" == this.readyState) {
          this.write(packets);
        } else {
          throw new Error("Transport not open");
        }
      };Transport.prototype.onOpen = function () {
        this.readyState = "open";this.writable = true;this.emit("open");
      };Transport.prototype.onData = function (data) {
        var packet = parser.decodePacket(data, this.socket.binaryType);this.onPacket(packet);
      };Transport.prototype.onPacket = function (packet) {
        this.emit("packet", packet);
      };Transport.prototype.onClose = function () {
        this.readyState = "closed";this.emit("close");
      };
    }, { "component-emitter": 15, "engine.io-parser": 19 }], 5: [function (_dereq_, module, exports) {
      (function (global) {
        var XMLHttpRequest = _dereq_("xmlhttprequest-ssl");var XHR = _dereq_("./polling-xhr");var JSONP = _dereq_("./polling-jsonp");var websocket = _dereq_("./websocket");exports.polling = polling;exports.websocket = websocket;function polling(opts) {
          var xhr;var xd = false;var xs = false;var jsonp = false !== opts.jsonp;if (global.location) {
            var isSSL = "https:" == location.protocol;var port = location.port;if (!port) {
              port = isSSL ? 443 : 80;
            }xd = opts.hostname != location.hostname || port != opts.port;xs = opts.secure != isSSL;
          }opts.xdomain = xd;opts.xscheme = xs;xhr = new XMLHttpRequest(opts);if ("open" in xhr && !opts.forceJSONP) {
            return new XHR(opts);
          } else {
            if (!jsonp) throw new Error("JSONP disabled");return new JSONP(opts);
          }
        }
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { "./polling-jsonp": 6, "./polling-xhr": 7, "./websocket": 9, "xmlhttprequest-ssl": 10 }], 6: [function (_dereq_, module, exports) {
      (function (global) {
        var Polling = _dereq_("./polling");var inherit = _dereq_("component-inherit");module.exports = JSONPPolling;var rNewline = /\n/g;var rEscapedNewline = /\\n/g;var callbacks;var index = 0;function empty() {}function JSONPPolling(opts) {
          Polling.call(this, opts);this.query = this.query || {};if (!callbacks) {
            if (!global.___eio) global.___eio = [];callbacks = global.___eio;
          }this.index = callbacks.length;var self = this;callbacks.push(function (msg) {
            self.onData(msg);
          });this.query.j = this.index;if (global.document && global.addEventListener) {
            global.addEventListener("beforeunload", function () {
              if (self.script) self.script.onerror = empty;
            }, false);
          }
        }inherit(JSONPPolling, Polling);JSONPPolling.prototype.supportsBinary = false;JSONPPolling.prototype.doClose = function () {
          if (this.script) {
            this.script.parentNode.removeChild(this.script);this.script = null;
          }if (this.form) {
            this.form.parentNode.removeChild(this.form);this.form = null;this.iframe = null;
          }Polling.prototype.doClose.call(this);
        };JSONPPolling.prototype.doPoll = function () {
          var self = this;var script = document.createElement("script");if (this.script) {
            this.script.parentNode.removeChild(this.script);this.script = null;
          }script.async = true;script.src = this.uri();script.onerror = function (e) {
            self.onError("jsonp poll error", e);
          };var insertAt = document.getElementsByTagName("script")[0];if (insertAt) {
            insertAt.parentNode.insertBefore(script, insertAt);
          } else {
            (document.head || document.body).appendChild(script);
          }this.script = script;var isUAgecko = "undefined" != typeof navigator && /gecko/i.test(navigator.userAgent);if (isUAgecko) {
            setTimeout(function () {
              var iframe = document.createElement("iframe");document.body.appendChild(iframe);document.body.removeChild(iframe);
            }, 100);
          }
        };JSONPPolling.prototype.doWrite = function (data, fn) {
          var self = this;if (!this.form) {
            var form = document.createElement("form");var area = document.createElement("textarea");var id = this.iframeId = "eio_iframe_" + this.index;var iframe;form.className = "socketio";form.style.position = "absolute";form.style.top = "-1000px";form.style.left = "-1000px";form.target = id;form.method = "POST";form.setAttribute("accept-charset", "utf-8");area.name = "d";form.appendChild(area);document.body.appendChild(form);this.form = form;this.area = area;
          }this.form.action = this.uri();function complete() {
            initIframe();fn();
          }function initIframe() {
            if (self.iframe) {
              try {
                self.form.removeChild(self.iframe);
              } catch (e) {
                self.onError("jsonp polling iframe removal error", e);
              }
            }try {
              var html = '<iframe src="javascript:0" name="' + self.iframeId + '">';iframe = document.createElement(html);
            } catch (e) {
              iframe = document.createElement("iframe");iframe.name = self.iframeId;iframe.src = "javascript:0";
            }iframe.id = self.iframeId;self.form.appendChild(iframe);self.iframe = iframe;
          }initIframe();data = data.replace(rEscapedNewline, "\\\n");this.area.value = data.replace(rNewline, "\\n");try {
            this.form.submit();
          } catch (e) {}if (this.iframe.attachEvent) {
            this.iframe.onreadystatechange = function () {
              if (self.iframe.readyState == "complete") {
                complete();
              }
            };
          } else {
            this.iframe.onload = complete;
          }
        };
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { "./polling": 8, "component-inherit": 16 }], 7: [function (_dereq_, module, exports) {
      (function (global) {
        var XMLHttpRequest = _dereq_("xmlhttprequest-ssl");var Polling = _dereq_("./polling");var Emitter = _dereq_("component-emitter");var inherit = _dereq_("component-inherit");var debug = _dereq_("debug")("engine.io-client:polling-xhr");module.exports = XHR;module.exports.Request = Request;function empty() {}function XHR(opts) {
          Polling.call(this, opts);if (global.location) {
            var isSSL = "https:" == location.protocol;var port = location.port;if (!port) {
              port = isSSL ? 443 : 80;
            }this.xd = opts.hostname != global.location.hostname || port != opts.port;this.xs = opts.secure != isSSL;
          } else {
            this.extraHeaders = opts.extraHeaders;
          }
        }inherit(XHR, Polling);XHR.prototype.supportsBinary = true;XHR.prototype.request = function (opts) {
          opts = opts || {};opts.uri = this.uri();opts.xd = this.xd;opts.xs = this.xs;opts.agent = this.agent || false;opts.supportsBinary = this.supportsBinary;opts.enablesXDR = this.enablesXDR;opts.pfx = this.pfx;opts.key = this.key;opts.passphrase = this.passphrase;opts.cert = this.cert;opts.ca = this.ca;opts.ciphers = this.ciphers;opts.rejectUnauthorized = this.rejectUnauthorized;opts.extraHeaders = this.extraHeaders;return new Request(opts);
        };XHR.prototype.doWrite = function (data, fn) {
          var isBinary = typeof data !== "string" && data !== undefined;var req = this.request({ method: "POST", data: data, isBinary: isBinary });var self = this;req.on("success", fn);req.on("error", function (err) {
            self.onError("xhr post error", err);
          });this.sendXhr = req;
        };XHR.prototype.doPoll = function () {
          debug("xhr poll");var req = this.request();var self = this;req.on("data", function (data) {
            self.onData(data);
          });req.on("error", function (err) {
            self.onError("xhr poll error", err);
          });this.pollXhr = req;
        };function Request(opts) {
          this.method = opts.method || "GET";this.uri = opts.uri;this.xd = !!opts.xd;this.xs = !!opts.xs;this.async = false !== opts.async;this.data = undefined != opts.data ? opts.data : null;this.agent = opts.agent;this.isBinary = opts.isBinary;this.supportsBinary = opts.supportsBinary;this.enablesXDR = opts.enablesXDR;this.pfx = opts.pfx;this.key = opts.key;this.passphrase = opts.passphrase;this.cert = opts.cert;this.ca = opts.ca;this.ciphers = opts.ciphers;this.rejectUnauthorized = opts.rejectUnauthorized;this.extraHeaders = opts.extraHeaders;this.create();
        }Emitter(Request.prototype);Request.prototype.create = function () {
          var opts = { agent: this.agent, xdomain: this.xd, xscheme: this.xs, enablesXDR: this.enablesXDR };opts.pfx = this.pfx;opts.key = this.key;opts.passphrase = this.passphrase;opts.cert = this.cert;opts.ca = this.ca;opts.ciphers = this.ciphers;opts.rejectUnauthorized = this.rejectUnauthorized;var xhr = this.xhr = new XMLHttpRequest(opts);var self = this;try {
            debug("xhr open %s: %s", this.method, this.uri);xhr.open(this.method, this.uri, this.async);try {
              if (this.extraHeaders) {
                xhr.setDisableHeaderCheck(true);for (var i in this.extraHeaders) {
                  if (this.extraHeaders.hasOwnProperty(i)) {
                    xhr.setRequestHeader(i, this.extraHeaders[i]);
                  }
                }
              }
            } catch (e) {}if (this.supportsBinary) {
              xhr.responseType = "arraybuffer";
            }if ("POST" == this.method) {
              try {
                if (this.isBinary) {
                  xhr.setRequestHeader("Content-type", "application/octet-stream");
                } else {
                  xhr.setRequestHeader("Content-type", "text/plain;charset=UTF-8");
                }
              } catch (e) {}
            }if ("withCredentials" in xhr) {
              xhr.withCredentials = true;
            }if (this.hasXDR()) {
              xhr.onload = function () {
                self.onLoad();
              };xhr.onerror = function () {
                self.onError(xhr.responseText);
              };
            } else {
              xhr.onreadystatechange = function () {
                if (4 != xhr.readyState) return;if (200 == xhr.status || 1223 == xhr.status) {
                  self.onLoad();
                } else {
                  setTimeout(function () {
                    self.onError(xhr.status);
                  }, 0);
                }
              };
            }debug("xhr data %s", this.data);xhr.send(this.data);
          } catch (e) {
            setTimeout(function () {
              self.onError(e);
            }, 0);return;
          }if (global.document) {
            this.index = Request.requestsCount++;Request.requests[this.index] = this;
          }
        };Request.prototype.onSuccess = function () {
          this.emit("success");this.cleanup();
        };Request.prototype.onData = function (data) {
          this.emit("data", data);this.onSuccess();
        };Request.prototype.onError = function (err) {
          this.emit("error", err);this.cleanup(true);
        };Request.prototype.cleanup = function (fromError) {
          if ("undefined" == typeof this.xhr || null === this.xhr) {
            return;
          }if (this.hasXDR()) {
            this.xhr.onload = this.xhr.onerror = empty;
          } else {
            this.xhr.onreadystatechange = empty;
          }if (fromError) {
            try {
              this.xhr.abort();
            } catch (e) {}
          }if (global.document) {
            delete Request.requests[this.index];
          }this.xhr = null;
        };Request.prototype.onLoad = function () {
          var data;try {
            var contentType;try {
              contentType = this.xhr.getResponseHeader("Content-Type").split(";")[0];
            } catch (e) {}if (contentType === "application/octet-stream") {
              data = this.xhr.response;
            } else {
              if (!this.supportsBinary) {
                data = this.xhr.responseText;
              } else {
                try {
                  data = String.fromCharCode.apply(null, new Uint8Array(this.xhr.response));
                } catch (e) {
                  var ui8Arr = new Uint8Array(this.xhr.response);var dataArray = [];for (var idx = 0, length = ui8Arr.length; idx < length; idx++) {
                    dataArray.push(ui8Arr[idx]);
                  }data = String.fromCharCode.apply(null, dataArray);
                }
              }
            }
          } catch (e) {
            this.onError(e);
          }if (null != data) {
            this.onData(data);
          }
        };Request.prototype.hasXDR = function () {
          return "undefined" !== typeof global.XDomainRequest && !this.xs && this.enablesXDR;
        };Request.prototype.abort = function () {
          this.cleanup();
        };if (global.document) {
          Request.requestsCount = 0;Request.requests = {};if (global.attachEvent) {
            global.attachEvent("onunload", unloadHandler);
          } else if (global.addEventListener) {
            global.addEventListener("beforeunload", unloadHandler, false);
          }
        }function unloadHandler() {
          for (var i in Request.requests) {
            if (Request.requests.hasOwnProperty(i)) {
              Request.requests[i].abort();
            }
          }
        }
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { "./polling": 8, "component-emitter": 15, "component-inherit": 16, debug: 17, "xmlhttprequest-ssl": 10 }], 8: [function (_dereq_, module, exports) {
      var Transport = _dereq_("../transport");var parseqs = _dereq_("parseqs");var parser = _dereq_("engine.io-parser");var inherit = _dereq_("component-inherit");var yeast = _dereq_("yeast");var debug = _dereq_("debug")("engine.io-client:polling");module.exports = Polling;var hasXHR2 = function () {
        var XMLHttpRequest = _dereq_("xmlhttprequest-ssl");var xhr = new XMLHttpRequest({ xdomain: false });return null != xhr.responseType;
      }();function Polling(opts) {
        var forceBase64 = opts && opts.forceBase64;if (!hasXHR2 || forceBase64) {
          this.supportsBinary = false;
        }Transport.call(this, opts);
      }inherit(Polling, Transport);Polling.prototype.name = "polling";Polling.prototype.doOpen = function () {
        this.poll();
      };Polling.prototype.pause = function (onPause) {
        var pending = 0;var self = this;this.readyState = "pausing";function pause() {
          debug("paused");self.readyState = "paused";onPause();
        }if (this.polling || !this.writable) {
          var total = 0;if (this.polling) {
            debug("we are currently polling - waiting to pause");total++;this.once("pollComplete", function () {
              debug("pre-pause polling complete");--total || pause();
            });
          }if (!this.writable) {
            debug("we are currently writing - waiting to pause");total++;this.once("drain", function () {
              debug("pre-pause writing complete");--total || pause();
            });
          }
        } else {
          pause();
        }
      };Polling.prototype.poll = function () {
        debug("polling");this.polling = true;this.doPoll();this.emit("poll");
      };Polling.prototype.onData = function (data) {
        var self = this;debug("polling got data %s", data);var callback = function callback(packet, index, total) {
          if ("opening" == self.readyState) {
            self.onOpen();
          }if ("close" == packet.type) {
            self.onClose();return false;
          }self.onPacket(packet);
        };parser.decodePayload(data, this.socket.binaryType, callback);if ("closed" != this.readyState) {
          this.polling = false;this.emit("pollComplete");if ("open" == this.readyState) {
            this.poll();
          } else {
            debug('ignoring poll - transport state "%s"', this.readyState);
          }
        }
      };Polling.prototype.doClose = function () {
        var self = this;function close() {
          debug("writing close packet");self.write([{ type: "close" }]);
        }if ("open" == this.readyState) {
          debug("transport open - closing");close();
        } else {
          debug("transport not open - deferring close");this.once("open", close);
        }
      };Polling.prototype.write = function (packets) {
        var self = this;this.writable = false;var callbackfn = function callbackfn() {
          self.writable = true;self.emit("drain");
        };var self = this;parser.encodePayload(packets, this.supportsBinary, function (data) {
          self.doWrite(data, callbackfn);
        });
      };Polling.prototype.uri = function () {
        var query = this.query || {};var schema = this.secure ? "https" : "http";var port = "";if (false !== this.timestampRequests) {
          query[this.timestampParam] = yeast();
        }if (!this.supportsBinary && !query.sid) {
          query.b64 = 1;
        }query = parseqs.encode(query);if (this.port && ("https" == schema && this.port != 443 || "http" == schema && this.port != 80)) {
          port = ":" + this.port;
        }if (query.length) {
          query = "?" + query;
        }var ipv6 = this.hostname.indexOf(":") !== -1;return schema + "://" + (ipv6 ? "[" + this.hostname + "]" : this.hostname) + port + this.path + query;
      };
    }, { "../transport": 4, "component-inherit": 16, debug: 17, "engine.io-parser": 19, parseqs: 27, "xmlhttprequest-ssl": 10, yeast: 30 }], 9: [function (_dereq_, module, exports) {
      (function (global) {
        var Transport = _dereq_("../transport");var parser = _dereq_("engine.io-parser");var parseqs = _dereq_("parseqs");var inherit = _dereq_("component-inherit");var yeast = _dereq_("yeast");var debug = _dereq_("debug")("engine.io-client:websocket");var BrowserWebSocket = global.WebSocket || global.MozWebSocket;var WebSocket = BrowserWebSocket;if (!WebSocket && typeof window === "undefined") {
          try {
            WebSocket = _dereq_("ws");
          } catch (e) {}
        }module.exports = WS;function WS(opts) {
          var forceBase64 = opts && opts.forceBase64;if (forceBase64) {
            this.supportsBinary = false;
          }this.perMessageDeflate = opts.perMessageDeflate;Transport.call(this, opts);
        }inherit(WS, Transport);WS.prototype.name = "websocket";WS.prototype.supportsBinary = true;WS.prototype.doOpen = function () {
          if (!this.check()) {
            return;
          }var self = this;var uri = this.uri();var protocols = void 0;var opts = { agent: this.agent, perMessageDeflate: this.perMessageDeflate };opts.pfx = this.pfx;opts.key = this.key;opts.passphrase = this.passphrase;opts.cert = this.cert;opts.ca = this.ca;opts.ciphers = this.ciphers;opts.rejectUnauthorized = this.rejectUnauthorized;if (this.extraHeaders) {
            opts.headers = this.extraHeaders;
          }this.ws = BrowserWebSocket ? new WebSocket(uri) : new WebSocket(uri, protocols, opts);if (this.ws.binaryType === undefined) {
            this.supportsBinary = false;
          }if (this.ws.supports && this.ws.supports.binary) {
            this.supportsBinary = true;this.ws.binaryType = "buffer";
          } else {
            this.ws.binaryType = "arraybuffer";
          }this.addEventListeners();
        };WS.prototype.addEventListeners = function () {
          var self = this;this.ws.onopen = function () {
            self.onOpen();
          };this.ws.onclose = function () {
            self.onClose();
          };this.ws.onmessage = function (ev) {
            self.onData(ev.data);
          };this.ws.onerror = function (e) {
            self.onError("websocket error", e);
          };
        };if ("undefined" != typeof navigator && /iPad|iPhone|iPod/i.test(navigator.userAgent)) {
          WS.prototype.onData = function (data) {
            var self = this;setTimeout(function () {
              Transport.prototype.onData.call(self, data);
            }, 0);
          };
        }WS.prototype.write = function (packets) {
          var self = this;this.writable = false;var total = packets.length;for (var i = 0, l = total; i < l; i++) {
            (function (packet) {
              parser.encodePacket(packet, self.supportsBinary, function (data) {
                if (!BrowserWebSocket) {
                  var opts = {};if (packet.options) {
                    opts.compress = packet.options.compress;
                  }if (self.perMessageDeflate) {
                    var len = "string" == typeof data ? global.Buffer.byteLength(data) : data.length;if (len < self.perMessageDeflate.threshold) {
                      opts.compress = false;
                    }
                  }
                }try {
                  if (BrowserWebSocket) {
                    self.ws.send(data);
                  } else {
                    self.ws.send(data, opts);
                  }
                } catch (e) {
                  debug("websocket closed before onclose event");
                }--total || done();
              });
            })(packets[i]);
          }function done() {
            self.emit("flush");setTimeout(function () {
              self.writable = true;self.emit("drain");
            }, 0);
          }
        };WS.prototype.onClose = function () {
          Transport.prototype.onClose.call(this);
        };WS.prototype.doClose = function () {
          if (typeof this.ws !== "undefined") {
            this.ws.close();
          }
        };WS.prototype.uri = function () {
          var query = this.query || {};var schema = this.secure ? "wss" : "ws";var port = "";if (this.port && ("wss" == schema && this.port != 443 || "ws" == schema && this.port != 80)) {
            port = ":" + this.port;
          }if (this.timestampRequests) {
            query[this.timestampParam] = yeast();
          }if (!this.supportsBinary) {
            query.b64 = 1;
          }query = parseqs.encode(query);if (query.length) {
            query = "?" + query;
          }var ipv6 = this.hostname.indexOf(":") !== -1;return schema + "://" + (ipv6 ? "[" + this.hostname + "]" : this.hostname) + port + this.path + query;
        };WS.prototype.check = function () {
          return !!WebSocket && !("__initialize" in WebSocket && this.name === WS.prototype.name);
        };
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { "../transport": 4, "component-inherit": 16, debug: 17, "engine.io-parser": 19, parseqs: 27, ws: undefined, yeast: 30 }], 10: [function (_dereq_, module, exports) {
      var hasCORS = _dereq_("has-cors");module.exports = function (opts) {
        var xdomain = opts.xdomain;var xscheme = opts.xscheme;var enablesXDR = opts.enablesXDR;try {
          if ("undefined" != typeof XMLHttpRequest && (!xdomain || hasCORS)) {
            return new XMLHttpRequest();
          }
        } catch (e) {}try {
          if ("undefined" != typeof XDomainRequest && !xscheme && enablesXDR) {
            return new XDomainRequest();
          }
        } catch (e) {}if (!xdomain) {
          try {
            return new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e) {}
        }
      };
    }, { "has-cors": 22 }], 11: [function (_dereq_, module, exports) {
      module.exports = after;function after(count, callback, err_cb) {
        var bail = false;err_cb = err_cb || noop;proxy.count = count;return count === 0 ? callback() : proxy;function proxy(err, result) {
          if (proxy.count <= 0) {
            throw new Error("after called too many times");
          }--proxy.count;if (err) {
            bail = true;callback(err);callback = err_cb;
          } else if (proxy.count === 0 && !bail) {
            callback(null, result);
          }
        }
      }function noop() {}
    }, {}], 12: [function (_dereq_, module, exports) {
      module.exports = function (arraybuffer, start, end) {
        var bytes = arraybuffer.byteLength;start = start || 0;end = end || bytes;if (arraybuffer.slice) {
          return arraybuffer.slice(start, end);
        }if (start < 0) {
          start += bytes;
        }if (end < 0) {
          end += bytes;
        }if (end > bytes) {
          end = bytes;
        }if (start >= bytes || start >= end || bytes === 0) {
          return new ArrayBuffer(0);
        }var abv = new Uint8Array(arraybuffer);var result = new Uint8Array(end - start);for (var i = start, ii = 0; i < end; i++, ii++) {
          result[ii] = abv[i];
        }return result.buffer;
      };
    }, {}], 13: [function (_dereq_, module, exports) {
      (function (chars) {
        "use strict";
        exports.encode = function (arraybuffer) {
          var bytes = new Uint8Array(arraybuffer),
              i,
              len = bytes.length,
              base64 = "";for (i = 0; i < len; i += 3) {
            base64 += chars[bytes[i] >> 2];
            base64 += chars[(bytes[i] & 3) << 4 | bytes[i + 1] >> 4];base64 += chars[(bytes[i + 1] & 15) << 2 | bytes[i + 2] >> 6];base64 += chars[bytes[i + 2] & 63];
          }if (len % 3 === 2) {
            base64 = base64.substring(0, base64.length - 1) + "=";
          } else if (len % 3 === 1) {
            base64 = base64.substring(0, base64.length - 2) + "==";
          }return base64;
        };exports.decode = function (base64) {
          var bufferLength = base64.length * .75,
              len = base64.length,
              i,
              p = 0,
              encoded1,
              encoded2,
              encoded3,
              encoded4;if (base64[base64.length - 1] === "=") {
            bufferLength--;if (base64[base64.length - 2] === "=") {
              bufferLength--;
            }
          }var arraybuffer = new ArrayBuffer(bufferLength),
              bytes = new Uint8Array(arraybuffer);for (i = 0; i < len; i += 4) {
            encoded1 = chars.indexOf(base64[i]);encoded2 = chars.indexOf(base64[i + 1]);encoded3 = chars.indexOf(base64[i + 2]);encoded4 = chars.indexOf(base64[i + 3]);bytes[p++] = encoded1 << 2 | encoded2 >> 4;bytes[p++] = (encoded2 & 15) << 4 | encoded3 >> 2;bytes[p++] = (encoded3 & 3) << 6 | encoded4 & 63;
          }return arraybuffer;
        };
      })("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/");
    }, {}], 14: [function (_dereq_, module, exports) {
      (function (global) {
        var BlobBuilder = global.BlobBuilder || global.WebKitBlobBuilder || global.MSBlobBuilder || global.MozBlobBuilder;var blobSupported = function () {
          try {
            var a = new Blob(["hi"]);return a.size === 2;
          } catch (e) {
            return false;
          }
        }();var blobSupportsArrayBufferView = blobSupported && function () {
          try {
            var b = new Blob([new Uint8Array([1, 2])]);return b.size === 2;
          } catch (e) {
            return false;
          }
        }();var blobBuilderSupported = BlobBuilder && BlobBuilder.prototype.append && BlobBuilder.prototype.getBlob;function mapArrayBufferViews(ary) {
          for (var i = 0; i < ary.length; i++) {
            var chunk = ary[i];if (chunk.buffer instanceof ArrayBuffer) {
              var buf = chunk.buffer;if (chunk.byteLength !== buf.byteLength) {
                var copy = new Uint8Array(chunk.byteLength);copy.set(new Uint8Array(buf, chunk.byteOffset, chunk.byteLength));buf = copy.buffer;
              }ary[i] = buf;
            }
          }
        }function BlobBuilderConstructor(ary, options) {
          options = options || {};var bb = new BlobBuilder();mapArrayBufferViews(ary);for (var i = 0; i < ary.length; i++) {
            bb.append(ary[i]);
          }return options.type ? bb.getBlob(options.type) : bb.getBlob();
        }function BlobConstructor(ary, options) {
          mapArrayBufferViews(ary);return new Blob(ary, options || {});
        }module.exports = function () {
          if (blobSupported) {
            return blobSupportsArrayBufferView ? global.Blob : BlobConstructor;
          } else if (blobBuilderSupported) {
            return BlobBuilderConstructor;
          } else {
            return undefined;
          }
        }();
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, {}], 15: [function (_dereq_, module, exports) {
      module.exports = Emitter;function Emitter(obj) {
        if (obj) return mixin(obj);
      }function mixin(obj) {
        for (var key in Emitter.prototype) {
          obj[key] = Emitter.prototype[key];
        }return obj;
      }Emitter.prototype.on = Emitter.prototype.addEventListener = function (event, fn) {
        this._callbacks = this._callbacks || {};(this._callbacks[event] = this._callbacks[event] || []).push(fn);return this;
      };Emitter.prototype.once = function (event, fn) {
        var self = this;this._callbacks = this._callbacks || {};function on() {
          self.off(event, on);fn.apply(this, arguments);
        }on.fn = fn;this.on(event, on);return this;
      };Emitter.prototype.off = Emitter.prototype.removeListener = Emitter.prototype.removeAllListeners = Emitter.prototype.removeEventListener = function (event, fn) {
        this._callbacks = this._callbacks || {};if (0 == arguments.length) {
          this._callbacks = {};return this;
        }var callbacks = this._callbacks[event];if (!callbacks) return this;if (1 == arguments.length) {
          delete this._callbacks[event];return this;
        }var cb;for (var i = 0; i < callbacks.length; i++) {
          cb = callbacks[i];if (cb === fn || cb.fn === fn) {
            callbacks.splice(i, 1);break;
          }
        }return this;
      };Emitter.prototype.emit = function (event) {
        this._callbacks = this._callbacks || {};var args = [].slice.call(arguments, 1),
            callbacks = this._callbacks[event];if (callbacks) {
          callbacks = callbacks.slice(0);for (var i = 0, len = callbacks.length; i < len; ++i) {
            callbacks[i].apply(this, args);
          }
        }return this;
      };Emitter.prototype.listeners = function (event) {
        this._callbacks = this._callbacks || {};return this._callbacks[event] || [];
      };Emitter.prototype.hasListeners = function (event) {
        return !!this.listeners(event).length;
      };
    }, {}], 16: [function (_dereq_, module, exports) {
      module.exports = function (a, b) {
        var fn = function fn() {};fn.prototype = b.prototype;a.prototype = new fn();a.prototype.constructor = a;
      };
    }, {}], 17: [function (_dereq_, module, exports) {
      exports = module.exports = _dereq_("./debug");exports.log = log;exports.formatArgs = formatArgs;exports.save = save;exports.load = load;exports.useColors = useColors;exports.storage = "undefined" != typeof chrome && "undefined" != typeof chrome.storage ? chrome.storage.local : localstorage();exports.colors = ["lightseagreen", "forestgreen", "goldenrod", "dodgerblue", "darkorchid", "crimson"];function useColors() {
        return "WebkitAppearance" in document.documentElement.style || window.console && (console.firebug || console.exception && console.table) || navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && parseInt(RegExp.$1, 10) >= 31;
      }exports.formatters.j = function (v) {
        return JSON.stringify(v);
      };function formatArgs() {
        var args = arguments;var useColors = this.useColors;args[0] = (useColors ? "%c" : "") + this.namespace + (useColors ? " %c" : " ") + args[0] + (useColors ? "%c " : " ") + "+" + exports.humanize(this.diff);if (!useColors) return args;var c = "color: " + this.color;args = [args[0], c, "color: inherit"].concat(Array.prototype.slice.call(args, 1));var index = 0;var lastC = 0;args[0].replace(/%[a-z%]/g, function (match) {
          if ("%%" === match) return;index++;if ("%c" === match) {
            lastC = index;
          }
        });args.splice(lastC, 0, c);return args;
      }function log() {
        return "object" === (typeof console === "undefined" ? "undefined" : _typeof(console)) && console.log && Function.prototype.apply.call(console.log, console, arguments);
      }function save(namespaces) {
        try {
          if (null == namespaces) {
            exports.storage.removeItem("debug");
          } else {
            exports.storage.debug = namespaces;
          }
        } catch (e) {}
      }function load() {
        var r;try {
          r = exports.storage.debug;
        } catch (e) {}return r;
      }exports.enable(load());function localstorage() {
        try {
          return window.localStorage;
        } catch (e) {}
      }
    }, { "./debug": 18 }], 18: [function (_dereq_, module, exports) {
      exports = module.exports = debug;exports.coerce = coerce;exports.disable = disable;exports.enable = enable;exports.enabled = enabled;exports.humanize = _dereq_("ms");exports.names = [];exports.skips = [];exports.formatters = {};var prevColor = 0;var prevTime;function selectColor() {
        return exports.colors[prevColor++ % exports.colors.length];
      }function debug(namespace) {
        function disabled() {}disabled.enabled = false;function enabled() {
          var self = enabled;var curr = +new Date();var ms = curr - (prevTime || curr);self.diff = ms;self.prev = prevTime;self.curr = curr;prevTime = curr;if (null == self.useColors) self.useColors = exports.useColors();if (null == self.color && self.useColors) self.color = selectColor();var args = Array.prototype.slice.call(arguments);args[0] = exports.coerce(args[0]);if ("string" !== typeof args[0]) {
            args = ["%o"].concat(args);
          }var index = 0;args[0] = args[0].replace(/%([a-z%])/g, function (match, format) {
            if (match === "%%") return match;index++;var formatter = exports.formatters[format];if ("function" === typeof formatter) {
              var val = args[index];match = formatter.call(self, val);args.splice(index, 1);index--;
            }return match;
          });if ("function" === typeof exports.formatArgs) {
            args = exports.formatArgs.apply(self, args);
          }var logFn = enabled.log || exports.log || console.log.bind(console);logFn.apply(self, args);
        }enabled.enabled = true;var fn = exports.enabled(namespace) ? enabled : disabled;fn.namespace = namespace;return fn;
      }function enable(namespaces) {
        exports.save(namespaces);var split = (namespaces || "").split(/[\s,]+/);var len = split.length;for (var i = 0; i < len; i++) {
          if (!split[i]) continue;namespaces = split[i].replace(/\*/g, ".*?");if (namespaces[0] === "-") {
            exports.skips.push(new RegExp("^" + namespaces.substr(1) + "$"));
          } else {
            exports.names.push(new RegExp("^" + namespaces + "$"));
          }
        }
      }function disable() {
        exports.enable("");
      }function enabled(name) {
        var i, len;for (i = 0, len = exports.skips.length; i < len; i++) {
          if (exports.skips[i].test(name)) {
            return false;
          }
        }for (i = 0, len = exports.names.length; i < len; i++) {
          if (exports.names[i].test(name)) {
            return true;
          }
        }return false;
      }function coerce(val) {
        if (val instanceof Error) return val.stack || val.message;return val;
      }
    }, { ms: 25 }], 19: [function (_dereq_, module, exports) {
      (function (global) {
        var keys = _dereq_("./keys");var hasBinary = _dereq_("has-binary");var sliceBuffer = _dereq_("arraybuffer.slice");var base64encoder = _dereq_("base64-arraybuffer");var after = _dereq_("after");var utf8 = _dereq_("utf8");var isAndroid = navigator.userAgent.match(/Android/i);var isPhantomJS = /PhantomJS/i.test(navigator.userAgent);var dontSendBlobs = isAndroid || isPhantomJS;exports.protocol = 3;var packets = exports.packets = { open: 0, close: 1, ping: 2, pong: 3, message: 4, upgrade: 5, noop: 6 };var packetslist = keys(packets);var err = { type: "error", data: "parser error" };var Blob = _dereq_("blob");exports.encodePacket = function (packet, supportsBinary, utf8encode, callback) {
          if ("function" == typeof supportsBinary) {
            callback = supportsBinary;supportsBinary = false;
          }if ("function" == typeof utf8encode) {
            callback = utf8encode;utf8encode = null;
          }var data = packet.data === undefined ? undefined : packet.data.buffer || packet.data;if (global.ArrayBuffer && data instanceof ArrayBuffer) {
            return encodeArrayBuffer(packet, supportsBinary, callback);
          } else if (Blob && data instanceof global.Blob) {
            return encodeBlob(packet, supportsBinary, callback);
          }if (data && data.base64) {
            return encodeBase64Object(packet, callback);
          }var encoded = packets[packet.type];if (undefined !== packet.data) {
            encoded += utf8encode ? utf8.encode(String(packet.data)) : String(packet.data);
          }return callback("" + encoded);
        };function encodeBase64Object(packet, callback) {
          var message = "b" + exports.packets[packet.type] + packet.data.data;return callback(message);
        }function encodeArrayBuffer(packet, supportsBinary, callback) {
          if (!supportsBinary) {
            return exports.encodeBase64Packet(packet, callback);
          }var data = packet.data;var contentArray = new Uint8Array(data);var resultBuffer = new Uint8Array(1 + data.byteLength);resultBuffer[0] = packets[packet.type];for (var i = 0; i < contentArray.length; i++) {
            resultBuffer[i + 1] = contentArray[i];
          }return callback(resultBuffer.buffer);
        }function encodeBlobAsArrayBuffer(packet, supportsBinary, callback) {
          if (!supportsBinary) {
            return exports.encodeBase64Packet(packet, callback);
          }var fr = new FileReader();fr.onload = function () {
            packet.data = fr.result;exports.encodePacket(packet, supportsBinary, true, callback);
          };return fr.readAsArrayBuffer(packet.data);
        }function encodeBlob(packet, supportsBinary, callback) {
          if (!supportsBinary) {
            return exports.encodeBase64Packet(packet, callback);
          }if (dontSendBlobs) {
            return encodeBlobAsArrayBuffer(packet, supportsBinary, callback);
          }var length = new Uint8Array(1);length[0] = packets[packet.type];var blob = new Blob([length.buffer, packet.data]);return callback(blob);
        }exports.encodeBase64Packet = function (packet, callback) {
          var message = "b" + exports.packets[packet.type];if (Blob && packet.data instanceof global.Blob) {
            var fr = new FileReader();fr.onload = function () {
              var b64 = fr.result.split(",")[1];callback(message + b64);
            };return fr.readAsDataURL(packet.data);
          }var b64data;try {
            b64data = String.fromCharCode.apply(null, new Uint8Array(packet.data));
          } catch (e) {
            var typed = new Uint8Array(packet.data);var basic = new Array(typed.length);for (var i = 0; i < typed.length; i++) {
              basic[i] = typed[i];
            }b64data = String.fromCharCode.apply(null, basic);
          }message += global.btoa(b64data);return callback(message);
        };exports.decodePacket = function (data, binaryType, utf8decode) {
          if (typeof data == "string" || data === undefined) {
            if (data.charAt(0) == "b") {
              return exports.decodeBase64Packet(data.substr(1), binaryType);
            }if (utf8decode) {
              try {
                data = utf8.decode(data);
              } catch (e) {
                return err;
              }
            }var type = data.charAt(0);if (Number(type) != type || !packetslist[type]) {
              return err;
            }if (data.length > 1) {
              return { type: packetslist[type], data: data.substring(1) };
            } else {
              return { type: packetslist[type] };
            }
          }var asArray = new Uint8Array(data);var type = asArray[0];var rest = sliceBuffer(data, 1);if (Blob && binaryType === "blob") {
            rest = new Blob([rest]);
          }return { type: packetslist[type], data: rest };
        };exports.decodeBase64Packet = function (msg, binaryType) {
          var type = packetslist[msg.charAt(0)];if (!global.ArrayBuffer) {
            return { type: type, data: { base64: true, data: msg.substr(1) } };
          }var data = base64encoder.decode(msg.substr(1));if (binaryType === "blob" && Blob) {
            data = new Blob([data]);
          }return { type: type, data: data };
        };exports.encodePayload = function (packets, supportsBinary, callback) {
          if (typeof supportsBinary == "function") {
            callback = supportsBinary;supportsBinary = null;
          }var isBinary = hasBinary(packets);if (supportsBinary && isBinary) {
            if (Blob && !dontSendBlobs) {
              return exports.encodePayloadAsBlob(packets, callback);
            }return exports.encodePayloadAsArrayBuffer(packets, callback);
          }if (!packets.length) {
            return callback("0:");
          }function setLengthHeader(message) {
            return message.length + ":" + message;
          }function encodeOne(packet, doneCallback) {
            exports.encodePacket(packet, !isBinary ? false : supportsBinary, true, function (message) {
              doneCallback(null, setLengthHeader(message));
            });
          }map(packets, encodeOne, function (err, results) {
            return callback(results.join(""));
          });
        };function map(ary, each, done) {
          var result = new Array(ary.length);var next = after(ary.length, done);var eachWithIndex = function eachWithIndex(i, el, cb) {
            each(el, function (error, msg) {
              result[i] = msg;cb(error, result);
            });
          };for (var i = 0; i < ary.length; i++) {
            eachWithIndex(i, ary[i], next);
          }
        }exports.decodePayload = function (data, binaryType, callback) {
          if (typeof data != "string") {
            return exports.decodePayloadAsBinary(data, binaryType, callback);
          }if (typeof binaryType === "function") {
            callback = binaryType;binaryType = null;
          }var packet;if (data == "") {
            return callback(err, 0, 1);
          }var length = "",
              n,
              msg;for (var i = 0, l = data.length; i < l; i++) {
            var chr = data.charAt(i);if (":" != chr) {
              length += chr;
            } else {
              if ("" == length || length != (n = Number(length))) {
                return callback(err, 0, 1);
              }msg = data.substr(i + 1, n);if (length != msg.length) {
                return callback(err, 0, 1);
              }if (msg.length) {
                packet = exports.decodePacket(msg, binaryType, true);if (err.type == packet.type && err.data == packet.data) {
                  return callback(err, 0, 1);
                }var ret = callback(packet, i + n, l);if (false === ret) return;
              }i += n;length = "";
            }
          }if (length != "") {
            return callback(err, 0, 1);
          }
        };exports.encodePayloadAsArrayBuffer = function (packets, callback) {
          if (!packets.length) {
            return callback(new ArrayBuffer(0));
          }function encodeOne(packet, doneCallback) {
            exports.encodePacket(packet, true, true, function (data) {
              return doneCallback(null, data);
            });
          }map(packets, encodeOne, function (err, encodedPackets) {
            var totalLength = encodedPackets.reduce(function (acc, p) {
              var len;if (typeof p === "string") {
                len = p.length;
              } else {
                len = p.byteLength;
              }return acc + len.toString().length + len + 2;
            }, 0);var resultArray = new Uint8Array(totalLength);var bufferIndex = 0;encodedPackets.forEach(function (p) {
              var isString = typeof p === "string";var ab = p;if (isString) {
                var view = new Uint8Array(p.length);for (var i = 0; i < p.length; i++) {
                  view[i] = p.charCodeAt(i);
                }ab = view.buffer;
              }if (isString) {
                resultArray[bufferIndex++] = 0;
              } else {
                resultArray[bufferIndex++] = 1;
              }var lenStr = ab.byteLength.toString();for (var i = 0; i < lenStr.length; i++) {
                resultArray[bufferIndex++] = parseInt(lenStr[i]);
              }resultArray[bufferIndex++] = 255;var view = new Uint8Array(ab);for (var i = 0; i < view.length; i++) {
                resultArray[bufferIndex++] = view[i];
              }
            });return callback(resultArray.buffer);
          });
        };exports.encodePayloadAsBlob = function (packets, callback) {
          function encodeOne(packet, doneCallback) {
            exports.encodePacket(packet, true, true, function (encoded) {
              var binaryIdentifier = new Uint8Array(1);binaryIdentifier[0] = 1;if (typeof encoded === "string") {
                var view = new Uint8Array(encoded.length);for (var i = 0; i < encoded.length; i++) {
                  view[i] = encoded.charCodeAt(i);
                }encoded = view.buffer;binaryIdentifier[0] = 0;
              }var len = encoded instanceof ArrayBuffer ? encoded.byteLength : encoded.size;var lenStr = len.toString();var lengthAry = new Uint8Array(lenStr.length + 1);for (var i = 0; i < lenStr.length; i++) {
                lengthAry[i] = parseInt(lenStr[i]);
              }lengthAry[lenStr.length] = 255;if (Blob) {
                var blob = new Blob([binaryIdentifier.buffer, lengthAry.buffer, encoded]);doneCallback(null, blob);
              }
            });
          }map(packets, encodeOne, function (err, results) {
            return callback(new Blob(results));
          });
        };exports.decodePayloadAsBinary = function (data, binaryType, callback) {
          if (typeof binaryType === "function") {
            callback = binaryType;binaryType = null;
          }var bufferTail = data;var buffers = [];var numberTooLong = false;while (bufferTail.byteLength > 0) {
            var tailArray = new Uint8Array(bufferTail);var isString = tailArray[0] === 0;var msgLength = "";for (var i = 1;; i++) {
              if (tailArray[i] == 255) break;if (msgLength.length > 310) {
                numberTooLong = true;break;
              }msgLength += tailArray[i];
            }if (numberTooLong) return callback(err, 0, 1);bufferTail = sliceBuffer(bufferTail, 2 + msgLength.length);msgLength = parseInt(msgLength);var msg = sliceBuffer(bufferTail, 0, msgLength);if (isString) {
              try {
                msg = String.fromCharCode.apply(null, new Uint8Array(msg));
              } catch (e) {
                var typed = new Uint8Array(msg);msg = "";for (var i = 0; i < typed.length; i++) {
                  msg += String.fromCharCode(typed[i]);
                }
              }
            }buffers.push(msg);bufferTail = sliceBuffer(bufferTail, msgLength);
          }var total = buffers.length;buffers.forEach(function (buffer, i) {
            callback(exports.decodePacket(buffer, binaryType, true), i, total);
          });
        };
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { "./keys": 20, after: 11, "arraybuffer.slice": 12, "base64-arraybuffer": 13, blob: 14, "has-binary": 21, utf8: 29 }], 20: [function (_dereq_, module, exports) {
      module.exports = Object.keys || function keys(obj) {
        var arr = [];var has = Object.prototype.hasOwnProperty;for (var i in obj) {
          if (has.call(obj, i)) {
            arr.push(i);
          }
        }return arr;
      };
    }, {}], 21: [function (_dereq_, module, exports) {
      (function (global) {
        var isArray = _dereq_("isarray");module.exports = hasBinary;function hasBinary(data) {
          function _hasBinary(obj) {
            if (!obj) return false;if (global.Buffer && global.Buffer.isBuffer(obj) || global.ArrayBuffer && obj instanceof ArrayBuffer || global.Blob && obj instanceof Blob || global.File && obj instanceof File) {
              return true;
            }if (isArray(obj)) {
              for (var i = 0; i < obj.length; i++) {
                if (_hasBinary(obj[i])) {
                  return true;
                }
              }
            } else if (obj && "object" == (typeof obj === "undefined" ? "undefined" : _typeof(obj))) {
              if (obj.toJSON) {
                obj = obj.toJSON();
              }for (var key in obj) {
                if (Object.prototype.hasOwnProperty.call(obj, key) && _hasBinary(obj[key])) {
                  return true;
                }
              }
            }return false;
          }return _hasBinary(data);
        }
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { isarray: 24 }], 22: [function (_dereq_, module, exports) {
      try {
        module.exports = typeof XMLHttpRequest !== "undefined" && "withCredentials" in new XMLHttpRequest();
      } catch (err) {
        module.exports = false;
      }
    }, {}], 23: [function (_dereq_, module, exports) {
      var indexOf = [].indexOf;module.exports = function (arr, obj) {
        if (indexOf) return arr.indexOf(obj);for (var i = 0; i < arr.length; ++i) {
          if (arr[i] === obj) return i;
        }return -1;
      };
    }, {}], 24: [function (_dereq_, module, exports) {
      module.exports = Array.isArray || function (arr) {
        return Object.prototype.toString.call(arr) == "[object Array]";
      };
    }, {}], 25: [function (_dereq_, module, exports) {
      var s = 1e3;var m = s * 60;var h = m * 60;var d = h * 24;var y = d * 365.25;module.exports = function (val, options) {
        options = options || {};if ("string" == typeof val) return parse(val);return options.long ? long(val) : short(val);
      };function parse(str) {
        str = "" + str;if (str.length > 1e4) return;var match = /^((?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|years?|yrs?|y)?$/i.exec(str);if (!match) return;var n = parseFloat(match[1]);var type = (match[2] || "ms").toLowerCase();switch (type) {case "years":case "year":case "yrs":case "yr":case "y":
            return n * y;case "days":case "day":case "d":
            return n * d;case "hours":case "hour":case "hrs":case "hr":case "h":
            return n * h;case "minutes":case "minute":case "mins":case "min":case "m":
            return n * m;case "seconds":case "second":case "secs":case "sec":case "s":
            return n * s;case "milliseconds":case "millisecond":case "msecs":case "msec":case "ms":
            return n;}
      }function short(ms) {
        if (ms >= d) return Math.round(ms / d) + "d";if (ms >= h) return Math.round(ms / h) + "h";if (ms >= m) return Math.round(ms / m) + "m";if (ms >= s) return Math.round(ms / s) + "s";return ms + "ms";
      }function long(ms) {
        return plural(ms, d, "day") || plural(ms, h, "hour") || plural(ms, m, "minute") || plural(ms, s, "second") || ms + " ms";
      }function plural(ms, n, name) {
        if (ms < n) return;if (ms < n * 1.5) return Math.floor(ms / n) + " " + name;return Math.ceil(ms / n) + " " + name + "s";
      }
    }, {}], 26: [function (_dereq_, module, exports) {
      (function (global) {
        var rvalidchars = /^[\],:{}\s]*$/;var rvalidescape = /\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g;var rvalidtokens = /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g;var rvalidbraces = /(?:^|:|,)(?:\s*\[)+/g;var rtrimLeft = /^\s+/;var rtrimRight = /\s+$/;module.exports = function parsejson(data) {
          if ("string" != typeof data || !data) {
            return null;
          }data = data.replace(rtrimLeft, "").replace(rtrimRight, "");if (global.JSON && JSON.parse) {
            return JSON.parse(data);
          }if (rvalidchars.test(data.replace(rvalidescape, "@").replace(rvalidtokens, "]").replace(rvalidbraces, ""))) {
            return new Function("return " + data)();
          }
        };
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, {}], 27: [function (_dereq_, module, exports) {
      exports.encode = function (obj) {
        var str = "";for (var i in obj) {
          if (obj.hasOwnProperty(i)) {
            if (str.length) str += "&";str += encodeURIComponent(i) + "=" + encodeURIComponent(obj[i]);
          }
        }return str;
      };exports.decode = function (qs) {
        var qry = {};var pairs = qs.split("&");for (var i = 0, l = pairs.length; i < l; i++) {
          var pair = pairs[i].split("=");qry[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
        }return qry;
      };
    }, {}], 28: [function (_dereq_, module, exports) {
      var re = /^(?:(?![^:@]+:[^:@\/]*@)(http|https|ws|wss):\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?((?:[a-f0-9]{0,4}:){2,7}[a-f0-9]{0,4}|[^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/;var parts = ["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "anchor"];module.exports = function parseuri(str) {
        var src = str,
            b = str.indexOf("["),
            e = str.indexOf("]");if (b != -1 && e != -1) {
          str = str.substring(0, b) + str.substring(b, e).replace(/:/g, ";") + str.substring(e, str.length);
        }var m = re.exec(str || ""),
            uri = {},
            i = 14;while (i--) {
          uri[parts[i]] = m[i] || "";
        }if (b != -1 && e != -1) {
          uri.source = src;uri.host = uri.host.substring(1, uri.host.length - 1).replace(/;/g, ":");uri.authority = uri.authority.replace("[", "").replace("]", "").replace(/;/g, ":");uri.ipv6uri = true;
        }return uri;
      };
    }, {}], 29: [function (_dereq_, module, exports) {
      (function (global) {
        (function (root) {
          var freeExports = (typeof exports === "undefined" ? "undefined" : _typeof(exports)) == "object" && exports;var freeModule = (typeof module === "undefined" ? "undefined" : _typeof(module)) == "object" && module && module.exports == freeExports && module;var freeGlobal = (typeof global === "undefined" ? "undefined" : _typeof(global)) == "object" && global;if (freeGlobal.global === freeGlobal || freeGlobal.window === freeGlobal) {
            root = freeGlobal;
          }var stringFromCharCode = String.fromCharCode;function ucs2decode(string) {
            var output = [];var counter = 0;var length = string.length;var value;var extra;while (counter < length) {
              value = string.charCodeAt(counter++);if (value >= 55296 && value <= 56319 && counter < length) {
                extra = string.charCodeAt(counter++);if ((extra & 64512) == 56320) {
                  output.push(((value & 1023) << 10) + (extra & 1023) + 65536);
                } else {
                  output.push(value);counter--;
                }
              } else {
                output.push(value);
              }
            }return output;
          }function ucs2encode(array) {
            var length = array.length;var index = -1;var value;var output = "";while (++index < length) {
              value = array[index];if (value > 65535) {
                value -= 65536;output += stringFromCharCode(value >>> 10 & 1023 | 55296);value = 56320 | value & 1023;
              }output += stringFromCharCode(value);
            }return output;
          }function checkScalarValue(codePoint) {
            if (codePoint >= 55296 && codePoint <= 57343) {
              throw Error("Lone surrogate U+" + codePoint.toString(16).toUpperCase() + " is not a scalar value");
            }
          }function createByte(codePoint, shift) {
            return stringFromCharCode(codePoint >> shift & 63 | 128);
          }function encodeCodePoint(codePoint) {
            if ((codePoint & 4294967168) == 0) {
              return stringFromCharCode(codePoint);
            }var symbol = "";if ((codePoint & 4294965248) == 0) {
              symbol = stringFromCharCode(codePoint >> 6 & 31 | 192);
            } else if ((codePoint & 4294901760) == 0) {
              checkScalarValue(codePoint);symbol = stringFromCharCode(codePoint >> 12 & 15 | 224);symbol += createByte(codePoint, 6);
            } else if ((codePoint & 4292870144) == 0) {
              symbol = stringFromCharCode(codePoint >> 18 & 7 | 240);symbol += createByte(codePoint, 12);symbol += createByte(codePoint, 6);
            }symbol += stringFromCharCode(codePoint & 63 | 128);return symbol;
          }function utf8encode(string) {
            var codePoints = ucs2decode(string);var length = codePoints.length;var index = -1;var codePoint;var byteString = "";while (++index < length) {
              codePoint = codePoints[index];byteString += encodeCodePoint(codePoint);
            }return byteString;
          }function readContinuationByte() {
            if (byteIndex >= byteCount) {
              throw Error("Invalid byte index");
            }var continuationByte = byteArray[byteIndex] & 255;byteIndex++;if ((continuationByte & 192) == 128) {
              return continuationByte & 63;
            }throw Error("Invalid continuation byte");
          }function decodeSymbol() {
            var byte1;var byte2;var byte3;var byte4;var codePoint;if (byteIndex > byteCount) {
              throw Error("Invalid byte index");
            }if (byteIndex == byteCount) {
              return false;
            }byte1 = byteArray[byteIndex] & 255;byteIndex++;if ((byte1 & 128) == 0) {
              return byte1;
            }if ((byte1 & 224) == 192) {
              var byte2 = readContinuationByte();codePoint = (byte1 & 31) << 6 | byte2;if (codePoint >= 128) {
                return codePoint;
              } else {
                throw Error("Invalid continuation byte");
              }
            }if ((byte1 & 240) == 224) {
              byte2 = readContinuationByte();byte3 = readContinuationByte();codePoint = (byte1 & 15) << 12 | byte2 << 6 | byte3;if (codePoint >= 2048) {
                checkScalarValue(codePoint);return codePoint;
              } else {
                throw Error("Invalid continuation byte");
              }
            }if ((byte1 & 248) == 240) {
              byte2 = readContinuationByte();byte3 = readContinuationByte();byte4 = readContinuationByte();codePoint = (byte1 & 15) << 18 | byte2 << 12 | byte3 << 6 | byte4;if (codePoint >= 65536 && codePoint <= 1114111) {
                return codePoint;
              }
            }throw Error("Invalid UTF-8 detected");
          }var byteArray;var byteCount;var byteIndex;function utf8decode(byteString) {
            byteArray = ucs2decode(byteString);byteCount = byteArray.length;byteIndex = 0;var codePoints = [];var tmp;while ((tmp = decodeSymbol()) !== false) {
              codePoints.push(tmp);
            }return ucs2encode(codePoints);
          }var utf8 = { version: "2.0.0", encode: utf8encode, decode: utf8decode };if (typeof define == "function" && _typeof(define.amd) == "object" && define.amd) {
            define(function () {
              return utf8;
            });
          } else if (freeExports && !freeExports.nodeType) {
            if (freeModule) {
              freeModule.exports = utf8;
            } else {
              var object = {};var hasOwnProperty = object.hasOwnProperty;for (var key in utf8) {
                hasOwnProperty.call(utf8, key) && (freeExports[key] = utf8[key]);
              }
            }
          } else {
            root.utf8 = utf8;
          }
        })(this);
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, {}], 30: [function (_dereq_, module, exports) {
      "use strict";
      var alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_".split(""),
          length = 64,
          map = {},
          seed = 0,
          i = 0,
          prev;function encode(num) {
        var encoded = "";do {
          encoded = alphabet[num % length] + encoded;num = Math.floor(num / length);
        } while (num > 0);return encoded;
      }function decode(str) {
        var decoded = 0;for (i = 0; i < str.length; i++) {
          decoded = decoded * length + map[str.charAt(i)];
        }return decoded;
      }function yeast() {
        var now = encode(+new Date());if (now !== prev) return seed = 0, prev = now;return now + "." + encode(seed++);
      }for (; i < length; i++) {
        map[alphabet[i]] = i;
      }yeast.encode = encode;yeast.decode = decode;module.exports = yeast;
    }, {}], 31: [function (_dereq_, module, exports) {
      var url = _dereq_("./url");var parser = _dereq_("socket.io-parser");var Manager = _dereq_("./manager");var debug = _dereq_("debug")("socket.io-client");module.exports = exports = lookup;var cache = exports.managers = {};function lookup(uri, opts) {
        if ((typeof uri === "undefined" ? "undefined" : _typeof(uri)) == "object") {
          opts = uri;uri = undefined;
        }opts = opts || {};var parsed = url(uri);var source = parsed.source;var id = parsed.id;var path = parsed.path;var sameNamespace = cache[id] && path in cache[id].nsps;var newConnection = opts.forceNew || opts["force new connection"] || false === opts.multiplex || sameNamespace;var io;if (newConnection) {
          debug("ignoring socket cache for %s", source);io = Manager(source, opts);
        } else {
          if (!cache[id]) {
            debug("new io instance for %s", source);cache[id] = Manager(source, opts);
          }io = cache[id];
        }return io.socket(parsed.path);
      }exports.protocol = parser.protocol;exports.connect = lookup;exports.Manager = _dereq_("./manager");exports.Socket = _dereq_("./socket");
    }, { "./manager": 32, "./socket": 34, "./url": 35, debug: 39, "socket.io-parser": 47 }], 32: [function (_dereq_, module, exports) {
      var eio = _dereq_("engine.io-client");var Socket = _dereq_("./socket");var Emitter = _dereq_("component-emitter");var parser = _dereq_("socket.io-parser");var on = _dereq_("./on");var bind = _dereq_("component-bind");var debug = _dereq_("debug")("socket.io-client:manager");var indexOf = _dereq_("indexof");var Backoff = _dereq_("backo2");var has = Object.prototype.hasOwnProperty;module.exports = Manager;function Manager(uri, opts) {
        if (!(this instanceof Manager)) return new Manager(uri, opts);if (uri && "object" == (typeof uri === "undefined" ? "undefined" : _typeof(uri))) {
          opts = uri;uri = undefined;
        }opts = opts || {};opts.path = opts.path || "/socket.io";this.nsps = {};this.subs = [];this.opts = opts;this.reconnection(opts.reconnection !== false);this.reconnectionAttempts(opts.reconnectionAttempts || Infinity);this.reconnectionDelay(opts.reconnectionDelay || 1e3);this.reconnectionDelayMax(opts.reconnectionDelayMax || 5e3);this.randomizationFactor(opts.randomizationFactor || .5);this.backoff = new Backoff({ min: this.reconnectionDelay(), max: this.reconnectionDelayMax(), jitter: this.randomizationFactor() });this.timeout(null == opts.timeout ? 2e4 : opts.timeout);this.readyState = "closed";this.uri = uri;this.connecting = [];this.lastPing = null;this.encoding = false;this.packetBuffer = [];this.encoder = new parser.Encoder();this.decoder = new parser.Decoder();this.autoConnect = opts.autoConnect !== false;if (this.autoConnect) this.open();
      }Manager.prototype.emitAll = function () {
        this.emit.apply(this, arguments);for (var nsp in this.nsps) {
          if (has.call(this.nsps, nsp)) {
            this.nsps[nsp].emit.apply(this.nsps[nsp], arguments);
          }
        }
      };Manager.prototype.updateSocketIds = function () {
        for (var nsp in this.nsps) {
          if (has.call(this.nsps, nsp)) {
            this.nsps[nsp].id = this.engine.id;
          }
        }
      };Emitter(Manager.prototype);Manager.prototype.reconnection = function (v) {
        if (!arguments.length) return this._reconnection;this._reconnection = !!v;return this;
      };Manager.prototype.reconnectionAttempts = function (v) {
        if (!arguments.length) return this._reconnectionAttempts;this._reconnectionAttempts = v;return this;
      };Manager.prototype.reconnectionDelay = function (v) {
        if (!arguments.length) return this._reconnectionDelay;this._reconnectionDelay = v;this.backoff && this.backoff.setMin(v);return this;
      };Manager.prototype.randomizationFactor = function (v) {
        if (!arguments.length) return this._randomizationFactor;this._randomizationFactor = v;this.backoff && this.backoff.setJitter(v);return this;
      };Manager.prototype.reconnectionDelayMax = function (v) {
        if (!arguments.length) return this._reconnectionDelayMax;this._reconnectionDelayMax = v;this.backoff && this.backoff.setMax(v);return this;
      };Manager.prototype.timeout = function (v) {
        if (!arguments.length) return this._timeout;this._timeout = v;return this;
      };Manager.prototype.maybeReconnectOnOpen = function () {
        if (!this.reconnecting && this._reconnection && this.backoff.attempts === 0) {
          this.reconnect();
        }
      };Manager.prototype.open = Manager.prototype.connect = function (fn) {
        debug("readyState %s", this.readyState);if (~this.readyState.indexOf("open")) return this;debug("opening %s", this.uri);this.engine = eio(this.uri, this.opts);var socket = this.engine;var self = this;this.readyState = "opening";this.skipReconnect = false;var openSub = on(socket, "open", function () {
          self.onopen();fn && fn();
        });var errorSub = on(socket, "error", function (data) {
          debug("connect_error");self.cleanup();self.readyState = "closed";self.emitAll("connect_error", data);if (fn) {
            var err = new Error("Connection error");err.data = data;fn(err);
          } else {
            self.maybeReconnectOnOpen();
          }
        });if (false !== this._timeout) {
          var timeout = this._timeout;debug("connect attempt will timeout after %d", timeout);var timer = setTimeout(function () {
            debug("connect attempt timed out after %d", timeout);openSub.destroy();socket.close();socket.emit("error", "timeout");self.emitAll("connect_timeout", timeout);
          }, timeout);this.subs.push({ destroy: function destroy() {
              clearTimeout(timer);
            } });
        }this.subs.push(openSub);this.subs.push(errorSub);return this;
      };Manager.prototype.onopen = function () {
        debug("open");this.cleanup();this.readyState = "open";this.emit("open");var socket = this.engine;this.subs.push(on(socket, "data", bind(this, "ondata")));this.subs.push(on(socket, "ping", bind(this, "onping")));this.subs.push(on(socket, "pong", bind(this, "onpong")));this.subs.push(on(socket, "error", bind(this, "onerror")));this.subs.push(on(socket, "close", bind(this, "onclose")));this.subs.push(on(this.decoder, "decoded", bind(this, "ondecoded")));
      };Manager.prototype.onping = function () {
        this.lastPing = new Date();this.emitAll("ping");
      };Manager.prototype.onpong = function () {
        this.emitAll("pong", new Date() - this.lastPing);
      };Manager.prototype.ondata = function (data) {
        this.decoder.add(data);
      };Manager.prototype.ondecoded = function (packet) {
        this.emit("packet", packet);
      };Manager.prototype.onerror = function (err) {
        debug("error", err);this.emitAll("error", err);
      };Manager.prototype.socket = function (nsp) {
        var socket = this.nsps[nsp];if (!socket) {
          socket = new Socket(this, nsp);this.nsps[nsp] = socket;var self = this;socket.on("connecting", onConnecting);
          socket.on("connect", function () {
            socket.id = self.engine.id;
          });if (this.autoConnect) {
            onConnecting();
          }
        }function onConnecting() {
          if (!~indexOf(self.connecting, socket)) {
            self.connecting.push(socket);
          }
        }return socket;
      };Manager.prototype.destroy = function (socket) {
        var index = indexOf(this.connecting, socket);if (~index) this.connecting.splice(index, 1);if (this.connecting.length) return;this.close();
      };Manager.prototype.packet = function (packet) {
        debug("writing packet %j", packet);var self = this;if (!self.encoding) {
          self.encoding = true;this.encoder.encode(packet, function (encodedPackets) {
            for (var i = 0; i < encodedPackets.length; i++) {
              self.engine.write(encodedPackets[i], packet.options);
            }self.encoding = false;self.processPacketQueue();
          });
        } else {
          self.packetBuffer.push(packet);
        }
      };Manager.prototype.processPacketQueue = function () {
        if (this.packetBuffer.length > 0 && !this.encoding) {
          var pack = this.packetBuffer.shift();this.packet(pack);
        }
      };Manager.prototype.cleanup = function () {
        debug("cleanup");var sub;while (sub = this.subs.shift()) {
          sub.destroy();
        }this.packetBuffer = [];this.encoding = false;this.lastPing = null;this.decoder.destroy();
      };Manager.prototype.close = Manager.prototype.disconnect = function () {
        debug("disconnect");this.skipReconnect = true;this.reconnecting = false;if ("opening" == this.readyState) {
          this.cleanup();
        }this.backoff.reset();this.readyState = "closed";if (this.engine) this.engine.close();
      };Manager.prototype.onclose = function (reason) {
        debug("onclose");this.cleanup();this.backoff.reset();this.readyState = "closed";this.emit("close", reason);if (this._reconnection && !this.skipReconnect) {
          this.reconnect();
        }
      };Manager.prototype.reconnect = function () {
        if (this.reconnecting || this.skipReconnect) return this;var self = this;if (this.backoff.attempts >= this._reconnectionAttempts) {
          debug("reconnect failed");this.backoff.reset();this.emitAll("reconnect_failed");this.reconnecting = false;
        } else {
          var delay = this.backoff.duration();debug("will wait %dms before reconnect attempt", delay);this.reconnecting = true;var timer = setTimeout(function () {
            if (self.skipReconnect) return;debug("attempting reconnect");self.emitAll("reconnect_attempt", self.backoff.attempts);self.emitAll("reconnecting", self.backoff.attempts);if (self.skipReconnect) return;self.open(function (err) {
              if (err) {
                debug("reconnect attempt error");self.reconnecting = false;self.reconnect();self.emitAll("reconnect_error", err.data);
              } else {
                debug("reconnect success");self.onreconnect();
              }
            });
          }, delay);this.subs.push({ destroy: function destroy() {
              clearTimeout(timer);
            } });
        }
      };Manager.prototype.onreconnect = function () {
        var attempt = this.backoff.attempts;this.reconnecting = false;this.backoff.reset();this.updateSocketIds();this.emitAll("reconnect", attempt);
      };
    }, { "./on": 33, "./socket": 34, backo2: 36, "component-bind": 37, "component-emitter": 38, debug: 39, "engine.io-client": 1, indexof: 42, "socket.io-parser": 47 }], 33: [function (_dereq_, module, exports) {
      module.exports = on;function on(obj, ev, fn) {
        obj.on(ev, fn);return { destroy: function destroy() {
            obj.removeListener(ev, fn);
          } };
      }
    }, {}], 34: [function (_dereq_, module, exports) {
      var parser = _dereq_("socket.io-parser");var Emitter = _dereq_("component-emitter");var toArray = _dereq_("to-array");var on = _dereq_("./on");var bind = _dereq_("component-bind");var debug = _dereq_("debug")("socket.io-client:socket");var hasBin = _dereq_("has-binary");module.exports = exports = Socket;var events = { connect: 1, connect_error: 1, connect_timeout: 1, connecting: 1, disconnect: 1, error: 1, reconnect: 1, reconnect_attempt: 1, reconnect_failed: 1, reconnect_error: 1, reconnecting: 1, ping: 1, pong: 1 };var emit = Emitter.prototype.emit;function Socket(io, nsp) {
        this.io = io;this.nsp = nsp;this.json = this;this.ids = 0;this.acks = {};this.receiveBuffer = [];this.sendBuffer = [];this.connected = false;this.disconnected = true;if (this.io.autoConnect) this.open();
      }Emitter(Socket.prototype);Socket.prototype.subEvents = function () {
        if (this.subs) return;var io = this.io;this.subs = [on(io, "open", bind(this, "onopen")), on(io, "packet", bind(this, "onpacket")), on(io, "close", bind(this, "onclose"))];
      };Socket.prototype.open = Socket.prototype.connect = function () {
        if (this.connected) return this;this.subEvents();this.io.open();if ("open" == this.io.readyState) this.onopen();this.emit("connecting");return this;
      };Socket.prototype.send = function () {
        var args = toArray(arguments);args.unshift("message");this.emit.apply(this, args);return this;
      };Socket.prototype.emit = function (ev) {
        if (events.hasOwnProperty(ev)) {
          emit.apply(this, arguments);return this;
        }var args = toArray(arguments);var parserType = parser.EVENT;if (hasBin(args)) {
          parserType = parser.BINARY_EVENT;
        }var packet = { type: parserType, data: args };packet.options = {};packet.options.compress = !this.flags || false !== this.flags.compress;if ("function" == typeof args[args.length - 1]) {
          debug("emitting packet with ack id %d", this.ids);this.acks[this.ids] = args.pop();packet.id = this.ids++;
        }if (this.connected) {
          this.packet(packet);
        } else {
          this.sendBuffer.push(packet);
        }delete this.flags;return this;
      };Socket.prototype.packet = function (packet) {
        packet.nsp = this.nsp;this.io.packet(packet);
      };Socket.prototype.onopen = function () {
        debug("transport is open - connecting");if ("/" != this.nsp) {
          this.packet({ type: parser.CONNECT });
        }
      };Socket.prototype.onclose = function (reason) {
        debug("close (%s)", reason);this.connected = false;this.disconnected = true;delete this.id;this.emit("disconnect", reason);
      };Socket.prototype.onpacket = function (packet) {
        if (packet.nsp != this.nsp) return;switch (packet.type) {case parser.CONNECT:
            this.onconnect();break;case parser.EVENT:
            this.onevent(packet);break;case parser.BINARY_EVENT:
            this.onevent(packet);break;case parser.ACK:
            this.onack(packet);break;case parser.BINARY_ACK:
            this.onack(packet);break;case parser.DISCONNECT:
            this.ondisconnect();break;case parser.ERROR:
            this.emit("error", packet.data);break;}
      };Socket.prototype.onevent = function (packet) {
        var args = packet.data || [];debug("emitting event %j", args);if (null != packet.id) {
          debug("attaching ack callback to event");args.push(this.ack(packet.id));
        }if (this.connected) {
          emit.apply(this, args);
        } else {
          this.receiveBuffer.push(args);
        }
      };Socket.prototype.ack = function (id) {
        var self = this;var sent = false;return function () {
          if (sent) return;sent = true;var args = toArray(arguments);debug("sending ack %j", args);var type = hasBin(args) ? parser.BINARY_ACK : parser.ACK;self.packet({ type: type, id: id, data: args });
        };
      };Socket.prototype.onack = function (packet) {
        var ack = this.acks[packet.id];if ("function" == typeof ack) {
          debug("calling ack %s with %j", packet.id, packet.data);ack.apply(this, packet.data);delete this.acks[packet.id];
        } else {
          debug("bad ack %s", packet.id);
        }
      };Socket.prototype.onconnect = function () {
        this.connected = true;this.disconnected = false;this.emit("connect");this.emitBuffered();
      };Socket.prototype.emitBuffered = function () {
        var i;for (i = 0; i < this.receiveBuffer.length; i++) {
          emit.apply(this, this.receiveBuffer[i]);
        }this.receiveBuffer = [];for (i = 0; i < this.sendBuffer.length; i++) {
          this.packet(this.sendBuffer[i]);
        }this.sendBuffer = [];
      };Socket.prototype.ondisconnect = function () {
        debug("server disconnect (%s)", this.nsp);this.destroy();this.onclose("io server disconnect");
      };Socket.prototype.destroy = function () {
        if (this.subs) {
          for (var i = 0; i < this.subs.length; i++) {
            this.subs[i].destroy();
          }this.subs = null;
        }this.io.destroy(this);
      };Socket.prototype.close = Socket.prototype.disconnect = function () {
        if (this.connected) {
          debug("performing disconnect (%s)", this.nsp);this.packet({ type: parser.DISCONNECT });
        }this.destroy();if (this.connected) {
          this.onclose("io client disconnect");
        }return this;
      };Socket.prototype.compress = function (compress) {
        this.flags = this.flags || {};this.flags.compress = compress;return this;
      };
    }, { "./on": 33, "component-bind": 37, "component-emitter": 38, debug: 39, "has-binary": 41, "socket.io-parser": 47, "to-array": 51 }], 35: [function (_dereq_, module, exports) {
      (function (global) {
        var parseuri = _dereq_("parseuri");var debug = _dereq_("debug")("socket.io-client:url");module.exports = url;function url(uri, loc) {
          var obj = uri;var loc = loc || global.location;if (null == uri) uri = loc.protocol + "//" + loc.host;if ("string" == typeof uri) {
            if ("/" == uri.charAt(0)) {
              if ("/" == uri.charAt(1)) {
                uri = loc.protocol + uri;
              } else {
                uri = loc.host + uri;
              }
            }if (!/^(https?|wss?):\/\//.test(uri)) {
              debug("protocol-less url %s", uri);if ("undefined" != typeof loc) {
                uri = loc.protocol + "//" + uri;
              } else {
                uri = "https://" + uri;
              }
            }debug("parse %s", uri);obj = parseuri(uri);
          }if (!obj.port) {
            if (/^(http|ws)$/.test(obj.protocol)) {
              obj.port = "80";
            } else if (/^(http|ws)s$/.test(obj.protocol)) {
              obj.port = "443";
            }
          }obj.path = obj.path || "/";var ipv6 = obj.host.indexOf(":") !== -1;var host = ipv6 ? "[" + obj.host + "]" : obj.host;obj.id = obj.protocol + "://" + host + ":" + obj.port;obj.href = obj.protocol + "://" + host + (loc && loc.port == obj.port ? "" : ":" + obj.port);return obj;
        }
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { debug: 39, parseuri: 45 }], 36: [function (_dereq_, module, exports) {
      module.exports = Backoff;function Backoff(opts) {
        opts = opts || {};this.ms = opts.min || 100;this.max = opts.max || 1e4;this.factor = opts.factor || 2;this.jitter = opts.jitter > 0 && opts.jitter <= 1 ? opts.jitter : 0;this.attempts = 0;
      }Backoff.prototype.duration = function () {
        var ms = this.ms * Math.pow(this.factor, this.attempts++);if (this.jitter) {
          var rand = Math.random();var deviation = Math.floor(rand * this.jitter * ms);ms = (Math.floor(rand * 10) & 1) == 0 ? ms - deviation : ms + deviation;
        }return Math.min(ms, this.max) | 0;
      };Backoff.prototype.reset = function () {
        this.attempts = 0;
      };Backoff.prototype.setMin = function (min) {
        this.ms = min;
      };Backoff.prototype.setMax = function (max) {
        this.max = max;
      };Backoff.prototype.setJitter = function (jitter) {
        this.jitter = jitter;
      };
    }, {}], 37: [function (_dereq_, module, exports) {
      var slice = [].slice;module.exports = function (obj, fn) {
        if ("string" == typeof fn) fn = obj[fn];if ("function" != typeof fn) throw new Error("bind() requires a function");var args = slice.call(arguments, 2);return function () {
          return fn.apply(obj, args.concat(slice.call(arguments)));
        };
      };
    }, {}], 38: [function (_dereq_, module, exports) {
      module.exports = Emitter;function Emitter(obj) {
        if (obj) return mixin(obj);
      }function mixin(obj) {
        for (var key in Emitter.prototype) {
          obj[key] = Emitter.prototype[key];
        }return obj;
      }Emitter.prototype.on = Emitter.prototype.addEventListener = function (event, fn) {
        this._callbacks = this._callbacks || {};(this._callbacks["$" + event] = this._callbacks["$" + event] || []).push(fn);return this;
      };Emitter.prototype.once = function (event, fn) {
        function on() {
          this.off(event, on);fn.apply(this, arguments);
        }on.fn = fn;this.on(event, on);return this;
      };Emitter.prototype.off = Emitter.prototype.removeListener = Emitter.prototype.removeAllListeners = Emitter.prototype.removeEventListener = function (event, fn) {
        this._callbacks = this._callbacks || {};if (0 == arguments.length) {
          this._callbacks = {};return this;
        }var callbacks = this._callbacks["$" + event];if (!callbacks) return this;if (1 == arguments.length) {
          delete this._callbacks["$" + event];return this;
        }var cb;for (var i = 0; i < callbacks.length; i++) {
          cb = callbacks[i];if (cb === fn || cb.fn === fn) {
            callbacks.splice(i, 1);break;
          }
        }return this;
      };Emitter.prototype.emit = function (event) {
        this._callbacks = this._callbacks || {};var args = [].slice.call(arguments, 1),
            callbacks = this._callbacks["$" + event];if (callbacks) {
          callbacks = callbacks.slice(0);for (var i = 0, len = callbacks.length; i < len; ++i) {
            callbacks[i].apply(this, args);
          }
        }return this;
      };Emitter.prototype.listeners = function (event) {
        this._callbacks = this._callbacks || {};return this._callbacks["$" + event] || [];
      };Emitter.prototype.hasListeners = function (event) {
        return !!this.listeners(event).length;
      };
    }, {}], 39: [function (_dereq_, module, exports) {
      arguments[4][17][0].apply(exports, arguments);
    }, { "./debug": 40, dup: 17 }], 40: [function (_dereq_, module, exports) {
      arguments[4][18][0].apply(exports, arguments);
    }, { dup: 18, ms: 44 }], 41: [function (_dereq_, module, exports) {
      (function (global) {
        var isArray = _dereq_("isarray");module.exports = hasBinary;function hasBinary(data) {
          function _hasBinary(obj) {
            if (!obj) return false;if (global.Buffer && global.Buffer.isBuffer && global.Buffer.isBuffer(obj) || global.ArrayBuffer && obj instanceof ArrayBuffer || global.Blob && obj instanceof Blob || global.File && obj instanceof File) {
              return true;
            }if (isArray(obj)) {
              for (var i = 0; i < obj.length; i++) {
                if (_hasBinary(obj[i])) {
                  return true;
                }
              }
            } else if (obj && "object" == (typeof obj === "undefined" ? "undefined" : _typeof(obj))) {
              if (obj.toJSON && "function" == typeof obj.toJSON) {
                obj = obj.toJSON();
              }for (var key in obj) {
                if (Object.prototype.hasOwnProperty.call(obj, key) && _hasBinary(obj[key])) {
                  return true;
                }
              }
            }return false;
          }return _hasBinary(data);
        }
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { isarray: 43 }], 42: [function (_dereq_, module, exports) {
      arguments[4][23][0].apply(exports, arguments);
    }, { dup: 23 }], 43: [function (_dereq_, module, exports) {
      arguments[4][24][0].apply(exports, arguments);
    }, { dup: 24 }], 44: [function (_dereq_, module, exports) {
      arguments[4][25][0].apply(exports, arguments);
    }, { dup: 25 }], 45: [function (_dereq_, module, exports) {
      arguments[4][28][0].apply(exports, arguments);
    }, { dup: 28 }], 46: [function (_dereq_, module, exports) {
      (function (global) {
        var isArray = _dereq_("isarray");var isBuf = _dereq_("./is-buffer");exports.deconstructPacket = function (packet) {
          var buffers = [];var packetData = packet.data;function _deconstructPacket(data) {
            if (!data) return data;if (isBuf(data)) {
              var placeholder = { _placeholder: true, num: buffers.length };buffers.push(data);return placeholder;
            } else if (isArray(data)) {
              var newData = new Array(data.length);for (var i = 0; i < data.length; i++) {
                newData[i] = _deconstructPacket(data[i]);
              }return newData;
            } else if ("object" == (typeof data === "undefined" ? "undefined" : _typeof(data)) && !(data instanceof Date)) {
              var newData = {};for (var key in data) {
                newData[key] = _deconstructPacket(data[key]);
              }return newData;
            }return data;
          }var pack = packet;pack.data = _deconstructPacket(packetData);pack.attachments = buffers.length;return { packet: pack, buffers: buffers };
        };exports.reconstructPacket = function (packet, buffers) {
          var curPlaceHolder = 0;function _reconstructPacket(data) {
            if (data && data._placeholder) {
              var buf = buffers[data.num];return buf;
            } else if (isArray(data)) {
              for (var i = 0; i < data.length; i++) {
                data[i] = _reconstructPacket(data[i]);
              }return data;
            } else if (data && "object" == (typeof data === "undefined" ? "undefined" : _typeof(data))) {
              for (var key in data) {
                data[key] = _reconstructPacket(data[key]);
              }return data;
            }return data;
          }packet.data = _reconstructPacket(packet.data);packet.attachments = undefined;return packet;
        };exports.removeBlobs = function (data, callback) {
          function _removeBlobs(obj, curKey, containingObject) {
            if (!obj) return obj;if (global.Blob && obj instanceof Blob || global.File && obj instanceof File) {
              pendingBlobs++;var fileReader = new FileReader();fileReader.onload = function () {
                if (containingObject) {
                  containingObject[curKey] = this.result;
                } else {
                  bloblessData = this.result;
                }if (! --pendingBlobs) {
                  callback(bloblessData);
                }
              };fileReader.readAsArrayBuffer(obj);
            } else if (isArray(obj)) {
              for (var i = 0; i < obj.length; i++) {
                _removeBlobs(obj[i], i, obj);
              }
            } else if (obj && "object" == (typeof obj === "undefined" ? "undefined" : _typeof(obj)) && !isBuf(obj)) {
              for (var key in obj) {
                _removeBlobs(obj[key], key, obj);
              }
            }
          }var pendingBlobs = 0;var bloblessData = data;_removeBlobs(bloblessData);if (!pendingBlobs) {
            callback(bloblessData);
          }
        };
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, { "./is-buffer": 48, isarray: 43 }], 47: [function (_dereq_, module, exports) {
      var debug = _dereq_("debug")("socket.io-parser");var json = _dereq_("json3");var isArray = _dereq_("isarray");var Emitter = _dereq_("component-emitter");var binary = _dereq_("./binary");var isBuf = _dereq_("./is-buffer");exports.protocol = 4;exports.types = ["CONNECT", "DISCONNECT", "EVENT", "BINARY_EVENT", "ACK", "BINARY_ACK", "ERROR"];exports.CONNECT = 0;exports.DISCONNECT = 1;exports.EVENT = 2;exports.ACK = 3;exports.ERROR = 4;exports.BINARY_EVENT = 5;exports.BINARY_ACK = 6;exports.Encoder = Encoder;exports.Decoder = Decoder;function Encoder() {}Encoder.prototype.encode = function (obj, callback) {
        debug("encoding packet %j", obj);if (exports.BINARY_EVENT == obj.type || exports.BINARY_ACK == obj.type) {
          encodeAsBinary(obj, callback);
        } else {
          var encoding = encodeAsString(obj);callback([encoding]);
        }
      };function encodeAsString(obj) {
        var str = "";var nsp = false;str += obj.type;if (exports.BINARY_EVENT == obj.type || exports.BINARY_ACK == obj.type) {
          str += obj.attachments;str += "-";
        }if (obj.nsp && "/" != obj.nsp) {
          nsp = true;str += obj.nsp;
        }if (null != obj.id) {
          if (nsp) {
            str += ",";nsp = false;
          }str += obj.id;
        }if (null != obj.data) {
          if (nsp) str += ",";str += json.stringify(obj.data);
        }debug("encoded %j as %s", obj, str);return str;
      }function encodeAsBinary(obj, callback) {
        function writeEncoding(bloblessData) {
          var deconstruction = binary.deconstructPacket(bloblessData);var pack = encodeAsString(deconstruction.packet);var buffers = deconstruction.buffers;buffers.unshift(pack);callback(buffers);
        }binary.removeBlobs(obj, writeEncoding);
      }function Decoder() {
        this.reconstructor = null;
      }Emitter(Decoder.prototype);Decoder.prototype.add = function (obj) {
        var packet;if ("string" == typeof obj) {
          packet = decodeString(obj);if (exports.BINARY_EVENT == packet.type || exports.BINARY_ACK == packet.type) {
            this.reconstructor = new BinaryReconstructor(packet);if (this.reconstructor.reconPack.attachments === 0) {
              this.emit("decoded", packet);
            }
          } else {
            this.emit("decoded", packet);
          }
        } else if (isBuf(obj) || obj.base64) {
          if (!this.reconstructor) {
            throw new Error("got binary data when not reconstructing a packet");
          } else {
            packet = this.reconstructor.takeBinaryData(obj);if (packet) {
              this.reconstructor = null;this.emit("decoded", packet);
            }
          }
        } else {
          throw new Error("Unknown type: " + obj);
        }
      };function decodeString(str) {
        var p = {};var i = 0;p.type = Number(str.charAt(0));if (null == exports.types[p.type]) return error();if (exports.BINARY_EVENT == p.type || exports.BINARY_ACK == p.type) {
          var buf = "";while (str.charAt(++i) != "-") {
            buf += str.charAt(i);if (i == str.length) break;
          }if (buf != Number(buf) || str.charAt(i) != "-") {
            throw new Error("Illegal attachments");
          }p.attachments = Number(buf);
        }if ("/" == str.charAt(i + 1)) {
          p.nsp = "";while (++i) {
            var c = str.charAt(i);if ("," == c) break;p.nsp += c;if (i == str.length) break;
          }
        } else {
          p.nsp = "/";
        }var next = str.charAt(i + 1);if ("" !== next && Number(next) == next) {
          p.id = "";while (++i) {
            var c = str.charAt(i);if (null == c || Number(c) != c) {
              --i;break;
            }p.id += str.charAt(i);if (i == str.length) break;
          }p.id = Number(p.id);
        }if (str.charAt(++i)) {
          try {
            p.data = json.parse(str.substr(i));
          } catch (e) {
            return error();
          }
        }debug("decoded %s as %j", str, p);return p;
      }Decoder.prototype.destroy = function () {
        if (this.reconstructor) {
          this.reconstructor.finishedReconstruction();
        }
      };function BinaryReconstructor(packet) {
        this.reconPack = packet;this.buffers = [];
      }BinaryReconstructor.prototype.takeBinaryData = function (binData) {
        this.buffers.push(binData);if (this.buffers.length == this.reconPack.attachments) {
          var packet = binary.reconstructPacket(this.reconPack, this.buffers);this.finishedReconstruction();return packet;
        }return null;
      };BinaryReconstructor.prototype.finishedReconstruction = function () {
        this.reconPack = null;this.buffers = [];
      };function error(data) {
        return { type: exports.ERROR, data: "parser error" };
      }
    }, { "./binary": 46, "./is-buffer": 48, "component-emitter": 49, debug: 39, isarray: 43, json3: 50 }], 48: [function (_dereq_, module, exports) {
      (function (global) {
        module.exports = isBuf;function isBuf(obj) {
          return global.Buffer && global.Buffer.isBuffer(obj) || global.ArrayBuffer && obj instanceof ArrayBuffer;
        }
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, {}], 49: [function (_dereq_, module, exports) {
      arguments[4][15][0].apply(exports, arguments);
    }, { dup: 15 }], 50: [function (_dereq_, module, exports) {
      (function (global) {
        (function () {
          var isLoader = typeof define === "function" && define.amd;var objectTypes = { "function": true, object: true };var freeExports = objectTypes[typeof exports === "undefined" ? "undefined" : _typeof(exports)] && exports && !exports.nodeType && exports;var root = objectTypes[typeof window === "undefined" ? "undefined" : _typeof(window)] && window || this,
              freeGlobal = freeExports && objectTypes[typeof module === "undefined" ? "undefined" : _typeof(module)] && module && !module.nodeType && (typeof global === "undefined" ? "undefined" : _typeof(global)) == "object" && global;if (freeGlobal && (freeGlobal["global"] === freeGlobal || freeGlobal["window"] === freeGlobal || freeGlobal["self"] === freeGlobal)) {
            root = freeGlobal;
          }function runInContext(context, exports) {
            context || (context = root["Object"]());exports || (exports = root["Object"]());var Number = context["Number"] || root["Number"],
                String = context["String"] || root["String"],
                Object = context["Object"] || root["Object"],
                Date = context["Date"] || root["Date"],
                SyntaxError = context["SyntaxError"] || root["SyntaxError"],
                TypeError = context["TypeError"] || root["TypeError"],
                Math = context["Math"] || root["Math"],
                nativeJSON = context["JSON"] || root["JSON"];if ((typeof nativeJSON === "undefined" ? "undefined" : _typeof(nativeJSON)) == "object" && nativeJSON) {
              exports.stringify = nativeJSON.stringify;exports.parse = nativeJSON.parse;
            }var objectProto = Object.prototype,
                getClass = objectProto.toString,
                _isProperty,
                _forEach,
                undef;var isExtended = new Date(-0xc782b5b800cec);try {
              isExtended = isExtended.getUTCFullYear() == -109252 && isExtended.getUTCMonth() === 0 && isExtended.getUTCDate() === 1 && isExtended.getUTCHours() == 10 && isExtended.getUTCMinutes() == 37 && isExtended.getUTCSeconds() == 6 && isExtended.getUTCMilliseconds() == 708;
            } catch (exception) {}function has(name) {
              if (has[name] !== undef) {
                return has[name];
              }var isSupported;if (name == "bug-string-char-index") {
                isSupported = "a"[0] != "a";
              } else if (name == "json") {
                isSupported = has("json-stringify") && has("json-parse");
              } else {
                var value,
                    serialized = "{\"a\":[1,true,false,null,\"\\u0000\\b\\n\\f\\r\\t\"]}";if (name == "json-stringify") {
                  var stringify = exports.stringify,
                      stringifySupported = typeof stringify == "function" && isExtended;if (stringifySupported) {
                    (value = function value() {
                      return 1;
                    }).toJSON = value;try {
                      stringifySupported = stringify(0) === "0" && stringify(new Number()) === "0" && stringify(new String()) == '""' && stringify(getClass) === undef && stringify(undef) === undef && stringify() === undef && stringify(value) === "1" && stringify([value]) == "[1]" && stringify([undef]) == "[null]" && stringify(null) == "null" && stringify([undef, getClass, null]) == "[null,null,null]" && stringify({ a: [value, true, false, null, "\x00\b\n\f\r	"] }) == serialized && stringify(null, value) === "1" && stringify([1, 2], null, 1) == "[\n 1,\n 2\n]" && stringify(new Date(-864e13)) == '"-271821-04-20T00:00:00.000Z"' && stringify(new Date(864e13)) == '"+275760-09-13T00:00:00.000Z"' && stringify(new Date(-621987552e5)) == '"-000001-01-01T00:00:00.000Z"' && stringify(new Date(-1)) == '"1969-12-31T23:59:59.999Z"';
                    } catch (exception) {
                      stringifySupported = false;
                    }
                  }isSupported = stringifySupported;
                }if (name == "json-parse") {
                  var parse = exports.parse;if (typeof parse == "function") {
                    try {
                      if (parse("0") === 0 && !parse(false)) {
                        value = parse(serialized);var parseSupported = value["a"].length == 5 && value["a"][0] === 1;if (parseSupported) {
                          try {
                            parseSupported = !parse('"	"');
                          } catch (exception) {}if (parseSupported) {
                            try {
                              parseSupported = parse("01") !== 1;
                            } catch (exception) {}
                          }if (parseSupported) {
                            try {
                              parseSupported = parse("1.") !== 1;
                            } catch (exception) {}
                          }
                        }
                      }
                    } catch (exception) {
                      parseSupported = false;
                    }
                  }isSupported = parseSupported;
                }
              }return has[name] = !!isSupported;
            }if (!has("json")) {
              var functionClass = "[object Function]",
                  dateClass = "[object Date]",
                  numberClass = "[object Number]",
                  stringClass = "[object String]",
                  arrayClass = "[object Array]",
                  booleanClass = "[object Boolean]";var charIndexBuggy = has("bug-string-char-index");if (!isExtended) {
                var floor = Math.floor;var Months = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];var getDay = function getDay(year, month) {
                  return Months[month] + 365 * (year - 1970) + floor((year - 1969 + (month = +(month > 1))) / 4) - floor((year - 1901 + month) / 100) + floor((year - 1601 + month) / 400);
                };
              }if (!(_isProperty = objectProto.hasOwnProperty)) {
                _isProperty = function isProperty(property) {
                  var members = {},
                      constructor;if ((members.__proto__ = null, members.__proto__ = { toString: 1 }, members).toString != getClass) {
                    _isProperty = function isProperty(property) {
                      var original = this.__proto__,
                          result = property in (this.__proto__ = null, this);this.__proto__ = original;return result;
                    };
                  } else {
                    constructor = members.constructor;_isProperty = function isProperty(property) {
                      var parent = (this.constructor || constructor).prototype;return property in this && !(property in parent && this[property] === parent[property]);
                    };
                  }members = null;return _isProperty.call(this, property);
                };
              }_forEach = function forEach(object, callback) {
                var size = 0,
                    Properties,
                    members,
                    property;(Properties = function Properties() {
                  this.valueOf = 0;
                }).prototype.valueOf = 0;members = new Properties();for (property in members) {
                  if (_isProperty.call(members, property)) {
                    size++;
                  }
                }Properties = members = null;if (!size) {
                  members = ["valueOf", "toString", "toLocaleString", "propertyIsEnumerable", "isPrototypeOf", "hasOwnProperty", "constructor"];_forEach = function forEach(object, callback) {
                    var isFunction = getClass.call(object) == functionClass,
                        property,
                        length;var hasProperty = !isFunction && typeof object.constructor != "function" && objectTypes[_typeof(object.hasOwnProperty)] && object.hasOwnProperty || _isProperty;for (property in object) {
                      if (!(isFunction && property == "prototype") && hasProperty.call(object, property)) {
                        callback(property);
                      }
                    }for (length = members.length; property = members[--length]; hasProperty.call(object, property) && callback(property)) {}
                  };
                } else if (size == 2) {
                  _forEach = function forEach(object, callback) {
                    var members = {},
                        isFunction = getClass.call(object) == functionClass,
                        property;for (property in object) {
                      if (!(isFunction && property == "prototype") && !_isProperty.call(members, property) && (members[property] = 1) && _isProperty.call(object, property)) {
                        callback(property);
                      }
                    }
                  };
                } else {
                  _forEach = function forEach(object, callback) {
                    var isFunction = getClass.call(object) == functionClass,
                        property,
                        isConstructor;for (property in object) {
                      if (!(isFunction && property == "prototype") && _isProperty.call(object, property) && !(isConstructor = property === "constructor")) {
                        callback(property);
                      }
                    }if (isConstructor || _isProperty.call(object, property = "constructor")) {
                      callback(property);
                    }
                  };
                }return _forEach(object, callback);
              };if (!has("json-stringify")) {
                var Escapes = { 92: "\\\\", 34: '\\"', 8: "\\b", 12: "\\f", 10: "\\n", 13: "\\r", 9: "\\t" };var leadingZeroes = "000000";var toPaddedString = function toPaddedString(width, value) {
                  return (leadingZeroes + (value || 0)).slice(-width);
                };var unicodePrefix = "\\u00";var quote = function quote(value) {
                  var result = '"',
                      index = 0,
                      length = value.length,
                      useCharIndex = !charIndexBuggy || length > 10;var symbols = useCharIndex && (charIndexBuggy ? value.split("") : value);for (; index < length; index++) {
                    var charCode = value.charCodeAt(index);switch (charCode) {case 8:case 9:case 10:case 12:case 13:case 34:case 92:
                        result += Escapes[charCode];break;default:
                        if (charCode < 32) {
                          result += unicodePrefix + toPaddedString(2, charCode.toString(16));break;
                        }result += useCharIndex ? symbols[index] : value.charAt(index);}
                  }return result + '"';
                };var serialize = function serialize(property, object, callback, properties, whitespace, indentation, stack) {
                  var value, className, year, month, date, time, hours, minutes, seconds, milliseconds, results, element, index, length, prefix, result;try {
                    value = object[property];
                  } catch (exception) {}if ((typeof value === "undefined" ? "undefined" : _typeof(value)) == "object" && value) {
                    className = getClass.call(value);if (className == dateClass && !_isProperty.call(value, "toJSON")) {
                      if (value > -1 / 0 && value < 1 / 0) {
                        if (getDay) {
                          date = floor(value / 864e5);for (year = floor(date / 365.2425) + 1970 - 1; getDay(year + 1, 0) <= date; year++) {}for (month = floor((date - getDay(year, 0)) / 30.42); getDay(year, month + 1) <= date; month++) {}date = 1 + date - getDay(year, month);time = (value % 864e5 + 864e5) % 864e5;hours = floor(time / 36e5) % 24;minutes = floor(time / 6e4) % 60;seconds = floor(time / 1e3) % 60;milliseconds = time % 1e3;
                        } else {
                          year = value.getUTCFullYear();month = value.getUTCMonth();date = value.getUTCDate();hours = value.getUTCHours();minutes = value.getUTCMinutes();seconds = value.getUTCSeconds();milliseconds = value.getUTCMilliseconds();
                        }value = (year <= 0 || year >= 1e4 ? (year < 0 ? "-" : "+") + toPaddedString(6, year < 0 ? -year : year) : toPaddedString(4, year)) + "-" + toPaddedString(2, month + 1) + "-" + toPaddedString(2, date) + "T" + toPaddedString(2, hours) + ":" + toPaddedString(2, minutes) + ":" + toPaddedString(2, seconds) + "." + toPaddedString(3, milliseconds) + "Z";
                      } else {
                        value = null;
                      }
                    } else if (typeof value.toJSON == "function" && (className != numberClass && className != stringClass && className != arrayClass || _isProperty.call(value, "toJSON"))) {
                      value = value.toJSON(property);
                    }
                  }if (callback) {
                    value = callback.call(object, property, value);
                  }if (value === null) {
                    return "null";
                  }className = getClass.call(value);if (className == booleanClass) {
                    return "" + value;
                  } else if (className == numberClass) {
                    return value > -1 / 0 && value < 1 / 0 ? "" + value : "null";
                  } else if (className == stringClass) {
                    return quote("" + value);
                  }if ((typeof value === "undefined" ? "undefined" : _typeof(value)) == "object") {
                    for (length = stack.length; length--;) {
                      if (stack[length] === value) {
                        throw TypeError();
                      }
                    }stack.push(value);results = [];prefix = indentation;indentation += whitespace;if (className == arrayClass) {
                      for (index = 0, length = value.length; index < length; index++) {
                        element = serialize(index, value, callback, properties, whitespace, indentation, stack);results.push(element === undef ? "null" : element);
                      }result = results.length ? whitespace ? "[\n" + indentation + results.join(",\n" + indentation) + "\n" + prefix + "]" : "[" + results.join(",") + "]" : "[]";
                    } else {
                      _forEach(properties || value, function (property) {
                        var element = serialize(property, value, callback, properties, whitespace, indentation, stack);if (element !== undef) {
                          results.push(quote(property) + ":" + (whitespace ? " " : "") + element);
                        }
                      });result = results.length ? whitespace ? "{\n" + indentation + results.join(",\n" + indentation) + "\n" + prefix + "}" : "{" + results.join(",") + "}" : "{}";
                    }stack.pop();return result;
                  }
                };exports.stringify = function (source, filter, width) {
                  var whitespace, callback, properties, className;if (objectTypes[typeof filter === "undefined" ? "undefined" : _typeof(filter)] && filter) {
                    if ((className = getClass.call(filter)) == functionClass) {
                      callback = filter;
                    } else if (className == arrayClass) {
                      properties = {};for (var index = 0, length = filter.length, value; index < length; value = filter[index++], (className = getClass.call(value), className == stringClass || className == numberClass) && (properties[value] = 1)) {}
                    }
                  }if (width) {
                    if ((className = getClass.call(width)) == numberClass) {
                      if ((width -= width % 1) > 0) {
                        for (whitespace = "", width > 10 && (width = 10); whitespace.length < width; whitespace += " ") {}
                      }
                    } else if (className == stringClass) {
                      whitespace = width.length <= 10 ? width : width.slice(0, 10);
                    }
                  }return serialize("", (value = {}, value[""] = source, value), callback, properties, whitespace, "", []);
                };
              }if (!has("json-parse")) {
                var fromCharCode = String.fromCharCode;var Unescapes = { 92: "\\", 34: '"', 47: "/", 98: "\b", 116: "	", 110: "\n", 102: "\f", 114: "\r" };var Index, Source;var abort = function abort() {
                  Index = Source = null;throw SyntaxError();
                };var lex = function lex() {
                  var source = Source,
                      length = source.length,
                      value,
                      begin,
                      position,
                      isSigned,
                      charCode;while (Index < length) {
                    charCode = source.charCodeAt(Index);switch (charCode) {case 9:case 10:case 13:case 32:
                        Index++;break;case 123:case 125:case 91:case 93:case 58:case 44:
                        value = charIndexBuggy ? source.charAt(Index) : source[Index];Index++;return value;case 34:
                        for (value = "@", Index++; Index < length;) {
                          charCode = source.charCodeAt(Index);if (charCode < 32) {
                            abort();
                          } else if (charCode == 92) {
                            charCode = source.charCodeAt(++Index);switch (charCode) {case 92:case 34:case 47:case 98:case 116:case 110:case 102:case 114:
                                value += Unescapes[charCode];Index++;break;case 117:
                                begin = ++Index;for (position = Index + 4; Index < position; Index++) {
                                  charCode = source.charCodeAt(Index);if (!(charCode >= 48 && charCode <= 57 || charCode >= 97 && charCode <= 102 || charCode >= 65 && charCode <= 70)) {
                                    abort();
                                  }
                                }value += fromCharCode("0x" + source.slice(begin, Index));break;default:
                                abort();}
                          } else {
                            if (charCode == 34) {
                              break;
                            }charCode = source.charCodeAt(Index);begin = Index;while (charCode >= 32 && charCode != 92 && charCode != 34) {
                              charCode = source.charCodeAt(++Index);
                            }value += source.slice(begin, Index);
                          }
                        }if (source.charCodeAt(Index) == 34) {
                          Index++;return value;
                        }abort();default:
                        begin = Index;if (charCode == 45) {
                          isSigned = true;charCode = source.charCodeAt(++Index);
                        }if (charCode >= 48 && charCode <= 57) {
                          if (charCode == 48 && (charCode = source.charCodeAt(Index + 1), charCode >= 48 && charCode <= 57)) {
                            abort();
                          }isSigned = false;for (; Index < length && (charCode = source.charCodeAt(Index), charCode >= 48 && charCode <= 57); Index++) {}if (source.charCodeAt(Index) == 46) {
                            position = ++Index;for (; position < length && (charCode = source.charCodeAt(position), charCode >= 48 && charCode <= 57); position++) {}if (position == Index) {
                              abort();
                            }Index = position;
                          }charCode = source.charCodeAt(Index);if (charCode == 101 || charCode == 69) {
                            charCode = source.charCodeAt(++Index);if (charCode == 43 || charCode == 45) {
                              Index++;
                            }for (position = Index; position < length && (charCode = source.charCodeAt(position), charCode >= 48 && charCode <= 57); position++) {}if (position == Index) {
                              abort();
                            }Index = position;
                          }return +source.slice(begin, Index);
                        }if (isSigned) {
                          abort();
                        }if (source.slice(Index, Index + 4) == "true") {
                          Index += 4;return true;
                        } else if (source.slice(Index, Index + 5) == "false") {
                          Index += 5;return false;
                        } else if (source.slice(Index, Index + 4) == "null") {
                          Index += 4;return null;
                        }abort();}
                  }return "$";
                };var get = function get(value) {
                  var results, hasMembers;if (value == "$") {
                    abort();
                  }if (typeof value == "string") {
                    if ((charIndexBuggy ? value.charAt(0) : value[0]) == "@") {
                      return value.slice(1);
                    }if (value == "[") {
                      results = [];for (;; hasMembers || (hasMembers = true)) {
                        value = lex();if (value == "]") {
                          break;
                        }if (hasMembers) {
                          if (value == ",") {
                            value = lex();if (value == "]") {
                              abort();
                            }
                          } else {
                            abort();
                          }
                        }if (value == ",") {
                          abort();
                        }results.push(get(value));
                      }return results;
                    } else if (value == "{") {
                      results = {};for (;; hasMembers || (hasMembers = true)) {
                        value = lex();if (value == "}") {
                          break;
                        }if (hasMembers) {
                          if (value == ",") {
                            value = lex();if (value == "}") {
                              abort();
                            }
                          } else {
                            abort();
                          }
                        }if (value == "," || typeof value != "string" || (charIndexBuggy ? value.charAt(0) : value[0]) != "@" || lex() != ":") {
                          abort();
                        }results[value.slice(1)] = get(lex());
                      }return results;
                    }abort();
                  }return value;
                };var update = function update(source, property, callback) {
                  var element = walk(source, property, callback);if (element === undef) {
                    delete source[property];
                  } else {
                    source[property] = element;
                  }
                };var walk = function walk(source, property, callback) {
                  var value = source[property],
                      length;if ((typeof value === "undefined" ? "undefined" : _typeof(value)) == "object" && value) {
                    if (getClass.call(value) == arrayClass) {
                      for (length = value.length; length--;) {
                        update(value, length, callback);
                      }
                    } else {
                      _forEach(value, function (property) {
                        update(value, property, callback);
                      });
                    }
                  }return callback.call(source, property, value);
                };exports.parse = function (source, callback) {
                  var result, value;Index = 0;Source = "" + source;result = get(lex());if (lex() != "$") {
                    abort();
                  }Index = Source = null;return callback && getClass.call(callback) == functionClass ? walk((value = {}, value[""] = result, value), "", callback) : result;
                };
              }
            }exports["runInContext"] = runInContext;return exports;
          }if (freeExports && !isLoader) {
            runInContext(root, freeExports);
          } else {
            var nativeJSON = root.JSON,
                previousJSON = root["JSON3"],
                isRestored = false;var JSON3 = runInContext(root, root["JSON3"] = { noConflict: function noConflict() {
                if (!isRestored) {
                  isRestored = true;root.JSON = nativeJSON;root["JSON3"] = previousJSON;nativeJSON = previousJSON = null;
                }return JSON3;
              } });root.JSON = { parse: JSON3.parse, stringify: JSON3.stringify };
          }if (isLoader) {
            define(function () {
              return JSON3;
            });
          }
        }).call(this);
      }).call(this, typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : {});
    }, {}], 51: [function (_dereq_, module, exports) {
      module.exports = toArray;function toArray(list, index) {
        var array = [];index = index || 0;for (var i = index || 0; i < list.length; i++) {
          array[i - index] = list[i];
        }return array;
      }
    }, {}] }, {}, [31])(31);
});
//# sourceMappingURL=angular.js.map
