var wc_demo = {

  // object reference to the form holding the demo fields
  theForm : null,

  // labels collection
  theLabels : null,

  // object references related to textarea 
  theCounter : null,
  theTextArea : null,
  
  // object reference to recipient text box
  theRecipient : null,

  // object reference to sender text box
  theSender : null,
  
  // object reference to demo button
  demoBtn : null,
  
  // properties/object references for border images
  borderImgs : null,
  allBorderImgs : null,
  chosenBorderImg : null,
  borderImgIsSelected : false,
  
  // properties/object references for font settings
  theFonts : null,
  allFonts : null,
  fontIsSelected : false,
  
  init : function() {

     // locating element nodes and building collections
     wc_demo.theForm = wc_global.getObj('demoForm');
     wc_demo.theLabels = document.getElementsByTagName('label');
     wc_demo.theCounter = wc_global.getObj('counter');
     wc_demo.theTextArea = wc_global.getObj('msg');
     wc_demo.theRecipient = wc_global.getObj('recip');
     wc_demo.theSender = wc_global.getObj('sender');
     wc_demo.demoBtn = wc_global.getObj('demo');
     wc_demo.borderImgs = document.getElementsByTagName('img');
     wc_demo.allBorderImgs = wc_demo.borderImgs.length;
     wc_demo.theFonts = document.getElementsByName('txtstyle');
     wc_demo.allFonts = wc_demo.theFonts.length;

     // launching configuration functions
     wc_demo.configCounter();
     wc_demo.configImgs();
     wc_demo.configDemoBtn();
  },

  // assign event handler to textarea
  configCounter : function() {
     wc_global.addEvent(this.theTextArea, 'keyup', wc_demo.updateCounter);
  },

  // update character count based on textarea data 
  updateCounter : function() {
     var totalCharacters = 300 - this.value.length;
     if (totalCharacters < 0) {
        totalCharacters = 'over';
        wc_demo.theCounter.className = 'overLimit';
        wc_demo.demoBtn.disabled = true;
     }
     else {
        wc_demo.theCounter.className = '';
        wc_demo.demoBtn.disabled = false;
     }
     wc_demo.theCounter.value = totalCharacters;
  },
  
  // assign event handlers to links surrounding border images
  configImgs : function() {
     for (var i=0; i<this.allBorderImgs; i++) {
         wc_global.addEvent(this.borderImgs[i].parentNode, 'click', this.addImgBorder);
     }
  },
  
  // toggle off all image outset borders and then toggle on the border for the clicked image 
  addImgBorder : function(e) {
     for (var i=0; i<wc_demo.allBorderImgs; i++) {
         wc_demo.borderImgs[i].className = '';
     }  
     this.firstChild.className = 'imgBorder';
     wc_demo.chosenBorderImg = this.firstChild.getAttribute('alt');
     wc_demo.borderImgIsSelected = true;
     wc_demo.stopDefault(e);
  },
  
  configDemoBtn : function() {
     wc_global.addEvent(this.demoBtn, 'click', this.validateSelections);
  },
  
  // checking for proper data existence
  validateSelections : function() {
     
     // font choice validation
     if (!wc_demo.fontIsSelected) { wc_demo.theLabels[0].className = 'error'; }
     for (var i=0; i<wc_demo.allFonts; i++) {
         if (wc_demo.theFonts[i].checked == true) {
            wc_demo.fontIsSelected = true;
            var chosenFont = wc_demo.theFonts[i].value;
            wc_demo.theLabels[0].className = '';
         }
     }
     
     // border image validation
     if (!wc_demo.borderImgIsSelected) { wc_demo.theLabels[1].className = 'error'; }
     else { wc_demo.theLabels[1].className = ''; }

     // recipient validation     
     if (wc_demo.theRecipient.value != '') { 
         var validRecipient = true; 
         wc_demo.theLabels[2].className = '';
     }
     else { wc_demo.theLabels[2].className = 'error'; }     
     
     // message validation
     if (wc_demo.theTextArea.value != '') { 
        var validTextArea = true;
        wc_demo.theLabels[3].className = '';
     }
     else { wc_demo.theLabels[3].className = 'error'; }
     
     // sender validation     
     if (wc_demo.theSender.value != '') { 
         var validSender = true; 
         wc_demo.theLabels[4].className = '';
     }
     else { wc_demo.theLabels[4].className = 'error'; }         
     
     // final check
     if (wc_demo.fontIsSelected && wc_demo.borderImgIsSelected && validRecipient && validTextArea && validSender) {
        if (document.getElementById('errorMessage')) {
           wc_demo.theForm.removeChild(document.getElementById('errorMessage'));
        }
        wc_demo.createCookie('font', chosenFont);
        wc_demo.createCookie('border', wc_demo.chosenBorderImg);
        wc_demo.createCookie('recipient', wc_demo.theRecipient.value);
        wc_demo.createCookie('message', wc_demo.theTextArea.value);
        wc_demo.createCookie('sender', wc_demo.theSender.value);
        window.open("preview/demo-card.html","_blank","top=25,left=25,width=400,height=290,scrollbars=0,resizable=0,location=0,toolbar=0,status=0,menubar=0,directories=0");
     }
     else {
        if (!document.getElementById('errorMessage')) {
          var errorMsg = document.createElement('p');
          errorMsg.id = 'errorMessage';
          errorMsg.appendChild(document.createTextNode('Missing information is boldface and red.'));
          wc_demo.theForm.insertBefore(errorMsg,wc_demo.theForm.firstChild)
        }
     }  
  },
  
  // utility function for setting cookies
  createCookie : function(name,value) {
    var data = name + "=" + escape(value);
    document.cookie = data;
  },  
  
  // utility function for stopping structural markup default behavior; disables link hrefs in this case
  stopDefault : function(e) {
     if (!e) {e = window.event;}
     if (!e.preventDefault) {
         e.preventDefault = function() { this.returnValue = false; }
     }
     e.preventDefault();
     return false;
  }

}

// object detection and initializing functionality
if (wc_global.W3CDOM) {
   wc_global.addEvent(window, 'load', wc_demo.init);
}