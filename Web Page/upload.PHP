<?php
	// This file demonstrates file upload to an S3 bucket. This is for using file upload via a file compared to just having the link.
	// we must setup your bucket to have the proper permissions. 
	// I have used composer to install the needed AWS packages.
	require './vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	// AWS Info
	$bucketName = 'cwad-bucket-one'; // bucket name
	$IAM_KEY = 'AKIAVZ7WJM2TPJ5DFN2R'; // IAM key of user
	$IAM_SECRET = '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'; // IAM secret key of user

	// Connect to AWS
	try {
		// we may need to change the region. It will say in the URL when the bucket is open
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
	
	
	// For this, I would generate a unqiue random string for the key name.
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


?>
<html>
<body>

<h2>Your file has been successfully uploaded on AWS S3</h2>
<p><a href="http://cwad-webpage.s3-website.us-east-2.amazonaws.com/">Click Here to View Breathing Chart</a></p>

</body>
</html>
