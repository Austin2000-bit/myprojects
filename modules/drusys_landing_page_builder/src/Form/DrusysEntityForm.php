<?php

namespace Drupal\drusys_landing_page_builder\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Entity Form for ROW.
 */
class DrusysEntityForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $form = parent::form($form, $form_state);
    $ds_row_presets = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Preset label'),
      '#maxlength' => 255,
      '#default_value' => $ds_row_presets->label(),
      '#description' => $this->t("Preset label for the Landing page builder."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $ds_row_presets->id(),
      '#machine_name' => [
        'exists' => '\Drupal\drusys_landing_page_builder\Entity\DrusysEntity::load',
      ],
      '#disabled' => !$ds_row_presets->isNew(),
    ];

    $form['tabs'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'edit-layouts',
      '#attributes' => ['id' => 'box-container'],
    ];

    $form['layouts'] = [
      '#type' => 'details',
      '#title' => $this->t('Layouts'),
      '#open' => TRUE,
      '#tree' => TRUE,
      '#group' => 'tabs',
    ];
    $form['colors'] = [
      '#type' => 'details',
      '#title' => $this->t('Colors'),
      '#tree' => TRUE,
      '#group' => 'tabs',
    ];
    $form['css_styles'] = [
      '#type' => 'details',
      '#title' => $this->t('Css Styles'),
      '#tree' => TRUE,
      '#group' => 'tabs',
    ];
    $form['css_classes'] = [
      '#type' => 'details',
      '#title' => $this->t('Css Classes'),
      '#tree' => TRUE,
      '#group' => 'tabs',
    ];
    // Css classes.
    $css_classes = $ds_row_presets->get('css_classes');
    $form['css_classes']['row'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Row'),
      '#size' => 1024,
      '#default_value' => isset($css_classes['row']) ? $css_classes['row'] : '',
      '#description' => $this->t('Example: text-white animate__animated animate__bounce home-hero-banner'),
    ];
    $form['css_classes']['column_1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Column 1'),
      '#size' => 1024,
      '#default_value' => isset($css_classes['column_1']) ? $css_classes['column_1'] : '',
      '#description' => $this->t('Example: animate__animated animate__bounce text-center'),
    ];
    $form['css_classes']['column_2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Column 2'),
      '#size' => 1024,
      '#default_value' => isset($css_classes['column_2']) ? $css_classes['column_2'] : '',
      '#description' => $this->t('Example: text-white text-center home-hero-banner'),
    ];
    $form['css_classes']['column_3'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Column 3'),
      '#size' => 1024,
      '#default_value' => isset($css_classes['column_3']) ? $css_classes['column_3'] : '',
      '#description' => $this->t('Example: text-white text-center home-hero-banner'),
    ];
    // Colors.
    $colors = $ds_row_presets->get('colors');
    $form['colors']['background_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Background color'),
      '#size' => 60,
      '#default_value' => isset($colors['background_color']) ? $colors['background_color'] : '',
      '#attributes' => ['class' => ['color-picker']],
    ];
    $form['colors']['overlay_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Overlay color'),
      '#size' => 60,
      '#default_value' => isset($colors['overlay_color']) ? $colors['overlay_color'] : '',
      '#attributes' => ['class' => ['color-picker']],
    ];
    $form['colors']['background_gradients'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Background gradients'),
      '#default_value' => isset($colors['background_gradients']) ? $colors['background_gradients'] : '',
      '#description' => $this->t('linear-gradient(160deg, #0093E9 0%, #80D0C7 100%)'),
    ];
    $form['colors']['overlay_gradients'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Overlay gradients'),
      '#default_value' => isset($colors['overlay_gradients']) ? $colors['overlay_gradients'] : '',
      '#description' => $this->t('linear-gradient(90deg, rgba(0,0,0,1) 63%, rgba(255,255,255,0) 100%)'),
    ];
    // Css styles.
    $css_styles = $ds_row_presets->get('css_styles');
    $form['css_styles']['row_padding'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Row padding'),
      '#description' => $this->t('Any valid css values. Ex: 6rem 0 or 30px 0 30px 0 or 30px 0'),
      '#default_value' => isset($css_styles['row_padding']) ? $css_styles['row_padding'] : '',
    ];
    $form['css_styles']['row_margin'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Row margin'),
      '#description' => $this->t('Any valid css values. Ex: 6rem 0 or 30px 0 30px 0 or 30px 0'),
      '#default_value' => isset($css_styles['row_margin']) ? $css_styles['row_margin'] : '',
    ];
    $form['css_styles']['parallax'] = [
      '#type' => 'checkboxes',
      '#options' => [1 => 'Enable'],
      '#title' => $this->t('Parallax background effect'),
      '#default_value' => isset($css_styles['parallax']) ? $css_styles['parallax'] : [0],
    ];

    // Layouts.
    $styles = \Drupal::entityTypeManager()->getStorage('image_style')->loadMultiple();
    $style_list['none'] = 'None (original size)';
    foreach ($styles as $value) {
      $style_list[$value->getName()] = $value->label();
    }
    $layouts = $ds_row_presets->get('layouts');
    $form['layouts']['large_image_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Large image size'),
      '#options' => $style_list,
      '#default_value' => isset($layouts['large_image_style']) ? $layouts['large_image_style'] : 'none',
    ];
    $form['layouts']['small_image_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Small image size'),
      '#options' => $style_list,
      '#default_value' => isset($layouts['small_image_style']) ? $layouts['small_image_style'] : 'none',
    ];
    $small_image_visibility = [
      '992' => 'width (0 to 992 pixels - md)',
      '768' => 'width (0 to 768 pixels - sm)',
      '576' => 'width (0 to 576 pixels - col)',
    ];
    $form['layouts']['small_image_visibility'] = [
      '#type' => 'select',
      '#title' => $this->t('Small image visibility'),
      '#options' => $small_image_visibility,
      '#default_value' => isset($layouts['small_image_visibility']) ? $layouts['small_image_visibility'] : '576',
    ];
    $form['layouts']['full_width'] = [
      '#type' => 'checkboxes',
      '#options' => [1 => 'Full width'],
      '#title' => $this->t('Width (full stretch)'),
      '#default_value' => isset($layouts['full_width']) ? $layouts['full_width'] : [0],
    ];
    $layout_lists = [
      "100" => "100%",
      "75" => "75%",
      "66" => "66%",
      "50" => "50%",
      "33" => "33%",
      "25" => "25%",
      "50_50" => "50% - 50%",
      "33_66" => "33% - 66%",
      "66_33" => "66% - 33%",
      "25_75" => "25% - 75%",
      "75_25" => "75% - 25%",
      "33_33_33" => "33% - 33% - 33%",
      "none" => 'None (I will use custom classes)',
    ];
    $form['layouts']['width_992'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 992 (large devices - lg)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_992']) ? $layouts['width_992'] : '100',
    ];
    $form['layouts']['width_768'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 768 (medium devices - md)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_768']) ? $layouts['width_768'] : '100',
    ];
    $form['layouts']['width_576'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 576 (small devices - sm)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_576']) ? $layouts['width_576'] : '100',
    ];
    $form['layouts']['width_0'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 0 (very small devices - col)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_0']) ? $layouts['width_0'] : '100',
    ];
    $alignment = [
      "none" => "None",
      "top_left" => "Top Left",
      "top_center" => "Top Center",
      "top_right" => "Top Right",
      "middle_left" => "Middle Left",
      "middle_center" => "Middle Center",
      "middle_right" => "Middle Right",
      "bottom_left" => "Bottom Left",
      "bottom_center" => "Bottom Center",
      "bottom_right" => "Bottom Right",
    ];
    $form['layouts']['alignment'] = [
      '#type' => 'radios',
      '#title' => $this->t('Container Alignemnt'),
      '#options' => $alignment,
      '#default_value' => isset($layouts['alignment']) ? $layouts['alignment'] : 'none',
    ];
    return $form;
  }

  /**
   * Function actions.
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    // Get the basic actins from the base class.
    $actions = parent::actions($form, $form_state);

    // Change the submit button text.
    $actions['submit']['#value'] = $this->t('Save');

    // Return the result.
    return $actions;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ds_row_presets = $this->entity;
    $status = $ds_row_presets->save();
    \Drupal::service('cache.render')->invalidateAll();
    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Row presets.', [
          '%label' => $ds_row_presets->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Row presets.', [
          '%label' => $ds_row_presets->label(),
        ]));
    }
    $form_state->setRedirectUrl($ds_row_presets->toUrl('collection'));
  }

}
