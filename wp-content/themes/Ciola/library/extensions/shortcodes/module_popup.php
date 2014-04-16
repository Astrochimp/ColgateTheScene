<?php
// this file contains the contents of the popup window
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert Category Module</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
<script language="javascript" type="text/javascript" src="tiny_mce_popup.js"></script>
<link rel="stylesheet" href="css/friendly_buttons_tinymce.css?version=3" />


<script type="text/javascript">
$(document).ready(function(){
  jQuery( "#button-type" ).click(function() {
    var moduleSelection = $(this).val();
     if (moduleSelection === 'a') {
                $('#button-amount').attr({ min: '4', max: '6', step: '2', value: '4' });
     } else if (moduleSelection === 'b') {
                $('#button-amount').attr({ min: '3', max: '12', step: '1', value: '4'});
     } else if (moduleSelection === 'c') {
                $('#button-amount').attr({ min: '2', max: '12', step: '1', value: '2' });
     } else if (moduleSelection === 'd') {
                $('#button-amount').attr({ min: '3', max: '12', step: '1', value: '5' });
     } else if (moduleSelection === 'e') {
                $('#button-amount').attr({ min: '12', max: '12', step: '1', value: '12' });
     } else if (moduleSelection === 'f') {
                $('#button-amount').attr({ min: '12', max: '12', step: '1', value: '12' });
     } else if (moduleSelection === 'g') {
                $('#button-amount').attr({ min: '12', max: '12', step: '1', value: '12' });
     } else if (moduleSelection === 'h') {
               $('#button-amount').attr({ min: '2', max: '16', step: '1', value: '2' });
     }
     
   });
});
    
    
var ButtonDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var category = jQuery('#button-dialog input#button-category').val();
        var type = jQuery('#button-dialog select#button-type').val();        
        var amount = jQuery('#button-dialog input#button-amount').val();        
		 
		var output = '';
		
		// setup the output of our shortcode
		output = '[module ';
			output += 'type=' + type + ' ';
            output += 'category="' + category + '" ';
            output += 'amount="' + amount +'" ';
			output += ']';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);

  
</script>

</head>
<body>
	<div id="button-dialog">
		<form action="/" method="get" accept-charset="utf-8" onsubmit="javascript:ButtonDialog.insert(ButtonDialog.local_ed);return false;">

		  <div>
                <label for="button-type">Module</label>
                <select name="button-type" id="button-type" size="1">
                    <option value="a" selected="selected">A: 100% width</option>
                    <option value="b">B: 50% width</option>
                    <option value="c">C: 50% width</option>
                    <option value="d">D: 50% width</option>
                    <option value="h">Blog Style A</option>
                    <option value="f">Slider: 1 full-width post</option>
                    <option value="e">Slider: 2 wide posts</option>
                    <option value="g">Slider: 3 tall posts</option>
                </select>
            </div>
            
            <div>
                <label for="button-category">Category Slug</label>
                <input type="text" name="button-category" value="" id="button-category" />
            </div>
            
            <div>
                <label for="button-amount">Amount Of Posts To Show:</label>
                <input type="number" name="button-amount" min="4" max="6" step="2" value="4" id="button-amount" />
            </div>
			<br clear="both" />
			<div>	
				<a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
			</div>
		</form>
	</div>
</body>
</html>