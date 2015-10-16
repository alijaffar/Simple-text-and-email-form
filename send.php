<!DOCTYPE html>
<html>
<head>
  <title>Simple Email/Text Form by Ali</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <style type="text/css">
    .red{color:red;}
    .green{color:green;}
  </style>
</head>
<body>
 <div class="container">
	<div class="row">
	  <div class="col-sm-12">
		<h1>Simple Email/Text Contact Form by <a href="http://twitter.com/ali_jaffar">@ali_jaffar</a></h1>
		<hr />
	  </div>
	</div>
 </div>

 <div class="container">
	<div class="row">
		<div class="col-sm-12">
<?php	
  error_reporting(0); //mute PHP errors, turn on for debugging
	$max_chars = 100; // for subject & message -- this gets set in JS below, as well as in the <textarea maxlength=""
	if ($_POST['to'] && $_POST['message']): //validate we have a submission, later make this stricter w/ jQ.
		
		// trim = remove whitespace from beginning + end
		$to = trim( $_POST['to'] ); // isset($_POST['to']) ? $_POST['to']: 'your@email.com'; 
		$to = $to.$_POST['carrier']; 	// Lists of E-mail to text @addresses: http://www.makeuseof.com/tag/email-to-sms/
		$subject = trim( $_POST['subject'] );
		
		$from = $_POST['from'] ? $_POST['from'] : 'your@email.com'; // if no 'from' entered, use a default value
		$from= trim( $from );
		
		$message = trim( $_POST['message'] ); 
		
		$headers = 'From: '.$from.'' . "\r\n" .
			'Reply-To: '.$from.'' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
				
		// mail($to, $subject, $message, $headers);

		if( @mail($to, $subject, $message, $headers) ) :
		  echo '<div class="alert alert-success" role="alert">Success, sent!</div>';
		else:
		  echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Error. Enter a valid e-mail. <a href="" onclick="window.location.href=window.location.href;">Retry.</a></div>';
		endif;
		
	else: // display form if no submission
?>

			<form class="form-horizontal" action="<?=$_SERVER['SCRIPT_NAME']?>" method="POST">

			  <div class="form-group">
				<label for="from" class="col-sm-2 control-label">From</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" name="from" placeholder="Cell or Email (Optional)" />
				</div>
			  </div>
										
			  <div class="form-group">
				<label for="subject" class="col-sm-2 control-label">Subject</label>
				<div class="col-sm-10">
				  <textarea class="form-control" name="subject" id="t1" placeholder="Subject (Optional)" rows="1" maxlength="<?=$max_chars?>"></textarea>
				  <small id="char_count"></small> 
				</div>
			  </div>

			  <div class="form-group">
				<label for="from" class="col-sm-2 control-label">Message</label>
				<div class="col-sm-10">
				  <textarea class="form-control" name="message" id="message" value="" placeholder="Message" maxlength="<?=$max_chars?>" required rows="4" onkeyup="countChar(this)"></textarea>
				  <small id="rev_char_count"></small>
				  
				</div>
			  </div>
			  
			  <hr />
																  
			  <div class="form-group">
				<label for="to" class="col-sm-2 control-label">To</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" name="to" placeholder="Cell or Email" required />
				</div>
			  </div>

			  <div class="form-group">
				<label for="carrier" class="col-sm-2 control-label">Carrier?</label>
				<div class="col-sm-10">
					<select name="carrier" class="form-control">
						<option value="" selected>No, just an E-mail.</option>
						<option value="@txt.att.net ">ATT</option>

						<option value="@myboostmobile.com">Boost Mobile</option>
						<option value="@mymetropcs.com">Metro PCS</option>
						<option value="@messaging.sprintpcs.com">Sprint</option>
						<option value="@tmomail.net">T-Mobile</option>
						<option value="@vtext.com">Verizon Wireless</option>    
						<option value="@vmobl.com">Virgin Mobile</option>
					</select>                              
				</div>
			  </div>                          

			 <div class="form-group">
			   <div class="col-sm-offset-2 col-sm-10">
				 <button type="submit" class="btn btn-primary" />Send it <span class="glyphicon glyphicon-send" aria-hidden="true"></span></button>
			   </div>
			 </div>                            
				
			</form>                  
                        
  <script type="text/javascript">
  	$('textarea').on('input propertychange', function() {
  		var ctrl =$(this),
  			max_len = <?php echo $max_chars; ?>,
  			len = $(ctrl).val().trim().length; 			
  		if($(ctrl).attr('id') == 't1') {
  			var c = $(ctrl).parent().find('#char_count');
  			c.text(len > 0 ? len + ' character' + (len == 1 ? '' : 's') : '');		
  			if(len < 4 || len > max_len)
      			c.removeClass('green').addClass('red');
  			else
      			c.removeClass('red').addClass('green');
  		}
  		else {
  			var c = $(ctrl).parent().find('#rev_char_count');
  			len = max_len -len;
  			c.text(len > 0 ? (len + ' character' + (len == 1 ? '' : 's')  + ' remaining.') : '');
  			$(ctrl).val($(ctrl).val().substring(0, max_len));
  			
  			if(len < 10 || len > max_len)
      			c.removeClass('green').addClass('red');
  			else
      			c.removeClass('red').addClass('green');
  							
  		}		
  	}); 
  </script>  
  
  <?php endif; //end the if condition which displays the form if it wasn't previously submitted ?>
	  </div> <!-- /col -->
	</div> <!-- /row -->
  </div> <!-- /container -->
</body>
</html>
