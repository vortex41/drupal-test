<?php declare(strict_types = 1);

namespace Drupal\atm;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the atm entity type.
 *
 * phpcs:disable Drupal.Arrays.Array.LongLineDeclaration
 *
 * @see https://www.drupal.org/project/coder/issues/3185082
 */
final class AtmAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResult {
    return match($operation) {
      'view' => AccessResult::allowedIfHasPermissions($account, ['view atm', 'administer atm types'], 'OR'),
      'update' => AccessResult::allowedIfHasPermissions($account, ['edit atm', 'administer atm types'], 'OR'),
      'delete' => AccessResult::allowedIfHasPermissions($account, ['delete atm', 'administer atm types'], 'OR'),
      default => AccessResult::neutral(),
    };
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL): AccessResult {
    return AccessResult::allowedIfHasPermissions($account, ['create atm', 'administer atm types'], 'OR');
  }

}
