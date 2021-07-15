<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$buttonHtml = '';

if($button){
    $buttonHtml = '<a href="'.$button['link'].'" class="btn btn-primary">'.$button['label'].'</a>';
}
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting"> 
    <title></title> 
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    
    <style>
      table {
			border-spacing: 0 !important;
			width:100%;
		}
      .main{
         max-width: 600px; 
		 margin: 0px auto; 
		 padding: 80px 0px;
         font-family: 'Lato', sans-serif;
	   }
	   .main td{
		 text-align:center;
         font-family: 'Lato', sans-serif;
	   }
	   .top-content{
	     background:#fff;
		 padding: 25px 45px;
	   }
       .logo{
        color: #000000;
        font-size: 24px;
        font-weight: 700;
        font-family: 'Lato', sans-serif;
		text-decoration:none;
		color:#000 !important;
       }
	   
	   h3{
	     font-size: 24px;
         font-weight: 300;
		 color:#000 !important;
	   }
	   .top-content p{
	         color: rgba(0,0,0,.3);
             font-size: 16px;
	   }
	   
	   .btn {
    padding: 10px 15px;
    display: inline-block;
	text-decoration:none;
}
	   .btn.btn-primary {
			border-radius: 5px;
			background: #534666;
			color: #ffffff;
		}
		
	   .footer-content{
	         width: 100%;
          background: #fafafa;
		  padding: 25px 45px;
	   }
       .footer-content p{
         color: rgba(0,0,0,.5);
       }

       @media only screen and (max-width:500px){
        .footer-content{
		  padding: 15px 20px;
        }
        .top-content{
            padding: 25px 20px;
        }
        .main{
            padding: 0px 0px;
        }
        .top-content p{
			 font-size: 14px;
	    }
       }
	   
     </style>
    </head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #0062cc;" contenteditable="false">
       <table class="main">
	      <tr>
		     <td>
			    <table class="top-content">
				    <tr>
					   <td>
						  <h3><?= $title ?></h3>
						  <?php 
							  if(!is_array($content)) echo '<p>'._eg($content).'</p>';
							  else{
								  foreach($content as $value){
									echo '<p>'._eg($value).'</p>';
								  }
							  } 
						  ?>
						  <?= $buttonHtml ?>
					   </td>
					</tr>
				</table>
			 </td>
		  </tr>
		  <tr>
		    <td>
			    <table class="footer-content">
				     <tr>
					    <td>
						  <p></p>
						  <p></p>
						</td>
                     </tr>					 
				</table>
			 </td>
		  </tr>
	   </table>
   </body>
</html>
            

