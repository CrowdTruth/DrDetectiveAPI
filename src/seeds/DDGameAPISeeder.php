<?php
namespace CrowdTruth\DDGameapi;

use \MongoDB\SoftwareComponent as SoftwareComponent;

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
	}
}
