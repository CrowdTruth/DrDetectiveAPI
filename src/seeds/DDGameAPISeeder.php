<?php
namespace CrowdTruth\DDGameapi;

use \SoftwareComponent as SoftwareComponent;
use \Template as Template;

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
			"js" => "",
			"version" => 0,
			"type" => "Cell Tagging Template",
			"game_type" => "CellEx",
			"tag" => "Cell Seeker",
			"instructions" => "test",
				//.'<p>You are given 3 microscopic images of one or more human cells. You will be identifying the cells in the images. Don\'t worry, it\'s easier than you think. Take a look at these examples. <button id="openExamplesButton" class="openExamples" style="margin-top: 50px; margin-bottom:50px;">Show detailed instructions</button></p>'
				//.'',
			"examples" => "test2",
				/*.'<div style="background-color:#6495ed; padding: 0px 20px 10px 20px;">'
				.'<div style="font-size: 20pt; color:#000;">Examples:</div>'
				.'</p>'
				.'<div style="background-color:#FFF; border:1px solid #000; padding:10px;">'
				.'<div style="border:1px solid #000;"><font color="#DC18DA"><b>Purple dots</b></font> show correctly counted cells. <font color="#3C5825"><b>Count & annotate a cell only when at least half of it is visible. </b></font><br>
						<font color="#DC18DA"><b>Mark</b></font> each cell as close to its center as possible. <br>
						(When you cannot see the complete cell, mark where you <i>think</i> the center would be.)<br> 
						<br>
						<font color="#0906C5"><b>Example A</b></font>. You see <font color="#3C5825"><b>1 complete cell, 1 nearly complete cell</b></font>, and 1 small bit of a cell => <font color="#DC18DA"><b>2 purple dot</b></font> markings. <br>
						<font color="#0906C5"><b>Example B</b></font>. You see <font color="#3C5825"><b>2 complete cells</b></font>, more then half of <font color="#3C5825"><b>1 cell</b></font>, and a little bit of 2 other cells => <font color="#DC18DA"><b>3 purple dot</b></font> markings. <br>
						<br>
						The <font color="#0906C5">dotted blue line</font> shows the imaginary outline of the cell beyond the border of the image.</div>'
				.'<img width="100%" src="img/CellTagging_Green.png">'
				.'</div>'
				.'</div>'
				.'',*/
			"steps" => "test3",
				/*.'<div style="font-size: 20pt; color:#000;">Cell identification steps</div>'
				.'<p>Step 1: Click near the center of al visible cells or drag the mouse to draw a box around the cells. Keep a mental count while you are tagging. </p>'
				.'<p>Step 2: Choose the option from the given list which best describes your cell markings. </p>'
				.'<p>Step 3: Report the number of cells you have counted in the designated field. </p>'
				.'<p>Step 4: Click the button which best describes the given image quality. </p>'
				.'<br>'
				.'Detailed explanation for Step 1: '
				.'<div>'
				.'<div class="col span_2_of_8"><img src="img/annotationMenu.png"></div>'
				.'<div class="col span_6_of_8"><ul style="-webkit-margin-before: 0em;-webkit-margin-after: 0em;">'
				.'<li>This menu is located to the left of (or above) your task images. </li>'
				.'<li>The "Drawn" table keeps track of your markings. (mouse clicks or drags)</li>'
				.'<li>To remove the last cell marking, click the <img src=img/removeLastButton.png> button.</li>'
				.'This removes the markings in the reversed order in which they were made (last mark will be deleted first). '
				.'<li>To undo a <i>specific</i> annotation click the <b>x</b> next to the faulty mark in the "Drawn" table which you want to remove. </li>'
				.'<li>Once you are happy with the result, click the "Next question" button. </li>'
				.'</ul></div>'
				.'</div>'
				.'',*/
			"extraInfo" => [
				"label" => "Mark each cell by clicking it or drawing a shape around it",
				"label1" => "I have annotated all cells",
				"label2" => "There were too many cells to annotate",
				"label3" => "No cell visible",
				"label4" => "Other",
				"label5" => "Enter the total number of cells here:",
				"step1" => "Click near the center of al visible cells or drag the mouse to draw a box around the cells. Keep a mental count while you are tagging. ",
				"step2" => "Choose the option from the given list which best describes your cell markings. ",
				"step3" => "Report the number of cells you have counted in the designated field. ",
				"step4" => "Click the button which best describes the given image quality. ",
			],
			"platform" => "DrDetectiveGamingPlatform",
			"user_id" => "carlosm",
			"instructions" => "",
			"level" => 1,
			"score" => 10
		] );
		
		$this->createTemplate ( [ 
			"_id" => "template/drdetective/2",
			"cml" => "{{url}}",
			"format" => "text",
			"css" => "",
			"js" => "",
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
			"instructions" => "",
			"level" => 1,
			"score" => 10
		]);
		
		$this->createTemplate([
			"_id" => "template/drdetective/3",
			"cml" => "{{url}}",
			"format" => "text",
			"css" => "",
			"js" => "",
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
			"instructions" => "",
			"level" => 2,
			"score" => 10
		]);
		
		$this->createTemplate([
			"_id" => "template/drdetective/4",
			"cml" => "{{url}}",
			"format" => "text",
			"css" => "",
			"js" => "",
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
			"instructions" => "",
			"level" => 2,
			"score" => 10
		]);
	}
	
	/**
	 * Create seed templates.
	 * 
	 * @param $templateArray
	 */
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
