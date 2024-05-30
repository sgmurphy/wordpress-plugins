/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/script.js":
/*!*********************************!*\
  !*** ./assets/src/js/script.js ***!
  \*********************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

eval("__webpack_require__.r(__webpack_exports__);\n/**\n * @package koko-analytics\n * @author Danny van Kooten\n * @license GPL-3.0+\n */\n\n// Map variables to global identifiers so that minifier can mangle them to even shorter names\nconst doc = document\nconst win = window\nconst nav = navigator\nconst enc = encodeURIComponent\nconst loc = win.location\nconst ka = \"koko_analytics\"\n\nfunction getPagesViewed() {\n  let m = doc.cookie.match(/_koko_analytics_pages_viewed=([^;]+)/)\n  return m ? m.pop().split('a') : [];\n}\n\nfunction request(url) {\n  return nav.sendBeacon(win[ka].url + (win[ka].url.indexOf('?') > -1 ? '&' : '?') + url)\n}\n\nfunction trackPageview (postId) {\n  let {use_cookie, cookie_path} = win[ka]\n\n  if (\n    // do not track if this is a prerender request\n    (doc.visibilityState == 'prerender') ||\n\n    // do not track if user agent looks like a bot\n    ((/bot|crawl|spider|seo|lighthouse|preview/i).test(nav.userAgent))\n  ) {\n    return\n  }\n\n  const pagesViewed = getPagesViewed()\n  postId += \"\"\n  let isNewVisitor = pagesViewed.length ? 0 : 1;\n  let isUniquePageview = pagesViewed.indexOf(postId) == -1 ? 1 : 0\n  let referrer = doc.referrer\n\n  // check if referred by same-site (so definitely a returning visitor)\n  if (referrer.indexOf(loc.origin) == 0) {\n    isNewVisitor = 0\n\n    // check if referred by same page (so not a unique pageview)\n    if (referrer == loc.href) {\n      isUniquePageview = 0\n    }\n\n    // don't store referrer if from same-site\n    referrer = ''\n  }\n\n  request(`p=${postId}&nv=${isNewVisitor}&up=${isUniquePageview}&r=${enc(referrer)}`)\n  if (isUniquePageview) pagesViewed.push(postId)\n  if (use_cookie) doc.cookie = `_${ka}_pages_viewed=${pagesViewed.join('a')};SameSite=lax;path=${cookie_path};max-age=21600`\n}\n\nwin[ka].trackPageview = trackPageview;\nwin.addEventListener('load', () =>  trackPageview(win[ka].post_id))\n\n\n//# sourceURL=webpack://koko-analytics/./assets/src/js/script.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/src/js/script.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;