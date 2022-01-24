<?php

use CRM_EmailPdfLetter_ExtensionUtil as E;
use Civi\Token\TokenProcessor;

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
        if (isset($_POST['html_message2']) && isset($_POST['email_options']) && isset($params['contactId'])) {
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
                    } elseif ($_POST['group_by_separator'] == 'br') {
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

                $contributions = [];
                $contribution = null;

                $html_message = str_replace(
                    $separator,
                    $realSeparator,
                    self::resolveTokens($html_message, $params['contactId'], null, $grouped, $separator, [])
                );

                $params['html'] = $html_message;
            }
        }
    }

    private static function resolveTokens(string $html_message, int $contactID, $contributionID, $grouped, $separator, $contributions): string
    {
        $tokenContext = [
            'smarty' => (defined('CIVICRM_MAIL_SMARTY') && CIVICRM_MAIL_SMARTY),
            'contactId' => $contactID,
            'schema' => ['contributionId'],
        ];
        if ($grouped) {
            // First replace the contribution tokens. These are pretty ... special.
            // if the text looks like `<td>{contribution.currency} {contribution.total_amount}</td>'
            // and there are 2 rows with a currency separator of
            // you wind up with a string like
            // '<td>USD</td><td>USD></td> <td>$50</td><td>$89</td>
            // see https://docs.civicrm.org/user/en/latest/contributions/manual-receipts-and-thank-yous/#grouped-contribution-thank-you-letters
            $tokenProcessor = new TokenProcessor(\Civi::dispatcher(), $tokenContext);
            $contributionTokens = CRM_Utils_Token::getTokens($html_message)['contribution'] ?? [];
            foreach ($contributionTokens as $token) {
                $tokenProcessor->addMessage($token, '{contribution.' . $token . '}', 'text/html');
            }

            foreach ($contributions as $contribution) {
                $tokenProcessor->addRow([
                    'contributionId' => $contribution['id'],
                    'contribution' => $contribution,
                ]);
            }
            $tokenProcessor->evaluate();
            $resolvedTokens = [];
            foreach ($contributionTokens as $token) {
                foreach ($tokenProcessor->getRows() as $row) {
                    $resolvedTokens[$token][$row->context['contributionId']] = $row->render($token);
                }
                $html_message = str_replace('{contribution.' . $token . '}', implode($separator, $resolvedTokens[$token]), $html_message);
            }
        }
        $tokenContext['contributionId'] = $contributionID;
        return CRM_Core_TokenSmarty::render(['html' => $html_message], $tokenContext)['html'];
    }

    private static function getTokenCategories()
    {
        if (!isset(Civi::$statics[__CLASS__]['token_categories'])) {
            $tokens = [];
            CRM_Utils_Hook::tokens($tokens);
            Civi::$statics[__CLASS__]['token_categories'] = array_keys($tokens);
        }
        return Civi::$statics[__CLASS__]['token_categories'];
    }
}
