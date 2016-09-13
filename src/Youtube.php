<?php

require_once '../vendor/autoload.php';

class Youtube {
	const OAUTH2_CLIENT_ID = 'YOUR OAUTH2 CLIENT ID';
	const OAUTH2_CLIENT_SECRET = 'YOUR OAUTH2 CLIENT SECRET';
	private $client;
	private $youtube;

	public function __construct(){
		$this->client = new Google_Client();
		$this->client->setClientId(self::OAUTH2_CLIENT_ID);
		$this->client->setClientSecret(self::OAUTH2_CLIENT_SECRET);

		$this->client->setScopes('https://www.googleapis.com/auth/youtube.force-ssl');
		$redirect = 'REPLACE WITH PATH OF YOUR WEBPAGE';
		$this->client->setRedirectUri($redirect);

		// Object used to make API requests.
		$this->youtube = new Google_Service_YouTube($this->client);
	}	

	// get auth URL from client
	// the return value of this URL will contain 'code' used to authenticate
	public function getAuthUrl() {
		return $this->client->createAuthUrl();
	}

	// authenticate using 'code'
	public function authenticate() {
		if (isset($_GET['code'])) {
			$this->client->authenticate($_GET['code']);
			$_SESSION['token'] = $this->client->getAccessToken();
			$this->setAccessToken($_SESSION['token']);

			return true;
		}
		return false;
	}

	public function setAccessToken($token) {
		$this->client->setAccessToken($token);
	}
}

?>