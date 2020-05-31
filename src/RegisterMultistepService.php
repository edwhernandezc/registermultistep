<?php

namespace Drupal\registermultistep;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\user\Entity\User;

/**
 * Class RegisterMultistepService.
 */
class RegisterMultistepService implements RegisterMultistepInterface
{

  /**
   * Constructs a new RegisterMultistepService object.
   * @param TranslationInterface $string_translation
   */
  public function __construct()
  {
  }

  /**
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function createUser(FormStateInterface $form_state)
  {
    $values = $form_state->getValues();
    $username = $values['step1']['first_name'] . '-' . $values['step1']['last_name'];

    $user = User::create();

    // Mandatory user creation settings
    $user->enforceIsNew();
    $user->setEmail("$username@edwin-site.com");
    $user->setUsername($username); // This username must be unique and accept only a-Z,0-9, - _ @ .

    // Fields
    $user->set('field_first_name', $values['step1']['first_name']);
    $user->set('field_last_name', $values['step1']['last_name']);
    $user->set('field_gender', $values['step1']['gender']);
    $user->set('field_birthday', $values['step1']['birthday']);
    $user->set('field_city', $values['step2']['city']);
    $user->set('field_phone_number', $values['step2']['phone_number']);
    $user->set('field_address', $values['step2']['address']);
    $user->set('status', 1);
    // Save user
    try {
      $user->save();
    } catch (EntityStorageException $e) {
      \Drupal::messenger()->addMessage($e->getMessage());
    }
  }
}
