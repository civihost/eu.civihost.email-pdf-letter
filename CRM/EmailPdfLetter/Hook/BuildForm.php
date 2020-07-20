<?php
class CRM_EmailPdfLetter_Hook_BuildForm
{

    private $form;
    private $formName;


    /**
     * CRM_EmailPdfLetter_Hook_BuildForm constructor.
     *
     * @param $formName
     * @param \CRM_Core_Form $form
     */
    public function __construct($formName, \CRM_Core_Form &$form)
    {
        $this->form = &$form;
        $this->formName = $formName;
    }

    public function run()
    {
        if (method_exists($this, $this->formName)) {
            $this->{$this->formName}();
        }
    }

    private function CRM_Contribute_Form_Task_PDFLetter()
    {
        /*/
        $email_options = $this->form->getElement('email_options');
        $email_options->addOption(
            ts('Send emails with text different from PDF. Generate printable PDFs for contacts who cannot receive email.'),
            'pdfemail_distinct'
        );
        $email_options->setAttribute('onchange', 'CRM.changeOption');
        */

        $className = CRM_Utils_System::getClassName($this->form);

        $this->form->add(
            'wysiwyg',
            'html_message2',
            strstr($className, 'PDF') ? ts('Document Body 2') : ts('HTML Format'),
            [
                'cols' => '80',
                'rows' => '8',
                'onkeyup' => "return verify(this)",
            ]
        );
        CRM_Core_Region::instance('form-body')->add(array(
            'template' => 'CRM/Contact/Form/Task/PDFLetterCommon-ext.tpl',
            'weight' => 0,
          ));
        //print_r($this->form); exit();

        //$this->form->freeze('html_message2');
        /*
        $this->redoPriceSet();

        $soft_credit_contact_id = CRM_Utils_Request::retrieveValue('soft_contact', 'Integer', 0);

        if (!$soft_credit_contact_id) {
          return;
        }

        $template = $this->form->getTemplate();
        $honoreeProfileFields = $template->get_template_vars('honoreeProfileFields');
        $defaultValues = [];
        CRM_Core_BAO_UFGroup::setProfileDefaults($soft_credit_contact_id, $honoreeProfileFields, $defaultValues);

        foreach ($honoreeProfileFields as $name => $field) {
          // If soft credit type is not chosen then make omit requiredness from honoree profile fields
          if (count($this->form->_submitValues) &&
            empty($this->form->_submitValues['soft_credit_type_id']) &&
            !empty($field['is_required'])
          ) {
            $field['is_required'] = FALSE;
          }
          CRM_Core_BAO_UFGroup::buildProfile($this->form, $field, CRM_Profile_Form::MODE_EDIT, $soft_credit_contact_id, FALSE, FALSE, NULL, 'honor');

          if ($this->form->elementExists('honor[' . $field['name'] . ']') && !empty($defaultValues)) {
            $element = $this->form->getElement('honor[' . $field['name'] . ']');
            $element->setAttribute('readonly');
          }
        }

        $this->form->setDefaults(['soft_credit_type_id' => '1', 'honor' => $defaultValues]);
        */
    }
}
