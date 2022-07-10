<?php
declare(strict_types=1);

namespace App\Bot\Dating\Modules\Profile\Form\Type;

use App\Bot\Dating\Modules\Profile\Dto\CreateProfileDto;
use App\Bot\Dating\Modules\Profile\Enum\Couple;
use App\Bot\Dating\Modules\Profile\Enum\Gender;
use App\Bot\Dating\Modules\Profile\Enum\Platform;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class CreateProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotNull(),
                    new Length([
                        'min' => 2,
                        'max' => 25,
                    ]),
                    new Regex('/^[A-Za-z\d_\- ]+$/'),
                ],
            ]);
//            ->add('name', TextType::class, [
//                'required' => true,
//                'constraints' => [
//                    new NotNull(),
//                    new Length([
//                        'min' => 2,
//                        'max' => 25,
//                    ]),
//                    new Regex('/^[A-Za-z\d_\- ]+$/'),
//                ],
//            ])
//            ->add('birthdate', DateType::class, [
//                'required' => true,
//                'format' => 'dd-MM-yyyy',
//            ])
//            ->add('countryCode', CountryType::class, [
//                'required' => true,
//                'constraints' => [
//                    new NotNull(),
//                ],
//            ])
//            ->add('city', TextType::class, [
//                'required' => true,
//                'constraints' => [
//                    new NotNull(),
//                    new Length([
//                        'min' => 2,
//                        'max' =>100,
//                    ]),
//                    new Regex('/^[A-Za-z\d_\- ]+$/'),
//                ],
//            ])
//            ->add('gender', ChoiceType::class, [
//                'required' => true,
//                'choices' => Gender::cases(),
//            ])
//            ->add('platform',  ChoiceType::class, [
//                'required' => true,
//                'choices' => Platform::cases(),
//            ])
//            ->add('couple', ChoiceType::class, [
//                'required' => true,
//                'choices' => Couple::cases(),
//            ])
//
//            ->add('description', TextType::class, [
//                'required' => false,
//            ])
//            ->add('tags', CollectionType::class, [
//                'required' => false,
//            ])
//            ->add('media', CollectionType::class, [
//                'required' => false,
//            ])
//            ->add('lang', LanguageType::class, [
//                'required' => false,
//            ])
//            ->add('locale', LocaleType::class, [
//                'required' => false,
//            ])
//            ->add('active', RadioType::class, [
//                'required' => true
//            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => CreateProfileDto::class,
            'allow_extra_fields' => true,
        ]);
    }

}
