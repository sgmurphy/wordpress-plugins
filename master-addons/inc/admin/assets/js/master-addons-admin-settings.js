/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./dev/admin/admin-settings.js":
/*!*************************************!*\
  !*** ./dev/admin/admin-settings.js ***!
  \*************************************/
/***/ (() => {

(function ($) {
  "use strict";

  jQuery(document).ready(function ($) {
    'use strict';

    // Save Button reacting on any changes
    var saveHeaderAction = $('.jltma-tab-dashboard-header-wrapper .jltma-tab-element-save-setting');
    $('.jltma-master-addons-features-list input').on('click', function () {
      saveHeaderAction.addClass('jltma-addons-save-now');
      saveHeaderAction.removeAttr('disabled').css('cursor', 'pointer');
    });

    //API & White Label Input Fields Change
    $('#jltma-api-forms-settings input, #jltma-addons-white-label-settings input').on('keyup', function () {
      saveHeaderAction.addClass('jltma-addons-save-now');
      saveHeaderAction.removeAttr('disabled').css('cursor', 'pointer');
    });

    //White Label Checkbox Fields Change
    $('#jltma-addons-white-label-settings input[type="checkbox"]').on('change', function () {
      saveHeaderAction.addClass('jltma-addons-save-now');
      saveHeaderAction.removeAttr('disabled').css('cursor', 'pointer');
    });

    // Enable All Elements
    $('#jltma-addons-elements .jltma-addons-enable-all, a.jltma-wl-plugin-logo, a.jltma-remove-button').on("click", function (e) {
      e.preventDefault();
      $("#jltma-addons-elements .jltma-master-addons_feature-switchbox input:enabled").each(function (i) {
        $(this).prop("checked", true).change();
      });
      saveHeaderAction.addClass("jltma-addons-save-now").removeAttr("disabled").css("cursor", "pointer");
    });

    // Disable All Elements
    $('#jltma-addons-elements .jltma-addons-disable-all').on("click", function (e) {
      e.preventDefault();
      $("#jltma-addons-elements .jltma-master-addons_feature-switchbox input:enabled").each(function (i) {
        $(this).prop("checked", false).change();
      });
      saveHeaderAction.addClass("jltma-addons-save-now").removeAttr("disabled").css("cursor", "pointer");
    });

    // Enable All Extensions
    $('#jltma-addons-extensions .jltma-addons-enable-all').on("click", function (e) {
      e.preventDefault();
      $("#jltma-addons-extensions .jltma-master-addons_feature-switchbox input:enabled").each(function (i) {
        $(this).prop("checked", true).change();
      });
      saveHeaderAction.addClass("jltma-addons-save-now").removeAttr("disabled").css("cursor", "pointer");
    });

    // Disable All Elements
    $('#jltma-addons-extensions .jltma-addons-disable-all').on("click", function (e) {
      e.preventDefault();
      $("#jltma-addons-extensions .jltma-master-addons_feature-switchbox input:enabled").each(function (i) {
        $(this).prop("checked", false).change();
      });
      saveHeaderAction.addClass("jltma-addons-save-now").removeAttr("disabled").css("cursor", "pointer");
    });

    // Dashboard widget links target
    $('.master-addons-posts a.rsswidget').attr('target', '_blank');

    //Navigation Tabs
    $('jltma-master-addons-tabs-navbar a:not(.jltma-upgrade-pro)').on('click', function (event) {
      event.preventDefault(); // Limit effect to the container element.

      var context = $(this).closest('jltma-master-addons-tabs-navbar').parent();
      var url = $(this).attr('href'),
        target = $(this).attr('target');
      if (target == '_blank') {
        window.open(url, target);
      } else {
        $('jltma-master-addons-tabs-navbar li', context).removeClass('jltma-admin-tab-active');
        $(this).closest('li').addClass('jltma-admin-tab-active');
        $('.jltma-master-addons-tab-panel', context).hide();
        $($(this).attr('href'), context).show();
      }
    });

    // Make setting jltma-admin-tab-active optional.
    $('jltma-master-addons-tabs-navbar').each(function () {
      if ($('.jltma-admin-tab-active', this).length) $('.jltma-admin-tab-active', this).click();else $('a', this).first().click();
    });

    // Go Pro Modal
    $('.ma-el-pro:parent').on('click', function (event) {
      event.preventDefault();
      swal({
        title: "Go Pro",
        text: 'Upgrade to <a href="https://master-addons.com/go/upgrade-pro/" target="_blank"> Pro Version </a> for ' + ' Unlock more Features ',
        type: "warning",
        showLoaderOnConfirm: true,
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonClass: 'btn-success',
        confirmButtonText: 'Okay'
      }, function () {
        setTimeout(function () {
          $('.ma-el-pro').fadeOut('slow');
        }, 2000);
      })["catch"](swal.noop);
    });

    // White Label Logo/Icon Upload on button click
    $('body').on('click', '.jltma-wl-plugin-logo', function (e) {
      e.preventDefault();
      var button = $(this),
        custom_uploader = wp.media({
          title: 'Insert image',
          library: {
            // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
            type: 'image'
          },
          button: {
            text: 'Use this image' // button label text
          },
          multiple: false
        }).on('select', function () {
          // it also has "open" and "close" events
          var attachment = custom_uploader.state().get('selection').first().toJSON();
          button.html('<img src="' + attachment.url + '">').next().show();
          $('.jltma-whl-selected-image').val(attachment.id);
        }).open();
    });

    // on remove button click
    $('body').on('click', '.jltma-remove-button', function (e) {
      e.preventDefault();
      var button = $(this);
      button.next().val(''); // emptying the hidden field
      button.hide().prev().html('<i class="dashicons dashicons-cloud-upload"></i> <span>Upload image</span>');
    });

    //Tracking purchases with Google Analytics and Facebook for Freemius Checkout
    var purchaseCompleted = function purchaseCompleted(response) {
      var trial = response.purchase.trial_ends !== null,
        total = trial ? 0 : response.purchase.initial_amount.toString(),
        productName = 'Product Name',
        storeUrl = 'https://master-addons.com',
        storeName = 'Master Addons';
      if (typeof fbq !== "undefined") {
        fbq('track', 'Purchase', {
          currency: 'USD',
          value: response.purchase.initial_amount
        });
      }
      if (typeof ga !== "undefined") {
        ga('send', 'event', 'plugin', 'purchase', productName, response.purchase.initial_amount.toString());
        ga('require', 'ecommerce');
        ga('ecommerce:addTransaction', {
          'id': response.purchase.id.toString(),
          // Transaction ID. Required.
          'affiliation': storeName,
          // Affiliation or store name.
          'revenue': total,
          // Grand Total.
          'shipping': '0',
          // Shipping.
          'tax': '0' // Tax.
        });
        ga('ecommerce:addItem', {
          'id': response.purchase.id.toString(),
          // Transaction ID. Required.
          'name': productName,
          // Product name. Required.
          'sku': response.purchase.plan_id.toString(),
          // SKU/code.
          'category': 'Plugin',
          // Category or variation.
          'price': response.purchase.initial_amount.toString(),
          // Unit price.
          'quantity': '1' // Quantity.
        });
        ga('ecommerce:send');
        ga('send', {
          hitType: 'pageview',
          page: '/purchase-completed/',
          location: storeUrl + '/purchase-completed/'
        });
      }
    };

    // Saving Data With Ajax Request
    $('.jltma-tab-element-save-setting').on('click', function (e) {
      e.preventDefault();
      var $this = $(this);
      if ($(this).hasClass('jltma-addons-save-now')) {
        // Master Addons Elemements
        $.ajax({
          url: JLTMA_OPTIONS.ajaxurl,
          type: 'post',
          data: {
            action: 'jltma_save_elements_settings',
            security: JLTMA_OPTIONS.ajax_nonce,
            fields: $('#jltma-addons-tab-settings').serialize()
          },
          success: function success(response) {
            swal({
              title: "Saved",
              text: "Your Changes has been Saved",
              type: "success",
              showLoaderOnConfirm: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonClass: 'btn-success',
              confirmButtonText: 'Okay'
            }, function () {
              setTimeout(function () {
                $('.jltma-addons-settings-saved').fadeOut('fast');
              }, 2000);
            });
            $this.html('Save Settings');
            $('.jltma-tab-dashboard-header-right').prepend('<span' + ' class="jltma-addons-settings-saved"></span>').fadeIn('slow');
            saveHeaderAction.removeClass('jltma-addons-save-now');
          },
          error: function error() {}
        });

        // Master Addons Extensions
        $.ajax({
          url: JLTMA_OPTIONS.ajaxurl,
          type: 'post',
          data: {
            action: 'master_addons_save_extensions_settings',
            security: JLTMA_OPTIONS.ajax_extensions_nonce,
            fields: $('#jltma-addons-extensions-settings').serialize()
          },
          success: function success(response) {
            swal({
              title: "Saved",
              text: "Your Changes has been Saved",
              type: "success",
              showLoaderOnConfirm: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonClass: 'btn-success',
              confirmButtonText: 'Okay'
            });
            $this.html('Save Settings');
            $('.jltma-tab-dashboard-header-right').prepend('<span' + ' class="jltma-addons-settings-saved"></span>').fadeIn('slow');
            saveHeaderAction.removeClass('jltma-addons-save-now');
            setTimeout(function () {
              $('.jltma-addons-settings-saved').fadeOut('slow');
              swal.close();
            }, 1200);
          },
          error: function error() {}
        });

        // Master Addons API Settings
        $.ajax({
          url: JLTMA_OPTIONS.ajaxurl,
          type: 'post',
          data: {
            action: 'jltma_save_api_settings',
            security: JLTMA_OPTIONS.ajax_api_nonce,
            fields: $('#jltma-api-forms-settings').serializeArray()
          },
          success: function success(response) {
            swal({
              title: "Saved",
              text: "Your Changes has been Saved",
              type: "success",
              showLoaderOnConfirm: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonClass: 'btn-success',
              confirmButtonText: 'Okay'
            });
            $this.html('Save Settings');
            $('.jltma-tab-dashboard-header-right').prepend('<span' + ' class="jltma-addons-settings-saved"></span>').fadeIn('slow');
            saveHeaderAction.removeClass('jltma-addons-save-now');
            setTimeout(function () {
              $('.jltma-addons-settings-saved').fadeOut('slow');
              swal.close();
            }, 1200);
          },
          error: function error() {}
        });

        // Master Addons Icons Library
        $.ajax({
          url: JLTMA_OPTIONS.ajaxurl,
          type: 'post',
          data: {
            action: 'jltma_save_icons_library_settings',
            security: JLTMA_OPTIONS.ajax_icons_library_nonce,
            fields: $('#jltma-master-addons-icons-settings').serialize()
          },
          success: function success(response) {
            swal({
              title: "Saved",
              text: "Your Changes has been Saved",
              type: "success",
              showLoaderOnConfirm: true,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonClass: 'btn-success',
              confirmButtonText: 'Okay'
            });
            $this.html('Save Settings');
            $('.jltma-tab-dashboard-header-right').prepend('<span' + ' class="jltma-addons-settings-saved"></span>').fadeIn('slow');
            saveHeaderAction.removeClass('jltma-addons-save-now');
            setTimeout(function () {
              $('.jltma-addons-settings-saved').fadeOut('slow');
              swal.close();
            }, 1200);
          },
          error: function error() {}
        });

        // Master Addons White Label Ajax Call
        if ('valid' === $(this).data("lic")) {
          $.ajax({
            url: JLTMA_OPTIONS.ajaxurl,
            type: 'post',
            data: {
              action: 'jltma_save_white_label_settings',
              security: JLTMA_OPTIONS.ajax_nonce,
              fields: $('form#jltma-addons-white-label-settings').serialize()
            },
            success: function success(response) {
              swal({
                title: "Saved",
                text: "Your Changes has been Saved",
                type: "success",
                showLoaderOnConfirm: true,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonClass: 'btn-success',
                confirmButtonText: 'Okay'
              });
              $this.html('Save Settings');
              $('.jltma-tab-dashboard-header-right').prepend('<span' + ' class="jltma-addons-settings-saved"></span>').fadeIn('slow');
              saveHeaderAction.removeClass('jltma-addons-save-now');
              setTimeout(function () {
                $('.jltma-addons-settings-saved').fadeOut('slow');
                swal.close();
              }, 1200);
            },
            error: function error() {
              swal('Oops...', 'Something Wrong!');
            }
          });
        }
      } else {
        $(this).attr('disabled', 'true').css('cursor', 'not-allowed');
      }
    });

    // Rollback Version
    $('select.master-addons-rollback-select').on('change', function () {
      var $this = $(this),
        $rollbackButton = $this.next('.jltma-rollback-button'),
        placeholderText = $rollbackButton.data('placeholder-text'),
        placeholderUrl = $rollbackButton.data('placeholder-url');
      $rollbackButton.html(placeholderText.replace('{VERSION}', $this.val()));
      $rollbackButton.attr('href', placeholderUrl.replace('VERSION', $this.val()));
    }).trigger('change');
    $('.jltma-rollback-button').on('click', function (event) {
      event.preventDefault();
      var $this = $(this),
        dialogsManager = new DialogsManager.Instance();
      dialogsManager.createWidget('confirm', {
        headerMessage: JLTMA_OPTIONS.rollback.rollback_to_previous_version,
        message: JLTMA_OPTIONS.rollback.rollback_confirm,
        strings: {
          cancel: JLTMA_OPTIONS.rollback.cancel,
          confirm: JLTMA_OPTIONS.rollback.yes
        },
        onConfirm: function onConfirm() {
          $this.addClass('loading');
          location.href = $this.attr('href');
        }
      }).show();
    });

    // Copy to Clipboard Section
    (function (n) {
      n.fn.copiq = function (e) {
        var t = n.extend({
          parent: "body",
          content: "",
          onSuccess: function onSuccess() {},
          onError: function onError() {}
        }, e);
        return this.each(function () {
          var e = n(this);
          e.on("click", function () {
            var n = e.parents(t.parent).find(t.content);
            var o = document.createRange();
            var c = window.getSelection();
            o.selectNodeContents(n[0]);
            c.removeAllRanges();
            c.addRange(o);
            try {
              var r = document.execCommand("copy");
              var a = r ? "onSuccess" : "onError";
              t[a](e, n, c.toString());
            } catch (i) {}
            c.removeAllRanges();
          });
        });
      };
    })(jQuery);
    $('.jltma-copy-btn').copiq({
      parent: '.copy-section',
      content: '.api-element-inner',
      onSuccess: function onSuccess($element, source, selection) {
        $('span', $element).text($element.attr("data-text-copied"));
        setTimeout(function () {
          $('span', $element).text($element.attr("data-text"));
        }, 2000);
      }
    });
  });
})(jQuery);

/***/ }),

/***/ "./assets/scss/premium/master-addons-pro.scss":
/*!****************************************************!*\
  !*** ./assets/scss/premium/master-addons-pro.scss ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/tippy/tippy.scss":
/*!**************************************!*\
  !*** ./assets/scss/tippy/tippy.scss ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/plugin-survey.scss":
/*!****************************************!*\
  !*** ./assets/scss/plugin-survey.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/admin/master-addons-admin.scss":
/*!****************************************************!*\
  !*** ./assets/scss/admin/master-addons-admin.scss ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/admin/master-addons-admin-sdk.scss":
/*!********************************************************!*\
  !*** ./assets/scss/admin/master-addons-admin-sdk.scss ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/modules/header-footer/header-footer.scss":
/*!**************************************************************!*\
  !*** ./assets/scss/modules/header-footer/header-footer.scss ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/modules/mega-menu/mega-menu.scss":
/*!******************************************************!*\
  !*** ./assets/scss/modules/mega-menu/mega-menu.scss ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/scss/addons-styles.scss":
/*!****************************************!*\
  !*** ./assets/scss/addons-styles.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/inc/admin/assets/js/master-addons-admin-settings": 0,
/******/ 			"assets/css/master-addons-styles": 0,
/******/ 			"assets/megamenu/css/megamenu": 0,
/******/ 			"inc/modules/header-footer-comment/assets/css/header-footer": 0,
/******/ 			"inc/admin/assets/css/master-addons-admin-sdk": 0,
/******/ 			"inc/admin/assets/css/master-addons-admin": 0,
/******/ 			"assets/css/plugin-survey": 0,
/******/ 			"assets/vendor/tippyjs/css/tippy": 0,
/******/ 			"premium/assets/css/master-addons-pro": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkmaster_addons"] = self["webpackChunkmaster_addons"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./dev/admin/admin-settings.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/admin/master-addons-admin.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/admin/master-addons-admin-sdk.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/modules/header-footer/header-footer.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/modules/mega-menu/mega-menu.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/addons-styles.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/premium/master-addons-pro.scss")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/tippy/tippy.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/master-addons-styles","assets/megamenu/css/megamenu","inc/modules/header-footer-comment/assets/css/header-footer","inc/admin/assets/css/master-addons-admin-sdk","inc/admin/assets/css/master-addons-admin","assets/css/plugin-survey","assets/vendor/tippyjs/css/tippy","premium/assets/css/master-addons-pro"], () => (__webpack_require__("./assets/scss/plugin-survey.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=master-addons-admin-settings.js.map