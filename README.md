# How to Use
Upload the entire repo to your server, in .env file, change the databse name and creditentials to your db's,
Run php artisan commands to generate the db structure (php artisan migrate:fresh --seed) with the seed that will generate an administrator's account. The created account will have the username "Administrator" and a temporary password "temporary123" (You can change both in the account settings tab). 

To set up your store's paypal payments to go to your account, change the id and secret, provided by paypal, in both transaction creation and execution functions, which are stored in App\paypalcontroller.php
From there the setup is complete, so you can visit your site on the browser and start using it :) !

*PS. If you want to see how stats graph displays sales data, you might want to manually add mock data into your db (the delimeters are columns 'total' and 'created at') since the only other way to generate new sales records is to execute actual paypal payments.*

# To-Dos
To consider this app fully production ready there are few minor details that need to be tweaked/optimised:
- Further improve front-end responsive design
- Retranslate UI to either full english or full lithuanian instead of a mix 

- In store admin panel's 'Stats' section, add a button to switch datasets(Optional)
- Add pagination to store management function lists(Optional)
