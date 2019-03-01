<?php

namespace Drupal\additional_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\taxonomy;

/**
* Provides a 'Product Isotope' block.
*
* @Block(
*   id = "contact_form",
*   admin_label = @Translation("Contact Form"),
* )
*/
class ContactForm extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get node IDs for latest Publications for each category
    $default_form = \Drupal::config('contact.settings')->get('default_form');
    $entity = \Drupal::entityManager()->getStorage('contact_form')->load($default_form);

    $message = \Drupal::entityManager()
      ->getStorage('contact_message')
      ->create(array(
        'contact_form' => $entity->id(),
      ));

    $form = \Drupal::service('entity.form_builder')->getForm($message);

    return $form;
  }
}