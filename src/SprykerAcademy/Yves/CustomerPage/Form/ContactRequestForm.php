<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace SprykerAcademy\Yves\CustomerPage\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactRequestForm extends AbstractType
{
    public const string FIELD_MESSAGE = 'message';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addMessageField($builder);
    }

    protected function addMessageField(FormBuilderInterface $builder): void
    {
        // TODO: Add a text field named FIELD_MESSAGE with label 'Your message' and a NotBlank constraint
        // Hint: $builder->add(static::FIELD_MESSAGE, TextType::class, ['label' => ..., 'constraints' => [new NotBlank()]])
    }
}
