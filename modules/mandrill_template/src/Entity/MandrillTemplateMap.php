<?php

/**
 * @file
 * Contains \Drupal\mandrill_template\Entity\MandrillTemplateMap.
 */

namespace Drupal\mandrill_template\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\mandrill_template\MandrillTemplateMapInterface;

/**
 * Defines the MandrillTemplateMap entity.
 *
 * @ingroup mandrill_template
 *
 * @ConfigEntityType(
 *   id = "mandrill_template_map",
 *   label = @Translation("Mandrill Template Map"),
 *   fieldable = FALSE,
 *   handlers = {
 *     "list_builder" = "Drupal\mandrill_template\Controller\MandrillTemplateMapListBuilder",
 *     "form" = {
 *       "add" = "Drupal\mandrill_template\Form\MandrillTemplateMapForm",
 *       "edit" = "Drupal\mandrill_template\Form\MandrillTemplateMapForm",
 *       "delete" = "Drupal\mandrill_template\Form\MandrillTemplateMapDeleteForm"
 *     }
 *   },
 *   config_prefix = "mandrill_template_map",
 *   admin_permission = "administer mandrill",
 *   entity_keys = {
 *     "id" = "id"
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/services/mandrill/templates/{mandrill_template_map}",
 *     "delete-form" = "/admin/config/services/mandrill/templates/{mandrill_template_map}/delete"
 *   }
 * )
 */
class MandrillTemplateMap extends ConfigEntityBase implements MandrillTemplateMapInterface {

  /**
   * Unique Mandrill Template Map entity ID.
   *
   * @var int
   */
  public $id;

  /**
   * The human-readable name of the Mandrill Template Map.
   *
   * @var string
   */
  public $label;

  /**
   *
   *
   * @var string
   */
  public $mailsystem_key;

  /**
   *
   *
   * @var string
   */
  public $template_id;

  /**
   *
   *
   * @var string
   */
  public $main_section;

  /**
   *
   *
   * @var string
   */
  public $sections;

  /**
   * {@inheritdoc}
   */
  public function label() {
    return $this->label;
  }

}
