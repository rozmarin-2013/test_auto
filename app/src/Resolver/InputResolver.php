<?php

namespace App\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InputResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        protected ValidatorInterface  $validator,
        protected SerializerInterface $serializer
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();

        if (!$argumentType || !str_ends_with($argumentType, 'Input')) {
            return [];
        }

        $jsonResponse = $request->getContent();

        if ($jsonResponse === "") {
            $jsonResponse = $this->serializer->serialize(
                [],
                JsonEncoder::FORMAT,
                [AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true]
            );
        }

        try {
            $dto = $this->serializer->deserialize($jsonResponse, $argumentType, 'json', ['disable_type_enforcement' => true]);
            $violations = $this->validator->validate($dto);

            if ($violations->count()) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[$violation->getPropertyPath()] = $violation->getMessage();
                }


                throw new \RuntimeException(json_encode($errors), Response::HTTP_BAD_REQUEST);
            }

            return [$dto];
        } catch (NotNormalizableValueException|NotEncodableValueException $e) {
            throw new \Exception($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $type = $argument->getType();

        if (empty($type)) {
            return false;
        }

        return str_ends_with($type, 'Input');
    }
}