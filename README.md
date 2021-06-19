# olam-reserved-account
## Reserved Account Creation Package with Monnify

### Steps:
- Add this block to the repositories section of your composer.json file 
```
"repositories": [{
        "type": "vcs",
        "url": "https://github.com/josiaholatunde/olam-reserved-acct"
    }]
```
and this to the requires section of your composer.json file 
```
"require": {
   "teamapt/monnify": "v1.0.1"
}
```
 
- Run the command below to add the package as a dependency to your magento application
```
composer require teamapt/monnify:v1.0.1
``` 
where v1.0.1 is the latest tag of the extension. You can then run the following commands to enable the module(plugin) and update the db schema
```
php bin/magento module:enable Teamapt_Monnify --clear-static-content 
php bin/magento setup:upgrade 
php bin/magento setup:di:compile 
php bin/magento cache:clean
```
- Visit the Admin page of your magento application. On the left side bar, you should see a menu tab with the title `Reserved Account`
- Click on the `Reserved Accounts` tab. This page lists all existing configurations such as your test and production credentials
- Click on `Add Config` button to add a new configuration
- After creating a new config, you should click on the `Set Active` action link on the right side of each row to enable the config hyou intend to use for creating the reserved account.

## Accessing the API
The API URL for creating the reserved account : {yourMagentoBaseUrl}/rest/V1/reserved-account . The API returns the reserved account details if the accountReference
already exists on monnify or creates a new reserved account if it does not exist on Monnify
Here is a sample valid request: 
```
{
	"accountReference": "evans",
	"customerName": "Jacob Evans",
	"customerEmail": "jacobevans@gmail.com",
	"accountName": "Jacob Evans"
	
}
```
Here is a sample valid response
```
[
  {
    "requestSuccessful": true,
    "data": {
      "bankAccountName": "Unique Solutions-Jac",
      "bankAccountNumber": "5000134139",
      "bankName": "Wema bank",
      "bankCode": "035",
      "accountReference": "evansolam",
      "customerName": "Jacob Evans",
      "customerEmail": "jacobevans@gmail.com"
    }
  }
]
```

Here is a sample invalid request:
```
{
	"accountReference": "evansjj"
}
```

Here is a sample invalid response:
```
[
  {
    "requestSuccessful": false,
    "message": "One or more validation error(s) occurred. Message: Customer name field is required. "
  }
]
```


