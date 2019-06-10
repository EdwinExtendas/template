<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

/**
 * Class BaseCommand.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
abstract class BaseCommand extends Command
{
    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param bool                                  $return_json
     *
     * @return array
     */
    public function getFormErrors(FormInterface $form, $return_json = false)
    {
        $errors = [];
        // Global
        foreach ($form->getErrors() as $error)
        {
            $errors[$form->getName()][] = $error->getMessage();
        }
        // Fields
        foreach ($form as $child /* @var Form $child */)
        {
            if (!$child->isValid())
            {
                foreach ($child->getErrors() as $error)
                {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $return_json ? json_encode($errors) : $errors;
    }
}
