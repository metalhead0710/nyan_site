<?php

/**
 * @file Contains views hooks.
 */

use Drupal\nyan_product\Plugin\views\filter\ProductDistributorFilter;

/**
 * Implements hook_views_data_alter().
 */
function nyan_product_views_data_alter(array &$data) {
  $table_name = 'product__field_distribution_info';
  if (isset($data[$table_name])) {
    $table =& $data[$table_name];
    $property_path = 'field_distribution_info_target_id';
    $table['_product_distributor_' . $property_path] = [
      'title' => t('Product distributor filter'),
      'help' => t(
        'Limits results to selected distributor.'
      ),

      'filter' => [
        'real field' => $property_path,
        'id' => ProductDistributorFilter::PLUGIN_ID,
        'entity_type' => 'product',
        'bundle' => 'product',
        'field_name' => 'field_distribution_info',
        'property_name' => 'target_id',
      ],
    ];
  }
}
