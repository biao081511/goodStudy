<?php
/**
 * @file Index.php
 * wap站首页相关
 * @author: dalong.jia
 * @date: 14-4-1
 * @time: 上午9:18
 */
class IndexController extends base_controller_wap {

	public function init(){
		parent::init();
	}
	
    //首页
    public function indexAction() {
        if (!isset($_GET['city'])) {
            $query = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
            $this->redirect('/' . $this->city_short . '/' . $query);
            die;
        }
        $ad = new Index_Util_AdModel();
        $ads = $ad->getAd();

    	$tag = new Index_Util_TagModel();

        //根据城市名称获取tagID
        $tagId = common_city::getTagIdByCity($this->city_name);
        $districts = $tag->getTag(4, $tagId, 'name, url');
    	
		//获取酒店分类
		$navigation = Yaf_Registry::get("city_hotel_class");
		$hotel_type = $navigation[$this->city_short];

        foreach ($hotel_type as $k => $v) {
            $hotel_type[$k]['class'] = $v['url'];
        }
    	$this->_view->assign('districts', $districts);
    	$this->_view->assign('hotel_type', $hotel_type);
        $this->_view->assign('ads', $ads);
    }

}