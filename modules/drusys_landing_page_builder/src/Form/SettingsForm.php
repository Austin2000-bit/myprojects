<?php

namespace Drupal\drusys_landing_page_builder\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class Landing Page buildr Settings Form.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ds_lpb.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ds_lpb.settings');
    $form['libraries'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Libraries'),
      '#options' => [
        'slick' => $this->t('Slick carousel'),
        'wow_animate' => $this->t('Wow & Animate CSS'),
        'bootstrap' => $this->t('Bootstrap (For non-bootstrap theme)'),
      ],
      '#default_value' => $config->get('libraries'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('ds_lpb.settings')
      ->set('libraries', $form_state->getValue('libraries'))
      ->save();
  }

}
