<?php
namespace CrowdTruth\DDGameapi;

use \MongoDB\Template as Template;

// SEE CrowdTruth\Crowdflower\crowdflower2.php for more info
class DrDetectiveJobController extends \FrameWork {
	// protected $CFJob = null;
	public function getLabel() {
		return "Serious gaming platform: DrDetectiveGame";
	}
	
	public function getName() {
		return "DrDetective";
	}
	
	public function getExtension() {
		return '';
	}
	
	public function getJobConfValidationRules() {
		return [];
	}
	
	public function __construct() {
		// $this->CFJob = new Job ( Config::get ( 'crowdflower::apikey' ) );
	}
	
	public function createView() {
		// Validate settings
		/*if (Config::get ( 'crowdflower::apikey' ) == '')
			Session::flash ( 'flashError', 'API key not set. Please check the manual.' );
		return View::make ( 'crowdflower::create' );*/
		return "DrDetective - make view";
	}
	
	public function updateJobConf($jc) {
		/*if (Input::has ( 'workerunitsPerWorker' )) { // Check if we really come from the CF page (should be the case)
			$c = $jc->content;
			$c ['countries'] = Input::get ( 'countries', array () );
			$jc->content = $c;
		}
		return $jc;*/
		return "JC";
	}
	
	/**
	 *
	 * @return
	 *
	 */
	public function publishJob($job, $sandbox) {
		$client = new \GuzzleHttp\Client();
		$apiURL = 'http://localhost:8080/admin-games/api';
		
		$template = Template::where('_id', '=', $job->jobConfiguration->content['template_id'])->first();
		
		$batchAssoc = [];
		// ['associationsTemplBatch'] is an array of strings in format: "column - alias"
		foreach ($job->extraInfoBatch['associationsTemplBatch'] as $assoc) {
			$assoc = explode(' - ', $assoc);
			$column = $assoc[0];
			$alias = $assoc[1];
			$batchAssoc[$column] = $alias;
		}
		
		// TaskData is the data from the batch sent to the job.
		// Each column of the batch items (parents) is sent with a given alias
		$taskData = [];
		foreach($job->batch->wasDerivedFrom as $parent) {	// Iterate through batch items
			$taskI = [];
			foreach($batchAssoc as $column => $alias) {
				$taskI[$alias] = $parent['content'][$column];
			}
			$taskData[] = $taskI;
		}
		
		$formData = [
			'action' => 'publish',
			'gameType' => $template->game_type,
			'level' => '1',
			'name' => $job->jobConfiguration->content['title'],
			'instructions' => $job->jobConfiguration->content['description'],
			'extraInfo' => $template->extraInfo,
			'taskData' => $taskData
		];
		
		// TODO: must be a better way to convert response to array ?
		$resRaw = $client->post($apiURL, ['form_params' => $formData]);
		$resBody = $resRaw->getBody()->__toString();
		$res = json_decode($resBody);
		
		if($res->status=='success') {
			return [
				'id'	=> $res->id
			];
		} else {
			throw new Exception ('API response:'.$res->message);
		}
	}
	
	/**
	 *
	 * @throws Exception
	 */
	public function undoCreation($id) {
		/*if (! isset ( $id ))
			return;
		try {
			$this->CFJob->cancelJob ( $id );
			$this->CFJob->deleteJob ( $id );
		} catch ( CFExceptions $e ) {
			throw new Exception ( $e->getMessage () ); // Let Job take care of this
		}*/
		dd('DrDetective - undoCreation');
	}
	
	public function refreshJob($id) {/*
		$job = \MongoDB\Entity::where ( '_id', $id )->first ();
		$batch = \MongoDB\Entity::where ( '_id', $job->batch_id )->first ();
		$jc = \MongoDB\Entity::where ( '_id', $job->jobConf_id )->first ();
		$result = $this->CFJob->readJob ( $job->platformJobId );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Read: " . $result ['result'] ['error'] ['message'] );
		$status = null;
		$this->CFDataToJobConf ( $result ['result'], $jc, $status );

		$jc->update ();

		$reward = $jc->content ['reward'];
		$workerunitsPerUnit = intval ( $jc->content ['workerunitsPerUnit'] );
		$unitsPerTask = intval ( $jc->content ['unitsPerTask'] );
		$unitsCount = count ( $batch->wasDerivedFrom );
		if (! $unitsPerTask)
			$projectedCost = 0;
		else
			$projectedCost = round ( ($reward / $unitsPerTask) * ($unitsCount * $workerunitsPerUnit), 2 );
		$job->expectedWorkerunitsCount = $unitsCount * $jc->content ['workerunitsPerUnit'];
		$job->projectedCost = $projectedCost;
		// }
		if (isset ( $status ))
			$job->status = $status;
		$job->update ();*/
		// dd('DrDetective - refreshJob');
		// TODO: to be implemented ?
	}
	
	/*
	private function CFDataToJobConf($CFd, &$jc, &$status) {
		$jcco = $jc->content;
		if (isset ( $CFd ['title'] )) {
			$pos = strpos ( $CFd ['title'], '[[' );
			if ($pos !== false && $pos > 0) {
				if (0 == strcmp ( substr ( $CFd ['title'], $pos ), '[[' . $jcco ['type'] ))
					$jcco ['title'] = $CFd ['title'] . substr ( $jcco ['title'], strpos ( $jcco ['title'], '(entity/' ) );
				else
					throw new Exception ( "Wrong type" );
			} else
				throw new Exception ( "Missing '[['" );
		}
		if (isset ( $CFd ['instructions'] ))
			$jcco ['instructions'] = $CFd ['instructions'];
		if (isset ( $CFd ['css'] ))
			$jcco ['css'] = $CFd ['css'];
		if (isset ( $CFd ['cml'] ))
			$jcco ['cml'] = $CFd ['cml'];
		if (isset ( $CFd ['js'] ))
			$jcco ['js'] = $CFd ['js'];
		if (isset ( $CFd ['state'] ))
			$status = $CFd ['state'];
		if (isset ( $CFd ['payment_cents'] ))
			$jcco ['reward'] = $CFd ['payment_cents'] / 100;
		if (isset ( $CFd ['minimum_requirements'] ))
			$jcco ['minimumRequirements'] = $CFd ['minimum_requirements'];
		if (isset ( $CFd ['options'] ['req_ttl_in_seconds'] ))
			$jcco ['expirationInMinutes'] = intval ( $CFd ['options'] ['req_ttl_in_seconds'] / 60 );
		if (isset ( $CFd ['options'] ['mail_to'] ))
			$jcco ['notificationEmail'] = $CFd ['options'] ['mail_to'];
		if (isset ( $CFd ['judgments_per_unit'] ))
			$jcco ['workerunitsPerUnit'] = $CFd ['judgments_per_unit'];
		if (isset ( $CFd ['units_per_assignment'] ))
			$jcco ['unitsPerTask'] = $CFd ['units_per_assignment'];
		if (isset ( $CFd ['max_judgments_per_worker'] ))
			$jcco ['workerunitsPerWorker'] = $CFd ['max_judgments_per_worker'];
		if (isset ( $CFd ['max_judgments_per_ip'] ))
			$jcco ['workerunitsPerWorker'] = $CFd ['max_judgments_per_ip'];
		// reward, keywords, expiration, workers_level,
		$jc->content = $jcco;
	}*/
	
	/*
	private function jobConfToCFData($jc) {
		$jc = $jc->content;
		$data = array ();

		if (isset ( $jc ['title'] ))
			$data ['title'] = substr ( $jc ['title'], 0, strpos ( $jc ['title'], '(entity/' ) );
		if (isset ( $jc ['css'] ))
			$data ['css'] = $jc ['css'];
		if (isset ( $jc ['cml'] ))
			$data ['cml'] = $jc ['cml'];
		if (isset ( $jc ['js'] ))
			$data ['js'] = $jc ['js'];
		if (isset ( $jc ['instructions'] ))
			$data ['instructions'] = $jc ['instructions'];
		if (isset ( $jc ['workerunitsPerUnit'] ))
			$data ['judgments_per_unit'] = $jc ['workerunitsPerUnit'];
		if (isset ( $jc ['unitsPerTask'] ))
			$data ['units_per_assignment'] = $jc ['unitsPerTask'];
		if (isset ( $jc ['workerunitsPerWorker'] )) {
			$data ['max_judgments_per_worker'] = $jc ['workerunitsPerWorker'];
			$data ['max_judgments_per_ip'] = $jc ['workerunitsPerWorker']; // We choose to keep this the same.
		}
		// Webhook doesn't work on localhost and the uri should be set.
		if ((! (strpos ( \Request::url (), 'localhost' ) > 0)) && (Config::get ( 'crowdflower::webhookuri' ) != '')) {
			$data ['webhook_uri'] = Config::get ( 'crowdflower::webhookuri' );
			$data ['send_judgments_webhook'] = 'true';
			\Log::debug ( "Webhook: {$data['webhook_uri']}" );
		} else {
			$data ['webhook_uri'] = Config::get ( 'crowdflower::webhookuri' );
			$data ['send_judgments_webhook'] = 'true';
			\Log::debug ( "Warning: no webhook set." );
		}
		return $data;
	}*/
	
	/**
	 *
	 * @return path to the csv, ready to be sent to the CrowdFlower API.
	 */
	public function batchToCSV($batch, $questionTemplate, $extraInfoBatch, $path = null) {
		dd('DrDetective - batchtocsv');
		/*
		// Create and open CSV file
		if (empty ( $path )) {
			$path = storage_path () . '/temp/crowdflower.csv';
			if (! file_exists ( storage_path () . '/temp' ))
				mkdir ( storage_path () . '/temp', 0777, true );
		}
		$out = fopen ( $path, 'w' );
		// Preprocess batch
		$array = array ();
		$units = $batch->wasDerivedFrom;

		foreach ( $units as $unit ) {
			unset ( $unit ['content'] ['properties'] );
			$c = array_change_key_case ( array_dot ( $unit ['content'] ), CASE_LOWER );
			foreach ( $c as $key => $val ) {
				$key = strtolower ( str_replace ( '.', '_', $key ) );
				if ($extraInfoBatch ["ownTemplate"] == true) {
					if (isset ( $extraInfoBatch ["batchColumnsNewTemplate"] [$key] ))
						$content [$extraInfoBatch ["batchColumnsNewTemplate"] [$key]] = $val;
				} else {
					foreach ( $extraInfoBatch ["associationsTemplBatch"] as $fieldColumn ) {
						$fieldColumnArray = explode ( " - ", $fieldColumn );
						if ($fieldColumnArray [1] == $key) {
							$content [$fieldColumnArray [0]] = $val;
						}
					}
					if ($extraInfoBatch ["batchColumnsExtraChosenTemplate"] != null)
						if (in_array ( $key, $extraInfoBatch ["batchColumnsExtraChosenTemplate"] ))
							$content [$key] = $val;
				}
			}
			$content ['uid'] = $unit ['_id'];
			$content ['_golden'] = 'false'; // TODO
			$array [] = $content;
		}
		// Headers and fields
		fputcsv ( $out, array_keys ( $array [0] ) );
		foreach ( $array as $row )
			fputcsv ( $out, $row );
			
		// Close file
		rewind ( $out );
		fclose ( $out );
		return $path;*/
	}
	
	public function orderJob($job) {
		dd('DrDetective - orderJob');
		/*$id = $job->platformJobId;
		$unitcount = count ( $job->batch->wasDerivedFrom );
		$this->hasStateOrFail ( $id, 'unordered' );
		$result = $this->CFJob->sendOrder ( $id, $unitcount, array (
				"cf_internal"
		) );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Order: " . $result ['result'] ['error'] ['message'] );
		*/
	}
	
	public function pauseJob($id) {
		dd('DrDetective - pauseJob');
		/*$result = $this->CFJob->pauseJob ( $id );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Pause: " . $result ['result'] ['error'] ['message'] );*/
	}
	
	public function resumeJob($id) {
		dd('DrDetective - resumeJob');
		/*
		$result = $this->CFJob->resumeJob ( $id );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Resume: " . $result ['result'] ['error'] ['message'] );
		*/
	}
	
	public function cancelJob($id) {
		dd('DrDetective - cancelJob');
		/*$result = $this->CFJob->cancelJob ( $id );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Cancel: " . $result ['result'] ['error'] ['message'] );*/
	}
	
	public function deleteJob($id) {
		dd('DrDetective - deleteJob');
		/*$result = $this->CFJob->deleteJob ( $id );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Delete: " . $result ['result'] ['error'] ['message'] );
		$job = \MongoDB\Entity::where ( 'platformJobId', $id )->first ();

		$jc = \MongoDB\Entity::where ( '_id', $job->jobConf_id )->first ();
		$ac = \MongoDB\Activity::where ( '_id', $job->activity_id )->first ();
		$job->forceDelete ();
		$jc->forceDelete ();
		$ac->forceDelete ();*/
	}
	
	public function deleteJobCT($id) {
		/*
		$job = \MongoDB\Entity::where ( 'platformJobId', $id )->first ();
		$jc = \MongoDB\Entity::where ( '_id', $job->jobConf_id )->first ();
		$ac = \MongoDB\Activity::where ( '_id', $job->activity_id )->first ();
		$job->forceDelete ();
		$jc->forceDelete ();
		$ac->forceDelete ();*/
	}
	
	public function deleteJobPL($id) {
		/*
		$result = $this->CFJob->deleteJob ( $id );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Delete: " . $result ['result'] ['error'] ['message'] );
			*/
	}
	
	/*private function hasStateOrFail($id, $state) {
		$result = $this->CFJob->readJob ( $id );
		if (isset ( $result ['result'] ['error'] ['message'] ))
			throw new Exception ( "Read Job: " . $result ['result'] ['error'] ['message'] );
		if ($result ['result'] ['state'] != $state)
			throw new Exception ( "Can't perform action; state is '{$result['result']['state']}' (should be '$state')" );
	}*/
	
	public function blockWorker($id, $message) {
		dd('DrDetective - blockWorker');
		/*$cfWorker = new Worker ( Config::get ( 'crowdflower::apikey' ) );
		try {
			$cfWorker->blockWorker ( $id, $message );
		} catch ( CFExceptions $e ) {
			throw new Exception ( $e->getMessage () );
		}*/
	}
	
	public function unblockWorker($id, $message) {
		dd('DrDetective - unblockWorker');
		/*$cfWorker = new Worker ( Config::get ( 'crowdflower::apikey' ) );
		try {
			$cfWorker->unblockWorker ( $id, $message );
		} catch ( CFExceptions $e ) {
			throw new Exception ( $e->getMessage () );
		}*/
	}
	
	public function sendMessage($subject, $body, $workerids) {
		dd('DrDetective - sendMessage');
		// throw new Exception ( 'Messaging is currently not possible with CrowdFlower, sorry!' );
	}
}
