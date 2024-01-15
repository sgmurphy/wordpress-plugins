"use strict";
(globalThis["webpackChunkyith_woocommerce_ajax_search"] = globalThis["webpackChunkyith_woocommerce_ajax_search"] || []).push([["input-block/input"],{

/***/ "./assets/js/blocks/src/base/components/index.js":
/*!*******************************************************!*\
  !*** ./assets/js/blocks/src/base/components/index.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   PopoverWithContent: () => (/* reexport safe */ _popover_with_content__WEBPACK_IMPORTED_MODULE_1__["default"]),
/* harmony export */   ProductResults: () => (/* reexport safe */ _product_results__WEBPACK_IMPORTED_MODULE_2__["default"]),
/* harmony export */   Root: () => (/* reexport safe */ _root__WEBPACK_IMPORTED_MODULE_3__["default"]),
/* harmony export */   SearchField: () => (/* reexport safe */ _search_field__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _search_field__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./search-field */ "./assets/js/blocks/src/base/components/search-field/index.js");
/* harmony import */ var _popover_with_content__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./popover-with-content */ "./assets/js/blocks/src/base/components/popover-with-content/index.js");
/* harmony import */ var _product_results__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./product-results */ "./assets/js/blocks/src/base/components/product-results/index.js");
/* harmony import */ var _root__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./root */ "./assets/js/blocks/src/base/components/root/index.js");





/***/ }),

/***/ "./assets/js/blocks/src/base/components/popover-with-content/index.js":
/*!****************************************************************************!*\
  !*** ./assets/js/blocks/src/base/components/popover-with-content/index.js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _utils_functions__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../utils/functions */ "./assets/js/blocks/src/base/utils/functions.js");
var _excluded = ["children"];
function _objectWithoutProperties(source, excluded) {
  if (source == null) return {};
  var target = _objectWithoutPropertiesLoose(source, excluded);
  var key, i;
  if (Object.getOwnPropertySymbols) {
    var sourceSymbolKeys = Object.getOwnPropertySymbols(source);
    for (i = 0; i < sourceSymbolKeys.length; i++) {
      key = sourceSymbolKeys[i];
      if (excluded.indexOf(key) >= 0) continue;
      if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
      target[key] = source[key];
    }
  }
  return target;
}
function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;
  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }
  return target;
}



var PopoverWithContent = function PopoverWithContent(_ref) {
  var children = _ref.children,
    props = _objectWithoutProperties(_ref, _excluded);
  var isSmallDevice = (0,_utils_functions__WEBPACK_IMPORTED_MODULE_2__.useMediaQuery)('(max-width: 600px)');
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, !isSmallDevice && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__.Popover, props, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__.Box, {
    className: "popover-content"
  }, children)), isSmallDevice && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__.Box, {
    className: "mobile-search-content"
  }, children));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (PopoverWithContent);

/***/ }),

/***/ "./assets/js/blocks/src/base/components/product-results/index.js":
/*!***********************************************************************!*\
  !*** ./assets/js/blocks/src/base/components/product-results/index.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _result_item__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./result-item */ "./assets/js/blocks/src/base/components/product-results/result-item.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _config__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../config */ "./assets/js/blocks/src/config.js");
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}





var ProductResults = function ProductResults(props) {
  var searchQuery = props.searchQuery,
    results = props.results,
    categoryList = props.categoryList,
    noResults = props.noResults,
    showViewAll = props.showViewAll,
    showViewAllText = props.showViewAllText,
    maxResultsToShow = props.maxResultsToShow;
  var handleClick = function handleClick(e, item) {
    var redirect = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
    e.stopPropagation();
    redirect && goToItemUrl(item);
    var path = '/ywcas/v1/register?itemID=' + item.post_id + '&queryString=' + searchQuery + '&totalResults=' + results.totalResults + '&lang=' + _config__WEBPACK_IMPORTED_MODULE_4__.YWCAS_LANG;
    _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default()({
      path: path
    }).then(null, function (error) {
      console.log(error);
    });
  };
  var goToItemUrl = function goToItemUrl(item) {
    if (item.url) {
      window.location.href = item.url;
    }
  };
  var handleSubmit = function handleSubmit() {
    var showQuery = results.fuzzyToken !== false ? results.fuzzyToken : searchQuery;
    var path = _config__WEBPACK_IMPORTED_MODULE_4__.YWCAS_SITE_URL + '?ywcas=1&post_type=product&lang=' + _config__WEBPACK_IMPORTED_MODULE_4__.YWCAS_LANG + '&s=' + showQuery;
    window.location.href = path;
  };
  var viewAllLabel = showViewAllText.replace('{total}', results.totalResults);
  var items = results.results;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1___default().createElement((react__WEBPACK_IMPORTED_MODULE_1___default().Fragment), null, items && items.length && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Grid, {
    className: "ywcas-search-results-grid",
    columns: 1
  }, items.map(function (item, index) {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1___default().createElement(_result_item__WEBPACK_IMPORTED_MODULE_0__["default"], _extends({
      key: index,
      item: item,
      onClick: handleClick,
      results: results
    }, props));
  })), !items && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Typography, null, noResults), items && showViewAll && maxResultsToShow < results.totalResults && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1___default().createElement("div", {
    className: "ywcas-total-results"
  }, " > ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_1___default().createElement("a", {
    className: "total-results-link",
    href: "#",
    onClick: handleSubmit
  }, viewAllLabel)));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ProductResults);

/***/ }),

/***/ "./assets/js/blocks/src/base/components/product-results/item-thumb.js":
/*!****************************************************************************!*\
  !*** ./assets/js/blocks/src/base/components/product-results/item-thumb.js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var html_react_parser__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! html-react-parser */ "./node_modules/html-react-parser/index.mjs");
/* harmony import */ var _config__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../config */ "./assets/js/blocks/src/config.js");
/* harmony import */ var _utils_functions__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../utils/functions */ "./assets/js/blocks/src/base/utils/functions.js");





var ItemThumb = function ItemThumb(_ref) {
  var imageSize = _ref.imageSize,
    marginLeft = _ref.marginLeft,
    item = _ref.item;
  var productInStock = Boolean(parseInt(item.instock));
  var isSmallDevice = (0,_utils_functions__WEBPACK_IMPORTED_MODULE_4__.useMediaQuery)('(max-width: 500px)');
  var imageWidth = isSmallDevice ? '70' : imageSize;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_1__.Stack, {
    className: "search-result-item__thumbnail",
    sx: {
      width: imageWidth,
      marginLeft: marginLeft
    }
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("img", {
    src: item.thumbnail,
    alt: item.name,
    width: imageWidth
  }));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ItemThumb);

/***/ }),

/***/ "./assets/js/blocks/src/base/components/product-results/result-item.js":
/*!*****************************************************************************!*\
  !*** ./assets/js/blocks/src/base/components/product-results/result-item.js ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var html_react_parser__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! html-react-parser */ "./node_modules/html-react-parser/index.mjs");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _utils_functions__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../utils/functions */ "./assets/js/blocks/src/base/utils/functions.js");
/* harmony import */ var _item_thumb__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./item-thumb */ "./assets/js/blocks/src/base/components/product-results/item-thumb.js");
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}
/* global ywcas_search_results_block_parameter */







function ResultItem(props) {
  var item = props.item,
    searchQuery = props.searchQuery,
    _onClick = props.onClick,
    showName = props.showName,
    showImage = props.showImage,
    layout = props.layout,
    imageSize = props.imageSize,
    productNameColor = props.productNameColor,
    results = props.results;
  var stackDirection = 'row';
  var stackAlign = 'center';
  var marginLeft = 0;
  var ItemName = function ItemName() {
    if (!showImage && (0,_utils_functions__WEBPACK_IMPORTED_MODULE_5__.isEmpty)(item.thumbnail)) {
      return '';
    }
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Stack, {
      className: "search-result-item_name",
      sx: {
        flex: 1,
        alignItems: 'left'
      },
      onClick: function onClick(e) {
        return _onClick(e, item, results.totalResults);
      }
    }, showName && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Typography, {
      sx: {
        color: productNameColor,
        fontSize: '0.9em'
      },
      className: "search-result-item__name"
    }, (0,html_react_parser__WEBPACK_IMPORTED_MODULE_1__["default"])(item.name)));
  };
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Box, {
    className: "search-result-item list"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Stack, {
    align: stackAlign,
    direction: stackDirection,
    spacing: 2,
    className: "search-result-item__content",
    "data-id": item.post_id,
    "data-name": item.name,
    onClick: function onClick(e) {
      return _onClick(e, item);
    }
  }, showImage && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_item_thumb__WEBPACK_IMPORTED_MODULE_6__["default"], _extends({
    marginLeft: marginLeft,
    item: item
  }, props)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(ItemName, null)));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ResultItem);

/***/ }),

/***/ "./assets/js/blocks/src/base/components/root/index.js":
/*!************************************************************!*\
  !*** ./assets/js/blocks/src/base/components/root/index.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _lapilli_ui_styles__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @lapilli-ui/styles */ "@lapilli-ui/styles");
/* harmony import */ var _lapilli_ui_styles__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_styles__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__);
function _slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}
function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;
  for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
  return arr2;
}
function _iterableToArrayLimit(r, l) {
  var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"];
  if (null != t) {
    var e,
      n,
      i,
      u,
      a = [],
      f = !0,
      o = !1;
    try {
      if (i = (t = t.call(r)).next, 0 === l) {
        if (Object(t) !== t) return;
        f = !1;
      } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0);
    } catch (r) {
      o = !0, n = r;
    } finally {
      try {
        if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return;
      } finally {
        if (o) throw n;
      }
    }
    return a;
  }
}
function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}



var Root = function Root(_ref) {
  var children = _ref.children;
  var _useState = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(),
    _useState2 = _slicedToArray(_useState, 2),
    doc = _useState2[0],
    setDoc = _useState2[1];
  return /*#__PURE__*/React.createElement("div", {
    ref: function ref(node) {
      return node && (node === null || node === void 0 ? void 0 : node.ownerDocument) && setDoc(node.ownerDocument);
    }
  }, doc && /*#__PURE__*/React.createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalDocumentProvider, {
    document: doc
  }, /*#__PURE__*/React.createElement(_lapilli_ui_styles__WEBPACK_IMPORTED_MODULE_1__.StyledProvider, {
    document: doc
  }, children)));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Root);

/***/ }),

/***/ "./assets/js/blocks/src/base/components/search-field/index.js":
/*!********************************************************************!*\
  !*** ./assets/js/blocks/src/base/components/search-field/index.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../common */ "./assets/js/blocks/src/common.js");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _submit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./submit */ "./assets/js/blocks/src/base/components/search-field/submit.js");
/* harmony import */ var _config__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../../config */ "./assets/js/blocks/src/config.js");






var SearchField = function SearchField(_ref) {
  var queryString = _ref.queryString,
    placeholder = _ref.placeholder,
    placeholderTextColor = _ref.placeholderTextColor,
    inputTextColor = _ref.inputTextColor,
    inputBgColor = _ref.inputBgColor,
    inputBgFocusColor = _ref.inputBgFocusColor,
    inputBorderColor = _ref.inputBorderColor,
    inputBorderFocusColor = _ref.inputBorderFocusColor,
    inputBorderSize = _ref.inputBorderSize,
    inputBorderRadius = _ref.inputBorderRadius,
    submitContentColor = _ref.submitContentColor,
    submitContentHoverColor = _ref.submitContentHoverColor,
    submitBgColor = _ref.submitBgColor,
    submitBgHoverColor = _ref.submitBgHoverColor,
    submitBorderColor = _ref.submitBorderColor,
    submitBorderHoverColor = _ref.submitBorderHoverColor,
    submitStyle = _ref.submitStyle,
    size = _ref.size,
    setSearchQuery = _ref.setSearchQuery,
    iconType = _ref.iconType,
    buttonLabel = _ref.buttonLabel,
    buttonBorderRadius = _ref.buttonBorderRadius,
    _ref$onFocus = _ref.onFocus,
    onFocus = _ref$onFocus === void 0 ? null : _ref$onFocus,
    _ref$onBlur = _ref.onBlur,
    onBlur = _ref$onBlur === void 0 ? null : _ref$onBlur,
    _ref$onCloseMobile = _ref.onCloseMobile,
    onCloseMobile = _ref$onCloseMobile === void 0 ? null : _ref$onCloseMobile,
    _ref$isSmallDevice = _ref.isSmallDevice,
    isSmallDevice = _ref$isSmallDevice === void 0 ? false : _ref$isSmallDevice;
  var getStyleOfIcon = function getStyleOfIcon() {
    return {
      borderRadius: '50%',
      backgroundColor: "".concat(submitBgColor, "!important"),
      border: '1px solid',
      borderColor: "".concat(submitBorderColor || '#FFF', " !important"),
      'svg': {
        height: submitBgColor !== '' && submitBgColor.toLowerCase() !== '#fff' && submitBgColor.toLowerCase() !== '#ffffff' ? '20px' : '24px'
      },
      '&:hover, & > sgv:hover': {
        backgroundColor: "".concat(submitBgHoverColor, "!important"),
        borderColor: "".concat(submitBorderHoverColor || '#FFF', " !important")
      }
    };
  };
  var getStyleSearchField = function getStyleSearchField() {
    return {
      '& .ywcas-input-field-wrapper': {
        flex: 1,
        borderRadius: "".concat(inputBorderRadius.topLeft, " ").concat(inputBorderRadius.topRight, " ").concat(inputBorderRadius.bottomRight, " ").concat(inputBorderRadius.bottomLeft),
        borderColor: "".concat(inputBorderColor || '#7C7C7C', "!important"),
        borderWidth: "".concat(inputBorderSize.topLeft, " ").concat(inputBorderSize.topRight, "  ").concat(inputBorderSize.bottomLeft, " ").concat(inputBorderSize.bottomRight),
        backgroundColor: "".concat(inputBgColor || '#FFF', "!important"),
        borderStyle: 'solid',
        overflow: 'hidden',
        '&:focus-within': {
          backgroundColor: "".concat(inputBgFocusColor || '#FFF', "!important"),
          borderColor: "".concat(inputBorderFocusColor || '#5B5B5B', "!important")
        },
        '& >div': {
          width: '100%',
          padding: 0,
          input: {
            flex: 1
          },
          'div:last-child': {
            display: 'none'
          }
        }
      },
      '& .ywcas-input-field input': {
        color: "".concat(inputTextColor || '#000', " !important"),
        fontSize: '1rem!important'
      },
      '& .ywcas-input-field input::placeholder': {
        color: "".concat(placeholderTextColor || '#000'),
        opacity: 1 /* Firefox */
      },

      '& .ywcas-submit-button': {
        color: "".concat(submitContentColor || '#fff', " !important"),
        backgroundColor: "".concat(submitBgColor || '#a7ab06', " !important"),
        borderColor: "".concat(submitBorderColor || '#FFF', " !important"),
        borderRadius: "".concat(buttonBorderRadius.topLeft, " ").concat(buttonBorderRadius.topRight, "  ").concat(buttonBorderRadius.bottomRight, "  ").concat(buttonBorderRadius.bottomLeft)
      },
      '& .ywcas-submit-button:hover': {
        color: "".concat(submitContentHoverColor || '#fff', " !important"),
        backgroundColor: "".concat(submitBgHoverColor || '#a7ab06', " !important"),
        borderColor: "".concat(submitBorderHoverColor || '#FFF', " !important")
      },
      '& .ywcas-submit-icon': {
        color: "".concat(submitContentColor || '#000', " !important")
      },
      '&:hover .ywcas-submit-icon, & .ywcas-submit-icon:hover': {
        color: "".concat(submitContentHoverColor || '#000', " !important")
      }
    };
  };
  var handleSubmit = function handleSubmit() {
    if ('' !== queryString) {
      var path = _config__WEBPACK_IMPORTED_MODULE_5__.YWCAS_SITE_URL + '?ywcas=1&post_type=product&lang=' + _config__WEBPACK_IMPORTED_MODULE_5__.YWCAS_LANG + '&s=' + queryString;
      window.location.href = path;
    }
  };
  var onKeyDown = function onKeyDown(event) {
    if (event.key === 'Enter') {
      handleSubmit();
    }
  };
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Box, {
    className: "ywcas-block-components-search-field",
    sx: getStyleSearchField()
  }, isSmallDevice && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    className: "mobile-search-close",
    onClick: onCloseMobile
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
    icon: (0,_common__WEBPACK_IMPORTED_MODULE_2__.CloseIcon)()
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Stack, {
    direction: "row",
    spacing: 0
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Stack, {
    className: "ywcas-input-field-wrapper"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Input, {
    className: "ywcas-input-field",
    placeholder: placeholder,
    autoComplete: "off",
    size: size,
    value: queryString,
    onChange: setSearchQuery,
    onFocus: onFocus,
    onBlur: onBlur,
    onKeyDown: onKeyDown,
    startAdornment: submitStyle === 'icon' && iconType === 'icon-left' ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_3__.Box, {
      className: "ywcas-submit-wrapper",
      sx: getStyleOfIcon()
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
      className: "ywcas-submit-icon",
      icon: (0,_common__WEBPACK_IMPORTED_MODULE_2__.MagnifyingGlassIcon)()
    })) : null,
    endAdornment: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_submit__WEBPACK_IMPORTED_MODULE_4__["default"], {
      submitStyle: submitStyle,
      buttonLabel: buttonLabel,
      submitBgColor: submitBgColor,
      iconType: iconType,
      onClick: handleSubmit,
      wrapperStyle: getStyleOfIcon()
    })
  })))));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (SearchField);

/***/ }),

/***/ "./assets/js/blocks/src/base/components/search-field/submit.js":
/*!*********************************************************************!*\
  !*** ./assets/js/blocks/src/base/components/search-field/submit.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _common__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../common */ "./assets/js/blocks/src/common.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__);



var Submit = function Submit(_ref) {
  var submitStyle = _ref.submitStyle,
    buttonLabel = _ref.buttonLabel,
    iconType = _ref.iconType,
    onClick = _ref.onClick,
    wrapperStyle = _ref.wrapperStyle;
  switch (submitStyle) {
    case 'text':
      return /*#__PURE__*/React.createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
        className: "ywcas-submit-button",
        color: "secondary",
        size: "sm",
        onClick: onClick
      }, buttonLabel);
    case 'icon':
      return iconType === 'icon-right' && /*#__PURE__*/React.createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__.Box, {
        className: "ywcas-submit-wrapper",
        sx: wrapperStyle
      }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
        className: "ywcas-submit-icon",
        onClick: onClick,
        icon: (0,_common__WEBPACK_IMPORTED_MODULE_0__.MagnifyingGlassIcon)()
      }));
    case 'iconText':
      return /*#__PURE__*/React.createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
        className: "ywcas-submit-button",
        color: "secondary",
        size: "sm",
        onClick: onClick
      }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
        className: "ywcas-submit-icon",
        icon: (0,_common__WEBPACK_IMPORTED_MODULE_0__.MagnifyingGlassIcon)()
      }), " ", buttonLabel);
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Submit);

/***/ }),

/***/ "./assets/js/blocks/src/base/utils/functions.js":
/*!******************************************************!*\
  !*** ./assets/js/blocks/src/base/utils/functions.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   formatPrice: () => (/* binding */ formatPrice),
/* harmony export */   formatSinglePrice: () => (/* binding */ formatSinglePrice),
/* harmony export */   formatString: () => (/* binding */ formatString),
/* harmony export */   getPrice: () => (/* binding */ getPrice),
/* harmony export */   getTopFrequentCategories: () => (/* binding */ getTopFrequentCategories),
/* harmony export */   getWordStr: () => (/* binding */ getWordStr),
/* harmony export */   isEmpty: () => (/* binding */ isEmpty),
/* harmony export */   useMediaQuery: () => (/* binding */ useMediaQuery)
/* harmony export */ });
/* harmony import */ var html_react_parser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! html-react-parser */ "./node_modules/html-react-parser/index.mjs");
/* harmony import */ var _config__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../config */ "./assets/js/blocks/src/config.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_2__);
function _slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
function _iterableToArrayLimit(r, l) {
  var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"];
  if (null != t) {
    var e,
      n,
      i,
      u,
      a = [],
      f = !0,
      o = !1;
    try {
      if (i = (t = t.call(r)).next, 0 === l) {
        if (Object(t) !== t) return;
        f = !1;
      } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0);
    } catch (r) {
      o = !0, n = r;
    } finally {
      try {
        if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return;
      } finally {
        if (o) throw n;
      }
    }
    return a;
  }
}
function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}
function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}
function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}
function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}
function _createForOfIteratorHelper(o, allowArrayLike) {
  var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"];
  if (!it) {
    if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") {
      if (it) o = it;
      var i = 0;
      var F = function F() {};
      return {
        s: F,
        n: function n() {
          if (i >= o.length) return {
            done: true
          };
          return {
            done: false,
            value: o[i++]
          };
        },
        e: function e(_e) {
          throw _e;
        },
        f: F
      };
    }
    throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }
  var normalCompletion = true,
    didErr = false,
    err;
  return {
    s: function s() {
      it = it.call(o);
    },
    n: function n() {
      var step = it.next();
      normalCompletion = step.done;
      return step;
    },
    e: function e(_e2) {
      didErr = true;
      err = _e2;
    },
    f: function f() {
      try {
        if (!normalCompletion && it["return"] != null) it["return"]();
      } finally {
        if (didErr) throw err;
      }
    }
  };
}
function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}
function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;
  for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
  return arr2;
}
function _typeof(o) {
  "@babel/helpers - typeof";

  return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) {
    return typeof o;
  } : function (o) {
    return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o;
  }, _typeof(o);
}



/**
 * Check if an element object or array is empty
 *
 * @param element
 * @returns {boolean}
 */
var isEmpty = function isEmpty(element) {
  if (typeof element === 'undefined') {
    return true;
  }
  if (_typeof(element) === 'object') {
    return Object.keys(element).length === 0;
  }
  return element.hasOwnProperty(length) ? element.length === 0 : 'undefined';
};
var formatSinglePrice = function formatSinglePrice(price) {
  return accounting.formatMoney(price, _config__WEBPACK_IMPORTED_MODULE_1__.ywcas_wc_data.currency);
};
var formatPrice = function formatPrice(max) {
  var min = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
  var maxFormatted = formatSinglePrice(max);
  if (!parseFloat(min) || min === max) {
    return maxFormatted;
  }
  var minFormatted = formatSinglePrice(min);
  return "".concat(minFormatted, " - ").concat(maxFormatted);
};

/**
 * Return the price of a product
 *
 * @param item
 * @returns {*|string}
 */
var getPrice = function getPrice(item) {
  if (item.product_type === 'variable') {
    return formatPrice(item['max_price'], item['min_price']);
  } else {
    if (parseInt(item.onsale)) {
      return formatPrice(item['min_price']);
    }
  }
  return formatPrice(item['max_price']);
};
var getWordStr = function getWordStr(str, numOfWords) {
  return str.split(' ').slice(0, numOfWords).join(" ");
};
var escapeRegExChars = function escapeRegExChars(value) {
  return value ? value.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&") : value;
};
var formatString = function formatString(query, currentText) {
  var pattern = '(' + escapeRegExChars(query) + ')';
  return (0,html_react_parser__WEBPACK_IMPORTED_MODULE_0__["default"])(currentText.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>'));
};
var getTopFrequentCategories = function getTopFrequentCategories(numbers) {
  var numberOfResults = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 3;
  // Count the occurrences of each number
  var frequencyMap = new Map();
  var _iterator = _createForOfIteratorHelper(numbers),
    _step;
  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var number = _step.value;
      if (frequencyMap.has(number)) {
        frequencyMap.set(number, frequencyMap.get(number) + 1);
      } else {
        frequencyMap.set(number, 1);
      }
    }
    // Sort the frequency map by values in descending order
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
  var sortedFrequency = _toConsumableArray(frequencyMap.entries()).sort(function (a, b) {
    return b[1] - a[1];
  });
  return sortedFrequency.slice(0, numberOfResults).map(function (entry) {
    return entry[0];
  });
};
var useMediaQuery = function useMediaQuery(query) {
  var mediaQuery = (0,react__WEBPACK_IMPORTED_MODULE_2__.useMemo)(function () {
    return window.matchMedia(query);
  }, [query]);
  var _useState = (0,react__WEBPACK_IMPORTED_MODULE_2__.useState)(mediaQuery.matches),
    _useState2 = _slicedToArray(_useState, 2),
    match = _useState2[0],
    setMatch = _useState2[1];
  (0,react__WEBPACK_IMPORTED_MODULE_2__.useEffect)(function () {
    var onChange = function onChange() {
      return setMatch(mediaQuery.matches);
    };
    mediaQuery.addEventListener("change", onChange);
    return function () {
      return mediaQuery.removeEventListener("change", onChange);
    };
  }, [mediaQuery]);
  return match;
};

/***/ }),

/***/ "./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/attributes.js":
/*!*****************************************************************************************!*\
  !*** ./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/attributes.js ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/**
 * External dependencies
 */

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  placeholder: {
    type: 'string',
    "default": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Search products...', 'yith-woocommerce-ajax-search')
  },
  placeholderTextColor: {
    type: 'string',
    "default": '#000'
  },
  iconType: {
    type: 'string',
    "default": 'icon-right'
  },
  inputTextColor: {
    type: 'string',
    "default": '#000'
  },
  inputBgColor: {
    type: 'string',
    "default": '#fff'
  },
  inputBgFocusColor: {
    type: 'string',
    "default": '#fff'
  },
  inputBorderColor: {
    type: 'string',
    "default": '#7C7C7C'
  },
  inputBorderFocusColor: {
    type: 'string',
    "default": '#5B5B5B'
  },
  inputBorderSize: {
    type: 'object',
    "default": {
      topLeft: "1px",
      topRight: "1px",
      bottomLeft: "1px",
      bottomRight: "1px"
    }
  },
  inputBorderRadius: {
    type: 'object',
    "default": {
      topLeft: "20px",
      topRight: "20px",
      bottomLeft: "20px",
      bottomRight: "20px"
    }
  },
  submitContentColor: {
    type: 'string',
    "default": '#000'
  },
  submitContentHoverColor: {
    type: 'string',
    "default": '#000'
  },
  submitBorderColor: {
    type: 'string',
    "default": '#fff'
  },
  submitBorderHoverColor: {
    type: 'string',
    "default": '#fff'
  },
  submitBgColor: {
    type: 'string',
    "default": '#fff'
  },
  submitBgHoverColor: {
    type: 'string',
    "default": '#fff'
  },
  submitStyle: {
    type: 'string',
    "default": 'icon'
  },
  className: {
    type: 'string',
    "default": 'ywcas-input-block'
  },
  buttonLabel: {
    type: 'string',
    "default": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Search', 'yith-woocommerce-ajax-search-premium')
  },
  buttonBorderRadius: {
    type: 'object',
    "default": {
      topLeft: "10px",
      topRight: "10px",
      bottomLeft: "10px",
      bottomRight: "10px"
    }
  },
  lock: {
    type: 'object',
    "default": {
      remove: false,
      move: false
    }
  }
});

/***/ }),

/***/ "./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/block.js":
/*!************************************************************************************!*\
  !*** ./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/block.js ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @lapilli-ui/components */ "@lapilli-ui/components");
/* harmony import */ var _lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _base_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../base/components */ "./assets/js/blocks/src/base/components/index.js");
/* harmony import */ var _context__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../context */ "./assets/js/blocks/src/blocks/search-block/context.js");
/* harmony import */ var _base_utils_functions__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../../../base/utils/functions */ "./assets/js/blocks/src/base/utils/functions.js");
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}
function _slicedToArray(arr, i) {
  return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest();
}
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}
function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}
function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;
  for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
  return arr2;
}
function _iterableToArrayLimit(r, l) {
  var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"];
  if (null != t) {
    var e,
      n,
      i,
      u,
      a = [],
      f = !0,
      o = !1;
    try {
      if (i = (t = t.call(r)).next, 0 === l) {
        if (Object(t) !== t) return;
        f = !1;
      } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0);
    } catch (r) {
      o = !0, n = r;
    } finally {
      try {
        if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return;
      } finally {
        if (o) throw n;
      }
    }
    return a;
  }
}
function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}






var Block = function Block(props) {
  var _props$placeholder = props.placeholder,
    placeholder = _props$placeholder === void 0 ? '' : _props$placeholder;
  var _useSearchContext = (0,_context__WEBPACK_IMPORTED_MODULE_4__.useSearchContext)(),
    query = _useSearchContext.query,
    setQuery = _useSearchContext.setQuery,
    inputFocused = _useSearchContext.inputFocused,
    setInputFocused = _useSearchContext.setInputFocused,
    size = _useSearchContext.size;
  var ref = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useRef)(null);
  var isSmallDevice = (0,_base_utils_functions__WEBPACK_IMPORTED_MODULE_5__.useMediaQuery)('(max-width: 600px)');
  var _useState = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(false),
    _useState2 = _slicedToArray(_useState, 2),
    mobileOpened = _useState2[0],
    setMobileOpened = _useState2[1];
  var _useState3 = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useState)(query),
    _useState4 = _slicedToArray(_useState3, 2),
    q = _useState4[0],
    setQ = _useState4[1];
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(function () {
    setQ(query);
  }, [query]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(function () {
    var delayUpdate = setTimeout(function () {
      setQuery(q);
    }, 500);
    return function () {
      return clearTimeout(delayUpdate);
    };
  }, [q]);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.useEffect)(function () {
    if (inputFocused) {
      if (isSmallDevice) {
        !mobileOpened && createSearchMobile();
      } else {
        destroySearchMobile();
      }
    }
  }, [isSmallDevice, inputFocused]);
  var createSearchMobile = function createSearchMobile() {
    var wpAdmin = document.querySelector('#wpadminbar');
    var yithDemo = document.querySelector('#ywtenv-banner');
    var searchMobile = document.querySelector('.ywcas-search-mobile');
    if (!searchMobile) {
      searchMobile = document.createElement('div');
      searchMobile.classList.add('ywcas-search-mobile');
      (wpAdmin || yithDemo) && searchMobile.classList.add('with-wp-admin-toolbar');
      var block = inputFocused.closest('.wp-block-yith-search-block');
      var index = Array.prototype.indexOf.call(block.parentNode.childNodes, block);
      block.parentNode.classList.add('ywcas-block-mounted');
      block.parentNode.dataset.ywcasTarget = index;
      searchMobile.append(block);
      document.body.append(searchMobile);
      document.body.classList.add('ywcas-disable-overflow');
      document.documentElement.style.overflow = 'hidden';
      setMobileOpened(true);
    }
  };
  var destroySearchMobile = function destroySearchMobile() {
    var wrapper = document.querySelector('.ywcas-search-mobile');
    if (wrapper) {
      var block = wrapper.querySelector('.wp-block-yith-search-block');
      var targetElement = document.querySelector('.ywcas-block-mounted');
      var oldPosition = targetElement.dataset.ywcasTarget;
      if (oldPosition < targetElement.childNodes.length - 1) {
        targetElement.insertBefore(block, targetElement.childNodes[oldPosition]);
      } else {
        targetElement.append(block);
      }
      wrapper.remove();
      targetElement.classList.remove('ywcas-block-mounted');
      document.body.classList.remove('ywcas-disable-overflow');
      document.documentElement.style.overflow = '';
    }
    setMobileOpened(false);
  };
  var resetQuery = function resetQuery() {
    destroySearchMobile();
    setQ('');
    setInputFocused(null);
  };
  var onCloseMobile = function onCloseMobile() {
    resetQuery();
    var event = new CustomEvent('ywcas-close-mobile', {
      detail: {},
      bubbles: true,
      cancelable: true,
      composed: false
    });
    document.dispatchEvent(event);
  };
  var handleOnChange = function handleOnChange(event, value) {
    if (!event) {
      setQ(value);
    } else {
      event.stopPropagation();
      if (!inputFocused) {
        setInputFocused(ref === null || ref === void 0 ? void 0 : ref.current);
      }
      if (q !== event.target.value) {
        setQ(event.target.value);
      }
    }
  };
  var setFocusOn = function setFocusOn() {
    setInputFocused(ref === null || ref === void 0 ? void 0 : ref.current);
  };
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_lapilli_ui_components__WEBPACK_IMPORTED_MODULE_2__.Box, {
    ref: ref
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_base_components__WEBPACK_IMPORTED_MODULE_3__.SearchField, _extends({
    placeholder: placeholder,
    setSearchQuery: handleOnChange,
    queryString: q,
    onFocus: setFocusOn,
    onCloseMobile: onCloseMobile,
    size: size,
    isSmallDevice: isSmallDevice
  }, props)));
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Block);

/***/ }),

/***/ "./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/frontend.js":
/*!***************************************************************************************!*\
  !*** ./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/frontend.js ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _data_shared_hocs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../data/shared/hocs */ "./assets/js/blocks/src/data/shared/hocs/index.js");
/* harmony import */ var _block__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block */ "./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/block.js");
/* harmony import */ var _attributes__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./attributes */ "./assets/js/blocks/src/blocks/search-block/inner-blocks/input-block/attributes.js");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ((0,_data_shared_hocs__WEBPACK_IMPORTED_MODULE_0__.withFilteredAttributes)(_attributes__WEBPACK_IMPORTED_MODULE_2__["default"])(_block__WEBPACK_IMPORTED_MODULE_1__["default"]));

/***/ }),

/***/ "./assets/js/blocks/src/data/shared/hocs/index.js":
/*!********************************************************!*\
  !*** ./assets/js/blocks/src/data/shared/hocs/index.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   withFilteredAttributes: () => (/* reexport safe */ _with_filtered_attributes__WEBPACK_IMPORTED_MODULE_0__.withFilteredAttributes)
/* harmony export */ });
/* harmony import */ var _with_filtered_attributes__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./with-filtered-attributes */ "./assets/js/blocks/src/data/shared/hocs/with-filtered-attributes.js");


/***/ }),

/***/ "./assets/js/blocks/src/data/shared/hocs/with-filtered-attributes.js":
/*!***************************************************************************!*\
  !*** ./assets/js/blocks/src/data/shared/hocs/with-filtered-attributes.js ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   withFilteredAttributes: () => (/* binding */ withFilteredAttributes)
/* harmony export */ });
/* harmony import */ var _base_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../base/utils */ "./assets/js/blocks/src/base/utils/index.js");
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}


/**
 * HOC that filters given attributes by valid block attribute values, or uses defaults if undefined.
 *
 * @param {Object} blockAttributes Component being wrapped.
 */
var withFilteredAttributes = function withFilteredAttributes(blockAttributes) {
  return function (OriginalComponent) {
    return function (ownProps) {
      var validBlockAttributes = (0,_base_utils__WEBPACK_IMPORTED_MODULE_0__.getValidBlockAttributes)(blockAttributes, ownProps);
      return /*#__PURE__*/React.createElement(OriginalComponent, _extends({}, ownProps, validBlockAttributes));
    };
  };
};

/***/ })

}]);
//# sourceMappingURL=input.js.map