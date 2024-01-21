# Email PDF Letter (WIP)

In contributions, in the action "Make Thank-you Letters", if you use "Send emails with an attached PDF where possible." as Print and email options, the email only contains the text "Please see attached" and the attached pdf is called "ThankYou.pdf".

This extension allow you to choose another template and write a specific text for the email.  
Additionally, the attachment is named as the email subject.

## Requirements

- PHP v7.4+
- CiviCRM 5.59+

## Installation

Install the extension as usual.

## Known Issues

- view extra fields only if:
  -  `CRM_Core_Config::singleton()->doNotAttachPDFReceipt` is false;
  -  "pdfemail" or "pdfemail_both" are selected;
- put extra fields above the submit buttons. Now this is done by javascript.

## Help
If you have any questions regarding this extension that are not answered in this README or the documentation, please post a question on https://civicrm.stackexchange.com. Alternatively, feel free to contact info@civihost.it.

## Contributing
Contributions to this repository are very welcome. For small changes, feel free to submit a pull request. For larger changes, please create an issue first so we can talk about your ideas.

## Credits
This is mantained by Samuele Masetto from [CiviHOST](https://www.civihost.it) who you can contact for help, support and further development.

## Disclaimer
This is still a work-in-progress extension.

## License
This extension is licensed under [AGPL-3.0](LICENSE.txt).