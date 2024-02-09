<?php declare(strict_types=1);

namespace Drupal\atm\Entity;

use lib\Entity\BaseFieldDefinitionsFactory;
use Drupal\atm\AtmInterface;
use Drupal\atm\OpenHours;
use Drupal\atm\WeekDay;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the atm entity class.
 *
 * @ContentEntityType(
 *   id = "atm",
 *   label = @Translation("Atm"),
 *   label_collection = @Translation("Atms"),
 *   label_singular = @Translation("atm"),
 *   label_plural = @Translation("atms"),
 *   label_count = @PluralTranslation(
 *     singular = "@count atms",
 *     plural = "@count atms",
 *   ),
 *   bundle_label = @Translation("Atm type"),
 *   handlers = {
 *     "list_builder" = "Drupal\atm\AtmListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\atm\AtmAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\atm\Form\AtmForm",
 *       "edit" = "Drupal\atm\Form\AtmForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\atm\Routing\AtmHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "atm",
 *   revision_table = "atm_revision",
 *   show_revision_ui = TRUE,
 *   admin_permission = "administer atm types",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "revision_id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log",
 *   },
 *   links = {
 *     "collection" = "/admin/content/atm",
 *     "add-form" = "/admin/content/atm/add/{atm_type}",
 *     "add-page" = "/admin/content/atm/add",
 *     "canonical" = "/admin/content/atm/{atm}",
 *     "edit-form" = "/admin/content/atm/{atm}",
 *     "delete-form" = "/admin/content/atm/{atm}/delete",
 *     "delete-multiple-form" = "/admin/content/atm/delete-multiple",
 *   },
 *   bundle_entity_type = "atm_type",
 *   field_ui_base_route = "entity.atm_type.edit_form",
 * )
 */
final class Atm extends RevisionableContentEntityBase implements AtmInterface
{

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage): void
  {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array
  {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setRevisionable(TRUE)
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setRevisionable(TRUE)
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(self::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['device_type'] = BaseFieldDefinitionsFactory::buildStringFieldDefinition(
      t('ATM device type - deposit/withdraw'),
      isRevisionable: FALSE,
      isTranslatable: FALSE,
    );

    $fields['city'] = BaseFieldDefinitionsFactory::buildStringFieldDefinition(
      t('City'),
      isRevisionable: FALSE,
      isTranslatable: FALSE,
    );

    $fields['address'] = BaseFieldDefinitionsFactory::buildStringFieldDefinition(
      t('Address'),
      isRevisionable: FALSE,
      isTranslatable: FALSE,
    );

    $fields['district'] = BaseFieldDefinitionsFactory::buildStringFieldDefinition(
      t('District'),
      isRevisionable: FALSE,
      isTranslatable: FALSE,
      required: FALSE,
    );

    foreach (WeekDay::cases() as $weekDay) {
      $day = $weekDay->value;
      $fields["open_hours_{$day}_from"] = BaseFieldDefinitionsFactory::buildStringFieldDefinition(
        t('Open hours from for @day', ['@day' => $day]),
        maxLength: 5,
        isRevisionable: FALSE,
        isTranslatable: FALSE,
      );
      $fields["open_hours_{$day}_to"] = BaseFieldDefinitionsFactory::buildStringFieldDefinition(
        t('Open hours to for @day', ['@day' => $day]),
        maxLength: 5,
        isRevisionable: FALSE,
        isTranslatable: FALSE,
      );
    }

    $fields['gps_lat'] = BaseFieldDefinitionsFactory::buildDecimalFieldDefinition(
      t('GPS latitude'),
      scale: 7,
      isRevisionable: FALSE,
    );

    $fields['gps_lon'] = BaseFieldDefinitionsFactory::buildDecimalFieldDefinition(
      t('GPS longitude'),
      scale: 7,
      isRevisionable: FALSE,
    );

    $fields['brand'] = BaseFieldDefinitionsFactory::buildStringFieldDefinition(
      t('Brand'),
      isRevisionable: FALSE,
      isTranslatable: FALSE,
    );

    $fields['fee'] = BaseFieldDefinitionsFactory::buildBooleanFieldDefinition(
      t('If fee will be applied'),
      isRevisionable: FALSE,
    );

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the atm was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the atm was last edited.'));

    return $fields;
  }

  /**
   * {@inheritDoc}
   */
  public function deviceType(): string
  {
    return $this->device_type->value ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function city(): string
  {
    return $this->city->value ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function address(): string
  {
    return $this->address->value ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function district(): string
  {
    return $this->district->value ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function latitude(): string
  {
    return $this->gps_lat->value ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function longitude(): string
  {
    return $this->gps_lon->value ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function brand(): string
  {
    return $this->brand->value ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function isFee(): bool
  {
    return (bool)$this->fee->value;
  }

  /**
   * {@inheritDoc}
   */
  public function getOpenHoursFor(WeekDay $weekDay): OpenHours
  {
    $fieldFrom = "open_hours_{$weekDay->value}_from";
    $fieldTo = "open_hours_{$weekDay->value}_to";

    return new OpenHours(
      $this->$fieldFrom->value,
      $this->$fieldTo->value
    );
  }

}
