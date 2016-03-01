<?php
require('db.php');
include("auth.php"); //include auth.php file on all secure pages
$status = "";
if(isset($_POST['new']) &&$_POST['user_cat'] && $_POST['new']==1)
{
$trn_date = date("Y-m-d H:i:s");
$name =$_REQUEST['name'];
//$age = $_REQUEST['age']; 
$post_brief =$_REQUEST['post_brief'];    
$post_detail =$_REQUEST['post_detail'];    
$submittedby = $_SESSION["username"];
$t1=implode(',',$_POST['user_cat']);
$ins_query="insert into new_record(`trn_date`,`name`,`post_brief`,`post_detail`,`submittedby`, `post_cat`)values('$trn_date','$name','$post_brief','$post_detail','$submittedby','$t1')";
mysql_query($ins_query) or die(mysql_error());
//$status = "New Record Inserted Successfully.</br></br><a href='post.php'>View Inserted Record</a>";
echo '<META http-equiv="refresh" content="0,url=report.php">';
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Stay Informed</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
                        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <link rel="stylesheet" href="css/normalize.css">
    	<link rel="stylesheet" href="css/zerogrid.css">
	<link rel="stylesheet" href="css/styl.css">
    	<link rel="stylesheet" href="css/responsive.css">
        <!-- EOF CSS INCLUDE -->                  
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="index.html">SAFE PAL</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                   
               
                           
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                   
                   
                    
                    
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                   
               
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
                        <div class="col-md-12">
                            
                            <form name="form" method="post" action="" enctype="multipart/form-data"  class="form-horizontal">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Report</strong> with Safe Pal</h3>
                                    
                                </div>
                                
                                <div class="panel-body form-group-separated">
                                   
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Number</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="hidden" name="new" value="1" />
                                                <input type="text" name="name" required class="form-control"/>
                                            </div>                                            
                                            <span class="help-block">This is sample of text field</span>
                                        </div>
                                    </div>
                                   
                                   
                                 
                                   
                                   
                                   
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Age</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                
                                                <input type="text" name="name" required class="form-control"/>
                                            </div>                                            
                                            <span class="help-block">This is sample of text field</span>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">location</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                
                                                <input type="text" name="name" required class="form-control"/>
                                            </div>                                            
                                            <span class="help-block">This is sample of text field</span>
                                        </div>
                                    </div>
                                   
                                   
                                    <div class="form-group">                                        
                                        <label class="col-md-3 col-xs-12 control-label">Datepicker</label>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                <input type="text" class="form-control datepicker" value="2014-11-01">                                            
                                            </div>
                                            <span class="help-block">Click on input field to get datepicker</span>
                                        </div>
                                    </div>
                                   
                                   
                                   
                                   
                                    
                                     <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Brief</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input type="text" name="post_brief" required class="form-control"/>
                                            </div>                                            
                                            <span class="help-block">This is sample of text field</span>
                                        </div>
                                    </div>
                                    
                                
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Details</label>
                                        <div class="col-md-6 col-xs-12">                                            
                                            <textarea class="form-control" name="post_detail" required rows="5"></textarea>
                                            <span class="help-block">Default textarea field</span>
                                        </div>
                                    </div>
                                    
<?php
// selected and uploaded a file

if (isset($_FILES['userImage']) && $_FILES['userImage']['size'] > 0) {


// Temporary file name stored on the server

$tmpName = $_FILES['userImage']['tmp_name'];


// Read the file

$fp = fopen($tmpName, 'r');

$data = fread($fp, filesize($tmpName));

$data = addslashes($data);

fclose($fp);



// Create the query and insert

// into our database.

$query = "INSERT INTO post_images ";

$query .= "(imageType) VALUES ('$data')";

$results = mysql_query($query, $connection);


}

else {

print "No image selected/uploaded";

}


// Close our MySQL Link

?>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Attach Media</label>
                                        <div class="col-md-6 col-xs-12">                                                                                                                                        
                                            <input type="file" class="fileinput btn-primary" name="userImage"  title="Browse file"/>
                                            <span class="help-block">Input type file</span>
                                        </div>

                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Categories</label>
                                        <div class="col-md-6 col-xs-12">                                                                                                                                        
                                            <label class="check"><input type="checkbox" name="user_cat[]" id="user_cat[]" value="general" class="icheckbox" /> general</label>
                                            <label class="check"><input type="checkbox" name="user_cat[]" id="user_cat[]" value="traders" class="icheckbox" /> traders</label>
                                            <label class="check"><input type="checkbox" name="user_cat[]" id="user_cat[]" value="students" class="icheckbox" /> students</label>
                                            <label class="check"><input type="checkbox" name="user_cat[]" id="user_cat[]" value="parents" class="icheckbox" /> parents</label>
                                            <label class="check"><input type="checkbox" name="user_cat[]" id="user_cat[]" value="institutions" class="icheckbox" /> institutions</label>
                                            <label class="check"><input type="checkbox" name="user_cat[]" id="user_cat[]" value="companies" class="icheckbox" /> Companies</label>
                                            <label class="check"><input type="checkbox" name="user_cat[]" id="user_cat[]" value="others" class="icheckbox" /> others</label>
                                            
                                            <span class="help-block">Checkbox cattegories you are updating</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <button class="btn btn-primary pull-right" value="Submit" name="submit">Submit</button>
                                </div>
                            </div>
                            </form>
                            
                        </div>
                    </div>                    
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="logout.php" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->             
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>                
        <!-- END PLUGINS -->
        
        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
       <!-- <script type="text/javascript" src="js/settings.js"></script>-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>

