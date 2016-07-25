## Setup

### Composer

Pull this package in through Composer. (development version `dev-master`)

```
{
    "require": {
        "jumper423/laravel-columns-search": "~1.0"
    }
}
```

    $ composer update


##Пример

```php
class Post{
    use Search;
    
    protected $searchColumns = ['name'];
}

$posts = Post::search()->get();
```
