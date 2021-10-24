<?php

namespace Drupal\nyan_site\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides sample entities.
 *
 * @see \Drupal\nyan_site\Entity\SampleEntityProviderInterface
 */
class SampleEntityProvider implements SampleEntityProviderInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * A constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager
  ) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity(
    string $entity_type_id,
    string $bundle = NULL
  ): EntityInterface {
    $values = [];

    $entity_type = $this->entityTypeManager->getDefinition($entity_type_id);
    $bundle_key = $entity_type->getKey('bundle');
    if ($bundle_key) {
      $values[$bundle_key] = $bundle;
    }

    // @todo Cache sample entities per type + bundle for performance?
    return $this->entityTypeManager->getStorage($entity_type_id)
      ->create($values);
  }

}
