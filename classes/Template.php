<?php

    class Template{
      
        
        public $globalNavArray = array(
            
            'home'=>array('Home','.','140'),
            'features'=>array('Features','features','150'),
            'pricing'=>array('Pricing','pricing','160'),
            'build'=>array('Build a WebCard','build','170'),
            'support'=>array('Support','support','190')
        );
           
        
        public function loadData(){
            
            if (!empty($_GET['p'])){
                
                $_GET['p'] = $this->cleanData($_GET['p']);
                $this->filePath = explode('-',$_GET['p']);
            }
            
            if (empty($_GET['p']) || $_GET['p'] === 'home'){
                
                $this->homepage = true;
                $this->validPath = true;
                $this->filePath[0] = 'home';
                include 'indexcontent.php';
            }
            
            else {
                $this->homepage = false;
                $filePathLength = count($this->filePath);
                if ($filePathLength === 1){$path = $this->filePath[0] . '.php';}
                
                else {$path = $this->filePath[0] . '/' . $this->filePath[1] . '.php';}
                
                if (!file_exists($path)){
                    $this->validPath = false;
                    include 'filenotfound.php';
                }
                
                else {
                    $this->validPath = true;
                    include $path;
                     
                }
            }
        }
        
        
        public function cleanData($data){
            $illegalCharacters = array('http','ftp','.','/','\\');
            
            $data = str_replace($illegalCharacters,'',$data);
            
            return $data;
        }
        
        
        public function printTitle(){
            echo $this->title;
        }
        
        
        public function linkJS(){
            echo "<script type=\"text/javascript\"src=\"js/webcards-global.js\"/></script>";
            if ($this->filePath[0] == 'build'){
                echo "<script type=\"text/javascript\" src=\"js/webcards-build.js\"></script>";
            }
        }
		
		        
        public function generateLoginBox(){
            
            echo "<div id=\"accountLinks\">";
            if (isset($_SESSION['name'])){
              if ((string)$_SESSION['isAdmin'] === 'True'){
               		echo "Welcome Admin {$_SESSION['name']}<br /><a href=\"/webcards/admin/admin\">Admin Page</a> or <a href=\"/webcards/account/logout\">Log Out</a>";
              }
              else {
               	  echo "Welcome {$_SESSION['name']}<br /><a href=\"/webcards/account/myaccount\">My Account</a> or <a href=\"/webcards/account/logout\">Log Out</a>";
              }
            }
            
            else {
                  echo "<a href=\"/webcards/account/login\">Log-in</a> or <a href=\"/webcards/signup/registration\">Sign up</a>";
            }
            
            echo "</div>";
            
        }
        
        public function generateGlobalNav(){
            
            echo "<ul id=\"tnav\">";
            foreach ($this->globalNavArray as $navItem=>$navData){
                
                if ($this->filePath[0] === $navItem){
                    echo "<li class=\"current\"><a>$navData[0]</a></li>";
                }
                
                else {
                echo "<li><a href=\"$navData[1]\" tabindex=\"$navData[2]\">$navData[0]</a></li>";
                
                }
                
            }
            echo "</ul>";
        }
        
        public function generateContent(){
            echo $this->content;
        }
        
        public function generateLocalNav(){
            echo $this->localNav;
        }
        
        public function getYear(){
            $currentYear = date('Y');
            echo $currentYear;
        }
        
        
    }
?>
