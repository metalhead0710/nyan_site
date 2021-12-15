<?php

namespace Drupal\nyan_supply\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the supply entity edit forms.
 */
class SupplyForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\nyan_product\Entity\SupplyInterface $entity */
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()
          ->addStatus($this->t('Created the %label supply.', [
            '%label' => $entity->label(),
          ]));
        break;

      default:
        $this->messenger()
          ->addStatus($this->t('Saved the %label supply.', [
            '%label' => $entity->label(),
          ]));
    }
    $form_state->setRedirect('view.supplies.list');
    return $status;
  }

}
