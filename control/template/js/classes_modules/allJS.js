var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
var isFirefox = typeof InstallTrigger !== 'undefined';
var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
var isIE = /*@cc_on!@*/false || !!document.documentMode;
var isEdge = !isIE && !!window.StyleMedia;
var isChrome = !!window.chrome && !!window.chrome.webstore;
var isBlink = (isChrome || isOpera) && !!window.CSS;
    function getX(e) {
        return getXY(e)[0]
    }

    function getY(e) {
        var t = getXY(e)[1];
        return t
    }

    function getW(e) {
        return e = ge(e), e && e.offsetWidth || 0
    }

    function getH(e) {
        return e = ge(e), e && e.offsetHeight || 0
    }

    function getCw() {
        return Math.max(window.innerWidth || 0, (window.htmlNode || {}).clientWidth || 0)
    }
function cancelEvent(event) {
  event = (event || window.event);
  if (!event) return false;
  while (event.originalEvent) {
    event = event.originalEvent;
  }
  if (event.preventDefault) event.preventDefault();
  if (event.stopPropagation) event.stopPropagation();
  if (event.stopImmediatePropagation) event.stopImmediatePropagation();
  event.cancelBubble = true;
  event.returnValue = false;
  return false;
}
function stopEvent(event) {
  event = (event || window.event);
  if (!event) return false;
  while (event.originalEvent) {
    event = event.originalEvent;
  }
  if (event.stopPropagation) event.stopPropagation();
  event.cancelBubble = true;
  return false;
}
function searfocus(e, t, n) {
        e = ge(e);
        try {
            if (e.focus(), ("undefined" == typeof t || t === !1) && (t = e.value.length), ("undefined" == typeof n || n === !1) && (n = t), e.createTextRange) {
                var i = e.createTextRange();
                i.collapse(!0), i.moveEnd("character", t), i.moveStart("character", n), i.select()
            } else e.setSelectionRange && e.setSelectionRange(t, n)
        } catch (a) {}
}
function childe(elem) {
  return (typeof elem == 'string' || typeof elem == 'number') ? document.getElementsByTagName(elem) : elem;
}
function find(elem,body) {
  return (typeof elem == 'string' || typeof elem == 'number') ? body.children().find(elem) : elem;
}
function scrollTo(element, to, duration) {
  if (duration < 0) return;
  var difference = to - element.scrollTop;
  var perTick = difference / duration * 2;

  setTimeout(function() {
    element.scrollTop = element.scrollTop + perTick;
    scrollTo(element, to, duration - 2);
  }, 10);
}
function scrollToTop(speed) {
  return scrollToY(0, speed);
}
function getscrool() {
 
}
    function parseCyr(e, t) {
        for (var n = e, i = ["yo", "zh", "kh", "ts", "ch", "sch", "shch", "sh", "eh", "yu", "ya", "YO", "ZH", "KH", "TS", "CH", "SCH", "SHCH", "SH", "EH", "YU", "YA", "'"], a = ["ё", "ж", "х", "ц", "ч", "щ", "щ", "ш", "э", "ю", "я", "Ё", "Ж", "Х", "Ц", "Ч", "Щ", "Щ", "Ш", "Э", "Ю", "Я", "ь"], o = 0, r = i.length; r > o; o++) n = t ? n.split(i[o]).join(a[o]) : n.split(a[o]).join(i[o]);
        for (var s = "abvgdezijklmnoprstufhcyABVGDEZIJKLMNOPRSTUFHCYёЁ", l = "абвгдезийклмнопрстуфхцыАБВГДЕЗИЙКЛМНОПРСТУФХЦЫеЕ", o = 0, r = s.length; r > o; o++) n = t ? n.split(s.charAt(o)).join(l.charAt(o)) : n.split(l.charAt(o)).join(s.charAt(o));
        return n == e ? null : n
    }
    function parseLat(e) {
        return parseCyr(e, !0)
    }
    function parseRusKeys(e, t, n) {
        if (!t) return null;
        for (var i = e, a = "qwertyuiop[]asdfghjkl;'zxcvbnm,./`QWERTYUIOP{}ASDFGHJKL:\"ZXCVBNM<>?~", o = "йцукенгшщзхъфывапролджэячсмитьбю.ёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ,Ё", r = 0, s = a.length; s > r; r++) i = n ? i.split(a.charAt(r)).join(o.charAt(r)) : i.split(o.charAt(r)).join(a.charAt(r));
        return i == e ? null : i
    }
    function parseLatKeys(e, t) {
        return parseRusKeys(e, t, !0)
    }
    function scrollLeft() {
        var e = window,
            t = e.htmlNode,
            n = e.bodyNode;
        return t.scrollLeft || n.scrollLeft || window.scrollX || 0
    }
    function scrollTop(e, t) {
        var n = window,
            i = n.htmlNode,
            a = n.bodyNode;
        return "undefined" == typeof e ? i.scrollTop || a.scrollTop || window.scrollY || 0 : void(t ? setTimeout(function() {
            window.scrollTo(0, Math.max(0, e))
        }, t) : window.scrollTo(0, Math.max(0, e)))
    }
function Childme(containerID, childID) {
    var elm = {};
    var elms = document.getElementById(containerID).getElementsByTagName("*");
    for (var i = 0; i < elms.length; i++) {
        if (elms[i].id === childID) {
            elm = elms[i];
            break;
        }
    }
    return elm;
}
function ge(el) {
  return (typeof el == 'string' || typeof el == 'number') ? document.getElementById(el) : el;
}

function geByTag(searchTag, node) {
  node = ge(node) || document;
  return node.getElementById(searchTag);
}
function geByTag1(searchTag, node) {
  node = ge(node) || document;
  return node.querySelector && node.querySelector(searchTag) || geByTag(searchTag, node)[0];
}
function geByClass(searchClass, node, tag) {
  node = ge(node) || document;
  tag = tag || '*';
  var classElements = [];

  if (node.querySelectorAll && tag != '*') {
    return node.querySelectorAll(tag + '.' + searchClass);
  }
  if (node.getElementsByClassName) {
    var nodes = node.getElementsByClassName(searchClass);
    if (tag != '*') {
      tag = tag.toUpperCase();
      for (var i = 0, l = nodes.length; i < l; ++i) {
        if (nodes[i].tagName.toUpperCase() == tag) {
          classElements.push(nodes[i]);
        }
      }
    } else {
      classElements = Array.prototype.slice.call(nodes);
    }
    return classElements;
  }

  var els = geByTag(tag, node);
  var pattern = new RegExp('(^|\\s)' + searchClass + '(\\s|$)');
  for (var i = 0, l = els.length; i < l; ++i) {
    if (pattern.test(els[i].className)) {
      classElements.push(els[i]);
    }
  }
  return classElements;
}
function geByClass1(searchClass, node, tag) {
  node = ge(node) || document;
  tag = tag || '*';
  return node.querySelector && node.querySelector(tag + '.' + searchClass) || geByClass(searchClass, node, tag)[0];
}

function gpeByClass(className, elem, stopElement) {
  elem = ge(elem);
  if (!elem) return null;
  while (stopElement !== elem && (elem = elem.parentNode)) {
    if (hasClass(elem, className)) return elem;
  }
  return null;
}
function attr(el, attrName, value) {
  el = ge(el);
  if (typeof value == 'undefined') {
    return el.getAttribute(attrName);
  } else {
    el.setAttribute(attrName, value);
    return value;
  }
}
function atters(el, attrName, value) {
  el = ge(el);
  if (typeof value == 'undefined') {
    return el.getAttribute(attrName);
  } else {
    el.setAttribute(attrName, value);
     if(el != null){
        return el;
       }
    return value;
  }
}


function showProgress(el, id, cls, doInsertBefore) {
  el = ge(el);
  if (!el) return;

  var prel;

  if (hasClass(el, 'pr')) {
    prel = el;
  } else {
    prel = se(rs(vk.pr_tpl, {id: id || '', cls: cls || ''}));

    if (doInsertBefore) {
      domInsertBefore(prel, el);
    } else {
      el.appendChild(prel);
    }
  }

  setTimeout(function(){
    setStyle(prel, {opacity: 1});
  });

  return prel;
}
function hideProgress(el) {
  if (el) {
    if (hasClass(el, 'pr')) {
      setStyle(el, {opacity: 0});
    } else {
      re(geByClass1('pr', el));
    }
  }
}

function disableEl(el) {
  setStyle(el, 'pointer-events', 'none')
}

function enableEl(el) {
  setStyle(el, 'pointer-events', '')
}
// Extending object by another
function extend() {
  var a = arguments, target = a[0] || {}, i = 1, l = a.length, deep = false, options;

  if (typeof target === 'boolean') {
    deep = target;
    target = a[1] || {};
    i = 2;
  }

  if (typeof target !== 'object' && !isFunction(target)) target = {};

  for (; i < l; ++i) {
    if ((options = a[i]) != null) {
      for (var name in options) {
        var src = target[name], copy = options[name];

        if (target === copy) continue;

        if (deep && copy && typeof copy === 'object' && !copy.nodeType) {
          target[name] = extend(deep, src || (copy.length != null ? [] : {}), copy);
        } else if (copy !== undefined) {
          target[name] = copy;
        }
      }
    }
  }

  return target;
}

function isChecked(el) {
  el = ge(el);
  return hasClass(el, 'on') ? 1 : '';
}
function checkbox(el, v) {
  el = ge(el);
  if (!el || hasClass(el, 'disabled')) return;

  if (v === undefined) {
    v = !isChecked(el);
  }
  toggleClass(el, 'on', v);
  el.setAttribute('aria-checked', v ? 'true' : 'false');
  return false;
}

window.whitespaceRegex = /[\t\r\n\f]/g;
function hasClass(obj, name) {
  obj = ge(obj);
  if (obj && obj.nodeType === 1 && (" " + obj.className + " ").replace(window.whitespaceRegex, " ").indexOf(" " + name + " ") >= 0) {
    return true;
  }

  return false;
}
function domByClass(el, searchClass) {
  if (!el) return el;
  return geByClass1(searchClass, el);
}
function toggleClass(obj, name, v) {
  if (v === undefined) {
    v = !hasClass(obj, name);
  }
  (v ? addClass : removeClass)(obj, name);
  return v;
}
function addClass(obj, name) {
  if ((obj = ge(obj)) && !hasClass(obj, name)) {
    obj.className = (obj.className ? obj.className + ' ' : '') + name;
  }
}
function addClassDelayed(obj, name) { return setTimeout(addClass.pbind(obj, name), 0); }

function removeClass(obj, name) {
  if (obj = ge(obj)) {
    obj.className = trim((obj.className || '').replace((new RegExp('(\\s|^)' + name + '(\\s|$)')), ' '));
  }
}
function trim(text) { return (text || '').replace(/^\s+|\s+$/g, ''); }



function val(input, value, nofire) {
  input = ge(input);
  if (!input) return;
  if (value !== undefined) {
    if (input.setValue) {
      input.setValue(value);
      !nofire && input.phonblur && input.phonblur();
    } else if (input.tagName == 'INPUT' || input.tagName == 'TEXTAREA') {
      input.value = value;
    } else if (input.emojiId !== undefined && window.Emoji) {
      Emoji.val(input, value);
    } else {
      input.innerHTML = value;
    }

    
  }

  return input.getValue ? input.getValue() :
         (((input.tagName == 'INPUT' || input.tagName == 'TEXTAREA') ? input.value : input.innerHTML) || '');
}




  function append(data) {
    // data should be an array of 16-bit numbers
    var words = data.length;
    var dataIndex = 0;
    while (words) {
      var tlen = words > 359 ? 359 : words;
      words -= tlen;
      do {
        _sum2 += _sum1 += data[dataIndex++];
      } while (--tlen);

      _sum1 = ((_sum1 & 0xffff) >>> 0) + (_sum1 >>> 16);
      _sum2 = ((_sum2 & 0xffff) >>> 0) + (_sum2 >>> 16);
    }
  }


function re(el) {
  el = ge(el);
  if (el && el.parentNode) el.parentNode.removeChild(el);
  return el;
}

function se(html) {return domFC(ce('div', {innerHTML: html}));}
function sech(html) {return domChildren(ce('div', {innerHTML: html}));}
function rs(html, repl) {
  each (repl, function(k, v) {
    html = html.replace(new RegExp('%' + k + '%', 'g'), (typeof v === 'undefined' ? '' : v)
      .toString().replace(/\$/g, '&#036;')); // fix in case input contains '$' which will be interpreted as control symbold
  });
  return html;
}


function domReplaceEl(oldEl, newEl) {
  if (isString(newEl)) {
    newEl = se(newEl);
  }
  domPN(oldEl).replaceChild(newEl, oldEl);
  return newEl;
}

function domEL(el, p) {
  p = p ? 'previousSibling' : 'nextSibling';
  while (el && !el.tagName) el = el[p];
  return el;
}
function domNS(el) {
  return domEL((el || {}).nextSibling);
}
function domPS(el) {
  return domEL((el || {}).previousSibling, 1);
}
function domFC(el) {
  return domEL((el || {}).firstChild);
}
function domLC(el) {
  return domEL((el || {}).lastChild, 1);
}
function domPN(el) {
  return (el || {}).parentNode;
}
function domChildren(el) {
  var chidlren = [];
  var nodes = el.childNodes;
  for (var i = 0; i < nodes.length; i++) {
    if (nodes[i].tagName) {
      chidlren.push(nodes[i]);
    }
  }
  return chidlren;
}




function isHover(el) {
  return matchesSelector(el, ':hover');
}



function domClosestOverflowHidden(startEl) {
  startEl = ge(startEl);
  var el = startEl, position, overflow, transform, lastPosition;

  while (el && el.tagName && el !== bodyNode) {
    position = getStyle(el, 'position');
    overflow = getStyle(el, 'overflow');
    transform = getStyle(el, 'transform');

    if (
      el !== startEl &&
      overflow !== 'visible' &&
      (position === 'static' ? !lastPosition || lastPosition === 'relative' : lastPosition !== 'fixed')
    ) break;

    if (transform !== 'none') {
      lastPosition = void 0;
    } else if (position !== 'static' && lastPosition !== 'fixed') {
      lastPosition = position;
    }

    el = domPN(el);
  }

  return el;
}

function hidden(elem) {
  var l = arguments.length;
  if (l > 1) {
    for (var i = 0; i < l; i++) {
      hide(arguments[i]);
    }
    return;
  }

  elem = ge(elem);
  if (!elem || !elem.style) return;

  var display = getStyle(elem, 'display');
  elem.olddisplay = ((display != 'none') ? display : '');
  elem.style.display = 'none';
}

function isVisible(elem) {
  elem = ge(elem);
  if (!elem || !elem.style) return false;
  return getStyle(elem, 'display') != 'none';
}

function clientHeight() {
  return window.innerHeight || docEl.clientHeight || bodyNode.clientHeight;
}
Function.prototype.pbind = function() {
  var args = Array.prototype.slice.call(arguments);
  args.unshift(window);
  return this.bind.apply(this, args);
};
function unsethidden(elem) {
  elem = document.getElementsByTagName("body");
  elem[0].style.overflow = 'auto';
  return elem;
}
function sethidden(el) {
  el = document.getElementsByTagName("body");
  el[0].style.overflow = 'hidden';
  return el;
}
function capitalize(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
}
function rand(mi, ma) { return Math.random() * (ma - mi + 1) + mi; }
function irand(mi, ma) { return Math.floor(rand(mi, ma)); }
function isUndefined(obj) { return typeof obj === 'undefined' };
function isFunction(obj) {return obj && Object.prototype.toString.call(obj) === '[object Function]'; }
function isArray(obj) { return Object.prototype.toString.call(obj) === '[object Array]'; }
function isString(obj) { return typeof obj === 'string'; }
function isObject(obj) { return Object.prototype.toString.call(obj) === '[object Object]'; }
function isEmpty(o) { if(Object.prototype.toString.call(o) !== '[object Object]') {return false;} for(var i in o){ if(o.hasOwnProperty(i)){return false;} } return true; }
function DniaNow() { return +new Date; }
function DniaImage() { return window.Image ? (new Image()) : ce('img'); } // IE8 workaround
function trim(text) { return (text || '').replace(/^\s+|\s+$/g, ''); }
function stripHTML(text) { return text ? text.replace(/<(?:.|\s)*?>/g, '') : ''; }
function escapeRE(s) { return s ? s.replace(/([.*+?^${}()|[\]\/\\])/g, '\\$1') : ''; }




// Simple FX
function animate(el, params, speed, callback) {
  el = ge(el);
  if (!el) return;
  var _cb = isFunction(callback) ? callback : function() {};
  var options = extend({}, typeof speed == 'object' ? speed : {duration: speed, onComplete: _cb});
  var fromArr = {}, toArr = {}, visible = isVisible(el), self = this, p;
  options.orig = {};
  params = clone(params);
  if (params.discrete) {
    options.discrete = 1;
    delete(params.discrete);
  }
  if (browser.iphone)
    options.duration = 0;
  var tween = data(el, 'tween'), i, name, toggleAct = visible ? 'hide' : 'show';
  if (tween && tween.isTweening) {
    options.orig = extend(options.orig, tween.options.orig);
    tween.stop(false);
    if (tween.options.show) toggleAct = 'hide';
    else if (tween.options.hide) toggleAct = 'show';
  }
  for (p in params)  {
    if (!tween && (params[p] == 'show' && visible || params[p] == 'hide' && !visible)) {
      return options.onComplete.call(this, el);
    }
    if ((p == 'height' || p == 'width') && el.style) {
      if (!params.overflow) {
        if (options.orig.overflow == undefined) {
          options.orig.overflow = getStyle(el, 'overflow');
        }
        el.style.overflow = 'hidden';
      }
      if (!hasClass(el, 'inl_bl') && el.tagName != 'TD') {
        el.style.display = 'block';
      }
    }
    if (/show|hide|toggle/.test(params[p])) {
      if (params[p] == 'toggle') {
        params[p] = toggleAct;
      }
      if (params[p] == 'show') {
        var from = 0;
        options.show = true;
        if (options.orig[p] == undefined) {
          options.orig[p] = getStyle(el, p, false) || '';
          setStyle(el, p, 0);
        }

        var o = options.orig[p];
        var old = el.style[p];
        el.style[p] = o;
        params[p] = parseFloat(getStyle(el, p, true));
        el.style[p] = old;

        if (p == 'height' && browser.msie && !params.overflow) {
          el.style.overflow = 'hidden';
        }
      } else {
        if (options.orig[p] == undefined) {
          options.orig[p] = getStyle(el, p, false) || '';
        }
        options.hide = true;
        params[p] = 0;
      }
    }
  }
  if (options.show && !visible) {
    show(el);
  }
  tween = new Fx.Base(el, options);
  each(params, function(name, to) {
    if (/backgroundColor|borderBottomColor|borderLeftColor|borderRightColor|borderTopColor|color|borderColor|outlineColor/.test(name)) {
      var p = (name == 'borderColor') ? 'borderTopColor' : name;
      from = getColor(el, p);
      to = getRGB(to);
      if (from === undefined) return;
    } else {
      var parts = to.toString().match(/^([+-]=)?([\d+-.]+)(.*)$/),
        start = tween.cur(name, true) || 0;
      if (parts) {
        to = parseFloat(parts[2]);
        if (parts[1]) {
          to = ((parts[1] == '-=' ? -1 : 1) * to) + to;
        }
      }

      from = tween.cur(name, true);
      if (from == 0 && (name == 'width' || name == 'height'))
        from = 1;

      if (name == 'opacity' && to > 0 && !visible) {
        setStyle(el, 'opacity', 0);
        from = 0;
        show(el);
      }
    }
    if (from != to || (isArray(from) && from.join(',') == to.join(','))) {
      fromArr[name] = from;
      toArr[name] = to;
    }
  });
  tween.start(fromArr, toArr);
  data(el, 'tween', tween);

  return tween;
}
function domStarted() {
  window.headNode = geByTag1('head');
  extend(window, {
    icoNode:  geByTag1('link', headNode),
    bodyNode: geByTag1('body'),
    htmlNode: geByTag1('html'),
    _fixedNav: false,
    _tbLink: {}
  });
}
getValue = function() {
    return o.editable ? el.innerHTML : el.value;
  }
function intval(value) {
  if (value === true) return 1;
  return parseInt(value) || 0;
}
function floatval(value) {
  if (value === true) return 1;
  return parseFloat(value) || 0;
}
function positive(value) {
  value = intval(value);
  return value < 0 ? 0 : value;
}
function isNumeric(value) {
  return !isNaN(value);
}

function winToUtf(text) {
  return text.replace(/&#(\d\d+);/g, function(s, c) {
    c = intval(c);
    return (c >= 32) ? String.fromCharCode(c) : s;
  }).replace(/&quot;/gi, '"').replace(/&lt;/gi, '<').replace(/&gt;/gi, '>').replace(/&amp;/gi, '&');
}
function replaceEntities(str) {
  return se('<textarea>' + ((str || '').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')) + '</textarea>').value;
}
function clean(str) {
  return str ? str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;') : '';
}
function unclean(str) {
  return replaceEntities(str.replace(/\t/g, "\n"));
}

//
//  Arrays, objects
//

function each(object, callback) {
  if (!isObject(object) && typeof object.length !== 'undefined') {
    for (var i = 0, length = object.length; i < length; i++) {
      var value = object[i];
      if (callback.call(value, i, value) === false) break;
    }
  } else {
    for (var name in object) {
      if (!Object.prototype.hasOwnProperty.call(object, name)) continue;
      if (callback.call(object[name], name, object[name]) === false)
        break;
    }
  }

  return object;
}

function indexOf(arr, value, from) {
  for (var i = from || 0, l = (arr || []).length; i < l; i++) {
    if (arr[i] == value) return i;
  }
  return -1;
}
function inArray(value, arr) {
  return indexOf(arr, value) != -1;
}
function clone(obj, req) {
  var newObj = !isObject(obj) && typeof obj.length !== 'undefined' ? [] : {};
  for (var i in obj) {
    if (/webkit/i.test(_ua) && (i == 'layerX' || i == 'layerY' || i == 'webkitMovementX' || i == 'webkitMovementY')) continue;
    if (req && typeof(obj[i]) === 'object' && i !== 'prototype' && obj[i] !== null) {
      newObj[i] = clone(obj[i]);
    } else {
      newObj[i] = obj[i];
    }

  }
  return newObj;
}

function arrayKeyDiff(a) {   // Computes the difference of arrays by keys and values
  var arr_dif = {}, i = 1, argc = arguments.length, argv = arguments, key, found;
  for (key in a){
    found = false;
    for (i = 1; i < argc; i++){
      if (argv[i][key] && (argv[i][key] == a[key])){
        found = true;
      }
    }
    if (!found) {
      arr_dif[key] = a[key];
    }
  }
  return arr_dif;
}

// Extending object by another
function extend() {
  var a = arguments, target = a[0] || {}, i = 1, l = a.length, deep = false, options;

  if (typeof target === 'boolean') {
    deep = target;
    target = a[1] || {};
    i = 2;
  }

  if (typeof target !== 'object' && !isFunction(target)) target = {};

  for (; i < l; ++i) {
    if ((options = a[i]) != null) {
      for (var name in options) {
        var src = target[name], copy = options[name];

        if (target === copy) continue;

        if (deep && copy && typeof copy === 'object' && !copy.nodeType) {
          target[name] = extend(deep, src || (copy.length != null ? [] : {}), copy);
        } else if (copy !== undefined) {
          target[name] = copy;
        }
      }
    }
  }

  return target;
}


    function append(e, t) {
        return e = ge(e), t = ge(t), e && t && t.appendChild(e) || !1
    }

    function before(e, t) {
        return t = ge(t), t && t.parentNode && t.parentNode.insertBefore(ge(e), t) || !1
    }

    function after(e, t) {
        return t = ge(t), t && t.parentNode && t.parentNode.insertBefore(ge(e), t.nextSibling) || !1
    }

    function replace(e, t) {
        before(e, t) && remove(t)
    }

    function remove(e) {
        return e = ge(e), e && e.parentNode ? e.parentNode.removeChild(e) : !1
    }

    function clone(e) {
        return e = ge(e), e ? e.cloneNode(!0) : !1
    }

    function reflow(e) {
        e = ge(e);
        try {
            {
                e.offsetWidth + e.offsetHeight
            }
        } catch (t) {}
    }

    function tag(e) {
        return e = ge(e), (e && e.tagName || "").toLowerCase()
    }

    function outer(e) {
        return e = ge(e), e ? val(ce("div").appendChild(clone(e)).parentNode) : ""
    }

    function show(e) {
        var t = ge(e);
        t && (t.style.display = t.oldstyle || (hasClass("_ib", t) ? "inline-block" : hasClass("_i", t) || "span" == tag(t) ? "inline" : "block"))
    }

    function hide(e) {
        var t = ge(e);
        t && ("none" != t.style.display && (t.oldstyle = t.style.display), t.style.display = "none")
    }
    function formatTime(e) {
        var t, n, i, a = 0 > e;
        return e = Math.round(a ? -e : e), n = e % 60, t = 10 > n ? "0" + n : n, e = Math.floor(e / 60), i = e % 60, t = i + ":" + t, e = Math.floor(e / 60), e > 0 && (10 > i && (t = "0" + t), t = e + ":" + t), a && (t = "-" + t), t
    }
      function empty( el ){
        var t = ge(el);
       t && ("none" != t.innerHTML && (t.innerHTML = t.innerHTML), t.innerHTML = "")
      }
      function Vaempty( el ){
        var t = ge(el);
       t && ("none" != t.value && (t.value = t.value), t.value = "")
      }
    function isVisible(e) {
        var t = ge(e);
        return t && t.style ? "none" != t.style.display : !1
    }

    function toggle(e, t) {
        "undefined" == typeof t && (t = !isVisible(e)), t && isVisible(e) || (t || isVisible(e)) && (t ? show : hide)(e)
    }

    function ce(e, t, n) {
        var i = document.createElement(e);
        return t && extend(i, t), n && setStyle(i, n), i
    }
    function parseJSON(obj) {
        try {
            return JSON.parse(obj)
        } catch (e) {
            return eval("(" + obj + ")")
        }
    }


function setStyle(elem, name, value){
  elem = ge(elem);
  if (!elem) return;
  if (typeof name == 'object') return each(name, function(k, v) { setStyle(elem,k,v); });
  if (name == 'opacity') {
    
      if ((value + '').length) {
        if (value !== 1) {
          elem.style.filter = 'alpha(opacity=' + value * 100 + ')';
        } else {
          elem.style.filter = '';
        }
      } else {
        elem.style.cssText = elem.style.cssText.replace(/filter\s*:[^;]*/gi, '');
      }
      elem.style.zoom = 1;
  
    elem.style.opacity = value;
  } else {
    try{
      var isN = typeof(value) == 'number';
      if (isN && (/height|width/i).test(name)) value = Math.abs(value);
      elem.style[name] = isN && !(/z-?index|font-?weight|opacity|zoom|line-?height/i).test(name) ? value + 'px' : value;
    } catch(e){debugLog('setStyle error: ', [name, value], e);}
  }
}
    function getStyle(e, t, n) {
        if (e = ge(e), !e) return !1;
        if (isArray(t)) {
            var i = {};
            return each(t, function(t, n) {
                i[n] = getStyle(e, n)
            }), i
        }
        if (isUndefined(n) && (n = !0), /transform(-origin)?|transition(-duration)?/i.test(t) && (t = getCssPropertyName(e, t), !t)) return !1;
        var a = window,
            o = a.browser;
        if (!n && "opacity" == t && o.msie) {
            var r = e.style.filter;
            return r ? r.indexOf("opacity=") >= 0 ? parseFloat(r.match(/opacity=([^)]*)/)[1]) / 100 + "" : "1" : ""
        }
        if (!n && e.style && (e.style[t] || "height" == t)) return e.style[t];
        var s, l = document.defaultView || window;
        if (l.getComputedStyle) {
            t = t.replace(/([A-Z])/g, "-$1").toLowerCase();
            var c = l.getComputedStyle(e, null);
            c && (s = c.getPropertyValue(t))
        } else if (e.currentStyle) {
            if ("opacity" == t && o.msie) {
                var r = e.currentStyle.filter;
                return r && r.indexOf("opacity=") >= 0 ? parseFloat(r.match(/opacity=([^)]*)/)[1]) / 100 + "" : "1"
            }
            var u = t.replace(/\-(\w)/g, function(e, t) {
                return t.toUpperCase()
            });
            s = e.currentStyle[t] || e.currentStyle[u], "auto" == s && (s = 0), s = (s + "").split(" "), each(s, function(t, n) {
                if (!/^\d+(px)?$/i.test(n) && /^\d/.test(n)) {
                    var i = e.style,
                        a = i.left,
                        o = e.runtimeStyle.left;
                    e.runtimeStyle.left = e.currentStyle.left, i.left = n || 0, s[t] = i.pixelLeft + "px", i.left = a, e.runtimeStyle.left = o
                }
            }), s = s.join(" ")
        }
        if (n && ("width" == t || "height" == t)) {
            var d = "width" == t ? getW(e) : getH(e);
            s = (intval(s) ? Math.max(floatval(s), d) : d) + "px"
        }
        return s
    }

( function() {
  var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
      is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
      is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

  if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
    window.addEventListener( 'hashchange', function() {
      var id = location.hash.substring( 1 ),
        element;

      if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
        return;
      }

      element = document.getElementById( id );

      if ( element ) {
        if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
          element.tabIndex = -1;
        }

        element.focus();
      }
    }, false );
  }
})();