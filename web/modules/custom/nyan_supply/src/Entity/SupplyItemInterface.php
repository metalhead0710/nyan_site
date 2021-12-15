<?php

namespace Drupal\nyan_supply\Entity;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface defining a supply item entity type.
 */
interface SupplyItemInterface extends ContentEntityInterface {

  /**
   * Returns the quantity of the supply item.
   *
   * @return int
   *   The amount of items bought.
   */
  public function getQuantity(): int;

  /**
   * Returns the discount.
   *
   * @return float|null
   *   The discount.
   */
  public function getDiscount(): ?float;

  /**
   * Returns the unit price.
   *
   * @return float
   *   The unit price.
   */
  public function getUnitPrice(): float;

}
