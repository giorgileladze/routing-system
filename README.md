# routing-system
## version 1.0

to use routing system:
 1) copy src code in your project (location doesn't metter, ideally in the root folder)
 2) change $searching_root instance in the RoutingService.php file to tell routing system from where to start searching yml files.
 3) register your route.yml in your sub dirs and dysplay each route, needed dynamic param and request method.
    see example:
                *module:*
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
