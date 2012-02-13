//This should be the last thing inside your object in your js file. This is a subobject, and can be referenced by globalobject.util.functionname.
//This must be set up in the init section, call util.configEvents(); and then it will work.
//We may or may not need the cookie functions, if not, they are easily removed
//If you have any questions feel free to ask.
 util : {

    configEvents : function() {
    
      if (document.addEventListener) {
    
          this.addEvent = function(el, type, func, capture) {
            el.addEventListener(type, func, capture);  
          };
 
          this.stopBubble = function(evt) { evt.stopPropagation(); };
  
          this.stopDefault = function(evt) { evt.preventDefault(); };

          this.findTarget = function(evt, targetNode, container) {
            var currentNode = evt.target;
            while (currentNode && currentNode !== container) {
              if (currentNode.nodeName.toLowerCase() === targetNode) {
                  return currentNode; break;
              }
              else { currentNode = currentNode.parentNode; }
            };
            return false;
          };
      }
    
      else if (document.attachEvent) {
    
          this.addEvent = function(el, type, func) {
            el["e" + type + func] = func;
            el[type + func] = function() { el["e" + type + func] (window.event); };
            el.attachEvent("on" + type, el[type + func]);
          };

          this.stopBubble = function(evt) { evt.cancelBubble = true; };

          this.stopDefault = function(evt) { evt.returnValue = false; };

          this.findTarget = function(evt, targetNode, container) {
            var currentNode = evt.srcElement;
            while (currentNode && currentNode !== container) {
              if (currentNode.nodeName.toLowerCase() === targetNode) {
                  return currentNode; break;
              }
              else { currentNode = currentNode.parentNode; }
            };
            return false;
          };
    
      }
    
    },
    
    createCookie : function(name,value,expiration,path,domain,secure) {
      var data = name + "=" + escape(value);
      if (expiration) { 
         var expiresAt = new Date();
         expiresAt.setTime(expiration);
         data += "; expires=" + expiresAt.toGMTString();
      }
      if (path) { data += "; path=" + path; }
      if (domain) { data += "; domain=" + domain; }
      if (secure) { data += "; secure"; }
      document.cookie = data;
    },
  
    findCookie : function(name) {  
      var query = name + "=";
      var queryLength = query.length;
      var cookieLength = document.cookie.length;
      var i=0;
      while (i<cookieLength) {
        var position = i + queryLength;
        if (document.cookie.substring(i,position) === query) {
           return this.findCookieValue(position);
        }
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) { break; }  
      }
      return null;  
    },

    findCookieValue : function(position) {
      var endsAt = document.cookie.indexOf(";", position);
      if (endsAt == -1) { endsAt = document.cookie.length; }
      return unescape(document.cookie.substring(position,endsAt));
    },
 
  }