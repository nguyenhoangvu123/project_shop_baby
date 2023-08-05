<!DOCTYPE html>
<!--[if IE 9 ]> <html lang="vi" prefix="og: https://ogp.me/ns#" class="ie9 loading-site no-js"> <![endif]-->
<!--[if IE 8 ]> <html lang="vi" prefix="og: https://ogp.me/ns#" class="ie8 loading-site no-js"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="vi" prefix="og: https://ogp.me/ns#" class="loading-site no-js">
<!--<![endif]-->

<head>
    <script>
        if (navigator.userAgent.match(/MSIE|Internet Explorer/i) || navigator.userAgent.match(/Trident\/7\..*?rv:11/i)) {
            var href = document.location.href;
            if (!href.match(/[?&]nowprocket/)) {
                if (href.indexOf("?") == -1) {
                    if (href.indexOf("#") == -1) {
                        document.location.href = href + "?nowprocket=1"
                    } else {
                        document.location.href = href.replace("#", "?nowprocket=1#")
                    }
                } else {
                    if (href.indexOf("#") == -1) {
                        document.location.href = href + "&nowprocket=1"
                    } else {
                        document.location.href = href.replace("#", "&nowprocket=1#")
                    }
                }
            }
        }
    </script>
    <script>
        class RocketLazyLoadScripts {
            constructor(e) {
                this.triggerEvents = e, this.eventOptions = {
                    passive: !0
                }, this.userEventListener = this.triggerListener.bind(this), this.delayedScripts = {
                    normal: [],
                    async: [],
                    defer: []
                }, this.allJQueries = []
            }
            _addUserInteractionListener(e) {
                this.triggerEvents.forEach((t => window.addEventListener(t, e.userEventListener, e.eventOptions)))
            }
            _removeUserInteractionListener(e) {
                this.triggerEvents.forEach((t => window.removeEventListener(t, e.userEventListener, e.eventOptions)))
            }
            triggerListener() {
                this._removeUserInteractionListener(this), this._loadEverythingNow()
            }
            async _loadEverythingNow() {
                this._delayEventListeners(), this._delayJQueryReady(this), this._handleDocumentWrite(), this
                    ._registerAllDelayedScripts(), this._preloadAllScripts(), await this._loadScriptsFromList(this
                        .delayedScripts.normal), await this._loadScriptsFromList(this.delayedScripts.defer), await this
                    ._loadScriptsFromList(this.delayedScripts.async), await this._triggerDOMContentLoaded(), await this
                    ._triggerWindowLoad(), window.dispatchEvent(new Event("rocket-allScriptsLoaded"))
            }
            _registerAllDelayedScripts() {
                document.querySelectorAll("script[type=rocketlazyloadscript]").forEach((e => {
                    e.hasAttribute("src") ? e.hasAttribute("async") && !1 !== e.async ? this.delayedScripts
                        .async.push(e) : e.hasAttribute("defer") && !1 !== e.defer || "module" === e
                        .getAttribute("data-rocket-type") ? this.delayedScripts.defer.push(e) : this
                        .delayedScripts.normal.push(e) : this.delayedScripts.normal.push(e)
                }))
            }
            async _transformScript(e) {
                return await this._requestAnimFrame(), new Promise((t => {
                    const n = document.createElement("script");
                    let i;
                    [...e.attributes].forEach((e => {
                            let t = e.nodeName;
                            "type" !== t && ("data-rocket-type" === t && (t = "type", i = e
                                .nodeValue), n.setAttribute(t, e.nodeValue))
                        })), e.hasAttribute("src") && this._isValidScriptType(i) ? (n.addEventListener(
                            "load", t), n.addEventListener("error", t)) : (n.text = e.text, t()), e
                        .parentNode.replaceChild(n, e)
                }))
            }
            _isValidScriptType(e) {
                return !e || "" === e || "string" == typeof e && ["text/javascript", "text/x-javascript",
                    "text/ecmascript", "text/jscript", "application/javascript", "application/x-javascript",
                    "application/ecmascript", "application/jscript", "module"
                ].includes(e.toLowerCase())
            }
            async _loadScriptsFromList(e) {
                const t = e.shift();
                return t ? (await this._transformScript(t), this._loadScriptsFromList(e)) : Promise.resolve()
            }
            _preloadAllScripts() {
                var e = document.createDocumentFragment();
                [...this.delayedScripts.normal, ...this.delayedScripts.defer, ...this.delayedScripts.async].forEach((
                    t => {
                        const n = t.getAttribute("src");
                        if (n) {
                            const t = document.createElement("link");
                            t.href = n, t.rel = "preload", t.as = "script", e.appendChild(t)
                        }
                    })), document.head.appendChild(e)
            }
            _delayEventListeners() {
                let e = {};

                function t(t, n) {
                    ! function(t) {
                        function n(n) {
                            return e[t].eventsToRewrite.indexOf(n) >= 0 ? "rocket-" + n : n
                        }
                        e[t] || (e[t] = {
                            originalFunctions: {
                                add: t.addEventListener,
                                remove: t.removeEventListener
                            },
                            eventsToRewrite: []
                        }, t.addEventListener = function() {
                            arguments[0] = n(arguments[0]), e[t].originalFunctions.add.apply(t, arguments)
                        }, t.removeEventListener = function() {
                            arguments[0] = n(arguments[0]), e[t].originalFunctions.remove.apply(t, arguments)
                        })
                    }(t), e[t].eventsToRewrite.push(n)
                }

                function n(e, t) {
                    const n = e[t];
                    Object.defineProperty(e, t, {
                        get: n || function() {},
                        set: n => {
                            e["rocket" + t] = n
                        }
                    })
                }
                t(document, "DOMContentLoaded"), t(window, "DOMContentLoaded"), t(window, "load"), t(window,
                    "pageshow"), t(document, "readystatechange"), n(document, "onreadystatechange"), n(window,
                    "onload"), n(window, "onpageshow")
            }
            _delayJQueryReady(e) {
                let t = window.jQuery;
                Object.defineProperty(window, "jQuery", {
                    get: () => t,
                    set(n) {
                        if (n && n.fn && !e.allJQueries.includes(n)) {
                            n.fn.ready = n.fn.init.prototype.ready = function(t) {
                                e.domReadyFired ? t.bind(document)(n) : document.addEventListener(
                                    "rocket-DOMContentLoaded", (() => t.bind(document)(n)))
                            };
                            const t = n.fn.on;
                            n.fn.on = n.fn.init.prototype.on = function() {
                                if (this[0] === window) {
                                    function e(e) {
                                        return e.split(" ").map((e => "load" === e || 0 === e.indexOf(
                                            "load.") ? "rocket-jquery-load" : e)).join(" ")
                                    }
                                    "string" == typeof arguments[0] || arguments[0] instanceof String ?
                                        arguments[0] = e(arguments[0]) : "object" == typeof arguments[
                                            0] && Object.keys(arguments[0]).forEach((t => {
                                            delete Object.assign(arguments[0], {
                                                [e(t)]: arguments[0][t]
                                            })[t]
                                        }))
                                }
                                return t.apply(this, arguments), this
                            }, e.allJQueries.push(n)
                        }
                        t = n
                    }
                })
            }
            async _triggerDOMContentLoaded() {
                this.domReadyFired = !0, await this._requestAnimFrame(), document.dispatchEvent(new Event(
                        "rocket-DOMContentLoaded")), await this._requestAnimFrame(), window.dispatchEvent(new Event(
                        "rocket-DOMContentLoaded")), await this._requestAnimFrame(), document.dispatchEvent(new Event(
                        "rocket-readystatechange")), await this._requestAnimFrame(), document
                    .rocketonreadystatechange && document.rocketonreadystatechange()
            }
            async _triggerWindowLoad() {
                await this._requestAnimFrame(), window.dispatchEvent(new Event("rocket-load")), await this
                    ._requestAnimFrame(), window.rocketonload && window.rocketonload(), await this._requestAnimFrame(),
                    this.allJQueries.forEach((e => e(window).trigger("rocket-jquery-load"))), window.dispatchEvent(
                        new Event("rocket-pageshow")), await this._requestAnimFrame(), window.rocketonpageshow && window
                    .rocketonpageshow()
            }
            _handleDocumentWrite() {
                const e = new Map;
                document.write = document.writeln = function(t) {
                    const n = document.currentScript,
                        i = document.createRange(),
                        r = n.parentElement;
                    let a = e.get(n);
                    void 0 === a && (a = n.nextSibling, e.set(n, a));
                    const o = document.createDocumentFragment();
                    i.setStart(o, 0), o.appendChild(i.createContextualFragment(t)), r.insertBefore(o, a)
                }
            }
            async _requestAnimFrame() {
                return new Promise((e => requestAnimationFrame(e)))
            }
            static run() {
                const e = new RocketLazyLoadScripts(["keydown", "mouseover", "touchmove", "touchstart", "touchend",
                    "touchcancel", "touchforcechange", "wheel"
                ]);
                e._addUserInteractionListener(e)
            }
        }
        RocketLazyLoadScripts.run();
    </script>
    <meta charset="UTF-8" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <meta name="google-site-verification" content="Ko-Yk6BIdFZTKNuRKMgBCGb1SXotDf15KTs9p0SwvIM" />
    <link rel="pingback" href="https://www.hangjapan.com/xmlrpc.php" />
    <meta name="facebook-domain-verification" content="foa3qq2kibjpwyh2x90p36zrt7zrmv" />
    <meta name="keywords"
        content="Hằng Japan Hệ thống cửa hàng cao cấp cho mẹ và bé, cửa hàng mẹ và bé, siêu thị, mẹ và bé, đồ dùng cho mẹ và bé, siêu thị trẻ em, chăm sóc em bé, đồ dùng cho bé " />
    <meta name="p:domain_verify" content="c76fbd82286a971c021c725c94645734" />
    <script type="rocketlazyloadscript">(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- Search Engine Optimization by Rank Math PRO - https://s.rankmath.com/home -->
    <title>Hằng Japan Hệ thống cửa hàng cao cấp cho mẹ và bé</title>
    <meta name="description"
        content="Hằng Japan Là cửa hàng Mẹ và Bé được yêu thích nhất Việt Nam, chuyên cung cấp sản phẩm nhập khẩu trực tiếp với hơn 20 triệu sản phẩm Tã Sữa, Thực phẩm.. chất lượng uy tín." />
    <meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large" />
    <link rel="canonical" href="https://www.hangjapan.com/" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Hằng Japan Hệ thống cửa hàng cao cấp cho mẹ và bé" />
    <meta property="og:description"
        content="Hằng Japan Là cửa hàng Mẹ và Bé được yêu thích nhất Việt Nam, chuyên cung cấp sản phẩm nhập khẩu trực tiếp với hơn 20 triệu sản phẩm Tã Sữa, Thực phẩm.. chất lượng uy tín." />
    <meta property="og:url" content="https://www.hangjapan.com/" />
    <meta property="og:site_name" content="Hằng Japan" />
    <meta property="og:updated_time" content="2023-02-13T22:15:09+07:00" />
    <meta property="og:image"
        content="https://www.hangjapan.com/wp-content/uploads/2022/08/Hang-Japan-He-thong-cua-hang-cao-cap-cho-me-va-be.jpg" />
    <meta property="og:image:secure_url"
        content="https://www.hangjapan.com/wp-content/uploads/2022/08/Hang-Japan-He-thong-cua-hang-cao-cap-cho-me-va-be.jpg" />
    <meta property="og:image:width" content="1222" />
    <meta property="og:image:height" content="465" />
    <meta property="og:image:alt" content="Hằng Japan - Hệ thống cửa hàng cao cấp cho mẹ và bé" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="article:published_time" content="2021-06-18T17:06:30+07:00" />
    <meta property="article:modified_time" content="2023-02-13T22:15:09+07:00" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Hằng Japan Hệ thống cửa hàng cao cấp cho mẹ và bé" />
    <meta name="twitter:description"
        content="Hằng Japan Là cửa hàng Mẹ và Bé được yêu thích nhất Việt Nam, chuyên cung cấp sản phẩm nhập khẩu trực tiếp với hơn 20 triệu sản phẩm Tã Sữa, Thực phẩm.. chất lượng uy tín." />
    <meta name="twitter:image"
        content="https://www.hangjapan.com/wp-content/uploads/2022/08/Hang-Japan-He-thong-cua-hang-cao-cap-cho-me-va-be.jpg" />
    <meta name="twitter:label1" content="Written by" />
    <meta name="twitter:data1" content="Hằng Japan" />
    <meta name="twitter:label2" content="Time to read" />
    <meta name="twitter:data2" content="Less than a minute" />
    <script type="application/ld+json" class="rank-math-schema-pro">{"@context":"https://schema.org","@graph":[{"@type":["Organization","Person"],"@id":"https://www.hangjapan.com/#person","name":"H\u1eb1ng Japan","url":"https://www.hangjapan.com","email":"support@hangjapan.com","address":{"@type":"PostalAddress","streetAddress":"12A B\u00f9i Th\u1ecb Xu\u00e2n, Ph\u01b0\u1eddng 2","addressLocality":"T\u00e2n B\u00ecnh","addressRegion":"H\u1ed3 ch\u00ed minh","postalCode":"700000","addressCountry":"Vi\u1ec7t Nam"},"logo":{"@type":"ImageObject","@id":"https://www.hangjapan.com/#logo","url":"https://www.hangjapan.com/wp-content/uploads/2022/08/HangJapanLogo.png","caption":"H\u1eb1ng Japan","inLanguage":"vi","width":"840","height":"277"},"telephone":"0397955489","image":{"@id":"https://www.hangjapan.com/#logo"}},{"@type":"WebSite","@id":"https://www.hangjapan.com/#website","url":"https://www.hangjapan.com","name":"H\u1eb1ng Japan","publisher":{"@id":"https://www.hangjapan.com/#person"},"inLanguage":"vi","potentialAction":{"@type":"SearchAction","target":"https://www.hangjapan.com/?s={search_term_string}","query-input":"required name=search_term_string"}},{"@type":"ImageObject","@id":"https://www.hangjapan.com/wp-content/uploads/2022/08/Hang-Japan-He-thong-cua-hang-cao-cap-cho-me-va-be.jpg","url":"https://www.hangjapan.com/wp-content/uploads/2022/08/Hang-Japan-He-thong-cua-hang-cao-cap-cho-me-va-be.jpg","width":"1222","height":"465","caption":"H\u1eb1ng Japan - H\u1ec7 th\u1ed1ng c\u1eeda h\u00e0ng cao c\u1ea5p cho m\u1eb9 v\u00e0 b\u00e9","inLanguage":"vi"},{"@type":"Person","@id":"https://www.hangjapan.com/author/congdongshop","name":"H\u1eb1ng Japan","url":"https://www.hangjapan.com/author/congdongshop","image":{"@type":"ImageObject","@id":"https://secure.gravatar.com/avatar/8f10df702d57906028d0f3ec8a3169fd?s=96&amp;d=retro&amp;r=g","url":"https://secure.gravatar.com/avatar/8f10df702d57906028d0f3ec8a3169fd?s=96&amp;d=retro&amp;r=g","caption":"H\u1eb1ng Japan","inLanguage":"vi"},"sameAs":["https://www.hangjapan.com/","https://www.facebook.com/hangjapansonline"]},{"@type":"WebPage","@id":"https://www.hangjapan.com/#webpage","url":"https://www.hangjapan.com/","name":"H\u1eb1ng Japan H\u1ec7 th\u1ed1ng c\u1eeda h\u00e0ng cao c\u1ea5p cho m\u1eb9 v\u00e0 b\u00e9","datePublished":"2021-06-18T17:06:30+07:00","dateModified":"2023-02-13T22:15:09+07:00","author":{"@id":"https://www.hangjapan.com/author/congdongshop"},"isPartOf":{"@id":"https://www.hangjapan.com/#website"},"primaryImageOfPage":{"@id":"https://www.hangjapan.com/wp-content/uploads/2022/08/Hang-Japan-He-thong-cua-hang-cao-cap-cho-me-va-be.jpg"},"inLanguage":"vi"},{"image":{"@id":"https://www.hangjapan.com/wp-content/uploads/2022/08/Hang-Japan-He-thong-cua-hang-cao-cap-cho-me-va-be.jpg"},"headline":"H\u1eb1ng Japan - H\u1ec7 th\u1ed1ng c\u1eeda h\u00e0ng cao c\u1ea5p cho m\u1eb9 v\u00e0 b\u00e9","description":"H\u1eb1ng Japan L\u00e0 c\u1eeda h\u00e0ng M\u1eb9 B\u00e9 \u0111\u01b0\u1ee3c y\u00eau th\u00edch nh\u1ea5t Vi\u1ec7t Nam, v\u1edbi h\u01a1n 20 tri\u1ec7u s\u1ea3n ph\u1ea9m T\u00e3 S\u1eefa, Th\u1ef1c ph\u1ea9m.. ch\u1ea5t l\u01b0\u1ee3ng uy t\u00edn nh\u1ea5t t\u1ea1i HCM.","keywords":"H\u1eb1ng Japan","@type":"Article","author":{"@id":"https://www.hangjapan.com/author/congdongshop"},"datePublished":"2021-06-18T17:06:30+07:00","dateModified":"2023-02-13T22:15:09+07:00","copyrightYear":"2023","name":"H\u1eb1ng Japan - H\u1ec7 th\u1ed1ng c\u1eeda h\u00e0ng cao c\u1ea5p cho m\u1eb9 v\u00e0 b\u00e9","@id":"https://www.hangjapan.com/#schema-13262","isPartOf":{"@id":"https://www.hangjapan.com/#webpage"},"publisher":{"@id":"https://www.hangjapan.com/#person"},"inLanguage":"vi","mainEntityOfPage":{"@id":"https://www.hangjapan.com/#webpage"}}]}</script>
    <meta name="google-site-verification" content="IKunugMmifOldloQJ9bnHiLwg0F4urcuJm1esXxqDwc" />
    <!-- /Rank Math WordPress SEO plugin -->

    <link rel='dns-prefetch' href='//stats.wp.com' />
    <link rel='dns-prefetch' href='//assets.pinterest.com' />
    <link rel='dns-prefetch' href='//fonts.googleapis.com' />
    <link href='https://fonts.gstatic.com' crossorigin rel='preconnect' />
    <link rel="alternate" type="application/rss+xml" title="Dòng thông tin Hằng Japan &raquo;"
        href="https://www.hangjapan.com/feed" />
    <link rel="alternate" type="application/rss+xml" title="Dòng phản hồi Hằng Japan &raquo;"
        href="https://www.hangjapan.com/comments/feed" />
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 0.07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    <style id='wp-block-library-inline-css' type='text/css'>
        :root {
            --wp-admin-theme-color: #007cba;
            --wp-admin-theme-color--rgb: 0, 124, 186;
            --wp-admin-theme-color-darker-10: #006ba1;
            --wp-admin-theme-color-darker-10--rgb: 0, 107, 161;
            --wp-admin-theme-color-darker-20: #005a87;
            --wp-admin-theme-color-darker-20--rgb: 0, 90, 135;
            --wp-admin-border-width-focus: 2px;
            --wp-block-synced-color: #7a00df;
            --wp-block-synced-color--rgb: 122, 0, 223
        }

        @media (-webkit-min-device-pixel-ratio:2),
        (min-resolution:192dpi) {
            :root {
                --wp-admin-border-width-focus: 1.5px
            }
        }

        .wp-element-button {
            cursor: pointer
        }

        :root {
            --wp--preset--font-size--normal: 16px;
            --wp--preset--font-size--huge: 42px
        }

        :root .has-very-light-gray-background-color {
            background-color: #eee
        }

        :root .has-very-dark-gray-background-color {
            background-color: #313131
        }

        :root .has-very-light-gray-color {
            color: #eee
        }

        :root .has-very-dark-gray-color {
            color: #313131
        }

        :root .has-vivid-green-cyan-to-vivid-cyan-blue-gradient-background {
            background: linear-gradient(135deg, #00d084, #0693e3)
        }

        :root .has-purple-crush-gradient-background {
            background: linear-gradient(135deg, #34e2e4, #4721fb 50%, #ab1dfe)
        }

        :root .has-hazy-dawn-gradient-background {
            background: linear-gradient(135deg, #faaca8, #dad0ec)
        }

        :root .has-subdued-olive-gradient-background {
            background: linear-gradient(135deg, #fafae1, #67a671)
        }

        :root .has-atomic-cream-gradient-background {
            background: linear-gradient(135deg, #fdd79a, #004a59)
        }

        :root .has-nightshade-gradient-background {
            background: linear-gradient(135deg, #330968, #31cdcf)
        }

        :root .has-midnight-gradient-background {
            background: linear-gradient(135deg, #020381, #2874fc)
        }

        .has-regular-font-size {
            font-size: 1em
        }

        .has-larger-font-size {
            font-size: 2.625em
        }

        .has-normal-font-size {
            font-size: var(--wp--preset--font-size--normal)
        }

        .has-huge-font-size {
            font-size: var(--wp--preset--font-size--huge)
        }

        .has-text-align-center {
            text-align: center
        }

        .has-text-align-left {
            text-align: left
        }

        .has-text-align-right {
            text-align: right
        }

        #end-resizable-editor-section {
            display: none
        }

        .aligncenter {
            clear: both
        }

        .items-justified-left {
            justify-content: flex-start
        }

        .items-justified-center {
            justify-content: center
        }

        .items-justified-right {
            justify-content: flex-end
        }

        .items-justified-space-between {
            justify-content: space-between
        }

        .screen-reader-text {
            clip: rect(1px, 1px, 1px, 1px);
            word-wrap: normal !important;
            border: 0;
            -webkit-clip-path: inset(50%);
            clip-path: inset(50%);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px
        }

        .screen-reader-text:focus {
            clip: auto !important;
            background-color: #ddd;
            -webkit-clip-path: none;
            clip-path: none;
            color: #444;
            display: block;
            font-size: 1em;
            height: auto;
            left: 5px;
            line-height: normal;
            padding: 15px 23px 14px;
            text-decoration: none;
            top: 5px;
            width: auto;
            z-index: 100000
        }

        html :where(.has-border-color) {
            border-style: solid
        }

        html :where([style*=border-top-color]) {
            border-top-style: solid
        }

        html :where([style*=border-right-color]) {
            border-right-style: solid
        }

        html :where([style*=border-bottom-color]) {
            border-bottom-style: solid
        }

        html :where([style*=border-left-color]) {
            border-left-style: solid
        }

        html :where([style*=border-width]) {
            border-style: solid
        }

        html :where([style*=border-top-width]) {
            border-top-style: solid
        }

        html :where([style*=border-right-width]) {
            border-right-style: solid
        }

        html :where([style*=border-bottom-width]) {
            border-bottom-style: solid
        }

        html :where([style*=border-left-width]) {
            border-left-style: solid
        }

        html :where(img[class*=wp-image-]) {
            height: auto;
            max-width: 100%
        }

        figure {
            margin: 0 0 1em
        }

        html :where(.is-position-sticky) {
            --wp-admin--admin-bar--position-offset: var(--wp-admin--admin-bar--height, 0px)
        }

        @media screen and (max-width:600px) {
            html :where(.is-position-sticky) {
                --wp-admin--admin-bar--position-offset: 0px
            }
        }
    </style>
    <link rel='stylesheet' id='classic-theme-styles-css'
        href='{{ asset('assets/client/lib/css/classic-themes.min.css') }}' type='text/css' media='all' />
    <link data-minify="1" rel='stylesheet' id='contact-form-7-css'
        href='{{ asset('assets/client/lib/css/style.css') }}' type='text/css' media='all' />
    <style id='woocommerce-inline-inline-css' type='text/css'>
        .woocommerce form .form-row .required {
            visibility: visible;
        }
    </style>
    <link rel='stylesheet' id='pinterest-for-woocommerce-pins-css'
        href='{{ asset('assets/client/lib/css/pinterest-for-woocommerce-pins.min.css') }}' type='text/css'
        media='all' />
    <link data-minify="1" rel='stylesheet' id='font-awesome-css'
        href='{{ asset('assets/client/lib/css/font-awesome.min.css') }}' type='text/css' media='all' />
    <link data-minify="1" rel='stylesheet' id='shw-shw-review-frontend-css'
        href='{{ asset('assets/client/lib/css/shw-review-frontend.css') }}' type='text/css' media='all' />
    <link data-minify="1" rel='stylesheet' id='flatsome-swatches-frontend-css'
        href='{{ asset('assets/client/lib/css/flatsome-swatches-frontend.css') }}' type='text/css' media='all' />
    <link data-minify="1" rel='stylesheet' id='flatsome-main-css'
        href='{{ asset('assets/client/lib/css/flatsome.css') }}' type='text/css' media='all' />
    <style id='flatsome-main-inline-css' type='text/css'>
        @font-face {
            font-family: "fl-icons";
            font-display: block;
            src: url({{ asset('assets/client/icons/css/fl-icons.eot') }});
            src:
                url({{ asset('assets/client/icons/fl-icons.eot') }}) format("embedded-opentype"),
                url({{ asset('assets/client/icons/fl-icons.woff2') }}) format("woff2"),
                url({{ asset('assets/client/icons/fl-icons.ttf') }}) format("truetype"),
                url({{ asset('assets/client/icons/fl-icons.woff') }}) format("woff"),
                url({{ asset('assets/client/icons/fl-icons.svg') }}) format("svg");
        }
    </style>
    <link data-minify="1" rel='stylesheet' id='flatsome-shop-css'
        href='{{ asset('assets/client/lib/css/flatsome-shop.css') }}' type='text/css' media='all' />
    <link data-minify="1" rel='stylesheet' id='flatsome-style-css'
        href='{{ asset('assets/client/lib/css/flash_some.css') }}' type='text/css' media='all' />
    <link rel='stylesheet' id='flatsome-googlefonts-css'
        href='//fonts.googleapis.com/css?family=Roboto%3Aregular%2C700%2Cregular%2Cregular%7CNoto+Serif%3Aregular%2Cregular&#038;display=swap&#038;ver=3.9'
        type='text/css' media='all' />
    <style id='rocket-lazyload-inline-css' type='text/css'>
        .rll-youtube-player {
            position: relative;
            padding-bottom: 56.23%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
        }

        .rll-youtube-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
            background: 0 0
        }

        .rll-youtube-player img {
            bottom: 0;
            display: block;
            left: 0;
            margin: auto;
            max-width: 100%;
            width: 100%;
            position: absolute;
            right: 0;
            top: 0;
            border: none;
            height: auto;
            cursor: pointer;
            -webkit-transition: .4s all;
            -moz-transition: .4s all;
            transition: .4s all
        }

        .rll-youtube-player img:hover {
            -webkit-filter: brightness(75%)
        }

        .rll-youtube-player .play {
            height: 72px;
            width: 72px;
            left: 50%;
            top: 50%;
            margin-left: -36px;
            margin-top: -36px;
            position: absolute;
            background: url(https://www.hangjapan.com/wp-content/plugins/wp-rocket/assets/img/youtube.png) no-repeat;
            cursor: pointer
        }
    </style>
    <script type='text/javascript' src='{{ asset('assets/client/lib/js/jquery.min.js') }}' id='jquery-core-js'></script>
    <script type="rocketlazyloadscript" data-rocket-type='text/javascript' src='{{ asset('assets/client/lib/js/jquery-migrate.min.js')}}' id='jquery-migrate-js' defer></script>
    <script type='text/javascript' src='{{ asset('assets/client/lib/js/core.min.js') }}' id='jquery-ui-core-js' defer>
    </script>
    <script type="rocketlazyloadscript" data-rocket-type='text/javascript' src='{{ asset('assets/client/lib/js/progressbar.min.js')}}' id='jquery-ui-progressbar-js' defer></script>
    <script data-minify="1" type='text/javascript' src='{{ asset('assets/client/lib/js/free-image-optimizer.js') }}'
        id='FreeImageOptimizer-admin-js' defer></script>
    <script type='text/javascript' src='{{ asset('assets/client/lib/js/wp-polyfill-inert.min.js?ver=3.1.2') }}'
        id='wp-polyfill-inert-js' defer></script>
    <script type="rocketlazyloadscript" data-rocket-type='text/javascript' src='{{ asset('assets/client/lib/js/regenerator-runtime.min.js') }}' id='regenerator-runtime-js' defer></script>
    <script type='text/javascript' src='{{ asset('assets/client/lib/js//wp-polyfill.min.js') }}' id='wp-polyfill-js'>
    </script>
    <script type="rocketlazyloadscript" data-rocket-type='text/javascript' src='{{ asset('assets/client/lib/js/hooks.min.js') }}' id='wp-hooks-js'></script>
    <script type="rocketlazyloadscript" data-rocket-type='text/javascript' src='https://stats.wp.com/w.js?ver=202331' id='woo-tracks-js' defer></script>
    <script data-minify="1" type='text/javascript' src='{{ asset('assets/client/lib/js/shw-site.js') }}' id='shw-site-js'
        defer></script>
    <link rel="https://api.w.org/" href="https://www.hangjapan.com/wp-json/" />
    <link rel="alternate" type="application/json" href="https://www.hangjapan.com/wp-json/wp/v2/pages/54" />
    <link rel="EditURI" type="application/rsd+xml" title="RSD"
        href="https://www.hangjapan.com/xmlrpc.php?rsd" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml"
        href="https://www.hangjapan.com/wp-includes/wlwmanifest.xml" />
    <meta name="generator" content="WordPress 6.2.2" />
    <link rel='shortlink' href='https://www.hangjapan.com/' />

    <!-- This website runs the Product Feed PRO for WooCommerce by AdTribes.io plugin - version 11.8.8 -->
    <!--[if IE]><link rel="stylesheet" type="text/css" href="https://www.hangjapan.com/wp-content/themes/flatsome/assets/css/ie-fallback.css"><script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script><script>
        var head = document.getElementsByTagName('head')[0],
            style = document.createElement('style');
        style.type = 'text/css';
        style.styleSheet.cssText = ':before,:after{content:none !important';
        head.appendChild(style);
        setTimeout(function() {
            head.removeChild(style);
        }, 0);
    </script><script src="https://www.hangjapan.com/wp-content/themes/flatsome/assets/libs/ie-flexibility.js"></script><![endif]-->
    <noscript>
        <style>
            .woocommerce-product-gallery {
                opacity: 1 !important;
            }
        </style>
    </noscript>
    <script type="rocketlazyloadscript" id="google_gtagjs" src="https://www.hangjapan.com/?local_ga_js=34751703c15e88504af1a63bae19e72a" async="async" data-rocket-type="text/javascript"></script>
    <script type="rocketlazyloadscript" id="google_gtagjs-inline" data-rocket-type="text/javascript">
window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-YNYBC4P8TX', {'anonymize_ip': true} );
</script>
    <link rel="icon" href="{{ asset('assets/client/images/favicon-hang-japan-150x150.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('assets/client/images/favicon-hang-japan.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('assets/client/images/favicon-hang-japan.png') }}" />
    <meta name="msapplication-TileImage" content="{{ asset('assets/client/images/favicon-hang-japan.png') }}" />
    <style id="custom-css" type="text/css">
        :root {
            --primary-color: #000000;
        }

        .full-width .ubermenu-nav,
        .container,
        .row {
            max-width: 1170px
        }

        .row.row-collapse {
            max-width: 1140px
        }

        .row.row-small {
            max-width: 1162.5px
        }

        .row.row-large {
            max-width: 1200px
        }

        .header-main {
            height: 82px
        }

        #logo img {
            max-height: 82px
        }

        #logo {
            width: 200px;
        }

        .header-bottom {
            min-height: 10px
        }

        .header-top {
            min-height: 40px
        }

        .transparent .header-main {
            height: 90px
        }

        .transparent #logo img {
            max-height: 90px
        }

        .has-transparent+.page-title:first-of-type,
        .has-transparent+#main>.page-title,
        .has-transparent+#main>div>.page-title,
        .has-transparent+#main .page-header-wrapper:first-of-type .page-title {
            padding-top: 170px;
        }

        .header.show-on-scroll,
        .stuck .header-main {
            height: 70px !important
        }

        .stuck #logo img {
            max-height: 70px !important
        }

        .search-form {
            width: 90%;
        }

        .header-bottom {
            background-color: #ffffff
        }

        .top-bar-nav>li>a {
            line-height: 16px
        }

        .header-wrapper:not(.stuck) .header-main .header-nav {
            margin-top: -10px
        }

        .header-bottom-nav>li>a {
            line-height: 30px
        }

        @media (max-width: 549px) {
            .header-main {
                height: 70px
            }

            #logo img {
                max-height: 70px
            }
        }

        .header-top {
            background-color: #ffffff !important;
        }

        /* Color */
        .accordion-title.active,
        .has-icon-bg .icon .icon-inner,
        .logo a,
        .primary.is-underline,
        .primary.is-link,
        .badge-outline .badge-inner,
        .nav-outline>li.active>a,
        .nav-outline>li.active>a,
        .cart-icon strong,
        [data-color='primary'],
        .is-outline.primary {
            color: #000000;
        }

        /* Color !important */
        [data-text-color="primary"] {
            color: #000000 !important;
        }

        /* Background Color */
        [data-text-bg="primary"] {
            background-color: #000000;
        }

        /* Background */
        .scroll-to-bullets a,
        .featured-title,
        .label-new.menu-item>a:after,
        .nav-pagination>li>.current,
        .nav-pagination>li>span:hover,
        .nav-pagination>li>a:hover,
        .has-hover:hover .badge-outline .badge-inner,
        button[type="submit"],
        .button.wc-forward:not(.checkout):not(.checkout-button),
        .button.submit-button,
        .button.primary:not(.is-outline),
        .featured-table .title,
        .is-outline:hover,
        .has-icon:hover .icon-label,
        .nav-dropdown-bold .nav-column li>a:hover,
        .nav-dropdown.nav-dropdown-bold>li>a:hover,
        .nav-dropdown-bold.dark .nav-column li>a:hover,
        .nav-dropdown.nav-dropdown-bold.dark>li>a:hover,
        .is-outline:hover,
        .tagcloud a:hover,
        .grid-tools a,
        input[type='submit']:not(.is-form),
        .box-badge:hover .box-text,
        input.button.alt,
        .nav-box>li>a:hover,
        .nav-box>li.active>a,
        .nav-pills>li.active>a,
        .current-dropdown .cart-icon strong,
        .cart-icon:hover strong,
        .nav-line-bottom>li>a:before,
        .nav-line-grow>li>a:before,
        .nav-line>li>a:before,
        .banner,
        .header-top,
        .slider-nav-circle .flickity-prev-next-button:hover svg,
        .slider-nav-circle .flickity-prev-next-button:hover .arrow,
        .primary.is-outline:hover,
        .button.primary:not(.is-outline),
        input[type='submit'].primary,
        input[type='submit'].primary,
        input[type='reset'].button,
        input[type='button'].primary,
        .badge-inner {
            background-color: #000000;
        }

        /* Border */
        .nav-vertical.nav-tabs>li.active>a,
        .scroll-to-bullets a.active,
        .nav-pagination>li>.current,
        .nav-pagination>li>span:hover,
        .nav-pagination>li>a:hover,
        .has-hover:hover .badge-outline .badge-inner,
        .accordion-title.active,
        .featured-table,
        .is-outline:hover,
        .tagcloud a:hover,
        blockquote,
        .has-border,
        .cart-icon strong:after,
        .cart-icon strong,
        .blockUI:before,
        .processing:before,
        .loading-spin,
        .slider-nav-circle .flickity-prev-next-button:hover svg,
        .slider-nav-circle .flickity-prev-next-button:hover .arrow,
        .primary.is-outline:hover {
            border-color: #000000
        }

        .nav-tabs>li.active>a {
            border-top-color: #000000
        }

        .widget_shopping_cart_content .blockUI.blockOverlay:before {
            border-left-color: #000000
        }

        .woocommerce-checkout-review-order .blockUI.blockOverlay:before {
            border-left-color: #000000
        }

        /* Fill */
        .slider .flickity-prev-next-button:hover svg,
        .slider .flickity-prev-next-button:hover .arrow {
            fill: #000000;
        }

        body {
            font-size: 100%;
        }

        @media screen and (max-width: 549px) {
            body {
                font-size: 100%;
            }
        }

        body {
            font-family: "Roboto", sans-serif
        }

        body {
            font-weight: 0
        }

        body {
            color: #000000
        }

        .nav>li>a {
            font-family: "Noto Serif", sans-serif;
        }

        .mobile-sidebar-levels-2 .nav>li>ul>li>a {
            font-family: "Noto Serif", sans-serif;
        }

        .nav>li>a {
            font-weight: 0;
        }

        .mobile-sidebar-levels-2 .nav>li>ul>li>a {
            font-weight: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .heading-font,
        .off-canvas-center .nav-sidebar.nav-vertical>li>a {
            font-family: "Roboto", sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .heading-font,
        .banner h1,
        .banner h2 {
            font-weight: 700;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .heading-font {
            color: #000000;
        }

        .alt-font {
            font-family: "Roboto", sans-serif;
        }

        .alt-font {
            font-weight: 0 !important;
        }

        .header:not(.transparent) .top-bar-nav>li>a {
            color: #999999;
        }

        .header:not(.transparent) .header-bottom-nav.nav>li>a {
            color: #000000;
        }

        a {
            color: #000000;
        }

        .shop-page-title.featured-title .title-overlay {
            background-color: #282828;
        }

        .current .breadcrumb-step,
        [data-icon-label]:after,
        .button#place_order,
        .button.checkout,
        .checkout-button,
        .single_add_to_cart_button.button {
            background-color: #000000 !important
        }

        .has-equal-box-heights .box-image {
            padding-top: 100%;
        }

        .star-rating span:before,
        .star-rating:before,
        .woocommerce-page .star-rating:before,
        .stars a:hover:after,
        .stars a.active:after {
            color: #000000
        }

        @media screen and (min-width: 550px) {
            .products .box-vertical .box-image {
                min-width: 600px !important;
                width: 600px !important;
            }
        }

        .footer-1 {
            background-color: #f4f5f7
        }

        .footer-2 {
            background-color: #f4f5f7
        }

        .absolute-footer,
        html {
            background-color: #f4f5f7
        }

        button[name='update_cart'] {
            display: none;
        }

        /* Custom CSS */
        p.from_the_blog_excerpt {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .woocommerce a.remove {
            width: 30px;
            height: 22px;
            position: relative;
            transition: opacity 200ms;
            vertical-align: top;
            display: block;
            -webkit-appearance: none;
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
            padding: 0;
            text-indent: -9999px;
        }

        ul.product_list_widget li a.remove {
            width: 30px;
            height: 22px;
            transition: opacity 200ms;
            vertical-align: top;
            display: block;
            -webkit-appearance: none;
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
            padding: 0;
            text-indent: -9999px;
        }

        .woocommerce a.remove:before,
        .woocommerce a.remove:after,
        ul.product_list_widget li a.remove:before,
        ul.product_list_widget li a.remove:after {
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAQCAQAAACMnYaxAAAAXUlEQVR4XsWQQQrAQAgD84Pti/JSoaftN1MCdgXxXgYvGfUQyABE4DEIUJmeuKgVlJI5em0RGTesFXXZuLwCzvL2pYbHmfCTNSXxpyyajLGClFy7K1dgaaho7YYovIpO3rju6hYFAAAAAElFTkSuQmCC) 0 0 no-repeat;
            left: 8px;
            position: absolute;
            right: 8px;
            top: 2px;
            display: inline-block;
            content: '';
        }

        .woocommerce a.remove:before,
        ul.product_list_widget li a.remove:before {
            height: 6px;
            transform-origin: -7% 100%;
            -moz-transform-origin: -7% 100%;
            -webkit-transform-origin: -7% 100%;
            transition: transform 150ms;
            -moz-transition: transform 150ms;
            -webkit-transition: transform 150ms;
            width: 14px;
        }

        .woocommerce a.remove:after,
        ul.product_list_widget li a.remove:after {
            background-position: -1px -4px;
            height: 12px;
            margin-left: 1px;
            margin-right: 2px;
            margin-top: 4px;
            width: 11px;
        }

        .woocommerce a.remove:hover:before,
        ul.product_list_widget li a.remove:hover:before {
            transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            transition: transform 250ms;
            -moz-transition: transform 250ms;
            -webkit-transition: transform 250ms;
        }

        .woocommerce a.remove:hover,
        ul.product_list_widget li a.remove:hover {
            background: transparent;
        }

        /* Custom CSS Mobile */
        @media (max-width: 549px) {
            .col.post-item .box-text.text-left {
                min-height: auto !important;
            }
        }

        .label-new.menu-item>a:after {
            content: "New";
        }

        .label-hot.menu-item>a:after {
            content: "Hot";
        }

        .label-sale.menu-item>a:after {
            content: "Sale";
        }

        .label-popular.menu-item>a:after {
            content: "Popular";
        }
    </style>
    <style type="text/css" id="wp-custom-css">
        span.text-topbar i,
        span.text-topbar b {
            color: #da2032;
        }

        span.text-topbar {
            color: #999;
            font-size: 13px;
        }

        p#shipping_address_2_field label {
            opacity: 1;
            width: auto;
        }

        span.text-topbar.topbar-right {
            margin-left: 15px;
        }

        a.linkshoppe {
            border: 1px solid;
            color: #f1582c;
            line-height: 30px;
            border-radius: 5px;
            display: flex;
            background: #f3f3f3;
            font-weight: bold;
            justify-content: space-evenly;
            align-items: center;
        }

        nav.rank-math-breadcrumb.breadcrumbs {
            font-size: 13px;
            text-transform: uppercase;
        }

        h4.collection-title {
            font-size: 13px;
            margin: 0;
        }

        .form-check {
            display: inline-block;
            float: left;
            padding-top: 0;
            padding-left: 0;
            width: 100px;
            margin-left: 30px;
        }

        .footer-widgets.footer.footer-1 a {
            font-weight: 300;
            color: #333;
        }

        .form-check span {
            font-size: 12px;
            display: inline-block;
            float: right;
            width: calc(100% - 30px);
            padding-left: 3px;
            margin-top: 0;
            line-height: 1.4;
            color: #333;
            font-weight: 400;
        }

        .form-check img,
        .form-check i {
            width: 30px;
            font-size: 30px;
        }

        div#top-bar {
            box-shadow: 0 0 5px 0 #cccc;
        }

        .footer-header img {
            width: 70%;
            text-align: center;
        }

        .footer-header table td {
            border: none;
        }

        .absolute-footer.light.medium-text-center.text-center .container.clearfix {
            border-top: 1px solid #fff;
            padding-top: 10px;
        }

        .ftwp-in-post#ftwp-container-outer.ftwp-float-left,
        .ftwp-in-post#ftwp-container-outer.ftwp-float-left #ftwp-contents {
            width: 100%;
            text-align: left;
        }

        .social-icons.follow-icons.icon-footer a {
            margin: 5px 15px;
            background: white;
            border: 1px solid;
            line-height: 45px;
        }

        /*danh mục sản phẩm*/
        .term-description {
            background: #f5f5f5eb;
            padding: 15px;
            border-radius: 5px;
            font-size: 13px;
        }

        .term-description figure {
            max-width: 60%;
        }

        .term-description h3 {
            border-left: 4px solid #da2032;
            background: linear-gradient(90deg, #ffffff 0, #f6f6f6 100%);
            padding: 5px;
        }

        .table-chinh-sach table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-chinh-sach td,
        .table-chinh-sach th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .footer-header {
            background: #fff;
        }

        .table-chinh-sach h2 {
            border-left: 4px solid #da2032;
            background: linear-gradient(90deg, #ffffff 0, #f6f6f6 100%);
            padding: 5px;
        }
    </style>
    <style id="flatsome-swatches-css" type="text/css">
        .variations td {
            display: block;
        }

        .variations td.label {
            display: flex;
            align-items: center;
        }
    </style><noscript>
        <style id="rocket-lazyload-nojs-css">
            .rll-youtube-player,
            [data-lazy-src] {
                display: none !important;
            }
        </style>
    </noscript><!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-T42SN6G');
    </script>
    <!-- End Google Tag Manager -->
</head>
