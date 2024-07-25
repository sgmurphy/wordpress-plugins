/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/admin/order/export_invoice.js":
/*!*****************************************************!*\
  !*** ./assets/src/js/admin/order/export_invoice.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ export_invoice)
/* harmony export */ });
/**
 * Export invoice to PDF
 */
function export_invoice() {
  let html2pdf_obj, modal;
  document.addEventListener('click', e => {
    const target = e.target;
    if (target.id === 'lp-invoice__export') {
      html2pdf_obj.save();
    } else if (target.id === 'lp-invoice__update') {
      const elOption = document.querySelector('.export-options__content');
      const fields = elOption.querySelectorAll('input');
      const fieldNameUnChecked = [];
      fields.forEach(field => {
        if (!field.checked) {
          fieldNameUnChecked.push(field.name);
        }
      });
      window.localStorage.setItem('lp_invoice_un_fields', JSON.stringify(fieldNameUnChecked));
      window.localStorage.setItem('lp_invoice_show', 1);
      window.location.reload();
    }
  });
  const exportPDF = () => {
    const pdfOptions = {
      margin: [0, 0, 0, 5],
      filename: document.title,
      image: {
        type: 'webp'
      },
      html2canvas: {
        scale: 2.5
      },
      jsPDF: {
        format: 'a4',
        orientation: 'p'
      }
    };
    const html = document.querySelector('#lp-invoice__content');
    html2pdf_obj = html2pdf().set(pdfOptions).from(html);
  };
  const showInfoFields = () => {
    // Get fields name checked
    const fieldsChecked = window.localStorage.getItem('lp_invoice_un_fields');
    const elOptions = document.querySelector('.export-options__content');
    const elInvoiceFields = document.querySelectorAll('.invoice-field');
    elInvoiceFields.forEach(field => {
      const nameClass = field.classList[1];
      if (fieldsChecked && fieldsChecked.includes(nameClass)) {
        field.remove();
        const elOption = elOptions.querySelector(`[name=${nameClass}]`);
        if (elOption) {
          elOption.checked = false;
        }
      }
    });
    const showInvoice = parseInt(window.localStorage.getItem('lp_invoice_show'));
    if (showInvoice === 1) {
      modal.style.display = 'block';
    }
  };
  document.addEventListener('DOMContentLoaded', () => {
    const elExportSection = document.querySelector('#order-export__section');
    if (!elExportSection.length) {
      const tabs = document.querySelectorAll('.tabs');
      const tab = document.querySelectorAll('.tab');
      const panel = document.querySelectorAll('.panel');
      function onTabClick(event) {
        // deactivate existing active tabs and panel

        for (let i = 0; i < tab.length; i++) {
          tab[i].classList.remove('active');
        }
        for (let i = 0; i < panel.length; i++) {
          panel[i].classList.remove('active');
        }

        // activate new tabs and panel
        event.target.classList.add('active');
        const classString = event.target.getAttribute('data-target');
        document.getElementById('panels').getElementsByClassName(classString)[0].classList.add('active');
      }
      for (let i = 0; i < tab.length; i++) {
        tab[i].addEventListener('click', onTabClick, false);
      }

      // Get the modal
      modal = document.getElementById('myModal');
      // Get the button that opens the modal
      const btn = document.getElementById('order-export__button');
      // Get the <span> element that closes the modal
      const span = document.getElementsByClassName('close')[0];
      // When the user clicks on the button, open the modal
      btn.onclick = function () {
        modal.style.display = 'block';
      };

      // When the user clicks on <span> (x), close the modal
      span.onclick = function () {
        modal.style.display = 'none';
        window.localStorage.setItem('lp_invoice_show', 0);
      };

      // When the user clicks anywhere outside the modal, close it
      window.onclick = function (event) {
        if (event.target === modal) {
          modal.style.display = 'none';
          window.localStorage.setItem('lp_invoice_show', 0);
        }
      };
      showInfoFields();
      exportPDF();
    }
  });
}

/***/ }),

/***/ "./assets/src/js/admin/order/modal-search-courses.js":
/*!***********************************************************!*\
  !*** ./assets/src/js/admin/order/modal-search-courses.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../utils */ "./assets/src/js/utils.js");
/* harmony import */ var _wordpress_url__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/url */ "@wordpress/url");
/* harmony import */ var _wordpress_url__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_url__WEBPACK_IMPORTED_MODULE_1__);


let data = {},
  paged = 1,
  term = '',
  hasItems = false,
  selectedItems = [];
const lpOrderNode = document.querySelector('#learn-press-order');
let listItems, displayModalBtn;
const modalSearchCourses = () => {
  if (!lpOrderNode) {
    return;
  }
  listItems = lpOrderNode.querySelector('.list-order-items tbody');
  displayModalBtn = lpOrderNode.querySelector('#learn-press-add-order-item');
  displayModal();
  doSearch();
  loadPage();
  selectItems();
  addItems();
  closeModal();
  removeItem();
};
const removeItem = () => {
  document.addEventListener('click', function (event) {
    const target = event.target;
    if (!target.classList.contains('remove-order-item') && !target.closest('.remove-order-item')) {
      return;
    }
    const lpOrderNode = target.closest('#learn-press-order');
    if (!lpOrderNode) {
      return;
    }
    event.preventDefault();
    const item = target.closest('tr');
    const itemId = item.getAttribute('data-item_id');
    item.remove();
    const orderItems = lpOrderNode.querySelectorAll('.list-order-items tbody tr:not(.no-order-items)');
    const noOrderItems = lpOrderNode.querySelector('.list-order-items tbody .no-order-items');
    if (orderItems.length === 0) {
      noOrderItems.style.display = 'block';
    }
    const query = {
      order_id: document.querySelector('#post_ID').value,
      items: [itemId],
      'lp-ajax': 'remove_items_from_order',
      remove_nonce: target.closest('.order-item-row').dataset.remove_nonce
    };
    const params = new URLSearchParams();
    for (const [key, value] of Object.entries(query)) {
      if (Array.isArray(value)) {
        value.forEach(item => params.append(`${key}[]`, item));
      } else {
        params.append(key, value);
      }
    }
    fetch(window.location.href, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: params
    }).then(response => response.text()).then(response => {
      const data = (0,_utils__WEBPACK_IMPORTED_MODULE_0__.lpAjaxParseJsonOld)(response);
      lpOrderNode.querySelector('.order-subtotal').innerHTML = data.order_data.subtotal_html;
      lpOrderNode.querySelector('.order-total').innerHTML = data.order_data.total_html;
      // lpOrderNode.querySelector( '#item-container' ).innerHTML = data.item_html;
    }).catch(error => {
      console.error('Error:', error);
    });
  });
};
const getAddedItems = () => {
  const orderItems = document.querySelectorAll('#learn-press-order .list-order-items tbody .order-item-row');
  return [...orderItems].map(orderItem => {
    return parseInt(orderItem.getAttribute('data-id'));
  });
};
const focusSearch = _.debounce(function () {
  document.querySelector('#modal-search-items input[name="search"]').focus();
}, 200);
const mountSearchModal = () => {
  const modalSearchItems = document.querySelector('#learn-press-modal-search-items');
  const modalContainer = document.querySelector('#container-modal-search-items');
  modalContainer.innerHTML = modalSearchItems.innerHTML;
};
const renderSearchResult = courses => {
  let html = '';
  for (let i = 0; i < courses.length; i++) {
    html += `
		<li class="lp-result-item" data-id="${courses[i].ID}" data-type="lp_course" data-text="${courses[i].post_title}">
			<label>
				<input type="checkbox" value="${courses[i].ID}" name="selectedItems[]">
				<span class="lp-item-text">${courses[i].post_title} (Course - #${courses[i].ID})</span>
			</label>
		</li>`;
  }
  return html;
};
const renderPagination = (currentPage, maxPage) => {
  currentPage = parseInt(currentPage);
  maxPage = parseInt(maxPage);
  let html = '';
  if (maxPage <= 1) {
    return html;
  }
  const nextPage = currentPage + 1;
  const prevPage = currentPage - 1;
  let pages = [];
  if (maxPage <= 9) {
    for (let i = 1; i <= maxPage; i++) {
      pages.push(i);
    }
  } else if (currentPage <= 3) {
    // x is ...
    pages = [1, 2, 3, 4, 5, 'x', maxPage];
  } else if (currentPage <= 5) {
    for (let i = 1; i <= currentPage; i++) {
      pages.push(i);
    }
    for (let j = 1; j <= 2; j++) {
      const tempPage = currentPage + j;
      pages.push(tempPage);
    }
    pages.push('x');
    pages.push(maxPage);
  } else {
    pages = [1, 'x'];
    for (let k = 2; k >= 0; k--) {
      const tempPage = currentPage - k;
      pages.push(tempPage);
    }
    const currentToLast = maxPage - currentPage;
    if (currentToLast <= 5) {
      for (let m = currentPage + 1; m <= maxPage; m++) {
        pages.push(m);
      }
    } else {
      for (let n = 1; n <= 2; n++) {
        const tempPage = currentPage + n;
        pages.push(tempPage);
      }
      pages.push('x');
      pages.push(maxPage);
    }
  }
  const maximum = pages.length;
  if (currentPage !== 1) {
    html += `<a class="prev page-numbers button" href="#" data-page="${prevPage}"><</a>`;
  }
  for (let i = 0; i < maximum; i++) {
    if (currentPage === parseInt(pages[i])) {
      html += `<a aria-current="page" class="page-numbers current button disabled" data-page="${pages[i]}">
				${pages[i]}
			</a>`;
    } else if (pages[i] === 'x') {
      html += `<span class="page-numbers dots button disabled">...</span>`;
    } else {
      html += `<a class="page-numbers button" href="#" data-page="${pages[i]}">${pages[i]} </a>`;
    }
  }
  if (currentPage !== maxPage) {
    html += `<a class="next page-numbers button" href="#" data-page="${nextPage}">></a>`;
  }
  return html;
};
const search = _.debounce(function () {
  document.querySelector('#modal-search-items').classList.add('loading');
  const query = {
    c_search: term,
    // input search
    paged,
    not_ids: data.exclude
  };
  wp.apiFetch({
    path: (0,_wordpress_url__WEBPACK_IMPORTED_MODULE_1__.addQueryArgs)('/lp/v1/admin/tools/search-course', query),
    method: 'GET'
  }).then(res => {
    if (res.status && res.status === 'success') {
      const courses = res.data.courses;
      hasItems = _.size(courses);
      const modal_search_items = document.querySelector('#modal-search-items');
      if (hasItems) {
        const searchNav = modal_search_items.querySelector('.search-nav');
        searchNav.style.display = 'flex';
        searchNav.style.gap = '4px';
      }
      modal_search_items.classList.remove('loading');
      modal_search_items.querySelector('.search-results').innerHTML = renderSearchResult(courses);
      const checkBoxNodes = modal_search_items.querySelectorAll('.search-results input[type="checkbox"]');
      [...checkBoxNodes].map(checkBoxNode => {
        const id = parseInt(checkBoxNode.value);
        if (_.indexOf(selectedItems, id) >= 0) {
          checkBoxNode.checked = true;
        }
      });
      _.debounce(function () {
        const searchNav = modal_search_items.querySelector('.search-nav');
        searchNav.innerHTML = renderPagination(paged, res.data.total_pages);
      }, 10)();
    }
  }).catch(err => {
    console.log(err);
  }).finally(() => {});
}, 500);
const doSearch = () => {
  document.addEventListener('input', function (event) {
    const target = event.target;
    if (target.name !== 'search') {
      return;
    }
    const modalSearchItems = target.closest('#modal-search-items');
    if (!modalSearchItems) {
      return;
    }
    term = target.value;
    paged = 1;
    search();
  });
};
const loadPage = () => {
  document.addEventListener('click', function (event) {
    const target = event.target;
    if (!target.classList.contains('page-numbers')) {
      return;
    }
    const modalSearchItems = target.closest('#modal-search-items');
    if (!modalSearchItems) {
      return;
    }
    event.preventDefault();
    const buttons = modalSearchItems.querySelectorAll('.search-nav a');
    buttons.forEach(button => {
      button.classList.add('disabled');
    });
    paged = target.getAttribute('data-page');
    search();
  });
};
const selectItems = () => {
  document.addEventListener('change', function (event) {
    const target = event.target;
    if (target.name !== 'selectedItems[]') {
      return;
    }
    const modalSearchItems = target.closest('#modal-search-items');
    if (!modalSearchItems) {
      return;
    }
    const id = parseInt(target.value);
    const pos = _.indexOf(selectedItems, id);
    if (target.checked) {
      if (pos === -1) {
        selectedItems.push(id);
      }
    } else if (pos >= 0) {
      selectedItems.splice(pos, 1);
    }
    const addBtn = document.querySelector('#modal-search-items button.button-primary');
    if (addBtn) {
      if (selectedItems.length) {
        addBtn.style.display = 'block';
      } else {
        addBtn.style.display = 'none';
      }
    }
  });
};
const addItems = () => {
  document.addEventListener('click', function (event) {
    const addBtn = event.target;
    if (!addBtn.classList.contains('add')) {
      return;
    }
    const modalSearchItems = addBtn.closest('#modal-search-items');
    if (!modalSearchItems) {
      return;
    }
    addBtn.disabled = true;
    const query = {
      order_id: data.contextId,
      items: selectedItems,
      'lp-ajax': 'add_items_to_order',
      nonce: lpGlobalSettings.nonce
    };
    const params = new URLSearchParams();
    for (const [key, value] of Object.entries(query)) {
      if (Array.isArray(value)) {
        value.forEach(item => params.append(`${key}[]`, item));
      } else {
        params.append(key, value);
      }
    }
    fetch(window.location.href, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: params
    }).then(response => {
      if (!response.ok) {
        throw new Error('Error');
      }
      return response.text();
    }).then(response => {
      const jsonString = response.replace(/<-- LP_AJAX_START -->|<-- LP_AJAX_END -->/g, '').trim();
      try {
        const result = LP.parseJSON(jsonString);
        const noItem = listItems.querySelector('.no-order-items');
        noItem.style.display = 'none';
        const itemHtml = result.item_html;
        noItem.insertAdjacentHTML('beforebegin', itemHtml);
        lpOrderNode.querySelector('.order-subtotal').innerHTML = result.order_data.subtotal_html;
        lpOrderNode.querySelector('.order-total').innerHTML = result.order_data.total_html;
        removeModal();
      } catch (error) {
        console.error('Error parsing JSON:', error);
      }
    }).catch(error => {
      console.error('Error:', error);
    });
  });
};
const closeModal = () => {
  document.addEventListener('click', function (event) {
    const closeBtn = event.target;
    if (!closeBtn.classList.contains('close')) {
      return;
    }
    const modalSearchItems = closeBtn.closest('#modal-search-items');
    if (!modalSearchItems) {
      return;
    }
    removeModal();
  });
};
const removeModal = () => {
  const modal = document.querySelector('#modal-search-items');
  if (modal) {
    selectedItems = [];
    modal.remove();
  }
};
const displayModal = () => {
  if (displayModalBtn) {
    displayModalBtn.addEventListener('click', function (event) {
      data = {
        postType: 'lp_course',
        context: 'order-items',
        exclude: getAddedItems(),
        show: true
      };
      const postIdNode = document.querySelector('#post_ID');
      if (postIdNode) {
        data.contextId = postIdNode.value; //order id
      }
      term = '';
      paged = 1;
      mountSearchModal();
      focusSearch();
      search();
    });
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (modalSearchCourses);

/***/ }),

/***/ "./assets/src/js/utils.js":
/*!********************************!*\
  !*** ./assets/src/js/utils.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   listenElementCreated: () => (/* binding */ listenElementCreated),
/* harmony export */   listenElementViewed: () => (/* binding */ listenElementViewed),
/* harmony export */   lpAddQueryArgs: () => (/* binding */ lpAddQueryArgs),
/* harmony export */   lpAjaxParseJsonOld: () => (/* binding */ lpAjaxParseJsonOld),
/* harmony export */   lpFetchAPI: () => (/* binding */ lpFetchAPI),
/* harmony export */   lpGetCurrentURLNoParam: () => (/* binding */ lpGetCurrentURLNoParam)
/* harmony export */ });
/**
 * Fetch API.
 *
 * @param url
 * @param data
 * @param functions
 * @since 4.2.5.1
 * @version 1.0.1
 */
const lpFetchAPI = (url, data = {}, functions = {}) => {
  if ('function' === typeof functions.before) {
    functions.before();
  }
  fetch(url, {
    method: 'GET',
    ...data
  }).then(response => response.json()).then(response => {
    if ('function' === typeof functions.success) {
      functions.success(response);
    }
  }).catch(err => {
    if ('function' === typeof functions.error) {
      functions.error(err);
    }
  }).finally(() => {
    if ('function' === typeof functions.completed) {
      functions.completed();
    }
  });
};

/**
 * Get current URL without params.
 *
 * @since 4.2.5.1
 */
const lpGetCurrentURLNoParam = () => {
  let currentUrl = window.location.href;
  const hasParams = currentUrl.includes('?');
  if (hasParams) {
    currentUrl = currentUrl.split('?')[0];
  }
  return currentUrl;
};
const lpAddQueryArgs = (endpoint, args) => {
  const url = new URL(endpoint);
  Object.keys(args).forEach(arg => {
    url.searchParams.set(arg, args[arg]);
  });
  return url;
};

/**
 * Listen element viewed.
 *
 * @param el
 * @param callback
 * @since 4.2.5.8
 */
const listenElementViewed = (el, callback) => {
  const observerSeeItem = new IntersectionObserver(function (entries) {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        callback(entry);
      }
    }
  });
  observerSeeItem.observe(el);
};

/**
 * Listen element created.
 *
 * @param callback
 * @since 4.2.5.8
 */
const listenElementCreated = callback => {
  const observerCreateItem = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      if (mutation.addedNodes) {
        mutation.addedNodes.forEach(function (node) {
          if (node.nodeType === 1) {
            callback(node);
          }
        });
      }
    });
  });
  observerCreateItem.observe(document, {
    childList: true,
    subtree: true
  });
  // End.
};

// Parse JSON from string with content include LP_AJAX_START.
const lpAjaxParseJsonOld = data => {
  if (typeof data !== 'string') {
    return data;
  }
  const m = String.raw({
    raw: data
  }).match(/<-- LP_AJAX_START -->(.*)<-- LP_AJAX_END -->/s);
  try {
    if (m) {
      data = JSON.parse(m[1].replace(/(?:\r\n|\r|\n)/g, ''));
    } else {
      data = JSON.parse(data);
    }
  } catch (e) {
    data = {};
  }
  return data;
};


/***/ }),

/***/ "@wordpress/url":
/*!*****************************!*\
  !*** external ["wp","url"] ***!
  \*****************************/
/***/ ((module) => {

module.exports = window["wp"]["url"];

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
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
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
/************************************************************************/
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./assets/src/js/admin/admin-order.js ***!
  \********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _order_export_invoice__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./order/export_invoice */ "./assets/src/js/admin/order/export_invoice.js");
/* harmony import */ var _order_modal_search_courses__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./order/modal-search-courses */ "./assets/src/js/admin/order/modal-search-courses.js");


document.addEventListener('DOMContentLoaded', event => {
  (0,_order_modal_search_courses__WEBPACK_IMPORTED_MODULE_1__["default"])();
  (0,_order_export_invoice__WEBPACK_IMPORTED_MODULE_0__["default"])();
});
/******/ })()
;
//# sourceMappingURL=admin-order.js.map