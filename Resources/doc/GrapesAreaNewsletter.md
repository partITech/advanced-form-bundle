KeyValueFormBundle
==================

A form type for grapeJS newsletter preset on sonata.



Usage
-----

To add to your form, use the `KeyValueType` type:

```php
use Partitech\AdvancedFormBundle\Form\Type\GrapesAreaNewsletter::class;


$builder->add('parameters', GrapesAreaNewsletter::class, []);


```

Html value is stored in db in json format.
php can access the generated value like this

```php
$data=json_decode($field_value);
echo $data['dataHtml'];

```
