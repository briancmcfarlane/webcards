var build_page = {

  loadValues : function() {
    var theFont = build_page.findCookie('font');
    var theBorder = build_page.findCookie('border');
    switch (theBorder) {
      case "Dentist Appt. A Border Image" : theBorder = 'dentistA'; break;
      case "Dentist Appt. B Border Image" : theBorder = 'dentistB'; break;
      case "Open House A Border Image" : theBorder = 'houseA'; break;
      case "Open House B Border Image" : theBorder = 'houseB'; break;
      case "Vet Appt. A Border Image" : theBorder = 'vetA'; break;
      case "Vet Appt. B Border Image" : theBorder = 'vetB'; break;
      case "Valentine's Day A Border Image" : theBorder = 'vdA'; break;
      case "Valentine's Day B Border Image" : theBorder = 'vdB'; break;
    }
    var theRecipient = build_page.findCookie('recipient');
    var theMessage = build_page.findCookie('message');
    var theSender = build_page.findCookie('sender');
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
build_page.addEvent(window, 'load', build_page.loadValues);