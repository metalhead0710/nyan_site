<?php

namespace Drupal\nyan_product\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Product price edit forms.
 */
class ProductForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\nyan_product\Entity\ProductInterface $entity */
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()
          ->addStatus($this->t('Created the %label product.', [
            '%label' => $entity->label(),
          ]));
        break;

      default:
        $this->messenger()
          ->addStatus($this->t('Saved the %label product.', [
            '%label' => $entity->label(),
          ]));
    }
    $form_state->setRedirect('view.products.list');
    return $status;
  }

}
