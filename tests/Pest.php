<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use Spatie\Permission\Models\Permission;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature')
    ->beforeEach(function () {
        Permission::findOrCreate('access admin panel');
        Permission::findOrCreate('view users');
        Permission::findOrCreate('view a user');
        Permission::findOrCreate('create users');
        Permission::findOrCreate('update users');
        Permission::findOrCreate('delete users');
        Permission::findOrCreate('view properties');
        Permission::findOrCreate('view a property');
        Permission::findOrCreate('create properties');
        Permission::findOrCreate('update properties');
        Permission::findOrCreate('delete properties');
        Permission::findOrCreate('restore properties');
        Permission::findOrCreate('force delete properties');
    });

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
