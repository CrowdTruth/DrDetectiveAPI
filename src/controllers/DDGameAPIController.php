<?php
namespace CrowdTruth\DDGameapi;

use \Input as Input;

/**
 * This controller provides the functionality for the Dr. Detective Game API.
 * 
 * @author carlosm
 */
class DDGameAPIController extends \Controller {
	protected $swcomponent;
	
	public function __construct(DDGameAPIComponent $swcomponent) {
		$this->swcomponent = $swcomponent;
	}
	
	/**
	 * Process requests sent to the API webhook.
	 * 
	 * Requests should contain the following parameters:
	 * 
	 *   signal      Signal to be processed. 'new_judgments' for new judgments
	 *   payload     a JSON structure with the judgments
	 *   signature   SHA1(payload + API_KEY)  
	 * 
	 * API is loosely based on CrowdFlower API:
	 *   https://success.crowdflower.com/hc/en-us/articles/201856249-CrowdFlower-API-Webhooks
	 */
	public function anyIndex() {
		$signal = Input::get('signal');
		$payload = Input::get('payload');
		$signature = Input::get('signature');
		
		if($signal=='new_judgments') {
			// Signature should be SHA1 of payload
			$signCheck = sha1(print_r($payload, true));
			if($signCheck!=$signature) {
				return $this->buildResponse($signal, 'error', 'Signature does not match');
			}
			
			$resp = $this->swcomponent->store($payload);
			if($resp['status']=='ok') {
				return $this->buildResponse($signal, 'ok', strval($resp['nEntities']).' processed');
			} else {
				return $this->buildResponse($signal, 'error', $resp['message']);
			}
			
		} else {
			return $this->buildResponse($signal, 'error', 'Unknown signal');
		}
	}
	
	/**
	 * Build response sent back to the webhook caller.
	 * 
	 * @param $signal received.
	 * @param $status status of the request
	 * @param $message response message
	 * @return Array-formatted response to be sent back.
	 */
	private function buildResponse($signal, $status, $message) {
		return [
			'signal' => $signal,
			'status' => $status,
			'message' => $message,
		];
	}
}
