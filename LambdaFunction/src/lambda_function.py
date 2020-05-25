import json
import boto3
import numpy as np

def my_json_data(json_file):
    json_content = json_file["Body"].read().decode('utf-8')
    json_data = json.loads(json_content)
    data = json_data["samples"]
    chest = np.array([d["c"] for d in data])
    return {
        'statusCode': 200,
        'body': json.dumps(chest.tolist())
    }

def lambda_handler(event, context):
    s3 = boto3.client("s3")
    json_file = s3.get_object(Bucket = "cwad-bucket-one", Key = "2020-04-28_Kate_test_Raw.json")
    return my_json_data(json_file)
