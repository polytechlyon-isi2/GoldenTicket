<?php

namespace GoldenTicket\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use GoldenTicket\DAO\TypeDAO;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('desc', 'textarea')
            ->add('minimalPrice', 'number')
            ->add('startDate', 'date')
            ->add('endDate', 'date')
            ->add('startHour', 'time')
            ->add('endHour', 'time')
            ->add('type', 'choice', array(
            'choices' => TypeDAO::findAll()))
            
            /*'type', 'choice', array(
                      'choices'  => array(
                          'Maybe' => null,
                          'Yes' => true,
                          'No' => false,
                      ),
                      // *this line is important*
                      'choices_as_values' => true,
                  ))*/
            ->add('coverImageLink', 'file');

    }

    public function getName()
    {
        return 'event';
    }
}
