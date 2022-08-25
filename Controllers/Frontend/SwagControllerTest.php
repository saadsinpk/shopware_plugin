<?php
// namespace SwagPluginSystem\Bundle\StoreFrontBundle;

use Shopware\Bundle\SearchBundle\ProductSearchResult;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL\Query\QueryBuilder;
use Shopware\Components\QueryAliasMapper;
use Zend_Mime_Part;
// use Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
// require_once (dirname(__FILE__,6).'/engine/Shopware/Bundle/StoreFrontBundle/Service/ListProductServiceInterface.php');
use Bundle\StoreFrontBundle\Struct;

// class ListProductService implements ListProductServiceInterface
class Shopware_Controllers_Frontend_SwagControllerTest extends Enlight_Controller_Action
{
    // private $originalService;

    // public function __construct(ListProductServiceInterface $service)
    // {
    //     $this->originalService = $service;
    // }

    // public function indexAction(array $numbers, ProductContextInterface $context)
    // {

    //     // Modify product list
        
    //     return $products;
    // }  
    public function indexAction()
    {
        $length_input_filter = '';
        if(isset($_POST['length_input_filter'])) {
            $length_input_filter = $_POST['length_input_filter'];
            $_SESSION['length_input_filter'] = $length_input_filter;
        } elseif(isset($_SESSION['length_input_filter'])) {
            $length_input_filter = $_SESSION['length_input_filter'];
        }
        
        $height_input_filter = '';
        if(isset($_POST['height_input_filter'])) {
            $height_input_filter = $_POST['height_input_filter'];
            $_SESSION['height_input_filter'] = $height_input_filter;
        } elseif(isset($_SESSION['height_input_filter'])) {
            $height_input_filter = $_SESSION['height_input_filter'];
        }
        $width_input_filter = '';
        if(isset($_POST['width_input_filter'])) {
            $width_input_filter = $_POST['width_input_filter'];
            $_SESSION['width_input_filter'] = $width_input_filter;
        } elseif(isset($_SESSION['width_input_filter'])) {
            $width_input_filter = $_SESSION['width_input_filter'];
        }
        if($length_input_filter == '' AND $height_input_filter == '' AND $width_input_filter == '') {
        } else {
            $processor = $this->get('shopware_search.search_term_pre_processor');
	        // $processor = $this->get(\Shopware\Bundle\SearchBundle\SearchTermPreProcessorInterface::class);
	        $term = $processor->process('Test');

	        // if (!$term || \strlen($term) < Shopware()->Config()->get('MinSearchLenght')) {
	        //     return;
	        // }

	        /** @var ShopContextInterface $context */
            $context = $this->get('shopware_storefront.context_service')->getShopContext();
	        // $context = $this->get(\Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface::class)->getShopContext();


	        $queryBuilder_length_option = $this->get('dbal_connection')->createQueryBuilder();
	        $queryBuilder_length_attr = $queryBuilder_length_option->select('optionID')->from('s_filter_options_attributes')->where("sidtechno_filter_length = 1");
	        $queryBuilder_length_attr = $queryBuilder_length_attr->execute()->fetch();

            $max_length_input_filter = $length_input_filter + 50;
            $min_length_input_filter = $length_input_filter - 50;

	        $queryBuilder_length = $this->get('dbal_connection')->createQueryBuilder();
	        $query_max_length = $queryBuilder_length->select('value, id')->from('s_filter_values')->where('optionID = '.$queryBuilder_length_attr['optionID'].' AND value >= '.$min_length_input_filter.' AND value <= '.$max_length_input_filter)->orderBy('id', 'ASC');
	        $query_max_length = $query_max_length->execute()->fetchAll();

	        $queryBuilder_height_option = $this->get('dbal_connection')->createQueryBuilder();
	        $queryBuilder_height_attr = $queryBuilder_height_option->select('optionID')->from('s_filter_options_attributes')->where("sidtechno_filter_height = 1");
	        $queryBuilder_height_attr = $queryBuilder_height_attr->execute()->fetch();


            $max_height_input_filter = $height_input_filter + 50;
            $min_height_input_filter = $height_input_filter - 50;

	        $queryBuilder_height = $this->get('dbal_connection')->createQueryBuilder();
	        $query_max_height = $queryBuilder_height->select('value, id')->from('s_filter_values')->where('optionID = '.$queryBuilder_height_attr['optionID'].' AND value >= '.$min_height_input_filter.' AND value <= '.$max_height_input_filter)->orderBy('id', 'ASC');
	        $query_max_height = $query_max_height->execute()->fetchAll();


	        $queryBuilder_width_option = $this->get('dbal_connection')->createQueryBuilder();
	        $queryBuilder_width_attr = $queryBuilder_width_option->select('optionID')->from('s_filter_options_attributes')->where("sidtechno_filter_width = 1");
	        $queryBuilder_width_attr = $queryBuilder_width_attr->execute()->fetch();

            $max_width_input_filter = $width_input_filter + 50;
            $min_width_input_filter = $width_input_filter - 50;

	        $queryBuilder_width = $this->get('dbal_connection')->createQueryBuilder();
	        $query_max_width = $queryBuilder_width->select('value, id')->from('s_filter_values')->where('optionID = '.$queryBuilder_width_attr['optionID'].' AND value >= '.$min_width_input_filter.' AND value <= '.$max_width_input_filter)->orderBy('id', 'ASC');
	        $query_max_width = $query_max_width->execute()->fetchAll();

            $f_filter = '';
            $f_filter_val = '';
            foreach ($query_max_width as $query_max_width_key => $query_max_width_value) {
                if(!empty($query_max_width_value['id'])) {
                    if($query_max_width_key != 0) {
                        $f_filter .= '|'.$query_max_width_value['id'];
                        $f_filter_val .= '|W-'.$query_max_width_value['value'];
                    } else {
                        $f_filter .= $query_max_width_value['id'];
                        $f_filter_val .= 'W-'.$query_max_width_value['value'];
                    }
                }
            }
            foreach ($query_max_height as $query_max_height_key => $query_max_height_value) {
                if(!empty($query_max_height_value['id'])) {
                    if($query_max_height_key == 0 AND empty($f_filter)) {
                        $f_filter .= $query_max_height_value['id'];
                        $f_filter_val .= 'H-'.$query_max_height_value['value'];
                    } else {
                        $f_filter .= '|'.$query_max_height_value['id'];
                        $f_filter_val .= '|H-'.$query_max_height_value['value'];
                    }
                }
            }
            foreach ($query_max_length as $query_max_length_key => $query_max_length_value) {
                if(!empty($query_max_length_value['id'])) {
                    if($query_max_length_key == 0 AND empty($f_filter)) {
                        $f_filter .= $query_max_length_value['id'];
                        $f_filter_val .= 'L-'.$query_max_length_value['value'];
                    } else {
                        $f_filter .= '|'.$query_max_length_value['id'];
                        $f_filter_val .= '|L-'.$query_max_length_value['value'];
                    }
                }
            }

            // length max-154|
            // width min-150|
            // width max-256|
            // height max-500

	        echo $f_filter;
	        echo "<br>";
	        echo $f_filter_val;
	        // exit();

			$this->Request()->setParam('f', $f_filter);
			$this->Request()->setParam('sFilterProperties', $f_filter);

	        // exit();
            $criteria = Shopware()->Container()->get('shopware_search.store_front_criteria_factory')
                ->createSearchCriteria($this->Request(), $context);

            $result = $this->get('shopware_search.product_search')->search($criteria, $context);
	        // $result = $this->get(\Shopware\Bundle\SearchBundle\ProductSearchInterface::class)->search($criteria, $context);
	        $products = $this->convertProducts($result);
            $pageCounts = $this->get('config')->get('fuzzySearchSelectPerPage');

	        $request = $this->Request()->getParams();
	        $request['sSearchOrginal'] = $term;

	        /** @var \Shopware\Components\QueryAliasMapper $mapper */
            $mapper = $this->get('query_alias_mapper');

            $service = Shopware()->Container()->get('shopware_storefront.custom_sorting_service');

            $sortingIds = $this->container->get('config')->get('searchSortings');
	        $sortingIds = array_filter(explode('|', $sortingIds));
	        $sortings = $service->getList($sortingIds, $context);
	        
	        $this->View()->assign([
	            'term' => $term,
	            'length_input_filter'=>$length_input_filter,
	            'height_input_filter'=>$height_input_filter,
	            'width_input_filter'=>$width_input_filter,
	            'criteria' => $criteria,
	            'facets' => $result->getFacets(),
	            'sPage' => $this->Request()->getParam('sPage', 1),
	            'sSort' => $this->Request()->getParam('sSort', 7),
	            'sTemplate' => $this->Request()->getParam('sTemplate'),
	            'sPerPage' => array_values(explode('|', $pageCounts)),
	            'sRequests' => $request,
	            'shortParameters' => $mapper->getQueryAliases(),
	            'pageSizes' => array_values(explode('|', $pageCounts)),
	            'ajaxCountUrlParams' => [],
	            'sortings' => $sortings,
	            'sSearchResults' => [
	                'sArticles' => $products,
	                'sArticlesCount' => $result->getTotalCount(),
	            ],
                'productBoxLayout' => $this->get('config')->get('searchProductBoxLayout'),
	        ]);
	    }


        // $directHit = $this->get(\Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface::class)->getList('TEST', 'TESTTT');
        // $products = $this->originalService->getList(1, '');

      // print_r($this->getList(array('1'),''));
        /**
         * The template will be automatically be loaded from the module name and the controller name:
         *
         * module => frontend
         * controller => SwagControllerTest becomes swag_controller_test
         * action => index
         *
         * So Shopware will look for a template called frontend/swag_controller_test/index.tpl in your Views folder
         *
         * You can load another template using $this->loadTemplate();
         *
         */
        /** @var QueryBuilder $queryBuilder */
        // $queryBuilder = $this->get('dbal_connection')->createQueryBuilder();

        // $query = $queryBuilder
        //     ->select('*')
        //     ->from('s_articles')
        //     ->orderBy('id', 'DESC');
        // $query = $query->execute()->fetchAll();
        // $totalCount = count($query);

        // $per_page = 2;
        // if(isset($_GET['page'])) {
        //     $cur_page = $_GET['page'];
        // } else {
        //     $cur_page = 1;
        // }

        // $start_from_page = $cur_page - 1;
        // $start_from_first = $start_from_page * $per_page;


        // $total_pages = ceil($totalCount / $per_page);
        // $data['total_pages'] = $total_pages;
        // $data['current_page'] = $cur_page;

        // $query_get = $queryBuilder
        //     ->select('*')
        //     ->from('s_articles')
        //     ->setFirstResult($start_from_first)
        //     ->setMaxResults($per_page)
        //     ->orderBy('id', 'ASC');
        // $query_get = $query_get->execute()->fetchAll();

        // foreach ($query_get as $query_get_key => $query_get_value) {
        //     echo "<pre>";
        //         print_r($query_get_value);
        //     echo "</pre>";
        //     $data['query']['SW1000'.$query_get_value['id']] = Array(
        //           "articleID" => 4,
        //           "articleDetailsID" => 4,
        //           "ordernumber" => SW10003,
        //           "highlight" => '',
        //           "description" => '',
        //           "description_long" => '',
        //           "esd" => '',
        //           "articleName" => 'test3',
        //           "taxID" => 1,
        //           "tax" => 19,
        //           "instock" => 100,
        //           "isAvailable" => 1,
        //           "hasAvailableVariant" => 1,
        //           "weight" => 0,
        //           "shippingtime" => '',
        //           "pricegroupActive" => '',
        //           "pricegroupID" => '',
        //           "length" => 0,
        //           "height" => 0,
        //           "width" => 0,
        //           "laststock" => '',
        //           "additionaltext" => '',
        //           "datum" => '2022 - 07 - 25',
        //           "update" => '2022 - 07 - 26',
        //           "sales" => 0,
        //           "filtergroupID" => '',
        //           "priceStartingFrom" => '',
        //           "pseudopricePercent" => '',
        //           "sVariantArticle" => '',
        //           "sConfigurator" => '',
        //           "metaTitle" => '',
        //           "shippingfree" => '',
        //           "suppliernumber" => '',
        //           "notification" => '',
        //           "ean" => '',
        //           "keywords" => '',
        //           "sReleasedate" => '',
        //           "template" => '',
        //           "allowBuyInListing" => 1,
        //           "supplierName" => 'test',
        //           "supplierImg" => '',
        //           "supplierID" => 1,
        //           "supplierDescription" => '',
        //           "supplierMedia" => '',
        //           "supplier_attributes" => Array(),
        //           "newArticle" => 1,
        //           "sUpcoming" => '',
        //           "topseller" => '',
        //           "valFrom" => 1,
        //           "valTo" => '',
        //           "from" => 1,
        //           "to" => '',
        //           "price" => '300, 00',
        //           "pseudoprice" => 0,
        //           "referenceprice" => 0,
        //           "has_pseudoprice" => '',
        //           "price_numeric" => '300',
        //           "pseudoprice_numeric" => 0,
        //           "price_attributes" => Array(),
        //           "pricegroup" => 'EK',
        //           "regulationPrice" => '',
        //           "minpurchase" => 1,
        //           "maxpurchase" => 100,
        //           "purchasesteps" => 1,
        //           "purchaseunit" => '',
        //           "referenceunit" => '',
        //           "packunit" => '',
        //           "unitID" => '',
        //           "sUnit" => Array(
        //             "unit" => '',
        //             "description" => '',
        //           ),
        //           "unit_attributes" => Array(),
        //           "prices" => Array(Array(
        //               "valFrom" => 1,
        //               "valTo" => '',
        //               "from" => 1,
        //               "to" => '',
        //               "price" => '300, 00',
        //               "pseudoprice" => 0,
        //               "referenceprice" => 0,
        //               "pseudopricePercent" => '',
        //               "has_pseudoprice" => '',
        //               "price_numeric" => 300,
        //               "pseudoprice_numeric" => 0,
        //               "price_attributes" => Array(),
        //               "pricegroup" => EK,
        //               "regulationPrice" => '',
        //               "minpurchase" => 1,
        //               "maxpurchase" => 100,
        //               "purchasesteps" => 1,
        //               "purchaseunit" => '',
        //               "referenceunit" => '',
        //               "packunit" => '',
        //               "unitID" => '',
        //               "sUnit" => Array(
        //                 "unit" => '',
        //                 "description" => '',
        //               ),
        //               "unit_attributes" => Array(),
        //             )
        //           ),
        //           "linkBasket" => 'shopware.php ? sViewport = basket & amp; sAdd = SW10003',
        //           "linkDetails" => 'http : //phpstack-539799-2777207.cloudwaysapps.com/testing-category/4/test3?c=5',
        //           "linkVariant" => 'shopware.php ? sViewport = detail & amp; sArticle = 4 & amp; number = SW10003'
        //         );
        // }
        // $data = array('test' => '', );
        // $this->View()->assign('lists', $data);
    }

    private function convertProducts(ProductSearchResult $result)
    {
        $products = [];
        foreach ($result->getProducts() as $product) {
            $productArray = $this->get('legacy_struct_converter')->convertListProductStruct($product);

            $products[] = $productArray;
        }

        if (empty($products)) {
            return null;
        }

        return $products;
    }
}
