document.addEventListener("DOMContentLoaded", function (event) {
  var buttons = document.querySelector('.crm-submit-buttons');
  buttons.parentNode.insertBefore(document.querySelector('#EMAILtemplate').closest('table'), buttons);
  buttons.parentNode.insertBefore(document.querySelector('#html_message2').closest('.crm-accordion-wrapper'), buttons);
});

function selectEmailTemplate(val, prefix) {
    var isPDF = true;
    var text_message = "text_message";
    var html_message = (cj("#edit-html-message-value").length > 0) ? "edit-html-message-value" : "html_message2";

    var dataUrl = "{crmURL p='civicrm/ajax / template ' h=0 }";
    var dataUrl = '/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fajax%2Ftemplate';
    cj.post(dataUrl, { tid: val }, function(data) {
        var hide = (data.document_body && isPDF) ? false : true;
        cj('.crm-html_email-accordion, .crm-pdf-format-accordion').toggle(hide);
        cj('.crm-document-accordion').toggle(!hide);

        cj('#document_type').closest('tr').toggle(hide);

        // Unset any uploaded document when any template is chosen
        if (cj('#document.file').length) {
            cj('#document_file').val('');
        }

        if (!hide) {
            cj("#subject").val(data.subject);
            cj("#document-preview").html(data.document_body).parent().css({ 'background': 'white' });
            return;
        }

        if (!isPDF) {
            if (prefix == "SMS") {
                text_message = "sms_text_message";
            }
            if (data.msg_text) {
                cj("#" + text_message).val(data.msg_text);
                cj("div.text").show();
                cj(".head").find('span').removeClass().addClass('ui-icon ui-icon-triangle-1-s');
                cj("#helptext").show();
            } else {
                cj("#" + text_message).val("");
            }
        }

        if (prefix == "SMS") {
            return;
        } else {
            cj("#subject").val(data.subject);
        }

        CRM.wysiwyg.setVal('#' + html_message, data.msg_html || '');

        if (isPDF) {
            var bind = data.pdf_format_id ? true : false;
            selectFormat(data.pdf_format_id, bind);
            if (!bind) {
                document.getElementById("bindFormat").style.display = "none";
            }
        }
    }, 'json');
}