<?php

namespace Drupal\event_demo\EventSubscriber;

use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\event_demo\RegisterInterestEvent;
use Drupal\event_demo\RegisterInterestEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RegistrationMailer.
 *
 * @package Drupal\event_demo
 */
class RegistrationMailer implements EventSubscriberInterface {

  /**
   * Mail manager definition.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $plugin_manager_mail;

  /**
   * Current user proxy.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $current_user;

  /**
   * Constructor.
   */
  public function __construct(MailManagerInterface $plugin_manager_mail, AccountProxyInterface $current_user) {
    $this->plugin_manager_mail = $plugin_manager_mail;
    $this->current_user = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events[RegisterInterestEvents::SUBMIT] = ['onRegisteration', 10];
    return $events;
  }

  /**
   * This method is called whenever the register_interest.submit event is
   * dispatched.
   *
   * @param RegisterInterestEvent $event
   */
  public function onRegisteration(RegisterInterestEvent $event) {
    $module = 'event_demo';
    $key = 'register_interest';
    $to = $event->getSubmittedEmail();
    $params = ['name' => $event->getSubmittedName()];
    $language = $this->current_user->getPreferredLangcode();
    $this->plugin_manager_mail->mail($module, $key, $to, $language, $params);
  }

}
