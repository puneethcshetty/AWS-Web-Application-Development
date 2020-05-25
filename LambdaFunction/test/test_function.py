import json
import boto3
import numpy as np
from src.lambda_function import *
from test import *


def test(event, context):
    s3 = boto3.client("s3")
    json_file = s3.get_object(Bucket = "mainlamdbas3", Key = "test.json")
    resp = my_json_data(json_file)
    print(resp)
    assert resp=={'statusCode': 200, 'body': '[3273, 3270, 3270, 3518, 3519]'}
    return  "Test is successfully run!!"
