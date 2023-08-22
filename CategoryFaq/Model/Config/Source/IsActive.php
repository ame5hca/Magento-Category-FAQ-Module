<?php

namespace GiftGroup\CategoryFaq\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => 'Enabled', 'value' => 1],
            ['label' => 'Disabled', 'value' => 0]
        ];
    }
}
