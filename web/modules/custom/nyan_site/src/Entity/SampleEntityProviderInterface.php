<?php

namespace Drupal\nyan_site\Entity;

use Drupal\Core\Entity\EntityInterface;

/**
 * Provides an interface for a sample entity provider.
 *
 * Some methods require an entity object, e.g. you can't get an option provider
 * without a full entity. The class solves this issue by providing an entity.
 *
 * @see \Drupal\Core\Field\FieldStorageDefinitionInterface::getOptionsProvider()
 */
interface SampleEntityProviderInterface {

  /**
   * Returns sample entity.
   *
   * It shouldn't be saved to a storage. If you need to save it, create a new
   * entity using the entity storage.
   *
   * @param string $entity_type_id
   *   The entity type ID.
   * @param string|null $bundle
   *   The bundle, if any.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The sample entity.
   */
  public function getEntity(
    string $entity_type_id,
    string $bundle = NULL
  ): EntityInterface;

}
