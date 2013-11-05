<?php require 'session.php';?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<?php echo "<title>".PROJECT." ".VERSION." - Help</title>\n"; ?>
<style type="text/css" media="all">@import "files/main.css";</style>
<script type='text/javascript' src='files/jquery-1.3.2.min.js'></script>
<script type='text/javascript' src='files/script.js'></script>
</head>
<body>
<?php
require 'opendb.php';
require 'functions.php';
require 'header.php';
?>

<div id="Content">
	<div>
		<a name='title'><strong>".PROJECT." - Help</strong></a>
		
		<ol>
			<li><a href="#h-1">Description</a></li>
			<li><a href="#h-2">Explanation of the pages/functions</a></li>
			<li><a href="#h-3">Changelog</a></li>
			<li><a href="#h-4">License</a></li>
		</ol>
	</div>
	

	<h2><a name="h-1">1</a> Description</h2> 
	<p>
	This tool lets the people of different companies who work together for a common project to load the information about effort and cost spent for the project. At the moment this tool lets save the info about the company overall. In some next release it should be possible inserting information about the single person.
	</p>
	<a href="#title">^</a>

	<h2><a name="h-2">2</a> Explanation of the pages/functions</h2>
	<p>
	<dl>
	  <dt>Select Project:</dt>
	    <dd>-  The first page through which the user can select the corresponding project in order to load the effort and cost report</dd>
	  <dt>Monthly Report</dt>
	    <dd>- This page lets the user to load the effort report only for a single month</dd>
	  <dt>Show M. Report</dt>
	    <dd>- This page shows all the monthly reports loaded for the project selected</dd>
	  <dt>Six-Monthly Report</dt>
	    <dd>- This page lets the user to load the effort and cost report referencing to the six montly just passed</dd>
	  <dt>Show SM Report</dt>
	    <dd>- This page shows all the report inserted for relative sixmonthly report</dd>
	  <dt>Export Report</dt>
	    <dd>- This function allows to export the effort and cost report in Excel file.
	                Simple users can export only the info about their company.
	                The administrator is able to export all information of all companies about the selected project.</dd>
	  <dt>Change Password</dt>
	    <dd>- As named, this page lets the user to change his password</dd>
	  <dt>Logs</dt>
	    <dd>- This page is available only for the Administrator and lets to know who user has inserted the report and When</dd>
	  <dt>Help</dt>
            <dd>- This page.</dd>
          <dt>Logout</dt>
	    <dd>- Function to log out</dd></dd>
	</dl> 
	</p>
	<a href="#title">^</a>

	<h2><a name="h-3">3</a> Changelog</h2>
	<p>
	<dl>
	<dt>Version 1.5:</dt>
            <dd>- different effort accounting: hours and months</dd>
            <dd>- effort fields on Cost table are now readonly</dd>
            <dd>- user's name is always present, for security</dd>
            <dd>- some style changes</dd>
  	
	<dt>Version 1.4:</dt>
	    <dd>- audit page was added to see Who inserts What</dd>
	<dt> Version 1.3</dt>
	    <dd>- the footer was added with contact email</dd>
	    <dd>- the change password page was added</dd>
	<dt>Version 1.2</dt>
	    <dd>- It was unified the page for complete export. Users can export only the info about their company. The administrator is able to extract all information</dd>
	<dt>Version 1.1</dt>
	    <dd>- the show report page was added for monthly and six-monthly report</dd>
	    <dd>- the link was added for export the monthly and six-monthly report in Excel format</dd>
	<dt>Version 1.0</dt>
	    <dd>- first version of the tool</dd>
	    <dd>- session management: user and password</dd>
	    <dd>- insert page for monthly and six-monthly report</dd>
	    <dd>- logout page</dd>
	</dl>     
	</p>
	<a href="#title">^</a>

	
	<h2><a name="h-4">4</a> License</h2>
	<p>
	        This tool is licensed with Creative Commons by-sa 3.0 
			For more information refers to the page <a href='http://creativecommons.org/licenses/by-sa/3.0/' >Creative Commons by-sa 3.0 </a>
	</p>
	<a href="#title">^</a>
</div>


<?php
include 'footer.php';
?>
</body>
</html>
