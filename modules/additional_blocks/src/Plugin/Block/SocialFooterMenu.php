<?php

namespace Drupal\additional_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\taxonomy;

/**
* Provides a 'Social Footer' block in menu.
*
* @Block(
*   id = "social_footer_menu",
*   admin_label = @Translation("Social Block Menu"),
* )
*/
class SocialFooterMenu extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get node IDs for latest Publications for each category
    $out = [];

    $footer = '<div class="social-links">';
    $footer .= '<a href="https://www.facebook.com/carbonoactivity/" class="social-link facebook-logo" target="_blank">Facebook</a>';
    $footer .= '<a href="https://www.instagram.com/carbonoactivity/" class="social-link instagram-logo" target="_blank">Instagram</a>';
    $footer .= '<a href="https://twitter.com/CARBONOActivity" class="social-link twitter-logo" target="_blank">Twitter</a>';
    $footer .= '</div>';

    $out = [
      '#markup' => $footer,
    ];

    return $out;
  }
}