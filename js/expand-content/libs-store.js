/* remove this before going to prod... */
var s_omni = {};

/* Namespace.js */

/*global window */
window.Namespace = 'Global';
/**
 * @namespace Bodybuilding.com Namespace
 * @version 1.1
 * @author Scott Byrns
 */
var BB = {
    /**
     * @namespace Interfaces namespace
     */
    Interfaces: {
        Geom: {
        }
    },
    /**
     * @namespace Application namespace
     */
    App: {
    },
    /**
     * @namespace Core namespace
     */
    Core: {
    },
    /**
     * @namespace Forms namespace
     */
    Forms: {
    },
    /**
     * @namespace Geometry namespace
     */
    Geom: {
    },
    /**
     * @namespace Helpers namespace
     */
    Helpers: {
        /**
         * @namespace Application namespace
         */
        App: {
        },
        /**
         * @namespace Core namespace
         */
        Core: {
        },
        /**
         * @namespace Geometry namespace
         */
        Geom: {
        },
        /**
         * @namespace User Interface namespace
         */
        UI: {
        },
        /**
         * @namespace Utility namespace
         */
        Util: {
        },
        /**
         * @namespace Constants namespace
         */
        Const: {
        }
    },
    /**
     * @namespace User Interface namespace
     */
    UI: {
    },
    /**
     * @namespace Utility namespace
     */
    Util: {
    },
    /**
     * @namespace Constants namespace
     */
    Const: {
        CSS_VER: '',
        developmentMode: false,
        widgetCoreTwo: false
    },
    /**
     * @namespace Instances namespace
     */
    Instances: {
    },
    /**
     * @namespace Controllers namespace
     */
    Controller: {
    },
    /**
     * @namespace Log namespace
     */
    Log: {
    },
    /**
     * Plugin namespace
     */
    Plugins: {
    
    }
};

/*
 * BAsic prototype extension for various objects
 */

if (!String.prototype.trim) {
    String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g,'');};
}

if (!String.prototype.unescapeHTML) {
    String.prototype.unescapeHTML = function () {
        var temp = document.createElement("div");
        temp.innerHTML = this;
        var result;
        if (temp.childNodes.length !== 0) {
            result = temp.childNodes[0].nodeValue;
            temp.removeChild(temp.firstChild);
        } else {
            result = '';
        }
        return result;
    };
}

if (!Array.prototype.clean) {
    Array.prototype.clean = function(d) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == d) {         
                this.splice(i, 1);
                i--;
            }
        }
        return this;
    };
}

if (!Array.prototype.remove) {
    Array.prototype.remove= function(){
        var what, a= arguments, L= a.length, ax;
        while(L && this.length){
            what= a[--L];
            while((ax= this.indexOf(what))!= -1){
                this.splice(ax, 1);
            }
        }
        return this;
    }
}

if (!Array.prototype.removeRange) {
    Array.prototype.removeRange = function(from, to) {
        var rest = this.slice((to || from) + 1 || this.length);
        this.length = from < 0 ? this.length + from : from;
        return this.push.apply(this, rest);
    };
}

if (!Array.prototype.removeValue) {
    Array.prototype.removeValue = function(value) {
        var index = this.indexOf(value);
        return (index < 0) ? this.length : this.removeRange(index);
    };
}

/*
 * Copyright (c) 2010 Nick Galbreath
 * http://code.google.com/p/stringencoders/source/browse/#svn/trunk/javascript
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
*/

/* base64 encode/decode compatible with window.btoa/atob
 *
 * window.atob/btoa is a Firefox extension to convert binary data (the "b")
 * to base64 (ascii, the "a").
 *
 * It is also found in Safari and Chrome.  It is not available in IE.
 *
 * if (!window.btoa) window.btoa = base64.encode
 * if (!window.atob) window.atob = base64.decode
 *
 * The original spec's for atob/btoa are a bit lacking
 * https://developer.mozilla.org/en/DOM/window.atob
 * https://developer.mozilla.org/en/DOM/window.btoa
 *
 * window.btoa and base64.encode takes a string where charCodeAt is [0,255]
 * If any character is not [0,255], then an exception is thrown.
 *
 * window.atob and base64.decode take a base64-encoded string
 * If the input length is not a multiple of 4, or contains invalid characters
 *   then an exception is thrown.
 */
(function () {
    var base64 = {};
    base64.PADCHAR = '=';
    base64.ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    base64.getbyte64 = function(s,i) {
        // This is oddly fast, except on Chrome/V8.
        //  Minimal or no improvement in performance by using a
        //   object with properties mapping chars to value (eg. 'A': 0)
        var idx = base64.ALPHA.indexOf(s.charAt(i));
        if (idx == -1) {
            throw "Cannot decode base64";
        }
        return idx;
    };

    base64.decode = function(s) {
        // convert to string
        s = "" + s;
        var getbyte64 = base64.getbyte64;
        var pads, i, b10;
        var imax = s.length
        if (imax == 0) {
            return s;
        }

        if (imax % 4 != 0) {
            throw "Cannot decode base64";
        }

        pads = 0
        if (s.charAt(imax -1) == base64.PADCHAR) {
            pads = 1;
            if (s.charAt(imax -2) == base64.PADCHAR) {
                pads = 2;
            }
            // either way, we want to ignore this last block
            imax -= 4;
        }

        var x = [];
        for (i = 0; i < imax; i += 4) {
            b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12) |
                (getbyte64(s,i+2) << 6) | getbyte64(s,i+3);
            x.push(String.fromCharCode(b10 >> 16, (b10 >> 8) & 0xff, b10 & 0xff));
        }

        switch (pads) {
        case 1:
            b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12) | (getbyte64(s,i+2) << 6)
            x.push(String.fromCharCode(b10 >> 16, (b10 >> 8) & 0xff));
            break;
        case 2:
            b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12);
            x.push(String.fromCharCode(b10 >> 16));
            break;
        }
        return x.join('');
    };

    base64.getbyte = function(s,i) {
        var x = s.charCodeAt(i);
        if (x > 255) {
            throw "INVALID_CHARACTER_ERR: DOM Exception 5";
        }
        return x;
    };


    base64.encode = function(s) {
        if (arguments.length != 1) {
            throw "SyntaxError: Not enough arguments";
        }
        var padchar = base64.PADCHAR;
        var alpha   = base64.ALPHA;
        var getbyte = base64.getbyte;

        var i, b10;
        var x = [];

        // convert to string
        s = "" + s;

        var imax = s.length - s.length % 3;

        if (s.length == 0) {
            return s;
        }
        for (i = 0; i < imax; i += 3) {
            b10 = (getbyte(s,i) << 16) | (getbyte(s,i+1) << 8) | getbyte(s,i+2);
            x.push(alpha.charAt(b10 >> 18));
            x.push(alpha.charAt((b10 >> 12) & 0x3F));
            x.push(alpha.charAt((b10 >> 6) & 0x3f));
            x.push(alpha.charAt(b10 & 0x3f));
        }
        switch (s.length - imax) {
        case 1:
            b10 = getbyte(s,i) << 16;
            x.push(alpha.charAt(b10 >> 18) + alpha.charAt((b10 >> 12) & 0x3F) +
                   padchar + padchar);
            break;
        case 2:
            b10 = (getbyte(s,i) << 16) | (getbyte(s,i+1) << 8);
            x.push(alpha.charAt(b10 >> 18) + alpha.charAt((b10 >> 12) & 0x3F) +
                   alpha.charAt((b10 >> 6) & 0x3f) + padchar);
            break;
        }
        return x.join('');
    };
    
    if (!window.btoa) {window.btoa = base64.encode;}
    if (!window.atob) {window.atob = base64.decode;}
})();

//Create a JSON object only if one does not already exist. We create the
//methods in a closure to avoid creating global variables.

if (!this.JSON) {
 /**
  * @namespace
  */
 this.JSON = {};
}

(function () {

 function f(n) {
     // Format integers to have at least two digits.
     return n < 10 ? '0' + n : n;
 }

 if (typeof Date.prototype.toJSON !== 'function') {

     Date.prototype.toJSON = function (key) {

         return isFinite(this.valueOf()) ?
                this.getUTCFullYear()   + '-' +
              f(this.getUTCMonth() + 1) + '-' +
              f(this.getUTCDate())      + 'T' +
              f(this.getUTCHours())     + ':' +
              f(this.getUTCMinutes())   + ':' +
              f(this.getUTCSeconds())   + 'Z' : null;
     };

     String.prototype.toJSON =
     Number.prototype.toJSON =
     Boolean.prototype.toJSON = function (key) {
         return this.valueOf();
     };
 }

 var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
     escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
     gap,
     indent,
     meta = {    // table of character substitutions
         '\b': '\\b',
         '\t': '\\t',
         '\n': '\\n',
         '\f': '\\f',
         '\r': '\\r',
         '"' : '\\"',
         '\\': '\\\\'
     },
     rep;


 function quote(string) {

//If the string contains no control characters, no quote characters, and no
//backslash characters, then we can safely slap some quotes around it.
//Otherwise we must also replace the offending characters with safe escape
//sequences.

     escapable.lastIndex = 0;
     return escapable.test(string) ?
         '"' + string.replace(escapable, function (a) {
             var c = meta[a];
             return typeof c === 'string' ? c :
                 '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
         }) + '"' :
         '"' + string + '"';
 }


 function str(key, holder) {

//Produce a string from holder[key].

     var i,          // The loop counter.
         k,          // The member key.
         v,          // The member value.
         length,
         mind = gap,
         partial,
         value = holder[key];

//If the value has a toJSON method, call it to obtain a replacement value.

     if (value && typeof value === 'object' &&
             typeof value.toJSON === 'function') {
         value = value.toJSON(key);
     }

//If we were called with a replacer function, then call the replacer to
//obtain a replacement value.

     if (typeof rep === 'function') {
         value = rep.call(holder, key, value);
     }

//What happens next depends on the value's type.

     switch (typeof value) {
     case 'string':
         return quote(value);

     case 'number':

//JSON numbers must be finite. Encode non-finite numbers as null.

         return isFinite(value) ? String(value) : 'null';

     case 'boolean':
     case 'null':

//If the value is a boolean or null, convert it to a string. Note:
//typeof null does not produce 'null'. The case is included here in
//the remote chance that this gets fixed someday.

         return String(value);

//If the type is 'object', we might be dealing with an object or an array or
//null.

     case 'object':

//Due to a specification blunder in ECMAScript, typeof null is 'object',
//so watch out for that case.

         if (!value) {
             return 'null';
         }

//Make an array to hold the partial results of stringifying this object value.

         gap += indent;
         partial = [];

//Is the value an array?

         if (Object.prototype.toString.apply(value) === '[object Array]') {

//The value is an array. Stringify every element. Use null as a placeholder
//for non-JSON values.

             length = value.length;
             for (i = 0; i < length; i += 1) {
                 partial[i] = str(i, value) || 'null';
             }

//Join all of the elements together, separated with commas, and wrap them in
//brackets.

             v = partial.length === 0 ? '[]' :
                 gap ? '[\n' + gap +
                         partial.join(',\n' + gap) + '\n' +
                             mind + ']' :
                       '[' + partial.join(',') + ']';
             gap = mind;
             return v;
         }

//If the replacer is an array, use it to select the members to be stringified.

         if (rep && typeof rep === 'object') {
             length = rep.length;
             for (i = 0; i < length; i += 1) {
                 k = rep[i];
                 if (typeof k === 'string') {
                     v = str(k, value);
                     if (v) {
                         partial.push(quote(k) + (gap ? ': ' : ':') + v);
                     }
                 }
             }
         } else {

//Otherwise, iterate through all of the keys in the object.

             for (k in value) {
                 if (Object.hasOwnProperty.call(value, k)) {
                     v = str(k, value);
                     if (v) {
                         partial.push(quote(k) + (gap ? ': ' : ':') + v);
                     }
                 }
             }
         }

//Join all of the member texts together, separated with commas,
//and wrap them in braces.

         v = partial.length === 0 ? '{}' :
             gap ? '{\n' + gap + partial.join(',\n' + gap) + '\n' +
                     mind + '}' : '{' + partial.join(',') + '}';
         gap = mind;
         return v;
     }
 }

//If the JSON object does not yet have a stringify method, give it one.

 if (typeof JSON.stringify !== 'function') {
     /**
      * This method produces a JSON text from a JavaScript value. <br /><br />
      * When an object value is found, if the object contains a toJSON
      * method, its toJSON method will be called and the result will be
      * stringified. A toJSON method does not serialize: it returns the
      * value represented by the name/value pair that should be serialized,
      * or undefined if nothing should be serialized. The toJSON method
      * will be passed the key associated with the value, and this will be
      * bound to the value
      * For example, this would serialize Dates as ISO strings. <br /><br />
      * <code>
      *     Date.prototype.toJSON = function (key) {
      *         function f(n) {
      *             // Format integers to have at least two digits.
      *             return n < 10 ? '0' + n : n;
      *         }
      * 
      *         return this.getUTCFullYear()   + '-' +
      *              f(this.getUTCMonth() + 1) + '-' +
      *              f(this.getUTCDate())      + 'T' +
      *              f(this.getUTCHours())     + ':' +
      *              f(this.getUTCMinutes())   + ':' +
      *              f(this.getUTCSeconds())   + 'Z';
      *     };
      * </code>
      * You can provide an optional replacer method. It will be passed the
      * key and value of each member, with this bound to the containing
      * object. The value that is returned from your method will be
      * serialized. If your method returns undefined, then the member will
      * be excluded from the serialization. <br /><br />
      * 
      * If the replacer parameter is an array of strings, then it will be
      * used to select the members to be serialized. It filters the results
      * such that only members with keys listed in the replacer array are
      * stringified. <br /><br />
      * 
      * Values that do not have JSON representations, such as undefined or
      * functions, will not be serialized. Such values in objects will be
      * dropped; in arrays they will be replaced with null. You can use
      * a replacer function to replace those with JSON values.
      * JSON.stringify(undefined) returns undefined. <br /><br />
      * 
      * The optional space parameter produces a stringification of the
      * value that is filled with line breaks and indentation to make it
      * easier to read. <br /><br />
      * 
      * If the space parameter is a non-empty string, then that string will
      * be used for indentation. If the space parameter is a number, then
      * the indentation will be that many spaces. <br /><br />
      * 
      * @name JSON#stringify
      * @function
      * @member JSON
      * @exports stringify as JSON.stringify
      * 
      * @param {Any} value any JavaScript value, usually an object or array.
      * @param {Function|String} replacer an optional parameter that determines how object
      * values are stringified for objects. It can be a
      * function or an array of strings.
      * @param {Number|String} space an optional parameter that specifies the indentation
      * of nested structures. If it is omitted, the text will
      * be packed without extra whitespace. If it is a number,
      * it will specify the number of spaces to indent at each
      * level. If it is a string (such as '\t' or '&nbsp;'),
      * it contains the characters used to indent at each level.
      * @example
      * text = JSON.stringify(['e', {pluribus: 'unum'}]);
      * // text is '["e",{"pluribus":"unum"}]'
      * 
      * 
      * text = JSON.stringify(['e', {pluribus: 'unum'}], null, '\t');
      * // text is '[\n\t"e",\n\t{\n\t\t"pluribus": "unum"\n\t}\n]'
      * 
      * text = JSON.stringify([new Date()], function (key, value) {
      *     return this[key] instanceof Date ?
      *         'Date(' + this[key] + ')' : value;
      * });
      * // text is '["Date(---current time---)"]'
      */
     JSON.stringify = function (value, replacer, space) {

//The stringify method takes a value and an optional replacer, and an optional
//space parameter, and returns a JSON text. The replacer can be a function
//that can replace values, or an array of strings that will select the keys.
//A default replacer method can be provided. Use of the space parameter can
//produce text that is more easily readable.

         var i;
         gap = '';
         indent = '';

//If the space parameter is a number, make an indent string containing that
//many spaces.

         if (typeof space === 'number') {
             for (i = 0; i < space; i += 1) {
                 indent += ' ';
             }

//If the space parameter is a string, it will be used as the indent string.

         } else if (typeof space === 'string') {
             indent = space;
         }

//If there is a replacer, it must be a function or an array.
//Otherwise, throw an error.

         rep = replacer;
         if (replacer && typeof replacer !== 'function' &&
                 (typeof replacer !== 'object' ||
                  typeof replacer.length !== 'number')) {
             throw new Error('JSON.stringify');
         }

//Make a fake root object containing our value under the key of ''.
//Return the result of stringifying the value.

         return str('', {'': value});
     };
 }


//If the JSON object does not yet have a parse method, give it one.

 if (typeof JSON.parse !== 'function') {
     /**
      * This method parses a JSON text to produce an object or array.
      * It can throw a SyntaxError exception.
      * <br /><br />
      * The optional reviver parameter is a function that can filter and
      * transform the results. It receives each of the keys and values,
      * and its return value is used instead of the original value.
      * If it returns what it received, then the structure is not modified.
      * If it returns undefined then the member is deleted.
      * @name JSON#parse
      * @function
      * @member JSON
      * @exports parse as JSON.parse
      * @example
      * 
      * // Parse the text. Values that look like ISO date strings will
      * // be converted to Date objects.
      * 
      * myData = JSON.parse(text, function (key, value) {
      *     var a;
      *     if (typeof value === 'string') {
      *         a =
      * /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2}(?:\.\d*)?)Z$/.exec(value);
      *         if (a) {
      *             return new Date(Date.UTC(+a[1], +a[2] - 1, +a[3], +a[4],
      *                 +a[5], +a[6]));
      *         }
      *     }
      *     return value;
      * });
      * 
      * myData = JSON.parse('["Date(09/09/2001)"]', function (key, value) {
      *     var d;
      *     if (typeof value === 'string' &&
      *             value.slice(0, 5) === 'Date(' &&
      *             value.slice(-1) === ')') {
      *         d = new Date(value.slice(5, -1));
      *         if (d) {
      *             return d;
      *         }
      *     }
      *     return value;
      * });
      */
     JSON.parse = function (text, reviver) {

/*The parse method takes a text and an optional reviver function, and returns
a JavaScript value if the text is a valid JSON text.*/

         var j;

         function walk(holder, key) {

/*The walk method is used to recursively walk the resulting structure so
that modifications can be made.*/

             var k, v, value = holder[key];
             if (value && typeof value === 'object') {
                 for (k in value) {
                     if (Object.hasOwnProperty.call(value, k)) {
                         v = walk(value, k);
                         if (v !== undefined) {
                             value[k] = v;
                         } else {
                             delete value[k];
                         }
                     }
                 }
             }
             return reviver.call(holder, key, value);
         }


//Parsing happens in four stages. In the first stage, we replace certain
//Unicode characters with escape sequences. JavaScript handles many characters
//incorrectly, either silently deleting them, or treating them as line endings.

         text = String(text);
         cx.lastIndex = 0;
         if (cx.test(text)) {
             text = text.replace(cx, function (a) {
                 return '\\u' +
                     ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
             });
         }

//In the second stage, we run the text against regular expressions that look
//for non-JSON patterns. We are especially concerned with '()' and 'new'
//because they can cause invocation, and '=' because it can cause mutation.
//But just to be safe, we want to reject all unexpected forms.

//We split the second stage into 4 regexp operations in order to work around
//crippling inefficiencies in IE's and Safari's regexp engines. First we
//replace the JSON backslash pairs with '@' (a non-JSON character). Second, we
//replace all simple value tokens with ']' characters. Third, we delete all
//open brackets that follow a colon or comma or that begin the text. Finally,
//we look to see that the remaining characters are only whitespace or ']' or
//',' or ':' or '{' or '}'. If that is so, then the text is safe for eval.

         if (/^[\],:{}\s]*$/.
test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@').
replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

//In the third stage we use the eval function to compile the text into a
//JavaScript structure. The '{' operator is subject to a syntactic ambiguity
//in JavaScript: it can begin a block or an object literal. We wrap the text
//in parens to eliminate the ambiguity.

             j = eval('(' + text + ')');

//In the optional fourth stage, we recursively walk the new structure, passing
//each name/value pair to a reviver function for possible transformation.

             return typeof reviver === 'function' ?
                 walk({'': j}, '') : j;
         }

//If the text is not JSON parseable, then a SyntaxError is thrown.

         throw new SyntaxError('JSON.parse');
     };
 }
}());

(function(source) {
    for (var property in source) {
        if (source.hasOwnProperty(property)) {
            Function.prototype[property] = source[property];
        }
    }
}(function() {
    var slice = Array.prototype.slice;

    function update(array, args) {
        var arrayLength = array.length, length = args.length;
        while (length) {
            length -= 1;
            array[arrayLength + length] = args[length];
        }
        return array;
    }

    function merge(array, args) {
        array = slice.call(array, 0);
        return update(array, args);
    }
    
    /**
     * Reads the argument names as stated in the function definition and returns
     * the values as an array of strings (or an empty array if the function is
     * defined without parameters).
     * @name Function#argumentNames
     * @function
     * @member Function
     * @exports argumentNames as Function.argumentNames
     * @returns {Array} list of argument names
     * @example
     *      function fn(foo, bar) {
     *        return foo + bar;
     *      }
     *      fn.argumentNames();
     *      //-> ['foo', 'bar']
     */
    function argumentNames() {
        var names = this.toString().match(/^[\s\(]*function[^(]*\(([^)]*)\)/)[1]
        .replace(/\/\/.*?[\r\n]|\/\*(?:.|[\r\n])*?\*\//g, '')
        .replace(/\s+/g, '').split(',');
        return names.length === 1 && !names[0] ? [] : names;
    }
    /**
     * Binds this function to the given `context` by wrapping it in another
     * function and returning the wrapper. Whenever the resulting "bound"
     * function is called, it will call the original ensuring that `this` is set
     * to `context`. Also optionally curries arguments for the function.
     * @name Function#bind
     * @function
     * @member Function
     * @exports bind as Function.bind
     * @param {Object} context The object or execution context to bind to
     * @param {Any} args(?) Optional additioanl arguments to curry for the function.
     * @example
     * A typical use of `Function#bind` is to ensure that a modalCreationCallback (event
     * handler, etc.) that is an object method gets called with the correct
     * object as its context (`this` value):
     * 
     * var a = function () { this.val = 1; };
     * a.prototype.alertVal = function () { alert(this.val); };
     * var b = new a();
     * 
     * document.getElementById('someId').onclick = b.alertVal.bind(this);
     */
    function bind(context) {
        var __method = this, args = slice.call(arguments, 1);
        return function() {
            var a = merge(args, arguments);
            return __method.apply(context, a);
        };
    }

    /**
     * *Curries* (burns in) arguments to a function, returning a new function
     * that when called with call the original passing in the curried arguments
     * (along with any new ones)
     * @name Function#curry
     * @function
     * @member Function
     * @exports curry as Function.curry
     * @param {Any} args(?) The arguments to curry.
     * @see Function#bind
     * @example
     * var a = function () { alert(arguments[0] + ' ' + arguments[1]); };
     * var b = a.curry(1,2);
     * b(); // Alerts "1 2"
     *  `Function#curry` works just like [[Function#bind]] without the initial
     *  context argument. Use `bind` if you need to curry arguments _and_ set
     *  context at the same time.
     *
     *  The name "curry" comes from [mathematics](http://en.wikipedia.org/wiki/Currying).
     */
    function curry () {
        if (!arguments.length) {
            return this;
        }
        var __method = this, args = slice.call(arguments, 0);
        return function() {
            var a = merge(args, arguments);
            return __method.apply(this, a);
        };
    }
    /**
     * Returns a function "wrapped" around the original function. <br />
     * {Function#wrap} distills the essence of aspect-oriented programming into
     * a single method, letting you easily build on existing functions by
     * specifying before and after behavior, transforming the return value, or
     * even preventing the original function from being called.
     * <br /> <br />
     * The wraper function is called with this signature:
     * <br /> <br />
     *     function wrapper(callOriginal[, args...])
     *  <br /> <br />
     * ...where `callOriginal` is a function that can be used to call the
     * original (wrapped) function (or not, as appropriate). (`callOriginal` is
     * not a direct reference to the original function, there's a layer of
     * indirection in-between that sets up the proper context \[`this` value\] for
     * it.)
     * @name Function#wrap
     * @function
     * @member Function
     * @exports wrap as Function.wrap
     * @param {Function} wrapper The function to use as a wrapper.
     * @example
     *      // Wrap String#capitalize so it accepts an additional argument
     *      String.prototype.capitalize = String.prototype.capitalize.wrap(
     *        function(callOriginal, eachWord) {
     *          if (eachWord && this.include(" ")) {
     *            // capitalize each word in the string
     *            return this.split(" ").invoke("capitalize").join(" ");
     *          } else {
     *            // proceed using the original function
     *            return callOriginal();
     *          }
     *        });
     *
     *      "hello world".capitalize();
     *      // -> "Hello world" (only the 'H' is capitalized)
     *      "hello world".capitalize(true);
     *      // -> "Hello World" (both 'H' and 'W' are capitalized)
     */
    function wrap(wrapper) {
        var __method = this;
        return function() {
            var a = update([__method.bind(this)], arguments);
            return wrapper.apply(this, a);
        };
    }
    return {
        argumentNames: argumentNames,
        bind: bind,
        curry: curry,
        wrap: wrap
    };
}()));

Function.prototype.bindAsEventListener = function (context) {
    var self = this;
    return function (event) {
        self.bind(context)(this, event);
    };
};

/**
 * Extend a class with the prototype of another class
 * @version 1.0
 * @param {Funciton} argument[0] Superclass to extend
 * @exports extend as Function.extend
 * @example
 * var myClass = function () {
 *      myOtherClass.call(this, arguments);
 * };
 * myClass.extend(myOtherClass);
 */
Function.prototype.extend = function () {
    var Fun = function () {};
    Fun.prototype = arguments[0].prototype;
    this.prototype = new Fun();
    this.prototype.constructor = this;
};

/**
 * Return the current browser.
 * @version 1.0
 * @author Scott Byrns
 * @function
 * @returns {String} Current browser as one of the following values:
 * IE6, IE7, IE8, CHROME, FF1, FF2, FF3, SAFARI
 */
BB.Util.getBrowser = function () {
    if ($.browser.msie) {
        try {
            if (typeof window.XMLHttpRequest === 'undefined') {
                return "IE6";
            }
        }
        catch (e) {}

        try {
            // var a = new XDomainRequest();
            if ($.browser.version == "8.0") {
                return "IE8";
            }
        }
        catch (e) {}

        if (document.all && !window.opera && window.XMLHttpRequest) {
            return "IE7";
        }
    }
    
    if (window.opera) {
        return "OPERA";
    }
    
    if (window.chrome) {
        return "CHROME";
    }
    
    if ($.browser.mozilla) {
        if (window.globalStorage && window.postMessage) {
            return "FF3";
        }
        if (window.globalStorage) {
            return "FF2";
        }
        if (window.getComputedStyle) {
            return "FF1";
        }
    }
    
    if ($.browser.safari) {
        return "SAFARI";
    }
    
    if (navigator.userAgent.match( /(iPod|iPhone|iPad)/ )) {
        return "MobileSafari";
    }
    
};

BB.Util.currentBrowser = BB.Util.getBrowser();

/**
 * Create a messaging controller that will dispatch events to registered listeners.
 * @version 1.0
 * @author Scott Byrns
 * @constructor
 * @member BB.Controller
 * @this BB.Controller.MessageController
 * @class Create a messaging controller that will dispatch events to registered listeners.
 * @param {BB.Controller.MessageController} parentMessageController Parent message controller to forward messages to if stopPropagation is not passed with sendMessage.
 * @example
 * var Messenger = new BB.Controller.MessageController();
 *
 * Messenger.registerListener('global-mouse-move', Math.floor(Math.random() * new Date()), function (message) {
 *  alert('X:' + message.x + ' Y:' + message.y);
 * });
 *
 * Messenger.sendMessage('global-mouse-move', {
 *  x: 123,
 *  y: 321
 * });
 * 
 */
BB.Controller.MessageController = function (settings) {
    /* Create a queue object */
    this.messageQueue = {};
    
    if (settings) {
        /* Assign a name to the message controller for debugging */
        this.messageControllerName = settings.name || 'Unamed message controller';
        /* Store a reference to the parent message controller if provided or set to false */
        this.parentMessageController = settings.parentMessageController || false;
    }
};
/**
 * Register a listener to accept events.
 * @static
 * @param {String} key The named key that defines the event category to which the event handler is associated.
 * @param {String} UID A unique key that can be used to unregister an event handler.
 * @param {Function} value The method that will be called when an event is propigated through the messaging system with the named key assocaited with this handler
 * @example
 * Messenger.registerListener('global-mouse-move', Math.floor(Math.random() * new Date()), function (message) {
 *  alert('X:' + message.x + ' Y:' + message.y);
 * });
 * 
 */
BB.Controller.MessageController.prototype.registerListener = function (key, UID, value) {
    /* See if we have a key that already exists */
    if (this.messageQueue[key]) {
        /* Push our UID and value onto the key */
        this.messageQueue[key][UID] = value;
    }
    /* If the key does not already exist */
    else {
        /* Create our key on the message queue */
        this.messageQueue[key] = {};
        /* Push our UID and value onto the key we created */
        this.messageQueue[key][UID] = value;
    }
    /* Notify the developer that our UID has been registered under our key */
    BB.Log.debug(this.messageControllerName + ': ' + UID + ' has been registered under ' + key);
};
/**
 * Send an event to all registered handlers of a named key.
 * @param {String} key The named key that defines the event category to which the value will be transmited
 * @param {Sting|Object|Function|Number|Array} value The value that will be transmited to the event handlers attached to the named key provided.
 * @example
 * Messenger.sendMessage('global-mouse-move', {
 *  x: 123,
 *  y: 321
 * });
 * 
 */
BB.Controller.MessageController.prototype.sendMessage = function (key, value, stopPropagation) {
    var target, UID;
    try {
        /* Attempt to assign our key in the message queue to the target variable */
        target = this.messageQueue[key];
        /* Set UID to a blank string in this scope */
        UID = '';   
    }
    /* If our key does not exist we cant send a message to it so we log it as an error and return from this method call */
    catch (e) {
        /* Log our error */
        BB.Log.error(e);
        /* Return from this method call */
        return false;
    }
    /* Loop over all of the registered members of our key */
    for (UID in target) {
        if (target.hasOwnProperty(UID)) {
            try {
                /* Attempt to send our message to the registered member of our key */
                target[UID](value);
            }
            catch (e) {
                /* Log our error if we had an issue sending our message to a registered member of our key */
                BB.Log.error(this.messageControllerName + ': ' + 'There was an error sending a message to a member of ' + key + ' with the UID of ' + UID);
                BB.Log.error(e);
            }
        }
    }
    
    BB.Log.debug(this.messageControllerName + ': ' + value + ' has been sent to all registered listeners attached to ' + key);
    /* If a parent message controller is defined and stopPropagation is not true forward the message to the parent message controller */
    if (this.parentMessageController && !stopPropagation) {
        try {
            BB.Log.debug(this.messageControllerName + ': ' + value + ' has been forwarded to the parent message controller.');
            /* Forward the message to the parent message controller */
            this.parentMessageController.sendMessage(key, value);
        }
        catch (e) {
            BB.Log.error(this.messageControllerName + ': ' + 'The parent message controller was called but returned an error.');
            BB.Log.error(this.messageControllerName + ': ' + e);
        }
    }
};
/**
 * Unregister an event listner from a named key
 * @param {String} key The named key that defines the event category to which our event handler is registered.
 * @param {String} UID The unique id with which our event handler was registered.
 */
BB.Controller.MessageController.prototype.unregisterListener = function (key, UID) {
    try {
        /* Attempt to delete the registered listner from our key */
        delete this.messageQueue[key][UID];
    }
    catch (e) {
        /* If we had an issue deleteing our key let the develoepr know */
        BB.Log.warn(e);
    }
    /* Let the developer know that a listner was unregistered from our key. */
    BB.Log.debug(this.messageControllerName + ': ' + UID + ' has been unregistered from ' + key);
};

/**
 * Global instance of {@link BB.Controller.MessageController}
 */
BB.Controller.Messenger = new BB.Controller.MessageController({
    name: 'Global Message Controller'
});

BB.Core.Log = {
    level: 0,
    isLoggingEnabled: function () {
        if (typeof console !== 'undefined') {
            return true;
        }
        else {
            return false;
        }
    },
    includingScript: false,
    includeFirebug: function () {
        BB.Core.Log.includingScript = true;
        BB.Helpers.includeScript('firebug.js', 'http://mgmt/');
    },
    ensureLoggingIsPossible: function () {
        if (!BB.Core.Log.isLoggingEnabled() && BB.Const.developerMode) {
            BB.Core.Log.notifyDeveloperOfFireBug();
        }
    },
    notifyDeveloperOfFireBug: function () {
        if (typeof $I !== 'function') {
            return;
        }
        var answer = confirm('Would you like to load firebug to allow logging?' +
                'You are seeing this message because BB.Core.Log.level is set to ' + BB.Core.Log.level + ' and' +
                'you have attempted to use the log object without a compatible javascript debugging tool available.');
        if (answer) {
            BB.Core.Log.includeFirebug();
        }
        else {
            BB.Core.Log.level = 0;
            /* alert('To avoid logging errors I have set BB.Core.Log.level to 0.'); */
        }
    },
    message: function (v) {
        BB.Core.Log.ensureLoggingIsPossible();
        if (BB.Core.Log.level > 0) {
            try {
                console.log('|\n|   Log ---- ' + v + '\n|');
            }catch(e){}
        }
    },
    warning: function (v) {
        BB.Core.Log.ensureLoggingIsPossible();
        if (BB.Core.Log.level > 49) {
            try {
                console.warn('∑\n∑∑  Warning ---- ' + v + '\n∑');
            }catch(e){}
        
        }
    },
    error: function (v) {
        BB.Core.Log.ensureLoggingIsPossible();
        if (BB.Core.Log.level > 98) {
            try {
                console.error('/ \n{-  Error ---- ' + v + '\n\\');
            }catch(e){}
            
        }
    },
    debug: (function () {
        try {
            if (typeof console !== 'undefined' && typeof console.debug === 'function') {
                return function (v) {
                    BB.Core.Log.ensureLoggingIsPossible();
                    if (BB.Core.Log.level > 10) {
                        try{
                            console.debug('\\ \n }- Debug ---- ' + v + '\n/');
                        }catch(e){}
                    }
                };
            }
            else {
                return function (v) {
                    BB.Core.Log.ensureLoggingIsPossible();
                    if (BB.Core.Log.level > 10) {
                        try {
                            console.log('\\ \n }- Debug ---- ' + v + '\n/');
                        }catch(e){}
                    }
                };
            }
        }
        catch (e) {
        }
    }())
};

BB.Log = BB.Core.Log;

// If you pass in a a log level using the bblog parameter setup loging right away.
(function() {
    var rx = (new RegExp('bblog=([0-9]{1,2})', 'gi')).exec(window.location.href);
    if (rx) {
        BB.Core.Log.level = parseInt(rx[1], 10);
    }
}())

var TINY = {};

TINY.esc_hide = function (e){
  if (!e) e = window.event;
  if (e.keyCode == "27") { TINY.box.hide(); }
};

function T$(i){return document.getElementById(i)}

TINY.box = function () {
    var p, m, b, fn, ic, iu, iw, ih, ia, f = 0;
    return {
        show: function (c, u, w, h, a, t) {
            BB.Log.debug("Showing Tinybox");
            if (!f) {
                p = document.createElement('div');
                p.id = 'tinybox';
                m = document.createElement('div');
                m.id = 'tinymask';
                b = document.createElement('div');
                b.id = 'tinycontent';
                document.body.appendChild(m);
                document.body.appendChild(p);
                p.appendChild(b);
                m.onclick = TINY.box.hide;
                window.onresize = TINY.box.resize;
                f = 1;
            }
            if (!a && !u) {
                p.style.width = w ? w + 'px' : 'auto';
                p.style.height = h ? h + 'px' : 'auto';
                p.style.backgroundImage = 'none';
                b.innerHTML = c;
            } else {
                b.style.display = 'none';
                p.style.width = p.style.height = '100px';
            }
            this.mask();
            ic = c;
            iu = u;
            iw = w;
            ih = h;
            ia = a;
            this.alpha(m, 1, 80, 3);
            if (t) {
                setTimeout(function () {
                    TINY.box.hide();
                }, 1000 * t);
            }
            // for esc key support
            if (typeof document.onkeypress === 'function') {
                var okpf = document.onkeypress;
                document.onkeypress = function() {
                    if (okpf) { okpf(); }
                    TINY.esc_hide();
                };
            }  else {
                document.onkeypress = TINY.esc_hide;
            }
        },
        fill: function (c, u, w, h, a) {
            BB.Log.debug("TINYBOX: Filling tinybox");
            if (u) {
                BB.Log.debug("TINYBOX: XHR request");
                p.style.backgroundImage = '';
                var x = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                x.onreadystatechange = function () {
                    BB.Log.debug("TINY.box onreadystatechange ( state:" + x.readyState + " status: )");
                    if (x.readyState == 4 && (x.status == 200 || x.status == 304)) {
                        BB.Log.debug("TINYBOX: Content returned, displaying.");
                        TINY.box.psh(x.responseText, w, h, a);
                    } else if (x.readyState == 4 && x.status != 200) {
                        BB.Log.debug("TINYBOX: Error occured getting content");
                    }
                };
                x.open('GET', c, 1);
                x.send(null);
            } else {
                BB.Log.debug("TINYBOX: Showing static or cached content");
                this.psh(c, w, h, a);
            }
        },
        psh: function (c, w, h, a) {
            BB.Log.debug("TINYBOX: Displaying content");
            if (a) {
                if (!w || !h) {
                    var x = p.style.width,
                        y = p.style.height;
                    b.innerHTML = c;
                    p.style.width = w ? w + 'px' : '';
                    p.style.height = h ? h + 'px' : '';
                    b.style.display = '';
                    w = parseInt(b.offsetWidth, 10);
                    h = parseInt(b.offsetHeight, 10);
                    b.style.display = 'none';
                    p.style.width = x;
                    p.style.height = y;
                } else {
                    b.innerHTML = c;
                }
                BB.Log.debug("TINYBOX: Content added, resizing modal");
                this.size(p, w, h);
            } else {
                p.style.backgroundImage = 'none';
            }
        },
        hide: function () {
            TINY.box.alpha(p, -1, 0, 3);
            // for esc key support
            document.onkeypress = '';
        },
        resize: function () {
            TINY.box.pos();
            TINY.box.mask();
            if (TINY.box.onResized !== 'undefined' && typeof TINY.box.onResized === 'function') {
                TINY.box.onResized();
            }
        },
        mask: function () {
            m.style.height = TINY.page.total(1) + 'px';
            m.style.width = '';
            m.style.width = TINY.page.total(0) + 'px';
        },
        pos: function () {
            var t = (TINY.page.height() / 2) - (p.offsetHeight / 2);
            t = t < 10 ? 10 : t;
            p.style.top = (t + TINY.page.top()) + 'px';
            p.style.left = (TINY.page.width() / 2) - (p.offsetWidth / 2) + 'px';
        },
        alpha: function (e, d, a) {
            clearInterval(e.ai);
            if (d == 1) {
                e.style.opacity = 0;
                e.style.filter = 'alpha(opacity=0)';
                e.style.display = 'block';
                this.pos();
            }
            e.ai = setInterval(function () {
                TINY.box.ta(e, a, d);
            }, 20);
        },
        ta: function (e, a, d) {
            var o = Math.round(e.style.opacity * 100);
            if (o == a) {
                clearInterval(e.ai);
                if (d == -1) {
                    e.style.display = 'none';
                    if (e == p) { 
                       TINY.box.alpha(m, -1, 0, 2);
                    } else {
                          b.innerHTML = p.style.backgroundImage = '';
                          if (TINY.box.onClosed !== 'undefined' && typeof TINY.box.onClosed === 'function') {
                              TINY.box.onClosed();
                          }
                    }
                } else {
                    if (e == m) { 
                        this.alpha(p, 1, 100);
                    } 
                    else {
                        TINY.box.fill(ic, iu, iw, ih, ia);
                    }
                }
            } else {
                var n = Math.ceil((o + ((a - o) * 0.5)));
                n = n == 1 ? 0 : n;
                e.style.opacity = n / 100;
                e.style.filter = 'alpha(opacity=' + n + ')';
            }
        },
        size: function (e, w, h) {
            e = typeof e == 'object' ? e : T$(e);
            clearInterval(e.si);
            var ow = e.offsetWidth, oh = e.offsetHeight, wo = ow - parseInt(e.style.width, 10), ho = oh - parseInt(e.style.height, 10);
            var wd = ow - wo > w ? 0 : 1, hd = (oh - ho > h) ? 0 : 1;
            TINY.wn = 0; TINY.hn = 0; TINY.wc = 0; TINY.hc = 0;
            e.si = setInterval(function () {
                TINY.box.ts(e, w, wo, wd, h, ho, hd);
            }, 20);
        },
        ts: function (e, w, wo, wd, h, ho, hd) {
            var ow = e.offsetWidth - wo, oh = e.offsetHeight - ho, n = 0;
            if ((ow == w && oh == h) || TINY.wc > 10 || TINY.hc > 10) {
                clearInterval(e.si); p.style.backgroundImage = 'none'; b.style.display = 'block';
                if (TINY.box.onShown && typeof TINY.box.onShown === 'function') { TINY.box.onShown(); }
            } else {
                
                if (ow != w) {
                    n = ow + ((w - ow) * 0.5);
                    //n = ((w - n) <= 2 || (w - n) >= -2) ? w : n;
                    if (TINY.wn === n) { TINY.wc++; }
                    else { TINY.wn = n }
                    e.style.width = wd ? Math.ceil(n) + 'px' : Math.floor(n) + 'px';
                }
                if (oh != h) {
                    n = oh + ((h - oh) * 0.5);
                    //n = ((h - n) <= 2 || (h - n) >= -2) ? h : n;
                    if (TINY.hn === n) { TINY.wh++; }
                    else { TINY.hn = n }
                    e.style.height = hd ? Math.ceil(n) + 'px' : Math.floor(n) + 'px';
                }
                this.pos();
            }
        },
        onShown: undefined,
        onClosed: undefined
    };
}();

TINY.page = function () {
    return {
        top: function () {
            return document.documentElement.scrollTop || document.body.scrollTop;
        },
        width: function () {
            return self.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        },
        height: function () {
            return self.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        },
        total: function (d) {
            var b = document.body, e = document.documentElement;
            return d ? Math.max(Math.max(b.scrollHeight, e.scrollHeight), Math.max(b.clientHeight, e.clientHeight)) : Math.max(Math.max(b.scrollWidth, e.scrollWidth), Math.max(b.clientWidth, e.clientWidth));
        }
    };
}();

/**
 * Return an instance of a reference to the template rendering function.
 */
BB.TemplateCore = function () {
    /* Create the cache object */
    var cache = {},
    _template;
    /* Define the alias for the tmpl method and define the tmpl method */
    _template = function tmpl(template, data){
        /* Figure out if we're getting a template, or if we need to
         load the template - and be sure to cache the result. */
        var fn = !/\W/.test(template) ? cache[template] = cache[template] || _template(template) :
        /* Generate a reusable function that will serve as a template
         generator (and which will be cached). */
        new Function("obj",
        "try{var p=[],print=function(){p.push.apply(p,arguments);};" +
        /* Introduce the data as local variables using with(){} */
        "with(obj){p.push('" +
        /*  Convert the template into pure JavaScript */
        template.replace(/[\r\t\n]/g, " ")
        .split("<?")
        .join("\t")
        .replace(/((^|\?>)[^\t]*)'/g, "$1\r")
        .replace(/\t=(.*?)\?>/g, "',$1,'")
        .split("\t")
        .join("');")
        .split("?>")
        .join("p.push('")
        .split("\r")
        .join("\\'") + "');}return p.join('');"+'}catch(e){BB.Log.error("Template Render Error!");BB.Log.error(e);}');
        /* Provide some basic currying to the user */
        return data ? fn( data ) : fn;
    };
    return _template;
};

$W = {};
$W.addModule = function (){};

/**
 * Due to the way we load scripts on the fly, we need to run them through this load method
 * to ensure the plugin has been created before we actually try to instantiate it.
 */
(function($) {
    BB.Util.loadPlugin = function(plugin, pluginName, retries) {
        if (!plugin || typeof plugin !== 'function') {
            return false;
        }
        if (!retries || /^\d+$/.test(retries)) { retries = 10; }
    
        var count = 0;
        var loader = window.setInterval(function() {
            try {
                count += 1;
                if (count > retries) {
                    window.clearInterval(loader);
                    return false;
                }
                if (pluginName && $.fn[pluginName]) {
                    plugin();
                    window.clearInterval(loader);
                } else if (!pluginName) {
                    plugin();
                }
            } catch (ex) {
                if (!pluginName && (ex instanceof TypeError) === false && ex.message.toLowerCase().indexOf("has no method") === -1) {
                    window.clearInterval(loader);
                    throw ex;
                } else {
                    throw ex;
                }
            }
        }, 100);
    };
})(jQuery);

//A library function that waits until called element exists, then does something

(function () {
    var _waitUntilExists = {
        pending_functions: [],
        loop_and_call: function () {
            if (!_waitUntilExists.pending_functions.length) {
                return;
            }
            for (var i = 0; i < _waitUntilExists.pending_functions.length; i++) {
                var obj = _waitUntilExists.pending_functions[i];
                var resolution = document.getElementById(obj.id);
                if (obj.id === document) {
                    resolution = document.body;
                }
                if (resolution) {
                    var _f = obj.f;
                    _waitUntilExists.pending_functions.splice(i, 1);
                    if (obj.c === "itself") {
                        obj.c = resolution;
                    }
                    _f.call(obj.c);
                    i--;
                }
            }
        },
        global_interval: setInterval(function () {
            _waitUntilExists.loop_and_call();
        }, 5)
    };
    if (document.addEventListener) {
        document.addEventListener("DOMNodeInserted", _waitUntilExists.loop_and_call, false);
        clearInterval(_waitUntilExists.global_interval);
    }
    window.waitUntilExists = function (id, the_function, context) {
        context = context || window;
        if (typeof id === "function") {
            context = the_function;
            the_function = id;
            id = document;
        }
        _waitUntilExists.pending_functions.push({
            f: the_function,
            id: id,
            c: context
        });
    };
    waitUntilExists.stop = function (id, f) {
        for (var i = 0, l = _waitUntilExists.pending_functions.length; i < l; i++) {
            if (_waitUntilExists.pending_functions[i].id === id && (typeof f === "undefined" || _waitUntilExists.pending_functions[i].f === f)) {
                _waitUntilExists.pending_functions.splice(i, 1);
            }
        }
    };
    waitUntilExists.stopAll = function () {
        _waitUntilExists.pending_functions = [];
    };
})();
(function () {
Math.inRange = function (minVal, maxVal, value) {
    if (typeof minVal === 'number' && typeof maxVal === 'number'){
        value *= 1;
        if(value == minVal || value === maxVal)
        {
            return true;
        } else { 
            if ( value > minVal && value < maxVal ) {
                return true;
            } 
        }
    }
    return false;
};
})();