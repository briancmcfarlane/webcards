<?php

class AdminAccounts{

	    public function __construct($acctFile, $supportFile) {
        
			include_once 'includes/xml-formatter.php';
        
			$this->accountsDataFilePath = $acctFile;
			$this->supportDataFilePath = $supportFile;
			$this->accountsData = simplexml_load_file($acctFile);
			$this->supportData = simplexml_load_file($supportFile);
			
			$this->currentAdmin = $this->loadCurrentAdminInfo();
			$this->userTableData  = $this->loadAllUserData();
			$this->supportTableData  = $this->loadAllSupportData();
			
			if ($_POST['delMsg'] === 'Remove Message'){
            
				$this->removeMessage();

			}

        
    }


	public function loadCurrentAdminInfo(){
        
        $allAccounts = count($this->accountsData->acct);
        
        for ($x=1; $x<$allAccounts; $x++){
            if ((string)$this->accountsData->acct[$x]->email === $_SESSION['email']){
                $acctToLoad = $this->accountsData->acct[$x];
            }
        }
        return $acctToLoad;
    }
    
    public function loadAllUserData(){
		$allAccounts = count($this->accountsData->acct);
		$allAccTable = '<table><tr><th></th><th>User Name</th><th>Email</th><th>Plan</th><th>Is Admin</th><th># Cards</th></tr>';

		for ($x=0; $x<$allAccounts; $x++){
				$valOfPost = $x +1;
                $allAccTable .= '<tr><td><input type="radio" name="postVal" value="'. $valOfPost . '"/></td><td>' . $this->accountsData->acct[$x]->name . '</td><td><a href = mailto:' . $this->accountsData->acct[$x]->email . '>' . $this->accountsData->acct[$x]->email .'</a></td><td>' . $this->accountsData->acct[$x]->plan .'</td><td>' . $this->accountsData->acct[$x]->isAdmin . '</td><td>' . $this->accountsData->acct[$x]->totalWebcards .'</td></tr>'; 
        
        
        }
        $allAccTable .= '</table>';
        return $allAccTable;
		
		
	}
	
	public function loadAllSupportData(){
		$allMsg = count($this->supportData->msg);
		$allMsgTable = '<table><tr><th>User Name</th><th>Email</th><th>Subject</th><th>Message</th></tr>';
		for ($x=0; $x<$allMsg; $x++){
			    $valOfPost = $x +1;   
                $allMsgTable .= '<tr><td>' . $this->supportData->msg[$x]->name . '</td><td><a href = mailto:' .  $this->supportData->msg[$x]->email . '>' . $this->supportData->msg[$x]->email .'</a></td><td>' . $this->supportData->msg[$x]->subject .'</td><td>' . $this->supportData->msg[$x]->message . '</td></tr>'; 
        
        
        }
        $allMsgTable .= '</table>';
        return $allMsgTable;
		
	}
	


}
?>
