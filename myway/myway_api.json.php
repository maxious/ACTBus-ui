<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */

function cleanString($subject) {
    $subject = str_replace("&nbsp;", " ", $subject);
    $subject = str_replace("&", "&amp;", $subject);
    $subject = preg_replace('/[^\r\n\t\x20-\x7E\xA0-\xFF]/', '', $subject);
    $subject = str_replace("  ", " ", $subject);
    return trim($subject);
}

$return = Array();
/* if (file_exists("mywayresponse.txt")) {
  @$fh = fopen("mywayresponse.txt", 'r');
  if ($fh) {
  $pageHTML = fread($fh, filesize("mywayresponse.txt"));
  fclose($fh);
  }
  } */
//set POST variables
$url = 'https://www.transport.act.gov.au/catch_a_bus/myway/check_your_balance?sq_content_src=%2BdXJsPWh0dHAlM0ElMkYlMkZmaWxlcy50cmFuc3BvcnQuYWN0Lmdvdi5hdSUyRkFSVFMlMkZ1c2VfRnVuY3MuYXNwJmFsbD0x';
//$url = 'http://localhost/myway.html';
$field_mapping = Array(
    "card_number" => "SRNO",
    "DOBmonth" => "month",
    "DOBday" => "day",
    "DOByear" => "year",
    "secret_answer" => "pwrd",
    "button" => "Submit",
    "rows" => "rows"
);
foreach (Array(
"card_number",
 "DOBday",
 "DOBmonth",
 "DOByear"
) as $field_name) {
    if (isset($_REQUEST[$field_name])) {
        $fields[$field_name] = filter_var($_REQUEST[$field_name], FILTER_SANITIZE_NUMBER_INT);
    } else {
        $return["error"][] = $field_name . " parameter invalid or unspecified";
    }
}
if (isset($_REQUEST['secret_answer'])) {
    $fields['secret_answer'] = filter_var($_REQUEST['secret_answer'], FILTER_SANITIZE_STRING, Array(
        FILTER_FLAG_NO_ENCODE_QUOTES,
        FILTER_FLAG_STRIP_HIGH,
        FILTER_FLAG_STRIP_LOW
            ));
} else {
    $return["error"][] = "secret_answer parameter invalid or unspecified";
}
$fields['button'] = 'Submit';
$fields['rows'] = '200';
$fields['sq_content_src'] = '+dXJsPWh0dHAlM0ElMkYlMkZmaWxlcy50cmFuc3BvcnQuYWN0Lmdvdi5hdSUyRkFSVFMlMkZ1c2VfRnVuY3MuYXNwJmFsbD0x';
$fields_string = "";
//url-ify the data for the POST
foreach ($fields as $key => $value) {
    if (sizeof($value) === 0)
        $return['error'][] = $key . " parameter invalid or unspecified";
    $fields_string.= $field_mapping[$key] . '=' . urlencode($value) . '&';
}
$fields_string = rtrim($fields_string, '&');
if (!isset($return['error'])) {
    //open connection
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    // ssl ignore
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    //execute post
    $pageHTML = curl_exec($ch);
    if (curl_errno($ch))
        $return["error"][] = "Network error " . curl_errno($ch) . " " . curl_error($ch) . " " . $url . $fields_string;
    //close connection
    curl_close($ch);
}

function parseTable($table,$tableName) {
    global $return;
            $tableColumns = Array();
            $tableColumnNum = 0;
            foreach ($table->find("th") as $th) {
                $tableColumns[$tableColumnNum] = cleanString($th->plaintext);
                $tableColumnNum++;
            }
            //print_r($tableColumns);
            $tableRowNum = 0;
            foreach ($table->find("tr") as $tr) {
                $tableColumnNum = 0;
                foreach ($tr->find("td") as $td) {
                    if ($tableName ==  "myway_carddetails") {
                        // first table has card/cardholder details
                        $return[$tableName][$tableColumns[$tableColumnNum]] = cleanString($td->plaintext);
                    } else {
                        // second table has transactions

                        if ($tableColumns[$tableColumnNum] == "TX Reference No / Type") {
                            $return[$tableName][$tableRowNum]["TX Reference No"] = substr(cleanString($td->plaintext), 0, 6);
                            $return[$tableName][$tableRowNum]["TX Type"] = substr(cleanString($td->plaintext), 7);
                        } else {
                            $return[$tableName][$tableRowNum][$tableColumns[$tableColumnNum]] = cleanString($td->plaintext);
                        }
                    }
                    //print_r($return);
                    $tableColumnNum++;
                }
                $tableRowNum++;
            }
}

if (!isset($return['error'])) {
    include_once ('../lib/simple_html_dom.php');
    //print_r($pageHTML);
    $page = str_get_html($pageHTML);
    $pageAlerts = $page->find(".smartCardAlert");
    if (sizeof($pageAlerts) > 0) {
        $return['error'][] = $pageAlerts[0]->plaintext;
    }
    if (!isset($return['error'])) {
        $tables = $page->find(".type3");
            parseTable($tables[0], "myway_carddetails");
      
        $tables = $page->find(".type2");
            parseTable($tables[0], "myway_transactions");
        
    }
}
if (sizeof($return) == 0) {
    $return['error'][] = "No data extracted from MyWay website - API may be out of date";
}
if (basename(__FILE__) == "myway_api.json.php") {
    header('Content-Type: text/javascript; charset=utf8');
// header('Access-Control-Allow-Origin: http://bus.lambdacomplex.org/');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    if (isset($_GET['callback'])) {
        $json = '(' . json_encode($return) . ');'; //must wrap in parens and end with semicolon
        print_r($_GET['callback'] . $json); //callback is prepended for json-p
    }
    else
        echo json_encode($return);
}
?>
