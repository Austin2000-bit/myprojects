<?php

namespace Drupal\drusys_landing_page_builder\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Row presets entity.
 *
 * @ConfigEntityType(
 *   id = "ds_row_presets",
 *   label = @Translation("Row presets"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\drusys_landing_page_builder\DrusysEntityListBuilder",
 *     "form" = {
 *       "add" = "Drupal\drusys_landing_page_builder\Form\DrusysEntityForm",
 *       "edit" = "Drupal\drusys_landing_page_builder\Form\DrusysEntityForm",
 *       "delete" = "Drupal\drusys_landing_page_builder\Form\DrusysEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\drusys_landing_page_builder\DrusysEntityHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "ds_row",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/ds-lpb/row/{ds_row_presets}",
 *     "add-form" = "/admin/structure/ds-lpb/row/add",
 *     "edit-form" = "/admin/structure/ds-lpb/row/{ds_row_presets}/edit",
 *     "delete-form" = "/admin/structure/ds-lpb/row/{ds_row_presets}/delete",
 *     "collection" = "/admin/structure/ds-lpb/row"
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
class DrusysEntity extends ConfigEntityBase implements DrusysEntityInterface {

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
