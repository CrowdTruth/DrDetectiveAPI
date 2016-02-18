<?php
namespace CrowdTruth\DDGameapi;

use \Template as Template;

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
	}
	
	public function createView() {
		return "DrDetective - make view";
	}
	
	public function updateJobConf($jc) {
		return "JC";
	}
	
	/**
	 *
	 * @return
	 */
	public function publishJob($job, $sandbox) {
		// TODO: make API URL configurable
		$client = new \GuzzleHttp\Client();
		$apiURL = \Config::get('ddgameapi::URL');
		
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
			'level' => $template->level,
			'name' => $job->jobConfiguration->content['title'],
			'instructions' => $job->jobConfiguration->content['description'],
			'extraInfo' => $template->extraInfo,
			'score' => $template->score,
			'taskData' => $taskData
		];
		
		// TODO: must be a better way to convert response to array ?
		$resRaw = $client->post($apiURL, ['form_params' => $formData]);
		$resBody = $resRaw->getBody()->__toString();
		$res = json_decode($resBody);
		
		// TODO: add game_id for this job_id
		if($res->status=='success') {
			$job->platformJobId = $res->id;
			$job->save();
			
			return [
				'id'	=> $res->id
			];
		} else {
			throw new \Exception ('API response:'.$res->message);
		}
	}
	
	public function undoCreation($id) {
		//dd('DrDetective - undoCreation');
	}
	
	public function refreshJob($id) {
		// dd('DrDetective - refreshJob');
		// TODO: to be implemented ?
	}
	
	public function batchToCSV($batch, $questionTemplate, $extraInfoBatch, $path = null) {
		dd('DrDetective - batchtocsv');
	}
	
	public function orderJob($job) {
		dd('DrDetective - orderJob');
	}
	
	public function pauseJob($id) {
		dd('DrDetective - pauseJob');
	}
	
	public function resumeJob($id) {
		dd('DrDetective - resumeJob');
	}
	
	public function cancelJob($id) {
		dd('DrDetective - cancelJob');
	}
	
	public function deleteJob($id) {
		dd('DrDetective - deleteJob');
	}
	
	public function blockWorker($id, $message) {
		dd('DrDetective - blockWorker');
	}
	
	public function unblockWorker($id, $message) {
		dd('DrDetective - unblockWorker');
	}
	
	public function sendMessage($subject, $body, $workerids) {
		dd('DrDetective - sendMessage');
	}
}
