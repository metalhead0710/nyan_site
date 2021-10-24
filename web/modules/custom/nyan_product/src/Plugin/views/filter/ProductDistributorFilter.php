<?php

namespace Drupal\nyan_product\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\nyan_site\Entity\SampleEntityProviderInterface;
use Drupal\views\Plugin\views\filter\ManyToOne;
use Drupal\search_api\Plugin\views\filter\SearchApiFilterTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a filter with options for product distributor.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter(Drupal\nyan_product\Plugin\views\filter\ProductDistributorFilter::PLUGIN_ID)
 */
class ProductDistributorFilter extends ManyToOne {

  /**
   * The plugin ID.
   */
  public const PLUGIN_ID = 'nyan_product_distributor';

  /**
   * The entity field manager service.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * The sample entity provider.
   *
   * @var \Drupal\nyan_site\Entity\SampleEntityProviderInterface
   */
  protected $sampleEntityProvider;

  /**
   * {@inheritdoc}
   */
  public static function create(
    ContainerInterface $container,
    array $configuration,
    $plugin_id,
    $plugin_definition
  ) {
    $instance = new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );

    $instance->entityFieldManager = $container->get('entity_field.manager');
    $instance->sampleEntityProvider = $container->get('nyan_site.sample_entity_provider');

    return $instance;
  }
  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    unset($form['reduce_duplicates']);
  }

  /**
   * {@inheritdoc}
   */
  public function getValueOptions() {
    if (isset($this->valueOptions)) {
      return $this->valueOptions;
    }

    $this->valueOptions = [];

    $field_name = $this->definition['field_name'];
    $entity_type = $this->definition['entity_type'];
    $bundle = $this->definition['bundle'];
    $property_name = $this->definition['property_name'];

    $field_definitions = $this
      ->entityFieldManager
      ->getFieldDefinitions($entity_type, $bundle);
    $field_definition = $field_definitions[$field_name] ?? NULL;
    if ($field_definition !== NULL) {
      $entity = $this->sampleEntityProvider->getEntity($entity_type);
      $options_provider = $field_definition->getFieldStorageDefinition()
        ->getOptionsProvider($property_name, $entity);
      $this->valueOptions = $options_provider
        ->getSettableOptions();
    }

    return $this->valueOptions;
  }
}
