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
*   id = "product_isotope",
*   admin_label = @Translation("Product Isotope"),
* )
*/
class ProductIsotope extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get node IDs for latest Publications for each category
    $out = [];

    $out['form-signin']['#prefix'] = '<div class="c-form c-form--signin">';
    $out['form-signin']['#suffix'] = '</div>';

    // Get list of products
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'producto');

    $nids = $query->execute();
    $items = [];

    // Load category vocabulary
    $cats = [];
    $vocabulary = \Drupal\taxonomy\Entity\Vocabulary::load('tipo_de_producto');
    $terms = \Drupal ::entityTypeManager()->getStorage('taxonomy_term')->loadTree('tipo_de_producto', 0, null, TRUE);

    foreach ($terms as $term) {
      $name = $term->getFields()['name']->getValue()[0]['value'];
      $tid = $term->getFields()['tid']->getValue()[0]['value'];
      $term_icon = [];

      $icons = $term->getFields()['field_tipo_de_producto_icono']->referencedEntities();

      if (count($icons) > 0) {
        foreach ($icons as $icon) {
          $image_url = \Drupal\image\Entity\ImageStyle::load('medium')->buildUrl($icon->getFileUri());
          $cats[] = [
            'data' => [
              '#markup' => '<a class="isotope-filter-element cat-'.$tid.'" data-isotope-filter="cat-'.$tid.'"><img src="'.$image_url.'" alt="'.$name.'"></a>',
            ],
          ];
        }
      }
    }

    $out[] = array(
      '#prefix' => '<div class="isotope-filter-wrapper">',
      '#suffix' => '</div>',
      '#theme' => 'item_list',
      '#items' => $cats,
      '#type' => 'ul',
      '#attributes' => array(
        'class' => ' isotope-filter',
        'id' => 'isotope-instance-1-filter',
      ),
      '#attached' => array(
        'library' => array(
          'additional_blocks/js_helper',
        ),
      ),
    );

    if (isset($nids) && count($nids) > 0) {
      foreach ($nids as $nid) {
        $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
        if (count($node->get('field_producto_tipo')->getValue()) > 0) {
          $categories = $node->get('field_producto_tipo')->getValue();
          $cats = [];
          foreach ($categories as $category) {
            $cats[] = 'cat-'.$category['target_id'];
          }
        }

//        new \dBug($node->get('field_producto_tipo')->getValue()); die();
        $node_output = node_view($node, 'producto_mosaico');
        $items[] = array(
          'value' => \Drupal::service('renderer')->render($node_output),
          'data' => array(
            'size' => ['col-md-3','col-sm-6','col-xs-6'],
            'cats' => $cats,
//            'shape' => $shape,
//            'color' => $color,
          ),
        );
      }
    }

    $out[] = array(
      '#theme' => 'isotope_grid',

      // '#theme' => 'item_list',
      '#items' => $items,
      '#instance' => 1,
      // '#attached' => array(
      //   'css' => array(drupal_get_path('module', 'isotope_example') . '/isotope_example.css'),
      // ),
    );

    return $out;
  }
}