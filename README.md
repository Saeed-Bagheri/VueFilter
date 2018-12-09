# VueFilter
[![Latest Stable Version](https://poser.pugx.org/saeed/vue-filter/v/stable)](https://packagist.org/packages/saeed/vue-filter)
[![Total Downloads](https://poser.pugx.org/saeed/vue-filter/downloads)](https://packagist.org/packages/saeed/vue-filter)
[![License](https://poser.pugx.org/saeed/vue-filter/license)](https://packagist.org/packages/saeed/vue-filter)

## Installation
>VueFilter requires Laravel 5.5 or higher, PHP 7.1.3+ and Vuejs Framework.


You may use Composer to install VueFilter into your Laravel project:

    composer require saeed/vue-filter

### Configuration

After installing the VueFilter , publish components , using the `vendor:publish` Artisan command:

   for  persian language 

    php artisan vendor:publish --tag=VueFilter-Persian


   for  english language 

    php artisan vendor:publish --tag=VueFilter-English







Next, add the `Filter` traits to your model (for example, `App\User` model):

```php
use Illuminate\Notifications\Notifiable;
use Saeed\VueFilter\Filter;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Filter;
}
```
Finally  , set filter option on your model (for example, `App\User` model):

```php
use Illuminate\Notifications\Notifiable;
use Saeed\VueFilter\Filter;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Filter;

  protected $allowedFilters = [
        'name', 'email', 'created_at'
    ];

    protected $orderable = [
        'name', 'email', 'created_at'
    ];
}
```

### Basic Usage
> in `resources/js/components` folder copy `defaulttable.vue` component and paste with new name . for example 'usertable.vue'.
now you must edit `usertable.vue` with new setting (field title , name and type=>string - datetime - counter on script and field name on blade).
<br>
now register component name on app.js and run `npm run dev`
<br>

```
Vue.component('userlist', require('./components/usertable.vue'));
```

web.php
```
Route::get('/user/list', 'userController@list')->name('userList');
```


userController 
```
public function list(){
$users = User::advancedFilter();

if (request()->ajax())
 return response()->json(['collection' => $users]);
  else
 return view('Users.List');
}

```

in blade

```
 <div class="row" id="app">
    <div class="col-12" >
       <div class="card card-default">
            <div class="card-header">
                 user list
             </div>

              <div class="card-body ">

                <usertable getdataurl="{{route('userList')}}"></usertable>

              </div>
        </div>
    </div>
 </div>
```









## License

VueFilter is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
