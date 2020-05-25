<?php
	// This file demonstrates file upload to an S3 bucket. This is for using file upload via a
	// file compared to just having the link. If you are doing it via link, refer to this:
	// 	//
	// You must setup your bucket to have the proper permissions. To learn how to do this
	// refer to:
		
	// I will be using composer to install the needed AWS packages.
	require './vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	// AWS Info
	$bucketName = 'cwad-bucket-one';
	$IAM_KEY = 'AKIAVZ7WJM2TPJ5DFN2R';
	$IAM_SECRET = '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';

	// Connect to AWS
	try {
		// You may need to change the region. It will say in the URL when the bucket is open
		// and on creation.
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'us-east-1'
			)
		);
			} catch (Exception $e) {
		// We use a die, so if this fails. It stops here. Typically this is a REST call so this would
		// return a json object.
		die("Error: " . $e->getMessage());
	}
	
	
	// For this, I would generate a unqiue random string for the key name. But you can do whatever.
	$keyName = '' . basename($_FILES["fileToUpload"]['name']);
	$pathInS3 = 'https://s3.us-east-1.amazonaws.com/' . $bucketName . '/';

	// Add it to S3
	try {
		// Uploaded:
		$file = $_FILES["fileToUpload"]['tmp_name'];

		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}


	// Now that you have it working, I recommend adding some checks on the files.
	// Example: Max size, allowed file types, etc.
?>
<html>
<body>

<h2>Your file has been successfully uploaded on AWS S3</h2>
<p><a href="http://cwad-webpage.s3-website.us-east-2.amazonaws.com/">Click Here to View Breathing Chart</a></p>

</body>
</html>
