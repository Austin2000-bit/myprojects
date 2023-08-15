<?php

namespace Drupal\drusys_landing_page_builder\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Grid entity.
 *
 * @ConfigEntityType(
 *   id = "ds_card_presets",
 *   label = @Translation("Card presets"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\drusys_landing_page_builder\DrusysGridListBuilder",
 *     "form" = {
 *       "add" = "Drupal\drusys_landing_page_builder\Form\DrusysGridForm",
 *       "edit" = "Drupal\drusys_landing_page_builder\Form\DrusysGridForm",
 *       "delete" = "Drupal\drusys_landing_page_builder\Form\DrusysGridDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\drusys_landing_page_builder\DrusysGridHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ds_card",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/ds-lpb/card/{ds_card_presets}",
 *     "add-form" = "/admin/structure/ds-lpb/card/add",
 *     "edit-form" = "/admin/structure/ds-lpb/card/{ds_card_presets}/edit",
 *     "delete-form" = "/admin/structure/ds-lpb/card/{ds_card_presets}/delete",
 *     "collection" = "/admin/structure/ds-lpb/card"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "css_styles",
 *     "css_classes",
 *     "layouts",
 *     "colors",
 *   }
 * )
 */
class DrusysGrid extends ConfigEntityBase implements DrusysGridInterface {

  /**
   * The Row presets ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Row presets label.
   *
   * @var string
   */
  protected $label;

  /**
   * {@inheritdoc}
   *
   * @var string
   */
  protected $layouts;

  /**
   * {@inheritdoc}
   *
   * @var string
   */
  protected $css_styles;

  /**
   * {@inheritdoc}
   *
   * @var string
   */
  protected $css_classes;

  /**
   * {@inheritdoc}
   *
   * @var string
   */
  protected $colors;

}
