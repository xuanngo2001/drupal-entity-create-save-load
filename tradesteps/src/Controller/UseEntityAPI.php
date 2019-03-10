<?php
 
// Note: The namespace path doesn't contain 'src' because
//  by default, Drupal will fetch all source code files from 'src' directory.
namespace Drupal\tradesteps\Controller;

use Drupal\Core\Controller\ControllerBase;

class UseEntityAPI extends ControllerBase{
    public function usage() {

        // Create a entity object.
        $entity = \Drupal::entityTypeManager()
                            ->getStorage('node')
                            ->create([
                                'type' => 'article', 
                                'title' => 'My title',
                                'body' => 'This is the body. Use machine name field.'
                                ]);

        // Update entity field.
        //      $entity->get('title')->getValue(): Return an array of values.
        //      $entity->get('title')->getString(): Return a value.
        $new_value=$entity->get('title')->getString() . ", updated on " . date('D, d M Y H:i:s');
        $entity->get('title')->setValue($new_value);

        // Save the entity object. It will commit to database.
        $entity->save();
        $saved_entity_id = $entity->id();

        // Load entity object.
        $loaded_entity = \Drupal::entityTypeManager()->getStorage('node')->load($saved_entity_id);

        // Get info about entity: Good for debugging.
        $entity_info = print_r($loaded_entity->toArray(), true);

        // Prepare to display data.
        $loaded_id = $loaded_entity->id();
        $loaded_title = $loaded_entity->getTitle();
        $loaded_type = $loaded_entity->getType();

        $html = 'Info of created ['.$loaded_type.']: [node id = '. $loaded_id. '] : ['. $loaded_title.']';
        $html .= '<pre>'. $entity_info. '</pre>';

        return array(
            '#type' => 'markup',
            '#markup' => t($html),
        );

    }

}
