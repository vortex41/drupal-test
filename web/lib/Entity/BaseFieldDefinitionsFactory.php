<?php

declare(strict_types=1);

namespace lib\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\link\LinkItemInterface;

/**
 * Base field definitions factory.
 */
class BaseFieldDefinitionsFactory
{

  /**
   * Build string field definition.
   *
   * @return \Drupal\Core\Field\BaseFieldDefinition
   *   Built definition.
   */
  public static function buildStringFieldDefinition(
    TranslatableMarkup $label = NULL,
    int $maxLength = 255,
    bool $isRevisionable = TRUE,
    bool $isTranslatable = TRUE,
    bool $required = TRUE,
    TranslatableMarkup $description = NULL,
  ): BaseFieldDefinition
  {
    $field = BaseFieldDefinition::create('string')
      ->setRevisionable($isRevisionable)
      ->setTranslatable($isTranslatable)
      ->setLabel($label ?? t('Label'))
      ->setDescription($description)
      ->setSetting('max_length', $maxLength)
      ->setRequired($required)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    if ($description) {
      $field->setDescription($description);
    }

    return $field;
  }

  /**
   * Build text long field definition.
   *
   * @return \Drupal\Core\Field\BaseFieldDefinition
   *   Return BaseFieldDefinition.
   */
  public static function buildTextLongFieldDefinition(
    TranslatableMarkup $label = NULL,
    int $maxLength = 255,
    bool $isRevisionable = TRUE,
    bool $isTranslatable = TRUE,
    bool $isRequired = FALSE,
    TranslatableMarkup $description = NULL
  ): BaseFieldDefinition
  {
    $field = BaseFieldDefinition::create('text_long')
      ->setRevisionable($isRevisionable)
      ->setTranslatable($isTranslatable)
      ->setSetting('max_length', $maxLength)
      ->setLabel($label ?? t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setRequired($isRequired)
      ->setDisplayConfigurable('view', TRUE);

    if ($description) {
      $field->setDescription($description);
    }

    return $field;
  }

  /**
   * Build timestamp field definition.
   *
   * @return \Drupal\Core\Field\BaseFieldDefinition
   *   Built definition.
   */
  public static function buildTimestampFieldDefinition(
    TranslatableMarkup $label,
    TranslatableMarkup $description,
    bool $isRequired = TRUE,
    bool $isRevisionable = TRUE,
    bool $isTranslatable = FALSE,
  ): BaseFieldDefinition
  {
    return BaseFieldDefinition::create('timestamp')
      ->setLabel($label)
      ->setTranslatable($isTranslatable)
      ->setRequired($isRequired)
      ->setRevisionable($isRevisionable)
      ->setDescription($description)
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
  }

  /**
   * Build boolean field definition.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $label
   *   Label.
   * @param bool $defaultValue
   *   Default value.
   * @param bool $isRevisionable
   *   Is revisionable.
   * @param bool $displayLabel
   *   If the label should be displayed instead.
   * @param string $format
   *   Format.
   *
   * @return \Drupal\Core\Field\BaseFieldDefinition
   *   Built definition.
   */
  public static function buildBooleanFieldDefinition(
    TranslatableMarkup $label,
    bool $defaultValue = FALSE,
    bool $isRevisionable = TRUE,
    bool $displayLabel = TRUE,
    string $format = 'yes-no',
    TranslatableMarkup $description = NULL,
    string $onLabel = NULL
  ): BaseFieldDefinition
  {
    $field = BaseFieldDefinition::create('boolean')
      ->setRevisionable($isRevisionable)
      ->setLabel($label)
      ->setDescription($description)
      ->setDefaultValue($defaultValue)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => $displayLabel,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => $format,
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    if ($description) {
      $field->setDescription($description);
    }

    if ($onLabel) {
      $field->setSetting('on_label', $onLabel);
    }

    return $field;
  }

  /**
   * Build boolean field definition.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $label
   *   Label.
   * @param int $scale
   *   Decimal scale - number of digits after comma.
   * @param int $precision
   *   Decimal precision - number of digits to store overall.
   * @param bool $isRevisionable
   *   If field is revisionable.
   * @param bool $required
   *   If field should be required.
   *
   * @return \Drupal\Core\Field\BaseFieldDefinition
   *   Built definition.
   */
  public static function buildDecimalFieldDefinition(
    TranslatableMarkup $label,
    int $scale = 2,
    int $precision = 10,
    bool $isRevisionable = TRUE,
    bool $required = TRUE,
  ): BaseFieldDefinition
  {
    return BaseFieldDefinition::create('decimal')
      ->setLabel($label)
      ->setRequired($required)
      ->setSetting('scale', $scale)
      ->setSetting('precision', $precision)
      ->setRevisionable($isRevisionable)
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'label' => 'above',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE);
  }

  /**
   * Build boolean field definition.
   *
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup $label
   *   Label.
   * @param array $allowedValues
   *   Allowed values.
   * @param string|null $defaultValue
   *   Default value.
   * @param \Drupal\Core\StringTranslation\TranslatableMarkup|null $description
   *   Description.
   * @param int $cardinality
   *   Cardinality.
   * @param bool $isRevisionable
   *   If field is revisionable.
   * @param bool $required
   *   If field should be required.
   *
   * @return \Drupal\Core\Field\BaseFieldDefinition
   *   Built definition.
   */
  public static function buildListStringFieldDefinition(
    TranslatableMarkup $label,
    array $allowedValues,
    string $defaultValue = NULL,
    TranslatableMarkup $description = NULL,
    int $cardinality = 1,
    bool $isRevisionable = TRUE,
    bool $required = TRUE,
  ): BaseFieldDefinition
  {
    return BaseFieldDefinition::create('list_string')
      ->setLabel($label)
      ->setDescription($description)
      ->setRevisionable($isRevisionable)
      ->setSettings([
        'allowed_values' => $allowedValues,
      ])
      ->setCardinality($cardinality)
      ->setDefaultValue($defaultValue)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'list_default',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'options_buttons',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired($required);
  }

  public static function buildColorFiledDefinition(
    TranslatableMarkup $label,
    TranslatableMarkup $description = NULL,
    bool $isRevisionable = TRUE,
    bool $required = TRUE,
    bool $isTranslatable = FALSE,
    bool $opacity = FALSE,
  ): BaseFieldDefinition
  {
    $field = BaseFieldDefinition::create('color_field_type')
      ->setRevisionable($isRevisionable)
      ->setTranslatable($isTranslatable)
      ->setLabel($label)
      ->setDescription($description)
      ->setRequired($required)
      ->setSetting('opacity', $opacity)
      ->setDisplayOptions('form', [
        'type' => 'color_field_widget_html5',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'color_field_formatter_swatch',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    if ($description) {
      $field->setDescription($description);
    }

    return $field;
  }

  public static function buildSimpleImageFieldDefinition(
    TranslatableMarkup $label,
    bool $isRevisionable = TRUE,
    bool $isTranslatable = TRUE,
    bool $isRequired = TRUE,
    TranslatableMarkup $description = NULL,
  ): BaseFieldDefinition
  {
    return BaseFieldDefinition::create('image')
      ->setRevisionable($isRevisionable)
      ->setTranslatable($isTranslatable)
      ->setLabel($label)
      ->setDescription($description)
      ->setRequired($isRequired)
      ->setDisplayOptions('form', [
        'type' => 'image_image',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);
  }

  public static function buildLinkFieldDefinition(
    TranslatableMarkup $label,
    TranslatableMarkup $description = NULL,
    bool $isRevisionable = TRUE,
    bool $isTranslatable = TRUE,
    bool $isRequired = TRUE,
    int $linkType = LinkItemInterface::LINK_EXTERNAL | LinkItemInterface::LINK_INTERNAL | LinkItemInterface::LINK_GENERIC,
  ): BaseFieldDefinition
  {
    return BaseFieldDefinition::create('link')
      ->setLabel($label)
      ->setDescription($description)
      ->setRequired($isRequired)
      ->setSettings([
        'link_type' => $linkType,
        'title' => DRUPAL_DISABLED,
      ])
      ->setDisplayOptions('form', [
        'type' => 'link_default',
        'weight' => 0,
      ])
      ->setRevisionable($isRevisionable)
      ->setTranslatable($isTranslatable)
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);
  }

}
