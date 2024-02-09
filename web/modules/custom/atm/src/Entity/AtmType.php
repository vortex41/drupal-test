<?php declare(strict_types = 1);

namespace Drupal\atm\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Atm type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "atm_type",
 *   label = @Translation("Atm type"),
 *   label_collection = @Translation("Atm types"),
 *   label_singular = @Translation("atm type"),
 *   label_plural = @Translation("atms types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count atms type",
 *     plural = "@count atms types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\atm\Form\AtmTypeForm",
 *       "edit" = "Drupal\atm\Form\AtmTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\atm\AtmTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer atm types",
 *   bundle_of = "atm",
 *   config_prefix = "atm_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/atm_types/add",
 *     "edit-form" = "/admin/structure/atm_types/manage/{atm_type}",
 *     "delete-form" = "/admin/structure/atm_types/manage/{atm_type}/delete",
 *     "collection" = "/admin/structure/atm_types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   },
 * )
 */
final class AtmType extends ConfigEntityBundleBase {

  /**
   * The machine name of this atm type.
   */
  protected string $id;

  /**
   * The human-readable name of the atm type.
   */
  protected string $label;

}
