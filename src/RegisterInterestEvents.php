<?php

/**
 * @file
 *  Contains Drupal\event_demo\RegisterInterestEvents
 */

namespace Drupal\event_demo;

/**
 * Contains all events relating to registering interest.
 */
final class RegisterInterestEvents {

  /**
   * Name of the event triggered for submitting the register interest form.
   *
   * This event allows you to respond to the submission of the register interest
   * form. Listeners of this event receive a
   * \Drupal\event_demo\RegisterInterestEvent instance.
   *
   * @Event
   *
   * @see \Drupal\event_demo\RegisterInterestEvent
   * @see \Drupal\event_demo\Form\RegisterInterestForm
   *
   * @var string
   */
  const SUBMIT = 'register_interest.submit';

}
