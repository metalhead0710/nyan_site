<?php

namespace Drupal\nyan_supply\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a supply entity type.
 */
interface SupplyInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the supply creation timestamp.
   *
   * @return int
   *   Creation timestamp of the supply.
   */
  public function getCreatedTime();

  /**
   * Sets the supply creation timestamp.
   *
   * @param int $timestamp
   *   The supply creation timestamp.
   *
   * @return \Drupal\nyan_supply\SupplyInterface
   *   The called supply entity.
   */
  public function setCreatedTime($timestamp);

}
