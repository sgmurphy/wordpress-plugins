(function webpackUniversalModuleDefinition(root, factory) {
  if (typeof exports === 'object' && typeof module === 'object') {
    const vue = require('../vue.min');
    module.exports = factory(vue);
  } else if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof exports === 'object') {
    const vue = require('../vue.min');
    exports['vue-phone-number-input'] = factory(vue);
  } else {
    root['vue-phone-number-input'] = factory(root['Vue']);
  }
})(
  typeof self !== 'undefined' ? self : this,
  function (__WEBPACK_EXTERNAL_MODULE__8bbf__) {
    return /******/ (function (modules) {
      // webpackBootstrap
      /******/ // The module cache
      /******/ var installedModules = {};
      /******/
      /******/ // The require function
      /******/ function __webpack_require__(moduleId) {
        /******/
        /******/ // Check if module is in cache
        /******/ if (installedModules[moduleId]) {
          /******/ return installedModules[moduleId].exports;
          /******/
        }
        /******/ // Create a new module (and put it into the cache)
        /******/ var module = (installedModules[moduleId] = {
          /******/ i: moduleId,
          /******/ l: false,
          /******/ exports: {},
          /******/
        });
        /******/
        /******/ // Execute the module function
        /******/ modules[moduleId].call(
          module.exports,
          module,
          module.exports,
          __webpack_require__
        );
        /******/
        /******/ // Flag the module as loaded
        /******/ module.l = true;
        /******/
        /******/ // Return the exports of the module
        /******/ return module.exports;
        /******/
      }
      /******/
      /******/
      /******/ // expose the modules object (__webpack_modules__)
      /******/ __webpack_require__.m = modules;
      /******/
      /******/ // expose the module cache
      /******/ __webpack_require__.c = installedModules;
      /******/
      /******/ // define getter function for harmony exports
      /******/ __webpack_require__.d = function (exports, name, getter) {
        /******/ if (!__webpack_require__.o(exports, name)) {
          /******/ Object.defineProperty(exports, name, {
            enumerable: true,
            get: getter,
          });
          /******/
        }
        /******/
      };
      /******/
      /******/ // define __esModule on exports
      /******/ __webpack_require__.r = function (exports) {
        /******/ if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
          /******/ Object.defineProperty(exports, Symbol.toStringTag, {
            value: 'Module',
          });
          /******/
        }
        /******/ Object.defineProperty(exports, '__esModule', { value: true });
        /******/
      };
      /******/
      /******/ // create a fake namespace object
      /******/ // mode & 1: value is a module id, require it
      /******/ // mode & 2: merge all properties of value into the ns
      /******/ // mode & 4: return value when already ns object
      /******/ // mode & 8|1: behave like require
      /******/ __webpack_require__.t = function (value, mode) {
        /******/ if (mode & 1) value = __webpack_require__(value);
        /******/ if (mode & 8) return value;
        /******/ if (
          mode & 4 &&
          typeof value === 'object' &&
          value &&
          value.__esModule
        )
          return value;
        /******/ var ns = Object.create(null);
        /******/ __webpack_require__.r(ns);
        /******/ Object.defineProperty(ns, 'default', {
          enumerable: true,
          value: value,
        });
        /******/ if (mode & 2 && typeof value != 'string')
          for (var key in value)
            __webpack_require__.d(
              ns,
              key,
              function (key) {
                return value[key];
              }.bind(null, key)
            );
        /******/ return ns;
        /******/
      };
      /******/
      /******/ // getDefaultExport function for compatibility with non-harmony modules
      /******/ __webpack_require__.n = function (module) {
        /******/ var getter =
          module && module.__esModule
            ? /******/ function getDefault() {
                return module['default'];
              }
            : /******/ function getModuleExports() {
                return module;
              };
        /******/ __webpack_require__.d(getter, 'a', getter);
        /******/ return getter;
        /******/
      };
      /******/
      /******/ // Object.prototype.hasOwnProperty.call
      /******/ __webpack_require__.o = function (object, property) {
        return Object.prototype.hasOwnProperty.call(object, property);
      };
      /******/
      /******/ // __webpack_public_path__
      /******/ __webpack_require__.p = '';
      /******/
      /******/
      /******/ // Load entry module and return exports
      /******/ return __webpack_require__((__webpack_require__.s = 'fb15'));
      /******/
    })(
      /************************************************************************/
      /******/ {
        /***/ '014b': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          // ECMAScript 6 symbols shim
          var global = __webpack_require__('e53d');
          var has = __webpack_require__('07e3');
          var DESCRIPTORS = __webpack_require__('8e60');
          var $export = __webpack_require__('63b6');
          var redefine = __webpack_require__('9138');
          var META = __webpack_require__('ebfd').KEY;
          var $fails = __webpack_require__('294c');
          var shared = __webpack_require__('dbdb');
          var setToStringTag = __webpack_require__('45f2');
          var uid = __webpack_require__('62a0');
          var wks = __webpack_require__('5168');
          var wksExt = __webpack_require__('ccb9');
          var wksDefine = __webpack_require__('6718');
          var enumKeys = __webpack_require__('47ee');
          var isArray = __webpack_require__('9003');
          var anObject = __webpack_require__('e4ae');
          var isObject = __webpack_require__('f772');
          var toObject = __webpack_require__('241e');
          var toIObject = __webpack_require__('36c3');
          var toPrimitive = __webpack_require__('1bc3');
          var createDesc = __webpack_require__('aebd');
          var _create = __webpack_require__('a159');
          var gOPNExt = __webpack_require__('0395');
          var $GOPD = __webpack_require__('bf0b');
          var $GOPS = __webpack_require__('9aa9');
          var $DP = __webpack_require__('d9f6');
          var $keys = __webpack_require__('c3a1');
          var gOPD = $GOPD.f;
          var dP = $DP.f;
          var gOPN = gOPNExt.f;
          var $Symbol = global.Symbol;
          var $JSON = global.JSON;
          var _stringify = $JSON && $JSON.stringify;
          var PROTOTYPE = 'prototype';
          var HIDDEN = wks('_hidden');
          var TO_PRIMITIVE = wks('toPrimitive');
          var isEnum = {}.propertyIsEnumerable;
          var SymbolRegistry = shared('symbol-registry');
          var AllSymbols = shared('symbols');
          var OPSymbols = shared('op-symbols');
          var ObjectProto = Object[PROTOTYPE];
          var USE_NATIVE = typeof $Symbol == 'function' && !!$GOPS.f;
          var QObject = global.QObject;
          // Don't use setters in Qt Script, https://github.com/zloirock/core-js/issues/173
          var setter =
            !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;

          // fallback for old Android, https://code.google.com/p/v8/issues/detail?id=687
          var setSymbolDesc =
            DESCRIPTORS &&
            $fails(function () {
              return (
                _create(
                  dP({}, 'a', {
                    get: function () {
                      return dP(this, 'a', { value: 7 }).a;
                    },
                  })
                ).a != 7
              );
            })
              ? function (it, key, D) {
                  var protoDesc = gOPD(ObjectProto, key);
                  if (protoDesc) delete ObjectProto[key];
                  dP(it, key, D);
                  if (protoDesc && it !== ObjectProto)
                    dP(ObjectProto, key, protoDesc);
                }
              : dP;

          var wrap = function (tag) {
            var sym = (AllSymbols[tag] = _create($Symbol[PROTOTYPE]));
            sym._k = tag;
            return sym;
          };

          var isSymbol =
            USE_NATIVE && typeof $Symbol.iterator == 'symbol'
              ? function (it) {
                  return typeof it == 'symbol';
                }
              : function (it) {
                  return it instanceof $Symbol;
                };

          var $defineProperty = function defineProperty(it, key, D) {
            if (it === ObjectProto) $defineProperty(OPSymbols, key, D);
            anObject(it);
            key = toPrimitive(key, true);
            anObject(D);
            if (has(AllSymbols, key)) {
              if (!D.enumerable) {
                if (!has(it, HIDDEN)) dP(it, HIDDEN, createDesc(1, {}));
                it[HIDDEN][key] = true;
              } else {
                if (has(it, HIDDEN) && it[HIDDEN][key]) it[HIDDEN][key] = false;
                D = _create(D, { enumerable: createDesc(0, false) });
              }
              return setSymbolDesc(it, key, D);
            }
            return dP(it, key, D);
          };
          var $defineProperties = function defineProperties(it, P) {
            anObject(it);
            var keys = enumKeys((P = toIObject(P)));
            var i = 0;
            var l = keys.length;
            var key;
            while (l > i) $defineProperty(it, (key = keys[i++]), P[key]);
            return it;
          };
          var $create = function create(it, P) {
            return P === undefined
              ? _create(it)
              : $defineProperties(_create(it), P);
          };
          var $propertyIsEnumerable = function propertyIsEnumerable(key) {
            var E = isEnum.call(this, (key = toPrimitive(key, true)));
            if (
              this === ObjectProto &&
              has(AllSymbols, key) &&
              !has(OPSymbols, key)
            )
              return false;
            return E ||
              !has(this, key) ||
              !has(AllSymbols, key) ||
              (has(this, HIDDEN) && this[HIDDEN][key])
              ? E
              : true;
          };
          var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(
            it,
            key
          ) {
            it = toIObject(it);
            key = toPrimitive(key, true);
            if (
              it === ObjectProto &&
              has(AllSymbols, key) &&
              !has(OPSymbols, key)
            )
              return;
            var D = gOPD(it, key);
            if (
              D &&
              has(AllSymbols, key) &&
              !(has(it, HIDDEN) && it[HIDDEN][key])
            )
              D.enumerable = true;
            return D;
          };
          var $getOwnPropertyNames = function getOwnPropertyNames(it) {
            var names = gOPN(toIObject(it));
            var result = [];
            var i = 0;
            var key;
            while (names.length > i) {
              if (
                !has(AllSymbols, (key = names[i++])) &&
                key != HIDDEN &&
                key != META
              )
                result.push(key);
            }
            return result;
          };
          var $getOwnPropertySymbols = function getOwnPropertySymbols(it) {
            var IS_OP = it === ObjectProto;
            var names = gOPN(IS_OP ? OPSymbols : toIObject(it));
            var result = [];
            var i = 0;
            var key;
            while (names.length > i) {
              if (
                has(AllSymbols, (key = names[i++])) &&
                (IS_OP ? has(ObjectProto, key) : true)
              )
                result.push(AllSymbols[key]);
            }
            return result;
          };

          // 19.4.1.1 Symbol([description])
          if (!USE_NATIVE) {
            $Symbol = function Symbol() {
              if (this instanceof $Symbol)
                throw TypeError('Symbol is not a constructor!');
              var tag = uid(arguments.length > 0 ? arguments[0] : undefined);
              var $set = function (value) {
                if (this === ObjectProto) $set.call(OPSymbols, value);
                if (has(this, HIDDEN) && has(this[HIDDEN], tag))
                  this[HIDDEN][tag] = false;
                setSymbolDesc(this, tag, createDesc(1, value));
              };
              if (DESCRIPTORS && setter)
                setSymbolDesc(ObjectProto, tag, {
                  configurable: true,
                  set: $set,
                });
              return wrap(tag);
            };
            redefine($Symbol[PROTOTYPE], 'toString', function toString() {
              return this._k;
            });

            $GOPD.f = $getOwnPropertyDescriptor;
            $DP.f = $defineProperty;
            __webpack_require__('6abf').f = gOPNExt.f = $getOwnPropertyNames;
            __webpack_require__('355d').f = $propertyIsEnumerable;
            $GOPS.f = $getOwnPropertySymbols;

            if (DESCRIPTORS && !__webpack_require__('b8e3')) {
              redefine(
                ObjectProto,
                'propertyIsEnumerable',
                $propertyIsEnumerable,
                true
              );
            }

            wksExt.f = function (name) {
              return wrap(wks(name));
            };
          }

          $export($export.G + $export.W + $export.F * !USE_NATIVE, {
            Symbol: $Symbol,
          });

          for (
            var es6Symbols =
                // 19.4.2.2, 19.4.2.3, 19.4.2.4, 19.4.2.6, 19.4.2.8, 19.4.2.9, 19.4.2.10, 19.4.2.11, 19.4.2.12, 19.4.2.13, 19.4.2.14
                'hasInstance,isConcatSpreadable,iterator,match,replace,search,species,split,toPrimitive,toStringTag,unscopables'.split(
                  ','
                ),
              j = 0;
            es6Symbols.length > j;

          )
            wks(es6Symbols[j++]);

          for (
            var wellKnownSymbols = $keys(wks.store), k = 0;
            wellKnownSymbols.length > k;

          )
            wksDefine(wellKnownSymbols[k++]);

          $export($export.S + $export.F * !USE_NATIVE, 'Symbol', {
            // 19.4.2.1 Symbol.for(key)
            for: function (key) {
              return has(SymbolRegistry, (key += ''))
                ? SymbolRegistry[key]
                : (SymbolRegistry[key] = $Symbol(key));
            },
            // 19.4.2.5 Symbol.keyFor(sym)
            keyFor: function keyFor(sym) {
              if (!isSymbol(sym)) throw TypeError(sym + ' is not a symbol!');
              for (var key in SymbolRegistry)
                if (SymbolRegistry[key] === sym) return key;
            },
            useSetter: function () {
              setter = true;
            },
            useSimple: function () {
              setter = false;
            },
          });

          $export($export.S + $export.F * !USE_NATIVE, 'Object', {
            // 19.1.2.2 Object.create(O [, Properties])
            create: $create,
            // 19.1.2.4 Object.defineProperty(O, P, Attributes)
            defineProperty: $defineProperty,
            // 19.1.2.3 Object.defineProperties(O, Properties)
            defineProperties: $defineProperties,
            // 19.1.2.6 Object.getOwnPropertyDescriptor(O, P)
            getOwnPropertyDescriptor: $getOwnPropertyDescriptor,
            // 19.1.2.7 Object.getOwnPropertyNames(O)
            getOwnPropertyNames: $getOwnPropertyNames,
            // 19.1.2.8 Object.getOwnPropertySymbols(O)
            getOwnPropertySymbols: $getOwnPropertySymbols,
          });

          // Chrome 38 and 39 `Object.getOwnPropertySymbols` fails on primitives
          // https://bugs.chromium.org/p/v8/issues/detail?id=3443
          var FAILS_ON_PRIMITIVES = $fails(function () {
            $GOPS.f(1);
          });

          $export($export.S + $export.F * FAILS_ON_PRIMITIVES, 'Object', {
            getOwnPropertySymbols: function getOwnPropertySymbols(it) {
              return $GOPS.f(toObject(it));
            },
          });

          // 24.3.2 JSON.stringify(value [, replacer [, space]])
          $JSON &&
            $export(
              $export.S +
                $export.F *
                  (!USE_NATIVE ||
                    $fails(function () {
                      var S = $Symbol();
                      // MS Edge converts symbol values to JSON as {}
                      // WebKit converts symbol values to JSON as null
                      // V8 throws on boxed symbols
                      return (
                        _stringify([S]) != '[null]' ||
                        _stringify({ a: S }) != '{}' ||
                        _stringify(Object(S)) != '{}'
                      );
                    })),
              'JSON',
              {
                stringify: function stringify(it) {
                  var args = [it];
                  var i = 1;
                  var replacer, $replacer;
                  while (arguments.length > i) args.push(arguments[i++]);
                  $replacer = replacer = args[1];
                  if ((!isObject(replacer) && it === undefined) || isSymbol(it))
                    return; // IE8 returns string on undefined
                  if (!isArray(replacer))
                    replacer = function (key, value) {
                      if (typeof $replacer == 'function')
                        value = $replacer.call(this, key, value);
                      if (!isSymbol(value)) return value;
                    };
                  args[1] = replacer;
                  return _stringify.apply($JSON, args);
                },
              }
            );

          // 19.4.3.4 Symbol.prototype[@@toPrimitive](hint)
          $Symbol[PROTOTYPE][TO_PRIMITIVE] ||
            __webpack_require__('35e8')(
              $Symbol[PROTOTYPE],
              TO_PRIMITIVE,
              $Symbol[PROTOTYPE].valueOf
            );
          // 19.4.3.5 Symbol.prototype[@@toStringTag]
          setToStringTag($Symbol, 'Symbol');
          // 20.2.1.9 Math[@@toStringTag]
          setToStringTag(Math, 'Math', true);
          // 24.3.3 JSON[@@toStringTag]
          setToStringTag(global.JSON, 'JSON', true);

          /***/
        },

        /***/ '01f9': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var LIBRARY = __webpack_require__('2d00');
          var $export = __webpack_require__('5ca1');
          var redefine = __webpack_require__('2aba');
          var hide = __webpack_require__('32e9');
          var Iterators = __webpack_require__('84f2');
          var $iterCreate = __webpack_require__('41a0');
          var setToStringTag = __webpack_require__('7f20');
          var getPrototypeOf = __webpack_require__('38fd');
          var ITERATOR = __webpack_require__('2b4c')('iterator');
          var BUGGY = !([].keys && 'next' in [].keys()); // Safari has buggy iterators w/o `next`
          var FF_ITERATOR = '@@iterator';
          var KEYS = 'keys';
          var VALUES = 'values';

          var returnThis = function () {
            return this;
          };

          module.exports = function (
            Base,
            NAME,
            Constructor,
            next,
            DEFAULT,
            IS_SET,
            FORCED
          ) {
            $iterCreate(Constructor, NAME, next);
            var getMethod = function (kind) {
              if (!BUGGY && kind in proto) return proto[kind];
              switch (kind) {
                case KEYS:
                  return function keys() {
                    return new Constructor(this, kind);
                  };
                case VALUES:
                  return function values() {
                    return new Constructor(this, kind);
                  };
              }
              return function entries() {
                return new Constructor(this, kind);
              };
            };
            var TAG = NAME + ' Iterator';
            var DEF_VALUES = DEFAULT == VALUES;
            var VALUES_BUG = false;
            var proto = Base.prototype;
            var $native =
              proto[ITERATOR] ||
              proto[FF_ITERATOR] ||
              (DEFAULT && proto[DEFAULT]);
            var $default = $native || getMethod(DEFAULT);
            var $entries = DEFAULT
              ? !DEF_VALUES
                ? $default
                : getMethod('entries')
              : undefined;
            var $anyNative =
              NAME == 'Array' ? proto.entries || $native : $native;
            var methods, key, IteratorPrototype;
            // Fix native
            if ($anyNative) {
              IteratorPrototype = getPrototypeOf($anyNative.call(new Base()));
              if (
                IteratorPrototype !== Object.prototype &&
                IteratorPrototype.next
              ) {
                // Set @@toStringTag to native iterators
                setToStringTag(IteratorPrototype, TAG, true);
                // fix for some old engines
                if (
                  !LIBRARY &&
                  typeof IteratorPrototype[ITERATOR] != 'function'
                )
                  hide(IteratorPrototype, ITERATOR, returnThis);
              }
            }
            // fix Array#{values, @@iterator}.name in V8 / FF
            if (DEF_VALUES && $native && $native.name !== VALUES) {
              VALUES_BUG = true;
              $default = function values() {
                return $native.call(this);
              };
            }
            // Define iterator
            if (
              (!LIBRARY || FORCED) &&
              (BUGGY || VALUES_BUG || !proto[ITERATOR])
            ) {
              hide(proto, ITERATOR, $default);
            }
            // Plug for library
            Iterators[NAME] = $default;
            Iterators[TAG] = returnThis;
            if (DEFAULT) {
              methods = {
                values: DEF_VALUES ? $default : getMethod(VALUES),
                keys: IS_SET ? $default : getMethod(KEYS),
                entries: $entries,
              };
              if (FORCED)
                for (key in methods) {
                  if (!(key in proto)) redefine(proto, key, methods[key]);
                }
              else
                $export(
                  $export.P + $export.F * (BUGGY || VALUES_BUG),
                  NAME,
                  methods
                );
            }
            return methods;
          };

          /***/
        },

        /***/ '0395': /***/ function (module, exports, __webpack_require__) {
          // fallback for IE11 buggy Object.getOwnPropertyNames with iframe and window
          var toIObject = __webpack_require__('36c3');
          var gOPN = __webpack_require__('6abf').f;
          var toString = {}.toString;

          var windowNames =
            typeof window == 'object' && window && Object.getOwnPropertyNames
              ? Object.getOwnPropertyNames(window)
              : [];

          var getWindowNames = function (it) {
            try {
              return gOPN(it);
            } catch (e) {
              return windowNames.slice();
            }
          };

          module.exports.f = function getOwnPropertyNames(it) {
            return windowNames && toString.call(it) == '[object Window]'
              ? getWindowNames(it)
              : gOPN(toIObject(it));
          };

          /***/
        },

        /***/ '0750': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          Object.defineProperty(exports, '__esModule', { value: true });
          exports.default = {
            aliceblue: '#f0f8ff',
            antiquewhite: '#faebd7',
            aqua: '#00ffff',
            aquamarine: '#7fffd4',
            azure: '#f0ffff',
            beige: '#f5f5dc',
            bisque: '#ffe4c4',
            black: '#000000',
            blanchedalmond: '#ffebcd',
            blue: '#0000ff',
            blueviolet: '#8a2be2',
            brown: '#a52a2a',
            burlywood: '#deb887',
            cadetblue: '#5f9ea0',
            chartreuse: '#7fff00',
            chocolate: '#d2691e',
            coral: '#ff7f50',
            cornflowerblue: '#6495ed',
            cornsilk: '#fff8dc',
            crimson: '#dc143c',
            cyan: '#00ffff',
            darkblue: '#00008b',
            darkcyan: '#008b8b',
            darkgoldenrod: '#b8860b',
            darkgray: '#a9a9a9',
            darkgreen: '#006400',
            darkkhaki: '#bdb76b',
            darkmagenta: '#8b008b',
            darkolivegreen: '#556b2f',
            darkorange: '#ff8c00',
            darkorchid: '#9932cc',
            darkred: '#8b0000',
            darksalmon: '#e9967a',
            darkseagreen: '#8fbc8f',
            darkslateblue: '#483d8b',
            darkslategray: '#2f4f4f',
            darkturquoise: '#00ced1',
            darkviolet: '#9400d3',
            deeppink: '#ff1493',
            deepskyblue: '#00bfff',
            dimgray: '#696969',
            dodgerblue: '#1e90ff',
            firebrick: '#b22222',
            floralwhite: '#fffaf0',
            forestgreen: '#228b22',
            fuchsia: '#ff00ff',
            gainsboro: '#dcdcdc',
            ghostwhite: '#f8f8ff',
            gold: '#ffd700',
            goldenrod: '#daa520',
            gray: '#808080',
            green: '#008000',
            greenyellow: '#adff2f',
            honeydew: '#f0fff0',
            hotpink: '#ff69b4',
            indianred: '#cd5c5c',
            indigo: '#4b0082',
            ivory: '#fffff0',
            khaki: '#f0e68c',
            lavender: '#e6e6fa',
            lavenderblush: '#fff0f5',
            lawngreen: '#7cfc00',
            lemonchiffon: '#fffacd',
            lightblue: '#add8e6',
            lightcoral: '#f08080',
            lightcyan: '#e0ffff',
            lightgoldenrodyellow: '#fafad2',
            lightgrey: '#d3d3d3',
            lightgreen: '#90ee90',
            lightpink: '#ffb6c1',
            lightsalmon: '#ffa07a',
            lightseagreen: '#20b2aa',
            lightskyblue: '#87cefa',
            lightslategray: '#778899',
            lightsteelblue: '#b0c4de',
            lightyellow: '#ffffe0',
            lime: '#00ff00',
            limegreen: '#32cd32',
            linen: '#faf0e6',
            magenta: '#ff00ff',
            maroon: '#800000',
            mediumaquamarine: '#66cdaa',
            mediumblue: '#0000cd',
            mediumorchid: '#ba55d3',
            mediumpurple: '#9370d8',
            mediumseagreen: '#3cb371',
            mediumslateblue: '#7b68ee',
            mediumspringgreen: '#00fa9a',
            mediumturquoise: '#48d1cc',
            mediumvioletred: '#c71585',
            midnightblue: '#191970',
            mintcream: '#f5fffa',
            mistyrose: '#ffe4e1',
            moccasin: '#ffe4b5',
            navajowhite: '#ffdead',
            navy: '#000080',
            oldlace: '#fdf5e6',
            olive: '#808000',
            olivedrab: '#6b8e23',
            orange: '#ffa500',
            orangered: '#ff4500',
            orchid: '#da70d6',
            palegoldenrod: '#eee8aa',
            palegreen: '#98fb98',
            paleturquoise: '#afeeee',
            palevioletred: '#d87093',
            papayawhip: '#ffefd5',
            peachpuff: '#ffdab9',
            peru: '#cd853f',
            pink: '#ffc0cb',
            plum: '#dda0dd',
            powderblue: '#b0e0e6',
            purple: '#800080',
            rebeccapurple: '#663399',
            red: '#ff0000',
            rosybrown: '#bc8f8f',
            royalblue: '#4169e1',
            saddlebrown: '#8b4513',
            salmon: '#fa8072',
            sandybrown: '#f4a460',
            seagreen: '#2e8b57',
            seashell: '#fff5ee',
            sienna: '#a0522d',
            silver: '#c0c0c0',
            skyblue: '#87ceeb',
            slateblue: '#6a5acd',
            slategray: '#708090',
            snow: '#fffafa',
            springgreen: '#00ff7f',
            steelblue: '#4682b4',
            tan: '#d2b48c',
            teal: '#008080',
            thistle: '#d8bfd8',
            tomato: '#ff6347',
            turquoise: '#40e0d0',
            violet: '#ee82ee',
            wheat: '#f5deb3',
            white: '#ffffff',
            whitesmoke: '#f5f5f5',
            yellow: '#ffff00',
            yellowgreen: '#9acd32',
            transparent: 'transparent',
          };
          //# sourceMappingURL=index.js.map

          /***/
        },

        /***/ '07e3': /***/ function (module, exports) {
          var hasOwnProperty = {}.hasOwnProperty;
          module.exports = function (it, key) {
            return hasOwnProperty.call(it, key);
          };

          /***/
        },

        /***/ '0a49': /***/ function (module, exports, __webpack_require__) {
          // 0 -> Array#forEach
          // 1 -> Array#map
          // 2 -> Array#filter
          // 3 -> Array#some
          // 4 -> Array#every
          // 5 -> Array#find
          // 6 -> Array#findIndex
          var ctx = __webpack_require__('9b43');
          var IObject = __webpack_require__('626a');
          var toObject = __webpack_require__('4bf8');
          var toLength = __webpack_require__('9def');
          var asc = __webpack_require__('cd1c');
          module.exports = function (TYPE, $create) {
            var IS_MAP = TYPE == 1;
            var IS_FILTER = TYPE == 2;
            var IS_SOME = TYPE == 3;
            var IS_EVERY = TYPE == 4;
            var IS_FIND_INDEX = TYPE == 6;
            var NO_HOLES = TYPE == 5 || IS_FIND_INDEX;
            var create = $create || asc;
            return function ($this, callbackfn, that) {
              var O = toObject($this);
              var self = IObject(O);
              var f = ctx(callbackfn, that, 3);
              var length = toLength(self.length);
              var index = 0;
              var result = IS_MAP
                ? create($this, length)
                : IS_FILTER
                  ? create($this, 0)
                  : undefined;
              var val, res;
              for (; length > index; index++)
                if (NO_HOLES || index in self) {
                  val = self[index];
                  res = f(val, index, O);
                  if (TYPE) {
                    if (IS_MAP)
                      result[index] = res; // map
                    else if (res)
                      switch (TYPE) {
                        case 3:
                          return true; // some
                        case 5:
                          return val; // find
                        case 6:
                          return index; // findIndex
                        case 2:
                          result.push(val); // filter
                      }
                    else if (IS_EVERY) return false; // every
                  }
                }
              return IS_FIND_INDEX
                ? -1
                : IS_SOME || IS_EVERY
                  ? IS_EVERY
                  : result;
            };
          };

          /***/
        },

        /***/ '0bfb': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          // 21.2.5.3 get RegExp.prototype.flags
          var anObject = __webpack_require__('cb7c');
          module.exports = function () {
            var that = anObject(this);
            var result = '';
            if (that.global) result += 'g';
            if (that.ignoreCase) result += 'i';
            if (that.multiline) result += 'm';
            if (that.unicode) result += 'u';
            if (that.sticky) result += 'y';
            return result;
          };

          /***/
        },

        /***/ '0d58': /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.14 / 15.2.3.14 Object.keys(O)
          var $keys = __webpack_require__('ce10');
          var enumBugKeys = __webpack_require__('e11e');

          module.exports =
            Object.keys ||
            function keys(O) {
              return $keys(O, enumBugKeys);
            };

          /***/
        },

        /***/ '0fc9': /***/ function (module, exports, __webpack_require__) {
          var toInteger = __webpack_require__('3a38');
          var max = Math.max;
          var min = Math.min;
          module.exports = function (index, length) {
            index = toInteger(index);
            return index < 0 ? max(index + length, 0) : min(index, length);
          };

          /***/
        },

        /***/ 1169: /***/ function (module, exports, __webpack_require__) {
          // 7.2.2 IsArray(argument)
          var cof = __webpack_require__('2d95');
          module.exports =
            Array.isArray ||
            function isArray(arg) {
              return cof(arg) == 'Array';
            };

          /***/
        },

        /***/ 1173: /***/ function (module, exports) {
          module.exports = function (it, Constructor, name, forbiddenField) {
            if (
              !(it instanceof Constructor) ||
              (forbiddenField !== undefined && forbiddenField in it)
            ) {
              throw TypeError(name + ': incorrect invocation!');
            }
            return it;
          };

          /***/
        },

        /***/ '11e9': /***/ function (module, exports, __webpack_require__) {
          var pIE = __webpack_require__('52a7');
          var createDesc = __webpack_require__('4630');
          var toIObject = __webpack_require__('6821');
          var toPrimitive = __webpack_require__('6a99');
          var has = __webpack_require__('69a8');
          var IE8_DOM_DEFINE = __webpack_require__('c69a');
          var gOPD = Object.getOwnPropertyDescriptor;

          exports.f = __webpack_require__('9e1e')
            ? gOPD
            : function getOwnPropertyDescriptor(O, P) {
                O = toIObject(O);
                P = toPrimitive(P, true);
                if (IE8_DOM_DEFINE)
                  try {
                    return gOPD(O, P);
                  } catch (e) {
                    /* empty */
                  }
                if (has(O, P)) return createDesc(!pIE.f.call(O, P), O[P]);
              };

          /***/
        },

        /***/ 1495: /***/ function (module, exports, __webpack_require__) {
          var dP = __webpack_require__('86cc');
          var anObject = __webpack_require__('cb7c');
          var getKeys = __webpack_require__('0d58');

          module.exports = __webpack_require__('9e1e')
            ? Object.defineProperties
            : function defineProperties(O, Properties) {
                anObject(O);
                var keys = getKeys(Properties);
                var length = keys.length;
                var i = 0;
                var P;
                while (length > i) dP.f(O, (P = keys[i++]), Properties[P]);
                return O;
              };

          /***/
        },

        /***/ 1654: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var $at = __webpack_require__('71c1')(true);

          // 21.1.3.27 String.prototype[@@iterator]()
          __webpack_require__('30f1')(
            String,
            'String',
            function (iterated) {
              this._t = String(iterated); // target
              this._i = 0; // next index
              // 21.1.5.2.1 %StringIteratorPrototype%.next()
            },
            function () {
              var O = this._t;
              var index = this._i;
              var point;
              if (index >= O.length) return { value: undefined, done: true };
              point = $at(O, index);
              this._i += point.length;
              return { value: point, done: false };
            }
          );

          /***/
        },

        /***/ 1691: /***/ function (module, exports) {
          // IE 8- don't enum bug keys
          module.exports =
            'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'.split(
              ','
            );

          /***/
        },

        /***/ '1af6': /***/ function (module, exports, __webpack_require__) {
          // 22.1.2.2 / 15.4.3.2 Array.isArray(arg)
          var $export = __webpack_require__('63b6');

          $export($export.S, 'Array', { isArray: __webpack_require__('9003') });

          /***/
        },

        /***/ '1bc3': /***/ function (module, exports, __webpack_require__) {
          // 7.1.1 ToPrimitive(input [, PreferredType])
          var isObject = __webpack_require__('f772');
          // instead of the ES6 spec version, we didn't implement @@toPrimitive case
          // and the second argument - flag - preferred type is a string
          module.exports = function (it, S) {
            if (!isObject(it)) return it;
            var fn, val;
            if (
              S &&
              typeof (fn = it.toString) == 'function' &&
              !isObject((val = fn.call(it)))
            )
              return val;
            if (
              typeof (fn = it.valueOf) == 'function' &&
              !isObject((val = fn.call(it)))
            )
              return val;
            if (
              !S &&
              typeof (fn = it.toString) == 'function' &&
              !isObject((val = fn.call(it)))
            )
              return val;
            throw TypeError("Can't convert object to primitive value");
          };

          /***/
        },

        /***/ '1c15': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          Object.defineProperty(exports, '__esModule', { value: true });
          exports.default = (hex, coef = 1) => {
            if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
              let c = hex.substring(1).split('');
              if (c.length === 3) c = [c[0], c[0], c[1], c[1], c[2], c[2]];
              const color = `0x${c.join('')}`; // eslint-disable-line
              return `rgba(${[
                (color >> 16) & 255,
                (color >> 8) & 255,
                color & 255,
              ].join(', ')}, ${coef})`;
            }
            throw new Error('Bad Hex');
          };
          //# sourceMappingURL=index.js.map

          /***/
        },

        /***/ '1ec9': /***/ function (module, exports, __webpack_require__) {
          var isObject = __webpack_require__('f772');
          var document = __webpack_require__('e53d').document;
          // typeof document.createElement is 'object' in old IE
          var is = isObject(document) && isObject(document.createElement);
          module.exports = function (it) {
            return is ? document.createElement(it) : {};
          };

          /***/
        },

        /***/ '20d6': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          // 22.1.3.9 Array.prototype.findIndex(predicate, thisArg = undefined)
          var $export = __webpack_require__('5ca1');
          var $find = __webpack_require__('0a49')(6);
          var KEY = 'findIndex';
          var forced = true;
          // Shouldn't skip holes
          if (KEY in [])
            Array(1)[KEY](function () {
              forced = false;
            });
          $export($export.P + $export.F * forced, 'Array', {
            findIndex: function findIndex(callbackfn /* , that = undefined */) {
              return $find(
                this,
                callbackfn,
                arguments.length > 1 ? arguments[1] : undefined
              );
            },
          });
          __webpack_require__('9c6c')(KEY);

          /***/
        },

        /***/ '20fd': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var $defineProperty = __webpack_require__('d9f6');
          var createDesc = __webpack_require__('aebd');

          module.exports = function (object, index, value) {
            if (index in object)
              $defineProperty.f(object, index, createDesc(0, value));
            else object[index] = value;
          };

          /***/
        },

        /***/ '230e': /***/ function (module, exports, __webpack_require__) {
          var isObject = __webpack_require__('d3f4');
          var document = __webpack_require__('7726').document;
          // typeof document.createElement is 'object' in old IE
          var is = isObject(document) && isObject(document.createElement);
          module.exports = function (it) {
            return is ? document.createElement(it) : {};
          };

          /***/
        },

        /***/ '241e': /***/ function (module, exports, __webpack_require__) {
          // 7.1.13 ToObject(argument)
          var defined = __webpack_require__('25eb');
          module.exports = function (it) {
            return Object(defined(it));
          };

          /***/
        },

        /***/ '24c5': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var LIBRARY = __webpack_require__('b8e3');
          var global = __webpack_require__('e53d');
          var ctx = __webpack_require__('d864');
          var classof = __webpack_require__('40c3');
          var $export = __webpack_require__('63b6');
          var isObject = __webpack_require__('f772');
          var aFunction = __webpack_require__('79aa');
          var anInstance = __webpack_require__('1173');
          var forOf = __webpack_require__('a22a');
          var speciesConstructor = __webpack_require__('f201');
          var task = __webpack_require__('4178').set;
          var microtask = __webpack_require__('aba2')();
          var newPromiseCapabilityModule = __webpack_require__('656e');
          var perform = __webpack_require__('4439');
          var userAgent = __webpack_require__('bc13');
          var promiseResolve = __webpack_require__('cd78');
          var PROMISE = 'Promise';
          var TypeError = global.TypeError;
          var process = global.process;
          var versions = process && process.versions;
          var v8 = (versions && versions.v8) || '';
          var $Promise = global[PROMISE];
          var isNode = classof(process) == 'process';
          var empty = function () {
            /* empty */
          };
          var Internal,
            newGenericPromiseCapability,
            OwnPromiseCapability,
            Wrapper;
          var newPromiseCapability = (newGenericPromiseCapability =
            newPromiseCapabilityModule.f);

          var USE_NATIVE = !!(function () {
            try {
              // correct subclassing with @@species support
              var promise = $Promise.resolve(1);
              var FakePromise = ((promise.constructor = {})[
                __webpack_require__('5168')('species')
              ] = function (exec) {
                exec(empty, empty);
              });
              // unhandled rejections tracking support, NodeJS Promise without it fails @@species test
              return (
                (isNode || typeof PromiseRejectionEvent == 'function') &&
                promise.then(empty) instanceof FakePromise &&
                // v8 6.6 (Node 10 and Chrome 66) have a bug with resolving custom thenables
                // https://bugs.chromium.org/p/chromium/issues/detail?id=830565
                // we can't detect it synchronously, so just check versions
                v8.indexOf('6.6') !== 0 &&
                userAgent.indexOf('Chrome/66') === -1
              );
            } catch (e) {
              /* empty */
            }
          })();

          // helpers
          var isThenable = function (it) {
            var then;
            return isObject(it) && typeof (then = it.then) == 'function'
              ? then
              : false;
          };
          var notify = function (promise, isReject) {
            if (promise._n) return;
            promise._n = true;
            var chain = promise._c;
            microtask(function () {
              var value = promise._v;
              var ok = promise._s == 1;
              var i = 0;
              var run = function (reaction) {
                var handler = ok ? reaction.ok : reaction.fail;
                var resolve = reaction.resolve;
                var reject = reaction.reject;
                var domain = reaction.domain;
                var result, then, exited;
                try {
                  if (handler) {
                    if (!ok) {
                      if (promise._h == 2) onHandleUnhandled(promise);
                      promise._h = 1;
                    }
                    if (handler === true) result = value;
                    else {
                      if (domain) domain.enter();
                      result = handler(value); // may throw
                      if (domain) {
                        domain.exit();
                        exited = true;
                      }
                    }
                    if (result === reaction.promise) {
                      reject(TypeError('Promise-chain cycle'));
                    } else if ((then = isThenable(result))) {
                      then.call(result, resolve, reject);
                    } else resolve(result);
                  } else reject(value);
                } catch (e) {
                  if (domain && !exited) domain.exit();
                  reject(e);
                }
              };
              while (chain.length > i) run(chain[i++]); // variable length - can't use forEach
              promise._c = [];
              promise._n = false;
              if (isReject && !promise._h) onUnhandled(promise);
            });
          };
          var onUnhandled = function (promise) {
            task.call(global, function () {
              var value = promise._v;
              var unhandled = isUnhandled(promise);
              var result, handler, console;
              if (unhandled) {
                result = perform(function () {
                  if (isNode) {
                    process.emit('unhandledRejection', value, promise);
                  } else if ((handler = global.onunhandledrejection)) {
                    handler({ promise: promise, reason: value });
                  } else if ((console = global.console) && console.error) {
                    console.error('Unhandled promise rejection', value);
                  }
                });
                // Browsers should not trigger `rejectionHandled` event if it was handled here, NodeJS - should
                promise._h = isNode || isUnhandled(promise) ? 2 : 1;
              }
              promise._a = undefined;
              if (unhandled && result.e) throw result.v;
            });
          };
          var isUnhandled = function (promise) {
            return promise._h !== 1 && (promise._a || promise._c).length === 0;
          };
          var onHandleUnhandled = function (promise) {
            task.call(global, function () {
              var handler;
              if (isNode) {
                process.emit('rejectionHandled', promise);
              } else if ((handler = global.onrejectionhandled)) {
                handler({ promise: promise, reason: promise._v });
              }
            });
          };
          var $reject = function (value) {
            var promise = this;
            if (promise._d) return;
            promise._d = true;
            promise = promise._w || promise; // unwrap
            promise._v = value;
            promise._s = 2;
            if (!promise._a) promise._a = promise._c.slice();
            notify(promise, true);
          };
          var $resolve = function (value) {
            var promise = this;
            var then;
            if (promise._d) return;
            promise._d = true;
            promise = promise._w || promise; // unwrap
            try {
              if (promise === value)
                throw TypeError("Promise can't be resolved itself");
              if ((then = isThenable(value))) {
                microtask(function () {
                  var wrapper = { _w: promise, _d: false }; // wrap
                  try {
                    then.call(
                      value,
                      ctx($resolve, wrapper, 1),
                      ctx($reject, wrapper, 1)
                    );
                  } catch (e) {
                    $reject.call(wrapper, e);
                  }
                });
              } else {
                promise._v = value;
                promise._s = 1;
                notify(promise, false);
              }
            } catch (e) {
              $reject.call({ _w: promise, _d: false }, e); // wrap
            }
          };

          // constructor polyfill
          if (!USE_NATIVE) {
            // 25.4.3.1 Promise(executor)
            $Promise = function Promise(executor) {
              anInstance(this, $Promise, PROMISE, '_h');
              aFunction(executor);
              Internal.call(this);
              try {
                executor(ctx($resolve, this, 1), ctx($reject, this, 1));
              } catch (err) {
                $reject.call(this, err);
              }
            };
            // eslint-disable-next-line no-unused-vars
            Internal = function Promise(executor) {
              this._c = []; // <- awaiting reactions
              this._a = undefined; // <- checked in isUnhandled reactions
              this._s = 0; // <- state
              this._d = false; // <- done
              this._v = undefined; // <- value
              this._h = 0; // <- rejection state, 0 - default, 1 - handled, 2 - unhandled
              this._n = false; // <- notify
            };
            Internal.prototype = __webpack_require__('5c95')(
              $Promise.prototype,
              {
                // 25.4.5.3 Promise.prototype.then(onFulfilled, onRejected)
                then: function then(onFulfilled, onRejected) {
                  var reaction = newPromiseCapability(
                    speciesConstructor(this, $Promise)
                  );
                  reaction.ok =
                    typeof onFulfilled == 'function' ? onFulfilled : true;
                  reaction.fail = typeof onRejected == 'function' && onRejected;
                  reaction.domain = isNode ? process.domain : undefined;
                  this._c.push(reaction);
                  if (this._a) this._a.push(reaction);
                  if (this._s) notify(this, false);
                  return reaction.promise;
                },
                // 25.4.5.1 Promise.prototype.catch(onRejected)
                catch: function (onRejected) {
                  return this.then(undefined, onRejected);
                },
              }
            );
            OwnPromiseCapability = function () {
              var promise = new Internal();
              this.promise = promise;
              this.resolve = ctx($resolve, promise, 1);
              this.reject = ctx($reject, promise, 1);
            };
            newPromiseCapabilityModule.f = newPromiseCapability = function (C) {
              return C === $Promise || C === Wrapper
                ? new OwnPromiseCapability(C)
                : newGenericPromiseCapability(C);
            };
          }

          $export($export.G + $export.W + $export.F * !USE_NATIVE, {
            Promise: $Promise,
          });
          __webpack_require__('45f2')($Promise, PROMISE);
          __webpack_require__('4c95')(PROMISE);
          Wrapper = __webpack_require__('584a')[PROMISE];

          // statics
          $export($export.S + $export.F * !USE_NATIVE, PROMISE, {
            // 25.4.4.5 Promise.reject(r)
            reject: function reject(r) {
              var capability = newPromiseCapability(this);
              var $$reject = capability.reject;
              $$reject(r);
              return capability.promise;
            },
          });
          $export($export.S + $export.F * (LIBRARY || !USE_NATIVE), PROMISE, {
            // 25.4.4.6 Promise.resolve(x)
            resolve: function resolve(x) {
              return promiseResolve(
                LIBRARY && this === Wrapper ? $Promise : this,
                x
              );
            },
          });
          $export(
            $export.S +
              $export.F *
                !(
                  USE_NATIVE &&
                  __webpack_require__('4ee1')(function (iter) {
                    $Promise.all(iter)['catch'](empty);
                  })
                ),
            PROMISE,
            {
              // 25.4.4.1 Promise.all(iterable)
              all: function all(iterable) {
                var C = this;
                var capability = newPromiseCapability(C);
                var resolve = capability.resolve;
                var reject = capability.reject;
                var result = perform(function () {
                  var values = [];
                  var index = 0;
                  var remaining = 1;
                  forOf(iterable, false, function (promise) {
                    var $index = index++;
                    var alreadyCalled = false;
                    values.push(undefined);
                    remaining++;
                    C.resolve(promise).then(function (value) {
                      if (alreadyCalled) return;
                      alreadyCalled = true;
                      values[$index] = value;
                      --remaining || resolve(values);
                    }, reject);
                  });
                  --remaining || resolve(values);
                });
                if (result.e) reject(result.v);
                return capability.promise;
              },
              // 25.4.4.4 Promise.race(iterable)
              race: function race(iterable) {
                var C = this;
                var capability = newPromiseCapability(C);
                var reject = capability.reject;
                var result = perform(function () {
                  forOf(iterable, false, function (promise) {
                    C.resolve(promise).then(capability.resolve, reject);
                  });
                });
                if (result.e) reject(result.v);
                return capability.promise;
              },
            }
          );

          /***/
        },

        /***/ '252c': /***/ function (
          module,
          __webpack_exports__,
          __webpack_require__
        ) {
          'use strict';
          /* WEBPACK VAR INJECTION */ (function (global) {
            /* unused harmony export install */
            /* harmony export (binding) */ __webpack_require__.d(
              __webpack_exports__,
              'a',
              function () {
                return ResizeObserver;
              }
            );
            function getInternetExplorerVersion() {
              var ua = window.navigator.userAgent;

              var msie = ua.indexOf('MSIE ');
              if (msie > 0) {
                // IE 10 or older => return version number
                return parseInt(
                  ua.substring(msie + 5, ua.indexOf('.', msie)),
                  10
                );
              }

              var trident = ua.indexOf('Trident/');
              if (trident > 0) {
                // IE 11 => return version number
                var rv = ua.indexOf('rv:');
                return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
              }

              var edge = ua.indexOf('Edge/');
              if (edge > 0) {
                // Edge (IE 12+) => return version number
                return parseInt(
                  ua.substring(edge + 5, ua.indexOf('.', edge)),
                  10
                );
              }

              // other browser
              return -1;
            }

            var isIE = void 0;

            function initCompat() {
              if (!initCompat.init) {
                initCompat.init = true;
                isIE = getInternetExplorerVersion() !== -1;
              }
            }

            var ResizeObserver = {
              render: function render() {
                var _vm = this;
                var _h = _vm.$createElement;
                var _c = _vm._self._c || _h;
                return _c('div', {
                  staticClass: 'resize-observer',
                  attrs: { tabindex: '-1' },
                });
              },
              staticRenderFns: [],
              _scopeId: 'data-v-b329ee4c',
              name: 'resize-observer',

              methods: {
                compareAndNotify: function compareAndNotify() {
                  if (
                    this._w !== this.$el.offsetWidth ||
                    this._h !== this.$el.offsetHeight
                  ) {
                    this._w = this.$el.offsetWidth;
                    this._h = this.$el.offsetHeight;
                    this.$emit('notify');
                  }
                },
                addResizeHandlers: function addResizeHandlers() {
                  this._resizeObject.contentDocument.defaultView.addEventListener(
                    'resize',
                    this.compareAndNotify
                  );
                  this.compareAndNotify();
                },
                removeResizeHandlers: function removeResizeHandlers() {
                  if (this._resizeObject && this._resizeObject.onload) {
                    if (!isIE && this._resizeObject.contentDocument) {
                      this._resizeObject.contentDocument.defaultView.removeEventListener(
                        'resize',
                        this.compareAndNotify
                      );
                    }
                    delete this._resizeObject.onload;
                  }
                },
              },

              mounted: function mounted() {
                var _this = this;

                initCompat();
                this.$nextTick(function () {
                  _this._w = _this.$el.offsetWidth;
                  _this._h = _this.$el.offsetHeight;
                });
                var object = document.createElement('object');
                this._resizeObject = object;
                object.setAttribute('aria-hidden', 'true');
                object.setAttribute('tabindex', -1);
                object.onload = this.addResizeHandlers;
                object.type = 'text/html';
                if (isIE) {
                  this.$el.appendChild(object);
                }
                object.data = 'about:blank';
                if (!isIE) {
                  this.$el.appendChild(object);
                }
              },
              beforeDestroy: function beforeDestroy() {
                this.removeResizeHandlers();
              },
            };

            // Install the components
            function install(Vue) {
              Vue.component('resize-observer', ResizeObserver);
              Vue.component('ResizeObserver', ResizeObserver);
            }

            // Plugin
            var plugin = {
              // eslint-disable-next-line no-undef
              version: '0.4.5',
              install: install,
            };

            // Auto-install
            var GlobalVue = null;
            if (typeof window !== 'undefined') {
              GlobalVue = window.Vue;
            } else if (typeof global !== 'undefined') {
              GlobalVue = global.Vue;
            }
            if (GlobalVue) {
              GlobalVue.use(plugin);
            }

            /* unused harmony default export */ var _unused_webpack_default_export =
              plugin;

            /* WEBPACK VAR INJECTION */
          }).call(this, __webpack_require__('c8ba'));

          /***/
        },

        /***/ '25eb': /***/ function (module, exports) {
          // 7.2.1 RequireObjectCoercible(argument)
          module.exports = function (it) {
            if (it == undefined) throw TypeError("Can't call method on  " + it);
            return it;
          };

          /***/
        },

        /***/ 2621: /***/ function (module, exports) {
          exports.f = Object.getOwnPropertySymbols;

          /***/
        },

        /***/ '292a': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          Object.defineProperty(exports, '__esModule', { value: true });
          exports.default = (color, percent) => {
            if (color.length < 7)
              throw new Error(
                `[shade-color] color must be formatted "#FFFFFF" not like this "#FFF" - (${color})`
              );
            if (!color.includes('#'))
              throw new Error(
                `[shade-color] color must be an HEX - ex: "#FFFFFF" - (${color})`
              );
            let R = parseInt(color.substring(1, 3), 16);
            let G = parseInt(color.substring(3, 5), 16);
            let B = parseInt(color.substring(5, 7), 16);
            R = parseInt(String((R * (100 + percent)) / 100));
            G = parseInt(String((G * (100 + percent)) / 100));
            B = parseInt(String((B * (100 + percent)) / 100));
            R = R < 255 ? R : 255;
            G = G < 255 ? G : 255;
            B = B < 255 ? B : 255;
            const RR =
              R.toString(16).length === 1
                ? '0' + R.toString(16)
                : R.toString(16);
            const GG =
              G.toString(16).length === 1
                ? '0' + G.toString(16)
                : G.toString(16);
            const BB =
              B.toString(16).length === 1
                ? '0' + B.toString(16)
                : B.toString(16);
            return '#' + RR + GG + BB;
          };
          //# sourceMappingURL=index.js.map

          /***/
        },

        /***/ '294c': /***/ function (module, exports) {
          module.exports = function (exec) {
            try {
              return !!exec();
            } catch (e) {
              return true;
            }
          };

          /***/
        },

        /***/ '2aba': /***/ function (module, exports, __webpack_require__) {
          var global = __webpack_require__('7726');
          var hide = __webpack_require__('32e9');
          var has = __webpack_require__('69a8');
          var SRC = __webpack_require__('ca5a')('src');
          var $toString = __webpack_require__('fa5b');
          var TO_STRING = 'toString';
          var TPL = ('' + $toString).split(TO_STRING);

          __webpack_require__('8378').inspectSource = function (it) {
            return $toString.call(it);
          };

          (module.exports = function (O, key, val, safe) {
            var isFunction = typeof val == 'function';
            if (isFunction) has(val, 'name') || hide(val, 'name', key);
            if (O[key] === val) return;
            if (isFunction)
              has(val, SRC) ||
                hide(val, SRC, O[key] ? '' + O[key] : TPL.join(String(key)));
            if (O === global) {
              O[key] = val;
            } else if (!safe) {
              delete O[key];
              hide(O, key, val);
            } else if (O[key]) {
              O[key] = val;
            } else {
              hide(O, key, val);
            }
            // add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
          })(Function.prototype, TO_STRING, function toString() {
            return (
              (typeof this == 'function' && this[SRC]) || $toString.call(this)
            );
          });

          /***/
        },

        /***/ '2aeb': /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
          var anObject = __webpack_require__('cb7c');
          var dPs = __webpack_require__('1495');
          var enumBugKeys = __webpack_require__('e11e');
          var IE_PROTO = __webpack_require__('613b')('IE_PROTO');
          var Empty = function () {
            /* empty */
          };
          var PROTOTYPE = 'prototype';

          // Create object with fake `null` prototype: use iframe Object with cleared prototype
          var createDict = function () {
            // Thrash, waste and sodomy: IE GC bug
            var iframe = __webpack_require__('230e')('iframe');
            var i = enumBugKeys.length;
            var lt = '<';
            var gt = '>';
            var iframeDocument;
            iframe.style.display = 'none';
            __webpack_require__('fab2').appendChild(iframe);
            iframe.src = 'javascript:'; // eslint-disable-line no-script-url
            // createDict = iframe.contentWindow.Object;
            // html.removeChild(iframe);
            iframeDocument = iframe.contentWindow.document;
            iframeDocument.open();
            iframeDocument.write(
              lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt
            );
            iframeDocument.close();
            createDict = iframeDocument.F;
            while (i--) delete createDict[PROTOTYPE][enumBugKeys[i]];
            return createDict();
          };

          module.exports =
            Object.create ||
            function create(O, Properties) {
              var result;
              if (O !== null) {
                Empty[PROTOTYPE] = anObject(O);
                result = new Empty();
                Empty[PROTOTYPE] = null;
                // add "__proto__" for Object.getPrototypeOf polyfill
                result[IE_PROTO] = O;
              } else result = createDict();
              return Properties === undefined
                ? result
                : dPs(result, Properties);
            };

          /***/
        },

        /***/ '2b4c': /***/ function (module, exports, __webpack_require__) {
          var store = __webpack_require__('5537')('wks');
          var uid = __webpack_require__('ca5a');
          var Symbol = __webpack_require__('7726').Symbol;
          var USE_SYMBOL = typeof Symbol == 'function';

          var $exports = (module.exports = function (name) {
            return (
              store[name] ||
              (store[name] =
                (USE_SYMBOL && Symbol[name]) ||
                (USE_SYMBOL ? Symbol : uid)('Symbol.' + name))
            );
          });

          $exports.store = store;

          /***/
        },

        /***/ '2d00': /***/ function (module, exports) {
          module.exports = false;

          /***/
        },

        /***/ '2d95': /***/ function (module, exports) {
          var toString = {}.toString;

          module.exports = function (it) {
            return toString.call(it).slice(8, -1);
          };

          /***/
        },

        /***/ '2fdb': /***/ function (module, exports, __webpack_require__) {
          'use strict';
          // 21.1.3.7 String.prototype.includes(searchString, position = 0)

          var $export = __webpack_require__('5ca1');
          var context = __webpack_require__('d2c8');
          var INCLUDES = 'includes';

          $export(
            $export.P + $export.F * __webpack_require__('5147')(INCLUDES),
            'String',
            {
              includes: function includes(searchString /* , position = 0 */) {
                return !!~context(this, searchString, INCLUDES).indexOf(
                  searchString,
                  arguments.length > 1 ? arguments[1] : undefined
                );
              },
            }
          );

          /***/
        },

        /***/ 3024: /***/ function (module, exports) {
          // fast apply, http://jsperf.lnkit.com/fast-apply/5
          module.exports = function (fn, args, that) {
            var un = that === undefined;
            switch (args.length) {
              case 0:
                return un ? fn() : fn.call(that);
              case 1:
                return un ? fn(args[0]) : fn.call(that, args[0]);
              case 2:
                return un
                  ? fn(args[0], args[1])
                  : fn.call(that, args[0], args[1]);
              case 3:
                return un
                  ? fn(args[0], args[1], args[2])
                  : fn.call(that, args[0], args[1], args[2]);
              case 4:
                return un
                  ? fn(args[0], args[1], args[2], args[3])
                  : fn.call(that, args[0], args[1], args[2], args[3]);
            }
            return fn.apply(that, args);
          };

          /***/
        },

        /***/ '30f1': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var LIBRARY = __webpack_require__('b8e3');
          var $export = __webpack_require__('63b6');
          var redefine = __webpack_require__('9138');
          var hide = __webpack_require__('35e8');
          var Iterators = __webpack_require__('481b');
          var $iterCreate = __webpack_require__('8f60');
          var setToStringTag = __webpack_require__('45f2');
          var getPrototypeOf = __webpack_require__('53e2');
          var ITERATOR = __webpack_require__('5168')('iterator');
          var BUGGY = !([].keys && 'next' in [].keys()); // Safari has buggy iterators w/o `next`
          var FF_ITERATOR = '@@iterator';
          var KEYS = 'keys';
          var VALUES = 'values';

          var returnThis = function () {
            return this;
          };

          module.exports = function (
            Base,
            NAME,
            Constructor,
            next,
            DEFAULT,
            IS_SET,
            FORCED
          ) {
            $iterCreate(Constructor, NAME, next);
            var getMethod = function (kind) {
              if (!BUGGY && kind in proto) return proto[kind];
              switch (kind) {
                case KEYS:
                  return function keys() {
                    return new Constructor(this, kind);
                  };
                case VALUES:
                  return function values() {
                    return new Constructor(this, kind);
                  };
              }
              return function entries() {
                return new Constructor(this, kind);
              };
            };
            var TAG = NAME + ' Iterator';
            var DEF_VALUES = DEFAULT == VALUES;
            var VALUES_BUG = false;
            var proto = Base.prototype;
            var $native =
              proto[ITERATOR] ||
              proto[FF_ITERATOR] ||
              (DEFAULT && proto[DEFAULT]);
            var $default = $native || getMethod(DEFAULT);
            var $entries = DEFAULT
              ? !DEF_VALUES
                ? $default
                : getMethod('entries')
              : undefined;
            var $anyNative =
              NAME == 'Array' ? proto.entries || $native : $native;
            var methods, key, IteratorPrototype;
            // Fix native
            if ($anyNative) {
              IteratorPrototype = getPrototypeOf($anyNative.call(new Base()));
              if (
                IteratorPrototype !== Object.prototype &&
                IteratorPrototype.next
              ) {
                // Set @@toStringTag to native iterators
                setToStringTag(IteratorPrototype, TAG, true);
                // fix for some old engines
                if (
                  !LIBRARY &&
                  typeof IteratorPrototype[ITERATOR] != 'function'
                )
                  hide(IteratorPrototype, ITERATOR, returnThis);
              }
            }
            // fix Array#{values, @@iterator}.name in V8 / FF
            if (DEF_VALUES && $native && $native.name !== VALUES) {
              VALUES_BUG = true;
              $default = function values() {
                return $native.call(this);
              };
            }
            // Define iterator
            if (
              (!LIBRARY || FORCED) &&
              (BUGGY || VALUES_BUG || !proto[ITERATOR])
            ) {
              hide(proto, ITERATOR, $default);
            }
            // Plug for library
            Iterators[NAME] = $default;
            Iterators[TAG] = returnThis;
            if (DEFAULT) {
              methods = {
                values: DEF_VALUES ? $default : getMethod(VALUES),
                keys: IS_SET ? $default : getMethod(KEYS),
                entries: $entries,
              };
              if (FORCED)
                for (key in methods) {
                  if (!(key in proto)) redefine(proto, key, methods[key]);
                }
              else
                $export(
                  $export.P + $export.F * (BUGGY || VALUES_BUG),
                  NAME,
                  methods
                );
            }
            return methods;
          };

          /***/
        },

        /***/ '32e9': /***/ function (module, exports, __webpack_require__) {
          var dP = __webpack_require__('86cc');
          var createDesc = __webpack_require__('4630');
          module.exports = __webpack_require__('9e1e')
            ? function (object, key, value) {
                return dP.f(object, key, createDesc(1, value));
              }
            : function (object, key, value) {
                object[key] = value;
                return object;
              };

          /***/
        },

        /***/ '32fc': /***/ function (module, exports, __webpack_require__) {
          var document = __webpack_require__('e53d').document;
          module.exports = document && document.documentElement;

          /***/
        },

        /***/ '335c': /***/ function (module, exports, __webpack_require__) {
          // fallback for non-array-like ES3 and non-enumerable old V8 strings
          var cof = __webpack_require__('6b4c');
          // eslint-disable-next-line no-prototype-builtins
          module.exports = Object('z').propertyIsEnumerable(0)
            ? Object
            : function (it) {
                return cof(it) == 'String' ? it.split('') : Object(it);
              };

          /***/
        },

        /***/ '355d': /***/ function (module, exports) {
          exports.f = {}.propertyIsEnumerable;

          /***/
        },

        /***/ '35e8': /***/ function (module, exports, __webpack_require__) {
          var dP = __webpack_require__('d9f6');
          var createDesc = __webpack_require__('aebd');
          module.exports = __webpack_require__('8e60')
            ? function (object, key, value) {
                return dP.f(object, key, createDesc(1, value));
              }
            : function (object, key, value) {
                object[key] = value;
                return object;
              };

          /***/
        },

        /***/ '36c3': /***/ function (module, exports, __webpack_require__) {
          // to indexed object, toObject with fallback for non-array-like ES3 strings
          var IObject = __webpack_require__('335c');
          var defined = __webpack_require__('25eb');
          module.exports = function (it) {
            return IObject(defined(it));
          };

          /***/
        },

        /***/ 3702: /***/ function (module, exports, __webpack_require__) {
          // check on default Array iterator
          var Iterators = __webpack_require__('481b');
          var ITERATOR = __webpack_require__('5168')('iterator');
          var ArrayProto = Array.prototype;

          module.exports = function (it) {
            return (
              it !== undefined &&
              (Iterators.Array === it || ArrayProto[ITERATOR] === it)
            );
          };

          /***/
        },

        /***/ 3846: /***/ function (module, exports, __webpack_require__) {
          // 21.2.5.3 get RegExp.prototype.flags()
          if (__webpack_require__('9e1e') && /./g.flags != 'g')
            __webpack_require__('86cc').f(RegExp.prototype, 'flags', {
              configurable: true,
              get: __webpack_require__('0bfb'),
            });

          /***/
        },

        /***/ '38fd': /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
          var has = __webpack_require__('69a8');
          var toObject = __webpack_require__('4bf8');
          var IE_PROTO = __webpack_require__('613b')('IE_PROTO');
          var ObjectProto = Object.prototype;

          module.exports =
            Object.getPrototypeOf ||
            function (O) {
              O = toObject(O);
              if (has(O, IE_PROTO)) return O[IE_PROTO];
              if (
                typeof O.constructor == 'function' &&
                O instanceof O.constructor
              ) {
                return O.constructor.prototype;
              }
              return O instanceof Object ? ObjectProto : null;
            };

          /***/
        },

        /***/ '3a38': /***/ function (module, exports) {
          // 7.1.4 ToInteger
          var ceil = Math.ceil;
          var floor = Math.floor;
          module.exports = function (it) {
            return isNaN((it = +it)) ? 0 : (it > 0 ? floor : ceil)(it);
          };

          /***/
        },

        /***/ '3c11': /***/ function (module, exports, __webpack_require__) {
          'use strict';
          // https://github.com/tc39/proposal-promise-finally

          var $export = __webpack_require__('63b6');
          var core = __webpack_require__('584a');
          var global = __webpack_require__('e53d');
          var speciesConstructor = __webpack_require__('f201');
          var promiseResolve = __webpack_require__('cd78');

          $export($export.P + $export.R, 'Promise', {
            finally: function (onFinally) {
              var C = speciesConstructor(this, core.Promise || global.Promise);
              var isFunction = typeof onFinally == 'function';
              return this.then(
                isFunction
                  ? function (x) {
                      return promiseResolve(C, onFinally()).then(function () {
                        return x;
                      });
                    }
                  : onFinally,
                isFunction
                  ? function (e) {
                      return promiseResolve(C, onFinally()).then(function () {
                        throw e;
                      });
                    }
                  : onFinally
              );
            },
          });

          /***/
        },

        /***/ '40c3': /***/ function (module, exports, __webpack_require__) {
          // getting tag from 19.1.3.6 Object.prototype.toString()
          var cof = __webpack_require__('6b4c');
          var TAG = __webpack_require__('5168')('toStringTag');
          // ES3 wrong here
          var ARG =
            cof(
              (function () {
                return arguments;
              })()
            ) == 'Arguments';

          // fallback for IE11 Script Access Denied error
          var tryGet = function (it, key) {
            try {
              return it[key];
            } catch (e) {
              /* empty */
            }
          };

          module.exports = function (it) {
            var O, T, B;
            return it === undefined
              ? 'Undefined'
              : it === null
                ? 'Null'
                : // @@toStringTag case
                  typeof (T = tryGet((O = Object(it)), TAG)) == 'string'
                  ? T
                  : // builtinTag case
                    ARG
                    ? cof(O)
                    : // ES3 arguments fallback
                      (B = cof(O)) == 'Object' && typeof O.callee == 'function'
                      ? 'Arguments'
                      : B;
          };

          /***/
        },

        /***/ 4178: /***/ function (module, exports, __webpack_require__) {
          var ctx = __webpack_require__('d864');
          var invoke = __webpack_require__('3024');
          var html = __webpack_require__('32fc');
          var cel = __webpack_require__('1ec9');
          var global = __webpack_require__('e53d');
          var process = global.process;
          var setTask = global.setImmediate;
          var clearTask = global.clearImmediate;
          var MessageChannel = global.MessageChannel;
          var Dispatch = global.Dispatch;
          var counter = 0;
          var queue = {};
          var ONREADYSTATECHANGE = 'onreadystatechange';
          var defer, channel, port;
          var run = function () {
            var id = +this;
            // eslint-disable-next-line no-prototype-builtins
            if (queue.hasOwnProperty(id)) {
              var fn = queue[id];
              delete queue[id];
              fn();
            }
          };
          var listener = function (event) {
            run.call(event.data);
          };
          // Node.js 0.9+ & IE10+ has setImmediate, otherwise:
          if (!setTask || !clearTask) {
            setTask = function setImmediate(fn) {
              var args = [];
              var i = 1;
              while (arguments.length > i) args.push(arguments[i++]);
              queue[++counter] = function () {
                // eslint-disable-next-line no-new-func
                invoke(typeof fn == 'function' ? fn : Function(fn), args);
              };
              defer(counter);
              return counter;
            };
            clearTask = function clearImmediate(id) {
              delete queue[id];
            };
            // Node.js 0.8-
            if (__webpack_require__('6b4c')(process) == 'process') {
              defer = function (id) {
                process.nextTick(ctx(run, id, 1));
              };
              // Sphere (JS game engine) Dispatch API
            } else if (Dispatch && Dispatch.now) {
              defer = function (id) {
                Dispatch.now(ctx(run, id, 1));
              };
              // Browsers with MessageChannel, includes WebWorkers
            } else if (MessageChannel) {
              channel = new MessageChannel();
              port = channel.port2;
              channel.port1.onmessage = listener;
              defer = ctx(port.postMessage, port, 1);
              // Browsers with postMessage, skip WebWorkers
              // IE8 has postMessage, but it's sync & typeof its postMessage is 'object'
            } else if (
              global.addEventListener &&
              typeof postMessage == 'function' &&
              !global.importScripts
            ) {
              defer = function (id) {
                global.postMessage(id + '', '*');
              };
              global.addEventListener('message', listener, false);
              // IE8-
            } else if (ONREADYSTATECHANGE in cel('script')) {
              defer = function (id) {
                html.appendChild(cel('script'))[ONREADYSTATECHANGE] =
                  function () {
                    html.removeChild(this);
                    run.call(id);
                  };
              };
              // Rest old browsers
            } else {
              defer = function (id) {
                setTimeout(ctx(run, id, 1), 0);
              };
            }
          }
          module.exports = {
            set: setTask,
            clear: clearTask,
          };

          /***/
        },

        /***/ '41a0': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var create = __webpack_require__('2aeb');
          var descriptor = __webpack_require__('4630');
          var setToStringTag = __webpack_require__('7f20');
          var IteratorPrototype = {};

          // 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
          __webpack_require__('32e9')(
            IteratorPrototype,
            __webpack_require__('2b4c')('iterator'),
            function () {
              return this;
            }
          );

          module.exports = function (Constructor, NAME, next) {
            Constructor.prototype = create(IteratorPrototype, {
              next: descriptor(1, next),
            });
            setToStringTag(Constructor, NAME + ' Iterator');
          };

          /***/
        },

        /***/ '43fc': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          // https://github.com/tc39/proposal-promise-try
          var $export = __webpack_require__('63b6');
          var newPromiseCapability = __webpack_require__('656e');
          var perform = __webpack_require__('4439');

          $export($export.S, 'Promise', {
            try: function (callbackfn) {
              var promiseCapability = newPromiseCapability.f(this);
              var result = perform(callbackfn);
              (result.e ? promiseCapability.reject : promiseCapability.resolve)(
                result.v
              );
              return promiseCapability.promise;
            },
          });

          /***/
        },

        /***/ 4439: /***/ function (module, exports) {
          module.exports = function (exec) {
            try {
              return { e: false, v: exec() };
            } catch (e) {
              return { e: true, v: e };
            }
          };

          /***/
        },

        /***/ '454f': /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('46a7');
          var $Object = __webpack_require__('584a').Object;
          module.exports = function defineProperty(it, key, desc) {
            return $Object.defineProperty(it, key, desc);
          };

          /***/
        },

        /***/ '456d': /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.14 Object.keys(O)
          var toObject = __webpack_require__('4bf8');
          var $keys = __webpack_require__('0d58');

          __webpack_require__('5eda')('keys', function () {
            return function keys(it) {
              return $keys(toObject(it));
            };
          });

          /***/
        },

        /***/ 4588: /***/ function (module, exports) {
          // 7.1.4 ToInteger
          var ceil = Math.ceil;
          var floor = Math.floor;
          module.exports = function (it) {
            return isNaN((it = +it)) ? 0 : (it > 0 ? floor : ceil)(it);
          };

          /***/
        },

        /***/ '45d0': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var __importDefault =
            (this && this.__importDefault) ||
            function (mod) {
              return mod && mod.__esModule ? mod : { default: mod };
            };
          Object.defineProperty(exports, '__esModule', { value: true });
          const _constantes_1 = __importDefault(__webpack_require__('0750'));
          exports.default = (color) => {
            if (!color) throw new Error('is-color-name: No color provided');
            const colorsList = Object.keys(_constantes_1.default);
            return colorsList.includes(color);
          };
          //# sourceMappingURL=index.js.map

          /***/
        },

        /***/ '45f2': /***/ function (module, exports, __webpack_require__) {
          var def = __webpack_require__('d9f6').f;
          var has = __webpack_require__('07e3');
          var TAG = __webpack_require__('5168')('toStringTag');

          module.exports = function (it, tag, stat) {
            if (it && !has((it = stat ? it : it.prototype), TAG))
              def(it, TAG, { configurable: true, value: tag });
          };

          /***/
        },

        /***/ 4630: /***/ function (module, exports) {
          module.exports = function (bitmap, value) {
            return {
              enumerable: !(bitmap & 1),
              configurable: !(bitmap & 2),
              writable: !(bitmap & 4),
              value: value,
            };
          };

          /***/
        },

        /***/ '46a7': /***/ function (module, exports, __webpack_require__) {
          var $export = __webpack_require__('63b6');
          // 19.1.2.4 / 15.2.3.6 Object.defineProperty(O, P, Attributes)
          $export(
            $export.S + $export.F * !__webpack_require__('8e60'),
            'Object',
            { defineProperty: __webpack_require__('d9f6').f }
          );

          /***/
        },

        /***/ '47ee': /***/ function (module, exports, __webpack_require__) {
          // all enumerable object keys, includes symbols
          var getKeys = __webpack_require__('c3a1');
          var gOPS = __webpack_require__('9aa9');
          var pIE = __webpack_require__('355d');
          module.exports = function (it) {
            var result = getKeys(it);
            var getSymbols = gOPS.f;
            if (getSymbols) {
              var symbols = getSymbols(it);
              var isEnum = pIE.f;
              var i = 0;
              var key;
              while (symbols.length > i)
                if (isEnum.call(it, (key = symbols[i++]))) result.push(key);
            }
            return result;
          };

          /***/
        },

        /***/ '481b': /***/ function (module, exports) {
          module.exports = {};

          /***/
        },

        /***/ '4bf8': /***/ function (module, exports, __webpack_require__) {
          // 7.1.13 ToObject(argument)
          var defined = __webpack_require__('be13');
          module.exports = function (it) {
            return Object(defined(it));
          };

          /***/
        },

        /***/ '4c95': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var global = __webpack_require__('e53d');
          var core = __webpack_require__('584a');
          var dP = __webpack_require__('d9f6');
          var DESCRIPTORS = __webpack_require__('8e60');
          var SPECIES = __webpack_require__('5168')('species');

          module.exports = function (KEY) {
            var C = typeof core[KEY] == 'function' ? core[KEY] : global[KEY];
            if (DESCRIPTORS && C && !C[SPECIES])
              dP.f(C, SPECIES, {
                configurable: true,
                get: function () {
                  return this;
                },
              });
          };

          /***/
        },

        /***/ '4ee1': /***/ function (module, exports, __webpack_require__) {
          var ITERATOR = __webpack_require__('5168')('iterator');
          var SAFE_CLOSING = false;

          try {
            var riter = [7][ITERATOR]();
            riter['return'] = function () {
              SAFE_CLOSING = true;
            };
            // eslint-disable-next-line no-throw-literal
            Array.from(riter, function () {
              throw 2;
            });
          } catch (e) {
            /* empty */
          }

          module.exports = function (exec, skipClosing) {
            if (!skipClosing && !SAFE_CLOSING) return false;
            var safe = false;
            try {
              var arr = [7];
              var iter = arr[ITERATOR]();
              iter.next = function () {
                return { done: (safe = true) };
              };
              arr[ITERATOR] = function () {
                return iter;
              };
              exec(arr);
            } catch (e) {
              /* empty */
            }
            return safe;
          };

          /***/
        },

        /***/ '50ed': /***/ function (module, exports) {
          module.exports = function (done, value) {
            return { value: value, done: !!done };
          };

          /***/
        },

        /***/ 5147: /***/ function (module, exports, __webpack_require__) {
          var MATCH = __webpack_require__('2b4c')('match');
          module.exports = function (KEY) {
            var re = /./;
            try {
              '/./'[KEY](re);
            } catch (e) {
              try {
                re[MATCH] = false;
                return !'/./'[KEY](re);
              } catch (f) {
                /* empty */
              }
            }
            return true;
          };

          /***/
        },

        /***/ 5168: /***/ function (module, exports, __webpack_require__) {
          var store = __webpack_require__('dbdb')('wks');
          var uid = __webpack_require__('62a0');
          var Symbol = __webpack_require__('e53d').Symbol;
          var USE_SYMBOL = typeof Symbol == 'function';

          var $exports = (module.exports = function (name) {
            return (
              store[name] ||
              (store[name] =
                (USE_SYMBOL && Symbol[name]) ||
                (USE_SYMBOL ? Symbol : uid)('Symbol.' + name))
            );
          });

          $exports.store = store;

          /***/
        },

        /***/ '52a7': /***/ function (module, exports) {
          exports.f = {}.propertyIsEnumerable;

          /***/
        },

        /***/ '53e2': /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
          var has = __webpack_require__('07e3');
          var toObject = __webpack_require__('241e');
          var IE_PROTO = __webpack_require__('5559')('IE_PROTO');
          var ObjectProto = Object.prototype;

          module.exports =
            Object.getPrototypeOf ||
            function (O) {
              O = toObject(O);
              if (has(O, IE_PROTO)) return O[IE_PROTO];
              if (
                typeof O.constructor == 'function' &&
                O instanceof O.constructor
              ) {
                return O.constructor.prototype;
              }
              return O instanceof Object ? ObjectProto : null;
            };

          /***/
        },

        /***/ '549b': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var ctx = __webpack_require__('d864');
          var $export = __webpack_require__('63b6');
          var toObject = __webpack_require__('241e');
          var call = __webpack_require__('b0dc');
          var isArrayIter = __webpack_require__('3702');
          var toLength = __webpack_require__('b447');
          var createProperty = __webpack_require__('20fd');
          var getIterFn = __webpack_require__('7cd6');

          $export(
            $export.S +
              $export.F *
                !__webpack_require__('4ee1')(function (iter) {
                  Array.from(iter);
                }),
            'Array',
            {
              // 22.1.2.1 Array.from(arrayLike, mapfn = undefined, thisArg = undefined)
              from: function from(
                arrayLike /* , mapfn = undefined, thisArg = undefined */
              ) {
                var O = toObject(arrayLike);
                var C = typeof this == 'function' ? this : Array;
                var aLen = arguments.length;
                var mapfn = aLen > 1 ? arguments[1] : undefined;
                var mapping = mapfn !== undefined;
                var index = 0;
                var iterFn = getIterFn(O);
                var length, result, step, iterator;
                if (mapping)
                  mapfn = ctx(mapfn, aLen > 2 ? arguments[2] : undefined, 2);
                // if object isn't iterable or it's array with default iterator - use simple case
                if (
                  iterFn != undefined &&
                  !(C == Array && isArrayIter(iterFn))
                ) {
                  for (
                    iterator = iterFn.call(O), result = new C();
                    !(step = iterator.next()).done;
                    index++
                  ) {
                    createProperty(
                      result,
                      index,
                      mapping
                        ? call(iterator, mapfn, [step.value, index], true)
                        : step.value
                    );
                  }
                } else {
                  length = toLength(O.length);
                  for (result = new C(length); length > index; index++) {
                    createProperty(
                      result,
                      index,
                      mapping ? mapfn(O[index], index) : O[index]
                    );
                  }
                }
                result.length = index;
                return result;
              },
            }
          );

          /***/
        },

        /***/ '54a1': /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('6c1c');
          __webpack_require__('1654');
          module.exports = __webpack_require__('95d5');

          /***/
        },

        /***/ 5537: /***/ function (module, exports, __webpack_require__) {
          var core = __webpack_require__('8378');
          var global = __webpack_require__('7726');
          var SHARED = '__core-js_shared__';
          var store = global[SHARED] || (global[SHARED] = {});

          (module.exports = function (key, value) {
            return (
              store[key] || (store[key] = value !== undefined ? value : {})
            );
          })('versions', []).push({
            version: core.version,
            mode: __webpack_require__('2d00') ? 'pure' : 'global',
            copyright: '© 2019 Denis Pushkarev (zloirock.ru)',
          });

          /***/
        },

        /***/ 5559: /***/ function (module, exports, __webpack_require__) {
          var shared = __webpack_require__('dbdb')('keys');
          var uid = __webpack_require__('62a0');
          module.exports = function (key) {
            return shared[key] || (shared[key] = uid(key));
          };

          /***/
        },

        /***/ '584a': /***/ function (module, exports) {
          var core = (module.exports = { version: '2.6.11' });
          if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef

          /***/
        },

        /***/ '5b4e': /***/ function (module, exports, __webpack_require__) {
          // false -> Array#indexOf
          // true  -> Array#includes
          var toIObject = __webpack_require__('36c3');
          var toLength = __webpack_require__('b447');
          var toAbsoluteIndex = __webpack_require__('0fc9');
          module.exports = function (IS_INCLUDES) {
            return function ($this, el, fromIndex) {
              var O = toIObject($this);
              var length = toLength(O.length);
              var index = toAbsoluteIndex(fromIndex, length);
              var value;
              // Array#includes uses SameValueZero equality algorithm
              // eslint-disable-next-line no-self-compare
              if (IS_INCLUDES && el != el)
                while (length > index) {
                  value = O[index++];
                  // eslint-disable-next-line no-self-compare
                  if (value != value) return true;
                  // Array#indexOf ignores holes, Array#includes - not
                }
              else
                for (; length > index; index++)
                  if (IS_INCLUDES || index in O) {
                    if (O[index] === el) return IS_INCLUDES || index || 0;
                  }
              return !IS_INCLUDES && -1;
            };
          };

          /***/
        },

        /***/ '5c95': /***/ function (module, exports, __webpack_require__) {
          var hide = __webpack_require__('35e8');
          module.exports = function (target, src, safe) {
            for (var key in src) {
              if (safe && target[key]) target[key] = src[key];
              else hide(target, key, src[key]);
            }
            return target;
          };

          /***/
        },

        /***/ '5ca1': /***/ function (module, exports, __webpack_require__) {
          var global = __webpack_require__('7726');
          var core = __webpack_require__('8378');
          var hide = __webpack_require__('32e9');
          var redefine = __webpack_require__('2aba');
          var ctx = __webpack_require__('9b43');
          var PROTOTYPE = 'prototype';

          var $export = function (type, name, source) {
            var IS_FORCED = type & $export.F;
            var IS_GLOBAL = type & $export.G;
            var IS_STATIC = type & $export.S;
            var IS_PROTO = type & $export.P;
            var IS_BIND = type & $export.B;
            var target = IS_GLOBAL
              ? global
              : IS_STATIC
                ? global[name] || (global[name] = {})
                : (global[name] || {})[PROTOTYPE];
            var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
            var expProto = exports[PROTOTYPE] || (exports[PROTOTYPE] = {});
            var key, own, out, exp;
            if (IS_GLOBAL) source = name;
            for (key in source) {
              // contains in native
              own = !IS_FORCED && target && target[key] !== undefined;
              // export native or passed
              out = (own ? target : source)[key];
              // bind timers to global for call from export context
              exp =
                IS_BIND && own
                  ? ctx(out, global)
                  : IS_PROTO && typeof out == 'function'
                    ? ctx(Function.call, out)
                    : out;
              // extend global
              if (target) redefine(target, key, out, type & $export.U);
              // export
              if (exports[key] != out) hide(exports, key, exp);
              if (IS_PROTO && expProto[key] != out) expProto[key] = out;
            }
          };
          global.core = core;
          // type bitmap
          $export.F = 1; // forced
          $export.G = 2; // global
          $export.S = 4; // static
          $export.P = 8; // proto
          $export.B = 16; // bind
          $export.W = 32; // wrap
          $export.U = 64; // safe
          $export.R = 128; // real proto method for `library`
          module.exports = $export;

          /***/
        },

        /***/ '5dbc': /***/ function (module, exports, __webpack_require__) {
          var isObject = __webpack_require__('d3f4');
          var setPrototypeOf = __webpack_require__('8b97').set;
          module.exports = function (that, target, C) {
            var S = target.constructor;
            var P;
            if (
              S !== C &&
              typeof S == 'function' &&
              (P = S.prototype) !== C.prototype &&
              isObject(P) &&
              setPrototypeOf
            ) {
              setPrototypeOf(that, P);
            }
            return that;
          };

          /***/
        },

        /***/ '5eda': /***/ function (module, exports, __webpack_require__) {
          // most Object methods by ES6 should accept primitives
          var $export = __webpack_require__('5ca1');
          var core = __webpack_require__('8378');
          var fails = __webpack_require__('79e5');
          module.exports = function (KEY, exec) {
            var fn = (core.Object || {})[KEY] || Object[KEY];
            var exp = {};
            exp[KEY] = exec(fn);
            $export(
              $export.S +
                $export.F *
                  fails(function () {
                    fn(1);
                  }),
              'Object',
              exp
            );
          };

          /***/
        },

        /***/ 6038: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var __importDefault =
            (this && this.__importDefault) ||
            function (mod) {
              return mod && mod.__esModule ? mod : { default: mod };
            };
          Object.defineProperty(exports, '__esModule', { value: true });
          exports.hexToRgba =
            exports.colorNameToHex =
            exports.isColorName =
            exports.shadeColor =
              void 0;
          const shade_color_1 = __importDefault(__webpack_require__('292a'));
          exports.shadeColor = shade_color_1.default;
          const is_color_name_1 = __importDefault(__webpack_require__('45d0'));
          exports.isColorName = is_color_name_1.default;
          const hex_to_rgba_1 = __importDefault(__webpack_require__('1c15'));
          exports.hexToRgba = hex_to_rgba_1.default;
          const color_name_to_hex_1 = __importDefault(
            __webpack_require__('c3b0')
          );
          exports.colorNameToHex = color_name_to_hex_1.default;
          //# sourceMappingURL=app.js.map

          /***/
        },

        /***/ '613b': /***/ function (module, exports, __webpack_require__) {
          var shared = __webpack_require__('5537')('keys');
          var uid = __webpack_require__('ca5a');
          module.exports = function (key) {
            return shared[key] || (shared[key] = uid(key));
          };

          /***/
        },

        /***/ '626a': /***/ function (module, exports, __webpack_require__) {
          // fallback for non-array-like ES3 and non-enumerable old V8 strings
          var cof = __webpack_require__('2d95');
          // eslint-disable-next-line no-prototype-builtins
          module.exports = Object('z').propertyIsEnumerable(0)
            ? Object
            : function (it) {
                return cof(it) == 'String' ? it.split('') : Object(it);
              };

          /***/
        },

        /***/ '62a0': /***/ function (module, exports) {
          var id = 0;
          var px = Math.random();
          module.exports = function (key) {
            return 'Symbol('.concat(
              key === undefined ? '' : key,
              ')_',
              (++id + px).toString(36)
            );
          };

          /***/
        },

        /***/ '63b6': /***/ function (module, exports, __webpack_require__) {
          var global = __webpack_require__('e53d');
          var core = __webpack_require__('584a');
          var ctx = __webpack_require__('d864');
          var hide = __webpack_require__('35e8');
          var has = __webpack_require__('07e3');
          var PROTOTYPE = 'prototype';

          var $export = function (type, name, source) {
            var IS_FORCED = type & $export.F;
            var IS_GLOBAL = type & $export.G;
            var IS_STATIC = type & $export.S;
            var IS_PROTO = type & $export.P;
            var IS_BIND = type & $export.B;
            var IS_WRAP = type & $export.W;
            var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
            var expProto = exports[PROTOTYPE];
            var target = IS_GLOBAL
              ? global
              : IS_STATIC
                ? global[name]
                : (global[name] || {})[PROTOTYPE];
            var key, own, out;
            if (IS_GLOBAL) source = name;
            for (key in source) {
              // contains in native
              own = !IS_FORCED && target && target[key] !== undefined;
              if (own && has(exports, key)) continue;
              // export native or passed
              out = own ? target[key] : source[key];
              // prevent global pollution for namespaces
              exports[key] =
                IS_GLOBAL && typeof target[key] != 'function'
                  ? source[key]
                  : // bind timers to global for call from export context
                    IS_BIND && own
                    ? ctx(out, global)
                    : // wrap global constructors for prevent change them in library
                      IS_WRAP && target[key] == out
                      ? (function (C) {
                          var F = function (a, b, c) {
                            if (this instanceof C) {
                              switch (arguments.length) {
                                case 0:
                                  return new C();
                                case 1:
                                  return new C(a);
                                case 2:
                                  return new C(a, b);
                              }
                              return new C(a, b, c);
                            }
                            return C.apply(this, arguments);
                          };
                          F[PROTOTYPE] = C[PROTOTYPE];
                          return F;
                          // make static versions for prototype methods
                        })(out)
                      : IS_PROTO && typeof out == 'function'
                        ? ctx(Function.call, out)
                        : out;
              // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
              if (IS_PROTO) {
                (exports.virtual || (exports.virtual = {}))[key] = out;
                // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
                if (type & $export.R && expProto && !expProto[key])
                  hide(expProto, key, out);
              }
            }
          };
          // type bitmap
          $export.F = 1; // forced
          $export.G = 2; // global
          $export.S = 4; // static
          $export.P = 8; // proto
          $export.B = 16; // bind
          $export.W = 32; // wrap
          $export.U = 64; // safe
          $export.R = 128; // real proto method for `library`
          module.exports = $export;

          /***/
        },

        /***/ '656e': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          // 25.4.1.5 NewPromiseCapability(C)
          var aFunction = __webpack_require__('79aa');

          function PromiseCapability(C) {
            var resolve, reject;
            this.promise = new C(function ($$resolve, $$reject) {
              if (resolve !== undefined || reject !== undefined)
                throw TypeError('Bad Promise constructor');
              resolve = $$resolve;
              reject = $$reject;
            });
            this.resolve = aFunction(resolve);
            this.reject = aFunction(reject);
          }

          module.exports.f = function (C) {
            return new PromiseCapability(C);
          };

          /***/
        },

        /***/ 6718: /***/ function (module, exports, __webpack_require__) {
          var global = __webpack_require__('e53d');
          var core = __webpack_require__('584a');
          var LIBRARY = __webpack_require__('b8e3');
          var wksExt = __webpack_require__('ccb9');
          var defineProperty = __webpack_require__('d9f6').f;
          module.exports = function (name) {
            var $Symbol =
              core.Symbol || (core.Symbol = LIBRARY ? {} : global.Symbol || {});
            if (name.charAt(0) != '_' && !(name in $Symbol))
              defineProperty($Symbol, name, { value: wksExt.f(name) });
          };

          /***/
        },

        /***/ 6762: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          // https://github.com/tc39/Array.prototype.includes
          var $export = __webpack_require__('5ca1');
          var $includes = __webpack_require__('c366')(true);

          $export($export.P, 'Array', {
            includes: function includes(el /* , fromIndex = 0 */) {
              return $includes(
                this,
                el,
                arguments.length > 1 ? arguments[1] : undefined
              );
            },
          });

          __webpack_require__('9c6c')('includes');

          /***/
        },

        /***/ '67bb': /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('f921');

          /***/
        },

        /***/ 6821: /***/ function (module, exports, __webpack_require__) {
          // to indexed object, toObject with fallback for non-array-like ES3 strings
          var IObject = __webpack_require__('626a');
          var defined = __webpack_require__('be13');
          module.exports = function (it) {
            return IObject(defined(it));
          };

          /***/
        },

        /***/ '696e': /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('c207');
          __webpack_require__('1654');
          __webpack_require__('6c1c');
          __webpack_require__('24c5');
          __webpack_require__('3c11');
          __webpack_require__('43fc');
          module.exports = __webpack_require__('584a').Promise;

          /***/
        },

        /***/ '69a8': /***/ function (module, exports) {
          var hasOwnProperty = {}.hasOwnProperty;
          module.exports = function (it, key) {
            return hasOwnProperty.call(it, key);
          };

          /***/
        },

        /***/ '69d3': /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('6718')('asyncIterator');

          /***/
        },

        /***/ '6a99': /***/ function (module, exports, __webpack_require__) {
          // 7.1.1 ToPrimitive(input [, PreferredType])
          var isObject = __webpack_require__('d3f4');
          // instead of the ES6 spec version, we didn't implement @@toPrimitive case
          // and the second argument - flag - preferred type is a string
          module.exports = function (it, S) {
            if (!isObject(it)) return it;
            var fn, val;
            if (
              S &&
              typeof (fn = it.toString) == 'function' &&
              !isObject((val = fn.call(it)))
            )
              return val;
            if (
              typeof (fn = it.valueOf) == 'function' &&
              !isObject((val = fn.call(it)))
            )
              return val;
            if (
              !S &&
              typeof (fn = it.toString) == 'function' &&
              !isObject((val = fn.call(it)))
            )
              return val;
            throw TypeError("Can't convert object to primitive value");
          };

          /***/
        },

        /***/ '6abf': /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.7 / 15.2.3.4 Object.getOwnPropertyNames(O)
          var $keys = __webpack_require__('e6f3');
          var hiddenKeys = __webpack_require__('1691').concat(
            'length',
            'prototype'
          );

          exports.f =
            Object.getOwnPropertyNames ||
            function getOwnPropertyNames(O) {
              return $keys(O, hiddenKeys);
            };

          /***/
        },

        /***/ '6b4c': /***/ function (module, exports) {
          var toString = {}.toString;

          module.exports = function (it) {
            return toString.call(it).slice(8, -1);
          };

          /***/
        },

        /***/ '6b54': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          __webpack_require__('3846');
          var anObject = __webpack_require__('cb7c');
          var $flags = __webpack_require__('0bfb');
          var DESCRIPTORS = __webpack_require__('9e1e');
          var TO_STRING = 'toString';
          var $toString = /./[TO_STRING];

          var define = function (fn) {
            __webpack_require__('2aba')(RegExp.prototype, TO_STRING, fn, true);
          };

          // 21.2.5.14 RegExp.prototype.toString()
          if (
            __webpack_require__('79e5')(function () {
              return $toString.call({ source: 'a', flags: 'b' }) != '/a/b';
            })
          ) {
            define(function toString() {
              var R = anObject(this);
              return '/'.concat(
                R.source,
                '/',
                'flags' in R
                  ? R.flags
                  : !DESCRIPTORS && R instanceof RegExp
                    ? $flags.call(R)
                    : undefined
              );
            });
            // FF44- RegExp#toString has a wrong name
          } else if ($toString.name != TO_STRING) {
            define(function toString() {
              return $toString.call(this);
            });
          }

          /***/
        },

        /***/ '6c1c': /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('c367');
          var global = __webpack_require__('e53d');
          var hide = __webpack_require__('35e8');
          var Iterators = __webpack_require__('481b');
          var TO_STRING_TAG = __webpack_require__('5168')('toStringTag');

          var DOMIterables = (
            'CSSRuleList,CSSStyleDeclaration,CSSValueList,ClientRectList,DOMRectList,DOMStringList,' +
            'DOMTokenList,DataTransferItemList,FileList,HTMLAllCollection,HTMLCollection,HTMLFormElement,HTMLSelectElement,' +
            'MediaList,MimeTypeArray,NamedNodeMap,NodeList,PaintRequestList,Plugin,PluginArray,SVGLengthList,SVGNumberList,' +
            'SVGPathSegList,SVGPointList,SVGStringList,SVGTransformList,SourceBufferList,StyleSheetList,TextTrackCueList,' +
            'TextTrackList,TouchList'
          ).split(',');

          for (var i = 0; i < DOMIterables.length; i++) {
            var NAME = DOMIterables[i];
            var Collection = global[NAME];
            var proto = Collection && Collection.prototype;
            if (proto && !proto[TO_STRING_TAG])
              hide(proto, TO_STRING_TAG, NAME);
            Iterators[NAME] = Iterators.Array;
          }

          /***/
        },

        /***/ '71c1': /***/ function (module, exports, __webpack_require__) {
          var toInteger = __webpack_require__('3a38');
          var defined = __webpack_require__('25eb');
          // true  -> String#at
          // false -> String#codePointAt
          module.exports = function (TO_STRING) {
            return function (that, pos) {
              var s = String(defined(that));
              var i = toInteger(pos);
              var l = s.length;
              var a, b;
              if (i < 0 || i >= l) return TO_STRING ? '' : undefined;
              a = s.charCodeAt(i);
              return a < 0xd800 ||
                a > 0xdbff ||
                i + 1 === l ||
                (b = s.charCodeAt(i + 1)) < 0xdc00 ||
                b > 0xdfff
                ? TO_STRING
                  ? s.charAt(i)
                  : a
                : TO_STRING
                  ? s.slice(i, i + 2)
                  : ((a - 0xd800) << 10) + (b - 0xdc00) + 0x10000;
            };
          };

          /***/
        },

        /***/ 7514: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          // 22.1.3.8 Array.prototype.find(predicate, thisArg = undefined)
          var $export = __webpack_require__('5ca1');
          var $find = __webpack_require__('0a49')(5);
          var KEY = 'find';
          var forced = true;
          // Shouldn't skip holes
          if (KEY in [])
            Array(1)[KEY](function () {
              forced = false;
            });
          $export($export.P + $export.F * forced, 'Array', {
            find: function find(callbackfn /* , that = undefined */) {
              return $find(
                this,
                callbackfn,
                arguments.length > 1 ? arguments[1] : undefined
              );
            },
          });
          __webpack_require__('9c6c')(KEY);

          /***/
        },

        /***/ '765d': /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('6718')('observable');

          /***/
        },

        /***/ 7726: /***/ function (module, exports) {
          // https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
          var global = (module.exports =
            typeof window != 'undefined' && window.Math == Math
              ? window
              : typeof self != 'undefined' && self.Math == Math
                ? self
                : // eslint-disable-next-line no-new-func
                  Function('return this')());
          if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef

          /***/
        },

        /***/ '774e': /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('d2d5');

          /***/
        },

        /***/ '77f1': /***/ function (module, exports, __webpack_require__) {
          var toInteger = __webpack_require__('4588');
          var max = Math.max;
          var min = Math.min;
          module.exports = function (index, length) {
            index = toInteger(index);
            return index < 0 ? max(index + length, 0) : min(index, length);
          };

          /***/
        },

        /***/ '794b': /***/ function (module, exports, __webpack_require__) {
          module.exports =
            !__webpack_require__('8e60') &&
            !__webpack_require__('294c')(function () {
              return (
                Object.defineProperty(__webpack_require__('1ec9')('div'), 'a', {
                  get: function () {
                    return 7;
                  },
                }).a != 7
              );
            });

          /***/
        },

        /***/ '795b': /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('696e');

          /***/
        },

        /***/ '79aa': /***/ function (module, exports) {
          module.exports = function (it) {
            if (typeof it != 'function')
              throw TypeError(it + ' is not a function!');
            return it;
          };

          /***/
        },

        /***/ '79e5': /***/ function (module, exports) {
          module.exports = function (exec) {
            try {
              return !!exec();
            } catch (e) {
              return true;
            }
          };

          /***/
        },

        /***/ '7cd6': /***/ function (module, exports, __webpack_require__) {
          var classof = __webpack_require__('40c3');
          var ITERATOR = __webpack_require__('5168')('iterator');
          var Iterators = __webpack_require__('481b');
          module.exports = __webpack_require__('584a').getIteratorMethod =
            function (it) {
              if (it != undefined)
                return (
                  it[ITERATOR] || it['@@iterator'] || Iterators[classof(it)]
                );
            };

          /***/
        },

        /***/ '7e90': /***/ function (module, exports, __webpack_require__) {
          var dP = __webpack_require__('d9f6');
          var anObject = __webpack_require__('e4ae');
          var getKeys = __webpack_require__('c3a1');

          module.exports = __webpack_require__('8e60')
            ? Object.defineProperties
            : function defineProperties(O, Properties) {
                anObject(O);
                var keys = getKeys(Properties);
                var length = keys.length;
                var i = 0;
                var P;
                while (length > i) dP.f(O, (P = keys[i++]), Properties[P]);
                return O;
              };

          /***/
        },

        /***/ '7f20': /***/ function (module, exports, __webpack_require__) {
          var def = __webpack_require__('86cc').f;
          var has = __webpack_require__('69a8');
          var TAG = __webpack_require__('2b4c')('toStringTag');

          module.exports = function (it, tag, stat) {
            if (it && !has((it = stat ? it : it.prototype), TAG))
              def(it, TAG, { configurable: true, value: tag });
          };

          /***/
        },

        /***/ '7f7f': /***/ function (module, exports, __webpack_require__) {
          var dP = __webpack_require__('86cc').f;
          var FProto = Function.prototype;
          var nameRE = /^\s*function ([^ (]*)/;
          var NAME = 'name';

          // 19.2.4.2 name
          NAME in FProto ||
            (__webpack_require__('9e1e') &&
              dP(FProto, NAME, {
                configurable: true,
                get: function () {
                  try {
                    return ('' + this).match(nameRE)[1];
                  } catch (e) {
                    return '';
                  }
                },
              }));

          /***/
        },

        /***/ '7f9a': /***/ function (module, exports, __webpack_require__) {
          // extracted by mini-css-extract-plugin
          /***/
        },

        /***/ 8378: /***/ function (module, exports) {
          var core = (module.exports = { version: '2.6.11' });
          if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef

          /***/
        },

        /***/ 8436: /***/ function (module, exports) {
          module.exports = function () {
            /* empty */
          };

          /***/
        },

        /***/ '84f2': /***/ function (module, exports) {
          module.exports = {};

          /***/
        },

        /***/ '85f2': /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('454f');

          /***/
        },

        /***/ '85fe': /***/ function (
          module,
          __webpack_exports__,
          __webpack_require__
        ) {
          'use strict';
          /* WEBPACK VAR INJECTION */ (function (global) {
            /* harmony export (binding) */ __webpack_require__.d(
              __webpack_exports__,
              'a',
              function () {
                return ObserveVisibility;
              }
            );
            /* unused harmony export install */
            function _typeof(obj) {
              if (
                typeof Symbol === 'function' &&
                typeof Symbol.iterator === 'symbol'
              ) {
                _typeof = function (obj) {
                  return typeof obj;
                };
              } else {
                _typeof = function (obj) {
                  return obj &&
                    typeof Symbol === 'function' &&
                    obj.constructor === Symbol &&
                    obj !== Symbol.prototype
                    ? 'symbol'
                    : typeof obj;
                };
              }

              return _typeof(obj);
            }

            function _classCallCheck(instance, Constructor) {
              if (!(instance instanceof Constructor)) {
                throw new TypeError('Cannot call a class as a function');
              }
            }

            function _defineProperties(target, props) {
              for (var i = 0; i < props.length; i++) {
                var descriptor = props[i];
                descriptor.enumerable = descriptor.enumerable || false;
                descriptor.configurable = true;
                if ('value' in descriptor) descriptor.writable = true;
                Object.defineProperty(target, descriptor.key, descriptor);
              }
            }

            function _createClass(Constructor, protoProps, staticProps) {
              if (protoProps)
                _defineProperties(Constructor.prototype, protoProps);
              if (staticProps) _defineProperties(Constructor, staticProps);
              return Constructor;
            }

            function _toConsumableArray(arr) {
              return (
                _arrayWithoutHoles(arr) ||
                _iterableToArray(arr) ||
                _nonIterableSpread()
              );
            }

            function _arrayWithoutHoles(arr) {
              if (Array.isArray(arr)) {
                for (
                  var i = 0, arr2 = new Array(arr.length);
                  i < arr.length;
                  i++
                )
                  arr2[i] = arr[i];

                return arr2;
              }
            }

            function _iterableToArray(iter) {
              if (
                Symbol.iterator in Object(iter) ||
                Object.prototype.toString.call(iter) === '[object Arguments]'
              )
                return Array.from(iter);
            }

            function _nonIterableSpread() {
              throw new TypeError(
                'Invalid attempt to spread non-iterable instance'
              );
            }

            function processOptions(value) {
              var options;

              if (typeof value === 'function') {
                // Simple options (callback-only)
                options = {
                  callback: value,
                };
              } else {
                // Options object
                options = value;
              }

              return options;
            }
            function throttle(callback, delay) {
              var options =
                arguments.length > 2 && arguments[2] !== undefined
                  ? arguments[2]
                  : {};
              var timeout;
              var lastState;
              var currentArgs;

              var throttled = function throttled(state) {
                for (
                  var _len = arguments.length,
                    args = new Array(_len > 1 ? _len - 1 : 0),
                    _key = 1;
                  _key < _len;
                  _key++
                ) {
                  args[_key - 1] = arguments[_key];
                }

                currentArgs = args;
                if (timeout && state === lastState) return;
                var leading = options.leading;

                if (typeof leading === 'function') {
                  leading = leading(state, lastState);
                }

                if ((!timeout || state !== lastState) && leading) {
                  callback.apply(
                    void 0,
                    [state].concat(_toConsumableArray(currentArgs))
                  );
                }

                lastState = state;
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                  callback.apply(
                    void 0,
                    [state].concat(_toConsumableArray(currentArgs))
                  );
                  timeout = 0;
                }, delay);
              };

              throttled._clear = function () {
                clearTimeout(timeout);
                timeout = null;
              };

              return throttled;
            }
            function deepEqual(val1, val2) {
              if (val1 === val2) return true;

              if (_typeof(val1) === 'object') {
                for (var key in val1) {
                  if (!deepEqual(val1[key], val2[key])) {
                    return false;
                  }
                }

                return true;
              }

              return false;
            }

            var VisibilityState =
              /*#__PURE__*/
              (function () {
                function VisibilityState(el, options, vnode) {
                  _classCallCheck(this, VisibilityState);

                  this.el = el;
                  this.observer = null;
                  this.frozen = false;
                  this.createObserver(options, vnode);
                }

                _createClass(VisibilityState, [
                  {
                    key: 'createObserver',
                    value: function createObserver(options, vnode) {
                      var _this = this;

                      if (this.observer) {
                        this.destroyObserver();
                      }

                      if (this.frozen) return;
                      this.options = processOptions(options);

                      this.callback = function (result, entry) {
                        _this.options.callback(result, entry);

                        if (result && _this.options.once) {
                          _this.frozen = true;

                          _this.destroyObserver();
                        }
                      }; // Throttle

                      if (this.callback && this.options.throttle) {
                        var _ref = this.options.throttleOptions || {},
                          _leading = _ref.leading;

                        this.callback = throttle(
                          this.callback,
                          this.options.throttle,
                          {
                            leading: function leading(state) {
                              return (
                                _leading === 'both' ||
                                (_leading === 'visible' && state) ||
                                (_leading === 'hidden' && !state)
                              );
                            },
                          }
                        );
                      }

                      this.oldResult = undefined;
                      this.observer = new IntersectionObserver(function (
                        entries
                      ) {
                        var entry = entries[0];

                        if (entries.length > 1) {
                          var intersectingEntry = entries.find(function (e) {
                            return e.isIntersecting;
                          });

                          if (intersectingEntry) {
                            entry = intersectingEntry;
                          }
                        }

                        if (_this.callback) {
                          // Use isIntersecting if possible because browsers can report isIntersecting as true, but intersectionRatio as 0, when something very slowly enters the viewport.
                          var result =
                            entry.isIntersecting &&
                            entry.intersectionRatio >= _this.threshold;
                          if (result === _this.oldResult) return;
                          _this.oldResult = result;

                          _this.callback(result, entry);
                        }
                      }, this.options.intersection); // Wait for the element to be in document

                      vnode.context.$nextTick(function () {
                        if (_this.observer) {
                          _this.observer.observe(_this.el);
                        }
                      });
                    },
                  },
                  {
                    key: 'destroyObserver',
                    value: function destroyObserver() {
                      if (this.observer) {
                        this.observer.disconnect();
                        this.observer = null;
                      } // Cancel throttled call

                      if (this.callback && this.callback._clear) {
                        this.callback._clear();

                        this.callback = null;
                      }
                    },
                  },
                  {
                    key: 'threshold',
                    get: function get() {
                      return (
                        (this.options.intersection &&
                          this.options.intersection.threshold) ||
                        0
                      );
                    },
                  },
                ]);

                return VisibilityState;
              })();

            function bind(el, _ref2, vnode) {
              var value = _ref2.value;
              if (!value) return;

              if (typeof IntersectionObserver === 'undefined') {
                console.warn(
                  '[vue-observe-visibility] IntersectionObserver API is not available in your browser. Please install this polyfill: https://github.com/w3c/IntersectionObserver/tree/master/polyfill'
                );
              } else {
                var state = new VisibilityState(el, value, vnode);
                el._vue_visibilityState = state;
              }
            }

            function update(el, _ref3, vnode) {
              var value = _ref3.value,
                oldValue = _ref3.oldValue;
              if (deepEqual(value, oldValue)) return;
              var state = el._vue_visibilityState;

              if (!value) {
                unbind(el);
                return;
              }

              if (state) {
                state.createObserver(value, vnode);
              } else {
                bind(
                  el,
                  {
                    value: value,
                  },
                  vnode
                );
              }
            }

            function unbind(el) {
              var state = el._vue_visibilityState;

              if (state) {
                state.destroyObserver();
                delete el._vue_visibilityState;
              }
            }

            var ObserveVisibility = {
              bind: bind,
              update: update,
              unbind: unbind,
            };

            function install(Vue) {
              Vue.directive('observe-visibility', ObserveVisibility);
              /* -- Add more components here -- */
            }
            /* -- Plugin definition & Auto-install -- */

            /* You shouldn't have to modify the code below */
            // Plugin

            var plugin = {
              // eslint-disable-next-line no-undef
              version: '0.4.6',
              install: install,
            };

            var GlobalVue = null;

            if (typeof window !== 'undefined') {
              GlobalVue = window.Vue;
            } else if (typeof global !== 'undefined') {
              GlobalVue = global.Vue;
            }

            if (GlobalVue) {
              GlobalVue.use(plugin);
            }

            /* unused harmony default export */ var _unused_webpack_default_export =
              plugin;

            /* WEBPACK VAR INJECTION */
          }).call(this, __webpack_require__('c8ba'));

          /***/
        },

        /***/ '86cc': /***/ function (module, exports, __webpack_require__) {
          var anObject = __webpack_require__('cb7c');
          var IE8_DOM_DEFINE = __webpack_require__('c69a');
          var toPrimitive = __webpack_require__('6a99');
          var dP = Object.defineProperty;

          exports.f = __webpack_require__('9e1e')
            ? Object.defineProperty
            : function defineProperty(O, P, Attributes) {
                anObject(O);
                P = toPrimitive(P, true);
                anObject(Attributes);
                if (IE8_DOM_DEFINE)
                  try {
                    return dP(O, P, Attributes);
                  } catch (e) {
                    /* empty */
                  }
                if ('get' in Attributes || 'set' in Attributes)
                  throw TypeError('Accessors not supported!');
                if ('value' in Attributes) O[P] = Attributes.value;
                return O;
              };

          /***/
        },

        /***/ 8875: /***/ function (module, exports, __webpack_require__) {
          var __WEBPACK_AMD_DEFINE_FACTORY__,
            __WEBPACK_AMD_DEFINE_ARRAY__,
            __WEBPACK_AMD_DEFINE_RESULT__; // addapted from the document.currentScript polyfill by Adam Miller
          // MIT license
          // source: https://github.com/amiller-gh/currentScript-polyfill

          // added support for Firefox https://bugzilla.mozilla.org/show_bug.cgi?id=1620505

          (function (root, factory) {
            if (true) {
              !((__WEBPACK_AMD_DEFINE_ARRAY__ = []),
              (__WEBPACK_AMD_DEFINE_FACTORY__ = factory),
              (__WEBPACK_AMD_DEFINE_RESULT__ =
                typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function'
                  ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(
                      exports,
                      __WEBPACK_AMD_DEFINE_ARRAY__
                    )
                  : __WEBPACK_AMD_DEFINE_FACTORY__),
              __WEBPACK_AMD_DEFINE_RESULT__ !== undefined &&
                (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
            } else {
            }
          })(typeof self !== 'undefined' ? self : this, function () {
            function getCurrentScript() {
              if (document.currentScript) {
                return document.currentScript;
              }

              // IE 8-10 support script readyState
              // IE 11+ & Firefox support stack trace
              try {
                throw new Error();
              } catch (err) {
                // Find the second match for the "at" string to get file src url from stack.
                var ieStackRegExp = /.*at [^(]*\((.*):(.+):(.+)\)$/gi,
                  ffStackRegExp = /@([^@]*):(\d+):(\d+)\s*$/gi,
                  stackDetails =
                    ieStackRegExp.exec(err.stack) ||
                    ffStackRegExp.exec(err.stack),
                  scriptLocation = (stackDetails && stackDetails[1]) || false,
                  line = (stackDetails && stackDetails[2]) || false,
                  currentLocation = document.location.href.replace(
                    document.location.hash,
                    ''
                  ),
                  pageSource,
                  inlineScriptSourceRegExp,
                  inlineScriptSource,
                  scripts = document.getElementsByTagName('script'); // Live NodeList collection

                if (scriptLocation === currentLocation) {
                  pageSource = document.documentElement.outerHTML;
                  inlineScriptSourceRegExp = new RegExp(
                    '(?:[^\\n]+?\\n){0,' +
                      (line - 2) +
                      '}[^<]*<script>([\\d\\D]*?)<\\/script>[\\d\\D]*',
                    'i'
                  );
                  inlineScriptSource = pageSource
                    .replace(inlineScriptSourceRegExp, '$1')
                    .trim();
                }

                for (var i = 0; i < scripts.length; i++) {
                  // If ready state is interactive, return the script tag
                  if (scripts[i].readyState === 'interactive') {
                    return scripts[i];
                  }

                  // If src matches, return the script tag
                  if (scripts[i].src === scriptLocation) {
                    return scripts[i];
                  }

                  // If inline source matches, return the script tag
                  if (
                    scriptLocation === currentLocation &&
                    scripts[i].innerHTML &&
                    scripts[i].innerHTML.trim() === inlineScriptSource
                  ) {
                    return scripts[i];
                  }
                }

                // If no match, return null
                return null;
              }
            }

            return getCurrentScript;
          });

          /***/
        },

        /***/ '8b97': /***/ function (module, exports, __webpack_require__) {
          // Works with __proto__ only. Old v8 can't work with null proto objects.
          /* eslint-disable no-proto */
          var isObject = __webpack_require__('d3f4');
          var anObject = __webpack_require__('cb7c');
          var check = function (O, proto) {
            anObject(O);
            if (!isObject(proto) && proto !== null)
              throw TypeError(proto + ": can't set as prototype!");
          };
          module.exports = {
            set:
              Object.setPrototypeOf ||
              ('__proto__' in {} // eslint-disable-line
                ? (function (test, buggy, set) {
                    try {
                      set = __webpack_require__('9b43')(
                        Function.call,
                        __webpack_require__('11e9').f(
                          Object.prototype,
                          '__proto__'
                        ).set,
                        2
                      );
                      set(test, []);
                      buggy = !(test instanceof Array);
                    } catch (e) {
                      buggy = true;
                    }
                    return function setPrototypeOf(O, proto) {
                      check(O, proto);
                      if (buggy) O.__proto__ = proto;
                      else set(O, proto);
                      return O;
                    };
                  })({}, false)
                : undefined),
            check: check,
          };

          /***/
        },

        /***/ '8bbf': /***/ function (module, exports) {
          module.exports = __WEBPACK_EXTERNAL_MODULE__8bbf__;

          /***/
        },

        /***/ '8e60': /***/ function (module, exports, __webpack_require__) {
          // Thank's IE8 for his funny defineProperty
          module.exports = !__webpack_require__('294c')(function () {
            return (
              Object.defineProperty({}, 'a', {
                get: function () {
                  return 7;
                },
              }).a != 7
            );
          });

          /***/
        },

        /***/ '8e6e': /***/ function (module, exports, __webpack_require__) {
          // https://github.com/tc39/proposal-object-getownpropertydescriptors
          var $export = __webpack_require__('5ca1');
          var ownKeys = __webpack_require__('990b');
          var toIObject = __webpack_require__('6821');
          var gOPD = __webpack_require__('11e9');
          var createProperty = __webpack_require__('f1ae');

          $export($export.S, 'Object', {
            getOwnPropertyDescriptors: function getOwnPropertyDescriptors(
              object
            ) {
              var O = toIObject(object);
              var getDesc = gOPD.f;
              var keys = ownKeys(O);
              var result = {};
              var i = 0;
              var key, desc;
              while (keys.length > i) {
                desc = getDesc(O, (key = keys[i++]));
                if (desc !== undefined) createProperty(result, key, desc);
              }
              return result;
            },
          });

          /***/
        },

        /***/ '8f60': /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var create = __webpack_require__('a159');
          var descriptor = __webpack_require__('aebd');
          var setToStringTag = __webpack_require__('45f2');
          var IteratorPrototype = {};

          // 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
          __webpack_require__('35e8')(
            IteratorPrototype,
            __webpack_require__('5168')('iterator'),
            function () {
              return this;
            }
          );

          module.exports = function (Constructor, NAME, next) {
            Constructor.prototype = create(IteratorPrototype, {
              next: descriptor(1, next),
            });
            setToStringTag(Constructor, NAME + ' Iterator');
          };

          /***/
        },

        /***/ 9003: /***/ function (module, exports, __webpack_require__) {
          // 7.2.2 IsArray(argument)
          var cof = __webpack_require__('6b4c');
          module.exports =
            Array.isArray ||
            function isArray(arg) {
              return cof(arg) == 'Array';
            };

          /***/
        },

        /***/ 9093: /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.7 / 15.2.3.4 Object.getOwnPropertyNames(O)
          var $keys = __webpack_require__('ce10');
          var hiddenKeys = __webpack_require__('e11e').concat(
            'length',
            'prototype'
          );

          exports.f =
            Object.getOwnPropertyNames ||
            function getOwnPropertyNames(O) {
              return $keys(O, hiddenKeys);
            };

          /***/
        },

        /***/ 9138: /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('35e8');

          /***/
        },

        /***/ '95d5': /***/ function (module, exports, __webpack_require__) {
          var classof = __webpack_require__('40c3');
          var ITERATOR = __webpack_require__('5168')('iterator');
          var Iterators = __webpack_require__('481b');
          module.exports = __webpack_require__('584a').isIterable = function (
            it
          ) {
            var O = Object(it);
            return (
              O[ITERATOR] !== undefined ||
              '@@iterator' in O ||
              // eslint-disable-next-line no-prototype-builtins
              Iterators.hasOwnProperty(classof(O))
            );
          };

          /***/
        },

        /***/ '96cf': /***/ function (module, exports, __webpack_require__) {
          /**
           * Copyright (c) 2014-present, Facebook, Inc.
           *
           * This source code is licensed under the MIT license found in the
           * LICENSE file in the root directory of this source tree.
           */

          var runtime = (function (exports) {
            'use strict';

            var Op = Object.prototype;
            var hasOwn = Op.hasOwnProperty;
            var undefined; // More compressible than void 0.
            var $Symbol = typeof Symbol === 'function' ? Symbol : {};
            var iteratorSymbol = $Symbol.iterator || '@@iterator';
            var asyncIteratorSymbol =
              $Symbol.asyncIterator || '@@asyncIterator';
            var toStringTagSymbol = $Symbol.toStringTag || '@@toStringTag';

            function define(obj, key, value) {
              Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
              });
              return obj[key];
            }
            try {
              // IE 8 has a broken Object.defineProperty that only works on DOM objects.
              define({}, '');
            } catch (err) {
              define = function (obj, key, value) {
                return (obj[key] = value);
              };
            }

            function wrap(innerFn, outerFn, self, tryLocsList) {
              // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
              var protoGenerator =
                outerFn && outerFn.prototype instanceof Generator
                  ? outerFn
                  : Generator;
              var generator = Object.create(protoGenerator.prototype);
              var context = new Context(tryLocsList || []);

              // The ._invoke method unifies the implementations of the .next,
              // .throw, and .return methods.
              generator._invoke = makeInvokeMethod(innerFn, self, context);

              return generator;
            }
            exports.wrap = wrap;

            // Try/catch helper to minimize deoptimizations. Returns a completion
            // record like context.tryEntries[i].completion. This interface could
            // have been (and was previously) designed to take a closure to be
            // invoked without arguments, but in all the cases we care about we
            // already have an existing method we want to call, so there's no need
            // to create a new function object. We can even get away with assuming
            // the method takes exactly one argument, since that happens to be true
            // in every case, so we don't have to touch the arguments object. The
            // only additional allocation required is the completion record, which
            // has a stable shape and so hopefully should be cheap to allocate.
            function tryCatch(fn, obj, arg) {
              try {
                return { type: 'normal', arg: fn.call(obj, arg) };
              } catch (err) {
                return { type: 'throw', arg: err };
              }
            }

            var GenStateSuspendedStart = 'suspendedStart';
            var GenStateSuspendedYield = 'suspendedYield';
            var GenStateExecuting = 'executing';
            var GenStateCompleted = 'completed';

            // Returning this object from the innerFn has the same effect as
            // breaking out of the dispatch switch statement.
            var ContinueSentinel = {};

            // Dummy constructor functions that we use as the .constructor and
            // .constructor.prototype properties for functions that return Generator
            // objects. For full spec compliance, you may wish to configure your
            // minifier not to mangle the names of these two functions.
            function Generator() {}
            function GeneratorFunction() {}
            function GeneratorFunctionPrototype() {}

            // This is a polyfill for %IteratorPrototype% for environments that
            // don't natively support it.
            var IteratorPrototype = {};
            define(IteratorPrototype, iteratorSymbol, function () {
              return this;
            });

            var getProto = Object.getPrototypeOf;
            var NativeIteratorPrototype =
              getProto && getProto(getProto(values([])));
            if (
              NativeIteratorPrototype &&
              NativeIteratorPrototype !== Op &&
              hasOwn.call(NativeIteratorPrototype, iteratorSymbol)
            ) {
              // This environment has a native %IteratorPrototype%; use it instead
              // of the polyfill.
              IteratorPrototype = NativeIteratorPrototype;
            }

            var Gp =
              (GeneratorFunctionPrototype.prototype =
              Generator.prototype =
                Object.create(IteratorPrototype));
            GeneratorFunction.prototype = GeneratorFunctionPrototype;
            define(Gp, 'constructor', GeneratorFunctionPrototype);
            define(
              GeneratorFunctionPrototype,
              'constructor',
              GeneratorFunction
            );
            GeneratorFunction.displayName = define(
              GeneratorFunctionPrototype,
              toStringTagSymbol,
              'GeneratorFunction'
            );

            // Helper for defining the .next, .throw, and .return methods of the
            // Iterator interface in terms of a single ._invoke method.
            function defineIteratorMethods(prototype) {
              ['next', 'throw', 'return'].forEach(function (method) {
                define(prototype, method, function (arg) {
                  return this._invoke(method, arg);
                });
              });
            }

            exports.isGeneratorFunction = function (genFun) {
              var ctor = typeof genFun === 'function' && genFun.constructor;
              return ctor
                ? ctor === GeneratorFunction ||
                    // For the native GeneratorFunction constructor, the best we can
                    // do is to check its .name property.
                    (ctor.displayName || ctor.name) === 'GeneratorFunction'
                : false;
            };

            exports.mark = function (genFun) {
              if (Object.setPrototypeOf) {
                Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
              } else {
                genFun.__proto__ = GeneratorFunctionPrototype;
                define(genFun, toStringTagSymbol, 'GeneratorFunction');
              }
              genFun.prototype = Object.create(Gp);
              return genFun;
            };

            // Within the body of any async function, `await x` is transformed to
            // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
            // `hasOwn.call(value, "__await")` to determine if the yielded value is
            // meant to be awaited.
            exports.awrap = function (arg) {
              return { __await: arg };
            };

            function AsyncIterator(generator, PromiseImpl) {
              function invoke(method, arg, resolve, reject) {
                var record = tryCatch(generator[method], generator, arg);
                if (record.type === 'throw') {
                  reject(record.arg);
                } else {
                  var result = record.arg;
                  var value = result.value;
                  if (
                    value &&
                    typeof value === 'object' &&
                    hasOwn.call(value, '__await')
                  ) {
                    return PromiseImpl.resolve(value.__await).then(
                      function (value) {
                        invoke('next', value, resolve, reject);
                      },
                      function (err) {
                        invoke('throw', err, resolve, reject);
                      }
                    );
                  }

                  return PromiseImpl.resolve(value).then(
                    function (unwrapped) {
                      // When a yielded Promise is resolved, its final value becomes
                      // the .value of the Promise<{value,done}> result for the
                      // current iteration.
                      result.value = unwrapped;
                      resolve(result);
                    },
                    function (error) {
                      // If a rejected Promise was yielded, throw the rejection back
                      // into the async generator function so it can be handled there.
                      return invoke('throw', error, resolve, reject);
                    }
                  );
                }
              }

              var previousPromise;

              function enqueue(method, arg) {
                function callInvokeWithMethodAndArg() {
                  return new PromiseImpl(function (resolve, reject) {
                    invoke(method, arg, resolve, reject);
                  });
                }

                return (previousPromise =
                  // If enqueue has been called before, then we want to wait until
                  // all previous Promises have been resolved before calling invoke,
                  // so that results are always delivered in the correct order. If
                  // enqueue has not been called before, then it is important to
                  // call invoke immediately, without waiting on a callback to fire,
                  // so that the async generator function has the opportunity to do
                  // any necessary setup in a predictable way. This predictability
                  // is why the Promise constructor synchronously invokes its
                  // executor callback, and why async functions synchronously
                  // execute code before the first await. Since we implement simple
                  // async functions in terms of async generators, it is especially
                  // important to get this right, even though it requires care.
                  previousPromise
                    ? previousPromise.then(
                        callInvokeWithMethodAndArg,
                        // Avoid propagating failures to Promises returned by later
                        // invocations of the iterator.
                        callInvokeWithMethodAndArg
                      )
                    : callInvokeWithMethodAndArg());
              }

              // Define the unified helper method that is used to implement .next,
              // .throw, and .return (see defineIteratorMethods).
              this._invoke = enqueue;
            }

            defineIteratorMethods(AsyncIterator.prototype);
            define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
              return this;
            });
            exports.AsyncIterator = AsyncIterator;

            // Note that simple async functions are implemented on top of
            // AsyncIterator objects; they just return a Promise for the value of
            // the final result produced by the iterator.
            exports.async = function (
              innerFn,
              outerFn,
              self,
              tryLocsList,
              PromiseImpl
            ) {
              if (PromiseImpl === void 0) PromiseImpl = Promise;

              var iter = new AsyncIterator(
                wrap(innerFn, outerFn, self, tryLocsList),
                PromiseImpl
              );

              return exports.isGeneratorFunction(outerFn)
                ? iter // If outerFn is a generator, return the full iterator.
                : iter.next().then(function (result) {
                    return result.done ? result.value : iter.next();
                  });
            };

            function makeInvokeMethod(innerFn, self, context) {
              var state = GenStateSuspendedStart;

              return function invoke(method, arg) {
                if (state === GenStateExecuting) {
                  throw new Error('Generator is already running');
                }

                if (state === GenStateCompleted) {
                  if (method === 'throw') {
                    throw arg;
                  }

                  // Be forgiving, per 25.3.3.3.3 of the spec:
                  // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
                  return doneResult();
                }

                context.method = method;
                context.arg = arg;

                while (true) {
                  var delegate = context.delegate;
                  if (delegate) {
                    var delegateResult = maybeInvokeDelegate(delegate, context);
                    if (delegateResult) {
                      if (delegateResult === ContinueSentinel) continue;
                      return delegateResult;
                    }
                  }

                  if (context.method === 'next') {
                    // Setting context._sent for legacy support of Babel's
                    // function.sent implementation.
                    context.sent = context._sent = context.arg;
                  } else if (context.method === 'throw') {
                    if (state === GenStateSuspendedStart) {
                      state = GenStateCompleted;
                      throw context.arg;
                    }

                    context.dispatchException(context.arg);
                  } else if (context.method === 'return') {
                    context.abrupt('return', context.arg);
                  }

                  state = GenStateExecuting;

                  var record = tryCatch(innerFn, self, context);
                  if (record.type === 'normal') {
                    // If an exception is thrown from innerFn, we leave state ===
                    // GenStateExecuting and loop back for another invocation.
                    state = context.done
                      ? GenStateCompleted
                      : GenStateSuspendedYield;

                    if (record.arg === ContinueSentinel) {
                      continue;
                    }

                    return {
                      value: record.arg,
                      done: context.done,
                    };
                  } else if (record.type === 'throw') {
                    state = GenStateCompleted;
                    // Dispatch the exception by looping back around to the
                    // context.dispatchException(context.arg) call above.
                    context.method = 'throw';
                    context.arg = record.arg;
                  }
                }
              };
            }

            // Call delegate.iterator[context.method](context.arg) and handle the
            // result, either by returning a { value, done } result from the
            // delegate iterator, or by modifying context.method and context.arg,
            // setting context.delegate to null, and returning the ContinueSentinel.
            function maybeInvokeDelegate(delegate, context) {
              var method = delegate.iterator[context.method];
              if (method === undefined) {
                // A .throw or .return when the delegate iterator has no .throw
                // method always terminates the yield* loop.
                context.delegate = null;

                if (context.method === 'throw') {
                  // Note: ["return"] must be used for ES3 parsing compatibility.
                  if (delegate.iterator['return']) {
                    // If the delegate iterator has a return method, give it a
                    // chance to clean up.
                    context.method = 'return';
                    context.arg = undefined;
                    maybeInvokeDelegate(delegate, context);

                    if (context.method === 'throw') {
                      // If maybeInvokeDelegate(context) changed context.method from
                      // "return" to "throw", let that override the TypeError below.
                      return ContinueSentinel;
                    }
                  }

                  context.method = 'throw';
                  context.arg = new TypeError(
                    "The iterator does not provide a 'throw' method"
                  );
                }

                return ContinueSentinel;
              }

              var record = tryCatch(method, delegate.iterator, context.arg);

              if (record.type === 'throw') {
                context.method = 'throw';
                context.arg = record.arg;
                context.delegate = null;
                return ContinueSentinel;
              }

              var info = record.arg;

              if (!info) {
                context.method = 'throw';
                context.arg = new TypeError('iterator result is not an object');
                context.delegate = null;
                return ContinueSentinel;
              }

              if (info.done) {
                // Assign the result of the finished delegate to the temporary
                // variable specified by delegate.resultName (see delegateYield).
                context[delegate.resultName] = info.value;

                // Resume execution at the desired location (see delegateYield).
                context.next = delegate.nextLoc;

                // If context.method was "throw" but the delegate handled the
                // exception, let the outer generator proceed normally. If
                // context.method was "next", forget context.arg since it has been
                // "consumed" by the delegate iterator. If context.method was
                // "return", allow the original .return call to continue in the
                // outer generator.
                if (context.method !== 'return') {
                  context.method = 'next';
                  context.arg = undefined;
                }
              } else {
                // Re-yield the result returned by the delegate method.
                return info;
              }

              // The delegate iterator is finished, so forget it and continue with
              // the outer generator.
              context.delegate = null;
              return ContinueSentinel;
            }

            // Define Generator.prototype.{next,throw,return} in terms of the
            // unified ._invoke helper method.
            defineIteratorMethods(Gp);

            define(Gp, toStringTagSymbol, 'Generator');

            // A Generator should always return itself as the iterator object when the
            // @@iterator function is called on it. Some browsers' implementations of the
            // iterator prototype chain incorrectly implement this, causing the Generator
            // object to not be returned from this call. This ensures that doesn't happen.
            // See https://github.com/facebook/regenerator/issues/274 for more details.
            define(Gp, iteratorSymbol, function () {
              return this;
            });

            define(Gp, 'toString', function () {
              return '[object Generator]';
            });

            function pushTryEntry(locs) {
              var entry = { tryLoc: locs[0] };

              if (1 in locs) {
                entry.catchLoc = locs[1];
              }

              if (2 in locs) {
                entry.finallyLoc = locs[2];
                entry.afterLoc = locs[3];
              }

              this.tryEntries.push(entry);
            }

            function resetTryEntry(entry) {
              var record = entry.completion || {};
              record.type = 'normal';
              delete record.arg;
              entry.completion = record;
            }

            function Context(tryLocsList) {
              // The root entry object (effectively a try statement without a catch
              // or a finally block) gives us a place to store values thrown from
              // locations where there is no enclosing try statement.
              this.tryEntries = [{ tryLoc: 'root' }];
              tryLocsList.forEach(pushTryEntry, this);
              this.reset(true);
            }

            exports.keys = function (object) {
              var keys = [];
              for (var key in object) {
                keys.push(key);
              }
              keys.reverse();

              // Rather than returning an object with a next method, we keep
              // things simple and return the next function itself.
              return function next() {
                while (keys.length) {
                  var key = keys.pop();
                  if (key in object) {
                    next.value = key;
                    next.done = false;
                    return next;
                  }
                }

                // To avoid creating an additional object, we just hang the .value
                // and .done properties off the next function object itself. This
                // also ensures that the minifier will not anonymize the function.
                next.done = true;
                return next;
              };
            };

            function values(iterable) {
              if (iterable) {
                var iteratorMethod = iterable[iteratorSymbol];
                if (iteratorMethod) {
                  return iteratorMethod.call(iterable);
                }

                if (typeof iterable.next === 'function') {
                  return iterable;
                }

                if (!isNaN(iterable.length)) {
                  var i = -1,
                    next = function next() {
                      while (++i < iterable.length) {
                        if (hasOwn.call(iterable, i)) {
                          next.value = iterable[i];
                          next.done = false;
                          return next;
                        }
                      }

                      next.value = undefined;
                      next.done = true;

                      return next;
                    };

                  return (next.next = next);
                }
              }

              // Return an iterator with no values.
              return { next: doneResult };
            }
            exports.values = values;

            function doneResult() {
              return { value: undefined, done: true };
            }

            Context.prototype = {
              constructor: Context,

              reset: function (skipTempReset) {
                this.prev = 0;
                this.next = 0;
                // Resetting context._sent for legacy support of Babel's
                // function.sent implementation.
                this.sent = this._sent = undefined;
                this.done = false;
                this.delegate = null;

                this.method = 'next';
                this.arg = undefined;

                this.tryEntries.forEach(resetTryEntry);

                if (!skipTempReset) {
                  for (var name in this) {
                    // Not sure about the optimal order of these conditions:
                    if (
                      name.charAt(0) === 't' &&
                      hasOwn.call(this, name) &&
                      !isNaN(+name.slice(1))
                    ) {
                      this[name] = undefined;
                    }
                  }
                }
              },

              stop: function () {
                this.done = true;

                var rootEntry = this.tryEntries[0];
                var rootRecord = rootEntry.completion;
                if (rootRecord.type === 'throw') {
                  throw rootRecord.arg;
                }

                return this.rval;
              },

              dispatchException: function (exception) {
                if (this.done) {
                  throw exception;
                }

                var context = this;
                function handle(loc, caught) {
                  record.type = 'throw';
                  record.arg = exception;
                  context.next = loc;

                  if (caught) {
                    // If the dispatched exception was caught by a catch block,
                    // then let that catch block handle the exception normally.
                    context.method = 'next';
                    context.arg = undefined;
                  }

                  return !!caught;
                }

                for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                  var entry = this.tryEntries[i];
                  var record = entry.completion;

                  if (entry.tryLoc === 'root') {
                    // Exception thrown outside of any try block that could handle
                    // it, so set the completion value of the entire function to
                    // throw the exception.
                    return handle('end');
                  }

                  if (entry.tryLoc <= this.prev) {
                    var hasCatch = hasOwn.call(entry, 'catchLoc');
                    var hasFinally = hasOwn.call(entry, 'finallyLoc');

                    if (hasCatch && hasFinally) {
                      if (this.prev < entry.catchLoc) {
                        return handle(entry.catchLoc, true);
                      } else if (this.prev < entry.finallyLoc) {
                        return handle(entry.finallyLoc);
                      }
                    } else if (hasCatch) {
                      if (this.prev < entry.catchLoc) {
                        return handle(entry.catchLoc, true);
                      }
                    } else if (hasFinally) {
                      if (this.prev < entry.finallyLoc) {
                        return handle(entry.finallyLoc);
                      }
                    } else {
                      throw new Error('try statement without catch or finally');
                    }
                  }
                }
              },

              abrupt: function (type, arg) {
                for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                  var entry = this.tryEntries[i];
                  if (
                    entry.tryLoc <= this.prev &&
                    hasOwn.call(entry, 'finallyLoc') &&
                    this.prev < entry.finallyLoc
                  ) {
                    var finallyEntry = entry;
                    break;
                  }
                }

                if (
                  finallyEntry &&
                  (type === 'break' || type === 'continue') &&
                  finallyEntry.tryLoc <= arg &&
                  arg <= finallyEntry.finallyLoc
                ) {
                  // Ignore the finally entry if control is not jumping to a
                  // location outside the try/catch block.
                  finallyEntry = null;
                }

                var record = finallyEntry ? finallyEntry.completion : {};
                record.type = type;
                record.arg = arg;

                if (finallyEntry) {
                  this.method = 'next';
                  this.next = finallyEntry.finallyLoc;
                  return ContinueSentinel;
                }

                return this.complete(record);
              },

              complete: function (record, afterLoc) {
                if (record.type === 'throw') {
                  throw record.arg;
                }

                if (record.type === 'break' || record.type === 'continue') {
                  this.next = record.arg;
                } else if (record.type === 'return') {
                  this.rval = this.arg = record.arg;
                  this.method = 'return';
                  this.next = 'end';
                } else if (record.type === 'normal' && afterLoc) {
                  this.next = afterLoc;
                }

                return ContinueSentinel;
              },

              finish: function (finallyLoc) {
                for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                  var entry = this.tryEntries[i];
                  if (entry.finallyLoc === finallyLoc) {
                    this.complete(entry.completion, entry.afterLoc);
                    resetTryEntry(entry);
                    return ContinueSentinel;
                  }
                }
              },

              catch: function (tryLoc) {
                for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                  var entry = this.tryEntries[i];
                  if (entry.tryLoc === tryLoc) {
                    var record = entry.completion;
                    if (record.type === 'throw') {
                      var thrown = record.arg;
                      resetTryEntry(entry);
                    }
                    return thrown;
                  }
                }

                // The context.catch method must only be called with a location
                // argument that corresponds to a known catch block.
                throw new Error('illegal catch attempt');
              },

              delegateYield: function (iterable, resultName, nextLoc) {
                this.delegate = {
                  iterator: values(iterable),
                  resultName: resultName,
                  nextLoc: nextLoc,
                };

                if (this.method === 'next') {
                  // Deliberately forget the last sent value so that we don't
                  // accidentally pass it on to the delegate.
                  this.arg = undefined;
                }

                return ContinueSentinel;
              },
            };

            // Regardless of whether this script is executing as a CommonJS module
            // or not, return the runtime object so that we can declare the variable
            // regeneratorRuntime in the outer scope, which allows this module to be
            // injected easily by `bin/regenerator --include-runtime script.js`.
            return exports;
          })(
            // If this script is executing as a CommonJS module, use module.exports
            // as the regeneratorRuntime namespace. Otherwise create a new empty
            // object. Either way, the resulting object will be used to initialize
            // the regeneratorRuntime variable at the top of this file.
            true ? module.exports : undefined
          );

          try {
            regeneratorRuntime = runtime;
          } catch (accidentalStrictMode) {
            // This module should not be running in strict mode, so the above
            // assignment should always work unless something is misconfigured. Just
            // in case runtime.js accidentally runs in strict mode, in modern engines
            // we can explicitly access globalThis. In older engines we can escape
            // strict mode using a global Function call. This could conceivably fail
            // if a Content Security Policy forbids using Function, but in that case
            // the proper solution is to fix the accidental strict mode problem. If
            // you've misconfigured your bundler to force strict mode and applied a
            // CSP to forbid Function, and you're not willing to fix either of those
            // problems, please detail your unique predicament in a GitHub issue.
            if (typeof globalThis === 'object') {
              globalThis.regeneratorRuntime = runtime;
            } else {
              Function('r', 'regeneratorRuntime = r')(runtime);
            }
          }

          /***/
        },

        /***/ '990b': /***/ function (module, exports, __webpack_require__) {
          // all object keys, includes non-enumerable and symbols
          var gOPN = __webpack_require__('9093');
          var gOPS = __webpack_require__('2621');
          var anObject = __webpack_require__('cb7c');
          var Reflect = __webpack_require__('7726').Reflect;
          module.exports =
            (Reflect && Reflect.ownKeys) ||
            function ownKeys(it) {
              var keys = gOPN.f(anObject(it));
              var getSymbols = gOPS.f;
              return getSymbols ? keys.concat(getSymbols(it)) : keys;
            };

          /***/
        },

        /***/ '9aa9': /***/ function (module, exports) {
          exports.f = Object.getOwnPropertySymbols;

          /***/
        },

        /***/ '9b43': /***/ function (module, exports, __webpack_require__) {
          // optional / simple context binding
          var aFunction = __webpack_require__('d8e8');
          module.exports = function (fn, that, length) {
            aFunction(fn);
            if (that === undefined) return fn;
            switch (length) {
              case 1:
                return function (a) {
                  return fn.call(that, a);
                };
              case 2:
                return function (a, b) {
                  return fn.call(that, a, b);
                };
              case 3:
                return function (a, b, c) {
                  return fn.call(that, a, b, c);
                };
            }
            return function (/* ...args */) {
              return fn.apply(that, arguments);
            };
          };

          /***/
        },

        /***/ '9c6c': /***/ function (module, exports, __webpack_require__) {
          // 22.1.3.31 Array.prototype[@@unscopables]
          var UNSCOPABLES = __webpack_require__('2b4c')('unscopables');
          var ArrayProto = Array.prototype;
          if (ArrayProto[UNSCOPABLES] == undefined)
            __webpack_require__('32e9')(ArrayProto, UNSCOPABLES, {});
          module.exports = function (key) {
            ArrayProto[UNSCOPABLES][key] = true;
          };

          /***/
        },

        /***/ '9def': /***/ function (module, exports, __webpack_require__) {
          // 7.1.15 ToLength
          var toInteger = __webpack_require__('4588');
          var min = Math.min;
          module.exports = function (it) {
            return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
          };

          /***/
        },

        /***/ '9e1e': /***/ function (module, exports, __webpack_require__) {
          // Thank's IE8 for his funny defineProperty
          module.exports = !__webpack_require__('79e5')(function () {
            return (
              Object.defineProperty({}, 'a', {
                get: function () {
                  return 7;
                },
              }).a != 7
            );
          });

          /***/
        },

        /***/ a159: /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
          var anObject = __webpack_require__('e4ae');
          var dPs = __webpack_require__('7e90');
          var enumBugKeys = __webpack_require__('1691');
          var IE_PROTO = __webpack_require__('5559')('IE_PROTO');
          var Empty = function () {
            /* empty */
          };
          var PROTOTYPE = 'prototype';

          // Create object with fake `null` prototype: use iframe Object with cleared prototype
          var createDict = function () {
            // Thrash, waste and sodomy: IE GC bug
            var iframe = __webpack_require__('1ec9')('iframe');
            var i = enumBugKeys.length;
            var lt = '<';
            var gt = '>';
            var iframeDocument;
            iframe.style.display = 'none';
            __webpack_require__('32fc').appendChild(iframe);
            iframe.src = 'javascript:'; // eslint-disable-line no-script-url
            // createDict = iframe.contentWindow.Object;
            // html.removeChild(iframe);
            iframeDocument = iframe.contentWindow.document;
            iframeDocument.open();
            iframeDocument.write(
              lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt
            );
            iframeDocument.close();
            createDict = iframeDocument.F;
            while (i--) delete createDict[PROTOTYPE][enumBugKeys[i]];
            return createDict();
          };

          module.exports =
            Object.create ||
            function create(O, Properties) {
              var result;
              if (O !== null) {
                Empty[PROTOTYPE] = anObject(O);
                result = new Empty();
                Empty[PROTOTYPE] = null;
                // add "__proto__" for Object.getPrototypeOf polyfill
                result[IE_PROTO] = O;
              } else result = createDict();
              return Properties === undefined
                ? result
                : dPs(result, Properties);
            };

          /***/
        },

        /***/ a22a: /***/ function (module, exports, __webpack_require__) {
          var ctx = __webpack_require__('d864');
          var call = __webpack_require__('b0dc');
          var isArrayIter = __webpack_require__('3702');
          var anObject = __webpack_require__('e4ae');
          var toLength = __webpack_require__('b447');
          var getIterFn = __webpack_require__('7cd6');
          var BREAK = {};
          var RETURN = {};
          var exports = (module.exports = function (
            iterable,
            entries,
            fn,
            that,
            ITERATOR
          ) {
            var iterFn = ITERATOR
              ? function () {
                  return iterable;
                }
              : getIterFn(iterable);
            var f = ctx(fn, that, entries ? 2 : 1);
            var index = 0;
            var length, step, iterator, result;
            if (typeof iterFn != 'function')
              throw TypeError(iterable + ' is not iterable!');
            // fast case for arrays with default iterator
            if (isArrayIter(iterFn))
              for (
                length = toLength(iterable.length);
                length > index;
                index++
              ) {
                result = entries
                  ? f(anObject((step = iterable[index]))[0], step[1])
                  : f(iterable[index]);
                if (result === BREAK || result === RETURN) return result;
              }
            else
              for (
                iterator = iterFn.call(iterable);
                !(step = iterator.next()).done;

              ) {
                result = call(iterator, f, step.value, entries);
                if (result === BREAK || result === RETURN) return result;
              }
          });
          exports.BREAK = BREAK;
          exports.RETURN = RETURN;

          /***/
        },

        /***/ a745: /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('f410');

          /***/
        },

        /***/ aa77: /***/ function (module, exports, __webpack_require__) {
          var $export = __webpack_require__('5ca1');
          var defined = __webpack_require__('be13');
          var fails = __webpack_require__('79e5');
          var spaces = __webpack_require__('fdef');
          var space = '[' + spaces + ']';
          var non = '\u200b\u0085';
          var ltrim = RegExp('^' + space + space + '*');
          var rtrim = RegExp(space + space + '*$');

          var exporter = function (KEY, exec, ALIAS) {
            var exp = {};
            var FORCE = fails(function () {
              return !!spaces[KEY]() || non[KEY]() != non;
            });
            var fn = (exp[KEY] = FORCE ? exec(trim) : spaces[KEY]);
            if (ALIAS) exp[ALIAS] = fn;
            $export($export.P + $export.F * FORCE, 'String', exp);
          };

          // 1 -> String#trimLeft
          // 2 -> String#trimRight
          // 3 -> String#trim
          var trim = (exporter.trim = function (string, TYPE) {
            string = String(defined(string));
            if (TYPE & 1) string = string.replace(ltrim, '');
            if (TYPE & 2) string = string.replace(rtrim, '');
            return string;
          });

          module.exports = exporter;

          /***/
        },

        /***/ aae3: /***/ function (module, exports, __webpack_require__) {
          // 7.2.8 IsRegExp(argument)
          var isObject = __webpack_require__('d3f4');
          var cof = __webpack_require__('2d95');
          var MATCH = __webpack_require__('2b4c')('match');
          module.exports = function (it) {
            var isRegExp;
            return (
              isObject(it) &&
              ((isRegExp = it[MATCH]) !== undefined
                ? !!isRegExp
                : cof(it) == 'RegExp')
            );
          };

          /***/
        },

        /***/ aba2: /***/ function (module, exports, __webpack_require__) {
          var global = __webpack_require__('e53d');
          var macrotask = __webpack_require__('4178').set;
          var Observer =
            global.MutationObserver || global.WebKitMutationObserver;
          var process = global.process;
          var Promise = global.Promise;
          var isNode = __webpack_require__('6b4c')(process) == 'process';

          module.exports = function () {
            var head, last, notify;

            var flush = function () {
              var parent, fn;
              if (isNode && (parent = process.domain)) parent.exit();
              while (head) {
                fn = head.fn;
                head = head.next;
                try {
                  fn();
                } catch (e) {
                  if (head) notify();
                  else last = undefined;
                  throw e;
                }
              }
              last = undefined;
              if (parent) parent.enter();
            };

            // Node.js
            if (isNode) {
              notify = function () {
                process.nextTick(flush);
              };
              // browsers with MutationObserver, except iOS Safari - https://github.com/zloirock/core-js/issues/339
            } else if (
              Observer &&
              !(global.navigator && global.navigator.standalone)
            ) {
              var toggle = true;
              var node = document.createTextNode('');
              new Observer(flush).observe(node, { characterData: true }); // eslint-disable-line no-new
              notify = function () {
                node.data = toggle = !toggle;
              };
              // environments with maybe non-completely correct, but existent Promise
            } else if (Promise && Promise.resolve) {
              // Promise.resolve without an argument throws an error in LG WebOS 2
              var promise = Promise.resolve(undefined);
              notify = function () {
                promise.then(flush);
              };
              // for other environments - macrotask based on:
              // - setImmediate
              // - MessageChannel
              // - window.postMessag
              // - onreadystatechange
              // - setTimeout
            } else {
              notify = function () {
                // strange IE + webpack dev server bug - use .call(global)
                macrotask.call(global, flush);
              };
            }

            return function (fn) {
              var task = { fn: fn, next: undefined };
              if (last) last.next = task;
              if (!head) {
                head = task;
                notify();
              }
              last = task;
            };
          };

          /***/
        },

        /***/ ac6a: /***/ function (module, exports, __webpack_require__) {
          var $iterators = __webpack_require__('cadf');
          var getKeys = __webpack_require__('0d58');
          var redefine = __webpack_require__('2aba');
          var global = __webpack_require__('7726');
          var hide = __webpack_require__('32e9');
          var Iterators = __webpack_require__('84f2');
          var wks = __webpack_require__('2b4c');
          var ITERATOR = wks('iterator');
          var TO_STRING_TAG = wks('toStringTag');
          var ArrayValues = Iterators.Array;

          var DOMIterables = {
            CSSRuleList: true, // TODO: Not spec compliant, should be false.
            CSSStyleDeclaration: false,
            CSSValueList: false,
            ClientRectList: false,
            DOMRectList: false,
            DOMStringList: false,
            DOMTokenList: true,
            DataTransferItemList: false,
            FileList: false,
            HTMLAllCollection: false,
            HTMLCollection: false,
            HTMLFormElement: false,
            HTMLSelectElement: false,
            MediaList: true, // TODO: Not spec compliant, should be false.
            MimeTypeArray: false,
            NamedNodeMap: false,
            NodeList: true,
            PaintRequestList: false,
            Plugin: false,
            PluginArray: false,
            SVGLengthList: false,
            SVGNumberList: false,
            SVGPathSegList: false,
            SVGPointList: false,
            SVGStringList: false,
            SVGTransformList: false,
            SourceBufferList: false,
            StyleSheetList: true, // TODO: Not spec compliant, should be false.
            TextTrackCueList: false,
            TextTrackList: false,
            TouchList: false,
          };

          for (
            var collections = getKeys(DOMIterables), i = 0;
            i < collections.length;
            i++
          ) {
            var NAME = collections[i];
            var explicit = DOMIterables[NAME];
            var Collection = global[NAME];
            var proto = Collection && Collection.prototype;
            var key;
            if (proto) {
              if (!proto[ITERATOR]) hide(proto, ITERATOR, ArrayValues);
              if (!proto[TO_STRING_TAG]) hide(proto, TO_STRING_TAG, NAME);
              Iterators[NAME] = ArrayValues;
              if (explicit)
                for (key in $iterators)
                  if (!proto[key]) redefine(proto, key, $iterators[key], true);
            }
          }

          /***/
        },

        /***/ aebd: /***/ function (module, exports) {
          module.exports = function (bitmap, value) {
            return {
              enumerable: !(bitmap & 1),
              configurable: !(bitmap & 2),
              writable: !(bitmap & 4),
              value: value,
            };
          };

          /***/
        },

        /***/ b0dc: /***/ function (module, exports, __webpack_require__) {
          // call something on iterator step with safe closing on error
          var anObject = __webpack_require__('e4ae');
          module.exports = function (iterator, fn, value, entries) {
            try {
              return entries ? fn(anObject(value)[0], value[1]) : fn(value);
              // 7.4.6 IteratorClose(iterator, completion)
            } catch (e) {
              var ret = iterator['return'];
              if (ret !== undefined) anObject(ret.call(iterator));
              throw e;
            }
          };

          /***/
        },

        /***/ b447: /***/ function (module, exports, __webpack_require__) {
          // 7.1.15 ToLength
          var toInteger = __webpack_require__('3a38');
          var min = Math.min;
          module.exports = function (it) {
            return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
          };

          /***/
        },

        /***/ b8e3: /***/ function (module, exports) {
          module.exports = true;

          /***/
        },

        /***/ bc13: /***/ function (module, exports, __webpack_require__) {
          var global = __webpack_require__('e53d');
          var navigator = global.navigator;

          module.exports = (navigator && navigator.userAgent) || '';

          /***/
        },

        /***/ be13: /***/ function (module, exports) {
          // 7.2.1 RequireObjectCoercible(argument)
          module.exports = function (it) {
            if (it == undefined) throw TypeError("Can't call method on  " + it);
            return it;
          };

          /***/
        },

        /***/ bf0b: /***/ function (module, exports, __webpack_require__) {
          var pIE = __webpack_require__('355d');
          var createDesc = __webpack_require__('aebd');
          var toIObject = __webpack_require__('36c3');
          var toPrimitive = __webpack_require__('1bc3');
          var has = __webpack_require__('07e3');
          var IE8_DOM_DEFINE = __webpack_require__('794b');
          var gOPD = Object.getOwnPropertyDescriptor;

          exports.f = __webpack_require__('8e60')
            ? gOPD
            : function getOwnPropertyDescriptor(O, P) {
                O = toIObject(O);
                P = toPrimitive(P, true);
                if (IE8_DOM_DEFINE)
                  try {
                    return gOPD(O, P);
                  } catch (e) {
                    /* empty */
                  }
                if (has(O, P)) return createDesc(!pIE.f.call(O, P), O[P]);
              };

          /***/
        },

        /***/ c207: /***/ function (module, exports) {
          /***/
        },

        /***/ c366: /***/ function (module, exports, __webpack_require__) {
          // false -> Array#indexOf
          // true  -> Array#includes
          var toIObject = __webpack_require__('6821');
          var toLength = __webpack_require__('9def');
          var toAbsoluteIndex = __webpack_require__('77f1');
          module.exports = function (IS_INCLUDES) {
            return function ($this, el, fromIndex) {
              var O = toIObject($this);
              var length = toLength(O.length);
              var index = toAbsoluteIndex(fromIndex, length);
              var value;
              // Array#includes uses SameValueZero equality algorithm
              // eslint-disable-next-line no-self-compare
              if (IS_INCLUDES && el != el)
                while (length > index) {
                  value = O[index++];
                  // eslint-disable-next-line no-self-compare
                  if (value != value) return true;
                  // Array#indexOf ignores holes, Array#includes - not
                }
              else
                for (; length > index; index++)
                  if (IS_INCLUDES || index in O) {
                    if (O[index] === el) return IS_INCLUDES || index || 0;
                  }
              return !IS_INCLUDES && -1;
            };
          };

          /***/
        },

        /***/ c367: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var addToUnscopables = __webpack_require__('8436');
          var step = __webpack_require__('50ed');
          var Iterators = __webpack_require__('481b');
          var toIObject = __webpack_require__('36c3');

          // 22.1.3.4 Array.prototype.entries()
          // 22.1.3.13 Array.prototype.keys()
          // 22.1.3.29 Array.prototype.values()
          // 22.1.3.30 Array.prototype[@@iterator]()
          module.exports = __webpack_require__('30f1')(
            Array,
            'Array',
            function (iterated, kind) {
              this._t = toIObject(iterated); // target
              this._i = 0; // next index
              this._k = kind; // kind
              // 22.1.5.2.1 %ArrayIteratorPrototype%.next()
            },
            function () {
              var O = this._t;
              var kind = this._k;
              var index = this._i++;
              if (!O || index >= O.length) {
                this._t = undefined;
                return step(1);
              }
              if (kind == 'keys') return step(0, index);
              if (kind == 'values') return step(0, O[index]);
              return step(0, [index, O[index]]);
            },
            'values'
          );

          // argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
          Iterators.Arguments = Iterators.Array;

          addToUnscopables('keys');
          addToUnscopables('values');
          addToUnscopables('entries');

          /***/
        },

        /***/ c3a1: /***/ function (module, exports, __webpack_require__) {
          // 19.1.2.14 / 15.2.3.14 Object.keys(O)
          var $keys = __webpack_require__('e6f3');
          var enumBugKeys = __webpack_require__('1691');

          module.exports =
            Object.keys ||
            function keys(O) {
              return $keys(O, enumBugKeys);
            };

          /***/
        },

        /***/ c3b0: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var __importDefault =
            (this && this.__importDefault) ||
            function (mod) {
              return mod && mod.__esModule ? mod : { default: mod };
            };
          Object.defineProperty(exports, '__esModule', { value: true });
          const _constantes_1 = __importDefault(__webpack_require__('0750'));
          exports.default = (color) => {
            if (!color)
              throw new Error('color-name-to-hex: No color name provided');
            const colorFound = _constantes_1.default[color.toLowerCase()];
            if (typeof colorFound !== 'undefined') return colorFound;
            throw new Error(`No hex found for ${color}`);
          };
          //# sourceMappingURL=index.js.map

          /***/
        },

        /***/ c50b: /***/ function (module, exports, __webpack_require__) {
          // extracted by mini-css-extract-plugin
          /***/
        },

        /***/ c5f6: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var global = __webpack_require__('7726');
          var has = __webpack_require__('69a8');
          var cof = __webpack_require__('2d95');
          var inheritIfRequired = __webpack_require__('5dbc');
          var toPrimitive = __webpack_require__('6a99');
          var fails = __webpack_require__('79e5');
          var gOPN = __webpack_require__('9093').f;
          var gOPD = __webpack_require__('11e9').f;
          var dP = __webpack_require__('86cc').f;
          var $trim = __webpack_require__('aa77').trim;
          var NUMBER = 'Number';
          var $Number = global[NUMBER];
          var Base = $Number;
          var proto = $Number.prototype;
          // Opera ~12 has broken Object#toString
          var BROKEN_COF = cof(__webpack_require__('2aeb')(proto)) == NUMBER;
          var TRIM = 'trim' in String.prototype;

          // 7.1.3 ToNumber(argument)
          var toNumber = function (argument) {
            var it = toPrimitive(argument, false);
            if (typeof it == 'string' && it.length > 2) {
              it = TRIM ? it.trim() : $trim(it, 3);
              var first = it.charCodeAt(0);
              var third, radix, maxCode;
              if (first === 43 || first === 45) {
                third = it.charCodeAt(2);
                if (third === 88 || third === 120) return NaN; // Number('+0x1') should be NaN, old V8 fix
              } else if (first === 48) {
                switch (it.charCodeAt(1)) {
                  case 66:
                  case 98:
                    radix = 2;
                    maxCode = 49;
                    break; // fast equal /^0b[01]+$/i
                  case 79:
                  case 111:
                    radix = 8;
                    maxCode = 55;
                    break; // fast equal /^0o[0-7]+$/i
                  default:
                    return +it;
                }
                for (
                  var digits = it.slice(2), i = 0, l = digits.length, code;
                  i < l;
                  i++
                ) {
                  code = digits.charCodeAt(i);
                  // parseInt parses a string to a first unavailable symbol
                  // but ToNumber should return NaN if a string contains unavailable symbols
                  if (code < 48 || code > maxCode) return NaN;
                }
                return parseInt(digits, radix);
              }
            }
            return +it;
          };

          if (!$Number(' 0o1') || !$Number('0b1') || $Number('+0x1')) {
            $Number = function Number(value) {
              var it = arguments.length < 1 ? 0 : value;
              var that = this;
              return that instanceof $Number &&
                // check on 1..constructor(foo) case
                (BROKEN_COF
                  ? fails(function () {
                      proto.valueOf.call(that);
                    })
                  : cof(that) != NUMBER)
                ? inheritIfRequired(new Base(toNumber(it)), that, $Number)
                : toNumber(it);
            };
            for (
              var keys = __webpack_require__('9e1e')
                  ? gOPN(Base)
                  : // ES3:
                    (
                      'MAX_VALUE,MIN_VALUE,NaN,NEGATIVE_INFINITY,POSITIVE_INFINITY,' +
                      // ES6 (in case, if modules with ES6 Number statics required before):
                      'EPSILON,isFinite,isInteger,isNaN,isSafeInteger,MAX_SAFE_INTEGER,' +
                      'MIN_SAFE_INTEGER,parseFloat,parseInt,isInteger'
                    ).split(','),
                j = 0,
                key;
              keys.length > j;
              j++
            ) {
              if (has(Base, (key = keys[j])) && !has($Number, key)) {
                dP($Number, key, gOPD(Base, key));
              }
            }
            $Number.prototype = proto;
            proto.constructor = $Number;
            __webpack_require__('2aba')(global, NUMBER, $Number);
          }

          /***/
        },

        /***/ c69a: /***/ function (module, exports, __webpack_require__) {
          module.exports =
            !__webpack_require__('9e1e') &&
            !__webpack_require__('79e5')(function () {
              return (
                Object.defineProperty(__webpack_require__('230e')('div'), 'a', {
                  get: function () {
                    return 7;
                  },
                }).a != 7
              );
            });

          /***/
        },

        /***/ c8ba: /***/ function (module, exports) {
          var g;

          // This works in non-strict mode
          g = (function () {
            return this;
          })();

          try {
            // This works if eval is allowed (see CSP)
            g = g || new Function('return this')();
          } catch (e) {
            // This works if the window reference is available
            if (typeof window === 'object') g = window;
          }

          // g can still be undefined, but nothing to do about it...
          // We return undefined, instead of nothing here, so it's
          // easier to handle this case. if(!global) { ...}

          module.exports = g;

          /***/
        },

        /***/ c8bb: /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('54a1');

          /***/
        },

        /***/ ca5a: /***/ function (module, exports) {
          var id = 0;
          var px = Math.random();
          module.exports = function (key) {
            return 'Symbol('.concat(
              key === undefined ? '' : key,
              ')_',
              (++id + px).toString(36)
            );
          };

          /***/
        },

        /***/ cadf: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var addToUnscopables = __webpack_require__('9c6c');
          var step = __webpack_require__('d53b');
          var Iterators = __webpack_require__('84f2');
          var toIObject = __webpack_require__('6821');

          // 22.1.3.4 Array.prototype.entries()
          // 22.1.3.13 Array.prototype.keys()
          // 22.1.3.29 Array.prototype.values()
          // 22.1.3.30 Array.prototype[@@iterator]()
          module.exports = __webpack_require__('01f9')(
            Array,
            'Array',
            function (iterated, kind) {
              this._t = toIObject(iterated); // target
              this._i = 0; // next index
              this._k = kind; // kind
              // 22.1.5.2.1 %ArrayIteratorPrototype%.next()
            },
            function () {
              var O = this._t;
              var kind = this._k;
              var index = this._i++;
              if (!O || index >= O.length) {
                this._t = undefined;
                return step(1);
              }
              if (kind == 'keys') return step(0, index);
              if (kind == 'values') return step(0, O[index]);
              return step(0, [index, O[index]]);
            },
            'values'
          );

          // argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
          Iterators.Arguments = Iterators.Array;

          addToUnscopables('keys');
          addToUnscopables('values');
          addToUnscopables('entries');

          /***/
        },

        /***/ cb7c: /***/ function (module, exports, __webpack_require__) {
          var isObject = __webpack_require__('d3f4');
          module.exports = function (it) {
            if (!isObject(it)) throw TypeError(it + ' is not an object!');
            return it;
          };

          /***/
        },

        /***/ ccb9: /***/ function (module, exports, __webpack_require__) {
          exports.f = __webpack_require__('5168');

          /***/
        },

        /***/ cd1c: /***/ function (module, exports, __webpack_require__) {
          // 9.4.2.3 ArraySpeciesCreate(originalArray, length)
          var speciesConstructor = __webpack_require__('e853');

          module.exports = function (original, length) {
            return new (speciesConstructor(original))(length);
          };

          /***/
        },

        /***/ cd78: /***/ function (module, exports, __webpack_require__) {
          var anObject = __webpack_require__('e4ae');
          var isObject = __webpack_require__('f772');
          var newPromiseCapability = __webpack_require__('656e');

          module.exports = function (C, x) {
            anObject(C);
            if (isObject(x) && x.constructor === C) return x;
            var promiseCapability = newPromiseCapability.f(C);
            var resolve = promiseCapability.resolve;
            resolve(x);
            return promiseCapability.promise;
          };

          /***/
        },

        /***/ ce10: /***/ function (module, exports, __webpack_require__) {
          var has = __webpack_require__('69a8');
          var toIObject = __webpack_require__('6821');
          var arrayIndexOf = __webpack_require__('c366')(false);
          var IE_PROTO = __webpack_require__('613b')('IE_PROTO');

          module.exports = function (object, names) {
            var O = toIObject(object);
            var i = 0;
            var result = [];
            var key;
            for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
            // Don't enum bug & hidden keys
            while (names.length > i)
              if (has(O, (key = names[i++]))) {
                ~arrayIndexOf(result, key) || result.push(key);
              }
            return result;
          };

          /***/
        },

        /***/ d2c8: /***/ function (module, exports, __webpack_require__) {
          // helper for String#{startsWith, endsWith, includes}
          var isRegExp = __webpack_require__('aae3');
          var defined = __webpack_require__('be13');

          module.exports = function (that, searchString, NAME) {
            if (isRegExp(searchString))
              throw TypeError('String#' + NAME + " doesn't accept regex!");
            return String(defined(that));
          };

          /***/
        },

        /***/ d2d5: /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('1654');
          __webpack_require__('549b');
          module.exports = __webpack_require__('584a').Array.from;

          /***/
        },

        /***/ d391: /***/ function (module) {
          module.exports = JSON.parse(
            '{"AC":"40123","AD":"312345","AE":"501234567","AF":"701234567","AG":"2684641234","AI":"2642351234","AL":"672123456","AM":"77123456","AO":"923123456","AR":"91123456789","AS":"6847331234","AT":"664123456","AU":"412345678","AW":"5601234","AX":"412345678","AZ":"401234567","BA":"61123456","BB":"2462501234","BD":"1812345678","BE":"470123456","BF":"70123456","BG":"43012345","BH":"36001234","BI":"79561234","BJ":"90011234","BL":"690001234","BM":"4413701234","BN":"7123456","BO":"71234567","BQ":"3181234","BR":"11961234567","BS":"2423591234","BT":"17123456","BW":"71123456","BY":"294911911","BZ":"6221234","CA":"5062345678","CC":"412345678","CD":"991234567","CF":"70012345","CG":"061234567","CH":"781234567","CI":"0123456789","CK":"71234","CL":"221234567","CM":"671234567","CN":"13123456789","CO":"3211234567","CR":"83123456","CU":"51234567","CV":"9911234","CW":"95181234","CX":"412345678","CY":"96123456","CZ":"601123456","DE":"15123456789","DJ":"77831001","DK":"32123456","DM":"7672251234","DO":"8092345678","DZ":"551234567","EC":"991234567","EE":"51234567","EG":"1001234567","EH":"650123456","ER":"7123456","ES":"612345678","ET":"911234567","FI":"412345678","FJ":"7012345","FK":"51234","FM":"3501234","FO":"211234","FR":"612345678","GA":"06031234","GB":"7400123456","GD":"4734031234","GE":"555123456","GF":"694201234","GG":"7781123456","GH":"231234567","GI":"57123456","GL":"221234","GM":"3012345","GN":"601123456","GP":"690001234","GQ":"222123456","GR":"6912345678","GT":"51234567","GU":"6713001234","GW":"955012345","GY":"6091234","HK":"51234567","HN":"91234567","HR":"921234567","HT":"34101234","HU":"201234567","ID":"812345678","IE":"850123456","IL":"502345678","IM":"7924123456","IN":"8123456789","IO":"3801234","IQ":"7912345678","IR":"9123456789","IS":"6111234","IT":"3123456789","JE":"7797712345","JM":"8762101234","JO":"790123456","JP":"9012345678","KE":"712123456","KG":"700123456","KH":"91234567","KI":"72001234","KM":"3212345","KN":"8697652917","KP":"1921234567","KR":"1020000000","KW":"50012345","KY":"3453231234","KZ":"7710009998","LA":"2023123456","LB":"71123456","LC":"7582845678","LI":"660234567","LK":"712345678","LR":"770123456","LS":"50123456","LT":"61234567","LU":"628123456","LV":"21234567","LY":"912345678","MA":"650123456","MC":"612345678","MD":"62112345","ME":"67622901","MF":"690001234","MG":"321234567","MH":"2351234","MK":"72345678","ML":"65012345","MM":"92123456","MN":"88123456","MO":"66123456","MP":"6702345678","MQ":"696201234","MR":"22123456","MS":"6644923456","MT":"96961234","MU":"52512345","MV":"7712345","MW":"991234567","MX":"12221234567","MY":"123456789","MZ":"821234567","NA":"811234567","NC":"751234","NE":"93123456","NF":"381234","NG":"8021234567","NI":"81234567","NL":"612345678","NO":"40612345","NP":"9841234567","NR":"5551234","NU":"8884012","NZ":"211234567","OM":"92123456","PA":"61234567","PE":"912345678","PF":"87123456","PG":"70123456","PH":"9051234567","PK":"3012345678","PL":"512345678","PM":"551234","PR":"7872345678","PS":"599123456","PT":"912345678","PW":"6201234","PY":"961456789","QA":"33123456","RE":"692123456","RO":"712034567","RS":"601234567","RU":"9123456789","RW":"720123456","SA":"512345678","SB":"7421234","SC":"2510123","SD":"911231234","SE":"701234567","SG":"81234567","SH":"51234","SI":"31234567","SJ":"41234567","SK":"912123456","SL":"25123456","SM":"66661212","SN":"701234567","SO":"71123456","SR":"7412345","SS":"977123456","ST":"9812345","SV":"70123456","SX":"7215205678","SY":"944567890","SZ":"76123456","TA":"8999","TC":"6492311234","TD":"63012345","TG":"90112345","TH":"812345678","TJ":"917123456","TK":"7290","TL":"77212345","TM":"66123456","TN":"20123456","TO":"7715123","TR":"5012345678","TT":"8682911234","TV":"901234","TW":"912345678","TZ":"621234567","UA":"501234567","UG":"712345678","US":"2015550123","UY":"94231234","UZ":"912345678","VA":"3123456789","VC":"7844301234","VE":"4121234567","VG":"2843001234","VI":"3406421234","VN":"912345678","VU":"5912345","WF":"821234","WS":"7212345","XK":"43201234","YE":"712345678","YT":"639012345","ZA":"711234567","ZM":"955123456","ZW":"712345678"}'
          );

          /***/
        },

        /***/ d3f4: /***/ function (module, exports) {
          module.exports = function (it) {
            return typeof it === 'object'
              ? it !== null
              : typeof it === 'function';
          };

          /***/
        },

        /***/ d499: /***/ function (
          module,
          __webpack_exports__,
          __webpack_require__
        ) {
          'use strict';
          /* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_e59be3b4_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ =
            __webpack_require__('7f9a');
          /* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_e59be3b4_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default =
            /*#__PURE__*/ __webpack_require__.n(
              _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_e59be3b4_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__
            );
          /* unused harmony reexport * */

          /***/
        },

        /***/ d53b: /***/ function (module, exports) {
          module.exports = function (done, value) {
            return { value: value, done: !!done };
          };

          /***/
        },

        /***/ d864: /***/ function (module, exports, __webpack_require__) {
          // optional / simple context binding
          var aFunction = __webpack_require__('79aa');
          module.exports = function (fn, that, length) {
            aFunction(fn);
            if (that === undefined) return fn;
            switch (length) {
              case 1:
                return function (a) {
                  return fn.call(that, a);
                };
              case 2:
                return function (a, b) {
                  return fn.call(that, a, b);
                };
              case 3:
                return function (a, b, c) {
                  return fn.call(that, a, b, c);
                };
            }
            return function (/* ...args */) {
              return fn.apply(that, arguments);
            };
          };

          /***/
        },

        /***/ d8e8: /***/ function (module, exports) {
          module.exports = function (it) {
            if (typeof it != 'function')
              throw TypeError(it + ' is not a function!');
            return it;
          };

          /***/
        },

        /***/ d9f6: /***/ function (module, exports, __webpack_require__) {
          var anObject = __webpack_require__('e4ae');
          var IE8_DOM_DEFINE = __webpack_require__('794b');
          var toPrimitive = __webpack_require__('1bc3');
          var dP = Object.defineProperty;

          exports.f = __webpack_require__('8e60')
            ? Object.defineProperty
            : function defineProperty(O, P, Attributes) {
                anObject(O);
                P = toPrimitive(P, true);
                anObject(Attributes);
                if (IE8_DOM_DEFINE)
                  try {
                    return dP(O, P, Attributes);
                  } catch (e) {
                    /* empty */
                  }
                if ('get' in Attributes || 'set' in Attributes)
                  throw TypeError('Accessors not supported!');
                if ('value' in Attributes) O[P] = Attributes.value;
                return O;
              };

          /***/
        },

        /***/ db06: /***/ function (module, exports, __webpack_require__) {
          // extracted by mini-css-extract-plugin
          /***/
        },

        /***/ dbdb: /***/ function (module, exports, __webpack_require__) {
          var core = __webpack_require__('584a');
          var global = __webpack_require__('e53d');
          var SHARED = '__core-js_shared__';
          var store = global[SHARED] || (global[SHARED] = {});

          (module.exports = function (key, value) {
            return (
              store[key] || (store[key] = value !== undefined ? value : {})
            );
          })('versions', []).push({
            version: core.version,
            mode: __webpack_require__('b8e3') ? 'pure' : 'global',
            copyright: '© 2019 Denis Pushkarev (zloirock.ru)',
          });

          /***/
        },

        /***/ e11e: /***/ function (module, exports) {
          // IE 8- don't enum bug keys
          module.exports =
            'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'.split(
              ','
            );

          /***/
        },

        /***/ e214: /***/ function (
          module,
          __webpack_exports__,
          __webpack_require__
        ) {
          'use strict';
          /* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_19351537_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ =
            __webpack_require__('db06');
          /* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_19351537_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default =
            /*#__PURE__*/ __webpack_require__.n(
              _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_19351537_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__
            );
          /* unused harmony reexport * */

          /***/
        },

        /***/ e4ae: /***/ function (module, exports, __webpack_require__) {
          var isObject = __webpack_require__('f772');
          module.exports = function (it) {
            if (!isObject(it)) throw TypeError(it + ' is not an object!');
            return it;
          };

          /***/
        },

        /***/ e508: /***/ function (
          module,
          __webpack_exports__,
          __webpack_require__
        ) {
          'use strict';
          /* WEBPACK VAR INJECTION */ (function (global) {
            /* unused harmony export DynamicScroller */
            /* unused harmony export DynamicScrollerItem */
            /* unused harmony export IdState */
            /* harmony export (binding) */ __webpack_require__.d(
              __webpack_exports__,
              'a',
              function () {
                return __vue_component__;
              }
            );
            /* harmony import */ var vue_resize__WEBPACK_IMPORTED_MODULE_0__ =
              __webpack_require__('252c');
            /* harmony import */ var vue_observe_visibility__WEBPACK_IMPORTED_MODULE_1__ =
              __webpack_require__('85fe');
            /* harmony import */ var scrollparent__WEBPACK_IMPORTED_MODULE_2__ =
              __webpack_require__('ed83');
            /* harmony import */ var scrollparent__WEBPACK_IMPORTED_MODULE_2___default =
              /*#__PURE__*/ __webpack_require__.n(
                scrollparent__WEBPACK_IMPORTED_MODULE_2__
              );
            /* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_3__ =
              __webpack_require__('8bbf');
            /* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_3___default =
              /*#__PURE__*/ __webpack_require__.n(
                vue__WEBPACK_IMPORTED_MODULE_3__
              );

            var config = {
              itemsLimit: 1000,
            };

            function _typeof(obj) {
              '@babel/helpers - typeof';

              if (
                typeof Symbol === 'function' &&
                typeof Symbol.iterator === 'symbol'
              ) {
                _typeof = function (obj) {
                  return typeof obj;
                };
              } else {
                _typeof = function (obj) {
                  return obj &&
                    typeof Symbol === 'function' &&
                    obj.constructor === Symbol &&
                    obj !== Symbol.prototype
                    ? 'symbol'
                    : typeof obj;
                };
              }

              return _typeof(obj);
            }

            function _defineProperty(obj, key, value) {
              if (key in obj) {
                Object.defineProperty(obj, key, {
                  value: value,
                  enumerable: true,
                  configurable: true,
                  writable: true,
                });
              } else {
                obj[key] = value;
              }

              return obj;
            }

            function ownKeys(object, enumerableOnly) {
              var keys = Object.keys(object);

              if (Object.getOwnPropertySymbols) {
                var symbols = Object.getOwnPropertySymbols(object);
                if (enumerableOnly)
                  symbols = symbols.filter(function (sym) {
                    return Object.getOwnPropertyDescriptor(object, sym)
                      .enumerable;
                  });
                keys.push.apply(keys, symbols);
              }

              return keys;
            }

            function _objectSpread2(target) {
              for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i] != null ? arguments[i] : {};

                if (i % 2) {
                  ownKeys(Object(source), true).forEach(function (key) {
                    _defineProperty(target, key, source[key]);
                  });
                } else if (Object.getOwnPropertyDescriptors) {
                  Object.defineProperties(
                    target,
                    Object.getOwnPropertyDescriptors(source)
                  );
                } else {
                  ownKeys(Object(source)).forEach(function (key) {
                    Object.defineProperty(
                      target,
                      key,
                      Object.getOwnPropertyDescriptor(source, key)
                    );
                  });
                }
              }

              return target;
            }

            function _unsupportedIterableToArray(o, minLen) {
              if (!o) return;
              if (typeof o === 'string') return _arrayLikeToArray(o, minLen);
              var n = Object.prototype.toString.call(o).slice(8, -1);
              if (n === 'Object' && o.constructor) n = o.constructor.name;
              if (n === 'Map' || n === 'Set') return Array.from(n);
              if (
                n === 'Arguments' ||
                /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
              )
                return _arrayLikeToArray(o, minLen);
            }

            function _arrayLikeToArray(arr, len) {
              if (len == null || len > arr.length) len = arr.length;

              for (var i = 0, arr2 = new Array(len); i < len; i++)
                arr2[i] = arr[i];

              return arr2;
            }

            function _createForOfIteratorHelper(o) {
              if (typeof Symbol === 'undefined' || o[Symbol.iterator] == null) {
                if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) {
                  var i = 0;

                  var F = function () {};

                  return {
                    s: F,
                    n: function () {
                      if (i >= o.length)
                        return {
                          done: true,
                        };
                      return {
                        done: false,
                        value: o[i++],
                      };
                    },
                    e: function (e) {
                      throw e;
                    },
                    f: F,
                  };
                }

                throw new TypeError(
                  'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
                );
              }

              var it,
                normalCompletion = true,
                didErr = false,
                err;
              return {
                s: function () {
                  it = o[Symbol.iterator]();
                },
                n: function () {
                  var step = it.next();
                  normalCompletion = step.done;
                  return step;
                },
                e: function (e) {
                  didErr = true;
                  err = e;
                },
                f: function () {
                  try {
                    if (!normalCompletion && it.return != null) it.return();
                  } finally {
                    if (didErr) throw err;
                  }
                },
              };
            }

            var props = {
              items: {
                type: Array,
                required: true,
              },
              keyField: {
                type: String,
                default: 'id',
              },
              direction: {
                type: String,
                default: 'vertical',
                validator: function validator(value) {
                  return ['vertical', 'horizontal'].includes(value);
                },
              },
            };
            function simpleArray() {
              return this.items.length && _typeof(this.items[0]) !== 'object';
            }

            var supportsPassive = false;

            if (typeof window !== 'undefined') {
              supportsPassive = false;

              try {
                var opts = Object.defineProperty({}, 'passive', {
                  get: function get() {
                    supportsPassive = true;
                  },
                });
                window.addEventListener('test', null, opts);
              } catch (e) {}
            }

            var uid = 0;
            var script = {
              name: 'RecycleScroller',
              components: {
                ResizeObserver:
                  vue_resize__WEBPACK_IMPORTED_MODULE_0__[
                    /* ResizeObserver */ 'a'
                  ],
              },
              directives: {
                ObserveVisibility:
                  vue_observe_visibility__WEBPACK_IMPORTED_MODULE_1__[
                    /* ObserveVisibility */ 'a'
                  ],
              },
              props: _objectSpread2({}, props, {
                itemSize: {
                  type: Number,
                  default: null,
                },
                minItemSize: {
                  type: [Number, String],
                  default: null,
                },
                sizeField: {
                  type: String,
                  default: 'size',
                },
                typeField: {
                  type: String,
                  default: 'type',
                },
                buffer: {
                  type: Number,
                  default: 200,
                },
                pageMode: {
                  type: Boolean,
                  default: false,
                },
                prerender: {
                  type: Number,
                  default: 0,
                },
                emitUpdate: {
                  type: Boolean,
                  default: false,
                },
              }),
              data: function data() {
                return {
                  pool: [],
                  totalSize: 0,
                  ready: false,
                  hoverKey: null,
                };
              },
              computed: {
                sizes: function sizes() {
                  if (this.itemSize === null) {
                    var sizes = {
                      '-1': {
                        accumulator: 0,
                      },
                    };
                    var items = this.items;
                    var field = this.sizeField;
                    var minItemSize = this.minItemSize;
                    var computedMinSize = 10000;
                    var accumulator = 0;
                    var current;

                    for (var i = 0, l = items.length; i < l; i++) {
                      current = items[i][field] || minItemSize;

                      if (current < computedMinSize) {
                        computedMinSize = current;
                      }

                      accumulator += current;
                      sizes[i] = {
                        accumulator: accumulator,
                        size: current,
                      };
                    } // eslint-disable-next-line

                    this.$_computedMinItemSize = computedMinSize;
                    return sizes;
                  }

                  return [];
                },
                simpleArray: simpleArray,
              },
              watch: {
                items: function items() {
                  this.updateVisibleItems(true);
                },
                pageMode: function pageMode() {
                  this.applyPageMode();
                  this.updateVisibleItems(false);
                },
                sizes: {
                  handler: function handler() {
                    this.updateVisibleItems(false);
                  },
                  deep: true,
                },
              },
              created: function created() {
                this.$_startIndex = 0;
                this.$_endIndex = 0;
                this.$_views = new Map();
                this.$_unusedViews = new Map();
                this.$_scrollDirty = false;
                this.$_lastUpdateScrollPosition = 0; // In SSR mode, we also prerender the same number of item for the first render
                // to avoir mismatch between server and client templates

                if (this.prerender) {
                  this.$_prerender = true;
                  this.updateVisibleItems(false);
                }
              },
              mounted: function mounted() {
                var _this = this;

                this.applyPageMode();
                this.$nextTick(function () {
                  // In SSR mode, render the real number of visible items
                  _this.$_prerender = false;

                  _this.updateVisibleItems(true);

                  _this.ready = true;
                });
              },
              beforeDestroy: function beforeDestroy() {
                this.removeListeners();
              },
              methods: {
                addView: function addView(pool, index, item, key, type) {
                  var view = {
                    item: item,
                    position: 0,
                  };
                  var nonReactive = {
                    id: uid++,
                    index: index,
                    used: true,
                    key: key,
                    type: type,
                  };
                  Object.defineProperty(view, 'nr', {
                    configurable: false,
                    value: nonReactive,
                  });
                  pool.push(view);
                  return view;
                },
                unuseView: function unuseView(view) {
                  var fake =
                    arguments.length > 1 && arguments[1] !== undefined
                      ? arguments[1]
                      : false;
                  var unusedViews = this.$_unusedViews;
                  var type = view.nr.type;
                  var unusedPool = unusedViews.get(type);

                  if (!unusedPool) {
                    unusedPool = [];
                    unusedViews.set(type, unusedPool);
                  }

                  unusedPool.push(view);

                  if (!fake) {
                    view.nr.used = false;
                    view.position = -9999;
                    this.$_views.delete(view.nr.key);
                  }
                },
                handleResize: function handleResize() {
                  this.$emit('resize');
                  if (this.ready) this.updateVisibleItems(false);
                },
                handleScroll: function handleScroll(event) {
                  var _this2 = this;

                  if (!this.$_scrollDirty) {
                    this.$_scrollDirty = true;
                    requestAnimationFrame(function () {
                      _this2.$_scrollDirty = false;

                      var _this2$updateVisibleI = _this2.updateVisibleItems(
                          false,
                          true
                        ),
                        continuous = _this2$updateVisibleI.continuous; // It seems sometimes chrome doesn't fire scroll event :/
                      // When non continous scrolling is ending, we force a refresh

                      if (!continuous) {
                        clearTimeout(_this2.$_refreshTimout);
                        _this2.$_refreshTimout = setTimeout(
                          _this2.handleScroll,
                          100
                        );
                      }
                    });
                  }
                },
                handleVisibilityChange: function handleVisibilityChange(
                  isVisible,
                  entry
                ) {
                  var _this3 = this;

                  if (this.ready) {
                    if (
                      isVisible ||
                      entry.boundingClientRect.width !== 0 ||
                      entry.boundingClientRect.height !== 0
                    ) {
                      this.$emit('visible');
                      requestAnimationFrame(function () {
                        _this3.updateVisibleItems(false);
                      });
                    } else {
                      this.$emit('hidden');
                    }
                  }
                },
                updateVisibleItems: function updateVisibleItems(checkItem) {
                  var checkPositionDiff =
                    arguments.length > 1 && arguments[1] !== undefined
                      ? arguments[1]
                      : false;
                  var itemSize = this.itemSize;
                  var minItemSize = this.$_computedMinItemSize;
                  var typeField = this.typeField;
                  var keyField = this.simpleArray ? null : this.keyField;
                  var items = this.items;
                  var count = items.length;
                  var sizes = this.sizes;
                  var views = this.$_views;
                  var unusedViews = this.$_unusedViews;
                  var pool = this.pool;
                  var startIndex, endIndex;
                  var totalSize;

                  if (!count) {
                    startIndex = endIndex = totalSize = 0;
                  } else if (this.$_prerender) {
                    startIndex = 0;
                    endIndex = this.prerender;
                    totalSize = null;
                  } else {
                    var scroll = this.getScroll(); // Skip update if use hasn't scrolled enough

                    if (checkPositionDiff) {
                      var positionDiff =
                        scroll.start - this.$_lastUpdateScrollPosition;
                      if (positionDiff < 0) positionDiff = -positionDiff;

                      if (
                        (itemSize === null && positionDiff < minItemSize) ||
                        positionDiff < itemSize
                      ) {
                        return {
                          continuous: true,
                        };
                      }
                    }

                    this.$_lastUpdateScrollPosition = scroll.start;
                    var buffer = this.buffer;
                    scroll.start -= buffer;
                    scroll.end += buffer; // Variable size mode

                    if (itemSize === null) {
                      var h;
                      var a = 0;
                      var b = count - 1;
                      var i = ~~(count / 2);
                      var oldI; // Searching for startIndex

                      do {
                        oldI = i;
                        h = sizes[i].accumulator;

                        if (h < scroll.start) {
                          a = i;
                        } else if (
                          i < count - 1 &&
                          sizes[i + 1].accumulator > scroll.start
                        ) {
                          b = i;
                        }

                        i = ~~((a + b) / 2);
                      } while (i !== oldI);

                      i < 0 && (i = 0);
                      startIndex = i; // For container style

                      totalSize = sizes[count - 1].accumulator; // Searching for endIndex

                      for (
                        endIndex = i;
                        endIndex < count &&
                        sizes[endIndex].accumulator < scroll.end;
                        endIndex++
                      ) {}

                      if (endIndex === -1) {
                        endIndex = items.length - 1;
                      } else {
                        endIndex++; // Bounds

                        endIndex > count && (endIndex = count);
                      }
                    } else {
                      // Fixed size mode
                      startIndex = ~~(scroll.start / itemSize);
                      endIndex = Math.ceil(scroll.end / itemSize); // Bounds

                      startIndex < 0 && (startIndex = 0);
                      endIndex > count && (endIndex = count);
                      totalSize = count * itemSize;
                    }
                  }

                  if (endIndex - startIndex > config.itemsLimit) {
                    this.itemsLimitError();
                  }

                  this.totalSize = totalSize;
                  var view;
                  var continuous =
                    startIndex <= this.$_endIndex &&
                    endIndex >= this.$_startIndex;

                  if (this.$_continuous !== continuous) {
                    if (continuous) {
                      views.clear();
                      unusedViews.clear();

                      for (var _i = 0, l = pool.length; _i < l; _i++) {
                        view = pool[_i];
                        this.unuseView(view);
                      }
                    }

                    this.$_continuous = continuous;
                  } else if (continuous) {
                    for (var _i2 = 0, _l = pool.length; _i2 < _l; _i2++) {
                      view = pool[_i2];

                      if (view.nr.used) {
                        // Update view item index
                        if (checkItem) {
                          view.nr.index = items.findIndex(function (item) {
                            return keyField
                              ? item[keyField] === view.item[keyField]
                              : item === view.item;
                          });
                        } // Check if index is still in visible range

                        if (
                          view.nr.index === -1 ||
                          view.nr.index < startIndex ||
                          view.nr.index >= endIndex
                        ) {
                          this.unuseView(view);
                        }
                      }
                    }
                  }

                  var unusedIndex = continuous ? null : new Map();
                  var item, type, unusedPool;
                  var v;

                  for (var _i3 = startIndex; _i3 < endIndex; _i3++) {
                    item = items[_i3];
                    var key = keyField ? item[keyField] : item;

                    if (key == null) {
                      throw new Error(
                        'Key is '
                          .concat(key, " on item (keyField is '")
                          .concat(keyField, "')")
                      );
                    }

                    view = views.get(key);

                    if (!itemSize && !sizes[_i3].size) {
                      if (view) this.unuseView(view);
                      continue;
                    } // No view assigned to item

                    if (!view) {
                      type = item[typeField];
                      unusedPool = unusedViews.get(type);

                      if (continuous) {
                        // Reuse existing view
                        if (unusedPool && unusedPool.length) {
                          view = unusedPool.pop();
                          view.item = item;
                          view.nr.used = true;
                          view.nr.index = _i3;
                          view.nr.key = key;
                          view.nr.type = type;
                        } else {
                          view = this.addView(pool, _i3, item, key, type);
                        }
                      } else {
                        // Use existing view
                        // We don't care if they are already used
                        // because we are not in continous scrolling
                        v = unusedIndex.get(type) || 0;

                        if (!unusedPool || v >= unusedPool.length) {
                          view = this.addView(pool, _i3, item, key, type);
                          this.unuseView(view, true);
                          unusedPool = unusedViews.get(type);
                        }

                        view = unusedPool[v];
                        view.item = item;
                        view.nr.used = true;
                        view.nr.index = _i3;
                        view.nr.key = key;
                        view.nr.type = type;
                        unusedIndex.set(type, v + 1);
                        v++;
                      }

                      views.set(key, view);
                    } else {
                      view.nr.used = true;
                      view.item = item;
                    } // Update position

                    if (itemSize === null) {
                      view.position = sizes[_i3 - 1].accumulator;
                    } else {
                      view.position = _i3 * itemSize;
                    }
                  }

                  this.$_startIndex = startIndex;
                  this.$_endIndex = endIndex;
                  if (this.emitUpdate)
                    this.$emit('update', startIndex, endIndex); // After the user has finished scrolling
                  // Sort views so text selection is correct

                  clearTimeout(this.$_sortTimer);
                  this.$_sortTimer = setTimeout(this.sortViews, 300);
                  return {
                    continuous: continuous,
                  };
                },
                getListenerTarget: function getListenerTarget() {
                  var target =
                    scrollparent__WEBPACK_IMPORTED_MODULE_2___default()(
                      this.$el
                    ); // Fix global scroll target for Chrome and Safari

                  if (
                    window.document &&
                    (target === window.document.documentElement ||
                      target === window.document.body)
                  ) {
                    target = window;
                  }

                  return target;
                },
                getScroll: function getScroll() {
                  var el = this.$el,
                    direction = this.direction;
                  var isVertical = direction === 'vertical';
                  var scrollState;

                  if (this.pageMode) {
                    var bounds = el.getBoundingClientRect();
                    var boundsSize = isVertical ? bounds.height : bounds.width;
                    var start = -(isVertical ? bounds.top : bounds.left);
                    var size = isVertical
                      ? window.innerHeight
                      : window.innerWidth;

                    if (start < 0) {
                      size += start;
                      start = 0;
                    }

                    if (start + size > boundsSize) {
                      size = boundsSize - start;
                    }

                    scrollState = {
                      start: start,
                      end: start + size,
                    };
                  } else if (isVertical) {
                    scrollState = {
                      start: el.scrollTop,
                      end: el.scrollTop + el.clientHeight,
                    };
                  } else {
                    scrollState = {
                      start: el.scrollLeft,
                      end: el.scrollLeft + el.clientWidth,
                    };
                  }

                  return scrollState;
                },
                applyPageMode: function applyPageMode() {
                  if (this.pageMode) {
                    this.addListeners();
                  } else {
                    this.removeListeners();
                  }
                },
                addListeners: function addListeners() {
                  this.listenerTarget = this.getListenerTarget();
                  this.listenerTarget.addEventListener(
                    'scroll',
                    this.handleScroll,
                    supportsPassive
                      ? {
                          passive: true,
                        }
                      : false
                  );
                  this.listenerTarget.addEventListener(
                    'resize',
                    this.handleResize
                  );
                },
                removeListeners: function removeListeners() {
                  if (!this.listenerTarget) {
                    return;
                  }

                  this.listenerTarget.removeEventListener(
                    'scroll',
                    this.handleScroll
                  );
                  this.listenerTarget.removeEventListener(
                    'resize',
                    this.handleResize
                  );
                  this.listenerTarget = null;
                },
                scrollToItem: function scrollToItem(index) {
                  var scroll;

                  if (this.itemSize === null) {
                    scroll = index > 0 ? this.sizes[index - 1].accumulator : 0;
                  } else {
                    scroll = index * this.itemSize;
                  }

                  this.scrollToPosition(scroll);
                },
                scrollToPosition: function scrollToPosition(position) {
                  if (this.direction === 'vertical') {
                    this.$el.scrollTop = position;
                  } else {
                    this.$el.scrollLeft = position;
                  }
                },
                itemsLimitError: function itemsLimitError() {
                  var _this4 = this;

                  setTimeout(function () {
                    console.log(
                      "It seems the scroller element isn't scrolling, so it tries to render all the items at once.",
                      'Scroller:',
                      _this4.$el
                    );
                    console.log(
                      "Make sure the scroller has a fixed height (or width) and 'overflow-y' (or 'overflow-x') set to 'auto' so it can scroll correctly and only render the items visible in the scroll viewport."
                    );
                  });
                  throw new Error('Rendered items limit reached');
                },
                sortViews: function sortViews() {
                  this.pool.sort(function (viewA, viewB) {
                    return viewA.nr.index - viewB.nr.index;
                  });
                },
              },
            };

            function normalizeComponent(
              template,
              style,
              script,
              scopeId,
              isFunctionalTemplate,
              moduleIdentifier /* server only */,
              shadowMode,
              createInjector,
              createInjectorSSR,
              createInjectorShadow
            ) {
              if (typeof shadowMode !== 'boolean') {
                createInjectorSSR = createInjector;
                createInjector = shadowMode;
                shadowMode = false;
              }
              // Vue.extend constructor export interop.
              const options =
                typeof script === 'function' ? script.options : script;
              // render functions
              if (template && template.render) {
                options.render = template.render;
                options.staticRenderFns = template.staticRenderFns;
                options._compiled = true;
                // functional template
                if (isFunctionalTemplate) {
                  options.functional = true;
                }
              }
              // scopedId
              if (scopeId) {
                options._scopeId = scopeId;
              }
              let hook;
              if (moduleIdentifier) {
                // server build
                hook = function (context) {
                  // 2.3 injection
                  context =
                    context || // cached call
                    (this.$vnode && this.$vnode.ssrContext) || // stateful
                    (this.parent &&
                      this.parent.$vnode &&
                      this.parent.$vnode.ssrContext); // functional
                  // 2.2 with runInNewContext: true
                  if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
                    context = __VUE_SSR_CONTEXT__;
                  }
                  // inject component styles
                  if (style) {
                    style.call(this, createInjectorSSR(context));
                  }
                  // register component module identifier for async chunk inference
                  if (context && context._registeredComponents) {
                    context._registeredComponents.add(moduleIdentifier);
                  }
                };
                // used by ssr in case component is cached and beforeCreate
                // never gets called
                options._ssrRegister = hook;
              } else if (style) {
                hook = shadowMode
                  ? function (context) {
                      style.call(
                        this,
                        createInjectorShadow(
                          context,
                          this.$root.$options.shadowRoot
                        )
                      );
                    }
                  : function (context) {
                      style.call(this, createInjector(context));
                    };
              }
              if (hook) {
                if (options.functional) {
                  // register for functional component in vue file
                  const originalRender = options.render;
                  options.render = function renderWithStyleInjection(
                    h,
                    context
                  ) {
                    hook.call(context);
                    return originalRender(h, context);
                  };
                } else {
                  // inject component registration as beforeCreate hook
                  const existing = options.beforeCreate;
                  options.beforeCreate = existing
                    ? [].concat(existing, hook)
                    : [hook];
                }
              }
              return script;
            }

            /* script */
            const __vue_script__ = script;
            /* template */
            var __vue_render__ = function () {
              var _obj, _obj$1;
              var _vm = this;
              var _h = _vm.$createElement;
              var _c = _vm._self._c || _h;
              return _c(
                'div',
                {
                  directives: [
                    {
                      name: 'observe-visibility',
                      rawName: 'v-observe-visibility',
                      value: _vm.handleVisibilityChange,
                      expression: 'handleVisibilityChange',
                    },
                  ],
                  staticClass: 'vue-recycle-scroller',
                  class:
                    ((_obj = {
                      ready: _vm.ready,
                      'page-mode': _vm.pageMode,
                    }),
                    (_obj['direction-' + _vm.direction] = true),
                    _obj),
                  on: {
                    '&scroll': function ($event) {
                      return _vm.handleScroll($event);
                    },
                  },
                },
                [
                  _vm.$slots.before
                    ? _c(
                        'div',
                        { staticClass: 'vue-recycle-scroller__slot' },
                        [_vm._t('before')],
                        2
                      )
                    : _vm._e(),
                  _vm._v(' '),
                  _c(
                    'div',
                    {
                      ref: 'wrapper',
                      staticClass: 'vue-recycle-scroller__item-wrapper',
                      style:
                        ((_obj$1 = {}),
                        (_obj$1[
                          _vm.direction === 'vertical'
                            ? 'minHeight'
                            : 'minWidth'
                        ] = _vm.totalSize + 'px'),
                        _obj$1),
                    },
                    _vm._l(_vm.pool, function (view) {
                      return _c(
                        'div',
                        {
                          key: view.nr.id,
                          staticClass: 'vue-recycle-scroller__item-view',
                          class: { hover: _vm.hoverKey === view.nr.key },
                          style: _vm.ready
                            ? {
                                transform:
                                  'translate' +
                                  (_vm.direction === 'vertical' ? 'Y' : 'X') +
                                  '(' +
                                  view.position +
                                  'px)',
                              }
                            : null,
                          on: {
                            mouseenter: function ($event) {
                              _vm.hoverKey = view.nr.key;
                            },
                            mouseleave: function ($event) {
                              _vm.hoverKey = null;
                            },
                          },
                        },
                        [
                          _vm._t('default', null, {
                            item: view.item,
                            index: view.nr.index,
                            active: view.nr.used,
                          }),
                        ],
                        2
                      );
                    }),
                    0
                  ),
                  _vm._v(' '),
                  _vm.$slots.after
                    ? _c(
                        'div',
                        { staticClass: 'vue-recycle-scroller__slot' },
                        [_vm._t('after')],
                        2
                      )
                    : _vm._e(),
                  _vm._v(' '),
                  _c('ResizeObserver', { on: { notify: _vm.handleResize } }),
                ],
                1
              );
            };
            var __vue_staticRenderFns__ = [];
            __vue_render__._withStripped = true;

            /* style */
            const __vue_inject_styles__ = undefined;
            /* scoped */
            const __vue_scope_id__ = undefined;
            /* module identifier */
            const __vue_module_identifier__ = undefined;
            /* functional template */
            const __vue_is_functional_template__ = false;
            /* style inject */

            /* style inject SSR */

            /* style inject shadow dom */

            const __vue_component__ = normalizeComponent(
              {
                render: __vue_render__,
                staticRenderFns: __vue_staticRenderFns__,
              },
              __vue_inject_styles__,
              __vue_script__,
              __vue_scope_id__,
              __vue_is_functional_template__,
              __vue_module_identifier__,
              false,
              undefined,
              undefined,
              undefined
            );

            var script$1 = {
              name: 'DynamicScroller',
              components: {
                RecycleScroller: __vue_component__,
              },
              inheritAttrs: false,
              provide: function provide() {
                if (typeof ResizeObserver !== 'undefined') {
                  this.$_resizeObserver = new ResizeObserver(function (
                    entries
                  ) {
                    var _iterator = _createForOfIteratorHelper(entries),
                      _step;

                    try {
                      for (_iterator.s(); !(_step = _iterator.n()).done; ) {
                        var entry = _step.value;

                        if (entry.target) {
                          var event = new CustomEvent('resize', {
                            detail: {
                              contentRect: entry.contentRect,
                            },
                          });
                          entry.target.dispatchEvent(event);
                        }
                      }
                    } catch (err) {
                      _iterator.e(err);
                    } finally {
                      _iterator.f();
                    }
                  });
                }

                return {
                  vscrollData: this.vscrollData,
                  vscrollParent: this,
                  vscrollResizeObserver: this.$_resizeObserver,
                };
              },
              props: _objectSpread2({}, props, {
                minItemSize: {
                  type: [Number, String],
                  required: true,
                },
              }),
              data: function data() {
                return {
                  vscrollData: {
                    active: true,
                    sizes: {},
                    validSizes: {},
                    keyField: this.keyField,
                    simpleArray: false,
                  },
                };
              },
              computed: {
                simpleArray: simpleArray,
                itemsWithSize: function itemsWithSize() {
                  var result = [];
                  var items = this.items,
                    keyField = this.keyField,
                    simpleArray = this.simpleArray;
                  var sizes = this.vscrollData.sizes;

                  for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    var id = simpleArray ? i : item[keyField];
                    var size = sizes[id];

                    if (
                      typeof size === 'undefined' &&
                      !this.$_undefinedMap[id]
                    ) {
                      size = 0;
                    }

                    result.push({
                      item: item,
                      id: id,
                      size: size,
                    });
                  }

                  return result;
                },
                listeners: function listeners() {
                  var listeners = {};

                  for (var key in this.$listeners) {
                    if (key !== 'resize' && key !== 'visible') {
                      listeners[key] = this.$listeners[key];
                    }
                  }

                  return listeners;
                },
              },
              watch: {
                items: function items() {
                  this.forceUpdate(false);
                },
                simpleArray: {
                  handler: function handler(value) {
                    this.vscrollData.simpleArray = value;
                  },
                  immediate: true,
                },
                direction: function direction(value) {
                  this.forceUpdate(true);
                },
              },
              created: function created() {
                this.$_updates = [];
                this.$_undefinedSizes = 0;
                this.$_undefinedMap = {};
              },
              activated: function activated() {
                this.vscrollData.active = true;
              },
              deactivated: function deactivated() {
                this.vscrollData.active = false;
              },
              methods: {
                onScrollerResize: function onScrollerResize() {
                  var scroller = this.$refs.scroller;

                  if (scroller) {
                    this.forceUpdate();
                  }

                  this.$emit('resize');
                },
                onScrollerVisible: function onScrollerVisible() {
                  this.$emit('vscroll:update', {
                    force: false,
                  });
                  this.$emit('visible');
                },
                forceUpdate: function forceUpdate() {
                  var clear =
                    arguments.length > 0 && arguments[0] !== undefined
                      ? arguments[0]
                      : true;

                  if (clear || this.simpleArray) {
                    this.vscrollData.validSizes = {};
                  }

                  this.$emit('vscroll:update', {
                    force: true,
                  });
                },
                scrollToItem: function scrollToItem(index) {
                  var scroller = this.$refs.scroller;
                  if (scroller) scroller.scrollToItem(index);
                },
                getItemSize: function getItemSize(item) {
                  var index =
                    arguments.length > 1 && arguments[1] !== undefined
                      ? arguments[1]
                      : undefined;
                  var id = this.simpleArray
                    ? index != null
                      ? index
                      : this.items.indexOf(item)
                    : item[this.keyField];
                  return this.vscrollData.sizes[id] || 0;
                },
                scrollToBottom: function scrollToBottom() {
                  var _this = this;

                  if (this.$_scrollingToBottom) return;
                  this.$_scrollingToBottom = true;
                  var el = this.$el; // Item is inserted to the DOM

                  this.$nextTick(function () {
                    el.scrollTop = el.scrollHeight + 5000; // Item sizes are computed

                    var cb = function cb() {
                      el.scrollTop = el.scrollHeight + 5000;
                      requestAnimationFrame(function () {
                        el.scrollTop = el.scrollHeight + 5000;

                        if (_this.$_undefinedSizes === 0) {
                          _this.$_scrollingToBottom = false;
                        } else {
                          requestAnimationFrame(cb);
                        }
                      });
                    };

                    requestAnimationFrame(cb);
                  });
                },
              },
            };

            /* script */
            const __vue_script__$1 = script$1;

            /* template */
            var __vue_render__$1 = function () {
              var _vm = this;
              var _h = _vm.$createElement;
              var _c = _vm._self._c || _h;
              return _c(
                'RecycleScroller',
                _vm._g(
                  _vm._b(
                    {
                      ref: 'scroller',
                      attrs: {
                        items: _vm.itemsWithSize,
                        'min-item-size': _vm.minItemSize,
                        direction: _vm.direction,
                        'key-field': 'id',
                      },
                      on: {
                        resize: _vm.onScrollerResize,
                        visible: _vm.onScrollerVisible,
                      },
                      scopedSlots: _vm._u(
                        [
                          {
                            key: 'default',
                            fn: function (ref) {
                              var itemWithSize = ref.item;
                              var index = ref.index;
                              var active = ref.active;
                              return [
                                _vm._t('default', null, null, {
                                  item: itemWithSize.item,
                                  index: index,
                                  active: active,
                                  itemWithSize: itemWithSize,
                                }),
                              ];
                            },
                          },
                        ],
                        null,
                        true
                      ),
                    },
                    'RecycleScroller',
                    _vm.$attrs,
                    false
                  ),
                  _vm.listeners
                ),
                [
                  _vm._v(' '),
                  _c('template', { slot: 'before' }, [_vm._t('before')], 2),
                  _vm._v(' '),
                  _c('template', { slot: 'after' }, [_vm._t('after')], 2),
                ],
                2
              );
            };
            var __vue_staticRenderFns__$1 = [];
            __vue_render__$1._withStripped = true;

            /* style */
            const __vue_inject_styles__$1 = undefined;
            /* scoped */
            const __vue_scope_id__$1 = undefined;
            /* module identifier */
            const __vue_module_identifier__$1 = undefined;
            /* functional template */
            const __vue_is_functional_template__$1 = false;
            /* style inject */

            /* style inject SSR */

            /* style inject shadow dom */

            const __vue_component__$1 = normalizeComponent(
              {
                render: __vue_render__$1,
                staticRenderFns: __vue_staticRenderFns__$1,
              },
              __vue_inject_styles__$1,
              __vue_script__$1,
              __vue_scope_id__$1,
              __vue_is_functional_template__$1,
              __vue_module_identifier__$1,
              false,
              undefined,
              undefined,
              undefined
            );

            var script$2 = {
              name: 'DynamicScrollerItem',
              inject: ['vscrollData', 'vscrollParent', 'vscrollResizeObserver'],
              props: {
                // eslint-disable-next-line vue/require-prop-types
                item: {
                  required: true,
                },
                watchData: {
                  type: Boolean,
                  default: false,
                },

                /**
                 * Indicates if the view is actively used to display an item.
                 */
                active: {
                  type: Boolean,
                  required: true,
                },
                index: {
                  type: Number,
                  default: undefined,
                },
                sizeDependencies: {
                  type: [Array, Object],
                  default: null,
                },
                emitResize: {
                  type: Boolean,
                  default: false,
                },
                tag: {
                  type: String,
                  default: 'div',
                },
              },
              computed: {
                id: function id() {
                  return this.vscrollData.simpleArray
                    ? this.index
                    : this.item[this.vscrollData.keyField];
                },
                size: function size() {
                  return (
                    (this.vscrollData.validSizes[this.id] &&
                      this.vscrollData.sizes[this.id]) ||
                    0
                  );
                },
                finalActive: function finalActive() {
                  return this.active && this.vscrollData.active;
                },
              },
              watch: {
                watchData: 'updateWatchData',
                id: function id() {
                  if (!this.size) {
                    this.onDataUpdate();
                  }
                },
                finalActive: function finalActive(value) {
                  if (!this.size) {
                    if (value) {
                      if (!this.vscrollParent.$_undefinedMap[this.id]) {
                        this.vscrollParent.$_undefinedSizes++;
                        this.vscrollParent.$_undefinedMap[this.id] = true;
                      }
                    } else {
                      if (this.vscrollParent.$_undefinedMap[this.id]) {
                        this.vscrollParent.$_undefinedSizes--;
                        this.vscrollParent.$_undefinedMap[this.id] = false;
                      }
                    }
                  }

                  if (this.vscrollResizeObserver) {
                    if (value) {
                      this.observeSize();
                    } else {
                      this.unobserveSize();
                    }
                  } else if (value && this.$_pendingVScrollUpdate === this.id) {
                    this.updateSize();
                  }
                },
              },
              created: function created() {
                var _this = this;

                if (this.$isServer) return;
                this.$_forceNextVScrollUpdate = null;
                this.updateWatchData();

                if (!this.vscrollResizeObserver) {
                  var _loop = function _loop(k) {
                    _this.$watch(function () {
                      return _this.sizeDependencies[k];
                    }, _this.onDataUpdate);
                  };

                  for (var k in this.sizeDependencies) {
                    _loop(k);
                  }

                  this.vscrollParent.$on(
                    'vscroll:update',
                    this.onVscrollUpdate
                  );
                  this.vscrollParent.$on(
                    'vscroll:update-size',
                    this.onVscrollUpdateSize
                  );
                }
              },
              mounted: function mounted() {
                if (this.vscrollData.active) {
                  this.updateSize();
                  this.observeSize();
                }
              },
              beforeDestroy: function beforeDestroy() {
                this.vscrollParent.$off('vscroll:update', this.onVscrollUpdate);
                this.vscrollParent.$off(
                  'vscroll:update-size',
                  this.onVscrollUpdateSize
                );
                this.unobserveSize();
              },
              methods: {
                updateSize: function updateSize() {
                  if (this.finalActive) {
                    if (this.$_pendingSizeUpdate !== this.id) {
                      this.$_pendingSizeUpdate = this.id;
                      this.$_forceNextVScrollUpdate = null;
                      this.$_pendingVScrollUpdate = null;
                      this.computeSize(this.id);
                    }
                  } else {
                    this.$_forceNextVScrollUpdate = this.id;
                  }
                },
                updateWatchData: function updateWatchData() {
                  var _this2 = this;

                  if (this.watchData) {
                    this.$_watchData = this.$watch(
                      'data',
                      function () {
                        _this2.onDataUpdate();
                      },
                      {
                        deep: true,
                      }
                    );
                  } else if (this.$_watchData) {
                    this.$_watchData();
                    this.$_watchData = null;
                  }
                },
                onVscrollUpdate: function onVscrollUpdate(_ref) {
                  var force = _ref.force;

                  // If not active, sechedule a size update when it becomes active
                  if (!this.finalActive && force) {
                    this.$_pendingVScrollUpdate = this.id;
                  }

                  if (
                    this.$_forceNextVScrollUpdate === this.id ||
                    force ||
                    !this.size
                  ) {
                    this.updateSize();
                  }
                },
                onDataUpdate: function onDataUpdate() {
                  this.updateSize();
                },
                computeSize: function computeSize(id) {
                  var _this3 = this;

                  this.$nextTick(function () {
                    if (_this3.id === id) {
                      var width = _this3.$el.offsetWidth;
                      var height = _this3.$el.offsetHeight;

                      _this3.applySize(width, height);
                    }

                    _this3.$_pendingSizeUpdate = null;
                  });
                },
                applySize: function applySize(width, height) {
                  var size = Math.round(
                    this.vscrollParent.direction === 'vertical' ? height : width
                  );

                  if (size && this.size !== size) {
                    if (this.vscrollParent.$_undefinedMap[this.id]) {
                      this.vscrollParent.$_undefinedSizes--;
                      this.vscrollParent.$_undefinedMap[this.id] = undefined;
                    }

                    this.$set(this.vscrollData.sizes, this.id, size);
                    this.$set(this.vscrollData.validSizes, this.id, true);
                    if (this.emitResize) this.$emit('resize', this.id);
                  }
                },
                observeSize: function observeSize() {
                  if (!this.vscrollResizeObserver) return;
                  this.vscrollResizeObserver.observe(this.$el.parentNode);
                  this.$el.parentNode.addEventListener('resize', this.onResize);
                },
                unobserveSize: function unobserveSize() {
                  if (!this.vscrollResizeObserver) return;
                  this.vscrollResizeObserver.unobserve(this.$el.parentNode);
                  this.$el.parentNode.removeEventListener(
                    'resize',
                    this.onResize
                  );
                },
                onResize: function onResize(event) {
                  var _event$detail$content = event.detail.contentRect,
                    width = _event$detail$content.width,
                    height = _event$detail$content.height;
                  this.applySize(width, height);
                },
              },
              render: function render(h) {
                return h(this.tag, this.$slots.default);
              },
            };

            /* script */
            const __vue_script__$2 = script$2;

            /* template */

            /* style */
            const __vue_inject_styles__$2 = undefined;
            /* scoped */
            const __vue_scope_id__$2 = undefined;
            /* module identifier */
            const __vue_module_identifier__$2 = undefined;
            /* functional template */
            const __vue_is_functional_template__$2 = undefined;
            /* style inject */

            /* style inject SSR */

            /* style inject shadow dom */

            const __vue_component__$2 = normalizeComponent(
              {},
              __vue_inject_styles__$2,
              __vue_script__$2,
              __vue_scope_id__$2,
              __vue_is_functional_template__$2,
              __vue_module_identifier__$2,
              false,
              undefined,
              undefined,
              undefined
            );

            function IdState() {
              var _ref =
                  arguments.length > 0 && arguments[0] !== undefined
                    ? arguments[0]
                    : {},
                _ref$idProp = _ref.idProp,
                idProp =
                  _ref$idProp === void 0
                    ? function (vm) {
                        return vm.item.id;
                      }
                    : _ref$idProp;

              var store = {};
              var vm = new vue__WEBPACK_IMPORTED_MODULE_3___default.a({
                data: function data() {
                  return {
                    store: store,
                  };
                },
              }); // @vue/component

              return {
                data: function data() {
                  return {
                    idState: null,
                  };
                },
                created: function created() {
                  var _this = this;

                  this.$_id = null;

                  if (typeof idProp === 'function') {
                    this.$_getId = function () {
                      return idProp.call(_this, _this);
                    };
                  } else {
                    this.$_getId = function () {
                      return _this[idProp];
                    };
                  }

                  this.$watch(this.$_getId, {
                    handler: function handler(value) {
                      var _this2 = this;

                      this.$nextTick(function () {
                        _this2.$_id = value;
                      });
                    },
                    immediate: true,
                  });
                  this.$_updateIdState();
                },
                beforeUpdate: function beforeUpdate() {
                  this.$_updateIdState();
                },
                methods: {
                  /**
                   * Initialize an idState
                   * @param {number|string} id Unique id for the data
                   */
                  $_idStateInit: function $_idStateInit(id) {
                    var factory = this.$options.idState;

                    if (typeof factory === 'function') {
                      var data = factory.call(this, this);
                      vm.$set(store, id, data);
                      this.$_id = id;
                      return data;
                    } else {
                      throw new Error(
                        '[mixin IdState] Missing `idState` function on component definition.'
                      );
                    }
                  },

                  /**
                   * Ensure idState is created and up-to-date
                   */
                  $_updateIdState: function $_updateIdState() {
                    var id = this.$_getId();

                    if (id == null) {
                      console.warn(
                        "No id found for IdState with idProp: '".concat(
                          idProp,
                          "'."
                        )
                      );
                    }

                    if (id !== this.$_id) {
                      if (!store[id]) {
                        this.$_idStateInit(id);
                      }

                      this.idState = store[id];
                    }
                  },
                },
              };
            }

            function registerComponents(Vue, prefix) {
              Vue.component(
                ''.concat(prefix, 'recycle-scroller'),
                __vue_component__
              );
              Vue.component(
                ''.concat(prefix, 'RecycleScroller'),
                __vue_component__
              );
              Vue.component(
                ''.concat(prefix, 'dynamic-scroller'),
                __vue_component__$1
              );
              Vue.component(
                ''.concat(prefix, 'DynamicScroller'),
                __vue_component__$1
              );
              Vue.component(
                ''.concat(prefix, 'dynamic-scroller-item'),
                __vue_component__$2
              );
              Vue.component(
                ''.concat(prefix, 'DynamicScrollerItem'),
                __vue_component__$2
              );
            }

            var plugin = {
              // eslint-disable-next-line no-undef
              version: '1.0.10',
              install: function install(Vue, options) {
                var finalOptions = Object.assign(
                  {},
                  {
                    installComponents: true,
                    componentsPrefix: '',
                  },
                  options
                );

                for (var key in finalOptions) {
                  if (typeof finalOptions[key] !== 'undefined') {
                    config[key] = finalOptions[key];
                  }
                }

                if (finalOptions.installComponents) {
                  registerComponents(Vue, finalOptions.componentsPrefix);
                }
              },
            };

            var GlobalVue = null;

            if (typeof window !== 'undefined') {
              GlobalVue = window.Vue;
            } else if (typeof global !== 'undefined') {
              GlobalVue = global.Vue;
            }

            if (GlobalVue) {
              GlobalVue.use(plugin);
            }

            /* unused harmony default export */ var _unused_webpack_default_export =
              plugin;

            //# sourceMappingURL=vue-virtual-scroller.esm.js.map

            /* WEBPACK VAR INJECTION */
          }).call(this, __webpack_require__('c8ba'));

          /***/
        },

        /***/ e53d: /***/ function (module, exports) {
          // https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
          var global = (module.exports =
            typeof window != 'undefined' && window.Math == Math
              ? window
              : typeof self != 'undefined' && self.Math == Math
                ? self
                : // eslint-disable-next-line no-new-func
                  Function('return this')());
          if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef

          /***/
        },

        /***/ e6f3: /***/ function (module, exports, __webpack_require__) {
          var has = __webpack_require__('07e3');
          var toIObject = __webpack_require__('36c3');
          var arrayIndexOf = __webpack_require__('5b4e')(false);
          var IE_PROTO = __webpack_require__('5559')('IE_PROTO');

          module.exports = function (object, names) {
            var O = toIObject(object);
            var i = 0;
            var result = [];
            var key;
            for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
            // Don't enum bug & hidden keys
            while (names.length > i)
              if (has(O, (key = names[i++]))) {
                ~arrayIndexOf(result, key) || result.push(key);
              }
            return result;
          };

          /***/
        },

        /***/ e71e: /***/ function (
          module,
          __webpack_exports__,
          __webpack_require__
        ) {
          'use strict';
          /* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_46e105de_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ =
            __webpack_require__('c50b');
          /* harmony import */ var _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_46e105de_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default =
            /*#__PURE__*/ __webpack_require__.n(
              _node_modules_mini_css_extract_plugin_dist_loader_js_ref_9_oneOf_1_0_node_modules_css_loader_dist_cjs_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_3_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_vue_vue_type_style_index_0_id_46e105de_prod_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__
            );
          /* unused harmony reexport * */

          /***/
        },

        /***/ e853: /***/ function (module, exports, __webpack_require__) {
          var isObject = __webpack_require__('d3f4');
          var isArray = __webpack_require__('1169');
          var SPECIES = __webpack_require__('2b4c')('species');

          module.exports = function (original) {
            var C;
            if (isArray(original)) {
              C = original.constructor;
              // cross-realm fallback
              if (
                typeof C == 'function' &&
                (C === Array || isArray(C.prototype))
              )
                C = undefined;
              if (isObject(C)) {
                C = C[SPECIES];
                if (C === null) C = undefined;
              }
            }
            return C === undefined ? Array : C;
          };

          /***/
        },

        /***/ ebfd: /***/ function (module, exports, __webpack_require__) {
          var META = __webpack_require__('62a0')('meta');
          var isObject = __webpack_require__('f772');
          var has = __webpack_require__('07e3');
          var setDesc = __webpack_require__('d9f6').f;
          var id = 0;
          var isExtensible =
            Object.isExtensible ||
            function () {
              return true;
            };
          var FREEZE = !__webpack_require__('294c')(function () {
            return isExtensible(Object.preventExtensions({}));
          });
          var setMeta = function (it) {
            setDesc(it, META, {
              value: {
                i: 'O' + ++id, // object ID
                w: {}, // weak collections IDs
              },
            });
          };
          var fastKey = function (it, create) {
            // return primitive with prefix
            if (!isObject(it))
              return typeof it == 'symbol'
                ? it
                : (typeof it == 'string' ? 'S' : 'P') + it;
            if (!has(it, META)) {
              // can't set metadata to uncaught frozen object
              if (!isExtensible(it)) return 'F';
              // not necessary to add metadata
              if (!create) return 'E';
              // add missing metadata
              setMeta(it);
              // return object ID
            }
            return it[META].i;
          };
          var getWeak = function (it, create) {
            if (!has(it, META)) {
              // can't set metadata to uncaught frozen object
              if (!isExtensible(it)) return true;
              // not necessary to add metadata
              if (!create) return false;
              // add missing metadata
              setMeta(it);
              // return hash weak collections IDs
            }
            return it[META].w;
          };
          // add metadata on freeze-family methods calling
          var onFreeze = function (it) {
            if (FREEZE && meta.NEED && isExtensible(it) && !has(it, META))
              setMeta(it);
            return it;
          };
          var meta = (module.exports = {
            KEY: META,
            NEED: false,
            fastKey: fastKey,
            getWeak: getWeak,
            onFreeze: onFreeze,
          });

          /***/
        },

        /***/ ed83: /***/ function (module, exports, __webpack_require__) {
          var __WEBPACK_AMD_DEFINE_FACTORY__,
            __WEBPACK_AMD_DEFINE_ARRAY__,
            __WEBPACK_AMD_DEFINE_RESULT__;
          (function (root, factory) {
            if (true) {
              !((__WEBPACK_AMD_DEFINE_ARRAY__ = []),
              (__WEBPACK_AMD_DEFINE_FACTORY__ = factory),
              (__WEBPACK_AMD_DEFINE_RESULT__ =
                typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function'
                  ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(
                      exports,
                      __WEBPACK_AMD_DEFINE_ARRAY__
                    )
                  : __WEBPACK_AMD_DEFINE_FACTORY__),
              __WEBPACK_AMD_DEFINE_RESULT__ !== undefined &&
                (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
            } else {
            }
          })(this, function () {
            var regex = /(auto|scroll)/;

            var parents = function (node, ps) {
              if (node.parentNode === null) {
                return ps;
              }

              return parents(node.parentNode, ps.concat([node]));
            };

            var style = function (node, prop) {
              return getComputedStyle(node, null).getPropertyValue(prop);
            };

            var overflow = function (node) {
              return (
                style(node, 'overflow') +
                style(node, 'overflow-y') +
                style(node, 'overflow-x')
              );
            };

            var scroll = function (node) {
              return regex.test(overflow(node));
            };

            var scrollParent = function (node) {
              if (
                !(node instanceof HTMLElement || node instanceof SVGElement)
              ) {
                return;
              }

              var ps = parents(node.parentNode, []);

              for (var i = 0; i < ps.length; i += 1) {
                if (scroll(ps[i])) {
                  return ps[i];
                }
              }

              return document.scrollingElement || document.documentElement;
            };

            return scrollParent;
          });

          /***/
        },

        /***/ f1ae: /***/ function (module, exports, __webpack_require__) {
          'use strict';

          var $defineProperty = __webpack_require__('86cc');
          var createDesc = __webpack_require__('4630');

          module.exports = function (object, index, value) {
            if (index in object)
              $defineProperty.f(object, index, createDesc(0, value));
            else object[index] = value;
          };

          /***/
        },

        /***/ f201: /***/ function (module, exports, __webpack_require__) {
          // 7.3.20 SpeciesConstructor(O, defaultConstructor)
          var anObject = __webpack_require__('e4ae');
          var aFunction = __webpack_require__('79aa');
          var SPECIES = __webpack_require__('5168')('species');
          module.exports = function (O, D) {
            var C = anObject(O).constructor;
            var S;
            return C === undefined || (S = anObject(C)[SPECIES]) == undefined
              ? D
              : aFunction(S);
          };

          /***/
        },

        /***/ f410: /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('1af6');
          module.exports = __webpack_require__('584a').Array.isArray;

          /***/
        },

        /***/ f559: /***/ function (module, exports, __webpack_require__) {
          'use strict';
          // 21.1.3.18 String.prototype.startsWith(searchString [, position ])

          var $export = __webpack_require__('5ca1');
          var toLength = __webpack_require__('9def');
          var context = __webpack_require__('d2c8');
          var STARTS_WITH = 'startsWith';
          var $startsWith = ''[STARTS_WITH];

          $export(
            $export.P + $export.F * __webpack_require__('5147')(STARTS_WITH),
            'String',
            {
              startsWith: function startsWith(
                searchString /* , position = 0 */
              ) {
                var that = context(this, searchString, STARTS_WITH);
                var index = toLength(
                  Math.min(
                    arguments.length > 1 ? arguments[1] : undefined,
                    that.length
                  )
                );
                var search = String(searchString);
                return $startsWith
                  ? $startsWith.call(that, search, index)
                  : that.slice(index, index + search.length) === search;
              },
            }
          );

          /***/
        },

        /***/ f772: /***/ function (module, exports) {
          module.exports = function (it) {
            return typeof it === 'object'
              ? it !== null
              : typeof it === 'function';
          };

          /***/
        },

        /***/ f921: /***/ function (module, exports, __webpack_require__) {
          __webpack_require__('014b');
          __webpack_require__('c207');
          __webpack_require__('69d3');
          __webpack_require__('765d');
          module.exports = __webpack_require__('584a').Symbol;

          /***/
        },

        /***/ fa5b: /***/ function (module, exports, __webpack_require__) {
          module.exports = __webpack_require__('5537')(
            'native-function-to-string',
            Function.toString
          );

          /***/
        },

        /***/ fab2: /***/ function (module, exports, __webpack_require__) {
          var document = __webpack_require__('7726').document;
          module.exports = document && document.documentElement;

          /***/
        },

        /***/ fb15: /***/ function (
          module,
          __webpack_exports__,
          __webpack_require__
        ) {
          'use strict';
          // ESM COMPAT FLAG
          __webpack_require__.r(__webpack_exports__);

          // CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/setPublicPath.js
          // This file is imported into lib/wc client bundles.

          if (typeof window !== 'undefined') {
            var currentScript = window.document.currentScript;
            if (true) {
              var getCurrentScript = __webpack_require__('8875');
              currentScript = getCurrentScript();

              // for backward compatibility, because previously we directly included the polyfill
              if (!('currentScript' in document)) {
                Object.defineProperty(document, 'currentScript', {
                  get: getCurrentScript,
                });
              }
            }

            var src =
              currentScript &&
              currentScript.src.match(/(.+\/)[^/]+\.js(\?.*)?$/);
            if (src) {
              __webpack_require__.p = src[1]; // eslint-disable-line
            }
          }

          // Indicate to webpack that this file can be concatenated
          /* harmony default export */ var setPublicPath = null;

          // CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js?{"cacheDirectory":"node_modules/.cache/vue-loader","cacheIdentifier":"23eda527-vue-loader-template"}!./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader/lib??vue-loader-options!./src/VuePhoneNumberInput/index.vue?vue&type=template&id=19351537&scoped=true&
          var render = function () {
            var _vm = this;
            var _h = _vm.$createElement;
            var _c = _vm._self._c || _h;
            return _c(
              'div',
              {
                staticClass: 'vue-phone-number-input flex',
                class: [{ dark: _vm.dark }, _vm.size],
                attrs: { id: _vm.id },
              },
              [
                !_vm.noCountrySelector
                  ? _c(
                      'div',
                      { staticClass: 'select-country-container' },
                      [
                        _c(
                          'CountrySelector',
                          {
                            ref: 'CountrySelector',
                            staticClass: 'input-country-selector',
                            attrs: {
                              id: _vm.uniqueId + '_country_selector',
                              items: _vm.codesCountries,
                              'countries-height': _vm.countriesHeight,
                              error: _vm.shouldChooseCountry,
                              hint: _vm.shouldChooseCountry
                                ? _vm.t.countrySelectorError
                                : null,
                              disabled: _vm.disabled,
                              valid: _vm.isValid && !_vm.noValidatorState,
                              'preferred-countries': _vm.preferredCountries,
                              'only-countries': _vm.onlyCountries,
                              'ignored-countries': _vm.ignoredCountries,
                              label: _vm.t.countrySelectorLabel,
                              'no-flags': _vm.noFlags,
                              'show-code-on-list': _vm.showCodeOnList,
                              size: _vm.size,
                              dark: _vm.dark,
                              theme: _vm.theme,
                            },
                            model: {
                              value: _vm.countryCode,
                              callback: function ($$v) {
                                _vm.countryCode = $$v;
                              },
                              expression: 'countryCode',
                            },
                          },
                          [_vm._t('arrow', null, { slot: 'arrow' })],
                          2
                        ),
                      ],
                      1
                    )
                  : _vm._e(),
                _c(
                  'div',
                  { staticClass: 'flex-1' },
                  [
                    _c(
                      'InputTel',
                      _vm._b(
                        {
                          ref: 'PhoneNumberInput',
                          staticClass: 'input-phone-number',
                          attrs: {
                            id: _vm.uniqueId + '_phone_number',
                            label: _vm.t.phoneNumberLabel,
                            hint: _vm.hintValue,
                            dark: _vm.dark,
                            disabled: _vm.disabled,
                            size: _vm.size,
                            error: _vm.error,
                            valid: _vm.isValid && !_vm.noValidatorState,
                            required: _vm.required,
                            'no-country-selector': _vm.noCountrySelector,
                            theme: _vm.theme,
                          },
                          on: {
                            keydown: function (e) {
                              _vm.lastKeyPressed = e.keyCode;
                            },
                            focus: function ($event) {
                              return _vm.$emit('phone-number-focused');
                            },
                            blur: function ($event) {
                              return _vm.$emit('phone-number-blur');
                            },
                          },
                          model: {
                            value: _vm.phoneNumber,
                            callback: function ($$v) {
                              _vm.phoneNumber = $$v;
                            },
                            expression: 'phoneNumber',
                          },
                        },
                        'InputTel',
                        _vm.$attrs,
                        false
                      )
                    ),
                  ],
                  1
                ),
              ]
            );
          };
          var staticRenderFns = [];

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/index.vue?vue&type=template&id=19351537&scoped=true&

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es7.object.get-own-property-descriptors.js
          var es7_object_get_own_property_descriptors =
            __webpack_require__('8e6e');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/web.dom.iterable.js
          var web_dom_iterable = __webpack_require__('ac6a');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.array.iterator.js
          var es6_array_iterator = __webpack_require__('cadf');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.object.keys.js
          var es6_object_keys = __webpack_require__('456d');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.regexp.to-string.js
          var es6_regexp_to_string = __webpack_require__('6b54');

          // EXTERNAL MODULE: ./node_modules/regenerator-runtime/runtime.js
          var runtime = __webpack_require__('96cf');

          // EXTERNAL MODULE: ./node_modules/@babel/runtime-corejs2/core-js/promise.js
          var promise = __webpack_require__('795b');
          var promise_default = /*#__PURE__*/ __webpack_require__.n(promise);

          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/asyncToGenerator.js

          function asyncGeneratorStep(
            gen,
            resolve,
            reject,
            _next,
            _throw,
            key,
            arg
          ) {
            try {
              var info = gen[key](arg);
              var value = info.value;
            } catch (error) {
              reject(error);
              return;
            }

            if (info.done) {
              resolve(value);
            } else {
              promise_default.a.resolve(value).then(_next, _throw);
            }
          }

          function _asyncToGenerator(fn) {
            return function () {
              var self = this,
                args = arguments;
              return new promise_default.a(function (resolve, reject) {
                var gen = fn.apply(self, args);

                function _next(value) {
                  asyncGeneratorStep(
                    gen,
                    resolve,
                    reject,
                    _next,
                    _throw,
                    'next',
                    value
                  );
                }

                function _throw(err) {
                  asyncGeneratorStep(
                    gen,
                    resolve,
                    reject,
                    _next,
                    _throw,
                    'throw',
                    err
                  );
                }

                _next(undefined);
              });
            };
          }
          // EXTERNAL MODULE: ./node_modules/@babel/runtime-corejs2/core-js/object/define-property.js
          var define_property = __webpack_require__('85f2');
          var define_property_default =
            /*#__PURE__*/ __webpack_require__.n(define_property);

          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/defineProperty.js

          function _defineProperty(obj, key, value) {
            if (key in obj) {
              define_property_default()(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
              });
            } else {
              obj[key] = value;
            }

            return obj;
          }
          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.number.constructor.js
          var es6_number_constructor = __webpack_require__('c5f6');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es7.array.includes.js
          var es7_array_includes = __webpack_require__('6762');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.string.includes.js
          var es6_string_includes = __webpack_require__('2fdb');

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/assets/js/phoneCodeCountries.js
          var allCountries = [
            ['Afghanistan (‫افغانستان‬‎)', 'af', '93'],
            ['Albania (Shqipëri)', 'al', '355'],
            ['Algeria (‫الجزائر‬‎)', 'dz', '213'],
            ['American Samoa', 'as', '1684'],
            ['Andorra', 'ad', '376'],
            ['Angola', 'ao', '244'],
            ['Anguilla', 'ai', '1264'],
            ['Antigua and Barbuda', 'ag', '1268'],
            ['Argentina', 'ar', '54'],
            ['Armenia (Հայաստան)', 'am', '374'],
            ['Aruba', 'aw', '297'],
            ['Australia', 'au', '61', 0],
            ['Austria (Österreich)', 'at', '43'],
            ['Azerbaijan (Azərbaycan)', 'az', '994'],
            ['Bahamas', 'bs', '1242'],
            ['Bahrain (‫البحرين‬‎)', 'bh', '973'],
            ['Bangladesh (বাংলাদেশ)', 'bd', '880'],
            ['Barbados', 'bb', '1246'],
            ['Belarus (Беларусь)', 'by', '375'],
            ['Belgium (België)', 'be', '32'],
            ['Belize', 'bz', '501'],
            ['Benin (Bénin)', 'bj', '229'],
            ['Bermuda', 'bm', '1441'],
            ['Bhutan (འབྲུག)', 'bt', '975'],
            ['Bolivia', 'bo', '591'],
            ['Bosnia and Herzegovina (Босна и Херцеговина)', 'ba', '387'],
            ['Botswana', 'bw', '267'],
            ['Brazil (Brasil)', 'br', '55'],
            ['British Indian Ocean Territory', 'io', '246'],
            ['British Virgin Islands', 'vg', '1284'],
            ['Brunei', 'bn', '673'],
            ['Bulgaria (България)', 'bg', '359'],
            ['Burkina Faso', 'bf', '226'],
            ['Burundi (Uburundi)', 'bi', '257'],
            ['Cambodia (កម្ពុជា)', 'kh', '855'],
            ['Cameroon (Cameroun)', 'cm', '237'],
            [
              'Canada',
              'ca',
              '1',
              1,
              [
                '204',
                '226',
                '236',
                '249',
                '250',
                '289',
                '306',
                '343',
                '365',
                '387',
                '403',
                '416',
                '418',
                '431',
                '437',
                '438',
                '450',
                '506',
                '514',
                '519',
                '548',
                '579',
                '581',
                '587',
                '604',
                '613',
                '639',
                '647',
                '672',
                '705',
                '709',
                '742',
                '778',
                '780',
                '782',
                '807',
                '819',
                '825',
                '867',
                '873',
                '902',
                '905',
              ],
            ],
            ['Cape Verde (Kabu Verdi)', 'cv', '238'],
            ['Caribbean Netherlands', 'bq', '599', 1],
            ['Cayman Islands', 'ky', '1345'],
            [
              'Central African Republic (République centrafricaine)',
              'cf',
              '236',
            ],
            ['Chad (Tchad)', 'td', '235'],
            ['Chile', 'cl', '56'],
            ['China (中国)', 'cn', '86'],
            ['Christmas Island', 'cx', '61', 2],
            ['Cocos (Keeling) Islands', 'cc', '61', 1],
            ['Colombia', 'co', '57'],
            ['Comoros (‫جزر القمر‬‎)', 'km', '269'],
            ['Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)', 'cd', '243'],
            ['Congo (Republic) (Congo-Brazzaville)', 'cg', '242'],
            ['Cook Islands', 'ck', '682'],
            ['Costa Rica', 'cr', '506'],
            ['Côte d’Ivoire', 'ci', '225'],
            ['Croatia (Hrvatska)', 'hr', '385'],
            ['Cuba', 'cu', '53'],
            ['Curaçao', 'cw', '599', 0],
            ['Cyprus (Κύπρος)', 'cy', '357'],
            ['Czech Republic (Česká republika)', 'cz', '420'],
            ['Denmark (Danmark)', 'dk', '45'],
            ['Djibouti', 'dj', '253'],
            ['Dominica', 'dm', '1767'],
            [
              'Dominican Republic (República Dominicana)',
              'do',
              '1',
              2,
              ['809', '829', '849'],
            ],
            ['Ecuador', 'ec', '593'],
            ['Egypt (‫مصر‬‎)', 'eg', '20'],
            ['El Salvador', 'sv', '503'],
            ['Equatorial Guinea (Guinea Ecuatorial)', 'gq', '240'],
            ['Eritrea', 'er', '291'],
            ['Estonia (Eesti)', 'ee', '372'],
            ['Ethiopia', 'et', '251'],
            ['Falkland Islands (Islas Malvinas)', 'fk', '500'],
            ['Faroe Islands (Føroyar)', 'fo', '298'],
            ['Fiji', 'fj', '679'],
            ['Finland (Suomi)', 'fi', '358', 0],
            ['France', 'fr', '33'],
            ['French Guiana (Guyane française)', 'gf', '594'],
            ['French Polynesia (Polynésie française)', 'pf', '689'],
            ['Gabon', 'ga', '241'],
            ['Gambia', 'gm', '220'],
            ['Georgia (საქართველო)', 'ge', '995'],
            ['Germany (Deutschland)', 'de', '49'],
            ['Ghana (Gaana)', 'gh', '233'],
            ['Gibraltar', 'gi', '350'],
            ['Greece (Ελλάδα)', 'gr', '30'],
            ['Greenland (Kalaallit Nunaat)', 'gl', '299'],
            ['Grenada', 'gd', '1473'],
            ['Guadeloupe', 'gp', '590', 0],
            ['Guam', 'gu', '1671'],
            ['Guatemala', 'gt', '502'],
            ['Guernsey', 'gg', '44', 1],
            ['Guinea (Guinée)', 'gn', '224'],
            ['Guinea-Bissau (Guiné Bissau)', 'gw', '245'],
            ['Guyana', 'gy', '592'],
            ['Haiti', 'ht', '509'],
            ['Honduras', 'hn', '504'],
            ['Hong Kong (香港)', 'hk', '852'],
            ['Hungary (Magyarország)', 'hu', '36'],
            ['Iceland (Ísland)', 'is', '354'],
            ['India (भारत)', 'in', '91'],
            ['Indonesia', 'id', '62'],
            ['Iran (‫ایران‬‎)', 'ir', '98'],
            ['Iraq (‫العراق‬‎)', 'iq', '964'],
            ['Ireland', 'ie', '353'],
            ['Isle of Man', 'im', '44', 2],
            ['Israel (‫ישראל‬‎)', 'il', '972'],
            ['Italy (Italia)', 'it', '39', 0],
            ['Jamaica', 'jm', '1876'],
            ['Japan (日本)', 'jp', '81'],
            ['Jersey', 'je', '44', 3],
            ['Jordan (‫الأردن‬‎)', 'jo', '962'],
            ['Kazakhstan (Казахстан)', 'kz', '7', 1],
            ['Kenya', 'ke', '254'],
            ['Kiribati', 'ki', '686'],
            ['Kosovo', 'xk', '383'],
            ['Kuwait (‫الكويت‬‎)', 'kw', '965'],
            ['Kyrgyzstan (Кыргызстан)', 'kg', '996'],
            ['Laos (ລາວ)', 'la', '856'],
            ['Latvia (Latvija)', 'lv', '371'],
            ['Lebanon (‫لبنان‬‎)', 'lb', '961'],
            ['Lesotho', 'ls', '266'],
            ['Liberia', 'lr', '231'],
            ['Libya (‫ليبيا‬‎)', 'ly', '218'],
            ['Liechtenstein', 'li', '423'],
            ['Lithuania (Lietuva)', 'lt', '370'],
            ['Luxembourg', 'lu', '352'],
            ['Macau (澳門)', 'mo', '853'],
            ['Macedonia (FYROM) (Македонија)', 'mk', '389'],
            ['Madagascar (Madagasikara)', 'mg', '261'],
            ['Malawi', 'mw', '265'],
            ['Malaysia', 'my', '60'],
            ['Maldives', 'mv', '960'],
            ['Mali', 'ml', '223'],
            ['Malta', 'mt', '356'],
            ['Marshall Islands', 'mh', '692'],
            ['Martinique', 'mq', '596'],
            ['Mauritania (‫موريتانيا‬‎)', 'mr', '222'],
            ['Mauritius (Moris)', 'mu', '230'],
            ['Mayotte', 'yt', '262', 1],
            ['Mexico (México)', 'mx', '52'],
            ['Micronesia', 'fm', '691'],
            ['Moldova (Republica Moldova)', 'md', '373'],
            ['Monaco', 'mc', '377'],
            ['Mongolia (Монгол)', 'mn', '976'],
            ['Montenegro (Crna Gora)', 'me', '382'],
            ['Montserrat', 'ms', '1664'],
            ['Morocco (‫المغرب‬‎)', 'ma', '212', 0],
            ['Mozambique (Moçambique)', 'mz', '258'],
            ['Myanmar (Burma) (မြန်မာ)', 'mm', '95'],
            ['Namibia (Namibië)', 'na', '264'],
            ['Nauru', 'nr', '674'],
            ['Nepal (नेपाल)', 'np', '977'],
            ['Netherlands (Nederland)', 'nl', '31'],
            ['New Caledonia (Nouvelle-Calédonie)', 'nc', '687'],
            ['New Zealand', 'nz', '64'],
            ['Nicaragua', 'ni', '505'],
            ['Niger (Nijar)', 'ne', '227'],
            ['Nigeria', 'ng', '234'],
            ['Niue', 'nu', '683'],
            ['Norfolk Island', 'nf', '672'],
            ['North Korea (조선 민주주의 인민 공화국)', 'kp', '850'],
            ['Northern Mariana Islands', 'mp', '1670'],
            ['Norway (Norge)', 'no', '47', 0],
            ['Oman (‫عُمان‬‎)', 'om', '968'],
            ['Pakistan (‫پاکستان‬‎)', 'pk', '92'],
            ['Palau', 'pw', '680'],
            ['Palestine (‫فلسطين‬‎)', 'ps', '970'],
            ['Panama (Panamá)', 'pa', '507'],
            ['Papua New Guinea', 'pg', '675'],
            ['Paraguay', 'py', '595'],
            ['Peru (Perú)', 'pe', '51'],
            ['Philippines', 'ph', '63'],
            ['Poland (Polska)', 'pl', '48'],
            ['Portugal', 'pt', '351'],
            ['Puerto Rico', 'pr', '1', 3, ['787', '939']],
            ['Qatar (‫قطر‬‎)', 'qa', '974'],
            ['Réunion (La Réunion)', 're', '262', 0],
            ['Romania (România)', 'ro', '40'],
            ['Russia (Россия)', 'ru', '7', 0],
            ['Rwanda', 'rw', '250'],
            ['Saint Barthélemy', 'bl', '590', 1],
            ['Saint Helena', 'sh', '290'],
            ['Saint Kitts and Nevis', 'kn', '1869'],
            ['Saint Lucia', 'lc', '1758'],
            ['Saint Martin (Saint-Martin (partie française))', 'mf', '590', 2],
            [
              'Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)',
              'pm',
              '508',
            ],
            ['Saint Vincent and the Grenadines', 'vc', '1784'],
            ['Samoa', 'ws', '685'],
            ['San Marino', 'sm', '378'],
            ['São Tomé and Príncipe (São Tomé e Príncipe)', 'st', '239'],
            ['Saudi Arabia (‫المملكة العربية السعودية‬‎)', 'sa', '966'],
            ['Senegal (Sénégal)', 'sn', '221'],
            ['Serbia (Србија)', 'rs', '381'],
            ['Seychelles', 'sc', '248'],
            ['Sierra Leone', 'sl', '232'],
            ['Singapore', 'sg', '65'],
            ['Sint Maarten', 'sx', '1721'],
            ['Slovakia (Slovensko)', 'sk', '421'],
            ['Slovenia (Slovenija)', 'si', '386'],
            ['Solomon Islands', 'sb', '677'],
            ['Somalia (Soomaaliya)', 'so', '252'],
            ['South Africa', 'za', '27'],
            ['South Korea (대한민국)', 'kr', '82'],
            ['South Sudan (‫جنوب السودان‬‎)', 'ss', '211'],
            ['Spain (España)', 'es', '34'],
            ['Sri Lanka (ශ්‍රී ලංකාව)', 'lk', '94'],
            ['Sudan (‫السودان‬‎)', 'sd', '249'],
            ['Suriname', 'sr', '597'],
            ['Svalbard and Jan Mayen', 'sj', '47', 1],
            ['Swaziland', 'sz', '268'],
            ['Sweden (Sverige)', 'se', '46'],
            ['Switzerland (Schweiz)', 'ch', '41'],
            ['Syria (‫سوريا‬‎)', 'sy', '963'],
            ['Taiwan (台灣)', 'tw', '886'],
            ['Tajikistan', 'tj', '992'],
            ['Tanzania', 'tz', '255'],
            ['Thailand (ไทย)', 'th', '66'],
            ['Timor-Leste', 'tl', '670'],
            ['Togo', 'tg', '228'],
            ['Tokelau', 'tk', '690'],
            ['Tonga', 'to', '676'],
            ['Trinidad and Tobago', 'tt', '1868'],
            ['Tunisia (‫تونس‬‎)', 'tn', '216'],
            ['Turkey (Türkiye)', 'tr', '90'],
            ['Turkmenistan', 'tm', '993'],
            ['Turks and Caicos Islands', 'tc', '1649'],
            ['Tuvalu', 'tv', '688'],
            ['U.S. Virgin Islands', 'vi', '1340'],
            ['Uganda', 'ug', '256'],
            ['Ukraine (Україна)', 'ua', '380'],
            ['United Arab Emirates (‫الإمارات العربية المتحدة‬‎)', 'ae', '971'],
            ['United Kingdom', 'gb', '44', 0],
            ['United States', 'us', '1', 0],
            ['Uruguay', 'uy', '598'],
            ['Uzbekistan (Oʻzbekiston)', 'uz', '998'],
            ['Vanuatu', 'vu', '678'],
            ['Vatican City (Città del Vaticano)', 'va', '39', 1],
            ['Venezuela', 've', '58'],
            ['Vietnam (Việt Nam)', 'vn', '84'],
            ['Wallis and Futuna (Wallis-et-Futuna)', 'wf', '681'],
            ['Western Sahara (‫الصحراء الغربية‬‎)', 'eh', '212', 1],
            ['Yemen (‫اليمن‬‎)', 'ye', '967'],
            ['Zambia', 'zm', '260'],
            ['Zimbabwe', 'zw', '263'],
            ['Åland Islands', 'ax', '358', 1],
          ];
          var countriesIso = allCountries.map(function (country) {
            return country[1].toUpperCase();
          });
          var countries = allCountries.map(function (country) {
            return {
              name: country[0],
              iso2: country[1].toUpperCase(),
              dialCode: country[2],
              priority: country[3] || 0,
              areaCodes: country[4] || null,
            };
          });
          // EXTERNAL MODULE: ./node_modules/libphonenumber-js/examples.mobile.json
          var examples_mobile = __webpack_require__('d391');

          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/metadata.min.json.js
          // This file is a workaround for a bug in web browsers' "native"
          // ES6 importing system which is uncapable of importing "*.json" files.
          // https://github.com/catamphetamine/libphonenumber-js/issues/239
          /* harmony default export */ var metadata_min_json = {
            version: 4,
            country_calling_codes: {
              1: [
                'US',
                'AG',
                'AI',
                'AS',
                'BB',
                'BM',
                'BS',
                'CA',
                'DM',
                'DO',
                'GD',
                'GU',
                'JM',
                'KN',
                'KY',
                'LC',
                'MP',
                'MS',
                'PR',
                'SX',
                'TC',
                'TT',
                'VC',
                'VG',
                'VI',
              ],
              7: ['RU', 'KZ'],
              20: ['EG'],
              27: ['ZA'],
              30: ['GR'],
              31: ['NL'],
              32: ['BE'],
              33: ['FR'],
              34: ['ES'],
              36: ['HU'],
              39: ['IT', 'VA'],
              40: ['RO'],
              41: ['CH'],
              43: ['AT'],
              44: ['GB', 'GG', 'IM', 'JE'],
              45: ['DK'],
              46: ['SE'],
              47: ['NO', 'SJ'],
              48: ['PL'],
              49: ['DE'],
              51: ['PE'],
              52: ['MX'],
              53: ['CU'],
              54: ['AR'],
              55: ['BR'],
              56: ['CL'],
              57: ['CO'],
              58: ['VE'],
              60: ['MY'],
              61: ['AU', 'CC', 'CX'],
              62: ['ID'],
              63: ['PH'],
              64: ['NZ'],
              65: ['SG'],
              66: ['TH'],
              81: ['JP'],
              82: ['KR'],
              84: ['VN'],
              86: ['CN'],
              90: ['TR'],
              91: ['IN'],
              92: ['PK'],
              93: ['AF'],
              94: ['LK'],
              95: ['MM'],
              98: ['IR'],
              211: ['SS'],
              212: ['MA', 'EH'],
              213: ['DZ'],
              216: ['TN'],
              218: ['LY'],
              220: ['GM'],
              221: ['SN'],
              222: ['MR'],
              223: ['ML'],
              224: ['GN'],
              225: ['CI'],
              226: ['BF'],
              227: ['NE'],
              228: ['TG'],
              229: ['BJ'],
              230: ['MU'],
              231: ['LR'],
              232: ['SL'],
              233: ['GH'],
              234: ['NG'],
              235: ['TD'],
              236: ['CF'],
              237: ['CM'],
              238: ['CV'],
              239: ['ST'],
              240: ['GQ'],
              241: ['GA'],
              242: ['CG'],
              243: ['CD'],
              244: ['AO'],
              245: ['GW'],
              246: ['IO'],
              247: ['AC'],
              248: ['SC'],
              249: ['SD'],
              250: ['RW'],
              251: ['ET'],
              252: ['SO'],
              253: ['DJ'],
              254: ['KE'],
              255: ['TZ'],
              256: ['UG'],
              257: ['BI'],
              258: ['MZ'],
              260: ['ZM'],
              261: ['MG'],
              262: ['RE', 'YT'],
              263: ['ZW'],
              264: ['NA'],
              265: ['MW'],
              266: ['LS'],
              267: ['BW'],
              268: ['SZ'],
              269: ['KM'],
              290: ['SH', 'TA'],
              291: ['ER'],
              297: ['AW'],
              298: ['FO'],
              299: ['GL'],
              350: ['GI'],
              351: ['PT'],
              352: ['LU'],
              353: ['IE'],
              354: ['IS'],
              355: ['AL'],
              356: ['MT'],
              357: ['CY'],
              358: ['FI', 'AX'],
              359: ['BG'],
              370: ['LT'],
              371: ['LV'],
              372: ['EE'],
              373: ['MD'],
              374: ['AM'],
              375: ['BY'],
              376: ['AD'],
              377: ['MC'],
              378: ['SM'],
              380: ['UA'],
              381: ['RS'],
              382: ['ME'],
              383: ['XK'],
              385: ['HR'],
              386: ['SI'],
              387: ['BA'],
              389: ['MK'],
              420: ['CZ'],
              421: ['SK'],
              423: ['LI'],
              500: ['FK'],
              501: ['BZ'],
              502: ['GT'],
              503: ['SV'],
              504: ['HN'],
              505: ['NI'],
              506: ['CR'],
              507: ['PA'],
              508: ['PM'],
              509: ['HT'],
              590: ['GP', 'BL', 'MF'],
              591: ['BO'],
              592: ['GY'],
              593: ['EC'],
              594: ['GF'],
              595: ['PY'],
              596: ['MQ'],
              597: ['SR'],
              598: ['UY'],
              599: ['CW', 'BQ'],
              670: ['TL'],
              672: ['NF'],
              673: ['BN'],
              674: ['NR'],
              675: ['PG'],
              676: ['TO'],
              677: ['SB'],
              678: ['VU'],
              679: ['FJ'],
              680: ['PW'],
              681: ['WF'],
              682: ['CK'],
              683: ['NU'],
              685: ['WS'],
              686: ['KI'],
              687: ['NC'],
              688: ['TV'],
              689: ['PF'],
              690: ['TK'],
              691: ['FM'],
              692: ['MH'],
              850: ['KP'],
              852: ['HK'],
              853: ['MO'],
              855: ['KH'],
              856: ['LA'],
              880: ['BD'],
              886: ['TW'],
              960: ['MV'],
              961: ['LB'],
              962: ['JO'],
              963: ['SY'],
              964: ['IQ'],
              965: ['KW'],
              966: ['SA'],
              967: ['YE'],
              968: ['OM'],
              970: ['PS'],
              971: ['AE'],
              972: ['IL'],
              973: ['BH'],
              974: ['QA'],
              975: ['BT'],
              976: ['MN'],
              977: ['NP'],
              992: ['TJ'],
              993: ['TM'],
              994: ['AZ'],
              995: ['GE'],
              996: ['KG'],
              998: ['UZ'],
            },
            countries: {
              AC: ['247', '00', '(?:[01589]\\d|[46])\\d{4}', [5, 6]],
              AD: [
                '376',
                '00',
                '(?:1|6\\d)\\d{7}|[135-9]\\d{5}',
                [6, 8, 9],
                [
                  ['(\\d{3})(\\d{3})', '$1 $2', ['[135-9]']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['1']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['6']],
                ],
              ],
              AE: [
                '971',
                '00',
                '(?:[4-7]\\d|9[0-689])\\d{7}|800\\d{2,9}|[2-4679]\\d{7}',
                [5, 6, 7, 8, 9, 10, 11, 12],
                [
                  ['(\\d{3})(\\d{2,9})', '$1 $2', ['60|8']],
                  [
                    '(\\d)(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['[236]|[479][2-8]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d)(\\d{5})', '$1 $2 $3', ['[479]']],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['5'], '0$1'],
                ],
                '0',
              ],
              AF: [
                '93',
                '00',
                '[2-7]\\d{8}',
                [9],
                [['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[2-7]'], '0$1']],
                '0',
              ],
              AG: [
                '1',
                '011',
                '(?:268|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([457]\\d{6})$',
                '268$1',
                0,
                '268',
              ],
              AI: [
                '1',
                '011',
                '(?:264|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2457]\\d{6})$',
                '264$1',
                0,
                '264',
              ],
              AL: [
                '355',
                '00',
                '(?:700\\d\\d|900)\\d{3}|8\\d{5,7}|(?:[2-5]|6\\d)\\d{7}',
                [6, 7, 8, 9],
                [
                  ['(\\d{3})(\\d{3,4})', '$1 $2', ['80|9'], '0$1'],
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['4[2-6]'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['[2358][2-5]|4'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{5})', '$1 $2', ['[23578]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['6'], '0$1'],
                ],
                '0',
              ],
              AM: [
                '374',
                '00',
                '(?:[1-489]\\d|55|60|77)\\d{6}',
                [8],
                [
                  ['(\\d{3})(\\d{2})(\\d{3})', '$1 $2 $3', ['[89]0'], '0 $1'],
                  ['(\\d{3})(\\d{5})', '$1 $2', ['2|3[12]'], '(0$1)'],
                  ['(\\d{2})(\\d{6})', '$1 $2', ['1|47'], '(0$1)'],
                  ['(\\d{2})(\\d{6})', '$1 $2', ['[3-9]'], '0$1'],
                ],
                '0',
              ],
              AO: [
                '244',
                '00',
                '[29]\\d{8}',
                [9],
                [['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[29]']]],
              ],
              AR: [
                '54',
                '00',
                '(?:11|[89]\\d\\d)\\d{8}|[2368]\\d{9}',
                [10, 11],
                [
                  [
                    '(\\d{4})(\\d{2})(\\d{4})',
                    '$1 $2-$3',
                    [
                      '2(?:2[024-9]|3[0-59]|47|6[245]|9[02-8])|3(?:3[28]|4[03-9]|5[2-46-8]|7[1-578]|8[2-9])',
                      '2(?:[23]02|6(?:[25]|4[6-8])|9(?:[02356]|4[02568]|72|8[23]))|3(?:3[28]|4(?:[04679]|3[5-8]|5[4-68]|8[2379])|5(?:[2467]|3[237]|8[2-5])|7[1-578]|8(?:[2469]|3[2578]|5[4-8]|7[36-8]|8[5-8]))|2(?:2[24-9]|3[1-59]|47)',
                      '2(?:[23]02|6(?:[25]|4(?:64|[78]))|9(?:[02356]|4(?:[0268]|5[2-6])|72|8[23]))|3(?:3[28]|4(?:[04679]|3[78]|5(?:4[46]|8)|8[2379])|5(?:[2467]|3[237]|8[23])|7[1-578]|8(?:[2469]|3[278]|5[56][46]|86[3-6]))|2(?:2[24-9]|3[1-59]|47)|38(?:[58][78]|7[378])|3(?:4[35][56]|58[45]|8(?:[38]5|54|76))[4-6]',
                      '2(?:[23]02|6(?:[25]|4(?:64|[78]))|9(?:[02356]|4(?:[0268]|5[2-6])|72|8[23]))|3(?:3[28]|4(?:[04679]|3(?:5(?:4[0-25689]|[56])|[78])|58|8[2379])|5(?:[2467]|3[237]|8(?:[23]|4(?:[45]|60)|5(?:4[0-39]|5|64)))|7[1-578]|8(?:[2469]|3[278]|54(?:4|5[13-7]|6[89])|86[3-6]))|2(?:2[24-9]|3[1-59]|47)|38(?:[58][78]|7[378])|3(?:454|85[56])[46]|3(?:4(?:36|5[56])|8(?:[38]5|76))[4-6]',
                    ],
                    '0$1',
                    1,
                  ],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1 $2-$3', ['1'], '0$1', 1],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1-$2-$3', ['[68]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2-$3', ['[23]'], '0$1', 1],
                  [
                    '(\\d)(\\d{4})(\\d{2})(\\d{4})',
                    '$2 15-$3-$4',
                    [
                      '9(?:2[2-469]|3[3-578])',
                      '9(?:2(?:2[024-9]|3[0-59]|47|6[245]|9[02-8])|3(?:3[28]|4[03-9]|5[2-46-8]|7[1-578]|8[2-9]))',
                      '9(?:2(?:[23]02|6(?:[25]|4[6-8])|9(?:[02356]|4[02568]|72|8[23]))|3(?:3[28]|4(?:[04679]|3[5-8]|5[4-68]|8[2379])|5(?:[2467]|3[237]|8[2-5])|7[1-578]|8(?:[2469]|3[2578]|5[4-8]|7[36-8]|8[5-8])))|92(?:2[24-9]|3[1-59]|47)',
                      '9(?:2(?:[23]02|6(?:[25]|4(?:64|[78]))|9(?:[02356]|4(?:[0268]|5[2-6])|72|8[23]))|3(?:3[28]|4(?:[04679]|3[78]|5(?:4[46]|8)|8[2379])|5(?:[2467]|3[237]|8[23])|7[1-578]|8(?:[2469]|3[278]|5(?:[56][46]|[78])|7[378]|8(?:6[3-6]|[78]))))|92(?:2[24-9]|3[1-59]|47)|93(?:4[35][56]|58[45]|8(?:[38]5|54|76))[4-6]',
                      '9(?:2(?:[23]02|6(?:[25]|4(?:64|[78]))|9(?:[02356]|4(?:[0268]|5[2-6])|72|8[23]))|3(?:3[28]|4(?:[04679]|3(?:5(?:4[0-25689]|[56])|[78])|5(?:4[46]|8)|8[2379])|5(?:[2467]|3[237]|8(?:[23]|4(?:[45]|60)|5(?:4[0-39]|5|64)))|7[1-578]|8(?:[2469]|3[278]|5(?:4(?:4|5[13-7]|6[89])|[56][46]|[78])|7[378]|8(?:6[3-6]|[78]))))|92(?:2[24-9]|3[1-59]|47)|93(?:4(?:36|5[56])|8(?:[38]5|76))[4-6]',
                    ],
                    '0$1',
                    0,
                    '$1 $2 $3-$4',
                  ],
                  [
                    '(\\d)(\\d{2})(\\d{4})(\\d{4})',
                    '$2 15-$3-$4',
                    ['91'],
                    '0$1',
                    0,
                    '$1 $2 $3-$4',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{5})', '$1-$2-$3', ['8'], '0$1'],
                  [
                    '(\\d)(\\d{3})(\\d{3})(\\d{4})',
                    '$2 15-$3-$4',
                    ['9'],
                    '0$1',
                    0,
                    '$1 $2 $3-$4',
                  ],
                ],
                '0',
                0,
                '0?(?:(11|2(?:2(?:02?|[13]|2[13-79]|4[1-6]|5[2457]|6[124-8]|7[1-4]|8[13-6]|9[1267])|3(?:02?|1[467]|2[03-6]|3[13-8]|[49][2-6]|5[2-8]|[67])|4(?:7[3-578]|9)|6(?:[0136]|2[24-6]|4[6-8]?|5[15-8])|80|9(?:0[1-3]|[19]|2\\d|3[1-6]|4[02568]?|5[2-4]|6[2-46]|72?|8[23]?))|3(?:3(?:2[79]|6|8[2578])|4(?:0[0-24-9]|[12]|3[5-8]?|4[24-7]|5[4-68]?|6[02-9]|7[126]|8[2379]?|9[1-36-8])|5(?:1|2[1245]|3[237]?|4[1-46-9]|6[2-4]|7[1-6]|8[2-5]?)|6[24]|7(?:[069]|1[1568]|2[15]|3[145]|4[13]|5[14-8]|7[2-57]|8[126])|8(?:[01]|2[15-7]|3[2578]?|4[13-6]|5[4-8]?|6[1-357-9]|7[36-8]?|8[5-8]?|9[124])))15)?',
                '9$1',
              ],
              AS: [
                '1',
                '011',
                '(?:[58]\\d\\d|684|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([267]\\d{6})$',
                '684$1',
                0,
                '684',
              ],
              AT: [
                '43',
                '00',
                '1\\d{3,12}|2\\d{6,12}|43(?:(?:0\\d|5[02-9])\\d{3,9}|2\\d{4,5}|[3467]\\d{4}|8\\d{4,6}|9\\d{4,7})|5\\d{4,12}|8\\d{7,12}|9\\d{8,12}|(?:[367]\\d|4[0-24-9])\\d{4,11}',
                [4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                [
                  ['(\\d)(\\d{3,12})', '$1 $2', ['1(?:11|[2-9])'], '0$1'],
                  ['(\\d{3})(\\d{2})', '$1 $2', ['517'], '0$1'],
                  ['(\\d{2})(\\d{3,5})', '$1 $2', ['5[079]'], '0$1'],
                  [
                    '(\\d{3})(\\d{3,10})',
                    '$1 $2',
                    ['(?:31|4)6|51|6(?:5[0-3579]|[6-9])|7(?:20|32|8)|[89]'],
                    '0$1',
                  ],
                  ['(\\d{4})(\\d{3,9})', '$1 $2', ['[2-467]|5[2-6]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['5'], '0$1'],
                  ['(\\d{2})(\\d{4})(\\d{4,7})', '$1 $2 $3', ['5'], '0$1'],
                ],
                '0',
              ],
              AU: [
                '61',
                '001[14-689]|14(?:1[14]|34|4[17]|[56]6|7[47]|88)0011',
                '1(?:[0-79]\\d{7}(?:\\d(?:\\d{2})?)?|8[0-24-9]\\d{7})|[2-478]\\d{8}|1\\d{4,7}',
                [5, 6, 7, 8, 9, 10, 12],
                [
                  ['(\\d{2})(\\d{3,4})', '$1 $2', ['16'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{2,4})', '$1 $2 $3', ['16'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['14|4'], '0$1'],
                  ['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['[2378]'], '(0$1)'],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1 $2 $3', ['1(?:30|[89])']],
                ],
                '0',
                0,
                '0|(183[12])',
                0,
                0,
                0,
                [
                  [
                    '(?:(?:2(?:[0-26-9]\\d|3[0-8]|4[02-9]|5[0135-9])|3(?:[0-3589]\\d|4[0-578]|6[1-9]|7[0-35-9])|7(?:[013-57-9]\\d|2[0-8]))\\d{3}|8(?:51(?:0(?:0[03-9]|[12479]\\d|3[2-9]|5[0-8]|6[1-9]|8[0-7])|1(?:[0235689]\\d|1[0-69]|4[0-589]|7[0-47-9])|2(?:0[0-79]|[18][13579]|2[14-9]|3[0-46-9]|[4-6]\\d|7[89]|9[0-4]))|(?:6[0-8]|[78]\\d)\\d{3}|9(?:[02-9]\\d{3}|1(?:(?:[0-58]\\d|6[0135-9])\\d|7(?:0[0-24-9]|[1-9]\\d)|9(?:[0-46-9]\\d|5[0-79])))))\\d{3}',
                    [9],
                  ],
                  [
                    '4(?:83[0-38]|93[0-6])\\d{5}|4(?:[0-3]\\d|4[047-9]|5[0-25-9]|6[06-9]|7[02-9]|8[0-24-9]|9[0-27-9])\\d{6}',
                    [9],
                  ],
                  ['180(?:0\\d{3}|2)\\d{3}', [7, 10]],
                  ['190[0-26]\\d{6}', [10]],
                  0,
                  0,
                  0,
                  ['163\\d{2,6}', [5, 6, 7, 8, 9]],
                  ['14(?:5(?:1[0458]|[23][458])|71\\d)\\d{4}', [9]],
                  [
                    '13(?:00\\d{6}(?:\\d{2})?|45[0-4]\\d{3})|13\\d{4}',
                    [6, 8, 10, 12],
                  ],
                ],
                '0011',
              ],
              AW: [
                '297',
                '00',
                '(?:[25-79]\\d\\d|800)\\d{4}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[25-9]']]],
              ],
              AX: [
                '358',
                '00|99(?:[01469]|5(?:[14]1|3[23]|5[59]|77|88|9[09]))',
                '2\\d{4,9}|35\\d{4,5}|(?:60\\d\\d|800)\\d{4,6}|7\\d{5,11}|(?:[14]\\d|3[0-46-9]|50)\\d{4,8}',
                [5, 6, 7, 8, 9, 10, 11, 12],
                0,
                '0',
                0,
                0,
                0,
                0,
                '18',
                0,
                '00',
              ],
              AZ: [
                '994',
                '00',
                '365\\d{6}|(?:[124579]\\d|60|88)\\d{7}',
                [9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['90'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    [
                      '1[28]|2|365|46',
                      '1[28]|2|365[45]|46',
                      '1[28]|2|365(?:4|5[02])|46',
                    ],
                    '(0$1)',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[13-9]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              BA: [
                '387',
                '00',
                '6\\d{8}|(?:[35689]\\d|49|70)\\d{6}',
                [8, 9],
                [
                  [
                    '(\\d{2})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['6[1-3]|[7-9]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{3})',
                    '$1 $2-$3',
                    ['[3-5]|6[56]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['6'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              BB: [
                '1',
                '011',
                '(?:246|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-9]\\d{6})$',
                '246$1',
                0,
                '246',
              ],
              BD: [
                '880',
                '00',
                '[1-469]\\d{9}|8[0-79]\\d{7,8}|[2-79]\\d{8}|[2-9]\\d{7}|[3-9]\\d{6}|[57-9]\\d{5}',
                [6, 7, 8, 9, 10],
                [
                  ['(\\d{2})(\\d{4,6})', '$1-$2', ['31[5-8]|[459]1'], '0$1'],
                  [
                    '(\\d{3})(\\d{3,7})',
                    '$1-$2',
                    [
                      '3(?:[67]|8[013-9])|4(?:6[168]|7|[89][18])|5(?:6[128]|9)|6(?:28|4[14]|5)|7[2-589]|8(?:0[014-9]|[12])|9[358]|(?:3[2-5]|4[235]|5[2-578]|6[0389]|76|8[3-7]|9[24])1|(?:44|66)[01346-9]',
                    ],
                    '0$1',
                  ],
                  ['(\\d{4})(\\d{3,6})', '$1-$2', ['[13-9]|22'], '0$1'],
                  ['(\\d)(\\d{7,8})', '$1-$2', ['2'], '0$1'],
                ],
                '0',
              ],
              BE: [
                '32',
                '00',
                '4\\d{8}|[1-9]\\d{7}',
                [8, 9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{3})',
                    '$1 $2 $3',
                    ['(?:80|9)0'],
                    '0$1',
                  ],
                  [
                    '(\\d)(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[239]|4[23]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[15-8]'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['4'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              BF: [
                '226',
                '00',
                '[025-7]\\d{7}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[025-7]'],
                  ],
                ],
              ],
              BG: [
                '359',
                '00',
                '[2-7]\\d{6,7}|[89]\\d{6,8}|2\\d{5}',
                [6, 7, 8, 9],
                [
                  ['(\\d)(\\d)(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['2'], '0$1'],
                  ['(\\d{3})(\\d{4})', '$1 $2', ['43[1-6]|70[1-9]'], '0$1'],
                  ['(\\d)(\\d{3})(\\d{3,4})', '$1 $2 $3', ['2'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{2,3})',
                    '$1 $2 $3',
                    ['[356]|4[124-7]|7[1-9]|8[1-6]|9[1-7]'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{3})',
                    '$1 $2 $3',
                    ['(?:70|8)0'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{2})',
                    '$1 $2 $3',
                    ['43[1-7]|7'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['[48]|9[08]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['9'], '0$1'],
                ],
                '0',
              ],
              BH: [
                '973',
                '00',
                '[136-9]\\d{7}',
                [8],
                [['(\\d{4})(\\d{4})', '$1 $2', ['[13679]|8[047]']]],
              ],
              BI: [
                '257',
                '00',
                '(?:[267]\\d|31)\\d{6}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[2367]'],
                  ],
                ],
              ],
              BJ: [
                '229',
                '00',
                '(?:[25689]\\d|40)\\d{6}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[24-689]'],
                  ],
                ],
              ],
              BL: [
                '590',
                '00',
                '(?:590|(?:69|80)\\d|976)\\d{6}',
                [9],
                0,
                '0',
                0,
                0,
                0,
                0,
                0,
                [
                  ['590(?:2[7-9]|5[12]|87)\\d{4}'],
                  ['69(?:0\\d\\d|1(?:2[2-9]|3[0-5]))\\d{4}'],
                  ['80[0-5]\\d{6}'],
                  0,
                  0,
                  0,
                  0,
                  0,
                  ['976[01]\\d{5}'],
                ],
              ],
              BM: [
                '1',
                '011',
                '(?:441|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-8]\\d{6})$',
                '441$1',
                0,
                '441',
              ],
              BN: [
                '673',
                '00',
                '[2-578]\\d{6}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[2-578]']]],
              ],
              BO: [
                '591',
                '00(?:1\\d)?',
                '(?:[2-467]\\d\\d|8001)\\d{5}',
                [8, 9],
                [
                  ['(\\d)(\\d{7})', '$1 $2', ['[23]|4[46]']],
                  ['(\\d{8})', '$1', ['[67]']],
                  ['(\\d{3})(\\d{2})(\\d{4})', '$1 $2 $3', ['8']],
                ],
                '0',
                0,
                '0(1\\d)?',
              ],
              BQ: [
                '599',
                '00',
                '(?:[34]1|7\\d)\\d{5}',
                [7],
                0,
                0,
                0,
                0,
                0,
                0,
                '[347]',
              ],
              BR: [
                '55',
                '00(?:1[245]|2[1-35]|31|4[13]|[56]5|99)',
                '(?:[1-46-9]\\d\\d|5(?:[0-46-9]\\d|5[0-46-9]))\\d{8}|[1-9]\\d{9}|[3589]\\d{8}|[34]\\d{7}',
                [8, 9, 10, 11],
                [
                  [
                    '(\\d{4})(\\d{4})',
                    '$1-$2',
                    ['300|4(?:0[02]|37)', '4(?:02|37)0|[34]00'],
                  ],
                  [
                    '(\\d{3})(\\d{2,3})(\\d{4})',
                    '$1 $2 $3',
                    ['(?:[358]|90)0'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{4})(\\d{4})',
                    '$1 $2-$3',
                    [
                      '(?:[14689][1-9]|2[12478]|3[1-578]|5[13-5]|7[13-579])[2-57]',
                    ],
                    '($1)',
                  ],
                  [
                    '(\\d{2})(\\d{5})(\\d{4})',
                    '$1 $2-$3',
                    ['[16][1-9]|[2-57-9]'],
                    '($1)',
                  ],
                ],
                '0',
                0,
                '(?:0|90)(?:(1[245]|2[1-35]|31|4[13]|[56]5|99)(\\d{10,11}))?',
                '$2',
              ],
              BS: [
                '1',
                '011',
                '(?:242|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([3-8]\\d{6})$',
                '242$1',
                0,
                '242',
              ],
              BT: [
                '975',
                '00',
                '[17]\\d{7}|[2-8]\\d{6}',
                [7, 8],
                [
                  ['(\\d)(\\d{3})(\\d{3})', '$1 $2 $3', ['[2-68]|7[246]']],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['1[67]|7'],
                  ],
                ],
              ],
              BW: [
                '267',
                '00',
                '(?:0800|(?:[37]|800)\\d)\\d{6}|(?:[2-6]\\d|90)\\d{5}',
                [7, 8, 10],
                [
                  ['(\\d{2})(\\d{5})', '$1 $2', ['90']],
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[24-6]|3[15-79]']],
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['[37]']],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1 $2 $3', ['0']],
                  ['(\\d{3})(\\d{4})(\\d{3})', '$1 $2 $3', ['8']],
                ],
              ],
              BY: [
                '375',
                '810',
                '(?:[12]\\d|33|44|902)\\d{7}|8(?:0[0-79]\\d{5,7}|[1-7]\\d{9})|8(?:1[0-489]|[5-79]\\d)\\d{7}|8[1-79]\\d{6,7}|8[0-79]\\d{5}|8\\d{5}',
                [6, 7, 8, 9, 10, 11],
                [
                  ['(\\d{3})(\\d{3})', '$1 $2', ['800'], '8 $1'],
                  ['(\\d{3})(\\d{2})(\\d{2,4})', '$1 $2 $3', ['800'], '8 $1'],
                  [
                    '(\\d{4})(\\d{2})(\\d{3})',
                    '$1 $2-$3',
                    [
                      '1(?:5[169]|6[3-5]|7[179])|2(?:1[35]|2[34]|3[3-5])',
                      '1(?:5[169]|6(?:3[1-3]|4|5[125])|7(?:1[3-9]|7[0-24-6]|9[2-7]))|2(?:1[35]|2[34]|3[3-5])',
                    ],
                    '8 0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2-$3-$4',
                    ['1(?:[56]|7[467])|2[1-3]'],
                    '8 0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2-$3-$4',
                    ['[1-4]'],
                    '8 0$1',
                  ],
                  ['(\\d{3})(\\d{3,4})(\\d{4})', '$1 $2 $3', ['[89]'], '8 $1'],
                ],
                '8',
                0,
                '0|80?',
                0,
                0,
                0,
                0,
                '8~10',
              ],
              BZ: [
                '501',
                '00',
                '(?:0800\\d|[2-8])\\d{6}',
                [7, 11],
                [
                  ['(\\d{3})(\\d{4})', '$1-$2', ['[2-8]']],
                  ['(\\d)(\\d{3})(\\d{4})(\\d{3})', '$1-$2-$3-$4', ['0']],
                ],
              ],
              CA: [
                '1',
                '011',
                '(?:[2-8]\\d|90)\\d{8}|3\\d{6}',
                [7, 10],
                0,
                '1',
                0,
                0,
                0,
                0,
                0,
                [
                  [
                    '(?:2(?:04|[23]6|[48]9|50|63)|3(?:06|43|6[578])|4(?:03|1[68]|3[178]|50|68|74)|5(?:06|1[49]|48|79|8[147])|6(?:04|13|39|47|72)|7(?:0[59]|78|8[02])|8(?:[06]7|19|25|73)|90[25])[2-9]\\d{6}',
                    [10],
                  ],
                  ['', [10]],
                  ['8(?:00|33|44|55|66|77|88)[2-9]\\d{6}', [10]],
                  ['900[2-9]\\d{6}', [10]],
                  [
                    '52(?:3(?:[2-46-9][02-9]\\d|5(?:[02-46-9]\\d|5[0-46-9]))|4(?:[2-478][02-9]\\d|5(?:[034]\\d|2[024-9]|5[0-46-9])|6(?:0[1-9]|[2-9]\\d)|9(?:[05-9]\\d|2[0-5]|49)))\\d{4}|52[34][2-9]1[02-9]\\d{4}|(?:5(?:00|2[125-7]|33|44|66|77|88)|622)[2-9]\\d{6}',
                    [10],
                  ],
                  0,
                  ['310\\d{4}', [7]],
                  0,
                  ['600[2-9]\\d{6}', [10]],
                ],
              ],
              CC: [
                '61',
                '001[14-689]|14(?:1[14]|34|4[17]|[56]6|7[47]|88)0011',
                '1(?:[0-79]\\d{8}(?:\\d{2})?|8[0-24-9]\\d{7})|[148]\\d{8}|1\\d{5,7}',
                [6, 7, 8, 9, 10, 12],
                0,
                '0',
                0,
                '0|([59]\\d{7})$',
                '8$1',
                0,
                0,
                [
                  [
                    '8(?:51(?:0(?:02|31|60|89)|1(?:18|76)|223)|91(?:0(?:1[0-2]|29)|1(?:[28]2|50|79)|2(?:10|64)|3(?:[06]8|22)|4[29]8|62\\d|70[23]|959))\\d{3}',
                    [9],
                  ],
                  [
                    '4(?:83[0-38]|93[0-6])\\d{5}|4(?:[0-3]\\d|4[047-9]|5[0-25-9]|6[06-9]|7[02-9]|8[0-24-9]|9[0-27-9])\\d{6}',
                    [9],
                  ],
                  ['180(?:0\\d{3}|2)\\d{3}', [7, 10]],
                  ['190[0-26]\\d{6}', [10]],
                  0,
                  0,
                  0,
                  0,
                  ['14(?:5(?:1[0458]|[23][458])|71\\d)\\d{4}', [9]],
                  [
                    '13(?:00\\d{6}(?:\\d{2})?|45[0-4]\\d{3})|13\\d{4}',
                    [6, 8, 10, 12],
                  ],
                ],
                '0011',
              ],
              CD: [
                '243',
                '00',
                '[189]\\d{8}|[1-68]\\d{6}',
                [7, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{3})', '$1 $2 $3', ['88'], '0$1'],
                  ['(\\d{2})(\\d{5})', '$1 $2', ['[1-6]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['1'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[89]'], '0$1'],
                ],
                '0',
              ],
              CF: [
                '236',
                '00',
                '(?:[27]\\d{3}|8776)\\d{4}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[278]'],
                  ],
                ],
              ],
              CG: [
                '242',
                '00',
                '222\\d{6}|(?:0\\d|80)\\d{7}',
                [9],
                [
                  ['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['8']],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[02]']],
                ],
              ],
              CH: [
                '41',
                '00',
                '8\\d{11}|[2-9]\\d{8}',
                [9],
                [
                  [
                    '(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['8[047]|90'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[2-79]|81'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4 $5',
                    ['8'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              CI: [
                '225',
                '00',
                '[02]\\d{9}',
                [10],
                [
                  ['(\\d{2})(\\d{2})(\\d)(\\d{5})', '$1 $2 $3 $4', ['2']],
                  ['(\\d{2})(\\d{2})(\\d{2})(\\d{4})', '$1 $2 $3 $4', ['0']],
                ],
              ],
              CK: [
                '682',
                '00',
                '[2-578]\\d{4}',
                [5],
                [['(\\d{2})(\\d{3})', '$1 $2', ['[2-578]']]],
              ],
              CL: [
                '56',
                '(?:0|1(?:1[0-69]|2[02-5]|5[13-58]|69|7[0167]|8[018]))0',
                '12300\\d{6}|6\\d{9,10}|[2-9]\\d{8}',
                [9, 10, 11],
                [
                  ['(\\d{5})(\\d{4})', '$1 $2', ['219', '2196'], '($1)'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['44']],
                  ['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['2[1-36]'], '($1)'],
                  ['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['9[2-9]']],
                  [
                    '(\\d{2})(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['3[2-5]|[47]|5[1-3578]|6[13-57]|8(?:0[1-9]|[1-9])'],
                    '($1)',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['60|8']],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['1']],
                  ['(\\d{3})(\\d{3})(\\d{2})(\\d{3})', '$1 $2 $3 $4', ['60']],
                ],
              ],
              CM: [
                '237',
                '00',
                '[26]\\d{8}|88\\d{6,7}',
                [8, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['88']],
                  [
                    '(\\d)(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4 $5',
                    ['[26]|88'],
                  ],
                ],
              ],
              CN: [
                '86',
                '00|1(?:[12]\\d|79)\\d\\d00',
                '1[127]\\d{8,9}|2\\d{9}(?:\\d{2})?|[12]\\d{6,7}|86\\d{6}|(?:1[03-689]\\d|6)\\d{7,9}|(?:[3-579]\\d|8[0-57-9])\\d{6,9}',
                [7, 8, 9, 10, 11, 12],
                [
                  [
                    '(\\d{2})(\\d{5,6})',
                    '$1 $2',
                    [
                      '(?:10|2[0-57-9])[19]',
                      '(?:10|2[0-57-9])(?:10|9[56])',
                      '(?:10|2[0-57-9])(?:100|9[56])',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{5,6})',
                    '$1 $2',
                    [
                      '3(?:[157]|35|49|9[1-68])|4(?:[17]|2[179]|6[47-9]|8[23])|5(?:[1357]|2[37]|4[36]|6[1-46]|80)|6(?:3[1-5]|6[0238]|9[12])|7(?:01|[1579]|2[248]|3[014-9]|4[3-6]|6[023689])|8(?:1[236-8]|2[5-7]|[37]|8[36-8]|9[1-8])|9(?:0[1-3689]|1[1-79]|[379]|4[13]|5[1-5])|(?:4[35]|59|85)[1-9]',
                      '(?:3(?:[157]\\d|35|49|9[1-68])|4(?:[17]\\d|2[179]|[35][1-9]|6[47-9]|8[23])|5(?:[1357]\\d|2[37]|4[36]|6[1-46]|80|9[1-9])|6(?:3[1-5]|6[0238]|9[12])|7(?:01|[1579]\\d|2[248]|3[014-9]|4[3-6]|6[023689])|8(?:1[236-8]|2[5-7]|[37]\\d|5[1-9]|8[36-8]|9[1-8])|9(?:0[1-3689]|1[1-79]|[379]\\d|4[13]|5[1-5]))[19]',
                      '85[23](?:10|95)|(?:3(?:[157]\\d|35|49|9[1-68])|4(?:[17]\\d|2[179]|[35][1-9]|6[47-9]|8[23])|5(?:[1357]\\d|2[37]|4[36]|6[1-46]|80|9[1-9])|6(?:3[1-5]|6[0238]|9[12])|7(?:01|[1579]\\d|2[248]|3[014-9]|4[3-6]|6[023689])|8(?:1[236-8]|2[5-7]|[37]\\d|5[14-9]|8[36-8]|9[1-8])|9(?:0[1-3689]|1[1-79]|[379]\\d|4[13]|5[1-5]))(?:10|9[56])',
                      '85[23](?:100|95)|(?:3(?:[157]\\d|35|49|9[1-68])|4(?:[17]\\d|2[179]|[35][1-9]|6[47-9]|8[23])|5(?:[1357]\\d|2[37]|4[36]|6[1-46]|80|9[1-9])|6(?:3[1-5]|6[0238]|9[12])|7(?:01|[1579]\\d|2[248]|3[014-9]|4[3-6]|6[023689])|8(?:1[236-8]|2[5-7]|[37]\\d|5[14-9]|8[36-8]|9[1-8])|9(?:0[1-3689]|1[1-79]|[379]\\d|4[13]|5[1-5]))(?:100|9[56])',
                    ],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['(?:4|80)0']],
                  [
                    '(\\d{2})(\\d{4})(\\d{4})',
                    '$1 $2 $3',
                    [
                      '10|2(?:[02-57-9]|1[1-9])',
                      '10|2(?:[02-57-9]|1[1-9])',
                      '10[0-79]|2(?:[02-57-9]|1[1-79])|(?:10|21)8(?:0[1-9]|[1-9])',
                    ],
                    '0$1',
                    1,
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    [
                      '3(?:[3-59]|7[02-68])|4(?:[26-8]|3[3-9]|5[2-9])|5(?:3[03-9]|[468]|7[028]|9[2-46-9])|6|7(?:[0-247]|3[04-9]|5[0-4689]|6[2368])|8(?:[1-358]|9[1-7])|9(?:[013479]|5[1-5])|(?:[34]1|55|79|87)[02-9]',
                    ],
                    '0$1',
                    1,
                  ],
                  ['(\\d{3})(\\d{7,8})', '$1 $2', ['9']],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['80'], '0$1', 1],
                  [
                    '(\\d{3})(\\d{4})(\\d{4})',
                    '$1 $2 $3',
                    ['[3-578]'],
                    '0$1',
                    1,
                  ],
                  ['(\\d{3})(\\d{4})(\\d{4})', '$1 $2 $3', ['1[3-9]']],
                  [
                    '(\\d{2})(\\d{3})(\\d{3})(\\d{4})',
                    '$1 $2 $3 $4',
                    ['[12]'],
                    '0$1',
                    1,
                  ],
                ],
                '0',
                0,
                '0|(1(?:[12]\\d|79)\\d\\d)',
                0,
                0,
                0,
                0,
                '00',
              ],
              CO: [
                '57',
                '00(?:4(?:[14]4|56)|[579])',
                '(?:60\\d\\d|9101)\\d{6}|(?:1\\d|3)\\d{9}',
                [10, 11],
                [
                  ['(\\d{3})(\\d{7})', '$1 $2', ['6'], '($1)'],
                  ['(\\d{3})(\\d{7})', '$1 $2', ['[39]']],
                  [
                    '(\\d)(\\d{3})(\\d{7})',
                    '$1-$2-$3',
                    ['1'],
                    '0$1',
                    0,
                    '$1 $2 $3',
                  ],
                ],
                '0',
                0,
                '0(4(?:[14]4|56)|[579])?',
              ],
              CR: [
                '506',
                '00',
                '(?:8\\d|90)\\d{8}|(?:[24-8]\\d{3}|3005)\\d{4}',
                [8, 10],
                [
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[2-7]|8[3-9]']],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1-$2-$3', ['[89]']],
                ],
                0,
                0,
                '(19(?:0[0-2468]|1[09]|20|66|77|99))',
              ],
              CU: [
                '53',
                '119',
                '[27]\\d{6,7}|[34]\\d{5,7}|(?:5|8\\d\\d)\\d{7}',
                [6, 7, 8, 10],
                [
                  ['(\\d{2})(\\d{4,6})', '$1 $2', ['2[1-4]|[34]'], '(0$1)'],
                  ['(\\d)(\\d{6,7})', '$1 $2', ['7'], '(0$1)'],
                  ['(\\d)(\\d{7})', '$1 $2', ['5'], '0$1'],
                  ['(\\d{3})(\\d{7})', '$1 $2', ['8'], '0$1'],
                ],
                '0',
              ],
              CV: [
                '238',
                '0',
                '(?:[2-59]\\d\\d|800)\\d{4}',
                [7],
                [['(\\d{3})(\\d{2})(\\d{2})', '$1 $2 $3', ['[2-589]']]],
              ],
              CW: [
                '599',
                '00',
                '(?:[34]1|60|(?:7|9\\d)\\d)\\d{5}',
                [7, 8],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[3467]']],
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['9[4-8]']],
                ],
                0,
                0,
                0,
                0,
                0,
                '[69]',
              ],
              CX: [
                '61',
                '001[14-689]|14(?:1[14]|34|4[17]|[56]6|7[47]|88)0011',
                '1(?:[0-79]\\d{8}(?:\\d{2})?|8[0-24-9]\\d{7})|[148]\\d{8}|1\\d{5,7}',
                [6, 7, 8, 9, 10, 12],
                0,
                '0',
                0,
                '0|([59]\\d{7})$',
                '8$1',
                0,
                0,
                [
                  [
                    '8(?:51(?:0(?:01|30|59|88)|1(?:17|46|75)|2(?:22|35))|91(?:00[6-9]|1(?:[28]1|49|78)|2(?:09|63)|3(?:12|26|75)|4(?:56|97)|64\\d|7(?:0[01]|1[0-2])|958))\\d{3}',
                    [9],
                  ],
                  [
                    '4(?:83[0-38]|93[0-6])\\d{5}|4(?:[0-3]\\d|4[047-9]|5[0-25-9]|6[06-9]|7[02-9]|8[0-24-9]|9[0-27-9])\\d{6}',
                    [9],
                  ],
                  ['180(?:0\\d{3}|2)\\d{3}', [7, 10]],
                  ['190[0-26]\\d{6}', [10]],
                  0,
                  0,
                  0,
                  0,
                  ['14(?:5(?:1[0458]|[23][458])|71\\d)\\d{4}', [9]],
                  [
                    '13(?:00\\d{6}(?:\\d{2})?|45[0-4]\\d{3})|13\\d{4}',
                    [6, 8, 10, 12],
                  ],
                ],
                '0011',
              ],
              CY: [
                '357',
                '00',
                '(?:[279]\\d|[58]0)\\d{6}',
                [8],
                [['(\\d{2})(\\d{6})', '$1 $2', ['[257-9]']]],
              ],
              CZ: [
                '420',
                '00',
                '(?:[2-578]\\d|60)\\d{7}|9\\d{8,11}',
                [9],
                [
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[2-8]|9[015-7]']],
                  ['(\\d{2})(\\d{3})(\\d{3})(\\d{2})', '$1 $2 $3 $4', ['96']],
                  ['(\\d{2})(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3 $4', ['9']],
                  ['(\\d{3})(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3 $4', ['9']],
                ],
              ],
              DE: [
                '49',
                '00',
                '[2579]\\d{5,14}|49(?:[34]0|69|8\\d)\\d\\d?|49(?:37|49|60|7[089]|9\\d)\\d{1,3}|49(?:2[02-9]|3[2-689]|7[1-7])\\d{1,8}|(?:1|[368]\\d|4[0-8])\\d{3,13}|49(?:[015]\\d|[23]1|[46][1-8])\\d{1,9}',
                [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                [
                  ['(\\d{2})(\\d{3,13})', '$1 $2', ['3[02]|40|[68]9'], '0$1'],
                  [
                    '(\\d{3})(\\d{3,12})',
                    '$1 $2',
                    [
                      '2(?:0[1-389]|1[124]|2[18]|3[14])|3(?:[35-9][15]|4[015])|906|(?:2[4-9]|4[2-9]|[579][1-9]|[68][1-8])1',
                      '2(?:0[1-389]|12[0-8])|3(?:[35-9][15]|4[015])|906|2(?:[13][14]|2[18])|(?:2[4-9]|4[2-9]|[579][1-9]|[68][1-8])1',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{4})(\\d{2,11})',
                    '$1 $2',
                    [
                      '[24-6]|3(?:[3569][02-46-9]|4[2-4679]|7[2-467]|8[2-46-8])|70[2-8]|8(?:0[2-9]|[1-8])|90[7-9]|[79][1-9]',
                      '[24-6]|3(?:3(?:0[1-467]|2[127-9]|3[124578]|7[1257-9]|8[1256]|9[145])|4(?:2[135]|4[13578]|9[1346])|5(?:0[14]|2[1-3589]|6[1-4]|7[13468]|8[13568])|6(?:2[1-489]|3[124-6]|6[13]|7[12579]|8[1-356]|9[135])|7(?:2[1-7]|4[145]|6[1-5]|7[1-4])|8(?:21|3[1468]|6|7[1467]|8[136])|9(?:0[12479]|2[1358]|4[134679]|6[1-9]|7[136]|8[147]|9[1468]))|70[2-8]|8(?:0[2-9]|[1-8])|90[7-9]|[79][1-9]|3[68]4[1347]|3(?:47|60)[1356]|3(?:3[46]|46|5[49])[1246]|3[4579]3[1357]',
                    ],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{4})', '$1 $2', ['138'], '0$1'],
                  ['(\\d{5})(\\d{2,10})', '$1 $2', ['3'], '0$1'],
                  ['(\\d{3})(\\d{5,11})', '$1 $2', ['181'], '0$1'],
                  [
                    '(\\d{3})(\\d)(\\d{4,10})',
                    '$1 $2 $3',
                    ['1(?:3|80)|9'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{7,8})', '$1 $2', ['1[67]'], '0$1'],
                  ['(\\d{3})(\\d{7,12})', '$1 $2', ['8'], '0$1'],
                  [
                    '(\\d{5})(\\d{6})',
                    '$1 $2',
                    ['185', '1850', '18500'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{4})(\\d{4})', '$1 $2 $3', ['7'], '0$1'],
                  ['(\\d{4})(\\d{7})', '$1 $2', ['18[68]'], '0$1'],
                  ['(\\d{5})(\\d{6})', '$1 $2', ['15[0568]'], '0$1'],
                  ['(\\d{4})(\\d{7})', '$1 $2', ['15[1279]'], '0$1'],
                  ['(\\d{3})(\\d{8})', '$1 $2', ['18'], '0$1'],
                  [
                    '(\\d{3})(\\d{2})(\\d{7,8})',
                    '$1 $2 $3',
                    ['1(?:6[023]|7)'],
                    '0$1',
                  ],
                  ['(\\d{4})(\\d{2})(\\d{7})', '$1 $2 $3', ['15[279]'], '0$1'],
                  ['(\\d{3})(\\d{2})(\\d{8})', '$1 $2 $3', ['15'], '0$1'],
                ],
                '0',
              ],
              DJ: [
                '253',
                '00',
                '(?:2\\d|77)\\d{6}',
                [8],
                [['(\\d{2})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['[27]']]],
              ],
              DK: [
                '45',
                '00',
                '[2-9]\\d{7}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[2-9]'],
                  ],
                ],
              ],
              DM: [
                '1',
                '011',
                '(?:[58]\\d\\d|767|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-7]\\d{6})$',
                '767$1',
                0,
                '767',
              ],
              DO: [
                '1',
                '011',
                '(?:[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                0,
                0,
                0,
                '8001|8[024]9',
              ],
              DZ: [
                '213',
                '00',
                '(?:[1-4]|[5-79]\\d|80)\\d{7}',
                [8, 9],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[1-4]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['9'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[5-8]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              EC: [
                '593',
                '00',
                '1\\d{9,10}|(?:[2-7]|9\\d)\\d{7}',
                [8, 9, 10, 11],
                [
                  [
                    '(\\d)(\\d{3})(\\d{4})',
                    '$1 $2-$3',
                    ['[2-7]'],
                    '(0$1)',
                    0,
                    '$1-$2-$3',
                  ],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['9'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['1']],
                ],
                '0',
              ],
              EE: [
                '372',
                '00',
                '8\\d{9}|[4578]\\d{7}|(?:[3-8]\\d|90)\\d{5}',
                [7, 8, 10],
                [
                  [
                    '(\\d{3})(\\d{4})',
                    '$1 $2',
                    [
                      '[369]|4[3-8]|5(?:[0-2]|5[0-478]|6[45])|7[1-9]|88',
                      '[369]|4[3-8]|5(?:[02]|1(?:[0-8]|95)|5[0-478]|6(?:4[0-4]|5[1-589]))|7[1-9]|88',
                    ],
                  ],
                  [
                    '(\\d{4})(\\d{3,4})',
                    '$1 $2',
                    ['[45]|8(?:00|[1-49])', '[45]|8(?:00[1-9]|[1-49])'],
                  ],
                  ['(\\d{2})(\\d{2})(\\d{4})', '$1 $2 $3', ['7']],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1 $2 $3', ['8']],
                ],
              ],
              EG: [
                '20',
                '00',
                '[189]\\d{8,9}|[24-6]\\d{8}|[135]\\d{7}',
                [8, 9, 10],
                [
                  ['(\\d)(\\d{7,8})', '$1 $2', ['[23]'], '0$1'],
                  [
                    '(\\d{2})(\\d{6,7})',
                    '$1 $2',
                    ['1[35]|[4-6]|8[2468]|9[235-7]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['[189]'], '0$1'],
                ],
                '0',
              ],
              EH: [
                '212',
                '00',
                '[5-8]\\d{8}',
                [9],
                0,
                '0',
                0,
                0,
                0,
                0,
                '528[89]',
              ],
              ER: [
                '291',
                '00',
                '[178]\\d{6}',
                [7],
                [['(\\d)(\\d{3})(\\d{3})', '$1 $2 $3', ['[178]'], '0$1']],
                '0',
              ],
              ES: [
                '34',
                '00',
                '[5-9]\\d{8}',
                [9],
                [
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[89]00']],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[5-9]'],
                  ],
                ],
              ],
              ET: [
                '251',
                '00',
                '(?:11|[2-579]\\d)\\d{7}',
                [9],
                [['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[1-579]'], '0$1']],
                '0',
              ],
              FI: [
                '358',
                '00|99(?:[01469]|5(?:[14]1|3[23]|5[59]|77|88|9[09]))',
                '[1-35689]\\d{4}|7\\d{10,11}|(?:[124-7]\\d|3[0-46-9])\\d{8}|[1-9]\\d{5,8}',
                [5, 6, 7, 8, 9, 10, 11, 12],
                [
                  [
                    '(\\d)(\\d{4,9})',
                    '$1 $2',
                    ['[2568][1-8]|3(?:0[1-9]|[1-9])|9'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{3,7})',
                    '$1 $2',
                    ['[12]00|[368]|70[07-9]'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{4,8})', '$1 $2', ['[1245]|7[135]'], '0$1'],
                  ['(\\d{2})(\\d{6,10})', '$1 $2', ['7'], '0$1'],
                ],
                '0',
                0,
                0,
                0,
                0,
                '1[03-79]|[2-9]',
                0,
                '00',
              ],
              FJ: [
                '679',
                '0(?:0|52)',
                '45\\d{5}|(?:0800\\d|[235-9])\\d{6}',
                [7, 11],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[235-9]|45']],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['0']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              FK: ['500', '00', '[2-7]\\d{4}', [5]],
              FM: [
                '691',
                '00',
                '(?:[39]\\d\\d|820)\\d{4}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[389]']]],
              ],
              FO: [
                '298',
                '00',
                '[2-9]\\d{5}',
                [6],
                [['(\\d{6})', '$1', ['[2-9]']]],
                0,
                0,
                '(10(?:01|[12]0|88))',
              ],
              FR: [
                '33',
                '00',
                '[1-9]\\d{8}',
                [9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '0 $1',
                  ],
                  [
                    '(\\d)(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4 $5',
                    ['[1-79]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              GA: [
                '241',
                '00',
                '(?:[067]\\d|11)\\d{6}|[2-7]\\d{6}',
                [7, 8],
                [
                  [
                    '(\\d)(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[2-7]'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['0']],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['11|[67]'],
                    '0$1',
                  ],
                ],
                0,
                0,
                '0(11\\d{6}|60\\d{6}|61\\d{6}|6[256]\\d{6}|7[467]\\d{6})',
                '$1',
              ],
              GB: [
                '44',
                '00',
                '[1-357-9]\\d{9}|[18]\\d{8}|8\\d{6}',
                [7, 9, 10],
                [
                  [
                    '(\\d{3})(\\d{4})',
                    '$1 $2',
                    ['800', '8001', '80011', '800111', '8001111'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3',
                    ['845', '8454', '84546', '845464'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{6})', '$1 $2', ['800'], '0$1'],
                  [
                    '(\\d{5})(\\d{4,5})',
                    '$1 $2',
                    [
                      '1(?:38|5[23]|69|76|94)',
                      '1(?:(?:38|69)7|5(?:24|39)|768|946)',
                      '1(?:3873|5(?:242|39[4-6])|(?:697|768)[347]|9467)',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{4})(\\d{5,6})',
                    '$1 $2',
                    ['1(?:[2-69][02-9]|[78])'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{4})(\\d{4})',
                    '$1 $2 $3',
                    ['[25]|7(?:0|6[02-9])', '[25]|7(?:0|6(?:[03-9]|2[356]))'],
                    '0$1',
                  ],
                  ['(\\d{4})(\\d{6})', '$1 $2', ['7'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['[1389]'], '0$1'],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                [
                  [
                    '(?:1(?:1(?:3(?:[0-58]\\d\\d|73[0235])|4(?:[0-5]\\d\\d|69[7-9]|70[01359])|(?:5[0-26-9]|[78][0-49])\\d\\d|6(?:[0-4]\\d\\d|50[0-79]))|2(?:(?:0[024-9]|2[3-9]|3[3-79]|4[1-689]|[58][02-9]|6[0-47-9]|7[013-9]|9\\d)\\d\\d|1(?:[0-7]\\d\\d|8(?:[02]\\d|1[0-26-9])))|(?:3(?:0\\d|1[0-8]|[25][02-9]|3[02-579]|[468][0-46-9]|7[1-35-79]|9[2-578])|4(?:0[03-9]|[137]\\d|[28][02-57-9]|4[02-69]|5[0-8]|[69][0-79])|5(?:0[1-35-9]|[16]\\d|2[024-9]|3[015689]|4[02-9]|5[03-9]|7[0-35-9]|8[0-468]|9[0-57-9])|6(?:0[034689]|1\\d|2[0-35689]|[38][013-9]|4[1-467]|5[0-69]|6[13-9]|7[0-8]|9[0-24578])|7(?:0[0246-9]|2\\d|3[0236-8]|4[03-9]|5[0-46-9]|6[013-9]|7[0-35-9]|8[024-9]|9[02-9])|8(?:0[35-9]|2[1-57-9]|3[02-578]|4[0-578]|5[124-9]|6[2-69]|7\\d|8[02-9]|9[02569])|9(?:0[02-589]|[18]\\d|2[02-689]|3[1-57-9]|4[2-9]|5[0-579]|6[2-47-9]|7[0-24578]|9[2-57]))\\d\\d)|2(?:0[013478]|3[0189]|4[017]|8[0-46-9]|9[0-2])\\d{3})\\d{4}|1(?:2(?:0(?:46[1-4]|87[2-9])|545[1-79]|76(?:2\\d|3[1-8]|6[1-6])|9(?:7(?:2[0-4]|3[2-5])|8(?:2[2-8]|7[0-47-9]|8[3-5])))|3(?:6(?:38[2-5]|47[23])|8(?:47[04-9]|64[0157-9]))|4(?:044[1-7]|20(?:2[23]|8\\d)|6(?:0(?:30|5[2-57]|6[1-8]|7[2-8])|140)|8(?:052|87[1-3]))|5(?:2(?:4(?:3[2-79]|6\\d)|76\\d)|6(?:26[06-9]|686))|6(?:06(?:4\\d|7[4-79])|295[5-7]|35[34]\\d|47(?:24|61)|59(?:5[08]|6[67]|74)|9(?:55[0-4]|77[23]))|7(?:26(?:6[13-9]|7[0-7])|(?:442|688)\\d|50(?:2[0-3]|[3-68]2|76))|8(?:27[56]\\d|37(?:5[2-5]|8[239])|843[2-58])|9(?:0(?:0(?:6[1-8]|85)|52\\d)|3583|4(?:66[1-8]|9(?:2[01]|81))|63(?:23|3[1-4])|9561))\\d{3}',
                    [9, 10],
                  ],
                  [
                    '7(?:457[0-57-9]|700[01]|911[028])\\d{5}|7(?:[1-3]\\d\\d|4(?:[0-46-9]\\d|5[0-689])|5(?:0[0-8]|[13-9]\\d|2[0-35-9])|7(?:0[1-9]|[1-7]\\d|8[02-9]|9[0-689])|8(?:[014-9]\\d|[23][0-8])|9(?:[024-9]\\d|1[02-9]|3[0-689]))\\d{6}',
                    [10],
                  ],
                  ['80[08]\\d{7}|800\\d{6}|8001111'],
                  [
                    '(?:8(?:4[2-5]|7[0-3])|9(?:[01]\\d|8[2-49]))\\d{7}|845464\\d',
                    [7, 10],
                  ],
                  ['70\\d{8}', [10]],
                  0,
                  ['(?:3[0347]|55)\\d{8}', [10]],
                  [
                    '76(?:464|652)\\d{5}|76(?:0[0-2]|2[356]|34|4[01347]|5[49]|6[0-369]|77|8[14]|9[139])\\d{6}',
                    [10],
                  ],
                  ['56\\d{8}', [10]],
                ],
                0,
                ' x',
              ],
              GD: [
                '1',
                '011',
                '(?:473|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-9]\\d{6})$',
                '473$1',
                0,
                '473',
              ],
              GE: [
                '995',
                '00',
                '(?:[3-57]\\d\\d|800)\\d{6}',
                [9],
                [
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['70'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['32'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['[57]']],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[348]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              GF: [
                '594',
                '00',
                '(?:[56]94|80\\d|976)\\d{6}',
                [9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[569]'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              GG: [
                '44',
                '00',
                '(?:1481|[357-9]\\d{3})\\d{6}|8\\d{6}(?:\\d{2})?',
                [7, 9, 10],
                0,
                '0',
                0,
                '0|([25-9]\\d{5})$',
                '1481$1',
                0,
                0,
                [
                  ['1481[25-9]\\d{5}', [10]],
                  ['7(?:(?:781|839)\\d|911[17])\\d{5}', [10]],
                  ['80[08]\\d{7}|800\\d{6}|8001111'],
                  [
                    '(?:8(?:4[2-5]|7[0-3])|9(?:[01]\\d|8[0-3]))\\d{7}|845464\\d',
                    [7, 10],
                  ],
                  ['70\\d{8}', [10]],
                  0,
                  ['(?:3[0347]|55)\\d{8}', [10]],
                  [
                    '76(?:464|652)\\d{5}|76(?:0[0-2]|2[356]|34|4[01347]|5[49]|6[0-369]|77|8[14]|9[139])\\d{6}',
                    [10],
                  ],
                  ['56\\d{8}', [10]],
                ],
              ],
              GH: [
                '233',
                '00',
                '(?:[235]\\d{3}|800)\\d{5}',
                [8, 9],
                [
                  ['(\\d{3})(\\d{5})', '$1 $2', ['8'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[235]'], '0$1'],
                ],
                '0',
              ],
              GI: [
                '350',
                '00',
                '(?:[25]\\d\\d|606)\\d{5}',
                [8],
                [['(\\d{3})(\\d{5})', '$1 $2', ['2']]],
              ],
              GL: [
                '299',
                '00',
                '(?:19|[2-689]\\d|70)\\d{4}',
                [6],
                [['(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3', ['19|[2-9]']]],
              ],
              GM: [
                '220',
                '00',
                '[2-9]\\d{6}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[2-9]']]],
              ],
              GN: [
                '224',
                '00',
                '722\\d{6}|(?:3|6\\d)\\d{7}',
                [8, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['3']],
                  ['(\\d{3})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['[67]']],
                ],
              ],
              GP: [
                '590',
                '00',
                '(?:590|(?:69|80)\\d|976)\\d{6}',
                [9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[569]'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '0$1',
                  ],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                [
                  [
                    '590(?:0[1-68]|[14][0-24-9]|2[0-68]|3[1289]|5[3-579]|6[0-289]|7[08]|8[0-689]|9\\d)\\d{4}',
                  ],
                  ['69(?:0\\d\\d|1(?:2[2-9]|3[0-5]))\\d{4}'],
                  ['80[0-5]\\d{6}'],
                  0,
                  0,
                  0,
                  0,
                  0,
                  ['976[01]\\d{5}'],
                ],
              ],
              GQ: [
                '240',
                '00',
                '222\\d{6}|(?:3\\d|55|[89]0)\\d{7}',
                [9],
                [
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[235]']],
                  ['(\\d{3})(\\d{6})', '$1 $2', ['[89]']],
                ],
              ],
              GR: [
                '30',
                '00',
                '5005000\\d{3}|8\\d{9,11}|(?:[269]\\d|70)\\d{8}',
                [10, 11, 12],
                [
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1 $2 $3', ['21|7']],
                  [
                    '(\\d{4})(\\d{6})',
                    '$1 $2',
                    [
                      '2(?:2|3[2-57-9]|4[2-469]|5[2-59]|6[2-9]|7[2-69]|8[2-49])|5',
                    ],
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['[2689]']],
                  ['(\\d{3})(\\d{3,4})(\\d{5})', '$1 $2 $3', ['8']],
                ],
              ],
              GT: [
                '502',
                '00',
                '(?:1\\d{3}|[2-7])\\d{7}',
                [8, 11],
                [
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[2-7]']],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['1']],
                ],
              ],
              GU: [
                '1',
                '011',
                '(?:[58]\\d\\d|671|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([3-9]\\d{6})$',
                '671$1',
                0,
                '671',
              ],
              GW: [
                '245',
                '00',
                '[49]\\d{8}|4\\d{6}',
                [7, 9],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['40']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[49]']],
                ],
              ],
              GY: [
                '592',
                '001',
                '9008\\d{3}|(?:[2-467]\\d\\d|862)\\d{4}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[2-46-9]']]],
              ],
              HK: [
                '852',
                '00(?:30|5[09]|[126-9]?)',
                '8[0-46-9]\\d{6,7}|9\\d{4,7}|(?:[2-7]|9\\d{3})\\d{7}',
                [5, 6, 7, 8, 9, 11],
                [
                  ['(\\d{3})(\\d{2,5})', '$1 $2', ['900', '9003']],
                  [
                    '(\\d{4})(\\d{4})',
                    '$1 $2',
                    ['[2-7]|8[1-4]|9(?:0[1-9]|[1-8])'],
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['8']],
                  ['(\\d{3})(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3 $4', ['9']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              HN: [
                '504',
                '00',
                '8\\d{10}|[237-9]\\d{7}',
                [8, 11],
                [['(\\d{4})(\\d{4})', '$1-$2', ['[237-9]']]],
              ],
              HR: [
                '385',
                '00',
                '(?:[24-69]\\d|3[0-79])\\d{7}|80\\d{5,7}|[1-79]\\d{7}|6\\d{5,6}',
                [6, 7, 8, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{2,3})', '$1 $2 $3', ['6[01]'], '0$1'],
                  ['(\\d{3})(\\d{2})(\\d{2,3})', '$1 $2 $3', ['8'], '0$1'],
                  ['(\\d)(\\d{4})(\\d{3})', '$1 $2 $3', ['1'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[67]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['9'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[2-5]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['8'], '0$1'],
                ],
                '0',
              ],
              HT: [
                '509',
                '00',
                '[2-489]\\d{7}',
                [8],
                [['(\\d{2})(\\d{2})(\\d{4})', '$1 $2 $3', ['[2-489]']]],
              ],
              HU: [
                '36',
                '00',
                '[235-7]\\d{8}|[1-9]\\d{7}',
                [8, 9],
                [
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['1'], '(06 $1)'],
                  [
                    '(\\d{2})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['[27][2-9]|3[2-7]|4[24-9]|5[2-79]|6|8[2-57-9]|9[2-69]'],
                    '(06 $1)',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['[2-9]'],
                    '06 $1',
                  ],
                ],
                '06',
              ],
              ID: [
                '62',
                '00[89]',
                '(?:(?:00[1-9]|8\\d)\\d{4}|[1-36])\\d{6}|00\\d{10}|[1-9]\\d{8,10}|[2-9]\\d{7}',
                [7, 8, 9, 10, 11, 12, 13],
                [
                  ['(\\d)(\\d{3})(\\d{3})', '$1 $2 $3', ['15']],
                  ['(\\d{2})(\\d{5,9})', '$1 $2', ['2[124]|[36]1'], '(0$1)'],
                  ['(\\d{3})(\\d{5,7})', '$1 $2', ['800'], '0$1'],
                  ['(\\d{3})(\\d{5,8})', '$1 $2', ['[2-79]'], '(0$1)'],
                  [
                    '(\\d{3})(\\d{3,4})(\\d{3})',
                    '$1-$2-$3',
                    ['8[1-35-9]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{6,8})', '$1 $2', ['1'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['804'], '0$1'],
                  [
                    '(\\d{3})(\\d)(\\d{3})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['80'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{4})(\\d{4,5})', '$1-$2-$3', ['8'], '0$1'],
                ],
                '0',
              ],
              IE: [
                '353',
                '00',
                '(?:1\\d|[2569])\\d{6,8}|4\\d{6,9}|7\\d{8}|8\\d{8,9}',
                [7, 8, 9, 10],
                [
                  [
                    '(\\d{2})(\\d{5})',
                    '$1 $2',
                    ['2[24-9]|47|58|6[237-9]|9[35-9]'],
                    '(0$1)',
                  ],
                  ['(\\d{3})(\\d{5})', '$1 $2', ['[45]0'], '(0$1)'],
                  ['(\\d)(\\d{3,4})(\\d{4})', '$1 $2 $3', ['1'], '(0$1)'],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['[2569]|4[1-69]|7[14]'],
                    '(0$1)',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['70'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['81'], '(0$1)'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[78]'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1 $2 $3', ['1']],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1 $2 $3', ['4'], '(0$1)'],
                  [
                    '(\\d{2})(\\d)(\\d{3})(\\d{4})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              IL: [
                '972',
                '0(?:0|1[2-9])',
                '1\\d{6}(?:\\d{3,5})?|[57]\\d{8}|[1-489]\\d{7}',
                [7, 8, 9, 10, 11, 12],
                [
                  ['(\\d{4})(\\d{3})', '$1-$2', ['125']],
                  ['(\\d{4})(\\d{2})(\\d{2})', '$1-$2-$3', ['121']],
                  ['(\\d)(\\d{3})(\\d{4})', '$1-$2-$3', ['[2-489]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1-$2-$3', ['[57]'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1-$2-$3', ['12']],
                  ['(\\d{4})(\\d{6})', '$1-$2', ['159']],
                  ['(\\d)(\\d{3})(\\d{3})(\\d{3})', '$1-$2-$3-$4', ['1[7-9]']],
                  ['(\\d{3})(\\d{1,2})(\\d{3})(\\d{4})', '$1-$2 $3-$4', ['15']],
                ],
                '0',
              ],
              IM: [
                '44',
                '00',
                '1624\\d{6}|(?:[3578]\\d|90)\\d{8}',
                [10],
                0,
                '0',
                0,
                '0|([25-8]\\d{5})$',
                '1624$1',
                0,
                '74576|(?:16|7[56])24',
              ],
              IN: [
                '91',
                '00',
                '(?:000800|[2-9]\\d\\d)\\d{7}|1\\d{7,12}',
                [8, 9, 10, 11, 12, 13],
                [
                  [
                    '(\\d{8})',
                    '$1',
                    [
                      '5(?:0|2[23]|3[03]|[67]1|88)',
                      '5(?:0|2(?:21|3)|3(?:0|3[23])|616|717|888)',
                      '5(?:0|2(?:21|3)|3(?:0|3[23])|616|717|8888)',
                    ],
                    0,
                    1,
                  ],
                  ['(\\d{4})(\\d{4,5})', '$1 $2', ['180', '1800'], 0, 1],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['140'], 0, 1],
                  [
                    '(\\d{2})(\\d{4})(\\d{4})',
                    '$1 $2 $3',
                    [
                      '11|2[02]|33|4[04]|79[1-7]|80[2-46]',
                      '11|2[02]|33|4[04]|79(?:[1-6]|7[19])|80(?:[2-4]|6[0-589])',
                      '11|2[02]|33|4[04]|79(?:[124-6]|3(?:[02-9]|1[0-24-9])|7(?:1|9[1-6]))|80(?:[2-4]|6[0-589])',
                    ],
                    '0$1',
                    1,
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    [
                      '1(?:2[0-249]|3[0-25]|4[145]|[68]|7[1257])|2(?:1[257]|3[013]|4[01]|5[0137]|6[0158]|78|8[1568])|3(?:26|4[1-3]|5[34]|6[01489]|7[02-46]|8[159])|4(?:1[36]|2[1-47]|5[12]|6[0-26-9]|7[0-24-9]|8[013-57]|9[014-7])|5(?:1[025]|22|[36][25]|4[28]|5[12]|[78]1)|6(?:12|[2-4]1|5[17]|6[13]|80)|7(?:12|3[134]|4[47]|61|88)|8(?:16|2[014]|3[126]|6[136]|7[078]|8[34]|91)|(?:43|59|75)[15]|(?:1[59]|29|67|72)[14]',
                      '1(?:2[0-24]|3[0-25]|4[145]|[59][14]|6[1-9]|7[1257]|8[1-57-9])|2(?:1[257]|3[013]|4[01]|5[0137]|6[058]|78|8[1568]|9[14])|3(?:26|4[1-3]|5[34]|6[01489]|7[02-46]|8[159])|4(?:1[36]|2[1-47]|3[15]|5[12]|6[0-26-9]|7[0-24-9]|8[013-57]|9[014-7])|5(?:1[025]|22|[36][25]|4[28]|[578]1|9[15])|674|7(?:(?:2[14]|3[34]|5[15])[2-6]|61[346]|88[0-8])|8(?:70[2-6]|84[235-7]|91[3-7])|(?:1(?:29|60|8[06])|261|552|6(?:12|[2-47]1|5[17]|6[13]|80)|7(?:12|31|4[47])|8(?:16|2[014]|3[126]|6[136]|7[78]|83))[2-7]',
                      '1(?:2[0-24]|3[0-25]|4[145]|[59][14]|6[1-9]|7[1257]|8[1-57-9])|2(?:1[257]|3[013]|4[01]|5[0137]|6[058]|78|8[1568]|9[14])|3(?:26|4[1-3]|5[34]|6[01489]|7[02-46]|8[159])|4(?:1[36]|2[1-47]|3[15]|5[12]|6[0-26-9]|7[0-24-9]|8[013-57]|9[014-7])|5(?:1[025]|22|[36][25]|4[28]|[578]1|9[15])|6(?:12(?:[2-6]|7[0-8])|74[2-7])|7(?:(?:2[14]|5[15])[2-6]|3171|61[346]|88(?:[2-7]|82))|8(?:70[2-6]|84(?:[2356]|7[19])|91(?:[3-6]|7[19]))|73[134][2-6]|(?:74[47]|8(?:16|2[014]|3[126]|6[136]|7[78]|83))(?:[2-6]|7[19])|(?:1(?:29|60|8[06])|261|552|6(?:[2-4]1|5[17]|6[13]|7(?:1|4[0189])|80)|7(?:12|88[01]))[2-7]',
                    ],
                    '0$1',
                    1,
                  ],
                  [
                    '(\\d{4})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    [
                      '1(?:[2-479]|5[0235-9])|[2-5]|6(?:1[1358]|2[2457-9]|3[2-5]|4[235-7]|5[2-689]|6[24578]|7[235689]|8[1-6])|7(?:1[013-9]|28|3[129]|4[1-35689]|5[29]|6[02-5]|70)|807',
                      '1(?:[2-479]|5[0235-9])|[2-5]|6(?:1[1358]|2(?:[2457]|84|95)|3(?:[2-4]|55)|4[235-7]|5[2-689]|6[24578]|7[235689]|8[1-6])|7(?:1(?:[013-8]|9[6-9])|28[6-8]|3(?:17|2[0-49]|9[2-57])|4(?:1[2-4]|[29][0-7]|3[0-8]|[56]|8[0-24-7])|5(?:2[1-3]|9[0-6])|6(?:0[5689]|2[5-9]|3[02-8]|4|5[0-367])|70[13-7])|807[19]',
                      '1(?:[2-479]|5(?:[0236-9]|5[013-9]))|[2-5]|6(?:2(?:84|95)|355|83)|73179|807(?:1|9[1-3])|(?:1552|6(?:1[1358]|2[2457]|3[2-4]|4[235-7]|5[2-689]|6[24578]|7[235689]|8[124-6])\\d|7(?:1(?:[013-8]\\d|9[6-9])|28[6-8]|3(?:2[0-49]|9[2-57])|4(?:1[2-4]|[29][0-7]|3[0-8]|[56]\\d|8[0-24-7])|5(?:2[1-3]|9[0-6])|6(?:0[5689]|2[5-9]|3[02-8]|4\\d|5[0-367])|70[13-7]))[2-7]',
                    ],
                    '0$1',
                    1,
                  ],
                  ['(\\d{5})(\\d{5})', '$1 $2', ['[6-9]'], '0$1', 1],
                  [
                    '(\\d{4})(\\d{2,4})(\\d{4})',
                    '$1 $2 $3',
                    ['1(?:6|8[06])', '1(?:6|8[06]0)'],
                    0,
                    1,
                  ],
                  [
                    '(\\d{4})(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['18'],
                    0,
                    1,
                  ],
                ],
                '0',
              ],
              IO: [
                '246',
                '00',
                '3\\d{6}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['3']]],
              ],
              IQ: [
                '964',
                '00',
                '(?:1|7\\d\\d)\\d{7}|[2-6]\\d{7,8}',
                [8, 9, 10],
                [
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['1'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[2-6]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['7'], '0$1'],
                ],
                '0',
              ],
              IR: [
                '98',
                '00',
                '[1-9]\\d{9}|(?:[1-8]\\d\\d|9)\\d{3,4}',
                [4, 5, 6, 7, 10],
                [
                  ['(\\d{4,5})', '$1', ['96'], '0$1'],
                  [
                    '(\\d{2})(\\d{4,5})',
                    '$1 $2',
                    [
                      '(?:1[137]|2[13-68]|3[1458]|4[145]|5[1468]|6[16]|7[1467]|8[13467])[12689]',
                    ],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['9'], '0$1'],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1 $2 $3', ['[1-8]'], '0$1'],
                ],
                '0',
              ],
              IS: [
                '354',
                '00|1(?:0(?:01|[12]0)|100)',
                '(?:38\\d|[4-9])\\d{6}',
                [7, 9],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[4-9]']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['3']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              IT: [
                '39',
                '00',
                '0\\d{5,10}|1\\d{8,10}|3(?:[0-8]\\d{7,10}|9\\d{7,8})|(?:55|70)\\d{8}|8\\d{5}(?:\\d{2,4})?',
                [6, 7, 8, 9, 10, 11],
                [
                  ['(\\d{2})(\\d{4,6})', '$1 $2', ['0[26]']],
                  [
                    '(\\d{3})(\\d{3,6})',
                    '$1 $2',
                    [
                      '0[13-57-9][0159]|8(?:03|4[17]|9[2-5])',
                      '0[13-57-9][0159]|8(?:03|4[17]|9(?:2|3[04]|[45][0-4]))',
                    ],
                  ],
                  [
                    '(\\d{4})(\\d{2,6})',
                    '$1 $2',
                    ['0(?:[13-579][2-46-8]|8[236-8])'],
                  ],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['894']],
                  ['(\\d{2})(\\d{3,4})(\\d{4})', '$1 $2 $3', ['0[26]|5']],
                  [
                    '(\\d{3})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['1(?:44|[679])|[378]'],
                  ],
                  [
                    '(\\d{3})(\\d{3,4})(\\d{4})',
                    '$1 $2 $3',
                    ['0[13-57-9][0159]|14'],
                  ],
                  ['(\\d{2})(\\d{4})(\\d{5})', '$1 $2 $3', ['0[26]']],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['0']],
                  ['(\\d{3})(\\d{4})(\\d{4,5})', '$1 $2 $3', ['3']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                [
                  [
                    '0669[0-79]\\d{1,6}|0(?:1(?:[0159]\\d|[27][1-5]|31|4[1-4]|6[1356]|8[2-57])|2\\d\\d|3(?:[0159]\\d|2[1-4]|3[12]|[48][1-6]|6[2-59]|7[1-7])|4(?:[0159]\\d|[23][1-9]|4[245]|6[1-5]|7[1-4]|81)|5(?:[0159]\\d|2[1-5]|3[2-6]|4[1-79]|6[4-6]|7[1-578]|8[3-8])|6(?:[0-57-9]\\d|6[0-8])|7(?:[0159]\\d|2[12]|3[1-7]|4[2-46]|6[13569]|7[13-6]|8[1-59])|8(?:[0159]\\d|2[3-578]|3[1-356]|[6-8][1-5])|9(?:[0159]\\d|[238][1-5]|4[12]|6[1-8]|7[1-6]))\\d{2,7}',
                  ],
                  ['3[1-9]\\d{8}|3[2-9]\\d{7}', [9, 10]],
                  ['80(?:0\\d{3}|3)\\d{3}', [6, 9]],
                  [
                    '(?:0878\\d{3}|89(?:2\\d|3[04]|4(?:[0-4]|[5-9]\\d\\d)|5[0-4]))\\d\\d|(?:1(?:44|6[346])|89(?:38|5[5-9]|9))\\d{6}',
                    [6, 8, 9, 10],
                  ],
                  ['1(?:78\\d|99)\\d{6}', [9, 10]],
                  0,
                  0,
                  0,
                  ['55\\d{8}', [10]],
                  ['84(?:[08]\\d{3}|[17])\\d{3}', [6, 9]],
                ],
              ],
              JE: [
                '44',
                '00',
                '1534\\d{6}|(?:[3578]\\d|90)\\d{8}',
                [10],
                0,
                '0',
                0,
                '0|([0-24-8]\\d{5})$',
                '1534$1',
                0,
                0,
                [
                  ['1534[0-24-8]\\d{5}'],
                  ['7(?:(?:(?:50|82)9|937)\\d|7(?:00[378]|97[7-9]))\\d{5}'],
                  ['80(?:07(?:35|81)|8901)\\d{4}'],
                  [
                    '(?:8(?:4(?:4(?:4(?:05|42|69)|703)|5(?:041|800))|7(?:0002|1206))|90(?:066[59]|1810|71(?:07|55)))\\d{4}',
                  ],
                  ['701511\\d{4}'],
                  0,
                  [
                    '(?:3(?:0(?:07(?:35|81)|8901)|3\\d{4}|4(?:4(?:4(?:05|42|69)|703)|5(?:041|800))|7(?:0002|1206))|55\\d{4})\\d{4}',
                  ],
                  [
                    '76(?:464|652)\\d{5}|76(?:0[0-2]|2[356]|34|4[01347]|5[49]|6[0-369]|77|8[14]|9[139])\\d{6}',
                  ],
                  ['56\\d{8}'],
                ],
              ],
              JM: [
                '1',
                '011',
                '(?:[58]\\d\\d|658|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                0,
                0,
                0,
                '658|876',
              ],
              JO: [
                '962',
                '00',
                '(?:(?:[2689]|7\\d)\\d|32|53)\\d{6}',
                [8, 9],
                [
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['[2356]|87'], '(0$1)'],
                  ['(\\d{3})(\\d{5,6})', '$1 $2', ['[89]'], '0$1'],
                  ['(\\d{2})(\\d{7})', '$1 $2', ['70'], '0$1'],
                  ['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['7'], '0$1'],
                ],
                '0',
              ],
              JP: [
                '81',
                '010',
                '00[1-9]\\d{6,14}|[257-9]\\d{9}|(?:00|[1-9]\\d\\d)\\d{6}',
                [8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                [
                  [
                    '(\\d{3})(\\d{3})(\\d{3})',
                    '$1-$2-$3',
                    ['(?:12|57|99)0'],
                    '0$1',
                  ],
                  [
                    '(\\d{4})(\\d)(\\d{4})',
                    '$1-$2-$3',
                    [
                      '1(?:26|3[79]|4[56]|5[4-68]|6[3-5])|499|5(?:76|97)|746|8(?:3[89]|47|51|63)|9(?:80|9[16])',
                      '1(?:267|3(?:7[247]|9[278])|466|5(?:47|58|64)|6(?:3[245]|48|5[4-68]))|499[2468]|5(?:76|97)9|7468|8(?:3(?:8[7-9]|96)|477|51[2-9]|636)|9(?:802|9(?:1[23]|69))|1(?:45|58)[67]',
                      '1(?:267|3(?:7[247]|9[278])|466|5(?:47|58|64)|6(?:3[245]|48|5[4-68]))|499[2468]|5(?:769|979[2-69])|7468|8(?:3(?:8[7-9]|96[2457-9])|477|51[2-9]|636[457-9])|9(?:802|9(?:1[23]|69))|1(?:45|58)[67]',
                    ],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1-$2-$3', ['60'], '0$1'],
                  [
                    '(\\d)(\\d{4})(\\d{4})',
                    '$1-$2-$3',
                    [
                      '[36]|4(?:2[09]|7[01])',
                      '[36]|4(?:2(?:0|9[02-69])|7(?:0[019]|1))',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{4})',
                    '$1-$2-$3',
                    [
                      '1(?:1|5[45]|77|88|9[69])|2(?:2[1-37]|3[0-269]|4[59]|5|6[24]|7[1-358]|8[1369]|9[0-38])|4(?:[28][1-9]|3[0-57]|[45]|6[248]|7[2-579]|9[29])|5(?:2|3[045]|4[0-369]|5[29]|8[02389]|9[0-389])|7(?:2[02-46-9]|34|[58]|6[0249]|7[57]|9[2-6])|8(?:2[124589]|3[27-9]|49|51|6|7[0-468]|8[68]|9[019])|9(?:[23][1-9]|4[15]|5[138]|6[1-3]|7[156]|8[189]|9[1-489])',
                      '1(?:1|5(?:4[018]|5[017])|77|88|9[69])|2(?:2(?:[127]|3[014-9])|3[0-269]|4[59]|5(?:[1-3]|5[0-69]|9[19])|62|7(?:[1-35]|8[0189])|8(?:[16]|3[0134]|9[0-5])|9(?:[028]|17))|4(?:2(?:[13-79]|8[014-6])|3[0-57]|[45]|6[248]|7[2-47]|8[1-9])|5(?:2|3[045]|4[0-369]|8[02389]|9[0-3])|7(?:2[02-46-9]|34|[58]|6[0249]|7[57]|9(?:[23]|4[0-59]|5[01569]|6[0167]))|8(?:2(?:[1258]|4[0-39]|9[0-2469])|49|51|6(?:[0-24]|36|5[0-3589]|72|9[01459])|7[0-468]|8[68])|9(?:[23][1-9]|4[15]|5[138]|6[1-3]|7[156]|8[189]|9(?:[1289]|3[34]|4[0178]))|(?:49|55|83)[29]|(?:264|837)[016-9]|2(?:57|93)[015-9]|(?:25[0468]|422|838)[01]|(?:47[59]|59[89]|8(?:6[68]|9))[019]',
                      '1(?:1|5(?:4[018]|5[017])|77|88|9[69])|2(?:2[127]|3[0-269]|4[59]|5(?:[1-3]|5[0-69]|9(?:17|99))|6(?:2|4[016-9])|7(?:[1-35]|8[0189])|8(?:[16]|3[0134]|9[0-5])|9(?:[028]|17))|4(?:2(?:[13-79]|8[014-6])|3[0-57]|[45]|6[248]|7[2-47]|9[29])|5(?:2|3[045]|4[0-369]|5[29]|8[02389]|9[0-3])|7(?:2[02-46-9]|34|[58]|6[0249]|7[57]|9(?:[23]|4[0-59]|5[01569]|6[0167]))|8(?:2(?:[1258]|4[0-39]|9[0169])|3(?:[29]|7(?:[017-9]|6[6-8]))|49|51|6(?:[0-24]|36[23]|5(?:[0-389]|5[23])|6(?:[01]|9[178])|72|9[0145])|7[0-468]|8[68])|9(?:4[15]|5[138]|7[156]|8[189]|9(?:[1289]|3(?:31|4[357])|4[0178]))|(?:8294|96)[1-3]|2(?:57|93)[015-9]|(?:223|8699)[014-9]|(?:25[0468]|422|838)[01]|(?:48|8292|9[23])[1-9]|(?:47[59]|59[89]|8(?:68|9))[019]',
                      '1(?:1|5(?:4[018]|5[017])|77|88|9[69])|2(?:2[127]|3[0-269]|4[59]|5(?:[1-3]|5[0-69]|7[015-9]|9(?:17|99))|6(?:2|4[016-9])|7(?:[1-35]|8[0189])|8(?:[16]|3[0134]|9[0-5])|9(?:[028]|17|3[015-9]))|4(?:2(?:[13-79]|8[014-6])|3[0-57]|[45]|6[248]|7[2-47]|9[29])|5(?:2|3[045]|4[0-369]|5[29]|8[02389]|9[0-3])|7(?:2[02-46-9]|34|[58]|6[0249]|7[57]|9(?:[23]|4[0-59]|5[01569]|6[0167]))|8(?:2(?:[1258]|4[0-39]|9(?:[019]|4[1-3]|6(?:[0-47-9]|5[01346-9])))|3(?:[29]|7(?:[017-9]|6[6-8]))|49|51|6(?:[0-24]|36[23]|5(?:[0-389]|5[23])|6(?:[01]|9[178])|72|9[0145])|7[0-468]|8[68])|9(?:4[15]|5[138]|6[1-3]|7[156]|8[189]|9(?:[1289]|3(?:31|4[357])|4[0178]))|(?:223|8699)[014-9]|(?:25[0468]|422|838)[01]|(?:48|829(?:2|66)|9[23])[1-9]|(?:47[59]|59[89]|8(?:68|9))[019]',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{4})',
                    '$1-$2-$3',
                    ['[14]|[289][2-9]|5[3-9]|7[2-4679]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1-$2-$3', ['800'], '0$1'],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1-$2-$3', ['[257-9]'], '0$1'],
                ],
                '0',
              ],
              KE: [
                '254',
                '000',
                '(?:[17]\\d\\d|900)\\d{6}|(?:2|80)0\\d{6,7}|[4-6]\\d{6,8}',
                [7, 8, 9, 10],
                [
                  ['(\\d{2})(\\d{5,7})', '$1 $2', ['[24-6]'], '0$1'],
                  ['(\\d{3})(\\d{6})', '$1 $2', ['[17]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[89]'], '0$1'],
                ],
                '0',
              ],
              KG: [
                '996',
                '00',
                '8\\d{9}|(?:[235-8]\\d|99)\\d{7}',
                [9, 10],
                [
                  ['(\\d{4})(\\d{5})', '$1 $2', ['3(?:1[346]|[24-79])'], '0$1'],
                  [
                    '(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['[235-79]|88'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d)(\\d{2,3})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              KH: [
                '855',
                '00[14-9]',
                '1\\d{9}|[1-9]\\d{7,8}',
                [8, 9, 10],
                [
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[1-9]'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1 $2 $3', ['1']],
                ],
                '0',
              ],
              KI: [
                '686',
                '00',
                '(?:[37]\\d|6[0-79])\\d{6}|(?:[2-48]\\d|50)\\d{3}',
                [5, 8],
                0,
                '0',
              ],
              KM: [
                '269',
                '00',
                '[3478]\\d{6}',
                [7],
                [['(\\d{3})(\\d{2})(\\d{2})', '$1 $2 $3', ['[3478]']]],
              ],
              KN: [
                '1',
                '011',
                '(?:[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-7]\\d{6})$',
                '869$1',
                0,
                '869',
              ],
              KP: [
                '850',
                '00|99',
                '85\\d{6}|(?:19\\d|[2-7])\\d{7}',
                [8, 10],
                [
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['8'], '0$1'],
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['[2-7]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['1'], '0$1'],
                ],
                '0',
              ],
              KR: [
                '82',
                '00(?:[125689]|3(?:[46]5|91)|7(?:00|27|3|55|6[126]))',
                '00[1-9]\\d{8,11}|(?:[12]|5\\d{3})\\d{7}|[13-6]\\d{9}|(?:[1-6]\\d|80)\\d{7}|[3-6]\\d{4,5}|(?:00|7)0\\d{8}',
                [5, 6, 8, 9, 10, 11, 12, 13, 14],
                [
                  [
                    '(\\d{2})(\\d{3,4})',
                    '$1-$2',
                    ['(?:3[1-3]|[46][1-4]|5[1-5])1'],
                    '0$1',
                  ],
                  ['(\\d{4})(\\d{4})', '$1-$2', ['1']],
                  ['(\\d)(\\d{3,4})(\\d{4})', '$1-$2-$3', ['2'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1-$2-$3', ['60|8'], '0$1'],
                  [
                    '(\\d{2})(\\d{3,4})(\\d{4})',
                    '$1-$2-$3',
                    ['[1346]|5[1-5]'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1-$2-$3', ['[57]'], '0$1'],
                  ['(\\d{2})(\\d{5})(\\d{4})', '$1-$2-$3', ['5'], '0$1'],
                ],
                '0',
                0,
                '0(8(?:[1-46-8]|5\\d\\d))?',
              ],
              KW: [
                '965',
                '00',
                '18\\d{5}|(?:[2569]\\d|41)\\d{6}',
                [7, 8],
                [
                  [
                    '(\\d{4})(\\d{3,4})',
                    '$1 $2',
                    ['[169]|2(?:[235]|4[1-35-9])|52'],
                  ],
                  ['(\\d{3})(\\d{5})', '$1 $2', ['[245]']],
                ],
              ],
              KY: [
                '1',
                '011',
                '(?:345|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-9]\\d{6})$',
                '345$1',
                0,
                '345',
              ],
              KZ: [
                '7',
                '810',
                '(?:33622|8\\d{8})\\d{5}|[78]\\d{9}',
                [10, 14],
                0,
                '8',
                0,
                0,
                0,
                0,
                '33|7',
                0,
                '8~10',
              ],
              LA: [
                '856',
                '00',
                '[23]\\d{9}|3\\d{8}|(?:[235-8]\\d|41)\\d{6}',
                [8, 9, 10],
                [
                  [
                    '(\\d{2})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['2[13]|3[14]|[4-8]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['30[013-9]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{2})(\\d{3})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['[23]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              LB: [
                '961',
                '00',
                '[27-9]\\d{7}|[13-9]\\d{6}',
                [7, 8],
                [
                  [
                    '(\\d)(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['[13-69]|7(?:[2-57]|62|8[0-7]|9[04-9])|8[02-9]'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['[27-9]']],
                ],
                '0',
              ],
              LC: [
                '1',
                '011',
                '(?:[58]\\d\\d|758|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-8]\\d{6})$',
                '758$1',
                0,
                '758',
              ],
              LI: [
                '423',
                '00',
                '[68]\\d{8}|(?:[2378]\\d|90)\\d{5}',
                [7, 9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3',
                    ['[2379]|8(?:0[09]|7)', '[2379]|8(?:0(?:02|9)|7)'],
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['8']],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['69']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['6']],
                ],
                '0',
                0,
                '0|(1001)',
              ],
              LK: [
                '94',
                '00',
                '[1-9]\\d{8}',
                [9],
                [
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['7'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[1-689]'], '0$1'],
                ],
                '0',
              ],
              LR: [
                '231',
                '00',
                '(?:2|33|5\\d|77|88)\\d{7}|[4-6]\\d{6}',
                [7, 8, 9],
                [
                  ['(\\d)(\\d{3})(\\d{3})', '$1 $2 $3', ['[4-6]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['2'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[3578]'], '0$1'],
                ],
                '0',
              ],
              LS: [
                '266',
                '00',
                '(?:[256]\\d\\d|800)\\d{5}',
                [8],
                [['(\\d{4})(\\d{4})', '$1 $2', ['[2568]']]],
              ],
              LT: [
                '370',
                '00',
                '(?:[3469]\\d|52|[78]0)\\d{6}',
                [8],
                [
                  [
                    '(\\d)(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['52[0-7]'],
                    '(8-$1)',
                    1,
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{3})',
                    '$1 $2 $3',
                    ['[7-9]'],
                    '8 $1',
                    1,
                  ],
                  [
                    '(\\d{2})(\\d{6})',
                    '$1 $2',
                    ['37|4(?:[15]|6[1-8])'],
                    '(8-$1)',
                    1,
                  ],
                  ['(\\d{3})(\\d{5})', '$1 $2', ['[3-6]'], '(8-$1)', 1],
                ],
                '8',
                0,
                '[08]',
              ],
              LU: [
                '352',
                '00',
                '35[013-9]\\d{4,8}|6\\d{8}|35\\d{2,4}|(?:[2457-9]\\d|3[0-46-9])\\d{2,9}',
                [4, 5, 6, 7, 8, 9, 10, 11],
                [
                  [
                    '(\\d{2})(\\d{3})',
                    '$1 $2',
                    [
                      '2(?:0[2-689]|[2-9])|[3-57]|8(?:0[2-9]|[13-9])|9(?:0[89]|[2-579])',
                    ],
                  ],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3',
                    [
                      '2(?:0[2-689]|[2-9])|[3-57]|8(?:0[2-9]|[13-9])|9(?:0[89]|[2-579])',
                    ],
                  ],
                  ['(\\d{2})(\\d{2})(\\d{3})', '$1 $2 $3', ['20[2-689]']],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{1,2})',
                    '$1 $2 $3 $4',
                    ['2(?:[0367]|4[3-8])'],
                  ],
                  ['(\\d{3})(\\d{2})(\\d{3})', '$1 $2 $3', ['80[01]|90[015]']],
                  ['(\\d{2})(\\d{2})(\\d{2})(\\d{3})', '$1 $2 $3 $4', ['20']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['6']],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})(\\d{1,2})',
                    '$1 $2 $3 $4 $5',
                    ['2(?:[0367]|4[3-8])'],
                  ],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{1,5})',
                    '$1 $2 $3 $4',
                    ['[3-57]|8[13-9]|9(?:0[89]|[2-579])|(?:2|80)[2-9]'],
                  ],
                ],
                0,
                0,
                '(15(?:0[06]|1[12]|[35]5|4[04]|6[26]|77|88|99)\\d)',
              ],
              LV: [
                '371',
                '00',
                '(?:[268]\\d|90)\\d{6}',
                [8],
                [['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['[269]|8[01]']]],
              ],
              LY: [
                '218',
                '00',
                '[2-9]\\d{8}',
                [9],
                [['(\\d{2})(\\d{7})', '$1-$2', ['[2-9]'], '0$1']],
                '0',
              ],
              MA: [
                '212',
                '00',
                '[5-8]\\d{8}',
                [9],
                [
                  [
                    '(\\d{5})(\\d{4})',
                    '$1-$2',
                    ['5(?:29|38)', '5(?:29[89]|389)', '5(?:29[89]|389)0'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['5[45]'],
                    '0$1',
                  ],
                  [
                    '(\\d{4})(\\d{5})',
                    '$1-$2',
                    [
                      '5(?:2[2-489]|3[5-9]|9)|892',
                      '5(?:2(?:[2-49]|8[235-9])|3[5-9]|9)|892',
                    ],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{7})', '$1-$2', ['8'], '0$1'],
                  ['(\\d{3})(\\d{6})', '$1-$2', ['[5-7]'], '0$1'],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                [
                  [
                    '5(?:29(?:[189][05]|2[29]|3[01])|389[05])\\d{4}|5(?:2(?:[0-25-7]\\d|3[1-578]|4[02-46-8]|8[0235-7]|90)|3(?:[0-47]\\d|5[02-9]|6[02-8]|8[08]|9[3-9])|(?:4[067]|5[03])\\d)\\d{5}',
                  ],
                  [
                    '(?:6(?:[0-79]\\d|8[0-247-9])|7(?:[017]\\d|2[0-2]|6[0-8]))\\d{6}',
                  ],
                  ['80\\d{7}'],
                  ['89\\d{7}'],
                  0,
                  0,
                  0,
                  0,
                  ['592(?:4[0-2]|93)\\d{4}'],
                ],
              ],
              MC: [
                '377',
                '00',
                '(?:[3489]|6\\d)\\d{7}',
                [8, 9],
                [
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['4'], '0$1'],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[389]'],
                  ],
                  [
                    '(\\d)(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4 $5',
                    ['6'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              MD: [
                '373',
                '00',
                '(?:[235-7]\\d|[89]0)\\d{6}',
                [8],
                [
                  ['(\\d{3})(\\d{5})', '$1 $2', ['[89]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['22|3'], '0$1'],
                  ['(\\d{3})(\\d{2})(\\d{3})', '$1 $2 $3', ['[25-7]'], '0$1'],
                ],
                '0',
              ],
              ME: [
                '382',
                '00',
                '(?:20|[3-79]\\d)\\d{6}|80\\d{6,7}',
                [8, 9],
                [['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[2-9]'], '0$1']],
                '0',
              ],
              MF: [
                '590',
                '00',
                '(?:590|(?:69|80)\\d|976)\\d{6}',
                [9],
                0,
                '0',
                0,
                0,
                0,
                0,
                0,
                [
                  ['590(?:0[079]|[14]3|[27][79]|30|5[0-268]|87)\\d{4}'],
                  ['69(?:0\\d\\d|1(?:2[2-9]|3[0-5]))\\d{4}'],
                  ['80[0-5]\\d{6}'],
                  0,
                  0,
                  0,
                  0,
                  0,
                  ['976[01]\\d{5}'],
                ],
              ],
              MG: [
                '261',
                '00',
                '[23]\\d{8}',
                [9],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{3})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[23]'],
                    '0$1',
                  ],
                ],
                '0',
                0,
                '0|([24-9]\\d{6})$',
                '20$1',
              ],
              MH: [
                '692',
                '011',
                '329\\d{4}|(?:[256]\\d|45)\\d{5}',
                [7],
                [['(\\d{3})(\\d{4})', '$1-$2', ['[2-6]']]],
                '1',
              ],
              MK: [
                '389',
                '00',
                '[2-578]\\d{7}',
                [8],
                [
                  [
                    '(\\d)(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['2|34[47]|4(?:[37]7|5[47]|64)'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['[347]'], '0$1'],
                  [
                    '(\\d{3})(\\d)(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[58]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              ML: [
                '223',
                '00',
                '[24-9]\\d{7}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[24-9]'],
                  ],
                ],
              ],
              MM: [
                '95',
                '00',
                '1\\d{5,7}|95\\d{6}|(?:[4-7]|9[0-46-9])\\d{6,8}|(?:2|8\\d)\\d{5,8}',
                [6, 7, 8, 9, 10],
                [
                  ['(\\d)(\\d{2})(\\d{3})', '$1 $2 $3', ['16|2'], '0$1'],
                  [
                    '(\\d{2})(\\d{2})(\\d{3})',
                    '$1 $2 $3',
                    [
                      '[45]|6(?:0[23]|[1-689]|7[235-7])|7(?:[0-4]|5[2-7])|8[1-6]',
                    ],
                    '0$1',
                  ],
                  ['(\\d)(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[12]'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['[4-7]|8[1-35]'],
                    '0$1',
                  ],
                  [
                    '(\\d)(\\d{3})(\\d{4,6})',
                    '$1 $2 $3',
                    ['9(?:2[0-4]|[35-9]|4[137-9])'],
                    '0$1',
                  ],
                  ['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['2'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['8'], '0$1'],
                  [
                    '(\\d)(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['92'],
                    '0$1',
                  ],
                  ['(\\d)(\\d{5})(\\d{4})', '$1 $2 $3', ['9'], '0$1'],
                ],
                '0',
              ],
              MN: [
                '976',
                '001',
                '[12]\\d{7,9}|[5-9]\\d{7}',
                [8, 9, 10],
                [
                  ['(\\d{2})(\\d{2})(\\d{4})', '$1 $2 $3', ['[12]1'], '0$1'],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[5-9]']],
                  ['(\\d{3})(\\d{5,6})', '$1 $2', ['[12]2[1-3]'], '0$1'],
                  [
                    '(\\d{4})(\\d{5,6})',
                    '$1 $2',
                    [
                      '[12](?:27|3[2-8]|4[2-68]|5[1-4689])',
                      '[12](?:27|3[2-8]|4[2-68]|5[1-4689])[0-3]',
                    ],
                    '0$1',
                  ],
                  ['(\\d{5})(\\d{4,5})', '$1 $2', ['[12]'], '0$1'],
                ],
                '0',
              ],
              MO: [
                '853',
                '00',
                '0800\\d{3}|(?:28|[68]\\d)\\d{6}',
                [7, 8],
                [
                  ['(\\d{4})(\\d{3})', '$1 $2', ['0']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[268]']],
                ],
              ],
              MP: [
                '1',
                '011',
                '[58]\\d{9}|(?:67|90)0\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-9]\\d{6})$',
                '670$1',
                0,
                '670',
              ],
              MQ: [
                '596',
                '00',
                '(?:69|80)\\d{7}|(?:59|97)6\\d{6}',
                [9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[569]'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              MR: [
                '222',
                '00',
                '(?:[2-4]\\d\\d|800)\\d{5}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[2-48]'],
                  ],
                ],
              ],
              MS: [
                '1',
                '011',
                '(?:[58]\\d\\d|664|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([34]\\d{6})$',
                '664$1',
                0,
                '664',
              ],
              MT: [
                '356',
                '00',
                '3550\\d{4}|(?:[2579]\\d\\d|800)\\d{5}',
                [8],
                [['(\\d{4})(\\d{4})', '$1 $2', ['[2357-9]']]],
              ],
              MU: [
                '230',
                '0(?:0|[24-7]0|3[03])',
                '(?:5|8\\d\\d)\\d{7}|[2-468]\\d{6}',
                [7, 8, 10],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[2-46]|8[013]']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['5']],
                  ['(\\d{5})(\\d{5})', '$1 $2', ['8']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '020',
              ],
              MV: [
                '960',
                '0(?:0|19)',
                '(?:800|9[0-57-9]\\d)\\d{7}|[34679]\\d{6}',
                [7, 10],
                [
                  ['(\\d{3})(\\d{4})', '$1-$2', ['[3467]|9[13-9]']],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['[89]']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              MW: [
                '265',
                '00',
                '(?:[129]\\d|31|77|88)\\d{7}|1\\d{6}',
                [7, 9],
                [
                  ['(\\d)(\\d{3})(\\d{3})', '$1 $2 $3', ['1[2-9]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['2'], '0$1'],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[137-9]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              MX: [
                '52',
                '0[09]',
                '1(?:(?:44|99)[1-9]|65[0-689])\\d{7}|(?:1(?:[017]\\d|[235][1-9]|4[0-35-9]|6[0-46-9]|8[1-79]|9[1-8])|[2-9]\\d)\\d{8}',
                [10, 11],
                [
                  [
                    '(\\d{2})(\\d{4})(\\d{4})',
                    '$1 $2 $3',
                    ['33|5[56]|81'],
                    0,
                    1,
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['[2-9]'], 0, 1],
                  [
                    '(\\d)(\\d{2})(\\d{4})(\\d{4})',
                    '$2 $3 $4',
                    ['1(?:33|5[56]|81)'],
                    0,
                    1,
                  ],
                  ['(\\d)(\\d{3})(\\d{3})(\\d{4})', '$2 $3 $4', ['1'], 0, 1],
                ],
                '01',
                0,
                '0(?:[12]|4[45])|1',
                0,
                0,
                0,
                0,
                '00',
              ],
              MY: [
                '60',
                '00',
                '1\\d{8,9}|(?:3\\d|[4-9])\\d{7}',
                [8, 9, 10],
                [
                  ['(\\d)(\\d{3})(\\d{4})', '$1-$2 $3', ['[4-79]'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1-$2 $3',
                    [
                      '1(?:[02469]|[378][1-9]|53)|8',
                      '1(?:[02469]|[37][1-9]|53|8(?:[1-46-9]|5[7-9]))|8',
                    ],
                    '0$1',
                  ],
                  ['(\\d)(\\d{4})(\\d{4})', '$1-$2 $3', ['3'], '0$1'],
                  [
                    '(\\d)(\\d{3})(\\d{2})(\\d{4})',
                    '$1-$2-$3-$4',
                    ['1(?:[367]|80)'],
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1-$2 $3', ['15'], '0$1'],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1-$2 $3', ['1'], '0$1'],
                ],
                '0',
              ],
              MZ: [
                '258',
                '00',
                '(?:2|8\\d)\\d{7}',
                [8, 9],
                [
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['2|8[2-79]']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['8']],
                ],
              ],
              NA: [
                '264',
                '00',
                '[68]\\d{7,8}',
                [8, 9],
                [
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['88'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['6'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['87'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['8'], '0$1'],
                ],
                '0',
              ],
              NC: [
                '687',
                '00',
                '(?:050|[2-57-9]\\d\\d)\\d{3}',
                [6],
                [['(\\d{2})(\\d{2})(\\d{2})', '$1.$2.$3', ['[02-57-9]']]],
              ],
              NE: [
                '227',
                '00',
                '[027-9]\\d{7}',
                [8],
                [
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['08']],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[089]|2[013]|7[04]'],
                  ],
                ],
              ],
              NF: [
                '672',
                '00',
                '[13]\\d{5}',
                [6],
                [
                  ['(\\d{2})(\\d{4})', '$1 $2', ['1[0-3]']],
                  ['(\\d)(\\d{5})', '$1 $2', ['[13]']],
                ],
                0,
                0,
                '([0-258]\\d{4})$',
                '3$1',
              ],
              NG: [
                '234',
                '009',
                '(?:[124-7]|9\\d{3})\\d{6}|[1-9]\\d{7}|[78]\\d{9,13}',
                [7, 8, 10, 11, 12, 13, 14],
                [
                  ['(\\d{2})(\\d{2})(\\d{3})', '$1 $2 $3', ['78'], '0$1'],
                  [
                    '(\\d)(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['[12]|9(?:0[3-9]|[1-9])'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2,3})',
                    '$1 $2 $3',
                    ['[3-7]|8[2-9]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[7-9]'], '0$1'],
                  ['(\\d{3})(\\d{4})(\\d{4,5})', '$1 $2 $3', ['[78]'], '0$1'],
                  ['(\\d{3})(\\d{5})(\\d{5,6})', '$1 $2 $3', ['[78]'], '0$1'],
                ],
                '0',
              ],
              NI: [
                '505',
                '00',
                '(?:1800|[25-8]\\d{3})\\d{4}',
                [8],
                [['(\\d{4})(\\d{4})', '$1 $2', ['[125-8]']]],
              ],
              NL: [
                '31',
                '00',
                '(?:[124-7]\\d\\d|3(?:[02-9]\\d|1[0-8]))\\d{6}|8\\d{6,9}|9\\d{6,10}|1\\d{4,5}',
                [5, 6, 7, 8, 9, 10, 11],
                [
                  ['(\\d{3})(\\d{4,7})', '$1 $2', ['[89]0'], '0$1'],
                  ['(\\d{2})(\\d{7})', '$1 $2', ['66'], '0$1'],
                  ['(\\d)(\\d{8})', '$1 $2', ['6'], '0$1'],
                  [
                    '(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['1[16-8]|2[259]|3[124]|4[17-9]|5[124679]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['[1-578]|91'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{5})', '$1 $2 $3', ['9'], '0$1'],
                ],
                '0',
              ],
              NO: [
                '47',
                '00',
                '(?:0|[2-9]\\d{3})\\d{4}',
                [5, 8],
                [
                  ['(\\d{3})(\\d{2})(\\d{3})', '$1 $2 $3', ['[489]|59']],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[235-7]'],
                  ],
                ],
                0,
                0,
                0,
                0,
                0,
                '[02-689]|7[0-8]',
              ],
              NP: [
                '977',
                '00',
                '(?:1\\d|9)\\d{9}|[1-9]\\d{7}',
                [8, 10, 11],
                [
                  ['(\\d)(\\d{7})', '$1-$2', ['1[2-6]'], '0$1'],
                  [
                    '(\\d{2})(\\d{6})',
                    '$1-$2',
                    ['1[01]|[2-8]|9(?:[1-59]|[67][2-6])'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{7})', '$1-$2', ['9']],
                ],
                '0',
              ],
              NR: [
                '674',
                '00',
                '(?:444|(?:55|8\\d)\\d|666)\\d{4}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[4-68]']]],
              ],
              NU: [
                '683',
                '00',
                '(?:[47]|888\\d)\\d{3}',
                [4, 7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['8']]],
              ],
              NZ: [
                '64',
                '0(?:0|161)',
                '[29]\\d{7,9}|50\\d{5}(?:\\d{2,3})?|6[0-35-9]\\d{6}|7\\d{7,8}|8\\d{4,9}|(?:11\\d|[34])\\d{7}',
                [5, 6, 7, 8, 9, 10],
                [
                  ['(\\d{2})(\\d{3,8})', '$1 $2', ['8[1-579]'], '0$1'],
                  [
                    '(\\d{3})(\\d{2})(\\d{2,3})',
                    '$1 $2 $3',
                    ['50[036-8]|[89]0', '50(?:[0367]|88)|[89]0'],
                    '0$1',
                  ],
                  [
                    '(\\d)(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['24|[346]|7[2-57-9]|9[2-9]'],
                    '0$1',
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['2(?:10|74)|[59]|80'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3,4})(\\d{4})',
                    '$1 $2 $3',
                    ['1|2[028]'],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,5})',
                    '$1 $2 $3',
                    ['2(?:[169]|7[0-35-9])|7|86'],
                    '0$1',
                  ],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              OM: [
                '968',
                '00',
                '(?:1505|[279]\\d{3}|500)\\d{4}|800\\d{5,6}',
                [7, 8, 9],
                [
                  ['(\\d{3})(\\d{4,6})', '$1 $2', ['[58]']],
                  ['(\\d{2})(\\d{6})', '$1 $2', ['2']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[179]']],
                ],
              ],
              PA: [
                '507',
                '00',
                '(?:00800|8\\d{3})\\d{6}|[68]\\d{7}|[1-57-9]\\d{6}',
                [7, 8, 10, 11],
                [
                  ['(\\d{3})(\\d{4})', '$1-$2', ['[1-57-9]']],
                  ['(\\d{4})(\\d{4})', '$1-$2', ['[68]']],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['8']],
                ],
              ],
              PE: [
                '51',
                '00|19(?:1[124]|77|90)00',
                '(?:[14-8]|9\\d)\\d{7}',
                [8, 9],
                [
                  ['(\\d{3})(\\d{5})', '$1 $2', ['80'], '(0$1)'],
                  ['(\\d)(\\d{7})', '$1 $2', ['1'], '(0$1)'],
                  ['(\\d{2})(\\d{6})', '$1 $2', ['[4-8]'], '(0$1)'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['9']],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
                ' Anexo ',
              ],
              PF: [
                '689',
                '00',
                '4\\d{5}(?:\\d{2})?|8\\d{7,8}',
                [6, 8, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3', ['44']],
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['4|8[7-9]'],
                  ],
                  ['(\\d{3})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['8']],
                ],
              ],
              PG: [
                '675',
                '00|140[1-3]',
                '(?:180|[78]\\d{3})\\d{4}|(?:[2-589]\\d|64)\\d{5}',
                [7, 8],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['18|[2-69]|85']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[78]']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              PH: [
                '63',
                '00',
                '(?:[2-7]|9\\d)\\d{8}|2\\d{5}|(?:1800|8)\\d{7,9}',
                [6, 8, 9, 10, 11, 12, 13],
                [
                  ['(\\d)(\\d{5})', '$1 $2', ['2'], '(0$1)'],
                  [
                    '(\\d{4})(\\d{4,6})',
                    '$1 $2',
                    [
                      '3(?:23|39|46)|4(?:2[3-6]|[35]9|4[26]|76)|544|88[245]|(?:52|64|86)2',
                      '3(?:230|397|461)|4(?:2(?:35|[46]4|51)|396|4(?:22|63)|59[347]|76[15])|5(?:221|446)|642[23]|8(?:622|8(?:[24]2|5[13]))',
                    ],
                    '(0$1)',
                  ],
                  [
                    '(\\d{5})(\\d{4})',
                    '$1 $2',
                    ['346|4(?:27|9[35])|883', '3469|4(?:279|9(?:30|56))|8834'],
                    '(0$1)',
                  ],
                  ['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['2'], '(0$1)'],
                  [
                    '(\\d{2})(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['[3-7]|8[2-8]'],
                    '(0$1)',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['[89]'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['1']],
                  ['(\\d{4})(\\d{1,2})(\\d{3})(\\d{4})', '$1 $2 $3 $4', ['1']],
                ],
                '0',
              ],
              PK: [
                '92',
                '00',
                '122\\d{6}|[24-8]\\d{10,11}|9(?:[013-9]\\d{8,10}|2(?:[01]\\d\\d|2(?:[06-8]\\d|1[01]))\\d{7})|(?:[2-8]\\d{3}|92(?:[0-7]\\d|8[1-9]))\\d{6}|[24-9]\\d{8}|[89]\\d{7}',
                [8, 9, 10, 11, 12],
                [
                  ['(\\d{3})(\\d{3})(\\d{2,7})', '$1 $2 $3', ['[89]0'], '0$1'],
                  ['(\\d{4})(\\d{5})', '$1 $2', ['1']],
                  [
                    '(\\d{3})(\\d{6,7})',
                    '$1 $2',
                    [
                      '2(?:3[2358]|4[2-4]|9[2-8])|45[3479]|54[2-467]|60[468]|72[236]|8(?:2[2-689]|3[23578]|4[3478]|5[2356])|9(?:2[2-8]|3[27-9]|4[2-6]|6[3569]|9[25-8])',
                      '9(?:2[3-8]|98)|(?:2(?:3[2358]|4[2-4]|9[2-8])|45[3479]|54[2-467]|60[468]|72[236]|8(?:2[2-689]|3[23578]|4[3478]|5[2356])|9(?:22|3[27-9]|4[2-6]|6[3569]|9[25-7]))[2-9]',
                    ],
                    '(0$1)',
                  ],
                  [
                    '(\\d{2})(\\d{7,8})',
                    '$1 $2',
                    [
                      '(?:2[125]|4[0-246-9]|5[1-35-7]|6[1-8]|7[14]|8[16]|91)[2-9]',
                    ],
                    '(0$1)',
                  ],
                  ['(\\d{5})(\\d{5})', '$1 $2', ['58'], '(0$1)'],
                  ['(\\d{3})(\\d{7})', '$1 $2', ['3'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['2[125]|4[0-246-9]|5[1-35-7]|6[1-8]|7[14]|8[16]|91'],
                    '(0$1)',
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['[24-9]'],
                    '(0$1)',
                  ],
                ],
                '0',
              ],
              PL: [
                '48',
                '00',
                '6\\d{5}(?:\\d{2})?|8\\d{9}|[1-9]\\d{6}(?:\\d{2})?',
                [6, 7, 8, 9, 10],
                [
                  ['(\\d{5})', '$1', ['19']],
                  ['(\\d{3})(\\d{3})', '$1 $2', ['11|64']],
                  [
                    '(\\d{2})(\\d{2})(\\d{3})',
                    '$1 $2 $3',
                    [
                      '(?:1[2-8]|2[2-69]|3[2-4]|4[1-468]|5[24-689]|6[1-3578]|7[14-7]|8[1-79]|9[145])1',
                      '(?:1[2-8]|2[2-69]|3[2-4]|4[1-468]|5[24-689]|6[1-3578]|7[14-7]|8[1-79]|9[145])19',
                    ],
                  ],
                  ['(\\d{3})(\\d{2})(\\d{2,3})', '$1 $2 $3', ['64']],
                  [
                    '(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['21|39|45|5[0137]|6[0469]|7[02389]|8(?:0[14]|8)'],
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['1[2-8]|[2-7]|8[1-79]|9[145]'],
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['8']],
                ],
              ],
              PM: [
                '508',
                '00',
                '(?:[45]|80\\d\\d)\\d{5}',
                [6, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3', ['[45]'], '0$1'],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              PR: [
                '1',
                '011',
                '(?:[589]\\d\\d|787)\\d{7}',
                [10],
                0,
                '1',
                0,
                0,
                0,
                0,
                '787|939',
              ],
              PS: [
                '970',
                '00',
                '[2489]2\\d{6}|(?:1\\d|5)\\d{8}',
                [8, 9, 10],
                [
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['[2489]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['5'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1 $2 $3', ['1']],
                ],
                '0',
              ],
              PT: [
                '351',
                '00',
                '1693\\d{5}|(?:[26-9]\\d|30)\\d{7}',
                [9],
                [
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['2[12]']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['16|[236-9]']],
                ],
              ],
              PW: [
                '680',
                '01[12]',
                '(?:[24-8]\\d\\d|345|900)\\d{4}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[2-9]']]],
              ],
              PY: [
                '595',
                '00',
                '59\\d{4,6}|9\\d{5,10}|(?:[2-46-8]\\d|5[0-8])\\d{4,7}',
                [6, 7, 8, 9, 10, 11],
                [
                  ['(\\d{3})(\\d{3,6})', '$1 $2', ['[2-9]0'], '0$1'],
                  [
                    '(\\d{2})(\\d{5})',
                    '$1 $2',
                    ['[26]1|3[289]|4[1246-8]|7[1-3]|8[1-36]'],
                    '(0$1)',
                  ],
                  [
                    '(\\d{3})(\\d{4,5})',
                    '$1 $2',
                    ['2[279]|3[13-5]|4[359]|5|6(?:[34]|7[1-46-8])|7[46-8]|85'],
                    '(0$1)',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['2[14-68]|3[26-9]|4[1246-8]|6(?:1|75)|7[1-35]|8[1-36]'],
                    '(0$1)',
                  ],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['87']],
                  ['(\\d{3})(\\d{6})', '$1 $2', ['9(?:[5-79]|8[1-6])'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[2-8]'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['9']],
                ],
                '0',
              ],
              QA: [
                '974',
                '00',
                '[2-7]\\d{7}|800\\d{4}(?:\\d{2})?|2\\d{6}',
                [7, 8, 9],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['2[126]|8']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[2-7]']],
                ],
              ],
              RE: [
                '262',
                '00',
                '976\\d{6}|(?:26|[68]\\d)\\d{7}',
                [9],
                [
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[2689]'],
                    '0$1',
                  ],
                ],
                '0',
                0,
                0,
                0,
                0,
                '26[23]|69|[89]',
              ],
              RO: [
                '40',
                '00',
                '(?:[2378]\\d|90)\\d{7}|[23]\\d{5}',
                [6, 9],
                [
                  [
                    '(\\d{3})(\\d{3})',
                    '$1 $2',
                    ['2[3-6]', '2[3-6]\\d9'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{4})', '$1 $2', ['219|31'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[23]1'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[237-9]'], '0$1'],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                ' int ',
              ],
              RS: [
                '381',
                '00',
                '38[02-9]\\d{6,9}|6\\d{7,9}|90\\d{4,8}|38\\d{5,6}|(?:7\\d\\d|800)\\d{3,9}|(?:[12]\\d|3[0-79])\\d{5,10}',
                [6, 7, 8, 9, 10, 11, 12],
                [
                  [
                    '(\\d{3})(\\d{3,9})',
                    '$1 $2',
                    ['(?:2[389]|39)0|[7-9]'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{5,10})', '$1 $2', ['[1-36]'], '0$1'],
                ],
                '0',
              ],
              RU: [
                '7',
                '810',
                '8\\d{13}|[347-9]\\d{9}',
                [10, 14],
                [
                  [
                    '(\\d{4})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    [
                      '7(?:1[0-8]|2[1-9])',
                      '7(?:1(?:[0-6]2|7|8[27])|2(?:1[23]|[2-9]2))',
                      '7(?:1(?:[0-6]2|7|8[27])|2(?:13[03-69]|62[013-9]))|72[1-57-9]2',
                    ],
                    '8 ($1)',
                    1,
                  ],
                  [
                    '(\\d{5})(\\d)(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    [
                      '7(?:1[0-68]|2[1-9])',
                      '7(?:1(?:[06][3-6]|[18]|2[35]|[3-5][3-5])|2(?:[13][3-5]|[24-689]|7[457]))',
                      '7(?:1(?:0(?:[356]|4[023])|[18]|2(?:3[013-9]|5)|3[45]|43[013-79]|5(?:3[1-8]|4[1-7]|5)|6(?:3[0-35-9]|[4-6]))|2(?:1(?:3[178]|[45])|[24-689]|3[35]|7[457]))|7(?:14|23)4[0-8]|71(?:33|45)[1-79]',
                    ],
                    '8 ($1)',
                    1,
                  ],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['7'], '8 ($1)', 1],
                  [
                    '(\\d{3})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2-$3-$4',
                    ['[349]|8(?:[02-7]|1[1-8])'],
                    '8 ($1)',
                    1,
                  ],
                  [
                    '(\\d{4})(\\d{4})(\\d{3})(\\d{3})',
                    '$1 $2 $3 $4',
                    ['8'],
                    '8 ($1)',
                  ],
                ],
                '8',
                0,
                0,
                0,
                0,
                '3[04-689]|[489]',
                0,
                '8~10',
              ],
              RW: [
                '250',
                '00',
                '(?:06|[27]\\d\\d|[89]00)\\d{6}',
                [8, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['0']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[7-9]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['2']],
                ],
                '0',
              ],
              SA: [
                '966',
                '00',
                '92\\d{7}|(?:[15]|8\\d)\\d{8}',
                [9, 10],
                [
                  ['(\\d{4})(\\d{5})', '$1 $2', ['9']],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['1'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['5'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['81'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['8']],
                ],
                '0',
              ],
              SB: [
                '677',
                '0[01]',
                '(?:[1-6]|[7-9]\\d\\d)\\d{4}',
                [5, 7],
                [['(\\d{2})(\\d{5})', '$1 $2', ['7|8[4-9]|9(?:[1-8]|9[0-8])']]],
              ],
              SC: [
                '248',
                '010|0[0-2]',
                '800\\d{4}|(?:[249]\\d|64)\\d{5}',
                [7],
                [['(\\d)(\\d{3})(\\d{3})', '$1 $2 $3', ['[246]|9[57]']]],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              SD: [
                '249',
                '00',
                '[19]\\d{8}',
                [9],
                [['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[19]'], '0$1']],
                '0',
              ],
              SE: [
                '46',
                '00',
                '(?:[26]\\d\\d|9)\\d{9}|[1-9]\\d{8}|[1-689]\\d{7}|[1-4689]\\d{6}|2\\d{5}',
                [6, 7, 8, 9, 10],
                [
                  [
                    '(\\d{2})(\\d{2,3})(\\d{2})',
                    '$1-$2 $3',
                    ['20'],
                    '0$1',
                    0,
                    '$1 $2 $3',
                  ],
                  [
                    '(\\d{3})(\\d{4})',
                    '$1-$2',
                    ['9(?:00|39|44|9)'],
                    '0$1',
                    0,
                    '$1 $2',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})',
                    '$1-$2 $3',
                    ['[12][136]|3[356]|4[0246]|6[03]|90[1-9]'],
                    '0$1',
                    0,
                    '$1 $2 $3',
                  ],
                  [
                    '(\\d)(\\d{2,3})(\\d{2})(\\d{2})',
                    '$1-$2 $3 $4',
                    ['8'],
                    '0$1',
                    0,
                    '$1 $2 $3 $4',
                  ],
                  [
                    '(\\d{3})(\\d{2,3})(\\d{2})',
                    '$1-$2 $3',
                    [
                      '1[2457]|2(?:[247-9]|5[0138])|3[0247-9]|4[1357-9]|5[0-35-9]|6(?:[125689]|4[02-57]|7[0-2])|9(?:[125-8]|3[02-5]|4[0-3])',
                    ],
                    '0$1',
                    0,
                    '$1 $2 $3',
                  ],
                  [
                    '(\\d{3})(\\d{2,3})(\\d{3})',
                    '$1-$2 $3',
                    ['9(?:00|39|44)'],
                    '0$1',
                    0,
                    '$1 $2 $3',
                  ],
                  [
                    '(\\d{2})(\\d{2,3})(\\d{2})(\\d{2})',
                    '$1-$2 $3 $4',
                    ['1[13689]|2[0136]|3[1356]|4[0246]|54|6[03]|90[1-9]'],
                    '0$1',
                    0,
                    '$1 $2 $3 $4',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1-$2 $3 $4',
                    ['10|7'],
                    '0$1',
                    0,
                    '$1 $2 $3 $4',
                  ],
                  [
                    '(\\d)(\\d{3})(\\d{3})(\\d{2})',
                    '$1-$2 $3 $4',
                    ['8'],
                    '0$1',
                    0,
                    '$1 $2 $3 $4',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
                    '$1-$2 $3 $4',
                    [
                      '[13-5]|2(?:[247-9]|5[0138])|6(?:[124-689]|7[0-2])|9(?:[125-8]|3[02-5]|4[0-3])',
                    ],
                    '0$1',
                    0,
                    '$1 $2 $3 $4',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{2})(\\d{3})',
                    '$1-$2 $3 $4',
                    ['9'],
                    '0$1',
                    0,
                    '$1 $2 $3 $4',
                  ],
                  [
                    '(\\d{3})(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1-$2 $3 $4 $5',
                    ['[26]'],
                    '0$1',
                    0,
                    '$1 $2 $3 $4 $5',
                  ],
                ],
                '0',
              ],
              SG: [
                '65',
                '0[0-3]\\d',
                '(?:(?:1\\d|8)\\d\\d|7000)\\d{7}|[3689]\\d{7}',
                [8, 10, 11],
                [
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[369]|8(?:0[1-5]|[1-9])']],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['8']],
                  ['(\\d{4})(\\d{4})(\\d{3})', '$1 $2 $3', ['7']],
                  ['(\\d{4})(\\d{3})(\\d{4})', '$1 $2 $3', ['1']],
                ],
              ],
              SH: [
                '290',
                '00',
                '(?:[256]\\d|8)\\d{3}',
                [4, 5],
                0,
                0,
                0,
                0,
                0,
                0,
                '[256]',
              ],
              SI: [
                '386',
                '00|10(?:22|66|88|99)',
                '[1-7]\\d{7}|8\\d{4,7}|90\\d{4,6}',
                [5, 6, 7, 8],
                [
                  ['(\\d{2})(\\d{3,6})', '$1 $2', ['8[09]|9'], '0$1'],
                  ['(\\d{3})(\\d{5})', '$1 $2', ['59|8'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['[37][01]|4[0139]|51|6'],
                    '0$1',
                  ],
                  [
                    '(\\d)(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[1-57]'],
                    '(0$1)',
                  ],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              SJ: [
                '47',
                '00',
                '0\\d{4}|(?:[489]\\d|[57]9)\\d{6}',
                [5, 8],
                0,
                0,
                0,
                0,
                0,
                0,
                '79',
              ],
              SK: [
                '421',
                '00',
                '[2-689]\\d{8}|[2-59]\\d{6}|[2-5]\\d{5}',
                [6, 7, 9],
                [
                  ['(\\d)(\\d{2})(\\d{3,4})', '$1 $2 $3', ['21'], '0$1'],
                  [
                    '(\\d{2})(\\d{2})(\\d{2,3})',
                    '$1 $2 $3',
                    ['[3-5][1-8]1', '[3-5][1-8]1[67]'],
                    '0$1',
                  ],
                  [
                    '(\\d)(\\d{3})(\\d{3})(\\d{2})',
                    '$1/$2 $3 $4',
                    ['2'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[689]'], '0$1'],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1/$2 $3 $4',
                    ['[3-5]'],
                    '0$1',
                  ],
                ],
                '0',
              ],
              SL: [
                '232',
                '00',
                '(?:[237-9]\\d|66)\\d{6}',
                [8],
                [['(\\d{2})(\\d{6})', '$1 $2', ['[236-9]'], '(0$1)']],
                '0',
              ],
              SM: [
                '378',
                '00',
                '(?:0549|[5-7]\\d)\\d{6}',
                [8, 10],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[5-7]'],
                  ],
                  ['(\\d{4})(\\d{6})', '$1 $2', ['0']],
                ],
                0,
                0,
                '([89]\\d{5})$',
                '0549$1',
              ],
              SN: [
                '221',
                '00',
                '(?:[378]\\d|93)\\d{7}',
                [9],
                [
                  ['(\\d{3})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['8']],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[379]'],
                  ],
                ],
              ],
              SO: [
                '252',
                '00',
                '[346-9]\\d{8}|[12679]\\d{7}|[1-5]\\d{6}|[1348]\\d{5}',
                [6, 7, 8, 9],
                [
                  ['(\\d{2})(\\d{4})', '$1 $2', ['8[125]']],
                  ['(\\d{6})', '$1', ['[134]']],
                  ['(\\d)(\\d{6})', '$1 $2', ['[15]|2[0-79]|3[0-46-8]|4[0-7]']],
                  ['(\\d)(\\d{7})', '$1 $2', ['24|[67]']],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[3478]|64|90']],
                  [
                    '(\\d{2})(\\d{5,7})',
                    '$1 $2',
                    ['1|28|6(?:0[5-7]|[1-35-9])|9[2-9]'],
                  ],
                ],
                '0',
              ],
              SR: [
                '597',
                '00',
                '(?:[2-5]|68|[78]\\d)\\d{5}',
                [6, 7],
                [
                  ['(\\d{2})(\\d{2})(\\d{2})', '$1-$2-$3', ['56']],
                  ['(\\d{3})(\\d{3})', '$1-$2', ['[2-5]']],
                  ['(\\d{3})(\\d{4})', '$1-$2', ['[6-8]']],
                ],
              ],
              SS: [
                '211',
                '00',
                '[19]\\d{8}',
                [9],
                [['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[19]'], '0$1']],
                '0',
              ],
              ST: [
                '239',
                '00',
                '(?:22|9\\d)\\d{5}',
                [7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[29]']]],
              ],
              SV: [
                '503',
                '00',
                '[267]\\d{7}|[89]00\\d{4}(?:\\d{4})?',
                [7, 8, 11],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[89]']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[267]']],
                  ['(\\d{3})(\\d{4})(\\d{4})', '$1 $2 $3', ['[89]']],
                ],
              ],
              SX: [
                '1',
                '011',
                '7215\\d{6}|(?:[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|(5\\d{6})$',
                '721$1',
                0,
                '721',
              ],
              SY: [
                '963',
                '00',
                '[1-39]\\d{8}|[1-5]\\d{7}',
                [8, 9],
                [
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['[1-5]'],
                    '0$1',
                    1,
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['9'], '0$1', 1],
                ],
                '0',
              ],
              SZ: [
                '268',
                '00',
                '0800\\d{4}|(?:[237]\\d|900)\\d{6}',
                [8, 9],
                [
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[0237]']],
                  ['(\\d{5})(\\d{4})', '$1 $2', ['9']],
                ],
              ],
              TA: ['290', '00', '8\\d{3}', [4], 0, 0, 0, 0, 0, 0, '8'],
              TC: [
                '1',
                '011',
                '(?:[58]\\d\\d|649|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-479]\\d{6})$',
                '649$1',
                0,
                '649',
              ],
              TD: [
                '235',
                '00|16',
                '(?:22|[69]\\d|77)\\d{6}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[2679]'],
                  ],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
              ],
              TG: [
                '228',
                '00',
                '[279]\\d{7}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[279]'],
                  ],
                ],
              ],
              TH: [
                '66',
                '00[1-9]',
                '(?:001800|[2-57]|[689]\\d)\\d{7}|1\\d{7,9}',
                [8, 9, 10, 13],
                [
                  ['(\\d)(\\d{3})(\\d{4})', '$1 $2 $3', ['2'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[13-9]'], '0$1'],
                  ['(\\d{4})(\\d{3})(\\d{3})', '$1 $2 $3', ['1']],
                ],
                '0',
              ],
              TJ: [
                '992',
                '810',
                '(?:00|[1-57-9]\\d)\\d{7}',
                [9],
                [
                  ['(\\d{6})(\\d)(\\d{2})', '$1 $2 $3', ['331', '3317']],
                  ['(\\d{3})(\\d{2})(\\d{4})', '$1 $2 $3', ['[34]7|91[78]']],
                  ['(\\d{4})(\\d)(\\d{4})', '$1 $2 $3', ['3[1-5]']],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[0-57-9]']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '8~10',
              ],
              TK: ['690', '00', '[2-47]\\d{3,6}', [4, 5, 6, 7]],
              TL: [
                '670',
                '00',
                '7\\d{7}|(?:[2-47]\\d|[89]0)\\d{5}',
                [7, 8],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[2-489]|70']],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['7']],
                ],
              ],
              TM: [
                '993',
                '810',
                '[1-6]\\d{7}',
                [8],
                [
                  [
                    '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
                    '$1 $2-$3-$4',
                    ['12'],
                    '(8 $1)',
                  ],
                  [
                    '(\\d{3})(\\d)(\\d{2})(\\d{2})',
                    '$1 $2-$3-$4',
                    ['[1-5]'],
                    '(8 $1)',
                  ],
                  ['(\\d{2})(\\d{6})', '$1 $2', ['6'], '8 $1'],
                ],
                '8',
                0,
                0,
                0,
                0,
                0,
                0,
                '8~10',
              ],
              TN: [
                '216',
                '00',
                '[2-57-9]\\d{7}',
                [8],
                [['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['[2-57-9]']]],
              ],
              TO: [
                '676',
                '00',
                '(?:0800|(?:[5-8]\\d\\d|999)\\d)\\d{3}|[2-8]\\d{4}',
                [5, 7],
                [
                  [
                    '(\\d{2})(\\d{3})',
                    '$1-$2',
                    ['[2-4]|50|6[09]|7[0-24-69]|8[05]'],
                  ],
                  ['(\\d{4})(\\d{3})', '$1 $2', ['0']],
                  ['(\\d{3})(\\d{4})', '$1 $2', ['[5-9]']],
                ],
              ],
              TR: [
                '90',
                '00',
                '4\\d{6}|8\\d{11,12}|(?:[2-58]\\d\\d|900)\\d{7}',
                [7, 10, 12, 13],
                [
                  [
                    '(\\d{3})(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['512|8[01589]|90'],
                    '0$1',
                    1,
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['5(?:[0-59]|61)', '5(?:[0-59]|616)', '5(?:[0-59]|6161)'],
                    '0$1',
                    1,
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[24][1-8]|3[1-9]'],
                    '(0$1)',
                    1,
                  ],
                  ['(\\d{3})(\\d{3})(\\d{6,7})', '$1 $2 $3', ['80'], '0$1', 1],
                ],
                '0',
              ],
              TT: [
                '1',
                '011',
                '(?:[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-46-8]\\d{6})$',
                '868$1',
                0,
                '868',
              ],
              TV: [
                '688',
                '00',
                '(?:2|7\\d\\d|90)\\d{4}',
                [5, 6, 7],
                [
                  ['(\\d{2})(\\d{3})', '$1 $2', ['2']],
                  ['(\\d{2})(\\d{4})', '$1 $2', ['90']],
                  ['(\\d{2})(\\d{5})', '$1 $2', ['7']],
                ],
              ],
              TW: [
                '886',
                '0(?:0[25-79]|19)',
                '[2-689]\\d{8}|7\\d{9,10}|[2-8]\\d{7}|2\\d{6}',
                [7, 8, 9, 10, 11],
                [
                  ['(\\d{2})(\\d)(\\d{4})', '$1 $2 $3', ['202'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[258]0'], '0$1'],
                  [
                    '(\\d)(\\d{3,4})(\\d{4})',
                    '$1 $2 $3',
                    [
                      '[23568]|4(?:0[02-48]|[1-47-9])|7[1-9]',
                      '[23568]|4(?:0[2-48]|[1-47-9])|(?:400|7)[1-9]',
                    ],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[49]'], '0$1'],
                  ['(\\d{2})(\\d{4})(\\d{4,5})', '$1 $2 $3', ['7'], '0$1'],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                0,
                0,
                '#',
              ],
              TZ: [
                '255',
                '00[056]',
                '(?:[26-8]\\d|41|90)\\d{7}',
                [9],
                [
                  ['(\\d{3})(\\d{2})(\\d{4})', '$1 $2 $3', ['[89]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[24]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[67]'], '0$1'],
                ],
                '0',
              ],
              UA: [
                '380',
                '00',
                '[89]\\d{9}|[3-9]\\d{8}',
                [9, 10],
                [
                  [
                    '(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    [
                      '6[12][29]|(?:3[1-8]|4[136-8]|5[12457]|6[49])2|(?:56|65)[24]',
                      '6[12][29]|(?:35|4[1378]|5[12457]|6[49])2|(?:56|65)[24]|(?:3[1-46-8]|46)2[013-9]',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{4})(\\d{5})',
                    '$1 $2',
                    [
                      '3[1-8]|4(?:[1367]|[45][6-9]|8[4-6])|5(?:[1-5]|6[0135689]|7[4-6])|6(?:[12][3-7]|[459])',
                      '3[1-8]|4(?:[1367]|[45][6-9]|8[4-6])|5(?:[1-5]|6(?:[015689]|3[02389])|7[4-6])|6(?:[12][3-7]|[459])',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{4})',
                    '$1 $2 $3',
                    ['[3-7]|89|9[1-9]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3,4})', '$1 $2 $3', ['[89]'], '0$1'],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                0,
                '0~0',
              ],
              UG: [
                '256',
                '00[057]',
                '800\\d{6}|(?:[29]0|[347]\\d)\\d{7}',
                [9],
                [
                  ['(\\d{4})(\\d{5})', '$1 $2', ['202', '2024'], '0$1'],
                  [
                    '(\\d{3})(\\d{6})',
                    '$1 $2',
                    ['[27-9]|4(?:6[45]|[7-9])'],
                    '0$1',
                  ],
                  ['(\\d{2})(\\d{7})', '$1 $2', ['[34]'], '0$1'],
                ],
                '0',
              ],
              US: [
                '1',
                '011',
                '[2-9]\\d{9}|3\\d{6}',
                [10],
                [
                  ['(\\d{3})(\\d{4})', '$1-$2', ['310'], 0, 1],
                  [
                    '(\\d{3})(\\d{3})(\\d{4})',
                    '($1) $2-$3',
                    ['[2-9]'],
                    0,
                    1,
                    '$1-$2-$3',
                  ],
                ],
                '1',
                0,
                0,
                0,
                0,
                0,
                [
                  [
                    '5(?:05(?:[2-57-9]\\d\\d|6(?:[0-35-9]\\d|44))|82(?:2(?:0[0-3]|[268]2)|3(?:0[02]|22|33)|4(?:00|4[24]|65|82)|5(?:00|29|58|83)|6(?:00|66|82)|7(?:58|77)|8(?:00|42|5[25]|88)|9(?:00|9[89])))\\d{4}|(?:2(?:0[1-35-9]|1[02-9]|2[03-589]|3[149]|4[08]|5[1-46]|6[0279]|7[0269]|8[13])|3(?:0[1-57-9]|1[02-9]|2[01356]|3[0-24679]|4[167]|5[12]|6[014]|8[056])|4(?:0[124-9]|1[02-579]|2[3-5]|3[0245]|4[023578]|58|6[349]|7[0589]|8[04])|5(?:0[1-47-9]|1[0235-8]|20|3[0149]|4[01]|5[19]|6[1-47]|7[0-5]|8[056])|6(?:0[1-35-9]|1[024-9]|2[03689]|[34][016]|5[01679]|6[0-279]|78|8[0-29])|7(?:0[1-46-8]|1[2-9]|2[04-7]|3[1247]|4[037]|5[47]|6[02359]|7[0-59]|8[156])|8(?:0[1-68]|1[02-8]|2[068]|3[0-289]|4[03578]|5[046-9]|6[02-5]|7[028])|9(?:0[1346-9]|1[02-9]|2[0589]|3[0146-8]|4[01357-9]|5[12469]|7[0-389]|8[04-69]))[2-9]\\d{6}',
                  ],
                  [''],
                  ['8(?:00|33|44|55|66|77|88)[2-9]\\d{6}'],
                  ['900[2-9]\\d{6}'],
                  [
                    '52(?:3(?:[2-46-9][02-9]\\d|5(?:[02-46-9]\\d|5[0-46-9]))|4(?:[2-478][02-9]\\d|5(?:[034]\\d|2[024-9]|5[0-46-9])|6(?:0[1-9]|[2-9]\\d)|9(?:[05-9]\\d|2[0-5]|49)))\\d{4}|52[34][2-9]1[02-9]\\d{4}|5(?:00|2[125-7]|33|44|66|77|88)[2-9]\\d{6}',
                  ],
                ],
              ],
              UY: [
                '598',
                '0(?:0|1[3-9]\\d)',
                '4\\d{9}|[1249]\\d{7}|(?:[49]\\d|80)\\d{5}',
                [7, 8, 10],
                [
                  ['(\\d{3})(\\d{4})', '$1 $2', ['405|8|90'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['9'], '0$1'],
                  ['(\\d{4})(\\d{4})', '$1 $2', ['[124]']],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['4'], '0$1'],
                ],
                '0',
                0,
                0,
                0,
                0,
                0,
                0,
                '00',
                ' int. ',
              ],
              UZ: [
                '998',
                '810',
                '(?:33|55|[679]\\d|88)\\d{7}',
                [9],
                [
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[35-9]'],
                    '8 $1',
                  ],
                ],
                '8',
                0,
                0,
                0,
                0,
                0,
                0,
                '8~10',
              ],
              VA: [
                '39',
                '00',
                '0\\d{5,10}|3[0-8]\\d{7,10}|55\\d{8}|8\\d{5}(?:\\d{2,4})?|(?:1\\d|39)\\d{7,8}',
                [6, 7, 8, 9, 10, 11],
                0,
                0,
                0,
                0,
                0,
                0,
                '06698',
              ],
              VC: [
                '1',
                '011',
                '(?:[58]\\d\\d|784|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-7]\\d{6})$',
                '784$1',
                0,
                '784',
              ],
              VE: [
                '58',
                '00',
                '[68]00\\d{7}|(?:[24]\\d|[59]0)\\d{8}',
                [10],
                [['(\\d{3})(\\d{7})', '$1-$2', ['[24-689]'], '0$1']],
                '0',
              ],
              VG: [
                '1',
                '011',
                '(?:284|[58]\\d\\d|900)\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-578]\\d{6})$',
                '284$1',
                0,
                '284',
              ],
              VI: [
                '1',
                '011',
                '[58]\\d{9}|(?:34|90)0\\d{7}',
                [10],
                0,
                '1',
                0,
                '1|([2-9]\\d{6})$',
                '340$1',
                0,
                '340',
              ],
              VN: [
                '84',
                '00',
                '[12]\\d{9}|[135-9]\\d{8}|[16]\\d{7}|[16-8]\\d{6}',
                [7, 8, 9, 10],
                [
                  ['(\\d{2})(\\d{5})', '$1 $2', ['80'], '0$1', 1],
                  ['(\\d{4})(\\d{4,6})', '$1 $2', ['1'], 0, 1],
                  [
                    '(\\d{2})(\\d{3})(\\d{2})(\\d{2})',
                    '$1 $2 $3 $4',
                    ['[69]'],
                    '0$1',
                    1,
                  ],
                  [
                    '(\\d{3})(\\d{3})(\\d{3})',
                    '$1 $2 $3',
                    ['[3578]'],
                    '0$1',
                    1,
                  ],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1 $2 $3', ['2[48]'], '0$1', 1],
                  ['(\\d{3})(\\d{4})(\\d{3})', '$1 $2 $3', ['2'], '0$1', 1],
                ],
                '0',
              ],
              VU: [
                '678',
                '00',
                '[57-9]\\d{6}|(?:[238]\\d|48)\\d{3}',
                [5, 7],
                [['(\\d{3})(\\d{4})', '$1 $2', ['[57-9]']]],
              ],
              WF: [
                '681',
                '00',
                '(?:40|72)\\d{4}|8\\d{5}(?:\\d{3})?',
                [6, 9],
                [
                  ['(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3', ['[478]']],
                  ['(\\d{3})(\\d{2})(\\d{2})(\\d{2})', '$1 $2 $3 $4', ['8']],
                ],
              ],
              WS: [
                '685',
                '0',
                '(?:[2-6]|8\\d{5})\\d{4}|[78]\\d{6}|[68]\\d{5}',
                [5, 6, 7, 10],
                [
                  ['(\\d{5})', '$1', ['[2-5]|6[1-9]']],
                  ['(\\d{3})(\\d{3,7})', '$1 $2', ['[68]']],
                  ['(\\d{2})(\\d{5})', '$1 $2', ['7']],
                ],
              ],
              XK: [
                '383',
                '00',
                '[23]\\d{7,8}|(?:4\\d\\d|[89]00)\\d{5}',
                [8, 9],
                [
                  ['(\\d{3})(\\d{5})', '$1 $2', ['[89]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{3})', '$1 $2 $3', ['[2-4]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[23]'], '0$1'],
                ],
                '0',
              ],
              YE: [
                '967',
                '00',
                '(?:1|7\\d)\\d{7}|[1-7]\\d{6}',
                [7, 8, 9],
                [
                  [
                    '(\\d)(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['[1-6]|7[24-68]'],
                    '0$1',
                  ],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['7'], '0$1'],
                ],
                '0',
              ],
              YT: [
                '262',
                '00',
                '80\\d{7}|(?:26|63)9\\d{6}',
                [9],
                0,
                '0',
                0,
                0,
                0,
                0,
                '269|63',
              ],
              ZA: [
                '27',
                '00',
                '[1-79]\\d{8}|8\\d{4,9}',
                [5, 6, 7, 8, 9, 10],
                [
                  ['(\\d{2})(\\d{3,4})', '$1 $2', ['8[1-4]'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{2,3})', '$1 $2 $3', ['8[1-4]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['860'], '0$1'],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['[1-9]'], '0$1'],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['8'], '0$1'],
                ],
                '0',
              ],
              ZM: [
                '260',
                '00',
                '800\\d{6}|(?:21|63|[79]\\d)\\d{7}',
                [9],
                [
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[28]'], '0$1'],
                  ['(\\d{2})(\\d{7})', '$1 $2', ['[79]'], '0$1'],
                ],
                '0',
              ],
              ZW: [
                '263',
                '00',
                '2(?:[0-57-9]\\d{6,8}|6[0-24-9]\\d{6,7})|[38]\\d{9}|[35-8]\\d{8}|[3-6]\\d{7}|[1-689]\\d{6}|[1-3569]\\d{5}|[1356]\\d{4}',
                [5, 6, 7, 8, 9, 10],
                [
                  [
                    '(\\d{3})(\\d{3,5})',
                    '$1 $2',
                    [
                      '2(?:0[45]|2[278]|[49]8)|3(?:[09]8|17)|6(?:[29]8|37|75)|[23][78]|(?:33|5[15]|6[68])[78]',
                    ],
                    '0$1',
                  ],
                  ['(\\d)(\\d{3})(\\d{2,4})', '$1 $2 $3', ['[49]'], '0$1'],
                  ['(\\d{3})(\\d{4})', '$1 $2', ['80'], '0$1'],
                  [
                    '(\\d{2})(\\d{7})',
                    '$1 $2',
                    [
                      '24|8[13-59]|(?:2[05-79]|39|5[45]|6[15-8])2',
                      '2(?:02[014]|4|[56]20|[79]2)|392|5(?:42|525)|6(?:[16-8]21|52[013])|8[13-59]',
                    ],
                    '(0$1)',
                  ],
                  ['(\\d{2})(\\d{3})(\\d{4})', '$1 $2 $3', ['7'], '0$1'],
                  [
                    '(\\d{3})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    [
                      '2(?:1[39]|2[0157]|[378]|[56][14])|3(?:12|29)',
                      '2(?:1[39]|2[0157]|[378]|[56][14])|3(?:123|29)',
                    ],
                    '0$1',
                  ],
                  ['(\\d{4})(\\d{6})', '$1 $2', ['8'], '0$1'],
                  [
                    '(\\d{2})(\\d{3,5})',
                    '$1 $2',
                    [
                      '1|2(?:0[0-36-9]|12|29|[56])|3(?:1[0-689]|[24-6])|5(?:[0236-9]|1[2-4])|6(?:[013-59]|7[0-46-9])|(?:33|55|6[68])[0-69]|(?:29|3[09]|62)[0-79]',
                    ],
                    '0$1',
                  ],
                  [
                    '(\\d{2})(\\d{3})(\\d{3,4})',
                    '$1 $2 $3',
                    ['29[013-9]|39|54'],
                    '0$1',
                  ],
                  [
                    '(\\d{4})(\\d{3,5})',
                    '$1 $2',
                    ['(?:25|54)8', '258|5483'],
                    '0$1',
                  ],
                ],
                '0',
              ],
            },
            nonGeographic: {
              800: [
                '800',
                0,
                '(?:00|[1-9]\\d)\\d{6}',
                [8],
                [['(\\d{4})(\\d{4})', '$1 $2', ['\\d']]],
                0,
                0,
                0,
                0,
                0,
                0,
                [0, 0, ['(?:00|[1-9]\\d)\\d{6}']],
              ],
              808: [
                '808',
                0,
                '[1-9]\\d{7}',
                [8],
                [['(\\d{4})(\\d{4})', '$1 $2', ['[1-9]']]],
                0,
                0,
                0,
                0,
                0,
                0,
                [0, 0, 0, 0, 0, 0, 0, 0, 0, ['[1-9]\\d{7}']],
              ],
              870: [
                '870',
                0,
                '7\\d{11}|[35-7]\\d{8}',
                [9, 12],
                [['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['[35-7]']]],
                0,
                0,
                0,
                0,
                0,
                0,
                [0, ['(?:[356]|774[45])\\d{8}|7[6-8]\\d{7}']],
              ],
              878: [
                '878',
                0,
                '10\\d{10}',
                [12],
                [['(\\d{2})(\\d{5})(\\d{5})', '$1 $2 $3', ['1']]],
                0,
                0,
                0,
                0,
                0,
                0,
                [0, 0, 0, 0, 0, 0, 0, 0, ['10\\d{10}']],
              ],
              881: [
                '881',
                0,
                '[0-36-9]\\d{8}',
                [9],
                [['(\\d)(\\d{3})(\\d{5})', '$1 $2 $3', ['[0-36-9]']]],
                0,
                0,
                0,
                0,
                0,
                0,
                [0, ['[0-36-9]\\d{8}']],
              ],
              882: [
                '882',
                0,
                '[13]\\d{6}(?:\\d{2,5})?|285\\d{9}|(?:[19]\\d|49)\\d{6}',
                [7, 8, 9, 10, 11, 12],
                [
                  ['(\\d{2})(\\d{5})', '$1 $2', ['16|342']],
                  ['(\\d{2})(\\d{6})', '$1 $2', ['4']],
                  ['(\\d{2})(\\d{2})(\\d{4})', '$1 $2 $3', ['[19]']],
                  ['(\\d{2})(\\d{4})(\\d{3})', '$1 $2 $3', ['3[23]']],
                  ['(\\d{2})(\\d{3,4})(\\d{4})', '$1 $2 $3', ['1']],
                  ['(\\d{2})(\\d{4})(\\d{4})', '$1 $2 $3', ['34[57]']],
                  ['(\\d{3})(\\d{4})(\\d{4})', '$1 $2 $3', ['34']],
                  ['(\\d{2})(\\d{4,5})(\\d{5})', '$1 $2 $3', ['[1-3]']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                [
                  0,
                  [
                    '342\\d{4}|(?:337|49)\\d{6}|3(?:2|47|7\\d{3})\\d{7}',
                    [7, 8, 9, 10, 12],
                  ],
                  0,
                  0,
                  0,
                  0,
                  0,
                  0,
                  [
                    '1(?:3(?:0[0347]|[13][0139]|2[035]|4[013568]|6[0459]|7[06]|8[15-8]|9[0689])\\d{4}|6\\d{5,10})|(?:(?:285\\d\\d|3(?:45|[69]\\d{3}))\\d|9[89])\\d{6}',
                  ],
                ],
              ],
              883: [
                '883',
                0,
                '(?:210|370\\d\\d)\\d{7}|51\\d{7}(?:\\d{3})?',
                [9, 10, 12],
                [
                  ['(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3', ['510']],
                  ['(\\d{3})(\\d{3})(\\d{4})', '$1 $2 $3', ['2']],
                  ['(\\d{4})(\\d{4})(\\d{4})', '$1 $2 $3', ['51[13]']],
                  ['(\\d{3})(\\d{3})(\\d{3})(\\d{3})', '$1 $2 $3 $4', ['[35]']],
                ],
                0,
                0,
                0,
                0,
                0,
                0,
                [
                  0,
                  0,
                  0,
                  0,
                  0,
                  0,
                  0,
                  0,
                  ['(?:210|(?:370[1-9]|51[013]0)\\d)\\d{7}|5100\\d{5}'],
                ],
              ],
              888: [
                '888',
                0,
                '\\d{11}',
                [11],
                [['(\\d{3})(\\d{3})(\\d{5})', '$1 $2 $3']],
                0,
                0,
                0,
                0,
                0,
                0,
                [0, 0, 0, 0, 0, 0, ['\\d{11}']],
              ],
              979: [
                '979',
                0,
                '[1359]\\d{8}',
                [9],
                [['(\\d)(\\d{4})(\\d{4})', '$1 $2 $3', ['[1359]']]],
                0,
                0,
                0,
                0,
                0,
                0,
                [0, 0, 0, ['[1359]\\d{8}']],
              ],
            },
          };
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/min/exports/withMetadataArgument.js
          // Importing from a ".js" file is a workaround for Node.js "ES Modules"
          // importing system which is even uncapable of importing "*.json" files.

          function withMetadataArgument(func, _arguments) {
            var args = Array.prototype.slice.call(_arguments);
            args.push(metadata_min_json);
            return func.apply(this, args);
          }
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/tools/semver-compare.js
          // Copy-pasted from:
          // https://github.com/substack/semver-compare/blob/master/index.js
          //
          // Inlining this function because some users reported issues with
          // importing from `semver-compare` in a browser with ES6 "native" modules.
          //
          // Fixes `semver-compare` not being able to compare versions with alpha/beta/etc "tags".
          // https://github.com/catamphetamine/libphonenumber-js/issues/381
          /* harmony default export */ var semver_compare = function (a, b) {
            a = a.split('-');
            b = b.split('-');
            var pa = a[0].split('.');
            var pb = b[0].split('.');

            for (var i = 0; i < 3; i++) {
              var na = Number(pa[i]);
              var nb = Number(pb[i]);
              if (na > nb) return 1;
              if (nb > na) return -1;
              if (!isNaN(na) && isNaN(nb)) return 1;
              if (isNaN(na) && !isNaN(nb)) return -1;
            }

            if (a[1] && b[1]) {
              return a[1] > b[1] ? 1 : a[1] < b[1] ? -1 : 0;
            }

            return !a[1] && b[1] ? 1 : a[1] && !b[1] ? -1 : 0;
          };
          //# sourceMappingURL=semver-compare.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/metadata.js
          function _typeof(obj) {
            '@babel/helpers - typeof';
            return (
              (_typeof =
                'function' == typeof Symbol &&
                'symbol' == typeof Symbol.iterator
                  ? function (obj) {
                      return typeof obj;
                    }
                  : function (obj) {
                      return obj &&
                        'function' == typeof Symbol &&
                        obj.constructor === Symbol &&
                        obj !== Symbol.prototype
                        ? 'symbol'
                        : typeof obj;
                    }),
              _typeof(obj)
            );
          }

          function _classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function _defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function _createClass(Constructor, protoProps, staticProps) {
            if (protoProps)
              _defineProperties(Constructor.prototype, protoProps);
            if (staticProps) _defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          // Added "possibleLengths" and renamed
          // "country_phone_code_to_countries" to "country_calling_codes".

          var V2 = '1.0.18'; // Added "idd_prefix" and "default_idd_prefix".

          var V3 = '1.2.0'; // Moved `001` country code to "nonGeographic" section of metadata.

          var V4 = '1.7.35';
          var DEFAULT_EXT_PREFIX = ' ext. ';
          var CALLING_CODE_REG_EXP = /^\d+$/;
          /**
           * See: https://gitlab.com/catamphetamine/libphonenumber-js/blob/master/METADATA.md
           */

          var Metadata = /*#__PURE__*/ (function () {
            function Metadata(metadata) {
              _classCallCheck(this, Metadata);

              validateMetadata(metadata);
              this.metadata = metadata;
              setVersion.call(this, metadata);
            }

            _createClass(Metadata, [
              {
                key: 'getCountries',
                value: function getCountries() {
                  return Object.keys(this.metadata.countries).filter(
                    function (_) {
                      return _ !== '001';
                    }
                  );
                },
              },
              {
                key: 'getCountryMetadata',
                value: function getCountryMetadata(countryCode) {
                  return this.metadata.countries[countryCode];
                },
              },
              {
                key: 'nonGeographic',
                value: function nonGeographic() {
                  if (this.v1 || this.v2 || this.v3) return; // `nonGeographical` was a typo.
                  // It's present in metadata generated from `1.7.35` to `1.7.37`.
                  // The test case could be found by searching for "nonGeographical".

                  return (
                    this.metadata.nonGeographic || this.metadata.nonGeographical
                  );
                },
              },
              {
                key: 'hasCountry',
                value: function hasCountry(country) {
                  return this.getCountryMetadata(country) !== undefined;
                },
              },
              {
                key: 'hasCallingCode',
                value: function hasCallingCode(callingCode) {
                  if (this.getCountryCodesForCallingCode(callingCode)) {
                    return true;
                  }

                  if (this.nonGeographic()) {
                    if (this.nonGeographic()[callingCode]) {
                      return true;
                    }
                  } else {
                    // A hacky workaround for old custom metadata (generated before V4).
                    var countryCodes = this.countryCallingCodes()[callingCode];

                    if (
                      countryCodes &&
                      countryCodes.length === 1 &&
                      countryCodes[0] === '001'
                    ) {
                      return true;
                    }
                  }
                },
              },
              {
                key: 'isNonGeographicCallingCode',
                value: function isNonGeographicCallingCode(callingCode) {
                  if (this.nonGeographic()) {
                    return this.nonGeographic()[callingCode] ? true : false;
                  } else {
                    return this.getCountryCodesForCallingCode(callingCode)
                      ? false
                      : true;
                  }
                }, // Deprecated.
              },
              {
                key: 'country',
                value: function country(countryCode) {
                  return this.selectNumberingPlan(countryCode);
                },
              },
              {
                key: 'selectNumberingPlan',
                value: function selectNumberingPlan(countryCode, callingCode) {
                  // Supports just passing `callingCode` as the first argument.
                  if (countryCode && CALLING_CODE_REG_EXP.test(countryCode)) {
                    callingCode = countryCode;
                    countryCode = null;
                  }

                  if (countryCode && countryCode !== '001') {
                    if (!this.hasCountry(countryCode)) {
                      throw new Error('Unknown country: '.concat(countryCode));
                    }

                    this.numberingPlan = new NumberingPlan(
                      this.getCountryMetadata(countryCode),
                      this
                    );
                  } else if (callingCode) {
                    if (!this.hasCallingCode(callingCode)) {
                      throw new Error(
                        'Unknown calling code: '.concat(callingCode)
                      );
                    }

                    this.numberingPlan = new NumberingPlan(
                      this.getNumberingPlanMetadata(callingCode),
                      this
                    );
                  } else {
                    this.numberingPlan = undefined;
                  }

                  return this;
                },
              },
              {
                key: 'getCountryCodesForCallingCode',
                value: function getCountryCodesForCallingCode(callingCode) {
                  var countryCodes = this.countryCallingCodes()[callingCode];

                  if (countryCodes) {
                    // Metadata before V4 included "non-geographic entity" calling codes
                    // inside `country_calling_codes` (for example, `"881":["001"]`).
                    // Now the semantics of `country_calling_codes` has changed:
                    // it's specifically for "countries" now.
                    // Older versions of custom metadata will simply skip parsing
                    // "non-geographic entity" phone numbers with new versions
                    // of this library: it's not considered a bug,
                    // because such numbers are extremely rare,
                    // and developers extremely rarely use custom metadata.
                    if (
                      countryCodes.length === 1 &&
                      countryCodes[0].length === 3
                    ) {
                      return;
                    }

                    return countryCodes;
                  }
                },
              },
              {
                key: 'getCountryCodeForCallingCode',
                value: function getCountryCodeForCallingCode(callingCode) {
                  var countryCodes =
                    this.getCountryCodesForCallingCode(callingCode);

                  if (countryCodes) {
                    return countryCodes[0];
                  }
                },
              },
              {
                key: 'getNumberingPlanMetadata',
                value: function getNumberingPlanMetadata(callingCode) {
                  var countryCode =
                    this.getCountryCodeForCallingCode(callingCode);

                  if (countryCode) {
                    return this.getCountryMetadata(countryCode);
                  }

                  if (this.nonGeographic()) {
                    var metadata = this.nonGeographic()[callingCode];

                    if (metadata) {
                      return metadata;
                    }
                  } else {
                    // A hacky workaround for old custom metadata (generated before V4).
                    // In that metadata, there was no concept of "non-geographic" metadata
                    // so metadata for `001` country code was stored along with other countries.
                    // The test case can be found by searching for:
                    // "should work around `nonGeographic` metadata not existing".
                    var countryCodes = this.countryCallingCodes()[callingCode];

                    if (
                      countryCodes &&
                      countryCodes.length === 1 &&
                      countryCodes[0] === '001'
                    ) {
                      return this.metadata.countries['001'];
                    }
                  }
                }, // Deprecated.
              },
              {
                key: 'countryCallingCode',
                value: function countryCallingCode() {
                  return this.numberingPlan.callingCode();
                }, // Deprecated.
              },
              {
                key: 'IDDPrefix',
                value: function IDDPrefix() {
                  return this.numberingPlan.IDDPrefix();
                }, // Deprecated.
              },
              {
                key: 'defaultIDDPrefix',
                value: function defaultIDDPrefix() {
                  return this.numberingPlan.defaultIDDPrefix();
                }, // Deprecated.
              },
              {
                key: 'nationalNumberPattern',
                value: function nationalNumberPattern() {
                  return this.numberingPlan.nationalNumberPattern();
                }, // Deprecated.
              },
              {
                key: 'possibleLengths',
                value: function possibleLengths() {
                  return this.numberingPlan.possibleLengths();
                }, // Deprecated.
              },
              {
                key: 'formats',
                value: function formats() {
                  return this.numberingPlan.formats();
                }, // Deprecated.
              },
              {
                key: 'nationalPrefixForParsing',
                value: function nationalPrefixForParsing() {
                  return this.numberingPlan.nationalPrefixForParsing();
                }, // Deprecated.
              },
              {
                key: 'nationalPrefixTransformRule',
                value: function nationalPrefixTransformRule() {
                  return this.numberingPlan.nationalPrefixTransformRule();
                }, // Deprecated.
              },
              {
                key: 'leadingDigits',
                value: function leadingDigits() {
                  return this.numberingPlan.leadingDigits();
                }, // Deprecated.
              },
              {
                key: 'hasTypes',
                value: function hasTypes() {
                  return this.numberingPlan.hasTypes();
                }, // Deprecated.
              },
              {
                key: 'type',
                value: function type(_type) {
                  return this.numberingPlan.type(_type);
                }, // Deprecated.
              },
              {
                key: 'ext',
                value: function ext() {
                  return this.numberingPlan.ext();
                },
              },
              {
                key: 'countryCallingCodes',
                value: function countryCallingCodes() {
                  if (this.v1)
                    return this.metadata.country_phone_code_to_countries;
                  return this.metadata.country_calling_codes;
                }, // Deprecated.
              },
              {
                key: 'chooseCountryByCountryCallingCode',
                value: function chooseCountryByCountryCallingCode(callingCode) {
                  return this.selectNumberingPlan(callingCode);
                },
              },
              {
                key: 'hasSelectedNumberingPlan',
                value: function hasSelectedNumberingPlan() {
                  return this.numberingPlan !== undefined;
                },
              },
            ]);

            return Metadata;
          })();

          var NumberingPlan = /*#__PURE__*/ (function () {
            function NumberingPlan(metadata, globalMetadataObject) {
              _classCallCheck(this, NumberingPlan);

              this.globalMetadataObject = globalMetadataObject;
              this.metadata = metadata;
              setVersion.call(this, globalMetadataObject.metadata);
            }

            _createClass(NumberingPlan, [
              {
                key: 'callingCode',
                value: function callingCode() {
                  return this.metadata[0];
                }, // Formatting information for regions which share
                // a country calling code is contained by only one region
                // for performance reasons. For example, for NANPA region
                // ("North American Numbering Plan Administration",
                //  which includes USA, Canada, Cayman Islands, Bahamas, etc)
                // it will be contained in the metadata for `US`.
              },
              {
                key: 'getDefaultCountryMetadataForRegion',
                value: function getDefaultCountryMetadataForRegion() {
                  return this.globalMetadataObject.getNumberingPlanMetadata(
                    this.callingCode()
                  );
                }, // Is always present.
              },
              {
                key: 'IDDPrefix',
                value: function IDDPrefix() {
                  if (this.v1 || this.v2) return;
                  return this.metadata[1];
                }, // Is only present when a country supports multiple IDD prefixes.
              },
              {
                key: 'defaultIDDPrefix',
                value: function defaultIDDPrefix() {
                  if (this.v1 || this.v2) return;
                  return this.metadata[12];
                },
              },
              {
                key: 'nationalNumberPattern',
                value: function nationalNumberPattern() {
                  if (this.v1 || this.v2) return this.metadata[1];
                  return this.metadata[2];
                }, // "possible length" data is always present in Google's metadata.
              },
              {
                key: 'possibleLengths',
                value: function possibleLengths() {
                  if (this.v1) return;
                  return this.metadata[this.v2 ? 2 : 3];
                },
              },
              {
                key: '_getFormats',
                value: function _getFormats(metadata) {
                  return metadata[this.v1 ? 2 : this.v2 ? 3 : 4];
                }, // For countries of the same region (e.g. NANPA)
                // formats are all stored in the "main" country for that region.
                // E.g. "RU" and "KZ", "US" and "CA".
              },
              {
                key: 'formats',
                value: function formats() {
                  var _this = this;

                  var formats =
                    this._getFormats(this.metadata) ||
                    this._getFormats(
                      this.getDefaultCountryMetadataForRegion()
                    ) ||
                    [];
                  return formats.map(function (_) {
                    return new Format(_, _this);
                  });
                },
              },
              {
                key: 'nationalPrefix',
                value: function nationalPrefix() {
                  return this.metadata[this.v1 ? 3 : this.v2 ? 4 : 5];
                },
              },
              {
                key: '_getNationalPrefixFormattingRule',
                value: function _getNationalPrefixFormattingRule(metadata) {
                  return metadata[this.v1 ? 4 : this.v2 ? 5 : 6];
                }, // For countries of the same region (e.g. NANPA)
                // national prefix formatting rule is stored in the "main" country for that region.
                // E.g. "RU" and "KZ", "US" and "CA".
              },
              {
                key: 'nationalPrefixFormattingRule',
                value: function nationalPrefixFormattingRule() {
                  return (
                    this._getNationalPrefixFormattingRule(this.metadata) ||
                    this._getNationalPrefixFormattingRule(
                      this.getDefaultCountryMetadataForRegion()
                    )
                  );
                },
              },
              {
                key: '_nationalPrefixForParsing',
                value: function _nationalPrefixForParsing() {
                  return this.metadata[this.v1 ? 5 : this.v2 ? 6 : 7];
                },
              },
              {
                key: 'nationalPrefixForParsing',
                value: function nationalPrefixForParsing() {
                  // If `national_prefix_for_parsing` is not set explicitly,
                  // then infer it from `national_prefix` (if any)
                  return (
                    this._nationalPrefixForParsing() || this.nationalPrefix()
                  );
                },
              },
              {
                key: 'nationalPrefixTransformRule',
                value: function nationalPrefixTransformRule() {
                  return this.metadata[this.v1 ? 6 : this.v2 ? 7 : 8];
                },
              },
              {
                key: '_getNationalPrefixIsOptionalWhenFormatting',
                value: function _getNationalPrefixIsOptionalWhenFormatting() {
                  return !!this.metadata[this.v1 ? 7 : this.v2 ? 8 : 9];
                }, // For countries of the same region (e.g. NANPA)
                // "national prefix is optional when formatting" flag is
                // stored in the "main" country for that region.
                // E.g. "RU" and "KZ", "US" and "CA".
              },
              {
                key: 'nationalPrefixIsOptionalWhenFormattingInNationalFormat',
                value:
                  function nationalPrefixIsOptionalWhenFormattingInNationalFormat() {
                    return (
                      this._getNationalPrefixIsOptionalWhenFormatting(
                        this.metadata
                      ) ||
                      this._getNationalPrefixIsOptionalWhenFormatting(
                        this.getDefaultCountryMetadataForRegion()
                      )
                    );
                  },
              },
              {
                key: 'leadingDigits',
                value: function leadingDigits() {
                  return this.metadata[this.v1 ? 8 : this.v2 ? 9 : 10];
                },
              },
              {
                key: 'types',
                value: function types() {
                  return this.metadata[this.v1 ? 9 : this.v2 ? 10 : 11];
                },
              },
              {
                key: 'hasTypes',
                value: function hasTypes() {
                  // Versions 1.2.0 - 1.2.4: can be `[]`.

                  /* istanbul ignore next */
                  if (this.types() && this.types().length === 0) {
                    return false;
                  } // Versions <= 1.2.4: can be `undefined`.
                  // Version >= 1.2.5: can be `0`.

                  return !!this.types();
                },
              },
              {
                key: 'type',
                value: function type(_type2) {
                  if (
                    this.hasTypes() &&
                    metadata_getType(this.types(), _type2)
                  ) {
                    return new Type(
                      metadata_getType(this.types(), _type2),
                      this
                    );
                  }
                },
              },
              {
                key: 'ext',
                value: function ext() {
                  if (this.v1 || this.v2) return DEFAULT_EXT_PREFIX;
                  return this.metadata[13] || DEFAULT_EXT_PREFIX;
                },
              },
            ]);

            return NumberingPlan;
          })();

          var Format = /*#__PURE__*/ (function () {
            function Format(format, metadata) {
              _classCallCheck(this, Format);

              this._format = format;
              this.metadata = metadata;
            }

            _createClass(Format, [
              {
                key: 'pattern',
                value: function pattern() {
                  return this._format[0];
                },
              },
              {
                key: 'format',
                value: function format() {
                  return this._format[1];
                },
              },
              {
                key: 'leadingDigitsPatterns',
                value: function leadingDigitsPatterns() {
                  return this._format[2] || [];
                },
              },
              {
                key: 'nationalPrefixFormattingRule',
                value: function nationalPrefixFormattingRule() {
                  return (
                    this._format[3] ||
                    this.metadata.nationalPrefixFormattingRule()
                  );
                },
              },
              {
                key: 'nationalPrefixIsOptionalWhenFormattingInNationalFormat',
                value:
                  function nationalPrefixIsOptionalWhenFormattingInNationalFormat() {
                    return (
                      !!this._format[4] ||
                      this.metadata.nationalPrefixIsOptionalWhenFormattingInNationalFormat()
                    );
                  },
              },
              {
                key: 'nationalPrefixIsMandatoryWhenFormattingInNationalFormat',
                value:
                  function nationalPrefixIsMandatoryWhenFormattingInNationalFormat() {
                    // National prefix is omitted if there's no national prefix formatting rule
                    // set for this country, or when the national prefix formatting rule
                    // contains no national prefix itself, or when this rule is set but
                    // national prefix is optional for this phone number format
                    // (and it is not enforced explicitly)
                    return (
                      this.usesNationalPrefix() &&
                      !this.nationalPrefixIsOptionalWhenFormattingInNationalFormat()
                    );
                  }, // Checks whether national prefix formatting rule contains national prefix.
              },
              {
                key: 'usesNationalPrefix',
                value: function usesNationalPrefix() {
                  return this.nationalPrefixFormattingRule() && // Check that national prefix formatting rule is not a "dummy" one.
                    !FIRST_GROUP_ONLY_PREFIX_PATTERN.test(
                      this.nationalPrefixFormattingRule()
                    ) // In compressed metadata, `this.nationalPrefixFormattingRule()` is `0`
                    ? // when `national_prefix_formatting_rule` is not present.
                      // So, `true` or `false` are returned explicitly here, so that
                      // `0` number isn't returned.
                      true
                    : false;
                },
              },
              {
                key: 'internationalFormat',
                value: function internationalFormat() {
                  return this._format[5] || this.format();
                },
              },
            ]);

            return Format;
          })();
          /**
           * A pattern that is used to determine if the national prefix formatting rule
           * has the first group only, i.e., does not start with the national prefix.
           * Note that the pattern explicitly allows for unbalanced parentheses.
           */

          var FIRST_GROUP_ONLY_PREFIX_PATTERN = /^\(?\$1\)?$/;

          var Type = /*#__PURE__*/ (function () {
            function Type(type, metadata) {
              _classCallCheck(this, Type);

              this.type = type;
              this.metadata = metadata;
            }

            _createClass(Type, [
              {
                key: 'pattern',
                value: function pattern() {
                  if (this.metadata.v1) return this.type;
                  return this.type[0];
                },
              },
              {
                key: 'possibleLengths',
                value: function possibleLengths() {
                  if (this.metadata.v1) return;
                  return this.type[1] || this.metadata.possibleLengths();
                },
              },
            ]);

            return Type;
          })();

          function metadata_getType(types, type) {
            switch (type) {
              case 'FIXED_LINE':
                return types[0];

              case 'MOBILE':
                return types[1];

              case 'TOLL_FREE':
                return types[2];

              case 'PREMIUM_RATE':
                return types[3];

              case 'PERSONAL_NUMBER':
                return types[4];

              case 'VOICEMAIL':
                return types[5];

              case 'UAN':
                return types[6];

              case 'PAGER':
                return types[7];

              case 'VOIP':
                return types[8];

              case 'SHARED_COST':
                return types[9];
            }
          }

          function validateMetadata(metadata) {
            if (!metadata) {
              throw new Error(
                '[libphonenumber-js] `metadata` argument not passed. Check your arguments.'
              );
            } // `country_phone_code_to_countries` was renamed to
            // `country_calling_codes` in `1.0.18`.

            if (!is_object(metadata) || !is_object(metadata.countries)) {
              throw new Error(
                "[libphonenumber-js] `metadata` argument was passed but it's not a valid metadata. Must be an object having `.countries` child object property. Got ".concat(
                  is_object(metadata)
                    ? 'an object of shape: { ' +
                        Object.keys(metadata).join(', ') +
                        ' }'
                    : 'a ' + type_of(metadata) + ': ' + metadata,
                  '.'
                )
              );
            }
          } // Babel transforms `typeof` into some "branches"
          // so istanbul will show this as "branch not covered".

          /* istanbul ignore next */

          var is_object = function is_object(_) {
            return _typeof(_) === 'object';
          }; // Babel transforms `typeof` into some "branches"
          // so istanbul will show this as "branch not covered".

          /* istanbul ignore next */

          var type_of = function type_of(_) {
            return _typeof(_);
          };
          /**
           * Returns extension prefix for a country.
           * @param  {string} country
           * @param  {object} metadata
           * @return {string?}
           * @example
           * // Returns " ext. "
           * getExtPrefix("US")
           */

          function getExtPrefix(country, metadata) {
            metadata = new Metadata(metadata);

            if (metadata.hasCountry(country)) {
              return metadata.country(country).ext();
            }

            return DEFAULT_EXT_PREFIX;
          }
          /**
           * Returns "country calling code" for a country.
           * Throws an error if the country doesn't exist or isn't supported by this library.
           * @param  {string} country
           * @param  {object} metadata
           * @return {string}
           * @example
           * // Returns "44"
           * getCountryCallingCode("GB")
           */

          function getCountryCallingCode(country, metadata) {
            metadata = new Metadata(metadata);

            if (metadata.hasCountry(country)) {
              return metadata.country(country).countryCallingCode();
            }

            throw new Error('Unknown country: '.concat(country));
          }
          function isSupportedCountry(country, metadata) {
            // metadata = new Metadata(metadata)
            // return metadata.hasCountry(country)
            return metadata.countries[country] !== undefined;
          }

          function setVersion(metadata) {
            var version = metadata.version;

            if (typeof version === 'number') {
              this.v1 = version === 1;
              this.v2 = version === 2;
              this.v3 = version === 3;
              this.v4 = version === 4;
            } else {
              if (!version) {
                this.v1 = true;
              } else if (semver_compare(version, V3) === -1) {
                this.v2 = true;
              } else if (semver_compare(version, V4) === -1) {
                this.v3 = true;
              } else {
                this.v4 = true;
              }
            }
          } // const ISO_COUNTRY_CODE = /^[A-Z]{2}$/
          // function isCountryCode(countryCode) {
          // 	return ISO_COUNTRY_CODE.test(countryCodeOrCountryCallingCode)
          // }
          //# sourceMappingURL=metadata.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/mergeArrays.js
          function _createForOfIteratorHelperLoose(o, allowArrayLike) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = _unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function _unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string') return _arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return _arrayLikeToArray(o, minLen);
          }

          function _arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          /**
           * Merges two arrays.
           * @param  {*} a
           * @param  {*} b
           * @return {*}
           */
          function mergeArrays(a, b) {
            var merged = a.slice();

            for (
              var _iterator = _createForOfIteratorHelperLoose(b), _step;
              !(_step = _iterator()).done;

            ) {
              var element = _step.value;

              if (a.indexOf(element) < 0) {
                merged.push(element);
              }
            }

            return merged.sort(function (a, b) {
              return a - b;
            }); // ES6 version, requires Set polyfill.
            // let merged = new Set(a)
            // for (const element of b) {
            // 	merged.add(i)
            // }
            // return Array.from(merged).sort((a, b) => a - b)
          }
          //# sourceMappingURL=mergeArrays.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/checkNumberLength.js

          function checkNumberLength(nationalNumber, metadata) {
            return checkNumberLengthForType(
              nationalNumber,
              undefined,
              metadata
            );
          } // Checks whether a number is possible for the country based on its length.
          // Should only be called for the "new" metadata which has "possible lengths".

          function checkNumberLengthForType(nationalNumber, type, metadata) {
            var type_info = metadata.type(type); // There should always be "<possiblePengths/>" set for every type element.
            // This is declared in the XML schema.
            // For size efficiency, where a sub-description (e.g. fixed-line)
            // has the same "<possiblePengths/>" as the "general description", this is missing,
            // so we fall back to the "general description". Where no numbers of the type
            // exist at all, there is one possible length (-1) which is guaranteed
            // not to match the length of any real phone number.

            var possible_lengths =
              (type_info && type_info.possibleLengths()) ||
              metadata.possibleLengths(); // let local_lengths    = type_info && type.possibleLengthsLocal() || metadata.possibleLengthsLocal()
            // Metadata before version `1.0.18` didn't contain `possible_lengths`.

            if (!possible_lengths) {
              return 'IS_POSSIBLE';
            }

            if (type === 'FIXED_LINE_OR_MOBILE') {
              // No such country in metadata.

              /* istanbul ignore next */
              if (!metadata.type('FIXED_LINE')) {
                // The rare case has been encountered where no fixedLine data is available
                // (true for some non-geographic entities), so we just check mobile.
                return checkNumberLengthForType(
                  nationalNumber,
                  'MOBILE',
                  metadata
                );
              }

              var mobile_type = metadata.type('MOBILE');

              if (mobile_type) {
                // Merge the mobile data in if there was any. "Concat" creates a new
                // array, it doesn't edit possible_lengths in place, so we don't need a copy.
                // Note that when adding the possible lengths from mobile, we have
                // to again check they aren't empty since if they are this indicates
                // they are the same as the general desc and should be obtained from there.
                possible_lengths = mergeArrays(
                  possible_lengths,
                  mobile_type.possibleLengths()
                ); // The current list is sorted; we need to merge in the new list and
                // re-sort (duplicates are okay). Sorting isn't so expensive because
                // the lists are very small.
                // if (local_lengths) {
                // 	local_lengths = mergeArrays(local_lengths, mobile_type.possibleLengthsLocal())
                // } else {
                // 	local_lengths = mobile_type.possibleLengthsLocal()
                // }
              }
            } // If the type doesn't exist then return 'INVALID_LENGTH'.
            else if (type && !type_info) {
              return 'INVALID_LENGTH';
            }

            var actual_length = nationalNumber.length; // In `libphonenumber-js` all "local-only" formats are dropped for simplicity.
            // // This is safe because there is never an overlap beween the possible lengths
            // // and the local-only lengths; this is checked at build time.
            // if (local_lengths && local_lengths.indexOf(nationalNumber.length) >= 0)
            // {
            // 	return 'IS_POSSIBLE_LOCAL_ONLY'
            // }

            var minimum_length = possible_lengths[0];

            if (minimum_length === actual_length) {
              return 'IS_POSSIBLE';
            }

            if (minimum_length > actual_length) {
              return 'TOO_SHORT';
            }

            if (possible_lengths[possible_lengths.length - 1] < actual_length) {
              return 'TOO_LONG';
            } // We skip the first element since we've already checked it.

            return possible_lengths.indexOf(actual_length, 1) >= 0
              ? 'IS_POSSIBLE'
              : 'INVALID_LENGTH';
          }
          //# sourceMappingURL=checkNumberLength.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/isPossibleNumber_.js

          function isPossiblePhoneNumber(input, options, metadata) {
            /* istanbul ignore if */
            if (options === undefined) {
              options = {};
            }

            metadata = new Metadata(metadata);

            if (options.v2) {
              if (!input.countryCallingCode) {
                throw new Error('Invalid phone number object passed');
              }

              metadata.selectNumberingPlan(input.countryCallingCode);
            } else {
              if (!input.phone) {
                return false;
              }

              if (input.country) {
                if (!metadata.hasCountry(input.country)) {
                  throw new Error('Unknown country: '.concat(input.country));
                }

                metadata.country(input.country);
              } else {
                if (!input.countryCallingCode) {
                  throw new Error('Invalid phone number object passed');
                }

                metadata.selectNumberingPlan(input.countryCallingCode);
              }
            } // Old metadata (< 1.0.18) had no "possible length" data.

            if (metadata.possibleLengths()) {
              return isPossibleNumber(
                input.phone || input.nationalNumber,
                metadata
              );
            } else {
              // There was a bug between `1.7.35` and `1.7.37` where "possible_lengths"
              // were missing for "non-geographical" numbering plans.
              // Just assume the number is possible in such cases:
              // it's unlikely that anyone generated their custom metadata
              // in that short period of time (one day).
              // This code can be removed in some future major version update.
              if (
                input.countryCallingCode &&
                metadata.isNonGeographicCallingCode(input.countryCallingCode)
              ) {
                // "Non-geographic entities" did't have `possibleLengths`
                // due to a bug in metadata generation process.
                return true;
              } else {
                throw new Error(
                  'Missing "possibleLengths" in metadata. Perhaps the metadata has been generated before v1.0.18.'
                );
              }
            }
          }
          function isPossibleNumber(nationalNumber, metadata) {
            //, isInternational) {
            switch (checkNumberLength(nationalNumber, metadata)) {
              case 'IS_POSSIBLE':
                return true;
              // This library ignores "local-only" phone numbers (for simplicity).
              // See the readme for more info on what are "local-only" phone numbers.
              // case 'IS_POSSIBLE_LOCAL_ONLY':
              // 	return !isInternational

              default:
                return false;
            }
          }
          //# sourceMappingURL=isPossibleNumber_.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/matchesEntirely.js
          /**
           * Checks whether the entire input sequence can be matched
           * against the regular expression.
           * @return {boolean}
           */
          function matchesEntirely(text, regular_expression) {
            // If assigning the `''` default value is moved to the arguments above,
            // code coverage would decrease for some weird reason.
            text = text || '';
            return new RegExp('^(?:' + regular_expression + ')$').test(text);
          }
          //# sourceMappingURL=matchesEntirely.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/getNumberType.js
          function getNumberType_createForOfIteratorHelperLoose(
            o,
            allowArrayLike
          ) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = getNumberType_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function getNumberType_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return getNumberType_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return getNumberType_arrayLikeToArray(o, minLen);
          }

          function getNumberType_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          var NON_FIXED_LINE_PHONE_TYPES = [
            'MOBILE',
            'PREMIUM_RATE',
            'TOLL_FREE',
            'SHARED_COST',
            'VOIP',
            'PERSONAL_NUMBER',
            'PAGER',
            'UAN',
            'VOICEMAIL',
          ]; // Finds out national phone number type (fixed line, mobile, etc)

          function getNumberType(input, options, metadata) {
            // If assigning the `{}` default value is moved to the arguments above,
            // code coverage would decrease for some weird reason.
            options = options || {}; // When `parse()` returned `{}`
            // meaning that the phone number is not a valid one.

            if (!input.country) {
              return;
            }

            metadata = new Metadata(metadata);
            metadata.selectNumberingPlan(
              input.country,
              input.countryCallingCode
            );
            var nationalNumber = options.v2
              ? input.nationalNumber
              : input.phone; // The following is copy-pasted from the original function:
            // https://github.com/googlei18n/libphonenumber/blob/3ea547d4fbaa2d0b67588904dfa5d3f2557c27ff/javascript/i18n/phonenumbers/phonenumberutil.js#L2835
            // Is this national number even valid for this country

            if (
              !matchesEntirely(nationalNumber, metadata.nationalNumberPattern())
            ) {
              return;
            } // Is it fixed line number

            if (isNumberTypeEqualTo(nationalNumber, 'FIXED_LINE', metadata)) {
              // Because duplicate regular expressions are removed
              // to reduce metadata size, if "mobile" pattern is ""
              // then it means it was removed due to being a duplicate of the fixed-line pattern.
              //
              if (
                metadata.type('MOBILE') &&
                metadata.type('MOBILE').pattern() === ''
              ) {
                return 'FIXED_LINE_OR_MOBILE';
              } // `MOBILE` type pattern isn't included if it matched `FIXED_LINE` one.
              // For example, for "US" country.
              // Old metadata (< `1.0.18`) had a specific "types" data structure
              // that happened to be `undefined` for `MOBILE` in that case.
              // Newer metadata (>= `1.0.18`) has another data structure that is
              // not `undefined` for `MOBILE` in that case (it's just an empty array).
              // So this `if` is just for backwards compatibility with old metadata.

              if (!metadata.type('MOBILE')) {
                return 'FIXED_LINE_OR_MOBILE';
              } // Check if the number happens to qualify as both fixed line and mobile.
              // (no such country in the minimal metadata set)

              /* istanbul ignore if */

              if (isNumberTypeEqualTo(nationalNumber, 'MOBILE', metadata)) {
                return 'FIXED_LINE_OR_MOBILE';
              }

              return 'FIXED_LINE';
            }

            for (
              var _iterator = getNumberType_createForOfIteratorHelperLoose(
                  NON_FIXED_LINE_PHONE_TYPES
                ),
                _step;
              !(_step = _iterator()).done;

            ) {
              var type = _step.value;

              if (isNumberTypeEqualTo(nationalNumber, type, metadata)) {
                return type;
              }
            }
          }
          function isNumberTypeEqualTo(nationalNumber, type, metadata) {
            type = metadata.type(type);

            if (!type || !type.pattern()) {
              return false;
            } // Check if any possible number lengths are present;
            // if so, we use them to avoid checking
            // the validation pattern if they don't match.
            // If they are absent, this means they match
            // the general description, which we have
            // already checked before a specific number type.

            if (
              type.possibleLengths() &&
              type.possibleLengths().indexOf(nationalNumber.length) < 0
            ) {
              return false;
            }

            return matchesEntirely(nationalNumber, type.pattern());
          }
          //# sourceMappingURL=getNumberType.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/validate_.js

          /**
           * Checks if a given phone number is valid.
           *
           * If the `number` is a string, it will be parsed to an object,
           * but only if it contains only valid phone number characters (including punctuation).
           * If the `number` is an object, it is used as is.
           *
           * The optional `defaultCountry` argument is the default country.
           * I.e. it does not restrict to just that country,
           * e.g. in those cases where several countries share
           * the same phone numbering rules (NANPA, Britain, etc).
           * For example, even though the number `07624 369230`
           * belongs to the Isle of Man ("IM" country code)
           * calling `isValidNumber('07624369230', 'GB', metadata)`
           * still returns `true` because the country is not restricted to `GB`,
           * it's just that `GB` is the default one for the phone numbering rules.
           * For restricting the country see `isValidNumberForRegion()`
           * though restricting a country might not be a good idea.
           * https://github.com/googlei18n/libphonenumber/blob/master/FAQ.md#when-should-i-use-isvalidnumberforregion
           *
           * Examples:
           *
           * ```js
           * isValidNumber('+78005553535', metadata)
           * isValidNumber('8005553535', 'RU', metadata)
           * isValidNumber('88005553535', 'RU', metadata)
           * isValidNumber({ phone: '8005553535', country: 'RU' }, metadata)
           * ```
           */

          function isValidNumber(input, options, metadata) {
            // If assigning the `{}` default value is moved to the arguments above,
            // code coverage would decrease for some weird reason.
            options = options || {};
            metadata = new Metadata(metadata); // This is just to support `isValidNumber({})`
            // for cases when `parseNumber()` returns `{}`.

            if (!input.country) {
              return false;
            }

            metadata.selectNumberingPlan(
              input.country,
              input.countryCallingCode
            ); // By default, countries only have type regexps when it's required for
            // distinguishing different countries having the same `countryCallingCode`.

            if (metadata.hasTypes()) {
              return (
                getNumberType(input, options, metadata.metadata) !== undefined
              );
            } // If there are no type regexps for this country in metadata then use
            // `nationalNumberPattern` as a "better than nothing" replacement.

            var national_number = options.v2
              ? input.nationalNumber
              : input.phone;
            return matchesEntirely(
              national_number,
              metadata.nationalNumberPattern()
            );
          }
          //# sourceMappingURL=validate_.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/constants.js
          // The minimum length of the national significant number.
          var MIN_LENGTH_FOR_NSN = 2; // The ITU says the maximum length should be 15,
          // but one can find longer numbers in Germany.

          var MAX_LENGTH_FOR_NSN = 17; // The maximum length of the country calling code.

          var MAX_LENGTH_COUNTRY_CODE = 3; // Digits accepted in phone numbers
          // (ascii, fullwidth, arabic-indic, and eastern arabic digits).

          var VALID_DIGITS = '0-9\uFF10-\uFF19\u0660-\u0669\u06F0-\u06F9'; // `DASHES` will be right after the opening square bracket of the "character class"

          var DASHES = '-\u2010-\u2015\u2212\u30FC\uFF0D';
          var SLASHES = '\uFF0F/';
          var DOTS = '\uFF0E.';
          var WHITESPACE = ' \xA0\xAD\u200B\u2060\u3000';
          var BRACKETS = '()\uFF08\uFF09\uFF3B\uFF3D\\[\\]'; // export const OPENING_BRACKETS = '(\uFF08\uFF3B\\\['

          var TILDES = '~\u2053\u223C\uFF5E'; // Regular expression of acceptable punctuation found in phone numbers. This
          // excludes punctuation found as a leading character only. This consists of dash
          // characters, white space characters, full stops, slashes, square brackets,
          // parentheses and tildes. Full-width variants are also present.

          var VALID_PUNCTUATION = ''
            .concat(DASHES)
            .concat(SLASHES)
            .concat(DOTS)
            .concat(WHITESPACE)
            .concat(BRACKETS)
            .concat(TILDES);
          var PLUS_CHARS = '+\uFF0B'; // const LEADING_PLUS_CHARS_PATTERN = new RegExp('^[' + PLUS_CHARS + ']+')
          //# sourceMappingURL=constants.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/applyInternationalSeparatorStyle.js
          // Removes brackets and replaces dashes with spaces.
          //
          // E.g. "(999) 111-22-33" -> "999 111 22 33"
          //
          // For some reason Google's metadata contains `<intlFormat/>`s with brackets and dashes.
          // Meanwhile, there's no single opinion about using punctuation in international phone numbers.
          //
          // For example, Google's `<intlFormat/>` for USA is `+1 213-373-4253`.
          // And here's a quote from WikiPedia's "North American Numbering Plan" page:
          // https://en.wikipedia.org/wiki/North_American_Numbering_Plan
          //
          // "The country calling code for all countries participating in the NANP is 1.
          // In international format, an NANP number should be listed as +1 301 555 01 00,
          // where 301 is an area code (Maryland)."
          //
          // I personally prefer the international format without any punctuation.
          // For example, brackets are remnants of the old age, meaning that the
          // phone number part in brackets (so called "area code") can be omitted
          // if dialing within the same "area".
          // And hyphens were clearly introduced for splitting local numbers into memorizable groups.
          // For example, remembering "5553535" is difficult but "555-35-35" is much simpler.
          // Imagine a man taking a bus from home to work and seeing an ad with a phone number.
          // He has a couple of seconds to memorize that number until it passes by.
          // If it were spaces instead of hyphens the man wouldn't necessarily get it,
          // but with hyphens instead of spaces the grouping is more explicit.
          // I personally think that hyphens introduce visual clutter,
          // so I prefer replacing them with spaces in international numbers.
          // In the modern age all output is done on displays where spaces are clearly distinguishable
          // so hyphens can be safely replaced with spaces without losing any legibility.
          //

          function applyInternationalSeparatorStyle(formattedNumber) {
            return formattedNumber
              .replace(
                new RegExp('['.concat(VALID_PUNCTUATION, ']+'), 'g'),
                ' '
              )
              .trim();
          }
          //# sourceMappingURL=applyInternationalSeparatorStyle.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/formatNationalNumberUsingFormat.js
          // This was originally set to $1 but there are some countries for which the
          // first group is not used in the national pattern (e.g. Argentina) so the $1
          // group does not match correctly. Therefore, we use `\d`, so that the first
          // group actually used in the pattern will be matched.

          var FIRST_GROUP_PATTERN = /(\$\d)/;
          function formatNationalNumberUsingFormat(number, format, _ref) {
            var useInternationalFormat = _ref.useInternationalFormat,
              withNationalPrefix = _ref.withNationalPrefix,
              carrierCode = _ref.carrierCode,
              metadata = _ref.metadata;
            var formattedNumber = number.replace(
              new RegExp(format.pattern()),
              useInternationalFormat
                ? format.internationalFormat() // This library doesn't use `domestic_carrier_code_formatting_rule`,
                : // because that one is only used when formatting phone numbers
                  // for dialing from a mobile phone, and this is not a dialing library.
                  // carrierCode && format.domesticCarrierCodeFormattingRule()
                  // 	// First, replace the $CC in the formatting rule with the desired carrier code.
                  // 	// Then, replace the $FG in the formatting rule with the first group
                  // 	// and the carrier code combined in the appropriate way.
                  // 	? format.format().replace(FIRST_GROUP_PATTERN, format.domesticCarrierCodeFormattingRule().replace('$CC', carrierCode))
                  // 	: (
                  // 		withNationalPrefix && format.nationalPrefixFormattingRule()
                  // 			? format.format().replace(FIRST_GROUP_PATTERN, format.nationalPrefixFormattingRule())
                  // 			: format.format()
                  // 	)
                  withNationalPrefix && format.nationalPrefixFormattingRule()
                  ? format
                      .format()
                      .replace(
                        FIRST_GROUP_PATTERN,
                        format.nationalPrefixFormattingRule()
                      )
                  : format.format()
            );

            if (useInternationalFormat) {
              return applyInternationalSeparatorStyle(formattedNumber);
            }

            return formattedNumber;
          }
          //# sourceMappingURL=formatNationalNumberUsingFormat.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/getIddPrefix.js

          /**
           * Pattern that makes it easy to distinguish whether a region has a single
           * international dialing prefix or not. If a region has a single international
           * prefix (e.g. 011 in USA), it will be represented as a string that contains
           * a sequence of ASCII digits, and possibly a tilde, which signals waiting for
           * the tone. If there are multiple available international prefixes in a
           * region, they will be represented as a regex string that always contains one
           * or more characters that are not ASCII digits or a tilde.
           */

          var SINGLE_IDD_PREFIX_REG_EXP =
            /^[\d]+(?:[~\u2053\u223C\uFF5E][\d]+)?$/; // For regions that have multiple IDD prefixes
          // a preferred IDD prefix is returned.

          function getIddPrefix(country, callingCode, metadata) {
            var countryMetadata = new Metadata(metadata);
            countryMetadata.selectNumberingPlan(country, callingCode);

            if (countryMetadata.defaultIDDPrefix()) {
              return countryMetadata.defaultIDDPrefix();
            }

            if (SINGLE_IDD_PREFIX_REG_EXP.test(countryMetadata.IDDPrefix())) {
              return countryMetadata.IDDPrefix();
            }
          }
          //# sourceMappingURL=getIddPrefix.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/extension/createExtensionPattern.js
          // The RFC 3966 format for extensions.

          var RFC3966_EXTN_PREFIX = ';ext=';
          /**
           * Helper method for constructing regular expressions for parsing. Creates
           * an expression that captures up to max_length digits.
           * @return {string} RegEx pattern to capture extension digits.
           */

          var createExtensionPattern_getExtensionDigitsPattern =
            function getExtensionDigitsPattern(maxLength) {
              return '(['.concat(VALID_DIGITS, ']{1,').concat(maxLength, '})');
            };
          /**
           * Helper initialiser method to create the regular-expression pattern to match
           * extensions.
           * Copy-pasted from Google's `libphonenumber`:
           * https://github.com/google/libphonenumber/blob/55b2646ec9393f4d3d6661b9c82ef9e258e8b829/javascript/i18n/phonenumbers/phonenumberutil.js#L759-L766
           * @return {string} RegEx pattern to capture extensions.
           */

          function createExtensionPattern(purpose) {
            // We cap the maximum length of an extension based on the ambiguity of the way
            // the extension is prefixed. As per ITU, the officially allowed length for
            // extensions is actually 40, but we don't support this since we haven't seen real
            // examples and this introduces many false interpretations as the extension labels
            // are not standardized.

            /** @type {string} */
            var extLimitAfterExplicitLabel = '20';
            /** @type {string} */

            var extLimitAfterLikelyLabel = '15';
            /** @type {string} */

            var extLimitAfterAmbiguousChar = '9';
            /** @type {string} */

            var extLimitWhenNotSure = '6';
            /** @type {string} */

            var possibleSeparatorsBetweenNumberAndExtLabel = '[ \xA0\\t,]*'; // Optional full stop (.) or colon, followed by zero or more spaces/tabs/commas.

            /** @type {string} */

            var possibleCharsAfterExtLabel = '[:\\.\uFF0E]?[ \xA0\\t,-]*';
            /** @type {string} */

            var optionalExtnSuffix = '#?'; // Here the extension is called out in more explicit way, i.e mentioning it obvious
            // patterns like "ext.".

            /** @type {string} */

            var explicitExtLabels =
              '(?:e?xt(?:ensi(?:o\u0301?|\xF3))?n?|\uFF45?\uFF58\uFF54\uFF4E?|\u0434\u043E\u0431|anexo)'; // One-character symbols that can be used to indicate an extension, and less
            // commonly used or more ambiguous extension labels.

            /** @type {string} */

            var ambiguousExtLabels =
              '(?:[x\uFF58#\uFF03~\uFF5E]|int|\uFF49\uFF4E\uFF54)'; // When extension is not separated clearly.

            /** @type {string} */

            var ambiguousSeparator = '[- ]+'; // This is the same as possibleSeparatorsBetweenNumberAndExtLabel, but not matching
            // comma as extension label may have it.

            /** @type {string} */

            var possibleSeparatorsNumberExtLabelNoComma = '[ \xA0\\t]*'; // ",," is commonly used for auto dialling the extension when connected. First
            // comma is matched through possibleSeparatorsBetweenNumberAndExtLabel, so we do
            // not repeat it here. Semi-colon works in Iphone and Android also to pop up a
            // button with the extension number following.

            /** @type {string} */

            var autoDiallingAndExtLabelsFound = '(?:,{2}|;)';
            /** @type {string} */

            var rfcExtn =
              RFC3966_EXTN_PREFIX +
              createExtensionPattern_getExtensionDigitsPattern(
                extLimitAfterExplicitLabel
              );
            /** @type {string} */

            var explicitExtn =
              possibleSeparatorsBetweenNumberAndExtLabel +
              explicitExtLabels +
              possibleCharsAfterExtLabel +
              createExtensionPattern_getExtensionDigitsPattern(
                extLimitAfterExplicitLabel
              ) +
              optionalExtnSuffix;
            /** @type {string} */

            var ambiguousExtn =
              possibleSeparatorsBetweenNumberAndExtLabel +
              ambiguousExtLabels +
              possibleCharsAfterExtLabel +
              createExtensionPattern_getExtensionDigitsPattern(
                extLimitAfterAmbiguousChar
              ) +
              optionalExtnSuffix;
            /** @type {string} */

            var americanStyleExtnWithSuffix =
              ambiguousSeparator +
              createExtensionPattern_getExtensionDigitsPattern(
                extLimitWhenNotSure
              ) +
              '#';
            /** @type {string} */

            var autoDiallingExtn =
              possibleSeparatorsNumberExtLabelNoComma +
              autoDiallingAndExtLabelsFound +
              possibleCharsAfterExtLabel +
              createExtensionPattern_getExtensionDigitsPattern(
                extLimitAfterLikelyLabel
              ) +
              optionalExtnSuffix;
            /** @type {string} */

            var onlyCommasExtn =
              possibleSeparatorsNumberExtLabelNoComma +
              '(?:,)+' +
              possibleCharsAfterExtLabel +
              createExtensionPattern_getExtensionDigitsPattern(
                extLimitAfterAmbiguousChar
              ) +
              optionalExtnSuffix; // The first regular expression covers RFC 3966 format, where the extension is added
            // using ";ext=". The second more generic where extension is mentioned with explicit
            // labels like "ext:". In both the above cases we allow more numbers in extension than
            // any other extension labels. The third one captures when single character extension
            // labels or less commonly used labels are used. In such cases we capture fewer
            // extension digits in order to reduce the chance of falsely interpreting two
            // numbers beside each other as a number + extension. The fourth one covers the
            // special case of American numbers where the extension is written with a hash
            // at the end, such as "- 503#". The fifth one is exclusively for extension
            // autodialling formats which are used when dialling and in this case we accept longer
            // extensions. The last one is more liberal on the number of commas that acts as
            // extension labels, so we have a strict cap on the number of digits in such extensions.

            return (
              rfcExtn +
              '|' +
              explicitExtn +
              '|' +
              ambiguousExtn +
              '|' +
              americanStyleExtnWithSuffix +
              '|' +
              autoDiallingExtn +
              '|' +
              onlyCommasExtn
            );
          }
          //# sourceMappingURL=createExtensionPattern.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/isViablePhoneNumber.js

          //  Regular expression of viable phone numbers. This is location independent.
          //  Checks we have at least three leading digits, and only valid punctuation,
          //  alpha characters and digits in the phone number. Does not include extension
          //  data. The symbol 'x' is allowed here as valid punctuation since it is often
          //  used as a placeholder for carrier codes, for example in Brazilian phone
          //  numbers. We also allow multiple '+' characters at the start.
          //
          //  Corresponds to the following:
          //  [digits]{minLengthNsn}|
          //  plus_sign*
          //  (([punctuation]|[star])*[digits]){3,}([punctuation]|[star]|[digits]|[alpha])*
          //
          //  The first reg-ex is to allow short numbers (two digits long) to be parsed if
          //  they are entered as "15" etc, but only if there is no punctuation in them.
          //  The second expression restricts the number of digits to three or more, but
          //  then allows them to be in international form, and to have alpha-characters
          //  and punctuation. We split up the two reg-exes here and combine them when
          //  creating the reg-ex VALID_PHONE_NUMBER_PATTERN itself so we can prefix it
          //  with ^ and append $ to each branch.
          //
          //  "Note VALID_PUNCTUATION starts with a -,
          //   so must be the first in the range" (c) Google devs.
          //  (wtf did they mean by saying that; probably nothing)
          //

          var MIN_LENGTH_PHONE_NUMBER_PATTERN =
            '[' + VALID_DIGITS + ']{' + MIN_LENGTH_FOR_NSN + '}'; //
          // And this is the second reg-exp:
          // (see MIN_LENGTH_PHONE_NUMBER_PATTERN for a full description of this reg-exp)
          //

          var VALID_PHONE_NUMBER =
            '[' +
            PLUS_CHARS +
            ']{0,1}' +
            '(?:' +
            '[' +
            VALID_PUNCTUATION +
            ']*' +
            '[' +
            VALID_DIGITS +
            ']' +
            '){3,}' +
            '[' +
            VALID_PUNCTUATION +
            VALID_DIGITS +
            ']*'; // This regular expression isn't present in Google's `libphonenumber`
          // and is only used to determine whether the phone number being input
          // is too short for it to even consider it a "valid" number.
          // This is just a way to differentiate between a really invalid phone
          // number like "abcde" and a valid phone number that a user has just
          // started inputting, like "+1" or "1": both these cases would be
          // considered `NOT_A_NUMBER` by Google's `libphonenumber`, but this
          // library can provide a more detailed error message — whether it's
          // really "not a number", or is it just a start of a valid phone number.

          var VALID_PHONE_NUMBER_START_REG_EXP = new RegExp(
            '^' +
              '[' +
              PLUS_CHARS +
              ']{0,1}' +
              '(?:' +
              '[' +
              VALID_PUNCTUATION +
              ']*' +
              '[' +
              VALID_DIGITS +
              ']' +
              '){1,2}' +
              '$',
            'i'
          );
          var VALID_PHONE_NUMBER_WITH_EXTENSION =
            VALID_PHONE_NUMBER + // Phone number extensions
            '(?:' +
            createExtensionPattern() +
            ')?'; // The combined regular expression for valid phone numbers:
          //

          var VALID_PHONE_NUMBER_PATTERN = new RegExp( // Either a short two-digit-only phone number
            '^' +
              MIN_LENGTH_PHONE_NUMBER_PATTERN +
              '$' +
              '|' + // Or a longer fully parsed phone number (min 3 characters)
              '^' +
              VALID_PHONE_NUMBER_WITH_EXTENSION +
              '$',
            'i'
          ); // Checks to see if the string of characters could possibly be a phone number at
          // all. At the moment, checks to see that the string begins with at least 2
          // digits, ignoring any punctuation commonly found in phone numbers. This method
          // does not require the number to be normalized in advance - but does assume
          // that leading non-number symbols have been removed, such as by the method
          // `extract_possible_number`.
          //

          function isViablePhoneNumber(number) {
            return (
              number.length >= MIN_LENGTH_FOR_NSN &&
              VALID_PHONE_NUMBER_PATTERN.test(number)
            );
          } // This is just a way to differentiate between a really invalid phone
          // number like "abcde" and a valid phone number that a user has just
          // started inputting, like "+1" or "1": both these cases would be
          // considered `NOT_A_NUMBER` by Google's `libphonenumber`, but this
          // library can provide a more detailed error message — whether it's
          // really "not a number", or is it just a start of a valid phone number.

          function isViablePhoneNumberStart(number) {
            return VALID_PHONE_NUMBER_START_REG_EXP.test(number);
          }
          //# sourceMappingURL=isViablePhoneNumber.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/RFC3966.js
          function _slicedToArray(arr, i) {
            return (
              _arrayWithHoles(arr) ||
              _iterableToArrayLimit(arr, i) ||
              RFC3966_unsupportedIterableToArray(arr, i) ||
              _nonIterableRest()
            );
          }

          function _nonIterableRest() {
            throw new TypeError(
              'Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function _iterableToArrayLimit(arr, i) {
            var _i =
              arr == null
                ? null
                : (typeof Symbol !== 'undefined' && arr[Symbol.iterator]) ||
                  arr['@@iterator'];
            if (_i == null) return;
            var _arr = [];
            var _n = true;
            var _d = false;
            var _s, _e;
            try {
              for (
                _i = _i.call(arr);
                !(_n = (_s = _i.next()).done);
                _n = true
              ) {
                _arr.push(_s.value);
                if (i && _arr.length === i) break;
              }
            } catch (err) {
              _d = true;
              _e = err;
            } finally {
              try {
                if (!_n && _i['return'] != null) _i['return']();
              } finally {
                if (_d) throw _e;
              }
            }
            return _arr;
          }

          function _arrayWithHoles(arr) {
            if (Array.isArray(arr)) return arr;
          }

          function RFC3966_createForOfIteratorHelperLoose(o, allowArrayLike) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = RFC3966_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function RFC3966_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return RFC3966_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return RFC3966_arrayLikeToArray(o, minLen);
          }

          function RFC3966_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          // https://www.ietf.org/rfc/rfc3966.txt

          /**
           * @param  {string} text - Phone URI (RFC 3966).
           * @return {object} `{ ?number, ?ext }`.
           */

          function parseRFC3966(text) {
            var number;
            var ext; // Replace "tel:" with "tel=" for parsing convenience.

            text = text.replace(/^tel:/, 'tel=');

            for (
              var _iterator = RFC3966_createForOfIteratorHelperLoose(
                  text.split(';')
                ),
                _step;
              !(_step = _iterator()).done;

            ) {
              var part = _step.value;

              var _part$split = part.split('='),
                _part$split2 = _slicedToArray(_part$split, 2),
                name = _part$split2[0],
                value = _part$split2[1];

              switch (name) {
                case 'tel':
                  number = value;
                  break;

                case 'ext':
                  ext = value;
                  break;

                case 'phone-context':
                  // Only "country contexts" are supported.
                  // "Domain contexts" are ignored.
                  if (value[0] === '+') {
                    number = value + number;
                  }

                  break;
              }
            } // If the phone number is not viable, then abort.

            if (!isViablePhoneNumber(number)) {
              return {};
            }

            var result = {
              number: number,
            };

            if (ext) {
              result.ext = ext;
            }

            return result;
          }
          /**
           * @param  {object} - `{ ?number, ?extension }`.
           * @return {string} Phone URI (RFC 3966).
           */

          function formatRFC3966(_ref) {
            var number = _ref.number,
              ext = _ref.ext;

            if (!number) {
              return '';
            }

            if (number[0] !== '+') {
              throw new Error(
                '"formatRFC3966()" expects "number" to be in E.164 format.'
              );
            }

            return 'tel:'.concat(number).concat(ext ? ';ext=' + ext : '');
          }
          //# sourceMappingURL=RFC3966.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/format_.js
          function format_createForOfIteratorHelperLoose(o, allowArrayLike) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = format_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function format_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return format_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return format_arrayLikeToArray(o, minLen);
          }

          function format_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          function ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
              var symbols = Object.getOwnPropertySymbols(object);
              enumerableOnly &&
                (symbols = symbols.filter(function (sym) {
                  return Object.getOwnPropertyDescriptor(object, sym)
                    .enumerable;
                })),
                keys.push.apply(keys, symbols);
            }
            return keys;
          }

          function _objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
              var source = null != arguments[i] ? arguments[i] : {};
              i % 2
                ? ownKeys(Object(source), !0).forEach(function (key) {
                    format_defineProperty(target, key, source[key]);
                  })
                : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(
                      target,
                      Object.getOwnPropertyDescriptors(source)
                    )
                  : ownKeys(Object(source)).forEach(function (key) {
                      Object.defineProperty(
                        target,
                        key,
                        Object.getOwnPropertyDescriptor(source, key)
                      );
                    });
            }
            return target;
          }

          function format_defineProperty(obj, key, value) {
            if (key in obj) {
              Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
              });
            } else {
              obj[key] = value;
            }
            return obj;
          }

          // This is a port of Google Android `libphonenumber`'s
          // `phonenumberutil.js` of December 31th, 2018.
          //
          // https://github.com/googlei18n/libphonenumber/commits/master/javascript/i18n/phonenumbers/phonenumberutil.js

          var DEFAULT_OPTIONS = {
            formatExtension: function formatExtension(
              formattedNumber,
              extension,
              metadata
            ) {
              return ''
                .concat(formattedNumber)
                .concat(metadata.ext())
                .concat(extension);
            },
          }; // Formats a phone number
          //
          // Example use cases:
          //
          // ```js
          // formatNumber('8005553535', 'RU', 'INTERNATIONAL')
          // formatNumber('8005553535', 'RU', 'INTERNATIONAL', metadata)
          // formatNumber({ phone: '8005553535', country: 'RU' }, 'INTERNATIONAL')
          // formatNumber({ phone: '8005553535', country: 'RU' }, 'INTERNATIONAL', metadata)
          // formatNumber('+78005553535', 'NATIONAL')
          // formatNumber('+78005553535', 'NATIONAL', metadata)
          // ```
          //

          function formatNumber(input, format, options, metadata) {
            // Apply default options.
            if (options) {
              options = _objectSpread(
                _objectSpread({}, DEFAULT_OPTIONS),
                options
              );
            } else {
              options = DEFAULT_OPTIONS;
            }

            metadata = new Metadata(metadata);

            if (input.country && input.country !== '001') {
              // Validate `input.country`.
              if (!metadata.hasCountry(input.country)) {
                throw new Error('Unknown country: '.concat(input.country));
              }

              metadata.country(input.country);
            } else if (input.countryCallingCode) {
              metadata.selectNumberingPlan(input.countryCallingCode);
            } else return input.phone || '';

            var countryCallingCode = metadata.countryCallingCode();
            var nationalNumber = options.v2
              ? input.nationalNumber
              : input.phone; // This variable should have been declared inside `case`s
            // but Babel has a bug and it says "duplicate variable declaration".

            var number;

            switch (format) {
              case 'NATIONAL':
                // Legacy argument support.
                // (`{ country: ..., phone: '' }`)
                if (!nationalNumber) {
                  return '';
                }

                number = formatNationalNumber(
                  nationalNumber,
                  input.carrierCode,
                  'NATIONAL',
                  metadata,
                  options
                );
                return addExtension(
                  number,
                  input.ext,
                  metadata,
                  options.formatExtension
                );

              case 'INTERNATIONAL':
                // Legacy argument support.
                // (`{ country: ..., phone: '' }`)
                if (!nationalNumber) {
                  return '+'.concat(countryCallingCode);
                }

                number = formatNationalNumber(
                  nationalNumber,
                  null,
                  'INTERNATIONAL',
                  metadata,
                  options
                );
                number = '+'.concat(countryCallingCode, ' ').concat(number);
                return addExtension(
                  number,
                  input.ext,
                  metadata,
                  options.formatExtension
                );

              case 'E.164':
                // `E.164` doesn't define "phone number extensions".
                return '+'.concat(countryCallingCode).concat(nationalNumber);

              case 'RFC3966':
                return formatRFC3966({
                  number: '+'.concat(countryCallingCode).concat(nationalNumber),
                  ext: input.ext,
                });
              // For reference, here's Google's IDD formatter:
              // https://github.com/google/libphonenumber/blob/32719cf74e68796788d1ca45abc85dcdc63ba5b9/java/libphonenumber/src/com/google/i18n/phonenumbers/PhoneNumberUtil.java#L1546
              // Not saying that this IDD formatter replicates it 1:1, but it seems to work.
              // Who would even need to format phone numbers in IDD format anyway?

              case 'IDD':
                if (!options.fromCountry) {
                  return; // throw new Error('`fromCountry` option not passed for IDD-prefixed formatting.')
                }

                var formattedNumber = formatIDD(
                  nationalNumber,
                  input.carrierCode,
                  countryCallingCode,
                  options.fromCountry,
                  metadata
                );
                return addExtension(
                  formattedNumber,
                  input.ext,
                  metadata,
                  options.formatExtension
                );

              default:
                throw new Error(
                  'Unknown "format" argument passed to "formatNumber()": "'.concat(
                    format,
                    '"'
                  )
                );
            }
          }

          function formatNationalNumber(
            number,
            carrierCode,
            formatAs,
            metadata,
            options
          ) {
            var format = chooseFormatForNumber(metadata.formats(), number);

            if (!format) {
              return number;
            }

            return formatNationalNumberUsingFormat(number, format, {
              useInternationalFormat: formatAs === 'INTERNATIONAL',
              withNationalPrefix:
                format.nationalPrefixIsOptionalWhenFormattingInNationalFormat() &&
                options &&
                options.nationalPrefix === false
                  ? false
                  : true,
              carrierCode: carrierCode,
              metadata: metadata,
            });
          }

          function chooseFormatForNumber(availableFormats, nationalNnumber) {
            for (
              var _iterator =
                  format_createForOfIteratorHelperLoose(availableFormats),
                _step;
              !(_step = _iterator()).done;

            ) {
              var format = _step.value;

              // Validate leading digits.
              // The test case for "else path" could be found by searching for
              // "format.leadingDigitsPatterns().length === 0".
              if (format.leadingDigitsPatterns().length > 0) {
                // The last leading_digits_pattern is used here, as it is the most detailed
                var lastLeadingDigitsPattern =
                  format.leadingDigitsPatterns()[
                    format.leadingDigitsPatterns().length - 1
                  ]; // If leading digits don't match then move on to the next phone number format

                if (nationalNnumber.search(lastLeadingDigitsPattern) !== 0) {
                  continue;
                }
              } // Check that the national number matches the phone number format regular expression

              if (matchesEntirely(nationalNnumber, format.pattern())) {
                return format;
              }
            }
          }

          function addExtension(
            formattedNumber,
            ext,
            metadata,
            formatExtension
          ) {
            return ext
              ? formatExtension(formattedNumber, ext, metadata)
              : formattedNumber;
          }

          function formatIDD(
            nationalNumber,
            carrierCode,
            countryCallingCode,
            fromCountry,
            metadata
          ) {
            var fromCountryCallingCode = getCountryCallingCode(
              fromCountry,
              metadata.metadata
            ); // When calling within the same country calling code.

            if (fromCountryCallingCode === countryCallingCode) {
              var formattedNumber = formatNationalNumber(
                nationalNumber,
                carrierCode,
                'NATIONAL',
                metadata
              ); // For NANPA regions, return the national format for these regions
              // but prefix it with the country calling code.

              if (countryCallingCode === '1') {
                return countryCallingCode + ' ' + formattedNumber;
              } // If regions share a country calling code, the country calling code need
              // not be dialled. This also applies when dialling within a region, so this
              // if clause covers both these cases. Technically this is the case for
              // dialling from La Reunion to other overseas departments of France (French
              // Guiana, Martinique, Guadeloupe), but not vice versa - so we don't cover
              // this edge case for now and for those cases return the version including
              // country calling code. Details here:
              // http://www.petitfute.com/voyage/225-info-pratiques-reunion
              //

              return formattedNumber;
            }

            var iddPrefix = getIddPrefix(
              fromCountry,
              undefined,
              metadata.metadata
            );

            if (iddPrefix) {
              return ''
                .concat(iddPrefix, ' ')
                .concat(countryCallingCode, ' ')
                .concat(
                  formatNationalNumber(
                    nationalNumber,
                    null,
                    'INTERNATIONAL',
                    metadata
                  )
                );
            }
          }
          //# sourceMappingURL=format_.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/PhoneNumber.js
          function PhoneNumber_ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
              var symbols = Object.getOwnPropertySymbols(object);
              enumerableOnly &&
                (symbols = symbols.filter(function (sym) {
                  return Object.getOwnPropertyDescriptor(object, sym)
                    .enumerable;
                })),
                keys.push.apply(keys, symbols);
            }
            return keys;
          }

          function PhoneNumber_objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
              var source = null != arguments[i] ? arguments[i] : {};
              i % 2
                ? PhoneNumber_ownKeys(Object(source), !0).forEach(
                    function (key) {
                      PhoneNumber_defineProperty(target, key, source[key]);
                    }
                  )
                : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(
                      target,
                      Object.getOwnPropertyDescriptors(source)
                    )
                  : PhoneNumber_ownKeys(Object(source)).forEach(function (key) {
                      Object.defineProperty(
                        target,
                        key,
                        Object.getOwnPropertyDescriptor(source, key)
                      );
                    });
            }
            return target;
          }

          function PhoneNumber_defineProperty(obj, key, value) {
            if (key in obj) {
              Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
              });
            } else {
              obj[key] = value;
            }
            return obj;
          }

          function PhoneNumber_classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function PhoneNumber_defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function PhoneNumber_createClass(
            Constructor,
            protoProps,
            staticProps
          ) {
            if (protoProps)
              PhoneNumber_defineProperties(Constructor.prototype, protoProps);
            if (staticProps)
              PhoneNumber_defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          var USE_NON_GEOGRAPHIC_COUNTRY_CODE = false;

          var PhoneNumber_PhoneNumber = /*#__PURE__*/ (function () {
            function PhoneNumber(countryCallingCode, nationalNumber, metadata) {
              PhoneNumber_classCallCheck(this, PhoneNumber);

              if (!countryCallingCode) {
                throw new TypeError(
                  '`country` or `countryCallingCode` not passed'
                );
              }

              if (!nationalNumber) {
                throw new TypeError('`nationalNumber` not passed');
              }

              if (!metadata) {
                throw new TypeError('`metadata` not passed');
              }

              var _metadata = new Metadata(metadata); // If country code is passed then derive `countryCallingCode` from it.
              // Also store the country code as `.country`.

              if (isCountryCode(countryCallingCode)) {
                this.country = countryCallingCode;

                _metadata.country(countryCallingCode);

                countryCallingCode = _metadata.countryCallingCode();
              } else {
                /* istanbul ignore if */
                if (USE_NON_GEOGRAPHIC_COUNTRY_CODE) {
                  if (
                    _metadata.isNonGeographicCallingCode(countryCallingCode)
                  ) {
                    this.country = '001';
                  }
                }
              }

              this.countryCallingCode = countryCallingCode;
              this.nationalNumber = nationalNumber;
              this.number = '+' + this.countryCallingCode + this.nationalNumber;
              this.metadata = metadata;
            }

            PhoneNumber_createClass(PhoneNumber, [
              {
                key: 'setExt',
                value: function setExt(ext) {
                  this.ext = ext;
                },
              },
              {
                key: 'isPossible',
                value: function isPossible() {
                  return isPossiblePhoneNumber(
                    this,
                    {
                      v2: true,
                    },
                    this.metadata
                  );
                },
              },
              {
                key: 'isValid',
                value: function isValid() {
                  return isValidNumber(
                    this,
                    {
                      v2: true,
                    },
                    this.metadata
                  );
                },
              },
              {
                key: 'isNonGeographic',
                value: function isNonGeographic() {
                  var metadata = new Metadata(this.metadata);
                  return metadata.isNonGeographicCallingCode(
                    this.countryCallingCode
                  );
                },
              },
              {
                key: 'isEqual',
                value: function isEqual(phoneNumber) {
                  return (
                    this.number === phoneNumber.number &&
                    this.ext === phoneNumber.ext
                  );
                }, // // Is just an alias for `this.isValid() && this.country === country`.
                // // https://github.com/googlei18n/libphonenumber/blob/master/FAQ.md#when-should-i-use-isvalidnumberforregion
                // isValidForRegion(country) {
                // 	return isValidNumberForRegion(this, country, { v2: true }, this.metadata)
                // }
              },
              {
                key: 'getType',
                value: function getType() {
                  return getNumberType(
                    this,
                    {
                      v2: true,
                    },
                    this.metadata
                  );
                },
              },
              {
                key: 'format',
                value: function format(_format, options) {
                  return formatNumber(
                    this,
                    _format,
                    options
                      ? PhoneNumber_objectSpread(
                          PhoneNumber_objectSpread({}, options),
                          {},
                          {
                            v2: true,
                          }
                        )
                      : {
                          v2: true,
                        },
                    this.metadata
                  );
                },
              },
              {
                key: 'formatNational',
                value: function formatNational(options) {
                  return this.format('NATIONAL', options);
                },
              },
              {
                key: 'formatInternational',
                value: function formatInternational(options) {
                  return this.format('INTERNATIONAL', options);
                },
              },
              {
                key: 'getURI',
                value: function getURI(options) {
                  return this.format('RFC3966', options);
                },
              },
            ]);

            return PhoneNumber;
          })();

          var isCountryCode = function isCountryCode(value) {
            return /^[A-Z]{2}$/.test(value);
          };
          //# sourceMappingURL=PhoneNumber.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/getExampleNumber.js

          function getExampleNumber(country, examples, metadata) {
            if (examples[country]) {
              return new PhoneNumber_PhoneNumber(
                country,
                examples[country],
                metadata
              );
            }
          }
          //# sourceMappingURL=getExampleNumber.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/min/exports/getExampleNumber.js

          function getExampleNumber_getExampleNumber() {
            return withMetadataArgument(getExampleNumber, arguments);
          }
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/ParseError.js
          function ParseError_typeof(obj) {
            '@babel/helpers - typeof';
            return (
              (ParseError_typeof =
                'function' == typeof Symbol &&
                'symbol' == typeof Symbol.iterator
                  ? function (obj) {
                      return typeof obj;
                    }
                  : function (obj) {
                      return obj &&
                        'function' == typeof Symbol &&
                        obj.constructor === Symbol &&
                        obj !== Symbol.prototype
                        ? 'symbol'
                        : typeof obj;
                    }),
              ParseError_typeof(obj)
            );
          }

          function ParseError_defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function ParseError_createClass(
            Constructor,
            protoProps,
            staticProps
          ) {
            if (protoProps)
              ParseError_defineProperties(Constructor.prototype, protoProps);
            if (staticProps)
              ParseError_defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          function ParseError_classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function _inherits(subClass, superClass) {
            if (typeof superClass !== 'function' && superClass !== null) {
              throw new TypeError(
                'Super expression must either be null or a function'
              );
            }
            subClass.prototype = Object.create(
              superClass && superClass.prototype,
              {
                constructor: {
                  value: subClass,
                  writable: true,
                  configurable: true,
                },
              }
            );
            Object.defineProperty(subClass, 'prototype', { writable: false });
            if (superClass) _setPrototypeOf(subClass, superClass);
          }

          function _createSuper(Derived) {
            var hasNativeReflectConstruct = _isNativeReflectConstruct();
            return function _createSuperInternal() {
              var Super = _getPrototypeOf(Derived),
                result;
              if (hasNativeReflectConstruct) {
                var NewTarget = _getPrototypeOf(this).constructor;
                result = Reflect.construct(Super, arguments, NewTarget);
              } else {
                result = Super.apply(this, arguments);
              }
              return _possibleConstructorReturn(this, result);
            };
          }

          function _possibleConstructorReturn(self, call) {
            if (
              call &&
              (ParseError_typeof(call) === 'object' ||
                typeof call === 'function')
            ) {
              return call;
            } else if (call !== void 0) {
              throw new TypeError(
                'Derived constructors may only return object or undefined'
              );
            }
            return _assertThisInitialized(self);
          }

          function _assertThisInitialized(self) {
            if (self === void 0) {
              throw new ReferenceError(
                "this hasn't been initialised - super() hasn't been called"
              );
            }
            return self;
          }

          function _wrapNativeSuper(Class) {
            var _cache = typeof Map === 'function' ? new Map() : undefined;
            _wrapNativeSuper = function _wrapNativeSuper(Class) {
              if (Class === null || !_isNativeFunction(Class)) return Class;
              if (typeof Class !== 'function') {
                throw new TypeError(
                  'Super expression must either be null or a function'
                );
              }
              if (typeof _cache !== 'undefined') {
                if (_cache.has(Class)) return _cache.get(Class);
                _cache.set(Class, Wrapper);
              }
              function Wrapper() {
                return _construct(
                  Class,
                  arguments,
                  _getPrototypeOf(this).constructor
                );
              }
              Wrapper.prototype = Object.create(Class.prototype, {
                constructor: {
                  value: Wrapper,
                  enumerable: false,
                  writable: true,
                  configurable: true,
                },
              });
              return _setPrototypeOf(Wrapper, Class);
            };
            return _wrapNativeSuper(Class);
          }

          function _construct(Parent, args, Class) {
            if (_isNativeReflectConstruct()) {
              _construct = Reflect.construct;
            } else {
              _construct = function _construct(Parent, args, Class) {
                var a = [null];
                a.push.apply(a, args);
                var Constructor = Function.bind.apply(Parent, a);
                var instance = new Constructor();
                if (Class) _setPrototypeOf(instance, Class.prototype);
                return instance;
              };
            }
            return _construct.apply(null, arguments);
          }

          function _isNativeReflectConstruct() {
            if (typeof Reflect === 'undefined' || !Reflect.construct)
              return false;
            if (Reflect.construct.sham) return false;
            if (typeof Proxy === 'function') return true;
            try {
              Boolean.prototype.valueOf.call(
                Reflect.construct(Boolean, [], function () {})
              );
              return true;
            } catch (e) {
              return false;
            }
          }

          function _isNativeFunction(fn) {
            return Function.toString.call(fn).indexOf('[native code]') !== -1;
          }

          function _setPrototypeOf(o, p) {
            _setPrototypeOf =
              Object.setPrototypeOf ||
              function _setPrototypeOf(o, p) {
                o.__proto__ = p;
                return o;
              };
            return _setPrototypeOf(o, p);
          }

          function _getPrototypeOf(o) {
            _getPrototypeOf = Object.setPrototypeOf
              ? Object.getPrototypeOf
              : function _getPrototypeOf(o) {
                  return o.__proto__ || Object.getPrototypeOf(o);
                };
            return _getPrototypeOf(o);
          }

          // https://stackoverflow.com/a/46971044/970769
          // "Breaking changes in Typescript 2.1"
          // "Extending built-ins like Error, Array, and Map may no longer work."
          // "As a recommendation, you can manually adjust the prototype immediately after any super(...) calls."
          // https://github.com/Microsoft/TypeScript-wiki/blob/main/Breaking-Changes.md#extending-built-ins-like-error-array-and-map-may-no-longer-work
          var ParseError = /*#__PURE__*/ (function (_Error) {
            _inherits(ParseError, _Error);

            var _super = _createSuper(ParseError);

            function ParseError(code) {
              var _this;

              ParseError_classCallCheck(this, ParseError);

              _this = _super.call(this, code); // Set the prototype explicitly.
              // Any subclass of FooError will have to manually set the prototype as well.

              Object.setPrototypeOf(
                _assertThisInitialized(_this),
                ParseError.prototype
              );
              _this.name = _this.constructor.name;
              return _this;
            }

            return ParseError_createClass(ParseError);
          })(/*#__PURE__*/ _wrapNativeSuper(Error));

          //# sourceMappingURL=ParseError.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/extension/extractExtension.js
          // Regexp of all known extension prefixes used by different regions followed by
          // 1 or more valid digits, for use when parsing.

          var EXTN_PATTERN = new RegExp(
            '(?:' + createExtensionPattern() + ')$',
            'i'
          ); // Strips any extension (as in, the part of the number dialled after the call is
          // connected, usually indicated with extn, ext, x or similar) from the end of
          // the number, and returns it.

          function extractExtension(number) {
            var start = number.search(EXTN_PATTERN);

            if (start < 0) {
              return {};
            } // If we find a potential extension, and the number preceding this is a viable
            // number, we assume it is an extension.

            var numberWithoutExtension = number.slice(0, start);
            var matches = number.match(EXTN_PATTERN);
            var i = 1;

            while (i < matches.length) {
              if (matches[i]) {
                return {
                  number: numberWithoutExtension,
                  ext: matches[i],
                };
              }

              i++;
            }
          }
          //# sourceMappingURL=extractExtension.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/parseDigits.js
          function parseDigits_createForOfIteratorHelperLoose(
            o,
            allowArrayLike
          ) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = parseDigits_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function parseDigits_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return parseDigits_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return parseDigits_arrayLikeToArray(o, minLen);
          }

          function parseDigits_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          // These mappings map a character (key) to a specific digit that should
          // replace it for normalization purposes. Non-European digits that
          // may be used in phone numbers are mapped to a European equivalent.
          //
          // E.g. in Iraq they don't write `+442323234` but rather `+٤٤٢٣٢٣٢٣٤`.
          //
          var DIGITS = {
            0: '0',
            1: '1',
            2: '2',
            3: '3',
            4: '4',
            5: '5',
            6: '6',
            7: '7',
            8: '8',
            9: '9',
            '\uFF10': '0',
            // Fullwidth digit 0
            '\uFF11': '1',
            // Fullwidth digit 1
            '\uFF12': '2',
            // Fullwidth digit 2
            '\uFF13': '3',
            // Fullwidth digit 3
            '\uFF14': '4',
            // Fullwidth digit 4
            '\uFF15': '5',
            // Fullwidth digit 5
            '\uFF16': '6',
            // Fullwidth digit 6
            '\uFF17': '7',
            // Fullwidth digit 7
            '\uFF18': '8',
            // Fullwidth digit 8
            '\uFF19': '9',
            // Fullwidth digit 9
            '\u0660': '0',
            // Arabic-indic digit 0
            '\u0661': '1',
            // Arabic-indic digit 1
            '\u0662': '2',
            // Arabic-indic digit 2
            '\u0663': '3',
            // Arabic-indic digit 3
            '\u0664': '4',
            // Arabic-indic digit 4
            '\u0665': '5',
            // Arabic-indic digit 5
            '\u0666': '6',
            // Arabic-indic digit 6
            '\u0667': '7',
            // Arabic-indic digit 7
            '\u0668': '8',
            // Arabic-indic digit 8
            '\u0669': '9',
            // Arabic-indic digit 9
            '\u06F0': '0',
            // Eastern-Arabic digit 0
            '\u06F1': '1',
            // Eastern-Arabic digit 1
            '\u06F2': '2',
            // Eastern-Arabic digit 2
            '\u06F3': '3',
            // Eastern-Arabic digit 3
            '\u06F4': '4',
            // Eastern-Arabic digit 4
            '\u06F5': '5',
            // Eastern-Arabic digit 5
            '\u06F6': '6',
            // Eastern-Arabic digit 6
            '\u06F7': '7',
            // Eastern-Arabic digit 7
            '\u06F8': '8',
            // Eastern-Arabic digit 8
            '\u06F9': '9', // Eastern-Arabic digit 9
          };
          function parseDigit(character) {
            return DIGITS[character];
          }
          /**
           * Parses phone number digits from a string.
           * Drops all punctuation leaving only digits.
           * Also converts wide-ascii and arabic-indic numerals to conventional numerals.
           * E.g. in Iraq they don't write `+442323234` but rather `+٤٤٢٣٢٣٢٣٤`.
           * @param  {string} string
           * @return {string}
           * @example
           * ```js
           * parseDigits('8 (800) 555')
           * // Outputs '8800555'.
           * ```
           */

          function parseDigits(string) {
            var result = ''; // Using `.split('')` here instead of normal `for ... of`
            // because the importing application doesn't neccessarily include an ES6 polyfill.
            // The `.split('')` approach discards "exotic" UTF-8 characters
            // (the ones consisting of four bytes) but digits
            // (including non-European ones) don't fall into that range
            // so such "exotic" characters would be discarded anyway.

            for (
              var _iterator = parseDigits_createForOfIteratorHelperLoose(
                  string.split('')
                ),
                _step;
              !(_step = _iterator()).done;

            ) {
              var character = _step.value;
              var digit = parseDigit(character);

              if (digit) {
                result += digit;
              }
            }

            return result;
          }
          //# sourceMappingURL=parseDigits.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/parseIncompletePhoneNumber.js
          function parseIncompletePhoneNumber_createForOfIteratorHelperLoose(
            o,
            allowArrayLike
          ) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = parseIncompletePhoneNumber_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function parseIncompletePhoneNumber_unsupportedIterableToArray(
            o,
            minLen
          ) {
            if (!o) return;
            if (typeof o === 'string')
              return parseIncompletePhoneNumber_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return parseIncompletePhoneNumber_arrayLikeToArray(o, minLen);
          }

          function parseIncompletePhoneNumber_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          /**
           * Parses phone number characters from a string.
           * Drops all punctuation leaving only digits and the leading `+` sign (if any).
           * Also converts wide-ascii and arabic-indic numerals to conventional numerals.
           * E.g. in Iraq they don't write `+442323234` but rather `+٤٤٢٣٢٣٢٣٤`.
           * @param  {string} string
           * @return {string}
           * @example
           * ```js
           * // Outputs '8800555'.
           * parseIncompletePhoneNumber('8 (800) 555')
           * // Outputs '+7800555'.
           * parseIncompletePhoneNumber('+7 800 555')
           * ```
           */

          function parseIncompletePhoneNumber(string) {
            var result = ''; // Using `.split('')` here instead of normal `for ... of`
            // because the importing application doesn't neccessarily include an ES6 polyfill.
            // The `.split('')` approach discards "exotic" UTF-8 characters
            // (the ones consisting of four bytes) but digits
            // (including non-European ones) don't fall into that range
            // so such "exotic" characters would be discarded anyway.

            for (
              var _iterator =
                  parseIncompletePhoneNumber_createForOfIteratorHelperLoose(
                    string.split('')
                  ),
                _step;
              !(_step = _iterator()).done;

            ) {
              var character = _step.value;
              result += parsePhoneNumberCharacter(character, result) || '';
            }

            return result;
          }
          /**
           * Parses next character while parsing phone number digits (including a `+`)
           * from text: discards everything except `+` and digits, and `+` is only allowed
           * at the start of a phone number.
           * For example, is used in `react-phone-number-input` where it uses
           * [`input-format`](https://gitlab.com/catamphetamine/input-format).
           * @param  {string} character - Yet another character from raw input string.
           * @param  {string?} prevParsedCharacters - Previous parsed characters.
           * @param  {object} meta - Optional custom use-case-specific metadata.
           * @return {string?} The parsed character.
           */

          function parsePhoneNumberCharacter(character, prevParsedCharacters) {
            // Only allow a leading `+`.
            if (character === '+') {
              // If this `+` is not the first parsed character
              // then discard it.
              if (prevParsedCharacters) {
                return;
              }

              return '+';
            } // Allow digits.

            return parseDigit(character);
          }
          //# sourceMappingURL=parseIncompletePhoneNumber.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/stripIddPrefix.js

          var CAPTURING_DIGIT_PATTERN = new RegExp('([' + VALID_DIGITS + '])');
          function stripIddPrefix(number, country, callingCode, metadata) {
            if (!country) {
              return;
            } // Check if the number is IDD-prefixed.

            var countryMetadata = new Metadata(metadata);
            countryMetadata.selectNumberingPlan(country, callingCode);
            var IDDPrefixPattern = new RegExp(countryMetadata.IDDPrefix());

            if (number.search(IDDPrefixPattern) !== 0) {
              return;
            } // Strip IDD prefix.

            number = number.slice(number.match(IDDPrefixPattern)[0].length); // If there're any digits after an IDD prefix,
            // then those digits are a country calling code.
            // Since no country code starts with a `0`,
            // the code below validates that the next digit (if present) is not `0`.

            var matchedGroups = number.match(CAPTURING_DIGIT_PATTERN);

            if (
              matchedGroups &&
              matchedGroups[1] != null &&
              matchedGroups[1].length > 0
            ) {
              if (matchedGroups[1] === '0') {
                return;
              }
            }

            return number;
          }
          //# sourceMappingURL=stripIddPrefix.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/extractNationalNumberFromPossiblyIncompleteNumber.js
          /**
           * Strips any national prefix (such as 0, 1) present in a
           * (possibly incomplete) number provided.
           * "Carrier codes" are only used  in Colombia and Brazil,
           * and only when dialing within those countries from a mobile phone to a fixed line number.
           * Sometimes it won't actually strip national prefix
           * and will instead prepend some digits to the `number`:
           * for example, when number `2345678` is passed with `VI` country selected,
           * it will return `{ number: "3402345678" }`, because `340` area code is prepended.
           * @param {string} number — National number digits.
           * @param {object} metadata — Metadata with country selected.
           * @return {object} `{ nationalNumber: string, nationalPrefix: string? carrierCode: string? }`. Even if a national prefix was extracted, it's not necessarily present in the returned object, so don't rely on its presence in the returned object in order to find out whether a national prefix has been extracted or not.
           */
          function extractNationalNumberFromPossiblyIncompleteNumber(
            number,
            metadata
          ) {
            if (number && metadata.numberingPlan.nationalPrefixForParsing()) {
              // See METADATA.md for the description of
              // `national_prefix_for_parsing` and `national_prefix_transform_rule`.
              // Attempt to parse the first digits as a national prefix.
              var prefixPattern = new RegExp(
                '^(?:' + metadata.numberingPlan.nationalPrefixForParsing() + ')'
              );
              var prefixMatch = prefixPattern.exec(number);

              if (prefixMatch) {
                var nationalNumber;
                var carrierCode; // https://gitlab.com/catamphetamine/libphonenumber-js/-/blob/master/METADATA.md#national_prefix_for_parsing--national_prefix_transform_rule
                // If a `national_prefix_for_parsing` has any "capturing groups"
                // then it means that the national (significant) number is equal to
                // those "capturing groups" transformed via `national_prefix_transform_rule`,
                // and nothing could be said about the actual national prefix:
                // what is it and was it even there.
                // If a `national_prefix_for_parsing` doesn't have any "capturing groups",
                // then everything it matches is a national prefix.
                // To determine whether `national_prefix_for_parsing` matched any
                // "capturing groups", the value of the result of calling `.exec()`
                // is looked at, and if it has non-undefined values where there're
                // "capturing groups" in the regular expression, then it means
                // that "capturing groups" have been matched.
                // It's not possible to tell whether there'll be any "capturing gropus"
                // before the matching process, because a `national_prefix_for_parsing`
                // could exhibit both behaviors.

                var capturedGroupsCount = prefixMatch.length - 1;
                var hasCapturedGroups =
                  capturedGroupsCount > 0 && prefixMatch[capturedGroupsCount];

                if (
                  metadata.nationalPrefixTransformRule() &&
                  hasCapturedGroups
                ) {
                  nationalNumber = number.replace(
                    prefixPattern,
                    metadata.nationalPrefixTransformRule()
                  ); // If there's more than one captured group,
                  // then carrier code is the second one.

                  if (capturedGroupsCount > 1) {
                    carrierCode = prefixMatch[1];
                  }
                } // If there're no "capturing groups",
                // or if there're "capturing groups" but no
                // `national_prefix_transform_rule`,
                // then just strip the national prefix from the number,
                // and possibly a carrier code.
                // Seems like there could be more.
                else {
                  // `prefixBeforeNationalNumber` is the whole substring matched by
                  // the `national_prefix_for_parsing` regular expression.
                  // There seem to be no guarantees that it's just a national prefix.
                  // For example, if there's a carrier code, it's gonna be a
                  // part of `prefixBeforeNationalNumber` too.
                  var prefixBeforeNationalNumber = prefixMatch[0];
                  nationalNumber = number.slice(
                    prefixBeforeNationalNumber.length
                  ); // If there's at least one captured group,
                  // then carrier code is the first one.

                  if (hasCapturedGroups) {
                    carrierCode = prefixMatch[1];
                  }
                } // Tries to guess whether a national prefix was present in the input.
                // This is not something copy-pasted from Google's library:
                // they don't seem to have an equivalent for that.
                // So this isn't an "officially approved" way of doing something like that.
                // But since there seems no other existing method, this library uses it.

                var nationalPrefix;

                if (hasCapturedGroups) {
                  var possiblePositionOfTheFirstCapturedGroup = number.indexOf(
                    prefixMatch[1]
                  );
                  var possibleNationalPrefix = number.slice(
                    0,
                    possiblePositionOfTheFirstCapturedGroup
                  ); // Example: an Argentinian (AR) phone number `0111523456789`.
                  // `prefixMatch[0]` is `01115`, and `$1` is `11`,
                  // and the rest of the phone number is `23456789`.
                  // The national number is transformed via `9$1` to `91123456789`.
                  // National prefix `0` is detected being present at the start.
                  // if (possibleNationalPrefix.indexOf(metadata.numberingPlan.nationalPrefix()) === 0) {

                  if (
                    possibleNationalPrefix ===
                    metadata.numberingPlan.nationalPrefix()
                  ) {
                    nationalPrefix = metadata.numberingPlan.nationalPrefix();
                  }
                } else {
                  nationalPrefix = prefixMatch[0];
                }

                return {
                  nationalNumber: nationalNumber,
                  nationalPrefix: nationalPrefix,
                  carrierCode: carrierCode,
                };
              }
            }

            return {
              nationalNumber: number,
            };
          }
          //# sourceMappingURL=extractNationalNumberFromPossiblyIncompleteNumber.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/extractNationalNumber.js

          /**
           * Strips national prefix and carrier code from a complete phone number.
           * The difference from the non-"FromCompleteNumber" function is that
           * it won't extract national prefix if the resultant number is too short
           * to be a complete number for the selected phone numbering plan.
           * @param  {string} number — Complete phone number digits.
           * @param  {Metadata} metadata — Metadata with a phone numbering plan selected.
           * @return {object} `{ nationalNumber: string, carrierCode: string? }`.
           */

          function extractNationalNumber(number, metadata) {
            // Parsing national prefixes and carrier codes
            // is only required for local phone numbers
            // but some people don't understand that
            // and sometimes write international phone numbers
            // with national prefixes (or maybe even carrier codes).
            // http://ucken.blogspot.ru/2016/03/trunk-prefixes-in-skype4b.html
            // Google's original library forgives such mistakes
            // and so does this library, because it has been requested:
            // https://github.com/catamphetamine/libphonenumber-js/issues/127
            var _extractNationalNumbe =
                extractNationalNumberFromPossiblyIncompleteNumber(
                  number,
                  metadata
                ),
              carrierCode = _extractNationalNumbe.carrierCode,
              nationalNumber = _extractNationalNumbe.nationalNumber;

            if (nationalNumber !== number) {
              if (
                !shouldHaveExtractedNationalPrefix(
                  number,
                  nationalNumber,
                  metadata
                )
              ) {
                // Don't strip the national prefix.
                return {
                  nationalNumber: number,
                };
              } // Check the national (significant) number length after extracting national prefix and carrier code.
              // Legacy generated metadata (before `1.0.18`) didn't support the "possible lengths" feature.

              if (metadata.possibleLengths()) {
                // The number remaining after stripping the national prefix and carrier code
                // should be long enough to have a possible length for the country.
                // Otherwise, don't strip the national prefix and carrier code,
                // since the original number could be a valid number.
                // This check has been copy-pasted "as is" from Google's original library:
                // https://github.com/google/libphonenumber/blob/876268eb1ad6cdc1b7b5bef17fc5e43052702d57/java/libphonenumber/src/com/google/i18n/phonenumbers/PhoneNumberUtil.java#L3236-L3250
                // It doesn't check for the "possibility" of the original `number`.
                // I guess it's fine not checking that one. It works as is anyway.
                if (
                  !isPossibleIncompleteNationalNumber(nationalNumber, metadata)
                ) {
                  // Don't strip the national prefix.
                  return {
                    nationalNumber: number,
                  };
                }
              }
            }

            return {
              nationalNumber: nationalNumber,
              carrierCode: carrierCode,
            };
          } // In some countries, the same digit could be a national prefix
          // or a leading digit of a valid phone number.
          // For example, in Russia, national prefix is `8`,
          // and also `800 555 35 35` is a valid number
          // in which `8` is not a national prefix, but the first digit
          // of a national (significant) number.
          // Same's with Belarus:
          // `82004910060` is a valid national (significant) number,
          // but `2004910060` is not.
          // To support such cases (to prevent the code from always stripping
          // national prefix), a condition is imposed: a national prefix
          // is not extracted when the original number is "viable" and the
          // resultant number is not, a "viable" national number being the one
          // that matches `national_number_pattern`.

          function shouldHaveExtractedNationalPrefix(
            nationalNumberBefore,
            nationalNumberAfter,
            metadata
          ) {
            // The equivalent in Google's code is:
            // https://github.com/google/libphonenumber/blob/e326fa1fc4283bb05eb35cb3c15c18f98a31af33/java/libphonenumber/src/com/google/i18n/phonenumbers/PhoneNumberUtil.java#L2969-L3004
            if (
              matchesEntirely(
                nationalNumberBefore,
                metadata.nationalNumberPattern()
              ) &&
              !matchesEntirely(
                nationalNumberAfter,
                metadata.nationalNumberPattern()
              )
            ) {
              return false;
            } // This "is possible" national number (length) check has been commented out
            // because it's superceded by the (effectively) same check done in the
            // `extractNationalNumber()` function after it calls `shouldHaveExtractedNationalPrefix()`.
            // In other words, why run the same check twice if it could only be run once.
            // // Check the national (significant) number length after extracting national prefix and carrier code.
            // // Fixes a minor "weird behavior" bug: https://gitlab.com/catamphetamine/libphonenumber-js/-/issues/57
            // // (Legacy generated metadata (before `1.0.18`) didn't support the "possible lengths" feature).
            // if (metadata.possibleLengths()) {
            // 	if (isPossibleIncompleteNationalNumber(nationalNumberBefore, metadata) &&
            // 		!isPossibleIncompleteNationalNumber(nationalNumberAfter, metadata)) {
            // 		return false
            // 	}
            // }

            return true;
          }

          function isPossibleIncompleteNationalNumber(
            nationalNumber,
            metadata
          ) {
            switch (checkNumberLength(nationalNumber, metadata)) {
              case 'TOO_SHORT':
              case 'INVALID_LENGTH':
                // This library ignores "local-only" phone numbers (for simplicity).
                // See the readme for more info on what are "local-only" phone numbers.
                // case 'IS_POSSIBLE_LOCAL_ONLY':
                return false;

              default:
                return true;
            }
          }
          //# sourceMappingURL=extractNationalNumber.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/extractCountryCallingCodeFromInternationalNumberWithoutPlusSign.js

          /**
           * Sometimes some people incorrectly input international phone numbers
           * without the leading `+`. This function corrects such input.
           * @param  {string} number — Phone number digits.
           * @param  {string?} country
           * @param  {string?} callingCode
           * @param  {object} metadata
           * @return {object} `{ countryCallingCode: string?, number: string }`.
           */

          function extractCountryCallingCodeFromInternationalNumberWithoutPlusSign(
            number,
            country,
            callingCode,
            metadata
          ) {
            var countryCallingCode = country
              ? getCountryCallingCode(country, metadata)
              : callingCode;

            if (number.indexOf(countryCallingCode) === 0) {
              metadata = new Metadata(metadata);
              metadata.selectNumberingPlan(country, callingCode);
              var possibleShorterNumber = number.slice(
                countryCallingCode.length
              );

              var _extractNationalNumbe = extractNationalNumber(
                  possibleShorterNumber,
                  metadata
                ),
                possibleShorterNationalNumber =
                  _extractNationalNumbe.nationalNumber;

              var _extractNationalNumbe2 = extractNationalNumber(
                  number,
                  metadata
                ),
                nationalNumber = _extractNationalNumbe2.nationalNumber; // If the number was not valid before but is valid now,
              // or if it was too long before, we consider the number
              // with the country calling code stripped to be a better result
              // and keep that instead.
              // For example, in Germany (+49), `49` is a valid area code,
              // so if a number starts with `49`, it could be both a valid
              // national German number or an international number without
              // a leading `+`.

              if (
                (!matchesEntirely(
                  nationalNumber,
                  metadata.nationalNumberPattern()
                ) &&
                  matchesEntirely(
                    possibleShorterNationalNumber,
                    metadata.nationalNumberPattern()
                  )) ||
                checkNumberLength(nationalNumber, metadata) === 'TOO_LONG'
              ) {
                return {
                  countryCallingCode: countryCallingCode,
                  number: possibleShorterNumber,
                };
              }
            }

            return {
              number: number,
            };
          }
          //# sourceMappingURL=extractCountryCallingCodeFromInternationalNumberWithoutPlusSign.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/extractCountryCallingCode.js

          /**
           * Converts a phone number digits (possibly with a `+`)
           * into a calling code and the rest phone number digits.
           * The "rest phone number digits" could include
           * a national prefix, carrier code, and national
           * (significant) number.
           * @param  {string} number — Phone number digits (possibly with a `+`).
           * @param  {string} [country] — Default country.
           * @param  {string} [callingCode] — Default calling code (some phone numbering plans are non-geographic).
           * @param  {object} metadata
           * @return {object} `{ countryCallingCode: string?, number: string }`
           * @example
           * // Returns `{ countryCallingCode: "1", number: "2133734253" }`.
           * extractCountryCallingCode('2133734253', 'US', null, metadata)
           * extractCountryCallingCode('2133734253', null, '1', metadata)
           * extractCountryCallingCode('+12133734253', null, null, metadata)
           * extractCountryCallingCode('+12133734253', 'RU', null, metadata)
           */

          function extractCountryCallingCode_extractCountryCallingCode(
            number,
            country,
            callingCode,
            metadata
          ) {
            if (!number) {
              return {};
            } // If this is not an international phone number,
            // then either extract an "IDD" prefix, or extract a
            // country calling code from a number by autocorrecting it
            // by prepending a leading `+` in cases when it starts
            // with the country calling code.
            // https://wikitravel.org/en/International_dialling_prefix
            // https://github.com/catamphetamine/libphonenumber-js/issues/376

            if (number[0] !== '+') {
              // Convert an "out-of-country" dialing phone number
              // to a proper international phone number.
              var numberWithoutIDD = stripIddPrefix(
                number,
                country,
                callingCode,
                metadata
              ); // If an IDD prefix was stripped then
              // convert the number to international one
              // for subsequent parsing.

              if (numberWithoutIDD && numberWithoutIDD !== number) {
                number = '+' + numberWithoutIDD;
              } else {
                // Check to see if the number starts with the country calling code
                // for the default country. If so, we remove the country calling code,
                // and do some checks on the validity of the number before and after.
                // https://github.com/catamphetamine/libphonenumber-js/issues/376
                if (country || callingCode) {
                  var _extractCountryCallin =
                      extractCountryCallingCodeFromInternationalNumberWithoutPlusSign(
                        number,
                        country,
                        callingCode,
                        metadata
                      ),
                    countryCallingCode =
                      _extractCountryCallin.countryCallingCode,
                    shorterNumber = _extractCountryCallin.number;

                  if (countryCallingCode) {
                    return {
                      countryCallingCode: countryCallingCode,
                      number: shorterNumber,
                    };
                  }
                }

                return {
                  number: number,
                };
              }
            } // Fast abortion: country codes do not begin with a '0'

            if (number[1] === '0') {
              return {};
            }

            metadata = new Metadata(metadata); // The thing with country phone codes
            // is that they are orthogonal to each other
            // i.e. there's no such country phone code A
            // for which country phone code B exists
            // where B starts with A.
            // Therefore, while scanning digits,
            // if a valid country code is found,
            // that means that it is the country code.
            //

            var i = 2;

            while (i - 1 <= MAX_LENGTH_COUNTRY_CODE && i <= number.length) {
              var _countryCallingCode = number.slice(1, i);

              if (metadata.hasCallingCode(_countryCallingCode)) {
                metadata.selectNumberingPlan(_countryCallingCode);
                return {
                  countryCallingCode: _countryCallingCode,
                  number: number.slice(i),
                };
              }

              i++;
            }

            return {};
          }
          //# sourceMappingURL=extractCountryCallingCode.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/helpers/getCountryByCallingCode.js
          function getCountryByCallingCode_createForOfIteratorHelperLoose(
            o,
            allowArrayLike
          ) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = getCountryByCallingCode_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function getCountryByCallingCode_unsupportedIterableToArray(
            o,
            minLen
          ) {
            if (!o) return;
            if (typeof o === 'string')
              return getCountryByCallingCode_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return getCountryByCallingCode_arrayLikeToArray(o, minLen);
          }

          function getCountryByCallingCode_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          var getCountryByCallingCode_USE_NON_GEOGRAPHIC_COUNTRY_CODE = false;
          function getCountryByCallingCode(
            callingCode,
            nationalPhoneNumber,
            metadata
          ) {
            /* istanbul ignore if */
            if (getCountryByCallingCode_USE_NON_GEOGRAPHIC_COUNTRY_CODE) {
              if (metadata.isNonGeographicCallingCode(callingCode)) {
                return '001';
              }
            } // Is always non-empty, because `callingCode` is always valid

            var possibleCountries =
              metadata.getCountryCodesForCallingCode(callingCode);

            if (!possibleCountries) {
              return;
            } // If there's just one country corresponding to the country code,
            // then just return it, without further phone number digits validation.

            if (possibleCountries.length === 1) {
              return possibleCountries[0];
            }

            return selectCountryFromList(
              possibleCountries,
              nationalPhoneNumber,
              metadata.metadata
            );
          }

          function selectCountryFromList(
            possibleCountries,
            nationalPhoneNumber,
            metadata
          ) {
            // Re-create `metadata` because it will be selecting a `country`.
            metadata = new Metadata(metadata);

            for (
              var _iterator =
                  getCountryByCallingCode_createForOfIteratorHelperLoose(
                    possibleCountries
                  ),
                _step;
              !(_step = _iterator()).done;

            ) {
              var country = _step.value;
              metadata.country(country); // Leading digits check would be the simplest and fastest one.
              // Leading digits patterns are only defined for about 20% of all countries.
              // https://gitlab.com/catamphetamine/libphonenumber-js/blob/master/METADATA.md#leading_digits
              // Matching "leading digits" is a sufficient but not necessary condition.

              if (metadata.leadingDigits()) {
                if (
                  nationalPhoneNumber &&
                  nationalPhoneNumber.search(metadata.leadingDigits()) === 0
                ) {
                  return country;
                }
              } // Else perform full validation with all of those
              // fixed-line/mobile/etc regular expressions.
              else if (
                getNumberType(
                  {
                    phone: nationalPhoneNumber,
                    country: country,
                  },
                  undefined,
                  metadata.metadata
                )
              ) {
                return country;
              }
            }
          }
          //# sourceMappingURL=getCountryByCallingCode.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/parse_.js
          // This is a port of Google Android `libphonenumber`'s
          // `phonenumberutil.js` of December 31th, 2018.
          //
          // https://github.com/googlei18n/libphonenumber/commits/master/javascript/i18n/phonenumbers/phonenumberutil.js

          // We don't allow input strings for parsing to be longer than 250 chars.
          // This prevents malicious input from consuming CPU.

          var MAX_INPUT_STRING_LENGTH = 250; // This consists of the plus symbol, digits, and arabic-indic digits.

          var PHONE_NUMBER_START_PATTERN = new RegExp(
            '[' + PLUS_CHARS + VALID_DIGITS + ']'
          ); // Regular expression of trailing characters that we want to remove.
          // A trailing `#` is sometimes used when writing phone numbers with extensions in US.
          // Example: "+1 (645) 123 1234-910#" number has extension "910".

          var AFTER_PHONE_NUMBER_END_PATTERN = new RegExp(
            '[^' + VALID_DIGITS + '#' + ']+$'
          );
          var parse_USE_NON_GEOGRAPHIC_COUNTRY_CODE = false; // Examples:
          //
          // ```js
          // parse('8 (800) 555-35-35', 'RU')
          // parse('8 (800) 555-35-35', 'RU', metadata)
          // parse('8 (800) 555-35-35', { country: { default: 'RU' } })
          // parse('8 (800) 555-35-35', { country: { default: 'RU' } }, metadata)
          // parse('+7 800 555 35 35')
          // parse('+7 800 555 35 35', metadata)
          // ```
          //

          function parse(text, options, metadata) {
            // If assigning the `{}` default value is moved to the arguments above,
            // code coverage would decrease for some weird reason.
            options = options || {};
            metadata = new Metadata(metadata); // Validate `defaultCountry`.

            if (
              options.defaultCountry &&
              !metadata.hasCountry(options.defaultCountry)
            ) {
              if (options.v2) {
                throw new ParseError('INVALID_COUNTRY');
              }

              throw new Error(
                'Unknown country: '.concat(options.defaultCountry)
              );
            } // Parse the phone number.

            var _parseInput = parseInput(text, options.v2, options.extract),
              formattedPhoneNumber = _parseInput.number,
              ext = _parseInput.ext,
              error = _parseInput.error; // If the phone number is not viable then return nothing.

            if (!formattedPhoneNumber) {
              if (options.v2) {
                if (error === 'TOO_SHORT') {
                  throw new ParseError('TOO_SHORT');
                }

                throw new ParseError('NOT_A_NUMBER');
              }

              return {};
            }

            var _parsePhoneNumber = parsePhoneNumber(
                formattedPhoneNumber,
                options.defaultCountry,
                options.defaultCallingCode,
                metadata
              ),
              country = _parsePhoneNumber.country,
              nationalNumber = _parsePhoneNumber.nationalNumber,
              countryCallingCode = _parsePhoneNumber.countryCallingCode,
              carrierCode = _parsePhoneNumber.carrierCode;

            if (!metadata.hasSelectedNumberingPlan()) {
              if (options.v2) {
                throw new ParseError('INVALID_COUNTRY');
              }

              return {};
            } // Validate national (significant) number length.

            if (!nationalNumber || nationalNumber.length < MIN_LENGTH_FOR_NSN) {
              // Won't throw here because the regexp already demands length > 1.

              /* istanbul ignore if */
              if (options.v2) {
                throw new ParseError('TOO_SHORT');
              } // Google's demo just throws an error in this case.

              return {};
            } // Validate national (significant) number length.
            //
            // A sidenote:
            //
            // They say that sometimes national (significant) numbers
            // can be longer than `MAX_LENGTH_FOR_NSN` (e.g. in Germany).
            // https://github.com/googlei18n/libphonenumber/blob/7e1748645552da39c4e1ba731e47969d97bdb539/resources/phonenumber.proto#L36
            // Such numbers will just be discarded.
            //

            if (nationalNumber.length > MAX_LENGTH_FOR_NSN) {
              if (options.v2) {
                throw new ParseError('TOO_LONG');
              } // Google's demo just throws an error in this case.

              return {};
            }

            if (options.v2) {
              var phoneNumber = new PhoneNumber_PhoneNumber(
                countryCallingCode,
                nationalNumber,
                metadata.metadata
              );

              if (country) {
                phoneNumber.country = country;
              }

              if (carrierCode) {
                phoneNumber.carrierCode = carrierCode;
              }

              if (ext) {
                phoneNumber.ext = ext;
              }

              return phoneNumber;
            } // Check if national phone number pattern matches the number.
            // National number pattern is different for each country,
            // even for those ones which are part of the "NANPA" group.

            var valid = (
              options.extended ? metadata.hasSelectedNumberingPlan() : country
            )
              ? matchesEntirely(
                  nationalNumber,
                  metadata.nationalNumberPattern()
                )
              : false;

            if (!options.extended) {
              return valid ? parse_result(country, nationalNumber, ext) : {};
            } // isInternational: countryCallingCode !== undefined

            return {
              country: country,
              countryCallingCode: countryCallingCode,
              carrierCode: carrierCode,
              valid: valid,
              possible: valid
                ? true
                : options.extended === true &&
                    metadata.possibleLengths() &&
                    isPossibleNumber(nationalNumber, metadata)
                  ? true
                  : false,
              phone: nationalNumber,
              ext: ext,
            };
          }
          /**
           * Extracts a formatted phone number from text.
           * Doesn't guarantee that the extracted phone number
           * is a valid phone number (for example, doesn't validate its length).
           * @param  {string} text
           * @param  {boolean} [extract] — If `false`, then will parse the entire `text` as a phone number.
           * @param  {boolean} [throwOnError] — By default, it won't throw if the text is too long.
           * @return {string}
           * @example
           * // Returns "(213) 373-4253".
           * extractFormattedPhoneNumber("Call (213) 373-4253 for assistance.")
           */

          function extractFormattedPhoneNumber(text, extract, throwOnError) {
            if (!text) {
              return;
            }

            if (text.length > MAX_INPUT_STRING_LENGTH) {
              if (throwOnError) {
                throw new ParseError('TOO_LONG');
              }

              return;
            }

            if (extract === false) {
              return text;
            } // Attempt to extract a possible number from the string passed in

            var startsAt = text.search(PHONE_NUMBER_START_PATTERN);

            if (startsAt < 0) {
              return;
            }

            return text // Trim everything to the left of the phone number
              .slice(startsAt) // Remove trailing non-numerical characters
              .replace(AFTER_PHONE_NUMBER_END_PATTERN, '');
          }
          /**
           * @param  {string} text - Input.
           * @param  {boolean} v2 - Legacy API functions don't pass `v2: true` flag.
           * @param  {boolean} [extract] - Whether to extract a phone number from `text`, or attempt to parse the entire text as a phone number.
           * @return {object} `{ ?number, ?ext }`.
           */

          function parseInput(text, v2, extract) {
            // Parse RFC 3966 phone number URI.
            if (text && text.indexOf('tel:') === 0) {
              return parseRFC3966(text);
            }

            var number = extractFormattedPhoneNumber(text, extract, v2); // If the phone number is not viable, then abort.

            if (!number) {
              return {};
            }

            if (!isViablePhoneNumber(number)) {
              if (isViablePhoneNumberStart(number)) {
                return {
                  error: 'TOO_SHORT',
                };
              }

              return {};
            } // Attempt to parse extension first, since it doesn't require region-specific
            // data and we want to have the non-normalised number here.

            var withExtensionStripped = extractExtension(number);

            if (withExtensionStripped.ext) {
              return withExtensionStripped;
            }

            return {
              number: number,
            };
          }
          /**
           * Creates `parse()` result object.
           */

          function parse_result(country, nationalNumber, ext) {
            var result = {
              country: country,
              phone: nationalNumber,
            };

            if (ext) {
              result.ext = ext;
            }

            return result;
          }
          /**
           * Parses a viable phone number.
           * @param {string} formattedPhoneNumber — Example: "(213) 373-4253".
           * @param {string} [defaultCountry]
           * @param {string} [defaultCallingCode]
           * @param {Metadata} metadata
           * @return {object} Returns `{ country: string?, countryCallingCode: string?, nationalNumber: string? }`.
           */

          function parsePhoneNumber(
            formattedPhoneNumber,
            defaultCountry,
            defaultCallingCode,
            metadata
          ) {
            // Extract calling code from phone number.
            var _extractCountryCallin =
                extractCountryCallingCode_extractCountryCallingCode(
                  parseIncompletePhoneNumber(formattedPhoneNumber),
                  defaultCountry,
                  defaultCallingCode,
                  metadata.metadata
                ),
              countryCallingCode = _extractCountryCallin.countryCallingCode,
              number = _extractCountryCallin.number; // Choose a country by `countryCallingCode`.

            var country;

            if (countryCallingCode) {
              metadata.selectNumberingPlan(countryCallingCode);
            } // If `formattedPhoneNumber` is in "national" format
            // then `number` is defined and `countryCallingCode` isn't.
            else if (number && (defaultCountry || defaultCallingCode)) {
              metadata.selectNumberingPlan(defaultCountry, defaultCallingCode);

              if (defaultCountry) {
                country = defaultCountry;
              } else {
                /* istanbul ignore if */
                if (parse_USE_NON_GEOGRAPHIC_COUNTRY_CODE) {
                  if (metadata.isNonGeographicCallingCode(defaultCallingCode)) {
                    country = '001';
                  }
                }
              }

              countryCallingCode =
                defaultCallingCode ||
                getCountryCallingCode(defaultCountry, metadata.metadata);
            } else return {};

            if (!number) {
              return {
                countryCallingCode: countryCallingCode,
              };
            }

            var _extractNationalNumbe = extractNationalNumber(
                parseIncompletePhoneNumber(number),
                metadata
              ),
              nationalNumber = _extractNationalNumbe.nationalNumber,
              carrierCode = _extractNationalNumbe.carrierCode; // Sometimes there are several countries
            // corresponding to the same country phone code
            // (e.g. NANPA countries all having `1` country phone code).
            // Therefore, to reliably determine the exact country,
            // national (significant) number should have been parsed first.
            //
            // When `metadata.json` is generated, all "ambiguous" country phone codes
            // get their countries populated with the full set of
            // "phone number type" regular expressions.
            //

            var exactCountry = getCountryByCallingCode(
              countryCallingCode,
              nationalNumber,
              metadata
            );

            if (exactCountry) {
              country = exactCountry;
              /* istanbul ignore if */

              if (exactCountry === '001') {
                // Can't happen with `USE_NON_GEOGRAPHIC_COUNTRY_CODE` being `false`.
                // If `USE_NON_GEOGRAPHIC_COUNTRY_CODE` is set to `true` for some reason,
                // then remove the "istanbul ignore if".
              } else {
                metadata.country(country);
              }
            }

            return {
              country: country,
              countryCallingCode: countryCallingCode,
              nationalNumber: nationalNumber,
              carrierCode: carrierCode,
            };
          }
          //# sourceMappingURL=parse_.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/parsePhoneNumber_.js
          function parsePhoneNumber_ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
              var symbols = Object.getOwnPropertySymbols(object);
              enumerableOnly &&
                (symbols = symbols.filter(function (sym) {
                  return Object.getOwnPropertyDescriptor(object, sym)
                    .enumerable;
                })),
                keys.push.apply(keys, symbols);
            }
            return keys;
          }

          function parsePhoneNumber_objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
              var source = null != arguments[i] ? arguments[i] : {};
              i % 2
                ? parsePhoneNumber_ownKeys(Object(source), !0).forEach(
                    function (key) {
                      parsePhoneNumber_defineProperty(target, key, source[key]);
                    }
                  )
                : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(
                      target,
                      Object.getOwnPropertyDescriptors(source)
                    )
                  : parsePhoneNumber_ownKeys(Object(source)).forEach(
                      function (key) {
                        Object.defineProperty(
                          target,
                          key,
                          Object.getOwnPropertyDescriptor(source, key)
                        );
                      }
                    );
            }
            return target;
          }

          function parsePhoneNumber_defineProperty(obj, key, value) {
            if (key in obj) {
              Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
              });
            } else {
              obj[key] = value;
            }
            return obj;
          }

          function parsePhoneNumber_parsePhoneNumber(text, options, metadata) {
            return parse(
              text,
              parsePhoneNumber_objectSpread(
                parsePhoneNumber_objectSpread({}, options),
                {},
                {
                  v2: true,
                }
              ),
              metadata
            );
          }
          //# sourceMappingURL=parsePhoneNumber_.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/parsePhoneNumber.js
          function parsePhoneNumber_typeof(obj) {
            '@babel/helpers - typeof';
            return (
              (parsePhoneNumber_typeof =
                'function' == typeof Symbol &&
                'symbol' == typeof Symbol.iterator
                  ? function (obj) {
                      return typeof obj;
                    }
                  : function (obj) {
                      return obj &&
                        'function' == typeof Symbol &&
                        obj.constructor === Symbol &&
                        obj !== Symbol.prototype
                        ? 'symbol'
                        : typeof obj;
                    }),
              parsePhoneNumber_typeof(obj)
            );
          }

          function es6_parsePhoneNumber_ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
              var symbols = Object.getOwnPropertySymbols(object);
              enumerableOnly &&
                (symbols = symbols.filter(function (sym) {
                  return Object.getOwnPropertyDescriptor(object, sym)
                    .enumerable;
                })),
                keys.push.apply(keys, symbols);
            }
            return keys;
          }

          function es6_parsePhoneNumber_objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
              var source = null != arguments[i] ? arguments[i] : {};
              i % 2
                ? es6_parsePhoneNumber_ownKeys(Object(source), !0).forEach(
                    function (key) {
                      es6_parsePhoneNumber_defineProperty(
                        target,
                        key,
                        source[key]
                      );
                    }
                  )
                : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(
                      target,
                      Object.getOwnPropertyDescriptors(source)
                    )
                  : es6_parsePhoneNumber_ownKeys(Object(source)).forEach(
                      function (key) {
                        Object.defineProperty(
                          target,
                          key,
                          Object.getOwnPropertyDescriptor(source, key)
                        );
                      }
                    );
            }
            return target;
          }

          function es6_parsePhoneNumber_defineProperty(obj, key, value) {
            if (key in obj) {
              Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
              });
            } else {
              obj[key] = value;
            }
            return obj;
          }

          function parsePhoneNumber_slicedToArray(arr, i) {
            return (
              parsePhoneNumber_arrayWithHoles(arr) ||
              parsePhoneNumber_iterableToArrayLimit(arr, i) ||
              parsePhoneNumber_unsupportedIterableToArray(arr, i) ||
              parsePhoneNumber_nonIterableRest()
            );
          }

          function parsePhoneNumber_nonIterableRest() {
            throw new TypeError(
              'Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function parsePhoneNumber_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return parsePhoneNumber_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return parsePhoneNumber_arrayLikeToArray(o, minLen);
          }

          function parsePhoneNumber_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          function parsePhoneNumber_iterableToArrayLimit(arr, i) {
            var _i =
              arr == null
                ? null
                : (typeof Symbol !== 'undefined' && arr[Symbol.iterator]) ||
                  arr['@@iterator'];
            if (_i == null) return;
            var _arr = [];
            var _n = true;
            var _d = false;
            var _s, _e;
            try {
              for (
                _i = _i.call(arr);
                !(_n = (_s = _i.next()).done);
                _n = true
              ) {
                _arr.push(_s.value);
                if (i && _arr.length === i) break;
              }
            } catch (err) {
              _d = true;
              _e = err;
            } finally {
              try {
                if (!_n && _i['return'] != null) _i['return']();
              } finally {
                if (_d) throw _e;
              }
            }
            return _arr;
          }

          function parsePhoneNumber_arrayWithHoles(arr) {
            if (Array.isArray(arr)) return arr;
          }

          function es6_parsePhoneNumber_parsePhoneNumber() {
            var _normalizeArguments = normalizeArguments(arguments),
              text = _normalizeArguments.text,
              options = _normalizeArguments.options,
              metadata = _normalizeArguments.metadata;

            return parsePhoneNumber_parsePhoneNumber(text, options, metadata);
          }
          function normalizeArguments(args) {
            var _Array$prototype$slic = Array.prototype.slice.call(args),
              _Array$prototype$slic2 = parsePhoneNumber_slicedToArray(
                _Array$prototype$slic,
                4
              ),
              arg_1 = _Array$prototype$slic2[0],
              arg_2 = _Array$prototype$slic2[1],
              arg_3 = _Array$prototype$slic2[2],
              arg_4 = _Array$prototype$slic2[3];

            var text;
            var options;
            var metadata; // If the phone number is passed as a string.
            // `parsePhoneNumber('88005553535', ...)`.

            if (typeof arg_1 === 'string') {
              text = arg_1;
            } else throw new TypeError('A text for parsing must be a string.'); // If "default country" argument is being passed then move it to `options`.
            // `parsePhoneNumber('88005553535', 'RU', [options], metadata)`.

            if (!arg_2 || typeof arg_2 === 'string') {
              if (arg_4) {
                options = arg_3;
                metadata = arg_4;
              } else {
                options = undefined;
                metadata = arg_3;
              }

              if (arg_2) {
                options = es6_parsePhoneNumber_objectSpread(
                  {
                    defaultCountry: arg_2,
                  },
                  options
                );
              }
            } // `defaultCountry` is not passed.
            // Example: `parsePhoneNumber('+78005553535', [options], metadata)`.
            else if (isObject(arg_2)) {
              if (arg_3) {
                options = arg_2;
                metadata = arg_3;
              } else {
                metadata = arg_2;
              }
            } else throw new Error('Invalid second argument: '.concat(arg_2));

            return {
              text: text,
              options: options,
              metadata: metadata,
            };
          } // Otherwise istanbul would show this as "branch not covered".

          /* istanbul ignore next */

          var isObject = function isObject(_) {
            return parsePhoneNumber_typeof(_) === 'object';
          };
          //# sourceMappingURL=parsePhoneNumber.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/parsePhoneNumberFromString_.js
          function parsePhoneNumberFromString_ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
              var symbols = Object.getOwnPropertySymbols(object);
              enumerableOnly &&
                (symbols = symbols.filter(function (sym) {
                  return Object.getOwnPropertyDescriptor(object, sym)
                    .enumerable;
                })),
                keys.push.apply(keys, symbols);
            }
            return keys;
          }

          function parsePhoneNumberFromString_objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
              var source = null != arguments[i] ? arguments[i] : {};
              i % 2
                ? parsePhoneNumberFromString_ownKeys(
                    Object(source),
                    !0
                  ).forEach(function (key) {
                    parsePhoneNumberFromString_defineProperty(
                      target,
                      key,
                      source[key]
                    );
                  })
                : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(
                      target,
                      Object.getOwnPropertyDescriptors(source)
                    )
                  : parsePhoneNumberFromString_ownKeys(Object(source)).forEach(
                      function (key) {
                        Object.defineProperty(
                          target,
                          key,
                          Object.getOwnPropertyDescriptor(source, key)
                        );
                      }
                    );
            }
            return target;
          }

          function parsePhoneNumberFromString_defineProperty(obj, key, value) {
            if (key in obj) {
              Object.defineProperty(obj, key, {
                value: value,
                enumerable: true,
                configurable: true,
                writable: true,
              });
            } else {
              obj[key] = value;
            }
            return obj;
          }

          function parsePhoneNumberFromString(text, options, metadata) {
            // Validate `defaultCountry`.
            if (
              options &&
              options.defaultCountry &&
              !isSupportedCountry(options.defaultCountry, metadata)
            ) {
              options = parsePhoneNumberFromString_objectSpread(
                parsePhoneNumberFromString_objectSpread({}, options),
                {},
                {
                  defaultCountry: undefined,
                }
              );
            } // Parse phone number.

            try {
              return parsePhoneNumber_parsePhoneNumber(text, options, metadata);
            } catch (error) {
              /* istanbul ignore else */
              if (error instanceof ParseError) {
                //
              } else {
                throw error;
              }
            }
          }
          //# sourceMappingURL=parsePhoneNumberFromString_.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/parsePhoneNumberFromString.js

          function parsePhoneNumberFromString_parsePhoneNumberFromString() {
            var _normalizeArguments = normalizeArguments(arguments),
              text = _normalizeArguments.text,
              options = _normalizeArguments.options,
              metadata = _normalizeArguments.metadata;

            return parsePhoneNumberFromString(text, options, metadata);
          }
          //# sourceMappingURL=parsePhoneNumberFromString.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/min/exports/parsePhoneNumberFromString.js

          function exports_parsePhoneNumberFromString_parsePhoneNumberFromString() {
            return withMetadataArgument(
              parsePhoneNumberFromString_parsePhoneNumberFromString,
              arguments
            );
          }
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouTypeState.js
          function AsYouTypeState_classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function AsYouTypeState_defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function AsYouTypeState_createClass(
            Constructor,
            protoProps,
            staticProps
          ) {
            if (protoProps)
              AsYouTypeState_defineProperties(
                Constructor.prototype,
                protoProps
              );
            if (staticProps)
              AsYouTypeState_defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          var AsYouTypeState = /*#__PURE__*/ (function () {
            function AsYouTypeState(_ref) {
              var onCountryChange = _ref.onCountryChange,
                onCallingCodeChange = _ref.onCallingCodeChange;

              AsYouTypeState_classCallCheck(this, AsYouTypeState);

              this.onCountryChange = onCountryChange;
              this.onCallingCodeChange = onCallingCodeChange;
            }

            AsYouTypeState_createClass(AsYouTypeState, [
              {
                key: 'reset',
                value: function reset(defaultCountry, defaultCallingCode) {
                  this.international = false;
                  this.IDDPrefix = undefined;
                  this.missingPlus = undefined;
                  this.callingCode = undefined;
                  this.digits = '';
                  this.resetNationalSignificantNumber();
                  this.initCountryAndCallingCode(
                    defaultCountry,
                    defaultCallingCode
                  );
                },
              },
              {
                key: 'resetNationalSignificantNumber',
                value: function resetNationalSignificantNumber() {
                  this.nationalSignificantNumber = this.getNationalDigits();
                  this.nationalSignificantNumberMatchesInput = true;
                  this.nationalPrefix = undefined;
                  this.carrierCode = undefined;
                  this.complexPrefixBeforeNationalSignificantNumber = undefined;
                },
              },
              {
                key: 'update',
                value: function update(properties) {
                  for (
                    var _i = 0, _Object$keys = Object.keys(properties);
                    _i < _Object$keys.length;
                    _i++
                  ) {
                    var key = _Object$keys[_i];
                    this[key] = properties[key];
                  }
                },
              },
              {
                key: 'initCountryAndCallingCode',
                value: function initCountryAndCallingCode(
                  country,
                  callingCode
                ) {
                  this.setCountry(country);
                  this.setCallingCode(callingCode);
                },
              },
              {
                key: 'setCountry',
                value: function setCountry(country) {
                  this.country = country;
                  this.onCountryChange(country);
                },
              },
              {
                key: 'setCallingCode',
                value: function setCallingCode(callingCode) {
                  this.callingCode = callingCode;
                  this.onCallingCodeChange(callingCode, this.country);
                },
              },
              {
                key: 'startInternationalNumber',
                value: function startInternationalNumber(country, callingCode) {
                  // Prepend the `+` to parsed input.
                  this.international = true; // If a default country was set then reset it
                  // because an explicitly international phone
                  // number is being entered.

                  this.initCountryAndCallingCode(country, callingCode);
                },
              },
              {
                key: 'appendDigits',
                value: function appendDigits(nextDigits) {
                  this.digits += nextDigits;
                },
              },
              {
                key: 'appendNationalSignificantNumberDigits',
                value: function appendNationalSignificantNumberDigits(
                  nextDigits
                ) {
                  this.nationalSignificantNumber += nextDigits;
                },
                /**
                 * Returns the part of `this.digits` that corresponds to the national number.
                 * Basically, all digits that have been input by the user, except for the
                 * international prefix and the country calling code part
                 * (if the number is an international one).
                 * @return {string}
                 */
              },
              {
                key: 'getNationalDigits',
                value: function getNationalDigits() {
                  if (this.international) {
                    return this.digits.slice(
                      (this.IDDPrefix ? this.IDDPrefix.length : 0) +
                        (this.callingCode ? this.callingCode.length : 0)
                    );
                  }

                  return this.digits;
                },
              },
              {
                key: 'getDigitsWithoutInternationalPrefix',
                value: function getDigitsWithoutInternationalPrefix() {
                  if (this.international) {
                    if (this.IDDPrefix) {
                      return this.digits.slice(this.IDDPrefix.length);
                    }
                  }

                  return this.digits;
                },
              },
            ]);

            return AsYouTypeState;
          })();

          //# sourceMappingURL=AsYouTypeState.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouTypeFormatter.util.js
          function AsYouTypeFormatter_util_createForOfIteratorHelperLoose(
            o,
            allowArrayLike
          ) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = AsYouTypeFormatter_util_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function AsYouTypeFormatter_util_unsupportedIterableToArray(
            o,
            minLen
          ) {
            if (!o) return;
            if (typeof o === 'string')
              return AsYouTypeFormatter_util_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return AsYouTypeFormatter_util_arrayLikeToArray(o, minLen);
          }

          function AsYouTypeFormatter_util_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          // Should be the same as `DIGIT_PLACEHOLDER` in `libphonenumber-metadata-generator`.
          var DIGIT_PLACEHOLDER = 'x'; // '\u2008' (punctuation space)

          var DIGIT_PLACEHOLDER_MATCHER = new RegExp(DIGIT_PLACEHOLDER); // Counts all occurences of a symbol in a string.
          // Unicode-unsafe (because using `.split()`).

          function countOccurences(symbol, string) {
            var count = 0; // Using `.split('')` to iterate through a string here
            // to avoid requiring `Symbol.iterator` polyfill.
            // `.split('')` is generally not safe for Unicode,
            // but in this particular case for counting brackets it is safe.
            // for (const character of string)

            for (
              var _iterator =
                  AsYouTypeFormatter_util_createForOfIteratorHelperLoose(
                    string.split('')
                  ),
                _step;
              !(_step = _iterator()).done;

            ) {
              var character = _step.value;

              if (character === symbol) {
                count++;
              }
            }

            return count;
          } // Repeats a string (or a symbol) N times.
          // http://stackoverflow.com/questions/202605/repeat-string-javascript

          function repeat(string, times) {
            if (times < 1) {
              return '';
            }

            var result = '';

            while (times > 1) {
              if (times & 1) {
                result += string;
              }

              times >>= 1;
              string += string;
            }

            return result + string;
          }
          function cutAndStripNonPairedParens(string, cutBeforeIndex) {
            if (string[cutBeforeIndex] === ')') {
              cutBeforeIndex++;
            }

            return stripNonPairedParens(string.slice(0, cutBeforeIndex));
          }
          function closeNonPairedParens(template, cut_before) {
            var retained_template = template.slice(0, cut_before);
            var opening_braces = countOccurences('(', retained_template);
            var closing_braces = countOccurences(')', retained_template);
            var dangling_braces = opening_braces - closing_braces;

            while (dangling_braces > 0 && cut_before < template.length) {
              if (template[cut_before] === ')') {
                dangling_braces--;
              }

              cut_before++;
            }

            return template.slice(0, cut_before);
          }
          function stripNonPairedParens(string) {
            var dangling_braces = [];
            var i = 0;

            while (i < string.length) {
              if (string[i] === '(') {
                dangling_braces.push(i);
              } else if (string[i] === ')') {
                dangling_braces.pop();
              }

              i++;
            }

            var start = 0;
            var cleared_string = '';
            dangling_braces.push(string.length);

            for (
              var _i = 0, _dangling_braces = dangling_braces;
              _i < _dangling_braces.length;
              _i++
            ) {
              var index = _dangling_braces[_i];
              cleared_string += string.slice(start, index);
              start = index + 1;
            }

            return cleared_string;
          }
          function populateTemplateWithDigits(template, position, digits) {
            // Using `.split('')` to iterate through a string here
            // to avoid requiring `Symbol.iterator` polyfill.
            // `.split('')` is generally not safe for Unicode,
            // but in this particular case for `digits` it is safe.
            // for (const digit of digits)
            for (
              var _iterator2 =
                  AsYouTypeFormatter_util_createForOfIteratorHelperLoose(
                    digits.split('')
                  ),
                _step2;
              !(_step2 = _iterator2()).done;

            ) {
              var digit = _step2.value;

              // If there is room for more digits in current `template`,
              // then set the next digit in the `template`,
              // and return the formatted digits so far.
              // If more digits are entered than the current format could handle.
              if (
                template.slice(position + 1).search(DIGIT_PLACEHOLDER_MATCHER) <
                0
              ) {
                return;
              }

              position = template.search(DIGIT_PLACEHOLDER_MATCHER);
              template = template.replace(DIGIT_PLACEHOLDER_MATCHER, digit);
            }

            return [template, position];
          }
          //# sourceMappingURL=AsYouTypeFormatter.util.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouTypeFormatter.complete.js

          function formatCompleteNumber(state, format, _ref) {
            var metadata = _ref.metadata,
              shouldTryNationalPrefixFormattingRule =
                _ref.shouldTryNationalPrefixFormattingRule,
              getSeparatorAfterNationalPrefix =
                _ref.getSeparatorAfterNationalPrefix;
            var matcher = new RegExp('^(?:'.concat(format.pattern(), ')$'));

            if (matcher.test(state.nationalSignificantNumber)) {
              return formatNationalNumberWithAndWithoutNationalPrefixFormattingRule(
                state,
                format,
                {
                  metadata: metadata,
                  shouldTryNationalPrefixFormattingRule:
                    shouldTryNationalPrefixFormattingRule,
                  getSeparatorAfterNationalPrefix:
                    getSeparatorAfterNationalPrefix,
                }
              );
            }
          }
          function canFormatCompleteNumber(
            nationalSignificantNumber,
            metadata
          ) {
            return (
              checkNumberLength(nationalSignificantNumber, metadata) ===
              'IS_POSSIBLE'
            );
          }

          function formatNationalNumberWithAndWithoutNationalPrefixFormattingRule(
            state,
            format,
            _ref2
          ) {
            var metadata = _ref2.metadata,
              shouldTryNationalPrefixFormattingRule =
                _ref2.shouldTryNationalPrefixFormattingRule,
              getSeparatorAfterNationalPrefix =
                _ref2.getSeparatorAfterNationalPrefix;
            // `format` has already been checked for `nationalPrefix` requirement.
            var nationalSignificantNumber = state.nationalSignificantNumber,
              international = state.international,
              nationalPrefix = state.nationalPrefix,
              carrierCode = state.carrierCode; // Format the number with using `national_prefix_formatting_rule`.
            // If the resulting formatted number is a valid formatted number, then return it.
            //
            // Google's AsYouType formatter is different in a way that it doesn't try
            // to format using the "national prefix formatting rule", and instead it
            // simply prepends a national prefix followed by a " " character.
            // This code does that too, but as a fallback.
            // The reason is that "national prefix formatting rule" may use parentheses,
            // which wouldn't be included has it used the simpler Google's way.
            //

            if (shouldTryNationalPrefixFormattingRule(format)) {
              var formattedNumber =
                AsYouTypeFormatter_complete_formatNationalNumber(
                  state,
                  format,
                  {
                    useNationalPrefixFormattingRule: true,
                    getSeparatorAfterNationalPrefix:
                      getSeparatorAfterNationalPrefix,
                    metadata: metadata,
                  }
                );

              if (formattedNumber) {
                return formattedNumber;
              }
            } // Format the number without using `national_prefix_formatting_rule`.

            return AsYouTypeFormatter_complete_formatNationalNumber(
              state,
              format,
              {
                useNationalPrefixFormattingRule: false,
                getSeparatorAfterNationalPrefix:
                  getSeparatorAfterNationalPrefix,
                metadata: metadata,
              }
            );
          }

          function AsYouTypeFormatter_complete_formatNationalNumber(
            state,
            format,
            _ref3
          ) {
            var metadata = _ref3.metadata,
              useNationalPrefixFormattingRule =
                _ref3.useNationalPrefixFormattingRule,
              getSeparatorAfterNationalPrefix =
                _ref3.getSeparatorAfterNationalPrefix;
            var formattedNationalNumber = formatNationalNumberUsingFormat(
              state.nationalSignificantNumber,
              format,
              {
                carrierCode: state.carrierCode,
                useInternationalFormat: state.international,
                withNationalPrefix: useNationalPrefixFormattingRule,
                metadata: metadata,
              }
            );

            if (!useNationalPrefixFormattingRule) {
              if (state.nationalPrefix) {
                // If a national prefix was extracted, then just prepend it,
                // followed by a " " character.
                formattedNationalNumber =
                  state.nationalPrefix +
                  getSeparatorAfterNationalPrefix(format) +
                  formattedNationalNumber;
              } else if (state.complexPrefixBeforeNationalSignificantNumber) {
                formattedNationalNumber =
                  state.complexPrefixBeforeNationalSignificantNumber +
                  ' ' +
                  formattedNationalNumber;
              }
            }

            if (
              isValidFormattedNationalNumber(formattedNationalNumber, state)
            ) {
              return formattedNationalNumber;
            }
          } // Check that the formatted phone number contains exactly
          // the same digits that have been input by the user.
          // For example, when "0111523456789" is input for `AR` country,
          // the extracted `this.nationalSignificantNumber` is "91123456789",
          // which means that the national part of `this.digits` isn't simply equal to
          // `this.nationalPrefix` + `this.nationalSignificantNumber`.
          //
          // Also, a `format` can add extra digits to the `this.nationalSignificantNumber`
          // being formatted via `metadata[country].national_prefix_transform_rule`.
          // For example, for `VI` country, it prepends `340` to the national number,
          // and if this check hasn't been implemented, then there would be a bug
          // when `340` "area coude" is "duplicated" during input for `VI` country:
          // https://github.com/catamphetamine/libphonenumber-js/issues/318
          //
          // So, all these "gotchas" are filtered out.
          //
          // In the original Google's code, the comments say:
          // "Check that we didn't remove nor add any extra digits when we matched
          // this formatting pattern. This usually happens after we entered the last
          // digit during AYTF. Eg: In case of MX, we swallow mobile token (1) when
          // formatted but AYTF should retain all the number entered and not change
          // in order to match a format (of same leading digits and length) display
          // in that way."
          // "If it's the same (i.e entered number and format is same), then it's
          // safe to return this in formatted number as nothing is lost / added."
          // Otherwise, don't use this format.
          // https://github.com/google/libphonenumber/commit/3e7c1f04f5e7200f87fb131e6f85c6e99d60f510#diff-9149457fa9f5d608a11bb975c6ef4bc5
          // https://github.com/google/libphonenumber/commit/3ac88c7106e7dcb553bcc794b15f19185928a1c6#diff-2dcb77e833422ee304da348b905cde0b
          //

          function isValidFormattedNationalNumber(
            formattedNationalNumber,
            state
          ) {
            return (
              parseDigits(formattedNationalNumber) === state.getNationalDigits()
            );
          }
          //# sourceMappingURL=AsYouTypeFormatter.complete.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouTypeFormatter.PatternParser.js
          function AsYouTypeFormatter_PatternParser_classCallCheck(
            instance,
            Constructor
          ) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function AsYouTypeFormatter_PatternParser_defineProperties(
            target,
            props
          ) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function AsYouTypeFormatter_PatternParser_createClass(
            Constructor,
            protoProps,
            staticProps
          ) {
            if (protoProps)
              AsYouTypeFormatter_PatternParser_defineProperties(
                Constructor.prototype,
                protoProps
              );
            if (staticProps)
              AsYouTypeFormatter_PatternParser_defineProperties(
                Constructor,
                staticProps
              );
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          var PatternParser = /*#__PURE__*/ (function () {
            function PatternParser() {
              AsYouTypeFormatter_PatternParser_classCallCheck(
                this,
                PatternParser
              );
            }

            AsYouTypeFormatter_PatternParser_createClass(PatternParser, [
              {
                key: 'parse',
                value: function parse(pattern) {
                  this.context = [
                    {
                      or: true,
                      instructions: [],
                    },
                  ];
                  this.parsePattern(pattern);

                  if (this.context.length !== 1) {
                    throw new Error(
                      'Non-finalized contexts left when pattern parse ended'
                    );
                  }

                  var _this$context$ = this.context[0],
                    branches = _this$context$.branches,
                    instructions = _this$context$.instructions;

                  if (branches) {
                    return {
                      op: '|',
                      args: branches.concat([
                        expandSingleElementArray(instructions),
                      ]),
                    };
                  }
                  /* istanbul ignore if */

                  if (instructions.length === 0) {
                    throw new Error('Pattern is required');
                  }

                  if (instructions.length === 1) {
                    return instructions[0];
                  }

                  return instructions;
                },
              },
              {
                key: 'startContext',
                value: function startContext(context) {
                  this.context.push(context);
                },
              },
              {
                key: 'endContext',
                value: function endContext() {
                  this.context.pop();
                },
              },
              {
                key: 'getContext',
                value: function getContext() {
                  return this.context[this.context.length - 1];
                },
              },
              {
                key: 'parsePattern',
                value: function parsePattern(pattern) {
                  if (!pattern) {
                    throw new Error('Pattern is required');
                  }

                  var match = pattern.match(OPERATOR);

                  if (!match) {
                    if (ILLEGAL_CHARACTER_REGEXP.test(pattern)) {
                      throw new Error(
                        'Illegal characters found in a pattern: '.concat(
                          pattern
                        )
                      );
                    }

                    this.getContext().instructions =
                      this.getContext().instructions.concat(pattern.split(''));
                    return;
                  }

                  var operator = match[1];
                  var before = pattern.slice(0, match.index);
                  var rightPart = pattern.slice(match.index + operator.length);

                  switch (operator) {
                    case '(?:':
                      if (before) {
                        this.parsePattern(before);
                      }

                      this.startContext({
                        or: true,
                        instructions: [],
                        branches: [],
                      });
                      break;

                    case ')':
                      if (!this.getContext().or) {
                        throw new Error(
                          '")" operator must be preceded by "(?:" operator'
                        );
                      }

                      if (before) {
                        this.parsePattern(before);
                      }

                      if (this.getContext().instructions.length === 0) {
                        throw new Error(
                          'No instructions found after "|" operator in an "or" group'
                        );
                      }

                      var _this$getContext = this.getContext(),
                        branches = _this$getContext.branches;

                      branches.push(
                        expandSingleElementArray(this.getContext().instructions)
                      );
                      this.endContext();
                      this.getContext().instructions.push({
                        op: '|',
                        args: branches,
                      });
                      break;

                    case '|':
                      if (!this.getContext().or) {
                        throw new Error(
                          '"|" operator can only be used inside "or" groups'
                        );
                      }

                      if (before) {
                        this.parsePattern(before);
                      } // The top-level is an implicit "or" group, if required.

                      if (!this.getContext().branches) {
                        // `branches` are not defined only for the root implicit "or" operator.

                        /* istanbul ignore else */
                        if (this.context.length === 1) {
                          this.getContext().branches = [];
                        } else {
                          throw new Error(
                            '"branches" not found in an "or" group context'
                          );
                        }
                      }

                      this.getContext().branches.push(
                        expandSingleElementArray(this.getContext().instructions)
                      );
                      this.getContext().instructions = [];
                      break;

                    case '[':
                      if (before) {
                        this.parsePattern(before);
                      }

                      this.startContext({
                        oneOfSet: true,
                      });
                      break;

                    case ']':
                      if (!this.getContext().oneOfSet) {
                        throw new Error(
                          '"]" operator must be preceded by "[" operator'
                        );
                      }

                      this.endContext();
                      this.getContext().instructions.push({
                        op: '[]',
                        args: parseOneOfSet(before),
                      });
                      break;

                    /* istanbul ignore next */

                    default:
                      throw new Error('Unknown operator: '.concat(operator));
                  }

                  if (rightPart) {
                    this.parsePattern(rightPart);
                  }
                },
              },
            ]);

            return PatternParser;
          })();

          function parseOneOfSet(pattern) {
            var values = [];
            var i = 0;

            while (i < pattern.length) {
              if (pattern[i] === '-') {
                if (i === 0 || i === pattern.length - 1) {
                  throw new Error(
                    "Couldn't parse a one-of set pattern: ".concat(pattern)
                  );
                }

                var prevValue = pattern[i - 1].charCodeAt(0) + 1;
                var nextValue = pattern[i + 1].charCodeAt(0) - 1;
                var value = prevValue;

                while (value <= nextValue) {
                  values.push(String.fromCharCode(value));
                  value++;
                }
              } else {
                values.push(pattern[i]);
              }

              i++;
            }

            return values;
          }

          var ILLEGAL_CHARACTER_REGEXP = /[\(\)\[\]\?\:\|]/;
          var OPERATOR = new RegExp( // any of:
            '(' + // or operator
              '\\|' + // or
              '|' + // or group start
              '\\(\\?\\:' + // or
              '|' + // or group end
              '\\)' + // or
              '|' + // one-of set start
              '\\[' + // or
              '|' + // one-of set end
              '\\]' +
              ')'
          );

          function expandSingleElementArray(array) {
            if (array.length === 1) {
              return array[0];
            }

            return array;
          }
          //# sourceMappingURL=AsYouTypeFormatter.PatternParser.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouTypeFormatter.PatternMatcher.js
          function AsYouTypeFormatter_PatternMatcher_createForOfIteratorHelperLoose(
            o,
            allowArrayLike
          ) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it =
                AsYouTypeFormatter_PatternMatcher_unsupportedIterableToArray(
                  o
                )) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function AsYouTypeFormatter_PatternMatcher_unsupportedIterableToArray(
            o,
            minLen
          ) {
            if (!o) return;
            if (typeof o === 'string')
              return AsYouTypeFormatter_PatternMatcher_arrayLikeToArray(
                o,
                minLen
              );
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return AsYouTypeFormatter_PatternMatcher_arrayLikeToArray(
                o,
                minLen
              );
          }

          function AsYouTypeFormatter_PatternMatcher_arrayLikeToArray(
            arr,
            len
          ) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          function AsYouTypeFormatter_PatternMatcher_classCallCheck(
            instance,
            Constructor
          ) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function AsYouTypeFormatter_PatternMatcher_defineProperties(
            target,
            props
          ) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function AsYouTypeFormatter_PatternMatcher_createClass(
            Constructor,
            protoProps,
            staticProps
          ) {
            if (protoProps)
              AsYouTypeFormatter_PatternMatcher_defineProperties(
                Constructor.prototype,
                protoProps
              );
            if (staticProps)
              AsYouTypeFormatter_PatternMatcher_defineProperties(
                Constructor,
                staticProps
              );
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          var AsYouTypeFormatter_PatternMatcher_PatternMatcher =
            /*#__PURE__*/ (function () {
              function PatternMatcher(pattern) {
                AsYouTypeFormatter_PatternMatcher_classCallCheck(
                  this,
                  PatternMatcher
                );

                this.matchTree = new PatternParser().parse(pattern);
              }

              AsYouTypeFormatter_PatternMatcher_createClass(PatternMatcher, [
                {
                  key: 'match',
                  value: function match(string) {
                    var _ref =
                        arguments.length > 1 && arguments[1] !== undefined
                          ? arguments[1]
                          : {},
                      allowOverflow = _ref.allowOverflow;

                    if (!string) {
                      throw new Error('String is required');
                    }

                    var result = _match(string.split(''), this.matchTree, true);

                    if (result && result.match) {
                      delete result.matchedChars;
                    }

                    if (result && result.overflow) {
                      if (!allowOverflow) {
                        return;
                      }
                    }

                    return result;
                  },
                },
              ]);

              return PatternMatcher;
            })();
          /**
           * Matches `characters` against a pattern compiled into a `tree`.
           * @param  {string[]} characters
           * @param  {Tree} tree — A pattern compiled into a `tree`. See the `*.d.ts` file for the description of the `tree` structure.
           * @param  {boolean} last — Whether it's the last (rightmost) subtree on its level of the match tree.
           * @return {object} See the `*.d.ts` file for the description of the result object.
           */

          function _match(characters, tree, last) {
            // If `tree` is a string, then `tree` is a single character.
            // That's because when a pattern is parsed, multi-character-string parts
            // of a pattern are compiled into arrays of single characters.
            // I still wrote this piece of code for a "general" hypothetical case
            // when `tree` could be a string of several characters, even though
            // such case is not possible with the current implementation.
            if (typeof tree === 'string') {
              var characterString = characters.join('');

              if (tree.indexOf(characterString) === 0) {
                // `tree` is always a single character.
                // If `tree.indexOf(characterString) === 0`
                // then `characters.length === tree.length`.

                /* istanbul ignore else */
                if (characters.length === tree.length) {
                  return {
                    match: true,
                    matchedChars: characters,
                  };
                } // `tree` is always a single character.
                // If `tree.indexOf(characterString) === 0`
                // then `characters.length === tree.length`.

                /* istanbul ignore next */

                return {
                  partialMatch: true, // matchedChars: characters
                };
              }

              if (characterString.indexOf(tree) === 0) {
                if (last) {
                  // The `else` path is not possible because `tree` is always a single character.
                  // The `else` case for `characters.length > tree.length` would be
                  // `characters.length <= tree.length` which means `characters.length <= 1`.
                  // `characters` array can't be empty, so that means `characters === [tree]`,
                  // which would also mean `tree.indexOf(characterString) === 0` and that'd mean
                  // that the `if (tree.indexOf(characterString) === 0)` condition before this
                  // `if` condition would be entered, and returned from there, not reaching this code.

                  /* istanbul ignore else */
                  if (characters.length > tree.length) {
                    return {
                      overflow: true,
                    };
                  }
                }

                return {
                  match: true,
                  matchedChars: characters.slice(0, tree.length),
                };
              }

              return;
            }

            if (Array.isArray(tree)) {
              var restCharacters = characters.slice();
              var i = 0;

              while (i < tree.length) {
                var subtree = tree[i];

                var result = _match(
                  restCharacters,
                  subtree,
                  last && i === tree.length - 1
                );

                if (!result) {
                  return;
                } else if (result.overflow) {
                  return result;
                } else if (result.match) {
                  // Continue with the next subtree with the rest of the characters.
                  restCharacters = restCharacters.slice(
                    result.matchedChars.length
                  );

                  if (restCharacters.length === 0) {
                    if (i === tree.length - 1) {
                      return {
                        match: true,
                        matchedChars: characters,
                      };
                    } else {
                      return {
                        partialMatch: true, // matchedChars: characters
                      };
                    }
                  }
                } else {
                  /* istanbul ignore else */
                  if (result.partialMatch) {
                    return {
                      partialMatch: true, // matchedChars: characters
                    };
                  } else {
                    throw new Error(
                      'Unsupported match result:\n'.concat(
                        JSON.stringify(result, null, 2)
                      )
                    );
                  }
                }

                i++;
              } // If `last` then overflow has already been checked
              // by the last element of the `tree` array.

              /* istanbul ignore if */

              if (last) {
                return {
                  overflow: true,
                };
              }

              return {
                match: true,
                matchedChars: characters.slice(
                  0,
                  characters.length - restCharacters.length
                ),
              };
            }

            switch (tree.op) {
              case '|':
                var partialMatch;

                for (
                  var _iterator =
                      AsYouTypeFormatter_PatternMatcher_createForOfIteratorHelperLoose(
                        tree.args
                      ),
                    _step;
                  !(_step = _iterator()).done;

                ) {
                  var branch = _step.value;

                  var _result = _match(characters, branch, last);

                  if (_result) {
                    if (_result.overflow) {
                      return _result;
                    } else if (_result.match) {
                      return {
                        match: true,
                        matchedChars: _result.matchedChars,
                      };
                    } else {
                      /* istanbul ignore else */
                      if (_result.partialMatch) {
                        partialMatch = true;
                      } else {
                        throw new Error(
                          'Unsupported match result:\n'.concat(
                            JSON.stringify(_result, null, 2)
                          )
                        );
                      }
                    }
                  }
                }

                if (partialMatch) {
                  return {
                    partialMatch: true, // matchedChars: ...
                  };
                } // Not even a partial match.

                return;

              case '[]':
                for (
                  var _iterator2 =
                      AsYouTypeFormatter_PatternMatcher_createForOfIteratorHelperLoose(
                        tree.args
                      ),
                    _step2;
                  !(_step2 = _iterator2()).done;

                ) {
                  var _char = _step2.value;

                  if (characters[0] === _char) {
                    if (characters.length === 1) {
                      return {
                        match: true,
                        matchedChars: characters,
                      };
                    }

                    if (last) {
                      return {
                        overflow: true,
                      };
                    }

                    return {
                      match: true,
                      matchedChars: [_char],
                    };
                  }
                } // No character matches.

                return;

              /* istanbul ignore next */

              default:
                throw new Error('Unsupported instruction tree: '.concat(tree));
            }
          }
          //# sourceMappingURL=AsYouTypeFormatter.PatternMatcher.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouTypeFormatter.js
          function AsYouTypeFormatter_createForOfIteratorHelperLoose(
            o,
            allowArrayLike
          ) {
            var it =
              (typeof Symbol !== 'undefined' && o[Symbol.iterator]) ||
              o['@@iterator'];
            if (it) return (it = it.call(o)).next.bind(it);
            if (
              Array.isArray(o) ||
              (it = AsYouTypeFormatter_unsupportedIterableToArray(o)) ||
              (allowArrayLike && o && typeof o.length === 'number')
            ) {
              if (it) o = it;
              var i = 0;
              return function () {
                if (i >= o.length) return { done: true };
                return { done: false, value: o[i++] };
              };
            }
            throw new TypeError(
              'Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function AsYouTypeFormatter_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return AsYouTypeFormatter_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return AsYouTypeFormatter_arrayLikeToArray(o, minLen);
          }

          function AsYouTypeFormatter_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          function AsYouTypeFormatter_classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function AsYouTypeFormatter_defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function AsYouTypeFormatter_createClass(
            Constructor,
            protoProps,
            staticProps
          ) {
            if (protoProps)
              AsYouTypeFormatter_defineProperties(
                Constructor.prototype,
                protoProps
              );
            if (staticProps)
              AsYouTypeFormatter_defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          // Used in phone number format template creation.
          // Could be any digit, I guess.

          var DUMMY_DIGIT = '9'; // I don't know why is it exactly `15`

          var LONGEST_NATIONAL_PHONE_NUMBER_LENGTH = 15; // Create a phone number consisting only of the digit 9 that matches the
          // `number_pattern` by applying the pattern to the "longest phone number" string.

          var LONGEST_DUMMY_PHONE_NUMBER = repeat(
            DUMMY_DIGIT,
            LONGEST_NATIONAL_PHONE_NUMBER_LENGTH
          ); // A set of characters that, if found in a national prefix formatting rules, are an indicator to
          // us that we should separate the national prefix from the number when formatting.

          var NATIONAL_PREFIX_SEPARATORS_PATTERN = /[- ]/; // Deprecated: Google has removed some formatting pattern related code from their repo.
          // https://github.com/googlei18n/libphonenumber/commit/a395b4fef3caf57c4bc5f082e1152a4d2bd0ba4c
          // "We no longer have numbers in formatting matching patterns, only \d."
          // Because this library supports generating custom metadata
          // some users may still be using old metadata so the relevant
          // code seems to stay until some next major version update.

          var SUPPORT_LEGACY_FORMATTING_PATTERNS = true; // A pattern that is used to match character classes in regular expressions.
          // An example of a character class is "[1-4]".

          var CREATE_CHARACTER_CLASS_PATTERN =
            SUPPORT_LEGACY_FORMATTING_PATTERNS &&
            function () {
              return /\[([^\[\]])*\]/g;
            }; // Any digit in a regular expression that actually denotes a digit. For
          // example, in the regular expression "80[0-2]\d{6,10}", the first 2 digits
          // (8 and 0) are standalone digits, but the rest are not.
          // Two look-aheads are needed because the number following \\d could be a
          // two-digit number, since the phone number can be as long as 15 digits.

          var CREATE_STANDALONE_DIGIT_PATTERN =
            SUPPORT_LEGACY_FORMATTING_PATTERNS &&
            function () {
              return /\d(?=[^,}][^,}])/g;
            }; // A regular expression that is used to determine if a `format` is
          // suitable to be used in the "as you type formatter".
          // A `format` is suitable when the resulting formatted number has
          // the same digits as the user has entered.
          //
          // In the simplest case, that would mean that the format
          // doesn't add any additional digits when formatting a number.
          // Google says that it also shouldn't add "star" (`*`) characters,
          // like it does in some Israeli formats.
          // Such basic format would only contain "valid punctuation"
          // and "captured group" identifiers ($1, $2, etc).
          //
          // An example of a format that adds additional digits:
          //
          // Country: `AR` (Argentina).
          // Format:
          // {
          //    "pattern": "(\\d)(\\d{2})(\\d{4})(\\d{4})",
          //    "leading_digits_patterns": ["91"],
          //    "national_prefix_formatting_rule": "0$1",
          //    "format": "$2 15-$3-$4",
          //    "international_format": "$1 $2 $3-$4"
          // }
          //
          // In the format above, the `format` adds `15` to the digits when formatting a number.
          // A sidenote: this format actually is suitable because `national_prefix_for_parsing`
          // has previously removed `15` from a national number, so re-adding `15` in `format`
          // doesn't actually result in any extra digits added to user's input.
          // But verifying that would be a complex procedure, so the code chooses a simpler path:
          // it simply filters out all `format`s that contain anything but "captured group" ids.
          //
          // This regular expression is called `ELIGIBLE_FORMAT_PATTERN` in Google's
          // `libphonenumber` code.
          //

          var NON_ALTERING_FORMAT_REG_EXP = new RegExp(
            '[' +
              VALID_PUNCTUATION +
              ']*' + // Google developers say:
              // "We require that the first matching group is present in the
              //  output pattern to ensure no data is lost while formatting."
              '\\$1' +
              '[' +
              VALID_PUNCTUATION +
              ']*' +
              '(\\$\\d[' +
              VALID_PUNCTUATION +
              ']*)*' +
              '$'
          ); // This is the minimum length of the leading digits of a phone number
          // to guarantee the first "leading digits pattern" for a phone number format
          // to be preemptive.

          var MIN_LEADING_DIGITS_LENGTH = 3;

          var AsYouTypeFormatter_AsYouTypeFormatter =
            /*#__PURE__*/ (function () {
              function AsYouTypeFormatter(_ref) {
                var state = _ref.state,
                  metadata = _ref.metadata;

                AsYouTypeFormatter_classCallCheck(this, AsYouTypeFormatter);

                this.metadata = metadata;
                this.resetFormat();
              }

              AsYouTypeFormatter_createClass(AsYouTypeFormatter, [
                {
                  key: 'resetFormat',
                  value: function resetFormat() {
                    this.chosenFormat = undefined;
                    this.template = undefined;
                    this.nationalNumberTemplate = undefined;
                    this.populatedNationalNumberTemplate = undefined;
                    this.populatedNationalNumberTemplatePosition = -1;
                  },
                },
                {
                  key: 'reset',
                  value: function reset(numberingPlan, state) {
                    this.resetFormat();

                    if (numberingPlan) {
                      this.isNANP = numberingPlan.callingCode() === '1';
                      this.matchingFormats = numberingPlan.formats();

                      if (state.nationalSignificantNumber) {
                        this.narrowDownMatchingFormats(state);
                      }
                    } else {
                      this.isNANP = undefined;
                      this.matchingFormats = [];
                    }
                  },
                  /**
                   * Formats an updated phone number.
                   * @param  {string} nextDigits — Additional phone number digits.
                   * @param  {object} state — `AsYouType` state.
                   * @return {[string]} Returns undefined if the updated phone number can't be formatted using any of the available formats.
                   */
                },
                {
                  key: 'format',
                  value: function format(nextDigits, state) {
                    var _this = this;

                    // See if the phone number digits can be formatted as a complete phone number.
                    // If not, use the results from `formatNationalNumberWithNextDigits()`,
                    // which formats based on the chosen formatting pattern.
                    //
                    // Attempting to format complete phone number first is how it's done
                    // in Google's `libphonenumber`, so this library just follows it.
                    // Google's `libphonenumber` code doesn't explain in detail why does it
                    // attempt to format digits as a complete phone number
                    // instead of just going with a previoulsy (or newly) chosen `format`:
                    //
                    // "Checks to see if there is an exact pattern match for these digits.
                    //  If so, we should use this instead of any other formatting template
                    //  whose leadingDigitsPattern also matches the input."
                    //
                    if (
                      canFormatCompleteNumber(
                        state.nationalSignificantNumber,
                        this.metadata
                      )
                    ) {
                      for (
                        var _iterator =
                            AsYouTypeFormatter_createForOfIteratorHelperLoose(
                              this.matchingFormats
                            ),
                          _step;
                        !(_step = _iterator()).done;

                      ) {
                        var format = _step.value;
                        var formattedCompleteNumber = formatCompleteNumber(
                          state,
                          format,
                          {
                            metadata: this.metadata,
                            shouldTryNationalPrefixFormattingRule:
                              function shouldTryNationalPrefixFormattingRule(
                                format
                              ) {
                                return _this.shouldTryNationalPrefixFormattingRule(
                                  format,
                                  {
                                    international: state.international,
                                    nationalPrefix: state.nationalPrefix,
                                  }
                                );
                              },
                            getSeparatorAfterNationalPrefix:
                              function getSeparatorAfterNationalPrefix(format) {
                                return _this.getSeparatorAfterNationalPrefix(
                                  format
                                );
                              },
                          }
                        );

                        if (formattedCompleteNumber) {
                          this.resetFormat();
                          this.chosenFormat = format;
                          this.setNationalNumberTemplate(
                            formattedCompleteNumber.replace(
                              /\d/g,
                              DIGIT_PLACEHOLDER
                            ),
                            state
                          );
                          this.populatedNationalNumberTemplate =
                            formattedCompleteNumber; // With a new formatting template, the matched position
                          // using the old template needs to be reset.

                          this.populatedNationalNumberTemplatePosition =
                            this.template.lastIndexOf(DIGIT_PLACEHOLDER);
                          return formattedCompleteNumber;
                        }
                      }
                    } // Format the digits as a partial (incomplete) phone number
                    // using the previously chosen formatting pattern (or a newly chosen one).

                    return this.formatNationalNumberWithNextDigits(
                      nextDigits,
                      state
                    );
                  }, // Formats the next phone number digits.
                },
                {
                  key: 'formatNationalNumberWithNextDigits',
                  value: function formatNationalNumberWithNextDigits(
                    nextDigits,
                    state
                  ) {
                    var previouslyChosenFormat = this.chosenFormat; // Choose a format from the list of matching ones.

                    var newlyChosenFormat = this.chooseFormat(state);

                    if (newlyChosenFormat) {
                      if (newlyChosenFormat === previouslyChosenFormat) {
                        // If it can format the next (current) digits
                        // using the previously chosen phone number format
                        // then return the updated formatted number.
                        return this.formatNextNationalNumberDigits(nextDigits);
                      } else {
                        // If a more appropriate phone number format
                        // has been chosen for these "leading digits",
                        // then re-format the national phone number part
                        // using the newly selected format.
                        return this.formatNextNationalNumberDigits(
                          state.getNationalDigits()
                        );
                      }
                    }
                  },
                },
                {
                  key: 'narrowDownMatchingFormats',
                  value: function narrowDownMatchingFormats(_ref2) {
                    var _this2 = this;

                    var nationalSignificantNumber =
                        _ref2.nationalSignificantNumber,
                      nationalPrefix = _ref2.nationalPrefix,
                      international = _ref2.international;
                    var leadingDigits = nationalSignificantNumber; // "leading digits" pattern list starts with a
                    // "leading digits" pattern fitting a maximum of 3 leading digits.
                    // So, after a user inputs 3 digits of a national (significant) phone number
                    // this national (significant) number can already be formatted.
                    // The next "leading digits" pattern is for 4 leading digits max,
                    // and the "leading digits" pattern after it is for 5 leading digits max, etc.
                    // This implementation is different from Google's
                    // in that it searches for a fitting format
                    // even if the user has entered less than
                    // `MIN_LEADING_DIGITS_LENGTH` digits of a national number.
                    // Because some leading digit patterns already match for a single first digit.

                    var leadingDigitsPatternIndex =
                      leadingDigits.length - MIN_LEADING_DIGITS_LENGTH;

                    if (leadingDigitsPatternIndex < 0) {
                      leadingDigitsPatternIndex = 0;
                    }

                    this.matchingFormats = this.matchingFormats.filter(
                      function (format) {
                        return (
                          _this2.formatSuits(
                            format,
                            international,
                            nationalPrefix
                          ) &&
                          _this2.formatMatches(
                            format,
                            leadingDigits,
                            leadingDigitsPatternIndex
                          )
                        );
                      }
                    ); // If there was a phone number format chosen
                    // and it no longer holds given the new leading digits then reset it.
                    // The test for this `if` condition is marked as:
                    // "Reset a chosen format when it no longer holds given the new leading digits".
                    // To construct a valid test case for this one can find a country
                    // in `PhoneNumberMetadata.xml` yielding one format for 3 `<leadingDigits>`
                    // and yielding another format for 4 `<leadingDigits>` (Australia in this case).

                    if (
                      this.chosenFormat &&
                      this.matchingFormats.indexOf(this.chosenFormat) === -1
                    ) {
                      this.resetFormat();
                    }
                  },
                },
                {
                  key: 'formatSuits',
                  value: function formatSuits(
                    format,
                    international,
                    nationalPrefix
                  ) {
                    // When a prefix before a national (significant) number is
                    // simply a national prefix, then it's parsed as `this.nationalPrefix`.
                    // In more complex cases, a prefix before national (significant) number
                    // could include a national prefix as well as some "capturing groups",
                    // and in that case there's no info whether a national prefix has been parsed.
                    // If national prefix is not used when formatting a phone number
                    // using this format, but a national prefix has been entered by the user,
                    // and was extracted, then discard such phone number format.
                    // In Google's "AsYouType" formatter code, the equivalent would be this part:
                    // https://github.com/google/libphonenumber/blob/0a45cfd96e71cad8edb0e162a70fcc8bd9728933/java/libphonenumber/src/com/google/i18n/phonenumbers/AsYouTypeFormatter.java#L175-L184
                    if (
                      nationalPrefix &&
                      !format.usesNationalPrefix() && // !format.domesticCarrierCodeFormattingRule() &&
                      !format.nationalPrefixIsOptionalWhenFormattingInNationalFormat()
                    ) {
                      return false;
                    } // If national prefix is mandatory for this phone number format
                    // and there're no guarantees that a national prefix is present in user input
                    // then discard this phone number format as not suitable.
                    // In Google's "AsYouType" formatter code, the equivalent would be this part:
                    // https://github.com/google/libphonenumber/blob/0a45cfd96e71cad8edb0e162a70fcc8bd9728933/java/libphonenumber/src/com/google/i18n/phonenumbers/AsYouTypeFormatter.java#L185-L193

                    if (
                      !international &&
                      !nationalPrefix &&
                      format.nationalPrefixIsMandatoryWhenFormattingInNationalFormat()
                    ) {
                      return false;
                    }

                    return true;
                  },
                },
                {
                  key: 'formatMatches',
                  value: function formatMatches(
                    format,
                    leadingDigits,
                    leadingDigitsPatternIndex
                  ) {
                    var leadingDigitsPatternsCount =
                      format.leadingDigitsPatterns().length; // If this format is not restricted to a certain
                    // leading digits pattern then it fits.
                    // The test case could be found by searching for "leadingDigitsPatternsCount === 0".

                    if (leadingDigitsPatternsCount === 0) {
                      return true;
                    } // Start narrowing down the list of possible formats based on the leading digits.
                    // (only previously matched formats take part in the narrowing down process)
                    // `leading_digits_patterns` start with 3 digits min
                    // and then go up from there one digit at a time.

                    leadingDigitsPatternIndex = Math.min(
                      leadingDigitsPatternIndex,
                      leadingDigitsPatternsCount - 1
                    );
                    var leadingDigitsPattern =
                      format.leadingDigitsPatterns()[leadingDigitsPatternIndex]; // Google imposes a requirement on the leading digits
                    // to be minimum 3 digits long in order to be eligible
                    // for checking those with a leading digits pattern.
                    //
                    // Since `leading_digits_patterns` start with 3 digits min,
                    // Google's original `libphonenumber` library only starts
                    // excluding any non-matching formats only when the
                    // national number entered so far is at least 3 digits long,
                    // otherwise format matching would give false negatives.
                    //
                    // For example, when the digits entered so far are `2`
                    // and the leading digits pattern is `21` –
                    // it's quite obvious in this case that the format could be the one
                    // but due to the absence of further digits it would give false negative.
                    //
                    // Also, `leading_digits_patterns` doesn't always correspond to a single
                    // digits count. For example, `60|8` pattern would already match `8`
                    // but the `60` part would require having at least two leading digits,
                    // so the whole pattern would require inputting two digits first in order to
                    // decide on whether it matches the input, even when the input is "80".
                    //
                    // This library — `libphonenumber-js` — allows filtering by `leading_digits_patterns`
                    // even when there's only 1 or 2 digits of the national (significant) number.
                    // To do that, it uses a non-strict pattern matcher written specifically for that.
                    //

                    if (leadingDigits.length < MIN_LEADING_DIGITS_LENGTH) {
                      // Before leading digits < 3 matching was implemented:
                      // return true
                      //
                      // After leading digits < 3 matching was implemented:
                      try {
                        return (
                          new AsYouTypeFormatter_PatternMatcher_PatternMatcher(
                            leadingDigitsPattern
                          ).match(leadingDigits, {
                            allowOverflow: true,
                          }) !== undefined
                        );
                      } catch (
                        error
                        /* istanbul ignore next */
                      ) {
                        // There's a slight possibility that there could be some undiscovered bug
                        // in the pattern matcher code. Since the "leading digits < 3 matching"
                        // feature is not "essential" for operation, it can fall back to the old way
                        // in case of any issues rather than halting the application's execution.
                        console.error(error);
                        return true;
                      }
                    } // If at least `MIN_LEADING_DIGITS_LENGTH` digits of a national number are
                    // available then use the usual regular expression matching.
                    //
                    // The whole pattern is wrapped in round brackets (`()`) because
                    // the pattern can use "or" operator (`|`) at the top level of the pattern.
                    //

                    return new RegExp(
                      '^('.concat(leadingDigitsPattern, ')')
                    ).test(leadingDigits);
                  },
                },
                {
                  key: 'getFormatFormat',
                  value: function getFormatFormat(format, international) {
                    return international
                      ? format.internationalFormat()
                      : format.format();
                  },
                },
                {
                  key: 'chooseFormat',
                  value: function chooseFormat(state) {
                    var _this3 = this;

                    var _loop = function _loop() {
                      var format = _step2.value;

                      // If this format is currently being used
                      // and is still suitable, then stick to it.
                      if (_this3.chosenFormat === format) {
                        return 'break';
                      } // Sometimes, a formatting rule inserts additional digits in a phone number,
                      // and "as you type" formatter can't do that: it should only use the digits
                      // that the user has input.
                      //
                      // For example, in Argentina, there's a format for mobile phone numbers:
                      //
                      // {
                      //    "pattern": "(\\d)(\\d{2})(\\d{4})(\\d{4})",
                      //    "leading_digits_patterns": ["91"],
                      //    "national_prefix_formatting_rule": "0$1",
                      //    "format": "$2 15-$3-$4",
                      //    "international_format": "$1 $2 $3-$4"
                      // }
                      //
                      // In that format, `international_format` is used instead of `format`
                      // because `format` inserts `15` in the formatted number,
                      // and `AsYouType` formatter should only use the digits
                      // the user has actually input, without adding any extra digits.
                      // In this case, it wouldn't make a difference, because the `15`
                      // is first stripped when applying `national_prefix_for_parsing`
                      // and then re-added when using `format`, so in reality it doesn't
                      // add any new digits to the number, but to detect that, the code
                      // would have to be more complex: it would have to try formatting
                      // the digits using the format and then see if any digits have
                      // actually been added or removed, and then, every time a new digit
                      // is input, it should re-check whether the chosen format doesn't
                      // alter the digits.
                      //
                      // Google's code doesn't go that far, and so does this library:
                      // it simply requires that a `format` doesn't add any additonal
                      // digits to user's input.
                      //
                      // Also, people in general should move from inputting phone numbers
                      // in national format (possibly with national prefixes)
                      // and use international phone number format instead:
                      // it's a logical thing in the modern age of mobile phones,
                      // globalization and the internet.
                      //

                      /* istanbul ignore if */

                      if (
                        !NON_ALTERING_FORMAT_REG_EXP.test(
                          _this3.getFormatFormat(format, state.international)
                        )
                      ) {
                        return 'continue';
                      }

                      if (!_this3.createTemplateForFormat(format, state)) {
                        // Remove the format if it can't generate a template.
                        _this3.matchingFormats = _this3.matchingFormats.filter(
                          function (_) {
                            return _ !== format;
                          }
                        );
                        return 'continue';
                      }

                      _this3.chosenFormat = format;
                      return 'break';
                    };

                    // When there are multiple available formats, the formatter uses the first
                    // format where a formatting template could be created.
                    //
                    // For some weird reason, `istanbul` says "else path not taken"
                    // for the `for of` line below. Supposedly that means that
                    // the loop doesn't ever go over the last element in the list.
                    // That's true because there always is `this.chosenFormat`
                    // when `this.matchingFormats` is non-empty.
                    // And, for some weird reason, it doesn't think that the case
                    // with empty `this.matchingFormats` qualifies for a valid "else" path.
                    // So simply muting this `istanbul` warning.
                    // It doesn't skip the contents of the `for of` loop,
                    // it just skips the `for of` line.
                    //

                    /* istanbul ignore next */
                    for (
                      var _iterator2 =
                          AsYouTypeFormatter_createForOfIteratorHelperLoose(
                            this.matchingFormats.slice()
                          ),
                        _step2;
                      !(_step2 = _iterator2()).done;

                    ) {
                      var _ret = _loop();

                      if (_ret === 'break') break;
                      if (_ret === 'continue') continue;
                    }

                    if (!this.chosenFormat) {
                      // No format matches the national (significant) phone number.
                      this.resetFormat();
                    }

                    return this.chosenFormat;
                  },
                },
                {
                  key: 'createTemplateForFormat',
                  value: function createTemplateForFormat(format, state) {
                    // The formatter doesn't format numbers when numberPattern contains '|', e.g.
                    // (20|3)\d{4}. In those cases we quickly return.
                    // (Though there's no such format in current metadata)

                    /* istanbul ignore if */
                    if (
                      SUPPORT_LEGACY_FORMATTING_PATTERNS &&
                      format.pattern().indexOf('|') >= 0
                    ) {
                      return;
                    } // Get formatting template for this phone number format

                    var template = this.getTemplateForFormat(format, state); // If the national number entered is too long
                    // for any phone number format, then abort.

                    if (template) {
                      this.setNationalNumberTemplate(template, state);
                      return true;
                    }
                  },
                },
                {
                  key: 'getSeparatorAfterNationalPrefix',
                  value: function getSeparatorAfterNationalPrefix(format) {
                    // `US` metadata doesn't have a `national_prefix_formatting_rule`,
                    // so the `if` condition below doesn't apply to `US`,
                    // but in reality there shoudl be a separator
                    // between a national prefix and a national (significant) number.
                    // So `US` national prefix separator is a "special" "hardcoded" case.
                    if (this.isNANP) {
                      return ' ';
                    } // If a `format` has a `national_prefix_formatting_rule`
                    // and that rule has a separator after a national prefix,
                    // then it means that there should be a separator
                    // between a national prefix and a national (significant) number.

                    if (
                      format &&
                      format.nationalPrefixFormattingRule() &&
                      NATIONAL_PREFIX_SEPARATORS_PATTERN.test(
                        format.nationalPrefixFormattingRule()
                      )
                    ) {
                      return ' ';
                    } // At this point, there seems to be no clear evidence that
                    // there should be a separator between a national prefix
                    // and a national (significant) number. So don't insert one.

                    return '';
                  },
                },
                {
                  key: 'getInternationalPrefixBeforeCountryCallingCode',
                  value:
                    function getInternationalPrefixBeforeCountryCallingCode(
                      _ref3,
                      options
                    ) {
                      var IDDPrefix = _ref3.IDDPrefix,
                        missingPlus = _ref3.missingPlus;

                      if (IDDPrefix) {
                        return options && options.spacing === false
                          ? IDDPrefix
                          : IDDPrefix + ' ';
                      }

                      if (missingPlus) {
                        return '';
                      }

                      return '+';
                    },
                },
                {
                  key: 'getTemplate',
                  value: function getTemplate(state) {
                    if (!this.template) {
                      return;
                    } // `this.template` holds the template for a "complete" phone number.
                    // The currently entered phone number is most likely not "complete",
                    // so trim all non-populated digits.

                    var index = -1;
                    var i = 0;
                    var internationalPrefix = state.international
                      ? this.getInternationalPrefixBeforeCountryCallingCode(
                          state,
                          {
                            spacing: false,
                          }
                        )
                      : '';

                    while (
                      i <
                      internationalPrefix.length +
                        state.getDigitsWithoutInternationalPrefix().length
                    ) {
                      index = this.template.indexOf(
                        DIGIT_PLACEHOLDER,
                        index + 1
                      );
                      i++;
                    }

                    return cutAndStripNonPairedParens(this.template, index + 1);
                  },
                },
                {
                  key: 'setNationalNumberTemplate',
                  value: function setNationalNumberTemplate(template, state) {
                    this.nationalNumberTemplate = template;
                    this.populatedNationalNumberTemplate = template; // With a new formatting template, the matched position
                    // using the old template needs to be reset.

                    this.populatedNationalNumberTemplatePosition = -1; // For convenience, the public `.template` property
                    // contains the whole international number
                    // if the phone number being input is international:
                    // 'x' for the '+' sign, 'x'es for the country phone code,
                    // a spacebar and then the template for the formatted national number.

                    if (state.international) {
                      this.template =
                        this.getInternationalPrefixBeforeCountryCallingCode(
                          state
                        ).replace(/[\d\+]/g, DIGIT_PLACEHOLDER) +
                        repeat(DIGIT_PLACEHOLDER, state.callingCode.length) +
                        ' ' +
                        template;
                    } else {
                      this.template = template;
                    }
                  },
                  /**
                   * Generates formatting template for a national phone number,
                   * optionally containing a national prefix, for a format.
                   * @param  {Format} format
                   * @param  {string} nationalPrefix
                   * @return {string}
                   */
                },
                {
                  key: 'getTemplateForFormat',
                  value: function getTemplateForFormat(format, _ref4) {
                    var nationalSignificantNumber =
                        _ref4.nationalSignificantNumber,
                      international = _ref4.international,
                      nationalPrefix = _ref4.nationalPrefix,
                      complexPrefixBeforeNationalSignificantNumber =
                        _ref4.complexPrefixBeforeNationalSignificantNumber;
                    var pattern = format.pattern();
                    /* istanbul ignore else */

                    if (SUPPORT_LEGACY_FORMATTING_PATTERNS) {
                      pattern = pattern // Replace anything in the form of [..] with \d
                        .replace(CREATE_CHARACTER_CLASS_PATTERN(), '\\d') // Replace any standalone digit (not the one in `{}`) with \d
                        .replace(CREATE_STANDALONE_DIGIT_PATTERN(), '\\d');
                    } // Generate a dummy national number (consisting of `9`s)
                    // that fits this format's `pattern`.
                    //
                    // This match will always succeed,
                    // because the "longest dummy phone number"
                    // has enough length to accomodate any possible
                    // national phone number format pattern.
                    //

                    var digits = LONGEST_DUMMY_PHONE_NUMBER.match(pattern)[0]; // If the national number entered is too long
                    // for any phone number format, then abort.

                    if (nationalSignificantNumber.length > digits.length) {
                      return;
                    } // Get a formatting template which can be used to efficiently format
                    // a partial number where digits are added one by one.
                    // Below `strictPattern` is used for the
                    // regular expression (with `^` and `$`).
                    // This wasn't originally in Google's `libphonenumber`
                    // and I guess they don't really need it
                    // because they're not using "templates" to format phone numbers
                    // but I added `strictPattern` after encountering
                    // South Korean phone number formatting bug.
                    //
                    // Non-strict regular expression bug demonstration:
                    //
                    // this.nationalSignificantNumber : `111111111` (9 digits)
                    //
                    // pattern : (\d{2})(\d{3,4})(\d{4})
                    // format : `$1 $2 $3`
                    // digits : `9999999999` (10 digits)
                    //
                    // '9999999999'.replace(new RegExp(/(\d{2})(\d{3,4})(\d{4})/g), '$1 $2 $3') = "99 9999 9999"
                    //
                    // template : xx xxxx xxxx
                    //
                    // But the correct template in this case is `xx xxx xxxx`.
                    // The template was generated incorrectly because of the
                    // `{3,4}` variability in the `pattern`.
                    //
                    // The fix is, if `this.nationalSignificantNumber` has already sufficient length
                    // to satisfy the `pattern` completely then `this.nationalSignificantNumber`
                    // is used instead of `digits`.

                    var strictPattern = new RegExp('^' + pattern + '$');
                    var nationalNumberDummyDigits =
                      nationalSignificantNumber.replace(/\d/g, DUMMY_DIGIT); // If `this.nationalSignificantNumber` has already sufficient length
                    // to satisfy the `pattern` completely then use it
                    // instead of `digits`.

                    if (strictPattern.test(nationalNumberDummyDigits)) {
                      digits = nationalNumberDummyDigits;
                    }

                    var numberFormat = this.getFormatFormat(
                      format,
                      international
                    );
                    var nationalPrefixIncludedInTemplate; // If a user did input a national prefix (and that's guaranteed),
                    // and if a `format` does have a national prefix formatting rule,
                    // then see if that national prefix formatting rule
                    // prepends exactly the same national prefix the user has input.
                    // If that's the case, then use the `format` with the national prefix formatting rule.
                    // Otherwise, use  the `format` without the national prefix formatting rule,
                    // and prepend a national prefix manually to it.

                    if (
                      this.shouldTryNationalPrefixFormattingRule(format, {
                        international: international,
                        nationalPrefix: nationalPrefix,
                      })
                    ) {
                      var numberFormatWithNationalPrefix = numberFormat.replace(
                        FIRST_GROUP_PATTERN,
                        format.nationalPrefixFormattingRule()
                      ); // If `national_prefix_formatting_rule` of a `format` simply prepends
                      // national prefix at the start of a national (significant) number,
                      // then such formatting can be used with `AsYouType` formatter.
                      // There seems to be no `else` case: everywhere in metadata,
                      // national prefix formatting rule is national prefix + $1,
                      // or `($1)`, in which case such format isn't even considered
                      // when the user has input a national prefix.

                      /* istanbul ignore else */

                      if (
                        parseDigits(format.nationalPrefixFormattingRule()) ===
                        (nationalPrefix || '') + parseDigits('$1')
                      ) {
                        numberFormat = numberFormatWithNationalPrefix;
                        nationalPrefixIncludedInTemplate = true; // Replace all digits of the national prefix in the formatting template
                        // with `DIGIT_PLACEHOLDER`s.

                        if (nationalPrefix) {
                          var i = nationalPrefix.length;

                          while (i > 0) {
                            numberFormat = numberFormat.replace(
                              /\d/,
                              DIGIT_PLACEHOLDER
                            );
                            i--;
                          }
                        }
                      }
                    } // Generate formatting template for this phone number format.

                    var template = digits // Format the dummy phone number according to the format.
                      .replace(new RegExp(pattern), numberFormat) // Replace each dummy digit with a DIGIT_PLACEHOLDER.
                      .replace(new RegExp(DUMMY_DIGIT, 'g'), DIGIT_PLACEHOLDER); // If a prefix of a national (significant) number is not as simple
                    // as just a basic national prefix, then just prepend such prefix
                    // before the national (significant) number, optionally spacing
                    // the two with a whitespace.

                    if (!nationalPrefixIncludedInTemplate) {
                      if (complexPrefixBeforeNationalSignificantNumber) {
                        // Prepend the prefix to the template manually.
                        template =
                          repeat(
                            DIGIT_PLACEHOLDER,
                            complexPrefixBeforeNationalSignificantNumber.length
                          ) +
                          ' ' +
                          template;
                      } else if (nationalPrefix) {
                        // Prepend national prefix to the template manually.
                        template =
                          repeat(DIGIT_PLACEHOLDER, nationalPrefix.length) +
                          this.getSeparatorAfterNationalPrefix(format) +
                          template;
                      }
                    }

                    if (international) {
                      template = applyInternationalSeparatorStyle(template);
                    }

                    return template;
                  },
                },
                {
                  key: 'formatNextNationalNumberDigits',
                  value: function formatNextNationalNumberDigits(digits) {
                    var result = populateTemplateWithDigits(
                      this.populatedNationalNumberTemplate,
                      this.populatedNationalNumberTemplatePosition,
                      digits
                    );

                    if (!result) {
                      // Reset the format.
                      this.resetFormat();
                      return;
                    }

                    this.populatedNationalNumberTemplate = result[0];
                    this.populatedNationalNumberTemplatePosition = result[1]; // Return the formatted phone number so far.

                    return cutAndStripNonPairedParens(
                      this.populatedNationalNumberTemplate,
                      this.populatedNationalNumberTemplatePosition + 1
                    ); // The old way which was good for `input-format` but is not so good
                    // for `react-phone-number-input`'s default input (`InputBasic`).
                    // return closeNonPairedParens(this.populatedNationalNumberTemplate, this.populatedNationalNumberTemplatePosition + 1)
                    // 	.replace(new RegExp(DIGIT_PLACEHOLDER, 'g'), ' ')
                  },
                },
                {
                  key: 'shouldTryNationalPrefixFormattingRule',
                  value: function shouldTryNationalPrefixFormattingRule(
                    format,
                    _ref5
                  ) {
                    var international = _ref5.international,
                      nationalPrefix = _ref5.nationalPrefix;

                    if (format.nationalPrefixFormattingRule()) {
                      // In some countries, `national_prefix_formatting_rule` is `($1)`,
                      // so it applies even if the user hasn't input a national prefix.
                      // `format.usesNationalPrefix()` detects such cases.
                      var usesNationalPrefix = format.usesNationalPrefix();

                      if (
                        (usesNationalPrefix && nationalPrefix) ||
                        (!usesNationalPrefix && !international)
                      ) {
                        return true;
                      }
                    }
                  },
                },
              ]);

              return AsYouTypeFormatter;
            })();

          //# sourceMappingURL=AsYouTypeFormatter.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouTypeParser.js
          function AsYouTypeParser_slicedToArray(arr, i) {
            return (
              AsYouTypeParser_arrayWithHoles(arr) ||
              AsYouTypeParser_iterableToArrayLimit(arr, i) ||
              AsYouTypeParser_unsupportedIterableToArray(arr, i) ||
              AsYouTypeParser_nonIterableRest()
            );
          }

          function AsYouTypeParser_nonIterableRest() {
            throw new TypeError(
              'Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function AsYouTypeParser_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return AsYouTypeParser_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return AsYouTypeParser_arrayLikeToArray(o, minLen);
          }

          function AsYouTypeParser_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          function AsYouTypeParser_iterableToArrayLimit(arr, i) {
            var _i =
              arr == null
                ? null
                : (typeof Symbol !== 'undefined' && arr[Symbol.iterator]) ||
                  arr['@@iterator'];
            if (_i == null) return;
            var _arr = [];
            var _n = true;
            var _d = false;
            var _s, _e;
            try {
              for (
                _i = _i.call(arr);
                !(_n = (_s = _i.next()).done);
                _n = true
              ) {
                _arr.push(_s.value);
                if (i && _arr.length === i) break;
              }
            } catch (err) {
              _d = true;
              _e = err;
            } finally {
              try {
                if (!_n && _i['return'] != null) _i['return']();
              } finally {
                if (_d) throw _e;
              }
            }
            return _arr;
          }

          function AsYouTypeParser_arrayWithHoles(arr) {
            if (Array.isArray(arr)) return arr;
          }

          function AsYouTypeParser_classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function AsYouTypeParser_defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function AsYouTypeParser_createClass(
            Constructor,
            protoProps,
            staticProps
          ) {
            if (protoProps)
              AsYouTypeParser_defineProperties(
                Constructor.prototype,
                protoProps
              );
            if (staticProps)
              AsYouTypeParser_defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          var VALID_FORMATTED_PHONE_NUMBER_DIGITS_PART =
            '[' + VALID_PUNCTUATION + VALID_DIGITS + ']+';
          var VALID_FORMATTED_PHONE_NUMBER_DIGITS_PART_PATTERN = new RegExp(
            '^' + VALID_FORMATTED_PHONE_NUMBER_DIGITS_PART + '$',
            'i'
          );
          var VALID_FORMATTED_PHONE_NUMBER_PART =
            '(?:' +
            '[' +
            PLUS_CHARS +
            ']' +
            '[' +
            VALID_PUNCTUATION +
            VALID_DIGITS +
            ']*' +
            '|' +
            '[' +
            VALID_PUNCTUATION +
            VALID_DIGITS +
            ']+' +
            ')';
          var AFTER_PHONE_NUMBER_DIGITS_END_PATTERN = new RegExp(
            '[^' + VALID_PUNCTUATION + VALID_DIGITS + ']+' + '.*' + '$'
          ); // Tests whether `national_prefix_for_parsing` could match
          // different national prefixes.
          // Matches anything that's not a digit or a square bracket.

          var COMPLEX_NATIONAL_PREFIX = /[^\d\[\]]/;

          var AsYouTypeParser_AsYouTypeParser = /*#__PURE__*/ (function () {
            function AsYouTypeParser(_ref) {
              var defaultCountry = _ref.defaultCountry,
                defaultCallingCode = _ref.defaultCallingCode,
                metadata = _ref.metadata,
                onNationalSignificantNumberChange =
                  _ref.onNationalSignificantNumberChange;

              AsYouTypeParser_classCallCheck(this, AsYouTypeParser);

              this.defaultCountry = defaultCountry;
              this.defaultCallingCode = defaultCallingCode;
              this.metadata = metadata;
              this.onNationalSignificantNumberChange =
                onNationalSignificantNumberChange;
            }

            AsYouTypeParser_createClass(AsYouTypeParser, [
              {
                key: 'input',
                value: function input(text, state) {
                  var _extractFormattedDigi =
                      extractFormattedDigitsAndPlus(text),
                    _extractFormattedDigi2 = AsYouTypeParser_slicedToArray(
                      _extractFormattedDigi,
                      2
                    ),
                    formattedDigits = _extractFormattedDigi2[0],
                    hasPlus = _extractFormattedDigi2[1];

                  var digits = parseDigits(formattedDigits); // Checks for a special case: just a leading `+` has been entered.

                  var justLeadingPlus;

                  if (hasPlus) {
                    if (!state.digits) {
                      state.startInternationalNumber();

                      if (!digits) {
                        justLeadingPlus = true;
                      }
                    }
                  }

                  if (digits) {
                    this.inputDigits(digits, state);
                  }

                  return {
                    digits: digits,
                    justLeadingPlus: justLeadingPlus,
                  };
                },
                /**
                 * Inputs "next" phone number digits.
                 * @param  {string} digits
                 * @return {string} [formattedNumber] Formatted national phone number (if it can be formatted at this stage). Returning `undefined` means "don't format the national phone number at this stage".
                 */
              },
              {
                key: 'inputDigits',
                value: function inputDigits(nextDigits, state) {
                  var digits = state.digits;
                  var hasReceivedThreeLeadingDigits =
                    digits.length < 3 && digits.length + nextDigits.length >= 3; // Append phone number digits.

                  state.appendDigits(nextDigits); // Attempt to extract IDD prefix:
                  // Some users input their phone number in international format,
                  // but in an "out-of-country" dialing format instead of using the leading `+`.
                  // https://github.com/catamphetamine/libphonenumber-js/issues/185
                  // Detect such numbers as soon as there're at least 3 digits.
                  // Google's library attempts to extract IDD prefix at 3 digits,
                  // so this library just copies that behavior.
                  // I guess that's because the most commot IDD prefixes are
                  // `00` (Europe) and `011` (US).
                  // There exist really long IDD prefixes too:
                  // for example, in Australia the default IDD prefix is `0011`,
                  // and it could even be as long as `14880011`.
                  // An IDD prefix is extracted here, and then every time when
                  // there's a new digit and the number couldn't be formatted.

                  if (hasReceivedThreeLeadingDigits) {
                    this.extractIddPrefix(state);
                  }

                  if (this.isWaitingForCountryCallingCode(state)) {
                    if (!this.extractCountryCallingCode(state)) {
                      return;
                    }
                  } else {
                    state.appendNationalSignificantNumberDigits(nextDigits);
                  } // If a phone number is being input in international format,
                  // then it's not valid for it to have a national prefix.
                  // Still, some people incorrectly input such numbers with a national prefix.
                  // In such cases, only attempt to strip a national prefix if the number becomes too long.
                  // (but that is done later, not here)

                  if (!state.international) {
                    if (!this.hasExtractedNationalSignificantNumber) {
                      this.extractNationalSignificantNumber(
                        state.getNationalDigits(),
                        function (stateUpdate) {
                          return state.update(stateUpdate);
                        }
                      );
                    }
                  }
                },
              },
              {
                key: 'isWaitingForCountryCallingCode',
                value: function isWaitingForCountryCallingCode(_ref2) {
                  var international = _ref2.international,
                    callingCode = _ref2.callingCode;
                  return international && !callingCode;
                }, // Extracts a country calling code from a number
                // being entered in internatonal format.
              },
              {
                key: 'extractCountryCallingCode',
                value: function extractCountryCallingCode(state) {
                  var _extractCountryCallin =
                      extractCountryCallingCode_extractCountryCallingCode(
                        '+' + state.getDigitsWithoutInternationalPrefix(),
                        this.defaultCountry,
                        this.defaultCallingCode,
                        this.metadata.metadata
                      ),
                    countryCallingCode =
                      _extractCountryCallin.countryCallingCode,
                    number = _extractCountryCallin.number;

                  if (countryCallingCode) {
                    state.setCallingCode(countryCallingCode);
                    state.update({
                      nationalSignificantNumber: number,
                    });
                    return true;
                  }
                },
              },
              {
                key: 'reset',
                value: function reset(numberingPlan) {
                  if (numberingPlan) {
                    this.hasSelectedNumberingPlan = true;

                    var nationalPrefixForParsing =
                      numberingPlan._nationalPrefixForParsing();

                    this.couldPossiblyExtractAnotherNationalSignificantNumber =
                      nationalPrefixForParsing &&
                      COMPLEX_NATIONAL_PREFIX.test(nationalPrefixForParsing);
                  } else {
                    this.hasSelectedNumberingPlan = undefined;
                    this.couldPossiblyExtractAnotherNationalSignificantNumber =
                      undefined;
                  }
                },
                /**
                 * Extracts a national (significant) number from user input.
                 * Google's library is different in that it only applies `national_prefix_for_parsing`
                 * and doesn't apply `national_prefix_transform_rule` after that.
                 * https://github.com/google/libphonenumber/blob/a3d70b0487875475e6ad659af404943211d26456/java/libphonenumber/src/com/google/i18n/phonenumbers/AsYouTypeFormatter.java#L539
                 * @return {boolean} [extracted]
                 */
              },
              {
                key: 'extractNationalSignificantNumber',
                value: function extractNationalSignificantNumber(
                  nationalDigits,
                  setState
                ) {
                  if (!this.hasSelectedNumberingPlan) {
                    return;
                  }

                  var _extractNationalNumbe =
                      extractNationalNumberFromPossiblyIncompleteNumber(
                        nationalDigits,
                        this.metadata
                      ),
                    nationalPrefix = _extractNationalNumbe.nationalPrefix,
                    nationalNumber = _extractNationalNumbe.nationalNumber,
                    carrierCode = _extractNationalNumbe.carrierCode;

                  if (nationalNumber === nationalDigits) {
                    return;
                  }

                  this.onExtractedNationalNumber(
                    nationalPrefix,
                    carrierCode,
                    nationalNumber,
                    nationalDigits,
                    setState
                  );
                  return true;
                },
                /**
                 * In Google's code this function is called "attempt to extract longer NDD".
                 * "Some national prefixes are a substring of others", they say.
                 * @return {boolean} [result] — Returns `true` if extracting a national prefix produced different results from what they were.
                 */
              },
              {
                key: 'extractAnotherNationalSignificantNumber',
                value: function extractAnotherNationalSignificantNumber(
                  nationalDigits,
                  prevNationalSignificantNumber,
                  setState
                ) {
                  if (!this.hasExtractedNationalSignificantNumber) {
                    return this.extractNationalSignificantNumber(
                      nationalDigits,
                      setState
                    );
                  }

                  if (
                    !this.couldPossiblyExtractAnotherNationalSignificantNumber
                  ) {
                    return;
                  }

                  var _extractNationalNumbe2 =
                      extractNationalNumberFromPossiblyIncompleteNumber(
                        nationalDigits,
                        this.metadata
                      ),
                    nationalPrefix = _extractNationalNumbe2.nationalPrefix,
                    nationalNumber = _extractNationalNumbe2.nationalNumber,
                    carrierCode = _extractNationalNumbe2.carrierCode; // If a national prefix has been extracted previously,
                  // then it's always extracted as additional digits are added.
                  // That's assuming `extractNationalNumberFromPossiblyIncompleteNumber()`
                  // doesn't do anything different from what it currently does.
                  // So, just in case, here's this check, though it doesn't occur.

                  /* istanbul ignore if */

                  if (nationalNumber === prevNationalSignificantNumber) {
                    return;
                  }

                  this.onExtractedNationalNumber(
                    nationalPrefix,
                    carrierCode,
                    nationalNumber,
                    nationalDigits,
                    setState
                  );
                  return true;
                },
              },
              {
                key: 'onExtractedNationalNumber',
                value: function onExtractedNationalNumber(
                  nationalPrefix,
                  carrierCode,
                  nationalSignificantNumber,
                  nationalDigits,
                  setState
                ) {
                  var complexPrefixBeforeNationalSignificantNumber;
                  var nationalSignificantNumberMatchesInput; // This check also works with empty `this.nationalSignificantNumber`.

                  var nationalSignificantNumberIndex =
                    nationalDigits.lastIndexOf(nationalSignificantNumber); // If the extracted national (significant) number is the
                  // last substring of the `digits`, then it means that it hasn't been altered:
                  // no digits have been removed from the national (significant) number
                  // while applying `national_prefix_transform_rule`.
                  // https://gitlab.com/catamphetamine/libphonenumber-js/-/blob/master/METADATA.md#national_prefix_for_parsing--national_prefix_transform_rule

                  if (
                    nationalSignificantNumberIndex >= 0 &&
                    nationalSignificantNumberIndex ===
                      nationalDigits.length - nationalSignificantNumber.length
                  ) {
                    nationalSignificantNumberMatchesInput = true; // If a prefix of a national (significant) number is not as simple
                    // as just a basic national prefix, then such prefix is stored in
                    // `this.complexPrefixBeforeNationalSignificantNumber` property and will be
                    // prepended "as is" to the national (significant) number to produce
                    // a formatted result.

                    var prefixBeforeNationalNumber = nationalDigits.slice(
                      0,
                      nationalSignificantNumberIndex
                    ); // `prefixBeforeNationalNumber` is always non-empty,
                    // because `onExtractedNationalNumber()` isn't called
                    // when a national (significant) number hasn't been actually "extracted":
                    // when a national (significant) number is equal to the national part of `digits`,
                    // then `onExtractedNationalNumber()` doesn't get called.

                    if (prefixBeforeNationalNumber !== nationalPrefix) {
                      complexPrefixBeforeNationalSignificantNumber =
                        prefixBeforeNationalNumber;
                    }
                  }

                  setState({
                    nationalPrefix: nationalPrefix,
                    carrierCode: carrierCode,
                    nationalSignificantNumber: nationalSignificantNumber,
                    nationalSignificantNumberMatchesInput:
                      nationalSignificantNumberMatchesInput,
                    complexPrefixBeforeNationalSignificantNumber:
                      complexPrefixBeforeNationalSignificantNumber,
                  }); // `onExtractedNationalNumber()` is only called when
                  // the national (significant) number actually did change.

                  this.hasExtractedNationalSignificantNumber = true;
                  this.onNationalSignificantNumberChange();
                },
              },
              {
                key: 'reExtractNationalSignificantNumber',
                value: function reExtractNationalSignificantNumber(state) {
                  // Attempt to extract a national prefix.
                  //
                  // Some people incorrectly input national prefix
                  // in an international phone number.
                  // For example, some people write British phone numbers as `+44(0)...`.
                  //
                  // Also, in some rare cases, it is valid for a national prefix
                  // to be a part of an international phone number.
                  // For example, mobile phone numbers in Mexico are supposed to be
                  // dialled internationally using a `1` national prefix,
                  // so the national prefix will be part of an international number.
                  //
                  // Quote from:
                  // https://www.mexperience.com/dialing-cell-phones-in-mexico/
                  //
                  // "Dialing a Mexican cell phone from abroad
                  // When you are calling a cell phone number in Mexico from outside Mexico,
                  // it’s necessary to dial an additional “1” after Mexico’s country code
                  // (which is “52”) and before the area code.
                  // You also ignore the 045, and simply dial the area code and the
                  // cell phone’s number.
                  //
                  // If you don’t add the “1”, you’ll receive a recorded announcement
                  // asking you to redial using it.
                  //
                  // For example, if you are calling from the USA to a cell phone
                  // in Mexico City, you would dial +52 – 1 – 55 – 1234 5678.
                  // (Note that this is different to calling a land line in Mexico City
                  // from abroad, where the number dialed would be +52 – 55 – 1234 5678)".
                  //
                  // Google's demo output:
                  // https://libphonenumber.appspot.com/phonenumberparser?number=%2b5215512345678&country=MX
                  //
                  if (
                    this.extractAnotherNationalSignificantNumber(
                      state.getNationalDigits(),
                      state.nationalSignificantNumber,
                      function (stateUpdate) {
                        return state.update(stateUpdate);
                      }
                    )
                  ) {
                    return true;
                  } // If no format matches the phone number, then it could be
                  // "a really long IDD" (quote from a comment in Google's library).
                  // An IDD prefix is first extracted when the user has entered at least 3 digits,
                  // and then here — every time when there's a new digit and the number
                  // couldn't be formatted.
                  // For example, in Australia the default IDD prefix is `0011`,
                  // and it could even be as long as `14880011`.
                  //
                  // Could also check `!hasReceivedThreeLeadingDigits` here
                  // to filter out the case when this check duplicates the one
                  // already performed when there're 3 leading digits,
                  // but it's not a big deal, and in most cases there
                  // will be a suitable `format` when there're 3 leading digits.
                  //

                  if (this.extractIddPrefix(state)) {
                    this.extractCallingCodeAndNationalSignificantNumber(state);
                    return true;
                  } // Google's AsYouType formatter supports sort of an "autocorrection" feature
                  // when it "autocorrects" numbers that have been input for a country
                  // with that country's calling code.
                  // Such "autocorrection" feature looks weird, but different people have been requesting it:
                  // https://github.com/catamphetamine/libphonenumber-js/issues/376
                  // https://github.com/catamphetamine/libphonenumber-js/issues/375
                  // https://github.com/catamphetamine/libphonenumber-js/issues/316

                  if (this.fixMissingPlus(state)) {
                    this.extractCallingCodeAndNationalSignificantNumber(state);
                    return true;
                  }
                },
              },
              {
                key: 'extractIddPrefix',
                value: function extractIddPrefix(state) {
                  // An IDD prefix can't be present in a number written with a `+`.
                  // Also, don't re-extract an IDD prefix if has already been extracted.
                  var international = state.international,
                    IDDPrefix = state.IDDPrefix,
                    digits = state.digits,
                    nationalSignificantNumber = state.nationalSignificantNumber;

                  if (international || IDDPrefix) {
                    return;
                  } // Some users input their phone number in "out-of-country"
                  // dialing format instead of using the leading `+`.
                  // https://github.com/catamphetamine/libphonenumber-js/issues/185
                  // Detect such numbers.

                  var numberWithoutIDD = stripIddPrefix(
                    digits,
                    this.defaultCountry,
                    this.defaultCallingCode,
                    this.metadata.metadata
                  );

                  if (
                    numberWithoutIDD !== undefined &&
                    numberWithoutIDD !== digits
                  ) {
                    // If an IDD prefix was stripped then convert the IDD-prefixed number
                    // to international number for subsequent parsing.
                    state.update({
                      IDDPrefix: digits.slice(
                        0,
                        digits.length - numberWithoutIDD.length
                      ),
                    });
                    this.startInternationalNumber(state, {
                      country: undefined,
                      callingCode: undefined,
                    });
                    return true;
                  }
                },
              },
              {
                key: 'fixMissingPlus',
                value: function fixMissingPlus(state) {
                  if (!state.international) {
                    var _extractCountryCallin2 =
                        extractCountryCallingCodeFromInternationalNumberWithoutPlusSign(
                          state.digits,
                          this.defaultCountry,
                          this.defaultCallingCode,
                          this.metadata.metadata
                        ),
                      newCallingCode =
                        _extractCountryCallin2.countryCallingCode,
                      number = _extractCountryCallin2.number;

                    if (newCallingCode) {
                      state.update({
                        missingPlus: true,
                      });
                      this.startInternationalNumber(state, {
                        country: state.country,
                        callingCode: newCallingCode,
                      });
                      return true;
                    }
                  }
                },
              },
              {
                key: 'startInternationalNumber',
                value: function startInternationalNumber(state, _ref3) {
                  var country = _ref3.country,
                    callingCode = _ref3.callingCode;
                  state.startInternationalNumber(country, callingCode); // If a national (significant) number has been extracted before, reset it.

                  if (state.nationalSignificantNumber) {
                    state.resetNationalSignificantNumber();
                    this.onNationalSignificantNumberChange();
                    this.hasExtractedNationalSignificantNumber = undefined;
                  }
                },
              },
              {
                key: 'extractCallingCodeAndNationalSignificantNumber',
                value: function extractCallingCodeAndNationalSignificantNumber(
                  state
                ) {
                  if (this.extractCountryCallingCode(state)) {
                    // `this.extractCallingCode()` is currently called when the number
                    // couldn't be formatted during the standard procedure.
                    // Normally, the national prefix would be re-extracted
                    // for an international number if such number couldn't be formatted,
                    // but since it's already not able to be formatted,
                    // there won't be yet another retry, so also extract national prefix here.
                    this.extractNationalSignificantNumber(
                      state.getNationalDigits(),
                      function (stateUpdate) {
                        return state.update(stateUpdate);
                      }
                    );
                  }
                },
              },
            ]);

            return AsYouTypeParser;
          })();
          /**
           * Extracts formatted phone number from text (if there's any).
           * @param  {string} text
           * @return {string} [formattedPhoneNumber]
           */

          function AsYouTypeParser_extractFormattedPhoneNumber(text) {
            // Attempt to extract a possible number from the string passed in.
            var startsAt = text.search(VALID_FORMATTED_PHONE_NUMBER_PART);

            if (startsAt < 0) {
              return;
            } // Trim everything to the left of the phone number.

            text = text.slice(startsAt); // Trim the `+`.

            var hasPlus;

            if (text[0] === '+') {
              hasPlus = true;
              text = text.slice('+'.length);
            } // Trim everything to the right of the phone number.

            text = text.replace(AFTER_PHONE_NUMBER_DIGITS_END_PATTERN, ''); // Re-add the previously trimmed `+`.

            if (hasPlus) {
              text = '+' + text;
            }

            return text;
          }
          /**
           * Extracts formatted phone number digits (and a `+`) from text (if there're any).
           * @param  {string} text
           * @return {any[]}
           */

          function _extractFormattedDigitsAndPlus(text) {
            // Extract a formatted phone number part from text.
            var extractedNumber =
              AsYouTypeParser_extractFormattedPhoneNumber(text) || ''; // Trim a `+`.

            if (extractedNumber[0] === '+') {
              return [extractedNumber.slice('+'.length), true];
            }

            return [extractedNumber];
          }
          /**
           * Extracts formatted phone number digits (and a `+`) from text (if there're any).
           * @param  {string} text
           * @return {any[]}
           */

          function extractFormattedDigitsAndPlus(text) {
            var _extractFormattedDigi3 = _extractFormattedDigitsAndPlus(text),
              _extractFormattedDigi4 = AsYouTypeParser_slicedToArray(
                _extractFormattedDigi3,
                2
              ),
              formattedDigits = _extractFormattedDigi4[0],
              hasPlus = _extractFormattedDigi4[1]; // If the extracted phone number part
            // can possibly be a part of some valid phone number
            // then parse phone number characters from a formatted phone number.

            if (
              !VALID_FORMATTED_PHONE_NUMBER_DIGITS_PART_PATTERN.test(
                formattedDigits
              )
            ) {
              formattedDigits = '';
            }

            return [formattedDigits, hasPlus];
          }
          //# sourceMappingURL=AsYouTypeParser.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/es6/AsYouType.js
          function AsYouType_typeof(obj) {
            '@babel/helpers - typeof';
            return (
              (AsYouType_typeof =
                'function' == typeof Symbol &&
                'symbol' == typeof Symbol.iterator
                  ? function (obj) {
                      return typeof obj;
                    }
                  : function (obj) {
                      return obj &&
                        'function' == typeof Symbol &&
                        obj.constructor === Symbol &&
                        obj !== Symbol.prototype
                        ? 'symbol'
                        : typeof obj;
                    }),
              AsYouType_typeof(obj)
            );
          }

          function AsYouType_slicedToArray(arr, i) {
            return (
              AsYouType_arrayWithHoles(arr) ||
              AsYouType_iterableToArrayLimit(arr, i) ||
              AsYouType_unsupportedIterableToArray(arr, i) ||
              AsYouType_nonIterableRest()
            );
          }

          function AsYouType_nonIterableRest() {
            throw new TypeError(
              'Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }

          function AsYouType_unsupportedIterableToArray(o, minLen) {
            if (!o) return;
            if (typeof o === 'string')
              return AsYouType_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return Array.from(o);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return AsYouType_arrayLikeToArray(o, minLen);
          }

          function AsYouType_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;
            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }
            return arr2;
          }

          function AsYouType_iterableToArrayLimit(arr, i) {
            var _i =
              arr == null
                ? null
                : (typeof Symbol !== 'undefined' && arr[Symbol.iterator]) ||
                  arr['@@iterator'];
            if (_i == null) return;
            var _arr = [];
            var _n = true;
            var _d = false;
            var _s, _e;
            try {
              for (
                _i = _i.call(arr);
                !(_n = (_s = _i.next()).done);
                _n = true
              ) {
                _arr.push(_s.value);
                if (i && _arr.length === i) break;
              }
            } catch (err) {
              _d = true;
              _e = err;
            } finally {
              try {
                if (!_n && _i['return'] != null) _i['return']();
              } finally {
                if (_d) throw _e;
              }
            }
            return _arr;
          }

          function AsYouType_arrayWithHoles(arr) {
            if (Array.isArray(arr)) return arr;
          }

          function AsYouType_classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
              throw new TypeError('Cannot call a class as a function');
            }
          }

          function AsYouType_defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
              var descriptor = props[i];
              descriptor.enumerable = descriptor.enumerable || false;
              descriptor.configurable = true;
              if ('value' in descriptor) descriptor.writable = true;
              Object.defineProperty(target, descriptor.key, descriptor);
            }
          }

          function AsYouType_createClass(Constructor, protoProps, staticProps) {
            if (protoProps)
              AsYouType_defineProperties(Constructor.prototype, protoProps);
            if (staticProps)
              AsYouType_defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, 'prototype', {
              writable: false,
            });
            return Constructor;
          }

          var AsYouType_USE_NON_GEOGRAPHIC_COUNTRY_CODE = false;

          var AsYouType_AsYouType = /*#__PURE__*/ (function () {
            /**
             * @param {(string|object)?} [optionsOrDefaultCountry] - The default country used for parsing non-international phone numbers. Can also be an `options` object.
             * @param {Object} metadata
             */
            function AsYouType(optionsOrDefaultCountry, metadata) {
              AsYouType_classCallCheck(this, AsYouType);

              this.metadata = new Metadata(metadata);

              var _this$getCountryAndCa = this.getCountryAndCallingCode(
                  optionsOrDefaultCountry
                ),
                _this$getCountryAndCa2 = AsYouType_slicedToArray(
                  _this$getCountryAndCa,
                  2
                ),
                defaultCountry = _this$getCountryAndCa2[0],
                defaultCallingCode = _this$getCountryAndCa2[1];

              this.defaultCountry = defaultCountry;
              this.defaultCallingCode = defaultCallingCode;
              this.reset();
            }

            AsYouType_createClass(AsYouType, [
              {
                key: 'getCountryAndCallingCode',
                value: function getCountryAndCallingCode(
                  optionsOrDefaultCountry
                ) {
                  // Set `defaultCountry` and `defaultCallingCode` options.
                  var defaultCountry;
                  var defaultCallingCode; // Turns out `null` also has type "object". Weird.

                  if (optionsOrDefaultCountry) {
                    if (
                      AsYouType_typeof(optionsOrDefaultCountry) === 'object'
                    ) {
                      defaultCountry = optionsOrDefaultCountry.defaultCountry;
                      defaultCallingCode =
                        optionsOrDefaultCountry.defaultCallingCode;
                    } else {
                      defaultCountry = optionsOrDefaultCountry;
                    }
                  }

                  if (
                    defaultCountry &&
                    !this.metadata.hasCountry(defaultCountry)
                  ) {
                    defaultCountry = undefined;
                  }

                  if (defaultCallingCode) {
                    /* istanbul ignore if */
                    if (AsYouType_USE_NON_GEOGRAPHIC_COUNTRY_CODE) {
                      if (
                        this.metadata.isNonGeographicCallingCode(
                          defaultCallingCode
                        )
                      ) {
                        defaultCountry = '001';
                      }
                    }
                  }

                  return [defaultCountry, defaultCallingCode];
                },
                /**
                 * Inputs "next" phone number characters.
                 * @param  {string} text
                 * @return {string} Formatted phone number characters that have been input so far.
                 */
              },
              {
                key: 'input',
                value: function input(text) {
                  var _this$parser$input = this.parser.input(text, this.state),
                    digits = _this$parser$input.digits,
                    justLeadingPlus = _this$parser$input.justLeadingPlus;

                  if (justLeadingPlus) {
                    this.formattedOutput = '+';
                  } else if (digits) {
                    this.determineTheCountryIfNeeded(); // Match the available formats by the currently available leading digits.

                    if (this.state.nationalSignificantNumber) {
                      this.formatter.narrowDownMatchingFormats(this.state);
                    }

                    var formattedNationalNumber;

                    if (this.metadata.hasSelectedNumberingPlan()) {
                      formattedNationalNumber = this.formatter.format(
                        digits,
                        this.state
                      );
                    }

                    if (formattedNationalNumber === undefined) {
                      // See if another national (significant) number could be re-extracted.
                      if (
                        this.parser.reExtractNationalSignificantNumber(
                          this.state
                        )
                      ) {
                        this.determineTheCountryIfNeeded(); // If it could, then re-try formatting the new national (significant) number.

                        var nationalDigits = this.state.getNationalDigits();

                        if (nationalDigits) {
                          formattedNationalNumber = this.formatter.format(
                            nationalDigits,
                            this.state
                          );
                        }
                      }
                    }

                    this.formattedOutput = formattedNationalNumber
                      ? this.getFullNumber(formattedNationalNumber)
                      : this.getNonFormattedNumber();
                  }

                  return this.formattedOutput;
                },
              },
              {
                key: 'reset',
                value: function reset() {
                  var _this = this;

                  this.state = new AsYouTypeState({
                    onCountryChange: function onCountryChange(country) {
                      // Before version `1.6.0`, the official `AsYouType` formatter API
                      // included the `.country` property of an `AsYouType` instance.
                      // Since that property (along with the others) have been moved to
                      // `this.state`, `this.country` property is emulated for compatibility
                      // with the old versions.
                      _this.country = country;
                    },
                    onCallingCodeChange: function onCallingCodeChange(
                      callingCode,
                      country
                    ) {
                      _this.metadata.selectNumberingPlan(country, callingCode);

                      _this.formatter.reset(
                        _this.metadata.numberingPlan,
                        _this.state
                      );

                      _this.parser.reset(_this.metadata.numberingPlan);
                    },
                  });
                  this.formatter = new AsYouTypeFormatter_AsYouTypeFormatter({
                    state: this.state,
                    metadata: this.metadata,
                  });
                  this.parser = new AsYouTypeParser_AsYouTypeParser({
                    defaultCountry: this.defaultCountry,
                    defaultCallingCode: this.defaultCallingCode,
                    metadata: this.metadata,
                    state: this.state,
                    onNationalSignificantNumberChange:
                      function onNationalSignificantNumberChange() {
                        _this.determineTheCountryIfNeeded();

                        _this.formatter.reset(
                          _this.metadata.numberingPlan,
                          _this.state
                        );
                      },
                  });
                  this.state.reset(
                    this.defaultCountry,
                    this.defaultCallingCode
                  );
                  this.formattedOutput = '';
                  return this;
                },
                /**
                 * Returns `true` if the phone number is being input in international format.
                 * In other words, returns `true` if and only if the parsed phone number starts with a `"+"`.
                 * @return {boolean}
                 */
              },
              {
                key: 'isInternational',
                value: function isInternational() {
                  return this.state.international;
                },
                /**
                 * Returns the "calling code" part of the phone number when it's being input
                 * in an international format.
                 * If no valid calling code has been entered so far, returns `undefined`.
                 * @return {string} [callingCode]
                 */
              },
              {
                key: 'getCallingCode',
                value: function getCallingCode() {
                  // If the number is being input in national format and some "default calling code"
                  // has been passed to `AsYouType` constructor, then `this.state.callingCode`
                  // is equal to that "default calling code".
                  //
                  // If the number is being input in national format and no "default calling code"
                  // has been passed to `AsYouType` constructor, then returns `undefined`,
                  // even if a "default country" has been passed to `AsYouType` constructor.
                  //
                  if (this.isInternational()) {
                    return this.state.callingCode;
                  }
                }, // A legacy alias.
              },
              {
                key: 'getCountryCallingCode',
                value: function getCountryCallingCode() {
                  return this.getCallingCode();
                },
                /**
                 * Returns a two-letter country code of the phone number.
                 * Returns `undefined` for "non-geographic" phone numbering plans.
                 * Returns `undefined` if no phone number has been input yet.
                 * @return {string} [country]
                 */
              },
              {
                key: 'getCountry',
                value: function getCountry() {
                  var digits = this.state.digits; // Return `undefined` if no digits have been input yet.

                  if (digits) {
                    return this._getCountry();
                  }
                },
                /**
                 * Returns a two-letter country code of the phone number.
                 * Returns `undefined` for "non-geographic" phone numbering plans.
                 * @return {string} [country]
                 */
              },
              {
                key: '_getCountry',
                value: function _getCountry() {
                  var country = this.state.country;
                  /* istanbul ignore if */

                  if (AsYouType_USE_NON_GEOGRAPHIC_COUNTRY_CODE) {
                    // `AsYouType.getCountry()` returns `undefined`
                    // for "non-geographic" phone numbering plans.
                    if (country === '001') {
                      return;
                    }
                  }

                  return country;
                },
              },
              {
                key: 'determineTheCountryIfNeeded',
                value: function determineTheCountryIfNeeded() {
                  // Suppose a user enters a phone number in international format,
                  // and there're several countries corresponding to that country calling code,
                  // and a country has been derived from the number, and then
                  // a user enters one more digit and the number is no longer
                  // valid for the derived country, so the country should be re-derived
                  // on every new digit in those cases.
                  //
                  // If the phone number is being input in national format,
                  // then it could be a case when `defaultCountry` wasn't specified
                  // when creating `AsYouType` instance, and just `defaultCallingCode` was specified,
                  // and that "calling code" could correspond to a "non-geographic entity",
                  // or there could be several countries corresponding to that country calling code.
                  // In those cases, `this.country` is `undefined` and should be derived
                  // from the number. Again, if country calling code is ambiguous, then
                  // `this.country` should be re-derived with each new digit.
                  //
                  if (
                    !this.state.country ||
                    this.isCountryCallingCodeAmbiguous()
                  ) {
                    this.determineTheCountry();
                  }
                }, // Prepends `+CountryCode ` in case of an international phone number
              },
              {
                key: 'getFullNumber',
                value: function getFullNumber(formattedNationalNumber) {
                  var _this2 = this;

                  if (this.isInternational()) {
                    var prefix = function prefix(text) {
                      return (
                        _this2.formatter.getInternationalPrefixBeforeCountryCallingCode(
                          _this2.state,
                          {
                            spacing: text ? true : false,
                          }
                        ) + text
                      );
                    };

                    var callingCode = this.state.callingCode;

                    if (!callingCode) {
                      return prefix(
                        ''.concat(
                          this.state.getDigitsWithoutInternationalPrefix()
                        )
                      );
                    }

                    if (!formattedNationalNumber) {
                      return prefix(callingCode);
                    }

                    return prefix(
                      ''
                        .concat(callingCode, ' ')
                        .concat(formattedNationalNumber)
                    );
                  }

                  return formattedNationalNumber;
                },
              },
              {
                key: 'getNonFormattedNationalNumberWithPrefix',
                value: function getNonFormattedNationalNumberWithPrefix() {
                  var _this$state = this.state,
                    nationalSignificantNumber =
                      _this$state.nationalSignificantNumber,
                    complexPrefixBeforeNationalSignificantNumber =
                      _this$state.complexPrefixBeforeNationalSignificantNumber,
                    nationalPrefix = _this$state.nationalPrefix;
                  var number = nationalSignificantNumber;
                  var prefix =
                    complexPrefixBeforeNationalSignificantNumber ||
                    nationalPrefix;

                  if (prefix) {
                    number = prefix + number;
                  }

                  return number;
                },
              },
              {
                key: 'getNonFormattedNumber',
                value: function getNonFormattedNumber() {
                  var nationalSignificantNumberMatchesInput =
                    this.state.nationalSignificantNumberMatchesInput;
                  return this.getFullNumber(
                    nationalSignificantNumberMatchesInput
                      ? this.getNonFormattedNationalNumberWithPrefix()
                      : this.state.getNationalDigits()
                  );
                },
              },
              {
                key: 'getNonFormattedTemplate',
                value: function getNonFormattedTemplate() {
                  var number = this.getNonFormattedNumber();

                  if (number) {
                    return number.replace(/[\+\d]/g, DIGIT_PLACEHOLDER);
                  }
                },
              },
              {
                key: 'isCountryCallingCodeAmbiguous',
                value: function isCountryCallingCodeAmbiguous() {
                  var callingCode = this.state.callingCode;
                  var countryCodes =
                    this.metadata.getCountryCodesForCallingCode(callingCode);
                  return countryCodes && countryCodes.length > 1;
                }, // Determines the country of the phone number
                // entered so far based on the country phone code
                // and the national phone number.
              },
              {
                key: 'determineTheCountry',
                value: function determineTheCountry() {
                  this.state.setCountry(
                    getCountryByCallingCode(
                      this.isInternational()
                        ? this.state.callingCode
                        : this.defaultCallingCode,
                      this.state.nationalSignificantNumber,
                      this.metadata
                    )
                  );
                },
                /**
                 * Returns a E.164 phone number value for the user's input.
                 *
                 * For example, for country `"US"` and input `"(222) 333-4444"`
                 * it will return `"+12223334444"`.
                 *
                 * For international phone number input, it will also auto-correct
                 * some minor errors such as using a national prefix when writing
                 * an international phone number. For example, if the user inputs
                 * `"+44 0 7400 000000"` then it will return an auto-corrected
                 * `"+447400000000"` phone number value.
                 *
                 * Will return `undefined` if no digits have been input,
                 * or when inputting a phone number in national format and no
                 * default country or default "country calling code" have been set.
                 *
                 * @return {string} [value]
                 */
              },
              {
                key: 'getNumberValue',
                value: function getNumberValue() {
                  var _this$state2 = this.state,
                    digits = _this$state2.digits,
                    callingCode = _this$state2.callingCode,
                    country = _this$state2.country,
                    nationalSignificantNumber =
                      _this$state2.nationalSignificantNumber; // Will return `undefined` if no digits have been input.

                  if (!digits) {
                    return;
                  }

                  if (this.isInternational()) {
                    if (callingCode) {
                      return '+' + callingCode + nationalSignificantNumber;
                    } else {
                      return '+' + digits;
                    }
                  } else {
                    if (country || callingCode) {
                      var callingCode_ = country
                        ? this.metadata.countryCallingCode()
                        : callingCode;
                      return '+' + callingCode_ + nationalSignificantNumber;
                    }
                  }
                },
                /**
                 * Returns an instance of `PhoneNumber` class.
                 * Will return `undefined` if no national (significant) number
                 * digits have been entered so far, or if no `defaultCountry` has been
                 * set and the user enters a phone number not in international format.
                 */
              },
              {
                key: 'getNumber',
                value: function getNumber() {
                  var _this$state3 = this.state,
                    nationalSignificantNumber =
                      _this$state3.nationalSignificantNumber,
                    carrierCode = _this$state3.carrierCode,
                    callingCode = _this$state3.callingCode; // `this._getCountry()` is basically same as `this.state.country`
                  // with the only change that it return `undefined` in case of a
                  // "non-geographic" numbering plan instead of `"001"` "internal use" value.

                  var country = this._getCountry();

                  if (!nationalSignificantNumber) {
                    return;
                  }

                  if (!country && !callingCode) {
                    return;
                  }

                  var phoneNumber = new PhoneNumber_PhoneNumber(
                    country || callingCode,
                    nationalSignificantNumber,
                    this.metadata.metadata
                  );

                  if (carrierCode) {
                    phoneNumber.carrierCode = carrierCode;
                  } // Phone number extensions are not supported by "As You Type" formatter.

                  return phoneNumber;
                },
                /**
                 * Returns `true` if the phone number is "possible".
                 * Is just a shortcut for `PhoneNumber.isPossible()`.
                 * @return {boolean}
                 */
              },
              {
                key: 'isPossible',
                value: function isPossible() {
                  var phoneNumber = this.getNumber();

                  if (!phoneNumber) {
                    return false;
                  }

                  return phoneNumber.isPossible();
                },
                /**
                 * Returns `true` if the phone number is "valid".
                 * Is just a shortcut for `PhoneNumber.isValid()`.
                 * @return {boolean}
                 */
              },
              {
                key: 'isValid',
                value: function isValid() {
                  var phoneNumber = this.getNumber();

                  if (!phoneNumber) {
                    return false;
                  }

                  return phoneNumber.isValid();
                },
                /**
                 * @deprecated
                 * This method is used in `react-phone-number-input/source/input-control.js`
                 * in versions before `3.0.16`.
                 */
              },
              {
                key: 'getNationalNumber',
                value: function getNationalNumber() {
                  return this.state.nationalSignificantNumber;
                },
                /**
                 * Returns the phone number characters entered by the user.
                 * @return {string}
                 */
              },
              {
                key: 'getChars',
                value: function getChars() {
                  return (
                    (this.state.international ? '+' : '') + this.state.digits
                  );
                },
                /**
                 * Returns the template for the formatted phone number.
                 * @return {string}
                 */
              },
              {
                key: 'getTemplate',
                value: function getTemplate() {
                  return (
                    this.formatter.getTemplate(this.state) ||
                    this.getNonFormattedTemplate() ||
                    ''
                  );
                },
              },
            ]);

            return AsYouType;
          })();

          //# sourceMappingURL=AsYouType.js.map
          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/min/exports/AsYouType.js
          // Importing from a ".js" file is a workaround for Node.js "ES Modules"
          // importing system which is even uncapable of importing "*.json" files.

          function exports_AsYouType_AsYouType(country) {
            return AsYouType_AsYouType.call(this, country, metadata_min_json);
          }

          exports_AsYouType_AsYouType.prototype = Object.create(
            AsYouType_AsYouType.prototype,
            {}
          );
          exports_AsYouType_AsYouType.prototype.constructor =
            exports_AsYouType_AsYouType;
          // CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js?{"cacheDirectory":"node_modules/.cache/vue-loader","cacheIdentifier":"23eda527-vue-loader-template"}!./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader/lib??vue-loader-options!./src/VuePhoneNumberInput/InputTel/index.vue?vue&type=template&id=e59be3b4&scoped=true&
          var InputTelvue_type_template_id_e59be3b4_scoped_true_render =
            function () {
              var _vm = this;
              var _h = _vm.$createElement;
              var _c = _vm._self._c || _h;
              return _c(
                'div',
                {
                  ref: 'parent',
                  staticClass: 'input-tel',
                  class: [
                    {
                      'is-focused': _vm.isFocus,
                      'is-valid': _vm.valid,
                      'has-value': _vm.value,
                      'has-error': _vm.error,
                      'is-disabled': _vm.disabled,
                      'is-dark': _vm.dark,
                      'has-hint': _vm.hint,
                    },
                    _vm.size,
                  ],
                  on: {
                    click: _vm.focusInput,
                    mouseenter: function ($event) {
                      return _vm.updateHoverState(true);
                    },
                    mouseleave: function ($event) {
                      return _vm.updateHoverState(false);
                    },
                  },
                },
                [
                  _vm.type === 'checkbox'
                    ? _c(
                        'input',
                        _vm._b(
                          {
                            directives: [
                              {
                                name: 'model',
                                rawName: 'v-model',
                                value: _vm.inputValue,
                                expression: 'inputValue',
                              },
                            ],
                            ref: 'InputTel',
                            staticClass: 'input-tel__input',
                            class: {
                              'no-country-selector': _vm.noCountrySelector,
                            },
                            style: [
                              _vm.noCountrySelector
                                ? _vm.radiusStyle
                                : _vm.radiusRightStyle,
                              _vm.inputCaretStyle,
                              _vm.inputBorderStyle,
                              _vm.inputBoxShadowStyle,
                              _vm.inputBgColor,
                              _vm.textColor,
                            ],
                            attrs: {
                              id: _vm.id,
                              placeholder: _vm.labelValue,
                              disabled: _vm.disabled,
                              required: _vm.required,
                              type: 'checkbox',
                            },
                            domProps: {
                              checked: Array.isArray(_vm.inputValue)
                                ? _vm._i(_vm.inputValue, null) > -1
                                : _vm.inputValue,
                            },
                            on: {
                              keydown: _vm.keyDown,
                              keyup: _vm.keyUp,
                              focus: _vm.onFocus,
                              blur: _vm.onBlur,
                              click: function ($event) {
                                return _vm.$emit('click', $event);
                              },
                              change: function ($event) {
                                var $$a = _vm.inputValue,
                                  $$el = $event.target,
                                  $$c = $$el.checked ? true : false;
                                if (Array.isArray($$a)) {
                                  var $$v = null,
                                    $$i = _vm._i($$a, $$v);
                                  if ($$el.checked) {
                                    $$i < 0 &&
                                      (_vm.inputValue = $$a.concat([$$v]));
                                  } else {
                                    $$i > -1 &&
                                      (_vm.inputValue = $$a
                                        .slice(0, $$i)
                                        .concat($$a.slice($$i + 1)));
                                  }
                                } else {
                                  _vm.inputValue = $$c;
                                }
                              },
                            },
                          },
                          'input',
                          _vm.$attrs,
                          false
                        )
                      )
                    : _vm.type === 'radio'
                      ? _c(
                          'input',
                          _vm._b(
                            {
                              directives: [
                                {
                                  name: 'model',
                                  rawName: 'v-model',
                                  value: _vm.inputValue,
                                  expression: 'inputValue',
                                },
                              ],
                              ref: 'InputTel',
                              staticClass: 'input-tel__input',
                              class: {
                                'no-country-selector': _vm.noCountrySelector,
                              },
                              style: [
                                _vm.noCountrySelector
                                  ? _vm.radiusStyle
                                  : _vm.radiusRightStyle,
                                _vm.inputCaretStyle,
                                _vm.inputBorderStyle,
                                _vm.inputBoxShadowStyle,
                                _vm.inputBgColor,
                                _vm.textColor,
                              ],
                              attrs: {
                                id: _vm.id,
                                placeholder: _vm.labelValue,
                                disabled: _vm.disabled,
                                required: _vm.required,
                                type: 'radio',
                              },
                              domProps: {
                                checked: _vm._q(_vm.inputValue, null),
                              },
                              on: {
                                keydown: _vm.keyDown,
                                keyup: _vm.keyUp,
                                focus: _vm.onFocus,
                                blur: _vm.onBlur,
                                click: function ($event) {
                                  return _vm.$emit('click', $event);
                                },
                                change: function ($event) {
                                  _vm.inputValue = null;
                                },
                              },
                            },
                            'input',
                            _vm.$attrs,
                            false
                          )
                        )
                      : _c(
                          'input',
                          _vm._b(
                            {
                              directives: [
                                {
                                  name: 'model',
                                  rawName: 'v-model',
                                  value: _vm.inputValue,
                                  expression: 'inputValue',
                                },
                              ],
                              ref: 'InputTel',
                              staticClass: 'input-tel__input',
                              class: {
                                'no-country-selector': _vm.noCountrySelector,
                              },
                              style: [
                                _vm.noCountrySelector
                                  ? _vm.radiusStyle
                                  : _vm.radiusRightStyle,
                                _vm.inputCaretStyle,
                                _vm.inputBorderStyle,
                                _vm.inputBoxShadowStyle,
                                _vm.inputBgColor,
                                _vm.textColor,
                              ],
                              attrs: {
                                id: _vm.id,
                                placeholder: _vm.labelValue,
                                disabled: _vm.disabled,
                                required: _vm.required,
                                type: _vm.type,
                              },
                              domProps: { value: _vm.inputValue },
                              on: {
                                keydown: _vm.keyDown,
                                keyup: _vm.keyUp,
                                focus: _vm.onFocus,
                                blur: _vm.onBlur,
                                click: function ($event) {
                                  return _vm.$emit('click', $event);
                                },
                                input: function ($event) {
                                  if ($event.target.composing) {
                                    return;
                                  }
                                  _vm.inputValue = $event.target.value;
                                },
                              },
                            },
                            'input',
                            _vm.$attrs,
                            false
                          )
                        ),
                  _c(
                    'label',
                    {
                      ref: 'label',
                      staticClass: 'input-tel__label',
                      class: _vm.error ? 'text-danger' : null,
                      style: [_vm.labelColorStyle],
                      attrs: { for: _vm.id },
                      on: { click: _vm.focusInput },
                    },
                    [
                      _vm._v(
                        ' ' + _vm._s(_vm.hintValue || _vm.labelValue) + ' '
                      ),
                    ]
                  ),
                  _vm.clearable && _vm.inputValue
                    ? _c(
                        'button',
                        {
                          staticClass: 'input-tel__clear',
                          attrs: {
                            title: 'clear',
                            type: 'button',
                            tabindex: '-1',
                          },
                          on: { click: _vm.clear },
                        },
                        [
                          _c('span', {
                            staticClass: 'input-tel__clear__effect',
                          }),
                          _c('span', [_vm._v(' ✕ ')]),
                        ]
                      )
                    : _vm._e(),
                  _vm.loader
                    ? _c('div', { staticClass: 'input-tel__loader' }, [
                        _c('div', {
                          staticClass: 'input-tel__loader__progress-bar',
                          style: [_vm.loaderBgColor],
                        }),
                      ])
                    : _vm._e(),
                ]
              );
            };
          var InputTelvue_type_template_id_e59be3b4_scoped_true_staticRenderFns =
            [];

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/InputTel/index.vue?vue&type=template&id=e59be3b4&scoped=true&

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/mixins/StylesHandler.js
          /* harmony default export */ var StylesHandler = {
            props: {
              theme: {
                type: Object,
                required: true,
              },
            },
            computed: {
              labelColorStyle: function labelColorStyle() {
                if (this.error) return this.theme.errorColor;
                else if (this.valid) return this.theme.validColor;
                else if (this.isFocus) return this.theme.color;
                else if (this.dark) return this.theme.textDarkColor;
                return null;
              },
              inputBorderStyle: function inputBorderStyle() {
                if (this.error) return this.theme.borderErrorColor;
                else if (this.valid) return this.theme.borderValidColor;
                else if (this.isHover || this.isFocus)
                  return this.theme.borderColor;
                return null;
              },
              inputBoxShadowStyle: function inputBoxShadowStyle() {
                if (this.isFocus) {
                  if (this.error) return this.theme.boxShadowError;
                  else if (this.valid) return this.theme.boxShadowValid;
                  return this.theme.boxShadowColor;
                }

                return null;
              },
              inputBgColor: function inputBgColor() {
                return !this.dark ? null : this.theme.bgDarkColor;
              },
              textColor: function textColor() {
                return this.dark ? this.theme.textDarkColor : null;
              },
              inputCaretStyle: function inputCaretStyle() {
                return {
                  caretColor: this.theme.colorValue,
                };
              },
              radiusStyle: function radiusStyle() {
                return this.theme.borderRadius;
              },
              radiusLeftStyle: function radiusLeftStyle() {
                return this.theme.borderLeftRadius;
              },
              radiusRightStyle: function radiusRightStyle() {
                return this.theme.borderRightRadius;
              },
              bgItemSelectedStyle: function bgItemSelectedStyle() {
                return this.theme.bgColor;
              },
              loaderBgColor: function loaderBgColor() {
                return this.theme.bgColor;
              },
            },
          };
          // CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader/lib??vue-loader-options!./src/VuePhoneNumberInput/InputTel/index.vue?vue&type=script&lang=js&

          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //

          /* harmony default export */ var InputTelvue_type_script_lang_js_ = {
            name: 'InputTel',
            mixins: [StylesHandler],
            props: {
              value: {
                type: [String, Number],
                default: null,
              },
              label: {
                type: String,
                default: 'Enter text',
              },
              hint: {
                type: String,
                default: null,
              },
              error: {
                type: Boolean,
                default: Boolean,
              },
              disabled: {
                type: Boolean,
                default: false,
              },
              dark: {
                type: Boolean,
                default: false,
              },
              id: {
                type: String,
                default: 'InputTel',
              },
              size: {
                type: String,
                default: null,
              },
              type: {
                type: String,
                default: 'tel',
              },
              readonly: {
                type: Boolean,
                default: false,
              },
              valid: {
                type: Boolean,
                default: false,
              },
              required: {
                type: Boolean,
                default: false,
              },
              loader: {
                type: Boolean,
                default: false,
              },
              clearable: {
                type: Boolean,
                default: false,
              },
              noCountrySelector: {
                type: Boolean,
                default: false,
              },
            },
            data: function data() {
              return {
                isFocus: false,
                isHover: false,
              };
            },
            computed: {
              inputValue: {
                get: function get() {
                  return this.value;
                },
                set: function set(value) {
                  this.$emit('input', value);
                },
              },
              labelValue: function labelValue() {
                var label = this.label;
                return this.required && label ? ''.concat(label, ' *') : label;
              },
              hintValue: function hintValue() {
                var hint = this.hint;
                return this.required && hint ? ''.concat(hint, ' *') : hint;
              },
            },
            methods: {
              updateHoverState: function updateHoverState(value) {
                this.isHover = value;
              },
              focusInput: function focusInput() {
                this.$refs.InputTel.focus();
              },
              onFocus: function onFocus() {
                this.$emit('focus');
                this.isFocus = true;
              },
              onBlur: function onBlur() {
                this.$emit('blur');
                this.isFocus = false;
              },
              clear: function clear() {
                this.$emit('input', null);
                this.$emit('clear');
              },
              keyUp: function keyUp(e) {
                this.$emit('keyup', e);
              },
              keyDown: function keyDown(e) {
                this.$emit('keydown', e);
              },
            },
          };
          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/InputTel/index.vue?vue&type=script&lang=js&
          /* harmony default export */ var VuePhoneNumberInput_InputTelvue_type_script_lang_js_ =
            InputTelvue_type_script_lang_js_;
          // EXTERNAL MODULE: ./src/VuePhoneNumberInput/InputTel/index.vue?vue&type=style&index=0&id=e59be3b4&prod&lang=scss&scoped=true&
          var InputTelvue_type_style_index_0_id_e59be3b4_prod_lang_scss_scoped_true_ =
            __webpack_require__('d499');

          // CONCATENATED MODULE: ./node_modules/vue-loader/lib/runtime/componentNormalizer.js
          /* globals __VUE_SSR_CONTEXT__ */

          // IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
          // This module is a runtime utility for cleaner component module output and will
          // be included in the final webpack user bundle.

          function normalizeComponent(
            scriptExports,
            render,
            staticRenderFns,
            functionalTemplate,
            injectStyles,
            scopeId,
            moduleIdentifier /* server only */,
            shadowMode /* vue-cli only */
          ) {
            // Vue.extend constructor export interop
            var options =
              typeof scriptExports === 'function'
                ? scriptExports.options
                : scriptExports;

            // render functions
            if (render) {
              options.render = render;
              options.staticRenderFns = staticRenderFns;
              options._compiled = true;
            }

            // functional template
            if (functionalTemplate) {
              options.functional = true;
            }

            // scopedId
            if (scopeId) {
              options._scopeId = 'data-v-' + scopeId;
            }

            var hook;
            if (moduleIdentifier) {
              // server build
              hook = function (context) {
                // 2.3 injection
                context =
                  context || // cached call
                  (this.$vnode && this.$vnode.ssrContext) || // stateful
                  (this.parent &&
                    this.parent.$vnode &&
                    this.parent.$vnode.ssrContext); // functional
                // 2.2 with runInNewContext: true
                if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
                  context = __VUE_SSR_CONTEXT__;
                }
                // inject component styles
                if (injectStyles) {
                  injectStyles.call(this, context);
                }
                // register component module identifier for async chunk inferrence
                if (context && context._registeredComponents) {
                  context._registeredComponents.add(moduleIdentifier);
                }
              };
              // used by ssr in case component is cached and beforeCreate
              // never gets called
              options._ssrRegister = hook;
            } else if (injectStyles) {
              hook = shadowMode
                ? function () {
                    injectStyles.call(
                      this,
                      (options.functional ? this.parent : this).$root.$options
                        .shadowRoot
                    );
                  }
                : injectStyles;
            }

            if (hook) {
              if (options.functional) {
                // for template-only hot-reload because in that case the render fn doesn't
                // go through the normalizer
                options._injectStyles = hook;
                // register for functional component in vue file
                var originalRender = options.render;
                options.render = function renderWithStyleInjection(h, context) {
                  hook.call(context);
                  return originalRender(h, context);
                };
              } else {
                // inject component registration as beforeCreate hook
                var existing = options.beforeCreate;
                options.beforeCreate = existing
                  ? [].concat(existing, hook)
                  : [hook];
              }
            }

            return {
              exports: scriptExports,
              options: options,
            };
          }

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/InputTel/index.vue

          /* normalize component */

          var component = normalizeComponent(
            VuePhoneNumberInput_InputTelvue_type_script_lang_js_,
            InputTelvue_type_template_id_e59be3b4_scoped_true_render,
            InputTelvue_type_template_id_e59be3b4_scoped_true_staticRenderFns,
            false,
            null,
            'e59be3b4',
            null
          );

          /* harmony default export */ var InputTel = component.exports;
          // CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js?{"cacheDirectory":"node_modules/.cache/vue-loader","cacheIdentifier":"23eda527-vue-loader-template"}!./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader/lib??vue-loader-options!./src/VuePhoneNumberInput/CountrySelector/index.vue?vue&type=template&id=46e105de&scoped=true&
          var CountrySelectorvue_type_template_id_46e105de_scoped_true_render =
            function () {
              var _vm = this;
              var _h = _vm.$createElement;
              var _c = _vm._self._c || _h;
              return _c(
                'div',
                {
                  ref: 'parent',
                  staticClass: 'country-selector',
                  class: [
                    {
                      'is-focused': _vm.isFocus,
                      'has-value': _vm.value,
                      'has-hint': _vm.hint,
                      'has-error': _vm.error,
                      'is-disabled': _vm.disabled,
                      'is-dark': _vm.dark,
                      'no-flags': _vm.noFlags,
                      'has-list-open': _vm.hasListOpen,
                      'is-valid': _vm.valid,
                    },
                    _vm.size,
                  ],
                  on: {
                    '!blur': function ($event) {
                      return _vm.handleBlur.apply(null, arguments);
                    },
                    mouseenter: function ($event) {
                      return _vm.updateHoverState(true);
                    },
                    mouseleave: function ($event) {
                      return _vm.updateHoverState(false);
                    },
                  },
                },
                [
                  _vm.value && !_vm.noFlags
                    ? _c(
                        'div',
                        {
                          staticClass: 'country-selector__country-flag',
                          on: {
                            click: function ($event) {
                              $event.stopPropagation();
                              return _vm.toggleList.apply(null, arguments);
                            },
                          },
                        },
                        [
                          _c('div', {
                            class:
                              'iti-flag-small iti-flag ' +
                              _vm.value.toLowerCase(),
                          }),
                        ]
                      )
                    : _vm._e(),
                  _c('input', {
                    ref: 'CountrySelector',
                    staticClass: 'country-selector__input',
                    style: [
                      _vm.radiusLeftStyle,
                      _vm.inputBorderStyle,
                      _vm.inputBoxShadowStyle,
                      _vm.inputBgColor,
                    ],
                    attrs: {
                      id: _vm.id,
                      placeholder: _vm.label,
                      disabled: _vm.disabled,
                      readonly: '',
                    },
                    domProps: { value: _vm.callingCode },
                    on: {
                      focus: function ($event) {
                        _vm.isFocus = true;
                      },
                      keydown: _vm.keyboardNav,
                      click: function ($event) {
                        $event.stopPropagation();
                        return _vm.toggleList.apply(null, arguments);
                      },
                    },
                  }),
                  _c(
                    'div',
                    {
                      staticClass: 'country-selector__toggle',
                      on: {
                        click: function ($event) {
                          $event.stopPropagation();
                          return _vm.toggleList.apply(null, arguments);
                        },
                      },
                    },
                    [
                      _vm._t('arrow', function () {
                        return [
                          _c(
                            'svg',
                            {
                              staticClass: 'country-selector__toggle__arrow',
                              attrs: {
                                mlns: 'http://www.w3.org/2000/svg',
                                width: '24',
                                height: '24',
                                viewBox: '0 0 24 24',
                              },
                            },
                            [
                              _c('path', {
                                staticClass: 'arrow',
                                attrs: {
                                  d: 'M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z',
                                },
                              }),
                              _c('path', {
                                attrs: { fill: 'none', d: 'M0 0h24v24H0V0z' },
                              }),
                            ]
                          ),
                        ];
                      }),
                    ],
                    2
                  ),
                  _c(
                    'label',
                    {
                      ref: 'label',
                      staticClass: 'country-selector__label',
                      style: [_vm.labelColorStyle],
                      on: {
                        click: function ($event) {
                          $event.stopPropagation();
                          return _vm.toggleList.apply(null, arguments);
                        },
                      },
                    },
                    [_vm._v(' ' + _vm._s(_vm.hint || _vm.label) + ' ')]
                  ),
                  _c('Transition', { attrs: { name: 'slide' } }, [
                    _c(
                      'div',
                      {
                        directives: [
                          {
                            name: 'show',
                            rawName: 'v-show',
                            value: _vm.hasListOpen,
                            expression: 'hasListOpen',
                          },
                        ],
                        ref: 'countriesList',
                        staticClass: 'country-selector__list',
                        class: { 'has-calling-code': _vm.showCodeOnList },
                        style: [
                          _vm.radiusStyle,
                          _vm.listHeight,
                          _vm.inputBgColor,
                        ],
                      },
                      [
                        _c('RecycleScroller', {
                          attrs: {
                            items: _vm.countriesSorted,
                            'item-size': 1,
                            'key-field': 'iso2',
                          },
                          scopedSlots: _vm._u([
                            {
                              key: 'default',
                              fn: function (ref) {
                                var item = ref.item;
                                return [
                                  _c(
                                    'button',
                                    {
                                      key: 'item-' + item.code,
                                      staticClass:
                                        'flex align-center country-selector__list__item',
                                      class: [
                                        { selected: _vm.value === item.iso2 },
                                        {
                                          'keyboard-selected':
                                            _vm.value !== item.iso2 &&
                                            _vm.tmpValue === item.iso2,
                                        },
                                      ],
                                      style: [
                                        _vm.itemHeight,
                                        _vm.value === item.iso2
                                          ? _vm.bgItemSelectedStyle
                                          : null,
                                      ],
                                      attrs: { tabindex: '-1', type: 'button' },
                                      on: {
                                        click: function ($event) {
                                          $event.stopPropagation();
                                          return _vm.updateValue(item.iso2);
                                        },
                                      },
                                    },
                                    [
                                      !_vm.noFlags
                                        ? _c(
                                            'div',
                                            {
                                              staticClass:
                                                'country-selector__list__item__flag-container',
                                            },
                                            [
                                              _c('div', {
                                                class:
                                                  'iti-flag-small iti-flag ' +
                                                  item.iso2.toLowerCase(),
                                              }),
                                            ]
                                          )
                                        : _vm._e(),
                                      _vm.showCodeOnList
                                        ? _c(
                                            'span',
                                            {
                                              staticClass:
                                                'country-selector__list__item__calling-code flex-fixed',
                                            },
                                            [
                                              _vm._v(
                                                '+' + _vm._s(item.dialCode)
                                              ),
                                            ]
                                          )
                                        : _vm._e(),
                                      _c('div', { staticClass: 'dots-text' }, [
                                        _vm._v(' ' + _vm._s(item.name) + ' '),
                                      ]),
                                    ]
                                  ),
                                ];
                              },
                            },
                          ]),
                        }),
                      ],
                      1
                    ),
                  ]),
                ],
                1
              );
            };
          var CountrySelectorvue_type_template_id_46e105de_scoped_true_staticRenderFns =
            [];

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/CountrySelector/index.vue?vue&type=template&id=46e105de&scoped=true&

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.function.name.js
          var es6_function_name = __webpack_require__('7f7f');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.string.starts-with.js
          var es6_string_starts_with = __webpack_require__('f559');

          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.array.find-index.js
          var es6_array_find_index = __webpack_require__('20d6');

          // EXTERNAL MODULE: ./node_modules/@babel/runtime-corejs2/core-js/array/is-array.js
          var is_array = __webpack_require__('a745');
          var is_array_default = /*#__PURE__*/ __webpack_require__.n(is_array);

          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/arrayLikeToArray.js
          function arrayLikeToArray_arrayLikeToArray(arr, len) {
            if (len == null || len > arr.length) len = arr.length;

            for (var i = 0, arr2 = new Array(len); i < len; i++) {
              arr2[i] = arr[i];
            }

            return arr2;
          }
          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/arrayWithoutHoles.js

          function _arrayWithoutHoles(arr) {
            if (is_array_default()(arr))
              return arrayLikeToArray_arrayLikeToArray(arr);
          }
          // EXTERNAL MODULE: ./node_modules/@babel/runtime-corejs2/core-js/array/from.js
          var from = __webpack_require__('774e');
          var from_default = /*#__PURE__*/ __webpack_require__.n(from);

          // EXTERNAL MODULE: ./node_modules/@babel/runtime-corejs2/core-js/is-iterable.js
          var is_iterable = __webpack_require__('c8bb');
          var is_iterable_default =
            /*#__PURE__*/ __webpack_require__.n(is_iterable);

          // EXTERNAL MODULE: ./node_modules/@babel/runtime-corejs2/core-js/symbol.js
          var symbol = __webpack_require__('67bb');
          var symbol_default = /*#__PURE__*/ __webpack_require__.n(symbol);

          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/iterableToArray.js

          function _iterableToArray(iter) {
            if (
              typeof symbol_default.a !== 'undefined' &&
              is_iterable_default()(Object(iter))
            )
              return from_default()(iter);
          }
          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/unsupportedIterableToArray.js

          function unsupportedIterableToArray_unsupportedIterableToArray(
            o,
            minLen
          ) {
            if (!o) return;
            if (typeof o === 'string')
              return arrayLikeToArray_arrayLikeToArray(o, minLen);
            var n = Object.prototype.toString.call(o).slice(8, -1);
            if (n === 'Object' && o.constructor) n = o.constructor.name;
            if (n === 'Map' || n === 'Set') return from_default()(n);
            if (
              n === 'Arguments' ||
              /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
            )
              return arrayLikeToArray_arrayLikeToArray(o, minLen);
          }
          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/nonIterableSpread.js
          function _nonIterableSpread() {
            throw new TypeError(
              'Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.'
            );
          }
          // CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/toConsumableArray.js

          function _toConsumableArray(arr) {
            return (
              _arrayWithoutHoles(arr) ||
              _iterableToArray(arr) ||
              unsupportedIterableToArray_unsupportedIterableToArray(arr) ||
              _nonIterableSpread()
            );
          }
          // EXTERNAL MODULE: ./node_modules/core-js/modules/es6.array.find.js
          var es6_array_find = __webpack_require__('7514');

          // CONCATENATED MODULE: ./node_modules/libphonenumber-js/min/exports/getCountryCallingCode.js

          function getCountryCallingCode_getCountryCallingCode() {
            return withMetadataArgument(getCountryCallingCode, arguments);
          }
          // EXTERNAL MODULE: ./node_modules/vue-virtual-scroller/dist/vue-virtual-scroller.esm.js
          var vue_virtual_scroller_esm = __webpack_require__('e508');

          // CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader/lib??vue-loader-options!./src/VuePhoneNumberInput/CountrySelector/index.vue?vue&type=script&lang=js&

          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //

          /* harmony default export */ var CountrySelectorvue_type_script_lang_js_ =
            {
              name: 'CountrySelector',
              components: {
                RecycleScroller:
                  vue_virtual_scroller_esm['a' /* RecycleScroller */],
              },
              mixins: [StylesHandler],
              props: {
                id: {
                  type: String,
                  default: 'CountrySelector',
                },
                value: {
                  type: [String, Object],
                  default: null,
                },
                label: {
                  type: String,
                  default: 'Choose country',
                },
                hint: {
                  type: String,
                  default: String,
                },
                size: {
                  type: String,
                  default: String,
                },
                error: {
                  type: Boolean,
                  default: false,
                },
                disabled: {
                  type: Boolean,
                  default: false,
                },
                valid: {
                  type: Boolean,
                  default: false,
                },
                dark: {
                  type: Boolean,
                  default: false,
                },
                items: {
                  type: Array,
                  default: Array,
                  required: true,
                },
                preferredCountries: {
                  type: Array,
                  default: null,
                },
                onlyCountries: {
                  type: Array,
                  default: null,
                },
                ignoredCountries: {
                  type: Array,
                  default: null,
                },
                noFlags: {
                  type: Boolean,
                  default: false,
                },
                countriesHeight: {
                  type: Number,
                  default: 35,
                },
                showCodeOnList: {
                  type: Boolean,
                  default: false,
                },
              },
              data: function data() {
                return {
                  isFocus: false,
                  hasListOpen: false,
                  selectedIndex: null,
                  tmpValue: this.value,
                  query: '',
                  indexItemToShow: 0,
                  isHover: false,
                };
              },
              computed: {
                itemHeight: function itemHeight() {
                  return {
                    height: ''.concat(this.countriesHeight, 'px'),
                  };
                },
                listHeight: function listHeight() {
                  return {
                    height: ''.concat((this.countriesHeight + 1) * 7, 'px'),
                    maxHeight: ''.concat((this.countriesHeight + 1) * 7, 'px'),
                  };
                },
                countriesList: function countriesList() {
                  var _this = this;

                  return this.items.filter(function (item) {
                    return !_this.ignoredCountries.includes(item.iso2);
                  });
                },
                countriesFiltered: function countriesFiltered() {
                  var _this2 = this;

                  var countries = this.onlyCountries || this.preferredCountries;
                  return countries.map(function (country) {
                    return _this2.countriesList.find(function (item) {
                      return item.iso2.includes(country);
                    });
                  });
                },
                otherCountries: function otherCountries() {
                  var _this3 = this;

                  return this.countriesList.filter(function (item) {
                    return !_this3.preferredCountries.includes(item.iso2);
                  });
                },
                countriesSorted: function countriesSorted() {
                  return this.preferredCountries
                    ? [].concat(
                        _toConsumableArray(this.countriesFiltered),
                        _toConsumableArray(this.otherCountries)
                      )
                    : this.onlyCountries
                      ? this.countriesFiltered
                      : this.countriesList;
                },
                selectedValueIndex: function selectedValueIndex() {
                  var _this4 = this;

                  return this.value
                    ? this.countriesSorted.findIndex(function (c) {
                        return c.iso2 === _this4.value;
                      })
                    : null;
                },
                tmpValueIndex: function tmpValueIndex() {
                  var _this5 = this;

                  return this.countriesSorted.findIndex(function (c) {
                    return c.iso2 === _this5.tmpValue;
                  });
                },
                callingCode: function callingCode() {
                  return this.value
                    ? '+'.concat(
                        getCountryCallingCode_getCountryCallingCode(this.value)
                      )
                    : null;
                },
              },
              methods: {
                updateHoverState: function updateHoverState(value) {
                  this.isHover = value;
                },
                handleBlur: function handleBlur(e) {
                  if (this.$el.contains(e.relatedTarget)) return;
                  this.isFocus = false;
                  this.closeList();
                },
                toggleList: function toggleList() {
                  this.$refs.countriesList.offsetParent
                    ? this.closeList()
                    : this.openList();
                },
                openList: function openList() {
                  if (!this.disabled) {
                    this.$refs.CountrySelector.focus();
                    this.$emit('open');
                    this.isFocus = true;
                    this.hasListOpen = true;
                    if (this.value)
                      this.scrollToSelectedOnFocus(this.selectedValueIndex);
                  }
                },
                closeList: function closeList() {
                  this.$emit('close');
                  this.hasListOpen = false;
                },
                updateValue: (function () {
                  var _updateValue = _asyncToGenerator(
                    /*#__PURE__*/ regeneratorRuntime.mark(
                      function _callee(val) {
                        return regeneratorRuntime.wrap(
                          function _callee$(_context) {
                            while (1) {
                              switch ((_context.prev = _context.next)) {
                                case 0:
                                  this.tmpValue = val;
                                  this.$emit('input', val || null);
                                  _context.next = 4;
                                  return this.$nextTick();

                                case 4:
                                  this.closeList();

                                case 5:
                                case 'end':
                                  return _context.stop();
                              }
                            }
                          },
                          _callee,
                          this
                        );
                      }
                    )
                  );

                  function updateValue(_x) {
                    return _updateValue.apply(this, arguments);
                  }

                  return updateValue;
                })(),
                scrollToSelectedOnFocus: function scrollToSelectedOnFocus(
                  arrayIndex
                ) {
                  var _this6 = this;

                  this.$nextTick(function () {
                    // this.indexItemToShow = arrayIndex - 3
                    _this6.$refs.countriesList.scrollTop =
                      arrayIndex * (_this6.countriesHeight + 1) -
                      (_this6.countriesHeight + 1) * 3;
                  });
                },
                keyboardNav: function keyboardNav(e) {
                  var code = e.keyCode;

                  if (code === 40 || code === 38) {
                    // arrow up down
                    if (e.view && e.view.event) {
                      // TODO : It's not compatible with FireFox
                      e.view.event.preventDefault();
                    }

                    if (!this.hasListOpen) this.openList();
                    var index =
                      code === 40
                        ? this.tmpValueIndex + 1
                        : this.tmpValueIndex - 1;

                    if (index === -1 || index >= this.countriesSorted.length) {
                      index =
                        index === -1 ? this.countriesSorted.length - 1 : 0;
                    }

                    this.tmpValue = this.countriesSorted[index].iso2;
                    this.scrollToSelectedOnFocus(index);
                  } else if (code === 13) {
                    // enter
                    this.hasListOpen
                      ? this.updateValue(this.tmpValue)
                      : this.openList();
                  } else if (code === 27) {
                    // escape
                    this.closeList();
                  } else {
                    // typing a country's name
                    this.searching(e);
                  }
                },
                searching: function searching(e) {
                  var _this7 = this;

                  var code = e.keyCode;
                  clearTimeout(this.queryTimer);
                  this.queryTimer = setTimeout(function () {
                    _this7.query = '';
                  }, 1000);
                  var q = String.fromCharCode(code);

                  if (code === 8 && this.query !== '') {
                    this.query = this.query.substring(0, this.query.length - 1);
                  } else if (/[a-zA-Z-e ]/.test(q)) {
                    if (!this.hasListOpen) this.openList();
                    this.query += e.key;
                    var countries = this.preferredCountries
                      ? this.countriesSorted.slice(
                          this.preferredCountries.length
                        )
                      : this.countriesSorted;
                    var resultIndex = countries.findIndex(function (c) {
                      _this7.tmpValue = c.iso2;
                      return c.name.toLowerCase().startsWith(_this7.query);
                    });

                    if (resultIndex !== -1) {
                      this.scrollToSelectedOnFocus(
                        resultIndex +
                          (this.preferredCountries
                            ? this.preferredCountries.length
                            : 0)
                      );
                    }
                  }
                },
              },
            };
          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/CountrySelector/index.vue?vue&type=script&lang=js&
          /* harmony default export */ var VuePhoneNumberInput_CountrySelectorvue_type_script_lang_js_ =
            CountrySelectorvue_type_script_lang_js_;
          // EXTERNAL MODULE: ./src/VuePhoneNumberInput/CountrySelector/index.vue?vue&type=style&index=0&id=46e105de&prod&lang=scss&scoped=true&
          var CountrySelectorvue_type_style_index_0_id_46e105de_prod_lang_scss_scoped_true_ =
            __webpack_require__('e71e');

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/CountrySelector/index.vue

          /* normalize component */

          var CountrySelector_component = normalizeComponent(
            VuePhoneNumberInput_CountrySelectorvue_type_script_lang_js_,
            CountrySelectorvue_type_template_id_46e105de_scoped_true_render,
            CountrySelectorvue_type_template_id_46e105de_scoped_true_staticRenderFns,
            false,
            null,
            '46e105de',
            null
          );

          /* harmony default export */ var CountrySelector =
            CountrySelector_component.exports;
          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/assets/locales/index.js
          /* harmony default export */ var locales = {
            countrySelectorLabel: 'Country code',
            countrySelectorError: 'Choose country',
            phoneNumberLabel: 'Phone number',
            example: 'Example:',
          };
          // EXTERNAL MODULE: ./node_modules/color-transformer-ui/lib/app.js
          var app = __webpack_require__('6038');

          // CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader/lib??vue-loader-options!./src/VuePhoneNumberInput/index.vue?vue&type=script&lang=js&

          function VuePhoneNumberInputvue_type_script_lang_js_ownKeys(
            object,
            enumerableOnly
          ) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
              var symbols = Object.getOwnPropertySymbols(object);
              enumerableOnly &&
                (symbols = symbols.filter(function (sym) {
                  return Object.getOwnPropertyDescriptor(object, sym)
                    .enumerable;
                })),
                keys.push.apply(keys, symbols);
            }
            return keys;
          }

          function VuePhoneNumberInputvue_type_script_lang_js_objectSpread(
            target
          ) {
            for (var i = 1; i < arguments.length; i++) {
              var source = null != arguments[i] ? arguments[i] : {};
              i % 2
                ? VuePhoneNumberInputvue_type_script_lang_js_ownKeys(
                    Object(source),
                    !0
                  ).forEach(function (key) {
                    _defineProperty(target, key, source[key]);
                  })
                : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(
                      target,
                      Object.getOwnPropertyDescriptors(source)
                    )
                  : VuePhoneNumberInputvue_type_script_lang_js_ownKeys(
                      Object(source)
                    ).forEach(function (key) {
                      Object.defineProperty(
                        target,
                        key,
                        Object.getOwnPropertyDescriptor(source, key)
                      );
                    });
            }
            return target;
          }

          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //
          //

          var VuePhoneNumberInputvue_type_script_lang_js_getShadowColor =
            function getShadowColor(color) {
              return Object(app['isColorName'])(color)
                ? Object(app['hexToRgba'])(
                    Object(app['colorNameToHex'])(color),
                    0.7
                  )
                : Object(app['hexToRgba'])(color, 0.7);
            };

          var browserLocale = function browserLocale() {
            if (!window) return null;
            var browserLocale =
              window.navigator.userLanguage || window.navigator.language;
            var locale = browserLocale
              ? browserLocale.substr(3, 4).toUpperCase()
              : null;
            if (locale === '')
              locale = browserLocale.substr(0, 2).toUpperCase();
            return locale;
          };

          var VuePhoneNumberInputvue_type_script_lang_js_isCountryAvailable =
            function isCountryAvailable(locale) {
              return countriesIso.includes(locale);
            };

          /* harmony default export */ var VuePhoneNumberInputvue_type_script_lang_js_ =
            {
              name: 'VuePhoneNumberInput',
              components: {
                InputTel: InputTel,
                CountrySelector: CountrySelector,
              },
              props: {
                value: {
                  type: String,
                  default: null,
                },
                id: {
                  type: String,
                  default: 'MazPhoneNumberInput',
                },
                color: {
                  type: String,
                  default: 'dodgerblue',
                },
                validColor: {
                  type: String,
                  default: 'yellowgreen',
                },
                errorColor: {
                  type: String,
                  default: 'orangered',
                },
                darkColor: {
                  type: String,
                  default: '#424242',
                },
                disabled: {
                  type: Boolean,
                  default: false,
                },
                defaultCountryCode: {
                  type: String,
                  default: null,
                },
                size: {
                  type: String,
                  default: null,
                },
                preferredCountries: {
                  type: Array,
                  default: null,
                },
                onlyCountries: {
                  type: Array,
                  default: null,
                },
                ignoredCountries: {
                  type: Array,
                  default: Array,
                },
                translations: {
                  type: Object,
                  default: null,
                },
                noValidatorState: {
                  type: Boolean,
                  default: false,
                },
                noFlags: {
                  type: Boolean,
                  default: false,
                },
                error: {
                  type: Boolean,
                  default: false,
                },
                noExample: {
                  type: Boolean,
                  default: false,
                },
                required: {
                  type: Boolean,
                  default: false,
                },
                countriesHeight: {
                  type: Number,
                  default: 30,
                },
                noUseBrowserLocale: {
                  type: Boolean,
                  default: false,
                },
                fetchCountry: {
                  type: Boolean,
                  default: false,
                },
                noCountrySelector: {
                  type: Boolean,
                  default: false,
                },
                showCodeOnList: {
                  type: Boolean,
                  default: false,
                },
                dark: {
                  type: Boolean,
                  default: false,
                },
                borderRadius: {
                  type: Number,
                  default: 4,
                },
              },
              data: function data() {
                return {
                  results: {},
                  userLocale: this.defaultCountryCode,
                  lastKeyPressed: null,
                };
              },
              computed: {
                uniqueId: function uniqueId() {
                  return ''.concat(this.id, '-').concat(this._uid);
                },
                t: function t() {
                  return VuePhoneNumberInputvue_type_script_lang_js_objectSpread(
                    VuePhoneNumberInputvue_type_script_lang_js_objectSpread(
                      {},
                      locales
                    ),
                    this.translations
                  );
                },
                codesCountries: function codesCountries() {
                  return countries;
                },
                countryCode: {
                  get: function get() {
                    return this.userLocale || this.results.countryCode;
                  },
                  set: function set(newCountry) {
                    this.setLocale(newCountry);
                    this.$refs.PhoneNumberInput.$el
                      .querySelector('input')
                      .focus();
                  },
                },
                phoneNumber: {
                  get: function get() {
                    return this.value;
                  },
                  set: function set(newPhone) {
                    this.emitValues({
                      countryCode: this.countryCode,
                      phoneNumber: newPhone,
                    });
                  },
                },
                shouldChooseCountry: function shouldChooseCountry() {
                  return !this.countryCode && !!this.phoneNumber;
                },
                phoneFormatted: function phoneFormatted() {
                  return this.results.formatInternational;
                },
                isValid: function isValid() {
                  return this.results.isValid;
                },
                phoneNumberExample: function phoneNumberExample() {
                  var phoneNumber = this.countryCode
                    ? getExampleNumber_getExampleNumber(
                        this.countryCode,
                        examples_mobile
                      )
                    : null;
                  return phoneNumber ? phoneNumber.formatNational() : null;
                },
                hasEmptyPhone: function hasEmptyPhone() {
                  return this.phoneNumber === '' || this.phoneNumber === null;
                },
                hintValue: function hintValue() {
                  return this.noExample || !this.phoneNumberExample
                    ? null
                    : this.hasEmptyPhone || this.isValid
                      ? null
                      : ''
                          .concat(this.t.example, ' ')
                          .concat(this.phoneNumberExample);
                },
                theme: function theme() {
                  return {
                    colorValue: this.color,
                    color: {
                      color: this.color,
                    },
                    textColor: {
                      color: '#747474',
                    },
                    textDarkColor: {
                      color: 'rgba(255, 255, 255, 0.7)',
                    },
                    validColor: {
                      color: this.validColor,
                    },
                    errorColor: {
                      color: this.errorColor,
                    },
                    darkColor: {
                      color: this.darkColor,
                    },
                    bgColor: {
                      backgroundColor: this.color,
                    },
                    bgValidColor: {
                      backgroundColor: this.validColor,
                    },
                    bgErrorColor: {
                      backgroundColor: this.errorColor,
                    },
                    bgDarkColor: {
                      backgroundColor: this.darkColor,
                    },
                    borderColor: {
                      borderColor: this.color,
                    },
                    borderValidColor: {
                      borderColor: this.validColor,
                    },
                    borderErrorColor: {
                      borderColor: this.errorColor,
                    },
                    borderDarkColor: {
                      borderColor: this.darkColor,
                    },
                    boxShadowColor: {
                      boxShadow: '0 0 0 0.125rem '.concat(
                        VuePhoneNumberInputvue_type_script_lang_js_getShadowColor(
                          this.color
                        )
                      ),
                    },
                    boxShadowValid: {
                      boxShadow: '0 0 0 0.125rem '.concat(
                        VuePhoneNumberInputvue_type_script_lang_js_getShadowColor(
                          this.validColor
                        )
                      ),
                    },
                    boxShadowError: {
                      boxShadow: '0 0 0 0.125rem '.concat(
                        VuePhoneNumberInputvue_type_script_lang_js_getShadowColor(
                          this.errorColor
                        )
                      ),
                    },
                    borderRadius: {
                      borderRadius: ''.concat(this.borderRadius, 'px'),
                    },
                    borderLeftRadius: {
                      borderTopLeftRadius: ''.concat(this.borderRadius, 'px'),
                      borderBottomLeftRadius: ''.concat(
                        this.borderRadius,
                        'px'
                      ),
                    },
                    borderRightRadius: {
                      borderTopRightRadius: ''.concat(this.borderRadius, 'px'),
                      borderBottomRightRadius: ''.concat(
                        this.borderRadius,
                        'px'
                      ),
                    },
                  };
                },
              },
              watch: {
                defaultCountryCode: function defaultCountryCode(
                  newValue,
                  oldValue
                ) {
                  if (newValue === oldValue) return;
                  this.setLocale(newValue);
                },
                phoneNumber: {
                  handler: function handler(newValue, oldValue) {
                    // init component (countryCode & phoneNumber) if phone number is provide
                    if (newValue && newValue !== oldValue) {
                      var phoneNumber =
                        exports_parsePhoneNumberFromString_parsePhoneNumberFromString(
                          newValue
                        );

                      if (phoneNumber) {
                        this.emitValues({
                          phoneNumber: phoneNumber.nationalNumber,
                          countryCode: this.countryCode
                            ? this.countryCode
                            : phoneNumber.country,
                        });
                      }
                    }
                  },
                  immediate: true,
                },
              },
              mounted: (function () {
                var _mounted = _asyncToGenerator(
                  /*#__PURE__*/ regeneratorRuntime.mark(function _callee() {
                    return regeneratorRuntime.wrap(
                      function _callee$(_context) {
                        while (1) {
                          switch ((_context.prev = _context.next)) {
                            case 0:
                              _context.prev = 0;
                              if (this.phoneNumber && this.defaultCountryCode)
                                this.emitValues({
                                  countryCode: this.defaultCountryCode,
                                  phoneNumber: this.phoneNumber,
                                });

                              if (
                                !(this.defaultCountryCode && this.fetchCountry)
                              ) {
                                _context.next = 4;
                                break;
                              }

                              throw new Error(
                                'MazPhoneNumberInput: Do not use "fetch-country" and "default-country-code" options in the same time'
                              );

                            case 4:
                              if (
                                !(
                                  this.defaultCountryCode &&
                                  this.noUseBrowserLocale
                                )
                              ) {
                                _context.next = 6;
                                break;
                              }

                              throw new Error(
                                'MazPhoneNumberInput: If you use a "default-country-code", do not use "no-use-browser-locale" options'
                              );

                            case 6:
                              if (!this.defaultCountryCode) {
                                _context.next = 8;
                                break;
                              }

                              return _context.abrupt('return');

                            case 8:
                              this.fetchCountry
                                ? this.fetchCountryCode()
                                : !this.noUseBrowserLocale
                                  ? this.setLocale(browserLocale())
                                  : null;
                              _context.next = 14;
                              break;

                            case 11:
                              _context.prev = 11;
                              _context.t0 = _context['catch'](0);
                              throw new Error(_context.t0);

                            case 14:
                            case 'end':
                              return _context.stop();
                          }
                        }
                      },
                      _callee,
                      this,
                      [[0, 11]]
                    );
                  })
                );

                function mounted() {
                  return _mounted.apply(this, arguments);
                }

                return mounted;
              })(),
              methods: {
                getAsYouTypeFormat: function getAsYouTypeFormat(payload) {
                  var countryCode = payload.countryCode,
                    phoneNumber = payload.phoneNumber;
                  var asYouType = new exports_AsYouType_AsYouType(countryCode);
                  return phoneNumber ? asYouType.input(phoneNumber) : null;
                },
                getParsePhoneNumberFromString:
                  function getParsePhoneNumberFromString(_ref) {
                    var phoneNumber = _ref.phoneNumber,
                      countryCode = _ref.countryCode;
                    var parsing =
                      phoneNumber && countryCode
                        ? exports_parsePhoneNumberFromString_parsePhoneNumberFromString(
                            phoneNumber,
                            countryCode
                          )
                        : null;
                    return VuePhoneNumberInputvue_type_script_lang_js_objectSpread(
                      VuePhoneNumberInputvue_type_script_lang_js_objectSpread(
                        {
                          countryCode: countryCode,
                          isValid: false,
                        },
                        phoneNumber && phoneNumber !== ''
                          ? {
                              phoneNumber: phoneNumber,
                            }
                          : null
                      ),
                      parsing
                        ? {
                            countryCallingCode: parsing.countryCallingCode,
                            formattedNumber: parsing.number,
                            nationalNumber: parsing.nationalNumber,
                            isValid: parsing.isValid(),
                            type: parsing.getType(),
                            formatInternational: parsing.formatInternational(),
                            formatNational: parsing.formatNational(),
                            uri: parsing.getURI(),
                            e164: parsing.format('E.164'),
                          }
                        : null
                    );
                  },
                emitValues: function emitValues(payload) {
                  var _this = this;

                  var asYouType = this.getAsYouTypeFormat(payload);
                  var backSpacePressed = this.lastKeyPressed === 8;
                  this.$nextTick(function () {
                    var lastCharacOfPhoneNumber = _this.phoneNumber
                      ? _this.phoneNumber.trim().slice(-1)
                      : false;

                    if (
                      backSpacePressed &&
                      lastCharacOfPhoneNumber &&
                      lastCharacOfPhoneNumber.slice(-1) === ')'
                    ) {
                      asYouType = _this.phoneNumber.slice(0, -2);
                      payload.phoneNumber = _this.phoneNumber.slice(0, -2);
                    }

                    _this.results =
                      _this.getParsePhoneNumberFromString(payload);

                    _this.$emit('update', _this.results);

                    _this.$emit('input', asYouType);
                  });
                },
                setLocale: function setLocale(locale) {
                  var countryAvailable =
                    VuePhoneNumberInputvue_type_script_lang_js_isCountryAvailable(
                      locale
                    );

                  if (countryAvailable && locale) {
                    this.userLocale = countryAvailable ? locale : null;
                    this.emitValues({
                      countryCode: locale,
                      phoneNumber: this.phoneNumber,
                    });
                  } else if (!countryAvailable && locale) {
                    window.console.warn(
                      'The locale '.concat(locale, ' is not available')
                    );
                  }
                },
                fetchCountryCode: (function () {
                  var _fetchCountryCode = _asyncToGenerator(
                    /*#__PURE__*/ regeneratorRuntime.mark(function _callee2() {
                      var response, responseText, result;
                      return regeneratorRuntime.wrap(
                        function _callee2$(_context2) {
                          while (1) {
                            switch ((_context2.prev = _context2.next)) {
                              case 0:
                                _context2.prev = 0;
                                _context2.next = 3;
                                return fetch('https://ip2c.org/s');

                              case 3:
                                response = _context2.sent;
                                _context2.next = 6;
                                return response.text();

                              case 6:
                                responseText = _context2.sent;
                                result = (responseText || '').toString();
                                if (result && result[0] === '1')
                                  this.setLocale(result.substr(2, 2));
                                _context2.next = 14;
                                break;

                              case 11:
                                _context2.prev = 11;
                                _context2.t0 = _context2['catch'](0);
                                throw new Error(_context2.t0);

                              case 14:
                              case 'end':
                                return _context2.stop();
                            }
                          }
                        },
                        _callee2,
                        this,
                        [[0, 11]]
                      );
                    })
                  );

                  function fetchCountryCode() {
                    return _fetchCountryCode.apply(this, arguments);
                  }

                  return fetchCountryCode;
                })(),
              },
            };
          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/index.vue?vue&type=script&lang=js&
          /* harmony default export */ var src_VuePhoneNumberInputvue_type_script_lang_js_ =
            VuePhoneNumberInputvue_type_script_lang_js_;
          // EXTERNAL MODULE: ./src/VuePhoneNumberInput/index.vue?vue&type=style&index=0&id=19351537&prod&lang=scss&scoped=true&
          var VuePhoneNumberInputvue_type_style_index_0_id_19351537_prod_lang_scss_scoped_true_ =
            __webpack_require__('e214');

          // CONCATENATED MODULE: ./src/VuePhoneNumberInput/index.vue

          /* normalize component */

          var VuePhoneNumberInput_component = normalizeComponent(
            src_VuePhoneNumberInputvue_type_script_lang_js_,
            render,
            staticRenderFns,
            false,
            null,
            '19351537',
            null
          );

          /* harmony default export */ var VuePhoneNumberInput =
            VuePhoneNumberInput_component.exports;
          // CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/entry-lib.js

          /* harmony default export */ var entry_lib = (__webpack_exports__[
            'default'
          ] = VuePhoneNumberInput);

          /***/
        },

        /***/ fdef: /***/ function (module, exports) {
          module.exports =
            '\x09\x0A\x0B\x0C\x0D\x20\xA0\u1680\u180E\u2000\u2001\u2002\u2003' +
            '\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028\u2029\uFEFF';

          /***/
        },

        /******/
      }
    )['default'];
  }
);
//# sourceMappingURL=vue-phone-number-input.umd.js.map
