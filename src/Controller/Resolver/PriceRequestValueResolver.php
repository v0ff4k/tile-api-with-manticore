<?php

declare(strict_types=1);

namespace App\Controller\Resolver;

use App\Dto\PriceRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Резольвер для маппинга Request в PriceRequest DTO.
 *
 * @return iterable<PriceRequest>
 */
final class PriceRequestValueResolver implements ValueResolverInterface
{
    /**
     * @return iterable<PriceRequest>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();

        if (null === $type || PriceRequest::class !== $type) {
            return [];
        }

        $factory    = (string) $request->query->get('factory', '');
        $collection = (string) $request->query->get('collection', '');
        $article    = (string) $request->query->get('article', '');

        // Валидация обязательных параметров
        if ('' === $factory || '' === $collection || '' === $article) {
            throw new BadRequestHttpException('Missing required parameters: factory, collection, article');
        }

        yield new PriceRequest($factory, $collection, $article);
    }
}
