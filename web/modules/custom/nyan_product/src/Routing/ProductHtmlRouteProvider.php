<?php

namespace Drupal\nyan_product\Routing;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides routes for products entities.
 */
class ProductHtmlRouteProvider extends AdminHtmlRouteProvider {

  use StringTranslationTrait;

  /**
   * Permission to manage quota entities.
   */
  protected const MANAGE_PERMISSION = 'manage products';

  /**
   * {@inheritdoc}
   */
  protected function getCollectionRoute(EntityTypeInterface $entity_type) {
    $route = parent::getCollectionRoute($entity_type);

    if ($route) {
      $title = (string) $this->t('Products');
      $route->setDefault('_title', $title);
      $route->setRequirement('_permission', static::MANAGE_PERMISSION);
    }

    return $route;
  }

}
