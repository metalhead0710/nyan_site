<?php

namespace Drupal\nyan_supply\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the supply item entity edit forms.
 */
class SupplyItemForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New supply item %label has been created.', $message_arguments));
      $this->logger('nyan_supply')->notice('Created new supply item %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The supply item %label has been updated.', $message_arguments));
      $this->logger('nyan_supply')->notice('Updated new supply item %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.supply_item.canonical', ['supply_item' => $entity->id()]);
  }

}
