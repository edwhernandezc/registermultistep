<?php

namespace Drupal\registermultistep;

use Drupal\Core\Form\FormStateInterface;

/**
 * Interface RegisterMultistepInterface.
 */
interface RegisterMultistepInterface
{
  public function createUser(FormStateInterface $form_state);
}
