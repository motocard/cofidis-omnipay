# cofidis-omnipay (Laravel)
Cofidis-Spain gateway for the OmniPay PHP payment processing library.

Laravel-customized to use views on redirect form page:  
Now redirect modal is rendered from blade template (Laravel) and must be stored on resources/views/omnipay/cofidis.blade.php.  
Form action is stored on a $url variable and hidden fields on $fields (use {!! $fields !!} to print the fields html properly)

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay) repository.
