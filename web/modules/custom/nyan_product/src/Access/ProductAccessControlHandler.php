<?php

namespace Drupal\nyan_product\Access;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\nyan_product\Entity\ProductInterface;

/**
 * Access controller for the Product entity.
 */
class ProductAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\nyan_product\Entity\ProductInterface $entity */
    switch ($operation) {
      case 'view':
        return AccessResult::allowed();

      default:
        return AccessResult::allowedIfHasPermission($account, 'manage products');
    }

    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'manage products');
  }

}
