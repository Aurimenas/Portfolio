# How to Use
Upload the entire repo to your server's public folder, in .env file, change the databse name and creditentials to your db's,
Use the .sql file provided to import a database or run the migrations. If you run the migrations you'll have to manually create an administrator account in the db table "Accounts" (will add a seeder later so you dont have to), use any username/password you desire and in you "group" collumn specify "Admin". Running the sql file will automatically generate one administrator account called with usn of:Auris   password of:123456
Visit your site on the browser and use it :) !

# To-Dos
To consider this app fully finished there are few minor details that need to be tweaked/optimised:
- Update the purchase bussiness logic by using store's settings for tax/global sale rate
- Further improve front-end responsive design
- Implement a function on store's front page to allow users to filter products by their category
- Improve user-experience by adding input error notifiers to every form (currently only at registration)
- Switch paypal's sandox mode to live to enable transactions for real(non-sanbox) users
- In store admin panel's 'Stats' section, add a button to switch datasets
# - Retranslate UI to either full english or full lithuanian instead of a mix 
