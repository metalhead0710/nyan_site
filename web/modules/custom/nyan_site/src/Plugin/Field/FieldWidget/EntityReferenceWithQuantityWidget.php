<?php

namespace Drupal\nyan_site\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\EntityReferenceAutocompleteWidget;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\link\LinkItemInterface;

/**
 * Provides widget for entity reference with quantity field type.
 *
 * @FieldWidget(
 *   id = "entity_reference_with_quantity",
 *   label = @Translation("Entity reference with quantity"),
 *   field_types = {
 *     "entity_reference_with_quantity"
 *   }
 * )
 */
class EntityReferenceWithQuantityWidget extends EntityReferenceAutocompleteWidget {

  use StringTranslationTrait;

  /**
   * Quantity minimal value.
   */
  const QUANTITY_MIN_VALUE = 0;

  /**
   * Field quantity weight.
   */
  const FIELD_QUANTITY_WEIGHT = 10;

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state
  ) {
    $widget = [
      '#type' => 'fieldset',
      '#title' => $this->t('Supplies info'),
    ];
    $fields = parent::formElement(
      $items,
      $delta,
      $element,
      $form,
      $form_state
    );
    $fields['target_id']['#title'] = $this->t('Supplier');
    $fields['target_id']['#placeholder'] = $this->t('Supplier');
    $fields['target_id']['#title_display'] = 'attribute';

    $quantity_settings = $this->fieldDefinition->getSetting('quantity_settings');
    $default_value = isset($items[$delta]) ?
      $items[$delta]->quantity : $quantity_settings['default_value'];

    $title = $quantity_settings['title'] ?? '';
    $fields['quantity'] = [
      '#title' => $title,
      '#type' => 'number',
      '#default_value' => $default_value ?? 0,
      '#min' => static::QUANTITY_MIN_VALUE,
      '#weight' => static::FIELD_QUANTITY_WEIGHT,
    ];

    $widget += $fields;

    return $widget;
  }

}
