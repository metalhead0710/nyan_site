<?php

namespace Drupal\nyan_product\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Handles routes for the products configuration.
 */
class ProductAdminController extends ControllerBase {

  /**
   * Handles base route for the field UI.
   *
   * Field UI needs some base route to attach its routes to.
   *
   * @return array
   *   The page content.
   */
  public function configuration(): array {
    return [
      '#markup' => $this->t(
        'There is nothing to configure, but you may proceed to field settings.'
      ),
    ];
  }

}
