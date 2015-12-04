# PHP configuration writer and reader
Allows to get and set configuration variables stored in ini-like (or java .properties) files

### Installation with composer
`composer require mayoturis/properties-ini`

or 
```javascript
{
    "require": {
        "mayoturis/properties-ini": "1.0"
    }
}
```
### Usage
####Basic Example
```php
$config = Mayoturis\Properties\RepositoryFactory::make('path_to_configuration_file');
$config->get('DB_PASSWORD');
$config->set('DB_STRICT_MODE', true);
```

#### File format
Reader can load these types of lines
```
DB_HOST=localhost           // loads as string 'localhost'
DB_USERNAME="user"          // string 'user'
DB_PASSWORD = 'password'    // string 'password'
DB_STRICT_MODE=true         // boolean true

FLOAT_VALUE=1.1             // float 1.1
INT_VALUE=1                 // int 1
NULL_VALUE=null             // null

# comment                   // won't be load
; comment                   // won't be load
//comment                   // won't be load
```
Comment has to be at the start of the line
#### Example of file loading
```
name="John"
surname=Doe
age=25
salary=12.5
married=false
wife=null
```
Will be load as
```php
[
  "name"    => "John",
  "surname" => "Doe",
  "age"     => 25,
  "salary"  => 12.5
  "married" => false,
  "wife"    => null
]
```

#### Saving configuration
When saving the configuration, file format will be respected. Therefore empty lines and comments will preserved. New values (NOT only changed) will be placed at the end of the file

#### Further examples
###### Get all configuration values
```php
$config = Mayoturis\Properties\RepositoryFactory::make('path_to_configuration_file');
$configurationArray = $config->all();
```

###### Setting value

```
// file .env

name=John
surname="Doe"

# In 2015
age=25
```

```php
// file index.php

$config = Mayoturis\Properties\RepositoryFactory::make(__DIR__ . '/.env');
$config->set('name', 'Johny');
$config->set('age', 35);
```

```
// file .env after

name=Johny
surname="Doe"

# In 2015
age=35
```

###### Save all configuration values
```php
$configArray = [
  "username" => "user",
  "password" => "password"
];

$config = Mayoturis\Properties\RepositoryFactory::make('path_to_configuration_file');
$config->setAll($configArray);
```
Notice: setAll function will override all configuration values. Previous values will be lost.
