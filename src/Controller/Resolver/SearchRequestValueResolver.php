<?php

declare(strict_types=1);

namespace App\Controller\Resolver;

use App\Dto\SearchRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Резольвер для маппинга Request в SearchRequest DTO.
 */
final class SearchRequestValueResolver implements ValueResolverInterface
{
    /**
     * @return iterable<SearchRequest>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();

        if (null === $type || SearchRequest::class !== $type) {
            return [];
        }

        $query = (string) $request->query->get('q', SearchRequest::DEFAULT_QUERY);
        $page  = $request->query->getInt('page', SearchRequest::DEFAULT_PAGE);
        $limit = $request->query->getInt('limit', SearchRequest::DEFAULT_LIMIT);

        // Ограничиваем максимальное значение limit
        $limit = min($limit, SearchRequest::MAX_LIMIT);

        yield new SearchRequest($query, $page, $limit);
    }
}
