<?php

declare(strict_types=1);

namespace Drupal\atm;

/**
 * Open hours.
 */
class OpenHours {

  /**
   * Constructor.
   *
   * @param string $from
   *   Time from.
   * @param string $to
   *   Time to.
   */
  public function __construct(public readonly string $from, public readonly string $to) {
  }

  /**
   * Is available.
   *
   * @return bool
   *   Usually true, false only when not available on that day at all.
   */
  public function isAvailable(): bool {
    return !($this->from === '00:00' && $this->to === '00:00');
  }

  /**
   * Is available 24h.
   *
   * @return bool
   *   If available for 24 hours on that day.
   */
  public function isAvailable24h(): bool {
    return $this->from === '00:00' && ($this->to === '23:59' || $this->to === '24:00');
  }

}
