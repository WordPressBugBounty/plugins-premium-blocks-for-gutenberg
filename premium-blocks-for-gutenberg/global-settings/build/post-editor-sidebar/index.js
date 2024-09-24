/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "../../node_modules/bezier-easing/src/index.js":
/*!*****************************************************!*\
  !*** ../../node_modules/bezier-easing/src/index.js ***!
  \*****************************************************/
/***/ (function(module) {

/**
 * https://github.com/gre/bezier-easing
 * BezierEasing - use bezier curve for transition easing function
 * by Gaëtan Renaudeau 2014 - 2015 – MIT License
 */

// These values are established by empiricism with tests (tradeoff: performance VS precision)
var NEWTON_ITERATIONS = 4;
var NEWTON_MIN_SLOPE = 0.001;
var SUBDIVISION_PRECISION = 0.0000001;
var SUBDIVISION_MAX_ITERATIONS = 10;

var kSplineTableSize = 11;
var kSampleStepSize = 1.0 / (kSplineTableSize - 1.0);

var float32ArraySupported = typeof Float32Array === 'function';

function A (aA1, aA2) { return 1.0 - 3.0 * aA2 + 3.0 * aA1; }
function B (aA1, aA2) { return 3.0 * aA2 - 6.0 * aA1; }
function C (aA1)      { return 3.0 * aA1; }

// Returns x(t) given t, x1, and x2, or y(t) given t, y1, and y2.
function calcBezier (aT, aA1, aA2) { return ((A(aA1, aA2) * aT + B(aA1, aA2)) * aT + C(aA1)) * aT; }

// Returns dx/dt given t, x1, and x2, or dy/dt given t, y1, and y2.
function getSlope (aT, aA1, aA2) { return 3.0 * A(aA1, aA2) * aT * aT + 2.0 * B(aA1, aA2) * aT + C(aA1); }

function binarySubdivide (aX, aA, aB, mX1, mX2) {
  var currentX, currentT, i = 0;
  do {
    currentT = aA + (aB - aA) / 2.0;
    currentX = calcBezier(currentT, mX1, mX2) - aX;
    if (currentX > 0.0) {
      aB = currentT;
    } else {
      aA = currentT;
    }
  } while (Math.abs(currentX) > SUBDIVISION_PRECISION && ++i < SUBDIVISION_MAX_ITERATIONS);
  return currentT;
}

function newtonRaphsonIterate (aX, aGuessT, mX1, mX2) {
 for (var i = 0; i < NEWTON_ITERATIONS; ++i) {
   var currentSlope = getSlope(aGuessT, mX1, mX2);
   if (currentSlope === 0.0) {
     return aGuessT;
   }
   var currentX = calcBezier(aGuessT, mX1, mX2) - aX;
   aGuessT -= currentX / currentSlope;
 }
 return aGuessT;
}

function LinearEasing (x) {
  return x;
}

module.exports = function bezier (mX1, mY1, mX2, mY2) {
  if (!(0 <= mX1 && mX1 <= 1 && 0 <= mX2 && mX2 <= 1)) {
    throw new Error('bezier x values must be in [0, 1] range');
  }

  if (mX1 === mY1 && mX2 === mY2) {
    return LinearEasing;
  }

  // Precompute samples table
  var sampleValues = float32ArraySupported ? new Float32Array(kSplineTableSize) : new Array(kSplineTableSize);
  for (var i = 0; i < kSplineTableSize; ++i) {
    sampleValues[i] = calcBezier(i * kSampleStepSize, mX1, mX2);
  }

  function getTForX (aX) {
    var intervalStart = 0.0;
    var currentSample = 1;
    var lastSample = kSplineTableSize - 1;

    for (; currentSample !== lastSample && sampleValues[currentSample] <= aX; ++currentSample) {
      intervalStart += kSampleStepSize;
    }
    --currentSample;

    // Interpolate to provide an initial guess for t
    var dist = (aX - sampleValues[currentSample]) / (sampleValues[currentSample + 1] - sampleValues[currentSample]);
    var guessForT = intervalStart + dist * kSampleStepSize;

    var initialSlope = getSlope(guessForT, mX1, mX2);
    if (initialSlope >= NEWTON_MIN_SLOPE) {
      return newtonRaphsonIterate(aX, guessForT, mX1, mX2);
    } else if (initialSlope === 0.0) {
      return guessForT;
    } else {
      return binarySubdivide(aX, intervalStart, intervalStart + kSampleStepSize, mX1, mX2);
    }
  }

  return function BezierEasing (x) {
    // Because JavaScript number are imprecise, we should guarantee the extremes are right.
    if (x === 0) {
      return 0;
    }
    if (x === 1) {
      return 1;
    }
    return calcBezier(getTForX(x), mY1, mY2);
  };
};


/***/ }),

/***/ "../../node_modules/classnames/index.js":
/*!**********************************************!*\
  !*** ../../node_modules/classnames/index.js ***!
  \**********************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;
	var nativeCodeString = '[native code]';

	function classNames() {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg)) {
				if (arg.length) {
					var inner = classNames.apply(null, arg);
					if (inner) {
						classes.push(inner);
					}
				}
			} else if (argType === 'object') {
				if (arg.toString !== Object.prototype.toString && !arg.toString.toString().includes('[native code]')) {
					classes.push(arg.toString());
					continue;
				}

				for (var key in arg) {
					if (hasOwn.call(arg, key) && arg[key]) {
						classes.push(key);
					}
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "../../node_modules/domelementtype/lib/index.js":
/*!******************************************************!*\
  !*** ../../node_modules/domelementtype/lib/index.js ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.Doctype = exports.CDATA = exports.Tag = exports.Style = exports.Script = exports.Comment = exports.Directive = exports.Text = exports.Root = exports.isTag = exports.ElementType = void 0;
/** Types of elements found in htmlparser2's DOM */
var ElementType;
(function (ElementType) {
    /** Type for the root element of a document */
    ElementType["Root"] = "root";
    /** Type for Text */
    ElementType["Text"] = "text";
    /** Type for <? ... ?> */
    ElementType["Directive"] = "directive";
    /** Type for <!-- ... --> */
    ElementType["Comment"] = "comment";
    /** Type for <script> tags */
    ElementType["Script"] = "script";
    /** Type for <style> tags */
    ElementType["Style"] = "style";
    /** Type for Any tag */
    ElementType["Tag"] = "tag";
    /** Type for <![CDATA[ ... ]]> */
    ElementType["CDATA"] = "cdata";
    /** Type for <!doctype ...> */
    ElementType["Doctype"] = "doctype";
})(ElementType = exports.ElementType || (exports.ElementType = {}));
/**
 * Tests whether an element is a tag or not.
 *
 * @param elem Element to test
 */
function isTag(elem) {
    return (elem.type === ElementType.Tag ||
        elem.type === ElementType.Script ||
        elem.type === ElementType.Style);
}
exports.isTag = isTag;
// Exports for backwards compatibility
/** Type for the root element of a document */
exports.Root = ElementType.Root;
/** Type for Text */
exports.Text = ElementType.Text;
/** Type for <? ... ?> */
exports.Directive = ElementType.Directive;
/** Type for <!-- ... --> */
exports.Comment = ElementType.Comment;
/** Type for <script> tags */
exports.Script = ElementType.Script;
/** Type for <style> tags */
exports.Style = ElementType.Style;
/** Type for Any tag */
exports.Tag = ElementType.Tag;
/** Type for <![CDATA[ ... ]]> */
exports.CDATA = ElementType.CDATA;
/** Type for <!doctype ...> */
exports.Doctype = ElementType.Doctype;


/***/ }),

/***/ "../../node_modules/domhandler/lib/index.js":
/*!**************************************************!*\
  !*** ../../node_modules/domhandler/lib/index.js ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __createBinding = (this && this.__createBinding) || (Object.create ? (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    var desc = Object.getOwnPropertyDescriptor(m, k);
    if (!desc || ("get" in desc ? !m.__esModule : desc.writable || desc.configurable)) {
      desc = { enumerable: true, get: function() { return m[k]; } };
    }
    Object.defineProperty(o, k2, desc);
}) : (function(o, m, k, k2) {
    if (k2 === undefined) k2 = k;
    o[k2] = m[k];
}));
var __exportStar = (this && this.__exportStar) || function(m, exports) {
    for (var p in m) if (p !== "default" && !Object.prototype.hasOwnProperty.call(exports, p)) __createBinding(exports, m, p);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.DomHandler = void 0;
var domelementtype_1 = __webpack_require__(/*! domelementtype */ "../../node_modules/domelementtype/lib/index.js");
var node_js_1 = __webpack_require__(/*! ./node.js */ "../../node_modules/domhandler/lib/node.js");
__exportStar(__webpack_require__(/*! ./node.js */ "../../node_modules/domhandler/lib/node.js"), exports);
// Default options
var defaultOpts = {
    withStartIndices: false,
    withEndIndices: false,
    xmlMode: false,
};
var DomHandler = /** @class */ (function () {
    /**
     * @param callback Called once parsing has completed.
     * @param options Settings for the handler.
     * @param elementCB Callback whenever a tag is closed.
     */
    function DomHandler(callback, options, elementCB) {
        /** The elements of the DOM */
        this.dom = [];
        /** The root element for the DOM */
        this.root = new node_js_1.Document(this.dom);
        /** Indicated whether parsing has been completed. */
        this.done = false;
        /** Stack of open tags. */
        this.tagStack = [this.root];
        /** A data node that is still being written to. */
        this.lastNode = null;
        /** Reference to the parser instance. Used for location information. */
        this.parser = null;
        // Make it possible to skip arguments, for backwards-compatibility
        if (typeof options === "function") {
            elementCB = options;
            options = defaultOpts;
        }
        if (typeof callback === "object") {
            options = callback;
            callback = undefined;
        }
        this.callback = callback !== null && callback !== void 0 ? callback : null;
        this.options = options !== null && options !== void 0 ? options : defaultOpts;
        this.elementCB = elementCB !== null && elementCB !== void 0 ? elementCB : null;
    }
    DomHandler.prototype.onparserinit = function (parser) {
        this.parser = parser;
    };
    // Resets the handler back to starting state
    DomHandler.prototype.onreset = function () {
        this.dom = [];
        this.root = new node_js_1.Document(this.dom);
        this.done = false;
        this.tagStack = [this.root];
        this.lastNode = null;
        this.parser = null;
    };
    // Signals the handler that parsing is done
    DomHandler.prototype.onend = function () {
        if (this.done)
            return;
        this.done = true;
        this.parser = null;
        this.handleCallback(null);
    };
    DomHandler.prototype.onerror = function (error) {
        this.handleCallback(error);
    };
    DomHandler.prototype.onclosetag = function () {
        this.lastNode = null;
        var elem = this.tagStack.pop();
        if (this.options.withEndIndices) {
            elem.endIndex = this.parser.endIndex;
        }
        if (this.elementCB)
            this.elementCB(elem);
    };
    DomHandler.prototype.onopentag = function (name, attribs) {
        var type = this.options.xmlMode ? domelementtype_1.ElementType.Tag : undefined;
        var element = new node_js_1.Element(name, attribs, undefined, type);
        this.addNode(element);
        this.tagStack.push(element);
    };
    DomHandler.prototype.ontext = function (data) {
        var lastNode = this.lastNode;
        if (lastNode && lastNode.type === domelementtype_1.ElementType.Text) {
            lastNode.data += data;
            if (this.options.withEndIndices) {
                lastNode.endIndex = this.parser.endIndex;
            }
        }
        else {
            var node = new node_js_1.Text(data);
            this.addNode(node);
            this.lastNode = node;
        }
    };
    DomHandler.prototype.oncomment = function (data) {
        if (this.lastNode && this.lastNode.type === domelementtype_1.ElementType.Comment) {
            this.lastNode.data += data;
            return;
        }
        var node = new node_js_1.Comment(data);
        this.addNode(node);
        this.lastNode = node;
    };
    DomHandler.prototype.oncommentend = function () {
        this.lastNode = null;
    };
    DomHandler.prototype.oncdatastart = function () {
        var text = new node_js_1.Text("");
        var node = new node_js_1.CDATA([text]);
        this.addNode(node);
        text.parent = node;
        this.lastNode = text;
    };
    DomHandler.prototype.oncdataend = function () {
        this.lastNode = null;
    };
    DomHandler.prototype.onprocessinginstruction = function (name, data) {
        var node = new node_js_1.ProcessingInstruction(name, data);
        this.addNode(node);
    };
    DomHandler.prototype.handleCallback = function (error) {
        if (typeof this.callback === "function") {
            this.callback(error, this.dom);
        }
        else if (error) {
            throw error;
        }
    };
    DomHandler.prototype.addNode = function (node) {
        var parent = this.tagStack[this.tagStack.length - 1];
        var previousSibling = parent.children[parent.children.length - 1];
        if (this.options.withStartIndices) {
            node.startIndex = this.parser.startIndex;
        }
        if (this.options.withEndIndices) {
            node.endIndex = this.parser.endIndex;
        }
        parent.children.push(node);
        if (previousSibling) {
            node.prev = previousSibling;
            previousSibling.next = node;
        }
        node.parent = parent;
        this.lastNode = null;
    };
    return DomHandler;
}());
exports.DomHandler = DomHandler;
exports["default"] = DomHandler;


/***/ }),

/***/ "../../node_modules/domhandler/lib/node.js":
/*!*************************************************!*\
  !*** ../../node_modules/domhandler/lib/node.js ***!
  \*************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __assign = (this && this.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.cloneNode = exports.hasChildren = exports.isDocument = exports.isDirective = exports.isComment = exports.isText = exports.isCDATA = exports.isTag = exports.Element = exports.Document = exports.CDATA = exports.NodeWithChildren = exports.ProcessingInstruction = exports.Comment = exports.Text = exports.DataNode = exports.Node = void 0;
var domelementtype_1 = __webpack_require__(/*! domelementtype */ "../../node_modules/domelementtype/lib/index.js");
/**
 * This object will be used as the prototype for Nodes when creating a
 * DOM-Level-1-compliant structure.
 */
var Node = /** @class */ (function () {
    function Node() {
        /** Parent of the node */
        this.parent = null;
        /** Previous sibling */
        this.prev = null;
        /** Next sibling */
        this.next = null;
        /** The start index of the node. Requires `withStartIndices` on the handler to be `true. */
        this.startIndex = null;
        /** The end index of the node. Requires `withEndIndices` on the handler to be `true. */
        this.endIndex = null;
    }
    Object.defineProperty(Node.prototype, "parentNode", {
        // Read-write aliases for properties
        /**
         * Same as {@link parent}.
         * [DOM spec](https://dom.spec.whatwg.org)-compatible alias.
         */
        get: function () {
            return this.parent;
        },
        set: function (parent) {
            this.parent = parent;
        },
        enumerable: false,
        configurable: true
    });
    Object.defineProperty(Node.prototype, "previousSibling", {
        /**
         * Same as {@link prev}.
         * [DOM spec](https://dom.spec.whatwg.org)-compatible alias.
         */
        get: function () {
            return this.prev;
        },
        set: function (prev) {
            this.prev = prev;
        },
        enumerable: false,
        configurable: true
    });
    Object.defineProperty(Node.prototype, "nextSibling", {
        /**
         * Same as {@link next}.
         * [DOM spec](https://dom.spec.whatwg.org)-compatible alias.
         */
        get: function () {
            return this.next;
        },
        set: function (next) {
            this.next = next;
        },
        enumerable: false,
        configurable: true
    });
    /**
     * Clone this node, and optionally its children.
     *
     * @param recursive Clone child nodes as well.
     * @returns A clone of the node.
     */
    Node.prototype.cloneNode = function (recursive) {
        if (recursive === void 0) { recursive = false; }
        return cloneNode(this, recursive);
    };
    return Node;
}());
exports.Node = Node;
/**
 * A node that contains some data.
 */
var DataNode = /** @class */ (function (_super) {
    __extends(DataNode, _super);
    /**
     * @param data The content of the data node
     */
    function DataNode(data) {
        var _this = _super.call(this) || this;
        _this.data = data;
        return _this;
    }
    Object.defineProperty(DataNode.prototype, "nodeValue", {
        /**
         * Same as {@link data}.
         * [DOM spec](https://dom.spec.whatwg.org)-compatible alias.
         */
        get: function () {
            return this.data;
        },
        set: function (data) {
            this.data = data;
        },
        enumerable: false,
        configurable: true
    });
    return DataNode;
}(Node));
exports.DataNode = DataNode;
/**
 * Text within the document.
 */
var Text = /** @class */ (function (_super) {
    __extends(Text, _super);
    function Text() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.type = domelementtype_1.ElementType.Text;
        return _this;
    }
    Object.defineProperty(Text.prototype, "nodeType", {
        get: function () {
            return 3;
        },
        enumerable: false,
        configurable: true
    });
    return Text;
}(DataNode));
exports.Text = Text;
/**
 * Comments within the document.
 */
var Comment = /** @class */ (function (_super) {
    __extends(Comment, _super);
    function Comment() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.type = domelementtype_1.ElementType.Comment;
        return _this;
    }
    Object.defineProperty(Comment.prototype, "nodeType", {
        get: function () {
            return 8;
        },
        enumerable: false,
        configurable: true
    });
    return Comment;
}(DataNode));
exports.Comment = Comment;
/**
 * Processing instructions, including doc types.
 */
var ProcessingInstruction = /** @class */ (function (_super) {
    __extends(ProcessingInstruction, _super);
    function ProcessingInstruction(name, data) {
        var _this = _super.call(this, data) || this;
        _this.name = name;
        _this.type = domelementtype_1.ElementType.Directive;
        return _this;
    }
    Object.defineProperty(ProcessingInstruction.prototype, "nodeType", {
        get: function () {
            return 1;
        },
        enumerable: false,
        configurable: true
    });
    return ProcessingInstruction;
}(DataNode));
exports.ProcessingInstruction = ProcessingInstruction;
/**
 * A `Node` that can have children.
 */
var NodeWithChildren = /** @class */ (function (_super) {
    __extends(NodeWithChildren, _super);
    /**
     * @param children Children of the node. Only certain node types can have children.
     */
    function NodeWithChildren(children) {
        var _this = _super.call(this) || this;
        _this.children = children;
        return _this;
    }
    Object.defineProperty(NodeWithChildren.prototype, "firstChild", {
        // Aliases
        /** First child of the node. */
        get: function () {
            var _a;
            return (_a = this.children[0]) !== null && _a !== void 0 ? _a : null;
        },
        enumerable: false,
        configurable: true
    });
    Object.defineProperty(NodeWithChildren.prototype, "lastChild", {
        /** Last child of the node. */
        get: function () {
            return this.children.length > 0
                ? this.children[this.children.length - 1]
                : null;
        },
        enumerable: false,
        configurable: true
    });
    Object.defineProperty(NodeWithChildren.prototype, "childNodes", {
        /**
         * Same as {@link children}.
         * [DOM spec](https://dom.spec.whatwg.org)-compatible alias.
         */
        get: function () {
            return this.children;
        },
        set: function (children) {
            this.children = children;
        },
        enumerable: false,
        configurable: true
    });
    return NodeWithChildren;
}(Node));
exports.NodeWithChildren = NodeWithChildren;
var CDATA = /** @class */ (function (_super) {
    __extends(CDATA, _super);
    function CDATA() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.type = domelementtype_1.ElementType.CDATA;
        return _this;
    }
    Object.defineProperty(CDATA.prototype, "nodeType", {
        get: function () {
            return 4;
        },
        enumerable: false,
        configurable: true
    });
    return CDATA;
}(NodeWithChildren));
exports.CDATA = CDATA;
/**
 * The root node of the document.
 */
var Document = /** @class */ (function (_super) {
    __extends(Document, _super);
    function Document() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.type = domelementtype_1.ElementType.Root;
        return _this;
    }
    Object.defineProperty(Document.prototype, "nodeType", {
        get: function () {
            return 9;
        },
        enumerable: false,
        configurable: true
    });
    return Document;
}(NodeWithChildren));
exports.Document = Document;
/**
 * An element within the DOM.
 */
var Element = /** @class */ (function (_super) {
    __extends(Element, _super);
    /**
     * @param name Name of the tag, eg. `div`, `span`.
     * @param attribs Object mapping attribute names to attribute values.
     * @param children Children of the node.
     */
    function Element(name, attribs, children, type) {
        if (children === void 0) { children = []; }
        if (type === void 0) { type = name === "script"
            ? domelementtype_1.ElementType.Script
            : name === "style"
                ? domelementtype_1.ElementType.Style
                : domelementtype_1.ElementType.Tag; }
        var _this = _super.call(this, children) || this;
        _this.name = name;
        _this.attribs = attribs;
        _this.type = type;
        return _this;
    }
    Object.defineProperty(Element.prototype, "nodeType", {
        get: function () {
            return 1;
        },
        enumerable: false,
        configurable: true
    });
    Object.defineProperty(Element.prototype, "tagName", {
        // DOM Level 1 aliases
        /**
         * Same as {@link name}.
         * [DOM spec](https://dom.spec.whatwg.org)-compatible alias.
         */
        get: function () {
            return this.name;
        },
        set: function (name) {
            this.name = name;
        },
        enumerable: false,
        configurable: true
    });
    Object.defineProperty(Element.prototype, "attributes", {
        get: function () {
            var _this = this;
            return Object.keys(this.attribs).map(function (name) {
                var _a, _b;
                return ({
                    name: name,
                    value: _this.attribs[name],
                    namespace: (_a = _this["x-attribsNamespace"]) === null || _a === void 0 ? void 0 : _a[name],
                    prefix: (_b = _this["x-attribsPrefix"]) === null || _b === void 0 ? void 0 : _b[name],
                });
            });
        },
        enumerable: false,
        configurable: true
    });
    return Element;
}(NodeWithChildren));
exports.Element = Element;
/**
 * @param node Node to check.
 * @returns `true` if the node is a `Element`, `false` otherwise.
 */
function isTag(node) {
    return (0, domelementtype_1.isTag)(node);
}
exports.isTag = isTag;
/**
 * @param node Node to check.
 * @returns `true` if the node has the type `CDATA`, `false` otherwise.
 */
function isCDATA(node) {
    return node.type === domelementtype_1.ElementType.CDATA;
}
exports.isCDATA = isCDATA;
/**
 * @param node Node to check.
 * @returns `true` if the node has the type `Text`, `false` otherwise.
 */
function isText(node) {
    return node.type === domelementtype_1.ElementType.Text;
}
exports.isText = isText;
/**
 * @param node Node to check.
 * @returns `true` if the node has the type `Comment`, `false` otherwise.
 */
function isComment(node) {
    return node.type === domelementtype_1.ElementType.Comment;
}
exports.isComment = isComment;
/**
 * @param node Node to check.
 * @returns `true` if the node has the type `ProcessingInstruction`, `false` otherwise.
 */
function isDirective(node) {
    return node.type === domelementtype_1.ElementType.Directive;
}
exports.isDirective = isDirective;
/**
 * @param node Node to check.
 * @returns `true` if the node has the type `ProcessingInstruction`, `false` otherwise.
 */
function isDocument(node) {
    return node.type === domelementtype_1.ElementType.Root;
}
exports.isDocument = isDocument;
/**
 * @param node Node to check.
 * @returns `true` if the node has children, `false` otherwise.
 */
function hasChildren(node) {
    return Object.prototype.hasOwnProperty.call(node, "children");
}
exports.hasChildren = hasChildren;
/**
 * Clone a node, and optionally its children.
 *
 * @param recursive Clone child nodes as well.
 * @returns A clone of the node.
 */
function cloneNode(node, recursive) {
    if (recursive === void 0) { recursive = false; }
    var result;
    if (isText(node)) {
        result = new Text(node.data);
    }
    else if (isComment(node)) {
        result = new Comment(node.data);
    }
    else if (isTag(node)) {
        var children = recursive ? cloneChildren(node.children) : [];
        var clone_1 = new Element(node.name, __assign({}, node.attribs), children);
        children.forEach(function (child) { return (child.parent = clone_1); });
        if (node.namespace != null) {
            clone_1.namespace = node.namespace;
        }
        if (node["x-attribsNamespace"]) {
            clone_1["x-attribsNamespace"] = __assign({}, node["x-attribsNamespace"]);
        }
        if (node["x-attribsPrefix"]) {
            clone_1["x-attribsPrefix"] = __assign({}, node["x-attribsPrefix"]);
        }
        result = clone_1;
    }
    else if (isCDATA(node)) {
        var children = recursive ? cloneChildren(node.children) : [];
        var clone_2 = new CDATA(children);
        children.forEach(function (child) { return (child.parent = clone_2); });
        result = clone_2;
    }
    else if (isDocument(node)) {
        var children = recursive ? cloneChildren(node.children) : [];
        var clone_3 = new Document(children);
        children.forEach(function (child) { return (child.parent = clone_3); });
        if (node["x-mode"]) {
            clone_3["x-mode"] = node["x-mode"];
        }
        result = clone_3;
    }
    else if (isDirective(node)) {
        var instruction = new ProcessingInstruction(node.name, node.data);
        if (node["x-name"] != null) {
            instruction["x-name"] = node["x-name"];
            instruction["x-publicId"] = node["x-publicId"];
            instruction["x-systemId"] = node["x-systemId"];
        }
        result = instruction;
    }
    else {
        throw new Error("Not implemented yet: ".concat(node.type));
    }
    result.startIndex = node.startIndex;
    result.endIndex = node.endIndex;
    if (node.sourceCodeLocation != null) {
        result.sourceCodeLocation = node.sourceCodeLocation;
    }
    return result;
}
exports.cloneNode = cloneNode;
function cloneChildren(childs) {
    var children = childs.map(function (child) { return cloneNode(child, true); });
    for (var i = 1; i < children.length; i++) {
        children[i].prev = children[i - 1];
        children[i - 1].next = children[i];
    }
    return children;
}


/***/ }),

/***/ "../../node_modules/html-dom-parser/lib/client/constants.js":
/*!******************************************************************!*\
  !*** ../../node_modules/html-dom-parser/lib/client/constants.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, exports) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.CASE_SENSITIVE_TAG_NAMES_MAP = exports.CASE_SENSITIVE_TAG_NAMES = void 0;
/**
 * SVG elements are case-sensitive.
 *
 * @see https://developer.mozilla.org/docs/Web/SVG/Element#svg_elements_a_to_z
 */
exports.CASE_SENSITIVE_TAG_NAMES = [
    'animateMotion',
    'animateTransform',
    'clipPath',
    'feBlend',
    'feColorMatrix',
    'feComponentTransfer',
    'feComposite',
    'feConvolveMatrix',
    'feDiffuseLighting',
    'feDisplacementMap',
    'feDropShadow',
    'feFlood',
    'feFuncA',
    'feFuncB',
    'feFuncG',
    'feFuncR',
    'feGaussianBlur',
    'feImage',
    'feMerge',
    'feMergeNode',
    'feMorphology',
    'feOffset',
    'fePointLight',
    'feSpecularLighting',
    'feSpotLight',
    'feTile',
    'feTurbulence',
    'foreignObject',
    'linearGradient',
    'radialGradient',
    'textPath',
];
exports.CASE_SENSITIVE_TAG_NAMES_MAP = exports.CASE_SENSITIVE_TAG_NAMES.reduce(function (accumulator, tagName) {
    accumulator[tagName.toLowerCase()] = tagName;
    return accumulator;
}, {});
//# sourceMappingURL=constants.js.map

/***/ }),

/***/ "../../node_modules/html-dom-parser/lib/client/domparser.js":
/*!******************************************************************!*\
  !*** ../../node_modules/html-dom-parser/lib/client/domparser.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, exports) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
// constants
var HTML = 'html';
var HEAD = 'head';
var BODY = 'body';
var FIRST_TAG_REGEX = /<([a-zA-Z]+[0-9]?)/; // e.g., <h1>
// match-all-characters in case of newlines (DOTALL)
var HEAD_TAG_REGEX = /<head[^]*>/i;
var BODY_TAG_REGEX = /<body[^]*>/i;
// falls back to `parseFromString` if `createHTMLDocument` cannot be used
// eslint-disable-next-line @typescript-eslint/no-unused-vars
var parseFromDocument = function (html, tagName) {
    /* istanbul ignore next */
    throw new Error('This browser does not support `document.implementation.createHTMLDocument`');
};
// eslint-disable-next-line @typescript-eslint/no-unused-vars
var parseFromString = function (html, tagName) {
    /* istanbul ignore next */
    throw new Error('This browser does not support `DOMParser.prototype.parseFromString`');
};
var DOMParser = typeof window === 'object' && window.DOMParser;
/**
 * DOMParser (performance: slow).
 *
 * @see https://developer.mozilla.org/docs/Web/API/DOMParser#Parsing_an_SVG_or_HTML_document
 */
if (typeof DOMParser === 'function') {
    var domParser_1 = new DOMParser();
    var mimeType_1 = 'text/html';
    /**
     * Creates an HTML document using `DOMParser.parseFromString`.
     *
     * @param html - The HTML string.
     * @param tagName - The element to render the HTML (with 'body' as fallback).
     * @returns - Document.
     */
    parseFromString = function (html, tagName) {
        if (tagName) {
            /* istanbul ignore next */
            html = "<".concat(tagName, ">").concat(html, "</").concat(tagName, ">");
        }
        return domParser_1.parseFromString(html, mimeType_1);
    };
    parseFromDocument = parseFromString;
}
/**
 * DOMImplementation (performance: fair).
 *
 * @see https://developer.mozilla.org/docs/Web/API/DOMImplementation/createHTMLDocument
 */
if (typeof document === 'object' && document.implementation) {
    var htmlDocument_1 = document.implementation.createHTMLDocument();
    /**
     * Use HTML document created by `document.implementation.createHTMLDocument`.
     *
     * @param html - The HTML string.
     * @param tagName - The element to render the HTML (with 'body' as fallback).
     * @returns - Document
     */
    parseFromDocument = function (html, tagName) {
        if (tagName) {
            var element = htmlDocument_1.documentElement.querySelector(tagName);
            if (element) {
                element.innerHTML = html;
            }
            return htmlDocument_1;
        }
        htmlDocument_1.documentElement.innerHTML = html;
        return htmlDocument_1;
    };
}
/**
 * Template (performance: fast).
 *
 * @see https://developer.mozilla.org/docs/Web/HTML/Element/template
 */
var template = typeof document === 'object' && document.createElement('template');
// eslint-disable-next-line @typescript-eslint/no-unused-vars
var parseFromTemplate;
if (template && template.content) {
    /**
     * Uses a template element (content fragment) to parse HTML.
     *
     * @param html - HTML string.
     * @returns - Nodes.
     */
    parseFromTemplate = function (html) {
        template.innerHTML = html;
        return template.content.childNodes;
    };
}
/**
 * Parses HTML string to DOM nodes.
 *
 * @param html - HTML markup.
 * @returns - DOM nodes.
 */
function domparser(html) {
    var _a, _b;
    var match = html.match(FIRST_TAG_REGEX);
    var firstTagName = match && match[1] ? match[1].toLowerCase() : '';
    switch (firstTagName) {
        case HTML: {
            var doc = parseFromString(html);
            // the created document may come with filler head/body elements,
            // so make sure to remove them if they don't actually exist
            if (!HEAD_TAG_REGEX.test(html)) {
                var element = doc.querySelector(HEAD);
                (_a = element === null || element === void 0 ? void 0 : element.parentNode) === null || _a === void 0 ? void 0 : _a.removeChild(element);
            }
            if (!BODY_TAG_REGEX.test(html)) {
                var element = doc.querySelector(BODY);
                (_b = element === null || element === void 0 ? void 0 : element.parentNode) === null || _b === void 0 ? void 0 : _b.removeChild(element);
            }
            return doc.querySelectorAll(HTML);
        }
        case HEAD:
        case BODY: {
            var elements = parseFromDocument(html).querySelectorAll(firstTagName);
            // if there's a sibling element, then return both elements
            if (BODY_TAG_REGEX.test(html) && HEAD_TAG_REGEX.test(html)) {
                return elements[0].parentNode.childNodes;
            }
            return elements;
        }
        // low-level tag or text
        default: {
            if (parseFromTemplate) {
                return parseFromTemplate(html);
            }
            var element = parseFromDocument(html, BODY).querySelector(BODY);
            return element.childNodes;
        }
    }
}
exports["default"] = domparser;
//# sourceMappingURL=domparser.js.map

/***/ }),

/***/ "../../node_modules/html-dom-parser/lib/client/html-to-dom.js":
/*!********************************************************************!*\
  !*** ../../node_modules/html-dom-parser/lib/client/html-to-dom.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
var domparser_1 = __importDefault(__webpack_require__(/*! ./domparser */ "../../node_modules/html-dom-parser/lib/client/domparser.js"));
var utilities_1 = __webpack_require__(/*! ./utilities */ "../../node_modules/html-dom-parser/lib/client/utilities.js");
var DIRECTIVE_REGEX = /<(![a-zA-Z\s]+)>/; // e.g., <!doctype html>
/**
 * Parses HTML string to DOM nodes in browser.
 *
 * @param html - HTML markup.
 * @returns - DOM elements.
 */
function HTMLDOMParser(html) {
    if (typeof html !== 'string') {
        throw new TypeError('First argument must be a string');
    }
    if (!html) {
        return [];
    }
    // match directive
    var match = html.match(DIRECTIVE_REGEX);
    var directive = match ? match[1] : undefined;
    return (0, utilities_1.formatDOM)((0, domparser_1.default)(html), null, directive);
}
exports["default"] = HTMLDOMParser;
//# sourceMappingURL=html-to-dom.js.map

/***/ }),

/***/ "../../node_modules/html-dom-parser/lib/client/utilities.js":
/*!******************************************************************!*\
  !*** ../../node_modules/html-dom-parser/lib/client/utilities.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.formatDOM = exports.formatAttributes = void 0;
var domhandler_1 = __webpack_require__(/*! domhandler */ "../../node_modules/domhandler/lib/index.js");
var constants_1 = __webpack_require__(/*! ./constants */ "../../node_modules/html-dom-parser/lib/client/constants.js");
/**
 * Gets case-sensitive tag name.
 *
 * @param tagName - Tag name in lowercase.
 * @returns - Case-sensitive tag name.
 */
function getCaseSensitiveTagName(tagName) {
    return constants_1.CASE_SENSITIVE_TAG_NAMES_MAP[tagName];
}
/**
 * Formats DOM attributes to a hash map.
 *
 * @param attributes - List of attributes.
 * @returns - Map of attribute name to value.
 */
function formatAttributes(attributes) {
    var map = {};
    var index = 0;
    var attributesLength = attributes.length;
    // `NamedNodeMap` is array-like
    for (; index < attributesLength; index++) {
        var attribute = attributes[index];
        map[attribute.name] = attribute.value;
    }
    return map;
}
exports.formatAttributes = formatAttributes;
/**
 * Corrects the tag name if it is case-sensitive (SVG).
 * Otherwise, returns the lowercase tag name (HTML).
 *
 * @param tagName - Lowercase tag name.
 * @returns - Formatted tag name.
 */
function formatTagName(tagName) {
    tagName = tagName.toLowerCase();
    var caseSensitiveTagName = getCaseSensitiveTagName(tagName);
    if (caseSensitiveTagName) {
        return caseSensitiveTagName;
    }
    return tagName;
}
/**
 * Transforms DOM nodes to `domhandler` nodes.
 *
 * @param nodes - DOM nodes.
 * @param parent - Parent node.
 * @param directive - Directive.
 * @returns - Nodes.
 */
function formatDOM(nodes, parent, directive) {
    if (parent === void 0) { parent = null; }
    var domNodes = [];
    var current;
    var index = 0;
    var nodesLength = nodes.length;
    for (; index < nodesLength; index++) {
        var node = nodes[index];
        // set the node data given the type
        switch (node.nodeType) {
            case 1: {
                var tagName = formatTagName(node.nodeName);
                // script, style, or tag
                current = new domhandler_1.Element(tagName, formatAttributes(node.attributes));
                current.children = formatDOM(
                // template children are on content
                tagName === 'template'
                    ? node.content.childNodes
                    : node.childNodes, current);
                break;
            }
            case 3:
                current = new domhandler_1.Text(node.nodeValue);
                break;
            case 8:
                current = new domhandler_1.Comment(node.nodeValue);
                break;
            default:
                continue;
        }
        // set previous node next
        var prev = domNodes[index - 1] || null;
        if (prev) {
            prev.next = current;
        }
        // set properties for current node
        current.parent = parent;
        current.prev = prev;
        current.next = null;
        domNodes.push(current);
    }
    if (directive) {
        current = new domhandler_1.ProcessingInstruction(directive.substring(0, directive.indexOf(' ')).toLowerCase(), directive);
        current.next = domNodes[0] || null;
        current.parent = parent;
        domNodes.unshift(current);
        if (domNodes[1]) {
            domNodes[1].prev = domNodes[0];
        }
    }
    return domNodes;
}
exports.formatDOM = formatDOM;
//# sourceMappingURL=utilities.js.map

/***/ }),

/***/ "../../node_modules/html-react-parser/lib/attributes-to-props.js":
/*!***********************************************************************!*\
  !*** ../../node_modules/html-react-parser/lib/attributes-to-props.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
var react_property_1 = __webpack_require__(/*! react-property */ "../../node_modules/react-property/lib/index.js");
var utilities_1 = __webpack_require__(/*! ./utilities */ "../../node_modules/html-react-parser/lib/utilities.js");
// https://react.dev/learn/sharing-state-between-components#controlled-and-uncontrolled-components
// https://developer.mozilla.org/docs/Web/HTML/Attributes
var UNCONTROLLED_COMPONENT_ATTRIBUTES = ['checked', 'value'];
var UNCONTROLLED_COMPONENT_NAMES = ['input', 'select', 'textarea'];
var valueOnlyInputs = {
    reset: true,
    submit: true,
};
/**
 * Converts HTML/SVG DOM attributes to React props.
 *
 * @param attributes - HTML/SVG DOM attributes.
 * @param nodeName - DOM node name.
 * @returns - React props.
 */
function attributesToProps(attributes, nodeName) {
    if (attributes === void 0) { attributes = {}; }
    var props = {};
    var isInputValueOnly = Boolean(attributes.type && valueOnlyInputs[attributes.type]);
    for (var attributeName in attributes) {
        var attributeValue = attributes[attributeName];
        // ARIA (aria-*) or custom data (data-*) attribute
        if ((0, react_property_1.isCustomAttribute)(attributeName)) {
            props[attributeName] = attributeValue;
            continue;
        }
        // convert HTML/SVG attribute to React prop
        var attributeNameLowerCased = attributeName.toLowerCase();
        var propName = getPropName(attributeNameLowerCased);
        if (propName) {
            var propertyInfo = (0, react_property_1.getPropertyInfo)(propName);
            // convert attribute to uncontrolled component prop (e.g., `value` to `defaultValue`)
            if (UNCONTROLLED_COMPONENT_ATTRIBUTES.includes(propName) &&
                UNCONTROLLED_COMPONENT_NAMES.includes(nodeName) &&
                !isInputValueOnly) {
                propName = getPropName('default' + attributeNameLowerCased);
            }
            props[propName] = attributeValue;
            switch (propertyInfo && propertyInfo.type) {
                case react_property_1.BOOLEAN:
                    props[propName] = true;
                    break;
                case react_property_1.OVERLOADED_BOOLEAN:
                    if (attributeValue === '') {
                        props[propName] = true;
                    }
                    break;
            }
            continue;
        }
        // preserve custom attribute if React >=16
        if (utilities_1.PRESERVE_CUSTOM_ATTRIBUTES) {
            props[attributeName] = attributeValue;
        }
    }
    // transform inline style to object
    (0, utilities_1.setStyleProp)(attributes.style, props);
    return props;
}
exports["default"] = attributesToProps;
/**
 * Gets prop name from lowercased attribute name.
 *
 * @param attributeName - Lowercased attribute name.
 * @returns - Prop name.
 */
function getPropName(attributeName) {
    return react_property_1.possibleStandardNames[attributeName];
}
//# sourceMappingURL=attributes-to-props.js.map

/***/ }),

/***/ "../../node_modules/html-react-parser/lib/dom-to-react.js":
/*!****************************************************************!*\
  !*** ../../node_modules/html-react-parser/lib/dom-to-react.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
var react_1 = __webpack_require__(/*! react */ "react");
var attributes_to_props_1 = __importDefault(__webpack_require__(/*! ./attributes-to-props */ "../../node_modules/html-react-parser/lib/attributes-to-props.js"));
var utilities_1 = __webpack_require__(/*! ./utilities */ "../../node_modules/html-react-parser/lib/utilities.js");
var React = {
    cloneElement: react_1.cloneElement,
    createElement: react_1.createElement,
    isValidElement: react_1.isValidElement,
};
/**
 * Converts DOM nodes to JSX element(s).
 *
 * @param nodes - DOM nodes.
 * @param options - Options.
 * @returns - String or JSX element(s).
 */
function domToReact(nodes, options) {
    if (options === void 0) { options = {}; }
    var reactElements = [];
    var hasReplace = typeof options.replace === 'function';
    var transform = options.transform || utilities_1.returnFirstArg;
    var _a = options.library || React, cloneElement = _a.cloneElement, createElement = _a.createElement, isValidElement = _a.isValidElement;
    var nodesLength = nodes.length;
    for (var index = 0; index < nodesLength; index++) {
        var node = nodes[index];
        // replace with custom React element (if present)
        if (hasReplace) {
            var replaceElement = options.replace(node, index);
            if (isValidElement(replaceElement)) {
                // set "key" prop for sibling elements
                // https://react.dev/learn/rendering-lists#rules-of-keys
                if (nodesLength > 1) {
                    replaceElement = cloneElement(replaceElement, {
                        key: replaceElement.key || index,
                    });
                }
                reactElements.push(transform(replaceElement, node, index));
                continue;
            }
        }
        if (node.type === 'text') {
            var isWhitespace = !node.data.trim().length;
            // We have a whitespace node that can't be nested in its parent
            // so skip it
            if (isWhitespace &&
                node.parent &&
                !(0, utilities_1.canTextBeChildOfNode)(node.parent)) {
                continue;
            }
            // Trim is enabled and we have a whitespace node
            // so skip it
            if (options.trim && isWhitespace) {
                continue;
            }
            // We have a text node that's not whitespace and it can be nested
            // in its parent so add it to the results
            reactElements.push(transform(node.data, node, index));
            continue;
        }
        var element = node;
        var props = {};
        if (skipAttributesToProps(element)) {
            (0, utilities_1.setStyleProp)(element.attribs.style, element.attribs);
            props = element.attribs;
        }
        else if (element.attribs) {
            props = (0, attributes_to_props_1.default)(element.attribs, element.name);
        }
        var children = void 0;
        switch (node.type) {
            case 'script':
            case 'style':
                // prevent text in <script> or <style> from being escaped
                // https://react.dev/reference/react-dom/components/common#dangerously-setting-the-inner-html
                if (node.children[0]) {
                    props.dangerouslySetInnerHTML = {
                        __html: node.children[0].data,
                    };
                }
                break;
            case 'tag':
                // setting textarea value in children is an antipattern in React
                // https://react.dev/reference/react-dom/components/textarea#caveats
                if (node.name === 'textarea' && node.children[0]) {
                    props.defaultValue = node.children[0].data;
                }
                else if (node.children && node.children.length) {
                    // continue recursion of creating React elements (if applicable)
                    children = domToReact(node.children, options);
                }
                break;
            // skip all other cases (e.g., comment)
            default:
                continue;
        }
        // set "key" prop for sibling elements
        // https://react.dev/learn/rendering-lists#rules-of-keys
        if (nodesLength > 1) {
            props.key = index;
        }
        reactElements.push(transform(createElement(node.name, props, children), node, index));
    }
    return reactElements.length === 1 ? reactElements[0] : reactElements;
}
exports["default"] = domToReact;
/**
 * Determines whether DOM element attributes should be transformed to props.
 * Web Components should not have their attributes transformed except for `style`.
 *
 * @param node - Element node.
 * @returns - Whether the node attributes should be converted to props.
 */
function skipAttributesToProps(node) {
    return (utilities_1.PRESERVE_CUSTOM_ATTRIBUTES &&
        node.type === 'tag' &&
        (0, utilities_1.isCustomComponent)(node.name, node.attribs));
}
//# sourceMappingURL=dom-to-react.js.map

/***/ }),

/***/ "../../node_modules/html-react-parser/lib/index.js":
/*!*********************************************************!*\
  !*** ../../node_modules/html-react-parser/lib/index.js ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.htmlToDOM = exports.domToReact = exports.attributesToProps = exports.Text = exports.ProcessingInstruction = exports.Element = exports.Comment = void 0;
var html_dom_parser_1 = __importDefault(__webpack_require__(/*! html-dom-parser */ "../../node_modules/html-dom-parser/lib/client/html-to-dom.js"));
exports.htmlToDOM = html_dom_parser_1.default;
var attributes_to_props_1 = __importDefault(__webpack_require__(/*! ./attributes-to-props */ "../../node_modules/html-react-parser/lib/attributes-to-props.js"));
exports.attributesToProps = attributes_to_props_1.default;
var dom_to_react_1 = __importDefault(__webpack_require__(/*! ./dom-to-react */ "../../node_modules/html-react-parser/lib/dom-to-react.js"));
exports.domToReact = dom_to_react_1.default;
var domhandler_1 = __webpack_require__(/*! domhandler */ "../../node_modules/domhandler/lib/index.js");
Object.defineProperty(exports, "Comment", ({ enumerable: true, get: function () { return domhandler_1.Comment; } }));
Object.defineProperty(exports, "Element", ({ enumerable: true, get: function () { return domhandler_1.Element; } }));
Object.defineProperty(exports, "ProcessingInstruction", ({ enumerable: true, get: function () { return domhandler_1.ProcessingInstruction; } }));
Object.defineProperty(exports, "Text", ({ enumerable: true, get: function () { return domhandler_1.Text; } }));
var domParserOptions = { lowerCaseAttributeNames: false };
/**
 * Converts HTML string to React elements.
 *
 * @param html - HTML string.
 * @param options - Parser options.
 * @returns - React element(s), empty array, or string.
 */
function HTMLReactParser(html, options) {
    if (typeof html !== 'string') {
        throw new TypeError('First argument must be a string');
    }
    if (!html) {
        return [];
    }
    return (0, dom_to_react_1.default)((0, html_dom_parser_1.default)(html, (options === null || options === void 0 ? void 0 : options.htmlparser2) || domParserOptions), options);
}
exports["default"] = HTMLReactParser;
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "../../node_modules/html-react-parser/lib/utilities.js":
/*!*************************************************************!*\
  !*** ../../node_modules/html-react-parser/lib/utilities.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.returnFirstArg = exports.canTextBeChildOfNode = exports.ELEMENTS_WITH_NO_TEXT_CHILDREN = exports.PRESERVE_CUSTOM_ATTRIBUTES = exports.setStyleProp = exports.isCustomComponent = void 0;
var react_1 = __webpack_require__(/*! react */ "react");
var style_to_js_1 = __importDefault(__webpack_require__(/*! style-to-js */ "../../node_modules/style-to-js/cjs/index.js"));
var RESERVED_SVG_MATHML_ELEMENTS = new Set([
    'annotation-xml',
    'color-profile',
    'font-face',
    'font-face-src',
    'font-face-uri',
    'font-face-format',
    'font-face-name',
    'missing-glyph',
]);
/**
 * Check if a tag is a custom component.
 *
 * @see {@link https://github.com/facebook/react/blob/v16.6.3/packages/react-dom/src/shared/isCustomComponent.js}
 *
 * @param tagName - Tag name.
 * @param props - Props passed to the element.
 * @returns - Whether the tag is custom component.
 */
function isCustomComponent(tagName, props) {
    if (!tagName.includes('-')) {
        return Boolean(props && typeof props.is === 'string');
    }
    // These are reserved SVG and MathML elements.
    // We don't mind this whitelist too much because we expect it to never grow.
    // The alternative is to track the namespace in a few places which is convoluted.
    // https://w3c.github.io/webcomponents/spec/custom/#custom-elements-core-concepts
    if (RESERVED_SVG_MATHML_ELEMENTS.has(tagName)) {
        return false;
    }
    return true;
}
exports.isCustomComponent = isCustomComponent;
var styleOptions = {
    reactCompat: true,
};
/**
 * Sets style prop.
 *
 * @param style - Inline style.
 * @param props - Props object.
 */
function setStyleProp(style, props) {
    if (typeof style !== 'string') {
        return;
    }
    if (!style.trim()) {
        props.style = {};
        return;
    }
    try {
        props.style = (0, style_to_js_1.default)(style, styleOptions);
    }
    catch (error) {
        props.style = {};
    }
}
exports.setStyleProp = setStyleProp;
/**
 * @see https://reactjs.org/blog/2017/09/08/dom-attributes-in-react-16.html
 */
exports.PRESERVE_CUSTOM_ATTRIBUTES = Number(react_1.version.split('.')[0]) >= 16;
/**
 * @see https://github.com/facebook/react/blob/cae635054e17a6f107a39d328649137b83f25972/packages/react-dom/src/client/validateDOMNesting.js#L213
 */
exports.ELEMENTS_WITH_NO_TEXT_CHILDREN = new Set([
    'tr',
    'tbody',
    'thead',
    'tfoot',
    'colgroup',
    'table',
    'head',
    'html',
    'frameset',
]);
/**
 * Checks if the given node can contain text nodes
 *
 * @param node - Element node.
 * @returns - Whether the node can contain text nodes.
 */
var canTextBeChildOfNode = function (node) {
    return !exports.ELEMENTS_WITH_NO_TEXT_CHILDREN.has(node.name);
};
exports.canTextBeChildOfNode = canTextBeChildOfNode;
/**
 * Returns the first argument as is.
 *
 * @param arg - The argument to be returned.
 * @returns - The input argument `arg`.
 */
var returnFirstArg = function (arg) { return arg; };
exports.returnFirstArg = returnFirstArg;
//# sourceMappingURL=utilities.js.map

/***/ }),

/***/ "../../node_modules/inline-style-parser/index.js":
/*!*******************************************************!*\
  !*** ../../node_modules/inline-style-parser/index.js ***!
  \*******************************************************/
/***/ (function(module) {

// http://www.w3.org/TR/CSS21/grammar.html
// https://github.com/visionmedia/css-parse/pull/49#issuecomment-30088027
var COMMENT_REGEX = /\/\*[^*]*\*+([^/*][^*]*\*+)*\//g;

var NEWLINE_REGEX = /\n/g;
var WHITESPACE_REGEX = /^\s*/;

// declaration
var PROPERTY_REGEX = /^(\*?[-#/*\\\w]+(\[[0-9a-z_-]+\])?)\s*/;
var COLON_REGEX = /^:\s*/;
var VALUE_REGEX = /^((?:'(?:\\'|.)*?'|"(?:\\"|.)*?"|\([^)]*?\)|[^};])+)/;
var SEMICOLON_REGEX = /^[;\s]*/;

// https://developer.mozilla.org/docs/Web/JavaScript/Reference/Global_Objects/String/Trim#Polyfill
var TRIM_REGEX = /^\s+|\s+$/g;

// strings
var NEWLINE = '\n';
var FORWARD_SLASH = '/';
var ASTERISK = '*';
var EMPTY_STRING = '';

// types
var TYPE_COMMENT = 'comment';
var TYPE_DECLARATION = 'declaration';

/**
 * @param {String} style
 * @param {Object} [options]
 * @return {Object[]}
 * @throws {TypeError}
 * @throws {Error}
 */
module.exports = function (style, options) {
  if (typeof style !== 'string') {
    throw new TypeError('First argument must be a string');
  }

  if (!style) return [];

  options = options || {};

  /**
   * Positional.
   */
  var lineno = 1;
  var column = 1;

  /**
   * Update lineno and column based on `str`.
   *
   * @param {String} str
   */
  function updatePosition(str) {
    var lines = str.match(NEWLINE_REGEX);
    if (lines) lineno += lines.length;
    var i = str.lastIndexOf(NEWLINE);
    column = ~i ? str.length - i : column + str.length;
  }

  /**
   * Mark position and patch `node.position`.
   *
   * @return {Function}
   */
  function position() {
    var start = { line: lineno, column: column };
    return function (node) {
      node.position = new Position(start);
      whitespace();
      return node;
    };
  }

  /**
   * Store position information for a node.
   *
   * @constructor
   * @property {Object} start
   * @property {Object} end
   * @property {undefined|String} source
   */
  function Position(start) {
    this.start = start;
    this.end = { line: lineno, column: column };
    this.source = options.source;
  }

  /**
   * Non-enumerable source string.
   */
  Position.prototype.content = style;

  var errorsList = [];

  /**
   * Error `msg`.
   *
   * @param {String} msg
   * @throws {Error}
   */
  function error(msg) {
    var err = new Error(
      options.source + ':' + lineno + ':' + column + ': ' + msg
    );
    err.reason = msg;
    err.filename = options.source;
    err.line = lineno;
    err.column = column;
    err.source = style;

    if (options.silent) {
      errorsList.push(err);
    } else {
      throw err;
    }
  }

  /**
   * Match `re` and return captures.
   *
   * @param {RegExp} re
   * @return {undefined|Array}
   */
  function match(re) {
    var m = re.exec(style);
    if (!m) return;
    var str = m[0];
    updatePosition(str);
    style = style.slice(str.length);
    return m;
  }

  /**
   * Parse whitespace.
   */
  function whitespace() {
    match(WHITESPACE_REGEX);
  }

  /**
   * Parse comments.
   *
   * @param {Object[]} [rules]
   * @return {Object[]}
   */
  function comments(rules) {
    var c;
    rules = rules || [];
    while ((c = comment())) {
      if (c !== false) {
        rules.push(c);
      }
    }
    return rules;
  }

  /**
   * Parse comment.
   *
   * @return {Object}
   * @throws {Error}
   */
  function comment() {
    var pos = position();
    if (FORWARD_SLASH != style.charAt(0) || ASTERISK != style.charAt(1)) return;

    var i = 2;
    while (
      EMPTY_STRING != style.charAt(i) &&
      (ASTERISK != style.charAt(i) || FORWARD_SLASH != style.charAt(i + 1))
    ) {
      ++i;
    }
    i += 2;

    if (EMPTY_STRING === style.charAt(i - 1)) {
      return error('End of comment missing');
    }

    var str = style.slice(2, i - 2);
    column += 2;
    updatePosition(str);
    style = style.slice(i);
    column += 2;

    return pos({
      type: TYPE_COMMENT,
      comment: str
    });
  }

  /**
   * Parse declaration.
   *
   * @return {Object}
   * @throws {Error}
   */
  function declaration() {
    var pos = position();

    // prop
    var prop = match(PROPERTY_REGEX);
    if (!prop) return;
    comment();

    // :
    if (!match(COLON_REGEX)) return error("property missing ':'");

    // val
    var val = match(VALUE_REGEX);

    var ret = pos({
      type: TYPE_DECLARATION,
      property: trim(prop[0].replace(COMMENT_REGEX, EMPTY_STRING)),
      value: val
        ? trim(val[0].replace(COMMENT_REGEX, EMPTY_STRING))
        : EMPTY_STRING
    });

    // ;
    match(SEMICOLON_REGEX);

    return ret;
  }

  /**
   * Parse declarations.
   *
   * @return {Object[]}
   */
  function declarations() {
    var decls = [];

    comments(decls);

    // declarations
    var decl;
    while ((decl = declaration())) {
      if (decl !== false) {
        decls.push(decl);
        comments(decls);
      }
    }

    return decls;
  }

  whitespace();
  return declarations();
};

/**
 * Trim `str`.
 *
 * @param {String} str
 * @return {String}
 */
function trim(str) {
  return str ? str.replace(TRIM_REGEX, EMPTY_STRING) : EMPTY_STRING;
}


/***/ }),

/***/ "../../node_modules/react-property/lib/index.js":
/*!******************************************************!*\
  !*** ../../node_modules/react-property/lib/index.js ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";


/**
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 *
 * 
 */




// A reserved attribute.
// It is handled by React separately and shouldn't be written to the DOM.
const RESERVED = 0;

// A simple string attribute.
// Attributes that aren't in the filter are presumed to have this type.
const STRING = 1;

// A string attribute that accepts booleans in React. In HTML, these are called
// "enumerated" attributes with "true" and "false" as possible values.
// When true, it should be set to a "true" string.
// When false, it should be set to a "false" string.
const BOOLEANISH_STRING = 2;

// A real boolean attribute.
// When true, it should be present (set either to an empty string or its name).
// When false, it should be omitted.
const BOOLEAN = 3;

// An attribute that can be used as a flag as well as with a value.
// When true, it should be present (set either to an empty string or its name).
// When false, it should be omitted.
// For any other value, should be present with that value.
const OVERLOADED_BOOLEAN = 4;

// An attribute that must be numeric or parse as a numeric.
// When falsy, it should be removed.
const NUMERIC = 5;

// An attribute that must be positive numeric or parse as a positive numeric.
// When falsy, it should be removed.
const POSITIVE_NUMERIC = 6;

function getPropertyInfo(name) {
  return properties.hasOwnProperty(name) ? properties[name] : null;
}

function PropertyInfoRecord(
  name,
  type,
  mustUseProperty,
  attributeName,
  attributeNamespace,
  sanitizeURL,
  removeEmptyString,
) {
  this.acceptsBooleans =
    type === BOOLEANISH_STRING ||
    type === BOOLEAN ||
    type === OVERLOADED_BOOLEAN;
  this.attributeName = attributeName;
  this.attributeNamespace = attributeNamespace;
  this.mustUseProperty = mustUseProperty;
  this.propertyName = name;
  this.type = type;
  this.sanitizeURL = sanitizeURL;
  this.removeEmptyString = removeEmptyString;
}

// When adding attributes to this list, be sure to also add them to
// the `possibleStandardNames` module to ensure casing and incorrect
// name warnings.
const properties = {};

// These props are reserved by React. They shouldn't be written to the DOM.
const reservedProps = [
  'children',
  'dangerouslySetInnerHTML',
  // TODO: This prevents the assignment of defaultValue to regular
  // elements (not just inputs). Now that ReactDOMInput assigns to the
  // defaultValue property -- do we need this?
  'defaultValue',
  'defaultChecked',
  'innerHTML',
  'suppressContentEditableWarning',
  'suppressHydrationWarning',
  'style',
];

reservedProps.forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    RESERVED,
    false, // mustUseProperty
    name, // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// A few React string attributes have a different name.
// This is a mapping from React prop names to the attribute names.
[
  ['acceptCharset', 'accept-charset'],
  ['className', 'class'],
  ['htmlFor', 'for'],
  ['httpEquiv', 'http-equiv'],
].forEach(([name, attributeName]) => {
  properties[name] = new PropertyInfoRecord(
    name,
    STRING,
    false, // mustUseProperty
    attributeName, // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These are "enumerated" HTML attributes that accept "true" and "false".
// In React, we let users pass `true` and `false` even though technically
// these aren't boolean attributes (they are coerced to strings).
['contentEditable', 'draggable', 'spellCheck', 'value'].forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    BOOLEANISH_STRING,
    false, // mustUseProperty
    name.toLowerCase(), // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These are "enumerated" SVG attributes that accept "true" and "false".
// In React, we let users pass `true` and `false` even though technically
// these aren't boolean attributes (they are coerced to strings).
// Since these are SVG attributes, their attribute names are case-sensitive.
[
  'autoReverse',
  'externalResourcesRequired',
  'focusable',
  'preserveAlpha',
].forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    BOOLEANISH_STRING,
    false, // mustUseProperty
    name, // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These are HTML boolean attributes.
[
  'allowFullScreen',
  'async',
  // Note: there is a special case that prevents it from being written to the DOM
  // on the client side because the browsers are inconsistent. Instead we call focus().
  'autoFocus',
  'autoPlay',
  'controls',
  'default',
  'defer',
  'disabled',
  'disablePictureInPicture',
  'disableRemotePlayback',
  'formNoValidate',
  'hidden',
  'loop',
  'noModule',
  'noValidate',
  'open',
  'playsInline',
  'readOnly',
  'required',
  'reversed',
  'scoped',
  'seamless',
  // Microdata
  'itemScope',
].forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    BOOLEAN,
    false, // mustUseProperty
    name.toLowerCase(), // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These are the few React props that we set as DOM properties
// rather than attributes. These are all booleans.
[
  'checked',
  // Note: `option.selected` is not updated if `select.multiple` is
  // disabled with `removeAttribute`. We have special logic for handling this.
  'multiple',
  'muted',
  'selected',

  // NOTE: if you add a camelCased prop to this list,
  // you'll need to set attributeName to name.toLowerCase()
  // instead in the assignment below.
].forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    BOOLEAN,
    true, // mustUseProperty
    name, // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These are HTML attributes that are "overloaded booleans": they behave like
// booleans, but can also accept a string value.
[
  'capture',
  'download',

  // NOTE: if you add a camelCased prop to this list,
  // you'll need to set attributeName to name.toLowerCase()
  // instead in the assignment below.
].forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    OVERLOADED_BOOLEAN,
    false, // mustUseProperty
    name, // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These are HTML attributes that must be positive numbers.
[
  'cols',
  'rows',
  'size',
  'span',

  // NOTE: if you add a camelCased prop to this list,
  // you'll need to set attributeName to name.toLowerCase()
  // instead in the assignment below.
].forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    POSITIVE_NUMERIC,
    false, // mustUseProperty
    name, // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These are HTML attributes that must be numbers.
['rowSpan', 'start'].forEach(name => {
  properties[name] = new PropertyInfoRecord(
    name,
    NUMERIC,
    false, // mustUseProperty
    name.toLowerCase(), // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

const CAMELIZE = /[\-\:]([a-z])/g;
const capitalize = token => token[1].toUpperCase();

// This is a list of all SVG attributes that need special casing, namespacing,
// or boolean value assignment. Regular attributes that just accept strings
// and have the same names are omitted, just like in the HTML attribute filter.
// Some of these attributes can be hard to find. This list was created by
// scraping the MDN documentation.
[
  'accent-height',
  'alignment-baseline',
  'arabic-form',
  'baseline-shift',
  'cap-height',
  'clip-path',
  'clip-rule',
  'color-interpolation',
  'color-interpolation-filters',
  'color-profile',
  'color-rendering',
  'dominant-baseline',
  'enable-background',
  'fill-opacity',
  'fill-rule',
  'flood-color',
  'flood-opacity',
  'font-family',
  'font-size',
  'font-size-adjust',
  'font-stretch',
  'font-style',
  'font-variant',
  'font-weight',
  'glyph-name',
  'glyph-orientation-horizontal',
  'glyph-orientation-vertical',
  'horiz-adv-x',
  'horiz-origin-x',
  'image-rendering',
  'letter-spacing',
  'lighting-color',
  'marker-end',
  'marker-mid',
  'marker-start',
  'overline-position',
  'overline-thickness',
  'paint-order',
  'panose-1',
  'pointer-events',
  'rendering-intent',
  'shape-rendering',
  'stop-color',
  'stop-opacity',
  'strikethrough-position',
  'strikethrough-thickness',
  'stroke-dasharray',
  'stroke-dashoffset',
  'stroke-linecap',
  'stroke-linejoin',
  'stroke-miterlimit',
  'stroke-opacity',
  'stroke-width',
  'text-anchor',
  'text-decoration',
  'text-rendering',
  'underline-position',
  'underline-thickness',
  'unicode-bidi',
  'unicode-range',
  'units-per-em',
  'v-alphabetic',
  'v-hanging',
  'v-ideographic',
  'v-mathematical',
  'vector-effect',
  'vert-adv-y',
  'vert-origin-x',
  'vert-origin-y',
  'word-spacing',
  'writing-mode',
  'xmlns:xlink',
  'x-height',

  // NOTE: if you add a camelCased prop to this list,
  // you'll need to set attributeName to name.toLowerCase()
  // instead in the assignment below.
].forEach(attributeName => {
  const name = attributeName.replace(CAMELIZE, capitalize);
  properties[name] = new PropertyInfoRecord(
    name,
    STRING,
    false, // mustUseProperty
    attributeName,
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// String SVG attributes with the xlink namespace.
[
  'xlink:actuate',
  'xlink:arcrole',
  'xlink:role',
  'xlink:show',
  'xlink:title',
  'xlink:type',

  // NOTE: if you add a camelCased prop to this list,
  // you'll need to set attributeName to name.toLowerCase()
  // instead in the assignment below.
].forEach(attributeName => {
  const name = attributeName.replace(CAMELIZE, capitalize);
  properties[name] = new PropertyInfoRecord(
    name,
    STRING,
    false, // mustUseProperty
    attributeName,
    'http://www.w3.org/1999/xlink',
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// String SVG attributes with the xml namespace.
[
  'xml:base',
  'xml:lang',
  'xml:space',

  // NOTE: if you add a camelCased prop to this list,
  // you'll need to set attributeName to name.toLowerCase()
  // instead in the assignment below.
].forEach(attributeName => {
  const name = attributeName.replace(CAMELIZE, capitalize);
  properties[name] = new PropertyInfoRecord(
    name,
    STRING,
    false, // mustUseProperty
    attributeName,
    'http://www.w3.org/XML/1998/namespace',
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These attribute exists both in HTML and SVG.
// The attribute name is case-sensitive in SVG so we can't just use
// the React name like we do for attributes that exist only in HTML.
['tabIndex', 'crossOrigin'].forEach(attributeName => {
  properties[attributeName] = new PropertyInfoRecord(
    attributeName,
    STRING,
    false, // mustUseProperty
    attributeName.toLowerCase(), // attributeName
    null, // attributeNamespace
    false, // sanitizeURL
    false, // removeEmptyString
  );
});

// These attributes accept URLs. These must not allow javascript: URLS.
// These will also need to accept Trusted Types object in the future.
const xlinkHref = 'xlinkHref';
properties[xlinkHref] = new PropertyInfoRecord(
  'xlinkHref',
  STRING,
  false, // mustUseProperty
  'xlink:href',
  'http://www.w3.org/1999/xlink',
  true, // sanitizeURL
  false, // removeEmptyString
);

['src', 'href', 'action', 'formAction'].forEach(attributeName => {
  properties[attributeName] = new PropertyInfoRecord(
    attributeName,
    STRING,
    false, // mustUseProperty
    attributeName.toLowerCase(), // attributeName
    null, // attributeNamespace
    true, // sanitizeURL
    true, // removeEmptyString
  );
});

// 
const {
  CAMELCASE,
  SAME,
  possibleStandardNames: possibleStandardNamesOptimized
} = __webpack_require__(/*! ../lib/possibleStandardNamesOptimized */ "../../node_modules/react-property/lib/possibleStandardNamesOptimized.js");

const ATTRIBUTE_NAME_START_CHAR =
  ':A-Z_a-z\\u00C0-\\u00D6\\u00D8-\\u00F6\\u00F8-\\u02FF\\u0370-\\u037D\\u037F-\\u1FFF\\u200C-\\u200D\\u2070-\\u218F\\u2C00-\\u2FEF\\u3001-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFFD';

const ATTRIBUTE_NAME_CHAR =
  ATTRIBUTE_NAME_START_CHAR + '\\-.0-9\\u00B7\\u0300-\\u036F\\u203F-\\u2040';

/**
 * Checks whether a property name is a custom attribute.
 *
 * @see https://github.com/facebook/react/blob/15-stable/src/renderers/dom/shared/HTMLDOMPropertyConfig.js#L23-L25
 *
 * @type {(attribute: string) => boolean}
 */
const isCustomAttribute =
  RegExp.prototype.test.bind(
    // eslint-disable-next-line no-misleading-character-class
    new RegExp('^(data|aria)-[' + ATTRIBUTE_NAME_CHAR + ']*$')
  );

/**
 * @type {Record<string, string>}
 */
const possibleStandardNames = Object.keys(
  possibleStandardNamesOptimized
).reduce((accumulator, standardName) => {
  const propName = possibleStandardNamesOptimized[standardName];
  if (propName === SAME) {
    accumulator[standardName] = standardName;
  } else if (propName === CAMELCASE) {
    accumulator[standardName.toLowerCase()] = standardName;
  } else {
    accumulator[standardName] = propName;
  }
  return accumulator;
}, {});

exports.BOOLEAN = BOOLEAN;
exports.BOOLEANISH_STRING = BOOLEANISH_STRING;
exports.NUMERIC = NUMERIC;
exports.OVERLOADED_BOOLEAN = OVERLOADED_BOOLEAN;
exports.POSITIVE_NUMERIC = POSITIVE_NUMERIC;
exports.RESERVED = RESERVED;
exports.STRING = STRING;
exports.getPropertyInfo = getPropertyInfo;
exports.isCustomAttribute = isCustomAttribute;
exports.possibleStandardNames = possibleStandardNames;


/***/ }),

/***/ "../../node_modules/react-property/lib/possibleStandardNamesOptimized.js":
/*!*******************************************************************************!*\
  !*** ../../node_modules/react-property/lib/possibleStandardNamesOptimized.js ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack_module, exports) {

// An attribute in which the DOM/SVG standard name is the same as the React prop name (e.g., 'accept').
var SAME = 0;
exports.SAME = SAME;

// An attribute in which the React prop name is the camelcased version of the DOM/SVG standard name (e.g., 'acceptCharset').
var CAMELCASE = 1;
exports.CAMELCASE = CAMELCASE;

exports.possibleStandardNames = {
  accept: 0,
  acceptCharset: 1,
  'accept-charset': 'acceptCharset',
  accessKey: 1,
  action: 0,
  allowFullScreen: 1,
  alt: 0,
  as: 0,
  async: 0,
  autoCapitalize: 1,
  autoComplete: 1,
  autoCorrect: 1,
  autoFocus: 1,
  autoPlay: 1,
  autoSave: 1,
  capture: 0,
  cellPadding: 1,
  cellSpacing: 1,
  challenge: 0,
  charSet: 1,
  checked: 0,
  children: 0,
  cite: 0,
  class: 'className',
  classID: 1,
  className: 1,
  cols: 0,
  colSpan: 1,
  content: 0,
  contentEditable: 1,
  contextMenu: 1,
  controls: 0,
  controlsList: 1,
  coords: 0,
  crossOrigin: 1,
  dangerouslySetInnerHTML: 1,
  data: 0,
  dateTime: 1,
  default: 0,
  defaultChecked: 1,
  defaultValue: 1,
  defer: 0,
  dir: 0,
  disabled: 0,
  disablePictureInPicture: 1,
  disableRemotePlayback: 1,
  download: 0,
  draggable: 0,
  encType: 1,
  enterKeyHint: 1,
  for: 'htmlFor',
  form: 0,
  formMethod: 1,
  formAction: 1,
  formEncType: 1,
  formNoValidate: 1,
  formTarget: 1,
  frameBorder: 1,
  headers: 0,
  height: 0,
  hidden: 0,
  high: 0,
  href: 0,
  hrefLang: 1,
  htmlFor: 1,
  httpEquiv: 1,
  'http-equiv': 'httpEquiv',
  icon: 0,
  id: 0,
  innerHTML: 1,
  inputMode: 1,
  integrity: 0,
  is: 0,
  itemID: 1,
  itemProp: 1,
  itemRef: 1,
  itemScope: 1,
  itemType: 1,
  keyParams: 1,
  keyType: 1,
  kind: 0,
  label: 0,
  lang: 0,
  list: 0,
  loop: 0,
  low: 0,
  manifest: 0,
  marginWidth: 1,
  marginHeight: 1,
  max: 0,
  maxLength: 1,
  media: 0,
  mediaGroup: 1,
  method: 0,
  min: 0,
  minLength: 1,
  multiple: 0,
  muted: 0,
  name: 0,
  noModule: 1,
  nonce: 0,
  noValidate: 1,
  open: 0,
  optimum: 0,
  pattern: 0,
  placeholder: 0,
  playsInline: 1,
  poster: 0,
  preload: 0,
  profile: 0,
  radioGroup: 1,
  readOnly: 1,
  referrerPolicy: 1,
  rel: 0,
  required: 0,
  reversed: 0,
  role: 0,
  rows: 0,
  rowSpan: 1,
  sandbox: 0,
  scope: 0,
  scoped: 0,
  scrolling: 0,
  seamless: 0,
  selected: 0,
  shape: 0,
  size: 0,
  sizes: 0,
  span: 0,
  spellCheck: 1,
  src: 0,
  srcDoc: 1,
  srcLang: 1,
  srcSet: 1,
  start: 0,
  step: 0,
  style: 0,
  summary: 0,
  tabIndex: 1,
  target: 0,
  title: 0,
  type: 0,
  useMap: 1,
  value: 0,
  width: 0,
  wmode: 0,
  wrap: 0,
  about: 0,
  accentHeight: 1,
  'accent-height': 'accentHeight',
  accumulate: 0,
  additive: 0,
  alignmentBaseline: 1,
  'alignment-baseline': 'alignmentBaseline',
  allowReorder: 1,
  alphabetic: 0,
  amplitude: 0,
  arabicForm: 1,
  'arabic-form': 'arabicForm',
  ascent: 0,
  attributeName: 1,
  attributeType: 1,
  autoReverse: 1,
  azimuth: 0,
  baseFrequency: 1,
  baselineShift: 1,
  'baseline-shift': 'baselineShift',
  baseProfile: 1,
  bbox: 0,
  begin: 0,
  bias: 0,
  by: 0,
  calcMode: 1,
  capHeight: 1,
  'cap-height': 'capHeight',
  clip: 0,
  clipPath: 1,
  'clip-path': 'clipPath',
  clipPathUnits: 1,
  clipRule: 1,
  'clip-rule': 'clipRule',
  color: 0,
  colorInterpolation: 1,
  'color-interpolation': 'colorInterpolation',
  colorInterpolationFilters: 1,
  'color-interpolation-filters': 'colorInterpolationFilters',
  colorProfile: 1,
  'color-profile': 'colorProfile',
  colorRendering: 1,
  'color-rendering': 'colorRendering',
  contentScriptType: 1,
  contentStyleType: 1,
  cursor: 0,
  cx: 0,
  cy: 0,
  d: 0,
  datatype: 0,
  decelerate: 0,
  descent: 0,
  diffuseConstant: 1,
  direction: 0,
  display: 0,
  divisor: 0,
  dominantBaseline: 1,
  'dominant-baseline': 'dominantBaseline',
  dur: 0,
  dx: 0,
  dy: 0,
  edgeMode: 1,
  elevation: 0,
  enableBackground: 1,
  'enable-background': 'enableBackground',
  end: 0,
  exponent: 0,
  externalResourcesRequired: 1,
  fill: 0,
  fillOpacity: 1,
  'fill-opacity': 'fillOpacity',
  fillRule: 1,
  'fill-rule': 'fillRule',
  filter: 0,
  filterRes: 1,
  filterUnits: 1,
  floodOpacity: 1,
  'flood-opacity': 'floodOpacity',
  floodColor: 1,
  'flood-color': 'floodColor',
  focusable: 0,
  fontFamily: 1,
  'font-family': 'fontFamily',
  fontSize: 1,
  'font-size': 'fontSize',
  fontSizeAdjust: 1,
  'font-size-adjust': 'fontSizeAdjust',
  fontStretch: 1,
  'font-stretch': 'fontStretch',
  fontStyle: 1,
  'font-style': 'fontStyle',
  fontVariant: 1,
  'font-variant': 'fontVariant',
  fontWeight: 1,
  'font-weight': 'fontWeight',
  format: 0,
  from: 0,
  fx: 0,
  fy: 0,
  g1: 0,
  g2: 0,
  glyphName: 1,
  'glyph-name': 'glyphName',
  glyphOrientationHorizontal: 1,
  'glyph-orientation-horizontal': 'glyphOrientationHorizontal',
  glyphOrientationVertical: 1,
  'glyph-orientation-vertical': 'glyphOrientationVertical',
  glyphRef: 1,
  gradientTransform: 1,
  gradientUnits: 1,
  hanging: 0,
  horizAdvX: 1,
  'horiz-adv-x': 'horizAdvX',
  horizOriginX: 1,
  'horiz-origin-x': 'horizOriginX',
  ideographic: 0,
  imageRendering: 1,
  'image-rendering': 'imageRendering',
  in2: 0,
  in: 0,
  inlist: 0,
  intercept: 0,
  k1: 0,
  k2: 0,
  k3: 0,
  k4: 0,
  k: 0,
  kernelMatrix: 1,
  kernelUnitLength: 1,
  kerning: 0,
  keyPoints: 1,
  keySplines: 1,
  keyTimes: 1,
  lengthAdjust: 1,
  letterSpacing: 1,
  'letter-spacing': 'letterSpacing',
  lightingColor: 1,
  'lighting-color': 'lightingColor',
  limitingConeAngle: 1,
  local: 0,
  markerEnd: 1,
  'marker-end': 'markerEnd',
  markerHeight: 1,
  markerMid: 1,
  'marker-mid': 'markerMid',
  markerStart: 1,
  'marker-start': 'markerStart',
  markerUnits: 1,
  markerWidth: 1,
  mask: 0,
  maskContentUnits: 1,
  maskUnits: 1,
  mathematical: 0,
  mode: 0,
  numOctaves: 1,
  offset: 0,
  opacity: 0,
  operator: 0,
  order: 0,
  orient: 0,
  orientation: 0,
  origin: 0,
  overflow: 0,
  overlinePosition: 1,
  'overline-position': 'overlinePosition',
  overlineThickness: 1,
  'overline-thickness': 'overlineThickness',
  paintOrder: 1,
  'paint-order': 'paintOrder',
  panose1: 0,
  'panose-1': 'panose1',
  pathLength: 1,
  patternContentUnits: 1,
  patternTransform: 1,
  patternUnits: 1,
  pointerEvents: 1,
  'pointer-events': 'pointerEvents',
  points: 0,
  pointsAtX: 1,
  pointsAtY: 1,
  pointsAtZ: 1,
  prefix: 0,
  preserveAlpha: 1,
  preserveAspectRatio: 1,
  primitiveUnits: 1,
  property: 0,
  r: 0,
  radius: 0,
  refX: 1,
  refY: 1,
  renderingIntent: 1,
  'rendering-intent': 'renderingIntent',
  repeatCount: 1,
  repeatDur: 1,
  requiredExtensions: 1,
  requiredFeatures: 1,
  resource: 0,
  restart: 0,
  result: 0,
  results: 0,
  rotate: 0,
  rx: 0,
  ry: 0,
  scale: 0,
  security: 0,
  seed: 0,
  shapeRendering: 1,
  'shape-rendering': 'shapeRendering',
  slope: 0,
  spacing: 0,
  specularConstant: 1,
  specularExponent: 1,
  speed: 0,
  spreadMethod: 1,
  startOffset: 1,
  stdDeviation: 1,
  stemh: 0,
  stemv: 0,
  stitchTiles: 1,
  stopColor: 1,
  'stop-color': 'stopColor',
  stopOpacity: 1,
  'stop-opacity': 'stopOpacity',
  strikethroughPosition: 1,
  'strikethrough-position': 'strikethroughPosition',
  strikethroughThickness: 1,
  'strikethrough-thickness': 'strikethroughThickness',
  string: 0,
  stroke: 0,
  strokeDasharray: 1,
  'stroke-dasharray': 'strokeDasharray',
  strokeDashoffset: 1,
  'stroke-dashoffset': 'strokeDashoffset',
  strokeLinecap: 1,
  'stroke-linecap': 'strokeLinecap',
  strokeLinejoin: 1,
  'stroke-linejoin': 'strokeLinejoin',
  strokeMiterlimit: 1,
  'stroke-miterlimit': 'strokeMiterlimit',
  strokeWidth: 1,
  'stroke-width': 'strokeWidth',
  strokeOpacity: 1,
  'stroke-opacity': 'strokeOpacity',
  suppressContentEditableWarning: 1,
  suppressHydrationWarning: 1,
  surfaceScale: 1,
  systemLanguage: 1,
  tableValues: 1,
  targetX: 1,
  targetY: 1,
  textAnchor: 1,
  'text-anchor': 'textAnchor',
  textDecoration: 1,
  'text-decoration': 'textDecoration',
  textLength: 1,
  textRendering: 1,
  'text-rendering': 'textRendering',
  to: 0,
  transform: 0,
  typeof: 0,
  u1: 0,
  u2: 0,
  underlinePosition: 1,
  'underline-position': 'underlinePosition',
  underlineThickness: 1,
  'underline-thickness': 'underlineThickness',
  unicode: 0,
  unicodeBidi: 1,
  'unicode-bidi': 'unicodeBidi',
  unicodeRange: 1,
  'unicode-range': 'unicodeRange',
  unitsPerEm: 1,
  'units-per-em': 'unitsPerEm',
  unselectable: 0,
  vAlphabetic: 1,
  'v-alphabetic': 'vAlphabetic',
  values: 0,
  vectorEffect: 1,
  'vector-effect': 'vectorEffect',
  version: 0,
  vertAdvY: 1,
  'vert-adv-y': 'vertAdvY',
  vertOriginX: 1,
  'vert-origin-x': 'vertOriginX',
  vertOriginY: 1,
  'vert-origin-y': 'vertOriginY',
  vHanging: 1,
  'v-hanging': 'vHanging',
  vIdeographic: 1,
  'v-ideographic': 'vIdeographic',
  viewBox: 1,
  viewTarget: 1,
  visibility: 0,
  vMathematical: 1,
  'v-mathematical': 'vMathematical',
  vocab: 0,
  widths: 0,
  wordSpacing: 1,
  'word-spacing': 'wordSpacing',
  writingMode: 1,
  'writing-mode': 'writingMode',
  x1: 0,
  x2: 0,
  x: 0,
  xChannelSelector: 1,
  xHeight: 1,
  'x-height': 'xHeight',
  xlinkActuate: 1,
  'xlink:actuate': 'xlinkActuate',
  xlinkArcrole: 1,
  'xlink:arcrole': 'xlinkArcrole',
  xlinkHref: 1,
  'xlink:href': 'xlinkHref',
  xlinkRole: 1,
  'xlink:role': 'xlinkRole',
  xlinkShow: 1,
  'xlink:show': 'xlinkShow',
  xlinkTitle: 1,
  'xlink:title': 'xlinkTitle',
  xlinkType: 1,
  'xlink:type': 'xlinkType',
  xmlBase: 1,
  'xml:base': 'xmlBase',
  xmlLang: 1,
  'xml:lang': 'xmlLang',
  xmlns: 0,
  'xml:space': 'xmlSpace',
  xmlnsXlink: 1,
  'xmlns:xlink': 'xmlnsXlink',
  xmlSpace: 1,
  y1: 0,
  y2: 0,
  y: 0,
  yChannelSelector: 1,
  z: 0,
  zoomAndPan: 1
};


/***/ }),

/***/ "../../node_modules/style-to-js/cjs/index.js":
/*!***************************************************!*\
  !*** ../../node_modules/style-to-js/cjs/index.js ***!
  \***************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

"use strict";

var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
var style_to_object_1 = __importDefault(__webpack_require__(/*! style-to-object */ "../../node_modules/style-to-object/cjs/index.js"));
var utilities_1 = __webpack_require__(/*! ./utilities */ "../../node_modules/style-to-js/cjs/utilities.js");
/**
 * Parses CSS inline style to JavaScript object (camelCased).
 */
function StyleToJS(style, options) {
    var output = {};
    if (!style || typeof style !== 'string') {
        return output;
    }
    (0, style_to_object_1.default)(style, function (property, value) {
        // skip CSS comment
        if (property && value) {
            output[(0, utilities_1.camelCase)(property, options)] = value;
        }
    });
    return output;
}
StyleToJS.default = StyleToJS;
module.exports = StyleToJS;
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "../../node_modules/style-to-js/cjs/utilities.js":
/*!*******************************************************!*\
  !*** ../../node_modules/style-to-js/cjs/utilities.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports) {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
exports.camelCase = void 0;
var CUSTOM_PROPERTY_REGEX = /^--[a-zA-Z0-9-]+$/;
var HYPHEN_REGEX = /-([a-z])/g;
var NO_HYPHEN_REGEX = /^[^-]+$/;
var VENDOR_PREFIX_REGEX = /^-(webkit|moz|ms|o|khtml)-/;
var MS_VENDOR_PREFIX_REGEX = /^-(ms)-/;
/**
 * Checks whether to skip camelCase.
 */
var skipCamelCase = function (property) {
    return !property ||
        NO_HYPHEN_REGEX.test(property) ||
        CUSTOM_PROPERTY_REGEX.test(property);
};
/**
 * Replacer that capitalizes first character.
 */
var capitalize = function (match, character) {
    return character.toUpperCase();
};
/**
 * Replacer that removes beginning hyphen of vendor prefix property.
 */
var trimHyphen = function (match, prefix) { return "".concat(prefix, "-"); };
/**
 * CamelCases a CSS property.
 */
var camelCase = function (property, options) {
    if (options === void 0) { options = {}; }
    if (skipCamelCase(property)) {
        return property;
    }
    property = property.toLowerCase();
    if (options.reactCompat) {
        // `-ms` vendor prefix should not be capitalized
        property = property.replace(MS_VENDOR_PREFIX_REGEX, trimHyphen);
    }
    else {
        // for non-React, remove first hyphen so vendor prefix is not capitalized
        property = property.replace(VENDOR_PREFIX_REGEX, trimHyphen);
    }
    return property.replace(HYPHEN_REGEX, capitalize);
};
exports.camelCase = camelCase;
//# sourceMappingURL=utilities.js.map

/***/ }),

/***/ "../../node_modules/style-to-object/cjs/index.js":
/*!*******************************************************!*\
  !*** ../../node_modules/style-to-object/cjs/index.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {

"use strict";

var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", ({ value: true }));
var inline_style_parser_1 = __importDefault(__webpack_require__(/*! inline-style-parser */ "../../node_modules/inline-style-parser/index.js"));
/**
 * Parses inline style to object.
 *
 * @param style - Inline style.
 * @param iterator - Iterator.
 * @returns - Style object or null.
 *
 * @example Parsing inline style to object:
 *
 * ```js
 * import parse from 'style-to-object';
 * parse('line-height: 42;'); // { 'line-height': '42' }
 * ```
 */
function StyleToObject(style, iterator) {
    var styleObject = null;
    if (!style || typeof style !== 'string') {
        return styleObject;
    }
    var declarations = (0, inline_style_parser_1.default)(style);
    var hasIterator = typeof iterator === 'function';
    declarations.forEach(function (declaration) {
        if (declaration.type !== 'declaration') {
            return;
        }
        var property = declaration.property, value = declaration.value;
        if (hasIterator) {
            iterator(property, value, declaration);
        }
        else if (value) {
            styleObject = styleObject || {};
            styleObject[property] = value;
        }
    });
    return styleObject;
}
exports["default"] = StyleToObject;
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "../../node_modules/webfontloader/webfontloader.js":
/*!*********************************************************!*\
  !*** ../../node_modules/webfontloader/webfontloader.js ***!
  \*********************************************************/
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_RESULT__;/* Web Font Loader v1.6.28 - (c) Adobe Systems, Google. License: Apache 2.0 */(function(){function aa(a,b,c){return a.call.apply(a.bind,arguments)}function ba(a,b,c){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(c,d);return a.apply(b,c)}}return function(){return a.apply(b,arguments)}}function p(a,b,c){p=Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?aa:ba;return p.apply(null,arguments)}var q=Date.now||function(){return+new Date};function ca(a,b){this.a=a;this.o=b||a;this.c=this.o.document}var da=!!window.FontFace;function t(a,b,c,d){b=a.c.createElement(b);if(c)for(var e in c)c.hasOwnProperty(e)&&("style"==e?b.style.cssText=c[e]:b.setAttribute(e,c[e]));d&&b.appendChild(a.c.createTextNode(d));return b}function u(a,b,c){a=a.c.getElementsByTagName(b)[0];a||(a=document.documentElement);a.insertBefore(c,a.lastChild)}function v(a){a.parentNode&&a.parentNode.removeChild(a)}
function w(a,b,c){b=b||[];c=c||[];for(var d=a.className.split(/\s+/),e=0;e<b.length;e+=1){for(var f=!1,g=0;g<d.length;g+=1)if(b[e]===d[g]){f=!0;break}f||d.push(b[e])}b=[];for(e=0;e<d.length;e+=1){f=!1;for(g=0;g<c.length;g+=1)if(d[e]===c[g]){f=!0;break}f||b.push(d[e])}a.className=b.join(" ").replace(/\s+/g," ").replace(/^\s+|\s+$/,"")}function y(a,b){for(var c=a.className.split(/\s+/),d=0,e=c.length;d<e;d++)if(c[d]==b)return!0;return!1}
function ea(a){return a.o.location.hostname||a.a.location.hostname}function z(a,b,c){function d(){m&&e&&f&&(m(g),m=null)}b=t(a,"link",{rel:"stylesheet",href:b,media:"all"});var e=!1,f=!0,g=null,m=c||null;da?(b.onload=function(){e=!0;d()},b.onerror=function(){e=!0;g=Error("Stylesheet failed to load");d()}):setTimeout(function(){e=!0;d()},0);u(a,"head",b)}
function A(a,b,c,d){var e=a.c.getElementsByTagName("head")[0];if(e){var f=t(a,"script",{src:b}),g=!1;f.onload=f.onreadystatechange=function(){g||this.readyState&&"loaded"!=this.readyState&&"complete"!=this.readyState||(g=!0,c&&c(null),f.onload=f.onreadystatechange=null,"HEAD"==f.parentNode.tagName&&e.removeChild(f))};e.appendChild(f);setTimeout(function(){g||(g=!0,c&&c(Error("Script load timeout")))},d||5E3);return f}return null};function B(){this.a=0;this.c=null}function C(a){a.a++;return function(){a.a--;D(a)}}function E(a,b){a.c=b;D(a)}function D(a){0==a.a&&a.c&&(a.c(),a.c=null)};function F(a){this.a=a||"-"}F.prototype.c=function(a){for(var b=[],c=0;c<arguments.length;c++)b.push(arguments[c].replace(/[\W_]+/g,"").toLowerCase());return b.join(this.a)};function G(a,b){this.c=a;this.f=4;this.a="n";var c=(b||"n4").match(/^([nio])([1-9])$/i);c&&(this.a=c[1],this.f=parseInt(c[2],10))}function fa(a){return H(a)+" "+(a.f+"00")+" 300px "+I(a.c)}function I(a){var b=[];a=a.split(/,\s*/);for(var c=0;c<a.length;c++){var d=a[c].replace(/['"]/g,"");-1!=d.indexOf(" ")||/^\d/.test(d)?b.push("'"+d+"'"):b.push(d)}return b.join(",")}function J(a){return a.a+a.f}function H(a){var b="normal";"o"===a.a?b="oblique":"i"===a.a&&(b="italic");return b}
function ga(a){var b=4,c="n",d=null;a&&((d=a.match(/(normal|oblique|italic)/i))&&d[1]&&(c=d[1].substr(0,1).toLowerCase()),(d=a.match(/([1-9]00|normal|bold)/i))&&d[1]&&(/bold/i.test(d[1])?b=7:/[1-9]00/.test(d[1])&&(b=parseInt(d[1].substr(0,1),10))));return c+b};function ha(a,b){this.c=a;this.f=a.o.document.documentElement;this.h=b;this.a=new F("-");this.j=!1!==b.events;this.g=!1!==b.classes}function ia(a){a.g&&w(a.f,[a.a.c("wf","loading")]);K(a,"loading")}function L(a){if(a.g){var b=y(a.f,a.a.c("wf","active")),c=[],d=[a.a.c("wf","loading")];b||c.push(a.a.c("wf","inactive"));w(a.f,c,d)}K(a,"inactive")}function K(a,b,c){if(a.j&&a.h[b])if(c)a.h[b](c.c,J(c));else a.h[b]()};function ja(){this.c={}}function ka(a,b,c){var d=[],e;for(e in b)if(b.hasOwnProperty(e)){var f=a.c[e];f&&d.push(f(b[e],c))}return d};function M(a,b){this.c=a;this.f=b;this.a=t(this.c,"span",{"aria-hidden":"true"},this.f)}function N(a){u(a.c,"body",a.a)}function O(a){return"display:block;position:absolute;top:-9999px;left:-9999px;font-size:300px;width:auto;height:auto;line-height:normal;margin:0;padding:0;font-variant:normal;white-space:nowrap;font-family:"+I(a.c)+";"+("font-style:"+H(a)+";font-weight:"+(a.f+"00")+";")};function P(a,b,c,d,e,f){this.g=a;this.j=b;this.a=d;this.c=c;this.f=e||3E3;this.h=f||void 0}P.prototype.start=function(){var a=this.c.o.document,b=this,c=q(),d=new Promise(function(d,e){function f(){q()-c>=b.f?e():a.fonts.load(fa(b.a),b.h).then(function(a){1<=a.length?d():setTimeout(f,25)},function(){e()})}f()}),e=null,f=new Promise(function(a,d){e=setTimeout(d,b.f)});Promise.race([f,d]).then(function(){e&&(clearTimeout(e),e=null);b.g(b.a)},function(){b.j(b.a)})};function Q(a,b,c,d,e,f,g){this.v=a;this.B=b;this.c=c;this.a=d;this.s=g||"BESbswy";this.f={};this.w=e||3E3;this.u=f||null;this.m=this.j=this.h=this.g=null;this.g=new M(this.c,this.s);this.h=new M(this.c,this.s);this.j=new M(this.c,this.s);this.m=new M(this.c,this.s);a=new G(this.a.c+",serif",J(this.a));a=O(a);this.g.a.style.cssText=a;a=new G(this.a.c+",sans-serif",J(this.a));a=O(a);this.h.a.style.cssText=a;a=new G("serif",J(this.a));a=O(a);this.j.a.style.cssText=a;a=new G("sans-serif",J(this.a));a=
O(a);this.m.a.style.cssText=a;N(this.g);N(this.h);N(this.j);N(this.m)}var R={D:"serif",C:"sans-serif"},S=null;function T(){if(null===S){var a=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))/.exec(window.navigator.userAgent);S=!!a&&(536>parseInt(a[1],10)||536===parseInt(a[1],10)&&11>=parseInt(a[2],10))}return S}Q.prototype.start=function(){this.f.serif=this.j.a.offsetWidth;this.f["sans-serif"]=this.m.a.offsetWidth;this.A=q();U(this)};
function la(a,b,c){for(var d in R)if(R.hasOwnProperty(d)&&b===a.f[R[d]]&&c===a.f[R[d]])return!0;return!1}function U(a){var b=a.g.a.offsetWidth,c=a.h.a.offsetWidth,d;(d=b===a.f.serif&&c===a.f["sans-serif"])||(d=T()&&la(a,b,c));d?q()-a.A>=a.w?T()&&la(a,b,c)&&(null===a.u||a.u.hasOwnProperty(a.a.c))?V(a,a.v):V(a,a.B):ma(a):V(a,a.v)}function ma(a){setTimeout(p(function(){U(this)},a),50)}function V(a,b){setTimeout(p(function(){v(this.g.a);v(this.h.a);v(this.j.a);v(this.m.a);b(this.a)},a),0)};function W(a,b,c){this.c=a;this.a=b;this.f=0;this.m=this.j=!1;this.s=c}var X=null;W.prototype.g=function(a){var b=this.a;b.g&&w(b.f,[b.a.c("wf",a.c,J(a).toString(),"active")],[b.a.c("wf",a.c,J(a).toString(),"loading"),b.a.c("wf",a.c,J(a).toString(),"inactive")]);K(b,"fontactive",a);this.m=!0;na(this)};
W.prototype.h=function(a){var b=this.a;if(b.g){var c=y(b.f,b.a.c("wf",a.c,J(a).toString(),"active")),d=[],e=[b.a.c("wf",a.c,J(a).toString(),"loading")];c||d.push(b.a.c("wf",a.c,J(a).toString(),"inactive"));w(b.f,d,e)}K(b,"fontinactive",a);na(this)};function na(a){0==--a.f&&a.j&&(a.m?(a=a.a,a.g&&w(a.f,[a.a.c("wf","active")],[a.a.c("wf","loading"),a.a.c("wf","inactive")]),K(a,"active")):L(a.a))};function oa(a){this.j=a;this.a=new ja;this.h=0;this.f=this.g=!0}oa.prototype.load=function(a){this.c=new ca(this.j,a.context||this.j);this.g=!1!==a.events;this.f=!1!==a.classes;pa(this,new ha(this.c,a),a)};
function qa(a,b,c,d,e){var f=0==--a.h;(a.f||a.g)&&setTimeout(function(){var a=e||null,m=d||null||{};if(0===c.length&&f)L(b.a);else{b.f+=c.length;f&&(b.j=f);var h,l=[];for(h=0;h<c.length;h++){var k=c[h],n=m[k.c],r=b.a,x=k;r.g&&w(r.f,[r.a.c("wf",x.c,J(x).toString(),"loading")]);K(r,"fontloading",x);r=null;if(null===X)if(window.FontFace){var x=/Gecko.*Firefox\/(\d+)/.exec(window.navigator.userAgent),xa=/OS X.*Version\/10\..*Safari/.exec(window.navigator.userAgent)&&/Apple/.exec(window.navigator.vendor);
X=x?42<parseInt(x[1],10):xa?!1:!0}else X=!1;X?r=new P(p(b.g,b),p(b.h,b),b.c,k,b.s,n):r=new Q(p(b.g,b),p(b.h,b),b.c,k,b.s,a,n);l.push(r)}for(h=0;h<l.length;h++)l[h].start()}},0)}function pa(a,b,c){var d=[],e=c.timeout;ia(b);var d=ka(a.a,c,a.c),f=new W(a.c,b,e);a.h=d.length;b=0;for(c=d.length;b<c;b++)d[b].load(function(b,d,c){qa(a,f,b,d,c)})};function ra(a,b){this.c=a;this.a=b}
ra.prototype.load=function(a){function b(){if(f["__mti_fntLst"+d]){var c=f["__mti_fntLst"+d](),e=[],h;if(c)for(var l=0;l<c.length;l++){var k=c[l].fontfamily;void 0!=c[l].fontStyle&&void 0!=c[l].fontWeight?(h=c[l].fontStyle+c[l].fontWeight,e.push(new G(k,h))):e.push(new G(k))}a(e)}else setTimeout(function(){b()},50)}var c=this,d=c.a.projectId,e=c.a.version;if(d){var f=c.c.o;A(this.c,(c.a.api||"https://fast.fonts.net/jsapi")+"/"+d+".js"+(e?"?v="+e:""),function(e){e?a([]):(f["__MonotypeConfiguration__"+
d]=function(){return c.a},b())}).id="__MonotypeAPIScript__"+d}else a([])};function sa(a,b){this.c=a;this.a=b}sa.prototype.load=function(a){var b,c,d=this.a.urls||[],e=this.a.families||[],f=this.a.testStrings||{},g=new B;b=0;for(c=d.length;b<c;b++)z(this.c,d[b],C(g));var m=[];b=0;for(c=e.length;b<c;b++)if(d=e[b].split(":"),d[1])for(var h=d[1].split(","),l=0;l<h.length;l+=1)m.push(new G(d[0],h[l]));else m.push(new G(d[0]));E(g,function(){a(m,f)})};function ta(a,b){a?this.c=a:this.c=ua;this.a=[];this.f=[];this.g=b||""}var ua="https://fonts.googleapis.com/css";function va(a,b){for(var c=b.length,d=0;d<c;d++){var e=b[d].split(":");3==e.length&&a.f.push(e.pop());var f="";2==e.length&&""!=e[1]&&(f=":");a.a.push(e.join(f))}}
function wa(a){if(0==a.a.length)throw Error("No fonts to load!");if(-1!=a.c.indexOf("kit="))return a.c;for(var b=a.a.length,c=[],d=0;d<b;d++)c.push(a.a[d].replace(/ /g,"+"));b=a.c+"?family="+c.join("%7C");0<a.f.length&&(b+="&subset="+a.f.join(","));0<a.g.length&&(b+="&text="+encodeURIComponent(a.g));return b};function ya(a){this.f=a;this.a=[];this.c={}}
var za={latin:"BESbswy","latin-ext":"\u00e7\u00f6\u00fc\u011f\u015f",cyrillic:"\u0439\u044f\u0416",greek:"\u03b1\u03b2\u03a3",khmer:"\u1780\u1781\u1782",Hanuman:"\u1780\u1781\u1782"},Aa={thin:"1",extralight:"2","extra-light":"2",ultralight:"2","ultra-light":"2",light:"3",regular:"4",book:"4",medium:"5","semi-bold":"6",semibold:"6","demi-bold":"6",demibold:"6",bold:"7","extra-bold":"8",extrabold:"8","ultra-bold":"8",ultrabold:"8",black:"9",heavy:"9",l:"3",r:"4",b:"7"},Ba={i:"i",italic:"i",n:"n",normal:"n"},
Ca=/^(thin|(?:(?:extra|ultra)-?)?light|regular|book|medium|(?:(?:semi|demi|extra|ultra)-?)?bold|black|heavy|l|r|b|[1-9]00)?(n|i|normal|italic)?$/;
function Da(a){for(var b=a.f.length,c=0;c<b;c++){var d=a.f[c].split(":"),e=d[0].replace(/\+/g," "),f=["n4"];if(2<=d.length){var g;var m=d[1];g=[];if(m)for(var m=m.split(","),h=m.length,l=0;l<h;l++){var k;k=m[l];if(k.match(/^[\w-]+$/)){var n=Ca.exec(k.toLowerCase());if(null==n)k="";else{k=n[2];k=null==k||""==k?"n":Ba[k];n=n[1];if(null==n||""==n)n="4";else var r=Aa[n],n=r?r:isNaN(n)?"4":n.substr(0,1);k=[k,n].join("")}}else k="";k&&g.push(k)}0<g.length&&(f=g);3==d.length&&(d=d[2],g=[],d=d?d.split(","):
g,0<d.length&&(d=za[d[0]])&&(a.c[e]=d))}a.c[e]||(d=za[e])&&(a.c[e]=d);for(d=0;d<f.length;d+=1)a.a.push(new G(e,f[d]))}};function Ea(a,b){this.c=a;this.a=b}var Fa={Arimo:!0,Cousine:!0,Tinos:!0};Ea.prototype.load=function(a){var b=new B,c=this.c,d=new ta(this.a.api,this.a.text),e=this.a.families;va(d,e);var f=new ya(e);Da(f);z(c,wa(d),C(b));E(b,function(){a(f.a,f.c,Fa)})};function Ga(a,b){this.c=a;this.a=b}Ga.prototype.load=function(a){var b=this.a.id,c=this.c.o;b?A(this.c,(this.a.api||"https://use.typekit.net")+"/"+b+".js",function(b){if(b)a([]);else if(c.Typekit&&c.Typekit.config&&c.Typekit.config.fn){b=c.Typekit.config.fn;for(var e=[],f=0;f<b.length;f+=2)for(var g=b[f],m=b[f+1],h=0;h<m.length;h++)e.push(new G(g,m[h]));try{c.Typekit.load({events:!1,classes:!1,async:!0})}catch(l){}a(e)}},2E3):a([])};function Ha(a,b){this.c=a;this.f=b;this.a=[]}Ha.prototype.load=function(a){var b=this.f.id,c=this.c.o,d=this;b?(c.__webfontfontdeckmodule__||(c.__webfontfontdeckmodule__={}),c.__webfontfontdeckmodule__[b]=function(b,c){for(var g=0,m=c.fonts.length;g<m;++g){var h=c.fonts[g];d.a.push(new G(h.name,ga("font-weight:"+h.weight+";font-style:"+h.style)))}a(d.a)},A(this.c,(this.f.api||"https://f.fontdeck.com/s/css/js/")+ea(this.c)+"/"+b+".js",function(b){b&&a([])})):a([])};var Y=new oa(window);Y.a.c.custom=function(a,b){return new sa(b,a)};Y.a.c.fontdeck=function(a,b){return new Ha(b,a)};Y.a.c.monotype=function(a,b){return new ra(b,a)};Y.a.c.typekit=function(a,b){return new Ga(b,a)};Y.a.c.google=function(a,b){return new Ea(b,a)};var Z={load:p(Y.load,Y)}; true?!(__WEBPACK_AMD_DEFINE_RESULT__ = (function(){return Z}).call(exports, __webpack_require__, exports, module),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)):0;}());


/***/ }),

/***/ "./node_modules/@react-spring/animated/dist/react-spring-animated.esm.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@react-spring/animated/dist/react-spring-animated.esm.js ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Animated": function() { return /* binding */ Animated; },
/* harmony export */   "AnimatedArray": function() { return /* binding */ AnimatedArray; },
/* harmony export */   "AnimatedObject": function() { return /* binding */ AnimatedObject; },
/* harmony export */   "AnimatedString": function() { return /* binding */ AnimatedString; },
/* harmony export */   "AnimatedValue": function() { return /* binding */ AnimatedValue; },
/* harmony export */   "createHost": function() { return /* binding */ createHost; },
/* harmony export */   "getAnimated": function() { return /* binding */ getAnimated; },
/* harmony export */   "getAnimatedType": function() { return /* binding */ getAnimatedType; },
/* harmony export */   "getPayload": function() { return /* binding */ getPayload; },
/* harmony export */   "isAnimated": function() { return /* binding */ isAnimated; },
/* harmony export */   "setAnimated": function() { return /* binding */ setAnimated; }
/* harmony export */ });
/* harmony import */ var _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @react-spring/shared */ "./node_modules/@react-spring/shared/dist/react-spring-shared.esm.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);




const $node = Symbol.for('Animated:node');
const isAnimated = value => !!value && value[$node] === value;
const getAnimated = owner => owner && owner[$node];
const setAnimated = (owner, node) => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.defineHidden)(owner, $node, node);
const getPayload = owner => owner && owner[$node] && owner[$node].getPayload();
class Animated {
  constructor() {
    this.payload = void 0;
    setAnimated(this, this);
  }

  getPayload() {
    return this.payload || [];
  }

}

class AnimatedValue extends Animated {
  constructor(_value) {
    super();
    this.done = true;
    this.elapsedTime = void 0;
    this.lastPosition = void 0;
    this.lastVelocity = void 0;
    this.v0 = void 0;
    this.durationProgress = 0;
    this._value = _value;

    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.num(this._value)) {
      this.lastPosition = this._value;
    }
  }

  static create(value) {
    return new AnimatedValue(value);
  }

  getPayload() {
    return [this];
  }

  getValue() {
    return this._value;
  }

  setValue(value, step) {
    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.num(value)) {
      this.lastPosition = value;

      if (step) {
        value = Math.round(value / step) * step;

        if (this.done) {
          this.lastPosition = value;
        }
      }
    }

    if (this._value === value) {
      return false;
    }

    this._value = value;
    return true;
  }

  reset() {
    const {
      done
    } = this;
    this.done = false;

    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.num(this._value)) {
      this.elapsedTime = 0;
      this.durationProgress = 0;
      this.lastPosition = this._value;
      if (done) this.lastVelocity = null;
      this.v0 = null;
    }
  }

}

class AnimatedString extends AnimatedValue {
  constructor(value) {
    super(0);
    this._string = null;
    this._toString = void 0;
    this._toString = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.createInterpolator)({
      output: [value, value]
    });
  }

  static create(value) {
    return new AnimatedString(value);
  }

  getValue() {
    let value = this._string;
    return value == null ? this._string = this._toString(this._value) : value;
  }

  setValue(value) {
    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.str(value)) {
      if (value == this._string) {
        return false;
      }

      this._string = value;
      this._value = 1;
    } else if (super.setValue(value)) {
      this._string = null;
    } else {
      return false;
    }

    return true;
  }

  reset(goal) {
    if (goal) {
      this._toString = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.createInterpolator)({
        output: [this.getValue(), goal]
      });
    }

    this._value = 0;
    super.reset();
  }

}

const TreeContext = {
  dependencies: null
};

class AnimatedObject extends Animated {
  constructor(source) {
    super();
    this.source = source;
    this.setValue(source);
  }

  getValue(animated) {
    const values = {};
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(this.source, (source, key) => {
      if (isAnimated(source)) {
        values[key] = source.getValue(animated);
      } else if ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(source)) {
        values[key] = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(source);
      } else if (!animated) {
        values[key] = source;
      }
    });
    return values;
  }

  setValue(source) {
    this.source = source;
    this.payload = this._makePayload(source);
  }

  reset() {
    if (this.payload) {
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(this.payload, node => node.reset());
    }
  }

  _makePayload(source) {
    if (source) {
      const payload = new Set();
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(source, this._addToPayload, payload);
      return Array.from(payload);
    }
  }

  _addToPayload(source) {
    if (TreeContext.dependencies && (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(source)) {
      TreeContext.dependencies.add(source);
    }

    const payload = getPayload(source);

    if (payload) {
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(payload, node => this.add(node));
    }
  }

}

class AnimatedArray extends AnimatedObject {
  constructor(source) {
    super(source);
  }

  static create(source) {
    return new AnimatedArray(source);
  }

  getValue() {
    return this.source.map(node => node.getValue());
  }

  setValue(source) {
    const payload = this.getPayload();

    if (source.length == payload.length) {
      return payload.map((node, i) => node.setValue(source[i])).some(Boolean);
    }

    super.setValue(source.map(makeAnimated));
    return true;
  }

}

function makeAnimated(value) {
  const nodeType = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isAnimatedString)(value) ? AnimatedString : AnimatedValue;
  return nodeType.create(value);
}

function getAnimatedType(value) {
  const parentNode = getAnimated(value);
  return parentNode ? parentNode.constructor : _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(value) ? AnimatedArray : (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isAnimatedString)(value) ? AnimatedString : AnimatedValue;
}

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

const withAnimated = (Component, host) => {
  const hasInstance = !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(Component) || Component.prototype && Component.prototype.isReactComponent;
  return (0,react__WEBPACK_IMPORTED_MODULE_1__.forwardRef)((givenProps, givenRef) => {
    const instanceRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(null);
    const ref = hasInstance && (0,react__WEBPACK_IMPORTED_MODULE_1__.useCallback)(value => {
      instanceRef.current = updateRef(givenRef, value);
    }, [givenRef]);
    const [props, deps] = getAnimatedState(givenProps, host);
    const forceUpdate = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useForceUpdate)();

    const callback = () => {
      const instance = instanceRef.current;

      if (hasInstance && !instance) {
        return;
      }

      const didUpdate = instance ? host.applyAnimatedValues(instance, props.getValue(true)) : false;

      if (didUpdate === false) {
        forceUpdate();
      }
    };

    const observer = new PropsObserver(callback, deps);
    const observerRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)();
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => {
      observerRef.current = observer;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(deps, dep => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.addFluidObserver)(dep, observer));
      return () => {
        if (observerRef.current) {
          (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(observerRef.current.deps, dep => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.removeFluidObserver)(dep, observerRef.current));
          _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.cancel(observerRef.current.update);
        }
      };
    });
    (0,react__WEBPACK_IMPORTED_MODULE_1__.useEffect)(callback, []);
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useOnce)(() => () => {
      const observer = observerRef.current;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(observer.deps, dep => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.removeFluidObserver)(dep, observer));
    });
    const usedProps = host.getComponentProps(props.getValue());
    return react__WEBPACK_IMPORTED_MODULE_1__.createElement(Component, _extends({}, usedProps, {
      ref: ref
    }));
  });
};

class PropsObserver {
  constructor(update, deps) {
    this.update = update;
    this.deps = deps;
  }

  eventObserved(event) {
    if (event.type == 'change') {
      _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.write(this.update);
    }
  }

}

function getAnimatedState(props, host) {
  const dependencies = new Set();
  TreeContext.dependencies = dependencies;
  if (props.style) props = _extends({}, props, {
    style: host.createAnimatedStyle(props.style)
  });
  props = new AnimatedObject(props);
  TreeContext.dependencies = null;
  return [props, dependencies];
}

function updateRef(ref, value) {
  if (ref) {
    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(ref)) ref(value);else ref.current = value;
  }

  return value;
}

const cacheKey = Symbol.for('AnimatedComponent');
const createHost = (components, {
  applyAnimatedValues: _applyAnimatedValues = () => false,
  createAnimatedStyle: _createAnimatedStyle = style => new AnimatedObject(style),
  getComponentProps: _getComponentProps = props => props
} = {}) => {
  const hostConfig = {
    applyAnimatedValues: _applyAnimatedValues,
    createAnimatedStyle: _createAnimatedStyle,
    getComponentProps: _getComponentProps
  };

  const animated = Component => {
    const displayName = getDisplayName(Component) || 'Anonymous';

    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.str(Component)) {
      Component = animated[Component] || (animated[Component] = withAnimated(Component, hostConfig));
    } else {
      Component = Component[cacheKey] || (Component[cacheKey] = withAnimated(Component, hostConfig));
    }

    Component.displayName = `Animated(${displayName})`;
    return Component;
  };

  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(components, (Component, key) => {
    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(components)) {
      key = getDisplayName(Component);
    }

    animated[key] = animated(Component);
  });
  return {
    animated
  };
};

const getDisplayName = arg => _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.str(arg) ? arg : arg && _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.str(arg.displayName) ? arg.displayName : _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(arg) && arg.name || null;




/***/ }),

/***/ "./node_modules/@react-spring/core/dist/react-spring-core.esm.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@react-spring/core/dist/react-spring-core.esm.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BailSignal": function() { return /* binding */ BailSignal; },
/* harmony export */   "Controller": function() { return /* binding */ Controller; },
/* harmony export */   "FrameValue": function() { return /* binding */ FrameValue; },
/* harmony export */   "Globals": function() { return /* reexport safe */ _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals; },
/* harmony export */   "Interpolation": function() { return /* binding */ Interpolation; },
/* harmony export */   "Spring": function() { return /* binding */ Spring; },
/* harmony export */   "SpringContext": function() { return /* binding */ SpringContext; },
/* harmony export */   "SpringRef": function() { return /* binding */ SpringRef; },
/* harmony export */   "SpringValue": function() { return /* binding */ SpringValue; },
/* harmony export */   "Trail": function() { return /* binding */ Trail; },
/* harmony export */   "Transition": function() { return /* binding */ Transition; },
/* harmony export */   "config": function() { return /* binding */ config; },
/* harmony export */   "createInterpolator": function() { return /* reexport safe */ _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.createInterpolator; },
/* harmony export */   "easings": function() { return /* binding */ easings; },
/* harmony export */   "inferTo": function() { return /* binding */ inferTo; },
/* harmony export */   "interpolate": function() { return /* binding */ interpolate; },
/* harmony export */   "to": function() { return /* binding */ to; },
/* harmony export */   "update": function() { return /* binding */ update; },
/* harmony export */   "useChain": function() { return /* binding */ useChain; },
/* harmony export */   "useIsomorphicLayoutEffect": function() { return /* reexport safe */ _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect; },
/* harmony export */   "useReducedMotion": function() { return /* reexport safe */ _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useReducedMotion; },
/* harmony export */   "useSpring": function() { return /* binding */ useSpring; },
/* harmony export */   "useSpringRef": function() { return /* binding */ useSpringRef; },
/* harmony export */   "useSprings": function() { return /* binding */ useSprings; },
/* harmony export */   "useTrail": function() { return /* binding */ useTrail; },
/* harmony export */   "useTransition": function() { return /* binding */ useTransition; }
/* harmony export */ });
/* harmony import */ var _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @react-spring/shared */ "./node_modules/@react-spring/shared/dist/react-spring-shared.esm.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _react_spring_animated__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @react-spring/animated */ "./node_modules/@react-spring/animated/dist/react-spring-animated.esm.js");
/* harmony import */ var _react_spring_types_animated__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @react-spring/types/animated */ "./node_modules/@react-spring/types/animated.js");
/* harmony import */ var _react_spring_types_animated__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_react_spring_types_animated__WEBPACK_IMPORTED_MODULE_3__);
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _react_spring_types_animated__WEBPACK_IMPORTED_MODULE_3__) if(["default","Globals","createInterpolator","useIsomorphicLayoutEffect","useReducedMotion","BailSignal","Controller","FrameValue","Interpolation","Spring","SpringContext","SpringRef","SpringValue","Trail","Transition","config","easings","inferTo","interpolate","to","update","useChain","useSpring","useSpringRef","useSprings","useTrail","useTransition"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = function(key) { return _react_spring_types_animated__WEBPACK_IMPORTED_MODULE_3__[key]; }.bind(0, __WEBPACK_IMPORT_KEY__)
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
/* harmony import */ var _react_spring_types_interpolation__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @react-spring/types/interpolation */ "./node_modules/@react-spring/types/interpolation.js");
/* harmony import */ var _react_spring_types_interpolation__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_react_spring_types_interpolation__WEBPACK_IMPORTED_MODULE_4__);
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _react_spring_types_interpolation__WEBPACK_IMPORTED_MODULE_4__) if(["default","Globals","createInterpolator","useIsomorphicLayoutEffect","useReducedMotion","BailSignal","Controller","FrameValue","Interpolation","Spring","SpringContext","SpringRef","SpringValue","Trail","Transition","config","easings","inferTo","interpolate","to","update","useChain","useSpring","useSpringRef","useSprings","useTrail","useTransition"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = function(key) { return _react_spring_types_interpolation__WEBPACK_IMPORTED_MODULE_4__[key]; }.bind(0, __WEBPACK_IMPORT_KEY__)
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);








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

function callProp(value, ...args) {
  return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(value) ? value(...args) : value;
}
const matchProp = (value, key) => value === true || !!(key && value && (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(value) ? value(key) : (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(value).includes(key)));
const resolveProp = (prop, key) => _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(prop) ? key && prop[key] : prop;
const getDefaultProp = (props, key) => props.default === true ? props[key] : props.default ? props.default[key] : undefined;

const noopTransform = value => value;

const getDefaultProps = (props, transform = noopTransform) => {
  let keys = DEFAULT_PROPS;

  if (props.default && props.default !== true) {
    props = props.default;
    keys = Object.keys(props);
  }

  const defaults = {};

  for (const key of keys) {
    const value = transform(props[key], key);

    if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(value)) {
      defaults[key] = value;
    }
  }

  return defaults;
};
const DEFAULT_PROPS = ['config', 'onProps', 'onStart', 'onChange', 'onPause', 'onResume', 'onRest'];
const RESERVED_PROPS = {
  config: 1,
  from: 1,
  to: 1,
  ref: 1,
  loop: 1,
  reset: 1,
  pause: 1,
  cancel: 1,
  reverse: 1,
  immediate: 1,
  default: 1,
  delay: 1,
  onProps: 1,
  onStart: 1,
  onChange: 1,
  onPause: 1,
  onResume: 1,
  onRest: 1,
  onResolve: 1,
  items: 1,
  trail: 1,
  sort: 1,
  expires: 1,
  initial: 1,
  enter: 1,
  update: 1,
  leave: 1,
  children: 1,
  onDestroyed: 1,
  keys: 1,
  callId: 1,
  parentId: 1
};

function getForwardProps(props) {
  const forward = {};
  let count = 0;
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(props, (value, prop) => {
    if (!RESERVED_PROPS[prop]) {
      forward[prop] = value;
      count++;
    }
  });

  if (count) {
    return forward;
  }
}

function inferTo(props) {
  const to = getForwardProps(props);

  if (to) {
    const out = {
      to
    };
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(props, (val, key) => key in to || (out[key] = val));
    return out;
  }

  return _extends({}, props);
}
function computeGoal(value) {
  value = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(value);
  return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(value) ? value.map(computeGoal) : (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isAnimatedString)(value) ? _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.createStringInterpolator({
    range: [0, 1],
    output: [value, value]
  })(1) : value;
}
function hasProps(props) {
  for (const _ in props) return true;

  return false;
}
function isAsyncTo(to) {
  return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(to) || _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(to) && _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(to[0]);
}
function detachRefs(ctrl, ref) {
  var _ctrl$ref;

  (_ctrl$ref = ctrl.ref) == null ? void 0 : _ctrl$ref.delete(ctrl);
  ref == null ? void 0 : ref.delete(ctrl);
}
function replaceRef(ctrl, ref) {
  if (ref && ctrl.ref !== ref) {
    var _ctrl$ref2;

    (_ctrl$ref2 = ctrl.ref) == null ? void 0 : _ctrl$ref2.delete(ctrl);
    ref.add(ctrl);
    ctrl.ref = ref;
  }
}

function useChain(refs, timeSteps, timeFrame = 1000) {
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => {
    if (timeSteps) {
      let prevDelay = 0;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(refs, (ref, i) => {
        const controllers = ref.current;

        if (controllers.length) {
          let delay = timeFrame * timeSteps[i];
          if (isNaN(delay)) delay = prevDelay;else prevDelay = delay;
          (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(controllers, ctrl => {
            (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(ctrl.queue, props => {
              const memoizedDelayProp = props.delay;

              props.delay = key => delay + callProp(memoizedDelayProp || 0, key);
            });
          });
          ref.start();
        }
      });
    } else {
      let p = Promise.resolve();
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(refs, ref => {
        const controllers = ref.current;

        if (controllers.length) {
          const queues = controllers.map(ctrl => {
            const q = ctrl.queue;
            ctrl.queue = [];
            return q;
          });
          p = p.then(() => {
            (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(controllers, (ctrl, i) => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(queues[i] || [], update => ctrl.queue.push(update)));
            return Promise.all(ref.start());
          });
        }
      });
    }
  });
}

const config = {
  default: {
    tension: 170,
    friction: 26
  },
  gentle: {
    tension: 120,
    friction: 14
  },
  wobbly: {
    tension: 180,
    friction: 12
  },
  stiff: {
    tension: 210,
    friction: 20
  },
  slow: {
    tension: 280,
    friction: 60
  },
  molasses: {
    tension: 280,
    friction: 120
  }
};
const c1 = 1.70158;
const c2 = c1 * 1.525;
const c3 = c1 + 1;
const c4 = 2 * Math.PI / 3;
const c5 = 2 * Math.PI / 4.5;

const bounceOut = x => {
  const n1 = 7.5625;
  const d1 = 2.75;

  if (x < 1 / d1) {
    return n1 * x * x;
  } else if (x < 2 / d1) {
    return n1 * (x -= 1.5 / d1) * x + 0.75;
  } else if (x < 2.5 / d1) {
    return n1 * (x -= 2.25 / d1) * x + 0.9375;
  } else {
    return n1 * (x -= 2.625 / d1) * x + 0.984375;
  }
};

const easings = {
  linear: x => x,
  easeInQuad: x => x * x,
  easeOutQuad: x => 1 - (1 - x) * (1 - x),
  easeInOutQuad: x => x < 0.5 ? 2 * x * x : 1 - Math.pow(-2 * x + 2, 2) / 2,
  easeInCubic: x => x * x * x,
  easeOutCubic: x => 1 - Math.pow(1 - x, 3),
  easeInOutCubic: x => x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2,
  easeInQuart: x => x * x * x * x,
  easeOutQuart: x => 1 - Math.pow(1 - x, 4),
  easeInOutQuart: x => x < 0.5 ? 8 * x * x * x * x : 1 - Math.pow(-2 * x + 2, 4) / 2,
  easeInQuint: x => x * x * x * x * x,
  easeOutQuint: x => 1 - Math.pow(1 - x, 5),
  easeInOutQuint: x => x < 0.5 ? 16 * x * x * x * x * x : 1 - Math.pow(-2 * x + 2, 5) / 2,
  easeInSine: x => 1 - Math.cos(x * Math.PI / 2),
  easeOutSine: x => Math.sin(x * Math.PI / 2),
  easeInOutSine: x => -(Math.cos(Math.PI * x) - 1) / 2,
  easeInExpo: x => x === 0 ? 0 : Math.pow(2, 10 * x - 10),
  easeOutExpo: x => x === 1 ? 1 : 1 - Math.pow(2, -10 * x),
  easeInOutExpo: x => x === 0 ? 0 : x === 1 ? 1 : x < 0.5 ? Math.pow(2, 20 * x - 10) / 2 : (2 - Math.pow(2, -20 * x + 10)) / 2,
  easeInCirc: x => 1 - Math.sqrt(1 - Math.pow(x, 2)),
  easeOutCirc: x => Math.sqrt(1 - Math.pow(x - 1, 2)),
  easeInOutCirc: x => x < 0.5 ? (1 - Math.sqrt(1 - Math.pow(2 * x, 2))) / 2 : (Math.sqrt(1 - Math.pow(-2 * x + 2, 2)) + 1) / 2,
  easeInBack: x => c3 * x * x * x - c1 * x * x,
  easeOutBack: x => 1 + c3 * Math.pow(x - 1, 3) + c1 * Math.pow(x - 1, 2),
  easeInOutBack: x => x < 0.5 ? Math.pow(2 * x, 2) * ((c2 + 1) * 2 * x - c2) / 2 : (Math.pow(2 * x - 2, 2) * ((c2 + 1) * (x * 2 - 2) + c2) + 2) / 2,
  easeInElastic: x => x === 0 ? 0 : x === 1 ? 1 : -Math.pow(2, 10 * x - 10) * Math.sin((x * 10 - 10.75) * c4),
  easeOutElastic: x => x === 0 ? 0 : x === 1 ? 1 : Math.pow(2, -10 * x) * Math.sin((x * 10 - 0.75) * c4) + 1,
  easeInOutElastic: x => x === 0 ? 0 : x === 1 ? 1 : x < 0.5 ? -(Math.pow(2, 20 * x - 10) * Math.sin((20 * x - 11.125) * c5)) / 2 : Math.pow(2, -20 * x + 10) * Math.sin((20 * x - 11.125) * c5) / 2 + 1,
  easeInBounce: x => 1 - bounceOut(1 - x),
  easeOutBounce: bounceOut,
  easeInOutBounce: x => x < 0.5 ? (1 - bounceOut(1 - 2 * x)) / 2 : (1 + bounceOut(2 * x - 1)) / 2
};

const defaults = _extends({}, config.default, {
  mass: 1,
  damping: 1,
  easing: easings.linear,
  clamp: false
});

class AnimationConfig {
  constructor() {
    this.tension = void 0;
    this.friction = void 0;
    this.frequency = void 0;
    this.damping = void 0;
    this.mass = void 0;
    this.velocity = 0;
    this.restVelocity = void 0;
    this.precision = void 0;
    this.progress = void 0;
    this.duration = void 0;
    this.easing = void 0;
    this.clamp = void 0;
    this.bounce = void 0;
    this.decay = void 0;
    this.round = void 0;
    Object.assign(this, defaults);
  }

}
function mergeConfig(config, newConfig, defaultConfig) {
  if (defaultConfig) {
    defaultConfig = _extends({}, defaultConfig);
    sanitizeConfig(defaultConfig, newConfig);
    newConfig = _extends({}, defaultConfig, newConfig);
  }

  sanitizeConfig(config, newConfig);
  Object.assign(config, newConfig);

  for (const key in defaults) {
    if (config[key] == null) {
      config[key] = defaults[key];
    }
  }

  let {
    mass,
    frequency,
    damping
  } = config;

  if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(frequency)) {
    if (frequency < 0.01) frequency = 0.01;
    if (damping < 0) damping = 0;
    config.tension = Math.pow(2 * Math.PI / frequency, 2) * mass;
    config.friction = 4 * Math.PI * damping * mass / frequency;
  }

  return config;
}

function sanitizeConfig(config, props) {
  if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.decay)) {
    config.duration = undefined;
  } else {
    const isTensionConfig = !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.tension) || !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.friction);

    if (isTensionConfig || !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.frequency) || !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.damping) || !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.mass)) {
      config.duration = undefined;
      config.decay = undefined;
    }

    if (isTensionConfig) {
      config.frequency = undefined;
    }
  }
}

const emptyArray = [];
class Animation {
  constructor() {
    this.changed = false;
    this.values = emptyArray;
    this.toValues = null;
    this.fromValues = emptyArray;
    this.to = void 0;
    this.from = void 0;
    this.config = new AnimationConfig();
    this.immediate = false;
  }

}

function scheduleProps(callId, {
  key,
  props,
  defaultProps,
  state,
  actions
}) {
  return new Promise((resolve, reject) => {
    var _props$cancel;

    let delay;
    let timeout;
    let cancel = matchProp((_props$cancel = props.cancel) != null ? _props$cancel : defaultProps == null ? void 0 : defaultProps.cancel, key);

    if (cancel) {
      onStart();
    } else {
      if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.pause)) {
        state.paused = matchProp(props.pause, key);
      }

      let pause = defaultProps == null ? void 0 : defaultProps.pause;

      if (pause !== true) {
        pause = state.paused || matchProp(pause, key);
      }

      delay = callProp(props.delay || 0, key);

      if (pause) {
        state.resumeQueue.add(onResume);
        actions.pause();
      } else {
        actions.resume();
        onResume();
      }
    }

    function onPause() {
      state.resumeQueue.add(onResume);
      state.timeouts.delete(timeout);
      timeout.cancel();
      delay = timeout.time - _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.now();
    }

    function onResume() {
      if (delay > 0 && !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.skipAnimation) {
        state.delayed = true;
        timeout = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.setTimeout(onStart, delay);
        state.pauseQueue.add(onPause);
        state.timeouts.add(timeout);
      } else {
        onStart();
      }
    }

    function onStart() {
      if (state.delayed) {
        state.delayed = false;
      }

      state.pauseQueue.delete(onPause);
      state.timeouts.delete(timeout);

      if (callId <= (state.cancelId || 0)) {
        cancel = true;
      }

      try {
        actions.start(_extends({}, props, {
          callId,
          cancel
        }), resolve);
      } catch (err) {
        reject(err);
      }
    }
  });
}

const getCombinedResult = (target, results) => results.length == 1 ? results[0] : results.some(result => result.cancelled) ? getCancelledResult(target.get()) : results.every(result => result.noop) ? getNoopResult(target.get()) : getFinishedResult(target.get(), results.every(result => result.finished));
const getNoopResult = value => ({
  value,
  noop: true,
  finished: true,
  cancelled: false
});
const getFinishedResult = (value, finished, cancelled = false) => ({
  value,
  finished,
  cancelled
});
const getCancelledResult = value => ({
  value,
  cancelled: true,
  finished: false
});

function runAsync(to, props, state, target) {
  const {
    callId,
    parentId,
    onRest
  } = props;
  const {
    asyncTo: prevTo,
    promise: prevPromise
  } = state;

  if (!parentId && to === prevTo && !props.reset) {
    return prevPromise;
  }

  return state.promise = (async () => {
    state.asyncId = callId;
    state.asyncTo = to;
    const defaultProps = getDefaultProps(props, (value, key) => key === 'onRest' ? undefined : value);
    let preventBail;
    let bail;
    const bailPromise = new Promise((resolve, reject) => (preventBail = resolve, bail = reject));

    const bailIfEnded = bailSignal => {
      const bailResult = callId <= (state.cancelId || 0) && getCancelledResult(target) || callId !== state.asyncId && getFinishedResult(target, false);

      if (bailResult) {
        bailSignal.result = bailResult;
        bail(bailSignal);
        throw bailSignal;
      }
    };

    const animate = (arg1, arg2) => {
      const bailSignal = new BailSignal();
      const skipAnimationSignal = new SkipAniamtionSignal();
      return (async () => {
        if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.skipAnimation) {
          stopAsync(state);
          skipAnimationSignal.result = getFinishedResult(target, false);
          bail(skipAnimationSignal);
          throw skipAnimationSignal;
        }

        bailIfEnded(bailSignal);
        const props = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(arg1) ? _extends({}, arg1) : _extends({}, arg2, {
          to: arg1
        });
        props.parentId = callId;
        (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(defaultProps, (value, key) => {
          if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props[key])) {
            props[key] = value;
          }
        });
        const result = await target.start(props);
        bailIfEnded(bailSignal);

        if (state.paused) {
          await new Promise(resume => {
            state.resumeQueue.add(resume);
          });
        }

        return result;
      })();
    };

    let result;

    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.skipAnimation) {
      stopAsync(state);
      return getFinishedResult(target, false);
    }

    try {
      let animating;

      if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(to)) {
        animating = (async queue => {
          for (const props of queue) {
            await animate(props);
          }
        })(to);
      } else {
        animating = Promise.resolve(to(animate, target.stop.bind(target)));
      }

      await Promise.all([animating.then(preventBail), bailPromise]);
      result = getFinishedResult(target.get(), true, false);
    } catch (err) {
      if (err instanceof BailSignal) {
        result = err.result;
      } else if (err instanceof SkipAniamtionSignal) {
        result = err.result;
      } else {
        throw err;
      }
    } finally {
      if (callId == state.asyncId) {
        state.asyncId = parentId;
        state.asyncTo = parentId ? prevTo : undefined;
        state.promise = parentId ? prevPromise : undefined;
      }
    }

    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(onRest)) {
      _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => {
        onRest(result, target, target.item);
      });
    }

    return result;
  })();
}
function stopAsync(state, cancelId) {
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flush)(state.timeouts, t => t.cancel());
  state.pauseQueue.clear();
  state.resumeQueue.clear();
  state.asyncId = state.asyncTo = state.promise = undefined;
  if (cancelId) state.cancelId = cancelId;
}
class BailSignal extends Error {
  constructor() {
    super('An async animation has been interrupted. You see this error because you ' + 'forgot to use `await` or `.catch(...)` on its returned promise.');
    this.result = void 0;
  }

}
class SkipAniamtionSignal extends Error {
  constructor() {
    super('SkipAnimationSignal');
    this.result = void 0;
  }

}

const isFrameValue = value => value instanceof FrameValue;
let nextId$1 = 1;
class FrameValue extends _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.FluidValue {
  constructor(...args) {
    super(...args);
    this.id = nextId$1++;
    this.key = void 0;
    this._priority = 0;
  }

  get priority() {
    return this._priority;
  }

  set priority(priority) {
    if (this._priority != priority) {
      this._priority = priority;

      this._onPriorityChange(priority);
    }
  }

  get() {
    const node = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this);
    return node && node.getValue();
  }

  to(...args) {
    return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.to(this, args);
  }

  interpolate(...args) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.deprecateInterpolate)();
    return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.to(this, args);
  }

  toJSON() {
    return this.get();
  }

  observerAdded(count) {
    if (count == 1) this._attach();
  }

  observerRemoved(count) {
    if (count == 0) this._detach();
  }

  _attach() {}

  _detach() {}

  _onChange(value, idle = false) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.callFluidObservers)(this, {
      type: 'change',
      parent: this,
      value,
      idle
    });
  }

  _onPriorityChange(priority) {
    if (!this.idle) {
      _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.frameLoop.sort(this);
    }

    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.callFluidObservers)(this, {
      type: 'priority',
      parent: this,
      priority
    });
  }

}

const $P = Symbol.for('SpringPhase');
const HAS_ANIMATED = 1;
const IS_ANIMATING = 2;
const IS_PAUSED = 4;
const hasAnimated = target => (target[$P] & HAS_ANIMATED) > 0;
const isAnimating = target => (target[$P] & IS_ANIMATING) > 0;
const isPaused = target => (target[$P] & IS_PAUSED) > 0;
const setActiveBit = (target, active) => active ? target[$P] |= IS_ANIMATING | HAS_ANIMATED : target[$P] &= ~IS_ANIMATING;
const setPausedBit = (target, paused) => paused ? target[$P] |= IS_PAUSED : target[$P] &= ~IS_PAUSED;

class SpringValue extends FrameValue {
  constructor(arg1, arg2) {
    super();
    this.key = void 0;
    this.animation = new Animation();
    this.queue = void 0;
    this.defaultProps = {};
    this._state = {
      paused: false,
      delayed: false,
      pauseQueue: new Set(),
      resumeQueue: new Set(),
      timeouts: new Set()
    };
    this._pendingCalls = new Set();
    this._lastCallId = 0;
    this._lastToId = 0;
    this._memoizedDuration = 0;

    if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(arg1) || !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(arg2)) {
      const props = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(arg1) ? _extends({}, arg1) : _extends({}, arg2, {
        from: arg1
      });

      if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.default)) {
        props.default = true;
      }

      this.start(props);
    }
  }

  get idle() {
    return !(isAnimating(this) || this._state.asyncTo) || isPaused(this);
  }

  get goal() {
    return (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(this.animation.to);
  }

  get velocity() {
    const node = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this);
    return node instanceof _react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.AnimatedValue ? node.lastVelocity || 0 : node.getPayload().map(node => node.lastVelocity || 0);
  }

  get hasAnimated() {
    return hasAnimated(this);
  }

  get isAnimating() {
    return isAnimating(this);
  }

  get isPaused() {
    return isPaused(this);
  }

  get isDelayed() {
    return this._state.delayed;
  }

  advance(dt) {
    let idle = true;
    let changed = false;
    const anim = this.animation;
    let {
      config,
      toValues
    } = anim;
    const payload = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getPayload)(anim.to);

    if (!payload && (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(anim.to)) {
      toValues = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(anim.to));
    }

    anim.values.forEach((node, i) => {
      if (node.done) return;
      const to = node.constructor == _react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.AnimatedString ? 1 : payload ? payload[i].lastPosition : toValues[i];
      let finished = anim.immediate;
      let position = to;

      if (!finished) {
        position = node.lastPosition;

        if (config.tension <= 0) {
          node.done = true;
          return;
        }

        let elapsed = node.elapsedTime += dt;
        const from = anim.fromValues[i];
        const v0 = node.v0 != null ? node.v0 : node.v0 = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(config.velocity) ? config.velocity[i] : config.velocity;
        let velocity;
        const precision = config.precision || (from == to ? 0.005 : Math.min(1, Math.abs(to - from) * 0.001));

        if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(config.duration)) {
          let p = 1;

          if (config.duration > 0) {
            if (this._memoizedDuration !== config.duration) {
              this._memoizedDuration = config.duration;

              if (node.durationProgress > 0) {
                node.elapsedTime = config.duration * node.durationProgress;
                elapsed = node.elapsedTime += dt;
              }
            }

            p = (config.progress || 0) + elapsed / this._memoizedDuration;
            p = p > 1 ? 1 : p < 0 ? 0 : p;
            node.durationProgress = p;
          }

          position = from + config.easing(p) * (to - from);
          velocity = (position - node.lastPosition) / dt;
          finished = p == 1;
        } else if (config.decay) {
          const decay = config.decay === true ? 0.998 : config.decay;
          const e = Math.exp(-(1 - decay) * elapsed);
          position = from + v0 / (1 - decay) * (1 - e);
          finished = Math.abs(node.lastPosition - position) <= precision;
          velocity = v0 * e;
        } else {
          velocity = node.lastVelocity == null ? v0 : node.lastVelocity;
          const restVelocity = config.restVelocity || precision / 10;
          const bounceFactor = config.clamp ? 0 : config.bounce;
          const canBounce = !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(bounceFactor);
          const isGrowing = from == to ? node.v0 > 0 : from < to;
          let isMoving;
          let isBouncing = false;
          const step = 1;
          const numSteps = Math.ceil(dt / step);

          for (let n = 0; n < numSteps; ++n) {
            isMoving = Math.abs(velocity) > restVelocity;

            if (!isMoving) {
              finished = Math.abs(to - position) <= precision;

              if (finished) {
                break;
              }
            }

            if (canBounce) {
              isBouncing = position == to || position > to == isGrowing;

              if (isBouncing) {
                velocity = -velocity * bounceFactor;
                position = to;
              }
            }

            const springForce = -config.tension * 0.000001 * (position - to);
            const dampingForce = -config.friction * 0.001 * velocity;
            const acceleration = (springForce + dampingForce) / config.mass;
            velocity = velocity + acceleration * step;
            position = position + velocity * step;
          }
        }

        node.lastVelocity = velocity;

        if (Number.isNaN(position)) {
          console.warn(`Got NaN while animating:`, this);
          finished = true;
        }
      }

      if (payload && !payload[i].done) {
        finished = false;
      }

      if (finished) {
        node.done = true;
      } else {
        idle = false;
      }

      if (node.setValue(position, config.round)) {
        changed = true;
      }
    });
    const node = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this);
    const currVal = node.getValue();

    if (idle) {
      const finalVal = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(anim.to);

      if ((currVal !== finalVal || changed) && !config.decay) {
        node.setValue(finalVal);

        this._onChange(finalVal);
      } else if (changed && config.decay) {
        this._onChange(currVal);
      }

      this._stop();
    } else if (changed) {
      this._onChange(currVal);
    }
  }

  set(value) {
    _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => {
      this._stop();

      this._focus(value);

      this._set(value);
    });
    return this;
  }

  pause() {
    this._update({
      pause: true
    });
  }

  resume() {
    this._update({
      pause: false
    });
  }

  finish() {
    if (isAnimating(this)) {
      const {
        to,
        config
      } = this.animation;
      _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => {
        this._onStart();

        if (!config.decay) {
          this._set(to, false);
        }

        this._stop();
      });
    }

    return this;
  }

  update(props) {
    const queue = this.queue || (this.queue = []);
    queue.push(props);
    return this;
  }

  start(to, arg2) {
    let queue;

    if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(to)) {
      queue = [_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(to) ? to : _extends({}, arg2, {
        to
      })];
    } else {
      queue = this.queue || [];
      this.queue = [];
    }

    return Promise.all(queue.map(props => {
      const up = this._update(props);

      return up;
    })).then(results => getCombinedResult(this, results));
  }

  stop(cancel) {
    const {
      to
    } = this.animation;

    this._focus(this.get());

    stopAsync(this._state, cancel && this._lastCallId);
    _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => this._stop(to, cancel));
    return this;
  }

  reset() {
    this._update({
      reset: true
    });
  }

  eventObserved(event) {
    if (event.type == 'change') {
      this._start();
    } else if (event.type == 'priority') {
      this.priority = event.priority + 1;
    }
  }

  _prepareNode(props) {
    const key = this.key || '';
    let {
      to,
      from
    } = props;
    to = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(to) ? to[key] : to;

    if (to == null || isAsyncTo(to)) {
      to = undefined;
    }

    from = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(from) ? from[key] : from;

    if (from == null) {
      from = undefined;
    }

    const range = {
      to,
      from
    };

    if (!hasAnimated(this)) {
      if (props.reverse) [to, from] = [from, to];
      from = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(from);

      if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(from)) {
        this._set(from);
      } else if (!(0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this)) {
        this._set(to);
      }
    }

    return range;
  }

  _update(_ref, isLoop) {
    let props = _extends({}, _ref);

    const {
      key,
      defaultProps
    } = this;
    if (props.default) Object.assign(defaultProps, getDefaultProps(props, (value, prop) => /^on/.test(prop) ? resolveProp(value, key) : value));
    mergeActiveFn(this, props, 'onProps');
    sendEvent(this, 'onProps', props, this);

    const range = this._prepareNode(props);

    if (Object.isFrozen(this)) {
      throw Error('Cannot animate a `SpringValue` object that is frozen. ' + 'Did you forget to pass your component to `animated(...)` before animating its props?');
    }

    const state = this._state;
    return scheduleProps(++this._lastCallId, {
      key,
      props,
      defaultProps,
      state,
      actions: {
        pause: () => {
          if (!isPaused(this)) {
            setPausedBit(this, true);
            (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flushCalls)(state.pauseQueue);
            sendEvent(this, 'onPause', getFinishedResult(this, checkFinished(this, this.animation.to)), this);
          }
        },
        resume: () => {
          if (isPaused(this)) {
            setPausedBit(this, false);

            if (isAnimating(this)) {
              this._resume();
            }

            (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flushCalls)(state.resumeQueue);
            sendEvent(this, 'onResume', getFinishedResult(this, checkFinished(this, this.animation.to)), this);
          }
        },
        start: this._merge.bind(this, range)
      }
    }).then(result => {
      if (props.loop && result.finished && !(isLoop && result.noop)) {
        const nextProps = createLoopUpdate(props);

        if (nextProps) {
          return this._update(nextProps, true);
        }
      }

      return result;
    });
  }

  _merge(range, props, resolve) {
    if (props.cancel) {
      this.stop(true);
      return resolve(getCancelledResult(this));
    }

    const hasToProp = !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(range.to);
    const hasFromProp = !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(range.from);

    if (hasToProp || hasFromProp) {
      if (props.callId > this._lastToId) {
        this._lastToId = props.callId;
      } else {
        return resolve(getCancelledResult(this));
      }
    }

    const {
      key,
      defaultProps,
      animation: anim
    } = this;
    const {
      to: prevTo,
      from: prevFrom
    } = anim;
    let {
      to = prevTo,
      from = prevFrom
    } = range;

    if (hasFromProp && !hasToProp && (!props.default || _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(to))) {
      to = from;
    }

    if (props.reverse) [to, from] = [from, to];
    const hasFromChanged = !(0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(from, prevFrom);

    if (hasFromChanged) {
      anim.from = from;
    }

    from = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(from);
    const hasToChanged = !(0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(to, prevTo);

    if (hasToChanged) {
      this._focus(to);
    }

    const hasAsyncTo = isAsyncTo(props.to);
    const {
      config
    } = anim;
    const {
      decay,
      velocity
    } = config;

    if (hasToProp || hasFromProp) {
      config.velocity = 0;
    }

    if (props.config && !hasAsyncTo) {
      mergeConfig(config, callProp(props.config, key), props.config !== defaultProps.config ? callProp(defaultProps.config, key) : void 0);
    }

    let node = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this);

    if (!node || _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(to)) {
      return resolve(getFinishedResult(this, true));
    }

    const reset = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.reset) ? hasFromProp && !props.default : !_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(from) && matchProp(props.reset, key);
    const value = reset ? from : this.get();
    const goal = computeGoal(to);
    const isAnimatable = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.num(goal) || _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(goal) || (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isAnimatedString)(goal);
    const immediate = !hasAsyncTo && (!isAnimatable || matchProp(defaultProps.immediate || props.immediate, key));

    if (hasToChanged) {
      const nodeType = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimatedType)(to);

      if (nodeType !== node.constructor) {
        if (immediate) {
          node = this._set(goal);
        } else throw Error(`Cannot animate between ${node.constructor.name} and ${nodeType.name}, as the "to" prop suggests`);
      }
    }

    const goalType = node.constructor;
    let started = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(to);
    let finished = false;

    if (!started) {
      const hasValueChanged = reset || !hasAnimated(this) && hasFromChanged;

      if (hasToChanged || hasValueChanged) {
        finished = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(computeGoal(value), goal);
        started = !finished;
      }

      if (!(0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(anim.immediate, immediate) && !immediate || !(0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(config.decay, decay) || !(0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(config.velocity, velocity)) {
        started = true;
      }
    }

    if (finished && isAnimating(this)) {
      if (anim.changed && !reset) {
        started = true;
      } else if (!started) {
        this._stop(prevTo);
      }
    }

    if (!hasAsyncTo) {
      if (started || (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(prevTo)) {
        anim.values = node.getPayload();
        anim.toValues = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(to) ? null : goalType == _react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.AnimatedString ? [1] : (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(goal);
      }

      if (anim.immediate != immediate) {
        anim.immediate = immediate;

        if (!immediate && !reset) {
          this._set(prevTo);
        }
      }

      if (started) {
        const {
          onRest
        } = anim;
        (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(ACTIVE_EVENTS, type => mergeActiveFn(this, props, type));
        const result = getFinishedResult(this, checkFinished(this, prevTo));
        (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flushCalls)(this._pendingCalls, result);

        this._pendingCalls.add(resolve);

        if (anim.changed) _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => {
          anim.changed = !reset;
          onRest == null ? void 0 : onRest(result, this);

          if (reset) {
            callProp(defaultProps.onRest, result);
          } else {
            anim.onStart == null ? void 0 : anim.onStart(result, this);
          }
        });
      }
    }

    if (reset) {
      this._set(value);
    }

    if (hasAsyncTo) {
      resolve(runAsync(props.to, props, this._state, this));
    } else if (started) {
      this._start();
    } else if (isAnimating(this) && !hasToChanged) {
      this._pendingCalls.add(resolve);
    } else {
      resolve(getNoopResult(value));
    }
  }

  _focus(value) {
    const anim = this.animation;

    if (value !== anim.to) {
      if ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidObservers)(this)) {
        this._detach();
      }

      anim.to = value;

      if ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidObservers)(this)) {
        this._attach();
      }
    }
  }

  _attach() {
    let priority = 0;
    const {
      to
    } = this.animation;

    if ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(to)) {
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.addFluidObserver)(to, this);

      if (isFrameValue(to)) {
        priority = to.priority + 1;
      }
    }

    this.priority = priority;
  }

  _detach() {
    const {
      to
    } = this.animation;

    if ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(to)) {
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.removeFluidObserver)(to, this);
    }
  }

  _set(arg, idle = true) {
    const value = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(arg);

    if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(value)) {
      const oldNode = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this);

      if (!oldNode || !(0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(value, oldNode.getValue())) {
        const nodeType = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimatedType)(value);

        if (!oldNode || oldNode.constructor != nodeType) {
          (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.setAnimated)(this, nodeType.create(value));
        } else {
          oldNode.setValue(value);
        }

        if (oldNode) {
          _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => {
            this._onChange(value, idle);
          });
        }
      }
    }

    return (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this);
  }

  _onStart() {
    const anim = this.animation;

    if (!anim.changed) {
      anim.changed = true;
      sendEvent(this, 'onStart', getFinishedResult(this, checkFinished(this, anim.to)), this);
    }
  }

  _onChange(value, idle) {
    if (!idle) {
      this._onStart();

      callProp(this.animation.onChange, value, this);
    }

    callProp(this.defaultProps.onChange, value, this);

    super._onChange(value, idle);
  }

  _start() {
    const anim = this.animation;
    (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this).reset((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(anim.to));

    if (!anim.immediate) {
      anim.fromValues = anim.values.map(node => node.lastPosition);
    }

    if (!isAnimating(this)) {
      setActiveBit(this, true);

      if (!isPaused(this)) {
        this._resume();
      }
    }
  }

  _resume() {
    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.skipAnimation) {
      this.finish();
    } else {
      _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.frameLoop.start(this);
    }
  }

  _stop(goal, cancel) {
    if (isAnimating(this)) {
      setActiveBit(this, false);
      const anim = this.animation;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(anim.values, node => {
        node.done = true;
      });

      if (anim.toValues) {
        anim.onChange = anim.onPause = anim.onResume = undefined;
      }

      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.callFluidObservers)(this, {
        type: 'idle',
        parent: this
      });
      const result = cancel ? getCancelledResult(this.get()) : getFinishedResult(this.get(), checkFinished(this, goal != null ? goal : anim.to));
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flushCalls)(this._pendingCalls, result);

      if (anim.changed) {
        anim.changed = false;
        sendEvent(this, 'onRest', result, this);
      }
    }
  }

}

function checkFinished(target, to) {
  const goal = computeGoal(to);
  const value = computeGoal(target.get());
  return (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(value, goal);
}

function createLoopUpdate(props, loop = props.loop, to = props.to) {
  let loopRet = callProp(loop);

  if (loopRet) {
    const overrides = loopRet !== true && inferTo(loopRet);
    const reverse = (overrides || props).reverse;
    const reset = !overrides || overrides.reset;
    return createUpdate(_extends({}, props, {
      loop,
      default: false,
      pause: undefined,
      to: !reverse || isAsyncTo(to) ? to : undefined,
      from: reset ? props.from : undefined,
      reset
    }, overrides));
  }
}
function createUpdate(props) {
  const {
    to,
    from
  } = props = inferTo(props);
  const keys = new Set();
  if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(to)) findDefined(to, keys);
  if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(from)) findDefined(from, keys);
  props.keys = keys.size ? Array.from(keys) : null;
  return props;
}
function declareUpdate(props) {
  const update = createUpdate(props);

  if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(update.default)) {
    update.default = getDefaultProps(update);
  }

  return update;
}

function findDefined(values, keys) {
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(values, (value, key) => value != null && keys.add(key));
}

const ACTIVE_EVENTS = ['onStart', 'onRest', 'onChange', 'onPause', 'onResume'];

function mergeActiveFn(target, props, type) {
  target.animation[type] = props[type] !== getDefaultProp(props, type) ? resolveProp(props[type], target.key) : undefined;
}

function sendEvent(target, type, ...args) {
  var _target$animation$typ, _target$animation, _target$defaultProps$, _target$defaultProps;

  (_target$animation$typ = (_target$animation = target.animation)[type]) == null ? void 0 : _target$animation$typ.call(_target$animation, ...args);
  (_target$defaultProps$ = (_target$defaultProps = target.defaultProps)[type]) == null ? void 0 : _target$defaultProps$.call(_target$defaultProps, ...args);
}

const BATCHED_EVENTS = ['onStart', 'onChange', 'onRest'];
let nextId = 1;
class Controller {
  constructor(props, flush) {
    this.id = nextId++;
    this.springs = {};
    this.queue = [];
    this.ref = void 0;
    this._flush = void 0;
    this._initialProps = void 0;
    this._lastAsyncId = 0;
    this._active = new Set();
    this._changed = new Set();
    this._started = false;
    this._item = void 0;
    this._state = {
      paused: false,
      pauseQueue: new Set(),
      resumeQueue: new Set(),
      timeouts: new Set()
    };
    this._events = {
      onStart: new Map(),
      onChange: new Map(),
      onRest: new Map()
    };
    this._onFrame = this._onFrame.bind(this);

    if (flush) {
      this._flush = flush;
    }

    if (props) {
      this.start(_extends({
        default: true
      }, props));
    }
  }

  get idle() {
    return !this._state.asyncTo && Object.values(this.springs).every(spring => {
      return spring.idle && !spring.isDelayed && !spring.isPaused;
    });
  }

  get item() {
    return this._item;
  }

  set item(item) {
    this._item = item;
  }

  get() {
    const values = {};
    this.each((spring, key) => values[key] = spring.get());
    return values;
  }

  set(values) {
    for (const key in values) {
      const value = values[key];

      if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(value)) {
        this.springs[key].set(value);
      }
    }
  }

  update(props) {
    if (props) {
      this.queue.push(createUpdate(props));
    }

    return this;
  }

  start(props) {
    let {
      queue
    } = this;

    if (props) {
      queue = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(props).map(createUpdate);
    } else {
      this.queue = [];
    }

    if (this._flush) {
      return this._flush(this, queue);
    }

    prepareKeys(this, queue);
    return flushUpdateQueue(this, queue);
  }

  stop(arg, keys) {
    if (arg !== !!arg) {
      keys = arg;
    }

    if (keys) {
      const springs = this.springs;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(keys), key => springs[key].stop(!!arg));
    } else {
      stopAsync(this._state, this._lastAsyncId);
      this.each(spring => spring.stop(!!arg));
    }

    return this;
  }

  pause(keys) {
    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(keys)) {
      this.start({
        pause: true
      });
    } else {
      const springs = this.springs;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(keys), key => springs[key].pause());
    }

    return this;
  }

  resume(keys) {
    if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(keys)) {
      this.start({
        pause: false
      });
    } else {
      const springs = this.springs;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(keys), key => springs[key].resume());
    }

    return this;
  }

  each(iterator) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(this.springs, iterator);
  }

  _onFrame() {
    const {
      onStart,
      onChange,
      onRest
    } = this._events;
    const active = this._active.size > 0;
    const changed = this._changed.size > 0;

    if (active && !this._started || changed && !this._started) {
      this._started = true;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flush)(onStart, ([onStart, result]) => {
        result.value = this.get();
        onStart(result, this, this._item);
      });
    }

    const idle = !active && this._started;
    const values = changed || idle && onRest.size ? this.get() : null;

    if (changed && onChange.size) {
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flush)(onChange, ([onChange, result]) => {
        result.value = values;
        onChange(result, this, this._item);
      });
    }

    if (idle) {
      this._started = false;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flush)(onRest, ([onRest, result]) => {
        result.value = values;
        onRest(result, this, this._item);
      });
    }
  }

  eventObserved(event) {
    if (event.type == 'change') {
      this._changed.add(event.parent);

      if (!event.idle) {
        this._active.add(event.parent);
      }
    } else if (event.type == 'idle') {
      this._active.delete(event.parent);
    } else return;

    _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.onFrame(this._onFrame);
  }

}
function flushUpdateQueue(ctrl, queue) {
  return Promise.all(queue.map(props => flushUpdate(ctrl, props))).then(results => getCombinedResult(ctrl, results));
}
async function flushUpdate(ctrl, props, isLoop) {
  const {
    keys,
    to,
    from,
    loop,
    onRest,
    onResolve
  } = props;
  const defaults = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(props.default) && props.default;

  if (loop) {
    props.loop = false;
  }

  if (to === false) props.to = null;
  if (from === false) props.from = null;
  const asyncTo = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(to) || _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(to) ? to : undefined;

  if (asyncTo) {
    props.to = undefined;
    props.onRest = undefined;

    if (defaults) {
      defaults.onRest = undefined;
    }
  } else {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(BATCHED_EVENTS, key => {
      const handler = props[key];

      if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(handler)) {
        const queue = ctrl['_events'][key];

        props[key] = ({
          finished,
          cancelled
        }) => {
          const result = queue.get(handler);

          if (result) {
            if (!finished) result.finished = false;
            if (cancelled) result.cancelled = true;
          } else {
            queue.set(handler, {
              value: null,
              finished: finished || false,
              cancelled: cancelled || false
            });
          }
        };

        if (defaults) {
          defaults[key] = props[key];
        }
      }
    });
  }

  const state = ctrl['_state'];

  if (props.pause === !state.paused) {
    state.paused = props.pause;
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.flushCalls)(props.pause ? state.pauseQueue : state.resumeQueue);
  } else if (state.paused) {
    props.pause = true;
  }

  const promises = (keys || Object.keys(ctrl.springs)).map(key => ctrl.springs[key].start(props));
  const cancel = props.cancel === true || getDefaultProp(props, 'cancel') === true;

  if (asyncTo || cancel && state.asyncId) {
    promises.push(scheduleProps(++ctrl['_lastAsyncId'], {
      props,
      state,
      actions: {
        pause: _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.noop,
        resume: _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.noop,

        start(props, resolve) {
          if (cancel) {
            stopAsync(state, ctrl['_lastAsyncId']);
            resolve(getCancelledResult(ctrl));
          } else {
            props.onRest = onRest;
            resolve(runAsync(asyncTo, props, state, ctrl));
          }
        }

      }
    }));
  }

  if (state.paused) {
    await new Promise(resume => {
      state.resumeQueue.add(resume);
    });
  }

  const result = getCombinedResult(ctrl, await Promise.all(promises));

  if (loop && result.finished && !(isLoop && result.noop)) {
    const nextProps = createLoopUpdate(props, loop, to);

    if (nextProps) {
      prepareKeys(ctrl, [nextProps]);
      return flushUpdate(ctrl, nextProps, true);
    }
  }

  if (onResolve) {
    _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => onResolve(result, ctrl, ctrl.item));
  }

  return result;
}
function getSprings(ctrl, props) {
  const springs = _extends({}, ctrl.springs);

  if (props) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(props), props => {
      if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props.keys)) {
        props = createUpdate(props);
      }

      if (!_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(props.to)) {
        props = _extends({}, props, {
          to: undefined
        });
      }

      prepareSprings(springs, props, key => {
        return createSpring(key);
      });
    });
  }

  setSprings(ctrl, springs);
  return springs;
}
function setSprings(ctrl, springs) {
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.eachProp)(springs, (spring, key) => {
    if (!ctrl.springs[key]) {
      ctrl.springs[key] = spring;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.addFluidObserver)(spring, ctrl);
    }
  });
}

function createSpring(key, observer) {
  const spring = new SpringValue();
  spring.key = key;

  if (observer) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.addFluidObserver)(spring, observer);
  }

  return spring;
}

function prepareSprings(springs, props, create) {
  if (props.keys) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(props.keys, key => {
      const spring = springs[key] || (springs[key] = create(key));
      spring['_prepareNode'](props);
    });
  }
}

function prepareKeys(ctrl, queue) {
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(queue, props => {
    prepareSprings(ctrl.springs, props, key => {
      return createSpring(key, ctrl);
    });
  });
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

const _excluded$3 = ["children"];
const SpringContext = _ref => {
  let {
    children
  } = _ref,
      props = _objectWithoutPropertiesLoose(_ref, _excluded$3);

  const inherited = (0,react__WEBPACK_IMPORTED_MODULE_1__.useContext)(ctx);
  const pause = props.pause || !!inherited.pause,
        immediate = props.immediate || !!inherited.immediate;
  props = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useMemoOne)(() => ({
    pause,
    immediate
  }), [pause, immediate]);
  const {
    Provider
  } = ctx;
  return react__WEBPACK_IMPORTED_MODULE_1__.createElement(Provider, {
    value: props
  }, children);
};
const ctx = makeContext(SpringContext, {});
SpringContext.Provider = ctx.Provider;
SpringContext.Consumer = ctx.Consumer;

function makeContext(target, init) {
  Object.assign(target, react__WEBPACK_IMPORTED_MODULE_1__.createContext(init));
  target.Provider._context = target;
  target.Consumer._context = target;
  return target;
}

const SpringRef = () => {
  const current = [];

  const SpringRef = function SpringRef(props) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.deprecateDirectCall)();
    const results = [];
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(current, (ctrl, i) => {
      if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props)) {
        results.push(ctrl.start());
      } else {
        const update = _getProps(props, ctrl, i);

        if (update) {
          results.push(ctrl.start(update));
        }
      }
    });
    return results;
  };

  SpringRef.current = current;

  SpringRef.add = function (ctrl) {
    if (!current.includes(ctrl)) {
      current.push(ctrl);
    }
  };

  SpringRef.delete = function (ctrl) {
    const i = current.indexOf(ctrl);
    if (~i) current.splice(i, 1);
  };

  SpringRef.pause = function () {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(current, ctrl => ctrl.pause(...arguments));
    return this;
  };

  SpringRef.resume = function () {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(current, ctrl => ctrl.resume(...arguments));
    return this;
  };

  SpringRef.set = function (values) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(current, ctrl => ctrl.set(values));
  };

  SpringRef.start = function (props) {
    const results = [];
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(current, (ctrl, i) => {
      if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(props)) {
        results.push(ctrl.start());
      } else {
        const update = this._getProps(props, ctrl, i);

        if (update) {
          results.push(ctrl.start(update));
        }
      }
    });
    return results;
  };

  SpringRef.stop = function () {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(current, ctrl => ctrl.stop(...arguments));
    return this;
  };

  SpringRef.update = function (props) {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(current, (ctrl, i) => ctrl.update(this._getProps(props, ctrl, i)));
    return this;
  };

  const _getProps = function _getProps(arg, ctrl, index) {
    return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(arg) ? arg(index, ctrl) : arg;
  };

  SpringRef._getProps = _getProps;
  return SpringRef;
};

function useSprings(length, props, deps) {
  const propsFn = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(props) && props;
  if (propsFn && !deps) deps = [];
  const ref = (0,react__WEBPACK_IMPORTED_MODULE_1__.useMemo)(() => propsFn || arguments.length == 3 ? SpringRef() : void 0, []);
  const layoutId = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(0);
  const forceUpdate = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useForceUpdate)();
  const state = (0,react__WEBPACK_IMPORTED_MODULE_1__.useMemo)(() => ({
    ctrls: [],
    queue: [],

    flush(ctrl, updates) {
      const springs = getSprings(ctrl, updates);
      const canFlushSync = layoutId.current > 0 && !state.queue.length && !Object.keys(springs).some(key => !ctrl.springs[key]);
      return canFlushSync ? flushUpdateQueue(ctrl, updates) : new Promise(resolve => {
        setSprings(ctrl, springs);
        state.queue.push(() => {
          resolve(flushUpdateQueue(ctrl, updates));
        });
        forceUpdate();
      });
    }

  }), []);
  const ctrls = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)([...state.ctrls]);
  const updates = [];
  const prevLength = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.usePrev)(length) || 0;
  (0,react__WEBPACK_IMPORTED_MODULE_1__.useMemo)(() => {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(ctrls.current.slice(length, prevLength), ctrl => {
      detachRefs(ctrl, ref);
      ctrl.stop(true);
    });
    ctrls.current.length = length;
    declareUpdates(prevLength, length);
  }, [length]);
  (0,react__WEBPACK_IMPORTED_MODULE_1__.useMemo)(() => {
    declareUpdates(0, Math.min(prevLength, length));
  }, deps);

  function declareUpdates(startIndex, endIndex) {
    for (let i = startIndex; i < endIndex; i++) {
      const ctrl = ctrls.current[i] || (ctrls.current[i] = new Controller(null, state.flush));
      const update = propsFn ? propsFn(i, ctrl) : props[i];

      if (update) {
        updates[i] = declareUpdate(update);
      }
    }
  }

  const springs = ctrls.current.map((ctrl, i) => getSprings(ctrl, updates[i]));
  const context = (0,react__WEBPACK_IMPORTED_MODULE_1__.useContext)(SpringContext);
  const prevContext = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.usePrev)(context);
  const hasContext = context !== prevContext && hasProps(context);
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => {
    layoutId.current++;
    state.ctrls = ctrls.current;
    const {
      queue
    } = state;

    if (queue.length) {
      state.queue = [];
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(queue, cb => cb());
    }

    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(ctrls.current, (ctrl, i) => {
      ref == null ? void 0 : ref.add(ctrl);

      if (hasContext) {
        ctrl.start({
          default: context
        });
      }

      const update = updates[i];

      if (update) {
        replaceRef(ctrl, update.ref);

        if (ctrl.ref) {
          ctrl.queue.push(update);
        } else {
          ctrl.start(update);
        }
      }
    });
  });
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useOnce)(() => () => {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(state.ctrls, ctrl => ctrl.stop(true));
  });
  const values = springs.map(x => _extends({}, x));
  return ref ? [values, ref] : values;
}

function useSpring(props, deps) {
  const isFn = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(props);
  const [[values], ref] = useSprings(1, isFn ? props : [props], isFn ? deps || [] : deps);
  return isFn || arguments.length == 2 ? [values, ref] : values;
}

const initSpringRef = () => SpringRef();

const useSpringRef = () => (0,react__WEBPACK_IMPORTED_MODULE_1__.useState)(initSpringRef)[0];

function useTrail(length, propsArg, deps) {
  var _passedRef;

  const propsFn = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(propsArg) && propsArg;
  if (propsFn && !deps) deps = [];
  let reverse = true;
  let passedRef = undefined;
  const result = useSprings(length, (i, ctrl) => {
    const props = propsFn ? propsFn(i, ctrl) : propsArg;
    passedRef = props.ref;
    reverse = reverse && props.reverse;
    return props;
  }, deps || [{}]);
  const ref = (_passedRef = passedRef) != null ? _passedRef : result[1];
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(ref.current, (ctrl, i) => {
      const parent = ref.current[i + (reverse ? 1 : -1)];

      if (parent) {
        ctrl.start({
          to: parent.springs
        });
      } else {
        ctrl.start();
      }
    });
  }, deps);

  if (propsFn || arguments.length == 3) {
    ref['_getProps'] = (propsArg, ctrl, i) => {
      const props = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(propsArg) ? propsArg(i, ctrl) : propsArg;

      if (props) {
        const parent = ref.current[i + (props.reverse ? 1 : -1)];
        if (parent) props.to = parent.springs;
        return props;
      }
    };

    return result;
  }

  ref['start'] = propsArg => {
    const results = [];
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(ref.current, (ctrl, i) => {
      const props = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(propsArg) ? propsArg(i, ctrl) : propsArg;
      const parent = ref.current[i + (reverse ? 1 : -1)];

      if (parent) {
        results.push(ctrl.start(_extends({}, props, {
          to: parent.springs
        })));
      } else {
        results.push(ctrl.start(_extends({}, props)));
      }
    });
    return results;
  };

  return result[0];
}

let TransitionPhase;

(function (TransitionPhase) {
  TransitionPhase["MOUNT"] = "mount";
  TransitionPhase["ENTER"] = "enter";
  TransitionPhase["UPDATE"] = "update";
  TransitionPhase["LEAVE"] = "leave";
})(TransitionPhase || (TransitionPhase = {}));

function useTransition(data, props, deps) {
  const propsFn = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(props) && props;
  const {
    reset,
    sort,
    trail = 0,
    expires = true,
    exitBeforeEnter = false,
    onDestroyed,
    ref: propsRef,
    config: propsConfig
  } = propsFn ? propsFn() : props;
  const ref = (0,react__WEBPACK_IMPORTED_MODULE_1__.useMemo)(() => propsFn || arguments.length == 3 ? SpringRef() : void 0, []);
  const items = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(data);
  const transitions = [];
  const usedTransitions = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(null);
  const prevTransitions = reset ? null : usedTransitions.current;
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => {
    usedTransitions.current = transitions;
  });
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useOnce)(() => {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(transitions, t => {
      ref == null ? void 0 : ref.add(t.ctrl);
      t.ctrl.ref = ref;
    });
    return () => {
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(usedTransitions.current, t => {
        if (t.expired) {
          clearTimeout(t.expirationId);
        }

        detachRefs(t.ctrl, ref);
        t.ctrl.stop(true);
      });
    };
  });
  const keys = getKeys(items, propsFn ? propsFn() : props, prevTransitions);
  const expired = reset && usedTransitions.current || [];
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(expired, ({
    ctrl,
    item,
    key
  }) => {
    detachRefs(ctrl, ref);
    callProp(onDestroyed, item, key);
  }));
  const reused = [];
  if (prevTransitions) (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(prevTransitions, (t, i) => {
    if (t.expired) {
      clearTimeout(t.expirationId);
      expired.push(t);
    } else {
      i = reused[i] = keys.indexOf(t.key);
      if (~i) transitions[i] = t;
    }
  });
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(items, (item, i) => {
    if (!transitions[i]) {
      transitions[i] = {
        key: keys[i],
        item,
        phase: TransitionPhase.MOUNT,
        ctrl: new Controller()
      };
      transitions[i].ctrl.item = item;
    }
  });

  if (reused.length) {
    let i = -1;
    const {
      leave
    } = propsFn ? propsFn() : props;
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(reused, (keyIndex, prevIndex) => {
      const t = prevTransitions[prevIndex];

      if (~keyIndex) {
        i = transitions.indexOf(t);
        transitions[i] = _extends({}, t, {
          item: items[keyIndex]
        });
      } else if (leave) {
        transitions.splice(++i, 0, t);
      }
    });
  }

  if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(sort)) {
    transitions.sort((a, b) => sort(a.item, b.item));
  }

  let delay = -trail;
  const forceUpdate = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useForceUpdate)();
  const defaultProps = getDefaultProps(props);
  const changes = new Map();
  const exitingTransitions = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(new Map());
  const forceChange = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(false);
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(transitions, (t, i) => {
    const key = t.key;
    const prevPhase = t.phase;
    const p = propsFn ? propsFn() : props;
    let to;
    let phase;
    let propsDelay = callProp(p.delay || 0, key);

    if (prevPhase == TransitionPhase.MOUNT) {
      to = p.enter;
      phase = TransitionPhase.ENTER;
    } else {
      const isLeave = keys.indexOf(key) < 0;

      if (prevPhase != TransitionPhase.LEAVE) {
        if (isLeave) {
          to = p.leave;
          phase = TransitionPhase.LEAVE;
        } else if (to = p.update) {
          phase = TransitionPhase.UPDATE;
        } else return;
      } else if (!isLeave) {
        to = p.enter;
        phase = TransitionPhase.ENTER;
      } else return;
    }

    to = callProp(to, t.item, i);
    to = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.obj(to) ? inferTo(to) : {
      to
    };

    if (!to.config) {
      const config = propsConfig || defaultProps.config;
      to.config = callProp(config, t.item, i, phase);
    }

    delay += trail;

    const payload = _extends({}, defaultProps, {
      delay: propsDelay + delay,
      ref: propsRef,
      immediate: p.immediate,
      reset: false
    }, to);

    if (phase == TransitionPhase.ENTER && _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(payload.from)) {
      const _p = propsFn ? propsFn() : props;

      const from = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(_p.initial) || prevTransitions ? _p.from : _p.initial;
      payload.from = callProp(from, t.item, i);
    }

    const {
      onResolve
    } = payload;

    payload.onResolve = result => {
      callProp(onResolve, result);
      const transitions = usedTransitions.current;
      const t = transitions.find(t => t.key === key);
      if (!t) return;

      if (result.cancelled && t.phase != TransitionPhase.UPDATE) {
        return;
      }

      if (t.ctrl.idle) {
        const idle = transitions.every(t => t.ctrl.idle);

        if (t.phase == TransitionPhase.LEAVE) {
          const expiry = callProp(expires, t.item);

          if (expiry !== false) {
            const expiryMs = expiry === true ? 0 : expiry;
            t.expired = true;

            if (!idle && expiryMs > 0) {
              if (expiryMs <= 0x7fffffff) t.expirationId = setTimeout(forceUpdate, expiryMs);
              return;
            }
          }
        }

        if (idle && transitions.some(t => t.expired)) {
          exitingTransitions.current.delete(t);

          if (exitBeforeEnter) {
            forceChange.current = true;
          }

          forceUpdate();
        }
      }
    };

    const springs = getSprings(t.ctrl, payload);

    if (phase === TransitionPhase.LEAVE && exitBeforeEnter) {
      exitingTransitions.current.set(t, {
        phase,
        springs,
        payload
      });
    } else {
      changes.set(t, {
        phase,
        springs,
        payload
      });
    }
  });
  const context = (0,react__WEBPACK_IMPORTED_MODULE_1__.useContext)(SpringContext);
  const prevContext = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.usePrev)(context);
  const hasContext = context !== prevContext && hasProps(context);
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => {
    if (hasContext) {
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(transitions, t => {
        t.ctrl.start({
          default: context
        });
      });
    }
  }, [context]);
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(changes, (_, t) => {
    if (exitingTransitions.current.size) {
      const ind = transitions.findIndex(state => state.key === t.key);
      transitions.splice(ind, 1);
    }
  });
  (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.useIsomorphicLayoutEffect)(() => {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)(exitingTransitions.current.size ? exitingTransitions.current : changes, ({
      phase,
      payload
    }, t) => {
      const {
        ctrl
      } = t;
      t.phase = phase;
      ref == null ? void 0 : ref.add(ctrl);

      if (hasContext && phase == TransitionPhase.ENTER) {
        ctrl.start({
          default: context
        });
      }

      if (payload) {
        replaceRef(ctrl, payload.ref);

        if ((ctrl.ref || ref) && !forceChange.current) {
          ctrl.update(payload);
        } else {
          ctrl.start(payload);

          if (forceChange.current) {
            forceChange.current = false;
          }
        }
      }
    });
  }, reset ? void 0 : deps);

  const renderTransitions = render => react__WEBPACK_IMPORTED_MODULE_1__.createElement(react__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, transitions.map((t, i) => {
    const {
      springs
    } = changes.get(t) || t.ctrl;
    const elem = render(_extends({}, springs), t.item, t, i);
    return elem && elem.type ? react__WEBPACK_IMPORTED_MODULE_1__.createElement(elem.type, _extends({}, elem.props, {
      key: _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.str(t.key) || _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.num(t.key) ? t.key : t.ctrl.id,
      ref: elem.ref
    })) : elem;
  }));

  return ref ? [renderTransitions, ref] : renderTransitions;
}
let nextKey = 1;

function getKeys(items, {
  key,
  keys = key
}, prevTransitions) {
  if (keys === null) {
    const reused = new Set();
    return items.map(item => {
      const t = prevTransitions && prevTransitions.find(t => t.item === item && t.phase !== TransitionPhase.LEAVE && !reused.has(t));

      if (t) {
        reused.add(t);
        return t.key;
      }

      return nextKey++;
    });
  }

  return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.und(keys) ? items : _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(keys) ? items.map(keys) : (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(keys);
}

const _excluded$2 = ["children"];
function Spring(_ref) {
  let {
    children
  } = _ref,
      props = _objectWithoutPropertiesLoose(_ref, _excluded$2);

  return children(useSpring(props));
}

const _excluded$1 = ["items", "children"];
function Trail(_ref) {
  let {
    items,
    children
  } = _ref,
      props = _objectWithoutPropertiesLoose(_ref, _excluded$1);

  const trails = useTrail(items.length, props);
  return items.map((item, index) => {
    const result = children(item, index);
    return _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.fun(result) ? result(trails[index]) : result;
  });
}

const _excluded = ["items", "children"];
function Transition(_ref) {
  let {
    items,
    children
  } = _ref,
      props = _objectWithoutPropertiesLoose(_ref, _excluded);

  return useTransition(items, props)(children);
}

class Interpolation extends FrameValue {
  constructor(source, args) {
    super();
    this.key = void 0;
    this.idle = true;
    this.calc = void 0;
    this._active = new Set();
    this.source = source;
    this.calc = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.createInterpolator)(...args);

    const value = this._get();

    const nodeType = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimatedType)(value);
    (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.setAnimated)(this, nodeType.create(value));
  }

  advance(_dt) {
    const value = this._get();

    const oldValue = this.get();

    if (!(0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.isEqual)(value, oldValue)) {
      (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getAnimated)(this).setValue(value);

      this._onChange(value, this.idle);
    }

    if (!this.idle && checkIdle(this._active)) {
      becomeIdle(this);
    }
  }

  _get() {
    const inputs = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.is.arr(this.source) ? this.source.map(_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue) : (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.getFluidValue)(this.source));
    return this.calc(...inputs);
  }

  _start() {
    if (this.idle && !checkIdle(this._active)) {
      this.idle = false;
      (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getPayload)(this), node => {
        node.done = false;
      });

      if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.skipAnimation) {
        _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates(() => this.advance());
        becomeIdle(this);
      } else {
        _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.frameLoop.start(this);
      }
    }
  }

  _attach() {
    let priority = 1;
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(this.source), source => {
      if ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(source)) {
        (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.addFluidObserver)(source, this);
      }

      if (isFrameValue(source)) {
        if (!source.idle) {
          this._active.add(source);
        }

        priority = Math.max(priority, source.priority + 1);
      }
    });
    this.priority = priority;

    this._start();
  }

  _detach() {
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(this.source), source => {
      if ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.hasFluidValue)(source)) {
        (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.removeFluidObserver)(source, this);
      }
    });

    this._active.clear();

    becomeIdle(this);
  }

  eventObserved(event) {
    if (event.type == 'change') {
      if (event.idle) {
        this.advance();
      } else {
        this._active.add(event.parent);

        this._start();
      }
    } else if (event.type == 'idle') {
      this._active.delete(event.parent);
    } else if (event.type == 'priority') {
      this.priority = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.toArray)(this.source).reduce((highest, parent) => Math.max(highest, (isFrameValue(parent) ? parent.priority : 0) + 1), 0);
    }
  }

}

function isIdle(source) {
  return source.idle !== false;
}

function checkIdle(active) {
  return !active.size || Array.from(active).every(isIdle);
}

function becomeIdle(self) {
  if (!self.idle) {
    self.idle = true;
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.each)((0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_2__.getPayload)(self), node => {
      node.done = true;
    });
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.callFluidObservers)(self, {
      type: 'idle',
      parent: self
    });
  }
}

const to = (source, ...args) => new Interpolation(source, args);
const interpolate = (source, ...args) => ((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.deprecateInterpolate)(), new Interpolation(source, args));

_react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.Globals.assign({
  createStringInterpolator: _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.createStringInterpolator,
  to: (source, args) => new Interpolation(source, args)
});
const update = _react_spring_shared__WEBPACK_IMPORTED_MODULE_0__.frameLoop.advance;




/***/ }),

/***/ "./node_modules/@react-spring/rafz/dist/react-spring-rafz.esm.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@react-spring/rafz/dist/react-spring-rafz.esm.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "__raf": function() { return /* binding */ __raf; },
/* harmony export */   "raf": function() { return /* binding */ raf; }
/* harmony export */ });
let updateQueue = makeQueue();
const raf = fn => schedule(fn, updateQueue);
let writeQueue = makeQueue();

raf.write = fn => schedule(fn, writeQueue);

let onStartQueue = makeQueue();

raf.onStart = fn => schedule(fn, onStartQueue);

let onFrameQueue = makeQueue();

raf.onFrame = fn => schedule(fn, onFrameQueue);

let onFinishQueue = makeQueue();

raf.onFinish = fn => schedule(fn, onFinishQueue);

let timeouts = [];

raf.setTimeout = (handler, ms) => {
  let time = raf.now() + ms;

  let cancel = () => {
    let i = timeouts.findIndex(t => t.cancel == cancel);
    if (~i) timeouts.splice(i, 1);
    pendingCount -= ~i ? 1 : 0;
  };

  let timeout = {
    time,
    handler,
    cancel
  };
  timeouts.splice(findTimeout(time), 0, timeout);
  pendingCount += 1;
  start();
  return timeout;
};

let findTimeout = time => ~(~timeouts.findIndex(t => t.time > time) || ~timeouts.length);

raf.cancel = fn => {
  onStartQueue.delete(fn);
  onFrameQueue.delete(fn);
  onFinishQueue.delete(fn);
  updateQueue.delete(fn);
  writeQueue.delete(fn);
};

raf.sync = fn => {
  sync = true;
  raf.batchedUpdates(fn);
  sync = false;
};

raf.throttle = fn => {
  let lastArgs;

  function queuedFn() {
    try {
      fn(...lastArgs);
    } finally {
      lastArgs = null;
    }
  }

  function throttled(...args) {
    lastArgs = args;
    raf.onStart(queuedFn);
  }

  throttled.handler = fn;

  throttled.cancel = () => {
    onStartQueue.delete(queuedFn);
    lastArgs = null;
  };

  return throttled;
};

let nativeRaf = typeof window != 'undefined' ? window.requestAnimationFrame : () => {};

raf.use = impl => nativeRaf = impl;

raf.now = typeof performance != 'undefined' ? () => performance.now() : Date.now;

raf.batchedUpdates = fn => fn();

raf.catch = console.error;
raf.frameLoop = 'always';

raf.advance = () => {
  if (raf.frameLoop !== 'demand') {
    console.warn('Cannot call the manual advancement of rafz whilst frameLoop is not set as demand');
  } else {
    update();
  }
};

let ts = -1;
let pendingCount = 0;
let sync = false;

function schedule(fn, queue) {
  if (sync) {
    queue.delete(fn);
    fn(0);
  } else {
    queue.add(fn);
    start();
  }
}

function start() {
  if (ts < 0) {
    ts = 0;

    if (raf.frameLoop !== 'demand') {
      nativeRaf(loop);
    }
  }
}

function stop() {
  ts = -1;
}

function loop() {
  if (~ts) {
    nativeRaf(loop);
    raf.batchedUpdates(update);
  }
}

function update() {
  let prevTs = ts;
  ts = raf.now();
  let count = findTimeout(ts);

  if (count) {
    eachSafely(timeouts.splice(0, count), t => t.handler());
    pendingCount -= count;
  }

  if (!pendingCount) {
    stop();
    return;
  }

  onStartQueue.flush();
  updateQueue.flush(prevTs ? Math.min(64, ts - prevTs) : 16.667);
  onFrameQueue.flush();
  writeQueue.flush();
  onFinishQueue.flush();
}

function makeQueue() {
  let next = new Set();
  let current = next;
  return {
    add(fn) {
      pendingCount += current == next && !next.has(fn) ? 1 : 0;
      next.add(fn);
    },

    delete(fn) {
      pendingCount -= current == next && next.has(fn) ? 1 : 0;
      return next.delete(fn);
    },

    flush(arg) {
      if (current.size) {
        next = new Set();
        pendingCount -= current.size;
        eachSafely(current, fn => fn(arg) && next.add(fn));
        pendingCount += next.size;
        current = next;
      }
    }

  };
}

function eachSafely(values, each) {
  values.forEach(value => {
    try {
      each(value);
    } catch (e) {
      raf.catch(e);
    }
  });
}

const __raf = {
  count() {
    return pendingCount;
  },

  isRunning() {
    return ts >= 0;
  },

  clear() {
    ts = -1;
    timeouts = [];
    onStartQueue = makeQueue();
    updateQueue = makeQueue();
    onFrameQueue = makeQueue();
    writeQueue = makeQueue();
    onFinishQueue = makeQueue();
    pendingCount = 0;
  }

};




/***/ }),

/***/ "./node_modules/@react-spring/shared/dist/react-spring-shared.esm.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@react-spring/shared/dist/react-spring-shared.esm.js ***!
  \***************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "FluidValue": function() { return /* binding */ FluidValue; },
/* harmony export */   "Globals": function() { return /* binding */ globals; },
/* harmony export */   "addFluidObserver": function() { return /* binding */ addFluidObserver; },
/* harmony export */   "callFluidObserver": function() { return /* binding */ callFluidObserver; },
/* harmony export */   "callFluidObservers": function() { return /* binding */ callFluidObservers; },
/* harmony export */   "colorToRgba": function() { return /* binding */ colorToRgba; },
/* harmony export */   "colors": function() { return /* binding */ colors; },
/* harmony export */   "createInterpolator": function() { return /* binding */ createInterpolator; },
/* harmony export */   "createStringInterpolator": function() { return /* binding */ createStringInterpolator; },
/* harmony export */   "defineHidden": function() { return /* binding */ defineHidden; },
/* harmony export */   "deprecateDirectCall": function() { return /* binding */ deprecateDirectCall; },
/* harmony export */   "deprecateInterpolate": function() { return /* binding */ deprecateInterpolate; },
/* harmony export */   "each": function() { return /* binding */ each; },
/* harmony export */   "eachProp": function() { return /* binding */ eachProp; },
/* harmony export */   "flush": function() { return /* binding */ flush; },
/* harmony export */   "flushCalls": function() { return /* binding */ flushCalls; },
/* harmony export */   "frameLoop": function() { return /* binding */ frameLoop; },
/* harmony export */   "getFluidObservers": function() { return /* binding */ getFluidObservers; },
/* harmony export */   "getFluidValue": function() { return /* binding */ getFluidValue; },
/* harmony export */   "hasFluidValue": function() { return /* binding */ hasFluidValue; },
/* harmony export */   "hex3": function() { return /* binding */ hex3; },
/* harmony export */   "hex4": function() { return /* binding */ hex4; },
/* harmony export */   "hex6": function() { return /* binding */ hex6; },
/* harmony export */   "hex8": function() { return /* binding */ hex8; },
/* harmony export */   "hsl": function() { return /* binding */ hsl; },
/* harmony export */   "hsla": function() { return /* binding */ hsla; },
/* harmony export */   "is": function() { return /* binding */ is; },
/* harmony export */   "isAnimatedString": function() { return /* binding */ isAnimatedString; },
/* harmony export */   "isEqual": function() { return /* binding */ isEqual; },
/* harmony export */   "isSSR": function() { return /* binding */ isSSR; },
/* harmony export */   "noop": function() { return /* binding */ noop; },
/* harmony export */   "raf": function() { return /* reexport safe */ _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf; },
/* harmony export */   "removeFluidObserver": function() { return /* binding */ removeFluidObserver; },
/* harmony export */   "rgb": function() { return /* binding */ rgb; },
/* harmony export */   "rgba": function() { return /* binding */ rgba; },
/* harmony export */   "setFluidGetter": function() { return /* binding */ setFluidGetter; },
/* harmony export */   "toArray": function() { return /* binding */ toArray; },
/* harmony export */   "useForceUpdate": function() { return /* binding */ useForceUpdate; },
/* harmony export */   "useIsomorphicLayoutEffect": function() { return /* binding */ useIsomorphicLayoutEffect; },
/* harmony export */   "useMemoOne": function() { return /* binding */ useMemoOne; },
/* harmony export */   "useOnce": function() { return /* binding */ useOnce; },
/* harmony export */   "usePrev": function() { return /* binding */ usePrev; },
/* harmony export */   "useReducedMotion": function() { return /* binding */ useReducedMotion; }
/* harmony export */ });
/* harmony import */ var _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @react-spring/rafz */ "./node_modules/@react-spring/rafz/dist/react-spring-rafz.esm.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);




function noop() {}
const defineHidden = (obj, key, value) => Object.defineProperty(obj, key, {
  value,
  writable: true,
  configurable: true
});
const is = {
  arr: Array.isArray,
  obj: a => !!a && a.constructor.name === 'Object',
  fun: a => typeof a === 'function',
  str: a => typeof a === 'string',
  num: a => typeof a === 'number',
  und: a => a === undefined
};
function isEqual(a, b) {
  if (is.arr(a)) {
    if (!is.arr(b) || a.length !== b.length) return false;

    for (let i = 0; i < a.length; i++) {
      if (a[i] !== b[i]) return false;
    }

    return true;
  }

  return a === b;
}
const each = (obj, fn) => obj.forEach(fn);
function eachProp(obj, fn, ctx) {
  if (is.arr(obj)) {
    for (let i = 0; i < obj.length; i++) {
      fn.call(ctx, obj[i], `${i}`);
    }

    return;
  }

  for (const key in obj) {
    if (obj.hasOwnProperty(key)) {
      fn.call(ctx, obj[key], key);
    }
  }
}
const toArray = a => is.und(a) ? [] : is.arr(a) ? a : [a];
function flush(queue, iterator) {
  if (queue.size) {
    const items = Array.from(queue);
    queue.clear();
    each(items, iterator);
  }
}
const flushCalls = (queue, ...args) => flush(queue, fn => fn(...args));
const isSSR = () => typeof window === 'undefined' || !window.navigator || /ServerSideRendering|^Deno\//.test(window.navigator.userAgent);

let createStringInterpolator$1;
let to;
let colors$1 = null;
let skipAnimation = false;
let willAdvance = noop;
const assign = globals => {
  if (globals.to) to = globals.to;
  if (globals.now) _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf.now = globals.now;
  if (globals.colors !== undefined) colors$1 = globals.colors;
  if (globals.skipAnimation != null) skipAnimation = globals.skipAnimation;
  if (globals.createStringInterpolator) createStringInterpolator$1 = globals.createStringInterpolator;
  if (globals.requestAnimationFrame) _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf.use(globals.requestAnimationFrame);
  if (globals.batchedUpdates) _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf.batchedUpdates = globals.batchedUpdates;
  if (globals.willAdvance) willAdvance = globals.willAdvance;
  if (globals.frameLoop) _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf.frameLoop = globals.frameLoop;
};

var globals = /*#__PURE__*/Object.freeze({
  __proto__: null,
  get createStringInterpolator () { return createStringInterpolator$1; },
  get to () { return to; },
  get colors () { return colors$1; },
  get skipAnimation () { return skipAnimation; },
  get willAdvance () { return willAdvance; },
  assign: assign
});

const startQueue = new Set();
let currentFrame = [];
let prevFrame = [];
let priority = 0;
const frameLoop = {
  get idle() {
    return !startQueue.size && !currentFrame.length;
  },

  start(animation) {
    if (priority > animation.priority) {
      startQueue.add(animation);
      _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf.onStart(flushStartQueue);
    } else {
      startSafely(animation);
      (0,_react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf)(advance);
    }
  },

  advance,

  sort(animation) {
    if (priority) {
      _react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf.onFrame(() => frameLoop.sort(animation));
    } else {
      const prevIndex = currentFrame.indexOf(animation);

      if (~prevIndex) {
        currentFrame.splice(prevIndex, 1);
        startUnsafely(animation);
      }
    }
  },

  clear() {
    currentFrame = [];
    startQueue.clear();
  }

};

function flushStartQueue() {
  startQueue.forEach(startSafely);
  startQueue.clear();
  (0,_react_spring_rafz__WEBPACK_IMPORTED_MODULE_0__.raf)(advance);
}

function startSafely(animation) {
  if (!currentFrame.includes(animation)) startUnsafely(animation);
}

function startUnsafely(animation) {
  currentFrame.splice(findIndex(currentFrame, other => other.priority > animation.priority), 0, animation);
}

function advance(dt) {
  const nextFrame = prevFrame;

  for (let i = 0; i < currentFrame.length; i++) {
    const animation = currentFrame[i];
    priority = animation.priority;

    if (!animation.idle) {
      willAdvance(animation);
      animation.advance(dt);

      if (!animation.idle) {
        nextFrame.push(animation);
      }
    }
  }

  priority = 0;
  prevFrame = currentFrame;
  prevFrame.length = 0;
  currentFrame = nextFrame;
  return currentFrame.length > 0;
}

function findIndex(arr, test) {
  const index = arr.findIndex(test);
  return index < 0 ? arr.length : index;
}

const colors = {
  transparent: 0x00000000,
  aliceblue: 0xf0f8ffff,
  antiquewhite: 0xfaebd7ff,
  aqua: 0x00ffffff,
  aquamarine: 0x7fffd4ff,
  azure: 0xf0ffffff,
  beige: 0xf5f5dcff,
  bisque: 0xffe4c4ff,
  black: 0x000000ff,
  blanchedalmond: 0xffebcdff,
  blue: 0x0000ffff,
  blueviolet: 0x8a2be2ff,
  brown: 0xa52a2aff,
  burlywood: 0xdeb887ff,
  burntsienna: 0xea7e5dff,
  cadetblue: 0x5f9ea0ff,
  chartreuse: 0x7fff00ff,
  chocolate: 0xd2691eff,
  coral: 0xff7f50ff,
  cornflowerblue: 0x6495edff,
  cornsilk: 0xfff8dcff,
  crimson: 0xdc143cff,
  cyan: 0x00ffffff,
  darkblue: 0x00008bff,
  darkcyan: 0x008b8bff,
  darkgoldenrod: 0xb8860bff,
  darkgray: 0xa9a9a9ff,
  darkgreen: 0x006400ff,
  darkgrey: 0xa9a9a9ff,
  darkkhaki: 0xbdb76bff,
  darkmagenta: 0x8b008bff,
  darkolivegreen: 0x556b2fff,
  darkorange: 0xff8c00ff,
  darkorchid: 0x9932ccff,
  darkred: 0x8b0000ff,
  darksalmon: 0xe9967aff,
  darkseagreen: 0x8fbc8fff,
  darkslateblue: 0x483d8bff,
  darkslategray: 0x2f4f4fff,
  darkslategrey: 0x2f4f4fff,
  darkturquoise: 0x00ced1ff,
  darkviolet: 0x9400d3ff,
  deeppink: 0xff1493ff,
  deepskyblue: 0x00bfffff,
  dimgray: 0x696969ff,
  dimgrey: 0x696969ff,
  dodgerblue: 0x1e90ffff,
  firebrick: 0xb22222ff,
  floralwhite: 0xfffaf0ff,
  forestgreen: 0x228b22ff,
  fuchsia: 0xff00ffff,
  gainsboro: 0xdcdcdcff,
  ghostwhite: 0xf8f8ffff,
  gold: 0xffd700ff,
  goldenrod: 0xdaa520ff,
  gray: 0x808080ff,
  green: 0x008000ff,
  greenyellow: 0xadff2fff,
  grey: 0x808080ff,
  honeydew: 0xf0fff0ff,
  hotpink: 0xff69b4ff,
  indianred: 0xcd5c5cff,
  indigo: 0x4b0082ff,
  ivory: 0xfffff0ff,
  khaki: 0xf0e68cff,
  lavender: 0xe6e6faff,
  lavenderblush: 0xfff0f5ff,
  lawngreen: 0x7cfc00ff,
  lemonchiffon: 0xfffacdff,
  lightblue: 0xadd8e6ff,
  lightcoral: 0xf08080ff,
  lightcyan: 0xe0ffffff,
  lightgoldenrodyellow: 0xfafad2ff,
  lightgray: 0xd3d3d3ff,
  lightgreen: 0x90ee90ff,
  lightgrey: 0xd3d3d3ff,
  lightpink: 0xffb6c1ff,
  lightsalmon: 0xffa07aff,
  lightseagreen: 0x20b2aaff,
  lightskyblue: 0x87cefaff,
  lightslategray: 0x778899ff,
  lightslategrey: 0x778899ff,
  lightsteelblue: 0xb0c4deff,
  lightyellow: 0xffffe0ff,
  lime: 0x00ff00ff,
  limegreen: 0x32cd32ff,
  linen: 0xfaf0e6ff,
  magenta: 0xff00ffff,
  maroon: 0x800000ff,
  mediumaquamarine: 0x66cdaaff,
  mediumblue: 0x0000cdff,
  mediumorchid: 0xba55d3ff,
  mediumpurple: 0x9370dbff,
  mediumseagreen: 0x3cb371ff,
  mediumslateblue: 0x7b68eeff,
  mediumspringgreen: 0x00fa9aff,
  mediumturquoise: 0x48d1ccff,
  mediumvioletred: 0xc71585ff,
  midnightblue: 0x191970ff,
  mintcream: 0xf5fffaff,
  mistyrose: 0xffe4e1ff,
  moccasin: 0xffe4b5ff,
  navajowhite: 0xffdeadff,
  navy: 0x000080ff,
  oldlace: 0xfdf5e6ff,
  olive: 0x808000ff,
  olivedrab: 0x6b8e23ff,
  orange: 0xffa500ff,
  orangered: 0xff4500ff,
  orchid: 0xda70d6ff,
  palegoldenrod: 0xeee8aaff,
  palegreen: 0x98fb98ff,
  paleturquoise: 0xafeeeeff,
  palevioletred: 0xdb7093ff,
  papayawhip: 0xffefd5ff,
  peachpuff: 0xffdab9ff,
  peru: 0xcd853fff,
  pink: 0xffc0cbff,
  plum: 0xdda0ddff,
  powderblue: 0xb0e0e6ff,
  purple: 0x800080ff,
  rebeccapurple: 0x663399ff,
  red: 0xff0000ff,
  rosybrown: 0xbc8f8fff,
  royalblue: 0x4169e1ff,
  saddlebrown: 0x8b4513ff,
  salmon: 0xfa8072ff,
  sandybrown: 0xf4a460ff,
  seagreen: 0x2e8b57ff,
  seashell: 0xfff5eeff,
  sienna: 0xa0522dff,
  silver: 0xc0c0c0ff,
  skyblue: 0x87ceebff,
  slateblue: 0x6a5acdff,
  slategray: 0x708090ff,
  slategrey: 0x708090ff,
  snow: 0xfffafaff,
  springgreen: 0x00ff7fff,
  steelblue: 0x4682b4ff,
  tan: 0xd2b48cff,
  teal: 0x008080ff,
  thistle: 0xd8bfd8ff,
  tomato: 0xff6347ff,
  turquoise: 0x40e0d0ff,
  violet: 0xee82eeff,
  wheat: 0xf5deb3ff,
  white: 0xffffffff,
  whitesmoke: 0xf5f5f5ff,
  yellow: 0xffff00ff,
  yellowgreen: 0x9acd32ff
};

const NUMBER = '[-+]?\\d*\\.?\\d+';
const PERCENTAGE = NUMBER + '%';

function call(...parts) {
  return '\\(\\s*(' + parts.join(')\\s*,\\s*(') + ')\\s*\\)';
}

const rgb = new RegExp('rgb' + call(NUMBER, NUMBER, NUMBER));
const rgba = new RegExp('rgba' + call(NUMBER, NUMBER, NUMBER, NUMBER));
const hsl = new RegExp('hsl' + call(NUMBER, PERCENTAGE, PERCENTAGE));
const hsla = new RegExp('hsla' + call(NUMBER, PERCENTAGE, PERCENTAGE, NUMBER));
const hex3 = /^#([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/;
const hex4 = /^#([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/;
const hex6 = /^#([0-9a-fA-F]{6})$/;
const hex8 = /^#([0-9a-fA-F]{8})$/;

function normalizeColor(color) {
  let match;

  if (typeof color === 'number') {
    return color >>> 0 === color && color >= 0 && color <= 0xffffffff ? color : null;
  }

  if (match = hex6.exec(color)) return parseInt(match[1] + 'ff', 16) >>> 0;

  if (colors$1 && colors$1[color] !== undefined) {
    return colors$1[color];
  }

  if (match = rgb.exec(color)) {
    return (parse255(match[1]) << 24 | parse255(match[2]) << 16 | parse255(match[3]) << 8 | 0x000000ff) >>> 0;
  }

  if (match = rgba.exec(color)) {
    return (parse255(match[1]) << 24 | parse255(match[2]) << 16 | parse255(match[3]) << 8 | parse1(match[4])) >>> 0;
  }

  if (match = hex3.exec(color)) {
    return parseInt(match[1] + match[1] + match[2] + match[2] + match[3] + match[3] + 'ff', 16) >>> 0;
  }

  if (match = hex8.exec(color)) return parseInt(match[1], 16) >>> 0;

  if (match = hex4.exec(color)) {
    return parseInt(match[1] + match[1] + match[2] + match[2] + match[3] + match[3] + match[4] + match[4], 16) >>> 0;
  }

  if (match = hsl.exec(color)) {
    return (hslToRgb(parse360(match[1]), parsePercentage(match[2]), parsePercentage(match[3])) | 0x000000ff) >>> 0;
  }

  if (match = hsla.exec(color)) {
    return (hslToRgb(parse360(match[1]), parsePercentage(match[2]), parsePercentage(match[3])) | parse1(match[4])) >>> 0;
  }

  return null;
}

function hue2rgb(p, q, t) {
  if (t < 0) t += 1;
  if (t > 1) t -= 1;
  if (t < 1 / 6) return p + (q - p) * 6 * t;
  if (t < 1 / 2) return q;
  if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
  return p;
}

function hslToRgb(h, s, l) {
  const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
  const p = 2 * l - q;
  const r = hue2rgb(p, q, h + 1 / 3);
  const g = hue2rgb(p, q, h);
  const b = hue2rgb(p, q, h - 1 / 3);
  return Math.round(r * 255) << 24 | Math.round(g * 255) << 16 | Math.round(b * 255) << 8;
}

function parse255(str) {
  const int = parseInt(str, 10);
  if (int < 0) return 0;
  if (int > 255) return 255;
  return int;
}

function parse360(str) {
  const int = parseFloat(str);
  return (int % 360 + 360) % 360 / 360;
}

function parse1(str) {
  const num = parseFloat(str);
  if (num < 0) return 0;
  if (num > 1) return 255;
  return Math.round(num * 255);
}

function parsePercentage(str) {
  const int = parseFloat(str);
  if (int < 0) return 0;
  if (int > 100) return 1;
  return int / 100;
}

function colorToRgba(input) {
  let int32Color = normalizeColor(input);
  if (int32Color === null) return input;
  int32Color = int32Color || 0;
  let r = (int32Color & 0xff000000) >>> 24;
  let g = (int32Color & 0x00ff0000) >>> 16;
  let b = (int32Color & 0x0000ff00) >>> 8;
  let a = (int32Color & 0x000000ff) / 255;
  return `rgba(${r}, ${g}, ${b}, ${a})`;
}

const createInterpolator = (range, output, extrapolate) => {
  if (is.fun(range)) {
    return range;
  }

  if (is.arr(range)) {
    return createInterpolator({
      range,
      output: output,
      extrapolate
    });
  }

  if (is.str(range.output[0])) {
    return createStringInterpolator$1(range);
  }

  const config = range;
  const outputRange = config.output;
  const inputRange = config.range || [0, 1];
  const extrapolateLeft = config.extrapolateLeft || config.extrapolate || 'extend';
  const extrapolateRight = config.extrapolateRight || config.extrapolate || 'extend';

  const easing = config.easing || (t => t);

  return input => {
    const range = findRange(input, inputRange);
    return interpolate(input, inputRange[range], inputRange[range + 1], outputRange[range], outputRange[range + 1], easing, extrapolateLeft, extrapolateRight, config.map);
  };
};

function interpolate(input, inputMin, inputMax, outputMin, outputMax, easing, extrapolateLeft, extrapolateRight, map) {
  let result = map ? map(input) : input;

  if (result < inputMin) {
    if (extrapolateLeft === 'identity') return result;else if (extrapolateLeft === 'clamp') result = inputMin;
  }

  if (result > inputMax) {
    if (extrapolateRight === 'identity') return result;else if (extrapolateRight === 'clamp') result = inputMax;
  }

  if (outputMin === outputMax) return outputMin;
  if (inputMin === inputMax) return input <= inputMin ? outputMin : outputMax;
  if (inputMin === -Infinity) result = -result;else if (inputMax === Infinity) result = result - inputMin;else result = (result - inputMin) / (inputMax - inputMin);
  result = easing(result);
  if (outputMin === -Infinity) result = -result;else if (outputMax === Infinity) result = result + outputMin;else result = result * (outputMax - outputMin) + outputMin;
  return result;
}

function findRange(input, inputRange) {
  for (var i = 1; i < inputRange.length - 1; ++i) if (inputRange[i] >= input) break;

  return i - 1;
}

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

const $get = Symbol.for('FluidValue.get');
const $observers = Symbol.for('FluidValue.observers');

const hasFluidValue = arg => Boolean(arg && arg[$get]);

const getFluidValue = arg => arg && arg[$get] ? arg[$get]() : arg;

const getFluidObservers = target => target[$observers] || null;

function callFluidObserver(observer, event) {
  if (observer.eventObserved) {
    observer.eventObserved(event);
  } else {
    observer(event);
  }
}

function callFluidObservers(target, event) {
  let observers = target[$observers];

  if (observers) {
    observers.forEach(observer => {
      callFluidObserver(observer, event);
    });
  }
}

class FluidValue {
  constructor(get) {
    this[$get] = void 0;
    this[$observers] = void 0;

    if (!get && !(get = this.get)) {
      throw Error('Unknown getter');
    }

    setFluidGetter(this, get);
  }

}

const setFluidGetter = (target, get) => setHidden(target, $get, get);

function addFluidObserver(target, observer) {
  if (target[$get]) {
    let observers = target[$observers];

    if (!observers) {
      setHidden(target, $observers, observers = new Set());
    }

    if (!observers.has(observer)) {
      observers.add(observer);

      if (target.observerAdded) {
        target.observerAdded(observers.size, observer);
      }
    }
  }

  return observer;
}

function removeFluidObserver(target, observer) {
  let observers = target[$observers];

  if (observers && observers.has(observer)) {
    const count = observers.size - 1;

    if (count) {
      observers.delete(observer);
    } else {
      target[$observers] = null;
    }

    if (target.observerRemoved) {
      target.observerRemoved(count, observer);
    }
  }
}

const setHidden = (target, key, value) => Object.defineProperty(target, key, {
  value,
  writable: true,
  configurable: true
});

const numberRegex = /[+\-]?(?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?/g;
const colorRegex = /(#(?:[0-9a-f]{2}){2,4}|(#[0-9a-f]{3})|(rgb|hsl)a?\((-?\d+%?[,\s]+){2,3}\s*[\d\.]+%?\))/gi;
const unitRegex = new RegExp(`(${numberRegex.source})(%|[a-z]+)`, 'i');
const rgbaRegex = /rgba\(([0-9\.-]+), ([0-9\.-]+), ([0-9\.-]+), ([0-9\.-]+)\)/gi;
const cssVariableRegex = /var\((--[a-zA-Z0-9-_]+),? ?([a-zA-Z0-9 ()%#.,-]+)?\)/;

const variableToRgba = input => {
  const [token, fallback] = parseCSSVariable(input);

  if (!token || isSSR()) {
    return input;
  }

  const value = window.getComputedStyle(document.documentElement).getPropertyValue(token);

  if (value) {
    return value.trim();
  } else if (fallback && fallback.startsWith('--')) {
    const _value = window.getComputedStyle(document.documentElement).getPropertyValue(fallback);

    if (_value) {
      return _value;
    } else {
      return input;
    }
  } else if (fallback && cssVariableRegex.test(fallback)) {
    return variableToRgba(fallback);
  } else if (fallback) {
    return fallback;
  }

  return input;
};

const parseCSSVariable = current => {
  const match = cssVariableRegex.exec(current);
  if (!match) return [,];
  const [, token, fallback] = match;
  return [token, fallback];
};

let namedColorRegex;

const rgbaRound = (_, p1, p2, p3, p4) => `rgba(${Math.round(p1)}, ${Math.round(p2)}, ${Math.round(p3)}, ${p4})`;

const createStringInterpolator = config => {
  if (!namedColorRegex) namedColorRegex = colors$1 ? new RegExp(`(${Object.keys(colors$1).join('|')})(?!\\w)`, 'g') : /^\b$/;
  const output = config.output.map(value => {
    return getFluidValue(value).replace(cssVariableRegex, variableToRgba).replace(colorRegex, colorToRgba).replace(namedColorRegex, colorToRgba);
  });
  const keyframes = output.map(value => value.match(numberRegex).map(Number));
  const outputRanges = keyframes[0].map((_, i) => keyframes.map(values => {
    if (!(i in values)) {
      throw Error('The arity of each "output" value must be equal');
    }

    return values[i];
  }));
  const interpolators = outputRanges.map(output => createInterpolator(_extends({}, config, {
    output
  })));
  return input => {
    var _output$find;

    const missingUnit = !unitRegex.test(output[0]) && ((_output$find = output.find(value => unitRegex.test(value))) == null ? void 0 : _output$find.replace(numberRegex, ''));
    let i = 0;
    return output[0].replace(numberRegex, () => `${interpolators[i++](input)}${missingUnit || ''}`).replace(rgbaRegex, rgbaRound);
  };
};

const prefix = 'react-spring: ';

const once = fn => {
  const func = fn;
  let called = false;

  if (typeof func != 'function') {
    throw new TypeError(`${prefix}once requires a function parameter`);
  }

  return (...args) => {
    if (!called) {
      func(...args);
      called = true;
    }
  };
};

const warnInterpolate = once(console.warn);
function deprecateInterpolate() {
  warnInterpolate(`${prefix}The "interpolate" function is deprecated in v9 (use "to" instead)`);
}
const warnDirectCall = once(console.warn);
function deprecateDirectCall() {
  warnDirectCall(`${prefix}Directly calling start instead of using the api object is deprecated in v9 (use ".start" instead), this will be removed in later 0.X.0 versions`);
}

function isAnimatedString(value) {
  return is.str(value) && (value[0] == '#' || /\d/.test(value) || !isSSR() && cssVariableRegex.test(value) || value in (colors$1 || {}));
}

const useIsomorphicLayoutEffect = isSSR() ? react__WEBPACK_IMPORTED_MODULE_1__.useEffect : react__WEBPACK_IMPORTED_MODULE_1__.useLayoutEffect;

const useIsMounted = () => {
  const isMounted = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)(false);
  useIsomorphicLayoutEffect(() => {
    isMounted.current = true;
    return () => {
      isMounted.current = false;
    };
  }, []);
  return isMounted;
};

function useForceUpdate() {
  const update = (0,react__WEBPACK_IMPORTED_MODULE_1__.useState)()[1];
  const isMounted = useIsMounted();
  return () => {
    if (isMounted.current) {
      update(Math.random());
    }
  };
}

function useMemoOne(getResult, inputs) {
  const [initial] = (0,react__WEBPACK_IMPORTED_MODULE_1__.useState)(() => ({
    inputs,
    result: getResult()
  }));
  const committed = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)();
  const prevCache = committed.current;
  let cache = prevCache;

  if (cache) {
    const useCache = Boolean(inputs && cache.inputs && areInputsEqual(inputs, cache.inputs));

    if (!useCache) {
      cache = {
        inputs,
        result: getResult()
      };
    }
  } else {
    cache = initial;
  }

  (0,react__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    committed.current = cache;

    if (prevCache == initial) {
      initial.inputs = initial.result = undefined;
    }
  }, [cache]);
  return cache.result;
}

function areInputsEqual(next, prev) {
  if (next.length !== prev.length) {
    return false;
  }

  for (let i = 0; i < next.length; i++) {
    if (next[i] !== prev[i]) {
      return false;
    }
  }

  return true;
}

const useOnce = effect => (0,react__WEBPACK_IMPORTED_MODULE_1__.useEffect)(effect, emptyDeps);
const emptyDeps = [];

function usePrev(value) {
  const prevRef = (0,react__WEBPACK_IMPORTED_MODULE_1__.useRef)();
  (0,react__WEBPACK_IMPORTED_MODULE_1__.useEffect)(() => {
    prevRef.current = value;
  });
  return prevRef.current;
}

const useReducedMotion = () => {
  const [reducedMotion, setReducedMotion] = (0,react__WEBPACK_IMPORTED_MODULE_1__.useState)(null);
  useIsomorphicLayoutEffect(() => {
    const mql = window.matchMedia('(prefers-reduced-motion)');

    const handleMediaChange = e => {
      setReducedMotion(e.matches);
      assign({
        skipAnimation: e.matches
      });
    };

    handleMediaChange(mql);
    mql.addEventListener('change', handleMediaChange);
    return () => {
      mql.removeEventListener('change', handleMediaChange);
    };
  }, []);
  return reducedMotion;
};




/***/ }),

/***/ "./node_modules/@react-spring/types/animated.js":
/*!******************************************************!*\
  !*** ./node_modules/@react-spring/types/animated.js ***!
  \******************************************************/
/***/ (function() {



/***/ }),

/***/ "./node_modules/@react-spring/types/interpolation.js":
/*!***********************************************************!*\
  !*** ./node_modules/@react-spring/types/interpolation.js ***!
  \***********************************************************/
/***/ (function() {



/***/ }),

/***/ "./node_modules/@react-spring/web/dist/react-spring-web.esm.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@react-spring/web/dist/react-spring-web.esm.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "a": function() { return /* binding */ animated; },
/* harmony export */   "animated": function() { return /* binding */ animated; }
/* harmony export */ });
/* harmony import */ var _react_spring_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @react-spring/core */ "./node_modules/@react-spring/core/dist/react-spring-core.esm.js");
/* harmony reexport (unknown) */ var __WEBPACK_REEXPORT_OBJECT__ = {};
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _react_spring_core__WEBPACK_IMPORTED_MODULE_0__) if(["default","a","animated"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = function(key) { return _react_spring_core__WEBPACK_IMPORTED_MODULE_0__[key]; }.bind(0, __WEBPACK_IMPORT_KEY__)
/* harmony reexport (unknown) */ __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _react_spring_shared__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @react-spring/shared */ "./node_modules/@react-spring/shared/dist/react-spring-shared.esm.js");
/* harmony import */ var _react_spring_animated__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @react-spring/animated */ "./node_modules/@react-spring/animated/dist/react-spring-animated.esm.js");






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

const _excluded$2 = ["style", "children", "scrollTop", "scrollLeft"];
const isCustomPropRE = /^--/;

function dangerousStyleValue(name, value) {
  if (value == null || typeof value === 'boolean' || value === '') return '';
  if (typeof value === 'number' && value !== 0 && !isCustomPropRE.test(name) && !(isUnitlessNumber.hasOwnProperty(name) && isUnitlessNumber[name])) return value + 'px';
  return ('' + value).trim();
}

const attributeCache = {};
function applyAnimatedValues(instance, props) {
  if (!instance.nodeType || !instance.setAttribute) {
    return false;
  }

  const isFilterElement = instance.nodeName === 'filter' || instance.parentNode && instance.parentNode.nodeName === 'filter';

  const _ref = props,
        {
    style,
    children,
    scrollTop,
    scrollLeft
  } = _ref,
        attributes = _objectWithoutPropertiesLoose(_ref, _excluded$2);

  const values = Object.values(attributes);
  const names = Object.keys(attributes).map(name => isFilterElement || instance.hasAttribute(name) ? name : attributeCache[name] || (attributeCache[name] = name.replace(/([A-Z])/g, n => '-' + n.toLowerCase())));

  if (children !== void 0) {
    instance.textContent = children;
  }

  for (let name in style) {
    if (style.hasOwnProperty(name)) {
      const value = dangerousStyleValue(name, style[name]);

      if (isCustomPropRE.test(name)) {
        instance.style.setProperty(name, value);
      } else {
        instance.style[name] = value;
      }
    }
  }

  names.forEach((name, i) => {
    instance.setAttribute(name, values[i]);
  });

  if (scrollTop !== void 0) {
    instance.scrollTop = scrollTop;
  }

  if (scrollLeft !== void 0) {
    instance.scrollLeft = scrollLeft;
  }
}
let isUnitlessNumber = {
  animationIterationCount: true,
  borderImageOutset: true,
  borderImageSlice: true,
  borderImageWidth: true,
  boxFlex: true,
  boxFlexGroup: true,
  boxOrdinalGroup: true,
  columnCount: true,
  columns: true,
  flex: true,
  flexGrow: true,
  flexPositive: true,
  flexShrink: true,
  flexNegative: true,
  flexOrder: true,
  gridRow: true,
  gridRowEnd: true,
  gridRowSpan: true,
  gridRowStart: true,
  gridColumn: true,
  gridColumnEnd: true,
  gridColumnSpan: true,
  gridColumnStart: true,
  fontWeight: true,
  lineClamp: true,
  lineHeight: true,
  opacity: true,
  order: true,
  orphans: true,
  tabSize: true,
  widows: true,
  zIndex: true,
  zoom: true,
  fillOpacity: true,
  floodOpacity: true,
  stopOpacity: true,
  strokeDasharray: true,
  strokeDashoffset: true,
  strokeMiterlimit: true,
  strokeOpacity: true,
  strokeWidth: true
};

const prefixKey = (prefix, key) => prefix + key.charAt(0).toUpperCase() + key.substring(1);

const prefixes = ['Webkit', 'Ms', 'Moz', 'O'];
isUnitlessNumber = Object.keys(isUnitlessNumber).reduce((acc, prop) => {
  prefixes.forEach(prefix => acc[prefixKey(prefix, prop)] = acc[prop]);
  return acc;
}, isUnitlessNumber);

const _excluded$1 = ["x", "y", "z"];
const domTransforms = /^(matrix|translate|scale|rotate|skew)/;
const pxTransforms = /^(translate)/;
const degTransforms = /^(rotate|skew)/;

const addUnit = (value, unit) => _react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.is.num(value) && value !== 0 ? value + unit : value;

const isValueIdentity = (value, id) => _react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.is.arr(value) ? value.every(v => isValueIdentity(v, id)) : _react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.is.num(value) ? value === id : parseFloat(value) === id;

class AnimatedStyle extends _react_spring_animated__WEBPACK_IMPORTED_MODULE_3__.AnimatedObject {
  constructor(_ref) {
    let {
      x,
      y,
      z
    } = _ref,
        style = _objectWithoutPropertiesLoose(_ref, _excluded$1);

    const inputs = [];
    const transforms = [];

    if (x || y || z) {
      inputs.push([x || 0, y || 0, z || 0]);
      transforms.push(xyz => [`translate3d(${xyz.map(v => addUnit(v, 'px')).join(',')})`, isValueIdentity(xyz, 0)]);
    }

    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.eachProp)(style, (value, key) => {
      if (key === 'transform') {
        inputs.push([value || '']);
        transforms.push(transform => [transform, transform === '']);
      } else if (domTransforms.test(key)) {
        delete style[key];
        if (_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.is.und(value)) return;
        const unit = pxTransforms.test(key) ? 'px' : degTransforms.test(key) ? 'deg' : '';
        inputs.push((0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.toArray)(value));
        transforms.push(key === 'rotate3d' ? ([x, y, z, deg]) => [`rotate3d(${x},${y},${z},${addUnit(deg, unit)})`, isValueIdentity(deg, 0)] : input => [`${key}(${input.map(v => addUnit(v, unit)).join(',')})`, isValueIdentity(input, key.startsWith('scale') ? 1 : 0)]);
      }
    });

    if (inputs.length) {
      style.transform = new FluidTransform(inputs, transforms);
    }

    super(style);
  }

}

class FluidTransform extends _react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.FluidValue {
  constructor(inputs, transforms) {
    super();
    this._value = null;
    this.inputs = inputs;
    this.transforms = transforms;
  }

  get() {
    return this._value || (this._value = this._get());
  }

  _get() {
    let transform = '';
    let identity = true;
    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.each)(this.inputs, (input, i) => {
      const arg1 = (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.getFluidValue)(input[0]);
      const [t, id] = this.transforms[i](_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.is.arr(arg1) ? arg1 : input.map(_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.getFluidValue));
      transform += ' ' + t;
      identity = identity && id;
    });
    return identity ? 'none' : transform;
  }

  observerAdded(count) {
    if (count == 1) (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.each)(this.inputs, input => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.each)(input, value => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.hasFluidValue)(value) && (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.addFluidObserver)(value, this)));
  }

  observerRemoved(count) {
    if (count == 0) (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.each)(this.inputs, input => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.each)(input, value => (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.hasFluidValue)(value) && (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.removeFluidObserver)(value, this)));
  }

  eventObserved(event) {
    if (event.type == 'change') {
      this._value = null;
    }

    (0,_react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.callFluidObservers)(this, event);
  }

}

const primitives = ['a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'bdi', 'bdo', 'big', 'blockquote', 'body', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'data', 'datalist', 'dd', 'del', 'details', 'dfn', 'dialog', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header', 'hgroup', 'hr', 'html', 'i', 'iframe', 'img', 'input', 'ins', 'kbd', 'keygen', 'label', 'legend', 'li', 'link', 'main', 'map', 'mark', 'menu', 'menuitem', 'meta', 'meter', 'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'output', 'p', 'param', 'picture', 'pre', 'progress', 'q', 'rp', 'rt', 'ruby', 's', 'samp', 'script', 'section', 'select', 'small', 'source', 'span', 'strong', 'style', 'sub', 'summary', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'track', 'u', 'ul', 'var', 'video', 'wbr', 'circle', 'clipPath', 'defs', 'ellipse', 'foreignObject', 'g', 'image', 'line', 'linearGradient', 'mask', 'path', 'pattern', 'polygon', 'polyline', 'radialGradient', 'rect', 'stop', 'svg', 'text', 'tspan'];

const _excluded = ["scrollTop", "scrollLeft"];
_react_spring_core__WEBPACK_IMPORTED_MODULE_0__.Globals.assign({
  batchedUpdates: react_dom__WEBPACK_IMPORTED_MODULE_1__.unstable_batchedUpdates,
  createStringInterpolator: _react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.createStringInterpolator,
  colors: _react_spring_shared__WEBPACK_IMPORTED_MODULE_2__.colors
});
const host = (0,_react_spring_animated__WEBPACK_IMPORTED_MODULE_3__.createHost)(primitives, {
  applyAnimatedValues,
  createAnimatedStyle: style => new AnimatedStyle(style),
  getComponentProps: _ref => {
    let props = _objectWithoutPropertiesLoose(_ref, _excluded);

    return props;
  }
});
const animated = host.animated;




/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/icon/index.js":
/*!******************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/icon/index.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/**
 * WordPress dependencies
 */

/** @typedef {{icon: JSX.Element, size?: number} & import('@wordpress/primitives').SVGProps} IconProps */

/**
 * Return an SVG icon.
 *
 * @param {IconProps} props icon is the SVG component to render
 *                          size is a number specifiying the icon size in pixels
 *                          Other props will be passed to wrapped SVG component
 *
 * @return {JSX.Element}  Icon component
 */

function Icon(_ref) {
  let {
    icon,
    size = 24,
    ...props
  } = _ref;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.cloneElement)(icon, {
    width: size,
    height: size,
    ...props
  });
}

/* harmony default export */ __webpack_exports__["default"] = (Icon);
//# sourceMappingURL=index.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/chevron-left.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/chevron-left.js ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const chevronLeft = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M14.6 7l-1.2-1L8 12l5.4 6 1.2-1-4.6-5z"
}));
/* harmony default export */ __webpack_exports__["default"] = (chevronLeft);
//# sourceMappingURL=chevron-left.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/chevron-right.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/chevron-right.js ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const chevronRight = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M10.6 6L9.4 7l4.6 5-4.6 5 1.2 1 5.4-6z"
}));
/* harmony default export */ __webpack_exports__["default"] = (chevronRight);
//# sourceMappingURL=chevron-right.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/close-small.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/close-small.js ***!
  \***************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const closeSmall = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 13.061z"
}));
/* harmony default export */ __webpack_exports__["default"] = (closeSmall);
//# sourceMappingURL=close-small.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/color.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/color.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const color = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  viewBox: "0 0 24 24",
  xmlns: "http://www.w3.org/2000/svg"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M17.2 10.9c-.5-1-1.2-2.1-2.1-3.2-.6-.9-1.3-1.7-2.1-2.6L12 4l-1 1.1c-.6.9-1.3 1.7-2 2.6-.8 1.2-1.5 2.3-2 3.2-.6 1.2-1 2.2-1 3 0 3.4 2.7 6.1 6.1 6.1s6.1-2.7 6.1-6.1c0-.8-.3-1.8-1-3zm-5.1 7.6c-2.5 0-4.6-2.1-4.6-4.6 0-.3.1-1 .8-2.3.5-.9 1.1-1.9 2-3.1.7-.9 1.3-1.7 1.8-2.3.7.8 1.3 1.6 1.8 2.3.8 1.1 1.5 2.2 2 3.1.7 1.3.8 2 .8 2.3 0 2.5-2.1 4.6-4.6 4.6z"
}));
/* harmony default export */ __webpack_exports__["default"] = (color);
//# sourceMappingURL=color.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/create.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/create.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const create = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M16 11.2h-3.2V8h-1.6v3.2H8v1.6h3.2V16h1.6v-3.2H16z"
}));
/* harmony default export */ __webpack_exports__["default"] = (create);
//# sourceMappingURL=create.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/layout.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/layout.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const layout = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M18 5.5H6a.5.5 0 00-.5.5v3h13V6a.5.5 0 00-.5-.5zm.5 5H10v8h8a.5.5 0 00.5-.5v-7.5zm-10 0h-3V18a.5.5 0 00.5.5h2.5v-8zM6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z"
}));
/* harmony default export */ __webpack_exports__["default"] = (layout);
//# sourceMappingURL=layout.js.map

/***/ }),

/***/ "./node_modules/@wordpress/icons/build-module/library/typography.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/typography.js ***!
  \**************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const typography = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M6.9 7L3 17.8h1.7l1-2.8h4.1l1 2.8h1.7L8.6 7H6.9zm-.7 6.6l1.5-4.3 1.5 4.3h-3zM21.6 17c-.1.1-.2.2-.3.2-.1.1-.2.1-.4.1s-.3-.1-.4-.2c-.1-.1-.1-.3-.1-.6V12c0-.5 0-1-.1-1.4-.1-.4-.3-.7-.5-1-.2-.2-.5-.4-.9-.5-.4 0-.8-.1-1.3-.1s-1 .1-1.4.2c-.4.1-.7.3-1 .4-.2.2-.4.3-.6.5-.1.2-.2.4-.2.7 0 .3.1.5.2.8.2.2.4.3.8.3.3 0 .6-.1.8-.3.2-.2.3-.4.3-.7 0-.3-.1-.5-.2-.7-.2-.2-.4-.3-.6-.4.2-.2.4-.3.7-.4.3-.1.6-.1.8-.1.3 0 .6 0 .8.1.2.1.4.3.5.5.1.2.2.5.2.9v1.1c0 .3-.1.5-.3.6-.2.2-.5.3-.9.4-.3.1-.7.3-1.1.4-.4.1-.8.3-1.1.5-.3.2-.6.4-.8.7-.2.3-.3.7-.3 1.2 0 .6.2 1.1.5 1.4.3.4.9.5 1.6.5.5 0 1-.1 1.4-.3.4-.2.8-.6 1.1-1.1 0 .4.1.7.3 1 .2.3.6.4 1.2.4.4 0 .7-.1.9-.2.2-.1.5-.3.7-.4h-.3zm-3-.9c-.2.4-.5.7-.8.8-.3.2-.6.2-.8.2-.4 0-.6-.1-.9-.3-.2-.2-.3-.6-.3-1.1 0-.5.1-.9.3-1.2s.5-.5.8-.7c.3-.2.7-.3 1-.5.3-.1.6-.3.7-.6v3.4z"
}));
/* harmony default export */ __webpack_exports__["default"] = (typography);
//# sourceMappingURL=typography.js.map

/***/ }),

/***/ "../components/HelperFunction.js":
/*!***************************************!*\
  !*** ../components/HelperFunction.js ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "addSVGAttributes": function() { return /* binding */ addSVGAttributes; },
/* harmony export */   "animationAttr": function() { return /* binding */ animationAttr; },
/* harmony export */   "borderCss": function() { return /* binding */ borderCss; },
/* harmony export */   "createElementFromHTMLString": function() { return /* binding */ createElementFromHTMLString; },
/* harmony export */   "filterJsCss": function() { return /* binding */ filterJsCss; },
/* harmony export */   "generateBlockId": function() { return /* binding */ generateBlockId; },
/* harmony export */   "generateCss": function() { return /* binding */ generateCss; },
/* harmony export */   "generateRandomIdForInput": function() { return /* binding */ generateRandomIdForInput; },
/* harmony export */   "getBackgroundCss": function() { return /* binding */ getBackgroundCss; },
/* harmony export */   "getBlockId": function() { return /* binding */ getBlockId; },
/* harmony export */   "getBorderCss": function() { return /* binding */ getBorderCss; },
/* harmony export */   "getMarginCss": function() { return /* binding */ getMarginCss; },
/* harmony export */   "getPaddingCss": function() { return /* binding */ getPaddingCss; },
/* harmony export */   "getTypographyCss": function() { return /* binding */ getTypographyCss; },
/* harmony export */   "gradientBackground": function() { return /* binding */ gradientBackground; },
/* harmony export */   "gradientValue": function() { return /* binding */ gradientValue; },
/* harmony export */   "handleResponsiveMultiValue": function() { return /* binding */ handleResponsiveMultiValue; },
/* harmony export */   "handleResponsiveSingleValue": function() { return /* binding */ handleResponsiveSingleValue; },
/* harmony export */   "isPremiumBlock": function() { return /* binding */ isPremiumBlock; },
/* harmony export */   "marginCss": function() { return /* binding */ marginCss; },
/* harmony export */   "paddingCss": function() { return /* binding */ paddingCss; },
/* harmony export */   "parseIcon": function() { return /* binding */ parseIcon; },
/* harmony export */   "typographyCss": function() { return /* binding */ typographyCss; },
/* harmony export */   "videoBackground": function() { return /* binding */ videoBackground; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/hooks */ "@wordpress/hooks");
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _typography_util__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./typography/util */ "../components/typography/util.js");
/* harmony import */ var html_react_parser__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! html-react-parser */ "../../node_modules/html-react-parser/esm/index.mjs");




const gradientBackground = (value, deviceType) => {
  const {
    backgroundType,
    backgroundColor,
    backgroundRepeat,
    backgroundPosition,
    fixed,
    backgroundSize,
    gradientColorTwo,
    gradientPosition,
    gradientType,
    gradientLocationOne,
    gradientLocationTwo,
    gradientAngle,
    backgroundImageURL
  } = value;
  let btnGrad, btnGrad2, btnbg;

  if (undefined !== backgroundType && "gradient" === backgroundType) {
    btnGrad = "transparent" === backgroundColor || undefined === backgroundColor ? "rgba(255,255,255,0)" : backgroundColor;
    btnGrad2 = undefined !== gradientColorTwo && undefined !== gradientColorTwo && "" !== gradientColorTwo ? gradientColorTwo : "#777";

    if ("radial" === gradientType) {
      btnbg = `radial-gradient(at ${gradientPosition}, ${btnGrad} ${gradientLocationOne}%, ${btnGrad2} ${gradientLocationTwo}%)`;
    } else if ("radial" !== gradientType) {
      btnbg = `linear-gradient(${gradientAngle}deg, ${btnGrad} ${gradientLocationOne}%, ${btnGrad2} ${gradientLocationTwo}%)`;
    }
  } else {
    btnbg = backgroundImageURL ? `url('${backgroundImageURL}')` : "";
  }

  return {
    backgroundColor: backgroundType === "transparent" ? "transparent" : backgroundColor,
    backgroundImage: backgroundType === "transparent" ? "" : gradientValue(value),
    backgroundRepeat: handleResponsiveSingleValue(deviceType, backgroundRepeat),
    backgroundPosition: handleResponsiveSingleValue(deviceType, backgroundPosition),
    backgroundSize: handleResponsiveSingleValue(deviceType, backgroundSize),
    backgroundAttachment: fixed ? "fixed" : "unset"
  };
};
const borderCss = (value, device) => {
  return {
    borderStyle: value === null || value === void 0 ? void 0 : value.borderType,
    borderWidth: handleResponsiveMultiValue(device, value === null || value === void 0 ? void 0 : value.borderWidth),
    borderColor: value === null || value === void 0 ? void 0 : value.borderColor,
    borderRadius: handleResponsiveMultiValue(device, value === null || value === void 0 ? void 0 : value.borderRadius)
  };
};
const parseIcon = icon => {
  const newIcon = icon.trim();
  const parseOptions = {
    trim: true,
    replace: _ref => {
      let {
        attribs,
        children,
        name,
        parent,
        type
      } = _ref;

      if (type !== "tag" || !parent && name !== "svg" || !name) {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null);
      } // Hyphens or colons in attribute names are lost in the default
      // process of html-react-parser. Spreading the attribs object as
      // props avoids the loss. Style does need to be handled separately.


      const Tag = `${name}`;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Tag, attribs, (0,html_react_parser__WEBPACK_IMPORTED_MODULE_3__.domToReact)(children, parseOptions));
    }
  };
  return (0,html_react_parser__WEBPACK_IMPORTED_MODULE_3__["default"])(newIcon, parseOptions);
};
const paddingCss = (value, device) => {
  return {
    padding: handleResponsiveMultiValue(device, value)
  };
};
const marginCss = (value, device) => {
  return {
    margin: handleResponsiveMultiValue(device, value)
  };
};
const typographyCss = (value, device) => {
  var _value$fontSize;

  const styles = {
    fontSize: handleResponsiveSingleValue(device, value["fontSize"]) && `${handleResponsiveSingleValue(device, value["fontSize"])}${value === null || value === void 0 ? void 0 : (_value$fontSize = value.fontSize) === null || _value$fontSize === void 0 ? void 0 : _value$fontSize.unit[device]}`,
    fontStyle: value === null || value === void 0 ? void 0 : value.fontStyle,
    fontFamily: (value === null || value === void 0 ? void 0 : value.fontFamily) === "Default" ? " " : (0,_typography_util__WEBPACK_IMPORTED_MODULE_2__.getFontFamily)(value.fontFamily),
    fontWeight: (value === null || value === void 0 ? void 0 : value.fontWeight) === "Default" ? " " : value === null || value === void 0 ? void 0 : value.fontWeight,
    letterSpacing: handleResponsiveSingleValue(device, value === null || value === void 0 ? void 0 : value.letterSpacing) && `${handleResponsiveSingleValue(device, value === null || value === void 0 ? void 0 : value.letterSpacing)}px`,
    textDecoration: value === null || value === void 0 ? void 0 : value.textDecoration,
    textTransform: value === null || value === void 0 ? void 0 : value.textTransform,
    lineHeight: handleResponsiveSingleValue(device, value === null || value === void 0 ? void 0 : value.lineHeight) && `${handleResponsiveSingleValue(device, value === null || value === void 0 ? void 0 : value.lineHeight)}px`
  };
  return { ...styles
  };
};
const generateBlockId = clientId => {
  return clientId.split("-")[4];
};
const generateCss = styles => {
  let styleCss = "";

  for (const selector in styles) {
    const selectorStyles = styles[selector];
    const filteredStyles = Object.keys(selectorStyles).map(property => {
      const value = selectorStyles[property];
      const valueWithoutUnits = value ? value.toString().replaceAll(/px|em|rem|!important|%/g, "").replaceAll(/\s/g, "") : "";

      if (value && !value.toString().includes("undefined") && valueWithoutUnits) {
        return `${property}: ${value};`;
      }
    }).filter(style => !!style).join("\n");
    styleCss += `${selector}{
                    ${filteredStyles}
                }\n`;
  }

  return styleCss;
};
const filterJsCss = styles => {
  const asArray = Object.entries(styles);
  const filtered = asArray.filter(_ref2 => {
    let [property, value] = _ref2;
    const valueWithoutUnits = value ? value.toString().replaceAll(/px|em|rem|!important|%/g, "").replaceAll(/\s/g, "") : "";
    return value && !value.toString().includes("undefined") && valueWithoutUnits;
  });
  const filteredStyles = Object.fromEntries(filtered);
  return filteredStyles;
};
const handleResponsiveSingleValue = (device, val) => {
  let data;

  if (val && val.Desktop !== "") {
    data = val.Desktop;
  }

  if (val && val.Tablet !== "" && (device === "Tablet" || device === "Mobile")) {
    data = val.Tablet;
  }

  if (val && val.Mobile !== "" && device === "Mobile") {
    data = val.Mobile;
  }

  return data;
};
const handleResponsiveMultiValue = (device, val) => {
  let data;

  if (val && Object.values(val.Desktop).some(x => x !== "")) {
    let {
      top,
      right,
      bottom,
      left
    } = val["Desktop"];
    data = `${top ? top : "0"}${typeof val.unit === "object" ? val.unit["Desktop"] : "px"} ${right ? right : "0"}${typeof val.unit === "object" ? val.unit["Desktop"] : "px"} ${bottom ? bottom : "0"}${typeof val.unit === "object" ? val.unit["Desktop"] : "px"} ${left ? left : "0"}${typeof val.unit === "object" ? val.unit["Desktop"] : "px"}`;
  }

  if (val && Object.values(val.Tablet).some(x => x !== "") && (device === "Tablet" || device === "Mobile")) {
    let {
      top,
      right,
      bottom,
      left
    } = val["Tablet"];
    data = `${top ? top : "0"}${typeof val.unit === "object" ? val.unit["Tablet"] : "px"} ${right ? right : "0"}${val.unit ? val.unit["Tablet"] : "px"} ${bottom ? bottom : "0"}${typeof val.unit === "object" ? val.unit["Tablet"] : "px"} ${left ? left : "0"}${typeof val.unit === "object" ? val.unit["Tablet"] : "px"}`;
  }

  if (val && Object.values(val.Mobile).some(x => x !== "") && device === "Mobile") {
    let {
      top,
      right,
      bottom,
      left
    } = val["Mobile"];
    data = `${top ? top : "0"}${typeof val.unit === "object" ? val.unit["Mobile"] : "px"} ${right ? right : "0"}${typeof val.unit === "object" ? val.unit["Mobile"] : "px"} ${bottom ? bottom : "0"}${typeof val.unit === "object" ? val.unit["Mobile"] : "px"} ${left ? left : "0"}${typeof val.unit === "object" ? val.unit["Mobile"] : "px"}`;
  }

  return data;
};
const videoBackground = (backgroundType, videoSource, videoURL, bgExternalVideo) => {
  if (backgroundType == "video") {
    if (videoSource == "local") {
      if (videoURL) {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
          className: "premium-blocks-video-bg-wrap"
        }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("video", {
          className: "premium-blocks-video-bg",
          autoPlay: true,
          muted: true,
          loop: true
        }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("source", {
          src: videoURL
        })));
      }
    }

    if (videoSource == "external") {
      if (bgExternalVideo) {
        let video = bgExternalVideo,
            src = "";

        if (video.match("youtube|youtu.be")) {
          let id = 0;

          if (video.match("embed") && video.split(/embed\//)[1]) {
            id = video.split(/embed\//)[1].split('"')[0];
          } else if (video.split(/v\/|v=|youtu\.be\//)[1]) {
            id = video.split(/v\/|v=|youtu\.be\//)[1].split(/[?&]/)[0];
          }

          src = "//www.youtube.com/embed/" + id + "?playlist=" + id + "&iv_load_policy=3&enablejsapi=1&disablekb=1&autoplay=1&mute=1&controls=0&showinfo=0&rel=0&loop=1&wmode=transparent&widgetid=1";
        } else if (video.match("vimeo.com")) {
          let id = video.split(/video\/|https:\/\/vimeo\.com\//)[1].split(/[?&]/)[0];
          src = "//player.vimeo.com/video/" + id + "?autoplay=1&loop=1&title=0&byline=0&portrait=0";
        }

        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
          className: "premium-blocks-video-bg-wrap"
        }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("iframe", {
          src: src,
          frameBorder: "0",
          allowFullScreen: true
        }));
      }
    }
  }
};
const animationAttr = data => {
  if (typeof data !== "undefined" && typeof data.name !== "undefined" && data.openAnimation) {
    return {
      "data-premiumanimation": JSON.stringify(data)
    };
  } else {
    return {};
  }
};
const gradientValue = value => {
  const {
    backgroundType,
    backgroundColor,
    gradientColorTwo,
    gradientPosition,
    gradientType,
    gradientLocationOne,
    gradientLocationTwo,
    gradientAngle,
    backgroundImageURL
  } = value;
  let btnGrad, btnGrad2, btnbg;

  if (undefined !== backgroundType && "gradient" === backgroundType) {
    btnGrad = "transparent" === backgroundColor || undefined === backgroundColor ? "rgba(255,255,255,0)" : backgroundColor;
    btnGrad2 = undefined !== gradientColorTwo && undefined !== gradientColorTwo && "" !== gradientColorTwo ? gradientColorTwo : "#777";

    if ("radial" === gradientType) {
      btnbg = `radial-gradient(at ${gradientPosition}, ${btnGrad} ${gradientLocationOne}%, ${btnGrad2} ${gradientLocationTwo}%)`;
    } else if ("radial" !== gradientType) {
      btnbg = `linear-gradient(${gradientAngle}deg, ${btnGrad} ${gradientLocationOne}%, ${btnGrad2} ${gradientLocationTwo}%)`;
    }
  } else {
    btnbg = backgroundImageURL ? `url('${backgroundImageURL}')` : "none";
  }

  return btnbg;
};
const getBorderCss = (value, deviceType) => {
  return {
    "border-style": value === null || value === void 0 ? void 0 : value.borderType,
    "border-width": `${handleResponsiveMultiValue(deviceType, value === null || value === void 0 ? void 0 : value.borderWidth)}`,
    "border-color": `${value === null || value === void 0 ? void 0 : value.borderColor}`,
    "border-radius": `${handleResponsiveMultiValue(deviceType, value === null || value === void 0 ? void 0 : value.borderRadius)}`
  };
};
const getPaddingCss = (value, deviceType) => {
  return {
    padding: `${handleResponsiveMultiValue(deviceType, value)}`
  };
};
const getMarginCss = (value, deviceType) => {
  return {
    margin: `${handleResponsiveMultiValue(deviceType, value)}`
  };
};
const getTypographyCss = (value, deviceType) => {
  var _value$fontSize2, _value$letterSpacing, _value$lineHeight;

  return {
    "font-size": `${handleResponsiveSingleValue(deviceType, value === null || value === void 0 ? void 0 : value.fontSize)}${value === null || value === void 0 ? void 0 : (_value$fontSize2 = value.fontSize) === null || _value$fontSize2 === void 0 ? void 0 : _value$fontSize2.unit[deviceType]}`,
    "font-style": value === null || value === void 0 ? void 0 : value.fontStyle,
    "font-family": value.fontFamily !== "Default" ? (0,_typography_util__WEBPACK_IMPORTED_MODULE_2__.getFontFamily)(value === null || value === void 0 ? void 0 : value.fontFamily) : "",
    "font-weight": value.fontWeight !== "Default" ? value === null || value === void 0 ? void 0 : value.fontWeight : "",
    "letter-spacing": `${handleResponsiveSingleValue(deviceType, value === null || value === void 0 ? void 0 : value.letterSpacing)}${value === null || value === void 0 ? void 0 : (_value$letterSpacing = value.letterSpacing) === null || _value$letterSpacing === void 0 ? void 0 : _value$letterSpacing.unit}`,
    "line-height": `${handleResponsiveSingleValue(deviceType, value === null || value === void 0 ? void 0 : value.lineHeight)}${value === null || value === void 0 ? void 0 : (_value$lineHeight = value.lineHeight) === null || _value$lineHeight === void 0 ? void 0 : _value$lineHeight.unit}`,
    "text-decoration": value === null || value === void 0 ? void 0 : value.textDecoration,
    "text-transform": value === null || value === void 0 ? void 0 : value.textTransform
  };
};
const getBackgroundCss = function (value, deviceType) {
  let additionalWord = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "";
  const {
    backgroundType,
    backgroundColor,
    backgroundRepeat,
    backgroundPosition,
    fixed,
    backgroundSize,
    gradientColorTwo,
    gradientPosition,
    gradientType,
    gradientLocationOne,
    gradientLocationTwo,
    gradientAngle,
    backgroundImageURL
  } = value;
  let btnGrad, btnGrad2, btnbg;

  if (undefined !== backgroundType && "gradient" === backgroundType) {
    btnGrad = "transparent" === backgroundColor || undefined === backgroundColor ? "rgba(255,255,255,0)" : backgroundColor;
    btnGrad2 = undefined !== gradientColorTwo && undefined !== gradientColorTwo && "" !== gradientColorTwo ? gradientColorTwo : "#777";

    if ("radial" === gradientType) {
      btnbg = `radial-gradient(at ${gradientPosition}, ${btnGrad} ${gradientLocationOne}%, ${btnGrad2} ${gradientLocationTwo}%)`;
    } else if ("radial" !== gradientType) {
      btnbg = `linear-gradient(${gradientAngle}deg, ${btnGrad} ${gradientLocationOne}%, ${btnGrad2} ${gradientLocationTwo}%)`;
    }
  } else {
    btnbg = backgroundImageURL ? `url('${backgroundImageURL}')` : "";
  }

  if (backgroundType == "") {
    return;
  }

  return {
    "background-color": `${backgroundType === "transparent" ? "transparent" : backgroundColor}${additionalWord}`,
    "background-image": `${gradientValue(value)}${additionalWord}`,
    "background-repeat": `${handleResponsiveSingleValue(deviceType, backgroundRepeat)}${additionalWord}`,
    "background-position": `${handleResponsiveSingleValue(deviceType, backgroundPosition)}${additionalWord}`,
    "background-size": `${handleResponsiveSingleValue(deviceType, backgroundSize)}${additionalWord}`,
    "background-attachment": `${fixed ? "fixed" : "unset"}${additionalWord}`
  };
};
const createElementFromHTMLString = (htmlString, contentRef, name, blockId) => {
  if (contentRef && contentRef.current) {
    let container = contentRef.current.querySelector(`#premium-${name}-svg-${blockId}`);
    container.innerHTML = htmlString;
    return container.firstElementChild;
  }
};
const addSVGAttributes = function (svgHTML, contentRef, name, blockId) {
  let attributesToAdd = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : {};
  let attributesToRemove = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : [];
  const svgNode = createElementFromHTMLString(svgHTML, contentRef, name, blockId);

  if (!svgNode) {
    return "";
  }

  Object.keys(attributesToAdd).forEach(key => {
    svgNode.setAttribute(key, attributesToAdd[key]);
  });
  attributesToRemove.forEach(key => {
    svgNode.removeAttribute(key);
  });
  return svgNode.outerHTML;
};
const isPremiumBlock = blockName => {
  return blockName.startsWith("premium/");
};

const addVariationIdAttribute = (settings, name) => {
  if (!isPremiumBlock(name)) {
    return settings;
  }

  if (typeof settings.attributes !== "undefined") {
    settings.attributes = Object.assign(settings.attributes, {
      vUniqueId: {
        type: "string",
        default: ""
      }
    });
  }

  return settings;
};

(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__.addFilter)("blocks.registerBlockType", "pbg/variation-id-attribute", addVariationIdAttribute);
const getBlockId = (blockName, attributes) => {
  let uniqueId = "";

  switch (blockName) {
    case "premium/container":
      if (attributes.block_id && attributes.block_id !== "") {
        uniqueId = `premium-container-${attributes.block_id}`;
      }

      break;

    default:
      uniqueId = attributes.blockId || "";
      break;
  }

  return uniqueId;
};
const generateRandomIdForInput = () => {
  // Id from 8 numbers and letters.
  const id = Math.random().toString(36).substring(2, 10);
  return id;
};

/***/ }),

/***/ "../components/RangeControl/range-control.js":
/*!***************************************************!*\
  !*** ../components/RangeControl/range-control.js ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ PremiumRange; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const {
  RangeControl
} = wp.components;
function PremiumRange(_ref) {
  let {
    onChange,
    value = "",
    step = 1,
    max = 100,
    min = 0,
    beforeIcon = "",
    help = "",
    defaultValue
  } = _ref;

  const onChangInput = event => {
    if (event.target.value === "") {
      onChange(undefined);
      return;
    }

    const newValue = Number(event.target.value);

    if (newValue === "") {
      onChange(undefined);
      return;
    }

    if (min < -0.1) {
      if (newValue > max) {
        onChange(max);
      } else if (newValue < min && newValue !== "-") {
        onChange(min);
      } else {
        onChange(newValue);
      }
    } else {
      if (newValue > max) {
        onChange(max);
      } else if (newValue < -0.1) {
        onChange(min);
      } else {
        onChange(newValue);
      }
    }
  };

  return [onChange && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wrapper"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `input-field-wrapper active`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(RangeControl, {
    className: "premium-range-value-input",
    beforeIcon: beforeIcon,
    value: value,
    onChange: newVal => onChange(newVal),
    min: min,
    max: max,
    step: step,
    help: help,
    withInputField: false
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium_range_value"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    value: value,
    onChange: onChangInput,
    min: min,
    max: max,
    step: step,
    type: "number",
    className: "components-text-control__input"
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: "premium-slider-reset",
    disabled: value == defaultValue,
    onClick: e => {
      e.preventDefault();
      onChange(defaultValue);
    }
  }))];
}

/***/ }),

/***/ "../components/RangeControl/responsive-range-control.js":
/*!**************************************************************!*\
  !*** ../components/RangeControl/responsive-range-control.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ ResponsiveRangeControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _single_range_control__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./single-range-control */ "../components/RangeControl/single-range-control.js");

const {
  useSelect,
  useDispatch
} = wp.data;
const {
  useState
} = wp.element;
const {
  __
} = wp.i18n;

function ResponsiveRangeControl(_ref) {
  let {
    label,
    onChange,
    value,
    step = 1,
    max = 100,
    min = 0,
    unit = "",
    showUnit = false,
    units = ["px", "em", "rem"],
    defaultValue
  } = _ref;
  let defaultValues = {
    Desktop: "",
    Tablet: "",
    Mobile: "",
    unit: {
      Desktop: "px",
      Tablet: "px",
      Mobile: "px"
    }
  };
  value = value ? { ...defaultValues,
    ...value
  } : defaultValues;
  const [state, setState] = useState(value);
  const [deviceType, setDeviceType] = useState("Desktop");

  let customSetPreviewDeviceType = device => {
    setDeviceType(device);
  };

  if (wp.data.select("core/edit-post")) {
    const theDevice = useSelect(select => {
      const {
        __experimentalGetPreviewDeviceType = null
      } = select("core/edit-post");
      return __experimentalGetPreviewDeviceType ? __experimentalGetPreviewDeviceType() : "Desktop";
    }, []);

    if (theDevice !== deviceType) {
      setDeviceType(theDevice);
    }

    const {
      __experimentalSetPreviewDeviceType = null
    } = useDispatch("core/edit-post");

    customSetPreviewDeviceType = device => {
      __experimentalSetPreviewDeviceType(device);

      setDeviceType(device);
    };
  }

  const onChangeValue = (value, device) => {
    const updatedState = { ...state
    };
    updatedState[device] = value;
    onChange(updatedState);
    setState(updatedState);
  };

  const onChangeUnit = (value, device) => {
    const updatedState = { ...state["unit"]
    };
    updatedState[device] = value;
    onChange({ ...state,
      unit: { ...updatedState
      }
    });
    setState({ ...state,
      unit: { ...updatedState
      }
    });
  };

  const output = {};
  output.Mobile = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_single_range_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
    device: "mobile",
    value: state["Mobile"],
    onChange: size => onChangeValue(size, "Mobile"),
    min: min,
    max: state["unit"]["Mobile"] === "%" || state["unit"]["Mobile"] === "vw" ? 100 : max,
    step: state["unit"]["Mobile"] === "em" || state["unit"]["Mobile"] === "rem" ? 0.1 : 1,
    showUnit: showUnit,
    unit: showUnit ? unit["Mobile"] : "px",
    defaultValue: defaultValues["Mobile"],
    responsive: true,
    onChangeUnit: val => onChangeUnit(val, "Mobile"),
    label: label,
    units: units
  });
  output.Tablet = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_single_range_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
    device: "tablet",
    value: state["Tablet"],
    onChange: size => onChangeValue(size, "Tablet"),
    min: min,
    max: state["unit"]["Tablet"] === "%" || state["unit"]["Tablet"] === "vw" ? 100 : max,
    step: state["unit"]["Tablet"] === "em" || state["unit"]["Tablet"] === "rem" ? 0.1 : 1,
    showUnit: showUnit,
    unit: showUnit ? unit["Tablet"] : "px",
    defaultValue: defaultValues["Tablet"],
    responsive: true,
    onChangeUnit: val => onChangeUnit(val, "Tablet"),
    label: label,
    units: units
  });
  output.Desktop = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_single_range_control__WEBPACK_IMPORTED_MODULE_1__["default"], {
    device: "desktop",
    value: state["Desktop"],
    onChange: size => onChangeValue(size, "Desktop"),
    min: min,
    max: state["unit"]["Desktop"] === "%" || state["unit"]["Desktop"] === "vw" ? 100 : max,
    step: state["unit"]["Desktop"] === "em" || state["unit"]["Desktop"] === "rem" ? 0.1 : 1,
    showUnit: showUnit,
    unit: showUnit ? unit["Desktop"] : "px",
    defaultValue: defaultValues["Desktop"],
    responsive: true,
    onChangeUnit: val => onChangeUnit(val, "Desktop"),
    label: label,
    units: units
  });
  return [onChange && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-blocks-range-control premium-blocks__base-control`
  }, output[deviceType] ? output[deviceType] : output.Desktop)];
}

/***/ }),

/***/ "../components/RangeControl/single-range-control.js":
/*!**********************************************************!*\
  !*** ../components/RangeControl/single-range-control.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ ResponsiveSingleRangeControl; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _premium_size_units__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../premium-size-units */ "../components/premium-size-units.js");
/* harmony import */ var _range_control__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./range-control */ "../components/RangeControl/range-control.js");
/* harmony import */ var _responsive__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../responsive */ "../components/responsive.js");

const {
  __
} = wp.i18n;


const {
  useSelect,
  useDispatch
} = wp.data;
const {
  useState
} = wp.element;

function ResponsiveSingleRangeControl(_ref) {
  let {
    device = "device",
    onChange,
    value,
    step = 1,
    max = 100,
    min = 0,
    unit = "",
    onChangeUnit,
    showUnit = false,
    units = ["px", "em", "rem"],
    className = "",
    label,
    help,
    defaultValue,
    responsive = false
  } = _ref;
  const [deviceType, setDeviceType] = useState("Desktop");

  let customSetPreviewDeviceType = device => {
    setDeviceType(device);
  };

  if (wp.data.select("core/edit-post")) {
    const theDevice = useSelect(select => {
      const {
        __experimentalGetPreviewDeviceType = null
      } = select("core/edit-post");
      return __experimentalGetPreviewDeviceType ? __experimentalGetPreviewDeviceType() : "Desktop";
    }, []);

    if (theDevice !== deviceType) {
      setDeviceType(theDevice);
    }

    const {
      __experimentalSetPreviewDeviceType = null
    } = useDispatch("core/edit-post");

    customSetPreviewDeviceType = device => {
      __experimentalSetPreviewDeviceType(device);

      setDeviceType(device);
    };
  }

  return [onChange && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-blocks-range-control premium-blocks__base-control`
  }, label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("header", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-slider-title-wrap`,
    style: {
      display: "flex",
      alignItems: "center"
    }
  }, label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "customize-control-title premium-control-title"
  }, label), responsive && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_responsive__WEBPACK_IMPORTED_MODULE_3__["default"], {
    onChange: newDevice => setDeviceType(newDevice)
  })), showUnit && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_premium_size_units__WEBPACK_IMPORTED_MODULE_1__["default"], {
    units: units,
    activeUnit: unit,
    onChangeSizeUnit: newValue => onChangeUnit(newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_range_control__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: undefined !== value ? value : "",
    onChange: size => onChange(size),
    min: min,
    max: max,
    step: step,
    defaultValue: defaultValue
  }))];
}

/***/ }),

/***/ "../components/premium-fonts.js":
/*!**************************************!*\
  !*** ../components/premium-fonts.js ***!
  \**************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
const fonts = {
  "ABeeZee": {
    "name": "ABeeZee"
  },
  "ADLaM Display": {
    "name": "ADLaM Display"
  },
  "Abel": {
    "name": "Abel"
  },
  "Abhaya Libre": {
    "name": "Abhaya Libre"
  },
  "Aboreto": {
    "name": "Aboreto"
  },
  "Abril Fatface": {
    "name": "Abril Fatface"
  },
  "Abyssinica SIL": {
    "name": "Abyssinica SIL"
  },
  "Aclonica": {
    "name": "Aclonica"
  },
  "Acme": {
    "name": "Acme"
  },
  "Actor": {
    "name": "Actor"
  },
  "Adamina": {
    "name": "Adamina"
  },
  "Advent Pro": {
    "name": "Advent Pro"
  },
  "Agdasima": {
    "name": "Agdasima"
  },
  "Aguafina Script": {
    "name": "Aguafina Script"
  },
  "Akatab": {
    "name": "Akatab"
  },
  "Akaya Kanadaka": {
    "name": "Akaya Kanadaka"
  },
  "Akaya Telivigala": {
    "name": "Akaya Telivigala"
  },
  "Akronim": {
    "name": "Akronim"
  },
  "Akshar": {
    "name": "Akshar"
  },
  "Aladin": {
    "name": "Aladin"
  },
  "Alata": {
    "name": "Alata"
  },
  "Alatsi": {
    "name": "Alatsi"
  },
  "Albert Sans": {
    "name": "Albert Sans"
  },
  "Aldrich": {
    "name": "Aldrich"
  },
  "Alef": {
    "name": "Alef"
  },
  "Alegreya": {
    "name": "Alegreya"
  },
  "Alegreya SC": {
    "name": "Alegreya SC"
  },
  "Alegreya Sans": {
    "name": "Alegreya Sans"
  },
  "Alegreya Sans SC": {
    "name": "Alegreya Sans SC"
  },
  "Aleo": {
    "name": "Aleo"
  },
  "Alex Brush": {
    "name": "Alex Brush"
  },
  "Alexandria": {
    "name": "Alexandria"
  },
  "Alfa Slab One": {
    "name": "Alfa Slab One"
  },
  "Alice": {
    "name": "Alice"
  },
  "Alike": {
    "name": "Alike"
  },
  "Alike Angular": {
    "name": "Alike Angular"
  },
  "Alkalami": {
    "name": "Alkalami"
  },
  "Alkatra": {
    "name": "Alkatra"
  },
  "Allan": {
    "name": "Allan"
  },
  "Allerta": {
    "name": "Allerta"
  },
  "Allerta Stencil": {
    "name": "Allerta Stencil"
  },
  "Allison": {
    "name": "Allison"
  },
  "Allura": {
    "name": "Allura"
  },
  "Almarai": {
    "name": "Almarai"
  },
  "Almendra": {
    "name": "Almendra"
  },
  "Almendra Display": {
    "name": "Almendra Display"
  },
  "Almendra SC": {
    "name": "Almendra SC"
  },
  "Alumni Sans": {
    "name": "Alumni Sans"
  },
  "Alumni Sans Collegiate One": {
    "name": "Alumni Sans Collegiate One"
  },
  "Alumni Sans Inline One": {
    "name": "Alumni Sans Inline One"
  },
  "Alumni Sans Pinstripe": {
    "name": "Alumni Sans Pinstripe"
  },
  "Amarante": {
    "name": "Amarante"
  },
  "Amaranth": {
    "name": "Amaranth"
  },
  "Amatic SC": {
    "name": "Amatic SC"
  },
  "Amethysta": {
    "name": "Amethysta"
  },
  "Amiko": {
    "name": "Amiko"
  },
  "Amiri": {
    "name": "Amiri"
  },
  "Amiri Quran": {
    "name": "Amiri Quran"
  },
  "Amita": {
    "name": "Amita"
  },
  "Anaheim": {
    "name": "Anaheim"
  },
  "Andada Pro": {
    "name": "Andada Pro"
  },
  "Andika": {
    "name": "Andika"
  },
  "Anek Bangla": {
    "name": "Anek Bangla"
  },
  "Anek Devanagari": {
    "name": "Anek Devanagari"
  },
  "Anek Gujarati": {
    "name": "Anek Gujarati"
  },
  "Anek Gurmukhi": {
    "name": "Anek Gurmukhi"
  },
  "Anek Kannada": {
    "name": "Anek Kannada"
  },
  "Anek Latin": {
    "name": "Anek Latin"
  },
  "Anek Malayalam": {
    "name": "Anek Malayalam"
  },
  "Anek Odia": {
    "name": "Anek Odia"
  },
  "Anek Tamil": {
    "name": "Anek Tamil"
  },
  "Anek Telugu": {
    "name": "Anek Telugu"
  },
  "Angkor": {
    "name": "Angkor"
  },
  "Annie Use Your Telescope": {
    "name": "Annie Use Your Telescope"
  },
  "Anonymous Pro": {
    "name": "Anonymous Pro"
  },
  "Antic": {
    "name": "Antic"
  },
  "Antic Didone": {
    "name": "Antic Didone"
  },
  "Antic Slab": {
    "name": "Antic Slab"
  },
  "Anton": {
    "name": "Anton"
  },
  "Antonio": {
    "name": "Antonio"
  },
  "Anuphan": {
    "name": "Anuphan"
  },
  "Anybody": {
    "name": "Anybody"
  },
  "Aoboshi One": {
    "name": "Aoboshi One"
  },
  "Arapey": {
    "name": "Arapey"
  },
  "Arbutus": {
    "name": "Arbutus"
  },
  "Arbutus Slab": {
    "name": "Arbutus Slab"
  },
  "Architects Daughter": {
    "name": "Architects Daughter"
  },
  "Archivo": {
    "name": "Archivo"
  },
  "Archivo Black": {
    "name": "Archivo Black"
  },
  "Archivo Narrow": {
    "name": "Archivo Narrow"
  },
  "Are You Serious": {
    "name": "Are You Serious"
  },
  "Aref Ruqaa": {
    "name": "Aref Ruqaa"
  },
  "Aref Ruqaa Ink": {
    "name": "Aref Ruqaa Ink"
  },
  "Arima": {
    "name": "Arima"
  },
  "Arimo": {
    "name": "Arimo"
  },
  "Arizonia": {
    "name": "Arizonia"
  },
  "Armata": {
    "name": "Armata"
  },
  "Arsenal": {
    "name": "Arsenal"
  },
  "Artifika": {
    "name": "Artifika"
  },
  "Arvo": {
    "name": "Arvo"
  },
  "Arya": {
    "name": "Arya"
  },
  "Asap": {
    "name": "Asap"
  },
  "Asap Condensed": {
    "name": "Asap Condensed"
  },
  "Asar": {
    "name": "Asar"
  },
  "Asset": {
    "name": "Asset"
  },
  "Assistant": {
    "name": "Assistant"
  },
  "Astloch": {
    "name": "Astloch"
  },
  "Asul": {
    "name": "Asul"
  },
  "Athiti": {
    "name": "Athiti"
  },
  "Atkinson Hyperlegible": {
    "name": "Atkinson Hyperlegible"
  },
  "Atma": {
    "name": "Atma"
  },
  "Atomic Age": {
    "name": "Atomic Age"
  },
  "Aubrey": {
    "name": "Aubrey"
  },
  "Audiowide": {
    "name": "Audiowide"
  },
  "Autour One": {
    "name": "Autour One"
  },
  "Average": {
    "name": "Average"
  },
  "Average Sans": {
    "name": "Average Sans"
  },
  "Averia Gruesa Libre": {
    "name": "Averia Gruesa Libre"
  },
  "Averia Libre": {
    "name": "Averia Libre"
  },
  "Averia Sans Libre": {
    "name": "Averia Sans Libre"
  },
  "Averia Serif Libre": {
    "name": "Averia Serif Libre"
  },
  "Azeret Mono": {
    "name": "Azeret Mono"
  },
  "B612": {
    "name": "B612"
  },
  "B612 Mono": {
    "name": "B612 Mono"
  },
  "BIZ UDGothic": {
    "name": "BIZ UDGothic"
  },
  "BIZ UDMincho": {
    "name": "BIZ UDMincho"
  },
  "BIZ UDPGothic": {
    "name": "BIZ UDPGothic"
  },
  "BIZ UDPMincho": {
    "name": "BIZ UDPMincho"
  },
  "Babylonica": {
    "name": "Babylonica"
  },
  "Bacasime Antique": {
    "name": "Bacasime Antique"
  },
  "Bad Script": {
    "name": "Bad Script"
  },
  "Bagel Fat One": {
    "name": "Bagel Fat One"
  },
  "Bahiana": {
    "name": "Bahiana"
  },
  "Bahianita": {
    "name": "Bahianita"
  },
  "Bai Jamjuree": {
    "name": "Bai Jamjuree"
  },
  "Bakbak One": {
    "name": "Bakbak One"
  },
  "Ballet": {
    "name": "Ballet"
  },
  "Baloo 2": {
    "name": "Baloo 2"
  },
  "Baloo Bhai 2": {
    "name": "Baloo Bhai 2"
  },
  "Baloo Bhaijaan 2": {
    "name": "Baloo Bhaijaan 2"
  },
  "Baloo Bhaina 2": {
    "name": "Baloo Bhaina 2"
  },
  "Baloo Chettan 2": {
    "name": "Baloo Chettan 2"
  },
  "Baloo Da 2": {
    "name": "Baloo Da 2"
  },
  "Baloo Paaji 2": {
    "name": "Baloo Paaji 2"
  },
  "Baloo Tamma 2": {
    "name": "Baloo Tamma 2"
  },
  "Baloo Tammudu 2": {
    "name": "Baloo Tammudu 2"
  },
  "Baloo Thambi 2": {
    "name": "Baloo Thambi 2"
  },
  "Balsamiq Sans": {
    "name": "Balsamiq Sans"
  },
  "Balthazar": {
    "name": "Balthazar"
  },
  "Bangers": {
    "name": "Bangers"
  },
  "Barlow": {
    "name": "Barlow"
  },
  "Barlow Condensed": {
    "name": "Barlow Condensed"
  },
  "Barlow Semi Condensed": {
    "name": "Barlow Semi Condensed"
  },
  "Barriecito": {
    "name": "Barriecito"
  },
  "Barrio": {
    "name": "Barrio"
  },
  "Basic": {
    "name": "Basic"
  },
  "Baskervville": {
    "name": "Baskervville"
  },
  "Battambang": {
    "name": "Battambang"
  },
  "Baumans": {
    "name": "Baumans"
  },
  "Bayon": {
    "name": "Bayon"
  },
  "Be Vietnam Pro": {
    "name": "Be Vietnam Pro"
  },
  "Beau Rivage": {
    "name": "Beau Rivage"
  },
  "Bebas Neue": {
    "name": "Bebas Neue"
  },
  "Belanosima": {
    "name": "Belanosima"
  },
  "Belgrano": {
    "name": "Belgrano"
  },
  "Bellefair": {
    "name": "Bellefair"
  },
  "Belleza": {
    "name": "Belleza"
  },
  "Bellota": {
    "name": "Bellota"
  },
  "Bellota Text": {
    "name": "Bellota Text"
  },
  "BenchNine": {
    "name": "BenchNine"
  },
  "Benne": {
    "name": "Benne"
  },
  "Bentham": {
    "name": "Bentham"
  },
  "Berkshire Swash": {
    "name": "Berkshire Swash"
  },
  "Besley": {
    "name": "Besley"
  },
  "Beth Ellen": {
    "name": "Beth Ellen"
  },
  "Bevan": {
    "name": "Bevan"
  },
  "BhuTuka Expanded One": {
    "name": "BhuTuka Expanded One"
  },
  "Big Shoulders Display": {
    "name": "Big Shoulders Display"
  },
  "Big Shoulders Inline Display": {
    "name": "Big Shoulders Inline Display"
  },
  "Big Shoulders Inline Text": {
    "name": "Big Shoulders Inline Text"
  },
  "Big Shoulders Stencil Display": {
    "name": "Big Shoulders Stencil Display"
  },
  "Big Shoulders Stencil Text": {
    "name": "Big Shoulders Stencil Text"
  },
  "Big Shoulders Text": {
    "name": "Big Shoulders Text"
  },
  "Bigelow Rules": {
    "name": "Bigelow Rules"
  },
  "Bigshot One": {
    "name": "Bigshot One"
  },
  "Bilbo": {
    "name": "Bilbo"
  },
  "Bilbo Swash Caps": {
    "name": "Bilbo Swash Caps"
  },
  "BioRhyme": {
    "name": "BioRhyme"
  },
  "BioRhyme Expanded": {
    "name": "BioRhyme Expanded"
  },
  "Birthstone": {
    "name": "Birthstone"
  },
  "Birthstone Bounce": {
    "name": "Birthstone Bounce"
  },
  "Biryani": {
    "name": "Biryani"
  },
  "Bitter": {
    "name": "Bitter"
  },
  "Black And White Picture": {
    "name": "Black And White Picture"
  },
  "Black Han Sans": {
    "name": "Black Han Sans"
  },
  "Black Ops One": {
    "name": "Black Ops One"
  },
  "Blaka": {
    "name": "Blaka"
  },
  "Blaka Hollow": {
    "name": "Blaka Hollow"
  },
  "Blaka Ink": {
    "name": "Blaka Ink"
  },
  "Blinker": {
    "name": "Blinker"
  },
  "Bodoni Moda": {
    "name": "Bodoni Moda"
  },
  "Bokor": {
    "name": "Bokor"
  },
  "Bona Nova": {
    "name": "Bona Nova"
  },
  "Bonbon": {
    "name": "Bonbon"
  },
  "Bonheur Royale": {
    "name": "Bonheur Royale"
  },
  "Boogaloo": {
    "name": "Boogaloo"
  },
  "Borel": {
    "name": "Borel"
  },
  "Bowlby One": {
    "name": "Bowlby One"
  },
  "Bowlby One SC": {
    "name": "Bowlby One SC"
  },
  "Braah One": {
    "name": "Braah One"
  },
  "Brawler": {
    "name": "Brawler"
  },
  "Bree Serif": {
    "name": "Bree Serif"
  },
  "Bricolage Grotesque": {
    "name": "Bricolage Grotesque"
  },
  "Bruno Ace": {
    "name": "Bruno Ace"
  },
  "Bruno Ace SC": {
    "name": "Bruno Ace SC"
  },
  "Brygada 1918": {
    "name": "Brygada 1918"
  },
  "Bubblegum Sans": {
    "name": "Bubblegum Sans"
  },
  "Bubbler One": {
    "name": "Bubbler One"
  },
  "Buda": {
    "name": "Buda"
  },
  "Buenard": {
    "name": "Buenard"
  },
  "Bungee": {
    "name": "Bungee"
  },
  "Bungee Hairline": {
    "name": "Bungee Hairline"
  },
  "Bungee Inline": {
    "name": "Bungee Inline"
  },
  "Bungee Outline": {
    "name": "Bungee Outline"
  },
  "Bungee Shade": {
    "name": "Bungee Shade"
  },
  "Bungee Spice": {
    "name": "Bungee Spice"
  },
  "Butcherman": {
    "name": "Butcherman"
  },
  "Butterfly Kids": {
    "name": "Butterfly Kids"
  },
  "Cabin": {
    "name": "Cabin"
  },
  "Cabin Condensed": {
    "name": "Cabin Condensed"
  },
  "Cabin Sketch": {
    "name": "Cabin Sketch"
  },
  "Caesar Dressing": {
    "name": "Caesar Dressing"
  },
  "Cagliostro": {
    "name": "Cagliostro"
  },
  "Cairo": {
    "name": "Cairo"
  },
  "Cairo Play": {
    "name": "Cairo Play"
  },
  "Caladea": {
    "name": "Caladea"
  },
  "Calistoga": {
    "name": "Calistoga"
  },
  "Calligraffitti": {
    "name": "Calligraffitti"
  },
  "Cambay": {
    "name": "Cambay"
  },
  "Cambo": {
    "name": "Cambo"
  },
  "Candal": {
    "name": "Candal"
  },
  "Cantarell": {
    "name": "Cantarell"
  },
  "Cantata One": {
    "name": "Cantata One"
  },
  "Cantora One": {
    "name": "Cantora One"
  },
  "Caprasimo": {
    "name": "Caprasimo"
  },
  "Capriola": {
    "name": "Capriola"
  },
  "Caramel": {
    "name": "Caramel"
  },
  "Carattere": {
    "name": "Carattere"
  },
  "Cardo": {
    "name": "Cardo"
  },
  "Carlito": {
    "name": "Carlito"
  },
  "Carme": {
    "name": "Carme"
  },
  "Carrois Gothic": {
    "name": "Carrois Gothic"
  },
  "Carrois Gothic SC": {
    "name": "Carrois Gothic SC"
  },
  "Carter One": {
    "name": "Carter One"
  },
  "Castoro": {
    "name": "Castoro"
  },
  "Castoro Titling": {
    "name": "Castoro Titling"
  },
  "Catamaran": {
    "name": "Catamaran"
  },
  "Caudex": {
    "name": "Caudex"
  },
  "Caveat": {
    "name": "Caveat"
  },
  "Caveat Brush": {
    "name": "Caveat Brush"
  },
  "Cedarville Cursive": {
    "name": "Cedarville Cursive"
  },
  "Ceviche One": {
    "name": "Ceviche One"
  },
  "Chakra Petch": {
    "name": "Chakra Petch"
  },
  "Changa": {
    "name": "Changa"
  },
  "Changa One": {
    "name": "Changa One"
  },
  "Chango": {
    "name": "Chango"
  },
  "Charis SIL": {
    "name": "Charis SIL"
  },
  "Charm": {
    "name": "Charm"
  },
  "Charmonman": {
    "name": "Charmonman"
  },
  "Chathura": {
    "name": "Chathura"
  },
  "Chau Philomene One": {
    "name": "Chau Philomene One"
  },
  "Chela One": {
    "name": "Chela One"
  },
  "Chelsea Market": {
    "name": "Chelsea Market"
  },
  "Chenla": {
    "name": "Chenla"
  },
  "Cherish": {
    "name": "Cherish"
  },
  "Cherry Bomb One": {
    "name": "Cherry Bomb One"
  },
  "Cherry Cream Soda": {
    "name": "Cherry Cream Soda"
  },
  "Cherry Swash": {
    "name": "Cherry Swash"
  },
  "Chewy": {
    "name": "Chewy"
  },
  "Chicle": {
    "name": "Chicle"
  },
  "Chilanka": {
    "name": "Chilanka"
  },
  "Chivo": {
    "name": "Chivo"
  },
  "Chivo Mono": {
    "name": "Chivo Mono"
  },
  "Chokokutai": {
    "name": "Chokokutai"
  },
  "Chonburi": {
    "name": "Chonburi"
  },
  "Cinzel": {
    "name": "Cinzel"
  },
  "Cinzel Decorative": {
    "name": "Cinzel Decorative"
  },
  "Clicker Script": {
    "name": "Clicker Script"
  },
  "Climate Crisis": {
    "name": "Climate Crisis"
  },
  "Coda": {
    "name": "Coda"
  },
  "Codystar": {
    "name": "Codystar"
  },
  "Coiny": {
    "name": "Coiny"
  },
  "Combo": {
    "name": "Combo"
  },
  "Comfortaa": {
    "name": "Comfortaa"
  },
  "Comforter": {
    "name": "Comforter"
  },
  "Comforter Brush": {
    "name": "Comforter Brush"
  },
  "Comic Neue": {
    "name": "Comic Neue"
  },
  "Coming Soon": {
    "name": "Coming Soon"
  },
  "Comme": {
    "name": "Comme"
  },
  "Commissioner": {
    "name": "Commissioner"
  },
  "Concert One": {
    "name": "Concert One"
  },
  "Condiment": {
    "name": "Condiment"
  },
  "Content": {
    "name": "Content"
  },
  "Contrail One": {
    "name": "Contrail One"
  },
  "Convergence": {
    "name": "Convergence"
  },
  "Cookie": {
    "name": "Cookie"
  },
  "Copse": {
    "name": "Copse"
  },
  "Corben": {
    "name": "Corben"
  },
  "Corinthia": {
    "name": "Corinthia"
  },
  "Cormorant": {
    "name": "Cormorant"
  },
  "Cormorant Garamond": {
    "name": "Cormorant Garamond"
  },
  "Cormorant Infant": {
    "name": "Cormorant Infant"
  },
  "Cormorant SC": {
    "name": "Cormorant SC"
  },
  "Cormorant Unicase": {
    "name": "Cormorant Unicase"
  },
  "Cormorant Upright": {
    "name": "Cormorant Upright"
  },
  "Courgette": {
    "name": "Courgette"
  },
  "Courier Prime": {
    "name": "Courier Prime"
  },
  "Cousine": {
    "name": "Cousine"
  },
  "Coustard": {
    "name": "Coustard"
  },
  "Covered By Your Grace": {
    "name": "Covered By Your Grace"
  },
  "Crafty Girls": {
    "name": "Crafty Girls"
  },
  "Creepster": {
    "name": "Creepster"
  },
  "Crete Round": {
    "name": "Crete Round"
  },
  "Crimson Pro": {
    "name": "Crimson Pro"
  },
  "Crimson Text": {
    "name": "Crimson Text"
  },
  "Croissant One": {
    "name": "Croissant One"
  },
  "Crushed": {
    "name": "Crushed"
  },
  "Cuprum": {
    "name": "Cuprum"
  },
  "Cute Font": {
    "name": "Cute Font"
  },
  "Cutive": {
    "name": "Cutive"
  },
  "Cutive Mono": {
    "name": "Cutive Mono"
  },
  "DM Mono": {
    "name": "DM Mono"
  },
  "DM Sans": {
    "name": "DM Sans"
  },
  "DM Serif Display": {
    "name": "DM Serif Display"
  },
  "DM Serif Text": {
    "name": "DM Serif Text"
  },
  "Dai Banna SIL": {
    "name": "Dai Banna SIL"
  },
  "Damion": {
    "name": "Damion"
  },
  "Dancing Script": {
    "name": "Dancing Script"
  },
  "Dangrek": {
    "name": "Dangrek"
  },
  "Darker Grotesque": {
    "name": "Darker Grotesque"
  },
  "Darumadrop One": {
    "name": "Darumadrop One"
  },
  "David Libre": {
    "name": "David Libre"
  },
  "Dawning of a New Day": {
    "name": "Dawning of a New Day"
  },
  "Days One": {
    "name": "Days One"
  },
  "Dekko": {
    "name": "Dekko"
  },
  "Dela Gothic One": {
    "name": "Dela Gothic One"
  },
  "Delicious Handrawn": {
    "name": "Delicious Handrawn"
  },
  "Delius": {
    "name": "Delius"
  },
  "Delius Swash Caps": {
    "name": "Delius Swash Caps"
  },
  "Delius Unicase": {
    "name": "Delius Unicase"
  },
  "Della Respira": {
    "name": "Della Respira"
  },
  "Denk One": {
    "name": "Denk One"
  },
  "Devonshire": {
    "name": "Devonshire"
  },
  "Dhurjati": {
    "name": "Dhurjati"
  },
  "Didact Gothic": {
    "name": "Didact Gothic"
  },
  "Diphylleia": {
    "name": "Diphylleia"
  },
  "Diplomata": {
    "name": "Diplomata"
  },
  "Diplomata SC": {
    "name": "Diplomata SC"
  },
  "Do Hyeon": {
    "name": "Do Hyeon"
  },
  "Dokdo": {
    "name": "Dokdo"
  },
  "Domine": {
    "name": "Domine"
  },
  "Donegal One": {
    "name": "Donegal One"
  },
  "Dongle": {
    "name": "Dongle"
  },
  "Doppio One": {
    "name": "Doppio One"
  },
  "Dorsa": {
    "name": "Dorsa"
  },
  "Dosis": {
    "name": "Dosis"
  },
  "DotGothic16": {
    "name": "DotGothic16"
  },
  "Dr Sugiyama": {
    "name": "Dr Sugiyama"
  },
  "Duru Sans": {
    "name": "Duru Sans"
  },
  "DynaPuff": {
    "name": "DynaPuff"
  },
  "Dynalight": {
    "name": "Dynalight"
  },
  "EB Garamond": {
    "name": "EB Garamond"
  },
  "Eagle Lake": {
    "name": "Eagle Lake"
  },
  "East Sea Dokdo": {
    "name": "East Sea Dokdo"
  },
  "Eater": {
    "name": "Eater"
  },
  "Economica": {
    "name": "Economica"
  },
  "Eczar": {
    "name": "Eczar"
  },
  "Edu NSW ACT Foundation": {
    "name": "Edu NSW ACT Foundation"
  },
  "Edu QLD Beginner": {
    "name": "Edu QLD Beginner"
  },
  "Edu SA Beginner": {
    "name": "Edu SA Beginner"
  },
  "Edu TAS Beginner": {
    "name": "Edu TAS Beginner"
  },
  "Edu VIC WA NT Beginner": {
    "name": "Edu VIC WA NT Beginner"
  },
  "El Messiri": {
    "name": "El Messiri"
  },
  "Electrolize": {
    "name": "Electrolize"
  },
  "Elsie": {
    "name": "Elsie"
  },
  "Elsie Swash Caps": {
    "name": "Elsie Swash Caps"
  },
  "Emblema One": {
    "name": "Emblema One"
  },
  "Emilys Candy": {
    "name": "Emilys Candy"
  },
  "Encode Sans": {
    "name": "Encode Sans"
  },
  "Encode Sans Condensed": {
    "name": "Encode Sans Condensed"
  },
  "Encode Sans Expanded": {
    "name": "Encode Sans Expanded"
  },
  "Encode Sans SC": {
    "name": "Encode Sans SC"
  },
  "Encode Sans Semi Condensed": {
    "name": "Encode Sans Semi Condensed"
  },
  "Encode Sans Semi Expanded": {
    "name": "Encode Sans Semi Expanded"
  },
  "Engagement": {
    "name": "Engagement"
  },
  "Englebert": {
    "name": "Englebert"
  },
  "Enriqueta": {
    "name": "Enriqueta"
  },
  "Ephesis": {
    "name": "Ephesis"
  },
  "Epilogue": {
    "name": "Epilogue"
  },
  "Erica One": {
    "name": "Erica One"
  },
  "Esteban": {
    "name": "Esteban"
  },
  "Estonia": {
    "name": "Estonia"
  },
  "Euphoria Script": {
    "name": "Euphoria Script"
  },
  "Ewert": {
    "name": "Ewert"
  },
  "Exo": {
    "name": "Exo"
  },
  "Exo 2": {
    "name": "Exo 2"
  },
  "Expletus Sans": {
    "name": "Expletus Sans"
  },
  "Explora": {
    "name": "Explora"
  },
  "Fahkwang": {
    "name": "Fahkwang"
  },
  "Familjen Grotesk": {
    "name": "Familjen Grotesk"
  },
  "Fanwood Text": {
    "name": "Fanwood Text"
  },
  "Farro": {
    "name": "Farro"
  },
  "Farsan": {
    "name": "Farsan"
  },
  "Fascinate": {
    "name": "Fascinate"
  },
  "Fascinate Inline": {
    "name": "Fascinate Inline"
  },
  "Faster One": {
    "name": "Faster One"
  },
  "Fasthand": {
    "name": "Fasthand"
  },
  "Fauna One": {
    "name": "Fauna One"
  },
  "Faustina": {
    "name": "Faustina"
  },
  "Federant": {
    "name": "Federant"
  },
  "Federo": {
    "name": "Federo"
  },
  "Felipa": {
    "name": "Felipa"
  },
  "Fenix": {
    "name": "Fenix"
  },
  "Festive": {
    "name": "Festive"
  },
  "Figtree": {
    "name": "Figtree"
  },
  "Finger Paint": {
    "name": "Finger Paint"
  },
  "Finlandica": {
    "name": "Finlandica"
  },
  "Fira Code": {
    "name": "Fira Code"
  },
  "Fira Mono": {
    "name": "Fira Mono"
  },
  "Fira Sans": {
    "name": "Fira Sans"
  },
  "Fira Sans Condensed": {
    "name": "Fira Sans Condensed"
  },
  "Fira Sans Extra Condensed": {
    "name": "Fira Sans Extra Condensed"
  },
  "Fjalla One": {
    "name": "Fjalla One"
  },
  "Fjord One": {
    "name": "Fjord One"
  },
  "Flamenco": {
    "name": "Flamenco"
  },
  "Flavors": {
    "name": "Flavors"
  },
  "Fleur De Leah": {
    "name": "Fleur De Leah"
  },
  "Flow Block": {
    "name": "Flow Block"
  },
  "Flow Circular": {
    "name": "Flow Circular"
  },
  "Flow Rounded": {
    "name": "Flow Rounded"
  },
  "Foldit": {
    "name": "Foldit"
  },
  "Fondamento": {
    "name": "Fondamento"
  },
  "Fontdiner Swanky": {
    "name": "Fontdiner Swanky"
  },
  "Forum": {
    "name": "Forum"
  },
  "Fragment Mono": {
    "name": "Fragment Mono"
  },
  "Francois One": {
    "name": "Francois One"
  },
  "Frank Ruhl Libre": {
    "name": "Frank Ruhl Libre"
  },
  "Fraunces": {
    "name": "Fraunces"
  },
  "Freckle Face": {
    "name": "Freckle Face"
  },
  "Fredericka the Great": {
    "name": "Fredericka the Great"
  },
  "Fredoka": {
    "name": "Fredoka"
  },
  "Freehand": {
    "name": "Freehand"
  },
  "Fresca": {
    "name": "Fresca"
  },
  "Frijole": {
    "name": "Frijole"
  },
  "Fruktur": {
    "name": "Fruktur"
  },
  "Fugaz One": {
    "name": "Fugaz One"
  },
  "Fuggles": {
    "name": "Fuggles"
  },
  "Fuzzy Bubbles": {
    "name": "Fuzzy Bubbles"
  },
  "GFS Didot": {
    "name": "GFS Didot"
  },
  "GFS Neohellenic": {
    "name": "GFS Neohellenic"
  },
  "Gabriela": {
    "name": "Gabriela"
  },
  "Gaegu": {
    "name": "Gaegu"
  },
  "Gafata": {
    "name": "Gafata"
  },
  "Gajraj One": {
    "name": "Gajraj One"
  },
  "Galada": {
    "name": "Galada"
  },
  "Galdeano": {
    "name": "Galdeano"
  },
  "Galindo": {
    "name": "Galindo"
  },
  "Gamja Flower": {
    "name": "Gamja Flower"
  },
  "Gantari": {
    "name": "Gantari"
  },
  "Gasoek One": {
    "name": "Gasoek One"
  },
  "Gayathri": {
    "name": "Gayathri"
  },
  "Gelasio": {
    "name": "Gelasio"
  },
  "Gemunu Libre": {
    "name": "Gemunu Libre"
  },
  "Genos": {
    "name": "Genos"
  },
  "Gentium Book Plus": {
    "name": "Gentium Book Plus"
  },
  "Gentium Plus": {
    "name": "Gentium Plus"
  },
  "Geo": {
    "name": "Geo"
  },
  "Geologica": {
    "name": "Geologica"
  },
  "Georama": {
    "name": "Georama"
  },
  "Geostar": {
    "name": "Geostar"
  },
  "Geostar Fill": {
    "name": "Geostar Fill"
  },
  "Germania One": {
    "name": "Germania One"
  },
  "Gideon Roman": {
    "name": "Gideon Roman"
  },
  "Gidugu": {
    "name": "Gidugu"
  },
  "Gilda Display": {
    "name": "Gilda Display"
  },
  "Girassol": {
    "name": "Girassol"
  },
  "Give You Glory": {
    "name": "Give You Glory"
  },
  "Glass Antiqua": {
    "name": "Glass Antiqua"
  },
  "Glegoo": {
    "name": "Glegoo"
  },
  "Gloock": {
    "name": "Gloock"
  },
  "Gloria Hallelujah": {
    "name": "Gloria Hallelujah"
  },
  "Glory": {
    "name": "Glory"
  },
  "Gluten": {
    "name": "Gluten"
  },
  "Goblin One": {
    "name": "Goblin One"
  },
  "Gochi Hand": {
    "name": "Gochi Hand"
  },
  "Goldman": {
    "name": "Goldman"
  },
  "Golos Text": {
    "name": "Golos Text"
  },
  "Gorditas": {
    "name": "Gorditas"
  },
  "Gothic A1": {
    "name": "Gothic A1"
  },
  "Gotu": {
    "name": "Gotu"
  },
  "Goudy Bookletter 1911": {
    "name": "Goudy Bookletter 1911"
  },
  "Gowun Batang": {
    "name": "Gowun Batang"
  },
  "Gowun Dodum": {
    "name": "Gowun Dodum"
  },
  "Graduate": {
    "name": "Graduate"
  },
  "Grand Hotel": {
    "name": "Grand Hotel"
  },
  "Grandiflora One": {
    "name": "Grandiflora One"
  },
  "Grandstander": {
    "name": "Grandstander"
  },
  "Grape Nuts": {
    "name": "Grape Nuts"
  },
  "Gravitas One": {
    "name": "Gravitas One"
  },
  "Great Vibes": {
    "name": "Great Vibes"
  },
  "Grechen Fuemen": {
    "name": "Grechen Fuemen"
  },
  "Grenze": {
    "name": "Grenze"
  },
  "Grenze Gotisch": {
    "name": "Grenze Gotisch"
  },
  "Grey Qo": {
    "name": "Grey Qo"
  },
  "Griffy": {
    "name": "Griffy"
  },
  "Gruppo": {
    "name": "Gruppo"
  },
  "Gudea": {
    "name": "Gudea"
  },
  "Gugi": {
    "name": "Gugi"
  },
  "Gulzar": {
    "name": "Gulzar"
  },
  "Gupter": {
    "name": "Gupter"
  },
  "Gurajada": {
    "name": "Gurajada"
  },
  "Gwendolyn": {
    "name": "Gwendolyn"
  },
  "Habibi": {
    "name": "Habibi"
  },
  "Hachi Maru Pop": {
    "name": "Hachi Maru Pop"
  },
  "Hahmlet": {
    "name": "Hahmlet"
  },
  "Halant": {
    "name": "Halant"
  },
  "Hammersmith One": {
    "name": "Hammersmith One"
  },
  "Hanalei": {
    "name": "Hanalei"
  },
  "Hanalei Fill": {
    "name": "Hanalei Fill"
  },
  "Handjet": {
    "name": "Handjet"
  },
  "Handlee": {
    "name": "Handlee"
  },
  "Hanken Grotesk": {
    "name": "Hanken Grotesk"
  },
  "Hanuman": {
    "name": "Hanuman"
  },
  "Happy Monkey": {
    "name": "Happy Monkey"
  },
  "Harmattan": {
    "name": "Harmattan"
  },
  "Headland One": {
    "name": "Headland One"
  },
  "Heebo": {
    "name": "Heebo"
  },
  "Henny Penny": {
    "name": "Henny Penny"
  },
  "Hepta Slab": {
    "name": "Hepta Slab"
  },
  "Herr Von Muellerhoff": {
    "name": "Herr Von Muellerhoff"
  },
  "Hi Melody": {
    "name": "Hi Melody"
  },
  "Hina Mincho": {
    "name": "Hina Mincho"
  },
  "Hind": {
    "name": "Hind"
  },
  "Hind Guntur": {
    "name": "Hind Guntur"
  },
  "Hind Madurai": {
    "name": "Hind Madurai"
  },
  "Hind Siliguri": {
    "name": "Hind Siliguri"
  },
  "Hind Vadodara": {
    "name": "Hind Vadodara"
  },
  "Holtwood One SC": {
    "name": "Holtwood One SC"
  },
  "Homemade Apple": {
    "name": "Homemade Apple"
  },
  "Homenaje": {
    "name": "Homenaje"
  },
  "Hubballi": {
    "name": "Hubballi"
  },
  "Hurricane": {
    "name": "Hurricane"
  },
  "IBM Plex Mono": {
    "name": "IBM Plex Mono"
  },
  "IBM Plex Sans": {
    "name": "IBM Plex Sans"
  },
  "IBM Plex Sans Arabic": {
    "name": "IBM Plex Sans Arabic"
  },
  "IBM Plex Sans Condensed": {
    "name": "IBM Plex Sans Condensed"
  },
  "IBM Plex Sans Devanagari": {
    "name": "IBM Plex Sans Devanagari"
  },
  "IBM Plex Sans Hebrew": {
    "name": "IBM Plex Sans Hebrew"
  },
  "IBM Plex Sans JP": {
    "name": "IBM Plex Sans JP"
  },
  "IBM Plex Sans KR": {
    "name": "IBM Plex Sans KR"
  },
  "IBM Plex Sans Thai": {
    "name": "IBM Plex Sans Thai"
  },
  "IBM Plex Sans Thai Looped": {
    "name": "IBM Plex Sans Thai Looped"
  },
  "IBM Plex Serif": {
    "name": "IBM Plex Serif"
  },
  "IM Fell DW Pica": {
    "name": "IM Fell DW Pica"
  },
  "IM Fell DW Pica SC": {
    "name": "IM Fell DW Pica SC"
  },
  "IM Fell Double Pica": {
    "name": "IM Fell Double Pica"
  },
  "IM Fell Double Pica SC": {
    "name": "IM Fell Double Pica SC"
  },
  "IM Fell English": {
    "name": "IM Fell English"
  },
  "IM Fell English SC": {
    "name": "IM Fell English SC"
  },
  "IM Fell French Canon": {
    "name": "IM Fell French Canon"
  },
  "IM Fell French Canon SC": {
    "name": "IM Fell French Canon SC"
  },
  "IM Fell Great Primer": {
    "name": "IM Fell Great Primer"
  },
  "IM Fell Great Primer SC": {
    "name": "IM Fell Great Primer SC"
  },
  "Ibarra Real Nova": {
    "name": "Ibarra Real Nova"
  },
  "Iceberg": {
    "name": "Iceberg"
  },
  "Iceland": {
    "name": "Iceland"
  },
  "Imbue": {
    "name": "Imbue"
  },
  "Imperial Script": {
    "name": "Imperial Script"
  },
  "Imprima": {
    "name": "Imprima"
  },
  "Inconsolata": {
    "name": "Inconsolata"
  },
  "Inder": {
    "name": "Inder"
  },
  "Indie Flower": {
    "name": "Indie Flower"
  },
  "Ingrid Darling": {
    "name": "Ingrid Darling"
  },
  "Inika": {
    "name": "Inika"
  },
  "Inknut Antiqua": {
    "name": "Inknut Antiqua"
  },
  "Inria Sans": {
    "name": "Inria Sans"
  },
  "Inria Serif": {
    "name": "Inria Serif"
  },
  "Inspiration": {
    "name": "Inspiration"
  },
  "Instrument Sans": {
    "name": "Instrument Sans"
  },
  "Instrument Serif": {
    "name": "Instrument Serif"
  },
  "Inter": {
    "name": "Inter"
  },
  "Inter Tight": {
    "name": "Inter Tight"
  },
  "Irish Grover": {
    "name": "Irish Grover"
  },
  "Island Moments": {
    "name": "Island Moments"
  },
  "Istok Web": {
    "name": "Istok Web"
  },
  "Italiana": {
    "name": "Italiana"
  },
  "Italianno": {
    "name": "Italianno"
  },
  "Itim": {
    "name": "Itim"
  },
  "Jacques Francois": {
    "name": "Jacques Francois"
  },
  "Jacques Francois Shadow": {
    "name": "Jacques Francois Shadow"
  },
  "Jaldi": {
    "name": "Jaldi"
  },
  "JetBrains Mono": {
    "name": "JetBrains Mono"
  },
  "Jim Nightshade": {
    "name": "Jim Nightshade"
  },
  "Joan": {
    "name": "Joan"
  },
  "Jockey One": {
    "name": "Jockey One"
  },
  "Jolly Lodger": {
    "name": "Jolly Lodger"
  },
  "Jomhuria": {
    "name": "Jomhuria"
  },
  "Jomolhari": {
    "name": "Jomolhari"
  },
  "Josefin Sans": {
    "name": "Josefin Sans"
  },
  "Josefin Slab": {
    "name": "Josefin Slab"
  },
  "Jost": {
    "name": "Jost"
  },
  "Joti One": {
    "name": "Joti One"
  },
  "Jua": {
    "name": "Jua"
  },
  "Judson": {
    "name": "Judson"
  },
  "Julee": {
    "name": "Julee"
  },
  "Julius Sans One": {
    "name": "Julius Sans One"
  },
  "Junge": {
    "name": "Junge"
  },
  "Jura": {
    "name": "Jura"
  },
  "Just Another Hand": {
    "name": "Just Another Hand"
  },
  "Just Me Again Down Here": {
    "name": "Just Me Again Down Here"
  },
  "K2D": {
    "name": "K2D"
  },
  "Kablammo": {
    "name": "Kablammo"
  },
  "Kadwa": {
    "name": "Kadwa"
  },
  "Kaisei Decol": {
    "name": "Kaisei Decol"
  },
  "Kaisei HarunoUmi": {
    "name": "Kaisei HarunoUmi"
  },
  "Kaisei Opti": {
    "name": "Kaisei Opti"
  },
  "Kaisei Tokumin": {
    "name": "Kaisei Tokumin"
  },
  "Kalam": {
    "name": "Kalam"
  },
  "Kameron": {
    "name": "Kameron"
  },
  "Kanit": {
    "name": "Kanit"
  },
  "Kantumruy Pro": {
    "name": "Kantumruy Pro"
  },
  "Karantina": {
    "name": "Karantina"
  },
  "Karla": {
    "name": "Karla"
  },
  "Karma": {
    "name": "Karma"
  },
  "Katibeh": {
    "name": "Katibeh"
  },
  "Kaushan Script": {
    "name": "Kaushan Script"
  },
  "Kavivanar": {
    "name": "Kavivanar"
  },
  "Kavoon": {
    "name": "Kavoon"
  },
  "Kdam Thmor Pro": {
    "name": "Kdam Thmor Pro"
  },
  "Keania One": {
    "name": "Keania One"
  },
  "Kelly Slab": {
    "name": "Kelly Slab"
  },
  "Kenia": {
    "name": "Kenia"
  },
  "Khand": {
    "name": "Khand"
  },
  "Khmer": {
    "name": "Khmer"
  },
  "Khula": {
    "name": "Khula"
  },
  "Kings": {
    "name": "Kings"
  },
  "Kirang Haerang": {
    "name": "Kirang Haerang"
  },
  "Kite One": {
    "name": "Kite One"
  },
  "Kiwi Maru": {
    "name": "Kiwi Maru"
  },
  "Klee One": {
    "name": "Klee One"
  },
  "Knewave": {
    "name": "Knewave"
  },
  "KoHo": {
    "name": "KoHo"
  },
  "Kodchasan": {
    "name": "Kodchasan"
  },
  "Koh Santepheap": {
    "name": "Koh Santepheap"
  },
  "Kolker Brush": {
    "name": "Kolker Brush"
  },
  "Konkhmer Sleokchher": {
    "name": "Konkhmer Sleokchher"
  },
  "Kosugi": {
    "name": "Kosugi"
  },
  "Kosugi Maru": {
    "name": "Kosugi Maru"
  },
  "Kotta One": {
    "name": "Kotta One"
  },
  "Koulen": {
    "name": "Koulen"
  },
  "Kranky": {
    "name": "Kranky"
  },
  "Kreon": {
    "name": "Kreon"
  },
  "Kristi": {
    "name": "Kristi"
  },
  "Krona One": {
    "name": "Krona One"
  },
  "Krub": {
    "name": "Krub"
  },
  "Kufam": {
    "name": "Kufam"
  },
  "Kulim Park": {
    "name": "Kulim Park"
  },
  "Kumar One": {
    "name": "Kumar One"
  },
  "Kumar One Outline": {
    "name": "Kumar One Outline"
  },
  "Kumbh Sans": {
    "name": "Kumbh Sans"
  },
  "Kurale": {
    "name": "Kurale"
  },
  "La Belle Aurore": {
    "name": "La Belle Aurore"
  },
  "Labrada": {
    "name": "Labrada"
  },
  "Lacquer": {
    "name": "Lacquer"
  },
  "Laila": {
    "name": "Laila"
  },
  "Lakki Reddy": {
    "name": "Lakki Reddy"
  },
  "Lalezar": {
    "name": "Lalezar"
  },
  "Lancelot": {
    "name": "Lancelot"
  },
  "Langar": {
    "name": "Langar"
  },
  "Lateef": {
    "name": "Lateef"
  },
  "Lato": {
    "name": "Lato"
  },
  "Lavishly Yours": {
    "name": "Lavishly Yours"
  },
  "League Gothic": {
    "name": "League Gothic"
  },
  "League Script": {
    "name": "League Script"
  },
  "League Spartan": {
    "name": "League Spartan"
  },
  "Leckerli One": {
    "name": "Leckerli One"
  },
  "Ledger": {
    "name": "Ledger"
  },
  "Lekton": {
    "name": "Lekton"
  },
  "Lemon": {
    "name": "Lemon"
  },
  "Lemonada": {
    "name": "Lemonada"
  },
  "Lexend": {
    "name": "Lexend"
  },
  "Lexend Deca": {
    "name": "Lexend Deca"
  },
  "Lexend Exa": {
    "name": "Lexend Exa"
  },
  "Lexend Giga": {
    "name": "Lexend Giga"
  },
  "Lexend Mega": {
    "name": "Lexend Mega"
  },
  "Lexend Peta": {
    "name": "Lexend Peta"
  },
  "Lexend Tera": {
    "name": "Lexend Tera"
  },
  "Lexend Zetta": {
    "name": "Lexend Zetta"
  },
  "Libre Barcode 128": {
    "name": "Libre Barcode 128"
  },
  "Libre Barcode 128 Text": {
    "name": "Libre Barcode 128 Text"
  },
  "Libre Barcode 39": {
    "name": "Libre Barcode 39"
  },
  "Libre Barcode 39 Extended": {
    "name": "Libre Barcode 39 Extended"
  },
  "Libre Barcode 39 Extended Text": {
    "name": "Libre Barcode 39 Extended Text"
  },
  "Libre Barcode 39 Text": {
    "name": "Libre Barcode 39 Text"
  },
  "Libre Barcode EAN13 Text": {
    "name": "Libre Barcode EAN13 Text"
  },
  "Libre Baskerville": {
    "name": "Libre Baskerville"
  },
  "Libre Bodoni": {
    "name": "Libre Bodoni"
  },
  "Libre Caslon Display": {
    "name": "Libre Caslon Display"
  },
  "Libre Caslon Text": {
    "name": "Libre Caslon Text"
  },
  "Libre Franklin": {
    "name": "Libre Franklin"
  },
  "Licorice": {
    "name": "Licorice"
  },
  "Life Savers": {
    "name": "Life Savers"
  },
  "Lilita One": {
    "name": "Lilita One"
  },
  "Lily Script One": {
    "name": "Lily Script One"
  },
  "Limelight": {
    "name": "Limelight"
  },
  "Linden Hill": {
    "name": "Linden Hill"
  },
  "Lisu Bosa": {
    "name": "Lisu Bosa"
  },
  "Literata": {
    "name": "Literata"
  },
  "Liu Jian Mao Cao": {
    "name": "Liu Jian Mao Cao"
  },
  "Livvic": {
    "name": "Livvic"
  },
  "Lobster": {
    "name": "Lobster"
  },
  "Lobster Two": {
    "name": "Lobster Two"
  },
  "Londrina Outline": {
    "name": "Londrina Outline"
  },
  "Londrina Shadow": {
    "name": "Londrina Shadow"
  },
  "Londrina Sketch": {
    "name": "Londrina Sketch"
  },
  "Londrina Solid": {
    "name": "Londrina Solid"
  },
  "Long Cang": {
    "name": "Long Cang"
  },
  "Lora": {
    "name": "Lora"
  },
  "Love Light": {
    "name": "Love Light"
  },
  "Love Ya Like A Sister": {
    "name": "Love Ya Like A Sister"
  },
  "Loved by the King": {
    "name": "Loved by the King"
  },
  "Lovers Quarrel": {
    "name": "Lovers Quarrel"
  },
  "Luckiest Guy": {
    "name": "Luckiest Guy"
  },
  "Lugrasimo": {
    "name": "Lugrasimo"
  },
  "Lumanosimo": {
    "name": "Lumanosimo"
  },
  "Lunasima": {
    "name": "Lunasima"
  },
  "Lusitana": {
    "name": "Lusitana"
  },
  "Lustria": {
    "name": "Lustria"
  },
  "Luxurious Roman": {
    "name": "Luxurious Roman"
  },
  "Luxurious Script": {
    "name": "Luxurious Script"
  },
  "M PLUS 1": {
    "name": "M PLUS 1"
  },
  "M PLUS 1 Code": {
    "name": "M PLUS 1 Code"
  },
  "M PLUS 1p": {
    "name": "M PLUS 1p"
  },
  "M PLUS 2": {
    "name": "M PLUS 2"
  },
  "M PLUS Code Latin": {
    "name": "M PLUS Code Latin"
  },
  "M PLUS Rounded 1c": {
    "name": "M PLUS Rounded 1c"
  },
  "Ma Shan Zheng": {
    "name": "Ma Shan Zheng"
  },
  "Macondo": {
    "name": "Macondo"
  },
  "Macondo Swash Caps": {
    "name": "Macondo Swash Caps"
  },
  "Mada": {
    "name": "Mada"
  },
  "Magra": {
    "name": "Magra"
  },
  "Maiden Orange": {
    "name": "Maiden Orange"
  },
  "Maitree": {
    "name": "Maitree"
  },
  "Major Mono Display": {
    "name": "Major Mono Display"
  },
  "Mako": {
    "name": "Mako"
  },
  "Mali": {
    "name": "Mali"
  },
  "Mallanna": {
    "name": "Mallanna"
  },
  "Mandali": {
    "name": "Mandali"
  },
  "Manjari": {
    "name": "Manjari"
  },
  "Manrope": {
    "name": "Manrope"
  },
  "Mansalva": {
    "name": "Mansalva"
  },
  "Manuale": {
    "name": "Manuale"
  },
  "Marcellus": {
    "name": "Marcellus"
  },
  "Marcellus SC": {
    "name": "Marcellus SC"
  },
  "Marck Script": {
    "name": "Marck Script"
  },
  "Margarine": {
    "name": "Margarine"
  },
  "Marhey": {
    "name": "Marhey"
  },
  "Markazi Text": {
    "name": "Markazi Text"
  },
  "Marko One": {
    "name": "Marko One"
  },
  "Marmelad": {
    "name": "Marmelad"
  },
  "Martel": {
    "name": "Martel"
  },
  "Martel Sans": {
    "name": "Martel Sans"
  },
  "Martian Mono": {
    "name": "Martian Mono"
  },
  "Marvel": {
    "name": "Marvel"
  },
  "Mate": {
    "name": "Mate"
  },
  "Mate SC": {
    "name": "Mate SC"
  },
  "Material Icons": {
    "name": "Material Icons"
  },
  "Material Icons Outlined": {
    "name": "Material Icons Outlined"
  },
  "Material Icons Round": {
    "name": "Material Icons Round"
  },
  "Material Icons Sharp": {
    "name": "Material Icons Sharp"
  },
  "Material Icons Two Tone": {
    "name": "Material Icons Two Tone"
  },
  "Material Symbols Outlined": {
    "name": "Material Symbols Outlined"
  },
  "Material Symbols Rounded": {
    "name": "Material Symbols Rounded"
  },
  "Material Symbols Sharp": {
    "name": "Material Symbols Sharp"
  },
  "Maven Pro": {
    "name": "Maven Pro"
  },
  "McLaren": {
    "name": "McLaren"
  },
  "Mea Culpa": {
    "name": "Mea Culpa"
  },
  "Meddon": {
    "name": "Meddon"
  },
  "MedievalSharp": {
    "name": "MedievalSharp"
  },
  "Medula One": {
    "name": "Medula One"
  },
  "Meera Inimai": {
    "name": "Meera Inimai"
  },
  "Megrim": {
    "name": "Megrim"
  },
  "Meie Script": {
    "name": "Meie Script"
  },
  "Meow Script": {
    "name": "Meow Script"
  },
  "Merienda": {
    "name": "Merienda"
  },
  "Merriweather": {
    "name": "Merriweather"
  },
  "Merriweather Sans": {
    "name": "Merriweather Sans"
  },
  "Metal": {
    "name": "Metal"
  },
  "Metal Mania": {
    "name": "Metal Mania"
  },
  "Metamorphous": {
    "name": "Metamorphous"
  },
  "Metrophobic": {
    "name": "Metrophobic"
  },
  "Michroma": {
    "name": "Michroma"
  },
  "Milonga": {
    "name": "Milonga"
  },
  "Miltonian": {
    "name": "Miltonian"
  },
  "Miltonian Tattoo": {
    "name": "Miltonian Tattoo"
  },
  "Mina": {
    "name": "Mina"
  },
  "Mingzat": {
    "name": "Mingzat"
  },
  "Miniver": {
    "name": "Miniver"
  },
  "Miriam Libre": {
    "name": "Miriam Libre"
  },
  "Mirza": {
    "name": "Mirza"
  },
  "Miss Fajardose": {
    "name": "Miss Fajardose"
  },
  "Mitr": {
    "name": "Mitr"
  },
  "Mochiy Pop One": {
    "name": "Mochiy Pop One"
  },
  "Mochiy Pop P One": {
    "name": "Mochiy Pop P One"
  },
  "Modak": {
    "name": "Modak"
  },
  "Modern Antiqua": {
    "name": "Modern Antiqua"
  },
  "Mogra": {
    "name": "Mogra"
  },
  "Mohave": {
    "name": "Mohave"
  },
  "Moirai One": {
    "name": "Moirai One"
  },
  "Molengo": {
    "name": "Molengo"
  },
  "Molle": {
    "name": "Molle"
  },
  "Monda": {
    "name": "Monda"
  },
  "Monofett": {
    "name": "Monofett"
  },
  "Monomaniac One": {
    "name": "Monomaniac One"
  },
  "Monoton": {
    "name": "Monoton"
  },
  "Monsieur La Doulaise": {
    "name": "Monsieur La Doulaise"
  },
  "Montaga": {
    "name": "Montaga"
  },
  "Montagu Slab": {
    "name": "Montagu Slab"
  },
  "MonteCarlo": {
    "name": "MonteCarlo"
  },
  "Montez": {
    "name": "Montez"
  },
  "Montserrat": {
    "name": "Montserrat"
  },
  "Montserrat Alternates": {
    "name": "Montserrat Alternates"
  },
  "Montserrat Subrayada": {
    "name": "Montserrat Subrayada"
  },
  "Moo Lah Lah": {
    "name": "Moo Lah Lah"
  },
  "Moon Dance": {
    "name": "Moon Dance"
  },
  "Moul": {
    "name": "Moul"
  },
  "Moulpali": {
    "name": "Moulpali"
  },
  "Mountains of Christmas": {
    "name": "Mountains of Christmas"
  },
  "Mouse Memoirs": {
    "name": "Mouse Memoirs"
  },
  "Mr Bedfort": {
    "name": "Mr Bedfort"
  },
  "Mr Dafoe": {
    "name": "Mr Dafoe"
  },
  "Mr De Haviland": {
    "name": "Mr De Haviland"
  },
  "Mrs Saint Delafield": {
    "name": "Mrs Saint Delafield"
  },
  "Mrs Sheppards": {
    "name": "Mrs Sheppards"
  },
  "Ms Madi": {
    "name": "Ms Madi"
  },
  "Mukta": {
    "name": "Mukta"
  },
  "Mukta Mahee": {
    "name": "Mukta Mahee"
  },
  "Mukta Malar": {
    "name": "Mukta Malar"
  },
  "Mukta Vaani": {
    "name": "Mukta Vaani"
  },
  "Mulish": {
    "name": "Mulish"
  },
  "Murecho": {
    "name": "Murecho"
  },
  "MuseoModerno": {
    "name": "MuseoModerno"
  },
  "My Soul": {
    "name": "My Soul"
  },
  "Mynerve": {
    "name": "Mynerve"
  },
  "Mystery Quest": {
    "name": "Mystery Quest"
  },
  "NTR": {
    "name": "NTR"
  },
  "Nabla": {
    "name": "Nabla"
  },
  "Nanum Brush Script": {
    "name": "Nanum Brush Script"
  },
  "Nanum Gothic": {
    "name": "Nanum Gothic"
  },
  "Nanum Gothic Coding": {
    "name": "Nanum Gothic Coding"
  },
  "Nanum Myeongjo": {
    "name": "Nanum Myeongjo"
  },
  "Nanum Pen Script": {
    "name": "Nanum Pen Script"
  },
  "Narnoor": {
    "name": "Narnoor"
  },
  "Neonderthaw": {
    "name": "Neonderthaw"
  },
  "Nerko One": {
    "name": "Nerko One"
  },
  "Neucha": {
    "name": "Neucha"
  },
  "Neuton": {
    "name": "Neuton"
  },
  "New Rocker": {
    "name": "New Rocker"
  },
  "New Tegomin": {
    "name": "New Tegomin"
  },
  "News Cycle": {
    "name": "News Cycle"
  },
  "Newsreader": {
    "name": "Newsreader"
  },
  "Niconne": {
    "name": "Niconne"
  },
  "Niramit": {
    "name": "Niramit"
  },
  "Nixie One": {
    "name": "Nixie One"
  },
  "Nobile": {
    "name": "Nobile"
  },
  "Nokora": {
    "name": "Nokora"
  },
  "Norican": {
    "name": "Norican"
  },
  "Nosifer": {
    "name": "Nosifer"
  },
  "Notable": {
    "name": "Notable"
  },
  "Nothing You Could Do": {
    "name": "Nothing You Could Do"
  },
  "Noticia Text": {
    "name": "Noticia Text"
  },
  "Noto Color Emoji": {
    "name": "Noto Color Emoji"
  },
  "Noto Emoji": {
    "name": "Noto Emoji"
  },
  "Noto Kufi Arabic": {
    "name": "Noto Kufi Arabic"
  },
  "Noto Music": {
    "name": "Noto Music"
  },
  "Noto Naskh Arabic": {
    "name": "Noto Naskh Arabic"
  },
  "Noto Nastaliq Urdu": {
    "name": "Noto Nastaliq Urdu"
  },
  "Noto Rashi Hebrew": {
    "name": "Noto Rashi Hebrew"
  },
  "Noto Sans": {
    "name": "Noto Sans"
  },
  "Noto Sans Adlam": {
    "name": "Noto Sans Adlam"
  },
  "Noto Sans Adlam Unjoined": {
    "name": "Noto Sans Adlam Unjoined"
  },
  "Noto Sans Anatolian Hieroglyphs": {
    "name": "Noto Sans Anatolian Hieroglyphs"
  },
  "Noto Sans Arabic": {
    "name": "Noto Sans Arabic"
  },
  "Noto Sans Armenian": {
    "name": "Noto Sans Armenian"
  },
  "Noto Sans Avestan": {
    "name": "Noto Sans Avestan"
  },
  "Noto Sans Balinese": {
    "name": "Noto Sans Balinese"
  },
  "Noto Sans Bamum": {
    "name": "Noto Sans Bamum"
  },
  "Noto Sans Bassa Vah": {
    "name": "Noto Sans Bassa Vah"
  },
  "Noto Sans Batak": {
    "name": "Noto Sans Batak"
  },
  "Noto Sans Bengali": {
    "name": "Noto Sans Bengali"
  },
  "Noto Sans Bhaiksuki": {
    "name": "Noto Sans Bhaiksuki"
  },
  "Noto Sans Brahmi": {
    "name": "Noto Sans Brahmi"
  },
  "Noto Sans Buginese": {
    "name": "Noto Sans Buginese"
  },
  "Noto Sans Buhid": {
    "name": "Noto Sans Buhid"
  },
  "Noto Sans Canadian Aboriginal": {
    "name": "Noto Sans Canadian Aboriginal"
  },
  "Noto Sans Carian": {
    "name": "Noto Sans Carian"
  },
  "Noto Sans Caucasian Albanian": {
    "name": "Noto Sans Caucasian Albanian"
  },
  "Noto Sans Chakma": {
    "name": "Noto Sans Chakma"
  },
  "Noto Sans Cham": {
    "name": "Noto Sans Cham"
  },
  "Noto Sans Cherokee": {
    "name": "Noto Sans Cherokee"
  },
  "Noto Sans Chorasmian": {
    "name": "Noto Sans Chorasmian"
  },
  "Noto Sans Coptic": {
    "name": "Noto Sans Coptic"
  },
  "Noto Sans Cuneiform": {
    "name": "Noto Sans Cuneiform"
  },
  "Noto Sans Cypriot": {
    "name": "Noto Sans Cypriot"
  },
  "Noto Sans Cypro Minoan": {
    "name": "Noto Sans Cypro Minoan"
  },
  "Noto Sans Deseret": {
    "name": "Noto Sans Deseret"
  },
  "Noto Sans Devanagari": {
    "name": "Noto Sans Devanagari"
  },
  "Noto Sans Display": {
    "name": "Noto Sans Display"
  },
  "Noto Sans Duployan": {
    "name": "Noto Sans Duployan"
  },
  "Noto Sans Egyptian Hieroglyphs": {
    "name": "Noto Sans Egyptian Hieroglyphs"
  },
  "Noto Sans Elbasan": {
    "name": "Noto Sans Elbasan"
  },
  "Noto Sans Elymaic": {
    "name": "Noto Sans Elymaic"
  },
  "Noto Sans Ethiopic": {
    "name": "Noto Sans Ethiopic"
  },
  "Noto Sans Georgian": {
    "name": "Noto Sans Georgian"
  },
  "Noto Sans Glagolitic": {
    "name": "Noto Sans Glagolitic"
  },
  "Noto Sans Gothic": {
    "name": "Noto Sans Gothic"
  },
  "Noto Sans Grantha": {
    "name": "Noto Sans Grantha"
  },
  "Noto Sans Gujarati": {
    "name": "Noto Sans Gujarati"
  },
  "Noto Sans Gunjala Gondi": {
    "name": "Noto Sans Gunjala Gondi"
  },
  "Noto Sans Gurmukhi": {
    "name": "Noto Sans Gurmukhi"
  },
  "Noto Sans HK": {
    "name": "Noto Sans HK"
  },
  "Noto Sans Hanifi Rohingya": {
    "name": "Noto Sans Hanifi Rohingya"
  },
  "Noto Sans Hanunoo": {
    "name": "Noto Sans Hanunoo"
  },
  "Noto Sans Hatran": {
    "name": "Noto Sans Hatran"
  },
  "Noto Sans Hebrew": {
    "name": "Noto Sans Hebrew"
  },
  "Noto Sans Imperial Aramaic": {
    "name": "Noto Sans Imperial Aramaic"
  },
  "Noto Sans Indic Siyaq Numbers": {
    "name": "Noto Sans Indic Siyaq Numbers"
  },
  "Noto Sans Inscriptional Pahlavi": {
    "name": "Noto Sans Inscriptional Pahlavi"
  },
  "Noto Sans Inscriptional Parthian": {
    "name": "Noto Sans Inscriptional Parthian"
  },
  "Noto Sans JP": {
    "name": "Noto Sans JP"
  },
  "Noto Sans Javanese": {
    "name": "Noto Sans Javanese"
  },
  "Noto Sans KR": {
    "name": "Noto Sans KR"
  },
  "Noto Sans Kaithi": {
    "name": "Noto Sans Kaithi"
  },
  "Noto Sans Kannada": {
    "name": "Noto Sans Kannada"
  },
  "Noto Sans Kayah Li": {
    "name": "Noto Sans Kayah Li"
  },
  "Noto Sans Kharoshthi": {
    "name": "Noto Sans Kharoshthi"
  },
  "Noto Sans Khmer": {
    "name": "Noto Sans Khmer"
  },
  "Noto Sans Khojki": {
    "name": "Noto Sans Khojki"
  },
  "Noto Sans Khudawadi": {
    "name": "Noto Sans Khudawadi"
  },
  "Noto Sans Lao": {
    "name": "Noto Sans Lao"
  },
  "Noto Sans Lao Looped": {
    "name": "Noto Sans Lao Looped"
  },
  "Noto Sans Lepcha": {
    "name": "Noto Sans Lepcha"
  },
  "Noto Sans Limbu": {
    "name": "Noto Sans Limbu"
  },
  "Noto Sans Linear A": {
    "name": "Noto Sans Linear A"
  },
  "Noto Sans Linear B": {
    "name": "Noto Sans Linear B"
  },
  "Noto Sans Lisu": {
    "name": "Noto Sans Lisu"
  },
  "Noto Sans Lycian": {
    "name": "Noto Sans Lycian"
  },
  "Noto Sans Lydian": {
    "name": "Noto Sans Lydian"
  },
  "Noto Sans Mahajani": {
    "name": "Noto Sans Mahajani"
  },
  "Noto Sans Malayalam": {
    "name": "Noto Sans Malayalam"
  },
  "Noto Sans Mandaic": {
    "name": "Noto Sans Mandaic"
  },
  "Noto Sans Manichaean": {
    "name": "Noto Sans Manichaean"
  },
  "Noto Sans Marchen": {
    "name": "Noto Sans Marchen"
  },
  "Noto Sans Masaram Gondi": {
    "name": "Noto Sans Masaram Gondi"
  },
  "Noto Sans Math": {
    "name": "Noto Sans Math"
  },
  "Noto Sans Mayan Numerals": {
    "name": "Noto Sans Mayan Numerals"
  },
  "Noto Sans Medefaidrin": {
    "name": "Noto Sans Medefaidrin"
  },
  "Noto Sans Meetei Mayek": {
    "name": "Noto Sans Meetei Mayek"
  },
  "Noto Sans Mende Kikakui": {
    "name": "Noto Sans Mende Kikakui"
  },
  "Noto Sans Meroitic": {
    "name": "Noto Sans Meroitic"
  },
  "Noto Sans Miao": {
    "name": "Noto Sans Miao"
  },
  "Noto Sans Modi": {
    "name": "Noto Sans Modi"
  },
  "Noto Sans Mongolian": {
    "name": "Noto Sans Mongolian"
  },
  "Noto Sans Mono": {
    "name": "Noto Sans Mono"
  },
  "Noto Sans Mro": {
    "name": "Noto Sans Mro"
  },
  "Noto Sans Multani": {
    "name": "Noto Sans Multani"
  },
  "Noto Sans Myanmar": {
    "name": "Noto Sans Myanmar"
  },
  "Noto Sans NKo": {
    "name": "Noto Sans NKo"
  },
  "Noto Sans Nabataean": {
    "name": "Noto Sans Nabataean"
  },
  "Noto Sans Nag Mundari": {
    "name": "Noto Sans Nag Mundari"
  },
  "Noto Sans Nandinagari": {
    "name": "Noto Sans Nandinagari"
  },
  "Noto Sans New Tai Lue": {
    "name": "Noto Sans New Tai Lue"
  },
  "Noto Sans Newa": {
    "name": "Noto Sans Newa"
  },
  "Noto Sans Nushu": {
    "name": "Noto Sans Nushu"
  },
  "Noto Sans Ogham": {
    "name": "Noto Sans Ogham"
  },
  "Noto Sans Ol Chiki": {
    "name": "Noto Sans Ol Chiki"
  },
  "Noto Sans Old Hungarian": {
    "name": "Noto Sans Old Hungarian"
  },
  "Noto Sans Old Italic": {
    "name": "Noto Sans Old Italic"
  },
  "Noto Sans Old North Arabian": {
    "name": "Noto Sans Old North Arabian"
  },
  "Noto Sans Old Permic": {
    "name": "Noto Sans Old Permic"
  },
  "Noto Sans Old Persian": {
    "name": "Noto Sans Old Persian"
  },
  "Noto Sans Old Sogdian": {
    "name": "Noto Sans Old Sogdian"
  },
  "Noto Sans Old South Arabian": {
    "name": "Noto Sans Old South Arabian"
  },
  "Noto Sans Old Turkic": {
    "name": "Noto Sans Old Turkic"
  },
  "Noto Sans Oriya": {
    "name": "Noto Sans Oriya"
  },
  "Noto Sans Osage": {
    "name": "Noto Sans Osage"
  },
  "Noto Sans Osmanya": {
    "name": "Noto Sans Osmanya"
  },
  "Noto Sans Pahawh Hmong": {
    "name": "Noto Sans Pahawh Hmong"
  },
  "Noto Sans Palmyrene": {
    "name": "Noto Sans Palmyrene"
  },
  "Noto Sans Pau Cin Hau": {
    "name": "Noto Sans Pau Cin Hau"
  },
  "Noto Sans Phags Pa": {
    "name": "Noto Sans Phags Pa"
  },
  "Noto Sans Phoenician": {
    "name": "Noto Sans Phoenician"
  },
  "Noto Sans Psalter Pahlavi": {
    "name": "Noto Sans Psalter Pahlavi"
  },
  "Noto Sans Rejang": {
    "name": "Noto Sans Rejang"
  },
  "Noto Sans Runic": {
    "name": "Noto Sans Runic"
  },
  "Noto Sans SC": {
    "name": "Noto Sans SC"
  },
  "Noto Sans Samaritan": {
    "name": "Noto Sans Samaritan"
  },
  "Noto Sans Saurashtra": {
    "name": "Noto Sans Saurashtra"
  },
  "Noto Sans Sharada": {
    "name": "Noto Sans Sharada"
  },
  "Noto Sans Shavian": {
    "name": "Noto Sans Shavian"
  },
  "Noto Sans Siddham": {
    "name": "Noto Sans Siddham"
  },
  "Noto Sans SignWriting": {
    "name": "Noto Sans SignWriting"
  },
  "Noto Sans Sinhala": {
    "name": "Noto Sans Sinhala"
  },
  "Noto Sans Sogdian": {
    "name": "Noto Sans Sogdian"
  },
  "Noto Sans Sora Sompeng": {
    "name": "Noto Sans Sora Sompeng"
  },
  "Noto Sans Soyombo": {
    "name": "Noto Sans Soyombo"
  },
  "Noto Sans Sundanese": {
    "name": "Noto Sans Sundanese"
  },
  "Noto Sans Syloti Nagri": {
    "name": "Noto Sans Syloti Nagri"
  },
  "Noto Sans Symbols": {
    "name": "Noto Sans Symbols"
  },
  "Noto Sans Symbols 2": {
    "name": "Noto Sans Symbols 2"
  },
  "Noto Sans Syriac": {
    "name": "Noto Sans Syriac"
  },
  "Noto Sans Syriac Eastern": {
    "name": "Noto Sans Syriac Eastern"
  },
  "Noto Sans TC": {
    "name": "Noto Sans TC"
  },
  "Noto Sans Tagalog": {
    "name": "Noto Sans Tagalog"
  },
  "Noto Sans Tagbanwa": {
    "name": "Noto Sans Tagbanwa"
  },
  "Noto Sans Tai Le": {
    "name": "Noto Sans Tai Le"
  },
  "Noto Sans Tai Tham": {
    "name": "Noto Sans Tai Tham"
  },
  "Noto Sans Tai Viet": {
    "name": "Noto Sans Tai Viet"
  },
  "Noto Sans Takri": {
    "name": "Noto Sans Takri"
  },
  "Noto Sans Tamil": {
    "name": "Noto Sans Tamil"
  },
  "Noto Sans Tamil Supplement": {
    "name": "Noto Sans Tamil Supplement"
  },
  "Noto Sans Tangsa": {
    "name": "Noto Sans Tangsa"
  },
  "Noto Sans Telugu": {
    "name": "Noto Sans Telugu"
  },
  "Noto Sans Thaana": {
    "name": "Noto Sans Thaana"
  },
  "Noto Sans Thai": {
    "name": "Noto Sans Thai"
  },
  "Noto Sans Thai Looped": {
    "name": "Noto Sans Thai Looped"
  },
  "Noto Sans Tifinagh": {
    "name": "Noto Sans Tifinagh"
  },
  "Noto Sans Tirhuta": {
    "name": "Noto Sans Tirhuta"
  },
  "Noto Sans Ugaritic": {
    "name": "Noto Sans Ugaritic"
  },
  "Noto Sans Vai": {
    "name": "Noto Sans Vai"
  },
  "Noto Sans Vithkuqi": {
    "name": "Noto Sans Vithkuqi"
  },
  "Noto Sans Wancho": {
    "name": "Noto Sans Wancho"
  },
  "Noto Sans Warang Citi": {
    "name": "Noto Sans Warang Citi"
  },
  "Noto Sans Yi": {
    "name": "Noto Sans Yi"
  },
  "Noto Sans Zanabazar Square": {
    "name": "Noto Sans Zanabazar Square"
  },
  "Noto Serif": {
    "name": "Noto Serif"
  },
  "Noto Serif Ahom": {
    "name": "Noto Serif Ahom"
  },
  "Noto Serif Armenian": {
    "name": "Noto Serif Armenian"
  },
  "Noto Serif Balinese": {
    "name": "Noto Serif Balinese"
  },
  "Noto Serif Bengali": {
    "name": "Noto Serif Bengali"
  },
  "Noto Serif Devanagari": {
    "name": "Noto Serif Devanagari"
  },
  "Noto Serif Display": {
    "name": "Noto Serif Display"
  },
  "Noto Serif Dogra": {
    "name": "Noto Serif Dogra"
  },
  "Noto Serif Ethiopic": {
    "name": "Noto Serif Ethiopic"
  },
  "Noto Serif Georgian": {
    "name": "Noto Serif Georgian"
  },
  "Noto Serif Grantha": {
    "name": "Noto Serif Grantha"
  },
  "Noto Serif Gujarati": {
    "name": "Noto Serif Gujarati"
  },
  "Noto Serif Gurmukhi": {
    "name": "Noto Serif Gurmukhi"
  },
  "Noto Serif HK": {
    "name": "Noto Serif HK"
  },
  "Noto Serif Hebrew": {
    "name": "Noto Serif Hebrew"
  },
  "Noto Serif JP": {
    "name": "Noto Serif JP"
  },
  "Noto Serif KR": {
    "name": "Noto Serif KR"
  },
  "Noto Serif Kannada": {
    "name": "Noto Serif Kannada"
  },
  "Noto Serif Khitan Small Script": {
    "name": "Noto Serif Khitan Small Script"
  },
  "Noto Serif Khmer": {
    "name": "Noto Serif Khmer"
  },
  "Noto Serif Khojki": {
    "name": "Noto Serif Khojki"
  },
  "Noto Serif Lao": {
    "name": "Noto Serif Lao"
  },
  "Noto Serif Makasar": {
    "name": "Noto Serif Makasar"
  },
  "Noto Serif Malayalam": {
    "name": "Noto Serif Malayalam"
  },
  "Noto Serif Myanmar": {
    "name": "Noto Serif Myanmar"
  },
  "Noto Serif NP Hmong": {
    "name": "Noto Serif NP Hmong"
  },
  "Noto Serif Oriya": {
    "name": "Noto Serif Oriya"
  },
  "Noto Serif Ottoman Siyaq": {
    "name": "Noto Serif Ottoman Siyaq"
  },
  "Noto Serif SC": {
    "name": "Noto Serif SC"
  },
  "Noto Serif Sinhala": {
    "name": "Noto Serif Sinhala"
  },
  "Noto Serif TC": {
    "name": "Noto Serif TC"
  },
  "Noto Serif Tamil": {
    "name": "Noto Serif Tamil"
  },
  "Noto Serif Tangut": {
    "name": "Noto Serif Tangut"
  },
  "Noto Serif Telugu": {
    "name": "Noto Serif Telugu"
  },
  "Noto Serif Thai": {
    "name": "Noto Serif Thai"
  },
  "Noto Serif Tibetan": {
    "name": "Noto Serif Tibetan"
  },
  "Noto Serif Toto": {
    "name": "Noto Serif Toto"
  },
  "Noto Serif Vithkuqi": {
    "name": "Noto Serif Vithkuqi"
  },
  "Noto Serif Yezidi": {
    "name": "Noto Serif Yezidi"
  },
  "Noto Traditional Nushu": {
    "name": "Noto Traditional Nushu"
  },
  "Nova Cut": {
    "name": "Nova Cut"
  },
  "Nova Flat": {
    "name": "Nova Flat"
  },
  "Nova Mono": {
    "name": "Nova Mono"
  },
  "Nova Oval": {
    "name": "Nova Oval"
  },
  "Nova Round": {
    "name": "Nova Round"
  },
  "Nova Script": {
    "name": "Nova Script"
  },
  "Nova Slim": {
    "name": "Nova Slim"
  },
  "Nova Square": {
    "name": "Nova Square"
  },
  "Numans": {
    "name": "Numans"
  },
  "Nunito": {
    "name": "Nunito"
  },
  "Nunito Sans": {
    "name": "Nunito Sans"
  },
  "Nuosu SIL": {
    "name": "Nuosu SIL"
  },
  "Odibee Sans": {
    "name": "Odibee Sans"
  },
  "Odor Mean Chey": {
    "name": "Odor Mean Chey"
  },
  "Offside": {
    "name": "Offside"
  },
  "Oi": {
    "name": "Oi"
  },
  "Old Standard TT": {
    "name": "Old Standard TT"
  },
  "Oldenburg": {
    "name": "Oldenburg"
  },
  "Ole": {
    "name": "Ole"
  },
  "Oleo Script": {
    "name": "Oleo Script"
  },
  "Oleo Script Swash Caps": {
    "name": "Oleo Script Swash Caps"
  },
  "Oooh Baby": {
    "name": "Oooh Baby"
  },
  "Open Sans": {
    "name": "Open Sans"
  },
  "Oranienbaum": {
    "name": "Oranienbaum"
  },
  "Orbit": {
    "name": "Orbit"
  },
  "Orbitron": {
    "name": "Orbitron"
  },
  "Oregano": {
    "name": "Oregano"
  },
  "Orelega One": {
    "name": "Orelega One"
  },
  "Orienta": {
    "name": "Orienta"
  },
  "Original Surfer": {
    "name": "Original Surfer"
  },
  "Oswald": {
    "name": "Oswald"
  },
  "Outfit": {
    "name": "Outfit"
  },
  "Over the Rainbow": {
    "name": "Over the Rainbow"
  },
  "Overlock": {
    "name": "Overlock"
  },
  "Overlock SC": {
    "name": "Overlock SC"
  },
  "Overpass": {
    "name": "Overpass"
  },
  "Overpass Mono": {
    "name": "Overpass Mono"
  },
  "Ovo": {
    "name": "Ovo"
  },
  "Oxanium": {
    "name": "Oxanium"
  },
  "Oxygen": {
    "name": "Oxygen"
  },
  "Oxygen Mono": {
    "name": "Oxygen Mono"
  },
  "PT Mono": {
    "name": "PT Mono"
  },
  "PT Sans": {
    "name": "PT Sans"
  },
  "PT Sans Caption": {
    "name": "PT Sans Caption"
  },
  "PT Sans Narrow": {
    "name": "PT Sans Narrow"
  },
  "PT Serif": {
    "name": "PT Serif"
  },
  "PT Serif Caption": {
    "name": "PT Serif Caption"
  },
  "Pacifico": {
    "name": "Pacifico"
  },
  "Padauk": {
    "name": "Padauk"
  },
  "Padyakke Expanded One": {
    "name": "Padyakke Expanded One"
  },
  "Palanquin": {
    "name": "Palanquin"
  },
  "Palanquin Dark": {
    "name": "Palanquin Dark"
  },
  "Palette Mosaic": {
    "name": "Palette Mosaic"
  },
  "Pangolin": {
    "name": "Pangolin"
  },
  "Paprika": {
    "name": "Paprika"
  },
  "Parisienne": {
    "name": "Parisienne"
  },
  "Passero One": {
    "name": "Passero One"
  },
  "Passion One": {
    "name": "Passion One"
  },
  "Passions Conflict": {
    "name": "Passions Conflict"
  },
  "Pathway Extreme": {
    "name": "Pathway Extreme"
  },
  "Pathway Gothic One": {
    "name": "Pathway Gothic One"
  },
  "Patrick Hand": {
    "name": "Patrick Hand"
  },
  "Patrick Hand SC": {
    "name": "Patrick Hand SC"
  },
  "Pattaya": {
    "name": "Pattaya"
  },
  "Patua One": {
    "name": "Patua One"
  },
  "Pavanam": {
    "name": "Pavanam"
  },
  "Paytone One": {
    "name": "Paytone One"
  },
  "Peddana": {
    "name": "Peddana"
  },
  "Peralta": {
    "name": "Peralta"
  },
  "Permanent Marker": {
    "name": "Permanent Marker"
  },
  "Petemoss": {
    "name": "Petemoss"
  },
  "Petit Formal Script": {
    "name": "Petit Formal Script"
  },
  "Petrona": {
    "name": "Petrona"
  },
  "Philosopher": {
    "name": "Philosopher"
  },
  "Phudu": {
    "name": "Phudu"
  },
  "Piazzolla": {
    "name": "Piazzolla"
  },
  "Piedra": {
    "name": "Piedra"
  },
  "Pinyon Script": {
    "name": "Pinyon Script"
  },
  "Pirata One": {
    "name": "Pirata One"
  },
  "Plaster": {
    "name": "Plaster"
  },
  "Play": {
    "name": "Play"
  },
  "Playball": {
    "name": "Playball"
  },
  "Playfair": {
    "name": "Playfair"
  },
  "Playfair Display": {
    "name": "Playfair Display"
  },
  "Playfair Display SC": {
    "name": "Playfair Display SC"
  },
  "Plus Jakarta Sans": {
    "name": "Plus Jakarta Sans"
  },
  "Podkova": {
    "name": "Podkova"
  },
  "Poiret One": {
    "name": "Poiret One"
  },
  "Poller One": {
    "name": "Poller One"
  },
  "Poltawski Nowy": {
    "name": "Poltawski Nowy"
  },
  "Poly": {
    "name": "Poly"
  },
  "Pompiere": {
    "name": "Pompiere"
  },
  "Pontano Sans": {
    "name": "Pontano Sans"
  },
  "Poor Story": {
    "name": "Poor Story"
  },
  "Poppins": {
    "name": "Poppins"
  },
  "Port Lligat Sans": {
    "name": "Port Lligat Sans"
  },
  "Port Lligat Slab": {
    "name": "Port Lligat Slab"
  },
  "Potta One": {
    "name": "Potta One"
  },
  "Pragati Narrow": {
    "name": "Pragati Narrow"
  },
  "Praise": {
    "name": "Praise"
  },
  "Prata": {
    "name": "Prata"
  },
  "Preahvihear": {
    "name": "Preahvihear"
  },
  "Press Start 2P": {
    "name": "Press Start 2P"
  },
  "Pridi": {
    "name": "Pridi"
  },
  "Princess Sofia": {
    "name": "Princess Sofia"
  },
  "Prociono": {
    "name": "Prociono"
  },
  "Prompt": {
    "name": "Prompt"
  },
  "Prosto One": {
    "name": "Prosto One"
  },
  "Proza Libre": {
    "name": "Proza Libre"
  },
  "Public Sans": {
    "name": "Public Sans"
  },
  "Puppies Play": {
    "name": "Puppies Play"
  },
  "Puritan": {
    "name": "Puritan"
  },
  "Purple Purse": {
    "name": "Purple Purse"
  },
  "Pushster": {
    "name": "Pushster"
  },
  "Qahiri": {
    "name": "Qahiri"
  },
  "Quando": {
    "name": "Quando"
  },
  "Quantico": {
    "name": "Quantico"
  },
  "Quattrocento": {
    "name": "Quattrocento"
  },
  "Quattrocento Sans": {
    "name": "Quattrocento Sans"
  },
  "Questrial": {
    "name": "Questrial"
  },
  "Quicksand": {
    "name": "Quicksand"
  },
  "Quintessential": {
    "name": "Quintessential"
  },
  "Qwigley": {
    "name": "Qwigley"
  },
  "Qwitcher Grypen": {
    "name": "Qwitcher Grypen"
  },
  "REM": {
    "name": "REM"
  },
  "Racing Sans One": {
    "name": "Racing Sans One"
  },
  "Radio Canada": {
    "name": "Radio Canada"
  },
  "Radley": {
    "name": "Radley"
  },
  "Rajdhani": {
    "name": "Rajdhani"
  },
  "Rakkas": {
    "name": "Rakkas"
  },
  "Raleway": {
    "name": "Raleway"
  },
  "Raleway Dots": {
    "name": "Raleway Dots"
  },
  "Ramabhadra": {
    "name": "Ramabhadra"
  },
  "Ramaraja": {
    "name": "Ramaraja"
  },
  "Rambla": {
    "name": "Rambla"
  },
  "Rammetto One": {
    "name": "Rammetto One"
  },
  "Rampart One": {
    "name": "Rampart One"
  },
  "Ranchers": {
    "name": "Ranchers"
  },
  "Rancho": {
    "name": "Rancho"
  },
  "Ranga": {
    "name": "Ranga"
  },
  "Rasa": {
    "name": "Rasa"
  },
  "Rationale": {
    "name": "Rationale"
  },
  "Ravi Prakash": {
    "name": "Ravi Prakash"
  },
  "Readex Pro": {
    "name": "Readex Pro"
  },
  "Recursive": {
    "name": "Recursive"
  },
  "Red Hat Display": {
    "name": "Red Hat Display"
  },
  "Red Hat Mono": {
    "name": "Red Hat Mono"
  },
  "Red Hat Text": {
    "name": "Red Hat Text"
  },
  "Red Rose": {
    "name": "Red Rose"
  },
  "Redacted": {
    "name": "Redacted"
  },
  "Redacted Script": {
    "name": "Redacted Script"
  },
  "Redressed": {
    "name": "Redressed"
  },
  "Reem Kufi": {
    "name": "Reem Kufi"
  },
  "Reem Kufi Fun": {
    "name": "Reem Kufi Fun"
  },
  "Reem Kufi Ink": {
    "name": "Reem Kufi Ink"
  },
  "Reenie Beanie": {
    "name": "Reenie Beanie"
  },
  "Reggae One": {
    "name": "Reggae One"
  },
  "Revalia": {
    "name": "Revalia"
  },
  "Rhodium Libre": {
    "name": "Rhodium Libre"
  },
  "Ribeye": {
    "name": "Ribeye"
  },
  "Ribeye Marrow": {
    "name": "Ribeye Marrow"
  },
  "Righteous": {
    "name": "Righteous"
  },
  "Risque": {
    "name": "Risque"
  },
  "Road Rage": {
    "name": "Road Rage"
  },
  "Roboto": {
    "name": "Roboto"
  },
  "Roboto Condensed": {
    "name": "Roboto Condensed"
  },
  "Roboto Flex": {
    "name": "Roboto Flex"
  },
  "Roboto Mono": {
    "name": "Roboto Mono"
  },
  "Roboto Serif": {
    "name": "Roboto Serif"
  },
  "Roboto Slab": {
    "name": "Roboto Slab"
  },
  "Rochester": {
    "name": "Rochester"
  },
  "Rock 3D": {
    "name": "Rock 3D"
  },
  "Rock Salt": {
    "name": "Rock Salt"
  },
  "RocknRoll One": {
    "name": "RocknRoll One"
  },
  "Rokkitt": {
    "name": "Rokkitt"
  },
  "Romanesco": {
    "name": "Romanesco"
  },
  "Ropa Sans": {
    "name": "Ropa Sans"
  },
  "Rosario": {
    "name": "Rosario"
  },
  "Rosarivo": {
    "name": "Rosarivo"
  },
  "Rouge Script": {
    "name": "Rouge Script"
  },
  "Rowdies": {
    "name": "Rowdies"
  },
  "Rozha One": {
    "name": "Rozha One"
  },
  "Rubik": {
    "name": "Rubik"
  },
  "Rubik 80s Fade": {
    "name": "Rubik 80s Fade"
  },
  "Rubik Beastly": {
    "name": "Rubik Beastly"
  },
  "Rubik Bubbles": {
    "name": "Rubik Bubbles"
  },
  "Rubik Burned": {
    "name": "Rubik Burned"
  },
  "Rubik Dirt": {
    "name": "Rubik Dirt"
  },
  "Rubik Distressed": {
    "name": "Rubik Distressed"
  },
  "Rubik Gemstones": {
    "name": "Rubik Gemstones"
  },
  "Rubik Glitch": {
    "name": "Rubik Glitch"
  },
  "Rubik Iso": {
    "name": "Rubik Iso"
  },
  "Rubik Marker Hatch": {
    "name": "Rubik Marker Hatch"
  },
  "Rubik Maze": {
    "name": "Rubik Maze"
  },
  "Rubik Microbe": {
    "name": "Rubik Microbe"
  },
  "Rubik Mono One": {
    "name": "Rubik Mono One"
  },
  "Rubik Moonrocks": {
    "name": "Rubik Moonrocks"
  },
  "Rubik Pixels": {
    "name": "Rubik Pixels"
  },
  "Rubik Puddles": {
    "name": "Rubik Puddles"
  },
  "Rubik Spray Paint": {
    "name": "Rubik Spray Paint"
  },
  "Rubik Storm": {
    "name": "Rubik Storm"
  },
  "Rubik Vinyl": {
    "name": "Rubik Vinyl"
  },
  "Rubik Wet Paint": {
    "name": "Rubik Wet Paint"
  },
  "Ruda": {
    "name": "Ruda"
  },
  "Rufina": {
    "name": "Rufina"
  },
  "Ruge Boogie": {
    "name": "Ruge Boogie"
  },
  "Ruluko": {
    "name": "Ruluko"
  },
  "Rum Raisin": {
    "name": "Rum Raisin"
  },
  "Ruslan Display": {
    "name": "Ruslan Display"
  },
  "Russo One": {
    "name": "Russo One"
  },
  "Ruthie": {
    "name": "Ruthie"
  },
  "Ruwudu": {
    "name": "Ruwudu"
  },
  "Rye": {
    "name": "Rye"
  },
  "STIX Two Text": {
    "name": "STIX Two Text"
  },
  "Sacramento": {
    "name": "Sacramento"
  },
  "Sahitya": {
    "name": "Sahitya"
  },
  "Sail": {
    "name": "Sail"
  },
  "Saira": {
    "name": "Saira"
  },
  "Saira Condensed": {
    "name": "Saira Condensed"
  },
  "Saira Extra Condensed": {
    "name": "Saira Extra Condensed"
  },
  "Saira Semi Condensed": {
    "name": "Saira Semi Condensed"
  },
  "Saira Stencil One": {
    "name": "Saira Stencil One"
  },
  "Salsa": {
    "name": "Salsa"
  },
  "Sanchez": {
    "name": "Sanchez"
  },
  "Sancreek": {
    "name": "Sancreek"
  },
  "Sansita": {
    "name": "Sansita"
  },
  "Sansita Swashed": {
    "name": "Sansita Swashed"
  },
  "Sarabun": {
    "name": "Sarabun"
  },
  "Sarala": {
    "name": "Sarala"
  },
  "Sarina": {
    "name": "Sarina"
  },
  "Sarpanch": {
    "name": "Sarpanch"
  },
  "Sassy Frass": {
    "name": "Sassy Frass"
  },
  "Satisfy": {
    "name": "Satisfy"
  },
  "Sawarabi Gothic": {
    "name": "Sawarabi Gothic"
  },
  "Sawarabi Mincho": {
    "name": "Sawarabi Mincho"
  },
  "Scada": {
    "name": "Scada"
  },
  "Scheherazade New": {
    "name": "Scheherazade New"
  },
  "Schibsted Grotesk": {
    "name": "Schibsted Grotesk"
  },
  "Schoolbell": {
    "name": "Schoolbell"
  },
  "Scope One": {
    "name": "Scope One"
  },
  "Seaweed Script": {
    "name": "Seaweed Script"
  },
  "Secular One": {
    "name": "Secular One"
  },
  "Sedgwick Ave": {
    "name": "Sedgwick Ave"
  },
  "Sedgwick Ave Display": {
    "name": "Sedgwick Ave Display"
  },
  "Sen": {
    "name": "Sen"
  },
  "Send Flowers": {
    "name": "Send Flowers"
  },
  "Sevillana": {
    "name": "Sevillana"
  },
  "Seymour One": {
    "name": "Seymour One"
  },
  "Shadows Into Light": {
    "name": "Shadows Into Light"
  },
  "Shadows Into Light Two": {
    "name": "Shadows Into Light Two"
  },
  "Shalimar": {
    "name": "Shalimar"
  },
  "Shantell Sans": {
    "name": "Shantell Sans"
  },
  "Shanti": {
    "name": "Shanti"
  },
  "Share": {
    "name": "Share"
  },
  "Share Tech": {
    "name": "Share Tech"
  },
  "Share Tech Mono": {
    "name": "Share Tech Mono"
  },
  "Shippori Antique": {
    "name": "Shippori Antique"
  },
  "Shippori Antique B1": {
    "name": "Shippori Antique B1"
  },
  "Shippori Mincho": {
    "name": "Shippori Mincho"
  },
  "Shippori Mincho B1": {
    "name": "Shippori Mincho B1"
  },
  "Shizuru": {
    "name": "Shizuru"
  },
  "Shojumaru": {
    "name": "Shojumaru"
  },
  "Short Stack": {
    "name": "Short Stack"
  },
  "Shrikhand": {
    "name": "Shrikhand"
  },
  "Siemreap": {
    "name": "Siemreap"
  },
  "Sigmar": {
    "name": "Sigmar"
  },
  "Sigmar One": {
    "name": "Sigmar One"
  },
  "Signika": {
    "name": "Signika"
  },
  "Signika Negative": {
    "name": "Signika Negative"
  },
  "Silkscreen": {
    "name": "Silkscreen"
  },
  "Simonetta": {
    "name": "Simonetta"
  },
  "Single Day": {
    "name": "Single Day"
  },
  "Sintony": {
    "name": "Sintony"
  },
  "Sirin Stencil": {
    "name": "Sirin Stencil"
  },
  "Six Caps": {
    "name": "Six Caps"
  },
  "Skranji": {
    "name": "Skranji"
  },
  "Slabo 13px": {
    "name": "Slabo 13px"
  },
  "Slabo 27px": {
    "name": "Slabo 27px"
  },
  "Slackey": {
    "name": "Slackey"
  },
  "Slackside One": {
    "name": "Slackside One"
  },
  "Smokum": {
    "name": "Smokum"
  },
  "Smooch": {
    "name": "Smooch"
  },
  "Smooch Sans": {
    "name": "Smooch Sans"
  },
  "Smythe": {
    "name": "Smythe"
  },
  "Sniglet": {
    "name": "Sniglet"
  },
  "Snippet": {
    "name": "Snippet"
  },
  "Snowburst One": {
    "name": "Snowburst One"
  },
  "Sofadi One": {
    "name": "Sofadi One"
  },
  "Sofia": {
    "name": "Sofia"
  },
  "Sofia Sans": {
    "name": "Sofia Sans"
  },
  "Sofia Sans Condensed": {
    "name": "Sofia Sans Condensed"
  },
  "Sofia Sans Extra Condensed": {
    "name": "Sofia Sans Extra Condensed"
  },
  "Sofia Sans Semi Condensed": {
    "name": "Sofia Sans Semi Condensed"
  },
  "Solitreo": {
    "name": "Solitreo"
  },
  "Solway": {
    "name": "Solway"
  },
  "Song Myung": {
    "name": "Song Myung"
  },
  "Sono": {
    "name": "Sono"
  },
  "Sonsie One": {
    "name": "Sonsie One"
  },
  "Sora": {
    "name": "Sora"
  },
  "Sorts Mill Goudy": {
    "name": "Sorts Mill Goudy"
  },
  "Source Code Pro": {
    "name": "Source Code Pro"
  },
  "Source Sans 3": {
    "name": "Source Sans 3"
  },
  "Source Serif 4": {
    "name": "Source Serif 4"
  },
  "Space Grotesk": {
    "name": "Space Grotesk"
  },
  "Space Mono": {
    "name": "Space Mono"
  },
  "Special Elite": {
    "name": "Special Elite"
  },
  "Spectral": {
    "name": "Spectral"
  },
  "Spectral SC": {
    "name": "Spectral SC"
  },
  "Spicy Rice": {
    "name": "Spicy Rice"
  },
  "Spinnaker": {
    "name": "Spinnaker"
  },
  "Spirax": {
    "name": "Spirax"
  },
  "Splash": {
    "name": "Splash"
  },
  "Spline Sans": {
    "name": "Spline Sans"
  },
  "Spline Sans Mono": {
    "name": "Spline Sans Mono"
  },
  "Squada One": {
    "name": "Squada One"
  },
  "Square Peg": {
    "name": "Square Peg"
  },
  "Sree Krushnadevaraya": {
    "name": "Sree Krushnadevaraya"
  },
  "Sriracha": {
    "name": "Sriracha"
  },
  "Srisakdi": {
    "name": "Srisakdi"
  },
  "Staatliches": {
    "name": "Staatliches"
  },
  "Stalemate": {
    "name": "Stalemate"
  },
  "Stalinist One": {
    "name": "Stalinist One"
  },
  "Stardos Stencil": {
    "name": "Stardos Stencil"
  },
  "Stick": {
    "name": "Stick"
  },
  "Stick No Bills": {
    "name": "Stick No Bills"
  },
  "Stint Ultra Condensed": {
    "name": "Stint Ultra Condensed"
  },
  "Stint Ultra Expanded": {
    "name": "Stint Ultra Expanded"
  },
  "Stoke": {
    "name": "Stoke"
  },
  "Strait": {
    "name": "Strait"
  },
  "Style Script": {
    "name": "Style Script"
  },
  "Stylish": {
    "name": "Stylish"
  },
  "Sue Ellen Francisco": {
    "name": "Sue Ellen Francisco"
  },
  "Suez One": {
    "name": "Suez One"
  },
  "Sulphur Point": {
    "name": "Sulphur Point"
  },
  "Sumana": {
    "name": "Sumana"
  },
  "Sunflower": {
    "name": "Sunflower"
  },
  "Sunshiney": {
    "name": "Sunshiney"
  },
  "Supermercado One": {
    "name": "Supermercado One"
  },
  "Sura": {
    "name": "Sura"
  },
  "Suranna": {
    "name": "Suranna"
  },
  "Suravaram": {
    "name": "Suravaram"
  },
  "Suwannaphum": {
    "name": "Suwannaphum"
  },
  "Swanky and Moo Moo": {
    "name": "Swanky and Moo Moo"
  },
  "Syncopate": {
    "name": "Syncopate"
  },
  "Syne": {
    "name": "Syne"
  },
  "Syne Mono": {
    "name": "Syne Mono"
  },
  "Syne Tactile": {
    "name": "Syne Tactile"
  },
  "Tai Heritage Pro": {
    "name": "Tai Heritage Pro"
  },
  "Tajawal": {
    "name": "Tajawal"
  },
  "Tangerine": {
    "name": "Tangerine"
  },
  "Tapestry": {
    "name": "Tapestry"
  },
  "Taprom": {
    "name": "Taprom"
  },
  "Tauri": {
    "name": "Tauri"
  },
  "Taviraj": {
    "name": "Taviraj"
  },
  "Teko": {
    "name": "Teko"
  },
  "Tektur": {
    "name": "Tektur"
  },
  "Telex": {
    "name": "Telex"
  },
  "Tenali Ramakrishna": {
    "name": "Tenali Ramakrishna"
  },
  "Tenor Sans": {
    "name": "Tenor Sans"
  },
  "Text Me One": {
    "name": "Text Me One"
  },
  "Texturina": {
    "name": "Texturina"
  },
  "Thasadith": {
    "name": "Thasadith"
  },
  "The Girl Next Door": {
    "name": "The Girl Next Door"
  },
  "The Nautigal": {
    "name": "The Nautigal"
  },
  "Tienne": {
    "name": "Tienne"
  },
  "Tillana": {
    "name": "Tillana"
  },
  "Tilt Neon": {
    "name": "Tilt Neon"
  },
  "Tilt Prism": {
    "name": "Tilt Prism"
  },
  "Tilt Warp": {
    "name": "Tilt Warp"
  },
  "Timmana": {
    "name": "Timmana"
  },
  "Tinos": {
    "name": "Tinos"
  },
  "Tiro Bangla": {
    "name": "Tiro Bangla"
  },
  "Tiro Devanagari Hindi": {
    "name": "Tiro Devanagari Hindi"
  },
  "Tiro Devanagari Marathi": {
    "name": "Tiro Devanagari Marathi"
  },
  "Tiro Devanagari Sanskrit": {
    "name": "Tiro Devanagari Sanskrit"
  },
  "Tiro Gurmukhi": {
    "name": "Tiro Gurmukhi"
  },
  "Tiro Kannada": {
    "name": "Tiro Kannada"
  },
  "Tiro Tamil": {
    "name": "Tiro Tamil"
  },
  "Tiro Telugu": {
    "name": "Tiro Telugu"
  },
  "Titan One": {
    "name": "Titan One"
  },
  "Titillium Web": {
    "name": "Titillium Web"
  },
  "Tomorrow": {
    "name": "Tomorrow"
  },
  "Tourney": {
    "name": "Tourney"
  },
  "Trade Winds": {
    "name": "Trade Winds"
  },
  "Train One": {
    "name": "Train One"
  },
  "Trirong": {
    "name": "Trirong"
  },
  "Trispace": {
    "name": "Trispace"
  },
  "Trocchi": {
    "name": "Trocchi"
  },
  "Trochut": {
    "name": "Trochut"
  },
  "Truculenta": {
    "name": "Truculenta"
  },
  "Trykker": {
    "name": "Trykker"
  },
  "Tsukimi Rounded": {
    "name": "Tsukimi Rounded"
  },
  "Tulpen One": {
    "name": "Tulpen One"
  },
  "Turret Road": {
    "name": "Turret Road"
  },
  "Twinkle Star": {
    "name": "Twinkle Star"
  },
  "Ubuntu": {
    "name": "Ubuntu"
  },
  "Ubuntu Condensed": {
    "name": "Ubuntu Condensed"
  },
  "Ubuntu Mono": {
    "name": "Ubuntu Mono"
  },
  "Uchen": {
    "name": "Uchen"
  },
  "Ultra": {
    "name": "Ultra"
  },
  "Unbounded": {
    "name": "Unbounded"
  },
  "Uncial Antiqua": {
    "name": "Uncial Antiqua"
  },
  "Underdog": {
    "name": "Underdog"
  },
  "Unica One": {
    "name": "Unica One"
  },
  "UnifrakturCook": {
    "name": "UnifrakturCook"
  },
  "UnifrakturMaguntia": {
    "name": "UnifrakturMaguntia"
  },
  "Unkempt": {
    "name": "Unkempt"
  },
  "Unlock": {
    "name": "Unlock"
  },
  "Unna": {
    "name": "Unna"
  },
  "Updock": {
    "name": "Updock"
  },
  "Urbanist": {
    "name": "Urbanist"
  },
  "VT323": {
    "name": "VT323"
  },
  "Vampiro One": {
    "name": "Vampiro One"
  },
  "Varela": {
    "name": "Varela"
  },
  "Varela Round": {
    "name": "Varela Round"
  },
  "Varta": {
    "name": "Varta"
  },
  "Vast Shadow": {
    "name": "Vast Shadow"
  },
  "Vazirmatn": {
    "name": "Vazirmatn"
  },
  "Vesper Libre": {
    "name": "Vesper Libre"
  },
  "Viaoda Libre": {
    "name": "Viaoda Libre"
  },
  "Vibes": {
    "name": "Vibes"
  },
  "Vibur": {
    "name": "Vibur"
  },
  "Victor Mono": {
    "name": "Victor Mono"
  },
  "Vidaloka": {
    "name": "Vidaloka"
  },
  "Viga": {
    "name": "Viga"
  },
  "Vina Sans": {
    "name": "Vina Sans"
  },
  "Voces": {
    "name": "Voces"
  },
  "Volkhov": {
    "name": "Volkhov"
  },
  "Vollkorn": {
    "name": "Vollkorn"
  },
  "Vollkorn SC": {
    "name": "Vollkorn SC"
  },
  "Voltaire": {
    "name": "Voltaire"
  },
  "Vujahday Script": {
    "name": "Vujahday Script"
  },
  "Waiting for the Sunrise": {
    "name": "Waiting for the Sunrise"
  },
  "Wallpoet": {
    "name": "Wallpoet"
  },
  "Walter Turncoat": {
    "name": "Walter Turncoat"
  },
  "Warnes": {
    "name": "Warnes"
  },
  "Water Brush": {
    "name": "Water Brush"
  },
  "Waterfall": {
    "name": "Waterfall"
  },
  "Wavefont": {
    "name": "Wavefont"
  },
  "Wellfleet": {
    "name": "Wellfleet"
  },
  "Wendy One": {
    "name": "Wendy One"
  },
  "Whisper": {
    "name": "Whisper"
  },
  "WindSong": {
    "name": "WindSong"
  },
  "Wire One": {
    "name": "Wire One"
  },
  "Wix Madefor Display": {
    "name": "Wix Madefor Display"
  },
  "Wix Madefor Text": {
    "name": "Wix Madefor Text"
  },
  "Work Sans": {
    "name": "Work Sans"
  },
  "Xanh Mono": {
    "name": "Xanh Mono"
  },
  "Yaldevi": {
    "name": "Yaldevi"
  },
  "Yanone Kaffeesatz": {
    "name": "Yanone Kaffeesatz"
  },
  "Yantramanav": {
    "name": "Yantramanav"
  },
  "Yatra One": {
    "name": "Yatra One"
  },
  "Yellowtail": {
    "name": "Yellowtail"
  },
  "Yeon Sung": {
    "name": "Yeon Sung"
  },
  "Yeseva One": {
    "name": "Yeseva One"
  },
  "Yesteryear": {
    "name": "Yesteryear"
  },
  "Yomogi": {
    "name": "Yomogi"
  },
  "Yrsa": {
    "name": "Yrsa"
  },
  "Ysabeau": {
    "name": "Ysabeau"
  },
  "Ysabeau Infant": {
    "name": "Ysabeau Infant"
  },
  "Ysabeau Office": {
    "name": "Ysabeau Office"
  },
  "Ysabeau SC": {
    "name": "Ysabeau SC"
  },
  "Yuji Boku": {
    "name": "Yuji Boku"
  },
  "Yuji Hentaigana Akari": {
    "name": "Yuji Hentaigana Akari"
  },
  "Yuji Hentaigana Akebono": {
    "name": "Yuji Hentaigana Akebono"
  },
  "Yuji Mai": {
    "name": "Yuji Mai"
  },
  "Yuji Syuku": {
    "name": "Yuji Syuku"
  },
  "Yusei Magic": {
    "name": "Yusei Magic"
  },
  "ZCOOL KuaiLe": {
    "name": "ZCOOL KuaiLe"
  },
  "ZCOOL QingKe HuangYou": {
    "name": "ZCOOL QingKe HuangYou"
  },
  "ZCOOL XiaoWei": {
    "name": "ZCOOL XiaoWei"
  },
  "Zen Antique": {
    "name": "Zen Antique"
  },
  "Zen Antique Soft": {
    "name": "Zen Antique Soft"
  },
  "Zen Dots": {
    "name": "Zen Dots"
  },
  "Zen Kaku Gothic Antique": {
    "name": "Zen Kaku Gothic Antique"
  },
  "Zen Kaku Gothic New": {
    "name": "Zen Kaku Gothic New"
  },
  "Zen Kurenaido": {
    "name": "Zen Kurenaido"
  },
  "Zen Loop": {
    "name": "Zen Loop"
  },
  "Zen Maru Gothic": {
    "name": "Zen Maru Gothic"
  },
  "Zen Old Mincho": {
    "name": "Zen Old Mincho"
  },
  "Zen Tokyo Zoo": {
    "name": "Zen Tokyo Zoo"
  },
  "Zeyada": {
    "name": "Zeyada"
  },
  "Zhi Mang Xing": {
    "name": "Zhi Mang Xing"
  },
  "Zilla Slab": {
    "name": "Zilla Slab"
  },
  "Zilla Slab Highlight": {
    "name": "Zilla Slab Highlight"
  }
};
/* harmony default export */ __webpack_exports__["default"] = (fonts);

/***/ }),

/***/ "../components/premium-size-units.js":
/*!*******************************************!*\
  !*** ../components/premium-size-units.js ***!
  \*******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ PremiumSizeUnits; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

function PremiumSizeUnits(props) {
  const {
    activeUnit,
    units,
    onChangeSizeUnit = unit => {}
  } = props;
  let sizeUnits = ["px", "em", "%"];

  if (undefined !== units) {
    sizeUnits = units;
  }

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    className: "premium-slider-units"
  }, sizeUnits.map((unit, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
    className: "single-unit " + (unit === activeUnit && "active"),
    onClick: () => onChangeSizeUnit(unit)
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: `unit-text`
  }, " ", unit))));
}

/***/ }),

/***/ "../components/premium-typo.js":
/*!*************************************!*\
  !*** ../components/premium-typo.js ***!
  \*************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ PremiumTypo; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _premium_fonts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./premium-fonts */ "../components/premium-fonts.js");
/* harmony import */ var _RangeControl_responsive_range_control__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./RangeControl/responsive-range-control */ "../components/RangeControl/responsive-range-control.js");
/* harmony import */ var _RangeControl_single_range_control__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./RangeControl/single-range-control */ "../components/RangeControl/single-range-control.js");
/* harmony import */ var _typography_fontList__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./typography/fontList */ "../components/typography/fontList.js");
/* harmony import */ var _typography_util__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./typography/util */ "../components/typography/util.js");






const {
  __
} = wp.i18n;
const {
  Component
} = wp.element;
const {
  SelectControl,
  Popover
} = wp.components;

function fuzzysearch(needle, haystack) {
  var hlen = haystack.length;
  var nlen = needle.length;

  if (nlen > hlen) {
    return false;
  }

  if (nlen === hlen) {
    return needle === haystack;
  }

  outer: for (var i = 0, j = 0; i < nlen; i++) {
    var nch = needle.charCodeAt(i);

    while (j < hlen) {
      if (haystack.charCodeAt(j++) === nch) {
        continue outer;
      }
    }

    return false;
  }

  return true;
}

class PremiumTypo extends Component {
  constructor() {
    super(...arguments);
    let defaultValues = {
      fontWeight: "",
      fontStyle: "",
      textTransform: "",
      letterSpacing: {
        Desktop: "",
        Tablet: "",
        Mobile: "",
        unit: "px"
      },
      fontFamily: "Default",
      lineHeight: {
        Desktop: "",
        Tablet: "",
        Mobile: "",
        unit: "px"
      },
      textDecoration: "",
      fontSize: {
        Desktop: "",
        Tablet: "",
        Mobile: "",
        unit: "px"
      }
    };
    this.state = {
      isVisible: false,
      currentView: "",
      search: "",
      device: "Desktop",
      value: this.props.value
    };
  }

  render() {
    var _value$fontSize;

    const {
      onChange
    } = this.props;
    const {
      value,
      isVisible,
      currentView,
      search,
      device
    } = this.state;
    const STYLE = [{
      value: "normal",
      label: __("Normal", "premium-blocks-for-gutenberg")
    }, {
      value: "italic",
      label: __("Italic", "premium-blocks-for-gutenberg")
    }, {
      value: "oblique",
      label: __("Oblique", "premium-blocks-for-gutenberg")
    }];
    const fonts = [{
      value: "Default",
      label: __("Default", "premium-blocks-for-gutenberg"),
      weight: [__("Default", "premium-blocks-for-gutenberg"), "100", "200", "300", "400", "500", "600", "700", "800", "900"],
      google: false
    }, {
      value: "Arial",
      label: "Arial",
      weight: [__("Default", "premium-blocks-for-gutenberg"), "100", "200", "300", "400", "500", "600", "700", "800", "900"],
      google: false
    }, {
      value: "Helvetica",
      label: "Helvetica",
      weight: [__("Default", "premium-blocks-for-gutenberg"), "100", "200", "300", "400", "500", "600", "700", "800", "900"],
      google: false
    }, {
      value: "Times New Roman",
      label: "Times New Roman",
      weight: [__("Default", "premium-blocks-for-gutenberg"), "100", "200", "300", "400", "500", "600", "700", "800", "900"],
      google: false
    }, {
      value: "Georgia",
      label: "Georgia",
      weight: [__("Default", "premium-blocks-for-gutenberg"), "100", "200", "300", "400", "500", "600", "700", "800", "900"],
      google: false
    }];
    let previewDevice = wp.data && wp.data.select && wp.data.select("core/edit-post") && wp.data.select("core/edit-post").__experimentalGetPreviewDeviceType ? wp.data.select("core/edit-post").__experimentalGetPreviewDeviceType() : "Desktop";

    if (this.state.device !== previewDevice) {
      this.setState({
        device: previewDevice
      });
    }

    let fontWeight = "";
    const performance = PremiumBlocksSettings.performance || {};
    const enableSelectGoogleFonts = (performance === null || performance === void 0 ? void 0 : performance["premium-enable-allowed-fonts"]) || false;
    const selectedGoogleFonts = (performance === null || performance === void 0 ? void 0 : performance["premium-google-fonts"]) || [];
    Object.keys(_premium_fonts__WEBPACK_IMPORTED_MODULE_1__["default"]).map((k, v) => {
      if (enableSelectGoogleFonts && selectedGoogleFonts.indexOf(k) === -1) return;
      fonts.push({
        value: k,
        label: k,
        weight: _premium_fonts__WEBPACK_IMPORTED_MODULE_1__["default"][k].weight,
        google: true
      });

      if (k === value["fontFamily"]) {
        fontWeight = _premium_fonts__WEBPACK_IMPORTED_MODULE_1__["default"][k].weight;
      }
    });

    if (PremiumBlocksSettings.localFonts && PremiumBlocksSettings.localFonts.length > 0) {
      PremiumBlocksSettings.localFonts.map(fontFamily => {
        return fonts.push({
          value: fontFamily.replace(/"/g, ""),
          label: fontFamily.replace(/"/g, ""),
          weight: [],
          custom: true
        });
      });
    }

    if (fontWeight === "") {
      fontWeight = fonts[0].weight;
    }

    const weights = ["Default", "100", "200", "300", "400", "500", "600", "700", "800", "900"];
    const renderVariations = (weights || []).map((weight, i) => {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
        key: i,
        className: `${weight == value["fontWeight"] ? "active" : ""}`,
        onClick: () => changeTypography("fontWeight", weight)
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
        className: "premium-variation-name"
      }, weight));
    });

    const changeTypography = (item, v) => {
      let initialState = { ...value
      };

      if (item === "fontFamily") {
        initialState["fontWeight"] = "Default";
      }

      initialState[item] = v;
      this.setState({
        value: initialState
      });
      onChange(initialState);
    };

    const linearFonts = fonts.filter(family => fuzzysearch(search.toLowerCase(), family["value"].toLowerCase()));
    const fontSize = value["fontSize"][device];
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-control-toggle premium-typography premium-blocks__base-control"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("header", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: " premium-control-title"
    }, __("Typography", "premium-blocks-for-gutenberg"))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-typography-wrapper"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-typohraphy-value"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-typography-title-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "premium-font",
      onClick: () => {
        this.setState({ ...this.state,
          isVisible: true,
          currentView: "fonts"
        });
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, value["fontFamily"])), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "premium-size",
      onClick: () => {
        this.setState({ ...this.state,
          isVisible: true,
          currentView: "options"
        });
      }
    }, fontSize, value === null || value === void 0 ? void 0 : (_value$fontSize = value.fontSize) === null || _value$fontSize === void 0 ? void 0 : _value$fontSize.unit[device]), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "premium-weight",
      onClick: () => {
        this.setState({ ...this.state,
          isVisible: true,
          currentView: "variations"
        });
      }
    }, value["fontWeight"]))), isVisible && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Popover, {
      className: "premium-popover-color",
      onClose: () => this.setState((state, props) => {
        return { ...state,
          isVisible: false,
          currentView: ""
        };
      }),
      onFocusOutside: () => this.setState({ ...this.state,
        isVisible: false,
        currentView: ""
      }),
      focusOnMount: true
    }, currentView === "fonts" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-option-modal "
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-typography-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      style: {
        top: "0px",
        right: "0px",
        left: `0px`
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
      className: "premium-typography-top premium-switch-panel premium-static"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: "premium-font"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      value: search,
      autoFocus: true,
      onKeyUp: e => {
        if (e.keyCode == 13) {
          if (linearFonts.length > 0) {
            changeTypography("fontFamily", linearFonts[0]);
            this.setState({
              search: ""
            });
          }
        }
      },
      onClick: e => e.stopPropagation(),
      onChange: _ref => {
        let {
          target: {
            value
          }
        } = _ref;
        return this.setState({
          search: value
        });
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
      width: "8",
      height: "8",
      viewBox: "0 0 15 15"
    }, currentView === "search" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      d: "M8.9,7.5l4.6-4.6c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L7.5,6.1L2.9,1.5c-0.4-0.4-1-0.4-1.4,0c-0.4,0.4-0.4,1,0,1.4l4.6,4.6l-4.6,4.6c-0.4,0.4-0.4,1,0,1.4c0.4,0.4,1,0.4,1.4,0l4.6-4.6l4.6,4.6c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L8.9,7.5z"
    }), currentView !== "search" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
      d: "M14.6,14.6c-0.6,0.6-1.4,0.6-2,0l-2.5-2.5c-1,0.7-2.2,1-3.5,1C2.9,13.1,0,10.2,0,6.6S2.9,0,6.6,0c3.6,0,6.6,2.9,6.6,6.6c0,1.3-0.4,2.5-1,3.5l2.5,2.5C15.1,13.1,15.1,14,14.6,14.6z M6.6,1.9C4,1.9,1.9,4,1.9,6.6s2.1,4.7,4.7,4.7c2.6,0,4.7-2.1,4.7-4.7C11.3,4,9.2,1.9,6.6,1.9z"
    })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_typography_fontList__WEBPACK_IMPORTED_MODULE_4__["default"], {
      linearFontsList: linearFonts,
      value: value["fontFamily"],
      onPickFamily: value => {
        (0,_typography_util__WEBPACK_IMPORTED_MODULE_5__.loadGoogleFont)(value);
        changeTypography("fontFamily", value);
      }
    })))), currentView === "options" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: " "
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-typography-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
      className: "premium-typography-options",
      style: {
        width: `100%`
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: "customize-control-premium-slider"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_RangeControl_responsive_range_control__WEBPACK_IMPORTED_MODULE_2__["default"], {
      label: __("Font Size", "premium-blocks-for-gutenberg"),
      value: value["fontSize"],
      onChange: value => changeTypography("fontSize", value),
      showUnit: true,
      units: ["px", "em"],
      unit: value["fontSize"]["unit"]
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: "customize-control-premium-slider"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_RangeControl_responsive_range_control__WEBPACK_IMPORTED_MODULE_2__["default"], {
      label: __("Line Height (PX)", "premium-blocks-for-gutenberg"),
      value: value["lineHeight"],
      onChange: value => changeTypography("lineHeight", value),
      showUnit: false,
      min: 0,
      max: 200
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: "customize-control-premium-slider"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_RangeControl_responsive_range_control__WEBPACK_IMPORTED_MODULE_2__["default"], {
      label: __("Letter Spacing (PX)", "premium-blocks-for-gutenberg"),
      value: value["letterSpacing"],
      onChange: value => changeTypography("letterSpacing", value),
      showUnit: false,
      step: 0.1,
      min: -5,
      max: 15
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: "customize-control-premium-slider"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SelectControl, {
      label: __("Style", "premium-blocks-for-gutenberg"),
      options: STYLE,
      value: value["fontStyle"],
      onChange: value => {
        changeTypography("fontStyle", value);
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      className: "premium-typography-variant"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
      className: "premium-text-transform"
    }, ["capitalize", "uppercase", "none"].map(variant => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      key: variant,
      onClick: () => {
        changeTypography("textTransform", value["textTransform"] === variant ? "" : variant);
      },
      className: `${value["textTransform"] === variant ? "active" : ""}${variant === "none" ? " dashicons dashicons-remove" : ""}`,
      "data-variant": variant
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("i", {
      className: "premium-tooltip-top"
    }, variant)))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
      className: "premium-text-decoration"
    }, ["line-through", "underline", "none"].map(variant => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      key: variant,
      onClick: () => {
        changeTypography("textDecoration", value["textDecoration"] === variant ? "" : variant);
      },
      className: `${value["textDecoration"] === variant ? "active" : ""}${variant === "none" ? " dashicons dashicons-remove" : ""}`,
      "data-variant": variant
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("i", {
      className: "premium-tooltip-top"
    }, variant)))))))), currentView === "variations" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-typography-option-modal "
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-typography-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
      className: "premium-typography-variations"
    }, renderVariations))))));
  }

}

/***/ }),

/***/ "../components/responsive.js":
/*!***********************************!*\
  !*** ../components/responsive.js ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);


const {
  useSelect,
  useDispatch
} = wp.data;

function Responsive(props) {
  const previewDevice = wp.customize && wp.customize.previewedDevice ? wp.customize.previewedDevice.get() : wp.data && wp.data.select && wp.data.select('core/edit-post') && wp.data.select('core/edit-post').__experimentalGetPreviewDeviceType ? wp.data.select('core/edit-post').__experimentalGetPreviewDeviceType() : 'Desktop';

  let customSetPreviewDeviceType = device => {
    props.onChange(device);
  };

  if (wp.data.select('core/edit-post')) {
    const theDevice = useSelect(select => {
      const {
        __experimentalGetPreviewDeviceType = null
      } = select('core/edit-post');
      return __experimentalGetPreviewDeviceType ? __experimentalGetPreviewDeviceType() : 'Desktop';
    }, []);

    if (theDevice !== props.deviceType) {
      props.onChange(theDevice);
    }

    const {
      __experimentalSetPreviewDeviceType = null
    } = useDispatch('core/edit-post');

    customSetPreviewDeviceType = device => {
      __experimentalSetPreviewDeviceType(device);

      props.onChange(device);
    };
  }

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    className: "premium-blocks-device"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "button",
    className: `premium-blocks-device-desktop ${previewDevice === "Desktop" ? "active" : ''}`,
    onClick: () => customSetPreviewDeviceType("Desktop")
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    class: "fa-desktop",
    "aria-hidden": "true",
    focusable: "false",
    "data-prefix": "far",
    "data-icon": "desktop",
    role: "img",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 576 512",
    "data-fa-i2svg": ""
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fill: "currentColor",
    d: "M528 0H48C21.5 0 0 21.5 0 48v288c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zm-6 336H54c-3.3 0-6-2.7-6-6V54c0-3.3 2.7-6 6-6h468c3.3 0 6 2.7 6 6v276c0 3.3-2.7 6-6 6zm-42 152c0 13.3-10.7 24-24 24H120c-13.3 0-24-10.7-24-24s10.7-24 24-24h98.7l18.6-55.8c1.6-4.9 6.2-8.2 11.4-8.2h78.7c5.2 0 9.8 3.3 11.4 8.2l18.6 55.8H456c13.3 0 24 10.7 24 24z"
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "button",
    className: `premium-blocks-device-tablet ${previewDevice === "Tablet" ? "active" : ''}`,
    onClick: () => customSetPreviewDeviceType("Tablet")
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    class: "fa-tablet-alt",
    "aria-hidden": "true",
    focusable: "false",
    "data-prefix": "fas",
    "data-icon": "tablet-alt",
    role: "img",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 448 512",
    "data-fa-i2svg": ""
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fill: "currentColor",
    d: "M400 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM224 480c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm176-108c0 6.6-5.4 12-12 12H60c-6.6 0-12-5.4-12-12V60c0-6.6 5.4-12 12-12h328c6.6 0 12 5.4 12 12v312z"
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "button",
    className: `premium-blocks-device-mobile ${previewDevice === "Mobile" ? "active" : ''}`,
    onClick: () => customSetPreviewDeviceType("Mobile")
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    class: "fa-mobile-alt",
    "aria-hidden": "true",
    focusable: "false",
    "data-prefix": "fas",
    "data-icon": "mobile-alt",
    role: "img",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 320 512",
    "data-fa-i2svg": ""
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    fill: "currentColor",
    d: "M272 0H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h224c26.5 0 48-21.5 48-48V48c0-26.5-21.5-48-48-48zM160 480c-17.7 0-32-14.3-32-32s14.3-32 32-32 32 14.3 32 32-14.3 32-32 32zm112-108c0 6.6-5.4 12-12 12H60c-6.6 0-12-5.4-12-12V60c0-6.6 5.4-12 12-12h200c6.6 0 12 5.4 12 12v312z"
  }))));
}

/* harmony default export */ __webpack_exports__["default"] = (Responsive);

/***/ }),

/***/ "../components/typography/fontList.js":
/*!********************************************!*\
  !*** ../components/typography/fontList.js ***!
  \********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "../../node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var webfontloader__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! webfontloader */ "../../node_modules/webfontloader/webfontloader.js");
/* harmony import */ var webfontloader__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(webfontloader__WEBPACK_IMPORTED_MODULE_3__);

const {
  useEffect,
  useRef,
  useState
} = wp.element;



const {
  __
} = wp.i18n;
let loadedFonts = [];

const loadGoogleFonts = font_families => {
  if (font_families.length === 0) return;
  loadedFonts = [...loadedFonts, ...font_families.map(_ref => {
    let {
      family
    } = _ref;
    return family;
  })];

  if (font_families.length > 0) {
    webfontloader__WEBPACK_IMPORTED_MODULE_3___default().load({ ...(font_families.length > 0 ? {
        google: {
          families: font_families
        }
      } : {}),
      classes: false,
      text: "abcdefghijklmnopqrstuvwxyz"
    });
  }
};

const SingleFont = _ref2 => {
  let {
    family,
    onPickFamily,
    value
  } = _ref2;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    onClick: () => onPickFamily(family.value),
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()("premium-typography-single-font", {
      active: family.value === value
    }),
    key: family[0]
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "premium-font-name"
  }, family.label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    style: {
      fontFamily: family.value
    },
    className: "premium-font-preview"
  }, "Simply dummy text"));
};

const FontsList = _ref3 => {
  let {
    value,
    onPickFamily,
    linearFontsList
  } = _ref3;
  const listRef = useRef(null);
  const [scrollTimer, setScrollTimer] = useState(null);
  useEffect(() => {
    if (value.family && listRef.current) {
      listRef.current.querySelector(".active").scrollIntoView();
    }
  }, []);
  let systemFonts = linearFontsList.filter(family => family.google === false);
  let googleFonts = linearFontsList.filter(family => family.google === true);
  let customFonts = linearFontsList.filter(family => family.custom === true);

  const onScroll = () => {
    scrollTimer && clearTimeout(scrollTimer);
    setScrollTimer(setTimeout(() => {
      if (!listRef.current) {
        return;
      }

      let overscanStartIndex = Math.ceil(listRef.current.scrollTop / 85);
      const perPage = 25;
      const startingPage = Math.ceil((overscanStartIndex + 1) / perPage);
      const pageItems = [...Array(perPage)].map((_, i) => (startingPage - 1) * perPage + i).map(index => {
        var _googleFonts$index;

        return googleFonts === null || googleFonts === void 0 ? void 0 : (_googleFonts$index = googleFonts[index]) === null || _googleFonts$index === void 0 ? void 0 : _googleFonts$index.value;
      }).filter(s => !!s);
      loadGoogleFonts(pageItems);
    }, 10));
  };

  useEffect(() => {
    onScroll();
  }, [linearFontsList]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    ref: listRef,
    className: "premium-typography-fonts",
    onScroll: onScroll,
    style: {
      width: `100%`
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", null, systemFonts.map(family => SingleFont({
    family,
    onPickFamily,
    value
  }))), customFonts.length > 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_2__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-fonts-source`
  }, __("Custom  Fonts", "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", null, customFonts.map(family => SingleFont({
    family,
    onPickFamily,
    value
  })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-fonts-source`
  }, __("Google  Fonts", "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", null, googleFonts.map(family => SingleFont({
    family,
    onPickFamily,
    value
  })))));
};

/* harmony default export */ __webpack_exports__["default"] = (FontsList);

/***/ }),

/***/ "../components/typography/util.js":
/*!****************************************!*\
  !*** ../components/typography/util.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "createLinkTagWithGoogleFont": function() { return /* binding */ createLinkTagWithGoogleFont; },
/* harmony export */   "getFontFamily": function() { return /* binding */ getFontFamily; },
/* harmony export */   "getGoogleFontURL": function() { return /* binding */ getGoogleFontURL; },
/* harmony export */   "isGoogleFontEnqueued": function() { return /* binding */ isGoogleFontEnqueued; },
/* harmony export */   "isWebFont": function() { return /* binding */ isWebFont; },
/* harmony export */   "loadGoogleFont": function() { return /* binding */ loadGoogleFont; }
/* harmony export */ });
/**
 * External dependencies
 */
// @from https://github.com/elementor/elementor/blob/45eaa6704fe1ad18f6190c8e95952b38b8a38dc7/assets/dev/js/editor/utils/helpers.js#L23
const getGoogleFontURL = fontName => {
  const family = fontName.replace(/ /g, '+');
  return `https://fonts.googleapis.com/css?family=${family}:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic`;
};
const isWebFont = fontName => fontName && !(fontName !== null && fontName !== void 0 && fontName.match(/^(sans[-+]serif|serif|monospace|serif-alt)$/i));
/**
 * Returns the current block editor head
 * element.
 *
 * @return {HTMLDocument} the head document
 */

const getDocumentHead = () => {
  const hasEditingContent = !!document.querySelector('iframe[name="editor-canvas"]');

  if (hasEditingContent) {
    return document.querySelector('iframe[name="editor-canvas"]').contentWindow.document.querySelector('head');
  }

  return document.querySelector('head');
};
/**
 * Load the stylesheet of a Google Font.
 *
 * @param {string} fontName The name of the font
 */


const loadGoogleFont = fontName => {
  const _loadGoogleFont = head => {
    if (head && isWebFont(fontName)) {
      if (isGoogleFontEnqueued(fontName, head)) {
        return;
      }

      const link = createLinkTagWithGoogleFont(fontName);
      head.appendChild(link);
    }
  };

  let index = 0; // There are cases when the content area has delayed loading (the content
  // area is in an iframe in FSE), so keep trying to load the font a few times.

  const interval = setInterval(() => {
    index++;

    if (index === 9) {
      clearInterval(interval);
    }

    const headElement = getDocumentHead();

    _loadGoogleFont(headElement);

    if (headElement !== document.querySelector('head')) {
      _loadGoogleFont(document.querySelector('head'));
    }
  }, 200);
};
const createLinkTagWithGoogleFont = function () {
  let fontName = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  const link = document.createElement('link');
  link.classList.add('ugb-google-fonts');
  link.setAttribute('data-font-name', fontName);
  link.setAttribute('href', getGoogleFontURL(fontName));
  link.setAttribute('rel', 'stylesheet');
  link.setAttribute('type', 'text/css');
  return link;
};
const isGoogleFontEnqueued = function (fontName) {
  let head = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : document.querySelector('head');
  return head.querySelector(`[data-font-name="${fontName}"]`);
};
const getFontFamily = fontName => {
  // Google Font.
  if (isWebFont(fontName)) {
    loadGoogleFont(fontName);
    return `"${fontName}", Sans-serif`;
  } // System fonts.


  if (fontName.match(/^serif$/i)) {
    return '"Palatino Linotype", Palatino, Palladio, "URW Palladio L", "Book Antiqua", Baskerville, "Bookman Old Style", "Bitstream Charter", "Nimbus Roman No9 L", Garamond, "Apple Garamond", "ITC Garamond Narrow", "New Century Schoolbook", "Century Schoolbook", "Century Schoolbook L", Georgia, serif';
  } else if (fontName.match(/^serif-alt$/i)) {
    return 'Constantia, Lucida Bright, Lucidabright, "Lucida Serif", Lucida, "DejaVu Serif", "Bitstream Vera Serif", "Liberation Serif", Georgia, serif';
  } else if (fontName.match(/^monospace$/i)) {
    return 'SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace';
  }

  return '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
};

/***/ }),

/***/ "./src/components/AdvancedColorControl.js":
/*!************************************************!*\
  !*** ./src/components/AdvancedColorControl.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/icon/index.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/close-small.js");

const {
  Component
} = wp.element;
const {
  Button,
  Popover,
  ColorIndicator,
  ColorPicker
} = wp.components;

const {
  __
} = wp.i18n;

class AdvancedColorControl extends Component {
  constructor() {
    super(...arguments);
    this.state = {
      isVisible: false,
      colors: [],
      currentColor: "",
      defaultColor: ""
    };
  }

  componentDidMount() {
    if ("transparent" === this.props.colorDefault) {
      this.setState({
        currentColor: undefined === this.props.colorValue || "" === this.props.colorValue || "transparent" === this.props.colorValue ? "" : this.props.colorValue
      });
      this.setState({
        defaultColor: ""
      });
    } else {
      this.setState({
        currentColor: undefined === this.props.colorValue || "" === this.props.colorValue ? this.props.colorDefault : this.props.colorValue
      });
      this.setState({
        defaultColor: this.props.colorDefault
      });
    }
  }

  render() {
    const {
      skipModal,
      isDefault,
      onRemove,
      onChangeName,
      name,
      slug,
      resetPalette,
      handleColorReset
    } = this.props;

    const toggleVisible = () => {
      if (skipModal) {
        return;
      }

      if ("transparent" === this.props.colorDefault) {
        this.setState({
          currentColor: undefined === this.props.colorValue || "" === this.props.colorValue || "transparent" === this.props.colorValue ? "" : this.props.colorValue
        });
      } else {
        this.setState({
          currentColor: undefined === this.props.colorValue || "" === this.props.colorValue ? this.props.colorDefault : this.props.colorValue
        });
      }

      this.setState({
        isVisible: true
      });
    };

    const toggleClose = () => {
      if (skipModal) {
        return;
      }

      if (this.state.isVisible === true) {
        this.setState({
          isVisible: false
        });
      }
    };

    const isNew = wp.components.GradientPicker;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: `premium-global-color-Wrapper`
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-global-advanced-color-container"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-global-color-wrapper"
    }, !skipModal && this.state.isVisible && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Popover, {
      position: "bottom left",
      className: "premium-global-popover-color",
      onClose: toggleClose
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: isNew ? "premium-global-gutenberg-color-picker-new" : "premium-global-gutenberg-color-picker"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ColorPicker, {
      color: undefined === this.props.colorValue || "" === this.props.colorValue || "transparent" === this.props.colorValue ? this.state.defaultColor : this.props.colorValue,
      onChangeComplete: color => {
        this.setState({
          currentColor: color.hex
        });

        if (color.rgb) {
          this.props.onColorChange(color.rgb.a != 1 ? "rgba(" + color.rgb.r + "," + color.rgb.g + "," + color.rgb.b + "," + color.rgb.a + ")" : color.hex);
        }
      }
    })), !isDefault && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "premium-color-name-value"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", null, __('Name', 'premium-blocks-for-gutenberg')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      onChange: _ref => {
        let {
          target: {
            value: name
          }
        } = _ref;
        onChangeName(name);
      },
      value: name,
      type: "text"
    })), resetPalette && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: `premium-reset-palette__Wrapper`
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
      type: "button",
      onClick: () => {
        handleColorReset();
      },
      className: " premium-btn-reset__color is-secondary is-small"
    }, __("Reset", "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
      className: `premium-reset__description`
    }, __(`This will reset the current color to the default one.`, "premium-blocks-for-gutenberg")))), this.state.isVisible && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      className: `premium-global-color-picker-single ${"" === this.props.colorDefault ? "premium-global-has-alpha" : "premium-global-no-alpha"}`,
      onClick: toggleClose,
      "data-tip": name,
      "data-for": "pbg-color-preview"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ColorIndicator, {
      className: "premium-global-advanced-color-indicate",
      colorValue: "transparent" === this.props.colorValue || undefined === this.props.colorValue || "" === this.props.colorValue ? this.props.colorDefault : this.props.colorValue
    })), !this.state.isVisible && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      className: `premium-global-color-picker-single ${"" === this.props.colorDefault ? "premium-global-has-alpha" : "premium-global-no-alpha"}`,
      onClick: toggleVisible,
      "data-tip": name,
      "data-for": "pbg-color-preview"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ColorIndicator, {
      className: "premium-global-advanced-color-indicate",
      colorValue: "transparent" === this.props.colorValue || undefined === this.props.colorValue || "" === this.props.colorValue ? this.props.colorDefault : this.props.colorValue
    }))), !isDefault && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      className: "premium-remove-color",
      onClick: () => onRemove(slug)
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_icons__WEBPACK_IMPORTED_MODULE_1__["default"], {
      icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_2__["default"]
    }))));
  }

}

/* harmony default export */ __webpack_exports__["default"] = (AdvancedColorControl);

/***/ }),

/***/ "./src/components/AdvancedRadio.js":
/*!*****************************************!*\
  !*** ./src/components/AdvancedRadio.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_tooltip__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-tooltip */ "./node_modules/react-tooltip/dist/index.es.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);





const AdvancedRadio = _ref => {
  let {
    value,
    onChange,
    label,
    choices
  } = _ref;
  let defaultVal = '';
  value = value ? value : defaultVal;
  const {
    first,
    second
  } = choices;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-blocks__base-control pbg-advanced-radio-control`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(react_tooltip__WEBPACK_IMPORTED_MODULE_2__["default"], {
    place: "left",
    effect: "solid",
    id: "pbg-toggle",
    getContent: dataTip => {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        style: {
          width: '200px'
        }
      }, dataTip);
    }
  }), label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "customize-control-title premium-control-title",
    style: {
      fontStyle: 'italic'
    }
  }, label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ButtonGroup, {
    className: "premium-radio-container-control"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
    isTertiary: true,
    className: classnames__WEBPACK_IMPORTED_MODULE_3___default()(`pbg-advanced-radio-button first`, {
      'active-radio': first.value === value
    }),
    onClick: () => {
      onChange(first.value);
    },
    "data-for": "pbg-toggle",
    "data-tip": first.help
  }, first.label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
    isTertiary: true,
    className: classnames__WEBPACK_IMPORTED_MODULE_3___default()(`pbg-advanced-radio-button second`, {
      'active-radio': second.value === value
    }),
    onClick: () => {
      onChange(second.value);
    },
    "data-for": "pbg-toggle",
    "data-tip": second.help
  }, second.label)));
};

/* harmony default export */ __webpack_exports__["default"] = (AdvancedRadio);

/***/ }),

/***/ "./src/components/ThemeColorPalette.js":
/*!*********************************************!*\
  !*** ./src/components/ThemeColorPalette.js ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../store/settings-store */ "./src/store/settings-store.js");
/* harmony import */ var _color_palettes_PalettePreview__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./color-palettes/PalettePreview */ "./src/components/color-palettes/PalettePreview.js");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);






const ThemeColorPalette = () => {
  const {
    setCustomColors,
    customColors
  } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_store_settings_store__WEBPACK_IMPORTED_MODULE_1__["default"]);

  const _colors = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => select('core/block-editor').getSettings().colors) || [];

  const themeColors = _colors.map(color => {
    return {
      name: color.name,
      color: color.color,
      slug: color.slug,
      skipModal: true,
      default: true
    };
  });

  const handleChangeColor = (value, id) => {
    let newColors = [...customColors].map(color => color.slug === id ? { ...color,
      color: value
    } : color);
    setCustomColors(newColors);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-palettes-preview`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_color_palettes_PalettePreview__WEBPACK_IMPORTED_MODULE_2__["default"], {
    onClick: () => {},
    colors: themeColors,
    customColors: customColors,
    onChange: (v, id) => handleChangeColor(v, id),
    skipModal: false,
    handleClickReset: id => handleChangeColor('', id)
  }));
};

/* harmony default export */ __webpack_exports__["default"] = (ThemeColorPalette);

/***/ }),

/***/ "./src/components/color-palette.js":
/*!*****************************************!*\
  !*** ./src/components/color-palette.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _color_palettes_PalettePreview__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./color-palettes/PalettePreview */ "./src/components/color-palettes/PalettePreview.js");
/* harmony import */ var _color_palettes_AddPaletteContainer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./color-palettes/AddPaletteContainer */ "./src/components/color-palettes/AddPaletteContainer.js");
/* harmony import */ var _color_palettes_ColorPalettesModal__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./color-palettes/ColorPalettesModal */ "./src/components/color-palettes/ColorPalettesModal.js");
/* harmony import */ var _common_popover_component__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./common/popover-component */ "./src/components/common/popover-component.js");
/* harmony import */ var _common_outside_component__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./common/outside-component */ "./src/components/common/outside-component.js");
/* harmony import */ var _react_spring_web__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @react-spring/web */ "./node_modules/@react-spring/web/dist/react-spring-web.esm.js");
/* harmony import */ var bezier_easing__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! bezier-easing */ "../../node_modules/bezier-easing/src/index.js");
/* harmony import */ var bezier_easing__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(bezier_easing__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _helpers_defaultPalettes__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../helpers/defaultPalettes */ "./src/helpers/defaultPalettes.js");
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../store/settings-store */ "./src/store/settings-store.js");









const {
  __
} = wp.i18n;





const ColorPalettes = _ref => {
  let {
    value,
    onChange,
    label
  } = _ref;
  const [state, setState] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(value);
  const colorPalettesWrapper = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useRef)();
  const buttonRef = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useRef)();
  const defaultValues = [..._helpers_defaultPalettes__WEBPACK_IMPORTED_MODULE_10__["default"], ...pbgGlobalSettings.palettes];
  const [{
    isOpen,
    isTransitioning
  }, setModalState] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)({
    isOpen: false,
    isTransitioning: false
  });
  const {
    globalColors,
    setGlobalColors,
    customColors,
    setCustomColors
  } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_store_settings_store__WEBPACK_IMPORTED_MODULE_11__["default"]);
  const [currentView, setCurrentView] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)("");
  const [openModal, setOpenModal] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [delPalette, setDelPalette] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)({});
  const {
    styles,
    popoverProps
  } = (0,_common_popover_component__WEBPACK_IMPORTED_MODULE_4__["default"])({
    ref: currentView === "add" ? buttonRef : colorPalettesWrapper,
    defaultHeight: 430,
    shouldCalculate: isTransitioning || isOpen
  });
  const titles = [__(`Buttons background color \n& Links hover color`, "premium-blocks-for-gutenberg"), __("Headings & Links color", "premium-blocks-for-gutenberg"), __("Body text", "premium-blocks-for-gutenberg"), __("Borders color", "premium-blocks-for-gutenberg"), __("Body background, a tint for Input fields", "premium-blocks-for-gutenberg"), __("Footer text color", "premium-blocks-for-gutenberg"), __("Footer background color", "premium-blocks-for-gutenberg")];
  const newColorsObj = globalColors === null || globalColors === void 0 ? void 0 : globalColors.colors.map((color, index) => {
    return {
      name: titles[index],
      slug: color.slug,
      color: color.color,
      default: true
    };
  });
  const globalPalette = { ...globalColors,
    colors: newColorsObj
  };

  const handleChangePalette = active => {
    const newGlobalColors = { ...globalColors,
      colors: active.colors,
      current_palette: active.id
    };
    setGlobalColors(newGlobalColors);
  };

  const handleChangeCustomColor = (value, id) => {
    let newColors = [...customColors].map(color => color.slug === id ? { ...color,
      color: value
    } : color);
    setCustomColors(newColors);
  };

  const handleChangeComplete = (color, index) => {
    if (index.includes('custom')) {
      handleChangeCustomColor(color, index);
      return;
    }

    let newColors = [...globalColors.colors];
    newColors = newColors.map(colorObj => colorObj.slug === index ? { ...colorObj,
      color: color
    } : colorObj);
    const newGlobalColors = { ...globalColors,
      colors: newColors
    };
    setGlobalColors(newGlobalColors);
  };

  const handleAddPalette = data => {
    let newPalettes = [...state];
    let newPalett = {
      id: `custom-palette-${newPalettes.length + 1}`,
      colors: [...globalColors.colors],
      type: "custom",
      skin: data.type,
      name: data.name
    };
    newPalettes.unshift(newPalett);
    setState(newPalettes);
    onChange(newPalettes);
    setGlobalColors({ ...globalColors,
      current_palette: `custom-palette-${newPalettes.length}`
    });
    setModalState(() => ({
      isOpen: null,
      isTransitioning: false
    }));
  };

  const handleDeletePalette = id => {
    setOpenModal(true);
    const deletePalette = value.find(palette => {
      return palette.id === id;
    });
    setDelPalette({ ...deletePalette
    });
  };

  const ConfirmDelete = () => {
    let newPalettes = value.filter(palette => {
      return palette.id !== delPalette.id;
    });
    setState(newPalettes);
    onChange(newPalettes);
    setOpenModal(false);
  };

  const handleResetColor = id => {
    let currentPalette = defaultValues.find(palette => palette.id === globalColors.current_palette);
    const resetColor = currentPalette['colors'].find(color => color.slug === id) || {};
    handleChangeComplete((resetColor === null || resetColor === void 0 ? void 0 : resetColor.color) || '', id);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("header", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "customize-control-title premium-control-title"
  }, label)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_common_outside_component__WEBPACK_IMPORTED_MODULE_5__["default"], {
    disabled: !isOpen,
    useCapture: false,
    className: "premium-palettes-outside",
    additionalRefs: [popoverProps.ref],
    onOutsideClick: e => {
      if (e.target.closest(".premium-global-color-picker-modal") || e.target.classList.contains("premium-global-color-picker-modal") || e.target.closest(".premium-option-modal")) {
        return;
      }

      setModalState(() => ({
        isOpen: null,
        isTransitioning: null
      }));
      setCurrentView(" ");
    },
    wrapperProps: {
      ref: colorPalettesWrapper
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-palettes-preview`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_color_palettes_PalettePreview__WEBPACK_IMPORTED_MODULE_1__["default"], {
    onClick: () => {
      setModalState(() => ({
        isOpen: null,
        isTransitioning: null
      }));
    },
    colors: globalPalette.colors,
    customColors: customColors,
    onChange: (v, id) => handleChangeComplete(v, id),
    handleClickReset: val => {
      handleResetColor(val);
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-palette-toggle-modal`,
    onClick: e => {
      e.preventDefault();
      setModalState(() => ({
        isOpen: !isOpen,
        isTransitioning: null
      }));
      setCurrentView("modal");
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("header", null, __(`Select Another Palette`, "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(`premium-button-open-palette`, {
      active: currentView === "modal"
    })
  }))), isOpen && currentView === "modal" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_color_palettes_ColorPalettesModal__WEBPACK_IMPORTED_MODULE_3__["default"], {
    wrapperProps: {
      style: { ...styles
      }
    },
    onChange: val => {
      setModalState(() => ({
        isOpen: false,
        isTransitioning: null
      }));
      handleChangePalette(val);
      setCurrentView("");
    },
    value: [..._helpers_defaultPalettes__WEBPACK_IMPORTED_MODULE_10__["default"], ...state],
    option: [..._helpers_defaultPalettes__WEBPACK_IMPORTED_MODULE_10__["default"], ...state],
    handleDeletePalette: id => handleDeletePalette(id)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_common_outside_component__WEBPACK_IMPORTED_MODULE_5__["default"], {
    disabled: !isTransitioning,
    useCapture: false,
    className: "premium-button-palettes-outside",
    additionalRefs: [popoverProps.ref],
    onOutsideClick: e => {
      if (e.target.closest(".premium-global-color-picker-modal") || e.target.classList.contains("premium-global-color-picker-modal") || e.target.closest(".premium-option-modal")) {
        return;
      }

      setModalState(() => ({
        isOpen: null,
        isTransitioning: null
      }));
      setCurrentView(" ");
    },
    wrapperProps: {
      ref: buttonRef,
      onClick: e => {
        e.preventDefault();

        if (e.target.closest(".premium-global-color-picker-modal") || e.target.classList.contains("premium-global-color-picker-modal")) {
          return;
        }

        if (!state.palettes) {
          return;
        }

        setModalState(() => ({
          isOpen: null,
          isTransitioning: true
        }));
      }
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: `premium-button-palette`,
    onClick: e => {
      e.stopPropagation();
      e.preventDefault();
      setCurrentView("add");
      setModalState(() => ({
        isOpen: null,
        isTransitioning: true
      }));
    }
  }, __('Save New Palette', "premium-blocks-for-gutenberg"))), isTransitioning && currentView === "add" && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createPortal)((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_react_spring_web__WEBPACK_IMPORTED_MODULE_6__.Transition, {
    items: isTransitioning,
    config: {
      duration: 100,
      easing: bezier_easing__WEBPACK_IMPORTED_MODULE_7___default()(0.25, 0.1, 0.25, 1.0)
    },
    from: isTransitioning ? {
      transform: "scale3d(0.95, 0.95, 1)",
      opacity: 0
    } : {
      opacity: 1
    },
    enter: isTransitioning ? {
      transform: "scale3d(1, 1, 1)",
      opacity: 1
    } : {
      opacity: 1
    },
    leave: !isTransitioning ? {
      transform: "scale3d(0.95, 0.95, 1)",
      opacity: 0
    } : {
      opacity: 1
    }
  }, (style, item) => {
    if (!item) {
      return null;
    } else return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_color_palettes_AddPaletteContainer__WEBPACK_IMPORTED_MODULE_2__["default"], {
      wrapperProps: {
        style: { ...style,
          ...styles
        },
        ...popoverProps
      },
      onChange: (val, id) => {
        handleChangeComplete(val, id);
      },
      value: state,
      option: state,
      handleAddPalette: handleAddPalette,
      handleCloseModal: () => {
        setCurrentView("");
      }
    });
  }), document.body), openModal && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_8__.Modal, {
    title: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: `premium-popup-modal__header`
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("i", {
      className: "dashicons dashicons-bell"
    }), " ", __("Warning", "premium-blocks-for-gutenberg")),
    className: `premium-global-color-palette-confrim__delete`,
    isDismissible: true,
    onRequestClose: () => {
      setOpenModal(false);
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: __(`premium-palette-popup-content`)
  }, __(`You are about to delete `, "premium-blocks-for-gutenberg"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("q", {
    className: `premium-deleted-palette__name`
  }, "\"", delPalette.name, "\""), __(`. This palette cannot be restored, are you sure you want to delete it?`, "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: __(`premium-paltette-popup-action`)
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "button",
    class: "button button-primary save has-next-sibling",
    onClick: () => {
      setOpenModal(false);
    }
  }, __("No", "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "button",
    class: "components-button  premium-button__delete__palette",
    onClick: e => {
      e.preventDefault();
      ConfirmDelete();
    }
  }, __('Yes', "premium-blocks-for-gutenberg")))));
};

/* harmony default export */ __webpack_exports__["default"] = (ColorPalettes);

/***/ }),

/***/ "./src/components/color-palettes/AddPaletteContainer.js":
/*!**************************************************************!*\
  !*** ./src/components/color-palettes/AddPaletteContainer.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ AddPaletteContainer; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _react_spring_web__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @react-spring/web */ "./node_modules/@react-spring/web/dist/react-spring-web.esm.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_4__);





const {
  __
} = wp.i18n;
function AddPaletteContainer(_ref) {
  let {
    value,
    handleCloseModal,
    wrapperProps = {},
    handleAddPalette
  } = _ref;
  const [data, setPaletteData] = (0,react__WEBPACK_IMPORTED_MODULE_2__.useState)({
    name: "",
    type: "light"
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_react_spring_web__WEBPACK_IMPORTED_MODULE_3__.animated.div, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    className: "premium-option-modal  premium-add-palettes-modal"
  }, wrapperProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium-add-palette-container`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("button", {
    className: `button-close-modal`,
    onClick: e => {
      e.preventDefault();
      handleCloseModal();
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("svg", {
    width: "24",
    height: "24",
    xmlns: "http://www.w3.org/2000/svg",
    viewBox: "0 0 24 24",
    role: "img",
    "aria-hidden": "true",
    focusable: "false"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("path", {
    d: "M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 13.061z"
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium-palette-info`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium-palette-name`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("p", {
    className: `premium-palette-type-label`
  }, __("palette name", "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("input", {
    type: "text",
    className: `premium-add-palette-title`,
    placeholder: __("name your palette", "premium-blocks-for-gutenberg"),
    onChange: e => setPaletteData({ ...data,
      name: e.target.value
    })
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium-Palette-type-container`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("p", {
    className: `premium-palette-type-label`
  }, __("palette type", "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium-Palette-type-wrapper`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("input", {
    type: "radio",
    checked: data.type === "light" ? true : false,
    name: "type",
    onChange: () => setPaletteData({ ...data,
      type: "light"
    })
  }), __('Light', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", null, " ", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("input", {
    type: "radio",
    checked: data.type === "dark" ? true : false,
    name: "type",
    onChange: () => setPaletteData({ ...data,
      type: "dark"
    })
  }), __('Dark', "premium-blocks-for-gutenberg")))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("button", {
    className: " premium-save-palette",
    disabled: data.name === "",
    onClick: e => {
      e.preventDefault();
      e.stopPropagation();
      handleAddPalette(data);
    }
  }, __('Save Palette', "premium-blocks-for-gutenberg")))));
}

/***/ }),

/***/ "./src/components/color-palettes/ColorPalettesModal.js":
/*!*************************************************************!*\
  !*** ./src/components/color-palettes/ColorPalettesModal.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _react_spring_web__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @react-spring/web */ "./node_modules/@react-spring/web/dist/react-spring-web.esm.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _PalettePreview__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./PalettePreview */ "./src/components/color-palettes/PalettePreview.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../store/settings-store */ "./src/store/settings-store.js");


const {
  __,
  sprintf
} = wp.i18n;







const ColorPalettesModal = _ref => {
  let {
    value,
    onChange,
    wrapperProps = {},
    handleDeletePalette
  } = _ref;
  const {
    globalColors
  } = (0,react__WEBPACK_IMPORTED_MODULE_3__.useContext)(_store_settings_store__WEBPACK_IMPORTED_MODULE_6__["default"]);
  const [typeOfPalette, setTypeOfPalette] = (0,react__WEBPACK_IMPORTED_MODULE_3__.useState)("light");
  const pbgPaletteColors = value.filter(palette => palette.skin === typeOfPalette && palette.type === "system");
  const customPaletteColors = value.filter(palette => {
    return palette.skin === typeOfPalette && palette.type === "custom";
  });

  const initPalette = palette => {
    const newPaletteColors = palette.colors.map(color => {
      return {
        name: color.name,
        slug: color.slug,
        color: color.color,
        default: true,
        skipModal: true
      };
    });
    return { ...palette,
      colors: newPaletteColors
    };
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_react_spring_web__WEBPACK_IMPORTED_MODULE_2__.animated.div, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    className: "premium-option-modal premium-palettes-modal"
  }, wrapperProps), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium-type-control`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_5___default()({
      active: typeOfPalette === "light"
    }),
    onClick: () => {
      setTypeOfPalette("light");
    }
  }, "Light"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_5___default()({
      active: typeOfPalette === "dark"
    }),
    onClick: () => {
      setTypeOfPalette("dark");
    }
  }, " Dark")), customPaletteColors.length > 0 && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium_label_type__palette`
  }, __(`my palettes`)), customPaletteColors.map((palette, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(react__WEBPACK_IMPORTED_MODULE_3__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_PalettePreview__WEBPACK_IMPORTED_MODULE_4__["default"], {
    colors: initPalette(palette).colors,
    className: classnames__WEBPACK_IMPORTED_MODULE_5___default()(`premium-custom-palette__container`, {
      'premium-active': palette.id === globalColors.current_palette
    }),
    renderBefore: () => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(react__WEBPACK_IMPORTED_MODULE_3__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("label", null, palette.name ? palette.name : sprintf(__('Palette #%s', "premium-blocks-for-gutenberg"), index + 1)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("button", {
      className: `premium-delete-palette`,
      onClick: e => {
        e.preventDefault();
        e.stopPropagation();
        handleDeletePalette(palette.id);
      }
    })),
    onClick: () => {
      onChange(palette);
    },
    canAdd: false
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("div", {
    className: `premium_label_type__palette`
  }, __(`Default palettes`, "premium-blocks-for-gutenberg")), pbgPaletteColors.map((palette, index) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(react__WEBPACK_IMPORTED_MODULE_3__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_PalettePreview__WEBPACK_IMPORTED_MODULE_4__["default"], {
    colors: initPalette(palette).colors,
    className: palette.id === globalColors.current_palette ? 'premium-active' : '',
    renderBefore: () => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("label", null, palette.name ? palette.name : sprintf(__('Palette #%s', "premium-blocks-for-gutenberg"), index + 1)),
    onClick: () => {
      onChange(palette);
    },
    canAdd: false
  }))));
};

/* harmony default export */ __webpack_exports__["default"] = (ColorPalettesModal);

/***/ }),

/***/ "./src/components/color-palettes/PalettePreview.js":
/*!*********************************************************!*\
  !*** ./src/components/color-palettes/PalettePreview.js ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/icon/index.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/create.js");
/* harmony import */ var react_tooltip__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-tooltip */ "./node_modules/react-tooltip/dist/index.es.js");
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../store/settings-store */ "./src/store/settings-store.js");
/* harmony import */ var _AdvancedColorControl__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../AdvancedColorControl */ "./src/components/AdvancedColorControl.js");

const {
  __
} = wp.i18n;







const PalettePreview = _ref => {
  let {
    renderBefore = () => null,
    colors,
    onChange,
    onClick,
    className,
    handleClickReset,
    canAdd = true
  } = _ref;

  const handleChangeColor = (color, optionId) => {
    let newColor;

    if (typeof color === "string") {
      newColor = color;
    } else if (undefined !== color.rgb && undefined !== color.rgb.a && 1 !== color.rgb.a) {
      newColor = `rgba(${color.rgb.r},${color.rgb.g},${color.rgb.b},${color.rgb.a})`;
    } else {
      newColor = color.hex;
    }

    onChange(newColor, optionId);
  };

  const {
    customColors,
    setCustomColors
  } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_store_settings_store__WEBPACK_IMPORTED_MODULE_3__["default"]);

  const handleRemoveColor = id => {
    let newValue = [...customColors];
    newValue = newValue.filter(color => color.slug !== id);
    setCustomColors(newValue);
  };

  const handleAddNewColor = () => {
    const lastColorIndex = customColors.length;
    const colorId = `custom-color${lastColorIndex + Math.floor(Math.random() * 100)}`;
    const colorTitle = `${__('Custom Color ')}${lastColorIndex + 1}`;
    let newColors = [...customColors];
    newColors.push({
      name: colorTitle,
      color: '',
      slug: colorId
    });
    setCustomColors(newColors);
  };

  const handleColorChangeName = (name, id) => {
    let newValue = [...customColors].map(color => color.slug === id ? { ...color,
      name: name
    } : color);
    setCustomColors(newValue);
  };

  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    react_tooltip__WEBPACK_IMPORTED_MODULE_2__["default"].rebuild();
  }, [colors]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()("premium-single-palette", className),
    onClick: e => {
      if (e.target.closest(".premium-global-color-picker-modal") || e.target.classList.contains("premium-global-color-picker-modal")) {
        return;
      }

      onClick();
    }
  }, renderBefore(), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: `premium-global-color-palette-container`
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(react_tooltip__WEBPACK_IMPORTED_MODULE_2__["default"], {
    place: "top",
    effect: "solid",
    id: "pbg-color-preview"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-palette-colors"
  }, colors.map(picker => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_AdvancedColorControl__WEBPACK_IMPORTED_MODULE_4__["default"], {
    colorValue: picker.color,
    className: "premium-global-color-palette-modal",
    isDefault: picker.default,
    colorDefault: "",
    onColorChange: color => handleChangeColor(color, picker[`slug`]),
    onRemove: () => handleRemoveColor(picker[`slug`]),
    onChangeName: false,
    name: picker.name,
    slug: picker.slug,
    skipModal: picker.skipModal,
    resetPalette: true,
    handleColorReset: () => handleClickReset(picker[`slug`])
  }))), canAdd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, __('Custom Color', "premium-blocks-for-gutenberg")), canAdd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-custom-colors"
  }, customColors.map(picker => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_AdvancedColorControl__WEBPACK_IMPORTED_MODULE_4__["default"], {
    colorValue: picker.color,
    className: "premium-global-color-palette-modal",
    isDefault: picker.default,
    colorDefault: "",
    onColorChange: color => handleChangeColor(color, picker[`slug`]),
    onRemove: () => handleRemoveColor(picker[`slug`]),
    onChangeName: v => handleColorChangeName(v, picker[`slug`]),
    name: picker.name,
    slug: picker.slug,
    skipModal: picker.skipModal,
    resetPalette: true,
    handleColorReset: () => handleClickReset(picker[`slug`])
  })), canAdd && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-add-new-color",
    onClick: () => handleAddNewColor(),
    "data-tip": __('Add Color', "premium-blocks-for-gutenberg")
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_icons__WEBPACK_IMPORTED_MODULE_5__["default"], {
    icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_6__["default"]
  })))));
};

/* harmony default export */ __webpack_exports__["default"] = (PalettePreview);

/***/ }),

/***/ "./src/components/common/outside-component.js":
/*!****************************************************!*\
  !*** ./src/components/common/outside-component.js ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ OutsideComponent; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);




const DISPLAY = {
  BLOCK: 'block',
  FLEX: 'flex',
  INLINE_BLOCK: 'inline-block'
};
const defaultProps = {
  disabled: false,
  // `useCapture` is set to true by default so that a `stopPropagation` in the
  // children will not prevent all outside click handlers from firing - maja
  useCapture: true,
  display: DISPLAY.BLOCK
};

const updateRef = (ref, instance) => {
  if (typeof ref === 'function') {
    ref(instance);
  } else {
    ref.current = instance;
  }
};

class OutsideComponent extends _wordpress_element__WEBPACK_IMPORTED_MODULE_2__.Component {
  constructor() {
    super(...arguments);

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__["default"])(this, "childNode", (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createRef)());

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__["default"])(this, "checkIsInside", event => {
      const result = [this.childNode, ...(this.props.additionalRefs || [])].reduce((isInside, currentRef) => {
        if (isInside) {
          return isInside;
        }

        if (!currentRef || !currentRef.current) {
          return isInside;
        }

        return currentRef.current.contains(event.target);
      }, false);
      return result;
    });

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__["default"])(this, "onMouseDown", e => {
      const {
        useCapture
      } = this.props;

      if (!this.checkIsInside(e)) {
        if (this.removeMouseUp) {
          this.removeMouseUp();
          this.removeMouseUp = null;
        }

        document.addEventListener('mouseup', this.onMouseUp, useCapture);

        this.removeMouseUp = () => {
          document.removeEventListener('mouseup', this.onMouseUp, useCapture);
        };
      }
    });

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__["default"])(this, "onMouseUp", e => {
      const {
        onOutsideClick
      } = this.props;

      if (this.removeMouseUp) {
        this.removeMouseUp();
        this.removeMouseUp = null;
      }

      if (!this.checkIsInside(e)) {
        onOutsideClick(e);
      }
    });

    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_1__["default"])(this, "setChildNodeRef", ref => {
      if (this.props.wrapperProps && this.props.wrapperProps.ref) {
        updateRef(this.props.wrapperProps.ref, ref);
      }

      updateRef(this.childNode, ref);
    });
  }

  componentDidMount() {
    const {
      disabled,
      useCapture
    } = this.props;
    if (!disabled) this.addMouseDownEventListener(useCapture);
  }

  UNSAFE_componentWillReceiveProps(_ref) {
    let {
      disabled,
      useCapture
    } = _ref;
    const {
      disabled: prevDisabled
    } = this.props;

    if (prevDisabled !== disabled) {
      if (disabled) {
        this.removeEventListeners();
      } else {
        this.addMouseDownEventListener(useCapture);
      }
    }
  }

  componentWillUnmount() {
    this.removeEventListeners();
  } // Use mousedown/mouseup to enforce that clicks remain outside the root's
  // descendant tree, even when dragged. This should also get triggered on
  // touch devices.


  addMouseDownEventListener(useCapture) {
    document.addEventListener('mousedown', this.onMouseDown, useCapture);

    this.removeMouseDown = () => {
      document.removeEventListener('mousedown', this.onMouseDown, useCapture);
    };
  }

  removeEventListeners() {
    if (this.removeMouseDown) this.removeMouseDown();
    if (this.removeMouseUp) this.removeMouseUp();
  }

  render() {
    const {
      children,
      display,
      className,
      wrapperProps
    } = this.props;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)("div", (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
      className: classnames__WEBPACK_IMPORTED_MODULE_3___default()(className)
    }, wrapperProps || {}, {
      ref: this.setChildNodeRef
    }), children);
  }

}
OutsideComponent.defaultProps = defaultProps;

/***/ }),

/***/ "./src/components/common/popover-component.js":
/*!****************************************************!*\
  !*** ./src/components/common/popover-component.js ***!
  \****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "nullifyTransforms": function() { return /* binding */ nullifyTransforms; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);


function nullifyTransforms(el) {
  const parseTransform = el => window.getComputedStyle(el).transform.split(/\(|,|\)/).slice(1, -1).map(v => parseFloat(v)); // 1


  let {
    top,
    left,
    width,
    height
  } = el.getBoundingClientRect();
  let transformArr = parseTransform(el);

  if (transformArr.length == 6) {
    // 2D matrix
    const t = transformArr; // 2

    let det = t[0] * t[3] - t[1] * t[2]; // 3

    return {
      width: width / t[0],
      height: height / t[3],
      left: (left * t[3] - top * t[2] + t[2] * t[5] - t[4] * t[3]) / det,
      top: (-left * t[1] + top * t[0] + t[4] * t[1] - t[0] * t[5]) / det
    };
  } else {
    // This case is not handled because it's very rarely needed anyway.
    // We just return the tranformed metrics, as they are, for consistency.
    return {
      top,
      left,
      width,
      height
    };
  }
}

const usePopoverMaker = function () {
  let {
    contentRef: contentRefProp,
    shouldCalculate = true,
    ref,
    defaultHeight = 0
  } = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  const contentRef = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useRef)();
  const [s, setState] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(null);

  const refresh = () => {
    if (!shouldCalculate) {
      return;
    }

    setState(Math.random());
  };

  const refreshOnScroll = e => {
    let modalRef = contentRefProp || contentRef;

    if (modalRef && modalRef.current && !modalRef.current.contains(e.target)) {
      refresh();
    }
  };

  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    setTimeout(() => {
      refresh();
    }, 500);
    window.addEventListener('resize', refresh);
    window.addEventListener('scroll', refreshOnScroll, true);
    let observer;

    if (ref.current) {
      observer = new window.ResizeObserver(refresh);
      observer.observe(ref.current, {
        attributes: true
      });

      if (ref.current.closest('.premium-tabs-scroll')) {
        observer.observe(ref.current.closest('.premium-tabs-scroll'), {
          attributes: true
        });
      }

      if (ref.current.closest('.customize-pane-child')) {
        observer.observe(ref.current.closest('.customize-pane-child'), {
          attributes: true
        });
      }
    }

    if (contentRefProp ? contentRefProp.current : contentRef.current) {
      if (!observer) {
        observer = new window.ResizeObserver(refresh);
      }

      observer.observe(contentRefProp ? contentRefProp.current : contentRef.current, {
        attributes: true
      });
    }

    return () => {
      window.removeEventListener('resize', refresh);
      window.removeEventListener('scroll', refreshOnScroll, true);

      if (observer) {
        observer.disconnect();
      }
    };
  }, [shouldCalculate, contentRef.current, contentRefProp, ref.current]);
  let {
    right,
    yOffset,
    position,
    otherStyles,
    modalWidth
  } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    let right = 0;
    let yOffset = 0;
    let position = 'bottom';
    let otherStyles = {};
    let selector = document.querySelector(".components-panel");
    var style = window.getComputedStyle ? getComputedStyle(selector, null) : selector.currentStyle;
    let modalWidth;

    if (selector) {
      modalWidth = selector.clientWidth - 42;
    }

    if (!shouldCalculate) {
      return {
        yOffset,
        right,
        position
      };
    }

    if (ref.current) {
      let rect = ref.current.getBoundingClientRect();
      let el = ref.current.closest('.premium-select-input') ? ref.current.closest('.premium-select-input') : ref.current;
      let maybeWidthFlag = getComputedStyle(el, ':before').content;
      yOffset = rect.top + rect.height;
      right = window.innerWidth - rect.right - 6;

      if (document.body.classList.contains('rtl')) {
        right = rect.left;
      }

      if (maybeWidthFlag.indexOf('ref-width') > -1) {
        let width = rect.width;

        if (maybeWidthFlag.indexOf('left') > -1 && el.previousElementSibling) {
          if (document.body.classList.contains('rtl')) {
            width = el.previousElementSibling.getBoundingClientRect().right - rect.left;
          } else {
            width = rect.right - el.previousElementSibling.getBoundingClientRect().left;
          }
        }

        if (maybeWidthFlag.indexOf('right') > -1) {
          let nextRect = el.parentNode // el.nextElementSibling || el.parentNode
          .getBoundingClientRect();

          if (document.body.classList.contains('rtl')) {
            right = nextRect.left;
            width = rect.right - nextRect.left;
          } else {
            right = window.innerWidth - nextRect.right;
            width = nextRect.right - rect.left;
          }
        }

        otherStyles['--x-selepremium-dropdown-width'] = `${width}px`;
      }

      let popoverRect = contentRefProp && contentRefProp.current || contentRef.current ? nullifyTransforms(contentRefProp ? contentRefProp.current : contentRef.current) : {
        height: defaultHeight
      };

      if (yOffset + popoverRect.height > window.innerHeight && rect.top - 15 > popoverRect.height) {
        position = 'top';
        yOffset = window.innerHeight - rect.bottom + rect.height;
      }

      if (yOffset + popoverRect.height > window.innerHeight && position === 'bottom') {
        position = 'top';
        yOffset = 0;
      }
    }

    return {
      yOffset,
      right,
      position,
      otherStyles,
      modalWidth
    };
  }, [s, shouldCalculate, ref, ref.current, contentRefProp, contentRef.current, defaultHeight]);
  return {
    refreshPopover: refresh,
    styles: {
      '--modal-y-offset': `${yOffset}px`,
      '--modal-x-offset': `${right}px`,
      '--modalWidth': `${modalWidth}px`,
      ...otherStyles
    },
    position,
    popoverProps: {
      ref: contentRefProp || contentRef,
      ...(position ? {
        'data-position': position
      } : {})
    }
  };
};

/* harmony default export */ __webpack_exports__["default"] = (usePopoverMaker);

/***/ }),

/***/ "./src/components/header.js":
/*!**********************************!*\
  !*** ./src/components/header.js ***!
  \**********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/chevron-right.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/chevron-left.js");


/**
 * WordPress dependencies
 */




function ScreenHeader(_ref) {
  let {
    title,
    description
  } = _ref;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalVStack, {
    spacing: 0
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalView, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalSpacer, {
    marginBottom: 0,
    paddingX: 4,
    paddingY: 3
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalHStack, {
    spacing: 2
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalNavigatorBackButton, {
    style: // TODO: This style override is also used in ToolsPanelHeader.
    // It should be supported out-of-the-box by Button.
    {
      minWidth: 24,
      padding: 0
    },
    icon: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.isRTL)() ? _wordpress_icons__WEBPACK_IMPORTED_MODULE_3__["default"] : _wordpress_icons__WEBPACK_IMPORTED_MODULE_4__["default"],
    isSmall: true,
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Navigate to the previous view', "premium-blocks-for-gutenberg")
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalSpacer, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalHeading, {
    level: 5
  }, title))))), description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: "premium-group-header-description"
  }, description));
}

/* harmony default export */ __webpack_exports__["default"] = (ScreenHeader);

/***/ }),

/***/ "./src/components/navigation-buttons.js":
/*!**********************************************!*\
  !*** ./src/components/navigation-buttons.js ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "NavigationBackButtonAsItem": function() { return /* binding */ NavigationBackButtonAsItem; },
/* harmony export */   "NavigationButtonAsItem": function() { return /* binding */ NavigationButtonAsItem; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);



/**
 * WordPress dependencies
 */


function GenericNavigationButton(_ref) {
  let {
    icon,
    children,
    ...props
  } = _ref;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalItem, props, icon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalHStack, {
    justify: "flex-start"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Icon, {
    icon: icon,
    size: 24,
    className: 'premium-group-item-icon'
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.FlexItem, null, children)), !icon && children);
}

function NavigationButtonAsItem(props) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalNavigatorButton, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    as: GenericNavigationButton
  }, props));
}

function NavigationBackButtonAsItem(props) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.__experimentalNavigatorBackButton, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    as: GenericNavigationButton
  }, props));
}



/***/ }),

/***/ "./src/helpers/defaultPalettes.js":
/*!****************************************!*\
  !*** ./src/helpers/defaultPalettes.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
const defaultPalettes = [{
  'id': 'palette-1',
  'name': 'Default',
  'colors': [{
    'slug': 'color1',
    'color': '#0085ba'
  }, {
    'slug': 'color2',
    'color': '#333333'
  }, {
    'slug': 'color3',
    'color': '#444140'
  }, {
    'slug': 'color4',
    'color': '#eaeaea'
  }, {
    'slug': 'color5',
    'color': '#ffffff'
  }],
  'type': 'system',
  'skin': 'light',
  'custom_colors': []
}, {
  'id': 'palette-2',
  'name': 'Sunrise',
  'colors': [{
    'slug': 'color1',
    'color': '#f67207'
  }, {
    'slug': 'color2',
    'color': '#1c1c1c'
  }, {
    'slug': 'color3',
    'color': '#4c4c4c'
  }, {
    'slug': 'color4',
    'color': '#e3e3e3'
  }, {
    'slug': 'color5',
    'color': '#fcfcfc'
  }],
  'type': 'system',
  'skin': 'light',
  'custom_colors': []
}, {
  'id': 'palette-3',
  'name': 'Emerald',
  'colors': [{
    'slug': 'color1',
    'color': '#b7d800'
  }, {
    'slug': 'color2',
    'color': '#1d3e93'
  }, {
    'slug': 'color3',
    'color': '#626262'
  }, {
    'slug': 'color4',
    'color': '#ebeef6'
  }, {
    'slug': 'color5',
    'color': '#f9fafb'
  }],
  'type': 'system',
  'skin': 'light',
  'custom_colors': []
}, {
  'id': 'palette-4',
  'name': 'Flare',
  'colors': [{
    'slug': 'color1',
    'color': '#e49135'
  }, {
    'slug': 'color2',
    'color': '#a63131'
  }, {
    'slug': 'color3',
    'color': '#4c4c4c'
  }, {
    'slug': 'color4',
    'color': '#f4e6e6'
  }, {
    'slug': 'color5',
    'color': '#fcfcfc'
  }],
  'type': 'system',
  'skin': 'light',
  'custom_colors': []
}, {
  'id': 'palette-5',
  'name': 'Shine',
  'colors': [{
    'slug': 'color1',
    'color': '#f67206'
  }, {
    'slug': 'color2',
    'color': '#f7f7f7'
  }, {
    'slug': 'color3',
    'color': '#c6c6c6'
  }, {
    'slug': 'color4',
    'color': '#4d4d4d'
  }, {
    'slug': 'color5',
    'color': '#3b3b3b'
  }],
  'type': 'system',
  'skin': 'dark',
  'custom_colors': []
}, {
  'id': 'palette-6',
  'name': 'Shine',
  'colors': [{
    'slug': 'color1',
    'color': '#8abf3b'
  }, {
    'slug': 'color2',
    'color': '#ffffff'
  }, {
    'slug': 'color3',
    'color': '#898d92'
  }, {
    'slug': 'color4',
    'color': '#2f3940'
  }, {
    'slug': 'color5',
    'color': '#131b21'
  }],
  'type': 'system',
  'skin': 'dark',
  'custom_colors': []
}, {
  'id': 'palette-7',
  'name': 'Sunny Days',
  'colors': [{
    'slug': 'color1',
    'color': '#f0db00'
  }, {
    'slug': 'color2',
    'color': '#ffffff'
  }, {
    'slug': 'color3',
    'color': '#f1f1f1'
  }, {
    'slug': 'color4',
    'color': '#3c3c3c'
  }, {
    'slug': 'color5',
    'color': '#222222'
  }],
  'type': 'system',
  'skin': 'dark',
  'custom_colors': []
}];
/* harmony default export */ __webpack_exports__["default"] = (defaultPalettes);

/***/ }),

/***/ "./src/helpers/defaults.js":
/*!*********************************!*\
  !*** ./src/helpers/defaults.js ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);

const defaults = {
  typography: {
    heading1: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": 0,
        "Tablet": 0,
        "Mobile": 0,
        "unit": "px"
      }
    },
    heading2: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      }
    },
    heading3: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "none",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      }
    },
    heading4: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      }
    },
    heading5: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      }
    },
    heading6: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      }
    },
    button: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      }
    },
    paragraph: {
      "fontWeight": "Default",
      "fontStyle": "",
      "textTransform": "",
      "fontFamily": "Default",
      "textDecoration": "",
      "fontSize": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": {
          "Desktop": "px",
          "Tablet": "px",
          "Mobile": "px"
        }
      },
      "lineHeight": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      },
      "letterSpacing": {
        "Desktop": '',
        "Tablet": '',
        "Mobile": '',
        "unit": "px"
      }
    }
  }
};
/* harmony default export */ __webpack_exports__["default"] = (defaults);

/***/ }),

/***/ "./src/screens/ColorsScreen.js":
/*!*************************************!*\
  !*** ./src/screens/ColorsScreen.js ***!
  \*************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header */ "./src/components/header.js");
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../store/settings-store */ "./src/store/settings-store.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _components_color_palette__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/color-palette */ "./src/components/color-palette.js");
/* harmony import */ var _components_ThemeColorPalette__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../components/ThemeColorPalette */ "./src/components/ThemeColorPalette.js");
/* harmony import */ var _components_AdvancedRadio__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../components/AdvancedRadio */ "./src/components/AdvancedRadio.js");










const ColorsScreen = () => {
  const {
    colorPalette,
    setColorPalette,
    colorPalettes,
    setColorPalettes,
    applyColorsToDefault,
    setApplyColorsToDefault
  } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_store_settings_store__WEBPACK_IMPORTED_MODULE_3__["default"]);
  const options = {
    first: {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Theme Defaults', "premium-blocks-for-gutenberg"),
      value: 'theme',
      help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate theme colors as the default color palette in the premium blocks color control.', "premium-blocks-for-gutenberg")
    },
    second: {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Premium Blocks', "premium-blocks-for-gutenberg"),
      value: 'pbg',
      help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Activate Premium Blocks color palette as the default color palette in the premium blocks color control and apply the current color palette colors to the blocks.', "premium-blocks-for-gutenberg")
    }
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_header__WEBPACK_IMPORTED_MODULE_2__["default"], {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Colors', "premium-blocks-for-gutenberg"),
    description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Manage your website colors based on your default theme colors or Premium Blocks color palette.', "premium-blocks-for-gutenberg")
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-global-colors-screen"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_AdvancedRadio__WEBPACK_IMPORTED_MODULE_7__["default"], {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Select a default color palette', "premium-blocks-for-gutenberg"),
    choices: options,
    value: colorPalette,
    onChange: newType => setColorPalette(newType)
  }), colorPalette === 'theme' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_ThemeColorPalette__WEBPACK_IMPORTED_MODULE_6__["default"], null), colorPalette === 'pbg' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_color_palette__WEBPACK_IMPORTED_MODULE_5__["default"], {
    value: colorPalettes,
    onChange: setColorPalettes
  }), colorPalette === 'pbg' && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.CheckboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Apply to Native Gutenberg Blocks', "premium-blocks-for-gutenberg"),
    checked: applyColorsToDefault,
    onChange: () => setApplyColorsToDefault(!applyColorsToDefault)
  })));
};

/* harmony default export */ __webpack_exports__["default"] = (ColorsScreen);

/***/ }),

/***/ "./src/screens/LayoutSettingsScreen.js":
/*!*********************************************!*\
  !*** ./src/screens/LayoutSettingsScreen.js ***!
  \*********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/header */ "./src/components/header.js");
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../store/settings-store */ "./src/store/settings-store.js");
/* harmony import */ var _components_RangeControl_single_range_control__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../components/RangeControl/single-range-control */ "../components/RangeControl/single-range-control.js");







const LayoutSettingsScreen = props => {
  const {
    layoutSettings,
    setLayoutSettings
  } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_store_settings_store__WEBPACK_IMPORTED_MODULE_3__["default"]);

  const changeHandler = (element, value) => {
    const updatedLayoutSettings = { ...layoutSettings
    };
    updatedLayoutSettings[element] = value;
    setLayoutSettings(updatedLayoutSettings);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_header__WEBPACK_IMPORTED_MODULE_2__["default"], {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Layout Settings', "premium-blocks-for-gutenberg")
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-layout-screen"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Control the space between Gutenberg blocks. The default value is 20px.', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_RangeControl_single_range_control__WEBPACK_IMPORTED_MODULE_4__["default"], {
    defaultValue: 20,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Block Spacing', "premium-blocks-for-gutenberg"),
    value: layoutSettings === null || layoutSettings === void 0 ? void 0 : layoutSettings.block_spacing,
    onChange: value => changeHandler('block_spacing', value),
    min: 1,
    max: 200,
    units: ['px']
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-layout-screen"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Manage container default width and devices breakpoints.', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_RangeControl_single_range_control__WEBPACK_IMPORTED_MODULE_4__["default"], {
    defaultValue: 1200,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Container Max Width', "premium-blocks-for-gutenberg"),
    value: layoutSettings === null || layoutSettings === void 0 ? void 0 : layoutSettings.container_width,
    onChange: value => changeHandler('container_width', value),
    min: 1,
    max: 4000,
    units: ['px']
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_RangeControl_single_range_control__WEBPACK_IMPORTED_MODULE_4__["default"], {
    defaultValue: 1024,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Tablet Breakpoint', "premium-blocks-for-gutenberg"),
    value: layoutSettings === null || layoutSettings === void 0 ? void 0 : layoutSettings.tablet_breakpoint,
    onChange: value => changeHandler('tablet_breakpoint', value),
    min: 1,
    max: 2000,
    units: ['px']
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_RangeControl_single_range_control__WEBPACK_IMPORTED_MODULE_4__["default"], {
    defaultValue: 767,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Mobile Breakpoint', "premium-blocks-for-gutenberg"),
    value: layoutSettings === null || layoutSettings === void 0 ? void 0 : layoutSettings.mobile_breakpoint,
    onChange: value => changeHandler('mobile_breakpoint', value),
    min: 1,
    max: 2000,
    units: ['px']
  })));
};

/* harmony default export */ __webpack_exports__["default"] = (LayoutSettingsScreen);

/***/ }),

/***/ "./src/screens/RootScreen.js":
/*!***********************************!*\
  !*** ./src/screens/RootScreen.js ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/color.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/typography.js");
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/layout.js");
/* harmony import */ var _components_navigation_buttons__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/navigation-buttons */ "./src/components/navigation-buttons.js");






const RootScreen = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Card, {
    size: "small"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.CardBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalItemGroup, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_navigation_buttons__WEBPACK_IMPORTED_MODULE_3__.NavigationButtonAsItem, {
    path: "/colors",
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Colors', "premium-blocks-for-gutenberg"),
    icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_4__["default"]
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Colors', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_navigation_buttons__WEBPACK_IMPORTED_MODULE_3__.NavigationButtonAsItem, {
    icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_5__["default"],
    path: '/typography',
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Typography styles', "premium-blocks-for-gutenberg")
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Typography', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_navigation_buttons__WEBPACK_IMPORTED_MODULE_3__.NavigationButtonAsItem, {
    icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_6__["default"],
    path: '/container-settings',
    "aria-label": (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Layout', "premium-blocks-for-gutenberg")
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Layout', "premium-blocks-for-gutenberg")))));
};

/* harmony default export */ __webpack_exports__["default"] = (RootScreen);

/***/ }),

/***/ "./src/screens/TypographyScreen.js":
/*!*****************************************!*\
  !*** ./src/screens/TypographyScreen.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_premium_typo__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../components/premium-typo */ "../components/premium-typo.js");
/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/header */ "./src/components/header.js");
/* harmony import */ var _helpers_defaults__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../helpers/defaults */ "./src/helpers/defaults.js");
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../store/settings-store */ "./src/store/settings-store.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var webfontloader__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! webfontloader */ "./node_modules/webfontloader/webfontloader.js");
/* harmony import */ var webfontloader__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(webfontloader__WEBPACK_IMPORTED_MODULE_7__);










const TypographyScreen = props => {
  var _getElementValue, _getElementValue2, _getElementValue3, _getElementValue4, _getElementValue5, _getElementValue6, _getElementValue7, _getElementValue8;

  const {
    globalTypography,
    setGlobalTypography,
    applyTypographyToDefault,
    setApplyTypographyToDefault
  } = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useContext)(_store_settings_store__WEBPACK_IMPORTED_MODULE_5__["default"]);
  const {
    typography: defaultValues
  } = _helpers_defaults__WEBPACK_IMPORTED_MODULE_4__["default"];

  const getElementValue = element => {
    let value = (globalTypography === null || globalTypography === void 0 ? void 0 : globalTypography[element]) || (defaultValues === null || defaultValues === void 0 ? void 0 : defaultValues[element]);
    return value;
  };

  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const allTypography = [getElementValue('heading1'), getElementValue('heading2'), getElementValue('heading3'), getElementValue('heading4'), getElementValue('heading5'), getElementValue('heading6'), getElementValue('button'), getElementValue('paragraph')];
    const googleFonts = allTypography.filter(typography => (typography === null || typography === void 0 ? void 0 : typography.fontFamily) !== 'Default').map(typography => typography.fontFamily);

    if (googleFonts.length > 0) {
      webfontloader__WEBPACK_IMPORTED_MODULE_7___default().load({
        google: {
          families: googleFonts
        }
      });
    }
  }, [globalTypography]);

  const toString = object => {
    object = { ...object,
      Desktop: object.Desktop.toString(),
      Tablet: object.Tablet.toString(),
      Mobile: object.Mobile.toString()
    };
    return object;
  };

  const changeHandler = (element, value) => {
    // Convert values to string.
    Object.keys(value).forEach(function (key, index) {
      value[key] = typeof value[key] === 'object' ? toString(value[key]) : value[key];
    });
    const updatedTypography = { ...globalTypography
    };
    updatedTypography[element] = value;
    setGlobalTypography(updatedTypography);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_header__WEBPACK_IMPORTED_MODULE_3__["default"], {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Typography', "premium-blocks-for-gutenberg"),
    description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Manage the typography settings for different elements.', "premium-blocks-for-gutenberg")
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-typography-screen"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h1", {
    style: {
      fontFamily: (_getElementValue = getElementValue('heading1')) === null || _getElementValue === void 0 ? void 0 : _getElementValue.fontFamily,
      fontSize: '38px',
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none',
      fontWeight: '600'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading 1', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('heading1'),
    title: false,
    onChange: newValue => changeHandler('heading1', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
    style: {
      fontFamily: (_getElementValue2 = getElementValue('heading2')) === null || _getElementValue2 === void 0 ? void 0 : _getElementValue2.fontFamily,
      fontSize: '30px',
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none',
      fontWeight: '600'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading 2', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('heading2'),
    title: false,
    onChange: newValue => changeHandler('heading2', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h3", {
    style: {
      fontFamily: (_getElementValue3 = getElementValue('heading3')) === null || _getElementValue3 === void 0 ? void 0 : _getElementValue3.fontFamily,
      fontSize: '25px',
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none',
      fontWeight: '600'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading 3', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('heading3'),
    title: false,
    onChange: newValue => changeHandler('heading3', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h4", {
    style: {
      fontFamily: (_getElementValue4 = getElementValue('heading4')) === null || _getElementValue4 === void 0 ? void 0 : _getElementValue4.fontFamily,
      fontSize: '20px',
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none',
      fontWeight: '600'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading 4', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('heading4'),
    title: false,
    onChange: newValue => changeHandler('heading4', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h5", {
    style: {
      fontFamily: (_getElementValue5 = getElementValue('heading5')) === null || _getElementValue5 === void 0 ? void 0 : _getElementValue5.fontFamily,
      fontSize: '18px',
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none',
      fontWeight: '600'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading 5', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('heading5'),
    title: false,
    onChange: newValue => changeHandler('heading5', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h6", {
    style: {
      fontFamily: (_getElementValue6 = getElementValue('heading6')) === null || _getElementValue6 === void 0 ? void 0 : _getElementValue6.fontFamily,
      fontSize: '15px',
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none',
      fontWeight: '600'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Heading 6', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('heading6'),
    title: false,
    onChange: newValue => changeHandler('heading6', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    style: {
      fontFamily: (_getElementValue7 = getElementValue('button')) === null || _getElementValue7 === void 0 ? void 0 : _getElementValue7.fontFamily,
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Buttons', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('button'),
    title: false,
    onChange: newValue => changeHandler('button', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "premium-element-typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    style: {
      fontFamily: (_getElementValue8 = getElementValue('paragraph')) === null || _getElementValue8 === void 0 ? void 0 : _getElementValue8.fontFamily,
      textDecoration: 'none',
      lineHeight: 'normal',
      textTransform: 'none'
    },
    className: "premium-element-typography-title"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Text', "premium-blocks-for-gutenberg")), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_premium_typo__WEBPACK_IMPORTED_MODULE_2__["default"], {
    value: getElementValue('paragraph'),
    title: false,
    onChange: newValue => changeHandler('paragraph', newValue)
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__.CheckboxControl, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__.__)('Apply to Native Gutenberg Blocks', "premium-blocks-for-gutenberg"),
    checked: applyTypographyToDefault,
    onChange: () => setApplyTypographyToDefault(!applyTypographyToDefault)
  })));
};

/* harmony default export */ __webpack_exports__["default"] = (TypographyScreen);

/***/ }),

/***/ "./src/store/settings-store.js":
/*!*************************************!*\
  !*** ./src/store/settings-store.js ***!
  \*************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "SettingsProvider": function() { return /* binding */ SettingsProvider; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);


/**
 * WordPress dependencies
 */


const SettingsContext = React.createContext({
  globalTypography: {},
  globalColors: {},
  colorPalette: '',
  setGlobalTypography: () => {},
  setGlobalColors: () => {},
  setColorPalette: () => {},
  colorPalettes: [],
  setColorPalettes: [],
  layoutSettings: {},
  setLayoutSettings: () => {},
  customColors: [],
  setCustomColors: () => {},
  applyColorsToDefault: [],
  setApplyColorsToDefault: () => {},
  applyTypographyToDefault: [],
  setApplyTypographyToDefault: () => {}
});
const SettingsProvider = props => {
  const [globalTypography, setGlobalTypography] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_global_typography');
  const [globalColors, setGlobalColors] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_global_colors');
  const [colorPalette, setColorPalette] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_global_color_palette');
  const [colorPalettes, setColorPalettes] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_global_color_palettes');
  const [customColors, setCustomColors] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_custom_colors');
  const [layoutSettings, setLayoutSettings] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_global_layout');
  const [applyColorsToDefault, setApplyColorsToDefault] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_global_colors_to_default');
  const [applyTypographyToDefault, setApplyTypographyToDefault] = (0,_wordpress_core_data__WEBPACK_IMPORTED_MODULE_1__.useEntityProp)('root', 'site', 'pbg_global_typography_to_default');
  const settingsContext = {
    globalTypography,
    setGlobalTypography,
    globalColors,
    setGlobalColors,
    colorPalette,
    setColorPalette,
    colorPalettes,
    setColorPalettes,
    customColors,
    setCustomColors,
    layoutSettings,
    setLayoutSettings,
    applyColorsToDefault,
    setApplyColorsToDefault,
    applyTypographyToDefault,
    setApplyTypographyToDefault
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SettingsContext.Provider, {
    value: settingsContext
  }, props.children);
};
/* harmony default export */ __webpack_exports__["default"] = (SettingsContext);

/***/ }),

/***/ "./src/ui.js":
/*!*******************!*\
  !*** ./src/ui.js ***!
  \*******************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _screens_ColorsScreen__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./screens/ColorsScreen */ "./src/screens/ColorsScreen.js");
/* harmony import */ var _screens_LayoutSettingsScreen__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./screens/LayoutSettingsScreen */ "./src/screens/LayoutSettingsScreen.js");
/* harmony import */ var _screens_RootScreen__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./screens/RootScreen */ "./src/screens/RootScreen.js");
/* harmony import */ var _screens_TypographyScreen__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./screens/TypographyScreen */ "./src/screens/TypographyScreen.js");








const GlobalStylesUI = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalNavigatorProvider, {
    className: "premium-global-styles-sidebar__navigator-provider",
    initialPath: "/"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalNavigatorScreen, {
    path: "/"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_screens_RootScreen__WEBPACK_IMPORTED_MODULE_5__["default"], null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalNavigatorScreen, {
    path: "/colors"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_screens_ColorsScreen__WEBPACK_IMPORTED_MODULE_3__["default"], null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalNavigatorScreen, {
    path: "/typography"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_screens_TypographyScreen__WEBPACK_IMPORTED_MODULE_6__["default"], null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalNavigatorScreen, {
    path: "/container-settings"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_screens_LayoutSettingsScreen__WEBPACK_IMPORTED_MODULE_4__["default"], null)));
};

/* harmony default export */ __webpack_exports__["default"] = (GlobalStylesUI);

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2018 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames() {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg)) {
				if (arg.length) {
					var inner = classNames.apply(null, arg);
					if (inner) {
						classes.push(inner);
					}
				}
			} else if (argType === 'object') {
				if (arg.toString === Object.prototype.toString) {
					for (var key in arg) {
						if (hasOwn.call(arg, key) && arg[key]) {
							classes.push(key);
						}
					}
				} else {
					classes.push(arg.toString());
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "./src/styles/index.scss":
/*!*******************************!*\
  !*** ./src/styles/index.scss ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/object-assign/index.js":
/*!*********************************************!*\
  !*** ./node_modules/object-assign/index.js ***!
  \*********************************************/
/***/ (function(module) {

"use strict";
/*
object-assign
(c) Sindre Sorhus
@license MIT
*/


/* eslint-disable no-unused-vars */
var getOwnPropertySymbols = Object.getOwnPropertySymbols;
var hasOwnProperty = Object.prototype.hasOwnProperty;
var propIsEnumerable = Object.prototype.propertyIsEnumerable;

function toObject(val) {
	if (val === null || val === undefined) {
		throw new TypeError('Object.assign cannot be called with null or undefined');
	}

	return Object(val);
}

function shouldUseNative() {
	try {
		if (!Object.assign) {
			return false;
		}

		// Detect buggy property enumeration order in older V8 versions.

		// https://bugs.chromium.org/p/v8/issues/detail?id=4118
		var test1 = new String('abc');  // eslint-disable-line no-new-wrappers
		test1[5] = 'de';
		if (Object.getOwnPropertyNames(test1)[0] === '5') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test2 = {};
		for (var i = 0; i < 10; i++) {
			test2['_' + String.fromCharCode(i)] = i;
		}
		var order2 = Object.getOwnPropertyNames(test2).map(function (n) {
			return test2[n];
		});
		if (order2.join('') !== '0123456789') {
			return false;
		}

		// https://bugs.chromium.org/p/v8/issues/detail?id=3056
		var test3 = {};
		'abcdefghijklmnopqrst'.split('').forEach(function (letter) {
			test3[letter] = letter;
		});
		if (Object.keys(Object.assign({}, test3)).join('') !==
				'abcdefghijklmnopqrst') {
			return false;
		}

		return true;
	} catch (err) {
		// We don't expect any of the above to throw, but better to be safe.
		return false;
	}
}

module.exports = shouldUseNative() ? Object.assign : function (target, source) {
	var from;
	var to = toObject(target);
	var symbols;

	for (var s = 1; s < arguments.length; s++) {
		from = Object(arguments[s]);

		for (var key in from) {
			if (hasOwnProperty.call(from, key)) {
				to[key] = from[key];
			}
		}

		if (getOwnPropertySymbols) {
			symbols = getOwnPropertySymbols(from);
			for (var i = 0; i < symbols.length; i++) {
				if (propIsEnumerable.call(from, symbols[i])) {
					to[symbols[i]] = from[symbols[i]];
				}
			}
		}
	}

	return to;
};


/***/ }),

/***/ "./node_modules/prop-types/checkPropTypes.js":
/*!***************************************************!*\
  !*** ./node_modules/prop-types/checkPropTypes.js ***!
  \***************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */



var printWarning = function() {};

if (true) {
  var ReactPropTypesSecret = __webpack_require__(/*! ./lib/ReactPropTypesSecret */ "./node_modules/prop-types/lib/ReactPropTypesSecret.js");
  var loggedTypeFailures = {};
  var has = __webpack_require__(/*! ./lib/has */ "./node_modules/prop-types/lib/has.js");

  printWarning = function(text) {
    var message = 'Warning: ' + text;
    if (typeof console !== 'undefined') {
      console.error(message);
    }
    try {
      // --- Welcome to debugging React ---
      // This error was thrown as a convenience so that you can use this stack
      // to find the callsite that caused this warning to fire.
      throw new Error(message);
    } catch (x) { /**/ }
  };
}

/**
 * Assert that the values match with the type specs.
 * Error messages are memorized and will only be shown once.
 *
 * @param {object} typeSpecs Map of name to a ReactPropType
 * @param {object} values Runtime values that need to be type-checked
 * @param {string} location e.g. "prop", "context", "child context"
 * @param {string} componentName Name of the component for error messages.
 * @param {?Function} getStack Returns the component stack.
 * @private
 */
function checkPropTypes(typeSpecs, values, location, componentName, getStack) {
  if (true) {
    for (var typeSpecName in typeSpecs) {
      if (has(typeSpecs, typeSpecName)) {
        var error;
        // Prop type validation may throw. In case they do, we don't want to
        // fail the render phase where it didn't fail before. So we log it.
        // After these have been cleaned up, we'll let them throw.
        try {
          // This is intentionally an invariant that gets caught. It's the same
          // behavior as without this statement except with a better message.
          if (typeof typeSpecs[typeSpecName] !== 'function') {
            var err = Error(
              (componentName || 'React class') + ': ' + location + ' type `' + typeSpecName + '` is invalid; ' +
              'it must be a function, usually from the `prop-types` package, but received `' + typeof typeSpecs[typeSpecName] + '`.' +
              'This often happens because of typos such as `PropTypes.function` instead of `PropTypes.func`.'
            );
            err.name = 'Invariant Violation';
            throw err;
          }
          error = typeSpecs[typeSpecName](values, typeSpecName, componentName, location, null, ReactPropTypesSecret);
        } catch (ex) {
          error = ex;
        }
        if (error && !(error instanceof Error)) {
          printWarning(
            (componentName || 'React class') + ': type specification of ' +
            location + ' `' + typeSpecName + '` is invalid; the type checker ' +
            'function must return `null` or an `Error` but returned a ' + typeof error + '. ' +
            'You may have forgotten to pass an argument to the type checker ' +
            'creator (arrayOf, instanceOf, objectOf, oneOf, oneOfType, and ' +
            'shape all require an argument).'
          );
        }
        if (error instanceof Error && !(error.message in loggedTypeFailures)) {
          // Only monitor this failure once because there tends to be a lot of the
          // same error.
          loggedTypeFailures[error.message] = true;

          var stack = getStack ? getStack() : '';

          printWarning(
            'Failed ' + location + ' type: ' + error.message + (stack != null ? stack : '')
          );
        }
      }
    }
  }
}

/**
 * Resets warning cache when testing.
 *
 * @private
 */
checkPropTypes.resetWarningCache = function() {
  if (true) {
    loggedTypeFailures = {};
  }
}

module.exports = checkPropTypes;


/***/ }),

/***/ "./node_modules/prop-types/factoryWithTypeCheckers.js":
/*!************************************************************!*\
  !*** ./node_modules/prop-types/factoryWithTypeCheckers.js ***!
  \************************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */



var ReactIs = __webpack_require__(/*! react-is */ "./node_modules/react-is/index.js");
var assign = __webpack_require__(/*! object-assign */ "./node_modules/object-assign/index.js");

var ReactPropTypesSecret = __webpack_require__(/*! ./lib/ReactPropTypesSecret */ "./node_modules/prop-types/lib/ReactPropTypesSecret.js");
var has = __webpack_require__(/*! ./lib/has */ "./node_modules/prop-types/lib/has.js");
var checkPropTypes = __webpack_require__(/*! ./checkPropTypes */ "./node_modules/prop-types/checkPropTypes.js");

var printWarning = function() {};

if (true) {
  printWarning = function(text) {
    var message = 'Warning: ' + text;
    if (typeof console !== 'undefined') {
      console.error(message);
    }
    try {
      // --- Welcome to debugging React ---
      // This error was thrown as a convenience so that you can use this stack
      // to find the callsite that caused this warning to fire.
      throw new Error(message);
    } catch (x) {}
  };
}

function emptyFunctionThatReturnsNull() {
  return null;
}

module.exports = function(isValidElement, throwOnDirectAccess) {
  /* global Symbol */
  var ITERATOR_SYMBOL = typeof Symbol === 'function' && Symbol.iterator;
  var FAUX_ITERATOR_SYMBOL = '@@iterator'; // Before Symbol spec.

  /**
   * Returns the iterator method function contained on the iterable object.
   *
   * Be sure to invoke the function with the iterable as context:
   *
   *     var iteratorFn = getIteratorFn(myIterable);
   *     if (iteratorFn) {
   *       var iterator = iteratorFn.call(myIterable);
   *       ...
   *     }
   *
   * @param {?object} maybeIterable
   * @return {?function}
   */
  function getIteratorFn(maybeIterable) {
    var iteratorFn = maybeIterable && (ITERATOR_SYMBOL && maybeIterable[ITERATOR_SYMBOL] || maybeIterable[FAUX_ITERATOR_SYMBOL]);
    if (typeof iteratorFn === 'function') {
      return iteratorFn;
    }
  }

  /**
   * Collection of methods that allow declaration and validation of props that are
   * supplied to React components. Example usage:
   *
   *   var Props = require('ReactPropTypes');
   *   var MyArticle = React.createClass({
   *     propTypes: {
   *       // An optional string prop named "description".
   *       description: Props.string,
   *
   *       // A required enum prop named "category".
   *       category: Props.oneOf(['News','Photos']).isRequired,
   *
   *       // A prop named "dialog" that requires an instance of Dialog.
   *       dialog: Props.instanceOf(Dialog).isRequired
   *     },
   *     render: function() { ... }
   *   });
   *
   * A more formal specification of how these methods are used:
   *
   *   type := array|bool|func|object|number|string|oneOf([...])|instanceOf(...)
   *   decl := ReactPropTypes.{type}(.isRequired)?
   *
   * Each and every declaration produces a function with the same signature. This
   * allows the creation of custom validation functions. For example:
   *
   *  var MyLink = React.createClass({
   *    propTypes: {
   *      // An optional string or URI prop named "href".
   *      href: function(props, propName, componentName) {
   *        var propValue = props[propName];
   *        if (propValue != null && typeof propValue !== 'string' &&
   *            !(propValue instanceof URI)) {
   *          return new Error(
   *            'Expected a string or an URI for ' + propName + ' in ' +
   *            componentName
   *          );
   *        }
   *      }
   *    },
   *    render: function() {...}
   *  });
   *
   * @internal
   */

  var ANONYMOUS = '<<anonymous>>';

  // Important!
  // Keep this list in sync with production version in `./factoryWithThrowingShims.js`.
  var ReactPropTypes = {
    array: createPrimitiveTypeChecker('array'),
    bigint: createPrimitiveTypeChecker('bigint'),
    bool: createPrimitiveTypeChecker('boolean'),
    func: createPrimitiveTypeChecker('function'),
    number: createPrimitiveTypeChecker('number'),
    object: createPrimitiveTypeChecker('object'),
    string: createPrimitiveTypeChecker('string'),
    symbol: createPrimitiveTypeChecker('symbol'),

    any: createAnyTypeChecker(),
    arrayOf: createArrayOfTypeChecker,
    element: createElementTypeChecker(),
    elementType: createElementTypeTypeChecker(),
    instanceOf: createInstanceTypeChecker,
    node: createNodeChecker(),
    objectOf: createObjectOfTypeChecker,
    oneOf: createEnumTypeChecker,
    oneOfType: createUnionTypeChecker,
    shape: createShapeTypeChecker,
    exact: createStrictShapeTypeChecker,
  };

  /**
   * inlined Object.is polyfill to avoid requiring consumers ship their own
   * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is
   */
  /*eslint-disable no-self-compare*/
  function is(x, y) {
    // SameValue algorithm
    if (x === y) {
      // Steps 1-5, 7-10
      // Steps 6.b-6.e: +0 != -0
      return x !== 0 || 1 / x === 1 / y;
    } else {
      // Step 6.a: NaN == NaN
      return x !== x && y !== y;
    }
  }
  /*eslint-enable no-self-compare*/

  /**
   * We use an Error-like object for backward compatibility as people may call
   * PropTypes directly and inspect their output. However, we don't use real
   * Errors anymore. We don't inspect their stack anyway, and creating them
   * is prohibitively expensive if they are created too often, such as what
   * happens in oneOfType() for any type before the one that matched.
   */
  function PropTypeError(message, data) {
    this.message = message;
    this.data = data && typeof data === 'object' ? data: {};
    this.stack = '';
  }
  // Make `instanceof Error` still work for returned errors.
  PropTypeError.prototype = Error.prototype;

  function createChainableTypeChecker(validate) {
    if (true) {
      var manualPropTypeCallCache = {};
      var manualPropTypeWarningCount = 0;
    }
    function checkType(isRequired, props, propName, componentName, location, propFullName, secret) {
      componentName = componentName || ANONYMOUS;
      propFullName = propFullName || propName;

      if (secret !== ReactPropTypesSecret) {
        if (throwOnDirectAccess) {
          // New behavior only for users of `prop-types` package
          var err = new Error(
            'Calling PropTypes validators directly is not supported by the `prop-types` package. ' +
            'Use `PropTypes.checkPropTypes()` to call them. ' +
            'Read more at http://fb.me/use-check-prop-types'
          );
          err.name = 'Invariant Violation';
          throw err;
        } else if ( true && typeof console !== 'undefined') {
          // Old behavior for people using React.PropTypes
          var cacheKey = componentName + ':' + propName;
          if (
            !manualPropTypeCallCache[cacheKey] &&
            // Avoid spamming the console because they are often not actionable except for lib authors
            manualPropTypeWarningCount < 3
          ) {
            printWarning(
              'You are manually calling a React.PropTypes validation ' +
              'function for the `' + propFullName + '` prop on `' + componentName + '`. This is deprecated ' +
              'and will throw in the standalone `prop-types` package. ' +
              'You may be seeing this warning due to a third-party PropTypes ' +
              'library. See https://fb.me/react-warning-dont-call-proptypes ' + 'for details.'
            );
            manualPropTypeCallCache[cacheKey] = true;
            manualPropTypeWarningCount++;
          }
        }
      }
      if (props[propName] == null) {
        if (isRequired) {
          if (props[propName] === null) {
            return new PropTypeError('The ' + location + ' `' + propFullName + '` is marked as required ' + ('in `' + componentName + '`, but its value is `null`.'));
          }
          return new PropTypeError('The ' + location + ' `' + propFullName + '` is marked as required in ' + ('`' + componentName + '`, but its value is `undefined`.'));
        }
        return null;
      } else {
        return validate(props, propName, componentName, location, propFullName);
      }
    }

    var chainedCheckType = checkType.bind(null, false);
    chainedCheckType.isRequired = checkType.bind(null, true);

    return chainedCheckType;
  }

  function createPrimitiveTypeChecker(expectedType) {
    function validate(props, propName, componentName, location, propFullName, secret) {
      var propValue = props[propName];
      var propType = getPropType(propValue);
      if (propType !== expectedType) {
        // `propValue` being instance of, say, date/regexp, pass the 'object'
        // check, but we can offer a more precise error message here rather than
        // 'of type `object`'.
        var preciseType = getPreciseType(propValue);

        return new PropTypeError(
          'Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + preciseType + '` supplied to `' + componentName + '`, expected ') + ('`' + expectedType + '`.'),
          {expectedType: expectedType}
        );
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function createAnyTypeChecker() {
    return createChainableTypeChecker(emptyFunctionThatReturnsNull);
  }

  function createArrayOfTypeChecker(typeChecker) {
    function validate(props, propName, componentName, location, propFullName) {
      if (typeof typeChecker !== 'function') {
        return new PropTypeError('Property `' + propFullName + '` of component `' + componentName + '` has invalid PropType notation inside arrayOf.');
      }
      var propValue = props[propName];
      if (!Array.isArray(propValue)) {
        var propType = getPropType(propValue);
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected an array.'));
      }
      for (var i = 0; i < propValue.length; i++) {
        var error = typeChecker(propValue, i, componentName, location, propFullName + '[' + i + ']', ReactPropTypesSecret);
        if (error instanceof Error) {
          return error;
        }
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function createElementTypeChecker() {
    function validate(props, propName, componentName, location, propFullName) {
      var propValue = props[propName];
      if (!isValidElement(propValue)) {
        var propType = getPropType(propValue);
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected a single ReactElement.'));
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function createElementTypeTypeChecker() {
    function validate(props, propName, componentName, location, propFullName) {
      var propValue = props[propName];
      if (!ReactIs.isValidElementType(propValue)) {
        var propType = getPropType(propValue);
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected a single ReactElement type.'));
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function createInstanceTypeChecker(expectedClass) {
    function validate(props, propName, componentName, location, propFullName) {
      if (!(props[propName] instanceof expectedClass)) {
        var expectedClassName = expectedClass.name || ANONYMOUS;
        var actualClassName = getClassName(props[propName]);
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + actualClassName + '` supplied to `' + componentName + '`, expected ') + ('instance of `' + expectedClassName + '`.'));
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function createEnumTypeChecker(expectedValues) {
    if (!Array.isArray(expectedValues)) {
      if (true) {
        if (arguments.length > 1) {
          printWarning(
            'Invalid arguments supplied to oneOf, expected an array, got ' + arguments.length + ' arguments. ' +
            'A common mistake is to write oneOf(x, y, z) instead of oneOf([x, y, z]).'
          );
        } else {
          printWarning('Invalid argument supplied to oneOf, expected an array.');
        }
      }
      return emptyFunctionThatReturnsNull;
    }

    function validate(props, propName, componentName, location, propFullName) {
      var propValue = props[propName];
      for (var i = 0; i < expectedValues.length; i++) {
        if (is(propValue, expectedValues[i])) {
          return null;
        }
      }

      var valuesString = JSON.stringify(expectedValues, function replacer(key, value) {
        var type = getPreciseType(value);
        if (type === 'symbol') {
          return String(value);
        }
        return value;
      });
      return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of value `' + String(propValue) + '` ' + ('supplied to `' + componentName + '`, expected one of ' + valuesString + '.'));
    }
    return createChainableTypeChecker(validate);
  }

  function createObjectOfTypeChecker(typeChecker) {
    function validate(props, propName, componentName, location, propFullName) {
      if (typeof typeChecker !== 'function') {
        return new PropTypeError('Property `' + propFullName + '` of component `' + componentName + '` has invalid PropType notation inside objectOf.');
      }
      var propValue = props[propName];
      var propType = getPropType(propValue);
      if (propType !== 'object') {
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type ' + ('`' + propType + '` supplied to `' + componentName + '`, expected an object.'));
      }
      for (var key in propValue) {
        if (has(propValue, key)) {
          var error = typeChecker(propValue, key, componentName, location, propFullName + '.' + key, ReactPropTypesSecret);
          if (error instanceof Error) {
            return error;
          }
        }
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function createUnionTypeChecker(arrayOfTypeCheckers) {
    if (!Array.isArray(arrayOfTypeCheckers)) {
       true ? printWarning('Invalid argument supplied to oneOfType, expected an instance of array.') : 0;
      return emptyFunctionThatReturnsNull;
    }

    for (var i = 0; i < arrayOfTypeCheckers.length; i++) {
      var checker = arrayOfTypeCheckers[i];
      if (typeof checker !== 'function') {
        printWarning(
          'Invalid argument supplied to oneOfType. Expected an array of check functions, but ' +
          'received ' + getPostfixForTypeWarning(checker) + ' at index ' + i + '.'
        );
        return emptyFunctionThatReturnsNull;
      }
    }

    function validate(props, propName, componentName, location, propFullName) {
      var expectedTypes = [];
      for (var i = 0; i < arrayOfTypeCheckers.length; i++) {
        var checker = arrayOfTypeCheckers[i];
        var checkerResult = checker(props, propName, componentName, location, propFullName, ReactPropTypesSecret);
        if (checkerResult == null) {
          return null;
        }
        if (checkerResult.data && has(checkerResult.data, 'expectedType')) {
          expectedTypes.push(checkerResult.data.expectedType);
        }
      }
      var expectedTypesMessage = (expectedTypes.length > 0) ? ', expected one of type [' + expectedTypes.join(', ') + ']': '';
      return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` supplied to ' + ('`' + componentName + '`' + expectedTypesMessage + '.'));
    }
    return createChainableTypeChecker(validate);
  }

  function createNodeChecker() {
    function validate(props, propName, componentName, location, propFullName) {
      if (!isNode(props[propName])) {
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` supplied to ' + ('`' + componentName + '`, expected a ReactNode.'));
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function invalidValidatorError(componentName, location, propFullName, key, type) {
    return new PropTypeError(
      (componentName || 'React class') + ': ' + location + ' type `' + propFullName + '.' + key + '` is invalid; ' +
      'it must be a function, usually from the `prop-types` package, but received `' + type + '`.'
    );
  }

  function createShapeTypeChecker(shapeTypes) {
    function validate(props, propName, componentName, location, propFullName) {
      var propValue = props[propName];
      var propType = getPropType(propValue);
      if (propType !== 'object') {
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type `' + propType + '` ' + ('supplied to `' + componentName + '`, expected `object`.'));
      }
      for (var key in shapeTypes) {
        var checker = shapeTypes[key];
        if (typeof checker !== 'function') {
          return invalidValidatorError(componentName, location, propFullName, key, getPreciseType(checker));
        }
        var error = checker(propValue, key, componentName, location, propFullName + '.' + key, ReactPropTypesSecret);
        if (error) {
          return error;
        }
      }
      return null;
    }
    return createChainableTypeChecker(validate);
  }

  function createStrictShapeTypeChecker(shapeTypes) {
    function validate(props, propName, componentName, location, propFullName) {
      var propValue = props[propName];
      var propType = getPropType(propValue);
      if (propType !== 'object') {
        return new PropTypeError('Invalid ' + location + ' `' + propFullName + '` of type `' + propType + '` ' + ('supplied to `' + componentName + '`, expected `object`.'));
      }
      // We need to check all keys in case some are required but missing from props.
      var allKeys = assign({}, props[propName], shapeTypes);
      for (var key in allKeys) {
        var checker = shapeTypes[key];
        if (has(shapeTypes, key) && typeof checker !== 'function') {
          return invalidValidatorError(componentName, location, propFullName, key, getPreciseType(checker));
        }
        if (!checker) {
          return new PropTypeError(
            'Invalid ' + location + ' `' + propFullName + '` key `' + key + '` supplied to `' + componentName + '`.' +
            '\nBad object: ' + JSON.stringify(props[propName], null, '  ') +
            '\nValid keys: ' + JSON.stringify(Object.keys(shapeTypes), null, '  ')
          );
        }
        var error = checker(propValue, key, componentName, location, propFullName + '.' + key, ReactPropTypesSecret);
        if (error) {
          return error;
        }
      }
      return null;
    }

    return createChainableTypeChecker(validate);
  }

  function isNode(propValue) {
    switch (typeof propValue) {
      case 'number':
      case 'string':
      case 'undefined':
        return true;
      case 'boolean':
        return !propValue;
      case 'object':
        if (Array.isArray(propValue)) {
          return propValue.every(isNode);
        }
        if (propValue === null || isValidElement(propValue)) {
          return true;
        }

        var iteratorFn = getIteratorFn(propValue);
        if (iteratorFn) {
          var iterator = iteratorFn.call(propValue);
          var step;
          if (iteratorFn !== propValue.entries) {
            while (!(step = iterator.next()).done) {
              if (!isNode(step.value)) {
                return false;
              }
            }
          } else {
            // Iterator will provide entry [k,v] tuples rather than values.
            while (!(step = iterator.next()).done) {
              var entry = step.value;
              if (entry) {
                if (!isNode(entry[1])) {
                  return false;
                }
              }
            }
          }
        } else {
          return false;
        }

        return true;
      default:
        return false;
    }
  }

  function isSymbol(propType, propValue) {
    // Native Symbol.
    if (propType === 'symbol') {
      return true;
    }

    // falsy value can't be a Symbol
    if (!propValue) {
      return false;
    }

    // 19.4.3.5 Symbol.prototype[@@toStringTag] === 'Symbol'
    if (propValue['@@toStringTag'] === 'Symbol') {
      return true;
    }

    // Fallback for non-spec compliant Symbols which are polyfilled.
    if (typeof Symbol === 'function' && propValue instanceof Symbol) {
      return true;
    }

    return false;
  }

  // Equivalent of `typeof` but with special handling for array and regexp.
  function getPropType(propValue) {
    var propType = typeof propValue;
    if (Array.isArray(propValue)) {
      return 'array';
    }
    if (propValue instanceof RegExp) {
      // Old webkits (at least until Android 4.0) return 'function' rather than
      // 'object' for typeof a RegExp. We'll normalize this here so that /bla/
      // passes PropTypes.object.
      return 'object';
    }
    if (isSymbol(propType, propValue)) {
      return 'symbol';
    }
    return propType;
  }

  // This handles more types than `getPropType`. Only used for error messages.
  // See `createPrimitiveTypeChecker`.
  function getPreciseType(propValue) {
    if (typeof propValue === 'undefined' || propValue === null) {
      return '' + propValue;
    }
    var propType = getPropType(propValue);
    if (propType === 'object') {
      if (propValue instanceof Date) {
        return 'date';
      } else if (propValue instanceof RegExp) {
        return 'regexp';
      }
    }
    return propType;
  }

  // Returns a string that is postfixed to a warning about an invalid type.
  // For example, "undefined" or "of type array"
  function getPostfixForTypeWarning(value) {
    var type = getPreciseType(value);
    switch (type) {
      case 'array':
      case 'object':
        return 'an ' + type;
      case 'boolean':
      case 'date':
      case 'regexp':
        return 'a ' + type;
      default:
        return type;
    }
  }

  // Returns class name of the object, if any.
  function getClassName(propValue) {
    if (!propValue.constructor || !propValue.constructor.name) {
      return ANONYMOUS;
    }
    return propValue.constructor.name;
  }

  ReactPropTypes.checkPropTypes = checkPropTypes;
  ReactPropTypes.resetWarningCache = checkPropTypes.resetWarningCache;
  ReactPropTypes.PropTypes = ReactPropTypes;

  return ReactPropTypes;
};


/***/ }),

/***/ "./node_modules/prop-types/index.js":
/*!******************************************!*\
  !*** ./node_modules/prop-types/index.js ***!
  \******************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

if (true) {
  var ReactIs = __webpack_require__(/*! react-is */ "./node_modules/react-is/index.js");

  // By explicitly using `prop-types` you are opting into new development behavior.
  // http://fb.me/prop-types-in-prod
  var throwOnDirectAccess = true;
  module.exports = __webpack_require__(/*! ./factoryWithTypeCheckers */ "./node_modules/prop-types/factoryWithTypeCheckers.js")(ReactIs.isElement, throwOnDirectAccess);
} else {}


/***/ }),

/***/ "./node_modules/prop-types/lib/ReactPropTypesSecret.js":
/*!*************************************************************!*\
  !*** ./node_modules/prop-types/lib/ReactPropTypesSecret.js ***!
  \*************************************************************/
/***/ (function(module) {

"use strict";
/**
 * Copyright (c) 2013-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */



var ReactPropTypesSecret = 'SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED';

module.exports = ReactPropTypesSecret;


/***/ }),

/***/ "./node_modules/prop-types/lib/has.js":
/*!********************************************!*\
  !*** ./node_modules/prop-types/lib/has.js ***!
  \********************************************/
/***/ (function(module) {

module.exports = Function.call.bind(Object.prototype.hasOwnProperty);


/***/ }),

/***/ "./node_modules/react-is/cjs/react-is.development.js":
/*!***********************************************************!*\
  !*** ./node_modules/react-is/cjs/react-is.development.js ***!
  \***********************************************************/
/***/ (function(__unused_webpack_module, exports) {

"use strict";
/** @license React v16.13.1
 * react-is.development.js
 *
 * Copyright (c) Facebook, Inc. and its affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */





if (true) {
  (function() {
'use strict';

// The Symbol used to tag the ReactElement-like types. If there is no native Symbol
// nor polyfill, then a plain number is used for performance.
var hasSymbol = typeof Symbol === 'function' && Symbol.for;
var REACT_ELEMENT_TYPE = hasSymbol ? Symbol.for('react.element') : 0xeac7;
var REACT_PORTAL_TYPE = hasSymbol ? Symbol.for('react.portal') : 0xeaca;
var REACT_FRAGMENT_TYPE = hasSymbol ? Symbol.for('react.fragment') : 0xeacb;
var REACT_STRICT_MODE_TYPE = hasSymbol ? Symbol.for('react.strict_mode') : 0xeacc;
var REACT_PROFILER_TYPE = hasSymbol ? Symbol.for('react.profiler') : 0xead2;
var REACT_PROVIDER_TYPE = hasSymbol ? Symbol.for('react.provider') : 0xeacd;
var REACT_CONTEXT_TYPE = hasSymbol ? Symbol.for('react.context') : 0xeace; // TODO: We don't use AsyncMode or ConcurrentMode anymore. They were temporary
// (unstable) APIs that have been removed. Can we remove the symbols?

var REACT_ASYNC_MODE_TYPE = hasSymbol ? Symbol.for('react.async_mode') : 0xeacf;
var REACT_CONCURRENT_MODE_TYPE = hasSymbol ? Symbol.for('react.concurrent_mode') : 0xeacf;
var REACT_FORWARD_REF_TYPE = hasSymbol ? Symbol.for('react.forward_ref') : 0xead0;
var REACT_SUSPENSE_TYPE = hasSymbol ? Symbol.for('react.suspense') : 0xead1;
var REACT_SUSPENSE_LIST_TYPE = hasSymbol ? Symbol.for('react.suspense_list') : 0xead8;
var REACT_MEMO_TYPE = hasSymbol ? Symbol.for('react.memo') : 0xead3;
var REACT_LAZY_TYPE = hasSymbol ? Symbol.for('react.lazy') : 0xead4;
var REACT_BLOCK_TYPE = hasSymbol ? Symbol.for('react.block') : 0xead9;
var REACT_FUNDAMENTAL_TYPE = hasSymbol ? Symbol.for('react.fundamental') : 0xead5;
var REACT_RESPONDER_TYPE = hasSymbol ? Symbol.for('react.responder') : 0xead6;
var REACT_SCOPE_TYPE = hasSymbol ? Symbol.for('react.scope') : 0xead7;

function isValidElementType(type) {
  return typeof type === 'string' || typeof type === 'function' || // Note: its typeof might be other than 'symbol' or 'number' if it's a polyfill.
  type === REACT_FRAGMENT_TYPE || type === REACT_CONCURRENT_MODE_TYPE || type === REACT_PROFILER_TYPE || type === REACT_STRICT_MODE_TYPE || type === REACT_SUSPENSE_TYPE || type === REACT_SUSPENSE_LIST_TYPE || typeof type === 'object' && type !== null && (type.$$typeof === REACT_LAZY_TYPE || type.$$typeof === REACT_MEMO_TYPE || type.$$typeof === REACT_PROVIDER_TYPE || type.$$typeof === REACT_CONTEXT_TYPE || type.$$typeof === REACT_FORWARD_REF_TYPE || type.$$typeof === REACT_FUNDAMENTAL_TYPE || type.$$typeof === REACT_RESPONDER_TYPE || type.$$typeof === REACT_SCOPE_TYPE || type.$$typeof === REACT_BLOCK_TYPE);
}

function typeOf(object) {
  if (typeof object === 'object' && object !== null) {
    var $$typeof = object.$$typeof;

    switch ($$typeof) {
      case REACT_ELEMENT_TYPE:
        var type = object.type;

        switch (type) {
          case REACT_ASYNC_MODE_TYPE:
          case REACT_CONCURRENT_MODE_TYPE:
          case REACT_FRAGMENT_TYPE:
          case REACT_PROFILER_TYPE:
          case REACT_STRICT_MODE_TYPE:
          case REACT_SUSPENSE_TYPE:
            return type;

          default:
            var $$typeofType = type && type.$$typeof;

            switch ($$typeofType) {
              case REACT_CONTEXT_TYPE:
              case REACT_FORWARD_REF_TYPE:
              case REACT_LAZY_TYPE:
              case REACT_MEMO_TYPE:
              case REACT_PROVIDER_TYPE:
                return $$typeofType;

              default:
                return $$typeof;
            }

        }

      case REACT_PORTAL_TYPE:
        return $$typeof;
    }
  }

  return undefined;
} // AsyncMode is deprecated along with isAsyncMode

var AsyncMode = REACT_ASYNC_MODE_TYPE;
var ConcurrentMode = REACT_CONCURRENT_MODE_TYPE;
var ContextConsumer = REACT_CONTEXT_TYPE;
var ContextProvider = REACT_PROVIDER_TYPE;
var Element = REACT_ELEMENT_TYPE;
var ForwardRef = REACT_FORWARD_REF_TYPE;
var Fragment = REACT_FRAGMENT_TYPE;
var Lazy = REACT_LAZY_TYPE;
var Memo = REACT_MEMO_TYPE;
var Portal = REACT_PORTAL_TYPE;
var Profiler = REACT_PROFILER_TYPE;
var StrictMode = REACT_STRICT_MODE_TYPE;
var Suspense = REACT_SUSPENSE_TYPE;
var hasWarnedAboutDeprecatedIsAsyncMode = false; // AsyncMode should be deprecated

function isAsyncMode(object) {
  {
    if (!hasWarnedAboutDeprecatedIsAsyncMode) {
      hasWarnedAboutDeprecatedIsAsyncMode = true; // Using console['warn'] to evade Babel and ESLint

      console['warn']('The ReactIs.isAsyncMode() alias has been deprecated, ' + 'and will be removed in React 17+. Update your code to use ' + 'ReactIs.isConcurrentMode() instead. It has the exact same API.');
    }
  }

  return isConcurrentMode(object) || typeOf(object) === REACT_ASYNC_MODE_TYPE;
}
function isConcurrentMode(object) {
  return typeOf(object) === REACT_CONCURRENT_MODE_TYPE;
}
function isContextConsumer(object) {
  return typeOf(object) === REACT_CONTEXT_TYPE;
}
function isContextProvider(object) {
  return typeOf(object) === REACT_PROVIDER_TYPE;
}
function isElement(object) {
  return typeof object === 'object' && object !== null && object.$$typeof === REACT_ELEMENT_TYPE;
}
function isForwardRef(object) {
  return typeOf(object) === REACT_FORWARD_REF_TYPE;
}
function isFragment(object) {
  return typeOf(object) === REACT_FRAGMENT_TYPE;
}
function isLazy(object) {
  return typeOf(object) === REACT_LAZY_TYPE;
}
function isMemo(object) {
  return typeOf(object) === REACT_MEMO_TYPE;
}
function isPortal(object) {
  return typeOf(object) === REACT_PORTAL_TYPE;
}
function isProfiler(object) {
  return typeOf(object) === REACT_PROFILER_TYPE;
}
function isStrictMode(object) {
  return typeOf(object) === REACT_STRICT_MODE_TYPE;
}
function isSuspense(object) {
  return typeOf(object) === REACT_SUSPENSE_TYPE;
}

exports.AsyncMode = AsyncMode;
exports.ConcurrentMode = ConcurrentMode;
exports.ContextConsumer = ContextConsumer;
exports.ContextProvider = ContextProvider;
exports.Element = Element;
exports.ForwardRef = ForwardRef;
exports.Fragment = Fragment;
exports.Lazy = Lazy;
exports.Memo = Memo;
exports.Portal = Portal;
exports.Profiler = Profiler;
exports.StrictMode = StrictMode;
exports.Suspense = Suspense;
exports.isAsyncMode = isAsyncMode;
exports.isConcurrentMode = isConcurrentMode;
exports.isContextConsumer = isContextConsumer;
exports.isContextProvider = isContextProvider;
exports.isElement = isElement;
exports.isForwardRef = isForwardRef;
exports.isFragment = isFragment;
exports.isLazy = isLazy;
exports.isMemo = isMemo;
exports.isPortal = isPortal;
exports.isProfiler = isProfiler;
exports.isStrictMode = isStrictMode;
exports.isSuspense = isSuspense;
exports.isValidElementType = isValidElementType;
exports.typeOf = typeOf;
  })();
}


/***/ }),

/***/ "./node_modules/react-is/index.js":
/*!****************************************!*\
  !*** ./node_modules/react-is/index.js ***!
  \****************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

"use strict";


if (false) {} else {
  module.exports = __webpack_require__(/*! ./cjs/react-is.development.js */ "./node_modules/react-is/cjs/react-is.development.js");
}


/***/ }),

/***/ "./node_modules/react-tooltip/dist/index.es.js":
/*!*****************************************************!*\
  !*** ./node_modules/react-tooltip/dist/index.es.js ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ ReactTooltip; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var uuid__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! uuid */ "./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/v4.js");




function ownKeys$2(object, enumerableOnly) {
  var keys = Object.keys(object);
  if (Object.getOwnPropertySymbols) {
    var symbols = Object.getOwnPropertySymbols(object);
    enumerableOnly && (symbols = symbols.filter(function (sym) {
      return Object.getOwnPropertyDescriptor(object, sym).enumerable;
    })), keys.push.apply(keys, symbols);
  }
  return keys;
}
function _objectSpread2(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = null != arguments[i] ? arguments[i] : {};
    i % 2 ? ownKeys$2(Object(source), !0).forEach(function (key) {
      _defineProperty(target, key, source[key]);
    }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys$2(Object(source)).forEach(function (key) {
      Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
    });
  }
  return target;
}
function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}
function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}
function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  Object.defineProperty(Constructor, "prototype", {
    writable: false
  });
  return Constructor;
}
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }
  return obj;
}
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
function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }
  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  Object.defineProperty(subClass, "prototype", {
    writable: false
  });
  if (superClass) _setPrototypeOf(subClass, superClass);
}
function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}
function _setPrototypeOf(o, p) {
  _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };
  return _setPrototypeOf(o, p);
}
function _isNativeReflectConstruct() {
  if (typeof Reflect === "undefined" || !Reflect.construct) return false;
  if (Reflect.construct.sham) return false;
  if (typeof Proxy === "function") return true;
  try {
    Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {}));
    return true;
  } catch (e) {
    return false;
  }
}
function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }
  return self;
}
function _possibleConstructorReturn(self, call) {
  if (call && (typeof call === "object" || typeof call === "function")) {
    return call;
  } else if (call !== void 0) {
    throw new TypeError("Derived constructors may only return object or undefined");
  }
  return _assertThisInitialized(self);
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
function _createForOfIteratorHelper(o, allowArrayLike) {
  var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"];
  if (!it) {
    if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") {
      if (it) o = it;
      var i = 0;
      var F = function () {};
      return {
        s: F,
        n: function () {
          if (i >= o.length) return {
            done: true
          };
          return {
            done: false,
            value: o[i++]
          };
        },
        e: function (e) {
          throw e;
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
    s: function () {
      it = it.call(o);
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
    }
  };
}

var commonjsGlobal = typeof globalThis !== 'undefined' ? globalThis : typeof window !== 'undefined' ? window : typeof __webpack_require__.g !== 'undefined' ? __webpack_require__.g : typeof self !== 'undefined' ? self : {};

var check = function (it) {
  return it && it.Math == Math && it;
};

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global$a =
  // eslint-disable-next-line es/no-global-this -- safe
  check(typeof globalThis == 'object' && globalThis) ||
  check(typeof window == 'object' && window) ||
  // eslint-disable-next-line no-restricted-globals -- safe
  check(typeof self == 'object' && self) ||
  check(typeof commonjsGlobal == 'object' && commonjsGlobal) ||
  // eslint-disable-next-line no-new-func -- fallback
  (function () { return this; })() || Function('return this')();

var objectGetOwnPropertyDescriptor = {};

var fails$9 = function (exec) {
  try {
    return !!exec();
  } catch (error) {
    return true;
  }
};

var fails$8 = fails$9;

// Detect IE8's incomplete defineProperty implementation
var descriptors = !fails$8(function () {
  // eslint-disable-next-line es/no-object-defineproperty -- required for testing
  return Object.defineProperty({}, 1, { get: function () { return 7; } })[1] != 7;
});

var fails$7 = fails$9;

var functionBindNative = !fails$7(function () {
  // eslint-disable-next-line es/no-function-prototype-bind -- safe
  var test = (function () { /* empty */ }).bind();
  // eslint-disable-next-line no-prototype-builtins -- safe
  return typeof test != 'function' || test.hasOwnProperty('prototype');
});

var NATIVE_BIND$2 = functionBindNative;

var call$4 = Function.prototype.call;

var functionCall = NATIVE_BIND$2 ? call$4.bind(call$4) : function () {
  return call$4.apply(call$4, arguments);
};

var objectPropertyIsEnumerable = {};

var $propertyIsEnumerable = {}.propertyIsEnumerable;
// eslint-disable-next-line es/no-object-getownpropertydescriptor -- safe
var getOwnPropertyDescriptor$1 = Object.getOwnPropertyDescriptor;

// Nashorn ~ JDK8 bug
var NASHORN_BUG = getOwnPropertyDescriptor$1 && !$propertyIsEnumerable.call({ 1: 2 }, 1);

// `Object.prototype.propertyIsEnumerable` method implementation
// https://tc39.es/ecma262/#sec-object.prototype.propertyisenumerable
objectPropertyIsEnumerable.f = NASHORN_BUG ? function propertyIsEnumerable(V) {
  var descriptor = getOwnPropertyDescriptor$1(this, V);
  return !!descriptor && descriptor.enumerable;
} : $propertyIsEnumerable;

var createPropertyDescriptor$2 = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};

var NATIVE_BIND$1 = functionBindNative;

var FunctionPrototype$1 = Function.prototype;
var call$3 = FunctionPrototype$1.call;
var uncurryThisWithBind = NATIVE_BIND$1 && FunctionPrototype$1.bind.bind(call$3, call$3);

var functionUncurryThisRaw = function (fn) {
  return NATIVE_BIND$1 ? uncurryThisWithBind(fn) : function () {
    return call$3.apply(fn, arguments);
  };
};

var uncurryThisRaw$1 = functionUncurryThisRaw;

var toString$1 = uncurryThisRaw$1({}.toString);
var stringSlice = uncurryThisRaw$1(''.slice);

var classofRaw$2 = function (it) {
  return stringSlice(toString$1(it), 8, -1);
};

var classofRaw$1 = classofRaw$2;
var uncurryThisRaw = functionUncurryThisRaw;

var functionUncurryThis = function (fn) {
  // Nashorn bug:
  //   https://github.com/zloirock/core-js/issues/1128
  //   https://github.com/zloirock/core-js/issues/1130
  if (classofRaw$1(fn) === 'Function') return uncurryThisRaw(fn);
};

var uncurryThis$9 = functionUncurryThis;
var fails$6 = fails$9;
var classof$3 = classofRaw$2;

var $Object$3 = Object;
var split = uncurryThis$9(''.split);

// fallback for non-array-like ES3 and non-enumerable old V8 strings
var indexedObject = fails$6(function () {
  // throws an error in rhino, see https://github.com/mozilla/rhino/issues/346
  // eslint-disable-next-line no-prototype-builtins -- safe
  return !$Object$3('z').propertyIsEnumerable(0);
}) ? function (it) {
  return classof$3(it) == 'String' ? split(it, '') : $Object$3(it);
} : $Object$3;

// we can't use just `it == null` since of `document.all` special case
// https://tc39.es/ecma262/#sec-IsHTMLDDA-internal-slot-aec
var isNullOrUndefined$2 = function (it) {
  return it === null || it === undefined;
};

var isNullOrUndefined$1 = isNullOrUndefined$2;

var $TypeError$5 = TypeError;

// `RequireObjectCoercible` abstract operation
// https://tc39.es/ecma262/#sec-requireobjectcoercible
var requireObjectCoercible$2 = function (it) {
  if (isNullOrUndefined$1(it)) throw $TypeError$5("Can't call method on " + it);
  return it;
};

// toObject with fallback for non-array-like ES3 strings
var IndexedObject$1 = indexedObject;
var requireObjectCoercible$1 = requireObjectCoercible$2;

var toIndexedObject$4 = function (it) {
  return IndexedObject$1(requireObjectCoercible$1(it));
};

var documentAll$2 = typeof document == 'object' && document.all;

// https://tc39.es/ecma262/#sec-IsHTMLDDA-internal-slot
var IS_HTMLDDA = typeof documentAll$2 == 'undefined' && documentAll$2 !== undefined;

var documentAll_1 = {
  all: documentAll$2,
  IS_HTMLDDA: IS_HTMLDDA
};

var $documentAll$1 = documentAll_1;

var documentAll$1 = $documentAll$1.all;

// `IsCallable` abstract operation
// https://tc39.es/ecma262/#sec-iscallable
var isCallable$c = $documentAll$1.IS_HTMLDDA ? function (argument) {
  return typeof argument == 'function' || argument === documentAll$1;
} : function (argument) {
  return typeof argument == 'function';
};

var isCallable$b = isCallable$c;
var $documentAll = documentAll_1;

var documentAll = $documentAll.all;

var isObject$6 = $documentAll.IS_HTMLDDA ? function (it) {
  return typeof it == 'object' ? it !== null : isCallable$b(it) || it === documentAll;
} : function (it) {
  return typeof it == 'object' ? it !== null : isCallable$b(it);
};

var global$9 = global$a;
var isCallable$a = isCallable$c;

var aFunction = function (argument) {
  return isCallable$a(argument) ? argument : undefined;
};

var getBuiltIn$5 = function (namespace, method) {
  return arguments.length < 2 ? aFunction(global$9[namespace]) : global$9[namespace] && global$9[namespace][method];
};

var uncurryThis$8 = functionUncurryThis;

var objectIsPrototypeOf = uncurryThis$8({}.isPrototypeOf);

var getBuiltIn$4 = getBuiltIn$5;

var engineUserAgent = getBuiltIn$4('navigator', 'userAgent') || '';

var global$8 = global$a;
var userAgent = engineUserAgent;

var process = global$8.process;
var Deno = global$8.Deno;
var versions = process && process.versions || Deno && Deno.version;
var v8 = versions && versions.v8;
var match, version;

if (v8) {
  match = v8.split('.');
  // in old Chrome, versions of V8 isn't V8 = Chrome / 10
  // but their correct versions are not interesting for us
  version = match[0] > 0 && match[0] < 4 ? 1 : +(match[0] + match[1]);
}

// BrowserFS NodeJS `process` polyfill incorrectly set `.v8` to `0.0`
// so check `userAgent` even if `.v8` exists, but 0
if (!version && userAgent) {
  match = userAgent.match(/Edge\/(\d+)/);
  if (!match || match[1] >= 74) {
    match = userAgent.match(/Chrome\/(\d+)/);
    if (match) version = +match[1];
  }
}

var engineV8Version = version;

/* eslint-disable es/no-symbol -- required for testing */

var V8_VERSION = engineV8Version;
var fails$5 = fails$9;

// eslint-disable-next-line es/no-object-getownpropertysymbols -- required for testing
var symbolConstructorDetection = !!Object.getOwnPropertySymbols && !fails$5(function () {
  var symbol = Symbol();
  // Chrome 38 Symbol has incorrect toString conversion
  // `get-own-property-symbols` polyfill symbols converted to object are not Symbol instances
  return !String(symbol) || !(Object(symbol) instanceof Symbol) ||
    // Chrome 38-40 symbols are not inherited from DOM collections prototypes to instances
    !Symbol.sham && V8_VERSION && V8_VERSION < 41;
});

/* eslint-disable es/no-symbol -- required for testing */

var NATIVE_SYMBOL$1 = symbolConstructorDetection;

var useSymbolAsUid = NATIVE_SYMBOL$1
  && !Symbol.sham
  && typeof Symbol.iterator == 'symbol';

var getBuiltIn$3 = getBuiltIn$5;
var isCallable$9 = isCallable$c;
var isPrototypeOf = objectIsPrototypeOf;
var USE_SYMBOL_AS_UID$1 = useSymbolAsUid;

var $Object$2 = Object;

var isSymbol$2 = USE_SYMBOL_AS_UID$1 ? function (it) {
  return typeof it == 'symbol';
} : function (it) {
  var $Symbol = getBuiltIn$3('Symbol');
  return isCallable$9($Symbol) && isPrototypeOf($Symbol.prototype, $Object$2(it));
};

var $String$1 = String;

var tryToString$1 = function (argument) {
  try {
    return $String$1(argument);
  } catch (error) {
    return 'Object';
  }
};

var isCallable$8 = isCallable$c;
var tryToString = tryToString$1;

var $TypeError$4 = TypeError;

// `Assert: IsCallable(argument) is true`
var aCallable$2 = function (argument) {
  if (isCallable$8(argument)) return argument;
  throw $TypeError$4(tryToString(argument) + ' is not a function');
};

var aCallable$1 = aCallable$2;
var isNullOrUndefined = isNullOrUndefined$2;

// `GetMethod` abstract operation
// https://tc39.es/ecma262/#sec-getmethod
var getMethod$1 = function (V, P) {
  var func = V[P];
  return isNullOrUndefined(func) ? undefined : aCallable$1(func);
};

var call$2 = functionCall;
var isCallable$7 = isCallable$c;
var isObject$5 = isObject$6;

var $TypeError$3 = TypeError;

// `OrdinaryToPrimitive` abstract operation
// https://tc39.es/ecma262/#sec-ordinarytoprimitive
var ordinaryToPrimitive$1 = function (input, pref) {
  var fn, val;
  if (pref === 'string' && isCallable$7(fn = input.toString) && !isObject$5(val = call$2(fn, input))) return val;
  if (isCallable$7(fn = input.valueOf) && !isObject$5(val = call$2(fn, input))) return val;
  if (pref !== 'string' && isCallable$7(fn = input.toString) && !isObject$5(val = call$2(fn, input))) return val;
  throw $TypeError$3("Can't convert object to primitive value");
};

var shared$3 = {exports: {}};

var global$7 = global$a;

// eslint-disable-next-line es/no-object-defineproperty -- safe
var defineProperty$2 = Object.defineProperty;

var defineGlobalProperty$3 = function (key, value) {
  try {
    defineProperty$2(global$7, key, { value: value, configurable: true, writable: true });
  } catch (error) {
    global$7[key] = value;
  } return value;
};

var global$6 = global$a;
var defineGlobalProperty$2 = defineGlobalProperty$3;

var SHARED = '__core-js_shared__';
var store$3 = global$6[SHARED] || defineGlobalProperty$2(SHARED, {});

var sharedStore = store$3;

var store$2 = sharedStore;

(shared$3.exports = function (key, value) {
  return store$2[key] || (store$2[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: '3.25.5',
  mode: 'global',
  copyright: '© 2014-2022 Denis Pushkarev (zloirock.ru)',
  license: 'https://github.com/zloirock/core-js/blob/v3.25.5/LICENSE',
  source: 'https://github.com/zloirock/core-js'
});

var requireObjectCoercible = requireObjectCoercible$2;

var $Object$1 = Object;

// `ToObject` abstract operation
// https://tc39.es/ecma262/#sec-toobject
var toObject$2 = function (argument) {
  return $Object$1(requireObjectCoercible(argument));
};

var uncurryThis$7 = functionUncurryThis;
var toObject$1 = toObject$2;

var hasOwnProperty = uncurryThis$7({}.hasOwnProperty);

// `HasOwnProperty` abstract operation
// https://tc39.es/ecma262/#sec-hasownproperty
// eslint-disable-next-line es/no-object-hasown -- safe
var hasOwnProperty_1 = Object.hasOwn || function hasOwn(it, key) {
  return hasOwnProperty(toObject$1(it), key);
};

var uncurryThis$6 = functionUncurryThis;

var id = 0;
var postfix = Math.random();
var toString = uncurryThis$6(1.0.toString);

var uid$2 = function (key) {
  return 'Symbol(' + (key === undefined ? '' : key) + ')_' + toString(++id + postfix, 36);
};

var global$5 = global$a;
var shared$2 = shared$3.exports;
var hasOwn$6 = hasOwnProperty_1;
var uid$1 = uid$2;
var NATIVE_SYMBOL = symbolConstructorDetection;
var USE_SYMBOL_AS_UID = useSymbolAsUid;

var WellKnownSymbolsStore = shared$2('wks');
var Symbol$1 = global$5.Symbol;
var symbolFor = Symbol$1 && Symbol$1['for'];
var createWellKnownSymbol = USE_SYMBOL_AS_UID ? Symbol$1 : Symbol$1 && Symbol$1.withoutSetter || uid$1;

var wellKnownSymbol$5 = function (name) {
  if (!hasOwn$6(WellKnownSymbolsStore, name) || !(NATIVE_SYMBOL || typeof WellKnownSymbolsStore[name] == 'string')) {
    var description = 'Symbol.' + name;
    if (NATIVE_SYMBOL && hasOwn$6(Symbol$1, name)) {
      WellKnownSymbolsStore[name] = Symbol$1[name];
    } else if (USE_SYMBOL_AS_UID && symbolFor) {
      WellKnownSymbolsStore[name] = symbolFor(description);
    } else {
      WellKnownSymbolsStore[name] = createWellKnownSymbol(description);
    }
  } return WellKnownSymbolsStore[name];
};

var call$1 = functionCall;
var isObject$4 = isObject$6;
var isSymbol$1 = isSymbol$2;
var getMethod = getMethod$1;
var ordinaryToPrimitive = ordinaryToPrimitive$1;
var wellKnownSymbol$4 = wellKnownSymbol$5;

var $TypeError$2 = TypeError;
var TO_PRIMITIVE = wellKnownSymbol$4('toPrimitive');

// `ToPrimitive` abstract operation
// https://tc39.es/ecma262/#sec-toprimitive
var toPrimitive$1 = function (input, pref) {
  if (!isObject$4(input) || isSymbol$1(input)) return input;
  var exoticToPrim = getMethod(input, TO_PRIMITIVE);
  var result;
  if (exoticToPrim) {
    if (pref === undefined) pref = 'default';
    result = call$1(exoticToPrim, input, pref);
    if (!isObject$4(result) || isSymbol$1(result)) return result;
    throw $TypeError$2("Can't convert object to primitive value");
  }
  if (pref === undefined) pref = 'number';
  return ordinaryToPrimitive(input, pref);
};

var toPrimitive = toPrimitive$1;
var isSymbol = isSymbol$2;

// `ToPropertyKey` abstract operation
// https://tc39.es/ecma262/#sec-topropertykey
var toPropertyKey$2 = function (argument) {
  var key = toPrimitive(argument, 'string');
  return isSymbol(key) ? key : key + '';
};

var global$4 = global$a;
var isObject$3 = isObject$6;

var document$1 = global$4.document;
// typeof document.createElement is 'object' in old IE
var EXISTS$1 = isObject$3(document$1) && isObject$3(document$1.createElement);

var documentCreateElement$1 = function (it) {
  return EXISTS$1 ? document$1.createElement(it) : {};
};

var DESCRIPTORS$7 = descriptors;
var fails$4 = fails$9;
var createElement = documentCreateElement$1;

// Thanks to IE8 for its funny defineProperty
var ie8DomDefine = !DESCRIPTORS$7 && !fails$4(function () {
  // eslint-disable-next-line es/no-object-defineproperty -- required for testing
  return Object.defineProperty(createElement('div'), 'a', {
    get: function () { return 7; }
  }).a != 7;
});

var DESCRIPTORS$6 = descriptors;
var call = functionCall;
var propertyIsEnumerableModule = objectPropertyIsEnumerable;
var createPropertyDescriptor$1 = createPropertyDescriptor$2;
var toIndexedObject$3 = toIndexedObject$4;
var toPropertyKey$1 = toPropertyKey$2;
var hasOwn$5 = hasOwnProperty_1;
var IE8_DOM_DEFINE$1 = ie8DomDefine;

// eslint-disable-next-line es/no-object-getownpropertydescriptor -- safe
var $getOwnPropertyDescriptor$1 = Object.getOwnPropertyDescriptor;

// `Object.getOwnPropertyDescriptor` method
// https://tc39.es/ecma262/#sec-object.getownpropertydescriptor
objectGetOwnPropertyDescriptor.f = DESCRIPTORS$6 ? $getOwnPropertyDescriptor$1 : function getOwnPropertyDescriptor(O, P) {
  O = toIndexedObject$3(O);
  P = toPropertyKey$1(P);
  if (IE8_DOM_DEFINE$1) try {
    return $getOwnPropertyDescriptor$1(O, P);
  } catch (error) { /* empty */ }
  if (hasOwn$5(O, P)) return createPropertyDescriptor$1(!call(propertyIsEnumerableModule.f, O, P), O[P]);
};

var objectDefineProperty = {};

var DESCRIPTORS$5 = descriptors;
var fails$3 = fails$9;

// V8 ~ Chrome 36-
// https://bugs.chromium.org/p/v8/issues/detail?id=3334
var v8PrototypeDefineBug = DESCRIPTORS$5 && fails$3(function () {
  // eslint-disable-next-line es/no-object-defineproperty -- required for testing
  return Object.defineProperty(function () { /* empty */ }, 'prototype', {
    value: 42,
    writable: false
  }).prototype != 42;
});

var isObject$2 = isObject$6;

var $String = String;
var $TypeError$1 = TypeError;

// `Assert: Type(argument) is Object`
var anObject$4 = function (argument) {
  if (isObject$2(argument)) return argument;
  throw $TypeError$1($String(argument) + ' is not an object');
};

var DESCRIPTORS$4 = descriptors;
var IE8_DOM_DEFINE = ie8DomDefine;
var V8_PROTOTYPE_DEFINE_BUG$1 = v8PrototypeDefineBug;
var anObject$3 = anObject$4;
var toPropertyKey = toPropertyKey$2;

var $TypeError = TypeError;
// eslint-disable-next-line es/no-object-defineproperty -- safe
var $defineProperty = Object.defineProperty;
// eslint-disable-next-line es/no-object-getownpropertydescriptor -- safe
var $getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;
var ENUMERABLE = 'enumerable';
var CONFIGURABLE$1 = 'configurable';
var WRITABLE = 'writable';

// `Object.defineProperty` method
// https://tc39.es/ecma262/#sec-object.defineproperty
objectDefineProperty.f = DESCRIPTORS$4 ? V8_PROTOTYPE_DEFINE_BUG$1 ? function defineProperty(O, P, Attributes) {
  anObject$3(O);
  P = toPropertyKey(P);
  anObject$3(Attributes);
  if (typeof O === 'function' && P === 'prototype' && 'value' in Attributes && WRITABLE in Attributes && !Attributes[WRITABLE]) {
    var current = $getOwnPropertyDescriptor(O, P);
    if (current && current[WRITABLE]) {
      O[P] = Attributes.value;
      Attributes = {
        configurable: CONFIGURABLE$1 in Attributes ? Attributes[CONFIGURABLE$1] : current[CONFIGURABLE$1],
        enumerable: ENUMERABLE in Attributes ? Attributes[ENUMERABLE] : current[ENUMERABLE],
        writable: false
      };
    }
  } return $defineProperty(O, P, Attributes);
} : $defineProperty : function defineProperty(O, P, Attributes) {
  anObject$3(O);
  P = toPropertyKey(P);
  anObject$3(Attributes);
  if (IE8_DOM_DEFINE) try {
    return $defineProperty(O, P, Attributes);
  } catch (error) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw $TypeError('Accessors not supported');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};

var DESCRIPTORS$3 = descriptors;
var definePropertyModule$3 = objectDefineProperty;
var createPropertyDescriptor = createPropertyDescriptor$2;

var createNonEnumerableProperty$2 = DESCRIPTORS$3 ? function (object, key, value) {
  return definePropertyModule$3.f(object, key, createPropertyDescriptor(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};

var makeBuiltIn$2 = {exports: {}};

var DESCRIPTORS$2 = descriptors;
var hasOwn$4 = hasOwnProperty_1;

var FunctionPrototype = Function.prototype;
// eslint-disable-next-line es/no-object-getownpropertydescriptor -- safe
var getDescriptor = DESCRIPTORS$2 && Object.getOwnPropertyDescriptor;

var EXISTS = hasOwn$4(FunctionPrototype, 'name');
// additional protection from minified / mangled / dropped function names
var PROPER = EXISTS && (function something() { /* empty */ }).name === 'something';
var CONFIGURABLE = EXISTS && (!DESCRIPTORS$2 || (DESCRIPTORS$2 && getDescriptor(FunctionPrototype, 'name').configurable));

var functionName = {
  EXISTS: EXISTS,
  PROPER: PROPER,
  CONFIGURABLE: CONFIGURABLE
};

var uncurryThis$5 = functionUncurryThis;
var isCallable$6 = isCallable$c;
var store$1 = sharedStore;

var functionToString = uncurryThis$5(Function.toString);

// this helper broken in `core-js@3.4.1-3.4.4`, so we can't use `shared` helper
if (!isCallable$6(store$1.inspectSource)) {
  store$1.inspectSource = function (it) {
    return functionToString(it);
  };
}

var inspectSource$2 = store$1.inspectSource;

var global$3 = global$a;
var isCallable$5 = isCallable$c;

var WeakMap$1 = global$3.WeakMap;

var weakMapBasicDetection = isCallable$5(WeakMap$1) && /native code/.test(String(WeakMap$1));

var shared$1 = shared$3.exports;
var uid = uid$2;

var keys = shared$1('keys');

var sharedKey$2 = function (key) {
  return keys[key] || (keys[key] = uid(key));
};

var hiddenKeys$4 = {};

var NATIVE_WEAK_MAP = weakMapBasicDetection;
var global$2 = global$a;
var isObject$1 = isObject$6;
var createNonEnumerableProperty$1 = createNonEnumerableProperty$2;
var hasOwn$3 = hasOwnProperty_1;
var shared = sharedStore;
var sharedKey$1 = sharedKey$2;
var hiddenKeys$3 = hiddenKeys$4;

var OBJECT_ALREADY_INITIALIZED = 'Object already initialized';
var TypeError$1 = global$2.TypeError;
var WeakMap = global$2.WeakMap;
var set, get, has;

var enforce = function (it) {
  return has(it) ? get(it) : set(it, {});
};

var getterFor = function (TYPE) {
  return function (it) {
    var state;
    if (!isObject$1(it) || (state = get(it)).type !== TYPE) {
      throw TypeError$1('Incompatible receiver, ' + TYPE + ' required');
    } return state;
  };
};

if (NATIVE_WEAK_MAP || shared.state) {
  var store = shared.state || (shared.state = new WeakMap());
  /* eslint-disable no-self-assign -- prototype methods protection */
  store.get = store.get;
  store.has = store.has;
  store.set = store.set;
  /* eslint-enable no-self-assign -- prototype methods protection */
  set = function (it, metadata) {
    if (store.has(it)) throw TypeError$1(OBJECT_ALREADY_INITIALIZED);
    metadata.facade = it;
    store.set(it, metadata);
    return metadata;
  };
  get = function (it) {
    return store.get(it) || {};
  };
  has = function (it) {
    return store.has(it);
  };
} else {
  var STATE = sharedKey$1('state');
  hiddenKeys$3[STATE] = true;
  set = function (it, metadata) {
    if (hasOwn$3(it, STATE)) throw TypeError$1(OBJECT_ALREADY_INITIALIZED);
    metadata.facade = it;
    createNonEnumerableProperty$1(it, STATE, metadata);
    return metadata;
  };
  get = function (it) {
    return hasOwn$3(it, STATE) ? it[STATE] : {};
  };
  has = function (it) {
    return hasOwn$3(it, STATE);
  };
}

var internalState = {
  set: set,
  get: get,
  has: has,
  enforce: enforce,
  getterFor: getterFor
};

var fails$2 = fails$9;
var isCallable$4 = isCallable$c;
var hasOwn$2 = hasOwnProperty_1;
var DESCRIPTORS$1 = descriptors;
var CONFIGURABLE_FUNCTION_NAME = functionName.CONFIGURABLE;
var inspectSource$1 = inspectSource$2;
var InternalStateModule = internalState;

var enforceInternalState = InternalStateModule.enforce;
var getInternalState = InternalStateModule.get;
// eslint-disable-next-line es/no-object-defineproperty -- safe
var defineProperty$1 = Object.defineProperty;

var CONFIGURABLE_LENGTH = DESCRIPTORS$1 && !fails$2(function () {
  return defineProperty$1(function () { /* empty */ }, 'length', { value: 8 }).length !== 8;
});

var TEMPLATE = String(String).split('String');

var makeBuiltIn$1 = makeBuiltIn$2.exports = function (value, name, options) {
  if (String(name).slice(0, 7) === 'Symbol(') {
    name = '[' + String(name).replace(/^Symbol\(([^)]*)\)/, '$1') + ']';
  }
  if (options && options.getter) name = 'get ' + name;
  if (options && options.setter) name = 'set ' + name;
  if (!hasOwn$2(value, 'name') || (CONFIGURABLE_FUNCTION_NAME && value.name !== name)) {
    if (DESCRIPTORS$1) defineProperty$1(value, 'name', { value: name, configurable: true });
    else value.name = name;
  }
  if (CONFIGURABLE_LENGTH && options && hasOwn$2(options, 'arity') && value.length !== options.arity) {
    defineProperty$1(value, 'length', { value: options.arity });
  }
  try {
    if (options && hasOwn$2(options, 'constructor') && options.constructor) {
      if (DESCRIPTORS$1) defineProperty$1(value, 'prototype', { writable: false });
    // in V8 ~ Chrome 53, prototypes of some methods, like `Array.prototype.values`, are non-writable
    } else if (value.prototype) value.prototype = undefined;
  } catch (error) { /* empty */ }
  var state = enforceInternalState(value);
  if (!hasOwn$2(state, 'source')) {
    state.source = TEMPLATE.join(typeof name == 'string' ? name : '');
  } return value;
};

// add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
// eslint-disable-next-line no-extend-native -- required
Function.prototype.toString = makeBuiltIn$1(function toString() {
  return isCallable$4(this) && getInternalState(this).source || inspectSource$1(this);
}, 'toString');

var isCallable$3 = isCallable$c;
var definePropertyModule$2 = objectDefineProperty;
var makeBuiltIn = makeBuiltIn$2.exports;
var defineGlobalProperty$1 = defineGlobalProperty$3;

var defineBuiltIn$1 = function (O, key, value, options) {
  if (!options) options = {};
  var simple = options.enumerable;
  var name = options.name !== undefined ? options.name : key;
  if (isCallable$3(value)) makeBuiltIn(value, name, options);
  if (options.global) {
    if (simple) O[key] = value;
    else defineGlobalProperty$1(key, value);
  } else {
    try {
      if (!options.unsafe) delete O[key];
      else if (O[key]) simple = true;
    } catch (error) { /* empty */ }
    if (simple) O[key] = value;
    else definePropertyModule$2.f(O, key, {
      value: value,
      enumerable: false,
      configurable: !options.nonConfigurable,
      writable: !options.nonWritable
    });
  } return O;
};

var objectGetOwnPropertyNames = {};

var ceil = Math.ceil;
var floor = Math.floor;

// `Math.trunc` method
// https://tc39.es/ecma262/#sec-math.trunc
// eslint-disable-next-line es/no-math-trunc -- safe
var mathTrunc = Math.trunc || function trunc(x) {
  var n = +x;
  return (n > 0 ? floor : ceil)(n);
};

var trunc = mathTrunc;

// `ToIntegerOrInfinity` abstract operation
// https://tc39.es/ecma262/#sec-tointegerorinfinity
var toIntegerOrInfinity$2 = function (argument) {
  var number = +argument;
  // eslint-disable-next-line no-self-compare -- NaN check
  return number !== number || number === 0 ? 0 : trunc(number);
};

var toIntegerOrInfinity$1 = toIntegerOrInfinity$2;

var max = Math.max;
var min$1 = Math.min;

// Helper for a popular repeating case of the spec:
// Let integer be ? ToInteger(index).
// If integer < 0, let result be max((length + integer), 0); else let result be min(integer, length).
var toAbsoluteIndex$1 = function (index, length) {
  var integer = toIntegerOrInfinity$1(index);
  return integer < 0 ? max(integer + length, 0) : min$1(integer, length);
};

var toIntegerOrInfinity = toIntegerOrInfinity$2;

var min = Math.min;

// `ToLength` abstract operation
// https://tc39.es/ecma262/#sec-tolength
var toLength$1 = function (argument) {
  return argument > 0 ? min(toIntegerOrInfinity(argument), 0x1FFFFFFFFFFFFF) : 0; // 2 ** 53 - 1 == 9007199254740991
};

var toLength = toLength$1;

// `LengthOfArrayLike` abstract operation
// https://tc39.es/ecma262/#sec-lengthofarraylike
var lengthOfArrayLike$2 = function (obj) {
  return toLength(obj.length);
};

var toIndexedObject$2 = toIndexedObject$4;
var toAbsoluteIndex = toAbsoluteIndex$1;
var lengthOfArrayLike$1 = lengthOfArrayLike$2;

// `Array.prototype.{ indexOf, includes }` methods implementation
var createMethod$1 = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIndexedObject$2($this);
    var length = lengthOfArrayLike$1(O);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare -- NaN check
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare -- NaN check
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) {
      if ((IS_INCLUDES || index in O) && O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};

var arrayIncludes = {
  // `Array.prototype.includes` method
  // https://tc39.es/ecma262/#sec-array.prototype.includes
  includes: createMethod$1(true),
  // `Array.prototype.indexOf` method
  // https://tc39.es/ecma262/#sec-array.prototype.indexof
  indexOf: createMethod$1(false)
};

var uncurryThis$4 = functionUncurryThis;
var hasOwn$1 = hasOwnProperty_1;
var toIndexedObject$1 = toIndexedObject$4;
var indexOf = arrayIncludes.indexOf;
var hiddenKeys$2 = hiddenKeys$4;

var push$1 = uncurryThis$4([].push);

var objectKeysInternal = function (object, names) {
  var O = toIndexedObject$1(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) !hasOwn$1(hiddenKeys$2, key) && hasOwn$1(O, key) && push$1(result, key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (hasOwn$1(O, key = names[i++])) {
    ~indexOf(result, key) || push$1(result, key);
  }
  return result;
};

// IE8- don't enum bug keys
var enumBugKeys$3 = [
  'constructor',
  'hasOwnProperty',
  'isPrototypeOf',
  'propertyIsEnumerable',
  'toLocaleString',
  'toString',
  'valueOf'
];

var internalObjectKeys$1 = objectKeysInternal;
var enumBugKeys$2 = enumBugKeys$3;

var hiddenKeys$1 = enumBugKeys$2.concat('length', 'prototype');

// `Object.getOwnPropertyNames` method
// https://tc39.es/ecma262/#sec-object.getownpropertynames
// eslint-disable-next-line es/no-object-getownpropertynames -- safe
objectGetOwnPropertyNames.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
  return internalObjectKeys$1(O, hiddenKeys$1);
};

var objectGetOwnPropertySymbols = {};

// eslint-disable-next-line es/no-object-getownpropertysymbols -- safe
objectGetOwnPropertySymbols.f = Object.getOwnPropertySymbols;

var getBuiltIn$2 = getBuiltIn$5;
var uncurryThis$3 = functionUncurryThis;
var getOwnPropertyNamesModule = objectGetOwnPropertyNames;
var getOwnPropertySymbolsModule = objectGetOwnPropertySymbols;
var anObject$2 = anObject$4;

var concat = uncurryThis$3([].concat);

// all object keys, includes non-enumerable and symbols
var ownKeys$1 = getBuiltIn$2('Reflect', 'ownKeys') || function ownKeys(it) {
  var keys = getOwnPropertyNamesModule.f(anObject$2(it));
  var getOwnPropertySymbols = getOwnPropertySymbolsModule.f;
  return getOwnPropertySymbols ? concat(keys, getOwnPropertySymbols(it)) : keys;
};

var hasOwn = hasOwnProperty_1;
var ownKeys = ownKeys$1;
var getOwnPropertyDescriptorModule = objectGetOwnPropertyDescriptor;
var definePropertyModule$1 = objectDefineProperty;

var copyConstructorProperties$1 = function (target, source, exceptions) {
  var keys = ownKeys(source);
  var defineProperty = definePropertyModule$1.f;
  var getOwnPropertyDescriptor = getOwnPropertyDescriptorModule.f;
  for (var i = 0; i < keys.length; i++) {
    var key = keys[i];
    if (!hasOwn(target, key) && !(exceptions && hasOwn(exceptions, key))) {
      defineProperty(target, key, getOwnPropertyDescriptor(source, key));
    }
  }
};

var fails$1 = fails$9;
var isCallable$2 = isCallable$c;

var replacement = /#|\.prototype\./;

var isForced$1 = function (feature, detection) {
  var value = data[normalize(feature)];
  return value == POLYFILL ? true
    : value == NATIVE ? false
    : isCallable$2(detection) ? fails$1(detection)
    : !!detection;
};

var normalize = isForced$1.normalize = function (string) {
  return String(string).replace(replacement, '.').toLowerCase();
};

var data = isForced$1.data = {};
var NATIVE = isForced$1.NATIVE = 'N';
var POLYFILL = isForced$1.POLYFILL = 'P';

var isForced_1 = isForced$1;

var global$1 = global$a;
var getOwnPropertyDescriptor = objectGetOwnPropertyDescriptor.f;
var createNonEnumerableProperty = createNonEnumerableProperty$2;
var defineBuiltIn = defineBuiltIn$1;
var defineGlobalProperty = defineGlobalProperty$3;
var copyConstructorProperties = copyConstructorProperties$1;
var isForced = isForced_1;

/*
  options.target         - name of the target object
  options.global         - target is the global object
  options.stat           - export as static methods of target
  options.proto          - export as prototype methods of target
  options.real           - real prototype method for the `pure` version
  options.forced         - export even if the native feature is available
  options.bind           - bind methods to the target, required for the `pure` version
  options.wrap           - wrap constructors to preventing global pollution, required for the `pure` version
  options.unsafe         - use the simple assignment of property instead of delete + defineProperty
  options.sham           - add a flag to not completely full polyfills
  options.enumerable     - export as enumerable property
  options.dontCallGetSet - prevent calling a getter on target
  options.name           - the .name of the function if it does not match the key
*/
var _export = function (options, source) {
  var TARGET = options.target;
  var GLOBAL = options.global;
  var STATIC = options.stat;
  var FORCED, target, key, targetProperty, sourceProperty, descriptor;
  if (GLOBAL) {
    target = global$1;
  } else if (STATIC) {
    target = global$1[TARGET] || defineGlobalProperty(TARGET, {});
  } else {
    target = (global$1[TARGET] || {}).prototype;
  }
  if (target) for (key in source) {
    sourceProperty = source[key];
    if (options.dontCallGetSet) {
      descriptor = getOwnPropertyDescriptor(target, key);
      targetProperty = descriptor && descriptor.value;
    } else targetProperty = target[key];
    FORCED = isForced(GLOBAL ? key : TARGET + (STATIC ? '.' : '#') + key, options.forced);
    // contained in target
    if (!FORCED && targetProperty !== undefined) {
      if (typeof sourceProperty == typeof targetProperty) continue;
      copyConstructorProperties(sourceProperty, targetProperty);
    }
    // add a flag to not completely full polyfills
    if (options.sham || (targetProperty && targetProperty.sham)) {
      createNonEnumerableProperty(sourceProperty, 'sham', true);
    }
    defineBuiltIn(target, key, sourceProperty, options);
  }
};

var uncurryThis$2 = functionUncurryThis;
var aCallable = aCallable$2;
var NATIVE_BIND = functionBindNative;

var bind$1 = uncurryThis$2(uncurryThis$2.bind);

// optional / simple context binding
var functionBindContext = function (fn, that) {
  aCallable(fn);
  return that === undefined ? fn : NATIVE_BIND ? bind$1(fn, that) : function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};

var classof$2 = classofRaw$2;

// `IsArray` abstract operation
// https://tc39.es/ecma262/#sec-isarray
// eslint-disable-next-line es/no-array-isarray -- safe
var isArray$1 = Array.isArray || function isArray(argument) {
  return classof$2(argument) == 'Array';
};

var wellKnownSymbol$3 = wellKnownSymbol$5;

var TO_STRING_TAG$1 = wellKnownSymbol$3('toStringTag');
var test = {};

test[TO_STRING_TAG$1] = 'z';

var toStringTagSupport = String(test) === '[object z]';

var TO_STRING_TAG_SUPPORT = toStringTagSupport;
var isCallable$1 = isCallable$c;
var classofRaw = classofRaw$2;
var wellKnownSymbol$2 = wellKnownSymbol$5;

var TO_STRING_TAG = wellKnownSymbol$2('toStringTag');
var $Object = Object;

// ES3 wrong here
var CORRECT_ARGUMENTS = classofRaw(function () { return arguments; }()) == 'Arguments';

// fallback for IE11 Script Access Denied error
var tryGet = function (it, key) {
  try {
    return it[key];
  } catch (error) { /* empty */ }
};

// getting tag from ES6+ `Object.prototype.toString`
var classof$1 = TO_STRING_TAG_SUPPORT ? classofRaw : function (it) {
  var O, tag, result;
  return it === undefined ? 'Undefined' : it === null ? 'Null'
    // @@toStringTag case
    : typeof (tag = tryGet(O = $Object(it), TO_STRING_TAG)) == 'string' ? tag
    // builtinTag case
    : CORRECT_ARGUMENTS ? classofRaw(O)
    // ES3 arguments fallback
    : (result = classofRaw(O)) == 'Object' && isCallable$1(O.callee) ? 'Arguments' : result;
};

var uncurryThis$1 = functionUncurryThis;
var fails = fails$9;
var isCallable = isCallable$c;
var classof = classof$1;
var getBuiltIn$1 = getBuiltIn$5;
var inspectSource = inspectSource$2;

var noop = function () { /* empty */ };
var empty = [];
var construct = getBuiltIn$1('Reflect', 'construct');
var constructorRegExp = /^\s*(?:class|function)\b/;
var exec = uncurryThis$1(constructorRegExp.exec);
var INCORRECT_TO_STRING = !constructorRegExp.exec(noop);

var isConstructorModern = function isConstructor(argument) {
  if (!isCallable(argument)) return false;
  try {
    construct(noop, empty, argument);
    return true;
  } catch (error) {
    return false;
  }
};

var isConstructorLegacy = function isConstructor(argument) {
  if (!isCallable(argument)) return false;
  switch (classof(argument)) {
    case 'AsyncFunction':
    case 'GeneratorFunction':
    case 'AsyncGeneratorFunction': return false;
  }
  try {
    // we can't check .prototype since constructors produced by .bind haven't it
    // `Function#toString` throws on some built-it function in some legacy engines
    // (for example, `DOMQuad` and similar in FF41-)
    return INCORRECT_TO_STRING || !!exec(constructorRegExp, inspectSource(argument));
  } catch (error) {
    return true;
  }
};

isConstructorLegacy.sham = true;

// `IsConstructor` abstract operation
// https://tc39.es/ecma262/#sec-isconstructor
var isConstructor$1 = !construct || fails(function () {
  var called;
  return isConstructorModern(isConstructorModern.call)
    || !isConstructorModern(Object)
    || !isConstructorModern(function () { called = true; })
    || called;
}) ? isConstructorLegacy : isConstructorModern;

var isArray = isArray$1;
var isConstructor = isConstructor$1;
var isObject = isObject$6;
var wellKnownSymbol$1 = wellKnownSymbol$5;

var SPECIES = wellKnownSymbol$1('species');
var $Array = Array;

// a part of `ArraySpeciesCreate` abstract operation
// https://tc39.es/ecma262/#sec-arrayspeciescreate
var arraySpeciesConstructor$1 = function (originalArray) {
  var C;
  if (isArray(originalArray)) {
    C = originalArray.constructor;
    // cross-realm fallback
    if (isConstructor(C) && (C === $Array || isArray(C.prototype))) C = undefined;
    else if (isObject(C)) {
      C = C[SPECIES];
      if (C === null) C = undefined;
    }
  } return C === undefined ? $Array : C;
};

var arraySpeciesConstructor = arraySpeciesConstructor$1;

// `ArraySpeciesCreate` abstract operation
// https://tc39.es/ecma262/#sec-arrayspeciescreate
var arraySpeciesCreate$1 = function (originalArray, length) {
  return new (arraySpeciesConstructor(originalArray))(length === 0 ? 0 : length);
};

var bind = functionBindContext;
var uncurryThis = functionUncurryThis;
var IndexedObject = indexedObject;
var toObject = toObject$2;
var lengthOfArrayLike = lengthOfArrayLike$2;
var arraySpeciesCreate = arraySpeciesCreate$1;

var push = uncurryThis([].push);

// `Array.prototype.{ forEach, map, filter, some, every, find, findIndex, filterReject }` methods implementation
var createMethod = function (TYPE) {
  var IS_MAP = TYPE == 1;
  var IS_FILTER = TYPE == 2;
  var IS_SOME = TYPE == 3;
  var IS_EVERY = TYPE == 4;
  var IS_FIND_INDEX = TYPE == 6;
  var IS_FILTER_REJECT = TYPE == 7;
  var NO_HOLES = TYPE == 5 || IS_FIND_INDEX;
  return function ($this, callbackfn, that, specificCreate) {
    var O = toObject($this);
    var self = IndexedObject(O);
    var boundFunction = bind(callbackfn, that);
    var length = lengthOfArrayLike(self);
    var index = 0;
    var create = specificCreate || arraySpeciesCreate;
    var target = IS_MAP ? create($this, length) : IS_FILTER || IS_FILTER_REJECT ? create($this, 0) : undefined;
    var value, result;
    for (;length > index; index++) if (NO_HOLES || index in self) {
      value = self[index];
      result = boundFunction(value, index, O);
      if (TYPE) {
        if (IS_MAP) target[index] = result; // map
        else if (result) switch (TYPE) {
          case 3: return true;              // some
          case 5: return value;             // find
          case 6: return index;             // findIndex
          case 2: push(target, value);      // filter
        } else switch (TYPE) {
          case 4: return false;             // every
          case 7: push(target, value);      // filterReject
        }
      }
    }
    return IS_FIND_INDEX ? -1 : IS_SOME || IS_EVERY ? IS_EVERY : target;
  };
};

var arrayIteration = {
  // `Array.prototype.forEach` method
  // https://tc39.es/ecma262/#sec-array.prototype.foreach
  forEach: createMethod(0),
  // `Array.prototype.map` method
  // https://tc39.es/ecma262/#sec-array.prototype.map
  map: createMethod(1),
  // `Array.prototype.filter` method
  // https://tc39.es/ecma262/#sec-array.prototype.filter
  filter: createMethod(2),
  // `Array.prototype.some` method
  // https://tc39.es/ecma262/#sec-array.prototype.some
  some: createMethod(3),
  // `Array.prototype.every` method
  // https://tc39.es/ecma262/#sec-array.prototype.every
  every: createMethod(4),
  // `Array.prototype.find` method
  // https://tc39.es/ecma262/#sec-array.prototype.find
  find: createMethod(5),
  // `Array.prototype.findIndex` method
  // https://tc39.es/ecma262/#sec-array.prototype.findIndex
  findIndex: createMethod(6),
  // `Array.prototype.filterReject` method
  // https://github.com/tc39/proposal-array-filtering
  filterReject: createMethod(7)
};

var objectDefineProperties = {};

var internalObjectKeys = objectKeysInternal;
var enumBugKeys$1 = enumBugKeys$3;

// `Object.keys` method
// https://tc39.es/ecma262/#sec-object.keys
// eslint-disable-next-line es/no-object-keys -- safe
var objectKeys$1 = Object.keys || function keys(O) {
  return internalObjectKeys(O, enumBugKeys$1);
};

var DESCRIPTORS = descriptors;
var V8_PROTOTYPE_DEFINE_BUG = v8PrototypeDefineBug;
var definePropertyModule = objectDefineProperty;
var anObject$1 = anObject$4;
var toIndexedObject = toIndexedObject$4;
var objectKeys = objectKeys$1;

// `Object.defineProperties` method
// https://tc39.es/ecma262/#sec-object.defineproperties
// eslint-disable-next-line es/no-object-defineproperties -- safe
objectDefineProperties.f = DESCRIPTORS && !V8_PROTOTYPE_DEFINE_BUG ? Object.defineProperties : function defineProperties(O, Properties) {
  anObject$1(O);
  var props = toIndexedObject(Properties);
  var keys = objectKeys(Properties);
  var length = keys.length;
  var index = 0;
  var key;
  while (length > index) definePropertyModule.f(O, key = keys[index++], props[key]);
  return O;
};

var getBuiltIn = getBuiltIn$5;

var html$1 = getBuiltIn('document', 'documentElement');

/* global ActiveXObject -- old IE, WSH */

var anObject = anObject$4;
var definePropertiesModule = objectDefineProperties;
var enumBugKeys = enumBugKeys$3;
var hiddenKeys = hiddenKeys$4;
var html = html$1;
var documentCreateElement = documentCreateElement$1;
var sharedKey = sharedKey$2;

var GT = '>';
var LT = '<';
var PROTOTYPE = 'prototype';
var SCRIPT = 'script';
var IE_PROTO = sharedKey('IE_PROTO');

var EmptyConstructor = function () { /* empty */ };

var scriptTag = function (content) {
  return LT + SCRIPT + GT + content + LT + '/' + SCRIPT + GT;
};

// Create object with fake `null` prototype: use ActiveX Object with cleared prototype
var NullProtoObjectViaActiveX = function (activeXDocument) {
  activeXDocument.write(scriptTag(''));
  activeXDocument.close();
  var temp = activeXDocument.parentWindow.Object;
  activeXDocument = null; // avoid memory leak
  return temp;
};

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var NullProtoObjectViaIFrame = function () {
  // Thrash, waste and sodomy: IE GC bug
  var iframe = documentCreateElement('iframe');
  var JS = 'java' + SCRIPT + ':';
  var iframeDocument;
  iframe.style.display = 'none';
  html.appendChild(iframe);
  // https://github.com/zloirock/core-js/issues/475
  iframe.src = String(JS);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(scriptTag('document.F=Object'));
  iframeDocument.close();
  return iframeDocument.F;
};

// Check for document.domain and active x support
// No need to use active x approach when document.domain is not set
// see https://github.com/es-shims/es5-shim/issues/150
// variation of https://github.com/kitcambridge/es5-shim/commit/4f738ac066346
// avoid IE GC bug
var activeXDocument;
var NullProtoObject = function () {
  try {
    activeXDocument = new ActiveXObject('htmlfile');
  } catch (error) { /* ignore */ }
  NullProtoObject = typeof document != 'undefined'
    ? document.domain && activeXDocument
      ? NullProtoObjectViaActiveX(activeXDocument) // old IE
      : NullProtoObjectViaIFrame()
    : NullProtoObjectViaActiveX(activeXDocument); // WSH
  var length = enumBugKeys.length;
  while (length--) delete NullProtoObject[PROTOTYPE][enumBugKeys[length]];
  return NullProtoObject();
};

hiddenKeys[IE_PROTO] = true;

// `Object.create` method
// https://tc39.es/ecma262/#sec-object.create
// eslint-disable-next-line es/no-object-create -- safe
var objectCreate = Object.create || function create(O, Properties) {
  var result;
  if (O !== null) {
    EmptyConstructor[PROTOTYPE] = anObject(O);
    result = new EmptyConstructor();
    EmptyConstructor[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = NullProtoObject();
  return Properties === undefined ? result : definePropertiesModule.f(result, Properties);
};

var wellKnownSymbol = wellKnownSymbol$5;
var create = objectCreate;
var defineProperty = objectDefineProperty.f;

var UNSCOPABLES = wellKnownSymbol('unscopables');
var ArrayPrototype = Array.prototype;

// Array.prototype[@@unscopables]
// https://tc39.es/ecma262/#sec-array.prototype-@@unscopables
if (ArrayPrototype[UNSCOPABLES] == undefined) {
  defineProperty(ArrayPrototype, UNSCOPABLES, {
    configurable: true,
    value: create(null)
  });
}

// add a key to Array.prototype[@@unscopables]
var addToUnscopables$1 = function (key) {
  ArrayPrototype[UNSCOPABLES][key] = true;
};

var $ = _export;
var $find = arrayIteration.find;
var addToUnscopables = addToUnscopables$1;

var FIND = 'find';
var SKIPS_HOLES = true;

// Shouldn't skip holes
if (FIND in []) Array(1)[FIND](function () { SKIPS_HOLES = false; });

// `Array.prototype.find` method
// https://tc39.es/ecma262/#sec-array.prototype.find
$({ target: 'Array', proto: true, forced: SKIPS_HOLES }, {
  find: function find(callbackfn /* , that = undefined */) {
    return $find(this, callbackfn, arguments.length > 1 ? arguments[1] : undefined);
  }
});

// https://tc39.es/ecma262/#sec-array.prototype-@@unscopables
addToUnscopables(FIND);

var CONSTANT = {
  GLOBAL: {
    HIDE: '__react_tooltip_hide_event',
    REBUILD: '__react_tooltip_rebuild_event',
    SHOW: '__react_tooltip_show_event'
  }
};

/**
 * Static methods for react-tooltip
 */
var dispatchGlobalEvent = function dispatchGlobalEvent(eventName, opts) {
  // Compatible with IE
  // @see http://stackoverflow.com/questions/26596123/internet-explorer-9-10-11-event-constructor-doesnt-work
  // @see https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent/CustomEvent
  var event;
  if (typeof window.CustomEvent === 'function') {
    event = new window.CustomEvent(eventName, {
      detail: opts
    });
  } else {
    event = document.createEvent('Event');
    event.initEvent(eventName, false, true, opts);
  }
  window.dispatchEvent(event);
};
function staticMethods (target) {
  /**
   * Hide all tooltip
   * @trigger ReactTooltip.hide()
   */
  target.hide = function (target) {
    dispatchGlobalEvent(CONSTANT.GLOBAL.HIDE, {
      target: target
    });
  };

  /**
   * Rebuild all tooltip
   * @trigger ReactTooltip.rebuild()
   */
  target.rebuild = function () {
    dispatchGlobalEvent(CONSTANT.GLOBAL.REBUILD);
  };

  /**
   * Show specific tooltip
   * @trigger ReactTooltip.show()
   */
  target.show = function (target) {
    dispatchGlobalEvent(CONSTANT.GLOBAL.SHOW, {
      target: target
    });
  };
  target.prototype.globalRebuild = function () {
    if (this.mount) {
      this.unbindListener();
      this.bindListener();
    }
  };
  target.prototype.globalShow = function (event) {
    if (this.mount) {
      var hasTarget = event && event.detail && event.detail.target && true || false;
      // Create a fake event, specific show will limit the type to `solid`
      // only `float` type cares e.clientX e.clientY
      this.showTooltip({
        currentTarget: hasTarget && event.detail.target
      }, true);
    }
  };
  target.prototype.globalHide = function (event) {
    if (this.mount) {
      var hasTarget = event && event.detail && event.detail.target && true || false;
      this.hideTooltip({
        currentTarget: hasTarget && event.detail.target
      }, hasTarget);
    }
  };
}

/**
 * Events that should be bound to the window
 */
function windowListener (target) {
  target.prototype.bindWindowEvents = function (resizeHide) {
    // ReactTooltip.hide
    window.removeEventListener(CONSTANT.GLOBAL.HIDE, this.globalHide);
    window.addEventListener(CONSTANT.GLOBAL.HIDE, this.globalHide, false);

    // ReactTooltip.rebuild
    window.removeEventListener(CONSTANT.GLOBAL.REBUILD, this.globalRebuild);
    window.addEventListener(CONSTANT.GLOBAL.REBUILD, this.globalRebuild, false);

    // ReactTooltip.show
    window.removeEventListener(CONSTANT.GLOBAL.SHOW, this.globalShow);
    window.addEventListener(CONSTANT.GLOBAL.SHOW, this.globalShow, false);

    // Resize
    if (resizeHide) {
      window.removeEventListener('resize', this.onWindowResize);
      window.addEventListener('resize', this.onWindowResize, false);
    }
  };
  target.prototype.unbindWindowEvents = function () {
    window.removeEventListener(CONSTANT.GLOBAL.HIDE, this.globalHide);
    window.removeEventListener(CONSTANT.GLOBAL.REBUILD, this.globalRebuild);
    window.removeEventListener(CONSTANT.GLOBAL.SHOW, this.globalShow);
    window.removeEventListener('resize', this.onWindowResize);
  };

  /**
   * invoked by resize event of window
   */
  target.prototype.onWindowResize = function () {
    if (!this.mount) return;
    this.hideTooltip();
  };
}

/**
 * Custom events to control showing and hiding of tooltip
 *
 * @attributes
 * - `event` {String}
 * - `eventOff` {String}
 */

var checkStatus = function checkStatus(dataEventOff, e) {
  var show = this.state.show;
  var id = this.props.id;
  var isCapture = this.isCapture(e.currentTarget);
  var currentItem = e.currentTarget.getAttribute('currentItem');
  if (!isCapture) e.stopPropagation();
  if (show && currentItem === 'true') {
    if (!dataEventOff) this.hideTooltip(e);
  } else {
    e.currentTarget.setAttribute('currentItem', 'true');
    setUntargetItems(e.currentTarget, this.getTargetArray(id));
    this.showTooltip(e);
  }
};
var setUntargetItems = function setUntargetItems(currentTarget, targetArray) {
  for (var i = 0; i < targetArray.length; i++) {
    if (currentTarget !== targetArray[i]) {
      targetArray[i].setAttribute('currentItem', 'false');
    } else {
      targetArray[i].setAttribute('currentItem', 'true');
    }
  }
};
var customListeners = {
  id: '9b69f92e-d3fe-498b-b1b4-c5e63a51b0cf',
  set: function set(target, event, listener) {
    if (this.id in target) {
      var map = target[this.id];
      map[event] = listener;
    } else {
      // this is workaround for WeakMap, which is not supported in older browsers, such as IE
      Object.defineProperty(target, this.id, {
        configurable: true,
        value: _defineProperty({}, event, listener)
      });
    }
  },
  get: function get(target, event) {
    var map = target[this.id];
    if (map !== undefined) {
      return map[event];
    }
  }
};
function customEvent (target) {
  target.prototype.isCustomEvent = function (ele) {
    var event = this.state.event;
    return event || !!ele.getAttribute('data-event');
  };

  /* Bind listener for custom event */
  target.prototype.customBindListener = function (ele) {
    var _this = this;
    var _this$state = this.state,
      event = _this$state.event,
      eventOff = _this$state.eventOff;
    var dataEvent = ele.getAttribute('data-event') || event;
    var dataEventOff = ele.getAttribute('data-event-off') || eventOff;
    dataEvent.split(' ').forEach(function (event) {
      ele.removeEventListener(event, customListeners.get(ele, event));
      var customListener = checkStatus.bind(_this, dataEventOff);
      customListeners.set(ele, event, customListener);
      ele.addEventListener(event, customListener, false);
    });
    if (dataEventOff) {
      dataEventOff.split(' ').forEach(function (event) {
        ele.removeEventListener(event, _this.hideTooltip);
        ele.addEventListener(event, _this.hideTooltip, false);
      });
    }
  };

  /* Unbind listener for custom event */
  target.prototype.customUnbindListener = function (ele) {
    var _this$state2 = this.state,
      event = _this$state2.event,
      eventOff = _this$state2.eventOff;
    var dataEvent = event || ele.getAttribute('data-event');
    var dataEventOff = eventOff || ele.getAttribute('data-event-off');
    ele.removeEventListener(dataEvent, customListeners.get(ele, event));
    if (dataEventOff) ele.removeEventListener(dataEventOff, this.hideTooltip);
  };
}

/**
 * Util method to judge if it should follow capture model
 */

function isCapture (target) {
  target.prototype.isCapture = function (currentTarget) {
    return currentTarget && currentTarget.getAttribute('data-iscapture') === 'true' || this.props.isCapture || false;
  };
}

/**
 * Util method to get effect
 */

function getEffect (target) {
  target.prototype.getEffect = function (currentTarget) {
    var dataEffect = currentTarget.getAttribute('data-effect');
    return dataEffect || this.props.effect || 'float';
  };
}

/**
 * Util method to get effect
 */
var makeProxy = function makeProxy(e) {
  var proxy = {};
  for (var key in e) {
    if (typeof e[key] === 'function') {
      proxy[key] = e[key].bind(e);
    } else {
      proxy[key] = e[key];
    }
  }
  return proxy;
};
var bodyListener = function bodyListener(callback, options, e) {
  var _options$respectEffec = options.respectEffect,
    respectEffect = _options$respectEffec === void 0 ? false : _options$respectEffec,
    _options$customEvent = options.customEvent,
    customEvent = _options$customEvent === void 0 ? false : _options$customEvent;
  var id = this.props.id;
  var tip = null;
  var forId;
  var target = e.target;
  var lastTarget;
  // walk up parent chain until tip is found
  // there is no match if parent visible area is matched by mouse position, so some corner cases might not work as expected
  while (tip === null && target !== null) {
    lastTarget = target;
    tip = target.getAttribute('data-tip') || null;
    forId = target.getAttribute('data-for') || null;
    target = target.parentElement;
  }
  target = lastTarget || e.target;
  if (this.isCustomEvent(target) && !customEvent) {
    return;
  }
  var isTargetBelongsToTooltip = id == null && forId == null || forId === id;
  if (tip != null && (!respectEffect || this.getEffect(target) === 'float') && isTargetBelongsToTooltip) {
    var proxy = makeProxy(e);
    proxy.currentTarget = target;
    callback(proxy);
  }
};
var findCustomEvents = function findCustomEvents(targetArray, dataAttribute) {
  var events = {};
  targetArray.forEach(function (target) {
    var event = target.getAttribute(dataAttribute);
    if (event) event.split(' ').forEach(function (event) {
      return events[event] = true;
    });
  });
  return events;
};
var getBody = function getBody() {
  return document.getElementsByTagName('body')[0];
};
function bodyMode (target) {
  target.prototype.isBodyMode = function () {
    return !!this.props.bodyMode;
  };
  target.prototype.bindBodyListener = function (targetArray) {
    var _this = this;
    var _this$state = this.state,
      event = _this$state.event,
      eventOff = _this$state.eventOff,
      possibleCustomEvents = _this$state.possibleCustomEvents,
      possibleCustomEventsOff = _this$state.possibleCustomEventsOff;
    var body = getBody();
    var customEvents = findCustomEvents(targetArray, 'data-event');
    var customEventsOff = findCustomEvents(targetArray, 'data-event-off');
    if (event != null) customEvents[event] = true;
    if (eventOff != null) customEventsOff[eventOff] = true;
    possibleCustomEvents.split(' ').forEach(function (event) {
      return customEvents[event] = true;
    });
    possibleCustomEventsOff.split(' ').forEach(function (event) {
      return customEventsOff[event] = true;
    });
    this.unbindBodyListener(body);
    var listeners = this.bodyModeListeners = {};
    if (event == null) {
      listeners.mouseover = bodyListener.bind(this, this.showTooltip, {});
      listeners.mousemove = bodyListener.bind(this, this.updateTooltip, {
        respectEffect: true
      });
      listeners.mouseout = bodyListener.bind(this, this.hideTooltip, {});
    }
    for (var _event in customEvents) {
      listeners[_event] = bodyListener.bind(this, function (e) {
        var targetEventOff = e.currentTarget.getAttribute('data-event-off') || eventOff;
        checkStatus.call(_this, targetEventOff, e);
      }, {
        customEvent: true
      });
    }
    for (var _event2 in customEventsOff) {
      listeners[_event2] = bodyListener.bind(this, this.hideTooltip, {
        customEvent: true
      });
    }
    for (var _event3 in listeners) {
      body.addEventListener(_event3, listeners[_event3]);
    }
  };
  target.prototype.unbindBodyListener = function (body) {
    body = body || getBody();
    var listeners = this.bodyModeListeners;
    for (var event in listeners) {
      body.removeEventListener(event, listeners[event]);
    }
  };
}

/**
 * Tracking target removing from DOM.
 * It's necessary to hide tooltip when it's target disappears.
 * Otherwise, the tooltip would be shown forever until another target
 * is triggered.
 *
 * If MutationObserver is not available, this feature just doesn't work.
 */

// https://hacks.mozilla.org/2012/05/dom-mutationobserver-reacting-to-dom-changes-without-killing-browser-performance/
var getMutationObserverClass = function getMutationObserverClass() {
  return window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;
};
function trackRemoval (target) {
  target.prototype.bindRemovalTracker = function () {
    var _this = this;
    var MutationObserver = getMutationObserverClass();
    if (MutationObserver == null) return;
    var observer = new MutationObserver(function (mutations) {
      for (var m1 = 0; m1 < mutations.length; m1++) {
        var mutation = mutations[m1];
        for (var m2 = 0; m2 < mutation.removedNodes.length; m2++) {
          var element = mutation.removedNodes[m2];
          if (element === _this.state.currentTarget) {
            _this.hideTooltip();
            return;
          }
        }
      }
    });
    observer.observe(window.document, {
      childList: true,
      subtree: true
    });
    this.removalTracker = observer;
  };
  target.prototype.unbindRemovalTracker = function () {
    if (this.removalTracker) {
      this.removalTracker.disconnect();
      this.removalTracker = null;
    }
  };
}

/**
 * Calculate the position of tooltip
 *
 * @params
 * - `e` {Event} the event of current mouse
 * - `target` {Element} the currentTarget of the event
 * - `node` {DOM} the react-tooltip object
 * - `place` {String} top / right / bottom / left
 * - `effect` {String} float / solid
 * - `offset` {Object} the offset to default position
 *
 * @return {Object}
 * - `isNewState` {Bool} required
 * - `newState` {Object}
 * - `position` {Object} {left: {Number}, top: {Number}}
 */
function getPosition (e, target, node, place, desiredPlace, effect, offset) {
  var _getDimensions = getDimensions(node),
    tipWidth = _getDimensions.width,
    tipHeight = _getDimensions.height;
  var _getDimensions2 = getDimensions(target),
    targetWidth = _getDimensions2.width,
    targetHeight = _getDimensions2.height;
  var _getCurrentOffset = getCurrentOffset(e, target, effect),
    mouseX = _getCurrentOffset.mouseX,
    mouseY = _getCurrentOffset.mouseY;
  var defaultOffset = getDefaultPosition(effect, targetWidth, targetHeight, tipWidth, tipHeight);
  var _calculateOffset = calculateOffset(offset),
    extraOffsetX = _calculateOffset.extraOffsetX,
    extraOffsetY = _calculateOffset.extraOffsetY;
  var windowWidth = window.innerWidth;
  var windowHeight = window.innerHeight;
  var _getParent = getParent(node),
    parentTop = _getParent.parentTop,
    parentLeft = _getParent.parentLeft;

  // Get the edge offset of the tooltip
  var getTipOffsetLeft = function getTipOffsetLeft(place) {
    var offsetX = defaultOffset[place].l;
    return mouseX + offsetX + extraOffsetX;
  };
  var getTipOffsetRight = function getTipOffsetRight(place) {
    var offsetX = defaultOffset[place].r;
    return mouseX + offsetX + extraOffsetX;
  };
  var getTipOffsetTop = function getTipOffsetTop(place) {
    var offsetY = defaultOffset[place].t;
    return mouseY + offsetY + extraOffsetY;
  };
  var getTipOffsetBottom = function getTipOffsetBottom(place) {
    var offsetY = defaultOffset[place].b;
    return mouseY + offsetY + extraOffsetY;
  };

  //
  // Functions to test whether the tooltip's sides are inside
  // the client window for a given orientation p
  //
  //  _____________
  // |             | <-- Right side
  // | p = 'left'  |\
  // |             |/  |\
  // |_____________|   |_\  <-- Mouse
  //      / \           |
  //       |
  //       |
  //  Bottom side
  //
  var outsideLeft = function outsideLeft(p) {
    return getTipOffsetLeft(p) < 0;
  };
  var outsideRight = function outsideRight(p) {
    return getTipOffsetRight(p) > windowWidth;
  };
  var outsideTop = function outsideTop(p) {
    return getTipOffsetTop(p) < 0;
  };
  var outsideBottom = function outsideBottom(p) {
    return getTipOffsetBottom(p) > windowHeight;
  };

  // Check whether the tooltip with orientation p is completely inside the client window
  var outside = function outside(p) {
    return outsideLeft(p) || outsideRight(p) || outsideTop(p) || outsideBottom(p);
  };
  var inside = function inside(p) {
    return !outside(p);
  };
  var placeIsInside = {
    top: inside('top'),
    bottom: inside('bottom'),
    left: inside('left'),
    right: inside('right')
  };
  function choose() {
    var allPlaces = desiredPlace.split(',').concat(place, ['top', 'bottom', 'left', 'right']);
    var _iterator = _createForOfIteratorHelper(allPlaces),
      _step;
    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var d = _step.value;
        if (placeIsInside[d]) return d;
      }
      // if nothing is inside, just use the old place.
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
    return place;
  }
  var chosen = choose();
  var isNewState = false;
  var newPlace;
  if (chosen && chosen !== place) {
    isNewState = true;
    newPlace = chosen;
  }
  if (isNewState) {
    return {
      isNewState: true,
      newState: {
        place: newPlace
      }
    };
  }
  return {
    isNewState: false,
    position: {
      left: parseInt(getTipOffsetLeft(place) - parentLeft, 10),
      top: parseInt(getTipOffsetTop(place) - parentTop, 10)
    }
  };
}
var getDimensions = function getDimensions(node) {
  var _node$getBoundingClie = node.getBoundingClientRect(),
    height = _node$getBoundingClie.height,
    width = _node$getBoundingClie.width;
  return {
    height: parseInt(height, 10),
    width: parseInt(width, 10)
  };
};

// Get current mouse offset
var getCurrentOffset = function getCurrentOffset(e, currentTarget, effect) {
  var boundingClientRect = currentTarget.getBoundingClientRect();
  var targetTop = boundingClientRect.top;
  var targetLeft = boundingClientRect.left;
  var _getDimensions3 = getDimensions(currentTarget),
    targetWidth = _getDimensions3.width,
    targetHeight = _getDimensions3.height;
  if (effect === 'float') {
    return {
      mouseX: e.clientX,
      mouseY: e.clientY
    };
  }
  return {
    mouseX: targetLeft + targetWidth / 2,
    mouseY: targetTop + targetHeight / 2
  };
};

// List all possibility of tooltip final offset
// This is useful in judging if it is necessary for tooltip to switch position when out of window
var getDefaultPosition = function getDefaultPosition(effect, targetWidth, targetHeight, tipWidth, tipHeight) {
  var top;
  var right;
  var bottom;
  var left;
  var disToMouse = 3;
  var triangleHeight = 2;
  var cursorHeight = 12; // Optimize for float bottom only, cause the cursor will hide the tooltip

  if (effect === 'float') {
    top = {
      l: -(tipWidth / 2),
      r: tipWidth / 2,
      t: -(tipHeight + disToMouse + triangleHeight),
      b: -disToMouse
    };
    bottom = {
      l: -(tipWidth / 2),
      r: tipWidth / 2,
      t: disToMouse + cursorHeight,
      b: tipHeight + disToMouse + triangleHeight + cursorHeight
    };
    left = {
      l: -(tipWidth + disToMouse + triangleHeight),
      r: -disToMouse,
      t: -(tipHeight / 2),
      b: tipHeight / 2
    };
    right = {
      l: disToMouse,
      r: tipWidth + disToMouse + triangleHeight,
      t: -(tipHeight / 2),
      b: tipHeight / 2
    };
  } else if (effect === 'solid') {
    top = {
      l: -(tipWidth / 2),
      r: tipWidth / 2,
      t: -(targetHeight / 2 + tipHeight + triangleHeight),
      b: -(targetHeight / 2)
    };
    bottom = {
      l: -(tipWidth / 2),
      r: tipWidth / 2,
      t: targetHeight / 2,
      b: targetHeight / 2 + tipHeight + triangleHeight
    };
    left = {
      l: -(tipWidth + targetWidth / 2 + triangleHeight),
      r: -(targetWidth / 2),
      t: -(tipHeight / 2),
      b: tipHeight / 2
    };
    right = {
      l: targetWidth / 2,
      r: tipWidth + targetWidth / 2 + triangleHeight,
      t: -(tipHeight / 2),
      b: tipHeight / 2
    };
  }
  return {
    top: top,
    bottom: bottom,
    left: left,
    right: right
  };
};

// Consider additional offset into position calculation
var calculateOffset = function calculateOffset(offset) {
  var extraOffsetX = 0;
  var extraOffsetY = 0;
  if (Object.prototype.toString.apply(offset) === '[object String]') {
    offset = JSON.parse(offset.toString().replace(/'/g, '"'));
  }
  for (var key in offset) {
    if (key === 'top') {
      extraOffsetY -= parseInt(offset[key], 10);
    } else if (key === 'bottom') {
      extraOffsetY += parseInt(offset[key], 10);
    } else if (key === 'left') {
      extraOffsetX -= parseInt(offset[key], 10);
    } else if (key === 'right') {
      extraOffsetX += parseInt(offset[key], 10);
    }
  }
  return {
    extraOffsetX: extraOffsetX,
    extraOffsetY: extraOffsetY
  };
};

// Get the offset of the parent elements
var getParent = function getParent(currentTarget) {
  var currentParent = currentTarget;
  while (currentParent) {
    var computedStyle = window.getComputedStyle(currentParent);
    // transform and will-change: transform change the containing block
    // https://developer.mozilla.org/en-US/docs/Web/CSS/Containing_Block
    if (computedStyle.getPropertyValue('transform') !== 'none' || computedStyle.getPropertyValue('will-change') === 'transform') break;
    currentParent = currentParent.parentElement;
  }
  var parentTop = currentParent && currentParent.getBoundingClientRect().top || 0;
  var parentLeft = currentParent && currentParent.getBoundingClientRect().left || 0;
  return {
    parentTop: parentTop,
    parentLeft: parentLeft
  };
};

/**
 * To get the tooltip content
 * it may comes from data-tip or this.props.children
 * it should support multiline
 *
 * @params
 * - `tip` {String} value of data-tip
 * - `children` {ReactElement} this.props.children
 * - `multiline` {Any} could be Bool(true/false) or String('true'/'false')
 *
 * @return
 * - String or react component
 */
function TipContent(tip, children, getContent, multiline) {
  if (children) return children;
  if (getContent !== undefined && getContent !== null) return getContent; // getContent can be 0, '', etc.
  if (getContent === null) return null; // Tip not exist and children is null or undefined

  var regexp = /<br\s*\/?>/;
  if (!multiline || multiline === 'false' || !regexp.test(tip)) {
    // No trim(), so that user can keep their input
    return tip;
  }

  // Multiline tooltip content
  return tip.split(regexp).map(function (d, i) {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("span", {
      key: i,
      className: "multi-line"
    }, d);
  });
}

/**
 * Support aria- and role in ReactTooltip
 *
 * @params props {Object}
 * @return {Object}
 */
function parseAria(props) {
  var ariaObj = {};
  Object.keys(props).filter(function (prop) {
    // aria-xxx and role is acceptable
    return /(^aria-\w+$|^role$)/.test(prop);
  }).forEach(function (prop) {
    ariaObj[prop] = props[prop];
  });
  return ariaObj;
}

/**
 * Convert nodelist to array
 * @see https://github.com/facebook/fbjs/blob/e66ba20ad5be433eb54423f2b097d829324d9de6/packages/fbjs/src/core/createArrayFromMixed.js#L24
 * NodeLists are functions in Safari
 */

function nodeListToArray (nodeList) {
  var length = nodeList.length;
  if (nodeList.hasOwnProperty) {
    return Array.prototype.slice.call(nodeList);
  }
  return new Array(length).fill().map(function (index) {
    return nodeList[index];
  });
}

function generateUUID() {
  return 't' + (0,uuid__WEBPACK_IMPORTED_MODULE_1__["default"])();
}

var baseCss = ".__react_component_tooltip {\n  border-radius: 3px;\n  display: inline-block;\n  font-size: 13px;\n  left: -999em;\n  opacity: 0;\n  position: fixed;\n  pointer-events: none;\n  transition: opacity 0.3s ease-out;\n  top: -999em;\n  visibility: hidden;\n  z-index: 999;\n}\n.__react_component_tooltip.allow_hover, .__react_component_tooltip.allow_click {\n  pointer-events: auto;\n}\n.__react_component_tooltip::before, .__react_component_tooltip::after {\n  content: \"\";\n  width: 0;\n  height: 0;\n  position: absolute;\n}\n.__react_component_tooltip.show {\n  opacity: 0.9;\n  margin-top: 0;\n  margin-left: 0;\n  visibility: visible;\n}\n.__react_component_tooltip.place-top::before {\n  bottom: 0;\n  left: 50%;\n  margin-left: -11px;\n}\n.__react_component_tooltip.place-bottom::before {\n  top: 0;\n  left: 50%;\n  margin-left: -11px;\n}\n.__react_component_tooltip.place-left::before {\n  right: 0;\n  top: 50%;\n  margin-top: -9px;\n}\n.__react_component_tooltip.place-right::before {\n  left: 0;\n  top: 50%;\n  margin-top: -9px;\n}\n.__react_component_tooltip .multi-line {\n  display: block;\n  padding: 2px 0;\n  text-align: center;\n}";

/**
 * Default pop-up style values (text color, background color).
 */
var defaultColors = {
  dark: {
    text: '#fff',
    background: '#222',
    border: 'transparent',
    arrow: '#222'
  },
  success: {
    text: '#fff',
    background: '#8DC572',
    border: 'transparent',
    arrow: '#8DC572'
  },
  warning: {
    text: '#fff',
    background: '#F0AD4E',
    border: 'transparent',
    arrow: '#F0AD4E'
  },
  error: {
    text: '#fff',
    background: '#BE6464',
    border: 'transparent',
    arrow: '#BE6464'
  },
  info: {
    text: '#fff',
    background: '#337AB7',
    border: 'transparent',
    arrow: '#337AB7'
  },
  light: {
    text: '#222',
    background: '#fff',
    border: 'transparent',
    arrow: '#fff'
  }
};
function getDefaultPopupColors(type) {
  return defaultColors[type] ? _objectSpread2({}, defaultColors[type]) : undefined;
}
var DEFAULT_PADDING = '8px 21px';
var DEFAULT_RADIUS = {
  tooltip: 3,
  arrow: 0
};

/**
 * Generates the specific tooltip style for use on render.
 */
function generateTooltipStyle(uuid, customColors, type, hasBorder, padding, radius) {
  return generateStyle(uuid, getPopupColors(customColors, type, hasBorder), padding, radius);
}

/**
 * Generates the tooltip style rules based on the element-specified "data-type" property.
 */
function generateStyle(uuid, colors) {
  var padding = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : DEFAULT_PADDING;
  var radius = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : DEFAULT_RADIUS;
  var textColor = colors.text;
  var backgroundColor = colors.background;
  var borderColor = colors.border;
  var arrowColor = colors.arrow;
  var arrowRadius = radius.arrow;
  var tooltipRadius = radius.tooltip;
  return "\n  \t.".concat(uuid, " {\n\t    color: ").concat(textColor, ";\n\t    background: ").concat(backgroundColor, ";\n\t    border: 1px solid ").concat(borderColor, ";\n\t    border-radius: ").concat(tooltipRadius, "px;\n\t    padding: ").concat(padding, ";\n  \t}\n\n  \t.").concat(uuid, ".place-top {\n        margin-top: -10px;\n    }\n    .").concat(uuid, ".place-top::before {\n        content: \"\";\n        background-color: inherit;\n        position: absolute;\n        z-index: 2;\n        width: 20px;\n        height: 12px;\n    }\n    .").concat(uuid, ".place-top::after {\n        content: \"\";\n        position: absolute;\n        width: 10px;\n        height: 10px;\n        border-top-right-radius: ").concat(arrowRadius, "px;\n        border: 1px solid ").concat(borderColor, ";\n        background-color: ").concat(arrowColor, ";\n        z-index: -2;\n        bottom: -6px;\n        left: 50%;\n        margin-left: -6px;\n        transform: rotate(135deg);\n    }\n\n    .").concat(uuid, ".place-bottom {\n        margin-top: 10px;\n    }\n    .").concat(uuid, ".place-bottom::before {\n        content: \"\";\n        background-color: inherit;\n        position: absolute;\n        z-index: -1;\n        width: 18px;\n        height: 10px;\n    }\n    .").concat(uuid, ".place-bottom::after {\n        content: \"\";\n        position: absolute;\n        width: 10px;\n        height: 10px;\n        border-top-right-radius: ").concat(arrowRadius, "px;\n        border: 1px solid ").concat(borderColor, ";\n        background-color: ").concat(arrowColor, ";\n        z-index: -2;\n        top: -6px;\n        left: 50%;\n        margin-left: -6px;\n        transform: rotate(45deg);\n    }\n\n    .").concat(uuid, ".place-left {\n        margin-left: -10px;\n    }\n    .").concat(uuid, ".place-left::before {\n        content: \"\";\n        background-color: inherit;\n        position: absolute;\n        z-index: -1;\n        width: 10px;\n        height: 18px;\n    }\n    .").concat(uuid, ".place-left::after {\n        content: \"\";\n        position: absolute;\n        width: 10px;\n        height: 10px;\n        border-top-right-radius: ").concat(arrowRadius, "px;\n        border: 1px solid ").concat(borderColor, ";\n        background-color: ").concat(arrowColor, ";\n        z-index: -2;\n        right: -6px;\n        top: 50%;\n        margin-top: -6px;\n        transform: rotate(45deg);\n    }\n\n    .").concat(uuid, ".place-right {\n        margin-left: 10px;\n    }\n    .").concat(uuid, ".place-right::before {\n        content: \"\";\n        background-color: inherit;\n        position: absolute;\n        z-index: -1;\n        width: 10px;\n        height: 18px;\n    }\n    .").concat(uuid, ".place-right::after {\n        content: \"\";\n        position: absolute;\n        width: 10px;\n        height: 10px;\n        border-top-right-radius: ").concat(arrowRadius, "px;\n        border: 1px solid ").concat(borderColor, ";\n        background-color: ").concat(arrowColor, ";\n        z-index: -2;\n        left: -6px;\n        top: 50%;\n        margin-top: -6px;\n        transform: rotate(-135deg);\n    }\n  ");
}
function getPopupColors(customColors, type, hasBorder) {
  var textColor = customColors.text;
  var backgroundColor = customColors.background;
  var borderColor = customColors.border;
  var arrowColor = customColors.arrow ? customColors.arrow : customColors.background;
  var colors = getDefaultPopupColors(type);
  if (textColor) {
    colors.text = textColor;
  }
  if (backgroundColor) {
    colors.background = backgroundColor;
  }
  if (hasBorder) {
    if (borderColor) {
      colors.border = borderColor;
    } else {
      colors.border = type === 'light' ? 'black' : 'white';
    }
  }
  if (arrowColor) {
    colors.arrow = arrowColor;
  }
  return colors;
}

var _class, _class2;

/* Polyfill */
var ReactTooltip = staticMethods(_class = windowListener(_class = customEvent(_class = isCapture(_class = getEffect(_class = bodyMode(_class = trackRemoval(_class = (_class2 = /*#__PURE__*/function (_React$Component) {
  _inherits(ReactTooltip, _React$Component);
  var _super = _createSuper(ReactTooltip);
  function ReactTooltip(props) {
    var _this;
    _classCallCheck(this, ReactTooltip);
    _this = _super.call(this, props);
    _this.state = {
      uuid: props.uuid || generateUUID(),
      place: props.place || 'top',
      // Direction of tooltip
      desiredPlace: props.place || 'top',
      type: props.type || 'dark',
      // Color theme of tooltip
      effect: props.effect || 'float',
      // float or fixed
      show: false,
      border: false,
      borderClass: 'border',
      customColors: {},
      customRadius: {},
      offset: {},
      padding: props.padding,
      extraClass: '',
      html: false,
      delayHide: 0,
      delayShow: 0,
      event: props.event || null,
      eventOff: props.eventOff || null,
      currentEvent: null,
      // Current mouse event
      currentTarget: null,
      // Current target of mouse event
      ariaProps: parseAria(props),
      // aria- and role attributes
      isEmptyTip: false,
      disable: false,
      possibleCustomEvents: props.possibleCustomEvents || '',
      possibleCustomEventsOff: props.possibleCustomEventsOff || '',
      originTooltip: null,
      isMultiline: false
    };
    _this.bind(['showTooltip', 'updateTooltip', 'hideTooltip', 'hideTooltipOnScroll', 'getTooltipContent', 'globalRebuild', 'globalShow', 'globalHide', 'onWindowResize', 'mouseOnToolTip']);
    _this.mount = true;
    _this.delayShowLoop = null;
    _this.delayHideLoop = null;
    _this.delayReshow = null;
    _this.intervalUpdateContent = null;
    return _this;
  }

  /**
   * For unify the bind and unbind listener
   */
  _createClass(ReactTooltip, [{
    key: "bind",
    value: function bind(methodArray) {
      var _this2 = this;
      methodArray.forEach(function (method) {
        _this2[method] = _this2[method].bind(_this2);
      });
    }
  }, {
    key: "componentDidMount",
    value: function componentDidMount() {
      var _this$props = this.props;
        _this$props.insecure;
        var resizeHide = _this$props.resizeHide,
        disableInternalStyle = _this$props.disableInternalStyle;
      this.mount = true;
      this.bindListener(); // Bind listener for tooltip
      this.bindWindowEvents(resizeHide); // Bind global event for static method

      if (!disableInternalStyle) {
        this.injectStyles(); // Inject styles for each DOM root having tooltip.
      }
    }
  }, {
    key: "componentWillUnmount",
    value: function componentWillUnmount() {
      this.mount = false;
      this.clearTimer();
      this.unbindListener();
      this.removeScrollListener(this.state.currentTarget);
      this.unbindWindowEvents();
    }

    /* Look for the closest DOM root having tooltip and inject styles. */
  }, {
    key: "injectStyles",
    value: function injectStyles() {
      var tooltipRef = this.tooltipRef;
      if (!tooltipRef) {
        return;
      }
      var parentNode = tooltipRef.parentNode;
      while (parentNode.parentNode) {
        parentNode = parentNode.parentNode;
      }
      var domRoot;
      switch (parentNode.constructor.name) {
        case 'Document':
        case 'HTMLDocument':
        case undefined:
          domRoot = parentNode.head;
          break;
        case 'ShadowRoot':
        default:
          domRoot = parentNode;
          break;
      }

      // Prevent styles duplication.
      if (!domRoot.querySelector('style[data-react-tooltip]')) {
        var style = document.createElement('style');
        style.textContent = baseCss;
        style.setAttribute('data-react-tooltip', 'true');
        domRoot.appendChild(style);
      }
    }

    /**
     * Return if the mouse is on the tooltip.
     * @returns {boolean} true - mouse is on the tooltip
     */
  }, {
    key: "mouseOnToolTip",
    value: function mouseOnToolTip() {
      var show = this.state.show;
      if (show && this.tooltipRef) {
        /* old IE or Firefox work around */
        if (!this.tooltipRef.matches) {
          /* old IE work around */
          if (this.tooltipRef.msMatchesSelector) {
            this.tooltipRef.matches = this.tooltipRef.msMatchesSelector;
          } else {
            /* old Firefox work around */
            this.tooltipRef.matches = this.tooltipRef.mozMatchesSelector;
          }
        }
        return this.tooltipRef.matches(':hover');
      }
      return false;
    }

    /**
     * Pick out corresponded target elements
     */
  }, {
    key: "getTargetArray",
    value: function getTargetArray(id) {
      var targetArray = [];
      var selector;
      if (!id) {
        selector = '[data-tip]:not([data-for])';
      } else {
        var escaped = id.replace(/\\/g, '\\\\').replace(/"/g, '\\"');
        selector = "[data-tip][data-for=\"".concat(escaped, "\"]");
      }

      // Scan document for shadow DOM elements
      nodeListToArray(document.getElementsByTagName('*')).filter(function (element) {
        return element.shadowRoot;
      }).forEach(function (element) {
        targetArray = targetArray.concat(nodeListToArray(element.shadowRoot.querySelectorAll(selector)));
      });
      return targetArray.concat(nodeListToArray(document.querySelectorAll(selector)));
    }

    /**
     * Bind listener to the target elements
     * These listeners used to trigger showing or hiding the tooltip
     */
  }, {
    key: "bindListener",
    value: function bindListener() {
      var _this3 = this;
      var _this$props2 = this.props,
        id = _this$props2.id,
        globalEventOff = _this$props2.globalEventOff,
        isCapture = _this$props2.isCapture;
      var targetArray = this.getTargetArray(id);
      targetArray.forEach(function (target) {
        if (target.getAttribute('currentItem') === null) {
          target.setAttribute('currentItem', 'false');
        }
        _this3.unbindBasicListener(target);
        if (_this3.isCustomEvent(target)) {
          _this3.customUnbindListener(target);
        }
      });
      if (this.isBodyMode()) {
        this.bindBodyListener(targetArray);
      } else {
        targetArray.forEach(function (target) {
          var isCaptureMode = _this3.isCapture(target);
          var effect = _this3.getEffect(target);
          if (_this3.isCustomEvent(target)) {
            _this3.customBindListener(target);
            return;
          }
          target.addEventListener('mouseenter', _this3.showTooltip, isCaptureMode);
          target.addEventListener('focus', _this3.showTooltip, isCaptureMode);
          if (effect === 'float') {
            target.addEventListener('mousemove', _this3.updateTooltip, isCaptureMode);
          }
          target.addEventListener('mouseleave', _this3.hideTooltip, isCaptureMode);
          target.addEventListener('blur', _this3.hideTooltip, isCaptureMode);
        });
      }

      // Global event to hide tooltip
      if (globalEventOff) {
        window.removeEventListener(globalEventOff, this.hideTooltip);
        window.addEventListener(globalEventOff, this.hideTooltip, isCapture);
      }

      // Track removal of targetArray elements from DOM
      this.bindRemovalTracker();
    }

    /**
     * Unbind listeners on target elements
     */
  }, {
    key: "unbindListener",
    value: function unbindListener() {
      var _this4 = this;
      var _this$props3 = this.props,
        id = _this$props3.id,
        globalEventOff = _this$props3.globalEventOff;
      if (this.isBodyMode()) {
        this.unbindBodyListener();
      } else {
        var targetArray = this.getTargetArray(id);
        targetArray.forEach(function (target) {
          _this4.unbindBasicListener(target);
          if (_this4.isCustomEvent(target)) _this4.customUnbindListener(target);
        });
      }
      if (globalEventOff) window.removeEventListener(globalEventOff, this.hideTooltip);
      this.unbindRemovalTracker();
    }

    /**
     * Invoke this before bind listener and unmount the component
     * it is necessary to invoke this even when binding custom event
     * so that the tooltip can switch between custom and default listener
     */
  }, {
    key: "unbindBasicListener",
    value: function unbindBasicListener(target) {
      var isCaptureMode = this.isCapture(target);
      target.removeEventListener('mouseenter', this.showTooltip, isCaptureMode);
      target.removeEventListener('mousemove', this.updateTooltip, isCaptureMode);
      target.removeEventListener('mouseleave', this.hideTooltip, isCaptureMode);
    }
  }, {
    key: "getTooltipContent",
    value: function getTooltipContent() {
      var _this$props4 = this.props,
        getContent = _this$props4.getContent,
        children = _this$props4.children;

      // Generate tooltip content
      var content;
      if (getContent) {
        if (Array.isArray(getContent)) {
          content = getContent[0] && getContent[0](this.state.originTooltip);
        } else {
          content = getContent(this.state.originTooltip);
        }
      }
      return TipContent(this.state.originTooltip, children, content, this.state.isMultiline);
    }
  }, {
    key: "isEmptyTip",
    value: function isEmptyTip(placeholder) {
      return typeof placeholder === 'string' && placeholder === '' || placeholder === null;
    }

    /**
     * When mouse enter, show the tooltip
     */
  }, {
    key: "showTooltip",
    value: function showTooltip(e, isGlobalCall) {
      if (!this.tooltipRef) {
        return;
      }
      if (isGlobalCall) {
        // Don't trigger other elements belongs to other ReactTooltip
        var targetArray = this.getTargetArray(this.props.id);
        var isMyElement = targetArray.some(function (ele) {
          return ele === e.currentTarget;
        });
        if (!isMyElement) return;
      }
      // Get the tooltip content
      // calculate in this phrase so that tip width height can be detected
      var _this$props5 = this.props,
        multiline = _this$props5.multiline,
        getContent = _this$props5.getContent;
      var originTooltip = e.currentTarget.getAttribute('data-tip');
      var isMultiline = e.currentTarget.getAttribute('data-multiline') || multiline || false;

      // If it is focus event or called by ReactTooltip.show, switch to `solid` effect
      var switchToSolid = e instanceof window.FocusEvent || isGlobalCall;

      // if it needs to skip adding hide listener to scroll
      var scrollHide = true;
      if (e.currentTarget.getAttribute('data-scroll-hide')) {
        scrollHide = e.currentTarget.getAttribute('data-scroll-hide') === 'true';
      } else if (this.props.scrollHide != null) {
        scrollHide = this.props.scrollHide;
      }

      // adding aria-describedby to target to make tooltips read by screen readers
      if (e && e.currentTarget && e.currentTarget.setAttribute) {
        e.currentTarget.setAttribute('aria-describedby', this.props.id || this.state.uuid);
      }

      // Make sure the correct place is set
      var desiredPlace = e.currentTarget.getAttribute('data-place') || this.props.place || 'top';
      var effect = switchToSolid && 'solid' || this.getEffect(e.currentTarget);
      var offset = e.currentTarget.getAttribute('data-offset') || this.props.offset || {};
      var result = getPosition(e, e.currentTarget, this.tooltipRef, desiredPlace.split(',')[0], desiredPlace, effect, offset);
      if (result.position && this.props.overridePosition) {
        result.position = this.props.overridePosition(result.position, e, e.currentTarget, this.tooltipRef, desiredPlace, desiredPlace, effect, offset);
      }
      var place = result.isNewState ? result.newState.place : desiredPlace.split(',')[0];

      // To prevent previously created timers from triggering
      this.clearTimer();
      var target = e.currentTarget;
      var reshowDelay = this.state.show ? target.getAttribute('data-delay-update') || this.props.delayUpdate : 0;
      var self = this;
      var updateState = function updateState() {
        self.setState({
          originTooltip: originTooltip,
          isMultiline: isMultiline,
          desiredPlace: desiredPlace,
          place: place,
          type: target.getAttribute('data-type') || self.props.type || 'dark',
          customColors: {
            text: target.getAttribute('data-text-color') || self.props.textColor || null,
            background: target.getAttribute('data-background-color') || self.props.backgroundColor || null,
            border: target.getAttribute('data-border-color') || self.props.borderColor || null,
            arrow: target.getAttribute('data-arrow-color') || self.props.arrowColor || null
          },
          customRadius: {
            tooltip: target.getAttribute('data-tooltip-radius') || self.props.tooltipRadius || '3',
            arrow: target.getAttribute('data-arrow-radius') || self.props.arrowRadius || '0'
          },
          effect: effect,
          offset: offset,
          padding: target.getAttribute('data-padding') || self.props.padding,
          html: (target.getAttribute('data-html') ? target.getAttribute('data-html') === 'true' : self.props.html) || false,
          delayShow: target.getAttribute('data-delay-show') || self.props.delayShow || 0,
          delayHide: target.getAttribute('data-delay-hide') || self.props.delayHide || 0,
          delayUpdate: target.getAttribute('data-delay-update') || self.props.delayUpdate || 0,
          border: (target.getAttribute('data-border') ? target.getAttribute('data-border') === 'true' : self.props.border) || false,
          borderClass: target.getAttribute('data-border-class') || self.props.borderClass || 'border',
          extraClass: target.getAttribute('data-class') || self.props["class"] || self.props.className || '',
          disable: (target.getAttribute('data-tip-disable') ? target.getAttribute('data-tip-disable') === 'true' : self.props.disable) || false,
          currentTarget: target
        }, function () {
          if (scrollHide) {
            self.addScrollListener(self.state.currentTarget);
          }
          self.updateTooltip(e);
          if (getContent && Array.isArray(getContent)) {
            self.intervalUpdateContent = setInterval(function () {
              if (self.mount) {
                var _getContent = self.props.getContent;
                var placeholder = TipContent(originTooltip, '', _getContent[0](), isMultiline);
                var isEmptyTip = self.isEmptyTip(placeholder);
                self.setState({
                  isEmptyTip: isEmptyTip
                });
                self.updatePosition();
              }
            }, getContent[1]);
          }
        });
      };

      // If there is no delay call immediately, don't allow events to get in first.
      if (reshowDelay) {
        this.delayReshow = setTimeout(updateState, reshowDelay);
      } else {
        updateState();
      }
    }

    /**
     * When mouse hover, update tool tip
     */
  }, {
    key: "updateTooltip",
    value: function updateTooltip(e) {
      var _this5 = this;
      var _this$state = this.state,
        delayShow = _this$state.delayShow,
        disable = _this$state.disable;
      var _this$props6 = this.props,
        afterShow = _this$props6.afterShow,
        disableProp = _this$props6.disable;
      var placeholder = this.getTooltipContent();
      var eventTarget = e.currentTarget || e.target;

      // Check if the mouse is actually over the tooltip, if so don't hide the tooltip
      if (this.mouseOnToolTip()) {
        return;
      }

      // if the tooltip is empty, disable the tooltip
      if (this.isEmptyTip(placeholder) || disable || disableProp) {
        return;
      }
      var delayTime = !this.state.show ? parseInt(delayShow, 10) : 0;
      var updateState = function updateState() {
        if (Array.isArray(placeholder) && placeholder.length > 0 || placeholder) {
          var isInvisible = !_this5.state.show;
          _this5.setState({
            currentEvent: e,
            currentTarget: eventTarget,
            show: true
          }, function () {
            _this5.updatePosition(function () {
              if (isInvisible && afterShow) {
                afterShow(e);
              }
            });
          });
        }
      };
      if (this.delayShowLoop) {
        clearTimeout(this.delayShowLoop);
      }
      if (delayTime) {
        this.delayShowLoop = setTimeout(updateState, delayTime);
      } else {
        this.delayShowLoop = null;
        updateState();
      }
    }

    /*
     * If we're mousing over the tooltip remove it when we leave.
     */
  }, {
    key: "listenForTooltipExit",
    value: function listenForTooltipExit() {
      var show = this.state.show;
      if (show && this.tooltipRef) {
        this.tooltipRef.addEventListener('mouseleave', this.hideTooltip);
      }
    }
  }, {
    key: "removeListenerForTooltipExit",
    value: function removeListenerForTooltipExit() {
      var show = this.state.show;
      if (show && this.tooltipRef) {
        this.tooltipRef.removeEventListener('mouseleave', this.hideTooltip);
      }
    }

    /**
     * When mouse leave, hide tooltip
     */
  }, {
    key: "hideTooltip",
    value: function hideTooltip(e, hasTarget) {
      var _this6 = this;
      var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {
        isScroll: false
      };
      var disable = this.state.disable;
      var isScroll = options.isScroll;
      var delayHide = isScroll ? 0 : this.state.delayHide;
      var _this$props7 = this.props,
        afterHide = _this$props7.afterHide,
        disableProp = _this$props7.disable;
      var placeholder = this.getTooltipContent();
      if (!this.mount) return;
      if (this.isEmptyTip(placeholder) || disable || disableProp) return; // if the tooltip is empty, disable the tooltip
      if (hasTarget) {
        // Don't trigger other elements belongs to other ReactTooltip
        var targetArray = this.getTargetArray(this.props.id);
        var isMyElement = targetArray.some(function (ele) {
          return ele === e.currentTarget;
        });
        if (!isMyElement || !this.state.show) return;
      }

      // clean up aria-describedby when hiding tooltip
      if (e && e.currentTarget && e.currentTarget.removeAttribute) {
        e.currentTarget.removeAttribute('aria-describedby');
      }
      var resetState = function resetState() {
        var isVisible = _this6.state.show;
        // Check if the mouse is actually over the tooltip, if so don't hide the tooltip
        if (_this6.mouseOnToolTip()) {
          _this6.listenForTooltipExit();
          return;
        }
        _this6.removeListenerForTooltipExit();
        _this6.setState({
          show: false
        }, function () {
          _this6.removeScrollListener(_this6.state.currentTarget);
          if (isVisible && afterHide) {
            afterHide(e);
          }
        });
      };
      this.clearTimer();
      if (delayHide) {
        this.delayHideLoop = setTimeout(resetState, parseInt(delayHide, 10));
      } else {
        resetState();
      }
    }

    /**
     * When scroll, hide tooltip
     */
  }, {
    key: "hideTooltipOnScroll",
    value: function hideTooltipOnScroll(event, hasTarget) {
      this.hideTooltip(event, hasTarget, {
        isScroll: true
      });
    }

    /**
     * Add scroll event listener when tooltip show
     * automatically hide the tooltip when scrolling
     */
  }, {
    key: "addScrollListener",
    value: function addScrollListener(currentTarget) {
      var isCaptureMode = this.isCapture(currentTarget);
      window.addEventListener('scroll', this.hideTooltipOnScroll, isCaptureMode);
    }
  }, {
    key: "removeScrollListener",
    value: function removeScrollListener(currentTarget) {
      var isCaptureMode = this.isCapture(currentTarget);
      window.removeEventListener('scroll', this.hideTooltipOnScroll, isCaptureMode);
    }

    // Calculation the position
  }, {
    key: "updatePosition",
    value: function updatePosition(callbackAfter) {
      var _this7 = this;
      var _this$state2 = this.state,
        currentEvent = _this$state2.currentEvent,
        currentTarget = _this$state2.currentTarget,
        place = _this$state2.place,
        desiredPlace = _this$state2.desiredPlace,
        effect = _this$state2.effect,
        offset = _this$state2.offset;
      var node = this.tooltipRef;
      var result = getPosition(currentEvent, currentTarget, node, place, desiredPlace, effect, offset);
      if (result.position && this.props.overridePosition) {
        result.position = this.props.overridePosition(result.position, currentEvent, currentTarget, node, place, desiredPlace, effect, offset);
      }
      if (result.isNewState) {
        // Switch to reverse placement
        return this.setState(result.newState, function () {
          _this7.updatePosition(callbackAfter);
        });
      }
      if (callbackAfter && typeof callbackAfter === 'function') {
        callbackAfter();
      }

      // Set tooltip position
      node.style.left = result.position.left + 'px';
      node.style.top = result.position.top + 'px';
    }

    /**
     * CLear all kinds of timeout of interval
     */
  }, {
    key: "clearTimer",
    value: function clearTimer() {
      if (this.delayShowLoop) {
        clearTimeout(this.delayShowLoop);
        this.delayShowLoop = null;
      }
      if (this.delayHideLoop) {
        clearTimeout(this.delayHideLoop);
        this.delayHideLoop = null;
      }
      if (this.delayReshow) {
        clearTimeout(this.delayReshow);
        this.delayReshow = null;
      }
      if (this.intervalUpdateContent) {
        clearInterval(this.intervalUpdateContent);
        this.intervalUpdateContent = null;
      }
    }
  }, {
    key: "hasCustomColors",
    value: function hasCustomColors() {
      var _this8 = this;
      return Boolean(Object.keys(this.state.customColors).find(function (color) {
        return color !== 'border' && _this8.state.customColors[color];
      }) || this.state.border && this.state.customColors['border']);
    }
  }, {
    key: "render",
    value: function render() {
      var _this9 = this;
      var _this$state3 = this.state,
        extraClass = _this$state3.extraClass,
        html = _this$state3.html,
        ariaProps = _this$state3.ariaProps,
        disable = _this$state3.disable,
        uuid = _this$state3.uuid;
      var content = this.getTooltipContent();
      var isEmptyTip = this.isEmptyTip(content);
      var style = this.props.disableInternalStyle ? '' : generateTooltipStyle(this.state.uuid, this.state.customColors, this.state.type, this.state.border, this.state.padding, this.state.customRadius);
      var tooltipClass = '__react_component_tooltip' + " ".concat(this.state.uuid) + (this.state.show && !disable && !isEmptyTip ? ' show' : '') + (this.state.border ? ' ' + this.state.borderClass : '') + " place-".concat(this.state.place) + // top, bottom, left, right
      " type-".concat(this.hasCustomColors() ? 'custom' : this.state.type) + (
      // dark, success, warning, error, info, light, custom
      this.props.delayUpdate ? ' allow_hover' : '') + (this.props.clickable ? ' allow_click' : '');
      var Wrapper = this.props.wrapper;
      if (ReactTooltip.supportedWrappers.indexOf(Wrapper) < 0) {
        Wrapper = ReactTooltip.defaultProps.wrapper;
      }
      var wrapperClassName = [tooltipClass, extraClass].filter(Boolean).join(' ');
      if (html) {
        var htmlContent = "".concat(content).concat(style ? "\n<style aria-hidden=\"true\">".concat(style, "</style>") : '');
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(Wrapper, _extends({
          className: "".concat(wrapperClassName),
          id: this.props.id || uuid,
          ref: function ref(_ref) {
            return _this9.tooltipRef = _ref;
          }
        }, ariaProps, {
          "data-id": "tooltip",
          dangerouslySetInnerHTML: {
            __html: htmlContent
          }
        }));
      } else {
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement(Wrapper, _extends({
          className: "".concat(wrapperClassName),
          id: this.props.id || uuid
        }, ariaProps, {
          ref: function ref(_ref2) {
            return _this9.tooltipRef = _ref2;
          },
          "data-id": "tooltip"
        }), style && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createElement("style", {
          dangerouslySetInnerHTML: {
            __html: style
          },
          "aria-hidden": "true"
        }), content);
      }
    }
  }], [{
    key: "propTypes",
    get: function get() {
      return {
        uuid: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        children: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().any),
        place: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        type: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        effect: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        offset: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().object),
        padding: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        multiline: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        border: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        borderClass: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        textColor: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        backgroundColor: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        borderColor: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        arrowColor: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        arrowRadius: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        tooltipRadius: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        insecure: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        "class": (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        className: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        id: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        html: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        delayHide: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().number),
        delayUpdate: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().number),
        delayShow: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().number),
        event: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        eventOff: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        isCapture: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        globalEventOff: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        getContent: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().any),
        afterShow: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().func),
        afterHide: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().func),
        overridePosition: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().func),
        disable: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        scrollHide: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        resizeHide: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        wrapper: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        bodyMode: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        possibleCustomEvents: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        possibleCustomEventsOff: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().string),
        clickable: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool),
        disableInternalStyle: (prop_types__WEBPACK_IMPORTED_MODULE_2___default().bool)
      };
    }
  }, {
    key: "getDerivedStateFromProps",
    value: function getDerivedStateFromProps(nextProps, prevState) {
      var ariaProps = prevState.ariaProps;
      var newAriaProps = parseAria(nextProps);
      var isChanged = Object.keys(newAriaProps).some(function (props) {
        return newAriaProps[props] !== ariaProps[props];
      });
      if (!isChanged) {
        return null;
      }
      return _objectSpread2(_objectSpread2({}, prevState), {}, {
        ariaProps: newAriaProps
      });
    }
  }]);
  return ReactTooltip;
}((react__WEBPACK_IMPORTED_MODULE_0___default().Component)), _defineProperty(_class2, "defaultProps", {
  insecure: true,
  resizeHide: true,
  wrapper: 'div',
  clickable: false
}), _defineProperty(_class2, "supportedWrappers", ['div', 'span']), _defineProperty(_class2, "displayName", 'ReactTooltip'), _class2)) || _class) || _class) || _class) || _class) || _class) || _class) || _class;


//# sourceMappingURL=index.es.js.map


/***/ }),

/***/ "./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/bytesToUuid.js":
/*!**************************************************************************************!*\
  !*** ./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/bytesToUuid.js ***!
  \**************************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/**
 * Convert array of 16 byte values to UUID string format of the form:
 * XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX
 */
var byteToHex = [];

for (var i = 0; i < 256; ++i) {
  byteToHex[i] = (i + 0x100).toString(16).substr(1);
}

function bytesToUuid(buf, offset) {
  var i = offset || 0;
  var bth = byteToHex; // join used to fix memory issue caused by concatenation: https://bugs.chromium.org/p/v8/issues/detail?id=3175#c4

  return [bth[buf[i++]], bth[buf[i++]], bth[buf[i++]], bth[buf[i++]], '-', bth[buf[i++]], bth[buf[i++]], '-', bth[buf[i++]], bth[buf[i++]], '-', bth[buf[i++]], bth[buf[i++]], '-', bth[buf[i++]], bth[buf[i++]], bth[buf[i++]], bth[buf[i++]], bth[buf[i++]], bth[buf[i++]]].join('');
}

/* harmony default export */ __webpack_exports__["default"] = (bytesToUuid);

/***/ }),

/***/ "./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/rng.js":
/*!******************************************************************************!*\
  !*** ./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/rng.js ***!
  \******************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ rng; }
/* harmony export */ });
// Unique ID creation requires a high quality random # generator. In the browser we therefore
// require the crypto API and do not support built-in fallback to lower quality random number
// generators (like Math.random()).
// getRandomValues needs to be invoked in a context where "this" is a Crypto implementation. Also,
// find the complete implementation of crypto (msCrypto) on IE11.
var getRandomValues = typeof crypto != 'undefined' && crypto.getRandomValues && crypto.getRandomValues.bind(crypto) || typeof msCrypto != 'undefined' && typeof msCrypto.getRandomValues == 'function' && msCrypto.getRandomValues.bind(msCrypto);
var rnds8 = new Uint8Array(16); // eslint-disable-line no-undef

function rng() {
  if (!getRandomValues) {
    throw new Error('crypto.getRandomValues() not supported. See https://github.com/uuidjs/uuid#getrandomvalues-not-supported');
  }

  return getRandomValues(rnds8);
}

/***/ }),

/***/ "./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/v4.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/v4.js ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _rng_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./rng.js */ "./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/rng.js");
/* harmony import */ var _bytesToUuid_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./bytesToUuid.js */ "./node_modules/react-tooltip/node_modules/uuid/dist/esm-browser/bytesToUuid.js");



function v4(options, buf, offset) {
  var i = buf && offset || 0;

  if (typeof options == 'string') {
    buf = options === 'binary' ? new Array(16) : null;
    options = null;
  }

  options = options || {};
  var rnds = options.random || (options.rng || _rng_js__WEBPACK_IMPORTED_MODULE_0__["default"])(); // Per 4.4, set bits for version and `clock_seq_hi_and_reserved`

  rnds[6] = rnds[6] & 0x0f | 0x40;
  rnds[8] = rnds[8] & 0x3f | 0x80; // Copy bytes to buffer, if provided

  if (buf) {
    for (var ii = 0; ii < 16; ++ii) {
      buf[i + ii] = rnds[ii];
    }
  }

  return buf || (0,_bytesToUuid_js__WEBPACK_IMPORTED_MODULE_1__["default"])(rnds);
}

/* harmony default export */ __webpack_exports__["default"] = (v4);

/***/ }),

/***/ "./node_modules/webfontloader/webfontloader.js":
/*!*****************************************************!*\
  !*** ./node_modules/webfontloader/webfontloader.js ***!
  \*****************************************************/
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_RESULT__;/* Web Font Loader v1.6.28 - (c) Adobe Systems, Google. License: Apache 2.0 */(function(){function aa(a,b,c){return a.call.apply(a.bind,arguments)}function ba(a,b,c){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(c,d);return a.apply(b,c)}}return function(){return a.apply(b,arguments)}}function p(a,b,c){p=Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?aa:ba;return p.apply(null,arguments)}var q=Date.now||function(){return+new Date};function ca(a,b){this.a=a;this.o=b||a;this.c=this.o.document}var da=!!window.FontFace;function t(a,b,c,d){b=a.c.createElement(b);if(c)for(var e in c)c.hasOwnProperty(e)&&("style"==e?b.style.cssText=c[e]:b.setAttribute(e,c[e]));d&&b.appendChild(a.c.createTextNode(d));return b}function u(a,b,c){a=a.c.getElementsByTagName(b)[0];a||(a=document.documentElement);a.insertBefore(c,a.lastChild)}function v(a){a.parentNode&&a.parentNode.removeChild(a)}
function w(a,b,c){b=b||[];c=c||[];for(var d=a.className.split(/\s+/),e=0;e<b.length;e+=1){for(var f=!1,g=0;g<d.length;g+=1)if(b[e]===d[g]){f=!0;break}f||d.push(b[e])}b=[];for(e=0;e<d.length;e+=1){f=!1;for(g=0;g<c.length;g+=1)if(d[e]===c[g]){f=!0;break}f||b.push(d[e])}a.className=b.join(" ").replace(/\s+/g," ").replace(/^\s+|\s+$/,"")}function y(a,b){for(var c=a.className.split(/\s+/),d=0,e=c.length;d<e;d++)if(c[d]==b)return!0;return!1}
function ea(a){return a.o.location.hostname||a.a.location.hostname}function z(a,b,c){function d(){m&&e&&f&&(m(g),m=null)}b=t(a,"link",{rel:"stylesheet",href:b,media:"all"});var e=!1,f=!0,g=null,m=c||null;da?(b.onload=function(){e=!0;d()},b.onerror=function(){e=!0;g=Error("Stylesheet failed to load");d()}):setTimeout(function(){e=!0;d()},0);u(a,"head",b)}
function A(a,b,c,d){var e=a.c.getElementsByTagName("head")[0];if(e){var f=t(a,"script",{src:b}),g=!1;f.onload=f.onreadystatechange=function(){g||this.readyState&&"loaded"!=this.readyState&&"complete"!=this.readyState||(g=!0,c&&c(null),f.onload=f.onreadystatechange=null,"HEAD"==f.parentNode.tagName&&e.removeChild(f))};e.appendChild(f);setTimeout(function(){g||(g=!0,c&&c(Error("Script load timeout")))},d||5E3);return f}return null};function B(){this.a=0;this.c=null}function C(a){a.a++;return function(){a.a--;D(a)}}function E(a,b){a.c=b;D(a)}function D(a){0==a.a&&a.c&&(a.c(),a.c=null)};function F(a){this.a=a||"-"}F.prototype.c=function(a){for(var b=[],c=0;c<arguments.length;c++)b.push(arguments[c].replace(/[\W_]+/g,"").toLowerCase());return b.join(this.a)};function G(a,b){this.c=a;this.f=4;this.a="n";var c=(b||"n4").match(/^([nio])([1-9])$/i);c&&(this.a=c[1],this.f=parseInt(c[2],10))}function fa(a){return H(a)+" "+(a.f+"00")+" 300px "+I(a.c)}function I(a){var b=[];a=a.split(/,\s*/);for(var c=0;c<a.length;c++){var d=a[c].replace(/['"]/g,"");-1!=d.indexOf(" ")||/^\d/.test(d)?b.push("'"+d+"'"):b.push(d)}return b.join(",")}function J(a){return a.a+a.f}function H(a){var b="normal";"o"===a.a?b="oblique":"i"===a.a&&(b="italic");return b}
function ga(a){var b=4,c="n",d=null;a&&((d=a.match(/(normal|oblique|italic)/i))&&d[1]&&(c=d[1].substr(0,1).toLowerCase()),(d=a.match(/([1-9]00|normal|bold)/i))&&d[1]&&(/bold/i.test(d[1])?b=7:/[1-9]00/.test(d[1])&&(b=parseInt(d[1].substr(0,1),10))));return c+b};function ha(a,b){this.c=a;this.f=a.o.document.documentElement;this.h=b;this.a=new F("-");this.j=!1!==b.events;this.g=!1!==b.classes}function ia(a){a.g&&w(a.f,[a.a.c("wf","loading")]);K(a,"loading")}function L(a){if(a.g){var b=y(a.f,a.a.c("wf","active")),c=[],d=[a.a.c("wf","loading")];b||c.push(a.a.c("wf","inactive"));w(a.f,c,d)}K(a,"inactive")}function K(a,b,c){if(a.j&&a.h[b])if(c)a.h[b](c.c,J(c));else a.h[b]()};function ja(){this.c={}}function ka(a,b,c){var d=[],e;for(e in b)if(b.hasOwnProperty(e)){var f=a.c[e];f&&d.push(f(b[e],c))}return d};function M(a,b){this.c=a;this.f=b;this.a=t(this.c,"span",{"aria-hidden":"true"},this.f)}function N(a){u(a.c,"body",a.a)}function O(a){return"display:block;position:absolute;top:-9999px;left:-9999px;font-size:300px;width:auto;height:auto;line-height:normal;margin:0;padding:0;font-variant:normal;white-space:nowrap;font-family:"+I(a.c)+";"+("font-style:"+H(a)+";font-weight:"+(a.f+"00")+";")};function P(a,b,c,d,e,f){this.g=a;this.j=b;this.a=d;this.c=c;this.f=e||3E3;this.h=f||void 0}P.prototype.start=function(){var a=this.c.o.document,b=this,c=q(),d=new Promise(function(d,e){function f(){q()-c>=b.f?e():a.fonts.load(fa(b.a),b.h).then(function(a){1<=a.length?d():setTimeout(f,25)},function(){e()})}f()}),e=null,f=new Promise(function(a,d){e=setTimeout(d,b.f)});Promise.race([f,d]).then(function(){e&&(clearTimeout(e),e=null);b.g(b.a)},function(){b.j(b.a)})};function Q(a,b,c,d,e,f,g){this.v=a;this.B=b;this.c=c;this.a=d;this.s=g||"BESbswy";this.f={};this.w=e||3E3;this.u=f||null;this.m=this.j=this.h=this.g=null;this.g=new M(this.c,this.s);this.h=new M(this.c,this.s);this.j=new M(this.c,this.s);this.m=new M(this.c,this.s);a=new G(this.a.c+",serif",J(this.a));a=O(a);this.g.a.style.cssText=a;a=new G(this.a.c+",sans-serif",J(this.a));a=O(a);this.h.a.style.cssText=a;a=new G("serif",J(this.a));a=O(a);this.j.a.style.cssText=a;a=new G("sans-serif",J(this.a));a=
O(a);this.m.a.style.cssText=a;N(this.g);N(this.h);N(this.j);N(this.m)}var R={D:"serif",C:"sans-serif"},S=null;function T(){if(null===S){var a=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))/.exec(window.navigator.userAgent);S=!!a&&(536>parseInt(a[1],10)||536===parseInt(a[1],10)&&11>=parseInt(a[2],10))}return S}Q.prototype.start=function(){this.f.serif=this.j.a.offsetWidth;this.f["sans-serif"]=this.m.a.offsetWidth;this.A=q();U(this)};
function la(a,b,c){for(var d in R)if(R.hasOwnProperty(d)&&b===a.f[R[d]]&&c===a.f[R[d]])return!0;return!1}function U(a){var b=a.g.a.offsetWidth,c=a.h.a.offsetWidth,d;(d=b===a.f.serif&&c===a.f["sans-serif"])||(d=T()&&la(a,b,c));d?q()-a.A>=a.w?T()&&la(a,b,c)&&(null===a.u||a.u.hasOwnProperty(a.a.c))?V(a,a.v):V(a,a.B):ma(a):V(a,a.v)}function ma(a){setTimeout(p(function(){U(this)},a),50)}function V(a,b){setTimeout(p(function(){v(this.g.a);v(this.h.a);v(this.j.a);v(this.m.a);b(this.a)},a),0)};function W(a,b,c){this.c=a;this.a=b;this.f=0;this.m=this.j=!1;this.s=c}var X=null;W.prototype.g=function(a){var b=this.a;b.g&&w(b.f,[b.a.c("wf",a.c,J(a).toString(),"active")],[b.a.c("wf",a.c,J(a).toString(),"loading"),b.a.c("wf",a.c,J(a).toString(),"inactive")]);K(b,"fontactive",a);this.m=!0;na(this)};
W.prototype.h=function(a){var b=this.a;if(b.g){var c=y(b.f,b.a.c("wf",a.c,J(a).toString(),"active")),d=[],e=[b.a.c("wf",a.c,J(a).toString(),"loading")];c||d.push(b.a.c("wf",a.c,J(a).toString(),"inactive"));w(b.f,d,e)}K(b,"fontinactive",a);na(this)};function na(a){0==--a.f&&a.j&&(a.m?(a=a.a,a.g&&w(a.f,[a.a.c("wf","active")],[a.a.c("wf","loading"),a.a.c("wf","inactive")]),K(a,"active")):L(a.a))};function oa(a){this.j=a;this.a=new ja;this.h=0;this.f=this.g=!0}oa.prototype.load=function(a){this.c=new ca(this.j,a.context||this.j);this.g=!1!==a.events;this.f=!1!==a.classes;pa(this,new ha(this.c,a),a)};
function qa(a,b,c,d,e){var f=0==--a.h;(a.f||a.g)&&setTimeout(function(){var a=e||null,m=d||null||{};if(0===c.length&&f)L(b.a);else{b.f+=c.length;f&&(b.j=f);var h,l=[];for(h=0;h<c.length;h++){var k=c[h],n=m[k.c],r=b.a,x=k;r.g&&w(r.f,[r.a.c("wf",x.c,J(x).toString(),"loading")]);K(r,"fontloading",x);r=null;if(null===X)if(window.FontFace){var x=/Gecko.*Firefox\/(\d+)/.exec(window.navigator.userAgent),xa=/OS X.*Version\/10\..*Safari/.exec(window.navigator.userAgent)&&/Apple/.exec(window.navigator.vendor);
X=x?42<parseInt(x[1],10):xa?!1:!0}else X=!1;X?r=new P(p(b.g,b),p(b.h,b),b.c,k,b.s,n):r=new Q(p(b.g,b),p(b.h,b),b.c,k,b.s,a,n);l.push(r)}for(h=0;h<l.length;h++)l[h].start()}},0)}function pa(a,b,c){var d=[],e=c.timeout;ia(b);var d=ka(a.a,c,a.c),f=new W(a.c,b,e);a.h=d.length;b=0;for(c=d.length;b<c;b++)d[b].load(function(b,d,c){qa(a,f,b,d,c)})};function ra(a,b){this.c=a;this.a=b}
ra.prototype.load=function(a){function b(){if(f["__mti_fntLst"+d]){var c=f["__mti_fntLst"+d](),e=[],h;if(c)for(var l=0;l<c.length;l++){var k=c[l].fontfamily;void 0!=c[l].fontStyle&&void 0!=c[l].fontWeight?(h=c[l].fontStyle+c[l].fontWeight,e.push(new G(k,h))):e.push(new G(k))}a(e)}else setTimeout(function(){b()},50)}var c=this,d=c.a.projectId,e=c.a.version;if(d){var f=c.c.o;A(this.c,(c.a.api||"https://fast.fonts.net/jsapi")+"/"+d+".js"+(e?"?v="+e:""),function(e){e?a([]):(f["__MonotypeConfiguration__"+
d]=function(){return c.a},b())}).id="__MonotypeAPIScript__"+d}else a([])};function sa(a,b){this.c=a;this.a=b}sa.prototype.load=function(a){var b,c,d=this.a.urls||[],e=this.a.families||[],f=this.a.testStrings||{},g=new B;b=0;for(c=d.length;b<c;b++)z(this.c,d[b],C(g));var m=[];b=0;for(c=e.length;b<c;b++)if(d=e[b].split(":"),d[1])for(var h=d[1].split(","),l=0;l<h.length;l+=1)m.push(new G(d[0],h[l]));else m.push(new G(d[0]));E(g,function(){a(m,f)})};function ta(a,b){a?this.c=a:this.c=ua;this.a=[];this.f=[];this.g=b||""}var ua="https://fonts.googleapis.com/css";function va(a,b){for(var c=b.length,d=0;d<c;d++){var e=b[d].split(":");3==e.length&&a.f.push(e.pop());var f="";2==e.length&&""!=e[1]&&(f=":");a.a.push(e.join(f))}}
function wa(a){if(0==a.a.length)throw Error("No fonts to load!");if(-1!=a.c.indexOf("kit="))return a.c;for(var b=a.a.length,c=[],d=0;d<b;d++)c.push(a.a[d].replace(/ /g,"+"));b=a.c+"?family="+c.join("%7C");0<a.f.length&&(b+="&subset="+a.f.join(","));0<a.g.length&&(b+="&text="+encodeURIComponent(a.g));return b};function ya(a){this.f=a;this.a=[];this.c={}}
var za={latin:"BESbswy","latin-ext":"\u00e7\u00f6\u00fc\u011f\u015f",cyrillic:"\u0439\u044f\u0416",greek:"\u03b1\u03b2\u03a3",khmer:"\u1780\u1781\u1782",Hanuman:"\u1780\u1781\u1782"},Aa={thin:"1",extralight:"2","extra-light":"2",ultralight:"2","ultra-light":"2",light:"3",regular:"4",book:"4",medium:"5","semi-bold":"6",semibold:"6","demi-bold":"6",demibold:"6",bold:"7","extra-bold":"8",extrabold:"8","ultra-bold":"8",ultrabold:"8",black:"9",heavy:"9",l:"3",r:"4",b:"7"},Ba={i:"i",italic:"i",n:"n",normal:"n"},
Ca=/^(thin|(?:(?:extra|ultra)-?)?light|regular|book|medium|(?:(?:semi|demi|extra|ultra)-?)?bold|black|heavy|l|r|b|[1-9]00)?(n|i|normal|italic)?$/;
function Da(a){for(var b=a.f.length,c=0;c<b;c++){var d=a.f[c].split(":"),e=d[0].replace(/\+/g," "),f=["n4"];if(2<=d.length){var g;var m=d[1];g=[];if(m)for(var m=m.split(","),h=m.length,l=0;l<h;l++){var k;k=m[l];if(k.match(/^[\w-]+$/)){var n=Ca.exec(k.toLowerCase());if(null==n)k="";else{k=n[2];k=null==k||""==k?"n":Ba[k];n=n[1];if(null==n||""==n)n="4";else var r=Aa[n],n=r?r:isNaN(n)?"4":n.substr(0,1);k=[k,n].join("")}}else k="";k&&g.push(k)}0<g.length&&(f=g);3==d.length&&(d=d[2],g=[],d=d?d.split(","):
g,0<d.length&&(d=za[d[0]])&&(a.c[e]=d))}a.c[e]||(d=za[e])&&(a.c[e]=d);for(d=0;d<f.length;d+=1)a.a.push(new G(e,f[d]))}};function Ea(a,b){this.c=a;this.a=b}var Fa={Arimo:!0,Cousine:!0,Tinos:!0};Ea.prototype.load=function(a){var b=new B,c=this.c,d=new ta(this.a.api,this.a.text),e=this.a.families;va(d,e);var f=new ya(e);Da(f);z(c,wa(d),C(b));E(b,function(){a(f.a,f.c,Fa)})};function Ga(a,b){this.c=a;this.a=b}Ga.prototype.load=function(a){var b=this.a.id,c=this.c.o;b?A(this.c,(this.a.api||"https://use.typekit.net")+"/"+b+".js",function(b){if(b)a([]);else if(c.Typekit&&c.Typekit.config&&c.Typekit.config.fn){b=c.Typekit.config.fn;for(var e=[],f=0;f<b.length;f+=2)for(var g=b[f],m=b[f+1],h=0;h<m.length;h++)e.push(new G(g,m[h]));try{c.Typekit.load({events:!1,classes:!1,async:!0})}catch(l){}a(e)}},2E3):a([])};function Ha(a,b){this.c=a;this.f=b;this.a=[]}Ha.prototype.load=function(a){var b=this.f.id,c=this.c.o,d=this;b?(c.__webfontfontdeckmodule__||(c.__webfontfontdeckmodule__={}),c.__webfontfontdeckmodule__[b]=function(b,c){for(var g=0,m=c.fonts.length;g<m;++g){var h=c.fonts[g];d.a.push(new G(h.name,ga("font-weight:"+h.weight+";font-style:"+h.style)))}a(d.a)},A(this.c,(this.f.api||"https://f.fontdeck.com/s/css/js/")+ea(this.c)+"/"+b+".js",function(b){b&&a([])})):a([])};var Y=new oa(window);Y.a.c.custom=function(a,b){return new sa(b,a)};Y.a.c.fontdeck=function(a,b){return new Ha(b,a)};Y.a.c.monotype=function(a,b){return new ra(b,a)};Y.a.c.typekit=function(a,b){return new Ga(b,a)};Y.a.c.google=function(a,b){return new Ea(b,a)};var Z={load:p(Y.load,Y)}; true?!(__WEBPACK_AMD_DEFINE_RESULT__ = (function(){return Z}).call(exports, __webpack_require__, exports, module),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)):0;}());


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "react-dom":
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/***/ (function(module) {

"use strict";
module.exports = window["ReactDOM"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/core-data":
/*!**********************************!*\
  !*** external ["wp","coreData"] ***!
  \**********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["coreData"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/edit-post":
/*!**********************************!*\
  !*** external ["wp","editPost"] ***!
  \**********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["editPost"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/hooks":
/*!*******************************!*\
  !*** external ["wp","hooks"] ***!
  \*******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["hooks"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/plugins":
/*!*********************************!*\
  !*** external ["wp","plugins"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["plugins"];

/***/ }),

/***/ "@wordpress/primitives":
/*!************************************!*\
  !*** external ["wp","primitives"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["primitives"];

/***/ }),

/***/ "../../node_modules/html-react-parser/esm/index.mjs":
/*!**********************************************************!*\
  !*** ../../node_modules/html-react-parser/esm/index.mjs ***!
  \**********************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Comment": function() { return /* reexport safe */ _lib_index_js__WEBPACK_IMPORTED_MODULE_0__.Comment; },
/* harmony export */   "Element": function() { return /* reexport safe */ _lib_index_js__WEBPACK_IMPORTED_MODULE_0__.Element; },
/* harmony export */   "ProcessingInstruction": function() { return /* reexport safe */ _lib_index_js__WEBPACK_IMPORTED_MODULE_0__.ProcessingInstruction; },
/* harmony export */   "Text": function() { return /* reexport safe */ _lib_index_js__WEBPACK_IMPORTED_MODULE_0__.Text; },
/* harmony export */   "attributesToProps": function() { return /* reexport safe */ _lib_index_js__WEBPACK_IMPORTED_MODULE_0__.attributesToProps; },
/* harmony export */   "domToReact": function() { return /* reexport safe */ _lib_index_js__WEBPACK_IMPORTED_MODULE_0__.domToReact; },
/* harmony export */   "htmlToDOM": function() { return /* reexport safe */ _lib_index_js__WEBPACK_IMPORTED_MODULE_0__.htmlToDOM; }
/* harmony export */ });
/* harmony import */ var _lib_index_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../lib/index.js */ "../../node_modules/html-react-parser/lib/index.js");




/* harmony default export */ __webpack_exports__["default"] = (_lib_index_js__WEBPACK_IMPORTED_MODULE_0__["default"] || _lib_index_js__WEBPACK_IMPORTED_MODULE_0__);


/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _defineProperty; }
/* harmony export */ });
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _extends; }
/* harmony export */ });
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
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/global */
/******/ 	!function() {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
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
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!******************************************!*\
  !*** ./src/post-editor-sidebar/index.js ***!
  \******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/plugins */ "@wordpress/plugins");
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/edit-post */ "@wordpress/edit-post");
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _ui__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../ui */ "./src/ui.js");
/* harmony import */ var _store_settings_store__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../store/settings-store */ "./src/store/settings-store.js");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/core-data */ "@wordpress/core-data");
/* harmony import */ var _wordpress_core_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _components_HelperFunction__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../../../components/HelperFunction */ "../components/HelperFunction.js");
/* harmony import */ var webfontloader__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! webfontloader */ "./node_modules/webfontloader/webfontloader.js");
/* harmony import */ var webfontloader__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(webfontloader__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _styles_index_scss__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../styles/index.scss */ "./src/styles/index.scss");





const {
  __
} = wp.i18n;








const SidebarIconItem = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    id: "Layer_1",
    xmlns: "http://www.w3.org/2000/svg",
    width: "24",
    height: "24",
    viewBox: "0 0 21.88 21.88"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M10.94,0C4.9,0,0,4.9,0,10.94s4.9,10.94,10.94,10.94,10.94-4.9,10.94-10.94S16.98,0,10.94,0ZM17.41,9.19l-3.03,3.03.83,4.12c.02.11-.02.21-.11.28-.05.04-.11.06-.17.06-.05,0-.09-.01-.13-.03l-3.86-1.93-3.86,1.93c-.09.05-.21.04-.3-.03-.09-.07-.13-.17-.11-.28l.83-4.12-3.03-3.03c-.07-.07-.1-.19-.06-.29.03-.1.12-.18.23-.19l4.12-.55,1.93-3.85c.09-.2.41-.2.51,0l1.92,3.85,4.12.55c.11.01.2.09.23.19.04.1,0,.22-.06.29Z"
  }));
};

const SidebarIcon = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    id: "Layer_1",
    xmlns: "http://www.w3.org/2000/svg",
    width: "24",
    height: "24",
    viewBox: "0 0 21.88 21.88"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M10.94,0C4.9,0,0,4.9,0,10.94s4.9,10.94,10.94,10.94,10.94-4.9,10.94-10.94S16.98,0,10.94,0ZM17.41,9.19l-3.03,3.03.83,4.12c.02.11-.02.21-.11.28-.05.04-.11.06-.17.06-.05,0-.09-.01-.13-.03l-3.86-1.93-3.86,1.93c-.09.05-.21.04-.3-.03-.09-.07-.13-.17-.11-.28l.83-4.12-3.03-3.03c-.07-.07-.1-.19-.06-.29.03-.1.12-.18.23-.19l4.12-.55,1.93-3.85c.09-.2.41-.2.51,0l1.92,3.85,4.12.55c.11.01.2.09.23.19.04.1,0,.22-.06.29Z"
  }));
};

const loadGlobalStyles = globalStyle => {
  const {
    colorPalette,
    globalColors,
    globalTypography,
    deviceType,
    applyColorsToDefault,
    applyTypographyToDefault,
    layoutSettings
  } = globalStyle;
  const css = loadStyles(colorPalette, globalColors, globalTypography, applyColorsToDefault, applyTypographyToDefault, deviceType, layoutSettings);
  return css;
};

const loadStyles = (colorPalette, globalColors, globalTypography, applyColorsToDefault, applyTypographyToDefault, deviceType, layoutSettings) => {
  var _heading1$fontSize, _heading1$fontSize2, _heading1$fontSize2$u, _heading1$letterSpaci, _heading1$letterSpaci2, _heading1$lineHeight, _heading1$lineHeight2, _heading2$fontSize, _heading2$fontSize2, _heading2$fontSize2$u, _heading2$letterSpaci, _heading2$letterSpaci2, _heading2$lineHeight, _heading2$lineHeight2, _heading3$fontSize, _heading3$fontSize2, _heading3$fontSize2$u, _heading3$letterSpaci, _heading3$letterSpaci2, _heading3$lineHeight, _heading3$lineHeight2, _heading4$fontSize, _heading4$fontSize2, _heading4$fontSize2$u, _heading4$letterSpaci, _heading4$letterSpaci2, _heading4$lineHeight, _heading4$lineHeight2, _heading5$fontSize, _heading5$fontSize2, _heading5$fontSize2$u, _heading5$letterSpaci, _heading5$letterSpaci2, _heading5$lineHeight, _heading5$lineHeight2, _heading6$fontSize, _heading6$fontSize2, _heading6$fontSize2$u, _heading6$letterSpaci, _heading6$letterSpaci2, _heading6$lineHeight, _heading6$lineHeight2, _button$fontSize, _button$fontSize2, _button$fontSize2$uni, _button$letterSpacing, _button$letterSpacing2, _button$lineHeight, _button$lineHeight2, _paragraph$fontSize, _paragraph$fontSize2, _paragraph$fontSize2$, _paragraph$letterSpac, _paragraph$letterSpac2, _paragraph$lineHeight, _paragraph$lineHeight2;

  if (!colorPalette || !(globalColors !== null && globalColors !== void 0 && globalColors.colors)) {
    return '';
  }

  const {
    heading1,
    heading2,
    heading3,
    heading4,
    heading5,
    heading6,
    button,
    paragraph
  } = globalTypography;
  const styles = {};
  let css = ''; // Colors

  if (colorPalette !== 'theme') {
    styles[':root'] = {};
    globalColors.colors.map((item, index) => {
      styles[':root'][`--pbg-global-${item.slug}`] = item.color;
      return item;
    });
    styles[`[class*="wp-block-premium"]`] = {
      'color': `var(--pbg-global-color3)`
    };
    styles[`[class*="wp-block-premium"] h1, [class*="wp-block-premium"] h2, [class*="wp-block-premium"] h3,[class*="wp-block-premium"] h4,[class*="wp-block-premium"] h5,[class*="wp-block-premium"] h6, [class*="wp-block-premium"] a:not([class*="button"])`] = {
      'color': `var(--pbg-global-color2)`
    };
    styles[`[class*="wp-block-premium"] .premium-button, [class*="wp-block-premium"] .premium-button a, [class*="wp-block-premium"] .premium-modal-box-modal-lower-close`] = {
      'color': `#ffffff`,
      'background-color': `var(--pbg-global-color1)`,
      'border-color': `var(--pbg-global-color4)`
    };
    styles[`[class*="wp-block-premium"] a:not([class*="button"]):hover`] = {
      'color': `var(--pbg-global-color1)`
    }; // Core Blocks Styles

    if (applyColorsToDefault) {
      styles[`.editor-styles-wrapper [data-type^="core/"]`] = {
        'color': `var(--pbg-global-color3)`
      };
      styles[`.editor-styles-wrapper h1[data-type^="core/"], .editor-styles-wrapper h2[data-type^="core/"], .editor-styles-wrapper h3[data-type^="core/"],.editor-styles-wrapper h4[data-type^="core/"],.editor-styles-wrapper h5[data-type^="core/"],.editor-styles-wrapper h6[data-type^="core/"], .editor-styles-wrapper [data-type^="core/"] a:not([class*="button"])`] = {
        'color': `var(--pbg-global-color2)`
      };
      styles[`.editor-styles-wrapper .wp-block-button > div, .editor-styles-wrapper .wp-block-button > .wp-block-button__link`] = {
        'color': `#ffffff`,
        'background-color': `var(--pbg-global-color1)`,
        'border-color': `var(--pbg-global-color4)`
      };
      styles[`.editor-styles-wrapper [data-type^="core/"] a:not([class*="button"]):hover`] = {
        'color': `var(--pbg-global-color1)`
      };
    }

    css += (0,_components_HelperFunction__WEBPACK_IMPORTED_MODULE_7__.generateCss)(styles);
  } // Block Spacing


  styles['body .entry-content > * + *, .edit-post-visual-editor .editor-styles-wrapper .edit-post-visual-editor__post-title-wrapper > * + *:not(p), .edit-post-visual-editor .editor-styles-wrapper .block-editor-block-list__layout.is-root-container > * + *:not(p), .editor-styles-wrapper > .block-editor-block-list__layout.is-root-container > .wp-block + .wp-block:not(p), .editor-styles-wrapper > .block-editor-block-list__layout.is-root-container > .wp-block + .wp-block:not(p)'] = {
    'margin-block-start': `${(layoutSettings === null || layoutSettings === void 0 ? void 0 : layoutSettings.block_spacing) + 'px'}`,
    'margin-top': `${(layoutSettings === null || layoutSettings === void 0 ? void 0 : layoutSettings.block_spacing) + 'px'}`
  }; // Typography

  styles[`h1[class*="premium"]`] = {
    'font-size': `${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$fontSize = heading1.fontSize) === null || _heading1$fontSize === void 0 ? void 0 : _heading1$fontSize[deviceType]}${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$fontSize2 = heading1.fontSize) === null || _heading1$fontSize2 === void 0 ? void 0 : (_heading1$fontSize2$u = _heading1$fontSize2.unit) === null || _heading1$fontSize2$u === void 0 ? void 0 : _heading1$fontSize2$u[deviceType]}`,
    'font-style': heading1 === null || heading1 === void 0 ? void 0 : heading1.fontStyle,
    'font-family': heading1 === null || heading1 === void 0 ? void 0 : heading1.fontFamily,
    'font-weight': heading1 === null || heading1 === void 0 ? void 0 : heading1.fontWeight,
    'letter-spacing': `${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$letterSpaci = heading1.letterSpacing) === null || _heading1$letterSpaci === void 0 ? void 0 : _heading1$letterSpaci[deviceType]}${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$letterSpaci2 = heading1.letterSpacing) === null || _heading1$letterSpaci2 === void 0 ? void 0 : _heading1$letterSpaci2.unit}`,
    'text-decoration': heading1 === null || heading1 === void 0 ? void 0 : heading1.textDecoration,
    'text-transform': heading1 === null || heading1 === void 0 ? void 0 : heading1.textTransform,
    'line-height': `${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$lineHeight = heading1.lineHeight) === null || _heading1$lineHeight === void 0 ? void 0 : _heading1$lineHeight[deviceType]}${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$lineHeight2 = heading1.lineHeight) === null || _heading1$lineHeight2 === void 0 ? void 0 : _heading1$lineHeight2.unit}`
  };
  styles[`h2[class*="premium"]`] = {
    'font-size': `${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$fontSize = heading2.fontSize) === null || _heading2$fontSize === void 0 ? void 0 : _heading2$fontSize[deviceType]}${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$fontSize2 = heading2.fontSize) === null || _heading2$fontSize2 === void 0 ? void 0 : (_heading2$fontSize2$u = _heading2$fontSize2.unit) === null || _heading2$fontSize2$u === void 0 ? void 0 : _heading2$fontSize2$u[deviceType]}`,
    'font-style': heading2 === null || heading2 === void 0 ? void 0 : heading2.fontStyle,
    'font-family': heading2 === null || heading2 === void 0 ? void 0 : heading2.fontFamily,
    'font-weight': heading2 === null || heading2 === void 0 ? void 0 : heading2.fontWeight,
    'letter-spacing': `${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$letterSpaci = heading2.letterSpacing) === null || _heading2$letterSpaci === void 0 ? void 0 : _heading2$letterSpaci[deviceType]}${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$letterSpaci2 = heading2.letterSpacing) === null || _heading2$letterSpaci2 === void 0 ? void 0 : _heading2$letterSpaci2.unit}`,
    'text-decoration': heading2 === null || heading2 === void 0 ? void 0 : heading2.textDecoration,
    'text-transform': heading2 === null || heading2 === void 0 ? void 0 : heading2.textTransform,
    'line-height': `${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$lineHeight = heading2.lineHeight) === null || _heading2$lineHeight === void 0 ? void 0 : _heading2$lineHeight[deviceType]}${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$lineHeight2 = heading2.lineHeight) === null || _heading2$lineHeight2 === void 0 ? void 0 : _heading2$lineHeight2.unit}`
  };
  styles[`h3[class*="premium"]`] = {
    'font-size': `${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$fontSize = heading3.fontSize) === null || _heading3$fontSize === void 0 ? void 0 : _heading3$fontSize[deviceType]}${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$fontSize2 = heading3.fontSize) === null || _heading3$fontSize2 === void 0 ? void 0 : (_heading3$fontSize2$u = _heading3$fontSize2.unit) === null || _heading3$fontSize2$u === void 0 ? void 0 : _heading3$fontSize2$u[deviceType]}`,
    'font-style': heading3 === null || heading3 === void 0 ? void 0 : heading3.fontStyle,
    'font-family': heading3 === null || heading3 === void 0 ? void 0 : heading3.fontFamily,
    'font-weight': heading3 === null || heading3 === void 0 ? void 0 : heading3.fontWeight,
    'letter-spacing': `${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$letterSpaci = heading3.letterSpacing) === null || _heading3$letterSpaci === void 0 ? void 0 : _heading3$letterSpaci[deviceType]}${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$letterSpaci2 = heading3.letterSpacing) === null || _heading3$letterSpaci2 === void 0 ? void 0 : _heading3$letterSpaci2.unit}`,
    'text-decoration': heading3 === null || heading3 === void 0 ? void 0 : heading3.textDecoration,
    'text-transform': heading3 === null || heading3 === void 0 ? void 0 : heading3.textTransform,
    'line-height': `${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$lineHeight = heading3.lineHeight) === null || _heading3$lineHeight === void 0 ? void 0 : _heading3$lineHeight[deviceType]}${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$lineHeight2 = heading3.lineHeight) === null || _heading3$lineHeight2 === void 0 ? void 0 : _heading3$lineHeight2.unit}`
  };
  styles[`h4[class*="premium"]`] = {
    'font-size': `${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$fontSize = heading4.fontSize) === null || _heading4$fontSize === void 0 ? void 0 : _heading4$fontSize[deviceType]}${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$fontSize2 = heading4.fontSize) === null || _heading4$fontSize2 === void 0 ? void 0 : (_heading4$fontSize2$u = _heading4$fontSize2.unit) === null || _heading4$fontSize2$u === void 0 ? void 0 : _heading4$fontSize2$u[deviceType]}`,
    'font-style': heading4 === null || heading4 === void 0 ? void 0 : heading4.fontStyle,
    'font-family': heading4 === null || heading4 === void 0 ? void 0 : heading4.fontFamily,
    'font-weight': heading4 === null || heading4 === void 0 ? void 0 : heading4.fontWeight,
    'letter-spacing': `${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$letterSpaci = heading4.letterSpacing) === null || _heading4$letterSpaci === void 0 ? void 0 : _heading4$letterSpaci[deviceType]}${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$letterSpaci2 = heading4.letterSpacing) === null || _heading4$letterSpaci2 === void 0 ? void 0 : _heading4$letterSpaci2.unit}`,
    'text-decoration': heading4 === null || heading4 === void 0 ? void 0 : heading4.textDecoration,
    'text-transform': heading4 === null || heading4 === void 0 ? void 0 : heading4.textTransform,
    'line-height': `${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$lineHeight = heading4.lineHeight) === null || _heading4$lineHeight === void 0 ? void 0 : _heading4$lineHeight[deviceType]}${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$lineHeight2 = heading4.lineHeight) === null || _heading4$lineHeight2 === void 0 ? void 0 : _heading4$lineHeight2.unit}`
  };
  styles[`h5[class*="premium"]`] = {
    'font-size': `${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$fontSize = heading5.fontSize) === null || _heading5$fontSize === void 0 ? void 0 : _heading5$fontSize[deviceType]}${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$fontSize2 = heading5.fontSize) === null || _heading5$fontSize2 === void 0 ? void 0 : (_heading5$fontSize2$u = _heading5$fontSize2.unit) === null || _heading5$fontSize2$u === void 0 ? void 0 : _heading5$fontSize2$u[deviceType]}`,
    'font-style': heading5 === null || heading5 === void 0 ? void 0 : heading5.fontStyle,
    'font-family': heading5 === null || heading5 === void 0 ? void 0 : heading5.fontFamily,
    'font-weight': heading5 === null || heading5 === void 0 ? void 0 : heading5.fontWeight,
    'letter-spacing': `${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$letterSpaci = heading5.letterSpacing) === null || _heading5$letterSpaci === void 0 ? void 0 : _heading5$letterSpaci[deviceType]}${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$letterSpaci2 = heading5.letterSpacing) === null || _heading5$letterSpaci2 === void 0 ? void 0 : _heading5$letterSpaci2.unit}`,
    'text-decoration': heading5 === null || heading5 === void 0 ? void 0 : heading5.textDecoration,
    'text-transform': heading5 === null || heading5 === void 0 ? void 0 : heading5.textTransform,
    'line-height': `${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$lineHeight = heading5.lineHeight) === null || _heading5$lineHeight === void 0 ? void 0 : _heading5$lineHeight[deviceType]}${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$lineHeight2 = heading5.lineHeight) === null || _heading5$lineHeight2 === void 0 ? void 0 : _heading5$lineHeight2.unit}`
  };
  styles[`h6[class*="premium"]`] = {
    'font-size': `${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$fontSize = heading6.fontSize) === null || _heading6$fontSize === void 0 ? void 0 : _heading6$fontSize[deviceType]}${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$fontSize2 = heading6.fontSize) === null || _heading6$fontSize2 === void 0 ? void 0 : (_heading6$fontSize2$u = _heading6$fontSize2.unit) === null || _heading6$fontSize2$u === void 0 ? void 0 : _heading6$fontSize2$u[deviceType]}`,
    'font-style': heading6 === null || heading6 === void 0 ? void 0 : heading6.fontStyle,
    'font-family': heading6 === null || heading6 === void 0 ? void 0 : heading6.fontFamily,
    'font-weight': heading6 === null || heading6 === void 0 ? void 0 : heading6.fontWeight,
    'letter-spacing': `${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$letterSpaci = heading6.letterSpacing) === null || _heading6$letterSpaci === void 0 ? void 0 : _heading6$letterSpaci[deviceType]}${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$letterSpaci2 = heading6.letterSpacing) === null || _heading6$letterSpaci2 === void 0 ? void 0 : _heading6$letterSpaci2.unit}`,
    'text-decoration': heading6 === null || heading6 === void 0 ? void 0 : heading6.textDecoration,
    'text-transform': heading6 === null || heading6 === void 0 ? void 0 : heading6.textTransform,
    'line-height': `${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$lineHeight = heading6.lineHeight) === null || _heading6$lineHeight === void 0 ? void 0 : _heading6$lineHeight[deviceType]}${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$lineHeight2 = heading6.lineHeight) === null || _heading6$lineHeight2 === void 0 ? void 0 : _heading6$lineHeight2.unit}`
  };
  styles[`[class*="wp-block-premium"] .premium-button, [class*="wp-block-premium"] .premium-pricing-table__button_link, [class*="wp-block-premium"] .premium-modal-box-modal-lower-close`] = {
    'font-size': `${button === null || button === void 0 ? void 0 : (_button$fontSize = button.fontSize) === null || _button$fontSize === void 0 ? void 0 : _button$fontSize[deviceType]}${button === null || button === void 0 ? void 0 : (_button$fontSize2 = button.fontSize) === null || _button$fontSize2 === void 0 ? void 0 : (_button$fontSize2$uni = _button$fontSize2.unit) === null || _button$fontSize2$uni === void 0 ? void 0 : _button$fontSize2$uni[deviceType]}`,
    'font-style': button === null || button === void 0 ? void 0 : button.fontStyle,
    'font-family': button === null || button === void 0 ? void 0 : button.fontFamily,
    'font-weight': button === null || button === void 0 ? void 0 : button.fontWeight,
    'letter-spacing': `${button === null || button === void 0 ? void 0 : (_button$letterSpacing = button.letterSpacing) === null || _button$letterSpacing === void 0 ? void 0 : _button$letterSpacing[deviceType]}${button === null || button === void 0 ? void 0 : (_button$letterSpacing2 = button.letterSpacing) === null || _button$letterSpacing2 === void 0 ? void 0 : _button$letterSpacing2.unit}`,
    'text-decoration': button === null || button === void 0 ? void 0 : button.textDecoration,
    'text-transform': button === null || button === void 0 ? void 0 : button.textTransform,
    'line-height': `${button === null || button === void 0 ? void 0 : (_button$lineHeight = button.lineHeight) === null || _button$lineHeight === void 0 ? void 0 : _button$lineHeight[deviceType]}${button === null || button === void 0 ? void 0 : (_button$lineHeight2 = button.lineHeight) === null || _button$lineHeight2 === void 0 ? void 0 : _button$lineHeight2.unit}`
  };
  styles[`.editor-styles-wrapper`] = {
    'font-size': `${paragraph === null || paragraph === void 0 ? void 0 : (_paragraph$fontSize = paragraph.fontSize) === null || _paragraph$fontSize === void 0 ? void 0 : _paragraph$fontSize[deviceType]}${paragraph === null || paragraph === void 0 ? void 0 : (_paragraph$fontSize2 = paragraph.fontSize) === null || _paragraph$fontSize2 === void 0 ? void 0 : (_paragraph$fontSize2$ = _paragraph$fontSize2.unit) === null || _paragraph$fontSize2$ === void 0 ? void 0 : _paragraph$fontSize2$[deviceType]}`,
    'font-style': paragraph === null || paragraph === void 0 ? void 0 : paragraph.fontStyle,
    'font-family': paragraph === null || paragraph === void 0 ? void 0 : paragraph.fontFamily,
    'font-weight': paragraph === null || paragraph === void 0 ? void 0 : paragraph.fontWeight,
    'letter-spacing': `${paragraph === null || paragraph === void 0 ? void 0 : (_paragraph$letterSpac = paragraph.letterSpacing) === null || _paragraph$letterSpac === void 0 ? void 0 : _paragraph$letterSpac[deviceType]}${paragraph === null || paragraph === void 0 ? void 0 : (_paragraph$letterSpac2 = paragraph.letterSpacing) === null || _paragraph$letterSpac2 === void 0 ? void 0 : _paragraph$letterSpac2.unit}`,
    'text-decoration': paragraph === null || paragraph === void 0 ? void 0 : paragraph.textDecoration,
    'text-transform': paragraph === null || paragraph === void 0 ? void 0 : paragraph.textTransform,
    'line-height': `${paragraph === null || paragraph === void 0 ? void 0 : (_paragraph$lineHeight = paragraph.lineHeight) === null || _paragraph$lineHeight === void 0 ? void 0 : _paragraph$lineHeight[deviceType]}${paragraph === null || paragraph === void 0 ? void 0 : (_paragraph$lineHeight2 = paragraph.lineHeight) === null || _paragraph$lineHeight2 === void 0 ? void 0 : _paragraph$lineHeight2.unit}`
  }; // Core Blocks Styles

  if (applyTypographyToDefault) {
    var _heading1$fontSize3, _heading1$fontSize4, _heading1$fontSize4$u, _heading1$letterSpaci3, _heading1$letterSpaci4, _heading1$lineHeight3, _heading1$lineHeight4, _heading2$fontSize3, _heading2$fontSize4, _heading2$fontSize4$u, _heading2$letterSpaci3, _heading2$letterSpaci4, _heading2$lineHeight3, _heading2$lineHeight4, _heading3$fontSize3, _heading3$fontSize4, _heading3$fontSize4$u, _heading3$letterSpaci3, _heading3$letterSpaci4, _heading3$lineHeight3, _heading3$lineHeight4, _heading4$fontSize3, _heading4$fontSize4, _heading4$fontSize4$u, _heading4$letterSpaci3, _heading4$letterSpaci4, _heading4$lineHeight3, _heading4$lineHeight4, _heading5$fontSize3, _heading5$fontSize4, _heading5$fontSize4$u, _heading5$letterSpaci3, _heading5$letterSpaci4, _heading5$lineHeight3, _heading5$lineHeight4, _heading6$fontSize3, _heading6$fontSize4, _heading6$fontSize4$u, _heading6$letterSpaci3, _heading6$letterSpaci4, _heading6$lineHeight3, _heading6$lineHeight4, _button$fontSize3, _button$fontSize4, _button$fontSize4$uni, _button$letterSpacing3, _button$letterSpacing4, _button$lineHeight3, _button$lineHeight4;

    styles['.editor-styles-wrapper h1[data-type^="core/"]'] = {
      'font-size': `${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$fontSize3 = heading1.fontSize) === null || _heading1$fontSize3 === void 0 ? void 0 : _heading1$fontSize3[deviceType]}${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$fontSize4 = heading1.fontSize) === null || _heading1$fontSize4 === void 0 ? void 0 : (_heading1$fontSize4$u = _heading1$fontSize4.unit) === null || _heading1$fontSize4$u === void 0 ? void 0 : _heading1$fontSize4$u[deviceType]}`,
      'font-style': heading1 === null || heading1 === void 0 ? void 0 : heading1.fontStyle,
      'font-family': heading1 === null || heading1 === void 0 ? void 0 : heading1.fontFamily,
      'font-weight': heading1 === null || heading1 === void 0 ? void 0 : heading1.fontWeight,
      'letter-spacing': `${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$letterSpaci3 = heading1.letterSpacing) === null || _heading1$letterSpaci3 === void 0 ? void 0 : _heading1$letterSpaci3[deviceType]}${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$letterSpaci4 = heading1.letterSpacing) === null || _heading1$letterSpaci4 === void 0 ? void 0 : _heading1$letterSpaci4.unit}`,
      'text-decoration': heading1 === null || heading1 === void 0 ? void 0 : heading1.textDecoration,
      'text-transform': heading1 === null || heading1 === void 0 ? void 0 : heading1.textTransform,
      'line-height': `${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$lineHeight3 = heading1.lineHeight) === null || _heading1$lineHeight3 === void 0 ? void 0 : _heading1$lineHeight3[deviceType]}${heading1 === null || heading1 === void 0 ? void 0 : (_heading1$lineHeight4 = heading1.lineHeight) === null || _heading1$lineHeight4 === void 0 ? void 0 : _heading1$lineHeight4.unit}`
    };
    styles['.editor-styles-wrapper h2[data-type^="core/"]'] = {
      'font-size': `${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$fontSize3 = heading2.fontSize) === null || _heading2$fontSize3 === void 0 ? void 0 : _heading2$fontSize3[deviceType]}${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$fontSize4 = heading2.fontSize) === null || _heading2$fontSize4 === void 0 ? void 0 : (_heading2$fontSize4$u = _heading2$fontSize4.unit) === null || _heading2$fontSize4$u === void 0 ? void 0 : _heading2$fontSize4$u[deviceType]}`,
      'font-style': heading2 === null || heading2 === void 0 ? void 0 : heading2.fontStyle,
      'font-family': heading2 === null || heading2 === void 0 ? void 0 : heading2.fontFamily,
      'font-weight': heading2 === null || heading2 === void 0 ? void 0 : heading2.fontWeight,
      'letter-spacing': `${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$letterSpaci3 = heading2.letterSpacing) === null || _heading2$letterSpaci3 === void 0 ? void 0 : _heading2$letterSpaci3[deviceType]}${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$letterSpaci4 = heading2.letterSpacing) === null || _heading2$letterSpaci4 === void 0 ? void 0 : _heading2$letterSpaci4.unit}`,
      'text-decoration': heading2 === null || heading2 === void 0 ? void 0 : heading2.textDecoration,
      'text-transform': heading2 === null || heading2 === void 0 ? void 0 : heading2.textTransform,
      'line-height': `${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$lineHeight3 = heading2.lineHeight) === null || _heading2$lineHeight3 === void 0 ? void 0 : _heading2$lineHeight3[deviceType]}${heading2 === null || heading2 === void 0 ? void 0 : (_heading2$lineHeight4 = heading2.lineHeight) === null || _heading2$lineHeight4 === void 0 ? void 0 : _heading2$lineHeight4.unit}`
    };
    styles['.editor-styles-wrapper h3[data-type^="core/"]'] = {
      'font-size': `${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$fontSize3 = heading3.fontSize) === null || _heading3$fontSize3 === void 0 ? void 0 : _heading3$fontSize3[deviceType]}${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$fontSize4 = heading3.fontSize) === null || _heading3$fontSize4 === void 0 ? void 0 : (_heading3$fontSize4$u = _heading3$fontSize4.unit) === null || _heading3$fontSize4$u === void 0 ? void 0 : _heading3$fontSize4$u[deviceType]}`,
      'font-style': heading3 === null || heading3 === void 0 ? void 0 : heading3.fontStyle,
      'font-family': heading3 === null || heading3 === void 0 ? void 0 : heading3.fontFamily,
      'font-weight': heading3 === null || heading3 === void 0 ? void 0 : heading3.fontWeight,
      'letter-spacing': `${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$letterSpaci3 = heading3.letterSpacing) === null || _heading3$letterSpaci3 === void 0 ? void 0 : _heading3$letterSpaci3[deviceType]}${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$letterSpaci4 = heading3.letterSpacing) === null || _heading3$letterSpaci4 === void 0 ? void 0 : _heading3$letterSpaci4.unit}`,
      'text-decoration': heading3 === null || heading3 === void 0 ? void 0 : heading3.textDecoration,
      'text-transform': heading3 === null || heading3 === void 0 ? void 0 : heading3.textTransform,
      'line-height': `${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$lineHeight3 = heading3.lineHeight) === null || _heading3$lineHeight3 === void 0 ? void 0 : _heading3$lineHeight3[deviceType]}${heading3 === null || heading3 === void 0 ? void 0 : (_heading3$lineHeight4 = heading3.lineHeight) === null || _heading3$lineHeight4 === void 0 ? void 0 : _heading3$lineHeight4.unit}`
    };
    styles['.editor-styles-wrapper h4[data-type^="core/"]'] = {
      'font-size': `${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$fontSize3 = heading4.fontSize) === null || _heading4$fontSize3 === void 0 ? void 0 : _heading4$fontSize3[deviceType]}${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$fontSize4 = heading4.fontSize) === null || _heading4$fontSize4 === void 0 ? void 0 : (_heading4$fontSize4$u = _heading4$fontSize4.unit) === null || _heading4$fontSize4$u === void 0 ? void 0 : _heading4$fontSize4$u[deviceType]}`,
      'font-style': heading4 === null || heading4 === void 0 ? void 0 : heading4.fontStyle,
      'font-family': heading4 === null || heading4 === void 0 ? void 0 : heading4.fontFamily,
      'font-weight': heading4 === null || heading4 === void 0 ? void 0 : heading4.fontWeight,
      'letter-spacing': `${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$letterSpaci3 = heading4.letterSpacing) === null || _heading4$letterSpaci3 === void 0 ? void 0 : _heading4$letterSpaci3[deviceType]}${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$letterSpaci4 = heading4.letterSpacing) === null || _heading4$letterSpaci4 === void 0 ? void 0 : _heading4$letterSpaci4.unit}`,
      'text-decoration': heading4 === null || heading4 === void 0 ? void 0 : heading4.textDecoration,
      'text-transform': heading4 === null || heading4 === void 0 ? void 0 : heading4.textTransform,
      'line-height': `${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$lineHeight3 = heading4.lineHeight) === null || _heading4$lineHeight3 === void 0 ? void 0 : _heading4$lineHeight3[deviceType]}${heading4 === null || heading4 === void 0 ? void 0 : (_heading4$lineHeight4 = heading4.lineHeight) === null || _heading4$lineHeight4 === void 0 ? void 0 : _heading4$lineHeight4.unit}`
    };
    styles['.editor-styles-wrapper h5[data-type^="core/"]'] = {
      'font-size': `${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$fontSize3 = heading5.fontSize) === null || _heading5$fontSize3 === void 0 ? void 0 : _heading5$fontSize3[deviceType]}${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$fontSize4 = heading5.fontSize) === null || _heading5$fontSize4 === void 0 ? void 0 : (_heading5$fontSize4$u = _heading5$fontSize4.unit) === null || _heading5$fontSize4$u === void 0 ? void 0 : _heading5$fontSize4$u[deviceType]}`,
      'font-style': heading5 === null || heading5 === void 0 ? void 0 : heading5.fontStyle,
      'font-family': heading5 === null || heading5 === void 0 ? void 0 : heading5.fontFamily,
      'font-weight': heading5 === null || heading5 === void 0 ? void 0 : heading5.fontWeight,
      'letter-spacing': `${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$letterSpaci3 = heading5.letterSpacing) === null || _heading5$letterSpaci3 === void 0 ? void 0 : _heading5$letterSpaci3[deviceType]}${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$letterSpaci4 = heading5.letterSpacing) === null || _heading5$letterSpaci4 === void 0 ? void 0 : _heading5$letterSpaci4.unit}`,
      'text-decoration': heading5 === null || heading5 === void 0 ? void 0 : heading5.textDecoration,
      'text-transform': heading5 === null || heading5 === void 0 ? void 0 : heading5.textTransform,
      'line-height': `${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$lineHeight3 = heading5.lineHeight) === null || _heading5$lineHeight3 === void 0 ? void 0 : _heading5$lineHeight3[deviceType]}${heading5 === null || heading5 === void 0 ? void 0 : (_heading5$lineHeight4 = heading5.lineHeight) === null || _heading5$lineHeight4 === void 0 ? void 0 : _heading5$lineHeight4.unit}`
    };
    styles['.editor-styles-wrapper h6[data-type^="core/"]'] = {
      'font-size': `${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$fontSize3 = heading6.fontSize) === null || _heading6$fontSize3 === void 0 ? void 0 : _heading6$fontSize3[deviceType]}${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$fontSize4 = heading6.fontSize) === null || _heading6$fontSize4 === void 0 ? void 0 : (_heading6$fontSize4$u = _heading6$fontSize4.unit) === null || _heading6$fontSize4$u === void 0 ? void 0 : _heading6$fontSize4$u[deviceType]}`,
      'font-style': heading6 === null || heading6 === void 0 ? void 0 : heading6.fontStyle,
      'font-family': heading6 === null || heading6 === void 0 ? void 0 : heading6.fontFamily,
      'font-weight': heading6 === null || heading6 === void 0 ? void 0 : heading6.fontWeight,
      'letter-spacing': `${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$letterSpaci3 = heading6.letterSpacing) === null || _heading6$letterSpaci3 === void 0 ? void 0 : _heading6$letterSpaci3[deviceType]}${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$letterSpaci4 = heading6.letterSpacing) === null || _heading6$letterSpaci4 === void 0 ? void 0 : _heading6$letterSpaci4.unit}`,
      'text-decoration': heading6 === null || heading6 === void 0 ? void 0 : heading6.textDecoration,
      'text-transform': heading6 === null || heading6 === void 0 ? void 0 : heading6.textTransform,
      'line-height': `${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$lineHeight3 = heading6.lineHeight) === null || _heading6$lineHeight3 === void 0 ? void 0 : _heading6$lineHeight3[deviceType]}${heading6 === null || heading6 === void 0 ? void 0 : (_heading6$lineHeight4 = heading6.lineHeight) === null || _heading6$lineHeight4 === void 0 ? void 0 : _heading6$lineHeight4.unit}`
    };
    styles['.wp-block-button > div, .wp-block-button > .wp-block-button__link'] = {
      'font-size': `${button === null || button === void 0 ? void 0 : (_button$fontSize3 = button.fontSize) === null || _button$fontSize3 === void 0 ? void 0 : _button$fontSize3[deviceType]}${button === null || button === void 0 ? void 0 : (_button$fontSize4 = button.fontSize) === null || _button$fontSize4 === void 0 ? void 0 : (_button$fontSize4$uni = _button$fontSize4.unit) === null || _button$fontSize4$uni === void 0 ? void 0 : _button$fontSize4$uni[deviceType]}`,
      'font-style': button === null || button === void 0 ? void 0 : button.fontStyle,
      'font-family': button === null || button === void 0 ? void 0 : button.fontFamily,
      'font-weight': button === null || button === void 0 ? void 0 : button.fontWeight,
      'letter-spacing': `${button === null || button === void 0 ? void 0 : (_button$letterSpacing3 = button.letterSpacing) === null || _button$letterSpacing3 === void 0 ? void 0 : _button$letterSpacing3[deviceType]}${button === null || button === void 0 ? void 0 : (_button$letterSpacing4 = button.letterSpacing) === null || _button$letterSpacing4 === void 0 ? void 0 : _button$letterSpacing4.unit}`,
      'text-decoration': button === null || button === void 0 ? void 0 : button.textDecoration,
      'text-transform': button === null || button === void 0 ? void 0 : button.textTransform,
      'line-height': `${button === null || button === void 0 ? void 0 : (_button$lineHeight3 = button.lineHeight) === null || _button$lineHeight3 === void 0 ? void 0 : _button$lineHeight3[deviceType]}${button === null || button === void 0 ? void 0 : (_button$lineHeight4 = button.lineHeight) === null || _button$lineHeight4 === void 0 ? void 0 : _button$lineHeight4.unit}`
    };
  }

  css += (0,_components_HelperFunction__WEBPACK_IMPORTED_MODULE_7__.generateCss)(styles);
  return css;
};

const loadFonts = function (globalTypography) {
  let editorDom = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

  if (globalTypography && Object.keys(globalTypography).length) {
    Object.values(globalTypography).map(value => {
      if (value !== null && value !== void 0 && value.fontFamily && (value === null || value === void 0 ? void 0 : value.fontFamily) !== 'Default') {
        webfontloader__WEBPACK_IMPORTED_MODULE_8___default().load({
          google: {
            families: [`${value === null || value === void 0 ? void 0 : value.fontFamily}:900,700,600,500,400,300,200,100,100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic`]
          },
          context: editorDom || ''
        });
      }
    });
  }
};

const PremiumSidebar = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_store_settings_store__WEBPACK_IMPORTED_MODULE_4__.SettingsProvider, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_ui__WEBPACK_IMPORTED_MODULE_3__["default"], null));
};

const PluginSidebarPostEditor = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_2__.PluginSidebarMoreMenuItem, {
    target: "premium-sidebar",
    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SidebarIconItem, null)
  }, __('Premium Blocks')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_2__.PluginSidebar, {
    name: "premium-sidebar",
    icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SidebarIcon, null),
    title: __('Premium Blocks', "premium-blocks-for-gutenberg")
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PremiumSidebar, null)));
};

const PremiumGlobalStyles = () => {
  const {
    globalColors,
    colorPalette,
    globalTypography,
    deviceType,
    applyColorsToDefault,
    applyTypographyToDefault,
    layoutSettings
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_5__.useSelect)(select => {
    var _getEditedEntityRecor, _getEditedEntityRecor2, _getEditedEntityRecor3, _getEditedEntityRecor4, _getEditedEntityRecor5, _getEditedEntityRecor6;

    const {
      __experimentalGetPreviewDeviceType = null
    } = select('core/edit-post');
    let deviceType = __experimentalGetPreviewDeviceType ? __experimentalGetPreviewDeviceType() : null;
    const {
      getEditedEntityRecord
    } = select(_wordpress_core_data__WEBPACK_IMPORTED_MODULE_6__.store);
    const pbgGlobalColors = ((_getEditedEntityRecor = getEditedEntityRecord('root', 'site')) === null || _getEditedEntityRecor === void 0 ? void 0 : _getEditedEntityRecor.pbg_global_colors) || [];
    const pbgDefaultPalette = ((_getEditedEntityRecor2 = getEditedEntityRecord('root', 'site')) === null || _getEditedEntityRecor2 === void 0 ? void 0 : _getEditedEntityRecor2.pbg_global_color_palette) || 'theme';
    const globalTypography = ((_getEditedEntityRecor3 = getEditedEntityRecord('root', 'site')) === null || _getEditedEntityRecor3 === void 0 ? void 0 : _getEditedEntityRecor3.pbg_global_typography) || [];
    const applyColorsToDefault = ((_getEditedEntityRecor4 = getEditedEntityRecord('root', 'site')) === null || _getEditedEntityRecor4 === void 0 ? void 0 : _getEditedEntityRecor4.pbg_global_colors_to_default) || false;
    const applyTypographyToDefault = ((_getEditedEntityRecor5 = getEditedEntityRecord('root', 'site')) === null || _getEditedEntityRecor5 === void 0 ? void 0 : _getEditedEntityRecor5.pbg_global_typography_to_default) || false;
    const pbgLayoutSettings = ((_getEditedEntityRecor6 = getEditedEntityRecord('root', 'site')) === null || _getEditedEntityRecor6 === void 0 ? void 0 : _getEditedEntityRecor6.pbg_global_layout) || false;
    return {
      globalColors: pbgGlobalColors,
      colorPalette: pbgDefaultPalette,
      globalTypography: globalTypography,
      deviceType,
      applyColorsToDefault,
      applyTypographyToDefault,
      layoutSettings: pbgLayoutSettings
    };
  }, []);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    var _siteEditorDom$conten, _siteEditorDom$conten2, _siteEditorDom$conten3;

    const loadStyleSheet = editorDom => {
      const css = loadGlobalStyles({
        globalColors,
        colorPalette,
        globalTypography,
        deviceType,
        applyColorsToDefault,
        applyTypographyToDefault,
        layoutSettings
      });
      const styleSheet = editorDom.querySelector('#premium-style-preview-css');

      if (styleSheet) {
        if (styleSheet.styleSheet) {
          styleSheet.styleSheet.cssText = css;
        } else {
          styleSheet.innerHTML = css;
        }
      } else {
        const style = document.createElement('style');
        style.setAttribute('id', 'premium-style-preview-css');
        editorDom.appendChild(style);
        style.type = 'text/css';

        if (style.styleSheet) {
          style.styleSheet.cssText = css;
        } else {
          style.appendChild(document.createTextNode(css));
        }
      }
    };

    const postEditorDom = document.querySelector(`.editor-styles-wrapper`);

    if (postEditorDom) {
      loadFonts(globalTypography);
      loadStyleSheet(postEditorDom);
      return;
    }

    let interval = null;
    let siteEditorDom = document.querySelector(`iframe[name="editor-canvas"]`);

    if (siteEditorDom && (_siteEditorDom$conten = siteEditorDom.contentDocument) !== null && _siteEditorDom$conten !== void 0 && (_siteEditorDom$conten2 = _siteEditorDom$conten.body) !== null && _siteEditorDom$conten2 !== void 0 && (_siteEditorDom$conten3 = _siteEditorDom$conten2.childNodes) !== null && _siteEditorDom$conten3 !== void 0 && _siteEditorDom$conten3.length) {
      const editorBody = siteEditorDom.contentDocument.body;
      loadFonts(globalTypography, siteEditorDom.contentWindow);
      loadStyleSheet(editorBody);
    } else {
      interval = setInterval(() => {
        siteEditorDom = document.querySelector(`iframe[name="editor-canvas"]`);

        if (siteEditorDom) {
          var _editorBody$childNode;

          const editorBody = siteEditorDom.contentDocument.body;

          if (editorBody && (editorBody === null || editorBody === void 0 ? void 0 : (_editorBody$childNode = editorBody.childNodes) === null || _editorBody$childNode === void 0 ? void 0 : _editorBody$childNode.length) !== 0) {
            clearInterval(interval);
            loadFonts(globalTypography, siteEditorDom.contentWindow);
            loadStyleSheet(editorBody);
          }
        }
      }, 200);
    }

    return () => {
      clearInterval(interval);
    };
  }, [globalColors, colorPalette, globalTypography, deviceType, applyColorsToDefault, applyTypographyToDefault, layoutSettings]);
  return null;
};

(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_1__.registerPlugin)('plugin-premium-blocks-styles', {
  render: PremiumGlobalStyles
});
(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_1__.registerPlugin)('plugin-premium-blocks', {
  render: PluginSidebarPostEditor
});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map