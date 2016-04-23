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
        $builder
            ->add('name', 'text')
            ->add('desc', 'textarea')
            ->add('minimalPrice', 'number')
            //->add('startDate', 'date')
            ->add('startDate', 'date', array(
                'input'  => 'string',
                'widget' => 'choice',
            ))
            ->add('endDate', 'date', array(
                'input'  => 'string',
                'widget' => 'choice',
            ))
            ->add('startHour', 'time', array(
                'input'  => 'string',
                'widget' => 'choice',
            ))
            ->add('endHour', 'time', array(
                'input'  => 'string',
                'widget' => 'choice',
            ))
            ->add('type', 'choice', array(
                      'choices' => $this->types))
            ->add('coverImageLink', 'file', array('label' => 'Brochure (PDF file)'));
    }

    public function getName()
    {
        return 'event';
    }
}
