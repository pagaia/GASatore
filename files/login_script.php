<script type="text/javascript">
       $(document).ready(function() { 
           formLogin();
           function	formLogin() {
                $("#container").fadeIn();
				var options = { 
                    target       :  '.<?php echo $this->target_element; ?>',
                    timeout      :    <?php echo $this->timeout;?>,    
                    beforeSubmit :   request,  
                    success      :   response  
                }; 
               $('.<?php echo $this->form_element;?>').submit(function() {  $(this).ajaxSubmit(options); return false;});   
                function request(formData, jqForm, options) { 
                    valid = true;
                    $('.<?php echo $this->wait_element; ?>').hide();
                    var label = "<span class='ajax_spinner'><img src='files/ispinner.gif'/><?php echo $this->wait_text;?></span>";
                    $(".<?php echo $this->wait_element; ?>").after(label);
                    $('.<?php echo $this->notify_element; ?>').hide();						
                    if(valid) {
                      return true;
                    } else { 
                     $('.<?php echo $this->wait_element; ?>').show();
					 $('.ajax_spinner').fadeOut();
					 $(".ajax_spinner").remove();
					 $('.<?php echo $this->notify_element; ?>').fadeIn(); 
                      return false;
                    } 
                } 
                function response(responseText, statusText) {
				   $('.<?php echo $this->wait_element; ?>').show();
                   $('.ajax_spinner').fadeOut();
				   $(".ajax_spinner").remove();	
				 }
            }		
        }); 		
 </script>