<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ArmMage\ReatailPrice\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Catalog\Model\Product;
use Magento\NewRelicReporting\Model\Apm\Deployments;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
* @codeCoverageIgnore
*/
class InstallData implements InstallDataInterface
{
    /**
     * Eav setup factory
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    private $eavConfig;
    protected $customerSetupFactory;
    private $attributeSetFactory;
    /**
     * Init
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory, \Magento\Eav\Model\Config $eavConfig ,CustomerSetupFactory $customerSetupFactory,
    AttributeSetFactory $attributeSetFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;

    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        if (!$eavSetup->getAttribute(Product::ENTITY, 'am_ref_discount_price')){
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'am_ref_discount_price',
            [
                'group' => 'General',
                'type' => 'decimal',
                'label' => 'Reatail Price',
                'input' => 'price',
                'required' => false,
                'sort_order' => 50,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );
    }


    $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
    $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
    $attributeSetId = $customerEntity->getDefaultAttributeSetId();
    $attributeSet = $this->attributeSetFactory->create();
    $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

    if (!$customerSetup->getAttribute(Customer::ENTITY, 'am_referal_codes')){
        // $customerSetup->removeAttribute(
        //     \Magento\Customer\Model\Customer::ENTITY,
        //     'am_referal_code');
        $customerSetup->addAttribute(Customer::ENTITY, 'am_referal_codes', [
            'type' => 'varchar',
            'label' => 'Referal Codes',
            'input' => 'text',
            'required' => false,
            'visible' => true,
            'user_defined' => true,
            'system' => 0,
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'am_referal_codes')
        ->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer','customer_account_create','customer_register_address'],//use below to add into other form ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
        ]);
         
        $attribute->save();
    }
  


    }
}
