<?php
require_once 'email_pdf_letter.civix.php';

use CRM_EmailPdfLetter_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function email_pdf_letter_civicrm_config(&$config)
{
    _email_pdf_letter_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function email_pdf_letter_civicrm_install()
{
    _email_pdf_letter_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function email_pdf_letter_civicrm_enable()
{
    _email_pdf_letter_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *

 // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function email_pdf_letter_civicrm_navigationMenu(&$menu) {
  _email_pdf_letter_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _email_pdf_letter_civix_navigationMenu($menu);
} // */

/**
 * @param $formName
 * @param \CRM_Core_Form $form
 */
function email_pdf_letter_civicrm_buildForm($formName, \CRM_Core_Form &$form)
{
    (new CRM_EmailPdfLetter_Hook_BuildForm($formName, $form))->run();
}

/**
 * Implements hook_civicrm_alterMailParams().
 *
 * @param $params
 * @param $context
 *
 * @throws \CRM_Core_Exception
 * @throws \CRM_Core_Exception
 */
function email_pdf_letter_civicrm_alterMailParams(&$params, $context)
{
    (new CRM_EmailPdfLetter_Hook_Hook())->alterMailParams($params, $context);
}
