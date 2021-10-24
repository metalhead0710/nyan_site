<?php

namespace Drupal\nyan_product\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface for defining Product entities.
 */
interface ProductInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Return price.
   *
   * @return string
   *   The price.
   */
  public function getPrice(): string;

}
