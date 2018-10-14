<?php

namespace App\EventListener;

use App\Enum\ApiProblemType;
use App\Exception\DeserializationFailedException;
use App\ValueObject\ApiProblem;
use App\ValueObject\ValidationErrorApiProblem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionConverter
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        RequestStack $requestStack,
        SerializerInterface $serializer
    ) {
        $this->requestStack = $requestStack;
        $this->serializer = $serializer;
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();

        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if ($exception instanceof NotFoundHttpException) {
            $this->setApiProblemResponse($event, new ApiProblem(
                Response::HTTP_NOT_FOUND,
                new ApiProblemType(ApiProblemType::NOT_FOUND),
                'Not Found',
                sprintf(
                    'There are no any resources at %s path.',
                    $request->getPathInfo()
                )
            ));

            return;
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            $this->setApiProblemResponse($event, new ApiProblem(
                Response::HTTP_METHOD_NOT_ALLOWED,
                new ApiProblemType(ApiProblemType::METHOD_NOT_ALLOWED),
                'Method Not Allowed',
                sprintf(
                    'HTTP method %s is not supported by resource. '
                    . 'For list of available HTTP methods, send OPTIONS request to %s.',
                    $request->getMethod(),
                    $request->getPathInfo()
                )
            ));

            return;
        }

        if ($exception instanceof NotEncodableValueException) {
            $this->setApiProblemResponse($event, new ApiProblem(
                Response::HTTP_BAD_REQUEST,
                new ApiProblemType(ApiProblemType::INVALID_JSON),
                'Invalid JSON',
                'JSON you have sent has invalid syntax.'
            ));
        }

        if ($exception instanceof DeserializationFailedException) {
            $this->setApiProblemResponse($event, new ValidationErrorApiProblem(
                Response::HTTP_BAD_REQUEST,
                new ApiProblemType(ApiProblemType::VALIDATION_ERROR),
                'Validation Error',
                'There are some invalid fields in your JSON payload. See "violations" field.',
                null,
                $exception->getConstraintViolations()
            ));
        }
    }

    private function setApiProblemResponse(
        GetResponseForExceptionEvent $event,
        ApiProblem $apiProblem
    ): void {
        $apiProblemJson = $this->serializer->serialize($apiProblem, JsonEncoder::FORMAT);

        $event->setResponse(new Response(
            $apiProblemJson,
            $apiProblem->getStatus()
        ));
    }
}
