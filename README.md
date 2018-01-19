
# shop
A simple internet-shop on CodeIgniter


User files in CodeIgniter are stored in the "application" directory.

### "core" directory:
MY_Controller.php - contains a basic controller, from which the other will be inherited. Realises pages generation and work with user data.

### "controllers" directory:
Cart.php - contains a controller for the shop cart and output of the goods list.
Feedback.php - contains a controller for feedback.
News.php - contains a controller for work with company's news.
Pages.php - contains a controller for output of static pages.
Reports.php - contains a controller for generating reports.
User.php - contains a controller for user registration and authorisation.

### "models" directory:
Cart_model.php - contains a model for saving and getting products, orders and user cart data from database.
Feedback_model.php - contains a model for saving and getting feedback messages from database.
News_model.php - contains a model for saving and getting news data from database.
Reports_model.php - contains a model for getting products, orders, employees, clients and stores data from database for creating reports.
User_model.php - contains a model for saving and getting users, their roles and rules data from database.

### "views" directory:
Files in this directory contain various views for the controllers.

### "config" directory:
Files in this directory contain project configuration - site address, database connection attributes etc.


Also, the "assets" directory stores images, css tables, js scripts.

Other files are standart for CodeIgniter framework and are well described in its documentation.
