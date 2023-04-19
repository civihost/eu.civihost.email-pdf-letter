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
        CRM_Core_Resources::singleton()->addScriptFile('eu.civihost.email-pdf-letter', 'js/PDFLetterCommon-ext.js');

        $className = CRM_Utils_System::getClassName($this->form);

        $prefix = 'EMAIL';
        $templates[$prefix] = CRM_Core_BAO_MessageTemplate::getMessageTemplates(FALSE);

        $elements = [];
        $elements[] = $this->form->add('select', "{$prefix}template", ts('Use Template for Email'),
          ['' => ts('- select -')] + $templates[$prefix], FALSE,
          ['onChange' => "selectEmailTemplate( this.value, '{$prefix}');"]
        );

        $elements[] = $this->form->add(
            'wysiwyg',
            'html_message2',
            strstr($className, 'PDF') ? ts('Email Body') : ts('HTML Format'),
            [
                'cols' => '80',
                'rows' => '8',
                'onkeyup' => "return verify(this)",
            ]
        );

        // $this->form->addGroup($elements, 'email_pdf_letter', 'Email text');
        // $this->form->insertElementBefore($elements[1], 'html_message'); // TODO: this does not work
        // $this->form->insertElementBefore($elements[0], 'html_message');

        CRM_Core_Region::instance('form-body')->add(array(
            'template' => 'CRM/Contact/Form/Task/PDFLetterCommon-ext.tpl',
            'weight' => 0,
          ));
    }
}
