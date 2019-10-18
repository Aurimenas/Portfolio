# How to Use
Upload the entire repo to your server, in .env file, change the databse name and creditentials to your db's,
Run php artisan commands to generate the db structure (php artisan db:migrate -fresh) and seed it to generate an administrator's account (php artisan db:seed), the created account will have the username "Administrator" and a temporary password "temporary123".
From there the setup is complete, so you can visit your site on the browser and start using it :) !

# To-Dos
To consider this app fully finished there are few minor details that need to be tweaked/optimised:
- Further improve front-end responsive design
- Implement a function on store's front page to allow users to filter products by their category
- Retranslate UI to either full english or full lithuanian instead of a mix 

- In store admin panel's 'Stats' section, add a button to switch datasets(Optional)
