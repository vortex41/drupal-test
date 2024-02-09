<?php declare(strict_types=1);

namespace Drupal\atm;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an atm entity type.
 */
interface AtmInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface
{

  /**
   * Device type.
   *
   * @return string
   *   Return device type.
   */
  public function deviceType(): string;

  /**
   * Get city.
   *
   * @return string
   *   City.
   */
  public function city(): string;

  /**
   * Get address.
   *
   * @return string
   *   Address.
   */
  public function address(): string;

  /**
   * Get district.
   *
   * @return string
   *   District.
   */
  public function district(): string;

  /**
   * Get GPS latitude.
   *
   * @return string
   *   GPS latitude.
   */
  public function latitude(): string;

  /**
   * Get GPS longitude.
   *
   * @return string
   *   GPS longitude.
   */
  public function longitude(): string;

  /**
   * Get ATM brand.
   *
   * @return string
   *   ATM brand.
   */
  public function brand(): string;

  /**
   * Check if fee will be applied for using the ATM.
   *
   * @return bool
   *   True if fee will be applied for using the ATM.
   */
  public function isFee(): bool;

  /**
   * Get open hours for day.
   *
   * @param \Drupal\atm\WeekDay $weekDay
   *   Week day.
   *
   * @return \Drupal\atm\OpenHours
   *   Return open hours.
   */
  public function getOpenHoursFor(WeekDay $weekDay): OpenHours;

}
