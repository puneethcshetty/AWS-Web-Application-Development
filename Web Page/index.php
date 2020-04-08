<!DOCTYPE html>
<html>
<title>PHP file upload page</title>
<h1>Welcome to CS682 Web Application Page</h1>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select file to upload into S3:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload File" name="Submit">
</form>

</body>
</html>