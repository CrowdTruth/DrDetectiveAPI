<?php
namespace CrowdTruth\DDGameapi;

use \Entities\WorkerUnit as WorkerUnit;
use \Entities\Job as Job;
use \Activity as Activity;
use \SoftwareComponent as SoftwareComponent;
use \MongoDate as MongoDate;
use \CrowdAgent as CrowdAgent;


/**
 * Software component for storing in the database jugdements generated by 
 * Dr. Detective Game and which are sent to CrowdTruth via the communication API.
 * 
 * @author carlosm
 */
class DDGameAPIComponent {
	protected $softwareComponent;
	
	/**
	 * Create a DDGameAPIComponent instance.
	 */
	public function __construct() {
		$this->softwareComponent = SoftwareComponent::find('drdetectiveapi');
	}
	
	/**
	 * Store to the database a list of game Judgments.
	 * 
	 * @param $entities List of judgments to be inserted. 
	 * 
	 * @return multitype:string A status array containing the result status information.
	 */
	public function store($entities) {
		$nEnts = count($entities);
		
		$activity = new Activity();
		$activity->softwareAgent_id = $this->softwareComponent->_id;
		$activity->save();
		
		// TODO: questions: with which doctype?
		$docType = 'gamejudgment';
		$seqName = 'entity/gamejudgment';
		
		// The '&' in '&$entity' means we modify the array directly
		foreach ($entities as $key => &$entity) {



			$agent = CrowdAgent::where('_id', "crowdagent/biocrowd/" . $entity['user_id'])->first();
			if($agent) {
				error_log(print_r($this));
				// do not delete this on rollback
				if(!array_key_exists($agent->_id, $this->crowdAgents)) {
					$agent->_existing = true;
				}
			} else {
				$agent = new CrowdAgent;
				$agent->_id= "crowdagent/biocrowd/" . $entity['user_id'];
				$agent->softwareAgent_id= 'biocrowd';
				$agent->platformAgentId = $entity['user_id'];
				$agent->save();
			}


			$workerunit = \Entities\Workerunit::where('platformWorkerUnitId', $entity['judgment_id'])->first();
			if($workerunit) {
				// do not delete this on rollback
				if(!array_key_exists($workerunit->_id, $this->workerUnits)) {
					$workerunit->_existing = true;
					$this->workerUnits[$workerunit->_id] = $workerunit;
				}
			} else {
				$workerunit = new Workerunit;
				$workerunit->activity_id = $activity->_id;
				//$workerunit->unit_id = $unitId;
				//$workerunit->acceptTime = $acceptTime;
				//$workerunit->cfChannel = $channel;
				//$workerunit->cfTrust = $trust;
				$workerunit->content = [
					'task_data' => $entity['task_data'],
					'response'  => $entity['response']
				];
				$workerunit->crowdAgent_id = $agentId;
				$workerunit->platformWorkerunitId = $annId;
				$workerunit->submitTime = $submitTime;
				$workerunit->documentType = 'gamejudgment';
				$workerunit->softwareAgent_id = 'biocrowd';

				// Maybe job should be cached if same game_id as previous loop ?
				// TODO: validate empty jobs (although shouldn't happen)
				$job = Job::where('platformJobId', intval($entity['game_id']))
				->where('softwareAgent_id', 'DrDetectiveGamingPlatform')->get()->first();
				$workerunit->job_id = $job->_id;
				$workerunit->project = $job->project;

				\Queue::push('Queues\SaveWorkerunit', array('workerunit' => serialize($workerunit)));		
				
			}
		}
		
		return [
			'status' => 'ok',
			'nEntities' => count($entities)
		];
	}
}
