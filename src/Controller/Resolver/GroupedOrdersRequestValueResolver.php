<?php

declare(strict_types=1);

namespace App\Controller\Resolver;

use App\Dto\GroupedOrdersRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Резольвер для маппинга Request в GroupedOrdersRequest DTO.
 */
final class GroupedOrdersRequestValueResolver implements ValueResolverInterface
{
    /**
     * @return iterable<GroupedOrdersRequest>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();

        if (null === $type || GroupedOrdersRequest::class !== $type) {
            return [];
        }

        $groupBy = (string) $request->query->get('group_by', GroupedOrdersRequest::DEFAULT_GROUP_BY);

        // Валидация group_by
        if (!in_array($groupBy, GroupedOrdersRequest::ALLOWED_GROUP_BY, true)) {
            $groupBy = GroupedOrdersRequest::DEFAULT_GROUP_BY;
        }

        $page = max(
            GroupedOrdersRequest::MIN_PAGE,
            $request->query->getInt('page', GroupedOrdersRequest::DEFAULT_PAGE)
        );

        $limit = max(
            GroupedOrdersRequest::MIN_LIMIT,
            min(
                $request->query->getInt('limit', GroupedOrdersRequest::DEFAULT_LIMIT),
                GroupedOrdersRequest::MAX_LIMIT
            )
        );

        yield new GroupedOrdersRequest($groupBy, $page, $limit);
    }
}
