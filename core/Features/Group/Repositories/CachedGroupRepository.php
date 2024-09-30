<?php

namespace Core\Features\Group\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Cache\Facades\CustomCache;
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
    private const CACHE_GROUP = 'Groups';
    private const NAME = 'Group';

    public function getMultiple($pageIndex, $perPage): GetListGroupsResult
    {
        $result = new GetListGroupsResult();

        return $result;
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
