<?php

namespace Drupal\nyan_supply\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the supply item entity class.
 *
 * @ContentEntityType(
 *   id = "supply_item",
 *   label = @Translation("Supply item"),
 *   label_collection = @Translation("Supply items"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\nyan_supply\Form\SupplyItemForm",
 *       "edit" = "Drupal\nyan_supply\Form\SupplyItemForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "supply_item",
 *   admin_permission = "administer supply item",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/content/supply-item/add",
 *     "canonical" = "/supply_item/{supply_item}",
 *     "edit-form" = "/admin/content/supply-item/{supply_item}/edit",
 *     "delete-form" = "/admin/content/supply-item/{supply_item}/delete",
 *     "collection" = "/admin/content/supply-item"
 *   },
 *   field_ui_base_route = "entity.supply_item.settings"
 * )
 */
class SupplyItem extends ContentEntityBase implements SupplyItemInterface {

  /**
   * {@inheritdoc}
   */
  public function getQuantity(): int {
    return (int) $this->get(SupplyItemFields::QUANTITY)
      ->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getDiscount(): ?float {
    return (float) $this->get(SupplyItemFields::DISCOUNT)
      ->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getUnitPrice(): float {
    return (float) $this->get(SupplyItemFields::UNIT_PRICE)
      ->value;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    $quantity = $this->getQuantity();
    $unitPrice = $this->getUnitPrice();
    $discount = $this->getDiscount();
    $total = $unitPrice * $quantity;
    if ($discount > 0) {
      $total = $total - ($total * $discount / 100);
    }

    $this->set(SupplyItemFields::TOTAL_PRICE, $total);
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields[SupplyItemFields::PRODUCT] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Product'))
      ->setDescription(t('The product you want to have in your stocks.'))
      ->setCardinality(1)
      ->setRequired(TRUE)
      ->setSetting('target_type', 'product')
      ->setSetting('handler', 'default')
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields[SupplyItemFields::SUPPLIER] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Supplier'))
      ->setDescription(t('The supplier you want to take the item from.'))
      ->setRequired(TRUE)
      ->setCardinality(1)
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting(
        'handler_settings',
        ['target_bundles' => ['supplier' => 'supplier']]
      )
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields[SupplyItemFields::QUANTITY] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Quantity'))
      ->setDescription(t('The amount of this products\' items.'))
      ->setRequired(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setSetting('unsigned', TRUE);

    return $fields;
  }

}
