var demo_page = {

  loadValues : function() {
    var theFont = demo_page.findCookie('font');
    var theBorder = demo_page.findCookie('border');
    switch (theBorder) {
      case 'Flower 1 Border Image': theBorder = 'flower1'; break;
      case 'Flower 2 Border Image': theBorder = 'flower2'; break;
      case 'Birthday Cake 1 Border Image': theBorder = 'cake1'; break;
      case 'Birthday Cake 2 Border Image': theBorder = 'cake2'; break;
      case 'Happy Birthday Text 1 Border Image': theBorder = 'text1'; break;
      case 'Happy Birthday Text 2 Border Image': theBorder = 'text2';
    }
    var theRecipient = demo_page.findCookie('recipient');
    var theMessage = demo_page.findCookie('message');
    var theSender = demo_page.findCookie('sender');
    var theBody = document.getElementsByTagName('body')[0];
    theBody.className = theFont + ' ' + theBorder;
    var toPara = document.createElement('p');
    var messagePara = document.createElement('p');
    var fromPara = document.createElement('p');
    toPara.appendChild(document.createTextNode(theRecipient));
    messagePara.appendChild(document.createTextNode(theMessage));
    fromPara.appendChild(document.createTextNode(theSender));
    theBody.appendChild(toPara);
    theBody.appendChild(messagePara);
    theBody.appendChild(fromPara);
  },

  // utility functions for retrieving cookie values
  findCookie : function(name) {
    var query = name + "=";
    var queryLength = query.length;
    var cookieLength = document.cookie.length;
    var i=0;
    while (i < cookieLength) {
      var startValue = i + queryLength;
      if (document.cookie.substring(i,startValue) == query) {
         return this.findValue(startValue);
      }
      i = document.cookie.indexOf(" ", i) + 1;
      if (i == 0) {break;}
    }
    return null;
  },

  findValue : function(startValue) {
    var endValue = document.cookie.indexOf(";", startValue);
    if (endValue == -1) {
       endValue = document.cookie.length;
    }
    return unescape(document.cookie.substring(startValue,endValue));
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

// initializing functionality
demo_page.addEvent(window, 'load', demo_page.loadValues);