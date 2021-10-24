<?php

namespace Drupal\nyan_product\Entity;

use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the product.
 *
 * @ContentEntityType(
 *   id = "product",
 *   label = @Translation("Product"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\nyan_product\Form\ProductForm",
 *       "add" = "Drupal\nyan_product\Form\ProductForm",
 *       "edit" = "Drupal\nyan_product\Form\ProductForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\nyan_product\Routing\ProductHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\nyan_product\Access\ProductAccessControlHandler",
 *   },
 *   base_table = "product",
 *   data_table = "product_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer products",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/admin/products/{product}",
 *     "add-form" = "/admin/products/add",
 *     "edit-form" = "/admin/products/{product}/edit",
 *     "delete-form" = "/admin/products/{product}/delete",
 *     "collection" = "/admin/content/products",
 *   },
 *   field_ui_base_route = "product.settings"
 * )
 */
class Product extends ContentEntityBase implements ProductInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getPrice(): string {
    return $this->get(ProductFields::PRICE)->value . ' ' . t('UAH');
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields[ProductFields::TITLE] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);

    $fields[ProductFields::PRICE] = BaseFieldDefinition::create('decimal')
      ->setLabel(t('Price'))
      ->setRequired(TRUE)
      ->setSetting('unsigned', TRUE)
      ->setSetting('min', 0)
      ->setSetting('suffix', 'UAH')
      ->setDefaultValue(1)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the product was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the product was last edited.'))
      ->setTranslatable(TRUE);

    return $fields;
  }

}
