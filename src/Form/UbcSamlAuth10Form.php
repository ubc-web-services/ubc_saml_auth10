<?php

/**
 * @file
 * Contains Drupal\ubc_saml_auth10\Form\UbcSamlAuth10Form.
 */

namespace Drupal\ubc_saml_auth10\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class UbcSamlAuth10Form extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ubc_saml_auth10.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ubc_saml_auth10_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);
    $config = $this->config('ubc_saml_auth10.settings');

    ### Individual Paths ###

    $form['ubc_saml_auth10_settings_ind1'] = [
      '#prefix' => '<h3>Enter Individual Paths</h3><p><strong><i>/cwl</i></strong> and <strong><i>/secure</i></strong> are included by default<br />Example: <strong><i>/my_cwl_content/policies</i></strong></p>',
      '#type' => 'textfield',
      '#title' => $this->t('CWL Individual Path'),
      '#default_value' => $config->get('ubc_saml_auth10.ubc_saml_auth10_settings_ind1'),
    ];

    $firstEmpty = true;
    for($i=2; $i<=UBC_SAML_AUTH_CONFIG_FIELD_NUM; $i++) {

      $next = $config->get('ubc_saml_auth10.ubc_saml_auth10_settings_ind'.$i);

      if(!empty($next) || $firstEmpty) {
        $firstEmpty = (empty($next))? false:true;
        $form['ubc_saml_auth10_settings_ind'.$i] = [
          '#type' => 'textfield',
          '#default_value' => $config->get('ubc_saml_auth10.ubc_saml_auth10_settings_ind'.$i),
        ];
      }
    }

    ### Wildcards ###

    $form['ubc_saml_auth10_settings1'] = [
      '#prefix' => '<h3>Enter Wildcard Paths</h3><p><strong><i>/cwl/*</i></strong> and <strong><i>/secure/*</i></strong> are included by default<br />Example: <strong><i>/my_cwl_content/*</i></strong></p>',
      '#type' => 'textfield',
      '#title' => $this->t('CWL Wildcard Path'),
      '#default_value' => $config->get('ubc_saml_auth10.ubc_saml_auth10_settings1'),
    ];

    $firstEmpty = true;
    for($i=2; $i<=UBC_SAML_AUTH_CONFIG_FIELD_NUM; $i++) {

      $next = $config->get('ubc_saml_auth10.ubc_saml_auth10_settings'.$i);

      if(!empty($next) || $firstEmpty) {
        $firstEmpty = (empty($next))? false:true;
        $form['ubc_saml_auth10_settings'.$i] = [
          '#type' => 'textfield',
          '#default_value' => $config->get('ubc_saml_auth10.ubc_saml_auth10_settings'.$i),
        ];
      }
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    for($i=1; $i<=UBC_SAML_AUTH_CONFIG_FIELD_NUM; $i++) {

      if(!empty($form_state->getValue('ubc_saml_auth10_settings_ind'.$i))) {

        if(!str_starts_with($form_state->getValue('ubc_saml_auth10_settings_ind'.$i), '/')) {
          $form_state->setErrorByName('ubc_saml_auth10_settings_ind'.$i, $this->t('Incorrect format: /your/path'));
        }
      }
      if(!empty($form_state->getValue('ubc_saml_auth10_settings'.$i))) {

        if(!str_starts_with($form_state->getValue('ubc_saml_auth10_settings'.$i), '/') ||
          !str_ends_with($form_state->getValue('ubc_saml_auth10_settings'.$i), '/*')) {
          $form_state->setErrorByName('ubc_saml_auth10_settings'.$i, $this->t('Incorrect format: /your/path/*'));
        }
      }


    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('ubc_saml_auth10.settings');

    for($i=1; $i<=UBC_SAML_AUTH_CONFIG_FIELD_NUM; $i++) {

      $config->set('ubc_saml_auth10.ubc_saml_auth10_settings_ind'.$i, $form_state->getValue('ubc_saml_auth10_settings_ind'.$i));

      $config->set('ubc_saml_auth10.ubc_saml_auth10_settings'.$i, $form_state->getValue('ubc_saml_auth10_settings'.$i));
    }

    $config->save();
    return parent::submitForm($form, $form_state);
  }


}
