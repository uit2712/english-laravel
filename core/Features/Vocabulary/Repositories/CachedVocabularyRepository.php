<?php

namespace Core\Features\Vocabulary\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Cache\Facades\CustomCache;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Entities\VocabularyEntity;
use Core\Features\Vocabulary\Facades\Vocabulary;
use Core\Features\Vocabulary\InterfaceAdapters\CachedVocabularyRepositoryInterface;
use Core\Features\Vocabulary\Models\GetListVocabulariesResult;
use Core\Features\Vocabulary\Models\GetVocabularyResult;
use Core\Helpers\ArrayHelper;
use Core\Helpers\NumberHelper;
use Core\Helpers\StringHelper;

class CachedVocabularyRepository implements CachedVocabularyRepositoryInterface
{
    private const CACHE_GROUP = 'VOCABULARY';

    public function get($id): GetVocabularyResult
    {
        $result = new GetVocabularyResult();
        if (NumberHelper::isPositiveInteger($id) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'id');
            return $result;
        }

        $keyCache = $this->getIdKeyCache($id);
        $data = CustomCache::get($keyCache);
        if (null !== $data) {
            $result->success = true;
            $result->message = sprintf(SuccessMessage::FOUND_ITEM, VocabularyConstants::NAME);
            $result->data = Vocabulary::getMapper()->mapFromCacheToEntity($data);
            // $result->data = $data;
            $result->isFromCache = true;
            return $result;
        }

        $getDataResult = Vocabulary::getRepo()->get($id);
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

    /**
     * @param VocabularyEntity|null $item Item.
     */
    private function setCache($item)
    {
        if (null === $item) {
            return;
        }

        CustomCache::setMultiple($this->convertListToCacheInput(array($item)));
    }

    /**
     * @param VocabularyEntity[]|null $data Data.
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
                $result[$idKeyCache] = $item;
            }
        }

        return $result;
    }

    public function getByTopicId($topicId): GetListVocabulariesResult
    {
        $result = new GetListVocabulariesResult();
        if (NumberHelper::isPositiveInteger($topicId) === false) {
            $result->message = sprintf(ErrorMessage::INVALID_PARAMETER, 'topicId');
            return $result;
        }

        $keyCache = $this->getByGroupIdKeyCache($topicId);
        $listIds = CustomCache::get($keyCache);
        if (ArrayHelper::isHasItems($listIds) === false) {
            $getDataResult = Vocabulary::getRepo()->getByTopicId($topicId);
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
                $newItem = Vocabulary::getMapper()->mapFromCacheToEntity($item);
            } else {
                $id = $this->retrieveIdFromKeyCache($keyCache);
                $newItem = $this->get($id)->data;
            }

            if (null !== $newItem) {
                $result->data[] = $newItem;
            }
        }

        $result->success = ArrayHelper::isHasItems($result->data);
        if ($result->success) {
            $result->message = sprintf(SuccessMessage::FOUND_LIST_ITEMS, VocabularyConstants::NAME);
        } else {
            $result->message = sprintf(ErrorMessage::NOT_FOUND_ITEM, VocabularyConstants::NAME);
        }

        return $result;
    }

    /**
     * @param int|null $groupId Group id.
     */
    private function getByGroupIdKeyCache($groupId): string
    {
        return implode(':', [self::CACHE_GROUP, 'TOPIC', $groupId]);
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
}
