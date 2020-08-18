## Routing

to create your routes, go to the file `app/Routes.php`. In the `initRoutes` function you will find the page relating to error 404. To create a new route, follow this pattern :

```php
$this->create(
    "/<url>",
    "<label>"
    "<title of page>",
    "<controller>",
    "<view>",
    "<template of view>"
);
```

When you go to the URL of your routes, the script will check the existence of the view, the template and the controller. If one of its three elements does not exist, you will be redirected to the "404" page.

**The first line** corresponds to the URL of your page. If your URL includes a variable argument (especially for GET requests), you can use the `{int}` or `{string}` tags. 

* **{int}**: When you go to the desired page, your URL will be checked. If you enter the tag `{int}`, PHP will adapt the argument to the typing "int" explained [here](https://www.php.net/manual/fr/language.types.integer.php#language.types.integer.casting)

* **{string}**: The {string} tag accepts all the characters included in the PHP "string" typing explained [here](https://www.php.net/manual/fr/language.types.string.php#language.types.string.casting).

**The second line** provides the identity of the route.

**The third line** is the title of your page. In the `app/init.php` file you will find a Global variable `TITLE`. The title of your page will be in the form `TITLE | title`.

**The fourth line** is the name of your Controller. if you have a controller in the path `controllers/controllerAuth`, you need to write `controllerAuth`, if the controllers is in a sub-directory of the folder "controllers", you need to write the relative path for example : `auth/controllerAuth`

**The fifth line** is the name of your view. if you have a view in the path `views/viewLogin`, you need to write `viewLogin`, if the view is in a sub-directory of the folder "views", you need to write the relative path for example : `auth/viewLogin`. If you don't want to use views, you can leave the value `null`.

**The sixth line** is the name of your template. if you have a template in the path `views/template/auth.php`, you need to write `auth`, if the template is in a sub-directory of the folder "views/template", you need to write the relative path for example : `auth/auth`. If you don't want to use template, you can leave the value `null`.

## Views

Views are the visible part of your website. In it you place the content of your page.

To create a new view, go to the "views" folder, then create your view (whatever name is suitable). follow this pattern:

```php+HTML
<?php
	// Load routing controller
    require_once("app/Routes.php");
    use app\Routes;
    $routes = new Routes;

    // Some variables
	// css, img, js folder
    $asset = "<links where your assets>/";
    $idPage = "<id of your page>";
	// start a section
    ob_start();
?>

<!-- HTML -->
<!-- redirection to "login" page with label -->
<a href="<?= $routes->url("login"); ?>">Login</a>

<?php 
	// end of section
	$<name of your section> = ob_get_clean(); 
?>
```

**First**, as you can see in this pattern, the sections of your page will be contained between two tags : `ob_start();` which starts a new section and `ob_get_clean()` which records its content in a variable. For example, by writing this :

```php+HTML
<?php
	ob_start();
?>
	<script>alert(1);</script>
<?php
	$script = ob_get_clean();
?>
```

You would then create a `script` section containing `<script>alert(1);</script>`.

**Next**, you can notice the use of the route controller. This would be useful for links as you can see below :

```php+HTML
<a href="<?= $routes->url("login"); ?>">Login</a>
<a href="<?= $routes->urlReplace("profil", array("1"))">profil</a>
```

**The first line** will be a link to the roads with the label `login`

**The second line** is a little more complex. You will notice the use of the urlReplace function. Let's imagine that the `profile` route has the URL `/profil/{int}`.This function will therefore take two parameters, the first is the route to be used and the second is the elements to be replaced in the URL in order.

**Finally**, you can also add variables if necessary that will be available in your template as well. This can be useful to designate a relative path to the assets (css, js, img) or to give a precise ID to a page.

## Templates

Templates are used to display content common to multiple pages. They act as extensions of the views previously seen. The creation of a template is done in the folder `views/template` and are of this form:

```php+HTML
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="<?= $asset //link to asset set in view ?>css/main.css">
        <link rel="stylesheet" href="<?= $asset ?>css/custom.css">
        <link rel="icon" href="<?= $asset ?>img/favicon.png">
        <title><?= $title ?></title>
        <?= $script; // script section set in view ?>>
    </head>
    <body id="<?= $idPage // id set in view ?>">
        <?= $content; // content section set in view ?>>
    </body>
</html>
```

You will notice the use of the `$assets` and `$idPage` variables defined in the views. In addition, you will also see the implementation of the `script` section explained above and `content`.

## Models

Models are used to interact with your database. This folder contains for the moment only one file `Model.php`. That file contain several functions relating to your database. With them, you can do some actions :

**select**:

The first function allows you to retrieve data from a table. It has 5 arguments, one of which is required.

* **The first argument** corresponds to the **table**. This argument is required.
* **The second argument** allows you to choose which **categories** to select. It must be in the form of an array with column names. The array : `array('id', 'username', 'validity')` will then retrieve the columns `id`, `username` and `validity` and and ignore the others. If the argument is equal to `null` or unspecified, All columns will be retrieved.
* **The third argument** is associated with the **"where"** clause, it is also in the form of a pair table. Indeed, the array `array('validity' => 'on')` will search data where `validity` is equal to `on`. If the argument is equal to `null` or unspecified, where clause will be ignore. You cannot specify a value other than `null` if the last argument is specified.
* **The fourth argument** sets a limit in your search. If you indicate `6,15` the query will then return values between `6` and `15` from the table. If the argument is equal to `null` or unspecified, limit clause will be ignore.
* **The fifth argument** allows for a less precise search. For example, if you write ` array('email' => 'test')`, the query will return all records where email contains the word "test".

Example :

```php
$data = select('users', array('id', 'username', 'validity'), array('validity' => 'on'));
while($row = $data->fetch()){
    // action
}
```

**insert**:

The second function is used to insert data. It includes two arguments that are necessary :

* **The first argument** corresponds to the **table**.
* **The second argument** is the values to be inserted. for example, if the table contains `id`, `username`, `email`, the second argument will be `array('id' => '1', 'username' => 'test', 'email' => 'test@test.com')`.

Example:

```php
$response = $this->insert('users', array('id' => '1', 'username' => 'test', 'email' => 'test@test.com'));
```

The response will be equal to `true` if the request was successful and `false` if it was unsuccessful.

**delete**:

The third function delete data. It uses two arguments that are required:

* **The first argument** corresponds to the **table**.
* **The second argument** is associated with the **"where"** clause, it is also in the form of a pair table. Indeed, the array `array('validity' => 'on')` will delete data where `validity` is equal to `on`.

Example:

```php
$response = $this->delete('users', array('validity' => 'on'));
```

The response will be equal to `true` if the request was successful and `false` if it was unsuccessful.

**update**:

The fourth function allows you to update data in a table. It has three arguments, all of which are mandatory

* **The first argument** corresponds to the **table**.
* **The second argument** is an array of pair with the data to be updated and their new values. The array `array('validity' => 'on', 'updated_at' => '2020-01-01 00:00:00')` will update the `validity` column with the value "`on`" and the `updated_at` column with the value "`2020-01-01 00:00:00`".
* **The third argument** is associated with the **"where"** clause, it is also in the form of a pair table. Indeed, the array `array('validity' => 'on')` will update data where `validity` is equal to `on`.

Example:

```php
$response = $this->update('users', array('validity' => 'on', 'updated_at' => '2020-01-01 00:00:00'), array('validity' => 'on'))
```

The response will be equal to `true` if the request was successful and `false` if it was unsuccessful.

**getAll**:

This function is more special. This requires a class specific to the table to be searched. It then allows you to return the values of a table in the form of objects. This function required to argument:

* **The first argument** corresponds to the **table**.
* **The second argument** match to the **file/class** of the table (must be in `models/tables` folder).

If you have a table named "users" with this structure :

| id   | name  | email           |
| ---- | ----- | --------------- |
| 1    | admin | admin@admin.com |

You will need to create a class like this in `models/tables` folder the name of the file should be the same of the class :

```php
<?php
    namespace Model\Tables
    
    class Users {
        private $_id;
        private $_name;
        private $_email;

        public function __construct(array $data){
            $this->hydrate($data);
        }

        public function hydrate(array $data){
            foreach($data as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($this, $method)){
                    $this->$method($value);
                }
            }
        }

        // SETTERS
        private function setId($id){
            $id = (int) $id;

            if($id > 0){
                $this->_id = $id;
            }
        }

        private function setName($name){
            if(is_string($name)){
                $this->_name = $name;
            }
        }

        private function setEmail($email){
            if(is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->_email = $email;
            }
        }

        // GETTERS
        public function id(){
            return $this->_id;
        }

        public function name(){
            return $this->_name;
        }

        public function email(){
            return $this->_email;
        }
    }
?>
```

This file will then be used to retrieve the data from your tables in the form of objects. It consists of `SETTERS` in which you can check your data and `GETTERS` which returns the data recovered by the `SETTERS`. Then, if you want a manager for your users, you can create a file named for example "`usersManager.php`" in `models` folder. Extends this file with the `Model` class like that :

```php
namespace Models;

require_once("models/Model.php");
use Models\Model;

class usersManager extends Model {

}
```

Then, you just have to create a function to retrieve your users as objects :

```php
namespace Models;

require_once("models/Model.php");
use Models\Model;

class usersManager extends Model {
	public function getUsers(){
        return $this->getAll('users', 'Users');
    }
}
```

Finally, you just have to instantiate this class to use this function :

```php
require_once("models/UsersManager.php");
use Models\UsersManager;

private $usersManager;
$usersManager = new UsersManager;
$users = $usersManager->getUsers();
foreach($users as $user){
    echo 'id: ' . $user->id();
    echo 'name: ' . $user->name();
    echo 'email: ' . $user->email();
}
```

## Controllers

Controllers are used for the hidden part of your website. They are used to load pages, process requests, ...

To create a new controller, go to the `controllers` folder, then create your controller (whatever name is suitable but need to be the same as the class) and follow the following pattern:

```php
<?php
    namespace controllers;

	// load modules
    require_once("views/View.php");
    use view\View;

    class <name of your controller> {
        private $_view;
        
        public function __construct($label, $name, $view, $template, $data){
            if($label == "<your label>"){
                $this->page($name, $view, $template);
            }
        }

        private function page($name, $view, $template){
            // action
            
            // view
            $this->_view = new View($view, $template);
            // generate view with data "titre" equal to $name
            $this->_view->generate(array("titre" => $name));
        }
    }
?>
```

The controllers have a more or less complex constructor. The constructor retrieves the information from the desired page. 

* First, it retrieves the label, the identity of the page. Rather than using the URL, we advise you to use the label to load a page. Afterwards, you will be able to modify the URL of your page without any problem if necessary.
* Then, it retrieves the name of the page. You can then pass this variable to your views.
* To continue, the third argument corresponds to the views of the page.
* The fourth argument is the template of your view
* Finally, the last argument is equal to the URL of your page as an array. Let's imagine that you load a page with the URL `/profile/1`. The value of `$data[0]` will equal `"profile"` and `$data[1]` will equal `"1"`. This variable is useful especially for variable URLs such as `/profil/{int}`.

Then, in your controller, to load your views, you must use this syntax:

```php
$this->_view = new View($view, $template);
$this->_view->generate(array("titre" => $name));
```

The first line instantiates your view with the template indicating

The second line generate your view with the variables in the array given. In this example, you give your view a variable named `title` with the value of `$name`

## Utils

### Validator

In the `utils` folder you will already find two file. The first `Validator.php` is a function which allows data validation. To use it, just follow this syntax:

```php
require_once("utils/Validator.php");
use utils\Validator;
private $_validator;

$data = array(
    array('username', $_POST['username'], 'required', 'max:32'),
    array('email', $_POST['email'], 'required', 'min:3', 'max:360', 'email'),
    array('password', $_POST['password'], 'cpassword:'.$_POST['cpassword'], 'required', 'min:6', 'max:32', 'requiredSpecialCharacter', 'requiredNumber', 'requiredLetter')
);
$_validator = new Validator($data);
$response = $this->_validator->validator();
```

you can use multiple parameters in the data like:

* `required` -> Check the presence of data.
* `requiredLetter` -> Check if data contains letters.
* `onlyLetter` -> Check if data contains only letters.
* `noLetter` -> Check if data don't contains letters.
* `requiredSpecialCharacter` -> Check if data contains specials characters.
* `noSpecialCharacter` -> Check if data don't contains specials characters.
* `requiredNumber` -> Check if data contains numbers.
* `onlyNumber` -> Check if data contains only numbers.
* `noNumber` -> Check if data don't contains numbers.
* `min:<int>`  -> Check if the value contains more characters than the specified number.
* `max:<int>`  -> Check if the value contains less characters than the specified number.
* `cpassword` -> Check if the value of the confirm password field is equal to the password field.
* `email` -> Check if the value is a valid email.

after call the `validator` function, you will get an array with that form in the response variable :

```php
["success" => "true/false", "<input>" => "valid/invalid", "message" => array("<input>" => "error")]
```

### captcha

the seconds file in `utils` folder named `Captcha.php` is a little script to verify a captcha. To use it, use that syntax :

```php
require_once("utils/Captcha.php");
use utils\Captcha;
private $_captcha;
    
$_captcha = new Captcha();
$response = $this->_captcha->verifyCaptcha(htmlspecialchars($_POST['g-recaptcha-response'], ENT_QUOTES), PRIVATE_KEY);
```

You need to define your `SITE_KEY` and `PRIVATE_KEY` in `app/init.php` to use it.





