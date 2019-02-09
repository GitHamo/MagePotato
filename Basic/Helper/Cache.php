<?php
/**
 * Copyright © Magepotato, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepotato\Basic\Helper;

use Magento\Msrp\Model\Product\Attribute\Source\Type;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Cache extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * Construct
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param Filesystem $filesystem
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
    ) {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
    }

    /**
     * Invalidate Cache
     * usage: $this->invalidateCache('block_html', 'layout');
     * @return $this
     */
    public function invalidateCache(...$targetedCacheTypes)
    {
        if ($cacheTypes = $this->_cacheConfig->getTypes()) {
            $cacheTypesList = $targetedCacheTypes ?: array_keys($cacheTypes);
            $this->_cacheTypeList->invalidate($cacheTypesList);
        }
        return $this;
    }



}
