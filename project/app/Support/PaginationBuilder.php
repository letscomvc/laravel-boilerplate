<?php

namespace App\Support;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PaginationBuilder extends QueryBuilder implements Responsable
{
    public const PER_PAGE_DEFAULT = 10;

    private $perPage = self::PER_PAGE_DEFAULT;

    private $resource;

    /**
     * Returns a instance of current class.
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    private function getPerPage()
    {
        $perPage = \Request::input('perPage', $this->perPage);
        if ($perPage > 200 || $perPage < 1) {
            $message = "Per page parameter [{$perPage}] out of the range.";
            throw new UnauthorizedHttpException($message);
        }

        return $perPage;
    }

    /**
     * @return $this
     */
    public function perPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Add query criteria
     *
     * @param  mixed  $criteria
     * @return $this
     */
    public function criteria($criteria): self
    {
        if (is_iterable($criteria)) {
            foreach ($criteria as $criterion) {
                $criterion->apply($this);
            }

            return $this;
        }

        $criteria->apply($this);

        return $this;
    }

    /**
     * @param  \Illuminate\Http\Resources\Json\JsonResource|string  $resource
     * @return $this
     */
    public function resource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function build()
    {
        $paginated = $this->paginate($this->getPerPage())
            ->appends(request()->query());

        return ($this->resource)
            ? $this->resource::collection($paginated)
            : JsonResource::collection($paginated);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return $this->build()
            ->response();
    }
}
