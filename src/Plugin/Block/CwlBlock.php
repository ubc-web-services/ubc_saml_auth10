<?php

namespace Drupal\ubc_saml_auth10\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an banner displaying CWL Login Name and a Logout button.
 *
 * @Block(
 *   id = "cwl_info",
 *   admin_label = @Translation("CWL Info"),
 *   category = @Translation("CWL"),
 * )
 */
class CwlBlock extends BlockBase {

 /**
   * {@inheritdoc}
   */
  public function build() {

    $user = \Drupal::currentUser();
    $user_roles = $user->getRoles();

    //foreach($user_roles as $i => $r) {
    //  \Drupal::logger('UBC_SAML_AUTH')->notice('Role: '.$i.' :'.$r);
    //}

    if (in_array('cwl', $user_roles)) {
      $cwl_name = $user->getAccountName();
      $cwl_role = TRUE;
    }
    else {
      $cwl_name = null;
      $cwl_role = null;
    }

    $config = array(
      '#cache' => [
        'max-age' => 0,
      ],
      '#theme' => 'cwl_template',
      '#cwl_name' => $cwl_name,
      '#cwl_role' => $cwl_role,
    );

 		return $config;
  }


}
