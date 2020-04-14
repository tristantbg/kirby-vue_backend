<?php
kirby()->response()->header('Access-Control-Allow-Origin','*');
kirby()->response()->header('Access-Control-Allow-Credentials', 'true');
kirby()->response()->header('Access-Control-Allow-Methods', 'GET,HEAD,OPTIONS,POST,PUT');
kirby()->response()->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization');
kirby()->response()->header('Content-type', 'application/json; charset=utf-8');
