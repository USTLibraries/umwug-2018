<?php
// api returning json data

require_once __DIR__."/custom/inc.php"; // this is required to be placed at start of execution - it loads the config, app vars, core app functions, and init

function generateResponse() {

	$default = array();
	$default = [ "hello world" ];

	$data = array();

	/* For example, when a person enters yourdomain.com/thisapi/?code=xkt then all the items under
		the xkt field will be returned. You can make up your own codes to correspond with the data
	*/
	// enter your own arrays here

	$data["bao"] = ["banana", "apples", "oranges"];

	$data["cbl"][] = array( "name" => "Charlie Brown","id" => "1005783","fines" => 38.93);
	$data["cbl"][] = array(	"name" => "Linus van Pelt","id" => "1004378","fines" => 0,"loans" => [array("title" => "Bible (KJV)", "due"=> "20181226"),array("title" => "Public Speaking","due"=>"20181226")]);

	$data["lvp"] = array(	"name" => "Linus van Pelt","id" => "1004378","fines" => 0,"loans" => [array("title" => "Bible (KJV)", "due"=> "20181226"),array("title" => "Public Speaking","due"=>"20181226")]);

	$data["cpe"] = array("gamechoices"=>["Falken's Maze","Black Jack","Gin Rummy","Hearts","Bridge","Checkers","Chess","Poker","Fighter Combat","Guerrilla Engagement","Desert Warfare","Air-To-Ground Actions","Theaterwide Tactical Warfare","Theaterwide Biotoxic and Chemical Warfare","Global Thermonuclear War"],"hiddengames"=>["Tic-Tac-Toe"]);

	$data["dev"][] = "https://developers.exlibrisgroup.com";

	$data["doc"][] = "https://developers.exlibrisgroup.com/alma/apis/users";


	$data["lhf"][] = "https://api-na.hosted.exlibrisgroup.com/almaws/v1/users/{{user_id}}/loans?user_id_type=all_unique&limit=10&offset=0&order_by=due_date&format=json&direction=ASC&apikey={{apikey}}";
	$data["lhf"][] = "https://api-na.hosted.exlibrisgroup.com/almaws/v1/users/{{user_id}}/requests?request_type=HOLD&user_id_type=all_unique&limit=10&offset=0&status=active&format=json&apikey={{apikey}}";
	$data["lhf"][] = "https://api-na.hosted.exlibrisgroup.com/almaws/v1/users/{{user_id}}/fees?user_id_type=all_unique&status=ACTIVE&format=json&apikey={{apikey}}";

	$data["git"][] = "https://github.com/ustlibraries";
	$data["git"][] = "https://github.com/chadkluck";
	$data["git"][] = "https://github.com/ustlibraries/exlibris-api-example";
	$data["git"][] = "https://github.com/ustlibraries/umwug-2018";
	$data["git"][] = "https://github.com/chadkluck/php-project-framework";
	$data["git"][] = "https://github.com/chadkluck/js-template";
	

	// stop entering codes here

	$code = strtolower(getParameter("code"));

	$json = array();
	$json = ($code && isset($data[$code]) ) ? $data[$code] : $default;

	return $json;
}

/* **********************************************
 *  START
 */

// begin JSON output

if(isApprovedOrigin()) {

	$json = generateResponse();

	if(!debugOn()) {

		httpReturnHeader(getCacheExpire("api"), getRequestOrigin(), "application/json");
		echo json_encode($json);

	} else {
		echo "<h3>JSON RAW</h3>";
		echo "<p>";
		echo json_encode($json);
		echo "</p>";
		echo "<h3>JSON FORMATTED</h3>";
		echo "<pre>";
		print_r($json);
		echo "</pre>";
		appExecutionEnd();
	}

} else {
	echo (getRequestOrigin()." not an allowed origin");
}

?>