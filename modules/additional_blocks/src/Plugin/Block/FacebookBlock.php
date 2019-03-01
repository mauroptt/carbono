<?php

namespace Drupal\additional_blocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\image\Entity\ImageStyle;
use Drupal\taxonomy;
use Facebook\FacebookRequest;
use Facebook\GraphNodes\GraphNode;
use Facebook\GraphNodes\GraphNodeFactory;

include_once DRUPAL_ROOT."/sites/default/libraries/facebook_sdk/src/Facebook/autoload.php";

/**
* Provides a 'Facebook Block' block.
*
* @Block(
*   id = "facebook_block",
*   admin_label = @Translation("Carbono en Facebook"),
* )
*/
class FacebookBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
//  public function build() {
//    _facebook_importer_processing();
//
//    ini_set('display_startup_errors', 1);
//    ini_set('display_errors', 1);
//    error_reporting(-1);
//
//    $fb = new \Facebook\Facebook([
//      'app_id' => '1111859605547169',
//      'app_secret' => 'ae99761260321395262bb90d03af4779',
//      'default_graph_version' => 'v2.7',
//      'default_access_token' => '1111859605547169|2uljps-RV5609sR-S0KaJABI0iA', // optional
//    ]);
//
//    try {
//      $response = $fb->get('/1553275308290121/photos/uploaded', $fb->getDefaultAccessToken());
//    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
//      // When Graph returns an error
////      echo 'Graph returned an error: ' . $e->getMessage();
////      exit;
//    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
//      // When validation fails or other local issues
////      echo 'Facebook SDK returned an error: ' . $e->getMessage();
////      exit;
//    }
//
//    $mark = '';
//
//    if (!isset($response)) {
//      return [];
//    }
//
//    $graphEdge = $response->getGraphEdge();
//
//    $container = [
//      '#type' => 'container',
//    ];
//
//    $i = 0;
//
//    $mark .= '<ul class="fb-photos">';
//    $modals = '';
//    foreach ($graphEdge as $graphNode) {
//      $i++;
//      if ($i <= 6) {
//        $pid = $graphNode->asArray()['id'];
//        $mark .= '<li><a data-toggle="modal" data-target="#image'.$i.'"><div class="overlay"><div class="link-icon"></div></div><img src="https://graph.facebook.com/'.$pid.'/picture" /></a></li>';
//        $modals .= $this->modals($i, '<img src="https://graph.facebook.com/'.$pid.'/picture" />');
//      }
//    }
//    $mark .= '</ul>';
//
//    $variable = [
//      '#markup' => $mark,
//
//      '#attached' => [
//        'library' => [
//          'additional_blocks/js_helper',
//        ],
//        'drupalSettings' => [
//          'modals' => $modals
//        ]
//      ]
//    ];
//
//    return $variable;
//  }

  public function build() {

    $mark = '<h2>Carbono en Facebook</h2>';
    $modals = '';

    $container = [
      '#type' => 'container',
    ];

    // Get list of products
    $query = \Drupal::entityQuery('node')
      ->condition('status', 1)
      ->condition('type', 'imagen_de_facebook')
      ->sort('created', 'DESC')
      ->range(0, 6);

    $nids = $query->execute();

    if (isset($nids) && count($nids) > 0) {
      $i = 0;

      $mark .= '<ul class="fb-photos">';

      foreach ($nids as $nid) {
        $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
        $fotos = $node->get('field_fb_imagen');
        if (count($fotos->referencedEntities()) > 0) {
          foreach ($fotos->referencedEntities() as $foto) {
            $image_url = \Drupal\image\Entity\ImageStyle::load('original')->buildUrl($foto->getFileUri());
            $mark .= '<li><a data-toggle="modal" data-target="#image'.$i.'"><div class="overlay"><div class="link-icon"></div></div><img src="'.$image_url.'" /></a></li>';
            $modals .= $this->modals($i, '<img src="'.$image_url.'" />');
            $i++;
          }
        }
      }
    }

    $mark .= '</ul>';

    $variable = [
      '#markup' => $mark,

      '#attached' => [
        'library' => [
          'additional_blocks/js_helper',
        ],
        'drupalSettings' => [
          'modals' => $modals
        ]
      ]
    ];

    return $variable;
  }

  public function modals($id, $image) {
    return '
    <div id="image'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <a class="close" data-dismiss="modal" aria-label="Close">
            <div class="nav-icon open">
              <span></span><span></span><span></span>
            </div>
          </a>
          <div class="modal-body">
            <div class="">
              <div class="row row-image">
                '.$image.'
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
  }
}
