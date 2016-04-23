<?php

namespace GoldenTicket\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use GoldenTicket\DAO\TypeDAO;

class EventType extends AbstractType
{
    private $types;

    public function __construct($types)
    {
        $this->types = $types;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        var_dump($this->types);

        $builder
            ->add('name', 'text')
            ->add('desc', 'textarea')
            ->add('minimalPrice', 'number')
            ->add('startDate', 'date')
            ->add('endDate', 'date')
            ->add('startHour', 'time')
            ->add('endHour', 'time')
            ->add('type', 'choice', array(
                      'choices' => $this->types))
            ->add('coverImageLink', 'file');
    }

    public function getName()
    {
        return 'event';
    }
}
