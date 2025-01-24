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
