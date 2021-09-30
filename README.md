
# Libreria PHP para vtiger

## API Reference

```php
    $vtiger = new vtiger('http://example.com/', 'YOUR_VTIGER_USERNAME', 'YOUR_VTIGER_ACCESSKEY');
```

#### Create

```php
$params      = array(
    'assigned_user_id'         => '1',
    'subject'                  => 'Test',
    'quotestage'               => 'Created',
    'productid'                => '14x3',
    'description'              => 'Test Description',
    'hdnTaxType'               => 'group', // group or individual taxes are obtained from the application
    'LineItems'                => array(
        '0' => array(
            'productid'        => '14x3',
            'sequence_no'      => '1',
            'quantity'         => '1.000',
            'listprice'        => '500.00',
            'comment'          => 'sample comment product',
        ),

    ),
);

$result = $vtiger->create($params, 'Quotes');
```

#### Update
```php
$params = array('id' => '12x3654', 'lastname' => 'Test Lead', 'email' => 'test@test.com', 'assigned_user_id' => '19x1');
$result = $vtiger->update($params);
```

#### Retrieve
```php
$result = $vtiger->retrieve('5x3679');
```

#### Revise
```php
$params = array('id' => '12x3653', 'email' => 'test2@test.com', 'assigned_user_id' => '19x1');
$result = $vtiger->revise($params);
```

#### Describe
```php
$result = $vtiger->describe('Contacts');
```
#### Query
```php
$params = ['email' => 'test2@test.com'];
$select = ['mobile'];

$result = $vtiger->query('Contacts', $params, $select);
```

#### ListTypes
```php
$result = $vtiger->listTypes();
```

#### RetrieveRelated
```php
$result = $vtiger->retrieveRelated('12x3653', 'Activities', 'Calendar');
```