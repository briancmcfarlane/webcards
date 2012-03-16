<?php

class WebcardImporter{
    
    public function __construct($dataFile) {
        
        include 'includes/xml-formatter.php';
        
        $this->data = simplexml_load_file($dataFile);
        
        $this->webcardTable = $this->loadUsersCards();
        
    }
    
    public function loadUsersCards(){
        
        $allCards = count($this->data->webcard);
        
        $table = '<table border="1"><thead><tr><th>Sender</th><th>Recipient</th><th>Text Style</th><th>Border</th><th>Message</th></tr></thead><tbody>';

        for ($x=0; $x<$allCards; $x++) {

        if ((string)$this->data->webcard[$x]->user === $_SESSION['email']) {
            $table .= '<tr>';
            $table .= '<td>' . $this->data->webcard[$x]->sender . '</td>';
            $table .= '<td>' . $this->data->webcard[$x]->recipient . '</td>';
            $table .= '<td>' . $this->data->webcard[$x]->txtstyle . '</td>';
            $table .= '<td>' . $this->data->webcard[$x]->bordr . '</td>';
            $table .= '<td>' . $this->data->webcard[$x]->message . '</td>';
            $table .= '</tr>';
        }

        }
        
        $table .= '</tbody></table>';
        
        return $table;
    
    }    
    
    
}
    
?>
