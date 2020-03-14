import boto3
from botocore.client import Config

ACCESS_KEY_ID = 'AKIA4PIWNSJYA747MI4E'
ACCESS_SECRET_KEY = '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'
BUCKET_NAME = 'cwad-bucket-one'


s3 = boto3.resource(
    's3',
    aws_access_key_id=ACCESS_KEY_ID,
    aws_secret_access_key=ACCESS_SECRET_KEY,
    config=Config(signature_version='s3v4')
)

response = s3.Bucket(BUCKET_NAME).download_file('testing+v49-02-03-2020-17_35_31.json','test.json')

print ("Done!")
print(response)