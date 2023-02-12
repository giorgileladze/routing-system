# routing-system
## version 1.0

to use routing system:
 - Step One: Copy the source code and place it in your project. It doesn't matter where, but ideally it should be in the root folder.
 - Step Two: Change the $searching_root instance in the RoutingService.php file. This tells the routing system where to start searching for YML files.
 - Step Three: Register your route.yml file in your sub-directories and display each route, along with any needed dynamic parameters and request methods. See the example below:
```yml
                module:
                  base_uri: /user
                  services:
                    create_user:
                      uri: /create
                      method: api\modules\users\src\controllers\UserController::create_user
                      request_method: POST

                    delete_user:
                      uri: /delete/{id}
                      method: api\modules\users\src\controllers\UserController::delete_user
                      request_method: DELETE

                    get_user_info:
                      uri: /get-info/{id}
                      method: api\modules\users\src\controllers\UserController::get_user_info
                      request_method: GET
```

- Step Four: Everything in the curly braces {} of the URI is considered a dynamic part of the URI.
