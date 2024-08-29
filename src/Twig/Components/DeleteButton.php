<?php

namespace App\Twig\Components;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;

#[AsTwigComponent]
final class DeleteButton
{
    public string $action;
    public FormView $form;
    public string $type = 'danger';
    public string $actionText = '';
    public string $roundedClass = '';
    
    #[PostMount]
    public function getData()
    {
        $formFactory = Forms::createFormFactory();
        
        $this->form = $formFactory->createBuilder()
            ->setAction($this->action)
            ->setMethod('POST')
            ->getForm()
            ->createView();
    }
}
