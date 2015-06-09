<?php
namespace CrowdTruth\DDGameapi;

use \MongoDB\SoftwareComponent as SoftwareComponent;
use \MongoDB\Template as Template;

/**
 * Create required objects in database, if they do not exist already.
 * 
 * Run:
 * 
 *   php artisan db:seed --class="CrowdTruth\DDGameapi\DDGameAPISeeder"
 * 
 * @author carlosm
 */
class DDGameAPISeeder extends \Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\Eloquent::unguard();
		
		$this->command->info('Initialize software component');
		
		$name = 'drdetectiveapi';
		$label = 'Component for communication with Dr. Detective game.';
		
		$sc = SoftwareComponent::find($name);
		if( is_null($sc) ) {
			// Initialize SoftwareComponent
			$component = new SoftwareComponent($name, $label);	// Create generic component
			$component->save();		// And save the component
		} else {
			$this->command->info('Software components already exists');
		}
		
		// TODO: Hard coded templates -- these should be created via template creator ?
		$this->createTemplate([
			"_id" => "template/drdetective/1",
			"cml" => "{{url}}",
			"format" => "text",
			"css" => "",
			"version" => 0,
			"type" => "Cell Tagging Template",
			"game_type" => "CellEx",
			"extraInfo" => [
				"label" => "Mark each cell by clicking it or drawing a shape around it",
				"label1" => "I have annotated all cells",
				"label2" => "There were too many cells to annotate",
				"label3" => "No cell visible",
				"label4" => "Other",
				"label5" => "Enter the total number of cells here:",
				"label6" => "Good",
				"label7" => "Medium",
				"label8" => "Poor",
				"label9" => "Blank (Black) Image",
				"label10" => "No Image"
			],
			"platform" => "DrDetectiveGamingPlatform",
			"user_id" => "carlosm",
		]);
		
		$this->createTemplate([
				"_id" => "template/drdetective/2",
				"cml" => "{{url}}",
				"format" => "text",
				"css" => "",
				"version" => 0,
				"type" => "Nucleus tagging Template",
				"game_type" => "CellEx",
				"extraInfo" => [
					"label" => "Mark each nucleus by clicking it or drawing a shape around it",
					"label1" => "I have annotated all nuclei ",
					"label2" => "There were too many nuclei to annotate",
					"label3" => "No nuclei visible",
					"label4" => "Other",
					"label5" => "Enter the total number of nuclei here:",
					"label6" => "Good",
					"label7" => "Medium",
					"label8" => "Poor",
					"label9" => "Blank (Black) Image",
					"label10" => "No Image"
				],
				"platform" => "DrDetectiveGamingPlatform",
				"user_id" => "carlosm",
		]);
		
		$this->createTemplate([
				"_id" => "template/drdetective/3",
				"cml" => "{{url}}",
				"format" => "text",
				"css" => "",
				"version" => 0,
				"type" => "Colony tagging Template",
				"game_type" => "CellEx",
				"extraInfo" => [
					"label" => "Mark each colony by clicking it or drawing a shape around it",
					"label1" => "I have annotated all colonies ",
					"label2" => "There were too many colonies to annotate",
					"label3" => "No colonies visible",
					"label4" => "Other",
					"label5" => "Enter the total number of colonies here:"
				],
				"platform" => "DrDetectiveGamingPlatform",
				"user_id" => "carlosm",
		]);
		
		$this->createTemplate([
				"_id" => "template/drdetective/4",
				"cml" => "{{url}}",
				"format" => "text",
				"css" => "",
				"version" => 0,
				"type" => "Vesicle locating Template",
				"game_type" => "VesEx",
				"extraInfo" => [
					"label" => "There are no vesicles in this image",
					"label1" => "The vesicles are equally distributed",
					"label2" => "The vesicles are near the tip",
					"label3" => "The vesicles are near the nucleus"
				],
				"platform" => "DrDetectiveGamingPlatform",
				"user_id" => "carlosm",
		]);
	}
	
	private function createTemplate($templateArray) {
		$template = Template::find($templateArray['_id']);
		if( is_null($template) ) {
			$this->command->info('Creating template: '.$templateArray['_id']);
			$t = new Template;
			
			foreach ($templateArray as $key => $value) {
				$t->$key = $value;
			}
			
			$t->save();
		} else {
			$this->command->info('Template already exists: '.$templateArray['_id']);
		}
	}
}
