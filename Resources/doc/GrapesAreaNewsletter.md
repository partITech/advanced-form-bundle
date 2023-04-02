GrapesAreaNewsletter
==================

A form type for grapeJS newsletter preset on sonata.



Usage
-----

To add to your form, use the `GrapesAreaNewsletter` type:

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


You can add pass some option to the form such as :

newsletter_trackingCode : will add a string in the header of the generated page. Purpose is to add a tracking code to your newsletter.

```php
    ->add('text',\Partitech\AdvancedFormBundle\Form\Type\GrapesAreaNewsletter::class,
            [
                    'newsletter_trackingCode'=>'<script>var tracking_code="placed in the header";</script>',
            ]
```

newsletter_images : will add an array of media that will be availlable to compose the page.

```php
    ->add('text',\Partitech\AdvancedFormBundle\Form\Type\GrapesAreaNewsletter::class,
            [
                    'newsletter_trackingCode'=>'<script>var tracking_code="placed in the header";</script>',
                    'newsletter_images'=>[
                     'https://images.pexels.com/photos/13219568/pexels-photo-13219568.jpeg',
                    [
                        'src'   =>'https://images.pexels.com/photos/14306688/pexels-photo-14306688.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 1'
                    ],
                    [
                        'src'   =>'https://images.pexels.com/photos/12034812/pexels-photo-12034812.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 2'
                    ],
                    [
                        'src'   =>'https://images.pexels.com/photos/9869862/pexels-photo-9869862.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 3'
                    ],
                    [
                        'src'   =>'https://images.pexels.com/photos/14704578/pexels-photo-14704578.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 4'
                    ],
                    [
                        'src'   =>'https://images.pexels.com/photos/14303270/pexels-photo-14303270.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 5'
                    ],
                    [
                        'src'   =>'https://images.pexels.com/photos/10677344/pexels-photo-10677344.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 6'
                    ],
                    [
                        'src'   =>'https://images.pexels.com/photos/5768336/pexels-photo-5768336.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 7'
                    ],
                    [
                        'src'   =>'https://images.pexels.com/photos/8807039/pexels-photo-8807039.jpeg',
                        'height'=>500,
                        'width' => 498,
                        'name' =>'image 8'
                    ],
                ]],
            );
```
newsletter_blocs : will add an array blocs organized by categories to drag'n drop widget of codes.

```php
    ->add('text',\Partitech\AdvancedFormBundle\Form\Type\GrapesAreaNewsletter::class,
            [                
            'newsletter_blocs'=>
            [
                        [
                            'label'     =>'titre block',
                            'category'  => 'Categorie',
                            'content'   => '<span>text</span>',
                            'class'     => 'gjs-fonts gjs-f-text'
                        ],
                        [
                            'label'     =>'titre block 2',
                            'category'  => 'Categorie',
                            'content'   => '<span>text 2</span>',
                            'class'     => 'fa fa-users'
                        ],
                        [
                            'label'     =>'titre block 3',
                            'category'  => 'Categorie 2',
                            'content'   => '<span>text 3</span>',
                            'class'     => 'fa fa-photo'
                        ],
                        [
                            'label'     =>'titre block 4',
                            'category'  => 'Categorie 2',
                            'content'   => '<span>text 4</span>',
                            'class'     => 'fa fa-angle-double-right'
                        ],
                    ]
            ]
            );
```
