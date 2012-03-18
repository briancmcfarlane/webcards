var wc_build = {

  // object reference to the form holding the build fields
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
  
  // object reference to build button
  buildBtn : null,
  buildBtnClicked : false,

  // object reference to save button
  signupBtn : null,
  signupBtnClicked : false,
  
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
     wc_build.theForm = wc_global.getObj('buildForm');
     wc_build.theLabels = document.getElementsByTagName('label');
     wc_build.theCounter = wc_global.getObj('counter');
     wc_build.theTextArea = wc_global.getObj('msg');
     wc_build.theRecipient = wc_global.getObj('recip');
     wc_build.theSender = wc_global.getObj('sender');
     wc_build.buildBtn = wc_global.getObj('build');
     wc_build.signupBtn = wc_global.getObj('signup');
     wc_build.borderImgs = document.getElementsByTagName('img');
     wc_build.allBorderImgs = wc_build.borderImgs.length;
     wc_build.theFonts = document.getElementsByName('txtstyle');
     wc_build.allFonts = wc_build.theFonts.length;

     // launching configuration functions
     wc_build.configCounter();
     wc_build.configImgs();
     wc_build.configDemoBtn();
	 wc_build.configSignupBtn();
  },

  // assign event handler to textarea
  configCounter : function() {
     wc_global.addEvent(this.theTextArea, 'keyup', wc_build.updateCounter);
  },

  // update character count based on textarea data 
  updateCounter : function() {
     var totalCharacters = 300 - this.value.length;
     if (totalCharacters < 0) {
        totalCharacters = 'over';
        wc_build.theCounter.className = 'overLimit';
        wc_build.buildBtn.disabled = true;
		wc_build.signupBtn.disabled = true;
     }
     else {
        wc_build.theCounter.className = '';
        wc_build.buildBtn.disabled = false;
		wc_build.signupBtn.disabled = false;
     }
     wc_build.theCounter.value = totalCharacters;
  },
  
  // assign event handlers to links surrounding border images
  configImgs : function() {
     for (var i=0; i<this.allBorderImgs; i++) {
         wc_global.addEvent(this.borderImgs[i].parentNode, 'click', this.addImgBorder);
     }
  },
  
  // toggle off all image outset borders and then toggle on the border for the clicked image 
  addImgBorder : function(e) {
     for (var i=0; i<wc_build.allBorderImgs; i++) {
         wc_build.borderImgs[i].className = '';
     }  
     this.firstChild.className = 'imgBorder';
     wc_build.chosenBorderImg = this.firstChild.getAttribute('alt');
     wc_build.borderImgIsSelected = true;
     wc_build.stopDefault(e);
  },
  
  configDemoBtn : function() {
	 wc_global.addEvent(this.signupBtn, 'click', function (){wc_build.signupBtnClicked = false;});
 	 wc_global.addEvent(this.buildBtn, 'click', function (){wc_build.buildBtnClicked = true;});
	 wc_global.addEvent(this.buildBtn, 'click', this.validateSelections);
  },

  configSignupBtn : function() {
	 wc_global.addEvent(this.buildBtn, 'click', function (){wc_build.buildBtnClicked = false;});
 	 wc_global.addEvent(this.signupBtn, 'click', function (){wc_build.signupBtnClicked = true;});	 
     wc_global.addEvent(this.signupBtn, 'click', this.validateSelections);
  },
  
  // checking for proper data existence
  validateSelections : function(btn) {
     
     // font choice validation
     if (!wc_build.fontIsSelected) { wc_build.theLabels[0].className = 'error'; }
     for (var i=0; i<wc_build.allFonts; i++) {
         if (wc_build.theFonts[i].checked == true) {
            wc_build.fontIsSelected = true;
            var chosenFont = wc_build.theFonts[i].value;
            wc_build.theLabels[0].className = '';
         }
     }
     
     // border image validation
     if (!wc_build.borderImgIsSelected) { wc_build.theLabels[1].className = 'error'; }
     else { wc_build.theLabels[1].className = ''; }

     // recipient validation     
     if (wc_build.theRecipient.value != '') { 
         var validRecipient = true; 
         wc_build.theLabels[2].className = '';
     }
     else { wc_build.theLabels[2].className = 'error'; }     
     
     // message validation
     if (wc_build.theTextArea.value != '') { 
        var validTextArea = true;
        wc_build.theLabels[3].className = '';
     }
     else { wc_build.theLabels[3].className = 'error'; }
     
     // sender validation     
     if (wc_build.theSender.value != '') { 
         var validSender = true; 
         wc_build.theLabels[4].className = '';
     }
     else { wc_build.theLabels[4].className = 'error'; }         
     
     // final check
     if (wc_build.fontIsSelected && wc_build.borderImgIsSelected && validRecipient && validTextArea && validSender) {
        if (document.getElementById('errorMessage')) {
           wc_build.theForm.removeChild(document.getElementById('errorMessage'));
        }
        wc_build.createCookie('font', chosenFont);
        wc_build.createCookie('border', wc_build.chosenBorderImg);
        wc_build.createCookie('recipient', wc_build.theRecipient.value);
        wc_build.createCookie('message', wc_build.theTextArea.value);
        wc_build.createCookie('sender', wc_build.theSender.value);
	
		if(wc_build.buildBtnClicked) {
			window.open("preview/build-card.html","_blank","top=25,left=25,width=400,height=290,scrollbars=0,resizable=0,location=0,toolbar=0,status=0,menubar=0,directories=0");
		}
		else {
			wc_build.createCookie('signup', wc_build.signupBtnClicked);
			window.location.reload();
		}
		
     }
     else {
        if (!document.getElementById('errorMessage')) {
          var errorMsg = document.createElement('p');
          errorMsg.id = 'errorMessage';
          errorMsg.appendChild(document.createTextNode('Missing information is boldface and red.'));
          wc_build.theForm.insertBefore(errorMsg,wc_build.theForm.firstChild)
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
   wc_global.addEvent(window, 'load', wc_build.init);
}