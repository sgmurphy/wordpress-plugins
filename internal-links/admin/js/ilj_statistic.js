/******/ "use strict";
/******/ var __webpack_modules__ = ({

/***/ "./assets/admin/js/components/ilj_modal.js":
/*!*************************************************!*\
  !*** ./assets/admin/js/components/ilj_modal.js ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   iljCreateModal: () => (/* binding */ iljCreateModal)
/* harmony export */ });
function iljCreateModal(title, content) {
  var modal = jQuery('<div/>').addClass('ilj_modal show');
  var modal_wrapper = jQuery('<div/>').addClass('ilj_modal_wrap').append(modal);
  var header = jQuery('<div/>').addClass('ilj_modal_header').append(jQuery('<h2 />').text(title));
  var body = jQuery('<div/>').addClass('ilj_modal_body').html(content);
  var footer = jQuery('<div/>').addClass('ilj_modal_footer').append(jQuery('<button/>').text('OK').addClass('button button-primary').on('click', function (e) {
    closeModal(e);
  }));
  var closeModal = function () {
    modal.removeClass('show').addClass('hide');
    jQuery('body').css({
      overflowY: 'auto'
    });
    setTimeout(function () {
      modal_wrapper.remove();
    }, 200);
  }.bind(modal_wrapper);
  modal.append(header);
  modal.append(body);
  modal.append(footer);
  jQuery('body').append(modal_wrapper).css({
    overflowY: 'hidden'
  });
}

/***/ })

/******/ });
/************************************************************************/
/******/ // The module cache
/******/ var __webpack_module_cache__ = {};
/******/ 
/******/ // The require function
/******/ function __webpack_require__(moduleId) {
/******/ 	// Check if module is in cache
/******/ 	var cachedModule = __webpack_module_cache__[moduleId];
/******/ 	if (cachedModule !== undefined) {
/******/ 		return cachedModule.exports;
/******/ 	}
/******/ 	// Create a new module (and put it into the cache)
/******/ 	var module = __webpack_module_cache__[moduleId] = {
/******/ 		// no module.id needed
/******/ 		// no module.loaded needed
/******/ 		exports: {}
/******/ 	};
/******/ 
/******/ 	// Execute the module function
/******/ 	__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 
/******/ 	// Return the exports of the module
/******/ 	return module.exports;
/******/ }
/******/ 
/************************************************************************/
/******/ /* webpack/runtime/define property getters */
/******/ (() => {
/******/ 	// define getter functions for harmony exports
/******/ 	__webpack_require__.d = (exports, definition) => {
/******/ 		for(var key in definition) {
/******/ 			if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 				Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 			}
/******/ 		}
/******/ 	};
/******/ })();
/******/ 
/******/ /* webpack/runtime/hasOwnProperty shorthand */
/******/ (() => {
/******/ 	__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ })();
/******/ 
/******/ /* webpack/runtime/make namespace object */
/******/ (() => {
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = (exports) => {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/ })();
/******/ 
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***************************************!*\
  !*** ./src/admin/js/ilj_statistic.js ***!
  \***************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var components_ilj_modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! components/ilj_modal */ "./assets/admin/js/components/ilj_modal.js");

(function ($) {
  /**
   * $ plugin for the tabnav handling
   */
  $.fn.ilj_tabnav = function () {
    var container = this;
    $(this).find('.nav-tab-wrapper').on('click', 'a', function () {
      //toggling tab-nav:
      $(this).addClass('nav-tab-active');
      $(this).siblings('a').removeClass('nav-tab-active');
      //toggling tab-content:
      container.find('.tab-content').removeClass('active');
      container.find('.tab-content#' + $(this).data('target')).addClass('active');
    });
  };

  /**
   * Config for tipso
   */
  var tipsoConfig = {
    width: '',
    maxWidth: '200',
    useTitle: true,
    delay: 100,
    speed: 500,
    background: '#32373c',
    color: '#eeeeee',
    size: 'small'
  };

  // /**
  //  * Config for swal
  //  */
  // var swalHandle = Swal.mixin({
  //     buttonsStyling: false,
  //     customClass: {
  //         confirmButton: 'button button-primary'
  //     },
  //     width: '48rem'
  // });

  /**
   * Internationalization config for dataTables
   */
  var dataTables_language = {
    aria: {
      sortAscending: ilj_statistic_translation.datatables_aria_sortAscending,
      sortDescending: ilj_statistic_translation.datatables_aria_sortDescending
    },
    paginate: {
      first: ilj_statistic_translation.datatables_paginate_first,
      last: ilj_statistic_translation.datatables_paginate_last,
      next: ilj_statistic_translation.datatables_paginate_next,
      previous: ilj_statistic_translation.datatables_paginate_previous
    },
    emptyTable: ilj_statistic_translation.datatables_empty_table,
    info: ilj_statistic_translation.datatables_info,
    infoEmpty: ilj_statistic_translation.datatables_info_empty,
    infoFiltered: ilj_statistic_translation.datatables_info_filtered,
    lengthMenu: ilj_statistic_translation.datatables_length_menu,
    loadingRecords: ilj_statistic_translation.datatables_loading_records,
    processing: ilj_statistic_translation.datatables_processing,
    search: ilj_statistic_translation.datatables_search,
    zeroRecords: ilj_statistic_translation.datatables_zero_records
  };
  var link_statistics_table_data = '';
  var anchor_statistics_table_data = '';
  var chunk_size = 1000;
  /**
   * Initialize the warning tip if possible
   */
  $(document).ready(function () {
    var $warningTip = $('.warning-tip');
    if (!$warningTip.length) {
      return;
    }
    var tipsoWarningConfig = $.extend(Object.assign({}, tipsoConfig), {
      tooltipHover: true,
      useTitle: false,
      content: $('<div/>').html($warningTip.find('.the-tip').html()).css({
        'margin': '10px 20px',
        'display': 'block'
      }),
      maxWidth: '250px'
    });
    $warningTip.iljtipso(tipsoWarningConfig);
  });

  /**
   * Initializing the statistics
   */
  $(document).ready(function () {
    /**
     * Get all available types in the statistic table
     */
    var get_available_types = function ($table) {
      var types = {};
      $table.dataTable().api().rows().every(function (index) {
        var row = $table.dataTable().api().row(index);
        var data = row.data();
        var $inner = $(data[2].display);
        var type_main = $inner.attr('data-type');
        var type_sub = $inner.text();
        if (types[type_main] === undefined) {
          types[type_main] = [];
        }
        types[type_main].push(type_sub);
      });
      $.each(types, function (property, value) {
        types[property] = types[property].filter(function (x, i, a) {
          return a.indexOf(x) == i;
        });
      });
      return types;
    };

    /**
     * Returns the translated label for a parent type (post, term, custom)
     */
    var get_main_type_label = function (slug) {
      switch (slug) {
        case 'post':
          slug = ilj_statistic_translation.filter_section_posts_pages;
          break;
        case 'term':
          slug = ilj_statistic_translation.filter_section_taxonomies;
          break;
        case 'custom':
          slug = ilj_statistic_translation.filter_section_custom_links;
          break;
      }
      return slug;
    };

    /**
     * Get the complete type filter node
     * @returns {jQuery}
     */
    var get_type_filter = function ($table) {
      var available_types = get_available_types($table);
      var $wrapper = $('<div/>').addClass('ilj-type-filter-wrapper');
      var $container = $('<ul/>');
      var $dropdown_link = $('<a/>').addClass('ilj-type-filter-dropdown').text(ilj_statistic_translation.filter_type).on('click', function () {
        $wrapper.toggleClass('show');
      });
      $wrapper.append($dropdown_link, $container);
      $container.activeTypes = [];
      $container.activeTypes.remove = function (target) {
        var index = this.indexOf(target);
        if (index > -1) {
          this.splice(index, 1);
        }
      };
      $.each(available_types, function (index, element) {
        var label = get_main_type_label(index);
        var $elem = $('<li/>').html($('<span/>').text(label));
        var $sub_container = $('<ul/>');
        $container.append($elem);
        if (element.length) {
          $elem.append($sub_container);
        }
        $.each(element, function (subindex, subelement) {
          var $sub_elem_toggle = $('<input/>').attr({
            type: 'checkbox',
            checked: 'checked'
          }).on('change', function () {
            var type = index + ';' + subelement;
            if (true === $(this).prop('checked')) {
              $container.activeTypes.push(type);
            } else {
              $container.activeTypes.remove(type);
            }
            var type_column = $table.dataTable().api().column('th.type');
            var type_search = $container.activeTypes.length ? $container.activeTypes.join('|') : null;
            type_column.search(type_search, true, false).draw();
          });
          var $sub_elem_inner = $('<label/>').html($('<span/>').text(subelement).attr('data-type', index));
          var $sub_elem = $('<li/>').addClass('type').html($sub_elem_inner);
          $container.activeTypes.push(index + ';' + subelement);
          $sub_elem_inner.prepend($sub_elem_toggle);
          $sub_container.append($sub_elem);
        });
      });
      return $wrapper;
    };
    var $tabnav = $('.ilj-statistic').find('.nav-tab-wrapper');
    if ($tabnav.length) {
      $('.ilj-statistic').ilj_tabnav();
    }
    $('.tip').iljtipso(tipsoConfig);
    function create_link_statistics_table() {
      // Create a table element with class "ilj-statistic-table-links display"
      var table = document.createElement('table');
      table.className = 'ilj-statistic-table-links display';

      // Create the table header (thead) with table row (tr) and table headers (th)
      var thead = document.createElement('thead');
      var header_row = document.createElement('tr');

      // Loop through the localized header_titles and create table headers
      header_titles.forEach(titleText => {
        var th = document.createElement('th');
        if (titleText === 'Type') {
          th.className = 'type';
        }
        th.textContent = titleText;
        header_row.appendChild(th);
      });
      thead.appendChild(header_row);

      // Create the table body (tbody)
      var tbody = document.createElement('tbody');

      // Combine the elements to build the final structure
      table.appendChild(thead);
      table.appendChild(tbody);

      // Now you can use this "table" element as needed, for example, appending it to a parent element in the DOM
      var parentElement = document.getElementById('statistic-links'); // Replace with the actual parent element's ID
      // Check if the parent element exists before attempting to append the table
      if (parentElement) {
        parentElement.appendChild(table);
      }
    }
    function load_statistics_chunk(start_count) {
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        // WordPress AJAX URL
        data: {
          action: 'load_statistics_chunk',
          nonce: ilj_dashboard.nonce,
          start_count: start_count,
          chunk_size: chunk_size
        },
        success: function (response) {
          // Append the HTML chunk to your table
          if ('null' != response) {
            link_statistics_table_data += response;
          }

          // Update the start_count for the next chunk
          start_count += chunk_size;
          // If there's more data, load the next chunk
          if ('null' != response) {
            load_statistics_chunk(start_count);
          } else {
            render_link_statistics_table();
          }
        },
        error: function (error) {
          console.log('Error loading statistics: ', error);
        }
      });
    }
    function render_link_statistics_table() {
      create_link_statistics_table();
      var $table = jQuery('.ilj-statistic-table-links');
      jQuery('.ilj-statistic-table-links tbody').append(link_statistics_table_data);
      $tabnav.show();
      $('#statistic-links').html($table);

      /**
       * Render the statistics table
       */
      $table.DataTable({
        stateSave: false,
        columnDefs: [{
          orderable: false,
          targets: 5
        }, {
          responsivePriority: 1,
          targets: 0
        }, {
          responsivePriority: 2,
          targets: 3
        }, {
          responsivePriority: 3,
          targets: 4
        }, {
          responsivePriority: 4,
          targets: 5
        }],
        language: dataTables_language,
        stateLoaded: function (settings, data) {
          $table.find('.tip').iljtipso(tipsoConfig);
        },
        initComplete: function () {
          var type_filter = get_type_filter($table);
          $('#statistic-links .dataTables_wrapper .dataTables_filter').append(type_filter);
        },
        responsive: true
      });
      $table.find('.tip').iljtipso(tipsoConfig);

      /**
       * Open detailed statistics
       */
      $table.on('click', '.ilj-statistic-detail', function () {
        $('.ilj-statistic-cover').show();
        var id = $(this).data('id');
        var type = $(this).data('type');
        var direction = $(this).data('direction');
        var headline = '';
        var link_count = 0;
        var title = $(this).closest('tr').find('td.asset-title').text();
        if (direction == 'to') {
          headline = ilj_statistic_translation.incoming_links;
          link_count = $(this).closest('a[data-direction="to"]').text();
        } else if (direction == 'from') {
          headline = ilj_statistic_translation.outgoing_links;
          link_count = $(this).closest('a[data-direction="from"]').text();
        }
        var data = {
          'action': 'ilj_render_link_detail_statistic',
          'id': id,
          'type': type,
          'direction': direction
        };
        $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: data
        }).done(function (data) {
          (0,components_ilj_modal__WEBPACK_IMPORTED_MODULE_0__.iljCreateModal)(headline + ' "' + title + '" (' + link_count + ')', $('<div/>').addClass('ilj-statistic').html(data));
          $('.ilj-statistic-cover').hide();
        });
      });
    }
    function create_link_anchor_statistics_table() {
      // Create a table element
      var table = document.createElement('table');
      table.className = 'ilj-statistic-table-anchors display';

      // Create the table header (thead) element
      var thead = document.createElement('thead');
      var headerRow = document.createElement('tr');

      // Create table header cells and add text content from localized data
      if ('undefined' !== typeof headerLabels) {
        headerLabels.forEach(function (labelText) {
          var th = document.createElement('th');
          th.textContent = labelText;
          headerRow.appendChild(th);
        });
      }
      thead.appendChild(headerRow);

      // Create the table body (tbody) element
      var tbody = document.createElement('tbody');

      // Append the header and body to the table
      table.appendChild(thead);
      table.appendChild(tbody);

      // Append the table to a specific element in the DOM
      var targetElement = document.getElementById('statistic-anchors');
      // Check if the parent element exists before attempting to append the table
      if (targetElement) {
        targetElement.appendChild(table);
      }
    }
    function load_anchor_statistics_chunk(start_count) {
      jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        // WordPress AJAX URL
        data: {
          action: 'load_anchor_statistics_chunk',
          nonce: ilj_dashboard.nonce,
          start_count: start_count,
          chunk_size: chunk_size
        },
        success: function (response) {
          // Append the HTML chunk to your table
          if ('null' != response) {
            anchor_statistics_table_data += response;
          }

          // Update the start_count for the next chunk
          start_count += chunk_size;
          // If there's more data, load the next chunk
          if ('null' != response) {
            load_anchor_statistics_chunk(start_count);
          } else {
            render_link_anchor_statistics_table();
          }
        },
        error: function (error) {
          console.log('Error loading statistics: ', error);
        }
      });
    }
    function render_link_anchor_statistics_table() {
      create_link_anchor_statistics_table();
      var $table = jQuery('.ilj-statistic-table-anchors');
      jQuery('.ilj-statistic-table-anchors tbody').append(anchor_statistics_table_data);
      $('#statistic-anchors').html($table);

      /**
       * Render the anchor statistics table
       */
      $table.DataTable({
        stateSave: false,
        language: dataTables_language,
        stateLoaded: function (settings, data) {
          $table.find('.tip').iljtipso(tipsoConfig);
        },
        columnDefs: [{
          responsivePriority: 1,
          targets: 0
        }, {
          responsivePriority: 2,
          targets: 3
        }, {
          responsivePriority: 3,
          targets: 2
        }, {
          responsivePriority: 4,
          targets: 1
        }],
        responsive: true
      });
      /**
       * Open detailed statistics
       */
      $table.on('click', '.ilj-statistic-detail', function () {
        $('.ilj-statistic-cover').show();
        var anchor = $(this).data('anchor');
        var link_count = $(this).text();
        var data = {
          'action': 'ilj_render_anchor_detail_statistic',
          'anchor': anchor
        };
        $.ajax({
          url: ajaxurl,
          type: 'POST',
          data: data
        }).done(function (data) {
          (0,components_ilj_modal__WEBPACK_IMPORTED_MODULE_0__.iljCreateModal)(ilj_statistic_translation.anchor_text + ' "' + anchor + '" (' + link_count + ')', $('<div/>').addClass('ilj-statistic').html(data));
          $('.ilj-statistic-cover').hide();
        });
      });
    }

    // Initial call to load the first chunk of data for link statistics table
    load_statistics_chunk(0);
    // Initial call to load the first chunk of data for anchor statistics table
    load_anchor_statistics_chunk(0);
  });

  /**
   * Hide type filter if open
   */
  $(document).on('mouseup', function (e) {
    var $wrapper = $('.ilj-type-filter-wrapper');
    if (!$wrapper.is(e.target) && $wrapper.has(e.target).length === 0) {
      $wrapper.removeClass('show');
    }
  });
})(jQuery);
})();

