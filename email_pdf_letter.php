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
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function email_pdf_letter_civicrm_xmlMenu(&$files)
{
    _email_pdf_letter_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function email_pdf_letter_civicrm_postInstall()
{
    _email_pdf_letter_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function email_pdf_letter_civicrm_uninstall()
{
    _email_pdf_letter_civix_civicrm_uninstall();
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

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function email_pdf_letter_civicrm_disable()
{
    _email_pdf_letter_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function email_pdf_letter_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL)
{
    return _email_pdf_letter_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function email_pdf_letter_civicrm_managed(&$entities)
{
    _email_pdf_letter_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function email_pdf_letter_civicrm_caseTypes(&$caseTypes)
{
    _email_pdf_letter_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function email_pdf_letter_civicrm_angularModules(&$angularModules)
{
    _email_pdf_letter_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function email_pdf_letter_civicrm_alterSettingsFolders(&$metaDataFolders = NULL)
{
    _email_pdf_letter_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function email_pdf_letter_civicrm_entityTypes(&$entityTypes)
{
    _email_pdf_letter_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function email_pdf_letter_civicrm_themes(&$themes)
{
    _email_pdf_letter_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function email_pdf_letter_civicrm_preProcess($formName, &$form) {

} // */

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
 * @throws \CiviCRM_API3_Exception
 */
function email_pdf_letter_civicrm_alterMailParams(&$params, $context)
{
    (new CRM_EmailPdfLetter_Hook_Hook())->alterMailParams($params, $context);
}
