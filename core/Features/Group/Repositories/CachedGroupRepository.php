<?php

namespace Core\Features\Group\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\HttpResponseCode;
use Core\Constants\SuccessMessage;
use Core\Features\Cache\Facades\CustomCache;
use Core\Features\Cache\Traits\CustomCacheTrait;
use Core\Features\Group\Constants\GroupErrorMessage;
use Core\Features\Group\Entities\GroupEntity;
use Core\Features\Group\Facades\Group;
use Core\Features\Group\InterfaceAdapters\CachedGroupRepositoryInterface;
use Core\Features\Group\Models\GetGroupResult;
use Core\Features\Group\Models\GetListGroupsResult;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;

class CachedGroupRepository implements CachedGroupRepositoryInterface
{
    use CustomCacheTrait;

    private const CACHE_GROUP = 'GROUPS';
    private const NAME = 'Group';

    public function getMultiple($pageIndex, $perPage): GetListGroupsResult
    {
        $result = new GetListGroupsResult();
        if (NumberHelper::isPositiveIntegerIncludeZero($pageIndex) === false) {
            $result->message = sprintf(GroupErrorMessage::INVALID_PARAMETER_PAGE_INDEX, 'pageIndex');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        if (NumberHelper::isPositiveInteger($perPage) === false) {
            $result->message = sprintf(GroupErrorMessage::INVALID_PARAMETER_PER_PAGE, 'perPage');
            $result->responseCode = HttpResponseCode::BAD_REQUEST;
            return $result;
        }

        $keyCache = $this->getMultipleKeyCache($pageIndex, $perPage);
        $listIds = CustomCache::get($keyCache);
        if (ArrayHelper::isHasItems($listIds) === false) {
            $getDataResult = Group::getRepo()->getMultiple($pageIndex, $perPage);
            if (false === $getDataResult->success) {
                return $getDataResult;
            }

            $listIds = array_map(
                function ($item) {
                    return $item->id;
                },
                $getDataResult->data,
            );
            CustomCache::set($keyCache, $listIds);
            CustomCache::setMultiple($this->convertListToCacheInput($getDataResult->data));

            return $getDataResult;
        }

        $listItemKeyCaches = array_map(
            function ($id) {
                return $this->getIdKeyCache($id);
            },
            $listIds,
        );
        $data = CustomCache::getMultipleKeepKeys($listItemKeyCaches);
        foreach ($data as $keyCache => $item) {
            if (null !== $item) {
                $newItem = Group::getMapper()->mapFromDbToEntity($item);
                $result->data[] = $newItem;
            } else {
                $id = $this->retrieveIdFromKeyCache($keyCache);
                $newItem = $this->get($id);
                $result->data[] = $newItem->data;
            }
        }

        $result->success = ArrayHelper::isHasItems($result->data);
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_LIST_ITEMS, self::NAME);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, self::NAME);
            $result->responseCode = HttpResponseCode::NOT_FOUND;
        }

        return $result;
    }

    /**
     * @param int|null $pageIndex Page start from 0.
     * @param int|null $perPage Per page.
     */
    private function getMultipleKeyCache($pageIndex, $perPage)
    {
        return $this->getKeyCacheFromList([self::CACHE_GROUP, 'PAGE', $pageIndex, 'PER_PAGE', $perPage]);
    }

    /**
     * @param GroupEntity[]|null $data Data.
     */
    private function convertListToCacheInput($data)
    {
        if (ArrayHelper::isHasItems($data) === false) {
            return array();
        }

        $result = array();
        foreach ($data as $item) {
            $idKeyCache = $this->getIdKeyCache($item->id);
            if (StringHelper::isHasValue($idKeyCache)) {
                $result[ $idKeyCache ] = $item;
            }
        }

        return $result;
    }

    public function get($id): GetGroupResult
    {
        $result = new GetGroupResult();
        if (NumberHelper::isPositiveInteger($id) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'id');
            return $result;
        }

        $keyCache = $this->getIdKeyCache($id);
        $data = CustomCache::get($keyCache);
        if (null !== $data) {
            $result->success = true;
            $result->message = sprintf(SuccessMessage::FOUND_ITEM, self::NAME);
            $result->data = Group::getMapper()->mapFromCacheToEntity($data);
            $result->isFromCache = true;
            return $result;
        }

        $getDataResult = Group::getRepo()->get($id);
        $result = $result->copyWithoutData($getDataResult);
        if ($getDataResult->isHasObjectData()) {
            $result->success = true;
            $result->data = $getDataResult->data;
            $this->setCache($getDataResult->data);
        }

        return $result;
    }

    /**
     * @param int|null $id Id.
     */
    private function getIdKeyCache($id): string
    {
        if (NumberHelper::isPositiveInteger($id) === false) {
            return '';
        }

        return implode(':', [self::CACHE_GROUP, $id]);
    }

    private function retrieveIdFromKeyCache($keyCache)
    {
        if (StringHelper::isHasValue($keyCache) === false) {
            return 0;
        }

        $arr = explode(':', $keyCache);
        if (count($arr) !== 2) {
            return 0;
        }

        return intval($arr[1]);
    }

    /**
     * @param GroupEntity|null $item Item.
     */
    private function setCache($item)
    {
        if (null === $item) {
            return;
        }

        CustomCache::setMultiple($this->convertListToCacheInput(array( $item )));
    }
}
