# How to Use
Upload the entire repo to your server, in .env file, change the databse name and creditentials to your db's,
Run php artisan commands to generate the db structure (php artisan db:migrate -fresh) and seed it to generate an administrator's account (php artisan db:seed), the created account will have the username "Administrator" and a temporary password "temporary123" (You can change both in the account settings tab).
From there the setup is complete, so you can visit your site on the browser and start using it :) !

# To-Dos
To consider this app fully production ready there are few minor details that need to be tweaked/optimised:
- Further improve front-end responsive design
- Retranslate UI to either full english or full lithuanian instead of a mix 

- In store admin panel's 'Stats' section, add a button to switch datasets(Optional)
- Add pagination to store management function lists(Optional)
