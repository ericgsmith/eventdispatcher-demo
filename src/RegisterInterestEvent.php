<?php

namespace Drupal\event_demo;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event that is dispatched after a name and email bas been collected.
 *
 * @package Drupal\event_demo
 */
class RegisterInterestEvent extends Event {

  /**
   * The name of the submission.
   *
   * @var string
   */
  protected $submittedName;

  /**
   * The phone number of the submission.
   *
   * @var string
   */
  protected $submittedEmail;

  /**
   * Constructor of the event.
   *
   * @param string $submittedName
   *   The name.
   * @param string $submittedEmail
   *   The email.
   */
  function __construct($submittedName, $submittedEmail) {
    $this->setSubmittedName(($submittedName));
    $this->setSubmittedEmail($submittedEmail);
  }


  /**
   * Get the email.
   *
   * @return string
   */
  public function getSubmittedEmail() {
    return $this->submittedEmail;
  }

  /**
   * Set the email.
   *
   * @param string $submittedEmail
   */
  protected function setSubmittedEmail($submittedEmail) {
    $this->submittedEmail = $submittedEmail;
  }

  /**
   * Get the name.
   *
   * @return string
   */
  public function getSubmittedName() {
    return $this->submittedName;
  }

  /**
   * Set the name.
   *
   * @param string $submittedName
   */
  protected function setSubmittedName($submittedName) {
    $this->submittedName = $submittedName;
  }

}
