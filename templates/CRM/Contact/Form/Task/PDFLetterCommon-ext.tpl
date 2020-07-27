{if $form.EMAILtemplate.html}
    <table class="form-layout-compressed">
        <tr>
          <td class="label-left">
            {$form.EMAILtemplate.label}
            {* {help id="template" title=$form.EMAILtemplate.label file="CRM/Contact/Form/Task/PDFLetterCommon.hlp"} *}
          </td>
          <td>
            {$form.EMAILtemplate.html}
          </td>
        </tr>
    </table>
{/if}

<div class="crm-accordion-wrapper crm-html_email-accordion ">
    <div class="crm-accordion-header">
        {$form.html_message2.label}
    </div><!-- /.crm-accordion-header -->
    <div class="crm-accordion-body">
        <div class="helpIcon" id="helphtml">
            <input id="token-selector-2" class="crm-token-selector big" data-field="html_message2" />
            {help id="id-token-html2" tplFile=$tplFile isAdmin=$isAdmin file="CRM/Contact/Form/Task/Email.hlp"}
        </div>
        <div class="clear"></div>
        <div class='html'>
            {$form.html_message2.html}<br />
        </div>

    </div><!-- /.crm-accordion-body -->
</div><!-- /.crm-accordion-wrapper -->

