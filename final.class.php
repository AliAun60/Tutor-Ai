<?php 
class final_rest
{


	/**
	 * @api  /api/v1/setTemp/
	 * @apiName setTemp
	 * @apiDescription Add remote temperature measurement
	 *
	 * @apiParam {string} location
	 * @apiParam {String} sensor
	 * @apiParam {double} value
	 *
	 * @apiSuccess {Integer} status
	 * @apiSuccess {string} message
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":0,
	 *              "message": ""
	 *     }
	 *
	 * @apiError Invalid data types
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":1,
	 *              "message":"Error Message"
	 *     }
	 *
	*/
	public static function setTemp ($location, $sensor, $value){
		if (!is_numeric($value)) {
			$retData["status"]=1;
			$retData["message"]="'$value' is not numeric";
		}
		else {
			try {
				EXEC_SQL("insert into temperature (location, sensor, value, date) values (?,?,?,CURRENT_TIMESTAMP)",$location, $sensor, $value);
				$retData["status"]=0;
				$retData["message"]="insert of '$value' for location: '$location' and sensor '$sensor' accepted";
			}
			catch  (Exception $e) {
				$retData["status"]=1;
				$retData["message"]=$e->getMessage();
			}
		}

		return json_encode ($retData);
	}

	/**
	 * @api  /api/v1/getLevel/
	 * @apiName getLevel
	 * @apiDescription Return all level data from database
	 *
	 * @apiSuccess {Integer} status
	 * @apiSuccess {string} message
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 
	 *              "result": [
	 *                { 
	 *                  levelid: 1,
	 *                  description: "",
	 *                  prompt: "",
	 * 					sortCode: 1
	 *              ]
	 *              "status":0,
	 *              "message": ""
	 *     }
	 *
	 * @apiError Invalid data types
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":1,
	 *              "message":"Error Message"
	 *     }
	 *
	*/
	public static function getLevel () {
		try {
            $retData["result"]=GET_SQL("select * from level order by sortCode");
            $retData["status"]=0;
            $retData["message"]="accepted";
        } catch  (Exception $e) {
            $retData["status"]=1;
            $retData["message"]=$e->getMessage();
        }
		return json_encode ($retData);
    }

	/**
	 * @api /api/v1/addLog
	 * @apiName getLevelDes
	 * @apiDescription Retrieves the experience levels
	 * 
	 * @apiSuccess {Integer} status
	 * @apiSuccess {string} message
	 * 
	 * @apiSuccessExample Success-Response:
	 * 		HTTP/1.1 200 OK
	 * 		{
	 * 				"result": [
	 * 					{
	 * 						description: ""
	 * 					}
	 * 				]
	 * 				"status": 0;
	 * 				"message": "accepted"
	 * 		}
	 * 
	 * @apiError Invalid data types
	 * 
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":1,
	 *              "message":"Error Message"
	 *     }
	*/
	public static function getLevelDes() {
		try {
			$retData["result"]=GET_SQL("SELECT description FROM level");
			$retData["status"] = 0;
			$retData["message"] = "accepted";
		} catch (Exception $e) {
			$retData["status"]=1;
			$retData["message"]=$e->getMessage();
		}
		return json_encode($retData);
	}

	/**
	 * @api  /api/v1/addLog/
	 * @apiName addLog
	 * @apiDescription Add record to logfile
	 *
	 * @apiParam {string} level
	 * @apiParam {String} systemPrompt
	 * @apiParam {String} userPrompt
	 * @apiParam {string} chatResponse
	 * @apiParam {Integer} inputTokens
	 * @apiParam {Integer} outputTokens
	 *
	 * @apiSuccess {Integer} status
	 * @apiSuccess {string} message
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":0,
	 *              "message": ""
	 *     }
	 *
	 * @apiError Invalid data types
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":1,
	 *              "message":"Error Message"
	 *     }
	 *
	*/

	public static function addLog ($inputdata, $outputdata) {
        try {
            EXEC_SQL("insert into log (input, output) values (?,?)",$inputdata, $outputdata);
            $retData["status"]=0;
            $retData["message"]="accepted";
        } catch  (Exception $e) {
            $retData["status"]=1;
            $retData["message"]=$e->getMessage();
        }
        return json_encode ($retData);
  	}	

	/**
	 * @api  /api/v1/getLog/
	 * @apiName getLog
	 * @apiDescription Retrieve Log Records
	 *
	 * @apiParam {string} date
	 * @apiParam {String} numRecords
	 *
	 * @apiSuccess {Integer} status
	 * @apiSuccess {string} message
	 *
	 * @apiSuccessExample Success-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "result": [
	 *                { 
	 *                  logid: "",
	 *                  input: "",
	 *                  output: "",
	 *                  datetime: "YYYY-MM-DD HH:MM:SS",
	 * 				  }
	 *              ],
	 *              "status":0,
	 *              "message": "Accepted"
	 *     }
	 *
	 * @apiError Invalid data types
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":1,
	 *              "message":"Error Message"
	 *     }
	*/

	public static function getLog ($date, $numrecords) {
		try {
			$retData["result"]=GET_SQL("SELECT * FROM log WHERE DATE(dateTime)=? LIMIT ?", $date, $numrecords);
			$retData["status"] = 0;
			$retData["message"] = "Accepted";
		} catch (Exception $e) {
			$retData["status"] = 1;
			$retData["message"]=$e->getMessage();
		}
		return json_encode ($retData);
	}

	/**
	 * @api api/v1/getDates 
	 * @apiName getDates
	 * @apiDescription Retrieve log dates
	 * 
	 * @apiSuccess {Integer} status
	 * @apiSuccess {string} message
	 * 
	 * @apiSuccessExample Success-Response:
	 * 		HTTP/1.1 200 OK
	 * 		{
	 * 				"result":[
	 * 				  {
	 * 					datetim: "YYY-MM-DD HH:MM:SS"
	 * 				  }
	 * 				],
	 * 				"status":0,
	 * 				"message": "Accepted"
	 * 		}
	 * @apiError Invalid data types
	 *
	 * @apiErrorExample Error-Response:
	 *     HTTP/1.1 200 OK
	 *     {
	 *              "status":1,
	 *              "message":"Error Message"
	 *     }
	 *
	*/

	public static function getDates() {
		try {
			$retData["result"]=GET_SQL("SELECT datetime FROM log");
			$retData["status"] = 0;
			$retData["message"] = "Accepted";
		} catch (Exception $e) {
			$retData["status"] = 1;
			$retData["message"] = $e->getMessage();
		}
		return json_encode ($retData);
	}

    /**
 * @api  /api/v1/chat
 * @apiName chat
 * @apiDescription Process user input, fetch AI response, and return result
 *
 * @apiParam {string} level User experience level (beginner, intermediate, advanced)
 * @apiParam {string} question User's input question
 *
 * @apiSuccess {string} answer AI response
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *         "answer": "This is a response from the AI system."
 *     }
 *
 * @apiError InvalidRequest Error processing the request
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 400 Bad Request
 *     {
 *         "error": "Invalid input provided."
 *     }
 */
    public static function chatGPTInteraction($description, $question) {
    try {
        // Validate inputs
        if (empty($description) || empty($question)) {
            throw new Exception("Both description and question must be provided.");
        }

        // Step 1: Fetch the prompt from the `level` table based on the provided description
        $levelData = GET_SQL("SELECT prompt FROM level WHERE description = ?", $description);
        if (empty($levelData) || !isset($levelData[0]['prompt'])) {
            throw new Exception("No matching prompt found for the given description.");
        }

        $prompt = $levelData[0]['prompt'];

        // Step 2: Combine the prompt with the user's question
        $chatInput = $prompt . " " . $question;

        // Step 3: Send the combined input to the ChatGPT API
        $chatGPTResponse = self::callChatGPTAPI($chatInput);

        if ($chatGPTResponse['status'] !== 0) {
            throw new Exception("Error interacting with ChatGPT: " . $chatGPTResponse['message']);
        }

        $chatResponse = $chatGPTResponse['response'];

        // Step 4: Log the user's question and ChatGPT's response in the `log` table
        $logResponse = self::addLog($question, $chatResponse);

        if (json_decode($logResponse, true)['status'] !== 0) {
            throw new Exception("Failed to log interaction: " . json_decode($logResponse, true)['message']);
        }

        // Step 5: Return the ChatGPT response to the user
        $retData['output'] = $chatResponse;
        $retData['status'] = 0;
        $retData['message'] = "Interaction successfully logged and response retrieved.";
    } catch (Exception $e) {
        $retData['status'] = 1;
        $retData['message'] = $e->getMessage();
    }

    return json_encode($retData);
    }


    private static function callChatGPTAPI($input) {
        try {
            // Replace with actual ChatGPT API call
            $apiResponse = [
                "status" => 0,
                "response" => "This is a mock response for the input: '$input'."
            ];

            return $apiResponse;
        } catch (Exception $e) {
            return [
                "status" => 1,
                "message" => $e->getMessage()
            ];
        }
    }

    public static function chatWithAI($description, $question) {
        return self::chatGPTInteraction($description, $question);
    }


    public static function testMethod() {
        return json_encode(["status" => 0, "message" => "Test method executed successfully."]);
    }
}