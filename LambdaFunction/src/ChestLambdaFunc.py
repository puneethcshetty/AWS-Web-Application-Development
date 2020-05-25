import json
import boto3
import numpy as np


def my_json_data(json_file):
	#decoding file as file is fetched with utf-8
	json_content = json_file["Body"].read().decode('utf-8')
	json_data = json.loads(json_content)
	
	#fetch required data from json
	data = json_data['samples']
	chest = np.array([d['c'] for d in data])
    
	#get dynamoDB instance and put filtered data into DB
	dynamoDB = boto3.resource("dynamodb")
	table = dynamoDB.Table('CWAD_data')
	item = {
        'Customer_id': 0,
        'Chest_data': json.dumps(chest.tolist())
	}
	table.put_item(Item = item)
	
	#return filtered data for customer
	return {
		'statusCode': 200,
		'body': json.dumps(chest.tolist())
	}
	
def lambda_handler(event, context):
    #boto3 is used to communicate with other AWS services
	s3 = boto3.client("s3")
    
	#get json file using file name
	json_file = s3.get_object(Bucket = "cwad-bucket-one", Key = "2020-04-28_Kate_test_Raw.json")
	
	return my_json_data(json_file)
