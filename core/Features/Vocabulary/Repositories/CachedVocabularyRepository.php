<?php

namespace Core\Features\Vocabulary\Repositories;

use Core\Constants\ErrorMessage;
use Core\Constants\SuccessMessage;
use Core\Features\Cache\Facades\CustomCache;
use Core\Features\Vocabulary\Constants\VocabularyConstants;
use Core\Features\Vocabulary\Entities\VocabularyEntity;
use Core\Features\Vocabulary\Facades\Vocabulary;
use Core\Features\Vocabulary\InterfaceAdapters\CachedVocabularyRepositoryInterface;
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
}
