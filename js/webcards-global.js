var wc_global = {

  W3CDOM : document.getElementById && document.getElementsByTagName && document.getElementsByName && document.createElement && document.createTextNode,

  // utility function to reduce object lookup code
  getObj : function(idvalue) {
     return document.getElementById(idvalue);
  },

  // utility function for adding events
  addEvent : function(obj, type, func) {
    if (obj.addEventListener) {obj.addEventListener(type, func, false);}
    else if (obj.attachEvent) {
      obj["e" + type + func] = func;
      obj[type + func] = function() {obj["e" + type + func] (window.event);}
      obj.attachEvent("on" + type, obj[type + func]);
    }
    else {obj["on" + type] = func;}
  }

}

// object detection and initializing functionality
if (wc_global.W3CDOM) {

}