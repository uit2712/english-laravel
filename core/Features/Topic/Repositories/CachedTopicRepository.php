<?php

namespace Core\Features\Topic\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Cache\Facades\CustomCache;
use Core\Features\Topic\Entities\TopicEntity;
use Core\Features\Topic\Facades\Topic;
use Core\Features\Topic\InterfaceAdapters\CachedTopicRepositoryInterface;
use Core\Features\Topic\Models\GetTopicResult;
use Core\Features\Topic\Models\GetListTopicsResult;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;

class CachedTopicRepository implements CachedTopicRepositoryInterface
{
    private const CACHE_GROUP = 'Topics';
    private const NAME = 'Topic';

    /**
     * @param TopicEntity[]|null $data Data.
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

    public function get($id): GetTopicResult
    {
        $result = new GetTopicResult();
        if (NumberHelper::isPositiveInteger($id) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'id');
            return $result;
        }

        $keyCache = $this->getIdKeyCache($id);
        $data = CustomCache::get($keyCache);
        if (null !== $data) {
            $result->success = true;
            $result->message = sprintf('Get data from cache success');
            $result->data = Topic::getMapper()->mapFromCacheToEntity($data);
            return $result;
        }

        $getDataResult = Topic::getRepo()->get($id);
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
     * @param TopicEntity|null $item Item.
     */
    private function setCache($item)
    {
        if (null === $item) {
            return;
        }

        CustomCache::setMultiple($this->convertListToCacheInput(array( $item )));
    }

    public function getByGroupId($groupId): GetListTopicsResult
    {
        $result = new GetListTopicsResult();
        if (NumberHelper::isPositiveInteger($groupId) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'groupId');
            return $result;
        }

        $keyCache = $this->getByGroupIdKeyCache($groupId);
        $listIds = CustomCache::get($keyCache);
        if (ArrayHelper::isHasItems($listIds) === false) {
            $getDataResult = Topic::getRepo()->getByGroupId($groupId);
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
                $newItem = Topic::getMapper()->mapFromDbToEntity($item);
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
        }

        return $result;
    }

    /**
     * @param int|null $groupId Group id.
     */
    private function getByGroupIdKeyCache($groupId): string
    {
        return implode(':', [self::CACHE_GROUP, 'GROUP', $groupId]);
    }
}
