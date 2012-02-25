<?php

class Form {
	
//key sets the label, default value  and id of each field, value determines the field type
//need to expand switch statement if using inputs other than <input> and <textarea>
public $fields = array('support' => array('name' => 'text','email' => 'text','subject' => 'text','message' => 'textarea'));

public function generateFields($values) {
	$output = "";
	$numFields = count($this->fields[$values]);
	$keys = array_keys($this->fields[$values]);
	$output =  "<ul class=\"support\">\n";
	
	for ($i=0; $i<$numFields; $i++) {
		$current = $keys[$i];
    	$type = $this->fields[$values][$current];
		
	    switch($type){
			case 'textarea':
				$output .=   "\t\t\t<li><textarea name=\"{$current}[]\" id=\"$current\">";
				$output .= $this->retainInput($current, $type);
				$output .= "</textarea></li>\n";
				break;
			default:
				$output .= "\t\t\t<li><input type=\"$type\" name=\"{$current}[]\" id=\"$current\" value=\"";
				$output .= $this->retainInput($current, $type);
				$output .= "\" /></li>\n";
				break;
		}
}
$output .= "\t\t</ul>";
return $output;
}
	
public function retainInput($arrKey) {
	
	if ($_POST[$arrKey][0]) {
     	return $_POST[$arrKey][0];
     }
	 else {
	 	return $arrKey;
	 } 
}

}
?>