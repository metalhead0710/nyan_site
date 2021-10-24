<?php

namespace Drupal\nyan_site\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides formatter for entity reference with quantity..
 *
 * @FieldFormatter(
 *   id = "entity_reference_with_quantity",
 *   label = @Translation("Entity reference with quantity"),
 *   field_types = {
 *     "entity_reference_with_quantity",
 *   },
 * )
 */
class EntityReferenceWithQuantityFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($items as $delta => $item) {
      $distributor = $item->entity->label();
      $uri = $item->uri;
      $url = Url::fromUri($uri);
      $link = Link::fromTextAndUrl(
        $this->t('See'),
        $url
      )->toString();
      $formattedPrice = number_format($item->price, 2, NULL, '');
      $price = "{$formattedPrice}  {$this->t('UAH')}/piece";
      $qty = $this->t('Available: @qty', ['@qty' => $item->quantity]);
      $element[$delta] = [
        '#markup' => "<b>{$distributor}</b>: {$qty}, $price, {$link}<br>",
      ];
    }

    return $element;
  }

}
