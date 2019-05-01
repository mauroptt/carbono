<?php

namespace Drupal\additional_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\taxonomy;

/**
* Provides a 'Social Footer' block.
*
* @Block(
*   id = "social_footer",
*   admin_label = @Translation("Social Block Footer"),
* )
*/
class SocialFooter extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get node IDs for latest Publications for each category
    $out = [];

    $footer = '<div class="col-md-6 col-sm-12 social-links social-links-left">';
    $footer .= '<a href="https://www.facebook.com/carbonoactivity/" class="social-link facebook-logo" target="_blank">Facebook</a>';
    $footer .= '<a href="https://www.instagram.com/carbonoactivity/" class="social-link instagram-logo" target="_blank">Instagram</a>';
    $footer .= '<a href="https://twitter.com/CARBONOActivity" class="social-link twitter-logo" target="_blank">Twitter</a>';
    $footer .= '</div>';
    $footer .= '<div class="col-md-6 col-sm-12 copyright"><span class="footer-logo">Carbono</span><br />' . date("Y") . ' CARBONO ACTIVITY</div>';
    $footer .= '<div class="col-md-6 col-sm-12 social-links social-links-right">';
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