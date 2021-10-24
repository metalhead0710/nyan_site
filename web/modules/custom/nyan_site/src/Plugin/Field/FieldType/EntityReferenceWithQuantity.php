<?php

namespace Drupal\nyan_site\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Url;

/**
 * Provides list of entity reference items with quantity.
 *
 * @FieldType(
 *   id = "entity_reference_with_quantity",
 *   label = @Translation("Entity reference with quantity"),
 *   category = @Translation("Custom"),
 *   default_widget = "entity_reference_with_quantity",
 *   default_formatter = "entity_reference_label",
 *   list_class = "\Drupal\Core\Field\EntityReferenceFieldItemList",
 * )
 */
class EntityReferenceWithQuantity extends EntityReferenceItem {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(
    FieldStorageDefinitionInterface $field_definition
  ) {
    $properties = parent::propertyDefinitions($field_definition);

    $properties['quantity'] = DataDefinition::create('integer')
      ->setLabel(t('Quantity'))
      ->setRequired(TRUE);
    $properties['price'] = DataDefinition::create('string')
      ->setLabel(t('Price'));
    $properties['uri'] = DataDefinition::create('uri')
      ->setLabel(t('URI'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(
    FieldStorageDefinitionInterface $field_definition
  ) {
    $schema = parent::schema($field_definition);
    $schema['columns'] += [
      'quantity' => [
        'type' => 'int',
        'size' => 'normal',
      ],
      'price' => [
        'type' => 'numeric',
        'not_null' => TRUE,
        'default' => 0,
        'unsigned' => TRUE,
      ],
      'uri' => [
        'description' => 'The URI of the link.',
        'type' => 'varchar',
        'length' => 2048,
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return [
      'quantity_settings' => [],
    ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(
    array $form,
    FormStateInterface $form_state
  ) {
    $form = parent::fieldSettingsForm($form, $form_state);
    $form['quantity_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Quantity settings'),
      '#open' => TRUE,
      '#tree' => TRUE,
    ];
    $quantity_settings = $this->getSetting('quantity_settings');
    $form['quantity_settings']['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Quantity title'),
      '#default_value' => $quantity_settings['title'] ?? '',
    ];
    $form['quantity_settings']['description'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Quantity description'),
      '#default_value' => $quantity_settings['description'] ?? '',
    ];
    $form['quantity_settings']['default_value'] = [
      '#type' => 'number',
      '#title' => $this->t('Quantity default value'),
      '#default_value' => $quantity_settings['default_value'] ?? '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints = parent::getConstraints();

    $constraints[] = $constraint_manager->create('ComplexData', [
      'price' => [
        'Regex' => [
          'pattern' => '/^[+-]?((\d+(\.\d*)?)|(\.\d+))$/i',
        ],
      ],
    ]);

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public function getUrl() {
    return Url::fromUri($this->uri);
  }

  /**
   * {@inheritdoc}
   */
  public static function getPreconfiguredOptions() {
    // Provide no preconfigured options to avoid flooding the list of field
    // types.
    return [];
  }

}
