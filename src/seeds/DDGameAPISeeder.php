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
			"instructions" => ""
				.'<p>You are given 3 microscopic images of one or more human cells. You will be identifying the cells in the images. Don\'t worry, it\'s easier than you think. Take a look at these examples. <button id="openExamplesButton" class="openExamples" style="margin-top: 50px; margin-bottom:50px;">Show detailed instructions</button></p>'
				.'',
			"examples" => ""
				.'<div style="background-color:#6495ed; padding: 0px 20px 10px 20px;">'
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
				.'',
			"steps" => ""
				.'<div style="font-size: 20pt; color:#000;">Cell identification steps</div>'
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
				.'',
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
			"tag" => "Nucly",
			"instructions" => ""
				.'<p>You are given 3 microscopic images of one or more human cells. You will be identifying the nuclei in the images. Don\'t worry, it\'s easier than you think. Take a look at these examples. <button id="openExamplesButton" class="openExamples" style="margin-top: 50px; margin-bottom:50px;">Show detailed instructions</button></p>'
				.'',
			"examples" => ""
				.'<div style="background-color:#6495ed; padding: 0px 20px 10px 20px;">'
				.'<div style="font-size: 20pt; color:#000;">Examples:</div>'
				.'</p>'
				.'<div style="background-color:#FFF; border:1px solid #000; padding:10px;">'
				.'<div style="border:1px solid #000;"><font color="#DC18DA"><b>Purple dots</b></font> show correctly counted nuclei. <font color="#3C5825"><b>Count & annotate nuclei only when at least half of them is visible. </b></font><br>
						<font color="#DC18DA"><b>Mark</b></font> each nucleus as close to its center as possible. <br>
						(When you cannot see the complete nucleus, mark where you <i>think</i> the center would be.)<br> 
						<br>
						<font color="#0906C5"><b>Example A</b></font>. You see <font color="#3C5825"><b>2 cells, 2 nuclei</b></font> => <font color="#DC18DA"><b>2 purple dot</b></font> markings. <br>
						<font color="#0906C5"><b>Example B</b></font>. You see <font color="#3C5825"><b>1 cell, 2 nuclei</b></font> => <font color="#DC18DA"><b>2 purple dot</b></font> markings. <br>
						<font color="#0906C5"><b>Example C</b></font>. You see <font color="#3C5825"><b>2 partially visible cells, 2 more then half visible nuclei</b></font> => <font color="#DC18DA"><b>2 purple dot</b></font> markings. <br>
						<br>
						The <font color="#0906C5">dotted blue line</font> shows the imaginary outline of the nucleus beyond the border of the image. </div>'
				.'<img width="100%" src="img/NucleusTagging_Green.png">'
				.'</div>'
				.'</div>'
				.'',
			"steps" => ""
				.'<div style="font-size: 20pt; color:#000;">Nuclei identification steps</div>'
				.'<p>Step 1: Click near the center of al visible nuclei or drag the mouse to draw a box around the nuclei. Keep a mental count while you are tagging. </p>'
				.'<p>Step 2: Choose the option from the given list which best describes your nuclei markings. </p>'
				.'<p>Step 3: Report the number of nuclei you have counted in the designated field. </p>'
				.'<p>Step 4: Click the button which best describes the given image quality. </p>'
				.'<br>'
				.'Detailed explanation for Step 1: '
				.'<div>'
				.'<div class="col span_2_of_8"><img src="img/annotationMenu.png"></div>'
				.'<div class="col span_6_of_8"><ul style="-webkit-margin-before: 0em;-webkit-margin-after: 0em;">'
				.'<li>This menu is located to the left of (or above) your task images. </li>'
				.'<li>The "Drawn" table keeps track of your markings. (mouse clicks or drags)</li>'
				.'<li>To remove the last nucleus marking, click the <img src=img/removeLastButton.png> button.</li>'
				.'This removes the markings in the reversed order in which they were made (last mark will be deleted first). '
				.'<li>To undo a <i>specific</i> annotation click the <b>x</b> next to the faulty mark in the "Drawn" table which you want to remove. </li>'
				.'<li>Once you are happy with the result, click the "Next question" button. </li>'
				.'</ul></div>'
				.'</div>'
				.'',
			"extraInfo" => [ 
				"label" => "Mark each nucleus by clicking it or drawing a shape around it",
				"label1" => "I have annotated all nuclei ",
				"label2" => "There were too many nuclei to annotate",
				"label3" => "No nuclei visible",
				"label4" => "Other",
				"label5" => "Enter the total number of nuclei here:",
				"step1" => "Click near the center of al visible nuclei or drag the mouse to draw a box around the nuclei. Keep a mental count while you are tagging. ",
				"step2" => "Choose the option from the given list which best describes your nuclei markings. ",
				"step3" => "Report the number of nuclei you have counted in the designated field. ",
				"step4" => "Click the button which best describes the given image quality. "
			],
			"platform" => "DrDetectiveGamingPlatform",
			"user_id" => "carlosm",
			"level" => 2,
			"score" => 20
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
			"tag" => "Colony Catcher",
			"instructions" => ""
				.'<p>You are given 3 microscopic images of one or more colonies. You will be identifying the colonies in the images. Don\'t worry, it\'s easier than you think. Take a look at these examples. <button id="openExamplesButton" class="openExamples" style="margin-top: 50px; margin-bottom:50px;">Show detailed instructions</button></p>'
				.'',
			"examples" => ""
				.'<div style="background-color:#6495ed; padding: 0px 20px 10px 20px;">'
				.'<div style="font-size: 20pt; color:#000;">Examples:</div>'
				.'</p>'
				.'<div style="background-color:#FFF; border:1px solid #000; padding:10px;">'
				.'<div style="border:1px solid #000;"><font color="#DC18DA"><b>Purple dots</b></font> show correctly counted colonies. <font color="#3C5825"><b>Count & annotate a colony only when at least half of it is visible. </b></font><br>
						<font color="#DC18DA"><b>Mark</b></font> each colony as close to its center as possible. <br>
						(When you cannot see the complete colony, mark where you <i>think</i> the center would be.)<br>
						Do not mark colonies that have merged into one big clump. <br>
						Do mark colonies that are at the edge of of the petri dish of which you can see more then half of the colony present. <br>
						<br>
						<font color="#0906C5"><b>Example A</b></font>. You see <font color="#3C5825"><b>13 complete colonies</b></font>, 2 clumps of merged colonies, and a few line shaped clumps at the bottom => <font color="#DC18DA"><b>13 purple dot</b></font> markings. <br>
						<font color="#0906C5"><b>Example B</b></font>. You see <font color="#3C5825"><b>2 complete colonies</b></font>, more then half of <font color="#3C5825"><b>1 colony</b></font>, a little bit of 2 other colony, and <font color="#3C5825"><b>1 colony at the edge of the petri dish</b></font> => <font color="#DC18DA"><b>4 purple dot</b></font> markings. <br>
						<br>
						The <font color="#0906C5">dotted blue line</font> shows the imaginary outline of the colony beyond the border of the image.</div>'
				.'<img width="100%" src="img/ColonyTagging_Mixed.png">'
				.'</div>'
				.'</div>'
				.'',
			"steps" => ""
				.'<div style="font-size: 20pt; color:#000;">Colony identification steps</div>'
				.'<p>Step 1: Click near the center of al visible colonies or drag the mouse to draw a box around the colonies. Keep a mental count while you are tagging. </p>'
				.'<p>Step 2: Choose the option from the given list which best describes your colony markings. </p>'
				.'<p>Step 3: Report the number of colonies you have counted in the designated field. </p>'
				.'<p>Step 4: Click the button which best describes the given image quality. </p>'
				.'<br>'
				.'Detailed explanation for Step 1: '
				.'<div>'
				.'<div class="col span_2_of_8"><img src="img/annotationMenu.png"></div>'
				.'<div class="col span_6_of_8"><ul style="-webkit-margin-before: 0em;-webkit-margin-after: 0em;">'
				.'<li>This menu is located to the left of (or above) your task images. </li>'
				.'<li>The "Drawn" table keeps track of your markings. (mouse clicks or drags)</li>'
				.'<li>To remove the last colony marking, click the <img src=img/removeLastButton.png> button.</li>'
				.'This removes the markings in the reversed order in which they were made (last mark will be deleted first). '
				.'<li>To undo a <i>specific</i> annotation click the <b>x</b> next to the faulty mark in the "Drawn" table which you want to remove. </li>'
				.'<li>Once you are happy with the result, click the "Next question" button. </li>'
				.'</ul></div>'
				.'</div>'
				.'',
			"extraInfo" => [
				"label" => "Mark each colony by clicking it or drawing a shape around it",
				"label1" => "I have annotated all colonies ",
				"label2" => "There were too many colonies to annotate",
				"label3" => "No colonies visible",
				"label4" => "Other",
				"label5" => "Enter the total number of colonies here:",
				"step1" => "Click near the center of al visible colonies or drag the mouse to draw a box around the colonies. Keep a mental count while you are tagging. ",
				"step2" => "Choose the option from the given list which best describes your colony markings. ",
				"step3" => "Report the number of colonies you have counted in the designated field. ",
				"step4" => "Click the button which best describes the given image quality. "
			],
			"platform" => "DrDetectiveGamingPlatform",
			"user_id" => "carlosm",
			"level" => 3,
			"score" => 30
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
			"tag" => "Vesicle Adventure",
			"instructions" => ""
				.'<p>You are given 3 microscopic images of one or more human cells. You will be identifying the vesicles in the images. Don\'t worry, it\'s easier than you think. Take a look at these examples. <button id="openExamplesButton" class="openExamples" style="margin-top: 50px; margin-bottom:50px;">Show detailed instructions</button></p>'
				.'',
			"examples" => ""
				.'<div style="background-color:#6495ed; padding: 0px 20px 10px 20px;">'
				.'<div style="font-size: 20pt; color:#000;">Examples:</div>'
				.'</p>'
				.'<div style="background-color:#FFF; border:1px solid #000; padding:10px;">'
				.'<div style="border:1px solid #000;">Arrows point to the area the example is classifying. A few of the larger nuclei have been marked with a <i>star</i> to help identify them. <br>
						<font color="#0906C5"><b>Example A</b></font>. Vesicles at the <i>tip</i> of the cell. <br>
						<font color="#0906C5"><b>Example B</b></font>. Vesicles fairly <i>evenly</i> diffused throughout the cell (think of a mist or fog)<br>
						<font color="#0906C5"><b>Example C</b></font>. Vesicles on <i>one</i> side of the nucleus. <br>
						<font color="#0906C5"><b>Example D</b></font>. Vesicles in <i>clusters</i>(clumps of small dots stuck together). <br>
						<font color="#0906C5"><b>Example E</b></font>. Vesicles in a <i>ring</i> around the nucleus. <br>
						</div>'
				.'<img width="100%" src="img/Vesicle_Locating_Mixed.png">'
				.'</div>'
				.'</div>'
				.'',
			"steps" => ""
				.'<div style="font-size: 20pt; color:#000;">Vesicle identification steps</div>'
				.'<p>Step 1: First, take a look at the image and click on the icon which best describes the behavior of the vesicles.</p>'
				.'<ul>'
				.'<li>Vesicles can be seen as tiny dots present throughout (a part of) the cell.</li>'
				.'<li>Vesicles can be seen as larger "clumps" of color, varying in size.</li>'
				.'<li>Different vesicles can exhibit different behavior we will call trends.</li>'
				.'<li>Some images will have vesicles with different fluorescent colors.</li>'
				.'<li>Refer to the rest of the image for correct identification of the cells and to be sure of not taking background spots as vesicles.</li>'
				.'</ul>'
				.'<p>Step 2: Choose the option from the given list which best describes your vesicle location classification.</p>'
				.'<p>Step 3: Click the button which best describes the given image quality. </p>'
				.'',
			"extraInfo" => [
				"label" => "Click on the icon below which best describes the VESICLE location",
				"label1" => "Side Nucleus",
				"label2" => "Ring around Nucleus",
				"label3" => "My selection applies to all the vesicles in this image",
				"label4" => "One or more cells in this image contained vesicles which behaved differently than my selection",
				"label5" => "No cell visible",
				"step1" => "Take a look at the image and click on the icon which best describes the behavior of the vesicles",
				"step2" => "Choose the option from the given list which best describes your vesicle location classification.",
				"step3" => "Click the button which best describes the given image quality. "
			],
			"platform" => "DrDetectiveGamingPlatform",
			"user_id" => "carlosm",
			"level" => 1,
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
