<?php
require_once 'includes/initializer.php';

$page_title = APP_NAME.' | All In One';

use Lib\Config\DBController as Database;
use Lib\Utils\Logger;
use Lib\Utils\Message as Message;

//Instantiate db_handler object from database class
$db_handler = new Database;

//On submit Set Notification button
if (isset($_POST['notfButton'])) {
	/*
	*Notification type values to pass:
	*success, error, notification
	*/
	$notificationType=$_POST['notificationType'];
	Message::SetMessage($notificationType, "Here your message.");
}

//On submit Insert Data button
if (isset($_POST['insertButton'])) {
	$subject=$_POST['subject'];
	$message=$_POST['message'];

	/*
	*Queary
	*The values must be passed as a question mark.
	*/
    $query = <<<SQL
        INSERT INTO tbl_email
        SET subject=?, message=?, sender_id=?
    SQL;


    /*
    *Create the query values as an array
    *The sequence must be as the order of query
    */
    $values=array($subject,$message,1);


    /*
    *Pass both query and values to the Database controller
    *
    *And get the response, The response may be: .
    *'Success' for a query executed without error 
    *'Failed' if a query failed for an unknown error, most of times errors from a user.
    *'Error (PDOException)' for an error that occurred on the query or database connection.
    *
    *'baseQuery()' is the public function in Database controller class.
    *It accept 2 parameters:
    *'query' SQL query e.g. INSERT INTO....
    *'values' variables to pass as values to the query. It is an array to pass multiple variables as a single parameter.
    *
    *The function baseQuery is used for INSERT, UPDATE, and DELETE. 
    */
    $response=$db_handler->baseQuery($query, $values);


    /*
    *The response will be an array:
    *'Index 0' contains its type (Success, Failed, and Error)
    *The details of the response for an error is at array index 1
    */
    if ($response[0]==='Success') {
    	//Show the message for the action completed without error.
        Message::SetMessage('success', 'Successfully Sent');
    }else if($response[0]==='Failed'){
    	//Display error message for unexpected errors, most of times errors from a user.
        Message::SetMessage('error', "Failed to send");
    }else{
    	//Error message that occurred on the query or database connection
        Message::SetMessage('error', "Failed to send the Email");

        //Register Query or Database or PDOException errors in log file.
        Logger::Log(implode(';', $response));
    }
}

//Declare empty $singleRow array variable to store retrieved row.
$singleRow=array();
//On submit Search a Single Message
if (isset($_POST['searchSingleRowButton'])) {
	$emailID=$_POST['emailID'];

	/*
	*Single row search query because their no E-Mail in the database with the same ID, it is a unique (primary) key.
	*/
	$query = <<<SQL
		SELECT * FROM tbl_email WHERE id=? LIMIT 1
	SQL;


	/*
	*Pass email id as $emailID variable to SQL
	*/
	$values=array($emailID);


	/*
	*baseSelect() function is used to retrive a single row from Database controller
	*
	*baseQuery() function retrieve a row and assign it to '$singleRow' variable.
	*
	*$singleRow variable have two values:
	*At index 0 response type (Success or Error).
	*At index 1 another 2 optional reponses:
	*'Option 1' when the query is executed without error, so it contains actual row
	*'Option 2' when Error occured, so it contains detail of Error.
	*/
	$singleRow=$db_handler->baseSelect($query, $values);


	//Check for errors
	if ($singleRow[0]==='Error') {
		//Register errors in log file.
	    Logger::Log($singleRow[1]);
	    //Make $singleRow variable back to empty
	    $singleRow=[];

	    //Disply alert to the user for error occurred.
	    Message::SetMessage('error', "Can't Fetch a Message");
	}else{
		/*
		*When row retrieved without error:
		*Assign the retrived row from the respose to '$singleRow' array  variable
		*/
	    $singleRow=$singleRow[1];

	    /*
	    *Finally use the retrieved row as object
	    *E.g. $singleRow->subject
	    *Look at the example bellow in select a single row section
	    */
	}
}

//Declare empty $multipleRows array variable to store retrieved rows.
$multipleRows=array();
//On submit Retrive all Messages
if (isset($_POST['retriveMultipleRowsButton'])) {

	/*
	*Single row search query because their no E-Mail in the database with the same ID, it is a unique (primary) key.
	*/
	$query = <<<SQL
		SELECT * FROM tbl_email ORDER BY subject ASC
	SQL;


	/*
	*The empty array indicates their no value to pass
	*/
	$values=array();


	/*
	*multiSelect() function is used to retrive multiple rows from Database controller
	*
	*multiSelect() function retrieve rows and assign it to '$multipleRows' variable.
	*
	*$multipleRows variable have two values:
	*At index 0 response type (Success or Error).
	*At index 1 another 2 optional reponses:
	*'Option 1' when the query is executed without error, so it contains actual row
	*'Option 2' when Error occured, so it contains detail of Error.
	*/
	$multipleRows=$db_handler->multiSelect($query, $values);


	//Check for errors
	if ($multipleRows[0]==='Error') {
		//Register errors in log file.
	    Logger::Log($multipleRows[1]);
	    //Make $multipleRows variable back to empty
	    $multipleRows=[];

	    //Disply alert to the user for error occurred.
	    Message::SetMessage('error', "Can't Fetch Messages");
	}else{
		/*
		*When row retrieved without error:
		*Assign the retrived row from the respose to '$multipleRows' array  variable
		*/
	    $multipleRows=$multipleRows[1];
	    /*
	    *Finally use foreach loop to display each rows on browser.
	    *Look at the example bellow in select multiple rows section
	    */
	}
}

require_once "includes/header.php";
?>

<!--Web page body DIV-->
<div class="container" align="center">
	<br>
	<br>
	<font color="red" size="5">Before you start this tutor first look <strong>database-using-way.php</strong> PHP file from root directory of the project standard.</font>
	<br>
	<br>
	<!--View notification alert-->
	<div class="row">
		<div class="col-md-6">
			<?php require 'includes/notification.php'; ?>
			<h4>Set notification</h4>
			<form method="post">
				<div class="form-group">
					<label for="exampleInputEmail1">Notification Type</label>
					
					<select class="form-control" name="notificationType" required>
						<option value="">*Select notification type*</option>
						<option value="success">Success</option>
						<option value="error">Error</option>
						<option value="notification">Notification</option>
					</select>
				</div><br>
				<button type="submit" name="notfButton" class="btn btn-primary">Set Notification</button>
			</form>
		</div>
	</div>
	<!--END, View notification alert-->

	<hr>

	<!--View notification messages-->
	<div class="row">
		<div class="col-md-6">
			<h4>Insert data into Database | send Email</h4>
			<form method="post">
				<div class="form-group">
					<label for="subject">Subject</label>
					<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
				</div>

				<div class="form-group">
					<label for="message">Message</label>
					<textarea class="form-control" id="message" name="message" rows="3" placeholder="Write your message here" required></textarea>
				</div>
				<br>
				<button type="submit" name="insertButton" class="btn btn-primary">Insert Data</button>
			</form>
		</div>
	</div>
	<!--END, View notification messages-->

	<hr>

	<!--Select a single row from a database table-->
	<div class="row">
		<div class="col-md-6">
			<h4>Select a single row from a database table | Search E-Mail by ID</h4>
			<form method="post">
				<div class="form-group">
					<label for="emailID">Subject</label>
					<input type="text" class="form-control" id="emailID" name="emailID" placeholder="Email ID" required>
				</div>
				<br>
				<button type="submit" name="searchSingleRowButton" class="btn btn-primary">Search a Single Message</button>
			</form>
			<br>
			<?php if(!empty($singleRow)) : ?>
				<table cellpadding="5" class="table">
					<tr>
						<th>ID</th>
						<th>Subject</th>
						<th>Message</th>
						<th>Date</th>
					</tr>
					<tr>
						<td><?= $singleRow->id ?></td>
						<td><?= $singleRow->subject ?></td>
						<td><?= $singleRow->message ?></td>
						<td><?= $singleRow->sent_date ?></td>
					</tr>
				</table>
			<?php endif; ?>
		</div>
	</div>
	<!--Select a single row from a database table-->

	<hr>	

	<!--Select multiple rows from a database table-->
	<div class="row">
		<div class="col-md-6">
			<h4>Select multiple rows from a database table | Retrive all messages</h4>
			<form method="post">
				<button type="submit" name="retriveMultipleRowsButton" class="btn btn-primary">Retrive all Messages</button>
			</form>
			<br>

			<table cellpadding="5" class="table">
				<tr>
					<th>ID</th>
					<th>Subject</th>
					<th>Message</th>
					<th>Date</th>
				</tr>
				<?php foreach ($multipleRows as $singleRow) : ?>
					<tr>
						<td><?= $singleRow->id ?></td>
						<td><?= $singleRow->subject ?></td>
						<td><?= $singleRow->message ?></td>
						<td><?= $singleRow->sent_date ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
	<!--Select a single row from a database table-->

	<br>
	<br>
	<br>
</div>
<!--END, Web page body DIV-->

<?php require_once "includes/footer.php"; ?>