<?php

use CRM_EmailPdfLetter_ExtensionUtil as E;

class CRM_EmailPdfLetter_Hook_Hook
{
    /**
     * @param $params
     * @param $context
     *
     * @throws \CRM_Core_Exception
     * @throws \CiviCRM_API3_Exception
     */
    public function alterMailParams(&$params, $context)
    {
        $templateVars = CRM_Core_Smarty::singleton()->get_template_vars();
        //print_r($templateVars['contact']);
        //print_r($templateVars);
        //exit();
        if (isset($_POST['html_message2']) && isset($_POST['email_options']) && isset($templateVars['contact'])) {
            if (stristr($_POST['email_options'], 'pdfemail') && $params['html'] == ts('Please see attached')) {
                $html_message = $_POST['html_message2'];
                $realSeparator = ', ';
                $tableSeparators = [
                  'td' => '</td><td>',
                  'tr' => '</td></tr><tr><td>',
                ];
                $separator = '****~~~~';
                //the original thinking was mutliple options - but we are going with only 2 (comma & td) for now in case
                // there are security (& UI) issues we need to think through
                if (isset($_POST['group_by_separator'])) {
                  if (in_array($_POST['group_by_separator'], ['td', 'tr'])) {
                    $realSeparator = $tableSeparators[$_POST['group_by_separator']];
                  }
                  elseif ($_POST['group_by_separator'] == 'br') {
                    $realSeparator = "<br />";
                  }
                }
                $groupBy = $_POST['group_by'];
                $messageToken = CRM_Utils_Token::getTokens($html_message);
                $grouped = FALSE;
                $groupByID = 0;
                if ($groupBy) {
                  $grouped = TRUE;
                }
                /*
                $result = civicrm_api3('Contribution', 'get', [
                    'sequential' => 1,
                    'id' => ['IN' => [123, 1234]],
                  ]);
                $result = civicrm_api3('Contribution', 'get', [
                    'sequential' => 1,
                    'id' => ['IN' => [30847, 28577]],
                  ]);
                */
                $contributions = [];
                $contribution = null;

                $contact = $templateVars['contact'];

                //$html_message = CRM_Contribute_Form_Task_PDFLetterCommon::generateHtml($contact, $contribution, $groupBy, $contributions, $realSeparator, $tableSeparators, $messageToken, $html_message, $separator, $grouped, $groupByID);
                $html_message = str_replace($separator, $realSeparator, self::resolveTokens($html_message, $contact, $contribution, $messageToken, $grouped, $separator));

                $params['html'] = $html_message;

            }
        }
        /*
    if ($params['valueName'] == 'contribution_invoice_receipt') {
      $templateVars = CRM_Core_Smarty::singleton()->get_template_vars();

      if (!empty($templateVars['payment_processor_type'])
        && $templateVars['payment_processor_type'] != 'PostalPayment')
      {
        return;
      }

      try {
        $messageTemplateId = civicrm_api3('MessageTemplate', 'getvalue', [
          'sequential' => 1,
          'return' => 'id',
          'msg_title' => CRM_Postalpayment_Install_MsgTemplate::MSG_TITLE,
        ]);
      } catch (CiviCRM_API3_Exception $e) {}

      if(empty($messageTemplateId)) {
        return;
      }

      $params['messageTemplateID'] = (int) $messageTemplateId;

      $domain = CRM_Core_BAO_Domain::getDomain();
      $customValue = civicrm_api3('CustomValue', 'get', [
        'entity_id' => $domain->contact_id,
        'format.field_names' => 1,
      ]);
      CRM_Core_Smarty::singleton()->assign('domain_iban', str_split($customValue['values']['iban'][0]));
    }
      */
    }

    private static function resolveTokens($html_message, $contact, $contribution, $messageToken, $grouped, $separator) {
        $categories = self::getTokenCategories();
        $domain = CRM_Core_BAO_Domain::getDomain();
        $tokenHtml = CRM_Utils_Token::replaceDomainTokens($html_message, $domain, true, $messageToken);
        $tokenHtml = CRM_Utils_Token::replaceContactTokens($tokenHtml, $contact, true, $messageToken);
        if ($grouped) {
            $tokenHtml = CRM_Utils_Token::replaceMultipleContributionTokens($separator, $tokenHtml, $contribution, true, $messageToken);
        } else {
            // no change to normal behaviour to avoid risk of breakage
            $tokenHtml = CRM_Utils_Token::replaceContributionTokens($tokenHtml, $contribution, true, $messageToken);
        }
        $tokenHtml = CRM_Utils_Token::replaceHookTokens($tokenHtml, $contact, $categories, true);
        if (defined('CIVICRM_MAIL_SMARTY') && CIVICRM_MAIL_SMARTY) {
            $smarty = CRM_Core_Smarty::singleton();
            // also add the tokens to the template
            $smarty->assign_by_ref('contact', $contact);
            $tokenHtml = $smarty->fetch("string:$tokenHtml");
        }
        return $tokenHtml;
    }

      private static function getTokenCategories() {
        if (!isset(Civi::$statics[__CLASS__]['token_categories'])) {
          $tokens = [];
          CRM_Utils_Hook::tokens($tokens);
          Civi::$statics[__CLASS__]['token_categories'] = array_keys($tokens);
        }
        return Civi::$statics[__CLASS__]['token_categories'];
      }
}
