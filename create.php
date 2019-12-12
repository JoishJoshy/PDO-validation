<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>
<script>
	function validate()
	{
		var fname=document.forms["form1"]["firstname"].value;
		var lname=document.forms["form1"]["lastname"].value;
		var email=document.forms["form1"]["email"].value;
		var age=document.forms["form1"]["age"].value;
		var location=document.forms["form1"]["location"].value;
		var atposition=email.indexOf("@");
		var dotposition=email.lastIndexOf(".");
	if(fname=="")
	{
		alert("Enter a valid firstname");
		document.forms["form1"]["firstname"].focus();
		return false;
	}
	if(lname=="")
	{
		alert("Enter a valid lastname");
		document.forms["form1"]["lastname"].focus();
		return false;
	}
	 
	if(email=="")
	{
		alert("Enter a valid email");
		document.forms["form1"]["email"].focus();
		return false;
	}
	 if(atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length)
	 {
		 alert("Enter a valid email");
		document.forms["form1"]["email"].focus();
		return false;
	 }
	if(age=="")
	{
		alert("Enter a valid age");
		document.forms["form1"]["age"].focus();
		return false;
	}
	if(isNaN(age))
	{
		alert("Enter a valid age");
		document.forms["form1"]["age"].focus();
		return false;
	}
	if(location=="")
	{
		alert("Enter a valid location");
		document.forms["form1"]["location"].focus();
		return false;
	}
	}
	</script>
	

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a user</h2>

<form name="form1" method="post" onsubmit="return validate()">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
