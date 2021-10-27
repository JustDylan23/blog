<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UserAdmin extends AbstractAdmin
{
    public function __construct(
        string $code,
        string $class,
        string $baseControllerName,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct($code, $class, $baseControllerName);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('username')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('username')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $isEdit = $this->getSubject()->getId() !== null;
        $constraints = [];
        if (!$isEdit) {
            $constraints[] = new NotBlank();
        }

        $form
            ->add('username')
            ->add('roles')
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => !$isEdit,
                'first_options' => ['label' => 'New password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => $constraints
            ])
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => 'Role',
                'choices' => [
                    'Super admin' => 'ROLE_SUPER_ADMIN',
                    'Normal admin' => 'ROLE_ADMIN',
                ],
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('username')
            ->add('roles')
        ;
    }

    protected function preUpdate(object $object): void
    {
        $this->encodePlainPassword($object);
    }

    protected function prePersist(object $object): void
    {
        $this->encodePlainPassword($object);
    }

    private function encodePlainPassword($user): void
    {
        if ($user->plainPassword) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->plainPassword));
        }
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('export');
    }
}
