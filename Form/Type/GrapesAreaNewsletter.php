<?php

namespace Partitech\AdvancedFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;


class GrapesAreaNewsletter extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /*dd($options);*/
        $view->vars = array_merge($view->vars, [
            'newsletter_trackingCode'=>isset($options['newsletter_trackingCode']) ? $options['newsletter_trackingCode'] : '',
            'newsletter_subject'=>isset($options['newsletter_subject']) ? $options['newsletter_subject'] : '',
            'newsletter_inline_style'=>isset($options['newsletter_inline_style']) ? $options['newsletter_inline_style'] : '',
            'newsletter_host'=>isset($options['newsletter_host']) ? $options['newsletter_host'] : '',
            'newsletter_images'=>isset($options['newsletter_images']) ? $options['newsletter_images'] : [],
            'newsletter_blocs'=>isset($options['newsletter_blocs']) ? $options['newsletter_blocs'] : [],
        ]);

        //dd($view->vars);
        parent::buildView($view, $form, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'newsletter_trackingCode' => null,
                'newsletter_subject' => null,
                'newsletter_inline_style' => null,
                'newsletter_host' => null,
                'newsletter_images' => [],
                'newsletter_blocs' => [],
            ])
        ;
        $resolver->setAllowedTypes('newsletter_images', 'array');
        $resolver->setAllowedTypes('newsletter_trackingCode', ['string', 'null']);
        $resolver->setAllowedTypes('newsletter_subject', ['string', 'null']);
        $resolver->setAllowedTypes('newsletter_inline_style', ['string', 'null']);
        $resolver->setAllowedTypes('newsletter_host', ['string', 'null']);
        $resolver->setAllowedTypes('newsletter_blocs', ['array', 'null']);
    }

    public function getBlockPrefix()
    {
        return 'partitech_afb_grapesarea_newsletter';
    }

    public function getParent()
    {
        return TextType::class;
    }
}
