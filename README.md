# Docs
## 1. Routing
```
Route::get('/{id}/{name}', function (int $id, string $name) {
    //http://127.0.0.1:8000/luffy
    return view('welcome', compact('id', 'name'));
});

Route::get('/', function () {
    $names = ['a', 'b', 'c', 'd', 'e'];
    return view('welcome', compact('names'));
});
```
> ### welcome.blade.php
```
@foreach ($names as $name)
    <h1> {{ $name }} </h1>
@endforeach
```
* ## Route Groups
### Middleware
```
Route::middleware(['first', 'second'])->group(function(){
    Route::get('/', function(){
        // uses first and second middleware
    });
});
```
### Controller
```
Route::controller(OrderController::class)->group(function(){
    Route::get('/orders/{id}', 'show');
    Route::post('/orders', 'store');
});
```
### Route Prefixes
```
Route::prefix('admin')->group(function(){
    Route::get('/users', function(){
        // matches the admin/users
    });
});
```
### Route Name Prefixes
```
Route::name('admin.')->group(function(){
    Route::get('/users', function(){
        // Route as admin.users
    })->name('users');
});
```
### Model binding
```
Route::get('/users/{user}', function(User $user){
    return $user->email;
});
```
---
## 2. Middlewares
- In Laravel, middleware is a mechanism that allows you to filter HTTP requests entering your application. It's a type of intermediary that processes requests before they reach your application’s routes or controllers, and also handles responses before they're sent to the browser.
- Middleware can be used for various purposes, such as:

1. Authentication: Ensuring the user is logged in before accessing certain routes.
2. Authorization: Checking if the authenticated user has the proper permissions to access a specific route.
3. Logging: Capturing certain details about incoming requests for debugging or monitoring.
4. Rate limiting: Limiting the number of requests a user can make in a specific time period.

`php artisan make:middleware EnsureTokenIsValid`

> App/Http/Middleware/EnsureTokenIsValid.php
```
if ($request->input('token') !== 'my-secret-token') {
    return redirect('/home');
}

return $next($request);
```
## - Registering Middleware
### i. Global Middleware
`bootstrap/app.php`
```
use App\Http\Middleware\EnsureTokenIsValid;
 
->withMiddleware(function (Middleware $middleware) {
     $middleware->append(EnsureTokenIsValid::class);
})
```
### ii. Assigning Middleware to Routes
> web.php
```
use App\Http\Middleware\EnsureTokenIsValid;
 
Route::get('/profile', function () {
    // ...
})->middleware(EnsureTokenIsValid::class);

Route::get('/', function () {
    // ...
})->middleware([First::class, Second::class]);
```
### iii. Excluding Middleware
```
use App\Http\Middleware\EnsureTokenIsValid;
 
Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/', function () {
        // ...
    });
 
    Route::get('/profile', function () {
        // ...
    })->withoutMiddleware([EnsureTokenIsValid::class]);
});

or
 
Route::withoutMiddleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/profile', function () {
        // ...
    });
});
```
## - Middleware Groups
> bootstrap/app.php
```
use App\Http\Middleware\First;
use App\Http\Middleware\Second;
 
->withMiddleware(function (Middleware $middleware) {
    $middleware->appendToGroup('group-name', [
        First::class,
        Second::class,
    ]);
 
    $middleware->prependToGroup('group-name', [
        First::class,
        Second::class,
    ]);
})
```
> web.php
```
Route::get('/', function () {
    // ...
})->middleware('group-name');
 
Route::middleware(['group-name'])->group(function () {
    // ...
});
```
---