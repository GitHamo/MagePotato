<?php
/**
 * * Copyright © Magepotato. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepotato\Tools\Helper;

use Magento\Cms\Model\Block as CmsBlock;
use Magento\Cms\Model\Page as CmsPage;

class FileDataManager extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\CollectionFactory
     */
    protected $pageCollectionFactory;

    /**
     * @var \Magento\Cms\Model\BlockFactory
     */
    protected $blockFactory;

    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface
     */
    protected $blockRepository;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Block\CollectionFactory
     */
    protected $blockCollectionFactory;

    /**
     * @var \Magepotato\Tools\Helper\CsvHandler
     */
    protected $csvHelper;

    private $availableModels = [CmsPage::CACHE_TAG => 'page', CmsBlock::CACHE_TAG => 'block'];

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockCollectionFactory,
        \Magepotato\Tools\Helper\CsvHandler $csvHelper
    ) {
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
        $this->blockCollectionFactory = $blockCollectionFactory;
        $this->csvHelper = $csvHelper;
        parent::__construct($context);
    }

    public function import($file = null, string $importType = null)
    {
        if(!$file)
            throw new \Exception("Nothing to import.", 1);
        if(!$importType || in_array($importType, $this->availableModels))
            throw new \Exception("Missing or invalid import type.", 1);
        $total = $processed = 0;
        $records = $this->csvHelper->read($file);
        if(!empty($records)) {
            $total = count($records);
            $factoryName = $this->availableModels[$importType] . "Factory";
            $repositoryName = $this->availableModels[$importType] . "Repository";
            foreach ($records as $data) {
                $entity = $this->$factoryName->create();
                $entity->setData($data);
                $this->$repositoryName->save($entity);
                $processed++;
            }
        }
        return [$total, $processed];
    }

    public function export(string $type, bool $download = false)
    {
        $collectionFactoryName = $this->availableModels[$importType] . "CollectionFactory";
        $collection = $this->$collectionFactoryName->create();
        if($collection->getSize() > 0) {
            $file = $this->exportCollectionDataToCsv($collection);
            if($download) {
                $file->output("$type-" . md5(time()) . '.csv');
            }
            return $file;
        }
    }

    protected function exportCollectionDataToCsv($collection)
    {
        $items = $collection->getItems();
        $header = $contents = [];
        array_walk($items, function($item) use (&$header, &$contents) {
            $itemData = $item->toArray();
            // @todo: find better solution than nested loops. (maybe flatten arrays function)
            array_walk($itemData, function($value, $key) use (&$itemData) {
                // implode arrays to prevent last implode failure
                if(is_array($value))
                    $itemData[$key] = implode(',', $value);
            });
            if(empty($header)) {
                $header = array_keys($itemData);
            }
            $contents[] = array_values($itemData);
        });
        $csv = $this->csvHelper->write($header, $contents);
        return $csv;
    }



}
