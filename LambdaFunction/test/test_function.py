import json
import boto3
import numpy as np
from src.lambda_function import *
from test import *

def test(event, context):
    s3 = boto3.client("s3")
    json_file = s3.get_object(Bucket = "mainlamdbas3", Key = "test.json") # Getting object from bucket name and json key name
    resp = my_json_data(json_file) # Calling my_json_data function from the lambda_function.py file
    assert resp=={'statusCode': 200, 'body': '[3273, 3270, 3270, 3518, 3519]'} #  testing if a condition in our code returns True, if not, the program will raise an AssertionError. 
    return  "Test is successfully run!!" # if it return True. It will print the statement.
