<?php declare(strict_types = 1);

namespace Drupal\atm;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of atm type entities.
 *
 * @see \Drupal\atm\Entity\AtmType
 */
final class AtmTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No atm types available. <a href=":link">Add atm type</a>.',
      [':link' => Url::fromRoute('entity.atm_type.add_form')->toString()],
    );

    return $build;
  }

}
