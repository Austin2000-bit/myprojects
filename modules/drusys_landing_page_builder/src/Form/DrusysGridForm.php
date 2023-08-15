<?php

namespace Drupal\drusys_landing_page_builder\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Drusys Cards Form.
 */
class DrusysGridForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $form['#tree'] = TRUE;
    $ds_card_presets = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $ds_card_presets->label(),
      '#description' => $this->t("Label for the Grid."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $ds_card_presets->id(),
      '#machine_name' => [
        'exists' => '\Drupal\drusys_landing_page_builder\Entity\DrusysGrid::load',
      ],
      '#disabled' => !$ds_card_presets->isNew(),
    ];

    $form['tabs'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'edit-layouts',
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
    $css_classes = $ds_card_presets->get('css_classes');

    $form['css_classes']['card_parent'] = [
      '#type' => 'textfield',
      '#title' => $this->t('All cards wrapper class'),
      '#size' => 1024,
      '#default_value' => isset($css_classes['card_parent']) ? $css_classes['card_parent'] : '',
      '#description' => $this->t('Example: text-white text-center home-three-column'),
    ];
    $form['css_classes']['card_common_css'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Common class for all cards'),
      '#size' => 1024,
      '#default_value' => isset($css_classes['card_common_css']) ? $css_classes['card_common_css'] : '',
      '#description' => $this->t('Example: text-white text-center home-three-column'),
    ];
    $num_names = $form_state->get('num_names');
    if ($num_names === NULL) {
      $form_state->set('num_names', 3);
      $num_names = 3;
    }

    $form['css_classes']['card_css_fieldset'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Each cards unique classes'),
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    for ($i = 1; $i <= $num_names; $i++) {
      $form['css_classes']['card_css_fieldset']['card_no'][$i] = [
        '#type' => 'textfield',
        '#title' => 'Card #' . $i,
        '#default_value' => isset($css_classes['card_css_fieldset']['card_no'][$i]) ? $css_classes['card_css_fieldset']['card_no'][$i] : '',
      ];
    }

    $form['css_classes']['card_css_fieldset']['actions'] = [
      '#type' => 'actions',
    ];
    $form['css_classes']['card_css_fieldset']['actions']['add_name'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add one more'),
      '#submit' => ['::addOne'],
      '#ajax' => [
        'callback' => '::addmoreCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
    ];
    // If there is more than one name, add the remove button.
    if ($num_names > 1) {
      $form['css_classes']['card_css_fieldset']['actions']['remove_name'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove one'),
        '#submit' => ['::removeCallback'],
        '#ajax' => [
          'callback' => '::addmoreCallback',
          'wrapper' => 'names-fieldset-wrapper',
        ],
      ];
    }
    // Colors.
    $colors = $ds_card_presets->get('colors');
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
    ];
    $form['colors']['overlay_gradients'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Overlay gradients'),
      '#default_value' => isset($colors['overlay_gradients']) ? $colors['overlay_gradients'] : '',
    ];
    // Css styles.
    $css_styles = $ds_card_presets->get('css_styles');
    $form['css_styles']['card_padding'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Card padding'),
      '#description' => $this->t('Any valid css values. Ex: 30px 0 30px 0 or 30px 0 or 6rem 0'),
      '#default_value' => isset($css_styles['card_padding']) ? $css_styles['card_padding'] : '',
    ];

    $form['css_styles']['card_margin'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Card margin'),
      '#description' => $this->t('Any valid css values. Ex: 30px 0 30px 0 or 30px 0 or 6rem 0'),
      '#default_value' => isset($css_styles['card_margin']) ? $css_styles['card_margin'] : '',
    ];

    // Layouts.
    $styles = \Drupal::entityTypeManager()->getStorage('image_style')->loadMultiple();
    $style_list['none'] = 'None (original size)';
    foreach ($styles as $value) {
      $style_list[$value->getName()] = $value->label();
    }
    $layouts = $ds_card_presets->get('layouts');
    $form['layouts']['image_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Card image size'),
      '#options' => $style_list,
      '#default_value' => isset($layouts['image_style']) ? $layouts['image_style'] : 'none',
    ];
    $form['layouts']['card_orientation'] = [
      '#type' => 'radios',
      '#title' => $this->t('Orientation'),
      '#options' => [
        'verticle' => $this->t('Verticle'),
        'horizontal' => $this->t('Horizontal'),
      ],
      '#default_value' => isset($layouts['card_orientation']) ? $layouts['card_orientation'] : 'verticle',
    ];
    $form['layouts']['slick'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Slick carousel'),
      '#default_value' => isset($layouts['slick']) ? $layouts['slick'] : 0,
      '#description' => $this->t('If enabled, below columns control will not work. Columns are handled through slick JS. Refer https://kenwheeler.github.io/slick'),
    ];
    $horizontal_image_size = [
      '75' => '75% image - 25% text',
      '50' => '50% image - 50% text',
      '33' => '33% image - 66% text',
      '25' => '25% image - 75% text',
    ];
    $form['layouts']['horizontal_image_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Horizontal image %'),
      '#options' => $horizontal_image_size,
      '#default_value' => isset($layouts['horizontal_image_size']) ? $layouts['horizontal_image_size'] : '33',
      '#states' => [
        'visible' => [
          ':input[name="layouts[card_orientation]"]' => ['value' => 'horizontal'],
        ],
      ],
    ];
    $layout_lists = [
      '12' => '1 column',
      '6' => '2 columns',
      '4' => '3 columns',
      '3' => '4 columns',
      '2' => '6 columns',
      '1' => '12 columns',
      'col' => 'Equal width',
    ];
    $form['layouts']['width_992'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 992 (large devices - lg)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_992']) ? $layouts['width_992'] : 'col',
    ];
    $form['layouts']['width_768'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 768 (medium devices - md)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_768']) ? $layouts['width_768'] : 'col',
    ];
    $form['layouts']['width_576'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 576 (small devices - sm)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_576']) ? $layouts['width_576'] : 'col',
    ];
    $form['layouts']['width_0'] = [
      '#type' => 'radios',
      '#title' => $this->t('Columns: Width > 0 (very small devices - col)'),
      '#options' => $layout_lists,
      '#default_value' => isset($layouts['width_0']) ? $layouts['width_0'] : 'col',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $ds_card_presets = $this->entity;
    $status = $ds_card_presets->save();
    \Drupal::service('cache.render')->invalidateAll();
    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Grid.', [
          '%label' => $ds_card_presets->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Grid.', [
          '%label' => $ds_card_presets->label(),
        ]));
    }
    $form_state->setRedirectUrl($ds_card_presets->toUrl('collection'));
  }

  /**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the fieldset with the names in it.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['css_classes']['card_css_fieldset'];
  }

  /**
   * Submit handler for the "add-one-more" button.
   *
   * Increments the max counter and causes a rebuild.
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    $add_button = $name_field + 1;
    $form_state->set('num_names', $add_button);
    $form_state->setRebuild();
  }

  /**
   * Submit handler for the "remove one" button.
   *
   * Decrements the max counter and causes a form rebuild.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    if ($name_field > 1) {
      $remove_button = $name_field - 1;
      $form_state->set('num_names', $remove_button);
    }
    $form_state->setRebuild();
  }

}
