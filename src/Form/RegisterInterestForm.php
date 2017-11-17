<?php

namespace Drupal\event_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\event_demo\RegisterInterestEvent;
use Drupal\event_demo\RegisterInterestEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class RegisterInterestForm.
 *
 * @package Drupal\event_demo\Form
 */
class RegisterInterestForm extends FormBase {

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
   */
  protected $eventDispatcher;

  const FORM_ID = 'register_interest_form';

  // Field names.
  const FIELD_NAME = 'name';
  const FIELD_EMAIL = 'email_address';
  const ACTION_WRAPPER = 'actions';
  const ACTION_SUBMIT = 'submit';

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $form = new static();
    $form->setEventDispatcher($container->get('event_dispatcher'));
    return $form;
  }

  /**
   * Set the event dispatcher.
   *
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher $eventDispatcher
   *   The event dispatcher.
   */
  public function setEventDispatcher(EventDispatcherInterface $eventDispatcher) {
    $this->eventDispatcher = $eventDispatcher;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return self::FORM_ID;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->addFields($form);
    $this->addActions($form);
    return $form;
  }

  /**
   * Add the fields to the form.
   *
   * @param array $form
   *   Drupal form array.
   */
  protected function addFields(array &$form) {
    $this->addFieldName($form);
    $this->addFieldEmail($form);
  }

  /**
   * Add the name field to the form.
   *
   * @param array $form
   *   Drupal form array.
   */
  protected function addFieldName(array &$form) {
    $form[self::FIELD_NAME] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Enter your name.'),
      '#required' => TRUE,
    );
  }

  /**
   * Add the email field to the form.
   *
   * @param array $form
   *   Drupal form array.
   */
  protected function addFieldEmail(array &$form) {
    $form['email_address'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#description' => $this->t('Enter your email address'),
      '#required' => TRUE,
    );
  }

  /**
   * Add the actions to the form.
   *
   * @param array $form
   *   Drupal form array.
   */
  protected function addActions(array &$form) {
    $form[self::ACTION_WRAPPER] = array('#type' => 'actions');
    $this->addActionSubmit($form);
  }

  /**
   * Add the submit button to the form.
   *
   * @param array $form
   *   Drupal form array.
   */
  protected function addActionSubmit(array &$form) {
    $form[self::ACTION_WRAPPER][self::ACTION_SUBMIT] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue(self::FIELD_NAME);
    $email = $form_state->getValue(self::FIELD_EMAIL);
    $event = new RegisterInterestEvent($name, $email);
    $this->eventDispatcher->dispatch(RegisterInterestEvents::SUBMIT, $event);
  }

}
