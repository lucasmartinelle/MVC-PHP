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

**The sixth line** is the name of your template. if you have a template in the path `views/template/auth.php`, you need to write `auth`, if the template is in a sub-directory of the folder "views/template", you need to write the relative path for example : `auth/auth`. If you don't want to use template, you can leave the value `null`.

## Controllers

## Models

## Views

## Utils





