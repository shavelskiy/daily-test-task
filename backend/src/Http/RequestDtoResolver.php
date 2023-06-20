<?php

declare(strict_types=1);

namespace App\Http;

use App\Api\Request\RequestDtoInterface;
use App\Exception\ValidationException;
use Exception;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

    public function __construct(
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (($class = $argument->getType()) === null || !class_exists($class)) {
            return false;
        }

        try {
            $reflection = new ReflectionClass($class);
        } catch (Exception $e) {
            return false;
        }

        return $reflection->implementsInterface(RequestDtoInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (($class = $argument->getType()) === null || !class_exists($class)) {
            return;
        }

        try {
            $reflection = new ReflectionClass($class);
        } catch (Exception $e) {
            return;
        }

        if (!$reflection->implementsInterface(RequestDtoInterface::class)) {
            return;
        }

        /** @var mixed */
        $object = $this->serializer->deserialize($request->getContent(), $class, 'json');

        if (is_object($object)) {
            $this->validateObject($object);
        }

        yield $object;
    }

    private function validateObject(object $object): void
    {
        $errors = $this->validator->validate($object);

        if (count($errors) > 0) {
            throw ValidationException::constraints($errors);
        }
    }
}
